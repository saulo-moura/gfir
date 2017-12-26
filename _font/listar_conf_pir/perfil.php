<?php
$idCampo = 'id_perfil';
$Tela = "o perfil";

//Monta o vetor de Campo
$vetCampo['classificacao'] = CriaVetTabela('Classificação');
$vetCampo['nm_perfil'] = CriaVetTabela('Nome');
$vetCampo['ativo'] = CriaVetTabela('Ativo?','descDominio',$vetSimNao);

$sql = 'select * from perfil order by classificacao';
?>