<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="<?php echo e(url('management/profile')); ?>">
                <img class="hide-on-med-and-down" src="<?php echo e($dotSlashes); ?>back/app-assets/images/logo/materialize-logo-color.png" alt="materialize logo" style="visibility: hidden" />
                <img class="show-on-medium-and-down hide-on-med-and-up" src="<?php echo e($dotSlashes); ?>back/app-assets/images/logo/materialize-logo.png" alt="materialize logo" />
                <span class="logo-text hide-on-med-and-down"><?php echo e($auth->user_role); ?></span></a>
            <a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a>
        </h1>

        <div class="asid-profile">
            <img onerror="this.src='<?php echo e(_slash('back/custom/img/avatar.png')); ?>'" src="<?php echo e(_slash('uploads/avatar/'.$auth->user_avatar)); ?>" >
            <h6 class="truncate"><?php echo e($auth->user_nickname); ?></h6>
            <h6 class="truncate"><?php echo e($auth->user_mobile); ?></h6>
            <div class="right-align mt-3">
                <a href="<?php echo e(url('management/profile')); ?>"><i class="material-icons">perm_contact_calendar</i></a>
            </div>
        </div>
    </div>

    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <?php echo \App\Helper\AccessController::create_menu(); ?>

        
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<?php /**PATH C:\wamp64\www\mis_maleki\application\resources\views/back-end/layout/asideRight.blade.php ENDPATH**/ ?>