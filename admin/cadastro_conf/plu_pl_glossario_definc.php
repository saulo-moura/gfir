<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['plu_pl_glossario']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['plu_pl_glossario']['data_registro']    =  trata_data($datadia);
	
	
	$vetRow['plu_pl_glossario']['origem']    =  "GERAL";
	if ($_GET['pf']=="S")
	{
	    $vetRow['plu_pl_glossario']['origem']    =  "Ponto Funчуo";
	}
	
	
	
}
?>