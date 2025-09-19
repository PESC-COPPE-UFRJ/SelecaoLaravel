@extends('templates.master')
@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
    <link rel="stylesheet" href="styles/datepicker3.css">
@stop
@section('scripts')
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>

<script type="text/javascript">

$(document).ready(function()
{
    $('.datepicker').datepicker({
            autoclose:  true,
            format: 'dd/mm/yyyy',
            language: 'pt-BR'
    });

    /* script das abas */
    var page = 0;

    $("#step1").hide();
    $("#step2").hide();

    //abas clicaveis
    $("a[id=steps-uid-0-t-0]").click(function(event)
    {

        event.preventDefault();

        $("#step1, #step2").hide();

        $("#step0").show('fast');

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

        $("#step1").show('fast');

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

        $("#step2").show('fast');

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
    /* fim script abas */


    /* Script accordion para configuração de provas */

        var botao;

        $(".mestrado.btnprovaconfig").click(function()
        {
            if(botao != this)
            {
                $('.divprovaconfig').hide('fast');

                $('#divprova'+this.id+'mestrado').show('fast');
            }

            botao = this;
        });

        $(".doutorado.btnprovaconfig").click(function()
        {
            if(botao != this)
            {
                $('.divprovaconfig').hide('fast');

                $('#divprova'+this.id+'doutorado').show('fast');
            }

            botao = this;
        });

    /* Script accordion para configuração de provas Fim */


    /* Adiciona prova de MESTRADO ao clicar em nova prova */

        var areas_mestrado     = new Array();

        $(".novaprova_mestrado").click(function()
        {
            var areaid      = $(this).attr('areaid');
            var areasigla   = $(this).attr('areasigla');

            if(!(areaid in areas_mestrado))
            {
                //console.log('não existe no array');
                areas_mestrado[areaid] = 0;
            }
            else
            {
                //console.log('existe no array!')
                areas_mestrado[areaid]++;
            }

            console.log(areas_mestrado);

            var prova_html = [
            '<div class="form-group div_prova_mestrado_'+areaid+'_'+areas_mestrado[areaid]+'">',
            '   <div class="row">',
            '       <label class="col-md-1 control-label"><button type="button" class="btn btn-danger prova_mestrado" prova_id="0" areaid="'+areaid+'" prova_i="'+areas_mestrado[areaid]+'" periodo_id="0">Deletar</button></label>',
            '       <label class="col-md-2 control-label" >Identificador:</label>',
            '       <div class="col-md-3">',
            '           <input type="text" name="provas_mestrado['+areaid+']['+areas_mestrado[areaid]+'][identificador]" placeholder="Identificador" class="form-control input-md">',
            '           <span class="help-block">Ex: P1 ou P2...</span>',
            '       </div>',
            '       <label class="col-md-3 control-label" for="selectbasic">Nome da Prova:</label>',
            '       <div class="col-md-3">',
            '           <select id="selectbasic" name="provas_mestrado['+areaid+']['+areas_mestrado[areaid]+'][id_prova]" class="form-control">',
            '               @foreach($provas as $key => $prova)',
            '               <option value="{{$key}}">{{$prova}}</option>',
            '               @endforeach',
            '           </select>',
            '       </div>',
            '   </div>',
            '   <div class="row">',
            '       <label class="col-md-3 control-label" for="selectbasic">Tipo da Prova:</label>',
            '       <div class="col-md-3">',
            '           <select id="selectbasic" areaid="'+areaid+'" prova_i="'+areas_mestrado[areaid]+'" name="provas_mestrado['+areaid+']['+areas_mestrado[areaid]+'][tipo]" class="form-control tipo_mestrado">',
            '               <option>Selecione uma opção</option>',
            '               <option value="Eliminatoria">Eliminatória</option>',
            '               <option value="Classificatoria">Classificatória</option>',
            '           </select>',
            '       </div>',
            '       <label class="col-md-3 control-label tipo_mestrado_eliminatoria'+areaid+'-'+areas_mestrado[areaid]+'" for="selectbasic" style="display: none;">Nota Eliminatória:</label>',
            '       <div class="col-md-3 tipo_mestrado_eliminatoria'+areaid+'-'+areas_mestrado[areaid]+'" style="display: none;">',
            '           <select name="provas_mestrado['+areaid+']['+areas_mestrado[areaid]+'][nota_eliminatoria]" class="form-control">',
            '               <option value="1">1</option>',
            '               <option value="2">2</option>',
            '               <option value="3">3</option>',
            '               <option value="4">4</option>',
            '               <option value="5">5</option>',
            '               <option value="6">6</option>',
            '               <option value="7">7</option>',
            '               <option value="8">8</option>',
            '               <option value="9">9</option>',
            '               <option value="10">10</option>',
            '           </select>',
            '       </div>',
            '       <label class="col-md-3 control-label tipo_mestrado_classificatoria'+areaid+'-'+areas_mestrado[areaid]+'" for="selectbasic" style="display: none;">Nota Classificatória:</label>',
            '       <div class="col-md-3 tipo_mestrado_classificatoria'+areaid+'-'+areas_mestrado[areaid]+'" style="display: none;">',
            '           <select name="provas_mestrado['+areaid+']['+areas_mestrado[areaid]+'][nota_classificatoria]" class="form-control">',
            '               <option value="1">1</option>',
            '               <option value="2">2</option>',
            '               <option value="3">3</option>',
            '               <option value="4">4</option>',
            '               <option value="5">5</option>',
            '               <option value="6">6</option>',
            '               <option value="7">7</option>',
            '               <option value="8">8</option>',
            '               <option value="9">9</option>',
            '               <option value="10">10</option>',
            '           </select>',
            '       </div>',
            '   </div>',
            '</div>',
            '<hr style="border-top: 1px solid #ccc;" class="div_prova_mestrado_'+areaid+'_'+areas_mestrado[areaid]+'">'
            ].join('');

            $('#divprova'+areasigla+'mestrado').append(prova_html);

            //console.log('#divprova'+areasigla+'doutorado');
            //console.log(areas_mestrado);
        });

    /* Adiciona prova de MESTRADO ao clicar em nova prova FIM */

    /* Adiciona prova de DOUTORADO ao clicar em nova prova */

    var areas_doutorado     = new Array();

    $(".novaprova_doutorado").click(function()
    {
        var areaid      = $(this).attr('areaid');
        var areasigla   = $(this).attr('areasigla');

        if(!(areaid in areas_doutorado))
        {
            //console.log('não existe no array');
            areas_doutorado[areaid] = 0;
        }
        else
        {
            //console.log('existe no array!')
            areas_doutorado[areaid]++;
        }

        var prova_html = [
        '<div class="form-group div_prova_doutorado_'+areaid+'_'+areas_doutorado[areaid]+'">',
        '   <div class="row">',
        '       <label class="col-md-1 control-label"><button type="button" class="btn btn-danger prova_doutorado" areaid="'+areaid+'" prova_id="0" prova_i="'+areas_doutorado[areaid]+'" periodo_id="0">Deletar</button></label>',
        '       <label class="col-md-2 control-label" >Identificador:</label>',
        '       <div class="col-md-3">',
        '           <input type="text" name="provas_doutorado['+areaid+']['+areas_doutorado[areaid]+'][identificador]" placeholder="Identificador" class="form-control input-md">',
        '           <span class="help-block">Ex: P1 ou P2...</span>',
        '       </div>',
        '       <label class="col-md-3 control-label" for="selectbasic">Nome da Prova:</label>',
        '       <div class="col-md-3">',
        '           <select id="selectbasic" name="provas_doutorado['+areaid+']['+areas_doutorado[areaid]+'][id_prova]" class="form-control">',
        '               @foreach($provas as $key => $prova)',
        '               <option value="{{$key}}">{{$prova}}</option>',
        '               @endforeach',
        '           </select>',
        '       </div>',
        '   </div>',
        '   <div class="row">',
        '       <label class="col-md-3 control-label" for="selectbasic">Tipo da Prova:</label>',
        '       <div class="col-md-3">',
        '           <select id="selectbasic" areaid="'+areaid+'" prova_i="'+areas_doutorado[areaid]+'" name="provas_doutorado['+areaid+']['+areas_doutorado[areaid]+'][tipo]" class="form-control tipo_doutorado">',
        '               <option>Selecione uma opção</option>',
        '               <option value="Eliminatoria">Eliminatória</option>',
        '               <option value="Classificatoria">Classificatória</option>',
        '           </select>',
        '       </div>',
        '       <label class="col-md-3 control-label tipo_doutorado_eliminatoria'+areaid+'-'+areas_doutorado[areaid]+'" for="selectbasic" style="display: none;">Nota Eliminatória:</label>',
        '       <div class="col-md-3 tipo_doutorado_eliminatoria'+areaid+'-'+areas_doutorado[areaid]+'" style="display: none;">',
        '           <select name="provas_doutorado['+areaid+']['+areas_doutorado[areaid]+'][nota_eliminatoria]" class="form-control">',
        '               <option value="1">1</option>',
        '               <option value="2">2</option>',
        '               <option value="3">3</option>',
        '               <option value="4">4</option>',
        '               <option value="5">5</option>',
        '               <option value="6">6</option>',
        '               <option value="7">7</option>',
        '               <option value="8">8</option>',
        '               <option value="9">9</option>',
        '               <option value="10">10</option>',
        '           </select>',
        '       </div>',
        '       <label class="col-md-3 control-label tipo_doutorado_classificatoria'+areaid+'-'+areas_doutorado[areaid]+'" for="selectbasic" style="display: none;">Nota Classificatória:</label>',
        '       <div class="col-md-3 tipo_doutorado_classificatoria'+areaid+'-'+areas_doutorado[areaid]+'" style="display: none;">',
        '           <select name="provas_doutorado['+areaid+']['+areas_doutorado[areaid]+'][nota_classificatoria]" class="form-control">',
        '               <option value="1">1</option>',
        '               <option value="2">2</option>',
        '               <option value="3">3</option>',
        '               <option value="4">4</option>',
        '               <option value="5">5</option>',
        '               <option value="6">6</option>',
        '               <option value="7">7</option>',
        '               <option value="8">8</option>',
        '               <option value="9">9</option>',
        '               <option value="10">10</option>',
        '           </select>',
        '       </div>',
        '   </div>',
        '</div>',
        '<hr style="border-top: 1px solid #ccc;" class="div_prova_doutorado_'+areaid+'_'+areas_doutorado[areaid]+'">'
        ].join('');

        $('#divprova'+areasigla+'doutorado').append(prova_html);

        //console.log('#divprova'+areasigla+'doutorado');
        //console.log(areas_doutorado);
    });

    /* Adiciona prova de doutorado ao clicar em nova prova FIM */


    /*Show Hide dependendo do tipo da prova (classificatória ou eliminatória)*/

    $(document).on('change', '.tipo_doutorado', function(event)
    {
        var tipo = $(this).val();
        var areaid = $(this).attr('areaid');
        var prova_i = $(this).attr('prova_i');
        //console.log(areaid +' - '+ prova_i);
        if(tipo == 'Classificatoria')
        {
            $('.tipo_doutorado_eliminatoria'+areaid+'-'+areas_doutorado[areaid]).hide();
            $('.tipo_doutorado_classificatoria'+areaid+'-'+areas_doutorado[areaid]).show();
        }
        else if (tipo == 'Eliminatoria')
        {
            $('.tipo_doutorado_eliminatoria'+areaid+'-'+prova_i).show();
            $('.tipo_doutorado_classificatoria'+areaid+'-'+prova_i).hide();
        }

        //$('tipo_doutorado_')
    });

    $(document).on('change', '.tipo_mestrado', function(event)
    {
        var tipo = $(this).val();
        var areaid = $(this).attr('areaid');
        var prova_i = $(this).attr('prova_i');
        //console.log(areaid +' - '+ prova_i);
        if(tipo == 'Classificatoria')
        {
            $('.tipo_mestrado_eliminatoria'+areaid+'-'+prova_i).hide();
            $('.tipo_mestrado_classificatoria'+areaid+'-'+prova_i).show();
        }
        else if (tipo == 'Eliminatoria')
        {
            $('.tipo_mestrado_eliminatoria'+areaid+'-'+prova_i).show();
            $('.tipo_mestrado_classificatoria'+areaid+'-'+prova_i).hide();
        }

    });

    $(document).on('click', '.prova_mestrado', function(event)
    {
        var areaid = $(this).attr('areaid');
        var prova_i = $(this).attr('prova_i');
        var provaId = $(this).attr('prova_id');

        if(provaId > 0){
            $.ajax({
                url: "adm/prova/destroyajax/",
                data: { prova_id : provaId, tipo : "m" },
                cache: false,
                success: function(html){
                    console.log('apaga Prova do periodo para mestrado');
                }
            });
        }
        $('.div_prova_mestrado_'+areaid+'_'+prova_i).remove()
    });

    $(document).on('click', '.prova_doutorado', function(event)
    {
        var areaid = $(this).attr('areaid');
        var prova_i = $(this).attr('prova_i');
        var provaId = $(this).attr('prova_id');

        if(provaId > 0){
            $.ajax({
                url: "adm/prova/destroyajax/",
                data: { prova_id : provaId, tipo : "d" },
                cache: false,
                success: function(html){
                    console.log('apaga Prova do periodo para doutorado');
                }
            });
        }

        $('.div_prova_doutorado_'+areaid+'_'+prova_i).remove()
    });

    /*Show Hide dependendo do tipo da prova (classificatória ou eliminatória) FIM*/


});
</script>



@stop

@section('content')


<form method="POST" action="{{URL::to("adm/periodo/")}}" accept-charset="UTF-8" class="form-horizontal ng-pristine ng-valid" role="form">
    <!-- Wizard START -->
    <!------------------>
    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> </strong></div>

        <div class="panel-body">

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Configuração do Período</a></li>

                    <li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Linhas e vagas de MESTRADO</a></li>

                    <li id="step2_tab" role="tab" class="done"><a id="steps-uid-0-t-2" href="#steps-uid-0-t-2"><span class="number">3.</span> Linhas e vagas de DOUTORADO</a></li>

                </ul>

            </div>

            <div class="content clearfix">


                <h1 id="step0_h1" tabindex="-1" class="title current">1. Configuração do Período</h1>

                <div id="step0" role="tabpanel" aria-labelledby="steps-uid-0-h-2" class="body current" style="display: block;">



                    {{Form::token()}}

                    <div class="form-group">
                        <label for="ano" class="col-sm-2 control-label required">Ano</label>
                        <div class="col-sm-10" id="div_ano">
                            <input class="form-control" type="text" id="ano" name="ano" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="periodo" class="col-sm-2 control-label">Periodo</label>
                        <div class="col-sm-10" id="div_periodo">
                            <select class="form-control" type="select" id="periodo" name="periodo">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="habilitado" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-2" id="div_habilitado">
                            <input name="status" type="radio" value="0" checked=""> Inativo
                        </div>
                        <div class="col-sm-2" id="div_habilitado">
                            <input name="status" type="radio" value="1"> Em Preparação
                        </div>
                        <div class="col-sm-2" id="div_habilitado">
                            <input name="status" type="radio" value="2"> Inscrições Abertas
                        </div>
                        <div class="col-sm-2" id="div_habilitado">
                            <input name="status" type="radio" value="3"> Inscrições Concluidas
                        </div>
                        <div class="col-sm-2" id="div_habilitado">
                            <input name="status" type="radio" value="4"> Periodo Fechado
                        </div>
                    </div>
                    <div class="form-group" data-ng-controller="DatepickerDemoCtrl">
                        <label for="data_hora_inicio" class="col-sm-2 control-label">Data de Início</label>
                        <div class="col-sm-10" id="div_data_hora_inicio">
                           <input class="form-control datepicker" type="text" id="data_hora_inicio" name="data_hora_inicio" value="">
                        </div>
                    </div>
                    <div class="form-group" data-ng-controller="DatepickerDemoCtrl">
                        <label for="data_hora_fim" class="col-sm-2 control-label">Data do Fim</label>
                        <div class="col-sm-10" id="div_data_hora_fim">
                               <input class="form-control datepicker" type="text" id="data_hora_fim" name="data_hora_fim" value="">
                        </div>
                    </div>


                </div>

                <h1 id="step1_h1" tabindex="-1" class="title">2. Linhas e vagas de MESTRADO</h1>

                <div id="step1" role="tabpanel" aria-labelledby="steps-uid-0-h-2" class="body" style="display: block;">


                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados cadastrais adicionais</strong></div>-->

                    @foreach($areas as $area)
                        <div class="form-group clearfix">
                            <label for="habilitado" class="col-md-4 control-label" style="text-align: right;">{{$area->nome}} ({{$area->sigla}})</label>
                            <div class="col-md-5" id="div_habilitado">
                                <input name="areas_vagas_mestrado[{{$area->id}}]" type="text" value="" class="form-control" placeholder="Numero de Vagas Ex: 4">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary mestrado btnprovaconfig" id="{{$area->sigla}}">Configurar Provas de {{$area->sigla}}</button>
                            </div>

                            <!-- DIV CONFIG PROVAS MESTRADO-->
                            <div class="col-md-12 divprovaconfig" id="divprova{{$area->sigla}}mestrado" style="display:none;">
                                <legend>Provas de {{$area->nome}} ({{$area->sigla}}) - MESTRADO</legend>

                                <!-- DIV CONFIG PROVAS TOOLBAR -->
                                <div class="btn-toolbar" role="toolbar">

                                    <div class="pull-left">
                                        <button type="button" class="btn btn-success novaprova_mestrado" areaid="{{$area->id}}" areasigla="{{$area->sigla}}">Nova Prova</button>
                                    </div>

                                    <div class="pull-right">
                                        <!-- <a href="{{URL::to('adm/prova/create')}}" class="btn btn-success">Nova Prova</a> -->
                                    </div>
                                </div>
                                <!-- DIV CONFIG PROVAS TOOLBAR FIM -->

                                <!-- <div class="form-group">
                                    <label class="col-md-2 control-label" >Identificador:</label>
                                    <div class="col-md-2">
                                        <input type="text" name="provas_mestrado[{{$area->id}}][][identificador]" placeholder="Identificador" class="form-control input-md">
                                        <span class="help-block">Ex: P1 ou P2...</span>
                                    </div>

                                    <label class="col-md-2 control-label" for="selectbasic">Nome da Prova:</label>
                                    <div class="col-md-2">
                                        <select id="selectbasic" name="provas_mestrado[{{$area->id}}][][id_prova]" class="form-control">
                                            @foreach($provas as $key => $prova)
                                                <option value="{{$key}}">{{$prova}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label class="col-md-1 control-label" for="selectbasic">Nota Eliminatória:</label>
                                    <div class="col-md-1">
                                        <select name="provas_mestrado[][][nota_eliminatoria]">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>

                                    <label class="col-md-1 control-label" for="selectbasic">Nota Classificatória:</label>
                                    <div class="col-md-1">
                                        <select name="provas_mestrado[][][nota_classificatoria]">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>


                                </div> -->

                            </div>
                            <!-- DIV CONFIG PROVAS MESTRADO FIM-->

                        </div>
                    @endforeach


                </div>

                <h1 id="step2_h1" tabindex="-1" class="title">3. Linhas e vagas de DOUTORADO</h1>

                <div id="step2" role="tabpanel" aria-labelledby="steps-uid-0-h-2" class="body" style="display: block;">

                    @foreach($areas as $area)
                        <div class="form-group clearfix">
                            <label for="habilitado" class="col-md-4 control-label" style="text-align: right;">{{$area->nome}} ({{$area->sigla}})</label>
                            <div class="col-md-5" id="div_habilitado">
                                <input name="areas_vagas_doutorado[{{$area->id}}]" type="text" value="" class="form-control" placeholder="Numero de Vagas Ex: 4">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary doutorado btnprovaconfig" id="{{$area->sigla}}">Configurar Provas de {{$area->sigla}}</button>
                            </div>

                            <!-- DIV CONFIG PROVAS DOUTORADO -->
                            <div class="col-md-12 divprovaconfig" id="divprova{{$area->sigla}}doutorado" style="display:none;">
                                <legend>Provas de {{$area->nome}} ({{$area->sigla}}) - DOUTORADO </legend>

                                <!-- DIV CONFIG PROVAS TOOLBAR -->
                                <div class="btn-toolbar" role="toolbar">

                                    <div class="pull-left">
                                        <button type="button" class="btn btn-success novaprova_doutorado" areaid="{{$area->id}}" areasigla="{{$area->sigla}}">Nova Prova</button>
                                    </div>

                                    <div class="pull-right">
                                        <!-- <a href="{{URL::to('adm/prova/create')}}" class="btn btn-success">Nova Prova</a> -->
                                    </div>
                                </div>
                                <!-- DIV CONFIG PROVAS TOOLBAR FIM -->

                            </div>
                            <!-- DIV CONFIG PROVAS DOUTORADO -->
                        </div>
                    @endforeach

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
    <!-- Wizard END -->
    <!---------------->



    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <a href="/adm/periodo" class="btn btn-default">Voltar a listagem</a>
            <input class="btn btn-primary" type="submit" value="Salvar">
        </div>
    </div>

    <br />
    <br />

</form>
<script type="text/javascript">
    $(function() { 
        $("#title_text").html("Criando novo Período");

        $("#ano").change(function(){
            var ano = $(this).val();
            var periodo = $("#periodo").val();
            if(ano != ''){
                $("#title_text").html("Criando novo Período "+ano+"."+periodo);
            } else {
                $("#title_text").html("Criando novo Período");
            }
        });
        $("#periodo").change(function(){
            var periodo = $(this).val();
            var ano = $("#ano").val();
            if(ano != ''){
                $("#title_text").html("Criando novo Período "+ano+"."+periodo);
            } else {
                $("#title_text").html("Criando novo Período");
            }
        });
        $("#steps-uid-0-t-0").click(function(){
            var ano = $("#ano").val();
            var periodo = $("#periodo").val();
            if(ano != ''){
                $("#title_text").html("Criando novo Período "+ano+"."+periodo);
            } else {
                $("#title_text").html("Criando novo Período");
            }
        });
        $("#steps-uid-0-t-1").click(function(){
            var ano = $("#ano").val();
            var periodo = $("#periodo").val();
            if(ano != ''){
                $("#title_text").html("Criando novo Período "+ano+"."+periodo+" - Mestrado");
            } else {
                $("#title_text").html("Criando novo Período - Mestrado");
            }
        });
        $("#steps-uid-0-t-2").click(function(){
            var ano = $("#ano").val();
            var periodo = $("#periodo").val();
            if(ano != ''){
                $("#title_text").html("Criando novo Período "+ano+"."+periodo+" - Doutorado");
            } else {
                $("#title_text").html("Criando novo Período - Doutorado");
            }
        });
        $("#next").click(function(){
            var ano = $("#ano").val();
            var periodo = $("#periodo").val();
            var id = $('.current').attr('id');
            if(id == "step0_tab"){$( "#steps-uid-0-t-0" ).trigger( "click" );}
            if(id == "step1_tab"){$( "#steps-uid-0-t-1" ).trigger( "click" );}
            if(id == "step2_tab"){$( "#steps-uid-0-t-2" ).trigger( "click" );}
        });
        $("#previous").click(function(){
            var ano = $("#ano").val();
            var periodo = $("#periodo").val();
            var id = $('.current').attr('id');
            if(id == "step0_tab"){$( "#steps-uid-0-t-0" ).trigger( "click" );}
            if(id == "step1_tab"){$( "#steps-uid-0-t-1" ).trigger( "click" );}
            if(id == "step2_tab"){$( "#steps-uid-0-t-2" ).trigger( "click" );}
        });
    });
</script>

@stop