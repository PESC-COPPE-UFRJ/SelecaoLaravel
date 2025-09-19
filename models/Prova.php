<?php

class Prova extends \Eloquent {

	protected $table = 'provas';

	// Add your validation rules here
	public static $rules = [
		 'nome' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['nome', 'publicado', 'sigla'];

}