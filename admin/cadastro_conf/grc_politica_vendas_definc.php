<?php
if ($acao=='inc'  )
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_politica_vendas']['data_responsavel'] = $datadia;
       $vetRow['grc_politica_vendas']['idt_responsavel']  = $_SESSION[CS]['g_id_usuario'];
	   
	   
	   $tabela = 'grc_politica_vendas';
       $Campo  = 'codigo';
       $tam = 7;
       $codigow = numerador_arquivo($tabela, $Campo, $tam);
       $codigo  = 'PV'.$codigow;
       $vetRow['grc_politica_vendas']['codigo']   = $codigo;
	   
	   
}
?>