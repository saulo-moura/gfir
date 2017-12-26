
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
        padding-right:20px;
		border-right:1px solid #C4C9CD;
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
        padding-left:5px;

    }
    .cb_inteiro {
        color:#000000;
        text-align:right;
        padding-right:5px;
    }

    .cb_perc {
        color:#000000;
        text-align:right;
        padding-right:5px;
		padding-left:3px;
		white-space:nowrap;
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
		background:#C4C9CD;
        color:#FFFFFF;
		width:10%;
		padding:5px;
		border-right:1px solid #000000;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		
	}
    .parametros_visualizacao {
	    width:100%;
		background:#ECF0F1;
		color:#666666;
		display:none;
		border:1px solid #000000;
	
	}
	.parametros_l1 {
	    width:100%;
		background:#ECF0F1;
		cursor:pointer;
		padding:5px;
	}
	
    .cb_titulo_meta {
		background:#2F66BB;
        color:#FFFFFF;
        font-size:20px;
        text-align:center;
    }

    .cb_texto_abc_titulo {
		background:#2A5696;
        color:#FFFFFF;
        font-size:18px;
        text-align:center;
		color:FFFFFF;
    }
    .cb_texto_abc_cab {
		background:#ECF0F1;
		font-size:14px;
		padding:5px;
		padding-right:25px;
		text-align:right;
		color:FFFFFF;
	}
	
	.cb_texto_abc_lin {
		background:#FFFFFF;
		font-size:14px;
		padding-right:25px;
		text-align:right;
		color:000000;
	}




</style>


<?php

