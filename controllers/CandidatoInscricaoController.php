<?php

/** 
* Inscrição para o Mestrado/Doutorado
*/
class CandidatoInscricaoController extends \BaseController
{

	public function getDadosInscricao()
	{
		//variavel que verifica se pode editar os "dados de inscrição" (só se for ADMIN)
		$permitSubmit = false;
		if($id && Request::is('adm/*'))
		{
			$this->id = $id;
			$permitSubmit = true;
			
		} 
// 		elseif($id) {
// 			$this->id = $id;
// 			$permitSubmit = true;
// 		}
		
	}
	
	public function getCandidatarse()
	{
	
		$tipo = Input::get('tipo');

		if($tipo == 'm')
		{
			$cursos = array('MSC' => 'Mestrado');
			$curso_sigla = 'MSC';
			$curso_nome = 'Mestrado';

		}
		else
		{
			$cursos = array('DSC' => 'Doutorado');
			$curso_sigla = 'DSC';
			$curso_nome = 'Doutorado';
		}

		//check se o usuario ja fez inscrição nesse curso nesse periodo
		$periodo_atual = Whelper::ChecaPeriodo();
		$hoje = date('Y-m-d');
		if($periodo_atual->status != 2 || ($hoje < $periodo_atual->data_hora_inicio || $periodo_atual->data_hora_fim < $hoje)){
			return Redirect::to('panel')->with('warning', array('O período de inscrição não está aberto'));
		}
		$inscricao = Inscricao::WHERE('curso','=',$curso_sigla)->WHERE('periodo_id','=',$periodo_atual->id)->WHERE('usuario_id','=',Auth::user()->id)->get();
		if($inscricao->count() > 0){
			if($tipo == 'm'){
				return Redirect::to('panel')->with('warning', array('Você já se candidatou em mestrado para este período'));
			} else {
				return Redirect::to('panel')->with('warning', array('Você já se candidatou em doutorado para este período'));
			}
		}

		if($tipo == 'm')
		{
			// verifica se há vagas em alguma área de mestrado
			$periodoAreaMestrado = DB::table('periodos_areas_mestrado')->where('periodo_id', $periodo_atual->id)->where('num_vagas','>','0')->count();

			if($periodoAreaMestrado == 0){
				return Redirect::to('panel')->with('warning', array('Não há vagas para o mestrado neste período de inscrição'));
			}
		}
		else
		{	
			// verifica se há vagas em alguma área de doutorado
			$periodoAreaDoutorado = DB::table('periodos_areas_doutorado')->where('periodo_id', $periodo_atual->id)->where('num_vagas','>','0')->count();

			if($periodoAreaDoutorado == 0){
				return Redirect::to('panel')->with('warning', array('Não há vagas para o doutorado neste período de inscrição'));
			}
		}	
		
		//checa se todos os dados pessoais já foram preenchidos
		$areas_q = array();
		$areas_q['dados_pessoais'] = Auth::user()->toArray();
		if(empty($areas_q['dados_pessoais']['estrangeiro'])){
			//brasileiro			  			
			unset($areas_q['dados_pessoais']['passaporte']);
			
			// Certificado Militar � opcional
 			unset($areas_q['dados_pessoais']['certmilitar']);
			unset($areas_q['dados_pessoais']['certificado_militar_arquivo']);
			unset($areas_q['dados_pessoais']['certificado_militar_verso_arquivo']);
			unset($areas_q['dados_pessoais']['certificado_militar_img']);
			unset($areas_q['dados_pessoais']['certificado_militar_verso_img']);
			unset($areas_q['dados_pessoais']['certmilitarcategoria']);
			unset($areas_q['dados_pessoais']['certmilitarorgao']);
			unset($areas_q['dados_pessoais']['certmilitaruf']);
			unset($areas_q['dados_pessoais']['certmilitaremissao']);
			
			// Titulo de Eleitor � Opcional
			unset($areas_q['dados_pessoais']['tituloeleitor']);
			unset($areas_q['dados_pessoais']['titulo_eleitor_arquivo']);
			unset($areas_q['dados_pessoais']['titulo_eleitor_verso_arquivo']);
			unset($areas_q['dados_pessoais']['titulo_eleitor_img']);
			unset($areas_q['dados_pessoais']['titulo_eleitor_verso_img']);
			unset($areas_q['dados_pessoais']['tituloeleitorzona']);
			unset($areas_q['dados_pessoais']['tituloeleitorsecao']);
			unset($areas_q['dados_pessoais']['tituloeleitoruf']);
			unset($areas_q['dados_pessoais']['tituloeleitoremissao']);



		} else {
			//estrangeiro
			unset($areas_q['dados_pessoais']['ident'],
			  $areas_q['dados_pessoais']['expedicao'],
			  $areas_q['dados_pessoais']['orgaoexped'],
			  $areas_q['dados_pessoais']['estexped'],
			  $areas_q['dados_pessoais']['cpf'],
			  $areas_q['dados_pessoais']['identidade_arquivo'],
			  $areas_q['dados_pessoais']['identidade_verso_arquivo'],
			  $areas_q['dados_pessoais']['estado_expedidor_identidade'],
			  $areas_q['dados_pessoais']['cpf_arquivo'],
			  $areas_q['dados_pessoais']['identidade_img'],
			  $areas_q['dados_pessoais']['identidade_verso_img']
		  	);

		}
		if($areas_q['dados_pessoais']['sexo'] == "Feminino"){
			unset($areas_q['dados_pessoais']['certmilitar']);
			unset($areas_q['dados_pessoais']['certificado_militar_arquivo']);
			unset($areas_q['dados_pessoais']['certificado_militar_verso_arquivo']);
			unset($areas_q['dados_pessoais']['certificado_militar_img']);
			unset($areas_q['dados_pessoais']['certificado_militar_verso_img']);
			unset($areas_q['dados_pessoais']['certmilitarcategoria']);
			unset($areas_q['dados_pessoais']['certmilitarorgao']);
			unset($areas_q['dados_pessoais']['certmilitaruf']);
			unset($areas_q['dados_pessoais']['certmilitaremissao']);
		}
		unset($areas_q['dados_pessoais']['id'],
		  	$areas_q['dados_pessoais']['id_joomla'],
		  	$areas_q['dados_pessoais']['id_ufrj_old'],
		  	$areas_q['dados_pessoais']['estrangeiro'],
			$areas_q['dados_pessoais']['poscomp_pontos'],
			$areas_q['dados_pessoais']['poscomp_nota_tec'],
			$areas_q['dados_pessoais']['poscomp_nota_fun'],
			$areas_q['dados_pessoais']['poscomp_nota_mat'],
			$areas_q['dados_pessoais']['numdeps'],
			$areas_q['dados_pessoais']['numfilhos'],
			$areas_q['dados_pessoais']['idadefilhos'],
			$areas_q['dados_pessoais']['situacao'],
			$areas_q['dados_pessoais']['nomepai'],
			$areas_q['dados_pessoais']['created_at'],
			$areas_q['dados_pessoais']['updated_at']
		);
		$anoAtual = date('Y');
		// candidatos sexo masculino com mais do que 45 anos certificado militar não é obrigatório
		$newDate = $anoAtual - 45;
		if(!empty($areas_q['dados_pessoais']['nascimento']) && $areas_q['dados_pessoais']['nascimento'] != '0000-00-00'){
			$date = DateTime::createFromFormat("d/m/Y", $areas_q['dados_pessoais']['nascimento']);
			if($date->format("Y") <= $newDate){
				unset($areas_q['dados_pessoais']['certmilitar']);
				unset($areas_q['dados_pessoais']['certificado_militar_arquivo']);
				unset($areas_q['dados_pessoais']['certificado_militar_verso_arquivo']);
				unset($areas_q['dados_pessoais']['certificado_militar_img']);
				unset($areas_q['dados_pessoais']['certificado_militar_verso_img']);
				unset($areas_q['dados_pessoais']['certmilitarcategoria']);
				unset($areas_q['dados_pessoais']['certmilitarorgao']);
				unset($areas_q['dados_pessoais']['certmilitaruf']);
				unset($areas_q['dados_pessoais']['certmilitaremissao']);
			}
		}
		// candidatos com mais do que 65 anos título de eleitor não é obrigatório
		$newDate = $anoAtual - 65;
		if(!empty($areas_q['dados_pessoais']['nascimento']) && $areas_q['dados_pessoais']['nascimento'] != '0000-00-00'){
			$date = DateTime::createFromFormat("d/m/Y", $areas_q['dados_pessoais']['nascimento']);
			if($date->format("Y") <= $newDate){
				unset($areas_q['dados_pessoais']['tituloeleitor']);
				unset($areas_q['dados_pessoais']['titulo_eleitor_arquivo']);
				unset($areas_q['dados_pessoais']['titulo_eleitor_verso_arquivo']);
				unset($areas_q['dados_pessoais']['titulo_eleitor_img']);
				unset($areas_q['dados_pessoais']['titulo_eleitor_verso_img']);
				unset($areas_q['dados_pessoais']['tituloeleitorzona']);
				unset($areas_q['dados_pessoais']['tituloeleitorsecao']);
				unset($areas_q['dados_pessoais']['tituloeleitoruf']);
				unset($areas_q['dados_pessoais']['tituloeleitoremissao']);
			}
		}
		foreach ($areas_q['dados_pessoais'] as $area) {
			if(empty($area)){
				return Redirect::to('panel')->with('warning', array('Você precisa preencher todos os seus dados pessoais antes de se candidatar.'));
			}
		}

		$imagens = Imagem::where('imagemMorph_id','=', Auth::user()->id)->where('imagemMorph_type','=','ProficienciaIngles')->where('caminho','like','%/proficienciaIngles%')->get();
		if($imagens->isEmpty()){
			return Redirect::to('panel')->with('warning', array('Você precisa fazer upload de proficiência em inglês na aba de "Outras Informações".'));
		}
		

		//start with empty form to create new Article
		if($tipo == 'm') {
			$concordo     = 'Declaro conhecer e concordar com as regras do Processo Seletivo de Ingresso no Mestrado Acadêmico do PESC (Edital UFRJ Nº 234/2014).';
		} else {
			$concordo     = 'Declaro conhecer e concordar com as regras do Processo Seletivo de Ingresso no Doutorado do PESC (Edital UFRJ Nº 234/2014).';
		}
		$dadosatualizados = 'Declaro que meus dados estão atualizados.';
		$cvatualizado     = 'Declaro que meu Currículo Lattes está atualizado.';
		$veracidade       = 'Declaro que meus dados foram conferidos e que correspondem à verdade.';
		$comunicacoes     = 'Declaro estar ciente que todas as comunicações do PESC serão feitas através de meu email, sendo de minha responsabilidade mantê-lo atualizado e consultá-lo periodicamente.';
		//Documentos foi removido do formulário logo abaixo por pedido da UFRJ
		$documentos       = 'Declaro estar ciente que minha inscrição só será válida com a entrega no PESC dos documentos exigidos até a data de encerramento das inscrições.';

		$form = DataForm::source(new Inscricao);

		//add fields to the form
		$form->select('curso','Curso')->options($cursos);
		$form->text('poscomp','Inscrição no POSCOMP/GRE');
		$form->select('regime','Regime')->options(array('PARC'=>'Parcial','INT'=>'Integral'));
		$form->add('bolsa','Solicita Bolsa de Estudos?','radiogroup')->option(1,'Sim')->option(0,'Não');
		// $form->text('cvlattes','URL do Currículo Lattes');
		// $form->add('cvlattes','URL do Currículo Lattes <span class="text-danger">*</span>','text')->rule('required');
		$form->add('vinculo','Manterá vínculo empregatício durante estudos?','radiogroup')->option(1,'Sim')->option(0,'Não');
		$form->text('instituicao','Nome da Instituição conveniada');
		$form->add('dinter','Faz parte do projeto dinter?','radiogroup')->option(1,'Sim')->option(0,'Não');


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
		// debug($areas);
		//$areas = Area::lists('nome','id');
		// debug($provasPesquisa);

		$form->select('area1','Área de Concentração 1 *')->options($areas);

		if($tipo == 'm') {
			// $areas[0] = 'Nenhuma';
			$form->select('area2','Área de Concentração 2')->options($areas);
		}

		$form->add('concordo', $concordo,'checkbox')->attr('required', 'required');
		$form->add('dadosatualizados', $dadosatualizados,'checkbox')->attr('required', 'required');
		$form->add('cvatualizado', $cvatualizado ,'checkbox')->attr('required', 'required');
		$form->add('veracidade', $veracidade, 'checkbox')->attr('required', 'required');
		$form->add('comunicacoes', $comunicacoes,'checkbox')->attr('required', 'required');
		//$form->add('documentos',$documentos,'checkbox')->attr('required', 'required');

		$form->build();

//		$form->close();

		return View::make('painel_candidato.inscricao.candidatar_se', compact('areas','provasPesquisa'))->with('form',$form);
	}

