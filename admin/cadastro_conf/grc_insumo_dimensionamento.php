<?php
$tabela = 'grc_insumo_dimensionamento';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 25, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 100, 255);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['vl_unitario'] = objDecimal('vl_unitario', 'Custo Unitario (R$)', True, 9);

$sql = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', True, $sql, ' ', 'width:180px;');

$maxlength = 700;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetFrm[] = Frame('<span>Custo</span>', Array(
    Array($vetCampo['idt_insumo_unidade'], '', $vetCampo['vl_unitario']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;