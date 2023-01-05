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
        #step1,#step2{
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $currency = currency()?>
    <?php $auth = \Illuminate\Support\Facades\Auth::check();?>
    <?php
        seoMeta([
            'pageTitle'=>'صفحه ورود با تلفن همراه',
        ]);
    ?>

    <div class="container" id="app_vue_body">
        <div class="auth-wrapper">
            <div class="auth-form shadow-around mt-3">
                <div class="text-center mb-5">
                    <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(url('uploads/setting/'.\App\Models\Option::getval('logo'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" style="max-height: 90px">
                    </a>
                </div>

                <?php $callback = isset($_GET['callback'])?$_GET['callback']:'' ?>
                <div method="post" action="<?php echo e(url('/login-done')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="callback" value="<?php echo e($callback); ?>">
                    <div v-if="step == 1" class="form-element-row" id="step1">
                        <h4>ورود | ثبت نام</h4>
                        <p class="mt-4 mb-2">سلام!</p>
                        <p class="mt-2 mb-3"> نام کاربری یا شماره موبایل خود را وارد کنید</p>
                        <div class="form-element-with-icon">
                            <input v-model="mobile" v-on:keydown="inputMobile" dir="ltr" type="number" maxlength="11" id="mobile-number" class="input-element text-center"  autocomplete="off" placeholder="شماره همراه خود را وارد کنید">
                            <i class="fad fa-mobile-alt"></i>
                        </div>
                        <p v-if="error_message.length" class="text-danger font-weight-bold mt-3" v-text="error_message"></p>
                        <div class="form-element-row mt-3">
                            <button type="button" v-on:click="sendMobile" class="btn-element btn-danger-element font-weight-bold" style="width: 100%;background: #ef4056 !important;">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                ورود
                            </button>
                        </div>
                    </div>

                    <div v-if="step == 2" class="form-element-row" id="step2" >
                        <h4>کد تایید را وارد کنید</h4>
                        <p class="mt-4 mb-3">کد تایید برای شماره <span class="font-weight-bold" v-text="mobile"></span> پیامک شد </p>
                        <div class="form-element-with-icon">
                            <input type="text" v-model="verify_code" v-on:keydown="inputVerify" id="verify-code" dir="ltr" class="input-element text-center"  autocomplete="off" placeholder="کد تایید را وارد کنید">
                            <i class="fad fa-mobile-alt"></i>
                        </div>
                        <div>
                            <p class="text-info  text-center mt-3 cursor-pointer font-iranYekan" style="font-size: 12px" v-on:click="step=1" >دریافت مجدد کد تایید</p>
                        </div>

                        <div id="days"></div>
                        <div id="hours"></div>
                        <div id="mins"></div>
                        <div id="secs"></div>
                        <div id="end"></div>
                        <div class="form-element-row mt-3">
                            <button type="button" v-on:click="checkAndLogin()" class="btn-element btn-danger-element font-weight-bold" style="width: 100%;background: #ef4056 !important;">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                               تایید
                            </button>
                        </div>
                    </div>
                </div>

                <div class="auth-form-footer">
                    <span class="font-small">اگر  قبلا ثبت نام نکرده اید ؟</span>
                    <a href="<?php echo e(url('/register?callback='.$callback)); ?>" class="link--with-border-bottom font-small"> اینجا کلیک کنید</a>
					<span class="font-small">همچنین میتوانید</span>
					<a href="<?php echo e(url('/login?callback='.$callback)); ?>" class="link--with-border-bottom font-small"> با رمز عبور</a>
					<span class="font-small">نیز وارد شوید</span>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footerScript'); ?>
    <script>

    </script>
    <script src="<?php echo e(_slash()); ?>plugin/vue/vue.js"></script>
    <script>
        var vm;
        $(document).ready(function () {
            vm = new Vue({
                el: '#app_vue_body',
                data: {
                    step:1,
                    loading:0,
                    mobile:'',
                    verify_code:'',
                    callback:'<?php echo e($callback); ?>',
                    error_message:'',
                },
                mounted(){
                    $("#step1,#step2").fadeIn(1100);
                    /*setTimeout(function () {
                        document.querySelector('#mobile-number').addEventListener('keypress', function (e) {
                            console.log('salam');
                            if (e.key === 'Enter') {
                                vm.sendMobile();
                            }
                        });
                    },1150)*/
                },
                methods:{
                    /*جستجوی محصول*/
                    sendMobile(){
                        if(vm.mobile.length < 4){
                            $toast.fire({icon:'warning',title:'لطفا شماره همراه یا نام کاربری خود را با دقت وارد نمایید'});
                            return 0;
                        }
                        vm.error_mesage = '';
                        vm.loading = 1;
                        helper().post('<?php echo e(url("/")); ?>/mobile-verify-code',{
                            mobile:vm.mobile,
                        })
                        .done(function (r) {
                            if(r.result){
                                vm.step = 2;
                                //$("#step2").fadeIn();

                                //timerOn();
                            }else{
                               vm.error_message = r.msg;
                            }
                            vm.loading = 0;
                        })
                        .fail(function(e){
                            vm.loading = 0;
                        })
                    },
                    checkAndLogin(){
                        vm.error_mesage = '';
                        vm.loading = 1;
                        helper().post('<?php echo e(url("/")); ?>/mobile-check-code',{
                            mobile:vm.mobile,
                            verify_code:vm.verify_code,
                        })
                        .done(function (r) {
                            if(r.result){
                                window.location.href = vm.callback.length?vm.callback.length:'<?php echo e(url("/")); ?>';
                            }else{
                                $toast.fire({icon:'warning',title:r.msg});
                            }
                            vm.loading = 0;
                        })
                        .fail(function(e){
                            vm.loading = 0;
                        })
                    },
                    inputMobile(event){
                        //console.log(event.keyCode);
                        if(event.keyCode === 13){
                            vm.sendMobile();
                        }
                    },
                    inputVerify(event){
                        if(event.keyCode === 13){
                            vm.checkAndLogin();
                        }
                    }
                },
                watch: {},

            });
        });
    </script>

	<!---تایمر جاوا اسکریپت--->
	<script>
		// The data/time we want to countdown to
        var d1 = new Date (),
            d2 = new Date ( d1 );
        d2.setMinutes ( d1.getMinutes() + 1 );
		var countDownDate = d2;

		// Run myfunc every second
		function timerOn() {
            var myfunc = setInterval(function() {
                var now = new Date().getTime();
                var timeleft = countDownDate - now;

                // Calculating the days, hours, minutes and seconds left
                var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

                // Result is output to the specific element
                document.getElementById("days").innerHTML = days + "d ";
                document.getElementById("hours").innerHTML = hours + "h ";
                document.getElementById("mins").innerHTML = minutes + "m ";
                document.getElementById("secs").innerHTML = seconds + "s ";

                // Display the message when countdown is over
                if (timeleft < 0) {
                    clearInterval(myfunc);
                    document.getElementById("days").innerHTML = "";
                    document.getElementById("hours").innerHTML = "";
                    document.getElementById("mins").innerHTML = "";
                    document.getElementById("secs").innerHTML = "";
                    document.getElementById("end").innerHTML = "TIME EXPIRE!!";
                }
            }, 1000);
        }
	</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('front-end.default._layout_master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/front-end/default/login-mobile.blade.php ENDPATH**/ ?>