<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\FirstPage;
use App\Models\ShopBrand;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{

    /**/
    function product_menu(){
        return [
            'result'=>1,
            'data'=>Category::productCategory(0,''),
        ];
    }

    /**/
    function index_menu(){
        return getCatApi(0,'index-menu');
    }

    /**/
    function footer_menu(){
        return getCatApi(0,'footer-menu');
    }

    /*صفحه اول*/
    function first_page(){

        $slider = \App\Models\FirstPage::getItem('width_slider',5);
        $category = getCatApi(0,'product');
        foreach ($category as $key=>$item){
            $category[$key]->url = getLink('cat',$item);
        }
        $product_festival = getProductList([
            'in_festival'=>1,
            'orderBy'=>['customer_price','asc']
        ]);
        $product_seller = getProductList([
            'orderBy'=>['seller_count','desc'],
            'per_page'=>12
        ]);
        $product_latest=getProductList([
            'orderBy'=>['created_at','desc']
        ]);
        $product_vip=getProductList([
            'in_vip'=>1,
            'orderBy'=>['created_at','desc'],
            'per_page'=>12
        ]);
        $slider = \App\Models\FirstPage::getItem('mobile_slider',10);
        $banner4 = \App\Models\FirstPage::getItem('banner_4s',4);
        $banner2 = \App\Models\FirstPage::getItem('banner_2s',2);
        $brands = ShopBrand::whereNotNull('id')
            ->orderby('created_at','desc')
            ->limit(10)
            ->get();

        /*وبلاگ*/
        /*$list = \App\Models\Post::whereIn('post.status',['active','publish'])
            ->leftJoin('users','users.id','post.created_by')
            ->where('post.type','post')
            ->select('post.*','users.nickname')
            ->orderby('created_at','desc')
            ->get(10);
        $blog=[];
        foreach($list as $key=>$item){
            $blog[]=[
                'id'=>$item->id,
                'title'=>$item->title,
                'unique_title'=>$item->unique_title,
                'excerpt'=>excerpt(textRaw($item->content),300),
                'img'=>$item->img,
                'link'=>getLink('post',$item),
                'created_at'=>$item->created_at,
                'created_at_fa'=>alphaDateTime($item->created_at),
                'nickname'=>$item->nickname,
            ];
        }*/
        $data=[
            'slider'=>$slider,
            'category'=>$category,
            'product_festival'=>$product_festival,
            'product_seller'=>$product_seller,
            'product_latest'=>$product_latest,
            'product_vip'=>$product_vip,
            'media_url'=>url('/uploads/media'),
            'banner2'=>$banner2,
            'banner4'=>$banner4,
            'brands'=>$brands,
            //'blog'=>$blog,
        ];
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function footer(){
        $options = \App\Models\Option::multiValue([
            'logo',
            'logo_dark',
            'favicon',
            'blog_title',
            'description',
            'tel',
            'mobile',
            'address',
            'email',
            'twitter',
            'telegram',
            'linkedin',
            'instagram',
            'watsapp',
            'namad1',
            'namad2',
            'namad3',
            'footer_copy_write',
            'pre_loading',
            'product_mega_menu',
            'product_level_menu',
            'currency',
            'about',
        ]);
        $options['footer_menu'] = getCatApi(0,'footer-menu');
        $options['footer_menu2'] = getCatApi(0,'footer-menu2');
        return [
            'result'=>1,
            'data'=>$options
        ];
    }



}
