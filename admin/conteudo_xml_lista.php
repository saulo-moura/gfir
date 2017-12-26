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

.bf_1 {
    background: #F1F1F1;
    color: #000000;
    font-weight: bold;
    width:100%;
	
    display:block;
    float:left;
	text-align:center;
	cursor:pointer;
    border-bottom:2px solid #666666;
}


</style>
<script>
function LimpaTabela()
{
    $('#lista_tabela').hide();
	
	var id = "filtro_campos";
	objx = document.getElementById(id);
    if (objx != null) {
       objx.value = '';
    }
	id = "filtro_where";
	objx = document.getElementById(id);
    if (objx != null) {
       objx.value = '';
    }
	
}
</script>
<?php


Require_Once('head.php');
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
<body style="background:#ffffff; ">

<style>
#filtro_classificacao {
    display:block;
}

#lista_tabela {
    display:block;
}
</style>

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
    echo "<div  style=''>";
    echo "<center>";
    $titulo_modulo="XML - LISTAS";
    echo "<div  id='titulo_modulo' style=''>";
    echo  $titulo_modulo;
    echo '</div>';
    echo '</div>';

echo '</div>';

echo '<div class="Meio" id="Meio">';


//echo "<div onclick='return bf_1();' class='bf_1' id='id_1'>";


echo "<div  class='bf_1' id='id_1'>";

echo "<a >Lista Tabela</a>";

//


$vetTbelas   = Array();
$vetTbelas['grc_evento']          = "Eventos";
$vetTbelas['grc_atendimento']     = "Atendimentos";
$vetTbelas['grc_entidade_pessoa'] = "Cadastro Pessoa Física";
$vetTbelas['grc_entidade_pessoa'] = "Cadastro Pessoa Jurídica";
$vetTbelas['grc_produto_tema']    = "Cadastro de Temas";
$vetTbelas['grc_produto_tipo']    = "Cadastro de Tipo de Produto";


//
// Carga das Tabelas de nomenclaturas do sistema  
//

          
$Filtro              = Array();
$Filtro['rs']        = $vetTbelas;
$Filtro['id']        = 'idt';
$Filtro['nome']      = 'Tabelas PIR';
$Filtro['js']        = " onchange='return LimpaTabela();'"; 
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['Tabela'] = $Filtro;
$tabela = $vetFiltro['Tabela']['valor'];


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_campos';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Campos';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['campos'] = $Filtro;
$sql_campos= $vetFiltro['campos']['valor'];


$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'filtro_where';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Condição';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['condicao'] = $Filtro;
$sql_condicao= $vetFiltro['condicao']['valor'];
$sqlinstrucao = "";
if  ($sql_campos=="")
{
    $sqlinstrucao = "";
}
else
{
    if ($sql_condicao=="")
	{
	    $sqlinstrucao = "Select {$sql_campos} from {$tabela}  ";
	}
	else
	{
	    $sqlinstrucao = "Select {$sql_campos} from {$tabela} where {$sql_condicao} ";
	}
}

$compl = "&tabela={$tabela}";
echo '<form name="frm" target="_self" action="conteudo_xml_lista?'.substr(getParametro($strPara),1).$compl.'" method="post">';

echo '<div>';
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
echo '</div>';

echo '</form>';

echo '</div>';

 
echo '</div>';


echo "<div id='lista_tabela'>";

if ($tabela!="")
{
	$prefixo      = "inc";
	$menu         = "xml_lista_tabela";
	$Require_Once = "$prefixo$menu.php";
    if (file_exists($Require_Once)) {
    	Require_Once($Require_Once);
    } else {
        exit();
    }

}
echo '</div>';

?>
<script>
//function LimpaTabela()
//{
    //$('#lista_tabela').hide();
	/*
	var id = "filtro_campos";
	objx = document.getElementById(id);
    if (objx != null) {
       objx.value = '';
    }
	id = "filtro_where";
	objx = document.getElementById(id);
    if (objx != null) {
       objx.value = '';
    }
	*/
//}
function bf_1()
{
	var left = 100;
	var top  = 100;
	var height = $(window).height() - 0;
	var width = $(window).width() * 1;
	var link = 'conteudo_xml_lista_tabela.php?prefixo=inc&menu=xml_lista_tabela';
	XMLListaTabela = window.open(link, "XMLListaTabela", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
	XMLListaTabela.focus();
}
function bf_2()
{
	var left = 100;
	var top  = 100;
	var height = $(window).height() - 0;
	var width = $(window).width() * 1;
	var link = 'conteudo_eap_lista_processo.php?prefixo=inc&menu=eap_lista_processo';
	eaplistaprocesso = window.open(link, "EAPListaProcesso", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
	eaplistaprocesso.focus();
}
</script>











</body>
</html>
