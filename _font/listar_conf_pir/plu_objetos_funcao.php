<?php
$idCampo = 'idt';
$Tela = "o Objeto da Função";
//
// Monta o vetor de Campo
//
$upCad = vetCad('p_cod_classificacao,p_nm_funcao,p_cod_funcao,p_classifica', 'Função', 'funcao');
//
$tipofiltro='S';

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_classificacao';
$Filtro['valor'] = trata_id($Filtro);
$Filtro['rs'] = '';
$vetFiltro['cod_classificacao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_nm_funcao';
$Filtro['valor'] = trata_id($Filtro);
$Filtro['rs'] = '';
$vetFiltro['nm_funcao'] = $Filtro;

$Filtro = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id'] = 'p_cod_funcao';
$Filtro['valor'] = trata_id($Filtro);
$Filtro['rs'] = '';
$vetFiltro['cod_funcao'] = $Filtro;

$Filtro         = Array();
$Filtro['rs'] = 'Texto';
$Filtro['id']   = 'p_classifica';
$Filtro['valor'] = trata_id($Filtro);
$Filtro['rs'] = '';
$vetFiltro['classifica'] = $Filtro;

$Filtro = Array();
$Filtro['campo']    = 'nm_funcao';
$Filtro['tabela']   = 'funcao';
$Filtro['id']       = 'id_funcao';
$Filtro['nome']     = 'Função';
$Filtro['valor']    = trata_id($Filtro);
$vetFiltro['idt_funcao'] = $Filtro;
//
$vetCampo['codigo']    = CriaVetTabela('Classificação');
$vetCampo['descricao'] = CriaVetTabela('Descrição');
$vetCampo['plu_to_descricao'] = CriaVetTabela('Tipo');
//
$sql   = 'select ';
$sql  .= '   plu_of.idt,  ';
$sql  .= '   plu_of.*,  ';
$sql  .= '   plu_to.descricao as plu_to_descricao ';
$sql  .= ' from plu_objetos_funcao as plu_of ';
$sql  .= ' left  join plu_tipo_objeto plu_to on plu_to.idt = plu_of.idt_tipo_objeto';
$sql  .= ' where plu_of.idt_funcao = '.null($vetFiltro['idt_funcao']['valor']);
$sql  .= ' order by plu_of.codigo';
//
?>
