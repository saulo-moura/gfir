
<style type="text/css">


    .cb_texto_tit {
        background:#2A5696;
        color:#FFFFFF;
        font-size:20px;
        text-align:center;
        padding-left:10px;
		border-bottom:1px solid #FFFFFF;
		border-top:1px solid #FFFFFF;

    }
    .cb_texto_cab {
        background:#2F66B8;
        color:#FFFFFF;
        font-size:14px;
    }

    .cb_texto_cab1 {
        padding-left:10px;
    }
    .cb_texto_int_cab {
        background:#2F66B8;
        color:#FFFFFF;
        font-size:14px;
        text-align:center;
		border-right:1px solid #C4C9CD;
    	padding-top:5px;
		padding-bottom:5px;


    }
	
	td.class_t {
	
	    background:#2F66B8;
        color:#FFFFFF;
        font-size:11px;
        xtext-align:center;
        padding-top:10px;
		padding-bottom:10px;
		color:#FFFFFF;
		border-right:1px solid #C4C9CD;
		border-top:1px solid #FFFFFF;
		border-bottom:2px solid #C4C9CD;

	
	}
	td.ur {
	
	    font-weight: bold;
		color:#FFFFFF;

	
	}
	.cb_texto_int_subcab {
        background:#2F66B8;
        color:#FFFFFF;
        font-size:14px;
        text-align:center;
        
		border-right:1px solid #C4C9CD;

    }

    .cb_texto_linha_par {
        background:#FFFFFF;
        font-size:11px;
		padding-top:5px;
		padding-bottom:5px;
		border-bottom:1px solid #C0C0C0;
		border-top:1px solid #FFFFFF;
		
		border-right:1px solid #C4C9CD;
    }
    .cb_texto_linha_imp {
        background:#ABBBBF;
        font-size:11px;
		padding-top:5px;
		padding-bottom:5px;
		border-bottom:1px solid #C0C0C0;
		border-top:1px solid #FFFFFF;
		
		border-right:1px solid #C4C9CD;
    }

    .cb_texto {
        color:#000000; text-align:left;
        padding-left:10px;

    }
	.cb_texto_pj {
        color:#000000; text-align:left;
        padding-left:10px;
		background:#F1F1F1;
        xfont-size:14px;
		border-bottom:1px solid #FFFFFF;

    }
    .cb_inteiro {
        color:#000000;
        text-align:right;
        padding-right:10px;
    }

    .cb_perc {
        color:#000000;
        text-align:right;
        padding-right:10px;
    }

    .total_g {
        background:#0080FF;
        color:#FFFFFF;
		border-top:1px solid #FFFFFF;
    }
    .semclassificar {
        background:#FF0000;
        color:#FFFFFF;
    }

    td.cb_barra_ferramenta {
	    cursor:pointer;
		background:#ECF0F1;
        color:#2C3E50;
		width:10%;
		padding:10px;
		border-right:1px solid #000000;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		
	}
    .parametros_visualizacao {
	    width:100%;
		background:#ECF0F1;
		display:none;
		border:1px solid #000000;
	
	}
	.parametros_l1 {
	    width:100%;
		background:#ECF0F1;
		cursor:pointer;
		xmargin-top:10px;
		padding:10px;
	}



    .cb_texto_cab {
        background:#2F66B8;
        color:#FFFFFF;
        font-size:18px;
		text-align:center;
    }
	

    .cb_texto {
        background:#FFFFFF;
        color:#000000;
        font-size:11px;
		text-align:left;
        padding-left:10px;
		border-bottom:1px solid #ECF0F1;
		border-right:1px solid #C0C0C0;
    }

    .cb_texto_s {
        background:#ECF0F1;
        color:#000000;
        font-size:14px;
		text-align:center;
        padding-left:10px;
		
		padding-top:5px;
		padding-bottom:5px;
		border-bottom:1px solid #C0C0C0;
		border-right:1px solid #C0C0C0;
    }

    .cb_texto_t {
        background:#C4C9CD;
        color:#FFFFFF;
        font-size:14px;
		text-align:center;
        padding-left:10px;
		
		padding-top:5px;
		padding-bottom:5px;
		border-bottom:1px solid #C0C0C0;
		border-right:1px solid #C0C0C0;
    }

	.cb_inteiro {
        text-align:right;
        padding-right:10px;
    }

    #filtro_classificacao {
        display:block;
	}
	#classificacao {
        display:none;
	}
	tr.tit td:last-child {
        display:none;
	}
	.barra_ferramentas {
	    padding-bottom:3px;
		xmargin-bottom: 15px;
		xborder: 1px solid #C0C0C0;
		width:98%;
	}
	form {
	    padding-top:40px;
		
	}
</style>


<?php

//////////////// filtros no padrão


