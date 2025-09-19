@extends('templates.master') @section('css')

<style type="text/css">
    .row-centered {
        text-align: center;
    }
    
    .col-centered {
        float: none;
        margin: 0 auto;
    }
</style>

@stop @section('scripts')

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>

@stop @section('content') {{ HTML::ul($errors->all()) }} {? $id = Input::get('show') ?}

<div class="page ng-scope">

    <!-- <form class="form-horizontal ng-pristine ng-valid outrasinfos" role="form" method="POST" action="candidato/doutorado/candidatarse"> -->

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Lista de Dados</strong></div>

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-9">
                    {{ $candidato->nome }}
                </div>

                <div class="col-sm-3">
                    <a class="btn btn-warning" href="professor/inscricao/dados-csv?id={{ $candidato->id }}"><span class="glyphicon glyphicon-download-alt"></span> &nbsp;.csv</a>
                    <a class="btn btn-warning" href="professor/inscricao/dados-pdf?id={{ $candidato->id }}"><span class="glyphicon glyphicon-print"></span> &nbsp;.pdf</a>
                    <a class="btn btn-warning" href="professor/inscricao/dados-rm-pdf?id={{ $candidato->id }}"><span class="glyphicon glyphicon-print"></span> &nbsp;RM (pdf)</a>
                </div>
            </div>

            <div class="row">
                <hr/>
            </div>

            <div class="row">

                <div class="col-sm-5">
                    @if(isset($candidato))

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
                                    @if($candidato->estrangeiro == 1) Sim @else Não @endif
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
                                    {{ $candidato->endereco->endereco }} {{ $candidato->endereco->cep }}
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
                    @endif @if(isset($poscomps) && $poscomps->count() > 0) {? $contadorPoscomp = 0; ?}
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Lista de POSCOMP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($poscomps as $poscomp)
                                    <table class="table" style="background-color: #fff;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">
                                                    POSCOMP {{ ($contadorPoscomp+1) }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Inscrição</td>
                                                <td>{{ $poscomp->codigo_inscricao }}</td>
                                            </tr>
                                            <tr>
                                                <td>Presença</td>
                                                <td>@if($poscomp->presenca) Presente @else Faltou @endif</td>
                                            </tr>
                                            <tr>
                                                <td>TEC</td>
                                                <td>{{ $poscomp->tec }}</td>
                                            </tr>
                                            <tr>
                                                <td>FUNC</td>
                                                <td>{{ $poscomp->fun }}</td>
                                            </tr>
                                            <tr>
                                                <td>MAT</td>
                                                <td>{{ $poscomp->mat }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pontuação</td>
                                                <td>{{ $poscomp->pontos }}</td>
                                            </tr>
                                            <tr>
                                                <td>Local</td>
                                                <td>{{ $poscomp->local }}</td>
                                            </tr>
                                            <tr>
                                                <td>Ano</td>
                                                <td>{{ $poscomp->ano }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {? $contadorPoscomp++; ?} @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                    @if(!$candidato->inscricoes->isEmpty()) {? $contador3 = 0; ?}
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Inscrições</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @forelse($candidato->inscricoes as $inscricao)
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
                                                <td> @if($inscricao->periodo) {{ $inscricao->periodo->ano}}/{{ $inscricao->periodo->periodo or 0 }} @else Sem Periodo @endif</td>
                                            </tr>
                                            <tr>
                                                <td>Situação</td>
                                                <td>{{ $inscricao->status->last()->descricao or 'Sem Status' }} </td>
                                            </tr>
                                            <tr>
                                                <td>Linha</td>
                                                <td>
                                                    @forelse ($inscricao->areas as $area) {{$area->sigla}} @empty
                                                    <p> Nenhuma linha até o momento </p>
                                                    @endforelse
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Curso</td>
                                                <td>
                                                    @if($inscricao->curso == 'MSC') Mestrado @else Doutorado @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Regime</td>
                                                <td>
                                                    @if($inscricao->regime == 'PARC') Parcial @else Integral @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Bolsa</td>
                                                <td>
                                                    @if($inscricao->bolsa == 1 || $inscricao->bolsa == 'S') Sim @else Não @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Vínculo Empregatício</td>
                                                <td>
                                                    @if($inscricao->trabalha == 'S') Sim @else Não @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {? $contador3++; ?} @empty
                                    <p> Nenhuma Inscrição até o momento </p>
                                    @endforelse
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>

                <div class="col-sm-1">
                    <table style="width: 3px; height: 700px;" align="center">
                        <tr>
                            <td style="background-color: #EAEAEA;">&nbsp;</td>
                        </tr>
                    </table>
                </div>

                @if(isset($candidato->formacoes) && $candidato->formacoes->count() > 0)
                <div class="col-sm-5">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Formação Superior</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {? $contador = 0; ?} @foreach($candidato->formacoes as $formacao)
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
                                                <td>{{ @number_format( (float)$formacao->cr, 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nota máxima</td>
                                                <td>{{ @number_format( (float)$formacao->media_maxima, 2, '.', '') }}</td>
                                            </tr>
                                            <tr>
                                                <td>% de rendimento</td>
                                                <td>
                                                    @if(!empty($formacao->cr) && !empty($formacao->media_maxima) && ($formacao->media_maxima != 0.0)) {{ @number_format(( (float) $formacao->cr / (float) $formacao->media_maxima) * 100.0, 2, '.', '') }} @else 0 @endif %
                                                </td>
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
                                    {? $contador++; ?} @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif @if(isset($candidato->experiencias) && $candidato->experiencias->count() > 0) {? $contador2 = 0; ?}
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
                                    {? $contador2++; ?} @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif 
                    @if(isset($candidato->docencias) && $candidato->docencias->count() > 0) {? $contador4 = 0; ?}
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Docências</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($candidato->docencias as $docencia)
                                    <table class="table" style="background-color: #fff;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">
                                                    Docência {{ ($contador4+1) }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Instituição</td>
                                                <td>{{ $docencia->instituicao }}</td>
                                            </tr>
                                            <tr>
                                                <td>País</td>
                                                <td>{{ $docencia->pais }}</td>
                                            </tr>
                                            <tr>
                                                <td>Estado</td>
                                                <td>{{ $docencia->estado }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tipo</td>
                                                <td>{{ $docencia->tipo }}</td>
                                            </tr>
                                            <tr>
                                                <td>Departamento</td>
                                                <td>{{ $docencia->departamento }}</td>
                                            </tr>
                                            <tr>
                                                <td>Nível</td>
                                                <td>{{ $docencia->nivel }}</td>
                                            </tr>
                                            <tr>
                                                <td>Disciplina</td>
                                                <td>{{ $docencia->disciplina }}</td>
                                            </tr>
                                            <tr>
                                                <td>Desde</td>
                                                <td>{{ $docencia->desde }}</td>
                                            </tr>
                                            <tr>
                                                <td>Até</td>
                                                <td>{{ $docencia->ate }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {? $contador4++; ?} @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif 

                    @if(isset($candidato->premios) && $candidato->premios->count() > 0) {? $contador5 = 0; ?}
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Prêmios e Distinções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach($candidato->premios as $premios)
                                    <table class="table" style="background-color: #fff;">
<!--                                    <thead>
                                            <tr>
                                                <th colspan="2" class="text-center">
                                                    Prêmio/Distinção {{ ($contador5+1) }}
                                                </th>
                                            </tr>
                                        </thead> -->
                                        <tbody>
                                            <tr>
                                                <td width="20%">{{ ($contador5+1) }}</td>
                                                <td>{{ $premios->nome }}</td>
                                            </tr>                   
                                        </tbody>
                                    </table>
                                    {? $contador5++; ?} 
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif 
                    
                    
                </div>

            </div>

            <div class="row">

                <div class="col-sm-2 col-centered">
                    <a class="btn btn-warning" href="professor/inscricao/dados-csv?id={{ $candidato->id }}"><span class="glyphicon glyphicon-download-alt"></span> &nbsp;.csv</a>
                    <a class="btn btn-warning" href="professor/inscricao/dados-pdf?id={{ $candidato->id }}"><span class="glyphicon glyphicon-print"></span> &nbsp;.pdf</a>
                </div>

            </div>

        </div>

    </section>

    <!-- </form> -->

</div>
@stop