	public function postCandidatarse()
	{
		// dd(Input::all());

		if(Input::has('tipo'))
		{
			$inscricao = new Inscricao;

			if(Input::get('tipo') == 'm')
			{
				$inscricao->curso = 'MSC';

				if(!empty(Input::get('area2')))
					$areas = array(Input::get('area1'), Input::get('area2'));
				else
					$areas = array(Input::get('area1'));

				$return = 'candidato/inscricao/status-candidatura?tipo=m';
			}
			else
			{
				$inscricao->curso = 'DSC';

				$areas = array(Input::get('area1'));

				$return = 'candidato/inscricao/status-candidatura?tipo=d';
			}

			$inscricao->poscomp       = Input::get('poscomp');
			$inscricao->regime        = Input::get('regime');
			$inscricao->url_cv_lattes = Input::get('cvlattes');
			$inscricao->bolsa 		  = Input::get('bolsa');
			$inscricao->status_id		  = 2;
			$inscricao->periodo_id    = Whelper::ChecaPeriodo()->id;

			// $inscricao->save();
			$inscricaoOld = Inscricao::WHERE('curso','=',$inscricao->curso)->WHERE('periodo_id','=',$inscricao->periodo_id)->WHERE('usuario_id','=',Auth::user()->id)->get();
			if($inscricaoOld->count() > 0){
				if($inscricao->curso == 'MSC'){
					return Redirect::to('panel')->with('warning', array('Você clicou várias vezes em se cadastrar em mestrado.'));
				} else {
					return Redirect::to('panel')->with('warning', array('Você clicou várias vezes em se cadastrar em doutorado.'));
				}
			}
			$inscricaoSaved = Auth::user()->inscricoes()->save($inscricao);
			$inscricaoSaved->areas()->sync($areas);
			$inscricaoSaved->status()->attach(2, array('anotacoes' => 'Inscrição em edição'));
			
			$candidato_id = Auth::user()->id;
			
			if(Input::hasFile('filePlanodePesquisa'))
			{
				$inscArea = AreaInscricao::where('inscricao_id','=',$inscricaoSaved->id)->where('area_id','=',Input::get('area1'))->get()->first();
				
				if ($inscArea)
				{				
					$img = Input::file('filePlanodePesquisa');			
					
					$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricaoSaved->id . '/areas/' . $inscArea->id . '/');												 					

					if($imginfo)
					{
						$imagem = new Imagem;
						
						$imagem->nome    = $imginfo['filename'];
						$imagem->caminho = $imginfo['destinationPath'];
						$imagem->titulo  = "Plano de pesquisa";
						//$imagem->imagemMorph_type = "Plano de pesquisa";
						$imagem->imagemMorph_type = 'AreaInscricao';
						$imagem->imagemMorph_id = $inscArea->id;						

						$inscArea->imagens()->save($imagem);
					}
				}
			}
			if(Input::hasFile('filePlanodePesquisa2'))
			{				
				$inscArea = AreaInscricao::where('inscricao_id','=',$inscricaoSaved->id)->where('area_id','=',Input::get('area2'))->get()->first();
				
				if ($inscArea)
				{	
					//$imginfo = $this->uploadImage($img, 'candidatos/planoPesquisa/'.Auth::user()->id);
					$img = Input::file('filePlanodePesquisa2');
					$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricaoSaved->id . '/areas/' . $inscArea->id . '/');

					if($imginfo)
					{
						$imagem = new Imagem;						
						$imagem->nome    = $imginfo['filename'];
						$imagem->caminho = $imginfo['destinationPath'];
						$imagem->titulo  = "Plano de pesquisa";
						//$imagem->imagemMorph_type = "Plano de pesquisa";
						$imagem->imagemMorph_type = 'AreaInscricao';
						$imagem->imagemMorph_id = $inscArea->id;						

						$inscArea->imagens()->save($imagem);
					}
				}
			}
			if(Input::hasFile('fileVinculo'))
			{
				$img = Input::file('fileVinculo');
				$imginfo = $this->uploadImage($img, 'usuarios/' . $candidato_id . '/inscricoes/' . $inscricaoSaved->id . '/');
				//$imginfo = $this->uploadImage($img, 'candidatos/cartaConcordanciaEmpresa/'.Auth::user()->id);

		        if($imginfo)
		        {
			        $imagem = new Imagem;
			        $imagem->titulo  = '';
			        $imagem->nome    = $imginfo['filename'];
			        $imagem->caminho = $imginfo['destinationPath'];
			        $imagem->titulo  = "Carta de Concordância da Empresa";
			        $imagem->imagemMorph_type = "Carta de Concordância da Empresa";

			        $inscricaoSaved->imagens()->save($imagem);
			    }
			}


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


