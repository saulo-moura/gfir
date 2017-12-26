<?php
$tabela = 'sca_organizacao_secao';
$id = 'idt';

$vetCampo['idt_organizacao'] = objFixoBanco('idt_organizacao', 'Organizacao', 'sca_estrutura_organizacional', 'idt', 'descricao', 0);


$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 90, 120);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 90, 120);
$vetCampo['localidade'] = objTexto('localidade', 'Localidade', True, 90, 120);
$vetCampo['sigla'] = objTexto('sigla', 'Sigla', True, 15, 45);

$sql = 'select idt, descricao from estado order by descricao';
$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', False, $sql,'','width:400px;');


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_organizacao']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['sigla']),
    Array($vetCampo['idt_estado']),
    Array($vetCampo['localidade']),
));
$vetCad[] = $vetFrm;
?>