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


.frame > table {
   width:100%;
   padding:5px;
}
#bia_conteudo___Frame {
   width:100%;

}
fieldset.class_frame {
    background: #FFFFFF; 
    border: 0px solid #FFFFFF; 
}
.campo_disabled {
    background-color: #FFFFFF;
}
.TextoFixo {
   border: 0;
}
.Texto {
   border: 0;
}

input {
    border: 0px inset;
}
select {
    border:0;
}
.TextArea {
   border: 0;
   background:#F1F1F1;
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
$EntidadePai = "Protocolo do Atendimento";
$idPai       = "idt";

// Buscar registro
$sql2 = 'select ';
$sql2 .= '  grc_ar.* ';
$sql2 .= '  from grc_atendimento_resumo grc_ar ';
$sql2 .= '  where grc_ar.idt = '.null($_GET['id']);
$rs_aap = execsql($sql2);
$row_aap = $rs_aap->data[0];


$idt_acao  = $row_aap['idt_acao'];
$idt_atendimento_pendencia  = $row_aap['idt_pendencia'];
$link_util  = $row_aap['link_util'];

$htmlw  = "";
$htmlw .= "<a href='{$link_util}' target='_blank'>Clique aqui para abrir o LINK: $link_util</a>";
$vetCampo['link_util_chama'] = objInclude('link_util_chama', $htmlw);

//
$TabelaPrinc      = "grc_atendimento_resumo";
$AliasPric        = "grc_ar";
$Entidade         = "Resumo do Atendimento";
$Entidade_p       = "Resumos do Atendimento";
$CampoPricPai     = "idt_atendimento";
$tabela = $TabelaPrinc;
$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);
$vetCampo['numero']    = objTexto('numero', 'Número', True, 15, 45);
$maxlength  = 5000;
$style      = "width:850px;";
$js         = "";
$vetCampo['descricao'] = objTextArea('descricao', 'Resumo', false, $maxlength, $style, $js);
$sql = "select idt, descricao from grc_atendimento_resumo_acao order by descricao";
$vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Ação no Atendimento', false, $sql,'','width:350px;');
$vetCampo['complemento_acao'] = objTexto('complemento_acao', 'Título', false, 15, 45);
$vetCampo['datahora'] = objDataHora('datahora', 'Data Hora', false);


$vetCampo['bia_acao']     = objTexto('bia_acao', 'AÇÃO BIA', false, 15, 45);
$vetCampo['bia_conteudo'] = objHTML('bia_conteudo', 'Conteúdo da BIA', false,400,850);

$vetCampo['link_util']     = objTexto('link_util', 'LINK ÚTIL', false, 80, 255);

$agendamento="";
if ($idt_acao==5)
{   // Agendamento marcacao
 	$agendamento="Agendamento - Marcação";	
}
if ($idt_acao==6)
{   // Agendamento desmarcacao
 	$agendamento="Agendamento - Desmarcação";		
}
if ($idt_acao==7)
{   // Agendamento exclusão
    $agendamento="Agendamento - Exclusão";	
 		
}
$vetCampo['marcacao'] = objHTML('marcacao', "{$agendamento}", false);

$vetCampo['obj_html_pendencia_historico'] = objInclude('obj_html_pendencia_historico', 'cadastro_conf/obj_html_pendencia_historico.php');




$vetFrm = Array();
 MesclarCol($vetCampo['complemento_acao'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai],'',$vetCampo['numero'],'',$vetCampo['datahora']),
	Array($vetCampo['idt_acao'],'',$vetCampo['complemento_acao']),
),$class_frame,$class_titulo,$titulo_na_linha);
/*
$vetFrm[] = Frame('', Array(
   // Array($vetCampo['idt_acao']),
    Array($vetCampo['descricao']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/
if ($idt_acao==1)
{   // bia
    $vetFrm[] = Frame('', Array(
		Array($vetCampo['bia_acao']),
		Array($vetCampo['bia_conteudo']),
	),$class_frame,$class_titulo,$titulo_na_linha);

}

if ($idt_acao==2)
{   // link util
    $vetFrm[] = Frame('', Array(
		Array($vetCampo['link_util_chama']),
	),$class_frame,$class_titulo,$titulo_na_linha);
		
}
if ($idt_acao==4)
{   // pendencia

    $vetFrm[] = Frame('', Array(
		Array($vetCampo['obj_html_pendencia_historico']),
	),$class_frame,$class_titulo,$titulo_na_linha);

}
if ($idt_acao==5)
{   // Agendamento marcacao
    $vetFrm[] = Frame('', Array(
		Array($vetCampo['marcacao']),
	),$class_frame,$class_titulo,$titulo_na_linha);
		
}
if ($idt_acao==6)
{   // Agendamento desmarcacao
    $vetFrm[] = Frame('', Array(
		Array($vetCampo['marcacao']),
	),$class_frame,$class_titulo,$titulo_na_linha);
		
}
if ($idt_acao==7)
{   // Agendamento exclusão
    $vetFrm[] = Frame('', Array(
		Array($vetCampo['marcacao']),
	),$class_frame,$class_titulo,$titulo_na_linha);
		
}
/*
$vetFrm[] = Frame('', Array(
    Array($vetCampo['numero']),
    Array($vetCampo['datahora']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/
$vetCad[] = $vetFrm;