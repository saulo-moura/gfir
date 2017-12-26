<?php
$tabela = 'ajudalogin';
$id = 'idt';
$vetCampo['pergunta'] = objTextArea('pergunta', 'Pergunta', false, 800,'height: 60px;width: 650px;');
$vetCampo['resposta'] = objTextArea('resposta', 'Resposta', false, 1800,'height: 180px;width: 650px;');
$vetCampo['ordem'] = objInteiroZero('ordem', 'Ordem', True, 3,3);
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['pergunta']),
    Array($vetCampo['resposta']),
    Array($vetCampo['ordem']),
));
$vetCad[] = $vetFrm;
?>