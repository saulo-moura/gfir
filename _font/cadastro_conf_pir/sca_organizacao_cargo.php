<?php
$tabela = 'sca_organizacao_cargo';
$id = 'idt';
$vetCampo['idt_secao'] = objFixoBanco('idt_secao', 'Se��o', 'sca_organizacao_secao', 'idt', 'descricao', 1);



$vetCampo['codigo']   = objTexto('codigo', 'C�digo', false, 35, 120);
$vetCampo['descricao']   = objTexto('descricao', 'Descri��o', false, 35, 120);
$vetCampo['agrupamento']   = objTexto('agrupamento', 'Agrupamento', false, 35, 120);



$vetFrm = Array();
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['idt_secao'] ),
));
$vetFrm[] = Frame(' ', Array(
    Array($vetCampo['codigo'] ),
    Array($vetCampo['descricao'] ),
    Array($vetCampo['agrupamento'] ),
));

$vetCad[] = $vetFrm;


?>