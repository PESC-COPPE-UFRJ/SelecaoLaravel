<?php

class MeusDadosController extends BaseController {

	protected $id;
	protected $regras = array(
								'cpf'        => 'cpf',
								// 'passaporte' => 'sometimes'
								//'nome_mae'		=> 'required'
								);

	public function __construct()
	{
		//
		$this->id = Auth::user()->id;
	}

	public function getDadosPessoais($id = false)
	{
		//variavel que verifica se pode editar os "meus dados" (só não é possivel editar se o status de sua inscrição for FECHADO - Edição Encerrada)
		$permitSubmit = true;
		if($id && Request::is('adm/*'))
		{
			$this->id = $id;
		} elseif($id) {
			$this->id = $id;
			$permitSubmit = true;
		}

		$periodo_atual     = Whelper::ChecaPeriodo();
		$all_estados_civis = EstadoCivil::all();
		$all_estados       = Estado::all();
		$all_paises        = Pais::all();
		$candidato         = Usuario::find($this->id);


		// $inscricao = Inscricao::WHERE('periodo_id','=',$periodo_atual->id)->WHERE('usuario_id','=',$this->id)->get()->last();
		$inscricoes = Inscricao::WHERE('periodo_id','=',$periodo_atual->id)->WHERE('usuario_id','=',$this->id)->get();
		$inscricao = $inscricoes->last();

		$imagens = array();
		foreach ($inscricoes as $ins){
			$morphImages = $ins->imagens()->get();
			foreach($morphImages as $image){
				if($image->titulo == "Plano de pesquisa" || $image->titulo == "Carta de Concordância da Empresa")
				$imagens[$image->titulo][] = $image->caminho.$image->nome;
			}
		}

		
		if(empty($id))
		{
			if ($periodo_atual->status != 4 && $inscricao)
			{	
				$confirmou = false;
				
				foreach ($inscricao->areasInscricoes as $area)
				{
					if ( !empty($area) && !empty($area->status))
					{
						if ( $area->status->sigla == 'CONFIRMOU' )
							$confirmou = true;
					}
				}
				// pode editar com período aberto se status for em edição, doc incompleto, ou confirmou matrícula em uma das áreas
				if($inscricao->status->last()->id != 1 && $inscricao->status->last()->id != 4 && !$confirmou)
				{
					$permitSubmit = false;
				}
			}
		}
		
		return View::make('painel_candidato.meus_dados.dados_pessoais')->with('candidato',$candidato)
													          	       ->with('all_estados_civis', $all_estados_civis)
													          	       ->with('all_estados', $all_estados)
														 	  	       ->with('all_paises', $all_paises)
														 	  	       ->with('imagens', $imagens)
														 	  	       ->with('permitSubmit', $permitSubmit);
	}

