<?php

namespace App\Http\Controllers;

use App\Helper\AccessController;
use App\Helper\Helper;
use App\Models\Category;
use App\Models\Post;
use App\Models\Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RedirectController extends Controller
{
    /**/
    function redirect_list(){
        return view('back-end.redirect_list');
    }

    /**/
    function redirect_list_dt(Request $request){

        $data=Redirect::select('*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>{{$id}}');
        $dt->editColumn('url',function ($data){
            $html='<div class="text-left" dir="ltr">';
            $html.= '<a href="'.url($data->old_url).'" title="'.$data->old_url.'" class="font-small">'.$data->old_url.'</a><br/>';
            $html.= '<a href="'.url($data->new_url).'" title="'.$data->new_url.'" class="font-small">'.$data->new_url.'</a>';
            $html.='</div>';
            return $html;
        });
        $dt->editColumn('type',function ($data){
            return Redirect::type($data->type);
        });
        $dt->addColumn('action', function ($data) {
            $info = json_encode([
                'id'=>hashId($data->id),
                'old_url'=>$data->old_url,
                'new_url'=>$data->new_url,
                'type'=>$data->type,
            ]);
            $html='<a href="javascript:;" title="ویرایش" class="mr-5"><i data-info=\''.$info.'\' class="material-icons circle dt-icon edit-line"  >edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.hashId($data->id).',\'redirect-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }


    /**/
    function redirect_done(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'old_url'=>'required|unique:redirect,old_url,'.unHashId($request->input('id')),
            'new_url'=>'required|unique:redirect,new_url,'.unHashId($request->input('id')),
            'type'=>'required',
        ],[
            'old_url.required'=>'لینک قدیمی را وارد کنید',
            'old_url.unique'=>'لینک قدیمی تکراری است',
            'new_url.required'=>'لینک جدید را وارد کنید',
            'new_url.unique'=>'لینک جدید تکراری است',
            'type.required'=>'نوع انتقال را مشخص کنید',
        ]);
        $id=unHashId($request->input('id'));
        $array=[
            'old_url'=>$request->input('old_url',''),
            'new_url'=>$request->input('new_url',''),
            'type'=>$request->input('type','301'),
        ];
        if($id==0){
            $array['created_at']=Carbon::now();
            $array['created_by']=auth_info()->user_id;
            $id=DB::table('redirect')->insertGetId($array);
        }else{
            $array['updated_at']=Carbon::now();
            Redirect::where('id',$id)->update($array);
        }
        return ['result'=>1,
            'msg'=>'درخواست با موفقیت انجام شد',
            'param'=>[
                'id'=>$id,
                'hash_id'=>Helper::hash($id),
            ]
        ];
    }

    /*delete */
    function redirect_delete(Request $request){
        $this->validate($request,[
            'foo'=>'required|array',
        ]);
        $foo=array_map(function ($a){return unHashId($a);},$request->input('foo',[]));
        if(Redirect::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'حذف با موفقیت انجام شد '];
        }
        return ['result'=>0,'msg'=>'خطایی رخ داده دوباره تلاش کنید'];
    }


}
