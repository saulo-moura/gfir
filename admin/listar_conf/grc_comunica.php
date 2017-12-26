<?php
$idCampo = 'idt';
$Tela = "o Email SMS da Comunicação";


$TabelaPrinc      = "grc_comunica";
$AliasPric        = "grc_c";
$Entidade         = "Comunica - Email";
$Entidade_p       = "Comunica - Email";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

if ($_SESSION[CS]['g_id_usuario']==1)
{
    $permite = 1;
}
else
{
	$permite = 0;
}

if ($permite != 1)
{
	$barra_inc_ap = false;
	$barra_alt_ap = true;
	$barra_con_ap = true;
	$barra_exc_ap = false;
	$barra_fec_ap = false;
}

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


//$orderby = "{$AliasPric}.codigo";
$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['grc_cp_descricao']    = CriaVetTabela('Processo');
$vetCampo['descricao'] = CriaVetTabela('Título');
$vetCampo['tipo']      = CriaVetTabela('Tipo?', 'descDominio', $vetTipoAES );
//$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );
$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_cp.descricao as grc_cp_descricao   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left join grc_comunica_processo grc_cp on grc_cp.idt = {$AliasPric}.idt_processo ";
//$sql  .= " where tipo = 'E' ";
//$sql  .= " where 1 = 1 ";

$veio=$_GET['veio'];
$veio='pa';

if ($veio=='pa')
{
    $sql .= ' where ';
    $sql .= " grc_c.origem = 'P' ";
}
else
{
    $sql .= ' where ';
    $sql .= " grc_c.origem = 'A' ";
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
	$sql .= ' or lower('.$AliasPric.'.detalhe) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
//$sql  .= " order by {$orderby}";
//p($sql);

?>