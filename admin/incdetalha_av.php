
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
        color:#000000;
		text-align:left;
        padding:5px;
		font-size:12px;
		border-bottom:1px solid #C0C0C0;

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

$opcao = $_GET['opcao'];


if ($opcao==1)
{
    $idt_evento = $_GET['idt_evento'];
    $sqlt  = " select ";
	$sqlt .= " grc_e.codigo, ";
	$sqlt .= " grc_e.dt_previsao_inicial, ";
	$sqlt .= " grc_e.dt_previsao_fim, ";
	$sqlt .= " grc_ai.descricao as instrumento, ";
	
	$sqlt .= " grc_e.descricao, ";
	$sqlt .= " grc_a.cpf, ";
	$sqlt .= " grc_a.data_registro, ";
	
	$sqlt .= " grc_a.email_avaliador, ";
	$sqlt .= " grc_a.nome_avaliador, ";
	$sqlt .= " grc_a.telefone_avaliador, ";
	$sqlt .= " grc_ar.resposta_txt, ";
    $sqlt .= " grc_en.descricao as cliente, ";
	
	
	
	$sqlt .= " grc_fr.codigo as avaliacao, ";
	$sqlt .= " plu_usu.nome_completo as clientex ";
	
	
	$sqlt .= " from grc_avaliacao grc_a";
    $sqlt .= " left  join `db_pir_gec`.`gec_entidade`   grc_en on grc_en.codigo = grc_a.cpf and reg_situacao = 'A' ";

	$sqlt .= " inner join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
	$sqlt .= " inner join `db_pir_grc`.`grc_atendimento_instrumento` grc_ai on grc_ai.idt = grc_e.idt_instrumento ";
	
	$sqlt .= " inner join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_e.idt_produto ";
	$sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
	
	$sqlt .= " left  join `db_pir_grc`.`plu_usuario` plu_usu on plu_usu.id_usuario = grc_a.idt_avaliador ";
	
	
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
    $sqlt .= " where grc_f.codigo = '700' ";
    
	
	//$sqlt .= " where grc_a.idt_formulario = 14 ";
	$sqlt .= "   and grc_e.idt = " . null($idt_evento);
	$sqlt .= " order by grc_ai.descricao, grc_e.codigo ";
	$rst   = execsql($sqlt);
	
	if ($rst->rows == 0)
	{
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		echo "<tr class=''>  ";
		echo "   <td colspan='7' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Evento sem Avaliação Estrelinha ";
		echo "   </td> ";
		echo "</tr>";
		echo "</table>";
	}
	else
	{  
		foreach ($rst->data as $rowt) {
			$codigo    = $rowt['codigo'];
			$descricao = $rowt['descricao'];
			break;
		}
		
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		
		echo "<tr class=''>  ";
		echo "   <td colspan='4' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Evento: $codigo - $descricao ";
		echo "   </td> ";
		echo "</tr>";

		
        echo "<tr class=''>  ";
		
		echo "   <td class='cb_texto_tit' style='text-align:left;' >";
		echo "   CPF ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='text-align:left;' >";
		echo "   Cliente ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='text-align:left;' >";
		echo "   Comentário ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='text-align:left;' >";
		echo "   Data Registro ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='width:155px; text-align:left;' >";
		echo "   Avaliação ";
		echo "   </td> ";
		echo "</tr>";

	    foreach ($rst->data as $rowt) {
			$codigo        = $rowt['codigo'];
			$cpf           = $rowt['cpf'];
			$cliente       = $rowt['cliente'];
			$descricao     = $rowt['descricao'];
			$instrumento   = $rowt['instrumento'];
			$data_registro = trata_data($rowt['data_registro']);
			
			
			
			
			$dt_previsao_inicial = trata_data($rowt['dt_previsao_inicial']);
			$dt_previsao_fim = trata_data($rowt['dt_previsao_fim']);

			$avaliacao     = $rowt['avaliacao'];
			echo "<tr class=''>  ";
			echo "   <td class='cb_texto' style='' >";
			echo $cpf;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $cliente;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $resposta_txt;
			echo "   </td> ";
			
			
			echo "   <td class='cb_texto' style='' >";
			echo $data_registro;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
			echo $img;
			echo "   </td> ";
			echo "</tr>";
		}
		// Total
		echo "<tr class=''>  ";
		echo "   <td colspan='4' class='cb_texto' style='background:#F1F1F1; text-align:right;' >";
		echo 'Avaliação Média';
		echo "   </td> ";
		echo "   <td class='cb_texto' style='background:#F1F1F1;' >";
		$vet = AvaliacaoEstrelinhaMediaEvento($idt_evento);
		$avaliacao = $vet['media'];
		$img          = $vet['imagem'];
		//$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
		echo $img;
		echo "   </td> ";
		echo "</tr>";
		echo "</table>"; 
	}
}