	public function postDadosPessoais()
	{
		if(Session::has('perfil') && (Session::get('perfil') == 1 || Session::get('perfil') == 2)){
			//do nothing
		} else {
			return Redirect::to('panel')->with('warning', array('Apenas admin pode editar este canditato!'));
		}
		//
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		//criando regras de validação

		$messages = array('cpf' => 'O CPF digitado é inválido!');

		//executando validação
		$validacao = Validator::make($inputs, $this->regras, $messages);

		//se a validação deu errado
		if ($validacao->fails())
		{
			Input::flash();

			return Redirect::to('candidato/meusdados/dados-pessoais')->with('danger', $validacao->messages()->getMessages());
		}
		else
		{
			if(isset($cpf))
			{
				$cpfsemcaracteres = preg_replace('/[.-]/','',$cpf);
			}
			else
			{
				$cpfsemcaracteres = '';
			}

			if(Input::has('id_usuario'))
			{
				$this->id = Input::get('id_usuario');

				$redirect_to = 'adm/meusdados/dados-pessoais/' . $this->id;
			}
			else
			{
				// $files = Input::file();

				// unset($files['certificado_militar_verso_arquivo']);
				// unset($files['certificado_militar_arquivo']);
				// foreach($files as $key => $file)
				// {
				// 	if(empty($file))
				// 	{
				// 		return Redirect::back()->with('warning', array("O upload do arquivo $key é obrigatório"));
				// 	}
				// }

				$redirect_to = 'candidato/meusdados/dados-pessoais';
			}

			$candidato = Usuario::with('endereco')->findOrFail($this->id);

			$candidato->nome          = (isset($nome_completo)) ? $nome_completo : '';
			$candidato->email         = (isset($email)) ? $email : '';
			$candidato->sexo          = (isset($sexo)) ? $sexo : '';
			$candidato->nascimento    = (isset($data_nascimento) && $data_nascimento != '') ?$data_nascimento : '0000-00-00';
			$candidato->cidadenasc    = (isset($cidade_nascimento)) ? $cidade_nascimento : '';
			$candidato->estrangeiro   = (isset($estrangeiro)) ? $estrangeiro : '';
			$candidato->nacionalidade = (isset($nacionalidade)) ? $nacionalidade : '';
			$candidato->estcivil      = (isset($estado_civil)) ? $estado_civil : '';
			$candidato->ident         = (isset($identidade)) ? $identidade : '';
			$candidato->expedicao     = (isset($data_expedicao_identidade) && $data_expedicao_identidade != '') ? $data_expedicao_identidade: '0000-00-00';
			$candidato->orgaoexped    = (isset($orgao_expedidor_identidade)) ? $orgao_expedidor_identidade : '' ;
			$candidato->estexped      = (isset($estado_expedidor_identidade)) ? $estado_expedidor_identidade : '' ;
			$candidato->cpf           = $cpfsemcaracteres;
			$candidato->passaporte    = (isset($passaporte)) ? $passaporte : '';
			$candidato->tituloeleitor = (isset($titulo_eleitor)) ? $titulo_eleitor : '';
			$candidato->tituloeleitorzona = (isset($titulo_eleitor_zona)) ? $titulo_eleitor_zona : '';
			$candidato->tituloeleitorsecao = (isset($titulo_eleitor_secao)) ? $titulo_eleitor_secao : '';
			$candidato->tituloeleitoruf = (isset($titulo_eleitor_uf)) ? $titulo_eleitor_uf : '';
			$candidato->tituloeleitoremissao = (isset($titulo_eleitor_emissao) && $titulo_eleitor_emissao != '') ? $titulo_eleitor_emissao : '0000-00-00';			
			$candidato->certmilitar   = (isset($certificado_militar)) ? $certificado_militar : '';
			$candidato->certmilitarcategoria  = (isset($certificado_militar_categoria)) ? $certificado_militar_categoria : '';
			$candidato->certmilitarorgao  = (isset($certificado_militar_orgao)) ? $certificado_militar_orgao : '';
			$candidato->certmilitaruf  = (isset($certificado_militar_uf)) ? $certificado_militar_uf : '';
			$candidato->certmilitaremissao = (isset($certificado_militar_emissao) && $certificado_militar_emissao != '') ? $certificado_militar_emissao : '0000-00-00';
			$candidato->telefone      = (isset($telefone)) ? $telefone : '';
			$candidato->celular       = (isset($celular)) ? $celular : '';
			$candidato->nomemae       = (isset($nome_mae)) ? $nome_mae : '';
			$candidato->nomepai       = (isset($nome_pai)) ? $nome_pai : '';
			$candidato->numdeps       = (isset($qtd_dependentes)) ? $qtd_dependentes : '';
			$candidato->numfilhos     = (isset($qtd_filhos)) ? $qtd_filhos : '';
			$candidato->idadefilhos   = (isset($idades_filhos)) ? $idades_filhos : '';
			$candidato->tiposanguineo = (isset($tipo_sanguineo)) ? $tipo_sanguineo : '';
			$candidato->fatorrh       = (isset($fator_rh)) ? $fator_rh : '';
			$candidato->corpele       = (isset($cor_pele)) ? $cor_pele : '';
			


			//IMGS
			$destinationPath = 'uploads/usuarios/' . $candidato->id . '/documentos/'; // upload path

			//Identidade
			// checking file is valid.
			if (Input::hasFile('identidade_arquivo') && Input::file('identidade_arquivo')->isValid())
			{								
				$extension = Input::file('identidade_arquivo')->getClientOriginalExtension(); // getting image extension

				if ($this->checkValidExtension($extension))
				{
					$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
					Input::file('identidade_arquivo')->move($destinationPath, $fileName); // uploading file to given path				
			  		$candidato->identidade_img = $fileName;
				}
			}

			//Identidade Verso
			// checking file is valid.
		    if (Input::hasFile('identidade_verso_arquivo') && Input::file('identidade_verso_arquivo')->isValid())
		    {
		    	$extension = Input::file('identidade_verso_arquivo')->getClientOriginalExtension(); // getting image extension
					
				if ($this->checkValidExtension($extension))
				{
				    $fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
		      		Input::file('identidade_verso_arquivo')->move($destinationPath, $fileName); // uploading file to given path
		      		$candidato->identidade_verso_img = $fileName;
				}
		    }

		    //CPF
		    // checking file is valid.
			if (Input::hasFile('cpf_arquivo') && Input::file('cpf_arquivo')->isValid())
			{
				$extension = Input::file('cpf_arquivo')->getClientOriginalExtension(); // getting image extension
				
				if ($this->checkValidExtension($extension))
				{
			  		$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
			  		Input::file('cpf_arquivo')->move($destinationPath, $fileName); // uploading file to given path
			  		$candidato->cpf_img = $fileName;
				}
			}

			//Titulo de eleitor
			// checking file is valid.
			if (Input::hasFile('titulo_eleitor_arquivo') && Input::file('titulo_eleitor_arquivo')->isValid())
			{
			  	$extension = Input::file('titulo_eleitor_arquivo')->getClientOriginalExtension(); // getting image extension
				
				if ($this->checkValidExtension($extension))
				{
			  		$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
			  		Input::file('titulo_eleitor_arquivo')->move($destinationPath, $fileName); // uploading file to given path
			  		$candidato->titulo_eleitor_img = $fileName;
				}
			}

			//Titulo de eleitor Verso
			// checking file is valid.
			if (Input::hasFile('titulo_eleitor_verso_arquivo') && Input::file('titulo_eleitor_verso_arquivo')->isValid())
			{
				$extension = Input::file('titulo_eleitor_verso_arquivo')->getClientOriginalExtension(); // getting image extension
				
				if ($this->checkValidExtension($extension))
				{
			  		$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
			  		Input::file('titulo_eleitor_verso_arquivo')->move($destinationPath, $fileName); // uploading file to given path
			  		$candidato->titulo_eleitor_verso_img = $fileName;
				}
			}

			//Certificado Militar
			// checking file is valid.
			if (Input::hasFile('certificado_militar_arquivo') && Input::file('certificado_militar_arquivo')->isValid())
			{
				$extension = Input::file('certificado_militar_arquivo')->getClientOriginalExtension(); // getting image extension
				if ($this->checkValidExtension($extension))
				{
			  		$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
			  		Input::file('certificado_militar_arquivo')->move($destinationPath, $fileName); // uploading file to given path
			  		$candidato->certificado_militar_img = $fileName;
				}
			}

			//Certificado Militar Verso
			// checking file is valid.
			if (Input::hasFile('certificado_militar_verso_arquivo') && Input::file('certificado_militar_verso_arquivo')->isValid())
			{
				$extension = Input::file('certificado_militar_verso_arquivo')->getClientOriginalExtension(); // getting image extension
				if ($this->checkValidExtension($extension))
				{
			  		$fileName = $candidato->id . rand(11111,99999).'.'.$extension; // renameing image
			  		Input::file('certificado_militar_verso_arquivo')->move($destinationPath, $fileName); // uploading file to given path
			  		$candidato->certificado_militar_verso_img = $fileName;
				}
			}


			$candidato->save();

			Ulog::Novo("Dados Pessoais", "Candidato salvou seus dados pessoais");

			if($candidato->endereco == null)
			{
				$address = new Endereco;
			}
			else
			{
				$address = Endereco::find($candidato->endereco->id);
			}

			$address->usuario_id   = $this->id;
			$address->endereco     = (isset($endereco)) ? $endereco : '';
			$address->bairro       = (isset($bairro)) ? $bairro : '';
			$address->cidade       = (isset($cidade)) ? $cidade : '';
			$address->estado       = (isset($estado)) ? $estado : '';
			$address->pais         = (isset($pais)) ? $pais : '';
			$address->cep          = (isset($cep)) ? $cep : '';

			$address->save();

			if(Input::hasFile('anexo'))
			{
				$this->upload($this->id);
			}

			return Redirect::to($redirect_to)->with('success',array(1 => 'Usuário atualizado com sucesso!'));
		}
	}

