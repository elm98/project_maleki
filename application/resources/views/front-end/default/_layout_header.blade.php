<?php
$tags=\App\Models\ShopProduct::where('status','active')
    ->orderby('view_count','desc')
    ->limit(20)
    ->pluck('tags')
    ->toArray();
$more_tags=explode(',',implode(',',$tags));
$more_tags=array_unique($more_tags);
$blog_title=\App\Models\Option::getval('blog_title');
?>


<style>
    #main-menu-loader{
        position: absolute;
        width: 100%;
        height: 100%;
        background: #fff;
        z-index:9;
        text-align: center;
        padding-top: 35px;
    }
    .font-very-small{
        font-size: 5px!important;
    }
</style>
<!-- Page Header -->
<div id="app-vue-header">

    <header class="page-header">
        {{--<div class="top-page-header" style="background: #f92b52;">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="contact-list">
                        <ul>
                            <li><a style="color: #fff" href="tel: 09353501323"> <i class="fas fa-monitor-heart-rate"></i>  این اسکریپت صرفا یک پیش نمایش محصول است - محمد شجاع : 09353501323 </a></li>
                        </ul>
                    </div>
                    <div class="top-header-menu">
                        <ul>
                            <li><a id="preview-closed" href="javascript:;" onclick="$(this).closest('.top-page-header').fadeOut();setTimeout(function(){$('#preview-closed').closest('.top-page-header').remove()},1000) "><i class="fas fa-eye-slash"></i> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="container">
            <div class="bottom-page-header" >
                <div class="d-flex align-items-center">
                    <div class="site-logo">
                        <a href="{{url('/')}}">
                            <img src="{{url('/uploads/setting/'.$options['logo'])}}" alt="{{$blog_title}}" class="rounded" style="height: 40px">
                        </a>
                    </div>
                    <div class="search-box">
                        <form action="#">
                            <input v-model="term" type="text" placeholder="نام محصول یا برند را جستجو کنید...">
                            <i v-if="searchLoading" class="far fa-spinner fa-spin"></i>
                            <i v-else class="far fa-search"></i>
                        </form>
                        <div class="search-result">
                            <ul class="search-result-list do-nice-scroll" style="max-height: 300px;overflow-y: scroll;overflow-x: hidden;">
                                <li v-for="row in searchList" class="mb-2" style="border-bottom: dashed 1px #ddd;">
                                    <a class="row" :href="baseUrl+'/product/'+row.rawId">
                                        <div class="col-md-2">
                                            <img onerror="this.srt='{{_noImage('avatar.png')}}'" :src="row.img" width="50">
                                        </div>
                                        <div class="col-md-10">
                                            <p v-text="row.text.substring(0,45)" :title="row.text">عنوان محصول</p>
                                            <span style="color: #969595;font-size: 12px;" v-html="row.text2?row.text2.replaceAll('|','<i class=\'fa fa-circle font-very-small pr-1 pl-1 text-info \'></i>'):'دسته بندی یافت نشد'">دسته بندی محصول</span>
                                        </div>
                                    </a>
                                </li>
                                <li v-if="searchList.length < 1">
                                    <a href="#">هیچ موردی یافت نشد</a>
                                </li>
                            </ul>
                            <ul class="search-result-most-view">
                                <?php $i=0?>
                                @foreach($more_tags as $item)
                                    @if($i++<5)
                                        <li><a href="{{url('/product-list/?tag='.$item)}}">{{$item}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="user-items">
                    <div class="user-item">
                        <a href="{{url('/profile?action=my-favorite')}}">
                            <i class="fal fa-heart"></i>
                            <span class="bag-items-number" >0</span>
                        </a>
                    </div>
                    <div class="user-item cart-list">
                        <a href="#">
                            <i class="fal fa-shopping-basket"></i>
                            <span class="bag-items-number" v-text="cart.length"></span>
                        </a>
                        <ul>
                            <li class="cart-items">
                                <ul class="do-nice-scroll">
                                    <li class="cart-item" v-for="(row,key) in cart">
                                        <span class="d-flex align-items-center mb-2">
                                            <a :href="baseUrl+'/product-info/'+row.product_id">
                                                <img :src="baseUrl+'/'+row.img" :alt="row.title">
                                            </a>
                                            <span>
                                                <a :href="baseUrl+'/product-info/'+row.product_id">
                                                    <span class="title-item" v-text="row.title">نام کالا</span>
                                                </a><br>
                                                <span class="price" v-text="number_format(row.customer_price)+' '+currency">قیمت</span><br/>
                                                <span class="price" v-text="'تعداد: '+row.count">قیمت</span>
                                            </span>
                                        </span>
                                        <button class="remove-item" v-on:click="deleteFromCart(key)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </li>
                                    <li v-if="!cart.length">
                                        <div class="text-center pt-4 pb-4">
                                            <h6 class="title-item">سبد خرید خالی است</h6>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li v-if="cart.length" class="cart-footer">
                                <a :href="baseUrl+'/cart'" class="btn-cart">
                                    مشاهده سبد خرید
                                    <i class="mi mi-ShoppingCart"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-item account">

                        <a href="javascript:;" class="btn-auth">
                            <i class="fal fa-user-circle"></i>
                            {{auth_info()->is_login?auth_info()->user_nickname:'ورود و عضویت'}}
                        </a>

                        {{--<a href="javascript:;">
                            {{$auth->check()?$user->nickname:'ورود و عضویت'}}
                            <i class="fad fa-chevron-down text-sm mr-1"></i>
                        </a>--}}
                        <ul class="dropdown--wrapper">
                            @if(auth_info()->is_login)
                            <li class="header-profile-dropdown-account-container">
                                <a href="{{url('/profile')}}" class="d-block">
                                <span class="header-profile-dropdown-user">
                                    <span class="header-profile-dropdown-user-img">
                                        <img class="rounded-50" onerror="this.src='{{_noImage('avatar.png')}}'" src="{{_slash('uploads/avatar/'.auth_info()->user_avatar)}}">
                                    </span>
                                    <span class="header-profile-dropdown-user-info">
                                        <p class="header-profile-dropdown-user-name">{{auth_info()->user_nickname}}</p>
                                        <span class="header-profile-dropdown-user-profile-link">مشاهده حساب کاربری</span>
                                    </span>
                                </span>
                                    <span class="header-profile-dropdown-account">
                                    <span class="header-profile-dropdown-account-item">
                                        <span class="header-profile-dropdown-account-item-title">اعتبار</span>
                                        <span class="header-profile-dropdown-account-item-amount">
                                            <span class="header-profile-dropdown-account-item-amount-number">{{number_format(auth_info()->user_credit)}}</span> {{$currency}}
                                        </span>
                                    </span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile')}}"> پروفایل</a>
                            </li>
                            <li>
                                <a href="{{url('/profile?action=my-order')}}"> پیگیری سفارش</a>
                            </li>
                            @if(in_array(auth_info()->user_role,['administrator','personal','operator']) )
                            <li>
                                <a href="{{url('/management')}}">رفتن به پنل ادمین</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{url('/profile?action=store-request')}}">پنل فروشنده</a>
                            </li>
                            <li>
                                <a href="{{url('/logout')}}">خروج</a>
                            </li>
                            @else
                            <li>
                                <a href="{{url('/login')}}" class="dropdown--btn-primary">وارد شوید</a>
                            </li>
                            <li>
                                <span>کاربر جدید هستید؟</span>
                                <a href="{{url('/register')}}" class="border-bottom-dt">  ثبت نام </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <nav class="nav-wrapper ">
                <ul style="max-width: 1150px">
                    @if($options['product_mega_menu'] == 'enable')
                    <li class="category-list" id="product-category-menu">
                        <a href="#"><i class="fal fa-bars"></i>دسته بندی کالاها</a>
                        <ul>
                            <li id="main-menu-loader" v-if="menu_loading">
                                <i class="fa fa-spinner fa-spin"></i>
                                <p class="pt-2">در حال بارگذاری</p>
                            </li>
                            <li v-for="(cat1,key) in menu">
                                <a :href="'{{url('/products')}}'+(cat1.url !=''?'/'+cat1.url:'?cat_id='+cat1.id)" v-text="cat1.title"></a>
                                <ul class="row">
                                    <li class="col-12">
                                        <a :href="'{{url('/products')}}'+(cat1.url !=''?'/'+cat1.url:'?cat_id='+cat1.id)" v-text="' همه دسته‌بندی‌ های '+cat1.title"></a>
                                    </li>
                                    <li class="col-3">
                                        <span v-for="item in sub_menu[key][0]">
                                            <a v-if="item.html_type == 'cat2'" :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a>
                                            <p v-if="item.html_type == 'cat3'" class="d-sub-menu"><a :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a></p>
                                        </span>
                                    </li>
                                    <li class="col-3">
                                        <span v-for="item in sub_menu[key][1]">
                                            <a v-if="item.html_type == 'cat2'" :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a>
                                            <p v-if="item.html_type == 'cat3'" class="d-sub-menu"><a :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a></p>
                                        </span>
                                    </li>
                                    <li class="col-3">
                                        <span v-for="item in sub_menu[key][2]">
                                            <a v-if="item.html_type == 'cat2'" :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a>
                                            <p v-if="item.html_type == 'cat3'" class="d-sub-menu"><a :href="'{{url('/products')}}'+(item.url !=''?'/'+item.url:'?cat_id='+item.id)+'#'+item.unique_title" v-text="item.title"></a></p>
                                        </span>
                                    </li>
                                    <li class="col-3">
                                        <a href="#" class="list-item--image my-3">
                                            <img onerror="this.src='{{_slash('back/custom/img/no-image.png')}}'" :src="'{{_slash('uploads/media')}}/'+cat1.img" class="img-fluid rounded" alt="">
                                        </a>
                                        {{--<a href="#">برندها</a>
                                        <ul class="d-flex my-3">
                                            <li><a href="#" class="list-item--image ml-1 border rounded p-1"><img src="{{_slash('front')}}/assets/images/mega-menu/brand-1.jpg" class="img-fluid rounded" alt=""></a>
                                            </li>
                                            <li><a href="#" class="list-item--image ml-1 border rounded p-1"><img src="{{_slash('front')}}/assets/images/mega-menu/brand-2.jpg" class="img-fluid rounded" alt=""></a>
                                            </li>
                                            <li><a href="#" class="list-item--image ml-1 border rounded p-1"><img src="{{_slash('front')}}/assets/images/mega-menu/brand-3.jpg" class="img-fluid rounded" alt=""></a>
                                            </li>
                                        </ul>--}}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif

                    <?php
                    $menu_product_items = [];
                    $menu_index_items = getCatApi(0,'index-menu');
                    ?>
                    @foreach($menu_index_items as $item)
                        <li>
                            <a class="{{$item['class']}}" href="{{str_replace('{SITE_URL}',url('/'),$item['url'])}}">{!! $item['icon'] !!} {{$item['title']}}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>
    <!-- header responsive -->
    <div class="header-responsive fixed--header-top">
        <div class="header-top">
            <div class="side-navigation-wrapper">
                <button class="btn-toggle-side-navigation"><i class="far fa-bars"></i></button>
                <div class="side-navigation">
                    <div class="site-logo">
                        <a href="{{url('/')}}">
                            <img src="{{url('/uploads/setting/'.$options['logo'])}}" alt="{{$blog_title}}" class="rounded" style="height: auto">
                        </a>
                    </div>
                    <div class="divider"></div>
                    <ul class="not-list-children">
                        @foreach($menu_index_items as $item)
                            <li><a href="{{str_replace('{SITE_URL}',url('/'),$item['url'])}}" class="{{$item['class']}}">{!! $item['icon'] !!} {{$item['title']}}</a></li>
                        @endforeach
                    </ul>
                    <div class="divider"></div>

                    <ul class="category-list">
                        @if($options['product_level_menu'] == 'enable')
                        <li>
                            <a href="javascript:;" class="toggle-level-menu" style="position: static;width: auto;min-height: auto">دسته بندی محصولات</a>
                        </li>
                        @endif
                        @if($options['product_mega_menu'] == 'enable')
                        <li v-for="cat1 in menu" :class="{'has-children':cat1.children.length}">
                            <a :href="baseUrl+'/product-list?cat_id='+cat1.id+'#'+cat1.title.replace(/ /g,'-')" v-text="cat1.title"></a>
                            <ul v-if="cat1.children.length">
                                <li v-for="cat2 in cat1.children" :class="{'has-children':cat2.children.length}">
                                    <a :href="baseUrl+'/product-list?cat_id='+cat2.id+'#'+cat2.title.replace(/ /g,'-')" v-text="cat2.title"></a>
                                    <ul v-if="cat2.children.length">
                                        <li v-for="cat3 in cat2.children" >
                                            <a :href="baseUrl+'/product-list?cat_id='+cat3.id+'#'+cat3.title.replace(/ /g,'-')" v-text="cat3.title"></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="overlay-side-navigation"></div>
            </div>
            <div class="site-logo">
                <a href="{{url('/')}}">
                    <img src="{{url('/uploads/setting/'.$options['logo'])}}" alt="{{$blog_title}}" style="height: auto">
                </a>
            </div>
            <div class="header-tools">
                <div class="cart-side">
                    <a href="#" class="btn-toggle-cart-side ml-0">
                        <i class="far fa-shopping-basket"></i>
                        <span class="bag-items-number" v-text="cart.length">0</span>
                    </a>
                    <div class="cart-side-content">
                        <ul>
                            <li class="cart-items">
                                <ul>
                                    <li class="cart-item" v-for="(row,key) in cart">
                                        <span class="d-flex align-items-center mb-2">
                                            <a :href="baseUrl+'/product-info/'+row.product_id">
                                                <img :src="baseUrl+'/'+row.img" :alt="row.title">
                                            </a>
                                            <span>
                                                <a :href="baseUrl+'/product-info/'+row.product_id">
                                                    <span class="title-item" v-text="row.title">نام کالا</span>
                                                </a><br>
                                                <span class="price" v-text="number_format(row.customer_price)+' '+currency">قیمت</span><br/>
                                                <span class="price" v-text="'تعداد: '+row.count">قیمت</span>
                                            </span>
                                        </span>
                                        <button class="remove-item" v-on:click="deleteFromCart(key)">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </li>
                                    <li v-if="!cart.length">
                                        <div class="text-center pt-4 pb-4">
                                            <h6 class="title-item">سبد خرید خالی است</h6>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li v-if="cart.length" class="cart-footer">
                                <span class="d-block text-center px-2">
                                    <a :href="baseUrl+'/cart'" class="btn-cart">
                                        مشاهده سبد خرید
                                        <i class="mi mi-ShoppingCart"></i>
                                    </a>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="overlay-cart-side"></div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="search-box">
                <form action="#">
                    <input v-model="term" type="text" placeholder="نام محصول یا برند را جستجو کنید...">
                    <i v-if="searchLoading" class="far fa-spinner fa-spin"></i>
                    <i v-else class="far fa-search"></i>
                </form>
                <div class="search-result">
                    <ul class="search-result-list " style="max-height: 300px;overflow-y: scroll;overflow-x: hidden;">
                        <li v-for="row in searchList" class="mb-2" style="border-bottom: dashed 1px #ddd;">
                            <a class="row" :href="baseUrl+'/product-info/'+row.rawId">
                                <div class="col-xs-2 text-center" style="width: 25%">
                                    <img onerror="this.srt='./back/custom/img/no-image.png'" :src="row.img" width="50">
                                </div>
                                <div class="col-xs-10" style="width: 75%;padding: 0 8px">
                                    <p v-text="row.text.substring(0,40)" :title="row.text">عنوان محصول</p>
                                    <span style="color: #969595;font-size: 12px;" v-html="row.text2?row.text2.replaceAll('|','<i class=\'fa fa-circle font-very-small pr-1 pl-1 text-info \'></i>'):'دسته بندی یافت نشد'">دسته بندی محصول</span>
                                </div>
                            </a>
                        </li>
                        <li v-if="searchList.length < 1">
                            <a href="#">هیچ موردی یافت نشد</a>
                        </li>
                    </ul>
                    <ul class="search-result-most-view">
                        <?php $i=0?>
                        @foreach($more_tags as $item)
                            @if($i++<5)
                                <li><a href="./product-list?tags[]={{$item}}">{{$item}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="header-tools">
			@if(auth_info()->user_id > 0)
				<a href="{{url('/profile')}}"><i class="far fa-user-circle"></i></a>
			@else
                <a href="{{url('/login')}}"><i class="far fa-user-circle"></i></a>
			@endif
            </div>
        </div>
    </div>
    <!-- end header responsive -->
</div> <!-- End Vue --->



<!--Veu-->
<script src="{{_slash()}}plugin/vue/vue.js"></script>
<script>
    var vh;
    $(document).ready(function () {
        vh = new Vue({
            el: '#app-vue-header',
            data: {
                baseUrl:window.$baseUrl,
                term:'',
                searchList:[],
                searchLoading:false,
                searchEmpty:false,
                timer:null,
                prefix:'myShoppingOnlineSystem_',
                cart:[],
                currency:'{{$currency}}',
                number_format:function (number) {
                    return helper().number_format(number)
                },
                menu_loaded:0,
                menu_loading:0,
                menu:[],
                multi_store:'{{\App\Models\Option::getval('multiStore')}}',

            },
            mounted:function(){
                vh = this;
                /* باز کردن منوی اصلی **/
                let hoverTimeout;
                $(".category-list").hover(function () {
                    hoverTimeout =setTimeout(function () {
                        $("#product-category-menu > ul, #shadow-cover").fadeIn();
                        vh.get_main_menu();
                    },250);
                },function () {
                    clearTimeout(hoverTimeout);
                    $("#product-category-menu > ul").hide();
                    $("#shadow-cover").fadeOut();
                });
                /* صدا زدن سبد خرید **/
                vh.getCart();
                //vh.get_main_menu();

                /*اعمال رنگ قالب*/
                let $switchColor = '{{_slash('front')}}/hamta/css/colors/'+this.getMetaData('switchColor')+'.css';
                $("#colorswitch").attr('href',$switchColor);
            },
            methods:{
                /*جستجوی محصول*/
                findProduct(){
                    helper().get($baseUrl+'/find-product?q='+this.term)
                        .done(function (r) {
                            if(r.items.length){
                                vh.searchList = r.items;
                                if(vh.searchList.length < 1){
                                    vh.searchEmpty = true;
                                }else{
                                    vh.searchEmpty = false;
                                }
                            }else{
                                vh.searchList = [];
                            }
                            vh.searchLoading = false;
                        })
                        .fail(function(e){
                            vh.searchLoading = false;
                        })
                },
                /*ست کردن متا دیتا*/
                setMetaData(key,data){
                    let LS=window.localStorage;
                    let metaKey=vh.prefix+'metaData';
                    let items=LS.getItem(metaKey);
                    let myData;
                    if(items && items.length){
                        myData=JSON.parse(items);
                        myData[key]=data;
                    }else{
                        myData={};
                        myData[key]=data;
                    }
                    LS.setItem(metaKey,JSON.stringify(myData));
                },
                /*گرفتن متا دیتا*/
                getMetaData(key){
                    let LS=window.localStorage;
                    let metaKey=vh.prefix+'metaData';
                    let items=LS.getItem(metaKey);
                    if(items && items.length){
                        let val= JSON.parse(items)[key];
                        return (typeof val == 'undefined')?'':val;
                    }else{
                        return '';
                    }
                },
                /*گرفتن دیتای کارت*/
                getCart(){
                    let LS=window.localStorage;
                    let key=vh.prefix+'cart';
                    let items = LS.getItem(key);
                    let arr= JSON.parse(items);
                    if(arr){
                        this.cart = arr;
                        return arr;
                    }
                    return [];
                },
                /*ست کردن کلی سبد خرید*/
                setCart(value){
                    let LS=window.localStorage;
                    let key=vh.prefix+'cart';
                    LS.setItem(key,value);
                },
                /*افزودن به سبد خرید*/
                addToCart(obj){
                    let arr=[];
                    let LS=window.localStorage;
                    let key=vh.prefix+'cart';
                    let str = LS.getItem(key);
                    let multi_store =vh.multi_store;
                    items = JSON.parse(str);
                    if(obj.count > obj.stock_count){
                        $toast.fire({icon:'error',title:'موجودی کافی نیست'});
                        return 0;
                    }
                    if(Array.isArray(items)){
                        let find=false;
                        let store_ids = items.map(function (a) {
                            return parseInt(a.store_id);
                        });
                        if(multi_store === 'disable' && store_ids.length && !store_ids.includes(parseInt(obj.store_id))){
                            $toast.fire({icon:'error',title:'امکان انتخاب محصول از چندین فروشگاه بسته شده'});
                            return 0;
                        }

                        let count=(typeof obj.count == 'undefined')?1:obj.count;
                        find = items.filter(function (a) {
                            return a.stock_id == obj.stock_id;
                        });

                        if(find.length){
                            find[0].count += count;
                            find[0].customer_price = obj.customer_price * find[0].count;
                        }else{
                            obj.customer_price = obj.customer_price * obj.count;
                            items.push(obj);
                        }
                        arr = items;
                    }
                    else{
                        obj.customer_price = obj.customer_price * obj.count;
                        arr.push(obj);
                    }
                    LS.setItem(key,JSON.stringify(arr));
                    $toast.fire({icon:'success',title:helper().excerpt(obj.title,19,'...')+' '+'به سبد اضافه شد'});
                    vh.getCart();
                },
				/*جایگزین*/
				addToCart2(obj){
                    let arr = [];
                    let LS = window.localStorage;
                    let key=vh.prefix + 'cart';
                    let str = LS.getItem(key);
                    let items = JSON.parse(str);

                    if(obj.count > obj.stock_count){
                        $toast.fire({icon:'error',title:'موجودی کافی نیست'});
                        return 0;
                    }console.log(obj);
                    if (items && items.length ) {
                        let store_ids = items.map(function (a) {return parseInt(a.store_id);});
                        if(vh.multi_store === 'disable' && store_ids.length && !store_ids.includes(parseInt(obj.store_id))){
                            $toast.fire({icon:'error',title:'امکان انتخاب محصول از چندین فروشگاه بسته شده'});
                            return 0;
                        }
                        let find = items.filter(function (i){
                            return parseInt(i.stock_id) == parseInt(obj.stock_id);
                        });
                        if(find.length){
                            find[0].count += 1;
                        }else{
                            items.push(obj);
                        }
                        arr = items;
                    } else {
                        arr.push(obj);
                    }
                    LS.setItem(key, JSON.stringify(arr));
                    $toast.fire({icon:'success',title:helper().excerpt(obj.title,19,'...')+' '+'به سبد اضافه شد'});
                    vh.getCart();
                },
                /*حذف از سبد خرید*/
                deleteFromCart(itemKey){
                    let LS=window.localStorage;
                    let key=vh.prefix+'cart';
                    let str = LS.getItem(key);
                    items = JSON.parse(str);
                    if(Array.isArray(items)){
                        let item = items[itemKey];
                        items.splice(itemKey,1);
                        LS.setItem(key,JSON.stringify(items));
                        vh.getCart();
                        $toast.fire({icon:'warning',title:helper().excerpt(item.title,19,'...')+' '+'از سبد حذف شد'});
                    }
                },
                /*خالی کردن سبد خرید*/
                emptyCart(){
                    let LS=window.localStorage;
                    let key=vh.prefix+'cart';
                    LS.setItem(key,JSON.stringify([]));
                },
                /*افزودن تعداد*/
                plusCart(key){
                    let LS=window.localStorage;
                    let index=vh.prefix+'cart';
                    let str = LS.getItem(index);
                    let items = JSON.parse(str);
                    if(Array.isArray(items)){
                        items[key].count++;
                        LS.setItem(index,JSON.stringify(items));
                    }
                },
                /*کم کردن تعداد*/
                minusCart(key){
                    let LS=window.localStorage;
                    let index=vh.prefix+'cart';
                    let str = LS.getItem(index);
                    let items = JSON.parse(str);
                    if(Array.isArray(items)){
                        if(items[key].count > 1){
                            items[key].count--;
                            LS.setItem(index,JSON.stringify(items));
                        }else{
                            $toast.fire({icon:'warning',title:'تعداد نمیتواند کمتر از یک باشد'});
                        }
                    }
                },
                /*افزودن به علاقه مندی*/
                add_to_favorite($relate_to,$relate_id,t){
                    helper().post('{{url("/add-to-favorite")}}',{
                        relate_to:$relate_to,
                        relate_id:$relate_id
                    }).done(function (r) {
                        if(r.result == 1){
                            $toast.fire({
                                title:r.msg,
                                icon:'success',
                                position:'center-center',
                            });
                            $(t).addClass('added');
                        }else if(r.result == 2){
                            $toast.fire({
                                title:r.msg,
                                icon:'success',
                                position:'center-center',
                            });
                            $(t).removeClass('added');
                        }
                        else{
                            $toast.fire({
                                title:r.msg,
                                icon:'warning',
                                position:'center-center',
                            });

                        }
                    })
                },
                /*آیتمهای منوی اصلی*/
                get_main_menu(){
                    let url = '{{url('/')}}';
                    if(!vh.menu_loaded){
                        vh.menu_loading = 1;
                        helper().get(url+'/?action=main-menu')
                            .done(function (r) {
                                if (r.result) {
                                    vh.menu_loaded =1;
                                    vh.menu = r.data;
                                    setTimeout(function () {
                                        $HAMTA.CategoryList();
                                        $HAMTA.ResponsiveHeader();
                                    },500)
                                }
                                vh.menu_loading = 0;
                            })
                            .fail(function (e) {
                                vh.menu_loading = 0;
                            });
                    }
                },
            },
            watch: {
                term(v){
                    vh.searchLoading = true;
                    if(v.length){
                        clearTimeout(vh.timer);
                        vh.timer=setTimeout(vh.findProduct,1000);
                    }else{
                        vh.searchList = [];
                        vh.searchLoading = false;
                    }
                },
            },
            computed:{
                sub_menu:function () {
                    let $all=[];
                    this.menu.forEach(function (cat1,k) {
                        if(cat1.hasOwnProperty('children')){
                            $all[k]=[];
                            cat1.children.forEach(function (cat2) {
                                $all[k].push({
                                    id:cat2.id,
                                    title:cat2.title,
                                    unique_title:cat2.title.replace(/ /g,'-'),
                                    img:cat2.img,
                                    url:cat2.url,
                                    value:cat2.value,
                                    html_type:'cat2',
                                });
                                if(cat2.children.length){
                                    cat2.children.forEach(function (cat3) {
                                        $all[k].push({
                                            id:cat3.id,
                                            title:cat3.title,
                                            unique_title:cat3.title.replace(/ /g,'-'),
                                            img:cat3.img,
                                            url:cat3.url,
                                            value:cat3.value,
                                            html_type:'cat3',
                                        });
                                    })
                                }
                            });
                        }
                    });
                    let $cols=[];
                    let $step = 13;
                    $all.forEach(function (v,index) {
                        let $b1=[],
                            $b2=[],
                            $b3=[];
                        v.forEach(function (item,k) {
                            if(k>=0 && k<$step){
                                $b1.push(item);
                            }
                            if(k>=$step && k<$step * 2){
                                $b2.push(item);
                            }
                            if(k>=$step * 2 && k<$step * 3){
                                $b3.push(item);
                            }
                        });
                        $cols.push([$b1,$b2,$b3]);
                    });
                    return $cols;
                }
            }
        });
    });
</script>



