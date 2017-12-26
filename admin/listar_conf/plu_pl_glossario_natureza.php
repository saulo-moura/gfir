<?php
$idCampo = 'idt';
$Tela = "a Natureza do Glossário";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_gn.*  ';
$sql  .= ' from '.db_pir.'plu_pl_glossario_natureza as plu_gn ';
$sql  .= ' order by plu_gn.codigo';
?>
