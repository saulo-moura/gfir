<?php

if ($_GET['idCad'] != '') {
   $_GET['idt0'] = $_GET['idCad'];
   $_GET['idt1'] = $_GET['idCad'];
   $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
   $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

//
$TabelaPai    = "gec_entidade_documento";
$AliasPai     = "gec_ed";
$EntidadePai  = "Documento do Entidade";
$idPai        = "idt";
//
//
$TabelaPrinc      = "gec_entidade_documento_arquivo";
$AliasPric        = "gec_eda";
$Entidade         = "Arquivo do Documento da Entidade";
$Entidade_p       = "Arquivos do Documento da Entidade";

$CampoPricPai     = "idt_entidade_documento";



//p($_GET);

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai]     = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'idt', 1);

$vetCampo['data_cadastro']   = objDatahora('data_cadastro', 'Data Cadastro', true);

$vetCampo['data_emissao']    = objData('data_emissao', 'Data Inicio', false);
$vetCampo['data_vencimento'] = objData('data_vencimento', 'Data Termino', false);

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);


$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Usuário', true, $sql,'','width:180px;');


$vetCampo['arquivo'] = objFile('arquivo', 'Arquivio com Edital', false, 40, 'todos', '', '', 0, '', 'Arquivo com Documento', 'class_file');



//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Processo</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

MesclarCol($vetCampo['arquivo'], 3);

$vetFrm[] = Frame('<span>Responsável</span>', Array(
    Array($vetCampo['idt_usuario'],'',$vetCampo['data_cadastro']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Documento</span>', Array(
    Array($vetCampo['data_emissao'],'',$vetCampo['data_vencimento']),
    
    Array($vetCampo['arquivo']),
    
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observações</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>