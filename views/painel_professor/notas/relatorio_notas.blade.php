@extends('templates.master')

@section('css')
    <style type="text/css">

        .row-centered{
            text-align: center;
        }

        .col-centered {
            float:none;
            margin: 0 auto;
        }

    </style>
@stop

@section('scripts')

    <script type="text/javascript">

        $(document).ready(function()
        {
            
        });

    </script>

@stop

@section('content')

{{ HTML::ul($errors->all()) }}

{? $tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo') ?}

<div class="page ng-scope">

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Relatório de Notas</strong></div>

        <div class="panel-body">

            <div class="row">

                <div class="col-sm-4">

                    <a href="nota/exportar-notas?tipo={{ $tipo }}@if(!empty($area_id))&area={{ $area_id }}@endif" target="blank"><button type="button" class="btn btn-warning exportar"><span class="fa fa-download"></span> Exportar lista de notas</button></a>

                </div>

                <div class="col-sm-8">
                
                    <form action="nota/relatorio-notas" method="GET">

                        <input type="hidden" name="tipo" value="{{ $tipo }}">

                        <!-- <div class="col-sm-12">                            

                            <div class="form-group">

                                <label for="area" class="col-sm-1">Período</label>

                                <div class="col-sm-3">

                                    <span class="ui-select">

                                        <select name="periodo_key" id="periodo_key" style="margin:0;">

                                            <option value="">Período</option>
                                                
                                            @forelse($periodos as $p)

                                                <option value="{{ $p->id }}">{{ $p->ano }} / {{ $p->periodo }}</option>

                                            @endforeach

                                        </select>

                                    </span>

                                </div>

                                <label for="area" class="col-sm-1">Área</label>

                                <div class="col-sm-3">

                                    <span class="ui-select">

                                        <select name="area" id="area" style="margin:0;">

                                            <option value="">Área</option>

                                            @if(isset($areas_usuario) && !$areas_usuario->isEmpty())
                                                
                                                @foreach($areas_usuario as $area)

                                                    <option value="{{ $area->id }}">{{ $area->nome }}</option>

                                                @endforeach

                                            @endif

                                        </select>

                                    </span>

                                </div>

                                <div class="col-sm-4">

                                    <button type="submit" class="btn btn-warning">buscar</button>

                                </div>                                

                            </div>

                        </div> -->
                        <div class="form-group pull-right">
                            <label>Período</label>&nbsp;
                            
                            <span class="ui-select">
                                <select name="periodo_key" id="periodo_key" style="margin:0;">
                                    <option value="">Período</option>
                                    @forelse($periodos as $p)
                                        <option value="{{ $p->id }}">{{ $p->ano }} / {{ $p->periodo }}</option>
                                    @endforeach
                                </select>
                            </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <label>Área</label>&nbsp;
                            
                            <span class="ui-select">
                                <select name="area" id="area" style="margin:0;">
                                    <option value="">Área</option>
                                    @if(isset($areas_usuario) && !$areas_usuario->isEmpty())
                                        @foreach($areas_usuario as $area)
                                            <option value="{{ $area->id }}">{{ $area->nome }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <button type="submit" class="btn btn-warning">buscar</button>
                        </div>

                    </form>

                </div>                

            </div>

            <div class="row">

                <div class="col-sm-12">

                <p>&nbsp;</p>

                @if($tipo == 'm')

                <div class="table-responsive">

                    <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="2">{{ $periodo->ano }}/{{ $periodo->periodo }} - Mestrado</td>
                        </tr>               
                        @if(isset($areas_mestrado) && !$areas_mestrado->isEmpty())

                            @foreach($areas_mestrado as $area_mestrado)
                                
                                <tr>
                                    <td colspan="2" style="border-bottom: 3px solid #EAEAEA !important"><h4><strong>{{ $area_mestrado->nome }}<strong></h4><br/></td>                                
                                </tr>                                 

                                <tr>
                                    <td>Candidato</td>
                                    <td>Provas</td>
                                </tr>                                

                                @if(!$area_mestrado->inscricoes->isEmpty())

                                    @foreach($area_mestrado->inscricoes as $inscricao)

                                        @if($inscricao->provas_mestrado != null && !$inscricao->provas_mestrado->isEmpty())
                                            <tr>
                                                <td>{{ $inscricao->usuario->nome }}</td>

                                                <td>
                                                    <table class="table table-striped table-bordered">
                                                    <tr>
                                                        
                                                        <th>Tipo de Prova</th>
                                                        <th>Nota</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    @foreach($inscricao->provas_mestrado as $prova_mestrado)                                                        
                                                        @if($prova_mestrado->area_id == $area_mestrado->id)                                                
                                                            <tr>
                                                                
                                                                <td>{{ $prova_mestrado->prova->nome }}</td>
                                                                <td>{{ @number_format($prova_mestrado->pivot->nota, 2, ',', '.') }} </td>
                                                                <td>{{ $prova_mestrado->pivot->status }}</td>
                                                            </tr>
                                                        @endif

                                                    @endforeach                                                    
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach

                                @endif 

                            @endforeach

                        @else
                            <tr>
                                <td>Sem resultados!</td>
                            </tr>
                        @endif
                    
                    </table>

                </div>

                @endif

                <p>&nbsp;</p>                

                @if($tipo == 'd')

                <div class="table-responsive">

                    <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="2">{{ $periodo->ano }}/{{ $periodo->periodo }} - Doutorado</td>
                        </tr>              
                        @if(isset($areas_doutorado) && !$areas_doutorado->isEmpty())

                            @foreach($areas_doutorado as $area_doutorado)
                                
                                <tr>
                                    <td colspan="2" style="border-bottom: 3px solid #EAEAEA !important"><h4><strong>{{ $area_doutorado->nome }}</strong></h4></td>
                                </tr>
                                
                                @if(!$area_doutorado->inscricoes->isEmpty())                                   

                                    @foreach($area_doutorado->inscricoes as $inscricao)

                                        {? $show = true; ?}

                                        @if($inscricao->provas_doutorado != null && !$inscricao->provas_doutorado->isEmpty())
                                            <tr>
                                                <td>{{ $inscricao->usuario->nome }}</td>

                                                <td>
                                                    <table class="table table-striped table-bordered">
                                                    <tr>
                                                        
                                                        <th>Tipo de Prova</th>
                                                        <th>Nota</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    @foreach($inscricao->provas_doutorado as $provas_doutorado)
                                                      
                                                        @if($provas_doutorado->area_id == $area_doutorado->id)                                                                                                      
                                                      
                                                            <tr>                                                                
                                                                <td>{{ $provas_doutorado->prova->nome }}</td>
                                                                <td>{{ @number_format($provas_doutorado->pivot->nota, 2, ',', '.') }} </td>
                                                                <td>{{ $provas_doutorado->pivot->status }}</td>
                                                            </tr>
                                                        @endif

                                                    @endforeach                                                    
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif

                                    @endforeach

                                @endif

                            @endforeach

                        @else
                            <tr>
                                <td>Sem áreas contendo vagas para o período ativo!</td>
                            </tr>
                        @endif
                    
                    </table>

                </div>

                @endif
                
                </div>

            </div>

        </div>

    </section>

</div>
@stop