<?php
$idCampo = 'idt';
$Tela = "o Responsável";
//Monta o vetor de Campo

$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_pl_re.idt,  ';
$sql  .= '   plu_pl_re.*  ';
$sql  .= ' from plu_pl_responsavel as plu_pl_re ';
$sql  .= ' order by plu_pl_re.codigo';
?>
