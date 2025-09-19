<?php
class Faq extends Eloquent
{
	public $table = 'faqs';

	public function categoria()
	{
		return $this->belongsTo('Categoria');
	}
}