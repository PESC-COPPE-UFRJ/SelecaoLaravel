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


@section('content')

<div class="page ng-scope">

<!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="get" action="professor/candidatos"> -->

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Linhas do candidato - {{$inscricao->usuario->nome}}</strong></div>

        <div class="panel-body">

            @include('elements.alerts')

            <div class="row">            

                <table class="table">
                    <thead>
                        <tr>
                            <th> Linha </th>
                            <th> Status </th>
                            <th> Ações </th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($inscricao->areasInscricoes)
                        @forelse($inscricao->areasInscricoes as $ai)
                        <tr>
                            <td>{{$ai->area->nome}}</td>
                            <td>{{$ai->status->descricao or 'Sem Status'}}</td>
                            <td>
                                <a href="professor/inscricao/historico-status/{{$ai->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Historico de Status"><span class="glyphicon glyphicon-list-alt"></span></button>
                                </a>

                                @if(Session::has('perfil') && Session::get('perfil') == 1)
                                
                                <a href="professor/inscricao/editar-situacao-linha-single/{{$ai->id}}">
                                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Editar Situação de Linha"><span class="glyphicon glyphicon-pencil"></span></button>
                                </a>

                                @endif
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    @endif
                    </tbody>
                </table>



            </div>

        </div>

    </section>

<!-- </form> -->

</div>
@stop