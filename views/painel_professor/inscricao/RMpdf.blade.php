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

        <h2 align="right">Registro de Matrícula - "Seleção {{ $periodo->ano }}/{{ $periodo->periodo }}"</h2>
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
            <span class="label">Tipo Sanguíneo</span>
            {{ $candidato->tiposanguineo }}
        </div>
      
        <div class="row">
            <span class="label">Fator RH</span>
            {{ $candidato->fatorrh }}
        </div>

        <div class="row">
            <span class="label">Cor Pele</span>
            {{ $candidato->corpele }}
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
            <span class="label">Nome da Mãe</span>
            {{ $candidato->nomemae }}
        </div>
      
        <div class="row">
            <span class="label">Nome do Pai</span>
            {{ $candidato->nomepai }}
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
            <span class="label">Telefone</span>
           {{ $candidato->telefone }}
        </div>
      
        <div class="row">
            <span class="label">Celular</span>
           {{ $candidato->celular }}
        </div>

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



      
    </div>    

    <div class="direita">

              <div class="row">
            <span class="label">Titulo de eleitor</span>
            {{ $candidato->tituloeleitor }}
        </div>
      
        <div class="row">
            <span class="label">Titulo Zona</span>
            {{ $candidato->tituloeleitorzona }}
        </div>

        <div class="row">
            <span class="label">Titulo Seção</span>
            {{ $candidato->tituloeleitorsecao }}
        </div>
      
        <div class="row">
            <span class="label">Titulo UF</span>
            {{ $candidato->tituloeleitoruf }}
        </div>

       <div class="row">
            <span class="label">Titulo Emissão</span>
            {{ $candidato->tituloeleitoremissao }}
        </div>

      
        <div class="row">
            <span class="label">Certificado Militar</span>
            {{ $candidato->certmilitar }}
        </div>
      
        <div class="row">
            <span class="label">Cert Milit Categoria</span>
            {{ $candidato->certmilitarcategoria }}
        </div>

        <div class="row">
            <span class="label">Cert Milit Orgão</span>
            {{ $candidato->certmilitarorgao }}
        </div>

        <div class="row">
            <span class="label">Cert Milit Emissão</span>
            {{ $candidato->certmilitaremissao }}
        </div>
      
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
       
        @if($candidato->inscricoes && !$candidato->inscricoes->isEmpty())           

            <div>
                
                <h3>Inscrições </h3>
            
                <?php $confirmou = false; ?>
                @foreach($candidato->inscricoes as $ki => $inscricao)  
              
                    @if ( $periodo->ano ==  $inscricao->periodo->ano &&  $periodo->periodo == $inscricao->periodo->periodo )   
                                              
                          @foreach ($inscricao->areasInscricoes as $area)
                              @if (  isset($area->status) && isset($area->status->sigla) && $area->status->sigla == 'CONFIRMOU' )
                                <?php $confirmou = true; ?>
                                </div>
                              @endif
                          @endforeach
                
                          @if ($confirmou)
                
                              <h4>Inscrição {{ ($ki+1) }}</h4>

                              <div class="row">
                                  <span class="label">Ano/Periodo</span>
                                  {{ $inscricao->periodo->ano }}/{{ $inscricao->periodo->periodo }}
                              </div>

                                   @foreach ($inscricao->areasInscricoes as $area)
                                     @if ($area->status->sigla == 'CONFIRMOU' )
                                        <div class="row">
                                        <span class="label">Linha</span>
                                        {{ $area->area->sigla }}
                                        </div>
                                      @endif
                                  @endforeach

                                  <div class="row">
                                  <span class="label">Regime</span>
                                  @if($inscricao->regime == 'PARC')
                                      Parcial
                                  @else
                                      Integral
                                  @endif
                                  </div>
                              @endif              
                    @endif

                @endforeach
        
                @if (!$confirmou)
                    <font size="3" color="red"> Atenção: Candidato NÃO APTO ou NÃO CONFIRMOU matrícula</font>
                @endif

            </div>      

        @endif

    </div>

</body>
</html>
