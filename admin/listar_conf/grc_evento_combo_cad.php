<?php
$_SESSION[CS]['grc_evento_combo_listar'] = $_SERVER['REQUEST_URI'];

$listar_sql_limit = false;

$idCampo = 'idt';
$Tela = "a Programação do Evento";

$tipoidentificacao = 'N';
$tipofiltro = 'S';
$comfiltro = 'A';
$comidentificacao = 'F';

$TabelaPrinc = "grc_evento";
$AliasPric = "grc_prop";
$Entidade = "Programação do Evento";
$Entidade_p = "Programações do Evento";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_evento_situacao';
$sql .= " where ativo = 'S'";
$sql .= ' order by codigo';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Status';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_evento_situacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['codigo'] = CriaVetTabela('Código');
$vetCampo['descricao'] = CriaVetTabela('Evento', 'func_trata_dado', ftd_grc_evento);
$vetCampo['grc_ersit_descricao'] = CriaVetTabela('Status', 'func_trata_dado', ftd_grc_evento);

$sql = "select ";
$sql .= "   {$AliasPric}.*,  ";
$sql .= " coalesce({$AliasPric}.idt_evento_pai, {$AliasPric}.idt) as idt,";
$sql .= "    grc_ersit.descricao as grc_ersit_descricao,";
$sql .= "    grc_ersit_ant.descricao as grc_ersit_ant_descricao,";
$sql .= '    null as ordem_contratacao, gec_pr.tipo_ordem as grc_pr_tipo_ordem';
$sql .= " from {$TabelaPrinc} as {$AliasPric} ";
$sql .= " inner join grc_evento_situacao grc_ersit on grc_ersit.idt = {$AliasPric}.idt_evento_situacao ";
$sql .= " left outer join grc_evento_situacao grc_ersit_ant on grc_ersit_ant.idt = {$AliasPric}.idt_evento_situacao_ant ";
$sql .= " left outer join ".db_pir_gec."gec_programa gec_pr on gec_pr.idt = {$AliasPric}.idt_programa";
$sql .= " where {$AliasPric}.idt_instrumento = 54";

if ($_SESSION[CS]['g_id_usuario'] !== '1') {
	$sql .= " and (";
	$sql .= " {$AliasPric}.temporario <> 'S'";
	$sql .= " or ({$AliasPric}.temporario = 'S' and {$AliasPric}.idt_responsavel = ".null($_SESSION[CS]['g_id_usuario']).")";
	$sql .= " )";
}

if ($vetFiltro['idt_evento_situacao']['valor'] != "" && $vetFiltro['idt_evento_situacao']['valor'] != "0" && $vetFiltro['idt_evento_situacao']['valor'] != "-1") {
    $sql .= ' and '.$AliasPric.'.idt_evento_situacao = '.null($vetFiltro['idt_evento_situacao']['valor']);
} else {
    //Mostra todos menos os cancelados
    $sql .= " and {$AliasPric}.idt_evento_situacao not in (4, 21)";
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '  lower('.$AliasPric.'.codigo)      like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower('.$AliasPric.'.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}