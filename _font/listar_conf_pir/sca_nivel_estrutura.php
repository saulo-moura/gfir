<?php
$idCampo = 'idt';
$Tela = "o N�vel da Estrutura";
//Monta o vetor de Campo
$vetCampo['nivel']        = CriaVetTabela('N�vel');
$vetCampo['descricao']    = CriaVetTabela('Descri��o');
$vetCampo['sigla']        = CriaVetTabela('Sigla');
$vetCampo['qtd_digitos']  = CriaVetTabela('Digitos');
$sql   = 'select ';
$sql  .= '   scane.*  ';
$sql  .= ' from sca_nivel_estrutura as scane ';
$sql  .= ' order by nivel';
?>