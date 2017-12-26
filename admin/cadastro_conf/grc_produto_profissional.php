<style>
#nm_funcao_desc label{
}
#nm_funcao_obj {
}
.Tit_Campo {
}
.Tit_Campo_Obr {
}
fieldset.class_frame {
    background:#ECF0F1;
    border:1px solid #14ADCC;
}
div.class_titulo {
    background: #ABBBBF;
    border    : 1px solid #14ADCC;
    color     : #FFFFFF;
    text-align: left;
}
div.class_titulo span {
    padding-left:10px;
}
</style>



<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', parent.funcaoFechaCTC_grc_produto_profissional);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.funcaoFechaCTC_grc_produto_profissional);</script>';
}
//p($_GET);


$TabelaPai   = "grc_produto";
$AliasPai    = "grc_atd";
$EntidadePai = "Produto";
$idPai       = "idt";
//
$TabelaPrinc      = "grc_produto_profissional";
$AliasPric        = "grc_atdp";
$Entidade         = "Profissional do Produto";
$Entidade_p       = "Profissionais do Produto";
$CampoPricPai     = "idt_produto";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);
$sql  = "select idt, codigo, descricao from ".db_pir_gec."gec_profissional ";
$sql .= " order by codigo";
$vetCampo['idt_profissional'] = objCmbBanco('idt_profissional', 'Profissional', true, $sql,' ','width:180px;');
//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);
//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Profissional</span>', Array(
    Array($vetCampo['idt_profissional']),
	Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);












$vetCad[] = $vetFrm;
?>