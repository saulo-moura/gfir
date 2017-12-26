<?php
if ($acao=='inc')
{
       $datadia = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_atendimento']['data_inicio_atendimento']   = $datadia;
       $vetRow['grc_atendimento']['data_termino_atendimento']  = $datadia;
       $vethorainicio = explode(' ',$datadia);
       $horainicio    = substr($vethorainicio[1],0,5);
       $vetRow['grc_atendimento']['hora_inicio_atendimento']   = $horainicio;

       $tabela      = 'grc_atendimento';
       $Campo       = 'protocolo';
       $tam         = 11;
       $codigow     = numerador_arquivo($tabela, $Campo, $tam);
       $codigo      = 'AT'.$codigow;
       $protocolow  = $codigo;
       $vetRow['grc_atendimento']['protocolo']   = $protocolow;


       $vetRow['grc_atendimento']['idt_consultor']   = $_SESSION[CS]['g_idt_usuario'];

       $vetRow['grc_atendimento']['idt_unidade_regional']   = $_SESSION[CS]['g_idt_unidade_regional'];
       $vetRow['grc_atendimento']['idt_projeto']   = $_SESSION[CS]['g_idt_projeto'];
       $vetRow['grc_atendimento']['idt_projeto_acao']   = $_SESSION[CS]['g_idt_acao'];

       
       
}
?>