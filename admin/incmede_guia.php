<style>
.guia_cab{
   background:#ECF0F1;
   color:#000000;
   border-bottom:1px solid #FFFFFF;

   padding:15px;
   
}
.guia_lin{
   background:#F1F1F1;
   color:#000000;
   border-bottom:1px solid #FFFFFF;
   padding:5px;
}
.guia_radio {
   background:#FFFFFF;
   color:#000000;
   width:22px;
   height:22px;
    padding-left:10%;

}
.botao {
	background:#2E66B7;
	color:#FFFFFF;
	height:40px;
	wheight:150px;
	text-align:center;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-style: normal;
	font-weight: bold;
	border-radius: 0.5em;
    cursor:pointer;
}

.botao_b {
	background:#F9F9F9;
	color:#666666;
	height:40px;
	wheight:150px;
	text-align:center;
	font-family: Calibri, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-style: normal;
	font-weight: bold;
	border-radius: 0.5em;
    cursor:normal;
	display:none;
}


.guia_rod {
   background:#F1F1F1;
   color:#FFFFFF;

}

.guia_tb {
   background:#2c3e50;
   color:#F1F1F1;
   margin-left:15%;

}
.guia_obs {
   background:#ECF0F1;
   color:#666666;
   padding:15px;

}


#passo_0 {
   margin-top:20px;
   

}
#passo_1 {
   margin-top:20px;
   display:none;
   

}

