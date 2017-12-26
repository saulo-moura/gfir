<?php
$tabela = 'sca_organizacao_pessoal';
$id = 'idt';
$vetCampo['idt_secao'] = objFixoBanco('idt_secao', 'Seзгo', 'sca_organizacao_secao', 'idt', 'descricao', 1);



$vetCampo['codigo'] = objTexto('codigo', 'Matrнcula', false, 35, 120);
$vetCampo['nome']   = objTexto('nome', 'Nomeo', false, 35, 120);

$sql = 'select idt , agrupamento, codigo,  descricao from sca_organizacao_cargo order by codigo';
$vetCampo['idt_cargo'] = objCmbBanco('idt_cargo', 'Cargo', true, $sql);




$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_secao'] ),
));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['codigo'] ),
    Array($vetCampo['nome'] ),
    Array($vetCampo['idt_cargo'] ),
));

$vetCad[] = $vetFrm;


?>