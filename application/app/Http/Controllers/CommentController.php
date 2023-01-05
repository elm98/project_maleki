<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Comment;
use App\Models\Locate;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    /**/
    function comment_list(){
        return view('back-end.comment_list');
    }

    /**/
    function comment_list_dt(Request $request){
        $relate_to=$request->input('relate_to','all');
        $status=$request->input('status','all');
        $parent_id=$request->input('parent_id',0);
        $user_id = $request->input('user_id',0);
        $data=Comment::leftJoin('comment as parent','parent.id','comment.parent_id')
            ->where(function ($q) use($status){
                return in_array($status,[null,'','all','0'])
                    ? 1
                    : $q->where('comment.status',$status);
            })
            ->where(function ($q) use($parent_id){
                return in_array($parent_id,[null,'','all','0',0])
                    ? 1
                    : $q->where('comment.parent_id',Helper::unHash($parent_id));
            })
            ->where(function ($q) use($user_id){
                return in_array($user_id,[null,'','all','0',0])
                    ? 1
                    : $q->where('comment.user_id',$user_id);
            })
            ->where(function ($q)use($status){
                if($status != 'trash')
                    return $q->whereNotIn('comment.status',['trash']);
                else
                    return $q->where('comment.status','trash');
            })
            ->where(function ($q)use($relate_to){
                if($relate_to == 'all')
                    return 1;
                else
                    return $q->where('comment.relate_to',$relate_to);
            })
            ->where(function ($q)use($request){
                $date = $request->input('date1');
                if(!empty($date))
                    return $q->where('comment.created_at','>=',toMiladi($date,'00:01:01'));
                return 1;
            })
            ->where(function ($q)use($request){
                $date = $request->input('date2');
                if(!empty($date))
                    return $q->where('comment.created_at','<=',toMiladi($date,'23:59:59'));
                return 1;
            })
            ->select('comment.*',
                'parent.id as parentId',
                'parent.nickname as parent_nickname',
                'parent.content as parent_content'
            );
        $dt=Datatables::of($data);

        /*****************field*******************/
        $dt->addColumn('checked', '<label><input type="checkbox" name="foo[]" value="{{$id}}" class="dt-row-checkbox"><span></span></label>');
        $dt->editColumn('nickname',function ($data){
            return '<div class="chip black-text "><img src="'.Helper::getAvatar('').'"> '.$data->nickname.'<span></span></div>';
        });
        $dt->editColumn('status',function ($data){
            return Helper::status_color($data->status,Comment::status($data->status));
        });
        $dt->editColumn('content',function ($data){
            if(!empty($data->parentId) || $data->parentId > 0){
                $html='<span class="multiline" title="'.$data->content.'">'.excerpt($data->content,30).'</span>';
                $html.='<hr color="#eee" style="height: 0px" />';
                $html.='<span class="font-very-small teal-text multiline"> در جواب </span>';
                $html.='<a href="'.url('/management/comment-edit/'.hashId($data->parentId)).'" target="_blank" class="font-small black-text" title="'.$data->parent_content.'">'.excerpt($data->parent_content,20).'</span>';
                return $html;
            }
            return '<span class="multiline">'.Helper::excerpt($data->content,20).'<a class="font-very-small" href="'.url('/management/comment-list?parent_id='.hashId($data->id)).'" target="_blank"> همه پاسخ های من </a></span>';
        });
        $dt->editColumn('created_at',function ($data){
            return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDate2($data->created_at).'</span>';
        });
        $dt->addColumn('type',function ($data){
            $str=$data->user_id > 0?Helper::status_color_bullet('is_user',"عضو سایت"):Helper::status_color_bullet('is_guest',"مهمان");
            return '<span>'.$str.'</span>';
        });
        $dt->addColumn('action', function ($data) {
            $html='<a href="'.url('/management/comment-edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
            $html.='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'comment-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
            return  $html;
        });
        return $dt->escapeColumns(null)->make(true);
    }

    /**/
    function comment_trash_list(){
        return view('back-end.comment_trash_list');
    }

    /**/
    function comment_edit($id){
        $comment=Comment::find(unHashId($id));
        if ($comment){
            $answer_list=Comment::where('parent_id',$comment->id)->get();
            return view('back-end.comment_edit',compact('comment','answer_list'));
        }
        return redirect()->back()->with(['error'=>'دیدگاه پیدا نشد']);
    }

    /**/
    function comment_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'content'=>'required',
            'status'=>'required',
        ],[
            'content.required'=>'متن دیدگاه نمیتواند خالی باشد',
            'status.required'=>'وضعیت را انتخاب نمایید',
        ]);

        $id=Helper::unHash($request->input('id'));
        $content=$request->input('content');
        $replay_text=$request->input('replay_text');
        $comment=Comment::find($id);
        $comment->content = $content;
        $comment->status=$request->input('status');
        $comment->save();
        if(!empty($replay_text)){
            $user=auth()->user();
            $arr=[
                'relate_to'=>'post',
                'relate_id'=>$comment->relate_id,
                'user_id'=>$user->id,
                'nickname'=>$user->nickname,
                'email'=>$user->email,
                'mobile'=>$user->mobile,
                'content'=>$replay_text,
                'status'=>'active',
                'parent_id'=>$comment->id,
                'edit_by'=>$user->id,
                'created_at'=>Carbon::now(),
            ];
            Comment::insert($arr);
        }
        return ['result'=>1,'msg'=>'ذخیره تغییرات با موفقیت انجام شد'];
    }

    /**/
    function comment_trashed($id,$list_address='comment-list'){
        $id=Helper::unHash($id);
        $comment=Comment::find($id);
        $comment->status='trash';
        $comment->save();
        return redirect()->intended('/management/'.$list_address)->with(['success'=>'دیدگاه به سطل زباله منتقل شد']);
    }

    /**/
    function comment_restore($id,$list_address='comment-list'){
        $id=Helper::unHash($id);
        $comment=Comment::find($id);
        $comment->status='active';
        $comment->save();
        return redirect()->intended('/management/'.$list_address)->with(['success'=>'دیدگاه بازیابی شد']);
    }

    /**/
    function comment_delete(Request $request){
        $foo=$request->input('foo');
        if(Comment::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }

}
