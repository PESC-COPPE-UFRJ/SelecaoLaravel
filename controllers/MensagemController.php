<?php

class MensagemController extends \BaseController 
{

	private $periodo_atual;

	public function __construct()
	{
		$this->periodo_atual = Whelper::checaPeriodo();
	}

	/**
	 * Display a listing of the resource.
	 * GET /mensagem
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		if(Session::has('perfil') && Session::get('perfil') == 1)
		{
			$userSelecao = Usuario::where('email','=','selecao@cos.ufrj.br')->get()->last();
			$mensagens = Mensagem::where('id_destinatario', '=', Auth::user()->id)->where('requerimento', 0)->orderBy('created_at', 'DESC')->orWhere('id_destinatario','=', $userSelecao->id)->with('remetente', 'destinatario')->paginate(10);
		} 
		else
		{
			$mensagens = Mensagem::where('id_destinatario', '=', Auth::user()->id)->where('requerimento', 0)->orderBy('created_at', 'DESC')->with('remetente', 'destinatario')->paginate(10);
		}

		$titulo = 'Mensagens Recebidas';

		$status_input = MensagemStatus::lists('nome', 'id');

		array_unshift($status_input, 'Selecionar status');

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('titulo', $titulo)
											->with('status_input', $status_input);
	}

	/**	 
	 * Form para enviar nova mensagem
	 * Monta lista de possíveis destinatátios dependendo do perfil ativo	 
	 * GET /mensagem/create
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$periodo_atual = Whelper::ChecaPeriodo();

		//dd($periodo_atual->inscricoes('DSC')->get()->toArray());

		//Pega areas do operador
		if(Session::has('perfil') && Session::get('perfil') == 1)
		{
            $user_areas = Area::get();
        } 
		else
		{
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
			// perfil admin: gera lisa ordenada de todos candidatos no período atual
			$inscricoes = Inscricao::join('usuarios','usuario_id','=','usuarios.id')
				->WHERE('periodo_id','=',$periodo_atual->id)->orderBy('nome','asc')->groupBy('usuario_id')->get();	
			
// 			$inscricoes = Inscricao::with(['usuario' => function($query){
// 				$query->orderBy('nome','asc');
// 			}])->WHERE('periodo_id','=',$periodo_atual->id)->groupBy('usuario_id')->get();			

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
			//qualquer perfil menos admin e candidato: gera lista de todos candidatos no período atual que estão aplicando para uma das linhas do perfil
			$inscricoes = Inscricao::join('usuarios','usuario_id','=','usuarios.id')
				->whereHas('areas', function($query) use($areas)
			{
				$query->whereIn('areas.id', $areas);
			})->WHERE('periodo_id','=',$periodo_atual->id)->orderBy('nome','asc')->groupBy('usuario_id')->get();
			
// 			$inscricoes = Inscricao::with(['usuario' => function($query){
// 				$query->orderBy('nome','asc');
// 			}])->whereHas('areas', function($query) use($areas)
// 			{
// 				$query->whereIn('areas.id', $areas);
// 			})->WHERE('periodo_id','=',$periodo_atual->id)->groupBy('usuario_id')->get();
		}
		$userEmail;
		if(Input::has('email')){
			$userEmail = Usuario::Where('email', Input::get('email'))->first();
		}
		
		$status = Status::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao', 'id');
    $status_linha = StatusLinha::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao', 'id');

		$areas_input = Area::all();

		//debug($inscricoes);

		$inscritos['MSC'] = $periodo_atual->inscricoes(['MSC'])->count();
		$inscritos['DSC'] = $periodo_atual->inscricoes(['DSC'])->count();


		return View::make('mensagens.create', compact('inscricoes', 'mensagens_padrao','professores','userEmail', 'status', 'status_linha', 'inscritos', 'areas_input'));
	}

	public function postStatus()
	{
		$mensagens = Input::get('mensagens');
		$status = Input::get('status');
		
		Mensagem::whereIn('id', $mensagens)->update(['id_status' => $status]);

		return Redirect::to('mensagem')->with('success', ['Status atualizados']);
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
		//dd(Input::all());

		if(isset($tipo_filtro) && $tipo_filtro == 'broadcast')
		{			
			$cursos = $para_broadcast;
			$inscricoes = $this->periodo_atual->inscricoes($cursos)->with(array('usuario' => function($query)
			{
				$query->select('id', 'email', 'nome');
			}))->with('areas')->get();

			$para = array();
			$pulos = 0;
			foreach($inscricoes as $i)
			{
				//Filtro de areas do broadcast
				if(isset($areas_broadcast) && count($areas_broadcast) > 0)
				{
					$continue = true;
					foreach($i->areas as $area)
					{
						//Se a inscricao atual possui uma das areas do filtro não pula o foreach e insere
						//o usuário no array						
						if(in_array($area->id, $areas_broadcast))
						{
							$continue = false;							
						}
					}

					//Se a inscrição não possuir a area, pula o foreach, assim evitando que seja inserido no array
					if($continue)
					{
						$pulos++;
						continue;
					}
				}

				//Filtro de situações de inscrição do broadcast
				if(isset($situacoes_broadcast) && count($situacoes_broadcast) > 0)
				{
					//Se a situação da inscrição não esta dentro das selecionadas no filtro, pula a interação do foreach
					//e não adiciona user no array.
					if(!in_array($i->status_id, $situacoes_broadcast))
					{
						$pulos++;
						continue;
					}
				}
				
				
				//Filtro de situações de linha do broadcast
				if(isset($situacoes_linha_broadcast) && count($situacoes_linha_broadcast) > 0)
				{
					$continue = true;
					foreach($i->areasInscricoes as $area)
					{
						// caso onde existem áreas selecionadas, verifica apenas para essas áreas
						if(isset($areas_broadcast) && count($areas_broadcast) > 0)
						{
							if(in_array($area->area_id, $areas_broadcast))
							{
								// se a situação dessa linha está selecionada
								if (in_array($area->status_id, $situacoes_linha_broadcast))
								{
									$continue = false;	
								}											
							}
						}
						else // não precisa verificar se área está selecionada, verifica para todas áreas da inscrição
						{							
							// se a situação dessa linha está selecionada
							if (in_array($area->status_id, $situacoes_linha_broadcast))
							{
								$continue = false;	
							}							
						}
					}

					//Se a inscrição não possuir area/situação compatível com os filtros, pula o foreach, assim evitando que seja inserido no array
					if($continue)
					{
						$pulos++;
						continue;
					}
				}


				$para[] = $i->usuario;
			}

			$para = Collection::make($para);

			unset($inscricoes);
		}

		if(isset($para) && !empty($para))
		{
			$arrayMensagem = array();

			if(!is_a($para, 'Collection'))
			{
				$para = Usuario::whereIn('email', $para)->select('id', 'email', 'nome')->get();
			}

			foreach($para as $user)
			{
				$msg = new Mensagem;

				$msg->id_remetente 		= Auth::User()->id;
				$msg->id_destinatario 	= $user->id;
				$msg->assunto			= $assunto;
				$msg->mensagem 			= $mensagem;
				$msg->lido 				= 0;

				if(isset($linha_id) && !empty($linha_id)){
					$msg->requestlinha = $linha_id;
				}

				$msg->requerimento = (isset($requerimento)) ? $requerimento : 0;

				$msg->save();

				Ulog::Novo("Envio de Mensagem", "Usuário enviou uma mensagem para {$user->nome}");

				//mensagem que é enviado para todos, menos candidatos.
				$mensagemSender = "Você recebeu uma mensagem pelo Sistema de Seleção do PESC-UFRJ";
				if(Session::has('perfil') && Session::get('perfil') == 2)//mensagem que é enviada apenas para candidatos
				{
					$mensagemSender = Auth::User()->nome." te enviou uma mensagem pelo sistema de Seleção PESC-UFRJ";
				}	
				$messageData = array(
			        'title' => 'Novo e-mail do sistema de Seleção PESC-UFRJ',
			        'sender' => $mensagemSender,
			        'from_email' => $user->email,
			        'from_name' => $user->nome,
			        'msg' => $msg->mensagem,
			        'assunto' => $assunto,
			        'link' => $_SERVER['SERVER_NAME'].'/mensagem/show/'.$msg->id
			    );

			    Mail::send('emails.mensagem', $messageData, function ($message) Use ($messageData){
			        $message->from("selecao@cos.ufrj.br", "Selecao");
			        $message->bcc("selecao@cos.ufrj.br", "Selecao");
			        $message->to($messageData["from_email"],$messageData["from_name"])->subject($messageData["assunto"]);
			    });
			    $arrayMensagem[] = "Mensagem enviada para {$user->nome} ({$user->email})";
			}

			return Redirect::to('mensagem')->with('success', $arrayMensagem);
			
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

		if($mensagem && $mensagem->id_destinatario == $id_logado || $mensagem->id_remetente == $id_logado || Session::get('perfil') == 1)
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

		$status_input = MensagemStatus::lists('nome', 'id');

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('status_input', $status_input)
											->with('titulo', $titulo);
	}

	public function getLogg()
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

	public function getRequestList()
	{
		$mensagens = Mensagem::with('remetente', 'destinatario')->where('id_destinatario', Auth::user()->id)->where('requerimento', 1)->orderBy('created_at', 'DESC')->paginate(10);

		$titulo = 'Mensagens Recebidas';

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('titulo', $titulo)
											->with('requerimento', 1);
	}

	public function getRequest()
	{
		$requerimento = true;
		$periodo_atual = Whelper::ChecaPeriodo();

		$mensagens_padrao = MensagemPadrao::all();
		$professores = array();
		$inscricoes = array();
		$areas = array();
		$areasCandidato = array();

		// perfil candidato
		$minhasInscricoes = Inscricao::with('usuario','usuario.areas','areas')->where('periodo_id','=',$periodo_atual->id)->where('usuario_id','=',Auth::user()->id)->get();
		foreach ($minhasInscricoes as $minhaInscricao) {
			foreach ($minhaInscricao->areas as $area) {
				$areas[] = $area->id;
				$areasCandidato[$area->id] = $area->nome;
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

		$userEmail;
		if(Input::has('email')){
			$userEmail = Usuario::Where('email', Input::get('email'))->first();
		}

		return View::make('mensagens.create', compact('inscricoes', 'mensagens_padrao','professores','userEmail','areasCandidato','requerimento'));
	}

	public function getRequestListSent()
	{
		$mensagens = Mensagem::with('remetente', 'destinatario')->where('id_remetente', '=', Auth::user()->id)->where('requerimento', 1)->orderBy('created_at', 'DESC')->paginate(10);

		$titulo = 'Mensagens Enviadas';

		return View::make('mensagens.index')->with('mensagens', $mensagens)
											->with('titulo', $titulo)
											->with('requerimento', 1);
	}

	public function getHistorico($id_remetente, $id_destinatario)
	{
		if($id_remetente == 4082 && (!Session::has('perfil') || Session::get('perfil') != 1))
		{
			return json_encode(['error' => 'Acesso Negado']);
		}

		$msgsremetente = Mensagem::with('remetente', 'destinatario')->where('id_remetente', $id_remetente)->where('id_destinatario', $id_destinatario)->orderBy('created_at', 'DESC')->get();
		$msgsdestinatario = Mensagem::with('remetente', 'destinatario')->where('id_remetente', $id_destinatario)->where('id_destinatario', $id_remetente)->orderBy('created_at', 'DESC')->get();

		$mensagens = $msgsremetente->merge($msgsdestinatario);

		return $mensagens;
	}

}