function CriarDimensoesAtendimentoMeta7(&$vetDimensao) {
    $kokw = 0;
	$vetPontoUR = Array();
    $vetInstrumento = Array();
    $vetPontoAtendimento = Array();
    //Instrumento
    $sqll = 'select ';
    $sqll .= '  grc_i.* ';
    $sqll .= '  from  grc_atendimento_instrumento grc_i ';
	//
    // $sqll .= " where nivel = 1 and balcao = 'S' ";
	//
	$sqll .= " where  ordem_matriz > 0 ";
    //$sqll .= '  order by balcao desc, idt_atendimento_instrumento ';
	$sqll .= '  order by ordem_matriz ';
    $rsl = execsqlNomeCol($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt       = $rowl['idt'];
        $codigo    = $rowl['codigo'];
		$descricao = $rowl['descricao_matriz'];
        $ativo     = $rowl['ativo'];
        $vetInstrumento[$idt] = $rowl;
    }
    // Ponto de Atendimento
    $sqll = 'select ';
    $sqll .= '  sca_os.* ';
    $sqll .= '  from  '.db_pir.'sca_organizacao_secao sca_os ';
    $sqll .= '  where posto_atendimento = "S" or tipo_estrutura="UR" ';
    $sqll .= '  order by sca_os.classificacao ';
    $rsl = execsqlNomeCol($sqll);
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

function QuantitativosAtendimentoMeta7($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, &$vetDimensao, &$vetDimensaoTotal, &$TotalGeral_G, &$vetDimensaoInstrumento, &$vetDimensaoTempoI, &$vetDimensaoTempoP,$op,&$vetMensal,&$vetEst) {
    //$vetDimensao = Array();
	
	//$vetDimensaoTotal = Array();
	
    $sql = "select ";
    $sql .= "   count(grc_a.idt) as quantidade, sum(horas_atendimento) as horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento ";
	$sql .= " from grc_historico_meta grc_a ";
	
	
    //$sql .= " from grc_atendimento grc_a ";
	//$sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento =  grc_a.idt";
	//$sql .= " left  join grc_nan_grupo_atendimento grc_ga on grc_ga.idt           =  grc_a.idt_grupo_atendimento";
	
	
	if ($op==2)
	{
	    $condicao = " origem = 'Evento' ";
	}
	else
	{
	    $condicao = " origem = 'Balcão' ";
	}
	//$condicao .= " and meta2 ='S' and req_intensidade = 'S'  ";
	
	$condicao .= " and meta7 ='S' and req_intensidade='S'  ";
	
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by grc_a.idt_ponto_atendimento, grc_a.idt_instrumento  ";
	
    $rsl = execsqlNomeCol($sql);
    $total = 0;
    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento  = $rowl['idt_ponto_atendimento'];
		
		$idt_instrumento        = $rowl['idt_instrumento'];
		if ($op==2 and $idt_instrumento==2)
		{
		    $idt_instrumento=39; // longa duração; 
		}
		if ($vetInstrumento[$idt_instrumento] > 0)
		{   // Instrumento 
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




	$sql = "select ";  
	$sql .= "   count(grc_a.idt) as quantidade, sum(grc_a.horas_atendimento) as horas_atendimento, substring(grc_a.data_atendimento,1,7) as anomes ";
	$sql .= " from grc_historico_meta grc_a ";
	//$sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento =  grc_a.idt";
	//$sql .= " left  join grc_evento              grc_ev on grc_ev.idt             =  grc_a.idt_evento";
	//$sql .= " left  join grc_nan_grupo_atendimento grc_ga on grc_ga.idt           =  grc_a.idt_grupo_atendimento";
	
	
	
	
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by substring(data_atendimento,1,7)  ";
	
    $rsl = execsqlNomeCol($sql);
	
    ForEach ($rsl->data as $rowl) {
        $anomes             = $rowl['anomes'];
		$quantidade         = $rowl['quantidade'];
		$horas_atendimento  = $rowl['horas_atendimento'];
		$vetMensal[$anomes]['qtd']=$vetMensal[$anomes]['qtd']+$quantidade;
		$vetMensal[$anomes]['hor']=$vetMensal[$anomes]['hor']+$horas_atendimento;
    }


    // Quantidade Bruta
    $sql = "select ";  
	$sql .= "   count(grc_a.idt) as quantidade, sum(grc_a.horas_atendimento) as horas_atendimento, tipo_pessoa, porte_meta ";
	$sql .= " from grc_historico_meta grc_a ";

	
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by tipo_pessoa, porte_meta  ";
	
    $rsl = execsqlNomeCol($sql);
	
    ForEach ($rsl->data as $rowl) {
        $tipo_pessoa        = $rowl['tipo_pessoa'];
		$porte_meta        = $rowl['porte_meta'];
		$quantidade         = $rowl['quantidade'];
		$horas_atendimento  = $rowl['horas_atendimento'];
		$vetEst['porte_meta'][$tipo_pessoa][$porte_meta]['qtd']=$vetEst['porte_meta'][$tipo_pessoa][$porte_meta]['qtd']+$quantidade;
		$vetEst['porte_meta'][$tipo_pessoa][$porte_meta]['hor']=$vetEst['porte_meta'][$tipo_pessoa][$porte_meta]['hor']+$horas_atendimento;
    }


}

$cargo           = $_GET['cargo'];
$idt_organizacao = $_GET['idt_organizacao'];
$descricao_cargo = "";

$vetPontoAtendimento   = Array();
$vetInstrumento        = Array();
$vetDimensao           = Array();
$ret = CriarDimensoesAtendimentoMeta3($vetDimensao);
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
$vetDimensaoTotal=Array();
$TotalGeral_G    = 0;



$vetMensal   = Array();
$vetEst       = Array();
$condicao       = ""; // todos os produtos
$condicao    = "  ( (year(grc_a.data) = 2016 and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is null and idt_grupo_atendimento is null )";
// Para Atendimentos do NAN
$condicao    .= " or (year(grc_a.data) = 2016 and ( (grc_a.nan_num_visita = 1 and grc_ga.status_1 = 'AP') or (grc_a.nan_num_visita = 2 and grc_ga.status_2 = 'AP')  and grc_a.idt_grupo_atendimento is not null ) )  ";
$condicao    .= " ) ";
//	

$condicao       = ""; // todos os produtos
QuantitativosAtendimentoMeta7($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP,1,$vetMensal,$vetEst);
//$condicao    = " ano = '2016' and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is not null and idt_grupo_atendimento is null ";

$condicao     = " year(grc_a.data) = 2016 and idt_evento is not null and idt_grupo_atendimento is null ";
$condicao    .= " and grc_ep.contrato in ('S','G','C')";
//$condicao    .= " and grc_ap.evento_concluio = 'S' "; // Consolidado
	
$condicao       = ""; // todos os produtos
QuantitativosAtendimentoMeta7($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP,2,$vetMensal,$vetEst);
$vetAtendimentoQtd = $vetDimensao;
//p($vetAtendimentoQtd);  
//p($vetDimensaoTotal);  
//p($vetInstrumento);
//p($vetEst);

////////////////////// MESCLAR TABELA COM INSTRUMENTOS DE eVENTOS
//
// ROTINA PARA EVENTOS.
//
//echo "----------------------------------------------------- <br />";



echo "<div id='meta4_titulo' class='cb_titulo_meta'>";
echo "Meta 7 - Atendimentos a Pequenos Negócios - FIDELIZAÇÃO ";
echo "</div>";
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


$vetInstrumentosG=Array();
$vetPAInstrumentosG=Array();

//
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
$data_inicio='01/01/2016'; 
$data_final ='31/12/2016'; 
echo "   <td colspan='29' class='cb_texto_tit' style='text-align:left; padding-left:5px;' >Período de {$data_inicio} até {$data_final}</td> ";
echo "</tr>";
echo "<tr class=''>  ";
echo "   <td rowspan='2' class='cb_texto_int_cab cb_texto_cab1' style=''>Unidade Regional<br />Ponto de Atendimento</td> ";
ForEach ($vetInstrumento as $idt => $row) {
    echo "   <td colspan='2' class='cb_texto_int_cab' style='width:16'>{$row['descricao_matriz']}</td> ";
	$vetInstrumentosG[$idt]=$row['descricao_matriz'];
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
$vetorPANome   = Array(); // Nome
$vetorPAQtdTot = Array(); // Quantidade
$vetorPAPerTot = Array(); // Percentual


	
ForEach ($vetPontoAtendimento as $idt_ponto_atendimento => $row) {
    $i = $i + 1;
	$brancos="";
	$hint="";
	$id_linha=$idt_ponto_atendimento;
	$UnidadeRegional="N";
	if ($row['tipo_estrutura']=='UR')
	{
        $classw  =  'cb_texto_linha_imp ur ';
		$idt_ur  = $idt_ponto_atendimento;
		$onclick = " onclick = 'return AbreFechaUnidade($idt_ur); '";
		$hint="Clique aqui para Abrir/Fechar Unidade Regional";
		$UnidadeRegional="S";
	}
	else
	{
	    $hint="Clique aqui para Detalhar os ATENDIMENTOS do Ponto de Atendimento";
	    $classw =   "cb_texto_linha_par pa pa{$idt_ur}";
	    $brancos="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$onclick = " onclick = 'return DetalhaPA($idt_ponto_atendimento); '";
	}
    echo "<tr class=''>  ";
	//
    echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}'class='cb_texto {$classw}' style='cursor:pointer; white-space:nowrap;' >{$brancos}{$row['descricao']}</td> ";
	if ($UnidadeRegional=="S")
	{
	    $vetorPANome[$idt_ponto_atendimento]=$row['descricao'];
	}	
	//
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
		if ($UnidadeRegional=="S")
		{
			
			$vetPAInstrumentosG[$idt_ponto_atendimento][$idt]=$vetPAInstrumentosG[$idt_ponto_atendimento][$idt] + $quantidade;
			
		}
    }
    echo "   <td class='cb_inteiro {$classw}' style='' >$TotalGeral</td> ";
    $perc=0;
    if ($TotalGeral_G>0)
    {
        $perc = ($TotalGeral / $TotalGeral_G) * 100;
    }
	
	if ($UnidadeRegional=="S")
	{
		$vetorPAQtdTot[$idt_ponto_atendimento]=$TotalGeral;
		$vetorPAPerTot[$idt_ponto_atendimento]=$perc;
		
		
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






}



// linha total geral
echo "<tr class=''>  ";
    $classw='class_t';
    echo "   <td class='cb_texto {$classw}' style='text-align:right' >TOTAL GERAL</td> ";
	$TotalGeral = $vetDimensaoTotal[$idt_ponto_atendimento];
	
	ForEach ($vetInstrumento as $idt => $row) {
	    $quantidade = $vetDimensaoInstrumento[$idt];
        echo "   <td class='cb_inteiro {$classw}' style='' >$quantidade</td> ";
	    $perc=0;
	    if ($TotalGeral_G>0)
	    {
            $perc = ($quantidade / $TotalGeral_G) * 100;
	    }
        $percw = format_decimal($perc, 2).' %';
        echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";
    }
    echo "   <td class='cb_inteiro {$classw}' style='' >$TotalGeral_G</td> ";
    $perc=0;
    if ($TotalGeral_G>0)
    {
        $perc = ($TotalGeral_G / $TotalGeral_G) * 100;
    }
    $percw = format_decimal($perc, 2).' %';
    echo "   <td class='cb_perc {$classw}' style='' >$percw</td> ";

	echo "   <td class='cb_perc {$classw}' style='' >$tempo_total_G</td> ";
    $media=0;
	if ($TotalGeral_G>0)
	{
        $media = ($tempo_total_G / $TotalGeral_G) ;
	}
    $mediaw = format_decimal($media, 1).' min';
    echo "   <td class='cb_perc {$classw}' style='' >$mediaw</td> ";








    echo "</tr>";
echo "</table>";








$vetorPAPerTotSort=Array();
$tam=7;
ForEach ($vetorPAPerTot as $idt_ponto_atendimento => $perw)
{
    $perww = format_decimal($perw,2);
    $indice = ZeroEsq($perww, $tam).ZeroEsq($idt_ponto_atendimento, $tam);
	$vetorPAPerTotSort[$indice]=$idt_ponto_atendimento;
}
krsort($vetorPAPerTotSort);

$vetorPAQtdTotSort=Array();
ForEach ($vetorPAQtdTot as $idt_ponto_atendimento => $qtdw)
{
    $qtdww = format_decimal($qtdw,0);
    $indice = ZeroEsq($qtdww, $tam).ZeroEsq($idt_ponto_atendimento, $tam);
	$vetorPAQtdTotSort[$indice]=$idt_ponto_atendimento;

}
krsort($vetorPAQtdTotSort);

//p($vetorPAPerTotSort);
//p($vetorPAQtdTotSort);
echo "<br />";
//p($vetorPANome); // Nome
//p($vetorPAQtdTot); // Quantidade
//p($vetorPAPerTot); // Percentual

echo "<table style='display:none;' class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
    echo "   <td colspan='4' class='cb_texto_abc_titulo' style='text-align:center'>Atendimentos - Curva ABC</td> ";
echo "</tr>";

echo "<tr class=''>  ";
	echo "   <td class='cb_texto_abc_cab' style=''>Ordem</td> ";
    echo "   <td class='cb_texto_abc_cab' style='text-align:left; padding-left:5px;'>Unidade Operacional</td> ";
	echo "   <td class='cb_texto_abc_cab' style=''>Quantidade</td> ";
    echo "   <td class='cb_texto_abc_cab' style=''>%</td> ";
echo "</tr>";

$titulo      = "Atendimentos - Curva ABC"."<br />Quantidade";
$legenda_x   = "";
$valores_g1  = "";
$virgula     = '';
$totalgeral  = 0;


$ordem = 0;


ForEach ($vetorPAQtdTotSort as $indice  => $idt_ponto_atendimento)
{
    $unidade     = $vetorPANome[$idt_ponto_atendimento];  
	$quantidade  = format_decimal($vetorPAQtdTot[$idt_ponto_atendimento],0);   
	$percentual  = format_decimal($vetorPAPerTot[$idt_ponto_atendimento],2); 
	$legenda_x  .= " {$virgula} '{$unidade}' ";
	$quantidadeat = $vetorPAQtdTot[$idt_ponto_atendimento];
	if ($quantidadeat=='')
	{
	    $quantidadeat='null';
	}
	$valores_g1 .= $virgula.$quantidadeat;
	$virgula     = ', ';
	
	echo "<tr class=''>  ";
	$ordem = $ordem + 1;
	if($ordem % 2 == 0)
	{
	   $bgc   = " background:#F1F1F1; ";
	}
	else
	{
	  $bgc   = " background:#FFFFFF; ";
	}
	
	echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$ordem</td> ";
	echo "   <td class='cb_texto_abc_lin' style='{$bgc} text-align:left; padding-left:5px;'>$unidade</td> ";
	echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$quantidade</td> ";
	echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$percentual</td> ";
	echo "</tr>";
}

$bgc   = " background:#2C3E50; color:#FFFFFF; ";

//echo "<tr class=''>  ";

echo "   <td class='cb_texto_abc_lin' style='{$bgc}'></td> ";
$unidade    = "TOTAL GERAL";
$quantidade = format_decimal($TotalGeral_G,0);
$percentual = "100,00";
echo "   <td class='cb_texto_abc_lin' style='{$bgc} text-align:right; padding-left:5px;'>$unidade</td> ";
echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$quantidade</td> ";
echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$percentual</td> ";
echo "</tr>";

echo "</table> ";

//p($vetMensal);


	


//echo "<br />";

echo "<table style='display:none;' class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
    echo "   <td colspan='3' class='cb_texto_abc_titulo' style='text-align:center'>Atendimentos - Mensal</td> ";
echo "</tr>";

echo "<tr class=''>  ";
    echo "   <td class='cb_texto_abc_cab' style='text-align:left; padding-left:25px;'>Mês</td> ";
	echo "   <td class='cb_texto_abc_cab' style=''>Quantidade</td> ";
    //echo "   <td class='cb_texto_abc_cab' style=''>Horas</td> ";
	echo "   <td class='cb_texto_abc_cab' style='padding-right:25px;'>%</td> ";
echo "</tr>";
$ordem = 0;



$ano="2016";
$vetfalta=Array(); 
$qtdmeses = count($vetMensal);
$qtdm = count($vetMensal)+1;
for ($tp = $qtdm; $tp <= 12; $tp++) {
    if ($tp<10)
	{
        $mesw = ZeroEsq($tp,2);
	}
	else
	{
        $mesw = $tp;
	}
	$anomes = $ano.'-'.$mesw;
	$vetMensal[$anomes]['qtd']='null';
	$vetMensal[$anomes]['hor']='null';
}
ksort($vetMensal);

$metaanual = $vetMetasValorAnual['MM7'];



$titulo2     = "Atendimentos - Mensal"."<br />Quantidade";
$legenda_y   = "";
$valores_g2  = "";
$virgula     = '';

$valores_g3  = "";
$valores_g4  = "";
$valores_g5  = "";

$horast = 0;
$acumulado = 0;

if ($qtdmeses==12)
{
   $valorprojetado = 'null';
}
else
{
	$valorprojetado =  (int) (($metaanual - $TotalGeral_G) / (12-$qtdmeses)); 
}
ForEach ($vetMensal as $anomes  => $vet)
{
    $quantidade = $vet['qtd'];  
	$horas      = $vet['hor'];  
	echo "<tr class=''>  ";
	$ordem = $ordem + 1;
	if($ordem % 2 == 0)
	{
	   $bgc   = " background:#F1F1F1; ";
	}
	else
	{
	  $bgc   = " background:#FFFFFF; ";
	}
	$mes         = substr($anomes,5,2);
	
	
	$textomes    = $vetMes[$mes];
	$mesano      = substr($anomes,5,2).'/'.substr($anomes,0,4).' - '.$textomes;
	
	$quantidadew = format_decimal($quantidade,0);
	
	$percw = format_decimal(($quantidade/$TotalGeral_G)*100,2);
	
	$legenda_y  .= " {$virgula} '{$textomes}' ";
	
	if ($ordem>$qtdmeses)
	{
	
	   $quantidadeat = $valorprojetado;
	   $valores_g2 .= $virgula.'null';
	   $valores_g5 .= $virgula.$quantidadeat;
	}
	else
	{
	   $quantidadeat = $quantidade;
	   $valores_g5 .= $virgula.'null';
	   $valores_g2 .= $virgula.$quantidadeat;
	    

	}
	$acumulado = $acumulado + $quantidadeat;
	$valores_g3 .= $virgula.$acumulado;
	$virgula     = ', ';

	
	$horasw      = format_decimal($horas,2);
	$horast      = $horast + $horas;
	echo "   <td class='cb_texto_abc_lin' style='{$bgc} text-align:left; padding-left:25px;'>$mesano</td> ";
	echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$quantidadew</td> ";
	//echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$horasw</td> ";
	echo "   <td class='cb_texto_abc_lin' style='{$bgc} padding-right:25px;'>$percw</td> ";
	echo "</tr>";
}

$valores_g4="";
$virgula="";
for ($tp = 1; $tp <= 12; $tp++) {
    if ($tp==12)
	{
	    $valores_g4 .= $virgula.$metaanual;
	}
	else
	{
	    $valores_g4 .= $virgula.'null';
	}
	$virgula=", ";
}
$bgc   = " background:#2C3E50; color:#FFFFFF; ";
echo "<tr class=''>  ";
$unidade    = "TOTAL GERAL";
$quantidade = format_decimal($TotalGeral_G,0);
$horast     = format_decimal($horas,2);
$percw      = '100,00';
echo "   <td class='cb_texto_abc_lin' style='{$bgc} text-align:right; padding-left:5px;'>$unidade</td> ";
echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$quantidade</td> ";
//echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$horast</td> ";
echo "   <td class='cb_texto_abc_lin' style='{$bgc}'>$percw</td> ";
echo "</tr>";

echo "</table> ";



//echo "<br />";


echo "<div>";
echo  "<div id='graficos' style='text-align:center; width:100%; height:30px; background:#2C3E50; color:#FFFFFF;'>";
echo  "Gráficos";
echo  "</div>";





$quantidadet=9;
$altura = $quantidadet * 40;
$onclick = " onclick='return AbreFechaM7(0);'; ";
$title = " title='Clique aqui para exibir ou esconder o Gráfico' ";
echo  "<div id='grafico0M7' {$onclick} style=''>";
echo  "<div id='grafico0tM7' {$title} style='padding-left:5px; border-bottom:1px solid #FFFFFF; cursor:pointer; float:left; width:100%; height:30px; background:#2A5696; color:#FFFFFF;'>";
echo  "1 - Público Sebrae";
echo  "</div>";
echo  "<div id='container_grafico0M7' style='display:none; float:left; width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696;'></div>";
echo "</div>";

echo "<br />";













$quantidadet=9;
$altura = $quantidadet * 40;




$onclick = " onclick='return AbreFechaM7(1);'; ";
$title = " title='Clique aqui para exibir ou esconder o Gráfico' ";
echo  "<div id='grafico1M7' {$onclick} style=''>";
echo  "<div id='grafico1tM7' {$title} style='padding-left:5px; border-bottom:1px solid #FFFFFF; cursor:pointer; float:left; width:100%; height:30px; background:#2A5696; color:#FFFFFF;'>";
echo  "2 - Atendimentos - Curva ABC";
echo  "</div>";
echo  "<div id='container_grafico1M7' style='display:none; float:left; width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696;'></div>";
echo "</div>";

echo "<br />";


$quantidadet=12;
$altura = ($quantidadet * 40)+300;

$onclick = " onclick='return AbreFechaM7(3);'; ";
echo  "<div id='grafico3M7' {$onclick} style=''>";
echo  "<div id='grafico3tM7' {$title} style='padding-left:5px; border-bottom:1px solid #FFFFFF; cursor:pointer; float:left; width:100%; height:30px; background:#2A5696; color:#FFFFFF;'>";
echo  "3 - Unidades Regionais - Atendimento por Instrumento";
echo  "</div>";
echo  "<div id='container_grafico3M7' style='display:none; float:left; width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696; border-bottom:3px solid #2A5696;'></div>";
echo "</div>";


$onclick = " onclick='return AbreFechaM7(2);'; ";
echo  "<div id='grafico2M7' {$onclick} style=''>";
echo  "<div id='grafico2tM7' {$title} style='padding-left:5px; border-bottom:1px solid #FFFFFF; cursor:pointer; float:left; width:100%; height:30px; background:#2A5696; color:#FFFFFF;'>";
echo  "4 - Atendimentos Mensal - Quantidade";
echo  "</div>";
echo  "<div id='container_grafico2M7' style='display:none; float:left; width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696; border-bottom:3px solid #2A5696;'></div>";
echo  "</div>";



$onclick = " onclick='return AbreFechaM7(4);'; ";
echo  "<div id='grafico4M7' {$onclick} style=''>";
echo  "<div id='grafico4tM7' {$title} style='padding-left:5px; border-bottom:1px solid #FFFFFF; cursor:pointer; float:left; width:100%; height:30px; background:#2A5696; color:#FFFFFF;'>";
echo  "5 - Atendimentos por Instrumento - Geral";
echo  "</div>";
echo  "<div id='container_grafico4M7' style='display:none; float:left; width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696; border-bottom:3px solid #2A5696;'></div>";
echo  "</div>";


echo "</div>";



echo "<br /><br /><br />";


//p($vetPAInstrumentosG);

$tituloI   ="Unidades Regionais<br />Atendimentos por Instrumento";
$legenda_xI = "";
$valores_gI = "";
$virgula   = '';
ForEach ($vetInstrumentosG as $idt_instrumento => $descricao) {
   $legenda_xI .= $virgula."'{$descricao}'";
   $valores_gI .= $virgula."30";
   $virgula     = ', ';
}


$tituloI4   ="Atendimentos por Instrumento<br />Geral";

$valores_gI4 = "";
$virgula     = '';
$vetPAInstrumentosG4 = Array();
ForEach ($vetPAInstrumentosG as $idt_ponto_atendimento => $vetInstrumentos) {
	ForEach ($vetInstrumentos as $idt_instrumento => $quantidade) {
		if ($quantidade=='')
		{
			$quantidade='0';
		}
		$vetPAInstrumentosG4[$idt_instrumento]=$vetPAInstrumentosG4[$idt_instrumento]+$quantidade;
	}	
}

ForEach ($vetPAInstrumentosG4 as $idt_instrumento => $quantidade) {
	$valores_gI4 .= $virgula.$quantidade;
	$virgula        = ', ';
}



//////////////// $vetEst

$tituloI5   ="Público do Sebrae";
$valores_gI5 = "";
$legenda_x5  = "";
$virgula     = '';
$vetEst5 = Array();
//
//  p($vetEst);
//
    $vetMeta = $vetEst['porte_meta'];
	$vetMetaF=$vetMeta['F'];
	$vetMetaJ=$vetMeta['J'];
	ForEach ($vetMetaF as $porte => $vetqtd) {
	    $quantidade = $vetqtd['qtd'];
		$horas      = $vetqtd['hor'];
		if ($quantidade=='')
		{
			$quantidade='0';
		}
		$vetEst5['F'][$porte]=$vetEst5['F'][$porte]+$quantidade;
	}
	
	ForEach ($vetMetaJ as $porte => $vetqtd) {
	    $quantidade = $vetqtd['qtd'];
		$horas      = $vetqtd['hor'];
		if ($quantidade=='')
		{
			$quantidade='0';
		}
		$vetEst5['J'][$porte]=$vetEst5['J'][$porte]+$quantidade;
	}	
$vetLeg=Array();
$vetLeg['PE'] ='Potencial Empresário';
$vetLeg['PEE']='Potencial Empreendedor';
$vetLeg['MEI']='Microemprrendedor Individual';
$vetLeg['ME'] ='Microempresa';
$vetLeg['EPP']='Empresa de Pequeno Porte';

ForEach ($vetEst5 as $tipo_pessoa => $vetPorte) {
    ForEach ($vetPorte as $porte => $quantidade) {
		$valores_gI5 .= $virgula.$quantidade;
		$leg          = $vetLeg[$porte];
		$leg          = $porte;
		$legenda_x5  .= " {$virgula} '{$leg}' ";  
		$virgula        = ', ';
	}
}
if (count($vetEst5)==0)
{
    ForEach ($vetLeg as $sigla => $porte) {
		$valores_gI5 .= $virgula.'null';
		$leg          = $porte;
		$legenda_x5  .= " {$virgula} '{$leg}' ";  
		$virgula        = ', ';
	}


}
//echo " legenda = ".$legenda_x5."<br />";
//echo " valores = ".$valores_gI5."<br />";

?>



<script type="text/javascript" >

//    var idt_organizacao = <?php echo $idt_organizacao; ?>;
var chartM7;
var chart2M7;
var chart3M7;
var chart4M7;
$(document).ready(function() {

        FechaTodosPA();

    chartM7 = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico0M7',
            type: 'bar'
        },
        title: {
		    margin:		    50,
            text: '<?php echo $tituloI5 ?>'
        },
        xAxis: {
			categories: [<?php echo $legenda_x5 ?>],
			
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			//max: 100,
			gridLineWidth: 1,
			//reversed: true,
            title: {
                text: '(em Quantidade de Atendimentos)',
				
                align: 'high'
            },
            labels: {
			    enabled: true,
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
		    enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
		{
            name: '<?php echo 'Quantidade de Atendimentos'; ?>',
			data: [<?php echo $valores_gI5 ?>],
			color: 'rgba(255, 0, 0, 1)'
        }
		]
    });
	
	
	
	
    chartM7 = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico1M7',
            type: 'bar'
        },
        title: {
		    margin:		    50,
            text: '<?php echo $titulo ?>'
        },
        xAxis: {
			categories: [<?php echo $legenda_x ?>],
			
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			//max: 100,
			gridLineWidth: 1,
			//reversed: true,
            title: {
                text: '(em Quantidade de Atendimentos)',
				
                align: 'high'
            },
            labels: {
			    enabled: true,
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
		    enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [
		{
            name: '<?php echo 'Quantidade de Atendimentos'; ?>',
			data: [<?php echo $valores_g1 ?>],
			color: 'rgba(255, 0, 0, 1)'
        }
		]
    });

	
	/////////////////// grafico 2
	 chart2M7 = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico2M7',
            type: 'line'
        },
        title: {
		    margin:		    50,
            useHTML:		    true,
            text: '<?php echo $titulo2 ?>'
        },
        // subtitle: {
        //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        // },
        xAxis: {
            //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
			categories: [<?php echo $legenda_y ?>],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			// max: 100,
			gridLineWidth: 1,
            title: {
                text: '(em quantidade)',
                align: 'high'
            },
            labels: {
			    enabled: true,
				//reversed: true,
                overflow: 'justify'
            }
			
			

			
			
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            },
			column: {
                borderWidth: 0,
				pointWidth: 15
                
            }
        },
        legend: {
		//reversed: true,
		   // enabled: false,
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: +80,
            y: 40,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      series: [ 
	   {
	        type: 'column',
            name: '<?php echo 'Realizado - Quantidade Mensal' ?>',
    		data: [<?php echo $valores_g2 ?>],
			color: 'rgba(255, 0, 0, 1)',
			
			dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#000000',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5, // 10 pixels down from the top
                style: {
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
			
			
			
        },
		
		
		{
            type: 'column',		
            name: '<?php echo 'Projetado - Quantidade Acumulada ' ?>',
    		data: [<?php echo $valores_g5 ?>],
			color: 'rgba(196, 196, 196, 1)',
			
			dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#000000',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5,
                style: {
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
			
			
        },
		
		{
            type: 'column',		
            name: '<?php echo 'Realizado - Quantidade Acumulada' ?>',
    		data: [<?php echo $valores_g3 ?>],
			color: 'rgba(0, 0, 255, 0.9)',
			
			dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5,
                style: {
				    
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
			
			
        },
		
        {
            type: 'line',		
            name: '<?php echo 'Quantidade Acumulada' ?>',
    		data: [<?php echo $valores_g3 ?>],
			color: 'rgba(196, 196, 196, 1)',
			
			dataLabels: {
                enabled: false,
               // rotation: -90,
			    rotation: +90,
                color: '#000000',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5,
                style: {
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
		
		{
            type: 'column',		
            name: '<?php echo 'Meta Anual - Quantidade' ?>',
    		data: [<?php echo $valores_g4 ?>],
			color: 'rgba(255, 0, 0, 1)',
			
			dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5,
                style: {
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
			
			
        }
		
		]
    });
	// fim do grafico 2
	// grafico 3
	
	 chart3M7 = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico3M7',
			marginBottom: 300,
            type: 'line'
        },
        title: {
		    margin:		    50,
            useHTML:		    true,
            text: '<?php echo $tituloI ?>'
        },
        // subtitle: {
        //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        // },
        xAxis: {
            //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
			categories: [<?php echo $legenda_xI ?>],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			// max: 100,
			gridLineWidth: 1,
            title: {
                text: '(em quantidade)',
                align: 'high'
            },
            labels: {
			    enabled: true,
				//reversed: true,
                overflow: 'justify'
            }
			
			

			
			
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            },
			column: {
                borderWidth: 0,
				pointWidth: 15
                
            }
        },
        legend: {
		//reversed: true,
		   // enabled: false,
            layout: 'vertical',
          //  align: 'right',
          //  verticalAlign: 'top',
          //  x: -5,
            y: -50,
			
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
      series: [ 
	   /*
        {
            type: 'line',		
            name: '<?php echo 'PA1' ?>',
    		data: [<?php echo $valores_gI ?>],
			color: 'rgba(196, 196, 196, 1)',
			
			dataLabels: {
                enabled: false,
               // rotation: -90,
			    rotation: +90,
                color: '#000000',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 1, // 10 pixels down from the top
				x: 5,
                style: {
                    fontSize: '12px',
					fontWeight: 'bold',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }
		*/
<?php		
	
$qtdg  = count($vetorPANome);
$ordem = 0;
ForEach ($vetPAInstrumentosG as $idt_ponto_atendimento => $vetInstrumentos) {
	$valores_serie  = "";
	$virgula     = '';
	$nome_serie  = $vetorPANome[$idt_ponto_atendimento];
	ForEach ($vetInstrumentos as $idt_instrumento => $quantidade) {
		if ($quantidade=='')
		{
			$quantidade='0';
		}
		$valores_serie .= $virgula.$quantidade;
		$virgula        = ', ';
	}	
	
	$ordem = $ordem + 1;
	$color1w = "0";
	$color2w = "0";
	$color3w = "0";
	switch ($ordem)
	{
		case 1:
            $color1w = "255";
			$color2w = "0";
			$color3w = "0";
		break;
		case 2:
            $color1w = "0";
			$color2w = "255";
			$color3w = "0";
		break;
		case 3:
            $color1w = "0";
			$color2w = "0";
			$color3w = "255";
		break;
		case 4:
            $color1w = "196";
			$color2w = "196";
			$color3w = "196";
		break;
		case 5:
            $color1w = "0";
			$color2w = "0";
			$color3w = "0";
		break;
		case 6:
            $color1w = "100";
			$color2w = "0";
			$color3w = "0";
		break;
        case 7:
            $color1w = "0";
			$color2w = "100";
			$color3w = "0";
		break;
		case 8:
            $color1w = "0";
			$color2w = "0";
			$color3w = "100";
		break;
		case 9:
            $color1w = "200";
			$color2w = "100";
			$color3w = "0";
		break;
		case 10:
		    $color1w = "100";
			$color2w = "200";
			$color3w = "0";
		break;
    }
	echo " {  ";
	echo "     type: 'line',		 ";
	echo "     name: '{$nome_serie}',   ";
	echo " 	data: [{$valores_serie}],  ";
	echo " 	color: 'rgba({$color1w}, {$color2w}, {$color3w}, 1)',  ";
	echo " 	dataLabels: {  ";
	echo "         enabled: false, ";
	//echo "        // rotation: -90, ";
	echo " 	    rotation: +90, ";
	echo "         color: '#000000', ";
	echo "         align: 'right', ";
	echo "         format: '{point.y:.1f}',  ";
	echo "         y: 1,  ";
	echo " 		x: 5, ";
	echo "         style: { ";
	echo "             fontSize: '12px', ";
	echo " 			fontWeight: 'bold', ";
	echo "             fontFamily: 'Verdana, sans-serif' ";
	echo "         } ";
	echo "   } ";
	if ($qtdg == $ordem)
	{
		echo " } ";
	}
	else
	{
		echo " }, ";
	}
}

?>		
		]
    });
	

	// fim do grafico 3

	


	// grafico 4
	
	 chart4M7 = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico4M7',
			// marginBottom: 300,
            type: 'bar'
        },
        title: {
		    margin:		    50,
            useHTML:		    true,
            text: '<?php echo $tituloI4 ?>'
        },
        // subtitle: {
        //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        // },
        xAxis: {
            //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
			categories: [<?php echo $legenda_xI ?>],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			// max: 100,
			gridLineWidth: 1,
            title: {
                text: '(em quantidade)',
                align: 'high'
            },
            labels: {
			    enabled: true,
				// reversed: true,
                overflow: 'justify'
            }
			
			

			
			
        },
        tooltip: {
            valueSuffix: ' '
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            },
			column: {
                borderWidth: 0,
				pointWidth: 15
                
            }
        },
        legend: {
            enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true        },
        credits: {
            enabled: false
        },
      series: [ 
        {
            //type: 'line',		
            name: '<?php echo 'Quantidade por Instrumento' ?>',
    		data: [<?php echo $valores_gI4 ?>],
			color: 'rgba(255, 0, 0, 1)'
			
			
        }
		]
    });
	

	// fim do grafico 4

	
	
	
});

