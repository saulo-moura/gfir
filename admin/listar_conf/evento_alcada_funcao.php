<?php
$idCampo = 'idt';
$Tela = "a funчуo do RM";

$TabelaPrinc      = db_pir."sca_organizacao_funcao";
$AliasPric        = "grc_ai";

$Filtro = Array();
$Filtro['rs']       = 'Texto';
$Filtro['id']       = 'texto';
$Filtro['js_tam']   = '0';
$Filtro['nome']     = 'Texto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['descricao'] = CriaVetTabela('Funчуo do RM');
$vetCampo['tipo_alcada_evento'] = CriaVetTabela('Funчуo da Alчada', 'descDominio', $vetTipoAlcadaEvento);

$sql   = "select ";
$sql  .= "   {$AliasPric}.*  ";
$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor']!="")
{
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}
