<?php

/**
 * Validacao de espacos em branco
 */
Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL\s]+$/u', $value);
});

Validator::extend('estrangeiro', function(){
	
});

/**
 * Validacao de cpf
 */
Validator::extend('cpf', function($field, $value, $params)
{
    return ValidateHelper::validarCPF($value);
});
