<style>
#filtro_classificacao {
     display:block;
}
#barra_menu {
     display:none;
}
#filtro {
     width:50%;
}
</style>
<?php
Require_Once('relatorio/lupe_generico.php');
Require_Once('style.php');
//
// Barra de tarefas 
//

$idt_atendimento_agenda=$_GET['idt_atendimento_agenda'];
//
if ($_GET['print'] != 's') {
    echo "<div id='barra_f' class='barra_ferramentas'>";
    echo "<table border='0' cellspacing='0' cellpadding='0' width='100%' >";
    echo "<tr>";
	
	
    echo "<td width='20' style='border:0; padding-left:5px;'>";
	//$voltar = ' <img src="imagens/bt_voltar.png" title="Voltar do Painel" onclick="self.location = '."'".'http://desenvolvepir.ba.sebrae.com.br/sebrae_grc/admin/conteudo.php?prefixo=inc&amp;painel_btvoltar_rod=N&amp;mostra_menu=N&amp;menu=plu_seguranca&amp;origem_tela=painel&amp;cod_volta=home'."'".'" value="Voltar" class="Botao">';
	//echo "{$voltar}";
	
	$voltar = 'javascript:parent.hidePopWin(true);';
	//parent.hidePopWin(true);
	$onclick=" onclick='javascript:parent.hidePopWin(true); '   "; 
	
	
	$voltar = 'javascript:top.close();';
	//parent.hidePopWin(true);
	$onclick=" onclick='javascript:top.close(); '   "; 
	
    
	echo "<a HREF='#' {$onclick}><img class='bartar' border='0' align=middle src='imagens/bt_voltar.png'></a>";
    echo "</td>";
	
	
    echo "<td width='20' style='border:0; padding-left:5px;'>";
    $str=$menu."&titulo_rel=".$titulo_relatorio;
    echo "<a HREF='#' onclick=\"return imprimir_comprovante('$str');\"><img border='0' class='bartar' width='32' height='32' align=middle src='relatorio/visualizar_impressao.png'></a>";
    echo "</td>";
	
  //  $href = "relatorio/conteudo_excel_rel.php" ;   
  //  echo "<td width='20'>";
  //  echo "<a HREF='{$href}'><img class='bartar' align=middle src='../imagens/excel.gif'></a>";
  //  echo "</td>";
   
    echo "<td>&nbsp;</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
}


$TabelaPrinc      = "grc_atendimento_agenda";
$AliasPric        = "grc_aa";

$campos = "{$AliasPric}.*, ";

$campos .= "sca_oc.descricao as ponto_atendimento,  ";

$campos .= "sca_oc.logradouro as logradouro,  ";
$campos .= "sca_oc.logradouro_numero as numero,  ";
$campos .= "sca_oc.logradouro_complemento as complemento,  ";
$campos .= "sca_oc.cep as cep,  ";
$campos .= "sca_oc.telefone   as telefone,  ";
$campos .= "sca_oc.horario_funcionamento as horario_funcionamento,  ";
$campos .= "sca_oc.imagem as imagem,  ";

$campos .= "sca_oc.logradouro_codbairro as logradouro_codbairro,  ";
$campos .= "sca_oc.logradouro_codcid as logradouro_codcid,  ";
$campos .= "sca_oc.logradouro_codest as logradouro_codest,  ";
$campos .= "sca_oc.logradouro_codpais as logradouro_codpais,  ";



$campos .= "pu.nome_completo as consultor,  ";
$campos .= "gae.descricao as servico  ";


$idt_atendimento_agenda=$_GET['idt_atendimento_agenda'];


//$tolerancia_par=15;
//$tolerancia=$tolerancia_par;
//
// Buscar Parametros
//
$tolerancia_atraso=0;
$vetParametrosw = Array();
DadosPARAGENDA($vetParametrosw);
$tolerancia_atraso = $vetParametrosw['row_ap']['tolerancia_atraso'];
$msg_comprovante ='';
$msg_comprovante.="Lembre-se de chegar com {$tolerancia_atraso} minutos de antecedência para garantir o atendimento na hora agendada.<br /> Caso necessite agendar um novo horário ou realizar o cancelamento, você poderá fazê-lo em até 48h antes do horário marcado através da Central de Relacionamento SEBRAE pelo número 0800 570 0800.";


