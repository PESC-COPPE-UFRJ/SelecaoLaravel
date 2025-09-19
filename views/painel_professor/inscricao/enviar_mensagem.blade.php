@extends('templates.master')

@section('css')
    <style type="text/css">

        .row-centered{
            text-align: center;
        }

        .col-centered {
            float:none;
            margin: 0 auto;
        }

    </style>
@stop

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function()
        {


        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Enviar Mensagem</strong></div>

        <div class="panel-body">        

            <div class="row">
                <div class="col-sm-6">
                    {{ $formMensagem }}
                </div>
            </div>

        </div>

    </section>

<!-- </form> -->

</div>
@stop