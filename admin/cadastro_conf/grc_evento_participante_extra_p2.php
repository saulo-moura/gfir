<?php
$tabela = 'grc_evento_participante';
$id = 'idt';

$vetCampo['bt_acao_insc'] = objHidden('bt_acao_insc', '', '', '', false);
$vetCampo['contrato'] = objHidden('contrato', $_SESSION[CS]['tmp'][CSU]['vetParametrosMC']['situacao_contrato']);

$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo['contrato'], '', $vetCampo['bt_acao_insc']),
        ), 'none');

$vetCad[] = $vetFrm;