<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Category;
use App\Models\Comment;
use App\Models\FirstPage;
use App\Models\Option;
use App\Models\Post;
use App\Models\ShopProduct;
use App\Models\ShopStore;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class DashboardController extends Controller
{
    /*دخیره تغییرات استایل قالب ادمین*/
    function access_denied(Request $request){
        return view('back-end.access_denied');
    }

    /**/
    function dashboard(Request $request){
       return view('back-end.index');
    }


    /**/
    function chart(){
        $data=[];
        $v=new Verta();
        $year=$v->year;
        $mon=$v->month;
        $dates_a=$this->monthRange(5); /*امسال*/
        $dates_b=$this->monthRange(5,toMiladi(($year-1)."/$mon/01")); /*پارسال*/
        $series_a=[];
        $series_b=[];
        $labels=[];
        foreach ($dates_a as $key=>$item){
            $series_a[]=User::whereBetween('created_at',[toMiladi($item['from']),toMiladi($item['to'])])->count();
            $series_b[]=User::whereBetween('created_at',[toMiladi($dates_b[$key]['from']),toMiladi($dates_b[$key]['to'])])->count();
            $labels[]=explode(' ',$item['label'])[0];
        }
        $data['user']=[
            'a'=>$series_a,
            'b'=>$series_b,
            'labels'=>$labels,
            'max_a'=>User::whereBetween('created_at',[toMiladi($year."/01/01"),toMiladi(($year+1)."/01/01")])->count(),
            'max_b'=>User::whereBetween('created_at',[toMiladi(($year-1)."/01/01"),toMiladi(($year)."/01/01")])->count(),
        ];
        return ['result'=>1,'data'=>$data];
    }

    /*تاریخ به ماه چند ماه گذشته*/
    function monthRange($number,$startDate=''){
        $dates=[];
        $startDate = empty($startDate)?time():$startDate;
        $v= new Verta($startDate);
        for($i=0;$i<=$number;$i++){
            $d = $v->subMonth($i);
            $from = $d->year.'-'.$d->month.'-1'.' 00:01:01';
            $d->endMonth();
            $to = $d->year.'-'.$d->month.'-'.$d->day.' 23:59:59';
            $dates[]=[
                'from'=>$from,
                'to'=>$to,
                'label'=>$d->format('F Y')
            ];
        }
        return array_reverse($dates);
    }

    /**/
    function elementor(Request $request){
        $action = $request->input('action','');
        switch ($action){
            case 'hjuiyu':
                return $this->chart();
                break;
            default:
                return view('back-end.elementor');
        }
    }



}
