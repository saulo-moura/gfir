<?php
$idCampo = 'idt';
$Tela = "o Sub Grupo Principal do CBO";
$TabelaPrinc      = "cbo_sub_grupo_principal";
$AliasPric        = "cbo_sgp";
$Entidade         = "Sub Grupo do CBO";
$Entidade_p       = "Sub Grupos Principais do CBO";
$barra_inc_h      = "Incluir um Novo Registro de {$Entidade} ";
$contlinfim       = "Existem #qt {$Entidade_p}.";


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

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

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
