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
        width:100px;
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

    .botao_ag_b2 {
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
    .botao_ag_b2:hover {
        background:#0000FF;
    }

    .botao_ag_b3 {
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
    .botao_ag_b3:hover {
        background:#0000FF;
    }

    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }

    .sem_width {
        width: auto;
    }
</style>
<?php
switch ($acao) {
    case 'alt':
        if ($acao_alt_con != 'S') {
            echo " <div class='botao_ag_b2' onclick='return ConfirmaMontarOrdem()' >";
            echo " <div style='margin:8px; '>Montar Ordem de Pagamento</div>";
            echo " </div>";

            echo " <div class='botao_ag_b2' onclick='return ConfirmaDesMontarOrdem()' >";
            echo " <div style='margin:8px; '>Desmontar Ordem de Pagamento</div>";
            echo " </div>";
        }

        echo " <div class='botao_ag_b3' onclick='return ImprimirOrdem()' >";
        echo " <div style='margin:8px; '>Imprimir Ordem de Pagamento</div>";
        echo " </div>";
        break;

    case 'inc':
        echo " <div class='botao_ag_b2' onclick='return ConfirmaMontarOrdem()' >";
        echo " <div style='margin:8px; '>Montar Ordem de Pagamento</div>";
        echo " </div>";
        break;

    case 'exc':
        echo " <div class='botao_ag_b2' style='width: 300px;' onclick='return ConfirmaDesMontarOrdemExc()' >";
        echo " <div style='margin:8px; '>Desmontar e Exclusão Ordem de Pagamento</div>";
        echo " </div>";

        echo " <div class='botao_ag_b3' onclick='return ImprimirOrdem()' >";
        echo " <div style='margin:8px; '>Imprimir Ordem de Pagamento</div>";
        echo " </div>";
        break;

    case 'con':
        echo " <div class='botao_ag_b3' onclick='return ImprimirOrdem()' >";
        echo " <div style='margin:8px; '>Imprimir Ordem de Pagamento</div>";
        echo " </div>";
        break;
}

echo " <div class='botao_ag_bl' onclick='return Voltar();'>";
echo " <div style='margin:8px; '>Voltar</div>";
echo " </div>";
?>
<script>
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            acao_nan = '';
        };
    });

    function Voltar() {
        $('#bt_voltar').click();
    }

    function ConfirmaMontarOrdem() {
        acao_nan = 'AG';
        $(':submit:first').click();
    }

    function ConfirmaDesMontarOrdem() {
        acao_nan = 'DE';
        $(':submit:first').click();
    }

    function ConfirmaDesMontarOrdemExc() {
        acao_nan = 'EX';
        $(':submit:first').click();
    }

    function ImprimirOrdem() {
        $('#bt_exportar').click();
    }
</script>


