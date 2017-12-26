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
//p($_GET);
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
// Dados da tabela Pai (Nivel 1)
$TabelaPai   = "grc_plano_facil_area";
$AliasPai    = "grc_pfa";
$EntidadePai = "Foco Temática";
$idPai       = "idt";
//
$class_titulo_f  = "class_titulo_f";
$class_frame_p   = "class_frame_p";
$class_titulo_p  = "class_titulo_p";
$class_frame     = "class_frame";
$class_titulo    = "class_titulo";
$titulo_na_linha = false;
//
// Dados da tabelha filho nivel 2 (deste programa)
//
$TabelaPrinc      = "grc_plano_facil_produto";
$AliasPric        = "grc_pfp";
$Entidade         = "Produto Plano Fácil"; 
$Entidade_p       = "Produtos Plano Fácil";
$CampoPricPai = "idt_atendimento";
//
$tabela = $TabelaPrinc;
// Fixa o item da tabela anterior (PAI)
$id = 'idt';

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$sql = '';
$sql .= ' select a.idt_grupo_atendimento';
$sql .= ' from grc_atendimento a';
$sql .= ' where a.idt = '.null($_GET['idt0']);
$rs = execsql($sql);
$idt_grupo_atendimento = $rs->data[0][0];

$sql = '';
$sql .= ' select ad.idt';
$sql .= ' from grc_atendimento at';
$sql .= ' inner join grc_avaliacao av on av.idt_atendimento = at.idt';
$sql .= ' inner join grc_avaliacao_devolutiva ad on ad.idt_avaliacao = av.idt';
$sql .= ' where at.idt_grupo_atendimento = '.null($idt_grupo_atendimento);
$sql .= ' and at.nan_num_visita = 1';
$rs = execsql($sql);
$idt_avaliacao_devolutiva = $rs->data[0][0];

$sql = '';
$sql .= ' select idt, descricao';
$sql .= ' from grc_produto';
$sql .= ' where idt in (';
$sql .= ' select idt_produto';
$sql .= ' from grc_avaliacao_devolutiva_produto';
$sql .= ' where idt_avaliacao_devolutiva = '.null($idt_avaliacao_devolutiva);
$sql .= " and ativo = 'S'";
$sql .= ' )';
$sql .= ' order by descricao';

$js_hm   = "";
$style   = " width:100%;  ";
$vetCampo['idt_produto'] = objCmbBanco('idt_produto', 'Produto', true, $sql,' ',$style,$js_hm);

$vetFrm = Array();

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_produto']),
),$class_frame,$class_titulo,$titulo_na_linha,$vetParametros);

$vetCad[] = $vetFrm;