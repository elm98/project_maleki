<?php $__env->startSection('headerScript'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(url('uploads/setting/'.\App\Models\Option::getval('logo'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" style="max-height: 90px">
                    </a>
                </div>

                <?php $callback = isset($_GET['callback'])?$_GET['callback']:'' ?>
                <form method="post" action="<?php echo e(url('/login-done')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="callback" value="<?php echo e($callback); ?>">
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
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <b class="text-danger"><?php echo e($error); ?></b>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty(session('error'))): ?>
                            <b class="text-danger"><?php echo e(session('error')); ?></b>
                        <?php endif; ?>
                    </div>
                    <div class="form-element-row ">
                        <button type="submit" class="btn-element btn-info-element" style="width: 100%;background-color: #ef4056;">
                            ورود به سامانه
                        </button>
                    </div>
                </form>

                <div class="auth-form-footer">
                    <span>کاربر جدید هستید ؟</span>
                    <a href="<?php echo e(url('/register?callback='.$callback)); ?>" class=" font-small text-danger">ثبت نام کنید </a>
                    <span>همچنین میتوانید</span>
                    <a href="<?php echo e(url('/login-mobile?callback='.$callback)); ?>" class=" font-small text-danger"> با موبایل وارد شوید </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.default._layout_master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/front-end/default/login.blade.php ENDPATH**/ ?>