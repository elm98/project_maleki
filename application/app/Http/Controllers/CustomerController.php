<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Locate;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**/
    function customer_list(){
        return view('back-end.customer_list');
    }

    /**/
    function customer_list_dt(Request $request){
        $status=$request->input('status','all');
        $role=$request->input('role','all');
        $date1=Helper::toMiladi($request->input('date1'),'00:01:01');
        $date2=Helper::toMiladi($request->input('date2'),'23:59:59');
        $data=User::whereNotNull('id')
            ->where(function ($q) use($status){
                return in_array($status,[null,'','all','0'])
                    ? 1
                    : $q->where('users.status',$status);
            })
            ->where('role','customer')
            ->where(function ($q) use($date1,$date2){
                $date2=!empty($date2)?$date2:Carbon::now()->endOfDay()->toDateTimeString();
                return in_array($date1,[null,'','all','0'])
                    ? 1
                    : $q->whereBetween('users.created_at',[$date1,$date2]);
            })
            ->select('users.*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('username',function ($data){
            return imageTitle('uploads/avatar/'.$data->avatar,$data->nickname);
        });
        $dt->editColumn('role',function ($data){
            return User::role($data->role);
        });
        $dt->editColumn('status',function ($data){
            return Helper::status_color($data->status,User::status($data->status));
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDate2($data->created_at).'</span>';
        });
        $dt->addColumn('action', function ($data) {
            $html='<a href="'.url('/management/customer-edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'customer-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function customer_add(){
        $user=(object)['username'=>'mohammad'];
        return view('back-end.customer_add',compact('user'));
    }

    /*درج کاربر جدید*/
    function customer_insert(Request $request){
        $this->validate($request,[
            'username'=> 'required|unique:users',
            'password'=> 'required|min:6|confirmed',
            'email'=>    'nullable|email|unique:users',
            'fname'=>    'required',
            'lname'=>    'required',
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'state'=>    'required|numeric|min:1',
            'city'=>     'required|numeric|min:1',
            //'role'=>     'required',
            'status'=>   'required',
            //'permission_id'=>'required_if:role,personnel,operator|numeric|min:1'
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'permission_id.required_if'=>'یک سطح دسترسی انتخاب کنید',
            'permission_id.min'=>'یک سطح دسترسی انتخاب کنید',
            'permission_id.numeric'=>'یک سطح دسترسی انتخاب کنید',
        ]);
        $birthday=Helper::toMiladi($request->input('birthday'));
        $role=$request->input('role');
        $permission_id=$request->has('permission_id')?$request->input('permission_id'):0;
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $array=[
            'username'=>$request->input('username'),
            'password'=>Hash::make($request->input('password')),
            'request_email'=>$request->input('request_email'),
            'nickname'=>$fname.' '.$lname,
            'fname'=>$fname,
            'lname'=>$lname,
            'mobile'=>$request->input('mobile'),
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'zip_code'=>$request->input('zip_code',''),
            'address'=>$request->input('address',''),
            'credit'=>0,
            'status'=>$request->input('status'),
            'tel'=>$request->input('tel',''),
            'birthday'=>$birthday,
            'edit_by'=>auth()->user()->id,
            'created_at'=>Carbon::now(),
        ];
        $id=User::insertGetId($array);
        if($id){
            $user=User::find($id);
            $avatar= $request->input('avatar','');
            if(!empty($avatar)){
                $name=Helper::hash($id).rand(0,999999);
                if($ret=Helper::saveBase64($avatar,$name,'uploads/avatar')){
                   $user->avatar=$ret;
                }
            }
            $user->present_code = User::present_code(Helper::hash($id));
            $user->save();
            return response()->json(['result'=>1,'msg'=>'کاربر جدید با موفقیت ایجاد شد .']);
        }
        return response()->json(['msg'=>'متاسفانه افزودن پرسنل جدید شکست خورد']);
    }

    /**/
    function customer_edit($id){
        $user=User::find(Helper::unHash($id));
        if($user){
            $user->state_fa=Locate::get_name($user->state);
            $user->city_fa=Locate::get_name($user->city);
            return view('back-end.customer_edit',compact('user'));
        }
        return redirect()->back()->with(['error'=>'مشتری پیدا نشد']);
    }

    /*ویرایش کاربر */
    function customer_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            //'username'=> 'required|unique:users',
            'email'=>    'nullable|email|unique:users,email,'.Helper::unHash($request->input('id')),
            'fname'=>    'required',
            'lname'=>    'required',
            //'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'state'=>    'required|numeric|min:1',
            'city'=>     'required|numeric|min:1',
            'status'=>   'required',
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'permission_id.required_if'=>'یک سطح دسترسی انتخاب کنید',
            'permission_id.min'=>'یک سطح دسترسی انتخاب کنید',
            'permission_id.numeric'=>'یک سطح دسترسی انتخاب کنید',
        ]);
        $id=Helper::unHash($request->input('id'));
        $birthday=Helper::toMiladi($request->input('birthday'));
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $array=[
            'request_email'=>$request->input('request_email'),
            'nickname'=>$fname.' '.$lname,
            'fname'=>$fname,
            'lname'=>$lname,
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'zip_code'=>$request->input('zip_code',''),
            'address'=>$request->input('address',''),
            'status'=>$request->input('status'),
            'birthday'=>$birthday,
            'edit_by'=>auth()->user()->id,
            'updated_at'=>Carbon::now(),
        ];
        $up=User::where('id',$id)->update($array);
        if($up){
            $user=User::find($id);
            $avatar= $request->input('avatar','');
            if(!empty($avatar)){
                $old_avatar=glob(Helper::basePath().'/uploads/avatar/'.$user->avatar);
                foreach ($old_avatar as $a){
                    if(is_file($a))
                        unlink($a);
                }
                $name=Helper::hash($id).rand(0,999999);
                if($ret=Helper::saveBase64($avatar,$name,'uploads/avatar')){
                    $user->avatar=$ret;
                }
            }
            $user->save();
            return response()->json(['result'=>1,'msg'=>'ویرایش با موفقیت انجام شد .','user'=>$user]);
        }
        return response()->json(['msg'=>'متاسفانه در اجرای درخواست خطایی رخ داده']);
    }

    /**/
    function customer_delete(Request $request){
        $foo=$request->input('foo');
        if(User::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }

    /*تغییر پسورد*/
    function change_pass(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'password'=>'required|confirmed|min:6'
        ]);
        $id=Helper::unHash($request->input('id'));
        $user=User::find($id);
        $new_pass=$request->input('password');
        if(Hash::check($new_pass,$user->password))
            return response()->json(['msg'=>'نمیتوانید گذر واژه ای مشابه قبلی انتخاب کنید']);
        $upd=$user->update([
            'password'=>Hash::make($new_pass)
        ]);
        if($upd)
            return response()->json(['result'=>1,'msg'=>'گذرواژه جدید با موفقیت تغییر کرد.']);
        else
            return response()->json(['msg'=>'بروز رسانی گذرواژه جدید انجام نشد. دوباره تلاش کنید']);
    }

    /*لیست ادرسهای اضافی یوزر*/
    function address_list($id){
        $id=Helper::unHash($id);
        $list=UserAddress::getList($id);
        $html='';
        $i=1;
        foreach ($list as $item){
            $html.='<tr>';
            $html.='<td>'.++$i.'</td>';
            $html.='<td>'.$item->state_fa.'</td>';
            $html.='<td>'.$item->city_fa.'</td>';
            $html.='<td><span class="font-small">'.$item->address.'</span></td>';
            $html.='<td>'.$item->zip_code.'</td>';
            $html.='<td class="center-align"><a href="javascript:void(0)" onclick="deleteAddress('.Helper::hash($item->id).')"><i class="material-icons pink-text">clear</i></a></td>';
            $html.='</tr>';
        }
        return['result'=>1,'html'=>$html];
    }

    /*افزودن ادرسهای اضافی یوزر*/
    function address_insert(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'state'=>'required|exists:locate,id',
            'city'=>'required|exists:locate,id',
            'zip_code'=>'required',
            'address'=>'required',
        ]);
        $id=Helper::unHash($request->input('id'));

        $in=UserAddress::insert([
           'user_id'=>$id,
           'state'=>$request->input('state'),
           'city'=>$request->input('city'),
           'zip_code'=>$request->input('zip_code'),
           'address'=>$request->input('address'),
           'sort'=>1
        ]);
        if($in)
            return ['result'=>1,'msg'=>'درج ادرس با موفقیت انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیره منتظره لطفا دوباره تلاش کنید'];

    }

    /*حذف ادرسهای اضافی یوزر*/
    function address_delete(Request $request){
        $id=$request->input('id',0);
        $id=Helper::unHash($id);
        if(UserAddress::find($id)->delete())
            return ['result'=>1,'msg'=>'حذف ادرس با موفقیت انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیره منتظره لطفا دوباره تلاش کنید'];
    }

    /**/
    function customer_meta_save(Request $request){
        $this->validate($request,[
            'id'=>'required',
        ]);
        $id=Helper::unHash($request->input('id'));
        $arr=[
            'instagram'=>$request->input('instagram',''),
            'watsapp'=>$request->input('watsapp',''),
            'telegram'=>$request->input('telegram',''),
            'twitter'=>$request->input('twitter',''),
            'website'=>$request->input('website',''),
        ];
        $meta=UserMeta::where('user_id',$id)->get();
        if($meta->count()){
            $meta=$meta->first();
            $meta->update($arr);
        }else{
            $arr['user_id']=$id;
            UserMeta::insert($arr);
        }
        return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];
    }

    /**/
    function customer_notify_save(Request $request){
        $this->validate($request,[
            'id'=>'required',
        ]);
        $id=Helper::unHash($request->input('id'));
        $arr=[
            'notify_comment_my_post'=>$request->input('notify_comment_my_post','no'),
            'notify_replay_my_comment'=>$request->input('notify_replay_my_comment','no'),
            'notify_new_post'=>$request->input('notify_new_post','no'),
            'notify_new_user'=>$request->input('notify_new_user','no'),
        ];
        $meta=UserMeta::where('user_id',$id)->get();
        if($meta->count()){
            $meta=$meta->first();
            $meta->update($arr);
        }else{
            $arr['user_id']=$id;
            UserMeta::insert($arr);
        }
        return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];
    }
}
