<style>
</style>

<?php

$idt_avaliacao=$_GET['idt_avaliacao'];
$sql   = "select  ";
$sql  .= "   grc_a.*,  ";

$sql  .= "   grc_at.protocolo as grc_at_protocolo,  ";
$sql  .= "   grc_as.descricao as grc_as_descricao,  ";
$sql  .= "   gec_eclio.descricao as gec_eclio_descricao, ";
$sql  .= "   gec_eclip.descricao as gec_eclip_descricao, ";
$sql  .= "   gec_ecreo.descricao as gec_ecreo_descricao, ";
$sql  .= "   gec_ecrep.descricao as gec_ecrep_descricao ";
$sql  .= " from grc_avaliacao grc_a ";
$sql  .= " inner join grc_avaliacao_situacao grc_as on grc_as.idt = grc_a.idt_situacao ";
$sql  .= " inner join grc_atendimento        grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_eclio on gec_eclio.idt = grc_a.idt_organizacao_avaliado ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_eclip on gec_eclip.idt = grc_a.idt_avaliado ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_ecreo on gec_ecreo.idt = grc_a.idt_organizacao_avaliador ";
$sql  .= " left join ".db_pir_gec."gec_entidade gec_ecrep on gec_ecrep.idt = grc_a.idt_avaliador ";
$sql .=  " where grc_a.idt = ".null($idt_avaliacao);
$rs = execsql($sql);
foreach ($rs->data as $row) {
    $grc_at_protocolo    = $row['grc_at_protocolo'];
    $codigo              = $row['codigo'];
	$descricao           = $row['descricao']; 
	$data_avaliacao      = trata_data($row['data_avaliacao']); 
	$gec_eclio_descricao = $row['gec_eclio_descricao']; 
    $gec_eclip_descricao = $row['gec_eclip_descricao']; 
    $gec_ecreo_descricao = $row['gec_ecreo_descricao']; 
    $gec_ecrep_descricao = $row['gec_ecrep_descricao']; 
}

verificaInfAvaliacaoNAN($idt_avaliacao, $gec_ecreo_descricao, $gec_ecrep_descricao, $gec_eclio_descricao, $gec_eclip_descricao);


