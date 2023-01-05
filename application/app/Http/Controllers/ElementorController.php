<?php

namespace App\Http\Controllers;

use App\Helper\AccessController;
use App\Helper\Helper;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Elementor;
use App\Models\ElementorItem;
use App\Models\FirstPage;
use App\Models\Option;
use App\Models\Post;
use App\Models\ShopProduct;
use App\Models\ShopStore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ElementorController extends Controller
{
    /**/
    function get_list(Request $request){
        $page_name = $request->input('page_name','index');
        $data =  $this->item_read(0,$page_name);
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function save_list(Request $request){
        $json_list = $request->input('list','{}');
        $list = json_decode($json_list);
        //dd($list);
        $page_name = $request->input('page_name','index');
        $template_name = Option::getval('template_name','default');
        foreach ($list as $rowKey=>$row){
            //$row = json_decode($row);
            //dd($row->child);
            $row->id = $this->release($row,0,$page_name,$template_name);
            if(isset($row->child)){
                foreach ($row->child as $colKey=>$col){
                    //$col = json_decode($row);
                    //dd($col->id);
                    $col->id = $this->release($col,$row->id,$page_name,$template_name);
                    if(isset($col->child)){
                        foreach ($col->child as $wKey=>$widget){
                            //$widget = json_decode($widget);
                            $this->release($widget,$col->id,$page_name,$template_name);
                        }
                    }
                }
            }
        }
        return ['result'=>1,'msg'=>'بروز رسانی با موفقیت انجام شد'];
    }

    /*خواندن لیست و ساخت درخت*/
    function item_read($parent_id,$pageName){
        $list=[];
        $template_name = Option::getval('template_name','default');
        $q=Elementor::where('parent_id',$parent_id)
            ->where('status','active')
            ->where('template_name',$template_name)
            ->where('page_name',$pageName)
            ->orderby('sort','asc')
            ->get();
        if($q->count()){
            foreach ($q as $item){
                $list[]=[
                    'id'=>intval($item->id),
                    'name'=>$item->name,
                    'title'=>$item->title,
                    'parent_id'=>intval($item->parent_id),
                    'setting'=>!empty($item->setting)?json_decode($item->setting):[],
                    'params'=>!empty($item->params)?json_decode($item->params):[],
                    'template_name'=>$item->template_name,
                    'page_name'=>$item->page_name,
                    'type'=>$item->type,
                    'sort'=>intval($item->sort),
                    'status'=>$item->status,
                    'deleted'=>'no',
                    'child'=>$this->item_read($item->id,$pageName)
                ];
            }
        }
        return $list;
    }

    /*بروز رسانی و درج*/
    function release($item,$parent_id,$page_name,$template_name='default'){
        $arr = [
            'parent_id'=>$parent_id,
            'name'=>isset($item->name)?$item->name:'',
            'title'=>isset($item->title)?$item->title:'',
            'setting'=>isset($item->setting)?json_encode($item->setting,JSON_UNESCAPED_UNICODE):'',
            'params'=>isset($item->params)?json_encode($item->params,JSON_UNESCAPED_UNICODE):'',
            'template_name'=>$template_name,
            'page_name'=>$page_name,
            'type'=>$item->type,
            'sort'=>isset($item->sort)?$item->sort:0,
            'status'=>'active',
        ];
        if($item->id == 0){
            $item->id = Elementor::insertGetId($arr);
        }else{
            Elementor::where('id',$item->id)->update($arr);
        }
        return $item->id;
    }

    /**/
    function delete_item(Request $request){
        $id = $request->input('id');
        $del2 = Elementor::where('parent_id',$id)->pluck('id')->toArray();
        $del3 = Elementor::whereIn('parent_id',$del2)->pluck('id')->toArray();
        $ids = array_merge((array)$id,$del2,$del3);
        $ElemItemIds = ElementorItem::whereIn('elementor_id',$ids)->pluck('id')->toArray();
        if(Elementor::whereIn('id',$ids)->delete()){
            ElementorItem::whereIn('id',$ElemItemIds)->delete();
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره دوباره تلاش کنید'];
    }

    /**/
    function widget_reader(){
        $widgets=[];
        $template_name = Option::getval('template_name','default');
        $path = resource_path()."/views/front-end/$template_name/widgets";
        $directories=array_filter(glob("$path/*"), 'is_dir');
        foreach ($directories as $key=>$directory){
            $e=explode("/",$directory);
            $folder = end($e);
            $file_info = glob($directory.'/info.json');
            $file_icon = glob($directory.'/icon.png');
            if(count($file_info)){
                $json=json_decode(file_get_contents($file_info[0]));
                $icon = url('/')."/application/resources/views/front-end/$template_name/widgets/$folder/icon.png";
                $json->icon = count($file_icon)?$icon:'';
                $json->folder = $folder;
                $widgets[] = $json;
            }
        }
        return ['result'=>1,'data'=>$widgets];

    }


    /**/
    function elementor_item(Request $request){
        $id = $request->input('id',0);
        if($id == 0){
            $data=new \classEmpty();
            $data->id=0;
            $data->relate_to='link';
            $data->sort=0;
            $data->link='#';

        }else{
            $data=ElementorItem::find($id);
            if($data->relate_to == 'post'){
                $r=Post::find($data->relate_id);
                $data->relate_item=$r?$r->title:'نامشخص';
            }elseif ($data->relate_to == 'shop'){
                $r=ShopStore::find(unHashId($data->relate_id));
                $data->relate_item=$r?$r->title:'نامشخص';
            }elseif ($data->relate_to == 'product'){
                $r=ShopProduct::find(unHashId($data->relate_id));
                $data->relate_item=$r?$r->title:'نامشخص';
            }elseif ($data->relate_to == 'category'){
                $r=Category::find($data->relate_id);
                $data->relate_item=$r?$r->title:'نامشخص';
            }elseif ($data->relate_to == 'comment'){
                $r=Comment::find($data->relate_id);
                $data->relate_item=$r?Helper::excerpt($r->content,20).'...':'نامشخص';
            }else{
                $data->relate_item='نامشخص';
            }
        }
        return  view('back-end.elementor-item',compact('data'));

    }

    /**/
    function elementor_item_update(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'elementor_id'=> 'required|numeric|min:1',
            'sort'=>    'required',
        ],[
            'elementor_id.required'=>'شناسه ابزارک  را انتخاب کنید',
            'elementor_id.min'=>' ابزارکی برای بروز رسانی پیدا نشد ، ابتدا یکبار صفحه را ذخیره کنید',
            'sort.required'=>'ترتیب را مشخص کنید',
        ]);
        $id=$request->input('id');
        $elementor_id = $request->input('elementor_id');
        $relate_to=$request->input('relate_to','');
        $relate_id=$request->input('relate_id',0);
        $link=$request->input('link','');
        $sort=$request->input('sort',0);
        $findSimpleSort=ElementorItem::where('elementor_id',$elementor_id)->where('sort',$sort)->whereNotIn('id',[$id])->count();
        if($findSimpleSort){
            return ['result'=>0,'msg'=>'شماره های ترتیب آیتم های مشابه نباید شبیه هم باشد '];
        }
        $sort_list=ElementorItem::where('elementor_id',$elementor_id)
            ->orderby('sort','desc')
            ->limit(1)
            ->get();
        $last_sort=$sort_list->count()?$sort_list->first()->sort:1;
        if(empty($link) && empty($relate_to))
            return ['result'=>0,'msg'=>'محتوا انتخاب نشده'];
        $arr=[
            'elementor_id'=>$elementor_id,
            'title'=>$request->input('title',''),
            'description'=>$request->input('description',''),
            'img'=>$request->input('img',''),
            'thumb'=>$request->input('thumb',''),
            'relate_to'=>$relate_to,
            'relate_id'=>$relate_id,
            'link'=>$link,
            'sort'=>$sort?$sort:$last_sort + 1,
            'status'=>$request->input('status'),
            'content'=>$request->input('content',''),
        ];
        if($id == 0){
            $arr['created_at']=Carbon::now();
            ElementorItem::insert($arr);
        }else{
            $arr['updated_at']=Carbon::now();
            ElementorItem::where('id',$id)->update($arr);
        }
        return ['result'=>1,'msg'=>'عملیات با موفقیت انجام شد'];
    }

    /*حذف */
    function elementor_item_delete(Request $request){
        $this->validate($request,[
            'foo'=>'required|array',
        ]);
        //$foo=array_map(function ($a){return unHashId($a);},$request->input('foo',[]));
        $foo=$request->input('foo',[]);
        if(ElementorItem::whereIn('id',$foo)->delete()){
            return ['result'=>1,'msg'=>'درخواست حذف با موفقیت انجام شد'];
        }
        return ['result'=>0,'msg'=>'خطای غیر منتظره ، دوباره تلاش کنید'];
    }


}
