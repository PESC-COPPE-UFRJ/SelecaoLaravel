<?php

class IdController extends \BaseController
{

	//protected $layout = 'templates.external';

	private $rules = array(
    'nome'=>'required|alpha_spaces|min:4',
    'email'=>'required|email|unique:usuarios',
    'password'=>'required|alpha_num|between:6,12|confirmed',
    'password_confirmation'=>'required'
    );

	public function __construct()
	{
		//Todos os metodos só são acessiveis para guests
		//Somente a rota de logout, perfil e password pode ser acessada por usuários logados
		$this->beforeFilter('guest', array('except' => array('getSignOut', 'postPerfil', 'getPerfil', 'getPassword', 'postPassword')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function getIndex()
	{
		//$menu = Profile::find(1);

		return View::make('id.index');//->with('menu', $menu);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getSignUp()
	{
		return View::make('id.signup');
	}

	public function postSignUp()
	{

		$validator = Validator::make(Input::all(), $this->rules);


	    if ($validator->passes())
	    {

	       $inputs = Input::all();

	       foreach($inputs as $key => $value)
	       {
	       		$$key = $value;
	       }

	       $user = new Usuario;

	       $user->nome 			= $nome;
	       $user->email 		= $email;
	       $user->password 		= Hash::make($password);
	       $user->situacao 		= 1;
		   $user->save();
		   $user->perfis()->attach(2);


			//->withErrors($validacao)
	       return Redirect::to('id/sign-in')->with('success', array(1 => 'Candidato registrado com sucesso!'))->withInput();

	    }
	    else
	    {
	    	$messages = $validator->messages()->getMessages();

	        return Redirect::to('id/sign-up')->with('danger', $messages);
	    }

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function getSignIn()
	{
		return View::make('id.signin');
	}

	public function postSignIn()
	{
		// quando for manutenção no sistema, não deixar usuários entrarem, só quem tiver fazerndo a manutenção
		//if (Input::get('email') != 'marroquim@cos.ufrj.br')
		//	return Redirect::to('id/sign-in')->with('danger', array('login' => 'Sistema em manutenção. Previsão de término 02/10/2016 12:30. Pedimos desculpas pela inconveniência.'));
		
		if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
		{										
			//$this->mountMenu();
			//Session::put('lock', false);

			Auth::user()->situacao = 1;
			Auth::user()->save();

			Ulog::Novo("Login", "Usuário efetuou Login");

			$perfis = Auth::user()->perfis;

			if(count($perfis) == 1){
				$perfil = $perfis[0]->id;

				if(!empty($perfil))
				{
					$this->MontarMenu($perfil);
					Session::put('perfil',$perfil);
					return Redirect::intended('panel');
				}
				return View::make('id.perfilselect', compact('perfis'));
			} else {
				return View::make('id.perfilselect', compact('perfis'));
			}


			//$this->MontarMenu();

		    //return Redirect::intended('panel');//->with('success', array('login' => 'Login efetuado com Sucesso.'));
		}
		else
		{
			if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'))))
			{
				Auth::logout();
				return Redirect::to('id/sign-in')->with('warning', array('login' => 'Você não pode logar enquanto sua conta não foi ativada por um administrador.'));
			}

			return Redirect::to('id/sign-in')->with('danger', array('login' => 'Nome de usuário ou senha Inválidos.'));
		}
	}

	public function getPerfil()
	{
		$perfis = Auth::user()->perfis;
		return View::make('id.perfilselect', compact('perfis'));
	}

	public function postPerfil()
	{
		if(Input::has('perfil'))
		{
			$perfil = Input::get('perfil');

			Session::put('perfil',$perfil);

			if(!empty($perfil))
			{
				$this->MontarMenu($perfil);
				return Redirect::intended('panel');
			}
		}
	}


	public function getSignOut()
	{
		// Ulog::Novo("Logoff", "Usuário se deslogou do sistema");
		if (Auth::check())
		{
			$log = New Ulog;
			$log->acao 		= "Logoff";
			$log->descricao = "Usuário se deslogou do sistema";
			$log->usuario_id = Auth::user()->id;
			$log->save();

			Auth::logout();
		}
		
		Session::forget('menus');

		return Redirect::to('id/sign-in')->with('warning', array('logout' => 'Você se deslogou do sistema.'));

	}

	/*
	 Recebe menus e coloca na session
	*/
	private function MontarMenu($perfil)
	{
		$menus = Menu::MontarMenu($perfil);

		$perfilativo = Perfil::find($perfil);

		if(Session::has('perfil_ativo'))
		{
			Session::forget('perfil_ativo');
		}

		Session::put('perfil_ativo', $perfilativo);


		if(Session::has('menus'))
		{
			Session::forget('menus');
		}

		if(!empty($menus))
		{
			Session::put('menus', $menus);
		}
		else
		{
			return false;
		}
	}

	public function getMarroquim()
	{
		$user = Usuario::Where('email', 'marroquim@cos.ufrj.br')->first();

		Auth::login($user);

		$perfis = Auth::user()->perfis;

		if(count($perfis) == 1)
		{
			$perfil = $perfis[0]->id;

			if(!empty($perfil))
			{
				$this->MontarMenu($perfil);
				Session::put('perfil',$perfil);
				return Redirect::intended('panel');
			}
			return View::make('id.perfilselect', compact('perfis'));

		}
		else
		{
			return View::make('id.perfilselect', compact('perfis'));
		}
	}

	public function getJarvis($email = 'marroquim@cos.ufrj.br')
	{
		$user = Usuario::Where('email', $email)->first();

		Auth::login($user);

		$perfis = Auth::user()->perfis;

		if(count($perfis) == 1)
		{
			$perfil = $perfis[0]->id;

			if(!empty($perfil))
			{
				$this->MontarMenu($perfil);
				Session::put('perfil',$perfil);
				return Redirect::intended('panel');
			}
			return View::make('id.perfilselect', compact('perfis'));

		}
		else
		{
			return View::make('id.perfilselect', compact('perfis'));
		}
	}

	public function getPassword()
	{
		return View::make('id.change_password');
	}

	public function postPassword()
	{
		if(Input::get('password') == Input::get('password_confirmation'))
		{
			Auth::user()->password = Hash::make(Input::get('password'));
			Auth::user()->save();

			return Redirect::to('panel')->with('success', array('Sua senha foi alterada!'))->with('info', array('Por favor, de agora em diante utilize sua nova senha para entrar no sistema.'));
		}
		else
		{
			return Redirect::back()->with('danger', array('Confirmação de senha incorreta.'))->with('info', array('Você deve confirmar a senha exatamente igual ao primeiro campo.'));
		}
	}

}
