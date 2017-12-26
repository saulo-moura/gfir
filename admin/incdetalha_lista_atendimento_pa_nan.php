
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
        font-size:18px;
    }

    .cb_texto_cab1 {
        padding-left:10px;
    }
    .cb_texto_int_cab {
        background:#2F66B8;
        color:#FFFFFF;
        font-size:14px;
        text-align:center;
        //padding-right:20px;
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

</style>


<?php

function CriarDimensoesAtendimento(&$vetDimensao) {
    $kokw = 0;
	$vetPontoUR = Array();
    $vetInstrumento = Array();
    $vetPontoAtendimento = Array();
    //Instrumento
    $sqll = 'select ';
    $sqll .= '  grc_i.* ';
    $sqll .= '  from  grc_atendimento_instrumento grc_i ';
    //$sqll .= " where nivel = 1 and balcao = 'S' ";
	$sqll .= " where  balcao = 'S' ";
    $sqll .= '  order by idt_atendimento_instrumento ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt       = $rowl['idt'];
        $codigo    = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo     = $rowl['ativo'];
        $vetInstrumento[$idt] = $rowl;
    }
    // Ponto de Atendimento
    $sqll = 'select ';
    $sqll .= '  sca_os.* ';
    $sqll .= '  from  '.db_pir.'sca_organizacao_secao sca_os ';
    $sqll .= '  where posto_atendimento = "S" or tipo_estrutura="UR" ';
    $sqll .= '  order by sca_os.classificacao ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt            = $rowl['idt'];
        $descricao      = $rowl['descricao'];
		$tipo_estrutura = $rowl['tipo_estrutura'];
        $vetPontoAtendimento[$idt] = $rowl;
		if ($tipo_estrutura=="UR") 
		{
		    $idt_ur = $idt;
		}
		else
		{
		   $vetPontoUR[$idt] = $idt_ur;
		}
    }

    $vetDimensao['PontoAtendimento'] = $vetPontoAtendimento;
    $vetDimensao['Instrumento']      = $vetInstrumento;
	$vetDimensao['UR']               = $vetPontoUR;
    return $kokw;
}

function QuantitativosAtendimento($idt_ponto_atendimento, $vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, &$vetDimensao, &$vetDimensaoTotal, &$TotalGeral_G, &$vetDimensaoInstrumento, &$vetDimensaoTempoI, &$vetDimensaoTempoP) {
/*
    $condicao    = " ano = '2016' and idt_ponto_atendimento = {$idt_ponto_atendimento} and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is null ";
    $vetDimensao = Array();
	
	$vetDimensaoTotal = Array();
	
    $sql = "select ";
        $sql .= "   count(grc_a.idt) as quantidade, sum(horas_atendimento) as horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento ";
    $sql .= " from grc_atendimento grc_a ";
	$sql .= " inner join grc_competencia grc_c on grc_c.idt =  grc_a.idt_competencia";
*/	
	
	
	
  $condicao    = " (grc_ga.status_1 = 'AP' ) and idt_grupo_atendimento is not null ";
	
	
	
    $vetDimensao = Array();
	
	$vetDimensaoTotal = Array();
	
    $sql = "select ";
    $sql .= "   count(grc_a.idt) as quantidade, sum(horas_atendimento) as horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento ";
    $sql .= " from grc_atendimento grc_a ";
	$sql .= " inner join grc_nan_grupo_atendimento grc_ga on grc_ga.idt =  grc_a.idt_grupo_atendimento";
	//$sql .= " inner join grc_competencia grc_c on grc_c.idt =  grc_a.idt_competencia";
 	
	
	
	
	
	
	
	
	
	
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by grc_a.idt_ponto_atendimento, grc_a.idt_instrumento  ";

    $rsl = execsql($sql);
    $total = 0;
    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento  = $rowl['idt_ponto_atendimento'];
		
		$idt_instrumento        = $rowl['idt_instrumento'];
		if ($vetInstrumento[$idt_instrumento] > 0)
		{   // Instrumento é de Balcão
			$quantidade             = $rowl['quantidade'];
			$horas_atendimento      = $rowl['horas_atendimento'];
			$TotalGeral_G           = $TotalGeral_G + $quantidade;
			$vetDimensao[$idt_ponto_atendimento][$idt_instrumento] = $quantidade;
			$vetDimensaoTotal[$idt_ponto_atendimento] = $vetDimensaoTotal[$idt_ponto_atendimento] + $quantidade;
			$vetDimensaoInstrumento[$idt_instrumento] = $vetDimensaoInstrumento[$idt_instrumento] + $quantidade;
			
			$vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] = $horas_atendimento;
			$vetDimensaoTempoP[$idt_ponto_atendimento] = $vetDimensaoTempoP[$idt_ponto_atendimento] + $horas_atendimento;
			
			$idt_ur                                   = $vetPontoUR[$idt_ponto_atendimento];
			if ($idt_ur>0)
			{
				$idt_ponto_atendimento=$idt_ur;
				$vetDimensao[$idt_ponto_atendimento][$idt_instrumento] = $vetDimensao[$idt_ponto_atendimento][$idt_instrumento] + $quantidade;
				$vetDimensaoTotal[$idt_ponto_atendimento] = $vetDimensaoTotal[$idt_ponto_atendimento] + $quantidade;
				
				$vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] = $vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] + $horas_atendimento;
			    $vetDimensaoTempoP[$idt_ponto_atendimento] = $vetDimensaoTempoP[$idt_ponto_atendimento] + $horas_atendimento;
			}		
		}	
    }

}

