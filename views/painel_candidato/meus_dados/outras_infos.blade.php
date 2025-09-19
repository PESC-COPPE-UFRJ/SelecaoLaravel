@extends('templates.master')

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
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>
<script type="text/javascript">

@if(isset($premios) && $premios->count() > 0)
var contPremios = {{ $premios->count() }};
@else
var contPremios = 0;
@endif
function adicionarPremios() 
{        
    var html = '';

    html += '<div class="row" id="premio-' + contPremios + '">';
    html += '<label for="premio" class="col-sm-2">' + (contPremios+1) + '</label>';
    html += '<div class="col-sm-7">';
    html += '<input type="hidden" name="premios[' + contPremios + '][id]" id="premio-' + contPremios + '-id" class="form-control" value="">';
    html += '<input type="text" name="premios[' + contPremios + '][nome]" id="premio-' + contPremios + '-nome" class="form-control txtPremio" value="">';
    html += '</div>';
    html += '<div class="col-sm-3">';
    html += '<a href="javascript:apagarPremios(\'' + contPremios + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
    html += '</div>';
    html += '<br/><br/><br/>';
    html += '</div>';

    contPremios++;

    $('.premios').append(html);
}

function apagarPremios(id)
{

    if(contPremios > 0)
    {
        contPremios--;
    }

    var cod = $('#premio-' + id + '-id').val();

    if(cod!='') 
    {
        $.post("candidato/meusdados/apagar-outras-infos",
            {idPremio: cod},
            function(response) {
                console.log('Candidatura Prévia: ' + cod + ' apagada com sucesso!');
            }
        );
    }

    $('#premio-'+id).remove();    
}

function limparCandidaturasPrevias()
{        
    $('#cod').val('');
    $('#cpid').val('');
    $('#nome').val('');
    $('#data').val('');
    $('#resultado').val('Aceito'); 
}

@if(isset($candidaturas) && $candidaturas->count() > 0)
var i = {{ $candidaturas->count() }};
@else
var i = 0;
@endif

function adicionarCandidaturasPrevias() 
{
    var html      = '';
    var contador  = parseInt(i)+1;        
    var cpid      = $('#cpid').val();
    var cod       = $('#cod').val();
    var nome      = $('#nome').val();
    var data      = $('#data').val();
    var resultado = $('#resultado').val();

    html += '<div id="candidatura-' + i + '">';
    html += '<div class="row">';
    html += '<input type="hidden" name="candidaturas[' + i + '][id]"        id="candidatura-' + i + '-id"        value="' + cpid      + '">';
    html += '<input type="hidden" name="candidaturas[' + i + '][nome]"      id="candidatura-' + i + '-nome"      value="' + nome      + '">';
    html += '<input type="hidden" name="candidaturas[' + i + '][data]"      id="candidatura-' + i + '-data"      value="' + data      + '">';
    html += '<input type="hidden" name="candidaturas[' + i + '][resultado]" id="candidatura-' + i + '-resultado" value="' + resultado + '">';
    html += '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
    html += contador + '-';
    html += '</div>';
    html += '<div class="col-sm-7">';
    html += nome + '<br/>';
    html += data + ' - ' + resultado;
    html += '</div>';
    html += '<div class="col-sm-3">';
    html += '<a href="javascript:editarCandidaturasPrevias(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
    html += '<a href="javascript:apagarCandidaturasPrevias(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
    html += '</div>';
    html += '</div>';
    html += '<hr style="background-color: #EAEAEA;height: 2px;"/>';
    html += '</div>';

    if(cod != '') {
        i = cod;
    }

    if(cod!='')
    {
        $('#candidatura-'+cod).html(html);
    }
    else
    {                
        $('#candidaturasPrevias').append(html);
    }

    i++;          
}

