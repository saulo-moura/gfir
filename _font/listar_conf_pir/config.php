<?php
$idCampo = 'id_config';
$Tela = "a configura��o do site";

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Configura��o');
$vetCampo['valor, extra'] = CriaVetTabela('Valor', 'str, descDominio', Array('', $vetIcoGrid));

$sql = 'select * from config order by descricao';
?>