<?php
$idCampo = 'idt';
$bt_mais = false;
$bt_prefixo = 'det';
$reg_pagina = 80;
$ver_tabela = true;
$tipofiltro='S';

    $upCad = vetCad('', 'Sistema', 'sca_sistema');
    $Filtro = Array();
    $Filtro['campo'] = 'descricao';
    $Filtro['tabela'] = 'sca_sistema';
    $Filtro['id'] = 'idt';
    $Filtro['nome'] = 'Sistema';
    $Filtro['valor'] = trata_id($Filtro);
    $vetFiltro['sca_sistema'] = $Filtro;

//Monta o vetor de Campo
$vetTipo=Array();
$vetTipo['1']='Gestor Sistema';
$vetTipo['2']='Administrador Sistema';
$vetTipo['3']='Usuário Máster';
$vetTipo['4']='Técnico TI';
$vetTipo['5']='Técnico Mantenedor';
$vetCampo['tipo']             = CriaVetTabela('Tipo','descDominio',$vetTipo);

$vetMaster=Array();
$vetMaster['N']='Não';
$vetMaster['S']='Sim';
$vetCampo['master']             = CriaVetTabela('Master(aprova Login e Perfil)?','descDominio',$vetMaster);


$vetCampo['us_nome_completo'] = CriaVetTabela('Nome');
$vetCampo['telefones']        = CriaVetTabela('Telefones');
$vetCampo['emails']           = CriaVetTabela("Email's");


$sql  = '';
$sql .= ' select ';
$sql .= ' scasr.idt, scasr.*, us.nome_completo as us_nome_completo,  ';
$sql .= ' concat_ws("<br />",telefone1,telefone2,telefone3) as telefones,  ';
$sql .= ' concat_ws("<br />",email1,email2,email3) as emails  ';
$sql .= ' from sca_sistema_responsavel scasr ';
$sql .= ' inner join usuario us on us.id_usuario = scasr.idt_responsavel ';
$sql .= ' where scasr.idt_sistema = '.null($vetFiltro['sca_sistema']['valor']);
$sql .= ' order by scasr.tipo, us.nome_completo';

?>