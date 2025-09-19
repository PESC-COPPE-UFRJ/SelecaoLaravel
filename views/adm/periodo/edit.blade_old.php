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

<form method="POST" action="{{URL::to("adm/periodo/{$periodo->id}")}}" accept-charset="UTF-8" class="form-horizontal ng-pristine ng-valid" role="form">
    {{Form::token()}}
    <input type="hidden" name="_method" value="PUT" />
    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <h2></h2>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="ano" class="col-sm-2 control-label required">Ano</label>
        <div class="col-sm-10" id="div_ano">
            <input class="form-control" type="text" id="ano" name="ano" value="{{$periodo->ano}}">
        </div>
    </div>
    <div class="form-group">
        <label for="periodo" class="col-sm-2 control-label">Periodo</label>
        <div class="col-sm-10" id="div_periodo">
            <select class="form-control" type="select" id="periodo" name="periodo">
                <option value="1" @if($periodo->periodo == 1) selected @endif >1</option>
                <option value="2" @if($periodo->periodo == 2) selected @endif >2</option>
                <option value="3" @if($periodo->periodo == 3) selected @endif >3</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="habilitado" class="col-sm-2 control-label">Habilitado</label>
        <div class="col-sm-10" id="div_habilitado">
            <input name="habilitado" type="radio" value="1" @if($periodo->habilitado == 1) checked @endif> Sim&nbsp;&nbsp;<input name="habilitado" type="radio" value="0" @if($periodo->habilitado == 0) checked @endif> Não&nbsp;&nbsp;
        </div>
    </div>
    <div class="form-group" data-ng-controller="DatepickerDemoCtrl">
        <label for="data_hora_inicio" class="col-sm-2 control-label">Data de Início</label>
        <div class="col-sm-10" id="div_data_hora_inicio">
           <input class="form-control datepicker" type="text" id="data_hora_inicio" name="data_hora_inicio" value="{{$periodo->data_hora_inicio}}">
        </div>
    </div>
    <div class="form-group" data-ng-controller="DatepickerDemoCtrl">
        <label for="data_hora_fim" class="col-sm-2 control-label">Data do Fim</label>
        <div class="col-sm-10" id="div_data_hora_fim">
               <input class="form-control datepicker" type="text" id="data_hora_fim" name="data_hora_fim" value="{{$periodo->data_hora_fim}}">
        </div>
    </div>

    <section class="panel panel-default mail-container">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Vagas abertas deste período </strong></div>

        @if(!$areas->isEmpty())
            @foreach($areas as $area)
                <div class="form-group clearfix">
                    <label for="habilitado" class="col-sm-2 control-label" style="text-align: right;">{{$area->nome}} ({{$area->sigla}})</label>
                    <div class="col-sm-7" id="div_habilitado">
                        <input name="areas_vagas[{{$area->id}}]" type="text" value="{{$area->pivot->num_vagas}}" class="form-control">
                    </div>
                    <div class="col-sm-3">
                        Vagas
                    </div>
                </div>
            @endforeach
        @else
            <div class="form-group clearfix">
                <p> Não há areas vinculadas a este Período.</p>
            </div>
        @endif

    </section>


    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <a href="/adm/periodo" class="btn btn-default">Voltar a listagem</a>
            <input class="btn btn-primary" type="submit" value="Salvar">
        </div>
    </div>
    <br />
    <br />
</form>

@stop