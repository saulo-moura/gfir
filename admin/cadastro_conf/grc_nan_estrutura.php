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
$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";
$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";
$class_frame = "class_frame";
$class_titulo = "class_titulo";
$class_titulo_c = "class_titulo_c";
$titulo_na_linha = false;

$veiofull = 0;
if ($_GET['idCad'] == '') {
    $sql = '';
    $sql .= " select gec_cc.idt_organizacao, gec_cc.nan_idt_unidade_regional";
    $sql .= ' from grc_nan_estrutura grc_ne ';
    $sql .= ' inner join '.db_pir_gec.'gec_contratar_credenciado gec_cc on gec_cc.idt = grc_ne.idt_contrato ';
    $sql .= ' where grc_ne.idt = '.null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];
} else {
    $_GET['idt0'] = $_GET['idCad'];
    $veiofull = 1;
    //$_GET['idt1'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'", parent.grc_nan_estrutura_fecha);</script>';

    $sql = '';
    $sql .= " select gec_cc.idt_organizacao, gec_cc.nan_idt_unidade_regional";
    $sql .= ' from '.db_pir_gec.'gec_contratar_credenciado gec_cc';
    $sql .= ' where gec_cc.idt = '.null($_GET['idt0']);
    $rs = execsql($sql);
    $row = $rs->data[0];
}

$TabelaPai = db_pir_gec.'gec_contratar_credenciado';
$AliasPai = "gec_oc";
$EntidadePai = "Contrato";
$idPai = "idt";
$CampoPricPai = "idt_contrato";

$onSubmitDep = 'grc_nan_estrutura_dep()';

//
$TabelaPrinc = "grc_nan_estrutura";
$AliasPric = "gec_ne";
$Entidade = "AOE E TUTOR do Contrato";
$Entidade_p = "AOEs E TUTORES do Contrato";

$CampoPricPai = "idt_contrato";


$tabela = 'grc_nan_estrutura';
$id = 'idt';

$sql = '';
$sql .= " select idt_acao, idt_tutor";
$sql .= ' from grc_nan_estrutura grc_ne ';
$sql .= ' where grc_ne.idt = '.null($_GET['id']);
$rs = execsql($sql);
$rowEst = $rs->data[0];

if ($veiofull == 1) {
    $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
} else {
    $sql = "select gec_cc.idt, ";
    $sql .= " gec_e.descricao as gec_e_executora, ";
    $sql .= " sca_nan.descricao as sca_nan_ur, ";
    $sql .= " gec_cc.codigo ";
    $sql .= " from ".db_pir_gec."gec_contratar_credenciado gec_cc ";
    $sql .= " left join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
    $sql .= " left join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";
    $sql .= " where gec_cc.nan_indicador = ".aspa('S');
    $sql .= " order by sca_nan.descricao, gec_cc.codigo";
    $vetCampo['idt_contrato'] = objCmbBanco('idt_contrato', 'Contrato', false, $sql, ' ', 'width:580px;');
}



//$vetCampo[$CampoPricPai] = objCmbBanco($CampoPricPai, $EntidadePai, true, $sql, '', 'width:580px;');




$_GET['idt100'] = $row['nan_idt_unidade_regional'];
$_GET['idt101'] = $row['idt_organizacao'];

$vetCampo['idt_ponto_atendimento'] = objFixoBanco('idt_ponto_atendimento', 'Unidade Regional', db_pir.'sca_organizacao_secao', 'idt', 'descricao', 100);
$vetCampo['idt_empresa_executora'] = objFixoBanco('idt_empresa_executora', 'Empresa Executora', db_pir_gec.'gec_entidade', 'idt', 'codigo, descricao', 101);

$corbloq = "#FFFF80";
$jst = " readonly='true' style='background:{$corbloq}; font-size:12px; xwidth:100%;' ";
$vetCampo['codigo'] = objTexto('codigo', 'Classificação', true, 10, 45, $jst);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 40, 120);
$vetCampo['ativo'] = objCmbVetor('ativo', 'Ativo?', True, $vetSimNao, '');
$maxlength = 2000;
$style = "width:730px;";
$js = "";

$vetCampo['detalhe'] = objTextArea('detalhe', 'Observação', false, $maxlength, $style);

$sql = "select idt, descricao from grc_nan_estrutura_tipo where idt = 6 order by codigo";

