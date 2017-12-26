<?php
$sql = '';
$sql .= ' select p.descricao as pd, pa.descricao as pda, count(grc_a.idt) as tot';
$sql .= ' from grc_atendimento grc_a ';
$sql .= ' inner join grc_projeto p on p.idt = grc_a.idt_projeto';
$sql .= ' inner join grc_projeto_acao pa on pa.idt = grc_a.idt_projeto_acao';
$sql .= ' where grc_a.idt_nan_ordem_pagamento = '.null($_GET['id']);
$sql .= ' group by p.descricao, pa.descricao';
$sql .= ' order by p.descricao, pa.descricao';
$rsx = execsql($sql);

if ($rsx->rows > 1) {
    echo '<br />';
    echo '<table class="Generica" cellspacing="0" cellpadding="0" border="0" align="center">';
    echo '<tr class="Generica">';
    echo '<td class="Titulo">Projeto</td>';
    echo '<td class="Titulo">Ação</td>';
    echo '<td class="Titulo">Qtd. Visita</td>';
    echo '</tr>';

    foreach ($rsx->data as $i => $rowx) {
        $lp = ($i % 2) == 0 ? '' : '1';
        
        echo '<tr class="Registro'.$lp.'">';
        echo '<td class="Registro">'.$rowx['pd'].'</td>';
        echo '<td class="Registro">'.$rowx['pda'].'</td>';
        echo '<td class="Registro">'.$rowx['tot'].'</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '<br />';
}
