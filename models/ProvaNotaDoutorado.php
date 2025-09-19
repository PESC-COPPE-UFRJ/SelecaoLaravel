<?php
class ProvaNotaDoutorado extends Eloquent
{
	public $table = 'provas_notas_doutorado';

	protected $guarded = [];

	public $timestamps = false;

	public function inscricao()
	{
		return $this->belongsTo('Inscricao', 'inscricao_id');
	}

	public function prova()
	{
		return $this->belongsTo('ProvaDoutorado', 'prova_id');
	}

}