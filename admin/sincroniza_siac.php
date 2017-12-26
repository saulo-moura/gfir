<?php
if (PHP_SAPI == 'cli') {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    if ($_REQUEST['cas'] == '') {
        $_REQUEST['cas'] = 'conteudo_abrir_sistema';
    }
    define('conteudo_abrir_sistema', $_REQUEST['cas']);
    Require_Once('configuracao.php');

    $conJOB = new_pdo($host, $bd_user, $password, $tipodb);

    $dt_ini_job = getdata(true, true, true);
    $sql = "update plu_config set valor = " . aspa('Executando em ' . $dt_ini_job) . " where variavel = 'ult_dt_sincroniza_siac'";
    execsql($sql, true, $conJOB);

    $t = mb_strtolower($argv[1] . '/sebrae_grc/admin/funcao_' . $plu_sigla_interna . '.php');
    if (file_exists($t)) {
        Require_Once($t);
    }

    $_GET['tipo'] = 'sincroniza_siac';
    require_once 'ajax_grc.php';

    $sql = "update plu_config set valor = " . aspa('Concluido em ' . $dt_ini_job . ' até ' . getdata(true, true, true)) . " where variavel = 'ult_dt_sincroniza_siac'";
    execsql($sql, true, $conJOB);

    try {
        $t = mb_strtolower($argv[1] . '/sebrae_grc/admin/inchelpdesk_integra_email.php');
        if (file_exists($t)) {
            ob_start();
            Require_Once($t);
            ob_end_clean();
        }
    } catch (PDOException $e) {
        grava_erro_log($tipodb, $e, $sql);
    } catch (Exception $e) {
        grava_erro_log('php', $e, '');
    }
} else {
    die('Chamada indevida...');
}