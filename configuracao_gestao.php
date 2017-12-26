<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Content-Type: text/html; charset=ISO-8859-1", true);

//ini_set('session.cookie_lifetime', 0);
//ini_set('display_errors', 'On');
Session_Start();

Require_Once('configuracao_cliente.php');

//*************************************************************************
//*** Configuração do Site (NÃO ALTERAR)                                ***
//*************************************************************************


$debug = true; //Coloca o sistema em modo de debug
$nome_site = 'PCO - Site'; // Nome do sistema
$sigla_site = 'PCO'; // Sigla do sistema
$dir_file = 'admin/obj_file';


define('CS', 'site_'.$sigla_site.'_'.md5($host));
$anterior = $_SESSION[CS];

define('CS', 'site_gestao'.$sigla_site.'_'.md5($host));
define('reg_pagina', 50);

$_SESSION[CS] = $anterior;

//*************************************************************************
//*** Conexção com o Banco de Dados e configuração do PHP (NÃO ALTERAR) ***
//*************************************************************************
Require_Once('funcao.php');

//p($anterior);
//exit();


if ($debug) {
    error_reporting(E_ALL & ~E_NOTICE);
    $target_js = 'self';
} else {
    if (version_compare(PHP_VERSION, '5.3.0', '<')) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
    }
    //  $target_js = 'parent.conteudo';
    $target_js = 'self';
}

//Verifica se o post ou get dado é do servidor
$post_url = parse_url($_SERVER['HTTP_REFERER']);

if ($post_url['host'] != '') {
    $post_url = mb_strtolower('http://'.$post_url['host'].($post_url['port'] == '' ? '' : ':'.$post_url['port']));
    $test_url = mb_strtolower('http://'.$_SERVER['HTTP_HOST']);

    if ($post_url != $test_url) {
        $arq = explode('/', $_SERVER['SCRIPT_NAME']);
        $arq = mb_strtolower(array_pop($arq));

        if (!($_SERVER['REQUEST_METHOD'] == 'GET' && $arq == 'index.php'))
            echo "<script type='text/javascript'>alert('Erro de acesso ao sistema!\\n\\nVocê esta tentando entrar no sistema por um servidor desconhecido.');</script>";

        unset($_SESSION[CS]);
        echo "<script type='text/javascript'>top.location = 'index.php';</script>";
        exit();
    }
}

$con = new_pdo($host, $bd_user, $password, $tipodb);

//*************************************************************************
//*** Dominios do Sistema (NÃO ALTERAR)                                 ***
//*************************************************************************
Require_Once('admin/definicao_vetor.php');

Require_Once('cria_vetor.php');

if ($_SESSION[CS]['g_ultimoAcesso'] != '') {
    $tempo_transcorrido = (strtotime(date("Y-n-j H:i:s")) - strtotime($_SESSION[CS]['g_ultimoAcesso']));

    //comparamos o tempo transcorrido
    //   echo ' tempo '.$vetConf['timeout_site'].' data '.$tempo_transcorrido;
//    30 * 60
    //   $tempotimeout=3600;
    $tempotimeout = $vetConf['timeout_site'];
    if ($tempo_transcorrido > $tempotimeout) {
        echo "
            <script type='text/javascript'>
                alert('A sessão do Site expirou!\\nFavor entrar de novo no Site.');
                top.location = 'index.php';
            </script>
        ";
        unset($_SESSION[CS]);
        exit();
    }
}

$_SESSION[CS]['g_ultimoAcesso'] = date("Y-n-j H:i:s");
$_SESSION[CS]['g_nom_tela'] = 'Site';
?>
