<?php
class Inscricao extends Eloquent
{
	protected $table = "inscricoes";

	public function areas()
	{
		return $this->belongsToMany('Area', 'areas_inscricoes', 'inscricao_id', 'area_id')->withPivot('id');
	}

	//Pivot de areas_inscricoes
	public function areasInscricoes()
	{
		return $this->hasMany('AreaInscricao', 'inscricao_id');
	}

	public function status()
	{
		return $this->belongsToMany('Status', 'inscricoes_status', 'inscricao_id', 'status_id')->withPivot('anotacoes', 'professor_id', 'created_at')->orderBy('pivot_created_at', 'ASC');
	}

	public function periodo()
	{
		return $this->belongsTo('Periodo','periodo_id');
	}

	public function usuario()
	{
		return $this->belongsTo('usuario','usuario_id');
	}

	public function provas()
	{		
		if ($this->curso == 'MSC')
		{
			return $this->belongsToMany('ProvaMestrado', 'provas_notas_mestrado', 'inscricao_id', 'prova_id')->withPivot('nota', 'status');			
		}
		else if ($this->curso == 'DSC')
		{
			return $this->belongsToMany('ProvaDoutorado', 'provas_notas_doutorado', 'inscricao_id', 'prova_id', 'publicado')->withPivot('nota', 'status');				
		}
		
	}
	
	public function provas_mestrado()
	{
		return $this->belongsToMany('ProvaMestrado', 'provas_notas_mestrado', 'inscricao_id', 'prova_id')->withPivot('nota', 'status');
	}

	public function provas_doutorado()
	{
		return $this->belongsToMany('ProvaDoutorado', 'provas_notas_doutorado', 'inscricao_id', 'prova_id', 'publicado')->withPivot('nota', 'status');
	}

	public function imagens()
	{
		return $this->morphMany('Imagem','imagemMorph');
	}
}