
<style type="text/css">

</style>


<?php

function CriarDimensoesAtendimentom1(&$vetDimensao) {
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
    $rsl = execsql($sqll);
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

function QuantitativosAtendimentom1($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, &$vetDimensao, &$vetDimensaoTotal, &$TotalGeral_G, &$vetDimensaoInstrumento, &$vetDimensaoTempoI, &$vetDimensaoTempoP,$op) {
    //$vetDimensao = Array();
	
	//$vetDimensaoTotal = Array();
	
    $sql = "select ";
    $sql .= "   count(grc_a.idt) as quantidade, sum(grc_a.horas_atendimento) as horas_atendimento, sum(grc_a.horas_evento) as horas_evento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento ";
    $sql .= " from grc_historico_meta grc_a ";
	//$sql .= " inner join grc_competencia grc_c on grc_c.idt =  grc_a.idt_competencia";
	//$sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento =  grc_a.idt";
	
	$condicao = "";
	if ($op==2)
	{
	    $condicao = " origem = 'Evento' ";
	}
	else
	{
	    $condicao = " origem = 'Balcão' ";
	}
	$condicao .= " and cnpj is not null and idt_instrumento <> 8 "; // Exclui  Informação 
    if ($condicao != "") {
        $sql .= "  where $condicao ";
    }
    $sql .= "  group by grc_a.idt_ponto_atendimento, grc_a.idt_instrumento  ";

    $rsl = execsql($sql);
    $total = 0;
    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento  = $rowl['idt_ponto_atendimento'];
		
		$idt_instrumento        = $rowl['idt_instrumento'];
		if ($op==2 and $idt_instrumento==2) // pegando de evento
		{
		    $idt_instrumento=39; // longa duração; 
		}
		if ($vetInstrumento[$idt_instrumento] > 0)
		{   // Instrumento 
			$quantidade             = $rowl['quantidade'];
			$horas_atendimento      = $rowl['horas_atendimento'];
			$horas_evento           = $rowl['horas_evento'];
			if ($horas_atendimento=='')
			{
			    $horas_atendimento=$horas_evento; 
			}
			$TotalGeral_G           = $TotalGeral_G + $quantidade;
			//
			$vetDimensao[$idt_ponto_atendimento][$idt_instrumento]       = $quantidade;
			$vetDimensaoTotal[$idt_ponto_atendimento]                    = $vetDimensaoTotal[$idt_ponto_atendimento] + $quantidade;
			$vetDimensaoInstrumento[$idt_instrumento]                    = $vetDimensaoInstrumento[$idt_instrumento] + $quantidade;
			
			$vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] = $horas_atendimento;
			$vetDimensaoTempoP[$idt_ponto_atendimento]                   = $vetDimensaoTempoP[$idt_ponto_atendimento] + $horas_atendimento;
			
			$idt_ur                                                      = $vetPontoUR[$idt_ponto_atendimento];
			if ($idt_ur>0)
			{
				$idt_ponto_atendimento = $idt_ur;
				$vetDimensaoTotal[$idt_ponto_atendimento]                    = $vetDimensaoTotal[$idt_ponto_atendimento] + $quantidade;
				
				$vetDimensao[$idt_ponto_atendimento][$idt_instrumento]       = $vetDimensao[$idt_ponto_atendimento][$idt_instrumento] + $quantidade;
				
				$vetDimensaoTempoP[$idt_ponto_atendimento]                   = $vetDimensaoTempoP[$idt_ponto_atendimento] + $horas_atendimento;
				$vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] = $vetDimensaoTempoI[$idt_ponto_atendimento][$idt_instrumento] + $horas_atendimento;
			    
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
$ret = CriarDimensoesAtendimentom1($vetDimensao);
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



$condicao       = ""; // todos os produtos
$condicao    = " ano = '2016' and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is null and idt_grupo_atendimento is null ";
QuantitativosAtendimentom1($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP,1);
//$condicao    = " ano = '2016' and (situacao = 'Finalizado' or situacao = 'Finalizado em Alteração') and idt_evento is not null and idt_grupo_atendimento is null ";

$condicao     = " ano = '2016'  and idt_evento is not null and idt_grupo_atendimento is null ";
$condicao    .= whereEventoParticipante('grc_ep');

QuantitativosAtendimentom1($vetInstrumento,$vetPontoUR,$idt_dimensao, $condicao, $vetDimensao,$vetDimensaoTotal,$TotalGeral_G, $vetDimensaoInstrumento, $vetDimensaoTempoI, $vetDimensaoTempoP,2);
$vetAtendimentoQtd = $vetDimensao;
//p($vetAtendimentoQtd);  
//p($vetDimensaoTotal);  
//p($vetInstrumento);

echo "<div id='mata1_titulo' class='cb_titulo_meta'>";
echo "Meta 1: Atendimento a Pequenos Negócios";
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
	
    echo "   <td id='{$id_linha}'  {$onclick} title='{$hint}'class='cb_texto {$classw}' style='cursor:pointer; white-space:nowrap;' >{$brancos}{$row['descricao']}</td> ";
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


?>



<script type="text/javascript" >

//    var idt_organizacao = <?php echo $idt_organizacao; ?>;

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
	$('#parametros').toggle();
    
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
	
</script>
