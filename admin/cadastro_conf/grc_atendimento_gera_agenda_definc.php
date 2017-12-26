<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_gera_agenda']['dt_geracao']            = $datadia;
	   $vetRow['grc_atendimento_gera_agenda']['hora_inicio']           = '08:00';
	   $vetRow['grc_atendimento_gera_agenda']['hora_fim']              = '18:00';
	   $vetRow['grc_atendimento_gera_agenda']['hora_intervalo_inicio'] = '12:00';
       $vetRow['grc_atendimento_gera_agenda']['hora_intervalo_fim']    = '14:00';
	   
	   $vetRow['grc_atendimento_gera_agenda']['duracao']               = $duracao;
	   
	   
	   
}
?>
