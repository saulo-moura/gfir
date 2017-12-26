<?php
if ($acao=='inc')
{
       $datadia                              = trata_data(date('d/m/Y'));

       $tabela      = 'grc_aviso';
       $Campo       = 'protocolo';
       $tam         = 7;
       $codigow     = numerador_arquivo($tabela, $Campo, $tam);
       $codigo      = 'AV'.$codigow;
       $protocolow  = $codigo;
       $vetRow['grc_aviso']['protocolo']     = $protocolow;
       $vetRow['grc_aviso']['data_inicio']   = $datadia;
       
       $datadia                              = trata_data(date('d/m/Y H:i:s'));
       $vetRow['grc_aviso']['data_registro'] = $datadia;
       $vetRow['grc_aviso']['idt_usuario']   = $_SESSION[CS]['g_id_usuario'];
}


?>
