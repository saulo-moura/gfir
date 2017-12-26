<?php
if ($acao=='inc')
{
    $datadia = (date('d/m/Y H:i:s'));  // dd/mm/aaaa
    $vetRow['grc_funil_execucao']['ano']  = substr($datadia,6,4);

}
?>