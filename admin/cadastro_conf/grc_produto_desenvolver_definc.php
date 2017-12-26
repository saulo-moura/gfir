<?php

//echo " teste ------------------------------------- $acao ";
//exit();
if ($acao=='inc')
{
    $tabela_c = 'grc_produto';
    $Campo_c  = 'codigo';
    $tam_c    = 11;
    $codigow  = numerador_arquivo($tabela_c, $Campo_c, $tam_c);
    $codigo_c = 'BA'.$codigow;
    $vetRow['grc_produto']['codigo'] = $codigo_c;
    $vetRow['grc_produto']['copia']  = '0';




//    $datadia = trata_data(date('d/m/Y H:i:s'));


}
?>