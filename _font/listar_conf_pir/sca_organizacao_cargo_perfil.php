<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 80;
$ver_tabela = true;
$tipofiltro='S';

$upCad = vetCad('idt,idt', 'Cargo', 'sca_organizacao_cargo');


$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_estrutura_organizacional';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organização';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;


$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_organizacao_secao';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Seção';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sca_organizacao_secao'] = $Filtro;



$Filtro = Array();
$Filtro['campo'] = 'descricao';
$Filtro['tabela'] = 'sca_organizacao_cargo';
$Filtro['id'] = 'idt';
$Filtro['nome'] = 'Cargo';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['sca_organizacao_cargo'] = $Filtro;


//$vetCampo['processo']           = CriaVetTabela('Processo');

$vetCampo['scae_classificacao'] = CriaVetTabela('Classificacão');
$vetCampo['scae_descricao']     = CriaVetTabela('Processo');
$sql  = '';
$sql .= ' select ';
$sql .= ' scaocp.idt, scaocp.* ,';
$sql .= '  per.nm_perfil     as scae_descricao, ';
$sql .= '  per.classificacao as scae_classificacao ';
$sql .= ' from sca_organizacao_cargo_perfil scaocp ';

$sql .= ' left  join perfil per  on per.id_perfil = scaocp.idt_perfil ';
$sql .= ' where scaocp.idt_cargo = '.null($vetFiltro['sca_organizacao_cargo']['valor']);
$sql .= ' order by per.classificacao ';

?>