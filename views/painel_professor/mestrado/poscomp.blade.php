@section('css')
    <link rel="stylesheet" href="styles/datepicker.css">
    <link rel="stylesheet" href="styles/datepicker3.css">
@stop
@section('scripts')
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>
<script type="text/javascript">
var acumulador = 0;
$( document ).ready(function() 
{

    //input[name=tel]    
    $("#cpf").mask("999.999.999-99");

    $('.tel').focusout(function()
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

    //$('#nascimento').mask('99/99/9999');

    $('#nascimento').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    $('.cep').mask('99.999-999');

    $('#enviar_foto').click(function(){
        $('#anexo').click();
    });

    /* script das abas */
    var page = 0;

    $("a[id=steps-uid-0-t-0]").click(function(event){

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

    $("a[id=steps-uid-0-t-1]").click(function(event){

        event.preventDefault();

        $("#step0, #step2, #step3").hide();

        $("#step1").show();

        $("#step0_tab, #step2_tab, #step3_tab").attr('class', 'done');

        $("#step1_tab").attr('class', 'current');

        page = 1;

        $("li[id=previous]").attr('class', '');

        $("li[id=next]").attr('class', '');

        $("li[id=nav_finish]").attr('style', 'display: none;');

    });

    $("a[id=steps-uid-0-t-2]").click(function(event){

        event.preventDefault();

        $("#step0, #step1, #step3").hide();

        $("#step2").show();

        $("#step0_tab, #step1_tab, #step3_tab").attr('class', 'done');

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

            if(page <3)

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



        $("#step0, #step1, #step2,#step3").hide();

        $("#step"+page).show();


        $("#step0_tab, #step1_tab, #step2_tab, #step3_tab").attr('class', 'done');

        $("#step"+page+"_tab").attr('class', 'current');



    });
    /* fim script abas */

    var countTelefone = 1;

    //addTelefone
    $('.addTelefone').click(function(){

        //alert('Adicionando novo campo Telefone');

        //{{ Input::old('tel') }}

        countTelefone++;

        divTelefone = $('#telefone');

        newDivTelefone  = '';

        newDivTelefone += '<div class="form-group" >';
        newDivTelefone += '<label for="label-focus" class="col-sm-2">Telefone</label>';
        newDivTelefone += '<div class="col-sm-5">';
        newDivTelefone += '<input type="text" name="tels_new[' + countTelefone + '][numero]" class="form-control tel" value="">';
        newDivTelefone += '</div>';
        newDivTelefone += '<label for="label-focus" class="col-sm-1" style="text-align: right;">Tipo</label>';
        newDivTelefone += '<div class="col-sm-4">';
        newDivTelefone += '<select name="tels_new[' + countTelefone + '][tipo]" class="form-control" required>';
        newDivTelefone += '<!-- recuperar do banco a lista de tipos de telefone -->';
            @if($tipos_telefones)
            @foreach($tipos_telefones as $tipo_telefone)
                newDivTelefone += '<option value="{{ $tipo_telefone->id }}">{{ $tipo_telefone->nome }}</option>';
            @endforeach
            @endif
        newDivTelefone += '</select>';
        newDivTelefone += '</div>';
        newDivTelefone += '<label for="label-focus" class="col-sm-2">&nbsp;</label>';
        newDivTelefone += '<div class="col-sm-10">';
        newDivTelefone += '</div>';
        newDivTelefone += '</div>';

        divTelefone.append(newDivTelefone);

        formataTelefone();
    });

    var countEmail = 0;

    //addEmail
    $('.addEmail').click(function(){
        //alert('Adicionando novo campo Email');

        countEmail++;

        divEmail = $('#email');

        //{{ Input::old('email') }}

        newDivEmail  = '';
        newDivEmail += '<div class="form-group">';
        newDivEmail += '<label for="label-focus" class="col-sm-2">Email Adicional</label>';
        newDivEmail += '<div class="col-sm-10">';
        newDivEmail += '<input type="email" name="emails_adicionais_new[]" id="email" class="form-control" value="">';
        newDivEmail += '</div>';
        newDivEmail += '</div>';

        divEmail.append(newDivEmail);
    });

    var countEndereco = 0;

    //addEndereco
    $('.addEndereco').click(function(){        

       //alert('Adicionando novo campo Endereco');

        countEndereco++;

        divEndereco = $('#endereco');

        //{{ Input::old('endereco') }}
        //{{ Input::old('complemento') }}
        //{{ Input::old('numero') }}
        //{{ Input::old('cep') }}

        newDivEndereco  = '';

        newDivEndereco += '<div class="col-md-12">';
        newDivEndereco += '<hr/>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="tipo_logradouro" class="col-sm-2">Tipo Logradouro</label>';
        newDivEndereco += '<div class="col-sm-10">';
        @if($tipos_logradouros)
            newDivEndereco += '<select name="enderecos_new[' + countEndereco + '][tipo_logradouro]" class="form-control">';
            @foreach($tipos_logradouros as $tipo_logradouro)
                newDivEndereco += '<option value="{{ $tipo_logradouro->id }}">{{ $tipo_logradouro->nome }}</option>';
            @endforeach
            newDivEndereco += '</select>';
        @endif
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Endereço</label>';
        newDivEndereco += '<div class="col-sm-10">';
        newDivEndereco += '<input type="text" name="enderecos_new[' + countEndereco + '][endereco]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Complemento</label>';
        newDivEndereco += '<div class="col-sm-5">';
        newDivEndereco += '<input type="text" name="enderecos_new[' + countEndereco + '][complemento]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">N°</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<input type="text" name="enderecos_new[' + countEndereco + '][numero]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Bairro</label>';
        newDivEndereco += '<div class="col-sm-5">';
        newDivEndereco += '<select name="enderecos_new[' + countEndereco + '][bairro]" class="form-control" required>';
        @if($bairros)
            @foreach($bairros as $bairro)
                newDivEndereco += '<option value="{{ $bairro->id }}">{{ $bairro->nome }}</option>';
            @endforeach
        @endif
        newDivEndereco += '</select>';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">Estado</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<select name="enderecos_new[' + countEndereco + '][estado]" class="form-control" required>';
        @if($estados)
            @foreach($estados as $estado)
                newDivEndereco += '<option value="{{ $estado->id }}">{{ $estado->uf }}</option>';
            @endforeach
        @endif
        newDivEndereco += '</select>';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Tipo</label>';
        newDivEndereco += '<div class="col-sm-5">';
        newDivEndereco += '<select name="enderecos_new[' + countEndereco + '][tipo]" class="form-control" required>';
        @if($tipos_enderecos)
            @foreach($tipos_enderecos as $tipo_endereco)
                newDivEndereco += '<option value="{{ $tipo_endereco->id }}">{{ $tipo_endereco->nome }}</option>';
            @endforeach
        @endif
        newDivEndereco += '</select>';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">CEP</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<input type="text" name="enderecos_new[' + countEndereco + '][cep]" class="form-control cep" value="">';
        newDivEndereco += '<!--<button type="button" id="bt_cep"><span class="glyphicon glyphicon-search"></span></button>-->';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';

        divEndereco.append(newDivEndereco);           

        $('.cep').mask('99.999-999');
    });

});

function formataTelefone() {
    $('.tel').focusout(function()
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

function exibirProdutos(id) 
{
    $('#linha-produtos-'+id).toggle("slow");
}

</script>

@stop
@section('content')

<?php
    $acao = URL::to('person') . '/' . $pessoa->id;

    if(isset($pessoa)) {
        $nome                = $pessoa->nome;
        $sobrenome           = $pessoa->sobrenome;

        $apelido             = $pessoa->apelido;
        $cpf                 = $pessoa->cpf;
        $identidade          = $pessoa->identidade;
        
        if ($pessoa->nascimento != "" && $pessoa->nascimento != '0000-00-00') {
            $nascimento          = date('d/m/Y',strtotime($pessoa->nascimento));
        } else {
            $nascimento = '';
        }
        
        $sexo                = $pessoa->sexo;
        $email               = $pessoa->email;
        $nacionalidade       = $pessoa->nacionalidade;
        $naturalidade        = $pessoa->naturalidade;        
        $estadocivil         = $pessoa->estadoCivil;
        $matricula           = $pessoa->matricula;
        $empresa             = $pessoa->empresa;
        $cargo               = $pessoa->cargo;
        $profissao           = $pessoa->profissao;
    
        $profiles          = $pessoa->profiles;
        $profile           = $pessoa->profiles->first();
        $telefones         = $pessoa->telefones;
        $emails_adicionais = $pessoa->emailsAdicionais;
        $enderecos         = $pessoa->enderecos;


    } else {
        $nome                = '';
        $sobrenome           = '';
        $apelido             = '';
        $cpf                 = '';
        $identidade          = '';
        $tel                 = '';
        $nascimento          = '';
        $sexo                = '';
        $email               = '';
        $nacionalidade       = '';
        $naturalidade        = '';        
        $estado_civil        = '';
        $empresa             = '';
        $cargo               = '';
        $profissao           = '';
        $telefones           = '';
        $enderecos           = '';
    }
        
?>

@include('elements.alerts')

<div class="page ng-scope">

<form class="form-horizontal ng-pristine ng-valid" role="form" method="POST" action="{{ $acao }}" enctype="multipart/form-data">
@if(isset($pessoa))
<input name="_method" type="hidden" value="PUT">
{{ Form::token() }}
@endif

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Editando {{ $profile->name or '' }} {{$nome}} {{$sobrenome}} </strong></div>

        <div class="panel-body">

            <!-- if there are creation errors, they will show here -->
            {{-- HTML::ul($errors->all()) --}}        

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Cadastro Inicial</a></li>

                    <li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Outras Informações</a></li>

                    <li id="step2_tab" role="tab" class="done"><a id="steps-uid-0-t-2" href="#steps-uid-0-t-2"><span class="number">3.</span> Produtos deste associado</a></li>

                </ul>

            </div>

            <div class="content clearfix">

                <h1 id="step0_h1" tabindex="-1" class="title current">1. Cadastro Inicial</h1>

                <div id="step0" class="current" style="display: block;">

                    <section class="panel panel-default">

                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados Iniciais</strong></div>

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="" class="col-sm-2">Nome</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nome" id="nome" class="form-control" value="{{ $nome }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Sobrenome</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="{{ $sobrenome }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Apelido</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="apelido" id="apelido" class="form-control" value="{{ $apelido }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">CPF</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="cpf" id="cpf" class="form-control" value="{{ $cpf }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Identidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="identidade" id="identidade" class="form-control" value="{{ $identidade }}">

                                        </div>

                                    </div>

                                    <div id="telefone">
                                        @if($telefones && $telefones->count() > 0)

                                            @foreach($telefones as $telefone)

                                                <div class="form-group">
                                                    <input type="hidden" name="telefones[{{ $telefone->id }}][id]" value="{{ $telefone->id }}">

                                                    <label for="label-focus" class="col-sm-2">Telefone</label>

                                                    <div class="col-sm-5">

                                                        <input type="text" name="telefones[{{ $telefone->id }}][numero]" class="form-control tel" value="{{ $telefone->numero }}">                                            
                                                        
                                                    </div>

                                                    <label for="label-focus" class="col-sm-1" style="text-align: right;">Tipo</label>

                                                    <div class="col-sm-4">

                                                        <select name="telefones[{{ $telefone->id }}][tipo]" class="form-control" required>
                                                            <option>Selecione</option>

                                                            <!-- recuperar do banco a lista de tipos de telefone -->

                                                            @if(isset($tipos_telefones))
                                                                @foreach($tipos_telefones as $tipo_telefone)
                                                                    <option value="{{ $tipo_telefone->id }}" @if($tipo_telefone->id == $telefone->id_tipo_telefone) selected @endif>{{ $tipo_telefone->nome }}</option>
                                                                @endforeach
                                                            @endif
                                                                                                                
                                                        </select>

                                                    </div>                                                    
                                                </div>
                                            @endforeach

                                        
                                        @else
                                            <script type="text/javascript">
                                                $(document).ready(function()
                                                {
                                                    $( ".addTelefone" ).trigger( "click" );
                                                });                                               
                                            </script>
                                        @endif                                       

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">&nbsp;</label>
                                                        
                                        <div class="col-sm-10" style="padding: 0;">
                                            <button type="button" class="btn btn-inverse btn-block addTelefone">Adicionar outro telefone</button>                                      
                                        </div>

                                    </div>

                                    <div id="email">

                                        <div class="form-group">

                                            <label for="label-focus" class="col-sm-2">Email</label>

                                            <div class="col-sm-10">

                                                <input type="email" name="email" class="form-control" value="{{ $email }}">

                                            </div>

                                        </div>

                                        @if(isset($emails_adicionais) && $emails_adicionais->count() > 0)

                                            @foreach($emails_adicionais as $email_adicional)                                                
                                                <div class="form-group">

                                                    <label for="label-focus" class="col-sm-2">Email Adicional</label>

                                                    <div class="col-sm-10">

                                                        <input type="hidden" name="emails_adicionais[{{$email_adicional->id}}][id]" value="{{ $email_adicional->id }}">

                                                        <input type="email" name="emails_adicionais[{{$email_adicional->id}}][email]" class="form-control" value="{{ $email_adicional->email }}">

                                                    </div>

                                                </div>
                                            @endforeach
                                        @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="label-focus" class="col-sm-2">&nbsp;</label>

                                        <div class="col-sm-10" style="padding: 0;">
                                            <button type="button" class="btn btn-inverse btn-block addEmail">Adicionar outro email</button>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Nascimento</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nascimento" id="nascimento" class="form-control" value="{{ $nascimento }}">

                                        </div>

                                    </div>

                                    <hr/>

                                    <div class="form-group" style="text-align: center;">                                    
                                        <?php $checked = ''; ?>
                                        @if($perfis->count() > 0)

                                                @foreach ($perfis as $perfil)           

                                                    <?php $checked = ''; ?>

                                                    @foreach($profiles as $profile)

                                                        @if($perfil->id == $profile->id)

                                                            <?php $checked = 'checked'; ?>
                                                        
                                                        @endif

                                                    @endforeach


                                                    <label class="ui-checkbox">
                                                        <input name="perfis[]" type="checkbox" value="{{$perfil->id}}" {{ $checked }}><span>{{$perfil->name}}</span>
                                                    </label>

                                                    <!--<input type="checkbox" name="perfis[]" value="{{--$perfil->id--}}"> {{--$perfil->name--}}-->

                                                @endforeach

                                        @endif

                                    </div>                                    

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group" style="text-align: center;">

                                        <button type="button" id="enviar_foto" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Enviar Foto</button>

                                        <!--<a href="http://abs.dev/user/1/edit"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Tirar Foto</button></a>-->

                                        <input type="file" name="anexo" id="anexo" style="visibility: hidden;">
                                    </div>

                                    <div class="form-group" style="text-align: center;">
                                        <span>A imagem será carregada após a pessoa física ser salva</span>
                                    </div>

                                    <hr>

                                    <div class="form-group" style="text-align: center;">

                                        @if(isset($pessoa) && $pessoa->foto != "")
                                            <img src="{{$pessoa->foto}}" width="246px" height="210px"/>
                                        @else
                                            <img src="images/assets/no-photo.png">
                                        @endif
                                        
                                    </div>

                                     <div class="form-group" style="text-align: center;">

                                        <select name="sexo" id="sexo">

                                            @if($sexo == 'Masculino')

                                                <option value="Masculino" selected="selected">Masculino</option>

                                                <option value="Feminino">Feminino</option>                                          

                                            @elseif($sexo == 'Feminino')

                                                <option value="Masculino">Masculino</option>

                                                <option value="Feminino" selected="selected">Feminino</option>                                              

                                            @else 
                                                <option value="" selected="selected">Indefinido</option>

                                                <option value="Masculino">Masculino</option>

                                                <option value="Feminino">Feminino</option>                                             

                                            @endif

                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-5">
                                            Data do cadastro:<br/>
                                            {{ $pessoa->getDataCadastro() }}
                                        </div>
                                        <div class="col-md-5">
                                            Data da última modificação:<br/>
                                            {{ $pessoa->getDataCadastroAtualizado() }}
                                        </div>
                                        <!-- botao para apresentar o log de quem mexeu neste registro -->
                                        <!--<button type="button" id="ver" class="btn btn-warning">Ver</button>-->
                                    </div>
                                </div>  

                        </div>

                    </section>

                </div>

                <h1 id="step1_h1" tabindex="-1" class="title">2. Outras Informações</h1>

                <div id="step1" class="current" style="display: none;">

                    <section class="panel panel-default">

                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Dados cadastrais adicionais</strong></div>

                        <div class="panel-body">

                            <div class="row">

                                <div class="col-md-6">
                                <!-- -->

                                    <div class="row" id="endereco">

                                        @if($enderecos && $enderecos->count() > 0)
                                            <?php $i=1; ?>
                                            @foreach($enderecos as $endereco)
                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <input type="hidden" name="enderecos[{{ $endereco->id }}][id]" value="{{ $endereco->id }}">

                                                        <label for="" class="col-sm-2">Tipo Logradouro</label>

                                                        <div class="col-sm-10">

                                                            @if($tipos_logradouros)

                                                            <select name="enderecos[{{ $endereco->id }}][tipo_logradouro]" id="tipo_logradouro" class="form-control">

                                                                @foreach($tipos_logradouros as $tipo_logradouro)

                                                                    <option value="{{ $tipo_logradouro->id }}" @if($tipo_logradouro->id == $endereco->tipoLogradouro->id) selected @endif>{{ $tipo_logradouro->nome }}</option>

                                                                @endforeach

                                                            </select>
                                                                
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <label for="label-focus" class="col-sm-2">Endereço</label>

                                                        <div class="col-sm-10">

                                                            <input type="text" name="enderecos[{{ $endereco->id }}][endereco]" id="endereco" class="form-control" value="{{ $endereco->endereco }}">

                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <label for="label-focus" class="col-sm-2">Complemento</label>

                                                        <div class="col-sm-5">

                                                            <input type="text" name="enderecos[{{ $endereco->id }}][complemento]" id="complemento" class="form-control" value="{{ $endereco->complemento }}">

                                                        </div>

                                                        <label for="label-focus" class="col-sm-2" style="text-align: right;">N°</label>

                                                            <div class="col-sm-3">

                                                                <input type="text" name="enderecos[{{ $endereco->id }}][numero]" id="numero" class="form-control" value="{{ $endereco->numero }}">

                                                            </div>

                                                        </div>

                                                    <div class="form-group">

                                                        <label for="label-focus" class="col-sm-2">Bairro</label>

                                                        <div class="col-sm-5">

                                                            <select name="enderecos[{{ $endereco->id }}][bairro]" id="bairro" class="form-control">

                                                                @if(isset($bairros))
                                                                    @foreach($bairros as $bairro)
                                                                        <option value="{{ $bairro->id }}" @if($bairro->nome == $endereco->bairro->nome) selected="selected" @endif>{{ $bairro->nome }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>

                                                        </div>

                                                        <label for="label-focus" class="col-sm-2" style="text-align: right;">Estado</label>

                                                        <div class="col-sm-3">

                                                            <select name="enderecos[{{ $endereco->id }}][estado]" id="estado" class="form-control">

                                                            @if(isset($estados))
                                                                @foreach($estados as $estado)
                                                                    <option value="{{ $estado->id }}" @if($estado->id == $endereco->bairro->estado->id) selected="selected" @endif>{{ $estado->uf }}</option>
                                                                @endforeach
                                                            @endif

                                                            </select>

                                                        </div>

                                                    </div>

                                                    <div class="form-group">

                                                        <label for="label-focus" class="col-sm-2">Tipo</label>

                                                        <div class="col-sm-5">

                                                            <select name="enderecos[{{ $endereco->id }}][tipo]" id="tipo" class="form-control">

                                                            @if(isset($tipos_enderecos))
                                                                @foreach($tipos_enderecos as $tipo_endereco)
                                                                    <option value="{{ $tipo_endereco->id }}" @if( $tipo_endereco->id == $endereco->tipo->id) selected @endif>{{ $tipo_endereco->nome }}</option>
                                                                @endforeach
                                                            @endif

                                                            </select>

                                                        </div>

                                                        <label for="label-focus" class="col-sm-2" style="text-align: right;">CEP</label>

                                                        <div class="col-sm-3">

                                                            <input type="text" name="enderecos[{{ $endereco->id }}][cep]" class="form-control cep" value="{{ $endereco->cep }}">
                                                            <!--
                                                            <button type="button" id="bt_cep_res"><span class="glyphicon glyphicon-search"></span></button>
                                                            -->
                                                        </div>

                                                    </div>

                                                @if($i == 1)
                                                    <button type="button" class="btn btn-inverse btn-block addEndereco">Adicionar outro endereco</button>
                                                @endif
                                                <hr/>

                                                </div>
                                                <?php $i++; ?>
                                            @endforeach

                                         @else
                                            <script type="text/javascript">
                                                $(document).ready(function()
                                                {
                                                    $( ".addEndereco" ).trigger( "click" );
                                                });                                               
                                            </script>

                                             <button type="button" class="btn btn-inverse btn-block addEndereco">Adicionar outro endereco</button>
                                        @endif

                                    </div>
                                
                                <!-- -->
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Matrícula</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="matricula" id="matricula" class="form-control" value="{{ $matricula }}" disabled="disabled">
                                            <!--<input type="button" value="Gerar Matrícula">-->
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Nacionalidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" value="{{ $nacionalidade }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Naturalidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="naturalidade" id="naturalidade" class="form-control" value="{{ $naturalidade }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Estado Civil</label>

                                        <div class="col-sm-10">

                                            @if(isset($estados_civis))

                                            <select name="estado_civil" id="estado_civil" class="form-control">

                                                @foreach($estados_civis as $estado_civil)                                                

                                                    <option value="{{ $estado_civil->id }}" @if($estado_civil->id == $estadocivil->id) selected @endif>{{ $estado_civil->nome }}</option>

                                                @endforeach

                                            </select>

                                            @endif                                            

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Empresa</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="empresa" id="empresa" class="form-control" value="{{ $empresa }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Cargo</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="cargo" id="cargo" class="form-control" value="{{ $cargo }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Profissão</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="profissao" id="profissao" class="form-control" value="{{ $profissao }}">

                                        </div>

                                    </div>                                   

                                <!-- -->
                                </div>

                            </div>

                        </div>

                    </section>

                </div>

                <h1 id="step2_h1" tabindex="-1" class="title">3. Produtos</h1>

                <div id="step2" class="current" aria-hidden="true" style="display: none;">

                    <div class="page page-table">

                    <div class="panel panel-default">

                        <div class="panel-heading">

                        <strong>

                            <span class="glyphicon glyphicon-th"></span> 

                            Produtos adquiridos por este associado

                         </strong>

                        </div>

                        <table class="table table-bordered table-striped table-hover" id="tbProdutosDisponiveis">

                            <thead>

                                <tr>

                                    <th>Produtos</th>

                                    <th style="text-align: center;">Quantidade</th>

                                    <th style="text-align: center;">Preço</th>

                                </tr>

                            </thead>
                            <tbody>
                                @if(isset($compras) && $compras->count() > 0)
                                    @foreach($compras as $compra)
                                        @foreach($compra->orderproduct as $produto)
                                        <tr>

                                            <td class="produto-nome-{{ $produto->produto->id }}">{{ $produto->produto->nome }}</td>

                                            <td style="text-align: center;">
                                                @if($produto->produto->quantidade > 0)
                                                    {{ ($produto->produto->quantidade-1) }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td class="produto-preco-{{ $produto->produto->id }}" style="text-align: center;">{{ Formatter::getValorFormatado($produto->subtotal) }}</td>

                                            <td class="produto-valor-{{ $produto->produto->id }}" style="display:none;">{{ $produto->produto->valor }}</td>

                                        </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td colspan="2" style="text-align:right;">Total:</td>
                                        <td style="text-align: center;">
                                            {{--@if(isset($compras))--}}
                                                {{ Formatter::getValorFormatado($total) }}
                                            {{--@endif--}}
                                        </td>
                                    </tr>
                                @else 

                                    <tr>
                                        <td colspan="4">Associado não adquiriu produtos!</td>
                                    </tr>

                                @endif 
                            </tbody>
                         
                        </table>                        

                            <!--
                            <div style="text-align: right;margin: 10px;">
                                Mostrar só disponíveis
                                <label class="switch switch-info"><input type="checkbox" checked=""><i></i></label>
                            </div>
                            -->

                    </div>

                </div>

                </div>              

            </div>

            <div class="actions clearfix">
                <ul role="menu">
                    <li id="previous" class="disabled"><a id="nav_form" href="#previous"><i class="glyphicon glyphicon-chevron-left"></i></a></li>
                    <li id="next" style="display: block;"><a id="nav_form" href="#next"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
                    <li id="nav_finish" style="display: none;"><button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i></button></li>
                </ul>
            </div>

            </div> 

        </div>

    </section>

</form>

</div>

@stop