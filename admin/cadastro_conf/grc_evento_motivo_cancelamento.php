<?php
$tabela = 'grc_evento_motivo_cancelamento';

$id = 'idt';
$vetCampo['codigo']    = objInteiro('codigo', 'Código', True, 9);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;