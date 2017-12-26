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
        xbackground:#ABBBBF;
        xborder:1px solid #FFFFFF;

        background:#FFFFFF;
        border:0px solid #FFFFFF;



    }
    div.class_titulo_p {
        xbackground: #ABBBBF;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;
        xbackground: #F1F1F1;

        background: #ECF0F1;

        background: #C4C9CD;


        border    : 0px solid #2C3E50;
        color     : #FFFFFF;

    }
    div.class_titulo_p span {
        padding-left:20px;
        text-align: left;
    }



    fieldset.class_frame {
        xbackground:#ECF0F1;
        xborder:1px solid #2C3E50;
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }
    div.class_titulo {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: left;

        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;


    }
    div.class_titulo span {
        padding-left:10px;
    }

    Select {
        border:0px;
        xopacity: 0;
        xfilter:alpha(opacity=0);
    }

    .TextoFixo {

        font-size:12px;
        height:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;



    }
    .Texto {

        font-size:12px;
        height:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        color:#5C6D7E;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;

    }

    td.Titulo {
        color:#666666;
    }



</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPrinc = "grc_avaliacao_resposta_anexo";
$AliasPric = "grc_ara";
$Entidade = "Resposta Anexo";
$Entidade_p = "Respostas Anexo";
$CampoPricPai = "idt_resposta";

$id = 'idt';
$tabela = $TabelaPrinc;

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$vetCampo['descricao']   = objTexto('descricao', 'Título', true, 30, 120);
$vetCampo['arquivo']     = objFile('arquivo', 'Arquivo Anexado', true, 120, 'todos');

$maxlength = 2000;
$style = "width:700px;";
$js = "";

$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

if ($_GET['id'] == 0) {
    $_GET['id_usuario1'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 1, true, '', true);
$vetCampo['data_responsavel'] = objTextoFixo('data_responsavel', 'Data Registro', 20, true, true, getdata(true, true, true));

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

MesclarCol($vetCampo['observacao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['descricao'], '', $vetCampo['arquivo']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_responsavel']),
    Array($vetCampo['observacao']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
