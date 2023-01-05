<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Bank\IndexController;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\FirstPage;
use App\Models\Following;
use App\Models\Option;
use App\Models\Post;
use App\Models\ShopStock;
use App\Models\ShopStore;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class SellerController extends Controller
{
    /*نمایش لیست فروشندگام*/
    function seller_list(Request $request){
        $data = ShopStore::where('status','active')
            ->whereNotNull('slug')
            ->where('slug','<>',"")
            ->paginate($request->input('per_page'));
        foreach ($data as $item){
            $item->img = url('/uploads/shop/'.$item->img);
        }

        return ['result'=>1,'data'=>$data];
    }

    /*لندینگ فروشنده*/
    function seller_landing(Request $request){
        $slug = $request->input('slug','');
        $user_id = $request->input('user_id',0);
        $stores = ShopStore::where('slug',$slug)
            ->orWhere('id',$slug)
            ->get();
        if($stores->count()){
            $store = $stores->first();
            $store->img = url('/uploads/shop/'.$store->img);
            $store->cover = url('/uploads/shop/'.$store->cover);
            /*گالری تصاویر*/
            $images = glob(basePath().'/uploads/shop/'.hashId($store->id).'_gallery_*.*');
            $gallery =[];
            foreach($images as $image) {
                $e = explode('/', $image);
                $gallery[] = url('/uploads/shop/'.end($e));
            }
            /*امار دیدگاهها و عملکرد*/
            $comments = Comment::where('relate_to','seller')
                ->where('relate_id',$store->id)
                ->whereIn('status',['active','publish','approved'])
                ->selectRaw("count(ms011_comment.id) as comment_count")
                ->selectRaw("sum(ms011_comment.rate) as comment_total_rate")
                ->get();
            /*عملکرد فروشنده*/
            $seller_worker = round(division(($comments->first()->comment_total_rate * 100),(5 * $comments->first()->comment_count)));
            /*تعداد محصولات فروشنده*/
            $product_count = ShopStock::where('store_id',$store->id)->groupby('product_id')->get()->count();
            /*تارخ ثبت نام*/
            $v = new Verta($store->created_at);
            $register_date = $v->formatDifference();
            /*آیا شما دنبال میکنید*/
            $you_is_following = Following::where('user_id',$user_id)
                ->where('relate_to','seller')
                ->where('relate_id',$store->id)
                ->get();
            /*آمار نظرات و بازخورد نظر سنجی*/
            $poll_items = DB::table('poll_item as item')
                ->where('item.poll_id',$store->poll_id)
                ->select(
                    'item.max_score',
                    'item.title',
                    'item.sort',
                    'item.id'
                )
                ->orderBy('item.sort')
                ->get();

            $poll_result=DB::table('poll_item as item')
                ->leftJoin('poll_answer as answer','item.id','answer.poll_item_id')
                ->where('item.poll_id',$store->poll_id)
                ->where('answer.relate_to','seller')
                ->where('answer.relate_id',$store->id)
                ->orderby('item.sort','asc')
                ->groupby('item.id')
                ->select(
                    'item.max_score',
                    'item.title',
                    'item.sort',
                    'item.id'
                )
                ->selectRaw("SUM(ms011_answer.score) as total_score")
                ->selectRaw("COUNT(ms011_answer.poll_item_id) as total_count")
                ->orderBy('item.sort')
                ->get();
            $poll_data =[];
            foreach($poll_result as $item) {
                $max_score = intval($item->max_score);
                $total_score = floatval($item->total_score);
                $total_count = intval($item->total_count);
                $very_good = $total_count * $max_score;
                $point = round(division($total_score * $max_score, $very_good));
                $percent = division($total_score * 100, $very_good);
                $poll_data[]=[
                    'item_title'=>$item->title,
                    'item_percent'=>$percent,
                    'item_point'=>$point,
                    'max_score'=>$max_score,
                    'item_id'=>$item->id,
                ];
            }
            return ['result' => 1, 'data' => [
                'store'=>$store,
                'gallery'=>$gallery,
                'seller_worker'=>$seller_worker,
                'product_count'=>$product_count,
                'register_date'=>$register_date,
                'comment_count'=>$comments->first()->comment_count,
                'poll_data'=>$poll_data,
                'poll_items'=>$poll_items,
                'follower'=>Following::where('relate_to','seller')->where('relate_id',$store->id)->count(),
                'following'=>Following::where('relate_to','seller')->where('user_id',$store->user_id)->count(),
                'you_is_follow'=>$you_is_following->count()?'yes':'no',
                ]
            ];
        }
        return ['result' => 1, 'msg' => 'فروشگاهی برای نمایش پیدا نشد'];
    }

    /*محصولات فروشنده*/
    function seller_products(Request $request){
        $orderBy = $request->input('orderBy','created_at|desc');
        $orderBy2 = $request->input('orderBy2','created_at|desc');
        $ids = $request->input('ids','');
        $slug = $request->input('slug');
        $stores = ShopStore::where('slug',$slug)->get();
        if($stores->count()){
            $store = $stores->first();
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
                'store_id'=>$store->id,
            ];
            $data=getProductList($param);
            $max_price = DB::table('shop_stock')->max('customer_price');
            return['result'=>1,
                'data'=>$data,
                'max_price'=>$max_price,
                'store'=>$store
            ];
        }else{
            return ['result'=>0,'msg'=>'فروشگاه پیدا نشد'];
        }

    }

    /*دیدگاههای فروشنده*/
    function seller_comment(Request $request){
        $relate_to = $request->input('relate_to','seller');
        $relate_id = $request->input('seller_id',0);
        $per_page = $request->input('per_page',15);
        $comments=Comment::where('comment.relate_to',$relate_to)
            ->where('comment.relate_id',$relate_id)
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

        return ['result'=>1,'data'=>$comments];
    }





}
