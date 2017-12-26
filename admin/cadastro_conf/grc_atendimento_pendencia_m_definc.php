<?php
if ($acao=='inc')
{
         
           

       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_pendencia']['data']   = $datadia;
       
       $vetRow['grc_atendimento_pendencia']['idt_usuario'] = $_SESSION[CS]['g_id_usuario'];
       
       $vetRow['grc_atendimento_pendencia']['recorrencia'] = $_SESSION[CS]['g_id_usuario'];

       

}


?>
