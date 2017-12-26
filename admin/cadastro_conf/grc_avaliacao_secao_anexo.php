<?php
$botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
$botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';

$idt_avaliacao = $_SESSION[CS]['objListarConf_vetID'][$_GET['session_cod']]['grc_avaliacao'];
$idt_secao = $_SESSION[CS]['objListarConf_vetID'][$_GET['session_cod']]['grc_formulario_secao'];

$id = 'idt';
$tabela = 'grc_avaliacao_secao_anexo';

$vetCampo['idt_avaliacao'] = objHidden('idt_avaliacao', $idt_avaliacao);
$vetCampo['idt_secao'] = objHidden('idt_secao',$idt_secao);

$vetCampo['descricao'] = objTexto('descricao', 'Título', true, 30, 120);
$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo Anexado (tamanho maximo de '.formata_tamanho($vetConf['max_upload_size']).')', true, 120, 'todos');

$maxlength = 2000;
$style = "width:700px;";
$js = "";

$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

if ($_GET['id'] == 0) {
    $_GET['id_usuario1'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 1, true, '', true);
$vetCampo['data_responsavel'] = objTextoFixo('data_responsavel', 'Data Registro', 20, true, true, getdata(true, true, true));

MesclarCol($vetCampo['observacao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_avaliacao'], '', $vetCampo['idt_secao']),
    Array($vetCampo['descricao'], '', $vetCampo['arquivo']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_responsavel']),
    Array($vetCampo['observacao']),
        ));

$vetCad[] = $vetFrm;
