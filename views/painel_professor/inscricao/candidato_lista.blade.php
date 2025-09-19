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

    </style>
@stop

@section('scripts')
    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function()
        {
              $('[data-toggle="tooltip"]').tooltip()

        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo') ?}

<div class="page ng-scope">
   <!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->
   <section class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Lista de Candidatos de @if($tipo == "m") Mestrado @else Doutorado @endif</strong></div>
      <div class="panel-body">
         <div class="row">
            <div class="col-sm-12">
               <form method="GET" action="{{URL::to('professor/inscricao/lista-candidatos')}}" accept-charset="UTF-8" class="form-inline" role="form">
                  <div class="btn-toolbar" role="toolbar">
                     <div class="pull-left">
                        <h2></h2>
                     </div>
                  </div>
                  <br>
                  <div class="col-sm-1">
                    <select class="form-control" placeholder="Linha" type="select" id="areas_area_id" name="periodo_id">
                      @if(!empty($periodos))
                          @foreach($periodos as $periodo)
                              <option value="{{$periodo->id}}" @if(Input::has('periodo_id') && $periodo->id == Input::get('periodo_id') || $periodo->id==$periodo_id) selected="" @endif>{{$periodo->ano}} / {{$periodo->periodo}}</option>
                          @endforeach
                      @else
                          <option value="">Nenhum periodo cadastrado</option>
                      @endif

                    </select>
                  </div>
                  <div class="col-sm-2">
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
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" placeholder="SituaçãoInscrição" type="select" id="status_status_inscricao_id" name="status_inscricao_id">
                      <option value="">Situação de inscrição</option>
                      @foreach($situacoes as $key => $situacao)                             
                          <option value="{{$key}}" @if(Input::has('status_inscricao_id') && $key == Input::get('status_inscricao_id')) selected="" @endif>{{$situacao}}</option>
                      @endforeach
                    </select>
                  </div>  
                  <div class="col-sm-2">
                    <select class="form-control" placeholder="SituaçãoLinha" type="select" id="status_status_linha_id" name="status_linha_id">
                      <option value="">Situação de linha</option>
                      @foreach($situacoes_linha as $key => $situacao)                             
                          <option value="{{$key}}" @if(Input::has('status_linha_id') && $key == Input::get('status_linha_id')) selected="" @endif>{{$situacao}}</option>
                      @endforeach
                    </select>

                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" placeholder="SolicitaBolsa" type="select" id="status_solicita_bolsa" name="solicita_bolsa">
                      <option value="">Bolsa</option>                                                  
                          <option value="S" @if(Input::has('solicita_bolsa') && Input::get('solicita_bolsa') == 'S') selected="" @endif>SIM</option>
                          <option value="N" @if(Input::has('solicita_bolsa') && Input::get('solicita_bolsa') == 'N') selected="" @endif>NÃO</option>
                    </select>

                  </div>
                   
                  <div class="col-sm-2">
                    <input class="form-control" placeholder="Nome" type="text" id="nome" name="nome" @if(Input::has('nome')) value="{{Input::get('nome')}}" @endif>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" type="select" id="pagination" name="pagination">
                      <option value="10">Paginação</option>
                      <option value="10" @if(Input::get('pagination') == 10) SELECTED @endif >10</option>
                      <option value="20" @if(Input::get('pagination') == 20) SELECTED @endif >20</option>
                      <option value="40" @if(Input::get('pagination') == 40) SELECTED @endif >40</option>
                      <option value="80" @if(Input::get('pagination') == 80) SELECTED @endif >80</option>
                      <option value="100" @if(Input::get('pagination') == 100) SELECTED @endif >100</option>
                      <option value="200" @if(Input::get('pagination') == 200) SELECTED @endif >200</option>
                    </select>
                  </div>

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
               <table class="table">
                  <thead>
                     <tr>
                        <th>
                          ID
                        </th>
                        <th>
                           <!-- <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=usuario.nome">
                           <span class="glyphicon glyphicon-arrow-up"></span>
                           </a>
                           <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=-usuario.nome">
                           <span class="glyphicon glyphicon-arrow-down"></span>
                           </a> -->
                           Nome
                        </th>
                        <th>
                           Inscrição
                        </th>
                        <th>
                           Linha/Situação
                        </th>
                        <th>
                           Regime
                        </th>
                        <th>
                           Bolsa
                        </th>
                        <th>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                  @if(isset($inscricoes) && !$inscricoes->isEmpty())
                     @foreach($inscricoes as $inscricao)
                         <tr>
                            <td>{{$inscricao->id}}</td>
                            <td>{{$inscricao->usuario->nome}}</td>
                            <td>@if(isset($inscricao->status) && $inscricao->status->last()) {{$inscricao->status->last()->descricao}} @else Sem status @endif  </td>
                            <td>
                              @foreach($inscricao->areasInscricoes AS $area)
                                {{$area->area->sigla}} : {{$area->status->descricao or 'Sem Status'}}<br>
                              @endforeach
                            </td>
                            <td>{{$inscricao->regime}}</td>
                            <td>@if($inscricao->bolsa == 'S' || $inscricao->bolsa == 1) Sim @else Não @endif</td>
                            <td>
                                <a href="professor/inscricao/candidato/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary"><span class="glyphicon glyphicon-tasks" data-toggle="tooltip" data-placement="top" title="Inscrição"></span></button>
                                </a>
                                <a href="mensagem/create/?email={{$inscricao->usuario->email}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Enviar Mensagem"><span class="glyphicon glyphicon-envelope"></span></button>
                                </a>                                
                                @if(Session::has('perfil') && Session::get('perfil') == 1)
                                 <a href="adm/meusdados/dados-pessoais/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Dados Pessoais"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </a>
                                <a href="adm/inscricao/dados-inscricao/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Dados de Inscrição"><span class="glyphicon glyphicon-book"></span></button>
                                </a>
                                <a href="adm/meusdados/docencia/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Dados de Docência"><span class="glyphicon glyphicon-book"></span></button>
                                </a>
                                <a href="candidato/meusdados/outras-infos/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Outras Informações"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </a>
                                <a href="professor/inscricao/editar-situacao/{{$inscricao->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar Situação"><span class="glyphicon glyphicon-pencil"></span></button>
                                </a>
                                <a href="candidato/meusdados/formacao/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Formação"><span class="glyphicon glyphicon-folder-open"></span></button>
                                </a>
                                <a href="candidato/meusdados/experiencia/{{$inscricao->usuario->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Experiências Profissionais"><span class="glyphicon glyphicon-briefcase"></span></button>
                                </a>
                                <a href="professor/inscricao/editar-situacao-linha-lista/{{$inscricao->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar Situação de Linha"><span class="glyphicon glyphicon-pencil"></span></button>
                                </a>
                                @endif                                
                                <a href="documentos/show/{{$inscricao->usuario->id}}/{{$inscricao->periodo_id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Documentos (Anexos)"><span class="glyphicon glyphicon-paperclip"></span></button>
                                </a>
                                @if($inscricao->url_cv_lattes !== '')
                                <a href="{{$inscricao->url_cv_lattes}}" target="blank">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Currículo Lattes"><span class="glyphicon glyphicon-book"></span></button>
                                </a>
                                @endif
                            </td>
                         </tr>
                     @endforeach
                  @else
                    Nenhum registro encontrado.
                  @endif
                  </tbody>
               </table>
               @if(isset($inscricoes))
                {{$inscricoes->appends(array('periodo_id' => Input::get('periodo_id'),'pagination' => Input::get('pagination'),'tipo'=> $tipo,'nome' => Input::get('nome'),'status_linha_id' => Input::get('status_linha_id'), 'solicita_bolsa' => Input::get('solicita_bolsa'), 'status_inscricao_id' => Input::get('status_inscricao_id'),'linha_id'=>Input::get('linha_id')))->links()}}
               @endif
            </div>
         </div>
      </div>
   </section>
   <!-- </form> -->
</div>
@stop