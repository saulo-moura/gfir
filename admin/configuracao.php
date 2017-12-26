<?php
if (file_exists("https.php")) include_once("https.php");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/html; charset=ISO-8859-1", true);

date_default_timezone_set("America/Bahia");

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
}

ini_set('memory_limit', '-1');
ini_set('session.cookie_lifetime', 0);
ini_set('display_errors', 'On');

Require_Once('definicao_class.php');

Session_Start();

$vetSistemaUtiliza = Array();
Require_Once('configuracao_cliente.php');

//*************************************************************************
//*** Configuração do Site (NÃO ALTERAR)                                ***
//*************************************************************************
$debug = false; //Coloca o sistema em modo de debug

if (debug === true) {
   $debug = debug; 
}

$versao_site = '2017.5.1';

define('versao_js', '?v='.$versao_site);

$versao_site .= $_SESSION['crm_banco']; // Versão do sistema
$nome_site   = 'crm|Sebrae'; // Nome do sistema
$sigla_site  = 'GRC_GC_ADM'; // Sigla do sistema
$dir_file    = 'obj_file';

$plu_sigla_interna = 'GRC';
$plu_codigo_interna = 'GR';
define('ajax_sistema', 'ajax_grc.php');

define('ajax_plu', 'ajax_plu.php?o=a');



if ($debug) {
    error_reporting(E_ALL & ~E_NOTICE);
    $target_js = 'self';
} else {
    if (version_compare(PHP_VERSION, '5.3.0', '<')) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
    }
    //   $target_js = 'parent.conteudo';
    $target_js = 'self';
}

define('CS', 'admin_'.$sigla_site.'_'.md5($host.conteudo_abrir_sistema));




$vetDispositivo = Array(
    '1' => 'DESKTOP',
    '2' => 'TABLET',
    '3' => 'SMARTPHONE',
);

$vetImgDispositivo = Array(
    '1' => '_16',
    '2' => '_32',
    '3' => '_32',
);

if ($_SESSION[CS]['g_dispositivo'] == '') {
    require_once 'Mobile_Detect.php';
    $detect = new Mobile_Detect;
    $isMobile = $detect->isMobile();
    $isTablet = $detect->isTablet();

    if ($isMobile) {
        $g_dispositivo = 3;
    } else if ($isTablet) {
        $g_dispositivo = 2;
    } else {
        $g_dispositivo = 1;
    }

    $_SESSION[CS]['g_dispositivo'] = $g_dispositivo;
}

define('img_dispositivo', $vetImgDispositivo[$_SESSION[CS]['g_dispositivo']]);

$vetTmp = $vetSistemaUtiliza;

$vetSistemaUtiliza = Array();
$vetSistemaUtiliza['atual'] = Array(
    'nome' => 'Atual',
    'url' => '',
);

if (is_array($vetTmp)) {
    $vetSistemaUtiliza = array_merge($vetSistemaUtiliza, $vetTmp);
}

$vetSistemaUtilizaCmb = Array();
foreach ($vetSistemaUtiliza as $key => $value) {
    $vetSistemaUtilizaCmb[$key] = $value['nome'];
}

Require_Once('definicao_lib.php');

//define('CS', 'site_'.$sigla_site.'_'.md5($host));
//*************************************************************************
//*** Conexção com o Banco de Dados e configuração do PHP (NÃO ALTERAR) ***
//*************************************************************************

$con = new_pdo($host, $bd_user, $password, $tipodb);

//echo " 1 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br /> ";
//*************************************************************************
//*** Dominios do Sistema (NÃO ALTERAR)                                 ***
//*************************************************************************
Require_Once('definicao_vetor.php');
Require_Once('funcao.php');
//echo " 2 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br /> ";

Require_Once('cria_vetor.php');
//echo " 3 xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx<br /> ";

if ($_SESSION[CS]['g_ultimoAcesso'] != '') {


    $tempo_transcorrido = (strtotime(date("Y-n-j H:i:s")) - strtotime($_SESSION[CS]['g_ultimoAcesso']));

    //comparamos o tempo transcorrido
    if ($tempo_transcorrido > $vetConf['timeout']) {
        // echo "
        //     <script type='text/javascript'>
        //         alert('A sessão do sistema expirou!\\nFavor entrar de novo no sistema.');
        //         top.location = 'index.php';
        //     </script>
        // ";
        // unset($_SESSION[CS]);
        // exit();
    }
}

$_SESSION[CS]['g_ultimoAcesso'] = date("Y-n-j H:i:s");

define('CSU', geraSenha(20, true, true, true));

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
}
