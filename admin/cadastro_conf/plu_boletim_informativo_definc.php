<?php
if ($acao=='inc')
{

       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow[db_pir.'plu_boletim_informativo']['data_registro']   = $datadia;
       $vetRow[db_pir.'plu_boletim_informativo']['idt_usuario'] = $_SESSION[CS]['g_id_usuario'];   
	   
	   $tabela = db_pir.'plu_boletim_informativo';
	   $Campo = 'codigo';
       $tam = 7;
	   $codigow = numerador_arquivo($tabela, $Campo, $tam);
	   $codigo = 'BI'.$codigow;
	   $vetRow[db_pir.'plu_boletim_informativo']['codigo'] = $codigo;
	   
	   
	   
}
?>