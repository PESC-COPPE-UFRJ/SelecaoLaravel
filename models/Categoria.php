<?php
class Categoria extends Eloquent
{
	public $table = 'categorias';

	public function faqs()
	{
		return $this->hasMany('Faq','categoria_id');
	}
}