#guia_2 {
	background:#F9F9F9;
	color:#666666;

	margin-top:10px;
	display:none;
}
#guia_6 {
	background:#F9F9F9;
	color:#666666;

	margin-top:10px;
	display:none;
}
.guia_select2 {
   	padding:15px;

}
.select_porte {
   margin-left:15px;
   border:0;
   border-bottom:1px solid #C0C0C0;
   height:25px;
   font-size:14px;
   cursor:pointer;
}
.guia_texto6 {
   height:50px;
}
</style>
<?php
    $pergunta_texto  ="";
	$pergunta_texto .="Por favor, para iniciar a avaliação escolha abaixo uma das opções: ";
	
	
	$html  = "";
	$html .= "<div id='passo_0'>";
    $sql  = 'select ';
    $sql .= '  grc_fg.*  ';
    $sql .= '  from  grc_formulario_guia grc_fg';
    $sql .= '  order by codigo ';
    $rs = execsql($sql);
    if ($rs->rows == 0)
    {
        $html  .= "  Erro não achou Guia para Avaliação  ";
    }
    else
    {
		$html .=  "<table class='guia_tb' width='70%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		$html .=  "<tr  style='' >  ";
		$html .=  "   <td class='guia_cab'   style='width:20px;' ></td> ";
		$html .=  "   <td class='guia_cab'   style='' >{$pergunta_texto}</td> ";
		$html .=  "</tr>";

        ForEach ($rs->data as $row)
        {
		    $idt_guia        = $row['idt'];
            $codigo          = $row['codigo'];
            $descricao       = $row['descricao'];
            $detalhe         = $row['detalhe'];
			$idt_porte       = $row['idt_porte'];
			$idt_formulario  = $row['idt_formulario'];
			$html .=  "<tr  style='' >  ";
			$onclick = " onclick='return EscolhaOpcao(this);' ";
			$escolha = "<input {$onclick} class='guia_radio' title='{$detalhe}'  id='id{$idt_guia}' type='radio' name='opcao' value='{$idt_guia}'>";
			$html .=  "   <td class='guia_lin'   style='' >{$escolha}</td> ";
			$html .=  "   <td class='guia_lin'   style='' >{$descricao}</td> ";
			$html .=  "</tr>";
			if ($idt_guia==2)
			{ // abrir opcao para entrar com dados
				$html .=  "<tr  id='guia_2' style='' >  ";
				$onchange = " onchange='return EscolhaCampo2(this);' ";
				
				$htmls  = "";
				$htmls .=  "Faturamento Anual:";
				$htmls .=  "<select {$onchange} class='select_porte'  >";
				$htmls .=  "<option value='{$idt_porte_formulario}'>Informe a sua faixa de Faturamento Anual</option>";
				$sqlw = '';
				$sqlw .= ' select grc_fp.idt as grc_fp_idt , gec_p.idt as gec_p_idt, gec_p.descricao, gec_p.desc_vl_cmb';
				$sqlw .= ' from '.db_pir_gec.'gec_organizacao_porte gec_p ';
				$sqlw .= ' inner join grc_formulario_porte grc_fp on grc_fp.idt_porte = gec_p.idt ';
				$sqlw .= " where gec_p.codigo in ('2', '3', '99')";
				$sqlw .= ' order by gec_p.descricao, gec_p.desc_vl_cmb';
				$rsw = execsql($sqlw);
				ForEach ($rsw->data as $roww)
				{
				    $gec_p_idt            = $roww['gec_p_idt'];
					$idt_porte_formulario = $roww['grc_fp_idt'];
					$desc_vl_cmb          = $roww['desc_vl_cmb'];
					$htmls .=  "<option value='{$idt_porte_formulario}'>{$desc_vl_cmb}</option>";
                }
				$htmls .=  "</select>";
				//$escolha = "<input  class='guia_texto' title='{$detalhe}'  id='id{$idt_guia}' type='text' name='texto_guia' value=''>";
				$escolha = $htmls;
				$html .=  "   <td class='guia_select2'   style='' ></td> ";
				$html .=  "   <td class='guia_select2'   style='' >{$escolha}</td> ";
				$html .=  "</tr>";
			}
			if ($idt_guia==6)
			{
				$html .=  "<tr  id='guia_6' style='' >  ";
				$onclick = " onclick='return EscolhaCampo6(this);' ";
				//$escolha = "<input  class='guia_texto' title='{$detalhe}'  id='id{$idt_guia}' type='text' name='texto_guia' value=''>";
				
				
				$sim = "<input {$onclick} class='guia_radio' title=''  id='id_sim' type='radio' name='opcaosn' value='Sim'>Sim";
			    $nao = "<input {$onclick} class='guia_radio' title=''  id='id_nao' type='radio' name='opcaosn' value='Não'>Não";
			    $escolha = " Voce tem conhecimento para responder sobre questões da empresa? ".$sim.$nao;
				
				$html .=  "   <td class='guia_texto6'   style='' ></td> ";
				$html .=  "   <td class='guia_texto6'   style='' >{$escolha}</td> ";
				$html .=  "</tr>";
			}
			
        }
		
		
		$observacao = "informe uma das opções.";
		$html .=  "<tr  style='' >  ";
		$html .=  "   <td class='guia_obs'   style='' ></td> ";
		$html .=  "   <td id='idguia_obs' class='guia_obs'   style='' >{$observacao}</td> ";
		$html .=  "</tr>";

		
		
		$onclick = " onclick='return Passo_1();' ";
		$botao = "<input {$onclick} class='botao_b' title=''  id='idbtc' type='buttom' name='continuar' value='Continuar'>";
		$html .=  "<tr  style='' >  ";
		$html .=  "   <td class='guia_rod'   style='' ></td> ";
		$html .=  "   <td class='guia_rod'   style='' >{$botao}</td> ";
		$html .=  "</tr>";

		
		$html .=  "</table> ";
    }
	$html .= "</div>";
	$pergunta2_texto="Continuar diálogo";
	
	$html .= "<div id='passo_1'>";
	$html .=  "<table class='guia_tb' width='70%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
	$html .=  "<tr  style='' >  ";
	$html .=  "   <td class='guia_cab'   style='width:20px;' ></td> ";
	$html .=  "   <td colspan='2' class='guia_cab'   style='' >{$pergunta2_texto}</td> ";
	$html .=  "</tr>";

	
	$botao  = "<input class='botao' title=''  id='idb{$idt_guia}' type='buttom' name='continuar' value='Continuar'>";
	$botaor = "<input class='botao' title=''  id='idbr{$idt_guia}' type='buttom' name='retornar' value='Retornar'>";
	$html .=  "<tr  style='' >  ";
	$html .=  "   <td class='guia_rod'   style='' ></td> ";
	
	$onclick = " onclick='return Passo_0();' ";
	$html .=  "   <td {$onclick} class='guia_rod'   style='' >{$botaor}</td> ";
	$html .=  "   <td class='guia_rod'   style='' >{$botao}</td> ";
	$html .=  "</tr>";

	
	$html .=  "</table> ";
	
	
	$html .= "</div>";
    //
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
/*
function DetalhaAtendimento(CodCliente,DataHoraInicioRealizacao,linha)
{
   //alert(' Detalha o atendimento '+CodCliente+" Hora "+DataHoraInicioRealizacao);
   //
   // CHAMAR O DETALHAMENTO DO ATENDIMENTO
   //
   var str="";
   var titulo = "Detalhar Histórico de Atendimento. Aguarde...";
   processando_grc(titulo,'#2F66B8');

   $.post('ajax_atendimento.php?tipo=DetalharHistorico', {
      async: false,
      CodCliente                : CodCliente,
      DataHoraInicioRealizacao  : DataHoraInicioRealizacao,
      linha                     : linha
   }
   , function (str) {
       if  (str == '') {
            alert('Erro detalhar historico '+str);
            processando_acabou_grc();
       } else {
            var id='detalhehistr_'+linha;
            objtp = document.getElementById(id);
            if (objtp != null) {
                $(objtp).show();
            }
            var id='detalhehistd_'+linha;
            objtp = document.getElementById(id);
            if (objtp != null) {
                objtp.innerHTML=str;
            }
            processando_acabou_grc();
       }
   });



    return false;
}

function  FechaDetalhe(linha)
{
    var id='detalhehistr_'+linha;
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).hide();
    }
}


*/

