
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
        font-size:12px;
		text-align:left;
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





</style>


<?php

function CriarDimensoesArea(&$vetDimensao) {
    $kokw = 0;
	$vetEdital     = Array();
	$vetPrograma   = Array();
    $vetArea       = Array();
	$vetArea_gc    = Array();
    
    //Programas
    $sqll = 'select ';
    $sqll .= '  gec_p.* ';
    $sqll .= '  from  '.db_pir_gec.'gec_programa gec_p ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt       = $rowl['idt'];
        $codigo    = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo     = $rowl['ativo'];
        $vetPrograma[$idt] = $rowl;
    }
    // Editais
    $sql  = "select idt_editalsgc, gec_ed.idt as gec_ed_idt ,gec_epe.idt as gec_epe_idt, gec_epe.idt_etapa as gec_epe_idt_etapa ";    $sql .= "  from ".db_pir_gec."gec_edital gec_ed ";
    $sql .= "  inner join gec_edital_processo gec_ep on gec_ep.idt_edital = gec_ed.idt ";
    //$sql .= "  inner join gec_edital_etapas   gec_epe on gec_epe.idt_processo = gec_ep.idt and gec_epe.idt_etapa = 1 ";
    $sql .= "  inner join ".db_pir_gec."gec_edital_etapas   gec_epe on gec_epe.idt_processo = gec_ep.idt  ";
    $rs = execsql($sql);
    ForEach ($rs->data as $row)
    {
       $gec_epe_idt_etapa = $row['gec_epe_idt_etapa'];
       if  ($gec_epe_idt_etapa==1)
       {   // inscri��o
           $idt_editalsgc  = $row['idt_editalsgc'];
           $gec_epe_idt    = $row['gec_epe_idt'];
           $gec_ed_idt     = $row['gec_ed_idt'];
           $vetEdital[$idt_editalsgc]=$gec_ed_idt;
       }
       if  ($gec_epe_idt_etapa==2)
       {   // habilita��o
           $gec_epe_idt    = $row['gec_epe_idt'];
           $vetEtapaEdital2[$idt_editalsgc]=$gec_epe_idt;
       }
       if  ($gec_epe_idt_etapa==3)
       {   // Credenciamento
           $gec_epe_idt    = $row['gec_epe_idt'];
           $vetEtapaEdital3[$idt_editalsgc]=$gec_epe_idt;
       }

    }
    $sqll = 'select ';
    $sqll .= '  gec_ac.* ';
    $sqll .= '  from  gec_area_conhecimento gec_ac ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt       = $rowl['idt'];
        $codigo    = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo     = $rowl['ativo'];
        $vetArea[$idt] = $rowl;
    }
    $sqll = 'select ';
    $sqll .= '  gec_ac.* ';
    $sqll .= '  from  ".db_pir_gec."gec_area_conhecimento gec_ac ';
	$sqll .= '  where idt_programa = 2 ';
    $sqll .= '  order by codigo ';
    $rsl = execsql($sqll);
    ForEach ($rsl->data as $rowl) {
        $idt       = $rowl['idt'];
        $codigo    = $rowl['codigo'];
        $descricao = $rowl['descricao'];
        $ativo     = $rowl['ativo'];
        $vetArea_gc[$idt] = $rowl;
    }
    $vetDimensao['Edital']     = $vetEdital;
    $vetDimensao['Programa']   = $vetPrograma;
	$vetDimensao['Area']       = $vetArea;
	$vetDimensao['Area_gc']    = $vetArea_gc;
    return $kokw;
}

