<style>
    #nm_funcao_desc label{
    }
    
    #nm_funcao_obj {
    }
    
    .Tit_Campo {
    }
    
    .Tit_Campo_Obr {
    }
    
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
        height:30px;
    }
    
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        height:30px;
        padding-top:10px;
    }
    
    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
        background:#ABBBBF;
        border:1px solid #FFFFFF;
    }
    
    div.class_titulo_p {
        background: #ABBBBF;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame {
        background: #FFFFFF;
        border:1px solid #2C3E50;
    }
    
    div.class_titulo {
        background: #C4C9CD;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
    }
    
    div.class_titulo span {
        padding-left:10px;
    }

    .Texto {
        border:0;
        background:#ECF0F1;
    }
    
    Select {
        border:0;
        background:#ECF0F1;
    }

    TextArea {
        border:0;
        background:#ECF0F1;
    }
    
    .TextArea {
        border:0;
        background:#ECF0F1;
    }

    div#xEditingArea {
        border:0;
        background:#ECF0F1;
    }

    .TextoFixo {
        background:#ECF0F1;
    }


    fieldset.class_frame {
        border:0;
    }

    .campo_disabled {
        background-color: #ffffd7;
    }    

    #parterepasse_tit {
        padding-left:0px;
    }
</style>




<?php


if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}


$tabela = 'grc_politica_parametro_campos';
$id = 'idt';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;
$titulo_cadastro = "POLÍTICA DE VENDAS - PARÂMETRO CAMPOS";


$js=" readonly='true' style='background:#ffff70;' ";
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45,$js);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 45, 120,$js);
$vetCampo['tipo']      = objTexto('descricao', 'Descrição', True, 45, 120,$js);
$vetCampo['alias']     = objTexto('alias', 'Nome do Campo na visão do Usuário (Alias)', True, 45, 120);
$vetCampo['selecao']   = objCmbVetor('selecao', 'Seleção', True, $vetSimNao,'');

$js=" disabled style='background:#ffff70;' ";
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'',$js);
//
/*
$maxlength  = 4000;
$style      = "width:100%;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Descrição Detalhada da Política de Venda', false, $maxlength, $style, $js);
*/


// $sql = "select idt, codigo, descricao from plu_estado order by descricao";
// $vetCampo['idt_estado'] = objCmbBanco('idt_estado', 'Estado', true, $sql,'','width:180px;');

$vetFrm = Array();
//MesclarCol($vetCampo['selecao'], 5);
$vetFrm[] = Frame('', Array(
    Array($vetCampo['codigo'],'',$vetCampo['ativo']),
	Array($vetCampo['descricao'],'',$vetCampo['tipo']),
	Array($vetCampo['alias'],'',$vetCampo['selecao']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;







?>