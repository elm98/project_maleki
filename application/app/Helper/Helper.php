<?php

namespace App\Helper;

use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Hekmatinasser\Verta\Verta;

class Helper
{
    /*بانک رنگ*/
    static function color_bank(){
        return [
            'green'=>['active','ok','ready','is_user'],
            'blue'=>['read'],
            'red'=>['trash','disconnect','is_guest'],
            'orange'=>['cancel','cancel_operator','cancel_customer'],
            'purple'=>['seller'], // بنفش
            'yellow'=>[],
            'cyan'=>['in'], //سبز کمرنگ
            'grey'=>[''],
            'pink'=>['inactive','deactive','expire'],
            'indigo'=>['verify'], //ابی مایل بنفش
            'teal'=>[], // سبز تیره تر
            'lime'=>[],
            'amber'=>['pending','draft'], // زرد خوشرنگ
            'brown'=>['out'],
        ];
    }

    /*متنهای رنگی*/
    static function text_color($color,$text=''){
        $data=[];
        $color_list=array_keys(self::color_bank());
        foreach ($color_list as $key){
            $data[$key]='<span class="chip lighten-5 '.$key.' '.$key.'-text">'.$text.'</span>';
        }
        return in_array($color,$color_list)?$data[$color]:$data['grey'];
    }

    /*بالتهای رنگی*/
    static function text_bullet($color,$text=''){
        $data=[];
        $color_list=array_keys(self::color_bank());
        foreach ($color_list as $key){
            $data[$key]='<span class="bullet '.$key.'"></span><small>'.$text.'</small>';
        }
        return in_array($color,$color_list)?$data[$color]:$data['grey'];
    }

    /*رنگ دادن به وضعیتها*/
    static function status_color($status,$text=''){
        $color='';
        $text=!empty($text)?$text:$status;
        foreach (self::color_bank() as $key=>$row){
            if(in_array($status,$row))
                $color=$key;
        }
        if(!empty($color))
            return self::text_color($color,$text);
        else
            return self::text_color('grey',$text);
    }

    /*رنگ دادن به بالت وضعیتها*/
    static function status_color_bullet($status,$text=''){
        $color='';
        $text=!empty($text)?$text:$status;
        foreach (self::color_bank() as $key=>$row){
            if(in_array($status,$row))
                $color=$key;
        }
        if(!empty($color))
            return self::text_bullet($color,$text);
        else
            return self::text_bullet('grey',$text);
    }

    /**/
    static function dot_slashes(){
        $r=Route::getCurrentRoute()->uri;
        $count=substr_count($r,'/');
        $dotSlashes='';
        for($i=0;$i<$count;$i++){
            $dotSlashes.='../';
        }
        return $dotSlashes;
    }

    /*مسیر ریشه پروژه*/
    static function basePath(){
        return realpath(base_path() . '/../');
    }

    //Shamsi to Miladi
    public static function toMiladi($date , $time="00:00:00"){
        if(empty($date)){
            return null;
        }
        $v=new Verta();
        $date=str_replace('-','/',$date);
        $explode_date=explode('/',$date);
        if(count($explode_date)==3){
            $y=intval($explode_date[0]);
            $m=intval($explode_date[1]);
            $d=intval($explode_date[2]);
            if($y > 1300 && $y < 1450){
                if($m >=1 && $m<=12){
                    if($d >=1 && $d<=31){
                        $explode_time=explode(':',$time);
                        if(count($explode_time)==3){
                            $timestamp= Verta::parse($y.'-'.$m.'-'.$d.' '.$explode_time[0].':'.$explode_time[1].':'.$explode_time[2])->getTimestamp();
                            $v->timezone = 'Asia/Tehran';
                            return date('Y-m-d H:i:s',$timestamp);
                        }
                    }
                }
            }
        }
        return date('Y-m-d H:i:s',time());
    }

    /*فقط تاریخ الفبایی*/
    public static function alphaDate($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('l, j F Y'.$txt);
    }

    /*فقط تاریخ الفبایی2*/
    public static function alphaDate2($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('j F Y'.$txt);
    }

    /*تاریخ و زمان الفبایی*/
    public static function alphaDateTime($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('l, j F Y - H:i:s'.$txt);
    }

    /*تبدیل میلادی به هر فرمت شمسی*/
    public static function v($str,$format='l, j F Y - H:i:s'){
        if(empty($str))
            return '';
        $v=new Verta($str);
        return $v->format($format);
    }

    /**/
    static function getImg($name){
        return empty($name)?self::dot_slashes().'back/custom/img/no-image.png':self::dot_slashes().'uploads/media/'.$name;
    }

    /**/
    static function getAvatar($name){
        return empty($name)?self::dot_slashes().'back/custom/img/avatar.png':self::dot_slashes().'uploads/avatar/'.$name;
    }

    /**/
    static function getApiImg($name,$folder='media'){
        return empty($name)?asset('back/custom/img/no-image.png'):asset('uploads/'.$folder.'/'.$name);
    }

    /**/
    static function getApiAvatar($name){
        return empty($name)?asset('back/custom/img/avatar.png'):asset('uploads/avatar/'.$name);
    }

    /**/
    static function getImgFolder($name,$folder='media'){
        return empty($name)?self::dot_slashes().'back/custom/img/no-image.png':self::dot_slashes().'uploads/'.$folder.'/'.$name;
    }

    /**/
    static function saveBase64($file,$name,$path){
        if (!is_null($file) && strpos($file, 'data:image') === 0) {
            $img = $file;
            $ext = 'jpg';
            if (strpos($img, 'data:image/jpeg;base64,') === 0) {
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $ext = 'jpg';
            }
            if (strpos($img, 'data:image/png;base64,') === 0) {
                $img = str_replace('data:image/png;base64,', '', $img);
                $ext = 'png';
            }
            if (strpos($img, 'data:image/gif;base64,') === 0) {
                $img = str_replace('data:image/gif;base64,', '', $img);
                $ext = 'gif';
            }

            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $fileName=$name.'.'.$ext;
            $path=realpath(base_path() . '/../'.$path);
            if(is_dir($path)){
                $myFile = $path.'/'.$fileName;
                if(file_put_contents($myFile, $data)){
                    return $fileName;
                }
            }
        }
        return 0;
    }

    /**/
    static function hash($id){
        if (intval($id)==0)
            return 0;
        $id = (((intval($id) * 53) + 147) - 9) + 12365;
        return $id;
    }
    static function unHash($id){
        if (intval($id)==0)
            return 0;
        $id= ((((intval($id) - 12365) + 9) - 147) / 53) ;
        return $id;
    }

    /**/
    static function jsonDecode($str){
        $str=stripcslashes($str);
        $str= json_decode($str);
        if(is_string($str))
            return json_decode($str);
        else
            return $str;
    }

    /**/
    static function excerpt($str,$len,$extend='...'){
        if(strlen($str) >= $len)
            return mb_substr($str,0,$len,"utf-8").' '.$extend;
        return $str;
    }

    /**/
    static function rand($length=7){
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'), str_split(time()));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    /**/
    static function getSuffix($name){
        $arr = explode('.',$name);
        return end($arr);
    }


}
