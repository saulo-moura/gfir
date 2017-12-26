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
    echo " <div class='botao_ag_bl' onclick='VoltarAtendimento();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
    ?>
</div>
<script>
    function VoltarAtendimento() {
        $('#bt_voltar').click();
    }
</script>