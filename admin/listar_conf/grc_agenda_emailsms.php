<?php
$idCampo = 'idt';
$Tela = "o Email SMS da Agenda";


$TabelaPrinc      = "grc_agenda_emailsms";
$AliasPric        = "grc_aes";
$Entidade         = "Email e SMS da Agenda";
$Entidade_p       = "Email e SMS da Agenda";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';


$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetAtivo=Array();
$vetAtivo['S']="Ativos";
$vetAtivo['N']="Inativos";
$vetAtivo['T']="Todos";
$Filtro = Array();
$Filtro['rs']       = $vetAtivo;
$Filtro['id']       = 'ativo';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ativo?';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;

$vetOrigem=Array();
if ($_GET['veio']=='pa') // Portal do ATENDIMENTO
{
	$vetOrigem['P']="Portal do Atendimento";
	$vetOrigem['A']="Agendamento";
	$vetOrigem['T']="Todos";
}
else
{
    $vetOrigem['A']="Portal do Atendimento";
	$vetOrigem['P']="Agendamento";
	$vetOrigem['T']="Todos";
}
$Filtro = Array();
$Filtro['rs']       = $vetOrigem;
$Filtro['id']       = 'ativo';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Origem';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['origem'] = $Filtro;



$vetProprietario=Array();
$vetProprietario['UAIN']="UAIN";
$vetProprietario['GESTOR']="GESTOR";
$vetProprietario['T']="Todos";
$Filtro = Array();
$Filtro['rs']       = $vetProprietario;
$Filtro['id']       = 'proprietario';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Proprietario';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['proprietario'] = $Filtro;



if ($vetFiltro['origem']['valor']=="T")
{
    $vetCampo['origem']      = CriaVetTabela('Origem', 'descDominio', $vetOrigem );
}
//$orderby = "{$AliasPric}.codigo";
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['grc_aep_descricao']    = CriaVetTabela('Processo');
$vetCampo['descricao'] = CriaVetTabela('Título');
$vetCampo['proprietario'] = CriaVetTabela('Proprietário');
$vetCampo['tipo']      = CriaVetTabela('Tipo?', 'descDominio', $vetTipoAES );
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$vetCampo['padrao']    = CriaVetTabela('Padrão?', 'descDominio', $vetSimNao );
$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_aep.descricao as grc_aep_descricao   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left join grc_agenda_emailsms_processo grc_aep on grc_aep.idt = {$AliasPric}.idt_processo ";
//$sql  .= " where tipo = 'E' ";
//$sql  .= " where 1 = 1 ";

$veio=$_GET['veio'];
/*
if ($veio=='pa')
{
    $sql .= ' where ';
    $sql .= " grc_aes.origem = 'P' ";
}
else
{
    $sql .= ' where ';
    $sql .= " grc_aes.origem = 'A' ";
}
*/
if ($vetFiltro['origem']['valor']!="")
{
	if ($vetFiltro['origem']['valor']=="P")
	{
		$sql .= ' where ';
		$sql .= " grc_aes.origem = 'P' ";
	}
	if ($vetFiltro['origem']['valor']=="A")
	{
		$sql .= ' where ';
		$sql .= " grc_aes.origem = 'A' ";
	}
	if ($vetFiltro['origem']['valor']=="T")
	{
		$sql .= ' where ';
		$sql .= " 1 = 1 ";
	}
}
else
{
	$sql .= ' where ';
	$sql .= " 1 = 1 ";
}

if ($vetFiltro['proprietario']['valor']!="T")
{
	$proprietario = $vetFiltro['proprietario']['valor'];
	$sql .= " and ( {$AliasPric}.proprietario = '{$proprietario}') ";
}



if ($vetFiltro['ativo']['valor']!="T")
{
	$ativo = $vetFiltro['ativo']['valor'];
	$sql .= " and ( {$AliasPric}.ativo = '{$ativo}') ";
}

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";

?>