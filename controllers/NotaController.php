<?php

class NotaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /nota
	 *
	 * @return Response
	 */
	public function getIndexOld()
	{

        $tipo = Input::get('tipo');

        if($tipo =='')
        {
            $tipo = 'm';
        }

        if($tipo == 'm')
        {
            $tipoInscricao = 'MSC';
        }
        else
        {
            $tipoInscricao = 'DSC';
        }

        if(Session::has('perfil') && Session::get('perfil') == 1) {
            $areas_usuario = Area::get(); 
        } else {
            $areas_usuario = Auth::user()->areas()->get();
        }

        $areas_usuario = $areas_usuario->lists('nome', 'id');

        $situacoes = Status::lists('descricao', 'id');

        $periodos = Periodo::orderBy('ano', 'DESC')->orderBy('periodo', 'DESC')->get();

        $inscricoes = Inscricao::with('usuario','areas','status', 'periodo')->where('curso','=',$tipoInscricao);

        if(Input::has('nome'))
        {
            $nome = Input::get('nome');

            $inscricoes = $inscricoes->whereHas('usuario', function($query) use($nome)
            {
                $query->where('nome', 'LIKE', "%$nome%");
            });
        }
        if(Input::has('periodo_id'))
        {
            $periodo_id = Input::get('periodo_id');
            $inscricoes = $inscricoes->where('periodo_id', '=', $periodo_id);
        } else {
            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;
            $inscricoes = $inscricoes->where('periodo_id', '=', $periodo_id);
        }
        if(Input::has('linha_id'))
        {
            $area_id = Input::get('linha_id');

            $inscricoes = $inscricoes->with(array('areas' => function($query){

                $query->distinct();

            }))->whereHas('areas', function($query) use($area_id)
            {
                $query->where('areas.id', '=', $area_id);
            });
            $inscricoes = $inscricoes->groupBy('usuario_id');
        } elseif(Session::has('perfil') && Session::get('perfil') != 1 && Session::get('perfil') != 6 && Session::get('perfil') != 7){
            $area_id = array();
            if(Session::has('perfil') && Session::get('perfil') == 1) {
                $user_areas = Area::get(); 
            } else {
                $user_areas = Auth::user()->areas;
            }
            foreach($user_areas as $area)
            {
                $area_id[] = $area->id;
            }

            $inscricoes = $inscricoes->whereHas('areas', function($query) use($area_id)
            {
                $query->whereIn('areas.id', $area_id);
            });
        }
        
        $inscricoes = $inscricoes->paginate(10);

        return  View::make('painel_professor.notas.index', compact('inscricoes', 'areas_usuario', 'situacoes', 'periodos','periodo_id'));

	}

	public function getIndex()
	{

        $tipo = Input::get('tipo');

        if($tipo =='')
        {
            $tipo = 'm';

            $prova = new ProvaMestrado;
            $notas = new ProvaNotaMestrado;
        }

        if($tipo == 'm')
        {
            $tipoInscricao = 'MSC';

            $prova = new ProvaMestrado;
            $notas = new ProvaNotaMestrado;
        }
        else
        {
            $tipoInscricao = 'DSC';

            $prova = new ProvaDoutorado;
            $notas = new ProvaNotaDoutorado;
        }

        if(Session::has('perfil') && Session::get('perfil') == 1) {
            $areas_usuario = Area::get(); 
        } else {
            $areas_usuario = Auth::user()->areas()->get();
        }

        $areas_usuario = $areas_usuario->lists('nome', 'id');

        $situacoes = Status::lists('descricao', 'id');

        $periodos = Periodo::orderBy('ano', 'DESC')->orderBy('periodo', 'DESC')->get();

        $periodo_id = Input::get('periodo_id');

        $linha_id = Input::get('linha_id');
        

        if(Input::has('identificador'))
        {
        	$id_identificador = Input::get('identificador');

        	$prova = $prova->with('area')->find($id_identificador);
					if (isset($prova))
					{
						$nomeProva = DB::table('provas')->where('id', '=', $prova->prova_id)->pluck('nome');	
          	$identificadorNome = DB::table('periodos_areas_provas_mestrado')->where('id', '=', $id_identificador)->pluck('identificador');
          	$notas = $notas->with('inscricao.usuario')->Where('prova_id', $id_identificador)->get();

	        	$notas->sort(function($a, $b)
			    	{
			    		if($a->inscricao && $b->inscricao)
							{
								$a = $a->inscricao->usuario->nome;
								$b = $b->inscricao->usuario->nome;
								if ($a === $b) {
										return 0;
								}
								return ($a > $b) ? 1 : -1;
							}
							else
							{
								return 0;
							}
						});
					}				
        } 
        else
        {
        	$id_identificador = '';
        	$identificadorNome = '';
          $notas = [];
        	$prova = [];
        }
            
		$publicavel = 0;
		if(Session::has('perfil') && Session::get('perfil') == 1)
		{
			$publicavel = 1;
		}

        return  View::make('painel_professor.notas.index', compact('prova', 'nomeProva', 'notas', 
																   'areas_usuario', 'situacoes', 
																   'periodos', 'periodo_id', 
																   'identificadorNome', 'id_identificador',
																   'publicavel'));

	}


	//Pega identificadores via AJAX quando o select de linhas é selecionado
	public function getIdentificadores($id_linha, $id_periodo)
	{

		//M para mestrado ou D para doutorado
		$tipo = Input::get('tipo');

		switch ($tipo) {
			case 'm':
				$obj = new ProvaMestrado;
				break;
			
			case 'd':
				$obj = new ProvaDoutorado;
				break;
			
			default:
				exit;
				break;
		}

		$identificadores = $obj->where('periodo_id', $id_periodo)
							   ->where('area_id', $id_linha)
							   ->distinct('identificador')
							   ->select('id', 'identificador')
							   ->get();

		return $identificadores;
	}

	public function getInscricoes($id)
	{

		$tipo = Input::get('tipo');

        if($tipo =='')
        {
            $tipo = 'm';
        }

        if($tipo == 'm')
        {
            $tipoInscricao = 'MSC';
        }
        else
        {
            $tipoInscricao = 'DSC';
        }

        $usuario = Usuario::find($id);

        $inscricoes = $usuario->inscricoes()->with(array('periodo' => function($query)
        	{
        		$query->orderBy('ano', 'DESC')->orderBy('periodo', 'DESC');
        	}))->where('curso', '=', $tipoInscricao)->paginate(10);

		// $inscricoes = Inscricao::with(array('usuario' => function($query) use($id)
		// {
		// 	$query->where('id', '=', $id);
		// }))->with('periodo')->where('curso', '=', $tipoInscricao)->get();

		return View::make('painel_professor.notas.inscricoes', compact('usuario', 'inscricoes'));
	}

	public function getProvas($id)
	{
		$tipo = Input::get('tipo');

		if($tipo == 'm')
		{
			$notas = Inscricao::with(array('provas_mestrado' => function($query)
			{
				if(Session::has('perfil') && Session::get('perfil') == 1) {
		            $areas = Area::get(); 
		        } else {
		            $areas = Auth::user()->areas;
		        }
				foreach($areas as $area)
				{
					$areas_in[] = $area->id;
				}

				$query->whereIn('area_id', $areas_in);
			}))->find($id)->provas_mestrado;
		}
		else
		{
			$notas = Inscricao::with(array('provas_doutorado'=> function($query)
			{
				if(Session::has('perfil') && Session::get('perfil') == 1) {
		            $areas = Area::get(); 
		        } else {
		            $areas = Auth::user()->areas;
		        }
				foreach($areas as $area)
				{
					$areas_in[] = $area->id;
				}

				$query->whereIn('area_id', $areas_in);
			}))->find($id)->provas_doutorado;
		}

		$inscricao = Inscricao::find($id);
		$usuario = $inscricao->usuario;
		$periodo = $inscricao->periodo;

		//debug($notas->toArray());

		// debug(Session::get('perfil_ativo'));

		//return View::make('hello', compact('provas'));
		return View::make('painel_professor.notas.provas', compact('provas', 'usuario', 'periodo', 'inscricao'));
	}

	public function postPublicar()
	{
		$tipo = Input::get('tipo');
		$id = Input::get('id');
		
		if($tipo == 'm')
		{
			$nota = ProvaMestrado::find($id);
		}
		else
		{
			$nota = ProvaDoutorado::find($id);
		}
		
		if ($nota)
		{
			if (Input::get('publicado') == '1')
				$nota->publicado = '0';
			elseif (Input::get('publicado') == '0')
				$nota->publicado = '1';

			$nota->save();
		}
					
		return Redirect::back()->with('success', array('Notas publicadas.'));		
	}
	
	public function postSalvar()
	{
		$input = Input::all();

		extract($input);

		if(isset($notas) && !empty($notas))
		{

			foreach($notas as $key => $input)
			{
				if($tipo == 'm')
				{
					$nota = ProvaNotaMestrado::find($key);
				}
				else
				{
					$nota = ProvaNotaDoutorado::find($key);
				}

				$string_nota = $input['nota'];			

				$status = '';
				if (strtolower($string_nota) == 'd')
				{
					$status = 'DISPENSADO';
					$string_nota = '';
				}
				else if (strtolower($string_nota) == 'f')
				{
					$status = 'FALTOU';
					$string_nota = '';
				}
				else
				{
					$string_nota = str_replace(',', '.', $string_nota);
					if (is_numeric ($string_nota))
					{
						$string_nota = floatval($string_nota);
						if ($nota->prova->tipo == 'Classificatoria')
						{										
							if ($string_nota < $nota->prova->nota_classificatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}
						if ($nota->prova->tipo == 'Eliminatoria') 
						{										
							if ($string_nota < $nota->prova->nota_eliminatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}						
					}
					else
					{
						$status = '';
						$string_nota = '';
					}
				}										
				
				$nota->nota = $string_nota;
				$nota->status = $status;// $input['status'];
				$nota->falta = (isset($input['falta']) && $input['falta']) ? 1 : 0;
				$nota->save();			
			}
			
		}
		
		Ulog::Novo("Atualização de notas", "Notas de provas atualizadas pelo Usuário ". Auth::user()->nome);

		return Redirect::back()->with('success', array('Notas atualizadas.'));

	}

	/**
	 * Gera o relatório de Notas (não é editável)
	 */
	public function getRelatorioNotas() 
	{
        $tipo = Input::get('tipo');

		// tipo default = Mestrado
        if($tipo == '')
        {
            $tipo = 'm';
        }

        $tipoInscricao = $tipo == 'm' ? 'MSC' : 'DSC';

        if(Session::has('perfil') && Session::get('perfil') == 1)
		{
            $areas_usuario = Area::get(); 
        } 
		else
		{
            $areas_usuario = Auth::user()->areas()->get();
        }

        $periodos = Periodo::orderBy('id','desc')->get();

        $periodo_key = Input::get('periodo_key');

        if($periodo_key != '')
        {
        	$periodo = Periodo::where('id','=',$periodo_key)->where('status','>','0')->first();
        }
        else
        {
			$periodo = Whelper::ChecaPeriodo();
        }

        if($periodo)
		{
        	if(Input::has('area'))
			{
        		$areas_usuario_id = array(Input::get('area'));
        		$area_id = Input::get('area');
        	}
        	else
			{
				$areas_usuario_id = $areas_usuario->lists('id');
				$area_id = '';
			}

        	if($tipoInscricao == 'MSC')
			{
        		//->temVagas()->with('inscricoes','inscricoes.usuario','inscricoes.provas_doutorado','inscricoes.provas_doutorado.prova')
        		$areas_mestrado   = $periodo->areas_mestrado()->whereIn('area_id',$areas_usuario_id)
        		->with(['inscricoes' => function($query) use ($periodo){
        			$query->where('inscricoes.status_id','!=','1')->where('inscricoes.status_id','!=','2')->where('inscricoes.periodo_id','=',$periodo->id)->with('provas_mestrado','provas_mestrado.prova')->get();
        		}])
        		->get();
        	} 
			else
			{
        		//$areas_doutorado  = $periodo->areas_doutorado()->whereIn('area_id',$areas_usuario_id)->temVagas()->with('inscricoes','inscricoes.usuario','inscricoes.provas_doutorado', 'inscricoes.provas_doutorado.prova')->get();
				$areas_doutorado  = $periodo->areas_doutorado()->whereIn('area_id',$areas_usuario_id)
				->with(['inscricoes' => function($query) use ($periodo) {
					$query->where('inscricoes.status_id','!=','1')->where('inscricoes.status_id','!=','2')->where('inscricoes.periodo_id','=',$periodo->id)->with('provas_doutorado', 'provas_doutorado.prova')->get();
				}])
				->get();        		
        	}
        }

		return View::make('painel_professor.notas.relatorio_notas')->with(compact('tipo', 'area_id', 'areas_usuario', 'periodos', 'periodo', 'areas_mestrado', 'areas_doutorado'));
	} 

	/**
	 * Gera o arquivo CSV do relatório de Notas
	 */
	public function getExportarNotas()
	{
        $tipo = Input::get('tipo');

        if($tipo == '')
        {
            $tipo = 'm';
        }

        $tipoInscricao = $tipo == 'm' ? 'MSC' : 'DSC';

        if(Session::has('perfil') && Session::get('perfil') == 1) {
            $areas_usuario = Area::get(); 
        } else {
            $areas_usuario = Auth::user()->areas()->get();
        }

        $periodos = Periodo::orderBy('id','desc')->get();

        $periodo_key = Input::get('periodo_key');

        if($periodo_key != '')
        {
        	$periodo = Periodo::where('id','=',$periodo_key)->where('status','>','0')->first();
        }
        else
        {
			$periodo = Whelper::ChecaPeriodo();
        }

        if($periodo) {

        	if(Input::has('area')) {
        		$areas_usuario_id = array(Input::get('area'));
        		$area_id = Input::get('area');
        	}
        	else {
				$areas_usuario_id = $areas_usuario->lists('id');
				$area_id = '';
			}
			if($tipoInscricao == 'MSC') {
        		//->temVagas()->with('inscricoes','inscricoes.usuario','inscricoes.provas_doutorado','inscricoes.provas_doutorado.prova')
        		$areas_mestrado   = $periodo->areas_mestrado()->whereIn('area_id',$areas_usuario_id)
        		->with(['inscricoes' => function($query) use ($periodo) {
        			$query->where('inscricoes.status_id','!=','1')->where('inscricoes.status_id','!=','2')->where('inscricoes.periodo_id','=',$periodo->id)->with('provas_mestrado','provas_mestrado.prova')->get();
        		}])
        		->get();
        	} else {
        		//$areas_doutorado  = $periodo->areas_doutorado()->whereIn('area_id',$areas_usuario_id)->temVagas()->with('inscricoes','inscricoes.usuario','inscricoes.provas_doutorado', 'inscricoes.provas_doutorado.prova')->get();
				$areas_doutorado  = $periodo->areas_doutorado()->whereIn('area_id',$areas_usuario_id)
				->with(['inscricoes' => function($query) use ($periodo) {
					$query->where('inscricoes.status_id','!=','1')->where('inscricoes.status_id','!=','2')->where('inscricoes.periodo_id','=',$periodo->id)->with('provas_doutorado', 'provas_doutorado.prova')->get();
				}])
				->get();        		
        	}


        	header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Description: File Transfer');
			header('Content-Type: text/csv');
			header("Content-Disposition: attachment; filename=relatorioNotas".$tipoInscricao.".csv");
			header('Content-Transfer-Encoding: binary');
    		// create a file pointer connected to the output stream
			$output = fopen('php://output', 'w');

			fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));


			/**
			 * Exporta notas do mestrado em formato csv.
			 * Uma inscrição (par candidato+linha de pesquisa) por linha do arquivo.
			 */
			 
			fputcsv($output, array('Linha', 'Candidato', 'PE', 'PO', 'PT', 'PP', 'Média', 'Situação'),';');
			$tipo = (Input::get('tipo')=='') ? 'm' : Input::get('tipo');
			if($tipo == 'm')
			{
				if(isset($areas_mestrado) && !$areas_mestrado->isEmpty())
				{
			        foreach($areas_mestrado as $area_mestrado)
					{
			            if(!$area_mestrado->inscricoes->isEmpty())
						{
			                foreach($area_mestrado->inscricoes as $inscricao)
							{
			                    if($inscricao->provas_mestrado != null && !$inscricao->provas_mestrado->isEmpty())
								{
									unset($notas);
									// inicia as notas com NA (Não Aplicada), a medida que forem encontradas preenche
									// a ordem é PE, PO, PT, PP
									$notas = array("NA", "NA", "NA", "NA");
			                        unset($array);
			                        $array[] = $area_mestrado->sigla;
			                        $array[] = $inscricao->usuario->nome;

									$media = 0.0;
									$notas_validas = 0;
									$mostra_media = true;
			                        foreach($inscricao->provas_mestrado as $prova_mestrado)
									{
			                            if($prova_mestrado->area_id == $area_mestrado->id)
										{
											$index_nota = 0;
											if (strcmp($prova_mestrado->identificador, "PE") == 0)
											{
												$index_nota = 0;
											}
											elseif (strcmp($prova_mestrado->identificador, "PO") == 0)
											{
												$index_nota = 1;
											}
											elseif (strcmp($prova_mestrado->identificador, "PT") == 0)
											{
												$index_nota = 2;
											}
											elseif (strcmp($prova_mestrado->identificador, "PP") == 0)
											{
												$index_nota = 3;
											}

											if ($prova_mestrado->pivot->status == 'FALTOU')
											{
												$notas[$index_nota] = 'F';		
												$mostra_media = false;
											}
											else if ($prova_mestrado->pivot->status == 'DISPENSADO')
											{
												$notas[$index_nota] = 'D';
											}
											else if ($prova_mestrado->pivot->nota == '')
											{
												$notas[$index_nota] = '-';
												$mostra_media = false;
											}
											else
											{
												$notas[$index_nota] = $prova_mestrado->pivot->nota;
																																				
												if ($prova_mestrado->tipo == 'Classificatoria')
												{												
													$media += $prova_mestrado->pivot->nota;
													$notas_validas += 1;
												}
												if ($prova_mestrado->pivot->nota < 5.0)
													$mostra_media = false;
											}
											
			                                //$array[] = $prova_mestrado->prova->nome;
			                                //$array[] = $prova_mestrado->pivot->nota;
			                                //$array[] = $prova_mestrado->pivot->status;
			                            }
			                        }
									if ($notas_validas > 0 && $mostra_media)
									{
										$media = $media / $notas_validas;										
									}				
									else
									{
										$media = '-';
										
									}

									$area_insc = AreaInscricao::where('inscricao_id','=',$inscricao->id)->where('area_id','=',$area_mestrado->id)->get();
									$status = '-';
									if (!$area_insc->isEmpty())
									{
										$status = $area_insc[0]->status['sigla'];										
									}
									
									
									//$status = $inscricao->status;
									$array = array_merge($array, $notas);
									$array[] = $media;
																		
									$array[] = $status;
									//$array = array_merge($array, $media);
									//$array = array_merge($array, $status);
		                        	fputcsv($output, $array,';');
			                    }
			                }
			            }
			        }
			    }
			} 
			else
			{
				if(isset($areas_doutorado) && !$areas_doutorado->isEmpty())
				{
					foreach($areas_doutorado as $area_doutorado)
					{
						if(!$area_doutorado->inscricoes->isEmpty())
						{
							foreach($area_doutorado->inscricoes as $inscricao)
							{
								if($inscricao->provas_doutorado != null && !$inscricao->provas_doutorado->isEmpty())
								{
									unset($notas);
									// inicia as notas com NA (Não Aplicada), a medida que forem encontradas preenche
									// a ordem é PE, PO, PT, PP
									$notas = array("NA", "NA", "NA", "NA");
			                        unset($array);
			                        $array[] = $area_doutorado->sigla;
			                        $array[] = $inscricao->usuario->nome;
									
									$media = 0.0;
									$notas_validas = 0;
									$mostra_media = true;
									foreach($inscricao->provas_doutorado as $prova_doutorado)
									{
										if($prova_doutorado->area_id == $area_doutorado->id)
										{
											$index_nota = 0;
											if (strcmp($prova_doutorado->identificador, "PE") == 0)
											{
												$index_nota = 0;
											}
											elseif (strcmp($prova_doutorado->identificador, "PO") == 0)
											{
												$index_nota = 1;
											}
											elseif (strcmp($prova_doutorado->identificador, "PT") == 0)
											{
												$index_nota = 2;
											}
											elseif (strcmp($prova_doutorado->identificador, "PP") == 0)
											{
												$index_nota = 3;
											}

											if ($prova_doutorado->pivot->status == 'FALTOU')
											{
												$notas[$index_nota] = 'F';		
												$mostra_media = false;
											}
											else if ($prova_doutorado->pivot->status == 'DISPENSADO')
											{
												$notas[$index_nota] = 'D';
											}
											else if ($prova_doutorado->pivot->nota == '')
											{
												$notas[$index_nota] = '-';
												$mostra_media = false;
											}
											else
											{
												$notas[$index_nota] = $prova_doutorado->pivot->nota;
																																				
												if ($prova_doutorado->tipo == 'Classificatoria')
												{												
													$media += $prova_doutorado->pivot->nota;
													$notas_validas += 1;
												}
												if ($prova_doutorado->pivot->nota < 5.0)
													$mostra_media = false;
											}
											
			                                //$array[] = $prova_mestrado->prova->nome;
			                                //$array[] = $prova_mestrado->pivot->nota;
			                                //$array[] = $prova_mestrado->pivot->status;
			                            }
			                        }
									if ($notas_validas > 0 && $mostra_media)
									{
										$media = $media / $notas_validas;										
									}				
									else
									{
										$media = '-';
										
									}

									$area_insc = AreaInscricao::where('inscricao_id','=',$inscricao->id)->where('area_id','=',$area_doutorado->id)->get();
									$status = '-';
									if (!$area_insc->isEmpty())
									{
										$status = $area_insc[0]->status['sigla'];										
									}
									
									
									//$status = $inscricao->status;
									$array = array_merge($array, $notas);
									$array[] = $media;
																		
									$array[] = $status;
									//$array = array_merge($array, $media);
									//$array = array_merge($array, $status);
		                        	fputcsv($output, $array,';');

								}
							}
						}
					}
				}
			}
			exit;
		}
	}
}
