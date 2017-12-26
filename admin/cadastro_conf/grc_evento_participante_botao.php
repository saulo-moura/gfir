<style>
    .botao_ag_b2 {
        text-align:center;
        width:200px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag_b2:hover {
        background:#0000FF;
    }

    .barra_final {
        text-align:center;
    }

    .btCopiarAgenda {
        width: auto;
        margin-left: 20px;
        margin-bottom: 10px;
    }
</style>
<?php
if ($veio == '') {
    $veio = $_GET['veio'];
}

if ($veio == 'SG' && $sgtec_modelo == 'E') {
    $vetLbl = Array(
        'bt_insc_salvar' => 'Salvar Registro',
        'bt_insc_print_rascunho' => '',
        'bt_insc_ass' => 'Gerar Termo de Adesão',
        'bt_insc_voltar_rascunho' => 'Cancelar Termo de Adesão',
        'bt_insc_print_contrato' => 'Imprimir Termo de Adesão',
        'bt_insc_concluido' => 'Concluir Venda',
        'bt_insc_canc_contrato' => 'Cancelar Termo de Adesão',
    );
} else {
    $vetLbl = Array(
        'bt_insc_salvar' => 'Salvar Inscrição',
        'bt_insc_print_rascunho' => 'Rascunho do Contrato',
        'bt_insc_ass' => 'Contrato para Assinatura',
        'bt_insc_voltar_rascunho' => 'Voltar para Rascunho',
        'bt_insc_print_contrato' => 'Imprimir Contrato',
        'bt_insc_concluido' => 'Contrato Concluido',
        'bt_insc_canc_contrato' => 'Cancelar Contrato',
    );
}

echo " <div class='barra_final' >";

$msgVoltar = 'N';

if ($acao == 'inc' || $acao == 'alt') {
    $tmp = $situacao_contrato;

    if ($tmp == 'R' && $veio == 'SG' && $sgtec_modelo == 'E' && $vl_determinado == 'N' && $idt_evento_situacao < 8) {
        $tmp = 'G';
    }

    switch ($tmp) {
        case 'G':
            $msgVoltar = 'S';

            echo " <div class='botao_ag_b2'id='bt_insc_salvar'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_salvar'] . "</div>";
            echo " </div>";
            break;

        case 'FE':
            $msgVoltar = 'S';

            echo " <div class='botao_ag_b2'id='bt_insc_salvar'>";
            echo " <div style='margin:8px; '>Salvar Reserva</div>";
            echo " </div>";
            break;

        case 'R':
            $msgVoltar = 'S';

            echo " <div class='botao_ag_b2'id='bt_insc_salvar'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_salvar'] . "</div>";
            echo " </div>";

            if ($vetLbl['bt_insc_print_rascunho'] != '') {
                echo " <div class='botao_ag_b2' id='bt_insc_print_rascunho'>";
                echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_print_rascunho'] . "</div>";
                echo " </div>";
            }

            echo " <div class='botao_ag_b2' id='bt_insc_ass'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_ass'] . "</div>";
            echo " </div>";
            break;

        case 'A':
            echo " <div class='botao_ag_b2' id='bt_insc_voltar_rascunho'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_voltar_rascunho'] . "</div>";
            echo " </div>";

            echo " <div class='botao_ag_b2' id='bt_insc_print_contrato'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_print_contrato'] . "</div>";
            echo " </div>";

            echo " <div class='botao_ag_b2' id='bt_insc_concluido'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_concluido'] . "</div>";
            echo " </div>";
            break;

        case 'C':
            echo " <div class='botao_ag_b2' id='bt_insc_canc_contrato'>";
            echo " <div style='margin:8px; '>" . $vetLbl['bt_insc_canc_contrato'] . "</div>";
            echo " </div>";
            break;
    }
} else if ($acao == 'exc') {
    if ($veio == 'SG') {
        if ($idt_evento_situacao == 1 || $idt_evento_situacao == 5) {
            echo " <div class='botao_ag_b2'id='bt_insc_excluir'>";
            echo " <div style='margin:8px; '>Excluir Inscrição</div>";
            echo " </div>";
        } else {
            alert('Só pode Excluir uma inscrição antes da Aprovação do evento!');
        }
    } else if ($situacao_contrato == 'R' || $situacao_contrato == 'G') {
        echo " <div class='botao_ag_b2'id='bt_insc_cancelar'>";
        echo " <div style='margin:8px; '>Cancelar Inscrição</div>";
        echo " </div>";
    } else if ($situacao_contrato == 'FE') {
        echo " <div class='botao_ag_b2'id='bt_insc_excluir'>";
        echo " <div style='margin:8px; '>Excluir Inscrição</div>";
        echo " </div>";
    } else {
        alert('Só pode Cancelar uma inscrição se estiver na situação ' . $vetEventoContrato['R'] . '!');
    }
}

echo " <div class='botao_ag_b2' id='bt_insc_voltar'>";
echo " <div style='margin:8px; '>Voltar</div>";
echo " </div>";

echo " </div>";
?>
<script type="text/javascript">
    $(document).ready(function () {
        onSubmitCancelado = function () {
            $('#bt_acao_insc').val('');
            valida_cust = '';
            onSubmitMsgTxt = '';
        };

        $('#bt_insc_salvar').click(function () {
            $(':submit:first').click();
        });

        $('#bt_insc_cancelar').click(function () {
            /*
            if ($('#motivo_cancelamento_md5').val() == '') {
                alert('Favor informar o Motivo do Cancelamento!');
                $('#motivo_cancelamento_md5').focus();
                return false;
            }
            */

            $('#contrato').val('IC');
            $('#bt_acao_insc').val('inscricao_cancelada');
            onSubmitMsgTxt = 'A inscrição vai ser cancelada!\n\nConfirma?';
            $(':submit:first').click();
        });

        $('#bt_insc_excluir').click(function () {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=MatriculaEventoValidaExcluir',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_atendimento: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    $('#dialog-processando').remove();

                    if (response.erro == '') {
                        $('#bt_acao_insc').val('inscricao_excluir');
                        onSubmitMsgTxt = 'A inscrição vai ser excluida do sistema!\n\nConfirma?';
                        $(':submit:first').click();
                    } else {
                        alert(url_decode(response.erro));
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#dialog-processando').remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });

            $('#dialog-processando').remove();
        });

        $('#bt_insc_print_rascunho').click(function () {
            $('#bt_acao_insc').val('print_rascunho');
            onSubmitMsgTxt = false;
            $(':submit:first').click();
        });

        $('#bt_insc_ass').click(function () {
            var ok = true;

            /*
             if ('<?php echo $composto; ?>' == 'S') {
             processando();
             
             $.ajax({
             dataType: 'json',
             type: 'POST',
             url: ajax_sistema + '?tipo=MatriculaEventoCompostoValida',
             data: {
             cas: conteudo_abrir_sistema,
             idt_atendimento: '<?php echo $_GET['id']; ?>'
             },
             success: function (response) {
             if (response.erro != '') {
             ok = false;
             $('#dialog-processando').remove();
             alert(url_decode(response.erro));
             }
             },
             error: function (jqXHR, textStatus, errorThrown) {
             $('#dialog-processando').remove();
             alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
             },
             async: false
             });
             
             $('#dialog-processando').remove();
             }
             */

            if (ok) {
                $('#contrato').val('A');
                $('#bt_acao_insc').val('print_contrato');
                onSubmitMsgTxt = 'A inscrição vai ser concluida e gerado o contrato para assinatura!';
                $(':submit:first').click();
            }
        });

        $('#bt_insc_voltar_rascunho').click(function () {
            valida_cust = 'N';
            $('#contrato').val('R');
            $('#bt_acao_insc').val('voltar_rascunho');
            onSubmitMsgTxt = 'Deseja voltar o contrato para rascunho?';
            $(':submit:first').click();
        });

        $('#bt_insc_print_contrato').click(function () {
            listar_rel_pdf_url('<?php echo $_SESSION[CS]['grc_evento_participante_volta_cad']; ?>', "C");
        });

        $('#bt_insc_concluido').click(function () {
            $('#contrato').val('C');
            $('#bt_acao_insc').val('gerar_contrato');
            onSubmitMsgTxt = 'O contrato foi Assinado? Pois este cadastro será integrado com o SIACWEB.\n\nConfirma?';
            $(':submit:first').click();
        });

        $('#bt_insc_canc_contrato').click(function () {
            valida_cust = 'N';
            $('#contrato').val('R');
            $('#bt_acao_insc').val('cancelar_contrato');
            onSubmitMsgTxt = 'Deseja cancelar o contrato deste inscrição?!';
            $(':submit:first').click();
        });

        $('#bt_insc_voltar').click(function () {
            msgVoltar = '<?php echo $msgVoltar; ?>';
            $('#bt_voltar').click();
        });
    });
</script>