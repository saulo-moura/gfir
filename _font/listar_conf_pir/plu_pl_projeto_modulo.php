<?php
$idCampo = 'idt';
$Tela = "o Módulo do Projeto ";
//
// Monta o vetor de Campo
//
$goCad[] = vetCad('idt,idt', 'Rotinas do Módulo', 'plu_pl_projeto_modulo_rotina');

$upCad = vetCad('', 'Projeto', 'plu_pl_projeto');
//
$tipofiltro='S';


$Filtro = Array();
$Filtro['campo']    = 'descricao';
$Filtro['tabela']   = 'plu_pl_projeto';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Projeto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_projeto'] = $Filtro;
//
$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
$vetCampo['plu_pl_re_descricao']  = CriaVetTabela('Responsavel');
//
$sql   = 'select ';
$sql  .= '   plu_pl_pm.idt,  ';
$sql  .= '   plu_pl_pm.*,  ';
$sql  .= '   plu_pl_re.descricao as plu_pl_re_descricao  ';
$sql  .= ' from plu_pl_projeto_modulo as plu_pl_pm ';
$sql  .= ' inner join plu_pl_responsavel as plu_pl_re on plu_pl_re.idt = plu_pl_pm.idt_responsavel ';
$sql  .= ' where plu_pl_pm.idt_projeto = '.null($vetFiltro['idt_projeto']['valor']);
$sql  .= ' order by plu_pl_pm.codigo';
//
?>
