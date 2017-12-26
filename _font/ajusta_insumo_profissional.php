<?php
require_once '../configuracao.php';

beginTransaction();


$sql = '';
$sql .= ' select idt as idt_produto_profissional, idt_produto, idt_profissional';
$sql .= ' from grc_produto_profissional';
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
    SincronizaProfissional($rowPrd['idt_produto_profissional'], $rowPrd['idt_produto'], $rowPrd['idt_profissional']);
    CalcularInsumoProduto($rowPrd['idt_produto']);
}

commit();

echo 'FIM...';
