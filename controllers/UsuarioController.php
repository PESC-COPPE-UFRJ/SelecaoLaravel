<?php

class UsuarioController extends \BaseController {

	/**
	 * Display a listing of usuarios
	 *
	 * @return Response
	 */
	public function index()
	{

		$usuarios = New Usuario;

		if(Input::has('_search') && (Input::has('nome') || Input::has('email') || Input::has('status')))
		{
			if(Input::has('nome') && !empty(Input::get('nome')))
			{
				$usuarios = $usuarios->Where('nome', 'LIKE', '%'.Input::get('nome').'%');
			}
			if(Input::has('email') && !empty(Input::get('email')))
			{
				$usuarios = $usuarios->Where('email', 'LIKE', '%'.Input::get('email').'%');
			}
			if(Input::has('status') && !empty(Input::get('status')))
			{
				$usuarios = $usuarios->Where('situacao', Input::get('status'));
			}
		}

		$usuarios = $usuarios->OrderBy('nome', 'ASC')->with('perfis')->paginate(15);


		debug($usuarios);

		if($usuarios)
		{
			$usuarios->each(function($user)
			{
				$perfis = null;
				foreach($user->perfis as $perfil)
				{
					$perfis .= $perfil->nome . ', ';
				}

				$perfis = rtrim($perfis, ', ');

				if(empty($perfis))
				{
					$perfis = null;
				}

				switch ($user->situacao) {
					case 0:
						$user->situacao = 'Inativo';
						break;

					case 1:
						$user->situacao = 'Ativo';
						break;
				}

				$user->perfis = $perfis;
			});

		}

		return View::make('adm.usuarios.index', compact('usuarios'));
	}

	/**
	 * Show the form for creating a new usuario
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('adm.usuarios.create');
	}

	/**
	 * Store a newly created usuario in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Usuario::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Usuario::create($data);

		return Redirect::route('adm.usuarios.index');
	}

	/**
	 * Display the specified usuario.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$usuario = Usuario::findOrFail($id);

		return View::make('adm.usuarios.show', compact('usuario'));
	}

	/**
	 * Show the form for editing the specified usuario.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$usuario = Usuario::with('perfis', 'areas')->find($id);

		$perfis = Perfil::all()->lists('nome', 'id');

		$areas = Area::all()->lists('nome', 'id');

		// debug($usuario);
		// debug($areas);

		return View::make('adm.usuarios.edit', compact('usuario'))->with('perfis', $perfis)->with('areas', $areas);
	}

	/**
	 * Update the specified usuario in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$usuario = Usuario::findOrFail($id);

		if(Input::has('perfis'))
		{
			$usuario->perfis()->sync(Input::get('perfis'));
		}
		if(Input::has('areas'))
		{
			$usuario->areas()->sync(Input::get('areas'));
		}

		// $usuario->update($data);

		return Redirect::to('adm/usuario/')->with('success', array('Usuário atualizado.'));
	}

	/**
	 * Remove the specified usuario from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Usuario::destroy($id);

		return Redirect::route('adm.usuarios.index');
	}

}
