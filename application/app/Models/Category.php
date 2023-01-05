<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='categories';
    protected $guarded=[];
    public $timestamps=true;

    public static function status($e=''){
        $data=[
            'active'=>'فعال',
            'inactive'=>'غیر فعال',
        ];
        return Option::fieldItems($data,$e);
    }

    /*خواندن لیست و ساخت درخت*/
    function item_read($parent_id,$type,$group_id=0){
        $list=[];
        $q=Category::where('type',$type)
            ->where('group_id',$group_id)
            ->where('parent_id',$parent_id)
            //->where('status','active')
            ->orderby('sort','asc')
            ->get();
        if($q->count()){
            foreach ($q as $item){
                $list[]=[
                    'id'=>intval($item->id),
                    'title'=>$item->title,
                    'children'=>$this->item_read($item->id,$type,$group_id)
                ];
            }
        }
        return $list;
    }

    /*بروز رسانی برگشتی همه ایتمهای موجود*/
    function item_release($json,$parent_id,$type,$group_id){
        $arr=$json;
        $sort=0;
        if(is_array($arr) && count($arr)>0){
            foreach ($arr as $object) {
                $sort++;
                if($object->id == 0){
                    $object->id=$this->item_insert($object,$parent_id,$type,$group_id,$sort);
                }else{
                    $this->item_update($object,$parent_id,$type,$group_id,$sort);
                }
                if(isset($object->children)) {
                    $this->item_release($object->children,$object->id,$type,$group_id);
                }
            }
        }
    }

    /*کمکی درج*/
    function item_insert($obj,$parent_id,$type,$group_id,$sort){
        $id=Category::insertGetId([
            'title'=>$obj->title,
            'parent_id'=>$parent_id,
            'type'=>$type,
            'group_id'=>$group_id,
            'sort'=>$sort,
        ]);
        return $id;
    }

    /*کمکی ویرایش*/
    function item_update($obj,$parent_id,$type,$group_id,$sort){
        Category::where('id',$obj->id)->update([
            'title'=>$obj->title,
            'parent_id'=>$parent_id,
            'type'=>$type,
            'group_id'=>$group_id,
            'sort'=>$sort,
        ]);
        return true;
    }

    /*نماش لیست درختی*/
    static function array_tree($type,$group_id,$parent_id=0){
        $list=Category::where('type',$type)
            ->where('group_id',$group_id)
            ->where('status','active')
            ->where('parent_id',$parent_id)
            ->orderby('sort','asc')
            ->get();
        $arr=[];
        if($list->count()){
            foreach ($list as $item){
                $arr[]=[
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'children'=>self::array_tree($type,$group_id,$item->id)
                ];
            }
        }
        return $arr;
    }

    /******************
        Helper
    ******************/
    static function get_cat($type,$parent_id=0){
        $list=Category::where('type',$type)
            ->where('parent_id',$parent_id)
            ->where('group_id',0)
            ->where('status','active')
            ->orderby('sort','asc')
            ->select('*')
            ->get();
        return $list;
    }

    /*خروجی بصورت اچ تی ام سلکت باکس*/
    static function get_cat_html($type,$parent_id=0){
        $list = self::get_cat($type,$parent_id);
        $html='';
        if($list->count()){
            foreach ($list as $item){
                $html.='<option value="'.$item->id.'">'.$item->title.'<option>';
            }
        }else{
            $html='<option value="0">هیچ موردی یافت نشد</option>';
        }
        return $html;
    }

    /*نماش لیست درختی فقط محصولات*/
    static function productCategory($parent_id,$parentIdsString=''){
        if($parent_id < 1){
            $parent_ids = [];
        }else{
            $parent_ids = !empty($parentIdsString)?explode(',',$parentIdsString):[];
            $parent_ids[] = $parent_id;

        }
        $parentIdsString = count($parent_ids)?implode(',',$parent_ids):'';
        $list=Category::where('type','product')
            ->where('group_id',0)
            ->where('status','active')
            ->where('parent_id',$parent_id)
            ->orderby('sort','asc')
            ->get();
        $arr=[];
        if($list->count()){
            foreach ($list as $item){
                $arr[]=[
                    'id'=>$item->id,
                    'parent_id'=>$item->parent_id,
                    'title'=>$item->title,
                    'parent_ids'=>$parentIdsString.(empty($parentIdsString)?$item->id:','.$item->id),
                    'img'=>$item->img,
                    'thumb'=>$item->thumb,
                    'icon'=>$item->icon,
                    'class'=>$item->class,
                    'url'=>$item->url,
                    'value'=>$item->value,
                    'link'=>getLink('cat',$item),
                    'children'=>self::productCategory($item->id,$parentIdsString)
                ];
            }
        }
        return $arr;
    }


}
