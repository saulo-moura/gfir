<?php

echo "<tr>";

echo "<td colspan='3' style='font-size:14px; background:#C0C0C0; text-align:right;'>";

echo $texto_total;

echo "</td>";


echo "<td  style=' font-size:14px; background:#C0C0C0; text-align:right; '>";

echo format_decimal($valor_total_falta_mes,0);

echo "</td>";

echo "<td font-size:14px; style='background:#C0C0C0; text-align:right;'>";

echo '&nbsp;';

echo "</td>";

echo "<td style='font-size:14px; background:#C0C0C0; text-align:right; '>";

echo format_decimal($valor_total_atestado_mes,0);

echo "</td>";

echo "<td  style='background:#C0C0C0; text-align:right;'>";

echo '&nbsp;';

echo "</td>";

echo "<td style='font-size:14px; background:#C0C0C0; text-align:right; '>";

echo format_decimal($valor_total_dias_atestados,0);

echo "</td>";

echo "<td  style='background:#C0C0C0; text-align:right;'>";

echo '&nbsp;';

echo "</td>";



echo "</tr>";
?>