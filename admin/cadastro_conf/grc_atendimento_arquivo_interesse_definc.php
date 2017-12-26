<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_atendimento_arquivo_interesse']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_atendimento_arquivo_interesse']['data_registro']    =  $datadia;
}
?>