<?php
if ($acao=='inc')
{
       //$vetRow['grc_atendimento_agenda']['situacao']   = 'Livre';
       //$vetRow['grc_atendimento_agenda']['origem']   = 'Extra';



       //$datadia = trata_data(date('d/m/Y H:i:s'));
       //$vetRow['grc_atendimento_agenda']['data_hora_marcacao']   = $datadia;
       
       //$vetRow['grc_atendimento_agenda']['origem']   = "Hora Extra";
       //$vetRow['grc_atendimento_agenda']['idt_ponto_atendimento']   = $_SESSION[CS]['g_idt_unidade_regional'];


    
           
       $tabela = 'grc_evento_local_pa';
       $Campo  = 'codigo';
       $tam = 7;
       $codigow = numerador_arquivo($tabela, $Campo, $tam);
       $codigo  = 'LO-'.$codigow;

       $vetRow['grc_evento_local_pa']['codigo']   = $codigo;


       //$datadia = trata_data(date('d/m/Y H:i:s'));
       //$vetRow['grc_atendimento_agenda']['data_hora_marcacao']   = $datadia;

}


?>