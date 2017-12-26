<?php
$excel=='S';
//header("Content-type: application/octet-stream");
// # replace excelfile.xls with whatever you want the filename to default to
//header("Content-Disposition: attachment; filename=excelfile.xls");
//header("Pragma: no-cache");
//header("Expires: 0");


$arquivo_t='excel_file.xls';
// Configura\'e7\'f5es header para for\'e7ar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"{$arquivo_t}\"" );
header ("Content-Description: PHP Generated Data" );



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

if ($_REQUEST['cabecalho'] == '')
	$cabecalho = 'S';
else
	$cabecalho = $_REQUEST['cabecalho'];

if ($menu == 'vazio' && $_SESSION[CS]['g_fornecedor'] != 'A' && $_SESSION[CS]['idtaltcad'] == '' && $_SESSION[CS]['idtaltcadu'] == '') {
    $menu = 'curriculo';
    $prefixo = 'cad';
}

$print_tela = 'S';

if ($_SESSION[CS]['g_fornecedor'] != 'A') {
    echo '<script language="JavaScript1.2">';
    echo "   var sem_menu   ='N'; ";
    echo "   var privez_menu='S'; ";
    echo "   var print_tela ='N'; ";
    echo "</script>";
} else {
    echo '<script language="JavaScript1.2">';
    echo "   var sem_menu   ='N'; ";
    echo "   var privez_menu='S'; ";
    echo "   var print_tela ='N'; ";
    echo "</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php //Require_Once('head.php'); ?>
<style>
body {
	background-color: white;
}
</style>
</head>
<body>
<?php
if ($cabecalho != 'N') {
//    Require_Once('cabecalho_padrao.php');
}
//<link href="padrao_print.css" rel="stylesheet" type="text/css" media="print" />
?>
<div id="meio">
    <?php
	$Require_Once = "$prefixo$menu.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        echo "<script type='text/javascript'>self.location = 'index.php';</script>";
        exit();
    }
    ?>
</div>

</body>
</html>
