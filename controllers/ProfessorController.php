<?php

class ProfessorController extends \BaseController {

	public function getDadosPessoais()
	{
		$user = Usuario::find(Auth::user()->id);

		return View::make('painel_professor.meus_dados.dados_pessoais')->with('user', $user);
	}

	public function postDadosPessoais()
	{
		$input = Input::all();


		$v = Validator::make($input, [
        'nome_completo' => 'required',
        'email' => 'required',
	    ]);

	    if ($v->fails())
	    {
	        return Redirect::back()->withErrors($v->errors());
	    }

		$user = Usuario::find(Auth::user()->id);

		if(!empty($input['email']))
		{
			$email_check = Usuario::where('email', '=', $input['email'])->first();
			if(empty($email_check) || $email_check->id == $user->id)
			{
				$user->nome = $input['nome_completo'];
				$user->email = $input['email'];

				$user->save();

				return Redirect::back()->with('success', array('Dados atualizados'));
			}
			else
			{
				return Redirect::back()->with('danger', array('Email já consta no sistema'));
			}
		}

	}

}
