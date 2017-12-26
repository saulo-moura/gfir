<style>
    .botao_ag_t {
        text-align:center;
        width:25px;
        xheight:35px;
        xcolor:#FFFFFF;
        Xbackground:#0000FF;
        background:#2F65BB;
        xfont-size:14px;
        cursor:pointer;
        xfloat:left;
        xmargin-top:20px;
        xmargin-right:10px;
        xpadding-top:20px;
        xpadding-right:20px;
        xfont-weight:bold;

        margin-top:20px;


    }
    .botao_ag_t:hover {
        background:#0000FF;


    }
    .botao_ag_bl_t {
        text-align:center;
        width:100px;
        height:35px;
        color:#FFFFFF;
        //background:#0000FF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:10px;
        margin-right:10px;
        xpadding-top:20px;
        xpadding-right:20px;
        font-weight:bold;

    }
    .botao_ag_bl_t:hover {
        background:#0000FF;
    }

</style>


<?php
echo " <div class='botao_ag_t' onclick='return IncluirTemaTratado({$idt_atendimento});' >";
echo " <img style='xpadding-top:15px;' width='16' height='16' title='Incluir Tema de Interesse' src='imagens/incluir_21.png' border='0'>";
echo " </div>";

/*
  echo " <div class='botao_ag_bl' onclick='return CancelarAtendimento({$idt_atendimento});' >";
  echo " <div style='margin:8px; '>Cancelar</div>";
  echo " </div>";
 */
?>
<script>
    $(document).ready(function () {
    });
    function IncluirTemaTratado(idt_atendimento)
    {
        var erros = "";
        var idt_tema_tratado = '';

        var id = 'idt_tema_tratado';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_tema_tratado = objtp.value;
        }
        if (idt_tema_tratado == '')
        {
            erros = erros + 'Favor escolher o Tema Tratado.' + "\n";
            ;
        }

        var idt_subtema_tratado = '';
        var id = 'idt_subtema_tratado';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_subtema_tratado = objtp.value;
        }
        if (idt_subtema_tratado == '')
        {
            erros = erros + 'Favor escolher o SubTema Tratado.' + "\n";
            ;
        }
        if (erros != '')
        {
            alert(erros);
            return false;
        }
        //
        var titulo = "Processando Salvar Tema Tratado. Aguarde...";
        processando_grc(titulo, '#2F66B8');

        $.ajax({
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=SalvarTemaTratado',
            data: {
                cas: conteudo_abrir_sistema,
                idt_atendimento: idt_atendimento,
                idt_tema_tratado: idt_tema_tratado,
                idt_subtema_tratado: idt_subtema_tratado
            },
            success: function (str) {
                if (str == '') {
                    btFechaCTC($('#grc_atendimento_tema_tratado').data('session_cod'));
                } else {
                    processando_acabou_grc();
                    alert(str);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                processando_acabou_grc();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });
        
        processando_acabou_grc();

        return false;
    }



</script>
