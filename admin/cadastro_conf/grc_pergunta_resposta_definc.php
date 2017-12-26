<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_pergunta_resposta']['data']   = $datadia;
       $vetRow['grc_pergunta_resposta']['idt_unidade_regional']   = $_SESSION[CS]['g_idt_unidade_regional'];
       $vetRow['grc_pergunta_resposta']['idt_consultor']       = $_SESSION[CS]['g_id_usuario'];
}
?>