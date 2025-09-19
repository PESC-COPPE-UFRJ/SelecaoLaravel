<?php

class MensagemPadraoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /mensagempadrao
	 *
	 * @return Response
	 */
	public function index()
	{
		$mensagens = MensagemPadrao::paginate(10);

		return View::make('mensagens_padrao.index', compact('mensagens'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /mensagempadrao/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('mensagens_padrao.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /mensagempadrao
	 *
	 * @return Response
	 */
	public function store()
	{

		if(Input::has('titulo') && Input::has('mensagem'))
		{
			$mensagem = new MensagemPadrao;
			$mensagem->titulo = Input::get('titulo');
			$mensagem->mensagem = Input::get('mensagem');
			$mensagem->save();

			return Redirect::to('adm/mensagem_padrao')->with('success', array('Mensagem Padrão criada com sucesso!'));
		}

		return Redirect::to('adm/mensagem_padrao')->with('danger', array('Algum dos campos não foram preenchidos corretamente'));
	}

	/**
	 * Display the specified resource.
	 * GET /mensagempadrao/{id}
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
	 * GET /mensagempadrao/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$mensagem = MensagemPadrao::findOrFail($id);

		return View::make('mensagens_padrao.edit', compact('mensagem'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /mensagempadrao/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		if(Input::has('titulo') && Input::has('mensagem'))
		{
			$mensagem = MensagemPadrao::findOrFail($id);

			$mensagem->titulo 	= Input::get('titulo');
			$mensagem->mensagem = Input::get('mensagem');
			$mensagem->save();

			return Redirect::to('adm/mensagem_padrao')->with('success', array('Mensagem Padrão criada com sucesso!'));
		}

	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /mensagempadrao/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}