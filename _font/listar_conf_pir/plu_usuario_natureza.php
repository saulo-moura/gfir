<?php
$idCampo = 'idt';
$Tela = "a Natureza do Usu�rio";
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   plu_un.* ';
$sql  .= ' from plu_usuario_natureza as plu_un ';
$sql  .= ' order by plu_un.codigo';
?>
