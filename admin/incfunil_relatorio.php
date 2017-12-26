<style>
.atende_tb{

}
.atende_gc{
   background:#ECF0F1;
   color:#000000;
   xborder-bottom:1px solid #000000;
   padding:5px;
}
.atende_gc_linha{
   background:#FFFFFF;
   color:#000000;
   xborder-bottom:1px solid #000000;
   padding:5px;
}


.atende_gc_s{

   background:#FFFFFF;
   color:#000000;
   border-bottom:1px solid #000000;
   padding:5px;
   text-align:center;
}
.atende_gc_linha_s1{
   background:#ECF0F1;
   color:#000000;
   padding:5px;
   text-align:center;
}

.atende_gc_linha_s{
   background:#FFFFFF;
   color:#000000;
   padding:5px;
   text-align:center;
}


div#topo {
   xxwidth:900px;
}
div#geral {
   xxwidth:900px;
}
table {
   width:100%;
}


.atende_gc_ti {
   xbackground:#ABBBBF;
   
   background:#C4C9CD;
   text-align:left;
   width:5%;

   color:#000000;
}
.atende_gc_li {
   background:#C4C9CD;
   text-align:left;
   width:45%;
   color:#FFFFFF;
}
.funil_imagem {
   xbackground: white url(imagens/funil.png) no-repeat center;
   xbackground: blue url(imagens/funil.png) no-repeat ;
   xwidth:100%;
   xheight:52em;
   xmargin-let:20px;
}
.lado_esq {
  background: red;
  width:100px;
  height:52em;
  border:1px solid blue;
  xleft: 30;
  xoverflow: auto;
  xpadding: 3em;
    xposition: absolute;
    xright: 0;
    xtext-align: center;
    xtop: 0;

}

.quebrapagina {
   page-break-before: always;
}
</style>
<?php


if ($_REQUEST['idt_atendimento'] == '')
 	$idt_atendimento = 'vazio';
else
	$idt_atendimento = $_REQUEST['idt_atendimento'];


$idt_unidade_regional_sel=$_GET['idt_unidade_regional'];

//echo " idt_unidade_regional=$idt_unidade_regional_sel <br>";
//p($_GET);

if ($_REQUEST['idt_projeto'] == '')
 	$idt_projeto = 'vazio';
else
	$idt_projeto = $_REQUEST['idt_projeto'];
	
//if ($_REQUEST['idt_acao'] == '')
// 	$idt_acao = 'vazio';
//else
	$idt_acao = $_REQUEST['idt_acao'];
//	echo " idt_acao = $idt_unidade_regional <br>";


