<?php
class Formacao extends Eloquent 
{

	public $table = 'formacoes';

	public function imagens()
    {
        return $this->morphMany('Imagem', 'imagemMorph');
    }

}