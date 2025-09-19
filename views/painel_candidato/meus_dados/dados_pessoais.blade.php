@extends('templates.master')
@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
    <link rel="stylesheet" href="styles/datepicker3.css">
    <style type="text/css">
    .required-field {
        color: red;
    }
    </style>
@stop
@section('scripts')
@section('scripts')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>

<script type="text/javascript">

function formataTelefone(id) {
    $(id).focusout(function()
    {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 10) {
            element.mask("(99) 99999-999?9");
        } else {
            element.mask("(99) 9999-9999?9");
        }
    }).trigger('focusout');
}

function formataTelefoneFixo(id) {
    $(id).focusout(function()
    {
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        element.mask("(99) 9999-9999");
    }).trigger('focusout');
}

function validaCPF(cpf)
  {
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
          return false;
    for (i = 0; i < cpf.length - 1; i++)
          if (cpf.charAt(i) != cpf.charAt(i + 1))
                {
                digitos_iguais = 0;
                break;
                }
    if (!digitos_iguais)
          {
          numeros = cpf.substring(0,9);
          digitos = cpf.substring(9);
          soma = 0;
          for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(0))
                return false;
          numeros = cpf.substring(0,10);
          soma = 0;
          for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
          resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
          if (resultado != digitos.charAt(1))
                return false;
          return true;
          }
    else
        return false;
  }

