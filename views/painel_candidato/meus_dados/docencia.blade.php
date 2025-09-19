@extends('templates.master')

@section('css')

    <link rel="stylesheet" href="styles/datepicker.css">

    <link rel="stylesheet" href="styles/datepicker3.css">

@stop

@section('scripts')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="scripts/locales/bootstrap-datepicker.pt-BR.js"></script>

<script type="text/javascript">

    @if(isset($docencias) && $docencias->count() > 0)
        var i = {{$docencias->count()}};
    @else
        var i = 0;
    @endif

    function limpar()
    {
        $('#cod').val('')
        $('#instituicao').val('');
        $('#estado').val('RJ');
        $('#pais').val('Brasil');
        $('#tipo').val('Pública');
        $('#departamento').val('');
        $('#disciplina').val('');
        $('#nivel').val('Graduação');
        $('#desde').val('');
        $('#ate').val('');
        $('#did').val('');
    }

    function adicionar()
    {
        var contador     = parseInt(i);
        var html = '';
        var cod          = $('#cod').val();
        var did          = $('#did').val();
        var instituicao  = $('#instituicao').val();
        var estado       = $('#estado').val();
        var pais         = $('#pais').val();
        var tipo         = $('#tipo').val();
        var departamento = $('#departamento').val();
        var disciplina   = $('#disciplina').val();
        var nivel        = $('#nivel').val();
        var desde        = $('#desde').val();
        var ate          = $('#ate').val();


        $("#ajaxLoading").show();
        $.post('candidato/meusdados/docencia-single', $('#form_docencia').serialize(), function(data)
        {
            if(data.id != '')
            {
                did = data.id;
            }
        }, "json").done(function()
        {


        html += '<div id="docencia-' + i + '">';
        html += '<div class="row">';
        html += '<input type="hidden" name="docencias[' + i + '][id]"           id="docencia-' + i + '-id"           value="' + did          + '">';
        html += '<input type="hidden" name="docencias[' + i + '][instituicao]"  id="docencia-' + i + '-instituicao"  value="' + instituicao  + '">';
        html += '<input type="hidden" name="docencias[' + i + '][estado]"       id="docencia-' + i + '-estado"       value="' + estado       + '">';
        html += '<input type="hidden" name="docencias[' + i + '][pais]"         id="docencia-' + i + '-pais"         value="' + pais         + '">';
        html += '<input type="hidden" name="docencias[' + i + '][tipo]"         id="docencia-' + i + '-tipo"         value="' + tipo         + '">';
        html += '<input type="hidden" name="docencias[' + i + '][departamento]" id="docencia-' + i + '-departamento" value="' + departamento + '">';
        html += '<input type="hidden" name="docencias[' + i + '][disciplina]"   id="docencia-' + i + '-disciplina"   value="' + disciplina   + '">';
        html += '<input type="hidden" name="docencias[' + i + '][nivel]"        id="docencia-' + i + '-nivel"        value="' + nivel        + '">';
        html += '<input type="hidden" name="docencias[' + i + '][desde]"        id="docencia-' + i + '-desde"        value="' + desde        + '">';
        html += '<input type="hidden" name="docencias[' + i + '][ate]"          id="docencia-' + i + '-ate"          value="' + ate          + '">';
        html += '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
        html += (contador+1) + '-';
        html += '</div>';
        html += '<div class="col-sm-7">';
        html += nivel + '<br/>';
        html += ' ' + instituicao + ' - ' + disciplina;
        html += '</div>';
        html += '<div class="col-sm-3">';
        html += '<a href="javascript:editar(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
        html += '<a href="javascript:apagar(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
        html += '</div>';
        html += '</div>';
        html += '<hr style="background-color: #EAEAEA;height: 2px;"/>';
        html += '</div>';

        if(cod != '') {
            i = cod;
        }

        if(cod!='')
        {
            $('#docencia-'+cod).html(html);
        }
        else
        {
            $('#docencias').append(html);
        }

        i++;

        $("#ajaxLoading").hide();
    });
    }

    function editar(id)
    {
        i=id;
        $('#cod').val(id);
        $('#did').val($('#docencia-' + id + '-id').val());
        $('#docencia-' + id + '-id').val($('#docencia-' + id + '-id').val());
        $('#instituicao').val($('#docencia-' + id +'-instituicao').val());
        $('#estado').val($('#docencia-' + id +'-estado').val());
        $('#pais').val($('#docencia-' + id +'-pais').val());
        $('#tipo').val($('#docencia-' + id +'-tipo').val());
        $('#departamento').val($('#docencia-' + id +'-departamento').val());
        $('#disciplina').val($('#docencia-' + id +'-disciplina').val());
        $('#nivel').val($('#docencia-' + id +'-nivel').val());
        $('#desde').val($('#docencia-' + id +'-desde').val());
        $('#ate').val($('#docencia-' + id +'-ate').val());
    }

    function apagar(id)
    {
        var confirmDelete = confirm("Deseja deletar esta docência?");
        if(confirmDelete){
            i--;

            var cod = $('#docencia-' + id + '-id').val();

            if(cod!='') {
                $.post(
                    "candidato/meusdados/apagar-docencia",
                     {idDocencia: cod},
                     function(response) {
                        console.log('Docência: ' + cod + ' apagada com sucesso!');
                    }
                );
            }

            $('#docencia-'+id).remove();
            limpar();

            if(i==0) {
                $('.nao').prop('checked',true);
                $('#adicionarDocencias').hide();
                $('#texto').hide();
                $('#concluir').hide();
            }
        }
    }

    $(document).ready(function() {

        $('#adicionarDocencias').hide();
        $('#texto').hide();
        $('#concluir').hide();

        @if(isset($docencias) && $docencias->count() > 0)
            $('.sim').prop('checked',true);
            $('#adicionarDocencias').show();
            $('#texto').show();
            $('#concluir').show();
        @endif

        $('#desde').datepicker({
            autoclose:  true,
            format: 'MM/yyyy',
            language: 'pt-BR'
        });

        $('#ate').datepicker({
            autoclose:  true,
            format: 'MM/yyyy',
            language: 'pt-BR'
        });

        $('.radio').change(function() {

            var eDocente = $(this).val();

            if(eDocente == 1)
            {
                $('#adicionarDocencias').show();
                $('#texto').show();
                $('#concluir').show();
            }
            else
            {
                $('#adicionarDocencias').hide();
                $('#texto').hide();
                $('#concluir').hide();
            }

        });

        $('#salvar').click(function(){
            var erro   = 0;
            var titulo = 'Docência';
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

        $('#adicionarCurso').click(function(){
            limpar();
        });
        // lista de todos os estados do brasil
        var availableStates = [
          "Acre",
          "Alagoas",
          "Amapá",
          "Amazonas",
          "Bahia",
          "Ceará",
          "Distrito Federal",
          "Espírito Santo",
          "Goiás",
          "Maranhão",
          "Mato Grosso",
          "Mato Grosso do Sul",
          "Minas Gerais",
          "Pará",
          "Paraíba",
          "Paraná",
          "Pernambuco",
          "Piauí",
          "Rio de Janeiro",
          "Rio Grande do Norte",
          "Rio Grande do Sul",
          "Rondônia",
          "Roraima",
          "Santa Catarina",
          "São Paulo",
          "Sergipe",
          "Tocantins"
        ];
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
        $( "#estado" ).autocomplete({
          source: availableStates
        });
        $( "#pais" ).autocomplete({
          source: availableCountries
        });
    });

</script>

@stop
@section('content')
<div class="page ng-scope">

    <form
        id="form_docencia"
        class="form-horizontal ng-pristine ng-valid"
        role="form"
        method="POST"
        action="candidato/meusdados/docencia">

        <section class="panel panel-default">

            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Docência</strong></div>

            <div class="panel-body">

                <div class="row" style="margin: 4% 25%;">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label class="col-sm-4">É/Foi docente universitário?</label>

                            <div class="col-sm-6">

                                <label class="ui-radio"><input name="ehdocente" type="radio" class="radio sim" value="1"><span>Sim</span></label>

                                <label class="ui-radio"><input name="ehdocente" type="radio" class="radio nao" value="2" checked><span>Não</span></label>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row" id="texto">

                    <div class="col-md-12">

                        <p>Preencha os últimos 5 cursos ministrados, em caso de ainda estar ministrando, deixar o campo ATÉ em branco.</p>

                    </div>

                </div>

                <div class="panel panel-default" id="adicionarDocencias">

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-8">

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <input type="hidden" name="did" id="did" value="">
                                        <input type="hidden" name="cod" id="cod" value="">

                                        <div class="form-group">

                                            <label class="col-sm-3">Instituição</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="instituicao" id="instituicao" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Estado</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="estado" id="estado" class="form-control texto" value="">
                                                <!-- <span class="ui-select">

                                                    <select name="estado" id="estado">

                                                        <option value="RJ">Rio de Janeiro</option>

                                                        <option value="SP">São Paulo</option>

                                                        <option value="ES">Espírito Santo</option>

                                                    </select>

                                                </span> -->

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">País</label>

                                            <div class="col-sm-8">
                                                <input type="text" name="pais" id="pais" class="form-control texto" value="">
                                                <!-- <span class="ui-select">

                                                    <select name="pais" id="pais">

                                                        <option value="Brasil">Brasil</option>

                                                        <option value="Argentina">Argentina</option>

                                                        <option value="Chile">Chile</option>

                                                    </select>

                                                </span> -->

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Tipo</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="tipo" id="tipo">

                                                        <option value="Pública">Pública</option>

                                                        <option value="Particular">Particular</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Departamento</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="departamento" id="departamento" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Nível</label>

                                            <div class="col-sm-8">

                                                <span class="ui-select">

                                                    <select name="nivel" id="nivel">

                                                        <option value="Graduação">Graduação</option>

                                                        <option value="Pós-graduação">Pós-graduação</option>

                                                    </select>

                                                </span>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Nome da Disciplina</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="disciplina" id="disciplina" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Desde</label>

                                            <div class="col-sm-3">

                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="desde" id="desde" class="form-control texto" value="">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-3">Até</label>

                                            <div class="col-sm-3">

                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="ate" id="ate" class="form-control texto" value="">
                                                </div>

                                            </div>

                                        </div>

                                        <!--<a href="#"></a>-->
                                        <button type="button" id="salvar" class="btn bg-orange pull-right">Salvar</button>

                                    </div>

                                </div>

                            </div>

                            <!-- fim primeira coluna -->

                            <div class="col-sm-1 hidden-xs hidden-sm">
                                <table style="width: 3px; height: 600px;" align="center">
                                    <tr>
                                        <td style="background-color: #EAEAEA;">&nbsp;</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-md-3">

                                <div id="docencias">

                                    <!-- <div class="row"> -->

<!--                                         <div class="col-sm-8">
                                            Adicione suas experiências como docente!
                                        </div>
                                        <br/>
                                        <br/><div> -->


                                            @if(isset($docencias))
                                                {? $contador = 0; ?}
                                                @foreach($docencias as $docencia)
                                                    {{--$docencia->instituicao--}}
                                                    <div id="docencia-{{ $contador }}">
                                                    <div class="row">
                                                    <input type="hidden" name="docencias[{{ $contador }}][id]"           id="docencia-{{ $contador }}-id"           value="{{$docencia->id}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][instituicao]"  id="docencia-{{ $contador }}-instituicao"  value="{{$docencia->instituicao}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][estado]"       id="docencia-{{ $contador }}-estado"       value="{{$docencia->estado}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][pais]"         id="docencia-{{ $contador }}-pais"         value="{{$docencia->pais}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][tipo]"         id="docencia-{{ $contador }}-tipo"         value="{{$docencia->tipo}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][departamento]" id="docencia-{{ $contador }}-departamento" value="{{$docencia->departamento}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][disciplina]"   id="docencia-{{ $contador }}-disciplina"   value="{{$docencia->disciplina}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][nivel]"        id="docencia-{{ $contador }}-nivel"        value="{{$docencia->nivel}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][desde]"        id="docencia-{{ $contador }}-desde"        value="{{$docencia->desde}}">
                                                    <input type="hidden" name="docencias[{{ $contador }}][ate]"          id="docencia-{{ $contador }}-ate"          value="{{$docencia->ate}}">
                                                    <div class="col-sm-2" style="text-align: right;font-size: 28px;">
                                                        {{ ($contador+1) . '-'}}
                                                    </div>
                                                    <div class="col-sm-7">
                                                    {{$docencia->nivel}} <br/>
                                                    {{$docencia->instituicao}}  {{$docencia->disciplina}}
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

                                    <!-- </div></div> -->

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

                                <button type="button" id="adicionarCurso" class="btn btn-default">Adicionar outro curso</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!--button type="submit" id="concluir" class="btn btn-primary pull-right">Salvar e concluir</button-->

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