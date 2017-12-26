<?php
$tabela = 'grc_insumo';
$id = 'idt';
$vetCampo['codigo']           = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao']        = objTexto('descricao', 'Descrição', True, 35, 120);
$vetCampo['ativo']            = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$vetCampo['classificacao']    = objTexto('classificacao', 'Classificação', True, 15, 15);
$vetCampo['custo_unitario_real'] = objDecimal('custo_unitario_real','Custo Unitario (R$)',true,15);
$vetCampo['por_participante'] = objCmbVetor('por_participante', 'Por Participante?', True, $vetSimNao);

$sql  = "select idt, codigo, descricao from grc_insumo_unidade ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_unidade'] = objCmbBanco('idt_insumo_unidade', 'Unidade', true, $sql,' ','width:180px;');

$sql  = "select idt, codigo, descricao from grc_insumo_elemento_custo ";
$sql .= " order by codigo";
$vetCampo['idt_insumo_elemento_custo'] = objCmbBanco('idt_insumo_elemento_custo', 'Elemento de Custo', true, $sql,' ','width:180px;');



//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['classificacao'],'',$vetCampo['descricao'],'',$vetCampo['idt_insumo_unidade'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Custo</span>', Array(
    Array($vetCampo['idt_insumo_elemento_custo'],'',$vetCampo['custo_unitario_real'],'',$vetCampo['por_participante']),
),$class_frame,$class_titulo,$titulo_na_linha);




$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>