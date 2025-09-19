<?php
/**
 * Controller para tela de alteração dos dados de inscrição.
 * Somente acessível para Admin.
 * Caso o candidato haja mais de uma inscição, a mais recente será exibida
 */
class AdminInscricaoController extends BaseController {

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

	/**
	 * Busca os dados da última inscrição de um candidato para serem editadas por Admin
	 */
	public function getDadosInscricao($id = false)
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
		$candidato         = Usuario::find($this->id);
		
		// retorna última inscrição do candidato (mais recente)
		//$inscricoes = Inscricao::WHERE('periodo_id','=',$periodo_atual->id)->WHERE('usuario_id','=',$this->id)->get();
		$inscricoes = Inscricao::WHERE('usuario_id','=',$this->id)->ORDERBY('periodo_id')->get();
		$inscricao = $inscricoes->last();
		
		// retorna as áreas da inscrição selecionada acima
		$inscricao_areas = AreaInscricao::WHERE('inscricao_id','=',$inscricao->id)->ORDERBY('id')->get();

		
		if ($inscricao->curso == 'MSC')
		{
			$cursos = array('MSC' => 'Mestrado');
			$curso_sigla = 'MSC';
			$curso_nome = 'Mestrado';
			$tipo = 'm';
		}
		else
		{
			$cursos = array('DSC' => 'Doutorado');
			$curso_sigla = 'DSC';
			$curso_nome = 'Doutorado';
			$tipo = 'd';			
		}

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
			if($inscricao && $inscricao->status->last()->id != 1 && $inscricao->status->last()->id != 4){
				$permitSubmit = false;
			}
		}
		
		// cria uma lista com as áreas do período atual
		$periodo = Whelper::ChecaPeriodo();
		$areas = array();
		$provasPesquisa = array();
		
		if($periodo)
		{
			if($tipo == 'm')
			{
				$areas_q = $periodo->areas_mestrado()->get();
				$provas_q = $periodo->provas_mestrado()->get();
			}
			else
			{
				$areas_q = $periodo->areas_doutorado()->get();
				$provas_q = $periodo->provas_doutorado()->get();
			}

			foreach($areas_q as $area)
			{
				if($area->pivot->num_vagas > 0)
				{
					$areas[$area->id] = $area->nome . ' ('.$area->pivot->num_vagas.')';
				}
			}
			
			
			foreach($provas_q as $provas)
			{
				if($provas->prova_id == 5){
					$provasPesquisa[] = $provas->area_id;
				}
			}
		}				
		
			
		// cria um novo DataForm para os campos da inscrição
		$form = DataForm::source(new Inscricao);
		
		// adiciona os campos para o formulário
		$form->select('curso','Curso')->options($cursos);
		$form->select('area1','Area de Concentração 1')->options($areas);
		$areas = array(0=>"Nenhuma") + $areas;
		$form->select('area2','Area de Concentração 2')->options($areas);
		$form->text('poscomp','Inscrição no POSCOMP/GRE');
		$form->select('regime','Regime')->options(array('PARC'=>'Parcial','INT'=>'Integral'));	
		$form->add('bolsa','Solicita Bolsa de Estudos?','radiogroup')->option(1,'Sim')->option(0,'Não');
		//$form->text('cvlattes','URL do Currículo Lattes');
		$form->add('cvlattes','URL do Currículo Lattes <span class="text-danger">*</span>','text')->rule('required');
		$form->add('vinculo','Manterá vínculo empregatício durante estudos?','radiogroup')->option(1,'Sim')->option(0,'Não');
		$form->text('instituicao','Nome da Instituição conveniada');

		$form->add('filePlanoPesquisa','Plano de Pesquisa', 'file')->rule('mimes:pdf');
		$form->add('filePlanoPesquisa2','Plano de Pesquisa', 'file')->rule('mimes:pdf');
     		//->move('uploads/pdf/');		
		
		// muda o valor default dos campos de acordo com a inscrição do candidato
		$form->field('area1')->value = (string) $inscricao_areas[0]->area_id;
		
		if (count($inscricao_areas) > 1)
		{
			$form->field('area2')->value = (string) $inscricao_areas[1]->area_id;
		}
		
		if ($inscricao->regime == 'INT')
		{
			$form->field('regime')->value = 'INT';
		}	
		
		$form->field('poscomp')->value = $inscricao->poscomp;
		
		$form->field('cvlattes')->value = $inscricao->url_cv_lattes;
		
		if ($inscricao->bolsa == 'S' || $inscricao->bolsa == 1)
		{
			$form->field('bolsa')->value = 1;			
		}
		else
		{
			$form->field('bolsa')->value = 0;
		}
		
		if ($inscricao->trabalha == 'S' || $inscricao->trabalha == 1)
		{
			$form->field('vinculo')->value = 1;			
		}
		else
		{
			$form->field('vinculo')->value = 0;
		}
		$form->field('instituicao')->value = $inscricao->instituicaoconv;			
		
				
		$form->build();
		
		return View::make('adm.inscricao.dados_candidato', compact('areas','provasPesquisa'))->with('candidato',$candidato)
															->with('tipo', $tipo)
															->with('inscricao',$inscricao)
														 	->with('imagens', $imagens)
														 	->with('permitSubmit', $permitSubmit)
															->with('form',$form);;
	}

	/**
	 * Escreve os dados de inscrição do candidato no BD
	 */
	public function postDadosInscricao()
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

		//dd(Input::all());
		//dd($inputs);


		if(Input::has('inscricao_id'))
		{
			//$inscricao = new Inscricao;
			$inscricao_id = Input::get('inscricao_id');
			
			$inscricao = Inscricao::find($inscricao_id);

			if(Input::get('tipo') == 'm')
			{
				$return = 'professor/inscricao/lista-candidatos?tipo=m';
			}
			else
			{
				$return = 'professor/inscricao/lista-candidatos?tipo=d';
			}

			$inscricao->poscomp       = Input::get('poscomp');
			$inscricao->regime        = Input::get('regime');
			$inscricao->url_cv_lattes = Input::get('cvlattes');
			$inscricao->bolsa 		  = Input::get('bolsa');
			//$inscricao->periodo_id    = Whelper::ChecaPeriodo()->id;
			
			//Auth::user()->inscricoes()->save($inscricao);
			// salva os dados da inscrição
			if ($inscricao)
				$inscricao->save();
			
			/** ÁREAS **/
			
			// checa se houve mudança nas áreas					
			$inscricao_areas = AreaInscricao::WHERE('inscricao_id','=',$inscricao->id)->ORDERBY('id')->get();
			$insc1 = AreaInscricao::find($inscricao_areas[0]->id);
			$insc2 = null;
			
			if (Input::get('area1') != $inscricao_areas[0]->area_id)
			{					
				$insc1->status_id = 2; // volta status para edição encerrada
				$insc1->area_id = Input::get('area1');		
				$insc1->save();
			}
			
			if (count($inscricao_areas) > 1)
			{
				$insc2 = AreaInscricao::find($inscricao_areas[1]->id);

				if (Input::get('area2') == 0 || Input::get('area1') == Input::get('area2'))
				{
					// apaga segunda inscrição se selecionou Nenhuma ou igual a primeira opção
					$insc2->delete();
				}
				else
				{
					// altera segunda inscrição	
					$insc2->area_id = Input::get('area2');
					$insc2->save();
				}								
			}			
			elseif (Input::get('area2') != 0 && Input::get('area1') != Input::get('area2'))
			{
				// adiciona nova segunda inscrição
				$newarea2 = new AreaInscricao;
				$newarea2->inscricao_id = $insc1->inscricao_id;
				$newarea2->periodo_id = $insc1->periodo_id;
				$newarea2->status_id = 2; // edição encerrada
				$newarea2->area_id = Input::get('area2');
				$newarea2->save();
				$insc2 = $newarea2;
			}
								
			/** PLANOS DE PESQUISA **/
			
			$candidato_id = Input::get('candidato_id');
			
			if(Input::hasFile('filePlanoPesquisa'))
			{			
				$img = Input::file('filePlanoPesquisa');
				//$imginfo = $this->uploadImage($img, 'usuarios/'.$candidato_id.'/'.$insc1->id);
				$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricao->id . '/areas/' . $insc1->area_id . '/');												 					
				//$imginfo = $this->uploadImage($img, 'usuarios/');

		        if($imginfo)
		        {
			        $imagem = new Imagem;
			        $imagem->titulo  = '';
			        $imagem->nome    = $imginfo['filename'];
			        $imagem->caminho = $imginfo['destinationPath'];
			        $imagem->titulo  = "Plano de pesquisa";
			        $imagem->imagemMorph_type = "AreaInscricao";

			        $insc1->imagens()->save($imagem);
			    }
			}			
			if(Input::hasFile('filePlanoPesquisa2') && $insc2 != null)
			{
				$img = Input::file('filePlanoPesquisa2');
				//$imginfo = $this->uploadImage($img, 'usuarios/'.$candidato_id.'/'.$insc2->id);
				$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricao->id . '/areas/' . $insc2->id . '/');												 					

		        if($imginfo)
		        {
			        $imagem = new Imagem;
			        $imagem->titulo  = '';
			        $imagem->nome    = $imginfo['filename'];
			        $imagem->caminho = $imginfo['destinationPath'];
			        $imagem->titulo  = "Plano de pesquisa";
			        $imagem->imagemMorph_type = "AreaInscricao";

			        $insc2->imagens()->save($imagem);
			    }
			}
			
			

			
			if(Input::hasFile('fileVinculo'))
			{
				$img = Input::file('fileVinculo');
				//$imginfo = $this->uploadImage($img, 'candidatos/cartaConcordanciaEmpresa/'.Auth::user()->id);
				//$imginfo = $this->uploadImage($img, 'usuarios/'.$candidato_id.'/'.$insc1->id);
				$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricao->id . '/');

		        if($imginfo)
		        {
			        $imagem = new Imagem;
			        $imagem->titulo  = '';
			        $imagem->nome    = $imginfo['filename'];
			        $imagem->caminho = $imginfo['destinationPath'];
			        $imagem->titulo  = "Carta de Concordância da Empresa";
			        $imagem->imagemMorph_type = "Carta de Concordância da Empresa";

			        $inscricao->imagens()->save($imagem);
			    }
			}
						// done up to here
			return Redirect::to($return);
			
			$inscricao->areas()->sync($areas);
			$inscricao->status()->attach(2, array('anotacoes' => 'Inscrição em edição'));

			$periodo_ativo = Whelper::ChecaPeriodo();

			if($periodo_ativo)
			{
				$tipo = Input::get('tipo');

				if($tipo == 'm')
				{
					$provas = $periodo_ativo->provas_mestrado()->whereIn('area_id', $areas)->get();

					if(!$provas->isEmpty())
					{
						foreach($provas as $prova)
						{
							$provas_sync[] = $prova->id;
						}
						$inscricao->provas_mestrado()->sync($provas_sync);
					}
				}
				else
				{
					$provas = $periodo_ativo->provas_doutorado()->whereIn('area_id', $areas)->get();

					if(!$provas->isEmpty())
					{
						foreach($provas as $prova)
						{
							$provas_sync[] = $prova->id;
						}
						$inscricao->provas_doutorado()->sync($provas_sync);
					}
				}

			}


			Ulog::Novo("Edição Candidatura {$inscricao->curso}", "Usuário se candidatou em {$inscricao->curso}");

			
		}
		else
		{
			//$return = 'professor/inscricao/lista-candidatos?tipo=m';
		}
		
		return Redirect::to($return);
	
	}

	public function upload($id)
	{
		  $file 	 = Input::file('anexo');
		  $dir_db	 = '/uploads/candidatos/fotos/';
		  $directory = public_path() . $dir_db;
	      $extension = $file->getClientOriginalExtension();
	      $filename  = sha1($file->getClientOriginalName() . time().time()) .".$extension";

	      $upload_success = $file->move($directory, $filename);

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

}