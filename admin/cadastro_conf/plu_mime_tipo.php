<?php
$tabela = 'plu_mime_tipo';
$id = 'idt_miti';

$vetCampo['idt_miar'] = objFixoBanco('idt_miar', 'Arquivo', 'plu_mime_arquivo', 'idt_miar', 'des_extensao', 0);
$vetCampo['des_tipo'] = objTexto('des_tipo', 'Mime do Arquivo', True, 80, 100);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_miar']),
    Array($vetCampo['des_tipo']),
));
$vetCad[] = $vetFrm;
?>