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


$TabelaPai   = "grc_evento";
$AliasPai    = "grc_ppr";
$EntidadePai = "PRPGRAMA��O DE EVENTO";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_periodo";
$AliasPric        = "grc_ppp";
$Entidade         = "Per�odo de Programa��o de Evento";
$Entidade_p       = "Per�odo de Programa��o de Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['codigo']    = objTexto('codigo', 'C�digo', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descri��o', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
$vetCampo['data_inicial']   = objDatahora('data_inicial', 'Inicio de Per�odo (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_final']   = objDatahora('data_final', 'Fim do Per�odo (dd/mm/aaaa hh:mm)', False);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Detalhe', false, $maxlength, $style, $js);


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Per�odo de Programa��o de Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Per�odos</span>', Array(
    Array($vetCampo['data_inicial'],'',$vetCampo['data_final']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>