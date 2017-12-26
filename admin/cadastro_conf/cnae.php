<?php
$tabela = 'cnae';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 45, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//

$vetCampo['secao']      = objTexto('secao', 'Se��o', false, 1, 4);
$vetCampo['divisao']    = objTexto('divisao', 'Divis�o', false, 2, 2);
$vetCampo['grupo']      = objTexto('grupo', 'Grupo', false, 4, 4);
$vetCampo['classe']     = objTexto('classe', 'Classe', false, 7, 7);
$vetCampo['subclasse']  = objTexto('subclasse', 'Subclasse', false, 15, 45);





$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$vetFrm = Array();
$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Classifica��o</span>', Array(
    Array($vetCampo['secao']),
    Array($vetCampo['divisao']),
    Array($vetCampo['grupo']),
    Array($vetCampo['classe']),
    Array($vetCampo['subclasse']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>