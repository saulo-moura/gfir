<style>
</style>

<?php
$idt_avaliacao=$_GET['idt_avaliacao'];

$sql   = "select  ";
$sql  .= "   grc_a.*,  ";
$sql  .= "   grc_as.descricao as grc_as_descricao,  ";
$sql  .= "   gec_eclio.descricao as gec_eclio_descricao, ";
$sql  .= "   gec_eclip.descricao as gec_eclip_descricao, ";
$sql  .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
$sql  .= "   gec_ecrep.descricao as gec_ecrep_descricao ";
$sql  .= " from grc_avaliacao grc_a ";
$sql  .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
$sql .=  " where grc_a.idt = ".null($idt_avaliacao);
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $codigo              = $row['codigo'];
	$descricao           = $row['descricao']; 
	$data_avaliacao      = trata_data($row['data_avaliacao']); 
	$gec_eclio_descricao = $row['gec_eclio_descricao']; 
    $gec_eclip_descricao = $row['gec_eclip_descricao']; 
    $gec_ecreo_descricao = $row['gec_ecreo_descricao']; 
    $gec_ecrep_descricao = $row['gec_ecrep_descricao']; 
}

verificaInfAvaliacaoNAN($idt_avaliacao, $gec_ecreo_descricao, $gec_ecrep_descricao, $gec_eclio_descricao, $gec_eclip_descricao);

 $background='#FFFFFF;';
 $color='#000000;';
 $width='100%';
 $width=$width.'%';
 $height='25px';
 $height=$height.'px';

 echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
 //echo "<tr>";
 $stylo="border-bottom:1px solid #000000;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:12pt; color:$color; background:$background;";
 echo "<tr >";
 echo "<td colspan='2' style='{$stylo} width:300px;' >";
 echo  "<span style='' ><b>Empresa: {$gec_eclio_descricao}</b></span>"; 
 echo "</td>";
 echo "</tr>";
 echo "<tr>";
 echo "<td  style='{$stylo} width:50%; border-right:1px solid #000000; ' >";
 echo  "<b>Data do Diagnóstico:{$data_avaliacao}</b>"; 
 echo "</td>";
 echo "<td  style='{$stylo} width:50%;' >";
 echo  "<b>Cliente:{$gec_eclip_descricao}</b>"; 
 echo "</td>";
 echo "</tr>";
 echo "<tr>";
 echo "<td  colspan='2' style='{$stylo}' >";
 echo  "<b>Agente de Orientação Empresarial:{$gec_ecrep_descricao}</b>"; 
 echo "</td>";
 echo "</tr>";
 echo "</table>";
