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
            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span>Patch Scripts</strong></div>
            <div class="panel-body">
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
                                Descrição
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        Scripts
                            <tr>
                                <td>Corrige esturura de diretórios para uploads</td>
                                <td>Move os canidatos para pastas usuarios, e organiza arquivos. Todos documentos associados
                                a um usuário fica na sua pasta e não mais espalhados de acordo com o tipo de documento. Para cada
                                inscrição cria uma pasta com o id dentro da pasta do usuário para guardar os docs associados a esta
                                inscrição. Para docs por área de pesquisa (ex Plano de Pesquisa) cria uma pasta por área dentro
                                da pasta da inscrição.                                
                                </td>
                                <td>                    
                                    <a href="adm/scripts/1/edit">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </a>
                                </td>
                            </tr>  
                            <tr>
                                <td>Formata as notas</td>
                                <td>Formata todas as notas com ponto como separador decimal.                        
                                </td>
                                <td>                    
                                    <a href="adm/scripts/2/edit">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </a>
                                </td>
                            </tr>  
                            <tr>
                                <td>Formata os status das notas</td>
                                <td>Formata os staus colocando APROVADO ou REPROVADO quando existir nota numérica, ou FALTOU quando
                                    estiver marcado falta no banco de dados.
                                </td>
                                <td>                    
                                    <a href="adm/scripts/3/edit">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </a>
                                </td>
                            </tr>  
                             <tr>
                                <td>Padroniza status bolsas</td>
                                <td>Formata os valores para S/N, alguns estão como null ou 1/0
                                </td>
                                <td>                    
                                    <a href="adm/scripts/4/edit">
                                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </a>
                                </td>
                            </tr>  
                        
                    </tbody>
                </table>

            </div>
        </section>
    </div>
</div>
@stop