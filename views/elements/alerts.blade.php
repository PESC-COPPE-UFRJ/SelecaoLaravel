@if (Session::get('success'))
<?php
$successes = Session::get('success');
?>
<div class="alert alert-success">
	<a class="close" data-dismiss="alert">×</a>
	<h4 class="alert-heading"> Sucesso! </h4>
	<ul>
		@foreach($successes as $sucesso)
			<li>{{$sucesso}}</li>
		@endforeach
	</ul>
</div>
@endif
@if (Session::get('info'))
<?php
$infos = Session::get('info');
?>
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<h4 class="alert-heading"> Informações: </h4>
	<ul>
		@foreach($infos as $info)
			<li>{{$info}}</li>
		@endforeach
	</ul>
</div>
@endif
@if (Session::get('warning'))
<?php
$warnings = Session::get('warning');
?>
<div class="alert alert-warning">
	<a class="close" data-dismiss="alert">×</a>
	<h4 class="alert-heading"> Atenção! </h4>
	<ul>
		@foreach($warnings as $warning)
			<li>{{$warning}}</li>
		@endforeach
	</ul>
</div>
@endif
@if (Session::get('danger'))
<?php
$dangers = Session::get('danger');
?>
<div class="alert alert-danger">
	<a class="close" data-dismiss="alert">×</a>
	<h4 class="alert-heading"> Os seguintes erros foram encontrados: </h4>
	<ul>
		@foreach($dangers as $danger)
			@if (is_array($danger))
				
					@foreach ($danger as $msg)				
						<li>{{$msg}}</li>
					@endforeach
				
			@else
				<li>{{$danger}}</li>
			@endif
			
		@endforeach
	</ul>
</div>
@endif