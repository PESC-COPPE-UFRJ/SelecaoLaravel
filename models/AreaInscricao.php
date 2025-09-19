<?php

class AreaInscricao extends \Eloquent {
	protected $table = 'areas_inscricoes';
	protected $fillable = [];

	public function inscricao()
	{
		return $this->belongsTo('Inscricao', 'inscricao_id');
	}

	public function area()
	{
		return $this->belongsTo('Area', 'area_id');
	}

	public function status()
	{
		return $this->belongsTo('Status', 'status_id');
	}

	public function statusHistorico()
	{
		return $this->hasMany('AreaInscricaoStatusHistorico', 'area_inscricao_id');
	}	
		
	public function imagens()
	{
		return $this->morphMany('Imagem','imagemMorph');
	}
}