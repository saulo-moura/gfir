<?php
$tabela = 'gec_entidade_classe';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 50, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe da Classe', false, $maxlength, $style, $js);

$sql = "select codigo, descricao from gec_entidade_tipo order by codigo";
$vetCampo['tipo_entidade'] = objCmbBanco('tipo_entidade', 'Tipo de Entidade', true, $sql,'','width:180px;', $js);


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo'],'',$vetCampo['tipo_entidade']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>