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
    $_GET['idt1'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);

// Dados da tabela Pai (Nivel 1)

$TabelaPai   = "grc_avaliacao";
$AliasPai    = "grc_a";
$EntidadePai = "Avalia��o";
$idPai       = "idt";

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc      = "grc_avaliacao_devolutiva";
$AliasPric        = "grc_ad";
$Entidade         = "Devolutiva da Avalia��o"; 
$Entidade_p       = "Devolutivas da Avalia��o";
$CampoPricPai     = "idt_avaliacao";


$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 1);

// descreve os campos do cadastro

$corbloq = "#FFFFE1";
$jst =" readonly='true' style='background:".$corbloq."' ";
$vetCampo['codigo'] = objTexto('codigo', 'Protocolo', true, 12, 45,$jst);

$vetCampo['descricao'] = objTexto('descricao', 'Observa��o', false, 60, 120);
$vetStatusDev=Array();
$vetStatusDev['CA']='Cadastrada';
$vetStatusDev['AV']='Em Avalia��o';
$vetStatusDev['SB']='Substituida';
$vetStatusDev['AP']='Aprovada';
$vetCampo['status']     = objCmbVetor('status', 'Status', True, $vetStatusDev,'');


$sistema_origem = DecideSistema();
$vetGrupo=Array();
if ($sistema_origem=='GEC')
{
	$vetGrupo['GC'] ='Gest�o de Credenciados';
}
else
{
	$vetGrupo['NAN']='Neg�cio a Neg�cio';
}
$vetCampo['grupo']     = objCmbVetor('grupo', 'Grupo', True, $vetGrupo,'');



$js_t    = " disabled  style='background:#FFFFE1;'";
$vetCampo['atual']     = objCmbVetor('atual', 'Atual?', True, $vetSimNao,'', $js_t);

//

$js      = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_cadastrante']  = objDataHora('data_cadastrante', 'Data Registro', false, $js );
$sql     = "select id_usuario, nome_completo from plu_usuario order by nome_completo";
$js_hm   = " disabled  ";
$style   = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_cadastrante'] = objCmbBanco('idt_cadastrante', 'Responsavel', false, $sql,'',$style,$js_hm);

$vetCampo['data_versao']  = objDataHora('data_versao', 'Data Vers�o', false, $js );
$vetCampo['versao'] = objInteiro('versao', 'Vers�o', false, 10,'','',$js);




$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);

//
// 
//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['observacao'], 5);
//MesclarCol($vetCampo['data_versao'], 3);
MesclarCol($vetCampo['data_cadastrante'], 3);

$vetFrm[] = Frame('<span>Identifica��o</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['status'],'',$vetCampo['grupo']),
	Array($vetCampo['atual'],'',$vetCampo['versao'],'',$vetCampo['data_versao']),
	Array($vetCampo['idt_cadastrante'],'',$vetCampo['data_cadastrante']),
	Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>