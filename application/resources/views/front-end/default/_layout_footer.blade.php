<!-- Page Footer -->
<!-- color switcher -->
<div id="colorswitch-option">
    <button style="border-radius: 5px;box-shadow: 0 0 7px 3px rgb(0 0 0 / 22%);">
        <i class="fas fa-swatchbook"></i>
    </button>
    <ul>
        <li style="width: 100%;margin-bottom: 10px"><p>انتخاب رنگ قالب</p></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/amber.css"><span style="background-color: #ffab00;" onclick="switchColor('amber')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/blue.css"><span style="background-color: #2962ff;" onclick="switchColor('blue')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/brown.css"><span style="background-color: #3e2723;" onclick="switchColor('brown')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/cyan.css"><span style="background-color: #00b8d4;" onclick="switchColor('cyan')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/green.css"><span style="background-color: #00c853;" onclick="switchColor('green')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/indigo.css"><span style="background-color: #304ffe;" onclick="switchColor('indigo')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/orange.css"><span style="background-color: #ff6d00;" onclick="switchColor('orange')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/pink.css"><span style="background-color: #c51162;" onclick="switchColor('pink')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/red.css"><span style="background-color: #d50000;" onclick="switchColor('red')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/teal.css"><span style="background-color: #009688;" onclick="switchColor('teal')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/purple.css"><span style="background-color: #aa00ff;" onclick="switchColor('purple')"></span></li>
        <li data-path="{{_slash('front')}}/hamta/css/colors/yellow.css"><span style="background-color: #ffd600;" onclick="switchColor('yellow')"></span></li>
    </ul>
</div>
<!-- end color switcher -->
<?php $blog_title=\App\Models\Option::getval('blog_title')?>
<!-- Page Loader -->
@if($options['pre_loading'] == 'enable')
<div class="page-loader">
    <div class="page-loader-content">
        <div class="logo-area">
            <img src="{{url('/uploads/setting/'.$options['logo'])}}" alt="{{$blog_title}}">
        </div>
        <span class="loader"></span>
    </div>
</div>
@endif
<!-- end Page Loader -->

<footer class="main-footer">
    <div class="back-to-top">
        <div class="back-btn">
            <i class="far fa-chevron-up icon"></i>
            <span>برگشت به بالا</span>
        </div>
    </div>
    <div class="container">
        <div class="services row mb-5">
            <div class="col-md-3 col-sm-6 mb-md-0 mb-4">
                <div class="service-item">
                    <img src="{{_slash('front')}}/hamta/images/services/delivery-person.png" alt="">
                    <div class="service-item-body">
                        <h6>تحویل سریع و رایگان</h6>
                        <p>تحویل رایگان کالا برای کلیه سفارشات بیش از 500 هزار تومان</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-0 mb-4">
                <div class="service-item">
                    <img src="{{_slash('front')}}/hamta/images/services/recieve.png" alt="">
                    <div class="service-item-body">
                        <h6>۷ روز ضمانت بازگشت</h6>
                        <p>در صورت نارضایتی به هر دلیلی می توانید محصول را بازگردانید</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-0 mb-4">
                <div class="service-item">
                    <img src="{{_slash('front')}}/hamta/images/services/headset.png" alt="">
                    <div class="service-item-body">
                        <h6>پشتیبانی ۲۴ ساعته</h6>
                        <p>در صورت وجود هرگونه سوال یا ابهامی، با ما در تماس باشید</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-md-0 mb-4">
                <div class="service-item">
                    <img src="{{_slash('front')}}/hamta/images/services/debit-card.png" alt="">
                    <div class="service-item-body">
                        <h6>پرداخت آنلاین ایمن</h6>
                        <p>محصولات مدنظر خود را با خیال آسوده به صورت آنلاین خریداری کنید</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-links">
                    <h2 class="widget-title">دسته بندی کالاها</h2>
                    <?php $menu_product_items = getCatApi(0,'product'); ?>
                    <ul class="widget-list">
                        @foreach($menu_product_items as $cat1)
                        <li class="widget-list-item">
                            <a href="{{url('/product-list/'.$cat1['id'].'#'.str_replace(' ','-',$cat1['title']))}}" class="widget-list-link">{{$cat1['title']}}</a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="widget widget-links">
                    <h2 class="widget-title">پشتیانی و دسترسی سریع</h2>
                    <?php $footer_menu = getCatTree(0,'footer-menu'); ?>
                    <ul class="widget-list">
                        @foreach($footer_menu as $item)
                        <li class="widget-list-item">
                            <a href="{{$item['url']}}" class="widget-list-link">{{$item['title']}}</a>
                        </li>
                        @endforeach

                    </ul>
                </div>

            </div>
            <div class="col-md-4">
                {{--<div class="widget widget-newsletter">
                    <h2 class="widget-title">خبرنامه:</h2>
                    <div class="newsletter">
                        <form action="#" class="newsletterform">
                            <div class="form-group">
                                <input type="email" placeholder="آدرس ایمیل خود را وارد نمایید">
                                <button type="submit">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>--}}
                <div class="widget">
                    <h2 class="widget-title">
                        ما را در شبکه‌های اجتماعی دنبال کنید:
                    </h2>
                    <div class="social">
                        <ul>
                            <li>
                                <a href="{{$options['linkedin']}}" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li>
                                <a href="{{$options['twitter']}}" class="twitter"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="{{$options['instagram']}}" class="instagram"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="{{$options['telegram']}}" class="telegram"><i class="fab fa-telegram-plane"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="widget">
                    <h2 class="widget-title">اصالت فروشگاه</h2>
                    <div class="d-flex flex-wrap">
                        <div class="ml-2 mb-2">
                            {!! $options['namad1'] !!}
                        </div>
                        <div class="ml-2 mb-2">
                            {!! $options['namad2'] !!}
                        </div>
                        <div class="ml-2 mb-2">
                            {!! $options['namad3'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                <a href="#">
                    <img src="{{url('/uploads/setting/'.$options['logo'])}}" style="height: 40px" alt="{{$blog_title}}">
                </a>
            </div>
            {{--<div class="col-12">
                <div class="widget widget-links mb-2">
                    <ul class="widget-list d-flex flex-wrap justify-content-center justify-content-md-start">
                        <li class="widget-list-item ml-4">
                            <a href="#" class="widget-list-link">درباره فروشگاه</a>
                        </li>
                        <li class="widget-list-item ml-4">
                            <a href="#" class="widget-list-link">فروش در فروشگاه</a>
                        </li>
                        <li class="widget-list-item ml-4">
                            <a href="#" class="widget-list-link">فرصت های شغلی</a>
                        </li>
                        <li class="widget-list-item ml-4">
                            <a href="#" class="widget-list-link">تماس با ما</a>
                        </li>
                        <li class="widget-list-item ml-4">
                            <a href="#" class="widget-list-link">حریم خصوصی</a>
                        </li>
                    </ul>
                </div>
            </div>--}}
        </div>
        <div class="row text-center">
            <div class="col-12">
                <div class="copy-right" dir="ltr">
                    <p>{!! $options['footer_copy_write'] !!}</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end Page Footer -->
<style>
    .namad-link img{
        width: 120px;
        height: 120px;
        border:solid 1px #e5e5ea;
        border-radius: 5px;
        padding: 10px;
        background: #fff;
    }


</style>

<script>
    function switchColor(color) {
        window.vh.setMetaData('switchColor',color);
        //window.location.reload();
    }
</script>


