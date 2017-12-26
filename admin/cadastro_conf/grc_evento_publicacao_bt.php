<style>
    .botao_ag_bl {
        text-align:center;
        min-width:130px;
        color:#FFFFFF;
        background:#2F65BB;
        font-size:14px;
        cursor:pointer;
        display: inline-block;
        margin-top:10px;
        margin-right:10px;
        font-weight:bold;
        padding: 8px;
    }

    .botao_ag_bl:hover {
        background:#0000FF;
    }

    .barra_final {
        text-align:center;
    }
</style>
<?php
echo "<div class='barra_final'>";

$id_usuarioSTR = $_SESSION[CS]['g_id_usuario'];
$id_usuarioSTR = (string) $id_usuarioSTR;

$sql = '';
$sql .= ' select idt_instrumento, previsao_despesa, idt_ponto_atendimento, idt_unidade, idt_gestor_projeto';
$sql .= ' from grc_evento';
$sql .= ' where idt = ' . null($_GET['idt0']);
$rs = execsqlNomeCol($sql);
$rowe = $rs->data[0];

if ($acao == 'exc') {
    switch ($rowDados['situacao']) {
        case 'CD':
            if ($id_usuarioSTR == $rowDados['idt_responsavel']) {
                echo "<div class='botao_ag_bl' onclick='btExcluir();'>Excluir</div>";
            } else {
                alert('Não pode excluir, pois não tem permissão!');
            }
            break;

        default:
            alert('Não pode Cancelar este evento!');
            break;
    }
} else if (($acao == 'inc' || $acao == 'alt') && $acao_alt_con == 'N') {
    if ($rowDados['idt_evento_situacao'] >= 14) {
        $sql = "select s.classificacao";
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao s';
        $sql .= " where s.idt  = " . null($rowe['idt_unidade']);
        $rs = execsql($sql);
        $classificacao_unidade = $rs->data[0][0];

        $situacao_novo = decideAprovadorInicialEventoPublicacao($rowe['idt_instrumento'], $rowe['idt_gestor_projeto'], $rowDados['idt_responsavel'], $rowe['idt_unidade'], $rowe['idt_ponto_atendimento'], $classificacao_unidade, $rowe['previsao_despesa'], $rs_pendencia, $temCG, $temDI);

        switch ($situacao_novo) {
            case 'CG':
                $lbl_funcao = 'Validar e Encaminhar para Coordenador/Gerente';
                break;

            case 'DI':
                $lbl_funcao = 'Validar e Encaminhar para Diretor';
                break;

            case 'AP':
                $lbl_funcao = 'Aprovar';
                break;

            default:
                $lbl_funcao = 'Enviar para Aprovação';
                break;
        }

        echo "<div class='botao_ag_bl' onclick=\"btAprovar('" . $situacao_novo . "');\">" . $lbl_funcao . "</div>";
    }

    echo "<div class='botao_ag_bl' onclick='btSalvar();'>Salvar</div>";
} else {
    if ($rowDados['situacao'] == 'GP' || $rowDados['situacao'] == 'CG' || $rowDados['situacao'] == 'DI') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_pendencia';
        $sql .= ' where idt = ' . null($_GET['idt_pendencia']);
        $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
        $sql .= " and ativo = 'S'";
        $sql .= " and tipo = 'Política de Desconto do Evento'";
        $sql .= whereAtendimentoPendencia();
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            switch ($rowDados['situacao']) {
                case 'GP':
                    $lbl_funcao = 'Validar e Encaminhar para Coordenador/Gerente';
                    $situacao_novo = 'CG';
                    break;

                case 'CG':
                    $sql = '';
                    $sql .= ' select ea.vl_alcada';
                    $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
                    $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
                    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = op.cod_usuario';
                    $sql .= ' where ea.idt_instrumento = ' . null($rowe['idt_instrumento']);
                    $sql .= ' and u.id_usuario = ' . null($id_usuarioSTR);
                    $rsEA = execsql($sql);
                    $vl_alcada = $rsEA->data[0][0];

                    if ($vl_alcada == '') {
                        $vl_alcada = 0;
                    }

                    if ($rowe['previsao_despesa'] > $vl_alcada) {
                        $lbl_funcao = 'Validar e Encaminhar para Diretor';
                        $situacao_novo = 'DI';
                    } else {
                        $lbl_funcao = 'Aprovar';
                        $situacao_novo = 'AP';
                    }
                    break;

                default:
                    $lbl_funcao = 'Aprovar';
                    $situacao_novo = 'AP';
                    break;
            }

            echo "<div class='botao_ag_bl' onclick=\"btAprovar('" . $situacao_novo . "');\">" . $lbl_funcao . "</div>";
            echo "<div class='botao_ag_bl' onclick='btCancelar();'>Cancelar Registro</div>";
        } else {
            $sql = "select s.classificacao";
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao s';
            $sql .= " where s.idt  = " . null($rowe['idt_unidade']);
            $rs = execsql($sql);
            $classificacao_unidade = $rs->data[0][0];

            $vetCG = CoordenadorGerenteDiretorEvento('CG', $rowe['idt_instrumento'], $rowe['idt_unidade'], $rowe['idt_ponto_atendimento'], $classificacao_unidade, $rowe['previsao_despesa']);

            if ($id_usuarioSTR == $rowDados['idt_responsavel'] || in_array($id_usuarioSTR, $vetCG)) {
                echo "<div class='botao_ag_bl' onclick='btCancelar();'>Cancelar Registro</div>";
            }
        }
    } else if ($rowDados['ativo'] == 'S' && $acao == 'alt') {
        $sql = "select s.classificacao";
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao s';
        $sql .= " where s.idt  = " . null($rowe['idt_unidade']);
        $rs = execsql($sql);
        $classificacao_unidade = $rs->data[0][0];

        $situacao_novo = decideAprovadorInicialEventoPublicacao($rowe['idt_instrumento'], $rowe['idt_gestor_projeto'], $rowDados['idt_responsavel'], $rowe['idt_unidade'], $rowe['idt_ponto_atendimento'], $classificacao_unidade, $rowe['previsao_despesa'], $rs_pendencia, $temCG, $temDI);

        echo "<div class='botao_ag_bl' onclick=\"btDespublicar('" . $situacao_novo . "');\">Despublicar</div>";
    }
}

