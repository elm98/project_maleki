<?php

namespace App\Http\Controllers;

use App\Helper\Helper;

use App\Models\LoginInfo;
use App\Models\Option;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserMeta;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    /**/
    function user_list(){
        return view('back-end.user_list');
    }

    /**/
    function user_list_dt(Request $request){
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
            ->where(function ($q) use($role){
                return in_array($role,[null,'','all','0'])
                    ? 1
                    : $q->where('users.role',$role);
            })
            ->where(function ($q) use($date1,$date2){
                $date2=!empty($date2)?$date2:Carbon::now()->endOfDay()->toDateTimeString();
                return in_array($date1,[null,'','all','0'])
                    ? 1
                    : $q->whereBetween('users.created_at',[$date1,$date2]);
            })
            ->whereIn('users.role',['personal','operator','administrator'])
            ->select('users.*');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('username',function ($data){
            return imageTitle('uploads/avatar/'.$data->avatar,$data->username,10);
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
            $html='<a href="'.url('/management/user-edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'user-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function user_add(){
        $user=(object)['username'=>'mohammad'];
        return view('back-end.user_add',compact('user'));
    }

    /*درج کاربر جدید*/
    function user_insert(Request $request){
        $this->validate($request,[
            'username'=> 'required|unique:users',
            'password'=> 'required|min:6|confirmed',
            'fname'=>    'required',
            'lname'=>    'required',
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',

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
            'zip_code'=>$request->input('zip_code',''),
            'address'=>$request->input('address',''),
            'credit'=>0,
            'role'=>'administrator',
            'status'=>$request->input('status'),
            'tel'=>$request->input('tel',''),
            'birthday'=>$birthday,
            'code_melli'=>$request->input('code_melli',''),
            'owner_name'=>$request->input('owner_name',''),
            'company_name'=>$request->input('company_name',''),
            'type'=>$request->input('type','real'),
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
            return ['result'=>1,'msg'=>'کاربر جدید با موفقیت ایجاد شد .'];
        }
        return ['msg'=>'متاسفانه افزودن پرسنل جدید شکست خورد'];
    }

    /**/
    function user_edit($id){
        $user=User::find(Helper::unHash($id));
        if($user){
            return view('back-end.user_edit',compact('user'));
        }
        else
            return redirect()->back()->with(['error'=>'کاربر پیدا نشد']);
    }

    /*ویرایش کاربر */
    function user_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            //'username'=> 'required|unique:users',
            //'email'=>    'nullable|email|unique:users,email,'.Helper::unHash($request->input('id')),
            'fname'=>    'required',
            'lname'=>    'required',
            //'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            //'state'=>    'required|numeric|min:1',
            //'city'=>     'required|numeric|min:1',
            //'role'=>     'required',
            //'status'=>   'required',
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
        $id=Helper::unHash($request->input('id'));
        $birthday=Helper::toMiladi($request->input('birthday'));
        $role=$request->input('role');
        $permission_id=$request->input('permission_id',0);
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $array=[
            'nickname'=>$fname.' '.$lname,
            'fname'=>$fname,
            'lname'=>$lname,
            'status'=>$request->input('status','active'),
            'tel'=>$request->input('tel',''),
            'birthday'=>$birthday,
            'code_melli'=>$request->input('code_melli',''),
            'owner_name'=>$request->input('owner_name',''),
            'company_name'=>$request->input('company_name',''),
            'type'=>$request->input('type','real'),
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
                $name=hashId($id).rand(0,999999);
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
    function user_delete(Request $request){
        $foo=$request->input('foo');
        $admin_ids = User::where('role','administrator')->pluck('id')->toArray();
        $countFindAdmin = count(array_intersect($admin_ids,$foo));
        if((count($admin_ids) < 2 && $countFindAdmin) || count($admin_ids) == $countFindAdmin){
            return ['result'=>0,'msg'=>'نمی توان تمام مدیران ارشد را حذف کرد ، حداقل یک مدیر باید وجود داشته باشد'];
        }
        foreach ($foo as $id){
            deleteFile('uploads/avatar/'.hashId($id).'*.*');
        }
        if(User::whereIn('id',$foo)->delete()){
            foreach ($foo as $id){
                deleteFile('uploads/avatar/'.hashId($id).'*.*');
            }
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
        if($id == 0){
            return ['result'=>0,'msg'=>'آدرس پیش فرض قابل حذف نیست'];
        }
        if(UserAddress::find($id)->delete())
            return ['result'=>1,'msg'=>'حذف ادرس با موفقیت انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیره منتظره لطفا دوباره تلاش کنید'];
    }

    /*لیست ادرسهای اضافی یوزر*/
    function get_address(Request $request){
        $id=unHashId($request->input('user_id'));
        $list = UserAddress::getList($id);
        return['result'=>1,'data'=>$list];
    }

    /**/
    function user_meta_save(Request $request){
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
    function user_notify_save(Request $request){
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

    /**/
    function change_credit(Request $request){
        $this->validate($request,[
            'user_id'=>'required',
            'credit'=>'required',
        ]);
        $credit = $request->input('credit');
        $user = User::find(unHashId($request->input('user_id')));
        $currency = Option::getval('currency');
        if($user){
            if($user->credit == $credit){
                return ['result'=>0,'msg'=>'مبلغ تغییری نکرده'];
            }
            if($user->credit > $credit){
                $in_out = 'out';
                $difCredit = $user->credit - $credit;
            }else{
                $in_out = 'in';
                $difCredit = $credit - $user->credit ;
            }
            $user->credit = $credit;
            $user->save();
            $auth = auth()->user();
            $e = $in_out =='out'?'کسر از ':'افزایش ';
            $desc = $e.'  شارژ مشتری به مبلغ '.$difCredit.' '.$currency.' توسط '.$auth->nickname.' با شناسه '.$auth->id.'-'.hashId($auth->id);
            Transaction::insert([
                'amount' => $difCredit,
                'user_from' => $user->id,
                'user_to' => $user->id,
                'in_out' => $in_out,
                'relate_to' => 'change_credit',
                'relate_id' => 0,
                'payment_method' => 'manual',
                'tracking_number' => 0,
                'description' => $desc ,
                'created_by' => $auth->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return ['result'=>1,'msg'=>'عملیات با موفقیت انجام شد'];
        }else{
            return ['result'=>0,'msg'=>'کاربر پیدا نشد'];
        }
    }


    /*صفحه فراموشی رمز*/
    function forget_password(){
        if(!auth()->check())
            return view('front-end.forget-password');
        else
            return redirect('/');
    }

    /*درخواست رمز جدید*/
    function forget_password_request(Request $request){
        $username = $request->input('username');
        $email = $request->input('email');
        if(!empty($email)){
            $find = User::where('email',$email)->get();
            if($find->count()){
                $u = $find->first();
                $code = encrypt(rand(11111,99999));
                $u->recovery_pass_token = $code;
                if($u->save()){
                    sendNotify('forget_password',[
                        'user'=>$u,
                        'mobile'=>$u->mobile,
                        'email'=>$u->email
                    ]);
                    return [
                        'result'=>1,
                        'msg'=>'لینک بازیابی رمز عبور به موبایل و ایمیل شما ارسال شد',
                    ];
                }else{
                    return ['result'=>0,'msg'=>'خطای دیتابیس رخ داده'];
                }
            }else{
                return ['result'=>0,'msg'=>'کاربری با این مشخصات پیدا نشد'];
            }
        }else{
            return ['result'=>0,'msg'=>'ایمیل را وارد کنید'];
        }
    }

    /*برگشت به صفحه برای تایید*/
    function recovery_password($recovery_token=''){
        if(!auth()->check()){
            $find = User::where('recovery_pass_token',$recovery_token)->get();
            if($find){
                $user = $find->first();
                return view('front-end.forget-password',compact('user','recovery_token'));
            }else{
                return 'ادرس درخواستی شما معتبر نیست';
            }
        }
        return redirect('/');
    }

    /*تایید و رمز جدید*/
    function set_new_password(Request $request){
        $validator= Validator::make($request->all(),[
            'password'=> 'required|min:6|confirmed',
            'recovery_token'=>'required|exists:users,recovery_pass_token'
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $recovery_token = $request->input('recovery_token');
        $find = User::where('recovery_pass_token',$recovery_token)->get();
        if($find->count()){
            $user = $find->first();
            $user->password = Hash::make($request->input('password'));
            $user->recovery_pass_token = '';
            $user->save();
            return ['result'=>1,'msg'=>'رمز عبور جدید با موفقیت ایجاد شد'];
        }else{
            return ['result'=>0,'msg'=>'کاربر یافت نشد'];
        }
    }

    /**/
    function login_list(Request $request){
        if($request->method() == 'GET')
            return view('back-end.login-list');

        $status=$request->input('status','all');
        $role=$request->input('role','all');
        $date1=toMiladi($request->input('date1'),'00:01:01');
        $date2=toMiladi($request->input('date2'),'23:59:59');
        $data=LoginInfo::Leftjoin('users','users.id','login_info.user_id')
            ->where(function ($q) use($status){
                return in_array($status,[null,'','all','0'])
                    ? 1
                    : $q->where('users.status',$status);
            })
            ->where(function ($q) use($role){
                return in_array($role,[null,'','all','0'])
                    ? 1
                    : $q->where('users.role',$role);
            })
            ->where(function ($q)use($date1){
                if(!empty($date1))
                    return $q->where('login_info.created_at','>=',$date1);
                return 1;
            })
            ->where(function ($q)use($date2){
                if(!empty($date2))
                    return $q->where('login_info.created_at','<=',$date2);
                return 1;
            })
            ->select(
                'users.*',
                'login_info.*'
            );
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('username',function ($data){
            return imageTitle('uploads/avatar/'.$data->avatar,$data->username,10);
        });
        $dt->editColumn('role',function ($data){
            return User::role($data->role);
        });
        $dt->editColumn('status',function ($data){
            return Helper::status_color($data->status,User::status($data->status));
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDateTime($data->created_at).'">'.Helper::alphaDateTime($data->created_at).'</span>';
        });

        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function login_delete(Request $request){
        $foo=$request->input('foo');
        if(LoginInfo::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }
}
