@extends('templates.master')



@section('scripts')



<script type="text/javascript">

function resetForm()

{

    document.getElementById("filtro").reset();

}

</script>



@stop



@section('content')



@include('elements.alerts')



<form id="filtro" method="GET" action="{{URL::to('adm/periodo')}}" accept-charset="UTF-8" class="form-inline ng-pristine ng-valid" role="form">

    <div class="btn-toolbar" role="toolbar">

        <div class="pull-left">

            <h2></h2>

        </div>

    </div>

    <br>

    <div class="form-group">

        <label for="ano" class="sr-only">Ano</label>

        <span id="div_ano">

        <input class="form-control" placeholder="Ano" type="text" id="ano" name="ano" value="{{Input::get('ano')}}">

        </span>

    </div>

    <div class="form-group">

        <label for="periodo" class="sr-only">Periodo</label>

        <span id="div_periodo">

        <input class="form-control autocompleter" placeholder="Periodo" type="text" id="periodo" name="periodo" value="{{Input::get('periodo')}}">

        </span>

    </div>

    <input class="btn btn-primary" type="submit" value="Filtrar">

    <!--button type="reset" class="btn btn-default" onClick="resetForm();">Limpar Filtros</button-->

    <input type="hidden" name="_search" value="1" />

</form>



<div class="btn-toolbar" role="toolbar">



    <div class="pull-left">

    <h2></h2>

</div>

            <div class="pull-right">

     <a href="/adm/periodo/create" class="btn btn-default">Novo Periodo</a>

        </div>

</div>



<br />



<table class="table">

    <thead>

        <tr>

            <th style="width:100px">

                <a href="{{URL::to('adm/periodo',array('ord1' => 'ano'))}}">

                <span class="glyphicon glyphicon-arrow-up"></span>

                </a>

                <a href="{{URL::to('adm/periodo', array('ord1' => '-ano'))}}">

                <span class="glyphicon glyphicon-arrow-down"></span>

                </a>

                Ano

            </th>

            <th>

                <a href="{{URL::to('adm/periodo', array('ord1' => 'periodo'))}}">

                <span class="glyphicon glyphicon-arrow-up"></span>

                </a>

                <a href="{{URL::to('adm/periodo', array('ord1' => '-periodo'))}}">

                <span class="glyphicon glyphicon-arrow-down"></span>

                </a>

                Periodo

            </th>

            <th>

                Status

            </th>

            <th>

                Data de Início

            </th>

            <th>

                Data do Fim

            </th>

            <th>

                Editar

            </th>

        </tr>

    </thead>

    <tbody>

        @foreach($periodos as $periodo)

        <tr>

            <td>{{$periodo->ano}}</td>

            <td>{{$periodo->periodo}}</td>

            <td>{{$periodo->status}}</td>

            <td>{{$periodo->data_hora_inicio}}</td>

            <td>{{$periodo->data_hora_fim}}</td>

            <td><!--a class="" title="Exibir" href="/adm/periodo/{{$periodo->id}}"><span class="glyphicon glyphicon-eye-open"> </span></a-->

                <a class="" href="{{URL::to("adm/periodo/{$periodo->id}/edit")}}" tooltip-placement="top" tooltip="Editar"><span class="glyphicon glyphicon-edit"> </span></a>&nbsp;&nbsp;&nbsp;
                <a class="" href="{{URL::to('adm/periodo/clonar', array('periodo_id' => $periodo->id))}}" tooltip-placement="top" tooltip="Clonar Período"><span class="glyphicon glyphicon-share"> </span></a>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>
<script type="text/javascript">
    $(function() { 
        $("#title_text").html("Lista de Períodos");
    });
</script>


{{$periodos->links()}}

@stop