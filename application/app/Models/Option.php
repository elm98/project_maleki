<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $table='options';
    protected $guarded=[];

    static function setval($key,$value,$description=''){
        $find=Option::where('key',$key)->get();
        if($find->count()){
            $o=$find->first();
            $description=!empty($description)?$description:$o->description;
            $o->value=$value;
            $o->description=$description;
            $o->save();
            return 1;
        }else{
            Option::insert([
                'key'=>$key,
                'value'=>$value,
                'description'=>$description,
            ]);
            return 1;
        }
    }

    static function setjson($key,$arr,$description=''){
        $find=Option::where('key',$key)->get();
        if($find->count()){
            $o=$find->first();
            $description=!empty($description)?$description:$o->description;
            $o->json=json_encode($arr);
            $o->description=$description;
            $o->save();
            return 1;
        }else{
            Option::insert([
                'key'=>$key,
                'json'=>json_encode($arr),
                'description'=>$description,
            ]);
            return 1;
        }
    }

    static function getval($key,$default=''){
        $find=Option::where('key',$key)->get();
        return $find->count()?$find->first()->value:$default;
    }

    static function getjson($key,$default=[]){
        $find=Option::where('key',$key)->get();
        return $find->count()?json_decode($find->first()->json):$default;
    }

    /*تایع پدر برای گزینه های هر فیلد*/
    public static function fieldItems($data,$e=''){
        if(is_null($e)){
            return '';
        }
        $data=!empty($data)?$data:[];
        if($e=='all')
            return $data;
        elseif (!empty($e) && isset($data[$e]))
            return $data[$e];
        elseif (empty($e) || $e=='')
            return $data;
        return 'نامشخص';
    }

    /**/
    static function find_key($options,$key){
        $list=$options->where('key',$key);
        if($list->count())
            return $list->first()->value;
        return '';
    }

    /**/
    static function exist_key($key){
        $list=Option::where('key',$key)->get();
        if($list->count())
            return $list->first()->id;
        return 0;
    }

    /* ذخیره کلید و مقدار */
    static public function meta_update($array)
    {
        if(!count($array)){
            return 0;
        }
        foreach($array as $key=>$value)
        {
            if($value != 'old_value'){
                $is = Option::where('key', $key)->count();
                if ($is)
                    Option::where('key', $key)
                        ->update([
                            'value' => $value,
                        ]);
                else
                    Option::insert([
                        'key' => $key,
                        'value' => $value,
                    ]);
            }
        }
        return 1;
    }

    /**/
    static function get_img($key,$folder=''){
        $find=Option::where('key',$key)->get();
        return $find->count()?url('/uploads/'.$folder.'/'.$find->first()->value):url('/back/custom/img/avatar.png');
    }

    /**/
    static function multikey($keys=[]){
        $arr=[];
        $list=Option::whereIn('key',$keys)->get();
        foreach ($keys as $key){
            $find = $list->where('key',$key);
            if($find->count())
                $arr[$key] = $find->first();
            else
                $arr[$key] = new \classEmpty();
        }
        return $arr;
    }

    /**/
    static function multiValue($keys=[]){
        $arr=[];
        $list=Option::whereIn('key',$keys)->get();
        foreach ($keys as $key){
            $find = $list->where('key',$key);
            if($find->count())
                $arr[$key] = str_replace(['{SITE_URL}'],[url('/')],$find->first()->value);
            else
                $arr[$key] = '';
        }
        return $arr;
    }

}
