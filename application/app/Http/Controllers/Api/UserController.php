<?php

namespace App\Http\Controllers\Api;

use App\Helper\Helper;
use App\Http\Controllers\Shop\StoreController;
use App\Http\Controllers\TicketController;
use App\Models\Option;
use App\Models\ShopInvoice;
use App\Models\ShopInvoiceSub;
use App\Models\ShopProduct;
use App\Models\ShopStore;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**/
    function myAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $user_id = $request->input('user_id');
        $list = UserAddress::leftJoin('locate as state','state.id','user_address.state')
            ->leftJoin('locate as city','city.id','user_address.city')
            ->where('user_address.user_id',$user_id)
            //->where('user_address.status','active')
            ->select('user_address.*'
                ,'state.name as state_name'
                ,'city.name as city_name'
            )
            ->orderby('created_at','asc')
            ->get();
        return ['result'=>1,'data'=>$list];
    }

    /**/
    function editAddress(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'state'=>'required|exists:locate,id',
            'city'=>'required|exists:locate,id',
            'zip_code'=>'required',
            //'address'=>'required|unique:user_address,address,',$request->input('id'),
            'address'=>'required',
            'nickname'=>'required',
            'mobile'=>   'required|numeric|digits:11|regex:/(09)[0-9]/',
        ],[
            'mobile.required'=>'شماره موبایل را وارد کنید',
            'mobile.unique'=>'شماره موبایل تکراری است',
            'mobile.regex'=>'فرمت موبایل را رعایت کنید',
            'mobile.digits'=>'موبایل باید 11 رقمی باشد',
            'state.required'=>'استان را انتخاب کنید',
            'state.exists'=>'استان معتبر نیست',
            'city.required'=>'شهر را انتخاب کنید',
            'city.exists'=>'شهر معتبر نیست',
            'zip_code.required'=>'کد پستی را وارد کنید',
            'address.required'=>'ادرس را وارد کنید',
            'address.unique'=>'چنین ادرسی قبلا در سامانه ثبت شده',
            'nickname.required'=>'نام گیرنده را وارد کنید',

        ]);
        if ($validator->fails()) {
            return ['result'=>0,'msg'=>$validator->messages()->first()];
        }
        $id=intval($request->input('id'));
        $user_id = $request->input('user_id');
        $arr=[
            'user_id'=>$user_id,
            'nickname'=>$request->input('nickname'),
            'mobile'=>$request->input('mobile'),
            'tel'=>$request->input('tel'),
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'zip_code'=>$request->input('zip_code'),
            'address'=>$request->input('address'),
            'lat'=>$request->input('lat',''),
            'lng'=>$request->input('lng',''),
            'status'=>'active',
            'sort'=>1
        ];
        if($id > 0){
            $action = UserAddress::where('id',$id)->update($arr);
        }else{
            $action = UserAddress::insert($arr);
        }
        if($action)
            return ['result'=>1,'msg'=>'درخواست با موفقیت انجام شد'];
        else
            return ['result'=>0,'msg'=>'خطای غیره منتظره لطفا دوباره تلاش کنید'];
    }

    /**/
    function deleteAddress(Request $request){
        $this->validate($request,[
            'id'=>'required',
        ]);
        $id=intval($request->input('id'));
        if(UserAddress::where('id',$id)->delete())
            return ['result'=>1,'msg'=>'آدرس انتخاب شده با موفقیت حذف شد'];
        else
            return ['result'=>0,'msg'=>'ایتمی برای حذف پیدا نشد'];
    }

    /**/
    function profile(Request $request){
        switch ($request->input('action')){
            case 'profile-edit':
                return $this->profile_edit($request);
            case 'my-order':
                return $this->profile_order($request);
            case 'order-info':
                return $this->profile_order_info($request);
            case 'my-favorite':
                return $this->profile_favorite($request);
            case 'my-comment':
                return $this->profile_comment($request);
            case 'my-address':
                return $this->profile_address($request);
            case 'my-password':
                return $this->profile_password($request);
            case 'change-password':
                return $this->change_pass($request);
            case 'my-ticket':
                return $this->profile_ticket($request);
            case 'my-new-ticket':
                return $this->profile_new_ticket($request);
            case 'ticket-message':
                return $this->profile_ticket_message($request);
            case 'ticket-closed':
                return $this->profile_ticket_closed($request);
            case 'store-request':
                return $this->profile_store_request($request);
            case 'store-insert':
                return $this->profile_store_insert($request);
            case 'my-store-info':
                return $this->profile_store_info($request);
            default :
                return $this->profile_show($request);
        }
    }

    /**/
    function profile_show(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - پروفایل مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile');
        }else{
            return redirect('/login');
        }

    }

    /**/
    function profile_edit(Request $request){
        $this->validate($request,[
            'fname'=>    'required',
            'lname'=>    'required',
            //'mobile'=>   'required|numeric|digits:11|unique:users,mobile|regex:/(09)[0-9]/',
            'state'=>    'required|numeric|min:1',
            'city'=>     'required|numeric|min:1',
            'sex'=>      'required|in:man,woman',
            'birthday'=> 'required'
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
        if(!auth()->check()){
            return ['result'=>1,'msg'=>'برای ویرایش اطلاعات شخص ابتدا باید وارد شوید'];
        }
        $id = auth()->user()->id;
        $birthday=toMiladi($request->input('birthday',null));
        //return $birthday;
        $fname=$request->input('fname');
        $lname=$request->input('lname');
        $array=[
            'nickname'=>$fname.' '.$lname,
            'fname'=>$fname,
            'lname'=>$lname,
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'birthday'=>$birthday,
            'sex'=>$request->input('sex'),
            'code_melli'=>$request->input('code_melli'),
            'edit_by'=>auth()->user()->id,
            'updated_at'=>Carbon::now(),
        ];
        $up=User::where('id',$id)->update($array);
        if($up){
            $user=User::find($id);
            $avatar= $request->input('avatar','');
            if(!empty($avatar)){
                $old_avatar=glob(Helper::basePath().'/uploads/avatar/'.$user->avatar);
                foreach ($old_avatar as $a){
                    if(is_file($a))
                        unlink($a);
                }
                $name=hashId($id).rand(0,999999);
                if($ret=saveBase64($avatar,$name,'avatar')){
                    $user->avatar=$ret;
                }
            }
            $user->save();
            return response()->json(['result'=>1,'msg'=>'ویرایش با موفقیت انجام شد .','user'=>$user]);
        }
        return response()->json(['msg'=>'متاسفانه در اجرای درخواست خطایی رخ داده']);
    }

    /**/
    function profile_order(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - سفارشات مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile-order');
        }else{
            return redirect('/login');
        }
    }

    /**/
    function profile_order_info(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - جزییات سفارشات مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        $id=$request->input('id',0);
        $invoice=ShopInvoice::find($id);
        if($invoice){
            $sub_invoice=ShopInvoiceSub::leftJoin('shop_store as store','store.id','shop_invoice_sub.store_id')
                ->leftJoin('shop_color as color','color.id','shop_invoice_sub.color_id')
                ->leftJoin('shop_size as size','size.id','shop_invoice_sub.size_id')
                ->where('shop_invoice_sub.invoice_id',$id)
                ->select(
                    'shop_invoice_sub.*'
                    ,'color.title as color_title'
                    ,'color.code as color_code'
                    ,'size.title as size_title'
                    ,'store.title as store_title'
                )
                ->get();
            return view('front-end.profile-order-info',compact('invoice','sub_invoice'));
        }else{
            return redirect()->back()->with(['error'=>'سفارشی شناسایی نشد']);
        }
    }

    /**/
    function profile_favorite(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - علاقه مندی های مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile-favorite');
        }else{
            return redirect('/login');
        }
    }

    /**/
    function profile_comment(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - نظرات مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile-comment');
        }else{
            return redirect('/login');
        }
    }

    /**/
    function profile_address(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - آدرسهای مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);

        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile-address');
        }else{
            return redirect('/login');
        }

    }

    /**/
    function profile_password(Request $request){
        $meta=[
            'url'=>url('/'),
            'pageTitle'=>Option::getval('blog_title').' - تغییر رمز عبور مشتری',
            'description'=>Option::getval('description'),
            'tags'=>Option::getval('tags'),
            'type'=>'article' ,//articles |
            'image'=>_slash('uploads/setting/'.Option::getval('logo_small')),
            'image_url'=>url('uploads/setting/'.Option::getval('logo_small')),
        ];

        $this->seo($meta);
        /******Actions *********/
        if(auth()->check()){
            return view('front-end.profile-password');
        }else{
            return redirect('/login');
        }

    }

    /*تغییر پسورد*/
    function change_pass(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'old_password'=>'required',
            'password'=>'required|confirmed|min:6'
        ]);
        $id=Helper::unHash($request->input('id'));
        $user=User::find($id);
        $new_pass=$request->input('password');
        $old_password = $request->input('old_password');
        if(!Hash::check($old_password,$user->password)){
            return response()->json(['result'=>0,'msg'=>'گذر واژه فعلی را بدرستی وارد کنید']);
        }
        if(Hash::check($new_pass,$user->password)){
            return response()->json(['result'=>0,'msg'=>'نمیتوانید گذر واژه ای مشابه قبلی انتخاب کنید']);
        }
        $upd=$user->update([
            'password'=>Hash::make($new_pass)
        ]);
        if($upd)
            return response()->json(['result'=>1,'msg'=>'گذرواژه جدید با موفقیت تغییر کرد.']);
        else
            return response()->json(['result'=>0,'msg'=>'بروز رسانی گذرواژه جدید انجام نشد. دوباره تلاش کنید']);
    }

    /**/
    function profile_ticket(Request $request){
        return view('front-end.profile-ticket');
    }

    /**/
    function profile_ticket_message(Request $request){

        if($request->method() == 'GET'){
            $this->validate($request,[
                'ticket_id'=> 'required|exists:ticket,id',
            ],[
                'ticket_id.required'=>'تیکت شناسایی نشد',
                'ticket_id.exists'=>'تیکت شناسایی نشد',
            ]);
            $ticket_id = $request->input('ticket_id');
            return view('front-end.profile-ticket-message',compact('ticket_id'));
        }else{
            $t=new TicketController();
            return $t->ticket_save($request);
        }
    }

    /**/
    function profile_new_ticket(Request $request){
        $this->validate($request,[
            'subject'=> 'required|min:3',
            'department'=> 'required',
            'priority'=> 'required',
            'content'=> 'required',
        ],[
            'subject.required'=>'موضوع را وارد نمایید',
            'subject.min'=>'موضوع باید حداقل 3 حرف باشد',
            'department.required'=>'دپارتمان را انتخاب کنید',
            'priority.required'=>'اولویت را مشخص کنید',
            'content.required'=>'محتوا را وارد نمایید',
        ]);


        $arr = [
            'customer_id'=>auth()->user()->id,
            'subject'=>$request->input('subject'),
            'priority'=>$request->input('priority'),
            'department'=>$request->input('department'),
            'status'=>'new',
            'created_at'=>Carbon::now()
        ];

        if($id = Ticket::insertGetId($arr)){
            $content=$request->input('content');
            $request->request->add(['ticket_id'=>hashId($id),'content'=>$content]);
            $t=new TicketController();
            return $t->ticket_save($request);
        }else{
            return ['result'=>0,'msg'=>'خطایی رخ داده دوباره تلاش کنید'];
        }

    }

    /**/
    function profile_ticket_closed(Request $request){
        $t=new TicketController();
        return $t->ticket_closed($request);
    }

    /**/
    function profile_store_request(Request $request){
        return view('front-end.profile-store-request');
    }

    /**/
    function profile_store_insert(Request $request){
        $s= new StoreController();
        $user_id=auth()->user()->id;
        $request->request->add([
            'opened'=>'open',
            'status'=>'waiting',
            'user_id'=>hashId($user_id),
        ]);
        $r = $s->store_insert($request);
        if($r['result']){
            session([
                'find_store'=>$r['id'],
                'status_store'=>'waiting'
            ]);
            sendNotify('store_request',[
                'user_id'=>$user_id,
                'mobile'=>Option::getval('mobile'),
                'email'=>Option::getval('email')
            ]);
        }
        return $r;
    }

    /**/
    function profile_store_info(Request $request){
        if($request->method() == 'GET'){
            return view('front-end.profile-store-info');
        }else{
            $s= new StoreController();
            $user_id=auth()->user()->id;
            $store_id = session('find_store');
            $store = ShopStore::find($store_id);
            $request->request->add([
                'opened'=>'open',
                'status'=>$store->status,
                'user_id'=>hashId($user_id),
                'id'=>hashId($store_id)
            ]);
            $r = $s->store_update($request);
            /*if($r['result']){
                session([
                    'find_store'=>$r['id'],
                    'status_store'=>'waiting'
                ]);
                sendNotify('store_request',[
                    'user_id'=>$user_id,
                    'mobile'=>Option::getval('mobile'),
                    'email'=>Option::getval('email')
                ]);
            }*/
            return $r;
        }

    }

    /**/
    function profile_store_products(Request $request){
        if($request->method() == 'GET'){
            return view('front-end.profile-store-products');
        }else{
            $status=$request->input('status','all');
            $cat1  =$request->input('cat1','-1');
            $cat2  =$request->input('cat2','-1');
            $cat3  =$request->input('cat3','-1');
            $cats  =$request->input('cats',[]);
            $store  =$request->input('store','-1');
            $is_count  =$request->input('is_count','all');
            $data = ShopProduct::leftJoin('shop_stock_room as stock','stock.product_id','shop_products.id')
                ->leftJoin('categories as cat1','cat1.id','shop_products.cat1')
                ->leftJoin('categories as cat2','cat2.id','shop_products.cat2')
                ->leftJoin('categories as cat3','cat3.id','shop_products.cat3')
                ->where(function ($q) use ($status){
                    if(in_array($status,['all','0','']))
                        return 1;
                    else
                        return $q->where('shop_products.status',$status);
                })
                ->where(function ($q) use ($cat1){
                    if(in_array($cat1,['','all',0,'0','-1']))
                        return 1;
                    return $q->where('shop_products.cat1',$cat1);
                })
                ->where(function ($q) use ($cat2){
                    if(in_array($cat2,['','all',0,'0','-1']))
                        return 1;
                    return $q->where('shop_products.cat2',$cat2);
                })
                ->where(function ($q) use ($cat3){
                    if(in_array($cat3,['','all',0,'0','-1']))
                        return 1;
                    return $q->where('shop_products.cat3',$cat3);
                })
                ->where(function ($q) use ($cats){
                    if(count($cats))
                        return $q->whereIn('shop_products.cat3',$cats);
                    return 1;
                })
                ->where(function ($q) use ($store){
                    if(in_array($store,['all',0,'0','-1']))
                        return 1;
                    return $q->where('stock.store_id',$store);
                })
                ->where(function ($q) use ($is_count){
                    if($is_count == 'yes'){
                        return $q->where('stock.count','>',1);
                    }elseif($is_count == 'no'){
                        return $q->where('stock.count','<',1);
                    }else{
                        return 1;
                    }
                })
                ->groupby('shop_products.id')
                ->select(
                    'shop_products.*',
                    'cat1.title as cat_title1',
                    'cat2.title as cat_title2',
                    'cat3.title as cat_title3'
                );

            $dt=Datatables::of($data);
            $dt->editColumn('checked',function ($data){
                return '<label>'.hashId($data->id).'</label>';
            });
            $dt->editColumn('title',function ($data){
                return '<a href="./profile?action=my-store-product-edit&id='.hashId($data->id).'" title="'.$data->title.'">'.imageTitle($data->img,$data->title ).'</a>';
            });
            $dt->editColumn('categories',function ($data){
                return '<span >'.$data->cat_title1.' > '.$data->cat_title2.' > '.$data->cat_title3.'</span>';
            });
            $dt->editColumn('status',function ($data){
                return status_color($data->status,ShopProduct::status($data->status));
            });
            $dt->editColumn('created_at',function ($data){
                return alphaDate($data->created_at);
            });
            $dt->addColumn('action',function ($data){
                return actionTable([
                    '<a class="teal-text" href="./profile?action=my-store-product-edit&id='.hashId($data->id).'" >نمایش</a>',
                    '<a class="blue-text" href="./profile?action=store-quantity&id='.hashId($data->id).'" > موجودی</a>',
                ]);
            });
            return $dt->escapeColumns(null)->make(true);
        }

    }

    /**/
    function profile_store_product_add(Request $request){
        if($request->method() == 'GET'){
            return view('front-end.profile-store-product-add');
        }else{
            $p = new \App\Http\Controllers\Shop\ProductController();
            $tags_str = str_replace('،',',',$request->input('tags',''));
            $tags = explode(',',$tags_str);
            $request->request->add([
                'status'=>'waiting_accept',
                'tags'=>$tags,
            ]);
            $r= $p->insert_product($request);
            return $r;
        }
    }

    /**/
    function profile_store_product_edit(Request $request){
        $this->validate($request,[
            'id'=>'required',
        ]);
        $id = unHashId($request->input('id'));
        return view('front-end.profile-store-product-edit',compact('id'));
    }

    /**/
    function profile_store_quantity(Request $request){
        $action2 = $request->input('action2');
        $id = $request->input('id',0);

        if(!empty($action2)){
            $p = new \App\Http\Controllers\Shop\ProductController();
            $request->request->add(['action'=>$action2]);
            return $p->product_quantity($request,$id);
        }else{
            $this->validate($request,[
                'id'=>'required',
            ]);
            $id = unHashId($request->input('id'));
            return view('front-end.profile-store-quantity',compact('id'));
        }
    }

    /**/
    function profile_store_orders(Request $request){
        if($request->method() == 'GET'){
            return view('front-end.profile-store-orders');
        }
        else{
            $store_id=session('find_store');
            $status=$request->input('status','all');
            $invoice=tblPrefix().'invoice';
            $data = DB::table('shop_invoice as invoice')
                ->join('shop_invoice_sub as sub','sub.invoice_id','invoice.id')
                ->leftJoin('users','users.id','invoice.customer_id')
                ->where('sub.store_id',$store_id)
                ->where(function ($q) use($status){
                    if($status == 'all')
                        return 1;
                    return $q->where('invoice.status','processing')
                        ->where('sub.status','review');
                })
                ->groupBy('invoice.id')
                ->select(
                    'invoice.*',
                    'users.avatar',
                    'users.nickname',
                    'users.username'
                )
                ->selectRaw("(
                ($invoice.customer_price - ($invoice.coupon_cart_percent * $invoice.customer_price)) +
                ($invoice.tax_percent * $invoice.customer_price) +
                ($invoice.shipping_price) -
                ($invoice.reject_price)
                ) as customer_paid"
                )
            ;
            $dt=Datatables::of($data);
            $dt->editColumn('checked',function ($data){
                return '<span>'.hashId($data->id).'</span>';
            });
            $dt->editColumn('customer_id',function ($data){
                return '<a href="invoice/?id='.hashId($data->id).'&action=edit">'.imageTitle('uploads/avatar/'.$data->avatar,excerpt($data->nickname,19) ).'</a>';
            });
            $dt->editColumn('status',function ($data){
                return status_color($data->status,'<span class="font-small">'.ShopInvoice::status($data->status).'<span>');
            });
            $dt->editColumn('payment_status',function ($data){
                return '<span class="font-small">'.ShopInvoice::payment_status($data->payment_status).'</span>';
                return status_color($data->payment_status,'<span class="font-small">'.ShopInvoice::payment_status($data->payment_status).'<span>');
            });
            $dt->editColumn('payment_method',function ($data){
                return status_color($data->payment_method,Transaction::payment_method($data->payment_method));
            });
            $dt->editColumn('created_at',function ($data){
                return '<span class="font-small">'.alphaDate($data->created_at) .'</span>';
            });
            $dt->addColumn('tax_percent',function ($data){
                return '<span>'.$data->customer_price * $data->tax_percent.'</span>';
            });
            $dt->addColumn('action',function ($data){
                return actionTable([
                    '<a class="item-edit" href="./profile?action=my-store-order-info&id='.hashId($data->id).'">نمایش جزییات</a>'
                ]);
            });
            return $dt->escapeColumns(null)->make(true);
        }
    }

    /**/
    function profile_store_order_info(Request $request){

        /******Actions *********/
        $id=unHashId($request->input('id',0));
        $store_id = $store_id=session('find_store');
        $invoice=ShopInvoice::find($id);
        if($invoice){
            $tbl = tblPrefix()."shop_invoice_sub";
            $sub_invoice=ShopInvoiceSub::leftJoin('shop_store as store','store.id','shop_invoice_sub.store_id')
                ->leftJoin('shop_color as color','color.id','shop_invoice_sub.color_id')
                ->leftJoin('shop_size as size','size.id','shop_invoice_sub.size_id')
                ->where('shop_invoice_sub.invoice_id',$id)
                ->where('shop_invoice_sub.store_id',$store_id)
                ->select(
                    'shop_invoice_sub.*'
                    ,'color.title as color_title'
                    ,'color.code as color_code'
                    ,'size.title as size_title'
                    ,'store.title as store_title'
                )
                ->get();
            return view('front-end.profile-store-order-info',compact('invoice','sub_invoice'));
        }else{
            return redirect()->back()->with(['error'=>'سفارشی شناسایی نشد']);
        }
    }

    /**/
    function profile_store_order_status(Request $request){
        $invoice_id=unHashId($request->input('invoice_id',0));
        $store_id = $store_id=session('find_store');
        ShopInvoiceSub::where('invoice_id',$invoice_id)
            ->where('store_id',$store_id)
            ->update(['status'=>'done']);
        return ['result'=>1,'msg'=>'بروز رسانی وضعیت زیرفاکتور ها انجام شد'];

    }

    /**/
    function profile_store_transactions(Request $request){
        if($request->method() == 'GET'){
            return view('front-end.profile-store-transactions');
        }
        else{
            $store_id=session('find_store');
            $relate_to=$request->input('relate_to','all');
            $data=Transaction::leftJoin('users','users.id','transaction.user_to')
                ->leftJoin('shop_store as store','store.user_id','transaction.user_to')
                ->whereIn('transaction.relate_to',['store_clearing','store_income','store_refer'])
                ->where(function ($q) use($relate_to){
                    return in_array($relate_to,[null,'','all','0'])
                        ? 1
                        : $q->where('transaction.relate_to',$relate_to);
                })
                ->where('transaction.relate_id',$store_id)
                ->where(function ($q)use($request){
                    $date = $request->input('date1');
                    if(!empty($date))
                        return $q->where('transaction.created_at','>=',toMiladi($date,'00:01:01'));
                    return 1;
                })
                ->where(function ($q)use($request){
                    $date = $request->input('date2');
                    if(!empty($date))
                        return $q->where('transaction.created_at','<=',toMiladi($date,'23:59:59'));
                    return 1;
                })
                ->select('transaction.*','users.nickname','users.avatar','store.title as store_title');
            $dt=Datatables::of($data);

            /*****************field*******************/
            $dt->addColumn('checked', function ($data){
                return '';
            });
            $dt->editColumn('nickname',function ($data){
                return imageTitle('uploads/avatar/'.$data->avatar,$data->nickname,30).'<br/><span class="font-small blue-text">'.$data->store_title.'</span>';
            });
            $dt->editColumn('in_out',function ($data){
                $color = $data->in_out == 'in'?'green':'red';
                return '<span class="bullet '.$color.'"></span><small>'.Transaction::in_out($data->in_out).'</small>';
            });
            $dt->editColumn('payment_method',function ($data){
                return Transaction::payment_method($data->payment_method);
            });
            $dt->editColumn('relate_to',function ($data){
                $color = $data->in_out == 'in'?'green':'red';
                $html = '<span class="bullet '.$color.'"></span>';
                $html .= Transaction::relate_to($data->relate_to);
                return $html;
            });
            $dt->editColumn('created_at',function ($data){
                return '<span class="font-small" title="'.Helper::alphaDate($data->created_at).'">'.Helper::alphaDateTime($data->created_at).'</span>';
            });
            $dt->addColumn('action', function ($data) {
                //$html='<a href="'.url('/management/edit/'.Helper::hash($data->id)).'" title="ویرایش" class="mr-5"><i class="material-icons circle dt-icon">edit</i></a>';
                //$html='<a href="javascript:;" title="حذف" class="mr-5" onclick="helper().one_row_delete(this,'.$data->id.',\'transaction-delete\')"><i class="material-icons red-text circle dt-icon" >delete</i></a>';
                return  $html='';
            });
            return $dt->escapeColumns(null)
                ->with('total', $data->sum('amount'))
                ->make(true);
        }
    }

    /*تنظم سئو صفحه*/
    function seo($meta){
        SEOMeta::setTitle($meta['pageTitle']);
        SEOMeta::setDescription($meta['description']);
        SEOMeta::setCanonical($meta['url']);
        SEOMeta::addKeyword($meta['tags']);

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
