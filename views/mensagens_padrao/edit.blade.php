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

<div class="page">
    <div class="page ng-scope">
        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Mensagem Padrão - Editando {{$mensagem->titulo}}</strong></div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{URL::to("adm/mensagem_padrao/$mensagem->id")}}" method="POST">
                    <input type="hidden" name="_method" value="PUT" />
                    <fieldset>
                        <!-- Form Name -->
                        <legend>Mensagem Padrão</legend>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="titulo">Titulo:</label>
                            <div class="col-md-5">
                                <input id="titulo" name="titulo" type="text" placeholder="Ex: mensagem de aprovação" class="form-control input-md" required="" value="{{$mensagem->titulo}}">
                                <span class="help-block">Titulo da mensagem, para identificação.</span>
                            </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="mensagem">Mensagem:</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="mensagem" name="mensagem">{{$mensagem->mensagem}}</textarea>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="salvar"></label>
                            <div class="col-md-4">
                                <button type="submit" id="salvar" name="salvar" class="btn btn-primary">Atualizar</button>
                            </div>
                        </div>

                        @include('infos.variaveis_de_msg')

                    </fieldset>
                </form>

            </div>
        </section>
    </div>
</div>
@stop