<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "');";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_combo, null, returnVal);</script>';
}

$tabela = 'grc_evento_combo';
$id = 'idt';
$onSubmitDep = 'grc_evento_combo_dep()';

$sql = '';
$sql .= ' select *';
$sql .= ' from grc_evento_combo';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$rowDados = $rs->data[0];

$vetCampo['idt_evento_origem'] = objHidden('idt_evento_origem', $_GET['idt0']);
$vetCampo['idt_evento'] = objListarCmb('idt_evento', 'grc_evento_combo_ass', 'Evento', true, '860px');
$vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', True, $vetSitEventoComboAss, ' ', '', '', '', 'CD');
$vetCampo['qtd_vaga'] = objInteiro('qtd_vaga', 'Qtde. Vagas', true, 10);
$vetCampo['qtd_utilizada'] = objTextoFixo('qtd_utilizada', 'Qtd. Utilizada', 10, false, false, $rowDados['qtd_utilizada']);
$vetCampo['vl_evento'] = objTextoFixo('vl_evento', 'Valor Inscrição no Evento', 10, true);
$vetCampo['vl_matricula'] = objTextoFixo('vl_matricula', 'Valor Inscrição no Combo', 10, true);

$sql = '';
$sql .= ' select (quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra) - (qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas) as qtd_disponivel';
$sql .= ' from grc_evento';
$sql .= ' where idt = ' . null($rowDados['idt_evento']);
$rs = execsql($sql);
$qtd_disponivel = $rs->data[0][0] + $rowDados['qtd_vaga'];

$vetCampo['qtd_disponivel'] = objTextoFixo('qtd_disponivel', 'Qtd. Disponível no Evento', 10, false, false, $qtd_disponivel);

if ($rowDados['situacao'] == 'AP') {
    $vetCampo['idt_evento']['mostra_bt'] = false;
    $vetCampo['matricula_obr'] = objFixoVetor('matricula_obr', 'Evento Obrigatório?', True, $vetSimNao);
    $vetCampo['perc_desconto'] = objTextoFixo('perc_desconto', 'Desconto na Inscrição (%)', 10, true, true);
} else {
    if ($_GET['combo_tipo'] == 'F') {
        $vetCampo['matricula_obr'] = objFixoVetor('matricula_obr', 'Evento Obrigatório?', True, $vetSimNao, ' ', '', '', '', 'S');
    } else {
        $vetCampo['matricula_obr'] = objCmbVetor('matricula_obr', 'Evento Obrigatório?', True, $vetSimNao);
    }

    $vetCampo['perc_desconto'] = objDecimal('perc_desconto', 'Desconto na Inscrição (%)', true, 6, 6, 2, '', '0,00');
}

$vetFrm = Array();

MesclarCol($vetCampo['idt_evento_origem'], 11);
MesclarCol($vetCampo['qtd_disponivel'], 9);
MesclarCol($vetCampo['idt_evento'], 11);

$vetFrm[] = Frame('', Array(
    Array($vetCampo['idt_evento_origem']),
    Array($vetCampo['situacao'], '', $vetCampo['qtd_disponivel']),
    Array($vetCampo['idt_evento']),
    Array($vetCampo['matricula_obr'], '', $vetCampo['qtd_vaga'], '', $vetCampo['qtd_utilizada'], '', $vetCampo['perc_desconto'], '', $vetCampo['vl_evento'], '', $vetCampo['vl_matricula']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCad[] = $vetFrm;
?>
<style type="text/css">
    #situacao_tf {
        display: inline-block;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('#perc_desconto').change(function () {
            var vl_matricula = 0;
            var vl_evento = str2float($('#vl_evento').val());
            var perc_desconto = str2float($('#perc_desconto').val());

            if (isNaN(vl_evento)) {
                vl_evento = 0;
            }

            if (isNaN(perc_desconto)) {
                perc_desconto = 0;
            }

            vl_matricula = float2str(vl_evento - (vl_evento * perc_desconto / 100));

            $('#vl_matricula').val(vl_matricula);
            $('#vl_matricula_fix').html(vl_matricula);
        });

    });

    function parListarCmb_idt_evento() {
        var par = '';

        par += '&par_idt_evento_origem=<?php echo $_GET['idt0']; ?>';
        par += '&par_idt_evento=' + $('#idt_evento').val();

        return par;
    }

    function fncListarCmbMuda_idt_evento(idt_evento) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_evento_combo_dados',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento
            },
            success: function (response) {
                $('#vl_evento').val(url_decode(response.vl_evento));
                $('#vl_evento_fix').html(url_decode(response.vl_evento));
                $('#qtd_disponivel').val(url_decode(response.qtd_disponivel));
                $('#qtd_disponivel_fix').html(url_decode(response.qtd_disponivel));
                $('#perc_desconto').change();

                if (response.erro != '') {
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();
    }

    function grc_evento_combo_dep() {
        var erro = '';

        var qtd_vaga = str2float($('#qtd_vaga').val());
        var qtd_utilizada = str2float($('#qtd_utilizada').val());

        if (isNaN(qtd_vaga)) {
            qtd_vaga = 0;
        }

        if (isNaN(qtd_utilizada)) {
            qtd_utilizada = 0;
        }

        if (qtd_vaga + qtd_utilizada <= 0) {
            alert('A Qtde. Vagas mais a Qtd. Utilizada tem que ser maior que ZERO!');
            $('#qtd_vaga').focus();
            return false;
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_evento_combo_dep',
            data: {
                cas: conteudo_abrir_sistema,
                idt: '<?php echo $_GET['id']; ?>',
                idt_evento: $('#idt_evento').val(),
                qtd_vaga: $('#qtd_vaga').val()
            },
            success: function (response) {
                if (response.erro != '') {
                    erro += url_decode(response.erro);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#dialog-processando').remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();

        if (erro != '') {
            alert(erro);
            return false;
        }

        return true;
    }
</script>