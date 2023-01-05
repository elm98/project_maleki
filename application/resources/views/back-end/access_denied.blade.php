@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css-rtl/pages/page-knowledge.min.css">
@stop

@section('content')
    <div class="section" id="knowledge">
        <div class="row knowledge-content">
            <div class="col s12">
                <div id="search-wrapper" class="card z-depth-0 search-image center-align p-35">
                    <div class="card-content">
                        <h5 class="center-align mb-3">بنظر میرسد دسترسی به این صفحه برای شما محدود شده</h5>
                        {{--<input placeholder=" شروع به تایپ کردن جستجوی خود کنید ..." id="first_name" class="search-box validate white search-circle search-shadow iransans">--}}
                        <button class="btn" onclick="window.location.href='{{url('/management/dashboard')}}'">بازگشت به داشبورد<i class="material-icons left">dashboard</i></button>
                        <button class="btn" onclick="window.history.back()">بازگشت به صفحه قبل<i class="material-icons right">arrow_back</i></button>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card card-hover z-depth-0 card-border-gray">
                    <div class="card-content center-align">
                        <h5><b>پشتیبانی</b></h5>
                        <i class="material-icons md-48 red-text">favorite_border</i>
                        <p class="mb-2 black-text"><a href="tel:{{\App\Models\Option::getval('tel')}}">با پشتیبانی تماس بگیرید<br>{{\App\Models\Option::getval('tel')}}</a></p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card card-hover z-depth-0 card-border-gray">
                    <div class="card-content center-align">
                        <h5><b>مجوز</b></h5>
                        <i class="material-icons md-48 amber-text">filter_none</i>
                        <p class="mb-2 black-text">توافقنامه صدور مجوز <br>مجوزی محدود برای شما صادر شده</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card card-hover z-depth-0 card-border-gray">
                    <div class="card-content center-align">
                        <h5><b>حساب شما</b></h5>
                        <i class="material-icons md-48 blue-text">aspect_ratio</i>
                        <p class="mb-2 black-text"> <a class="black-text" href="javascript:void(0)" onclick="helper().logout()">می خواهید از حساب خود خارج شوید<br> اینجا کلیک کنید</a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('modal')
@stop

@section('float_button')
    {{--<div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow"><i class="material-icons">add</i></a>
        <ul>
            <li><a href="css-helpers.html" class="btn-floating blue"><i class="material-icons">help_outline</i></a></li>
            <li><a href="cards-extended.html" class="btn-floating green"><i class="material-icons">widgets</i></a></li>
            <li><a href="app-calendar.html" class="btn-floating amber"><i class="material-icons">today</i></a></li>
            <li><a href="app-email.html" class="btn-floating red"><i class="material-icons">mail_outline</i></a></li>
        </ul>
    </div>--}}
@stop

@section('footerScript')

@stop

