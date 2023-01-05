<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Option;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OptionController extends Controller
{
    /*دخیره تغییرات استایل قالب ادمین*/
    function save_them_setting(Request $request){
        $setting=$request->input('setting');
        Option::setjson('them_setting',$setting);
        return ['result'=>1,'msg'=>'تغییرات با موفقیت ذخیره شد'];
    }

    /*دریافت مشخصات قالب ادمین*/
    function get_them_setting(){
        $data=Option::getjson('them_setting');
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function setting(){
        $option=Option::all();
        return view('back-end.setting',compact('option'));
    }

    /*بروز رسانی مشخصاتی مقداذ رشته ای*/
    function setting_update(Request $request){
        $update=[];
        $insert=[];
        foreach ($request->all() as $key=>$val){
            if(substr_count($key,'optionKey_')){
                $key=str_replace('optionKey_','',$key);
                if(Option::exist_key($key)){
                    $update[]=['key'=>$key,'value'=>$val];
                }else{
                    $insert[]=['key'=>$key,'value'=>$val];
                }
            }
        }
        //Update
        foreach ($update as $item){
            Option::where('key',$item['key'])
                ->update(['value'=>$item['value']]);
        }
        //Insert
        if(count($insert)){
            Option::insert($insert);
        }
        //More
        $array=[];
        $tags=$request->has('tags')?implode(',',$request->input('tags')):'old_value';
        $array=['tags'=>$tags];
        Option::meta_update($array);
        return ['result'=>1,'msg'=>'بروز رسانی تنظیمات انجام شد'];
    }

    /*بروز رسانی مشخصاتی جیسون */
    function json_save(Request $request){
        $key = $request->input('key');
        $json=[];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        foreach ($request->all() as $index=>$val){
            if(substr_count($index,'optionJson_')){
                $json[explode('_',$index)[1]]=$val;
            }elseif (!in_array($index,['key','_token'])){
                $myRequest->request->add(['optionKey_'.$index=>$val]);
            }
        }
        //dd($myRequest);
        $id=Option::exist_key($key);
        if($id){
            $update=Option::where('id',$id)->update([
                'json'=>json_encode($json,JSON_UNESCAPED_UNICODE),
            ]);
        }else{
            $update=Option::insertGetId([
                'key'=>$key,
                'json'=>json_encode($json,JSON_UNESCAPED_UNICODE),
                'created_at'=>Carbon::now(),
            ]);
        }
        if($update){
            //dd($myRequest);
            $this->setting_update($myRequest);
            return ['result'=>1,'msg'=>'بروز رسانی تنظیمات انجام شد'];

        }

        else
            return ['result'=>0,'msg'=>'خطای غیر منتظره رخ داده دوباره تلاش کنید'];
    }

    /*بروز رسانی مشخصات تصویر*/
    function setting_image_update(Request $request){
        $this->validate($request,[
            'img'=>'required|min:100',
            'key'=>'required',
        ],[
            'img'=>'تصویری انتخاب نشده',
            'img.min'=>'تصویری انتخاب نشده',
        ]);
        $img= $request->input('img');
        $key= $request->input('key');
        $exist=Option::exist_key($key);
        if($exist){
            $val=Option::getval($key);
            if(!empty($val)){
                deleteFile('uploads/setting/'.$val);
            }
        }
        $name=myRandom(15);
        if($ret=saveBase64($img,$name,'setting')){
            $val=$ret;
            if($exist){
                Option::where('key',$key)->update(['value'=>$val]);
            }else{
                Option::insert([
                    'key'=>$key,
                    'value'=>$val,
                ]);
            }
        }
        return ['result'=>1,'msg'=>'بروز رسانی تصویر انجام شد'];
    }

    /**/
    function backup_list(Request $request){
        $action = $request->input('action');
        $path = basePath().'/data/database-backup';
        if($action == 'delete'){
            $filename = $request->input('filename');
            if(deleteFile("data/database-backup/$filename")){
                return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
            }else{
                return ['result'=>0,'msg'=>'خطایی رخ داده ، دوباره تلاش کنید'];
            }
        }else{
            $list = glob("$path/*.*");
            usort($list, function($a,$b){ return filemtime($b) - filemtime($a);});/*مرتب سازی تاریخ*/
            return view('back-end.backup-list',compact('list'));
        }

    }

    /**/
    function setting_social(){
        $option=Option::all();
        return view('back-end.setting-social',compact('option'));
    }

    /**/
    function setting_address(){
        $option=Option::all();
        return view('back-end.setting-address',compact('option'));
    }

    /**/
    function truncate_table(Request $request){
        $array=[
            'categories',
            'poll',
            'poll_item',
            'poll_answer',
            'view_history',
            'search_history',
            'question',
            'comments',
            'contact',
            'favorites',
            'file',
            'file_user',
            'login_info',
            'notify',
            'payment',
            'payment_request',
            'shop_brand',
            'shop_color',
            'shop_coupon_cart',
            'shop_coupon_cart_user',
            'shop_custom_field',
            'shop_custom_value',
            'shop_discount',
            'shop_invoice',
            'shop_invoice_sub',
            'shop_products',
            'shop_size',
            'shop_warranty',
            'shop_stock',
            'shop_store',
            'sms',
            'ticket',
            'ticket_message',
            'transaction',
            'post',
            'history',
            'shop_stock',
            'shop_stock_report',
        ];
        foreach ($array as $table){
            if(Schema::hasTable($table)){
                DB::table($table)->truncate(); //ShopProduct::query()->truncate();
            }
        }
		deleteFile('uploads/product/*.*');
        deleteFile('uploads/amlak/*.*');
        deleteFile('uploads/shop/*.*');
        return ['result'=>1,'msg'=>'ریست جداول انجام شد'];
     }
}
