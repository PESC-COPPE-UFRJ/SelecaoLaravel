@extends('templates.master')
@section('scripts')
<script type="text/javascript">
$( document ).ready(function() 
{
    var page = 0;

    $("a[id=nav_form]").click(function(event)
    {
        event.preventDefault();

        var action = $(this).attr( "href" );

        if(action == '#next')
        {
            if(page <1)
            {
                page++;
            }
        }
        else
        {
            if(page > 0)
            {
                page--;
            }
        }

        if(page > 0)
        {
            $("li[id=previous]").attr('class', '');
        }
        else
        {
            $("li[id=previous]").attr('class', 'disabled');
        }

        if(page < 1)
        {
            $("li[id=next]").attr('class', '');
            $("li[id=nav_finish]").attr('style', 'display: none;')
        }
        else
        {
            $("li[id=next]").attr('class', 'disabled');
            $("li[id=nav_finish]").show('fast');
        }

        $("#step0, #step1").hide();
        $("#step"+page).show();

        $("#step0_tab, #step1_tab").attr('class', 'done');
        $("#step"+page+"_tab").attr('class', 'current');

    });
    

    $("td button").click(function(event) 
    {
        event.preventDefault();
        var id = $(this).attr('id');
        
        // alert("tr#"+id);
         $("."+id).toggle('fast');

         var span = $(this).find('span');

         var spanclass = $(span).attr('class');

         if(spanclass == 'glyphicon glyphicon-arrow-up')
         {
            $(span).attr('class', 'glyphicon glyphicon-arrow-down');
         }
         else
         {
            $(span).attr('class', 'glyphicon glyphicon-arrow-up');
         }

         
    });

    $(".parent").click(function()
    {
        var id = $(this).attr('id');

        if($(this).is(':checked'))
        {
            $('.child').each(function()
            {
                if($(this).attr('id') == id)
                {
                    $(this).prop('checked', true);
                }
            });
        }
        else
        {
            $('.child').each(function()
            {
                if($(this).attr('id') == id)
                {
                    $(this).prop('checked', false);
                }
            });
        }

    });

});
</script>
@stop

@section('content')
<div class="page ng-scope">

<form class="form-horizontal ng-pristine ng-valid" role="form" method="POST" action="{{URL::to("adm/perfil")}}">

    @include('elements.alerts')

    <section class="panel panel-default">
        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Novo Perfil</strong></div>
        <div class="panel-body">
            <div class="wizard clearfix" id="steps-uid-0"><div class="steps clearfix"><ul><li id="step0_tab" role="tab" class="first current"><a id="steps-uid-0-t-0"><span class="current-info audible">current step: </span><span class="number">1.</span> Nome do perfil</a></li><li id="step1_tab" role="tab" class="done"><a id="steps-uid-0-t-1"><span class="number">2.</span> Controle de Acesso</a></li></ul></div><div class="content clearfix">
               
                <h1 id="step0_h1" tabindex="-1" class="title current">1. Nome do Perfil</h1>
                <div id="step0" class="current" style="display: block;">
                    
                    <section class="panel panel-default">

                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Nome do Perfil</strong></div>
                        <div class="panel-body">

                        <h4>Você esta criando um novo perfil de acesso ao sistema. Qual o nome do perfil?</h4>
                        <input type="text" name="Nome" class="form-control" placeholder="Ex: Diretor1, Gerente1, Assistente2">

                        </div>

                    </section>

                </div>

                <h1 id="step1_h1" tabindex="-1" class="title">3. Definição do Perfil</h1>
                <div id="step1" class="current" aria-hidden="true" style="display: none;">

                    <div class="page page-table">

                    <div class="panel panel-default">

                        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> 

                            Controle de Acessos

                         </strong>

                        </div>         
                            @if($menus->count() > 0)
                                <table class="table table-striped table-hover">

                                    <thead>

                                        <tr>

                                            <th>Modulo</th>

                                            <th>Atividade</th>

                                            <th>#</th>

                                            <th>#</th>

                                        </tr>

                                    </thead>

                                    <tbody>



                                    @foreach ($menus as $menu)


                                        <tr class="info">

                                            <td><button id="{{$menu->id}}" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-down" data-toggle="tooltip" data-placement="right" title="Clique para expandir"></span> {{$menu->nome}}</button></td>

                                            

                                            <td></td>



                                            <td><input id="{{$menu->id}}" class="parent" type="checkbox" name="menus[]" value="{{$menu->id}}"></td>

                                            <td></td>


                                        </tr>

                                        @foreach($menu->submenus as $submenu)

                                        <tr class="{{$menu->id}}" style="display: none;">
                                            <td></td>
                                            <td>{{$submenu->nome}}</td>
                                            <td></td>
                                            <td><input id="{{$menu->id}}" class="child" type="checkbox" name="menus[]" value="{{$submenu->id}}"></td>
                                        </tr>

                                        @endforeach

                                    @endforeach



                                 </tbody>

                                </table>

                                



                            @else

                            <div class="alert alert-info">

                                <p> Nenhum registro encontrado. </p>

                            </div>

                        @endif


                    </div>



                </div>

                </div>

 
            </div><div class="actions clearfix"><ul role="menu"><li id="previous" class="disabled"><a id="nav_form" href="#previous">Voltar</a></li><li id="next" style="display: block;"><a id="nav_form" href="#next">Avançar</a></li><li id="nav_finish" style="display: none;"><button type="submit" class="btn btn-primary">Salvar</button></li></ul></div></div> 

        </div>
    </section>

</form>

</div>
@stop