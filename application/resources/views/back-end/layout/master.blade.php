<!DOCTYPE html>
<html class="loading--" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->
<?php $dotSlashes=\App\Helper\Helper::dot_slashes();$auth=auth_info();
$options = \App\Models\Option::multiValue(['blog_title','notify','refresh_time','logo','logo_dark','favicon'])
?>
<head>
    <link rel="apple-touch-icon" href="{{_slash('uploads/setting/'.$options['favicon'])}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{_slash('uploads/setting/'.$options['favicon'])}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="}">
    <meta name="keywords" content="">
    <meta name="author" content="ThemeSelect">
	<meta name="csrf-token" content="{{csrf_token()}}">
    <title>داشبورد مدیریتی </title>
    {{--<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{--{!! SEO::generate() !!}--}}


    <!-- وندور استایل-->
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/animate-css/animate.css">
    <!-- راست چین استایل-->
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/style-rtl.min.css">
    <!-- استایل عمودی-->
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/themes/vertical-modern-menu-template/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/themes/vertical-modern-menu-template/style.min.css">
    <!--select2-->
    <link rel="stylesheet" href="{{$dotSlashes}}back/app-assets/vendors/select2/select2.min.css" type="text/css">
    <link rel="stylesheet" href="{{$dotSlashes}}back/app-assets/vendors/select2/select2-materialize.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/pages/form-select2.min.css">
    <!-- کاستوم استایل -->
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/custom/custom.css">
    <!--استایل من-->
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/custom/css/rtl.css">
    <!-- جی کوئری -->
    {{--<script src="{{$dotSlashes}}back/custom/js/jquery-3.5.1.min.js"></script>--}}

    <style>
        #pageLoading{
            width:100%;
            height:100%;
            background:rgba(255,255,255,0.95);
            position:fixed;
            top:0;
            right:0;
            z-index:9999
        }
        #pageLoading img{
            position:fixed;
            top:45%;
            right:48%;
            z-index:1000;
            width: 110px;
        }
    </style>
    <script>
        var $csrf_token='{{csrf_token()}}',
            $baseurl=$baseUrl='{{url('/')}}',
            $appname='{{env('APP_NAME')}}';
    </script>
    @yield('headerScript')
</head>
<body onload="loading_off()" onunload="loading_on()" class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns" style="overflow-x: hidden">
<!--لودینگ-->
<div id="pageLoading2" class="display-none-" style="position: fixed;text-align: center;width: 100%; height: 100%;background: #ffffffed;z-index: 1000;padding-top: 200px;">
    <div class="preloader-wrapper active">
        <div class="spinner-layer spinner-red-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>

    </div>
	<div>در حال بارگذاری</div>
</div>

<?php
$data_layout = isset($data_layout)?$data_layout:[];
?>

<!--هدر--->
@if(!isset($data_layout['header']) || ($data_layout['header']=='yes'))
   @include('back-end.layout.header')
@endif

<!--سایدبار راست--->
@if(!isset($data_layout['sidebar']) || ($data_layout['sidebar']=='yes'))
    @include('back-end.layout.asideRight')
@endif
<!--شروع ماجرا-->
<div id="main" style="{{isset($data_layout['sidebar']) && $data_layout['sidebar'] == 'no'?'padding-right: inherit !important;':''}}">
    <div class="row" id="app-body">
        @if(isset($head_color))<div class="content-wrapper-before gradient-45deg-indigo-purple"></div>@endif
        <div class="col s12">
            <div class="container">
                <div class="section">
                    <!--محتوای اصلی--->
                    @yield('content')
                </div>
                <!--سایدبار چپ--->
                @include('back-end.layout.asideLeft')
                <!-- مودالها -->
                <div id="intro">
                    <div class="row">
                        <div class="col s12">
                            <!-- مودالها -->
                            @yield('modal')
                        </div>
                    </div>
                </div>
                <!-- دکمه پروازی -->
                @yield('float_button')

            </div>
            <div class="content-overlay"></div>
        </div>
    </div>
