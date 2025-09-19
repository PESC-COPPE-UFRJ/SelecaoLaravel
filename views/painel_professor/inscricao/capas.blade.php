@if($linha->inscricoes != null && !$linha->inscricoes->isEmpty())		

	

		<div class="row">
			<div class="col-sm-6">			
 				<a href="professor/inscricao/imprimir-capas?linha={{ $linha->id }}&capa={{ $capa }}&curso={{ $curso }}" target="_blank">
					<button class="btn btn-warning"><span class="glyphicon glyphicon-print"></span></button>
				</a>
			</div>
		</div>

	

@endif

<br/>
<div class="row">
	<div class="col-sm-6 text-center">
		@if($linha->inscricoes != null && !$linha->inscricoes->isEmpty())
			@foreach($linha->inscricoes as $inscricao)
				@if($curso == $inscricao->curso)
					@if($capa == 1)
						Normal
					@else
						Livreto
					@endif <br/>
				
					@if($inscricao->curso == 'DSC')
						Doutorado
					@else
						Mestrado
					@endif
					<br/>				
					{{ $linha->nome }}<br/>
					Prova: {{ $inscricao->idprova}} <br/>
				    {? $foto = $inscricao->usuario->foto != '' ? $inscricao->usuario->foto : 'images/assets/no-photo.png'; ?}
	                <img src="{{ $foto }}" alt="" style="width: 100px;height: 100px;"><br/>				
					{{ $inscricao->usuario->nome }}<br/>
					{{ $inscricao->usuario->email }}<br/>	
					{{ $inscricao->usuario->getCPFFormatado() }}<br/>
					{{ $inscricao->usuario->telefone }}<br/>
				@endif
			@endforeach
		@else
			Não há capas disponíveis para esta 
		@endif
	</div>
</div>
