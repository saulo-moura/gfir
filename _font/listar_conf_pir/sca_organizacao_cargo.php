<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 80;
$ver_tabela = true;
$tipofiltro='S';

$upCad = vetCad('idt', 'Seзгo', 'sca_organizacao_secao');

$goCad[] = vetCad('idt,idt,idt', 'Processos', 'sca_organizacao_cargo_processo');
$goCad[] = vetCad('idt,idt,idt', 'Perfil', 'sca_organizacao_cargo_perfil');


$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_estrutura_organizacional';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organizaзгo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;

$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_organizacao_secao';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Seзгo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sca_organizacao_secao'] = $Filtro;

$vetCampo['codigo']     = CriaVetTabela('Cуdigo');
$vetCampo['descricao']        = CriaVetTabela('Descriзгo');
$vetCampo['agrupamento']           = CriaVetTabela("Agrupamento");


$sql  = '';
$sql .= ' select ';
//$sql .= ' scaoc.idt, scaoc.* , scaos.localidade as scaos_localidade ';
$sql .= ' scaoc.idt, scaoc.*  ';
$sql .= ' from sca_organizacao_cargo scaoc ';
//$sql .= ' inner join sca_organizacao_secao scaos on scaos.idt = scaoc.idt_secao';
$sql .= ' where scaoc.idt_secao = '.null($vetFiltro['sca_organizacao_secao']['valor']);
$sql .= ' order by scaoc.agrupamento, scaoc.codigo';

?>