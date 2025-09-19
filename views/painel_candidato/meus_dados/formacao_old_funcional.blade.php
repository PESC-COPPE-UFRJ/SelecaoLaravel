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

        i= $("#formacoes > div").length;
    }

    function adicionar()
    {
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
                                html+= '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
                                html += (contador+1) + '-';
                                html+= '</div>';
                                html+= '<div class="col-sm-7">';
                                html+= formacao + '<br/>';
                                html+= curso + ' ' + instituicao;
                                html+= '</div>';
                                html += '<div class="col-sm-3">';
                                html += '<a href="javascript:editar(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
                                html += '<a href="javascript:apagar(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
                                html += '</div>';
                                html+= '</div>';
                                html+= '<hr style="background-color: #EAEAEA;height: 2px;"/>';
                                html+= '</div>';

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

                                console.log('adicionar -' + i);
                            }

        var complete_f =    function func_complete(xhr)
                            {
                                $("#ajaxLoading").hide();
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

        // $.post('candidato/meusdados/formacao-single', $('#form_formacao').serialize(), function(data)
        // {
        //     if(data.id != '')
        //     {
        //         fid = data.id;
        //     }
        // }, "json").done(function()
        // {

        //     html+= '<div id="formacao-' + i + '">';
        //     html+= '<div class="row">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][id]"           id="formacao-' + i + '-id"           value="' + fid         + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][formacao]"     id="formacao-' + i + '-formacao"     value="' + formacao    + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][concluido]"    id="formacao-' + i + '-concluido"    value="' + concluido   + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][instituicao]"  id="formacao-' + i + '-instituicao"  value="' + instituicao + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][estado]"       id="formacao-' + i + '-estado"       value="' + estado      + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][pais]"         id="formacao-' + i + '-pais"         value="' + pais        + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][curso]"        id="formacao-' + i + '-curso"        value="' + curso       + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][cr]"           id="formacao-' + i + '-cr"           value="' + cr          + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][valor]"        id="formacao-' + i + '-valor"        value="' + valor       + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][media_maxima]" id="formacao-' + i + '-media_maxima" value="' + media_maxima+ '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][ano_inicio]"   id="formacao-' + i + '-ano_inicio"   value="' + ano_inicio  + '">';
        //     html+= '<input type="hidden" name="formacoes[' + i + '][ano_fim]"      id="formacao-' + i + '-ano_fim"      value="' + ano_fim + '">';
        //     html+= '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
        //     html += (contador+1) + '-';
        //     html+= '</div>';
        //     html+= '<div class="col-sm-7">';
        //     html+= formacao + '<br/>';
        //     html+= curso + ' ' + instituicao;
        //     html+= '</div>';
        //     html += '<div class="col-sm-3">';
        //     html += '<a href="javascript:editar(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
        //     html += '<a href="javascript:apagar(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
        //     html += '</div>';
        //     html+= '</div>';
        //     html+= '<hr style="background-color: #EAEAEA;height: 2px;"/>';
        //     html+= '</div>';

        //     if(cod != '')
        //     {
        //         i = cod;
        //     }

        //     if(cod!='')
        //     {
        //         $('#formacao-'+cod).html(html);
        //     }
        //     else
        //     {
        //         $('#formacoes').append(html);
        //     }

        //     i++;

        //     $("#ajaxLoading").hide();

        // });
    }

    function editar(id)
    {
        i=id;

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

        console.log('editar - ' + i);
    }

    function apagar(id)
    {
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

        $('#formacao-'+id).remove();
        limpar();
    }

    $(document).ready(function() {


        // bind 'myForm' and provide a simple callback function
        $('#form_formacao').ajaxForm();


        $('#salvar').click(function(){

            var erro   = 0;
            var titulo = 'Formação Superior';
            var texto  = 'Antes de clicar em OK, preencha todos os campos!';

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

                <div class="panel panel-default" id="adicionarDocencias">

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

                                            <label class="col-sm-3">Estado</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="estado" id="estado" style="margin: 0 !important;">

                                                        <option value="RJ">Rio de Janeiro</option>

                                                        <option value="SP">São Paulo</option>

                                                        <option value="ES">Espírito Santo</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">País</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="pais" id="pais" style="margin: 0 !important;">

                                                        <option value="Brasil">Brasil</option>

                                                        <option value="Argentina">Argentina</option>

                                                        <option value="Chile">Chile</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Curso</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="curso" id="curso" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Coeficiente de Rendimento</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="cr" id="cr" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Valor</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="valor" id="valor" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Média Maxima</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="media_maxima" id="media_maxima" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Ano de início</label>

                                            <div class="col-sm-3">

                                                <span class="ui-select">

                                                    <select name="ano_inicio" id="ano_inicio" style="margin: 0 !important;">

                                                    {? $ano_inicio = Carbon::now()->year; ?}

                                                    @for($i=0;$i<30;$i++)

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
                                                    @for($i=0;$i<30;$i++)

                                                        <option value="{{ $ano_fim }}">{{ $ano_fim }}</option>

                                                        {? $ano_fim--; ?}

                                                    @endfor

                                                    </select>

                                                </span>


                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Upload de Documento</label>

                                            <div class="col-sm-3">

                                                {{ Form::file('documento_formacao_img', array('id' => 'documento_formacao_img')) }}

                                            </div>

                                        </div>

                                        <div class="form-grouo">

                                            <div class="col-sm-4">
                                                Envie UM documento referente a esta formação.<br />
                                                Ordem de importancia:
                                                <ol>
                                                    <li>Diploma da Graduação</li>
                                                    <li>Diploma do segundo grau ou declaração de colação de grau</li>
                                                    <li>Declaração de inscrição em todas as disciplinas</li>
                                                    <li>Histórico</li>
                                                </ol>
                                            </div>

                                            <div class="col-sm-4">


                                                    <a target="_blank" class="img-responsive-link">
                                                        <img class="img-responsive" src="images/placeholder.jpg" id="documento_formacao_img_src"/>
                                                    </a>


                                            </div>

                                            <div class="col-sm-4">

                                            </div>

                                        </div>

                                        <!--<a href="#"></a>-->
                                        <button type="button" id="salvar" class="btn bg-orange pull-right">OK</button>

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
                                                    <div class="col-sm-2" style="text-align: right;font-size: 28px;">
                                                        {{ ($contador+1) . '-'}}
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