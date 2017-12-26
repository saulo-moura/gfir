<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_publicacao_voucher);</script>';
}

$TabelaPai = "grc_evento_publicacao_voucher";
$AliasPai = "grc_ep";
$EntidadePai = "Voucher da Política de Desconto";
$idPai = "idt";

$TabelaPrinc = "grc_evento_publicacao_voucher_registro";
$AliasPric = "grc_epc";
$Entidade = "Registro do Voucher da Política de Desconto";
$Entidade_p = "Registro do Voucher da Política de Desconto";
$CampoPricPai = "idt_evento_publicacao_voucher";

$tabela = $TabelaPrinc;
$id = 'idt';

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento_publicacao_voucher_registro';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

if ($rowDados['dt_utilizacao'] != '') {
    alert('Voucher já utilizado! Com isso só pode consultar.');
    $_GET['acao'] = 'con';
    $acao = $_GET['acao'];
}

$vetFrm = Array();

if ($_GET['veio'] == 'ep') {
    $sql = '';
    $sql .= ' select t.codigo';
    $sql .= ' from grc_evento_publicacao_voucher v';
    $sql .= ' inner join grc_evento_tipo_voucher t on t.idt = v.idt_tipo_voucher';
    $sql .= ' where v.idt = ' . null($_POST['idt_evento_publicacao_voucher']);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        $tipo_voucher = 'V' . $rs->data[0]['codigo'];
    } else {
        $tipo_voucher = 'VX';
    }

    $idt_evento_publicacao = $_GET['idt0'];

    if ($_GET['id'] == 0) {
        $sql = '';
        $sql .= ' select v.idt, v.descricao';
        $sql .= ' from grc_evento_publicacao_voucher v';
        $sql .= ' inner join grc_evento_tipo_voucher t on t.idt = v.idt_tipo_voucher';
        $sql .= ' where v.idt_evento_publicacao = ' . null($idt_evento_publicacao);
        $sql .= " and t.codigo = 'B'";
        $sql .= ' order by v.descricao';
        $vetCampo[$CampoPricPai] = objCmbBanco($CampoPricPai, $EntidadePai, true, $sql);
    } else {
        $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao');
    }
} else {
    $sql = '';
    $sql .= ' select t.codigo, v.idt_evento_publicacao';
    $sql .= ' from grc_evento_publicacao_voucher v';
    $sql .= ' inner join grc_evento_tipo_voucher t on t.idt = v.idt_tipo_voucher';
    $sql .= ' where v.idt = ' . null($_GET['idt0']);
    $rs = execsql($sql);
    $tipo_voucher = 'V' . $rs->data[0]['codigo'];
    $idt_evento_publicacao = $rs->data[0]['idt_evento_publicacao'];

    $vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
}

$vetCampo['idt_evento_publicacao'] = objHidden('idt_evento_publicacao', $idt_evento_publicacao);

$vetCampo['numero'] = objAutoNum('numero', 'Número', 14, true, 12, $tipo_voucher);
$vetCampo['cpf'] = objCPF('cpf', 'CPF', true);
$vetCampo['nome_pessoa'] = objTexto('nome_pessoa', 'Nome Completo', true, 120);
$vetCampo['dt_utilizacao'] = objTextoFixo('dt_utilizacao', 'Dt. Utilização', 16, true);

MesclarCol($vetCampo[$CampoPricPai], 3);
MesclarCol($vetCampo['cpf'], 3);
MesclarCol($vetCampo['nome_pessoa'], 3);
MesclarCol($vetCampo['idt_evento_publicacao'], 3);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['numero'], '', $vetCampo['dt_utilizacao']),
    Array($vetCampo['cpf']),
    Array($vetCampo['nome_pessoa']),
    Array($vetCampo['idt_evento_publicacao']),
        ));

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cpf').change(function () {
            if ($(this).val() != '') {
                $('#btBuscaCPF').click();
            }
        });

        var btAcaoCPF = $('<img border="0" id="btBuscaCPF" style="margin-left: 3px; cursor: pointer; vertical-align: middle;" src="imagens/bt_pesquisa.png" title="Pesquisar">');

        btAcaoCPF.click(function () {
            if ($('#cpf').val() == '') {
                alert('Favor informar o CPF!');
                $('#cpf').val('');
                $('#cpf').focus();
                return false;
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=BuscaCPF_Nome',
                data: {
                    cas: conteudo_abrir_sistema,
                    cpf: $('#cpf').val()
                },
                success: function (response) {
                    $('#nome_pessoa').val(url_decode(response.nome_pessoa));

                    if ($('#nome_pessoa').val() == '') {
                        $('#nome_pessoa').removeProp("disabled").removeClass("campo_disabled");
                    } else {
                        $("#nome_pessoa").prop("disabled", true).addClass("campo_disabled");
                    }

                    if (response.erro != '') {
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

        $('#cpf_obj').attr('nowrap', 'nowrap').append(btAcaoCPF);
    });
</script>