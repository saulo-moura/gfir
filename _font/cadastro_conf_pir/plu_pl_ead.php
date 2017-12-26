<?php
$tabela = 'plu_pl_ead';
$id = 'idt';

$vetCampo['codigo']        = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['classificacao'] = objTexto('classificacao', 'Classificaзгo', True, 20, 120);
$vetCampo['descricao']     = objTexto('descricao', 'Descriзгo', True, 40, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetCampo['detalhe']       = objHTML('detalhe', 'Descriгo', false);

$sql = 'select idt , codigo, descricao from plu_pl_ead_natureza order by codigo';
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', true, $sql);

$sql = 'select idt , codigo, descricao from plu_pl_responsavel order by codigo';
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', true, $sql);

$sql = 'select idt , codigo, descricao from sca_sistema order by codigo';
$vetCampo['idt_sistema'] = objCmbBanco('idt_sistema', 'Sistema', false, $sql);

$vetFrm = Array();
MesclarCol($vetCampo['idt_responsavel'], 3);
MesclarCol($vetCampo['idt_sistema'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['classificacao'],'',$vetCampo['codigo'],'',$vetCampo['descricao']),
    Array($vetCampo['idt_natureza'],'',$vetCampo['idt_responsavel']),
    Array($vetCampo['idt_sistema']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));

$vetCad[] = $vetFrm;
?>