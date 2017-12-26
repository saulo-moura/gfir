<?php


$menu='empreendimento';
$path = 'listar_conf/'.$menu.'.php';
$geral_empree='S';
if (file_exists($path)) {
	Require_Once($path);
} else {
    echo "<br><br><div align='center' class='Msg'>Função em desenvolvimento...</div>";
    onLoadPag();
    FimTela();
    exit();
}

?>