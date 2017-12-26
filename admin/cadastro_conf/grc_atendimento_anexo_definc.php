<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_anexo']['data_responsavel'] = $datadia;
       $vetRow['grc_atendimento_anexo']['idt_responsavel']  = $_SESSION[CS]['g_id_usuario'];
}
?>