function editarCandidaturasPrevias(id)
{
    var confirmDelete = confirm("Deseja deletar esta candidatura?");
    if(confirmDelete){
        i=id;

        $('#cod').val(id);
        $('#cpid').val($('#candidatura-'      + id + '-id').val());
        $('#nome').val($('#candidatura-'      + id + '-nome').val());
        $('#data').val($('#candidatura-'      + id + '-data').val());
        $('#resultado').val($('#candidatura-' + id + '-resultado').val());     
    }
}

function apagarCandidaturasPrevias(id)
{
    var confirmDelete = confirm("Deseja deletar esta candidatura?");
    if(confirmDelete){
        if(i>0)
        {
            i--;
        }

        var cod = $('#candidatura-' + id + '-id').val();

        if (cod != '') {
            $.post("candidato/meusdados/apagar-outras-infos",
                {idCandidatura: cod},
                function(response) {
                    console.log('Candidatura Prévia: ' + cod + ' apagada com sucesso!');
                }
            );
        }

        $('#candidatura-'+id).remove();
        limparCandidaturasPrevias();
    }
}

var contOutrasCandidaturas = 0;

function adicionarOutrasCandidaturas() 
{
    var html = '';

    html += '<div class="row" id="outracandidatura-' + contOutrasCandidaturas + '">';
    html += '<label for="outracandidatura" class="col-sm-2">' + (contOutrasCandidaturas+1) + '</label>';
    html += '<div class="col-sm-7">';
    html += '<input type="hidden" name="outrascandidaturas[' + contOutrasCandidaturas + '][id]" id="outracandidatura-' + contOutrasCandidaturas + '-id"   value="" class="form-control">';
    html += '<input type="text" name="outrascandidaturas[' + contOutrasCandidaturas + '][nome]" id="outracandidatura-' + contOutrasCandidaturas + '-nome" value="" class="form-control txtOutraCandidatura">';
    html += '</div>';
    html += '<div class="col-sm-3">';
    html += '<a href="javascript:apagarOutrasCandidaturas(\'' + contOutrasCandidaturas + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
    html += '</div>';
    html += '<br/><br/><br/>';
    html += '</div>';

    contOutrasCandidaturas++;

    $('.outrascandidaturas').append(html);
}

function apagarOutrasCandidaturas(id)
{
    var confirmDelete = confirm("Deseja apagar esta candidatura?");
    if(confirmDelete){
        if(contOutrasCandidaturas>0)
        {
            contOutrasCandidaturas--;
        }

        var cod = $('#outracandidatura-' + id + '-id').val();

        if (cod != '') {
            $.post("candidato/meusdados/apagar-outras-infos",
                {idOutraCandidatura: cod},
                function(response) {
                    console.log('Candidatura Prévia: ' + cod + ' apagada com sucesso!');
                }
            );
        }

        $('#outracandidatura-'+id).remove();
    }
}
    
function apagarProficienciaIngles(id)
{
    var confirmDelete = confirm("Deseja apagar este documento?");
    if(confirmDelete)
    {
        $.get( "{{URL::to('imagem/delete')}}/" + id ).done(function(data)
        {                    
            location.reload();
        });
    }    
}


