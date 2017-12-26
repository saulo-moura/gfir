<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento_abertura']['dt_abertura']   = $datadia;
       
       $vetRow['grc_atendimento_abertura']['situacao']   = 'Aberto';
       
       
       $vetRow['grc_atendimento_abertura']['idt_unidade_regional']   = $_SESSION[CS]['gat_idt_unidade_regional'];
       $vetRow['grc_atendimento_abertura']['idt_projeto']   = $_SESSION[CS]['gat_idt_projeto'];
       $vetRow['grc_atendimento_abertura']['idt_projeto_acao']   = $_SESSION[CS]['gat_idt_acao'];

       
       
}
?>