if ($opcao==2)
{
    $idt_produto = $_GET['idt_produto'];
	
	// p($_GET);
	
	
	
    $sqlt  = " select ";
	$sqlt .= " grc_e.codigo, ";
	$sqlt .= " grc_e.dt_previsao_inicial, ";
	$sqlt .= " grc_e.dt_previsao_fim, ";
	$sqlt .= " grc_ai.descricao as instrumento, ";
	
	$sqlt .= " grc_p.codigo as codigo_produto , ";
	$sqlt .= " grc_p.descricao as descricao_produto, ";
	
	
	$sqlt .= " grc_a.cpf as cpf_cli, ";
	$sqlt .= " grc_e.descricao, ";
	$sqlt .= " grc_a.data_registro, ";
	
	$sqlt .= " grc_a.email_avaliador, ";
	$sqlt .= " grc_a.nome_avaliador, ";
	$sqlt .= " grc_a.telefone_avaliador, ";
	$sqlt .= " grc_ar.resposta_txt, ";
	$sqlt .= " grc_en.descricao as cliente_av, ";
	
	
	
	
	$sqlt .= " grc_fr.codigo as avaliacao, ";
	$sqlt .= " plu_usu.nome_completo as cliente ";
	$sqlt .= " from grc_avaliacao grc_a";
	
	$sqlt .= " left  join `db_pir_gec`.`gec_entidade`   grc_en on grc_en.codigo = grc_a.cpf and reg_situacao = 'A' ";
	
	$sqlt .= " left  join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
	$sqlt .= " left join `db_pir_grc`.`grc_atendimento_instrumento` grc_ai on grc_ai.idt = grc_e.idt_instrumento ";
	
	$sqlt .= " left join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_a.idt_produto ";
	
	$sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
	
	$sqlt .= " left  join `db_pir_grc`.`plu_usuario` plu_usu on plu_usu.id_usuario = grc_a.idt_avaliador ";
	
	//$sqlt .= " where grc_a.idt_formulario = 9 ";
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
	$sqlt .= " where grc_f.codigo = '700' ";
    
	
	
	$sqlt .= "   and grc_a.idt_produto = " . null($idt_produto);
	$sqlt .= " order by grc_ai.descricao, grc_e.codigo ";
	$rst   = execsql($sqlt);
	
	
	
	if ($rst->rows == 0)
	{
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		echo "<tr class=''>  ";
		echo "   <td colspan='7' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Produto sem Avaliação Estrelinha  ";
		echo "   </td> ";
		echo "</tr>";
		echo "</table>";

	}
	else
	{  
		foreach ($rst->data as $rowt) {
			$codigo    = $rowt['codigo_produto'];
			$descricao = $rowt['descricao_produto'];
			break;
		}
		
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		
		echo "<tr class=''>  ";
		echo "   <td colspan='7' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Produto: $codigo - $descricao ";
		echo "   </td> ";
		echo "</tr>";

		
        echo "<tr class=''>  ";
		
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Código Evento ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Descrição Evento ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Instrumento ";
		echo "   </td> ";
		
		
		/*
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Inicio ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Término ";
		echo "   </td> ";
		*/
		
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Cliente ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Comentário ";
		echo "   </td> ";
		
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Registro ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='width:155px;' >";
		echo "   Avaliação ";
		echo "   </td> ";
		echo "</tr>";

	    foreach ($rst->data as $rowt) {
			$codigo        = $rowt['codigo'];
			$descricao     = $rowt['descricao'];
			$instrumento   = $rowt['instrumento'];
			$data_registro = trata_data($rowt['data_registro']);
			$dt_previsao_inicial = trata_data($rowt['dt_previsao_inicial']);
			$dt_previsao_fim = trata_data($rowt['dt_previsao_fim']);
			
			$email_avaliador = $rowt['email_avaliador'];
			$nome_avaliador  = $rowt['nome_avaliador'];
			$telefone_avaliador = $rowt['telefone_avaliador'];
			$resposta_txt       = $rowt['resposta_txt'];
			$cliente            =$rowt['cliente_av'];

			$avaliacao     = $rowt['avaliacao'];
			echo "<tr class=''>  ";
			
			echo "   <td class='cb_texto' style='' >";
			echo $codigo;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $descricao;
			echo "   </td> ";
			
			echo "   <td class='cb_texto' style='' >";
			echo $instrumento;
			echo "   </td> ";
			
			/*
			echo "   <td class='cb_texto' style='' >";
			echo $dt_previsao_inicial;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $dt_previsao_fim;
			echo "   </td> ";
			*/
			$cli = $nome_avaliador;
			if ($cliente!="")
			{
				$cli = $cliente;
			}
			
			echo "   <td class='cb_texto' style='' >";
			echo $cli;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			//echo $resposta_txt." av ".$avaliacao;
			echo $resposta_txt;
			echo "   </td> ";
			
			
			
			
			echo "   <td class='cb_texto' style='' >";
			echo $data_registro;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
			echo $img;
			echo "   </td> ";
			echo "</tr>";
		}
		// Total
		echo "<tr class=''>  ";
		echo "   <td colspan='6' class='cb_texto' style='background:#F1F1F1; text-align:right;' >";
		echo 'Avaliação Média';
		echo "   </td> ";
		echo "   <td class='cb_texto' style='background:#F1F1F1;' >";
		$vet = AvaliacaoEstrelinhaMediaProduto($idt_produto);
		$avaliacao = $vet['media'];
		$img          = $vet['imagem'];

	//	p($vet);
//		$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
		echo $img;
		echo "   </td> ";
		echo "</tr>";
		echo "</table>"; 
	}
}














