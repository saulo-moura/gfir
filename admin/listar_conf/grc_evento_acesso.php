<?php
$idCampo = 'idt';
$Tela = "a Entrega para acesso ao Evento";

$TabelaPrinc = "grc_evento_acesso";
$AliasPric = "grc_eb";
$Entidade = "Entrega para acesso ao Evento";
$Entidade_p = "Entrega para acesso ao Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$barra_exc_ap = false;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['descricao'] = CriaVetTabela('Descri��o');

$sql = "select ";
$sql .= "   {$AliasPric}.*  ";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' where ';
    $sql .= ' ( ';
    $sql .= '  lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}
