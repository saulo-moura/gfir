<?php
$idCampo = 'idt_migr';
$Tela = "o grupo";

//Monta o vetor de Campo
$vetCampo['des_gurpo'] = CriaVetTabela('Descri��o');

$sql = 'select * from mime_grupo order by des_gurpo';
?>