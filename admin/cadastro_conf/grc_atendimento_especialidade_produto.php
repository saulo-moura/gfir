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
    // $_GET['entidade_idt'] = $_GET['idCad'];
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
} else {
/*
    if ($_GET['entidade_idt'] > 0) {
        $rascunho = cria_rascunho_entidade($_GET['entidade_idt'], DecideSistema());

        if (is_numeric($rascunho)) {
            $_GET['entidade_idt'] = $rascunho;
            $_REQUEST['entidade_idt'] = $rascunho;
        } else {
            die($rascunho);
        }
    }
*/	
}

$TabelaPai = "grc_atendimento_especialidade";
$AliasPai = "grc_ae";
$EntidadePai = "Especialidade do Servi�o";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento_especialidade_produto";
$AliasPric = "gec_aep";
$Entidade = "Produto do Servi�o";
$Entidade_p = "Produtos do Servi�o";
$CampoPricPai = "idt_atendimento_especialidade";

$tabela = $TabelaPrinc;

$id = 'idt';

if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';
    $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
    $_GET['id'] = 0;

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno($campoDescListarCmb, '', true),
    );

    $vetCampo['idt_produto'] = objListarCmbMulti('idt_produto', 'grc_produto_cmb', 'Produto do Servi�o', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['idt_produto'] = objListarCmb('idt_produto', 'grc_produto_cmb', 'Produto do Servi�o', true);
}

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);


$js = " readonly='true' style='background:#FFFFE1;' ";
$vetCampo['data_registro'] = objDataHora('data_registro', 'Data Registro', false, $js);

if ($_GET['id'] == 0) {
    $_GET['id_usuario99'] = $_SESSION[CS]['g_id_usuario'];
}

$vetCampo['idt_responsavel'] = objFixoBanco('idt_responsavel', 'Responsavel', 'plu_usuario', 'id_usuario', 'nome_completo', 99);

$maxlength = 255;
$style = "width:700px;";
$js = "";
$vetCampo['observacao'] = objTextArea('observacao', 'Observa��o', false, $maxlength, $style, $js);

//
$vetFrm = Array();

$class_frame_f = "class_frame_f";
$class_titulo_f = "class_titulo_f";

$class_frame_p = "class_frame_p";
$class_titulo_p = "class_titulo_p";

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$titulo_cadastro = 'PRODUTO DO SERVI�O';

$vetParametros = Array(
    'situacao_padrao' => true,
);
$vetFrm[] = Frame("<span>$titulo_cadastro</span>", '', $class_frame_f, $class_titulo_f, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'codigo_frm' => 'relato01a',
    'controle_fecha' => 'A',
);

$vetFrm[] = Frame('<span>1 - IDENTIFICA��O</span>', '', $class_frame_p, $class_titulo_p, $titulo_na_linha_p, $vetParametros);

$vetParametros = Array(
    'codigo_pai' => 'relato01a',
);

MesclarCol($vetCampo['idt_produto'], 3);
MesclarCol($vetCampo['idorg'], 3);
MesclarCol($vetCampo['observacao'], 3);
$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_produto']),
    Array($vetCampo['idorg']),
    Array($vetCampo['observacao']),
    Array($vetCampo['idt_responsavel'], '', $vetCampo['data_registro']),
    Array(),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#idt_atendimento_especialidade_tf').html(parent.$('#descricao').val());
    });
</script>