
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Impressão Capas</title>

<style>

   body {
        margin: 0;
        padding: 0;
        background-color: #FFF;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #FFF solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .subpage {
        padding: 1cm;
        border: 5px #FFF solid;
        height: 256mm;
        outline: 2cm #FFF solid;
		
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }

</style>


</head>

<body>

		@if($linha->inscricoes != null && !$linha->inscricoes->isEmpty())

			@foreach($linha->inscricoes as $inscricao)

					@if($curso == $inscricao->curso)			
						<div class="book">
						  <div class="page">
						        <div class="subpage">

						        <img src="{{ asset('images/logo_pesc.jpg') }}" alt="PESC" title="PESC" border="0"/><br/>
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

							
						        </div>    
						    </div>
						</div>				
				@endif

			@endforeach

		@endif

</body>
</html>