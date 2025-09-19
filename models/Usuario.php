<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Usuario extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	//public $table = 'jos_sel_candidato';
	protected $table = 'usuarios';

	protected $hidden = array('password', 'remember_token');


	public function getNascimentoAttribute($value)
	{
		if($value == '0000-00-00')
		{
			return '';
		}
		else
		{
			return Formatter::dateToString($value);
		}

	}

	public function setNascimentoAttribute($value)
	{
		$this->attributes['nascimento'] = Formatter::stringToDate($value);
	}

	public function getExpedicaoAttribute($value)
	{
		if($value == '0000-00-00')
		{
			return '';
		}
		else
		{
			return Formatter::dateToString($value);
		}
	}

	public function setExpedicaoAttribute($value)
	{
		$this->attributes['expedicao'] = Formatter::stringToDate($value);
	}
	
	public function getTituloeleitoremissaoAttribute($value)
	{
		if($value == '0000-00-00')
		{
			return '';
		}
		else
		{
			return Formatter::dateToString($value);
		}
	}
	
	public function setTituloeleitoremissaoAttribute($value)
	{
		$this->attributes['tituloeleitoremissao'] = Formatter::stringToDate($value);
	}
	
		public function getCertmilitaremissaoAttribute($value)
	{
		if($value == '0000-00-00')
		{
			return '';
		}
		else
		{
			return Formatter::dateToString($value);
		}
	}
	
	public function setCertmilitaremissaoAttribute($value)
	{
		$this->attributes['certmilitaremissao'] = Formatter::stringToDate($value);
	}
	
	public function areas()
	{
		return $this->belongsToMany('Area', 'areas_usuarios', 'usuario_id', 'area_id');
	}

	public function endereco()
	{
		return $this->hasOne('Endereco','usuario_id');
	}

	public function formacoes()
	{
		return $this->hasMany('Formacao','usuario_id');
	}

	public function experiencias()
	{
		return $this->hasMany('Experiencia','usuario_id');
	}

	public function perfis()
	{
		return $this->belongsToMany('Perfil', 'perfis_usuarios', 'usuario_id', 'perfil_id');
	}

	public function inscricoes()
	{
		return $this->hasMany('Inscricao', 'usuario_id');
	}

	public function inscricao_atual($periodo_atual, $tipo)
	{
		return $this->hasMany('Inscricao', 'usuario_id')->Where('periodo_id', '=', $periodo_atual->id)->Where('curso', '=', $tipo);
	}

	public function mestrado()
	{
		return $this->hasOne('Inscricao', 'usuario_id')->where('curso', '=', 'MSC')->orderBy('created_at', 'DESC');
	}

	public function doutorado()
	{
		return $this->hasOne('Inscricao', 'usuario_id')->where('curso', '=', 'DSC')->orderBy('created_at', 'DESC');
	}

	public function docencias()
	{
		return $this->hasMany('Docencia', 'usuario_id');
	}

	public function outrasinfos()
	{
		return $this->hasOne('OutraInfo', 'usuario_id');
	}

	public function premios()
	{
		return $this->hasMany('Premio', 'usuario_id');
	}

	public function candidaturas_previas()
	{
		return $this->hasMany('CandidaturaPrevia', 'usuario_id');
	}

	public function outras_candidaturas()
	{
		return $this->hasMany('OutraCandidatura', 'usuario_id');
	}

	public function getCPFFormatado()
	{
		$parte1 = substr($this->cpf,0,3);
		$parte2 = substr($this->cpf,3,3);
		$parte3 = substr($this->cpf,6,3);
		$parte4 = substr($this->cpf,9,2);

		return "$parte1.$parte2.$parte3-$parte4";
	}

	public function logs()
	{
		return $this->hasMany('Log', 'usuario_id');
	}
}