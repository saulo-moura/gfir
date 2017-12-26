<?php
$idCampo = 'idt';
$Tela = "a Natureza do Usuário";
//Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   plu_un.* ';
$sql  .= ' from plu_usuario_natureza as plu_un ';
$sql  .= ' order by plu_un.codigo';
?>
