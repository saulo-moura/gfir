<?php
if ($acao=='inc')
{
	$vetRow['grc_comunicacao']['nome'] = $_SESSION[CS]['g_nome_completo'];    
	$vetRow['grc_comunicacao']['email'] = $_SESSION[CS]['g_email'];    
    $vetRow['grc_comunicacao']['ip'] = $_SERVER['REMOTE_ADDR'];    
	$vetRow['grc_comunicacao']['login'] = $_SESSION[CS]['g_login'];
	$datadia = trata_data(date('d/m/Y H:i:s'));
	$vetRow['grc_comunicacao']['datahora']   = $datadia;

	$tabela = 'grc_comunicacao';
	$Campo  = 'protocolo';
	$tam = 7;
	$codigow = numerador_arquivo($tabela, $Campo, $tam);
	$codigo  = 'CC'.$codigow;
	$vetRow['grc_comunicacao']['protocolo']   = $codigo;
	
}


?>