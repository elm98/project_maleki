<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $table='redirect';
    protected $guarded=[];

    /*نوع انتقال*/
    static function type($e=''){
        $data=[
            '301'=>'301',
            '302'=>'302',
            '307'=>'307',
            '404'=>'404',
        ];
        return Option::fieldItems($data,$e);
    }



}