/*
    $_SESSION[CS]['g_estrutura_tabela']=Array();
    $vetEstrutura=Array();
	$banco  = "db_pir_grc";
    $tabela = "grc_atendimento_organizacao";
    MontaSql($banco,$tabela,$vetEstrutura);
    //p($vetEstrutura);
	$vetPHPInsert = $vetEstrutura['sql']['PHP']['insert'];
	p($vetPHPInsert);
	
	$arquivo="obj_file/include/{$banco}_{$tabela}_insert.php";
	$fo = fopen($arquivo, "w");
	$dados ="";
	foreach ($vetPHPInsert as $indice => $linha)
	{
	   //$linha  = str_replace("#","<".$linha); 
	   $dados .= $linha.chr(13);
	}
	// Agora escrevemos estes dados no arquivo
	$escreve = fwrite($fo,$dados);
	// Fechando o arquivo
	fclose($fo);
    //	
    $vetEstrutura=Array();
	$banco  = "db_pir_grc";
    $tabela = "grc_atendimento_pessoa";
    MontaSql($banco,$tabela,$vetEstrutura);
    //p($vetEstrutura);
	$vetPHPInsert = $vetEstrutura['sql']['PHP']['insert'];
	p($vetPHPInsert);
	
	$arquivo="obj_file/include/{$banco}_{$tabela}_insert.php";
	$fo = fopen($arquivo, "w");
	$dados ="";
	foreach ($vetPHPInsert as $indice => $linha)
	{
	   //$linha  = str_replace("#","<".$linha); 
	   $dados .= $linha.chr(13);
	}
	// Agora escrevemos estes dados no arquivo
	$escreve = fwrite($fo,$dados);
	// Fechando o arquivo
	fclose($fo);
    //	
*/

   $rascunho=1;
   echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
	echo "<tr>";
	$stylo="font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt;";
	echo "<td colspan='2' style='{$stylo}' >";
	$Require_Once="cadastro_conf/botao_protocolo_segunda_visita.php";
	if (file_exists($Require_Once)) {
		Require_Once($Require_Once);
	} else {
		echo "PROBLEMA NA dos botões do Protocolo da Segunda Visita. CONTACTAR ADMINISTRADOR DO SISTEMA";
	}
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	
	echo "<br /><br />";


 echo  "<div id='rascunho' style='text-align:center; display:block; color:#FFFFFF; background:red;'>";
 echo  "<b>DOCUMENTO EM FORMA DE RASCUNHO.</b><br /><br />";
 echo  "<b>DOCUMENTO PROVISÓRIO SEM VALIDADE PARA ASSINATURAS.</b><br /><br /><br />";
 echo  "</div>";
 






 // $background = '#2C3E50;';
 $background = '#ECF0F1;';
 $color      = '#000000;';
 //

 echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' style='' >";
 $titulo = "PROTOCOLO DA SEGUNDA VISITA";
 $stylo="border:1px solid #c4c9cd;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:18pt; color:$color; background:$background;";
 echo "<tr >";
 $header = '<img style="padding:5px;" src="imagens/logo_sebrae.png" alt="" border="0" />';
 echo "<td  style='{$stylo} width:100px;' >";
 echo $header; 
 echo "</td>";
 echo "<td colspan='3' style='{$stylo} width:80%;' >";
 if ($rascunho == 1)
 {
 
 echo  "<div id='rascunho' style='text-align:center; display:block; '>";
 echo  "<span style='' ><b>{$titulo}</b></span><br/>"; 
 echo  "<span style='font-size:10px; color:#FF0000; xbackground:red;' ><b>DOCUMENTO PROVISÓRIO SEM VALIDADE PARA ASSINATURAS.</b></span>";
 echo  "</div>";
 }
 else
 {
     echo  "<span style='' ><b>{$titulo}</b></span>"; 
 }
 
 
 echo "</td>";
 //
 $header = '<img style="padding:5px;" src="imagens/negocioanegocio.jpg" alt="" border="0" />';
 echo "<td  style='{$stylo} width:100px;' >";
 echo   $header; 
 echo "</td>";
 
 echo "</tr>";
 //
 $background = '#FFFFFF;';
 $color      = '#000000;';
 //
 $stylo="border:1px solid #C0C0C0;  padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:12pt; color:$color; background:$background;";
 echo "<tr >";
 echo "<td colspan='5' style='{$stylo} width:300px;' >";
 echo  "<span style='' >Empresa: <b> {$gec_eclio_descricao}</b></span>"; 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td  colspan='3' style='{$stylo} xwidth:50%; ' >";
 echo  "Data do Diagnóstico: <b>{$data_avaliacao}</b>"; 
 echo "</td>";
 echo "<td  colspan='2' style='{$stylo} xwidth:50%;' >";
 echo  "Cliente: <b>{$gec_eclip_descricao}</b>"; 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td  colspan='3' style='{$stylo}' >";
 echo  "Agente de Orientação Empresarial: <b>{$gec_ecrep_descricao}</b>"; 
 echo "</td>";
 echo "<td  colspan='2' style='{$stylo}' >";
 echo  "Protocolo da 1a Visita: <b>{$grc_at_protocolo}</b>"; 
 echo "</td>";
 
 echo "</tr>";
 
 
 echo "<td  colspan='5' style='{$stylo} ' >";
 echo  "<br /><br />";
 echo  "<div style='text-align:left; xmargin-left:50px; '>";
 echo  "Eu,_________________________________, proprietário ou representante legal do empreendimento,<br />";
 echo  "recebi os seguintes documentos nesta 2ª visita :<br /><br />";
 echo  "1 - Devolutiva – Informações Técnicas da situação organizacional atual de minha empresa<br />";
 echo  "2 - Caderno de ferramentas – Documento que subsidiará a melhoria de práticas de minha gestão<br />";
 echo  "3 - Plano Fácil – Documento para construção do meu planejamento para execução das sugestões Negócio a Negócio<br />";
 echo  "4 - Outro_______________________________________________________________<br /><br /><br />";
 echo  "</div>";
 

 $ano = '2016';
 
 echo  "<div style='text-align:center; display:block;'>";
 echo  "_________________________________, de _________________________ de $ano <br /><br /><br />";
 echo  "______________________________________________<br />";
 echo  "       {$gec_eclio_descricao}<br />";
 echo  "       Proprietário ou Representante Legal<br /><br /><br />";
 echo  "______________________________________________<br />";
 echo  "       {$gec_ecrep_descricao}<br />";
 echo  "       Agente de Orientação Empresarial<br /><br />";
 echo  "</div>";
 
 
 echo  "<div id='rascunho' style='text-align:center; display:block; color:#FFFFFF; background:red;'>";
 echo  "<b>DOCUMENTO EM FORMA DE RASCUNHO.</b><br /><br />";
 echo  "<b>DOCUMENTO PROVISÓRIO SEM VALIDADE PARA ASSINATURAS.</b><br /><br /><br />";
 echo  "</div>";
 
 
 
 echo "</td>";
 
 echo "</tr>";
 
 echo "</table>";


 