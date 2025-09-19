        {{--Config::get('template.url')--}}

        <base href="{{Config::get('base.url')}}"/>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>UFRJ</title>

        <meta name="description" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic" rel="stylesheet" type="text/css">

        <!-- needs images, font... therefore can not be part of ui.css -->

        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css">

        <!-- end needs images -->

        <link rel="stylesheet" href="styles/ui.css"/>


        <link rel="stylesheet" href="styles/main.css">


        <link rel="stylesheet" href="styles/softbrazil.css">

        <link rel='stylesheet' href='styles/loading-bar.min.css' type='text/css' media='all' />

        <!--<link rel="stylesheet" href="styles/datepicker.css">-->
        <link rel="stylesheet"  href="styles/jquery-ui.css" type="text/css"/>

        <script type="text/javascript" src="scripts/vendor.js"></script>

        <script type="text/javascript" src="scripts/jquery.min.js"></script>

        <script type="text/javascript" src="scripts/jquery.form.min.js"></script>

        <script type="text/javascript" src="scripts/maskedinput.min.js"></script>

        <script type="text/javascript" src="scripts/bootstrap.min.js"></script>

        <script type='text/javascript' src='scripts/loading-bar.min.js'></script>
        
        <script type="text/javascript" src="scripts/ui.js"></script>

        <script type="text/javascript" src="scripts/app.js"></script>

        @section('css')

        @show       

        {{ Rapyd::head() }}

        @section('scripts')

        @show
