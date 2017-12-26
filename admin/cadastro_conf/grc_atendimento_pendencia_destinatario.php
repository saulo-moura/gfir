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
$TabelaPrinc  = "grc_atendimento_pendencia_destinatario";
$AliasPric    = "gec_apd";
$Entidade     = "Destinatário da Pendência";
$Entidade_p   = "Destinatários da Pendência";
$CampoPricPai = "idt_pendencia";

$tabela = $TabelaPrinc;
$id = 'idt';

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);


$sql = "select id_usuario, nome_completo  descricao from plu_usuario ";
$sql .= " order by nome_completo";
$js_hm = "";
$style = " width:800px; ";
$vetCampo['idt_destinatario'] = objCmbBanco('idt_destinatario', 'Destinatários', true, $sql, ' ', $style, $js_hm);
$maxlength = 5000;
$style = "width:800px; height:60px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where tipo_estrutura = 'UR' ";
$js_hm = "";
$style = " background:{$corbloq}; width:800px;";
$js_hm = " disabled ";
$vetCampo['idt_unidade'] = objCmbBanco('idt_unidade', 'Unidade', false, $sql, ' ', $style, $js_hm);



$sql = 'select ';
$sql .= '   idt, descricao  ';
$sql .= ' from '.db_pir.'sca_organizacao_secao sac_os ';
$sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S' ) ";
//$sql .= "   and idt = ".null($idt_ponto_atendimento);
$sql .= ' order by classificacao ';
$js_hm = "";
$style = " background:{$corbloq}; width:800px;";
$js_hm = " disabled ";
$vetCampo['idt_ponto_atendimento'] = objCmbBanco('idt_ponto_atendimento', 'Ponto de Atendimento', false, $sql, ' ', $style, $js_hm);



$js = "";
$vetCampo['enviar_email_destinatario'] = objCmbVetor('enviar_email_destinatario', 'Enviar E-mail?', false, $vetSimNao, '', $js);



$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
	Array($vetCampo['idt_destinatario']),
	Array($vetCampo['enviar_email_destinatario']),
    Array($vetCampo['observacao']),
	Array($vetCampo['idt_unidade']),
	Array($vetCampo['idt_ponto_atendimento']),
        ));
$vetCad[] = $vetFrm;