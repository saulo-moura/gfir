<?php
/*
<style type="text/css">
.cabp {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.cabs {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.linha {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   background:#FFFFFF;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.intro {

   border-left :1px solid #000000;
   border-right:1px solid #000000;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
 

}
.imgc {
   border-top  :1px solid #000000;
   border-left :1px solid #000000;
   border-right:1px solid #000000;

}

.radap {
   border-top :1px solid #000000;
   border-left :1px solid #000000;
   border-right:1px solid #000000;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
 

}

.imgd {
   border-top    :1px solid #000000;
   border-left   :1px solid #000000;
   border-right  :1px solid #000000;
   border-bottom :1px solid #000000;

}
.semservico {
  padding:15px;
  background:#FF0000;
  font-family: Calibri, Arial, "Courier New", Courier, monospace;
  font-size: 18px;
  text-align:center;
  color:#FFFFFF;
}
</style>
*/

/////////////////


$idt_servico               = $_GET['idt_servico'];
$idt_atendimento           = $_GET['idt_atendimento'];
$idt_atendimento_pendencia = $_GET['idt_atendimento_pendencia'];

//echo "$idt_servico == $idt_atendimento";

//$idt_servico     = 10;
//$idt_atendimento = 1436;


//
// Obter Formulário para impressão
//
$sql  = 'select ';
$sql .= '   grc_ae.*, grc_aea.*  ';
$sql .= ' from grc_atendimento_especialidade grc_ae ';
$sql .= ' inner join grc_atendimento_especialidade_acao grc_aea on grc_aea.idt_especialidade = grc_ae.idt';
$sql .= " where grc_ae.idt = ".null($idt_servico);
$rs   = execsql($sql);
if ($rs->rows > 0) {
	// echo " to fora <br>";
	foreach ($rs->data as $row) {
		$codigo           = $row['codigo'];
		$descricao        = $row['descricao'];
		$arquivo_cab      = $row['arquivo_cab'];
		$introducao_texto = $row['introducao_texto'];
		$observacao_texto = $row['observacao_texto'];
		$arquivo_rod      = $row['arquivo_rod'];
		$cor              = $row['cor'];
		$largura          = $row['largura'];
    }
}
else
{
   if ($idt_servico>0)
   {
	   echo "<div class='semservico'>";
	   echo "Relatório não esta Parametrizado para o serviço solicitado - Serviço ".$idt_servico;
	   echo "</div>";
   }
   else
   {
	   echo "<div class='semservico'>";
	   echo "Por favor, para visualizar Relatório de Devolutiva o campo de Serviço tem que estar informado.";
	   echo "</div>";
   }
   exit();
}
$path = "obj_file/grc_atendimento_especialidade_acao/";
$arquivo_cabw = $path.$arquivo_cab;
$arquivo_rodw = $path.$arquivo_rod;


//		$cor              = $row['cor'];
//		$largura          = $row['largura'];
		
$larguraw="";		
if ($largura!='')
{
   $larguraw="100%";		
}
$corw="";		
if ($cor!='')
{
   $corw="#FFFFFF";		
}


$larguraw = "700";		
$corw     = "#00FF00";	

$larguraw = $larguraw;

$largura_imagem='698';
$altura_imagem='';

if ($gravadevolutivapdf=="S")
{
   // Direcionar html para buffer
   //echo " Direcionar html para buffer <br />"; 
   ob_start();
  //  Require_Once($Require_Once);
}


?>


