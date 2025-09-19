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

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Provas e Notas</strong></div>

        <div class="panel-body" data-ng-controller="TabsDemoCtrl">        

            <div class="row">
                <div class="col-sm-8 col-centered">
                   <!-- Tab -->
                    <tabset class="ui-tab">

                        <tab heading="Identificador de prova">
                            
                            <div class="row">
                                <div class="col-sm-6 col-centered">
                                    <label for="identificador">Selecione o estado do candidato</label><br/>
                                    <select name="estados">
                                        <option value="">Selecione</option>                                
                                    </select><br/>

                                    <button type="button">Gerar Identificador</button>
                                </div>
                            </div>

                        </tab>

                        <tab heading="Capas de provas">

                            <div class="row">
                                <div class="col-sm-6 col-centered">
                                    <label for="identificador">Selecione o tipo de prova</label><br/>
                                    <select name="identificador">
                                        <option value="">Selecione</option>
                                        <option value="">Línguas</option>
                                        <option value="">Banco de Dados</option>
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </div>

                        </tab>

                        <tab heading="Notas de candidatos">

                            {{ $filterNotas }}

                            {{ $gridNotas }}

                            editando a nota de fulano

                            prova de inglês <input><br/>
                            <button type="button">salvar</button>


                        </tab>

                    </tabset>
                    <!-- end Tab -->
                </div>
            </div>
        </div>

    </section>

<!-- </form> -->

</div>
@stop