if ($rowDados['temporario'] == 'S') {
    echo "<div class='botao_ag_bl' onclick='btVoltar(true);'>Voltar</div>";
} else {
    echo "<div class='botao_ag_bl' onclick='btVoltar(false);'>Voltar</div>";
}

echo "</div>";
?>
<script type="text/javascript">
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            $('#situacao').val('<?php echo $rowDados['situacao']; ?>');
            $('#situacao_ant').val('<?php echo $rowDados['situacao']; ?>');
        };
    });

    function btExcluir() {
        $(':submit:first').click();
    }

    function btSalvar() {
        $(':submit:first').click();
    }

    function btAprovar(situacao_novo) {
        if (situacao_novo == 'AP') {
            onSubmitMsgTxt = 'Confirma a APROVAÇÃO FINAL deste registro?';
        } else {
            onSubmitMsgTxt = 'Confirma a APROVAÇÃO desta etapa do registro?';
        }

        $('#situacao').val(situacao_novo);
        $(':submit:first').click();
    }

    function btCancelar() {
        valida_cust = 'N';
        $('#situacao').val('CA');
        $(':submit:first').click();
    }

    function btDespublicar(situacao_novo) {
        if (confirm('Deseja Despublicar o Evento?')) {
            valida_cust = 'N';
            onSubmitMsgTxt = false;
            $('#situacao').val(situacao_novo);
            $('#situacao_ant').val('Despublicar');
            $(':submit:first').click();
        }
    }

    function btVoltar(chama_ajax) {
        if (chama_ajax) {
            if (confirm('Deseja EXCLUIR este registro de rascunho?')) {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: ajax_sistema + '?tipo=grc_evento_publicacao_exc_temp',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt: '<?php echo $rowDados['idt']; ?>'
                    },
                    success: function (response) {
                        if (response.erro == '') {
                            $('#bt_voltar').click();
                        } else {
                            $('#dialog-processando').remove();
                            alert(url_decode(response.erro));
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#dialog-processando').remove();
                        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                    },
                    async: false
                });

                $('#dialog-processando').remove();
            }
        } else {
            $('#bt_voltar').click();
        }
    }
</script>