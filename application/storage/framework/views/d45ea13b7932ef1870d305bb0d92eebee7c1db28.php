<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
<?php $__env->startSection('headerScript'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css-rtl/pages/page-account-settings.min.css">
    <!--crop image-->
    <link href="<?php echo e($dotSlashes); ?>plugin/crop-image/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>plugin/crop-image/pixelarity.css">
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col s12">
        <div class="container">
        <!-- Account settings -->
            <section class="tabs-vertical mt-1 section">
                <div class="row">
                    <div class="col l2 s12">
                    </div>
                    <div class="col l8 s12">
                        <!-- tabs content -->
                        <div id="general">
                            <div class="card-panel">
                                <div class="display-flex">
                                    <div class="media">
                                        <img src="<?php echo e(\App\Helper\Helper::getAvatar($user->avatar)); ?>" id="media-img" class="border-radius-4" alt="profile image" height="64" width="64">
                                    </div>
                                    <div class="media-body">
                                        <div class="general-action-btn">
                                            <button id="select-files text-center" onclick="$('#upfile').click()" class="btn indigo mr-2 iransans">
                                                <i class="material-icons left">crop_rotate</i>
                                                <span class="hide-on-small-and-down">یک آواتار برای خود انتخاب کنید</span>
                                            </button>
                                            <button class="btn btn-light-pink iransans" onclick="$('#upfile').val(null);$('#media-img').attr('src','<?php echo e($dotSlashes); ?>back/custom/img/avatar.png');$('#avatar').val('')"><i class="material-icons left">autorenew</i><span class="hide-on-small-and-down">تنظیم مجدد</span> </button>
                                        </div>
                                        <small>JPG یا PNG مجاز است. حداکثر اندازه 200kB</small>
                                        <div class="upfilewrapper">
                                            <input id="upfile" type="file" onchange="faceCrop(this,'media-img')" />
                                        </div>
                                    </div>
                                </div>

                                <form class="form-valid send-ajax" method="post" action="<?php echo e(url('/management/user-update')); ?>" >
                                    <div class="row">
                                        <div class="col s12  mb-3 mt-1 mb-3 display-block"><hr></div>
                                        <input type="hidden" id="avatar" name="avatar">
                                        <input type="hidden" name="id" value="<?php echo e(\App\Helper\Helper::hash($user->id)); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>نام کاربری</label>
                                                <input type="text"  disabled value="<?php echo e($user->username); ?>" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>نام</label>
                                                <input name="fname" type="text" value="<?php echo e($user->fname); ?>" required data-msg-required="اسم کوچک را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label>فامیلی</label>
                                                <input name="lname" type="text" value="<?php echo e($user->lname); ?>" required data-msg-required="نام خانوادگی را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <input name="mobile" type="number" value="<?php echo e($user->mobile); ?>" disabled maxlength="11" minlength="11" required data-msg-required="موبایل را وارد کنید" autocomplete="off" >
                                                <label class="active always">موبایل</label>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <label class="active always">تاریخ تولد</label>
                                                <input name="birthday" type="text" value="<?php echo e(\App\Helper\Helper::v($user->birthday,'Y/m/d')); ?>" id="pdate1" readonly autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <input name="code_melli" value="<?php echo e($user->code_melli); ?>"  class="text-center" type="number" maxlength="10" minlength="10" required data-msg-required="کد ملی را وارد کنید" autocomplete="off" >
                                                <label>کد ملی *</label>
                                            </div>
                                        </div>
                                        <div class="break"></div>
                                        <input type="hidden" name="status" value="active">


                                        <div class="col s12">
                                            <div class="row mb-5">
                                                <div class="col s12">
                                                    <label >نوع کاربر را مشخص کنید *</label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="type" required value="real" type="radio" checked onchange="$(this).is(':checked')?$('.company').hide():$('.company').show()" <?php echo e($user->type == 'real'?'checked':''); ?>>
                                                        <span> حقیقی </span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 input-field">
                                                    <label>
                                                        <input name="type" required value="legal" type="radio" onchange="$(this).is(':checked')?$('.company').show():$('.company').hide()" <?php echo e($user->type == 'legal'?'checked':''); ?>>
                                                        <span> حقوقی </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col m6 s12 company <?php echo e($user->type == 'real'?'display-none':'display-block'); ?>">
                                            <div class="input-field">
                                                <label>نام شرکت *</label>
                                                <input name="owner_name" value="<?php echo e($user->owner_name); ?>" type="text" required data-msg-required="نام شرکت را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col m6 s12 company <?php echo e($user->type == 'real'?'display-none':'display-block'); ?>">
                                            <div class="input-field">
                                                <label> نام مدیر شرکت *</label>
                                                <input name="company_name" value="<?php echo e($user->company_name); ?>" type="text" required data-msg-required="نام مدیر شرکت را وارد کنید" value="" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action mt-3">
                                            <a class="btn btn-light-pink iransans" href="<?php echo e(url('/management/user-list')); ?>">برگشت به لیست </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره تغییرات
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footerScript'); ?>
    
    <script type="text/javascript" src="<?php echo e($dotSlashes); ?>plugin/crop-image/pixelarity-face.js"></script>
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
                $("#"+id).attr('src','<?php echo e($dotSlashes); ?>back/custom/img/avatar.png');
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



<?php $__env->stopSection(); ?>


<?php echo $__env->make('back-end.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/back-end/user_edit.blade.php ENDPATH**/ ?>