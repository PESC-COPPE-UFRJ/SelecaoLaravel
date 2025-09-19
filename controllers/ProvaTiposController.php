<?php

class ProvaTiposController extends \BaseController {

	/**
	 * Display a listing of provatipos
	 *
	 * @return Response
	 */
	public function index()
	{
		$provatipos = Provatipo::all();

		return View::make('provatipos.index', compact('provatipos'));
	}

	/**
	 * Show the form for creating a new provatipo
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('provatipos.create');
	}

	/**
	 * Store a newly created provatipo in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Provatipo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Provatipo::create($data);

		return Redirect::route('provatipos.index');
	}

	/**
	 * Display the specified provatipo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$provatipo = Provatipo::findOrFail($id);

		return View::make('provatipos.show', compact('provatipo'));
	}

	/**
	 * Show the form for editing the specified provatipo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$provatipo = Provatipo::find($id);

		return View::make('provatipos.edit', compact('provatipo'));
	}

	/**
	 * Update the specified provatipo in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$provatipo = Provatipo::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Provatipo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$provatipo->update($data);

		return Redirect::route('provatipos.index');
	}

	/**
	 * Remove the specified provatipo from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Provatipo::destroy($id);

		return Redirect::route('provatipos.index');
	}

}
