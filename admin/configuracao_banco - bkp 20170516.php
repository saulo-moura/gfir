<?php
//*************************************************************************
//*** Configuração do Banco de Dados                                    ***
//*************************************************************************
$tipodb = 'mysql';

//Sebrae Homologação
$host = '10.6.14.40';
$bd_user  = 'lupe'; // Login do Banco
$password = 'my$ql$sebraeh'; // Senha de acesso ao Banco

/*
//Sebrae Produção
$host = 'localhost';
$bd_user  = 'root'; // Login do Banco
$password = ''; // Senha de acesso ao Banco

//Esmeraldo
$host = 'localhost';
$bd_user  = 'root'; // Login do Banco
$password = 'root'; // Senha de acesso ao Banco

//Lupe
$host = 'localhost';
$bd_user  = 'lupe'; // Login do Banco
$password = 'lup3-1234'; // Senha de acesso ao Banco
 * 
 */

$host = $tipodb.':host='.$host.';dbname=db_pir_grc;port=3307'; // Endereço do Banco de Dados

define('debug',true);

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

if (mb_strtolower($_GET['banco']) != '') {
    $_SESSION['crm_banco'] = mb_strtolower($_GET['banco']);
}

if ($_SESSION['crm_banco'] == 'sqlserver') {
    $tipodb = 'sqlsrv';
    $host = 'bd.ba.sebrae.com.br';
    $bd_user = 'pir'; // Login do Banco
    $password = '1!2@3#qwe'; // Senha de acesso ao Banco

    $host = $tipodb.':Server='.$host.';Database=db_pir_grc'; // Endereço do Banco de Dados
}
