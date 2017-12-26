<?php
$idCampo = 'subclasse';
$Tela = "o CNAE";

$TabelaPrinc = "cnae";
$AliasPric = "cn";
$Entidade = "CNAE";
$Entidade_p = "CNAEs";

$tipofiltro = 'S';
$comfiltro = 'A';

$contlinfim = "Existem #qt {$Entidade_p}.";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'codigo';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Cуdigo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['codigo'] = $Filtro;

//$vetCampo['secao'] = CriaVetTabela('Seзгo');
//$vetCampo['divisao'] = CriaVetTabela('Divisгo');
//$vetCampo['grupo'] = CriaVetTabela('Grupo');
//$vetCampo['classe'] = CriaVetTabela('Classe');
$vetCampo['subclasse'] = CriaVetTabela('Subclasse');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');

$sql = '';
$sql .= " select {$AliasPric}.subclasse, {$AliasPric}.secao, {$AliasPric}.divisao, {$AliasPric}.grupo, {$AliasPric}.classe, {$AliasPric}.descricao,";
$sql .= " concat_ws(' - ', {$AliasPric}.subclasse, {$AliasPric}.descricao) as {$campoDescListarCmb}";
$sql .= " from ".db_pir_gec."{$TabelaPrinc} {$AliasPric}";
$sql .= " where {$AliasPric}.subclasse is not null";
$sql .= " and {$AliasPric}.ativo = 'S'";
$sql .= " and {$AliasPric}.existe_siacweb = 'S'";

if ($vetFiltro['texto']['valor'] != '') {
    $sql .= ' and lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
}

if ($vetFiltro['codigo']['valor'] != '') {
    $sql .= ' and lower('.$AliasPric.'.codigo) like lower('.aspa($vetFiltro['codigo']['valor'], '%', '%').')';
}

if ($_GET['idt_evento'] != '') {
    $sql .= " and {$AliasPric}.subclasse in (";
    $sql .= ' select cnae';
    $sql .= ' from grc_evento_cnae';
    $sql .= ' where idt_evento = '.null($_GET['idt_evento']);
    $sql .= ' )';
}