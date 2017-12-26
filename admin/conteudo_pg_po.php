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
	
	
$idt0   = $_REQUEST['idt0'];
$idt1   = $_REQUEST['idt1'];
$idt2   = $_REQUEST['idt2'];
$titulo = $_REQUEST['titulo'];

	
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
    Table.ssMenu_print {
        background:#FFFFFF;
        width: 100%;
        }

</style>
<?php Require_Once('head.php');
  $nome_titulo=$titulo;
  echo "<script type='text/javascript'>var reduz_cron='N';</script>";
?>
</head>
<body>
<table border="0" cellpadding="0" width="100%" cellspacing="0" class="ssMenu_print">
    <tr>
        <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_oas_empreendimentos.jpg" width="305" height="115" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
        <td align="right" style="font-size: 10px; padding-right:20px; ">
            <?php
                $path = $dir_file.'/empreendimento/';
                $img_empreendimento = $_SESSION[CS]['g_imagem_logo_obra'];
                $nm_empreendimento = $_SESSION[CS]['g_nm_obra'];
                ImagemMostrar(305, 115, $path, $img_empreendimento, $nm_empreendimento, false);
            
//                echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
//                echo '<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
                
                if ($ampliar!='S')
                {
                    echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                    echo '<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
                }
                else
                {
                    if ($origem!='S')
                    {
                        echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                        echo '<br />Atualizado por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
                    }
                    else
                    {
                        echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
                    }                }

                
                
            ?>
        </td>
    </tr>
    <tr>
        <td align="center"  style="font-size: 24px;  padding-bottom:5px;" colspan="2">
             <?php
            echo ' <div id="topo_barra1" style="color:#FFFFFF; margin:0; pedding:0; "> ';
            echo ' <div class="bt_topo_barra" style="color:#FFFFFF; margin:0; pedding:0; "> ';
            echo '       <a href="javascript:top.close();" title="Clique aqui retornar"><img title="Clique aqui retornar" style="padding-top:2px; padding-right:5px;" src="imagens/esquerda.gif" width="16" height="16" alt="Voltar" border="0" />Retornar</a>';
            echo ' </div>  ';

            echo $nome_titulo;
            echo ' </div>  ';
            ?>
        </td>

    </tr>
</table>

<div class="Meio" id="Meio">
    <?php

    if ($prefixo=='listar')
    {
        $Require_Once = "$prefixo.php";
    }
    else
    {
        $Require_Once = "$prefixo$menu.php";
    }
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        //echo "<script type='text/javascript'>self.location = 'conteudo.php?prefixo=inc&menu=qsrsms';</script>";
        exit();
    }
    ?>
</div>
</body>
</html>
