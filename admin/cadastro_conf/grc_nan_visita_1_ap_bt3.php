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
    $acao = $acao_org;
    if ($acao_org == 'alt') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_pendencia';
        $sql .= ' where idt = '.null($_GET['idt_pendencia']);
        $sql .= ' and idt_responsavel_solucao = '.null($_SESSION[CS]['g_id_usuario']);
        $sql .= " and ativo = 'S'";
        $sql .= " and tipo   =  'NAN - Visita {$num_visita}'";
        $sql .= " and status =  'Aprovação'";
        $sql .= whereAtendimentoPendencia();
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            alert('Não pode Validar a Visita, pois não tem permissão!');
        } else {
            echo " <div class='botao_ag_bl' onclick='ValidarVisita();' >";
            echo " <div style='margin:8px; '>Validar Visita</div>";
            echo " </div>";

            echo " <div class='botao_ag_bl' onclick='DevolverAjustes();' >";
            echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
            echo " </div>";
        }
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

    function ValidarVisita() {
        situacao_submit = 'Validar Visita';
        $(':submit:first').click();
    }

    function DevolverAjustes() {
        valida_cust = 'N';
        situacao_submit = 'Devolver para Ajustes';
        $(':submit:first').click();
    }
</script>