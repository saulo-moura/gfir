<?php
$idCampo = 'codigo';
$Tela = "o Banco do Evento";

$tipofiltro = 'S';
$comfiltro = 'A';

$TabelaPrinc = "grc_evento_banco";
$AliasPric = "grc_eb";
$Entidade = "Banco do Evento";
$Entidade_p = "Bancos do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');

$sql = "select ";
$sql .= "   {$AliasPric}.*, concat_ws(' - ', codigo, descricao) as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " where ativo = 'S'";

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ( ';
    $sql .= '  lower(' . $AliasPric . '.codigo)      like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' or lower(' . $AliasPric . '.descricao) like lower(' . aspa($vetFiltro['texto']['valor'], '%', '%') . ')';
    $sql .= ' ) ';
}