<?php
$idCampo = 'idt';
$Tela = "o Cargo";
//Monta o vetor de Campo
$sql  = "select sca_eo.idt, sca_eo.codigo, sca_eo.descricao from sca_estrutura_organizacional sca_eo";
$sql .= " order by sca_eo.descricao";
$Filtro = Array();
$Filtro['rs']       = execsql($sql);
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Organização';
$Filtro['valor'] = trata_id($Filtro);
$vetFiltro['idt_organizacao'] = $Filtro;

$tipofiltro='S';

$vetCampo['scaac_descricao'] = CriaVetTabela('Grupo');

$vetCampo['codigo']          = CriaVetTabela('Código RH');
$vetCampo['descricao']       = CriaVetTabela('Descrição');

$sql   = 'select ';
$sql  .= '   scaca.*,  ';
$sql  .= '   scaac.descricao as scaac_descricao   ';
$sql  .= ' from sca_cargo as scaca ';
$sql  .= ' left join sca_cargo_grupo scaac on scaac.idt             = scaca.idt_agrupa_cargo';
$sql  .= '                                and scaac.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);
$sql  .= ' where scaca.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);
$sql  .= ' order by scaac.codigo, scaca.codigo ';
?>
