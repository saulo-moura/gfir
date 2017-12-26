<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
	$_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);
Require_Once('configuracao.php');

define('web', 'S');

//$ssaIdtEvento = 5007;
//$ssaIdtAtendimento = 323271;
$ssaIdtEntidade = 33090;

$conJOB = new_pdo($host, $bd_user, $password, $tipodb);

$dt_ini_job = getdata(true, true, true);
$sql = "update plu_config set valor = ".aspa('Executando em '.$dt_ini_job)." where variavel = 'ult_dt_sincroniza_siac'";
execsql($sql, true, $conJOB);

$_GET['tipo'] = 'sincroniza_siac';
require_once 'ajax_grc.php';

$sql = "update plu_config set valor = ".aspa('Concluido em '.$dt_ini_job.' até '.getdata(true, true, true))." where variavel = 'ult_dt_sincroniza_siac'";
execsql($sql, true, $conJOB);
