<?php
$tabela = 'site_assinatura';
$id = 'idt';

$vetCampo['idt_empreendimento'] = objFixoBanco('idt_empreendimento', 'Empreendimento', 'empreendimento', 'idt', 'descricao', 0);

$sql = 'select id_usuario, nome_completo from usuario order by nome_completo ';
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Assinante', true, $sql,'','width:180px;');

$vetCampo['assinado'] = objCmbVetor('assinado', 'Assinado?', true, $vetSimNao);

$vetCampo['mes'] = objCmbVetor('mes', 'Mês', true, $vetMes);
$vetCampo['ano'] = objCmbVetor('ano', 'Ano', true, $vetAno);

$vetCampo['chave'] = objTexto('chave', 'Chave', true, 45, 45);
$vetCampo['data'] = objData('data', 'Data', True);




$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_empreendimento']),
    Array($vetCampo['chave']),
    Array($vetCampo['data']),
    Array($vetCampo['idt_usuario']),
));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['assinado']),
    Array($vetCampo['mes'], ' ', $vetCampo['ano']),
));


$vetCad[] = $vetFrm;
?>