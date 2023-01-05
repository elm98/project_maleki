<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Ui\CommentController;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Option;
use App\Models\ShopInvoice;
use App\Models\ShopInvoiceSub;
use App\Models\ShopShipping;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    /*نمایش پروفایل*/
    function index(Request $request){
        $user_id = $request->input('user_id');
        $orders = ShopInvoice::where('customer_id',$user_id)->get();
        $data = User::find($request->input('user_id'));
        $data->state_fa = locateName($data->state);
        $data->city_fa = locateName($data->city);
        $data->birthday_fa = vv($data->birthday,'Y-m-d');
        $data->avatarUrl = !empty($data->avatar)?url('/uploads/avatar/'.$data->avatar):'';
        $data->orders = $orders->count();
        $data->comments = Comment::where('user_id',$user_id)->count();
        $data->favorits = Favorite::where('user_id',$user_id)->count();
        $data->status_fa = User::status($data->status);
        $data->last = Verta($data->created_at)->formatDifference();;
        //$data->orders_done = $orders->where('status','done')->count();
        //$data->orders_waiting_payment = $orders->where('status','waiting_payment')->count();
        return ['result'=>1,'data'=>$data];
    }

    /**/
    function profileUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'=>'required|exists:users,id',
            'fname'=>    'required',
            'lname'=>    'required',
            'email'=>    'required|unique:users,email,'.$request->input('user_id'),
            //'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'state'=>    'required|numeric|min:1',
            'city'=>     'required|numeric|min:1',
            'sex'=>      'required|in:man,woman',
            //'birthday'=> 'required'
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'fname.required'=>'نام را وارد کنید',
            'lname.required'=>'نام خانوادگی را وارد کنید',
            'state.required'=>'استان را انتخاب کنید',
            'city.required'=>'شهر را انتخاب کنید',
            'sex.required'=>'جنسیت را انتخاب کنید',
            'birthday.required'=>'تاریخ تولد را وارد کنید',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $id = $request->input('user_id');
        $user=User::find($id);
        $birthday=toMiladi($request->input('birthday',null));
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $user=User::find($id);
        $email = $request->input('email','');
        $email = empty($user->email)?$email:$user->email;
        $array=[
            'nickname'=>$fname.' '.$lname,
            'fname'=>$fname,
            'lname'=>$lname,
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'email'=>$email,
            //'birthday'=>$birthday,
            'sex'=>$request->input('sex','man'),
            'code_melli'=>$request->input('code_melli'),
            'edit_by'=>$id,
            'updated_at'=>Carbon::now(),
        ];
        foreach ($array as $key=>$value){
            $user->$key = $value;
        }
        $up=$user->save();
        if($up){
            //$user=User::find($id);
            $avatar= $request->input('avatar','');
            if(!empty($avatar)){
                deleteFile('/uploads/avatar/'.$user->avatar);
                $name=hashId($id).rand(0,999999);
                if($ret=saveBase64($avatar,$name,'avatar')){
                    $user->avatar=$ret;
                }
            }
            $user->save();
            $user->avatarUrl = url('/uploads/avatar/'.$user->avatar);
            return [
                'result'=>1,
                'msg'=>'ویرایش با موفقیت انجام شد .',
                'user'=>$user
            ];
        }
        return ['msg'=>'متاسفانه در اجرای درخواست خطایی رخ داده'];

    }

    /**/
    function myOrders(Request $request){
        $user_id = $request->input('user_id');
        $list = ShopInvoice::where('customer_id',$user_id)
            ->where(function ($q)use($request){
                $status = $request->input('status');
                if(empty($status))
                    return 1;
                return $q->where('status',$status);
            })
            ->orderby('created_at','desc')
            ->paginate($request->input('per_page',15));
        foreach ($list as $key=>$item){
            $list[$key]->created_at_fa = vv($item->created_at);
            $list[$key]->status_fa = ShopInvoice::status($item->status);
            $list[$key]->state_fa = locateName($item->state);
            $list[$key]->city_fa = locateName($item->city);
            $list[$key]->pricing = ShopInvoice::finance($item);
        }
        return [
            'result'=>1,
            'data'=>$list,
            'color_bank'=>color_bank(),
            'invoice_prefix'=>Option::getval('invoice_prefix')
        ];
    }

    /**/
    function orderInfo(Request $request){
        $user_id = $request->input('user_id');
        $invoice_id = $request->input('invoice_id');
        $invoice=ShopInvoice::find($invoice_id);

        if($invoice){
            $shipping =ShopShipping::find($invoice->shipping_id);
            $invoice->created_at_fa = vv($invoice->created_at);
            $invoice->pricing = ShopInvoice::finance($invoice);
            $invoice->prefix = Option::getval('invoice_prefix');
            $invoice->status_fa = ShopInvoice::status($invoice->status);
            $invoice->state_fa = locateName($invoice->state);
            $invoice->city_fa = locateName($invoice->city);
            $invoice->shipping_method_fa = $shipping?$shipping->title:'نامشخص';
            $invoice->payment_method_fa = Transaction::payment_method($invoice->payment_method);
            $invoice->color_bank = color_bank();
            $invoice->expire_number = intval(Option::getval('expire_invoice_payment',12));
            $invoice->expire_date = date('Y-m-d H:i:s',strtotime($invoice->created_at) + ((intval(Option::getval('expire_invoice_payment',12))) * 3600)) ;
            $invoice->is_expire = time() > strtotime($invoice->expire_date) ? "yes":"no";
            $invoice->ex = time()." - ".strtotime($invoice->expire_date);
            $sub_invoice=ShopInvoiceSub::leftJoin('shop_store as store','store.id','shop_invoice_sub.store_id')
                ->leftJoin('shop_color as color','color.id','shop_invoice_sub.color_id')
                ->leftJoin('shop_size as size','size.id','shop_invoice_sub.size_id')
                ->leftJoin('shop_warranty as warranty','warranty.id','shop_invoice_sub.warranty_id')
                ->leftJoin('shop_products as product','product.id','shop_invoice_sub.product_id')
                ->where('shop_invoice_sub.invoice_id',$invoice_id)
                ->select(
                    'shop_invoice_sub.*'
                    ,'color.id as color_id'
                    ,'color.title as color_title'
                    ,'color.code as color_code'
                    ,'size.id as size_id'
                    ,'size.title as size_title'
                    ,'warranty.id as warranty_id'
                    ,'warranty.title as warranty_title'
                    ,'store.title as store_title'
                    ,'product.title as product_title'
                    ,'product.title_en as product_title_en'
                    ,'product.img as product_img'
                    ,'product.unit as product_unit'
                )
                ->get();
            foreach ($sub_invoice as $key=>$item){
                $sub_invoice[$key]->status_fa = ShopInvoiceSub::status($item->status);
                $sub_invoice[$key]->product_img = url('/'.$item->product_img);
                $sub_invoice[$key]->pricing = ShopInvoiceSub::finance($item,$invoice->tax_percent);
            }
            return ['result'=>1,'data'=>[
                'invoice'=>$invoice,
                'sub_invoices'=>$sub_invoice
            ]];
        }else{
            return ['result'=>0,'msg'=>'فاکتور شناسایی نشد'];
        }
    }

    /**/
    function favorite(Request $request){
        $user_id = $request->input('user_id');
        $ids =  Favorite::where('user_id',$user_id)
            ->where('relate_to','product')
            ->orderby('created_at','desc')
            ->pluck('relate_id')
            ->toArray();
        $list = getProductList([
            'ids'=>!empty($ids)?$ids:[0],
            'per_page'=>$request->input('per_page',15),
            'user_id'=>$user_id
        ]);
        foreach ($list as $key=>$item){
            $list[$key]->img = url('/'.$item->img);
            $list[$key]->description = excerpt(textRaw($item->description),300);
        }
        return ['result'=>1,'data'=>$list];
    }

    /**/
    function myComment(Request $request){
        $user_id = $request->input('user_id');
        $list = DB::table('comment')
        ->leftJoin('shop_products as product','product.id','comment.relate_id')
            ->where('comment.relate_to','product')
            ->where('comment.user_id',$user_id)
            ->orderby('comment.created_at','desc')
            ->select('comment.*',
                'product.title as product_title',
                'product.img as product_img',
                'product.id as product_id')
            ->paginate($request->input('per_page',15));
        foreach ($list as $key=>$item){
            $list[$key]->relate_to_fa = Comment::relate_to($item->relate_to);
            $list[$key]->created_at_fa = vv($item->created_at);
            $list[$key]->status_fa = Comment::status($item->status);
            $list[$key]->weakness = !empty($item->weakness)?json_decode($item->weakness,JSON_UNESCAPED_UNICODE):[];
            $list[$key]->strength = !empty($item->strength)?json_decode($item->strength,JSON_UNESCAPED_UNICODE):[];
        }
        return ['result'=>1,'data'=>$list];
    }

    /**/
    function newComment(Request $request){
        $c=new CommentController();
        return $c->save_comment($request);
    }

    /**/
    function changePass(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password'=>'required',
            'password'=>'required|confirmed|min:6'
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }

        $id=$request->input('user_id');
        $user=User::find($id);
        $new_pass=$request->input('password');
        $old_password = $request->input('old_password');
        if(!Hash::check($old_password,$user->password)){
            return ['result'=>0,'msg'=>'گذر واژه فعلی را بدرستی وارد کنید'];
        }
        if(Hash::check($new_pass,$user->password)){
            return ['result'=>0,'msg'=>'نمیتوانید گذر واژه ای مشابه قبلی انتخاب کنید'];
        }
        $upd=$user->update([
            'password'=>Hash::make($new_pass)
        ]);
        if($upd)
            return ['result'=>1,'msg'=>'گذرواژه جدید با موفقیت تغییر کرد.'];
        else
            return ['result'=>0,'msg'=>'بروز رسانی گذرواژه جدید انجام نشد. دوباره تلاش کنید'];

    }





}
