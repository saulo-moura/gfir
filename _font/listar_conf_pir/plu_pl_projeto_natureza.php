<?php
$idCampo = 'idt';
$Tela = "o Natureza do Elemento da EAP";
//Monta o vetor de Campo

$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_pl_pn.idt,  ';
$sql  .= '   plu_pl_pn.*  ';
$sql  .= ' from plu_pl_projeto_natureza as plu_pl_pn ';
$sql  .= ' order by plu_pl_pn.codigo';
?>
