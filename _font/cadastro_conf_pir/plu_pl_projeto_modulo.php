<?php
$tabela = 'plu_pl_projeto_modulo';
$id = 'idt';

$vetCampo['idt_projeto'] = objFixoBanco('idt_projeto', 'Projeto', 'plu_pl_projeto', 'idt', 'descricao', 0);

$vetCampo['codigo']        = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descriзгo', True, 60, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$sql = 'select idt , codigo, descricao from plu_pl_responsavel order by codigo';
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', true, $sql);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_projeto']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['idt_responsavel']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));

$vetCad[] = $vetFrm;
?>