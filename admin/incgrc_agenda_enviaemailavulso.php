<style type="text/css">

.tituloemail {
   background:#0000FF;
   color:#FFFFFF;
   border:1px solid #000000;
   padding:5px;
   font-size:16px;
   font-family: Calibri, Arial, "Courier New", Courier, monospace;
   text-align:center;
}



</style>

<?php

//echo " ------------ ".$idt_atendimento_agenda;
//echo " ------------ ".$idt_agenda_processo;

$idt_agenda_processo=1;
$sql  = 'select ';
$sql .= '   grc_aep.*, grc_ae.detalhe as grc_ae_detalhe   ';
$sql .= ' from grc_agenda_emailsms_processo grc_aep ';
$sql .= ' inner join grc_agenda_emailsms grc_ae on grc_ae.idt_processo =  grc_aep.idt ';
$sql .= " where grc_aep.idt = ".null($idt_agenda_processo);
$rs   = execsql($sql);
if ($rs->rows > 0) {
	foreach ($rs->data as $row) {   
	   $grc_ae_detalhe = $row['grc_ae_detalhe'];
	}	
}
else
{
   // sem parametros de email
   echo " sem parametros de email ";   
}
$sql  = 'select ';
$sql .= '   grc_aa.*  ';
$sql .= ' from grc_atendimento_agenda grc_aa ';
$sql .= " where idt = ".null($idt_atendimento_agenda);
$rs   = execsql($sql);
if ($rs->rows > 0) {
	foreach ($rs->data as $row) {
		$protocolo = $row['protocolo'];
	}	
}
else
{
   // não encontrou o agendamnento
   echo " não encontrou o agendamnento ";   
}







$titulo   = "Envio de Email Avulso";
$larguraw = 700;
echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='3' class='tituloemail' style='' >{$titulo}</td> ";
echo "</tr>";
echo "</table> ";
//
// Formatar email
//


echo "<table class='' width='{$larguraw}' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
echo "<tr class=''>  ";
echo "   <td colspan='3' class='tituloemail' style='' >{$grc_ae_detalhe}</td> ";
echo "</tr>";
echo "</table> ";









/*


$idt_servico     = $_GET['idt_servico'];
$idt_atendimento = $_GET['idt_atendimento'];








//echo "$idt_servico == $idt_atendimento";

$idt_servico     = 10;
$idt_atendimento = 1436;




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
   echo "Relatório não esta Parametrizado para o serviço solicitado";
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
	echo "   <td colspan='3'  class='intro' style='width:{$larguraw}; ' >";
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
$sql .= ' inner join grc_atendimento_pessoa      grc_ap on grc_ap.idt_atendimento = grc_a.idt';
$sql .= ' left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt';
$sql .= ' left  join grc_atendimento_modalidade  grc_am on grc_am.idt             = grc_a.idt_modalidade';

$sql .= ' left  join plu_usuario       plu_usu on plu_usu.id_usuario = grc_a.idt_consultor';
$sql .= ' left  join grc_tema_subtema  grc_ts  on grc_ts.idt = grc_a.idt_tema_tratado';




$sql .= " where grc_a.idt = ".null($idt_atendimento);
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
   exit();
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
	echo "   <td colspan='3' class='radap' style='' >";
	
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
*/
?>
