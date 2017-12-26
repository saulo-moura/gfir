<?php

//p($_GET);

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai   = "gec_edital";
$AliasPai    = "gec_ed";
$EntidadePai = "Edital";
$idPai       = "idt";



//
$TabelaPrinc      = "gec_edital_comissao";
$AliasPric        = "gec_edc";
$Entidade         = "Comissão do Edital";
$Entidade_p       = "Comissões do Edital";
$CampoPricPai     = "idt_edital";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
//
$vetCampo['email_1']     = objTexto('email_1', 'EMAIL 1', false, 60, 120);
$vetCampo['email_2']     = objTexto('email_2', 'EMAIL 2', false, 60, 120);
//
$vetCampo['telefone_1']  = objTexto('telefone_1', 'Telefone 1', false, 60, 120);
$vetCampo['telefone_2']  = objTexto('telefone_2', 'Telefone 2', false, 60, 120);
//
$sql  = "select idt, codigo, descricao from gec_edital_relacao ";
$sql .= " order by codigo";
$vetCampo['idt_relacao'] = objCmbBanco('idt_relacao', 'Relação', true, $sql,'','width:180px;');


$sql  = "select idt, descricao from gec_entidade ";
$sql .= " where tipo_entidade= 'P'";
$sql .= " order by descricao";
$vetCampo['idt_pessoa'] = objCmbBanco('idt_pessoa', 'Pessoa', true, $sql,'','width:380px;');



//
//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Edital</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['idt_situacao'], 3);

$vetFrm[] = Frame('<span>Pessoa</span>', Array(
    Array($vetCampo['idt_pessoa'],'',$vetCampo['idt_relacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Comunicação</span>', Array(
    Array($vetCampo['telefone_1'],'',$vetCampo['telefone_2']),
    Array($vetCampo['email_1'],'',$vetCampo['email_2']),
),$class_frame,$class_titulo,$titulo_na_linha);


$vetCad[] = $vetFrm;
?>