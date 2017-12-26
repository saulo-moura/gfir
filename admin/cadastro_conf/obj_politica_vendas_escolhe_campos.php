<style>
 .escolha_tabela {
    cursor:pointer;
 }
</style>

<?php

echo "<table border='1' cellspacing='0' cellpadding='1' width='99%' style='' >";
echo "<tr>";
if ($veio=='M')
{
    $cols='2';
}
else
{
    $cols='2';
}
echo "<td colspan='{$cols}' style='font-size:14px; background:#F1F1F1; color:#000000; text-align:center; font-weight: normal;  ' >";
echo "PARA SELECIONAR UM CAMPO PARA CONDIÇÃO, PRIMEIRO,  ESCOLHA A TABELA";
echo "</td>"; 
echo "</tr>";
echo "<tr>";
$hint = 'Clique para Selecionar a Tabela';

if ($veio=='M')
{
	$onclick=" onclick='return EscolheTabela(3);' ";
	echo "<td title='{$hint}' {$onclick} class='escolha_tabela' style='font-size:12px; background:#D1D1D1; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "CLIENTE PF";
	echo "</td>"; 
	$onclick=" onclick='return EscolheTabela(3);' ";
	echo "<td title='{$hint}' {$onclick} class='escolha_tabela' style='font-size:12px; background:#D1D1D1; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "CLIENTE PJ";
	echo "</td>"; 
}
else
{
    $onclick=" onclick='return EscolheTabela(1);' ";
	echo "<td title='{$hint}' {$onclick} class='escolha_tabela' style='font-size:12px; background:#D1D1D1; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "EVENTO";
	echo "</td>";
	$onclick=" onclick='return EscolheTabela(2);' ";
	echo "<td title='{$hint}' {$onclick} class='escolha_tabela' style='font-size:12px; background:#D1D1D1; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "PRODUTO";
	echo "</td>"; 
	 
}
echo "</tr>";
echo "</table>";

/*
$idt_politica_parametro_tabelas=1;
$sqlt  = " select grc_ppc.* ";
$sqlt .= " from ".db_pir_grc."grc_politica_parametro_campos grc_ppc ";
$sqlt .= " where idt_politica_parametro_tabelas = ".null($idt_politica_parametro_tabelas);
$sqlt .= "   and ativo = ".aspa('S');
$sqlt .= " order by codigo ";
$rst   = execsql($sqlt);

echo "<table border='1' cellspacing='0' cellpadding='1' width='100%' style='width:100%; ' >";

if ($rst->rows==0)
{
}
else
{
    if ($idt_politica_parametro_tabelas==1)
	{
		$tabela_escolhida='EVENTO';
	}
	if ($idt_politica_parametro_tabelas==2)
	{
		$tabela_escolhida='PRODUTOS';
	}
	if ($idt_politica_parametro_tabelas==3)
	{
		$tabela_escolhida='CLIENTES';
	}	
	echo "<tr>";
	echo "<td colspan='2' style='font-size:14px; background:#C0C0C0; color:#FFFFFF; text-align:left; font-weight: normal;  ' >";
	echo "ESCOLHA O CAMPO PARA A TABELA ".$tabela_escolhida;
	echo "</td>"; 
	echo "</tr>";
	echo "<tr>";
	echo "<td style='font-size:12px; background:#F1F1F1; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "CÓDIGO";
	echo "</td>"; 
	echo "<td style='font-size:12px; background:#C0C0C0; color:#000000; text-align:center; font-weight: normal;  ' >";
	echo "DESCRIÇÃO";
	echo "</td>"; 
	echo "</tr>";
	$hint = 'Clique para Selecionar o Campo';
	foreach ($rst->data as $rowt) {
	    $idt       = $rowt['idt'];
		$codigo    = $rowt['codigo'];
		$descricao = $rowt['descricao'];
		echo "<tr>";
		$onclick = " onclick='return EscolheCampo($idt);' ";
		echo "<td title='{$hint}' id='codigo_{$idt}' {$onclick} class='escolha_tabela' style='font-size:18px; background:#FFFFFF; color:#000000; text-align:left; font-weight: normal;  ' >";
		echo $codigo;
		echo "</td>"; 
		echo "<td style='font-size:18px; background:#FFFFFF; color:#000000; text-align:left; font-weight: normal;  ' >";
		echo $descricao;
		echo "</td>"; 
		echo "</tr>";
	}
}
echo "</table>";
*/


echo "<div id='IDEscolheCampos' style='width:99%;'>";
echo "</div>";



?>
<script>
    $(document).ready(function () {
        
    });
	/*
	function AbreFaseFunil(funil_idt_cliente_classificacao)
	{
	    //alert('Popup de '+funil_idt_cliente_classificacao);
		 
        var tamw = $('div.showPopWin_width').width() - 50;
        var url = 'conteudo_funil_orientacao.php?prefixo=&menu=&funil_idt_cliente_classificacao=' + funil_idt_cliente_classificacao;
        var titulo = "<div style='display:block; width:"+tamw+"px; text-align:center; '>FUNIL DE ATENDIMENTO - ORIENTAÇÃO TÉCNICA</div>";
        showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, null, true);
        return false;
	}
	*/
	function EscolheTabela(opcao)
	{
	    // alert('Opção '+opcao);
		var str="";
		$.post('ajax_grc.php?tipo=EscolherCampo', {
		  async   : false,
		  opcao   : opcao
		}
		, function (str) {
		   if (str == '') {
			   alert(' Não montou o html ');
		   } else {
		       //alert(' html '+str);
			   var id='IDEscolheCampos';
			   obj = document.getElementById(id);
			   if (obj != null) {
				   obj.innerHTML = str;
				   TelaHeight();
			   }
		   }
		});
		return false;
	}
	function EscolheCampo(idt)
	{
	    var id = 'codigo_'+idt;
		var codigo_c = "";
		objtp = document.getElementById(id);
		if (objtp != null) {
		   codigo_c = objtp.innerHTML;
		}
		var id = 'codigo';
		objtp = document.getElementById(id);
		if (objtp != null) {
		   objtp.value = codigo_c;
		}
		return false;
	}
</script>