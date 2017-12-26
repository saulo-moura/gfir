<?php
require_once 'configuracao.php';

beginTransaction();

$sql = '';
$sql .= ' select idt, painel_altura, painel_largura';
$sql .= ' from plu_painel';
$rsp = execsql($sql);

foreach ($rsp->data as $rowp) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from plu_painel_funcao';
    $sql .= ' where idt_painel = '.null($rowp['idt']);
    $sql .= ' and idt_painel_grupo is null';
    $rsg = execsql($sql);

    if ($rsg->rows > 0) {
        $sql = 'insert into plu_painel_grupo (idt_painel, codigo, ordem, descricao, mostra_barra, painel_altura, painel_largura) values (';
        $sql .= null($rowp['idt']).", 'geral', 1, 'Geral', 'N', ".null($rowp['painel_altura']).', '.null($rowp['painel_largura']).')';
        execsql($sql);

        $sql = 'update plu_painel_funcao set idt_painel_grupo = '.null(lastInsertId());
        $sql .= ' where idt_painel = '.null($rowp['idt']);
        $sql .= ' and idt_painel_grupo is null';
        execsql($sql);
    }
}

$sql = 'update plu_painel_grupo g inner join plu_painel p on g.idt_painel = p.idt set';
$sql .= ' g.mostra_item = p.mostra_item,';
$sql .= ' g.texto_altura = p.texto_altura,';
$sql .= ' g.move_item = p.move_item,';
$sql .= ' g.passo = p.passo,';
$sql .= ' g.layout_grid = p.layout_grid,';
$sql .= ' g.img_altura = p.img_altura,';
$sql .= ' g.img_largura = p.img_largura,';
$sql .= ' g.img_margem_dir = p.img_margem_dir,';
$sql .= ' g.img_margem_esq = p.img_margem_esq,';
$sql .= ' g.espaco_linha = p.espaco_linha';
execsql($sql);

commit();

echo 'Fim...';