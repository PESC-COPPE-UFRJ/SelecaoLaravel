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

    @if(isset($experiencias) && $experiencias->count() > 0)
        var i = {{$experiencias->count()}};
    @else
        var i = 0;
    @endif

    function limpar()
    {
        $('#eid').val('');
        $('#cod').val('');
        $('#empresa').val('');
        $('#url').val('');
        $('#funcao').val('');
        $('#endereco').val('');
        $('#admissao').val('');
        $('#demissao').val('');
    }

    function adicionar()
    {
        var contador  = parseInt(i);
        var html      = '';
        var cod       = $('#cod').val();
        var eid       = $('#eid').val();
        var empresa   = $('#empresa').val();
        var url       = $('#url').val();
        var funcao    = $('#funcao').val();
        var endereco  = $('#endereco').val();
        var admissao  = $('#admissao').val();
        var demissao  = $('#demissao').val();

        $("#ajaxLoading").show();
        $.post('candidato/meusdados/experiencia-single', $('#form_experiencia').serialize(), function(data)
        {
            if(data.id != '')
            {
                eid = data.id;
            }
        }, "json").done(function()
        {

            html+= '<div id="experiencia-' + i + '">';
            html+= '<div class="row">';
            html+= '<input type="hidden" name="experiencias[' + i + '][id]"       id="experiencia-' + i + '-id"       value="' + eid      + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][empresa]"  id="experiencia-' + i + '-empresa"  value="' + empresa  + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][url]"      id="experiencia-' + i + '-url"      value="' + url  + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][funcao]"   id="experiencia-' + i + '-funcao"   value="' + funcao   + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][endereco]" id="experiencia-' + i + '-endereco" value="' + endereco + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][admissao]" id="experiencia-' + i + '-admissao" value="' + admissao + '">';
            html+= '<input type="hidden" name="experiencias[' + i + '][demissao]" id="experiencia-' + i + '-demissao" value="' + demissao + '">';
            html+= '<div class="col-sm-2" style="text-align: right;font-size: 28px;">';
            html += (contador+1) + '-';
            html+= '</div>';
            html+= '<div class="col-sm-7">';
            html+= empresa + '<br/>';
            html+= funcao;
            html+= '</div>';
            html += '<div class="col-sm-3">';
            html += '<a href="javascript:editar(\'' + i + '\');" class="editar"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;';
            html += '<a href="javascript:apagar(\'' + i + '\');" class="remover"><span class="glyphicon glyphicon-remove"></span></a>';
            html += '</div>';
            html+= '</div>';
            html+= '<hr style="background-color: #EAEAEA;height: 2px;"/>';
            html+= '</div>';

            if(cod != '') {
                i = cod;
            }

            if(cod!='')
            {
                $('#experiencia-'+cod).html(html);
            }
            else
            {
                $('#experiencias').append(html);
            }

            i++;

            $("#ajaxLoading").hide();
        });
    }

    function editar(id)
    {
        i=id;

        var empresa   = $('#empresa').val();
        var empresa   = $('#url').val();
        var funcao    = $('#funcao').val();
        var endereco  = $('#endereco').val();
        var admissao  = $('#admissao').val();
        var demissao  = $('#demissao').val();

        $('#cod').val(id);
        $('#eid').val($('#experiencia-' + id + '-id').val());
        $('#experiencia-' + id + '-id').val($('#experiencia-' + id + '-id').val());
        $('#empresa').val($('#experiencia-' + id + '-empresa').val());
        $('#url').val($('#experiencia-' + id + '-url').val());
        $('#funcao').val($('#experiencia-' + id + '-funcao').val());
        $('#endereco').val($('#experiencia-' + id + '-endereco').val());
        $('#admissao').val($('#experiencia-' + id + '-admissao').val());
        $('#demissao').val($('#experiencia-' + id + '-demissao').val());
    }

    function apagar(id)
    {
        var confirmDelete = confirm("Deseja deletar esta experiência?");
        if(confirmDelete){
            i--;

            var cod = $('#experiencia-' + id + '-id').val();

            if(cod!='') {
                $.post(
                    "candidato/meusdados/apagar-experiencia",
                    {idExperiencia: cod},
                    function(response) {
                        console.log('Experiência: ' + cod + ' apagada com sucesso!');
                    }
                );
            }

            $('#experiencia-'+id).remove();
            limpar();
        }
    }

    $(document).ready(function() {

        $('#admissao').datepicker({
            autoclose:  true,
            format: 'dd/MM/yyyy',
            language: 'pt-BR'
        });

        $('#demissao').datepicker({
            autoclose:  true,
            format: 'dd/MM/yyyy',
            language: 'pt-BR'
        });

        $('#salvar').click(function(){
            var erro   = 0;
            var titulo = 'Experiência Profissional';
            var texto  = 'Antes de clicar em OK, preencha todos os campos!';

            $('#myModal').on('show.bs.modal', function (event) {
              var modal = $(this);
              modal.find('.modal-title').text(titulo);
              modal.find('.modal-body').text(texto);
            });

            $('.texto').each(function(){
                if($(this).val() == '') {

                    if($(this).attr('id') != 'demissao')
                    {
                        erro++;
                    }
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


<script type="text/javascript">

    $(function () {
      $('[data-toggle="tooltip-data"]').tooltip()
    })

</script>

@stop
@section('content')
<div class="page ng-scope">

    <form id="form_experiencia" class="form-horizontal ng-pristine ng-valid" role="form" method="POST" action="candidato/meusdados/experiencia">
        <input type="hidden" name="userId" value="{{$userId}}" id="userId" />
        <section class="panel panel-default">

            <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Experiência Profissional</strong></div>

            <div class="panel-body">

                <div class="row" id="texto">

                    <div class="col-md-12">

                        <p>
                            Indique a(s) sua(s) experiência(s) profissional(ais)
                        </p>

                    </div>

                </div>

                <div class="panel panel-default" id="adicionarDocencias">

                    <div class="panel-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <input type="hidden" name="eid" id="eid" value="">
                                        <input type="hidden" name="cod" id="cod" value="">

                                        <div class="form-group">

                                            <label class="col-sm-2">Empresa</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="empresa" id="empresa" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-2">URL da empresa</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="url" id="url" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-2">Função</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="funcao" id="funcao" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-2">Endereço</label>

                                            <div class="col-sm-8">

                                                <input type="text" name="endereco" id="endereco" class="form-control texto" value="">

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-2" >Admissão</label>

                                            <div class="col-sm-4">

                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="admissao" id="admissao" class="form-control texto" value="" data-toggle="tooltip-data" data-placement="right" title="Caso não lembre o dia exato, escolha qualquer dia do mês">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-sm-2">Demissão</label>

                                            <div class="col-sm-4">

                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" name="demissao" id="demissao" class="form-control texto" value="" data-toggle="tooltip-data" data-placement="right" title="Caso não lembre o dia exato, escolha qualquer dia do mês">
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

                                <div id="experiencias">
                                    @if(isset($experiencias))
                                        {? $contador = 0; ?}
                                        @foreach($experiencias as $experiencia)
                                            <div id="experiencia-{{ $contador }}">
                                                <div class="row">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][id]"       id="experiencia-{{ $contador }}-id"       value="{{$experiencia->id}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][empresa]"  id="experiencia-{{ $contador }}-empresa"  value="{{$experiencia->empresa}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][url]"  id="experiencia-{{ $contador }}-url"  value="{{$experiencia->url}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][funcao]"   id="experiencia-{{ $contador }}-funcao"   value="{{$experiencia->funcao}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][endereco]" id="experiencia-{{ $contador }}-endereco" value="{{$experiencia->endereco}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][admissao]" id="experiencia-{{ $contador }}-admissao" value="{{$experiencia->admissao}}">
                                                    <input type="hidden" name="experiencias[{{ $contador }}][demissao]" id="experiencia-{{ $contador }}-demissao" value="{{$experiencia->demissao}}">
                                                    <div class="col-sm-2" style="text-align: right;font-size: 28px;">
                                                        {{ ($contador+1) . '-'}}
                                                    </div>
                                                    <div class="col-sm-7">
                                                    {{$experiencia->empresa}} <br/>
                                                    {{$experiencia->funcao}}
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

                                <button type="button" id="adicionarFormacao" class="btn btn-default">Adicionar outra experiência</button>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- <a href="#"></a> -->
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