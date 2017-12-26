<style>
 .funil_fase {
    cursor:pointer;
 }
</style>

<?php

if ($_GET['funil_idt_cliente_classificacao']!="")
{
//p("3333 zzzzzzzzzzzzz-------------- ".$funil_idt_cliente_classificacao);
  //  $funil_idt_cliente_classificacao=$_GET['funil_idt_cliente_classificacao'];
}
//p("3333-------------- ".$funil_idt_cliente_classificacao);
if ($funil_idt_cliente_classificacao=='')
{
	//$funil_idt_cliente_classificacao=3;
}
$width_fase=$_GET['width_fase'];
if ($width_fase=='')
{
    $width_fase='120px';
}
$height_fase=$_GET['height_fase'];
if ($height_fase=='')
{
    $height_fase='45px';
}
$funil_bgc_cor = "#FFFFFF";
$funil_txt_cor = "#000000";
$descricao     = "";
$sqlt  = " select grc_ff.idt, ";
$sqlt .= "        grc_ff.codigo, ";
$sqlt .= "        grc_ff.descricao, ";
$sqlt .= "        grc_ff.nome, ";
$sqlt .= "        grc_ff.cordafase, ";
$sqlt .= "        grc_ff.cortextfase, ";
$sqlt .= "        grc_ff.detalhe ";
$sqlt .= " from ".db_pir_grc."grc_funil_fase grc_ff ";
$sqlt .= " order by codigo ";
$rst   = execsql($sqlt);

echo "<br />";
echo "<table border='1' cellspacing='0' cellpadding='1' width='100%' style='width:100%; ' >";
echo "<tr>";
echo "<td colspan='6' style='font-size:18px; background:#2F65BB; color:#FFFFFF; text-align:center; font-weight: bold;  ' >";
echo "FUNIL DE ATENDIMENTO";
echo "</td>"; 
echo "</tr>";

if ($rst->rows==0)
{
	$funil_bgc_cor = "#FF0000";
	$funil_txt_cor = "#FFFFFF";
	$descricao     = "ERRO";
}
else
{

    $rowcol=" rowspan='2' ";
    echo "<tr>";

	foreach ($rst->data as $rowt) {
		$idt           = $rowt['idt'];
		$codigo        = $rowt['codigo'];
		$descricao     = $rowt['descricao'];
		$nome          = $rowt['nome'];
		$cordafase     = '#'.$rowt['cordafase'];
		$cortextfase   = '#'.$rowt['cortextfase'];
		$detalhe       = $rowt['detalhe'];
		$funil_bgc_cor = $cordafase;
		$funil_txt_cor = $cortextfase;
		$descricaow = str_replace('CLIENTE ','',$descricao);
		$hint = "Clique para visualizar a Descrição e a Orientação Técnica";
		if ($codigo>'02')
		{
		    break;
		}
		if ($funil_idt_cliente_classificacao==$idt)
		{
		    echo "<td id='mostraclassificacaoatual'{$rowcol}  style='width:16%; background:{$funil_bgc_cor}; color:{$funil_txt_cor};'>";
        	echo " <div title='$hint' class='funil_fase' onclick='return AbreFaseFunil($idt);'>";
			echo " <div id='mostraclassificacaoatual2' style='text-align:center; font-weight: bold; xwidth:{$width_fase}; background:{$funil_bgc_cor}; color:{$funil_txt_cor}; '>";
			echo " {$descricaow}";
			echo " </div>";
			echo " </div>";
			
			echo "</td>";

		}
		else
		{
		    echo "<td {$rowcol} style='width:16%;  background:#FFFFFF; color:#000000; text-align:center; font-weight: bold; width:{$width_fase}; '>";
        	echo " <div title='$hint' class='funil_fase' onclick='return AbreFaseFunil($idt);' >";
			echo " <div style='text-align:center; font-weight: bold; xwidth:{$width_fase}; xbackground:#FFFFFF; xcolor:#000000; '>";
			echo " {$descricaow}";
			echo " </div>";
			echo " </div>";
			echo "</td>";
		}
	}
	echo "<td colspan='4' style='padding:5px; background:#F5F5F5;  color:#000000; text-align:center; font-weight: bold;  '>";
	echo "CLIENTE";
 	echo "</td>";
	echo "</tr>";
    echo "<tr>";
	$rowcol='';
	foreach ($rst->data as $rowt) {
		$idt           = $rowt['idt'];
		$codigo        = $rowt['codigo'];
		$descricao     = $rowt['descricao'];
		$nome          = $rowt['nome'];
		$cordafase     = '#'.$rowt['cordafase'];
		$cortextfase   = '#'.$rowt['cortextfase'];
		$detalhe       = $rowt['detalhe'];
		$funil_bgc_cor = $cordafase;
		$funil_txt_cor = $cortextfase;
		$descricaow = str_replace('CLIENTE ','',$descricao);
		if ($codigo>'02')
		{
		    $rowcol='';
			if ($funil_idt_cliente_classificacao==$idt)
			{
				echo "<td {$rowcol} style='width:16%; padding:5px; background:{$funil_bgc_cor}; color:{$funil_txt_cor};'>";
				echo " <div title='$hint' class='funil_fase' onclick='return AbreFaseFunil($idt);'>";
				echo " <div style='text-align:center; font-weight: bold; xwidth:{$width_fase};  '>";
				echo " {$descricaow}";
				echo " </div>";
				echo " </div>";
				echo "</td>";
			}
			else
			{
				echo "<td {$rowcol} style='width:16%; padding:5px; background:#FFFFFF; color:#000000; text-align:center; font-weight: bold; width:{$width_fase}; '>";
				echo " <div title='$hint' class='funil_fase' onclick='return AbreFaseFunil($idt);' >";
				echo " <div style='text-align:center; font-weight: bold; width:{$width_fase}; background:#FFFFFF; color:#000000; '>";
				echo " {$descricaow}";
				echo " </div>";
				echo " </div>";
				echo "</td>";
			}
		}
	}
	echo "</tr>";
}
echo "</table>";







?>
<script>
    $(document).ready(function () {
        
    });
	function AbreFaseFunil(funil_idt_cliente_classificacao)
	{
	    //alert('Popup de '+funil_idt_cliente_classificacao);
		 
        var tamw = $('div.showPopWin_width').width() - 50;
        var url = 'conteudo_funil_orientacao.php?prefixo=&menu=&funil_idt_cliente_classificacao=' + funil_idt_cliente_classificacao;
        var titulo = "<div style='display:block; width:"+tamw+"px; text-align:center; '>FUNIL DE ATENDIMENTO - ORIENTAÇÃO TÉCNICA</div>";
        showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 40, null, true);
        return false;
	}
</script>