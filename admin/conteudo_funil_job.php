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
	
if ($_REQUEST['acao'] == '')
	$acao = 'con';
else
	$acao = $_REQUEST['acao'];

if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo='';
else
	$nome_titulo = $_REQUEST['titulo_rel'];
	

if ($_REQUEST['idt_unidade_regional'] == '')
    $idt_unidade_regional_sel='';
else
	$idt_unidade_regional_sel = $_REQUEST['idt_unidade_regional'];

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
        color:#FFFFFF;
        font-size:18px;
        width:100%;
        padding-top:3px;
        
        xbackground: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        xbackground: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        xbackground: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        xbackground: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        xbackground: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        xbackground: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        xfilter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        xborder-radius: 1em;
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

/*
if ($_SESSION[CS]['g_id_usuario'] == '') {

    echo 'Entrada indevida... ';
    // header("Location: ../");
    echo ' <script type="text/javascript" language="JavaScript1.2">';
    echo "    self.location = 'incentrada_indevida.php';";
    echo ' </script> ';
    exit();
}
*/
?>
</head>
<body style="background:#ffffff; ">

<?php

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
	
	/*
	echo ' <div id="retornar" style="xwidth:80px;"> ';
    echo '       <a href="javascript:window.print();;" title="Clique aqui para Imprimir.'."\n".' Melhor formato em Paisagem."><img alt="" src="imagens/imprimir.png" width="32" height="32"></a>';
    echo ' </div>  ';
    
	echo ' <div id="retornar" style="xwidth:80px;"> ';
    echo '       <a href="javascript:MigraPdf('.$idt_unidade_regional_sel.');" title="Clique aqui Migrar para PDF"><img alt="" src="imagens/gerarpdf.png" width="32" height="32"></a>';
    echo ' </div>  ';
	*/
	
	
	
    echo "<div  style=''>";
	
	
	
    echo "<center>";
    $titulo_modulo="FUNIL - EXECUÇÃO DO JOB PARA OBTER SENSIBILIZAÇÃO DE METAS E CLASSIFICAÇÃO DO CLIENTE PARA FUNIL";
    echo "<div  id='titulo_modulo' style=''>";
    echo  $titulo_modulo;
    echo '</div>';
    echo '</div>';

echo '</div>';



echo '<div class="Meio" id="Meio">';
echo '<div class="funil_menu" id="funil_menu">';
echo "<style>";
echo ".funil_menu { ";
echo "    background:#FFFFFF; ";
echo "	color:#888888; ";
echo "	font-weight: bold;  ";
echo "	font-size: 14px; ";
echo "	text-align:center; ";
echo "} ";

echo "#menu_funil ul { ";
echo "    padding:0px; ";
echo "    margin:0px; ";
echo "    background-color:#EDEDED; ";
echo "    list-style:none; ";
echo "    border-bottom:1px solid #FFFFFF;";
echo "} ";

echo "#menu_funil ul li { display: inline; }";

echo "#menu_funil ul li a {";
echo "    padding:1em;";
echo "    display: inline-block;";
/* visual do link */ 
echo "    background-color:#EDEDED;";
echo "    color: #333;";
echo "    text-decoration: none;";
echo "    border-right:1px solid #EDEDED;";
echo "    width:10em;";
echo "}";

echo "#menu_funil ul li a:hover {";
//echo "    background-color:#D6D6D6;";
echo "    background-color:#EDEDED;";
echo "    color: #6D6D6D;";
echo "    border-left:1px solid #C0C0C0;";
echo "    border-bottom:1px solid #C0C0C0;";
echo "}";
//

echo ".funil_ap {";
echo "    background-color:#F1F1F1;";
echo "    border-top:1px solid #BBBBBB;";
echo "    color: #666666;";
echo "    display:none;";
echo "}";

echo "#link2 {";
echo "    font-size:2em;";
echo "    padding:2em; ";
echo "}";

echo "</style>";

echo "<div id='instrucoes' class='' style='border:1px solid #C0C0C0; '>";
echo "Essa Funcionalidade IMPORTA os dados referentes a METAS MOBILIZADORAS 1 e 7<br/>";
echo "Para isso clique em 'Executar Job'<br/>";
echo "Essa Rotina demora em torno de 1 Hora e Meia para conclusão da Importação<br/><br/>";
//
echo "Possibilita também a Atualização da Classificação do Cliente no Funil do Atendimento<br/>";
echo "Para isso clique em 'Classificar Clientes'<br/>";
echo "Essa Rotina demora em torno de 1 Hora para conclusão da Classificação<br/><br/>";
//
echo "<span style='font-size:24px; color:#0000FF;' >ATENÇÃO...<br/><br/>";
echo "MELHOR EXECUTAR ESSA FUNCIONALIDADE NO NAVEGADOR</span> <span style='font-size:24px; color:#FF0000;' >MOZILLA FIREFOX.</span><br/><br/>";
//
echo '</div>';




