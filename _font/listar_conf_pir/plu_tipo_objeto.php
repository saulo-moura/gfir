<?php
$idCampo = 'idt';
$Tela = "o Tipo de Objeto";
//Monta o vetor de Campo

$vetCampo['imagem']    = CriaVetTabela('S�mbolo', 'arquivo', '25', 'plu_tipo_objeto');
$vetCampo['classificacao']    = CriaVetTabela('Classifica��o');
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['plu_nto_descricao'] = CriaVetTabela('Natureza');
//
$sql   = 'select ';
$sql  .= '   plu_to.idt,  ';
$sql  .= '   plu_to.*,  ';
$sql  .= '   plu_nto.descricao as plu_nto_descricao ';

$sql  .= ' from plu_tipo_objeto as plu_to ';
$sql  .= ' inner join plu_natureza_tipo_objeto plu_nto on plu_nto.idt = plu_to.idt_natureza';
$sql  .= ' order by plu_to.classificacao';
?>
