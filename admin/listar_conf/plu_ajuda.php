<?php
$Tela = "a Ajuda";

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');

$sql = 'select * from plu_ajuda order by descricao';
?>