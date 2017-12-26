<?php
if ($acao=='inc')
{
    $tabela_c = 'grc_produto_entrega';
    $Campo_c  = 'codigo';
    $tam_c    = 11;
    $codigow  = numerador_arquivo($tabela_c, $Campo_c, $tam_c);
    $codigo_c = 'TA'.$codigow;
    $vetRow['grc_atendimento_evento_entrega']['codigo'] = $codigo_c;
}
?>