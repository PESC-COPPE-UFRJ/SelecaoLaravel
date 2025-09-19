@extends('templates.master') @section('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $("a[href=#finish]").hide();

        $('.disabled').addClass('done').removeClass('disabled');
    });
</script>

@stop @section('content') @include('elements.alerts')


<div class="page ng-scope">

    <section class="panel panel-default">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Documentos do candidato : {{$candidato->nome}}</strong></div>
        <div class="panel-body">
            <div class="vertical" data-ui-wizard-form>

                <h1>Documentos Pessoais</h1>
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="identidade" class="col-sm-3">Identidade</label>
                                <div class="col-sm-9">
                                    {{ $candidato->identidade }}
                                </div>
                            </div>

                            <hr />
                            <div class="form-group row">
                                <label for="identidade_arquivo" class="col-sm-3">Identidade Arquivo</label>

                                <div class="col-sm-9">
                                    @if(isset($candidato->identidade_img))

                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" target="_blank">
                                            @if(strpos($candidato->identidade_img, ".jpg") || strpos($candidato->identidade_img, ".jpeg") || strpos($candidato->identidade_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" />
                                            @elseif(!empty($candidato->identidade_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>

                            </div>

                            <hr />

                            <div class="form-group row">

                                <label for="identidade_verso_arquivo" class="col-sm-3">Identidade Verso Arquivo</label>


                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->identidade_verso_img))
                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" target="_blank">
                                            @if(strpos($candidato->identidade_verso_img, ".jpg") || strpos($candidato->identidade_verso_img, ".jpeg") || strpos($candidato->identidade_verso_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" />
                                            @elseif(!empty($candidato->identidade_verso_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" frameborder="0" width="61.25px" height="91.063px" style="width:61.25px;height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>

                            </div>

                            <hr />

                            <div class="form-group row">

                                <label for="cpf" class="col-sm-3">CPF</label>

                                <div class="col-sm-9">
                                    {{ $candidato->cpf }}
                                </div>

                            </div>
                            <hr />

                            <div class="form-group row">

                                <label for="cpf_arquivo" class="col-sm-3">CPF Arquivo</label>

                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->cpf_img))
                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" target="_blank">
                                            @if(strpos($candidato->cpf_img, ".jpg") || strpos($candidato->cpf_img, ".jpeg") || strpos($candidato->cpf_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" />
                                            @elseif($candidato->cpf_img)
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>

                            </div>

                            <hr />

                            <div class="form-group row">

                                <label for="passaporte" class="col-sm-3">Passaporte</label>

                                <div class="col-sm-9">
                                    {{ $candidato->passaporte }}
                                </div>

                            </div>

                            <hr />

                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor</label>

                                <div class="col-sm-9">
                                    {{ $candidato->titulo_eleitor }}
                                </div>
                            </div>
                            <hr />

                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Arquivo</label>


                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->titulo_eleitor_img))
                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" target="_blank">
                                            @if(strpos($candidato->titulo_eleitor_img, ".jpg") || strpos($candidato->titulo_eleitor_img, ".jpeg") || strpos($candidato->titulo_eleitor_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" />
                                            @elseif(!empty($candidato->titulo_eleitor_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>
                            </div>


                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Verso Arquivo</label>


                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->titulo_eleitor_verso_img))
                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_verso_img}}" target="_blank">
                                            @if(strpos($candidato->titulo_eleitor_verso_img, ".jpg") || strpos($candidato->titulo_eleitor_verso_img, ".jpeg") || strpos($candidato->titulo_eleitor_verso_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_verso_img}}" />
                                            @elseif(!empty($candidato->titulo_eleitor_verso_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}s/documentos/{{$candidato->titulo_eleitor_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>
                            </div>
                            <div class="form-group row">

                                <label for="certificado_militar" class="col-sm-3">Certificado Militar</label>

                                <div class="col-sm-9">
                                    {{ $candidato->certificado_militar }}
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Certificado Militar Arquivo</label>

                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->certificado_militar_img))

                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" target="_blank">
                                            @if(strpos($candidato->certificado_militar_img, ".jpg") || strpos($candidato->certificado_militar_img, ".jpeg") || strpos($candidato->certificado_militar_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" />
                                            @elseif(!empty($candidato->certificado_militar_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Certificado Militar Verso Arquivo</label>

                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($candidato->certificado_militar_verso_img))

                                    <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" target="_blank">
                                            @if(strpos($candidato->certificado_militar_verso_img, ".jpg") || strpos($candidato->certificado_militar_verso_img, ".jpeg") || strpos($candidato->certificado_militar_verso_img, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" />
                                            @elseif(!empty($candidato->certificado_militar_verso_img))
                                                <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                        </a> @endif
                                </div>

                            </div>

                            <div class="form-group row">

                                <label for="titulo_eleitor" class="col-sm-3">Proficiências em Ingles</label>

                                <div class="col-sm-9">
                                    @if(isset($candidato) && isset($proficiencias_ingles)) @forelse($proficiencias_ingles as $pi)
                                    <div class="thumbnail col-sm-3">
                                        <a href="{{$pi->caminho}}{{$pi->nome}}" target="_blank">                                                                                            
                                        
                                        @if(strpos($pi->nome, ".jpg") || strpos($pi->nome, ".jpeg") || strpos($pi->nome, ".png"))
                                            <img class="img-thumbnail" width="304" height="236" src="{{$pi->caminho}}{{$pi->nome}}" />
                                        @elseif(!empty($pi->nome))
                                            <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/proficienciaIngles{{$candidato->certificado_militar_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                        @else
                                            <p> Sem Imagem </p>
                                        @endif

                                        </a>

                                        <div class="caption">
                                            <h4>  @if(!empty(trim($pi->titulo))) {{$pi->titulo}} @else Sem Titulo @endif </h4>
                                        </div>

                                    </div>
                                    @empty
                                    <p> Sem Imagem </p>

                                    @endforelse @endif
                                </div>

                            </div>


                        </div>
                    </div>

                </div>

                <h1>Formações</h1>
                <div>
                    <h2>Formações</h2> @forelse($candidato->formacoes as $f)

                    <hr style="border-color: #E2DDDD;">

                    <div class="row" style="background-color: #D0DCE4; margin-top: 25px;">
                        <div class="col-md-12">
                            <h4>{{ $f->formacao }}</h4>
                            <h3>{{ $f->instituicao }} - {{$f->curso}}</h3>
                        </div>

                        <div class="col-md-12">
                            @forelse($f->imagens as $i)
                            <div class="col-md-3">
                                <div class="thumbnail">

                                    {? $explode = explode('.', $i->nome) ?}

                                    <a href="{{$i->caminho}}{{$i->nome}}" target="_blank">
                                    @if(strpos($i->nome, ".jpg") || strpos($i->nome, ".jpeg") || strpos($i->nome, ".png"))
                                        <img class="img-thumbnail" width="304" height="236" src="{{$i->caminho}}{{$i->nome}}" />
                                    @elseif(!empty($i->nome))
                                        <iframe src="{{$i->caminho}}{{$i->nome}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                    @else
                                        <p> Sem Imagem </p>
                                    @endif
                                    <div class="caption">
                                        <h4>  @if(empty(trim($i->titulo))) Sem Titulo @else {{$i->titulo}} @endif  </h4>
                                    </div>
                                </a>
                                </div>
                            </div>
                            @empty
                            <p> Nenhum arquivo agregado a esta formação </p>
                            @endforelse
                        </div>
                    </div>

                    @empty
                    <p>Usuário não possui formações</p>
                    @endforelse

                </div>

                <!-- <h1>Experiências</h1>
                <div>
                    <h2> Experiências </h2>

                    @forelse($candidato->experiencias as $f)
                    <hr style="border-color: #E2DDDD;">

                    <div class="row" style="margin-top: 25px; background-color: #D0DCE4;">
                        <div class="row">
                            <div class="col-md-6">
                              <p>Nome da Empresa:</p>
                            </div>
                            <div class="col-md-6">
                              <p>{{ $f->empresa }} </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p> Função:</p>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $f->funcao }}</p>
                            </div>
                        </div>

                        
                      </div>

                    @empty
                        <p>Usuário não possui formações</p>
                    @endforelse
                </div> -->

                @if(isset($inscricoes['msc']))
                <h1>Inscrições MSc</h1>
                <div>


                    <!-- <div class="row">
                            <div class="col-md-4"> URL Lattes: </div>
                            <div class="col-md-8"> @if($inscricoes['msc']->url_cv_lattes) <a href="{{$inscricoes['msc']->url_cv_lattes}}" target="_blank"> {{$inscricoes['msc']->url_cv_lattes}} @else Lattes não foi cadastrado @endif</a></div>
                        </div> -->

                    <hr style="border-color: #E2DDDD;"> 
                   <!-- documents gerais para uma inscrição -->
                    @foreach($inscricoes['msc']->imagens as $i)
                     <div class="row">                                                
                        <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="thumbnail">

                                    {? $explode = explode('.', $i->nome) ?}

                                    <a href="{{$i->caminho}}{{$i->nome}}" target="_blank">
                                        @if(strpos($i->nome, ".jpg") || strpos($i->nome, ".jpeg") || strpos($i->nome, ".png"))
                                            <img class="img-thumbnail" width="304" height="236" src="{{$i->caminho}}{{$i->nome}}" />
                                        @elseif(!empty($i->nome))
                                            <iframe src="{{$i->caminho}}{{$i->nome}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                        @else
                                            <p> Sem Imagem </p>
                                        @endif
                                        <div class="caption">
                                            <h4>  @if(!empty(trim($i->titulo))) {{$i->titulo}} @else Sem Titulo @endif </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                    
                    <!-- documents por área de inscrição -->
                    
                    @foreach($inscricoes['msc']->areasInscricoes as $a)
                    
                    <div class="row">
                        <h2> {{ $a->area->nome }} </h2> 
                                                
                        @forelse($a->imagens as $i)
                        
                        <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="thumbnail">

                                    {? $explode = explode('.', $i->nome) ?}

                                    <a href="{{$i->caminho}}{{$i->nome}}" target="_blank">
                                            @if(strpos($i->nome, ".jpg") || strpos($i->nome, ".jpeg") || strpos($i->nome, ".png"))
                                                <img class="img-thumbnail" width="304" height="236" src="{{$i->caminho}}{{$i->nome}}" />
                                            @elseif(!empty($i->nome))
                                                <iframe src="{{$i->caminho}}{{$i->nome}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                            @else
                                                <p> Sem Imagem </p>
                                            @endif
                                            <div class="caption">
                                                <h4>  @if(!empty(trim($i->titulo))) {{$i->titulo}} @else Sem Titulo @endif </h4>
                                            </div>
                                        </a>
                                </div>
                            </div>
                        </div>

                        @empty
                        <p> Nenhum arquivo agregado a esta inscrição </p>
                        @endforelse
                    </div>
                    @endforeach




                </div>
                @endif @if(isset($inscricoes['dsc']))
                <h1>Inscrições DSc</h1>
                <div>
                    <!-- <div class="row">
                            <div class="col-md-4"> URL Lattes: </div>
                            <div class="col-md-8"> @if($inscricoes['dsc']->url_cv_lattes) <a href="{{$inscricoes['dsc']->url_cv_lattes}}" target="_blank"> {{$inscricoes['dsc']->url_cv_lattes}} @else Lattes não foi cadastrado @endif</a></div>
                        </div> -->
                    <hr style="border-color: #E2DDDD;"> 
                    <!-- documents gerais para uma inscrição -->
                    @foreach($inscricoes['dsc']->imagens as $i)
                     <div class="row">                                                
                        <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="thumbnail">

                                    {? $explode = explode('.', $i->nome) ?}

                                    <a href="{{$i->caminho}}{{$i->nome}}" target="_blank">
                                        @if(strpos($i->nome, ".jpg") || strpos($i->nome, ".jpeg") || strpos($i->nome, ".png"))
                                            <img class="img-thumbnail" width="304" height="236" src="{{$i->caminho}}{{$i->nome}}" />
                                        @elseif(!empty($i->nome))
                                            <iframe src="{{$i->caminho}}{{$i->nome}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                        @else
                                            <p> Sem Imagem </p>
                                        @endif
                                        <div class="caption">
                                            <h4>  @if(!empty(trim($i->titulo))) {{$i->titulo}} @else Sem Titulo @endif </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                    
                    <!-- documents por área de inscrição -->
                 
                    @foreach($inscricoes['dsc']->areasInscricoes as $a)
                    <div class="row">
                        <h2> {{ $a->area->nome }} </h2> 
                        @forelse($a->imagens as $i)

                        <div class="col-md-3">
                            <div class="col-md-12">
                                <div class="thumbnail">

                                    {? $explode = explode('.', $i->nome) ?}

                                    <a href="{{$i->caminho}}{{$i->nome}}" target="_blank">
                                        @if(strpos($i->nome, ".jpg") || strpos($i->nome, ".jpeg") || strpos($i->nome, ".png"))
                                            <img class="img-thumbnail" width="304" height="236" src="{{$i->caminho}}{{$i->nome}}" />
                                        @elseif(!empty($i->nome))
                                            <iframe src="{{$i->caminho}}{{$i->nome}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                        @else
                                            <p> Sem Imagem </p>
                                        @endif
                                        <div class="caption">
                                            <h4>  @if(!empty(trim($i->titulo))) {{$i->titulo}} @else Sem Titulo @endif </h4>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @empty
                        <p> Nenhum arquivo agregado a esta inscrição </p>
                        @endforelse
                    </div>
                    @endforeach

                </div>
                @endif




            </div>

        </div>
    </section>

</div>

@stop