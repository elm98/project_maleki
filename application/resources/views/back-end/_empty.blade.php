@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')

@stop

@section('content')
    <div class="card card-round">
        <div class="card-header gradient-45deg-light-blue-cyan gradient-shadow rounded">
            <div class="title">عنوان در اینجا</div>
            <div class="tools">
                <a href="{{url('/management')}}" class="btn white black-text">
                    <i class="material-icons left">arrow_forward</i> برگشت به لیست
                </a>
            </div>
        </div>
        <div class="card-content">
            .
            .
            .
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

