<?php


$barra_inc_ap=false;
//$barra_alt_ap
//$barra_con_ap
$barra_exc_ap=false;



$veio_assinatura='S';
$pathw='listar_conf/site_perfil.php';
if (file_exists($pathw)) {
	Require_Once($pathw);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}
?>
