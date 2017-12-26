<?php
$tabela = db_pir.'plu_pl_glossario';
$id = 'idt';
$vetCampo['termo']     = objTexto('termo', 'Tъrmo', True, 80, 255);


$sql  = "select idt, codigo, descricao from ".db_pir."plu_pl_glossario_natureza ";
$sql .= " order by codigo";

$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', true, $sql);




$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['resumo'] = objTextArea('resumo', 'Resumo', true, $maxlength, $style, $js);

$vetCampo['texto'] = objHTML('texto', 'Descriчуo', false);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['termo']),
    Array($vetCampo['idt_natureza']),
    Array($vetCampo['resumo']),
));


$vetFrm[] = Frame('', Array(
    Array($vetCampo['texto']),
));






$vetCad[] = $vetFrm;
?>