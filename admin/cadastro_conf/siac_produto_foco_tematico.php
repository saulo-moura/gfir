<?php
$tabela = 'db_pir_siac.produto_foco_tematico';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['idt_siac']  = objInteiro('idt_siac', 'IDT SIAC', True, 10);
$vetCampo['idt_pir']   = objInteiro('idt_pir', 'IDT PIR', True, 10);
$vetCampo['data_ultima_movimentacao'] = objDataHora('data_ultima_movimentacao', 'Data última Movimentação', True);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_siac'],'',$vetCampo['idt_pir'],'',$vetCampo['data_ultima_movimentacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>