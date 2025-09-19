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

    <script type="text/javascript">

        $(document).ready(function()
        {

          $("#mudarStatus").click(function(){
            var confirmAtualizar = confirm("Se você fez alguma alteração nas notas deste candidato, suas alterações só serão salvas se você clicar em 'Atualizar Notas', Deseja continuar?");
            if(confirmAtualizar){
                window.location.href = '{{URL::to("professor/inscricao/editar-situacao/$inscricao->id")}}';
            }
            return false;
          });

        });

    </script>

@stop

@section('content')

@include('elements.alerts')

{? $tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo') ?}

<div class="page ng-scope">
   <!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->
   <section class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Provas do candidato {{$usuario->nome}} </strong></div>
      <div class="panel-body">

         <div class="row">
            <div class="col-sm-12">
               <div class="btn-toolbar" role="toolbar">
                  <div class="pull-left">
                     <h2></h2>
                  </div>
               </div>
               <br>
               <h2> Periodo: {{$periodo->ano}} - {{$periodo->periodo}} </h2>
               <form action="{{URL::to("nota/salvar?tipo=$tipo")}}" method="POST">
                <input type="hidden" name="inscricao_id" value="{{$inscricao->id}}" />
                 <table class="table">
                    <thead>
                       <tr>
                          <th>
                             <!-- <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=usuario.nome">
                             <span class="glyphicon glyphicon-arrow-up"></span>
                             </a>
                             <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=-usuario.nome">
                             <span class="glyphicon glyphicon-arrow-down"></span>
                             </a> -->
                             Identificador
                          </th>
                          <th>
                             Tipo
                          </th>
                          <th>
                             Area
                          </th>
                          <th>
                             Nota
                          </th>
                          <th>
                             Status
                          </th>
                          <th>
                          </th>
                       </tr>
                    </thead>
                    <tbody>
                    @if(isset($provas) && !$provas->isEmpty())
                       @foreach($provas as $prova)
                           <tr>
                              <td>{{$prova->identificador}}</td>
                              <td>{{$prova->tipo}}</td>
                              <td>{{$prova->area->nome}}</td>
                              <td><input type="text" name="provas[{{$prova->id}}][nota]" class="" value="{{$prova->pivot->nota}}" /></td>
                              <td><input type="text" name="provas[{{$prova->id}}][status]" class="" value="{{$prova->pivot->status}}" /></td>
                              <td>                    
                                  
                              </td>
                           </tr>
                       @endforeach
                    @else
                      Nenhum registro encontrado.
                    @endif                    
                    </tbody>
                 </table>

                 {? $perfil_ativo = Session::get('perfil_ativo') ?}

                 @if(isset($provas) && !$provas->isEmpty() && $perfil_ativo->nome != 'Comissão de Bolsas')
                  <input type="submit" id="enviar" class="btn btn-sm btn-primary" value="Atualizar Notas">
                 @endif
                 @if(Session::has('perfil') && Session::get('perfil') == 1)
                  <a href="professor/inscricao/editar-situacao/{{$inscricao->id}}" class="btn btn-sm  btn-primary" id="mudarStatus" data-toggle="tooltip" data-placement="top" title="Editar Situação">
                      Mudar status
                  </a>
                 @endif
               </form>
               @if(isset($inscricoes))
                {{$inscricoes->links()}}
               @endif
               
            </div>
         </div>
      </div>
   </section>
   <!-- </form> -->
</div>
@stop