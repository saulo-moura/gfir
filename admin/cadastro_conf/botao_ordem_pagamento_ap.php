<?php
if ($rowPEN['idt_pfo_af_processo'] == '') {
    if ($acao == 'alt') {
        if ($row['situacao'] == 'GE') {
            echo " <div id='btAprovar' class='botao_ag_b2' onclick='opAprovar();' >";
            echo " <div style='margin:8px; '>Solicitar Aprovação</div>";
            echo " </div>";

            echo " <div id='btSincRM' class='botao_ag_b2' onclick='opSincRM();' >";
            echo " <div style='margin:8px; '>Aprovar para Pagamento</div>";
            echo " </div>";
        } else {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pendencia';
            $sql .= ' where idt = '.null($_GET['idt_pendencia']);
            $sql .= ' and idt_responsavel_solucao = '.null($_SESSION[CS]['g_id_usuario']);
            $sql .= " and ativo = 'S'";
            $sql .= " and (tipo = 'NAN - Ordem de Pagamento' or tipo = 'Pagamento a Credenciado')";
            $sql .= whereAtendimentoPendencia();
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                alert('Não pode dar continuidade ao processo, pois não tem permissão!');
            } else {
                if ($row['situacao'] == 'V8') {
                    echo " <div class='botao_ag_b2' onclick='opSincRM();' >";
                    echo " <div style='margin:8px; '>Aprovar para Pagamento</div>";
                    echo " </div>";
                } else {
                    echo " <div id='btAprovar' class='botao_ag_b2' onclick='opAprovar();' >";
                    echo " <div style='margin:8px; '>Aprovação</div>";
                    echo " </div>";

                    echo " <div id='btSincRM' class='botao_ag_b2' onclick='opSincRM();' >";
                    echo " <div style='margin:8px; '>Aprovar para Pagamento</div>";
                    echo " </div>";
                }

                echo " <div class='botao_ag_b2' onclick='opDevolver();' >";
                echo " <div style='margin:8px; '>Devolver</div>";
                echo " </div>";
            }
        }
    }
} else {
    if ($rowPFO['situacao_reg'] == 'ED') {
        echo " <div class='botao_ag_bl' onclick='return pfoSalvar();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolverDOC();'>";
        echo " <div style='margin:8px; '>Devolver para Ajustes (Documentação)</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolverNF();'>";
        echo " <div style='margin:8px; '>Devolver para Ajustes (Nota Fiscal)</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAprovarFIN();'>";
        echo " <div style='margin:8px; '>Financeiro</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAvaliar();'>";
        echo " <div style='margin:8px; '>Avaliar Credenciado</div>";
        echo " </div>";
    } else {
        echo " <div class='botao_ag_bl' onclick='return pfoSalvar();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolver();'>";
        echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAprovar();'>";
        echo " <div style='margin:8px; '>Aprovar Prestação de Contas</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAvaliar();'>";
        echo " <div style='margin:8px; '>Avaliar Credenciado</div>";
        echo " </div>";
    }
}
?>
<script type="text/javascript">
    function opSincRM() {
        acao_nan = 'RM';
        $(':submit:first').click();
    }

    function opAprovar() {
        acao_nan = 'AP';
        $(':submit:first').click();
    }

    function opDevolver() {
        if ($('textarea#solucao_pendencia').val() == '') {
            alert('Por favor o Motivo da Devolução!');
            $('textarea#solucao_pendencia').focus();
            return false;
        }

        acao_nan = 'DV';
        $(':submit:first').click();
    }

    function pfoSalvar() {
        onSubmitMsgTxt = '';
        valida_cust = 'N';
        acao_nan = 'pfoSalvar';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolver() {
        var tot = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox').length;
        var marcado = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checked').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes?';
        valida_cust = 'N';
        acao_nan = 'pfoDevolver';
        $(':submit:first').click();

        return true;
    }

    function pfoAprovar() {
        var tot = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox').length;
        var marcado = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checked').length;

        if (tot != marcado) {
            alert('Não pode aprovar, pois tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Aprovar Prestação de Contas?';
        valida_cust = 'N';
        acao_nan = 'pfoAprovar';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolverDOC() {
        var tot = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox[data-tipo_documento!="NF"]').length;
        var marcado = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checked[data-tipo_documento!="NF"]').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes (Documentação)?';
        valida_cust = 'N';
        acao_nan = 'pfoDevolver';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolverNF() {
        var tot = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox[data-tipo_documento="NF"]').length;
        var marcado = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checked[data-tipo_documento="NF"]').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem Nota Fiscal pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes (Nota Fiscal)?';
        valida_cust = 'N';
        acao_nan = 'pfoAprovar';
        $(':submit:first').click();

        return true;
    }

    function pfoAprovarFIN() {
        var tot = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checkbox').length;
        var marcado = $('#pfo_af_processo_item_desc td[data-campo=situacao] > :checked').length;

        if (tot != marcado) {
            alert('Não pode mandar para o financeiro, pois tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma o envio para o financeiro?';
        valida_cust = 'N';
        acao_nan = 'pfoAprovarFIN';
        $(':submit:first').click();

        return true;
    }

    function pfoAvaliar() {
        var idt_pfo_af_processo = '<?php echo $idt_pfo_af_processo; ?>';
        var url = 'conteudo_exportar.php?prefixo=cadastro&menu=grc_avaliacao_resposta&origem_tela=menu&idt_pfo_af_processo=' + idt_pfo_af_processo;
        OpenWin(url, 'pfoAvaliar' + idt_pfo_af_processo, screen.width, screen.height, 0, 0);
    }
</script>