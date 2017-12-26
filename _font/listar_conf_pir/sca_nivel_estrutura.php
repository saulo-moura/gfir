<?php
$idCampo = 'idt';
$Tela = "o Nнvel da Estrutura";
//Monta o vetor de Campo
$vetCampo['nivel']        = CriaVetTabela('Nнvel');
$vetCampo['descricao']    = CriaVetTabela('Descriзгo');
$vetCampo['sigla']        = CriaVetTabela('Sigla');
$vetCampo['qtd_digitos']  = CriaVetTabela('Digitos');
$sql   = 'select ';
$sql  .= '   scane.*  ';
$sql  .= ' from sca_nivel_estrutura as scane ';
$sql  .= ' order by nivel';
?>