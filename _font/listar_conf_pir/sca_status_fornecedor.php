<?php
$idCampo = 'idt';
$Tela = "o Status do Fornecedor";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   scasf.idt,  ';
$sql  .= '   scasf.*  ';
$sql  .= ' from sca_status_fornecedor as scasf ';
$sql  .= ' order by scasf.codigo';
?>
