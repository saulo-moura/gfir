<?php
$idCampo = 'id_funcao';
$Tela = "a funзгo Site";

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_classificacao';
$Filtro['nome'] = 'Classificaзгo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'nm_funcao';
$Filtro['nome'] = 'Nome';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'cod_funcao';
$Filtro['nome'] = 'Transaзгo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['cod_funcao'] = $Filtro;

//Monta o vetor de Campo
$vetCampo['cod_classificacao'] = CriaVetTabela('Classificaзгo');
$vetCampo['nm_funcao'] = CriaVetTabela('Nome');
$vetCampo['cod_funcao'] = CriaVetTabela('Transaзгo');
$vetCampo['sts_menu'] = CriaVetTabela('Mostra Menu', 'descDominio', $vetSimNao);
$vetCampo['cod_assinatura'] = CriaVetTabela('Cуdigo<br>Assinatura');
//$vetCampo['seto_descricao'] = CriaVetTabela('Setor');
//$sql  = 'select fun.*, seto.descricao as seto_descricao ';

$sql  = 'select fun.* ';

$sql .= ' from site_funcao fun ';
//$sql .= '  left join setor seto on seto.idt = fun.idt_setor ';
$sql .= ' where ';
$sql .= ' lower(cod_classificacao) like lower('.aspa($vetFiltro['cod_classificacao']['valor'], '', '%').')';   
$sql .= ' and lower(nm_funcao) like lower('.aspa($vetFiltro['nm_funcao']['valor'], '%', '%').')';   
$sql .= ' and lower(cod_funcao) like lower('.aspa($vetFiltro['cod_funcao']['valor'], '%', '%').')';   
$sql .= ' order by cod_classificacao';



?>