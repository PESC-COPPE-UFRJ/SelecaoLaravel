<?php
class AreaDoutorado extends Eloquent
{
	public $table = 'periodos_areas_doutorado';


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
		return $this->hasMany('ProvaDoutorado', 'periodo_area_id');
	}

}