$cargo           = $_GET['cargo'];
$idt_organizacao = $_GET['idt_organizacao'];
$descricao_cargo = "";


$vetPontoAtendimento   = Array();
$vetInstrumento        = Array();
$vetDimensao           = Array();
$ret = CriarDimensoesAtendimento($vetDimensao);
$vetPontoAtendimento   = $vetDimensao['PontoAtendimento'];
$vetInstrumento        = $vetDimensao['Instrumento'];
$vetPontoUR            = $vetDimensao['UR'];

  //p($vetInstrumento);
  // p($vetPontoAtendimento);
  
$vetAtendimentoQtd = Array();
$idt_dimensao   = 'idt_instrumento';
$vetDimensao    = Array();
$vetDimensaoInstrumento = Array();
$vetDimensaoTempoI=Array();
$vetDimensaoTempoP=Array();

$condicao       = ""; // todos os produtos
 QuantitativosAtendimento($idt_ponto_atendimento,$vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP);
$vetAtendimentoQtd = $vetDimensao;
  
//p($vetAtendimentoQtd);  
//p($vetDimensaoTotal);  
//p($vetInstrumento);
/*
// Barra de Ferramentas
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";

$onclickA = " onclick = 'return AbreParametros();' ";
$hint     = "title = 'Clique aqui para parametrizar a Visualização das linhas da Matriz'";
echo "   <td {$onclickA} {$hint} class='cb_barra_ferramenta' style=''>Visualização</td> ";

echo "   <td  class='cb_barra_ferramenta' style='width:90%'>&nbsp;</td> ";


echo "</tr>";
echo "</table>";

echo "<div id='parametros' class='parametros_visualizacao'>";

echo "<div id='parametros_linhas' class='parametros_l1'>";
$onclickA = " onclick = 'return Parametros_ocultar_ur();' ";
$hint     = "title = 'Clique aqui para Ocultar as linhas das Unidades Regionais'";
echo "   <a {$onclickA} {$hint} class='cb_barra_ferramenta' style=''>Ocultar/Exibir linhas das Unidades Regionais</a> ";
echo "</div>";

echo "<div id='parametros_linhas' class='parametros_l1'>";
$onclickA = " onclick = 'return Parametros_ocultar_pa();' ";
$hint     = "title = 'Clique aqui para Ocultar as linhas dos PAs '";
echo "   <a {$onclickA} {$hint} class='cb_barra_ferramenta' style=''>Ocultar/Exibir linhas dos PAs</a> ";
echo "</div>";

echo "</div>";

echo "<br />";

*/
//
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
$data_inicio='01/01/2016'; 
$data_final ='31/12/2016'; 
echo "   <td colspan='11' class='cb_texto_tit' style='' >Período de {$data_inicio} até {$data_final}</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td rowspan='2' class='cb_texto_int_cab cb_texto_cab1' style='width:27%'>Unidade Regional<br />Ponto de Atendimento</td> ";
ForEach ($vetInstrumento as $idt => $row) {
    echo "   <td colspan='2' class='cb_texto_int_cab' style='width:16'>{$row['descricao']}</td> ";
}
echo "   <td colspan='2' class='cb_texto_int_cab' style='width:16%'>TOTAL</td> ";

