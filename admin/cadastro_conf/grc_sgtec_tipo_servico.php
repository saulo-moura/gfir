<?php
$tabela = 'grc_sgtec_tipo_servico';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$sql = "select idt, descricao from grc_sgtec_natureza order by codigo";
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', true, $sql,'','width:180px;');

$sql = "select idt, descricao from grc_sgtec_modalidade order by codigo";
$vetCampo['idt_modalidade'] = objCmbBanco('idt_modalidade', 'Modalidade', true, $sql,'','width:180px;');









$vetFrm = Array();
MesclarCol($vetCampo['idt_modalidade'], 3);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['idt_natureza'],'',$vetCampo['idt_modalidade']),
	
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>