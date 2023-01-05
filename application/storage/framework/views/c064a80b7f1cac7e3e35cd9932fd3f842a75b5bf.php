<?php $dotSlashes=\App\Helper\Helper::dot_slashes()?>
<?php use App\Models\Option; $head_color=1;?>
<?php $__env->startSection('headerScript'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e($dotSlashes); ?>back/app-assets/css-rtl/pages/page-account-settings.min.css">
    <style>
        input[type],textarea{
            color:green;
        }
        .gateway{
            background: #eee;
            border-radius: 5px;
            padding: 10px;
            height: 100%;
        }
        .gateway input{
            color:#000;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col s12">
        <div class="container">
            <section class="tabs-vertical mt-1 section">
                <div class="row">
                    <div class="col l4 s12">
                        <!-- tabs  -->
                        <div class="card-panel">
                            <ul class="tabs">
                                <li class="tab">
                                    <a href="#tab1">
                                        <i class="material-icons">brightness_low</i>
                                        <span>عمومی</span>
                                    </a>
                                </li>
                                <li class="tab" disabled>
                                    <a href="#tab2">
                                        <i class="material-icons">sms</i>
                                        <span>پیامک</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#tab3">
                                        <i class="material-icons">image</i>
                                        <span>تصاویر و لوگو</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#tab4">
                                        <i class="material-icons">call_to_action</i>
                                        <span>درگاه های بانک</span>
                                    </a>
                                </li>

                                <li class="tab">
                                    <a href="#tab5">
                                        <i class="material-icons">shop</i>
                                        <span>فروشگاه</span>
                                    </a>
                                </li>
                                <li class="tab">
                                    <a href="#tab6">
                                        <i class="material-icons">more</i>
                                        <span>موارد بیشتری</span>
                                    </a>
                                </li>
                            </ul>
                            <a class="btn btn-light-amber iransans w-100 mt-5" href="<?php echo e(url('/management/dashboard')); ?>"> رفتن به داشبورد </a>
                        </div>
                    </div>
                    <div class="col l8 s12 ">
                        <!-- tabs content -->
                        <div id="tab1">
                            <div class="card-panel">
                                <h6 class="mb-5">مشخصات عمومی</h6>
                                <form class="formValidate form-valid send-ajax" method="post" action="<?php echo e(url('/management/setting-update')); ?>" >
                                    <div class="row">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>عنوان سایت</label>
                                                <input type="text" name="optionKey_blog_title" required value="<?php echo e(Option::find_key($option,'blog_title')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col m12 s12">
                                            <div class="input-field">
                                                <textarea name="optionKey_description" class="materialize-textarea" ><?php echo e(Option::find_key($option,'description')); ?></textarea>
                                                <label>توضیحات</label>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <div class="input-field">
                                                <select name="tags[]" class="browser-default select2_tag" multiple>
                                                    <?php $__currentLoopData = explode(',',Option::find_key($option,'tags')); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item); ?>" selected><?php echo e($item); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <label>کلمات کلیدی سایت</label>
                                            </div>
                                        </div>

                                        <div class="col s12 mt-2">
                                            <div class="input-field">
                                                <label>ایمیل مدیریت</label>
                                                <input type="text" dir="ltr" name="optionKey_email" value="<?php echo e(Option::find_key($option,'email')); ?>" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col s12 mt-2">
                                            <div class="row">
                                                <div class="col m6 s6 input-field">
                                                    <label class="active">استان پیشفرض سامانه</label>
                                                    <select class="browser-default select2" name="optionKey_state" onchange="helper().setCitySelectBox(this.value,'city')">
                                                        <?php $__currentLoopData = getState(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($state->id); ?>" <?php echo e(intval(Option::find_key($option,'state')) == $state->id?'selected':''); ?>><?php echo e($state->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="col m6 s6 input-field">
                                                    <label class="active">شهر پیشفرض سامانه</label>
                                                    <select id="city" class="browser-default select2" name="optionKey_city">
                                                        <?php $__currentLoopData = getCity(intval(Option::find_key($option,'state'))); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($city->id); ?>" <?php echo e(Option::find_key($option,'city') == $city->id?'selected':''); ?>><?php echo e($city->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">notifications_active</i> نمایش شمارنده رویداد پنل مدیریت:</p>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_notify" value="enable" type="radio" <?php echo e(Option::find_key($option,'notify') == 'enable'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_notify" value="disable" type="radio" <?php echo e(Option::find_key($option,'notify') == 'disable'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="input-field">
                                                <p><i class="material-icons" style="vertical-align: bottom">timer</i>زمان رفرش رویداد (به میلی  ثانیه) </p>
                                                <input type="number" name="optionKey_refresh_time" value="<?php echo e(Option::find_key($option,'refresh_time')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s12 mt-4">
                                            <div class="input-field">
                                                <p class="active ">متن کپی رایت فوتر</p>
                                                <i class="material-icons cursor-pointer" onclick="$('#footer_copy_write').css({'text-align':'right','direction':'rtl'})">format_align_right</i>
                                                <i class="material-icons cursor-pointer" onclick="$('#footer_copy_write').css({'text-align':'left','direction':'ltr'})">format_align_left</i>
                                                <textarea id="footer_copy_write" type="text" name="optionKey_footer_copy_write" class="browser-default width-100" rows="10" autocomplete="off"><?php echo e(Option::find_key($option,'footer_copy_write')); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <hr/>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="<?php echo e(url('/management/dashboard')); ?>"> رفتن به داشبورد </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره تغییرات
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tab2">
                            <div class="card-panel ">
                                <h6 class="mb-5"> مشخصات سامانه پیامکی </h6>
                                
                                <div class="row" style="display: flex;flex-wrap: wrap;margin-top:15px">
                                    <!---واسطه ای--->
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold ">پنل پیامک واسطه ای</h6>
                                            <?php $opt = optionJsonValues('smsPanel_inductor')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="smsPanel_inductor">
                                                <input type="hidden" name="optionJson_title" value="پنل پیامک واسطه ای">
                                                <input type="hidden" name="optionJson_patternMod" value="no">
                                                <div class="input-field">
                                                    <p>آدرس سرور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_server" value="<?php echo e($opt->server); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>نام کاربری</p>
                                                    <input type="text" required dir="ltr" name="optionJson_user" value="<?php echo e($opt->user); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>رمز عبور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_pass" value="<?php echo e($opt->pass); ?>" autocomplete="off">
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" class="filled-in" name="smsPanelDefault" value="smsPanel_inductor" <?php echo e(Option::find_key($option,'smsPanelDefault')=="smsPanel_inductor"?'checked':''); ?>>
                                                        <span>به عنوان پیش فرض</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!---نیاز پرداز مستقیم--->
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold ">پنل ارسال مستقیم نیاز پرداز</h6>
                                            <?php $opt = optionJsonValues('smsPanel_niazpardaz')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="smsPanel_niazpardaz">
                                                <input type="hidden" name="optionJson_title" value="پنل ارسال مستقیم نیاز پرداز">
                                                <input type="hidden" name="optionJson_patternMod" value="no">
                                                <div class="input-field">
                                                    <p>آدرس سرور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_server" value="<?php echo e($opt->server); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>نام کاربری</p>
                                                    <input type="text" required dir="ltr" name="optionJson_user" value="<?php echo e($opt->user); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>رمز عبور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_pass" value="<?php echo e($opt->pass); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>شماره خط</p>
                                                    <input type="text" required dir="ltr" name="optionJson_lineNumber" value="<?php echo e($opt->lineNumber); ?>" autocomplete="off">
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" class="filled-in" name="smsPanelDefault" value="smsPanel_niazpardaz" <?php echo e(Option::find_key($option,'smsPanelDefault')=="smsPanel_niazpardaz"?'checked':''); ?>>
                                                        <span>به عنوان پیش فرض</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!---کاوه نگار پترنی--->
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold ">پیامک پترنی کاوه نگار</h6>
                                            <?php $opt = optionJsonValues('smsPanel_kavenegar')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="smsPanel_kavenegar">
                                                <input type="hidden" name="optionJson_title" value="پنل پیامک کاوه نگار">
                                                <input type="hidden" name="optionJson_patternMod" value="yes">
                                                <div class="input-field">
                                                    <p>API - توکن کاوه نگار</p>
                                                    <input type="text" required dir="ltr" name="optionJson_api" value="<?php echo e($opt->api); ?>" autocomplete="off">
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" class="filled-in" name="smsPanelDefault" value="smsPanel_kavenegar" <?php echo e(Option::find_key($option,'smsPanelDefault')=="smsPanel_kavenegar"?'checked':''); ?>>
                                                        <span>به عنوان پیش فرض</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!---ملی پیامک پترنی--->
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold ">پیامک پترنی ملی پیامک</h6>
                                            <?php $opt = optionJsonValues('smsPanel_mellipayamak')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="smsPanel_mellipayamak">
                                                <input type="hidden" name="optionJson_title" value="پنل پیامک ملی پیامک">
                                                <input type="hidden" name="optionJson_patternMod" value="yes">
                                                <div class="input-field">
                                                    <p>نام کاربری</p>
                                                    <input type="text" required dir="ltr" name="optionJson_user" value="<?php echo e($opt->user); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>رمز عبور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_pass" value="<?php echo e($opt->pass); ?>" autocomplete="off">
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" class="filled-in" name="smsPanelDefault" value="smsPanel_mellipayamak" <?php echo e(Option::find_key($option,'smsPanelDefault')=="smsPanel_mellipayamak"?'checked':''); ?>>
                                                        <span>به عنوان پیش فرض</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!---SMS.IR--->
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold ">پیامک پترنی SMS.IR</h6>
                                            <?php $opt = optionJsonValues('smsPanel_smsir')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="smsPanel_smsir">
                                                <input type="hidden" name="optionJson_title" value="پیامک پترنی SMS.IR">
                                                <input type="hidden" name="optionJson_patternMod" value="yes">
                                                <div class="input-field">
                                                    <p>API KEY</p>
                                                    <input type="text" required dir="ltr" name="optionJson_apikey" value="<?php echo e($opt->apikey); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>SECRET KEY</p>
                                                    <input type="text" required dir="ltr" name="optionJson_secretkey" value="<?php echo e($opt->secretkey); ?>" autocomplete="off">
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="radio" class="filled-in" name="smsPanelDefault" value="smsPanel_smsir" <?php echo e(Option::find_key($option,'smsPanelDefault')=="smsPanel_smsir"?'checked':''); ?>>
                                                        <span>به عنوان پیش فرض</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab3">
                            <div class="card-panel">
                                <h6 class="mb-5">مدیریت لوگوها</h6>
                                <div class="row">
                                    <div class="col m6 s12 center-align">
                                        <form class="send-ajax" method="post" action="<?php echo e(url('/management/setting-image-update')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="w-100">
                                                <p class="font-medium">لوگوی اصلی</p>
                                                <p class="font-small">JPG یا PNG مجاز است. حداکثر اندازه 200kB</p>
                                            </div>
                                            <img src="<?php echo e(_slash('uploads/setting/'.Option::find_key($option,'logo'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" id="img1" class="border-radius-4" alt="profile image" style="max-height:100px;max-width:100%">
                                            <div class="center-align">
                                                <i class="material-icons cursor-pointer" onclick="$('#upfile1').click()">monochrome_photos</i>
                                                <i class="material-icons cursor-pointer" onclick="$('#upfile1').val(null);$('#img1').attr('src','')">close</i>
                                                <input type="hidden" name="key" value="logo">
                                                <input type="hidden" name="img" id="i1" value="">
                                                <div class="break"></div>
                                                <button type="submit" class="btn">ذخیره تصویر</button>
                                            </div>
                                        </form>
                                        <input id="upfile1" type="file" onchange="helper().imagePreview(this,'img1',200000);" style="visibility: hidden" />
                                    </div>
                                    <div class="col m6 s12 center-align" style="background: #0b0b0b">
                                        <form class="send-ajax" method="post" action="<?php echo e(url('/management/setting-image-update')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="w-100">
                                                <p class="font-medium white-text">لوگوی برای حالت تاریک</p>
                                                <p class="font-small white-text">JPG یا PNG مجاز است. حداکثر اندازه 200kB</p>
                                            </div>
                                            <img src="<?php echo e(_slash('uploads/setting/'.Option::find_key($option,'logo_dark'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" id="img2" class="border-radius-4" alt="profile image" style="max-height:100px;max-width:100%">
                                            <div class="center-align">
                                                <i class="material-icons cursor-pointer white-text" onclick="$('#upfile2').click()">monochrome_photos</i>
                                                <i class="material-icons cursor-pointer white-text" onclick="$('#upfile2').val(null);$('#img2').attr('src','')">close</i>
                                                <input type="hidden" name="key" value="logo_dark">
                                                <input type="hidden" name="img" id="i2" value="">
                                                <div class="break"></div>
                                                <button type="submit" class="btn">ذخیره تصویر</button>
                                            </div>
                                        </form>
                                        <input id="upfile2" type="file" onchange="helper().imagePreview(this,'img2',200000)" style="visibility: hidden" />
                                    </div>
                                    <div class="col s12 mt-3">
                                        <div class="divider"></div>
                                    </div>

                                    <div class="col m12 s12 center-align">
                                        <form class="send-ajax" method="post" action="<?php echo e(url('/management/setting-image-update')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="w-100">
                                                <p class="font-medium">فاو ایکن</p>
                                                <p class="font-small">JPG یا PNG مجاز است. حداکثر اندازه 200kB</p>
                                            </div>
                                            <img id="img3" src="<?php echo e(_slash('uploads/setting/'.Option::find_key($option,'favicon'))); ?>" onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" class="border-radius-4" alt="profile image" style="max-height:70px;max-width:100%">
                                            <div class="center-align">
                                                <i class="material-icons cursor-pointer" onclick="$('#upfile3').click()">monochrome_photos</i>
                                                <i class="material-icons cursor-pointer" onclick="$('#upfile3').val(null);$('#img3').attr('src','')">close</i>
                                                <input type="hidden" name="key" value="favicon">
                                                <input type="hidden" name="img" id="i3" value="favicon">
                                                <div class="break"></div>
                                                <button type="submit" class="btn">ذخیره تصویر</button>
                                            </div>
                                        </form>
                                        <input id="upfile3" type="file" onchange="helper().imagePreview(this,'img3',200000);" style="visibility: hidden" />
                                        <div class="divider"></div>
                                    </div>

                                    <form id="form2" class="form-valid1 send-ajax" method="post" action="<?php echo e(url('/management/setting-update')); ?>" >
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col s12 mt-2">
                                            <div class="input-field">
                                                <p>تصویر اصالت سایت (ای نماد)</p>
                                                <input type="text" name="optionKey_namad1" value="<?php echo e(Option::find_key($option,'namad1')); ?>" autocomplete="off" placeholder="کد ، متن یا آدرس تصویر ای نماد را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="col s12 mt-2">
                                            <div class="input-field">
                                                <p>تصویر اصالت سایت (شماره 2)</p>
                                                <input type="text" name="optionKey_namad2" value="<?php echo e(Option::find_key($option,'namad2')); ?>" autocomplete="off" placeholder="کد ، متن یا آدرس تصویر نماد را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="col s12 mt-2">
                                            <div class="input-field">
                                                <p>تصویر اصالت سایت (شماره 3)</p>
                                                <input type="text" name="optionKey_namad3" value="<?php echo e(Option::find_key($option,'namad3')); ?>" autocomplete="off" placeholder="کد ، متن یا آدرس تصویر نماد را وارد کنید">
                                            </div>
                                        </div>
                                        <div class="col m12 s12">
                                            <button type="submit" class="btn green">ذخیره مشخصات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="tab4">
                            <div class="card-panel">
                                <h6 class="mb-5">مدیریت درگاههای بانکی</h6>
                                <div class="row " style="display: flex;flex-wrap: wrap">
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold ">بانک پارسیان</h6>
                                            <?php $opt = optionJsonValues('bank_parsian')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_parsian">
                                                <input type="hidden" name="optionJson_title" value="بانک پارسیان">
                                                <div class="input-field">
                                                    <p>شماره ترمینال</p>
                                                    <input type="text" required dir="ltr" name="optionJson_terminalNumber" value="<?php echo e($opt->terminalNumber); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>پین کد</p>
                                                    <input type="text" required dir="ltr" name="optionJson_pinCode" value="<?php echo e($opt->pinCode); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3 ">
                                        <div class="gateway ">
                                            <h6 class="black-text bold ">بانک صادرات</h6>
                                            <?php $opt = optionJsonValues('bank_saderat')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_saderat">
                                                <input type="hidden" name="optionJson_title" value="بانک صادرات">
                                                <div class="input-field">
                                                    <p>شماره ترمینال</p>
                                                    <input type="text" required dir="ltr" name="optionJson_terminalNumber" value="<?php echo e($opt->terminalNumber); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>

                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold ">بانک ملی</h6>
                                            <?php $opt = optionJsonValues('bank_melli')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_melli">
                                                <input type="hidden" name="optionJson_title" value="بانک ملی">
                                                <div class="input-field">
                                                    <p>شماره ترمینال</p>
                                                    <input type="text" required dir="ltr" name="optionJson_terminalNumber" value="<?php echo e($opt->terminalNumber); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>مرچنت ایدی</p>
                                                    <input type="text" required dir="ltr" name="optionJson_merchantId" value="<?php echo e($opt->merchantId); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>کلید</p>
                                                    <input type="text" required dir="ltr" name="optionJson_key" value="<?php echo e($opt->key); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>

                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold "> زرین پال </h6>
                                            <?php $opt = optionJsonValues('bank_zarinpal')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_zarinpal">
                                                <input type="hidden" name="optionJson_title" value="بانک زرین پال">
                                                <div class="input-field">
                                                    <p>مرچنت ایدی</p>
                                                    <input type="text" required dir="ltr" name="optionJson_merchantId" value="<?php echo e($opt->merchantId); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>

                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>

                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway">
                                            <h6 class="black-text bold "> نکست پی </h6>
                                            <?php $opt = optionJsonValues('bank_nextpay')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_nextpay">
                                                <input type="hidden" name="optionJson_title" value="بانک نکست پی">
                                                <div class="input-field">
                                                    <p>کلید مجوز دهی API_KEY</p>
                                                    <input type="text" required dir="ltr" name="optionJson_apikey" value="<?php echo e($opt->apikey); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold "> زیبال </h6>
                                            <?php $opt = optionJsonValues('bank_zibal')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_zibal">
                                                <input type="hidden" name="optionJson_title" value="بانک زیبال">
                                                <div class="input-field">
                                                    <p>مرچنت ایدی</p>
                                                    <input type="text" required dir="ltr" name="optionJson_merchantId" value="<?php echo e($opt->merchantId); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold "> ملت </h6>
                                            <?php $opt = optionJsonValues('bank_mellat')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_mellat">
                                                <input type="hidden" name="optionJson_title" value="بانک ملت">
                                                <div class="input-field">
                                                    <p>شماره پایانه</p>
                                                    <input type="text" required dir="ltr" name="optionJson_terminalId" value="<?php echo e($opt->terminalId); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>نام کاربری</p>
                                                    <input type="text" required dir="ltr" name="optionJson_userName" value="<?php echo e($opt->userName); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>رمز عبور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_userPassword" value="<?php echo e($opt->userPassword); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col s12 mb-3" >
                                        <div class="gateway ">
                                            <h6 class="black-text bold "> ایران کیش </h6>
                                            <?php $opt = optionJsonValues('bank_irankish')?>
                                            <form class="send-ajax" method="post" action="<?php echo e(url('/management/json-save')); ?>">
                                                <?php echo e(csrf_field()); ?>

                                                <input type="hidden" name="key" value="bank_irankish">
                                                <input type="hidden" name="optionJson_title" value="بانک ایران کیش">
                                                <div class="input-field">
                                                    <p>شماره پایانه</p>
                                                    <input type="text" required dir="ltr" name="optionJson_terminalID" value="<?php echo e($opt->terminalID); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>رمز عبور</p>
                                                    <input type="text" required dir="ltr" name="optionJson_password" value="<?php echo e($opt->password); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>کد پذیرنده</p>
                                                    <input type="text" required dir="ltr" name="optionJson_acceptorId" value="<?php echo e($opt->acceptorId); ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field">
                                                    <p>کلید اختصاصی</p>
                                                    <textarea class="browser-default w-100" rows="10" required dir="ltr" name="optionJson_pubKey" autocomplete="off"><?php echo e($opt->pubKey); ?></textarea>
                                                </div>
                                                <div class="input-field">
                                                    <p>ضریب مبلغ درگاه</p>
                                                    <input type="number" required dir="ltr" name="optionJson_factorAmount" value="<?php echo e($opt->factorAmount); ?>" autocomplete="off">
                                                    <span class="font-small">مثلا برای تبدیل تومان به ریال ضریب 10 نیاز است</span>
                                                </div>
                                                <div class="">
                                                    <label>
                                                        <input type="checkbox" class="filled-in" name="optionJson_active" value="true" <?php echo e($opt->active=="true"?'checked':''); ?>>
                                                        <span>نمایش درگاه</span>
                                                    </label>
                                                </div>
                                                <div class="right-align">
                                                    <button type="submit" class="btn green">ذخیره</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab5">
                            <div class="card-panel">
                                <h6 class="mb-5">پارامترهای فروشگاه</h6>
                                <form class="formValidate form-valid send-ajax" method="post" action="<?php echo e(url('/management/setting-update')); ?>" >
                                    <div class="row">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>حروف پیشوند شماره فاکتور</label>
                                                <input type="text" dir="ltr" class="text-center" name="optionKey_invoice_prefix" required value="<?php echo e(Option::find_key($option,'invoice_prefix')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        

                                        <div class="col s12">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">add_shopping_cart</i> قابلیت افزودن محصولات به سبد خرید از چند فروشگاه:</p>
                                                </div>
                                                <div class="col m4 s12 ">
                                                    <label>
                                                        <input name="optionKey_multiStore" value="enable" type="radio" <?php echo e(Option::find_key($option,'multiStore') == 'enable'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 ">
                                                    <label>
                                                        <input name="optionKey_multiStore" value="disable" type="radio" <?php echo e(Option::find_key($option,'multiStore') == 'disable'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col s6 mt-2">
                                            <div class="input-field">
                                                <label>واحد پول</label>
                                                <input type="text" name="optionKey_currency" value="<?php echo e(Option::find_key($option,'currency')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s6 mt-2">
                                            <div class="input-field">
                                                <label>درصد مالیات</label>
                                                <input type="number" step="0.01" name="optionKey_tax" value="<?php echo e(Option::find_key($option,'tax')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col s6 mt-2">
                                            <div class="input-field">
                                                <label>مدت زمان پرداخت فاکتور (به ساعت)</label>
                                                <input type="number" dir="ltr" step="1" name="optionKey_expire_invoice_payment" value="<?php echo e(Option::find_key($option,'expire_invoice_payment')); ?>" autocomplete="off" class="text-center">
                                            </div>
                                        </div>
                                        <div class="col s6 mt-2">
                                            <div class="input-field">
                                                <label>محدوده اخطار تعداد موجودی</label>
                                                <input type="number" dir="ltr" name="optionKey_count_limit" value="<?php echo e(Option::find_key($option,'count_limit')); ?>" autocomplete="off" class="text-center">
                                            </div>
                                        </div>
                                        <div class="col m12 s12 mb-3 pb-3 grey lighten-3">
                                            <div class="row ">
                                                <div class="col m12 s12"><p>نمایش محصول فروشندگان بر اساس پلن فروشندگان</p></div>
                                                <div class="col m4 s12 ">
                                                    <label>
                                                        <input name="optionKey_is_store_plan" value="yes" type="radio" <?php echo e(Option::find_key($option,'is_store_plan') == 'yes'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m4 s12 ">
                                                    <label>
                                                        <input name="optionKey_is_store_plan" value="no" type="radio" <?php echo e(Option::find_key($option,'is_store_plan') == 'no'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="<?php echo e(url('/management/dashboard')); ?>"> رفتن به داشبورد </a>
                                            <button type="submit" class="btn indigo waves-effect waves-light ml-2 iransans">
                                                ذخیره تغییرات
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tab6">
                            <div class="card-panel">
                                <h6 class="mb-5">موارد بیشتر</h6>
                                <form class="formValidate form-valid send-ajax" method="post" action="<?php echo e(url('/management/setting-update')); ?>" >
                                    <div class="row">
                                        <?php echo e(csrf_field()); ?>

                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>ورژن اپلیکیشن (در صورت وجود)</label>
                                                <input type="text" name="optionKey_app_version" required value="<?php echo e(Option::find_key($option,'app_version')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col m12 s12 grey lighten-3">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">refresh</i> نمایش پیش بارگذارنده:</p>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_pre_loading" value="enable" type="radio" <?php echo e(Option::find_key($option,'pre_loading') == 'enable'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_pre_loading" value="disable" type="radio" <?php echo e(Option::find_key($option,'pre_loading') == 'disable'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">art_track</i> نمایش مگامنوی محصولات:</p>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_product_mega_menu" value="enable" type="radio" <?php echo e(Option::find_key($option,'product_mega_menu') == 'enable'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_product_mega_menu" value="disable" type="radio" <?php echo e(Option::find_key($option,'product_mega_menu') == 'disable'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col m6 s12">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">subscriptions</i> نمایش منوی چند عمقی محصولات:</p>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_product_level_menu" value="enable" type="radio" <?php echo e(Option::find_key($option,'product_level_menu') == 'enable'?'checked':''); ?>>
                                                        <span>فعال</span>
                                                    </label>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_product_level_menu" value="disable" type="radio" <?php echo e(Option::find_key($option,'product_level_menu') == 'disable'?'checked':''); ?>>
                                                        <span>غیر فعال</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 grey lighten-3">
                                            <div class="input-field-">
                                                <p class="font-medium mb-0">مسیر اپ (pwa) در حالت موبایل</p>
                                                <input type="text" name="optionKey_mobile_app_url" required dir="ltr" class="fill" value="<?php echo e(Option::find_key($option,'mobile_app_url')); ?>" autocomplete="off" placeholder="مسیر پیشفرض حالت موبایل را وارد نمایید">
                                            </div>
                                        </div>
                                        <div class="col m12 s12">
                                            <div class="row mb-5">
                                                <div class="col m12 s12">
                                                    <p ><i class="material-icons left">keyboard_tab</i> میخواهید مشتری در حالت موبایل به مسیر پیش فرض هدایت شود:</p>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_redirect_to_mobile" value="yes" type="radio" <?php echo e(Option::find_key($option,'redirect_to_mobile') == 'yes'?'checked':''); ?>>
                                                        <span>بله</span>
                                                    </label>
                                                </div>
                                                <div class="col m6 s12 ">
                                                    <label>
                                                        <input name="optionKey_redirect_to_mobile" value="no" type="radio" <?php echo e(Option::find_key($option,'redirect_to_mobile') == 'no'?'checked':''); ?>>
                                                        <span>خیر</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12 grey lighten-3">
                                            <div class="input-field">
                                                <p class="">متن درباره ما <span class="orange-text font-small">(نمایش خلاصه اطلاعات مفید شما)</span></p>
                                                <textarea class="browser-default w-100" rows="10" name="optionKey_about"><?php echo e(Option::find_key($option,'about')); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col m12 s12 mt-3 mb-5 pb-3 pt-3 grey lighten-3">
                                            <h5>تنظیمات قوانین و حریم خصوصی</h5>
                                            <div class="row ">
                                                <div class="col m6 s12" id="ruleId">
                                                    <p>انتخاب متن قوانین</p>
                                                    <?php $e = \App\Models\Post::find(intval(Option::find_key($option,'privacy_policy'))) ?>
                                                    <select name="optionKey_privacy_policy" class="browser-default select2_ajax" data-url="../management/find-post" data-field-="rawId" data-parent="ruleId">
                                                        <?php if($e): ?>
                                                            <option value="<?php echo e($e->id); ?>" selected><?php echo e($e->title); ?></option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col m6 s12" id="privacy_id">
                                                    <p> انتخاب متن حریم خصوصی </p>
                                                    <?php $e = \App\Models\Post::find(intval(Option::find_key($option,'site_rule'))) ?>
                                                    <select name="optionKey_site_rule" class="browser-default select2_ajax" data-url="../management/find-post" data-field-="raw_id" data-parent="privacy_id">
                                                        <?php if($e): ?>
                                                            <option value="<?php echo e($e->id); ?>" selected><?php echo e($e->title); ?></option>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>



                                        <div class="col s12">
                                            <div class="input-field">
                                                <label>ریست داده های برنامه <span class="red-text font-small">(احتیاط)</span></label><br/>
                                                <button type="button" onclick="resetData()" class="btn red mt-1"> <i class="material-icons">delete_sweep</i>&nbsp; برای خالی کردن اطلاعات سامانه اینجا کلیک کنید &nbsp;</button>
                                            </div>
                                        </div>
                                        <div class="col s12">
                                            <hr/>
                                        </div>
                                        <div class="col s12 display-flex justify-content-end form-action">
                                            <a class="btn btn-light-pink iransans" href="<?php echo e(url('/management/dashboard')); ?>"> رفتن به داشبورد </a>
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

    <script>
        $('img#img1').on('load', function () {
            $("#i1").val($(this).attr('src'))
        });
        $('img#img2').on('load', function () {
            $("#i2").val($(this).attr('src'))
        });
        $('img#img3').on('load', function () {
            $("#i3").val($(this).attr('src'))
        });
        function getAddressList() {
            helper().get($baseurl+'/management/address-list/')
                .done(function (r) {
                    $("#tblListAddress").html(r.html);
                })
        }
        function deleteAddress($id){
            if(confirm('آیا مطمن هستید ؟')){
                helper().post($baseurl+'/management/address-delete',{id:$id})
                    .done(function (r) {
                        if(r.result){
                            after_done3()
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

    <script>
        function resetData() {
            swal({
                title:'احتیاط',
                text:'با این عملیات تمام اطلاعات جداول پایگاه داده خالی میشود لطفا قبل از اقدام یک بک اپ از جداول تهیه کنید',
                icon:'warning',
                buttons: {
                    cancel: 'منصرف شدم',
                    delete: 'ادامه میدهم'
                    }
                }).then(function (v) {
                if(v){
                    helper().post('./truncate-table',{}).done(function (r) {
                        if(r.result){
                            swal({
                                title:'انجام عملیات',
                                text:r.msg,
                                icon:'success'
                            })
                        }
                    })
                }
            })
        }
    </script>

    <script>
        $("input[name='smsPanelDefault']").on('click',function () {
            $("input[name='smsPanelDefault']").prop('checked',false);
            $(this).prop('checked',true);
        })
    </script>

    <!---فایل منیجر--->
    
<?php $__env->stopSection(); ?>


<?php echo $__env->make('back-end.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/back-end/setting.blade.php ENDPATH**/ ?>