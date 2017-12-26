<style>
    .botao_ag_b2 {
        text-align:center;
        width:200px;
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
    .botao_ag_b2:hover {
        background:#0000FF;
    }

    .barra_final {
        text-align:center;
    }

    .btCopiarAgenda {
        width: auto;
        margin-left: 20px;
        margin-bottom: 10px;
    }
</style>
<?php
echo " <div class='barra_final' >";

if ($acao == 'inc' || $acao == 'alt') {
    echo " <div class='botao_ag_b2'id='bt_empresa'>";
    echo " <div style='margin:8px; '>Carregar dados da Empresa</div>";
    echo " </div>";

    echo " <div class='botao_ag_b2' id='bt_cliente'>";
    echo " <div style='margin:8px; '>Carregar dados do Cliente</div>";
    echo " </div>";

    echo " </div>";
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#bt_empresa').click(function () {
            $('#cpfcnpj').val('<?php echo $vetDadosBtNovo['J']['cpfcnpj']; ?>');
            $('#razao_social').val('<?php echo $vetDadosBtNovo['J']['razao_social']; ?>');
        });
        
        $('#bt_cliente').click(function () {
            $('#cpfcnpj').val('<?php echo $vetDadosBtNovo['F']['cpfcnpj']; ?>');
            $('#razao_social').val('<?php echo $vetDadosBtNovo['F']['razao_social']; ?>');
        });
    });
</script>