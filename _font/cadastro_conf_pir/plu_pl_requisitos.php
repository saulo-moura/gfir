<?php
$tabela = 'plu_pl_requisitos';
$id = 'idt';

$vetCampo['idt_projeto'] = objFixoBanco('idt_projeto', 'Projeto', 'plu_pl_projeto', 'idt', 'descricao', 0);

$vetCampo['codigo']        = objTexto('codigo', 'Código', True, 20, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Nome', True, 60, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
//$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$vetCampo['detalhe']       = objHTML('detalhe', 'Descrião', false);

$sql = 'select idt , codigo, descricao from plu_pl_responsavel order by codigo';
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', true, $sql);


$sql = 'select idt , codigo, descricao from plu_pl_requisitos_prioridade order by codigo';
$vetCampo['idt_prioridade'] = objCmbBanco('idt_prioridade', 'Prioridade', true, $sql);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_projeto']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['idt_prioridade']),
    Array($vetCampo['idt_responsavel']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));

$vetCad[] = $vetFrm;
?>