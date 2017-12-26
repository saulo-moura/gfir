<?php
require_once '../configuracao.php';
ini_set('memory_limit', '2048M');
set_time_limit(0);

beginTransaction();

$sql = '';
$sql .= ' select e.idt';
$sql .= ' from grc_evento e';
$sql .= ' where e.tipo_sincroniza_siacweb_old is not null';
$sql .= ' and e.idt_instrumento = 2';
$sql .= ' and not EXISTS(';
$sql .= ' select a.idt from grc_evento_agenda a where a.idt_evento = e.idt';
$sql .= ' )';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = 'insert into grc_evento_agenda (idt_evento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg)';
    $sql .= ' select idt_evento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg';
    $sql .= ' from grc_evento_agenda_bkp';
    $sql .= ' where idt_evento = '.null($row['idt']);
    execsql($sql);
}

commit();

echo 'FIM...';
