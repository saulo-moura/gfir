<?php
die('travado...');

require_once '../configuracao.php';

beginTransaction();

$sql = '';
$sql .= ' select i.idt_evento, i.idt';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_evento_insumo i on i.idt_evento = e.idt';
$sql .= ' where e.idt_instrumento in (46, 47)';
$sql .= " and i.codigo = '70001'";
$sql .= " and i.qtd_automatico = 'S'";
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
        $sql = "update grc_evento_insumo set qtd_automatico = 'N', quantidade = 1 where idt = ".null($rowPrd['idt']);
        execsql($sql);
    
	CalcularInsumoEvento($rowPrd['idt_evento']);
}

commit();

echo 'FIM...';
