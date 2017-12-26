<style>
    .botao_ag_bl {
        text-align:center;
        min-width:130px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
        padding: 8px;
    }

    .botao_ag_bl:hover {
        background:#0000FF;
    }

    .barra_final {
        text-align:center;
    }
</style>
<?php
echo "<div class='barra_final'>";

echo "<div class='botao_ag_bl' onclick='btAlterarBloco();'>Alterar registro em bloco</div>";

echo "</div>";
?>
<script type="text/javascript">
    function btAlterarBloco() {
        if ($('#ab_ini').val() == '') {
            alert('Favor informar a Coordenada Inicial!');
            $('#ab_ini').focus();
            return false;
        }

        if ($('#ab_idt_tipo_assento').val() == '' && $('#ab_ativo').val() == '') {
            alert('Favor informar Tipo de Assento ou Ativo!');
            return false;
        }

        var patt1 = null;
        var patt2 = null;
        var erro = null;
        var txt = '';
        var padraoIni = '';
        var padraoFim = '';

        txt = $('#ab_ini').val().trim();

        if (txt != '') {
            patt1 = /^([a-zA-Z]{1,}[0-9]*)$/g;
            patt2 = /^([a-zA-Z]+)$/g;

            erro = !patt1.test(txt);

            if (erro) {
                padraoIni = 'Só Coluna';
                erro = isNaN(parseInt(txt * 1));
            } else if (patt2.test(txt)) {
                padraoIni = 'Só Linha';
            } else {
                padraoIni = 'Linha e Coluna';
            }

            if (erro) {
                alert('A Coordenada Inicial não esta válida!');
                $('#ab_ini').val('');
                $('#ab_ini').focus();
                return false;
            }
        }

        txt = $('#ab_fim').val().trim();

        if (txt != '') {
            patt1 = /^([a-zA-Z]{1,}[0-9]*)$/g;
            patt2 = /^([a-zA-Z]+)$/g;

            erro = !patt1.test(txt);

            if (erro) {
                padraoFim = 'Só Coluna';
                erro = isNaN(parseInt(txt * 1));
            } else if (patt2.test(txt)) {
                padraoFim = 'Só Linha';
            } else {
                padraoFim = 'Linha e Coluna';
            }

            if (erro) {
                alert('A Coordenada Final não esta válida!');
                $('#ab_fim').val('');
                $('#ab_fim').focus();
                return false;
            }

            if (padraoIni != padraoFim) {
                alert('O padrão da Coordenada Final não esta a mesma da Coordenada Inicial!\nCoordenada Inicial: ' + padraoIni + '\nCoordenada Final: ' + padraoFim);
                return false;
            }
        }

        if (confirm('Deseja alterar os registros?')) {
            processando();

            var padraoJS = '';

            switch (padraoIni) {
                case 'Só Coluna':
                    padraoJS = 'SC';
                    break;

                case 'Só Linha':
                    padraoJS = 'SL';
                    break;

                case 'Linha e Coluna':
                    padraoJS = 'LC';
                    break;
            }

            if (padraoJS == '') {
                alert('Favor informar um padrão de Coordenada valido!');
                return false;
            }

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=grc_evento_local_pa_mapa_btAlterarBloco',
                data: {
                    cas: conteudo_abrir_sistema,
                    padraoJS: padraoJS,
                    ab_ini: $('#ab_ini').val(),
                    ab_fim: $('#ab_fim').val(),
                    ab_idt_tipo_assento: $('#ab_idt_tipo_assento').val(),
                    ab_ativo: $('#ab_ativo').val(),
                    idt: '<?php echo $_GET['id']; ?>'
                },
                success: function (response) {
                    funcaoFechaCTC_grc_evento_local_pa_mapa_assento();

                    if (response.erro != '') {
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

            $('#ab_idt_tipo_assento').val('');
            $('#ab_ativo').val('');

            $('#dialog-processando').remove();
        }
    }
</script>