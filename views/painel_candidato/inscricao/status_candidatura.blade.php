@extends('templates.master')

@section('content')
<div class="page">

    <div class="panel panel-profile panel-profile-timeline">
        <div class="panel-heading clearfix">
            <h3>Status da Candidatura</h3>
        </div>
    </div>

    @include('elements.alerts')

    <section class="ui-timeline">
        <?php
        $i = 0;
        ?>
        @foreach($rows as $row)

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
                            {{ Formatter::getDataFormatada($row['pivot']['created_at']) }} <br />
                            <strong>
                                @if ($row['pivot']['professor_id'])
                                    Por professor {{Usuario::find($row['pivot']['professor_id'])->nome}}
                                @endif
                            </strong> <br />
                        </div>
                        <div class="tl-icon round-icon sm bg-info"><i class="fa fa-check"></i></div>
                        <div class="tl-content">
                            <h4 class="tl-tile text-primary">{{$row['descricao']}}</h4>
                            {{$row['pivot']['anotacoes']}}
                        </div>
                    </div>
                </div>
            </article>
            <?php $i++ ?>
        @endforeach

    </section>


    {{$paginate}}

</div>
@stop