<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;

class CatController extends Controller
{

    /*************************
     MAIN ACTION
     *************************/
    /*دسته بندی درختی*/
    function my_menu(Request $request){
        $action=$request->input('action','show');
        if ($action == 'detail'){
            return $this->menu_cat_detail($request);
        }elseif ($action == 'detail-update'){
            return $this->menu_cat_detail_update($request);
        }else{
            $pageName = $request->input('pageName');
            $type=$request->input('type');
            $group_id=0;
            $C=new Category();
            $data=json_encode($C->item_read(0,$type,$group_id));
            return view("back-end.$pageName",compact(
                'data',
                'type',
                'group_id',
            ));
        }
    }

    /*نمایش جزییات دسته از منو*/
    function menu_cat_detail(Request $request){
        $id=$request->input('id');
        $data=Category::find($id);
        if($data)
            return ['result'=>1,'data'=>$data];
        else
            return ['result'=>0,'msg'=>'آیتمی شناسایی نشد'];
    }

    /*بروز رسانی جزییات دسته از منو*/
    function menu_cat_detail_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'title'=>'required'
        ]);
        $item=Category::find($request->input('id'));
        $item->img=$request->input('img','');
        $item->title=$request->input('title');
        $item->value=$request->input('value');
        $item->class=$request->input('class');
        $item->icon=$request->input('icon');
        $item->url=$request->input('url');
        $item->status=$request->input('status','active');
        if($item->save())
            return ['result'=>1,'msg'=>'درخواست انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباره امتحان کنید'];
    }

    /*بروز رسانی همه لیست جیسون منو*/
    function menu_all_update(Request $request){
        $this->validate($request,[
            'json'=>'required',
            'type'=>'required',
        ]);
        $json=$request->input('json');
        $json=stripcslashes($json);
        $arr=json_decode($json);
        $type=$request->input('type');
        $group_id=$request->input('group_id',0);
        $C=new Category();
        $C->item_release($arr,0,$type,$group_id);
        return ['result'=>1,'msg'=>'بروز رسانی انجام شد'];
    }

    /********************
     DELETE ACTIONS
    ********************/
    /*خذف شاخه همراه با زیر شاخه ها*/
    function index_menu_delete(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:categories,id',
        ]);
        $id=$request->input('id');
        $ids=Category::where('parent_id',$id)
            ->pluck('id')
            ->toArray();
        $ids[]=$id;

        /*-----------------
        اگر میخواید شرطی بنویسید در اینجا قرار میگیرد
         --------------*/

        if(Category::whereIn('id',$ids)->delete()){
            return ['result'=>1,'msg'=>'عملیات حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباه تلاش کنید'];
    }


    /**/
    function cat_edit($id){
        return view('back-end.cat-edit',compact('id'));
    }

    /**/
    function cat_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'title'=>'required'
        ]);
        $hash_id = $request->input('id');
        $id = unHashId($hash_id);
        $item=Category::find($id);
        $item->img=$request->input('img','');
        $item->thumb=$request->input('thumb','');
        $item->title=$request->input('title');
        $item->value=$request->input('value');
        $item->class=$request->input('class');
        $item->icon=$request->input('icon');
        $item->seo_title=$request->input('seo_title','');
        $item->seo_description=$request->input('seo_description','');
        $item->url=textClear($request->input('url',''));
        $item->status=$request->input('status','active');
        $item->description=$request->input('description','');
        $item->cat_property=$request->input('cat_property',0);
        if($item->save())
            return ['result'=>1,'msg'=>'درخواست انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباره امتحان کنید'];
    }

}
