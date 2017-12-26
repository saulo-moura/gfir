<?php
$tabela = 'grc_agenda_parametro_sondagem';
$id = 'idt';
$vetCampo['codigo']    = objTexto('codigo', 'Código da Pergunta', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Pergunta', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objHtml('detalhe', 'Explicação da Pergunta', false);

$sql = "select idt, descricao from grc_agenda_parametro_sondagem_grupo order by descricao";
$vetCampo['idt_grupo'] = objCmbBanco('idt_grupo', 'Grupo', true, $sql,'','width:180px;');

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação da Pergunta de Sondagem</span>', Array(
    Array($vetCampo['idt_grupo'],'',$vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>