$sql = '';
$sql .= " select uf.id_usuario, ef.codigo, ef.descricao, group_concat(distinct er.descricao separator ', ') as tipo";
$sql .= ' from '.db_pir_gec.'gec_entidade_entidade ee';
$sql .= ' inner join '.db_pir_gec.'gec_entidade ef on ef.idt = ee.idt_entidade_relacionada';
$sql .= ' inner join '.db_pir_gec.'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
$sql .= ' inner join plu_usuario uf on uf.login = ef.codigo';
$sql .= ' where ee.idt_entidade = '.null($row['idt_organizacao']);
$sql .= " and ee.ativo = 'S'";
$sql .= ' and ee.idt_entidade_relacao = 8';
$sql .= " and ef.tipo_entidade = 'P'";
$sql .= " and ef.reg_situacao = 'A'";
$sql .= " and ef.ativo = 'S'";
$sql .= " and ef.credenciado_nan = 'S'";
$sql .= " and ef.credenciado = 'S'";
$sql .= " and ef.nan_ano = ".aspa(nan_ano);
$sql .= ' group by uf.id_usuario, ef.codigo, ef.descricao';
$sql .= ' order by ef.descricao';
$vetCampo['idt_usuario'] = objCmbBanco('idt_usuario', 'Agente', true, $sql, ' ', 'width:580px;');

$width = '580px';

$sql = "select ";
$sql .= " grc_pa.idt, grc_p.descricao, grc_pa.descricao ";
$sql .= " from grc_projeto_acao grc_pa ";
$sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto';
$sql .= " where nan_idt_unidade_regional =  ".null($_GET['idt100']);
$sql .= " and grc_pa.nan =  ".aspa('S');
$sql .= " order by grc_p.descricao, grc_pa.descricao";
$vetCampo['idt_acao'] = objCmbBanco('idt_acao', 'Projeto/Ação', true, $sql, ' ', 'width:580px;');

$sql = "select grc_ne.idt,  ";
$sql .= " plu_usu.nome_completo as plu_usu_nome_completo  ";
$sql .= " from grc_nan_estrutura grc_ne ";
$sql .= " inner join grc_nan_estrutura_tipo grc_net on grc_net.idt  = grc_ne.idt_nan_tipo ";
$sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
$sql .= " where grc_ne.idt_acao = ".null($rowEst['idt_acao']);
$sql .= " and   grc_net.codigo = ".aspa('05');
$sql .= " order by plu_usu.nome_completo";
$vetCampo['idt_tutor'] = objCmbBanco('idt_tutor', 'Tutor', true, $sql, ' ', 'width:580px;');
$vetCampo['idt_tutor_old'] = objHidden('idt_tutor_old', $rowEst['idt_tutor'], '', '', false);

/*
  $vetFrm[] = Frame('<span></span>', Array(
  Array($vetCampo[$CampoPricPai]),
  ), $class_frame, $class_titulo, $titulo_na_linha);
 */
//
MesclarCol($vetCampo[$CampoPricPai], 3);
MesclarCol($vetCampo['idt_ponto_atendimento'], 3);
MesclarCol($vetCampo['idt_empresa_executora'], 3);
MesclarCol($vetCampo['idt_acao'], 3);
MesclarCol($vetCampo['detalhe'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_ponto_atendimento']),
    Array($vetCampo['idt_empresa_executora']),
    Array($vetCampo['idt_usuario'], '', $vetCampo['ativo']),
    Array($vetCampo['idt_acao']),
    Array($vetCampo['idt_tutor'], '', $vetCampo['idt_tutor_old']),
    Array($vetCampo['detalhe']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idt_usuario").cascade("#idt_empresa_executora", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_pf_pj_usuario&cas=' + conteudo_abrir_sistema
            }
        });

        $("#idt_acao").cascade("#idt_ponto_atendimento", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_acao_pa&cas=' + conteudo_abrir_sistema
            }
        });

        $("#idt_tutor").cascade("#idt_acao", {
            ajax: {
                url: ajax_sistema + '?tipo=nan_tutor_acao&cas=' + conteudo_abrir_sistema
            }
        });

        $('#idt_contrato').change(function () {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_nan_estrutura_contrato',
                data: {
                    cas: conteudo_abrir_sistema,
                    id: $(this).val()
                },
                success: function (response) {
                    if (response.erro == '') {
                        $('#idt_ponto_atendimento').val(url_decode(response.idt_ponto_atendimento));
                        $('#idt_ponto_atendimento_tf').html(url_decode(response.idt_ponto_atendimento_desc));
                        $('#idt_empresa_executora').val(url_decode(response.idt_empresa_executora));
                        $('#idt_empresa_executora_tf').html(url_decode(response.idt_empresa_executora_desc));

                        $('#idt_empresa_executora').change();
                        $('#idt_ponto_atendimento').change();
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $("#dialog-processando").remove();

        });
    });

    function grc_nan_estrutura_dep() {
        if ($('#idt_tutor').val() != $('#idt_tutor_old').val() && $('#id').val() > 0) {
            return confirm('Se continuar com a operação vai ser trocado o Tutor dos atendimentos abertos deste AOE!');
        }

        return true;
    }
</script>