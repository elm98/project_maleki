@extends('back-end.layout.master')
<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
@section('headerScript')
    <style>
        #new_gallery_image{
            border: dashed 2px;
            text-align: center;
            cursor: pointer;
            height: 135px;
        }
        #new_gallery_image i{
            font-size: 30px;
            margin-top: 50px;
        }
        .gallery_image_cover{
            background: #eee url('{{$dotSlashes}}/back/custom/img/no-image.png') no-repeat center center;
            cursor: pointer;
            position: relative;
            text-align: center;
            padding: 5px;
            border: dashed 1px;
            border-radius: 5px;
        }
        .gallery_image_cover img{
            max-width: 100%;
            min-height: 100px;
            max-height: 100px;
        }
        .gwi i{
            position: absolute;
            left: 7px;
            top: -4px;
            padding: 0;
            border-radius: 11px;
            z-index: 9;
            box-shadow: 0px 0px 1px 3px rgb(218, 218, 218, 0.50);
            background: #fff;
            width: 23px;
            height: 23px;
            cursor: pointer;
            transition:all 0.5s ease;
        }
        .gwi i:hover{
            background: #ff4081;
        }
        .gwi{
            margin-bottom: 25px;
            position: relative;
        }
        ul.cat-list{
            padding-right: 20px;
        }
        #img{
            border:dashed 2px #ddd;
            padding: 5px;
        }
    </style>

    <!-- seo preview --->
    <link href="{{$dotSlashes}}plugin/seo-preview/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link href="{{$dotSlashes}}plugin/seo-preview/css/jquery-seopreview.css" rel="stylesheet" type="text/css">

@stop

