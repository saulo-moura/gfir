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
$AliasPai    = "grc_a";
$EntidadePai = "Protocolo";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_pendencia";
$AliasPric        = "grc_ap";
$Entidade         = "Pendência do Atendimento";
$Entidade_p       = "Pendências do Atendimento";
$CampoPricPai     = "idt_atendimento";

$tabela = $TabelaPrinc;


$idt_atendimento_pendencia = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_ap.*  ";
     $sql .= " from grc_atendimento_pendencia grc_ap ";
     $sql .= " where idt = {$idt_atendimento_pendencia} ";
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
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);

$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$js_hm="";
$style="";
$vetCampo['idt_responsavel_solucao'] = objCmbBanco('idt_responsavel_solucao', 'Responsável da Solução', false, $sql,' ',$style,$js_hm);


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


$js    = "";
$vetCampo['data_solucao'] = objData('data_solucao', 'Data da Solução', False,$js,'','S');


$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data'] = objDatahora('data', 'Data Ocorrência', False,$js);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['solucao'] = objTextArea('solucao', 'Solução', false, $maxlength, $style, $js);

$js         = "";
$vetCampo['enviar_email'] = objCmbVetor('enviar_email', 'Enviar email?', false, $vetSimNao,'',$js);

$maxlength  = 255;
$style      = "width:700px; height:60px; ";
$js         = "";
$vetCampo['assunto'] = objTextArea('assunto', 'Assunto', true, $maxlength, $style, $js);



$vetFrm = Array();
$vetFrm[] = Frame('<span>Assunto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['assunto']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Consultor</span>', Array(
    Array($vetCampo['data'],'',$vetCampo['idt_usuario']),
    Array($vetCampo['enviar_email'],'',$vetCampo['recorrencia']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);


MesclarCol($vetCampo['solucao'], 3);
$vetFrm[] = Frame('<span>Solução</span>', Array(
    Array($vetCampo['data_solucao'],'',$vetCampo['idt_responsavel_solucao']),
    Array($vetCampo['solucao']),
),$class_frame,$class_titulo,$titulo_na_linha);

//$vetFrm[] = Frame('<span>Observação</span>', Array(
//    Array($vetCampo['solucao']),
//),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>
