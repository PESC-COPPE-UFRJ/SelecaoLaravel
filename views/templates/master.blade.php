<!doctype html>

<!--[if gt IE 8]><!-->
<html class="no-js"> 
<!--<![endif]-->

    <head>        
        
        @include('common.head')
        
    </head>

    <body data-ng-app="app" id="app" data-custom-background="" data-off-canvas-nav="" ng-cloak class="ng-cloak">

             

                <section id="header" class="top-header">

                    @include('common.header')

                </section>


                <aside id="nav-container">

                    @include('common.menu')

                </aside>

                <div class="view-container">

                    <section id="content" class="animate-fade-up">

                        <div class="page">

                            @section('content')

                            @show

                        </div>

                    </section>

                </div>


                @include('common.postscripts')

                @yield('postscripts')


    </body>

</html>