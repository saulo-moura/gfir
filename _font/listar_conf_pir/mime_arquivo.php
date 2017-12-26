<?php
$idCampo = 'idt_miar';
$Tela = "o arquivo";
$num_col_tab = 1;

$goCad[] = vetCad('idt_miar', 'Mime do Arquivo', 'mime_tipo');

//Monta o vetor de Campo
$vetCampo['des_extensao'] = CriaVetTabela('Extensão');

$sql = 'select * from mime_arquivo order by des_extensao';
?>