
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
//
$idt_ponto_atendimento=$_GET['idt_ponto_atendimento'];


$condicao     = " (e.idt_evento_situacao = 14 or e.idt_evento_situacao = 16 or e.idt_evento_situacao = 19 or e.idt_evento_situacao = 20 )";
$condicao    .= " and e.dt_previsao_inicial >= ".aspa(trata_data('29/08/2016'));
$condicao    .= " and e.dt_previsao_inicial <= ".aspa(trata_data('03/09/2016'));


$condicao    .= " and e.idt_ponto_atendimento = ".null($idt_ponto_atendimento);




$sql = "select e.*,";
$sql .= " e.idt as e_idt_evento, ";
$sql .= " i.descricao as instrumento_desc,";
$sql .= " grc_ersit.descricao as grc_ersit_descricao,";
$sql .= " grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
$sql .= ' (';
$sql .= " select concat_ws('<br />', u.nome_completo, date_format(ap.dt_update, '%d/%m/%Y %H:%i:%s')) as aprovador";
$sql .= ' from grc_atendimento_pendencia ap';
$sql .= ' inner join plu_usuario u on u.id_usuario = ap.idt_usuario_update';
$sql .= ' where ap.idt_evento_situacao_para = 14';
$sql .= ' and ap.idt_evento = e.idt';
$sql .= ' order by ap.dt_update desc limit 1';
$sql .= ' ) as aprovador ';
$sql .= " from grc_evento e";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = e.idt_evento_situacao";
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = e.idt_evento_situacao_ant ";
$sql .= ' left outer join grc_produto pr on pr.idt = e.idt_produto';

$sql .= " where e.temporario <> 'S'";
//
if ($condicao != "") {
	$sql .= "  and $condicao ";
}
$sql .= "  order by dt_previsao_inicial ";
$rsl = execsql($sql);
echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td  class='cb_texto_int_cab' style=''>Código</td> ";
echo "   <td  class='cb_texto_int_cab cb_texto_cab1' style=''>Descrição</td> ";
echo "   <td  class='cb_texto_int_cab cb_texto_cab1' style=''>Instrumento</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Data Início</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Data Término</td> ";
echo "   <td  class='cb_texto_int_cab' style=''>Aprovador</td> ";
echo "</tr>";
ForEach ($rsl->data as $rowl) {

    $idt_evento =  $rowl['e_idt_evento'];
	$codigo=$rowl['codigo'];
	$descricao=$rowl['descricao'];
	$instrumento_desc=$rowl['instrumento_desc'];
	$dt_previsao_inicial=trata_data($rowl['dt_previsao_inicial']);
	$dt_previsao_fim=trata_data($rowl['dt_previsao_fim']);
	$grc_ersit_descricao=$rowl['grc_ersit_descricao'];
	$aprovador=$rowl['aprovador'];
	$ordem_contratacao=$rowl['ordem_contratacao'];
	$rm_consolidado=$rowl['rm_consolidado'];
	$situacao_reg=$rowl['situacao_reg'];
    echo "<tr class=''>  ";
	
	//$onclick = " onclick = 'return Detalha_Atendimento($idt_atendimento); '";
	//$hint=" title='Clique aqui para Detalhar o Evento' ";

	$onclick = "";
	$hint    = "";

    echo "   <td id='{$idt_evento}' {$onclick} {$hint} class='cb_texto {$classw}' style='cursor:pointer; color:#2F66B8;  text-align:center;' >{$codigo}</td> ";

	echo "   <td class='cb_texto {$classw}' style='' >{$descricao}</td> ";
	echo "   <td class='cb_texto {$classw}' style='' >{$instrumento_desc}</td> ";
	echo "   <td class='cb_texto {$classw}' style='' >{$dt_previsao_inicial}</td> ";
	echo "   <td class='cb_texto {$classw}' style='' >{$dt_previsao_fim}</td> ";
	
	echo "   <td class='cb_texto {$classw}' style=';' >{$aprovador}</td> ";
	
	
	echo "</tr>  ";
	
}
echo "</table>";


?>



<script type="text/javascript" >
function Detalha_Atendimento(idt_atendimento)
{
    alert('Chamar ficha do atendimento para consultar'+idt_atendimento);
    return false;
}
	
</script>