/*

function DetalhaPA(idt_ponto_atendimento)
{
    var descricao_pa = '';
    objd=document.getElementById(idt_ponto_atendimento);
    if (objd != null) {
       descricao_paw = String(objd.innerHTML);
	   descricao_pa = descricao_paw.replace(/&nbsp;/gi,'');
    }
    //alert('Detalha PA'+idt_ponto_atendimento+' - ' +descricao_pa);

    var parww='&idt_ponto_atendimento='+idt_ponto_atendimento+'&pa='+descricao_pa;
    var href='conteudo_detalha_pa.php?prefixo=inc&menu=detalha_lista_atendimento_pa'+parww;
    var  left   = 0;
    var  top    = 0;
    var  height = $(window).height();
    var  width  = $(window).width();
    top    = 200;
    left   = 300;
	
	top    = 100;
    left   = 25;
	
    width  = width  - 50;
    height = height - 50;
	
	
    var titulo = "<div style='width:700px; display:block; text-align:center; '>Detalha PA - "+descricao_pa+"</div>";
    showPopWin(href, titulo , width, height, close_DetalhaPA);
    return false;
}

function close_DetalhaPA(returnVal) {
    // alert(returnVal);
    // var href = "conteudo_tipologia_medicao.php?prefixo=inc&menu=mapa_medicao&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_empreendimento="+idt_empreendimento;
    // self.location =  href;

}

function AbreFechaUnidade(idt_ur)
{
//    alert('Unidade Regional'+idt_ur);
	 var classew = 'pa'+idt_ur;
	 $('.'+classew).each(function () {
        $(this).toggle(); 
    });
   
	
	
	
	
	return false;
}

function AbreTodosPA()
{
	 var classew = 'pa';
	 $('.'+classew).each(function () {
        $(this).show(); 
    });
	return false;
}

function FechaTodosPA()
{
	 var classew = 'pa';
	 $('.'+classew).each(function () {
        $(this).hide(); 
    });
	return false;
}

function AbreParametros()
{
//	$('#parametros').toggle();
    $('.parametros_visualizacao').each(function () {
        $(this).toggle();
    });
	return false;
}

function FechaParametros()
{
	$('#parametros').hide(); 
	return false;
}

function Parametros_ocultar_ur()
{
	 var classew = 'ur';
	 $('.'+classew).each(function () {
        $(this).toggle();  
    });
	return false;
}

function Parametros_ocultar_pa()
{
	 var classew = 'pa';
	 $('.'+classew).each(function () {
        $(this).toggle();  
    });
	return false;
}
*/
function AbreFechaM7(op)
{
    var id = "#container_grafico"+op+'M7';
    $(id).toggle();  
	return false;
}

/*





    function ChamaDepto(codigo_secao)
    {
        alert(codigo_secao);
        //alert(' gggg '+em_idt);
        var opcao = "A";
        var parww = '&codigo_secao=' + idt_organizacao + '&codigo_secao=' + idt_organizacao;
        var href = 'conteudo_matriz_pessoas.php?prefixo=inc&menu=matriz_lista_pessoas&print=n&titulo_rel=Pessoas Associadas a seção ' + codigo_secao;
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();
        top = 100;
        left = 150;
        width = width - 200;
        height = height - 350;
        var titulo = "<div style='width:700px; display:block; text-align:center; '>Pessoas Associadas a seção " + codigo_secao + "</div>";
        showPopWin(href, titulo, width, height, close_ChamaDepto, true, top, left);
        //***

        return false;
    }

//Esmeraldo
    function close_ChamaDepto(returnVal) {
        //alert(returnVal);
        //var href = "conteudo_tipologia.php?prefixo=inc&menu=tipologia_medicao&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_empreendimento="+idt_empreendimento;
        //self.location =  href;

    }
    function ChamaDeptoCargo(codigo_secao, cargo)
    {
        alert(codigo_secao + ' ====  ' + cargo);

        return false;
    }
	
*/	
	
</script>
