<?php
onLoadPag();

$sql = 'select des_html from html where menu = '.aspa($menu);
$rs = execsql($sql);
$row = $rs->data[0];
echo $row['des_html'];
?>


<div align="center"> <a href="conteudo.php"><img src="imagens/volt.jpg" alt="Voltar" border="0" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;</a></div>