</div>
<!--تنظیمات قالب--->
@include('back-end.layout.setting')
<!--فوتر-->
@if(!isset($data_layout['footer']) || ($data_layout['footer']=='yes'))
@include('back-end.layout.footer')
@endif
<!--وندور-->
<script src="{{$dotSlashes}}back/app-assets/js/vendors.min.js"></script>
<script src="{{$dotSlashes}}back/app-assets/vendors/sweetalert/sweetalert-rtl.min.js"></script>
<script src="{{$dotSlashes}}back/app-assets/vendors/select2/select2.full.min.js"></script>
<!-- تم وندور-->
<script src="{{$dotSlashes}}back/app-assets/js/plugins.min.js"></script>
{{--<script src="{{$dotSlashes}}back/app-assets/js-rtl/custom/custom-script-rtl.min.js"></script>فارسی کردن اعداد--}}
<script src="{{$dotSlashes}}back/app-assets/js/scripts/customizer.min.js"></script>
<!--تاریخ شمسی--->
<link rel="stylesheet" href="{{asset('plugin/persian_picker/js-persian-cal.css')}}">
<style>a.pcalBtn{display: none;}</style>
<script type="text/javascript" src="{{asset('plugin/persian_picker/js-persian-cal.min.js')}}"></script>
<!--فرمت ورودی -->
<script src="{{_slash()}}back/app-assets/vendors/formatter/jquery.formatter.min.js"></script>
<!----Num2persian(this.value)----->
<script src="{{_slash()}}plugin/num2persian/dist/num2persian.js" type="text/javascript"></script>
<!--اسکریپت های من-->
<script src="{{$dotSlashes}}plugin/jquery_validate/dist/jquery.validate.js"></script>
<script src="{{$dotSlashes}}back/custom/js/helper.js"></script>
<script src="{{$dotSlashes}}back/custom/js/formAjaxSubmit.js"></script>
<script>
    let $alertBox = function(obj) {
        swal({
            title:obj.title,
            text : obj.text,
            icon :obj.type,
        })
    }
</script>
<script>
    function loading_off() {
        setTimeout(function () {
            $('#pageLoading').fadeOut('normal');
            $('#pageLoading2').fadeOut('normal');
        },0);
    }
    function loading_on() {
        //$('#pageLoading').show();
    }
    $(window).bind('beforeunload', function(){
        return  loading_on();
    });
    function search_menu(term) {
        if(term.length > 0){
            $.get($baseurl+'/management/search-menu?term='+term)
                .done(function (r) {
                    $("#result_search_menu").fadeIn().html(r.data);
                })
        }else{
            $("#result_search_menu").fadeOut().html('');
        }
    }
</script>
@yield('footerScript')

@if(session('error'))
    <script>
        swal({
            title:'بروز خطا',
            text : '{!! session('error') !!}',
            icon :'warning'
        })
    </script>
@elseif(session('success'))
    <script>
        swal({
            title:'عملیات موفق',
            text : '{!! session('success') !!}',
            icon :'success'
        })
    </script>
@endif
@if($options['notify'] == 'enable')
<script>
    function notify_refresh() {
        let set = function ($count) {
            if($count){
                $("#notify-counter-i").addClass("pulse animated infinite");
                $("#notify-counter-n").html($count).removeClass('grey').addClass('red');
            }else{
                $("#notify-counter-i").removeClass("pulse animated infinite");
                $("#notify-counter-n").html(0).removeClass('red').addClass('grey');
            }
        };
        $.post('{{url('/management/notify-refresh')}}',{_token:'{{csrf_token()}}'})
            .done(function (r) {
                if(r.result){
                    set(r.data.count);
                }
            }).fail(function (e) {
                set(0);
            })
    }
    setInterval(function () {
        notify_refresh()
    },{{$options['refresh_time']}});
    $(document).ready(function () {
        notify_refresh();
    });
</script>
@endif
</body>

</html>
