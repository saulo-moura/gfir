<?php
$idCampo = 'idt';
$Tela = "a Natureza do Gloss�rio";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   plu_gn.*  ';
$sql  .= ' from '.db_pir.'plu_pl_glossario_natureza as plu_gn ';
$sql  .= ' order by plu_gn.codigo';
?>
