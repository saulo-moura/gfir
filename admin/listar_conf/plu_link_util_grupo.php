<?php
$idCampo = 'idt';
$Tela = "os grupos do link";

$TabelaPrinc      = "plu_link_util_grupo";
$AliasPric        = "plu_lug";
$Entidade         = "Grupo do Link";
$Entidade_p       = "Grupos do Link";

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

$vetCampo['codigo']    = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['sac_os_descricao'] = CriaVetTabela('Ponto Atendimento');

/*

$idt_ponto_atendimento=$_SESSION[CS]['g_idt_unidade_regional'];
$fixaunidade=1;
if ($fixaunidade==0)
{   // Todos
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where posto_atendimento = 'PA' ";
    $sql  .= ' order by classificacao ';
}
else
{
    $sql   = 'select ';
    $sql  .= '   idt, descricao  ';
    $sql  .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
    $sql  .= " where (posto_atendimento = 'PA' ) ";
    $sql  .= "   and idt = ".null($idt_ponto_atendimento);
    $sql  .= ' order by classificacao ';
}
$rs = execsql($sql);

$Filtro = Array();
$Filtro['rs']        = $rs;
$Filtro['id']        = 'idt';
$Filtro['js_tam']    = '0';
$Filtro['nome']      = 'Pontos de Atendimento';
$Filtro['valor']     = trata_id($Filtro);
$vetFiltro['ponto_atendimento'] = $Filtro;

*/



$sql   = "select ";
$sql  .= "   {$AliasPric}.*,  ";
$sql  .= " sac_os.descricao as  sac_os_descricao ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " left join ".db_pir."sca_organizacao_secao sac_os on sac_os.idt = {$AliasPric}.idt_ponto_atendimento ";

//$sql .= ' where ';
//$sql .= " {$AliasPric}.idt_ponto_atendimento =  ".null($vetFiltro['ponto_atendimento']['valor']);


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
