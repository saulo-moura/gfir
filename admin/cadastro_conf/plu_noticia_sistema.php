<?php
$tabela = 'plu_noticia_sistema';
$id = 'idt';
$vetCampo['ordem'] = objAutoNum('ordem', 'Ordem', 10, True);
$vetCampo['data'] = objData('data', 'Data Publicação', True);
$vetCampo['hora'] = objTexto('hora', 'Hora Publicação', true, 8, 8);
$vetCampo['ativa'] = objCmbVetor('ativa', 'Ativada?', True, $vetSimNao);
$vetCampo['principal'] = objCmbVetor('principal', 'Principal?', True, $vetSimNao);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45, 120);
$vetCampo['contato'] = objTexto('contato', 'Contato', True, 45, 45);
$vetCampo['detalhe'] = objHTML('detalhe', 'Notícia Detalhada', false);

$vetCampo['dt_mostra_ini'] = objDataHora('dt_mostra_ini', 'Mostrar de', True);
$vetCampo['dt_mostra_fim'] = objDataHora('dt_mostra_fim', 'Mostrar até', True);

$vetLocal = Array();
$vetLocal['T'] = 'Site e GC';
$vetLocal['S'] = 'Site';
$vetLocal['G'] = 'Gerador de Conteúdo - GC';
$vetCampo['local_apresentacao'] = objCmbVetor('local_apresentacao', 'Local?', True, $vetLocal);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['ordem'], '', $vetCampo['data'], '', $vetCampo['hora'], '', $vetCampo['local_apresentacao']),
    Array($vetCampo['principal'], '', $vetCampo['ativa'], '', $vetCampo['dt_mostra_ini'], '', $vetCampo['dt_mostra_fim']),
        ));
$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['contato']),
    Array($vetCampo['detalhe']),
        ));
$vetCad[] = $vetFrm;
?>