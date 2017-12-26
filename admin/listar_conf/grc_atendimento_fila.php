<?php
$idCampo = 'idt';
$Tela = "as Filas";

$TabelaPrinc      = "grc_atendimento_fila";
$AliasPric        = "grc_af";
$Entidade         = "Fila";
$Entidade_p       = "Filas";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim  = "Existem #qt {$Entidade_p}.";


$sql   = 'select ';
$sql  .= '   idt, descricao  ';
$sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql  .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
$sql  .= ' order by classificacao ';
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']       = $rs;
$Filtro['id']       = 'idt';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Pontos de Atendimento';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$orderby = "{$AliasPric}.codigo";

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['localizacao'] = CriaVetTabela('Localização');
$vetCampo['sac_os_descricao'] = CriaVetTabela('Ponto Atendimento');
$vetCampo['ativo']     = CriaVetTabela('Ativo?', 'descDominio', $vetSimNao );

//$sql   = "select ";
//$sql  .= "   {$AliasPric}.*  ";
//$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";


$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= " sac_os.descricao as  sac_os_descricao ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql  .= " left join ".db_pir."sca_organizacao_secao sac_os on sac_os.idt = {$AliasPric}.idt_ponto_atendimento ";

$sql  .= ' where ';
$sql  .= ' idt_ponto_atendimento = '.null($vetFiltro['ponto_atendimento']['valor']);


if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
$sql  .= " order by {$orderby}";

?>
