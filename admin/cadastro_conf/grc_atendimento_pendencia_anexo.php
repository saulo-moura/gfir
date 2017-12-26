<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai = "grc_atendimento_pendencia";
$AliasPai = "grc_at";
$EntidadePai = "Atendimento Pendência";
$idPai = "idt";
//
$TabelaPrinc  = "grc_atendimento_pendencia_anexo";
$AliasPric    = "gec_aai";
$Entidade     = "Anexo ";
$Entidade_p   = "Anexos";
$CampoPricPai = "idt_atendimento_pendencia";

$tabela = $TabelaPrinc;
$id = 'idt';

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$vetCampo['arquivo'] = objFile('arquivo', 'Anexo', true, 120, 'todos');

// $vetCampo['data'] = objData('data', 'Data do Envio', false, '', '', 'S');
// $vetCampo['email'] = objEmail('email', 'E-mail Destinatário', false, 40, 60);

$maxlength = 255;
$style = "width:700px; height:60px;";
$js = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Descrição', true, $maxlength, $style, $js);

$vetCampo['tipo'] = objHidden('tipo', $_GET['tipo']);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['descricao']),
    Array($vetCampo['arquivo']),
    Array($vetCampo['tipo']),
    Array($vetCampo['data']),
    Array($vetCampo['email']),
        ));
$vetCad[] = $vetFrm;