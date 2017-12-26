<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_plano_facil']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_plano_facil']['data_responsavel']    =  trata_data($datadia);
	$tabela = 'grc_plano_facil';
    $Campo  = 'protocolo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo  = 'PF'.$codigow;
    $vetRow['grc_plano_facil']['protocolo']   = $codigo;

}
?>
