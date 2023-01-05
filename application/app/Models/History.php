<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table='history';
    protected $guarded=[];

    /*علت*/
    static function relate_to($e=''){
        $data=[
            'order_status'=>'تغییر وضعیت فاکتور',

        ];
        return Option::fieldItems($data,$e);
    }

}
