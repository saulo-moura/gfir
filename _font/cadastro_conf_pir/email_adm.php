<?php
$tabela = '';
$acao = 'enviar';
$botao_volta = 'parent.hidePopWin(false)';
$botao_acao = '<script>parent.hidePopWin(false);</script>';

if ($_SESSION[CS]['g_email'] == '') {
    $vetCampo['email'] = objTexto('email', 'e-Mail de Contato', True, 79);
} else {
    $vetCampo['email'] = objHidden('email', $_SESSION[CS]['g_email']);
}

$vetCampo['assunto'] = objTexto('assunto', 'Assunto', True, 79);
$vetCampo['mensagem'] = objTextArea('mensagem', 'Mensagem', True, 65000, 'height: 120px;');

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['email']),
    Array($vetCampo['assunto']),
    Array($vetCampo['mensagem'])
));
$vetCad[] = $vetFrm;
?>