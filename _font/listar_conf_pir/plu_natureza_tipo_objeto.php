<?php
$idCampo = 'idt';
$Tela = "a Natureza do Tipo de Objeto";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   plu_nto.*  ';
$sql  .= ' from plu_natureza_tipo_objeto as plu_nto ';
$sql  .= ' order by plu_nto.codigo';
?>
