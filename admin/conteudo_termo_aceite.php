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


if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo='';
else
	$nome_titulo = $_REQUEST['titulo_rel'];

if ($_REQUEST['origem'] == '')
    $origem='';
else
	$origem = $_REQUEST['origem'];

if ($_REQUEST['ampliar'] == '')
    $ampliar='';
else
	$ampliar = $_REQUEST['ampliar'];

$nome_cabecalho ='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $nome_titulo.' - '.$nome_site      ?></title>
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
    Table.Menu_printqsma {
        background:#FFFFFF;
        width: 100%;
    }
    div#termo {
        margin:30px;
    }
    div#termo_nao {
    	font-family: Calibri, Arial, Helvetica, sans-serif;
    	font-style: normal;
        font-weight: bold;
    	color: #FF0000;
    	font-size:16px;
    	margin:30px;
    }
    div#termo_sim {
    	font-family: Calibri, Arial, Helvetica, sans-serif;
    	font-style: normal;
        font-weight: bold;
    	color: #14ADCC;
    	font-size:16px;
    	margin:30px;
    }
</style>
<?php Require_Once('head.php'); ?>
<?php
 echo "<script type='text/javascript'>print_tela = 'S';</script>";
 ?>
</head>
<body>
<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_printqsma">
    <tr>
        <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_sebrae.jpg" width="305" height="115" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
        <td align="right" style="font-size: 10px; padding-right:20px; ">
            <?php
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
    if ($_REQUEST['texto_emite'] == '')
    {
        $texto_emite='';
    }
    else
    {
    	$texto_emite = $_REQUEST['texto_emite'];
    }
    $numero_edital   = $_REQUEST['numero_edital'];
    $numero_processo = $_REQUEST['numero_processo'];
    $aceite          = $_REQUEST['aceite'];
    echo "<div id='termo'>";
    $texto_emite = $_SESSION[CS]['g_texto_emite'];
    echo $texto_emite;
    echo "</div>";
    
    if ($aceite=='N')
    {
        echo "<div id='termo_nao'>";
        $texto_aceite = "ATENÇÃO!!!<br />TERMO NÃO ACEITO";
        echo $texto_aceite;
        echo "</div>";
    }
    else
    {
        echo "<div id='termo_sim'>";
        $texto_aceite = "ATENÇÃO!!!<br />TERMO ACEITO.";
        echo $texto_aceite;
        echo "</div>";
    }
    
    ?>
</div>
</body>
</html>