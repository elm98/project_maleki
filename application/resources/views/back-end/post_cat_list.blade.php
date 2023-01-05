@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <link href="{{$dotSlashes}}plugin/menu-builder/jquery.domenu-0.100.77.css" rel="stylesheet">
    <style>
        .modal-img{
            border:dashed 2px #8cf5d8;
            padding: 3px;
            background: #fff;
        }
    </style>
@stop

@section('content')
    <div class="card">
        <div class="card-header gradient-45deg-light-blue-cyan gradient-shadow">
            <div class="title">دسته بندی درختی</div>
            <div class="tools"><a href="{{url('/management/post-list')}}" class="btn white black-text">
                    <i class="material-icons left">arrow_forward</i><span class="hide-on-small-and-down">  برگشت به لیست </span>
                </a>
            </div>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col s12" style="direction: ltr;text-align: left">
                    <div class="dd" id="domenu-1">
                        <ol class="dd-list"></ol>
                        <button type="button" class="dd-new-item">+</button>
                        <li class="dd-item-blueprint">
                            <button  class="expand" data-action="expand" type="button" style="display: none;margin-top:30px">+</button>
                            <button  class="collapse" data-action="collapse" type="button" style="display: none;margin-top:30px">–</button>
                            <div class="dd-handle dd3-handle"></div>
                            <div class="dd3-content">
                                <span class="item-name">[item_name]</span>
                                <div class="dd-button-container">
                                    <button type="button" class="item-edited"><i class="material-icons">edit</i></button>
                                    <button type="button" class="item-add"><i class="material-icons">library_add</i></button>
                                    <button type="button" class="item-remove" data-confirm-class--="item-remove-confirm" >
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                                <div class="dd-edit-box" style="display: none;">
                                    <input type="text" class="browser-default" name="title" autocomplete="off" placeholder="Item"
                                           data-placeholder="عنوان مورد نظر خود را وارد کنید؟"
                                           data-default-value="رسته جدید شماره . {?numeric.increment}">
                                    <i class="end-edit">ذخیره موقت</i>
                                </div>
                            </div>
                        </li>
                    </div>
                </div>
                <div class="col s12">
                    <div id="domenu-1-output" class="output-preview-container">
                        <form class="send-ajax" method="post" action="{{url('/management/cat-item-update')}}" data-after-done="after_done">
                            {{csrf_field()}}
                            <textarea  name="json" class="browser-default jsonOutput display-none"></textarea>
                            <input type="hidden" name="type" value="{{$type}}">
                            <input type="hidden" name="group_id" value="{{$group_id}}">
                            <button type="submit" class="btn mt-2">ذخیره و ثبت نهایی</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('modal')
    <!-- Modal 1 -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <form id="form1" class="send-ajax form-valid" method="post" data-after-done="after_done2">
                <input type="hidden" name="id" value="">
                {{csrf_field()}}
                <div class="row">
                    <div class="col m12 s12 center-align">
                        <img id="image_img1" src="{{\App\Helper\Helper::getAvatar('')}}" class="modal-img rounded cursor_pointer" width="70px" onclick="fm_modal_open(this)" data-target-id="img1" data-after-done="fm_after_done">
                        <input id="hidden_img1" type="hidden" name="img" value="">
                        <div id="div_img1" dir="ltr" class="font-small"></div>
                        <div class="divider mt-1"></div>
                    </div>
                    <div class="col m12 s12">
                        <div class="row pt-3">
                            <div class="col m6 s12">
                                <div class="input-field">
                                    <p class="font-medium">عنوان ایتم</p>
                                    <input name="title" type="text" class="fill" required autocomplete="off">

                                </div>
                            </div>
                            <div class="col m6 s12"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="divider"></div>
            <a href="javascript:void(0)" class="modal-close waves-effect waves-green btn-flat">انصراف</a>
            <button type="button" onclick="$('#form1').submit()" class="btn cyan">بروز رسانی</button>
        </div>
    </div>
@stop

@section('float_button')
@stop

