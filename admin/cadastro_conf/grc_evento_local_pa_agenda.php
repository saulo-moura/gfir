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
        guyheight:30px;
    }
    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        guyheight:30px;
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
        background: #2F66B8;

        text-align: left;
        border    : 0px solid #2C3E50;
        color     : #FFFFFF;
        color     : #FFFFFF;
        text-align: left;
        height    : 20px;
        font-size : 12px;
        padding-top:5px;



    }
    div.class_titulo_p span {
        padding:10px;

        text-align: left;
    }

    div.class_titulo_p_barra {
        text-align: left;
        background: #c4c9cd;
        border    : none;
        color     : #FFFFFF;
        font-weight: bold;
        line-height: 12px;
        margin: 0;
        padding: 3px;
        padding-left: 20px;
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
    div.class_titulo_c {
        xbackground: #C4C9CD;
        xborder    : 1px solid #2C3E50;
        xcolor     : #FFFFFF;
        text-align: center;

        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;


    }
    div.class_titulo_c span {
        padding-left:10px;
    }











    Select {
        border:0px;
        height:28px;
    }

    .TextoFixo {

        font-size:12px;
        guyheight:25px;
        text-align:left;
        border:0px;
        xbackground:#F1F1F1;
        background:#ECF0F1;


        font-weight:normal;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;
        font-style: normal;
        word-spacing: 0px;
        padding-top:5px;



    }

    td#idt_competencia_obj div {
        color:#FF0000;
    }

    .Tit_Campo {
        font-size:12px;
    }


    div#topo {
        wwxwidth:900px;
    }
    div#geral {
        wwxwidth:900px;
    }

    div#grd0 {
        wwxwidth:700px;
        wwxmargin-left:200px;

    }

    div#meio_util {
        wwxwidth:700px;
        wwxmargin-left:70px;
    }
    td.Titulo {
        color:#666666;
    }




    #idt_instrumento_obj {
        width:100%;
        height: 28px;
        overflow: hidden;
        display: block;
    }

    #idt_instrumento_tf {
        text-align:center;
        font-size:2em;
        background:#2C3E50;
        color:#FFFFFF;
        font-weight:bold;

        font-family: Lato Regular, Calibri, Arial,  Helvetica, sans-serif;

    }


    .Texto {
        padding: 3px;
        padding-top: 5px;
        border:0;
    }

    #idt_foco_tematico_tf {
        background: #ffff80;
    }

    div.Barra {
        xdisplay: none;
    }

    #lbl_painel_desc {
        text-align: center;
        color: black;
        font-weight: bold;
        font-size: 16px;
        vertical-align: middle;
    }

    #lbl_painel_desc div {
        padding-bottom: 5px;
        border-bottom: 1px solid #2f66b8;
    } 

    #evento_aberto_obj {
        width: 185px;
    }

    #dt_previsao_inicial_obj,
    #dt_previsao_fim_obj,
    #quantidade_participante_desc {
        white-space: nowrap;
    }

    #descricao {
        width: 429px;
    }

    #divProtocolo {
        color: #FFFFFF;
        font-weight: bold;
        float: right;
        padding-right: 10px;
        position: relative;
        font-size:12px;
        top: -19px;
    }

    .frm_evento_situacao {
        display: none;
    }

    Td.Titulo_radio {
        width: 64px;
    }

    fieldset.frm_sem_margem {
        margin: 0px
    }

    fieldset.frm_sem_margem > table {
        padding: 0px
    }

    fieldset.frm_left > table {
        width: auto;
        float: left;
    }
#idt_local_pa_tf {
        width: 700px;
    }
	
	
    #alocacao_disponivel_obj > div {
        width: 40px;
    }

    #alocacao_msg_obj > div {
        width: auto;
    }
</style>
<?php

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."', parent.funcaoFechaCTC_grc_evento_local_pa_agenda);";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.funcaoFechaCTC_grc_evento_local_pa_agenda);</script>';
}



$tabela = 'grc_evento_local_pa_agenda';
$id     = 'idt';

$TabelaPai   = "grc_evento_local_pa";
$AliasPai    = "grc_elpa";
$EntidadePai = "Local da Unidade Regional/PA´s";
$idPai       = "idt";

$CampoPricPai     = "idt_local_pa";

if ($_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';

    $vetCampo['idorg'] = objHidden('idorg', $_GET['id'], '', '', false);
    $_GET['id'] = 0;
}

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);

$vetCampo['data_inicial'] = objData('data_inicial', 'Data Inicial', true, '', '', 'S');
$vetCampo['data_final'] = objData('data_final', 'Data Final', true, '', '', 'S');

$vetCampo['hora_inicial'] = objHora('hora_inicial', 'Hora Inícial', true);
$vetCampo['hora_final'] = objHora('hora_final', 'Hora Final', true);

$vetCampo['dt_ini']       = objHidden('dt_ini', '');
$vetCampo['dt_fim']       = objHidden('dt_fim', '');

$vetStatus=Array();
$vetStatus['INDISPONIVEL'] = 'Indisponível';
$vetCampo['status'] = objCmbVetor('status', 'Status', True, $vetStatus,'');

$maxlength  = 2000;
$style      = "width:700px;";
$js         = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);
if ($_GET['idt0']>0)
{
    $vetFrm[] = Frame('', Array(
       Array($vetCampo[$CampoPricPai]),
    ),$class_frame,$class_titulo,$titulo_na_linha);
}
//
MesclarCol($vetCampo['detalhe'], 9);
MesclarCol($vetCampo['idorg'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['data_inicial'],'',$vetCampo['hora_inicial'],'',$vetCampo['data_final'],'',$vetCampo['hora_final'],'',$vetCampo['status']),
    Array($vetCampo['detalhe']),
    Array($vetCampo['dt_ini'], '', $vetCampo['dt_fim'], '', $vetCampo['idorg']),
    
),$class_frame,$class_titulo,$titulo_na_linha);

if ($_GET['id'] > 0) {
    $vetCampo['alocacao_disponivel'] = objFixoVetor('alocacao_disponivel', 'Local/Sala disponível?', false, $vetSimNao);
    $vetCampo['alocacao_msg'] = objHtml('alocacao_msg', 'Mensagem', false, '100', '', '', false, false, true);

    $vetFrm[] = Frame('<span>Local/Sala</span>', Array(
        Array($vetCampo['alocacao_disponivel'], '', $vetCampo['alocacao_msg']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

$vetCad[] = $vetFrm;