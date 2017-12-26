<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 80;
$ver_tabela = true;
$tipofiltro='S';

$upCad = vetCad('idt', 'Se��o', 'sca_organizacao_secao');


$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_estrutura_organizacional';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organiza��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;


$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_organizacao_secao';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Se��o';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sca_organizacao_secao'] = $Filtro;

$vetCampo['codigo']          = CriaVetTabela('C�digo');
$vetCampo['nome']       = CriaVetTabela('Descri��o');
$vetCampo['scaoc_descricao'] = CriaVetTabela("Cargo");


$sql  = '';
$sql .= ' select ';
//$sql .= ' scaoc.idt, scaoc.* , scaos.localidade as scaos_localidade ';
$sql .= ' scaop.idt, scaop.* , scaoc.descricao as scaoc_descricao ';
$sql .= ' from sca_organizacao_pessoa scaop ';
$sql .= ' left join sca_organizacao_cargo scaoc on scaoc.idt = scaop.idt_cargo';
$sql .= ' where scaop.idt_secao = '.null($vetFiltro['sca_organizacao_secao']['valor']);
$sql .= ' order by scaop.nome';

?>