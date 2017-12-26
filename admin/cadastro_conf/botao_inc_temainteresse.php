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
echo " <div class='botao_ag_t' onclick='return IncluirTemaInteresse({$idt_atendimento});' >";
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

    function IncluirTemaInteresse(idt_atendimento)
    {
        var idt_tema_interesse = '';
        var id = 'idt_tema_interesse';
        objtp = document.getElementById(id);
        if (objtp != null) {
            idt_tema_interesse = objtp.value;
        }

        if (idt_tema_interesse == '')
        {
            alert('Favor escolher o Tema de Interesse.');
            return false;
        }

        var titulo = "Processando Salvar Tema de Interesse. Aguarde...";
        processando_grc(titulo, '#2F66B8');

        $.ajax({
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=SalvarTemaInteresse',
            data: {
                cas: conteudo_abrir_sistema,
                idt_atendimento: idt_atendimento,
                idt_tema_interesse: idt_tema_interesse
            },
            success: function (str) {
                if (str == '') {
                    btFechaCTC($('#grc_atendimento_tema').data('session_cod'));
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