	public function upload($id)
	{
		$file 	 = Input::file('anexo');
		
		$dir_db	 = '/uploads/usuarios/$id/documentos/';
		$directory = public_path() . $dir_db;
	    $extension = $file->getClientOriginalExtension();
		
		$upload_success = false;
		if ($this->checkValidExtension($extension))
		{
	      	$filename  = sha1($file->getClientOriginalName() . time().time()) .".$extension";
	      	$upload_success = $file->move($directory, $filename);
		}

		if( $upload_success )
		{
			$candidato = Usuario::find($id);
			$candidato->foto = $dir_db . $filename;
			$candidato->save();
		}
		else
		{
			return false;
		}

	   return true;
	}

	public function getFormacao($id = false)
	{
		
		//
		$userId = false;
		if($id && Session::has('perfil') && Session::get('perfil') != 2)
		{
			$this->id = $id;
			$userId = $this->id;
		}
		$formacoes = Formacao::with('imagens')->where('usuario_id', '=', $this->id)->OrderBy('ano_inicio', 'DESC')->get();
		return View::make('painel_candidato.meus_dados.formacao')->with('formacoes',$formacoes)->with('userId',$userId);
	}

	public function postFormacao()
	{
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}	

		if(Input::has('userId'))
		{
			$this->id = Input::get('userId');

			$redirect_to = 'candidato/meusdados/formacao/' . $this->id;
		}
		else
		{
			$redirect_to = 'candidato/meusdados/formacao';
		}
		$redirect = Redirect::to($redirect_to);

