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
$AliasPai    = "grc_eve";
$EntidadePai = "Evento";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_responsavel";
$AliasPric        = "grc_evepro";
$Entidade         = "Responsavel Associado a Evento";
$Entidade_p       = "Responsaveis Associado a Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['codigo']    = objTexto('codigo', 'Código', false, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', false, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);
//
$maxlength  = 4000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observações', false, $maxlength, $style, $js);


$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Responsavel', true, $sql,' ','width:300px;');

$sql  = "select idt,codigo,descricao from grc_evento_relacao_colaborador ";
$sql .= " order by codigo";
$vetCampo['idt_evento_relacao_colaborador'] = objCmbBanco('idt_evento_relacao_colaborador', 'Função no Evento', true, $sql,' ','width:300px;');


//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Evento</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Responsavel</span>', Array(
    Array($vetCampo['idt_usuario'],'',$vetCampo['idt_evento_relacao_colaborador'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);


/*
$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);
*/

$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['detalhe']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>