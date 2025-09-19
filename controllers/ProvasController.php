<?php

class ProvasController extends \BaseController {

	public function __construct() {

        $this->beforeFilter('csrf', array('only' =>
                            array('store', 'update', 'destroyMany', 'destroy')));
    }

	/**
	 * Display a listing of provas
	 *
	 * @return Response
	 */
	public function index()
	{
		$provas = Prova::orderBy('nome', 'ASC')->paginate(10);

		$provas->each(function($prova)
		{
			$prova->publicado = $prova->publicado ? '<span class="label label-success"> Sim </span>' : '<span class="label label-danger"> Não </span>';
		});

		return View::make('adm.provas.index', compact('provas'));
	}

	/**
	 * Show the form for creating a new prova
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('adm.provas.create');
	}

	/**
	 * Store a newly created prova in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::except('_token'), Prova::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Prova::create($data);

		return Redirect::to('adm/prova')->with('success', array('Registro salvo.'));
	}

	/**
	 * Display the specified prova.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$prova = Prova::findOrFail($id);

		return View::make('adm.provas.show', compact('prova'));
	}

	/**
	 * Show the form for editing the specified prova.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$prova = Prova::find($id);

		return View::make('adm.provas.edit', compact('prova'));
	}

	/**
	 * Update the specified prova in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$prova = Prova::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Prova::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$prova->update($data);

		return Redirect::to('adm/prova')->with('success', array('Registro atualizado.'));
	}

	/**
	 * Remove the specified prova from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Prova::destroy($id);

		return Redirect::route('adm.provas.index');
	}

	public function destroyajax()
	{
		if(Input::has('prova_id') && Input::has('tipo'))
		{
			$id    = Input::get('prova_id');
			$tipo  = Input::get('tipo');
			if($tipo == "m"){
				$prova = ProvaMestrado::find($id);
			} elseif($tipo == "d") {
				$prova = ProvaDoutorado::find($id);
			}
			$prova->delete();
			debug($id);
		}
		return "true";
		
	}

	public function destroyMany()
	{
		if(Input::has('provas'))
		{
			$provas = Input::get('provas');

			foreach($provas as $prova)
			{
				Prova::destroy($prova);
			}
		}

		return Redirect::to('adm/prova')->with('success', array('Registros deletados.'));
	}

}
