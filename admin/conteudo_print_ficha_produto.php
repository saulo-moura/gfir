<?php
Require_Once('configuracao.php');

if ($_REQUEST['idt_produto'] == '')
    $idt_produto=0;
else
	$idt_produto = $_REQUEST['idt_produto'];


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
    Table.Menu_print {
        background:#FFFFFF;
        width:100%;
      }
    Table.Menu_print_p {
        background:#FFFFFF;
        width:100%;
        }

</style>
<?php Require_Once('head.php');
  echo "<script type='text/javascript'>print_tela = 'S';</script>";
  $nome_titulo ='Ficha do Produto';
?>
</head>

<body style='width:100%; background:#FFFFFF;'>

<div style='display:block; padding:5px;  background:#FFFFFF; width:98%;'>



<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_print_p">
    <tr>
        <td align="left" style="font-size: 24px; padding:5px;"><img style="padding:5px;" src="imagens/logo_oas_empreendimentos.jpg" width="305" height="115" alt="Comunicação com o Administrador do Sistema" border="0" /></td>
        <td align="right" style="font-size: 10px; padding-right:20px; ">
            <?php
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
        <td align="center"  style="font-size: 24px;  padding:5px;" colspan="2">
            <?php echo $nome_titulo ?>
        </td>

    </tr>
</table>
<div class="Meio" id="Meio">
    <?php
    $sqlpw      = "select ";
    $sqlpw     .= " qpm.*, nome_completo as nome_usuario ";
    $sqlpw     .= " from qp_material qpm ";
    $sqlpw     .= " left join usuario us on us.id_usuario = qpm.idt_usuario ";
    $sqlpw     .= " where idt = ".null($idt_produto);
    $rspw       = execsql($sqlpw);
    if ($rspw->rows == 0)
    {
        return $kokw;
    }
    else
    {
        ForEach ($rspw->data as $rowpw) {
           $idt            = $rowpw['idt'];
           $detalhe        = $rowpw['detalhe'];
           $aplicacao      = $rowpw['aplicacao'];
           $aplicacaow     = str_replace('display:none','',$aplicacao );
           $aplicacaow     = str_replace("onclick='return abre_aplicacao","sonclick='return abre_aplicacao",$aplicacaow);
           
           
           $impw .='<a target="_blank" href="conteudo_print_ficha_produto.php?idt_produto='.$idt_produto.'" ><img style="padding:5px;" src="imagens/impressora.gif" width="16" height="16" title="Preparar para Impressão" alt="Preparar para Impressão"  border="0" /></a>';
           
           
           $aplicacaow     = str_replace($impw,"",$aplicacaow);
           
           
           
           echo $aplicacaow;
        }
    }
    ?>
</div>
</div>
</body>
</html>
