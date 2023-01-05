<!-- BEGIN: Header-->
<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed" id="app-header">
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
            <div class="nav-wrapper">
                <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
                    <input class="header-search-input z-depth-2 iransans" type="text"  placeholder="جست و جو در منوی اصلی ..." autocomplete="off" data-search="template-list" onkeyup="search_menu(this.value)">
                    <ul class="search-list collection display-none"></ul>
                    <div class="w-100">
                        <ul id="result_search_menu" style="display: none">
                        </ul>
                    </div>
                </div>
                <ul class="navbar-list right">
                    <!--language-->
                    <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                    <!--Notify--><?php if($options['notify'] == 'enable'): ?><li><a class="waves-effect waves-block waves-light sidenav-trigger" href="<?php echo e(url('/management/notify-list')); ?>" ><i class="material-icons" id="notify-counter-i">notifications_none<small id="notify-counter-n" class="notification-badge grey">0</small></i></a></li><?php endif; ?>
                    <!--avatar--><li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img onerror="this.src='<?php echo e(_noImage('avatar.png')); ?>'" src="<?php echo e(_slash('uploads/avatar/'.$auth->user_avatar)); ?>" alt="<?php echo e($auth->user_nickname); ?>" style="box-shadow: 0 0 3px 3px rgba(255, 255, 255 , 0.37);"><i></i></span></a></li>
                    <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#" data-target="theme-cutomizer-out"><i class="material-icons">brush</i></a></li>
                    <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#" onclick="helper().logout()"><i class="material-icons">settings_power</i></a></li>
                    <!--leftSidebar-->
                </ul>

                <!-- translation-button-->
                <ul class="dropdown-content" id="translation-dropdown">
                    <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="en"><i class="flag-icon flag-icon-ir"></i> فارسی</a></li>
                    <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="en"><i class="flag-icon flag-icon-gb"></i> انگلیسی</a></li>
                    <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="fr"><i class="flag-icon flag-icon-fr"></i> فرانسوی</a></li>
                    <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="pt"><i class="flag-icon flag-icon-pt"></i> پرتغالی</a></li>
                    <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="de"><i class="flag-icon flag-icon-de"></i> آلمانی</a></li>
                </ul>

                <!-- notifications-dropdown-->
                <ul class="dropdown-content" id="notifications-dropdown">
                    <li>
                        <h6>اطلاعیه<span class="new badge">5</span></h6>
                    </li>
                    <li class="divider"></li>
                    <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span>سفارش جدیدی گذاشته شده است!</a>
                        <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 ساعت گذشته</time>
                    </li>
                    <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> کار را تمام کرد</a>
                        <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 روز گذشته</time>
                    </li>
                    <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle teal small">settings</span> تنظیمات به روز شد</a>
                        <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 روز گذشته</time>
                    </li>
                    <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle deep-orange small">today</span>جلسه مدیر شروع شد</a>
                        <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 روز گذشته</time>
                    </li>
                    <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle amber small">trending_up</span>گزارش ماهانه تهیه کنید</a>
                        <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 هفته پیش</time>
                    </li>
                    <li>
                        <a class="blue-text center-align" href="<?php echo e(url('/management/notify-list')); ?>"><span class="material-icons   ">notifications_active</span>نمایش همه</a>
                    </li>
                </ul>

                <!-- profile-dropdown پروفایل -->
                <ul class="dropdown-content" id="profile-dropdown">
                    <li><a class="grey-text text-darken-1 font-medium" href="<?php echo e(url('/management/profile')); ?>"><i class="material-icons">person_outline</i> مشخصات</a></li>
                    <li><a class="grey-text text-darken-1 font-medium" href="<?php echo e(url('/management/comment-list?user_id='.$auth->user_id)); ?>"><i class="material-icons">chat_bubble_outline</i>  دیدگاه من</a></li>
                    <li><a class="grey-text text-darken-1 font-medium" href="<?php echo e(url('/management/access-denied')); ?>"><i class="material-icons">help_outline</i> راهنمایی</a></li>
                    <li class="divider"></li>
                    <li><a class="grey-text text-darken-1 font-medium" href="javascript:;" onclick="helper().logout()"><i class="material-icons">lock_outline</i> خروج</a></li>
                </ul>
            </div>
        </nav>
     </div>
</header>
<!-- END: Header-->

<?php /**PATH D:\wamp64\www\mis_maleki\application\resources\views/back-end/layout/header.blade.php ENDPATH**/ ?>