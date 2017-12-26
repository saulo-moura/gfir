<?php
$path = $dir_file . '/grc_evento_local_pa_tipo_assento/';

$sql = '';
$sql .= ' select a.idt, a.codigo, a.descricao, a.ativo, a.linha, a.coluna, t.descricao as tipo, t.imagem, t.imagem_d';
$sql .= ' from grc_evento_local_pa_mapa_assento a';
$sql .= ' inner join grc_evento_local_pa_tipo_assento t on t.idt = a.idt_tipo_assento';
$sql .= ' where a.idt_local_pa_mapa = ' . null($_GET['id']);
$sql .= ' order by a.linha, a.coluna';
$rs = execsql($sql);

$vetDados = Array();

foreach ($rs->data as $row) {
    $vetDados[$row['linha']][$row['coluna']] = $row;
}

$totCol = 0;

foreach ($vetDados as $row) {
    $tot = count($row);

    if ($tot > $totCol) {
        $totCol = $tot;
    }
}

$htmlLocal = '';
$htmlLocal .= '<center>';
$htmlLocal .= 'Frente';
$htmlLocal .= '<table id="mapa_tabela">';
$htmlLocal .= '<thead>';
$htmlLocal .= '<tr>';
$htmlLocal .= '<th></th>';

for ($col = 1; $col <= $totCol; $col++) {
    $htmlLocal .= '<th>' . $col . '</th>';
}

$htmlLocal .= '<th></th>';
$htmlLocal .= '</tr>';
$htmlLocal .= '</thead>';
$htmlLocal .= '<tbody>';

foreach ($vetDados as $lin => $vetCol) {
    $htmlLocal .= '<tr>';
    $htmlLocal .= '<td>' . getLetterFromNumber($lin) . '</td>';

    for ($col = 1; $col <= $totCol; $col++) {
        $row = $vetCol[$col];
        $htmlLocalTD = '';

        if ($row != '') {
            if ($row['ativo'] == 'S') {
                $img = $row['imagem'];
            } else {
                $img = $row['imagem_d'];
            }

            $alt = $row['codigo'];

            if ($row['codigo'] != $row['descricao']) {
                $alt .= ' - ' . $row['descricao'];
            }

            if ($acao == 'alt') {
                $comp = 'style="cursor: pointer;" onclick="abreALT(' . $row['idt'] . ')"';
            } else {
                $comp = '';
            }

            $htmlLocalTD .= '<img src="' . $path . $img . '" width="32" title="' . $alt . '" ' . $comp . ' />';
        }

        $htmlLocal .= '<td>';
        $htmlLocal .= $htmlLocalTD;
        $htmlLocal .= '</td>';
    }

    $htmlLocal .= '<td>' . getLetterFromNumber($lin) . '</td>';
    $htmlLocal .= '</tr>';
}

$htmlLocal .= '</tbody>';
$htmlLocal .= '<tfoot>';
$htmlLocal .= '<tr>';
$htmlLocal .= '<th></th>';

for ($col = 1; $col <= $totCol; $col++) {
    $htmlLocal .= '<th>' . $col . '</th>';
}

$htmlLocal .= '<th></th>';
$htmlLocal .= '</tr>';
$htmlLocal .= '</tfoot>';
$htmlLocal .= '</table>';
$htmlLocal .= 'Fundo';

$sql = '';
$sql .= ' select descricao, imagem';
$sql .= ' from grc_evento_local_pa_tipo_assento';
$sql .= ' order by descricao';
$rs = execsql($sql);

$htmlLocal .= '<div id="legenda">';

foreach ($rs->data as $row) {
    $htmlLocal .= '<span class="legenda"><img class="legenda" src="' . $path . $row['imagem'] . '" width="32" />' . $row['descricao'] . '</span>';
}

$htmlLocal .= '</div>';

$htmlLocal .= '</center>';

if ($ajax == 'S') {
    echo rawurlencode($htmlLocal);
} else {
    echo $htmlLocal;
}
