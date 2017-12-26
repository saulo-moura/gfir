<?php
$idCampo = 'idt_miar';
$Tela = "o arquivo";
$num_col_tab = 1;

$goCad[] = vetCad('idt_miar', 'Mime do Arquivo', 'plu_mime_tipo');

//Monta o vetor de Campo
$vetCampo['des_extensao'] = CriaVetTabela('Extensão');

$sql = 'select * from plu_mime_arquivo order by des_extensao';
?>