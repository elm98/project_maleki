<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Ui\AppController;
use App\Models\LoginInfo;
use App\Models\Notify;
use App\Models\NotifyTemp;
use App\Models\Option;
use App\Models\Role;
use App\Models\Sms;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $timeOut = 60 * 24 * 14; /*برحسب دقیقه که شده دو هفته*/

    /*صفحه ورود فرونت*/
    function login(Request $request){
        if(Auth::check())
            return redirect()->intended('/management');
        else
            return  view(AppController::getView('login'));
    }

    /*ورود با موبایل*/
    function login_mobile(){
        if(Auth::check())
            return redirect()->intended('/profile');
        else
            return  view(AppController::getView('login-mobile'));
    }

    /**/
    function mobile_verify_code(Request $request){
        $mobile = $request->input('mobile');
        $find = User::where('mobile',$mobile)
            ->orWhere('username',$mobile)
            ->get();
        if($find->count()){
            $code = rand(00000,99999);
            $user = $find->first();
            $user->mobile_verify_code = '11111';
            $user->save();

            return [
                'result'=>1,
                'msg'=>'کد تایید را وارد کنید',
            ];
        }else{
            return [
                'result'=>0,'msg'=>'کاربری با این مشخصات پیدا نشد'];
        }
    }

    /**/
    function mobile_check_code(Request $request){
        $mobile = $request->input('mobile');
        $verify_code = $request->input('verify_code');
        $find = User::where('mobile',$mobile)
            ->orWhere('username',$mobile)
            ->get();
        if($find->count() && $find->first()->mobile_verify_code == $verify_code){
            \auth()->loginUsingId($find->first()->id);
            return [
                'result'=>1,
                'msg'=>'کد تایید صحیح است',
            ];
        }else{
            return [
                'result'=>0,'msg'=>'کد تایید اشتباه میباشد'];
        }
    }

    /*صفحه ورود فرونت*/
    function login_done(Request $request){
        $callback = $request->input('callback');
        $r = $this->x_login($request);
        if($r['result']){
            return !empty($callback)?redirect($callback):redirect('/');
        }
        return redirect()->back()->with(['error'=>$r['msg']]);
    }

    /*صفحه ثبت نام فرونت*/
    function register(Request $request){
        if(Auth::check())
            return redirect()->intended('/');
        else
            return view(AppController::getView('register'));
    }

    /*ارسال فرم ثبت نام*/
    function register_done(Request $request){
        $r =  $this->x_register($request);
        if($r['result']) {
            \auth()->loginUsingId($r['user_id']);
        }
        return $r;


        if($r['result']){
            \auth()->loginUsingId($r['user_id']);
            return redirect()->intended('/profile');
        }else{
            return redirect()->back()->with(['result'=>0,'msg'=>$r['msg'],'error'=>$r['msg']]);
        }

    }

    /*خروج*/
    function logout(){
        return x_logout();
    }

    /************************
    Back End Login
     **********************/
    /*صفحه ورود بک اند*/
    function log_in(Request $request){
        if(Auth::check())
            return redirect('/management');
        else{
            cookie()->queue(env('APP_NAME').'_auth_info','',1);
            return view('back-end.log_in');
        }
    }

    /*عملیات ورود بک اند*/
    function logged_in(Request $request)
    {
        $r = $this->x_login($request);
        if($r['result']){
            return redirect('/management');
        }
        return redirect()->back()->with(['error'=>$r['msg']]);
    }

    /*عملیات خروج*/
    function log_out(Request $request){
        return $this->x_logout();
    }

    /*عملیات اصلی ورود*/
    function x_login(Request $request){
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
        ],[
            'username.required'=>'نام کاربری را وارد کنید',
            'password.required'=>'رمز عبور را واد کنید',
        ]);
        $username=$request->input('username');
        $password=$request->input('password');
        $credentials1 = [
            'mobile'=>$username,
            'password'=>$password
        ];
        $credentials2 = [
            'username'=>$username,
            'password'=>$password
        ];
        $remember = intval($request->input('remember',0));
        if (Auth::attempt($credentials1,$remember) || Auth::attempt($credentials2,$remember)) {
            $user=Auth::user();
            LoginInfo::insert([
                'user_id'=>$user->id,
                'username'=>$user->username,
                'ip'=>$this->getIPAddress(),
                'agent'=>$_SERVER['HTTP_USER_AGENT'],
                'created_at'=>Carbon::now()
            ]);
            return ['result'=>1,'msg'=>'عملیات ورود با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'نام کاربری یا رمز عبور اشتباه است'];
    }

    /*عملیات اصلی ثبت نام کاربران*/
    function x_register(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'password'=> 'required|min:6|confirmed',
            'fname'=>    'required',
            'lname'=>    'required',

        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'fname.required'=>'نام خود را وارد کنید',
            'lname.required'=>'فامیلی را وارد کنید',
            'state.required'=>'استان را انتخاب کنید',
            'city.required'=>'شهر را انتخاب کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $nickname = $fname.' '.$lname;
        $mobile = $request->input('mobile');
        $username = 'admin_'.$mobile;
        $password = $request->input('password');
        $array=[
            'username'=>$username,
            'password'=>Hash::make($password),
            'nickname'=>$nickname,
            'fname'=>$fname,
            'lname'=>$lname,
            'mobile'=>$request->input('mobile'),
            'owner_name'=>$request->input('owner_name',''),
            'company_name'=>$request->input('company_name',''),
            'type'=>$request->input('type','real'),
            'credit'=>0,
            'role'=>'administrator',
            'status'=>'active',
            'created_at'=>Carbon::now(),
        ];
        $id=User::insertGetId($array);
        if($id){
            return [
                'result'=>1,
                'msg'=>'ثبت نام شما با موفقیت انجام شد',
                'user_id'=>$id
            ];
        }
        return ['result'=>0,'msg'=>'متاسفانه خطای غیر منتظره رخ داده ، دوباره تلاش کنید'];
    }

    /*عملیات اصلی خروج*/
    function x_logout(){
        return x_logout();
    }

    /*دریافت ای پی ادرس*/
    function getIPAddress() {
        //whether ip is from the share internet
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from the proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from the remote address
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**/
    static function getIp(){
        $t = new LoginController();
        return $t->getIPAddress();
    }

}
