<?php
$idCampo = 'idt';
$Tela = "o Respons�vel";
//Monta o vetor de Campo

$vetCampo['codigo']               = CriaVetTabela('C�digo');
$vetCampo['descricao']            = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   plu_pl_re.idt,  ';
$sql  .= '   plu_pl_re.*  ';
$sql  .= ' from plu_pl_responsavel as plu_pl_re ';
$sql  .= ' order by plu_pl_re.codigo';
?>
