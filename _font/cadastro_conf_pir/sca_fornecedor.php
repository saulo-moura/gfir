<?php
$tabela = 'sca_fornecedor';
$id = 'idt';

$vetCampo['identificacao'] = objTexto('identificacao', 'Identificaчуo', false, 45, 45);
$vetCampo['razao_nome']    = objTexto('razao_nome', 'Descriчуo', True, 60, 120);
$vetCampo['cnpj'] = objCNPJ('cnpj', 'CNPJ', false, 45, 45);
$vetCampo['cpf'] = objCNPJ('cpf', 'CPF', false, 45, 45);

$vetCampo['contatos'] = objTexto('contatos', 'Contatos', false, 80, 255);
$vetCampo['telefones'] = objTexto('telefones', 'Telefones', false, 80, 255);


$sql = 'select idt , codigo, descricao from sca_status_fornecedor order by codigo';
$vetCampo['idt_status'] = objCmbBanco('idt_status', 'Status', true, $sql);



$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['cnpj'], ' ', $vetCampo['cpf'], ' ', $vetCampo['identificacao']),
));

$vetFrm[] = Frame('', Array(
    Array($vetCampo['razao_nome']),
    Array($vetCampo['contatos']),
    Array($vetCampo['telefones']),
));
$vetFrm[] = Frame(' Status ', Array(
    Array($vetCampo['idt_status']),
));
$vetCad[] = $vetFrm;
?>