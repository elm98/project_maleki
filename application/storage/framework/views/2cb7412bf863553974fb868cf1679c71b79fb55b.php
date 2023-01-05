<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="داشبورد مدیریتی توسعه داده شده توسط گروه نرم افزاری یونیک">
    <meta name="keywords" content="پنل ، داشبورد مدیریت ، صفحات ادمین ، مدیریت بک اند">
    <meta name="author" content="ThemeSelect">
    <title>ورود به داشبورد مدیریت</title>
    <link rel="apple-touch-icon" href="<?php echo e(\App\Models\Option::get_img('logo_small','setting')); ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(\App\Models\Option::get_img('logo_small','setting')); ?>">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="./back/app-assets/vendors/vendors.min.css">
    <!-- END: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="./back/app-assets/css-rtl/style-rtl.min.css">
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="./back/app-assets/css-rtl/themes/vertical-modern-menu-template/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="./back/app-assets/css-rtl/themes/vertical-modern-menu-template/style.min.css">
    <link rel="stylesheet" type="text/css" href="./back/app-assets/css-rtl/pages/login.css">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="./back/app-assets/css-rtl/custom/custom.css">
    <!-- END: Custom CSS-->
    <style>
        .input-field input[type]{
            height: 3rem;
        }
        .login_icon{
            background: #1cadfe;
            text-align: center;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            color: #000;
            height: 3rem;
        }
    </style>
</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
<div class="row">
    <div class="col s12">
        <div class="container">
            <div id="login-page" class="row">
                <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                    <form id="formValidate" method="post" action="logged-in" class="login-form">
                        <div class="row">
                            <div class="input-field col s12">
                                <h6 class="center-align">ورود به داشبورد مدیریت</h6>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix pt-1 login_icon">person_outline</i>
                                <input id="username" name="username" type="text">
                                <label for="username" class="center-align">نام کاربری</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="input-field col s12">
                                <i class="material-icons prefix pt-1 login_icon">lock_outline</i>
                                <input id="password" name="password" required data-msg-required="نام کاربری را پر کنید" type="password">
                                <label for="password">رمز عبور</label>
                            </div>
                        </div>
                        <div class="row margin">
                            <div class="col s12 m12 l12 ml-1 mt-1">
                                <p>
                                    <label>
                                        <input type="checkbox" value="1" name="remember"/>
                                        <span>مرا به خاطر بسپار</span>
                                    </label>
                                </p>
                                <p>
                                    <a href="<?php echo e(url('/')); ?>">
                                        <span>رفتن به وبسایت</span>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <?php echo e(csrf_field()); ?>

                                <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">وارد شدن<i class="material-icons left">fingerprint</i></button>
                            </div>
                        </div>
                        <div class="row">
                            <?php if($errors->any()): ?>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col m12 l12">
                                        <div class="card-alert card orange lighten-5">
                                            <div class="card-content orange-text">
                                                <p><?php echo e($error); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif(session('error')): ?>
                                <div class="col m12 l12">
                                    <div class="card-alert card orange lighten-5">
                                        <div class="card-content orange-text">
                                            <p><?php echo e(session('error')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="content-overlay"></div>
    </div>
</div>

<!-- BEGIN VENDOR JS-->
<script src="./back/app-assets/js/vendors.min.js"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<!-- END PAGE VENDOR JS-->
<!-- BEGIN THEME  JS-->
<script src="./back/app-assets/js/plugins.min.js"></script>
<script src="./back/app-assets/js/search.min.js"></script>
<script src="./back/app-assets/js-rtl/custom/custom-script-rtl.min.js"></script>
<!-- END THEME  JS-->
<!-- BEGIN PAGE LEVEL JS-->
<!-- END PAGE LEVEL JS-->


</body>

</html>
<?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/back-end/log_in.blade.php ENDPATH**/ ?>