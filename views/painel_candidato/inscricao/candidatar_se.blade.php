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
    $('#box_bolsa').hide();
    $('.instituicao').hide();
    $('#regime').change(function(){
        if($(this).val() == 'INT')
        {
            $('#box_bolsa').show();

            $('input[name=vinculo]').change(function(){

                if($(this).val() == 1)
                {
                    $('.instituicao').show();
                }
                else
                {
                    $('.instituicao').hide();
                }
            });

        }
        else
        {
            $('#box_bolsa').hide();
        }
    });

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
    
    //abas clicaveis
    $("a[id=steps-uid-0-t-0]").click(function(event)
    {
        event.preventDefault();
        $("#step1, #step2").hide();
        $("#step0").show();
        $("#step1_tab, #step2_tab").attr('class', 'done');
        $("#step0_tab").attr('class', 'current');
        page = 0;
        $("li[id=previous]").attr('class', 'disabled');
        $("li[id=next]").attr('class', '');
        $("li[id=nav_finish]").attr('style', 'display: none;');
    });

    $("a[id=steps-uid-0-t-1]").click(function(event){
        event.preventDefault();
        $("#step0, #step2").hide();
        $("#step1").show();
        $("#step0_tab, #step2_tab").attr('class', 'done');
        $("#step1_tab").attr('class', 'current');
        page = 1;
        $("li[id=previous]").attr('class', '');
        $("li[id=next]").attr('class', '');
        $("li[id=nav_finish]").attr('style', 'display: none;');
    });

    $("a[id=steps-uid-0-t-2]").click(function(event){
        event.preventDefault();
        $("#step0, #step1").hide();
        $("#step2").show();
        $("#step0_tab, #step1_tab").attr('class', 'done');
        $("#step2_tab").attr('class', 'current');
        page = 2;
        $("li[id=previous]").attr('class', '');
        $("li[id=next]").attr('class', 'disabled');
        $("li[id=nav_finish]").show('fast');
    });

    $("a[id=nav_form]").click(function(event)
    {
        event.preventDefault();
        var action = $(this).attr( "href" );

        if(action == '#next')
        {
            if(page < 2)
            {
                page++;
            }
        }
        else
        {
            if(page > 0)
            {
                page--;
            }
        }
        if(page > 0)
        {
            $("li[id=previous]").attr('class', '');
        }
        else
        {
            $("li[id=previous]").attr('class', 'disabled');
        }
        if(page < 2)
        {
            $("li[id=next]").attr('class', '');
            $("li[id=nav_finish]").attr('style', 'display: none;')
        }
        else
        {
            $("li[id=next]").attr('class', 'disabled');
            $("li[id=nav_finish]").show('fast');
        }
        $("#step0, #step1, #step2").hide();
        $("#step"+page).show();
        $("#step0_tab, #step1_tab, #step2_tab").attr('class', 'done');
        $("#step"+page+"_tab").attr('class', 'current');
    });

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
            html += '        <label>Para se candidatar a esta área de pesquisa é preciso submeter um Plano de Pesquisa (formato livre)<label><br/>';
            html += '        <input type="file" class="form-control" REQUIRED="REQUIRED" name="filePlanodePesquisa" />';
            html += '    </div>';
            html += '</div>';
            html += '<div class="col-md-12"></div>';
        }
        $('#UplaodFile').html(html);
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
            html += '        <label>Para se candidatar a esta área de pesquisa é preciso submeter um Plano de Pesquisa (formato livre)<label><br/>';
            html += '        <input type="file" class="form-control" REQUIRED="REQUIRED" name="filePlanodePesquisa2" />';
            html += '    </div>';
            html += '</div>';
            html += '<div class="col-md-2"></div>';
        }
        $('#UplaodFile2').html(html);
    });
    $('#area1').trigger( "change" );
    $('#nav_finish').click(function(){
        if( typeof  $( 'input[name="filePlanodePesquisa"]' ).val() !== "undefined"){
            if( !$('input[name="filePlanodePesquisa"]').val() ) {
                $('#steps-uid-0-t-1').trigger( "click" );
            }
        }
        if( typeof  $( 'input[name="filePlanodePesquisa2"]' ).val() !== "undefined"){
            if( !$('input[name="filePlanodePesquisa2"]').val() ) {
                $('#steps-uid-0-t-1').trigger( "click" );
            }
        }
        if( typeof  $( 'input[name="fileVinculo"]' ).val() !== "undefined"){
            if( !$('input[name="fileVinculo"]').val() ) {
                $('#steps-uid-0-t-0').trigger( "click" );
            }
        }
        if( $( 'input[name="cvlattes"]' ).val() == ""){
            $('#steps-uid-0-t-0').trigger( "click" );
        }
    });

    $('#form').submit( function(){
        var confirmDelete = confirm("Ao concluir a candidatura, seus dados não poderão ser alterados até o final deste processo seletivo. Confirma conlusão da candidatura?");
        if(confirmDelete){
            return true;
        } else {
            return false;
        }
    } );

});

/* fim script abas */

</script>

@stop

@section('content')

