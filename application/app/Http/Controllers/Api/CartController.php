<?php

namespace App\Http\Controllers\Api;

use App\Helper\AccessController;
use App\Http\Controllers\Bank\IndexController;
use App\Http\Controllers\Shop\InvoiceController;
use App\Models\Notify;
use App\Models\Option;
use App\Models\ShopCouponCart;
use App\Models\ShopCouponCartUser;
use App\Models\ShopInvoice;
use App\Models\ShopShipping;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    /**/
    function cart(Request $request){
        $validator = Validator::make($request->all(), [
            'cart'=>'required|array'
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $cart = $request->input('cart',[]);

        $weight=0;
        $info=[];
        foreach ($cart as $item){
            $p = getProductInfo($item['product_id']);
            $weight +=$p['product']['weight'] * $item['count'];
            foreach ($p['stock'] as $stock){
                if($stock['id'] == intval($item['stock_id'])){
                    $stock['request_count'] = intval($item['count']);
                    $info[]=[
                        'product'=>$p['product'],
                        'stock'=>$stock,
                    ];
                }
            }
        }
        $data=[
            'cart_info'=>$info,
            'coupon_info'=>$this->checkCoupon($request),
            'weight'=>$weight,
            'tax'=>floatval(Option::getval('tax',0)),
        ];
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function checkCoupon(Request $request){
        $code = $request->input('coupon_code','');
        $code = $request->input('code',$code);
        $user_id = $request->input('user_id');
        $coupons = ShopCouponCart::where('code',$code)
            ->where('status','active')
            ->get();
        if($coupons->count()){
            $coupon = $coupons->first();
            $dateTime=date('Y-m-d H:i:s');
            if($dateTime > $coupon->date_range_from && $dateTime < $coupon->date_range_to){
                if(!ShopCouponCartUser::where('coupon_id',$coupon->id)
                    ->where('user_id',$user_id)
                    ->get()->count()){
                    return ['result'=>1,'data'=>$coupon,'msg'=>'کوپن تخفیف معتبر میباشد'];
                }else{
                    return ['result'=>0,'msg'=>'این کوپن توسط شما قبلا استفاده شده'];
                }
            }else{
                return ['result'=>0,'msg'=>'مهلت استفاده این کوپن به اتمام رسیده'];
            }
        }else{
            return ['result'=>0,'msg'=>'کد نامعتبر'];
        }
    }

    /**/
    function shippingMethod(Request $request){

        $list = ShopShipping::where('status','active')
            ->select('*')
            ->get();
        foreach ($list as $key=>$item){
            $list[$key]->img = url($item->img);
        }

        return ['result'=>1,'data'=>$list];
    }

    /**/
    function shippingCalculate(Request $request){
        $validator = Validator::make($request->all(), [
            'shipping_id'=> 'required|exists:shop_shipping,id',
            'city_to'=>    'required|exists:locate,id',
            'weight'=>    'required|numeric',
        ],[
            'shipping_id.required'=>'روش حمل را مشخص کنید',
            'city_to.required'=>'شهر مقصد نامشخص',
            'weight.required'=>'وزن نامشخص',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $shipping_id=$request->input('shipping_id');
        $city_from=intval(Option::getval('city'));
        $city_to=$request->input('city_to');
        $weight=$request->input('weight');
        $amount = $request->input('amount',0);
        return ShopShipping::calculate($shipping_id,$city_from,$city_to,$weight,$amount);
    }

    /**/
    function newInvoice(Request $request){
        $invoice = new InvoiceController();
        $user_id = $request->input('user_id');
        $request->request->add(['customer_id'=>hashId($user_id)]);
        $customer_id = hashId($user_id);
        $request->request->add(['customer_id'=>$customer_id]);
        $r = $invoice->new_invoice($request);
        if($r['result']){
            $user = User::find($user_id);
            $nickname = $user->user_nickname;
            $invoice_id = $r['param']['id'];
            $invoice = ShopInvoice::find($invoice_id);
            $finance = ShopInvoice::finance($invoice);
            $r['param']['relate_to']='invoice_payment';
            $r['param']['relate_to_fa']=Transaction::relate_to('invoice_payment');
            $r['param']['amount']=$finance['paid_price'];
            $html = " فاکتور جدید توسط $nickname با شماره $invoice_id ایجاد شد ";
            Notify::insert([
                'user_id'=>0,
                'relate_to'=>'new_invoice',
                'relate_id'=>$invoice_id,
                'content'=>$html,
                'created_at'=>Carbon::now()
            ]);
            sendNotify('new_invoice',[
                'user'=>$user,
                'invoice_id'=>$invoice_id,
                'mobile'=>Option::getval('mobile'),
                'email'=>$user->email
            ]);
            //$r['data']=ShopInvoice::find($r['param']['id']);
        }
        return $r;
    }

    /**/
    function paymentGateList(Request $request){
        $list = Option::where('key','LIKE','bank_%')
            ->get();
        $data=[];
        $user = User::find($request->input('user_id'));
        foreach ($list as $key=>$item){
            $info = getJsonInfo($item->json);
            if($info->active == "true"){
                $data[]=[
                    'id'=>$item->id,
                    'name'=>explode('_',$item->key)[1],
                    'title'=>$info->title,
                ];
            }
        }
        return ['result'=>1,'data'=>[
                'list'=>$data,
                'credit'=>intval($user->credit),
            ]
        ];

    }

    /**/
    function paymentRequest(Request $request){
        $c = new IndexController();
        return $c->payment_request($request);
    }

    /**/
    function newPayment($invoice_id){
        /****** Actions *******/
        $invoice=ShopInvoice::find($invoice_id);
        if($invoice){
            return view('front-end.cart-complete',compact('invoice'));
        }
        return view('front-end.404');
    }






}
