<?php
class ProvaMestrado extends Eloquent
{
	public $table = 'periodos_areas_provas_mestrado';

	protected $guarded = [];


	// public function provas()
	// {
	// 	return $this->belongsToMany('Prova', 'periodos_areas_provas', 'periodo_area_id', 'prova_id')->withPivot('identificador', 'tipo', 'nota_eliminatoria', 'nota_classificatoria');
	// }

	public function prova()
	{
		return $this->belongsTo('Prova', 'prova_id');
	}

	public function periodoArea()
	{
		return $this->belongsTo('PeriodoAreaMestrado', 'periodo_area_id');
	}

	public function inscricao_mestrado()
	{
		return $this->belongsToMany('Inscricao', 'provas_notas_mestrado', 'prova_id', 'inscricao_id');
	}

	public function inscricao_doutorado()
	{
		return $this->belongsToMany('Inscricao', 'provas_notas_doutorado', 'prova_id', 'inscricao_id');
	}

	public function area()
	{
		return $this->belongsTo('Area', 'area_id');
	}

	public function scopeDaArea($query, $area_id)
	{
		return $query->where('area_id', $area_id);
	}

	public function notas()
	{
		return $this->hasMany('ProvaNotaMestrado', 'prova_id');
	}


}