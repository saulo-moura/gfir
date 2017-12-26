<?php
$idCampo = 'idt';
$Tela = "o Instrumento - Métrica";

$TabelaPrinc = "grc_atendimento_instrumento_metrica";
$AliasPric = "grc_ai";
$Entidade = "Instrumento - Métrica";
$Entidade_p = "Instrumento - Métrica";

$barra_inc_h = "Incluir um Novo Registro de {$Entidade}";
$contlinfim = "Existem #qt {$Entidade_p}.";
$comfiltro = 'A';

$sql = '';
$sql .= ' select idt, descricao, codigo_sge';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where codigo_sge is not null';
$sql .= ' order by descricao, codigo_sge';
$Filtro = Array();
$Filtro['rs'] = execsql($sql);
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Instrumento';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['instrumento'] = $Filtro;

$sql = '';
$sql .= ' select codigo';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt = '.null($vetFiltro['instrumento']['valor']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo = Array();
$vetCampo['ano'] = CriaVetTabela('Ano');

if (substr($row['codigo'], 0, 2) == 'MC' || substr($row['codigo'], 0, 2) == 'FE') {
    $vetCampo['participacao_sebrae'] = CriaVetTabela('Modo de Participação do Sebrae', 'descDominio', $vetParticipacaoEvento);
}

$vetCampo['descricao'] = CriaVetTabela('Métrica');

$sql = "select et.*, am.descricao";
$sql .= " from grc_atendimento_instrumento_metrica et ";
$sql .= ' inner join grc_atendimento_metrica am on am.idt = et.idt_atendimento_metrica';
$sql .= ' where et.idt_atendimento_instrumento = '.null($vetFiltro['instrumento']['valor']);
