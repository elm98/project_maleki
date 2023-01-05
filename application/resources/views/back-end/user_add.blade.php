@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
<?php $head_color='yes'?>
@section('headerScript')
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/pages/page-account-settings.min.css">
    <!--crop image-->
    <link href="{{$dotSlashes}}plugin/crop-image/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}plugin/crop-image/pixelarity.css">
    <style type="text/css">
        #result-img{
            display: block;
            position: relative;
            margin-top: 40px;
        }
        .face{
            position: absolute;
            height: 0px;
            width: 0px;
            background-color: transparent;;
            border: 4px solid rgba(10,10,10,0.5);
            z-index: 99;
        }
        .pixelarity-img-edit-act{
            font-family: 'iranyekan';
        }
        .pixelarity-img-edit{
           z-index: 999;
        }
        .tab.disabled a span{
            color: #d6d6d6;
        }
    </style>

@stop

@section('content')
    <div class="col s12">
        <div class="container">
        <!-- Account settings -->
            <section class="tabs-vertical mt-1 section">
                <div class="row">
                    <div class="col l2 s12" >

                    </div>
                    <div class="col l8 s12">
                        <!-- tabs content -->
                        <div id="general">
                            <div class="card-panel">
                                <div class="display-flex">
                                    <div class="media">
                                        <img src="{{$dotSlashes}}back/custom/img/avatar.png" id="media-img" class="border-radius-4" alt="profile image" height="64" width="64">
                                    </div>
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <button id="select-files" onclick="$('#upfile').click()" class="btn indigo mr-2 iransans">
                                                <i class="material-icons left">crop_rotate</i>
                                                <span>یک آواتار برای خود انتخاب کنید</span>
                                            </button>
                                            <button class="btn btn-light-pink iransans" onclick="$('#upfile').val(null);$('#media-img').attr('src','{{$dotSlashes}}back/custom/img/avatar.png');$('#avatar').val('')">تنظیم مجدد</button>
                                        </div>
                                        <small>JPG یا PNG مجاز است. حداکثر اندازه 200kB</small>
                                        <div class="upfilewrapper">
                                            <input id="upfile" type="file" onchange="faceCrop(this,'media-img')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="divider mb-3 mt-1"></div>
                                <form class="formValidate form-valid send-ajax" method="post" action="{{url('/management/user-insert')}}" data-after-done="after_done">
                                    <div class="row">
                                        <input type="hidden" id="avatar" name="avatar">
                                        {{csrf_field()}}
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>نام کاربری *</label>
                                                <input type="text"  name="username" value="000" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>رمز عبور *</label>
                                                <input type="password"  name="password" required minlength="6" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>تکرار رمز عبور *</label>
                                                <input type="password"  name="password_confirmation" required minlength="6" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>نام *</label>
                                                <input name="fname" type="text" required data-msg-required="اسم کوچک را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>فامیلی *</label>
                                                <input name="lname" type="text" required data-msg-required="نام خانوادگی را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <p class=" mb-0 mt-0">موبایل *</p>
                                                <input name="mobile" type="number" maxlength="11" minlength="11" required data-msg-required="موبایل را وارد کنید" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <span class=" mb-0 mt-0">تاریخ تولد</span>
                                                <input name="birthday" type="text" id="pdate1" readonly autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <input type="hidden" name="status" value="active">
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <input name="code_melli" class="text-center" type="number" maxlength="10" minlength="10" required data-msg-required="کد ملی را وارد کنید" autocomplete="off" >
                                                <label>کد ملی *</label>
                                            </div>
                                        </div>

                                        <div class="break"></div>


                                        <div class="break"></div>



                                        <div class="col s12">
                                            <div class="row mb-5">
                                                <div class="col s12">
                                                    <label >نوع کاربر را مشخص کنید *</label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="type" required value="real" type="radio" checked onchange="$(this).is(':checked')?$('.company').hide():$('.company').show()">
                                                        <span> حقیقی </span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="type" required value="legal" type="radio" onchange="$(this).is(':checked')?$('.company').show():$('.company').hide()">
                                                        <span> حقوقی </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col m6 s12 company display-none">
                                            <div class="input-field">
                                                <label>نام شرکت *</label>
                                                <input name="owner_name" type="text" required data-msg-required="نام شرکت را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12 company display-none">
                                            <div class="input-field">
                                                <label> نام مدیر شرکت *</label>
                                                <input name="company_name" type="text" required data-msg-required="نام مدیر شرکت را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>


                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="{{url('/management/user-list')}}">برگشت به لیست </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره و ایجاد
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
    {{--<script src="{{$dotSlashes}}back/app-assets/js/scripts/page-account-settings.min.js"></script>--}}
    <script type="text/javascript" src="{{$dotSlashes}}plugin/crop-image/pixelarity-face.js"></script>
    <script>
        // without face detection
        function faceCrop(input,id){
            var img = input.files[0];
            if(!pixelarity.open(img, true, function(res){
                $("#"+id).attr("src", res);
                $("#avatar").val(res); //base64 string
                //let n=res.length;
            }, "jpeg", "png", 0.5)){
                $(input).val(null);
                $("#"+id).attr('src','{{$dotSlashes}}back/custom/img/avatar.png');
                swal({
                    text:'شما باید یک فایل تصویر را انتخاب کنید',
                    icon:'warning'
                });
            }
        }
    </script>

    <script>
        function after_done() {
            setTimeout(function () {
                window.location.href='{{url('/management/user-list')}}';
            },2000)
        }
    </script>

    <script>
        $("input[name='role']").on('change',function(){
            console.log('salam');
             if($(this).is(':checked')){
                 if($(this).val() === 'administrator'){
                     $("#permission").attr('disabled',true);
                 }else{
                     $("#permission").attr('disabled',false);
                 }
             }
        })
    </script>
@stop

