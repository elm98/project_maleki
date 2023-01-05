<?php

namespace App\Http\Controllers\Ui;

use App\Models\Option;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class AppController extends Controller
{
    static function getView($name){
        $them_name = session('appek_them_name');
        if(empty($them)){
            $them_name = Option::getval('theme','default');
            session(['appek_them_name'=>$them_name]);
        }
        $v= "front-end.$them_name.$name";
        if (View::exists($v))
            return $v;
        else
            return 'front-end.404';
    }

}
