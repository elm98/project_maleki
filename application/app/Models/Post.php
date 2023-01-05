<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Post extends Authenticatable
{
    protected $table='post';
    protected $guarded=[];

    function get_val($key){
        if($this){
            if(isset($this->$key)){
                return $this->$key;
            }
        }
        return '';
    }

    /*status*/
    static function status($e=''){
        $data=[
            'active'=>'فعال',
            'inactive'=>'غیر فعال',
            'draft'=>'پیش نویس',
        ];
        return Option::fieldItems($data,$e);
    }

    /*type*/
    static function type($e=''){
        $data=[
            'post'=>'مطلب',
            'page'=>'صفحه',
            'portfolio'=>'نمونه کار',
        ];
        return Option::fieldItems($data,$e);
    }
}