// "Caso necessite agendar um novo horário ou realizar o cancelamento, você poderá fazê-lo através da Central de Relacionamento SEBRAE pelo número 0800 570 0800."


//$msg_comprovante.="Lembre-se de chegar com {$tolerancia_atraso} minutos de antecedência para garantir o atendimento na hora agendada.<br /> Caso necessite agendar um novo horário ou realizar o cancelamento, você poderá fazê-lo em até 48h antes do horário marcado através da Central de Relacionamento SEBRAE pelo número 0800 570 0800.";

//$msg_comprovante.="Lembre-se de chegar com {$tolerancia_atraso} minutos de antecedência para garantir o atendimento na hora agendada.<br /> Caso necessite agendar um novo horário ou realizar o cancelamento, você poderá fazê-lo através da Central de Relacionamento SEBRAE pelo número 0800 570 0800.";


$sql  = "select  ";
$sql .= " $campos  ";
$sql .= " from {$TabelaPrinc}  {$AliasPric}";


$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
$sql  .= " left  join ".db_pir."sca_organizacao_secao as sca_oc on sca_oc.idt = {$AliasPric}.idt_ponto_atendimento ";



$strWhere  = " {$AliasPric}.idt = ".null($idt_atendimento_agenda);
$korderbyw = "";

if ($strWhere!="")
{
	$sql .= " where (";
	$sql .= $strWhere ;
	$sql .= " )";
}
if ($korderbyw!="")
{
	$sql .= " order by ";
    $sql .= $korderbyw;
}	
$rs = execsql($sql);
$qtd_sel = $rs->rows;
if ($qtd_sel == 0 )
{
    // Nada foi selecionado
    echo "Erro Registro de Agendamento Não Encontrado";	
	//p($sql);
	//exit();
	
}    
else
{
     // Imprimir Comprovante
	$styleR = "width:100%;";
	echo "<div id='Comprovante' style='{$styleR}'>"; 
	$eventow = "##"; 
	ForEach($rs->data as $row)
	{
		$codigo             = $row['codigo'];
		$data               = trata_data($row['data']);
		$hora               = $row['hora'];
		$dia_semana         = $row['dia_semana'];
		$cliente_texto      = $row['cliente_texto'];
		$protocolo          = $row['protocolo'];
		$cpf                = $row['cpf'];
		$cnpj               = $row['cnpj'];
		$nome_empresa       = $row['nome_empresa'];
		$unidade_regional   = $row['unidade_regional'];  
		$ponto_atendimento  = $row['ponto_atendimento'];  
		$servico            = $row['servico'];  
		$consultor          = $row['consultor'];  
		
		
		$logradouro         = $row['logradouro'];  
		$numero             = $row['numero'];  
		$complemento        = $row['complemento'];  
		$cep                = $row['cep'];  
		$telefone           = $row['telefone'];  
		$horario_funcionamento=$row['horario_funcionamento'];  

		$logradouro_codbairro=$row['logradouro_codbairro'];  
		$logradouro_codcid=$row['logradouro_codcid'];  
		$logradouro_codest=$row['logradouro_codest'];  
		$logradouro_codpais=$row['logradouro_codpais'];  
		$imagem=$row['imagem'];  

		
		
		echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
		$styleCA="font-size:15px; width:200px; padding-left:10px; ";
		$styleC="font-size:15px; padding:2px;";
		echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} margin-top:20px;' >";
		echo   "PROTOCOLO:";
		echo "</td> ";
        echo " <td class='' style='{$styleC}'>";
		echo   $protocolo;
		echo "</td> ";
		echo "</tr>";
		
    	echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "DATA e HORA:";
		echo "</td> ";
        echo " <td class='' style='{$styleC}'>";
		echo   $data."  ".$hora."   ".$dia_semana;
		echo "</td> ";
		echo "</tr>";
  		
    	echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "CLIENTE:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo $cpf." - ".$cliente_texto;
		echo "</td> ";
		echo "</tr>";

        if ($cnpj!="")
		{
			echo "<tr class='' style=''>  ";
			echo " <td class='' style='{$styleCA} '>";
			echo   "EMPRESA:";
			echo "</td> ";
			echo " <td class='' style='{$styleC} '>";
			echo $cnpj." - ".$nome_empresa;
			echo "</td> ";
			echo "</tr>";
        }
    	echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "SERVIÇO:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo $servico;
		echo "</td> ";
		echo "</tr>";
/*
        echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "CONSULTOR/ATENDENTE:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo $consultor;
		echo "</td> ";
		echo "</tr>";
*/
		echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "PONTO DE ATENDIMENTO:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo $ponto_atendimento;
		echo "</td> ";
		echo "</tr>";
/*
		echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "TELEFONE:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo $telefone;
		echo "</td> ";
		echo "</tr>";
*/


		$sqlp = '';
		$sqlp .= " select distinct codpais as cod, pais_nome";
		$sqlp .= ' from '.db_pir_gec.'base_cep';
		$sqlp .= ' where codpais = '.null($logradouro_codpais);
		$rsp = execsql($sqlp);
		ForEach($rsp->data as $rowp)
		{
			$pais_nome = $rowp['pais_nome'];
		}

		$sqlp = '';
		$sqlp .= " select distinct codest as cod, uf_nome";
		$sqlp .= ' from '.db_pir_gec.'base_cep';
		$sqlp .= ' where codest = '.null($logradouro_codest);
		$rsp = execsql($sqlp);
		ForEach($rsp->data as $rowp)
		{
			$uf_nome = $rowp['uf_nome'];
		}
		$sqlp = '';
		$sqlp .= " select distinct codcid as cod, cidade";
		$sqlp .= ' from '.db_pir_gec.'base_cep';
		$sqlp .= ' where codcid = '.null($logradouro_codcid);
		$rsp = execsql($sqlp);
		ForEach($rsp->data as $rowp)
		{
			$cidade = $rowp['cidade'];
		}

		$sqlp = '';
		$sqlp .= " select distinct codbairro as cod, bairro";
		$sqlp .= ' from '.db_pir_gec.'base_cep';
		$sqlp .= ' where codbairro = '.null($logradouro_codbairro);
		$rsp = execsql($sqlp);
		ForEach($rsp->data as $rowp)
		{
			$bairro = $rowp['bairro'];
		}

		echo "<tr class='' style=''>  ";
		echo " <td class='' style='{$styleCA} '>";
		echo   "ENDEREÇO:";
		echo "</td> ";
        echo " <td class='' style='{$styleC} '>";
		echo "$pais_nome, $uf_nome, $cidade, $bairro<br /> ";
		if ($numero ==  "" and $complemento=="")
        {
			if ($cep ==  "")
			{
				echo "$logradouro ";
			}
			else
			{
			    echo "$logradouro, $cep "; 
			}      }
        if ($numero !=  "" and $complemento=="")
        {
		    echo "$logradouro, $numero, $cep ";
        }
        if ($numero ==  "" and $complemento!="")
        {
		    echo "$logradouro, $complemento, $cep ";
        }
        if ($numero !=  "" and $complemento!="")
        {
		    echo "$logradouro, $numero, $complemento, $cep ";
        }		
		
		echo "</td> ";
		echo "</tr>";

$styleCM="font-size:15px; padding:10px;";
echo "<tr class='' style=''>  ";
		echo " <td colspan='2' class='' style='{$styleCM} '>";
		echo   $msg_comprovante;
		echo "</td> ";
		echo "</tr>";



	}
	echo "</table> ";
	echo "</div>"; 
}




?>
<script>
function imprimir_comprovante()
{
   var id='#barra_f';
   $(id).hide();
   
      /*

   document.documentElement.innerHTML
   var id='#barra_f';
   $(id).show();
   //
   var conteudo = document.documentElement.innerHTML
   var win = window.open();  
   win.document.write(conteudo);  
   win.print();  
   win.close();//Fecha após a impressão.  
      */

   window.print();
   var id='#barra_f';
   $(id).show();
   window.close();//Fecha após a impressão.  
      var id='#barra_f';
   $(id).show();

   /*
	var conteudo = document.getElementById(divID).innerHTML;  
	var win = window.open();  
	win.document.write(conteudo);  
	win.print();  
	win.close();//Fecha após a impressão.  
   */
   
}
</script>