//////////////////////////// verifica job
    $texto   = "";
	$caminho = "obj_file/funil/job_funil_Execucao.log";
	$fp      = fopen($caminho, "r"); 
	$texto = fread($fp, filesize ($caminho));
	fclose($fp);
    $vet       = explode("=",$texto);
	$status    = substr($vet[1],1,2);
	$vet       = explode("Protocolo:",$texto);
	$protocolo = substr($vet[1],0,16); 
	//
	$textohtml = str_replace(chr(13),'<br />',$texto);
	if ($status!='OK')
	{
	    echo "<div style='font-size:20px; font-weight: bold; background:#FF0000; color:#FFFFFF; padding:20px; text-align:center; '>";
		echo "Dados para Geração do Relatórios estão sendo preparados...<br /><br />";
		echo "Por favor, aguarde mais um pouco e volte a acessar.<br />";
		echo "</div>";
		
		
		$vetRetorno = Array();
        $ano_atual = Funil_parametro(1, $vetRetorno);
        $quantidade_g = 0;		
		$sqlt = "";
		$sqlt .= " select count(idt) as quantidade ";
		$sqlt .= " from grc_funil_{$ano_atual}_gestao_meta ";
		$rst = execsqlNomeCol($sqlt);
		if ($rst->rows == 0) {
		} else {
			foreach ($rst->data as $rowt) {
				$quantidade_g = $rowt['quantidade'];
			}
		}
		
		
		echo "<div style='font-size:20px; font-weight: bold; background:#F1F1F1; color:#000000; padding:20px; text-align:left; '>";
		echo "Andamento da Atualização dos dados.<br /><br />";
		echo "Protocolo:{$protocolo}<br /><br />";
		
		//
		echo "Total Gravados:{$quantidade_g}<br /><br />";
		//
		echo "{$textohtml}<br />";
		echo "</div>";

		
	    die();
	}
	
	
	






	$cor_ur ="#2F44CC";
	$cor_urw="#CCF5FF";
	$cor_prospects="#2FA833";
	$cor_prospects_perc="#3DEB3D";
	$cor_leads="#F24B29";
	$cor_leads_perc="#EBC2A7";
	$cor_total_perc="#EBD1D5";
	$cor_clientes="#F28B57";
	$cor_nps="#8A7A7D";
	$cor_clientes_sub="#EBD1D5";

	// METAS
	$vetRetorno=Array();
	$ano_base = Funil_parametro(1,$vetRetorno);
	
	
	
	
	//$ano_base = "2017";
	
	$tot_meta_prospects          = 0;
	$tot_meta_leads              = 0;
	$tot_meta_clientes           = 0;
	$tot_meta_net_promoter_score = 0;
	$wherecomple="";
	if ($idt_unidade_regional_sel > 0)
	{
        $wherecomple=" and idt_unidade_regional = ".null($idt_unidade_regional_sel);
	}
			
	
	$vetMetasFunil=Array();
	$sqlt  = " select ";
	$sqlt .= "   grc_fm.*, ";
	$sqlt .= "   sca_os.descricao as sca_os_descricao  ";
	$sqlt .= " from grc_funil_meta grc_fm ";
	$sqlt .= "   inner join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = grc_fm.idt_unidade_regional  ";
	$sqlt .= " where grc_fm.ano  = ".aspa($ano_base);
	$sqlt .= $wherecomple;
	$rst   = execsql($sqlt);
	if ($rst->rows==0)
	{
	
	}
	else
	{
	    $qtd_ele = 0; 
		foreach ($rst->data as $rowt) {
		    $sca_os_descricao     = $rowt['sca_os_descricao'];
			$idt_unidade_regional = $rowt['idt_unidade_regional'];
			$qtd_prospects        = $rowt['qtd_prospects'];
			$qtd_leads            = $rowt['qtd_leads'];
			$qtd_clientes         = $rowt['qtd_clientes'];
			$net_promoter_score   = $rowt['net_promoter_score'];
			$vetMetasFunil[$ano][$idt_unidade_regional]['prospects']          = $qtd_prospects;
			$vetMetasFunil[$ano][$idt_unidade_regional]['leads']              = $qtd_leads;
			$vetMetasFunil[$ano][$idt_unidade_regional]['clientes']           = $qtd_clientes;
			$vetMetasFunil[$ano][$idt_unidade_regional]['net_promoter_score'] = $net_promoter_score;
			$qtd_ele=$qtd_ele+1;
			$tot_meta_prospects          = $tot_meta_prospects+$qtd_prospects;
			$tot_meta_leads              = $tot_meta_leads+$qtd_leads;
			$tot_meta_clientes           = $tot_meta_clientes+$qtd_clientes;
			$tot_meta_net_promoter_score = $tot_meta_net_promoter_score+$net_promoter_score;
        }	
		$tot_meta_net_promoter_score = $tot_meta_net_promoter_score/$qtd_ele;
	}
	// totalizar realizado
	$sqlt  = " select ";
	$sqlt .= "   grc_fe.*, ";
	$sqlt .= "   sca_os.descricao as sca_os_descricao  ";
	$sqlt .= " from grc_funil_execucao grc_fe ";
	$sqlt .= "   left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = grc_fe.idt_unidade_regional  ";
	$sqlt .= " where grc_fe.ano  = ".aspa($ano_base);
	$sqlt .= $wherecomple;
	$rst   = execsql($sqlt);
	if ($rst->rows==0)
	{
	
	}
	else
	{
	    $tot_prospects=0;
		$tot_leads=0;
		$tot_sem_avaliacao=0;
		$tot_detrators=0;
		$tot_neutros=0;
		$tot_promotores=0;
		$tot_clientes=0;
		
	    $qtd_ele = 0;
		foreach ($rst->data as $rowt) {
		    $idt_unidade_regional = $rowt['idt_unidade_regional'];
		    $sca_os_descricao   = $rowt['sca_os_descricao'];
			$descricao_jurisdicao= $rowt['descricao_jurisdicao'];
			$qtd_prospects      = $rowt['qtd_prospects'];
			$qtd_leads          = $rowt['qtd_leads'];
			$qtd_sem_avaliacao  = $rowt['qtd_sem_avaliacao'];
			$qtd_detrators      = $rowt['qtd_detrators'];
			
			$qtd_neutros        = $rowt['qtd_neutros'];
			$qtd_promotores     = $rowt['qtd_promotores'];
			$net_promoter_score = $rowt['net_promoter_score'];
			// calculos
			$qtd_ele = $qtd_ele + 1;
			$qtd_clientes           = $qtd_sem_avaliacao+$qtd_detrators+$qtd_neutros+$qtd_promotores;
			$tot_prospects          = $tot_prospects+$qtd_prospects;
			$tot_leads              = $tot_leads+$qtd_leads;
			$tot_sem_avaliacao      = $tot_sem_avaliacao+$qtd_sem_avaliacao;
			$tot_detrators          = $tot_detrators+$qtd_detrators;
			$tot_neutros            = $tot_neutros+$qtd_neutros;
			$tot_promotores         = $tot_promotores+$qtd_promotores;
			$tot_clientes           = $tot_clientes+$qtd_clientes;
			$tot_net_promoter_score = $tot_net_promoter_score+$net_promoter_score;
		}	
		$tot_net_promoter_score=$tot_net_promoter_score/$qtd_ele;
    }

    $tx_conversao1=$tot_leads/$tot_prospects;
	$tx_conversao2=$tot_clientes/$tot_leads;
	$tx_conversao3=$tot_promotores/$tot_clientes;
	$tx_conversao1w=format_decimal($tx_conversao1*100);
	$tx_conversao2w=format_decimal($tx_conversao2*100);
	$tx_conversao3w=format_decimal($tx_conversao3*100);
	

    $html  = "";
    $html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	
	
    $html .=  "<tr  style='' >  ";
	
	$html .=  "   <td class=''   style='width:20%; xborder:1px solid #00FF00;' >";
	// Lado esquerdo
	$html .=  "    <img style='padding-left:15em; ;'  title='{$tit_1}' src='imagens/taxaconversao.png' border='0'>";
	
	$html .=  "  </td> ";
	
	
	if ($pdf==1)
	{
		$html .=  "   <td class=''   style='width:12%; xborder:1px solid #00FF00;' >";
	}
	else
	{
		$html .=  "   <td class=''   style='width:10%; xborder:1px solid #00FF00;' >";
	}
	// Lado esquerdo
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$html .=  "<tr>";
	if ($pdf==1)
	{
	    $html .=  "<td  class='' valign='bottom'  style='font-size:1.2em; text-align:right; padding-right:5px; width:100%; height:21.5em; xborder:1px solid #FF0000;'>";
	}
	else
	{
	    $html .=  "<td  class='' valign='bottom'  style='font-size:1.3em; text-align:right; padding-right:5px; width:100%; height:13.5em; xborder:1px solid #FF0000;'>";
	}
	
	
	$html .=  $tx_conversao1w." % " ;
	$html .=  "</td>";
	$html .=  "</tr>";
	
	$html .=  "<tr>";
	if ($pdf==1)
	{
	   $html .=  "<td  class=''  valign='bottom' style='font-size:1.2em; text-align:right; padding-right:5px;  width:100%; height:13.0em; xborder:1px solid #0000FF;'>";
	}
	else
	{
	   $html .=  "<td  class=''  valign='bottom' style='font-size:1.3em; text-align:right; padding-right:5px;  width:100%; height:5.5em; xborder:1px solid #0000FF;'>";
	}   
	
	
	$html .=  $tx_conversao2w." % " ;
	$html .=  "</td>";
    $html .=  "</tr>";
	
    
	//tirado o terceiro
	$html .=  "<tr>";	
	if ($pdf==1)
	{
	    $html .=  "<td  class='' valign='bottom'  style='font-size:1.2em; text-align:right; padding-right:5px; width:100%; height:12.5em; xborder:1px solid #00FF00;'>";
	}
	else
	{
		$html .=  "<td  class='' valign='bottom'  style='font-size:1.3em; text-align:right; padding-right:5px; width:100%; height:5.5em; xborder:1px solid #00FF00;'>";
    }	
	
	//$html .=  $tx_conversao3w." % " ;
	$html .=  "</td>";
	
	
	
	$html .=  "</tr>";
	
	
	
	
	$html .=  "<tr>";	
	$html .=  "<td  class=''   style='width:100%; height:9em; xborder:1px solid #00FF00;'>";
	$html .=  "</td>";
	$html .=  "</tr>";
	
	
	
	
	
	$html .=  "</tr>";
	
	
	
	$html .=  "</table>"; 
	
	
	
	
	
	$html .=  "  </td> ";
	
	
	
	
	
	
    $html .=  "   <td class='funil_imagem'   style='width:40%; xborder:1px solid #FF0000;' >";
	$html .=  "    <img width='100%;'  xheight='{$altura}'  title='{$tit_1}' src='imagens/funil.png' border='0'>";
    $html .=  "  </td> ";
	
	$html .=  "   <td class=''   style='width:40%; xborder:1px solid #0000FF; ' >";
	
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$tam1   = '8em';
	$tam2   = '4em';
	$tam3   = '4em';
	$tam4   = '4em';
	$tam5   = '4em';
	$tamfont0 ="2.0em";
    $tamfont1 ="1.6em";
	$tamfont2 ="1.4em";
	$tamfont3 ="1.4em";
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class=''   style='height:{$tam1}; xwidth:30%; xborder:1px solid #00FF00;' >";
	$html .=  "  ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
    // 1 elemento 	
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class=''   style='height:{$tam2}; xwidth:20%; xborder:1px solid #00FF00; border-bottom:5px solid #FFFFFF; ' >";
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td rowspan='2' class=''   style='width:10%; text-align:center; height:{$tam2}; font-size:{$tamfont0}; border-right: 2px solid #000000; xmargin-bottom:5px;  ' >";
	$html .=  " 1 ";
	$html .=  "  </td> ";
				
	$qtd_prospects=format_decimal($tot_meta_prospects,0);
	$html .=  "   <td  class=''   style='padding-left:5px; width:88%; border-bottom: 1px solid #888888;' >";
	$html .=  "<span style='font-size:{$tamfont1}; color:{$cor_prospects}; '> PROSPECTS</span><br/> ";
	$html .=  "<span style='font-size:{$tamfont2}'>Previsto: $qtd_prospects</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "<tr  style='' >  ";
	
	$qtd_prospects_r=format_decimal($tot_prospects,0);
    $html .=  "   <td  class=''   style='padding-left:5px; ' >";
	$html .=  "<span style='color:{$cor_prospects}; font-size:{$tamfont3};'>Realizado: $qtd_prospects_r</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "</table> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	// 2 elemento 	
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class=''   style='height:{$tam3}; xwidth:20%; xborder:1px solid #00FF00; border-bottom:5px solid #FFFFFF;' >";
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td rowspan='2' class=''   style='width:10%; text-align:center; height:{$tam2}; font-size:{$tamfont0}; border-right: 2px solid #000000; ' >";
	$html .=  " 2 ";
	$html .=  "  </td> ";
	$qtd_leads=format_decimal($tot_meta_leads,0);
	$html .=  "   <td  class=''   style='padding-left:5px; width:88%; border-bottom: 1px solid #888888;' >";
	$html .=  "<span style='font-size:{$tamfont1}; color:{$cor_leads}; '>LEADS</span><br/> ";
	$html .=  "<span style='font-size:{$tamfont2};'>Previsto: $qtd_leads</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "<tr  style='' >  ";
	$qtd_leads_r=format_decimal($tot_leads,0);
    $html .=  "   <td  class=''   style='padding-left:5px; ' >";
	$html .=  "<span style='color:{$cor_leads}; font-size:{$tamfont3};'>Realizado: $qtd_leads_r</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "</table> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	//
	// 3 elemento 	
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class=''   style='height:{$tam4}; xwidth:20%; xborder:1px solid #00FF00; border-bottom:5px solid #FFFFFF;' >";
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td rowspan='2' class=''   style='width:10%; text-align:center; height:{$tam2}; font-size:{$tamfont0}; border-right: 2px solid #000000; ' >";
	$html .=  " 3 ";
	$html .=  "  </td> ";
	$qtd_clientes=format_decimal($tot_meta_clientes,0);
	$html .=  "   <td  class=''   style='padding-left:5px; width:88%; border-bottom: 1px solid #888888;' >";
	$html .=  "<span style='font-size:{$tamfont1};  color:{$cor_clientes};  '>CLIENTES</span><br/> ";
	$html .=  "<span style='font-size:{$tamfont2};'>Previsto: $qtd_clientes</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "<tr  style='' >  ";
	$qtd_clientes_r=format_decimal($tot_clientes,0);
    $html .=  "   <td  class=''   style='padding-left:5px; ' >";
	$html .=  "<span style='color:{$cor_clientes}; font-size:{$tamfont3};'>Realizado: $qtd_clientes_r</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "</table> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
    // 4 elemento 	
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class=''   style='height:{$tam5}; xwidth:20%; xborder:1px solid #00FF00;  border-bottom:5px solid #FFFFFF;' >";
	$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    $html .=  "<tr  style='' >  ";
    $html .=  "   <td rowspan='2' class=''   style='width:10%; text-align:center; height:{$tam2}; font-size:{$tamfont0}; border-right: 2px solid #000000; ' >";
	$html .=  " 4 ";
	$html .=  "  </td> ";
	
	$nps_prev = format_decimal($tot_meta_net_promoter_score,0)."%";
	
	$qtd_promotores="NPS ".format_decimal($tot_meta_net_promoter_score,0)."%";
	
	$html .=  "   <td  class=''   style='padding-left:5px; width:88%; border-bottom: 1px solid #888888;' >";
	//$html .=  "<span style='font-size:{$tamfont1}; color:#888888; '>PROMOTORES</span><br/> ";
	
	
	
	$html .=  "<span style='font-size:{$tamfont1};'>NPS</span><br/> ";
	$html .=  "<span style='font-size:{$tamfont2}; '>Previsto: {$nps_prev}</span><br/> ";
	
	
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "<tr  style='' >  ";
	$qtd_promotores_r=format_decimal($tot_net_promoter_score,0)." %";
    $html .=  "   <td  class=''   style='padding-left:5px; ' >";
	$html .=  "<span style='color:#000000; font-size:{$tamfont3};'>Realizado: $qtd_promotores_r</span><br/> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	$html .=  "</table> ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
 	$html .=  "</table> ";
	
	$html .=  "  </td> ";

    $html .=  "</tr>";
    $html .=  "</table> ";
	
	
	// $html .=  "<div class='lado_esq' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
    // $html .=  "1";
	// $html .=  "</div> ";
	
	
	$html .=  "<table class='atende_tb' width='80%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$html .=  "<tr>";
	$html .=  "<td colspan='4'  class=''   style='font-size:11px; color:#888888; width:100%; height:3em; xborder:1px solid #FF0000;'>";
	$html .=  "Fonte: SIACWEB<br />";
	
	
	
	$texto   = "";
	$caminho      = "obj_file/funil/job_funil_ControleRelatorio_{$ano_base}.log";
	$fp      = fopen($caminho, "r"); 
	$texto = fread($fp, filesize ($caminho));
	fclose($fp);
	
	//echo " ---------------- ".$texto;
	
	
    $vet = explode("=",$texto);
	$DataUltimaAtualizacao = substr($vet[1],0,20);
	$html .=  "Atualizado: {$DataUltimaAtualizacao}<br />";
	$html .=  "</td>";
	$html .=  "</tr>";
	$html .=  "</table> ";

	
    ///////////////////////////// matriz   
	
	$linhasep="#666666";
	//$html .=  "<br /> ";
	//$html .= " <br class='quebrapagina'> ";
	
	if ($pdf==1)
	{
	}
	else
	{
		// $html .= " <div style='page-break-after: always'></div> ";
	}	

	$html .="<style>  ";
	$html .=".cab_ma { ";
	$html .="   border-top:1px solid {$linhasep}; ";
	$html .="   border-bottom:1px solid {$linhasep}; ";
	$html .="   text-align:center; ";
	$html .=" } ";
	$html .="</style>  ";
	$html .=  "<table class='atende_tb' width='80%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";

	// colunas de cabeçalho 1
	$html .=  "<tr  style='' >  ";
	$html .=  "   <td colspan='15' class='cab_ma'   style='background:#D0D0D0; color:#000000; font-size:18px;  ' >";
	//$html .=  $ano_base;
	$html .=  "Funil de Atendimento";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	
	
	
    $html .=  "<tr  style='' >  ";
	$onclick=" onclick='return AtivaTodasRegional();'";
	$html .=  "   <td {$onclick} rowspan='2' class='cab_ma' title='Clique aqui para ativar a Visualização de Todas as Unidades Regionais'  style='cursor:pointer;  background:{$cor_ur}; color:#FFFFFF; width:23%; border-right:1px solid {$linhasep};' >";
	$html .=  "UR";
	$html .=  "  </td> ";
	$html .=  "   <td  colspan='3' xrowspan='2' class='cab_ma'   style='background:{$cor_prospects}; width:11%; border-right:1px solid {$linhasep};' >";
	$html .=  "PROSPECTS  ";
	$html .=  "  </td> ";
	//$html .=  "   <td rowspan='2' class='cab_ma'   style='background:{$cor_prospects_perc};  width:5%; border-right:1px solid {$linhasep}; ' >";
	//$html .=  "%";
	//$html .=  "  </td> ";
	$html .=  "   <td colspan='3' xrowspan='2' class='cab_ma'   style='background:{$cor_leads}; width:11%; border-right:1px solid {$linhasep};' >";
	$html .=  "LEADS";
	$html .=  "  </td> ";
	
	//$html .=  "   <td  rowspan='2' class='cab_ma'   style='background:{$cor_leads_perc}; width:5%; border-right:1px solid {$linhasep};' >";
	//$html .=  "%";
	//$html .=  "  </td> ";
	
	
	$html .=  "   <td colspan='5' class='cab_ma'   style='background:{$cor_clientes}; width:10%; xborder-right:1px solid {$linhasep};' >";
	$html .=  "CLIENTE ";
	$html .=  "  </td> ";
	$html .=  "   <td colspan='2' xrowspan='2' class='cab_ma'   style='background:{$cor_clientes}; width:7%; border-right:1px solid {$linhasep};' >";
	$html .=  "TOTAL";
	$html .=  "  </td> ";
	
