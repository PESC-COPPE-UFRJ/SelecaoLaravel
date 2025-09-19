@extends('templates.master')
@section('content')

<div class="page page-table">

    <div style="text-align: right; margin-bottom: 15px;"> <a href="{{URL::to("adm/perfil/create")}}"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Novo Perfil</button></a> </div>

    <div class="panel panel-default">

        @include('elements.alerts')

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> 

            Gerênciar Perfis

         </strong>

        </div>



            @if (isset($perfis))

                @if(!empty($perfis) && count($perfis) > 0)



                    {{ Form::open(array('url' => 'user/destroy')) }}

                    <table class="table table-striped table-hover">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th>Perfil</th>

                                <th>Ações</th>

                            </tr>

                        </thead>

                        <tbody>



                        @foreach ($perfis as $perfil)



                            <?php

                            $status = ($perfil->fgAtivo == 'S') ? 'Ativo' : 'Inativo';

                            $status_class = ($perfil->fgAtivo == 'S') ? 'label-success' : 'label-danger';

                            ?>

                            <tr>

                                <td>{{$perfil->id}}</td>

                                <td>{{$perfil->nome}}</td>                                
 
                                <td>

                                    <a href="{{URL::to("adm/perfil/$perfil->id/edit")}}"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-edit"></span> Editar</button></a>

                                    {{-- Form::open(array('url' => 'adm/perfil/' . $perfil->id)) --}}

                                        {{-- Form::hidden('_method', 'DELETE') --}}

                                        {{-- Form::submit('Deletar', array('class' => 'btn btn-w-md btn-gap-v btn-line-danger')) --}}

                                    {{-- Form::close() --}}

                                </td>

                            </tr>

                        @endforeach



                     </tbody>

                    </table>

                    

<!--                         <button type="submit" class="btn btn-danger" href="#">

                            <i class="fa fa-trash-o fa-lg"></i> Deletar Selecionados 

                        </button> -->



                        {{-- Form::submit('Deletar Selecionados', array('class' => 'btn btn-w-md btn-gap-v btn-danger')) --}}

                    {{ Form::close() }}



                @else

                <div class="alert alert-info">

                    <p> Nenhum registro encontrado. </p>

                </div>

            @endif

        @endif

                    

        {{$perfis->links()}}

    </div>



</div>
@stop