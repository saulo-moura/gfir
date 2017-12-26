<?php
$idCampo = 'idt';
$Tela = "o Grupo do Cargo";
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


$vetCampo['codigo']          = CriaVetTabela('Código RH');
$vetCampo['descricao']       = CriaVetTabela('Descrição');

$sql   = 'select ';
$sql  .= '   scacag.*  ';
$sql  .= ' from sca_cargo_grupo as scacag ';
$sql  .= ' where scacag.idt_organizacao = '.null($vetFiltro['idt_organizacao']['valor']);
$sql  .= ' order by scacag.codigo ';
?>
