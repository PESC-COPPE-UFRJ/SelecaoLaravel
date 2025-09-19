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

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> FAQ</strong></div>

        <div class="panel-body">        

            <form action="faqs/nova" method="post">

                {{ $form->render('categoria.nome') }}
                {{ $form->render('pergunta') }}
                {{ $form->render('resposta') }}
                {{ $form->render('publicado') }}
                {{ $form->render('ordem') }}

                <input type="hidden" name="usuario" value="{{ Auth::user()->nome }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
            
                <button type="submit" class="glyphicon glyphicon-check">Salvar</button>

            </form>
        </div>

    </section>

</div>

@stop