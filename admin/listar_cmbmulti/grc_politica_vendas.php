
<?php


echo "<style>";
echo ".div_descricao {";
echo "    display:none;";
echo "}";
echo "</style>";



$idCampo = 'idt';
$Tela = "a natureza";


$outramsgvazio=false;

/*
$Filtro = Array();
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from gec_compromisso_evento';
$sql .= ' order by descricao';
$Filtro['rs'] = execsql($sql);
$Filtro['id_select'] = 'idt';
$Filtro['id'] = 'idt_evento';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Evento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_evento'] = $Filtro;
*/
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$idt_politica_vendas = $_SESSION[CS]['grc_politica_evento_condicao'];

//p($idt_politica_vendas);

// montar existentes
$whereexi = "";
$sqlp  = '';
$sqlp .= " select idt_evento ";
$sqlp .= ' from grc_politica_vendas_eventos';
$sqlp .= ' where idt_politica_vendas = ' . null($idt_politica_vendas);
$rsp   = execsql($sqlp);
if ($rsp->rows == 0 )
{
    $whereexi="";
}
else
{
    $whereexi = "( ";
	$or       = " ";
	ForEach ($rsp->data as $rowp) {
		$whereexi .= $or.' evento.idt <> '.$rowp['idt_evento'];
		$or    = " and ";
	}
	$whereexi .= ") ";
}









$vetParametro=Array();
$vetParametro['idt_politica_vendas']=$idt_politica_vendas;
$vetParametro['tipo']='P';
$ret = MontaWherePoliticaVendas($vetParametro);
$condicaoHtml = $vetParametro['condicaoHtml'];
/*
echo "<div style='float:left; width:100%; display:block;'>";
echo $condicaoHtml;
echo "</div>";
*/

$where = $vetParametro['where'];
//echo $where;
$filtrocomplementar="";
if ($where!="")
{
    $filtrocomplementar=" and ".$where;
}

if ($whereexi!="")
{   // exclui os existentes
    $filtrocomplementar .= " and ".$whereexi;

}

$sql = '';
$sql .= ' select ';
$sql .= ' evento.idt, ';
$sql .= ' evento.codigo, ';
$sql .= ' evento.descricao ';
$sql .= ' from grc_evento evento ';
$sql .= ' inner join grc_produto produto on produto.idt = evento.idt_produto ';
$sql .= " where 1 = 1 {$filtrocomplementar} ";
//p($sql);
if ($vetFiltro['idt_evento']['valor'] > 0) {
    $sql .= ' and grc_e.idt_evento = '.null($vetFiltro['idt_evento']['valor']);
}
if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(grc_e.codigo)    like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(grc_e.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


 $sqlw =  str_replace('1 = 1','2 = 1',$sql);
 $sqlm =  str_replace('1 = 1  and', ' ' ,$sql);
 $ret  =  VerificaSQL($sqlw,$e);
 
 //echo 'Menssagem1 : '.$e->errorInfo[2];
 
 $msgsql = $e->errorInfo[2];
 
 //echo 'Menssagem2 : '.$e->message;
 
 //p($e);
 
 
 //echo $sqlw;
 //echo $sqlm;
 
 if ($ret==0)
 {
    echo "<div style='padding-bottom:10px; width:100%; display:block; background:#FFFFFF; color:#FF0000; font-size:16px; text-align:center;'>";
	echo "ATENÇÃO...<br >";
	echo "ERRO NA SINTAXE DO SELECT.<br ><br />";
	echo "Por favor, retornar e ajustar parametrização.<br >";
	echo "</div>";
	
	echo "<div style='padding-top:10px; width:100%; display:block; background:#F1F1F1; color:#0000FF; font-size:16px; text-align:left;'>";
	echo "SQL MONTADO:<br /><br />";
	echo $sqlm;
	echo "</div>";
	
	
	echo "<div style='padding-bottom:10px; padding-top:10px; width:100%; display:block; background:#FFFFFF; color:#000000; font-size:16px; text-align:left;'>";
	echo "MENSAGEM ORIGINAL DO SQL:<br /><br />";
	echo $msgsql;
	echo "</div>";
	
	
	echo "<div style='padding-top:15px; width:100%; display:block; background:#FFFFFF; color:#000000; font-size:16px; text-align:center;'>";
	echo '<input type="Button" onclick="parent.hidePopWin(false);" value="Voltar" class="Botao">';
	echo "</div>";
	
	exit();
 }



