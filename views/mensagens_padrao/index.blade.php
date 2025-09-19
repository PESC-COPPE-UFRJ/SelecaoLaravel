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
        @include('elements.alerts')
        <section class="panel panel-default">
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Mensagem Padrão</strong></div>
            <div class="panel-body">
                <div class="pull-right">
                    <a href="{{URL::to('adm/mensagem_padrao/create')}}" class="btn btn-default">Nova Mensagem Padrão</a>
                </div>
                <!-- <form method="GET" action="faqs/lista?search=1" accept-charset="UTF-8" class="form-inline ng-pristine ng-valid" role="form">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="pull-left">
                            <h2></h2>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="pergunta" class="sr-only">Pergunta</label>
                        <span id="div_pergunta">
                        <input class="form-control" placeholder="Pergunta" type="text" id="pergunta" name="pergunta">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="resposta" class="sr-only">Resposta</label>
                        <span id="div_resposta">
                        <input class="form-control" placeholder="Resposta" type="text" id="resposta" name="resposta">
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="categoria_nome" class="sr-only">Linha</label>
                        <span id="div_categoria_nome">
                            <select class="form-control" placeholder="Linha" type="select" id="categoria_nome" name="categoria_nome">
                                <option value="1">Notícias em Geral</option>
                                <option value="2">Mambo Open Source</option>
                                <option value="7">Acadêmicos</option>
                                <option value="9">Página Principal</option>
                                <option value="13">Contato</option>
                                <option value="14">Seleção 2006</option>
                                <option value="16">Acesso ao Portal</option>
                                <option value="17">Processo de Seleção</option>
                                <option value="18">Linhas de Pesquisa</option>
                                <option value="19">Processo de Seleção</option>
                                <option value="20">Seleção 2007</option>
                                <option value="21">Documentação</option>
                                <option value="22">Seleção 2007</option>
                                <option value="23">Informações aos Candidatos</option>
                                <option value="24">Cursos de Mestrado e Doutorado</option>
                                <option value="25">Arquivos</option>
                                <option value="26">Matrícula no PESC</option>
                                <option value="28">Seleção 2008</option>
                                <option value="29">Seleção 2008</option>
                                <option value="31">Seleção 2009</option>
                                <option value="33">Seleção 2009</option>
                                <option value="35">Seleção 2009/2</option>
                                <option value="36">Seleção 2010</option>
                                <option value="37">Seleção 2011</option>
                                <option value="38">Seleção 2012</option>
                                <option value="39">Seleção 2013</option>
                                <option value="40">Seleção 2014</option>
                                <option value="41">Seleção 2015</option>
                            </select>
                        </span>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Pesquisar">
                    <input name="search" type="hidden" value="1">
                </form> -->
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
                                Titulo
                            </th>
                            <th>
                                Mensagem
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mensagens as $mensagem)
                            <tr>
                                <td>{{$mensagem->titulo}}</td>
                                <td>{{$mensagem->mensagem}}</td>
                                <td>                    
                                    <a href="adm/mensagem_padrao/{{$mensagem->id}}/edit">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </a>
                                </td>
                            </tr>  
                        @endforeach      
                    </tbody>
                </table>

            </div>
        </section>
    </div>
</div>
@stop