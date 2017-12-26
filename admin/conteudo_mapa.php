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
	
if ($_REQUEST['CodCliente'] == '')
    $CodCliente='';
else
	$CodCliente = $_REQUEST['CodCliente'];
	

if ($_REQUEST['cnpj'] == '')
    $cnpj="";
else
	$cnpj = $_REQUEST['cnpj'];
	
if ($_REQUEST['razao'] == '')
    $razao="";
else
	$razao = $_REQUEST['razao'];
	

	//p($_REQUEST);

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
        background:#2F2FFF;
        color:#FFFFFF;
        font-size:20px;
        width:100%;
        background: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        background: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        border: 1px solid thick #c00000;
        border-radius: 1em;
        border:1px solid  #0000A0;
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
 <div id="div_topo">
            <center>
                <div class="meio ctopo">
                    <a href="<?php echo $vetConf['url_helpdesk']; ?>" target="_blank">HelpDesk Sebrae</a>
                    <a href="<?php echo $vetConf['url_sebrae_na'] ?>" target="_blank"><span class="oas">Sebrae-Nacional</span></a>
                    <a href="<?php echo $vetConf['url_sebrae_ba'] ?>" target="_blank"><span class="oas">Sebrae-Bahia</span></a>
                   
                </div>
            </center>
        </div>


<table border="0" cellpadding="0" width="100%" cellspacing="0" class="Menu_printqsma">
    <tr>
        <?php
            echo '<td align="right" width="200" style="font-size: 10px; padding-right:20px; ">';
            echo "<div onclick='javascript:close();' title='Retorna a Home ' style='cursor:pointer; padding-left:15px;'>";
			//echo "<div onclick='javascript:hidePopWin(true);' title='Retorna a Home ' style='cursor:pointer; padding-left:15px;'>";
			//<a href="javascript:parent.hidePopWin(true);" title="Clique aqui retornar">Retornar</a>';
            
			
			
            echo '<img style="padding:5px;" src="imagens/logo_noticia_sistema.jpg" width="82" height="53"  border="0" />';
            echo '</div>';
            echo '</td>';
            echo '<td align="left" style="font-size: 24px; padding:5px;">';
            echo "<div  style='xborder: 1px solid red; '>";
            echo "<center>";
            //$titulo_modulo="DETALHA CLIENTE - "."{$cnpj} - {$razao}";
			$titulo_modulo="DETALHA CLIENTE";
            echo "<div  id='titulo_modulo' style=''>";
            echo  $titulo_modulo;
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '<td align="left" width="100" style="font-size: 24px; padding:5px;">';
            echo "<div  style='float:right; xborder: 1px solid red; '>";
            echo '</div>';
            echo '</td>';
        ?>
    </tr>
</table>





 <div id="barra_topo_m">
                                        <?php
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
			                            //echo '       <a href="javascript:parent.hidePopWin(true);" title="Clique aqui retornar"><img alt="" src="imagens/bt_voltar_g.png" width="32" height="32"></a>';
										
			//							echo "<div onclick='javascript:hidePopWin(true);' title='Retorna a Home ' style='cursor:pointer; padding-left:15px;'>";
			//<a href="javascript:parent.hidePopWin(true);" title="Clique aqui retornar">Retornar</a>';
            
                                        echo ' </div>  ';


                                        echo "<div id='usuario_m'>Usuário: {$_SESSION[CS]['g_nome_completo']}   </div> ";
                                        ?>
                                        <div id="resto_m"><?php echo 'Salvador, '.date("d \d\e ").$vetMes[date("n")].date(" \d\e Y"); ?>
                                        </div>

                                    </div>




    <?php
	echo "<section id='secao_4'>";
	//echo "<div id='mapa_titulo'  style='width:100%; display:block;'>";
	//echo "<div id='mapa1' >";
	//echo "       <a href='{$mapa_a_link}' {$mapa_a_target} ><img src='{$mapa_a_imagem} ' title='{mapa_a_hint}' width='{mapa_a_width}'  height='{mapa_a_height}'  /></a>";
	//echo "     </div> ";
	//echo "<div id='mapa2' >";
	//echo "       <h2>{$mapa_a_titulo}</h2>";
	//echo "     </div> ";
	//echo "     </div> ";
	echo "<div id='mapa' style='height:500px; width: 100%;'>";
	echo "        </div>";
	$dir_mapa = "js/mapa_google/";

    echo "       <script src='http://maps.googleapis.com/maps/api/js?sensor=false'></script> ";
	
	echo "        <!-- Caixa de informação --> ";
	echo "        <script src='{$dir_mapa}js/infobox.js'></script> ";
	echo "        <!-- Agrupamento dos marcadores --> ";
	echo "		<script src='{$dir_mapa}js/markerclusterer.js'></script> ";
	echo "        <!-- Arquivo de inicialização do mapa --> ";
	echo "		<script src='{$dir_mapa}js/mapa.js'></script> ";
	echo "</section>";
    ?>


<div class="Meio" id="Meio">
    <?php
    ?>
</div>
</body>
</html>
