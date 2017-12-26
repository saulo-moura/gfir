<?php
$ano_base = '2017';

$sql = "SELECT * FROM grc_dw_{$ano_base}_iq";
$rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

echo "<table>";

echo "  <tr>";
echo "      <th>Unidade Regional</th>";
echo "      <th>Ponto Atendimento</th>";
echo "      <th>Indicador 1</th>";
echo "      <th>Indicador 2</th>";
echo "      <th>Indicador 3</th>";
echo "      <th>Indicador 4</th>";
echo "      <th>Indicador 5</th>";
echo "      <th>Geral</th>";
echo "  </tr>";

$unidade = null;
$tot_indicador1 = 0;
$tot_indicador2 = 0;
$tot_indicador3 = 0;
$tot_indicador4 = 0;
$tot_indicador5 = 0;
$tot_indicador_linha = 0;
$tot_geral = 0;
$totlinha_unidade = 0;
ForEach ($rsl->data as $row) {

    IF (!isset($unidade)) {
        $unidade = $row['unidade_regional'];
    }

    if ($unidade == $row['unidade_regional']) {

        $tot_indicador1 = $tot_indicador1 + null($row['indicador_1']);
        $tot_indicador2 = $tot_indicador2 + null($row['indicador_2']);
        $tot_indicador3 = $tot_indicador3 + null($row['indicador_3']);
        $tot_indicador4 = $tot_indicador4 + null($row['indicador_4']);
        $tot_indicador5 = $tot_indicador5 + null($row['indicador_5']);
        $tot_indicador_linha = (null($row['indicador_1']) + null($row['indicador_2']) + null($row['indicador_3']) + null($row['indicador_5'])) / 4;
        $tot_geral = $tot_geral + $tot_indicador_linha;
        $totlinha_unidade++;

        echo "  <tr>";

        if ($totlinha_unidade > 1) {
            echo "      <td>  </td>";
        } else {
            echo "      <td> {$row['unidade_regional']} </td>";
        }

        echo "      <td> {$row['ponto_atendimento']} </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_1'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_2'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_3'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_4'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_5'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador_linha, 2) . " </td>";
        echo "  </tr>";
    } elseif ($unidade <> $row['unidade_regional']) {

        echo "  <tr>";
        echo "      <td colspan=\"2\" style=\"text-align: right\"> TOTAL UR </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador1 / $totlinha_unidade, 2) . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador2 / $totlinha_unidade, 2) . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador3 / $totlinha_unidade, 2) . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador4 / $totlinha_unidade, 2) . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador5 / $totlinha_unidade, 2) . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_geral / $totlinha_unidade, 2) . " </td>";
        echo "  </tr>";

        $unidade = $row['unidade_regional'];
        $tot_indicador1 = 0;
        $tot_indicador2 = 0;
        $tot_indicador3 = 0;
        $tot_indicador4 = 0;
        $tot_indicador5 = 0;
        $tot_indicador_linha = 0;
        $tot_geral = 0;
        $totlinha_unidade = 0;

        $tot_indicador1 = $tot_indicador1 + null($row['indicador_1']);
        $tot_indicador2 = $tot_indicador2 + null($row['indicador_2']);
        $tot_indicador3 = $tot_indicador3 + null($row['indicador_3']);
        $tot_indicador4 = $tot_indicador4 + null($row['indicador_4']);
        $tot_indicador5 = $tot_indicador5 + null($row['indicador_5']);
        $tot_indicador_linha = (null($row['indicador_1']) + null($row['indicador_2']) + null($row['indicador_3']) + null($row['indicador_5'])) / 4;
        $tot_geral = $tot_geral + $tot_indicador_linha;
        $totlinha_unidade++;

        echo "  <tr>";
        echo "      <td> {$row['unidade_regional']} </td>";
        echo "      <td> {$row['ponto_atendimento']} </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_1'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_2'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_3'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_4'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . $row['indicador_5'] . " </td>";
        echo "      <td style=\"text-align: right\"> " . round($tot_indicador_linha, 2) . " </td>";
        echo "  </tr>";
    }
}

echo "  <tr>";
echo "      <td colspan=\"2\" style=\"text-align: right\"> TOTAL UR </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_indicador1 / $totlinha_unidade, 2) . " </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_indicador2 / $totlinha_unidade, 2) . " </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_indicador3 / $totlinha_unidade, 2) . " </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_indicador4 / $totlinha_unidade, 2) . " </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_indicador5 / $totlinha_unidade, 2) . " </td>";
echo "      <td style=\"text-align: right\"> " . round($tot_geral / $totlinha_unidade, 2) . " </td>";
echo "  </tr>";

echo "</table>";
