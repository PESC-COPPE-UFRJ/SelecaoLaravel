<?php
class Nota extends Eloquent
{
	public $table = 'provas_notas';

	public function prova()
	{
		return $this->belongsTo('PeriodoArea');
	}
}