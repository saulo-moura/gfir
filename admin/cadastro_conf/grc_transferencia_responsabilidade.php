<style type="text/css">
    #idt_colaborador_origem {
        width: 743px;
    }

    Tr.Registro:nth-child(even) {
        background-color: #f2f2f2;
        cursor:default;
    }

    Tr.Registro:nth-child(odd) {
        background-color: #ffffff;
        cursor:default;
    }

    Tr.Registro:hover {
        background-color: #ff8080;
        cursor:default;
    }
</style>
<?php
$tabela = 'grc_transferencia_responsabilidade';
$id = 'idt';

if ($_GET['id'] == 0) {
    $onSubmitDep = 'grc_transferencia_responsabilidade_inc_dep()';
} else {
    $onSubmitDep = 'grc_transferencia_responsabilidade_alt_dep()';
}

$bt_salvar_lbl = 'Enviar para Aprovação';

if ($_GET['voltar'] == 'pendencia_home') {
    $botao_acao = '<script type="text/javascript">self.location = "conteudo.php";</script>';
    $botao_volta = "self.location = 'conteudo.php';";
} else if ($_GET['voltar'] == 'pendencia_listar') {
    $botao_acao = '<script type="text/javascript">self.location = "'.$_SESSION[CS]['pendencia_listar'].'";</script>';
    $botao_volta = "self.location = '".$_SESSION[CS]['pendencia_listar']."';";
}

if ($_GET['id'] == 0) {
    $_GET['id_usuario99'] = $_SESSION[CS]['g_id_usuario'];

    $row = Array(
        'idt_colaborador_destino' => $_SESSION[CS]['g_id_usuario'],
        'idt_unidade_lotacao' => $_SESSION[CS]['g_idt_unidade_lotacao'],
    );
} else {
    $sql = '';
    $sql .= ' select r.situacao, r.idt_colaborador_origem, r.idt_colaborador_destino, u.idt_unidade_lotacao';
    $sql .= ' from grc_transferencia_responsabilidade r';
    $sql .= ' inner join plu_usuario u on u.id_usuario = r.idt_colaborador_destino';
    $sql .= ' where r.idt = '.null($_GET['id']);
    $rs = execsql($sql);
    $row = $rs->data[0];
}

if ($rs->rows == 0) {
    unset($_GET['idt_pendencia']);
}

if ($_GET['idt_pendencia'] != '') {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_atendimento_pendencia';
    $sql .= ' where idt = '.null($_GET['idt_pendencia']);
    $sql .= ' and idt_responsavel_solucao = '.null($_SESSION[CS]['g_id_usuario']);
    $sql .= " and ativo = 'S'";
    $sql .= " and (tipo = 'Transferência de Responsabilidades')";
    $sql .= whereAtendimentoPendencia();
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        unset($_GET['idt_pendencia']);
    }
}

if ($_GET['id'] > 0) {
    if ($_GET['idt_pendencia'] == '') {
        $acao = 'con';
        $_GET['acao'] = $acao;
    } else {
        $acao_alt_con = 'S';
    }
}

$vetCampo['tipo'] = objHidden('tipo', 'T');
$vetCampo['descricao'] = objTexto('descricao', 'Descrição', True, 120);
$vetCampo['dt_inicio'] = objHidden('dt_inicio', getdata(false, true));
$vetCampo['dt_validade'] = objData('dt_validade', 'Validade da Transferência', true);

if ($_GET['id'] == 0) {
    $vetCampo['situacao'] = objHidden('situacao', 'GC');
} else {
    $vetCampo['situacao'] = objFixoVetor('situacao', 'Situação', true, $vetSitTransResp);
}

$vetCampo['justificativa'] = objTextArea('justificativa', 'Justificativa', false, 2000);
$vetCampo['evidencia'] = objFile('evidencia', 'Evidência', false, 255, 'pdf');

$sql = '';
$sql .= ' select id_usuario, nome_completo';
$sql .= ' from plu_usuario';
$sql .= ' where (idt_unidade_lotacao = '.null($row['idt_unidade_lotacao']);
$sql .= ' and id_usuario <> '.null($row['idt_colaborador_destino']);
$sql .= ' ) or id_usuario = '.null($row['idt_colaborador_origem']);
$sql .= ' order by nome_completo';
$vetCampo['idt_colaborador_origem'] = objCmbBanco('idt_colaborador_origem', 'Colaborador Origem', true, $sql);

$vetCampo['idt_colaborador_destino'] = objFixoBanco('idt_colaborador_destino', 'Colaborador Destino', 'plu_usuario', 'id_usuario', 'nome_completo', 99);

$vetCampo['chk_evento'] = objCheckbox('chk_evento', 'Responsabilidades', 'S', 'N', 'Fluxo de Aprovação de Eventos', true, 'N');
$vetCampo['chk_pag_cred'] = objCheckbox('chk_pag_cred', '', 'S', 'N', 'Processo de Pagamento de Credenciado', true, 'N');
$vetCampo['chk_atend'] = objCheckbox('chk_atend', '', 'S', 'N', 'Respostas Técnicas do Atendimento', true, 'N');

MesclarCol($vetCampo['tipo'], 3);
MesclarCol($vetCampo['descricao'], 5);
MesclarCol($vetCampo['dt_validade'], 3);
MesclarCol($vetCampo['idt_colaborador_origem'], 5);
MesclarCol($vetCampo['idt_colaborador_destino'], 5);
MesclarCol($vetCampo['justificativa'], 5);
MesclarCol($vetCampo['evidencia'], 5);