if ($opcao==3)
{
    $cpf   = $_GET['cpf'];
    $sqlt  = " select ";
	$sqlt .= " grc_e.codigo, ";
	$sqlt .= " grc_e.dt_previsao_inicial, ";
	$sqlt .= " grc_e.dt_previsao_fim, ";
	$sqlt .= " grc_ai.descricao as instrumento, ";
	
	$sqlt .= " grc_e.descricao, ";
	$sqlt .= " grc_a.data_registro, ";
	
	$sqlt .= " grc_a.email_avaliador, ";
	$sqlt .= " grc_a.nome_avaliador, ";
	$sqlt .= " grc_a.telefone_avaliador, ";
	$sqlt .= " grc_ar.resposta_txt, ";

	
	
	$sqlt .= " grc_fr.codigo as avaliacao, ";
	$sqlt .= " plu_usu.nome_completo as cliente ";
	$sqlt .= " from grc_avaliacao grc_a";
	$sqlt .= " inner join `db_pir_grc`.`grc_evento`   grc_e on grc_e.idt = grc_a.idt_evento ";
	$sqlt .= " inner join `db_pir_grc`.`grc_atendimento_instrumento` grc_ai on grc_ai.idt = grc_e.idt_instrumento ";
	
	$sqlt .= " inner join `db_pir_grc`.`grc_produto`  grc_p on grc_p.idt = grc_e.idt_produto ";
	$sqlt .= " inner join `db_pir_grc`.`grc_avaliacao_resposta`  grc_ar on grc_ar.idt_avaliacao = grc_a.idt ";
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario_resposta` grc_fr on grc_fr.idt = grc_ar.idt_resposta ";
	
	$sqlt .= " left  join `db_pir_grc`.`plu_usuario` plu_usu on plu_usu.id_usuario = grc_a.idt_avaliador ";
	
//	$sqlt .= " where grc_a.idt_formulario = 14 ";
	
	$sqlt .= " inner join `db_pir_grc`.`grc_formulario` grc_f on grc_f.idt = grc_a.idt_formulario ";
	$sqlt .= " where grc_f.codigo = '700' ";

	
	$sqlt .= "   and grc_a.cpf = " . aspa($cpf);
	$sqlt .= " order by grc_ai.descricao, grc_e.codigo ";
	$rst   = execsql($sqlt);
	
	if ($rst->rows == 0)
	{
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		echo "<tr class=''>  ";
		echo "   <td colspan='7' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Cliente sem Avaliação Estrelinha ";
		echo "   </td> ";
		echo "</tr>";
		echo "</table>";
	}
	else
	{  
		foreach ($rst->data as $rowt) {
			$cliente = $rowt['cliente'];
			break;
		}
		
	    echo "<table class='' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		
		echo "<tr class=''>  ";
		echo "   <td colspan='7' class='cb_texto_tit' style='background:#C0C0C0; color:#000000; text-align:left;' >";
		echo "   Cliente: $cpf - $cliente ";
		echo "   </td> ";
		echo "</tr>";

		
        echo "<tr class=''>  ";
		
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Código Evento ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Descrição Evento ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Instrumento ";
		echo "   </td> ";
		
		/*
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Inicio ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Término ";
		echo "   </td> ";
		*/ 
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Cliente ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Comentário ";
		echo "   </td> ";
		
		echo "   <td class='cb_texto_tit' style='' >";
		echo "   Data Registro ";
		echo "   </td> ";
		echo "   <td class='cb_texto_tit' style='width:155px;' >";
		echo "   Avaliação ";
		echo "   </td> ";
		echo "</tr>";

	    foreach ($rst->data as $rowt) {
			$codigo        = $rowt['codigo'];
			$descricao     = $rowt['descricao'];
			$instrumento   = $rowt['instrumento'];
			$data_registro = trata_data($rowt['data_registro']);
			
		
			
			
			$dt_previsao_inicial = trata_data($rowt['dt_previsao_inicial']);
			$dt_previsao_fim = trata_data($rowt['dt_previsao_fim']);

			$avaliacao     = $rowt['avaliacao'];
			echo "<tr class=''>  ";
			
			echo "   <td class='cb_texto' style='' >";
			echo $codigo;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $descricao;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $instrumento;
			echo "   </td> ";
		
		/*	
			echo "   <td class='cb_texto' style='' >";
			echo $dt_previsao_inicial;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $dt_previsao_fim;
			echo "   </td> ";
		*/	
		
		
		    $cli = $nome_avaliador;
			if ($cliente!="")
			{
				$cli = $cliente;
			}
			
			echo "   <td class='cb_texto' style='' >";
			echo $cli;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			echo $resposta_txt;
			echo "   </td> ";
			
			echo "   <td class='cb_texto' style='' >";
			echo $data_registro;
			echo "   </td> ";
			echo "   <td class='cb_texto' style='' >";
			$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
			echo $img;
			echo "   </td> ";
			echo "</tr>";
		}
		// Total
		echo "<tr class=''>  ";
		echo "   <td colspan='6' class='cb_texto' style='background:#F1F1F1; text-align:right;' >";
		echo 'Avaliação Média';
		echo "   </td> ";
		echo "   <td class='cb_texto' style='background:#F1F1F1;' >";
		$vet = AvaliacaoEstrelinhaMediaCliente($cpf);
		$avaliacao = $vet['media'];
		$img          = $vet['imagem'];
		//$img = AvaliacaoFazImagem($avaliacao,0,0,$cpf);
		echo $img;
		echo "   </td> ";
		echo "</tr>";
		echo "</table>"; 
	}
}


?>
<script type="text/javascript" >
function Detalha_Atendimento(idt_atendimento)
{
    alert('Chamar ficha do atendimento para consultar'+idt_atendimento);
    return false;
}
	
</script>
