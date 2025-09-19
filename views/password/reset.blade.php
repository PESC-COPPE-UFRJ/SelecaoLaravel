@extends('templates.login')

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

                <form class="form-horizontal" method="POST" action="{{ action('RemindersController@postReset') }}">

                    <fieldset>

                        <input type="hidden" name="token" value="{{ $token }}">

                    	<h1 class="text-center">Redefinir Senha</h1>

                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email"
                                       name="email"
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
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Senha"
                                       >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-lock"></span>
                                </span>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirmar Senha"
                                       >
                            </div>
                        </div>

                        <div class="form-group">

                            <button type="submit" class="btn btn-primary btn-lg btn-block" >Redefinir senha</button>

                        </div>

                    </fieldset>

                </form>

            </div>

        </div>

    </div>

</div>
@stop