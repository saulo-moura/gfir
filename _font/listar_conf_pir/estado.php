<?php
$idCampo = 'idt';
$Tela = "o Estado";

$goCad[] = vetCad('idt', 'Cidades', 'cidade');

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'texto';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['texto'] = $Filtro;


//Monta o vetor de Campo
$vetCampo['codigo'] = CriaVetTabela('Cуdigo');
$vetCampo['descricao'] = CriaVetTabela('Descriзгo');
$vetCampo['imagem'] = CriaVetTabela('Unidade Federaзгo', 'arquivo', '200', 'estado');

$sql = 'select * from '.$pre_table.'estado where ';
$sql .= ' lower(codigo) like lower('.aspa($vetFiltro['texto']['valor'], '', '%').')';
$sql .= ' and lower(descricao) like lower('.aspa($vetFiltro['texto']['valor'], '%', '%').')';
$sql .= ' order by descricao';
?>