echo "   <td colspan='2' class='cb_texto_int_cab' style='width:13%'>TEMPO</td> ";


echo "</tr>";
echo "<tr class=''>  ";
ForEach ($vetInstrumento as $idt => $row) {
    echo "   <td class='cb_texto_int_subcab' style=''>Quantidade</td> ";
    echo "   <td class='cb_texto_int_subcab' style=''>%</td> ";
}
echo "   <td class='cb_texto_int_subcab' style=''>Quantidade</td> ";
echo "   <td class='cb_texto_int_subcab' style=''>%</td> ";

echo "   <td class='cb_texto_int_subcab' style=''>TOTAL</td> ";
echo "   <td class='cb_texto_int_subcab' style=''>MÉDIO</td> ";

echo "</tr>";


 $tempo_total_G = 0;


$row=$vetPontoAtendimento[$idt_ponto_atendimento];
$i = $i + 1;
$brancos="";
$hint="";
$id_linha=$idt_ponto_atendimento;
if ($row['tipo_estrutura']=='UR')
{
	$classw  =  'cb_texto_linha_imp ur ';
	$idt_ur  = $idt_ponto_atendimento;
	$onclick = " onclick = 'return AbreFechaUnidade($idt_ur); '";
	$hint="Clique aqui para Abrir/Fechar Unidade Regional";
}
else
{
	$hint="Clique aqui para Detalhar os ATENDIMENTOS do Ponto de Atendimento";
	$classw =   "cb_texto_linha_par pa pa{$idt_ur}";
	$brancos="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$onclick = " onclick = 'return DetalhaPA($idt_ponto_atendimento); '";
}
echo "<tr class=''>  ";

echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}'class='cb_texto {$classw}' style='cursor:pointer;' >{$brancos}{$row['descricao']}</td> ";
$TotalGeral = $vetDimensaoTotal[$idt_ponto_atendimento];

ForEach ($vetInstrumento as $idt => $row) {
	$quantidade = $vetDimensao[$idt_ponto_atendimento][$idt];
	echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
	$perc=0;
	if ($TotalGeral>0)
	{
		$perc = ($quantidade / $TotalGeral) * 100;
	}
	$percw = format_decimal($perc, 2).' %';
	echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
}
echo "   <td class='cb_inteiro {$classw}' style='' >$TotalGeral</td> ";
$perc=0;
if ($TotalGeral_G>0)
{
	$perc = ($TotalGeral / $TotalGeral_G) * 100;
}
$percw = format_decimal($perc, 2).' %';
echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";



$tempo_total = $vetDimensaoTempoP[$idt_ponto_atendimento];

$tempo_total_G = $tempo_total_G +  $tempo_total;

echo "   <td class='cb_perc {$classw}' style='' >$tempo_total</td> ";
$media=0;
if ($TotalGeral>0)
{
	$media = ($tempo_total / $TotalGeral) ;
}
$mediaw = format_decimal($media, 1).' min';
echo "   <td class='cb_perc {$classw}' style='' >$mediaw</td> ";
echo "</tr>";
echo "</table>";
//
echo "<br />";
//
//$condicao    = " ano = '2016' and idt_ponto_atendimento = {$idt_ponto_atendimento} and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is null ";



$condicao    = " idt_ponto_atendimento = {$idt_ponto_atendimento} and (grc_ga.status_1 = 'AP' ) and idt_grupo_atendimento is not null ";

$sql = "select ";

$sql .= "   grc_a.idt  as grc_a_idt,";
$sql .= "   grc_a.protocolo, grc_a.horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento, ";
$sql .= "   grc_a.data_inicio_atendimento, ";
$sql .= "   grc_ap.cpf  as grc_ap_cpf,";
$sql .= "   grc_ap.nome as grc_ap_nome,";
$sql .= "   grc_ap.representa_empresa as grc_ap_representa_empresa,";
$sql .= "   grc_ap.tipo_relacao as grc_ap_tipo_relacao,";

$sql .= "   grc_ao.cnpj  as grc_ao_cnpj,";
$sql .= "   grc_ao.razao_social as grc_ao_razao_social,";

$sql .= "   concat_ws('<br />',grc_ap.nome,grc_ao.razao_social) as nome_razao_social,";


$sql .= "   plu_usucon.nome_completo as plu_usucon_nome_completo";

