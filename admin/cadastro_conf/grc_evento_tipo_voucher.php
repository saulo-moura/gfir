<?php
$tabela = 'grc_evento_tipo_voucher';
$id = 'idt';

$vetCampo['codigo'] = objTextoFixo('codigo', 'C�digo', 15, True);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

$maxlength = 1000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm = Array();

$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
