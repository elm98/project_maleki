@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/vendors/data-tables/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{$dotSlashes}}back/app-assets/css/pages/data-tables.min.css">
@stop

@section('content')
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card card-round">
                <div class="card-header rounded  gradient-45deg-light-blue-cyan gradient-shadow">
                    <div class="title"> @if(auth()->user()->role=='administrator')<a href="{{url('/management/permission-source')}}"><i class="material-icons left">lock_open</i></a>@endif  نمایش لیست مجوزهای دسترسی</div>
                    <div class="tools">
                        <a href="{{url('/management/permission-add')}}" class="btn white black-text">
                            <i class="material-icons right">control_point</i> افزودن
                        </a>
                    </div>
                </div>
                <div class="card-content">
                    {{--<form id="dt_form">
                        <div class="row mb-2">
                            <div class="col m2 s12 input-field">
                                <input type="text" class="validate date_p">
                                <label class="">زمان ایجاد از تاریخ</label>
                            </div>
                            <div class="col m2 s12 input-field">
                                <input type="text" class="validate date_p">
                                <label>تا تاریخ</label>
                            </div>
                            <div class="col m2 s12 input-field">
                                <select>
                                    <option value="0">انتخاب کنید</option>
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیر فعال</option>
                                </select>
                                <label>نقش کاربری</label>
                            </div>
                            <div class="col m2 s12 input-field">
                                <select>
                                    <option value="0">انتخاب کنید</option>
                                    <option value="active">فعال</option>
                                    <option value="inactive">غیر فعال</option>
                                </select>
                                <label>وضعیت</label>
                            </div>
                            <div class="col m2 s12 input-field ">
                                <select class="select2 browser-default" >
                                    <option value=""></option>
                                    <option value="square">مربع</option>
                                    <option value="rectangle">مستطیل</option>
                                    <option value="rombo">رومبو</option>
                                    <option value="romboid">رومبوید</option>
                                    <option value="trapeze">ذوزنقه</option>
                                    <option value="traible">مثلث</option>
                                    <option value="polygon">چند ضلعی</option>
                                </select>
                                <label>سلکت 2</label>
                            </div>
                            <div class="--BUTTON-- col m2 s12 left-align">
                                <button type="submit" class="btn blue btn-small waves-effect waves-light mb-2"><i class="material-icons left">search</i> اعمال فیلتر</button>
                                <button type="button" id="dt_reset" class="btn btn-small waves-effect waves-light mb-2"><i class="material-icons left">close</i> حذف فیلترها </button>
                            </div>
                        </div>
                    </form>--}}
                    <!--dataTable-->
                    <div class="row">
                        <div class="col s12 section-data-tables scrollspy">
                            <table id="my-dt" class="display tbl-border">
                                <thead>
                                <tr>
                                    <th style="padding-right: 11px"><label><input type="checkbox" class="check-all"><span></span></label></th>
                                    <th>شناسه</th>
                                    <th>نام مجوز</th>
                                    <th>تاریخ ایجاد</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                            </table>
                            <div class="action-button mt-2">
                                <button class="btn rows-delete--" onclick="helper().rows_delete('permission-delete')" data-action="user-delete">حذف گزینه های انتخاب شده<i class="material-icons left">delete</i></button>
                            </div>
                        </div>
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
    <!--دیتا تیبل-->
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{$dotSlashes}}back/app-assets/vendors/data-tables/js/dataTables.select.min.js"></script>
    <script>
        $(function () {
            var dt=$("#my-dt").DataTable({
                responsive:!0,
                lengthMenu:[5, 10, 25, 50, 100, 200, 500, 1000, 2000],
                pageLength:25,
                searching: true,
                processing: true,
                serverSide: true,
                searchDelay: 500,
                //scrollX:!0,
                language: {
                    sProcessing: "درحال پردازش ....",
                    emptyTable: "هیچ اطلاعاتی مطابقت نداشت",
                    info: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
                    infoEmpty: "هیچ رکوردی یافت نشد",
                    infoFiltered: "(فیلتر 1 از _MAX_ رکورد)",
                    lengthMenu: "نمایش سطر در هر صفحه  _MENU_ ",
                    search: "جستجوی گسترده: ",
                    zeroRecords: "هیچ نتیجه ای یافت نشد",
                },
                ajax: {
                    url: '{{url("/management/permission-list-dt")}}',
                    type: "POST",
                    dataType: "json",
                    delay:5000,
                    data:
                        function(d) {
                            $('.dtparam').each(function(){
                                var name= $(this).attr('name');
                                d[name] = $(this).val();
                            });
                            d._token='{{csrf_token()}}';
                        }
                },
                columns: [
                    { data: 'checked', name: 'checkboxes',orderable: false, searchable: false },
                    { data: 'id', name: 'id',"visible": false},
                    { data: 'title', name: 'title' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                order: [[1, 'desc']]
            });
            $('#dt_form').on('submit', function(e) {
                e.preventDefault();
                dt.draw();
                helper().scrollTo('my-dt',70);
            });
            $('#dt_reset').on('click', function(e) {
                $("#dt_form").find("input[type]").val('');
                dt.draw();
                helper().scrollTo('my-dt',70);
            });
        });
        setTimeout(function () {
            helper().scrollTo('my-dt',70);
        },2000)
    </script>
@stop

