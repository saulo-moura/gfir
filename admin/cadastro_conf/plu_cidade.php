<?php
$tabela = 'plu_cidade';
$id = 'idt';


$vetCampo['idt_estado'] = objFixoBanco('idt_estado', 'Estado', 'plu_estado', 'idt', 'descricao', 1);

$vetCampo['sigla']     = objTexto('sigla', 'Sigla', True, 5, 5);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45, 45);


//$sql = "select idt, codigo, descricao from plu_estado order by descricao";
//$vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação do estado</span>', Array(
    Array($vetCampo['idt_estado']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação do Município</span>', Array(
    Array($vetCampo['sigla']),
    Array($vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetCad[] = $vetFrm;
?>