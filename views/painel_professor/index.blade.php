@extends('templates.master')
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
    });
</script>
@stop
@section('content')

{? $foto = Auth::user()->foto != '' ? Auth::user()->foto : 'images/assets/no-photo.png'; ?}

<div class="page page-table">

    <div class="row">
        <div class="col-sm-6">
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
                    @if($_SERVER['HTTP_HOST'] == "ufrj.dev")
                    <li class="list-group-item">
                        <span class="badge badge-warning">2</span>
                        <i class="fa fa-tasks"></i>
                        Atividades pendentes
                    </li>
                    @endif
                    <li class="list-group-item">
                        <span class="badge badge-info">{{ count($mensagem) }}</span>
                        <i class="fa fa-envelope-o"></i>
                        Mensagens não lidas
                    </li>
                    @if($_SERVER['HTTP_HOST'] == "ufrj.dev")
                    <li class="list-group-item">
                        <span class="badge badge-success">3</span>
                        <i class="fa fa-check-square-o"></i>
                        itens incompletos
                    </li>
                    @endif
                </ul>
            </div>
            <!-- end Pofile panel -->
        </div>
<!--         <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-transform: capitalize !important;"><strong><span class="glyphicon glyphicon-th"></span> Notícias/Adicionar Conteúdo</strong></div>
                <div class="panel-body">
                    {{-- $formNoticia --}}
                </div>
            </div>
        </div> -->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-transform: capitalize !important;"><strong><span class="glyphicon glyphicon-th"></span> Meus Candidatos</strong></div>
                <div class="panel-body">
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <tabset class="ui-tab">
                                <tab heading="Mestrado">
                                    {{ $gridMestrado }}
                                </tab>                      
                            </tabset>
                        </div>
                        <div class="col-sm-6">
                            <tabset class="ui-tab">                   
                                <tab heading="Doutorado">
                                    {{ $gridDoutorado }}
                                </tab>                      
                            </tabset>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript">

    $(document).ready(function()
    {
        @if(Session::has('success') || Session::get('danger') || Session::get('info') || Session::get('warning'))
            $("#ModalAlerta").modal('show');
        @else
            $("#ModalAlerta").modal('hide');
        @endif
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