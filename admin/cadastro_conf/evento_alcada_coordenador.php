<?php
$tabela = 'grc_evento_alcada';
$id = 'idt';

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt in (40, 47, 46, 49, 50, 2, 41, 45, 48)';
$sql .= ' order by descricao';
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql);

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from '.db_pir.'sca_organizacao_funcao';
$sql .= ' order by descricao';
$vetCampo['idt_sca_organizacao_funcao'] = objCmbBanco('idt_sca_organizacao_funcao', 'Funчуo', true, $sql);

$vetCampo['vl_alcada'] = objDecimal('vl_alcada', 'Valor da Alчada', True, 18);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_instrumento']),
    Array($vetCampo['idt_sca_organizacao_funcao']),
    Array($vetCampo['vl_alcada']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
