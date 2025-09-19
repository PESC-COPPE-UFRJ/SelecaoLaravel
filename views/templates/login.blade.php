<!doctype html>

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

    <head>

        <base href="{{ Config::get('base.url') }}"/>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>UFRJ</title>

        <meta name="description" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">

        <!-- needs images, font... therefore can not be part of ui.css -->

        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css">

        <!-- end needs images -->

        <link rel="stylesheet" href="styles/ui.css"/>


        <link rel="stylesheet" href="styles/main.css">


        <link rel="stylesheet" href="styles/softbrazil.css">

        <!--<link rel="stylesheet" href="styles/datepicker.css">-->
        <link rel="stylesheet"  href="styles/jquery-ui.css" type="text/css"/>
        <style type="text/css">
        html
        {
            overflow: auto;
        }
        </style>
        <style type="text/css">

        html
        {
            overflow: auto;
        }

        </style>

        @section('css')

        @show

        @include('common.postscripts')

        <script type="text/javascript" src="scripts/jquery.min.js"></script>

        <script type="text/javascript" src="scripts/maskedinput.min.js"></script>

        @section('scripts')

        @show

    </head>

    <body data-ng-app="app" id="app" data-custom-background="" data-off-canvas-nav="">


        <!--[if lt IE 9]>

            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>

        <![endif]-->

        @include('header.header_external')

        @section('content')

        @show

        <script src="scripts/vendor.js"></script>

        <script src="scripts/ui.js"></script>

        <script src="scripts/app.js"></script>

    </body>



</html>
