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

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_plano_facil';
$sql .= ' where idt_atendimento = '.null($_GET['idt0']);
$rsPF = execsql($sql);
$rowPF = $rsPF->data[0];

$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

// Dados da tabelha filho nivel 2 (deste programa)

$TabelaPrinc = "grc_plano_facil_ferramenta_pri";
$AliasPric = "grc_pff";
$Entidade = "Ferramentas priorizadas pelo cliente";
$Entidade_p = "Ferramentas priorizadas pelo cliente";
$CampoPricPai = "idt_atendimento";
$_SESSION[CS]['g_nom_tela'] = $Entidade;

$tabela = $TabelaPrinc;

$id = 'idt';
$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$sql = '';
$sql .= ' select pff.idt, fg.descricao as ferramenta, fa.descricao as area';
$sql .= ' from grc_plano_facil_ferramenta pff';
$sql .= ' inner join grc_formulario_ferramenta_gestao fg on fg.idt = pff.idt_ferramenta';
$sql .= ' inner join grc_plano_facil_area pfa on pfa.idt = pff.idt_plano_facil_area';
$sql .= ' inner join grc_formulario_area fa on fa.idt = pfa.idt_area';
$sql .= ' where pfa.idt_plano_facil = '.null($rowPF['idt']);
$sql .= " and pff.ativo = 'S'";
$sql .= ' order by pff.idt';
$vetCampo['idt_grc_plano_facil_ferramenta'] = objCmbBanco('idt_grc_plano_facil_ferramenta', 'Ferramenta', true, $sql);

$vetFrm = Array();

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_grc_plano_facil_ferramenta']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);


$vetCad[] = $vetFrm;