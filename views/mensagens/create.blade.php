@extends('templates.master')

@section('content')
{? $temEmail = false; ?}
<div class="col-sm-12">
    <section class="panel panel-default mail-container mail-compose">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Redigir mensagem</strong></div>
        <div class="panel-body">
            <form id="form_email" action="{{URL::to('mensagem/create')}}" method="POST" class="form-horizontal">

                @if(Session::has('perfil') && Session::get('perfil') == 1)
                <dl class="dl-horizontal">
                    <dt>Tipo de filtro "para"</dt>
                    <dd>
                        <label class="ui-radio"><input name="tipo_filtro" type="radio" value="single" checked ><span>Seleção Individual</span></label>
                        <label class="ui-radio"><input name="tipo_filtro" type="radio" value="broadcast"><span>Broadcast</span></label>
                    </dd>
                </dl>
                @endif

                <div class="form-group">
                    <label for="mail_to" class="col-xs-2">Para:</label>
                    <div class="col-xs-10" id="para_singles">
                        <select id="mail_to" class="form-control" name="para[]" required="required" @if(Session::has('perfil') && Session::get('perfil') != 2) multiple size="13" @endif>
                                <option value="selecao@cos.ufrj.br">SELECAO UFRJ</option>
                                @if(!isset($requerimento))                                    
                                    @foreach($inscricoes as $inscricao)
                                        <option value="{{$inscricao->usuario->email}}" @if(Input::has('email') && Input::get('email') == $inscricao->usuario->email) {? $temEmail = true; ?} SELECTED="SELECTED" @endif usuario_id="{{$inscricao->usuario->id}}"> {{$inscricao->usuario->nome}}</option>
                                    @endforeach
                                    @foreach($professores as $professor)
                                        <option value="{{$professor->email}}" @if(Input::has('email') && Input::get('email') == $professor->email) {? $temEmail = true; ?} SELECTED="SELECTED" @endif usuario_id="{{$professor->id}}"> {{$professor->nome}}</option>
                                    @endforeach
                                    @if(Input::has('email') && Session::has('perfil') && !$temEmail)
                                        <option value="{{Input::get('email')}}" SELECTED="SELECTED" usuario_id="{{$userEmail->id}}"> {{$userEmail->nome}}</option>
                                    @endif
                                @endif
                        </select>
                    </div>

                    @if(Session::has('perfil') && Session::get('perfil') == 1)

                    <div class="col-xs-10 broadcast" id="para_broadcast">
                        <select class="form-control" name="para_broadcast[]" required="required" multiple>
                                <option value="MSC">Mestrado ({{$inscritos['MSC']}} inscritos)</option>
                                <option value="DSC">Doutorado ({{$inscritos['DSC']}} inscritos)</option>
                        </select>
                    </div>

                    <label for="mail_to" class="col-xs-2 broadcast">Das Seguintes Areas:</label>
                    <div class="col-xs-10" id="broadcast_areas">
                        <select class="form-control" name="areas_broadcast[]" multiple>
                                @foreach($areas_input as $area)
                                    <option value="{{$area->id}}">{{$area->nome}}</option>
                                @endforeach
                        </select>
                    </div>

                    <label for="mail_to" class="col-xs-2 broadcast">Nas Seguintes Situações de Inscrição:</label>
                    <div class="col-xs-10" id="broadcast_situacoes">
                        <select class="form-control" name="situacoes_broadcast[]" multiple>
                                @foreach($status as $key => $situacao)
                                    <option value="{{$key}}">{{$situacao}}</option>
                                @endforeach
                        </select>
                    </div>
                  
                    <label for="mail_to" class="col-xs-2 broadcast">Nas Seguintes Situações de Linha:</label>
                    <div class="col-xs-10" id="broadcast_situacoes">
                        <select class="form-control" name="situacoes_linha_broadcast[]" multiple>
                                @foreach($status_linha as $key => $situacao)
                                    <option value="{{$key}}">{{$situacao}}</option>
                                @endforeach
                        </select>
                    </div>

                    @endif

                </div>
                @if(isset($requerimento) && $requerimento)
                    <input type="hidden" name="requerimento" value="1" />
                    <div class="form-group">
                        <label for="mail_subject" class="col-xs-2">Linha:</label>
                        <div class="col-xs-10">
                            <select id="linha_id" class="form-control" name="linha_id" required="required">
                                @foreach($areasCandidato AS $idArea => $nomeArea)
                                    <option value="{{$idArea}}" nomeArea="{{$nomeArea}}">{{$nomeArea}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mail_subject" class="col-xs-2">Prova:</label>
                        <div class="col-xs-10">
                            <input type="text" id="prova_id" class="form-control" name="prova_id" required="required">
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label for="mail_subject" class="col-xs-2">Assunto:</label>
                    <div class="col-xs-10">
                        {? $assunto = Input::get('assunto'); ?}
                        <input type="text" id="mail_subject" class="form-control" name="assunto" value="{{ $assunto or '' }}" required="required" @if(isset($requerimento) && $requerimento) readonly="READONLY" @endif>
                    </div>
                </div>

                <div class="mail-actions">
                    <div class="form-group">
                        <textarea id="tamensagem" name="mensagem" class="form-control">
                        </textarea>
                    </div>
                    <input type="submit" id="enviar" class="btn btn-sm btn-primary" value="Enviar" />
                    @if(Session::get('perfil_ativo')->nome != 'Candidato')
                        <button type="button" id="hidden" class="btn btn-sm btn-danger"> Escolher uma Mensagem Padrão </button>
                    @endif
                </div>
            </form>
        </div>
    </section>

    @if(Session::get('perfil_ativo')->nome != 'Candidato')
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Histórico do usuário</h3>
        </div>
        <div class="panel-body" id="log">

        </div>
    </div>
    @endif
</div>


@if(Session::has('perfil_ativo'))
{? $perfil_ativo = Session::get('perfil_ativo') ?}

    @if($perfil_ativo->nome != 'Candidato')
    <!-- Modal -->
    <div class="modal fade" id="ModalAlerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Mensagens Padrão</h4>
          </div>
          <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                Titulo
                            </th>
                            <th>
                                Mensagem
                            </th>
                            <th>
                                Selecionar
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mensagens_padrao as $mensagem)
                            <tr>
                                <td id="assunto_{{$mensagem->id}}">{{$mensagem->titulo}}</td>
                                <td id="{{$mensagem->id}}">{{$mensagem->mensagem}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary pickhtml" btn_id="{{$mensagem->id}}"><span class="glyphicon glyphicon-ok"></span></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>
    @endif

@endif

@stop

@section('scripts')

<!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="scripts/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    language : 'pt_BR',
 });
