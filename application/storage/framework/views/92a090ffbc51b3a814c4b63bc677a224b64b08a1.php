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
        .form-element-row .form-element-with-icon i{
            font-size: 15px;
        }
    </style>
    <script>
        let $error = 0;
        let $success = 0;
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $currency = currency()?>
    <?php $auth = \Illuminate\Support\Facades\Auth::check();
    $options = \App\Models\Option::multiValue(['blog_title','description','tags','logo']);
    $meta=[
        'url'=>url()->current(),
        'pageTitle'=>'ثبت نام مشتری - '.$options['blog_title'],
        'description'=>$options['description'],
        'tags'=>$options['tags'],
        'type'=>'article' ,//articles |
        'image'=>url('uploads/setting/'.$options['logo']),
        'image_url'=>url('uploads/setting/'.$options['logo']),
    ];
    seoMeta($meta);
    ?>

    <div class="container">
        <div class="auth-wrapper" id="top">
            <div class="auth-form shadow-around mt-3">
                <div class="text-center mb-5">
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(url('uploads/setting/'.\App\Models\Option::getval('logo'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" style="max-height: 90px">
                    </a>
                </div>

                <?php $callback = isset($_GET['callback'])?$_GET['callback']:'' ?>
                <form method="post" action="<?php echo e(url('/register-done')); ?>" class="send-ajax" data-after-done="after_done">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="callback" value="<?php echo e($callback); ?>">
                    <h4 class="mb-3">ثبت نام</h4>
                    <div class="form-element-row">
                        <label  class="label-element">شماره موبایل (نام کاربری)</label>
                        <div class="form-element-with-icon">
                            <input type="number" maxlength="11" name="mobile" class="input-element"  autocomplete="off" value="<?php echo e(old('mobile')); ?>">
                            <i class="fad fa-mobile-alt"></i>
                        </div>
                    </div>
                    <div class="form-element-row">
                        <label  class="label-element">نام (اسم کوچک)</label>
                        <div class="form-element-with-icon">
                            <input type="text" name="fname" class="input-element" value="<?php echo e(old('fname')); ?>" autocomplete="off">
                            <i class="fad fa-user"></i>
                        </div>
                    </div>

                    <div class="form-element-row">
                        <label  class="label-element"> نام خانوادگی (فامیلی)</label>
                        <div class="form-element-with-icon">
                            <input type="text" name="lname" class="input-element" value="<?php echo e(old('lname')); ?>" autocomplete="off">
                            <i class="fad fa-user-alt"></i>
                        </div>
                    </div>



                    <div class="form-element-row">
                        <label  class="label-element"> کلمه عبور (حداقل 6 کاراکتر)</label>
                        <div class="form-element-with-icon">
                            <input type="password" name="password" class="input-element"  autocomplete="off">
                            <i class="fad fa-lock"></i>
                        </div>
                    </div>

                    <div class="form-element-row">
                        <label  class="label-element"> تکرار کلمه عبور</label>
                        <div class="form-element-with-icon">
                            <input type="password" name="password_confirmation" class="input-element"  autocomplete="off">
                            <i class="fad fa-lock"></i>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly;margin-bottom: 30px">
                        <label class=" " >
                            حقیقی
                            <input type="radio" name="type" value="real" onchange="$(this).is(':checked')?$('.company').hide():$('.company').show()">
                        </label>

                        <label class="" >
                            حقوقی
                            <input type="radio" name="type" value="legal" checked onchange="$(this).is(':checked')?$('.company').show():$('.company').hide()">
                        </label>
                    </div>


                    <div class="form-element-row company">
                        <label  class="label-element">نام (اسم کوچک)</label>
                        <div class="form-element-with-icon">
                            <input type="text" name="company_name" class="input-element" value="<?php echo e(old('company_name')); ?>" autocomplete="off">
                            <i class="fad fa-user"></i>
                        </div>
                    </div>

                    <div class="form-element-row company">
                        <label  class="label-element"> نام خانوادگی (فامیلی)</label>
                        <div class="form-element-with-icon">
                            <input type="text" name="owner_name" class="input-element" value="<?php echo e(old('owner_name')); ?>" autocomplete="off">
                            <i class="fad fa-user-alt"></i>
                        </div>
                    </div>




                    <div class="pt-3 pb-3" id="errors">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><b class="text-danger"><?php echo e($error); ?></b></p>
                            <script> $error = 1;</script>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty(session('error'))): ?>
                           <p><b class="text-danger"><?php echo e(session('error')); ?></b></p>
                                <script> $error = 1;</script>
                        <?php endif; ?>
                        <?php if(!empty(session('success'))): ?>
                            <p><b class="text-success"><?php echo e(session('success')); ?></b></p>
                            <script> $success = 1;</script>
                        <?php endif; ?>
                    </div>


                    <div class="form-element-row text-left">
                        <button type="submit" id="subBtn" class="btn-element btn-primary" style="background: #ef4056">
                            <i class="fad fa-user"></i>
                            ثبت نام در سامانه
                        </button>
                    </div>
                </form>
                <div class="auth-form-footer">
                    <span class="font-small">قبلا ثبت نام کردم؟</span>
                    <a href="<?php echo e(url('/login?callback='.$callback)); ?>" class=" text-danger font-small">ورود به سامانه</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
    <script>
        function after_done() {
            setTimeout(function () {
                window.location.href = '<?php echo e(url('/profile')); ?>';
            },3000)
        }
    </script>
<script>
    $(document).ready(function () {
        if($error){
            helper().scrollTo('errors');
        }else{
            helper().scrollTo('top');
        }
        if($success){
            setTimeout(function () {
                window.location.href = '<?php echo e(url('/')); ?>';
            },3000)
        }
    })
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.default._layout_master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/front-end/default/register.blade.php ENDPATH**/ ?>