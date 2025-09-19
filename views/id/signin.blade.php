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

                <form class="form-horizontal" method="POST" action="{{URL::to('id/sign-in')}}">

                    <fieldset>

                        <div class="form-group">

                            <div class="input-group input-group-lg">

                                <span class="input-group-addon">

                                    <span class="glyphicon glyphicon-envelope"></span>

                                </span>

                                <input name="email"

                                       type="email"

                                       class="form-control"

                                       placeholder="Email"

                                       >

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="input-group input-group-lg">

                                <span class="input-group-addon">

                                    <span class="glyphicon glyphicon-lock"></span>

                                </span>

                                <input name="password"

                                       type="password"

                                       class="form-control"

                                       placeholder="Senha"

                                       >

                            </div>

                        </div>

                        <div class="form-group">

                        </div>

                        <div class="form-group">

                            <button type="submit" class="btn btn-primary btn-lg btn-block" >Log In</button>

                        </div>

                    </fieldset>

                </form>



                <section>

                    <p class="text-center"><a href="{{ URL::to('password/remind') }}">Esqueceu sua senha?</a></p>

                    <p class="text-center text-muted text-small">Ainda não possui uma conta? <a href="{{URL::to('id/sign-up')}}">Registrar</a></p>

                </section>

                

            </div>

        </div>

    </div>



</div>

@stop