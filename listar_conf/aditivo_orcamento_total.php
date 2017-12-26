<?php

echo "<tr>";

echo "<td colspan='2' style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

echo $texto_total;

echo "</td>";
echo "<td style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

echo format_decimal($total_incc,2);

echo "</td>";
echo "<td style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

echo format_decimal($total_real,2);

echo "</td>";

echo "<td style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

echo format_decimal($total_dias,0);

echo "</td>";

echo "<td style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

echo '  ';

echo "</td>";

//echo "<td style='background:#C0C0C0; text-align:right; font-weight: bold;'>";

//echo '  ';

//echo "</td>";

echo "</tr>";
?>