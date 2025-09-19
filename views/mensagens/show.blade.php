@extends('templates.master')

@section('content')
	<div class="col-sm-12" data-ng-controller="Mensagem.ShowController as msg">

        <section class="panel panel-default mail-container">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Visualizando Mensagem</strong></div>
            <div class="panel-body">
                <div class="mail-header row">
                    <div class="col-md-8">
                        <h3>Assunto: {{$mensagem->assunto}}</h3>
                    </div>
                    <div class="col-md-4">
                        <div class="pull-right">
                            <a href="{{URL::to('mensagem/create/?email=' . $mensagem->remetente->email.'&assunto='.$mensagem->assunto)}}" class="btn btn-sm btn-primary">Responder <i class="fa fa-mail-reply"></i></a>
                            <a href="{{URL::to('mensagem/delete/' . $mensagem->id)}}" class="btn btn-sm btn-default"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>
                </div>
                <div class="mail-info">
                    <div class="row">
                        <div class="col-md-8">
                            <strong>{{$mensagem->remetente->nome}}</strong> ({{$mensagem->remetente->email}}) para
                            <strong>{{$mensagem->destinatario->nome}}</strong>
                        </div>
                        <div class="col-md-4">
                            <div class="pull-right">
                                {{$mensagem->created_at}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mail-content">
                    {{$mensagem->mensagem}}
                </div>
                <div class="mail-actions">
                    <a href="{{URL::to('mensagem/create/?email=' . $mensagem->remetente->email.'&assunto='.$mensagem->assunto)}}" class="btn btn-sm btn-primary">Responder <i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
        </section>


        <section class="panel panel-default mail-container">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Mensagens Anteriores</strong></div>

                <section class="panel panel-default mail-container" data-ng-repeat="mensagem in msg.historico | orderBy:'-created_at'">
                    <div class="panel-heading"><strong><span class="glyphicon glyphicon-envelope"></span> </strong> <strong>@{{mensagem.remetente.nome}}</strong> (@{{mensagem.remetente.email}}) para
                                    <strong>@{{mensagem.destinatario.nome}}</strong> EM @{{mensagem.created_at}}</div>
                    <div class="panel-body">
                        <div class="mail-header row">
                            <div class="col-md-8">
                                <h3>Assunto: @{{mensagem.assunto}}</h3>
                            </div>
                        </div>
                        <div class="mail-info">
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                        <div class="mail-content" data-ng-bind-html="mensagem.mensagem">

                        </div>
                    </div>
                </section>
        </section>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
    var laravel_vars = {"mensagem" : {"id_remetente" : {{$mensagem->remetente->id}}, "id_destinatario": {{$mensagem->id_destinatario}} } };
</script>
@stop