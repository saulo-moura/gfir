<?php
$idCampo = 'idt';
$Tela = "o Alчada Gerente / Coordenador";

$Filtro = Array();
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt in (40, 47, 46, 49, 50, 2, 41, 45, 48)';
$sql .= ' order by descricao';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Instrumento';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['instrumento'] = $Filtro;

$Filtro = Array();
$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_funcao';
$sql .= ' order by descricao';
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Funчуo';
$Filtro['LinhaUm'] = ' ';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['instrumento'] = CriaVetTabela('Instrumento');
$vetCampo['funcao'] = CriaVetTabela('Funчуo');
$vetCampo['vl_alcada'] = CriaVetTabela('Valor da Alчada', 'decimal');

$sql = '';
$sql .= ' select ea.idt, i.descricao as instrumento, f.descricao as funcao, ea.vl_alcada';
$sql .= ' from grc_evento_alcada ea';
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = ea.idt_instrumento';
$sql .= ' inner join '.db_pir.'sca_organizacao_funcao f on f.idt = ea.idt_sca_organizacao_funcao';
$sql .= ' where 1 = 1';

if ($vetFiltro['instrumento']['valor'] != "" && $vetFiltro['instrumento']['valor'] != "0" && $vetFiltro['instrumento']['valor'] != "-1") {
    $sql .= ' and ea.idt_instrumento = '.null($vetFiltro['instrumento']['valor']);
}

if ($vetFiltro['funcao']['valor'] != "" && $vetFiltro['funcao']['valor'] != "0" && $vetFiltro['funcao']['valor'] != "-1") {
    $sql .= ' and ea.idt_sca_organizacao_funcao = '.null($vetFiltro['funcao']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and ';
    $sql .= ' ( ';
    $sql .= '    lower(i.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' or lower(f.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
    $sql .= ' ) ';
}