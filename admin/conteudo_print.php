<?php
Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '') {
    $menu = 'vazio';
} else {
    $menu = $_REQUEST['menu'];
}

if ($_REQUEST['prefixo'] == '') {
    $prefixo = 'inc';
} else {
    $prefixo = $_REQUEST['prefixo'];
}

if ($_REQUEST['titulo_rel'] == '') {
    $nome_titulo = '';
} else {
    $nome_titulo = $_REQUEST['titulo_rel'];
}

$print_tela = $_REQUEST['print_tela'];
$cont_arq = '_print';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $nome_titulo.' - '.$nome_site ?></title>
        <?php Require_Once('head.php'); ?>
        <style type="text/css">
            table#table_barra_full {
                display: none;
            }

            Table#Tabela_Filtro td.Tit_Campo_Obr {
                padding-left: 10px;
                padding-right: 5px;
                vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <table border="0" cellpadding="0" width="100%" cellspacing="0">
            <tr>
                <td align="left" width="236" style="padding:5px;">
                    <img style="padding:5px;" src="imagens/logo_sebrae.jpg" alt="" border="0" />
                </td>
                <td align="center" style="font-size: 24px;  padding:5px;" colspan="2">
                    <?php echo $nome_titulo ?>
                </td>
                <td align="right" width="80" style="font-size: 10px; padding-right:20px; ">
                    Emitido em:&nbsp;
                    <?php
                    echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                    echo '<br />';
                    echo $_SESSION[CS]['g_nome_completo'];
                    ?>
                </td>
            </tr>
        </table>
        <div class="Meio" id="Meio">
            <?php
            if ($prefixo == 'listar' || $prefixo == 'listar_rel') {
                $Require_Once = "listar.php";
            } else {
			    if ($prefixo == 'relatorio') {
				    $Require_Once = "{$prefixo}/{$menu}.php";
				}
				else
				{
                    $Require_Once = "$prefixo$menu.php";
				}
            }

            if (file_exists($Require_Once)) {
                Require_Once($Require_Once);
            } else {
                //echo "<script type='text/javascript'>top.location = 'index.php';</script>";
				echo "Funcionalidade {$Require_Once} não esta implementada";
                exit();
            }
            ?>
        </div>
    </body>
</html>