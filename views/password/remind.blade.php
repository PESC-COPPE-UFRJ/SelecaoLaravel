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

                <form class="form-horizontal" method="POST" action="{{ action('RemindersController@postRemind') }}">

                    <fieldset>

                    	<h1 class="text-center">Lembrar Senha</h1>

                        <div class="form-group">

                            <div class="input-group input-group-lg">

                                <span class="input-group-addon">

                                    <span class="glyphicon glyphicon-envelope"></span>

                                </span>

                                <input name="email"

                                       type="email"

                                       class="form-control"

                                       placeholder="Email cadastrado"

                                       REQUIRED
                                       >

                            </div>

                        </div>

                        <div class="form-group">

                            <button type="submit" class="btn btn-primary btn-lg btn-block" >Lembrar</button>

                        </div>

                    </fieldset>

                </form>           

            </div>

        </div>

    </div>

</div>

@stop