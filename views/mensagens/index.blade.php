@extends('templates.master')

@section('content')

<form action="{{URL::to('mensagem/status')}}" method="POST">

<div class="row">

    @if(!isset($requerimento) || $requerimento != 1)
    <div class="panel-heading col-sm-2">
        <a href="{{URL::to('mensagem/create')}}" class="btn btn-block btn-lg btn-primary">Nova Mensagem</a>
    </div>
    @elseif(Session::has('perfil') &&  Session::get('perfil') == 2)
        <div class="panel-heading col-sm-3">
            <a href="{{URL::to('mensagem/request')}}" class="btn btn-block btn-lg btn-primary">Novo Requerimento de Reconsideração</a>
        </div>
    @endif

    @if(Session::has('perfil') &&  Session::get('perfil') == 1)
    <div class="panel-heading col-sm-7 pull-right text-right">
        Salvar selecionados como 
        {{Form::select('status', $status_input)}}

        <button type="submit" class="btn btn-success"> Salvar </button>
    </div>
    @endif
</div>

@include('elements.alerts')

<div class="row ng-scope">

    <div class="col-sm-12">
    <section class="panel panel-default mail-container" data-ng-controller="Mensagem.ListController as list">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> {{$titulo}} </strong></div>
        <div class="mail-options">
            <!--label class="ui-checkbox"><input name="checkbox1" type="checkbox" value="option1"><span>Toggle All</span></label-->
        </div>
        <table class="table table-hover">
            <tbody>

            @if(!$mensagens->isEmpty())
                @foreach($mensagens as $msg)
                <tr id="{{$msg->id}}" class="@if(!$msg->lido && $msg->destinatario->id == Auth::user()->id) mail-unread  @endif">
                    <!--td><label class="ui-checkbox"><input name="checkbox1" type="checkbox" value="option1"><span></span></label></td-->
                    @if(Session::has('perfil') &&  Session::get('perfil') == 1)
                    <td><input type="checkbox" name="mensagens[]" value="{{$msg->id}}" /></td>
                    @endif
                    <td class="msglink">@if($titulo == "Mensagens Enviadas") {{$msg->destinatario->nome}} @else {{$msg->remetente->nome}} @endif</i></td>
                    <td class="msglink">{{$msg->assunto}}</td>
                    <td class="msglink"></td>
                    <td class="msglink">{{Formatter::getDataHoraFormatada($msg->created_at)}}</td>
                    <td class="msglink"></td>
                    <td class="msglink">{{$msg->status->nome or ''}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <!--td></td-->
                    <td>Caixa de mensagens vazia.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endif

            </tbody>
        </table>
        {{$mensagens->links()}}
    </section>
    </div>

</div>

</form>
@stop

@section('scripts')

<script type="text/javascript">

    $(document).ready(function()
    {
        @if(!$mensagens->isEmpty())
            $(".msglink").click(function()
            {
                var id = $(this).parent().attr('id');

                window.location = '{{URL::to("mensagem/show/")}}/' + id;
            });
        @endif
    });

</script>

@stop