<?php
class OutraInfo extends Eloquent {

	public $table = 'outras_informacoes';

	public function premios()
	{
		return $this->hasMany('Premio','outras_infos_id');
	}

	public function candidaturasprevias()
	{
		return $this->hasMany('CandidaturaPrevia','outras_infos_id');
	}

	public function outrascandidaturas()
	{
		return $this->hasMany('OutraCandidatura','outras_infos_id');
	}	
}