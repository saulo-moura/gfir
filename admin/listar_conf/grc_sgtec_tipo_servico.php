<?php
$idCampo = 'idt';
$Tela = "o Tipo do Serviзo do SGTEC";
$TabelaPrinc      = "grc_sgtec_tipo_servico";
$AliasPric        = "grc_sts";
$Entidade         = "O Tipo de Serviзo do SGTEC";
$Entidade_p       = "Os Tipos de Serviзos do SGTEC";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']           = CriaVetTabela('Cуdigo');
$vetCampo['descricao']        = CriaVetTabela('Descriзгo');
$vetCampo['grc_sn_descricao'] = CriaVetTabela('Natureza');
$vetCampo['grc_sm_descricao'] = CriaVetTabela('Modalidade');
$vetCampo['ativo']            = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= "   grc_sn.descricao as grc_sn_descricao,   ";
$sql  .= "   grc_sm.descricao as grc_sm_descricao   ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " inner join  grc_sgtec_natureza grc_sn on grc_sn.idt = {$AliasPric}.idt_natureza ";
$sql  .= " inner join  grc_sgtec_modalidade grc_sm on grc_sm.idt = {$AliasPric}.idt_modalidade ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(sgc_sn.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
	$sql .= ' or lower(sgc_sm.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>