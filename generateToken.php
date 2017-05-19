<?php
function generateToken() {
	$lmin = 'abcdefghijklmnpqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
	$num = '123456789';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	$caracteres .= $lmai . $num ;
	$len = strlen($caracteres);
	for ($n = 1; $n <= 6; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	return $retorno;
}
?>