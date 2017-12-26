<?php
$tabela = 'plu_parametros_lista';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['numero'] = objInteiro('numero', 'Número', True, 10);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');


$maxlength  = 1000;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Objetivo', false, $maxlength, $style, $js);


$sql = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$vetCampo['idt_proprietario'] = objCmbBanco('idt_proprietario', 'Proprietário', true, $sql,' ','width:380px;');
$vetFrm = Array();
MesclarCol($vetCampo['idt_proprietario'], 5);
MesclarCol($vetCampo['detalhe'], 5);
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['numero'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['idt_proprietario']),
	Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetCad[] = $vetFrm;
?>