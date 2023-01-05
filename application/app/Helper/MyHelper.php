<?php

use App\Models\Role;
use App\Models\ShopStock;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Locate;
use Hekmatinasser\Verta\Verta;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\NotifyTemp;
use App\Models\Option;

if(!function_exists('fieldItems')){
    /**
     * @param $data
     * @param string $e
     * @return array|mixed|string
     */
    function fieldItems($data,$e='all'){
        $data=!empty($data)?$data:[];
        if($e=='all' || empty($e))
            return $data;
        elseif (is_null($e))
            return 'ناشناخته';
        elseif (!empty($e) && isset($data[$e]))
            return $data[$e];
        return 'ناشناخته';
    }
}
if(!function_exists('_slash')){
    function _slash($src=''){
        $abs = url('/').'/'.$src;
        if(Route::getCurrentRoute()){
            $r=Route::getCurrentRoute()->uri;
            if($r=='/'){
                return $src.'';
            }
            $e = explode('/',$r);
            foreach ($e as $param){
                if(substr_count($param,'?'))
                    return $abs;
            }
            $count=substr_count($r,'/');
            if(!$count){
                return $abs;
            }
            $dotSlashes='';
            for($i=0;$i<$count;$i++){
                $dotSlashes.='../';
            }
            return $dotSlashes.$src;
        }else{
            return $abs;
            //$_SERVER['SERVER_NAME'] نام دامنه
            //$_SERVER['REQUEST_URI'] عبارت پس از نام دامنه
        }

    }
}
if(!function_exists('_noImage')){
    function _noImage($name='no-image.png'){
        return _slash('back/custom/img/'.$name);
    }
}
if(!function_exists('imageTitle')){
    function imageTitle($src,$title,$excerpt=19){
        $src=_slash($src);
        $title_excerpt = $excerpt == 0?$title:excerpt($title,$excerpt,'...');
        $onerror=url('back/custom/img/avatar.png');
        return '<span style="white-space:nowrap" class="chip black-text" title="'.$title.'"><img onerror="this.src=\''.$onerror.'\'" src="'.$src.'"> '.$title_excerpt.'</span>';
    }
}
if(!function_exists('tblPrefix')){
    function tblPrefix(){
        return \Illuminate\Support\Facades\DB::getTablePrefix();
    }
}
if(!function_exists('basePath')){
    /*مسیر ریشه پروژه*/
    function basePath(){
        return realpath(base_path() . '/../');
    }
}
if(!function_exists('getMediaPath')){
    function getMediaPath(){
        return $path=basePath().'/uploads/media';
    }
}
if(!function_exists('getUploadPath')){
    function getUploadPath(){
        return $path=basePath().'/uploads';
    }
}
if(!function_exists('saveBase64')){
    function saveBase64($file,$name,$folder){
        if (!is_null($file) && !empty($file) && strpos($file, 'data:image') === 0) {
            $img = $file;
            $ext = 'jpg';
            if (strpos($img, 'data:image/jpeg;base64,') === 0) {
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $ext = 'jpg';
            }
            if (strpos($img, 'data:image/png;base64,') === 0) {
                $img = str_replace('data:image/png;base64,', '', $img);
                $ext = 'png';
            }
            if (strpos($img, 'data:image/gif;base64,') === 0) {
                $img = str_replace('data:image/gif;base64,', '', $img);
                $ext = 'gif';
            }

            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $fileName=$name.'.'.$ext;
            $path=getUploadPath();
            if($path){
                $path.='/'.$folder;
                $myFile = $path.'/'.$fileName;
                if(file_put_contents($myFile, $data)){
                    return $fileName;
                }
            }
        }
        return 0;
    }
}
if(!function_exists('deleteFile')){
    function deleteFile($search){
        if(empty($search))
            return 0;
        $path=basePath().'/'.$search;
        $list = glob($path);
        if($list && count($list)){
            foreach ($list as $item){
                try{
                    unlink($item);
                }catch (Exception $e){

                }
            }
            return 1;
        }
        return 0;
    }
}
if(!function_exists('hashId')){
    /**
     * @param $id
     * @return float|int
     */
    function hashId($id){
        if (intval($id)==0)
            return 0;
        $id = (((intval($id) * 53) + 147) - 9) + 12365;
        return $id;
    }
}
if(!function_exists('unHashId')){
    function unHashId($id){
        if (intval($id)==0)
            return 0;
        $id= ((((intval($id) - 12365) + 9) - 147) / 53) ;
        return $id;
    }
}
if(!function_exists('myRandom')){
    function myRandom($length=7,$type='numeric'){
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'), str_split(time()));
        if($type == 'numeric'){
            $characters = array_merge(range('0','9'), str_split(time()));
        }
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
if(!function_exists('randomNumber')){
    function randomNumber($length=7){
        $str = "";
        $characters = array_merge(range('0','9'), str_split(time()));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
if(!function_exists('getSuffix')){
    function getSuffix($name){
        $arr = explode('.',$name);
        return end($arr);
    }
}
if(!function_exists('getCatApi')){
    /**
     * @param $parent_id
     * @param string $type
     * @return mixed
     */
    function getCatApi($parent_id,$type=''){
        $parent_id=is_numeric($parent_id)?$parent_id:0;
        $list=\App\Models\Category::where('parent_id',$parent_id)
            ->where(function ($q) use($type){
                if(!empty($type))
                    $q->where('type',$type);
                return 1;
            })
            ->where('group_id',0)
            ->where('status','active')
            ->orderby('sort','asc')
            ->select('id','title','img','thumb','url','value','class','icon')
            ->get();
        foreach ($list as $key=>$item){
            $list[$key]->url = str_replace('{SITE_URL}',url('/'),$item->url);
        }
        return $list;
    }
}
if(!function_exists('getCatTree')){
    function getCatTree($parent_id,$type=''){
        $new_list = Category::where('type',$type)
            ->where('status','active')
            ->where(function ($q) use($type){
                if(!empty($type))
                    $q->where('type',$type);
                return 1;
            })
            ->where('parent_id',$parent_id)
            ->orderby('sort','asc')
            ->get();
        $arr=[];
        if($new_list->count()){
            foreach ($new_list as $item){
                $arr[]=[
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'img'=>$item->img,
                    'value'=>$item->value,
                    'class'=>$item->class,
                    'icon'=>$item->icon,
                    'url'=>str_replace('{SITE_URL}',url('/'),$item->url),
                    'children'=>getCatTree($item->id,$type)
                ];
            }
        }
        return $arr;
    }
}
if(!function_exists('getCatParents')){
    /**
     * @param $parent_id
     * @param string $type
     * @return array
     */
    function getCatParents($id){
        $arr=qLevel($id,[]);
        return array_reverse($arr);
    }
    function qLevel($id,$list){
        $find = Category::find($id);
        if($find){
            $list[]=[
                'id'=>$find->id,
                'parent_id'=>$find->parent_id,
                'title'=>$find->title,
                'img'=>$find->img,
                'value'=>$find->value,
                'url'=>$find->url,
            ];
            $index=count($list) - 1;
            if($index > -1){
                if($list[$index]['parent_id'] > 0){
                    $list=qLevel($list[$index]['parent_id'],$list);
                }
            }
        }
        return $list;
    }
}

if(!function_exists('catName')){
    function catName($id){
        $find=Category::find($id);
        return $find?$find->title:'نامشخص';
    }
}
if(!function_exists('actionTable')){
    function actionTable($data=[]){
        $buttons='';
        foreach ($data as $key=>$val){
            $buttons.='<span style="font-weight: 600">'.$val.'</span>';
            $buttons.=count($data)>$key+1?'<span style="font-weight: 600"> | <span>':'';
        }
        return $buttons;
    }
}
if(!class_exists('classEmpty')){
    class classEmpty{
        private $vars = array() ;
        public function __get($name)
        {
            return isset($this->vars[$name])?$this->vars[$name]:'';
        }

        public function __set($name, $value='')
        {
            $this->vars[$name] = $value ;
        }
    }
}
if(!function_exists('currency')){
    function currency(){
        return \App\Models\Option::getval('currency');
    }
}
if(!function_exists('excerpt')){
    function excerpt($str,$len,$more='...'){
        if (extension_loaded('mbstring')) {
            $strlen = mb_strlen($str,'utf8');
        }else{
            $strlen = strlen($str);
        }
        if($strlen > $len){
            return mb_substr($str,0,$len,"utf-8").' '.$more;
        }
        return $str;
    }
}
if(!function_exists('getState')){
    function getState(){
        return \App\Models\Locate::where('type','state')->get();
    }
}
if(!function_exists('getCity')){
    function getCity($parent_id){
        return $parent_id>0?\App\Models\Locate::where('type','city')
            ->where('parent_id',intval($parent_id))
            ->get():[];
    }
}
if(!function_exists('locateName')){
    function locateName($id){
        $locate=Locate::find($id);
        if ($locate)
            return $locate->name;
        return 'نامشخص';
    }
}
if(!function_exists('discountPrice')){
    function discountPrice($price,$discount){
        return  (0.01 * $discount) * $price;
    }
}
if(!function_exists('status_color')){
    /*رنگ دادن به وضعیتها*/
    function status_color($status,$text=''){
        $color='';
        $text=!empty($text)?$text:$status;
        foreach (color_bank() as $key=>$row){
            if(in_array($status,$row))
                $color=$key;
        }
        if(!empty($color))
            return text_color($color,$text);
        else
            return text_color('grey',$text);
    }
}
if(!function_exists('color_bank')){
    /*بانک رنگ*/
    function color_bank(){
        return [
            'green'=>['active','ok','ready','is_user','done','accept'],
            'blue'=>['read','answer','waite_for_send'],
            'red'=>['trash',
                'disconnect',
                'is_guest',
                'cancel_operator',
                'cancel_customer',
                'cancel_store',
                'reject_customer',
                'unread',
            ],
            'orange'=>['cancel','waiting_complete','review','new'],
            'purple'=>['seller','waiting_accept','waiting_payment','waiting'], // بنفش
            'yellow'=>[],
            'cyan'=>['in','paid',], //سبز کمرنگ
            'grey'=>[],
            'pink'=>['inactive','deactive','expire','processing'],
            'indigo'=>['verify','sending'], //ابی مایل بنفش
            'teal'=>['open'], // سبز تیره تر
            'lime'=>['anbar'],
            'amber'=>['pending','draft'], // زرد خوشرنگ
            'brown'=>['out','closed'],
        ];
    }
}
if(!function_exists('text_color')){
    /*متنهای رنگی*/
    function text_color($color,$text=''){
        $data=[];
        $color_list=array_keys(color_bank());
        foreach ($color_list as $key){
            $data[$key]='<span class="chip lighten-5 '.$key.' '.$key.'-text">'.$text.'</span>';
        }
        return in_array($color,$color_list)?$data[$color]:$data['grey'];
    }
}
if(!function_exists('alphaDate')){
    /*فقط تاریخ الفبایی*/
    function alphaDate($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('l, j F Y'.$txt);
    }
}
if(!function_exists('alphaDate2')){
    /*فقط تاریخ الفبایی2*/
    function alphaDate2($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('j F Y'.$txt);
    }
}
if(!function_exists('alphaDateTime')){
    /*تاریخ و زمان الفبایی*/
    function alphaDateTime($str,$txt=''){
        $v=new Verta($str);
        $txt=!empty($txt)?' '.$txt:'';
        return $v->format('l, j F Y - H:i:s'.$txt);
    }
}
if(!function_exists('vv')){
    /*تبدیل میلادی به هر فرمت شمسی*/
    function vv($str,$format='l, j F Y - H:i:s'){
        if(empty($str) || is_null($str) || DateTime::createFromFormat('m/d/Y', $str) !== false)
            return '';
        $v=new Verta($str);
        return $v->format($format);
    }
}
if(!function_exists('toMiladi')){
    /*تبدیل میلادی به میلادی*/
    function toMiladi($date , $time="00:00:00"){
        if(empty($date)){
            return null;
        }
        $v=new Verta();
        $date=str_replace('-','/',$date);
        $explode_date=explode('/',$date);
        if(count($explode_date)==3){
            $y=intval($explode_date[0]);
            $m=intval($explode_date[1]);
            $d=intval($explode_date[2]);
            if($y > 1300 && $y < 1450){
                if($m >=1 && $m<=12){
                    if($d >=1 && $d<=31){
                        $explode_time=explode(':',$time);
                        if(count($explode_time)==3){
                            $timestamp= Verta::parse($y.'-'.$m.'-'.$d.' '.$explode_time[0].':'.$explode_time[1].':'.$explode_time[2])->getTimestamp();
                            $v->timezone = 'Asia/Tehran';
                            return date('Y-m-d H:i:s',$timestamp);
                        }
                    }
                }
            }
        }
        return date('Y-m-d H:i:s',time());
    }
}
if(!function_exists('getProductList')){
    function getProductList($opt=[]){
        $page=isset($opt['page'])?$opt['page']:1;
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $tblProducts = tblPrefix().'shop_products';
        $tblStock = tblPrefix().'shop_stock';
        $tblStore = tblPrefix().'shop_store';
        $user_id = isset($opt['user_id'])?$opt['user_id']:0;
        $title = isset($opt['title'])?$opt['title']:'';
        $per_page=isset($opt['per_page'])?$opt['per_page']:15;
        $price_from=isset($opt['price_from'])?$opt['price_from']:0;
        $price_to=isset($opt['price_to'])?$opt['price_to']:0;
        $cat_id=isset($opt['cat_id'])?intval($opt['cat_id']):0;
        $sub_cat_ids=isset($opt['sub_cat_ids'])?$opt['sub_cat_ids']:'';
        $brands=isset($opt['brands'])&&!empty($opt['brands'])?$opt['brands']:[];
        $colors=isset($opt['colors'])?$opt['colors']:[];
        $size=isset($opt['size'])?$opt['size']:0;
        $product_ids=isset($opt['product_ids'])?$opt['product_ids']:[];
        $status=isset($opt['status'])?$opt['status']:'active';
        $orderBy=isset($opt['orderBy']) && !empty($opt['orderBy'])?$opt['orderBy']:['created_at','desc'];
        $orderBy2=isset($opt['orderBy2'])  && !empty($opt['orderBy2']) ?$opt['orderBy2']:['created_at','desc'];
        $is_count=isset($opt['is_count'])?$opt['is_count']:0;
        $is_discount=isset($opt['is_discount'])?$opt['is_discount']:0;
        $tag=isset($opt['tag'])?$opt['tag']:'';
        $ids=isset($opt['ids']) && count($opt['ids'])?$opt['ids']:[];
        $term=isset($opt['term'])?$opt['term']:'';
        $in_festival = isset($opt['in_festival'])?$opt['in_festival']:0;
        $in_vip = isset($opt['in_vip'])?$opt['in_vip']:0;
        $except_id = isset($opt['except_id'])?$opt['except_id']:[];
        $store_id  = isset($opt['store_id'])?$opt['store_id']:0;
        $filters = isset($opt['filters'])?$opt['filters']:[];
        $buffer=[];
        $havingOr = [];
        $havingValues=[];
        foreach ($filters as $key=>$group){
            foreach ($group as $index=>$item){
                $im = str_replace('<separator>','---',$item);
                $havingValues[]=explode('<separator>',$item);
                $buffer[]="FIND_IN_SET('$im',propertyNames)";
            }
            $havingOr[$key]=implode(' OR ',$buffer);
            $buffer=[];
        }
        $having = count($havingOr)?implode(' AND ',$havingOr):"1";
        $prefix='ms011_';
        $list = DB::table('shop_products as products')
            ->join('shop_stock as stock','stock.product_id','products.id' )
            ->join('shop_store as store','store.id','stock.store_id')
            ->leftJoin('shop_custom_value as cv',function ($q)use($havingValues){
                if(count($havingValues)){
                    return $q->on('cv.product_id','products.id')
                        ->whereIn('cv.value',array_column($havingValues,1));
                }else{
                    return $q->where('cv.id','<',-1);
                }
            })
            ->where(function ($q) use($store_id){
                if(intval($store_id) > 0)
                    return $q->where('store.id',$store_id);
                else
                    return 1;
            })
            ->where(function ($q) use($title){
                if(!empty($title))
                    return $q->where('products.title','like','%'.$title.'%');
                else
                    return 1;
            })
            ->where(function ($q)use ($except_id){
                if(count($except_id)){
                    return $q->whereNotIn('products.id',$except_id);
                }
                return 1;
            })
            ->where(function ($q) use($brands){
                if(count($brands))
                    return $q->whereIn('products.brand',$brands);
                else
                    return 1;
            })
            ->where(function ($q) use($colors){
                if(count($colors))
                    return $q->whereIn('stock.color_id',$colors);
                return 1;
            })
            ->where(function ($q) use($size){
                if(intval($size) > 0)
                    return $q->where('stock.size_id',$size);
                return 1;
            })
            ->where(function ($q) use($price_from){
                if(intval($price_from) > 0)
                    return $q->where('stock.price','>=',$price_from);
                return 1;
            })
            ->where(function ($q) use($price_to){
                if(intval($price_to) > 0)
                    return $q->where('stock.price','<=',$price_to);
                return 1;
            })
            ->where(function ($q) use($in_vip){
                if($in_vip)
                    return $q->where('products.vip',1);
                return 1;
            })
            ->where(function ($q) use($product_ids){
                if(count($product_ids))
                    return $q->whereIn('products.id',$product_ids);
                return 1;
            })
            ->where(function ($q) use($status){
                if($status == 'all')
                    return 1;
                return $q->where('products.status',$status);
            })
            ->where(function ($q) use($tag){
                if(empty($tag))
                    return 1;
                return $q->whereRaw("FIND_IN_SET('$tag',ms011_products.tags)");
            })
            ->where(function ($q) use($cat_id,$sub_cat_ids){
                if(!empty($sub_cat_ids)){
                    //dd('sub Cat: ',$sub_cat_ids);
                    $arr = explode(',',$sub_cat_ids);
                    foreach ($arr as $s){
                        $q->orWhereRaw("FIND_IN_SET('$s',ms011_products.cats)");
                    }
                    return $q;
                }
                else if(intval($cat_id) > 0){
                    return $q->whereRaw("FIND_IN_SET('$cat_id',ms011_products.cats)");
                }
                return 1;
            })

            ->where(function ($q) use($is_discount){
                if($is_discount)
                    return $q->where('stock.price','>','stock.customer_price')
                        ->orWhere('product.festival_discount','>',0);
                return 1;
            })
            ->where(function ($q) use($is_count){
                if($is_count){
                    return $q->where('stock.count','>',0);
                }
                return 1;
            })
            ->where(function ($q) use($in_festival){
                if($in_festival){
                    return $q->where('products.festival_discount','>',0)
                        //->where('stock.discount','=',0)
                        ->where('products.festival_start_date', '<=', date('Y-m-d H:i:s'))
                        ->where('products.festival_end_date', '>=', date('Y-m-d H:i:s'));
                }
                return 1;
            })
            ->where(function ($q) use($ids){
                if(count($ids))
                    return $q->whereIn('products.id',$ids);
                return 1;
            })
            ->where(function ($q) use($term){
                if(!empty($term))
                    return $q->where('products.title','LIKE','%'.$term.'%')
                        ->orWhere('products.tags','LIKE','%'.$term.'%');
                return 1;
            })
            ->where('products.status','active')
            ->where(function ($q){
                $is_plan = Option::getval('is_store_plan');
                if($is_plan == 'yes'){
                    return $q->where('store.expire','>',date('Y-m-d H:i:s'));
                }
                return 1;
            })
            ->where('store.status','active')
            ->select(
                'products.id'
                ,'products.title'
                ,'products.title_en'
                ,'products.description'
                ,'products.seo_alt'
                ,'products.slug'
                ,'products.img'
                ,'products.brand'
                ,'products.cats'
                ,'products.cats_select'
                ,'products.seller_count'
                ,'products.view_count'
                ,'products.rate_star'
                ,'products.rate_score'
                ,'products.created_at'
                ,'products.festival_id'
                ,'products.festival_discount'
                ,'products.festival_start_date'
                ,'products.festival_end_date'
                ,'products.festival_exception'
                /*,'stock.id as stock_id'
                ,'stock.product_id as stock_product_id'
                ,'stock.store_id as stock_store_id'
                ,'stock.price as stock_price'
                ,'stock.customer_price as stock_customer_price'
                ,'stock.count as stock_count'
                ,'stock.size_id as stock_size_id'
                ,'stock.color_id as stock_color_id'
                ,'stock.warranty as stock_warranty'
                ,'stock.is_default as stock_is_default'
                ,'cv.value as cv_value'*/
            )
            ->selectRaw("ROUND(MIN(ms011_stock.customer_price)) as stock_min_customer_price")
            ->selectRaw("GROUP_CONCAT(
            ms011_stock.id,'|'
            ,IFNULL(ms011_stock.customer_price,0),'|'
            ,IFNULL(ms011_stock.count,0)) as concat_price"
            )
            ->selectRaw("GROUP_CONCAT( CONCAT( ms011_cv.custom_field_id,'---', ms011_cv.value ) SEPARATOR ',' ) AS  propertyNames ")
            ->selectRaw("CONCAT_WS('---',ms011_cv.custom_field_id,ms011_cv.value) as con_ws")
            ->groupBy('products.id')
            ->orderby($orderBy[0],$orderBy[1])
            ->orderby($orderBy2[0],$orderBy2[1])
            /*->havingRaw("FIND_IN_SET('142---120',propertyNames) AND FIND_IN_SET('176---6.2',propertyNames)")*/


			->havingRaw($having)
            ->paginate($per_page);
			//dd($list);
			//End Query

        $product_ids=$list->pluck('id')->toArray();

        /**start find favorite**/
        $user_id = intval(auth_info()->user_id) > 0?intval(auth_info()->user_id):$user_id;
        if($user_id > 0){
            $favList=\App\Models\Favorite::where('relate_to','product')
                ->whereIn('relate_id',$product_ids)
                ->where('user_id',intval($user_id))
                ->get();
        }else{
            $favList=[];
        }
        foreach ($list->items() as $key=>$row){
            unset($find);
            $concat_price = explode(',',$row->concat_price);
            if(count($concat_price)){
                foreach ($concat_price as $id_price){
                    $e = explode('|',$id_price);
                    if(intval($e[1]) == intval($row->stock_min_customer_price) && intval($e[2]>0)){
                        $find = DB::table('shop_stock as stock')
                            ->where("id",$e[0])
                            ->get();
                    }
                }
            }
            if(isset($find) && $find->count()){
                $row->stock = $find->first();
            }
            else{
                $q = DB::table('shop_stock as stock')
                    ->where('count','>',0)
                    ->where('product_id',$row->id)
                    ->limit(1)
                    ->select('*')
                    ->orderBy('customer_price','asc')
                    ->get();
                if($q->count()){
                    $row->stock = $q->first();
                }else{
                    $row->stock = new classEmpty();
                    $row->stock->id =0;
                    $row->stock->price =0;
                    $row->stock->customer_price =0;
                    $row->stock->product_id =$row->id;
                }
            }
            if($row->festival_discount > 0 &&
                $row->festival_start_date <= date('Y-m-d H:i:s') &&
                $row->festival_end_date >= date('Y-m-d H:i:s')
            ){
                $inFestival = 1;
            }else{
                $inFestival = 0;
            }
            $price = intval($row->stock->price);
            $customer_price = intval($row->stock->customer_price);
            $customer_price = $inFestival
                ?$price - ($price * $row->festival_discount)
                :$customer_price;
            try {
                $discount_percent =  round(100 - (($customer_price * 100) / $price));
                $discount_percent = $discount_percent * 0.01;
            }catch (DivisionByZeroError $e){
                $discount_percent = 0;
            }
            $list->items()[$key]->in_festival = $inFestival;
            $list->items()[$key]->festival_discount = floatval($row->festival_discount);
            $list->items()[$key]->festival_percent = round(floatval($row->festival_discount) * 100);

            $list->items()[$key]->real_price = $price;


            $list->items()[$key]->stock_id = $row->stock->id;
            $list->items()[$key]->stock_product_id = $row->stock->product_id;
            $list->items()[$key]->stock_store_id = $row->stock->store_id;
            $list->items()[$key]->stock_price = $price;
            $list->items()[$key]->stock_customer_price = $row->stock->customer_price;
            $list->items()[$key]->stock_discount = floatval($row->stock->discount);
            $list->items()[$key]->stock_count = intval($row->stock->count);
            $list->items()[$key]->stock_size_id = $row->stock->size_id;
            $list->items()[$key]->stock_color_id = $row->stock->color_id;
            $list->items()[$key]->stock_warranty_id = $row->stock->warranty_id;
            $list->items()[$key]->stock_warranty = $row->stock->warranty;
            $list->items()[$key]->stock_is_default = $row->stock->is_default;
            $list->items()[$key]->store_id = 0;
            $list->items()[$key]->stock_store_id = 0;
            $list->items()[$key]->price_label = empty($row->stock->price_label)?'|empty|':$row->stock->price_label;


            $img=explode('/',$row->img);
            $list->items()[$key]->image_only = end($img);
            $list->items()[$key]->rate_star_percent = round(($row->rate_star * 100) / 5);
            $list->items()[$key]->is_favorite = !empty($favList)&&$favList->where('relate_id',$row->id)->count()?1:0;/*آیا در لیست علاقه مندی ها هست یا نه*/
            $list->items()[$key]->customer_price = round($customer_price);
            $list->items()[$key]->customer_discount =  $discount_percent;
            $list->items()[$key]->link = getLink('product',$row);
            $list->items()[$key]->description = excerpt(strip_tags(html_entity_decode($row->description)),600);
            $list->items()[$key]->alt = !empty(textRaw($row->seo_alt))?$row->seo_alt:($row->title.' - '.excerpt(strip_tags(html_entity_decode($row->description)),300));
        }
		//dd($list);
        return $list;
    }
}
if(!function_exists('getProductInfo')){
    function getProductInfo($slug,$user_id=0){
        $list = DB::table('shop_products as products')
            ->leftJoin('shop_stock as stock','stock.product_id','products.id' )
            ->leftJoin('shop_store as store','store.id','stock.store_id')
            ->leftJoin('shop_color as color','color.id','stock.color_id')
            ->leftJoin('shop_size as size','size.id','stock.size_id')
            ->leftJoin('shop_warranty as warranty','warranty.id','stock.warranty_id')
            ->where('products.id',intval($slug))
            ->orWhere('products.slug',$slug)
            ->where('store.status','active')
            //->where('stock.count','>',0)
            ->select(
                'stock.*'
                ,'products.id as product_id'
                ,'color.title as color_title'
                ,'color.code as color_code'
                ,'size.title as size_title'
                ,'warranty.title as warranty_title'
                ,'warranty.description as warranty_description'
                ,'size.description as size_description'
                ,'size.label as size_label'
                ,'store.id as store_id'
                ,'store.title as store_title'
                ,'store.slug as store_slug'
                ,'store.img as store_img'
                ,'store.commission as store_commission'
                ,'store.state as store_state'
                ,'store.city as store_city'
                ,'products.festival_id'
                ,'products.festival_discount'
                ,'products.festival_start_date'
                ,'products.festival_end_date'
                ,'products.festival_exception'
            )
            ->get();
        //dd($list);
        if($list->count() && $list->first()->product_id > 0){
            $id = $list->first()->product_id;
            $user_id = intval(auth_info()->user_id) > 0?intval(auth_info()->user_id):intval($user_id);
            if($user_id > 0){
                $is_favorite=\App\Models\Favorite::where('relate_to','product')
                    ->where('relate_id',$id)
                    ->where('user_id',$user_id)
                    ->count();
            }else{
                $is_favorite=0;
            }
            $data=[];
            $data['product']=\App\Models\ShopProduct::find($id);
            $data['product']->is_favorite = $is_favorite;
            $data['product']->cat_items = getCatParents(explode(',',$data['product']->cats_select)[0]);
            /*مرتب سازی دسته بندی ها*/
            foreach ($data['product']->cat_items as $key=>$item){
                $index = 'cat'.($key+1);
                $index2 = 'cat'.($key+1).'_title';
                $data['product']->$index = $item['id'];
                $data['product']->$index2 = $item['title'];
            }
            $data['product']->link = getLink('product',$data['product']);
            $data['product']->user_id = $user_id;
            /*در جشنواره هست با نه*/
            if($data['product']->festival_discount > 0 &&
                $data['product']->festival_start_date <= date('Y-m-d H:i:s') &&
                $data['product']->festival_end_date >= date('Y-m-d H:i:s')
            ){
                $inFestival = 1;
            }else{
                $inFestival = 0;
            }
            $data['product']->in_festival = $inFestival;
            $stock=[];
            foreach ($list as $item){
                $price = intval($item->price);
                $stock_customer_price = floatval($item->customer_price);
                $customer_price = $inFestival
                    ?$price - ($price * $item->festival_discount)
                    :$stock_customer_price;
                try {
                    $discount_percent =  round(100 - (($customer_price * 100) / $price));
                    $discount_percent = $discount_percent * 0.01;
                }catch (DivisionByZeroError $e){
                    $discount_percent = 0;
                }
                $stock[]=[
                    'id'=>$item->id,
                    'product_id'=>$item->product_id,
                    'store_id'=>$item->store_id,
                    'store_state'=>$item->store_state,
                    'store_city'=>$item->store_city,
                    'store_state_title'=>locateName($item->store_state),
                    'store_city_title'=>locateName($item->store_city),
                    'store_img'=>($item->store_img),
                    'color_id'=>$item->color_id,
                    'color_title'=>$item->color_title?$item->color_title:'',
                    'color_code'=>$item->color_code,
                    'size_id'=>intval($item->size_id),
                    'size_title'=>$item->size_title?$item->size_title:'',
                    'size_description'=>$item->size_description,
                    'size_label'=>$item->size_label,
                    'warranty_id'=>intval($item->warranty_id),
                    'warranty_title'=>$item->warranty_title,
                    'warranty_description'=>$item->warranty_description,
                    'real_price'=>floatval($item->price),
                    'customer_price'=>round($customer_price),
                    'price_label'=>empty($item->price_label)?'|empty|':$item->price_label,
                    'customer_discount'=>$price> 0 ?number_format(floatval((100 - (($customer_price * 100) / $price)) * 0.01),2):0 ,
                    'discount'=>$discount_percent,
                    'is_default'=>$item->is_default,
                    'count'=>intval($item->count),
                    'max_in_cart'=>intval($item->max_in_cart),
                    'stock_customer_price'=>$stock_customer_price,
                    'store_title'=>$item->store_title,
                    'store_slug'=>$item->store_slug,
                    'store_landing'=>getLink('seller',(object)['id'=>$item->store_id,'slug'=>$item->store_slug]),
                    'store_commission'=>$item->store_commission,
                    'in_festival'=>$inFestival,
                ];
            }

            $defaultIndex = 0;
            /*مرتب سازی ارایه بر اساس مقادیر یک ستون*/
            $c=array_column($stock,'customer_price');
            array_multisort($c, SORT_ASC, $stock);
            $data['stock']=$stock;
            return $data;
        }
        return 0;
    }
}
if(!function_exists('myRoundBase')){
    /*رند اعداد بر پایه عدد خاص*/
    function myRoundBase($number,$base=10){
        $mod = fmod($number,$base);
        return $mod > 0?intval($number + ($base - $mod)):$number;
    }
}
if(!function_exists('sendNotify')){
    function sendNotify($template,$opt=[]){
        $result=[
            'email'=>0,
            'sms'=>0,
            'msg'=>'',
        ];

        $mobile = isset($opt['mobile'])?$opt['mobile']:'';
        $email = isset($opt['email'])?$opt['email']:'';

        $user_id = isset($opt['user_id'])?$opt['user_id']:0;
        $invoice_id = isset($opt['invoice_id'])?$opt['invoice_id']:0;

        $user=isset($opt['user'])?$opt['user']:new classEmpty();
        $invoice=isset($opt['invoice'])?$opt['invoice']:new classEmpty();

        if(is_numeric($user_id) && $user_id > 0){
            $find = \App\Models\User::find($user_id);
            $user = $find?$find:$user;
        }

        if(is_numeric($invoice_id) && $invoice_id > 0){
            $find = \App\Models\ShopInvoice::find($invoice_id);
            $invoice = $find?$find:$invoice;
        }
        $opt['user'] = $user;
        $opt['invoice'] = $invoice;

        $template = NotifyTemp::where('for_use',$template)->first();
        if($template){
            /*ارسال ایمیل*/
            $send_admin = $template->email_send_admin;
            $emails[]=$email;
            $emails[] = ($send_admin=='yes')?Option::getval('email'):$email;
            $emails = array_unique($emails);
            //dd($emails);
            if($template->status_email == 'active' && count($emails) && !empty($emails[0])){//return 'here';
                $mail=new \App\Http\Controllers\MailController();
                $content = NotifyTemp::setContent($template->email_content,$opt);
                $more_text_email = isset($opt['more_text_email'])?$opt['more_text_email']:'';
                $content.=$more_text_email;
                $param=[
                    'to'=>implode(',',$emails),
                    'to_name'=>$user->nickname,
                    'subject'=>$template->subject,
                    'from'=>Option::getval('blog_title'),
                    'from_email'=>env('MAIL_USERNAME')
                ];
                $result['email'] = $mail->send($content,$param);
            }else{$result['msg'].='<br/> ایمیل غیر فعال یا خالی است';}
            /*ارسال پیامک*/
            $send_admin = $template->sms_send_admin;
            $mobiles[]=$mobile;
            $mobiles[] = ($send_admin=='yes')?Option::getval('mobile'):$mobile;
            $mobiles = array_unique($mobiles);
            if($template->status_sms == 'active' && count($mobiles)){
                if(!empty($template->sms_pattern)){ /*ارسال از طریق الگوی از پیش اماده*/
                    $arrayContent = NotifyTemp::arrayContent($opt);
                    $result['sms'] = \App\Models\Sms::send_pattern(
                        $template->sms_content,
                        implode(',',$mobiles),
                        $template->sms_pattern,
                        $arrayContent
                    );
                }else{
                    $content = NotifyTemp::setContent($template->sms_content,$opt);
                    $more_text_sms = isset($opt['more_text_sms'])?$opt['more_text_sms']:'';
                    $content.=$more_text_sms;
                    $result['sms'] = \App\Models\Sms::send($content,implode(',',$mobiles));
                }
            }else{$result['msg'].='<br/> پیامک غیر فعال یا خالی است';}
        }else{
            $result['msg'].='<br/> قالب ارسال یافت نشد';
        }
        return $result;
    }
}
if(!function_exists('seoMeta')){
    /*تنظم سئو صفحه*/
    function seoMeta($meta){

        $options = Option::multiValue(['logo','blog_title','description','tags']);
        $meta['url']=isset($meta['url'])?$meta['url']:url()->current();
        $meta['pageTitle']=isset($meta['pageTitle']) && !empty($meta['pageTitle'])?$meta['pageTitle']:$options['blog_title'];
        $meta['description']=isset($meta['description']) && !empty($meta['description'])?$meta['description']:$options['description'];
        $meta['tags']=isset($meta['tags']) && !empty($meta['tags'])?$meta['tags']:$options['tags'];
        $meta['type']=isset($meta['type']) && !empty($meta['type'])?$meta['type']:'article';
        $meta['image']=isset($meta['image']) && !empty($meta['image'])?$meta['image']:_slash('uploads/setting/'.$options['logo']);
        $meta['image_url']=isset($meta['image_url']) && !empty($meta['image_url'])?$meta['image_url']:_slash('uploads/setting/'.$options['logo']);
        $meta['canonical']=isset($meta['canonical']) && !empty($meta['canonical'])?$meta['canonical']:'';
		SEOMeta::setTitle($meta['pageTitle']);
        SEOMeta::setDescription($meta['description']);
        SEOMeta::setCanonical($meta['url']); //$meta['url']
        SEOMeta::addKeyword($meta['tags']);
		if(!empty($meta['canonical'])){
            SEOMeta::setCanonical($meta['canonical']);
        }

        OpenGraph::setDescription($meta['description']);
        OpenGraph::setTitle($meta['pageTitle']);
        OpenGraph::setUrl($meta['url']);
        OpenGraph::addProperty('og:keywords',$meta['tags']);
        OpenGraph::addProperty('type', $meta['type']);
        OpenGraph::addProperty('locale', 'fa-IR');
        OpenGraph::addImage($meta['image']);
        OpenGraph::addImage(['url' => $meta['image_url'], 'size' => 300]);

        TwitterCard::setTitle($meta['pageTitle']);
        TwitterCard::setSite($meta['url']);
    }
}
if(!function_exists('send_curl')){
    /*ارسال توسط curl*/
    function send_curl($array,$url){
        $data=json_encode($array);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_ENCODING, "");
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER,
            array(
                "Content-Type: application/json; charset=UTF-8",
                'Content-Length: ' . strlen($data)
            )
        );
        $res= curl_exec($handle);
        curl_close($handle);
        return $res;
    }
}
if(!function_exists('optionJsonValue')){
    function optionJsonValue($keyVal,$default=''){
        $e= explode('.',$keyVal);
        if(count($e) != 2)
            return $default;
        $find=Option::where('key',$e[0])->get();
        $jsonStr = $find->count()? $find->first()->json:"";
        if(!empty($jsonStr)){
            $json=json_decode($jsonStr);
            $key = $e[1];
            if(isset($json->$key)){
                return $json->$key;
            }
        }
        return $default;
    }
}
if(!function_exists('optionJsonValues')){
    function optionJsonValues($key,$array=[]){
        $ret = new classEmpty();
        $find=Option::where('key',$key)->get();
        $jsonStr = $find->count()? $find->first()->json:"";
        if(!empty($jsonStr)){
            $json=json_decode($jsonStr);
            foreach ($json as $k=>$val){
                $ret->$k = $val;
            }
        }
        return $ret;
    }
}
if(!function_exists('auth_info')){
    function auth_info(){
        //$info = json_decode(Cookie::get(env('APP_NAME').'_auth_info'));
        $key = str_replace([':','//','.'],['','',''],url('/')).'_auth_info';
        $info = session($key);
        if(isset($info) && count($info) && $info['user_id'] > 0){
            $info['is_login'] = 1;
            return (object)$info;
        }elseif(auth()->check()){
            $user = auth()->user();
            $role=Role::where('role',$user->role)->get();
            $array = [
                'user_id'=>$user->id,
                'user_role'=>$user->role,
                'user_name'=>$user->username,
                'user_status'=>$user->status,
                'user_avatar'=>$user->avatar,
                'user_mobile'=>$user->mobile,
                'user_state'=>$user->state,
                'user_city'=>$user->city,
                'user_nickname'=>$user->nickname,
                'user_credit'=>$user->credit,
                'user_score'=>$user->score,
                'user_permission_id'=>$user->permission_id,
                'user_menu'=>$role->count()?$role->first()->menu:'',
                'user_access_panel'=>$role->count()?$role->first()->access_panel:'',
                'is_login'=>1,
            ];
            session([$key=>$array]);
            return (object)$array;
        }else{
            $info = new classEmpty();
            $info->is_login = 0;
            return $info;
        }
    }
}
if(!function_exists('adminRoles')){
    function adminRoles(){
        $arr=\App\Models\Role::where('access_panel','yes')->pluck('role')->toArray();
        return $arr;
    }
}
if(!function_exists('sizeControl')){
    function sizeControl($size){
        $r=[
            'unit'=>'',
            'size'=>'',
            'title'=>''
        ];
        if($size > 1024){
            $size = $size / 1024;
            $r['unit']='Kb';
            $r['size']=$size;
        }
        if($size > 1024){
            $size = $size / 1024;
            $r['unit']='Mb';
            $r['size']=$size;
        }
        if($size > 1024){
            $size = $size / 1024;
            $r['unit']='Gb';
            $r['size']=$size;
        }
        $r['title'] = number_format($r['size']).' '.$r['unit'];
        return $r;
    }
}
if(!function_exists('getJsonInfo')){
    function getJsonInfo($str){
        if(empty($str)){
            return new classEmpty();
        }
        $arr = json_decode($str);
        $obj = new classEmpty();
        foreach ($arr as $key=>$value){
            $obj->$key = $value;
        }
        return $obj;
    }
}
if(!function_exists('paginated')){
    function paginated($list,$html=[]){
        $q=[];
        //dd(request()->query());
        foreach (request()->query() as $key=>$val) {
            if (!is_array($val)){
                if ($key != 'page') {
                    $q[] = (string)$key . '=' . (is_array($val) ? implode(',', $val) : $val);
                }
            }
        }
        $append = implode('&',$q);
        $paginate=[];
        $paginate['id'] = isset($html['goto'])?$html['goto']:'';
        $paginate['step'] = 3;
        $paginate['current'] = $list->currentPage();
        $paginate['start'] = $paginate['current'] - $paginate['step'] > 0?$paginate['current'] - $paginate['step']:1;
        $paginate['end'] = $paginate['current'] + $paginate['step'] <= $list->lastPage()?$paginate['current'] + $paginate['step']:$list->lastPage();
        $paginate['finish'] = $list->lastPage();
        $paginate['prv'] = $paginate['current'] > $paginate['start']?'?page='.($paginate['current'] - 1).(count($q)?'&'.$append:''):'';
        $paginate['next'] = $paginate['current'] < $paginate['end']?'?page='.($paginate['current'] + 1).(count($q)?'&'.$append:''):'';
        $prev = isset($html['prev'])?$html['prev']:'';
        $next = isset($html['next'])?$html['next']:'';
        $button = isset($html['button'])?$html['button']:'';
        $activeClass = isset($html['active'])?$html['active']:'';
        $ret ='';
        if(!empty($paginate['prv'])){
            $ret.= str_replace('{URL}',$paginate['prv'],$prev);
        }
        for($i=$paginate['start'];$i<=$paginate['end'];$i++){
           $plink = '?page='.$i;
           $plink = count($q)?$plink.'&'.$append:$plink;
           //$plink.=!empty($paginate['id'])?'#'.$paginate['id']:'';
           $isActive = $i == $paginate['current']?$activeClass:'';
           $ret.=str_replace(['{CLASS}','{URL}','{TEXT}'],[$isActive,$plink,$i],$button);
        }
        if(!empty($paginate['next'])) {
            $ret.= str_replace('{URL}',$paginate['next'],$next);
        }
        return $ret;
    }
}
if(!function_exists('x_logout')){
    function x_logout(){
        $prev_link = url()->previous();
        $find = substr_count($prev_link,'management');
        if(auth()->check()){
            auth()->logout();
            session()->flush();
            if($find){
                return redirect('/admin'); // ورود مدیریت
            }else{
                return redirect('/login'); // ورود مشتری
            }
        }else{
            return redirect('/login')->with(['error'=>'Error! : شما هنوز وارد نشده اید']);
        }
    }
}
if(!function_exists('productCatSelectBox')){
    function productCatSelectBox($list,$selected,$titles,$mode='ids'){
        $html='';
        $str = ltrim($titles,' > ');
        $selectArray = explode(',',$selected);
        $selectArray = array_filter($selectArray);
        foreach ($list as $item){
            $html .= '<option '.(in_array($item['id'],$selectArray)?"selected":" ").' value="'.($mode == 'ids'?$item['parent_ids']:$item['id']).'">'.$str.' > '.$item['title'].'</option>';
            if(count($item['children'])){
                $html.= productCatSelectBox($item['children'],$selected,$str.' > '.$item['title'],$mode);
            }
        }
        return $html;
    }

}
if(!function_exists('lastDate')){
    function lastDae($type,$number){
        $arr = [];
        for ($i=$number;$i>=0;$i--){
            $v = new Verta("-$i $type");
            $v1 = new Verta($v);
            $v2 = new Verta($v);
            switch ($type){
                case 'hours':
                    $arr[] = [
                        'datetime'=>$v,
                        'start'=>$v->format('Y/m/d H:00:00'),
                        'end'=>$v->format('Y/m/d H:59:59'),
                    ];
                    break;
                case 'day':
                    $arr[] = [
                        'datetime'=>$v,
                        'start'=>$v1->startDay(),
                        'end'=>$v2->endDay(),
                    ];
                    break;
                case 'week':
                    $arr[] = [
                        'datetime'=>$v,
                        'start'=>$v1->startWeek(),
                        'end'=>$v2->endWeek(),
                    ];
                    break;
                case 'month':
                    $arr[] = [
                        'datetime'=>$v,
                        'start'=>$v1->startMonth(),
                        'end'=>$v2->endMonth(),
                    ];
                    break;
                case 'year':
                    $arr[] = [
                        'datetime'=>$v,
                        'start'=>$v1->startYear(),
                        'end'=>$v2->endYear(),
                    ];
                    break;
            }
        }
        return $arr;
    }
}
if(!function_exists('appName')){
    function appName(){
        return str_replace([':','//','.'],['','',''],url('/'));
    }
}
if(!function_exists('templateName')){
    function templateName(){
        if(session('template_name') && !empty(session('template_name'))){
            return session('template_name');
        }else{
            $template_name = Option::getval('template_name');
            session(['template_name'=>$template_name]);
            return $template_name;
        }
    }
}
if(!function_exists('getLink')){
    function getLink($type,$opt=[]){
        if($type == 'product'){
            if(is_object($opt)){
                return !empty($opt->slug)?url('/product/'.$opt->slug):url('/product/'.$opt->id.'/'.textClear($opt->title));
            }else{
                $id = isset($opt['id'])?$opt['id']:0;
                $title = isset($opt['title'])?$opt['title']:'';
                return url('/product/'.$id.'/'.textClear($title));
            }
        }
        elseif($type == 'cat'){
            $item = is_array($opt)?(object)$opt:$opt;
            $confirm = !empty($item->url)?$item->url:$item->id;
            return url('/shop/'.$confirm);
        }
        elseif($type == 'page'){
            $item = is_array($opt)?(object)$opt:$opt;
            $title = textClear($item->title);
            $confirm = !empty($item->unique_title)?$item->unique_title:'page/'.$item->id;
            return url('/'.$confirm);
        }
        elseif($type == 'post'){
            $item = is_array($opt)?(object)$opt:$opt;
            $confirm = !empty($item->unique_title)?$item->unique_title:'post/'.$item->id.'/'.$item->title;
            return url('/'.$confirm);
        }
		elseif($type == 'portfolio'){
            $item = is_array($opt)?(object)$opt:$opt;
            $confirm = !empty($item->unique_title)?'portfolio/'.$item->unique_title:'portfolio/'.$item->id.'/'.$item->title;
            return url('/'.$confirm);
        }
        elseif($type == 'brand-landing'){
            $item = is_array($opt)?(object)$opt:$opt;
            $confirm = !empty($item->slug)?'brand-landing/'.$item->slug:'brand-landing/'.$item->id.'/'.$item->title_en;
            return url('/'.$confirm);
        }
        elseif($type == 'seller'){
            $item = is_array($opt)?(object)$opt:$opt;
            $confirm = !empty($item->slug)?'seller-landing/'.$item->slug:'seller-landing/'.$item->id;
            return url('/'.$confirm);
        }
        return url('/');
    }
}
if(!function_exists('textClear')){
    function textClear($text){
        return str_replace([" ","/","'","`",":"],["-","-","-","-","-"],$text);
    }
}
if(!function_exists('textRaw')){
    function textRaw($text){
        $text = trim(html_entity_decode(strip_tags($text)));
        $text = preg_replace('/\s+/', ' ', $text);
        return $text;
    }
}
if(!function_exists('redirect')){
    function redirect($url)
    {
        if (!headers_sent()){
            header("Location: $url");
        }else{
            echo "<script type='text/javascript'>window.location.href='$url'</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=$url'/></noscript>";
        }
        exit;
    }
}
if(!function_exists('division')){
    function division($a,$b)
    {
        return $a==0?0:$a/$b;
    }
}












