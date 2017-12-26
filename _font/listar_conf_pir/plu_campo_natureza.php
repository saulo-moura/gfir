<?php
$idCampo = 'idt';
$Tela = "a Natureza do Campo";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_cn.*  ';
$sql  .= ' from plu_campo_natureza as plu_cn ';
$sql  .= ' order by plu_cn.codigo';
?>
