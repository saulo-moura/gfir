<?php
$tabela = 'grc_tipo_galeria';
$id = 'idt';

$vetCampo['descricao'] = objTexto('descricao', 'Descriчуo', True, 120);
$vetCampo['tem_link'] = objCmbVetor('tem_link', 'Tem Link?', True, $vetSimNao);
$vetCampo['tem_arquivo'] = objCmbVetor('tem_arquivo', 'Tem Arquivo?', True, $vetSimNao);

$vetFrm = Array();

MesclarCol($vetCampo['descricao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['tem_link'], '', $vetCampo['tem_arquivo']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;