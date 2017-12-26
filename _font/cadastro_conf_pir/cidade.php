<?php
$tabela = 'cidade';
$id = 'idt';

$vetCampo['sigla'] = objTexto('sigla', 'Sigla', True, 5, 5);
$vetCampo['descricao'] = objTexto('descricao', 'Descriчуo', True, 45, 45);
$sql = "select idt, codigo, descricao from estado order by descricao";
$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['sigla']),
    Array($vetCampo['descricao']),
    Array($vetCampo['idt_estado']),


));
$vetCad[] = $vetFrm;
?>