		if(isset($formacoes) && sizeof($formacoes) > 0)
		{
			foreach($formacoes as $form)
			{
				if($form['id'] == '')
				{
					$formacao = new Formacao;
					$formacao->usuario_id = $this->id;
					$formacao->estado       = $form['estado'];
					$formacao->pais         = $form['pais'];
					$formacao->formacao     = $form['formacao'];
					$formacao->concluido    = $form['concluido'];
					$formacao->instituicao  = $form['instituicao'];
					$formacao->curso        = $form['curso'];
					$formacao->cr           = $form['cr'];
					$formacao->valor 		= $form['valor'];
					$formacao->media_maxima = $form['media_maxima'];
					$formacao->ano_inicio   = $form['ano_inicio'];
					$formacao->ano_fim      = $form['ano_fim'];
					$formacao->save();
					$mensagem = 'Formações criadas com sucesso!';
				}
				else
				{
					$formacao = Formacao::find($form['id']);
					$formacao->usuario_id = $this->id;
					$formacao->estado       = $form['estado'];
					$formacao->pais         = $form['pais'];
					$formacao->formacao     = $form['formacao'];
					$formacao->concluido    = $form['concluido'];
					$formacao->instituicao  = $form['instituicao'];
					$formacao->curso        = $form['curso'];
					$formacao->cr           = $form['cr'];
					$formacao->valor 		= $form['valor'];
					$formacao->media_maxima = $form['media_maxima'];
					$formacao->ano_inicio   = $form['ano_inicio'];
					$formacao->ano_fim      = $form['ano_fim'];
					$formacao->save();
					$mensagem = 'Formações atualizadas com sucesso!';
				}
			}
		}

