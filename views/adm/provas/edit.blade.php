@extends('templates.master')

@section('content')

<div class="page">

	<form class="form-horizontal" method="POST" action="{{URL::to("adm/prova/$prova->id")}}">
		<input type="hidden" name="_method" value="PUT">
		{{Form::token()}}

		<div class="btn-toolbar" role="toolbar">
		    <div class="pull-left">
		    	<h2></h2>
			</div>
		    <div class="pull-right">
			    <a href="{{URL::to('adm/prova')}}" class="btn btn-default">Voltar para listagem</a>
			    <button type="submit" class="btn btn-success">Salvar</button>
		    </div>
		</div>



	    <fieldset>
	        <!-- Form Name -->
	        <legend>Prova - {{$prova->nome}}</legend>
	        <!-- Text input-->
	        <div class="form-group">
	            <label class="col-md-4 control-label" for="nome">Prova:</label>
	            <div class="col-md-5">
	                <input id="nome" name="nome" type="text" placeholder="ex: Prova Específica" class="form-control input-md" required="" value="{{$prova->nome}}">
	                <span class="help-block">O nome da Prova</span>
	            </div>
	        </div>

	        <!-- Text input-->
			<div class="form-group">
			    <label class="col-md-4 control-label" for="sigla">Sigla</label>
			    <div class="col-md-5">
			        <input id="sigla" name="sigla" type="text" placeholder="Ex: PP" class="form-control input-md" required="" value="{{$prova->sigla}}">
			        <span class="help-block">Sigla do nome.</span>
			    </div>
			</div>

	        <!-- Multiple Radios -->
			<div class="form-group">
			    <label class="col-md-4 control-label" for="publicado">Publicado</label>
			    <div class="col-md-4">
			        <div class="radio">
			            <label for="publicado-0">
			            <input type="radio" name="publicado" id="publicado-0" value="1" @if($prova->publicado) checked="checked" @endif>
			            Sim
			            </label>
			        </div>
			        <div class="radio">
			            <label for="publicado-1">
			            <input type="radio" name="publicado" id="publicado-1" value="0" @if(!$prova->publicado) checked="checked" @endif>
			            Não
			            </label>
			        </div>
			    </div>
			</div>

	    </fieldset>
	</form>


</div>

@stop