<?php
$Tela = "a Ajuda";

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Descri��o');
$vetCampo['codigo'] = CriaVetTabela('C�digo');

$sql = 'select * from plu_ajuda order by descricao';
?>