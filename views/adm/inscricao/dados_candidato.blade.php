@extends('templates.master')
<?php header('Content-Type: text/html; charset=utf-8'); ?>
@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
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
//     $('#box_bolsa').hide();
//     $('.instituicao').hide();
//     $('#regime').change(function(){
//         if($(this).val() == 'INT')
//         {
//             $('#box_bolsa').show();

//             $('input[name=vinculo]').change(function(){

//                 if($(this).val() == 1)
//                 {
//                     $('.instituicao').show();
//                 }
//                 else
//                 {
//                     $('.instituicao').hide();
//                 }
//             });

//         }
//         else
//         {
//             $('#box_bolsa').hide();
//         }
//     });
    
    
    
        /* script das abas */
    var page = 0;

    $("input[name=vinculo]").change(function(){
        var regime = $('#regime').val();
        var vinculo = $(this).val();
        if(regime == 'INT')
        {
            $('#box_bolsa').show();

            if($(this).val() == 1)
            {
                $('.instituicao').show();
            }
            else
            {
                $('.instituicao').hide();
            }

        }
        else
        {
            $('#box_bolsa').hide();
        }
        var html = '';
        if(vinculo == "1"){
            html += '<div class="col-md-12"></div>';
            html += '    <div class="col-md-18" style="height:80px;">';
            html += '        <label>Carta de concordância da empresa<label><br/>';
            html += '        <input type="file" class="form-control" REQUIRED="REQUIRED" name="fileVinculo" />';
            html += '    </div>';
            html += '</div>';
            html += '<div class="col-md-12"></div>';
        }
        $('#UplaodFileVinculo').html(html);
    });    
    
//         $('#form').submit( function(){
//         var confirmEdit = confirm("Confirma edição da candidatura?");
//         if(confirmEdit){
//             return true;
//         } else {
//             return false;
//         }
//     } );
    
    
        $('#area1').change(function(){
        var area = $(this).val();
        var showUpload = false;
        var provaID = 0;
        var html = '';
        $(".provaPesquisa").each(function() {
            provaID = $(this).html();
            if(area == provaID){
                showUpload = true;
            }
        });
        if(showUpload){
            html += '<div class="col-md-12"></div>';
            html += '    <div class="col-md-18" style="height:80px;">';
            html += '        <label>Plano de Pesquisa<label><br/>';
            html += '        <input type="file" class="form-control" REQUIRED="REQUIRED" name="filePlanodePesquisa" />';
            html += '    </div>';
            html += '</div>';
            html += '<div class="col-md-12"></div>';
        }
        $('#UploadFile').html(html);
    });
    $('#area2').change(function(){
        var area = $(this).val();
        var showUpload = false;
        var provaID = 0;
        var html = '';
        $(".provaPesquisa").each(function() {
            provaID = $(this).html();
            if(area == provaID){
                showUpload = true;
            }
        });
        if(showUpload){
            html += '<div class="col-md-12"></div>';
            html += '    <div class="col-md-12" style="height:80px;">';
            html += '        <label>Plano de Pesquisa<label><br/>';
            html += '        <input type="file" class="form-control" REQUIRED="REQUIRED" name="filePlanodePesquisa2" />';
            html += '    </div>';
            html += '</div>';
            html += '<div class="col-md-2"></div>';
        }
        $('#UploadFile2').html(html);
    });
        
});

/* fim script abas */

</script>

@stop    

@section('content')

