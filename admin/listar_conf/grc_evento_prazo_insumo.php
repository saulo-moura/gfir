<?php
$idCampo = 'idt';
$Tela = "o Prazo para o Insumo";

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

$sql = "select idt,  descricao from ".db_pir_gec."gec_programa ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$rs = execsql($sql);
$Filtro = Array();
$Filtro['rs'] = $rs;
$Filtro['id'] = 'idt';
$Filtro['LinhaUm'] = ' ';
$Filtro['nome'] = 'Programa Credenciado';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['programa'] = $Filtro;

$vetCampo['instrumento'] = CriaVetTabela('Instrumento');
$vetCampo['programa'] = CriaVetTabela('Programa Credenciado');
$vetCampo['prazo_insumo'] = CriaVetTabela('Prazo do Insumo');
$vetCampo['prazo_credenciado'] = CriaVetTabela('Prazo do Credenciado');

$sql = '';
$sql .= ' select epi.*, i.descricao as instrumento, p.descricao as programa';
$sql .= ' from grc_evento_prazo_insumo epi';
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = epi.idt_instrumento';
$sql .= ' inner join '.db_pir_gec.'gec_programa p on p.idt = epi.idt_programa';
$sql .= ' where 1 = 1';

if ($vetFiltro['instrumento']['valor'] != "" && $vetFiltro['instrumento']['valor'] != "0" && $vetFiltro['instrumento']['valor'] != "-1") {
    $sql .= ' and epi.idt_instrumento = '.null($vetFiltro['instrumento']['valor']);
}

if ($vetFiltro['programa']['valor'] != "" && $vetFiltro['programa']['valor'] != "0" && $vetFiltro['programa']['valor'] != "-1") {
    $sql .= ' and epi.idt_programa = '.null($vetFiltro['programa']['valor']);
}