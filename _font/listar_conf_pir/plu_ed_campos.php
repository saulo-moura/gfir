<?php
$idCampo = 'idt';
$Tela = "os Campos";
//Monta o vetor de Campo

$vetCampo['plu_cn_descricao'] = CriaVetTabela('Natureza');
$vetCampo['codigo']             = CriaVetTabela('Código');
$vetCampo['descricao']          = CriaVetTabela('Descrição');
//$vetCampo['plu_edct_codigo']    = CriaVetTabela('codigo_TIPO');
$vetCampo['plu_edct_descricao'] = CriaVetTabela('Tipo');
$vetCampo['tamanho']            = CriaVetTabela('Tamanho');
$vetCampo['qtd_decimal']        = CriaVetTabela('Decimal');

$sql   = 'select ';
$sql  .= '   plu_edc.idt,  ';
$sql  .= '   plu_edc.*,  ';
$sql  .= '   plu_edct.codigo as plu_edct_codigo,  ';
$sql  .= '   plu_edct.descricao as plu_edct_descricao,  ';
$sql  .= '   CONCAT_WS(" / ", plu_edct.codigo, plu_edct.descricao) as plu_edct_descricao,  ';

$sql  .= '   plu_cn.codigo as plu_cn_descricao  ';
//$sql  .= '   CONCAT_WS(" / ", plu_cn.codigo, plu_cn.descricao) as plu_cn_descricao  ';

$sql  .= ' from plu_ed_campos as plu_edc ';
$sql  .= ' inner join plu_ed_campos_tipo as plu_edct on plu_edct.idt = plu_edc.idt_tipo ';
$sql  .= ' inner join plu_ed_campo_natureza as plu_cn on plu_cn.idt = plu_edc.idt_natureza ';
$sql  .= ' order by plu_cn.codigo,plu_edc.codigo';
?>
