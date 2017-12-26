<style>
    .proprio {
        background: #2F66B8;
        color     : #FFFFFF;
        text-align: center;
        font-size:18px;
        height:20px;
        padding:10px;

    }

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
        width: 500px;
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
        width: 88px;
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

    #idt_ponto_atendimento_tf {
        width: 730px;
    }
    #frm5 {

    }

</style>
<?php
$_SESSION[CS]['g_nom_tela'] = 'Estrutura Operacional do NAN';

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_c = "class_titulo_c";
$titulo_na_linha = false;


if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.grc_nan_estrutura_arvore_fecha);</script>';
}

$tabela = 'grc_nan_estrutura';
$id = 'idt';

$TabelaPai = "grc_projeto_acao";
$AliasPai = "grc_pa";
$EntidadePai = "Ação do Projeto";
$idPai = "idt";

$CampoPricPai = "idt_acao";

$sql = '';
$sql .= " select grc_pa.*, ";
$sql .= "        grc_p.descricao as grc_p_descricao ";
$sql .= ' from grc_projeto_acao grc_pa ';
$sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto ';
$sql .= ' where grc_pa.idt = '.null($_GET['idt0']);
$rs = execsql($sql);
$row = $rs->data[0];

$grc_p_descricao = $row['grc_p_descricao'];

echo " <div id='id_projeto' style='width:100%; background:#0000FF; color:#FFFFFF; '>";
echo " $grc_p_descricao <br />";
echo " </div>";

$sql = '';
$sql .= " select grc_ne.*";
$sql .= ' from grc_nan_estrutura grc_ne ';
$sql .= ' where grc_ne.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, $idPai, 'descricao', 0);
$vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Ponto de Atendimento', db_pir."sca_organizacao_secao", 'idt', 'descricao', 'nan_idt_unidade_regional');

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['codigo'] = objTexto('codigo', 'Classificação', true, 10, 45, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 40, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

$maxlength = 2000;
$style = "width:730px;";
$js = "";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

$sql = "select idt, descricao from grc_nan_estrutura_tipo ";
$sql .= " where idt in (5, 3, 10)";
$sql .= " order by ordem";
$vetCampo['idt_nan_tipo'] = objCmbBanco('idt_nan_tipo', 'Tipo', true, $sql, ' ', 'width:180px;');
$vetCampo['idt_usuario'] = objListarCmb('idt_usuario', 'grc_organizacao_nan_cmb', 'Gestor / Tutor', false);

switch ($row['idt_nan_tipo']) {
    case 10:
        $idt_nan_tipo = 4;
        break;

    case 3:
        $idt_nan_tipo = 10;
        break;

    case 5:
        $idt_nan_tipo = 3;
        break;

    default:
        $idt_nan_tipo = 0;
        break;
}

$sql = "select grc_ne.idt,  ";
$sql .= " plu_usu.nome_completo as plu_usu_nome_completo  ";
$sql .= " from grc_nan_estrutura grc_ne ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
$sql .= " where grc_ne.idt_nan_tipo = ".null($idt_nan_tipo);

if ($row['idt_nan_tipo'] != 10) {
    $sql .= " and grc_ne.idt_ponto_atendimento = ".null($_GET['nan_idt_unidade_regional']);
}

$sql .= " order by plu_usu.nome_completo";
$vetCampo['idt_tutor'] = objCmbBanco('idt_tutor', 'Gestor', true, $sql, ' ', 'width:380px;');

$vetCampo['vl_aprova_ordem'] = objDecimal('vl_aprova_ordem', 'Valor da Alçada', false, 15);

$sql = '';
$sql .= " select idt, aprova_ordem";
$sql .= ' from grc_nan_estrutura_tipo';
$rstt = execsql($sql);

$vetDE = Array();
$vetAT = Array();
foreach ($rstt->data as $rowtt) {
    if ($rowtt['aprova_ordem'] == 'S') {
        $vetAT[] = $rowtt['idt'];
    } else {
        $vetDE[] = $rowtt['idt'];
    }
}

$par = 'vl_aprova_ordem';
$vetDesativa['idt_nan_tipo'][0] = vetDesativa($par, ','.implode(',', $vetDE));
$vetAtivadoObr['idt_nan_tipo'][0] = vetAtivadoObr($par, implode(',', $vetAT));

if ($_GET['idt0'] > 0) {
    $vetFrm[] = Frame('<span></span>', Array(
        Array($vetCampo[$CampoPricPai]),
        Array($vetCampo['idt_ponto_atendimento']),
            ), $class_frame, $class_titulo, $titulo_na_linha);
}

MesclarCol($vetCampo['idt_usuario'], 3);
MesclarCol($vetCampo['detalhe'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_nan_tipo'], '', $vetCampo['idt_usuario']),
    Array($vetCampo['idt_tutor'], '', $vetCampo['vl_aprova_ordem'], '', $vetCampo['ativo']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idt_tutor").cascade("#idt_nan_tipo", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_tipo_tutor_pa&idt_pa=<?php echo $_GET['nan_idt_unidade_regional']; ?>&cas=' + conteudo_abrir_sistema
            }
        });

        $('#idt_tutor').bind('cascade', function () {
            if (!$('#idt_tutor').prop("disabled")) {
                $('#idt_tutor').removeClass("campo_disabled");
            }
        });
    });

    function parListarCmb_idt_usuario() {
        var par = '';

        if ($('#idt_nan_tipo').val() == '') {
            alert('Favor informar o Tipo!');
            $('#idt_nan_tipo').focus();
            return false;
        }

        par += '&tipo=' + $('#idt_nan_tipo').val();

        return par;
    }
</script>