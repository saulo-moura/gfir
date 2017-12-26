<?php
acesso($menu, '', true);
onLoadPag();
?>
<script type="text/javascript">
    $(document).ready(function () {
        if (confirm('Confirma o inicio da sincronização com o SiacWeb?')) {
            processando();

            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=sincroniza_siac',
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
