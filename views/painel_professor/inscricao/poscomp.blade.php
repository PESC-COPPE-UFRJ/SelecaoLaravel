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

@include('elements.alerts')

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> POSCOMP</strong></div>

        <div class="panel-body">        

            <div class="row">
                <div class="col-sm-6">
                    
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">

                <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="post" action="professor/inscricao/poscomp" enctype="multipart/form-data">

                    <input type="hidden" name="tipo" value="{{ Input::get('tipo') }}">

                    <div class="form-group">
                        <div class="row">
                        <label for="nome_pai" class="col-sm-2">Importar dados</label>

                            <div class="col-sm-10">

                                <input type="file" name="poscomp" id="poscomp">

                            </div>
                        </div>
                        <div class="row">
                            <label for="nome_pai" class="col-sm-2">Ano</label>
                            <div class="col-sm-10">
                                <input type="text" name="poscomp_year" id="poscomp_year" required maxlength="4" size="5" >

                            </div>
                        </div>
                    </div>

                    <button type="submit" id="salvar" class="btn btn-primary pull-right">Carregar</button>

                </form>
                
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                @if(isset($filterPoscomp))
                    {{ $filterPoscomp }}
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                @if(isset($gridPoscomp))
                    {{ $gridPoscomp }}
                @endif
            </div>
        </div>

    </section>

</div>
@stop