<?php
die('travado...');

require_once '../configuracao.php';

beginTransaction();

$sql = "update grc_evento set tipo_sincroniza_siacweb = 'VX'";
$sql .= " where idt_instrumento in (46,47)";
$sql .= " and tipo_sincroniza_siacweb = 'VF'";

//$sql .= " and idt_evento_situacao in (1,5)";
$sql .= " and idt in (13227)";

execsql($sql);

$sql = '';
$sql .= ' select i.idt_evento, i.idt';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_evento_insumo i on i.idt_evento = e.idt';
$sql .= ' where e.idt_instrumento in (46, 47)';
$sql .= " and tipo_sincroniza_siacweb = 'VX'";
$sql .= " and i.codigo = '70001'";
$sql .= " and i.qtd_automatico = 'N'";
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
    $sql = "update grc_evento_insumo set qtd_automatico = 'S' where idt = " . null($rowPrd['idt']);
    execsql($sql);

    CalcularInsumoEvento($rowPrd['idt_evento']);
}

commit();

echo 'FIM...';
