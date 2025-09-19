@extends('templates.master')

@section('css')

    <link rel="stylesheet" href="styles/datepicker.css">

    <link rel="stylesheet" href="styles/datepicker3.css">

@stop

@section('scripts')
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>

<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">
    function readURL()
    {
        //  rehide the image and remove its current "src",
        //  this way if the new image doesn't load,
        //  then the image element is "gone" for now
        if (this.files && this.files[0])
        {
            var reader = new FileReader();
            $(reader).load(function(e) {
                $('#documento_formacao_img_src')
                    //  first we set the attribute of "src" thus changing the image link
                    .attr('src', e.target.result)   //  this will now call the load event on the image
            });
            reader.readAsDataURL(this.files[0]);
        }
    }


    $(document).ready(function()
    {
        $("#documento_formacao_img").change(readURL);

    });

</script>


<script type="text/javascript">

    var html = '';

    @if(isset($formacoes) && $formacoes->count() > 0)
        var i = {{$formacoes->count()}};
    @else
        var i = 0;
    @endif

    console.log(i);

    function limpar()
    {
        $('#fid').val('');
        $('#cod').val('');
        $('#formacao').val('Graduação');
        $('#concluido').val('Sim');
        $('#instituicao').val('');
        $('#estado').val('RJ');
        $('#pais').val('Brasil');
        $('#curso').val('');
        $('#cr').val('');
        $('#valor').val('');
        $('#media_maxima').val('');
        $('#ano_inicio').val('{{ Carbon::now()->year }}');
        $('#ano_fim').val('{{ Carbon::now()->year }}');
        $('#documento_formacao_img').val('');
        $('#imagens').html('');

        i= $("#formacoes > div").length;
    }

    // função chamada pelo botão Salvar Formação
    function adicionar()
    {
        @if($userId && Session::has('perfil') && Session::get('perfil') != 1 && Session::get('perfil') != 2)
            alert('Você não tem permissão para fazer esta ação');
            return false;
        @endif
        var contador     = parseInt(i);
        var html = '';
        var fid          = $('#fid').val();
        var cod          = $('#cod').val();
        var formacao     = $('#formacao').val();
        var concluido    = $('#concluido').val();
        var instituicao  = $('#instituicao').val();
        var estado       = $('#estado').val();
        var pais         = $('#pais').val();
        var curso        = $('#curso').val();
        var cr           = $('#cr').val();
        var valor        = $('#valor').val();
        var media_maxima = $('#media_maxima').val();
        var ano_inicio   = $('#ano_inicio').val();
        var ano_fim      = $('#ano_fim').val();

        var before_f =      function func_beforeSubmit()
                            {
                                $("#ajaxLoading").show();
                            }

        var success_f =     function func_success(data)
                            {
                                console.log(data);
                                if(data)
                                {
                                    if(data.id != '')
                                    {
                                        console.log(data);
                                        fid = data.id;
                                    }

                                    if(data.documento_formacao_img != '')
                                    {
                                        var documento_formacao_img = data.documento_formacao_img;
                                    }
                                }

                                if(cod != '')
                                {
                                    i = cod;
                                }

                                html+= '<div id="formacao-' + i + '">';
                                html+= '<div class="row">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][id]"           id="formacao-' + i + '-id"           value="' + fid         + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][formacao]"     id="formacao-' + i + '-formacao"     value="' + formacao    + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][concluido]"    id="formacao-' + i + '-concluido"    value="' + concluido   + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][instituicao]"  id="formacao-' + i + '-instituicao"  value="' + instituicao + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][estado]"       id="formacao-' + i + '-estado"       value="' + estado      + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][pais]"         id="formacao-' + i + '-pais"         value="' + pais        + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][curso]"        id="formacao-' + i + '-curso"        value="' + curso       + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][cr]"           id="formacao-' + i + '-cr"           value="' + cr          + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][valor]"        id="formacao-' + i + '-valor"        value="' + valor       + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][media_maxima]" id="formacao-' + i + '-media_maxima" value="' + media_maxima+ '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][ano_inicio]"   id="formacao-' + i + '-ano_inicio"   value="' + ano_inicio  + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][ano_fim]"      id="formacao-' + i + '-ano_fim"      value="' + ano_fim + '">';
                                html+= '<input type="hidden" name="formacoes[' + i + '][documento_formacao_img]"      id="formacao-' + i + '-documento_formacao_img"      value="' + documento_formacao_img + '">';
                               

                                // $.each(data.titulos),function(){
                                //   // var titulo = $('#formacao-' + (i-1) + '-titulo'+i_img).val();
                                //   // html += '<input type="hidden" name="formacoes[' + i + '][titulo['+i_img+']]"  id="formacao-' + i + '-titulo'+i_img+'"      value="' + titulo + '">';
                                // });
                                
                                var i_img = 0;
                                $.each(data.imagens, function(ii, obj) {
                                  //use obj.id and obj.name here, for example:                                  
                                    
                                  // var titulo = $('#formacao-' + (i-1) + '-titulo'+i_img).val();
                                  html += '<input type="hidden" name="formacoes[' + i + '][id['+i_img+']]"  id="formacao-' + i + '-id'+i_img+'"      value="'+obj.id+'">';
                                  html += '<input type="hidden" name="formacoes[' + i + '][titulo['+i_img+']]"  id="formacao-' + i + '-titulo'+i_img+'"      value="' + obj.titulo + '">';
                                  html += '<input type="hidden" name="formacoes[' + i + '][imagem['+i_img+']]"  class="imgdo'+ i +'"    id="formacao-' + i + '-imagem'+i_img+'"      value="'+obj.caminho+''+obj.nome+'">';
                                  i_img++;
                                });

                                html += '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
                                html += '<span id="span-contador-'+i+'">'+(contador+1)+'</span>' + '-';
                                html += '</div>';
                                html += '<div class="col-sm-7">';
                                html += formacao + '<br/>';
                                html += curso + ' ' + instituicao;
                                html += '</div>';
                                html += '<div class="col-sm-3">';
                                html += '<a href="javascript:editar(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
                                html += '<a href="javascript:apagar(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
                                html += '</div>';
                                html += '</div>';
                                html += '<hr style="background-color: #EAEAEA;height: 2px;"/>';
                                html += '</div>';

                                if(cod != '')
                                {
                                    i = cod;
                                }

                                if(cod!='')
                                {
                                    $('#formacao-'+cod).html(html);
                                }
                                else
                                {
                                    $('#formacoes').append(html);
                                }

                                limpar();
                                //console.log('adicionar -' + i);
                            }

        var complete_f =    function func_complete(xhr)
                            {                                
                                if(fid!='' && fid != null) {
                                    var request  = $.get('candidato/meusdados/imagens-formacao',{formacao_id: fid},function(data)
                                    {
                                        
                                        console.log(data);
                                         $.each(data,function(keyId,valueId){                                             
                                            console.log((i-1)+ ' : ' + keyId + ' : ' + valueId);
                                            $('#formacao-' + (i-1) + '-id'+keyId).val(valueId);
                                         });
                                    },'json');
                                }
                                $("#ajaxLoading").hide();
                                location.reload();
                            }

        var options = {
            clearForm       :   true,        // clear all form fields after successful submit
            resetForm       :   true,        // reset the form after successful submit
            url             :   "candidato/meusdados/formacao-single",
            type            :   'post',
            dataType        :   'json',
            beforeSubmit    :   before_f,
            success         :   success_f,
            complete        :   complete_f
        };

        $("#form_formacao").ajaxSubmit(options);
    }

    // função chamada quando a formação é selecionada para edição
    function editar(id)
    {
        var file = "";
        i=id;
        $("#imagens").html('');

        $('#cod').val(id);
        $('#fid').val($('#formacao-' + id + '-id').val());
        $('#formacao-' + id + '-id').val($('#formacao-' + id + '-id').val());
        $('#formacao').val($('#formacao-'    + id + '-formacao').val());
        $('#concluido').val($('#formacao-'   + id + '-concluido').val());
        $('#instituicao').val($('#formacao-' + id + '-instituicao').val());
        $('#estado').val($('#formacao-'      + id + '-estado').val());
        $('#pais').val($('#formacao-'        + id + '-pais').val());
        $('#curso').val($('#formacao-'       + id + '-curso').val());
        $('#cr').val($('#formacao-'          + id + '-cr').val());
        $('#valor').val($('#formacao-'          + id + '-valor').val());
        $('#media_maxima').val($('#formacao-'          + id + '-media_maxima').val());
        $('#ano_inicio').val($('#formacao-'  + id + '-ano_inicio').val());
        $('#ano_fim').val($('#formacao-' + id + '-ano_fim').val());
        $('#documento_formacao_img_link').attr('src', $('#formacao-' + id + '-documento_formacao_img').val());
        $('#documento_formacao_img_src').attr('src', $('#formacao-' + id + '-documento_formacao_img').val());

        var i_img = 0;

        var imagens = $('.imgdo'+id).each(function(key, value)
        {
            //console.log(key);
            //<label class="">Documento '+ i_img +'</label>
            //<label class="">Título</label><br/><input type="text" name="titulo[]"><br/>
            
            var titulo = $('#formacao-' + id + '-titulo'+key).val();    
            
            file = $(this).val();
            if( file.toLowerCase().indexOf(".pdf") >= 0){
                //documento

                
                
                $("#imagens").append('<div class="row"><div class="col-md-6"><span><label class="">Título</label>\
                                     <br/><input type="text" name="titulo[]" value="' + titulo + '">\
                                     <br/><input type="hidden" class="imginput" name="imgid[]" value="'+ $('#formacao-'+id+'-id'+i_img).val() +'" />\
                                     <input class="form-control imginput" type="file" id="'+i_img+'" name="imagens[]" accept="image/jpeg,image/jpg,image/png,application/pdf"></span></div>\
                                     <div class="col-md-2"><span>\
                                     <button type="button" class="btn btn-danger delimg" inputid = "'+i_img+'" imgid="'+$(this).attr('imgid')+'"> Apagar </button> </div>\
                                     <div class="col-md-4"><a href="'+$(this).val()+'" target="_blank">\
                                     <iframe class="imgthumb" count="'+i_img+'" id="img'+i_img+'" src="'+$(this).val()+'" alt="" style="width: 100%; height: 100%; cursor: pointer;" scrolling="no" frameborder="0"></iframe>\
                                     <small>Visualizar arquivo</small></a></div></div>');
            } else {
                //imagem
                $("#imagens").append('<div class="row"><div class="col-md-6"><span><label class="">Título</label>\
                                        <br/><input type="text" name="titulo[]" value="' + titulo + '">\
                                        <br/><input type="hidden" class="imginput" name="imgid[]" value="'+ $('#formacao-'+id+'-id'+i_img).val() +'" />\
                                        <input class="form-control imginput" type="file" id="'+i_img+'" name="imagens[]" accept="image/jpeg,image/jpg,image/png,application/pdf"></span></div>\
                                        <div class="col-md-2"><span>\
                                        <button type="button" class="btn btn-danger delimg" inputid = "'+i_img+'" imgid="'+$(this).attr('imgid')+'"> Apagar </button> </div>\
                                        <div class="col-md-4"><a href="'+$(this).val()+'" target="_blank">\
                                        <img class="imgthumb" count="'+i_img+'" id="img'+i_img+'" src="'+$(this).val()+'" alt="" style="width: 100%; height: 100%; cursor: pointer;"></a></div></div>');
            }

            //console.log($(this).val());
            i_img++;
        });


        //console.log('editar - ' + i);
    }

    function apagar(id)
    {
        @if($userId && Session::has('perfil') && Session::get('perfil') != 1 && Session::get('perfil') != 2)
            alert('Você não tem permissão para fazer esta ação');
            return false;
        @endif
        var confirmDelete = confirm("Deseja deletar esta formação?");
        if(confirmDelete){
            i--;
            var cod = $('#formacao-' + id + '-id').val();
            if(cod != '')
            {
                $.post(
                    "candidato/meusdados/apagar-formacao",
                    {idFormacao: cod},
                    function(response) {
                        console.log('Formação: ' + cod + ' apagada com sucesso!');
                    }
                );
            }
            var cont = parseInt($("#span-contador-"+id).html());
            while(cont>=0){
                if( typeof  $("#span-contador-"+cont).html() === "undefined"){
                    break;
                }
                $("#span-contador-"+cont).html(cont++);
            }
            $('#formacao-'+id).remove();
            limpar();

        }
    }

    $(document).ready(function() {


        // bind 'myForm' and provide a simple callback function
        $('#form_formacao').ajaxForm();


        $('#salvar').click(function(){
            @if($userId && Session::has('perfil') && Session::get('perfil') != 1 && Session::get('perfil') != 2)
                alert('Você não tem permissão para fazer esta ação');
                return false;
            @endif
            var erro     = 0;
            var titulo   = 'Formação Superior';
            var texto    = 'Antes de clicar em OK, preencha todos os campos! Obs1: Formação Superior sem upload de histórico não será levada em consideração. Obs2: Para formação completa (com ano de término), é preciso também apresentar o diploma ou equivalente quando solicitado. Caso formando, uma declaração da secretaria do curso deverá ser apresentada quando solicitado. Veja Documentação necessária no Portal de Seleção para mais detalhes.';
            var concluido= $('#concluido').val();
            var file     = 0;
	    var formado = $('#formacao').val();

            $(".imginput").each(function(){
                if($(this).val()!='' && $(this).val()!=null) {
                    file++;
                }
            });

            if(concluido == 'Sim' && formado == 'Graduação' && file == 0){
                $('.modal-body').text('Atenção, Formação Superior sem upload de histórico não será considerada e sua inscrição não será validada!');
                $('#myModal').modal('show');
                return true; 
            }

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

            //Abaixo, uma dadiva dos ninjas
            if(erro == 0)
            {
                adicionar();
                limpar();
            }
            else
            {
                $('#myModal').modal('show');
            }
        });

        $('#adicionarFormacao').click(function(){
            limpar();
        });

        $(".onlyNumbers").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    });

