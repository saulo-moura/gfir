<?php
Require_Once('configuracao.php');

$menu = $_REQUEST['menu'];
$prefixo = $_REQUEST['prefixo'];
$acao = mb_strtolower($_REQUEST['acao']);
$cont_arq = '_popup';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Require_Once('head.php'); ?>
</head>
<body id="body">
<?php
if ($prefixo == 'listar' || $prefixo == 'listar_rel')
	$Require_Once = "listar.php";
else if ($prefixo == 'detalhe')
	$Require_Once = "detalhe.php";
else if ($prefixo == 'cadastro')
	$Require_Once = "cadastro.php";
else
	$Require_Once = "$prefixo$menu.php";

if (!file_exists($Require_Once)) {
    echo "
        <script type='text/javascript'>
            alert('Pagina não encontrada!');
            parent.$.prettyPhoto.close();
        </script>
    ";
} else {
    Require_Once($Require_Once);
}
?>
</body>
</html>
