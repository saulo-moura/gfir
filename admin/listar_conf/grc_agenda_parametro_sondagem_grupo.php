<?php
$idCampo = 'idt';
$Tela = "os Grupos de Perguntas de Sondagem";

$TabelaPrinc      = "grc_agenda_parametro_sondagem_grupo";
$AliasPric        = "grc_dg";
$Entidade         = "Grupo de Perguntas de Sondagem";
$Entidade_p       = "Grupo de Perguntas de Sondagem";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetAtivo=Array();
$vetAtivo['T']="Todos";
$vetAtivo['S']="Ativos";
$vetAtivo['N']="Inativos";
$Filtro = Array();
$Filtro['rs']       = $vetAtivo;
$Filtro['id']       = 'ativo';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Ativo?';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ativo'] = $Filtro;


$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Cуdigo do Grupo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " where 1 = 1 ";
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
$sql  .= " order by {$orderby}";

?>