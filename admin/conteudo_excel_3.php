<?php
//header("Content-type: application/octet-stream");

/*
Require_Once('configuracao.php');


header("Expires: 0");

header('Content-Type: application/x-msexcel; charset=iso-8859-1');
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
//header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=excel_file.xls" );
header ("Content-Description: PHP Generated Data" );
*/

Require_Once('configuracao.php');

header("Expires: 0");
//header("Content-Type: text/html; charset=ISO-8859-1",true);

header('Content-Type: application/x-msexcel; charset=iso-8859-1',true);
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
//header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=excel_file.xls" );
header ("Content-Description: PHP Generated Data" );


$excel=='S';

if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];

if ($_REQUEST['comp_excel_name'] == '')
	$comp_excel_name = '';
else
	$comp_excel_name = $_REQUEST['comp_excel_name'].'_';

//header("Content-type: application/octet-stream");
// # replace excelfile.xls with whatever you want the filename to default to
//header("Content-Disposition: attachment; filename=excelfile.xls");
//header("Pragma: no-cache");
//header("Expires: 0");

if ($menu=='fisico_financeiro_g')
{
//    $arquivo_excel="{$comp_excel_name}Cronograma_Obra.xls";
    
    $ta = $_REQUEST['ta'];
    $arquivo_excel='CRONOGRAMA GANTT - '.mb_strtoupper($_SESSION[CS]['g_nm_obra']).' - '.str_replace('/','-',$ta);

    
}
else
{
    $arquivo_excel="{$comp_excel_name}{$menu}.xls";
}
header ("Content-Disposition: attachment; filename=\"{$arquivo_excel}\"" );

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
  //  Require_Once('cabecalho_padrao.php');
}
//<link href="padrao_print.css" rel="stylesheet" type="text/css" media="print" />
?>
<div id="meio">
    <?php
    $excel_3='S';
	$Require_Once = "$prefixo$menu.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        echo "<script type='text/javascript'>top.location = 'index.php';</script>";
        exit();
    }
       exit();
    ?>
</div>

</body>
</html>
