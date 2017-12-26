<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "grc_atendimento_fila";
$AliasPai    = "grc_af";
$EntidadePai = "Fila";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_atendimento_fila_painel";
$AliasPric        = "grc_afp";
$Entidade         = "Painel da Fila";
$Entidade_p       = "Paineis da Fila";
$CampoPricPai     = "idt_fila";

$tabela = $TabelaPrinc;


$idt_fila_painel = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " grc_afp.*  ";
     $sql .= " from grc_atendimento_fila_painel grc_afp ";
     $sql .= " where idt = {$idt_fila_painel} ";
     $rs = execsql($sql);
     $wcodigo = '';
}
else
{

}

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql  = "select idt, descricao from grc_atendimento_painel ";
$sql .= " order by descricao";
$vetCampo['idt_painel'] = objCmbBanco('idt_painel', 'Painel', true, $sql,' ','width:700px;');

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$vetFrm[] = Frame('<span>Fila</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Painel</span>', Array(
    Array($vetCampo['idt_painel']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
