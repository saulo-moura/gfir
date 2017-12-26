<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_atendimento_especialidade_produto']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_atendimento_especialidade_produto']['data_registro']    =  trata_data($datadia);
    
    $vetRow['']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['']['data_registro']    =  trata_data($datadia);
}
?>