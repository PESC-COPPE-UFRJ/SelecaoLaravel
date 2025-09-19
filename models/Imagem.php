<?php

class Imagem extends \Eloquent {

	protected $table = 'imagens';

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function imagemMorph()
    {
        return $this->morphTo();
    }

}