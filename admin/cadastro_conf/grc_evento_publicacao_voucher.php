<?php
if ($_GET['idCad'] != '') {
    $_GET['idt0'] = $_GET['idCad'];
    $botao_volta = "parent.btFechaCTC('" . $_GET['session_cod'] . "', parent.funcaoFechaCTC_grc_evento_publicacao_voucher, parent.funcaoFechaCTC_grc_evento_publicacao_voucher_ant(" . $_GET['id'] . "));";
    $botao_acao = '<script type="text/javascript">parent.btFechaCTC("' . $_GET['session_cod'] . '", parent.funcaoFechaCTC_grc_evento_publicacao_voucher);</script>';
}

$TabelaPai = "grc_evento_publicacao";
$AliasPai = "grc_ep";
$EntidadePai = "Política de Desconto do Evento";
$idPai = "idt";

$TabelaPrinc = "grc_evento_publicacao_voucher";
$AliasPric = "grc_epc";
$Entidade = "Voucher do Evento";
$Entidade_p = "Voucher do Evento";
$CampoPricPai = "idt_evento_publicacao";

$tabela = $TabelaPrinc;
$id = 'idt';
$onSubmitDep = 'grc_evento_publicacao_voucher_dep()';

$vetFrm = Array();

$vetCampo[$CampoPricPai] = objFixoBanco($CampoPricPai, $EntidadePai, $TabelaPai, 'idt', 'descricao', 0);
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', true, 45, 45);
$vetCampo['data_validade'] = objData('data_validade', 'Data Validade Voucher', false, '', '', 'S');
$vetCampo['perc_desconto'] = objDecimal('perc_desconto', '% Desconto', true, 6);
$vetCampo['qtd_prazo'] = objInteiro('qtd_prazo', 'Prazo para a Validade (Dias Úteis)', false, 2);
$vetCampo['perc_desconto_indicador'] = objDecimal('perc_desconto_indicador', '% Desconto do Indicador', true, 6);
$vetCampo['qtd_prazo_indicador'] = objInteiro('qtd_prazo_indicador', 'Prazo para a Validade do Indicador (Dias Úteis)', false, 2);

if ($_GET['id'] == 0) {
    $sql = '';
    $sql .= ' select idt, codigo, descricao';
    $sql .= ' from grc_evento_tipo_voucher';
    $sql .= " where codigo in ('A', 'B', 'E')";
    $sql .= ' order by codigo, descricao';
    $vetCampo['idt_tipo_voucher'] = objCmbBanco('idt_tipo_voucher', 'Tipo de Voucher', true, $sql, ' ', 'width:560px;');

    $tipoVoucher = '';
} else {
    $vetCampo['idt_tipo_voucher'] = objFixoBanco('idt_tipo_voucher', 'Tipo de Voucher', 'grc_evento_tipo_voucher', 'idt', 'codigo, descricao');

    $sql = '';
    $sql .= ' select t.codigo';
    $sql .= ' from grc_evento_publicacao_voucher v';
    $sql .= ' inner join grc_evento_tipo_voucher t on t.idt = v.idt_tipo_voucher';
    $sql .= ' where v.idt = ' . null($_GET['id']);
    $rs = execsql($sql);
    $tipoVoucher = $rs->data[0][0];
}

if ($tipoVoucher == 'B') {
    $vetCampo['quantidade'] = objHidden('quantidade', '');
} else {
    $vetCampo['quantidade'] = objInteiro('quantidade', 'Quantidade', true, 9);
}

$tmp = $vetTipoVoucherCodIDT;
unset($tmp['E']);
$tmp = implode(',', $tmp);

$par = 'data_validade,quantidade';
$vetDesativa['idt_tipo_voucher'][0] = vetDesativa($par, ',' . $vetTipoVoucherCodIDT['E']);
$vetAtivadoObr['idt_tipo_voucher'][0] = vetAtivadoObr($par, $tmp);

$par = 'qtd_prazo,perc_desconto_indicador,qtd_prazo_indicador';
$vetDesativa['idt_tipo_voucher'][1] = vetDesativa($par, ',' . $tmp);
$vetAtivadoObr['idt_tipo_voucher'][1] = vetAtivadoObr($par, $vetTipoVoucherCodIDT['E']);

MesclarCol($vetCampo[$CampoPricPai], 11);
MesclarCol($vetCampo['descricao'], 5);
MesclarCol($vetCampo['idt_tipo_voucher'], 5);

$vetFrm[] = Frame('', Array(
    Array($vetCampo[$CampoPricPai]),
    Array($vetCampo['descricao'], '', $vetCampo['idt_tipo_voucher']),
    Array($vetCampo['quantidade'], '', $vetCampo['data_validade'], '', $vetCampo['perc_desconto'], '', $vetCampo['perc_desconto_indicador'], '', $vetCampo['qtd_prazo'], '', $vetCampo['qtd_prazo_indicador']),
        ));

