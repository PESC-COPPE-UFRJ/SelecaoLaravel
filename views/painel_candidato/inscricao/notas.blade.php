@extends('templates.master')

@section('content')
<div class="page">

    <div class="panel panel-profile panel-profile-timeline">
        <div class="panel-heading clearfix">
            <h3>Notas do Candidato</h3>
        </div>
    </div>

    @include('elements.alerts')

   <section class="panel panel-default">
    
            @foreach($notas as $notas_insc) 
       
            <div class="row">
                <div class="col-sm-6">
                    <div class="table-responsive">                                                                                                
                        
                        
                        <table class="table table-striped table-bordered">
                        <tr>
                            <td colspan="2" style="border-bottom: 3px solid #EAEAEA !important"><h4><strong>
                              Período : {{ $notas_insc->periodo->ano }} / {{ $notas_insc->periodo->periodo }}
                             </strong></h4></td>
                        </tr>                            
                            
                        <tr>
                            <th>Área</th>
                            <th>Tipo de Prova</th>
                            <th>Nota</th>
                            <th>Status</th>
                        </tr>                                   
                                                     
                        @foreach($notas_insc->provas as $prova)                            
                            <tr>
                                <td>{{ $prova->area->nome }}</td>
                                <td>{{ $prova->prova->nome }}</td>
                                @if ( $prova['publicado'] == 1  )
                                    <td> {{ @number_format($prova->pivot->nota,2,",",".") }} </td>
                                    <td>{{ $prova->pivot->status }}</td>
                                @else
                                    <td>Não disponível</td>
                                    <td></td>
                                @endif                                                                
                                <!--td>{{ $prova->pivot->status }}</td-->
                            </tr>

                        @endforeach                                                    
                        </table>
                    </div>
                </div>
            </div>
            @endforeach  
    </section> 
    
</div>
@stop