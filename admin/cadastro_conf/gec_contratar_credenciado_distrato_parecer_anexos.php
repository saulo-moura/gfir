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
    $_GET['entidade_idt'] = $_GET['idCad'];

    if ($_SESSION[CS]['g_abrir_sistema'] == '') {
        $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    } else {
        $botao_volta = "parent.parent.btFechaCTC('" . $_GET['session_cod'] . "');";
        $botao_acao = '<script type="text/javascript">parent.parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';
    }
}

$TabelaPai = "gec_contratar_credenciado_distrato_parecer";
$AliasPai = "gec_ccd";
$EntidadePai = "";
$idPai = "idt";
//
$TabelaPrinc = "gec_contratar_credenciado_distrato_parecer_anexos";
$AliasPric = "gec_ccaa";
$Entidade = "Arquivo em Anexo";
$Entidade_p = "Arquivos em Anexo";
$CampoPricPai = "idt_gec_contratar_credenciado_distrato_parecer";

$tabela = $TabelaPrinc;
$tabela_banco = db_pir_gec;

$pathObjFile = $vetSistemaUtiliza['GEC']['path_file'];

$id = 'idt';
$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['entidade_idt']);

$vetCampo['data_registro'] = objTextoFixo('data_registro', 'Data Registro', 20, true);

$sql = "select id_usuario, nome_completo from " . db_pir_gec . "plu_usuario order by nome_completo";
$js_hm = " disabled  ";
$style = " width:380px; background:#FFFFE1;  ";
$vetCampo['idt_responsavel'] = objCmbBanco('idt_responsavel', 'Responsavel', true, $sql, '', $style, $js_hm);

$vetCampo['arquivo'] = objFile('arquivo', 'Arquivo Associado', true, 120, 'todos');

$maxlength = 255;
$style = "width:700px; height:60px;";
$js = "";
$vetCampo['titulo'] = objTextArea('titulo', 'Título', true, $maxlength, $style, $js);

$vetFrm = Array();

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

MesclarCol($vetCampo[$CampoPricPai], 3);
MesclarCol($vetCampo['titulo'], 3);
MesclarCol($vetCampo['arquivo'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['titulo']),
    Array($vetCampo['arquivo']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
