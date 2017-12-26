<style type="text/css">
    #grc_evento_anexo_desc,
    #grc_atendimento_evento_anexo_desc {
        width: 800px;
    }

    #bt_ficha_acao {
        text-align: center;
        color: #FFFFFF;
        background: #2F65BB;
        font-size: 14px;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        padding: 5px 10px;
    }    
</style>
<div id='bt_ficha_acao'>FICHA TÉCNICA DO PRODUTO</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#bt_ficha_acao').click(function () {
            if ($('#idt_produto').val() == '') {
                alert('Favor informar o Produto!');
                return false;
            }
            
            var url = 'conteudo_pdf.php?prefixo=cadastro&menu=grc_produto&titulo_rel=Ficha%20T%E9cnica%20do%20Produto&print_tela=S&id=' + $('#idt_produto').val();
            OpenWin(url, 'ficha' +  $('#idt_produto').val(), screen.width, screen.height, 0, 0, 'yes');
        });
    });
</script>