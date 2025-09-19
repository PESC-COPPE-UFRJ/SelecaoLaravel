<?php

class Periodo extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	//protected $fillable = [];

	protected $guarded = array();

	public function areas_mestrado()
	{
		return $this->belongsToMany('Area', 'periodos_areas_mestrado', 'periodo_id', 'area_id')->withPivot('id', 'num_vagas')->orderBy('areas.nome', 'ASC');
	}

	public function areas_doutorado()
	{
		return $this->belongsToMany('Area', 'periodos_areas_doutorado', 'periodo_id', 'area_id')->withPivot('id', 'num_vagas')->orderBy('areas.nome', 'ASC');
	}

	public function areas_mestrado_get()
	{
		return $this->hasMany('AreaMestrado', 'periodo_id');
	}

	public function areas_doutorado_get()
	{
		return $this->hasMany('AreaDoutorado', 'periodo_id');
	}

	public function provas_mestrado()
	{
		return $this->hasMany('ProvaMestrado', 'periodo_id');
	}

	public function provas_doutorado()
	{
		return $this->hasMany('ProvaDoutorado', 'periodo_id');
	}

	public function inscricoes($cursos = false)
	{
		$relacao =  $this->hasMany('Inscricao', 'periodo_id');

		if($cursos && is_array($cursos))
		{			
			$relacao = $relacao->whereIn('curso', $cursos);			
		}

		return $relacao;
	}

}