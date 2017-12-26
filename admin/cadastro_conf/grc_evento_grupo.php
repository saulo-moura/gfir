<?php
$tabela = 'grc_evento_grupo';
$id = 'idt';

$vetFrm = Array();

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
$vetCampo['arq_selo'] = objFile('arq_selo', 'Imagem do Selo', false, 40, 'imagem');

MesclarCol($vetCampo['arq_selo'], 5);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo']),
    Array($vetCampo['arq_selo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$maxlength = 1000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;