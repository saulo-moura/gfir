<?php
$idCampo = 'idt';
$Tela = "a Prioridade do Requisito";
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Nome');
$vetCampo['detalhe'] = CriaVetTabela('Descrição');

//
$sql   = 'select ';
$sql  .= '   plu_pl_rp.* ';
$sql  .= ' from plu_pl_requisitos_prioridade as plu_pl_rp ';
$sql  .= ' order by plu_pl_rp.codigo';
?>
