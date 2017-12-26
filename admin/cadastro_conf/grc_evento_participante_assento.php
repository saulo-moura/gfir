<?php
$path = $dir_file . '/grc_evento_local_pa_tipo_assento/';
$htmlLocal = '';

$sql = '';
$sql .= ' select pm.idt, pm.descricao';
$sql .= ' from grc_evento ep';
$sql .= ' inner join grc_evento_mapa pm on pm.idt_evento = ep.idt';
$sql .= ' where ep.idt = ' . null($idt_evento);
$sql .= " and ep.assento_marcado = 'S'";
$rsAEP = execsql($sql);

foreach ($rsAEP->data as $rowAEP) {
    $sql = '';
    $sql .= ' select a.idt, a.codigo, a.descricao, a.ativo, a.linha, a.coluna, t.descricao as tipo, t.imagem, t.imagem_d,';
    $sql .= ' a.idt_matricula_utilizado';
    $sql .= ' from grc_evento_mapa_assento a';
    $sql .= ' inner join grc_evento_local_pa_tipo_assento t on t.idt = a.idt_tipo_assento';
    $sql .= ' where a.idt_evento_mapa = ' . null($rowAEP['idt']);
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

    $htmlLocal .= '<center>';
    $htmlLocal .= '<h1>' . $rowAEP['descricao'] . '</h1>';
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
                $alt = $row['codigo'];

                if ($row['codigo'] != $row['descricao']) {
                    $alt .= ' - ' . $row['descricao'];
                }

                $alt_reg = assentoMarcadoAlt;

                if ($row['ativo'] != 'S') {
                    $alt_reg = false;
                }

                if ($row['idt_matricula_utilizado'] != '') {
                    if ($row['idt_matricula_utilizado'] != $_GET['id']) {
                        $alt_reg = false;
                    }
                }

                if ($alt_reg) {
                    $img = $row['imagem'];
                    $comp = 'style="cursor: pointer;" onclick="marcaAssento(this, ' . $row['idt'] . ', ' . $_GET['id'] . ')"';
                } else {
                    $img = $row['imagem_d'];
                    $comp = '';
                }

                $img_src = $path . $img;

                if ($row['idt_matricula_utilizado'] == $_GET['id']) {
                    $img_src = 'imagens/assento_sel.png';
                }

                $htmlLocalTD .= '<img src="' . $img_src . '" data-img="' . $path . $img . '" width="32" title="' . $alt . '" ' . $comp . ' />';
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
}

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
    return rawurlencode($htmlLocal);
} else {
    echo $htmlLocal;
}
