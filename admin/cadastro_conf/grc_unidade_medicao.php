<?php
$tabela = 'grc_unidade_medicao';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Observa��o</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
