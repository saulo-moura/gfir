<?php
$tabela = 'erro_msg';

$vetCampo['data'] = objTextoFixo('data', 'Data', '', True);
$vetCampo['origem_msg'] = objTextoFixo('origem_msg', 'Origem', '', True);
$vetCampo['num_erro'] = objTextoFixo('num_erro', 'Nº do Erro', '', True);
$vetCampo['msg_erro'] = objTextoFixo('msg_erro', 'Mensagem do Sistema', '', True);
$vetCampo['msg_usuario'] = objTextArea('msg_usuario', 'Mensagem do Usuário', True, 8000);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['data']),
    Array($vetCampo['origem_msg']),
    Array($vetCampo['num_erro']),
    Array($vetCampo['msg_erro']),
    Array($vetCampo['msg_usuario'])
));
$vetCad[] = $vetFrm;
?>