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
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$class_frame = "class_frame";
$class_titulo = "class_titulo";
$titulo_na_linha = false;

$TabelaPai = "grc_atendimento_organizacao";
$AliasPai = "grc_atp";
$EntidadePai = "Atendimento Pessoa";
$idPai = "idt";
//
$TabelaPrinc = "grc_atendimento_organizacao_cnae";
$AliasPric = "gec_apti";
$Entidade = "Atividade Econômica Secundária";
$Entidade_p = "Atividade Econômica Secundária";
$CampoPricPai = "idt_atendimento_organizacao";

$tabela = $TabelaPrinc;

$id = 'idt';

if ($_GET['id'] == 0 || $_GET['id'] == -1 || $_POST['idorg'] == -1) {
    $tabela = '';
    $vetCampo['idorg'] = objHidden('idorg', -1, '', '', false);
    $_GET['id'] = 0;

    $vetRetorno = Array(
        vetRetorno('subclasse', '', true),
        vetRetorno('descricao', '', true),
    );

    $vetCampo['cnae'] = objListarCmbMulti('cnae', 'gec_cnae', 'Atividade Econômica Secundária', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['cnae'] = objListarCmb('cnae', 'gec_cnae', 'Atividade Econômica Secundária', true);
}

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'razao_social', 0);

$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['cnae']),
    Array($vetCampo['idorg']),
        ), $class_frame, $class_titulo, $titulo_na_linha);
$vetCad[] = $vetFrm;
