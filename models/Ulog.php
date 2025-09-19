<?php

class Ulog extends \Eloquent 
{
	protected $table = 'logs';
	protected $fillable = [];

	public function usuario()
	{
		return $this->belongsTo('Usuario', 'usuario_id');
	}

	static function Novo($acao, $descricao)
	{
		$log = New Ulog;
		$log->acao 		= $acao;
		$log->descricao = $descricao;
		$log->usuario_id = Auth::user()->id;
		$log->save();
	}
}