<style type="text/css">
.cabp {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.cabs {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.linha {
   border-top :1px solid #000000;
   border-left:1px solid #000000;
   border-right:1px solid #000000;
   padding:5px;
   background:#FFFFFF;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   
}
.intro {

   border-left :1px solid #000000;
   border-right:1px solid #000000;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
 

}
.imgc {
   border-top  :1px solid #000000;
   border-left :1px solid #000000;
   border-right:1px solid #000000;

}

.radap {
   border-top :1px solid #000000;
   border-left :1px solid #000000;
   border-right:1px solid #000000;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
 

}

.imgd {
   border-top    :1px solid #000000;
   border-left   :1px solid #000000;
   border-right  :1px solid #000000;
   border-bottom :1px solid #000000;

}
.semservico {
  padding:15px;
  background:#FF0000;
  font-family: Calibri, Arial, "Courier New", Courier, monospace;
  font-size: 18px;
  text-align:center;
  color:#FFFFFF;
}
</style>

<?php

//
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
if ($arquivo_cab!="")
{
	echo "<tr class=''>  ";
	//$largura_imagems='800';
	$imgcab="<img width='{$largura_imagem}' height='{$altura_imagem}' border='0' src='{$arquivo_cabw}'/>";
	echo "   <td colspan='3' class='imgc' style='' >{$imgcab}</td> ";
	echo "</tr>";
}
if ($introducao_texto!="")
{
	echo "<tr class=''>  ";
	echo "   <td colspan='3'  class='intro' style='background:{$corw}; width:{$larguraw}; ' >";
	echo "   <div style='background:{$corw}; padding:10px;  xmargin-top:10px; margin-bottom:10px;' >";
	echo "   {$introducao_texto}";
	echo "   </div>";
	echo "   </td> ";
	echo "</tr>";
}
//
// Conteúdo do relatório
//
// Pegar do Atendimento e cadastro de PF e PJ
//
$sql  = 'select ';
$sql .= '   grc_a.*, grc_ao.*, grc_ap.*, grc_am.descricao as grc_am_descricao, plu_usu.nome_completo as plu_usu_nome_completo, grc_ts.descricao as grc_ts_descricao  ';
$sql .= ' from grc_atendimento grc_a ';
//$sql .= ' inner join grc_atendimento_pessoa      grc_ap on grc_ap.idt_atendimento    = grc_a.idt';
$sql .= ' left  join grc_atendimento_pessoa      grc_ap on grc_ap.idt_atendimento    = grc_a.idt';
//$sql .= "                                              and grc_ap.representa_empresa = 'S' ";
$sql .= ' left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt';
$sql .= "                                              and grc_ao.representa = 'S' ";
$sql .= ' left  join grc_atendimento_modalidade  grc_am on grc_am.idt             = grc_a.idt_modalidade';
$sql .= ' left  join plu_usuario       plu_usu on plu_usu.id_usuario = grc_a.idt_consultor';
$sql .= ' left  join grc_tema_subtema  grc_ts  on grc_ts.idt = grc_a.idt_tema_tratado';
$sql .= " where grc_a.idt = ".null($idt_atendimento);
//p($sql);
$rs   = execsql($sql);
if ($rs->rows > 0) {
	// echo " to fora <br>";
	foreach ($rs->data as $row) {
		$data_inicio_atendimento  = $row['data_inicio_atendimento'];
		$data_termino_atendimento = $row['data_termino_atendimento'];
		$hora_inicio_atendimento  = $row['hora_inicio_atendimento'];
		$hora_termino_atendimento = $row['hora_termino_atendimento'];
		$data                     = $row['data'];
		$diagnostico              = $row['diagnostico'];
		$devolutiva               = $row['devolutiva'];
		$recomendacao             = $row['recomendacao'];
		$solucao_sebrae           = $row['solucao_sebrae'];
		$protocolo                = $row['protocolo'];
		
		$cpf                      = $row['cpf'];
		$nome                     = $row['nome'];
		
		$logradouro_cidade        = $row['logradouro_cidade'];
        $logradouro_estado        = $row['logradouro_estado'];

		$cnpj                     = $row['cnpj'];
		$razao_social             = $row['razao_social'];
		
		$grc_am_descricao         = $row['grc_am_descricao'];
        $plu_usu_nome_completo    = $row['plu_usu_nome_completo'];		
		
		$grc_ts_descricao         = $row['grc_ts_descricao'];		
    }
}
else
{
   echo "Relatório não esta Parametrizado para o Atendimento solicitado";
   die();
}



$modalidade   = $grc_am_descricao;
$data         = trata_data($data);
$hora_inicial = $hora_inicio_atendimento;
$hora_final   = $hora_termino_atendimento;
$cidade       = $logradouro_cidade;
$estado       = $logradouro_estado;
$tema         = $grc_ts_descricao;
$consultor    = $plu_usu_nome_completo;
// dados cliente
$nome         = $nome;
$cpf          = $cpf;
$protocolo    = $protocolo;


		
$empreendimento = $razao_social;
$cnpj           = $cnpj;
// Resumo do atendimento
$demanda       = $devolutiva;
$diagnostico   = $diagnostico;

$demanda       = $diagnostico;
$diagnostico   = $devolutiva;


$recomendacao  = $recomendacao;
$solucao       = $solucao_sebrae;

//  Central de Relacionamento Sebrae: 0800 570 0800 | www.ba.sebrae.com.br

echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabp' style='background:{$corw}; font-weight: bold;' >Dados da Consultoria</td> ";
echo "</tr>";

echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='' ><b>Modalidade:</b> {$modalidade}</td> ";
echo "</tr>";

echo "<tr class=''>  ";
echo "   <td class='linha' style='width:33%;' ><b>Data:</b> {$data}</td> ";
echo "   <td class='linha' style='width:33%;' ><b>Hora Inicial:</b> {$hora_inicial}</td> ";
echo "   <td class='linha' style='width:33%;' ><b>Hora Final:</b> {$hora_final}</td> ";
echo "</tr>";

echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='padding:0; ' >";
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td class='' style='width:50%; border-right:1px solid #000000; padding:5px;  ' ><b>Cidade:</b> {$cidade}</td> ";
echo "   <td class='' style='width:50%; padding:5px;  ' ><b>Estado:</b> {$estado}</td> ";
echo "</tr>";

echo "</table >";
echo "   </td> ";
echo "</tr>";



echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='padding:0; ' >";
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td class='' style='width:50%; border-right:1px solid #000000; padding:5px;  ' ><b>Tema:</b> {$tema}</td> ";
echo "   <td class='' style='width:50%; padding:5px;  ' ><b>Consultor:</b> {$consultor}</td> ";
echo "</tr>";
echo "</table >";
echo "   </td> ";
echo "</tr>";







echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabp' style='background:{$corw}; font-weight: bold;' >Dados do Cliente</td> ";
echo "</tr>";



echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='' ><b>Nome do Completo:</b> {$nome}</td> ";
echo "</tr>";


echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='padding:0; ' >";
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td class='' style='width:50%; border-right:1px solid #000000; padding:5px;  ' ><b>CPF:</b> {$cpf}</td> ";
echo "   <td class='' style='width:50%; padding:5px;  ' ><b>Protocolo:</b> {$protocolo}</td> ";
echo "</tr>";
echo "</table >";
echo "   </td> ";
echo "</tr>";

echo "<tr class=''>  ";
echo "   <td colspan='3' class='linha' style='padding:0; ' >";
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td class='' style='width:50%; border-right:1px solid #000000; padding:5px;  ' ><b>Empreendimento:</b> {$empreendimento}</td> ";
echo "   <td class='' style='width:50%; padding:5px;  ' ><b>CNPJ:</b> {$cnpj}</td> ";
echo "</tr>";
echo "</table >";
echo "   </td> ";
echo "</tr>";



echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabp' style='background:{$corw}; font-weight: bold;' >Resumo do Atendimento</td> ";
echo "</tr>";





echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' ><b>Demanda do Cliente</b></td> ";
echo "</tr>";

echo "<tr class=''>  ";

echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' >";
echo "<div style='width:100%; padding:10px;' >  ";
echo $demanda;
echo "</div>  ";
echo "</td> ";
echo "</tr>";



echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' ><b>Diagnóstico realizado pelo consultor</b></td> ";
echo "</tr>";


echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' >";
echo "<div style='width:100%; padding:10px;' >  ";
echo $diagnostico;
echo "</div>  ";
echo "</td> ";
echo "</tr>";


echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' ><b>Recomendações/orientações feitas pelo consultor</b></td> ";
echo "</tr>";


echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' >";
echo "<div style='width:100%; padding:10px;' >  ";
echo $recomendacao;
echo "</div>  ";
echo "</td> ";
echo "</tr>";




echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' ><b>Solução Sebrae indicada</b></td> ";
echo "</tr>";

echo "<tr class=''>  ";
echo "   <td colspan='3' class='cabs' style='background:#FFFFFF;' >";
echo "<div style='width:100%; padding:10px;' >  ";
echo $solucao;
echo "</div>  ";
echo "</td> ";
echo "</tr>";








// Rodapé

if ($observacao_texto!="")
{
	echo "<tr class=''>  ";
	echo "   <td colspan='3' class='radap' style='background:{$corw};' >";
	
	echo "   <div style='background:{$corw}; padding:10px;  xmargin-top:10px; margin-top:5px; margin-bottom:5px;' >";
	echo "   {$observacao_texto}";
	echo "   </div>";
	
	echo "   </td> ";
	
	
	echo "</tr>";
}

if ($arquivo_rod!="")
{
	echo "<tr class=''>  ";
	$imgrod="<img width='{$largura_imagem}' height='{$altura_imagem}' border='0' src='{$arquivo_rodw}' />";
	echo "   <td colspan='3'  class='imgd' style='' >{$imgrod}</td> ";
	
	
	
	
	echo "</tr>";
}
echo "</table>";









if ($gravadevolutivapdf=="S")
{
   // 
   // Gravar Html em pdf
   // ----
   //echo " Gravar Html em pdf <br />"; 
   $html .= ob_get_contents();
   //$html .= 'áéíóúàèìòùâêîôûäëïöüãõ@#$%^&*()+=~`ç|\/:,?"<>';
   ob_end_clean();
	
	// aqui gravar o pdf
	define('_MPDF_PATH', lib_mpdf);
	include(lib_mpdf.'mpdf.php');

	//$mpdf=new mPDF('iso-8859-1','A4','','',ME,MD,MS,MB,MHEADER,MFOOTER);

	$ME = 5;
	$MD = 5;
	//$MS = 27;
	$MS = 7;
	$MB = 7;
	//$MHEADER = 3;
	//$MFOOTER = 5;
    $MHEADER = 1;
	$MFOOTER = 1;

	$mpdf = new mPDF('win-1252', 'A4', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'P');
	$html = preg_replace("|<script\b[^>]*>(.*?)</script>|s", "", $html);
	$html = str_replace('  ', ' ', $html);
	$html = str_replace("\n", '', $html);
	$html = str_replace(chr(10), '', $html);
	$html = str_replace(chr(13), '', $html);
	$html = str_replace("&nbsp;", '', $html);
	$html = utf8_encode($html);
	set_time_limit(0);
    $mpdf->WriteHTML($html);
	$protocolo = $_GET['protocolo'];
	$pathPDF="obj_file/at_di_devolutiva/{$protocolo}_devolutiva.pdf";
    $mpdf->Output($pathPDF, 'F');
	unset($mpdf);

	
}

?>