$sql .= " from grc_atendimento grc_a ";
$sql .= " left join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento =  grc_a.idt";
$sql .= "                                         and tipo_relacao = 'L' ";

$sql .= " left join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento =  grc_a.idt";
$sql .= "                                         and grc_ao.representa = 'S' ";

$sql .= " inner join grc_nan_grupo_atendimento grc_ga on grc_ga.idt =  grc_a.idt_grupo_atendimento";

//$sql .= " inner join grc_competencia grc_c on grc_c.idt =  grc_a.idt_competencia";
$sql .= " left  join plu_usuario plu_usudig on plu_usudig.id_usuario   =  grc_a.idt_digitador";
$sql .= " inner join plu_usuario plu_usucon on plu_usucon.id_usuario   =  grc_a.idt_consultor";
if ($condicao != "") {
    $sql .= "  where $condicao ";
}
$sql .= "  order by data_inicio_atendimento, idt_instrumento ";
$rsl = execsql($sql);
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td  class='cb_texto_int_cab' style=''>Data</td> ";
echo "   <td  class='cb_texto_int_cab cb_texto_cab1' style=''>Protocolo</td> ";

echo "   <td  class='cb_texto_int_cab' style=''>Atendente/Consultor</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Instrumento</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Cliente/Representante</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Tipo</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>TEMPO</td> ";

echo "</tr>";
$total_tempo = 0;
ForEach ($rsl->data as $rowl) {
    $idt_atendimento          = $rowl['grc_a_idt'];
    $protocolo                = $rowl['protocolo'];
	$data_inicio_atendimento  = trata_data($rowl['data_inicio_atendimento']);
	$plu_usucon_nome_completo = $rowl['plu_usucon_nome_completo'];
	$idt_instrumento          = $rowl['idt_instrumento'];
	$grc_ap_nome              = $rowl['grc_ap_nome'];
	$grc_ap_tipo_relacao      = $rowl['grc_ap_tipo_relacao'];
	$grc_ap_representa_empresa= $rowl['grc_ap_representa_empresa'];
	
	$horas_atendimento        = $rowl['horas_atendimento'];
	
	$nome_razao_social        = $rowl['nome_razao_social'];
	
	$classw            = "cb_texto_linha_par ";
	$total_tempo       = $total_tempo + $horas_atendimento;
	$row               = $vetInstrumento[$idt_instrumento]; 
	$idt_instrumento_t = $row['descricao'];
	
	if ($grc_ap_representa_empresa=='N')
	{
	    $grc_ap_representa_empresa_w='PF';
	}
	else
	{
        $grc_ap_representa_empresa_w='PJ';
	}
	
    echo "<tr class=''>  ";
	echo "   <td class='cb_texto {$classw}' style=' text-align:center;' >{$data_inicio_atendimento}</td> ";
	
	$onclick = " onclick = 'return Detalha_Atendimento($idt_atendimento); '";
	$hint=" title='Clique aqui para Detalhar o Atendimento' ";
    echo "   <td id='{$idt_atendimento}' {$onclick} {$hint} class='cb_texto {$classw}' style='cursor:pointer; color:#2F66B8;  text-align:center;' >{$protocolo}</td> ";

	echo "   <td class='cb_texto {$classw}' style='' >{$plu_usucon_nome_completo}</td> ";
	echo "   <td class='cb_texto {$classw}' style='' >{$idt_instrumento_t}</td> ";
	//echo "   <td class='cb_texto {$classw}' style='' >{$grc_ap_nome}</td> ";
	echo "   <td class='cb_texto {$classw}' style='' >{$nome_razao_social}</td> ";
	
	echo "   <td class='cb_texto {$classw}' style=';' >{$grc_ap_representa_empresa_w}</td> ";
	
	echo "   <td class='cb_inteiro {$classw}' style=';' >{$horas_atendimento}</td> ";
	
	echo "</tr>  ";
	
}
    // total
    echo "<tr class=''>  ";
    echo "   <td colspan='6' class='class_t cb_texto ' style='cursor:pointer; text-align:right;' >TEMPO TOTAL</td> ";
	echo "   <td class='class_t cb_inteiro ' style='cursor:pointer;' >{$total_tempo}</td> ";
	echo "</tr>  ";

echo "</table>";


?>



<script type="text/javascript" >
function Detalha_Atendimento(idt_atendimento)
{
    alert('Chamar ficha do atendimento para consultar'+idt_atendimento);
    return false;
}
	
</script>
