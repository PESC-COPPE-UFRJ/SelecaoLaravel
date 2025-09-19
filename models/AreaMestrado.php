<?php
class AreaMestrado extends Eloquent
{
	public $table = 'periodos_areas_mestrado';


	// public function provas()
	// {
	// 	return $this->belongsToMany('Prova', 'periodos_areas_provas', 'periodo_area_id', 'prova_id')->withPivot('identificador', 'tipo', 'nota_eliminatoria', 'nota_classificatoria');
	// }


	public function area()
	{
		return $this->belongsTo('Area', 'area_id');
	}

	public function provas()
	{
		return $this->hasMany('ProvaMestrado', 'periodo_area_id');
	}

}