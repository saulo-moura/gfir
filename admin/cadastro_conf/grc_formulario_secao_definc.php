<?php
if ($acao=='inc')
{
         
           

		$datadia = trata_data(date('d/m/Y H:i:s'));
		//$vetRow['grc_atendimento_avulso']['data_atendimento']   = $datadia;

		$tabela = 'grc_formulario_secao';
		$Campo  = 'codigo';
		$tam = 7;
		$codigow = numerador_arquivo($tabela, $Campo, $tam);
		$codigo  = 'SE'.$codigow;
		$vetRow['grc_formulario_secao']['codigo']   = $codigo;

}

?>