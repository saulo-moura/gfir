<?php
$veio_assinatura='S';
$pathw='cadastro_conf/site_perfil.php';
if (file_exists($pathw)) {
	Require_Once($pathw);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}
?>
