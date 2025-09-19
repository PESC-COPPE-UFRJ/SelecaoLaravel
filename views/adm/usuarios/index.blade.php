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

<form id="filtro" method="GET" action="{{URL::to('adm/usuario')}}" accept-charset="UTF-8" class="form-inline ng-pristine ng-valid" role="form">
    <div class="btn-toolbar" role="toolbar">
        <div class="pull-left">
            <h2></h2>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="ano" class="sr-only">Nome</label>
        <span id="div_ano">
        <input class="form-control" placeholder="Nome" type="text" id="nome" name="nome" value="{{Input::get('nome')}}">
        </span>
    </div>
    <div class="form-group">
        <label for="usuario" class="sr-only">E-mail</label>
        <span id="div_usuario">
        <input class="form-control autocompleter" placeholder="E-mail" type="text" id="email" name="email" value="{{Input::get('email')}}">
        </span>
    </div>
    <div class="form-group">
        <label for="usuario" class="sr-only">Status</label>
        <span id="div_usuario">
        <select name="status" class="form-control">
            <option value="">Status</option>
            <option value="0">Inativo</option>
            <option value="1">Ativo</option>
        </select>
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
<!--         <div class="pull-right">
        <a href="adm/usuario/create" class="btn btn-default">Novo Usuário</a>
        </div> -->
</div>

<br />

<table class="table">
    <thead>
        <tr>
            <th>
                <a href="adm/usuario?ord1=usuario">
                <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a href="adm/usuario?ord1=-usuario">
                <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
                nome
            </th>
            <th> ID </th>
            <th>
                E-mail
            </th>
            <th>
                Perfis
            </th>
            <th>
                Status
            </th>
            <th>
                Ações
            </th>
        </tr>
    </thead>
    <tbody>
    	@foreach($usuarios as $usuario)
        <tr>
            <td>{{$usuario->nome}}</td>
           <td>{{$usuario->id}}</td>
            <td>{{$usuario->email}}</td>
            <td>@if(!empty($usuario->perfis)) {{$usuario->perfis}} @else - @endif</td>
            <td> {{$usuario->situacao}} </td>
            <td><!-- <a class="" title="Exibir" href="/adm/usuario/{{$usuario->id}}"><span class="glyphicon glyphicon-eye-open"> </span></a> -->
                <a class="" title="Modificar" href="/adm/usuario/{{$usuario->id}}/edit"><span class="glyphicon glyphicon-edit"> </span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{$usuarios->appends(array('nome' => Input::get('nome'),'email' => Input::get('email')))->links()}}
@stop