$(document).ready(function()
{

    $('#data').datepicker({
        autoclose:  true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'        
    });

    $('#adicionarPremios').click(function(){
        adicionarPremios();
    });

    $('#addOutrasCandidaturas').click(function(){        
        adicionarOutrasCandidaturas();
    });

    @if(isset($premios) && $premios->count() > 0)
        $('.isPremiosSim').prop('checked',true);
        $('#dvPremios').show();    
    @else
        $('.isPremiosNao').prop('checked',true);
        $('#dvPremios').hide();    
    @endif

    @if(isset($candidaturas) && $candidaturas->count() > 0)
        $('.isCandidaturasPreviasSim').prop('checked',true);
        $('#dvCandidaturasPrevias').show();    
    @else
        $('.isCandidaturasPreviasNao').prop('checked',true);
        $('#dvCandidaturasPrevias').hide();    
    @endif

    @if(isset($outrascandidaturas) && $outrascandidaturas->count() > 0)
        $('.isOutrasCandidaturasSim').prop('checked',true);
        //$('#dvOutrasCandidaturas').show();    
    @else
        $('.isOutrasCandidaturasNao').prop('checked',true);
        //$('#dvOutrasCandidaturas').hide();    
    @endif

    $('#dvOutrasCandidaturas').show();    
    
    $('.isPremios').change(function() {
        if($(this).val() == 2)
        {
            $('#dvPremios').hide();
        }
        else
        {
            $('#dvPremios').show();
        }
    });   

    $('.isCandidaturasPrevias').change(function() {
        if($(this).val() == 2)
        {
            $('#dvCandidaturasPrevias').hide();
        }
        else
        {
            $('#dvCandidaturasPrevias').show();
        }
    });

    $('.isOutrasCandidaturas').change(function() {
        if($(this).val() == 2)
        {
            $('#dvOutrasCandidaturas').hide();
        }
        else
        {
            $('#dvOutrasCandidaturas').show();
        }
    });

    $('#salvarCandidaturasPrevias').click(function() {
        var erro   = 0;
        var titulo = 'Outras Informações';
        var texto  = 'Candidaturas Prévias: Antes de clicar em OK, preencha todos os campos!';

        $('#myModal').on('show.bs.modal', function (event) {
          var modal = $(this);
          modal.find('.modal-title').text(titulo);
          modal.find('.modal-body').text(texto);
        });            

        $('.texto').each(function(){
            if($(this).val() == '') {
                erro++;
            }
        });

        if(erro == 0)
        {
            adicionarCandidaturasPrevias();
            limparCandidaturasPrevias();
        }
        else
        {
            $('#myModal').modal('show');
        }        
    });

    $('#info').keyup(function(event){        
        var max = 200;
        var len = $(this).val().length;
        var total = max - len;

        $('#maximo').html(total);

        if(len > max)
        {
            var val = $(this).val();
            $(this).val(val.substr(0,max));
        }

    });

    $('#frmOutrasInfos').submit(function(){
        var retorno = false;

        var erroPremio   = 0;
        var erroOutraCandidatura = 0;
        var titulo = 'Outras Infos';
        var texto  = '';

        $('.txtPremio').each(function(){
            if($(this).val() == '') {
                erroPremio++;
            }
        });

        $('.txtOutraCandidatura').each(function(){
            if($(this).val() == '') {
                erroOutraCandidatura++;
            }
        });

        if(erroPremio > 0) 
        {
            texto += '<strong>Prêmios</strong>: Antes de clicar em concluir, preencha os campos vazios!<br/>';
        }

        if(erroOutraCandidatura > 0)
        {
            texto += '<strong>Outras Candidaturas</strong>: Antes de clicar em concluir, preencha os campos vazios!<br/>';
        }


        $('#myModal').on('show.bs.modal', function (event) {
          var modal = $(this);
          modal.find('.modal-title').text(titulo);
          modal.find('.modal-body').html(texto);
        });

        if(erroPremio == 0 && erroOutraCandidatura == 0)
        {
            retorno = true;
        }
        else
        {
            $('#myModal').modal('show');
        }  


        return retorno;

    });

    /* script das abas */
    var page = 0;

    //abas clicaveis
    $("a[id=steps-uid-0-t-0]").click(function(event)
    {        

        event.preventDefault();

        $("#step1, #step2, #step3").hide();

        $("#step0").show();

        $("#step1_tab, #step2_tab, #step3_tab").attr('class', 'done');

        $("#step0_tab").attr('class', 'current');

        page = 0;

        $("li[id=previous]").attr('class', 'disabled');

        $("li[id=next]").attr('class', '');

        $("li[id=nav_finish]").attr('style', 'display: none;');

    });

//     $("a[id=steps-uid-0-t-1]").click(function(event){

//         event.preventDefault();

//         $("#step0, #step2, #step3").hide();

//         $("#step1").show();

//         $("#step0_tab, #step2_tab, #step3_tab").attr('class', 'done');

//         $("#step1_tab").attr('class', 'current');

//         page = 1;

//         $("li[id=previous]").attr('class', '');

//         $("li[id=next]").attr('class', '');

//         $("li[id=nav_finish]").attr('style', 'display: none;');        
        
//     });

    $("a[id=steps-uid-0-t-1]").click(function(event){

        event.preventDefault();
        
        $("#step0, #step2, #step3").hide();

        $("#step1").show();

        $("#step0_tab, #step2_tab, #step3_tab").attr('class', 'done');

        $("#step1_tab").attr('class', 'current');

        page = 1;

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


        if(page < 1)

        {

            $("li[id=next]").attr('class', '');

            $("li[id=nav_finish]").attr('style', 'display: none;')

        }

        else

        {

            $("li[id=next]").attr('class', 'disabled');

            $("li[id=nav_finish]").show('fast');

        }



        $("#step0, #step1, #step2,#step3").hide();

        $("#step"+page).show();



        $("#step0_tab, #step1_tab, #step2_tab, #step3_tab").attr('class', 'done');

        $("#step"+page+"_tab").attr('class', 'current');



    });

});

