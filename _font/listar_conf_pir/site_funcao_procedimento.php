<?php
$idCampo = 'id_funcao';
$Tela = "a funзгo Site Procedimentos";

$barra_inc_ap=false;
$barra_alt_ap=false;
$barra_con_ap=false;
$barra_exc_ap=false;


$goCad[] = vetCad('id_funcao', 'Inserir Arquivo', 'procedimento');


// Monta o vetor de Campo
//$vetCampo['cod_classificacao'] = CriaVetTabela('Classificaзгo');
$vetCampo['nm_funcao'] = CriaVetTabela('Nome');
//$vetCampo['cod_funcao'] = CriaVetTabela('Cуdigo');
//$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);
//
$sql = 'select * from site_funcao where ';
$sql .= ' procedimento = '.aspa('S');
?>