@extends('templates.master')
@section('css')
    
@stop
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function() {
            $('.remove').click(function(){
                var txt = "Deseja deletar esta categoria?";
                var qtdfaq = $(this).attr('qtdfaq');
                if(qtdfaq>0){
                    txt += " Esta categoria tem "+qtdfaq+" pergunta(s) que também será(ão) deletada(s)!";
                }
                var confirmDelete = confirm(txt);
                if(confirmDelete){
                    var id = $(this).attr('questionid');
                    window.location.href = "faqs/delete-categoria?idCategoria="+id;
                }
            })
        });

    </script>

@stop
@section('content')

<div class="page ng-scope">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Lista de Categorias</strong></div>

        <div class="panel-body">        

            <div class="pull-right">
                <a href="faqs/nova-categoria" class="btn btn-default">Nova Categoria</a>
            </div>

            {{ $filter }}          

            {{ $grid }}

            <div class="pull-right">
                <a href="faqs/lista" class="btn btn-primary">Voltar</a>
            </div>
        </div>

    </section>

</div>

@stop