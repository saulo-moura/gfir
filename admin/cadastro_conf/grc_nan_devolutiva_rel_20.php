<style>
</style>

<?php


$sql  = '';
$sql .= ' select grc_ffg.*, grc_fa.descricao as grc_fa_descricao';
$sql .= ' from grc_formulario_ferramenta_gestao grc_ffg ';
$sql .= ' inner join grc_formulario_area grc_fa on grc_fa.idt = grc_ffg.idt_area  ';
//$sql .= ' where grc_nd.codigo = '.aspa('01');
$sql .= ' order by grc_ffg.codigo ';
$rs = execsql($sql);

 $background='#FF8000;';
 $color='#004080;';
 $width='100%';
 $width=$width.'%';
 $height='25px';
 $height=$height.'px';
 
  
 $vetAvaliacaoA = $vetAvaliacao['AFe'];
 $vetAvaliacaoL = $vetAvaliacao['LFe'];
 $vetAvaliacaoQ = $vetAvaliacao['QFe'];
 $vetAvaliacaoF = $vetAvaliacao['FFe'];
 
 $vetAvaliacaoFR = Array();;
   
 ForEach ($vetAvaliacaoF as $area => $verpergunta)
 {
	 ForEach ($verpergunta as $pergunta => $descricao_ferramenta)
	 {
		$vetAvaliacaoFR[$area][$pergunta]['desc'] = $descricao_ferramenta;
		$vetAvaliacaoFR[$area][$pergunta]['A']    = $vetAvaliacaoA[$area][$pergunta];
	}	
 } 
 
 
 $vetRank = $vetAvaliacao['RankO'];
 $vetFerramentas = Array();
 $qtd_ferramenta = 8;
 $qtd = 0;
 ForEach ($vetRank as $linha => $ferramenta)
 {
    $qtd = $qtd + 1;
	if ($qtd>8)
	{
	    break;
	}
	$vetFerramentas[$ferramenta]=$linha;
 }
 
 //p($vetFerramentas);
    
 //p($vetAvaliacaoFR);
 
 
echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";
 echo "<tr>";
 $stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
 echo "<tr>";
 echo "<td  style='{$stylo}' >";
 echo  'Área'; 
 echo "</td>";
 echo "<td  style='{$stylo} width:300px;' >";
 echo  'Ferramenta Recomendada'; 
 echo "</td>";
 echo "<td  style='{$stylo}' >";
 echo  'O que é'; 
 echo "</td>";
 echo "<td  style='{$stylo}' >";
 echo  'Página'; 
 echo "</td>";
 echo "</tr>";
 $vetFerr=Array();
foreach ($rs->data as $row) {
    $idt_ferramenta = $row['idt'];
    $codigo    = $row['codigo'];
	$descricao = $row['descricao'];
	$detalhe   = $row['detalhe'];
	$pagina    = $row['numero_pagina'];
	$grc_fa_descricao = $row['grc_fa_descricao'];
	
	if ($vetFerramentas[$descricao]=="")
	{
	    continue;
	}
	$vetFerr[$idt_ferramenta]=$descricao;
	
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
	echo "<tr>";
	echo "<td  style='{$stylo}' >";
	echo  $grc_fa_descricao; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $descricao; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $detalhe; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $pagina; 
	echo "</td>";
	echo "</tr>";

}
echo "</table>";

// p($vetFerr);
 
