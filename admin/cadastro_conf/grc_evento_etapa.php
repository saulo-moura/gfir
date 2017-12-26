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
$AliasPai    = "grc_ppr";
$EntidadePai = "PROGRAMAÇÃO DE EVENTO";
$idPai       = "idt";

//
$TabelaPrinc      = "grc_evento_etapa";
$AliasPric        = "grc_ppp";
$Entidade         = "Etapa de Programação de Evento";
$Entidade_p       = "Etapa de Programação de Evento";
$CampoPricPai     = "idt_evento";

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['nome_etapa'] = objTexto('nome_etapa', 'Nome da Etapa', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao);

$sql  = "select id_usuario, nome_completo from plu_usuario ";
$sql .= " order by nome_completo";
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Responsavel', true, $sql,' ','width:300px;');

$sql  = "select idt,codigo,descricao from grc_evento_relacao_colaborador ";
$sql .= " order by codigo";
$vetCampo['idt_evento_relacao_colaborador'] = objCmbBanco('idt_evento_relacao_colaborador', 'Função na Etapa', true, $sql,' ','width:300px;');

$vetCampo['data_inicial']   = objDatahora('data_inicial', 'Inicio de Etapa (dd/mm/aaaa hh:mm)', False);
$vetCampo['data_final']   = objDatahora('data_final', 'Fim do Etapa (dd/mm/aaaa hh:mm)', False);
//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js );

//
$vetFrm = Array();
$vetFrm[] = Frame('<span>Etapa de Programação de Produto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['codigo'],'',$vetCampo['nome_etapa'],'',$vetCampo['ativo']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Colaborador Associado</span>', Array(
    Array($vetCampo['idt_usuario']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Função no Evento</span>', Array(
    Array($vetCampo['idt_evento_relacao_colaborador']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Etapas</span>', Array(
    Array($vetCampo['data_inicial'],'',$vetCampo['data_final']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetFrm[] = Frame('<span>Observação</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);



$vetCad[] = $vetFrm;
?>