{? $tipo = Input::get('tipo'); ?}
{? $titulo = $tipo == 'm' || $tipo == 'M' ? 'Mestrado' : 'Doutorado'; ?}

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<form class="form-horizontal ng-pristine ng-valid outrasinfos" id="form" role="form" method="POST" action="{{URL::to('candidato/inscricao/candidatarse')}}" enctype="multipart/form-data">

    {{Form::token()}}

    <input type="hidden" name='tipo' value='{{Input::get('tipo')}}' />

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{ $titulo }}</strong></div>

        <div class="panel-body">

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Detalhes Gerais</a></li>

                    <li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Inscrições</a></li>

                    <li id="step2_tab" role="tab" class="done"><a id="steps-uid-0-t-2" href="#steps-uid-0-t-2"><span class="number">3.</span> Conclusão</a></li>

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
                                        {{ $form->render('curso') }}<br/>
                                    </div>
                                    <div class="row">
                                        {{ $form->render('poscomp') }}<br/>
                                    </div>
                                    <div class="row">
                                        {{ $form->render('regime') }}<br/>
                                    </div>
                                    <div class="row">
                                        <span id="div_cvlattes">
                                            <label for="cvlattes" class=" required">URL do Currículo Lattes (formato : http://lattes.cnpq.br/XXXXXXXXXXXXXXXX) <span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="cvlattes" name="cvlattes" REQUIRED>
                                        </span>
                                    <br>
                                    </div>
                                    <div class="row">
                                            {{ $form->render('vinculo') }}<br/>
                                    </div>
                                    <div class="row" id="UplaodFileVinculo"></div>
                                    <div id="box_bolsa">
                                        <!--div class="row instituicao">
                                            {{ $form->render('instituicao') }}<br/>
                                        </div-->
                                        <div class="row">
                                            <br/>{{ $form->render('bolsa') }} &nbsp; &nbsp; &nbsp;
                                            (Ler atentamente as regras para bolsas neste <a href="http://www.cos.ufrj.br/selecao/?page_id=225&lang=pt">link</a>)<br/><br/>
                                        </div>
                                    </div>
                                    <!-- Marroquim pediu, no dia 19/06/2015, por e-mail, para esconder essa opção -->
                                    <div class="row" style="display:none">
                                        {{ $form->render('dinter') }}<br/>
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                            </div>

                        </div>

                    </section>

                </div>

                <h1 id="step1_h1" tabindex="-1" class="title">2. Inscrições</h1>
                <div id="step1" class="current" style="display: none;">
                    <section class="panel panel-default">
                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados cadastrais adicionais</strong></div>-->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <span id="div_area1">
                                        <label for="area1" class="">Área de Concentração 1</label>
                                        <select class="form-control select-area" type="select" id="area1" name="area1">
                                            @foreach($areas as $key => $area)
                                                <option value="{{$key}}"> {{$area}} </option>
                                            @endforeach
                                        </select>
                                    </span>
                                    <br/>
                                    <div class="row" id="UplaodFile"></div>
                                    @if($tipo == 'm' || $tipo == 'M')
                                        <span id="div_area2">
                                            <label for="area2" class="">Área de Concentração 2 (opcional)</label>
                                            <select class="form-control select-area" type="select" id="area2" name="area2">
                                                    <option value=""> Nenhum </option>
                                                @foreach($areas as $key => $area)
                                                    <option value="{{$key}}"> {{$area}} </option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <br/>
                                        <div class="row" id="UplaodFile2"></div>
                                    @endif
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            @foreach($provasPesquisa AS $prova_id)
                                <span style="display:none;" class="provaPesquisa">{{$prova_id}}</span>
                            @endforeach
                        </div>
                    </section>
                    
                </div>

                <h1 id="step2_h1" tabindex="-1" class="title">3. Conclusão</h1>
                <div id="step2" class="current" aria-hidden="true" style="display: none;">
                    <div class="panel panel-default">
                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span>Produtos disponíveis para este associado</strong></div>-->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <strong>A conclusão de sua ficha é necessária para que sua inscrição na(s) área(s) de concentração seja considerada pelo processo de seleção.</strong>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <p>&nbsp;</p>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $form->field('concordo') }}<br/> 
                                        </div>
                                        <div class="col-md-11">
                                            {{ $form->field('concordo')->label }}<br/> 
                                        </div>                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $form->field('dadosatualizados') }}<br/> 
                                        </div>
                                        <div class="col-md-11">
                                            {{ $form->field('dadosatualizados')->label }}<br/> 
                                        </div>                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $form->field('cvatualizado') }}<br/> 
                                        </div>
                                        <div class="col-md-11">
                                            {{ $form->field('cvatualizado')->label }}<br/> 
                                        </div>                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $form->field('veracidade') }}<br/> 
                                        </div>
                                        <div class="col-md-11">
                                            {{ $form->field('veracidade')->label }}<br/> 
                                        </div>                    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            {{ $form->field('comunicacoes') }}<br/> 
                                        </div>
                                        <div class="col-md-11">
                                            {{ $form->field('comunicacoes')->label }}<br/> 
                                        </div>                    
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions clearfix">
                <ul role="menu">
                    <li id="previous" class="disabled"><a id="nav_form" href="#previous">Voltar</a></li>
                    <li id="next" style="display: block;"><a id="nav_form" href="#next">Avançar</a></li>
                    <li id="nav_finish" style="display: none;"><button type="submit" class="btn btn-primary">Concluir</button></li>
                </ul>
            </div>
            </div>
        </div>
    </section>
</form>
</div>
@stop