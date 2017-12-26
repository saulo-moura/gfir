<?php
require_once '../configuracao.php';

beginTransaction();

$sql = '';
$sql .= ' select idt';
$sql .= ' from '.db_pir_gec.'gec_profissional';
$sql .= " where codigo = '00'";
$rs = execsql($sql);
$idt_profissional = $rs->data[0][0];

$sql = '';
$sql .= ' select idt, necessita_credenciado';
$sql .= ' from grc_produto';
$sql .= ' where idt_programa = 4';
$rsPrd = execsql($sql);

foreach ($rsPrd->data as $rowPrd) {
    if ($rowPrd['necessita_credenciado'] == 'S') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_produto_profissional';
        $sql .= ' where idt_produto = '.null($rowPrd['idt']);
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = 'insert into grc_produto_profissional (idt_produto, idt_profissional, observacao) values (';
            $sql .= null($rowPrd['idt']).', '.null($idt_profissional).", 'Registro Automático')";
            execsql($sql);
            $idt_produto_profissional = lastInsertId();
        } else {
			$idt_produto_profissional = $rs->data[0][0];
		}
		
		SincronizaProfissional($idt_produto_profissional, $rowPrd['idt'], $idt_profissional);
		CalcularInsumoProduto($rowPrd['idt']);
    }
}

commit();

echo 'FIM...';
