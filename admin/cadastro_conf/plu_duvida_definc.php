<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['plu_duvida']['data_registro']   = $datadia;
       $vetRow['plu_duvida']['idt_responsavel']   = $_SESSION[CS]['g_id_usuario'];
}
?>