if ($tipoVoucher == 'B') {
    $vetCampoFC = Array();
    $vetCampoFC['numero'] = CriaVetTabela('Número');
    $vetCampoFC['pessoa'] = CriaVetTabela('NOME DO CLIENTE / CPF');
    $vetCampoFC['dt_utilizacao'] = CriaVetTabela('Dt. Utilização', 'data');

    $titulo = 'Registro do Voucher';
    $TabelaPrinc = "grc_evento_publicacao_voucher_registro";
    $AliasPric = "grc_epc";
    $orderby = "{$AliasPric}.numero";

    $sql = "select {$AliasPric}.*, ";
    $sql .= " concat_ws('<br />', {$AliasPric}.nome_pessoa, {$AliasPric}.cpf) as pessoa";
    $sql .= " from {$TabelaPrinc} {$AliasPric} ";
    $sql .= " where {$AliasPric}" . '.idt_evento_publicacao_voucher = $vlID';
    $sql .= " order by {$orderby}";

    $vetParametrosLC = Array(
        'func_trata_row' => trata_row_grc_evento_publicacao_voucher_registro,
        'barra_icone' => true,
        'barra_inc_ap' => false,
        'barra_exc_ap' => false,
    );

    $vetCampo['grc_evento_publicacao_voucher_registro'] = objListarConf('grc_evento_publicacao_voucher_registro', 'idt', $vetCampoFC, $sql, $titulo, true, $vetParametrosLC);

    $vetParametros = Array(
        'width' => '880px',
    );

    $vetFrm[] = Frame('Lista de Voucher', Array(
        Array($vetCampo['grc_evento_publicacao_voucher_registro']),
            ), '', '', true, $vetParametros);
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    function grc_evento_publicacao_voucher_dep() {
        if (valida == 'S') {
            var data_publicacao_de = '<?php echo $_GET['data_publicacao_de'] ?>';
            var data_publicacao_ate = '<?php echo $_GET['data_publicacao_ate'] ?>';
            var data_hora_fim_inscricao_ec = '<?php echo $_GET['data_hora_fim_inscricao_ec'] ?>';

            if (data_publicacao_de != '') {
                if (validaDataMaiorStr(false, $('#data_validade'), 'Data Validade Voucher', data_publicacao_de, 'Publicar De') === false) {
                    return false;
                }
            }

            if (data_publicacao_ate != '') {
                if (validaDataMenorStr(false, $('#data_validade'), 'Data Validade Voucher', data_publicacao_ate, 'Publicar Até') === false) {
                    return false;
                }
            }

            if (data_hora_fim_inscricao_ec != '') {
                if (validaDataMenorStr(false, $('#data_validade'), 'Data Validade Voucher', data_hora_fim_inscricao_ec, 'Data Fim inscrição loja Virtual') === false) {
                    return false;
                }
            }

            if ($('#perc_desconto').val() != '') {
                var idtTipoE = '<?php echo $vetTipoVoucherCodIDT['E']; ?>';
                var limite_desconto = str2float(vetConf.evento_publicacao_limite_voucher_e);
                var perc_desconto = str2float($('#perc_desconto').val());

                if (isNaN(limite_desconto) || $('#idt_tipo_voucher').val() != idtTipoE) {
                    limite_desconto = 100;
                }

                if (perc_desconto > limite_desconto) {
                    alert('O Desconto não pode ser maior que o limite do sistema (' + float2str(limite_desconto) + '%)!');
                    $('#perc_desconto').val('');
                    $('#perc_desconto').focus();
                    return false;
                }
            }

            if ($('#perc_desconto_indicador').val() != '') {
                var idtTipoE = '<?php echo $vetTipoVoucherCodIDT['E']; ?>';
                var limite_desconto = str2float(vetConf.evento_publicacao_limite_voucher_e);
                var perc_desconto = str2float($('#perc_desconto_indicador').val());

                if (isNaN(limite_desconto) || $('#idt_tipo_voucher').val() != idtTipoE) {
                    limite_desconto = 100;
                }

                if (perc_desconto > limite_desconto) {
                    alert('O Desconto do Indicador não pode ser maior que o limite do sistema (' + float2str(limite_desconto) + '%)!');
                    $('#perc_desconto_indicador').val('');
                    $('#perc_desconto_indicador').focus();
                    return false;
                }
            }

            var erro = '';
            var quantidade = '';

            if ($('#quantidade').length == 1) {
                quantidade = $('#quantidade').val();
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_publicacao_voucher_dep',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_tipo_voucher: $('#idt_tipo_voucher').val(),
                    quantidade: quantidade,
                    idt_evento_publicacao: $('#idt_evento_publicacao').val(),
                    idt: $('#id').val()
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
        }

        return true;
    }

    function func_AtivaDesativa_idt_tipo_voucher(idx_regra) {
        if ($('#data_validade').prop("disabled")) {
            $('#data_validade_desc, #data_validade_obj').hide();
            $('#quantidade_desc, #quantidade_obj').hide();
        } else {
            $('#data_validade_desc, #data_validade_obj').show();
            $('#quantidade_desc, #quantidade_obj').show();
        }

        if ($('#qtd_prazo').prop("disabled")) {
            $('#qtd_prazo_desc, #qtd_prazo_obj').hide();
            $('#qtd_prazo_indicador_desc, #qtd_prazo_indicador_obj').hide();
            $('#perc_desconto_indicador_desc, #perc_desconto_indicador_obj').hide();
        } else {
            $('#qtd_prazo_desc, #qtd_prazo_obj').show();
            $('#qtd_prazo_indicador_desc, #qtd_prazo_indicador_obj').show();
            $('#perc_desconto_indicador_desc, #perc_desconto_indicador_obj').show();
        }

        if (acao == 'inc') {
            if ('<?php echo $vetTipoVoucherCodIDT['B']; ?>' == $('#idt_tipo_voucher').val().toString()) {
                $(':submit').val('Continua');
            } else {
                $(':submit').val('Salvar');
            }
        }
    }
</script>