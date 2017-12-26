<style type="text/css">
    .Barra {
        display: none;
    }

    .botao_ag_b2 {
        text-align:center;
        padding: 10px;
        width: 200px;
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
</style>
<center>
    <?php
    $sql = '';
    $sql .= ' select r.situacao, r.idt_colaborador_origem, r.idt_colaborador_destino, u.idt_unidade_lotacao';
    $sql .= ' from grc_transferencia_responsabilidade r';
    $sql .= ' inner join plu_usuario u on u.id_usuario = r.idt_colaborador_destino';
    $sql .= ' where r.idt = '.null($_GET['id']);
    $rs = execsql($sql);
    $rowT = $rs->data[0];

    if ($rowT['situacao'] == 'GC') {
        $sql = '';
        $sql .= ' select idt_cargo';
        $sql .= ' from plu_usuario';
        $sql .= ' where id_usuario = '.null($rowT['idt_colaborador_origem']);
        $rs = execsql($sql);
        $idt_cargoOrg = $rs->data[0][0];

        $sql = '';
        $sql .= ' select idt_cargo';
        $sql .= ' from plu_usuario';
        $sql .= ' where id_usuario = '.null($rowT['idt_colaborador_destino']);
        $rs = execsql($sql);
        $idt_cargoDes = $rs->data[0][0];

        if ($idt_cargoOrg != $idt_cargoDes) {
            $sql = '';
            $sql .= ' select u.id_usuario';
            $sql .= ' from plu_usuario u';
            $sql .= ' inner join plu_perfil p on p.id_perfil = u.id_perfil';
            $sql .= " where p.trans_resp_aprova_cgp = 'S'";
            $sql .= " and u.ativo = 'S'";
            $sql .= ' limit 1';
            $rsCG = execsql($sql);

            if ($rsCG->rows == 0) {
                alert('Não pode Aprovar esta Transferência de Responsabilidade, pois não tem colaborador autorizado para fazer a aprovação CGP!');
            } else {
                echo "<div class='botao_ag_b2' onclick='return ConfirmaAprovacao()'>Aprovar</div>";
            }
        } else {
            echo "<div class='botao_ag_b2' onclick='return ConfirmaAprovacao()'>Aprovar</div>";
        }
    } else {
        echo "<div class='botao_ag_b2' onclick='return ConfirmaAprovacao()'>Aprovar</div>";
    }
    ?>
    <div class='botao_ag_b2' onclick='return ConfirmaReprovacao()'>Reprovar</div>
    <div class='botao_ag_b2' onclick='return Voltar();'>Voltar</div>
</center>
<script>
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            situacao = situacaoPadrao;
        };

        setTimeout(function () {
            $('#justificativa_reprovacao').removeProp("disabled").removeClass("campo_disabled");
        }, 500);

        setTimeout(function () {
            $('#justificativa_reprovacao').removeProp("disabled").removeClass("campo_disabled");
        }, 2000);
    });

    function Voltar() {
        $('#bt_voltar').click();
    }

    function ConfirmaAprovacao() {
        situacao = 'AP';
        $(':submit:first').click();
    }

    function ConfirmaReprovacao() {
        if ($('#justificativa_reprovacao').val().length == 0) {
            alert('Favor informar a Justificativa da Aprovação / Reprovação!');
            $('#justificativa_reprovacao').focus();
            return false;
        }


        situacao = 'RE';
        $(':submit:first').click();
    }
</script>


