<?php
if ($acao=='inc')
{
         
           

       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_avulso']['data_atendimento']   = $datadia;
       
       $tabela = 'grc_atendimento_avulso';
       $Campo  = 'protocolo';
       //$tam = 7;
       $tam = 4;
       $codigow = numerador_arquivo($tabela, $Campo, $tam);
       $codigo  = 'CH'.$codigow;
       $vetRow['grc_atendimento_avulso']['protocolo']   = $codigo;

}


?>