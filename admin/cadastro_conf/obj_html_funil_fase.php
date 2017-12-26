<?php
//$funil_idt_cliente_classificacao=$_GET['funil_idt_cliente_classificacao'];
if ($funil_idt_cliente_classificacao=='')
{
	//$funil_idt_cliente_classificacao=3;
}

//p($_GET);


$width_fase=$_GET['width_fase'];
if ($width_fase=='')
{
    $width_fase='120px;';
}
$height_fase=$_GET['height_fase'];
if ($height_fase=='')
{
    $height_fase='40px;';
}
$paddi_fase=$_GET['paddi_fase'];
if ($height_fase=='')
{
    $paddi_fase='10px;';
}
$vetParametro=Array();
$vetParametro['funil_idt_cliente_classificacao']=$funil_idt_cliente_classificacao;
$vetParametro['width_fase']  = $width_fase;
$vetParametro['height_fase'] = $height_fase;
$vetParametro['paddi_fase']  = $paddi_fase;


//p($vetParametro);

FunilExibeClassificacao($vetParametro);
$html = $vetParametro['html'];
echo $html;

/*
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
$sqlt .= " where grc_ff.idt = ".null($funil_idt_cliente_classificacao);
$rst   = execsql($sqlt);
if ($rst->rows==0)
{
	$funil_bgc_cor = "#FF0000";
	$funil_txt_cor = "#FFFFFF";
	$descricao     = "ERRO";
}
else
{
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
	}
}	
$html  = "";
$html .= " <div class='funil_fase' onclick='return AbreFaseFunil($funil_idt_cliente_classificacao);'>";
$html .= " <div style='height:{$height_fase}; padding:3px; text-align:center; font-weight: bold; width:{$width_fase}; background:{$funil_bgc_cor}; color:{$funil_txt_cor}; '>";
$html .= " <div style='padding:{$paddi_fase};'>{$descricao}</div>";
$html .= " </div>";
$html .= " </div>";
if ($funil_em_html=="S")
{
    $funil_texto_html=$html;
}
else
{
    echo $html;
}

*/


?>
<script>
    $(document).ready(function () {
        
    });
</script>