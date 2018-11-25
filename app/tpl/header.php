<header class="main">
    <a href="javascript:;" data-menu-status="= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'true' : 'false' ?>" class="menu_switch = (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'opened no_animation' : '' ?>"><i class="fa fa-bars"></i></a>
    <h1>Dashboard</h1>
    <div class="user_menu_container">
        <a href="javascript:;" class="language_switch user">
            <span>Hello Youssef</span>
            <i class="material-icons">Key</i>
        </a>
        <ul class="user_menu">
            <li><a href="/"><i class="fa fa-user"></i>= profile ?></a></li>
            <li><a href="/"><i class="fa fa-key"></i>= change_password ?></a></li>
            <li><a href="/"><i class="fa fa-gear"></i>= account_settings ?></a></li>
            <li><a href="/auth/logout"><i class="fa fa-sign-out"></i>= log_out ?></a></li>
        </ul>
    </div>
    <a href="/messages" class="language_switch"><i class="fa fa-envelope"></i></a>
    <a href="javascript:;" class="language_switch notifications"><i class="fa fa-bell"></i></a>
    <a href="/language" class="language_switch"><span>En</span> <i class="fa fa-globe"></i></a>
</header>