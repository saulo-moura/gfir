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



$vetCampo['scae_classificacao'] = CriaVetTabela('Classificacão');
$vetCampo['scae_descricao']     = CriaVetTabela('Processo');
$vetCampo['scate_descricao']     = CriaVetTabela('Tipo');


$vetCampo['classificacao']      = CriaVetTabela('Código<br />Atividade');
$vetCampo['processo']           = CriaVetTabela('Atividade');

$vetCampo['scas_descricao']           = CriaVetTabela('Sistema<br />Computacional');

$vetCampo['fun_nm_funcao']           = CriaVetTabela('Programa<br />Computacional');

//$vetCampo['scae_sistema_executa']    = CriaVetTabela('Sistema');
//$vetCampo['scae_transacao']          = CriaVetTabela('Transação');

$sql  = '';
$sql .= ' select ';
$sql .= ' scaocp.idt, scaocp.* ,';
$sql .= '  scae.classificacao as scae_classificacao, ';
$sql .= '  scae.descricao as scae_descricao, ';
$sql .= '  scae.sistema_executa as scae_sistema_executa, ';
$sql .= '  scae.transacao as scae_transacao, ';
$sql .= '  scate.descricao as scate_descricao, ';

$sql .= '  scas.descricao as scas_descricao, ';
$sql .= '  fun.nm_funcao as fun_nm_funcao ';

$sql .= ' from sca_organizacao_cargo_processo scaocp ';

//$sql .= ' left join sca_estrutura scae on substring(scae.classificacao,1,8) = scaocp.classificacao ';
$sql .= ' inner join sca_estrutura scae on scae.idt = scaocp.idt_processo ';
$sql .= ' left  join sca_sistema   scas on scas.idt = scaocp.idt_sistema ';
$sql .= ' left  join funcao        fun  on fun.id_funcao  = scaocp.idt_funcao ';
$sql .= ' left  join sca_tipo_estrutura scate on scate.idt = scae.idt_sca_tipo_estrutura ';
$sql .= ' where scaocp.idt_cargo = '.null($vetFiltro['sca_organizacao_cargo']['valor']);
$sql .= ' order by scaocp.classificacao, scae.classificacao';

?>