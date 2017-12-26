<?php
$tabela = 'plu_objetos_funcao';
$id = 'idt';


$vetCampo['idt_funcao'] = objFixoBanco('idt_funcao', 'Programa', 'funcao', 'id_funcao', 'nm_funcao', 4);
$vetCampo['codigo']    = objTexto('codigo', 'Cуdigo', True, 15,45);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 70,120);


$sql  = "select idt, codigo, descricao from plu_tipo_objeto ";
$sql .= " order by codigo";

$vetCampo['idt_tipo_objeto'] = objCmbBanco('idt_tipo_objeto', 'Tipo do Objeto', false, $sql);


$vetFrm = Array();
MesclarCol($vetCampo['idt_funcao'], 3);
MesclarCol($vetCampo['descricao'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_funcao']),
    Array($vetCampo['codigo'],'',$vetCampo['idt_tipo_objeto']),
    Array($vetCampo['descricao'])
));
$vetCad[] = $vetFrm;
?>