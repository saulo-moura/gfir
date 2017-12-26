<style>
    .botao_ag_bl_pj {
        text-align:center;
        width:270px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;

    }
    .botao_ag_bl_pj:hover {
        background:#0000FF;
    }
</style>
<div align="center">
    <?php
    echo " <div class='botao_ag_bl_pj' onclick='ValidarPJ({$_GET['id']})'>";
    echo " <div style='margin:8px; '>Analisado Cadastro de Empreendimento</div>";
    echo " </div>";
    ?>
</div>
<script>
    function ValidarPJ(idt_atendimento) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=nanValidarPJ',
            data: {
                cas: conteudo_abrir_sistema,
                idt: idt_atendimento
            },
            success: function (response) {
                if (response.erro == '') {
                    ajusta_frm_etapa('cadastro_at');
                    $('div.botao_ag_bl_pj').remove();
                } else {
                    $("#dialog-processando").remove();
                    alert(url_decode(response.erro));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#dialog-processando").remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $("#dialog-processando").remove();
    }
</script>