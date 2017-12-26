<?php
$idCampo = 'idt_migr';
$Tela = "o grupo";

//Monta o vetor de Campo
$vetCampo['des_gurpo'] = CriaVetTabela('Descriчуo');

$sql = 'select * from mime_grupo order by des_gurpo';
?>