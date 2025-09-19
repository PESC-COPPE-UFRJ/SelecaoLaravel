<?php
class Area extends Eloquent
{
	public $table = 'areas';


	public function inscricoes()
	{
		return $this->belongsToMany('Inscricao', 'areas_inscricoes', 'area_id', 'inscricao_id')->withPivot('periodo_id');
	}

	// public function inscricoesPeriodoAtual()
	// {

	// 	$result = $this->belongsToMany('Inscricao', 'areas_inscricoes', 'area_id', 'inscricao_id')->withPivot('periodo_id');
	// 	if(Whelper::ChecaPeriodo())
	// 	{
	// 		debug(Whelper::ChecaPeriodo()->id);
	// 		$result = $result->wherePivot('periodo_id', Whelper::ChecaPeriodo()->id);
	// 	}

	// 	return $result;
	// }

	public function periodos()
	{
		return $this->belongsToMany('Periodo', 'periodos_areas', 'area_id', 'periodo_id')->withPivot('tipo', 'num_vagas');
	}

	public function scopeTemVagas($query)
	{
		return $query->where('num_vagas', '>', 0);
	}

}