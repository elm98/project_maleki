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
                    <div class="col l4 s12">
                        <!-- tabs  -->
                        <div class="card-panel">
                            <ul class="tabs">
                                <li class="tab">
                                    <a href="#general">
                                        <i class="material-icons">brightness_low</i>
                                        <span>عمومی</span>
                                    </a>
                                </li>
                                <li class="tab" disabled>
                                    <a href="#change-password">
                                        <i class="material-icons">lock_open</i>
                                        <span>تغییر رمز عبور</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#address">
                                        <i class="material-icons">add_location</i>
                                        <span> آدرسها</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#social-link">
                                        <i class="material-icons">chat_bubble_outline</i>
                                        <span>پیوندهای اجتماعی</span>
                                    </a>
                                </li>
                                <li class="tab" style="visibility: hidden">
                                    <a href="#notifications">
                                        <i class="material-icons">notifications_none</i>
                                        <span> اطلاعیه</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 center-align">
                                        <p class="bold purple-text">{{$user->username}}</p>
                                        <p class="bold purple-text">{{$user->email}}</p>
                                        <div class="divider mt-3 mb-5"></div>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">نام :</span>
                                        <span class="right bold blue-text">{{$user->nickname}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">موبایل :</span>
                                        <span class="right bold blue-text">{{$user->mobile}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">نقش کاربری :</span>
                                        <span class="right bold blue-text">{{\App\Models\User::role($user->role)}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">استان :</span>
                                        <span class="right bold blue-text">{{$user->state_fa}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">شهر :</span>
                                        <span class="right bold blue-text">{{$user->city_fa}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">اعتبار :</span>
                                        <span class="right bold blue-text">{{number_format($user->credit)}} {{\App\Models\Option::getval('currency')}}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">وضعیت :</span>
                                        <span class="right bold blue-text">{!! \App\Helper\Helper::status_color($user->status,\App\Models\User::status($user->status)) !!}</span>
                                    </div>
                                    <div class="col s12 mb-5">
                                        <span class="left">کد معرفی به دوستان :</span>
                                        <span class="right bold blue-text">{{$user->present_code}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col l8 s12">
                        <!-- tabs content -->
                        <div id="general">
                            <div class="card-panel">
                                <h6 class="mb-4">نمایش و بروز رسانی پروفایل</h6>
                                <div class="display-flex">
                                    <div class="media">
                                        <img src="{{\App\Helper\Helper::getAvatar($user->avatar)}}" id="media-img" class="border-radius-4" alt="profile image" height="64" width="64">
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
                                <form class="form-valid send-ajax" method="post" action="{{url('/management/profile-update')}}" >
                                    <div class="row">
                                        <input type="hidden" id="avatar" name="avatar">
                                        <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($user->id)}}">
                                        {{csrf_field()}}
                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>نام کاربری</label>
                                                <input type="text"  disabled value="{{$user->username}}" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>نام</label>
                                                <input name="fname" type="text" value="{{$user->fname}}" required data-msg-required="اسم کوچک را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>فامیلی</label>
                                                <input name="lname" type="text" value="{{$user->lname}}" required data-msg-required="نام خانوادگی را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <input name="mobile" type="number" value="{{$user->mobile}}" disabled maxlength="11" minlength="11" required data-msg-required="موبایل را وارد کنید" autocomplete="off" >
                                                <label class="active always">موبایل</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label class="active always">تاریخ تولد</label>
                                                <input name="birthday" type="text" value="{{\App\Helper\Helper::v($user->birthday,'Y/m/d')}}" id="pdate1" readonly autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <select name="status"  disabled>
                                                    @foreach(\App\Models\User::status() as $key=>$val)
                                                        <option value="{{$key}}" {{$user->status==$key?'selected':''}}>{{$val}}</option>
                                                    @endforeach
                                                </select>
                                                <label>وضعیت</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field display-none">
                                                <select class="browser-default select2" disabled name="permission_id">
                                                    <option>یک دسترسی انتخاب کنید</option>
                                                    @foreach(\App\Models\PermissionList::all() as $item)
                                                        <option value="{{$item->id}}" {{$user->permission_id==$item->id?'selected':''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                                <label>مجوز دسترسی</label>
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <select name="state" class="browser-default select2" onchange="helper().setCitySelectBox(this.value,'city')">
                                                    @foreach(\App\Models\Locate::get_state() as $item)
                                                        <option value="{{$item->id}}" {{$user->state==$item->id?'selected':''}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                <label>انتخاب استان</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <select name="city" id="city" class="browser-default select2" >
                                                    <option value="">یک شهر انتخاب کنید</option>
                                                    @foreach(\App\Models\Locate::get_city($user->state)['list'] as $item)
                                                        <option value="{{$item->id}}" {{$user->city==$item->id?'selected':''}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                                <label>انتخاب شهر</label>
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <input type="text" value="{{$user->zip_code}}" name="zip_code" autocomplete="off">
                                                <label>کد پستی</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>ایمیل</label>
                                                <input type="email" name="email" value="{{$user->email}}" autocomplete="off" >
                                            </div>
                                        </div>
                                        {{--<div class="col s12">
                                            <div class="card card-alert orange lighten-5">
                                                <div class="card-content orange-text">
                                                    <p>اگر فیلد ایمیل را پر کنید ، پیامی به صندوق شما ارسال میشود تا با کلیک بر روی آن ایمیل شما مورد تایید ما قرار گیرد.  <a href="javascript: void(0);" class="close">متوجه شدم</a> </p>
                                                </div>
                                                <button type="button" class="close orange-text" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        </div>--}}
                                        <div class="col m12 s12">
                                            <div class="input-field">
                                                <textarea name="address" class="materialize-textarea" >{{$user->address}}</textarea>
                                                <label>آدرس</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="row mb-5">
                                                <div class="col s12">
                                                    <label >نقش کاربری را تعیین کنید</label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="role" disabled value="administrator" type="radio" {{$user->role=='administrator'?'checked':''}}>
                                                        <span>مدیر ارشد</span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="role" disabled value="operator" type="radio" {{$user->role=='operator'?'checked':''}}>
                                                        <span>اپراتور</span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="role" disabled value="personal" type="radio" {{$user->role=='personal'?'checked':''}}>
                                                        <span>کادر اداری(پرسنل)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="{{url('/management/user-list')}}">برگشت به لیست </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره تغییرات
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="change-password">
                            <div class="card-panel">
                                <h6 class="mb-5">تغییر رمز عبور حساب کاربری</h6>
                                <form id="form2" class="form-valid1 send-ajax" method="post" action="{{url('/management/change-pass')}}" data-after-done="after_done2">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($user->id)}}">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input name="password" required type="password" autocomplete="off">
                                                <label>رمز عبور جدید</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input name="password_confirmation" required type="password" autocomplete="off">
                                                <label>تکرار رمز عبور جدید</label>
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <button type="submit" class="btn indigo waves-effect waves-light mr-1 iransans">ذخیره تغییرات</button>
                                            <button type="reset" class="btn btn-light-pink waves-effect waves-light iransans">لغو</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="address">
                            <div class="card-panel">
                                <h6 class="mb-5">مدیریت آدرسهای بیشتر</h6>
                                <div class="row">
                                    <form id="form3" class="form-valid2 send-ajax" method="post" action="{{url('/management/address-insert')}}" data-after-done="after_done3">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($user->id)}}">
                                        <div class="padding-1 grey lighten-3 mb-5 mr-3 ml-3" style="border:dashed 2px #adadad">
                                            <div class="col s12 mb-3"><p class="black-text padding-1 grey black-text lighten-2 center-align">افزودن آدرس جدید</p></div>
                                            <div class="col m4 s12">
                                                <div class="input-field">
                                                    <select name="state" class="browser-default select2" onchange="helper().setCitySelectBox(this.value,'city2')">
                                                        <option value="0" >انتخاب استان</option>
                                                        @foreach(\App\Models\Locate::get_state() as $item)
                                                            <option value="{{$item->id}}" >{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label>انتخاب استان</label>
                                                </div>
                                            </div>
                                            <div class="col m4 s12">
                                                <div class="input-field">
                                                    <select name="city" id="city2" required class="browser-default " >
                                                        <option value="">یک شهر انتخاب کنید</option>
                                                    </select>
                                                    <label class="active">انتخاب شهر</label>
                                                </div>
                                            </div>
                                            <div class="col m4 s12">
                                                <div class="input-field">
                                                    <input type="text" required name="zip_code" autocomplete="off">
                                                    <label class="active always">کد پستی</label>
                                                </div>
                                            </div>
                                            <div class="col m12 s12">
                                                <div class="input-field">
                                                    <textarea name="address" required class="browser-default " rows="7" style="width: 100%"  ></textarea>
                                                    <label class="active always">آدرس</label>
                                                </div>
                                            </div>
                                            <div class="col s12">
                                                <button type="submit" class="btn indigo waves-effect waves-light iransans">افزودن به لیست آدرسها<i class="material-icons left">arrow_downward</i></button>
                                            </div>
                                            <div class="break"></div>
                                        </div>
                                    </form>

                                    <div class="col s12 mb-5" >
                                        <table class="subscription-table responsive-table highlight mb-2">
                                            <caption class="padding-1 green lighten-2 white-text" >آدرس پیش فرض</caption>
                                            <tbody>
                                                <tr class="green lighten-5">
                                                    <td>1</td>
                                                    <td>{{$user->state_fa}}</td>
                                                    <td>{{$user->city_fa}}</td>
                                                    <td><span class="font-small">{{$user->address}}</span></td>
                                                    <td>{{$user->zip_code}}</td>
                                                    <td class="center-align"><a href="javascript:void(0)" onclick="swal({text:'آدرس پیش فرض را نمیتوان حذف کرد',icon:'warning'})"><i class="material-icons grey-text">clear</i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <i class="material-icons cursor_pointer" title="تازه سازی ادرسها" onclick="getAddressList()">autorenew</i>
                                        <table id="addressListTable" class="subscription-table responsive-table highlight blue lighten-5 black-text">
                                            <caption class="padding-1 blue lighten-2 white-text" >آدرس های بیشتر</caption>
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>استان</th>
                                                <th>شهر</th>
                                                <th>آدرس</th>
                                                <th>کد پستی</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tblListAddress">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="social-link">
                            <div class="card-panel">
                                <form class="form-valid3 send-ajax" method="post" action="{{url('/management/profile-meta-save')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($user->id)}}">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input type="text" name="telegram"  placeholder="پیوند را اضافه کنید" value="{{$user->meta('telegram')}}" dir="ltr" autocomplete="off">
                                                <label>تلگرام</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input type="text" name="instagram"  placeholder="پیوند را اضافه کنید" value="{{$user->meta('instagram')}}" dir="ltr" autocomplete="off">
                                                <label>اینستاگرام</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input type="text" name="watsapp"  placeholder="پیوند را اضافه کنید" value="{{$user->meta('watsapp')}}" dir="ltr" autocomplete="off">
                                                <label>واتس اپ</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input type="text" name="twitter"  placeholder="پیوند را اضافه کنید" value="{{$user->meta('twitter')}}" dir="ltr" autocomplete="off">
                                                <label>توییتر</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <input type="text" name="website"  placeholder="پیوند را اضافه کنید" value="{{$user->meta('website')}}" dir="ltr" autocomplete="off">
                                                <label>وبسایت</label>
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <button type="submit" class="btn indigo waves-effect waves-light iransans">ذخیره تغییرات</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="notifications">
                            <div class="card-panel">
                                <form class="form-valid3 send-ajax" method="post" action="{{url('/management/profile-notify-save')}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($user->id)}}">
                                    <div class="row">
                                        <h6 class="col s12 mb-2">فعالیت</h6>
                                        <div class="col s12 mb-1">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" name="notify_comment_my_post" value="yes" {{$user->meta('notify_comment_my_post')=='yes'?'checked':''}}>
                                                    <span class="lever"></span>
                                                </label>
                                                <span class="switch-label w-100">وقتی کسی درباره مقاله من اظهار نظر کرد به من خبر بده</span>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" name="notify_replay_my_comment" value="yes" {{$user->meta('notify_replay_my_comment')=='yes'?'checked':''}}>
                                                    <span class="lever"></span>
                                                </label>
                                                <span class="switch-label w-100">
                                                وقتی کسی دیدگاه من را جواب بدهد به من خبر بده
                                            </span>
                                            </div>
                                        </div>
                                        <h6 class="col s12 mb-2 mt-2">برنامه ها</h6>
                                        <div class="col s12 mb-1">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" name="notify_new_post" value="yes" {{$user->meta('notify_new_post')=='yes'?'checked':''}}>
                                                    <span class="lever"></span>
                                                </label>
                                                <span class="switch-label w-100">انتشار اخبار و اطلاعیه های جدید</span>
                                            </div>
                                        </div>
                                        <div class="col s12 mb-1">
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox" name="notify_new_user" value="yes" {{$user->meta('notify_new_user')=='yes'?'checked':''}}>
                                                    <span class="lever"></span>
                                                </label>
                                                <span class="switch-label w-100">اطلاع رسانی در صورت افزودن کاربر تازه</span>
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action mt-2">
                                            <button type="submit" class="btn indigo waves-light waves-effect iransans">ذخیره تغییرات</button>
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
        function after_done2() {
            $("#form3")[0].reset()
        }
        function after_done3() {
            getAddressList();
            helper().scrollTo('addressListTable',70);
            $("#form3")[0].reset()
        }
    </script>
    <script>
        function getAddressList() {
            helper().get($baseurl+'/management/address-list/{{\App\Helper\Helper::hash($user->id)}}')
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
        setTimeout(function () {
            getAddressList();
        },2000)
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

