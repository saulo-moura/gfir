<?php
$tabela = 'grc_evento_prazo_insumo';
$id = 'idt';

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_atendimento_instrumento';
$sql .= ' where idt in (40, 47, 46, 49, 50, 2, 41, 45, 48)';
$sql .= ' order by descricao';
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql);

$sql = "select idt,  descricao from ".db_pir_gec."gec_programa ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$vetCampo['idt_programa'] = objCmbBanco('idt_programa', 'Programa Credenciado', true, $sql);

$vetCampo['prazo_insumo'] = objInteiro('prazo_insumo', 'Prazo do Insumo (em dias)', True, 9);
$vetCampo['prazo_credenciado'] = objInteiro('prazo_credenciado', 'Prazo do Credenciado (em dias)', True, 9);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_instrumento']),
    Array($vetCampo['idt_programa']),
    Array($vetCampo['prazo_insumo']),
    Array($vetCampo['prazo_credenciado']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
