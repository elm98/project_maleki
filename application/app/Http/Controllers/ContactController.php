<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Clue;
use App\Models\Contact;
use App\Models\Locate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    /**/
    function list(){
        return view('back-end.contact-list');
    }

    /**/
    function list_dt(Request $request){
        $role=$request->input('role','all');
        $data=Contact::where(function ($q) use($role){
                return in_array($role,[null,'','all','0'])
                    ? 1
                    : $q->where('role',$role);
            })
            ->where(function ($q)use($request){
                $date = $request->input('date1');
                if(!empty($date))
                    return $q->where('created_at','>=',toMiladi($date,'00:01:01'));
                return 1;
            })
            ->where(function ($q)use($request){
                $date = $request->input('date2');
                if(!empty($date))
                    return $q->where('created_at','<=',toMiladi($date,'23:59:59'));
                return 1;
            })
            ->select('contact.*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked',function ($data){return '<label><input type="checkbox" name="foo[]" value="'.hashId($data->id).'" class="dt-row-checkbox"><span></span></label>';});
        $dt->editColumn('nickname',function ($data){
            return imageTitle($data->img,$data->nickname);
        });
		$dt->editColumn('name',function ($data){
            return $data->name.' <span class="font-small blue-text">('.Contact::role($data->role).' )</span>';
        });
        $dt->editColumn('role',function ($data){
            return Contact::role($data->role);
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small">'.vv($data->created_at,'l,j F Y').'</span>';
        });
		$dt->editColumn('address',function ($data){
            return '<span class="font-small" title="'.$data->address.'">'.excerpt($data->address,50,'...').'</span>';
        });
        $dt->addColumn('action', function ($data) {
            return actionTable([
                '<a class="teal-text" href="./contact-edit/'.hashId($data->id).'" >نمایش</a>',
                '<span class="red-text cursor-pointer dt-row-delete" data-action="./contact-delete" >حذف</span>'
            ]);
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function add(){
        $contact=new \classEmpty();
        $contact->id = -1;
        return view('back-end.contact-edit',compact('contact'));
    }

    /**/
    function edit($id){
        $contact=Contact::find(unHashId($id));
        return view('back-end.contact-edit',compact('contact'));
    }

    /*درج */
    function insert(Request $request){
        $this->validate($request,[
            'organization'=> 'required',
            'name'=>     'required',
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'name.required'=>'نام شخص را وارد کنید',
            'organization.required'=>'نام سازمان را وارد کنید',
        ]);
        $array=[
            'name'=>$request->input('name'),
            'organization'=>$request->input('organization'),
            'mobile'=>$request->input('mobile'),
            'tel'=>$request->input('tel',''),
            'role'=>'admin',
            'address'=>$request->input('address'),
            'created_at'=>Carbon::now(),
        ];
        $id=Contact::insertGetId($array);
        if($id){
            $array=[];
            foreach ($request->input('info',[]) as $item){
                $array[]=[
                    'parent_id'=>$id,
                    'name'=>$item['name'],
                    'organization'=>$request->input('organization'),
                    'mobile'=>$item['mobile'],
                    'tel'=>'',
                    'role'=>'personal',
                    'address'=>'',
                ];
            }
            if(count($array)){
                Contact::insert($array);
            }
            return [
                'result'=>1,
                'msg'=>'درخواست با موفقیت ایجاد شد .',
                'param'=>['id'=>hashId($id)]
            ];
        }
        return ['msg'=>'خطای غیر منتظره ، دوباره امتحان کنید'];
    }

    /*ویرایش  */
    function update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'organization'=> 'required',
            'name'=>     'required',
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'name.required'=>'نام شخص را وارد کنید',
            'organization.required'=>'نام سازمان را وارد کنید',
        ]);
        $id = unHashId($request->input('id'));
        $array=[
            'name'=>$request->input('name'),
            'organization'=>$request->input('organization'),
            'mobile'=>$request->input('mobile'),
            'tel'=>$request->input('tel',''),
            'role'=>'admin',
            'address'=>$request->input('address'),
            'updated_at'=>Carbon::now(),
        ];
        $done=Contact::where('id',$id)->update($array);
        if($done){
            $old_ids = Contact::where('parent_id',$id)->pluck('id')->toArray();
            $new_list = $request->input('info',[]);
            $new_ids = array_column($new_list,'id');
            $delete = array_diff($old_ids,$new_ids);
            $insert = [];
            $update = [];
            foreach ($request->input('info') as $item){
                $array=[
                    'id'=>$item['id'],
                    'parent_id'=>$id,
                    'name'=>$item['name'],
                    'organization'=>$request->input('organization'),
                    'mobile'=>$item['mobile'],
                    'tel'=>'',
                    'role'=>'personal',
                    'address'=>'',
                ];
                if($item['id'] > 0)
                    $update[] = $array;
                else
                    $insert[]= $array;
            }
            if(count($delete)){
                Contact::whereIn('id',$delete)->delete();
            }
            if(count($insert)){
                Contact::insert($insert);
            }
            if(count($update)){
                foreach ($update as $item){
                    Contact::where('id',$item['id'])->update($item);
                }
            }
            return [
                'result'=>1,
                'msg'=>'درخواست با موفقیت انجام شد .',
            ];
        }
        return ['msg'=>'خطای غیر منتظره ، دوباره امتحان کنید'];
    }

    /**/
    function delete(Request $request){
        $this->validate($request,[
            'foo'=>'required|array',
        ]);
        $foo=array_map(function ($a){return unHashId($a);},$request->input('foo',[]));
        if(Contact::whereIn('id',$foo)->delete()){
            foreach ($foo as $id){
                Contact::where('parent_id',$id)->delete();
            }
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }

}
