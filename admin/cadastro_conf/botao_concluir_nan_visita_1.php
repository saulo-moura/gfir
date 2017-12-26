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
        width:160px;
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
<?php
if ($_GET['pesquisa'] == 'SC') {
    echo " <div class='botao_ag_bl' onclick='return CancelarAtendimento();' >";
    echo " <div style='margin:8px; '>Cancelar</div>";
    echo " </div>";
    
    echo " <div class='botao_ag_bl' onclick='{$botao_volta_include};'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else if ($acao == 'inc' || $acao == 'alt') {
    echo " <div class='botao_ag_bl' onclick='return FinalizarAtendimento();' >";
    echo " <div style='margin:8px; '>Enviar para Validação</div>";
    echo " </div>";

    echo " <div class='botao_ag_bl' onclick='return CancelarAtendimento();' >";
    echo " <div style='margin:8px; '>Cancelar</div>";
    echo " </div>";

    echo " <div class='botao_ag_bl' onclick='return VoltarAtendimentoAba2();'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else {
    echo " <div class='botao_ag_bl' onclick='{$botao_volta_include};'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
}
?>
<script>
    $(document).ready(function () {
        onSubmitCancelado = function () {
            situacao_submit = '';
            onSubmitMsgTxt = '';
            valida_cust = '';

            $('#diagnostico_desc, #demanda_desc, #devolutiva_desc').removeClass("Tit_Campo").addClass("Tit_Campo_Obr");
        };
    });

    function FinalizarAtendimento()
    {
        calculaMinuto();

        situacao_submit = 'Enviar para Validação';
        onSubmitMsgTxt = 'Este atendimento será Enviar para Validação e Gravado.\n\nConfirma?';
        $(':submit:first').click();
    }

    function CancelarAtendimento()
    {
        situacao_submit = 'Cancelado';
        onSubmitMsgTxt = 'Este atendimento será Cancelado.\n\nConfirma?';
        valida_cust = 'N';
        $(':submit:first').click();
    }

    function VoltarAtendimentoAba2()
    {
        situacao_submit = 'Finalizado em Alteração';
        $('#diagnostico_desc, #demanda_desc, #devolutiva_desc').addClass("Tit_Campo").removeClass("Tit_Campo_Obr");
        $(':submit:first').click();
    }
</script>