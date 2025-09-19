@extends('templates.login')

@section('css')

@stop

@section('scripts')

@stop

@section('content')

<div class="page-signin" style="margin-top: 50px;">



    <div class="signin-header">

        <div class="container text-center">

            <section class="logo">

                <a href="{{URL::to('/')}}">UFRJ</a>

            </section>

        </div>

    </div>



    <div class="signin-body">

        <div class="container">

            <div class="form-container">

                 @include('elements.alerts')

                <form class="form-horizontal" method="POST" action="{{URL::to('id/perfil')}}">

                    <fieldset>

                        <div class="form-group">
                        <label>Selecione um perfil</label>
                            <div class="input-group input-group-lg">

                                <span class="input-group-addon">

                                    <span class="glyphicon glyphicon-user"></span>

                                </span>

                                <select name="perfil" class="form-control">
                                    @foreach($perfis as $perfil)
                                        <option value="{{$perfil->id}}"> {{$perfil->nome}} </option>
                                    @endforeach
                                </select>

                            </div>

                        </div>


                        <div class="form-group">

                        </div>

                        <div class="form-group">

                            <button type="submit" class="btn btn-primary btn-lg btn-block" >Entrar com Perfil selecionado</button>

                        </div>

                    </fieldset>

                </form>

            </div>

        </div>

    </div>



</div>

@stop