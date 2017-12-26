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


$TabelaPai   = "grc_atendimento_agenda";
$AliasPai    = "grc_aa";
$EntidadePai = "Agenda";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_agenda_ocorrencia";
$AliasPric        = "grc_aao";
$Entidade         = "Ocorrência da Agenda";
$Entidade_p       = "Ocorrências da Agenda";
$CampoPricPai     = "idt_atendimento_agenda";

$tabela = $TabelaPrinc;


$idt_atendimento_agenda_ocorrencia = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_aa.*  ";
     $sql .= " from grc_atendimento_agenda_ocorrencia grc_aa ";
     $sql .= " where idt = {$idt_atendimento_agenda_ocorrencia} ";
     $rs = execsql($sql);
     $wcodigo = '';
     ForEach($rs->data as $row)
     {
         $idt_usuario = $row['idt_usuario'];
     }
}
else
{

}


$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'assunto', 0);

$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
if ($acao!='inc')
{

    $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
}
else
{

}
    $js_hm   = " disabled  ";

$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Consultor/Atendente', false, $sql,'',$style,$js_hm);


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data'] = objDatahora('data', 'Data Ocorrência', False,$js);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);




$vetFrm = Array();
$vetFrm[] = Frame('<span>Assunto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Consultor</span>', Array(
    Array($vetCampo['data'],'',$vetCampo['idt_usuario']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>