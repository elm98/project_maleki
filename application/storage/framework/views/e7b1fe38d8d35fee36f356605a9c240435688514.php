<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
<?php $__env->startSection('headerScript'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css-rtl/pages/page-knowledge.min.css">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="section" id="knowledge">
        <div class="row knowledge-content">
            <div class="col s12">
                <div id="search-wrapper" class="card z-depth-0 search-image center-align p-35">
                    <div class="card-content">
                        <h5 class="center-align mb-3">بنظر میرسد دسترسی به این صفحه برای شما محدود شده</h5>
                        
                        <button class="btn" onclick="window.location.href='<?php echo e(url('/management/dashboard')); ?>'">بازگشت به داشبورد<i class="material-icons left">dashboard</i></button>
                        <button class="btn" onclick="window.history.back()">بازگشت به صفحه قبل<i class="material-icons right">arrow_back</i></button>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card card-hover z-depth-0 card-border-gray">
                    <div class="card-content center-align">
                        <h5><b>پشتیبانی</b></h5>
                        <i class="material-icons md-48 red-text">favorite_border</i>
                        <p class="mb-2 black-text"><a href="tel:<?php echo e(\App\Models\Option::getval('tel')); ?>">با پشتیبانی تماس بگیرید<br><?php echo e(\App\Models\Option::getval('tel')); ?></a></p>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('float_button'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('back-end.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/back-end/access_denied.blade.php ENDPATH**/ ?>