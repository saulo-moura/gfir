<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);
Require_Once('configuracao.php');

$t = mb_strtolower($argv[1] . '/sebrae_grc/admin/funcao_' . $plu_sigla_interna . '.php');
if (file_exists($t)) {
    Require_Once($t);
}

$t = mb_strtolower($argv[1] . '/sebrae_grc/admin/funcao_gerencial.php');
if (file_exists($t)) {
    Require_Once($t);
}

$_GET['tipo'] = 'GerarDW';
require 'ajax_atendimento.php';

$_GET['tipo'] = 'GeraDWIQ';
require 'ajax_atendimento.php';