</script>

<script type="text/javascript">
    //NOVAS IMAGENS
    function readURL()
    {
        //  rehide the image and remove its current "src",
        //  this way if the new image doesn't load,
        //  then the image element is "gone" for now
        if (this.files && this.files[0])
        {
            var reader = new FileReader();
            $(reader).load(function(e) {
                $('#img')
                //  first we set the attribute of "src" thus changing the image link
                .attr('src', e.target.result)   //  this will now call the load event on the image
            });
            reader.readAsDataURL(this.files[0]);
        }
    }

    function readURL2(input, imgid)
    {
        if (input.files && input.files[0])
        {
            var reader = new FileReader();
            reader.onload = function (e)
            {
                $(imgid).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(document).ready(function()
    {
        
        
        $("#imagem").change(readURL);

        $("#img").click(function()
        {
            $("#imagem").trigger('click');
        });

        $("#imagens").on("change", ".imginput", function(event)
        {            
            event.preventDefault();            
            readURL2(this, '#img'+this.id);
            
        });


        // insere documento
        $("#addimg").click(function()
        {
            //alert($(".imgthumb").size());           
            //alert($(".imgthumb").last().attr('count'));
            if($(".imgthumb").last().attr('count'))
            {
                var i = parseInt($(".imgthumb").last().attr('count')) + 1;
            }
            else
            {
                var i = 0;
            }
                        
            
            //Documento '+ i +'
            $("#imagens").append('<div class="row"><div class="col-md-6"><span><label class="">Título</label>\
                                 <br/><input type="text" name="titulo[]"><br/>\
                                 <input class="form-control imginput" type="file" id="'+i+'" name="imagens[]" accept="image/jpeg,image/jpg,image/png,application/pdf"></span></div>\
                                 <div class="col-md-2"><span><button type="button" class="btn btn-danger delimg" inputid = "'+i+'"> Apagar </button> </div>\
                                 <div class="col-md-4"><img class="imgthumb" id="img'+i+'" count="'+i+'" src="images/placeholder.jpg" alt="" style="width: 100%; height: 100%; cursor: pointer;"></div>\
                                 </div>');
            i++;
        });

        // apaga documento
        $(document).on('click', '.delimg', function()
        {
            var id = $(this).attr('imgid');

            var imgdiv = $(this).parent().closest('.row');

            //alert('apagar imagem ' + id);
            
            if(id)
            { 
                $.get( "{{URL::to('imagem/delete')}}/" + id ).done(function(data)
                {                    
                    imgdiv.remove();
                });
            }
            else
            {
                imgdiv.remove();
            }

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

    });

</script>

@stop
@section('content')

@include('elements.alerts')

<div class="page ng-scope">

    <form id="form_formacao" class="form-horizontal ng-pristine ng-valid" role="form" method="POST" action="candidato/meusdados/formacao" enctype="multipart/form-data">

        <section class="panel panel-default">

            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Formação Superior</strong></div>

            <div class="panel-body">

                <div class="row" id="texto">

                    <div class="col-md-12">

                        <p>
                            Indicar o(s) curso(s) superior(es) mais relevante(s) já concluído(s), ainda em andamento ou interrompido(s). Os alunos que ainda não possuem nenhuma formação superior e que estão cursando o último ano da graduação devem indicá-las como em andamento. Para a instituição preencher estado onde se localiza (e país, caso seja estrangeira).
                        </p>

                    </div>

                </div>

                <div class="panel panel-default" id="editarFormacao">

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <input type="hidden" name="fid" id="fid" value="">
                                        <input type="hidden" name="cod" id="cod" value="">

                                        <div class="form-group">

                                            <label class="col-sm-3">Formação</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="formacao" id="formacao" style="margin: 0 !important;">

                                                        <option value="Graduação">Graduação</option>

                                                        <option value="Pós Graduação">Pós graduação</option>

                                                        <option value="Mestrado">Mestrado</option>

                                                        <option value="Doutorado">Doutorado</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Concluído?</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="concluido" id="concluido" style="margin: 0 !important;">

                                                        <option value="Sim">Sim</option>

                                                        <option value="Não">Não</option>

                                                        <option value="Em andamento">Em andamento</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Instituição</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="instituicao" id="instituicao" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">País</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="pais" id="pais" class="form-control texto" value="">
                                                <!-- <span class="ui-select">

                                                    <select name="pais" id="pais" style="margin: 0 !important;">

                                                        <option value="Brasil">Brasil</option>

                                                        <option value="Argentina">Argentina</option>

                                                        <option value="Chile">Chile</option>

                                                    </select>

                                                </span> -->

                                            </div>

                                        </div>
                                        
                                        <div class="form-group">

                                            <label class="col-sm-3">Estado</label>

                                            <div class="col-sm-8" id="div-estado-field">
                                                <input type="text" name="estado" id="estado" class="form-control texto" value="">
                                                <!--<span class="ui-select">


                                                    <select name="estado" id="estado" style="margin: 0 !important;">

                                                        <option value="RJ">Rio de Janeiro</option>

                                                        <option value="SP">São Paulo</option>

                                                        <option value="ES">Espírito Santo</option>

                                                    </select>

                                                </span>-->

                                            </div>

                                        </div>

                                        

                                        <div class="form-group">

                                            <label class="col-sm-3">Curso</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="curso" id="curso" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3" tooltip="Coeficiente de Rendimento atual ou final, sobre o Grau máximo possível (ex. 8.2 / 10.0). Só são aceitos números, se o coeficiente for conceito faça a conversão necessária.">Coeficiente de Rendimento / Grau máximo possível</label>

                                            <div class="col-sm-4">
                                                <input type="text" name="cr" id="cr" class="form-control texto onlyNumbers" value="" maxlength="5">
                                            </div>
                                            <div class="col-sm-1"><strong style="font-size:25px;">/</strong></div>
                                            <div class="col-sm-3">
                                                <input type="text" name="media_maxima" id="media_maxima" maxlength="5" class="form-control texto onlyNumbers" value="" placeholder="Média Máxima">
                                            </div>

                                        </div>

                                        <!-- <div class="form-group">

                                            <label class="col-sm-3">Valor</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="valor" id="valor" class="form-control texto" value="">

                                            </div>

                                        </div> -->

                                        <!-- <div class="form-group">

                                            <label class="col-sm-3">Média Maxima</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="media_maxima" id="media_maxima" class="form-control texto" value="">

                                            </div>

                                        </div> -->

                                        <div class="form-group">

                                            <label class="col-sm-3">Ano de início</label>

                                            <div class="col-sm-3">

                                                <span class="ui-select">

                                                    <select name="ano_inicio" id="ano_inicio" style="margin: 0 !important;">

                                                    {? $ano_inicio = Carbon::now()->year; ?}

                                                    @for($i=0;$i<60;$i++)

                                                        <option value="{{ $ano_inicio }}">{{ $ano_inicio }}</option>

                                                        {? $ano_inicio--; ?}

                                                    @endfor

                                                    </select>

                                                </span>
                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Ano de término</label>

                                            <div class="col-sm-3">

                                                <span class="ui-select">

                                                    <select name="ano_fim" id="ano_fim" style="margin: 0 !important;">

                                                    {? $ano_fim = Carbon::now()->year; ?}
                                                        <option value=""> Em progresso </option>
                                                    @for($i=0;$i<60;$i++)

                                                        <option value="{{ $ano_fim }}">{{ $ano_fim }}</option>

                                                        {? $ano_fim--; ?}

                                                    @endfor

                                                    </select>

                                                </span>


                                            </div>

                                        </div>


                                        <div class="col-sm-12">
                                            <h2> Documentos (Imagens) </h2>
                                            <small>Obs1: Formação Superior sem upload de histórico não será levada em consideração.</small><br>
                                            <small>Obs2: Para formação completa (com ano de término), é preciso entregar cópia do diploma ou equivalente se solicitado. Caso formando, deverá apresentar declaração da secretaria do curso caso solicitado. 
                                                <br>Veja Documentação necessária no <a href="http://www.cos.ufrj.br/selecao">Portal de Seleção</a> para mais detalhes.</small>
                                            <div id="imagens" class="form-group">


                                            </div>
                                            <div class="form-group">
                                                <a class="btn btn-default" id="addimg">Adicionar Documento</a>
                                            </div>
                                        </div>

                                        <!--<a href="#"></a>-->
                                        <button type="button" id="salvar" class="btn bg-orange pull-right">Salvar Formação</button>
                                        @if(isset($userId) && $userId)
                                            <input type="hidden" name="userId" value="{{$userId}}" />
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <!-- fim primeira coluna -->

                            <div class="col-sm-1">
                                <table style="width: 3px; height: 600px;" align="center">
                                    <tr>
                                        <td style="background-color: #EAEAEA;">&nbsp;</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-3">

                                <div id="formacoes">
                                    @if(isset($formacoes))
                                        {? $contador = 0; ?}
                                        @foreach($formacoes as $formacao)
                                            <div id="formacao-{{$contador}}">
                                                <div class="row">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][id]"           id="formacao-{{ $contador }}-id"           value="{{$formacao->id}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][formacao]"     id="formacao-{{ $contador }}-formacao"     value="{{$formacao->formacao}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][concluido]"    id="formacao-{{ $contador }}-concluido"    value="{{$formacao->concluido}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][instituicao]"  id="formacao-{{ $contador }}-instituicao"  value="{{$formacao->instituicao}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][estado]"       id="formacao-{{ $contador }}-estado"       value="{{$formacao->estado}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][pais]"         id="formacao-{{ $contador }}-pais"         value="{{$formacao->pais}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][curso]"        id="formacao-{{ $contador }}-curso"        value="{{$formacao->curso}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][cr]"           id="formacao-{{ $contador }}-cr"           value="{{$formacao->cr}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][valor]"        id="formacao-{{ $contador }}-valor"        value="{{$formacao->valor}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][media_maxima]" id="formacao-{{ $contador }}-media_maxima" value="{{$formacao->media_maxima}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][ano_inicio]"   id="formacao-{{ $contador }}-ano_inicio"   value="{{$formacao->ano_inicio}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][ano_fim]"      id="formacao-{{ $contador }}-ano_fim"      value="{{$formacao->ano_fim}}">
                                                    <input type="hidden" name="formacoes[{{ $contador }}][documento_formacao_img]"      id="formacao-{{ $contador }}-documento_formacao_img"      value="@if($formacao->documento_formacao_img) uploads/candidatos/formacoes/{{Auth::user()->id}}/{{$formacao->documento_formacao_img}} @else images/placeholder.jpg @endif">
                                                    {? $i_img = 0 ?}
                                                    @if($formacao->imagens)
                                                        @foreach($formacao->imagens as $img)
                                                            <input type="hidden" name="formacoes[{{ $contador }}][id[{{$i_img}}]]"      id="formacao-{{ $contador }}-id{{$i_img}}"       value="{{$img->id}}">
                                                            <input type="hidden" name="formacoes[{{ $contador }}][titulo[{{$i_img}}]]"  id="formacao-{{ $contador }}-titulo{{$i_img}}"   value="{{$img->titulo}}">
                                                            <input type="hidden" name="formacoes[{{ $contador }}][imagem[{{$i_img}}]]"  class="imgdo{{$contador}}"  imgid="{{$img->id}}"  id="formacao-{{ $contador }}-imagem{{$i_img}}"      value="{{$img->caminho}}{{$img->nome}}">
                                                        {? $i_img++; ?}
                                                        @endforeach
                                                    @endif
                                                    <div class="col-sm-2" style="text-align: right;font-size: 28px;">
                                                        <span id="span-contador-{{$contador}}">{{ ($contador+1) . '</span>-'}}
                                                    </div>
                                                    <div class="col-sm-7">
                                                    {{$formacao->formacao}} <br/>
                                                    {{$formacao->curso}}  {{$formacao->instituicao}}
                                                    </div>
                                                    <div class="col-sm-3">
                                                    <a href="javascript:editar('{{ $contador }}');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;
                                                    <a href="javascript:apagar('{{ $contador }}');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>
                                                    </div>
                                                </div>
                                                <hr style="background-color: #EAEAEA;height: 2px;"/>
                                            </div>
                                            {? $contador++; ?}
                                        @endforeach
                                    @endif
                                </div>

                                <div id="ajaxLoading" style="text-align: center; display:none;">
                                    <div class="loadingAjax" style="margin-left: auto; margin-right: auto;">
                                    <div class="wBall" id="wBall_1">
                                    <div class="wInnerBall">
                                    </div>
                                    </div>
                                    <div class="wBall" id="wBall_2">
                                    <div class="wInnerBall">
                                    </div>
                                    </div>
                                    <div class="wBall" id="wBall_3">
                                    <div class="wInnerBall">
                                    </div>
                                    </div>
                                    <div class="wBall" id="wBall_4">
                                    <div class="wInnerBall">
                                    </div>
                                    </div>
                                    <div class="wBall" id="wBall_5">
                                    <div class="wInnerBall">
                                    </div>
                                    </div>
                                    </div>
                                </div>

                                <br/>

                                <button type="button" id="adicionarFormacao" class="btn btn-default">Adicionar outra formação</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- <a href="#"></a> -->
                <!--button type="submit" id="concluir" class="btn btn-primary pull-right">Salvar e concluir</button-->

            <!-- -->
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