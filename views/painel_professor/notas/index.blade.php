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

        .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
          background-color: #E1E1E1;
        }

    </style>
@stop

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function()
        {
            getIdentificadores();

            $('#areas_area_id').change(function()
            {
                getIdentificadores();
            });

            $('#areas_periodo_id').change(function()
            {
                getIdentificadores();
            });

            // original
	    /*function getIdentificadores()
            {
                var id_linha = $('#areas_area_id').val();

                var id_periodo = $('#areas_periodo_id').val();

                if(id_linha && id_periodo)
                {
                  $.get( "nota/identificadores/"+id_linha+"/"+id_periodo+"/?tipo={{Input::get('tipo')}}", function( data ) 
                  {
                    $('#select_identificadores').html('');

                    if(data.length)
                    {
                      for (var i = data.length - 1; i >= 0; i--) {

			var identificador = data[i].identificador;

                        if( identificador == 'PE' ){
                          identificador = 'Prova Específica';
                        }

                        if( identificador == 'PO' ){
                          identificador = 'Prova Oral';
                        }

                        if( identificador == 'PT' ){
                          identificador = 'Prova de Título';
                        }

                        if( identificador == 'PP' ){
                          identificador = 'Plano de Pesquisa';
                        }                          

			$('#select_identificadores').append('<option value="'+data[i].id+'">'+identificador+'</option>');
                        $('#select_identificadores').removeAttr('disabled', 'disabled');
                      };
                    }
                    else
                    {
                      $('#select_identificadores').append('<option value="">Não há provas com esse periodo/area</option>');
                      $('#select_identificadores').attr('disabled', 'disabled');
                    }                        

                    console.log(data);
                  });
                }
            }*/

	    // em teste
            function getIdentificadores()
            {
                var id_linha = $('#areas_area_id').val();

                var id_periodo = $('#areas_periodo_id').val();				
				
				
				
                if(id_linha && id_periodo)
                {
                  $.get( "nota/identificadores/"+id_linha+"/"+id_periodo+"/?tipo={{Input::get('tipo')}}", function( data ) 
                  {
                    $('#select_identificadores').html('');

                    var identificadorSelected = '';

                    if ( '{{ $id_identificador }}' != '' )
                    {
                      if( '{{ $identificadorNome }}' == 'PE' ){
                        identificadorSelected = 'Prova Específica';
                      }

                      if( '{{ $identificadorNome }}' == 'PO' ){
                        identificadorSelected = 'Prova Oral';
                      }

                      if( '{{ $identificadorNome }}' == 'PT' ){
                        identificadorSelected = 'Prova de Título';
                      }

                      if( '{{ $identificadorNome }}' == 'PP' ){
                        identificadorSelected = 'Plano de Pesquisa';
                      }

                      $('#select_identificadores').append("<option value={{ $id_identificador }} selected>"+identificadorSelected+"</option>");
                    }  

                    if(data.length)
                    {
                      for (var i = data.length - 1; i >= 0; i--) {
                        
                        var identificador = data[i].identificador;

                        if( identificador == 'PE' ){
                          identificador = 'Prova Específica';
                        }

                        if( identificador == 'PO' ){
                          identificador = 'Prova Oral';
                        }

                        if( identificador == 'PT' ){
                          identificador = 'Prova de Título';
                        }

                        if( identificador == 'PP' ){
                          identificador = 'Plano de Pesquisa';
                        }  
                        
                        if ( identificador != identificadorSelected ){
                          $('#select_identificadores').append('<option value="'+data[i].id+'">'+identificador+'</option>');
                          $('#select_identificadores').removeAttr('disabled', 'disabled');
                        }

                      };
                    }
                    else
                    {
                      $('#select_identificadores').append('<option value="">Não há provas com esse periodo/area</option>');
                      $('#select_identificadores').attr('disabled', 'disabled');
                    }                        

                    console.log(data);
                  });
                }
            }

        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo') ?}

<div class="page ng-scope">
   <!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->
   <section class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Lista de Candidatos</strong></div>
      <div class="panel-body">
         <div class="row">
            <div class="col-sm-12">
               <form method="GET" action="{{URL::to('nota')}}" accept-charset="UTF-8" class="form-inline" role="form">
                  <div class="btn-toolbar" role="toolbar">
                     <div class="pull-left">
                        <h2></h2>
                     </div>
                  </div>
                  <br>
                  <select class="form-control" placeholder="Linha" type="select" id="areas_periodo_id" name="periodo_id">
                    <option value="">Selecione um Periodo</option>
                    @if(!empty($periodos))
                        @foreach($periodos as $periodo)
                            <option value="{{$periodo->id}}" @if((Input::has('periodo_id') && $periodo->id == Input::get('periodo_id')) || $periodo_id == $periodo->id) selected="" @endif>{{$periodo->ano}} / {{$periodo->periodo}}</option>
                        @endforeach
                    @else                        
                        <option value="">Você não pertence a nenhuma Linha</option>
                    @endif

                  </select>

                  <select class="form-control" placeholder="Linha" type="select" id="areas_area_id" name="linha_id">
                    <option value="">Selecione uma Linha</option>
                    @if(!empty($areas_usuario))
                        @foreach($areas_usuario as $key => $area)
                            <option value="{{$key}}" @if(Input::has('linha_id') && $key == Input::get('linha_id')) selected="" @endif>{{$area}}</option>
                        @endforeach
                    @else                        
                        <option>Você não pertence a nenhuma Linha</option>
                    @endif
                  </select>
                  <!-- <select class="form-control" placeholder="Situação" type="select" id="status_status_id" name="status_id">
                    <option value="">Selecione uma situação</option>
                    @foreach($situacoes as $key => $situacao)
                        <option value="{{$key}}" @if(Input::has('status_id') && $key == Input::get('status_id')) selected="" @endif>{{$situacao}}</option>
                    @endforeach
                  </select> -->

                  <select id="select_identificadores" name="identificador" placeholder="Identificador, Ex: P1" class="form-control">
                    <option>Selecione um periodo e area primeiro</option>
                  </select>

                  <!-- <input class="form-control" placeholder="Nome" type="text" id="nome" name="nome" @if(Input::has('nome')) value="{{Input::get('nome')}}" @endif> -->


                  <input type="hidden" name="tipo" value="{{ $tipo }}">
                  <input class="btn btn-primary" type="submit" value="Filtrar">
                  <input name="search" type="hidden" value="1">
               </form>
            </div>
         </div>
         <div class="row">
            <div class="col-sm-12">
               <div class="btn-toolbar" role="toolbar">
                  <div class="pull-left">
                     <h2></h2>
                  </div>
               </div>
               <br>

               <form method="POST" action="{{URL::to('nota/salvar')}}">
                   @if(isset($prova) && !empty($prova))
                   <div class="page-header">
                    <h2>{{$prova->area->sigla}} - {{$prova->area->nome}}</h2>
	
					<h3>{{$nomeProva}} - {{$prova->tipo}}</h3>
					
                    @if($prova->tipo == 'Classificatoria')
                      <h3 class="label label-success">Nota Classificatória: {{$prova->nota_classificatoria}}</h3>
                    @else
                      <h3 class="label label-danger">Nota Eliminatória: {{$prova->nota_eliminatoria}}</h3>
                    @endif         
					   
					   <br><br>
					@if ($publicavel || !$prova->publicado)					   
						<h5>Inserir 'F' para 'FALTA'</h5>
                    	@if($prova->tipo == 'Eliminatoria')					   
                      	<h5>Inserir 'D' para 'DISPENSADO'</h5>
                    	@endif    
					@endif

                   </div>
                   @endif

                   <table class="table table-striped">
                      <thead>
                         <tr>
                            <th>
                               Nome do Candidato
                            </th>
                            <th>
                               Nota
                            </th>
                            <th>
                               Status
                            </th>
                         </tr>
                      </thead>
                      <tbody>

                      @forelse($notas as $nota)
                        @if($nota->inscricao)
                         <tr>
                            <td>{{$nota->inscricao->usuario->nome}}</td>
							@if (!$publicavel && $prova->publicado)
								 @if (@is_numeric($nota->nota))
									<td> {{ @number_format($nota->nota, 2, ',', '.') }} </td>
								 @elseif ($nota->status == "FALTOU")
									<td>F</td>
								 @elseif ($nota->status == "DISPENSADO")
									<td>D</td>					 
								 @endif
							 @else
								 @if (@is_numeric($nota->nota))
										<td><input type="text" name="notas[{{$nota->id}}][nota]" 
									   value="{{ @number_format($nota->nota, 2, ',', '.') }}" /></td>
								 @elseif ($nota->status == "FALTOU")
										<td><input type="text" name="notas[{{$nota->id}}][nota]" 
									   value="F" /></td>
								 @elseif ($nota->status == "DISPENSADO")
									<td><input type="text" name="notas[{{$nota->id}}][nota]" 
									   value="D" /></td>				
								@else
									<td><input type="text" name="notas[{{$nota->id}}][nota]" 
									   value="" /></td>
								 @endif														
							 @endif
                            <td>{{$nota->status}}</td>
                            <!--td><input type="checkbox" name="notas[{{$nota->id}}][falta]" value="1" @if($nota->falta == 1) CHECKED @endif /></td-->
                         </tr>
                        @endif
                      @empty
                        Nenhum registro encontrado.
                      @endforelse
                       
                      </tbody>
                   </table>               
                   @if(isset($notas))
                   <input type="hidden" name="tipo" value="{{Input::get('tipo')}}" />
                   <div class="row">
					 @if(isset($prova) && !empty($prova))
					 	@if ($publicavel || !$prova->publicado) 
                     		<button type="submit" class="btn btn-w-md btn-gap-v btn-primary">Salvar dados desta página</button>
					 	@else
					    	<h4><strong>As notas foram publicadas - edição desabilitada</strong></h4>
					    @endif
					 @endif
                   </div>
                   <!-- <div class="row">
                    {{--$notas->appends(array('periodo_id' => Input::get('periodo_id'),'tipo'=> $tipo,'nome' => Input::get('nome'),'linha_id'=>Input::get('linha_id'), 'identificador' => Input::get('identificador')))->links()--}}
                   </div> -->
                   @endif
               </form>
				<br> <br>
				<form method="POST" action="{{URL::to('nota/publicar')}}">
					@if(isset($prova) && !empty($prova))						
						@if ($publicavel)
							<input type="hidden" name="tipo" value="{{Input::get('tipo')}}" />
							<input type="hidden" name="id" value="{{$prova->id}}" />
							<input type="hidden" name="publicado" value="{{$prova->publicado}}" />
							<div class="row">
								@if ($prova->publicado)
					  			<button type="submit" class="btn btn-w-md btn-gap-v btn-primary">Despublicar Notas</button>
								@else
								<button type="submit" class="btn btn-w-md btn-gap-v btn-primary">Publicar Notas</button>
								@endif
							</div>
					  	@endif 
					@endif
				</form>

            </div>
         </div>
      </div>
   </section>
   <!-- </form> -->
</div>
@stop
