<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\History;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class HistoryController extends Controller
{
    function history_list(){
        return view('back-end.history_list');
    }

    /**/
    function history_list_dt(Request $request){
        $relate_to=$request->input('relate_to','all');
        $user_id=$request->input('user_id',0);

        $data=History::leftJoin('users','users.id','history.user_id')
            ->where(function ($q) use($relate_to){
                return in_array($relate_to,[null,'','all','0'])
                    ? 1
                    : $q->where('history.relate_to',$relate_to);
            })

            ->where(function ($q) use($user_id){
                return in_array($user_id,[null,'','all','0'])
                    ? 1
                    : $q->where('history.user_id',unHashId($user_id));
            })
            ->where(function ($q)use($request){
                $date1=toMiladi($request->input('date1'),'00:01:01');
                if(!empty($date1))
                    return $q->where('history.created_at','>=',$date1);
                return 1;
            })
            ->where(function ($q)use($request){
                $date2=toMiladi($request->input('date2'),'23:59:59');
                if(!empty($date2))
                    return $q->where('history.created_at','<=',$date2);
                return 1;
            })
            ->select('history.*','users.nickname','users.avatar');
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('nickname',function ($data){
            $html= '<div class="chip black-text "><img src="'.Helper::getAvatar($data->avatar).'"> '.$data->nickname.'<span></span></div>';
            $html.= '<br/><span class="font-small">شناسه : '.$data->id.'</span>';
            return $html;
        });
        $dt->editColumn('relate_to',function ($data){
            return '<span class="no-break">'.History::relate_to($data->relate_to).'<br/><span class="font-small blue-text ">با شناسه  : '.$data->relate_id.'</span></span>';
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDateTime($data->created_at).'</span>';
        });
        $dt->addColumn('action', function ($data) {
            //$html='<a href="'.url('/management/edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'transaction-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /*حذف */
    function history_delete(Request $request){
        $foo=$request->input('foo');
        if(History::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست حذف انجام شد ، دقت کنید عواقبی مانند عدم تطبیق اعداد یا کسری در گزارشات و یا هر مشکل دیگری بر عهده شخص حذف کننده میباشد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }



}
