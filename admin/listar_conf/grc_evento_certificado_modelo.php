<?php
$idCampo = 'idt';
$Tela = "o modelo do certificado";

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= " where idt in (2, 40, 41, 45, 46, 47, 48, 49, 50)";
$sql .= ' order by descricao';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'f_idt_instrumento';
$Filtro['id_select'] = 'idt';
$Filtro['nome'] = 'Instrumento';
$Filtro['LinhaUm'] = '<< Todos >>';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['f_idt_instrumento'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;

$vetCampo['instrumento'] = CriaVetTabela('Instrumento');
$vetCampo['descricao'] = CriaVetTabela('Descrição');

$sql = '';
$sql .= ' select m.idt, m.descricao, i.descricao as instrumento';
$sql .= ' from grc_evento_certificado_modelo m';
$sql .= ' left outer join grc_atendimento_instrumento i on i.idt = m.idt_instrumento';
$sql .= ' where 1 = 1';

if ($vetFiltro['f_idt_instrumento']['valor'] != "" && $vetFiltro['f_idt_instrumento']['valor'] != "0" && $vetFiltro['f_idt_instrumento']['valor'] != "-1") {
    $sql .= ' and m.idt_instrumento = ' . null($vetFiltro['f_idt_instrumento']['valor']);
}

if ($vetFiltro['texto']['valor'] != "") {
    $sql .= ' and lower(m.descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
}