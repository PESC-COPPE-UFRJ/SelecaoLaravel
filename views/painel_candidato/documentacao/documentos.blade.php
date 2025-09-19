@extends('templates.master')

@section('css')
    
@stop

@section('scripts')

	<script type="text/javascript">

		$(document).ready(function() {

            $('#enviar_identidade').click(function(){
                $('#identidade').click();
            });

		});


	</script>

@stop

@section('content')

@include('elements.alerts')

{{ HTML::ul($errors->all()) }}

<div class="page ng-scope">

<!-- <form id="frmDocumentos"
      class="form-horizontal ng-pristine ng-valid" 
      role="form" 
      method="POST" 
      action="candidato/documentacao" 
      enctype="multipart/form-data"> -->

    <section class="panel panel-default">

        <div class="panel-heading"><strong><span class="glyphicon glyphicon-th"></span> Documentação</strong></div>

        <div class="panel-body">


        	<div class="row">

        		<div class="col-sm-4">
        			
        			Área de upload de documentos do candidato.

        		</div>

        	</div>

<!--             <p>&nbsp;</p>
            <p>&nbsp;</p> -->

        	<div class="row">

        		<div class="col-sm-6">
                    {{ $form }}
        		</div>

        	</div>

<!--        
            <div class="row">
                <div class="col-sm-5">
                    <button type="submit" id="salvar" class="btn btn-primary pull-right">Salvar</button>                    
                </div>
            </div> -->

        </div>

    </section>



<!-- </form> -->

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Titulo Padrão</h4>
			</div>
			<div class="modal-body">
				Conteúdo padrão
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

@stop