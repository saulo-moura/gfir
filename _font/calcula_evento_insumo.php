<?php
require_once '../configuracao.php';

beginTransaction();

$sql = '';
$sql .= ' select idt';
$sql .= ' from grc_evento';
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
	CalcularInsumoEvento($rowPrd['idt']);
}

commit();

echo 'FIM...';
