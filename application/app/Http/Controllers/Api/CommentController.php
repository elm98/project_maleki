<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**/
    function newComment(Request $request){
        $c=new \App\Http\Controllers\Ui\CommentController();
        $poll_item = $request->input('poll_item',[]);
        $new_poll_item = [];
        if(count($poll_item)){
            foreach ($poll_item as $key=>$value){
                $new_poll_item[]=[
                    $key=>$value
                ];
            }
            $request->request->add(['poll_item'=>$new_poll_item]);
        }
        return $c->save_comment($request);
    }

    /**/
    function save_question(Request $request){
        $c=new \App\Http\Controllers\Ui\QuestionController();
        return $c->save_question($request);
    }



}
