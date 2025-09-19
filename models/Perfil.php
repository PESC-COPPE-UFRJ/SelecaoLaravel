<?php

class Perfil extends \Eloquent {

	protected $table = 'perfis';

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function menus()
	{
		return $this->belongsToMany('Menu', 'menus_perfis', 'perfil_id', 'menu_id')->orderBy('ordem', 'ASC');
	}

}