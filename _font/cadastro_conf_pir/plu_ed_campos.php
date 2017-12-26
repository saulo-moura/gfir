<?php
$tabela = 'plu_ed_campos';
$id = 'idt';
$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 30, 120);
$vetCampo['tamanho'] = objInteiro('tamanho', 'Tamanho', True, 10);
$vetCampo['qtd_decimal'] = objInteiro('qtd_decimal', 'Decimal', false, 10);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$sql = 'select idt, codigo, descricao from plu_ed_campos_tipo order by codigo';

 $linhafixa = '';
 $style = '';
 $js = "";

$vetCampo['idt_tipo'] = objCmbBanco('idt_tipo', 'Tipo Campo', true, $sql, $linhafixa, $style, $js);

$vetCampo['mascara'] = objTexto('mascara', 'Mascara', false, 30, 120);

$sql = 'select idt , codigo, descricao from plu_ed_campo_natureza order by codigo';
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', true, $sql);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['idt_tipo'],'',$vetCampo['tamanho'],'',$vetCampo['qtd_decimal'],'',$vetCampo['descricao']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_natureza'],'',$vetCampo['mascara']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>