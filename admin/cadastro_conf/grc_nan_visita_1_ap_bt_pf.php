<style>
    .botao_ag_bl_pf {
        text-align:center;
        width:250px;
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
    .botao_ag_bl_pf:hover {
        background:#0000FF;
    }
</style>
<div align="center">
    <?php
    echo " <div class='botao_ag_bl_pf' onclick='ValidarPF({$_GET['id']})'>";
    echo " <div style='margin:8px; '>Analisado Cadastro de Pessoa</div>";
    echo " </div>";
    ?>
</div>
<script>
    function  ValidarPF(idt_atendimento) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=nanValidarPF',
            data: {
                cas: conteudo_abrir_sistema,
                idt: idt_atendimento
            },
            success: function (response) {
                if (response.erro == '') {
                    ajusta_frm_etapa('cadastro_pj');
                    $('div.botao_ag_bl_pf').remove();
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