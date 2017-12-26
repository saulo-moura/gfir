<?php
header(”Content-type: application/vnd.ms-excel”);
header(”Content-type: application/force-download”);
header(”Content-Disposition: attachment; filename=relatorio.xls”);
header(”Pragma: no-cache”);
echo ”
<table>
<tr>
<td>Linha 1 - Coluna 1</td>
<td>Linha 1 - Coluna 2</td>
<td>Linha 1 - Coluna 3</td>
<td>Linha 1 - Coluna 4</td>
<td>Linha 1 - Coluna 5</td>
<td>Linha 1 - Coluna 6</td>
</tr>
<tr>
<td>Linha 2 - Coluna 1</td>
<td>Linha 2 - Coluna 2</td>
<td>Linha 2 - Coluna 3</td>
<td>Linha 2 - Coluna 4</td>
<td>Linha 2 - Coluna 5</td>
<td>Linha 2 - Coluna 6</td>
</tr>
<tr>
<td>Linha 3 - Coluna 1</td>
<td>Linha 3 - Coluna 2</td>
<td>Linha 3 - Coluna 3</td>
<td>Linha 3 - Coluna 4</td>
<td>Linha 3 - Coluna 5</td>
<td>Linha 3- Coluna 6</td>
</tr>
</table>
“;
?>