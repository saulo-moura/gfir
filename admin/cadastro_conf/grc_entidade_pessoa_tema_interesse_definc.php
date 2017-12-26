<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));
    $vetRow['grc_entidade_pessoa_tema_interesse']['idt_responsavel']  =  $_SESSION[CS]['g_id_usuario'];
    $vetRow['grc_entidade_pessoa_tema_interesse']['data_registro']    = trata_data($datadia);
}
?>