		if(!isset($mensagem))
		{
			return $redirect;
		}
		else
		{
			Ulog::Novo("Salvou Formações", "Usuário salvou suas formações");
			return $redirect->with('success',array(1 => $mensagem));
		}

	}

	public function getImagensFormacao()
	{
		$id       = Input::get('formacao_id');
		$formacao = Formacao::with('imagens')->find($id);
		$array_ids = array();
			
		foreach($formacao->imagens as $imagem)
		{
			$array_ids[] = $imagem->id;
		}
		
		
		return json_encode($array_ids);
	}

	public function postFormacaoSingle()
	{		
		$form = Input::all();		
		
		if(isset($form['userId']) && !empty($form['userId']))
		{
			$this->id = $form['userId'];
		}
		$imagem = '';

		// verifica se formação já existe (edição)
		if(Input::has('fid') && Input::get('fid') != null && Input::get('fid') != '')
		{
			$formacao = Formacao::find(Input::get('fid'));

			$formacao->estado       = $form['estado'];
			$formacao->pais         = $form['pais'];
			$formacao->formacao     = $form['formacao'];
			$formacao->concluido    = $form['concluido'];
			$formacao->instituicao  = $form['instituicao'];
			$formacao->curso        = $form['curso'];
			$formacao->cr           = $form['cr'];
			//$formacao->valor 		= $form['valor'];
			$formacao->media_maxima = $form['media_maxima'];
			$formacao->ano_inicio   = $form['ano_inicio'];
			$formacao->ano_fim      = $form['ano_fim'];
			
		
			if($formacao->usuario_id == Auth::user()->id || $formacao->usuario_id == $form['userId'])
			{																
				
				// Conta quantas imagens formação já tinha, para pegar contador correto no formulário
				$num_old_images = count($formacao->imagens);
				
				//Se tiver imagens sobe
				if(Input::hasFile('imagens'))
				{
					$imagens = Input::file('imagens');
				
					foreach($imagens as $key => $img)
					{
						$dst_folder = 'usuarios/' . $this->id . '/documentos/formacoes/' . $formacao->id . '/';
				        $imginfo = $this->uploadImage($img, $dst_folder);

				        if($imginfo)
				        {
					        $imagem = new Imagem;
					        $imagem->titulo  = $form['titulo'][$key+$num_old_images];
					        $imagem->nome    = $imginfo['filename'];
					        $imagem->caminho = $imginfo['destinationPath'];
					        $formacao->imagens()->save($imagem);
					    }
				    }
				}
				if(isset($form['imgid']))
				{
					foreach($form['imgid'] as $key => $imgId)
				    {
				    	$imagem = Imagem::find($imgId);
				    	$imagem->titulo = $form['titulo'][$key];
				    	$imagem->save();
				    }
				}

				$formacao->save();
				$msg = 'Formação atualizada com sucesso.';
			}
			else
			{
				$msg = 'Acesso Negado';
			}

			Ulog::Novo("Atualizou Formações", "Usuário Atualizou suas formações");
			$msg = 'Formação atualizada com sucesso.';
			$id  = $formacao->id;

		}
		// cria nova formação
		else
		{
			$formacao = new Formacao;
			$formacao->estado       = $form['estado'];
			$formacao->pais         = $form['pais'];
			$formacao->formacao     = $form['formacao'];
			$formacao->concluido    = $form['concluido'];
			$formacao->instituicao  = $form['instituicao'];
			$formacao->curso        = $form['curso'];
			$formacao->cr           = $form['cr'];
			//$formacao->valor 		= $form['valor'];
			$formacao->media_maxima = $form['media_maxima'];
			$formacao->ano_inicio   = $form['ano_inicio'];
			$formacao->ano_fim      = $form['ano_fim'];

			$user = Usuario::find($this->id);
			$user->formacoes()->save($formacao);

			//Se tiver imagens sobe
			if(Input::hasFile('imagens'))
			{
				$imagens = Input::file('imagens');

				foreach($imagens as $key => $img)
				{
			        //$imginfo = $this->uploadImage($img, 'candidatos/formacoes'.Auth::user()->id);
					$dst_file = 'usuarios/' . $this->id . '/documentos/formacoes/' . $formacao->id . '/';
				    $imginfo = $this->uploadImage($img, $dst_file);

			        if($imginfo)
			        {
				        $imagem = new Imagem;
				        $imagem->titulo = $form['titulo'][$key];
				        $imagem->nome = $imginfo['filename'];
				        $imagem->caminho = $imginfo['destinationPath'];

				        $formacao->imagens()->save($imagem);
				    }
			    }
			}

			Ulog::Novo("Salvou Formações", "Usuário salvou suas formações");
			$msg = 'Formação adicionada com sucesso.';
			$id = $formacao->id;
		}

		$imagens = $formacao->imagens->toArray();
		$response = array('msg' => $msg, 'id' => $id, 'documento_formacao_img' => $imagem, 'imagens' => $imagens);
		echo json_encode($response);
	}

	public function postApagarFormacao()
	{
		$idFormacao = Input::get('idFormacao');

		$formacao = Formacao::find($idFormacao);
		
		$usuarioId = $formacao->usuario_id;
	
		// apaga imagens
		foreach($formacao->imagens as $i)
		{
			$filename = $i->caminho . $i->nome;
			if (is_file($filename))
			{
				unlink($filename);				
			}
			$i->delete();
		}
		
		$formacao->delete();
		
		$formacaoDir = 'uploads/usuarios/' . $usuarioId . '/documentos/formacoes/' . $idFormacao;
		//system("rmdir ".escapeshellarg($formacaoDir));
		
		$deleted = $this->deleteDirectory($formacaoDir);			
	}


	public function getExperiencia($id = false)
	{
		
		$userId = false;
		if($id && Session::has('perfil') && Session::get('perfil') != 2)
		{
			$this->id = $id;
		}
		$experiencias = Experiencia::where('usuario_id','=', $this->id)->get();
		return View::make('painel_candidato.meus_dados.experiencia')->with('experiencias',$experiencias)->with('userId',$this->id);
	}

	public function postExperiencia()
	{
		//
		$redirect = Redirect::to('candidato/meusdados/experiencia');

		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		if(isset($userId) && !empty($userId))
		{
			$this->id = $userId;
		}

		if(isset($experiencias) && sizeof($experiencias) > 0)
		{

			foreach($experiencias as $exp)
			{
				if($exp['id'] == '')
				{
					$experiencia = new Experiencia;
					$experiencia->usuario_id = $this->id;
					$experiencia->empresa      = $exp['empresa'];
					$experiencia->url 		   = $exp['url'];
					$experiencia->funcao       = $exp['funcao'];
					$experiencia->endereco     = $exp['endereco'];
					$experiencia->admissao     = $exp['admissao'];
					$experiencia->demissao     = $exp['demissao'];
					$experiencia->save();
					$mensagem = 'Experiência criadas com sucesso!';
				}
				else
				{
					$experiencia = Experiencia::find($exp['id']);
					$experiencia->usuario_id = $this->id;
					$experiencia->empresa      = $exp['empresa'];
					$experiencia->url 		   = $exp['url'];
					$experiencia->funcao       = $exp['funcao'];
					$experiencia->endereco     = $exp['endereco'];
					$experiencia->admissao     = $exp['admissao'];
					$experiencia->demissao     = $exp['demissao'];
					$experiencia->save();
					$mensagem = 'Experiência atualizadas com sucesso!';
				}
			}
		}

		if(!isset($mensagem))
		{
			return $redirect;
		}
		else
		{
			return $redirect->with('success',array(1 => $mensagem));
		}

	}

	public function postExperienciaSingle()
	{
		$exp = Input::all();

		if(isset($exp['userId']) && !empty($exp['userId']))
		{
			$this->id = $exp['userId'];
		}
		$user = Usuario::find($this->id);

		if(Input::has('eid') && Input::get('eid') != null)
		{

			$experiencia = Experiencia::find(Input::get('eid'));

			$experiencia->empresa      = $exp['empresa'];
			$experiencia->url 		   = $exp['url'];
			$experiencia->funcao       = $exp['funcao'];
			$experiencia->endereco     = $exp['endereco'];
			$experiencia->admissao     = $exp['admissao'];
			$experiencia->demissao     = $exp['demissao'];

			// if($experiencia->usuario_id == Auth::user()->id)
			// {
				$experiencia->save();
				Ulog::Novo("Atualizou Experiência", "Usuário atualizou suas Experiências");
				$msg = 'Experiência atualizada com sucesso.';
			// }
			// else
			// {
			// 	$msg = 'Acesso Negado';
			// }


			$id  = $experiencia->id;

		}
		else
		{
			$experiencia = new Experiencia;
			$experiencia->empresa      = $exp['empresa'];
			$experiencia->url 		   = $exp['url'];
			$experiencia->funcao       = $exp['funcao'];
			$experiencia->endereco     = $exp['endereco'];
			$experiencia->admissao     = $exp['admissao'];
			$experiencia->demissao     = $exp['demissao'];

			$experiencia->save();

			$user->experiencias()->save($experiencia);

			$msg = 'Experiência adicionada com sucesso.';
			Ulog::Novo("Salvou experiências", "Usuário salvou suas experiências");
			$id = $experiencia->id;
		}

		$response = array('msg' => $msg, 'id' => $id);
		echo json_encode($response);
	}

	public function postApagarExperiencia()
	{
		//
		$idExperiencia = Input::get('idExperiencia');

		$experiencia = Experiencia::find($idExperiencia);

		$experiencia->delete();
	}

	public function getDocencia( $id = false )
	{
		$permitSubmit = true;
		
		if($id && Request::is('adm/*'))
		{
			$this->id = $id;
		} 
		elseif($id) 
		{
			$this->id = $id;
			$permitSubmit = true;
		}

		$docencias = Docencia::where('usuario_id', '=', $this->id)->get();
		return View::make('painel_candidato.meus_dados.docencia')->with('docencias',$docencias);
	}

	public function postDocencia()
	{
		//

		$redirect = Redirect::to('candidato/meusdados/docencia');

		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		if(isset($docencias) && sizeof($docencias) > 0)
		{

			foreach($docencias as $doc)
			{
				if($doc['id'] == '')
				{
					$docencia = new Docencia;
					$docencia->usuario_id = $this->id;
					$docencia->estado       = $doc['estado'];
					$docencia->pais         = $doc['pais'];
					$docencia->instituicao  = $doc['instituicao'];
					$docencia->tipo         = $doc['tipo'];
					$docencia->departamento = $doc['departamento'];
					$docencia->nivel        = $doc['nivel'];
					$docencia->disciplina   = $doc['disciplina'];
					$docencia->desde        = $doc['desde'];
					$docencia->ate          = $doc['ate'];
					$docencia->save();
					$mensagem = 'Docência(s) criada(s) com sucesso!';
				}
				else
				{
					$docencia = Docencia::find($doc['id']);
					$docencia->usuario_id = $this->id;
					$docencia->estado       = $doc['estado'];
					$docencia->pais         = $doc['pais'];
					$docencia->instituicao  = $doc['instituicao'];
					$docencia->tipo         = $doc['tipo'];
					$docencia->departamento = $doc['departamento'];
					$docencia->nivel        = $doc['nivel'];
					$docencia->disciplina   = $doc['disciplina'];
					$docencia->desde        = $doc['desde'];
					$docencia->ate          = $doc['ate'];
					$docencia->save();
					$mensagem = 'Docência(s) atualizada(s) com sucesso!';
				}
			}
		}

		if(!isset($mensagem)) {
			return $redirect;
		}
		else
		{
			return $redirect->with('success', array(1 => $mensagem));
		}

	}

	public function postDocenciaSingle()
	{

		if(Input::has('did') && Input::get('did') != null)
		{
			$docencia = Docencia::find(Input::get('did'));

			$docencia->estado       = Input::get('estado');
			$docencia->pais         = Input::get('pais');
			$docencia->instituicao  = Input::get('instituicao');
			$docencia->tipo         = Input::get('tipo');
			$docencia->departamento = Input::get('departamento');
			$docencia->nivel        = Input::get('nivel');
			$docencia->disciplina   = Input::get('disciplina');
			$docencia->desde        = Input::get('desde');
			$docencia->ate          = Input::get('ate');

			if($docencia->usuario_id == Auth::user()->id OR Session::get('perfil') == 1)
			{
				$docencia->save();
				Ulog::Novo("Atualizou Docências", "Usuário atualizou suas docências");
				$msg = 'Docência atualizada com sucesso.';
			}
			else
			{
				$msg = 'Acesso Negado';
			}

			$id  = $docencia->id;

		}
		else
		{
			$docencia = new Docencia;
			$docencia->estado       = Input::get('estado');
			$docencia->pais         = Input::get('pais');
			$docencia->instituicao  = Input::get('instituicao');
			$docencia->tipo         = Input::get('tipo');
			$docencia->departamento = Input::get('departamento');
			$docencia->nivel        = Input::get('nivel');
			$docencia->disciplina   = Input::get('disciplina');
			$docencia->desde        = Input::get('desde');
			$docencia->ate          = Input::get('ate');

			Auth::user()->docencias()->save($docencia);

			$msg = 'Docência adicionada com sucesso.';
			Ulog::Novo("Salvou Docências", "Usuário salvou suas docências");
			$id = $docencia->id;
		}

		$response = array('msg' => $msg, 'id' => $id);
		echo json_encode($response);
	}

	public function postApagarDocencia()
	{
		//
		$idDocencia = Input::get('idDocencia');

		$docencia   = Docencia::find($idDocencia);

		$docencia->delete();
		Ulog::Novo("Deletou Docências", "Usuário deletou uma de suas docências");
	}

	public function getOutrasInfos( $id = false )
	{
		if( $id == '' )
		{
			$id = Auth::user()->id;
		}

		$outras_infos       = OutraInfo::where('usuario_id','=', $id)->first();
		$premios            = Premio::where('usuario_id','=', $id)->get();
		$candidaturas       = CandidaturaPrevia::where('usuario_id','=', $id)->get();
		$outrascandidaturas = OutraCandidatura::where('usuario_id','=', $id)->get();
		$imagens 			= Imagem::where('imagemMorph_id','=', $id)->where('imagemMorph_type','=','ProficienciaIngles')->get();

		return View::make('painel_candidato.meus_dados.outras_infos')->with('outras_infos', $outras_infos)
																	 ->with('premios', $premios)
																	 ->with('imagens', $imagens)
																	 ->with('candidaturas', $candidaturas)
																	 ->with('outrascandidaturas', $outrascandidaturas)
																	 ->with('id', $id);
	}

	public function postOutrasInfos()
	{
		
		$id = Input::get('id');
		
		$redirect = Redirect::to('candidato/meusdados/outras-infos');	
		
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		// if($outrasinfosid == '')
		// {
		// 	$outrainfo = new OutraInfo;
		// 	$outrainfo->usuario_id = Auth::user()->id;
		// 	$outrainfo->info = $info;
		// 	$outrainfo->save();
		// }
		// else
		// {
		// 	$outrainfo = OutraInfo::find($outrasinfosid);
		// 	$outrainfo->usuario_id = Auth::user()->id;
		// 	$outrainfo->info = $info;
		// 	$outrainfo->save();
		// }
		$sem_outras_infos = Input::has('sem_outras_infos') ? Input::get('sem_outras_infos') : null;

		$outrasinfos 					= Auth::user()->outrasinfos ?: new OutraInfo;
		// $outrasinfos->info 				= $info;
		$outrasinfos->sem_outras_infos 	= $sem_outras_infos;
		Auth::user()->outrasinfos()->save($outrasinfos);

		if(isset($premios) && sizeof($premios) > 0)
		{
			foreach($premios as $frmPremio)
			{
				if($frmPremio['id'] == '')
				{
					$premio = new Premio;
					$premio->usuario_id = $id;
					$premio->nome         = $frmPremio['nome'];
					$premio->save();
				}
				else
				{
					$premio = Premio::find($frmPremio['id']);
					$premio->usuario_id = $id;
					$premio->nome         = $frmPremio['nome'];
					$premio->save();
				}
			}
		}

		if(isset($candidaturas) && sizeof($candidaturas) > 0)
		{
			foreach($candidaturas as $frmCandidatura)
			{
				if($frmCandidatura['id'] == '')
				{
					$candidatura = new CandidaturaPrevia;
					$candidatura->usuario_id = $id;
					$candidatura->nome         = $frmCandidatura['nome'];
					$candidatura->data         = Formatter::stringToDate($frmCandidatura['data']);
					$candidatura->resultado    = $frmCandidatura['resultado'];
					$candidatura->save();
				}
				else
				{
					$candidatura = CandidaturaPrevia::find($frmCandidatura['id']);
					$candidatura->usuario_id = $id;
					$candidatura->nome         = $frmCandidatura['nome'];
					$candidatura->data         = Formatter::stringToDate($frmCandidatura['data']);
					$candidatura->resultado    = $frmCandidatura['resultado'];
					$candidatura->save();
				}
			}
		}

		if(isset($outrascandidaturas) && sizeof($outrascandidaturas) > 0)
		{
			foreach($outrascandidaturas as $frmOutraCandidatura)
			{
				if($frmOutraCandidatura['id'] == '')
				{
					$outracandidatura = new OutraCandidatura;
					$outracandidatura->usuario_id = $id;
					$outracandidatura->nome         = $frmOutraCandidatura['nome'];
					$outracandidatura->save();
				}
				else
				{
					$outracandidatura = OutraCandidatura::find($frmOutraCandidatura['id']);
					$outracandidatura->usuario_id = $id;
					$outracandidatura->nome         = $frmOutraCandidatura['nome'];
					$outracandidatura->save();
				}
			}
		}

		//Proficiencia ingles
	    if (Input::hasFile('proficienciaInglesFile'))
	    {
	      	$img = Input::file('proficienciaInglesFile');
			$dst_file = 'usuarios/' . $id . '/documentos/proficienciaIngles/';
	        $imginfo = $this->uploadImage($img, $dst_file);

	        if($imginfo)
	        {
		        $imagem = new Imagem;
		        $imagem->titulo  			= $titulo;
		        $imagem->nome    			= $imginfo['filename'];
		        $imagem->caminho 			= $imginfo['destinationPath'];
		        $imagem->imagemMorph_id   	= $id;
		        $imagem->imagemMorph_type 	= 'ProficienciaIngles';

		        $imagem->save();
		    }
	    }

		$mensagem = 'Suas outras informações foram salvas com sucesso!';
		Ulog::Novo("Salvou outras informações", "Usuário salvou Outras informações");

		return Redirect::to("candidato/meusdados/outras-infos/$id")->with('success',array(1 => $mensagem));
	}

	public function postApagarOutrasInfos()
	{

		$idPremio           = Input::get('idPremio');
		$idCandidatura      = Input::get('idCandidatura');
		$idOutraCandidatura = Input::get('idOutraCandidatura');

		if(isset($idPremio) && $idPremio != '')
		{
			$premio = Premio::find($idPremio);

			$premio->delete();
		}

		if(isset($idCandidatura) && $idCandidatura != '')
		{
			$candidatura = CandidaturaPrevia::find($idCandidatura);

			$candidatura->delete();
		}

		if(isset($idOutraCandidatura) && $idOutraCandidatura != '')
		{
			$outra_candidatura = OutraCandidatura::find($idOutraCandidatura);

			$outra_candidatura->delete();
		}
	}

}