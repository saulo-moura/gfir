<?php
$idCampo = 'idt_miti';
$Tela = "o mime do arquivo";
$num_col_tab = 1;

$upCad = vetCad('', 'Arquivo', 'plu_mime_arquivo');

$Filtro = Array();
$Filtro['campo'] = 'des_extensao';
$Filtro['tabela'] = 'plu_mime_arquivo';
$Filtro['id'] = 'idt_miar';
$Filtro['nome'] = 'Arquivo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['arquivo'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['des_tipo'] = CriaVetTabela('Mime do Arquivo');

$sql = 'select * from plu_mime_tipo where idt_miar = '.$vetFiltro['arquivo']['valor'].' order by des_tipo';
?>