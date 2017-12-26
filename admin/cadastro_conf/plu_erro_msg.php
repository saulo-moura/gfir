<?php
$tabela = 'plu_erro_msg';

$vetCampo['data'] = objTextoFixo('data', 'Data', '', True);
$vetCampo['origem_msg'] = objTextoFixo('origem_msg', 'Origem', '', True);
$vetCampo['num_erro'] = objTextoFixo('num_erro', 'NК do Erro', '', True);
$vetCampo['msg_erro'] = objTextoFixo('msg_erro', 'Mensagem do Sistema', '', True);
$vetCampo['msg_usuario'] = objTextArea('msg_usuario', 'Mensagem do Usuсrio', True, 8000);


$vetGravidade = Array();
$vetGravidade['Informa'] ='Informar'; 
$vetGravidade['Alerta']  ='Alertar'; 
$vetGravidade['Grave']   ='Grave'; 
$js = "";
$vetCampo['gravidade'] = objCmbVetor('gravidade', 'Natureza da Mensagem', false, $vetGravidade,'',$js);


//~ /$vetCampo['detalhe']       = objHtml('detalhe', 'Detalhe', false,'250px','','',True);
$vetCampo['justificativa'] = objHTML('justificativa', 'Justificativa', false, $altura, $largura, $js);
$altura = "350"; 
$largura= "950";
//$js = " style='width:100%;'";
$js = "";
$vetCampo['detalhe']       = objHtml('detalhe', 'Explicaчуo sobre a mensagem', false,$altura, $largura, $js);


$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['data']),
    Array($vetCampo['origem_msg']),
    Array($vetCampo['num_erro']),
    Array($vetCampo['msg_erro']),
    Array($vetCampo['msg_usuario']),
	Array($vetCampo['gravidade']),
	Array($vetCampo['detalhe']),
));
$vetCad[] = $vetFrm;
?>