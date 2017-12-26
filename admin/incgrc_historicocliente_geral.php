<style>
.atende_tb{

}
.atende_gc{
   background:#C4C9CD;
   color:#000000;
   border-bottom:1px solid #C0C0C0;
   padding:3px;
}
.atende_gc_linha{
   background:#FFFFFF;
   color:#000000;
   border-bottom:1px solid #C0C0C0;
   padding:3px;
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
</style>
<?php



$vetCliente=Array();
$vetClienteN=Array();
$html   = "";
$html  .= " <div  style='font-weight:bold; width:100%; color:#000000;background:#2F66B8; text-align:center; font-size:18px; color:#FFFFFF; bmargin-top:10px;  xborder-top:1px solid #000000; border-bottom:1px solid #000000; '>";
$html  .= " CLIENTES COM ATENDIMENTOS SEBRAE ";
$html  .= " </div> ";
//
//   Lista de Clientes Atendidos Pelo SEBRAE
//
$html .=  "<table class='atende_tb' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
$html .=  "<tr  style='' >  ";
$html .=  "   <td class='atende_gc'   style='padding-left:10px;  border-right:1px solid #C0C0C0; ' >Razão Social</td> ";
$html .=  "   <td class='atende_gc'   style='text-align:center; border-right:1px solid #C0C0C0; ' >CNPJ</td> ";
$html .=  "   <td class='atende_gc'   style='text-align:center; padding-right:10px;' >SiacWeb</td> ";
$html .=  "</tr>";
//
$sql  = 'select ';
$sql .= '  distinct ';
$sql .= '  siac_his.CodCliente as siac_his_CodCliente,  ';
$sql .= '  par_empre.CgcCpf           as par_empre_CgcCpf,  ';
$sql .= '  par_empre.NomeRazaoSocial  as par_empre_NomeRazaoSocial  ';
$sql .= '  from  '.db_pir_siac.'parceiro siac_par';
$sql .= '  INNER JOIN '.db_pir_siac.'historicorealizacoescliente siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
$sql .= "  inner join  ".db_pir_siac."sebrae sebrae            on sebrae.codsebrae      = siac_his.CodSebrae ";
$sql .= "  left  join  ".db_pir_siac."parceiro par_empre       on par_empre.CodParceiro = siac_his.codempreedimento ";
$sql .= '  order by par_empre.NomeRazaoSocial ';
$rs = execsql($sql);
if ($rs->rows == 0)
{
}
else
{
	ForEach ($rs->data as $row)
	{
		//
		$siac_his_CodCliente        = $row['siac_his_codcliente'];
		$par_empre_CgcCpf           = $row['par_empre_cgccpf'];
		$par_empre_NomeRazaoSocial  = $row['par_empre_nomerazaosocial'];
		$indice = $par_empre_CgcCpf.$par_empre_NomeRazaoSocial;
		$vetClienteSiac[$indice]=$siac_his_CodCliente;
		$vetCliente[$par_empre_CgcCpf]=$par_empre_NomeRazaoSocial;
		$vetClienteN[$par_empre_NomeRazaoSocial]=$par_empre_CgcCpf;
	}
}
$sql  = 'select ';
$sql .= '  distinct ';
$sql .= '  siac_his.CodCliente as siac_his_CodCliente,  ';
$sql .= '  par_empre.CgcCpf           as par_empre_CgcCpf,  ';
$sql .= '  par_empre.NomeRazaoSocial  as par_empre_NomeRazaoSocial  ';
$sql .= '  from  '.db_pir_siac.'parceiro siac_par';
$sql .= '  INNER JOIN '.db_pir_siac.'historicorealizacoescliente_anosanteriores siac_his ON siac_par.CodParceiro = siac_his.CodCliente';
$sql .= "  inner join  ".db_pir_siac."sebrae sebrae            on sebrae.codsebrae      = siac_his.CodSebrae ";
$sql .= "  left  join  ".db_pir_siac."parceiro par_empre       on par_empre.CodParceiro = siac_his.codempreedimento ";
$sql .= '  order by par_empre.NomeRazaoSocial ';
$rs = execsql($sql);
if ($rs->rows == 0)
{
}
else
{
	ForEach ($rs->data as $row)
	{
	    $siac_his_CodCliente        = $row['siac_his_codcliente'];
		$par_empre_CgcCpf           = $row['par_empre_cgccpf'];
		$par_empre_NomeRazaoSocial  = $row['par_empre_nomerazaosocial'];
		$indice = $par_empre_CgcCpf.$par_empre_NomeRazaoSocial;
		$vetClienteSiac[$indice]=$siac_his_CodCliente;
		$vetCliente[$par_empre_CgcCpf]=$par_empre_NomeRazaoSocial;
		$vetClienteN[$par_empre_NomeRazaoSocial]=$par_empre_CgcCpf;
	}
}
ksort($vetCliente);	
ksort($vetClienteN);	
$linha=0;

ForEach ($vetClienteN as $razao => $cnpj)
{
	$html .=  "<tr  style='' >  ";
	$linha=$linha+1;
	$indice = $cnpj.$razao;
	$siac_his_CodCliente = $vetClienteSiac[$indice];
	$onclick = "onclick = 'return DetalhaCliente({$siac_his_CodCliente},\"$cnpj\",\"$razao\");'";
	$html .=  "   <td $onclick class='atende_gc_linha' title='Detalha o Atendimento'   style='padding-left:10px; border-right:1px solid #C0C0C0;  color:#2A5696; cursor:pointer' >{$razao}</td> ";
	$html .=  "   <td class='atende_gc_linha'   style='border-right:1px solid #C0C0C0;  text-align:right; ' >{$cnpj}</td> ";
	$html .=  "   <td class='atende_gc_linha'   style='text-align:right; padding-right:10px;' >{$siac_his_CodCliente}</td> ";
	$html .=  "</tr>";
}    

$html .=  "<tr  style='' >  ";
$html .=  "   <td colspan='3' class='atende_gc'   style='' >Total de Clientes: {$linha}</td> ";
$html .=  "</tr>";
$html .=  "</table>";


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

function DetalhaCliente(siac_his_CodCliente , CNPJ, razao)
{
    // 
    // alert(' Detalha o Cliente '+' siac_his_CodCliente '+siac_his_CodCliente+' CNPJ '+CNPJ);
	//
    var razao_social = CNPJ+' - '+razao;
    var parww   = '&CodCliente='+siac_his_CodCliente+'&cnpj='+CNPJ+'&razao='+razao;
    var href    = 'conteudo_detalha_cliente.php?prefixo=inc&menu=detalha_lista_cliente'+parww;
	/*
    var  left   = 0;
    var  top    = 0;
    var  height = $(window).height();
    var  width  = $(window).width();
	top    = 0;
    left   = 0;
    width  = width;
    height = height;
    var titulo = "<div style='width:700px; display:block; text-align:center; '>Detalha CLIENTE - "+razao_social+"</div>";
    showPopWin(href, titulo , width, height, close_DetalhaCLIENTE);
	*/
	var left = 0;
	var top = 0;
	var height = $(window).height();
	var width = $(window).width();
	
	
	var width  = screen.width;
    var height = screen.height;
  
	

	var link = href;
	var nome_Tela = "";
	if (siac_his_CodCliente!='')
	{
	     nome_Tela = "ClienteDetalhadoPop"+siac_his_CodCliente;
    }
    else
    {
			if (CNPJ!="")
			{
			    nome_Tela = "ClienteDetalhadoPop"+siac_his_CodCliente;
			}
			else
			{
			    nome_Tela = "ClienteDetalhadoPop";
			}
    }
	ClienteDetalhadoPop = window.open(link, nome_Tela, "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",location=no,resizable=yes,menubar=no,scrollbars=yes,toolbar=no,alwaysLowered=yes,alwaysRaised=no,dependent=yes,directories=no,hotkeys=no,menubar=no,personalbar=no,scrollbars=yes,status=no,titlebar=no,z-lock=yes,titlebar=no");
	ClienteDetalhadoPop.focus();

	
	
	
	
	
    return false;
}

function close_DetalhaCLIENTE(returnVal) {
    // alert(returnVal);
    // var href = "conteudo_tipologia_medicao.php?prefixo=inc&menu=mapa_medicao&print=s&lupa=s&titulo_rel=&ampliar=S&origem=S&idt_empreendimento="+idt_empreendimento;
    // self.location =  href;

}
	
   

</script>
