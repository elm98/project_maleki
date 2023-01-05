@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css/pages/data-tables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <style>
        .select2-selection__choice{
            font-size: 12px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col m12 s12">
            <form class="card send-ajax form-valid" method="post" id="form" action="./post-excel-import" data-with-file="yes" enctype="multipart/form-data"
             data-after-done="after_done">
                {{csrf_field()}}
                <div class="card-content">
                    <div class="row">
                        <div class="col m12 s12">
                            <p class="black-text bold">بارگذاری فایل اکسل <span>(<a href="{{url('/back/custom/other/sample-import.xlsx')}}">فایل نمونه</a>)</span></p>
                            <hr/>
                        </div>

                        <div class="col m4 s12">
                            <p class="font-medium"> فایل اکسل را انتخاب کنید</p>
                            <input type="file" name="file" required style="width: 100%;" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" >
                        </div>

                        <div class="col m6 s12">
                            <label class="col m12 s12">.</label>
                            <button type="submit" class="btn cyan">شروع بارگذاری محصولات </button>
                            <button type="reset" id="reset" style="visibility: hidden"></button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col m12 s12">
                            <table class="table table-bordered  table-striped table-responsive">
                                <tr>
                                    <td>محصولات ثبت شده</td>
                                    <td>محصولات ویرایش شده</td>
                                    <td>انبار درج شده</td>
                                    <td>انبار ویرایش شده</td>
                                </tr>
                                <tr>
                                    <td id="inserted_product">-</td>
                                    <td id="updated_product">-</td>
                                    <td id="inserted_stock">-</td>
                                    <td id="updated_stock">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>




    </div>
@stop

@section('modal')
@stop

@section('float_button')

@stop

@section('footerScript')
    <!--دیتا تیبل-->
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        function after_done(param) {
            $("#inserted_product").html(param.inserted_product);
         $("#updated_product").html(param.updated_product);
         $("#inserted_stock").html(param.inserted_stock);
         $("#updated_stock").html(param.updated_stock);


     }
 </script>



@stop

