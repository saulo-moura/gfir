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

$id_usuarioSTR = $_SESSION[CS]['g_id_usuario_sistema']['GEC'];
$id_usuarioSTR = (string) $id_usuarioSTR;

if ($acao != 'con') {
    if ($acao == 'exc') {
        switch ($rowDados['situacao']) {
            case 'CD':
            case 'DE':
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
        if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
            $situacao_novo = 'RE';
            $lbl_funcao = 'Enviar para Aprovação';
        } else {
            $situacao_novo = decideAprovadorInicialDistratoAditivo($rowDados['idt_instrumento'], $rowDados['idt_gestor_projeto'], $rowDados['idt_responsavel_evento'], $rowDados['idt_unidade'], $rowDados['idt_ponto_atendimento'], $rowDados['classificacao'], $rowDados['vl_cotacao'], $rs_pendencia, $temCG, $temDI);

            switch ($situacao_novo) {
                case 'CG':
                    $lbl_funcao = 'Validar e Encaminhar para Gerente';
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
        }

        echo "<div class='botao_ag_bl' onclick=\"btAprovar('" . $situacao_novo . "');\">" . $lbl_funcao . "</div>";
        echo "<div class='botao_ag_bl' onclick='btSalvar();'>Salvar</div>";
    } else {
        if ($rowDados['situacao'] == 'RE' || $rowDados['situacao'] == 'GP' || $rowDados['situacao'] == 'CG' || $rowDados['situacao'] == 'DI') {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pendencia';
            $sql .= ' where idt = ' . null($_GET['idt_pendencia']);
            $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
            $sql .= " and ativo = 'S'";
            $sql .= " and tipo = 'Aprovação do Aditamento'";
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                switch ($rowDados['situacao']) {
                    case 'RE':
                        $lbl_funcao = 'Validar e Encaminhar para Gestor';
                        $situacao_novo = 'CG';
                        break;

                    case 'GP':
                        $lbl_funcao = 'Validar e Encaminhar para Gerente';
                        $situacao_novo = 'CG';
                        break;

                    case 'CG':
                        $sql = '';
                        $sql .= ' select ea.vl_alcada';
                        $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
                        $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
                        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = op.cod_usuario';
                        $sql .= ' where ea.idt_instrumento = ' . null($rowDados['idt_instrumento']);
                        $sql .= ' and u.id_usuario = ' . null(IdUsuarioPIR($id_usuarioSTR, db_pir_gec, db_pir_grc));
                        $rsEA = execsql($sql);
                        $vl_alcada = $rsEA->data[0][0];

                        if ($vl_alcada == '') {
                            $vl_alcada = 0;
                        }

                        if ($rowDados['vl_cotacao'] > $vl_alcada) {
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
                echo "<div class='botao_ag_bl' onclick='btDevolver();'>Devolver para Ajuste</div>";

                if ($rowDados['situacao'] == 'RE') {
                    echo "<div class='botao_ag_bl' onclick='btSalvar();'>Salvar</div>";
                }

                echo "<div class='botao_ag_bl' onclick='btCancelar();'>Cancelar Registro</div>";
            } else {
                $vetCG = CoordenadorGerenteDiretorEvento('CG', $rowDados['idt_instrumento'], $rowDados['idt_unidade'], $rowDados['idt_ponto_atendimento'], $rowDados['classificacao'], $rowDados['vl_cotacao']);

                if ($id_usuarioSTR == $rowDados['idt_responsavel'] || in_array($id_usuarioSTR, $vetCG)) {
                    echo "<div class='botao_ag_bl' onclick='btCancelar();'>Cancelar Registro</div>";
                }
            }
        }

        if ($rowDados['situacao'] == 'AP') {
            echo "<div class='botao_ag_bl' onclick='btAssinar();'>Salvar</div>";
        }
    }
}

echo "<div class='botao_ag_bl' onclick='btVoltar();'>Voltar</div>";

echo "</div>";
?>
<script type="text/javascript">
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            $('#situacao').val('<?php echo $rowDados['situacao']; ?>');
            $('#situacao_ant').val('<?php echo $rowDados['situacao']; ?>');
            $('#bt_salva').val('');
        };
    });

    function btExcluir() {
        $(':submit:first').click();
    }

    function btSalvar() {
        $('#bt_salva').val('S');
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

    function btDevolver() {
        valida_cust = 'N';
        onSubmitMsgTxt = 'Confirma a Devolução para Ajuste deste registro?';
        $('#situacao').val('DE');
        $(':submit:first').click();
    }

    function btAssinar() {
        onSubmitMsgTxt = 'Confirma a Assinatura do Aditamento?';
        $('#situacao').val('AS');
        $(':submit:first').click();
    }

    function btCancelar() {
        valida_cust = 'N';
        $('#situacao').val('CA');
        $(':submit:first').click();
    }

    function btVoltar() {
        $('#bt_voltar').click();
    }

    function AbrirEvento(idt_evento) {
        var url = 'conteudo.php?acao=alt&prefixo=cadastro&menu=grc_evento&idt_instrumento=2&id=' + idt_evento;
        OpenWin(url, 'AbrirEvento' + idt_evento, screen.width, screen.height, 0, 0);
    }
</script>