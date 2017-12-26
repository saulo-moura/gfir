<?php
Require_Once('../configuracao.php');
header("Expires: 0");
header('Content-Type: application/x-msexcel; charset=iso-8859-1');
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Disposition: attachment; filename=excel_file.xls" );
header ("Content-Description: PHP Generated Data" );
if ($_REQUEST['menu'] == '')
	$menu = 'vazio';
else
	$menu = $_REQUEST['menu'];
if ($_REQUEST['prefixo'] == '')
	$prefixo = 'inc';
else
	$prefixo = $_REQUEST['prefixo'];


$Require_Once = "$prefixo$menu.php";
if (file_exists($Require_Once)) {
  	Require_Once($Require_Once);
} else {
 echo "<script type='text/javascript'>self.location = 'index.php';</script>";
 exit();
}
?>
