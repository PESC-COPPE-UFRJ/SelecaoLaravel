<?php

/**
 * Patch scripts
 * Normalmente devem ser executados apenas uma vez
 */
class ScriptsController extends \BaseController
{
	
	/**
	 * Atualiza valor booleano de bolsas, alguns estão com S/N outros com 1/0
	 */
	function padronizaBooleanoBolsas()
	{		
		$inscricoes = Inscricao::all();		
		foreach ($inscricoes as $inscricao)
		{
			if ($inscricao->bolsa == '1' || $inscricao->bolsa == 'S')
			{
				$inscricao->bolsa = '1';
			}
			else
			{
				$inscricao->bolsa = '0';
				
			}
			$inscricao->save();
		}
	}
	
	
	/**
	 * Formata as notas para padrão com . como separador decimal
	 * Note que as notas são exibidas e atualizadas no sistema com ,
	 * Isto é apenas para armazenamento no banco para facilitar e padronizar operações
	 */
	function formataNotas()
	{
		$notas = ProvaNotaDoutorado::all();		
		foreach ($notas as $nota)
		{
			
			$string_number = $nota->nota;
			$number = floatval(str_replace(',', '.', $string_number));
			
			$nota->nota = $number;
			$nota->save();
		}
				
		$notas = ProvaNotaMestrado::all();		
		foreach ($notas as $nota)
		{
			
			$string_number = $nota->nota;
			$number = floatval(str_replace(',', '.', $string_number));
			
			$nota->nota = $number;
			$nota->save();
		}		
	}
	
	
	/**
	 * Formata os status de acordo com as notas e faltas
	 */
	function formataStatusNotas()
	{
		$notas = ProvaNotaDoutorado::all();
		foreach ($notas as $nota)
		{
			$string_nota = '';
			$status = '';
			if ($nota->falta == 1)
			{
				$string_nota = '';
				$status = 'FALTOU';
			}
			elseif ($nota->status == 'DISPENSADO')
			{
				$string_nota = '';
				$status = 'DISPENSADO';
			}
			elseif ($nota->nota == null  || $nota->nota == '')
			{
				$string_nota = '';
				$status = '';				
			}
			else
			{
				$string_nota = $nota->nota;
				$string_nota = str_replace(',', '.', $string_nota);
				if (is_numeric ($string_nota))
				{
					$string_nota = floatval($string_nota);
					if ($nota->prova)
					{
						if ($nota->prova->tipo == 'Classificatoria')
						{										
							if ($string_nota < $nota->prova->nota_classificatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}
						if ($nota->prova->tipo == 'Eliminatoria') 
						{										
							if ($string_nota < $nota->prova->nota_eliminatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}
					}
				}
			}
			
			$nota->nota = $string_nota;
			$nota->status = $status;
			$nota->save();		
		}
		
		$notas = ProvaNotaMestrado::all();	
		foreach ($notas as $nota)
		{
			$string_nota = '';
			$status = '';
			if ($nota->falta == 1)
			{
				$string_nota = '';
				$status = 'FALTOU';
			}
			elseif ($nota->status == 'DISPENSADO')
			{
				$string_nota = '';
				$status = 'DISPENSADO';
			}
			elseif ($nota->nota == null || $nota->nota == '')
			{
				$string_nota = '';
				$status = '';				
			}
			else
			{
				$string_nota = $nota->nota;
				$string_nota = str_replace(',', '.', $string_nota);
				if (is_numeric ($string_nota))
				{
					$string_nota = floatval($string_nota);
					if ($nota->prova)
					{
						if ($nota->prova->tipo == 'Classificatoria')
						{										
							if ($string_nota < $nota->prova->nota_classificatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}
						if ($nota->prova->tipo == 'Eliminatoria') 
						{										
							if ($string_nota < $nota->prova->nota_eliminatoria)
								$status = 'REPROVADO';
							else
								$status = 'APROVADO';
						}
					}
				}
			}
			
			$nota->nota = $string_nota;
			$nota->status = $status;
			$nota->save();		
		}
	}
	
	/**
	 * Reorganiza a estrutura de arquivos, criando uma pasta por usuário e colocando
	 * todos arquivos de um usuário nesta pasta organizadamente
	 * ATENÇÂO: é preciso atualizar algumas views e controllers para acessarem corretamente os arquivos depois do patch
	 */
	function correctFilesDir()
	{		
		$candidato = Usuario::whereBetween('id', [0,10])->get();
		
		$num_records = count($candidato);
		
		//dd(count($candidato));
		foreach ($candidato as $c)
		{						
			// imagens associadas ao candidato (move da pasta documentos genérica para pasta documentos do candidato)
			$dir_src = 'uploads/candidatos/documentos/';
			$dir_dst = 'uploads/usuarios/' . $c->id . '/documentos/';
			if (!file_exists($dir_dst)) {mkdir($dir_dst, 0755, true);}	
			
			//foto			
			$filename_src =  $c->foto;
			
			// se começar com / remove a mesma do nome
			if (!empty($filename_src) && $filename_src[0] == '/')
				$filename_src = substr($filename_src, 1);
			
			if (is_file($filename_src))
			{
				$filename_dst = $dir_dst . basename($filename_src);
				if ($filename_src != $filename_dst)
				{
					copy ($filename_src, $filename_dst);
					chmod($filename_dst, 0644);		
					$c->foto = $filename_dst;
					$c->save();
				}
			}
			
			// docs
			$images = array($c->identidade_img, $c->identidade_verso_img, $c->cpf_img, $c->titulo_eleitor_img, $c->titulo_eleitor_verso_img, $c->certificado_militar_img, $c->certificado_militar_verso_img);		
			foreach ($images as $imagefile)
			{
				if (!empty($imagefile))
				{			
					$filename_src = $dir_src . '/' . $imagefile;
					$filename_dst = $dir_dst . '/' . $imagefile;
					// already patched
					if ($filename_src != $filename_dst)
					{
						if (is_dir($filename_src))
							dd ($filename_src);
						copy ($filename_src, $filename_dst);
						chmod($filename_dst, 0644);
					}
				}
			}
			
			// formacoes									
			foreach($c->formacoes as $f)
			{
				$imagens = Imagem::where('imagemMorph_id','=', $f->id)->where('imagemMorph_type','=','Formacao')->get();
				foreach($imagens as $i)
				{
					$filename_src = $i->caminho . $i->nome;
					$dir_dst = 'uploads/usuarios/' . $c->id . '/documentos/formacoes/' . $f->id . '/';
					$filename_dst = $dir_dst . $i->nome;

					// check if already patched
					if ($filename_src != $filename_dst)
					{							
						if (!file_exists($dir_dst))
						{
							mkdir($dir_dst, 0755, true);
						}							

						copy ($filename_src, $filename_dst);
						chmod($filename_dst, 0644);

						$i->imagemMorph_type = 'Formacao';
						$i->caminho = $dir_dst;
						$i->imagemMorph_id = $f->id;
						$i->save();
					}
				}								
			}												

			// proficiencia em ingles
			$proficiencias_ingles = Imagem::where('imagemMorph_id','=', $c->id)->where('imagemMorph_type','=','Usuario')->get();		
			foreach($proficiencias_ingles as $i)
			{								
				$filename_src = $i->caminho . $i->nome;
				$dir_dst = 'uploads/usuarios/' . $c->id . '/documentos/proficienciaIngles/';
				$filename_dst = $dir_dst . $i->nome;				
					
				// already patched
				if ($filename_src != $filename_dst)
				{					
					if (!file_exists($dir_dst))
					{
						mkdir($dir_dst, 0755, true);
					}							

					copy ($filename_src, $filename_dst);
					chmod($filename_dst, 0644);

					$i->imagemMorph_type = 'ProficienciaIngles';
					$i->caminho = $dir_dst;
					$i->imagemMorph_id = $c->id;
					$i->save();					
				}
				
			}
			
			
			// imagens associadas às inscrições (modph id = id do usuario)
			$allinsc = Inscricao::WHERE('usuario_id', '=', $c->id)->get();
			foreach($allinsc as $insc)
			{										
				// imagens associadas à uma área de inscrição
// 				foreach($insc->areasInscricoes as $a)
// 				{
// 					foreach($a->imagens as $i)
// 					{
					
// 						$filename_src = $i->caminho . $i->nome;
// 						$dir_dst = 'uploads/usuarios/' . $c->id . '/inscricoes/' . $insc->id . '/areas/' . $a->id . '/';
// 						$filename_dst = $dir_dst . '/' . $i->nome;

// 						// already patched
// 						if ($filename_src != $filename_dst) 
// 						{
// 							if (!file_exists($dir_dst))
// 							{
// 								mkdir($dir_dst, 0755, true);
// 							}							
// 							copy ($filename_src, $filename_dst);
// 							chmod($filename_dst, 0644);

// 							$i->imagemMorph_type = 'AreaInscricao';
// 							$i->caminho = $dir_dst;
// 							$i->imagemMorph_id = $a->id;
// 							$i->save();
// 						}						
// 					}									
// 				}
				
				// imagens associadas à uma inscrição
				foreach($insc->imagens as $i)
				{		
					$filename_src = $i->caminho . $i->nome;
					// se for Plano de Pesquisa insere em todas áreas da inscrição (não sabemos qual é qual no modelo anterior)
					if ($i->titulo === 'Plano de pesquisa')
					{
						foreach($insc->areasInscricoes as $a)
						{
							$dir_dst = 'uploads/usuarios/' . $c->id . '/inscricoes/' . $insc->id . '/areas/' . $a->id . '/';
							$filename_dst = $dir_dst . $i->nome;

							// already patched
							if ($filename_src != $filename_dst)
							{
								if (!file_exists($dir_dst))
								{
									mkdir($dir_dst, 0755, true);
								}							

								copy ($filename_src, $filename_dst);
								chmod($filename_dst, 0644);

								$i->imagemMorph_type = 'AreaInscricao';
								$i->caminho = $dir_dst;
								$i->imagemMorph_id = $a->id;
								$i->save();
							}
						}
					}								
					// se não for plano de pesquisa coloca na pasta da inscrição e não da área
					else
					{
						$dir_dst = 'uploads/usuarios/' . $c->id . '/inscricoes/' . $insc->id . '/';
						$filename_dst = $dir_dst . $i->nome;

						// already patched
						if ($filename_src != $filename_dst)
						{						
							if (!file_exists($dir_dst))
							{
								mkdir($dir_dst, 0755, true);
							}							

							copy ($filename_src, $filename_dst);
							chmod($filename_dst, 0644);

							$i->caminho = $dir_dst;
							$i->save();
						}
					}			
				}
				
			}
		}
		//return View::make('adm/scripts.index');
		//return View::make('painel_professor.documentos.show')->with(compact('candidato', 'inscricoes', 'proficiencias_ingles'));
	}
	
	/**
	 * Display a listing of the resource.
	 * GET /mensagempadrao
	 *
	 * @return Response
	 */
	public function index()
	{		
		return View::make('adm/scripts.index');
	}
	
	public function create()
	{
	}
	
	public function store()
	{
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
	
	public function update($id)
	{

	}
	
	public function edit($id)
	{
		//
		if ($id == 1)
			$this->correctFilesDir();
		if ($id == 2)
			$this->formataNotas();
		if ($id == 3)
			$this->formataStatusNotas();
		if ($id == 4)
			$this->padronizaBooleanoBolsas();

		
		return View::make('adm/scripts.index');
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