function QuantitativosArea($condicao, &$vetArea_gc)
{
    $kokw = 0;
	$sql  = 'select ';
	$sql .= '  gec_e.idt ';
	$sql .= '  from '.db_pir_gec.'gec_entidade gec_e   ';
	$sql .= '  where  ';
	$sql .= '     gec_e.reg_situacao         = '.aspa('A');
	//-- $sql .= '     and    gec_e.aprovado      = '.aspa('S');
	$sql .= '     and    gec_e.tipo_entidade = '.aspa('P');
	$sql .= '     and    gec_e.credenciado   = '.aspa('S');
	$rs = execsql($sql);
	//p($sql);
    ForEach ($rs->data as $row)
    {
        $idt_entidade  = $row['idt'];
  	    $sqlt  = 'select ';
	    $sqlt .= '  gec_ar.* ';
		$sqlt .= '  from '.db_pir_gec.'gec_entidade_area_conhecimento gec_ar   ';
		$sqlt .= '  where  ';
		$sqlt .= '     gec_ar.idt_entidade          = '.null($idt_entidade);
		$rst = execsql($sqlt);
		ForEach ($rst->data as $rowt)
		{
			$gec_ar_idt    = $rowt['idt_area_conhecimento'];
			$idt_natureza  = $rowt['idt_natureza'];
			//echo " ======= {$gec_ar_idt} ----- {$idt_natureza} <br />";
			if ($idt_natureza==2)
			{
			    $vetArea_gc[$gec_ar_idt]['cons']=$vetArea_gc[$gec_ar_idt]['cons']+1;
			}
            else
            {			
			    $vetArea_gc[$gec_ar_idt]['inst']=$vetArea_gc[$gec_ar_idt]['inst']+1;
			}	
		}
    }
	$kokw = 1;
    return $kokw;
}

function QuantitativosAtendimento($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, &$vetDimensao, &$vetDimensaoTotal, &$TotalGeral_G, &$vetDimensaoInstrumento, &$vetDimensaoTempoI, &$vetDimensaoTempoP) {
    $condicao    = " ano = '2016' and (situacao = 'Finalizado' or situacao = 'Finalizado em Altera��o') and idt_evento is null ";
    $vetDimensao = Array();
	
	$vetDimensaoTotal = Array();
	
    $sql = "select ";
    $sql .= "   count(*) as quantidade, sum(horas_atendimento) as horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento ";
    $sql .= " from grc_atendimento grc_a ";
	$sql .= " inner join grc_competencia grc_c on grc_c.idt =  grc_a.idt_competencia";
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
		{   // Instrumento � de Balc�o
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



$vetDimensao           = Array();
$ret = CriarDimensoesArea($vetDimensao);
$vetEdital   = $vetDimensao['Edital'];
$vetPrograma = $vetDimensao['Programa'];
$vetArea     = $vetDimensao['Area'];
$vetArea_gc  = $vetDimensao['Area_gc'];


//p($vetEdital);  
//p($vetPrograma);  
//p($vetArea);  
//p($vetArea_gc);  

$condicao       = ""; // todos os produtos
QuantitativosArea($condicao, $vetArea_gc);

//p($vetArea_gc);  

echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td class='cb_texto_cab' style=''>�REA</td> ";
echo "   <td class='cb_texto_cab' style=''>SUBAREA</td> ";
echo "   <td class='cb_texto_cab' style=''>ESPECIALIDADE</td> ";
echo "   <td class='cb_texto_cab' style=''>CONS.</td> ";
echo "   <td class='cb_texto_cab' style=''>INST.</td> ";
echo "</tr>";
ForEach ($vetArea_gc as $idt => $row) {
    $idt          = $row['idt'];
    $codigo       = $row['codigo'];
    $descricao_n1 = $row['descricao_n1'];
	$descricao_n2 = $row['descricao_n2'];
	$descricao_n3 = $row['descricao_n3'];
    $ativo        = $row['ativo'];
	$tipo         = $row['tipo'];
	$classw='cb_texto';
	if ($tipo=='S')
	{
	    $classw='cb_texto_s';
	}
	$descricao_n1i = '&nbsp;';
	if ($descricao_n1w != $descricao_n1)
	{
	    $descricao_n1w = $descricao_n1; 
	    $descricao_n1i = $descricao_n1w;
		$descricao_n2w = $descricao_n2; 
		$descricao_n2i = $descricao_n2w;
	}
	else
	{
	    $descricao_n2i = '&nbsp;';
		if ($descricao_n1w.$descricao_n2w != $descricao_n1.$descricao_n2)
		{
			$descricao_n2w = $descricao_n2; 
			$descricao_n2i = $descricao_n2w;
		}
	
	}
	
	
	
	//$brancos="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$onclick  = "";
	$hint="";
	$cursor="";
	if ($tipo == 'A')
	{
		$onclick = " onclick = 'return DetalhaArea($idt); '";
		$hint    = "Clique aqui para Detalhar";
		$cursor  = "cursor:pointer;";
	}
	echo "<tr class=''>  ";
    echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$descricao_n1i}</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$descricao_n2i}</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw}' style='{$cursor}' >{$brancos}{$descricao_n3}</td> ";
	
	$cons = format_decimal($vetArea_gc[$idt]['cons'],0);
	$inst = format_decimal($vetArea_gc[$idt]['inst'],0);
	
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw} cb_inteiro' style='{$cursor}' >{$brancos}$cons</td> ";
	echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}' class='{$classw} cb_inteiro' style='{$cursor}' >{$brancos}$inst</td> ";
    echo "</tr>  ";
	
}
echo "</table>";

