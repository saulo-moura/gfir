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
    $sql = "select ad.idt";
    $sql .= " from grc_avaliacao_devolutiva ad";
    $sql .= " inner join grc_avaliacao a on a.idt = ad.idt_avaliacao";
    $sql .= ' where a.idt_atendimento = '.null($_GET['idCad']);
    $rs = execsql($sql);
    $_GET['idCad'] = $rs->data[0][0];
    $_GET['idt0'] = $_GET['idCad'];

    $botao_volta = "parent.btFechaCTC('".$_GET['session_cod']."');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("'.$_GET['session_cod'].'");</script>';
}

$TabelaPai = "grc_avaliacao_devolutiva";
$AliasPai = "grc_eve";
$EntidadePai = "Devolutiva";
$idPai = "idt";

//
$TabelaPrinc = "grc_avaliacao_devolutiva_produto";
$AliasPric = "grc_evepro";
$Entidade = "Produto Associado";
$Entidade_p = "Produtos Associado";
$CampoPricPai = "idt_avaliacao_devolutiva";

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

    $vetCampo['idt_produto'] = objListarCmbMulti('idt_produto', 'grc_produto_cmb', 'Produto', true, '', '', '', $vetRetorno);
} else {
    $vetCampo['idt_produto'] = objListarCmb('idt_produto', 'grc_produto_cmb', 'Produto', true);
}

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idt0']);

$vetFrm = Array();

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_produto']),
    Array($vetCampo['idorg']),
    Array($vetCampo[$CampoPricPai]),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;