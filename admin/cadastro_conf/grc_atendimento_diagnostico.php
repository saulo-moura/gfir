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
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "grc_atendimento";
$AliasPai    = "grc_eve";
$EntidadePai = "Atendimento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_diagnostico";
$AliasPric        = "grc_evepro";
$Entidade         = "Diagnostico Associado a Atendimento";
$Entidade_p       = "Diagnosticos Associado a Atendimento";
$CampoPricPai     = "idt_atendimento";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'assunto', 0);


$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


$sql  = "select idt, codigo, descricao from grc_diagnostico ";
$sql .= " order by codigo";
$vetCampo['idt_diagnostico'] = objCmbBanco('idt_diagnostico', 'Diagnostico Associado', true, $sql,' ','width:500px;');

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Diagnostico</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Diagnostico Associado</span>', Array(
    Array($vetCampo['idt_diagnostico']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>
