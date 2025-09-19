<?php

class MensagemHistoricoController extends \BaseController 
{
	public function getIndex()
	{
		return View::make('mensagens.log');
	}

	public function getMensagensRecebidas($id)
	{
		return Mensagem::with('remetente', 'destinatario')->Where('id_destinatario', $id)->orderBy('created_at', 'DESC')->get();
	}

	public function getMensagensEnviadas($id)
	{
		return Mensagem::with('destinatario', 'remetente')->Where('id_remetente', $id)->orderBy('created_at', 'DESC')->get();
	}

	public function getUsuarios()
	{
		$remetentes =  Mensagem::distinct()->select('id_remetente')->get()->toArray();

		$destinatarios = Mensagem::distinct()->select('id_destinatario')->get()->toArray();

		$remetentes_id = [];
		foreach($remetentes as $r)
		{
			$remetentes_id[$r['id_remetente']] = $r['id_remetente']; 
		}

		$destinatarios_id = [];
		foreach($destinatarios as $r)
		{
			$destinatarios_id[$r['id_destinatario']] = $r['id_destinatario']; 
		}

		$usuarios_id = array_values(array_unique(array_merge($remetentes_id, $destinatarios_id), SORT_REGULAR));

		return Usuario::whereIn('id', $usuarios_id)->select('id', 'nome', 'email', 'foto')->get();
	}

	public function getMensagensTrocadas($id_remetente, $id_destinatario)
	{
		$mensagens = Mensagem::with('remetente', 'destinatario')->Where('id_remetente', $id_remetente)->where('id_destinatario', $id_destinatario)->orderBy('created_at', 'DESC')->get();

		$mensagens2 = Mensagem::with('remetente', 'destinatario')->Where('id_remetente', $id_destinatario)->where('id_destinatario', $id_remetente)->orderBy('created_at', 'DESC')->get();

		if(!$mensagens && !$mensagens2)
		{
			return Response::json(['error' => 'Não existem mensagens trocadas entre estes usuários']);
		}

		$mensagens = $mensagens->merge($mensagens2);

		return Response::json($mensagens);
	}

}