$link1 = " onclick= 'return link1();'";
$link2 = " onclick= 'return link2();'";
$link3 = " onclick= 'return link3();'";
$link4 = " onclick= 'return link4();'";
$hint1 = " title='Retornar dessa para o Painel do CRM|Sebrae-BA' ";
$hint2 = " title='Possibilita a execução da Migração da sensibilização da Metas Mobilizadoras 1 e 7' ";
$hint3 = " title='Possibilita a execução da Classificação dos Clientes no Funil de Atendimento' ";
$hint4 = " title='Possibilita a análise do Resultado das execuções em JOB' ";
echo "<nav id='menu_funil'>";
echo "    <ul>";
echo "        <li><a href='#' {$link1} {$hint1}>Retornar</a></li>";
echo "        <li><a href='#' {$link2} {$hint2}>Executar Job</a></li>";
echo "        <li><a href='#' {$link3} {$hint3}>Classificar Clientes</a></li>";
//echo "        <li><a href='#' {$link4} {$hint4}>Controles</a></li>";
echo "    </ul>";
echo "</nav>";
echo '</div>';
// Telas de apresentação
echo "<div id='link2' class='funil_ap'>";
echo "Aguarde...<br/><br/>";
echo "essa Funcionalidade esta sendo executada...'<br/><br/>";
echo "Executando a Funcionalidade de Migração das Metas Mobilizadoras 1 e 7 do SiacWeb.<br/><br/>";

echo "<img width='25' height='25' src='imagens/funil_esperar.gif' title='Aguarde...'/>";


echo '</div>';

echo "<div id='link3' class='funil_ap'>";
echo "Mostrar Resultado da execução do job<br/><br/>";
echo '</div>';


echo "<div id='link4' class='funil_ap'>";
echo "Mostrar Controle do Job<br/><br/>";
echo '</div>';

echo '</div>';


$dataprotocolo  = date('d/m/Y H:i:s');
$dataprotocolow = str_replace('/','',$dataprotocolo);
$dataprotocolow = str_replace(' ','',$dataprotocolow);
$dataprotocolow = str_replace(':','',$dataprotocolow);
$vetRetorno = Array();
$ano_atual = Funil_parametro(1, $vetRetorno);
$anobasew = $ano_atual;




?>
<script>

var protocolo = '<?php echo $dataprotocolow;  ?>';
var anobase   = '<?php echo $anobasew;  ?>';

function link1()
{
   top.close();
}
function link2()
{
    $('#link3').hide();
	$('#link4').hide();
	var texto = "";
	texto = texto + "Atenção!"+"\n\n"; 
	texto = texto + "A funcionalidade de Migração das informações sobre a Sensibilização das Metas Mobilizadoras  1 e 7 será executada."+"\n\n"; 
	texto = texto + "Isso pode demorar muito para concluir a Migração."+"\n\n\n"; 
	texto = texto + "Para Confirmar a Execução clicar no botão 'OK'"+"\n"; 
	texto = texto + "Para Não Executar a Migração clicar no botão 'CANCELAR'"+"\n"; 
	var r = confirm(texto);
	if (r == true) {
		processando();
		/*
		var left = 10;
		var top = 10;
		var height = $(window).height() - 0;
		var width = $(window).width() - 20;
		var link = 'conteudo_funil_job_executa.php';
		FunilJobExecuta = window.open(link, "FunilJobExecuta", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
		//FunilJobExecuta.focus();
		window.close();
		//alert('xxxx');
		*/
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'ajax_grc.php?tipo=FunilMetasMobilizadoras',
			data: {
				cas: conteudo_abrir_sistema
			},
			success: function (response) {
			    $("#dialog-processando").remove();
				if (response.erro != '') {
				    var texto = 'Migração das Metas Mobilzadoras NÃO Obteve SUCESSO.'+"\n\n"+'Tecle OK para continuar.'+"\n\n";
					alert(texto+"\n\n"+url_decode(response.erro));
				}
				else
				{
				   alert('Migração das Metas Mobilzadoras Obteve SUCESSO.'+"\n\n"+'Tecle OK para continuar.'+"\n\n");
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
				$("#dialog-processando").remove();
			},
			async: false
		});
	} else {
       $("#dialog-processando").remove();
	}
}


function link3()
{
    $('#link2').hide();
	$('#link4').hide();
	var texto = "";
	texto = texto + "Atenção!"+"\n\n"; 
	texto = texto + "A funcionalidade de Classificação dos Clientes para o Funil será executada."+"\n\n"; 
	texto = texto + "Isso pode demorar muito para concluir a Classificação."+"\n\n\n"; 
	texto = texto + "Para Confirmar a Execução clicar no botão 'OK'"+"\n"; 
	texto = texto + "Para Não Executar a Classificação clicar no botão 'CANCELAR'"+"\n"; 
	var r = confirm(texto);
	if (r == true) {
        processando();
		/*
		var left = 10;
		var top = 10;
		var height = $(window).height() - 0;
		var width = $(window).width() - 120;
		var link = 'conteudo_funil_job_classifica.php';
		FunilJobClassificacao = window.open(link, "FunilJobClassificacao", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
		*/
        //window.close();		
		//alert('Tecle ok para continuar');
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: 'ajax_grc.php?tipo=FunilClassificaCliente',
			data: {
				cas: conteudo_abrir_sistema
			},
			success: function (response) {
			    $("#dialog-processando").remove();
				if (response.erro != '') {
				    var texto = 'Classificação dos Clientes para Funil NÃO Obteve SUCESSO.'+"\n\n"+'Tecle OK para continuar.'+"\n\n";
					alert(texto+"\n\n"+url_decode(response.erro));
				}
				else
				{
				   alert('Classificação dos Clientes para Funil Obteve SUCESSO.'+"\n\n"+'Tecle OK para continuar.'+"\n\n");
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
				$("#dialog-processando").remove();
			},
			async: false
		});
		
	} else {
		$("#dialog-processando").remove();
	}
	
	
	
}
function link4()
{
   $('#link2').hide();
   $('#link3').hide();
   $('#link4').show();

}



</script>
</body>
</html>
