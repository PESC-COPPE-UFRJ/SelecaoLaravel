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

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function()
        {


        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="post" action="professor/inscricao/poscomp" enctype="multipart/form-data">

    <input type="hidden" name="tipo" value="{{ Input::get('tipo') }}">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> POSCOMP</strong></div>

        <div class="panel-body">        

            <div class="row">
                <div class="col-sm-2 col-centered">
                    <select>
                        <option value="2015/1">2015/1</option>
                    </select>
                </div>
            </div>

            <br/>

            <div class="row">
                <div class="col-sm-6 col-centered">

                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Nome</td>
                                <td>{{ $usuario->nome }}</td>
                            </tr>
                            <tr>
                                <td>Ano</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Situação</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>CPF</td>
                                <td>{{ $usuario->cpf }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">Notas:</td>
                            </tr>
                            <tr>
                                <td>Nota de Fundamentos</td>
                                <td>{{ $usuario->poscomp_nota1 }}</td>                                
                            </tr>
                            <tr>
                                <td>Nota de Tecnologia</td>
                                <td>{{ $usuario->poscomp_nota2 }}</td>                                
                            </tr>
                            <tr>
                                <td>Nota de Matemática</td>
                                <td>{{ $usuario->poscomp_nota3 }}</td>                                
                            </tr>
                            <tr>
                                <td>Média</td>
                                <td>{{ $usuario->poscomp_media }}</td>                                
                            </tr>                            
                        </tbody>
                    </table>                    
                </div>                

            </div>

            <div class="row">
                <div class="col-sm-2 col-centered">
                    <a href="professor/inscricao/poscomp" class="btn btn-default">Voltar</a>
                </div>
            </div>

        </div>

    </section>

</form>

</div>
@stop