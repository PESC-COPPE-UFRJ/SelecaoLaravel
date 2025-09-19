<?php

class Mensagem extends \Eloquent {
	protected $fillable = [];
	protected $table = 'mensagens';

	public function remetente()
	{
		return $this->belongsTo('Usuario', 'id_remetente', 'id');
	}

	public function destinatario()
	{
		return $this->belongsTo('Usuario', 'id_destinatario', 'id');
	}

	public function status()
	{
		return $this->belongsTo('MensagemStatus', 'id_status');
	}

	public function setMensagemAttribute($msg)
	{
		$periodo 	= (Whelper::ChecaPeriodo()) ? Whelper::ChecaPeriodo()->ano . '/' . Whelper::ChecaPeriodo()->periodo : 'Nenhum Periodo Ativo';
		$to 		= Usuario::find($this->attributes['id_destinatario']);

		$vars 							= array('$usuario$', '$email$', '$periodo_ativo$');
		$replace 						= array($to->nome, $to->email, $periodo);
		$this->attributes['mensagem'] 	= str_replace($vars, $replace, $msg);
	}
}