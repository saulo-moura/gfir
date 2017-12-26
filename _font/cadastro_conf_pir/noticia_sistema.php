<?php
$tabela = 'noticia_sistema';
$id = 'idt';
$vetCampo['ordem'] = objAutoNum('ordem', 'Ordem', 10, True);
$vetCampo['data'] = objData('data', 'Data Publicaзгo', True);
$vetCampo['hora'] = objTexto('hora', 'Hora Publicaзгo', true, 8, 8);
$vetCampo['ativa'] = objCmbVetor('ativa', 'Ativada?', True, $vetSimNao);
$vetCampo['principal'] = objCmbVetor('principal', 'Principal?', True, $vetSimNao);
$vetCampo['descricao'] = objTexto('descricao', 'Descriзгo', True, 45,120);
$vetCampo['contato'] = objTexto('contato', 'Contato', True, 45,45);
$vetCampo['detalhe'] = objHTML('detalhe', 'Notнcia Detalhada', false);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ordem'], '' , $vetCampo['data'], '' , $vetCampo['hora'], '' , $vetCampo['ativa'], '' , $vetCampo['principal']),
 ));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['contato']),
    Array($vetCampo['detalhe']),
 ));
$vetCad[] = $vetFrm;
?>