			Ulog::Novo("Candidatura {$inscricao->curso}", "Usuário se candidatou em {$inscricao->curso}");

			return Redirect::to($return);
		}
	}

	public function getDadosPreenchidos()
	{
		$candidato = Usuario::with('formacoes','experiencias')->find(Auth::user()->id);
		// $periodo = Periodo::where('habilitado','=',1)->first();
		$periodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
		return View::make('painel_candidato.inscricao.dados_preenchidos')->with('candidato', $candidato)
																		 ->with('periodo', $periodo);
	}

	public function getDadosCsv()
	{
		//$candidato = Usuario::with('formacoes')->find(Auth::user()->id);

		$export = Excel::create('dados', function($excel) {

		    $excel->sheet('Sheetname', function($sheet) {

		    	//$candidato = Usuario::find(Auth::user()->id);
		        //$sheet->fromArray($candidato->toArray());

		        // $sheet->fromArray(array(array('data1', 'data2'),
							   //          array('data3', 'data4')));

				$candidato = Usuario::with('formacoes','experiencias')->find(Auth::user()->id);
		    	$sheet->loadView('painel_candidato.inscricao.csv', array('candidato' => $candidato));

		    });

		})->export('csv');

		return $export;
	}



	public function getDadosPdf()
	{
		$candidato = Usuario::with('formacoes','experiencias')->find(Auth::user()->id);
		$periodo = WHelper::ChecaPeriodo();
		if($periodo)
		{
			// return View::make('painel_candidato.inscricao.pdf')->with('candidato', $candidato)
			// 													->with('periodo', $periodo);
			// exit;
			$pdf =  PDF::loadView('painel_candidato.inscricao.pdf', compact('candidato','periodo'));
			return $pdf->stream();
		}
		else
		{
			return Redirect::to('panel')->with('danger', array('O período de inscrição não esta aberto. Acesso negado.'));
		}
		//return $pdf->download($candidato->nome. '_dados_preenchidos.pdf');
	}

	public function getStatusCandidatura()
	{

		if(Input::has('tipo'))
		{														
			if(Input::get('tipo') == 'd')
			{
				$status_historico = Auth::user()
										->doutorado;
				if($status_historico)
				{
					$status_historico = $status_historico->status()
										->paginate(10);
				}

			}
			else
			{
				$status_historico = Auth::user()
										->mestrado;
				if($status_historico)
				{
					$status_historico = $status_historico->status()
										->paginate(10);
				}

			}
		}

		if(!$status_historico)
		{
			return Redirect::to('panel')->with('warning', array('Você ainda não se candidatou a este Curso'));
		}

		$paginate = $status_historico->links();
		$rows = $status_historico->toArray();
		$rows = $rows['data'];		

		return View::make('painel_candidato.inscricao.status_candidatura')
				   ->with('rows', $rows)
				   ->with('paginate', $paginate);
	}

	public function getImprimir()
	{
		$candidato = Usuario::with('formacoes','experiencias')->find(Auth::user()->id);
		$periodo = Whelper::ChecaPeriodo();
		return View::make('painel_candidato.inscricao.imprimir')->with('candidato', $candidato)
																->with('periodo', $periodo);
	}

	public function postImprimir()
	{

	}

	public function getStatusLinhasMestrado()
	{
		return $this->StatusLinhas('MSC');
	}

	public function getStatusLinhasDoutorado()
	{
		return $this->StatusLinhas('DSC');	
	}

	private function StatusLinhas($tipo)
	{
		$periodo_atual = Whelper::ChecaPeriodo();

		if(!$periodo_atual)
		{
			return Redirect::to('panel')->with('info', ['Nenhum periodo em andamento no momento.']);
		}

		$inscricao = Auth::user()->inscricao_atual($periodo_atual, $tipo)->first();

        if(!$inscricao)
        {
            return Redirect::to('panel')->with('warning', ['Inscrição não encontrada']);
        }

        if(Auth::user()->id != $inscricao->usuario_id)
        {
            if(!Session::has('perfil') || Session::get('perfil') != 1)
            {
                return Redirect::to("panel")->with('danger', array('Acesso negado.'));
            }
        }

        return View::make('painel_professor.inscricao.situacao_linhas_lista', compact('inscricao'));
	}
	
	/**
	 * Notas do candidato de todas candidaturas realizadas
	 */
	public function getNotasCandidatura()
	{						
		if(Input::has('id') && Session::has('perfil') && Session::get('perfil') == 1)
		{
			$this->id = Input::get('id');
		} else 
		{
			$this->id = Auth::user()->id;			
		}
			
		if(Input::has('tipo'))
		{
			$notas = array();
					
			$candidato_id = $this->id;
			$periodo_atual = Whelper::ChecaPeriodo();													
					
			$inscricao = Inscricao::where('usuario_id','=',$candidato_id)->get();	
			
			if(Input::get('tipo') == 'd')
			{
				// para cada inscrição do candidato
				foreach($inscricao as $insc)
				{
					// notas das provas
					$notas_insc = Inscricao::with('periodo')
						->with(array('provas_doutorado'))->find($insc->id);				
				
					
					if (count($notas_insc->provas) > 0 && $notas_insc->curso == 'DSC')
					{						
						array_push ($notas, $notas_insc);
					}
				}
				
			}
			else
			{		
				foreach($inscricao as $insc)
				{
					$notas_insc = Inscricao::with('periodo')
						->with(array('provas_mestrado'))->find($insc->id);
					
					if (count($notas_insc->provas) > 0 && $notas_insc->curso == 'MSC')
					{
						array_push ($notas, $notas_insc);
					}
				}
			}
		}
		//dd($notas);
		
		if(count($notas) == 0)
		{
			return Redirect::to('panel')->with('warning', array('Você ainda não possui nenhuma candidatura valida'));
		}

		return View::make('painel_candidato.inscricao.notas')
				   	->with('notas', $notas)
					->with('tipo', Input::get('tipo'));
	}
	
	
}
