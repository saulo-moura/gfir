<?php
if ($acao=='inc')
{
     $sql  = "select  ";
     $sql .= " grc_pp.duracao  ";
     $sql .= " from grc_atendimento_pa_pessoa grc_pp ";
     $sql .= " where idt_ponto_atendimento = ".null($_SESSION[CS]['g_idt_unidade_regional']) ;
     $sql .= "   and idt_usuario           = ".null($_SESSION[CS]['g_id_usuario']) ;

     $rs = execsql($sql);
     $duracao = 0;
     ForEach($rs->data as $row)
     {
         $duracao = $row['duracao'];
     }
     $vetRow['grc_atendimento_usuario_disponibilidade']['idt_ponto_atendimento']   = $_SESSION[CS]['g_idt_unidade_regional'];
     $vetRow['grc_atendimento_usuario_disponibilidade']['duracao']   = $duracao;
}


?>