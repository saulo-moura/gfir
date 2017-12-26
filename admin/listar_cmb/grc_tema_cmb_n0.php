<?php
$idCampo = 'idt';
$Tela = "o Tema/Subtema";

$TabelaPrinc = "grc_tema_subtema";
$AliasPric = "grc_tsb";
$Entidade = "Tema/Subtema";
$Entidade_p = "Tema/Subtemas";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$listar_sql_limit = false;
$reg_pagina_esp = 'tudo';
$barra_con_ap = false;

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
$sql .= "   {$AliasPric}.*,";
$sql .= " concat_ws(' - ', {$AliasPric}.descricao) as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " where {$AliasPric}.ativo = 'S'";
$sql .= ' and nivel = 0';

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}

if ($sqlOrderby == '') {
    $sqlOrderby = "{$AliasPric}.codigo asc";
}

$vetOrderby = Array(
    "{$AliasPric}.codigo" => 'Cуdigo',
    "{$AliasPric}.descricao" => 'Descriзгo',
);

?>