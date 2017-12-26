
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

</style>


<?php
//echo "fazer aqui ";
$vetAgenda = $_SESSION[CS]['CarregarAgendaExistente'];
$pa_desc   = $_SESSION[CS]['gdesc_idt_unidade_regional'];
$vetMatrizAgendaLinha      = Array();
$vetMatrizAgendaColuna     = Array();
$vetMatrizAgendaLinhaColuna= Array();

foreach ($vetAgenda as $idt_agenda => $rowa) {
    $idt        = $rowa['idt'];
	$data       = $rowa['data'];
	$situacao   = $rowa['situacao'];
	$origem     = $rowa['origem'];
	$hora       = $rowa['hora'];
	$vetMatrizAgendaLinha[$hora] =$data;
	$vetMatrizAgendaColuna[$data]=$hora;
	$vetMatrizAgendaLinhaColuna[$hora][$data]=$situacao;
	$vetMatrizAgendaLinhaColunaIdt[$hora][$data]=$idt;
}
ksort($vetMatrizAgendaLinha);
ksort($vetMatrizAgendaColuna);
$vetMatrizAgendaLinhaColunaTable=Array();
foreach ($vetMatrizAgendaLinha as $hora => $data) {
	$situacao = $vetMatrizAgendaLinhaColuna[$hora][$data];
	$vetMatrizAgendaLinhaColunaTable[$hora][$data]=$situacao;
	
}


$qtd_col = count($vetMatrizAgendaColuna);

$qtd_colw = $qtd_col + 1; 
$html  = "";
$html .= "<table cellspacing='0' cellpadding='0' width='100%' border='0'>";


$html .= "<tr>";
$html .= "<td colspan='{$qtd_colw}' class='cab' style='padding:5px; background:#C0C0C0; text-align:center; border-bottom:1px solid #000000;  ' >";
$html .= "{$pa_desc}";
$html .= "</td>";


$html .= "<tr>";
$html .= "<td class='cab' style='padding:5px; background:#F1F1F1; text-align:center; border-bottom:1px solid #C0C0C0; border-top:1px solid #FFFFFF; border-right:1px solid #C0C0C0; ' >";
$html .= "Hora";
$html .= "</td>";
foreach ($vetMatrizAgendaColuna as $data => $hora) {
	$html .= "<td class='cab' style='padding:5px; background:#F1F1F1;  text-align:center;  border-bottom:1px solid #C0C0C0; border-right:1px solid #C0C0C0; '>";
	$dataw = trata_data($data);
	$dia_semana = GRC_DiaSemana($dataw, 'resumo1');   // formato dd/mm/aaaa
	$html .= " $dataw<br />{$dia_semana} ";
	$html .= "</td>";
}
$html .= "</tr>";

// Gerar as linhas

foreach ($vetMatrizAgendaLinha as $hora => $datat) {
	$html .= "<tr>";
	$html .= "<td class='lin' style='padding:5px; background:#F1F1F1;  text-align:center; border-bottom:1px solid #C0C0C0; border-right:1px solid #C0C0C0; '>";
	$html .= "$hora";
	$html .= "</td>";
	foreach ($vetMatrizAgendaColuna as $data => $horat) {
	     
	    $situacao = $vetMatrizAgendaLinhaColuna[$hora][$data];
		$idt      = $vetMatrizAgendaLinhaColunaIdt[$hora][$data];
		if ($situacao!="")
		{
			$hint=$situacao;
			$img ='imagens/bola_amarela_l.png';
		}	
		if ($situacao=='Agendado')
		{
		    $hint='Disponível';
			$img ='imagens/bola_verde_l.png';
		}
    	if ($situacao=='Bloqueado')
		{
		    $hint=$situacao;
			$img ='imagens/bola_vermelha_l.png';
		}
		if ($situacao=='Marcado')
		{
		    $hint=$situacao;
			$img ='imagens/bola_azul_l.png';
		}
		if ($situacao=="")
		{
		    $situacaow = "";
		}  
		else
		{
		    $situacaow = "<img alt='' title='{$hint}' src='{$img}' width='25' height='25'>";
		}
		$onclick = " onclick='return AcessaAgenda($idt);' ";
		$html .= "<td {$onclick} class='lin' style='cursor:xpointer; padding:5px; background:#FFFFFF; text-align:center; border-bottom:1px solid #C0C0C0; border-right:1px solid #C0C0C0;'>";
		$html .= " $situacaow ";
		$html .= "</td>";
	}	
	$html .= "</tr>";
}


$html .= "</table>";
echo $html;


?>



<script type="text/javascript" >

//    var idt_organizacao = <?php echo $idt_organizacao; ?>;

function AcessaAgenda(idt)
{
    // alert('Teste de abrir xxx '+idt);
	/*
	$.ajax({
		dataType: 'json', 
		type: 'POST',
		url: ajax_sistema + '?tipo=CarregarDadosAgenda',
		data: {
			cas: conteudo_abrir_sistema,
			idt_atendimento_gera_agenda : idt
		},
		success: function (response) {
			if (response.erro == '') {
			   // carregou os dados
			   alert('Teste de abrir xxx '+response.erro);
			   
			} else {
				alert(url_decode(response.erro));
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		async: false
	});
*/	
    return false;
}

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

	
</script>
