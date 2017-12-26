<?php
$tabela = 'sca_cargo_grupo';
$id = 'idt';

$vetCampo['idt_organizacao'] = objFixoBanco('idt_organizacao', 'Organizacao', 'sca_estrutura_organizacional', 'idt', 'descricao', 0);


$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 90, 120);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 90, 120);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_organizacao']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
));
$vetCad[] = $vetFrm;
?>