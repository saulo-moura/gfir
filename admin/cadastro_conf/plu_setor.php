<?php
$tabela = 'plu_setor';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'C�digo', True, 45, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),

));
$vetCad[] = $vetFrm;
?>