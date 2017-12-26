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

//
$TabelaPrinc      = "grc_insumo_foco_instrumento";
$AliasPric        = "grc_ifi";
$Entidade         = "Relação Insumo x Foco X Instrumento";
$Entidade_p       = "Relação Insumo x Foco X Instrumento";
$CampoPricPai     = "";

$tabela = $TabelaPrinc;

// INSTRUMENTO
$sql = "select idt, descricao from grc_atendimento_instrumento ";
$sql .= " where nivel = 1";
$sql .= " order by descricao";
$vetCampo['idt_instrumento'] = objCmbBanco('idt_instrumento', 'Instrumento', true, $sql, ' ', 'width:300px;');

// foco
$sql = "select idt,  descricao from grc_foco_tematico ";
$sql .= " where ativo = 'S'";
$sql .= " order by descricao";
$vetCampo['idt_foco'] = objCmbBanco('idt_foco', 'Foco Temático', false, $sql, ' ', 'width:300px;');

$js="";
$vetCampo['insumorm'] = objTexto('insumorm', 'Código RM', True, 10, 45, $js);

//
$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['obaervacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

$js = "  '   ";
$vetStatus=Array();
$vetStatus['D']='Desenvolvimento';
$vetStatus['P']='Disponibilizado';

$vetCampo['status'] = objCmbVetor('status', 'Status', True, $vetStatus, '', $js);

//
$vetFrm = Array();
//MesclarCol($vetCampo['idt_situacao'], 3);
$vetFrm[] = Frame('<span>Produto Associado</span>', Array(
    Array($vetCampo['idt_instrumento'],'',$vetCampo['idt_foco'],'',$vetCampo['insumorm'],'', $vetCampo['status']),
),$class_frame,$class_titulo,$titulo_na_linha);
$vetFrm[] = Frame('<span>Resumo</span>', Array(
    Array($vetCampo['observacao']),
),$class_frame,$class_titulo,$titulo_na_linha);











$vetCad[] = $vetFrm;
?>