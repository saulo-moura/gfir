<?php
$idCampo = 'id_config';
$Tela = "a configuração do site";

//Monta o vetor de Campo
$vetCampo['descricao'] = CriaVetTabela('Configuração');
$vetCampo['valor, extra'] = CriaVetTabela('Valor', 'str, descDominio', Array('', $vetIcoGrid));

$sql = 'select * from config order by descricao';
?>