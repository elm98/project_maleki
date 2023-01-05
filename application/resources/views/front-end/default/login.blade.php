@extends('front-end.default._layout_master2')

@section('headerScript')
    <style>

        .page-content{
            margin-top: 30px !important;
        }
        .input-element{
            border:solid 1px #ddd;
            width: 100%;
            height: 40px;
            padding: 7px;
            border-radius: 5px;
            background: #eee;
        }
        .sidebar-card{

        }
        h2{
            line-height: 1.7;
        }
        .pricing tr td{
            padding: 5px;
            text-align: left;
        }
    </style>
@stop

@section('content')
    <?php $currency = currency()?>
    <?php $auth = \Illuminate\Support\Facades\Auth::check();?>
    <?php
        seoMeta([
            'pageTitle'=>'صفحه ورود',
        ]);
    ?>

    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-form shadow-around mt-3">
                <div class="text-center mb-5">
                    <a href="{{url('/')}}">
                        <img src="{{url('uploads/setting/'.\App\Models\Option::getval('logo'))}}" onerror="this.src='{{_noImage('avatar.png')}}'" style="max-height: 90px">
                    </a>
                </div>

                <?php $callback = isset($_GET['callback'])?$_GET['callback']:'' ?>
                <form method="post" action="{{url('/login-done')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="callback" value="{{$callback}}">
                    <div class="form-element-row">
                        <label for="phone-number" class="label-element"> نام کاربری (شماره موبایل)</label>
                        <div class="form-element-with-icon">
                            <input type="text" name="username" class="input-element" id="phone-number" autocomplete="off">
                            <i class="fad fa-mobile-alt"></i>
                        </div>
                    </div>
                    <div class="form-element-row">
                        <label for="password" class="label-element">
                            <span class="d-flex justify-content-between">
                                <span>کلمه عبور</span>
                            </span>
                        </label>
                        <div class="form-element-with-icon">
                            <input type="password" name="password" class="input-element" id="password">
                            <i class="fad fa-key-skeleton"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="container-checkbox font-medium">
                                مرا به خاطر داشته باش
                                <input type="checkbox" checked="checked" name="remember" value="1">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                    </div>
                    <div class="pt-3 pb-3">
                        @foreach($errors->all() as $error)
                            <b class="text-danger">{{$error}}</b>
                        @endforeach
                        @if(!empty(session('error')))
                            <b class="text-danger">{{session('error')}}</b>
                        @endif
                    </div>
                    <div class="form-element-row ">
                        <button type="submit" class="btn-element btn-info-element" style="width: 100%;background-color: #ef4056;">
                            ورود به سامانه
                        </button>
                    </div>
                </form>

                <div class="auth-form-footer">
                    <span>کاربر جدید هستید ؟</span>
                    <a href="{{url('/register?callback='.$callback)}}" class=" font-small text-danger">ثبت نام کنید </a>
                    <span>همچنین میتوانید</span>
                    <a href="{{url('/login-mobile?callback='.$callback)}}" class=" font-small text-danger"> با موبایل وارد شوید </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal')

@stop

@section('footerScript')
@stop
