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


        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo') ?}

<div class="page ng-scope">
   <!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->
   <section class="panel panel-default">
      <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Inscrições/Periodos do Candidato {{$usuario->nome}} </strong></div>
      <div class="panel-body">

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
                           <!-- <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=usuario.nome">
                           <span class="glyphicon glyphicon-arrow-up"></span>
                           </a>
                           <a href="professor/inscricao/lista-candidatos?tipo=m&amp;ord=-usuario.nome">
                           <span class="glyphicon glyphicon-arrow-down"></span>
                           </a> -->
                           Ano
                        </th>
                        <th>
                           Periodo
                        </th>
                        <th>
                           Curso
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
                            <td>{{$inscricao->periodo->ano}}</td>
                            <td>{{$inscricao->periodo->periodo}}</td>
                            <td>{{$inscricao->curso}}</td>
                            <td>{{$inscricao->regime}}</td>
                            <td>@if($inscricao->bolsa == 'S') Sim @else Não @endif</td>
                            <td>                    
                                <a href="nota/provas/{{$inscricao->id}}/?tipo={{$tipo}}">
                                    <button class="btn btn-primary"><span class="glyphicon glyphicon-tasks"></span></button>
                                </a>
                            </td>
                         </tr>
                     @endforeach
                  @else
                    Nenhum registro encontrado.
                  @endif                    
                  </tbody>
               </table>
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