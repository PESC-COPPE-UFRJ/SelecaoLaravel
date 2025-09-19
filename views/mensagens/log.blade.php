@extends('templates.master')

@section('content')

<div class="row" data-ng-controller="Mensagem.HistoricoController as historicoCtrl">

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong><span class="glyphicon glyphicon-envelope"></span> Log de Mensagens </strong>
        </div>
        <div class="panel-body">
            <div class="ui-tab-container">
                <tabset justified="true" class="ui-tab">
                    <tab heading="Todas as mensagens por usuário">
                            <fieldset>
                                <div class="form-group">
                                    <label for="filtro_remetente">Buscar por usuário:</label>
                                    <input type="text" id="filtro_remetente" class="form-control" data-ng-model="historicoCtrl.filtroSingle" placeholder="Digite o nome ou parte dele"/>
                                </div>
                                
                                <div class="form-group">
                                <ul class="list-unstyled">
                                    <li class="text-normal nav-profile well well-lg" data-ng-style="usuario.selecionado" data-ng-repeat="usuario in historicoCtrl.listaUsuarios | filter:{nome:historicoCtrl.filtroSingle}" data-ng-if="historicoCtrl.filtroSingle">
                                        <a href="javascript:;" data-ng-click="historicoCtrl.selecionaSingle(usuario)">
                                            <img data-ng-src="@{{usuario.foto ? usuario.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img30_30">
                                            <span>
                                                <span>@{{usuario.nome}}</span>
                                            </span>
                                        </a>
                                    </li>                                    
                                </ul>

                                </div>
                            </fieldset>

                            <div class="panel panel-default" data-ng-if="historicoCtrl.usuarioSingle">
                                <div class="panel-heading">
                                    <strong><span class="glyphicon glyphicon-envelope"></span> Histórico </strong>
                                </div>
                                <div class="panel-body">

                                    <!-- Pofile panel -->
                                    <div class="panel panel-profile">
                                        <div class="panel-heading bg-primary clearfix">
                                            <a href="" class="pull-left profile">
                                                <img data-ng-src="@{{historicoCtrl.usuarioSingle.foto ? historicoCtrl.usuarioSingle.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img80_80">
                                            </a>
                                            <h3>@{{historicoCtrl.usuarioSingle.nome}}</h3>
                                            <p>@{{historicoCtrl.usuarioSingle.email}}</p>
                                        </div>
                                    </div>
                                    <!-- end Pofile panel -->

                                    <div class="ui-tab-container">
                                        <tabset justified="true" class="ui-tab">
                                            <tab heading="Mensagens Recebidas">

                                                <!-- Scrollable -->
                                                <div class="pre-scrollable mail-container">
                                                    <table class="table table-hover" data-ng-if="historicoCtrl.usuarioSingle.mensagensRecebidas.length">
                                                        <tr ng-class="{'mail-unread': !recebida.lido}" data-ng-repeat="recebida in historicoCtrl.usuarioSingle.mensagensRecebidas" data-ng-click="historicoCtrl.mensagemOnClick(recebida)" style="cursor: pointer;">
                                                            <td>De: @{{recebida.remetente.nome}}</td>
                                                            <td>@{{recebida.assunto}}</td>
                                                            <td>@{{recebida.created_at}}</td>
                                                        </tr>
                                                    </table>

                                                    <div class="alert alert-info text-center" data-ng-show="!historicoCtrl.usuarioSingle.mensagensRecebidas.length">
                                                        Nenhuma mensagem recebida
                                                    </div>
                                                </div>

                                            </tab>
                                            <tab heading="Mensagens Enviadas">


                                                <!-- Scrollable -->
                                                <div class="pre-scrollable mail-container">

                                                    <table class="table table-hover">
                                                        <tr ng-class="{'mail-unread': !enviada.lido}" data-ng-repeat="enviada in historicoCtrl.usuarioSingle.mensagensEnviadas" style="cursor: pointer;" data-ng-click="historicoCtrl.mensagemOnClick(enviada)">
                                                            <td>Para: @{{enviada.destinatario.nome}}</td>
                                                            <td>@{{enviada.assunto}}</td>
                                                            <td>@{{enviada.created_at}}</td>
                                                        </tr>
                                                    </table>

                                                    <div class="alert alert-info text-center" data-ng-show="!historicoCtrl.usuarioSingle.mensagensEnviadas.length">
                                                        Nenhuma mensagem enviada
                                                    </div>
                                                </div>
                                            </tab>
                                        </tabset>
                                    </div>
                                </div>

                            </div>
                    </tab>
                    <tab heading="Histórico de Conversa">

                        <form class="form-validation">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="filtro_remetente">Buscar por Remetente:</label>
                                        <input type="text" class="form-control ng-invalid ng-invalid-required" data-ng-model="historicoCtrl.filtroRemetente" placeholder="Digite o nome ou parte dele" required/>
                                    </div>

                                    <div class="form-group">
                                        <ul class="list-unstyled">
                                            <li class="text-normal nav-profile well well-lg" data-ng-style="usuario.selecionado1" data-ng-repeat="usuario in historicoCtrl.listaUsuarios | filter:{nome:historicoCtrl.filtroRemetente}" data-ng-if="historicoCtrl.filtroRemetente">
                                                <a href="javascript:;" data-ng-click="historicoCtrl.selecionaRemetente(usuario)">
                                                    <img data-ng-src="@{{usuario.foto ? usuario.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img30_30">
                                                    <span>
                                                        <span>@{{usuario.nome}}</span>
                                                    </span>
                                                </a>
                                            </li>                                    
                                        </ul>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filtro_remetente">Buscar por Destinatário:</label>
                                        <input type="text" class="form-control" data-ng-model="historicoCtrl.filtroDestinatario" placeholder="Digite o nome ou parte dele" required/>
                                    </div>

                                    <div class="form-group">
                                        <ul class="list-unstyled">
                                            <li class="text-normal nav-profile well well-lg" data-ng-style="usuario.selecionado2" data-ng-repeat="usuario in historicoCtrl.listaUsuarios | filter:{nome:historicoCtrl.filtroDestinatario}" data-ng-if="historicoCtrl.filtroDestinatario">
                                                <a href="javascript:;" data-ng-click="historicoCtrl.selecionaDestinatario(usuario)">
                                                    <img data-ng-src="@{{usuario.foto ? usuario.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img30_30">
                                                    <span>
                                                        <span>@{{usuario.nome}}</span>
                                                    </span>
                                                </a>
                                            </li>                                    
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </form>

                        <div class="row">

                            <div class="panel panel-default" data-ng-if="historicoCtrl.remetenteSelecionado && historicoCtrl.destinatarioSelecionado">
                                <div class="panel-heading">
                                    <strong><span class="glyphicon glyphicon-envelope"></span> Histórico </strong>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <!-- Pofile panel Remetente -->
                                        <div class="panel panel-profile col-md-6">
                                            <div class="panel-heading bg-primary clearfix">
                                                <a href="" class="pull-left profile">
                                                    <img data-ng-src="@{{historicoCtrl.remetenteSelecionado.foto ? historicoCtrl.remetenteSelecionado.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img80_80">
                                                </a>
                                                <h3>@{{historicoCtrl.remetenteSelecionado.nome}}</h3>
                                                <p>@{{historicoCtrl.remetenteSelecionado.email}}</p>
                                            </div>
                                        </div>
                                        <!-- end Pofile panel -->

                                        <!-- Pofile panel Destinatario -->
                                        <div class="panel panel-profile col-md-6">
                                            <div class="panel-heading bg-primary clearfix">
                                                <a href="" class="pull-left profile">
                                                    <img data-ng-src="@{{historicoCtrl.destinatarioSelecionado.foto ? historicoCtrl.destinatarioSelecionado.foto : '/images/assets/no-photo.png'}}" alt="" class="img-circle img80_80">
                                                </a>
                                                <h3>@{{historicoCtrl.destinatarioSelecionado.nome}}</h3>
                                                <p>@{{historicoCtrl.destinatarioSelecionado.email}}</p>
                                            </div>
                                        </div>
                                        <!-- end Pofile panel -->
                                    </div>

                                    <div class="ui-tab-container">
                                        <tabset justified="true" class="ui-tab">
                                            <tab heading="Mensagens Trocadas">

                                                <!-- Scrollable -->
                                                <div class="pre-scrollable mail-container">
                                                    <table class="table table-hover" data-ng-if="historicoCtrl.mensagensTrocadas.length">
                                                        <tr ng-class="{'mail-unread': !mensagem.lido}" data-ng-repeat="mensagem in historicoCtrl.mensagensTrocadas" data-ng-click="historicoCtrl.mensagemOnClick(mensagem)" style="cursor: pointer;">
                                                            <td>De: @{{mensagem.remetente.nome}}</td>
                                                            <td>Para: @{{mensagem.destinatario.nome}}</td>
                                                            <td>@{{mensagem.assunto}}</td>
                                                            <td>@{{mensagem.created_at}}</td>
                                                        </tr>
                                                    </table>

                                                    <div class="alert alert-info text-center" data-ng-show="!historicoCtrl.mensagensTrocadas.length">
                                                        Nenhuma mensagem trocada
                                                    </div>
                                                </div>

                                            </tab>
                                          </tabset>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                    </tab>
                </tabset>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="ModalAlerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-ng-show="historicoCtrl.mensagemSelecionada">
      <div class="modal-dialog">
        <div class="modal-content" style="display:inline-block;">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Assunto: @{{historicoCtrl.mensagemSelecionada.assunto}}</h4>
          </div>
          <div class="modal-body">

            <div class="mail-info">
                <div class="row">
                    <div class="col-md-9">
                        <strong>De: @{{historicoCtrl.mensagemSelecionada.remetente.nome}}</strong> (@{{historicoCtrl.mensagemSelecionada.remetente.email}})
                        <br /> 
                        <strong>Para: @{{historicoCtrl.mensagemSelecionada.destinatario.nome}}</strong> (@{{historicoCtrl.mensagemSelecionada.destinatario.email}})
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            @{{historicoCtrl.mensagemSelecionada.created_at}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>
            <hr />
            <div class="divider"></div>

            <div class="mail-content" data-ng-bind-html="historicoCtrl.mensagemSelecionada.mensagem">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>


</div>



@stop

@section('postscripts')

<script type="text/javascript" src="scripts/bootstrap.min.js"></script>

<script type="text/javascript" src="scripts/app/Mensagem/controllers/Mensagem.HistoricoController.js"></script>
<script type="text/javascript" src="scripts/app/Mensagem/factories/Mensagem.MensagemFactory.js"></script>

@stop