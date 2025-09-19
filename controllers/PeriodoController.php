<?php

class PeriodoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /adm
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Input::has('ord1'))
		{
			$order_field = Input::get('ord1');

			$order_direction = (strpos($order_field, '-') !== false) ? 'DESC' : 'ASC';

			$order_field = str_replace('-', '', $order_field);
		}
		else
		{
			$order_field 		= 'data_hora_inicio';
			$order_direction 	= 'DESC';
		}

		if(Input::has('_search') && Input::get('_search') == 1)
		{
			$ano = Input::get('ano');
			$periodo = Input::get('periodo');

			if($periodo)
			{
				$periodos = Periodo::Where('periodo', '=', $periodo);
			}

			if($ano)
			{
				$periodos = isset($periodos) ? $periodos->Where('ano', '=', $ano) : Periodo::Where('ano', '=', $ano);
			}

			$periodos = $periodos->paginate(15);
		}
		else
		{
			$periodos = Periodo::OrderBy($order_field, $order_direction)->paginate(15);
		}

		$periodos->each(function($periodo)
		{
			switch ($periodo->status) {
				case 0:
					$periodo->status = '<span class="label label-default"> Inativo </span>';
					break;
				case 1:
					$periodo->status = '<span class="label label-warning"> Em preparação </span>';
					break;
				case 2:
					$periodo->status = '<span class="label label-success"> Inscrições abertas </span>';
					break;
				case 3:
					$periodo->status = '<span class="label label-info"> Inscrições concluídas </span>';
					break;
				case 4:
					$periodo->status = '<span class="label label-primary"> Período concluido </span>';
					break;
			}

			$periodo->data_hora_inicio = $this->formatDateBack($periodo->data_hora_inicio);

			$periodo->data_hora_fim = $this->formatDateBack($periodo->data_hora_fim);
		});

		return View::make('adm.periodo.index')->with(compact('periodos'));
	}

	public function create()
    {
    	$areas = Area::all();
    	$provas = Prova::lists("nome", "id");

    	// debug($provas);
    	// debug($areas);

        return View::make('adm.periodo.create')->with(compact('areas', 'provas'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /adm
	 *
	 * @return Response
	 */
	public function store()
	{

		

		$form = Input::except('_token', '_method', 'areas_vagas_mestrado', 'areas_vagas_doutorado', 'provas_mestrado', 'provas_doutorado');

		$form['data_hora_inicio'] = $this->formatDate($form['data_hora_inicio']);

		$form['data_hora_fim'] = $this->formatDate($form['data_hora_fim']);

		//$habilitado = Periodo::where('habilitado', '=', 1)->first();
		$habilitado = Whelper::ChecaPeriodo();

		if($form['status'] > 4 && $habilitado)
		{
			$form['status'] = 0;
			$warning = array(1 => 'Já existe um período finalizado, seu novo período foi salvo como Inativo.');
		}
		else
		{
			$success = array(1 => 'Periodo criado.');
		}

		$periodo = new Periodo($form);

		$periodo->save();

		// //VAGAS DE MESTRADO
		if(Input::has('areas_vagas_mestrado'))
		{
			$areas_vagas_mestrado = Input::get('areas_vagas_mestrado');

			if(is_array($areas_vagas_mestrado) && !empty($areas_vagas_mestrado))
			{
				$areas_vagas_mestrado_sync = array();

				foreach($areas_vagas_mestrado as $key => $value)
				{

					$areas_vagas_mestrado_sync[$key] = array('num_vagas' => $value);

				}

				$periodo->areas_mestrado()->sync($areas_vagas_mestrado_sync);

			}
		}

		// //VAGAS DE DOUTORADO
		if(Input::has('areas_vagas_doutorado'))
		{
			$areas_vagas_doutorado = Input::get('areas_vagas_doutorado');

			if(is_array($areas_vagas_doutorado) && !empty($areas_vagas_doutorado))
			{
				$areas_vagas_doutorado_sync = array();

				foreach($areas_vagas_doutorado as $key => $value)
				{
					$areas_vagas_doutorado_sync[$key] = array('num_vagas' => $value);
				}

				$periodo->areas_doutorado()->sync($areas_vagas_doutorado_sync);

			}
		}

		//Provas Mestrado

		//$mestrados = $periodo->areas()->wherePivot('tipo', '=', 'M')->get()

		$provas_mestrado = (Input::has('provas_mestrado')) ? Input::get('provas_mestrado') : false ;


		if($provas_mestrado != false)
		{
			foreach($provas_mestrado as $area => $prova)
			{
				foreach($prova as $p)
				{

					$nova_prova = new ProvaMestrado;

					$nova_prova->periodo_area_id = $periodo->areas_mestrado()->wherePivot('area_id', '=', $area)->first()->pivot->id;

					$nova_prova->periodo_id = $periodo->id;

					$nova_prova->area_id = $area;

					$nova_prova->prova_id = $p['id_prova'];

					$nova_prova->identificador = $p['identificador'];

					$nova_prova->tipo = $p['tipo'];

					$nova_prova->nota_eliminatoria = $p['nota_eliminatoria'];

					$nova_prova->nota_classificatoria = $p['nota_classificatoria'];

					$nova_prova->save();
				}
			}
		}


		$provas_doutorado = (Input::has('provas_doutorado')) ? Input::get('provas_doutorado') : false ;


		if($provas_doutorado != false)
		{
			foreach($provas_doutorado as $area => $prova)
			{
				foreach($prova as $p)
				{
					$nova_prova = new ProvaDoutorado;

					$nova_prova->periodo_area_id = $periodo->areas_doutorado()->wherePivot('area_id', '=', $area)->first()->pivot->id;

					$nova_prova->periodo_id = $periodo->id;

					$nova_prova->area_id = $area;

					$nova_prova->prova_id = $p['id_prova'];

					$nova_prova->identificador = $p['identificador'];

					$nova_prova->tipo = $p['tipo'];

					$nova_prova->nota_eliminatoria = $p['nota_eliminatoria'];

					$nova_prova->nota_classificatoria = $p['nota_classificatoria'];

					$nova_prova->save();
				}
			}
		}



		if(isset($warning))
		{
			return Redirect::to('adm/periodo/')->with('warning', $warning);
		}
		else
		{
			return Redirect::to('adm/periodo/')->with('success', $success);
		}

	}

	/**
	 * Display the specified resource.
	 * GET /adm/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$periodo = Periodo::With('areas')->FindOrFail($id);

		// debug($periodo);

		$periodo->habilitado = $periodo->habilitado ? 'Sim' : 'Não';

		$periodo->data_hora_inicio = $this->formatDateBack($periodo->data_hora_inicio);

		$periodo->data_hora_fim = $this->formatDateBack($periodo->data_hora_fim);

		return View::make('adm.periodo.show', compact('periodo'))->with('areas', $periodo->areas);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /adm/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$periodo = Periodo::With('areas_mestrado_get.area', 'areas_mestrado_get.provas.prova', 'areas_doutorado_get.area', 'areas_doutorado_get.provas.prova')->FindOrFail($id);

		if($periodo->status == 4)
		{
			return Redirect::to('adm/periodo/')->with('danger', array('O período selecionado já se encontra CONCLUIDO e não pode mais ser alterado.'));
			die();
		}

		//Array com indices de mesmo valor da area, para facilitar em colocar o valor das vagas no edit.
		$areas_mestrado = array();

		foreach($periodo->areas_mestrado_get as $obj)
		{
			$areas_mestrado[$obj->area_id] = $obj;
		}

		//Array com indices de mesmo valor da area, para facilitar em colocar o valor das vagas no edit.
		$areas_doutorado = array();

		foreach($periodo->areas_doutorado_get as $obj)
		{
			$areas_doutorado[$obj->area_id] = $obj;
		}

		$periodo->data_hora_inicio = $this->formatDateBack($periodo->data_hora_inicio);

		$periodo->data_hora_fim = $this->formatDateBack($periodo->data_hora_fim);

		$areas = Area::all();
    	$provas = Prova::lists("nome", "id");

		return View::make('adm.periodo.edit', compact('periodo', 'areas', 'provas', 'areas_mestrado', 'areas_doutorado'));
	}

/**/

	/**
	 * Show the form for editing the specified resource.
	 * GET /adm/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function clonar($id)
	{
		$periodo = Periodo::With('areas_mestrado_get.area', 'areas_mestrado_get.provas.prova', 'areas_doutorado_get.area', 'areas_doutorado_get.provas.prova')->FindOrFail($id);

		// if($periodo->status == 4)
		// {
		// 	return Redirect::to('adm/periodo/')->with('danger', array('O período selecionado já se encontra CONCLUIDO e não pode mais ser alterado.'));
		// 	die();
		// }

		//Array com indices de mesmo valor da area, para facilitar em colocar o valor das vagas no edit.
		$areas_mestrado = array();

		foreach($periodo->areas_mestrado_get as $obj)
		{
			$areas_mestrado[$obj->area_id] = $obj;
		}

		//Array com indices de mesmo valor da area, para facilitar em colocar o valor das vagas no edit.
		$areas_doutorado = array();

		foreach($periodo->areas_doutorado_get as $obj)
		{
			$areas_doutorado[$obj->area_id] = $obj;
		}

		$periodo->data_hora_inicio = $this->formatDateBack($periodo->data_hora_inicio);

		$periodo->data_hora_fim = $this->formatDateBack($periodo->data_hora_fim);

		$areas = Area::all();
    	$provas = Prova::lists("nome", "id");
    	$periodo->status = 1;
		return View::make('adm.periodo.clone', compact('periodo', 'areas', 'provas', 'areas_mestrado', 'areas_doutorado'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /adm/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$form = Input::except('_token', '_method', 'areas_vagas_mestrado', 'areas_vagas_doutorado', 'provas_mestrado', 'provas_doutorado');

		$form['data_hora_inicio'] = $this->formatDate($form['data_hora_inicio']);

		$form['data_hora_fim'] = $this->formatDate($form['data_hora_fim']);

		$periodo = Periodo::with('areas_mestrado_get.provas', 'areas_doutorado_get.provas')->FindOrFail($id);

		$habilitado = Whelper::ChecaPeriodo();

		if($form['status'] > 0 && $habilitado && ($periodo->id != $habilitado->id))
		{
			// $form['status'] = 0;
			$success = array(1 => 'Periodo Atualizado.');
		}
		else
		{
			Usuario::where('situacao', '1')->update(['situacao' => 0]);
			$success = array(1 => 'Periodo Atualizado.');
		}


		$periodo->update($form);

		//VAGAS DE MESTRADO
		if(Input::has('areas_vagas_mestrado'))
		{
			$areas_vagas_mestrado = Input::get('areas_vagas_mestrado');

			if(is_array($areas_vagas_mestrado) && !empty($areas_vagas_mestrado))
			{
				$areas_vagas_mestrado_sync = array();

				foreach($areas_vagas_mestrado as $key => $value)
				{

					$areas_vagas_mestrado_sync[$key] = array('num_vagas' => $value);

				}

				$periodo->areas_mestrado()->sync($areas_vagas_mestrado_sync);

			}
		}

		//VAGAS DE DOUTORADO
		if(Input::has('areas_vagas_doutorado'))
		{
			$areas_vagas_doutorado = Input::get('areas_vagas_doutorado');

			if(is_array($areas_vagas_doutorado) && !empty($areas_vagas_doutorado))
			{
				$areas_vagas_doutorado_sync = array();

				foreach($areas_vagas_doutorado as $key => $value)
				{
					$areas_vagas_doutorado_sync[$key] = array('num_vagas' => $value);
				}

				$periodo->areas_doutorado()->sync($areas_vagas_doutorado_sync);

			}
		}

		//Provas Mestrado

		//$mestrados = $periodo->areas()->wherePivot('tipo', '=', 'M')->get()

		$provas_mestrado = (Input::has('provas_mestrado')) ? Input::get('provas_mestrado') : false ;


		if($provas_mestrado != false)
		{
			foreach($provas_mestrado as $area => $prova)
			{
				foreach($prova as $p)
				{
					$id = (isset($p['id'])) ? $p['id'] : null;

					$nova_prova =  ProvaMestrado::FirstOrNew(array('id' => $id));

					$nova_prova->id = $id;

					$nova_prova->periodo_area_id = $periodo->areas_mestrado()->wherePivot('area_id', '=', $area)->first()->pivot->id;

					$nova_prova->periodo_id = $periodo->id;

					$nova_prova->area_id = $area;

					$nova_prova->prova_id = $p['id_prova'];

					$nova_prova->identificador = $p['identificador'];

					$nova_prova->tipo = $p['tipo'];

					$nova_prova->nota_eliminatoria = $p['nota_eliminatoria'];

					$nova_prova->nota_classificatoria = $p['nota_classificatoria'];

					$nova_prova->save();
				}
			}

		}


		$provas_doutorado = (Input::has('provas_doutorado')) ? Input::get('provas_doutorado') : false ;


		if($provas_doutorado != false)
		{
			foreach($provas_doutorado as $area => $prova)
			{
				foreach($prova as $p)
				{
					$id = (isset($p['id'])) ? $p['id'] : null;

					$nova_prova = ProvaDoutorado::FirstOrNew(array('id' => $id));

					$nova_prova->id = $id;

					$nova_prova->periodo_area_id = $periodo->areas_doutorado()->wherePivot('area_id', '=', $area)->first()->pivot->id;

					$nova_prova->periodo_id = $periodo->id;

					$nova_prova->area_id = $area;

					$nova_prova->prova_id = $p['id_prova'];

					$nova_prova->identificador = $p['identificador'];

					$nova_prova->tipo = $p['tipo'];

					$nova_prova->nota_eliminatoria = $p['nota_eliminatoria'];

					$nova_prova->nota_classificatoria = $p['nota_classificatoria'];

					$nova_prova->save();
				}


			}

		}

		//return View::make('hello');


		if(isset($warning))
		{
			return Redirect::to('adm/periodo/')->with('warning', $warning);
		}
		else
		{
			return Redirect::to('adm/periodo/')->with('success', $success);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /adm/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function formatDate($date)
	{
		$e_date = explode('/', $date);

		$f_date = $e_date[2] . '-' . $e_date[1] . '-' . $e_date[0];

		return $f_date;
	}

	private function formatDateBack($date)
	{
		$e_date = explode('-', $date);

		$f_date = $e_date[2] . '/' . $e_date[1] . '/' . $e_date[0];

		return $f_date;
	}

	public function teste()
	{
		dd('dasdas');
	}

}