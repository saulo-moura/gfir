<?php
$idCampo = 'idt';
$Tela = "a Rotina do Módulo do Projeto ";
//
// Monta o vetor de Campo
//
$upCad = vetCad('idt', 'Módulo', 'plu_pl_projeto_modulo');
//
$tipofiltro='S';


$Filtro = Array();
$Filtro['campo']    = 'descricao';
$Filtro['tabela']   = 'plu_pl_projeto';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Projeto';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_projeto'] = $Filtro;

$Filtro = Array();
$Filtro['campo']    = 'descricao';
$Filtro['tabela']   = 'plu_pl_projeto_modulo';
$Filtro['id']       = 'idt';
$Filtro['nome']     = 'Módulo';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_modulo'] = $Filtro;

//
$vetCampo['codigo']               = CriaVetTabela('Código');
$vetCampo['descricao']            = CriaVetTabela('Descrição');
$vetCampo['plu_pl_re_descricao']  = CriaVetTabela('Responsavel');
//
$sql   = 'select ';
$sql  .= '   plu_pl_pmr.idt,  ';
$sql  .= '   plu_pl_pmr.*,  ';
$sql  .= '   plu_pl_re.descricao as plu_pl_re_descricao  ';
$sql  .= ' from plu_pl_projeto_modulo_rotina as plu_pl_pmr ';
$sql  .= ' inner join plu_pl_responsavel as plu_pl_re on plu_pl_re.idt = plu_pl_pmr.idt_responsavel ';
$sql  .= ' where plu_pl_pmr.idt_modulo = '.null($vetFiltro['idt_modulo']['valor']);
$sql  .= ' order by plu_pl_pmr.codigo';
//
?>
