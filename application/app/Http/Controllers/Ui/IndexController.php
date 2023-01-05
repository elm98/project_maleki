<?php

namespace App\Http\Controllers\Ui;;

use App\Models\Favorite;
use App\Models\FirstPage;
use App\Models\Option;
use App\Models\ShopBrand;
use App\Models\ShopInvoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{

    /**/
    function index(Request $request){
        return redirect('/login');
    }

    /**/
    function _404(){
        return view('front-end.404');
    }

}
