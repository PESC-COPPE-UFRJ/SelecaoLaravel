<?php

class FaqController extends \BaseController
{

	public function getIndex()
	{
		$categorias = Categoria::all();
		return View::make('painel_candidato.faqs.index')->with('categorias', $categorias);
	}

	public function getFaqDetalhe($id) 
	{			
		$categoria = Categoria::find($id);
		return View::make('painel_candidato.faqs.faq_detalhe')->with('categoria', $categoria);		
	}

	public function getLista()
	{
        // debug(Inscricao::with('usuario','areas','status', 'periodo')->where('curso','=',$tipoInscricao)->get()->toArray());

        $filter = DataFilter::source(Faq::with('categoria'));
        $filter->text('pergunta','Pergunta');
        $filter->text('resposta','Resposta');
        $filter->select('categoria.nome','Linha')->options(Categoria::lists('nome', 'id'));
        $filter->submit('Pesquisar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->add('{{$categoria->nome}}','Categoria');
        $grid->add('pergunta','Pergunta', true);
        $grid->add('resposta','Resposta', true);
        $grid->add('
                    <button class="btn btn-danger remove" questionid="{{$id}}"><span class="glyphicon glyphicon-remove"></span></button>
                    
                    <a href="faqs/edit-faq/{{$id}}">
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
                    </a>
                    ', '');
        //$grid->edit('professor/inscricao/form', '','show|modify|delete');
        $grid->orderBy('id','desc');
        $grid->paginate(10);

        return  View::make('adm.faqs.lista_faqs', compact('filter', 'grid'));
	}


	public function getNova()
	{

		//or find a record to update some value
		//$form = DataForm::source(Article::find(1));

		//categoria, nome, email, publicado, ordem

		//start with empty form to create new Article
		$form = DataForm::source(new Faq);

		//add fields to the form
		$form->select('categoria.nome','Categoria')->options(Categoria::lists('nome', 'id')); 
		$form->text('pergunta','Pergunta'); 
		$form->text('resposta','Resposta'); 
		//$form->add('nome','');
		//$form->add('email','');
		$form->checkbox('publicado','Publicado');
		$form->text('ordem','Ordem');

		//submit button
		$form->submit('Salvar');
		$form->build();

		// at the end you can use closure to add stuffs or redirect after save
		// $form->saved(function() use ($form)
		// {
		//     $form->message("ok record saved");
		//     $form->link("/another/url","Next Step");
		// });

		return View::make('adm.faqs.nova_faq', compact('form'));
	}

	public function postNova()
	{
		//
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		// //executando validação
		// $validacao = Validator::make($inputs);

		// //se a validação deu errado
		// if ($validacao->fails())
		// {
		// 	return Redirect::to('candidato/meusdados/dados-pessoais')->with('danger', $validacao->messages()->getMessages());
		// }
		// else
		// {

			$faq = new Faq;
			$faq->categoria_id = $categoria_nome;
			$faq->pergunta     = $pergunta;
			$faq->resposta     = $resposta;
			$faq->nome         = $usuario;
			$faq->email        = $email;
			$faq->publicado    = $publicado;
			$faq->ordem        = $ordem;
			$faq->save();

			return Redirect::to('faqs/lista');
		// }
	}

	public function getEditFaq($id) 
	{

		//or find a record to update some value
		$form = DataForm::source(Faq::find($id));

		//categoria, nome, email, publicado, ordem

		//start with empty form to create new Article
		//$form = DataForm::source(new Faq);

		//add fields to the form
		$form->select('categoria.nome','Categoria')->options(Categoria::lists('nome', 'id')); 
		$form->text('pergunta','Pergunta'); 
		$form->text('resposta','Resposta'); 
		$form->hidden('teste','teste');
		//$form->add('email','');
		$form->checkbox('publicado','Publicado');
		$form->text('ordem','Ordem');

		//submit button
		$form->submit('Salvar');
		$form->build();

		// at the end you can use closure to add stuffs or redirect after save
		// $form->saved(function() use ($form)
		// {
		//     $form->message("ok record saved");
		//     $form->link("/another/url","Next Step");
		// });

		return View::make('adm.faqs.edit_faq', compact('form','id'));
	}

	public function postEditFaq()
	{
		//
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		// //executando validação
		// $validacao = Validator::make($inputs);

		// //se a validação deu errado
		// if ($validacao->fails())
		// {
		// 	return Redirect::to('candidato/meusdados/dados-pessoais')->with('danger', $validacao->messages()->getMessages());
		// }
		// else
		// {

			$faq = Faq::find($id);
			$faq->categoria_id = $categoria_nome;
			$faq->pergunta     = $pergunta;
			$faq->resposta     = $resposta;
			$faq->nome         = $usuario;
			$faq->email        = $email;
			$faq->publicado    = $publicado;
			$faq->ordem        = $ordem;
			$faq->save();

			return Redirect::to('faqs/lista');
		// }
	}

	public function getDelete()
	{
		if(Input::has('idPergunta')){
			$idPergunta = Input::get('idPergunta');
			$faq = Faq::find($idPergunta);
			$faq->delete();
		}
		return Redirect::to('faqs/lista');
	}

	public function getCategoriaLista()
	{
        // debug(Inscricao::with('usuario','areas','status', 'periodo')->where('curso','=',$tipoInscricao)->get()->toArray());

        $filter = DataFilter::source(Categoria::with('faqs')->orderBy('nome','ASC'));
        $filter->select('id','Categoria')->options(Categoria::lists('nome', 'id'));
        $filter->submit('Pesquisar');
        $filter->build();

        $grid = DataGrid::source($filter);
        $grid->add('{{$nome}}','Categoria');
        $grid->add('
                    <button class="btn btn-danger remove" questionid="{{$id}}" qtdfaq="{{count($faqs)}}"><span class="glyphicon glyphicon-remove"></span></button>
                    ', '');
        //$grid->edit('professor/inscricao/form', '','show|modify|delete');
        $grid->orderBy('id','desc');
        $grid->paginate(10);

        return  View::make('adm.faqs.lista_categorias', compact('filter', 'grid'));
	}

	public function getDeleteCategoria()
	{
		if(Input::has('idCategoria')){
			$idCategoria = Input::get('idCategoria');
			$categoria = Categoria::find($idCategoria);
			$categoria->delete();
		}
		return Redirect::to('faqs/categoria-lista');
	}

	public function getNovaCategoria()
	{
		$form = DataForm::source(new Categoria);

		$form->text('nome','Nome'); 
		$form->text('descricao','Descrição'); 
		$form->submit('Salvar');
		$form->build();

		return View::make('adm.faqs.nova_categoria', compact('form'));
	}

	public function postNovaCategoria()
	{
		$inputs = Input::all();

		foreach($inputs as $key => $value)
		{
			$$key = $value;
		}

		$categoria = new Categoria;
		$categoria->titulo    = $nome;
		$categoria->nome      = $nome;
		$categoria->imagem    = "";
		$categoria->descricao = $descricao;
		$categoria->publicado = "1";
		$categoria->ordem     = "1";
		$categoria->save();

		return Redirect::to('faqs/categoria-lista');
	}
}