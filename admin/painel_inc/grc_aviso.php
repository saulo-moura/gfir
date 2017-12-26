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
/*
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
*/


//
$TabelaPrinc      = "grc_aviso";
$AliasPric        = "grc_av";
$Entidade         = "Aviso";
$Entidade_p       = "Avisos";
$CampoPricPai     = "";

$tabela = $TabelaPrinc;


$idt_aviso = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_av.*  ";
     $sql .= " from grc_aviso grc_av ";
     $sql .= " where idt = {$idt_aviso} ";
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
//$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);
$vetCampo['origem']                    = objTexto('origem', 'Origem', false, 15, 45);
$vetCampo['referencia']                = objTexto('referencia', 'Referência', false, 15, 45);

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['protocolo']                 = objTexto('protocolo', 'Protocolo', false, 15, 45,$js);
$js    = "";
$datepicker='S';
$vetCampo['data_inicio']  = objData('data_inicio', 'Data Inicio', true,$js,'',$datepicker);
$vetCampo['data_termino'] = objData('data_termino', 'Data Término', false,$js,'',$datepicker);

$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_registro'] = objDatahora('data_registro', 'Data Registro', false,$js);
$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
if ($acao!='inc')
{
    $sql .= " where plu_usu.id_usuario = ".null($idt_usuario);
}
else
{

}
$js_hm   = " disabled  ";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Responsável pelo registro', false, $sql,'',$style,$js_hm);
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Texto do Aviso', false, $maxlength, $style, $js);

$vetPri=Array();
$vetPri['0']='Crítica';
$vetPri['1']='Urgente';
$vetPri['2']='Média';
$vetPri['3']='Baixa';
$vetCampo['prioridade'] = objCmbVetor('prioridade', 'Prioridade', True, $vetPri,' ');





$vetFrm = Array();
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['protocolo'],'',$vetCampo['idt_usuario'],'',$vetCampo['data_registro']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Publicação</span>', Array(
    Array($vetCampo['prioridade'],'',$vetCampo['data_inicio'],'',$vetCampo['data_termino']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Aviso</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetCad[] = $vetFrm;
?>
