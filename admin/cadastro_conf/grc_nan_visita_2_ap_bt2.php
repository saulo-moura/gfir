<style>
    .botao_ag {
        text-align:center;
        width:180px;
        height:35px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        float:left;
        margin-top:20px;
        margin-right:10px;
        font-weight:bold;
    }
    .botao_ag:hover {
        background:#0000FF;


    }
    .botao_ag_bl {
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
    .botao_ag_bl:hover {
        background:#0000FF;
    }

    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }

</style>
<div align="center">
    <?php
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_avaliacao';
    $sql .= ' where idt_atendimento = '.null($_GET['id']);
    $rs = execsql($sql);
    $idt_avaliacao = $rs->data[0][0];

    if (frm_etapa == 'cadastro_pf' || frm_etapa == 'cadastro_pj' || frm_etapa == 'cadastro_at') {
        echo " <div id='botao_ag_bl_at' class='botao_ag_bl' onclick='ValidarAtendimento({$_GET['id']})'>";
        echo " <div style='margin:8px; '>Analisado Cadastro de Atendimento</div>";
        echo " </div>";
    }
    ?>
</div>
<script>
    $(document).ready(function () {
        onSubmitCancelado = function () {
            situacao_submit = '';
            onSubmitMsgTxt = '';
            valida_cust = '';
        };

        setTimeout(function () {
            $('#solucao').removeProp("disabled").removeClass("campo_disabled");
        }, 100);
    });

    function  ValidarAtendimento(idt_atendimento) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php?tipo=nanValidarAtendimento',
            data: {
                cas: conteudo_abrir_sistema,
                idt: idt_atendimento
            },
            success: function (response) {
                if (response.erro == '') {
                    ajusta_frm_etapa('parecer');
                    $('div#botao_ag_bl_at').remove();
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