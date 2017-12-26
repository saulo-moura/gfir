<?php
$idCampo = 'idt';
$Tela = "o EAD";
//Monta o vetor de Campo

//$goCad[] = vetCad('idt', 'Módulos do Projeto', 'plu_pl_projeto_modulo');

//$goCad[] = vetCad('idt', 'Requisitos do Projeto', 'plu_pl_requisitos');

$vetCampo['classificacao']        = CriaVetTabela('Classificão');
$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
$vetCampo['plu_pl_pn_descricao']  = CriaVetTabela('Natureza');
$vetCampo['plu_pl_re_descricao']  = CriaVetTabela('Responsavel');
//
$sql   = 'select ';
$sql  .= '   plu_pl_p.idt,  ';
$sql  .= '   plu_pl_p.*,  ';
$sql  .= '   plu_pl_re.codigo as plu_pl_re_codigo,  ';
$sql  .= '   plu_pl_re.descricao as plu_pl_re_descricao,  ';
$sql  .= '   plu_pl_pn.descricao as plu_pl_pn_descricao  ';
$sql  .= ' from plu_pl_ead as plu_pl_p ';
$sql  .= ' inner join plu_pl_responsavel as plu_pl_re on plu_pl_re.idt = plu_pl_p.idt_responsavel ';
$sql  .= ' inner join plu_pl_ead_natureza as plu_pl_pn on plu_pl_pn.idt = plu_pl_p.idt_natureza ';
$sql  .= ' order by plu_pl_p.codigo';
?>
