<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ $title }}</h2>

		<p> {{ $sender }}</p>

		<p> Mensagem: {{ $msg }}</p>

		<p> Por favor, <a href="{{ $link }}">clique aqui</a> ou acesse o sistema da UFRJ para responder a está mensagem.</p>

		<p> Caso o link não funcione, cole esta URL no seu navegador: {{ $link }}</p>
	</body>
</html>
