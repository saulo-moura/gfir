<?php
$tabela = 'plu_tipo_objeto';
$id = 'idt';


$vetCampo['classificacao'] = objTexto('classificacao', 'Classificaзгo', True, 20, 45);
$vetCampo['codigo']        = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['descricao']     = objTexto('descricao', 'Descriзгo', True, 60, 120);
$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);
$vetCampo['imagem']      = objFile('imagem', 'Sнmbolo 25 x 25 px', false, 80, 'imagem', 25, 25);
$sql = 'select idt , codigo, descricao from plu_natureza_tipo_objeto order by codigo';
$vetCampo['idt_natureza'] = objCmbBanco('idt_natureza', 'Natureza', true, $sql);



$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['classificacao'],'',$vetCampo['descricao'],'',$vetCampo['codigo']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_natureza']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['imagem']),
    Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>