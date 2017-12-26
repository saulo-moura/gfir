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
        background:#ECF0F1;
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
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
$AliasPai    = "grc_aae";
$TabelaPai   = " ";

$EntidadePai = "Administrar Email e SMS";
$idPai       = "idt";
//
$TabelaPrinc  = "grc_atendimento_administrar_email";
$AliasPric    = "grc_aae";
$Entidade     = "Administrar Email e SMS";
$Entidade_p   = "Administrar Email e SMS";

$tabela=$TabelaPrinc;

//
$vetCampo['codigo']    = objTexto('codigo', 'Código', True, 15, 45);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 60, 120);
$vetCampo['ativo']     = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao,'');




//
$maxlength  = 750;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação Detalhada', false, $maxlength, $style, $js);


/*
$sql  = " select plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
$js_hm   = " disabled  ";
$style   = " background:#FFFF80; font-size:14px;   ";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsável', false, $sql,'',$style,$js_hm);
$js    = " readonly='true' style='background:#FFFF80; font-size:14px;' ";
$vetCampo['data_registro'] = objDatahora('data_registro', 'Data Registro', False,$js);
*/

if ($_GET['id'] == 0) {
    $_GET['id_usuario1'] = $_SESSION[CS]['g_id_usuario'];
}
$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsável', 'plu_usuario', 'id_usuario', 'nome_completo', 1, true, '', true);
$vetCampo['data_registro']   = objTextoFixo('data_registro', 'Data Registro', 20, true, true, getdata(true, true, true));

$vetFrm = Array();
MesclarCol($vetCampo['detalhe'], 5);
MesclarCol($vetCampo['idt_responsavel'], 3);

$vetFrm[] = Frame('<span>Identificação</span>', Array(
	Array($vetCampo['codigo'],'',$vetCampo['descricao'],'',$vetCampo['ativo']),
	Array($vetCampo['detalhe']),
	Array($vetCampo['idt_responsavel'],'',$vetCampo['data_registro']),
),$class_frame,$class_titulo,$titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
</script>