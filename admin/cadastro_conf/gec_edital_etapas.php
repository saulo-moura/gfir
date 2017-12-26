<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

//
$TabelaPai    = "gec_edital_processo";
$AliasPai     = "gec_edp";
$EntidadePai  = "Processo do Edital";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_edital_etapas";
$AliasPric        = "gec_edets";
$Entidade         = "Etapa  do Edital";
$Entidade_p       = "Etapas do Edital";
$CampoPricPai     = "idt_processo";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'titulo', 1);


$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data Inicio', true);
$vetCampo['data_termino']   = objDatahora('data_termino', 'Data Termino', true);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);

$sql  = "select idt, codigo, descricao from gec_edital_etapa ";
$sql .= " order by codigo";
$vetCampo['idt_etapa'] = objCmbBanco('idt_etapa', 'Etapa', true, $sql,'','width:180px;');


$sql  = "select idt, codigo, descricao from gec_edital_etapas_situacao ";
$sql .= " order by codigo";
$vetCampo['idt_situacao'] = objCmbBanco('idt_situacao', 'Situação', true, $sql,'','width:180px;');


$vetCampo['linkdeacesso']    = objURL('linkdeacesso', 'Link de Acesso', false, 80, 255);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Processo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['ativo'], 7);

$vetFrm[] = Frame('<span>Etapa</span>', Array(
    Array($vetCampo['idt_etapa'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino'],'',$vetCampo['idt_situacao']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Etapa</span>', Array(
    Array($vetCampo['linkdeacesso']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>