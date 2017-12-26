<?php
$idCampo = 'idt';
$Tela = "o Tipo do Campo";
//Monta o vetor de Campo

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['tamanho'] = CriaVetTabela('Tamanho');
$vetCampo['qtd_decimal'] = CriaVetTabela('Decimal');

$sql   = 'select ';
$sql  .= '   plu_edct.idt,  ';
$sql  .= '   plu_edct.*  ';
$sql  .= ' from plu_ed_campos_tipo as plu_edct ';
$sql  .= ' order by plu_edct.codigo';
?>
