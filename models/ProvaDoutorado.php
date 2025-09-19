<?php
class ProvaDoutorado extends Eloquent
{
	public $table = 'periodos_areas_provas_doutorado';

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
		return $this->belongsTo('PeriodoAreadoutorado', 'periodo_area_id');
	}

	public function area()
	{
		return $this->belongsTo('Area', 'area_id');
	}

	public function notas()
	{
		return $this->hasMany('ProvaNotaDoutorado', 'prova_id');
	}

}