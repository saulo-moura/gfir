<style>
</style>

<?php
////////////////// parte 1

$sql  = '';
$sql .= ' select grc_ndl.*';
$sql .= ' from grc_nan_devolutiva_link grc_ndl ';
//$sql .= ' where grc_nd.codigo = '.aspa('01');
$sql .= ' order by grc_ndl.codigo ';
$rs = execsql($sql);

 $background='#FF8000;';
 $color='#004080;';
 $width='100%';
 $width=$width.'%';
 $height='25px';
 $height=$height.'px';

echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";
 echo "<tr>";
 $stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
 echo "<tr>";
 echo "<td  style='{$stylo}' >";
 echo  'Fonte'; 
 echo "</td>";
 echo "<td  style='{$stylo}' >";
 echo  'Link'; 
 echo "</td>";
 echo "</tr>";
foreach ($rs->data as $row) {
    $codigo    = $row['codigo'];
	$descricao = $row['descricao'];
	$detalhe   = $row['detalhe'];
	$link      = $row['link'];
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
	echo "<tr>";
	echo "<td  style='{$stylo}' >";
	echo  $descricao; 
	echo "</td>";
	
	echo "<td  style='{$stylo}' >";
	echo  $link; 
	echo "</td>";
	echo "</tr>";

}
echo "</table>";

/*
$texto_2 =   "Além de navegar nos sites acima, os seguintes cursos à distância oferecidos pelo EAD Sebrae podem ser úteis para você e sua empresa:";
if ($texto_2!="")
{
	$background='#FFFFFF;';
	$color='#000000;';
	$width='100%';
	$width=$width.'%';
	$height='25px';
	$height=$height.'px';
    echo "<br />";
	echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
	echo "<tr>";
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
	echo "<tr>";
	echo "<td  style='{$stylo}' >";
	echo  $texto_2; 
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br />";

}


//////////////// parte 2

$sql  = '';
$sql .= ' select grc_ffe.*, grc_fa.descricao as grc_fa_descricao';
$sql .= ' from grc_formulario_ferramenta_ead grc_ffe ';
$sql .= ' inner join grc_formulario_area grc_fa on grc_fa.idt = grc_ffe.idt_area  ';
//$sql .= ' where grc_nd.codigo = '.aspa('01');
$sql .= ' order by grc_ffe.codigo ';
$rs = execsql($sql);

 $background='#FF8000;';
 $color='#004080;';
 $width='100%';
 $width=$width.'%';
 $height='25px';
 $height=$height.'px';

echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";
 echo "<tr>";
 $stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
 echo "<tr>";
 echo "<td  style='{$stylo}' >";
 echo  'Tema'; 
 echo "</td>";
 echo "<td  style='{$stylo} xwidth:300px;' >";
 echo  'Curso EAD'; 
 echo "</td>";
 echo "<td  style='{$stylo}' >";
 echo  'Solução'; 
 echo "</td>";
 echo "<td  style='{$stylo}' >";
 echo  'Link'; 
 echo "</td>";
 echo "</tr>";
foreach ($rs->data as $row) {
    $codigo    = $row['codigo'];
	$descricao = $row['descricao'];
	$detalhe   = $row['detalhe'];
	$solucao   = $row['solucao'];
	$link      = $row['link'];
	$grc_fa_descricao = $row['grc_fa_descricao'];
	
	$idt_area = $row['idt_area'];
	$serve = 0;
	$sql  = '';
	$sql .= ' select grc_naf.* ';
	$sql .= ' from grc_nan_area_x_foco_tematico grc_naf ';
	$sql .= ' where grc_naf.idt = '.null($idt_area);
	$rst = execsql($sql);
    foreach ($rst->data as $rowt) {
       $idt_tema_area = $rowt['idt_tema'];
	   if ( $kvetFocoP[$idt_tema_area] != '' )
	   {
	      $serve=1;
          break;		  
	   }
	}
	if ($serve==0)
	{
	    continue;
	}
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
	echo "<tr>";
	echo "<td  style='{$stylo}' >";
	echo  $grc_fa_descricao; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $descricao; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $solucao; 
	echo "</td>";
	echo "<td  style='{$stylo}' >";
	echo  $link; 
	echo "</td>";
	echo "</tr>";

}
echo "</table>";
*/