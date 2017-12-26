<?php
$idCampo = 'idt';
$Tela = "o Porte do Sistemas";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
//
$sql   = 'select ';
$sql  .= '   scaps.idt,  ';
$sql  .= '   scaps.*,  ';
$sql  .= '   scaps.descricao as scaps_descricao ';
$sql  .= ' from sca_porte_sistema as scaps ';
$sql  .= ' order by scaps.descricao';
?>
