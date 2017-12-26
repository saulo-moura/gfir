<?php
acesso($menu, '', true);
onLoadPag();
?>
<script type="text/javascript">
    $(document).ready(function () {
        if (confirm('Confirma a sincronização com SGE?')) {
            processando();

            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=executa_job_sge',
                data: {
                    cas: conteudo_abrir_sistema
                },
                success: function (response) {
                    $("#dialog-processando").remove();
                    alert(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        }

        $("#dialog-processando").remove();

        self.location = '<?php echo trata_aspa($_SESSION[CS]['painel_url_volta'][$_GET['cod_volta']]); ?>';

    });
</script>