var acumulador = 0;
$(document).ready(function()
{
    $("#cpf").mask("999.999.999-99");

    $('#data_nascimento').datepicker({
        autoclose:  true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    $('#data_expedicao_identidade').datepicker({
        autoclose:  true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    $('#titulo_eleitor_emissao').datepicker({
        autoclose:  true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
    
    $('#certificado_militar_emissao').datepicker({
        autoclose:  true,
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });
    
    formataTelefoneFixo('#telefone');
    formataTelefone('#celular');

    $('#cep').mask('99.999?-999');

    $('#enviar_foto').click(function(){
        $('#anexo').click();
    });

    $('#frmDadosPessoais').submit(function(){
        var retorno = false;

        var erro = 0;

        var texto = '';

        if($('#estrangeiro').val() == 0)
        {
            if($('#cpf').val() == '')
            {
                texto += 'O campo CPF é obrigatório!';
            }
            else
            {
                var cpf = $('#cpf').val();

                var cpfpuro = '';

                if(cpf.indexOf('.') != -1 || cpf.indexOf('-') != -1)
                {
                  cpfpuro = cpf.replace(/[\.-]/g,'');
                }
                else{
                  cpfpuro = cpf;
                }

                if(!validaCPF(cpfpuro))
                {
                    texto += 'Este cpf é inválido';
                }
            }
        }
        else
        {
            if($('#passaporte').val()=='')
            {
                texto += 'O campo Passaporte é obrigatório!';
            }
        }


        if(texto == '')
        {
            retorno = true;
        }
        else
        {

            $('#myModal').on('show.bs.modal', function (event) {
              var modal = $(this);
              modal.find('.modal-title').text('Houve um erro!');
              modal.find('.modal-body').text(texto);
            });

            $('#myModal').modal('show');

            retorno = false;
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
        // $("li[id=nav_finish]").attr('style', 'display: none;');
    });

    $("a[id=steps-uid-0-t-1]").click(function(event){
        event.preventDefault();
        $("#step0, #step2, #step3").hide();
        $("#step1").show();
        $("#step0_tab, #step2_tab, #step3_tab").attr('class', 'done');
        $("#step1_tab").attr('class', 'current');
        page = 1;
        $("li[id=previous]").attr('class', '');
        $("li[id=next]").attr('class', '');
        // $("li[id=nav_finish]").attr('style', 'display: none;');
    });

    $("a[id=steps-uid-0-t-2]").click(function(event){
        event.preventDefault();
        $("#step0, #step1, #step3").hide();
        $("#step2").show();
        $("#step0_tab, #step1_tab, #step3_tab").attr('class', 'done');
        $("#step2_tab").attr('class', 'current');
        page = 2;
        $("li[id=previous]").attr('class', '');
        $("li[id=next]").attr('class', '');
        // $("li[id=nav_finish]").attr('style', 'display: none;');
    });

    $("a[id=steps-uid-0-t-3]").click(function(event){
        event.preventDefault();
        $("#step0, #step1, #step2").hide();
        $("#step3").show();
        $("#step0_tab, #step1_tab, #step2_tab").attr('class', 'done');
        $("#step3_tab").attr('class', 'current');
        page = 3;
        $("li[id=previous]").attr('class', '');
        $("li[id=next]").attr('class', 'disabled');
        // $("li[id=nav_finish]").show('fast');
    });


    $("a[id=nav_form]").click(function(event)
    {
        event.preventDefault();
        var action = $(this).attr( "href" );
        if(action == '#next')
        {
            if(page < 3)
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
        if(page < 3)
        {
            $("li[id=next]").attr('class', '');
            // $("li[id=nav_finish]").attr('style', 'display: none;')
        }
        else
        {
            $("li[id=next]").attr('class', 'disabled');
            // $("li[id=nav_finish]").show('fast');
        }
        $("#step0, #step1, #step2,#step3").hide();
        $("#step"+page).show();
        $("#step0_tab, #step1_tab, #step2_tab, #step3_tab").attr('class', 'done');
        $("#step"+page+"_tab").attr('class', 'current');
    });

    //exibe alerta para qualquer upload feito no sistema
    $('input[type=file]').click(function()
    {
        alert('É de sua responsabilidade que o documento esteja legível. Só será aceito os seguintes formatos: PDF, JPG, JPEG e PNG');
    });
    // jquery que permite apenas numeros nos inputs
    $(".justNumbers").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    //exibe imagem de upload do perfil
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#imgPerfil').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#anexo").change(function(){
        readURL(this);
    });
    // auto complete para estados e países
    //lista com alguns países
    var availableCountries = [
      "África do Sul",
      "Alemanha",
      "Angola",
      "Argélia",
      "Argentina",
      "Austrália",
      "Bélgica",
      "Bolívia",
      "Brasil",
      "Canada",
      "Chile",
      "Colômbia",
      "Costa do Marfim",
      "Costa Rica",
      "Croácia",
      "Cuba",
      "Equador",
      "Estados Unidos",
      "França",
      "Grécia",
      "Itália",
      "Jamaica",
      "Marrocos",
      "México",
      "Portugal",
      "Russia",
      "Uruguai",
      "venezuela",
    ];
    $( "#pais" ).autocomplete({
      source: availableCountries
    });

    $("#pais").change(function(){
        var html = '';
        if($( this ).val() == "BR" || $( this ).val() == "br" || $( this ).val() == "Br" || $( this ).val() == "Brasil" || $( this ).val() == "brasil"){
          $( this ).val('Brasil');
          html += '';
          html += '<select name="estado" id="estado" style="width: 100%;" class="form-control">';
          html += '   <option value="Alagoas">Alagoas</option>';
          html += '   <option value="Amapá">Amapá</option>';
          html += '   <option value="Amazonas">Amazonas</option>';
          html += '   <option value="Bahia">Bahia</option>';
          html += '   <option value="Ceará">Ceará</option>';
          html += '   <option value="Distrito Federal">Distrito Federal</option>';
          html += '   <option value="Espírito Santo">Espírito Santo</option>';
          html += '   <option value="Goiás">Goiás</option>';
          html += '   <option value="Maranhão">Maranhão</option>';
          html += '   <option value="Mato Grosso">Mato Grosso</option>';
          html += '   <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>';
          html += '   <option value="Minas Gerais">Minas Gerais</option>';
          html += '   <option value="Pará">Pará</option>';
          html += '   <option value="Paraíba">Paraíba</option>';
          html += '   <option value="Paraná">Paraná</option>';
          html += '   <option value="Pernambuco">Pernambuco</option>';
          html += '   <option value="Piauí">Piauí</option>';
          html += '   <option value="Rio de Janeiro" selected="SELECTED">Rio de Janeiro</option>';
          html += '   <option value="Rio Grande do Norte">Rio Grande do Norte</option>';
          html += '   <option value="Rio Grande do Sul">Rio Grande do Sul</option>';
          html += '   <option value="Rondônia">Rondônia</option>v';
          html += '   <option value="Roraima">Roraima</option>';
          html += '   <option value="Santa Catarina">Santa Catarina</option>';
          html += '   <option value="São Paulo">São Paulo</option>';
          html += '   <option value="Sergipe">Sergipe</option>';
          html += '   <option value="Tocantins">Tocantins</option>';
          html += '</select>';
        }else{
          html += '<input type="text" name="estado" id="estado" class="form-control" value="">';
        }
        $('#div-estado-field').html(html);
    })

    function RequiredFields() {
        var sexo = $('#sexo').val();
        var estrangeiro = $('#estrangeiro').val();
        if(estrangeiro==1){
          $('.nao-estrangeiro').hide();
        } else{
          $('.nao-estrangeiro').show();
          if(sexo == "Masculino"){
            $('.apenas-homem').show();
          } else {
            $('.apenas-homem').hide();
          }
        }
    }
    $('#sexo').change(function(){
      RequiredFields();
    });
    $('#estrangeiro').change(function(){
      RequiredFields();
    });
    RequiredFields();
 });
    /* fim script abas */

</script>

@stop
@section('content')

<?php

    $nome_completo       = $candidato->nome;
    $email               = $candidato->email;
    $sexo                = $candidato->sexo;
    $data_nascimento     = $candidato->nascimento=='0000-00-00'?'':$candidato->nascimento;
    $cidade_nascimento   = $candidato->cidadenasc;
    $estrangeiro         = $candidato->estrangeiro;
    $nacionalidade       = $candidato->nacionalidade;
    $estado_civil        = $candidato->estcivil;
    $foto                = $candidato->foto != '' ? $candidato->foto : 'images/assets/no-photo.png';

    if($candidato->endereco!=null)
    {
        $endereco = $candidato->endereco->endereco;
        $bairro   = $candidato->endereco->bairro;
        $cidade   = $candidato->endereco->cidade;
        $estado   = $candidato->endereco->estado;
        $pais     = $candidato->endereco->pais;
        $cep      = $candidato->endereco->cep;
    }
    else
    {
        $endereco = '';
        $bairro   = '';
        $cidade   = '';
        $estado   = '';
        $pais     = '';
        $cep      = '';
    }

    $identidade                  = $candidato->ident;
    $data_expedicao_identidade   = $candidato->expedicao=='0000-00-00'?'':$candidato->expedicao;
    $orgao_expedidor_identidade  = $candidato->orgaoexped;
    $estado_expedidor_identidade = $candidato->estexped;
    $cpf                         = $candidato->cpf;
    $passaporte                  = $candidato->passaporte;
    $titulo_eleitor              = $candidato->tituloeleitor;
    $titulo_eleitor_zona         = $candidato->tituloeleitorzona;
    $titulo_eleitor_secao        = $candidato->tituloeleitorsecao;
    $titulo_eleitor_uf           = $candidato->tituloeleitoruf;
    $titulo_eleitor_emissao      = $candidato->tituloeleitoremissao=='0000-00-00'?'':$candidato->tituloeleitoremissao;
    $certificado_militar         = $candidato->certmilitar;
    $certificado_militar_categoria = $candidato->certmilitarcategoria;
    $certificado_militar_orgao   = $candidato->certmilitarorgao;
    $certificado_militar_uf      = $candidato->certmilitaruf;
    $certificado_militar_emissao = $candidato->certmilitaremissao=='0000-00-00'?'':$candidato->certmilitaremissao;
    $telefone                    = $candidato->telefone;
    $celular                     = $candidato->celular;
    $nome_mae                    = $candidato->nomemae;
    $nome_pai                    = $candidato->nomepai;
    $qtd_dependentes             = $candidato->numdeps;
    $qtd_filhos                  = $candidato->numfilhos;
    $idades_filhos               = $candidato->idadefilhos;
    $tipo_sanguineo              = $candidato->tiposanguineo;
    $fator_rh                    = $candidato->fatorrh;
    $cor_pele                    = $candidato->corpele;
?>

@include('elements.alerts')

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<form id="frmDadosPessoais"
      class="form-horizontal ng-pristine ng-valid"
      role="form"
      method="POST"
      action="candidato/meusdados/dados-pessoais"
      enctype="multipart/form-data">

      @if(Request::is('adm/*'))
        <input type="hidden" name="id_usuario" value="{{$candidato->id}}" />
      @endif

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Pessoais</strong></div>

        <div class="panel-body">

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Principal</a></li>

                    <li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Endereço</a></li>

                    <li id="step2_tab" role="tab" class="done"><a id="steps-uid-0-t-2" href="#steps-uid-0-t-2"><span class="number">3.</span> Documentos</a></li>

                    <li id="step3_tab" role="tab" class="last done"><a id="steps-uid-0-t-3" href="#steps-uid-0-t-3"><span class="number">4.</span> Outros Detalhes</a></li>

                </ul>

            </div>

            <div class="content clearfix">

                <h1 id="step0_h1" tabindex="-1" class="title current">1. Principal</h1>

                <div id="step0" class="current" style="display: block;">

                    <section class="panel panel-default">

                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Iniciais</strong></div>-->

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="nome_completo" class="col-sm-3">Nome Completo<span class="required-field">*</span></label>

                                        <div class="col-sm-9">

                                            <input type="text" name="nome_completo" id="nome_completo" class="form-control" value="{{ $nome_completo }}">

                                        </div>

                                    </div>

                                    <div id="email">

                                        <div class="form-group">

                                            <label for="email" class="col-sm-3">Email<span class="required-field">*</span></label>

                                            <div class="col-sm-9">

                                                <input type="email" name="email" id="email" class="form-control" value="{{ $email }}">

                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="sexo" class="col-sm-3">Sexo<span class="required-field">*</span></label>


                                        <div class="col-sm-9">
                                            <span class="ui-select">

                                                <select name="sexo" id="sexo" style="margin: 0 !important;">

                                                    <option value="Masculino" @if($sexo=='Masculino') selected="selected" @endif>Masculino</option>

                                                    <option value="Feminino" @if($sexo=='Feminino') selected="selected" @endif>Feminino</option>

                                                    <option value="Outros" @if($sexo=='Outros') selected="selected" @endif>Outros</option>

                                                </select>

                                            </span>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="data_nascimento" class="col-sm-3">Nascimento<span class="required-field">*</span></label>

                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="data_nascimento" id="data_nascimento" class="form-control" value="{{ $data_nascimento }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group" >
                                        <label for="cidade_nascimento" class="col-sm-3">Cidade de Nascimento<span class="required-field">*</span></label>

                                        <div class="col-sm-9">

                                            <input type="text" name="cidade_nascimento" class="form-control" value="{{ $cidade_nascimento }}">

                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="estrangeiro" class="col-sm-3">É estrangeiro?<span class="required-field">*</span></label>


                                        <div class="col-sm-9">
                                            <span class="ui-select">

                                                <select name="estrangeiro" id="estrangeiro" style="margin: 0 !important;">

                                                    <option value="0" @if($estrangeiro == '0') selected="selected" @endif>Não</option>

                                                    <option value="1"  @if($estrangeiro == '1') selected="selected" @endif>Sim</option>

                                                </select>

                                            </span>
                                        </div>

                                    </div>

                                    <div class="form-group" >
                                        <label for="nacionalidade" class="col-sm-3">Nacionalidade<span class="required-field">*</span></label>

                                        <div class="col-sm-9">

                                            <input type="text" name="nacionalidade" class="form-control" value="{{ $nacionalidade }}">

                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="estado_civil" class="col-sm-3">Estado Civil<span class="required-field">*</span></label>

                                        <div class="col-sm-9">
                                            <span class="ui-select">
                                                <select name="estado_civil" id="estado_civil" style="margin: 0 !important;">

                                                    @if(isset($all_estados_civis) && $all_estados_civis->count() > 0)
                                                        @foreach($all_estados_civis as $all_estado_civil)
                                                            <option value="{{ $all_estado_civil->nome }}" @if($all_estado_civil->getEstadoCivil() == strtoupper(substr($candidato->estcivil,0,3))) selected="selected" @endif>{{ $all_estado_civil->nome }}</option>
                                                        @endforeach
                                                    @endif

                                                </select>

                                            </span>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="form-group" style="text-align: center;">
                                        <button type="button" id="enviar_foto" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Enviar Foto</button>
                                        <input type="file" name="anexo" id="anexo" style="visibility: hidden;">
                                    </div>
                                    <hr>
                                    <p>Conclua o cadastro para salvar a imagem</p>
                                    <div class="form-group" style="text-align: center;">
                                        <!-- <img src="images/assets/no-photo.png"> -->
                                        <img src="{{ $foto }}" style="max-width: 547.5px;mas-height:448px;" id="imgPerfil">
                                    </div>
                                </div>
                        </div>

                    </section>

                </div>


                <h1 id="step1_h1" tabindex="-1" class="title">2. Endereço</h1>

                <div id="step1" class="current" style="display: none;">



                    <section class="panel panel-default">



                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados cadastrais adicionais</strong></div>-->

                        <div class="panel-body">



                            <div class="row">

                                <div class="col-md-6">

                                    <!-- *** -->

                                    <div class="row" id="endereco">

                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <label for="endereco" class="col-sm-2">Endereço<span class="required-field">*</span></label>

                                                <div class="col-sm-10">

                                                    <input type="text" name="endereco" id="endereco" class="form-control" value="{{ $endereco }}">

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="bairro" class="col-sm-2">Bairro<span class="required-field">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $bairro }}">
                                                </div>
                                            </div>
                                            <!--<button type="button" class="btn btn-inverse btn-block addEndereco">Adicionar outro endereço</button>-->
                                            <!--<hr/>-->
                                        </div>
                                    </div>
                                </div>
                                <!-- *** -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pais" class="col-sm-2">País<span class="required-field">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="pais" id="pais" class="form-control" value="{{ $pais }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="estado" class="col-sm-2" id="div-estado-label">Estado<span class="required-field">*</span></label>
                                        <div class="col-sm-10" id="div-estado-field">
                                            @if($pais == "BR" || $pais == "br" || $pais == "Br" || $pais == "Brasil" || $pais == "brasil")
                                              <select name="estado" id="estado" style="width: 100%;" class="form-control">
                                                  @if(isset($all_estados) && $all_estados->count() > 0)
                                                      @foreach($all_estados as $all_estado)
                                                          <option value="{{ $all_estado->descricao }}" @if($all_estado->descricao == $estado) SELECTED="SELECTED" @endif >{{ $all_estado->descricao }}</option>
                                                      @endforeach
                                                  @endif
                                              </select>
                                            @else
                                              <input type="text" name="estado" id="estado" class="form-control" value="{{ $estado }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cidade" class="col-sm-2">Cidade<span class="required-field">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $cidade }}">
                                        </div>
                                    </div>
                                    <div class="form-group cep">
                                        <label for="label-focus" class="col-sm-2">CEP<span class="required-field">*</span></label>
                                        <div class="col-sm-5">
                                            <input type="text" name="cep" id="cep" class="form-control" value="{{ $cep }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </section>
                </div>
                <h1 id="step2_h1" tabindex="-1" class="title">3. Documentos</h1>
                <div id="step2" class="current" aria-hidden="true" style="display: none;">
                    <div class="panel panel-default">
                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span>Produtos disponíveis para este associado</strong></div>-->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="identidade" class="col-sm-3">Identidade<span class="required-field nao-estrangeiro">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="identidade" id="identidade" class="form-control justNumbers" value="{{ $identidade }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="identidade_arquivo" class="col-sm-3">Identidade Arquivo<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-7">

                                            {{ Form::file('identidade_arquivo') }}

                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->identidade_img))

                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" target="_blank">
                                                    @if(strpos($candidato->identidade_img, ".jpg") || strpos($candidato->identidade_img, ".jpeg") || strpos($candidato->identidade_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" />
                                                    @elseif(!empty($candidato->identidade_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="identidade_verso_arquivo" class="col-sm-3">Identidade Verso Arquivo<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-7">

                                            {{ Form::file('identidade_verso_arquivo') }}

                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->identidade_verso_img))
                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" target="_blank">
                                                    @if(strpos($candidato->identidade_verso_img, ".jpg") || strpos($candidato->identidade_verso_img, ".jpeg") || strpos($candidato->identidade_verso_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" />
                                                    @elseif(!empty($candidato->identidade_verso_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->identidade_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" frameborder="0" width="61.25px" height="91.063px" style="width:61.25px;height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="data_expedicao_identidade" class="col-sm-3">Data de expedição<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="data_expedicao_identidade" id="data_expedicao_identidade" class="form-control" value="{{ $data_expedicao_identidade }}">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="orgao_expedidor_identidade" class="col-sm-3">Órgão Expedidor<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-9">

                                            <input type="text" name="orgao_expedidor_identidade" id="orgao_expedidor_identidade" class="form-control" value="{{ $orgao_expedidor_identidade }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="estado_expedidor_identidade" class="col-sm-3">Estado de Expedição<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-9">

                                            <select name="estado_expedidor_identidade" id="estado_expedidor_identidade" style="width: 100%;" class="form-control">

                                                @if(isset($all_estados) && $all_estados->count() > 0)
                                                    @foreach($all_estados as $all_estado)
                                                        <option value="{{ $all_estado->descricao }}" @if($all_estado->descricao == $estado_expedidor_identidade) SELECTED="SELECTED" @endif >{{ $all_estado->descricao }}</option>
                                                    @endforeach
                                                @endif

                                            </select>

                                            <!-- <input type="text" name="estado_expedidor_identidade" id="estado_expedidor_identidade" class="form-control" value="{{ $estado_expedidor_identidade }}"> -->

                                        </div>

                                    </div>
                                    @if(isset($imagens) && is_array($imagens) && !empty($imagens))
                                    {{debug($imagens)}}
                                      @foreach($imagens as $titulo => $arrImage)
                                        <div class="form-group">
                                          <label class="col-sm-3">{{$titulo}}</label>
                                          @foreach($arrImage as $imagem)
                                            <div class="form-group">
                                              <div class="col-sm-9 col-sm-offset-3">
                                                <a href="{{$imagem}}" target="_blank">
                                                  @if(strpos($imagem, ".jpg") || strpos($imagem, ".jpeg") || strpos($imagem, ".png"))
                                                    <img class="img-responsive" src="{{$imagem}}" width="61.25px" height="91.063px" />
                                                  @elseif(!empty($imagem))
                                                    <iframe src="{{$imagem}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" frameborder="0" width="61.25px" height="91.063px" style="width:61.25px;height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                  @else
                                                        <p> Sem Imagem </p>
                                                  @endif
                                                </a>
                                              </div>
                                            </div>
                                          @endforeach
                                        </div>
                                      @endforeach
                                    @endif
  

                                    <div class="form-group">

                                        <label for="cpf" class="col-sm-3">CPF<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="cpf" id="cpf" class="form-control" value="{{ $cpf }}">
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="cpf_arquivo" class="col-sm-3">Curriculo LATTES<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-7">
                                            {{ Form::file('cpf_arquivo') }}
                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->cpf_img))
                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" target="_blank">
                                                    @if(strpos($candidato->cpf_img, ".jpg") || strpos($candidato->cpf_img, ".jpeg") || strpos($candidato->cpf_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" />
                                                    @elseif($candidato->cpf_img)
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->cpf_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="passaporte" class="col-sm-3">Passaporte<span class="required-field estrangeiro" style="display:none;">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="passaporte" id="passaporte" class="form-control" value="{{ $passaporte }}">
                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor<span class="required-field nao-estrangeiro">*</span></label>

                                        <div class="col-sm-9">
                                            <input type="text" name="titulo_eleitor" id="titulo_eleitor" class="form-control justNumbers" value="{{ $titulo_eleitor }}">
                                        </div>

                                    </div>
                                                                   
                                    
                                    <div class="form-group">
                                        <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Zona<span class="required-field nao-estrangeiro">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="titulo_eleitor_zona" id="titulo_eleitor_zona" class="form-control justNumbers" value="{{ $titulo_eleitor_zona }}">
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Seção<span class="required-field nao-estrangeiro">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="titulo_eleitor_secao" id="titulo_eleitor_secao" class="form-control justNumbers" value="{{ $titulo_eleitor_secao }}">
                                        </div>
                                    </div>                                  
                                  
                                   <div class="form-group">
                                        <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Estado Emissor<span class="required-field nao-estrangeiro">*</span></label>
                                        <div class="col-sm-9">
                                          
                                            <select name="titulo_eleitor_uf" id="titulo_eleitor_uf" style="width: 100%;" class="form-control">

                                                @if(isset($all_estados) && $all_estados->count() > 0)
                                                    @foreach($all_estados as $all_estado)
                                                        <option value="{{ $all_estado->descricao }}" @if($all_estado->descricao == $titulo_eleitor_uf) SELECTED="SELECTED" @endif >{{ $all_estado->descricao }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>                                         
                                    
                                    <div class="form-group">
                                        <label for="titulo_eleitor_emissao" class="col-sm-3">Título de eleitor emissão<span class="required-field nao-estrangeiro">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="titulo_eleitor_emissao" id="titulo_eleitor_emissao" class="form-control" value="{{ $titulo_eleitor_emissao }}">
                                            </div>
                                        </div>
                                    </div>
                 

                                    <div class="form-group">

                                        <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Arquivo</label>

                                        <div class="col-sm-7">
                                            {{ Form::file('titulo_eleitor_arquivo') }}
                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->titulo_eleitor_img))
                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" target="_blank">
                                                    @if(strpos($candidato->titulo_eleitor_img, ".jpg") || strpos($candidato->titulo_eleitor_img, ".jpeg") || strpos($candidato->titulo_eleitor_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" />
                                                    @elseif(!empty($candidato->titulo_eleitor_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">

                                      <label for="titulo_eleitor" class="col-sm-3">Titulo de eleitor Verso Arquivo</label>


                                        <div class="col-sm-7">
                                            {{ Form::file('titulo_eleitor_verso_arquivo') }}
                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->titulo_eleitor_verso_img))
                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_verso_img}}" target="_blank">
                                                    @if(strpos($candidato->titulo_eleitor_verso_img, ".jpg") || strpos($candidato->titulo_eleitor_verso_img, ".jpeg") || strpos($candidato->titulo_eleitor_verso_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_verso_img}}" />
                                                    @elseif(!empty($candidato->titulo_eleitor_verso_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->titulo_eleitor_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar<span class="required-field nao-estrangeiro apenas-homem reservista">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="certificado_militar" id="certificado_militar" class="form-control justNumbers" value="{{ $certificado_militar }}">
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar Categoria<span class="required-field nao-estrangeiro apenas-homem reservista">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="certificado_militar_categoria" id="certificado_militar_categoria" class="form-control" value="{{ $certificado_militar_categoria }}">
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar Órgão<span class="required-field nao-estrangeiro apenas-homem reservista">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" name="certificado_militar_orgao" id="certificado_militar_orgao" class="form-control" value="{{ $certificado_militar_orgao }}">
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar Estado Emissor<span class="required-field nao-estrangeiro apenas-homem reservista">*</span></label>
                                        <div class="col-sm-9">
                                             <select name="certificado_militar_uf" id="certificado_militar_uf" style="width: 100%;" class="form-control">

                                                @if(isset($all_estados) && $all_estados->count() > 0)
                                                    @foreach($all_estados as $all_estado)
                                                        <option value="{{ $all_estado->descricao }}" @if($all_estado->descricao == $certificado_militar_uf) SELECTED="SELECTED" @endif >{{ $all_estado->descricao }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="certificado_militar_emissao" class="col-sm-3">Certificado Militar emissão<span class="required-field nao-estrangeiro apenas-homem reservista">*</span></label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" name="certificado_militar_emissao" id="certificado_militar_emissao" class="form-control" value="{{ $certificado_militar_emissao }}">
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="form-group">

                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar Arquivo</label>


                                        <div class="col-sm-7">
                                            {{ Form::file('certificado_militar_arquivo') }}
                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->certificado_militar_img))

                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" target="_blank">
                                                    @if(strpos($candidato->certificado_militar_img, ".jpg") || strpos($candidato->certificado_militar_img, ".jpeg") || strpos($candidato->certificado_militar_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" />
                                                    @elseif(!empty($candidato->certificado_militar_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="certificado_militar" class="col-sm-3">Certificado Militar Verso Arquivo</label>



                                        <div class="col-sm-7">
                                            {{ Form::file('certificado_militar_verso_arquivo') }}
                                        </div>

                                        <div class="col-sm-2">
                                            @if(isset($candidato) && isset($candidato->certificado_militar_verso_img))

                                                <a href="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" target="_blank">
                                                    @if(strpos($candidato->certificado_militar_verso_img, ".jpg") || strpos($candidato->certificado_militar_verso_img, ".jpeg") || strpos($candidato->certificado_militar_verso_img, ".png"))
                                                        <img class="img-responsive" src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" />
                                                    @elseif(!empty($candidato->certificado_militar_verso_img))
                                                        <iframe src="uploads/usuarios/{{$candidato->id}}/documentos/{{$candidato->certificado_militar_verso_img}}" scrolling="no" frameborder="0" width="61.25px" height="91.063px" style="max-width:61.25px;max-height:91.063px;overflow:hidden;"></iframe><br />Visualizar
                                                    @else
                                                        <p> Sem Imagem </p>
                                                    @endif
                                                </a>

                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <hr/>

                            </div>


                            @if(Session::has('perfil') && Session::get('perfil') != 2)
                            <hr>

                            <div class="row">

                              <div class="col-md-6">
                                  <h2> Formações </h2>

                                  @forelse($candidato->formacoes as $f)
                                  <div class="row" style="border-top: 1px solid;">
                                      <div class="col-md-2">
                                        <h4>{{ $f->formacao }}</h4>
                                        <h3>{{ $f->instituicao }} - {{$f->curso}}</h3>
                                      </div>

                                      <div class="col-md-10">
                                        @forelse($f->imagens as $i)
                                          <div class="col-md-3">
                                            <div class="thumbnail">

                                              {? $explode = explode('.', $i->nome) ?}

                                              <a href="{{$i->caminho}}{{$i->nome}}" target="_blank"><img alt="" src="@if($explode[1] != 'pdf') {{$i->caminho}}{{$i->nome}} @else {{URL::to('images/')}}/doc.png @endif">
                                                <div class="caption">
                                                    <h4>  {{$i->titulo}}  </h4>
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


                              <div class="col-md-6">
                                  <h2> Experiências </h2>

                                  @forelse($candidato->experiencias as $f)
                                  <div class="row" style="border-top: 1px solid;">
                                      <div class="col-md-2">
                                        <h4>{{ $f->empresa }}</h4>
                                        <h3>{{ $f->funcao }} </h3>
                                      </div>

                                      <div class="col-md-10">

                                      </div>
                                    </div>
                                  @empty
                                      <p>Usuário não possui formações</p>
                                  @endforelse

                              </div>



                            </div>

                            @endif

                        </div>
                    </div>

                </div>

                <h1 id="step3_h1" tabindex="-1" class="title">4. Outros Detalhes</h1>

                <div id="step3" class="current" aria-hidden="true" style="display: none;">

                    <div class="panel panel-default">

                        <!--<div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span>Produtos disponíveis para este associado</strong></div>-->

                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="telefone" class="col-sm-2">Telefone Residencial<span class="required-field">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="telefone" id="telefone" class="form-control" value="{{ $telefone }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="celular" class="col-sm-2">Celular<span class="required-field">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="celular" id="celular" class="form-control" value="{{ $celular }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="nome_mae" class="col-sm-2">Nome da mãe <span class="required-field">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nome_mae" id="nome_mae" class="form-control" value="{{ $nome_mae }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="nome_pai" class="col-sm-2">Nome do pai</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nome_pai" id="nome_pai" class="form-control" value="{{ $nome_pai }}">

                                        </div>

                                    </div>
                                </div>
                              
                                       
                              
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="tipo_sanguineo" class="col-sm-2">Tipo Sanguíneo</label>
                                            <div class="col-sm-9">
                                            <span class="ui-select">
                                                <select name="tipo_sanguineo" id="tipo_sanguineo" style="margin: 0 !important;">
                                                    <option value="A" @if($tipo_sanguineo=='A') selected="selected" @endif>A</option>
                                                    <option value="B" @if($tipo_sanguineo=='B') selected="selected" @endif>B</option>
                                                    <option value="AB" @if($tipo_sanguineo=='AB') selected="selected" @endif>AB</option>
                                                    <option value="O" @if($tipo_sanguineo=='O') selected="selected" @endif>O</option>
                                                </select>
                                            </span>                                      
                                           </div>
                                    </div>
                                      
                                  
                                    <div class="form-group">
                                        <label for="fator_rh" class="col-sm-2">Fator RH</label>
                                        <div class="col-sm-9">
                                            <span class="ui-select">
                                                <select name="fator_rh" id="fator_rh" style="margin: 0 !important;">
                                                    <option value="+" @if($fator_rh=='+') selected="selected" @endif>+</option>
                                                    <option value="-" @if($fator_rh=='-') selected="selected" @endif>-</option>
                                                </select>
                                            </span>                                      
                                           </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="cor_pele" class="col-sm-2">Cor</label>
                                            <div class="col-sm-9">
                                            <span class="ui-select">
                                                <select name="cor_pele" id="cor_pele" style="margin: 0 !important;">
                                                    <option value="amarela" @if($cor_pele=='amarela') selected="selected" @endif>amarela</option>
                                                    <option value="branca" @if($cor_pele=='branca') selected="selected" @endif>branca</option>
                                                    <option value="índio" @if($cor_pele=='índio') selected="selected" @endif>índio</option>
                                                    <option value="parda" @if($cor_pele=='parda') selected="selected" @endif>parda</option>
                                                    <option value="preta" @if($cor_pele=='preta') selected="selected" @endif>preta</option>                                                    
                                                </select>
                                            </span>                                      
                                           </div>                                     
                                    </div>
                                  
                                  
                                    <div class="form-group">

                                        <label for="qtd_dependentes" class="col-sm-2">Número de dependentes<span class="required-field">*</span></label>

                                        <div class="col-sm-10">
                                                <!--
                                                <span class="ui-select">

                                                <select name="qtd_dependentes" id="qtd_dependentes" style="width: 100%;">

                                                    <option value="0">Nenhum</option>

                                                    <option value="1">1</option>

                                                    <option value="2">2</option>

                                                </select>

                                            </span>
                                            -->

                                            <input type="text" name="qtd_dependentes" id="qtd_dependentes" class="form-control justNumbers" value="{{ $qtd_dependentes }}">
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="qtd_filhos" class="col-sm-2">Número de filhos</label>

                                        <div class="col-sm-10">
                                            <!--
                                                <span class="ui-select">

                                                <select name="qtd_filhos" id="qtd_filhos" style="width: 100%;">

                                                    <option value="0">Nenhum</option>

                                                    <option value="1">1</option>

                                                    <option value="2">2</option>

                                                </select>

                                            </span>
                                            -->

                                            <input type="text" name="qtd_filhos" id="qtd_filhos" class="form-control justNumbers" value="{{ $qtd_filhos }}">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="idades_filhos" class="col-sm-2">Idades dos filhos</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="idades_filhos" id="idades_filhos" class="form-control" maxlength="50" placeholder="Ex.: 4;8" value="{{ $idades_filhos }}">
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
                    <li id="previous" class="disabled" title="Anterior"><a id="nav_form" href="#previous"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                    <li id="next" style="display: block;" title="Próximo"><a id="nav_form" href="#next"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
                    @if($permitSubmit)
                        <li id="nav_finish"  title="Salvar"><button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i></button></li>
                    @endif
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
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

@stop