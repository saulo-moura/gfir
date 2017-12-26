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

$tabela = 'grc_nan_estrutura';
$id = 'idt';

$sql = '';
$sql .= " select grc_ne.*";
$sql .= ' from grc_nan_estrutura grc_ne ';
$sql .= ' where grc_ne.idt = '.null($_GET['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetCampo['idt_ponto_atendimento'] = objHidden('idt_ponto_atendimento', 6);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');

$maxlength = 2000;
$style = "width:730px;";
$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

$sql = "select idt, descricao from grc_nan_estrutura_tipo ";
$sql .= " where idt in (8, 9, 2, 4)";
$sql .= " order by ordem";
$vetCampo['idt_nan_tipo'] = objCmbBanco('idt_nan_tipo', 'Tipo', true, $sql, ' ', 'width:180px;');

$vetCampo['idt_usuario'] = objListarCmb('idt_usuario', 'grc_organizacao_nan_cmb', 'Ator', true);

switch ($row['idt_nan_tipo']) {
    case 9:
        $idt_nan_tipo = 8;
        break;

    case 2:
        $idt_nan_tipo = 9;
        break;

    case 4:
        $idt_nan_tipo = 2;
        break;

    default:
        $idt_nan_tipo = 0;
        break;
}

$sql = "select grc_ne.idt, plu_usu.nome_completo";
$sql .= " from grc_nan_estrutura grc_ne ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = grc_ne.idt_usuario";
$sql .= " where grc_ne.idt_nan_tipo = ".null($idt_nan_tipo);
$sql .= " order by plu_usu.nome_completo";
$vetCampo['idt_tutor'] = objCmbBanco('idt_tutor', 'Ator Superior', false, $sql, ' ', 'width:380px;');

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

MesclarCol($vetCampo['idt_ponto_atendimento'], 5);
MesclarCol($vetCampo['idt_usuario'], 3);
MesclarCol($vetCampo['detalhe'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_ponto_atendimento']),
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
                url: ajax_sistema + '?tipo=nan_tipo_tutor&cas=' + conteudo_abrir_sistema
            }
        });

        $('#idt_tutor').bind('cascade', function () {
            var campo = $("#idt_tutor");
            var obr = $("#idt_tutor_desc");
            var vlTmp = $('#idt_nan_tipo').val();

            if (vlTmp == null) {
                vlTmp = "";
            }

            func_AtivaDesativa(vlTmp.toLowerCase(), ",8".split(","), campo, obr, ",8".split(","), "S", "N", "");
        });

        $('#idt_nan_tipo').change();
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