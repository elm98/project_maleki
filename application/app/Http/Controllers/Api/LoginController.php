<?php

namespace App\Http\Controllers\Api;


use App\Models\Notify;
use App\Models\Option;
use App\Models\ShopInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /*یکسان کردن ساختار خروجی ارسالی به اپ*/
    private function arrangeUserData($user){
        return $data=[
            //'token'=> $token,
            //'token_expire' => date('Y-m-d H:i:s',$expire),
            'token_type' => 'bearer',
            'user_id'=>$user->id,
            'mobile'=>$user->mobile,
            'nickname'=>$user->nickname,
            'username'=>$user->username,
            'credit'=>$user->credit,
            'state_fa'=>locateName($user->state),
            'city_fa'=>locateName($user->city),
            'state'=>$user->state,
            'city'=>$user->city,
            'avatar'=>url('/uploads/avatar/'.$user->avatar),
            'no_avatar'=>url('/back/custom/img/avatar.png'),
            'currency'=>Option::getval('currency')
        ];
    }

    /*ورود*/
    function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username'=>'required',
            'password'=>'required',
        ],[
            'username.required'=>'نام کاربری را وارد کنید',
            'password.required'=>'کلمه عبور را وارد کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $credentials2 = [
            'mobile' => $request->input('username'),
            'password' => $request->input('password'),
        ];
        $customClaims = ['userId'=>rand(1,1000)]; /*یه دیتای فرضی اضافه کردیم به توکن*/
        try {
            if (!$token = JWTAuth::attempt($credentials,$customClaims)) {
                if (!$token = JWTAuth::attempt($credentials2,$customClaims)){
                    return ['result' => 0, 'msg' => 'مشخصات ورود اشتباه است '];
                }
            }
        } catch (JWTException $e) {
            return ['result' => 0, 'msg' => 'نمیتوان توکن ایجاد کند'];
        }
        $expire = JWTAuth::setToken($token)->getPayload()->get('exp');
        $user = auth()->user();
        $data = $this->arrangeUserData($user);
        $data['token'] = $token;
        $data['token_expire'] = date('Y-m-d H:i:s',$expire);
        return ['result' => 1, 'data' => $data];
    }

    /*چک یا پیدا کردن موبایل درخواستی*/
    function login_with_mobile(Request $request){
        $validator = Validator::make($request->all(), [
            //'mobile'=>'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'mobile'=>'required|numeric|digits:11|regex:/(09)[0-9]/',
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.numeric'=>'شماره موبایل نباید شامل حروف باشد',
            'mobile.regex'=>'فرمت شماره موبایل را رعایت کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=> 'error','msg'=>$validator->messages()->first()];
        }
        $mobile = $request->input('mobile');
        $find = User::where('mobile',$mobile)->get();
        if($find->count()){
            $user = $find->first();
            $user->mobile_verify_code = myRandom(5);
            $user->save();
            sendNotify('mobile_verify_code',[
                'user'=>$user,
                'mobile'=>$user->mobile
            ]);
            return ['result' => 1, 'code' => $user->mobile_verify_code];
        }
        return ['result' => 0, 'msg' => 'کاریری با این مشخصات یافت نشد'];
    }

    /*تایید کد و لاگین در اپ*/
    function mobile_verify_code(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile'=>'required|numeric|digits:11|regex:/(09)[0-9]/',
            'code'=>'required|numeric|digits:5',
        ],[
            'mobile.required'=>'شماره موبایل را موارد کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $mobile=$request->input('mobile');
        $code = $request->input('code');

        $find=User::where('mobile',$mobile)
            ->where('mobile_verify_code',$code)
            ->limit(1)
            ->get();
        if(!$find->count()){
            return ['result' => 0, 'msg' => 'لطفا کد تایید را با دقت وارد نمایید'];
        }
        $user = $find->first();
        //dd($user);
        $credentials = [
            'mobile' => $mobile,
            'mobile_verify_code' => $code,
            'password' => $user->password,
        ];
        $customClaims = ['userId'=>rand(1,1000)]; /*یه دیتای فرضی اضافه کردیم به توکن*/
        try {
            if (!$token = JWTAuth::fromUser($user)) {
                return ['result' => 0, 'msg' => ' کد تایید اشتباه است '];
            }
        } catch (JWTException $e) {
            return ['result' => 0, 'msg' => 'توکن ایجاد نشد - '.$e->getMessage()];
        }
        $expire = JWTAuth::setToken($token)->getPayload()->get('exp');
        $data = $this->arrangeUserData($user);
        $data['token'] = $token;
        $data['token_expire'] = date('Y-m-d H:i:s',$expire);
        return ['result' => 1, 'data' => $data];
    }

    /*ثبت نام*/
    function register(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            //'password'=> 'required|min:6|confirmed',
            'fname'=>    'required',
            'lname'=>    'required',
            'state'=>    'required|numeric|min:1',
            'city'=>     'required|numeric|min:1',
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
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $nickname = $fname.' '.$lname;
        $mobile = $request->input('mobile');
        $username = 'customer_'.$mobile;
        $randomCode = myRandom(7);
        $array=[
            'username'=>$username,
            //'password'=>Hash::make($request->input('password')),
            'password'=>Hash::make($randomCode),
            'nickname'=>$nickname,
            'fname'=>$fname,
            'lname'=>$lname,
            'mobile'=>$request->input('mobile'),
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'credit'=>0,
            'role'=>'customer',
            'status'=>'active',
            'created_at'=>Carbon::now(),
        ];
        $id=User::insertGetId($array);
        if($id){
            Notify::insert([
                'user_id'=>0,
                'relate_to'=>'new_customer',
                'relate_id'=>$id,
                'content'=>"مشتری جدید ($nickname) به تازگی از طریق Api ثبت نام کرد",
                'created_at'=>Carbon::now()
            ]);
            sendNotify('new_customer',[
                'user_id'=>$id,
                'mobile'=>$mobile,
            ]);
            return [
                'result'=>1,
                'data'=>[
                    'mobile'=>$mobile
                ],
                'msg'=>'ثبت نام شما با موفقیت انجام شد',
            ];
        }
        return ['result'=>0,'msg'=>'متاسفانه خطای غیر منتظره رخ داده ، دوباره تلاش کنید'];
    }

    /*خروج*/
    public function logout()
    {
        auth()->logout();
        return response()->json(['result'=>1,'msg' => 'User successfully logged out.']);
    }

    /*رفرش توکن*/
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /*نمایش پروفایل*/
    public function profile(Request $request)
    {
        $orders = ShopInvoice::where('user_id',$request->input('user_id'))->get();
        $user = User::find($request->input('user_id'));
        $user->state = locateName($user->state);
        $user->city = locateName($user->city);
        //$user->order_done =

        return $user;
    }

}
