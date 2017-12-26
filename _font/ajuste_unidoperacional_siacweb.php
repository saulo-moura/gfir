<?php
require_once '../configuracao.php';

$conSIAC = conSIAC();

beginTransaction();

$sql = '';
$sql .= ' select codunidop, rowguid';
$sql .= ' from unidoperacional';
$rsPrd = execsql($sql, true, $conSIAC);

foreach ($rsPrd->data as $rowPrd) {
    $sql = 'update '.db_pir_siac.'unidoperacional set rowguid = '.aspa($rowPrd['rowguid']).' where codunidop = '.null($rowPrd['codunidop']);
    execsql($sql);
}

commit();

echo 'FIM...';
