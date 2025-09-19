@extends('templates.master')

@section('content')
<div class="page">

    <div class="panel panel-profile panel-profile-timeline">
        <div class="panel-heading clearfix">
            <h3>Historico de linha - {{$area_nome}}</h3>
            <h4> Candidato - {{$candidato->nome}} </h4>
        </div>
    </div>

    @include('elements.alerts')

    @if($rows->isEmpty())
        <div class="alert alert-warning">
            <a class="close" data-dismiss="alert">×</a>
            <h4 class="alert-heading"> Atenção! </h4>
            Esta linha ainda não possui nenhum status.
        </div>
    @endif

    <section class="ui-timeline">
        <?php
        $i = 0;
        ?>
        @forelse($rows as $row)

            <?php
            if ( $i & 1 ) {
              $alt = 'alt';
            } else {
              $alt = '';
            }
            ?>

            <article class="tl-item {{$alt}}">
                <div class="tl-body">
                    <div class="tl-entry">
                        <div class="tl-time">
                            {{ Formatter::getDataFormatada($row->created_at) }} <br />
                            <strong>
                                @if ($row->professor_id)
                                    Por professor {{Usuario::find($row->professor_id)->nome}}
                                @endif
                            </strong> <br />
                        </div>
                        <div class="tl-icon round-icon sm bg-info"><i class="fa fa-check"></i></div>
                        <div class="tl-content">
                            <h4 class="tl-tile text-primary">{{$row->status->descricao}}</h4>
                            {{$row->anotacoes}}
                        </div>
                    </div>
                </div>
            </article>
            <?php $i++ ?>

        @empty

        @endforelse

    </section>


    {{$paginate}}

</div>
@stop