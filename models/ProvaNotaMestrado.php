<?php
class ProvaNotaMestrado extends Eloquent
{
	public $table = 'provas_notas_mestrado';

	protected $guarded = [];

	public $timestamps = false;

	public function inscricao()
	{
		return $this->belongsTo('Inscricao', 'inscricao_id');
	}

	public function prova()
	{
		return $this->belongsTo('ProvaMestrado', 'prova_id');
	}

}