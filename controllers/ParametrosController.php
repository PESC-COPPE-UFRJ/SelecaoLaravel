<?php

class ParametrosController extends \BaseController {

	/**
	 * Display a listing of parametros
	 *
	 * @return Response
	 */
	public function index()
	{
		$parametros = Parametro::all();

		return View::make('parametros.index', compact('parametros'));
	}

	/**
	 * Show the form for creating a new parametro
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('parametros.create');
	}

	/**
	 * Store a newly created parametro in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Parametro::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Parametro::create($data);

		return Redirect::route('parametros.index');
	}

	/**
	 * Display the specified parametro.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$parametro = Parametro::findOrFail($id);

		return View::make('parametros.show', compact('parametro'));
	}

	/**
	 * Show the form for editing the specified parametro.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$parametro = Parametro::find($id);

		return View::make('parametros.edit', compact('parametro'));
	}

	/**
	 * Update the specified parametro in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$parametro = Parametro::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Parametro::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$parametro->update($data);

		return Redirect::route('parametros.index');
	}

	/**
	 * Remove the specified parametro from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Parametro::destroy($id);

		return Redirect::route('parametros.index');
	}

}
