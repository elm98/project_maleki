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

    <link rel = "stylesheet" href = "{{_slash()}}plugin/leaflet/leaflet.css"/>
    {{--<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />--}}
    <link rel = "stylesheet" href = "{{_slash()}}plugin/leaflet/leaflet-search.css"/>
    <link href="{{_slash()}}plugin/leaflet/map/leaflet.fullscreen.css" rel='stylesheet' />
    <link rel="stylesheet" href="{{_slash()}}plugin/leaflet/map/leaflet-routing-machine.css" />

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
                                <h6 class="mb-5">آدرس و تلفن</h6>
                                <div class="row">
                                    <div class="col m12 s12">
                                        <form class="send-ajax form-valid2" method="post" action="{{url('/management/setting-update')}}">
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" value="">
                                            <div class="card">
                                                <div class="card-header mb-3">
                                                    <div class="title"> <span class="black-text">راه های ارتباطی را تنظیم کنید</span></div>
                                                    <div class="tools">
                                                        <a href="{{url('/management')}}" class="btn white black-text">
                                                            <i class="material-icons left">arrow_forward</i> برگشت به داشبورد
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="row">
                                                        <div class="col m12 s12">
                                                            <div class="input-field pb-3">
                                                                <input type="text" required name="optionKey_address" value="{{Option::find_key($option,'address')}}" placeholder="درج کامل آدرس " autocomplete="off">
                                                                <label class="active always"><i class="material-icons left" style="font-size:18px">local_shipping</i>آدرس</label>
                                                            </div>
                                                        </div>

                                                        <div class="col m6 s12">
                                                            <div class="input-field pb-3">
                                                                <input type="text" name="optionKey_lat" id="lat" class="fill" value="{{Option::find_key($option,'lat')}}" placeholder="طول جغرافیایی" autocomplete="off">
                                                                <label class="active always"><i class="material-icons left" style="font-size:18px">map</i>طول جغرافیایی</label>
                                                            </div>
                                                        </div>
                                                        <div class="col m6 s12">
                                                            <div class="input-field pb-3">
                                                                <input type="text" name="optionKey_lng" id="lng" class="fill" value="{{Option::find_key($option,'lng')}}" placeholder="عرض جغرافیایی" autocomplete="off">
                                                                <label class="active always"><i class="material-icons left" style="font-size:18px">map</i>عرض جغرافیایی</label>
                                                            </div>
                                                        </div>
                                                        <div class="col m6 s12">
                                                            <div class="input-field pb-3">
                                                                <input type="text" name="optionKey_zip_code" class="fill"  value="{{Option::find_key($option,'zip_code')}}" placeholder="درج کد پستی" autocomplete="off">
                                                                <label class="active always"><i class="material-icons left" style="font-size:18px">flag</i>کد پستی</label>
                                                            </div>
                                                        </div>

                                                        <div class="col s6 mb-2">
                                                            <div class="input-field">
                                                                <label>تلفن تماس</label>
                                                                <input type="text" name="optionKey_tel" class="fill" value="{{Option::find_key($option,'tel')}}" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="col s6">
                                                            <div class="input-field">
                                                                <label>شماره همراه مدیریت</label>
                                                                <input type="text" name="optionKey_mobile" class="fill" value="{{Option::find_key($option,'mobile')}}" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col s6">
                                                            <div class="input-field">
                                                                <label>ایمیل مدیریت</label>
                                                                <input type="email" dir="ltr" name="optionKey_email" class="fill" value="{{Option::find_key($option,'email')}}" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="col s6 pt-2 mb-2">
                                                            <button type="submit" class="btn">ذخیره</button>
                                                        </div>
                                                        <div class="col m12">
                                                            <div id="search_map"></div>
                                                            <div id="map" style="width: 100%;height: 400px" ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
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


    <script src = "{{_slash()}}plugin/leaflet/leaflet.js"></script>
    {{--<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>--}}
    <script src="{{_slash()}}plugin/leaflet/leaflet-search.js"></script>
    <script src="{{_slash()}}plugin/leaflet/Leaflet.fullscreen.min.js"></script>
    <script src="{{_slash()}}plugin/leaflet/leaflet-routing-machine.js"></script>
    <script>
        var old_lat='{{\App\Models\Option::find_key($option,'lat')}}';
        var old_lng='{{\App\Models\Option::find_key($option,'lng')}}';
        var latitud = old_lat!==''?old_lat:35.688428639754235;
        var langtitud = old_lng!==''?old_lng:51.38988018035889;
        // Creating map options
        var mapOptions = {
            center: [latitud, langtitud],
            zoom: 12,
            fullscreenControl: true,
        };
        var map = new L.map('map', mapOptions); // Creating a map object
        var layer = new L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }); // Creating a Layer object
        map.addLayer(layer); // Adding layer to the map
        map.addControl( new L.Control.Search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: L.circleMarker([0,0],{radius:30}),
            autoCollapse: false,
            autoType: false,
            minLength: 2,
            textPlaceholder:"جستجو مکان مورد نظر روی نقشه",
            /*   moveToLocation:function (latlng, title, map) {
                   console.log(latlng.lat);
               },*/
            container:"search_map",
            collapsed:false,
            textErr:"مکان مورد نظر یافت نشد.",
            autoResize:false,
            firstTipSubmit:true,
            zoom:18,
            /*autoCollapseTime:4000000000*/
        }) );
        marker_add=0;
        map.on('click', function(e) {
            console.log(e);
            let $lat = e.latlng.lat;
            let $lng = e.latlng.lng;
            mapAction($lat,$lng);
        });
        function mapAction($lat,$lng){
            if(marker_add==0){
                marker1=new L.Marker([$lat, $lng], {
                    draggable: true,
                    icon: new L.DivIcon({
                        iconAnchor: [-7, 55],
                        elevation: 0,
                        title: "مبدا",
                        className: 'my-div-icon',
                        html: '<div><img class="my-div-image" src="{{$dotSlashes}}plugin/leaflet/images/marker-icon.png" width="45px"/>'+
                            '<span class="my-div-span busy"></span></div>',
                    })
                });
                marker1.addTo(map);
                marker1.on('dragend', function() {
                    var coord = marker1.getLatLng();
                    var lat = coord.lat;
                    var lng = coord.lng;
                    $("#lat").val(lat);
                    $("#lng").val( lng);
                });
                marker_add=1;
            }
            $("#lat").val($lat);
            $("#lng").val($lng);
            var newLatLng = new L.LatLng($lat,$lng);
            marker1.setLatLng(newLatLng);
        }
        mapAction(latitud,langtitud);
    </script>


@stop