/* fim script abas */

</script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<form
    id="frmOutrasInfos" 
    class="form-horizontal ng-pristine ng-valid outrasinfos"
    role="form"
    method="POST"
    action="candidato/meusdados/outras-infos"
    enctype="multipart/form-data">

    <input type="hidden" name="id" value="{{ $id }}">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Outras Informações</strong></div>

        <div class="panel-body">        

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Prêmios e Distinções</a></li>
                    
                    <!--li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Candidaturas Prévias</a></li-->

                    <li id="step1_tab" role="tab" class="last done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Proficiência em inglês</a></li>

                </ul>

            </div>

            <div class="content clearfix">

                <h1 id="step0_h1" tabindex="-1" class="title current">1. Prêmios e Dintinções</h1>

                <div id="step0" class="current" style="display: block;">

                    <section class="panel panel-default">

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6 col-centered">

                                    <div class="form-group">

                                        <label class="col-sm-7">Você possui Prêmios e Distinções Acadêmicas?</label>

                                        <div class="col-sm-4">

                                            <label class="ui-radio"><input name="isPremios" class="isPremios isPremiosSim" type="radio" value="1"><span>Sim</span></label>

                                            <label class="ui-radio"><input name="isPremios" class="isPremios isPremiosNao" type="radio" value="2" checked><span>Não</span></label>

                                        </div>

                                    </div>

                                </div>

                            </div>                            

                            <div id="dvPremios">

                                <div class="row">
                                    <div class="col-md-3 col-centered">
                                        Quais?
                                    </div>
                                </div>

                                <br/><br/>

                                <div class="row">

                                    <div class="col-md-3 col-centered">                                

                                        <div class="premios">
                                            @if(isset($premios) && $premios->count() >0)

                                                {? $contador = 0; ?}

                                                @foreach($premios as $premio)

                                                    <div class="row" id="premio-{{ $contador }}">

                                                        <label for="premio" class="col-sm-2">{{ ($contador+1); }}</label>

                                                        <div class="col-sm-7">
                                                            <input type="hidden" name="premios[{{ $contador }}][id]" id="premio-{{ $contador }}-id" value="{{$premio->id}}">
                                                            <input type="text" name="premios[{{ $contador }}][nome]" id="premio-{{ $contador }}-nome" class="form-control txtPremio" value="{{ $premio->nome }}">
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <a href="javascript:apagarPremios('{{ $contador }}');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>
                                                        </div>
                                                        <br/><br/><br/>

                                                    </div>

                                                    {? $contador++; ?}

                                                @endforeach

                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <div class="row row-centered">
                                    <div class="col-md-6 col-centered">
                                        <button type="button" id="adicionarPremios" class="btn btn-default">Adicionar</button>
                                    </div>                                
                                </div>

                            </div>

                        </div>

                    </section>

                </div>

                <!--
                <h1 id="step1_h1" tabindex="-1" class="title">2. Candidaturas Prévias</h1>

                <div id="step1" class="current" style="display: none;">

                    <section class="panel panel-default">

                     
                        <div class="panel-body">                  

                            <div class="row">

                                <div class="col-md-11 col-centered">

                                    <div class="form-group">

                                        <label class="col-sm-6">Você se candidatou anteriormente a algum programa de pós-graduação na UFRJ?</label>

                                        <div class="col-sm-2">

                                            <label class="ui-radio"><input name="isCandidaturasPrevias" class="isCandidaturasPrevias isCandidaturasPreviasSim" type="radio" value="1"><span>Sim</span></label>

                                            <label class="ui-radio"><input name="isCandidaturasPrevias" class="isCandidaturasPrevias isCandidaturasPreviasNao" type="radio" value="2" checked><span>Não</span></label>

                                        </div>

                                    </div>

                                </div>

                            </div>              

                            <div class="panel panel-default" id="dvCandidaturasPrevias">

                                <div class="panel-body">

                                    <div class="row">

                                        <div class="col-md-6">

                                            <div class="panel panel-default">
                                                <div class="panel-body">

                                                    <input type="hidden" name="cpid" id="cpid" value="">
                                                    <input type="hidden" name="cod" id="cod" value="">

                                                    <div class="form-group">

                                                        <label class="col-sm-3">Qual</label>

                                                        <div class="col-sm-8">

                                                            <input type="text" name="nome" id="nome" class="form-control texto" value="">

                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <label class="col-sm-3">Quando</label>

                                                        <div class="col-sm-5">

                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                <input type="text" name="data" id="data" class="form-control texto" value="">
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <label class="col-sm-3">Resultado</label>

                                                        <div class="col-sm-8">

                                                            <span class="ui-select">

                                                                <select name="resultado" id="resultado">

                                                                    <option value="Aceito">Aceito</option>

                                                                    <option value="Não aceito">Não aceito</option>                                                  

                                                                </select>

                                                            </span>

                                                        </div>

                                                    </div>
                                                    
                                                    <button type="button" id="salvarCandidaturasPrevias" class="btn bg-orange pull-right">OK</button>

                                                </div>

                                            </div>

                                        </div>

                                       

                                        <div class="col-sm-1 hidden-xs hidden-sm">
                                            <table style="width: 3px; height: 600px;" align="center">
                                                <tr>
                                                    <td style="background-color: #EAEAEA;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-md-3">

                                            <div id="formacoes">

                                                <div class="row">

                                                    <div id="candidaturasPrevias">
                                                        @if(isset($candidaturas) && $candidaturas->count() > 0)
                                                            {? $contador = 0; ?}
                                                            @foreach($candidaturas as $candidatura)
                                                                <div id="candidatura-{{ $contador }}">
                                                                    <div class="row">
                                                                        <input type="hidden" name="candidaturas[{{ $contador }}][id]"        id="candidatura-{{ $contador }}-id"        value="{{ $candidatura->id }}">
                                                                        <input type="hidden" name="candidaturas[{{ $contador }}][nome]"      id="candidatura-{{ $contador }}-nome"      value="{{ $candidatura->nome }}">
                                                                        <input type="hidden" name="candidaturas[{{ $contador }}][data]"      id="candidatura-{{ $contador }}-data"      value="{{ Formatter::dateToString($candidatura->data) }}">
                                                                        <input type="hidden" name="candidaturas[{{ $contador }}][resultado]" id="candidatura-{{ $contador }}-resultado" value="{{ $candidatura->resultado }}">
                                                                        <div class="col-sm-2" style="text-align: right;font-size: 28px;">      
                                                                            {{ ($contador+1) }}-
                                                                        </div>
                                                                        <div class="col-sm-7">
                                                                        {{ $candidatura->nome }} <br/>
                                                                        {{ Formatter::dateToString($candidatura->data) }} - {{ $candidatura->resultado }}
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                        <a href="javascript:editarCandidaturasPrevias('{{ $contador }}');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
                                                                        <a href="javascript:apagarCandidaturasPrevias('{{ $contador }}');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>                                                                
                                                                    </div>
                                                                    <hr style="background-color: #EAEAEA;height: 2px;"/>
                                                                </div>
                                                                {? $contador++; ?}
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>

                                            <br/>
                                            
                                            <button type="button" id="adicionarOutrasCandidaturas" class="btn btn-default">Adicionar outras</button>

                                    
                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </section>

                </div>
                -->

                <h1 id="step1_h1" tabindex="-1" class="title">3. Proficiência em inglês</h1>

                <div id="step1" class="current" aria-hidden="true" style="display: none;">

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="row" style="margin: 4% 10%;">

                                <div class="col-md-12">

                                    <div class="form-group">

                                        <label class="col-sm-12">Os documentos comprobatórios aceitos estão especificados no "Portal de Seleção" no item "Documentação."<br/><small>Apenas PDF*</small></label>

                                    </div>

                                </div>

                            </div>

                            <div class="panel panel-default" id="dvOutrasCandidaturas">

                                <div class="panel-body">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    Proficiência em Inglês:
                                                </div>
                                                <div class="col-md-4">
                                                    <input class="form-control" name="titulo" placeholder="Título do arquivo" type="text"/>
                                                </div>
                                                <div class="col-md-5">
                                                    <input class="form-control" name="proficienciaInglesFile" type="file" />
                                                </div>
                                            </div>

                                            <br/><br/>

                                            <div class="row">
                                                @if($imagens && !$imagens->isEmpty())
                                                    @foreach($imagens AS $imagem)
                                                        <div class="col-md-2">
                                                            <a href="{{ $imagem->caminho.$imagem->nome }}" type="" target="_blank">
                                                                <div class="thumbnail">
                                                                    @if(strpos($imagem->nome, ".jpg") || strpos($imagem->nome, ".jpeg") || strpos($imagem->nome, ".png"))
                                                                        <img class="img-responsive" src="{{ $imagem->caminho.$imagem->nome }}" />
                                                                    @elseif(strpos($imagem->nome, ".pdf") || strpos($imagem->nome, ".text"))
                                                                        <iframe src="{{ $imagem->caminho.$imagem->nome }}" scrolling="no" frameborder="0" width="100%" height="91.063px" style="max-width:100%;max-height:91.063px;overflow:hidden;"></iframe><br />
                                                                    @else
                                                                        <img alt="" src="images/doc.png ">
                                                                    @endif
                                                                    <div class="caption">
                                                                        <h4>{{$imagem->titulo}}</h4>
                                                                    </div>
                  
                                                                </div>
                                                            </a>
                                                             <div class="caption">
                                                            <a href="javascript:apagarProficienciaIngles({{ $imagem->id}});" class="remover">
                                                                <span class="glyphicon glyphicon-remove"></span>Apagar</a>                                                                     
                                                                </div>                                             
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        
                        </div>
                    </div>

                </div>

            </div>

            <div class="actions clearfix">
                <ul role="menu">
                    <li id="previous" class="disabled"><a id="nav_form" href="#previous">Anterior</a></li>
                    <li id="next" style="display: block;"><a id="nav_form" href="#next">Próximo</a></li>
                    <li id="nav_finish" style="display: none;"><button type="submit" class="btn btn-primary">Concluir</button></li>
                </ul>
            </div>

            </div> 

        </div>

    </section>

</form>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@stop