var escolha_opcao = 0;
var qual_escolha  = 0;

function  Passo_0()
{
    var id='passo_0';
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).show();
    }
	var id='passo_1';
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).hide();
    }
}



function  Passo_1()
{
    if  (escolha_opcao==0)
	{
	    alert('Atenção!\nPor favor, escolha uma das opções.');
	    return false;
	}


    var id='passo_0';
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).hide();
    }
	var id='passo_1';
    objtp = document.getElementById(id);
    if (objtp != null) {
        $(objtp).show();
    }
}

function  EscolhaOpcao(thisw)
{
    
	qual_escolha = thisw.value;
	if (qual_escolha==1)
	{
	    
	}
	if (qual_escolha==2)
	{
	    var id ='guia_6';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).hide();
		}
		var id ='guia_2';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).show();
		}
	}
	if (qual_escolha==3)
	{
		
	}
	if (qual_escolha==4)
	{
		
	}
	if (qual_escolha==5)
	{
		
	}
	if (qual_escolha==6)
	{
		var id ='guia_2';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).hide();
		}
		var id ='guia_6';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).show();
		}
	
	}
	if (qual_escolha==1 || qual_escolha==3 || qual_escolha==4 || qual_escolha==5)
	{
	    var id ='guia_2';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).hide();
		}
	    var id ='guia_6';
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).hide();
		}
	
	
	    escolha_opcao = 1;
		id = "idbtc";
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).show();
			$(objtp).removeClass('botao_b');
			$(objtp).addClass('botao');
			id = "idguia_obs";
			obj = document.getElementById(id);
			if (obj != null) {
				obj.innerHTML="Observe que vc já escolheu a sua Opção, clicar em Continuar para prosseguir com a Avaliação";
			}
		}
	}
	else
	{
	    escolha_opcao = 0;
		id = "idbtc";
		objtp = document.getElementById(id);
		if (objtp != null) {
			$(objtp).hide();
			$(objtp).removeClass('botao_b');
			$(objtp).removeClass('botao');
			//$(objtp).addClass('botao_b');
			id = "idguia_obs";
			obj = document.getElementById(id);
			if (obj != null) {
				obj.innerHTML="Observe que vc já escolheu a sua Opção, clicar em Continuar para prosseguir com a Avaliação";
			}
		}

	}
}

function EscolhaCampo2(thisw)
{

	escolha_opcao = 1;
	id = "idbtc";
	objtp = document.getElementById(id);
	if (objtp != null) {
		$(objtp).show();
		$(objtp).removeClass('botao_b');
		$(objtp).addClass('botao');
		id = "idguia_obs";
		obj = document.getElementById(id);
		if (obj != null) {
			obj.innerHTML="Observe que vc já escolheu a sua Opção, clicar em Continuar para prosseguir com a Avaliação";
		}
	}


}
</script>
