<?php
$idCampo = 'idt';
$Tela = "a Regiуo";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'idt';
$Filtro['js_tam'] = '0';
$Filtro['nome'] = 'Texto';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['descricao'] = $Filtro;



//Monta o vetor de Campo
$vetCampo['sigla'] = CriaVetTabela('Sigla');
$vetCampo['descricao'] = CriaVetTabela('Descriчуo');
$vetCampo['re_descricao'] = CriaVetTabela('Regiуo');

$sql   = 'select re.idt, re.sigla, re.descricao, es.codigo as es_codigo, es.descricao as es_descricao from cidade re ';
$sql  .= ' inner join estado es on es.idt = re.idt_estado ';
$sql  .= ' order by re.descricao'
?>