</script>

<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript">

    $(document).ready(function()
    {
        @if(Session::has('success') || Session::get('danger') || Session::get('info') || Session::get('warning'))
            $("#ModalAlerta").modal('show');
        @else
            $("#ModalAlerta").modal('hide');
        @endif


        if($("input[name=tipo_filtro]:checked").length)
        {
            togglePara();
        }

        $("input[name=tipo_filtro]").change(function()
        {
            togglePara();
        });

        function togglePara()
        {
            var val = $("input[name=tipo_filtro]:checked").val();
            switch(val)
            {
                case 'single':
                    $("#para_broadcast").hide().find('input, textarea, button, select').attr('disabled','disabled');
                    $("#broadcast_situacoes").hide().find('input, textarea, button, select').attr('disabled','disabled');
                    $("#broadcast_areas").hide().find('input, textarea, button, select').attr('disabled','disabled');
                    $(".broadcast").hide();
                    $("#para_singles").show().find('input, textarea, button, select').removeAttr("disabled");
                break;
                case 'broadcast':
                    $("#para_singles").hide().find('input, textarea, button, select').attr('disabled','disabled');
                    $("#broadcast_situacoes").show().find('input, textarea, button, select').removeAttr('disabled');
                    $("#broadcast_areas").show().find('input, textarea, button, select').removeAttr('disabled');
                    $(".broadcast").show();
                    $("#para_broadcast").show().find('input, textarea, button, select').removeAttr("disabled");
                break;
            }
        }

    });

</script>

<script type="text/javascript">

    $(document).ready(function()
    {
        $("#mail_to").change(function()
        {
            var id = $(this).find(':selected').attr('usuario_id');


            $.get('{{URL::to('mensagem/logg')}}/', { 'id': id }).done(function(data)
            {
                $("#log").html(data);
            });
        });

        $("#hidden").click(function()
        {
            var valor = $('input[type=hidden]').val();
            $("#ModalAlerta").modal('show');

        });

        $(".pickhtml").click(function()
        {
            var id = $(this).attr('btn_id');
            var html = $("#"+id).html();
            var assunto = $("#assunto_"+id).html();

            console.log(html);
            $('input[type=hidden]').val(html);
            $('#mail_subject').val(assunto);
            // $("textarea#tamensagem").html(html);
            tinymce.activeEditor.setContent(html);
            $("#ModalAlerta").modal('hide');
        });

        $('#linha_id').change(function(){
            var nome = $(this).find(':selected').attr("nomearea");
            var prova_id = $("#prova_id").val();
            $('#mail_subject').val('Requerimento de reconsideração - '+nome+ ' - '+ prova_id);
        });

        $('#prova_id').change(function(){
            var nome = $('#linha_id').find(':selected').attr("nomearea");
            var prova_id = $("#prova_id").val();
            $('#mail_subject').val('Requerimento de reconsideração - '+nome+ ' - '+ prova_id);
        });

        if($('#linha_id').val()){
            $( "#linha_id" ).trigger( "change" );
        }

    });

</script>


@stop