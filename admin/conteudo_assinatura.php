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
    Table.Menu_print_ass {
        background:#FFFFFF;
        width: 100%;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        sfont-size: 14px;
        font-style: normal;
        font-weight: bold;
        scolor: #313131;
    }

</style>
<?php Require_Once('head.php');
  echo "<script type='text/javascript'>var reduz_cron='N';</script>";
?>
</head>
<body>
<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_print_ass">
    <tr>
        <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_PCO.jpg" width="148" height="113" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
        
        <td align="right" style="font-size: 10px; padding-right:20px; ">
            <?php
                $path = $dir_file.'/empreendimento/';
                $img_empreendimento = $_SESSION[CS]['g_imagem_logo_obra'];
                $nm_empreendimento = $_SESSION[CS]['g_nm_obra'];
                
                echo '<div id="tela_logo_obra" style="float:right; margin-left:75px; margin-top:22px; background:#FFFFFF;">';
                $path = 'imagens/';
                // $img  = 'logo_PCO.jpg';
                $img  = 'logo_oas_empreendimentos.jpg';
                ImagemMostrar(200, 0, $path, $img, 'Logo do oas empreendimentos' , false, '');


//              ImagemMostrar(305, 115, $path, $img_empreendimento, $nm_empreendimento, false);
            
//              echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
//              echo '<br />Emitido por:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
                
               echo '<br />'.date('d/m/Y').' '.(date('H') - date('I')).':'.date('i');
               echo '<br />Usuário:&nbsp;'.$_SESSION[CS]['g_nome_completo'];
               echo '</div>';
                
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
        echo "<script type='text/javascript'>self.location = 'conteudo.php?prefixo=inc&menu=qsrsms';</script>";
        exit();
    }
    ?>
</div>
</body>
</html>
