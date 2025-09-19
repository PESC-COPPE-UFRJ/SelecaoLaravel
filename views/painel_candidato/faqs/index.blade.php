@extends('templates.master')
@section('css')
    
@stop
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {

        });

    </script>

@stop
@section('content')

<div class="page ng-scope">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> FAQ </strong></div>

        <div class="panel-body">

                <ul>
                @foreach($categorias as $categoria)
                    @if(count($categoria->faqs) > 0)
                        <li><a href="faqs/faq-detalhe/{{ $categoria->id }}">{{ $categoria->nome }}</a></li>
                    @endif
                @endforeach   
                </ul>

<!--             <accordion close-others="oneAtATime" class="ui-accordion">
                @foreach($categoria->faqs as $faq)
                <accordion-group heading="{{-- $faq->pergunta --}}" is-open="false">
                    {{-- $faq->resposta --}}
                </accordion-group>
                @endforeach
            </accordion>   -->          

        </div>

    </section>

</div>

@stop