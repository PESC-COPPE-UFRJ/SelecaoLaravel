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

        $(document).ready(function() {

        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = Input::get('tipo'); ?}

<div class="page ng-scope">

<!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="POST" action="candidato/doutorado/candidatarse"> -->

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Impressão</strong></div>

        <div class="panel-body">        

            <div class="row">
                <div class="col-sm-9">
                    Impressão somente para conferência. <strong>ESTA NÃO É VÁLIDA PARA INSCRIÇÃO.</strong>
                </div>
                
                <div class="col-sm-3">
                    <a class="btn btn-warning" href="candidato/inscricao/dados-csv?tipo={{ $tipo }}"><span class="glyphicon glyphicon-download-alt"></span> &nbsp;.csv</a>
                </div>
            </div>

            <div class="row">
                <hr/>
            </div>

            <div class="row">

                <div class="col-sm-6 text-center">
                    <img src="images/logo_pesc.jpg" alt="PESC" title="PESC" border="0"/>
                </div>
                <div class="col-sm-6">
                    <h1 align="right">Lista de dados para candidatura "Seleção {{$periodo->ano}}/{{$periodo->periodo}}"</h1>
                    <h3 align="right">Esta não é válida para inscrição!</h3>
                </div>
                
            </div>

            <div class="row">

                <div class="col-sm-5">
                    {{--@if(isset($candidato))--}}

                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Dados Pessoais</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nome</td>
                                <td>{{ $candidato->nome }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $candidato->email }}</td>
                            </tr>
                            <tr>
                                <td>Sexo</td>
                                <td>{{ $candidato->sexo }}</td>
                            </tr>
                            <tr>
                                <td>Nascimento</td>
                                <td>{{ $candidato->nascimento }}</td>
                            </tr>
                            <tr>
                                <td>Cidade de Nascimento</td>
                                <td>{{ $candidato->cidadenasc }}</td>
                            </tr>
                            <tr>
                                <td>É Estrangeiro?</td>
                                <td>
                                    @if($candidato->estrangeiro == 1)
                                        Sim
                                    @else
                                        Não
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Nacionalidade</td>
                                <td>{{ $candidato->nacionalidade }}</td>
                            </tr>
                            <tr>
                                <td>Estado Civil</td>
                                <td>{{ $candidato->estcivil }}</td>
                            </tr>
                            @if($candidato->endereco!=null)
                                <tr>
                                    <td>Endereco</td>
                                    <td>
                                        {{ $candidato->endereco->endereco }}
                                        {{ $candidato->endereco->cep }}
                                    </td>
                                </tr>      
                                <tr>
                                    <td>Bairro</td>
                                    <td>{{ $candidato->endereco->bairro }}</td>
                                </tr>
                                <tr>
                                    <td>Cidade</td>
                                    <td>{{ $candidato->endereco->cidade }}</td>
                                </tr>                                
                                <tr>
                                    <td>Estado</td>
                                    <td>{{ $candidato->endereco->estado }}</td>
                                </tr>
                                <tr>
                                    <td>Pais</td>
                                    <td>{{ $candidato->endereco->pais }}</td>
                                </tr>
                            @endif                            
                            <tr>
                                <td>Identidade</td>
                                <td>{{ $candidato->ident }}</td>
                            </tr>
                            <tr>
                                <td>Data de Expedição</td>
                                <td>{{ $candidato->expedicao }}</td>
                            </tr>
                            <tr>
                                <td>Orgão expedidor</td>
                                <td>{{ $candidato->orgaoexped }}</td>
                            </tr>
                            <tr>
                                <td>Estado de Expedição</td>
                                <td>{{ $candidato->estexped }}</td>
                            </tr>
                            <tr>
                                <td>CPF</td>
                                <td>{{ $candidato->cpf }}</td>
                            </tr>
                            <tr>
                                <td>Passaporte</td>
                                <td>{{ $candidato->passaporte }}</td>
                            </tr>
                            <tr>
                                <td>Titulo de eleitor</td>
                                <td>{{ $candidato->tituloeleitor }}</td>
                            </tr>
                            <tr>
                                <td>Certificado Militar</td>
                                <td>{{ $candidato->certmilitar }}</td>
                            </tr>
                        </tbody>
                    </table>
                    {{--@endif--}}
                </div>

                <div class="col-sm-1">
                    <table style="width: 3px; height: 700px;" align="center">
                        <tr>
                            <td style="background-color: #EAEAEA;">&nbsp;</td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-5">
                    @if(isset($candidato->formacoes) && $candidato->formacoes->count() > 0)
                    {? $contador = 0; ?}                
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Formação Superior</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($candidato->formacoes as $formacao)
                                        <table class="table" style="background-color: #fff;">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        Formação {{ ($contador+1) }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Formação</td>
                                                    <td>{{ $formacao->formacao }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Concluído?</td>
                                                    <td>{{ $formacao->concluido }}</td>
                                                </tr>                                                    
                                                <tr>
                                                    <td>Instituição</td>
                                                    <td>{{ $formacao->instituicao }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Estado</td>
                                                    <td>{{ $formacao->estado }}</td>
                                                </tr>
                                                <tr>
                                                    <td>País</td>
                                                    <td>{{ $formacao->pais }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Curso</td>
                                                    <td>{{ $formacao->curso }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Coeficiente de Rendimento</td>
                                                    <td>{{ $formacao->cr }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ano de Início</td>
                                                    <td>{{ $formacao->ano_inicio }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Ano de Término</td>
                                                    <td>{{ $formacao->ano_fim }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {? $contador++; ?}
                                    @endforeach                                    
                                </td>
                            </tr>   
                        </tbody>
                    </table>
                    @endif

                    @if(isset($candidato->experiencias) && $candidato->experiencias->count() > 0)
                    {? $contador2 = 0; ?}                
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Experiências Profissionais</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($candidato->experiencias as $experiencia)
                                        <table class="table" style="background-color: #fff;">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        Experiência {{ ($contador2+1) }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Empresa</td>
                                                    <td>{{ $experiencia->empresa }}</td>
                                                </tr>                                            
                                                <tr>
                                                    <td>Função</td>
                                                    <td>{{ $experiencia->funcao }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Endereço</td>
                                                    <td>{{ $experiencia->endereco }}</td>
                                                </tr>                                                    
                                                <tr>
                                                    <td>Admissão</td>
                                                    <td>{{ $experiencia->admissao }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Demissão</td>
                                                    <td>{{ $experiencia->demissao }}</td>
                                                </tr>                                            
                                            </tbody>
                                        </table>
                                        {? $contador2++; ?}
                                    @endforeach                                    
                                </td>
                            </tr>   
                        </tbody>
                    </table>
                    @endif
                    @if(!$candidato->inscricoes->isEmpty())
                    {? $contador3 = 0; ?}                
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Inscrições</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($candidato->inscricoes as $inscricao)
                                        <table class="table" style="background-color: #fff;">
                                            <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        Inscrição {{ ($contador3+1) }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Ano/Periodo</td>
                                                    <td>{{ $inscricao->periodo->ano }}/{{ $inscricao->periodo->periodo }}</td>
                                                </tr>                                            
                                                <tr>
                                                    <td>Situação</td>
                                                    <td>{{ $inscricao->status->last()->descricao }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Linha</td>
                                                    <td>
                                                        @foreach ($inscricao->areas as $area)
                                                            {{$area->sigla}}
                                                        @endforeach
                                                    </td>
                                                </tr>                                                    
                                                <tr>
                                                    <td>Regime</td>
                                                    <td>
                                                        @if($inscricao->regime == 'PARC')
                                                            Parcial
                                                        @else
                                                            Integral
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bolsa</td>
                                                    <td>
                                                        @if($inscricao->bolsa == 0)
                                                            Não
                                                        @else
                                                            Sim
                                                        @endif
                                                    </td>
                                                </tr>                                            
                                            </tbody>
                                        </table>
                                        {? $contador3++; ?}
                                    @endforeach                                    
                                </td>
                            </tr>   
                        </tbody>
                    </table>
                    @endif                                                    
                </div>
                
            </div>

<!--             <div class="row">

                <div class="col-sm-6">c</div>
                <div class="col-sm-6">d</div>
                
            </div> -->

        </div>

    </section>

<!-- </form> -->

</div>
@stop