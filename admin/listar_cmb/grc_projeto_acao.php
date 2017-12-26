<?php
$idCampo = 'idt';
$Tela = "o Projeto";

$TabelaPrinc = "grc_projeto_acao";
$AliasPric = "grc_pro";
$Entidade = "Aчуo do Projeto";
$Entidade_p = "Aчѕes do Projeto";
$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";


// Filtro de texto
$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

// Vetor com campos da tela
$vetCampo['descricao'] = CriaVetTabela('Descriчуo');

$sql = "select ";
$sql .= "   {$AliasPric}.*, ";
$sql .= "    grc_pro.descricao as {$campoDescListarCmb}";
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= ' where 1 = 1';

$sql .= ' and ativo_siacweb  = '.aspa('S');
$sql .= ' and existe_siacweb = '.aspa('S');


if ($_GET['idt_projeto'] != '') {
    $sql .= " and {$AliasPric}.idt_projeto = ".null($_GET['idt_projeto']);
}

if ($_GET['idt_unidade'] != '') {
    $sql .= " and {$AliasPric}.idt_unidade = ".null($_GET['idt_unidade']);
}

if ($_GET['veio'] == 'SG') {
    $sql .= " and {$AliasPric}.contrapartida_sgtec IS NOT NULL ";
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}


if ($sqlOrderby == '') {
    $sqlOrderby = "descricao asc";
}