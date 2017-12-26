<?php
require_once '../configuracao.php';

set_time_limit(0);

beginTransaction();

$sql = '';
$sql .= ' select g.idt, e.codigo';
$sql .= ' from grc_nan_grupo_atendimento g';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
$sql .= ' where year(g.dt_registro_1) = 2017';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select g.idt';
    $sql .= ' from grc_nan_grupo_atendimento g';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
    $sql .= ' where year(g.dt_registro_2) = 2016';
    $sql .= ' and e.codigo = '.aspa($row['codigo']);
    $sql .= " and g.status_2 = 'AP'";
    $rst = execsqlNomeCol($sql);

    if ($rst->rows > 0) {
        $sql = 'update grc_nan_grupo_atendimento set nan_ciclo = 2';
        $sql .= ' where idt = ' . null($row['idt']);
        execsql($sql);
    }
}

commit();

echo 'FIM...';
