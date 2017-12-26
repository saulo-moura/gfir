<style>
#filtro_classificacao {
     display:block;
}
#barra_menu {
     display:none;
}
#filtro {
     width:50%;
}




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
Require_Once('relatorio/lupe_generico.php');
Require_Once('style.php');



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
    $sql  = "select idt_editalsgc, gec_ed.idt as gec_ed_idt ,gec_epe.idt as gec_epe_idt, gec_epe.idt_etapa as gec_epe_idt_etapa ";    
	$sql .= "  from ".db_pir_gec."gec_edital gec_ed ";
    $sql .= "  inner join ".db_pir_gec."gec_edital_processo gec_ep on gec_ep.idt_edital = gec_ed.idt ";
    //$sql .= "  inner join gec_edital_etapas   gec_epe on gec_epe.idt_processo = gec_ep.idt and gec_epe.idt_etapa = 1 ";
    $sql .= "  inner join ".db_pir_gec."gec_edital_etapas   gec_epe on gec_epe.idt_processo = gec_ep.idt  ";
    $rs = execsql($sql);
    ForEach ($rs->data as $row)
    {
       $gec_epe_idt_etapa = $row['gec_epe_idt_etapa'];
       if  ($gec_epe_idt_etapa==1)
       {   // inscrição
           $idt_editalsgc  = $row['idt_editalsgc'];
           $gec_epe_idt    = $row['gec_epe_idt'];
           $gec_ed_idt     = $row['gec_ed_idt'];
           $vetEdital[$idt_editalsgc]=$gec_ed_idt;
       }
       if  ($gec_epe_idt_etapa==2)
       {   // habilitação
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
    $sqll .= '  from  '.db_pir_gec.'gec_area_conhecimento gec_ac ';
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
    $sqll .= '  from  '.db_pir_gec.'gec_area_conhecimento gec_ac ';
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
	//$sql .= '     and    gec_e.tipo_entidade = '.aspa('P');
	//$sql .= '     and    gec_e.credenciado   = '.aspa('S');
	
	$sql .= '     and    gec_e.tipo_entidade     = '.aspa('O');
	$sql .= '     and    gec_e.credenciado_sgtec = '.aspa('S');
	
	$rs = execsql($sql);
	//p($sql);
    ForEach ($rs->data as $row)
    {
        $idt_entidade  = $row['idt'];
		
		$sqlt  = 'select ';
	    $sqlt .= '  gec_ep.*, gec_p.codigo as gec_p_codigo, gec_p.descricao as gec_p_descricao   ';
		$sqlt .= '  from '.db_pir_gec.'gec_entidade_produto gec_ep   ';
		$sqlt .= '  inner join grc_produto gec_p on gec_p.idt =   gec_ep.idt_produto ';
		$sqlt .= '  where  ';
		$sqlt .= '     gec_ep.idt_entidade          = '.null($idt_entidade);
		$rst = execsql($sqlt);
		ForEach ($rst->data as $rowt)
		{
			$gec_ar_idt      = $rowt['idt_produto'];
			$gec_p_descricao = $rowt['gec_p_descricao']; 
			$gec_p_codigo    = $rowt['gec_p_codigo']; 
			$vetArea_gc[$gec_ar_idt]['cons']=$vetArea_gc[$gec_ar_idt]['cons']+1;
			$row=Array();
			$row['idt']=$gec_ar_idt; 
			$row['codigo']=$gec_p_codigo; 
			$row['descricao_n1']=$gec_p_descricao; 
			$row['descricao_n2']=$gec_p_descricao; 
			$row['descricao_n3']=$gec_p_descricao; 
			$vetArea_gc[$gec_ar_idt]['row']=$row;
			
    
			
			
		}
		
		
		
		/*
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
		*/
    }
	$kokw = 1;
    return $kokw;
}

function QuantitativosAtendimento($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, &$vetDimensao, &$vetDimensaoTotal, &$TotalGeral_G, &$vetDimensaoInstrumento, &$vetDimensaoTempoI, &$vetDimensaoTempoP) {
    $condicao    = " ano = '2016' and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is null ";
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
echo "   <td class='cb_texto_cab' style=''>ÁREA</td> ";
echo "   <td class='cb_texto_cab' style=''>SUBAREA</td> ";
echo "   <td class='cb_texto_cab' style=''>ESPECIALIDADE</td> ";
echo "   <td class='cb_texto_cab' style=''>CONS.</td> ";
echo "   <td class='cb_texto_cab' style=''>INST.</td> ";
echo "</tr>";

p($vetArea_gc);

ForEach ($vetArea_gc as $idt => $rowx) {
    $row = $rowx['row'];
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



?>
<script type="text/javascript">
    $(document).ready(function () {
    }
</script>

