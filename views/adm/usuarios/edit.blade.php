@extends('templates.master')
@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
    <link rel="stylesheet" href="styles/datepicker3.css">
@stop
@section('scripts')
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>

<script type="text/javascript">

$(document).ready(function()
{
    $('.datepicker').datepicker({
            autoclose:  true,
            format: 'dd/mm/yyyy',
            language: 'pt-BR'
    });
});
</script>

@stop

@section('content')


<form method="POST" action="{{URL::to("adm/usuario/{$usuario->id}")}}" accept-charset="UTF-8" class="form-horizontal ng-pristine ng-valid" role="form">
    <section class="panel panel-default mail-container">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Editando usuário {{$usuario->nome}} </strong></div>

            <input type="hidden" name="_method" value="PUT" />

            {{Form::token()}}
            <div class="btn-toolbar" role="toolbar">
                <div class="pull-left">
                    <h2></h2>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="ano" class="col-sm-2 control-label required">Perfis</label>
                <div class="col-sm-10" id="div_ano">
                    <select multiple class="form-control" id="perfis" name="perfis[]">
                    	@foreach($perfis as $key => $value)
                    	   <option value="{{$key}}" @foreach($usuario->perfis as $perfil) @if($key == $perfil->id) selected  @endif @endforeach > {{$value}} </option>
                    	@endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="ano" class="col-sm-2 control-label required">Areas</label>
                <div class="col-sm-10" id="div_ano">
                    <select multiple class="form-control" id="areas" name="areas[]">
                    	@foreach($areas as $key => $value)
                    	   <option value="{{$key}}" @foreach($usuario->areas as $area) @if($key == $area->id) selected  @endif @endforeach> {{$value}} </option>
                    	@endforeach
                    </select>
                </div>
            </div>



    </section>

    <!-- <section class="panel panel-default mail-container">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Vagas abertas deste período </strong></div>



    </section> -->


    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <a href="adm/usuario" class="btn btn-default">Voltar a listagem</a>
            <input class="btn btn-primary" type="submit" value="Salvar">
        </div>
    </div>

    <br />
    <br />

</form>

@stop