<style>
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
</style>
<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}


$TabelaPrinc = "grc_evento_tema";
$AliasPric = "grc_at";
$Entidade = "Tema do Evento";
$Entidade_p = "Temas do Evento";
$CampoPricPai = "idt_evento";

$id = 'idt';
$tabela = $TabelaPrinc;


if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';
    $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
    $_GET['id'] = 0;

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno('idt_tema', '', false),
        vetRetorno($campoDescListarCmb, '', true),
    );

    $vetCampo['idt_sub_tema'] = objListarCmbMulti('idt_sub_tema', 'grc_tema_cmb', 'Tema e subtema', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['idt_sub_tema'] = objListarCmb('idt_sub_tema', 'grc_tema_cmb', 'Tema e subtema', true);
}

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['idt_sub_tema']),
    Array($vetCampo['idorg']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;