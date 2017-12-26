<?php
$tabela = 'duvida';
$id = 'idt';
$vetCampo['pergunta'] = objTextArea('pergunta', 'Pergunta', false, 800,'height: 60px;width: 650px;');
$vetCampo['resposta'] = objTextArea('resposta', 'Resposta', false, 800,'height: 180px;width: 650px;');
$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['pergunta']),
    Array($vetCampo['resposta']),
));
$vetCad[] = $vetFrm;
?>