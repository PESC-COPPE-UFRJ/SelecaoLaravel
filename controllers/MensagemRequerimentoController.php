<?php

class MensagemRequerimentoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /mensagem
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		if(Session::has('perfil') && Session::get('perfil') == 1){
			$userSelecao = Usuario::where('email','=','selecao@cos.ufrj.br')->get()->last();
			$mensagens = Mensagem::where('id_destinatario', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->orWhere('id_destinatario','=', $userSelecao->id)->with('remetente', 'destinatario')->paginate(10);
		} else {
			$mensagens = Mensagem::where('id_destinatario', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->with('remetente', 'destinatario')->paginate(10);
		}


		$titulo = 'Mensagens Recebidas';

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('titulo', $titulo);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /mensagem/create
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$periodo_atual = Whelper::ChecaPeriodo();

		//Pega areas do operador
		if(Session::has('perfil') && Session::get('perfil') == 1) {
            $user_areas = Area::get();
        } else {
            $user_areas = Auth::user()->areas;
        }
		$areas = array();
		foreach($user_areas as $area)
		{
			$areas[] = $area->id;
		}

		$mensagens_padrao = MensagemPadrao::all();
		$professores = array();
		$inscricoes = array();
		//Pega usuários que são da mesma área do operador
		if(Session::get('perfil_ativo')->nome == 'Admin')
		{
			// perfil admin
			$inscricoes = Inscricao::with(['usuario' => function($query){
				$query->orderBy('nome','asc');
			}])->WHERE('periodo_id','=',$periodo_atual->id)->groupBy('usuario_id')->get();
		}
		elseif(Session::get('perfil_ativo')->nome == 'Candidato')
		{
			unset($areas);
			$areas = array();
			// perfil candidato
			$minhasInscricoes = Inscricao::with('usuario','usuario.areas','areas')->where('periodo_id','=',$periodo_atual->id)->where('usuario_id','=',Auth::user()->id)->get();
			foreach ($minhasInscricoes as $minhaInscricao) {
				foreach ($minhaInscricao->areas as $area) {
					$areas[] = $area->id;
				}
			}

			$professores = Usuario::join('perfis_usuarios', 'perfis_usuarios.usuario_id', '=', 'usuarios.id')
				->join('areas_usuarios', 'areas_usuarios.usuario_id', '=', 'usuarios.id')
				->where('perfis_usuarios.perfil_id','=',3);

			if($areas)
			{
				$professores->whereIn('areas_usuarios.area_id',$areas);
			}

			$professores->get();
		} else {
			//qualquer perfil menos admin e candidato
			$inscricoes = Inscricao::with(['usuario' => function($query){
				$query->orderBy('nome','asc');
			}])->whereHas('areas', function($query) use($areas)
			{
				$query->whereIn('areas.id', $areas);
			})->WHERE('periodo_id','=',$periodo_atual->id)->groupBy('usuario_id')->get();
		}


		//debug($inscricoes);

		return View::make('mensagens.create', compact('inscricoes', 'mensagens_padrao','professores'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /mensagem
	 *
	 * @return Response
	 */
	public function postCreate()
	{
		extract(Input::all());

		if(isset($para) && !empty($para))
		{
			if(is_array($para)){
				$arrayMensagem = array();
				foreach($para as $email){
					$user = Usuario::where('email', '=', $email)->first();
					if($user)
					{
						$msg = new Mensagem;

						$msg->id_remetente 		= Auth::User()->id;
						$msg->id_destinatario 	= $user->id;
						$msg->assunto			= $assunto;
						$msg->mensagem 			= $mensagem;
						$msg->lido 				= 0;
						$msg->save();

						Ulog::Novo("Envio de Mensagem", "Usuário enviou uma mensagem para {$user->nome}");

						$messageData = array(
					        'title' => 'Novo e-mail do sistema da URFJ',
					        'sender' => Auth::User()->nome,
					        'from_email' => $user->email,
					        'from_name' => $user->nome,
					        'msg' => $mensagem,
					        'assunto' => $assunto,
					        'link' => $_SERVER['SERVER_NAME'].'/mensagem/show/'.$msg->id
					    );

					    Mail::send('emails.mensagem', $messageData, function ($message) Use ($messageData) {
					        $message->from("selecao@cos.ufrj.br", "Selecao");
				        	$message->bcc("selecao@cos.ufrj.br", "Selecao");
					        $message->to($messageData["from_email"],$messageData["from_name"])->subject($messageData["assunto"]);
					    });
					    $arrayMensagem[] = "Mensagem enviada para {$user->nome} ({$user->email})";
					}
				}
				return Redirect::to('mensagem')->with('success', $arrayMensagem);
			} else {
				$user = Usuario::where('email', '=', $para)->first();

				if($user)
				{
					$msg = new Mensagem;

					$msg->id_remetente 		= Auth::User()->id;
					$msg->id_destinatario 	= $user->id;
					$msg->assunto			= $assunto;
					$msg->mensagem 			= $mensagem;
					$msg->lido 				= 0;
					$msg->save();

					Ulog::Novo("Envio de Mensagem", "Usuário enviou uma mensagem para {$user->nome}");

					$messageData = array(
				        'title' => 'Novo e-mail do sistema da URFJ',
				        'sender' => Auth::User()->nome,
				        'from_email' => $user->email,
				        'from_name' => $user->nome,
				        'msg' => $mensagem,
				        'assunto' => $assunto,
				        'link' => $_SERVER['SERVER_NAME'].'/mensagem/show/'.$msg->id
				    );

				    Mail::send('emails.mensagem', $messageData, function ($message) Use ($messageData) {
				        $message->from("selecao@cos.ufrj.br", "Selecao");
				        $message->bcc("selecao@cos.ufrj.br", "Selecao");
				        $message->to($messageData["from_email"],$messageData["from_name"])->subject($messageData["assunto"]);
				    });

					return Redirect::to('mensagem')->with('success', array("Mensagem enviada para {$user->nome} ({$user->email})"));
				}else
				{
					return Redirect::back()->with('danger', array('Não consta usuários no sistema com este endereço de E-mail.'));
				}
			}
		}
		else
		{
			return Redirect::back()->with('danger', array('O Campo PARA não pode estar vazio.'));
		}
	}

	/**
	 * Display the specified resource.
	 * GET /mensagem/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($id)
	{
		$mensagem = Mensagem::with('remetente')->find($id);

		$id_logado = Auth::user()->id;

		if($mensagem && $mensagem->id_destinatario == $id_logado || $mensagem->id_remetente == $id_logado)
		{
			if($mensagem->lido == 0 && $mensagem->id_destinatario == $id_logado)
			{
				$mensagem->lido = 1;
				$mensagem->save();

				$remetente = Usuario::find($mensagem->id_remetente);

				Ulog::Novo("Leitura de Mensagem", "Usuário leu a mensagem '{$mensagem->assunto}' do remetente '{$remetente->nome}'");
			}

			return View::make('mensagens.show')->with('mensagem', $mensagem);
		}
		else
		{
			return Redirect::back()->with('danger', array('Mensagem não encontrada.'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /mensagem/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getSent()
	{
		$mensagens = Mensagem::where('id_remetente', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->with('remetente', 'destinatario')->paginate(10);

		$titulo = 'Mensagens Enviadas';

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('titulo', $titulo);
	}

	public function getLog()
	{
		$id = Input::get('id');

		$logs = Ulog::where('usuario_id', '=', $id)->orderBy('created_at', 'DESC')->get();

		if($logs)
		{
			$html = '';
			$html .= '<div class="table-responsive">';
		    $html .=     '<table class="table table-striped table-bordered">';
		    $html .=         '<thead>';
		    $html .= 	         '<tr>';
		    $html .= 			     '<th>Acão</th>';
		    $html .= 				 '<th>Descrição</th>';
		    $html .= 				 '<th>Data/Hora</th>';
		    $html .= 			 '</tr>';
		    $html .= 		 '</thead>';
		    $html .= 		 '<tbody>';
		    foreach($logs as $log)
		    {
			    $html .= 			 '<tr>';
			    $html .= 			     '<td>'.$log->acao.'</td>';
			    $html .= 				 '<td>'.$log->descricao.'</td>';
			    $html .= 				 '<td>'.$log->created_at.'</td>';
			    $html .= 			 '</tr>';
			}
		    $html .= 		 '</tbody>';
		    $html .= 	 '</table>';
		    $html .= '</div>';
	    }

		echo $html;
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /mensagem/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /mensagem/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}