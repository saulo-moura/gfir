<script type="text/javascript">
    $(document).ready(function () {
        $("#bt_local_novo").click(function () {
            var url = 'conteudo_cadastro.php?acao=inc&externo=S&prefixo=cadastro&menu=grc_evento_local_pa&id=0&showPopWin=S';
            var titulo = 'Local Externo';
            showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, bt_local_novoClose, false);
        });
    });

    function bt_local_novoClose(returnVal) {
        $("#idt_local").val('');
        $("#idt_local").data('cascade_val', returnVal);
        $("#idt_cidade").change();
    }
</script>
<?php
if (acesso('grc_evento_local_pa', aspa('inc'), false, false) && ($acao == 'inc' || $acao == 'alt')) {
    echo '<img id="bt_local_novo" title="Novo Local Externo" src="imagens/incluir_32.png">';
}
