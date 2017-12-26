<?php
$tabela = 'plu_link_util';
$id = 'idt';
$vetCampo['codigo']    = objAutonum('codigo', 'Protocolo', 10,true);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');

$vetCampo['analitico']     = objCmbVetor('analitico', 'Analítico?', True, $vetSimNao,'');

//
$vetCampo['classificacao'] = objTexto('classificacao', 'Classificação', True, 15, 45);
$vetCampo['link'] = objTexto('link', 'LINK', false, 90, 255);

$maxlength  = 4000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');
$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['classificacao'],'',$vetCampo['descricao'],'',$vetCampo['analitico'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>LINK</span>', Array(
    Array($vetCampo['link']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>