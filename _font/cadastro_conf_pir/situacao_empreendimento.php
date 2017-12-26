<?php
$tabela = 'situacao_empreendimento';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 45, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 60, 120);

$vetCampo['imagem'] = objFile('imagem', 'Imagem (32 x 32)', false, 32, 'imagem', 32, 32);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['imagem']),

));
$vetCad[] = $vetFrm;
?>