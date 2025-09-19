<section id="header" class="top-header">

    <header class="clearfix">
        <a href="#/" data-toggle-min-nav
                     class="toggle-min">
                     <i class="fa fa-bars"></i></a>

        <!-- Logo -->
        <div class="logo">
            <a href="#/">
                <span><img src="images/logo.png" alt="UFRJ" style="width:130px;" /></span>
            </a>
        </div>

        <!-- needs to be put after logo to make it working-->
        <div class="menu-button" toggle-off-canvas>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>

        <div class="top-nav">
            <ul class="nav-left list-unstyled">
                <li class="pull-right">
                    <h4 id="title_text"></h4>
                </li>
            </ul>

            <ul class="nav-right pull-right list-unstyled">
                <li class="dropdown text-normal nav-profile">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        {? $foto = Auth::user()->foto != '' ? Auth::user()->foto : 'images/assets/no-photo.png'; ?}
                        <img src="{{ $foto }}" alt="" class="img-circle img30_30">
                        <span class="hidden-xs">
                            <span data-i18n="{{ Auth::user()->nome }}"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu with-arrow pull-right">
                        <li>
                            <a href="{{URL::to('id/perfil')}}">
                                <i class="fa fa-sign-out"></i>
                                <span data-i18n="Alterar Perfil de sistema"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('candidato/meusdados/dados-pessoais')}}">
                                <i class="fa fa-user"></i>
                                <span data-i18n="Dados Pessoais"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{URL::to('id/password')}}">
                                <i class="fa fa-sign-out"></i>
                                <span data-i18n="Alterar sua senha de acesso"></span>
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
            </ul>
        </div>

    </header>
</section>