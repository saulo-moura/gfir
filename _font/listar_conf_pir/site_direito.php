<?php
$idCampo = 'id_direito';
$Tela = "o direito";

//Monta o vetor de Campo
$vetCampo['nm_direito'] = CriaVetTabela('Nome');
$vetCampo['cod_direito'] = CriaVetTabela('C�digo');

$sql = 'select * from site_direito order by nm_direito';
?>