@extends('templates.master')
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('.op').click(function(){
            if($(this).val() == 'cpf') {
                $("#p_chave").mask("999.999.999-99");
            } else {
                $("#p_chave").unmask();
            }
        });
    });
</script>
@stop
@section('content')

<div class="page page-table">
	
    <div class="row">
    	<!--
        <div class="col-sm-6"> <a href="{{URL::to("person/create")}}"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Nova Pessoa Física</button></a> </div>
		-->

        <div class="col-sm-6 pull-right">

            <form action="{{ URL::to('pesquisar') }}" method="GET">
                <div class="input-group" style="width: 60%;">
                    <input type="text" class="form-control" name="p_chave" id="p_chave">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="sbumit">Pesquisar</button>
                    </span>
                </div>
                <!--
                <br/>
                <label class="ui-radio"><input name="radioOption" type="radio" class="op" value="nome" checked="checked"><span>Nome</span></label>                
                <label class="ui-radio"><input name="radioOption" type="radio" class="op" value="matricula"><span>Matrícula</span></label>
                <label class="ui-radio"><input name="radioOption" type="radio" class="op" value="cpf"><span>CPF</span></label>
                <label class="ui-radio"><input name="radioOption" type="radio" class="op" value="identidade"><span>Identidade</span></label>            
                -->
            </form>

        </div>
    </div>    
    <p>&nbsp;</p>
    <div class="panel panel-default">

        <div class="panel-heading">

            <strong>

                <span class="glyphicon glyphicon-th"></span> 

                Candidatos              

            </strong>

            <span style="margin:0 10%;">Total de registros: {{ $total_candidatos }}</span>

            <div class="pull-right">
            	Prova de conceito importação de dados
            </div>

        </div>

        @include('elements.alerts')

		<!-- Tab -->

		<section class="panel panel-default">

		    <!--<div class="panel-heading"><span class="glyphicon glyphicon-th"></span> Tabs</div>-->

		    <div class="panel-body" data-ng-controller="TabsDemoCtrl">

		        <div class="row">
		            <div class="col-sm-12">
		                <!--<h3>Simple Tabs</h3>-->
		                <div class="divider"></div>
		                <tabset class="ui-tab">
		                    <tab heading="Mestrado">
		                    	<?php
		                    		$ordem = Input::get('ordem');
		                    		if($ordem == 'ASC') {
		                    			$ordem = 'DESC';
		                    			$icone = '';
		                    		}else {
		                    			$ordem = 'ASC';
		                    			$icone = '';
		                    		}
		                    	?>
						        <table class="responsive table table-striped table-hover">

						            <thead>

						                <tr>

						                    <th>
							                    <a href="{{URL::to('classificar?classificacao=nome&ordem='.$ordem)}}">
							                    	Nome
							                    </a>
						                    </th>

						                    <th>
						                    	<a href="{{URL::to('classificar?classificacao=anoprocesso&ordem='.$ordem)}}">
						                    		Ano
						                    	</a>/
						                    	<a href="{{URL::to('classificar?classificacao=periodoprocesso&ordem='.$ordem)}}">
						                    		Período
						                    	</a>						                    	
						                    </th>

						                    <th>
						                    	<!--<a href="{{URL::to('classificar?classificacao=situacao')}}">-->
						                    		Situação
						                    	<!--</a>-->
						                    </th>

						                    <th>
						                    	<a href="{{URL::to('classificar?classificacao=curso&ordem='.$ordem)}}">
						                    		Curso
						                    	</a>
						                    </th>

						                    <th>
						                    	<!--<a href="{{URL::to('classificar?classificacao=linha')}}">-->
						                    		Linha
						                    	<!--</a>-->
						                    </th>

						                    <th>
						                    	<a href="{{URL::to('classificar?classificacao=regime&ordem='.$ordem)}}">
						                    		Regime
						                    	</a>
						                    </th>

						                    <th>
						                    	<a href="{{URL::to('classificar?classificacao=bolsa&ordem='.$ordem)}}">
						                    		Bolsa
						                    	</a>
						                    </th>

						                </tr>

						            </thead>

						            <tbody>

						            @if(isset($candidatos) && $candidatos->count() > 0)

						                @foreach ($candidatos as $candidato)

						                <?php
						                	/*
						                	switch($candidato->situacao)
						                	{
						                		case 1: $situacao = 'Em edição';$situacao_class = 'label-warning';break;
						                		case 2: $situacao = 'Fechado';$situacao_class = 'label-success';break;
						                		case 3: $situacao = 'Rejeitado';$situacao_class = 'label-danger';break;
						                		default: $situcao = 'Em edição';$situacao_class = 'label-warning';break;
						                	}

						                    if ($situacao == 0) {
						                        $class = "background-color: #eaeaea;";
						                    } else {
						                        $class = "";
						                    }
											*/
						                ?>

						                <tr>

						                    <td>
							                    <a href="{{URL::to('candidato/dadospessoais/' . $candidato->id . '/edit')}}">
							                    	{{ $candidato->nome }} {{--$candidato->sobrenome--}}
							                    </a>
						                    </td>

						                    <td>{{ $candidato->anoprocesso}}/{{$candidato->periodoprocesso }}</td>

						                    <td>
						                    <!--
						                    -
						                    <span class="label {{--$situacao_class--}}">{{--$situacao--}}</span>
						                    -->
						                    <span class="label label-warning">Em edição</span>
						                    </td>

						                    <td>{{ $candidato->curso }}</td>

						                    <td>-</td>

						                    <td>{{ $candidato->regime }}</td>

						                    <td>{{ $candidato->bolsa }}</td>                    

						                    <!--
						                    <td>

						                        <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></button></a>

						                        <a href="#"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></button></a>

						                    </td>
						                    -->

						                </tr>

						                @endforeach

						            @else

						            <tr>

						                <td> Nenhum registro encontrado. </td>

						            </tr>

						            @endif

						            </tbody>

						        </table>

						        @if (isset($candidatos))
						            {{ $candidatos->links() }}
						        @endif		                    
		                    </tab>
		                </tabset>

		            </div>

		        </div>

		    </div>
		</section>
		<!-- end Tab -->        

    </div>

</div>

@stop
