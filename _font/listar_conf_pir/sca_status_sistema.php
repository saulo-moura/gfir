<?php
$idCampo = 'idt';
$Tela = "o Status do Sistemas";
//   Monta o vetor de Campo
$vetCampo['codigo']    = CriaVetTabela('C�digo');
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
//
$sql   = 'select ';
$sql  .= '   scass.idt,  ';
$sql  .= '   scass.*,  ';
$sql  .= '   scass.descricao as scass_descricao ';
$sql  .= ' from sca_status_sistema as scass ';
$sql  .= ' order by scass.descricao';
?>
