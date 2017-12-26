<?php
$tabela = 'plu_ed_campos_tipo';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 60, 120);
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$vetCampo['tamanho'] = objInteiro('tamanho', 'Tamanho', True, 10);
$vetCampo['qtd_decimal'] = objInteiro('qtd_decimal', 'Decimal', false, 10);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['tamanho'],'',$vetCampo['qtd_decimal'],'',$vetCampo['descricao']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>