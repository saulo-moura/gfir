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
    Table.Menu_print_e {
        background:#FFFFFF;
        width: 100%;

        }




      div#barra_topo_m {
        background:#004080;
        width: 100%;
        height:35px;
        display:block;
        margin-bottom:4px;
        color:#FFFFFF;
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-style: normal;
        font-weight: bold;
        xdisplay:none;
    }
    div#retornar {
        float:left;
        padding-left:5px;
        padding-top:2px;
    }
    div#retornar a {
        font-family: Calibri, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-style: normal;
        font-weight: bold;
        color:#FFFFFF;
        text-decoration:none;

    }

    div#usuario_m {
        float:left;
        padding-left:30px;
        padding-top:5px;
    }
    div#resto_m {
        float:right;
        padding-right:30px;
        padding-top:5px;
    }
     div#titulo_modulo {
        xbackground:#2F2FFF;
        color:#2F2FFF;
        font-size:30px;
        width:100%;
        xbackground: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        xbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        xbackground: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        xbackground: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        xbackground: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        xbackground: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        xfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        xborder-radius: 1em;
        xborder:1px solid  #0000A0;
    }
div#div_topo {
    padding:0px;
    margin:0px;
    width: 100%;
}
.ctopo {
    width: 100%;
    sbackground: url(imagens/div_topo_meio.png) no-repeat top;
    background: #808080;
    text-align: center;
    padding: 0px;
    padding-top: 8px;
    height: 24px;
}
.ctopo a {
    color: #d2d2d2;
    margin: 0px 5px;
    font-size:12px;
}
.ctopo a.intranet {
    color: white;
    font-weight: bold;
}

.barra_ferramentas {
    background: #FFFFFF;
    color: #000000;
    font-weight: bold;
    width:100%;
    display:block;
    float:left;
    border-bottom:2px solid #666666;
}
</style>
<?php Require_Once('head.php');
//  echo "<script type='text/javascript'>var reduz_cron='N';</script>";

if ($_SESSION[CS]['g_id_usuario'] == '') {

    echo 'Entrada indevida... ';
    // header("Location: ../");
    echo ' <script type="text/javascript" language="JavaScript1.2">';
    echo "    self.location = 'incentrada_indevida.php';";
    echo ' </script> ';
    exit();
}
?>
</head>
<body style="background:#FFFFFF; ">
<?php


  $idt_atendimento=0;

echo '<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_printqsma">';
echo '    <tr>';
            echo '<td align="right" width="200" style="font-size: 10px; padding-right:20px; ">';
            echo "<div onclick='javascript:top.close();' title='Retorna a Home ' style='cursor:pointer; padding-left:15px;'>";
            echo '<img style="padding:5px;" src="imagens/logo_sebrae.jpg" xwidth="82" xheight="53"  border="0" />';
            echo '</div>';
            echo '</td>';
            echo '<td align="left" style="font-size: 24px; padding:5px;">';

            echo "<div  style='xborder: 1px solid red; '>";
            echo "<center>";
            $titulo_modulo="BASE DE INFORMAÇÕES DE ATENDIMENTO";
            echo "<div  id='titulo_modulo' style=''>";
            echo  $titulo_modulo;
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '<td align="left" width="100" style="font-size: 24px; padding:5px;">';
            echo "<div  style='float:right; xborder: 1px solid red; '>";
            echo '</div>';
            echo '</td>';
echo '    </tr> ';
echo '</table>';











echo ' <div id="barra_topo_m"> ';
    $vetMes = Array(
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    );
    echo ' <div id="retornar" style="xwidth:80px;"> ';
    echo '       <a href="javascript:top.close();" title="Clique aqui retornar"><img alt="" src="imagens/sair.png" width="32" height="32"></a>';
    echo ' </div>  ';
    echo "<div id='usuario_m'></div> ";
    
    
    echo " <div onclick='return ConfirmaPerguntasFrequentes({$idt_atendimento});' style='xwidth:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; xpadding:0; padding-top:2px; xpadding-bottom:5px;   '   >";
       echo " <img width='32'  height='32'  title='Acessa Perguntas Frequentes'  src='imagens/at_perguntas.png' border='0'>";
       echo "</div>";
    echo " </div>";

    echo " <div onclick='return ConfirmaLinks({$idt_atendimento});' style='xwidth:{$tamdiv}; color:#004080; font-size:14px; cursor:pointer; float:left;  margin-right:15px;  '>";
       echo "<div style='float:left; xpadding:{$pad}; padding-top:2px; xpadding-bottom:5px;   '   >";
       echo " <img width='32'  height='32'  title='Acessa LINKs úteis' src='imagens/at_link_util.png' border='0'>";
       echo "</div>";
    echo " </div>";

    
echo '</div>';

        echo '<div class="Meio" id="Meio">';
            //echo "BIA....";
            $Require_Once="incconteudo_bia.php";
            if (file_exists($Require_Once)) {
            	Require_Once($Require_Once);
            } else {
                exit();
            }
        echo "</div>";
?>


<script>
function ConfirmaPerguntasFrequentes(idt_atendimento)
{
//    alert(' Perguntas Frequentes '+idt_atendimento);

    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.8 ;

    var link ='conteudo_atendimento_perguntas_frequentes.php?prefixo=inc&menu=atendimento_perguntas_frequentes&idt_atendimento='+idt_atendimento;
    faq =  window.open(link,"PerguntasFrequentes","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    faq.focus();
}

function ConfirmaLinks(idt_atendimento)
{
   // alert(' LINKs '+idt_atendimento);
    var  left   = 100;
    var  top    = 100;
    var  height = $(window).height()-100;
    var  width  = $(window).width() * 0.7;
    var link ='conteudo_atendimento_link_util.php?prefixo=inc&menu=atendimento_link_util&idt_atendimento='+idt_atendimento;
    linkutil =  window.open(link,"linkutil","left="+left+",top="+top+",width="+width+",height="+height+",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
    linkutil.focus();
}

</script>










</body>
</html>
