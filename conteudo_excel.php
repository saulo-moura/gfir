<?php
//Require_Once('configuracao.php');
// Configura\'e7\'f5es header para for\'e7ar o download
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D,d M YH:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
header("Content-Description: PHP Generated Data");

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
define('reg_pagina', 50);

//*************************************************************************
//*** Conexção com o Banco de Dados e configuração do PHP (NÃO ALTERAR) ***
//*************************************************************************
Require_Once('funcao.php');

if ($debug) {
    error_reporting(E_ALL & ~E_NOTICE);
    $target_js = 'self';
} else {
    if (version_compare(PHP_VERSION, '5.3.0', '<')) {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    } else {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
    }
    // $target_js = 'parent.conteudo';
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
    }
}

$_SESSION[CS]['g_ultimoAcesso'] = date("Y-n-j H:i:s");
$_SESSION[CS]['g_nom_tela'] = 'Site';





if ($_REQUEST['menu'] == '')
    $menu = 'vazio';
else
    $menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];


if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo = '';
else
    $nome_titulo = $_REQUEST['titulo_rel'];





$nome_cabecalho = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $nome_titulo.' - '.$nome_site ?></title>
        <style type="text/css" media="all">
            Table.sMenu_print {
                font-family: Arial, Helvetica, sans-serif;
                font-style: normal;
                font-weight: bold;
                color: Black;
                word-spacing: 0px;
                width: 100%;
                border: 1px solid Black;
                display: inline;
            }
            Table.Menu_print {
                background:#FFFFFF;
            }

        </style>
        <?php Require_Once('head.php'); ?>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_print">
            <tr>
                <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_oas_empreendimentos.jpg" width="305" height="115" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
                <td align="right" style="font-size: 10px; padding-right:20px; ">
                    <?php
                    $path = $dir_file.'/empreendimento/';
                    $img_empreendimento = $_SESSION[CS]['g_imagem_logo_obra'];
                    $nm_empreendimento = $_SESSION[CS]['g_nm_obra'];
                    ImagemMostrar(305, 115, $path, $img_empreendimento, $nm_empreendimento, false);

                    echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                    echo '<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center"  style="font-size: 24px;  padding:5px;" colspan="2">
                    <?php echo $nome_titulo ?>
                </td>

            </tr>
        </table>
        <div class="Meio" id="Meio">
            <?php
            if ($prefixo == 'listar') {
                $Require_Once = "$prefixo.php";
            } else {
                $Require_Once = "$prefixo$menu.php";
            }




            if (file_exists($Require_Once)) {
                Require_Once($Require_Once);
            } else {
                echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                exit();
            }
            ?>
        </div>
    </body>
</html>
