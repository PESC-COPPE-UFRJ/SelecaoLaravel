<div id="nav-wrapper">

    <ul id="nav"

        data-ng-controller="NavCtrl"

        data-collapse-nav

        data-slim-scroll

        data-highlight-active>

        <li><a href="{{ URL::to('panel') }}"> <i class="fa fa-bar-chart-o"><span class="icon-bg bg-danger"></span></i><span data-i18n="Painel"></span> </a></li>

        {{--@if (Session::has('menus'))--}}

            {{--@foreach (Session::get('menus') as $menu)--}}

                <li><a href="##"> <i class="fa fa-user {{--$menu['icon']--}}"><span class="icon-bg bg-orange"></span></i><span data-i18n="Meus dados{{--$menu['name']--}}"></span> </a>

                    {{--@if (isset($menu['submenus']) && !empty($menu['submenus']))--}}

                        <ul>

                        {{--@foreach ($menu['submenus'] as $submenu)--}}

                            <!-- <li><a href="{{ URL::to('candidato/dadospessoais/create') }}"><i class="fa fa-caret-right"></i><span data-i18n="Dados Pessoais Incluir"></span></a></li> -->

                            <!-- {{--URL::to($submenu['url'])--}} -->

                            <li><a href="{{ URL::to('candidato/meusdados/dados-pessoais') }}"><i class="fa fa-caret-right"></i><span data-i18n="Dados pessoais{{--($submenu['name'])--}}"></span></a></li>

                            <li><a href="{{ URL::to('candidato/meusdados/formacao') }}"><i class="fa fa-caret-right"></i><span data-i18n="Formação superior"></span></a></li>

                            <li><a href="{{ URL::to('candidato/meusdados/experiencia') }}"><i class="fa fa-caret-right"></i><span data-i18n="Experiência profissional"></span></a></li>

                            <li><a href="{{ URL::to('candidato/meusdados/docencia') }}"><i class="fa fa-caret-right"></i><span data-i18n="Docência"></span></a></li>

                            <li><a href="{{ URL::to('candidato/meusdados/outras-infos') }}"><i class="fa fa-caret-right"></i><span data-i18n="Outras Informações"></span></a></li>

                        {{--@endforeach--}}

                        </ul>

                    {{--@endif--}}

                </li>

            {{--@endforeach--}}

        {{--@endif--}}

        <li><a href="{{ URL::to('panel') }}"> <i class="fa fa-folder"><span class="icon-bg bg-danger"></span></i><span data-i18n="Documentação"></span> </a>

            <ul>
                <li> <a href="{{ URL::to('candidato/documentacao/') }}"><i class="fa fa-caret-right"></i><span data-i18n="Enviar documentos"></span></a> </li>
            </ul>

        </li>

        <li><a href="{{ URL::to('panel') }}"> <i class="fa fa-graduation-cap"><span class="icon-bg bg-danger"></span></i><span data-i18n="Mestrado"></span> </a>

            <ul>
                <li> <a href="{{ URL::to('candidato/inscricao/candidatarse?tipo=m') }}"><i class="fa fa-caret-right"></i><span data-i18n="Candidatar-se"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/dados-preenchidos?tipo=m') }}"><i class="fa fa-caret-right"></i><span data-i18n="Dados preenchidos"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/status-candidatura?tipo=m') }}"><i class="fa fa-caret-right"></i><span data-i18n="Status de candidatura"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/imprimir?tipo=m') }}"><i class="fa fa-caret-right"></i><span data-i18n="Imprimir"></span></a> </li>
            </ul>

        </li>

        <li><a href="{{ URL::to('panel') }}"> <i class="fa fa-university"><span class="icon-bg bg-danger"></span></i><span data-i18n="Doutorado"></span> </a>

            <ul>
                <li> <a href="{{ URL::to('candidato/inscricao/candidatarse?tipo=d') }}"><i class="fa fa-caret-right"></i><span data-i18n="Candidatar-se"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/dados-preenchidos?tipo=d') }}"><i class="fa fa-caret-right"></i><span data-i18n="Dados preenchidos"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/status-candidatura?tipo=d') }}"><i class="fa fa-caret-right"></i><span data-i18n="Status de candidatura"></span></a> </li>

                <li> <a href="{{ URL::to('candidato/inscricao/imprimir?tipo=d') }}"><i class="fa fa-caret-right"></i><span data-i18n="Imprimir"></span></a> </li>
            </ul>

        </li>

        <li><a href="{{ URL::to('panel') }}"> <i class="fa fa-question-circle"><span class="icon-bg bg-danger"></span></i><span data-i18n="FAQ"></span> </a>
            <?php
                $collection = Categoria::with('faqs')->get();

                $categorias = $collection->filter(function($categoria)
                {
                    if ($categoria->faqs->count() > 0) {
                        return true;
                    }
                });
            ?>
            <ul>
                @foreach($categorias as $categoria)
                    <li> <a href="candidato/faqs?id={{ $categoria->id }}"><i class="fa fa-caret-right"></i><span data-i18n="{{ $categoria->nome }}"></span></a> </li>
                @endforeach
            </ul>

        </li>

    </ul>

</div>