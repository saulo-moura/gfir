<?php
$tabela = 'plu_mime_arquivo';
$id = 'idt_miar';

$vetCampo['des_extensao'] = objTexto('des_extensao', 'Extensão do Arquivo', True, 10);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['des_extensao']),
));
$vetCad[] = $vetFrm;
?>