echo "<br />";
echo "<br />";

/*

$condicao       = ""; // todos os produtos
// QuantitativosAtendimento($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP);
$vetAtendimentoQtd = $vetDimensao;
  
// Barra de Ferramentas
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";

$onclickA = " onclick = 'return AbreParametros();' ";
$hint     = "title = 'Clique aqui para parametrizar a Visualiza��o das linhas da Matriz'";
echo "   <td {$onclickA} {$hint} class='cb_barra_ferramenta' style=''>Visualiza��o</td> ";

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


//
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
$data_inicio='01/01/2016'; 
$data_final ='31/12/2016'; 
echo "   <td colspan='11' class='cb_texto_tit' style='' >Per�odo de {$data_inicio} at� {$data_final}</td> ";
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
echo "   <td class='cb_texto_int_subcab' style=''>M�DIO</td> ";

echo "</tr>";


$tempo_total_G = 0;
ForEach ($vetPontoAtendimento as $idt_ponto_atendimento => $row) {
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

echo "<br /><br />";
*/

?>



<script type="text/javascript" >

//    var idt_organizacao = <?php echo $idt_organizacao; ?>;



function DetalhaArea(idt_area)
{
    var descricao_area = "pegar descricao da �rea";
    //alert('Detalha Area'+idt_area);

    var parww='&idt_area='+idt_area+'&area='+descricao_area;
    var href='conteudo_detalha_area.php?prefixo=inc&menu=detalha_area_conhecimento'+parww;
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
	
	
    var titulo = "<div style='width:700px; display:block; text-align:center; '>Detalha �REA - "+idt_area+"</div>";
    showPopWin(href, titulo , width, height, close_DetalhaArea);
    return false;
}

function close_DetalhaArea(returnVal) {
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
	$('#parametros').show(); 
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



/*





    function ChamaDepto(codigo_secao)
    {
        alert(codigo_secao);
        //alert(' gggg '+em_idt);
        var opcao = "A";
        var parww = '&codigo_secao=' + idt_organizacao + '&codigo_secao=' + idt_organizacao;
        var href = 'conteudo_matriz_pessoas.php?prefixo=inc&menu=matriz_lista_pessoas&print=n&titulo_rel=Pessoas Associadas a se��o ' + codigo_secao;
        var left = 0;
        var top = 0;
        var height = $(window).height();
        var width = $(window).width();
        top = 100;
        left = 150;
        width = width - 200;
        height = height - 350;
        var titulo = "<div style='width:700px; display:block; text-align:center; '>Pessoas Associadas a se��o " + codigo_secao + "</div>";
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
