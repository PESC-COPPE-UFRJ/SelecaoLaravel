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
    $("#cpf").mask("999.999.999-99");

    formataTelefone();

    //$('#nascimento').mask('99/99/9999');

    $('#nascimento').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR'
    });

    $('.cep').mask('99.999-999');

    $('#enviar_foto').click(function(){
        $('#anexo').click();
    });

    $('#gerar_matricula').click(function(){
        var offset = parseInt({{ $matricula_offset }});
        $('#matricula').val(++offset);
        $('#matricula').prop('readonly','true');
        $(this).prop('disabled','true');
    });

    /* script das abas */
    var page = 0;

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

        $("li[id=next]").attr('class', '');

        $("li[id=nav_finish]").attr('style', 'display: none;');

    });

    $("a[id=steps-uid-0-t-3]").click(function(event){

        event.preventDefault();

        $("#step0, #step1, #step2").hide();

        $("#step3").show();

        $("#step0_tab, #step1_tab, #step2_tab").attr('class', 'done');

        $("#step3_tab").attr('class', 'current');

        page = 3;

        if (page == 3) {        
           var tbodyLen = $('#tbProdutosSelecionados tbody tr').length;

           if (tbodyLen == 1) {
             $('#nodata').show();
             $('#somatorio').hide();
           } else {
             $('#nodata').hide();
             $('#somatorio').show();
           }
        }

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


        if (page == 3) {        
           var tbodyLen = $('#tbProdutosSelecionados tbody tr').length;

           if (tbodyLen == 1) {
             $('#nodata').show();
             $('#somatorio').hide();
           } else {
             $('#nodata').hide();
             $('#somatorio').show();
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

    var tbProdutosDisponiveis  = $('#tbProdutosDisponiveis');
    var tbProdutosSelecionados = $('#tbProdutosSelecionados');    

    $('.id').click(function()
    {
        var debug = "";

        if($(this).is(':checked')) 
        {
            
            id           = $(this).val();

            parents      = $(this).parents().eq(1);

            elementNome  = parents.find('.produto-nome-' + id);

            elementPrice = parents.find('.produto-preco-'+ id);

            elementValor = parents.find('.produto-valor-'+ id);

            produto = elementNome.html();
            preco   = elementPrice.html();
            valor   = parseFloat(elementValor.html());
            
            newRow0  = '<tr id="' + id + '">';
            newRow0 += '<td>';
            newRow0 += '<input type="checkbox" name="produtos[]" value="' + id + '" checked="checked" disabled="disabled">';
            newRow0 += '<span style="margin-left: 20px;">' + produto + '</span>';
            newRow0 += '</td>';
            newRow0 += '<td style="text-align: center;" >';
            newRow0 += '<span id="preco-txt-produto-' + id + '">' + preco + '</span>';
            newRow0 += '<span style="display: none;" id="preco-val-produto-' + id + '">' + valor.toFixed(2) + '</span>';
            newRow0 += '</td>';           
            newRow0 += '<td style="text-align: center;">';
            newRow0 += '<input type="text" name="desconto" id="desconto-produto-' + id + '">';
            newRow0 += '<input type="hidden" name="produtos[' + id + '][desconto]" id="hidDesconto-'+ id +'" value="' + preco + '">';            
            newRow0 += '<button type="button" onclick="darDesconto(' + id + ')">OK</button>';            
            newRow0 += '</td>';
            newRow0 += '<td style="text-align: center;" >';
            newRow0 += '<span id="subtotal-produto-' + id + '">' + preco + '</span>';            
            newRow0 += '<input type="hidden" name="produtos[' + id + '][subtotal]" id="hidSubTotal-'+ id +'">';
            newRow0 += '</td>';
            newRow0 += '</tr>';

            $('#tbProdutosSelecionados > tbody > tr:last').after(newRow0);

            var price = parseFloat(valor);

            acumulador += price;

            strTotal = acumulador.toFixed(2);

            htmlTotal  = '<span id="valorTotal">R$ ' + strTotal.replace('.',',') + '</span>';
            htmlTotal += '<input type="hidden" name="inTotal" id="inTotal">';

            $('#tdTotal').html(htmlTotal);
            $('#inTotal').val(acumulador.toFixed(2));

            $('#hidDesconto-' + id).val(0);
            $('#hidSubTotal-' + id).val(price.toFixed(2));

        } 
        else
        {

            id           = $(this).val();

            parents      = $(this).parents().eq(1);

            elementNome  = parents.find('.produto-nome-' + id);

            elementPrice = parents.find('.produto-preco-'+ id);

            elementValor = parents.find('.produto-valor-'+ id);  

            var price = parseFloat(elementValor.html());

            acumulador -= price;

            $('#tdTotal').html('<span id="valorTotal">R$' + acumulador + '</span><input type="hidden" name="inTotal" id="inTotal">');

            $('#inTotal').val(acumulador);

            $('#tbProdutosSelecionados tbody tr#' + id).remove();

            //$('#tbProdutosSelecionados tbody tr').remove();

            //debug += 'Descheckado \n';
            //debug += 'Id ' + id + '\n';

            //alert(debug);
        }
        
    });

    newRowFoot  = '<tr id="nodata" style="display:none">';
    newRowFoot += '<td colspan="4" class="alert alert-info"><p> Nenhum registro encontrado. </p></td>';
    newRowFoot += '</tr>';                
    newRowFoot += '<tr id="somatorio" style="display:none">';
    newRowFoot += '<td colspan="3" style="background-color: #eee;border-left:none;border-bottom:none;">&nbsp;</td>';
    newRowFoot += '<td id="tdTotal" style="text-align: center;"><input type="hidden" name="inTotal" id="inTotal"></td>';
    newRowFoot += '</tr>';                           

    $('#tbProdutosSelecionados > tfoot > tr:last').after(newRowFoot);

    $('#bt_cep').click(function(){

        var cep = $('#cep').val();

        if (cep != "") {

            var request = $.ajax({ 
                                   type: 'POST',
                                   url: "{{ URL::to('pesquisarCEP') }}",
                                   data: {cep: cep},
                                   cache: false
                                  });
              request.done(function(data) {

                var objeto = JSON.parse(data);                

                $('#tipo_logradouro').append('<option value="' + objeto.tipo_logradouro + '" selected="selected">'+objeto.tipo_logradouro+'</option>');
                $('#endereco').val(objeto.logradouro);
                $('#bairro').append('<option value="' + objeto.bairro + '" selected="selected">' + objeto.bairro + '</option>');
                $('#estado').append('<option value="' + objeto.estado + '" selected="selected">' + objeto.estado + '</option>');

              });

              request.fail(function(jqXHR, textStatus) {
                //alert( "error " + textStatus);
                alert('O cep não foi encontrado!');
              });
        } else {
            alert('Por favor preencha um cep!');
        }

    });


    $('#bt_cep_com').click(function(){

        var cep = $('#cep_com').val();

        if (cep != "") {

            var request = $.ajax({ 
                                   type: 'POST',
                                   url: "{{ URL::to('pesquisarCEP') }}",
                                   data: {cep: cep},
                                   cache: false
                                  });
              request.done(function(data) {

                var objeto = JSON.parse(data);                

                $('#tipo_logradouro_com').append('<option value="' + objeto.tipo_logradouro + '" selected="selected">'+objeto.tipo_logradouro+'</option>');
                $('#endereco_com').val(objeto.logradouro);
                $('#bairro_com').append('<option value="' + objeto.bairro + '" selected="selected">' + objeto.bairro + '</option>');
                $('#estado_com').append('<option value="' + objeto.estado + '" selected="selected">' + objeto.estado + '</option>');

              });

              request.fail(function(jqXHR, textStatus) {
                //alert( "error " + textStatus);
                alert('O cep não foi encontrado!');
              });
        } else {
            alert('Por favor preencha um cep!');
        }

    });
    
    @if(Input::old('tels'))
        {? $count = count(Input::old('tels')) ?}

        var countTelefone = {{$count}}
    @else
        var countTelefone = 0;
    @endif
    //addTelefone
    $('.addTelefone').click(function(){

        //alert('Adicionando novo campo Telefone');

        //{{ Input::old('tel') }}

        divTelefone = $('#telefone');

        newDivTelefone  = '';

        newDivTelefone += '<div class="form-group" >';
        newDivTelefone += '<label for="label-focus" class="col-sm-2">Telefone</label>';
        newDivTelefone += '<div class="col-sm-5">';
        newDivTelefone += '<input type="text" name="tels[' + countTelefone + '][numero]" class="form-control tel" value="">';
        newDivTelefone += '</div>';
        newDivTelefone += '<label for="label-focus" class="col-sm-1" style="text-align: right;">Tipo</label>';
        newDivTelefone += '<div class="col-sm-4">';
        newDivTelefone += '<select name="tels[' + countTelefone + '][tipo]" class="form-control" required>';
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

        countTelefone++;
    });

    var countEmail = 0;

    //addEmail
    $('.addEmail').click(function(){
        //alert('Adicionando novo campo Email');

        divEmail = $('#email');

        //{{ Input::old('email') }}

        newDivEmail  = '';
        newDivEmail += '<div class="form-group">';
        newDivEmail += '<label for="label-focus" class="col-sm-2">Email Adicional</label>';
        newDivEmail += '<div class="col-sm-10">';
        newDivEmail += '<input type="email" name="emails_adicionais[]" id="email" class="form-control" value="">';
        newDivEmail += '</div>';
        newDivEmail += '</div>';

        divEmail.append(newDivEmail);

        countEmail++;
    });

    @if(Input::old('enderecos') && count(Input::old('enderecos')) > 0)
        var countEndereco = {{count(Input::old('enderecos'))}};
    @else
        var countEndereco = 0;
    @endif

    //addEndereco
    $('.addEndereco').click(function(){        

       //alert('Adicionando novo campo Endereco');

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
            newDivEndereco += '<select name="enderecos[' + countEndereco + '][tipo_logradouro]" class="form-control">';
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
        newDivEndereco += '<input type="text" name="enderecos[' + countEndereco + '][endereco]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Complemento</label>';
        newDivEndereco += '<div class="col-sm-5">';
        newDivEndereco += '<input type="text" name="enderecos[' + countEndereco + '][complemento]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">N°</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<input type="text" name="enderecos[' + countEndereco + '][numero]" class="form-control" value="">';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '<div class="form-group">';
        newDivEndereco += '<label for="label-focus" class="col-sm-2">Bairro</label>';
        newDivEndereco += '<div class="col-sm-5">';
        newDivEndereco += '<select name="enderecos[' + countEndereco + '][bairro]" class="form-control" required>';
        @if($bairros)
            @foreach($bairros as $bairro)
                newDivEndereco += '<option value="{{ $bairro->id }}">{{ $bairro->nome }}</option>';
            @endforeach
        @endif
        newDivEndereco += '</select>';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">Estado</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<select name="enderecos[' + countEndereco + '][estado]" class="form-control" required>';
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
        newDivEndereco += '<select name="enderecos[' + countEndereco + '][tipo]" class="form-control" required>';
        @if($tipos_enderecos)
            @foreach($tipos_enderecos as $tipo_endereco)
                newDivEndereco += '<option value="{{ $tipo_endereco->id }}">{{ $tipo_endereco->nome }}</option>';
            @endforeach
        @endif
        newDivEndereco += '</select>';
        newDivEndereco += '</div>';
        newDivEndereco += '<label for="label-focus" class="col-sm-2" style="text-align: right;">CEP</label>';
        newDivEndereco += '<div class="col-sm-3">';
        newDivEndereco += '<input type="text" name="enderecos[' + countEndereco + '][cep]" class="form-control cep" value="">';
        newDivEndereco += '<!--<button type="button" id="bt_cep"><span class="glyphicon glyphicon-search"></span></button>-->';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';
        newDivEndereco += '</div>';

        divEndereco.append(newDivEndereco);  

        countEndereco++;         

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


Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
    var n = this,
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSeparator = decSeparator == undefined ? "." : decSeparator,
        thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
        sign = n < 0 ? "-" : "",
        i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
};

var aux = 0;

function darDesconto(id) 
{
    var spanPreco     = $('#preco-val-produto-' + id);
    var inputDesconto = $('#desconto-produto-' + id);
    var hidDesconto   = $('#hidDesconto-'+id);
    var spanSubtotal  = $('#subtotal-produto-' + id);
    var hidSubtotal   = $('#hidSubTotal-' + id);
    var spanTotal     = $('#valorTotal');
    var hidTotal      = $('#inTotal');

    //
    var desconto = parseFloat(inputDesconto.val());
    var preco    = parseFloat(spanPreco.html());
    var total    = parseFloat(hidTotal.val());
    var subtotalDesconto = parseFloat('0');    

    if(inputDesconto.val().indexOf('%') != -1)
    {
        var porcentagem = 1-(desconto/100);
        var diferenca = 0;

        subtotalDesconto = preco * porcentagem;
        diferenca = preco - subtotalDesconto;
        spanSubtotal.html('R$ ' + subtotalDesconto.toFixed(2));
        hidSubtotal.val(subtotalDesconto.toFixed(2));

        if(hidDesconto.val() == 0)
        {
            total-= diferenca;
            aux = diferenca;
        }
        else
        {
            total -= diferenca;
            total += parseFloat(hidDesconto.val());
        }

        hidDesconto.val(inputDesconto.val());

        spanTotal.html('R$ ' + total.toFixed(2));
        hidTotal.val(total);
    }
    else if (desconto > 0 && desconto != "") 
    {
        if(desconto <= preco)
        {
            subtotalDesconto = preco-desconto;
            spanSubtotal.html('R$ ' + subtotalDesconto.toFixed(2));
            hidSubtotal.val(subtotalDesconto.toFixed(2));

            if(hidDesconto.val() == 0)
            {
                total-= desconto;
                aux = desconto;
            }
            else
            {
                total -= desconto;
                total += parseFloat(hidDesconto.val());
            }

            hidDesconto.val(desconto);

            spanTotal.html('R$ ' + total.toFixed(2));
            hidTotal.val(total);
        }
    }
    else
    {

        if(hidDesconto.val().indexOf('%') != -1)
        {
            var porcentagem = 1-(parseFloat(hidDesconto.val())/100);
            var diferenca = 0;

            subtotalDesconto = preco * porcentagem;
            diferenca = preco - subtotalDesconto;
            total += diferenca;
            hidDesconto.val('0');
        }
        else
        {
            total += parseFloat(hidDesconto.val());
            hidDesconto.val('0');
        }        

        spanSubtotal.html('R$ ' + preco.toFixed(2));
        hidSubtotal.val(preco.toFixed(2));
        spanTotal.html('R$ ' + total.toFixed(2));
        hidTotal.val(total.toFixed(2));
    }
}

function marcarProduto(id) 
{

    elementNome  = $('.produto-nome-' + id);

    elementPrice = $('.produto-preco-'+ id);

    elementValor = $('.produto-valor-'+ id);

    newRow0  = '<tr id="' + id + '">';
    newRow0 += '<td>';
    newRow0 += '<input type="checkbox" name="produtos[]" value="' + id + '" checked="checked" disabled="disabled">';
    newRow0 += '<span style="margin-left: 20px;">'
    newRow0 += elementNome.html();
    newRow0 += '</span>';
    newRow0 += '</td>';
    newRow0 += '<td style="text-align: center;">';
    newRow0 +=  elementPrice.html();
    newRow0 += '</td>';
    newRow0 += '<td style="text-align: center;">';
    newRow0 += '<input type="text" name="desconto" id="desconto-produto-' + id + '" value="">';
    newRow0 += '<button type="button" onclick="darDesconto(' + id + ')">OK</button>';
    newRow0 += '</td>';
    newRow0 += '<td style="text-align: center;" id="preco-produto-' + id + '">';
    newRow0 += elementPrice.html();
    newRow0 += '<input type="hidden" name="produtos[' + id + '][desconto]" id="hidDesconto-'+ id +'">';
    newRow0 += '<input type="hidden" name="produtos[' + id + '][subtotal]" id="hidSubTotal-'+ id +'">';
    newRow0 += '</td>';
    newRow0 += '<td style="display: none;" id="valor-produto-' + id + '">' 
    newRow0 += elementValor.html();
    newRow0 += '</td>';
    newRow0 += '</tr>';

    $('#tbProdutosSelecionados > tbody > tr:last').after(newRow0);

    var price = parseFloat(elementValor.html());

    acumulador += price;

    strTotal = acumulador.toFixed(2);

    $('#tdTotal').html('R$ ' + strTotal.replace('.',',') + '<input type="hidden" name="inTotal" id="inTotal">');
    $('#inTotal').val(acumulador.toFixed(2));
    $('#hidDesconto-' + id).val(0);
    $('#hidSubTotal-' + id).val(price);


    newRowFoot  = '<tr id="nodata" style="display:none">';
    newRowFoot += '<td colspan="4" class="alert alert-info"><p> Nenhum registro encontrado. </p></td>';
    newRowFoot += '</tr>';                
    newRowFoot += '<tr id="somatorio" style="display:none">';
    newRowFoot += '<td colspan="3" style="background-color: #eee;border-left:none;border-bottom:none;">&nbsp;</td>';
    newRowFoot += '<td id="tdTotal" style="text-align: center;"><input type="hidden" name="inTotal" id="inTotal"></td>';
    newRowFoot += '</tr>';                           

    $('#tbProdutosSelecionados > tfoot > tr:last').after(newRowFoot);

    //debug += 'Checkado \n';
    //debug += 'Id ' + id + '\n';

    //alert(debug);
}
    

</script>

@stop
@section('content')

<!-- if there are creation errors, they will show here -->
{{-- HTML::ul($errors->all()) --}}

@include('elements.alerts')

<div class="page ng-scope">
<form class="form-horizontal ng-pristine ng-valid" role="form" method="POST" action="{{ URL::to('person') }}" enctype="multipart/form-data">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Nova Pessoa Física</strong></div>

        <div class="panel-body">        

            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix">

                <ul>

                    <li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0" href="#steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Cadastro Inicial</a></li>

                    <li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1" href="#steps-uid-0-t-1"><span class="number">2.</span> Outras Informações</a></li>

                    <li id="step2_tab" role="tab" class="done"><a id="steps-uid-0-t-2" href="#steps-uid-0-t-2"><span class="number">3.</span> Produtos</a></li>

                    <li id="step3_tab" role="tab" class="last done"><a id="steps-uid-0-t-3" href="#steps-uid-0-t-3"><span class="number">4.</span> Pagamento e carteira</a></li>

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

                                        <label for="" class="col-sm-2">Nome <span class="color-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nome" id="nome" class="form-control" value="{{ Input::old('nome') }}">                                            
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Sobrenome <span class="color-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="sobrenome" id="sobrenome" class="form-control" value="{{ Input::old('sobrenome') }}">

                                        </div>

                                    </div>

                                     <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Apelido</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="apelido" id="apelido" class="form-control" value="{{ Input::old('apelido') }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">CPF <span class="color-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <input type="text" name="cpf" id="cpf" class="form-control" value="{{ Input::old('cpf') }}">

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Identidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="identidade" id="identidade" class="form-control" value="{{ Input::old('identidade') }}">

                                        </div>

                                    </div>

                                    <div id="telefone">
                                       
                                        @if(Input::old('tels') && count(Input::old('tels')) > 0)

                                            @foreach(Input::old('tels') as $key => $telefone)
                                                @if(!empty($telefone['numero']))
                                                    <div class="form-group">
                                                        <input type="hidden" name="tels[{{ $key }}][id]" value="{{ $key }}">

                                                        <label for="label-focus" class="col-sm-2">Telefone</label>

                                                        <div class="col-sm-5">

                                                            <input type="text" name="tels[{{ $key }}][numero]" class="form-control tel" value="{{ $telefone['numero'] }}">                                            
                                                            
                                                        </div>

                                                        <label for="label-focus" class="col-sm-1" style="text-align: right;">Tipo</label>

                                                        <div class="col-sm-4">

                                                            <select name="tels[{{ $key }}][tipo]" class="form-control" required>
                                                                <option>Selecione</option>

                                                                <!-- recuperar do banco a lista de tipos de telefone -->

                                                                @if(isset($tipos_telefones))
                                                                    @foreach($tipos_telefones as $tipo_telefone)
                                                                        <option value="{{ $telefone['tipo'] }}" @if($tipo_telefone->id == $telefone['tipo']) selected @endif>{{ $tipo_telefone->nome }}</option>
                                                                    @endforeach
                                                                @endif
                                                                                                                    
                                                            </select>

                                                        </div>                                                    
                                                    </div>
                                                @endif
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
                                                        
                                        <div class="col-sm-10">
                                            <button type="button" class="btn btn-inverse btn-block addTelefone">Adicionar outro telefone</button>                                      
                                        </div>

                                    </div>

                                    <div id="email">

                                        <div class="form-group">
                                            
                                            <label for="label-focus" class="col-sm-2">Email Principal <span class="color-danger">*</span></label>

                                            <div class="col-sm-10">

                                                <input type="email" name="email" id="email" class="form-control" value="{{ Input::old('email') }}">
                                                
                                            </div>

                                        </div>

                                        @if(Input::old('emails_adicionais'))
                                            @foreach(Input::old('emails_adicionais') as $email_adicional)
                                                @if(!empty($email_adicional))
                                                    <div class="form-group">
                                                        <label for="label-focus" class="col-sm-2">Email Adicional</label>

                                                        <div class="col-sm-10">

                                                            <input type="email" name="emails_adicionais[]" id="email" class="form-control" value="{{$email_adicional}}">

                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="label-focus" class="col-sm-2">&nbsp;</label>

                                        <div class="col-sm-10">
                                            <button type="button" class="btn btn-inverse btn-block addEmail">Adicionar outro email</button>
                                        </div>
                                    </div>

                                    <div class="form-group" data-ng-controller="DatepickerDemoCtrl">

                                        <label for="label-focus" class="col-sm-2">Nascimento</label>

                                        <div class="col-sm-3">
                                            <input type="text" name="nascimento" id="nascimento" class="form-control" value="{{ Input::old('nascimento') }}">
                                        </div>

                                    </div>

                                    <hr/>

                                    <div class="form-group" style="text-align: center;">
                                        <span class="color-danger">*</span>
                                        @if($perfis->count() > 0)                    

                                                @foreach ($perfis as $perfil)

                                                    {? $checked = '' ?}

                                                    @if(Input::old('perfis'))
                                                        @foreach(Input::old('perfis') as $perfil_old)

                                                            @if($perfil_old == $perfil->id)
                                                                {? $checked = 'checked' ?}
                                                            @endif

                                                        @endforeach
                                                    @endif

                                                    <label class="ui-checkbox">
                                                        <input name="perfis[]" type="checkbox" value="{{$perfil->id}}" {{$checked}}><span>{{$perfil->name}}</span>
                                                    </label>

                                                    <!--<input type="checkbox" name="perfis[]" value="{{--$perfil->id --}}"> {{--$perfil->name--}}-->

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

                                    <hr>

                                    <div class="form-group" style="text-align: center;">
                                        <span>A imagem será carregada após a pessoa física ser salva</span>
                                    </div>

                                    <div class="form-group" style="text-align: center;">
                                        <img src="images/assets/no-photo.png">
                                    </div>

                                     <div class="form-group" style="text-align: center;">
                                        <span class="color-danger">*</span>
                                        <select name="sexo" id="sexo" required>

                                            <option value="Masculino">Masculino</option>

                                            <option value="Feminino">Feminino</option>

                                        </select>

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

                                    <!-- *** -->

                                    <div class="row" id="endereco">

                                    {? $flag = false ?}

                                    @if(Input::old('enderecos'))

                                        {? $i = 0; ?}    

                                        @foreach(Input::old('enderecos') as $endereco)

                                        @if(!empty($endereco['endereco']))

                                        {? $flag=true; ?}

                                        <div class="col-md-12">                                    

                                            <div class="form-group">

                                                <label for="tipo_logradouro" class="col-sm-2">Tipo Logradouro</label>

                                                <div class="col-sm-10">

                                                    @if($tipos_logradouros)

                                                    <select name="enderecos[{{$i}}][tipo_logradouro]" id="tipo_logradouro-0" class="form-control">

                                                        @foreach($tipos_logradouros as $tipo_logradouro)
                                                            {? $selected = ''; ?}
                                                            @if($endereco['tipo_logradouro'] == $tipo_logradouro->id)
                                                                {? $selected = 'selected'; ?}
                                                            @endif
                                                            <option value="{{ $tipo_logradouro->id }}" {{$selected}}>{{ $tipo_logradouro->nome }}</option>

                                                        @endforeach

                                                    </select>
                                                        
                                                    @endif

                                                </div>

                                            </div>


                                            <div class="form-group">

                                                <label for="label-focus" class="col-sm-2">Endereço</label>

                                                <div class="col-sm-10">

                                                    <input type="text" name="enderecos[{{$i}}][endereco]" id="endereco-0" class="form-control" value="{{ $endereco['endereco'] }}">

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label for="label-focus" class="col-sm-2">Complemento</label>

                                                <div class="col-sm-5">

                                                    <input type="text" name="enderecos[{{$i}}][complemento]" id="complemento-0" class="form-control" value="{{ $endereco['complemento'] }}">

                                                </div>



                                                <label for="label-focus" class="col-sm-2" style="text-align: right;">N°</label>

                                                <div class="col-sm-3">

                                                    <input type="text" name="enderecos[{{$i}}][numero]" id="numero-0" class="form-control" value="{{ $endereco['numero'] }}">

                                                </div>

                                            </div>



                                            <div class="form-group">

                                                <label for="label-focus" class="col-sm-2">Bairro</label>

                                                <div class="col-sm-5">

                                                    <select name="enderecos[{{$i}}][bairro]" id="bairro-0" class="form-control" required>

                                                        @if($bairros)
                                                            @foreach($bairros as $bairro)
                                                                <option value="{{ $bairro->id }}">{{ $bairro->nome }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>

                                                </div>



                                                <label for="label-focus" class="col-sm-2" style="text-align: right;">Estado</label>

                                                <div class="col-sm-3">

                                                    <select name="enderecos[{{$i}}][estado]" id="estado-0" class="form-control" required>

                                                        @if($estados)
                                                            @foreach($estados as $estado)
                                                                <option value="{{ $estado->id }}">{{ $estado->uf }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="label-focus" class="col-sm-2">Tipo</label>

                                                <div class="col-sm-5">

                                                    <select name="enderecos[{{$i}}][tipo]" id="tipo-0" class="form-control" required>

                                                        @if($tipos_enderecos)
                                                            @foreach($tipos_enderecos as $tipo_endereco)
                                                                {? $selected = ''; ?}
                                                                @if($endereco['tipo'] == $tipo_endereco->id)
                                                                    {? $selected = 'selected'; ?}
                                                                @endif
                                                                <option value="{{ $tipo_endereco->id }}" {{$selected}}>{{ $tipo_endereco->nome }}</option>
                                                                
                                                            @endforeach
                                                        @endif

                                                    </select>

                                                </div>

                                                <label for="label-focus" class="col-sm-2" style="text-align: right;">CEP</label>

                                                <div class="col-sm-3">

                                                    <input type="text" name="enderecos[{{$i}}][cep]" id="cep-0" class="form-control cep" value="{{ $endereco['cep'] }}">
                                                    <!--
                                                    <button type="button" id="bt_cep"><span class="glyphicon glyphicon-search"></span></button>
                                                    -->
                                                </div>

                                            </div>

                                            <hr/>
                                        </div>

                                        {? $i++; ?}
                                        @endif
                                        @endforeach

                                        @if(!$flag)

                                            <script type="text/javascript">
                                                $(document).ready(function()
                                                {
                                                    $( ".addEndereco" ).trigger( "click" );
                                                });                                               
                                            </script>

                                        @endif

                                    @else

                                        <script type="text/javascript">
                                            $(document).ready(function()
                                            {
                                                $( ".addEndereco" ).trigger( "click" );
                                            });                                               
                                        </script>                                        
                                    @endif

                                    </div>

                                    <div class="form-group">
                                        <label for="label-focus" class="col-sm-2">&nbsp;</label>
                                        <div class="col-sm-10">
                                            <button type="button" class="btn btn-inverse btn-block addEndereco">Adicionar outro endereço</button>
                                        </div>
                                    </div>

                                </div>

                                <!-- *** -->

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Matrícula <span class="color-danger">*</span></label>

                                        <div class="col-sm-10">

                                            <div class="input-group">

                                                <input type="text" name="matricula" id="matricula" class="form-control" value="{{ Input::old('matricula') }}">
                                                <span class="input-group-btn">
                                                    <input class="btn btn-default" type="button" id="gerar_matricula" value="Gerar Matrícula">
                                                </span>
                                            
                                            </div>
                                            
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Nacionalidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="nacionalidade" id="nacionalidade" class="form-control" value="{{ Input::old('nacionalidade') }}">

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Naturalidade</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="naturalidade" id="naturalidade" class="form-control" value="{{ Input::old('naturalidade') }}">

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Estado Civil</label>

                                        <div class="col-sm-10">

                                            <!--<input type="text" name="estado_civil" id="estado_civil" class="form-control" value="{{ Input::old('estado_civil') }}">-->

                                            @if($estados_civis)

                                            <select name="estado_civil" id="estado_civil" class="form-control">

                                                @foreach($estados_civis as $estado_civil)                                                

                                                    <option value="{{ $estado_civil->id }}">{{ $estado_civil->nome }}</option>

                                                @endforeach

                                            </select>

                                            @endif

                                        </div>

                                    </div>

                                   <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Empresa</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="empresa" id="empresa" class="form-control" value="{{ Input::old('empresa') }}">

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Cargo</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="cargo" id="cargo" class="form-control" value="{{ Input::old('cargo') }}">

                                        </div>

                                    </div>



                                    <div class="form-group">

                                        <label for="label-focus" class="col-sm-2">Profissão</label>

                                        <div class="col-sm-10">

                                            <input type="text" name="profissao" id="profissao" class="form-control" value="{{ Input::old('profissao') }}">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <hr>                   

                        </div>

                    </section>

                </div>

                <h1 id="step2_h1" tabindex="-1" class="title">3. Produtos</h1>

                <div id="step2" class="current" aria-hidden="true" style="display: none;">



                    <div class="page page-table">



                    <div class="panel panel-default">



                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> 



                            Produtos disponíveis para este associado



                         </strong>



                        </div>         

                            <div style="text-align: right;margin: 10px; display:none;">
                                Mostrar só disponíveis
                                <label class="switch switch-info"><input type="checkbox" checked=""><i></i></label>
                            </div>

                            @if($tipos_produtos && $tipos_produtos->count() > 0)

                                <table class="table table-bordered table-striped table-hover" id="tbProdutosDisponiveis">

                                    <thead>

                                        <tr>

                                            <th>Produtos<span class="color-danger">*</span></th>

                                            <th style="text-align: center;">Quantidade</th>

                                            <th style="text-align: center;">Preço</th>

                                            <th>&nbsp;</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    @foreach ($tipos_produtos as $tipo_produto)

                                        @if($tipo_produto->ativo == 1)

                                            <thead>
                                            <tr>

                                                <td colspan="4" class="info">
                                                    <a href="javascript:exibirProdutos('{{ $tipo_produto->id }}');" class="btn-icon-round btn-icon-round-sm bg-primary" id="produto-exibir"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                    {{ $tipo_produto->nome }}
                                                </td>

                                            </tr>
                                            </thead>
                                            <tbody id="linha-produtos-{{ $tipo_produto->id }}">

                                            @foreach($tipo_produto->products as $product)

                                                @if($product->ativo == 1)

                                                    @if(Input::old('produtos'))
                                                        {? $checked = ''; ?}
                                                        @foreach(Input::old('produtos') as $produto)
                                                            @if($produto['id'] == $product->id)
                                                                {? $checked = 'checked'; ?}
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    <tr>

                                                        <td class="produto-nome-{{ $product->id }}">{{ $product->nome }}</td>

                                                        <td style="text-align: center;">                                                            
                                                            @if($product->quantidade > 0)
                                                                {{ $product->quantidade }}
                                                            @else
                                                                -
                                                            @endif

                                                            @if($checked)
                                                                <script type="text/javascript">
                                                                    $(document).ready(function(){
                                                                        marcarProduto('{{$product->id}}');
                                                                    });
                                                                </script>
                                                            @endif
                                                        </td>

                                                        <td class="produto-preco-{{ $product->id }}" style="text-align: center;">{{ $product->getValorFormatted() }}</td>

                                                        <td class="produto-valor-{{ $product->id }}" style="display:none;">{{ $product->valor }}</td>

                                                        <td style="text-align: center;"><input type="checkbox" class="id" name="produtos[{{ $product->id }}][id]" value="{{ $product->id }}" {{ $checked }}></td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                        @endif

                                        </tbody>                                        

                                    @endforeach

                                    </tbody>
                                 
                                </table>

                            @else

                            <div class="alert alert-info">

                                <p> Nenhum registro encontrado. </p>

                            </div>

                            @endif

                    </div>

                </div>

                </div>

                <h1 id="step3_h1" tabindex="-1" class="title">4. Pagamento e carteira</h1>

                <div id="step3" class="current" aria-hidden="true" style="display: none;">

                    <div class="page page-table">

                    <div class="panel panel-default">

                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> 

                            Produtos disponíveis para este associado

                         </strong>

                        </div>                       

                        <table class="table table-bordered table-striped table-hover" id="tbProdutosSelecionados">
                            <thead>

                                <tr>

                                    <th>Produtos selecionados</th>

                                    <th style="text-align: center;">Preço</th>                                            

                                    <th style="text-align: center;">Desconto</th>

                                    <th style="text-align: center;">Valor Total</th>

                                </tr>

                            </thead>
                            <tfoot>
                                <tr></tr>
                            </tfoot>
                            <tbody>
                                <tr></tr>
                            </tbody>                         
                        </table>

                        <!--
                        <div class="alert alert-info">

                            <p> Nenhum registro encontrado. </p>

                        </div>
                        -->

                            <hr>

                            Formas de pagamento: 
                            <select name="forma_pagamento">
                                <option>Selecione</option>
                                @if(isset($formas_pagamento) && $formas_pagamento->count() > 0)
                                    @foreach($formas_pagamento as $forma_pagamento)
                                        @if($forma_pagamento->ativo == 1)
                                            <option value="{{ $forma_pagamento->id }}">{{ $forma_pagamento->nome }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>

                            <hr>

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