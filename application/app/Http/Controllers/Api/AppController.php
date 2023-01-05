<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Bank\IndexController;
use App\Models\Favorite;
use App\Models\FirstPage;
use App\Models\Following;
use App\Models\Option;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AppController extends Controller
{

    /*لیست استانها*/
    function get_state(Request $request){
        $list = getState();
        return ['result' => 1, 'data' => $list];
    }

    /*لیست شهرها*/
    function get_city(Request $request){
        $parent_id = $request->input('parent_id');
        $list = getCity($parent_id);
        return ['result' => 1, 'data' => $list];
    }

    /**/
    function setting(Request $request){
        $user_id = $request->input('user_id');
        $user = \App\Models\User::find($user_id);
        $user = $user?$user:new \classEmpty();
        $options = Option::multiValue([
            'app_version',
            'logo',
            'logo_dark',
            'favicon',
            'mobile',
            'tel',
            'lat',
            'lng',
            'address',
            'expire_invoice_payment',
            'invoice_prefix'
        ]);
        $data=[
            //'max_price'=>intval(DB::table('shop_stock')->max('price')),
            'app_version'=>$options['app_version'],
            'user_id'=>$user_id,
            'credit'=>$user->credit,
            'state_fa'=>locateName($user->state),
            'city_fa'=>locateName($user->city),
            'state'=>$user->state,
            'city'=>$user->city,
            'logo'=>url('/uploads/setting/'.$options['logo']),
            'logo_dark'=>url('/uploads/setting/'.$options['logo_dark']),
            'favicon'=>url('/uploads/setting/'.$options['favicon']),
            'mobile'=>$options['mobile'],
            'tel'=>$options['tel'],
            'address'=>$options['address'],
            'lat'=>$options['lat'],
            'lng'=>$options['lng'],
            'expire_invoice_payment'=>intval($options['expire_invoice_payment']),
            'invoice_prefix'=>$options['invoice_prefix'],
        ];
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function add_to_favorite(Request $request){
        $validator = Validator::make($request->all(), [
            'relate_to'=> 'required',
            'relate_id'=>    'required',
        ],[
            'relate_to.required'=>'دلیل علاقه مندی ضروری میباشد',
            'relate_id.required'=>'شناسه علاقه مندی ضروری میباشد',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $relate_to = $request->input('relate_to','product');
        $relate_id = $request->input('relate_id');
        $user_id = $request->input('user_id');
        $find = Favorite::where('relate_to',$relate_to)
            ->where('relate_id',$relate_id)
            ->where('user_id',$user_id)
            ->get();
        if(!$find->count()){
            $insert=Favorite::insert([
                'relate_to'=>$relate_to,
                'relate_id'=>$relate_id,
                'user_id'=>$user_id,
                'created_at'=>Carbon::now()
            ]);
            if($insert)
                return ['result'=>1,'msg'=>'به علاقه مندی های شما اضافه شده'];
        }else{
            Favorite::where('id',$find->first()->id)->delete();
            return ['result'=>2,'msg'=>'از سبد علاقه مندی حذف شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده '];
    }

    /**/
    function add_follow(Request $request){
        $validator = Validator::make($request->all(), [
            'relate_to'=> 'required',
            'relate_id'=>    'required',
        ],[
            'relate_to.required'=>'دلیل علاقه مندی ضروری میباشد',
            'relate_id.required'=>'شناسه علاقه مندی ضروری میباشد',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $relate_to = $request->input('relate_to');
        $relate_id = $request->input('relate_id');
        $user_id = $request->input('user_id');
        $find = Following::where('relate_to',$relate_to)
            ->where('relate_id',$relate_id)
            ->where('user_id',$user_id)
            ->get();
        if(!$find->count()){
            $insert=Following::insert([
                'relate_to'=>$relate_to,
                'relate_id'=>$relate_id,
                'user_id'=>$user_id,
                'created_at'=>Carbon::now()
            ]);
            if($insert)
                return ['result'=>1,'msg'=>'به دنبال شوندگان شما اضافه شد'];
        }else{
            Following::where('id',$find->first()->id)->delete();
            return ['result'=>2,'msg'=>'شما دیگر او را دنبال نمیکنید'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده '];
    }

    /**/
    function search(Request $request){
        $term = $request->input('term','');
        if(!empty($term)){
            $request->query->add(['q'=>$term]);
            $app = new \App\Http\Controllers\AppController();
            return $app->find_product($request);
        }else{
            return [
                'result'=>0 ,
                'msg'=>'حداقل یک کاراکتر وارد کنید',
                'items'=>[]
            ];
        }
    }

    /**/
    function rule(Request $request){
        $data = Post::find(Option::getval('site_rule'));
        if($data){
            return ['result'=>1,'data'=>$data];
        }else{
            return ['result'=>0,'msg'=>'صفحه قوانین پیدا نشد'];
        }
    }
    /**/
    function privacy_policy(Request $request){
        $data = Post::find(Option::getval('privacy_policy'));
        if($data){
            return ['result'=>1,'data'=>$data];
        }else{
            return ['result'=>0,'msg'=>'صفحه حریم خصوصی پیدا نشد'];
        }
    }
    /**/
    function about(Request $request){
        $about = Option::getval('about');
        return ['result'=>1,'data'=>[
            'about'=>$about,
            'social'=>Option::multiValue([
                    'telegram',
                    'watsapp',
                    'instagram',
                    'email',
                    'linkedin',
                    'twitter',
                    'tel',
                    'lat',
                    'lng'
                ]
            )]
        ];
    }

}
