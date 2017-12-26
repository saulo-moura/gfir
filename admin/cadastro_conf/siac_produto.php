<?php
$tabela = 'db_pir_siac.produto';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['idt_siac']  = objInteiro('idt_siac', 'IDT SIAC', True, 10);
$vetCampo['idt_pir']   = objInteiro('idt_pir', 'IDT PIR', True, 10);
$vetCampo['data_ultima_movimentacao'] = objDataHora('data_ultima_movimentacao', 'Data última Movimentação', True);

$sql = "select idt, codigo, descricao from db_pir_siac.produto_instrumento order by descricao";
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql,'','width:380px;');

$sql = "select idt, codigo, descricao from db_pir_siac.produto_foco_tematico order by descricao";
$vetCampo['idt_foco_tematico'] = objCmbBanco('idt_foco_tematico', 'Foco Temático', true, $sql,'','width:380px;');

$sql = "select idt, codigo, descricao from db_pir_siac.produto_autor order by descricao";
$vetCampo['idt_autor'] = objCmbBanco('idt_autor', 'Autor', true, $sql,'','width:380px;');

$sql = "select idt, codigo, descricao from db_pir_siac.produto_responsavel order by descricao";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Autor', true, $sql,'','width:380px;');





$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_siac'],'',$vetCampo['idt_pir'],'',$vetCampo['data_ultima_movimentacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span></span>', Array(
    Array($vetCampo['idt_instrumento'],'',$vetCampo['idt_foco_tematico']),
    Array($vetCampo['idt_autor'],'',$vetCampo['idt_responsavel']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>