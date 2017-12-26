<?php

$basew    = 'db_oas_sap';
$con_trab = $con;
$con      = Conexao_Base();
if ($con != '')
{
    // Erro de conex�o
}

$origem_carga = "SCA";



$idCampo = 'id_funcao';
$Tela    = "a fun��o";
$tipofiltro='S';
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_classificacao';
$Filtro['nome'] = 'Classifica��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'nm_funcao';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_funcao';
$Filtro['nome'] = 'Transa��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['cod_classificacao'] = CriaVetTabela('Classifica��o');
$vetCampo['nm_funcao'] = CriaVetTabela('Nome');
$vetCampo['cod_funcao'] = CriaVetTabela('Transa��o');
$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);

$sql = 'select * from funcao where ';
$sql .= ' lower(cod_classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';   
$sql .= ' and lower(nm_funcao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';   
$sql .= ' and lower(cod_funcao) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';   
$sql .= ' order by cod_classificacao';
?>