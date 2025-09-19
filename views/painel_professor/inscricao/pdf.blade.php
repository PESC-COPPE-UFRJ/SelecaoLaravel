<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PDF Ficha de Inscrição</title>
<style type="text/css">

    body {
        font-family: "Lato", Helvetica, Arial, sans-serif;
        font-size: 14px;
        line-height: 1.42857;
        color: #767676;
    }

    h1, h2, h3, h4, h5 {text-align: center;}

    h3{border-bottom: 2px solid #dddddd;}
    h4{border-bottom: 1px solid #dddddd;}

    .esquerda, .direita
    {
        width: 49%;
    }
    .esquerda {float:left;}
    .direita {float: right;border-left: 3px solid #EAEAEA;padding-left: 2%;margin-left: 2%;}
    .label{display:inline-block;width: 42%;font-weight: bold;}
    .row{border-bottom: 1px solid #dddddd;margin: 2px;}
</style>
</head>

<body>
    
    <div>
        <img src="{{asset('images/logo.png') }}" alt="PESC" title="PESC" border="0"/>

        <h2 align="right">Lista de dados para candidatura "Seleção {{ $periodo->ano }}/{{ $periodo->periodo }}"</h2>
    </div>

    <div class="esquerda">
        
        <h3>Dados Pessoais</h3>

        <div class="row">
            <span class="label">Nome</span>
            {{ $candidato->nome }}
        </div>

        <div class="row">
            <span class="label">Email</span>
            {{ $candidato->email }}
        </div>

        <div class="row">
            <span class="label">Sexo</span>
            {{ $candidato->sexo }}
        </div>

        <div class="row">
            <span class="label">Nascimento</span>
            {{ $candidato->nascimento }}
        </div>

        <div class="row">
            <span class="label">Cidade de Nascimento</span>
            {{ $candidato->cidadenasc }}
        </div>

        <div class="row">
            <span class="label">É Estrangeiro?</span>
            @if($candidato->estrangeiro == 1)
                Sim
            @else
                Não
            @endif
        </div>

        <div class="row">
            <span class="label">Nacionalidade</span>
            {{ $candidato->nacionalidade }}
        </div>

        <div class="row">
            <span class="label">Estado Civil</span>
            {{ $candidato->estcivil }}
        </div>

        @if($candidato->endereco!=null)
            
            <div class="row">
                <span class="label">Endereco</span>                    
                {{ $candidato->endereco->endereco }} {{ $candidato->endereco->cep }} 
            </div>
            
            <div class="row">
                <span class="label">Bairro</span>
                {{ $candidato->endereco->bairro }}
            </div>

            <div class="row">
                <span class="label">Cidade</span>
                {{ $candidato->endereco->cidade }}
            </div>
            
            <div class="row">                      
                <span class="label">Estado</span>
                {{ $candidato->endereco->estado }}
            </div>

            <div class="row">
                <span class="label">Pais</span>
                {{ $candidato->endereco->pais }}
            </div>
            
        @endif        

        <div class="row">
            <span class="label">Identidade¨</span>
            {{ $candidato->ident }}
        </div>

        <div class="row">
            <span class="label">Data de Expedição</span>
            {{ $candidato->expedicao }}
        </div>

        <div class="row">
            <span class="label">Orgão expedidor</span>
            {{ $candidato->orgaoexped }}
        </div>

        <div class="row">
            <span class="label">Estado de Expedição</span>
            {{ $candidato->estexped }}
        </div>
              
        <div class="row">          
            <span class="label">CPF</span>
            {{ $candidato->cpf }}
        </div>

        <div class="row">
            <span class="label">Passaporte</span>
            {{ $candidato->passaporte }}
        </div>

        <div class="row">
            <span class="label">Titulo de eleitor</span>
            {{ $candidato->tituloeleitor }}
        </div>

        <div class="row">
            <span class="label">Certificado Militar</span>
            {{ $candidato->certmilitar }}
        </div>

    </div>    

    <div class="direita">

        @if($candidato->formacoes && !$candidato->formacoes->isEmpty())

            <div>
                
                <h3>Formações</h3>
            
                @foreach($candidato->formacoes as $kf => $formacao)
                            
                    <h4>Formação {{ ($kf+1) }}</h4>
                
                    <div class="row">
                        <span class="label">Formação</span>
                        {{ $formacao->formacao }}
                    </div>

                    <div class="row">
                        <span class="label">Concluído?</span>
                        {{ $formacao->concluido }}
                    </div>
                          
                    <div class="row">                                          
                        <span class="label">Instituição</span>
                        {{ $formacao->instituicao }}
                    </div>

                    <div class="row">
                        <span class="label">Estado</span>
                        {{ $formacao->estado }}
                    </div>
                
                    <div class="row">
                        <span class="label">País</span>
                        {{ $formacao->pais }}
                    </div>
                
                    <div class="row">
                        <span class="label">Curso</span>
                        {{ $formacao->curso }}
                    </div>
                
                    <div class="row">
                        <span class="label">Coeficiente de Rendimento</span>
                        {{ @number_format( (float)$formacao->cr, 2, '.', '') }}
                    </div>
              
                    <div class="row">
                        <span class="label">Nota máxima</span>
                        {{ @number_format( (float)$formacao->media_maxima, 2, '.', '') }}
                    </div>
              
                    <div class="row">
                        <span class="label">% de rendimento</span>
                        @if(!empty($formacao->cr) && !empty($formacao->media_maxima) && ($formacao->media_maxima != 0.0)) {{ @number_format(( (float) $formacao->cr / (float) $formacao->media_maxima) * 100.0, 2, '.', '') }} @else 0 @endif %
                    </div>
              
                    <div class="row">
                        <span class="label">Ano de Início</span>
                        {{ $formacao->ano_inicio }}
                    </div>

                    <div class="row">
                        <span class="label">Ano de Término</span>
                        {{ $formacao->ano_fim }}
                    </div>
                            
                @endforeach                            

            </div>      

        @endif

        @if($candidato->experiencias && !$candidato->experiencias->isEmpty())                

            <div>
                
                <h3>Experiências Profissionais</h3>
                    
                @foreach($candidato->experiencias as $ke => $experiencia)                           
                      
                    <h4>Experiência{{ ($ke+1) }}</h4>
                
                    <div class="row">
                        <span class="label">Empresa</span>
                        {{ $experiencia->empresa }}
                    </div>
                                                            
                    <div class="row">
                        <span class="label">Função</span>
                        {{ $experiencia->funcao }}
                    </div>
                
                    <div class="row">
                        <span class="label">Endereço</span>
                        {{ $experiencia->endereco }}
                    </div>
                                                                    
                    <div class="row">
                        <span class="label">Admissão</span>
                        {{ $experiencia->admissao }}
                    </div>
                
                    <div class="row">
                        <span class="label">Demissão</span>
                        {{ $experiencia->demissao }}
                    </div>
                                                                        
                @endforeach

            </div>

        @endif

        @if($candidato->docencias && !$candidato->docencias->isEmpty())

            <div>
                
                <h3>Docências</h3>
            
                @foreach($candidato->docencias as $kd => $docencia)
                                
                    <h4>Docência {{ ($kd+1) }}</h4>
                
                    <div class="row">
                        <span class="label">Instituição</span>
                        {{ $docencia->instituicao }}
                    </div>
                
                    <div class="row">
                        <span class="label">País</span>
                        {{ $docencia->pais }}
                    </div>
                
                    <div class="row">
                        <span class="label">Estado</span>
                        {{ $docencia->estado }}
                    </div>
                
                    <div class="row">
                        <span class="label">Tipo</span>
                        {{ $docencia->tipo }}
                    </div>
                
                    <div class="row">
                        <span class="label">Departamento</span>
                        {{ $docencia->departamento }}
                    </div>
                
                    <div class="row">
                        <span class="label">Nível</span>
                        {{ $docencia->nivel }}
                    </div>
                
                    <div class="row">
                        <span class="label">Disciplina</span>
                        {{ $docencia->disciplina }}
                    </div>
                
                    <div class="row">
                        <span class="label">Desde</span>
                        {{ $docencia->desde }}
                    </div>
                
                    <div class="row">
                        <span class="label">Até</span>
                        {{ $docencia->ate }}
                    </div>
                                                                                                                                                                            
                @endforeach

            </div>      

        @endif
        
        @if($candidato->inscricoes && !$candidato->inscricoes->isEmpty())           

            <div>
                
                <h3>Inscrições </h3>
            
                @foreach($candidato->inscricoes as $ki => $inscricao)  
                    
                    <h4>Inscrição {{ ($ki+1) }}</h4>
                    
                    <div class="row">
                        <span class="label">Ano/Periodo</span>
                        {{ $inscricao->periodo->ano }}/{{ $inscricao->periodo->periodo }}
                    </div>
                    
                    <div class="row">
                        <span class="label">Situação</span>
                        @if($inscricao->status->last())
                            {{ $inscricao->status->last()->descricao or 'Sem Status' }}
                        @endif
                    </div>
                    
                    <div class="row">
                        <span class="label">Linha</span>
                        @foreach ($inscricao->areas as $area)
                            {{$area->sigla}}
                        @endforeach
                    </div>
                    
                    <div class="row">
                        <span class="label">Regime</span>
                        @if($inscricao->regime == 'PARC')
                            Parcial
                        @else
                            Integral
                        @endif
                    </div>
                
                    <div class="row">
                        <span class="label">Bolsa</span>
                        @if($inscricao->bolsa == 0)
                            Não
                        @else
                            Sim
                        @endif
                    </div>

                @endforeach

            </div>      

        @endif

    </div>

</body>
</html>
