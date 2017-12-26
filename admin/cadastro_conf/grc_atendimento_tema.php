<style>
    #nm_funcao_desc label{
    }
    #nm_funcao_obj {
    }
    .Tit_Campo {
    }
    .Tit_Campo_Obr {
    }
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
//p($_GET);

if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}
//p($_GET);


$TabelaPai = "grc_atendimento";
$AliasPai = "grc_a";
$EntidadePai = "Protocolo";
$idPai = "idt";

//
$TabelaPrinc = "grc_atendimento_tema";
$AliasPric = "grc_at";
$Entidade = "Tema do Atendimento";
$Entidade_p = "Temas do Atendimento";
$CampoPricPai = "idt_atendimento";

$tabela = $TabelaPrinc;


if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';
    $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
    $_GET['id'] = 0;

    $vetRetorno = Array(
        vetRetorno('idt', '', false),
        vetRetorno($campoDescListarCmb, '', true),
    );

    $vetCampo['idt_tema'] = objListarCmbMulti('idt_tema', 'grc_tema_cmb_n0', 'Tema', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['idt_tema'] = objListarCmb('idt_tema', 'grc_tema_cmb_n0', 'Tema', true);
}

$id = 'idt';
$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'protocolo', 0);

$vetCampo['tipo_tratamento'] = objHidden('tipo_tratamento', 'I');

$vetFrm = Array();
$vetFrm[] = Frame('<span>Assunto</span>', Array(
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetFrm[] = Frame('<span>Consultor</span>', Array(
    Array($vetCampo['idt_tema']),
    Array($vetCampo['idorg']),
    Array($vetCampo['tipo_tratamento']),
        ), $class_frame, $class_titulo, $titulo_na_linha);


$vetCad[] = $vetFrm;
