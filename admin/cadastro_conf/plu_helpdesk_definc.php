<?php
if ($acao=='inc')
{
	$vetRow['plu_helpdesk']['nome'] = $_SESSION[CS]['g_nome_completo'];    
	$vetRow['plu_helpdesk']['email'] = $_SESSION[CS]['g_email'];    
    $vetRow['plu_helpdesk']['ip'] = $_SERVER['REMOTE_ADDR'];    
	$vetRow['plu_helpdesk']['login'] = $_SESSION[CS]['g_login'];
	
	
	$vetRow['plu_helpdesk']['status_helpdesk_usuario'] = 'Cadastrada no CRM';
	
	$datadia = trata_data(date('d/m/Y H:i:s'));
	$vetRow['plu_helpdesk']['datahora']   = $datadia;
/*
	$tabela = 'plu_helpdesk';
	$Campo  = 'protocolo';
	$tam = 7;
	$codigow = numerador_arquivo($tabela, $Campo, $tam);
	$codigo  = 'HD'.$codigow;
	$vetRow['plu_helpdesk']['protocolo']   = $codigo;
*/	
}


?>