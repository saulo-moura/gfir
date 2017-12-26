<?php
Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];

$acao = mb_strtolower($_REQUEST['acao']);
$_SESSION[CS]['g_nom_tela'] = $vetMenu[$menu];
$cont_arq = '_popup';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Require_Once('head.php'); ?>
</head>
<body id="body" onload="MenuPodeUsar = true; ativaObj(); if ($.isFunction(self.onLoadPag)) onLoadPag();">
<center>
<div id="dtBanco" style="display: none;"><?php echo date("d/n/Y") ?></div>
<input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
<div id="geral_popup">
    <div id="topo_popup">&nbsp;</div>
    <div id="meio_popup">
        <div id="conteudo_popup">
            <?php
            if ($_SESSION[CS]['g_id_usuario'] == '') {
				$msg = 'timeout do sistema';
				$tipo = 'timeout';
				$inf_extra = Array(
				);
				erro_try($msg, $tipo, $inf_extra);

                echo "<div align='center' class='Msg'>Favor entrar no sistema outra vez!</div>";
            } else {
                if ($prefixo == 'listar' || $prefixo == 'listar_rel')
                	$Require_Once = "listar.php";
                else if ($prefixo == 'cadastro')
                	$Require_Once = "cadastro.php";
                else if ($prefixo == 'relatorio')
                	$Require_Once = "relatorio/$menu.php";
                else
                	$Require_Once = "$prefixo$menu.php";

                if (file_exists($Require_Once)) {
                	Require_Once($Require_Once);
                } else {
                    echo "<script type='text/javascript'>top.location = 'index.php';</script>";
                    exit();
                }
            }
            ?>
        </div>
    </div>
    <div id="rodape_popup">&nbsp;</div>
</div>
</center>
</body>
</html>
