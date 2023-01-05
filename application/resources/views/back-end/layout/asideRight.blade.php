<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="{{url('management/profile')}}">
                <img class="hide-on-med-and-down" src="{{$dotSlashes}}back/app-assets/images/logo/materialize-logo-color.png" alt="materialize logo" style="visibility: hidden" />
                <img class="show-on-medium-and-down hide-on-med-and-up" src="{{$dotSlashes}}back/app-assets/images/logo/materialize-logo.png" alt="materialize logo" />
                <span class="logo-text hide-on-med-and-down">{{$auth->user_role}}</span></a>
            <a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a>
        </h1>

        <div class="asid-profile">
            <img onerror="this.src='{{_slash('back/custom/img/avatar.png')}}'" src="{{_slash('uploads/avatar/'.$auth->user_avatar)}}" >
            <h6 class="truncate">{{$auth->user_nickname}}</h6>
            <h6 class="truncate">{{$auth->user_mobile}}</h6>
            <div class="right-align mt-3">
                <a href="{{url('management/profile')}}"><i class="material-icons">perm_contact_calendar</i></a>
            </div>
        </div>
    </div>

    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        {!! \App\Helper\AccessController::create_menu() !!}
        {{--<li class="navigation-header">
            <a class="navigation-header-text">جدا کننده</a>
            <i class="navigation-header-icon material-icons">more_horiz</i>
        </li>--}}
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