if ($_GET['print'] != 's') {
    echo "<div class='barra_ferramentas'>";
    echo "<table cellspacing='0' cellpadding='0' width='100%' border='0'>";
    echo "<tr>";
    echo "<td width='20'>";
	echo "<a HREF='#' onclick=\"return voltar(1);\"><img class='bartar' align=middle src='imagens/bt_voltar.png'></a>";
    echo "</td>";
    echo "<td width='20'>";
    $titulo_rel = 'Lista Credenciados';
    $str=$menu."&titulo_rel=".$titulo_rel;
    echo "<a HREF='#' onclick=\"return imprimir_rel('$str');\"><img class='bartar' align=middle src='relatorio/visualiza_imprime.jpg'></a>";
    echo "</td>";
    $href = "conteudo_nan_credenciado.php" ;
    echo "<td width='20'>";
    echo "<a HREF='#' onclick=\"return imprimir_excel('$str');\"><img class='bartar' align=middle src='../imagens/excel.gif'></a>";
    echo "</td>";
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}

echo '<form name="frm" target="_self" action="conteudo_nan_credenciado.php?'.substr(getParametro($strPara),1).'" method="post">';
$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'credenciado_texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

///////////// filtros
$vetOrdenacao = Array(
    'gec_pj.descricao, gec_e.descricao' => 'Razão Social, Nome do Indicado',
	'gec_e.descricao, gec_pj.descricao' => 'Nome do Indicado, Razão Social',
	'gec_pj.codigo, gec_e.codigo' => 'CNPJ, CPF',
    'gec_e.codigo, gec_pj.codigo ' => 'CPF, CNPJ',
	
);

$Filtro = Array();
$Filtro['rs']         = $vetOrdenacao;
$Filtro['id']         = 'indice_ordenacao';
$Filtro['nome']       = 'Classificar por:';
// $Filtro['LinhaUm'] = 'Selecione um registro';
$Filtro['valor']      = trata_id($Filtro);
$vetFiltro['indice_ordenacao'] = $Filtro;

// Área de Filtro do relatório
$idx = -1;
ForEach($vetFiltro as $Filtro) {
    $idx++;
    $strPara .= $Filtro['id'].$idx.',';
}

//p($_GET);
if ($_GET['print'] != 's') {
    $Focus = '';
    codigo_filtro(false);
    onLoadPag($Focus);
} else {
    codigo_filtro_fixo();
    onLoadPag();
}
echo "</form>";

$idt_area        = $_GET['idt_area'];
/*
$sql  = 'select ';
$sql .= '  gec_ac.descricao_estruturada ';
$sql .= '  from gec_area_conhecimento gec_ac   ';
$sql .= '  where  ';
$sql .= '      gec_ac.idt  = '.null($idt_area);
$rs = execsql($sql);
ForEach ($rs->data as $row)
{
	$descricao_estruturada = $row['descricao_estruturada'];
}
*/

$kokw = 0;
$sql  = 'select ';
//$sql .= '  distinct gec_ee.idt, ';
//$sql .= '  gec_e.*, idt_natureza, ';

$sql .= '  gec_e.*, ';
$sql .= '  gec_pj.codigo as gec_pj_cnpj, gec_pj.descricao as gec_pj_descricao ';
$sql .= '  from '.db_pir_gec.'gec_entidade gec_e   ';
$sql .= ' left  join '.db_pir_gec.'gec_entidade_entidade gec_ee on gec_ee.idt_entidade_relacionada = gec_e.idt ';
$sql .= '                         and    gec_ee.idt_entidade_relacao = 8 ';
$sql .= ' left  join '.db_pir_gec.'gec_entidade gec_pj on gec_pj.idt = gec_ee.idt_entidade ';
$sql .= '  where  ';
$sql .= '            gec_e.reg_situacao     = '.aspa('A');
$sql .= '     and    gec_e.tipo_entidade    = '.aspa('P');
$sql .= '     and    gec_e.credenciado      = '.aspa('S');
$sql .= '     and    gec_e.credenciado_nan  = '.aspa('S');
$sql .= '     and    gec_e.nan_ano          = '.aspa(nan_ano);
$sql .= '     and    gec_pj.credenciado     = '.aspa('S');
$sql .= '     and    gec_pj.credenciado_nan = '.aspa('S');
$sql .= '     and    gec_pj.nan_ano         = '.aspa(nan_ano);
$sql .= '     and    gec_ee.idt_entidade_relacao = 8 ';

if ($vetFiltro['texto']['valor']!='')
{
    $sql .= '     and    ';
	$sql .= ' ( ';
	$sql .= '  lower(gec_e.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(gec_e.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(gec_pj.codigo) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(gec_pj.descricao)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' ) ';

	
	
}

//p($sql);
//$sql .= ' order by idt_natureza, gec_e.descricao, gec_pj.descricao ';


//$sql .= ' order by idt_natureza, gec_e.descricao ';

