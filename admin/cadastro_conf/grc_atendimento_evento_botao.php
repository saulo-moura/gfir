<style>
    .botao_ag_b2 {
        text-align:center;
        min-width: 150px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
        padding: 10px;
    }

    .botao_ag_b2:hover {
        background:#0000FF;
    }

    .barra_final {
        text-align:center;
    }
</style>
<?php
echo "<div class='barra_final'>";

if ($acao == 'alt') {
    switch ($rowDados['bt_acao_cadastro']) {
        case 'bt_aprovacao':
            echo "<div class='botao_ag_b2'id='bt_print'>Imprimir Termo de Adesão</div>";
            echo "<div class='botao_ag_b2'id='bt_concluir'>Concluir Venda</div>";
            break;

        default:
            echo "<div class='botao_ag_b2'id='bt_salvar'>Salvar</div>";
            echo "<div class='botao_ag_b2'id='bt_aprovacao'>Gerar Termo de Adesão</div>";
            echo "<div class='botao_ag_b2'id='bt_backoffice_cotacao'>Enviar para Cotação</div>";
            echo "<div class='botao_ag_b2'id='bt_backoffice'>Enviar para Backoffice</div>";
            break;
    }
}

echo "<div class='botao_ag_b2'id='bt_voltar_per'>Voltar</div>";

echo "</div>";
?>
<script type="text/javascript">
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            $('#bt_acao_cadastro').val('<?php echo $rowDados['bt_acao_cadastro']; ?>');
        };

        $('#bt_salvar').click(function () {
            $(':submit:first').click();
        });

        $('#bt_print').click(function () {
            listar_rel_pdf_url('<?php echo 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING']; ?>', "C");
        });

        $('#bt_concluir').click(function () {
            $('#bt_acao_cadastro').val('bt_concluir');
            $(':submit:first').click();
        });

        $('#bt_aprovacao').click(function () {
            if (idt_unidade == '') {
                alert('Favor informar a Unidade/Escritório!');
                $('#idt_unidade').focus();
                return false;
            }

            if ($('#idt_gestor_evento').val() == '') {
                alert('Favor informar o Responsável pelo Evento!');
                $('#idt_gestor_evento').focus();
                return false;
            }

            if ($('#idt_produto').val() == '') {
                alert('Favor informar o Produto!');
                return false;
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_evento: -1,
                    idt_unidade: idt_unidade,
                    idt_gestor_evento: $('#idt_gestor_evento').val(),
                    idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                    idt_responsavel: '<?php echo $idt_responsavel; ?>',
                    idt_instrumento: $('#idt_instrumento').val(),
                    idt_produto: $('#idt_produto').val(),
                    idt_programa: '',
                    idt_ponto_atendimento_tela: '<?php echo idt_ponto_atendimento_tela; ?>',
                    previsao_despesa: $('#resumo_tot').html(),
                    dt_previsao_inicial: '',
                    situacao: 6
                },
                success: function (response) {
                    if (response.erro == '') {
                        $('#dialog-processando').remove();
                        $('#bt_acao_cadastro').val('bt_aprovacao');
                        onSubmitMsgTxt = 'Deseja criar e enviar para aprovação deste Evento?';
                        $(':submit:first').click();
                    } else {
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
        });

        $('#bt_backoffice_cotacao').click(function () {
            if (idt_unidade == '') {
                alert('Favor informar a Unidade/Escritório!');
                $('#idt_unidade').focus();
                return false;
            }

            if ($('#idt_gestor_evento').val() == '') {
                alert('Favor informar o Responsável pelo Evento!');
                $('#idt_gestor_evento').focus();
                return false;
            }

            if ($('#idt_produto').val() == '') {
                alert('Favor informar o Produto!');
                return false;
            }

            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_evento: -1,
                    idt_unidade: idt_unidade,
                    idt_gestor_evento: $('#idt_gestor_evento').val(),
                    idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                    idt_responsavel: '<?php echo $idt_responsavel; ?>',
                    idt_instrumento: $('#idt_instrumento').val(),
                    idt_produto: $('#idt_produto').val(),
                    idt_programa: '',
                    idt_ponto_atendimento_tela: '<?php echo idt_ponto_atendimento_tela; ?>',
                    previsao_despesa: $('#resumo_tot').html(),
                    dt_previsao_inicial: '',
                    situacao: 24
                },
                success: function (response) {
                    if (response.erro == '') {
                        $('#dialog-processando').remove();
                        $('#bt_acao_cadastro').val('bt_backoffice_cotacao');
                        onSubmitMsgTxt = 'Deseja criar e enviar para cotação este Evento?';
                        $(':submit:first').click();
                    } else {
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
        });

        $('#bt_backoffice').click(function () {
            $('#bt_acao_cadastro').val('bt_backoffice');
            onSubmitMsgTxt = 'Deseja criar e enviar para Backoffice deste Evento?';
            $(':submit:first').click();
        });

        $('#bt_voltar_per').click(function () {
            $('#bt_voltar').click();
        });
    });
</script>