<?php
echo " <div onclick='return IncluiPecaGestor();' style='color:#004080; font-size:14px; float:left; cursor:pointer; padding-top:30px; padding-left:0px; '>";
echo " <img  xwidth='24' xheight='24' title='Inclui Peça gerada pelo Gestor' src='imagens/incluir_16.png' border='0'>";
echo " </div>";
echo " <div onclick='return AlteraPecaGestor();' style='color:#004080; font-size:14px; float:left; cursor:pointer; padding-top:25px; padding-left:10px; '>";
echo " <img  width='24' height='24' title='Altera Peça gerada pelo Gestor' src='imagens/alterar_16.png' border='0'>";
echo " </div>";
echo " <div onclick='return ExcluiPecaGestor();' style='color:#004080; font-size:14px; float:left; cursor:pointer; padding-top:25px; padding-left:10px; '>";
echo " <img  width='24' height='24' title='Exclui Peça gerada pelo Gestor' src='imagens/excluir_16.png' border='0'>";
echo " </div>";
?>
<script>


    function IncluiPecaGestor()
    {
        // Peça Gestor

        var peca_padrao = 0;
        var id = 'peca_padrao';
        objtp = document.getElementById(id);
        if (objtp != null) {
            peca_padrao = objtp.value;
        }
        if (peca_padrao == "S")
        {
            alert('A Peça associada a esse Evento é a Padrão Gerada pela UAIN');
            return false;
        }
        var idt_peca = 0;
        var id = 'idt_peca';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_peca = objtp.value;
        }
        if (idt_peca > 0)
        {
            alert('A Peça que esta associada a esse Evento é uma Gerada pela UAIN.');
            return false;
        }

        // incluir Peca pelo Gestor

        var idt_peca_evento = 0;
        var id = 'idt_peca_evento';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_peca_evento = objtp.value;
        }
        if (idt_peca_evento > 0)
        {
            alert('Já existe uma Peça associada a esse Evento pelo GESTOR');
            // chmar e mostrar peça Evento
        } else
        {
            peca = "G";
            //alert('A Peça associada '+idt_peca_evento);
            var url = 'conteudo_cadastro.php?acao=inc&prefixo=cadastro&menu=grc_agenda_emailsms' + '&veio=pa&peca=' + peca + '&idt_peca=' + idt_peca_evento;
            var titulo = 'Peça Gerada pelo GESTOR - INCLUSÃO';
            showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, RefreshPecaGestor, false);
        }
    }


    function AlteraPecaGestor()
    {
        // Peça Gestor
        var idt_peca_evento = 0;
        var id = 'idt_peca_evento';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_peca_evento = objtp.value;
        }
        if (idt_peca_evento > 0)
        {
            // chmar e mostrar peça Evento
            peca = "G";
            //alert('A Peça associada '+idt_peca_evento);
            var url = 'conteudo_cadastro.php?acao=alt&prefixo=cadastro&menu=grc_agenda_emailsms' + '&veio=pa&peca=' + peca + '&id=' + idt_peca_evento;
            var titulo = 'Peça Gerada pelo GESTOR - ALTERAÇÃO';
            showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, RefreshPecaGestor, false);

        } else {
            alert('A Peça associada a esse Evento Não é uma Peça gerada pelo Gestor');
        }
    }


    function ExcluiPecaGestor()
    {
        // Peça Gestor
        var idt_peca_evento = 0;
        var id = 'idt_peca_evento';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_peca_evento = objtp.value;
        }
        if (idt_peca_evento > 0)
        {
            // chmar e mostrar peça Evento
            peca = "G";
            //alert('A Peça associada '+idt_peca_evento);
            var url = 'conteudo_cadastro.php?acao=exc&prefixo=cadastro&menu=grc_agenda_emailsms' + '&veio=pa&peca=' + peca + '&id=' + idt_peca_evento;
            var titulo = 'Peça Gerada pelo GESTOR - EXCLUSÃO';
            showPopWin(url, titulo, $('div.showPopWin_width').width() - 10, $(window).height() - 100, RefreshPecaGestor, false);

        } else
        {
            alert('A Peça associada a esse Evento Não é uma Peça gerada pelo Gestor');
        }
    }

    function RefreshPecaGestor() {
        processando();

        $.ajax({
            type: 'POST',
            url: ajax_sistema + '?tipo=cmb_peca_gestor',
            data: {
                cas: conteudo_abrir_sistema
            },
            success: function (str) {
                var idt_org = $('#idt_peca_evento').val();
                $('#idt_peca_evento').html(url_decode(str));
                $('#idt_peca_evento').val(idt_org);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $("#dialog-processando").remove();
    }
</script>