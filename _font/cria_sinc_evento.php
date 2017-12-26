<?php
require_once 'configuracao.php';

beginTransaction();

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento';
$sql .= ' where idt_evento_situacao = 14';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo, representa) values (';
    $sql .= null($row['idt']).", 'EV', 'N')";
    execsql($sql);
}

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_atendimento';
$sql .= ' where idt_evento is not null';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    sincronizaAtendimentoGEC($row['idt']);
}

commit();

echo 'FIM...';
