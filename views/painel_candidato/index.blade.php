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

{? $foto = Auth::user()->foto != '' ? Auth::user()->foto : 'images/assets/no-photo.png'; ?}
{? $itensIncompletos = 0; ?}
<div class="page page-table">

	<div class="row">

		<div class="col-sm-12">

		</div>

	</div>

	<div class="row">
		<div class="col-sm-9">
            <!-- Pofile panel -->
            <div class="panel panel-profile">
                <div class="panel-heading bg-primary clearfix">
                    <a href="" class="pull-left profile">
                        <img alt="" src="{{ $foto }}" class="img-circle img80_80">
                    </a>
                    <h3 style="text-transform: capitalize !important;">{{ Auth::user()->nome }}</h3>
                    <p style="text-transform: lowercase !important;">{{ Auth::user()->email }}</p>
                </div>
                <ul class="list-group">
                    <!-- <li class="list-group-item">
                        <span class="badge badge-warning">2</span>
                        <i class="fa fa-tasks"></i>
                        Atividades pendentes
                    </li> -->
                    <li class="list-group-item">
                        <span class="badge badge-info">{{ count($mensagem) }}</span>
                        <i class="fa fa-envelope-o"></i>
                        Mensagens não lidas
                    </li>
                    <li class="list-group-item">
                        <span class="badge badge-success" id="incomplete-itens"></span>
                        <i class="fa fa-check-square-o"></i>
                        itens incompletos
                    </li>
                </ul>
            </div>
            <!-- end Pofile panel -->
		</div>
		<div class="col-sm-3">
		    <section data-ng-controller="chartCtrl">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Dados totais completos</h3>
                    </div>
                    <div class="panel-body text-center">
                    <!-- easypiechart3.percent -->
                    	@if(isset($total))
                        <div easypiechart options="easypiechart3.options" percent="{{$total}}" class="easypiechart">
                            <span class="pie-percent" ng-bind="{{$total}}"></span>
                        </div>
                        @else
                        <div easypiechart options="easypiechart3.options" percent="{{$total_candidatos}}" class="easypiechart">
                            <span class="pie-percent" ng-bind="{{$total_candidatos}}"></span>
                        </div>
                        @endif
                    </div>
                </div>
			</section>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
		    <div class="panel panel-default">
		        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Andamento do cadastro</strong></div>
		        <table class="table">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>Área</th>
		                    <th>Status</th>
		                    <th>Progresso</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr>
		                    <td>1</td>
		                    <td><a href="{{URL::to('candidato/meusdados/dados-pessoais')}}"> Dados Pessoais </a></td>
		                    @if($progresso['dados_pessoais'] < 100) <?php $label = 'warning'; $itensIncompletos++; ?> @else <?php $label = 'success'; ?> @endif
		                    <td><span class="label label-{{$label}} pover" @if(isset($vazio['dados_pessoais'])) popover-trigger="mouseenter" popover-title="Campos não preenchidos" popover="{{implode(', ', $vazio['dados_pessoais'])}}" @endif>@if($progresso['dados_pessoais'] < 100) <?php $label = 'warning'; ?> Pendente @else <?php $label = 'success'; ?> Finalizado @endif</span></td>
		                    <td><progressbar class="progressbar-xs no-margin" value="{{$progresso['dados_pessoais']}}" type="{{$label}}"></progressbar></td>
		                </tr>
		                <tr>
		                	{{--$progresso['formacao_superior']--}}
		                	{{--isset($progresso['formacao_superior']) && $progresso['formacao_superior'] < 100--}}
		                	{? $progressoFormacaoSuperior = isset($progresso['formacao_superior']) && $progresso['formacao_superior'] <= 100 ? $progresso['formacao_superior'] : 0; ?}
		                    <td>2</td>
		                    <td><a href="{{URL::to('candidato/meusdados/formacao')}}"> Formação Superior </a></td>
		                    @if($progressoFormacaoSuperior >= 0 && $progressoFormacaoSuperior < 100) <?php $label = 'warning'; $itensIncompletos++; ?> @else <?php $label = 'success'; ?> @endif
		                    <td><span class="label label-{{$label}} pover" @if(isset($vazio['formacao_superior'])) popover-trigger="mouseenter" popover-title="Campos não preenchidos" popover="{{implode(', ', $vazio['formacao_superior'])}}" @endif>@if($progressoFormacaoSuperior >= 0 && $progressoFormacaoSuperior < 100) <?php $label = 'warning'; ?> Pendente @else <?php $label = 'success'; ?> Finalizado @endif</span></td>
		                    <td><progressbar class="progressbar-xs no-margin" value="{{$progressoFormacaoSuperior}}" type="{{$label}}"></progressbar></td>
		                </tr>
		                <tr>
		                	{{-- $progresso['experiencia_profissional'] --}}
		                	{{-- isset($progresso['experiencia_profissional']) && $progresso['experiencia_profissional'] < 100 --}}
		                	{? $progressoExperienciaProfissional = isset($progresso['experiencia_profissional']) && $progresso['experiencia_profissional'] <= 100 ? $progresso['experiencia_profissional'] : 0; ?}
		                    <td>3</td>
		                    <td><a href="{{URL::to('candidato/meusdados/experiencia')}}"> Experiência Profissional </a></td>
		                    @if($progressoExperienciaProfissional > 0 && $progressoExperienciaProfissional < 100) <?php $label = 'warning'; $itensIncompletos++; ?> @else <?php $label = 'success'; ?> @endif
		                    <td><span class="label label-{{$label}} pover" @if(isset($vazio['experiencia_profissional'])) popover-trigger="mouseenter" popover-title="Campos não preenchidos" popover="{{implode(', ', $vazio['experiencia_profissional'])}}" @endif>@if($progressoExperienciaProfissional > 0 && $progressoExperienciaProfissional < 100) <?php $label = 'warning'; ?> Pendente @else <?php $label = 'success'; ?> Finalizado @endif</span></td>
		                    <td><progressbar class="progressbar-xs no-margin" value="{{ $progressoExperienciaProfissional }}" type="{{$label}}"></progressbar>
		                </tr>
		                <tr>
		                	{{-- $progresso['docencia'] --}}
		                	{{-- isset($progresso['docencia']) && $progresso['docencia'] < 100 --}}
		                	{? $progressoDocencia = isset($progresso['docencia']) && $progresso['docencia'] <= 100 ? $progresso['docencia'] : 0; ?}
		                    <td>4</td>
		                    <td><a href="{{URL::to('candidato/meusdados/docencia')}}"> Docência </a></td>
		                    @if($progressoDocencia > 0 && $progressoDocencia < 100 ) <?php $label = 'warning'; $itensIncompletos++; ?> @else <?php $label = 'success'; ?> @endif
		                    <td><span class="label label-{{$label}} pover" @if(isset($vazio['docencia'])) popover-trigger="mouseenter" popover-title="Campos não preenchidos" popover="{{implode(', ', $vazio['docencia'])}}" @endif>@if($progressoDocencia > 0 && $progressoDocencia < 100 ) <?php $label = 'warning'; ?> Pendente @else <?php $label = 'success'; ?> Finalizado @endif</span></td>
		                    <td><progressbar class="progressbar-xs no-margin" value="{{ $progressoDocencia }}" type="{{$label}}"></progressbar></td>
		                </tr>
						<tr>
			                {{-- $progresso['outras_infos'] --}}
		                	{{-- isset($progresso['outras_infos']) && $progresso['outras_infos'] < 100 --}}
		                	{? $progressoOutrasInfos = isset($progresso['outras_infos']) ? $progresso['outras_infos'] : 0; ?}
		                    <td>4</td>
		                    <td><a href="{{URL::to('candidato/meusdados/outras-infos')}}"> Outras Informações </a></td>
		                    @if($progressoOutrasInfos < 100 ) <?php $label = 'warning'; $itensIncompletos++; ?> @else <?php $label = 'success'; ?> @endif
		                    <td><span class="label label-{{$label}} pover" @if($progressoOutrasInfos < 100 ) popover-trigger="mouseenter" popover-title="Campos não preenchidos" popover="proficiencia_ingles" @endif>@if($progressoOutrasInfos < 100 ) <?php $label = 'warning'; ?> Pendente @else <?php $label = 'success'; ?> Finalizado @endif</span></td>
		                    <td><progressbar class="progressbar-xs no-margin" value="{{ $progressoOutrasInfos }}" type="{{$label}}"></progressbar></td>
		                </tr>
		            </tbody>
		        </table>
		    </div>
	    </div>
	</div>


</div>

<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript">

	$(document).ready(function()
	{
		$("#incomplete-itens").html('<?php echo $itensIncompletos; ?>');
		@if(Session::has('success') || Session::get('danger') || Session::get('info') || Session::get('warning'))
			$("#ModalAlerta").modal('show');
		@else
			$("#ModalAlerta").modal('hide');
		@endif

		$('.pover').popover({ html: true });
		$('.pover').popover('show');
	});

</script>

	<!-- Modal -->
	<div class="modal fade" id="ModalAlerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Alerta</h4>
	      </div>
	      <div class="modal-body">
	      	@include('elements.alerts')
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	      </div>
	    </div>
	  </div>
	</div>

@stop