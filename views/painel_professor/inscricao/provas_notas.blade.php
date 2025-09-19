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

            $('#tipo_prova').change(function(){
                if($(this).val() != '') {
                    $.get( $(this).val(), function( data ) {
                      $( "#capas" ).html( data );
                    });
                } else {
                    alert('Selecione um valor na lista!');
                }
            });

            $('#generateIdentifier').click(function() {
                var retorno = false;
                var situation = $("#status_id").val();
                var tipo = $("#curso").val();
                var txtSituation = ''
                if(situation == null){
                    alert('Selecione, pelo menos, uma situação!');
                    // return false;
                    return retorno;
                }
                $.each( situation, function( key, value ) {
                    txtSituation += '&situacao[]='+value;
                });
                console.log('professor/inscricao/check-identficador?tipo='+tipo+txtSituation);
                $.get( 'professor/inscricao/check-identficador?tipo='+tipo+txtSituation, function( data ) {
                    if(data == 1) {
                        var r = confirm("Já existe identificadores para esta situação, deseja criar novos identificadores?");
                        console.log(r);
                        if (r == true) {
                            $("#formId").submit();
                        }
                    } else {
                        $("#formId").submit();
                    }
                })
                return retorno;
            });
        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = Input::get('tipo')==''?'m':Input::get('tipo'); ?}

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
                            <form class="form-horizontal ng-pristine ng-valid" id="formId" role="form" method="post" action="professor/inscricao/identificador">
                            <div class="row">
                                <div class="col-sm-6 col-centered">
                                    
                                    {? $formIdentificador->render('status.status_id') ?}

                                    <label>Situação</label>
                                    <select class="form-control" id="status_id" name="status_id[]" multiple>
                                        @if(count($status) > 0)
                                            @foreach($status as $statusSituation)
                                                <option value="{{ $statusSituation->id }}">{{ $statusSituation->descricao }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <input type="hidden" name="tipo" id="curso" value="{{ $tipo }}">

                                    <br/>

                                    <button type="submit" id="generateIdentifier">Gerar Identificador</button>
                                    @if(Input::has('success'))
                                        <div><h4 class="text-success">Identificadores gerados!</h4></div>
                                    @endif
                                    
                                </div>
                            </div>
                            </form>
                        </tab>
                        

                        
                        <tab heading="Capas de provas">
                            <!-- <form class="form-horizontal ng-pristine ng-valid" role="form" method="post" action="professor/inscricao/identificador"> -->
                            <div class="row">

                                <div class="col-sm-6 col-centered">

                                    <label for="tipo_prova">Selecione o tipo de prova</label><br/>

                                    <select name="tipo_prova" id="tipo_prova">

                                        <option value="">Selecione</option>
                                        @foreach($linhas as $linha)
                                            <optgroup label="{{ $linha->nome }}">
                                                <option value="professor/inscricao/capas?linha={{ $linha->id }}&capa=1&curso={{ $tipo }}">{{ $linha->sigla }} Normal</option>
                                                <option value="professor/inscricao/capas?linha={{ $linha->id }}&capa=2&curso={{ $tipo }}">{{ $linha->sigla }} Livreto</option>
                                            </optgroup>
                                        @endforeach

                                    </select>

                                </div>

                            </div>
                            <br/>
                            <div class="row" id="capas">

                            </div>
                            <!-- </form> -->
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