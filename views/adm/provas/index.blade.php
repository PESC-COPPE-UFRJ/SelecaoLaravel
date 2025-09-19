@extends('templates.master')

@section('scripts')

<script type="text/javascript">
function resetForm()
{
    document.getElementById("filtro").reset();
}

$(document).ready(function()
{
	$("#select_all").click(function()
	{
		var checkBoxes = $("input[name=provas\\[\\]]");
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	});
});

</script>

@stop

@section('content')

<legend>Lista de Provas</legend>

@include('elements.alerts')

<form id="filtro" method="GET" action="{{URL::to('adm/periodo')}}" accept-charset="UTF-8" class="form-inline ng-pristine ng-valid" role="form">
    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <h2></h2>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="ano" class="sr-only">Ano</label>
        <span id="div_ano">
        <input class="form-control" placeholder="Ano" type="text" id="ano" name="ano" value="{{Input::get('ano')}}">
        </span>
    </div>
    <div class="form-group">
        <label for="periodo" class="sr-only">Periodo</label>
        <span id="div_periodo">
        <input class="form-control autocompleter" placeholder="Periodo" type="text" id="periodo" name="periodo" value="{{Input::get('periodo')}}">
        </span>
    </div>
    <input class="btn btn-primary" type="submit" value="Filtrar">
    <!--button type="reset" class="btn btn-default" onClick="resetForm();">Limpar Filtros</button-->
    <input type="hidden" name="_search" value="1" />
</form>

<hr>

<form id="delete" action="{{URL::to('adm/prova/deletar')}}" method="POST">
	{{Form::token()}}
	<div class="btn-toolbar" role="toolbar">

	    <div class="pull-left">
	    	<input type="submit" class="btn btn-danger" value="Deletar Selecionados">
		</div>

	    <div class="pull-right">
	    	<a href="{{URL::to('adm/prova/create')}}" class="btn btn-success">Nova Prova</a>
	    </div>
	</div>

	<br />

	<table class="table">
	    <thead>
	        <tr>
	        	<th>
	        	<div class="checkbox">
				    <input type="checkbox" id="select_all">
				    Selecionar todos
				</div>
	        	</th>
	            <th>
	                <a href="/adm/periodo?ord1=ano">
	                <span class="glyphicon glyphicon-arrow-up"></span>
	                </a>
	                <a href="/adm/periodo?ord1=-ano">
	                <span class="glyphicon glyphicon-arrow-down"></span>
	                </a>
	                Nome da prova
	            </th>
	            <th>
	                Pubicado
	            </th>
	            <th>
	                Ações
	            </th>
	        </tr>
	    </thead>
	    <tbody>
	    	@foreach($provas as $prova)
	        <tr>
	        	<td>
		        	<div class="checkbox">
					    <input type="checkbox" name="provas[]" value="{{$prova->id}}">
					</div>
				</td>
	            <td>{{$prova->nome}}</td>
	            <td>{{$prova->publicado}}</td>
	            <td>
	                <a class="" title="Modificar" href="/adm/prova/{{$prova->id}}/edit"><span class="glyphicon glyphicon-edit"> </span></a>
	            </td>
	        </tr>
	        @endforeach
	    </tbody>
	</table>
</form>

{{$provas->links()}}
@stop