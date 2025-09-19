<?php

class PerfilController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$perfis = Perfil::paginate(15);

		return View::make('adm.perfil.index')->with('perfis', $perfis);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$menus = Menu::with('submenus')->where('parent_id', '=', 0)->orWhere('parent_id', '=', NULL)->get();

		// debug($menus);

		return View::make('adm.perfil.create')->with('menus', $menus);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$Nome    		 = Input::get('Nome');
		$menus 			 = Input::get('menus');
		$submenus 		 = Input::get('submenus');

		if(Input::has('Nome'))
		{

			$perfil = new Perfil;

			$perfil->nome 		= $Nome;
			$perfil->save();

			if(Input::has('menus'))
			{
				$perfil->menus()->sync($menus);
			}

			return Redirect::to('adm/perfil')->with('success', array(1 => 'Perfil criado com Sucesso!'));
		}
		else
		{
			return Redirect::to('adm/perfil/create')->with('danger', array(1 => 'É obrigatório selecionar um nome para o Perfil'));
		}

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perfil = Perfil::find($id);

		$menus = Menu::with('submenus')->where('parent_id', '=', 0)->orWhere('parent_id', '=', NULL)->get();

		if($perfil)
		{

			return  View::make('adm.perfil.edit')->with('perfil', $perfil)
															   ->with('menus', $menus);

		}
		else
		{
			return Redirect::to('adm/perfil/index')->with('danger', array(1 => 'Perfil não encontrado, tente novamente.'));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$perfil = Perfil::find($id);

		if($perfil)
		{
			if(Input::has('nome'))
			{
				$perfil->nome = Input::get('nome');
				$perfil->save();

				if(Input::has('menus'))
				{
					$perfil->menus()->detach();
					$perfil->menus()->sync(Input::get('menus'));
				}

				return Redirect::to('adm/perfil')->with('success', array(1 => "O perfil $perfil->nome foi alterado com sucesso"));

			}
			else
			{
				return Redirect::to("adm/perfil/$id/edit")->with('danger', array(1 => 'É obrigatório selecionar um nome para o Perfil'));

			}
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
