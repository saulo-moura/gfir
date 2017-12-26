<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_avaliacao_devolutiva']['idt_cadastrante']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_avaliacao_devolutiva']['data_cadastrante']    =  trata_data($datadia);
	
    $vetRow['grc_avaliacao_devolutiva']['versao']              =  1;
    $vetRow['grc_avaliacao_devolutiva']['data_versao']    =  trata_data($datadia);
	
	$vetRow['grc_avaliacao_devolutiva']['status']    =  'CA';
	$vetRow['grc_avaliacao_devolutiva']['grupo']     =  'NAN';

	$vetRow['grc_avaliacao_devolutiva']['atual']     =  'S';

	$tabela = 'grc_avaliacao_devolutiva';
	
    $Campo  = 'codigo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo  = 'DV'.$codigow;

    $vetRow['grc_avaliacao_devolutiva']['codigo']   = $codigo;

}
?>