if ($vetFiltro['indice_ordenacao']!='')
{
    $sql .= ' order by '.$vetFiltro['indice_ordenacao']['valor'];
}
else
{
    $sql .= ' order by gec_pj.descricao, gec_e.descricao ';
}

$rs = execsql($sql);

echo "<div id='migra_excel'>";


echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

echo "<tr class=''>  ";
echo "   <td colspan='4' class='cb_texto' style=''>$descricao_estruturada</td> ";
echo "</tr>";



echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab' style='width:13%'>CNPJ</td> ";
echo "   <td class='cb_texto_cab' style='width:38%;'>RAZÃO SOCIAL</td> ";
echo "   <td class='cb_texto_cab' style='width:1%'></td> ";
echo "   <td class='cb_texto_cab' style='width:10%;'>CPF</td> ";
echo "   <td class='cb_texto_cab' style='width:38%;'>NOME</td> ";
echo "</tr>";
$idt_naturezaw = 0;
//p($sql);
$qtd_pessoas = 0;
$qtd_pj = 0;
$ordem = 0;
ForEach ($rs->data as $row)
{
    $idt_entidade     = $row['idt'];
	$codigo           = $row['codigo'];
	$descricao        = $row['descricao'];
	$idt_natureza     = $row['idt_natureza'];
	$gec_pj_cnpj      = $row['gec_pj_cnpj'];
	$gec_pj_descricao = $row['gec_pj_descricao'];
	
	
	
	if ($idt_naturezaw != $idt_natureza)
	{
	    if ($idt_naturezaw!=0)
		{
			$classw = 'cb_texto_t';
			$qtd_pessoasw = format_decimal($qtd_pessoas,0);
			echo "<tr class=''>  ";
			echo "   <td colspan='4' id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >";
			echo "   {$brancos}Total de {$natureza}: {$qtd_pessoasw} ";
			echo "   </td> ";
			echo "</tr>  ";
		}
	    $idt_naturezaw = $idt_natureza;
		$natureza = "Instrutores";
		if ($idt_naturezaw==2)
		{
		    $natureza = "Consultores";
		}
		$classw = 'cb_texto_s';
		echo "<tr class=''>  ";
		echo "   <td colspan='4' id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >";
		echo "   {$brancos}{$natureza} ";
		echo "   </td> ";
		echo "</tr>  ";
		$qtd_pessoas = 0;
	}
	$qtd_pessoas = $qtd_pessoas + 1;
	//$brancos="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$brancos  = "";
	$onclick  = "";
	$hint     = "";
	$cursor   = "";
	$classw = 'cb_texto';
	echo "<tr class=''>  ";
	//$gec_pj_cnpjw="##";
	if ($gec_pj_cnpjw!=$gec_pj_cnpj)
	{
	    $gec_pj_cnpjw=$gec_pj_cnpj;
		
        $qtd_pj = $qtd_pj+1;
		$ordem = 0;
        $classw = 'cb_texto_pj';
	//	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$gec_pj_cnpj}</td> ";
	//	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$gec_pj_descricao}</td> ";
		
		
    }
	else
	{
	    $brancos="&nbsp;";
	  //  echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}</td> ";
	//	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}</td> ";
		$brancos="";
	}
	
	// 
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$gec_pj_cnpj}</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$gec_pj_descricao}</td> ";
		
	
	
	$qtd_pessoas = $qtd_pessoas + 1;
	$ordem       = $ordem + 1;
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor} text-align:right;' >{$ordem}</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$codigo}</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$descricao}</td> ";

	echo "</tr>  ";

}
if ($idt_naturezaw!=0)
{
	$classw = 'cb_texto_t';
	$qtd_pessoasw = format_decimal($qtd_pessoas,0);
	echo "<tr class=''>  ";
	echo "   <td colspan='5' id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >";
	echo "   {$brancos}Total de {$natureza}: {$qtd_pessoasw} ";
	echo "   </td> ";
	echo "</tr>  ";
}

$classw = 'cb_texto_t';
$qtd_pessoasw = format_decimal($qtd_pessoas,0);
$qtd_pjw = format_decimal($qtd_pj,0);
echo "<tr class=''>  ";
echo "   <td colspan='5' id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >";
echo "   {$brancos}Total de Credenciados: {$qtd_pjw}  {$brancos}Total de Indicados: {$qtd_pessoasw} ";
echo "   </td> ";
echo "</tr>  ";
echo "</table>";

echo "</div>";

echo "<br />";
echo "<br />";




?>

<script>	

var migra_excel = 'migra_excel';

$(document).ready(function () {

});

function imprimir_rel(titulo)
{
   alert('Impressora'+titulo); 
   print();
}
function imprimir_excel(titulo)
{
   migrar_xls();
}
function voltar(op)
{
   if (op==1)
   {
       javascript:close();  
   }	   
}
function migrar_xls()
{
    alert('Excel'+migra_excel); 
	var div = '#'+migra_excel;
}
</script>



	