//	$html .=  "   <td rowspan='2' class='cab_ma'   style='background:{$cor_total_perc}; width:5%; border-right:1px solid {$linhasep};' >";
//	$html .=  "%";
//	$html .=  "  </td> ";
	$html .=  "   <td rowspan='2' class='cab_ma'   style='background:{$cor_nps}; color:#FFFFFF; width:5%;  ' >";
	$html .=  "NPS<br />(META<br />80%)  ";
	$html .=  "  </td> ";
	$html .=  "</tr>";
	
	/*
		$vetMetasFunil[$ano][$idt_unidade_regional]['prospects']          = $qtd_prospects;
			$vetMetasFunil[$ano][$idt_unidade_regional]['leads']              = $qtd_leads;
			$vetMetasFunil[$ano][$idt_unidade_regional]['clientes']           = $qtd_clientes;
			$vetMetasFunil[$ano][$idt_unidade_regional]['net_promoter_score'] = $net_promoter_score;
	*/	
	
	
	
	
	
	
	
	// colunas de cabeçalho 2
	
	$html .=  "<tr  style='' >  ";
	
	/*
    $html .=  "<tr  style='' >  ";
	$html .=  "   <td class='cab_ma'   style='width:15%; border-right:1px solid {$linhasep};' >";
	//$html .=  "UR";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:10%; border-right:1px solid {$linhasep};' >";
	//$html .=  "PROSPECTS  ";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:5%; border-right:1px solid {$linhasep}; ' >";
	//$html .=  "%";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:10%; border-right:1px solid {$linhasep};' >";
	//$html .=  "LEADS";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:5%; border-right:1px solid {$linhasep};' >";
	//$html .=  "%";
	$html .=  "  </td> ";
	*/
	// PROSPECTS
	$html .=  "   <td class='cab_ma'   style='background:{$cor_prospects}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "META";
	$html .=  "  </td> ";
    $html .=  "   <td class='cab_ma'   style='background:{$cor_prospects}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "RALIZADO";
	$html .=  "  </td> ";
    $html .=  "   <td class='cab_ma'   style='background:{$cor_prospects}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  " % de realização ";
	$html .=  "  </td> ";

    // LEAD
	$html .=  "   <td class='cab_ma'   style='background:{$cor_leads}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "META";
	$html .=  "  </td> ";
    $html .=  "   <td class='cab_ma'   style='background:{$cor_leads}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "RALIZADO";
	$html .=  "  </td> ";
    $html .=  "   <td class='cab_ma'   style='background:{$cor_leads}; width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  " % de realização ";
	$html .=  "  </td> ";
   
    // CLIENTES 	
	
	 // TOTAL 
    $html .=  "   <td class='cab_ma'   style='background:{$cor_clientes};  width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "META";
	$html .=  "  </td> ";
    $html .=  "   <td class='cab_ma'   style='background:{$cor_clientes};  width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  "RALIZADO";
	$html .=  "  </td> ";

    $html .=  "   <td class='cab_ma'   style='background:{$cor_clientes};  width:8%; border-right:1px solid {$linhasep};' >";
	$html .=  " % de realização ";
	$html .=  "  </td> ";



	$html .=  "   <td class='cab_ma'   style='background:{$cor_clientes_sub}; width:9%; border-right:1px solid {$linhasep};' >";
	$html .=  "SEM AVALIAÇÃO  ";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='background:{$cor_clientes_sub}; width:9%; border-right:1px solid {$linhasep};' >";
	$html .=  "DETRATORES";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='background:{$cor_clientes_sub}; width:9%; border-right:1px solid {$linhasep};' >";
	$html .=  "NEUTROS";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='background:{$cor_clientes_sub}; width:9%; border-right:1px solid {$linhasep};' >";
	$html .=  "PROMOTORES";
	$html .=  "  </td> ";
	
	
	
	
	
	
	
	
	/*
	$html .=  "   <td class='cab_ma'   style='width:10%; border-right:1px solid {$linhasep};' >";
	//$html .=  "TOTAL";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:5%; border-right:1px solid {$linhasep};' >";
	//$html .=  "%";
	$html .=  "  </td> ";
	$html .=  "   <td class='cab_ma'   style='width:10%;  ' >";
	//$html .=  "NPS<br />(META 80%)>  ";
	$html .=  "  </td> ";
	*/
	$html .=  "</tr>";
	//
	// $ano_base = "2017";
	//
	$sqlt  = " select ";
	$sqlt .= "   grc_fe.*, ";
	$sqlt .= "   sca_os.descricao as sca_os_descricao  ";
	$sqlt .= " from grc_funil_execucao grc_fe ";
	$sqlt .= "   left join ".db_pir."sca_organizacao_secao sca_os on sca_os.idt = grc_fe.idt_unidade_regional  ";
	$sqlt .= " where grc_fe.ano  = ".aspa($ano_base);
	$sqlt .= $wherecomple;
	$rst   = execsql($sqlt);
	if ($rst->rows==0)
	{
	
	}
	else
	{
	    $tot_prospects=0;
		$tot_leads=0;
		$tot_sem_avaliacao=0;
		$tot_detrators=0;
		$tot_neutros=0;
		$tot_promotores=0;
		$tot_clientes=0;
		
		$html .="<style>  ";
		$html .=".det_ma { ";
		$html .="   border-top:1px solid {$linhasep}; ";
		$html .="   border-bottom:1px solid {$linhasep}; ";
		$html .="   text-align:right; ";
	    $html .="   padding-right:5px;; ";
		$html .=" } ";
		$html .="</style>  ";
		foreach ($rst->data as $rowt) {
		    $idt_unidade_regional = $rowt['idt_unidade_regional'];
		    $sca_os_descricao   = $rowt['sca_os_descricao'];
			$descricao_jurisdicao= $rowt['descricao_jurisdicao'];
			$qtd_prospects      = $rowt['qtd_prospects'];
			$qtd_leads          = $rowt['qtd_leads'];
			$qtd_sem_avaliacao  = $rowt['qtd_sem_avaliacao'];
			$qtd_detrators      = $rowt['qtd_detrators'];
			
			$qtd_neutros        = $rowt['qtd_neutros'];
			$qtd_promotores     = $rowt['qtd_promotores'];
			$net_promoter_score = $rowt['net_promoter_score'];
			// calculos
			$qtd_clientes        = $qtd_sem_avaliacao+$qtd_detrators+$qtd_neutros+$qtd_promotores;
			
			$tot_prospects=$tot_prospects+$qtd_prospects;
			$tot_leads=$tot_leads+$qtd_leads;
			$tot_sem_avaliacao=$tot_sem_avaliacao+$qtd_sem_avaliacao;
			$tot_detrators=$tot_detrators+$qtd_detrators;
			$tot_neutros=$tot_neutros+$qtd_neutros;
			$tot_promotores=$tot_promotores+$qtd_promotores;
			
			$tot_clientes=$tot_clientes+$qtd_clientes;
			
			$qtd_clientesw       = format_decimal($qtd_clientes,0);
			
			$qtd_prospectsw      = format_decimal($qtd_prospects,0);
			$qtd_leadsw          = format_decimal($qtd_leads,0);
			$qtd_sem_avaliacaow  = format_decimal($qtd_sem_avaliacao,0);
			$qtd_detratorsw      = format_decimal($qtd_detrators,0);
			
			$qtd_neutrosw        = format_decimal($qtd_neutros,0);
			$qtd_promotoresw     = format_decimal($qtd_promotores,0);
			$net_promoter_scorew = format_decimal($net_promoter_score,1);

		    $qtd_meta_prospects      = $vetMetasFunil[$ano][$idt_unidade_regional]['prospects'];
			$qtd_meta_leads          = $vetMetasFunil[$ano][$idt_unidade_regional]['leads'];
			$qtd_meta_clientes       = $vetMetasFunil[$ano][$idt_unidade_regional]['clientes'];
			$meta_net_promoter_score = $vetMetasFunil[$ano][$idt_unidade_regional]['net_promoter_score'];
    
	        $perc_prospects      = $qtd_prospects/$qtd_meta_prospects;
			$meta_leads          = $qtd_leads/$qtd_meta_leads;
			$meta_clientes       = $qtd_clientes/$qtd_meta_clientes;
			
			
			
			
			$qtd_prospects_percw = format_decimal($perc_prospects*100,1);
			$qtd_leads_percw     = format_decimal($meta_leads*100,1); 
			$qtd_clientes_percw  = format_decimal($meta_clientes*100,1);
			
			
			//$tot_meta_prospects      = $tot_meta_prospects+$qtd_meta_prospects;
			//$tot_meta_leads          = $tot_meta_leads+$qtd_meta_leads;
			//$top_meta_clientes       = $top_meta_clientes+$qtd_meta_clientes;
			$tot_meta_net_promoter_score = $tot_meta_net_promoter_score+$meta_net_promoter_score;
    
			
			$qtd_meta_prospectsw      = format_decimal($qtd_meta_prospects,0);
			$qtd_meta_leadsw          = format_decimal($qtd_meta_leads,0);
			$qtd_meta_clientesw       = format_decimal($qtd_meta_clientes,0);
			$meta_net_promoter_scorew = format_decimal($meta_net_promoter_score,1);
    
			
			// Exibe
			// colunas de detalhe
			$html .=  "<tr  style='' >  ";
			$onclick=" onclick='return AtivaRegional({$idt_unidade_regional});'";
			$html .=  "   <td id='UR_{$idt_unidade_regional}' {$onclick} title='Clique aqui para Filtrar por essa unidade Regional' class='det_ma'   style='background:{$cor_urw};cursor:pointer; border-right:1px solid {$linhasep};' >";
			//$html .=  $sca_os_descricao;
			if ($pdf==1)
	        {
			    $html .=  $descricao_jurisdicao;
			}
			else
			{
			    $html .=  "<span style='font-size:1em;'>$descricao_jurisdicao</span>";
			}
			
			$html .=  "  </td> ";
			// PROSPECTS META
			
			
			
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_meta_prospectsw;
			$html .=  "  </td> ";
			// PROSPECT REALIZADO
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_prospectsw;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_prospects_percw;
			$html .=  "  </td> ";
			// LEAD META
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_meta_leadsw;
			$html .=  "  </td> ";
			// LEAD REALIZADO
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_leadsw;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_leads_percw;
			$html .=  "  </td> ";
			
			// TOTAL DE META CLIENTES
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_meta_clientesw;
			$html .=  "  </td> ";
			// TOTAL DE CLIENTES
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_clientesw;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_clientes_percw;
			$html .=  "  </td> ";
			
			
			
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_sem_avaliacaow;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_detratorsw;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_neutrosw;
			$html .=  "  </td> ";
			$html .=  "   <td class='det_ma'   style='border-right:1px solid {$linhasep};' >";
			$html .=  $qtd_promotoresw;
			$html .=  "  </td> ";
			
			//$meta_net_promoter_scorew = format_decimal(meta_net_promoter_score,2);
    
			$html .=  "   <td class='det_ma'   style='width:5%;  ' >";
			$html .=  $net_promoter_scorew ;
			$html .=  "  </td> ";
			$html .=  "</tr>";
		}	
    }	   
	// Total
	// colunas de detalhe

