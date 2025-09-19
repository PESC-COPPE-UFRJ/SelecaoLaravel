<?php

// debug(Whelper::ChecaPeriodo());

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function()
{
	Route::get('panel',function(){
		$total_candidatos = Usuario::all()->count();


		$perfis = Auth::user()->perfis()->get()->toArray();
		$candidato = false;
		$chefe = false;
		$admin = false;
		foreach($perfis as $perfil)
		{

			if(Session::has('perfil')) {

				if(in_array('Chefe de linha', $perfil) && Session::get('perfil') == 4)
				{
					$chefe = true;
				}

				if(in_array('Chefe de linha', $perfil) && Session::get('perfil') == 1)
				{
					$admin = true;
				}

				if(in_array('Candidato', $perfil) && Session::get('perfil') == 2)
				{
					$candidato = true;
				}

			}
		}

		if($candidato)
		{
			//Barras de progresso
			$areas 	   = array();
			$progresso = array();
			//Dados Pessoais

			$usuario = Usuario::with('formacoes', 'experiencias', 'docencias', 'outrasinfos', 'premios', 'candidaturas_previas', 'outras_candidaturas')
							  ->where('id', '=', Auth::user()->id)
							  ->get()->first()
							  ->toArray();

			$areas['dados_pessoais'] 			= Auth::user()->toArray();
			$areas['formacao_superior'] 		= isset($usuario['formacoes'][0]) ? $usuario['formacoes'][0] : array();
			$areas['experiencia_profissional'] 	= isset($usuario['experiencias'][0]) ? $usuario['experiencias'][0] : array();
			$areas['docencia']					= isset($usuario['docencias'][0]) ? $usuario['docencias'][0] : array();
			$areas['outras_infos']				= isset($usuario['outrasinfos'][0]) ? $usuario['outrasinfos'][0] : array();

			$premios 							= isset($usuario['premios'][0]) ? $usuario['premios'][0] : array();
			$candidaturas_previas				= isset($usuario['candidaturas_previas'][0]) ? $usuario['candidaturas_previas'][0] : array();
			$outras_candidaturas				= isset($usuario['outras_candidaturas'][0]) ? $usuario['outras_candidaturas'][0] : array();

			$areas['outras_infos'] = array_merge($areas['outras_infos'], $premios, $candidaturas_previas, $outras_candidaturas);
			$areas['dados_pessoais'] = Auth::user()->toArray();

			unset($areas['dados_pessoais']['id'],
				  $areas['dados_pessoais']['id_joomla'],
				  $areas['dados_pessoais']['id_ufrj_old'],
				  $areas['dados_pessoais']['estrangeiro'],
				  $areas['dados_pessoais']['poscomp_pontos'],
				  $areas['dados_pessoais']['poscomp_nota_tec'],
				  $areas['dados_pessoais']['poscomp_nota_fun'],
				  $areas['dados_pessoais']['poscomp_nota_mat'],
				  $areas['dados_pessoais']['numdeps'],
				  $areas['dados_pessoais']['numfilhos'],
				  $areas['dados_pessoais']['idadefilhos'],
				  $areas['dados_pessoais']['situacao'],
				  $areas['dados_pessoais']['nomepai'],
				  $areas['dados_pessoais']['created_at'],
				  $areas['dados_pessoais']['updated_at']
				  );
			if(empty($usuario["estrangeiro"])){
				//brasileiro
				unset($areas['dados_pessoais']['passaporte']);
				
			} else {
				//estrangeiro
				unset($areas['dados_pessoais']['ident'],
				  $areas['dados_pessoais']['expedicao'],
				  $areas['dados_pessoais']['orgaoexped'],
				  $areas['dados_pessoais']['estexped'],
				  $areas['dados_pessoais']['cpf'],
				  $areas['dados_pessoais']['tituloeleitor'],
					$areas['dados_pessoais']['tituloeleitorzona'],
					$areas['dados_pessoais']['tituloeleitorsecao'],
					$areas['dados_pessoais']['tituloeleitoruf'],
					$areas['dados_pessoais']['tituloeleitoremissao'],
				  $areas['dados_pessoais']['identidade_arquivo'],
				  $areas['dados_pessoais']['identidade_verso_arquivo'],
				  $areas['dados_pessoais']['estado_expedidor_identidade'],
				  $areas['dados_pessoais']['cpf_arquivo'],
				  $areas['dados_pessoais']['titulo_eleitor_arquivo'],
				  $areas['dados_pessoais']['titulo_eleitor_verso_arquivo'],
					$areas['dados_pessoais']['certmilitar'],
					$areas['dados_pessoais']['certmilitarcategoria'],
					$areas['dados_pessoais']['certmilitarorgao'],
					$areas['dados_pessoais']['certmilitaruf'],
					$areas['dados_pessoais']['certmilitaremissao'],
				  $areas['dados_pessoais']['identidade'],
				  $areas['dados_pessoais']['cpf_img'],
				  $areas['dados_pessoais']['titulo_eleitor_img'],
				  $areas['dados_pessoais']['titulo_eleitor_verso_img'],
				  $areas['dados_pessoais']['certificado_militar_img'],
				  $areas['dados_pessoais']['certificado_militar_verso_img'],
				  $areas['dados_pessoais']['certmilitar'],
				  $areas['dados_pessoais']['identidade_img'],
				  $areas['dados_pessoais']['identidade_verso_img']
				  );
			}
			if($usuario["sexo"] == "Feminino"){
				unset($areas['dados_pessoais']['certmilitar']);
				unset($areas['dados_pessoais']['certmilitarcategoria']);
				unset($areas['dados_pessoais']['certmilitarorgao']);
				unset($areas['dados_pessoais']['certmilitaruf']);
				unset($areas['dados_pessoais']['certmilitaremissao']);
				unset($areas['dados_pessoais']['certificado_militar_arquivo']);
				unset($areas['dados_pessoais']['certificado_militar_verso_arquivo']);
				unset($areas['dados_pessoais']['certificado_militar_img']);
				unset($areas['dados_pessoais']['certificado_militar_verso_img']);
			}
			unset($areas['formacao_superior']['id'],
				  $areas['formacao_superior']['usuario_id'],
				  $areas['formacao_superior']['documento_formacao_img'],
				  $areas['formacao_superior']['diploma'],
				  $areas['formacao_superior']['historico'],
				  $areas['formacao_superior']['valor'],
				  $areas['formacao_superior']['ano_fim'],
				  $areas['formacao_superior']['created_at'],
				  $areas['formacao_superior']['updated_at']
				  );

			unset($areas['experiencia_profissional']['id'],
				  $areas['experiencia_profissional']['usuario_id'],
				  $areas['experiencia_profissional']['demissao'],
				  $areas['experiencia_profissional']['created_at'],
				  $areas['experiencia_profissional']['updated_at']
				  );

			unset($areas['docencia']['id'],
				  $areas['docencia']['usuario_id'],
				  $areas['docencia']['created_at'],
				  $areas['docencia']['updated_at']
				  );

			unset($areas['outras_infos']['id'],
				  $areas['outras_infos']['usuario_id'],
				  $areas['outras_infos']['created_at'],
				  $areas['outras_infos']['updated_at']
				  );
			$anoAtual = date('Y');
			// candidatos sexo masculino com mais do que 45 anos certificado militar não é obrigatório
			$newDate = $anoAtual - 45;
			if(!empty($areas['dados_pessoais']['nascimento']) && $areas['dados_pessoais']['nascimento'] != '0000-00-00'){
				$date = DateTime::createFromFormat("d/m/Y", $areas['dados_pessoais']['nascimento']);
				if($date->format("Y") <= $newDate){
					unset($areas['dados_pessoais']['certmilitar']);
					unset($areas['dados_pessoais']['certificado_militar_arquivo']);
					unset($areas['dados_pessoais']['certificado_militar_verso_arquivo']);
					unset($areas['dados_pessoais']['certificado_militar_img']);
					unset($areas['dados_pessoais']['certificado_militar_verso_img']);
					unset($areas['dados_pessoais']['certmilitarcategoria']);
					unset($areas['dados_pessoais']['certmilitarorgao']);
					unset($areas['dados_pessoais']['certmilitaruf']);
					unset($areas['dados_pessoais']['certmilitaremissao']);
				}
			}
			// candidatos com mais do que 65 anos título de eleitor não é obrigatório
			$newDate = $anoAtual - 65;
			if(!empty($areas['dados_pessoais']['nascimento']) && $areas['dados_pessoais']['nascimento'] != '0000-00-00'){
				$date = DateTime::createFromFormat("d/m/Y", $areas['dados_pessoais']['nascimento']);
				if($date->format("Y") <= $newDate){
					unset($areas['dados_pessoais']['tituloeleitor']);
					unset($areas['dados_pessoais']['titulo_eleitor_arquivo']);
					unset($areas['dados_pessoais']['titulo_eleitor_verso_arquivo']);
					unset($areas['dados_pessoais']['titulo_eleitor_img']);
					unset($areas['dados_pessoais']['titulo_eleitor_verso_img']);
					unset($areas['dados_pessoais']['tituloeleitorzona']);
					unset($areas['dados_pessoais']['tituloeleitorsecao']);
					unset($areas['dados_pessoais']['tituloeleitoruf']);
					unset($areas['dados_pessoais']['tituloeleitoremissao']);
				}
			}

			
			$imagens = Imagem::where('imagemMorph_id','=', Auth::user()->id)->where('imagemMorph_type','=','ProficienciaIngles')->get();
			$areas['outras_infos']['proficiencia_ingles'] = "ok!";
			if($imagens->isEmpty()){
				$areas['outras_infos']['proficiencia_ingles'] = null;
			}
			$mensagem = Mensagem::where('id_destinatario','=',Auth::user()->id)->where('lido','=',0)->get();
			$total = 0;
			$total_preenchido = 0;
			$vazio = array();
			foreach($areas as $key => $array)
			{
				$total += count($array);
				foreach($array as $key2 => $value)
				{
					$value = str_replace(' ', '', $value);

					if(!empty($value) )
					{
						if(!isset($progresso[$key]))
						{
							$progresso[$key] = 0;
						}

						$total_preenchido++;
						$progresso[$key]++;

					}
					else
					{
						$vazio[$key][] = $key2;
					}

				}
			}

			// debug($vazio);

			//$progresso_old = $progresso;
			foreach($progresso as $key => $value)
			{
				$progresso[$key] = ($value / count($areas[$key])) * 100;
			}

			// debug($total);
			// debug($total_preenchido);
			// debug($progresso);
			$faltantes = $total - $total_preenchido;
			$total = ($total_preenchido / $total) * 100;
			//debug($progresso_old, $progresso, $areas);
			$total = number_format($total, 1, '.', '');

			return View::make('painel_candidato.index', compact('vazio'))->with('progresso', $progresso)->with('total', $total)->with('faltantes', $faltantes)->with('mensagem', $mensagem);

			// fim candidato
		}
		elseif($chefe || (!$admin && !$candidato))
		{
			//$candidatos = Usuario::paginate(20);

            //->rule('required')
            //add fields to the form
            //mensagens
			$mensagem = Mensagem::where('id_destinatario','=',Auth::user()->id)->where('lido','=',0)->get();
			//user areas
			$user_areas = Auth::user()->areas;
			$areas = array();
			foreach($user_areas as $area)
			{
				$areas[] = $area->id;
			}
			//debug($areas);
			$formNoticia = DataForm::create();
            $formNoticia->text('titulo','Título')->options(Status::lists('descricao','id'));
            $formNoticia->select('categoria','Categoria')->options(array(1=>'João',2=>'José'));
            $formNoticia->add('texto','Notícia', 'textarea');
            $formNoticia->submit('Salvar e Publicar');
            $formNoticia->build();

            //ultimo periodo ativo
            //$ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $ultimoPeriodo = Whelper::ChecaPeriodo();
            $periodo_id = $ultimoPeriodo->id;

		    $gridMestrado = DataGrid::source(Inscricao::with('usuario','status', 'periodo')->with(array('areas' => function($query){
		    	$query->distinct()->get();
		    }))->where('curso','=','MSC')->where('periodo_id', '=', $periodo_id)->whereHas('areas', function($query) use($areas)
			{
				$query->whereIn('areas_inscricoes.area_id', $areas);
			}));

		    $gridMestrado->add('usuario.nome','Nome');
		    // $gridMestrado->add('periodo.ano','Ano');
		    // $gridMestrado->add('periodo.periodo','Periodo');
		    // $gridMestrado->add('{{$status->last()->descricao}}','Situção');
		    // $gridMestrado->add('curso','Curso');
		    $gridMestrado->add(' @foreach ($areas as $area) {{$area->sigla}} @endforeach ','Linha');
		    $gridMestrado->add('regime','Regime');
		    $gridMestrado->add('bolsa','Bolsa');
		    $gridMestrado->edit('professor/inscricao', '','');
		    $gridMestrado->orderBy('id','desc');
		    $gridMestrado->paginate(10);

		    $gridMestrado->row(function ($row) {
		        if ($row->cell('bolsa')->value == 0) {
		            $row->cell('bolsa')->value = 'Não';
		        }
		        else
		        {
		            $row->cell('bolsa')->value = 'Sim';
		        }
		    });

		    $gridDoutorado = DataGrid::source(Inscricao::with('usuario','status', 'periodo')->with(array('areas' => function($query){
		    	$query->distinct()->get();
		    }))->where('curso','=','DSC')->where('periodo_id', '=', $periodo_id)->whereHas('areas', function($query) use($areas)
			{
				$query->whereIn('areas_inscricoes.area_id', $areas);
			}));
		    $gridDoutorado->add('usuario.nome','Nome');
		    // $gridDoutorado->add('periodo.ano','Ano');
		    // $gridDoutorado->add('periodo.periodo','Periodo');
		    // $gridDoutorado->add('{{$status->last()->descricao}}','Situção');
		    // $gridDoutorado->add('curso','Curso');
		    $gridDoutorado->add(' @foreach ($areas as $area) {{$area->sigla}} @endforeach ','Linha');
		    $gridDoutorado->add('regime','Regime');
		    $gridDoutorado->add('bolsa','Bolsa');
		    $gridDoutorado->edit('professor/inscricao', '','');
		    $gridDoutorado->orderBy('id','desc');
		    $gridDoutorado->paginate(10);

		    $gridDoutorado->row(function ($row) {
		        if ($row->cell('bolsa')->value == 0) {
		            $row->cell('bolsa')->value = 'Não';
		        }
		        else
		        {
		            $row->cell('bolsa')->value = 'Sim';
		        }
		    });

			return View::make('painel_professor.index')->with(compact('formNoticia','gridMestrado', 'gridDoutorado','mensagem'));
			//fim chefe de linha
		} else
		{
			//$candidatos = Usuario::paginate(20);

            //->rule('required')
            //add fields to the form
			$mensagem = Mensagem::where('id_destinatario','=',Auth::user()->id)->where('lido','=',0)->get();
			$formNoticia = DataForm::create();
            $formNoticia->text('titulo','Título')->options(Status::lists('descricao','id'));
            $formNoticia->select('categoria','Categoria')->options(array(1=>'João',2=>'José'));
            $formNoticia->add('texto','Notícia', 'textarea');
            $formNoticia->submit('Salvar e Publicar');
            $formNoticia->build();

            //ultimo periodo ativo
            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;

		    $gridMestrado = DataGrid::source(Inscricao::with('usuario','status', 'periodo')->with(array('areas' => function($query){
		    	$query->distinct()->get();
		    }))->where('curso','=','MSC')->where('periodo_id', '=', $periodo_id));
		    $gridMestrado->add('usuario.nome','Nome');
		    // $gridMestrado->add('periodo.ano','Ano');
		    // $gridMestrado->add('periodo.periodo','Periodo');
		    //$gridMestrado->add('{{$status->last()->descricao}}','Situção');
		    // $gridMestrado->add('curso','Curso');
		    $gridMestrado->add(' @foreach ($areas as $area) {{$area->sigla}} @endforeach ','Linha');
		    //$gridMestrado->add(' {{ count($areas) }} ','Linha');
		    $gridMestrado->add('regime','Regime');
		    $gridMestrado->add('bolsa','Bolsa');
		    $gridMestrado->edit('professor/inscricao', '','show|modify');
		    $gridMestrado->orderBy('id','desc');
		    $gridMestrado->paginate(10);

		    $gridMestrado->row(function ($row) {
		        if ($row->cell('bolsa')->value == 0) {
		            $row->cell('bolsa')->value = 'Não';
		        }
		        else
		        {
		            $row->cell('bolsa')->value = 'Sim';
		        }
		    });

		    $gridDoutorado = DataGrid::source(Inscricao::with('usuario','status', 'periodo')->with(array('areas' => function($query){
		    	$query->distinct()->get();
		    }))->where('curso','=','DSC')->where('periodo_id', '=', $periodo_id));
		    $gridDoutorado->add('usuario.nome','Nome');
		    // $gridDoutorado->add('periodo.ano','Ano');
		    // $gridDoutorado->add('periodo.periodo','Periodo');
		    // $gridDoutorado->add('{{$status->last()->descricao}}','Situção');
		    // $gridDoutorado->add('curso','Curso');
		    $gridDoutorado->add(' @foreach ($areas as $area) {{$area->sigla}} @endforeach ','Linha');
		    $gridDoutorado->add('regime','Regime');
		    $gridDoutorado->add('bolsa','Bolsa');
		    $gridDoutorado->edit('professor/inscricao', '','show|modify');
		    $gridDoutorado->orderBy('id','desc');
		    $gridDoutorado->paginate(10);

		    $gridDoutorado->row(function ($row) {
		        if ($row->cell('bolsa')->value == 0) {
		            $row->cell('bolsa')->value = 'Não';
		        }
		        else
		        {
		            $row->cell('bolsa')->value = 'Sim';
		        }
		    });

			return View::make('painel_professor.index')->with(compact('formNoticia','gridMestrado', 'gridDoutorado','mensagem'));
		}

	});

	// Classificacao
	Route::get('pesquisar','CandidatoDadosPessoaisController@pesquisar');
	Route::get('classificar','CandidatoDadosPessoaisController@classificar');

	// Outras Rotas
	Route::controller('candidato/meusdados','MeusDadosController');
	Route::controller('adm/inscricao', 'AdminInscricaoController');
	//Route::controller('candidato/documentacao','DocumentoController');
	Route::controller('faqs', 'FaqController');
	Route::controller('professor/inscricao','ProfessorInscricaoController');
	
	//Academico
	//Route::controller('academico/alunos','AcademicoAlunosController');
	
	
	Route::group(array('before' => 'admin'), function()
	{
		Route::controller('mensagem/log', 'MensagemHistoricoController');
	});

	Route::controller('mensagem', 'MensagemController');	
	Route::controller('mensagem-requerimento', 'MensagemRequerimentoController');

	//Notas
	Route::controller('nota', 'NotaController');

	/** ---ADM--- **/
		Route::get('/adm/periodo/clonar/{id}','PeriodoController@clonar');
		Route::resource('adm/periodo', 'PeriodoController');
		Route::resource('adm/perfil', 'PerfilController');
		Route::resource('adm/usuario', 'UsuarioController');
		Route::controller('adm/parametro', 'ParametrosController');
		Route::resource('adm/mensagem_padrao', 'MensagemPadraoController');
		Route::resource('adm/scripts', 'ScriptsController');

		
		Route::get('adm/inscricao/dados-inscricao/{id}', 'AdminInscricaoController@getDadosInscricao');
		Route::post('adm/inscricao/dados-inscricao/', 'AdminInscricaoController@postDadosInscricao');

		Route::get('adm/meusdados/dados-pessoais/{id}', 'MeusDadosController@getDadosPessoais');
		Route::post('adm/meusdados/dados-pessoais/', 'MeusDadosController@postDadosPessoais');

		Route::get('adm/meusdados/docencia/{id}', 'MeusDadosController@getDocencia');
		Route::get('adm/meusdados/docencia/', 'MeusDadosController@postDocencia');

		//Provas
		Route::post('adm/prova/deletar', 'ProvasController@destroyMany');
		Route::get("adm/prova/destroyajax", 'ProvasController@destroyajax');
		Route::resource('adm/provatipos', 'ProvaTiposController');
		Route::resource('adm/prova', 'ProvasController');

	/** ---ADM--- **/

	//Professor
	Route::controller('documentos', 'DocumentoController');
	Route::controller('professor','ProfessorController');

	//ROTAS que necessitam de login E que o periodo de inscrição esteja ativo
	Route::group(array('before' => 'periodo_ativo'), function()
	{
		Route::controller('candidato/inscricao', 'CandidatoInscricaoController');		
	});

});

Route::controller('imagem', 'ImagemController');

Route::controller('id', 'IdController');
Route::controller('password','RemindersController');

Route::get('/', function()
{
	return Redirect::to('panel');
});