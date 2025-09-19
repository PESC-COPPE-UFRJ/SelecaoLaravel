@extends('templates.master')
@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
    <link rel="stylesheet" href="styles/datepicker3.css">
@stop
@section('scripts')
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
@stop
@section('content')


@include('elements.alerts')

<!-- if there are creation errors, they will show here -->
@if(isset($errors) && !empty($errors->all()))
<div class="alert alert-danger">
    <a class="close" data-dismiss="alert">×</a>
    <h4 class="alert-heading"> Os seguintes erros foram encontrados: </h4>
    {{ HTML::ul($errors->all()) }}
</div>
@endif



<div class="page ng-scope">

<form id="frmDadosPessoais"
      class="form-horizontal ng-pristine ng-valid"
      role="form"
      method="POST"
      action="professor/dados-pessoais"
      enctype="multipart/form-data">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Pessoais</strong></div>

        <div class="panel-body">

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Principal</a></li>

                </ul>

            </div>

            <div class="content clearfix">

                <h1 id="step0_h1" tabindex="-1" class="title current">1. Principal</h1>

                <div id="step0" class="current" style="display: block;">

                    <section class="panel panel-default">

                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Iniciais</strong></div>-->

                        <div class="panel-body">

                            <div class="row clearfix">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="nome_completo" class="col-sm-2">Nome Completo *</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nome_completo" id="nome_completo" class="form-control" value="{{ $user->nome or '' }}" required>

                                        </div>

                                    </div>

                                    <div id="email">

                                        <div class="form-group">

                                            <label for="email" class="col-sm-2">Email *</label>

                                            <div class="col-sm-10">

                                                <input type="email" name="email" id="email" class="form-control" value="{{ $user->email or '' }}" required>

                                            </div>

                                        </div>

                                    </div>


                                </div>

                            </div>


                        </div>

                    </section>

                </div>

            <div class="actions clearfix">
                <ul role="menu">
                    <li id="nav_finish"><button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i></button></li>
                </ul>
            </div>

            </div>



        </div>

    </section>



</form>

</div>


@stop