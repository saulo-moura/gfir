<?php
require_once '../configuracao.php';

beginTransaction();

$sql = 'update grc_produto set idt_programa = null';
$sql .= ' where idt_programa > 5';
execsql($sql);

$sql = '';
$sql .= ' select e.idt, p.idt_programa';
$sql .= ' from grc_evento e';
$sql .= ' left outer join grc_produto p on p.idt = e.idt_produto';
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
    $sql = 'update grc_evento set idt_programa = '.null($rowPrd['idt_programa']);
    $sql .= ' where idt = '.null($rowPrd['idt']);
    execsql($sql);
}

commit();

echo 'FIM...';
