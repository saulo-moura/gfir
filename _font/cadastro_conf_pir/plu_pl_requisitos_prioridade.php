<?php
$tabela = 'plu_pl_requisitos_prioridade';
$id = 'idt';
$vetCampo['codigo']        = objTexto('codigo', 'C�digo', True, 20, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descri��o', True, 60, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));

$vetCad[] = $vetFrm;
?>