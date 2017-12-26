<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "plu_link_util_grupo";
$AliasPai    = "plu_lug";
$EntidadePai = "Grupo";
$idPai       = "idt";

//
$TabelaPrinc      = "plu_link_util_grupo_usuario";
$AliasPric        = "plu_lugu";
$Entidade         = "Usuário do Grupo";
$Entidade_p       = "Usuários do Grupo";
$CampoPricPai     = "idt_grupo";

$tabela = $TabelaPrinc;


$idt_grupo_usuario = $_GET['id'];
if ($acao!='inc')
{
     $sql  = "select  ";
     $sql .= " plu_lugu.*  ";
     $sql .= " from plu_link_util_grupo_usuario plu_lugu ";
     $sql .= " where idt = {$idt_grupo_usuario} ";
     $rs = execsql($sql);
     $wcodigo = '';
//   ForEach($rs->data as $row)
//   {
//       $idt_usuario = $row['idt_usuario'];
//   }
}
else
{

}

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Usuário', true, $sql,' ','width:700px;');

$maxlength  = 700;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$vetFrm[] = Frame('<span>Grupo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Usuário</span>', Array(
    Array($vetCampo['idt_usuario']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
