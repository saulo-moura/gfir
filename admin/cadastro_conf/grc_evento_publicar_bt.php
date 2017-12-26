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
$id_usuarioSTR = $_SESSION[CS]['g_id_usuario'];
$id_usuarioSTR = (string) $id_usuarioSTR;

if ($_GET['idt_pendencia'] != '' && $rowDados['situacao'] == 'FR') {
    echo "<div class='barra_final'>";
    echo "<div class='botao_ag_bl' id='btFecharPen'>Fechar Pendência</div>";
    echo "</div>";
} else
if ($rowDados['idt_responsalvel'] == $id_usuarioSTR && $rowDados['situacao'] == 'AA') {
    echo "<div class='barra_final'>";
    echo "<div class='botao_ag_bl' id='btCancelarAprovacao'>Cancelar Aprovação</div>";
    echo "</div>";
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btFecharPen').click(function () {
            if (confirm('Deseja fechar esta Pendência?')) {
                processando();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_evento_publicar_fechar_pen',
                    data: {
                        cas: conteudo_abrir_sistema,
                        situacao: '<?php echo $rowDados['situacao']; ?>',
                        idt: '<?php echo $_GET['id']; ?>'
                    },
                    success: function (response) {
                        $('#dialog-processando').remove();
                        
                        if (response.erro == '') {
                            $('#btFecharPen').remove();
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
            }
        });

        $('#btCancelarAprovacao').click(function () {
            if (confirm('Deseja cancelar a Aprovação?')) {
                processando();
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_evento_publicar_fechar_pen',
                    data: {
                        cas: conteudo_abrir_sistema,
                        situacao: 'CA',
                        idt: '<?php echo $_GET['id']; ?>'
                    },
                    success: function (response) {
                        $('#dialog-processando').remove();
                        
                        if (response.erro == '') {
                            $('#bt_voltar').click();
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
            }
        });
    });
</script>