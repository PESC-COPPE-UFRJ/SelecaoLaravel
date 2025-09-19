<?php
class EstadoCivil extends Eloquent {

	public $table = 'estado_civil';

	public function getEstadoCivil()
	{
		return strtoupper(substr($this->nome,0,3));
	}
}