@section('content')
    <?php $auth=auth()->user();
    $mod=$post->id > 0?'edit':'add';
    ?>
    <form class="send-ajax" method="post" action="{{url('/management/post-update')}}" data-after-done="form_after_done" data-with-file="yes" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{\App\Helper\Helper::hash($post->id)}}">
        <div class="row">
            <div class="col m8 s12">
                <div class="card ">
                    <div class="card-header gradient-45deg-light-blue-cyan gradient-shadow">
                        <div class="title">@if($mod=='add')<span>ایجاد مکاتبه تازه</span> @endif {{$post->title}} </div>
                        <div class="tools">
                            <a href="{{url('/management/post-list')}}" class="btn white black-text">
                                <i class="material-icons left">arrow_forward</i><span class="hide-on-small-and-down"> برگشت به لیست </span>
                            </a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="input-field">
                            <input type="text" name="title" id="meta_title" value="{{$post->title}}" autocomplete="off" required  onkeyup="sync_preview()" >
                            <label>عنوان مکاتبه را وارد کنید</label>
                        </div>

                        <div>
                            <button type="button" class="btn btn-small amber black-text mb-1" onclick="fm_modal_open(this)" data-filter="image" data-after-done="insertImageInTiny">افزودن تصویر</button>
                            <button type="button" class="btn btn-small amber black-text mb-1" onclick="fm_modal_open(this)" data-filter="image" data-after-done="insertVideoInTiny">افزودن ویدئو</button>
                            <button type="button" class="btn btn-small amber black-text mb-1" onclick="fm_modal_open(this)" data-filter="image" data-after-done="insertAudioInTiny">افزودن صدا</button>
                            <textarea class="browser-default tiny" name="content">{{$post->content}}</textarea>
                        </div>
                    </div>
                </div>




            </div>
            <!--انتشار-->
            <div class="col m4 s12">
                <div class="card">
                    <div class="card-header gradient-45deg-light-blue-cyan gradient-shadow">
                        <div class="title">انتشار</div>
                        <div class="tools">
                            @if($post->id > 0)
                            <a href="{{url('/management/post-add')}}" class="btn white black-text">
                                <i class="material-icons left">add</i> جدید
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-content">
                        <p class="mb-4 font-medium">
                            <span><i class="material-icons left">people</i> ویرایش توسط : </span> <span class="font-small cyan-text iransans">{{$auth->nickname}}</span>
                        </p>
                        <p class="mb-4 font-medium">
                            <span><i class="material-icons left">alarm_on</i> ایجاد :</span> <span class="font-small blue-text iransans">{{\App\Helper\Helper::v($post->created_at)}}</span>
                        </p>
                        <p class="mb-4 font-medium">
                            <span> <i class="material-icons left">update</i> بروز رسانی : </span> <span class="font-small blue-text iransans">{{\App\Helper\Helper::v($post->updated_at)}}</span>
                        </p>
                        <div class="row">
                            <div class="divider col m12 mb-4" ></div>
                            @foreach(\App\Models\Post::status() as $key=>$val)
                                <div class="col m6 s12 mb-4">
                                    <label>
                                        <input type="radio" name="status" value="{{$key}}" {{$post->status==$key?'checked':''}} >
                                        <span>{{$val}}</span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="divider col m12 mb-4" ></div>

                            <div class="col s12">
                                <button type="submit" class="btn cyan">ذخیره </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!---تصویر شاخص--->
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="col s12">
                                <p class="iransans black-text bold mb-3">انتخاب تصویر </p>
                                <input type="file" name="file">

                                <div class="text-left mt-5 grey lighten-3" dir="ltr" style="padding: 5px">
                                    <p class="bold black-text text-right" dir="rtl">فایل اپدیت شده : </p>
                                    <?php
                                    $files = glob('uploads/post/'.$post->id.'_*.*');
                                    foreach ($files as $file){
                                        $f = explode('/',$file);
                                        echo '<a href="'.url('/uploads/post/'.end($f)).'" >&nbsp;'.end($f).'</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

    <!-- tinymce-->
    <script src="{{$dotSlashes}}plugin/tinymce/jquery.tinymce.min.js"></script>
    <script src="{{$dotSlashes}}plugin/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: ".tiny,.tiny2,.tiny3,.tiny4",
            height: 500,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor code fullscreen save"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect ",
            toolbar2: "| link unlink | image media | forecolor backcolor  | print preview code fullscreen save- | styleselect ",
            image_advtab: true ,
            theme_advanced_fonts : "Tahoma=tahoma",
            relative_urls : false,
            remove_script_host : false,
            document_base_url : $baseUrl+'/',
            directionality : "rtl",
            language: 'fa',
            save_enablewhendirty: true,
            fontsize_formats: "8pt 10pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 20pt 22pt 24pt 36pt",
            setup: function (ed) {
                ed.on("change", function () {
                    tinyOnChangeHandler(ed);
                })
            }
        });
        function tinyOnChangeHandler(inst) {
            let content=inst.getBody().innerHTML;
            content = content.replace(/(<([^>]+)>)/gi, "");
            $("#js-seo-preview__google-desc").html(helper().excerpt(content,150,''));
        }
    </script>
    <script>
		/*درج تصویر در ادیتور*/
        function insertImageInTiny(param) {
            let sr=$baseurl+'/uploads/media/'+param.file;
            tinyMCE.execCommand('mceInsertContent', false, '<img alt="Mohammad Shoja" src="' + sr + '"/>');
        }
		/*درج ویدئو در ادیتور*/
        function insertVideoInTiny(param) {
            let sr=$baseurl+'/uploads/media/'+param.file;
            let $video = '<video width="320" height="240" controls>';
            $video += '<source src="'+sr+'" type="video/mp4">';
            $video += '<source src="'+sr+'" type="video/ogg">';
            $video += 'مرور گر شما از این قابلیت پشتیبانی نمیکند(ویدئو)';
            $video += '</video>';
            tinyMCE.execCommand('mceInsertContent', false, $video);
        }
        /*درج صدا در ادیتور*/
        function insertAudioInTiny(param) {
            let sr=$baseurl+'/uploads/media/'+param.file;
            let $audio = '<audio controls>';
            $audio += '<source src="'+sr+'" type="audio/ogg">';
            $audio += '<source src="'+sr+'" type="audio/mpeg">';
            $audio += 'مرور گر شما از این قابلیت پشتیبانی نمیکند(صدا)';
            $audio += '</audio>';
            tinyMCE.execCommand('mceInsertContent', false, $audio);
        }
        function form_after_done(param) {
            let id=parseInt('{{$post->id}}');
            if(id == 0)
                setTimeout(function () {
                    window.location.href=$baseurl+'/management/post-edit/'+param.id;
                },1500);
        }
    </script>

    <!---فایل منیجر--->
    <link rel="stylesheet" href="{{$dotSlashes}}plugin/file_manager/custom.css">
    <script src="{{$dotSlashes}}plugin/file_manager/custom.js"></script>
    <script>
        function after_done(param) {
            $("#"+param.id).attr('src',$baseurl+'/uploads/media/'+param.file);
            $("#img_text").html(param.file);
            $("#img_input").val(param.file);
        }
        function after_done2(param) {
            window.vm.list[param.id].img = param.file;
        }
    </script>

    <!--add category-->
    <script>
        function add_fast_category() {
            let $title=$("#cat_title");
            let $list=$("#post_category");
            if($title.val() == ''){
                M.toast({html:'ابتدا نام دسته را وارد کنید'});
                return 0;
            }
            helper().post($baseurl+'/management/add-fast-category',{
                title:$title.val(),
                type:'post',
                group_id:0
            }).done(function (r) {
                if(r.result){
                    $list.append('<li><label><input type="checkbox" name="cat[]" value="'+r.data.id+'"><span>'+$title.val()+'</span></label></li>');
                    $title.val('');
                }else{
                    M.toast({html:r.msg,classes:'yellow black-text'});
                }
            });
        }
    </script>

    <!--Veu-->
    <script src="{{$dotSlashes}}plugin/vue/vue.js"></script>
    <script>
        var vm = new Vue({
            el: '#vue_body',
            data: {
                loading:true,
                list:[],
            },
            mounted:function(){
                let vm=this;
                setTimeout(function () {
                    //vm.get_gallery();
                    window.sync_preview();
                },1000);
            },
            methods:{
                get_gallery(){
                    vm.loading = true;
                    helper().get('{{url('/management/post-get-gallery/'.\App\Helper\Helper::hash($post->id))}}')
                        .done(function (r) {
                            if(r.result){
                                vm.list = r.data;
                            }else{
                                M.toast({
                                    html:r.msg,
                                    classes:'warning',
                                });
                            }
                    }).fail(function (e) {
                        vm.loading = false;
                    })
                },
                add_item(){
                    vm.list.push({img:'',caption:''});
                },
                remove_item(k){
                    vm.list.splice(k,1);
                },
                save_gallery(){
                    vm.loading = true;
                    helper().post('{{url('/management/post-save-gallery')}}',{
                        id:'{{\App\Helper\Helper::hash($post->id)}}',
                        list:vm.list,
                    }).done(function (r) {
                        if(r.result){
                            M.toast({
                                html:'گالری بروز رسانی شد',
                                classes:'success',
                            });

                        }else{
                            M.toast({
                                html:r.msg,
                                classes:'warning',
                            });
                        }
                    })
                },
            },
        });
    </script>

    <script>
        function sync_preview() {
            let title=$("#meta_title").val();
            let mod = '{{$mod}}';
            let id = '{{$post->id}}';

            let url=$baseurl+'/post/'+id+'/'+$("#unique_title").val();
            let url2=$baseurl+'/'+$("#unique_title").val();
            $("#link-preview").html(url);
            $("#link-preview").attr('href',url);

            $("#link-preview2").html(url2);
            $("#link-preview2").attr('href',url2);

            $("#js-seo-preview__google-title").html(title);
            $("#js-seo-preview__google-url").html(url);
        }
    </script>

    <!------File Uploader--------->
    <link href="{{_slash('plugin/ajax-uploader/jquery.growl.css')}}" rel="stylesheet" type="text/css">
    <link href="{{_slash('plugin/ajax-uploader/src/fileup.css')}}" rel="stylesheet" type="text/css">
    <script src="{{_slash('plugin/ajax-uploader/jquery.growl.js')}}"></script>
    <script src="{{_slash('plugin/ajax-uploader/src/fileup.js')}}"></script>
    <script src="{{_slash('plugin/ajax-uploader/custom.js')}}"></script>
    <script>
        let $opt={
            inputID: 'upload-1', //this.fileup.options; options.inputID
            dropzoneID: 'upload-1-dropzone',
            queueID: 'upload-1-queue',
            wrap:'multiple-file-1',
            id_list_upload:'my-list-file',
            fieldName: 'files[]',
            id:'{{$post->id}}_gallery_',
            token:'{{csrf_token()}}',
            path:'post',
            sizeLimit:1000000, // 1Mb = 1000000
            filesLimit:10, // max file count select
            autostart:false,
        };
        _constructor($opt);
    </script>

    <!----فرم تکرار شونده---->
    <script src="{{_slash('back')}}/app-assets/vendors/form_repeater/jquery.repeater.min.js"></script>
    <script>
        $('document').ready(function () {
            var $repeater=$(".invoice-item-repeater").repeater({
                show: function () {
                    $(this).slideDown();
                },
                hide: function (e) {
                    $(this).slideUp(e);
                    //confirm("آیا از حذف این عبارت اطمینان دارید ؟") && $(this).slideUp(e);
                },
            });
            $repeater.setList([
                @foreach(!empty($post->info)?json_decode($post->info):[] as $opt)
                {
                    'name': '{{isset($opt->name)?$opt->name:''}}' ,
                    'value': '{{isset($opt->value)?$opt->value:''}}',
                    'class': '{{isset($opt->class)?$opt->class:''}}'
                },
                @endforeach
            ]);

        });
    </script>

@stop

