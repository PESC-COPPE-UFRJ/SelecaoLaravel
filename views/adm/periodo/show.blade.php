@extends('templates.master')

@section('content')
	<section class="panel panel-default">
        <div class="panel-heading">
        	<strong>
        		<span class="glyphicon glyphicon-th"></span> Periodo</strong>
        	</div>
        <div class="panel-body ng-scope" data-ng-controller="TypeaheadCtrl">
        	@include('elements.alerts')

        	<div class="form">
                <div class="btn-toolbar" role="toolbar">
                    <div class="pull-left">
                        <h2></h2>
                    </div>
                    <div class="pull-right">
                        <a href="/adm/periodo/{{$periodo->id}}/edit" class="btn btn-default">Modificar</a>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="ano" class="col-sm-2 control-label">Ano</label>
                    <div class="col-sm-10" id="div_ano">
                        <div class="help-block">{{$periodo->ano}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="periodo" class="col-sm-2 control-label">Periodo</label>
                    <div class="col-sm-10" id="div_periodo">
                        <div class="help-block">{{$periodo->periodo}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="habilitado" class="col-sm-2 control-label">Habilitado</label>
                    <div class="col-sm-10" id="div_habilitado">
                        <div class="help-block">{{$periodo->habilitado}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data_hora_inicio" class="col-sm-2 control-label">Data de Início</label>
                    <div class="col-sm-10" id="div_data_hora_inicio">
                        <div class="help-block">{{$periodo->data_hora_inicio}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="data_hora_fim" class="col-sm-2 control-label">Data do Fim</label>
                    <div class="col-sm-10" id="div_data_hora_fim">
                        <div class="help-block">{{$periodo->data_hora_fim}}</div>
                    </div>
                </div>
                <div class="btn-toolbar" role="toolbar">
                    <div class="pull-left">
                        <a href="/adm/periodo" class="btn btn-default">Voltar a listagem</a>
                    </div>
                </div>
                <br>
            </div>

        </div>
    </section>

    <section class="panel panel-default">
    <div class="panel-heading">
        <strong>
            <span class="glyphicon glyphicon-th"></span> Vagas abertas do Período</strong>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th style="width: 20%;">
                        Area
                    </th>
                    <th style="width: 10%;">
                        Sigla
                    </th>
                    <th>
                        Vagas
                    </th>
                </tr>
            </thead>
            <tbody>
            @if(!$areas->isEmpty())
                @foreach($areas as $area)
                <tr>
                    <td>{{$area->nome}}</td>
                    <td>{{$area->sigla}}</td>
                    <td>{{$area->pivot->num_vagas}}</td>
                </tr>
                @endforeach
            @else
            <div class="form-group clearfix">
                <p> Não há areas vinculadas a este Período.</p>
            </div>
            @endif
            </tbody>
        </table>

    </section>
@stop