$vetFrm = Array();

$vetFrm[] = Frame('<span>Identificação</span>', Array(
    Array($vetCampo['tipo'], '', $vetCampo['dt_inicio']),
    Array($vetCampo['descricao']),
    Array($vetCampo['dt_validade'], '', $vetCampo['situacao']),
    Array($vetCampo['idt_colaborador_origem']),
    Array($vetCampo['idt_colaborador_destino']),
    Array($vetCampo['justificativa']),
    Array($vetCampo['evidencia']),
    Array($vetCampo['chk_evento'], '', $vetCampo['chk_pag_cred'], '', $vetCampo['chk_atend']),
        ), $class_frame, $class_titulo, $titulo_na_linha);

$vetCampo['listagem_pendencia'] = objHidden('listagem_pendencia', '', '', '', false);

$vetParametros = Array(
    'width' => '95%',
);

$vetFrm[] = Frame('<span>Pendências Abertas</span>', Array(
    Array($vetCampo['listagem_pendencia']),
        ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

if ($_GET['idt_pendencia'] != '') {
    $vetCampo['justificativa_reprovacao'] = objTextArea('justificativa_reprovacao', 'Justificativa da Aprovação / Reprovação', false, 2000);

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['justificativa_reprovacao']),
            ), $class_frame, $class_titulo, $titulo_na_linha, $vetParametros);

    $vetCampo['grc_transferencia_responsabilidade_bt'] = objInclude('grc_transferencia_responsabilidade_bt', 'cadastro_conf/grc_transferencia_responsabilidade_bt.php');

    $vetFrm[] = Frame('', Array(
        Array($vetCampo['grc_transferencia_responsabilidade_bt']),
            ), '', $class_titulo, $titulo_na_linha, $vetParametros);
}

$vetCad[] = $vetFrm;
?>
<script type="text/javascript">
    var situacao = '<?php echo $row['situacao']; ?>';
    var situacaoPadrao = '<?php echo $row['situacao']; ?>';

    $(document).ready(function () {
        if ('<?php echo $_GET['id']; ?>' == '0') {
            $('#idt_colaborador_origem, #chk_evento, #chk_pag_cred, #chk_atend').change(function () {
                $('#listagem_pendencia_obj').html('');

                var chk_evento = 'N';
                var chk_pag_cred = 'N';
                var chk_atend = 'N';

                if ($('#chk_evento').prop('checked')) {
                    chk_evento = 'S';
                }

                if ($('#chk_pag_cred').prop('checked')) {
                    chk_pag_cred = 'S';
                }

                if ($('#chk_atend').prop('checked')) {
                    chk_atend = 'S';
                }

                if ($('#idt_colaborador_origem').val() != '' && (chk_evento == 'S' || chk_pag_cred == 'S' || chk_atend == 'S')) {
                    processando();

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: ajax_sistema + '?tipo=grc_transferencia_responsabilidade_listagem',
                        data: {
                            cas: conteudo_abrir_sistema,
                            idt_colaborador_origem: $('#idt_colaborador_origem').val(),
                            chk_evento: chk_evento,
                            chk_pag_cred: chk_pag_cred,
                            chk_atend: chk_atend
                        },
                        success: function (response) {
                            if (response.erro == '') {
                                $('#listagem_pendencia_obj').html(url_decode(response.html));
                            } else {
                                $("#dialog-processando").remove();
                                alert(url_decode(response.erro));
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#dialog-processando").remove();
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });

                    TelaHeight();
                    $("#dialog-processando").remove();
                }
            });

            $('#listagem_pendencia_obj').on('change', '#chkTodos', function () {
                $('tr.Registro :checkbox').prop('checked', $('#chkTodos').prop('checked')).change();
            });

            $('#listagem_pendencia_obj').on('change', 'input[data-id ^= "chk_tela"]', function () {
                var vl = 'N';

                if ($(this).prop('checked')) {
                    vl = 'S';
                }

                $('#' + $(this).data('id')).val(vl);
            });
        } else {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_transferencia_responsabilidade_banco',
                data: {
                    cas: conteudo_abrir_sistema,
                    id: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    if (response.erro == '') {
                        $('#listagem_pendencia_obj').html(url_decode(response.html));
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            TelaHeight();
            $("#dialog-processando").remove();
        }
    });

    function grc_transferencia_responsabilidade_inc_dep() {
        var ok = false;

        if (validaDataMaior(false, $('#dt_validade'), 'Validade da Transferência', $('#dtBancoObj'), 'Hoje', false) === false) {
            $('#dt_validade').focus();
            return false;
        }

        if (!($('#chk_evento').prop('checked') || $('#chk_pag_cred').prop('checked') || $('#chk_atend').prop('checked'))) {
            alert('Favor informar alguma Responsabilidades!');
            return false;
        }

        if ($("input:checked[data-id]").length == 0) {
            alert('Favor informar alguma Pendências Abertas!');
            return false;
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=grc_transferencia_responsabilidade_valida',
            data: {
                cas: conteudo_abrir_sistema,
                id: $('#idt_colaborador_destino').val()
            },
            success: function (response) {
                if (response.erro == '') {
                    ok = true;
                } else {
                    $("#dialog-processando").remove();
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

        return ok;
    }

    function grc_transferencia_responsabilidade_alt_dep() {
        $('#situacao').val(situacao);
        return true;
    }
</script>