<!DOCTYPE html>
<html lang="en">
<?php
    $options = \App\Models\Option::multiValue([
        'logo',
        'logo_dark',
        'favicon',
        'blog_title',
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
        'product_level_menu'
    ]);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="{{url('/uploads/setting/'.$options['favicon'])}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{url('/uploads/setting/'.$options['favicon'])}}">
	<meta name="csrf-token" content="{{csrf_token()}}">

    {!! SEO::generate() !!}
    <?php
    $is_product = 0;
    $current_uri = \Illuminate\Support\Facades\Route::getCurrentRoute()->uri;
    if(in_array($current_uri,["product-info/{product_id}/{title?}","product/{product_id}/{title?}"])){
        $is_product = 1;
    }
    ?>
    @if($is_product)
        <meta name="product_id" content="{{$product->id}}">
        <meta name="product_name" content="{{$product->title}}">
        <meta name="product_price" content="{{$customer_price}}">
        <meta name="product_old_price" content="{{$real_price}}">
        <meta name="availability" content="{{$in_stock}}">  <!---instock or outofstock--->
        <meta property="og:image" content="{{url('/'.$product->img)}}">
        <meta property="product:condition" content="new">
        <meta property="product:availability" content="{{$in_stock}}">
    @endif

    <!-- font-awesome -->
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/font-awesome.min.css">
    <!-- Bootstrap 4.5.3 -->
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/bootstrap/css/bootstrap.min.css">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/apexcharts.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/jquery.classycountdown.min.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/nouislider.min.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/sweetalert2.min.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/select2.min.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/plugins/swiper.min.css">
    <!-- CSS Template -->
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/theme.css">
    <link rel="stylesheet" href="{{_slash('front')}}/hamta/css/custom.css">
    <!-- colors: default,amber,blue,brown,cyan,green,indigo,orange,pink,purple,red,teal,yellow -->
    <link rel="stylesheet"  href="{{_slash('front')}}/hamta/css/colors/default.css" id="colorswitch">
    <script src="{{_slash('front')}}/hamta/js/jquery-3.5.1.min.js"></script>
    <script>
        var $csrf_token = '{{csrf_token()}}';
        var $baseUrl = $baseurl = '{{url('/')}}';
        var $HAMTA = {};
    </script>
    @yield('headerScript')



</head>

<body>
<div id="shadow-cover"></div>
<div class="page-wrapper">
    <!-- Page Content -->
    <main class="page-content">
        @yield('content')
    </main>
    <!-- end Page Content -->
    @yield('modal')
</div>



<!-- JS Global Compulsory -->
<script src="{{_slash('front')}}/hamta/js/plugins/popper.min.js"></script>
<script src="{{_slash('front')}}/hamta/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Imple{{_slash('front')}}/menting Plugins -->
<script src="{{_slash('front')}}/hamta/js/plugins/apexcharts.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/jquery.ez-plus.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/jquery.knob.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/jquery.throttle.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/jquery.classycountdown.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/jquery.nicescroll.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/nouislider.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/sweetalert2.all.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/select2.full.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/swiper.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/ResizeSensor.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/theia-sticky-sidebar.min.js"></script>
<script src="{{_slash('front')}}/hamta/js/plugins/wNumb.js"></script>
<!-- JS Template -->
<script src="{{_slash('front')}}/hamta/js/theme.js"></script>
<!----Num2persian(this.value)----->
<script src="{{_slash()}}plugin/num2persian/dist/num2persian.js" type="text/javascript"></script>

<!--Toast Fire-->
<script>
    const $toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        showCloseButton: true,
        allowEscapeKey:true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    //position = 'top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end'
</script>
<!-- Here goes your custom.js -->
<script src="{{_slash('front/hamta/js/helperHamta.js')}}"></script>
<script src="{{_slash('front/custom/js/formAjaxSubmit.js')}}"></script>

@if(session('error'))
    <script>
        $toast.fire({title:'{{session("error")}}',icon:'error',position:'top-start'})
    </script>
@endif

@yield('footerScript')
</body>

</html>
