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
 <div id="barra_topo_m">
                                        <?php
                                        $vetMes = Array(
                                            1 => 'Janeiro',
                                            2 => 'Fevereiro',
                                            3 => 'Mar�o',
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


                                        echo "<div id='usuario_m'>Usu�rio: {$_SESSION[CS]['g_nome_completo']}   </div> ";
                                        ?>
                                        <div id="resto_m"><?php echo 'Salvador, '.date("d \d\e ").$vetMes[date("n")].date(" \d\e Y"); ?>
                                        </div>

                                    </div>




    <?php
    /*
    echo "<div class='barra_ferramentas'>";
    $Require_Once="grc_atendimento_ferramentas.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    }
    echo "</div>";
    */
    ?>


<div class="Meio" id="Meio">
    <?php
   //$acao ='alt';
   
   
   
   $id            = $_GET['id'];
   $idt_externo   = $_GET['idt_atendimento_agenda'];
   
   $idt_ponto_atendimento  = $_GET['idt_ponto_atendimento'];
   $SMS  = $_GET['SMS'];
   if ($SMS=='')
   {
	   if  ($_GET['deondeveio'] == "AgendaSMSPresenca")
	   {
		   $_GET['SMS']=1;
	   }
	   else
	   {
	       $_GET['SMS']=0;
	   }
   }
   $_GET['id']           = $id;
   $_GET['idt_externo']  = $idt_externo;
   // $_GET['acao']       = $acao;
   $_GET['deondeveio'] = 'Distancia';
   $acao =$_GET['acao'];
   //$prefixo = 'cadastro';
   //$menu    = 'grc_atendimento_agenda_marcacao';
   //
    $Require_Once = "cadastro_p.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
	    echo " --------------------- erro acesso a $prefixo $menu cadastro_p.php ";
        exit();
    }
    ?>
</div>
</body>
</html>