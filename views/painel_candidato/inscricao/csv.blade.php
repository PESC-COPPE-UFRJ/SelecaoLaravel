<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CSV</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Sexo</th>
                <th>Nascimento</th>
                <th>Cidade de Nascimento</th>
                <th>É Estrangeiro?</th>
                <th>Nacionalidade</th>
                <th>Estado Civil</th>
                <th>Endereco</th>
                <th>Identidade</th>
                <th>Data de Expedição</th>
                <th>Orgão expedidor</th>
                <th>Estado de Expedição</th>
                <th>CPF</th>
                <th>Passaporte</th>
                <th>Titulo de eleitor</th>
                <th>Certificado Militar</th>
                <!-- Formacoes -->
                @if(isset($candidato->formacoes) && $candidato->formacoes->count() > 0)
                    @for($i=0;$i<$candidato->formacoes->count();$i++)                        
                        <th>Formação</th>
                        <th>Tipo de Formação</th>
                        <th>Concluído?</th>
                        <th>Instituição</th>
                        <th>Estado</th>
                        <th>País</th>
                        <th>Curso</th>
                        <th>Coeficiente de Rendimento</th>
                        <th>Ano de Início</th>
                        <th>Ano de Término</th>
                    @endfor
                @endif
                <!-- /Formacoes -->                
                <!-- Experiencias -->
                @if(isset($candidato->experiencias) && $candidato->experiencias->count() > 0)                
                    @for($j=0;$j<$candidato->experiencias->count();$j++)
                        <th>Experiência</th>
                        <th>Empresa</th>
                        <th>Função</th>
                        <th>Endereço</th>
                        <th>Admissão</th>
                        <th>Demissão</th>
                    @endfor
                @endif
                <!-- Experiencias -->
                <!-- Inscricoes -->
                @if($candidato->inscricoes->count())
                    @for($k=0;$k<$candidato->inscricoes->count();$k++)
                        <th>Inscrições</th>
                        <th>Ano/Periodo</th>
                        <th>Situação</th>
                        <th>Linha</th>
                        <th>Regime</th>
                        <th>Bolsa</th>
                    @endfor
                @endif
                <!-- Inscricoes -->   
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $candidato->nome }}</td>
                <td>{{ $candidato->email }}</td>
                <td>{{ $candidato->sexo }}</td>
                <td>{{ $candidato->nascimento }}</td>
                <td>{{ $candidato->cidadenasc }}</td>
                <td>
                   @if($candidato->estrangeiro == 1)
                        Sim
                   @else
                        Não
                   @endif
                </td>
                <td>{{ $candidato->nacionalidade }}</td>
                <td>{{ $candidato->estcivil }}</td>
                <td>
                    @if($candidato->endereco!=null)
                    {{ $candidato->endereco->endereco }} - 
                    {{ $candidato->endereco->bairro }} - {{ $candidato->endereco->cep }}
                    {{ $candidato->endereco->cidade }} - {{ $candidato->endereco->estado }} - {{ $candidato->endereco->pais }}
                    @endif
                </td>
                <td>{{ $candidato->ident }}</td>
                <td>{{ $candidato->expedicao }}</td>
                <td>{{ $candidato->orgaoexped }}</td>
                <td>{{ $candidato->estexped }}</td>
                <td>{{ $candidato->cpf }}</td>
                <td>{{ $candidato->passaporte }}</td>
                <td>{{ $candidato->tituloeleitor }}</td>
                <td>{{ $candidato->certmilitar }}</td>
                @if(isset($candidato->formacoes) && $candidato->formacoes->count() > 0)
                {? $contador = 0; ?}
                    @foreach($candidato->formacoes as $formacao)
                        <td>Formacao {{ ($contador+1) }}</td>
                        <td>{{ $formacao->formacao }}</td>
                        <td>{{ $formacao->concluido }}</td>
                        <td>{{ $formacao->instituicao }}</td>
                        <td>{{ $formacao->estado }}</td>
                        <td>{{ $formacao->pais }}</td>
                        <td>{{ $formacao->curso }}</td>
                        <td>{{ $formacao->cr }}</td>
                        <td>{{ $formacao->ano_inicio }}</td>
                        <td>{{ $formacao->ano_fim }}</td>
                    {? $contador++; ?}
                    @endforeach
                @endif
                @if(isset($candidato->experiencias) && $candidato->experiencias->count() > 0)
                {? $contador2 = 0; ?}
                    @foreach($candidato->experiencias as $experiencia)
                        <td>Experiência {{ ($contador2+1) }}</td>
                        <td>{{ $experiencia->empresa }}</td>
                        <td>{{ $experiencia->funcao }}</td>
                        <td>{{ $experiencia->endereco }}</td>
                        <td>{{ $experiencia->admissao }}</td>
                        <td>{{ $experiencia->demissao }}</td>
                    {? $contador2++; ?}
                    @endforeach
                @endif
            @if($candidato->inscricoes->count() > 0)
                {? $contador3 = 0; ?}                
                @foreach($candidato->inscricoes as $inscricao)
                    <td>Inscrição {{ ($contador3+1) }}</td>
                    <td>{{ $inscricao->periodo->ano }}/{{ $inscricao->periodo->periodo }}</td>
                    <td>
                        @if($inscricao->status->last())
                            {{ $inscricao->status->last()->descricao }}
                        @endif
                    </td>
                    <td>
                        @foreach ($inscricao->areas as $area)
                            {{$area->sigla}};
                        @endforeach
                    </td>
                    <td>
                        @if($inscricao->regime == 'PARC')
                            Parcial
                        @else
                            Integral
                        @endif
                    </td>
                    <td>
                        @if($inscricao->bolsa == 1 || $inscricao->bolsa == "S")
                            Sim
                        @else
                            Não
                        @endif
                    </td>
                {? $contador3++; ?}
                @endforeach
            @endif             
            </tr>                   
        </tbody>
    </table>        

</body>
</html>