/*
    $tot_prospects=;
	$tot_prospects_perc=;
	$tot_leads=;
	$tot_leads_perc=;
	$tot_sem_avaliacao=;
	$tot_detrators=;
	$tot_neutros=;
	$tot_promotores=;
	$tot_clientes=;
	$tot_clientes_perc=;
	$tot_net_promoter_scorew ;
*/
	
    $tot_prospectsw=format_decimal($tot_prospects,0);
	/*
	$tot_meta_prospects          = $tot_meta_prospects+$qtd_prospects;
			$tot_meta_leads              = $tot_meta_leads+$qtd_leads;
			$tot_meta_clientes           = $tot_meta_clientes+$qtd_clientes;
			$tot_meta_net_promoter_score = $tot_meta_net_promoter_score+$net_promoter_score;
	*/		
	$tot_prospects_perc=($tot_prospects/$tot_meta_prospects)*100;
	$tot_prospects_percw=format_decimal($tot_prospects_perc,1);
	$tot_leadsw=format_decimal($tot_leads,0);
	$tot_leads_perc=($tot_leads/$tot_meta_leads)*100;
	$tot_leads_percw=format_decimal($tot_leads_perc,1);
	$tot_sem_avaliacaow=format_decimal($tot_sem_avaliacao,0);
	$tot_detratorsw=format_decimal($tot_detrators,0);
	$tot_neutrosw=format_decimal($tot_neutros,0);
	$tot_promotoresw=format_decimal($tot_promotores,0);
	$tot_clientesw=format_decimal($tot_clientes,0);
	$tot_clientes_perc=($tot_clientes/$tot_meta_clientes)*100;
	$tot_clientes_percw=format_decimal($tot_clientes_perc,1);
	$tot_net_promoter_scorew=format_decimal($tot_net_promoter_score,1);
	
	
	$tot_meta_prospectsw      = format_decimal($tot_meta_prospects,0);
	$tot_meta_leadsw          = format_decimal($tot_meta_leads,0);
	$tot_meta_clientesw       = format_decimal($tot_meta_clientes,0);
	$tot_meta_net_promoter_scorew = format_decimal($tot_meta_net_promoter_score,1);
    
	
	if ($idt_unidade_regional_sel=='')
	{
		$html .="<style>  ";
		$html .=".tot_ma { ";
		$html .="   border-bottom:1px solid {$linhasep}; ";
		$html .="   background:#F1F1F1; ";
		$html .="   text-align:right; ";
		$html .="   padding-right:5px;; ";
		$html .="   padding:5px;; ";
		$html .=" } ";
		$html .="</style>  ";
		
		$html .=  "<tr  style='' >  ";
		$html .=  "   <td class='tot_ma'   style='text-align:right; padding-right:5px; border-right:1px solid {$linhasep};' >";
		$html .=  "TOTAL";
		$html .=  "  </td> ";
	


		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_meta_prospectsw;
		$html .=  "  </td> ";
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_prospectsw;
		$html .=  "  </td> ";
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_prospects_percw;
		$html .=  "  </td> ";
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_meta_leadsw;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_leadsw;
		$html .=  "  </td> ";
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_leads_percw;
		$html .=  "  </td> ";
		
		
		
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_meta_clientesw;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_clientesw;
		$html .=  "  </td> ";
		
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_clientes_percw;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_sem_avaliacaow;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_detratorsw;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_neutrosw;
		$html .=  "  </td> ";
		$html .=  "   <td class='tot_ma'   style='border-right:1px solid {$linhasep};' >";
		$html .=  $tot_promotoresw;
		$html .=  "  </td> ";


    

		
		
//	$tot_meta_net_promoter_scorew = format_decimal($tot_meta_net_promoter_score);
		
		$html .=  "   <td class='tot_ma'   style='width:10%;  ' >";
		$html .=  $tot_net_promoter_scorew ;
		$html .=  "  </td> ";
		$html .=  "</tr>";
	}
	
    $html .=  "</table> ";
	$html .=  "<br /><br /> ";
	//////////////////////
	echo $html;
?>
<script>
$(document).ready(function () {
/*
           objd=document.getElementById('tipo_pessoa_desc');
           if (objd != null)
           {
               $(objd).css('visibility','hidden');
           }
           objd=document.getElementById('tipo_pessoa');
           if (objd != null)
           {
               objd.value = "";
               $(objd).css('visibility','hidden');
           }
*/
});

function AtivaRegional(idt_unidade_regional)
{
    var id='UR_'+idt_unidade_regional;
	var UR_Nome = 'Não acessou UR '+idt_unidade_regional;
    objd=document.getElementById(id);
	if (objd != null)
	{
	   UR_Nome = objd.innerHTML;
	}
   var href='conteudo_funil_relatorio.php?idt_unidade_regional='+idt_unidade_regional+'&nome_unidade_regional='+UR_Nome;
   self.location=href;
   return false;
}

function AtivaTodasRegional()
{
   var href='conteudo_funil_relatorio.php?idt_unidade_regional=';
   self.location=href;
   return false;
}

</script>
