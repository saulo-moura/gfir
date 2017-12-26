<?php
$tabela = 'plu_setor';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 45, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 60, 120);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),

));
$vetCad[] = $vetFrm;
?>