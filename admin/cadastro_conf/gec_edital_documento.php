<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";



//
$TabelaPrinc      = "gec_edital_documento";
$AliasPric        = "gec_ed";
$Entidade         = "Documento do Edital";
$Entidade_p       = "Documentos do Edital";
$CampoPricPai     = "idt_edital";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


//$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data Inicio', False);
//$vetCampo['data_termino']   = objDatahora('data_termino', 'Data Termino', False);


$sql  = "select idt, codigo, descricao from gec_documento ";
$sql .= " order by codigo";
$vetCampo['idt_documento'] = objCmbBanco('idt_documento', 'Documento', true, $sql,'','width:180px;');


$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Edital</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);

$vetFrm[] = Frame('<span>Datas</span>', Array(
    Array($vetCampo['idt_documento']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>