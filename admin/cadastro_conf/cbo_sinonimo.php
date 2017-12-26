<?php
$tabela = 'cbo_sinonimo';
$id = 'idt';

$vetCampo['codigo'] = objTexto('codigo', 'Código', True, 20, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);

$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>