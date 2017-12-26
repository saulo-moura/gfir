<?php

$basew    = 'db_oas_sap';
$con_trab = $con;
$con      = Conexao_Base();
if ($con == '')
{
    $con = $con_trab;
}

$origem_carga = "SCA";


$idCampo = 'id_perfil';
$Tela = "o perfil";

//Monta o vetor de Campo
$vetCampo['nm_perfil'] = CriaVetTabela('Nome');

$sql = 'select * from perfil order by nm_perfil';
?>