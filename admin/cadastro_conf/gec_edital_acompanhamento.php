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
$TabelaPrinc      = "gec_edital_acompanhamento";
$AliasPric        = "gec_eac";
$Entidade         = "Acompanhamento do Edital";
$Entidade_p       = "Acompanhamentos do Edital";
$CampoPricPai     = "idt_edital";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


//$vetCampo['data_inicio'] = objDatahora('data_inicio', 'Data Inicio', False);
//$vetCampo['data_termino']   = objDatahora('data_termino', 'Data Termino', False);

$vetCampo['data'] = objDatahora('data', 'Data Ocorrência', False);

$sql  = "select idt, codigo, descricao from gec_edital_peca ";
$sql .= " order by codigo";
$vetCampo['idt_peca'] = objCmbBanco('idt_peca', 'Peça', true, $sql,' ','width:180px;');

$vetCampo['demandante'] = objTexto('demandante', 'Demandante', True, 60, 120);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Responsável', true, $sql,' ','width:180px;');

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['ocorrencia'] = objTextArea('ocorrencia', 'Ocorrência', false, $maxlength, $style, $js);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Edital</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);

$vetFrm[] = Frame('<span>Datas</span>', Array(
    Array($vetCampo['idt_peca'],'',$vetCampo['data']),
    Array($vetCampo['idt_usuario'],'',$vetCampo['demandante']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Ocorrência</span>', Array(
    Array($vetCampo['ocorrencia']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>