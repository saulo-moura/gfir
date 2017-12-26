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
    //$_GET['entidade_idt'] = $_GET['idCad'];
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
} else {
    if ($_GET['entidade_idt'] > 0) {
        // $rascunho = cria_rascunho_entidade($_GET['entidade_idt'], DecideSistema());

        if (is_numeric($rascunho)) {
            $_GET['entidade_idt'] = $rascunho;
            $_REQUEST['entidade_idt'] = $rascunho;
        } else {
            die($rascunho);
        }
    }
}
$TabelaPai = "grc_entidade_pessoa";
$AliasPai = "grc_atp";
$EntidadePai = "Pessoa";
$idPai = "idt";
//
$TabelaPrinc = "grc_entidade_pessoa_tema_interesse";
$AliasPric = "gec_apti";
$Entidade = "Tema de Interesse da Pessoa";
$Entidade_p = "Tema de Interesse da Pessoa";
$CampoPricPai = "idt_entidade_pessoa";

$tabela = $TabelaPrinc;
$onSubmitDep = 'grc_entidade_pessoa_tema_interesse_dep()';


$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'nome', 0);


$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_registro'] = objDataHora('data_registro', 'Data Registro', false, $js);

if ($_GET['id'] == 0) {
    $_GET['id_usuario99'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 99);

$sql = "select idt, descricao from grc_tema_subtema ";
$sql .= ' where nivel = 0';
$sql .= " and ativo = 'S'";
$sql .= " order by codigo";
$vetCampo['idt_tema'] = objCmbBanco('idt_tema', 'Tema de Interesse', true, $sql, '', 'width:380px;');

//$sql = "select idt, descricao from ".db_pir_grc."grc_tema_subtema ";
//$sql = " order by codigo";
//$vetCampo['idt_subtema'] = objCmbBanco('idt_subtema', 'Subtema de Interesse', false, $sql,'','width:380px;');
//$vetCampo['idt_produto'] = objListarCmb('idt_produto', 'grc_produto_cmb', 'Produto de Interesse', true);

$maxlength = 255;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observação', false, $maxlength, $style, $js);

//
$vetFrm = Array();

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = 'TEMAS DE INTERESSE';

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'relato01a',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>1 - IDENTIFICAÇÃO</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'relato01a',
);

MesclarCol($vetCampo['observacao'], 3);
MesclarCol($vetCampo['idt_tema'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    //Array($vetCampo['idt_tema'],'',$vetCampo['idt_subtema']),
    Array($vetCampo['idt_tema']),
    Array($vetCampo['observacao']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro']),
    Array(),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idt_entidade_pessoa_tf').html(parent.$('#nome').val());
    });

    function grc_entidade_pessoa_tema_interesse_dep() {
        var ok = true;

        if (valida == 'S') {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema +  '?tipo=grc_entidade_pessoa_tema_interesse_dep',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt: $('#id').val(),
                    idt_entidade_pessoa: $('#idt_entidade_pessoa').val(),
                    idt_tema: $('#idt_tema').val()
                },
                success: function (response) {
                    if (response.erro != '') {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                        ok = false;
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    ok = false;

                },
                async: false
            });

            $("#dialog-processando").remove();
        }

        return ok;
    }
</script>