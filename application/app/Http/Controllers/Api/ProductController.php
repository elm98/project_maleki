<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Notify;
use App\Models\Option;
use App\Models\ShopBrand;
use App\Models\ShopColor;
use App\Models\ShopCustomValue;
use App\Models\ShopProduct;
use App\Models\ShopSize;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**/
    function products(Request $request){
        $orderBy = $request->input('orderBy','created_at|desc');
        $orderBy2 = $request->input('orderBy2','created_at|desc');
        $ids = $request->input('ids','');
        $param=[
            'page'=>$request->input('page',1),
            'per_page'=>$request->input('per_page',16),
            'user_id'=>$request->input('user_id',0),
            'price_from'=>intval($request->input('price_from',0)),
            'price_to'=>intval($request->input('price_to',0)),
            'cat_id'=>intval($request->input('cat_id')),
            'brands'=>array_filter(array_map(function ($a){return intval($a);},explode(',',$request->input('brands','')))),
            'colors'=>array_filter(array_map(function ($a){return intval($a);},explode(',',$request->input('colors','')))),
            'size'=>$request->input('size',0),
            'orderBy'=>!empty($orderBy)?explode('|',$orderBy):'',
            'orderBy2'=>!empty($orderBy2)?explode('|',$orderBy2):'',
            'is_count'=>intval($request->input('is_count',0)),
            'is_discount'=>intval($request->input('is_discount',0)),
            'tag'=>$request->input('tag',''),
            'ids'=>!empty($ids)?explode(',',$ids):[],
            'term'=>$request->input('term',''),
            'in_festival'=>intval($request->input('in_festival',0)),
            'in_vip'=>intval($request->input('in_vip',0)),
        ];
        //return $param;
        $data=getProductList($param);
        $max_price = DB::table('shop_stock')->max('customer_price');
        return['result'=>1,'data'=>$data,'max_price'=>$max_price];
    }

    /*لیست دسته محصولات*/
    function get_category(Request $request){
        $parent_id = $request->input('parent_id');
        $parent = Category::find($parent_id);
        $list = getCatApi($parent_id,'product');
        collect($list)->map(function ($a){
            $a['img'] = url('uploads/media/'.$a['img']);
            $a['slug'] = $a['url'];
            return $a;
        });
        return [
            'result' => 1,
            'data' => $list,
            'parent'=>$parent,
        ];
    }

    /**/
    function get_brands(Request $request){
        $cat_id = intval($request->input('cat_id',0));
        $list = ShopBrand::where(function ($q)use ($cat_id){
           if($cat_id > 0){
               return $q->whereRaw("FIND_IN_SET($cat_id,ms011_shop_brand.cats)")->get();
           }
           return 1;
        })
        ->get();
        return ['result' => 1, 'data' => $list];
    }

    /**/
    function get_sizing(Request $request){
        $cat_id = intval($request->input('cat_id',0));
        $list = ShopSize::where(function ($q)use ($cat_id){
            if($cat_id > 0){
                return $q->whereRaw("FIND_IN_SET($cat_id,ms011_shop_size.cats)")->get();
            }
            return 1;
        })
        ->get();
        return ['result' => 1, 'data' => $list];
    }

    /**/
    function get_colors(Request $request){
        $list = ShopColor::all();
        return ['result' => 1, 'data' => $list];
    }

    /**/
    function product_info(Request $request){
        $validator = Validator::make($request->all(),[
            'product_id'=>'required|exists:shop_products,id'
        ],[
            'product_id.required'=>'شناسه محصول پیدا نشد',
            'product_id.exists'=>'شناسه محصول معتبر نیست',
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>0,'msg'=>$validator->messages()->first()]);
        }
        $product_id = $request->input('product_id');
        $user_id = $request->input('user_id',0);
        $info=getProductInfo($product_id,$user_id);
        $e = explode('/',$info['product']->img);
        $info['product']->image_only = end($e);
        $info['product']->description = strip_tags(html_entity_decode($info['product']->description));
        $info['product']->img = empty($info['product']->img)?url('/back/custom/img/no-image.png'):url('/'.$info['product']->img);
        $images = glob(basePath().'/uploads/product/'.$product_id.'_gallery*.*');
        $image_gallery = array_map(function($a){
            $e=explode('/',$a);
            return url('/uploads/product/'.end($e));
        },$images);
        $info['product']->image_gallery = $image_gallery;
        /**********Action view************/
        /*if(1){
            $product->view_count = $product->view_count + 1;
            $product->save();
        }*/

        $brand=ShopBrand::find($info['product']['brand']);
        $image_list = glob(basePath().'/uploads/product/'.$product_id.'_gallery*.*');
        $images = count($image_list)?array_map(function ($a){
            $e = explode('/',$a);
            return url('/uploads/product/'.end($e));
        },$image_list):[];
        $custom_field = DB::table('shop_custom_field')
            ->where('shop_custom_field.cat_id',$info['product']['cat_property'])
            ->orderby('shop_custom_field.sort', 'asc')
            ->select('shop_custom_field.*')
            ->get();
        $v=ShopCustomValue::whereIn('custom_field_id',$custom_field->pluck('id')->toArray())
            ->where('product_id',$product_id)
            ->get();
        foreach ($custom_field as $key=>$item){
            $find = $v->where('custom_field_id',$item->id);
            if($find->count()){
                $custom_field[$key]->value = $find->first()->value;
            }else{
                $custom_field[$key]->value = '';
            }
        }

        $stock = $info['stock'];
        /*پبدا کردن تنوع پیش فرض*/
        $selective = [];
        foreach ($stock as $item){
            if($item['count'] > 0 && $item['customer_price'] > 0){
                $selective = $item;
                break;
            }
        }
        $stock_entity = array_filter(array_map(function ($a){return $a['count']>0?$a['store_id']:0;},$stock));
        $customer_price = isset($selective['customer_price'])?$selective['customer_price']:0;
        $real_price = isset($selective['real_price'])?$selective['real_price']:0;
        $in_stock = isset($selective['count']) && $selective['count'] > 0 ?'instock':'outofstock';

        return ['result'=>1,'data'=>[
            'info'=>$info,
            'product_id'=>$product_id,
            'brand'=>$brand,
            'custom_field'=>$custom_field,
            'images'=>$images,
            'stock_entity'=>$stock_entity,
            'torob'=>[
                'customer_price'=>$customer_price,
                'real_price'=>$real_price,
                'in_stock'=>$in_stock,
            ]
        ]];
    }

    /**/
    function product_comment(Request $request,$product_id){
        $per_page = $request->input('per_page',15);
        $comments=Comment::where('comment.relate_to','product')
            ->where('comment.relate_id',$product_id)
            ->where('comment.status','active')
            ->orderby('comment.created_at','desc')
            ->groupby('comment.id')
            ->select('comment.*')
            ->paginate($per_page);
        foreach ($comments as $key=>$comment){
            $comments[$key]->created_at_fa = alphaDateTime($comment->created_at);
            $comments[$key]->weakness = !empty($comment->weakness)?json_decode($comment->weakness,JSON_UNESCAPED_UNICODE):[];
            $comments[$key]->strength = !empty($comment->strength)?json_decode($comment->strength,JSON_UNESCAPED_UNICODE):[];
        }
        $product = ShopProduct::find($product_id);
        return ['result'=>1,'data'=>$comments,'product'=>$product];
    }

    /*سرویس مخصوص ترب*/
    function torob(Request $request){
        //return $request->input('page',1);
        $param=[
            'cat_id'=>intval($request->input('cat_id')),
            'term'=>$request->input('term',''),
            'page'=>$request->input('page',1),
            'per_page'=>$request->input('per_page',100),
            //'brands'=>array_filter(array_map(function ($a){return intval($a);},explode(',',$request->input('brands',[])))),
            //'colors'=>array_filter(array_map(function ($a){return intval($a);},explode(',',$request->input('colors',[])))),
            'is_count'=>intval($request->input('is_count',0)),
            'is_discount'=>intval($request->input('is_discount',0)),
            'price_from'=>intval($request->input('price_from',0)),
            'price_to'=>$request->input('price_to'),
            'tag'=>$request->input('tag',''),
            'orderBy'=>explode('|',$request->input('orderBy','created_at|desc')),
        ];
        $list=getProductList($param);
        //dd($list);
        $data=[];
        foreach ($list as  $ke=>$item){
            $cat = Category::find(explode(',',$item->cats_select)[0]);
            $data['products'][]=[
                'product_id' => $item->id,
                'page_unique'=>$item->id,
                'title' => $item->title,
                'subtitle' => $item->title_en,
                'page_url' => $item->link ,
                'image_link'=>url($item->img),
                'current_price' => $item->customer_price,
                'old_price' => $item->stock_price,
                'availability' => $item->stock_count > 0?'instock':'outstock', //instock - outstock;
                'category_name'=>$cat?$cat->title:'' ,
                'short_desc'=>$item->description,
                'stock_id'=>$item->stock_id,
                //'registry'=>$item->registry
            ];
            $data['current_page'] = $list->currentPage();
            $data['per_page'] = $list->perPage();
            $data['lase_page'] = $list->lastPage();
            $data['total_item'] = $list->total();
            $data['max_pages'] = $list->lastPage();
            $data['count'] = $list->total();
        }
        return $data;
    }




}
