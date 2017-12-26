<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_agenda_ocorrencia']['data']   = $datadia;
       $vetRow['grc_atendimento_agenda_ocorrencia']['idt_usuario'] = $_SESSION[CS]['g_id_usuario'];
}


?>