@extends('templates.login')
@section('content')
<div class="page-signup" style="margin-top: 50px;">

    <div class="signin-header">
        <div class="container text-center">
            <section class="logo">
                <a href="/">UFRJ</a>
            </section>
        </div>
    </div>

    <div class="signup-body">

        <div class="container">
            <div class="form-container">

                @include('elements.alerts')

                <section>
                    <form class="form-horizontal" action="{{URL::to("id/sign-up")}}" method="POST">
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                </span>
                                <input  type="text"
                                        name="nome"
                                        class="form-control"
                                        placeholder="Nome"
                                        value="{{ Input::old('nome') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="Email"
                                       value="{{ Input::old('email') }}">
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
<!--                             <p class="text-muted text-small">By clicking on Sign up, you agree to <a href="javascript:;">terms & conditions</a> and <a href="javascript:;">privacy policy</a></p>
 -->                            <div class="divider"></div>
                            <button type="submit"
                                    class="btn btn-primary btn-block btn-lg">Registrar</button>
                        </div>
 
                    </form>
                </section>

                <section>
                    <p class="text-center text-muted">Ja é registrado? <a href="{{URL::to('id/sign-in')}}" >Faça Login</a></p>
                </section>

            </div>
        </div>
    </div>
</div>
@stop