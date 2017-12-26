<style>
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
        background: #2C3E50;
        border    : 0px solid #2C3E50;
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
        color     : black;
        border    : 0px solid #2C3E50;
    }

    div.class_titulo span {
        padding:10px;
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

    .Tit_Campo {
        font-size:12px;
    }

    td.Titulo {
        color:#666666;
    }

    .Texto {
        padding: 3px;
        padding-top: 5px;
        border:0;
    }
</style>
<?php
$botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
$botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '");</script>';

$TabelaPrinc = "grc_atendimento_evento_contadevolucao";
$AliasPric = "grc_evepar";
$Entidade = "Dados para Devolução";
$Entidade_p = "Dados para Devolução";
$CampoPricPai = "idt_atendimento_evento";

$onSubmitDep = 'grc_atendimento_evento_contadevolucao_dep()';

$sql = '';
$sql .= ' select cd.*, ae.idt_atendimento';
$sql .= ' from grc_atendimento_evento_contadevolucao cd';
$sql .= ' inner join grc_atendimento_evento ae on ae.idt = cd.idt_atendimento_evento';
$sql .= ' where cd.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

$vetDadosBtNovo = Array();
$vetDadosBtNovo['J'] = Array(
    'cpfcnpj' => $rowDados['codigo'],
    'razao_social' => substr($rowDados['descricao'], 0, 60),
);

$SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');

$parametro = Array(
    'DataServerName' => 'FinCFODataBR',
    'Filtro' => "codcoligada=1 and cgccfo = '" . $rowDados['codigo'] . "'",
    'Contexto' => 'codcoligada=1',
);
$rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

$rm_codcfo = $rsRM['FCFO']->data[0]['codcfo'];

if ($rowDados['rm_idmov'] != '' && $acao != 'con') {
    $_GET['acao'] = 'con';
    $acao = 'con';
    alert('Não pode alterar este pagamento, pois já esta integrado com o RM!');
}

$tabela = $TabelaPrinc;
$id = 'idt';

$vetParametros = Array(
    'width' => '100%',
);

$vetFrm = Array();

$vetCampo[$CampoPricPai] = objHidden($CampoPricPai, $_GET['idCad']);
$vetCampo['rm_codcfo'] = objHidden('rm_codcfo', $rm_codcfo);
$vetCampo['rm_idpgto'] = objHidden('rm_idpgto', '');
$vetCampo['descricao'] = objTextoFixo('descricao', 'Pagametos feitos por', '', true);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['rm_codcfo']),
    Array($vetCampo['rm_idpgto']),
    Array($vetCampo['descricao']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetCampo['cc_rm'] = objInclude('cc_rm', 'cadastro_conf/grc_atendimento_evento_contadevolucao_rm.php');

$vetFrm[] = Frame('<span>Conta(s) bancária(s) vinculadas a Empresa Beneficiada (Jurídica ou Física)</span>', Array(
    Array($vetCampo['cc_rm']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

$vetParametros = Array(
    'align' => 'left',
);

$vetCampo['bt_novo'] = objInclude('bt_novo', 'cadastro_conf/grc_atendimento_evento_contadevolucao_bt.php');
$vetCampo['banco_numero'] = objListarCmb('banco_numero', 'grc_evento_banco', 'Banco', true, '500px');
$vetCampo['banco_nome'] = objHidden('banco_nome', '');
$vetCampo['agencia_numero'] = objTexto('agencia_numero', 'Número da Agência', true, 15);
$vetCampo['agencia_digito'] = objTexto('agencia_digito', 'Digito da Agência', false, 2);
$vetCampo['cc_numero'] = objTexto('cc_numero', 'Número da Conta Corrente', true, 15);
$vetCampo['cc_digito'] = objTexto('cc_digito', 'Digito da Conta Corrente', false, 2);

$js = 'onblur="return validaCPFCNPJ(this);" onkeyup="return formataCPFCNPJ(this,event);"';
$vetCampo['cpfcnpj'] = objTexto('cpfcnpj', 'CPF / CNPJ', true, 18, 18, $js);

$vetCampo['razao_social'] = objTexto('razao_social', 'Nome Completo / Razão Social', true, 60);

MesclarCol($vetCampo['bt_novo'], 7);
MesclarCol($vetCampo['banco_numero'], 5);
MesclarCol($vetCampo['razao_social'], 5);

$vetFrm[] = Frame('<span>Dados da conta bancária</span>', Array(
    Array($vetCampo['bt_novo']),
    Array($vetCampo['banco_numero'], '', $vetCampo['banco_nome']),
    Array($vetCampo['agencia_numero'], '', $vetCampo['agencia_digito'], '', $vetCampo['cc_numero'], '', $vetCampo['cc_digito']),
    Array($vetCampo['cpfcnpj'], '', $vetCampo['razao_social']),
        ), $class_frame . ' novo_rm', $class_titulo, $titulo_na_linha, $vetParametros);

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_atendimento_evento_contadevolucao_dep() {
        if ($('#cc_rm input:radio:checked').length == 0) {
            alert('Favor informar um opção de Conta(s) bancária(s) vinculadas a Empresa Beneficiada (Jurídica ou Física)!');
            return false;
        }

        return validaCPFCNPJ($('#cpfcnpj')[0]);
    }
</script>