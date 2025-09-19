<?php

class Whelper
{
	static function ChecaPeriodo()
	{

    	//$periodo = Periodo::where('status', '>', 0)->where('status', '<', 4)->orderBy('id','DESC')->first();
		$periodo = Periodo::where('status', '>', 0)->orderBy('id','DESC')->first();

    	if($periodo)
    	{
    		$agora = strtotime(date("Y-m-d H:i:s", time()));
			$periodo_inicio = strtotime($periodo->data_hora_inicio);
			$periodo_fim = strtotime($periodo->data_hora_fim);

			// debug('Periodo Encontrado');
			// dd($periodo_inicio);
			//if($agora > $periodo_inicio && $agora < $periodo_fim)
			//{
				// debug('Periodo esta dentro da data correta, formulÃ¡rio habilitado');
				// debug($periodo->id);
				// debug(date("Y-m-d H:i:s", $agora));
				return $periodo;
			//}
			//else
			//{
			    //return FALSE;
			//}
    	}
    	else
    	{
    		return FALSE;
    	}

	}
}