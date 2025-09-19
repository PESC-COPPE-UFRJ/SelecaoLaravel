<?php

class DocumentoController extends BaseController
{

	public function getShow($id, $idPeriodo = null)
	{
		
		$candidato = Usuario::with('formacoes', 'experiencias')->find($id);

		if(!empty($idPeriodo)){
			$periodo_ativo = Periodo::where('id','=',$idPeriodo)->first();
		} else {
			$periodo_ativo = Whelper::ChecaPeriodo();
		}
		
		$inscricoes = array();
		
		if($periodo_ativo)
		{
			$inscricoes['dsc'] = $candidato->inscricao_atual($periodo_ativo, 'DSC')->get();
			$inscricoes['msc'] = $candidato->inscricao_atual($periodo_ativo, 'MSC')->get();						

			if($inscricoes['dsc']->isEmpty())
			{
				unset($inscricoes['dsc']);
			}
			else
			{
				$inscricoes['dsc'] = $inscricoes['dsc']->first();
			}
			if($inscricoes['msc']->isEmpty())
			{
				unset($inscricoes['msc']);
			}
			else
			{
				$inscricoes['msc'] = $inscricoes['msc']->first();
			}
		}

		$inscricoes = array_filter($inscricoes);

		$proficiencias_ingles = Imagem::where('imagemMorph_id','=', $candidato->id)->where('imagemMorph_type','=','ProficienciaIngles')->get();		
		
		return View::make('painel_professor.documentos.show')->with(compact('candidato', 'inscricoes', 'proficiencias_ingles'));
	}

}