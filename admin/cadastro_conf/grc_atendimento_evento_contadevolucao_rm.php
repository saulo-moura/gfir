<?php
$valSel = -1;

$sql = '';
$sql .= ' select codigo, descricao';
$sql .= ' from grc_evento_banco';
$rs = execsql($sql);

$vetBanco = Array();

foreach ($rs->data as $row) {
    $vetBanco[$row['codigo']] = $row['descricao'];
}

$filtro = "codcoligada=1 and (codcfo = '" . $rm_codcfo . "'";

if ($rowDados['inc_pag_rm'] == 'S') {
    $sql = '';
    $sql .= ' select cpf, nome';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($rowDados['idt_atendimento']);
    $sql .= " and tipo_relacao = 'L'";
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetDadosBtNovo['F'] = Array(
        'cpfcnpj' => $row['cpf'],
        'razao_social' => substr($row['nome'], 0, 60),
    );

    $parametro = Array(
        'DataServerName' => 'FinCFODataBR',
        'Filtro' => "codcoligada=1 and cgccfo = '" . FormataCPF14($row['cpf']) . "'",
        'Contexto' => 'codcoligada=1',
    );
    $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

    $filtro .= " or codcfo = '" . $rsRM['FCFO']->data[0]['codcfo'] . "'";
}

$filtro .= ")";

$parametro = Array(
    'DataServerName' => 'FinDadosPgtoDataBR',
    'Filtro' => $filtro,
    'Contexto' => 'codcoligada=1',
);
$rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FDadosPgto'), $parametro, true);
$rsConta = $rsRM['FDadosPgto'];

$vetConta = Array();

foreach ($rsConta->data as $idx => $rowConta) {
    $parametro = Array(
        'DataServerName' => 'FinDadosPgtoDataBR',
        'PrimaryKey' => '1;1;' . $rowConta['codcfo'] . ';' . $rowConta['idpgto'],
        'Contexto' => 'codcoligada=1;codcolcfo=1;codcfo=' . $rowConta['codcfo'] . ';idpgto=' . $rowConta['idpgto'],
    );
    $rsRM = $SoapSebraeRM_DS->executa('ReadRecordAuth', Array('FDadosPgto'), $parametro, true);
    $rowRM = $rsRM['FDadosPgto']->data[0];

    $vetConta[$idx] = Array(
        'rm_codcfo' => $rowRM['codcfo'],
        'rm_idpgto' => $rowRM['idpgto'],
        'banco_numero' => $rowRM['numerobanco'],
        'banco_nome' => $vetBanco[$rowRM['numerobanco']],
        'agencia_numero' => $rowRM['codigoagencia'],
        'agencia_digito' => $rowRM['digitoagencia'],
        'cc_numero' => $rowRM['contacorrente'],
        'cc_digito' => $rowRM['digitoconta'],
        'cpfcnpj' => formataCPFCNPJ($rowRM['cgcfavorecido']),
        'razao_social' => $rowRM['favorecido'],
    );

    if ($rowRM['idpgto'] === $rowDados['rm_idpgto']) {
        $valSel = $idx;
    }
}

$_SESSION[CS]['tmp']['contadevolucao'][$_GET['session_cod']] = $vetConta;
?>
<style type="text/css">
    #cc_rm {
        border-collapse: collapse;
        width: 100%;
    }

    #cc_rm td {
        padding: 2px 5px;
    }

    #cc_rm td:first-child {
        width: 15px;
    }

    #cc_rm tr.tit td {
        color: #00297B;
        font-weight: bold;
        border-bottom: 1px solid #aaaaaa;
    }

    #cc_rm tr.bt td {
        border-bottom: none;
        border-top: 1px solid #aaaaaa;
    }
</style>
<table id="cc_rm">
    <tr class="tit">
        <td></td>
        <td>Banco</td>
        <td>Agência</td>
        <td>Conta</td>
        <td>CPF / CNPJ</td>
        <td>Nome / Razão Social</td>
    </tr>
    <?php
    if (count($vetConta) == 0) {
        echo '<tr>';
        echo '<td style="text-align: center;" colspan="6">Não tem conta bancária (Jurídica ou Física) cadastrada no RM!</td>';
        echo '</tr>';
    } else {
        foreach ($vetConta as $idx => $row) {
            if ($valSel === $idx) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            echo '<tr>';
            echo '<td><input type="radio" name="conta" ' . $checked . ' value="' . $idx . '" /></td>';
            echo '<td>' . $row['banco_numero'] . ' - ' . $row['banco_nome'] . '</td>';

            //Agencia
            echo '<td>';
            echo $row['agencia_numero'];

            if ($row['agencia_digito'] != '') {
                echo ' - ' . $row['agencia_digito'];
            }

            echo '</td>';

            //Conta
            echo '<td>';
            echo $row['cc_numero'];

            if ($row['cc_digito'] != '') {
                echo ' - ' . $row['cc_digito'];
            }

            echo '</td>';
            echo '<td>' . $row['cpfcnpj'] . '</td>';
            echo '<td>' . $row['razao_social'] . '</td>';

            echo '</tr>';
        }
    }

    if ($rowDados['inc_pag_rm'] == 'S') {
        if ($valSel === -1) {
            $checked = 'checked';
        } else {
            $checked = '';
        }

        echo '<tr class="tit bt">';
        echo '<td><input type="radio" name="conta" ' . $checked . ' value="-1" /></td>';
        echo '<td colspan="5">Cadastrar outra conta bancária (Jurídica ou Física)</td>';
        echo '</tr>';
    } else {
        if ($valSel === -1) {
            $valSel = -2;
        }
    }
    ?>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cc_rm input:radio').click(function () {
            acaoClickRadio($(this).val());
        });

        acaoClickRadio(<?php echo $valSel; ?>);
    });

    function acaoClickRadio($val) {
        var obr = $('#banco_numero_desc, #agencia_numero_desc, #cc_numero_desc, #cpfcnpj_desc, #razao_social_desc');

        if ($val == -1) {
            obr.addClass("Tit_Campo_Obr").removeClass("Tit_Campo");
            $('fieldset.novo_rm').show();
        } else {
            obr.addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
            $('fieldset.novo_rm').hide();
        }

        TelaHeight();
    }
</script>