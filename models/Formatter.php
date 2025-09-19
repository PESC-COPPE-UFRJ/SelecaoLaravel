<?php

class Formatter 
{

	public static function stringToDate($data) 
	{
		$data = str_replace('/', '-', $data);
		return date('Y-m-d',strtotime($data));
	}

	public static function dateToString($data)
	{
		return date('d/m/Y',strtotime($data));
	}

	public static function getDataFormatada($data) 
	{
		return date('d/m/Y',strtotime($data));
	}

	public static function getDataHoraFormatada($dataHora) 
	{
		return date('d/m/Y H:i:s',strtotime($dataHora));
	}

	public static function getValorFormatado($valor)
	{
		return 'R$ ' . number_format($valor,'2',',','.'); 
	}

	public static function getDataPorExtensoAbreviada($data) 
	{
		setlocale(LC_ALL,'pt-BR');
		return utf8_encode(ucfirst(strftime('%a %d/%m',strtotime($data))));
	}

	public static function getDataPorExtenso($data) 
	{
		setlocale(LC_ALL,'pt-BR');
		return utf8_encode(strftime('%d/%m/%Y - %A',strtotime($data)));
	}	

	public static function getMesPorExtenso($data)
	{
		setlocale(LC_ALL,'pt-BR');
		return utf8_encode(ucfirst(strftime('%B de %Y',strtotime($data))));
	}

	public static function getPorcentagemFormatada($valor)
	{
		return number_format($valor,'2',',','.'); 
	}
}