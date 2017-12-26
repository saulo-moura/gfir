<?php
$tabela = 'grc_evento_acesso';
$id = 'idt';

$vetCampo['descricao'] = objTexto('descricao', 'Descriчуo', True, 120);
$vetCampo['descricao_md5'] = objHidden('descricao_md5', '');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['descricao_md5']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;