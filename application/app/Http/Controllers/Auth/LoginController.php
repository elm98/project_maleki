<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*صفحه ورود*/
    function login(Request $request){
        return view('back-end.login');
    }

    /*عملیات خروج*/
    function logout(Request $request){
        $action=$request->input('action','normal');
        if(Auth::check()){
            Auth::logout();
            if($action=='from-panel')
                return redirect('/login');
            else
                return redirect('/');
        }else{
            return 'Error! : you not log in';
        }
    }
}
