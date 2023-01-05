@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
<?php use App\Models\Option; $head_color=1;?>
@section('headerScript')
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/pages/page-account-settings.min.css">
    <style>
        input[type],textarea{
            color:green;
        }
        .gateway{
            background: #eee;
            border-radius: 5px;
            padding: 10px;
            height: 100%;
        }
        .gateway input{
            color:#000;
        }
    </style>
@stop

@section('content')
    <div class="col s12">
        <div class="container">
            <section class="tabs-vertical mt-1 section">
                <div class="row">
                    <div class="col l4 s12">
                        <!-- tabs  -->
                        <div class="card-panel">
                            <ul class="tabs">
                                <li class="tab">
                                    <a href="#tab1">
                                        <i class="material-icons">brightness_low</i>
                                        <span>شبکه های اجتماعی</span>
                                    </a>
                                </li>

                            </ul>
                            <a class="btn btn-light-amber iransans w-100 mt-5" href="{{url('/management/dashboard')}}"> رفتن به داشبورد </a>
                        </div>
                    </div>
                    <div class="col l8 s12 ">
                        <!-- tabs content -->
                        <div id="tab1">
                            <div class="card-panel">
                                <h6 class="mb-5">شبکه های اجتماعی</h6>
                                <form class="formValidate form-valid send-ajax" method="post" action="{{url('/management/setting-update')}}" >
                                    <div class="row">
                                        {{csrf_field()}}
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">تلگرام</label>
                                                <input type="text" name="optionKey_telegram" dir="ltr"  value="{{Option::find_key($option,'telegram')}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">اینستاگرام</label>
                                                <input type="text" name="optionKey_instagram" dir="ltr"  value="{{Option::find_key($option,'instagram')}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">واتس اپ</label>
                                                <input type="text" name="optionKey_watsapp" dir="ltr"  value="{{Option::find_key($option,'watsapp')}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">لینکد این</label>
                                                <input type="text" name="optionKey_linkedin" dir="ltr"  value="{{Option::find_key($option,'linkedin')}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label class="active">تویتر</label>
                                                <input type="text" name="optionKey_twitter" dir="ltr"  value="{{Option::find_key($option,'twitter')}}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col s12 mt-4">
                                            <div class="input-field">
                                                <p class="active ">خلاصه متن درباره ما</p>
                                                <textarea type="text" name="optionKey_about_me" class="browser-default width-100" rows="10" autocomplete="off">{{Option::find_key($option,'about_me')}}</textarea>
                                            </div>
                                        </div>

                                        <div class="col s12 mt-4">
                                            <div class="input-field">
                                                <label class="active">لینک ادامه متن درباره ما</label>
                                                <input type="text" name="optionKey_about_me_link" dir="ltr" required value="{{Option::find_key($option,'about_me_link')}}" autocomplete="off">
                                                <span class="font-small">{SITE_URL} = ادرس سایت شما</span>
                                            </div>
                                        </div>

                                        <div class="col s12">
                                            <hr/>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="{{url('/management/dashboard')}}"> رفتن به داشبورد </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره تغییرات
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="content-overlay"></div>
    </div>
@stop

@section('modal')
@stop


@section('footerScript')

    <script>
        $('img#img1').on('load', function () {
            $("#i1").val($(this).attr('src'))
        });
        $('img#img2').on('load', function () {
            $("#i2").val($(this).attr('src'))
        });
        $('img#img3').on('load', function () {
            $("#i3").val($(this).attr('src'))
        });
        function getAddressList() {
            helper().get($baseurl+'/management/address-list/')
                .done(function (r) {
                    $("#tblListAddress").html(r.html);
                })
        }
        function deleteAddress($id){
            if(confirm('آیا مطمن هستید ؟')){
                helper().post($baseurl+'/management/address-delete',{id:$id})
                    .done(function (r) {
                        if(r.result){
                            after_done3()
                        }else{
                            swal({
                                text:r.msg,
                                icon:'warning'
                            })
                        }
                    })
            }
        }
    </script>

    <!---فایل منیجر--->
    {{--<script src="{{asset('plugin/file_manager/custom.js')}}"></script>
    <link rel="stylesheet" href="{{asset('plugin/file_manager/custom.css')}}">
    <script>
        function after_done(param) {
            window.vm.list[param.id].img = param.file;
            window.vm.edit_mode(param.id);
        }
    </script>--}}
@stop

