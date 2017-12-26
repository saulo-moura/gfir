<style type="text/css">
    fieldset.class_frame_f {
        background:#2F66B8;
        border:1px solid #FFFFFF;
    }

    div.class_titulo_f {
        background: #2F66B8;
        border    : 1px solid #2C3E50;
        color     : #FFFFFF;
        text-align: left;
        padding-top:10px;
    }

    div.class_titulo_f span {
        padding-left:20px;
        text-align: left;
    }

    fieldset.class_frame_p {
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
        background:#FFFFFF;
        border:0px solid #2C3E50;
    }

    div.class_titulo {
        text-align: left;
        background: #FFFFFF;
        color     : #FFFFFF;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding-left:10px;
    }

    div.class_titulo_c {
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
        text-align:left;
        border:0px;
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


// Dados da tabela Pai (Nivel 1)

$TabelaPai = "grc_plano_facil_area";
$AliasPai = "grc_pfa";
$EntidadePai = "Área Temática";
$idPai = "idt";


$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc = "grc_plano_facil_plano_acao";
$AliasPric = "grc_pfpa";
$Entidade = "Plano de Ação da Área Plano Fácil";
$Entidade_p = "Plano de Ação da Área Plano Fácil";
$CampoPricPai = "idt_atendimento";


$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)
//p($_GET);
$id = 'idt';

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$vetCampo['quem'] = objTexto('quem', 'Quem?', true, 120);
$vetCampo['quando'] = objData('quando', 'Quando?', true, "", "", "S");

$vetFrm = Array();

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['quem']),
    Array($vetCampo['quando']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        ajusta_altura_PopWin(350);
    });
</script>