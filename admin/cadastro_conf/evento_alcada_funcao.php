<?php
$tabela = db_pir.'sca_organizacao_funcao';
$id = 'idt';

$vetCampo['descricao'] = objTextoFixo('descricao', 'Fun��o do RM', '', True);
$vetCampo['tipo_alcada_evento'] = objCmbVetor('tipo_alcada_evento', 'Fun��o da Al�ada', false, $vetTipoAlcadaEvento);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao']),
    Array($vetCampo['tipo_alcada_evento']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
