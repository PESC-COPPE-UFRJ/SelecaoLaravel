<?php

class AreaInscricaoStatusHistorico extends \Eloquent {
	protected $table = 'areas_inscricoes_status_historico';
	protected $guarded = [];

	public function area()
	{
		return $this->belongsTo('Area', 'area_id');
	}

	public function status()
	{
		return $this->belongsTo('Status', 'status_id');
	}
}