<div id="nav-wrapper">

    <ul id="nav"

        data-ng-controller="NavCtrl"

        data-collapse-nav

        data-slim-scroll

        data-highlight-active>

        <li><a href="panel"> <i class="fa fa-dashboard"><span class="icon-bg bg-danger"></span></i><span data-i18n="Painel"></span> </a></li>

        @if (Session::has('menus'))

            @foreach (Session::get('menus') as $menu)

                <li><a href="##"> <i class="fa {{$menu['icon']}}"><span class="icon-bg bg-danger"></span></i><span data-i18n="{{$menu['nome']}}"></span></a>

                    @if (isset($menu['subs']) && !empty($menu['subs']))

                        <ul>

                        @foreach ($menu['subs'] as $submenu)

                            <li><a href="{{URL::to($submenu['caminho'])}}"><i class="fa fa-caret-right"></i><span data-i18n="{{($submenu['nome'])}}"></span></a></li>

                        @endforeach

                        </ul>

                    @endif

                </li>

            @endforeach

        @endif

    </ul>

</div>