@section('footerScript')
    <script>
        var $action_detail='post-cat-detail';
        var $action_detail_edit='post-cat-detail-update';
        var $action_delete='post-cat-item-delete';
    </script>
    <script src="{{$dotSlashes}}plugin/menu-builder/jquery.domenu-0.100.77.js"></script>
    <script>
        $(document).ready(function() {
            var $domenu            = $('#domenu-1'),
                domenu             = $('#domenu-1').domenu(),
                $outputContainer   = $('#domenu-1-output'),
                $jsonOutput        = $outputContainer.find('.jsonOutput'),
                $keepChanges       = $('.keepChanges'),
                $clearLocalStorage = $('.clearLocalStorage'); //کلاس چک باکس برای نگه داشتن تغییرات بعد از رفرش صفحه
            $domenu.domenu({
                advanceEditFunction:'advanceEdit',
                data: '{!! $data !!}',
                maxDepth: 1
            }).parseJson()
                .on(['onItemCollapsed', 'onItemExpanded', 'onItemAdded', 'onSaveEditBoxInput', 'onItemDrop', 'onItemDrag', 'onItemRemoved', 'onItemEndEdit'], function(a, b, c) {
                    $jsonOutput.val(domenu.toJson());
                    if($keepChanges.is(':checked')) window.localStorage.setItem('domenu-1Json', domenu.toJson());
                })
                /* ثبت رویداد دلخواه همراه با ارگومانها */
                .onItemMaxDepth(function() {
                    alert('شما از حد اکثر عمق مجاز تجاوز کردید');
                    //console.log('event: onItemCollapsed', 'arguments:', arguments, 'context:', this);
                });
            $jsonOutput.val(domenu.toJson());// Init textarea
            //domenu.collapseAll();
            //$("#loading").hide();
            $("#form1").attr('action',$baseurl+'/management/'+$action_detail_edit);
        });
    </script>

    <script>
        function after_done() {
            setTimeout(function () {
                window.location.reload();
            },1500)
        }
        function after_done2() {
            setTimeout(function () {
                $("#modal1").modal('close')
            },1000)
        }
        /*ویرایش*/
        function advanceEdit($id) {
            if($id === 0){
                M.toast({
                    html:' <i class="material-icons">warning</i>  این آیتم هنوز ثبت نهایی نشده ',
                    classes:'amber black-text',
                });
                return 0;
            }else{
                helper().loadingOn('form1');
                helper().post($baseurl+'/management/'+$action_detail,{id:$id}).done(function (r) {
                    if(r.result){
                        let $avatar='{{\App\Helper\Helper::getAvatar("")}}',
                            $img=$("#image_img1"),
                            $div_img=$("#div_img1"),
                            $empty = ['',null].includes(r.data.img)?true:false;
                        !$empty?$img.attr('src',$baseurl+'/uploads/media/'+r.data.img):$img.attr('src',$avatar);
                        $empty?$div_img.html('هیچ تصویری انتخاب نشده'):$div_img.html(r.data.img);
                        $("#hidden_img1").val(r.data.img);
                        $("#form1 input[name='id']").val(r.data.id);
                        $("#form1 input[name='title']").val(r.data.title);
                        $("#form1 input[name='value']").val(r.data.value);
                        $("#modal1").modal('open')
                    }else{
                        swal({text:r.msg,icon:'warning'});
                    }
                    helper().loadingOff('form1');
                }).fail(function (e) {
                    helper().loadingOff('form1');
                });
            }
        }
        /*حذف*/
        function removeFunction($id,blueprint) {
            if($id===0){
                blueprint.remove();
            }else{
                helper().post($baseurl+'/management/'+$action_delete,{id:$id}).done(function (r) {
                    if(r.result){
                        blueprint.remove();
                        swal({
                            text:r.msg,
                            icon:'success'
                        })
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
    <script src="{{asset('plugin/file_manager/custom.js')}}"></script>
    <script>var $fm_modal_src = '../plugin/file_manager/index.html'</script>
    <link rel="stylesheet" href="{{asset('plugin/file_manager/custom.css')}}">
    <script>
        function fm_after_done(param) {
            let $path=$baseurl+'/uploads/media/'+param.file;
            $("#image_"+param.id).attr('src',$path);
            $("#hidden_"+param.id).val(param.file);
            $("#div_"+param.id).html('{{$dotSlashes}}uploads/media/'+param.file);
        }
    </script>

@stop

