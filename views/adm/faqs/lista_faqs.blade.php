@extends('templates.master')
@section('css')
    
@stop
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {
            $('.remove').click(function(){
                var confirmDelete = confirm("Deseja deletar esta pergunta?");
                if(confirmDelete){
                    var id = $(this).attr('questionid');
                    window.location.href = "faqs/delete?idPergunta="+id;
                }
            })
        });

    </script>

@stop
@section('content')

<div class="page ng-scope">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> FAQ</strong></div>

        <div class="panel-body">        
            
            <div class="pull-right">
                <a href="faqs/nova" class="btn btn-default">Nova FAQ</a>
            </div>

            <div class="pull-right" style="padding-right:8px;">
                <a href="faqs/categoria-lista" class="btn btn-default">Lista de Categorias</a> 
            </div>

            <!-- {{ $filter }}           -->

            {{ $grid }}

        </div>

    </section>

</div>

@stop