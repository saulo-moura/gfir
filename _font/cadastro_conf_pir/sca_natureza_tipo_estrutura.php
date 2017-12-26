<?php
$tabela = 'sca_natureza_tipo_estrutura';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 60, 120);

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetCampo['imagem']      = objFile('imagem', 'Sнmbolo 25 x 25 px', false, 80, 'imagem', 25, 25);






$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['imagem']),
    Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>