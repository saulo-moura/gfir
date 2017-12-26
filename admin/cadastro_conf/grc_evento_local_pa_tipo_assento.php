<?php
$tabela = 'grc_evento_local_pa_tipo_assento';
$id = 'idt';

$vetCampo['codigo'] = objAutoNum('codigo', 'Código', 15, true, 2);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['pode_ocupar'] = objCmbVetor('pode_ocupar', 'Pode Ocupar?', True, $vetSimNao);

$vetFrm = Array();

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'], '', $vetCampo['descricao'], '', $vetCampo['ativo'], '', $vetCampo['pode_ocupar']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCampo['imagem'] = objFile('imagem', 'Imagem Ativado (32px x 32px)', true, 40, 'imagem', 32, 32);
$vetCampo['imagem_d'] = objFile('imagem_d', 'Imagem Desativado (32px x 32px)', true, 40, 'imagem', 32, 32);
$vetCampo['img_ocupado'] = objFile('img_ocupado', 'Imagem do Assento Ocupado (32px x 32px)', true, 40, 'imagem', 32, 32);

MesclarCol($vetCampo['img_ocupado'], 3);

$vetFrm[] = Frame('<span>Imagem</span>', Array(
    Array($vetCampo['imagem'], '', $vetCampo['imagem_d']),
    Array($vetCampo['img_ocupado']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$maxlength = 1000;
$style = "width:700px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