{? $titulo = $tipo == 'm' || $tipo == 'M' ? 'Mestrado' : 'Doutorado'; ?}

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<form class="form-horizontal ng-pristine ng-valid outrasinfos" 
      id="form" role="form" 
      method="POST" 
      action="adm/inscricao/dados-inscricao" 
      enctype="multipart/form-data">

    {{Form::token()}}
    
    <input type="hidden" name='tipo' value='{{Input::get('tipo')}}' />
    
    <section class="panel panel-default">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $titulo }}</strong></div>
        
        <div class="panel-body">
            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">
                <ul>
                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Dados Inscrição</a></li>
                </ul>
            </div>                  
                
            <div class="content clearfix">
                <h1 id="step0_h1" tabindex="-1" class="title current">1. Detalhes Gerais</h1>
                <div id="step0" class="current" style="display: block;">

                    <section class="panel panel-default">

                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Iniciais</strong></div>-->

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-2"></div>

                                <div class="col-md-8">
                                    <div class="row">
                                        Candidato: {{ $candidato->nome }} <br/> 
                                    </div>
                                    <div class="row">
                                        Inscrição: {{ $inscricao->id }} <br/> 
                                    </div>
                                    <div class="row">
                                        Período: @if($inscricao->periodo) {{ $inscricao->periodo->ano}}/{{ $inscricao->periodo->periodo or 0 }} @else Sem Periodo @endif <br/>
                                    </div>
                                    <div class="row">
                                        {{ $form->render('curso') }}<br/>
                                    </div>
                                    
                                    <div class="row">
                                        {{ $form->render('area1') }}<br/>
                                    </div>
                                    <div class="form-group">                                        
                                        <label for="filePlanoPesquisa" class="col-sm-3">Plano de Pesquisa:</label>
                                        <div class="col-sm-7">
                                            {{ $form->render('filePlanoPesquisa') }}                                            
                                        </div>
                                        <br>
                                    </div>
                                                                    
<!--                                     
                                    <div class="row" id="UploadFile"></div>

                                    <div class="form-group">
                                        <label for="identidade_arquivo" class="col-sm-3">Identidade Arquivo<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-7">

                                            {{ Form::file('identidade_arquivo') }}

                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->identidade_img))

                                                <a href="uploads/candidatos/documentos/{{$candidato->identidade_img}}" target="_blank">
                                                    @if(strpos($candidato->identidade_img, ".jpg") || strpos($candidato->identidade_img, ".jpeg") || strpos($candidato->identidade_img, ".png"))
                                                        <img class="img-responsive" src="uploads/candidatos/documentos/{{$candidato->identidade_img}}" />
                                                    @elseif(!empty($candidato->identidade_img))
                                                        <iframe src="uploads/candidatos/documentos/{{$candidato->identidade_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>

                                    </div> -->
                                                                                                           
                                    @if($inscricao->curso == 'MSC') 
                                        <div class="row"> 
                                            {{$form->render('area2') }} <br/>
                                        </div>
                                        <div class="form-group">                                        
                                            <label for="filePlanoPesquisa2" class="col-sm-3">Plano de Pesquisa:</label>
                                            <div class="col-sm-7">
                                                {{ $form->render('filePlanoPesquisa2') }}                                            
                                            </div>
                                            <br>
                                        </div>                                                                                       
                                    @endif                                    

                                    <div class="row">                                        
                                         {{ $form->render('regime') }} <br/>
                                    </div>
                                    <div class="row">                                        
                                         {{ $form->render('cvlattes') }} <br/>
                                    </div>
                                    <div class="row">
                                            {{ $form->render('bolsa') }}<br/><br/>
                                    </div>
                                    <div class="row">
                                        {{ $form->render('poscomp') }}<br/>
                                    </div>
                                                                        
                                    <div class="row">
                                            {{ $form->render('vinculo') }}<br/><br/>
                                    </div>
                                    <div class="row" id="UplaodFileVinculo"></div>
                                    <div id="box_bolsa">
   
                                        <div class="row instituicao">
                                            {{ $form->render('instituicao') }}<br/>
                                        </div>
                                    </div>
                                    
                                    
                                    @foreach($provasPesquisa AS $prova_id)
                                        <span style="display:none;" class="provaPesquisa">{{$prova_id}}</span>
                                    @endforeach
                                </div>
                                         
                                <div class="col-md-2"></div>

                            </div>

                        </div>

                    </section>

                </div>
            </div>
            <div class="actions clearfix">
                <input type="hidden" name="tipo" value="{{ $tipo }}">
                <input type="hidden" name="candidato_id" value="{{ $candidato->id }}">
                <input type="hidden" name="inscricao_id" value="{{ $inscricao->id }}">
                <ul role="menu">
                    <li id="nav_finish"><button type="submit" class="btn btn-primary">Salvar</button></li>
                </ul>
            </div>
            </div>                
                
                
        </div>
    </section>      
</form>        
</div>
@stop