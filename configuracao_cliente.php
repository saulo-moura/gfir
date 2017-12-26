<?php
//*************************************************************************
//*** Configuração do Banco de Dados                                    ***
//*************************************************************************
require_once 'admin/configuracao_banco.php';

define('servidor', 'producao');
define('url', 'http://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']));
$dir_file = 'http://'.$_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']).'admin/obj_file';
