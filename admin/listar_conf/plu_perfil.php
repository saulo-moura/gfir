<?php
$idCampo = 'id_perfil';
$Tela = "o perfil";

$TabelaPrinc      = "plu_perfil";
$AliasPric        = "plu_per";
$Entidade         = "Perfil";
$Entidade_p       = "Perfies";

$barra_inc_h      = "Incluir um Novo Registro de Perfil";
$contlinfim       = "Existem #qt Perfies.";


//Monta o vetor de Campo
$vetCampo['classificacao'] = CriaVetTabela('Classificação');
$vetCampo['nm_perfil'] = CriaVetTabela('Nome');
$vetCampo['ativo'] = CriaVetTabela('Ativo?','descDominio',$vetSimNao);

$sql = 'select * from plu_perfil order by classificacao';
?>