<?php
$tabela = 'sca_cargo';
$id = 'idt';

$vetCampo['idt_organizacao'] = objFixoBanco('idt_organizacao', 'Organizacao', 'sca_estrutura_organizacional', 'idt', 'descricao', 0);


$vetCampo['codigo'] = objTexto('codigo', 'Cуdigo', True, 90, 120);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 90, 120);

$sql  = 'select idt, descricao from sca_cargo_grupo ';
$sql .= ' where idt_organizacao = '.null($_GET['idt0']);
$sql .= ' order by codigo';
$vetCampo['idt_agrupa_cargo'] = objCmbBanco('idt_agrupa_cargo', 'Grupo', False, $sql,'','width:400px;');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_organizacao']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo']),
    Array($vetCampo['descricao']),
    Array($vetCampo['idt_agrupa_cargo']),
));
$vetCad[] = $vetFrm;
?>