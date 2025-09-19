<li class="dropdown text-normal nav-profile">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
        <img src="{{Auth::user()->foto}}" alt="" class="img-circle img30_30">
        <span class="hidden-xs">
            <span data-i18n="{{Auth::user()->nome}}"></span>
        </span>
    </a>
    <ul class="dropdown-menu with-arrow pull-right">
        <li>
            <a href="user/profile">
                <i class="fa fa-user"></i>
                <span data-i18n="Meu Perfil"></span>
            </a>
        </li>
        <!-- <li>
            <a href="#/tasks">
                <i class="fa fa-check"></i>
                <span data-i18n="My Tasks"></span>
            </a>
        </li> -->
        <li>
            <a href="{{URL::to('user/lock')}}">
                <i class="fa fa-lock"></i>
                <span data-i18n="Trancar"></span>
            </a>
        </li>
        <li>
            <a href="{{URL::to('id/sign-out')}}">
                <i class="fa fa-sign-out"></i>
                <span data-i18n="Log Out"></span>
            </a>
        </li>
    </ul>
</li>