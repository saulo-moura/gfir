<?php
require('definicao_vetor_grc.php');

define('nan_ano', 2016);

function wizardCriaTela($idDivGeral, $vetWizardTabelaLocal, $tipo, $formula) {
    global $vetWizardOperador, $vetWizardExpressao, $vetRsWizardCampo, $vetIdtWizardParametro;

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_politica_vendas_condicao';
    $sql .= ' where idt_politica_vendas = ' . null($_GET['id']);
    $sql .= ' and tipo = ' . aspa($tipo);
    $sql .= ' and (parentese_ant is not null or parentese_dep is not null)';
    $rs = execsqlNomeCol($sql);

    if ($rs->rows == 0) {
        $opcaoClick = '_wizard_opcao_s';
    } else {
        $opcaoClick = '_wizard_opcao_a';
    }
    ?>
    <div id="<?php echo $idDivGeral; ?>" class="wizard_geral">
        <div class="wizard_opcao">
            <input type="radio" name="<?php echo $idDivGeral; ?>_wizard_opcao" id="<?php echo $idDivGeral; ?>_wizard_opcao_s" value="S" /><label for="<?php echo $idDivGeral; ?>_wizard_opcao_s">PESQUISA SIMPLES</label>
            <input type="radio" name="<?php echo $idDivGeral; ?>_wizard_opcao" id="<?php echo $idDivGeral; ?>_wizard_opcao_a" value="A" /><label for="<?php echo $idDivGeral; ?>_wizard_opcao_a">PESQUISA AVANÇADA</label>
        </div>
        <?php
        $idx = 0;

        echo '<div class="wizard_titulo">';
        echo '<span class="wizard_ordem">&nbsp;</span>';
        echo '<span class="wizard_parentese_ant">Parêntese</span>';
        echo '<span class="wizard_tabela">Tabela</span>';
        echo '<span class="wizard_campo">Campo</span>';
        echo '<span class="wizard_operador">Operador</span>';
        echo '<span class="wizard_valor">Valor</span>';
        echo '<span class="wizard_parentese_dep">Parêntese</span>';
        echo '<span class="wizard_expressao">Expressão</span>';
        echo '</div>';

        echo '<ul>';

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from grc_politica_vendas_condicao';
        $sql .= ' where idt_politica_vendas = ' . null($_GET['id']);
        $sql .= ' and tipo = ' . aspa($tipo);
        $sql .= ' order by ordem';
        $rs = execsqlNomeCol($sql);

        foreach ($rs->data as $row) {
            $idx++;
            echo wizardHtmlLI($idDivGeral, $idx, $row, $vetWizardTabelaLocal);
        }

        echo '</ul>';
        echo '<div class="wizard_modelo">';
        echo wizardHtmlLI($idDivGeral, 0, Array(), $vetWizardTabelaLocal);
        echo '</div>';
        ?>
        <div class="wizard_rodape">
            <span class="wizard_mais" title="Inserir novo item de condição">+ Inserir Item</span>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#<?php echo $formula; ?>').html(wizardMontaSQL('<?php echo $idDivGeral; ?>'));

            $('div#<?php echo $idDivGeral; ?>').on('change', '.wizard_tabela > select', function () {
                var li = $(this).parent().parent();
                var wizard_campo = li.find('.wizard_campo > select');

                var valor = wizard_campo.val();

                if (valor != null) {
                    wizard_campo.empty();

                    var position = {'z-index': '6000', 'position': 'absolute', 'width': '16px'};
                    $.extend(position, wizard_campo.offset());
                    position.top = position.top + 3;
                    position.left = position.left + 3;
                    $("<div class='cascade-loading'>&nbsp;</div>").appendTo("body").css(position);
                    wizard_campo.disabled = true;

                    $.ajax({
                        type: 'POST',
                        url: ajax_sistema + '?tipo=wizard_campo',
                        data: {
                            cas: conteudo_abrir_sistema,
                            wizard_tabela: $(this).val()
                        },
                        success: function (str) {
                            wizard_campo.html(url_decode(str));
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                        },
                        async: false
                    });

                    $(".cascade-loading").remove();
                }
            });

            $('div#<?php echo $idDivGeral; ?>').on('change', 'select', function () {
                $('#<?php echo $formula; ?>').html(wizardMontaSQL('<?php echo $idDivGeral; ?>'));
            });

            $('div#<?php echo $idDivGeral; ?>').on('change', 'input', function () {
                $('#<?php echo $formula; ?>').html(wizardMontaSQL('<?php echo $idDivGeral; ?>'));
            });

            $('div#<?php echo $idDivGeral; ?> > ul').on("click", 'li > span.wizard_menos', function () {
                $(this).parent().remove();
                wizardTravaExpressaoLast('<?php echo $idDivGeral; ?>');
                $('#<?php echo $formula; ?>').html(wizardMontaSQL('<?php echo $idDivGeral; ?>'));
                TelaHeight();
            });

            $('div#<?php echo $idDivGeral; ?> .wizard_mais').click(function () {
                var li = $('#<?php echo $idDivGeral; ?> > .wizard_modelo').html();
                li = li.replace(new RegExp(/<?php echo $idDivGeral; ?>\[0\]/, "g"), '<?php echo $idDivGeral; ?>\[' + ($('div#<?php echo $idDivGeral; ?> > ul > li').length + 1) + '\]');

                $('div#<?php echo $idDivGeral; ?> > ul').append(li);
                wizardTravaExpressaoLast('<?php echo $idDivGeral; ?>');
                TelaHeight();
            });

            $('div#<?php echo $idDivGeral; ?> .wizard_opcao input').click(function () {
                if ($(this).val() == 'S') {
                    $('div#<?php echo $idDivGeral; ?> .wizard_parentese_ant > select, div#<?php echo $idDivGeral; ?> .wizard_parentese_dep > select').val('');
                    $('div#<?php echo $idDivGeral; ?> .wizard_parentese_ant, div#<?php echo $idDivGeral; ?> .wizard_parentese_dep').hide();
                } else {
                    $('div#<?php echo $idDivGeral; ?> .wizard_parentese_ant, div#<?php echo $idDivGeral; ?> .wizard_parentese_dep').show();
                }
            });

            $("div#<?php echo $idDivGeral; ?> > ul").sortable({
                placeholder: "ui-state-highlight",
                update: function (event, ui) {
                    setTimeout("wizardTravaExpressaoLast('<?php echo $idDivGeral; ?>')", 100);
                }
            });

            if ($("div#<?php echo $idDivGeral; ?> > ul > li").length == 0) {
                $('div#<?php echo $idDivGeral; ?> .wizard_mais').click();
            }

            wizardTravaExpressaoLast('<?php echo $idDivGeral; ?>');

            $('#<?php echo $idDivGeral . $opcaoClick; ?>').click();
        });
    </script>
    <?php
}

function wizardHtmlLI($idDivGeral, $idx, $row, $vetWizardTabela) {
    global $vetWizardOperador, $vetWizardExpressao, $vetRsWizardCampo, $vetIdtWizardParametro;

    $idtTabela = $vetIdtWizardParametro[$row['codigo']];

    $html = '';
    $html .= '<li>';

    $html .= '<span class="wizard_ordem"><img src="imagens/bt_move.png" title="Ordenar as cláusulas" /></span>';

    $html .= '<span class="wizard_parentese_ant">';
    $html .= criar_combo_vet(Array('(' => '('), $idDivGeral . '[' . $idx . '][parentese_ant]', $row['parentese_ant'], ' ', '', '', true);
    $html .= '</span>';

    $html .= '<span class="wizard_tabela">';
    $html .= criar_combo_vet($vetWizardTabela, $idDivGeral . '[' . $idx . '][tabela]', $idtTabela, ' ', '', '', true);
    $html .= '</span>';

    $html .= '<span class="wizard_campo">';
    $html .= criar_combo_rs($vetRsWizardCampo[$idtTabela], $idDivGeral . '[' . $idx . '][campo]', $row['codigo'], ' ', '', '', '', true, '', 'Não existe informação no sistema', Array('tipo'));
    $html .= '</span>';

    $html .= '<span class="wizard_operador">';
    $html .= criar_combo_vet($vetWizardOperador, $idDivGeral . '[' . $idx . '][operador]', $row['condicao'], ' ', '', '', true);
    $html .= '</span>';

    $html .= '<input type="text" class="Texto wizard_valor" name="' . $idDivGeral . '[' . $idx . '][valor]" value="' . $row['valor'] . '" />';

    $html .= '<span class="wizard_parentese_dep">';
    $html .= criar_combo_vet(Array(')' => ')'), $idDivGeral . '[' . $idx . '][parentese_dep]', $row['parentese_dep'], ' ', '', '', true);
    $html .= '</span>';

    $html .= '<span class="wizard_expressao">';
    $html .= criar_combo_vet($vetWizardExpressao, $idDivGeral . '[' . $idx . '][expressao]', $row['operador'], ' ', '', '', true);
    $html .= '</span>';

    $html .= '<span class="wizard_menos" title="Remover este item de condição">-</span>';
    $html .= '</li>';

    return $html;
}

function checa_ponto_formulario($idt_filho, $campo_idt_pai, $tab_filho, $tab_pai, $acao) {
    // neutralizada por Luiz
    $sistema_origem = DecideSistema();
    $vetGrupo = Array();
    if ($sistema_origem == 'GEC') {
        // controla peso
    } else {
        return true;
    }


    $sql = '';
    $sql .= ' select p.idt, p.qtd_pontos';
    $sql .= ' from ' . $tab_filho . ' f';
    $sql .= ' inner join ' . $tab_pai . ' p on f.' . $campo_idt_pai . ' = p.idt';
    $sql .= ' where f.idt = ' . null($idt_filho);
    $rs = execsql($sql);
    $idt_pai = $rs->data[0]['idt'];
    $qtd_pontos = $rs->data[0]['qtd_pontos'];


    $sql = " delete from {$tab_filho} where valido = 'N' and {$campo_idt_pai} = " . null($idt_pai);
    execsql($sql);

    // p($sql); 


    $sql = '';
    $sql .= ' select sum(qtd_pontos) as tot';
    $sql .= ' from ' . $tab_filho;
    $sql .= ' where ' . $campo_idt_pai . ' = ' . null($idt_pai);
    $rs = execsql($sql);
    $qtd_pontos -= Troca($rs->data[0][0], '', 0);

    if ($qtd_pontos != 0) {
        if ($tab_filho == 'grc_formulario_resposta') {
            $codigow = 999999;
        } else {
            $codigow = aspa('Falta distribuir pontos');
        }
        $codigow = 999999;
        $sql = '';
        $sql .= ' insert into ' . $tab_filho . ' (' . $campo_idt_pai . ',  codigo, descricao,  qtd_pontos, valido) values (';
        $sql .= null($idt_pai) . ", $codigow, 'Falta distribuir o valor do pontos informado', " . null($qtd_pontos) . ", 'N')";
        execsql($sql);

        //p($sql); 
    }
}

function checa_ponto_formularioEXC($idt_filho, $campo_idt_pai, $tab_filho, $tab_pai, $acao) {
    // neutralizada por Luiz
    $sistema_origem = DecideSistema();
    $vetGrupo = Array();
    if ($sistema_origem == 'GEC') {
        // controla peso
    } else {
        return true;
    }


    $sql = '';
    $sql .= ' select p.idt, p.qtd_pontos';
    $sql .= ' from ' . $tab_filho . ' f';
    $sql .= ' inner join ' . $tab_pai . ' p on f.' . $campo_idt_pai . ' = p.idt';
    $sql .= ' where f.idt = ' . null($idt_filho);
    $rs = execsql($sql);
    $idt_pai = $rs->data[0]['idt'];
    $qtd_pontos = $rs->data[0]['qtd_pontos'];


    $sql = " delete from {$tab_filho} where valido = 'N' and {$campo_idt_pai} = " . null($idt_pai);
    execsql($sql);

    // p($sql); 


    $sql = '';
    $sql .= ' select sum(qtd_pontos) as tot';
    $sql .= ' from ' . $tab_filho;
    $sql .= ' where ' . $campo_idt_pai . ' = ' . null($idt_pai);
    $sql .= '   and idt = ' . null($idt_filho);
    $rs = execsql($sql);
    $qtd_pontos -= Troca($rs->data[0][0], '', 0);

    if ($qtd_pontos != 0) {
        if ($tab_filho == 'grc_formulario_resposta') {
            $codigow = 999999;
        } else {
            $codigow = aspa('Falta distribuir pontos');
        }
        $codigow = 999999;
        $sql = '';
        $sql .= ' insert into ' . $tab_filho . ' (' . $campo_idt_pai . ',  codigo, descricao,  qtd_pontos, valido) values (';
        $sql .= null($idt_pai) . ", $codigow, 'Falta distribuir o valor do pontos informado', " . null($qtd_pontos) . ", 'N')";
        execsql($sql);

        //p($sql); 
    }
}

function bloqueia_row_formulario($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['valido'] == 'N') {
        $barra_alt_ap_row = false;
        $barra_con_ap_row = false;
        $barra_exc_ap_row = false;
    }
}

function bloqueia_row_grc_produto_insumo($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['idt_produto_profissional'] != '') {
        $barra_alt_ap_row = $row['codigo'] == '70004';
        $barra_con_ap_row = true;
        $barra_exc_ap_row = false;
    }
}

function bloqueia_row_grc_evento_insumo($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['idt_profissional'] != '') {
        $barra_alt_ap_row = false;
        $barra_con_ap_row = true;
        $barra_exc_ap_row = false;

        if (!($row['codigo'] == '70001' || $row['codigo'] == '71001')) {
            $barra_alt_ap_row = true;
        }
    }
}

/**
 * Verifica se o JOB de Processos automaticos foi executado hoje, senão executa o JOB
 * @access public
 * */
function verifica_job() {
    $sql = '';
    $sql .= " select dtc_registro from plu_log_sistema where nom_tabela = 'executa_job'";
    $sql .= ' order by id_log_sistema desc limit 1';
    $rs = execsql($sql);

    $data = substr(trata_data($rs->data[0][0]), 0, 10);
    $hoje = date("d/m/Y");

    if ($data != $hoje) {
        $fim = 'N';
        require_once('executa_job.php');
    }
}

function grc_atendimento_produto_per($row, $session_cod) {
    $title = 'Excluir o Registro';
    $mensagem = trata_aspa('Deseja excluir o registro "' . $row['grc_pp_descricao'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickExcDireta(\"grc_atendimento_produto\", \"idt\", \"{$row['idt']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function grc_avaliacao_devolutiva_produto_per($row, $session_cod) {
    $title = 'Excluir o Registro';
    $mensagem = trata_aspa('Deseja excluir o registro "' . $row['grc_pp_descricao'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickPendenciaAtivo(\"grc_avaliacao_devolutiva_produto\", \"idt\", \"{$row['idt_avaliacao_devolutiva_produto']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function grc_atendimento_tema_tratado($row, $session_cod) {
    $title = 'Excluir o Registro';
    $mensagem = trata_aspa('Deseja excluir o registro "' . $row['grc_tema'] . ' - ' . $row['grc_sub_tema'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickExcDireta(\"grc_atendimento_tema\", \"idt\", \"{$row['idt']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function grc_atendimento_tema($row, $session_cod) {
    $title = 'Excluir o Registro';
    $mensagem = trata_aspa('Deseja excluir o registro "' . $row['grc_tema'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickExcDireta(\"grc_atendimento_tema\", \"idt\", \"{$row['idt']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function grc_atendimento_pessoa_representante($row) {
    global $barra_exc_ap_row;

    if ($row['tipo_relacao'] == 'L') {
        $barra_exc_ap_row = false;
    }
}

function trata_row_grc_evento_receita($row) {
    global $barra_alt_ap_row, $barra_exc_ap_row;

    if ($row['codigo'] == 'evento_insc') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
    }
}

function trata_row_grc_evento_publicacao($row) {
    global $barra_alt_ap_row, $barra_exc_ap_row, $barra_con_ap_row;

    $barra_exc_ap_row = false;
    $barra_alt_ap_row = false;

    if ($row['situacao'] == 'CD') {
        $barra_exc_ap_row = true;
        $barra_alt_ap_row = true;
    }

    /*
      if ($row['ativo'] == 'S' && $row['situacao'] == 'AP' && $row['tipo_acao'] == 'P') {
      $sql = '';
      $sql .= ' select idt';
      $sql .= ' from grc_evento_publicacao';
      $sql .= ' where idt_evento = ' . null($row['idt_evento']);
      $sql .= " and ativo = 'S'";
      $sql .= " and tipo_acao = 'D'";
      $sql .= " and situacao <> 'CA'";
      $rs = execsql($sql);

      if ($rs->rows == 0) {
      $barra_alt_ap_row = true;
      }
      }
     * 
     */

    if ($row['ativo'] == 'S' && ($row['situacao'] == 'GP' || $row['situacao'] == 'CG' || $row['situacao'] == 'DI')) {
        $barra_alt_ap_row = true;
    }
}

function trata_row_grc_evento_publicacao_voucher_registro($row) {
    global $barra_alt_ap_row, $barra_exc_ap_row;

    if ($row['dt_utilizacao'] == '') {
        $barra_alt_ap_row = true;
    } else {
        $barra_alt_ap_row = false;
    }
}

function trata_row_grc_evento_participante_pagamento(&$row) {
    global $barra_alt_ap_row, $barra_exc_ap_row, $barra_con_ap_row;

    if ($row['rm_idmov'] == '') {
        $barra_alt_ap_row = true;
    }

    if ($row['operacao'] == 'D') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;

        if ($row['np_descricao'] == '') {
            $row['np_descricao'] = 'Devolução';
        }
    }

    if ($row['so_consulta'] == 'S') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
        $barra_con_ap_row = false;
    }
}

function trata_row_grc_evento_participante_pagamento_d(&$row) {
    global $barra_alt_ap_row, $barra_exc_ap_row, $barra_con_ap_row;

    if ($row['operacao'] == 'D') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;

        if ($row['np_descricao'] == '') {
            $row['np_descricao'] = 'Devolução';
        }
    }

    if ($row['so_consulta'] == 'S') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
        $barra_con_ap_row = false;
    }
}

function trata_row_grc_evento_participante($row) {
    global $barra_alt_ap_row;

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_participante_pagamento';
    $sql .= ' where idt_atendimento = ' . $row['idt'];
    $sql .= " and estornado <> 'S'";
    $sql .= " and operacao = 'C'";
    $sql .= ' and idt_aditivo_participante is null';
    $sql .= ' and rm_idmov is null';
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        $barra_alt_ap_row = true;
    }
}

/**
 * Calcula o valor do Aditamento para o Cliente
 * @access public
 * @return tipo
 * @param int $idt_aditivo <p>
 * IDT do Aditamento
 * </p>
 * @param int $valor_aditivo <p>
 * Valor do Aditamento
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function calculaValorAditivoParticipante($idt_aditivo, $valor_aditivo, $trata_erro = true) {
    if (!is_numeric($valor_aditivo)) {
        $valor_aditivo = 0;
    }

    $sql = '';
    $sql .= ' select ord.idt_evento, e.contrapartida_sgtec';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo cca';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = cca.idt_contratar_credenciado';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
    $sql .= ' where cca.idt = ' . null($idt_aditivo);
    $rs = execsqlNomeCol($sql, $trata_erro);
    $rowDados = $rs->data[0];

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante';
    $sql .= ' where idt_aditivo = ' . null($idt_aditivo);
    $rs = execsql($sql, $trata_erro);
    $quantidade_participante = $rs->rows;

    if ($quantidade_participante == '') {
        $quantidade_participante = 0;
    }

    if ($quantidade_participante == 0) {
        $cotacao = 0;
    } else {
        $cotacao = $valor_aditivo / $quantidade_participante;
    }

    foreach ($rs->data as $row_ep) {
        if ($rowDados['contrapartida_sgtec'] == '') {
            $pag_real = $cotacao;
        } else {
            $pag_real = round($cotacao * $rowDados['contrapartida_sgtec'] / 100, 2);
        }

        $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante set vl_aditivo = ' . null($pag_real);
        $sql .= ' where idt = ' . null($row_ep['idt']);
        execsql($sql, $trata_erro);
    }
}

/**
 * Valida o registro de Aditamento
 * @access public
 * @return string Mensagem de erro na validação
 * @param int $idt_aditivo <p>
 * IDT do Aditamento
 * </p>
 * @param int $idt_aditivo_participante [opcional] <p>
 * IDT do Aditamento Participante
 * </p>
 * */
function gec_contratar_credenciado_aditivo_dep($idt_aditivo, $idt_aditivo_participante = '') {
    $trata_erro = false;
    $msg = '';
    $vetErro = Array();

    $sql = '';
    $sql .= ' select ap.idt, ap.vl_aditivo, sum(pp.valor_pagamento) as vl_pago,';
    $sql .= " concat_ws(' - ', a.protocolo, o.razao_social, o.cnpj) as empreendimento";
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante ap';
    $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ap.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = ap.idt_atendimento";
    $sql .= ' left outer join grc_evento_participante_pagamento pp on pp.idt_aditivo_participante = ap.idt';
    $sql .= " and pp.estornado <> 'S' ";
    $sql .= " and pp.operacao = 'C'";
    $sql .= ' where ap.idt_aditivo = ' . null($idt_aditivo);

    if ($idt_aditivo_participante != '') {
        $sql .= ' and ap.idt = ' . null($idt_aditivo_participante);
    }

    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        if ($row['vl_aditivo'] == '') {
            $row['vl_aditivo'] = 0;
        }

        if ($row['vl_pago'] == '') {
            $row['vl_pago'] = 0;
        }

        $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante set vl_tot_pagamento = ' . null($row['vl_pago']);
        $sql .= ' where idt = ' . null($row['idt']);
        execsql($sql, $trata_erro);

        if ($row['vl_aditivo'] != $row['vl_pago']) {
            $vetErro[] = $row['empreendimento'];
        }
    }

    if (count($vetErro) > 0) {
        $msg .= "Os clientes a baixos não estão com o Valor do Aditamento registrado em Pagamento!\n\n";
        $msg .= implode("\n", $vetErro);
    }

    return $msg;
}

function fbp_grc_plano_facil_ferramenta($row, $session_cod) {
    $title = 'Excluir o Registro';
    $mensagem = trata_aspa('Deseja excluir o registro "' . $row['ferramenta'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickExcDireta(\"grc_plano_facil_ferramenta\", \"idt\", \"{$row['idt']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

/**
 * Inclui ou alterar o registro da tabela informada
 * @access public
 * @return int IDT do Registro
 * @param string $tabela <p>
 * Nome da Tabela do GEC
 * </p>
 * @param string $where <p>
 * Where do SQL para verificação se o registro já existe.
 * </p>
 * @param array $row <p>
 * Array com os dados do registro
 * </p>
 * @param array $vetCampoExtra <p>
 * Array com os dados extras do registro
 * </p>
 * @param array $vetCampoRemoveUpdate <p>
 * Array com os campos que vão atualizados no update
 * </p>
 * */
function sincronizaGecEntidadeAcao($tabela, $where, $row, $vetCampoExtra, $vetCampoRemoveUpdate = Array()) {
    set_time_limit(60);
    $tabela = db_pir_gec . $tabela;

    $vetCampo = Array();

    foreach ($row as $key => $value) {
        if (!is_array($value)) {
            $vetCampo[$key] = aspa($value);
        }
    }

    foreach ($vetCampoExtra as $key => $value) {
        $vetCampo[$key] = aspa($value);
    }

    if ($where === false) {
        $idt = '';
    } else {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . $tabela;
        $sql .= ' where ' . $where;
        $rs = execsql($sql);
        $idt = $rs->data[0][0];
    }

    if ($idt == '') {
        $sql = 'insert into ' . $tabela . ' (' . implode(', ', array_keys($vetCampo)) . ') values (' . implode(', ', $vetCampo) . ')';
        execsql($sql);
        $idt = lastInsertId();
    } else {
        $tmp = Array();
        foreach ($vetCampo as $key => $value) {
            if (!in_array($key, $vetCampoRemoveUpdate)) {
                $tmp[] = $key . ' = ' . $value;
            }
        }

        $sql = 'update ' . $tabela . ' set ' . implode(', ', $tmp) . ' where idt = ' . null($idt);
        execsql($sql);
    }

    return $idt;
}

/**
 * Cria ou Altera um registro de entidade no GEC<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return int Retorna o IDT da Entidade
 * @param array $dados <p>
 * Array multidimensão dos dados do registro no formato:<br />
 * Ver definição do array da variavel $dados ($dadosModelo)<br />
 * <b>Observação</b><br />
 * Os campos devem ser passados no formado do mysql
 * Os campos de datas tem que ser informados no formato yyyy-mm-dd hh:mm:ss<br />
 * Os campo decimal tem que ser informados no formato 9999.99<br />
 * </p>
 * @param array $vetRetorno <p>
 * Contem dados de retorno para ações posteriores.
 * </p>
 * */
function sincronizaGecEntidade($dados, &$vetRetorno) {
    global $vetSistemaUtiliza;

    //Exemplo do $dados
    $dadosModelo = Array(
        'campo tabela' => 'valor',
        'tabela 1' => Array(
            Array(
                'campo tabela' => 'valor',
                'tabela N' => Array(
                    Array(
                        'campo tabela' => 'valor',
                    ),
                    Array(
                        'campo tabela' => 'valor',
                    ),
                ),
            ),
        ),
    );

    $tipo_entidade = $dados['tipo_entidade'];
    $cpfcnpj = $dados['codigo'];
    $nirf = $dados['gec_entidade_organizacao'][0]['nirf'];
    $dap = $dados['gec_entidade_organizacao'][0]['dap'];
    $rmp = $dados['gec_entidade_organizacao'][0]['rmp'];
    $ie = $dados['gec_entidade_organizacao'][0]['ie_prod_rural'];
    $sicab_codigo = $dados['gec_entidade_organizacao'][0]['sicab_codigo'];

    $idt_entidade = idtEntidadeGEC($tipo_entidade, $cpfcnpj, $nirf, $dap, $rmp, $ie, $sicab_codigo);

    $where = '';
    $where .= ' idt = ' . null($idt_entidade);
    $where .= " and reg_situacao = 'A'";

    $vetCampoExtra = Array();

    $vetCampoRemoveUpdate = Array(
        'codigo_siacweb',
    );

    $idt_entidade = sincronizaGecEntidadeAcao('gec_entidade', $where, $dados, $vetCampoExtra, $vetCampoRemoveUpdate);

    $sql = 'update ' . db_pir_gec . 'gec_entidade set dt_ult_alteracao = now() where idt = ' . null($idt_entidade);
    execsql($sql);

    $tabela_n1 = 'gec_entidade_arquivo_interesse';
    if (is_array($dados[$tabela_n1])) {
        $sql = 'select arquivo from ' . db_pir_gec . $tabela_n1 . ' where idt_entidade = ' . null($idt_entidade);
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetRetorno['arqDeletar'][] = str_replace('/', DIRECTORY_SEPARATOR, $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/' . $tabela_n1 . '/' . $rowt['arquivo']);
        }

        $sql = 'delete from ' . db_pir_gec . $tabela_n1 . ' where idt_entidade = ' . null($idt_entidade);
        execsql($sql);

        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = false;

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);
        }
    }

    $tabela_n1 = 'gec_entidade_endereco';
    if (is_array($dados[$tabela_n1])) {
        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = '';
            $where .= ' idt_entidade = ' . null($idt_entidade);
            $where .= ' and idt_entidade_endereco_tipo = ' . null($row_n1['idt_entidade_endereco_tipo']);

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);

            $tabela_n2 = 'gec_entidade_comunicacao';
            if (is_array($row_n1[$tabela_n2])) {
                foreach ($row_n1[$tabela_n2] as $row_n2) {
                    $where = '';
                    $where .= ' idt_entidade = ' . null($idt_entidade);
                    $where .= ' and origem = ' . aspa($row_n2['origem']);

                    $vetCampoExtra = Array(
                        'idt_entidade' => $idt_entidade,
                        'idt_endereco' => $idt_n1,
                    );

                    $idt_n2 = sincronizaGecEntidadeAcao($tabela_n2, $where, $row_n2, $vetCampoExtra);
                }
            }

            $tabela_n2 = 'gec_entidade_endereco_estrutura';
            if (is_array($row_n1[$tabela_n2])) {
                foreach ($row_n1[$tabela_n2] as $row_n2) {
                    $where = '';
                    $where .= ' idt_endereco = ' . null($idt_n1);
                    $where .= ' and codigo = ' . aspa($row_n2['codigo']);

                    $vetCampoExtra = Array(
                        'idt_entidade' => $idt_entidade,
                        'idt_endereco' => $idt_n1,
                    );

                    $idt_n2 = sincronizaGecEntidadeAcao($tabela_n2, $where, $row_n2, $vetCampoExtra);
                }
            }
        }
    }

    $tabela_n1 = 'gec_entidade_organizacao';
    if (is_array($dados[$tabela_n1])) {
        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = '';
            $where .= ' idt_entidade = ' . null($idt_entidade);

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);

            $tabela_n2 = 'gec_entidade_cnae';
            if (is_array($row_n1[$tabela_n2])) {
                $sql = 'delete from ' . db_pir_gec . $tabela_n2 . ' where idt_entidade_organizacao = ' . null($idt_n1);
                execsql($sql);

                foreach ($row_n1[$tabela_n2] as $row_n2) {
                    $where = false;

                    $vetCampoExtra = Array(
                        'idt_entidade' => $idt_entidade,
                        'idt_entidade_organizacao' => $idt_n1,
                    );

                    $idt_n2 = sincronizaGecEntidadeAcao($tabela_n2, $where, $row_n2, $vetCampoExtra);
                }
            }
        }
    }

    $tabela_n1 = 'gec_entidade_pessoa';
    if (is_array($dados[$tabela_n1])) {
        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = '';
            $where .= ' idt_entidade = ' . null($idt_entidade);

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);

            $tabela_n2 = 'gec_entidade_pessoa_tipo_deficiencia';
            if (is_array($row_n1[$tabela_n2])) {
                $sql = 'delete from ' . db_pir_gec . $tabela_n2 . ' where idt = ' . null($idt_n1);
                execsql($sql);

                foreach ($row_n1[$tabela_n2] as $row_n2) {
                    $where = false;

                    $vetCampoExtra = Array(
                        'idt' => $idt_n1,
                    );

                    $idt_n2 = sincronizaGecEntidadeAcao($tabela_n2, $where, $row_n2, $vetCampoExtra);
                }
            }
        }
    }

    $tabela_n1 = 'gec_entidade_produto_interesse';
    if (is_array($dados[$tabela_n1])) {
        $sql = 'delete from ' . db_pir_gec . $tabela_n1 . ' where idt_entidade = ' . null($idt_entidade);
        execsql($sql);

        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = false;

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);
        }
    }

    $tabela_n1 = 'gec_entidade_tema_interesse';
    if (is_array($dados[$tabela_n1])) {
        $sql = 'delete from ' . db_pir_gec . $tabela_n1 . ' where idt_entidade = ' . null($idt_entidade);
        execsql($sql);

        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = false;

            $vetCampoExtra = Array(
                'idt_entidade' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);
        }
    }

    $tabela_n1 = 'gec_entidade_x_tipo_informacao';
    if (is_array($dados[$tabela_n1])) {
        $sql = 'delete from ' . db_pir_gec . $tabela_n1 . ' where idt = ' . null($idt_entidade);
        execsql($sql);

        foreach ($dados[$tabela_n1] as $row_n1) {
            $where = false;

            $vetCampoExtra = Array(
                'idt' => $idt_entidade,
            );

            $idt_n1 = sincronizaGecEntidadeAcao($tabela_n1, $where, $row_n1, $vetCampoExtra);
        }
    }

    return $idt_entidade;
}

function func_grc_tema_subtema(&$row) {
    global $trHtml;

    $row['descricao'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $row['nivel']) . $row['descricao'];

    $display_none = 'N' . $row['nivel'] . ' ';

    $data = '';
    $data .= ' data-nivel="' . $row['nivel'] . '"';
    $data .= ' data-aberto="S"';

    $vetCod = explode('.', $row['codigo']);

    foreach ($vetCod as $idx => $cod) {
        $data .= ' data-cod' . $idx . '="' . $cod . '"';
    }

    $trHtml = str_replace("class='", $data . " class='{$display_none}", $trHtml);
}

/**
 * Sincroniza Atendimento com GEC
 * @access public
 * @param int $idt_atendimento <p>
 * IDT do Atendimento
 * </p>
 * @param string $lstIdtPessoa [opcional] <p>
 * Lista dos IDTs do grc_atendimento_pessoa separado por vilgula
 * </p>
 * */
function sincronizaAtendimentoGEC($idt_atendimento, $lstIdtPessoa = '') {
    global $vetSistemaUtiliza, $microtime;

    $idtEntidadePes = '';

    //grc_atendimento_organizacao
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);

    $vetEntidadeOrg = Array();
    $vetEntidadePessPar = Array();

    foreach ($rs->data as $row) {
        $idt_entidade = '';

        if ($row['modificado'] == 'S' || $row['representa'] == 'S') {
            $vetRetorno = Array();

            if ($row['idt_tipo_empreendimento'] == 7 || $row['idt_tipo_empreendimento'] == 13) {
                $tipo_registro = 'PR';
            } else {
                $tipo_registro = 'OP';
            }

            //grc_atendimento_organizacao_cnae
            $vetCNAE = Array();

            if ($row['idt_cnae_principal'] != '') {
                $vetCNAE[$row['idt_cnae_principal']] = Array(
                    'cnae' => $row['idt_cnae_principal'],
                    'principal' => 'S',
                );
            }

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao_cnae';
            $sql .= ' where idt_atendimento_organizacao = ' . null($row['idt']);
            $rst = execsql($sql);

            foreach ($rst->data as $rowt) {
                if ($vetCNAE[$rowt['cnae']] == '') {
                    $vetCNAE[$rowt['cnae']] = Array(
                        'cnae' => $rowt['cnae'],
                        'principal' => 'N',
                    );
                }
            }

            $dadosGEC = Array(
                'codigo' => $row['cnpj'],
                'descricao' => $row['razao_social'],
                'ativo' => 'S',
                'tipo_entidade' => 'O',
                'idt_entidade_classe' => 45,
                'resumo' => $row['nome_fantasia'],
                'codigo_siacweb' => $row['codigo_siacweb_e'],
                'idt_situacao' => 2,
                'natureza' => 'CLI.FOR',
                'codigo_prod_rural' => $row['codigo_prod_rural'],
                'receber_informacao' => $row['receber_informacao_e'],
                'idt_entidade_tipo_emp' => $row['idt_tipo_empreendimento'],
                'tipo_registro' => $tipo_registro,
                'siacweb_situacao' => $row['siacweb_situacao_e'],
                'pa_senha' => $row['pa_senha_e'],
                'pa_idfacebook' => $row['pa_idfacebook_e'],
                'gec_entidade_organizacao' => Array(
                    Array(
                        //'inscricao_estadual' => $row[''],
                        //'inscricao_municipal' => $row[''],
                        //'registro_junta' => $row[''],
                        //'data_registro' => $row[''],
                        'ativo' => 'S',
                        'idt_porte' => $row['idt_porte'],
                        //'idt_tipo' => $row[''],
                        //'idt_natureza_juridica' => $row[''],
                        //'idt_faturamento' => $row[''],
                        //'faturamento' => $row[''],
                        'qt_funcionarios' => $row['pessoas_ocupadas'],
                        'data_inicio_atividade' => $row['data_abertura'],
                        'tamanho_propriedade' => $row['tamanho_propriedade'],
                        'dap' => $row['dap'],
                        'nirf' => $row['nirf'],
                        'rmp' => $row['rmp'],
                        'ie_prod_rural' => $row['ie_prod_rural'],
                        'sicab_codigo' => $row['sicab_codigo'],
                        'sicab_dt_validade' => $row['sicab_dt_validade'],
                        'data_fim_atividade' => $row['data_fim_atividade'],
                        'simples_nacional' => $row['simples_nacional'],
                        'idt_entidade_setor' => $row['idt_setor'],
                        'gec_entidade_cnae' => $vetCNAE,
                    ),
                ),
                'gec_entidade_endereco' => Array(
                    Array(
                        'logradouro' => $row['logradouro_endereco_e'],
                        'logradouro_numero' => $row['logradouro_numero_e'],
                        'logradouro_complemento' => $row['logradouro_complemento_e'],
                        'logradouro_bairro' => $row['logradouro_bairro_e'],
                        'logradouro_municipio' => $row['logradouro_cidade_e'],
                        'logradouro_estado' => $row['logradouro_estado_e'],
                        'logradouro_pais' => $row['logradouro_pais_e'],
                        'logradouro_referencia' => $row['logradouro_referencia_e'],
                        'logradouro_cep' => $row['logradouro_cep_e'],
                        'logradouro_codbairro' => $row['logradouro_codbairro_e'],
                        'logradouro_codcid' => $row['logradouro_codcid_e'],
                        'logradouro_codest' => $row['logradouro_codest_e'],
                        'logradouro_codpais' => $row['logradouro_codpais_e'],
                        'cep' => $row['logradouro_cep_e'],
                        'idt_entidade_endereco_tipo' => 8,
                        'ativo' => 'S',
                        'gec_entidade_comunicacao' => Array(
                            Array(
                                'origem' => 'ATENDIMENTO PRINCIPAL',
                                'telefone_1' => $row['telefone_comercial_e'],
                                'telefone_2' => $row['telefone_celular_e'],
                                'email_1' => $row['email_e'],
                                'sms_1' => $row['sms_e'],
                                'www_1' => $row['site_url'],
                            ),
                        ),
                    ),
                ),
            );

            //grc_atendimento_organizacao_tipo_informacao
            $sql = '';
            $sql .= ' select idt_tipo_informacao_e';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao';
            $sql .= ' where idt = ' . null($row['idt']);
            $rst = execsql($sql);

            $vetTmp = Array();

            foreach ($rst->data as $rowt) {
                $vetTmp[] = Array(
                    'idt_tipo_informacao' => $rowt['idt_tipo_informacao_e'],
                );
            }

            $dadosGEC['gec_entidade_x_tipo_informacao'] = $vetTmp;

            $idt_entidade = sincronizaGecEntidade($dadosGEC, $vetRetorno);
        }

        if ($row['desvincular'] == 'S') {
            if ($idt_entidade == '') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade';
                $sql .= ' where codigo = ' . aspa($row['cnpj']);
                $sql .= " and reg_situacao = 'A'";
                $rst = execsql($sql);
                $idt_entidade = $rst->data[0][0];
            }

            if ($idt_entidade != '') {
                $vetEntidadeOrg[$idt_entidade] = Array(
                    'situacao' => 'D',
                    'idt' => $row['idt'],
                    'codigo_siacweb' => $row['codigo_siacweb_e'],
                    'representa_codcargcli' => $row['representa_codcargcli'],
                );
            }
        } else if ($row['representa'] == 'S') {
            $vetEntidadeOrg[$idt_entidade] = Array(
                'situacao' => 'R',
                'idt' => $row['idt'],
                'codigo_siacweb' => $row['codigo_siacweb_e'],
                'representa_codcargcli' => $row['representa_codcargcli'],
            );
        } else if ($row['modificado'] == 'S') {
            $vetEntidadeOrg[$idt_entidade] = Array(
                'situacao' => 'M',
                'idt' => $row['idt'],
                'codigo_siacweb' => $row['codigo_siacweb_e'],
                'representa_codcargcli' => $row['representa_codcargcli'],
            );
        }
    }

    //Pessoa
    $vetRetorno = Array();

    //grc_atendimento_pessoa
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);

    if ($lstIdtPessoa != '') {
        $sql .= ' and idt in (' . $lstIdtPessoa . ')';
    }

    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        //grc_atendimento_pessoa_tipo_deficiencia
        $sql = '';
        $sql .= ' select idt_tipo_deficiencia';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_deficiencia';
        $sql .= ' where idt = ' . null($row['idt']);
        $rst = execsql($sql);

        $vetTipoDeficiencia = Array();

        foreach ($rst->data as $rowt) {
            $vetTipoDeficiencia[] = Array(
                'idt_tipo_deficiencia' => $rowt['idt_tipo_deficiencia'],
            );
        }

        $dadosGEC = Array(
            'codigo' => $row['cpf'],
            'descricao' => $row['nome'],
            'ativo' => 'S',
            'tipo_entidade' => 'P',
            'idt_entidade_classe' => 67,
            'resumo' => truncaString($row['nome'], 80),
            'codigo_siacweb' => $row['codigo_siacweb'],
            'idt_situacao' => 2,
            'natureza' => 'CLI',
            'receber_informacao' => $row['receber_informacao'],
            'siacweb_situacao' => $row['siacweb_situacao'],
            'pa_senha' => $row['pa_senha'],
            'pa_idfacebook' => $row['pa_idfacebook'],
            'gec_entidade_pessoa' => Array(
                Array(
                    'ativo' => 'S',
                    'data_nascimento' => $row['data_nascimento'],
                    'nome_pai' => $row['nome_pai'],
                    'nome_mae' => $row['nome_mae'],
                    'idt_ativeconpf' => $row['idt_ativeconpf'],
                    'idt_profissao' => $row['idt_profissao'],
                    'idt_estado_civil' => $row['idt_estado_civil'],
                    'idt_cor_pele' => $row['idt_cor_pele'],
                    'idt_religiao' => $row['idt_religiao'],
                    'idt_destreza' => $row['idt_destreza'],
                    'idt_sexo' => $row['idt_sexo'],
                    'necessidade_especial' => $row['necessidade_especial'],
                    'idt_escolaridade' => $row['idt_escolaridade'],
                    'nome_tratamento' => $row['nome_tratamento'],
                    'idt_tipo_deficiencia' => $row[''],
                    'idt_segmentacao' => $row['idt_segmentacao'],
                    'idt_subsegmentacao' => $row['idt_subsegmentacao'],
                    'idt_programa_fidelidade' => $row['idt_programa_fidelidade'],
                    'potencial_personagem' => $row['potencial_personagem'],
                    'gec_entidade_pessoa_tipo_deficiencia' => $vetTipoDeficiencia,
                ),
            ),
            'gec_entidade_endereco' => Array(
                Array(
                    'logradouro' => $row['logradouro_endereco'],
                    'logradouro_numero' => $row['logradouro_numero'],
                    'logradouro_complemento' => $row['logradouro_complemento'],
                    'logradouro_bairro' => $row['logradouro_bairro'],
                    'logradouro_municipio' => $row['logradouro_cidade'],
                    'logradouro_estado' => $row['logradouro_estado'],
                    'logradouro_pais' => $row['logradouro_pais'],
                    'logradouro_referencia' => $row['logradouro_referencia'],
                    'logradouro_cep' => $row['logradouro_cep'],
                    'logradouro_codbairro' => $row['logradouro_codbairro'],
                    'logradouro_codcid' => $row['logradouro_codcid'],
                    'logradouro_codest' => $row['logradouro_codest'],
                    'logradouro_codpais' => $row['logradouro_codpais'],
                    'cep' => $row['logradouro_cep'],
                    'idt_entidade_endereco_tipo' => 8,
                    'ativo' => 'S',
                    'gec_entidade_comunicacao' => Array(
                        Array(
                            'origem' => 'ATENDIMENTO PRINCIPAL',
                            'telefone_1' => $row['telefone_residencial'],
                            'telefone_2' => $row['telefone_celular'],
                            'email_1' => $row['email'],
                            'sms_1' => $row['sms'],
                        ),
                        Array(
                            'origem' => 'ATENDIMENTO RECADO',
                            'telefone_1' => $row['telefone_recado'],
                        ),
                    ),
                ),
            ),
        );

        //grc_atendimento_pessoa_arquivo_interesse
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_arquivo_interesse';
        $sql .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
        $rst = execsql($sql);

        $vetTmp = Array();

        foreach ($rst->data as $rowt) {
            $vetPrefixoArq = explode('_', $rowt['arquivo']);
            $PrefixoArq = '';
            $PrefixoArq .= $vetPrefixoArq[0] . '_';
            $PrefixoArq .= $vetPrefixoArq[1] . '_';
            $PrefixoArq .= $vetPrefixoArq[2] . '_';
            $arq_novo = GerarStr() . '_arquivo_' . $microtime . '_' . substr($rowt['arquivo'], strlen($PrefixoArq));

            $vetRetorno['arqCopia'][] = Array(
                'de' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_atendimento_pessoa_arquivo_interesse/' . $rowt['arquivo']),
                'para' => str_replace('/', DIRECTORY_SEPARATOR, $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_entidade_arquivo_interesse/' . $arq_novo),
            );

            $vetTmp[] = Array(
                'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
                'data_registro' => $rowt['data_registro'],
                'titulo' => $rowt['titulo'],
                'arquivo' => $arq_novo,
            );
        }

        $dadosGEC['gec_entidade_arquivo_interesse'] = $vetTmp;

        //grc_atendimento_pessoa_produto_interesse
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_produto_interesse';
        $sql .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
        $rst = execsql($sql);

        $vetTmp = Array();

        foreach ($rst->data as $rowt) {
            $vetTmp[] = Array(
                'idt_produto' => $rowt['idt_produto'],
                'observacao' => $rowt['observacao'],
                'data_registro' => $rowt['data_registro'],
                'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
            );
        }

        $dadosGEC['gec_entidade_produto_interesse'] = $vetTmp;

        //grc_atendimento_pessoa_tema_interesse
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_tema_interesse';
        $sql .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
        $rst = execsql($sql);

        $vetTmp = Array();

        foreach ($rst->data as $rowt) {
            $vetTmp[] = Array(
                'idt_tema' => $rowt['idt_tema'],
                'idt_subtema' => $rowt['idt_subtema'],
                'observacao' => $rowt['observacao'],
                'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
                'data_registro' => $rowt['data_registro'],
            );
        }

        $dadosGEC['gec_entidade_tema_interesse'] = $vetTmp;

        //grc_atendimento_pessoa_tipo_informacao
        $sql = '';
        $sql .= ' select idt_tipo_informacao';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_informacao';
        $sql .= ' where idt = ' . null($row['idt']);
        $rst = execsql($sql);

        $vetTmp = Array();

        foreach ($rst->data as $rowt) {
            $vetTmp[] = Array(
                'idt_tipo_informacao' => $rowt['idt_tipo_informacao'],
            );
        }

        $dadosGEC['gec_entidade_x_tipo_informacao'] = $vetTmp;

        $idt_pessoa_gec = sincronizaGecEntidade($dadosGEC, $vetRetorno);

        if ($row['tipo_relacao'] == 'L') {
            $idtEntidadePes = $idt_pessoa_gec;
            $representa = 'S';
        } else {
            $vetEntidadePessPar[] = $idt_pessoa_gec;
            $representa = 'N';
        }

        $codigo_siacweb = sincronizaSIACcad($idt_pessoa_gec, $idt_atendimento, $representa, $row['idt']);

        $sql = 'update ' . db_pir_grc . 'grc_atendimento_pessoa ';
        $sql .= " set codigo_siacweb = " . aspa($codigo_siacweb);
        $sql .= ' where idt = ' . null($row['idt']);
        execsql($sql);
    }

    if ($idtEntidadePes != '') {
        foreach ($vetEntidadeOrg as $idtEntidadeOrg => $vet) {
            if ($vet['situacao'] == 'D') {
                $sql = 'update ' . db_pir_gec . 'gec_entidade';
                $sql .= ' set idt_ult_representante_emp = null,';
                $sql .= ' representa_codcargcli = null';
                $sql .= ' where idt = ' . null($idtEntidadeOrg);
                execsql($sql);

                $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
                $sql .= " set ativo = 'N', data_termino = now()";
                $sql .= ' , representa_codcargcli = ' . null($vet['representa_codcargcli']);
                $sql .= ' where idt_entidade = ' . null($idtEntidadePes);
                $sql .= ' and idt_entidade_relacionada = ' . null($idtEntidadeOrg);
                $sql .= ' and idt_entidade_relacao <> 8';
                execsql($sql);
            } else if ($vet['situacao'] == 'M') {
                $codigo_siacweb = sincronizaSIACcad($idtEntidadeOrg, $idt_atendimento, 'N');

                $sql = 'update ' . db_pir_grc . 'grc_atendimento_organizacao';
                $sql .= " set codigo_siacweb_e = " . aspa($codigo_siacweb);
                $sql .= ' where idt = ' . null($vet['idt']);
                execsql($sql);
            } else {
                $sql = 'update ' . db_pir_gec . 'gec_entidade';
                $sql .= ' set idt_ult_representante_emp = ' . null($idtEntidadePes) . ',';
                $sql .= ' representa_codcargcli = ' . null($vet['representa_codcargcli']);
                $sql .= ' where idt = ' . null($idtEntidadeOrg);
                execsql($sql);

                $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
                $sql .= ' set idt_entidade_relacao = 13';
                $sql .= ' where idt_entidade = ' . null($idtEntidadePes);
                $sql .= ' and idt_entidade_relacao = 12';
                execsql($sql);

                $sql = '';
                $sql .= ' select idt, idt_entidade_relacao';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade';
                $sql .= ' where idt_entidade = ' . null($idtEntidadePes);
                $sql .= ' and idt_entidade_relacionada = ' . null($idtEntidadeOrg);
                $sql .= ' and idt_entidade_relacao in (12, 13)';
                $sql .= ' order by idt_entidade_relacao limit 1';
                $rst = execsql($sql);
                $idt = $rst->data[0]['idt'];
                $idt_entidade_relacao = $rst->data[0]['idt_entidade_relacao'];

                if ($idt == '') {
                    $sql = 'insert into ' . db_pir_gec . 'gec_entidade_entidade (';
                    $sql .= ' idt_entidade, idt_entidade_relacionada, idt_entidade_relacao, ativo, data_inicio, representa_codcargcli';
                    $sql .= ' ) values (';
                    $sql .= null($idtEntidadePes) . ', ' . null($idtEntidadeOrg) . ", 12, 'S', now(), " . null($vet['representa_codcargcli']);
                    $sql .= ' )';
                    execsql($sql);
                } else if ($idt_entidade_relacao == 12) {
                    $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
                    $sql .= ' set ';
                    $sql .= " ativo = 'S', data_termino = null";
                    $sql .= ' , representa_codcargcli = ' . null($vet['representa_codcargcli']);
                    $sql .= ' where idt = ' . null($idt);
                    execsql($sql);
                } else {
                    $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
                    $sql .= ' set idt_entidade_relacao = 12,';
                    $sql .= " ativo = 'S', data_inicio = now(), data_termino = null";
                    $sql .= ' , representa_codcargcli = ' . null($vet['representa_codcargcli']);
                    $sql .= ' where idt = ' . null($idt);
                    execsql($sql);
                }

                foreach ($vetEntidadePessPar as $idt_pessoa_gec) {
                    $sql = '';
                    $sql .= ' select idt, idt_entidade_relacao';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade';
                    $sql .= ' where idt_entidade = ' . null($idt_pessoa_gec);
                    $sql .= ' and idt_entidade_relacionada = ' . null($idtEntidadeOrg);
                    $sql .= ' and idt_entidade_relacao in (13)';
                    $sql .= ' order by idt_entidade_relacao limit 1';
                    $rst = execsql($sql);
                    $idt = $rst->data[0]['idt'];

                    if ($idt == '') {
                        $sql = 'insert into ' . db_pir_gec . 'gec_entidade_entidade (';
                        $sql .= ' idt_entidade, idt_entidade_relacionada, idt_entidade_relacao, ativo, data_inicio';
                        $sql .= ' ) values (';
                        $sql .= null($idt_pessoa_gec) . ', ' . null($idtEntidadeOrg) . ", 13, 'S', now()";
                        $sql .= ' )';
                        execsql($sql);
                    } else {
                        $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
                        $sql .= ' set ';
                        $sql .= " ativo = 'S', data_termino = null";
                        $sql .= ' where idt = ' . null($idt);
                        execsql($sql);
                    }
                }

                $codigo_siacweb = sincronizaSIACcad($idtEntidadeOrg, $idt_atendimento, 'S');

                $sql = 'update ' . db_pir_grc . 'grc_atendimento_organizacao';
                $sql .= " set codigo_siacweb_e = " . aspa($codigo_siacweb);
                $sql .= ' where idt = ' . null($vet['idt']);
                execsql($sql);
            }
        }
    }

    if (is_array($vetRetorno['arqCopia'])) {
        foreach ($vetRetorno['arqCopia'] as $arq) {
            if (is_file($arq['de'])) {
                copy($arq['de'], $arq['para']);
            }
        }
    }

    if (is_array($vetRetorno['arqDeletar'])) {
        foreach ($vetRetorno['arqDeletar'] as $arq) {
            if (is_file($arq)) {
                unlink($arq);
            }
        }
    }
}

function grc_atendimento_organizacao_per($row, $session_cod) {
    $html = '';

    if ($row['representa'] == 'S') {
        $checked = 'checked="checked"';
    } else {
        $checked = '';
    }

    $html .= '<input type="radio" class="radio_representa" name="representa" value="' . $row['idt'] . '" ' . $checked . ' />';

    $title = 'Desvincular Empreendimento';
    $mensagem = trata_aspa('Deseja Desvincular Empreendimento "' . $row['razao_social'] . '"?');

    $html .= "<a href='#' onclick='return btDesvincula(\"{$row['idt']}\", \"{$mensagem}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function grc_atendimento_organizacao_per_consulta($row, $session_cod) {
    $html = '';

    if ($row['representa'] == 'S') {
        $checked = 'checked="checked"';
    } else {
        $checked = '';
    }

    $html .= '<input type="radio" disable class="radio_representa" name="representa" value="' . $row['idt'] . '" ' . $checked . ' />';

    return $html;
}

function grc_atendimento_pendencia_per($row, $session_cod) {
    $title = 'Ativar / Desativar o Registro';
    $mensagem = trata_aspa('Deseja Ativar / Desativar o registro "' . $row['assunto'] . '"?');
    $html = '';

    $html .= "<a href='#' onclick='return btClickPendenciaAtivo(\"grc_atendimento_pendencia\", \"idt\", \"{$row['idt']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/excluir_16.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

/**
 * Cria as variaveis de $_SESSION do usuario
 * @access public
 * @param int $id_usuario [opcional] <p>
 * IDT do Usuário.
 * Se o valor for vazio vai usar o valor $_SESSION[CS]['g_id_usuario']
 * </p>
 * */
function carregaSession($id_usuario = '') {
    if ($id_usuario === '') {
        $id_usuario = $_SESSION[CS]['g_id_usuario_sistema']['GRC'];
    }

    $sql = "select * from " . db_pir_grc . "plu_usuario where id_usuario = " . null($id_usuario);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        die('Usuário não esta logado no sistema!');
    } else {
        $row = $rs->data[0];

        $_SESSION[CS]['alt_status_produto'] = $row['alt_status_produto'];
        $_SESSION[CS]['g_id_usuario'] = $row['id_usuario'];
        $_SESSION[CS]['g_evento_canal_registro'] = $row['evento_canal_registro'];

        $_SESSION[CS]['g_id_usuario_sistema'] = Array(
            'PIR' => IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir),
            'GEC' => IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir_gec),
            'GFI' => IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir_gfi),
            'GRC' => IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir_grc),
            'PFO' => IdUsuarioPIR($row['id_usuario'], db_pir_grc, db_pir_pfo),
        );

        $_SESSION[CS]['g_login'] = $row['login'];
        $_SESSION[CS]['g_nome_completo'] = $row['nome_completo'];
        $_SESSION[CS]['g_email'] = $row['email'];
        $_SESSION[CS]['g_senha_antiga'] = $row['senha'];
        $_SESSION[CS]['g_mostra_menu'] = $row['mostra_menu'];
        $_SESSION[CS]['g_mostra_barra_home'] = $row['mostra_barra_home'];
        $_SESSION[CS]['g_ldap'] = $row['ldap'];

        $_SESSION[CS]['g_id_perfil'] = $row['id_perfil'];




        $_SESSION[CS]['g_id_site_perfil'] = $row['id_site_perfil'];
        $_SESSION[CS]['g_id_site_perfil_assi'] = $row['idt_site_perfil_assi'];

        //$_SESSION[CS]['g_idt_pessoa'] = $row['idt_pessoa'];
        $_SESSION[CS]['g_idt_empreendimento'] = $row['idt_empreendimento'];
        $_SESSION[CS]['g_tipo_usuario'] = $row['tipo_usuario'];

        $_SESSION[CS]['g_gerenciador'] = $row['gerenciador'];
        $_SESSION[CS]['g_acesso_obra'] = $row['acesso_obra'];
        $_SESSION[CS]['g_gerador_conteudo'] = 'S';

        $_SESSION[CS]['g_procedimento'] = $row['procedimento'];

        $_SESSION[CS]['g_idt_setor'] = $row['idt_setor'];
        $_SESSION[CS]['g_nome_setor'] = '';

        $_SESSION[CS]['g_usuario_codparceiro'] = $row['codparceiro_siacweb'];





        $_SESSION[CS]['g_identificacao'] = $_SESSION[CS]['g_login'];

        $_SESSION[CS]['g_cpf'] = $row['cpf'];

        $_SESSION[CS]['g_telefone'] = $row['telefone'];
        $_SESSION[CS]['g_idt_natureza'] = $row['idt_natureza'];
        $_SESSION[CS]['g_gestor_produto'] = $row['gestor_produto'];
        $_SESSION[CS]['g_idt_unidade_regional'] = $row['idt_unidade_regional'];
        $_SESSION[CS]['g_idt_unidade_lotacao'] = $row['idt_unidade_lotacao'];
        $_SESSION[CS]['g_idt_projeto'] = $row['idt_projeto'];
        $_SESSION[CS]['g_idt_acao'] = $row['idt_acao'];

        $_SESSION[CS]['gdesc_idt_natureza'] = "";
        $_SESSION[CS]['gdesc_idt_unidade_regional'] = "";
        $_SESSION[CS]['gdesc_idt_projeto'] = "";
        $_SESSION[CS]['gdesc_idt_acao'] = "";

        CarregaParametrosGeraisAgendamento();

        // BOX da recepção
        $_SESSION[CS]['g_idt_box_recepcao'] = "";

        $sql = " select  ";
        $sql .= " grc_ab.idt as grc_ab_idt  ";
        $sql .= " from " . db_pir_grc . "grc_atendimento_box grc_ab ";
        $sql .= " inner join " . db_pir_grc . "grc_atendimento_tipo_box grc_atb on grc_atb.idt = grc_ab.idt_tipo_box";

        $sql .= " where grc_atb.codigo = '01' "; // o tipo dele é 01
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $_SESSION[CS]['g_idt_box_recepcao'] = $row['grc_ab_idt'];
        }



        $sql = "select  ";
        $sql .= " plu_un.*  ";
        $sql .= " from " . db_pir_grc . "plu_usuario_natureza plu_un ";
        $sql .= " where idt = " . null($_SESSION[CS]['g_idt_natureza']);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $_SESSION[CS]['gdesc_idt_natureza'] = $row['descricao'];
        }
        $sql = "select  ";
        $sql .= " sca_os.*  ";
        $sql .= " from " . db_pir . "sca_organizacao_secao sca_os ";
        $sql .= " where idt = " . null($_SESSION[CS]['g_idt_unidade_regional']);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $_SESSION[CS]['gdesc_idt_unidade_regional'] = $row['descricao'];
            $_SESSION[CS]['gdesc_codcid'] = $row['codcid'];
            $_SESSION[CS]['g_pa_responsavel_codparceiro'] = $row['codparceiro_siacweb'];
        }




        $sql = "select  ";
        $sql .= " grc_p.*, grc_ps.descricao as etapa  ";
        $sql .= " from " . db_pir_grc . "grc_projeto grc_p ";
        $sql .= " left join " . db_pir_grc . "grc_projeto_situacao grc_ps on grc_ps.idt = grc_p.idt_projeto_situacao ";
        $sql .= " where grc_p.idt = " . null($_SESSION[CS]['g_idt_projeto']);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $_SESSION[CS]['gdesc_idt_projeto'] = $row['descricao'];

            $_SESSION[CS]['g_projeto_gestor'] = $row['gestor'];
            $_SESSION[CS]['g_projeto_etapa'] = $row['etapa'];
        }

        $sql = "select  ";
        $sql .= " grc_pa.*  ";
        $sql .= " from " . db_pir_grc . "grc_projeto_acao grc_pa ";
        $sql .= " where idt = " . null($_SESSION[CS]['g_idt_acao']);
        $rs = execsql($sql);
        $wcodigo = '';
        ForEach ($rs->data as $row) {
            $_SESSION[CS]['gdesc_idt_acao'] = $row['descricao'];
        }


        // Gestor local da unidade

        $_SESSION[CS]['g_idt_gestor_local'] = $_SESSION[CS]['g_id_usuario'];





        $_SESSION[CS]['gat_idt_natureza'] = $_SESSION[CS]['g_idt_natureza'];
        $_SESSION[CS]['gat_gestor_produto'] = $_SESSION[CS]['g_gestor_produto'];
        $_SESSION[CS]['gat_idt_unidade_regional'] = $_SESSION[CS]['g_idt_unidade_regional'];
        $_SESSION[CS]['gat_idt_projeto'] = $_SESSION[CS]['g_idt_projeto'];
        $_SESSION[CS]['gat_idt_acao'] = $_SESSION[CS]['g_idt_acao'];
        $_SESSION[CS]['gatdesc_idt_unidade_regional'] = $_SESSION[CS]['gdesc_idt_unidade_regional'];
        $_SESSION[CS]['gatdesc_idt_natureza'] = $_SESSION[CS]['gdesc_idt_natureza'];
        $_SESSION[CS]['gatdesc_idt_projeto'] = $_SESSION[CS]['gdesc_idt_projeto'];
        $_SESSION[CS]['gatdesc_idt_acao'] = $_SESSION[CS]['gdesc_idt_acao'];



//////////////////////////////////// compet~encia
        carregaCompetencia();

//////////////////////////////////////
        // box
        $sql1 = 'select ';
        $sql1 .= '  *   ';
        $sql1 .= '  from ' . db_pir_grc . 'grc_atendimento_pa_pessoa ';
        $sql1 .= '  where idt_ponto_atendimento = ' . null($_SESSION[CS]['g_idt_unidade_regional']);
        $sql1 .= '    and idt_usuario = ' . null($_SESSION[CS]['g_id_usuario']);
        $rs_aa = execsql($sql1);
        $rowp = $rs_aa->data[0];
        $_SESSION[CS]['g_idt_atendimento_box'] = $rowp['idt_box'];
        $_SESSION[CS]['g_atendimento_relacao'] = $rowp['relacao'];




////////////////////////////////////////

        $sql1 = 'select ';
        $sql1 .= '  *   ';
        $sql1 .= '  from ' . db_pir_grc . 'plu_perfil ';
        $sql1 .= '  where id_perfil = ' . null($_SESSION[CS]['g_id_perfil']);
        $rs_aa = execsql($sql1);
        $rowp = $rs_aa->data[0];
        $_SESSION[CS]['g_atendimento_digitador'] = $rowp['atendimento_digitador'];
        $_SESSION[CS]['g_mostra_pk'] = $rowp['mostra_pk'];



        /*
          $sqlss  = "select descricao from sca_estrutura  ";
          $sqlss .= " where idt = ".null($_SESSION[CS]['g_idt_setor']);
          $resultss = execsql($sqlss);
          ForEach ($resultss->data as $rowss) {
          $_SESSION[CS]['g_nome_setor'] = $rowss['descricao'];
          }
         */


        $_SESSION[CS]['g_matricula_intranet'] = $row['matricula_intranet'];

        $_SESSION[CS]['g_trancar_gantt'] = $row['trancar_gantt'];



        /*
          $Vet_obra = Array();
          $Vet_obra_site = Array();
          if ($_SESSION[CS]['g_acesso_obra'] == '0') {
          // acesso a todas as obras
          // acesso a obras especificas
          $sql = "select em.* from empreendimento em  ";
          $sql .= " order by estado, descricao ";
          // $result = execsql($sql);
          $pri = 1;
          if ($_SESSION[CS]['g_idt_obra'] == '') {
          $pri = 0;
          $_SESSION[CS]['g_idt_obra'] = 0;
          }

          ForEach ($result->data as $row) {
          $Vet_obra[$row['idt']] = $row['estado'].' - '.$row['descricao'];
          if ($row['ativo'] == 'N') {

          } else {
          $Vet_obra_site[$row['idt']] = $row['estado'].' - '.$row['descricao'];
          }



          if ($pri == 0) {
          $pri = 1;
          $_SESSION[CS]['g_pri_vez_log'] = 1;
          $_SESSION[CS]['g_idt_obra'] = $row['idt'];
          $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
          $path = $dir_file.'/empreendimento/';
          $_SESSION[CS]['g_path_logo_obra'] = $path;
          $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
          $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
          $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
          $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
          //     $guy=$guy.' mais '.$row['orcamento_real'].' = '.$_SESSION[CS]['g_obra_orc_real'];

          $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];

          $_SESSION[CS]['g_ativo'] = $row['ativo'];



          $vetper = Array();
          $_SESSION[CS]['g_periodo_obra'] = '';
          //$vetper = calculaperiodoobra($row,1);
          $_SESSION[CS]['g_periodo_obra'] = $vetper;
          //      $guy=$guy.' mais  222222 '.$row['orcamento_real'].' = '.$_SESSION[CS]['g_obra_orc_real'];
          //$vetper = calculaperiodoobra($row,2);
          $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

          //    menu_obra($_SESSION[CS]['g_idt_obra']);
          }
          }
          } else {
          // acesso a obras especificas

          $sql = "select ue.*, em.*, em.ativo as em_ativo from {$pre_table}plu_usuario usu  ";
          $sql .= " inner join plu_usuario_empreendimento ue on ue.id_usuario = usu.id_usuario ";
          $sql .= " inner join empreendimento em on em.idt = ue.idt_empreendimento ";
          $sql .= "where ue.id_usuario = ".null($_SESSION[CS]['g_id_usuario']);
          $sql .= " order by estado, descricao ";



          //    $result = execsql($sql);
          $pri = 1;
          if ($_SESSION[CS]['g_idt_obra'] == '') {
          $pri = 0;
          $_SESSION[CS]['g_idt_obra'] = 0;
          }

          ForEach ($result->data as $row) {
          $Vet_obra[$row['idt_empreendimento']] = $row['estado'].' - '.$row['descricao'];
          if ($row['em_ativo'] == 'N') {

          } else {
          $Vet_obra_site[$row['idt']] = $row['estado'].' - '.$row['descricao'];
          }

          if ($pri == 0) {
          $pri = 1;
          $_SESSION[CS]['g_pri_vez_log'] = 1;
          $_SESSION[CS]['g_idt_obra'] = $row['idt_empreendimento'];
          $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
          $path = $dir_file.'/empreendimento/';
          $_SESSION[CS]['g_path_logo_obra'] = $path;
          $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
          $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
          $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
          $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
          $vetper = Array();
          $_SESSION[CS]['g_periodo_obra'] = '';
          // $vetper = calculaperiodoobra($row,1);
          $_SESSION[CS]['g_periodo_obra'] = $vetper;
          // $vetper = calculaperiodoobra($row,2);
          $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;
          //    menu_obra($_SESSION[CS]['g_idt_obra']);
          }
          }
          }

          $_SESSION[CS]['g_idt_obra'] = '';

          //echo rawurlencode($guy);
          $_SESSION[CS]['g_vet_obras'] = $Vet_obra;
          $_SESSION[CS]['g_vet_obras_site'] = $Vet_obra_site;
         */

        //  $_SESSION[CS]['g_vet_assina_obras_site']=assina_obra($_SESSION[CS]['g_id_usuario']);
    }
}

function GRC_parametros() {
    $vetGRC_parametros = Array();
    $sql = 'select ';
    $sql .= '  pfo_pa.*   ';
    $sql .= '  from  grc_parametros pfo_pa ';
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        
    } else {
        ForEach ($rs->data as $row) {
            $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
            $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");
            $vetGRC_parametros[$codigo] = $detalhe;
        }
    }
    return $vetGRC_parametros;
}

/**
 * Verifica a disponibilidade da Sala para o evento
 * @access public
 * @return Array Informa os dias indisponicel para alocação da sala
 * @param int $idt_evento_agenda <p>
 * IDT do Evento Agenda que esta fazendo a validação
 * </p>
 * @param int $idt_evento_local_pa_agenda <p>
 * IDT do Local PA Agenda que esta fazendo a validação
 * </p>
 * @param int $idt_local <p>
 * IDT do Local
 * </p>
 * @param string $dt_ini <p>
 * Dt. Inicio da alocação<br />
 * Formarto da data: dd/mm/yyyy hh:mm:ss
 * </p>
 * @param string $dt_fim <p>
 * Dt. Fim da alocação<br />
 * Formarto da data: dd/mm/yyyy hh:mm:ss
 * </p>
 * */
function validaDispLocalEvento($idt_evento_agenda, $idt_evento_local_pa_agenda, $idt_local, $dt_ini, $dt_fim) {
    $vetAgenda = Array();
    $vetReturn = Array();

    $sql = '';
    $sql .= ' select proprio';
    $sql .= ' from grc_evento_local_pa';
    $sql .= ' where idt = ' . null($idt_local);
    $rs = execsql($sql);

    if ($rs->data[0][0] == 'S') {
        $intDia = 86400; //Qtd de segundos em 24h

        $vetTmp = Array();

        $vet = DatetoArray($dt_ini);
        $intIni = mktime(0, 0, 0, $vet['mes'], $vet['dia'], $vet['ano']);
        $intIniHora = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

        $vet = DatetoArray($dt_fim);
        $intFim = mktime(0, 0, 0, $vet['mes'], $vet['dia'], $vet['ano']);
        $intFimHora = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

        if ($intIniHora + $intDia > $intFimHora) {
            $dia = date('d/m/Y H:i:s', $intIniHora);
            $vetTmp[] = $dia;

            $dia = date('d/m/Y H:i:s', $intFimHora);
            $vetTmp[] = $dia;
        } else {
            for ($i = $intIni; $i <= $intFim; $i = $i + $intDia) {
                switch ($i) {
                    case $intIni:
                        $dia = date('d/m/Y H:i:s', $intIniHora);
                        break;

                    case $intFim:
                        $dia = date('d/m/Y H:i:s', $intFimHora);
                        break;

                    default:
                        $dia = date('d/m/Y', $i);
                        break;
                }

                $vetTmp[] = $dia;
            }
        }

        $vetAgenda[] = $vetTmp;

        $tabela_agenda = 'a' . md5('validaDispLocalEvento_' . $_SESSION[CS]['g_id_usuario'] . '_' . GerarStr());

        $sql = 'DROP TEMPORARY TABLE IF EXISTS ' . $tabela_agenda;
        execsql($sql);

        $sql = '';
        $sql .= ' CREATE TEMPORARY TABLE ' . $tabela_agenda . ' ENGINE=MEMORY AS (';
        $sql .= ' select * from (';
        $sql .= " select concat('E', ea.idt) as idt, ea.dt_ini, ea.dt_fim, e.codigo";
        $sql .= ' from grc_evento_agenda ea';
        $sql .= ' inner join grc_evento e on e.idt = ea.idt_evento';
        $sql .= ' where ea.idt_local = ' . null($idt_local);
        $sql .= " and ea.alocacao_disponivel = 'S'";
        $sql .= ' and e.idt_evento_situacao not in (4, 19, 20, 21, 22, 23)';

        if ($idt_evento_agenda > 0) {
            $sql .= ' and ea.idt <> ' . null($idt_evento_agenda);
        }

        $sql .= ' and (';
        $sql .= ' cast(ea.dt_ini as date) between ' . aspa(trata_data($dt_ini, false, true)) . ' and ' . aspa(trata_data($dt_fim, false, true));
        $sql .= ' or cast(ea.dt_fim as date) between ' . aspa(trata_data($dt_ini, false, true)) . ' and ' . aspa(trata_data($dt_fim, false, true));
        $sql .= ' )';

        $sql .= ' union all';

        $sql .= " select concat('L', ea.idt) as idt, ea.dt_ini, ea.dt_fim, 'Local/Sala Indisponível' as codigo";
        $sql .= ' from grc_evento_local_pa_agenda ea';
        $sql .= ' inner join grc_evento_local_pa e on e.idt = ea.idt_local_pa';
        $sql .= ' where ea.idt_local_pa = ' . null($idt_local);
        $sql .= " and ea.alocacao_disponivel = 'S'";

        if ($idt_evento_local_pa_agenda > 0) {
            $sql .= ' and ea.idt <> ' . null($idt_evento_local_pa_agenda);
        }

        $sql .= ' and (';
        $sql .= ' cast(ea.dt_ini as date) between ' . aspa(trata_data($dt_ini, false, true)) . ' and ' . aspa(trata_data($dt_fim, false, true));
        $sql .= ' or cast(ea.dt_fim as date) between ' . aspa(trata_data($dt_ini, false, true)) . ' and ' . aspa(trata_data($dt_fim, false, true));
        $sql .= ' )';

        $sql .= ' ) as tudo';
        $sql .= ' )';
        execsql($sql);

        foreach ($vetAgenda as $vetRegistro) {
            $qtd = count($vetRegistro) - 1;

            for ($i = 0; $i < $qtd; $i++) {
                $ini = $vetRegistro[$i];
                $fim = $vetRegistro[$i + 1];

                $sql = '';
                $sql .= ' select *';
                $sql .= ' from ' . $tabela_agenda;
                $sql .= ' where ' . aspa(trata_data($ini, true)) . ' between dt_ini and dt_fim';
                $sql .= ' or ' . aspa(trata_data($fim, true)) . ' between dt_ini and dt_fim';

                $sql .= ' or (';
                $sql .= ' dt_ini >= ' . aspa(trata_data($ini, true));
                $sql .= ' and dt_fim <= ' . aspa(trata_data($fim, true));
                $sql .= ' )';

                $rs_a = execsql($sql);

                foreach ($rs_a->data as $row_a) {
                    $vetReturn[$row_a['idt']] = $row_a['codigo'] . ': ' . trata_data($row_a['dt_ini'], true) . ' a ' . trata_data($row_a['dt_fim'], true);
                }
            }
        }

        $sql = 'DROP TEMPORARY TABLE IF EXISTS ' . $tabela_agenda;
        execsql($sql);
    }

    return $vetReturn;
}

/**
 * Consulta os participantes que concluiram o Evento com o SiacWEB
 * @access public
 * @return string Mensagem de Erro
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * */
function conParticipanteEventoConcluidoSiacWeb($idt_evento) {
    global $debug;

    try {
        beginTransaction();

        $sql = '';
        $sql .= ' select idt, codigo_siacweb';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($idt_evento);
        $sql .= ' and idt_instrumento <> 2';

        //Resolver problema do Evento Composto
        $sql .= " and (composto = 'N' and idt_evento_pai is null)";

        $rs = execsql($sql, false);
        $row_e = $rs->data[0];

        if ($row_e['codigo_siacweb'] == '') {
            commit();
            return '';
        }

        $conSIAC = new_pdo(siacweb_host, siacweb_bd_user, siacweb_password, siacweb_tipodb, false);

        $sql = '_BA_Consulta_Acesso_Evento';

        $vetBindParam = Array();
        $vetBindParam['CodEvento'] = vetBindParam($row_e['codigo_siacweb'], PDO::PARAM_INT);
        $vetBindParam['codpessoapf'] = vetBindParam(0, PDO::PARAM_INT);
        $rs = execsql($sql, false, $conSIAC, $vetBindParam);

        $vetPessSIAC = Array();

        foreach ($rs->data as $row) {
            $cpf = FormataCPF12($row['cpf']);
            $vetPessSIAC[$cpf] = aspa($cpf);
        }

        if (count($vetPessSIAC) > 0) {
            $sql = 'update grc_atendimento_pessoa set ';
            $sql .= " evento_concluio = 'S'";
            $sql .= ' where evento_concluio is null';
            $sql .= ' and cpf in (' . implode(', ', $vetPessSIAC) . ')';
            $sql .= ' and idt_atendimento in (';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento';
            $sql .= ' where idt_evento = ' . null($row_e['idt']);
            $sql .= ' )';
            execsql($sql);
        }

        commit();

        return '';
    } catch (Exception $e) {
        rollBack();

        return grava_erro_log('conParticipanteEventoConcluidoSiacWeb', $e);
    }
}

/**
 * Consulta os participantes do Evento com o SiacWEB
 * @access public
 * @return string Mensagem de Erro
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param int &$qtd_incluido <p>
 * Quantidade de Matriculas incluidas
 * </p>
 * */
function conParticipanteEventoSiacWeb($idt_evento, &$qtd_incluido) {
    global $debug;

    $qtd_matriculado_siacweb = 0;
    $qtd_vagas_resevado = 0;

    try {
        $sql = '';
        $sql .= ' select idt, codigo_siacweb, idt_instrumento';
        $sql .= ' from ' . db_pir_grc . 'grc_evento';
        $sql .= ' where idt = ' . null($idt_evento);

        //Resolver problema do Evento Composto
        $sql .= " and (composto = 'N' and idt_evento_pai is null)";

        $rs = execsql($sql, false);
        $row_e = $rs->data[0];

        if ($row_e['codigo_siacweb'] == '') {
            return '';
        }

        $sql = '';
        $sql .= " select idt, lojasiac_status";
        $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao_pagamento';
        $rs = execsql($sql, false);

        $vetSituacaoPagamento = Array();

        foreach ($rs->data as $row) {
            $vetSituacaoPagamento[$row['lojasiac_status']] = $row['idt'];
        }

        $sql = '';
        $sql .= " select idt, lojasiac_modalidade";
        $sql .= ' from ' . db_pir_grc . 'grc_evento_natureza_pagamento';
        $sql .= ' where lojasiac_modalidade is not null';
        $rs = execsql($sql, false);

        $vetNaturezaPagamento = Array();

        foreach ($rs->data as $row) {
            $vetNaturezaPagamento[$row['lojasiac_modalidade']] = $row['idt'];
        }

        $sql = '';
        $sql .= " select idt, lojasiac_codbandeira";
        $sql .= ' from ' . db_pir_grc . 'grc_evento_cartao_bandeira';
        $sql .= ' where lojasiac_codbandeira is not null';
        $rs = execsql($sql, false);

        $vetBandeiraPagamento = Array();

        foreach ($rs->data as $row) {
            $vetBandeiraPagamento[$row['lojasiac_codbandeira']] = $row['idt'];
        }

        $sql = '';
        $sql .= " select idt, idt_natureza, numero_de_parcelas";
        $sql .= ' from ' . db_pir_grc . 'grc_evento_forma_parcelamento';
        $rs = execsql($sql, false);

        $vetParcelamentoPagamento = Array();

        foreach ($rs->data as $row) {
            $vetParcelamentoPagamento[$row['idt_natureza']][$row['numero_de_parcelas']] = $row['idt'];
        }

        $conSIAC = new_pdo(siacweb_host, siacweb_bd_user, siacweb_password, siacweb_tipodb, false);

        $sql = '';
        $sql .= ' select pr.codpessoapf, pf.cgccpf as cpf, pr.codpessoapj, pj.cgccpf as cnpj,';
        $sql .= ' pjd.coddap as dap, pjd.nirf as nirf, pjd.codpescador as rmp, pjd.codprodutorrural as ie_prod_rural, pjd.codsicab as sicab_codigo';
        $sql .= ' from participante pr with(nolock)';
        $sql .= ' inner join parceiro pf with(nolock) on pf.codparceiro = pr.codpessoapf';
        $sql .= ' left outer join parceiro pj with(nolock) on pj.codparceiro = pr.codpessoapj';
        $sql .= ' left outer join pessoaj pjd with(nolock) on pjd.codparceiro = pr.codpessoapj';
        $sql .= ' where pr.codevento = ' . null($row_e['codigo_siacweb']);

        $rs = execsql($sql, false, $conSIAC);

        $vetPessSIAC = Array();

        foreach ($rs->data as $row) {
            $vetPessSIAC[FormataCPF12($row['cpf'])] = $row;
        }

        $sql = '';
        $sql .= ' select p.idt_atendimento, p.idt as idt_atendimento_pessoa, p.cpf, p.tipo_relacao, p.codigo_siacweb,';
        $sql .= ' o.idt as idt_atendimento_organizacao, o.cnpj, o.codigo_siacweb_e, p.evento_inscrito, p.falta_sincronizar_siacweb,';
        $sql .= ' p.evento_exc_siacweb, ep.contrato';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
        $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_atendimento_organizacao o on o.idt_atendimento = a.idt';
        $sql .= ' where a.idt_evento = ' . null($row_e['idt']);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rs = execsql($sql, false);

        $transAtivo = false;

        foreach ($rs->data as $row) {
            beginTransaction();
            $transAtivo = true;
            set_time_limit(0);

            $totAlt = 0;
            $cpf = FormataCPF12($row['cpf']);

            if ($row['contrato'] == '') {
                $row['contrato'] = 'R';
            }

            if (is_array($vetPessSIAC[$cpf])) {
                if ($row['falta_sincronizar_siacweb'] != 'S' && ($row['contrato'] == 'R' || $row['contrato'] == 'S')) {
                    $row_par = $vetPessSIAC[$cpf];

                    if ($row['codigo_siacweb_e'] != $row_par['codpessoapj'] && $row['tipo_relacao'] == 'P') {
                        $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_pessoa where idt = ' . null($row['idt_atendimento_pessoa']);
                        execsql($sql, false);

                        $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set evento_alt_siacweb = 'S'";
                        $sql .= " where idt_atendimento = " . null($row['idt_atendimento']);
                        $sql .= " and tipo_relacao = 'L'";
                        execsql($sql, false);

                        $qtd_incluido++;
                        novoInscricaoEvento($row_e, $row, $row_par);
                    }

                    atualizaDadosPessoaEvento($row_par['codpessoapf'], $row['idt_atendimento_pessoa'], $conSIAC);

                    if ($row['tipo_relacao'] == 'L') {
                        if ($row['idt_atendimento_organizacao'] == '') {
                            if ($row_par['codpessoapj'] != '') {
                                novoEmpresaEvento($row['idt_atendimento'], $row['idt_atendimento_pessoa'], $row, $row_par);
                                $totAlt += atualizaDadosEmpresaEvento($row_par['codpessoapj'], $row['idt_atendimento_organizacao'], $conSIAC);
                            }
                        } else {
                            if ($row_par['codpessoapj'] == '') {
                                $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao where idt = ' . null($row['idt_atendimento_organizacao']);
                                execsql($sql, false);

                                $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_pessoa where idt_atendimento = ' . null($row['idt_atendimento']);
                                $sql .= " and tipo_relacao = 'P'";
                                execsql($sql, false);

                                $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set representa_empresa = 'N'";
                                $sql .= " where idt_atendimento = " . null($row['idt_atendimento']);
                                $sql .= " and tipo_relacao = 'L'";
                                execsql($sql, false);
                            } else {
                                $totAlt += atualizaDadosEmpresaEvento($row_par['codpessoapj'], $row['idt_atendimento_organizacao'], $conSIAC);
                            }
                        }
                    }

                    $totAlt += atualizaPagamentoLojaEvento($row_e['codigo_siacweb'], $row_par['codpessoapf'], $row['idt_atendimento'], $conSIAC);

                    if ($totAlt > 0) {
                        $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set evento_alt_siacweb = 'S'";
                        $sql .= " where idt_atendimento = " . null($row['idt_atendimento']);
                        $sql .= " and tipo_relacao = 'L'";
                        execsql($sql, false);
                    }
                }

                $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set evento_exc_siacweb = 'N', evento_inscrito = 'S'";
                $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                execsql($sql, false);
            }

            //Saldo Vagas
            if (is_array($vetPessSIAC[$cpf])) {
                $qtd_matriculado_siacweb++;

                if ($row['evento_exc_siacweb'] == 'S') {
                    $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set evento_exc_siacweb = 'N', evento_inscrito = 'S'";
                    $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                    execsql($sql, false);
                }
            } else if ($row['evento_inscrito'] == 'S') {
                $qtd_vagas_resevado++;

                $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set evento_exc_siacweb = 'S', evento_inscrito = 'N'";
                $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                execsql($sql, false);
            } else {
                $qtd_vagas_resevado++;
            }

            unset($vetPessSIAC[$cpf]);

            $sql = "update " . db_pir_grc . "grc_evento set qtd_matriculado_siacweb = " . null($qtd_matriculado_siacweb);
            $sql .= ", qtd_vagas_resevado = " . null($qtd_vagas_resevado);
            $sql .= " where idt = " . null($row_e['idt']);
            execsql($sql, false);

            commit();
            $transAtivo = false;
        }

        foreach ($vetPessSIAC as $row_par) {
            beginTransaction();
            $transAtivo = true;
            set_time_limit(0);

            $row = Array();

            $qtd_incluido++;
            novoInscricaoEvento($row_e, $row, $row_par);
            $qtd_matriculado_siacweb++;

            atualizaDadosPessoaEvento($row_par['codpessoapf'], $row['idt_atendimento_pessoa'], $conSIAC);

            if ($row['tipo_relacao'] == 'L' && $row['idt_atendimento_organizacao'] != '') {
                atualizaDadosEmpresaEvento($row_par['codpessoapj'], $row['idt_atendimento_organizacao'], $conSIAC);
            }

            atualizaPagamentoLojaEvento($row_e['codigo_siacweb'], $row_par['codpessoapf'], $row['idt_atendimento'], $conSIAC);

            $sql = "update " . db_pir_grc . "grc_evento set qtd_matriculado_siacweb = " . null($qtd_matriculado_siacweb);
            $sql .= ", qtd_vagas_resevado = " . null($qtd_vagas_resevado);
            $sql .= " where idt = " . null($row_e['idt']);
            execsql($sql, false);

            commit();
            $transAtivo = false;
        }

        return '';
    } catch (Exception $e) {
        if ($transAtivo) {
            rollBack();
        }

        if ($debug) {
            p($e);
        }

        return grava_erro_log('conParcipanteEventoSiacWeb', $e);
    }
}

/**
 * Cadastra uma nova inscrição para o evento
 * @access public
 * */
function novoInscricaoEvento($row_e, &$row, $row_par, $evento_origem = 'SIACWEB') {
    $cpf = FormataCPF12($row_par['cpf']);

    $parCPF = Array();
    $parCPF['erro'] = "";
    $parCPF['cpf'] = $cpf;
    $parCPF['idt_instrumento'] = $row_e['idt_instrumento'];
    $parCPF['idt_pf'] = 0;
    $parCPF['idt_evento'] = $row_e['idt'];
    $parCPF['bancoTransaction'] = 'N';
    $parCPF['evento_origem'] = $evento_origem;
    $parCPF['canal_registro'] = 'LOJA';
    $parCPF['id_usuario'] = $_SESSION[CS]['g_id_usuario_sistema']['GRC'];

    BuscaCPF(0, $parCPF);

    if ($parCPF['idt_atendimento'] > 0) {
        $row['idt_atendimento'] = $parCPF['idt_atendimento'];
        $row['idt_atendimento_pessoa'] = $parCPF['idt_atendimento_pessoa'];
        $row['cpf'] = $cpf;
        $row['tipo_relacao'] = 'L';
        $row['codigo_siacweb'] = $row_par['codpessoapf'];

        if ($evento_origem == 'SIACWEB') {
            $contrato = 'S';
        } else {
            $contrato = 'R';
        }

        $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante (idt_atendimento, contrato) VALUES (' . null($parCPF['idt_atendimento']) . ", '{$contrato}')";
        execsql($sql, false);

        if ($row_par['codpessoapj'] == '') {
            $representa_empresa = 'N';

            $row['idt_atendimento_organizacao'] = '';
            $row['cnpj'] = '';
            $row['codigo_siacweb_e'] = '';
        } else {
            $representa_empresa = 'S';

            $parCNPJ = Array();
            $parCNPJ['erro'] = "";

            if ($row_par['cnpj'] == '') {
                $parCNPJ['cnpj'] = '';
            } else {
                $parCNPJ['cnpj'] = FormataCNPJ($row_par['cnpj']);
            }

            $parCNPJ['codparceiro'] = $row_par['codpessoapj'];
            $parCNPJ['dap'] = $row_par['dap'];
            $parCNPJ['nirf'] = $row_par['nirf'];
            $parCNPJ['rmp'] = $row_par['rmp'];
            $parCNPJ['ie_prod_rural'] = $row_par['ie_prod_rural'];
            $parCNPJ['sicab_codigo'] = $row_par['sicab_codigo'];
            $parCNPJ['bancoTransaction'] = 'N';

            BuscaCNPJ($parCPF['idt_atendimento'], $parCNPJ);

            $row['idt_atendimento_organizacao'] = $parCNPJ['idt_atendimento_organizacao'];
            $row['cnpj'] = $parCNPJ['cnpj'];
            $row['codigo_siacweb_e'] = $row_par['codpessoapj'];

            $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set novo_registro = 'N' where idt = " . null($parCNPJ['idt_atendimento_organizacao']);
            execsql($sql, false);
        }

        $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set representa_empresa = " . aspa($representa_empresa);

        if ($evento_origem == 'SIACWEB') {
            $sql .= ", evento_alt_siacweb = 'S', evento_inscrito = 'S'";
        }

        $sql .= " where idt = " . null($parCPF['idt_atendimento_pessoa']);
        execsql($sql, false);

        sincronizaAtendimentoGEC($parCPF['idt_atendimento']);
    }
}

/**
 * Cadastra uma Empresa na inscrição para o evento
 * @access public
 * */
function novoEmpresaEvento($idt_atendimento, $idt_atendimento_pessoa, &$row, $row_par) {
    $representa_empresa = 'S';

    $parCNPJ = Array();
    $parCNPJ['erro'] = "";

    if ($row_par['cnpj'] == '') {
        $parCNPJ['cnpj'] = '';
    } else {
        $parCNPJ['cnpj'] = FormataCNPJ($row_par['cnpj']);
    }

    $parCNPJ['codparceiro'] = $row_par['codpessoapj'];
    $parCNPJ['dap'] = $row_par['dap'];
    $parCNPJ['nirf'] = $row_par['nirf'];
    $parCNPJ['rmp'] = $row_par['rmp'];
    $parCNPJ['ie_prod_rural'] = $row_par['ie_prod_rural'];
    $parCNPJ['sicab_codigo'] = $row_par['sicab_codigo'];
    $parCNPJ['bancoTransaction'] = 'N';

    BuscaCNPJ($idt_atendimento, $parCNPJ);

    $row['idt_atendimento_organizacao'] = $parCNPJ['idt_atendimento_organizacao'];
    $row['cnpj'] = $parCNPJ['cnpj'];
    $row['codigo_siacweb_e'] = $row_par['codpessoapj'];

    $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set novo_registro = 'N' where idt = " . null($parCNPJ['idt_atendimento_organizacao']);
    execsql($sql, false);

    $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set representa_empresa = " . aspa($representa_empresa);
    $sql .= ", evento_alt_siacweb = 'S', evento_inscrito = 'S'";
    $sql .= " where idt = " . null($idt_atendimento_pessoa);
    execsql($sql, false);

    sincronizaAtendimentoGEC($idt_atendimento);
}

/**
 * Atualiza os dados da empresa em uma inscrição em evento
 * @access public
 * @return int Quantidade de registros modificados
 * @param int $codparceiro <p>
 * CodParceiro do SiacWEB
 * </p>
 * @param int idt_atendimento_organizacao <p>
 * IDT do grc_atendimento_organizacao
 * </p>
 * @param PDO $conSIAC <p>
 * Obejto PDO de conecção com o banco do SiacWEB
 * </p>
 * */
function atualizaDadosEmpresaEvento($codparceiro, $idt_atendimento_organizacao, $conSIAC) {
    $totAlt = 0;
    $vetpir = BuscaDadosEntidadeSIACWEB($codparceiro, 'J', $conSIAC);

    if ($vetpir['existe_entidade'] == 'S') {
        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nome'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];

        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];

        $cpfcnpj = $vetdadosproprios['row']['cgccpf'];
        $cnpj_e = $cpfcnpj;

        $codigo_siacweb_e = $vetdadosproprios['row']['codparceiro'];
        $razao_social_e = $vetdadosproprios['row']['nomerazaosocial'];
        $nome_fantasia_e = $vetdadosproprios['row']['nomeabrevfantasia'];
        $receber_informacao_e = $vetdadosproprios['row']['receberinfosebrae'];

        $inscricao_estadual_e = $vetdadosproprios['row']['inscest'];
        $inscricao_municipal_e = $vetdadosproprios['row']['inscmun'];
        $data_abertura_e = $vetdadosproprios['row']['databert'];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_emp';
        $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codconst']);
        $rstt = execsql($sql, false);
        $idt_tipo_empreendimento_e = $rstt->data[0][0];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_setor';
        $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['codsetor']);
        $rstt = execsql($sql, false);
        $idt_setor_e = $rstt->data[0][0];

        $pessoas_ocupadas_e = $vetdadosproprios['row']['numfunc'];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
        $sql .= ' where codigo = ' . aspa($vetdadosproprios['row']['faturam']);
        $rstt = execsql($sql, false);
        $idt_porte_e = $rstt->data[0][0];

        $dap_e = $vetdadosproprios['row']['coddap'];
        $nirf_e = $vetdadosproprios['row']['nirf'];
        $ie_prod_rural_e = $vetdadosproprios['row']['codprodutorrural'];
        $sicab_codigo = $vetdadosproprios['row']['codsicab'];
        $sicab_dt_validade = $vetdadosproprios['row']['datavalidade'];
        $data_fim_atividade = $vetdadosproprios['row']['datfech'];
        $siacweb_situacao = $vetdadosproprios['row']['situacao'];
        $pa_senha = '';
        $pa_idfacebook = '';

        if ($vetdadosproprios['row']['optantesimplesnacional'] == 0) {
            $simples_nacional_e = 'S';
        } else {
            $simples_nacional_e = 'N';
        }

        $tamanho_propriedade_e = $vetdadosproprios['row']['tamanhopropriedade'];
        $rmp_e = $vetdadosproprios['row']['codpescador'];

        // Busca cnae principal
        $vetcmae = Array();

        $sql = '';
        $sql .= ' select codativecon, codcnaefiscal, indativprincipal';
        $sql .= ' from ' . db_pir_siac . 'ativeconpj';
        $sql .= ' where codparceiro = ' . null($codigo_siacweb_e);
        $rstt = execsql($sql, false);

        foreach ($rstt->data as $rowtt) {
            $cnae = substr($rowtt['codativecon'], 0, 4) . '-' . substr($rowtt['codativecon'], 4) . '/' . $rowtt['codcnaefiscal'];

            if ($rowtt['indativprincipal'] == 1) {
                $idt_cnae_principal_e = $cnae;
            } else {
                $vetcmae[] = Array(
                    'cnae' => $cnae,
                    'principal' => 'N',
                );
            }
        }

        // Comunicacao
        $vetcomunicacao = $vetpir['comunicacao']['row'];
        $telefone_comercial_e = $vetcomunicacao['telefone_1_p'];
        $telefone_celular_e = $vetcomunicacao['telefone_2_p'];
        $sms_e = $vetcomunicacao['telefone_3_p'];
        $email_e = $vetcomunicacao['email_1_p'];
        $site_url_e = $vetcomunicacao['www_1_p'];

        // Parte variável
        $vetenderecos = $vetpir['enderecos'];

        ForEach ($vetenderecos as $idx => $vetrow) {
            // 00 é o principal
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }

            $logradouro_e = $vetrow['logradouro'];
            $logradouro_numero_e = $vetrow['logradouro_numero'];
            $logradouro_complemento_e = $vetrow['logradouro_complemento'];
            $logradouro_bairro_e = $vetrow['logradouro_bairro'];
            $logradouro_municipio_e = $vetrow['logradouro_municipio'];
            $logradouro_estado_e = $vetrow['logradouro_estado'];
            $logradouro_pais_e = $vetrow['logradouro_pais'];

            $logradouro_codbairro_e = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_e = $vetrow['logradouro_codcid'];
            $logradouro_codest_e = $vetrow['logradouro_codest'];
            $logradouro_codpais_e = $vetrow['logradouro_codpais'];

            $cep_e = $vetrow['logradouro_cep'];

            $idt_pais_e = $vetrow['idt_pais'];
            $idt_estado_e = $vetrow['idt_estado'];
            $idt_cidade_e = $vetrow['idt_cidade'];
        }

        //Update
        $codigo_siacweb = aspa($codigo_siacweb_e);
        $idt_tipo_empreendimento = null($idt_tipo_empreendimento_e);

        $sql = '';
        $sql .= ' select codigo_prod_rural';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao';
        $sql .= ' where idt = ' . null($idt_atendimento_organizacao);
        $rs = execsql($sql, false);
        $codigo_prod_rural = $rs->data[0][0];

        if ($cnpj_e == '') {
            if ($codigo_prod_rural == '') {
                $codigo_prod_rural = 'PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc);
            }

            $cnpj = aspa($codigo_prod_rural);
        } else {
            $cnpj = aspa(FormataCNPJ($cnpj_e));
        }

        $codigo_prod_rural = aspa($codigo_prod_rural);

        if ($razao_social_e == '') {
            $razao_social_e = 'Novo Empreendimento';
        }

        $razao_social = aspa($razao_social_e);
        $nome_fantasia = aspa($nome_fantasia_e);
        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = null($pessoas_ocupadas_e);
        $logradouro_cep = aspa($cep_e);
        $logradouro_endereco = aspa($logradouro_e);
        $logradouro_numero = aspa($logradouro_numero_e);
        $logradouro_bairro = aspa($logradouro_bairro_e);
        $logradouro_complemento = aspa($logradouro_complemento_e);
        $logradouro_cidade = aspa($logradouro_municipio_e);
        $logradouro_estado = aspa($logradouro_estado_e);
        $logradouro_pais = aspa($logradouro_pais_e);

        $logradouro_codbairro_e = null($logradouro_codbairro_e);
        $logradouro_codcid_e = null($logradouro_codcid_e);
        $logradouro_codest_e = null($logradouro_codest_e);
        $logradouro_codpais_e = null($logradouro_codpais_e);

        $idt_pais = null($idt_pais_e);
        $idt_estado = null($idt_estado_e);
        $idt_cidade = null($idt_cidade_e);
        $telefone_comercial = aspa($telefone_comercial_e);
        $telefone_celular = aspa($telefone_celular_e);
        $sms = aspa($sms_e);
        $email = aspa($email_e);
        $site_url = aspa($site_url_e);
        $receber_informacao = aspa($receber_informacao_e);
        //
        $dap = aspa($dap_e);
        $nirf = aspa(FormataNirf($nirf_e));
        $rmp = aspa($rmp_e);
        $ie_prod_rural = aspa($ie_prod_rural_e);
        $sicab_codigo = aspa(FormataSICAB($sicab_codigo));
        $sicab_dt_validade = aspa($sicab_dt_validade);
        $data_fim_atividade = aspa($data_fim_atividade);

        if ($siacweb_situacao == '') {
            $siacweb_situacao = 1;
        }

        $siacweb_situacao = null($siacweb_situacao);
        $pa_senha = aspa($pa_senha);
        $pa_idfacebook = aspa($pa_idfacebook);
        $data_abertura = aspa($data_abertura_e);
        $pessoas_ocupadas = aspa($pessoas_ocupadas_e);
        $idt_cnae_principal = aspa($idt_cnae_principal_e);
        $idt_porte = null($idt_porte_e);
        $idt_setor = null($idt_setor_e);
        $simples_nacional = null($simples_nacional_e);
        $tamanho_propriedade = null($tamanho_propriedade_e);

        $sql = "";
        $sql .= " UPDATE " . db_pir_grc . "grc_atendimento_organizacao";
        $sql .= " SET ";
        $sql .= " cnpj = $cnpj,";
        $sql .= " razao_social = $razao_social,";
        $sql .= " nome_fantasia = $nome_fantasia,";
        $sql .= " logradouro_cep_e = $logradouro_cep,";
        $sql .= " logradouro_endereco_e = $logradouro_endereco,";
        $sql .= " logradouro_numero_e = $logradouro_numero,";
        $sql .= " logradouro_complemento_e = $logradouro_complemento,";
        $sql .= " logradouro_codbairro_e = $logradouro_codbairro_e,";
        $sql .= " logradouro_bairro_e = $logradouro_bairro,";
        $sql .= " logradouro_codcid_e = $logradouro_codcid_e,";
        $sql .= " logradouro_cidade_e = $logradouro_cidade,";
        $sql .= " logradouro_codest_e = $logradouro_codest_e,";
        $sql .= " logradouro_estado_e = $logradouro_estado,";
        $sql .= " logradouro_codpais_e = $logradouro_codpais_e,";
        $sql .= " logradouro_pais_e = $logradouro_pais,";
        $sql .= " idt_pais_e = $idt_pais,";
        $sql .= " idt_estado_e = $idt_estado,";
        $sql .= " idt_cidade_e = $idt_cidade,";
        $sql .= " telefone_comercial_e = $telefone_comercial,";
        $sql .= " telefone_celular_e = $telefone_celular,";
        $sql .= " email_e = $email,";
        $sql .= " sms_e = $sms,";
        $sql .= " receber_informacao_e = $receber_informacao,";
        $sql .= " codigo_siacweb_e = $codigo_siacweb,";
        $sql .= " site_url = $site_url,";
        $sql .= " idt_porte = $idt_porte,";
        $sql .= " idt_tipo_empreendimento = $idt_tipo_empreendimento,";
        $sql .= " data_abertura = $data_abertura,";
        $sql .= " pessoas_ocupadas = $pessoas_ocupadas,";
        $sql .= " idt_setor = $idt_setor,";
        $sql .= " idt_cnae_principal = $idt_cnae_principal,";
        $sql .= " simples_nacional = $simples_nacional,";
        $sql .= " tamanho_propriedade = $tamanho_propriedade,";
        $sql .= " dap = $dap,";
        $sql .= " nirf = $nirf,";
        $sql .= " rmp = $rmp,";
        $sql .= " ie_prod_rural = $ie_prod_rural,";
        $sql .= " sicab_codigo = $sicab_codigo,";
        $sql .= " sicab_dt_validade = $sicab_dt_validade,";
        $sql .= " data_fim_atividade = $data_fim_atividade,";
        $sql .= " siacweb_situacao_e = $siacweb_situacao,";
        $sql .= " pa_senha_e = $pa_senha,";
        $sql .= " pa_idfacebook_e = $pa_idfacebook,";
        $sql .= " codigo_prod_rural = $codigo_prod_rural";
        $sql .= " WHERE idt = " . null($idt_atendimento_organizacao);
        $totAlt = execsql($sql, false);

        $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao_cnae where idt_atendimento_organizacao = ' . null($idt_atendimento_organizacao);
        execsql($sql, false);

        ForEach ($vetcmae as $idx => $rowcnae) {
            if ($rowcnae['principal'] == 'N') {
                $cnae = aspa($rowcnae['cnae']);
                $principal = aspa($rowcnae['principal']);
                $sql_i = ' insert into ' . db_pir_grc . ' grc_atendimento_organizacao_cnae ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_atendimento_organizacao, ";
                $sql_i .= " cnae, ";
                $sql_i .= " principal ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_atendimento_organizacao, ";
                $sql_i .= " $cnae, ";
                $sql_i .= " $principal ";
                $sql_i .= ') ';
                execsql($sql_i, false);
            }
        }
    }

    return $totAlt;
}

/**
 * Atualiza os dados da pessoa em uma inscrição em evento
 * @access public
 * @param int $codparceiro <p>
 * CodParceiro do SiacWEB
 * </p>
 * @param int $idt_atendimento_pessoa <p>
 * IDT do grc_atendimento_pessoa
 * </p>
 * @param PDO $conSIAC <p>
 * Obejto PDO de conecção com o banco do SiacWEB
 * </p>
 * */
function atualizaDadosPessoaEvento($codparceiro, $idt_atendimento_pessoa, $conSIAC) {
    $vetpir = BuscaDadosEntidadeSIACWEB($codparceiro, 'F', $conSIAC);

    if ($vetpir['existe_entidade'] == 'S') {
        $qtd_entidade = $vetpir['qtd_entidade'];
        $idt_entidade = $vetpir['idt_entidade'];
        $codigo_siacweb = $idt_entidade;
        $cpfcnpj = $vetpir['cpfcnpj'];
        $idt_cliente = $vetpir['idt_cliente'];
        $nome = $vetpir['nomerazaosocial'];
        $nome_pessoa = $vetpir['nomerazaosocial'];
        $telefone = $vetpir['telefone'];
        $celular = $vetpir['celular'];
        $email = $vetpir['email'];
        $cnpj = $vetpir['cnpj'];
        $nome_empresa = $vetpir['nome_empresa'];
        // complemento dependendo do tipo
        $vetdadosproprios = $vetpir['dadosproprios'];
        //p($vetdadosproprios);

        $vetDN = explode(' ', $vetdadosproprios['row']['data_nascimento']);

        $cpf = FormataCPF12($vetdadosproprios['row']['cgccpf']);
        $idt_complemento_pessoa_c = $vetdadosproprios['row']['idt'];
        $idt_origem_c = $vetdadosproprios['row']['idt_origem'];
        $idt_entidade_c = $vetdadosproprios['row']['idt_entidade'];
        $ativo_c = $vetdadosproprios['row']['ativo'];
        $data_nascimento_c = $vetDN[0];
        $nome_pai_c = $vetdadosproprios['row']['nome_pai'];
        $nome_mae_c = $vetdadosproprios['row']['nome_mae'];
        $idt_ativeconpf = $vetdadosproprios['row']['idt_ativeconpf'];
        $siacweb_situacao = $vetpir['siacweb_situacao'];
        $pa_senha = $vetpir['pa_senha'];
        $pa_idfacebook = $vetpir['pa_idfacebook'];
        $idt_profissao_c = $vetdadosproprios['row']['idt_profissao'];
        $idt_estado_civil_c = $vetdadosproprios['row']['idt_estado_civil'];
        $idt_cor_pele_c = $vetdadosproprios['row']['idt_cor_pele'];
        $idt_religiao_c = $vetdadosproprios['row']['idt_religiao'];
        $idt_destreza_c = $vetdadosproprios['row']['idt_destreza'];
        $idt_sexo_c = $vetdadosproprios['row']['idt_sexo'];
        $necessidade_especial_c = $vetdadosproprios['row']['necessidade_especial'];
        $idt_escolaridade_c = $vetdadosproprios['row']['idt_escolaridade'];
        $receber_informacao_c = $vetdadosproprios['row']['receber_informacao'];
        $nome_tratamento_c = $vetdadosproprios['row']['nome_tratamento'];

        $vetendereco = $vetpir['enderecos'];

        //p($vetendereco);

        $logradouro_p = $vetendereco['row']['logradouro'];
        $logradouro_numero_p = $vetendereco['row']['logradouro_numero'];
        $logradouro_complemento_p = $vetendereco['row']['logradouro_complemento'];
        $logradouro_bairro_p = $vetendereco['row']['logradouro_bairro'];
        $logradouro_municipio_p = $vetendereco['row']['logradouro_municipio'];
        $logradouro_estado_p = $vetendereco['row']['logradouro_estado'];
        $logradouro_pais_p = $vetendereco['row']['logradouro_pais'];
        $logradouro_cep_p = $vetendereco['row']['logradouro_cep'];

        $logradouro_codbairro_p = $vetendereco['row']['logradouro_codbairro'];
        $logradouro_codcid_p = $vetendereco['row']['logradouro_codcid'];
        $logradouro_codest_p = $vetendereco['row']['logradouro_codest'];
        $logradouro_codpais_p = $vetendereco['row']['logradouro_codpais'];

        $cep_p = $vetendereco['row']['cep'];

        $idt_pais_p = $vetendereco['row']['idt_pais'];
        $idt_estado_p = $vetendereco['row']['idt_estado'];
        $idt_cidade_p = $vetendereco['row']['idt_cidade'];

        // Comunicacao
        $vetcomunicacao = $vetpir['comunicacao']['row'];

        $telefone_1_p = $vetcomunicacao['telefone_1_p'];
        $telefone_2_p = $vetcomunicacao['telefone_2_p'];
        $telefone_3_p = $vetcomunicacao['telefone_3_p'];
        $email_1_p = $vetcomunicacao['email_1_p'];
        $sms_1_p = $vetcomunicacao['sms_1_p'];

        // o SMS = telefone celular
        $sms_1_p = $telefone_2_p;
        // Parte variável
        $vetenderecos = $vetpir['enderecos'];
        $vetprotocolos = $vetpir['protocolos'];
        $vetempresas = $vetpir['empresas'];
        $vetempresasPE = $vetempresas['PE'];
        $vetempresasEP = $vetempresas['EP'];

        ForEach ($vetenderecos as $idx => $Vettrab) {
            $vetendereco = $Vettrab['endereco'];
            $vetrow = $vetendereco['row'];
            //
            // 00 é o principal
            //
               //$vetrow['idt_entidade_endereco_tipo'];
            if ($vetrow['gec_eneet_codigo'] != "00" and $vetrow['gec_eneet_codigo'] != "99") {
                continue;
            }
            $logradouro_p = $vetrow['logradouro'];
            $logradouro_numero_p = $vetrow['logradouro_numero'];
            $logradouro_complemento_p = $vetrow['logradouro_complemento'];
            $logradouro_bairro_p = $vetrow['logradouro_bairro'];
            $logradouro_municipio_p = $vetrow['logradouro_municipio'];
            $logradouro_estado_p = $vetrow['logradouro_estado'];
            $logradouro_pais_p = $vetrow['logradouro_pais'];

            $logradouro_codbairro_p = $vetrow['logradouro_codbairro'];
            $logradouro_codcid_p = $vetrow['logradouro_codcid'];
            $logradouro_codest_p = $vetrow['logradouro_codest'];
            $logradouro_codpais_p = $vetrow['logradouro_codpais'];

            $logradouro_cep_p = $vetrow['logradouro_cep'];
            $cep_p = $vetrow['cep'];

            $idt_pais_p = $vetrow['idt_pais'];
            $idt_estado_p = $vetrow['idt_estado'];
            $idt_cidade_p = $vetrow['idt_cidade'];

            $vetcomunicacaow = $vetendereco['comunicacao'];
            if (is_array($vetcomunicacaow)) {
                ForEach ($vetcomunicacaow as $idxw => $VetCom) {
                    //        p($VetCom);
                    $telefone_1_p = $VetCom['comunicacao']['telefone_1'];
                    $telefone_2_p = $VetCom['comunicacao']['telefone_2'];
                    //$telefone_3_p = $VetCom['comunicacao']['telefone_3'];
                    $email_1_p = $VetCom['comunicacao']['email_1'];
                    $email_2_p = $VetCom['comunicacao']['email_2'];
                    $sms_1_p = $VetCom['comunicacao']['sms_1'];
                    $sms_2_p = $VetCom['comunicacao']['sms_2'];
                }
            }
        }

        //Update
        $idt_pessoa = null($idt_entidade);
        $nome_mae = aspa($nome_mae_c);
        $idt_ativeconpf = null($idt_ativeconpf);

        if ($siacweb_situacao == '') {
            $siacweb_situacao = 1;
        }

        $siacweb_situacao = null($siacweb_situacao);
        $pa_senha = aspa($pa_senha);
        $pa_idfacebook = aspa($pa_idfacebook);
        $nome_pai = aspa($nome_pai_c);
        $logradouro_cep = aspa($cep_p);
        $cep = aspa($cep_p);
        $logradouro_endereco = aspa($logradouro_p);
        $logradouro_numero = aspa($logradouro_numero_p);
        $logradouro_bairro = aspa($logradouro_bairro_p);
        $logradouro_complemento = aspa($logradouro_complemento_p);
        $logradouro_cidade = aspa($logradouro_municipio_p);
        $logradouro_estado = aspa($logradouro_estado_p);
        $logradouro_pais = aspa($logradouro_pais_p);

        $logradouro_codbairro_p = null($logradouro_codbairro_p);
        $logradouro_codcid_p = null($logradouro_codcid_p);
        $logradouro_codest_p = null($logradouro_codest_p);
        $logradouro_codpais_p = null($logradouro_codpais_p);

        $idt_pais = null(idt_pais_p);
        $idt_estado = null(idt_estado_p);
        $idt_cidade = null(idt_cidade_p);
        $telefone_residencial = aspa($telefone_1_p);
        $telefone_celular = aspa($telefone_2_p);
        $telefone_recado = aspa($telefone_3_p);

        /*
         * Removido por causa do suporte #606
          if ($telefone_3_p == "") {
          if ($telefone_celular != '') {
          $telefone_recado = $telefone_celular;
          } else {
          $telefone_recado = $telefone_residencial;
          }
          }
         * 
         */

        $email = aspa($email_1_p);
        $sms = aspa($sms_1_p);
        //
        $nome_tratamento = aspa($nome_tratamento_c);
        $idt_escolaridade = null($idt_escolaridade_c);
        $idt_sexo = null($idt_sexo_c);
        $data_nascimento = aspa($data_nascimento_c);
        $receber_informacao = aspa($receber_informacao_c);
        $necessidade_especial = aspa($necessidade_especial_c);
        //
        $idt_profissao = null($idt_profissao_c);
        $idt_estado_civil = null($idt_estado_civil_c);
        $idt_cor_pele = null($idt_cor_pele_c);
        $idt_religiao = null($idt_religiao_c);
        $idt_destreza = null($idt_destreza_c);
        //
        $cpf = aspa($cpf);
        $codigo_siacweb = aspa($codigo_siacweb);
        $nome = aspa($nome_pessoa);
        $tipo_relacao = aspa("L");
        $representa_empresa = aspa('N');
        if ($cnpj_w != "") {
            $representa_empresa = aspa('S');
        }

        $sql = "";
        $sql .= " UPDATE " . db_pir_grc . "grc_atendimento_pessoa";
        $sql .= " SET";
        $sql .= " cpf = $cpf,";
        $sql .= " nome = $nome,";
        $sql .= " nome_mae = $nome_mae,";
        $sql .= " idt_ativeconpf = $idt_ativeconpf,";
        $sql .= " siacweb_situacao = $siacweb_situacao,";
        $sql .= " pa_senha = $pa_senha,";
        $sql .= " pa_idfacebook = $pa_idfacebook,";
        $sql .= " logradouro_cep = $logradouro_cep,";
        $sql .= " logradouro_endereco = $logradouro_endereco,";
        $sql .= " logradouro_numero = $logradouro_numero,";
        $sql .= " logradouro_complemento = $logradouro_complemento,";
        $sql .= " logradouro_codbairro = $logradouro_codbairro_p,";
        $sql .= " logradouro_bairro = $logradouro_bairro,";
        $sql .= " logradouro_codcid = $logradouro_codcid_p,";
        $sql .= " logradouro_cidade = $logradouro_cidade,";
        $sql .= " logradouro_codest = $logradouro_codest_p,";
        $sql .= " logradouro_estado = $logradouro_estado,";
        $sql .= " logradouro_codpais = $logradouro_codpais_p,";
        $sql .= " logradouro_pais = $logradouro_pais,";
        $sql .= " idt_pais = $idt_pais,";
        $sql .= " idt_estado = $idt_estado,";
        $sql .= " idt_cidade = $idt_cidade,";
        $sql .= " telefone_residencial = $telefone_residencial,";
        $sql .= " telefone_celular = $telefone_celular,";
        $sql .= " email = $email,";
        $sql .= " sms = $sms,";
        $sql .= " nome_tratamento = $nome_tratamento,";
        $sql .= " idt_escolaridade = $idt_escolaridade,";
        $sql .= " idt_sexo = $idt_sexo,";
        $sql .= " data_nascimento = $data_nascimento,";
        $sql .= " receber_informacao = $receber_informacao,";
        $sql .= " nome_pai = $nome_pai,";
        $sql .= " necessidade_especial = $necessidade_especial,";
        $sql .= " idt_profissao = $idt_profissao,";
        $sql .= " idt_estado_civil = $idt_estado_civil,";
        $sql .= " idt_cor_pele = $idt_cor_pele,";
        $sql .= " idt_religiao = $idt_religiao,";
        $sql .= " idt_destreza = $idt_destreza,";
        $sql .= " codigo_siacweb = $codigo_siacweb,";
        $sql .= " telefone_recado = $telefone_recado";
        $sql .= " WHERE idt = " . null($idt_atendimento_pessoa);
        $totAlt = execsql($sql, false);

        if ($totAlt > 0) {
            $sql = "";
            $sql .= " UPDATE " . db_pir_grc . "grc_atendimento_pessoa";
            $sql .= " SET";
            $sql .= " evento_alt_siacweb = 'S'";
            $sql .= " WHERE idt = " . null($idt_atendimento_pessoa);
            execsql($sql, false);
        }
    }
}

/**
 * Consulta os participantes do Evento com o SiacWEB
 * @access public
 * @return string Mensagem de Erro
 * @param int $codparceiro <p>
 * CodParceiro do SiacWEB
 * </p>
 * @param string $tipo <p>
 * Tipo do Registro F ou J
 * </p>
 * @param PDO $conSIAC <p>
 * Obejto PDO de conecção com o banco do SiacWEB
 * </p>
 * */
function BuscaDadosEntidadeSIACWEB($codparceiro, $tipo, $conSIAC) {
    $sql = "select * from parceiro as siac_p with(nolock)";

    if ($tipo == 'F') {
        $sql .= " left outer join pessoaf siac_pf with(nolock) on siac_pf.CodParceiro = siac_p.CodParceiro ";
    } else {
        $sql .= " left outer join pessoaj siac_pj with(nolock) on siac_pj.CodParceiro = siac_p.CodParceiro ";
    }

    $sql .= " where siac_p.CodParceiro       = " . null($codparceiro);
    $sql .= "   and siac_p.TipoParceiro = " . aspa($tipo);
    $rs = execsql($sql, false, $conSIAC);
    $qtd_entidade = 0;
    $idt_cliente = "";

    $vetret = Array();
    $tem_dados = true;

    if ($rs->rows == 0) {
        $tem_dados = false;

        $vetret['existe_entidade'] = "N";
        $vetret['tipo_entidade'] = "N";
        $vetret['qtd_entidade'] = $qtd_entidade;
        $vetret['cpfcnpj'] = $cpfcnpj;
        $vetret['idt_cliente'] = $idt_cliente;
    }

    if ($tem_dados) {
        $qtd_pessoa = $rs->rows;
        ForEach ($rs->data as $row) {
            $idt_siacba = $row['codparceiro'];
            $vetret['existe_entidade'] = "S";
            $vetret['tipo_entidade'] = $row['tipoparceiro'];
            $vetret['qtd_entidade'] = $qtd_entidades;
            $vetret['idt_entidade'] = $idt_siacba;
            $vetret['cpf'] = $row['cgccpf'];
            $vetret['idt_cliente'] = $idt_siacba;

            $vetret['codigo_siacweb'] = $idt_siacba;

            $vetret['nomerazaosocial'] = $row['nomerazaosocial'];
            $vetret['nomeabrvfantasia'] = $row['nomeabrvfantasia'];
            $vetret['siacweb_situacao'] = $row['situacao'];
            $vetret['pa_senha'] = '';
            $vetret['pa_idfacebook'] = '';


            if ($tipo == 'F') {
                $row['nome_mae'] = $row['nomemae'];
                // tira hora minuto seg
                $vetDN = explode(' ', $row['datanasc']);
                $row['data_nascimento'] = $vetDN[0];

                // Sexo
                if ($row['sexo'] == 1) {   // masculino
                    $row['idt_sexo'] = 5;
                    $row['nome_tratamento'] = "Sr.";
                }

                if ($row['sexo'] == 0) {   // feminino
                    $row['idt_sexo'] = 6;
                    $row['nome_tratamento'] = "Sra.";
                }

                $sqle = "select * from " . db_pir_gec . "gec_entidade_grau_formacao as gec_gf ";
                $sqle .= " where codigo  = " . aspa($row['codgrauescol']);
                $rse = execsql($sqle, false);
                ForEach ($rse->data as $rowe) {
                    $row['idt_escolaridade'] = $rowe['idt'];
                }

                $sqle = "select * from " . db_pir_gec . "gec_entidade_ativeconpf ";
                $sqle .= " where codigo  = " . aspa($row['codatividadepf']);
                $rse = execsql($sqle);
                ForEach ($rse->data as $rowe) {
                    $row['idt_ativeconpf'] = $rowe['idt'];
                }
            }

            $vetret['dadosproprios']['row'] = $row;

            $sqle = "select * from endereco as siac_en with(nolock) ";
            $sqle .= " where CodParceiro  = " . null($idt_siacba);
            $sqle .= " and EndCorresp = 'SIM'";
            $rse = execsql($sqle, false, $conSIAC);

            if ($rse->rows > 0) {
                $qtd_enderecos = $rse->rows;
                $vetret['endereco'] = $qtd_enderecos;
                $principal = 0;

                ForEach ($rse->data as $rowe) {
                    $idt_siacba = $rowe['codparceiro'];
                    $NumSeqEnd = $rowe['numseqend'];

                    $rowe['logradouro'] = $rowe['descendereco'];
                    $rowe['logradouro_numero'] = $rowe['numero'];
                    $rowe['logradouro_complemento'] = $rowe['complemento'];

                    $CodBairro = $rowe['codbairro'];
                    $CodCid = $rowe['codcid'];
                    $CodEst = $rowe['codest'];
                    $CodPais = $rowe['codpais'];

                    // Pais
                    $sqlt = "select * from pais as siac_pa with(nolock) ";
                    $sqlt .= " where CodPais    = " . null($CodPais);
                    $rst = execsql($sqlt, false, $conSIAC);
                    $logradouro_pais = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_pais = $rowt['descpais'];
                    }

                    // Estado
                    $sqlt = "select * from estado as siac_es with(nolock) ";
                    $sqlt .= " where CodPais   = " . null($CodPais);
                    $sqlt .= "   and CodEst    = " . null($CodEst);
                    $rst = execsql($sqlt, false, $conSIAC);
                    $logradouro_estado = "";
                    $codigo_estado = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_estado = $rowt['descest'];
                        $codigo_estado = $rowt['abrevest'];
                    }

                    // Município
                    $sqlt = "select * from cidade as siac_ci with(nolock) ";
                    $sqlt .= " where CodEst    = " . null($CodEst);
                    $sqlt .= "   and CodCid    = " . null($CodCid);
                    $rst = execsql($sqlt, false, $conSIAC);
                    $logradouro_municipio = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_municipio = $rowt['desccid'];
                    }

                    $sqlt = "select * from bairro as siac_en with(nolock) ";
                    $sqlt .= " where CodCid     = " . null($CodCid);
                    $sqlt .= "   and CodBairro  = " . null($CodBairro);
                    $rst = execsql($sqlt, false, $conSIAC);
                    $logradouro_bairro = "";
                    ForEach ($rst->data as $rowt) {
                        $logradouro_bairro = $rowt['descbairro'];
                    }

                    $rowe['logradouro_bairro'] = $logradouro_bairro;
                    $rowe['logradouro_municipio'] = $logradouro_municipio;
                    $rowe['logradouro_estado'] = $codigo_estado;
                    $rowe['logradouro_pais'] = $logradouro_pais;

                    $rowe['logradouro_codbairro'] = $rowe['codbairro'];
                    $rowe['logradouro_codcid'] = $rowe['codcid'];
                    $rowe['logradouro_codest'] = $rowe['codest'];
                    $rowe['logradouro_codpais'] = $rowe['codpais'];

                    $rowe['logradouro_cep'] = substr($rowe['cep'], 0, 5) . '-' . substr($rowe['cep'], 5, 3);
                    $rowe['cep'] = $rowe['logradouro_cep'];

                    $rowe['idt_pais'] = "";
                    $rowe['idt_estado'] = "";
                    $rowe['idt_cidade'] = "";

                    $principal = $principal + 1;

                    if ($rowe['endcoresp'] == 'SIM') {
                        $rowe['gec_eneet_codigo'] = '00';
                        $vetret['enderecos']['row'] = $rowe;
                        break;
                    } else {
                        $rowe['gec_eneet_codigo'] = '00';
                        $vetret['enderecos']['row'] = $rowe;
                    }
                }
            }

            // comunicação
            $sqle = "select * from comunicacao as siac_co with(nolock) ";
            $sqle .= " where CodParceiro  = " . null($idt_siacba);
            $rse = execsql($sqle, false, $conSIAC);

            if ($rse->rows > 0) {
                $qtd_comunicacao = $rse->rows;
                $vetret['comunicacao']['qtd'] = $qtd_comunicacao;
                $principal = 0;
                $vetSIAC = Array();
                $vetSIAC[1] = 'TELEFONE';
                $vetSIAC[2] = 'FAX';
                $vetSIAC[3] = 'TELEX';
                $vetSIAC[4] = 'URL';
                $vetSIAC[5] = 'TELEFONE CELULAR';
                $vetSIAC[6] = 'TELEFONE COMERCIAL';
                $vetSIAC[11] = 'PÚBLICO';
                $vetSIAC[12] = 'TELEFONE COMUNITÁRIO';
                $vetSIAC[21] = 'TELEFONE RECADO';
                $vetSIAC[22] = 'TELEFONE INTERNACIONAL';
                $vetSIAC[25] = 'E-MAIL';
                $vetSIAC[35] = 'CAIXA POSTAL';
                $vetSIAC[36] = 'BIP';
                $vetSIAC[37] = 'POSTO DE SERVIÇO';
                $vetSIAC[38] = 'Endereço de Correspondência';
                $vetSIAC[39] = 'RAMAL';
                $vetSIAC[40] = 'ANDAR';

                $vetComunicacao = Array();

                ForEach ($rse->data as $rowe) {
                    $codcomunic = $rowe['codcomunic'];
                    $numero = $rowe['numero'];
                    $IndInternet = $rowe['indinternet'];

                    if ($tipo == 'F') {
                        if ($codcomunic == 1) {  // residencial
                            $numero = AjustaTelefoneSiacWEB($numero);
                            $vetComunicacao['telefone_1_p'] = $numero;
                        }
                    } else {
                        if ($codcomunic == 6) {  // residencial
                            $numero = AjustaTelefoneSiacWEB($numero);
                            $vetComunicacao['telefone_1_p'] = $numero;
                        }
                    }

                    if ($codcomunic == 5) {  // celular
                        $numero = AjustaTelefoneSiacWEB($numero);
                        $vetComunicacao['telefone_2_p'] = $numero;
                    }

                    if ($codcomunic == 21) {   // recado
                        $numero = AjustaTelefoneSiacWEB($numero);
                        $vetComunicacao['telefone_3_p'] = $numero;
                    }

                    if ($codcomunic == 25) {
                        $vetComunicacao['email_1_p'] = $numero;
                    }

                    if ($codcomunic == 4) {
                        $vetComunicacao['www_1_p'] = $numero;
                    }
                }

                $vetret['comunicacao']['row'] = $vetComunicacao;
            }
        }
    }

    return $vetret;
}

/**
 * Atualiza os dados do pagamentode uma inscrição em evento
 * @access public
 * @return int Quantidade de registros modificados
 * @param int $codrealizacao <p>
 * Codigo do Evento no SiacWEB
 * </p>
 * @param int $codparceiro <p>
 * CodParceiro do SiacWEB
 * </p>
 * @param int $idt_atendimento <p>
 * IDT do grc_atendimento
 * </p>
 * @param PDO $conSIAC <p>
 * Obejto PDO de conecção com o banco do SiacWEB
 * </p>
 * */
function atualizaPagamentoLojaEvento($codrealizacao, $codparceiro, $idt_atendimento, $conSIAC) {
    global $vetSituacaoPagamento, $vetNaturezaPagamento, $vetBandeiraPagamento, $vetParcelamentoPagamento;

    $totAlt = 0;

    $sql = '_BA_Consulta_Inscritos_Loja';

    $vetBindParam = Array();
    $vetBindParam['CodEvento'] = vetBindParam($codrealizacao, PDO::PARAM_INT);
    $vetBindParam['Codparceiro'] = vetBindParam($codparceiro, PDO::PARAM_INT);

    $rs = execsql($sql, false, $conSIAC, $vetBindParam);

    foreach ($rs->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento_participante_pagamento';
        $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
        $sql .= ' and lojasiac_id = ' . null($row['id']);
        $rst = execsql($sql, false);

        if ($rst->rows == 0) {
            $sql = 'insert into grc_evento_participante_pagamento (idt_atendimento, idt_evento_situacao_pagamento, data_pagamento, valor_pagamento, idt_evento_natureza_pagamento, ';
            $sql .= 'idt_evento_cartao_bandeira, idt_evento_forma_parcelamento, origem_reg, lojasiac_id) values (';
            $sql .= null($idt_atendimento) . ', ' . null($vetSituacaoPagamento[$row['codstatus']]) . ', ' . aspa($row['dataatualizacao']) . ', ' . null($row['valor']) . ', ' . null($vetNaturezaPagamento[$row['codmodalidade']]) . ', ';
            $sql .= null($vetBandeiraPagamento[$row['codbandeira']]) . ', ' . null($vetParcelamentoPagamento[$vetNaturezaPagamento[$row['codmodalidade']]][$row['parcelas']]) . ", 'SIACLOJA', " . null($row['id']) . ')';
            $totAlt += execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' update grc_evento_participante_pagamento set';
            $sql .= ' idt_evento_situacao_pagamento = ' . null($vetSituacaoPagamento[$row['codstatus']]) . ',';
            $sql .= ' data_pagamento = ' . aspa($row['dataatualizacao']) . ',';
            $sql .= ' valor_pagamento = ' . null($row['valor']) . ',';
            $sql .= ' idt_evento_natureza_pagamento = ' . null($vetNaturezaPagamento[$row['codmodalidade']]) . ',';
            $sql .= ' idt_evento_cartao_bandeira = ' . null($vetBandeiraPagamento[$row['codbandeira']]) . ',';
            $sql .= ' idt_evento_forma_parcelamento = ' . null($vetParcelamentoPagamento[$vetNaturezaPagamento[$row['codmodalidade']]][$row['parcelas']]);
            $sql .= ' where idt = ' . null($rst->data[0][0]);
            $totAlt += execsql($sql, false);
        }
    }

    return $totAlt;
}

/**
 * Utilizado para alterar o html da TD grc_atpe_evento_concluio no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_evento_pendente($valor, $row, $Campo) {
    $html = '';

    if ($row['grc_evpa_contrato'] == 'C' || $row['grc_evpa_contrato'] == 'S' || $row['grc_evpa_contrato'] == 'G') {
        if ($row['idt_instrumento'] == 52) {
            $sql = '';
            $sql .= ' select p.idt, e.descricao, i.descricao as instrumento, p.evento_concluio';
            $sql .= ' from grc_atendimento a';
            $sql .= " inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
            $sql .= ' where a.idt_atendimento_pai = ' . null($row['idt']);
            $sql .= " and ep.ativo = 'S'";
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                $valor = $row['evento_concluio'];

                if ($valor == '') {
                    $valor = 'N';
                }

                if ($valor == 'S') {
                    $chk = 'checked';
                } else {
                    $chk = '';
                }

                $html .= '<input ' . $chk . ' type="checkbox" class="cmb_evento_concluio" id="evento_concluio_' . $row['idt'] . '" name="evento_concluio_' . $row['idt'] . '" value="S">';
                $html .= '<label for="evento_concluio_' . $row['idt'] . '">';
                $html .= $row['instrumento'] . ' - ' . $row['descricao'] . '<br />';
                $html .= '</label>';
            }
        } else {
            if ($valor == '') {
                $valor = 'N';
            }

            if ($valor == 'S') {
                $chk = 'checked';
            } else {
                $chk = '';
            }

            $html .= '<input ' . $chk . ' type="checkbox" class="cmb_evento_concluio" name="evento_concluio_' . $row['grc_atpe_idt'] . '" value="S">';
        }
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD evento_resp_pesq_certificado no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_evento_resp_pesq_certificado($valor, $row, $Campo) {
    global $acao, $vetSimNao;

    $html = '';

    if ($row['grc_atpe_evento_concluio'] == 'S') {
        if ($row['idt_instrumento'] == 52) {
            $sql = '';
            $sql .= ' select p.idt, e.descricao, i.descricao as instrumento, p.evento_resp_pesq_certificado';
            $sql .= ' from grc_atendimento a';
            $sql .= " inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
            $sql .= ' where a.idt_atendimento_pai = ' . null($row['idt']);
            $sql .= " and ep.ativo = 'S'";
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                if ($acao == 'alt') {
                    $valor = $row['evento_resp_pesq_certificado'];

                    if ($valor == '') {
                        $valor = 'N';
                    }

                    if ($valor == 'S') {
                        $chk = 'checked';
                    } else {
                        $chk = '';
                    }

                    $html .= '<input ' . $chk . ' type="checkbox" class="cmb_evento_resp_pesq_certificado" id="evento_resp_pesq_certificado_' . $row['idt'] . '" name="evento_resp_pesq_certificado_' . $row['idt'] . '" value="' . $row['grc_atpe_idt'] . '">';
                    $html .= '<label for="evento_resp_pesq_certificado_' . $row['idt'] . '">';
                    $html .= $row['instrumento'] . ' - ' . $row['descricao'];
                    $html .= '</label>';
                } else {
                    $html .= $vetSimNao[$valor];
                }

                $html .= '<span class="certificado_pdf" data-idt="' . $row['grc_atpe_idt'] . '">';

                if ($valor == 'S') {
                    $html .= '<span title="Imprimir Certificado"></span>';
                }

                $html .= '</span>';

                $html .= '<br />';
            }
        } else {
            if ($acao == 'alt') {
                if ($valor == '') {
                    $valor = 'N';
                }

                if ($valor == 'S') {
                    $chk = 'checked';
                } else {
                    $chk = '';
                }

                $html .= '<input ' . $chk . ' type="checkbox" class="cmb_evento_resp_pesq_certificado" name="evento_resp_pesq_certificado_' . $row['grc_atpe_idt'] . '" value="' . $row['grc_atpe_idt'] . '">';
            } else {
                $html .= $vetSimNao[$valor];
            }

            $html .= '<span class="certificado_pdf" data-idt="' . $row['grc_atpe_idt'] . '">';

            if ($valor == 'S') {
                $html .= '<span title="Imprimir Certificado"></span>';
            }

            $html .= '</span>';
        }
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD evento_resp_pesq_certificado no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_evento_certificado($valor, $row, $Campo) {
    $html = '';

    if ($row['grc_atpe_evento_concluio'] == 'S') {
        if ($row['idt_instrumento'] == 52) {
            $sql = '';
            $sql .= ' select p.idt, e.descricao, i.descricao as instrumento, p.evento_resp_pesq_certificado';
            $sql .= ' from grc_atendimento a';
            $sql .= " inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
            $sql .= ' where a.idt_atendimento_pai = ' . null($row['idt']);
            $sql .= " and ep.ativo = 'S'";
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                $html .= '<span class="certificado_pdf" data-idt="' . $row['grc_atpe_idt'] . '">';
                $html .= '<span title="Imprimir Certificado"></span>';
                $html .= '</span>';
                $html .= '<br />';
            }
        } else {
            $html .= '<span class="certificado_pdf" data-idt="' . $row['grc_atpe_idt'] . '">';
            $html .= '<span title="Imprimir Certificado"></span>';
            $html .= '</span>';
        }
    }

    return $html;
}

/**
 * Fila de Espera
 * Utilizado para alterar o html do cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_participante_filaespera($valor, $row, $campo) {
    global $vetEventoMatFE;

    $html = '';

    switch ($campo) {
        case 'habilitado':
            if ($valor == '') {
                $valor = 'N';
            }

            if ($valor == 'S') {
                $chk = 'checked';
            } else {
                $chk = '';
            }

            $html .= '<input ' . $chk . ' type="checkbox" class="habilitado_fe" value="' . $row['grc_atpe_idt'] . '">';
            break;

        case 'fe_situacao':
            $html .= $vetEventoMatFE[$row['fe_situacao']];

            if ($row['fe_situacao'] == 'QP') {
                $html .= '<br />Expirou em ' . trata_data($row['fe_dt_validade'], true);
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Checa se os registros liberado para matrícula da Fila de Espera estão no Prazo
 * @access public
 * @return tipo
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * */
function checaMatFEprazo($idt_evento) {

    $sql = '';
    $sql .= ' select ep.idt_atendimento';
    $sql .= ' from grc_evento_participante ep';
    $sql .= ' inner join grc_atendimento a on a.idt = ep.idt_atendimento';
    $sql .= ' where a.idt_evento = ' . null($idt_evento);
    $sql .= ' and ep.contrato is null';
    $sql .= " and ep.fe_situacao = 'AM'";
    $sql .= ' and ep.fe_dt_validade <= now()';
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        beginTransaction();

        foreach ($rs->data as $row) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pessoa';
            $sql .= ' where idt_atendimento = ' . null($row['idt_atendimento']);
            $rstt = execsql($sql);

            $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - " . $rstt->rows;
            $sql .= " where idt = " . null($idt_evento);
            execsql($sql);

            $sql = 'update grc_evento_participante set';
            $sql .= " contrato = 'FE',";
            $sql .= " fe_situacao = 'QP'";
            $sql .= ' where idt_atendimento = ' . null($row['idt_atendimento']);
            execsql($sql);

            $sql = 'insert into grc_evento_participante_fe_log (idt_evento, idt_atendimento, usuario_nome, usuario_login, situacao) values (';
            $sql .= null($idt_evento) . ', ' . null($row['idt_atendimento']) . ", 'Sistema CRM', 'rotina.automatico', 'QP')";
            execsql($sql);
        }

        commit();
    }
}

/**
 * Utilizado para alterar o html da TD grc_atpe_evento_concluio no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_evento_concluio($valor, $row, $Campo) {
    global $vetSimNao;

    $html = '';
    $html .= $vetSimNao[$valor];

    if ($row['siacweb_hist_erro_cod'] != '') {
        $html .= '';
        $html .= '<br/><span title="[' . $row['siacweb_hist_erro_cod'] . '] ' . $row['siacweb_hist_erro_msg'] . '" style="color:red; cursor:help;">Erro no histórico no SiacWEB</span>';
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD grc_ersit_descricao no listar_conf/grc_produto.php
 * @access public
 * */
function ftd_grc_produto($valor, $row, $campo) {
    $html = '';

    switch ($campo) {
        case 'descricao':
            if ($row['temporario'] == 'S') {
                $html .= '<span class="red" title="O registro esta na situação rascunho, altere para poder confirmar o registro!" style="color: red; font-weight: bold; cursor:help;">REGISTRO EM RASCUNHO</span><br />';
            }

            $html .= $valor;
            break;

        case 'ficha':
            $url = 'conteudo_pdf.php?prefixo=cadastro&menu=grc_produto&titulo_rel=Ficha%20T%E9cnica%20do%20Produto&print_tela=S&id=' . $row['idt'];
            $onclick = "OpenWin('" . $url . "', 'ficha" . $row['idt'] . "', screen.width, screen.height, 0, 0, 'yes');";
            $html .= '<img src="imagens/ficha.png" alt="Ficha Técnica" style="cursor: pointer;" onclick="' . $onclick . '" />';
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD no listar_conf/ftd_grc_sincroniza_ws_sg.php
 * @access public
 * */
function ftd_grc_sincroniza_ws_sg($valor, $row, $campo) {
    $html = '';

    switch ($campo) {
        case 'ws_sg_erro':
            if ($row['ws_sg_idt_erro_log'] == '') {
                $html .= $valor;
            } else {
                $url = 'ajax.php?tipo=erro_log&idt=' . $row['ws_sg_idt_erro_log'];
                $html .= '<span style="color: red; cursor:pointer;" onclick="showPopWin(\'' . $url . '\', \'Classe do Erro\', $(window).width() - 40, $(window).height() - 100, null);">' . $valor . '</span>';
            }

            if ($valor != '') {
                $html .= '<div style="cursor:pointer;" onclick="btReprocessar(' . $row['idt'] . ', ' . $row['idt_atendimento_pessoa'] . ', false)">Reprocessar</div>';
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD grc_ersit_descricao no listar_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento($valor, $row, $campo) {
    global $vetEventoPublicaInternet, $vetEventoPubilcar;

    $html = '';

    switch ($campo) {
        case 'grc_ersit_descricao':
            if ($row['idt_evento_situacao'] == 20 && $row['siac_at_erro_con'] == 'S') {
                $valor = '<span style="color: red; font-weight: bold;">CONSOLIDADO COM ERRO: EXERCÍCIO FECHADO PARA CONTABILIZAÇÃO</span>';
            }

            if ($row['grc_ersit_ant_descricao'] == '') {
                $html .= $valor;
            } else {
                $html .= '<span title="Situação Anterior: ' . $row['grc_ersit_ant_descricao'] . '" style="cursor:help;">' . $valor . '</span>';
            }
            break;

        case 'descricao':
            if ($row['temporario'] == 'S') {
                $html .= '<span class="red" title="O registro esta na situação rascunho, salve ou envie para aprovação para poder confirmar o registro!" style="color: red; font-weight: bold; cursor:help;">REGISTRO EM RASCUNHO</span><br />';
            }

            $html .= $valor;
            break;

        case 'ordem_contratacao':
            $ordem = false;

            if ($row['cred_necessita_credenciado'] == 'S' && $row['cred_rodizio_auto'] == 'S') {
                $ordem = true;
            }

            if ($row['cred_necessita_credenciado'] == 'S' && $row['cred_rodizio_auto'] == 'N' && $row['cred_credenciado_sgc'] == 'S') {
                $ordem = true;
            }

            if ($row['idt_evento_situacao'] < 14 && $row['grc_pr_tipo_ordem'] == 'GC') {
                $ordem = false;
            }

            if ($ordem) {
                if ($row['idt_evento'] == '') {
                    $idt_evento = $row['idt'];
                } else {
                    $idt_evento = $row['idt_evento'];
                }

                $html .= "<a href='conteudo.php?prefixo=listar&menu=gec_contratacao_credenciado_ordem&origem_tela=menu&class=0&idt_evento=" . $idt_evento . "' target='_blank' class='Titulo'>";
                $html .= "Credenciado";
                $html .= "</a>";
            }
            break;

        case 'composto':
            if ($row['composto'] == 'S') {
                $html .= "Composto (Principal)";
            } else {
                if ($row['idt_evento_pai'] == '') {
                    $html .= "Simples";
                } else {
                    $html .= "Composto";
                }
            }
            break;

        case 'pubilcar_situacao':
            if ($row['publica_internet'] == 'S') {
                $html .= $vetEventoPublicaInternet[$row['publica_internet']];
            } else {
                $html .= $vetEventoPubilcar[$row['pubilcar_situacao']];

                if ($html == '') {
                    $html .= $vetEventoPublicaInternet[$row['publica_internet']];
                }
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD grc_ersit_descricao no listar_conf/grc_evento_monitoramento.php
 * @access public
 * */
function ftd_grc_evento_monitoramento($valor, $row, $campo) {
    global $vetAFProcessoSit, $vetAFProcessoFI;

    $html = '';

    switch ($campo) {
        case 'grc_ersit_descricao':
            if ($row['grc_ersit_ant_descricao'] == '') {
                $html .= $valor;
            } else {
                $html .= '<span title="Situação Anterior: ' . $row['grc_ersit_ant_descricao'] . '" style="cursor:help;">' . $valor . '</span>';
            }
            break;

        case 'descricao':
            if ($row['temporario'] == 'S') {
                $html .= '<span class="red" title="O registro esta na situação rascunho, salve ou envie para aprovação para poder confirmar o registro!" style="color: red; font-weight: bold; cursor:help;">REGISTRO EM RASCUNHO</span><br />';
            }

            $html .= $valor;
            break;

        case 'ordem_contratacao':
            $html .= "<a href='conteudo.php?prefixo=listar&menu=gec_contratacao_credenciado_ordem&origem_tela=menu&class=0&idt_evento=" . $row['idt'] . "' target='_blank' class='Titulo'>";
            $html .= 'GC: ' . $row['ordem_contratacao'] . '<br />';
            $html .= 'SGC: ' . $row['chave_sgc'] . '<br />';
            $html .= "</a>";
            break;

        case 'rm_consolidado':
            switch ($row['rm_consolidado']) {
                case 'P':
                    $html .= 'Empenhado<br />';
                    $html .= 'Cod. RM: ' . $row['rm_idmov'] . '<br />';
                    $html .= 'R$ ' . format_decimal($row['valor_prev']) . ' (' . $row['mesano'] . ')' . '<br />';
                    break;

                case 'R':
                    $html .= 'Realizado<br />';
                    $html .= 'Cod. RM: ' . $row['rm_idmov'] . '<br />';
                    $html .= 'R$ ' . format_decimal($row['valor_real']) . ' (' . $row['mesano'] . ')' . '<br />';
                    break;

                default:
                    $html .= 'Falta Empenhar<br />';
                    break;
            }

            if ($row['rm_idmov'] != '') {
                $html .= '<span title="Fazer esta sincronização quando o processo não estiver aparecendo na Etapa 1" style="color: red; cursor: pointer;" onclick="sincronizaRM(' . $row['rm_idmov'] . ')">Sincronizar com RM - Problema na Etapa 1</span>';
            }
            break;

        case 'situacao_reg':
            if ($row['situacao_reg'] == '') {
                $html .= 'O credenciado não consultou este processo';
            } else {
                $html .= $vetAFProcessoSit[$row['situacao_reg']];

                if ($row['situacao_reg'] == 'FI') {
                    $html .= '<br />' . $vetAFProcessoFI[$row['gfi_situacao']];
                }
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html do ListarConf grc_evento_participante no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_participante($valor, $row, $campo) {
    global $vetSimNao, $vetEventoContrato, $vetEventoMatFE;

    $html = '';

    switch ($campo) {
        case 'grc_atpe_evento_alt_siacweb':
            if ($vetSimNao[$row['grc_atpe_evento_alt_siacweb']] == '') {
                $html .= $row['grc_atpe_evento_alt_siacweb'];
            } else {
                $html .= $vetSimNao[$row['grc_atpe_evento_alt_siacweb']];
            }

            if ($row['grc_atpe_evento_exc_siacweb'] == 'S') {
                $html .= '<br />Inscrição Excluida no SiacWEB';
            } else if ($row['grc_atpe_evento_inscrito'] == 'N' && $row['grc_evpa_contrato'] != 'IC') {
                $html .= '<br />Inscrição não realizada no SiacWEB';
            }
            break;

        case 'grc_evpa_contrato':
            if ($valor == '') {
                if ($row['fe_situacao'] != '') {
                    $html .= $vetEventoMatFE[$row['fe_situacao']];

                    if ($row['fe_situacao'] == 'AM') {
                        $html .= '<br />Expira em ' . trata_data($row['fe_dt_validade'], true);
                    }
                }
            } else {
                $html .= $vetEventoContrato[$valor];
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_consolidado_siacweb($valor, $row, $campo) {
    global $vetSimNao;

    $html = '';

    switch ($campo) {
        case 'consolidado_siacweb':
            if ($row['consolidado_siacweb'] == 'S') {
                $html .= 'Consolidada';
            } else if ($row['consolidado_cred'] == 'S') {
                $html .= 'Aguardando Aprovação de Prestação de Contas';
            } else {
                $html .= 'Aguardando Prestação de Contas';
            }
            break;
    }

    return $html;
}

/**
 * Retorna o html do resumo_evento_receita_despesa
 * @access public
 * @return string
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * */
function html_resumo_evento_receita_despesa($idt_evento) {
    $sql = '';
    $sql .= ' select idt_evento_pai, composto';
    $sql .= ' from grc_evento';
    $sql .= ' where idt = ' . null($idt_evento);
    $rsa = execsql($sql);
    $rowa = $rsa->data[0];

    $idt_evento_pai = $rowa['idt_evento_pai'];

    if ($idt_evento_pai == '' && $rowa['composto'] == 'S') {
        $idt_evento_pai = $idt_evento;
    }

    if ($idt_evento_pai == '') {
        $idtFilho = $idt_evento;
    } else {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento';
        $sql .= ' where idt_evento_pai = ' . null($idt_evento_pai);
        $rs = execsql($sql, $trata_erro);

        $idtFilho = Array();
        $idtFilho[] = 0;

        foreach ($rs->data as $row) {
            $idtFilho[] = $row['idt'];
        }

        $idtFilho = implode(', ', $idtFilho);
    }

    $sql = '';
    $sql .= ' select grc_ei.codigo, grc_ei.custo_total, grc_ei.receita_total, grc_i.sinal';
    $sql .= ' from grc_evento_insumo grc_ei';
    $sql .= " inner join grc_insumo grc_i on grc_i.idt = grc_ei.idt_insumo";
    $sql .= ' where grc_ei.idt_evento in (' . $idtFilho . ')';
    $rs = execsql($sql);

    $receita = 0;
    $desp_geral = 0;
    $desp_70 = 0;

    foreach ($rs->data as $row) {
        if ($row['sinal'] == 'S') {
            $pre = substr($row['codigo'], 0, 2);
            if ($pre == '70' || $pre == '71') {
                $desp_70 += $row['custo_total'];
            } else {
                $desp_geral += $row['custo_total'];
            }
        } else {
            $receita += $row['receita_total'];
        }
    }

    $desp_total = $desp_geral + $desp_70;
    $resultado = $receita - $desp_total;

    $html = '';
    $html .= '<table border="0" cellpadding="0" width="100%" cellspacing="0">';
    $html .= '<tr class="resumo_cab"> ';
    $html .= '<td rowspan="2" class="border_r">';
    $html .= 'RECEITA';
    $html .= '</td>';
    $html .= '<td colspan="3" class="border_r">';
    $html .= 'DESPESA';
    $html .= '</td>';
    $html .= '<td rowspan="2">';
    $html .= 'RESULTADO';
    $html .= '</td>';
    $html .= '</tr> ';

    $html .= '<tr class="resumo_cab"> ';
    $html .= '<td>';
    $html .= 'INSUMOS';
    $html .= '</td>';
    $html .= '<td>';
    $html .= 'CREDENCIADO';
    $html .= '</td>';
    $html .= '<td class="border_r">';
    $html .= 'TOTAL';
    $html .= '</td>';
    $html .= '</tr> ';

    $html .= '<tr class="resumo_det"> ';
    $html .= '<td class="border_r">';
    $html .= format_decimal($receita);
    $html .= '</td>';
    $html .= '<td>';
    $html .= format_decimal($desp_geral);
    $html .= '</td>';
    $html .= '<td>';
    $html .= format_decimal($desp_70);
    $html .= '</td>';
    $html .= '<td class="border_r">';
    $html .= format_decimal($desp_total);
    $html .= '</td>';
    $html .= '<td>';
    $html .= format_decimal($resultado);
    $html .= '</td>';
    $html .= '</tr> ';

    $html .= '</table><br />';

    $html .= '<input type="hidden" id="previsao_despesa" value="' . $desp_total . '" />';

    return $html;
}

/**
 * Sincroniza cadastro de Organização com GEC
 * @access public
 * @param int $idt <p>
 * IDT do grc_entidade_organizacao
 * </p>
 * */
function sincronizaEntidadeOrganizacaoGEC($idt) {
    global $vetSistemaUtiliza, $microtime;

    //grc_entidade_organizacao
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_organizacao';
    $sql .= ' where idt = ' . null($idt);
    $rs = execsql($sql);
    $row = $rs->data[0];

    if (($row['idt_tipo_empreendimento'] == 7 || $row['idt_tipo_empreendimento'] == 13) && $row['codigo_prod_rural'] == '') {
        $row['codigo_prod_rural'] = 'PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc);
    }

    if ($row['cnpj'] == '') {
        $row['cnpj'] = $row['codigo_prod_rural'];
    }

    $idt_entidade = '';

    $vetRetorno = Array();

    if ($row['idt_tipo_empreendimento'] == 7 || $row['idt_tipo_empreendimento'] == 13) {
        $tipo_registro = 'PR';
    } else {
        $tipo_registro = 'OP';
    }

    //grc_entidade_organizacao_cnae
    $vetCNAE = Array();

    if ($row['idt_cnae_principal'] != '') {
        $vetCNAE[$row['idt_cnae_principal']] = Array(
            'cnae' => $row['idt_cnae_principal'],
            'principal' => 'S',
        );
    }

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_organizacao_cnae';
    $sql .= ' where idt_entidade_organizacao = ' . null($row['idt']);
    $rst = execsql($sql);

    foreach ($rst->data as $rowt) {
        if ($vetCNAE[$rowt['cnae']] == '') {
            $vetCNAE[$rowt['cnae']] = Array(
                'cnae' => $rowt['cnae'],
                'principal' => 'N',
            );
        }
    }

    $dadosGEC = Array(
        'codigo' => $row['cnpj'],
        'descricao' => $row['razao_social'],
        'ativo' => 'S',
        'tipo_entidade' => 'O',
        'idt_entidade_classe' => 45,
        'resumo' => $row['nome_fantasia'],
        'codigo_siacweb' => $row['codigo_siacweb_e'],
        'idt_ult_representante_emp' => $row['idt_representa'],
        'representa_codcargcli' => $row['representa_codcargcli'],
        'idt_situacao' => 2,
        'natureza' => 'CLI.FOR',
        'codigo_prod_rural' => $row['codigo_prod_rural'],
        'receber_informacao' => $row['receber_informacao_e'],
        'idt_entidade_tipo_emp' => $row['idt_tipo_empreendimento'],
        'tipo_registro' => $tipo_registro,
        'siacweb_situacao' => $row['siacweb_situacao_e'],
        'pa_senha' => $row['pa_senha_e'],
        'pa_idfacebook' => $row['pa_idfacebook_e'],
        'gec_entidade_organizacao' => Array(
            Array(
                //'inscricao_estadual' => $row[''],
                //'inscricao_municipal' => $row[''],
                //'registro_junta' => $row[''],
                //'data_registro' => $row[''],
                'ativo' => 'S',
                'idt_porte' => $row['idt_porte'],
                //'idt_tipo' => $row[''],
                //'idt_natureza_juridica' => $row[''],
                //'idt_faturamento' => $row[''],
                //'faturamento' => $row[''],
                'qt_funcionarios' => $row['pessoas_ocupadas'],
                'data_inicio_atividade' => $row['data_abertura'],
                'tamanho_propriedade' => $row['tamanho_propriedade'],
                'dap' => $row['dap'],
                'nirf' => $row['nirf'],
                'rmp' => $row['rmp'],
                'ie_prod_rural' => $row['ie_prod_rural'],
                'sicab_codigo' => $row['sicab_codigo'],
                'sicab_dt_validade' => $row['sicab_dt_validade'],
                'data_fim_atividade' => $row['data_fim_atividade'],
                'simples_nacional' => $row['simples_nacional'],
                'idt_entidade_setor' => $row['idt_setor'],
                'gec_entidade_cnae' => $vetCNAE,
            ),
        ),
        'gec_entidade_endereco' => Array(
            Array(
                'logradouro' => $row['logradouro_endereco_e'],
                'logradouro_numero' => $row['logradouro_numero_e'],
                'logradouro_complemento' => $row['logradouro_complemento_e'],
                'logradouro_bairro' => $row['logradouro_bairro_e'],
                'logradouro_municipio' => $row['logradouro_cidade_e'],
                'logradouro_estado' => $row['logradouro_estado_e'],
                'logradouro_pais' => $row['logradouro_pais_e'],
                'logradouro_referencia' => $row['logradouro_referencia_e'],
                'logradouro_cep' => $row['logradouro_cep_e'],
                'logradouro_codbairro' => $row['logradouro_codbairro_e'],
                'logradouro_codcid' => $row['logradouro_codcid_e'],
                'logradouro_codest' => $row['logradouro_codest_e'],
                'logradouro_codpais' => $row['logradouro_codpais_e'],
                'cep' => $row['logradouro_cep_e'],
                'idt_entidade_endereco_tipo' => 8,
                'ativo' => 'S',
                'gec_entidade_comunicacao' => Array(
                    Array(
                        'origem' => 'ATENDIMENTO PRINCIPAL',
                        'telefone_1' => $row['telefone_comercial_e'],
                        'telefone_2' => $row['telefone_celular_e'],
                        'email_1' => $row['email_e'],
                        'sms_1' => $row['sms_e'],
                        'www_1' => $row['site_url'],
                    ),
                ),
            ),
        ),
    );

    //grc_entidade_organizacao_tipo_informacao
    $sql = '';
    $sql .= ' select idt_tipo_informacao_e';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_organizacao_tipo_informacao';
    $sql .= ' where idt = ' . null($row['idt']);
    $rst = execsql($sql);

    $vetTmp = Array();

    foreach ($rst->data as $rowt) {
        $vetTmp[] = Array(
            'idt_tipo_informacao' => $rowt['idt_tipo_informacao_e'],
        );
    }

    $dadosGEC['gec_entidade_x_tipo_informacao'] = $vetTmp;

    $idt_entidade = sincronizaGecEntidade($dadosGEC, $vetRetorno);

    if ($row['idt_entidade'] == '') {
        $sql = 'update ' . db_pir_grc . 'grc_entidade_organizacao';
        $sql .= " set idt_entidade = " . null($idt_entidade);
        $sql .= ' where idt = ' . null($idt);
        execsql($sql);
    }

    $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
    $sql .= ' set idt_entidade_relacao = 13';
    $sql .= ' where idt_entidade = ' . null($row['idt_representa']);
    $sql .= ' and idt_entidade_relacao = 12';
    execsql($sql);

    $sql = '';
    $sql .= ' select idt, idt_entidade_relacao';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade';
    $sql .= ' where idt_entidade = ' . null($row['idt_representa']);
    $sql .= ' and idt_entidade_relacionada = ' . null($idt_entidade);
    $sql .= ' and idt_entidade_relacao in (12, 13)';
    $sql .= ' order by idt_entidade_relacao limit 1';
    $rst = execsql($sql);
    $idt = $rst->data[0]['idt'];
    $idt_entidade_relacao = $rst->data[0]['idt_entidade_relacao'];

    if ($idt == '') {
        $sql = 'insert into ' . db_pir_gec . 'gec_entidade_entidade (';
        $sql .= ' idt_entidade, idt_entidade_relacionada, idt_entidade_relacao, ativo, data_inicio, representa_codcargcli';
        $sql .= ' ) values (';
        $sql .= null($row['idt_representa']) . ', ' . null($idt_entidade) . ", 12, 'S', now(), " . null($row['representa_codcargcli']);
        $sql .= ' )';
        execsql($sql);
    } else if ($idt_entidade_relacao == 12) {
        $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
        $sql .= ' set ';
        $sql .= " ativo = 'S', data_termino = null";
        $sql .= ' , representa_codcargcli = ' . null($row['representa_codcargcli']);
        $sql .= ' where idt = ' . null($idt);
        execsql($sql);
    } else {
        $sql = 'update ' . db_pir_gec . 'gec_entidade_entidade';
        $sql .= ' set idt_entidade_relacao = 12,';
        $sql .= " ativo = 'S', data_inicio = now(), data_termino = null";
        $sql .= ' , representa_codcargcli = ' . null($row['representa_codcargcli']);
        $sql .= ' where idt = ' . null($idt);
        execsql($sql);
    }

    $codigo_siacweb = sincronizaSIACcad($idt_entidade, 0, 'S');

    $sql = 'update ' . db_pir_grc . 'grc_entidade_organizacao';
    $sql .= " set codigo_siacweb_e = " . aspa($codigo_siacweb);
    $sql .= ' where idt = ' . null($idt);
    execsql($sql);

    return $idt_entidade;
}

/**
 * Sincroniza cadastro de Pessoa com GEC
 * @access public
 * @param int $idt <p>
 * IDT do grc_entidade_pessoa
 * </p>
 * */
function sincronizaEntidadePessoaGEC($idt, $trata_erro = true) {
    global $vetSistemaUtiliza, $microtime;

    //Pessoa
    $vetRetorno = Array();

    //grc_entidade_pessoa
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa';
    $sql .= ' where idt = ' . null($idt);
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];

    //grc_entidade_pessoa_tipo_deficiencia
    $sql = '';
    $sql .= ' select idt_tipo_deficiencia';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_tipo_deficiencia';
    $sql .= ' where idt = ' . null($row['idt']);
    $rst = execsql($sql, $trata_erro);

    $vetTipoDeficiencia = Array();

    foreach ($rst->data as $rowt) {
        $vetTipoDeficiencia[] = Array(
            'idt_tipo_deficiencia' => $rowt['idt_tipo_deficiencia'],
        );
    }

    $dadosGEC = Array(
        'codigo' => $row['cpf'],
        'descricao' => $row['nome'],
        'ativo' => 'S',
        'tipo_entidade' => 'P',
        'idt_entidade_classe' => 67,
        'resumo' => $row['nome'],
        'codigo_siacweb' => $row['codigo_siacweb'],
        'idt_situacao' => 2,
        'natureza' => 'CLI',
        'receber_informacao' => $row['receber_informacao'],
        'siacweb_situacao' => $row['siacweb_situacao'],
        'pa_senha' => $row['pa_senha'],
        'pa_idfacebook' => $row['pa_idfacebook'],
        'gec_entidade_pessoa' => Array(
            Array(
                'ativo' => 'S',
                'data_nascimento' => $row['data_nascimento'],
                'nome_pai' => $row['nome_pai'],
                'nome_mae' => $row['nome_mae'],
                'idt_ativeconpf' => $row['idt_ativeconpf'],
                'idt_profissao' => $row['idt_profissao'],
                'idt_estado_civil' => $row['idt_estado_civil'],
                'idt_cor_pele' => $row['idt_cor_pele'],
                'idt_religiao' => $row['idt_religiao'],
                'idt_destreza' => $row['idt_destreza'],
                'idt_sexo' => $row['idt_sexo'],
                'necessidade_especial' => $row['necessidade_especial'],
                'idt_escolaridade' => $row['idt_escolaridade'],
                'nome_tratamento' => $row['nome_tratamento'],
                'idt_tipo_deficiencia' => $row[''],
                'idt_segmentacao' => $row['idt_segmentacao'],
                'idt_subsegmentacao' => $row['idt_subsegmentacao'],
                'idt_programa_fidelidade' => $row['idt_programa_fidelidade'],
                'potencial_personagem' => $row['potencial_personagem'],
                'gec_entidade_pessoa_tipo_deficiencia' => $vetTipoDeficiencia,
            ),
        ),
        'gec_entidade_endereco' => Array(
            Array(
                'logradouro' => $row['logradouro_endereco'],
                'logradouro_numero' => $row['logradouro_numero'],
                'logradouro_complemento' => $row['logradouro_complemento'],
                'logradouro_bairro' => $row['logradouro_bairro'],
                'logradouro_municipio' => $row['logradouro_cidade'],
                'logradouro_estado' => $row['logradouro_estado'],
                'logradouro_pais' => $row['logradouro_pais'],
                'logradouro_referencia' => $row['logradouro_referencia'],
                'logradouro_cep' => $row['logradouro_cep'],
                'logradouro_codbairro' => $row['logradouro_codbairro'],
                'logradouro_codcid' => $row['logradouro_codcid'],
                'logradouro_codest' => $row['logradouro_codest'],
                'logradouro_codpais' => $row['logradouro_codpais'],
                'cep' => $row['logradouro_cep'],
                'idt_entidade_endereco_tipo' => 8,
                'ativo' => 'S',
                'gec_entidade_comunicacao' => Array(
                    Array(
                        'origem' => 'ATENDIMENTO PRINCIPAL',
                        'telefone_1' => $row['telefone_residencial'],
                        'telefone_2' => $row['telefone_celular'],
                        'email_1' => $row['email'],
                        'sms_1' => $row['sms'],
                    ),
                    Array(
                        'origem' => 'ATENDIMENTO RECADO',
                        'telefone_1' => $row['telefone_recado'],
                    ),
                ),
            ),
        ),
    );

    //grc_entidade_pessoa_arquivo_interesse
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_arquivo_interesse';
    $sql .= ' where idt_entidade_pessoa = ' . null($row['idt']);
    $rst = execsql($sql, $trata_erro);

    if (path_fisico == 'path_fisico') {
        define('path_fisico', mb_strtolower($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'sebrae_grc' . DIRECTORY_SEPARATOR . 'admin');
    }

    if ($microtime == '') {
        $microtime = substr(time(), -3);
    }

    $vetTmp = Array();

    foreach ($rst->data as $rowt) {
        $vetPrefixoArq = explode('_', $rowt['arquivo']);
        $PrefixoArq = '';
        $PrefixoArq .= $vetPrefixoArq[0] . '_';
        $PrefixoArq .= $vetPrefixoArq[1] . '_';
        $PrefixoArq .= $vetPrefixoArq[2] . '_';
        $arq_novo = GerarStr() . '_arquivo_' . $microtime . '_' . substr($rowt['arquivo'], strlen($PrefixoArq));

        $vetRetorno['arqCopia'][] = Array(
            'de' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_entidade_pessoa_arquivo_interesse/' . $rowt['arquivo']),
            'para' => str_replace('/', DIRECTORY_SEPARATOR, $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_entidade_arquivo_interesse/' . $arq_novo),
        );

        $vetTmp[] = Array(
            'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
            'data_registro' => $rowt['data_registro'],
            'titulo' => $rowt['titulo'],
            'arquivo' => $arq_novo,
        );
    }

    $dadosGEC['gec_entidade_arquivo_interesse'] = $vetTmp;

    //grc_entidade_pessoa_produto_interesse
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_produto_interesse';
    $sql .= ' where idt_entidade_pessoa = ' . null($row['idt']);
    $rst = execsql($sql, $trata_erro);

    $vetTmp = Array();

    foreach ($rst->data as $rowt) {
        $vetTmp[] = Array(
            'idt_produto' => $rowt['idt_produto'],
            'observacao' => $rowt['observacao'],
            'data_registro' => $rowt['data_registro'],
            'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
        );
    }

    $dadosGEC['gec_entidade_produto_interesse'] = $vetTmp;

    //grc_entidade_pessoa_tema_interesse
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_tema_interesse';
    $sql .= ' where idt_entidade_pessoa = ' . null($row['idt']);
    $rst = execsql($sql, $trata_erro);

    $vetTmp = Array();

    foreach ($rst->data as $rowt) {
        $vetTmp[] = Array(
            'idt_tema' => $rowt['idt_tema'],
            'idt_subtema' => $rowt['idt_subtema'],
            'observacao' => $rowt['observacao'],
            'idt_responsavel' => IdUsuarioPIR($rowt['idt_responsavel'], db_pir_grc, db_pir_gec),
            'data_registro' => $rowt['data_registro'],
        );
    }

    $dadosGEC['gec_entidade_tema_interesse'] = $vetTmp;

    //grc_entidade_pessoa_tipo_informacao
    $sql = '';
    $sql .= ' select idt_tipo_informacao';
    $sql .= ' from ' . db_pir_grc . 'grc_entidade_pessoa_tipo_informacao';
    $sql .= ' where idt = ' . null($row['idt']);
    $rst = execsql($sql, $trata_erro);

    $vetTmp = Array();

    foreach ($rst->data as $rowt) {
        $vetTmp[] = Array(
            'idt_tipo_informacao' => $rowt['idt_tipo_informacao'],
        );
    }

    $dadosGEC['gec_entidade_x_tipo_informacao'] = $vetTmp;

    $idt_entidade = sincronizaGecEntidade($dadosGEC, $vetRetorno);

    if ($row['idt_entidade'] == '') {
        $sql = 'update ' . db_pir_grc . 'grc_entidade_pessoa';
        $sql .= " set idt_entidade = " . null($idt_entidade);
        $sql .= ' where idt = ' . null($idt);
        execsql($sql, $trata_erro);
    }

    $codigo_siacweb = sincronizaSIACcad($idt_entidade, 0, 'S');

    $sql = 'update ' . db_pir_grc . 'grc_entidade_pessoa ';
    $sql .= " set codigo_siacweb = " . aspa($codigo_siacweb);
    $sql .= ' where idt = ' . null($row['idt']);
    execsql($sql, $trata_erro);

    if (is_array($vetRetorno['arqCopia'])) {
        foreach ($vetRetorno['arqCopia'] as $arq) {
            if (is_file($arq['de'])) {
                copy($arq['de'], $arq['para']);
            }
        }
    }

    if (is_array($vetRetorno['arqDeletar'])) {
        foreach ($vetRetorno['arqDeletar'] as $arq) {
            if (is_file($arq)) {
                unlink($arq);
            }
        }
    }

    return $idt_entidade;
}

/**
 * Utilizado para alterar o html da TD grc_ersit_descricao no listar_conf/grc_entidade_organizacao.php
 * @access public
 * */
function ftd_gec_entidade($valor, $row, $campo) {
    global $vetTipoOrganizacao;

    $html = '';

    switch ($campo) {
        case 'codigo':
            if ($row['tipo_registro'] == 'PR') {
                $vet = Array();

                if ($row['codigo'][0] != 'P') {
                    $vet['codigo'] = $row['codigo'];
                }

                if ($row['dap'] != '') {
                    $vet['dap'] = $row['dap'];
                }

                if ($row['nirf'] != '') {
                    $vet['nirf'] = $row['nirf'];
                }

                if ($row['rmp'] != '') {
                    $vet['rmp'] = $row['rmp'];
                }

                if ($row['ie_prod_rural'] != '') {
                    $vet['ie_prod_rural'] = $row['ie_prod_rural'];
                }

                if ($row['sicab_codigo'] != '') {
                    $vet['sicab_codigo'] = $row['sicab_codigo'];
                }

                $html .= implode('<br />', $vet);
            } else {
                $html .= $valor;
            }
            break;

        case 'tipo_registro':
            if ($row['tipo_registro'] == 'PR') {
                $html .= $vetTipoOrganizacao[$row['idt_entidade_tipo_emp']];
            } else {
                $html .= $vetTipoOrganizacao['cnpj'];
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_grc_evento_pfo_af_processo_item($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['PFO']['path'] . 'admin/obj_file/pfo_af_processo_item/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['PFO']['path'] . 'admin/', $vetSistemaUtiliza['PFO']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href="' . $url . '" target="_blank">Link GED</a>';
            }
            break;

        case 'situacao':
            if ($row['situacao'] == 'AP') {
                $checked = 'checked="checked"';
                $lbl = 'Conferido';
            } else {
                $checked = '';
                $lbl = 'Pendente';
            }

            $html .= '<input type="checkbox" ' . $checked . ' data-tipo_documento="' . $row['tipo_documento'] . '" id="pfoafpi' . $row['idt'] . '" name="pfo_situacao[' . $row['idt'] . '][vl]" value="AP" />';
            $html .= '<label for="pfoafpi' . $row['idt'] . '" class="Tit_Campo_Obr">' . $lbl . '</label>';
            $html .= '<br />';
            $html .= '<input type="text" class="Texto pfoObs" name="pfo_situacao[' . $row['idt'] . '][obs]" value="' . $row['obs_validacao'] . '" maxlength="255" size="30" />';
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_grc_evento_pfo_af_processo_item_ds_per($row, $session_cod) {
    global $vetSistemaUtiliza;

    $title = 'Gerar PDF da Declaração de Entrega';

    $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $vetSistemaUtiliza['PFO']['url']);
    $url = 'conteudo_pdf.php?menu=declaracao_entrega_sg&prefixo=cadastro_export&id=' . $row['idt'];

    $html = '';
    $html .= "<a href='{$url}' target='_blank' title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/bt_print_32.png' width='16' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function fnc_grc_evento_rm($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'autorizar_nf_sem_doc':
            if ($row['autorizar_nf_sem_doc'] == 'S') {
                $checked = 'checked="checked"';
                $lbl = 'Sim';
            } else {
                $checked = '';
                $lbl = 'Não';
            }

            $sql = "select pi.idt ";
            $sql .= " from " . db_pir_pfo . "pfo_af_processo_item pi";
            $sql .= " inner join " . db_pir_pfo . "pfo_af_processo afp on pi.idt_processo = afp.idt";
            $sql .= ' where afp.idmov = ' . null($row['rm_idmov']);
            $sql .= ' and pi.arquivo is not null';
            $rsCE = execsql($sql);

            if ($rsCE->rows == 0) {
                $autorizar_nf_sem_doc_alt = 'S';
            } else {
                $autorizar_nf_sem_doc_alt = 'N';
            }

            $html .= '<input type="checkbox" ' . $checked . ' data-liberado="' . $autorizar_nf_sem_doc_alt . '" id="pfoafp' . $row['idt'] . '" name="gec_autorizar_nf_sem_doc[' . $row['idt'] . ']" value="S" />';
            $html .= '<label for="pfoafp' . $row['idt'] . '" class="Tit_Campo_Obr">' . $lbl . '</label>';
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_grc_nan_gestao_contrato($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            $path = $vetSistemaUtiliza['GEC']['path'] . 'admin/obj_file/gec_contratar_credenciado_anexo/';

            $vetImagemProdPrefixo = explode('_', $row[$campo]);
            $ImagemProdPrefixo = '';
            $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
            $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
            $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

            $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
            $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
            $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

            $html .= $url;
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function NAN_MontaListas($menu) {
    // Monta Vetor

    /*
      -- Atendimento
      Unidade Regional
      Ponto de Atendimento
      Projeto
      Ação
      Data de Inicio
      Data da Finalização
      Instrumento
      Tema/Subtema/Foco temático
      Consultor/Atendente

      -- Pessoa Física
      Código do Cliente
      Nome Completo
      Sexo
      Data de Nascimento
      Logradouro
      Número
      Complemento
      Bairro
      Cidade
      Estado
      Telefone Residencial
      Telefone Celular
      Telefone Recado
      E-mail
      Escolaridade
      Portador de Necessidades Especiais?
      Deficiência
      Potencial Personagem

      -- Pessoa Jurídica
      Código do Empreendimento
      Tipo do Empreeendimento
      Porte/Faixa do Faturamento
      Setor
      Razão Social
      Nome Fantasia
      Data de Abertura
      Pessoas ocupadas
      Optante do SIMPLES?
      Cargo do Representante
      Atividade Econômica Principal
      Atividade Econômica Secundária

      Logradouro
      Número
      Complemento
      Bairro
      Cidade
      Estado


     */
    if ($menu == 'grc_nan_visita_analitico') {
        $vetTablas = Array();

        $vetTablas['PG']['tipodefull'] = "Analitico";
        $vetTablas['PG']['titulo'] = "Dimensões";
        $vetTablas['PG']['colgrupo'] = 2;



        $vetTablas['GR']['S1'] = "Pessoa Física";
        $vetTablas['GR']['S2'] = "Pessoa Jurídica";
        $vetTablas['GR']['TP'] = "Atendimento";


        $vetTablas['TP']['TabelaPrinc'] = "grc_atendimento";
        $vetTablas['TP']['AliasPric'] = "grc_atd";
        $vetTablas['TP']['Entidade'] = "Atendimento";
        $vetTablas['TP']['Entidade_p'] = "AtendimentoS";

        $vetTablas['S1']['TabelaSecun1'] = "grc_atendimento_pessoa";
        $vetTablas['S1']['AliasSecun1'] = "grc_atdp";
        $vetTablas['S1']['Entidades1'] = "Atendimento Pessoa";
        $vetTablas['S1']['Entidades1_p'] = "Atendimentos pessoa";

        $vetTablas['S2']['TabelaSecun2'] = "grc_atendimento_organizacao";
        $vetTablas['S2']['AliasSecun2'] = "grc_atdo";
        $vetTablas['S2']['Entidades2'] = "Atendimento Organizacao";
        $vetTablas['S2']['Entidades2_p'] = "Atendimentos Organizacao";
        //
        // Colunas do Atendimento
        //
        $grupo = "TP";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Protocolo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_protocolo"] = $vetQualificadores;

        $vetQualificadores['dsc'] = "Cliente";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_cliente"] = $vetQualificadores;

        $vetQualificadores['dsc'] = "Representante";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_representante"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Empresa Executora";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_empresa_executora"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Tutor/Gestor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_tutor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Agente";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_agente"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Unidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_nome_unidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ponto Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_ponto_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_projeto"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ação";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_acao"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ciclo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_ciclo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Instrumento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_instrumento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Visita";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_data"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Hora<br />Inicial";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_hora_inicio_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Hora<br />Final";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_hora_termino_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Duração";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_horas_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Prazo<br />Validação";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_prazo_validacao"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Motivo desistência";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_motivo_desistencia"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Registro";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_data_registro"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Situação";
        $vetQualificadores['tip'] = "descDominio";
        $vetQualificadores['vet'] = "vetNanGrupo";

        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_situacao"] = $vetQualificadores;


        // Pessoa
        $grupo = "S1";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CPF";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cpf"] = $vetQualificadores;
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cliente";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pf_nome"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Sexo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_sexo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Nascimento";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_data_nascimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CEP";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cep"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Logradouro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pf_logradouro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Número";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_numero"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Complemento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_complemento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_bairro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Estado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_estado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "País";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_pais"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Residencial";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_residencial"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Celular";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_celular"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Recado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_recado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Email";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_email"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Escolaridade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_escolaridade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Potencial<br />Personagem";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_potencial_personagem"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Necessidades<br />Especiais";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_necessidade_especial"] = $vetQualificadores;

        // Empreendimento 
        $grupo = "S2";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CNPJ";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cnpj"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Razão Social";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_razao_social"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Nome Fantasia";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_nome_fantasia"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Tipo<br />Empreendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_tipo_empreendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Porte/Faixa Faturamento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_porte_faixa"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Setor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_setor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Abertura";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_data_abertura"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Pessoas<br />Ocupadas";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_pessoas_ocupadas"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Optante<br />Simples";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_optante_simples"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cargo<br />Representante";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cargo_representante"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Atividade<br />Econômica";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_atividade_economica"] = $vetQualificadores;




        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CEP";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cep"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Logradouro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_logradouro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Número";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_numero"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Complemento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_complemento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_bairro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Estado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_estado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "País";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_pais"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Principal";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_telefone_principal"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Secundário";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_telefone_secundario"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Email";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_email"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Site URL";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_site_url"] = $vetQualificadores;
    }



    if ($menu == 'grc_nan_visita_sintetico') {
        $vetTablas = Array();

        $vetTablas['PG']['tipodefull'] = "Sintetico";
        $vetTablas['PG']['titulo'] = "Relatórios";
        $vetTablas['PG']['colgrupo'] = 4;

        $vetTablas['GR']['S1'] = "";
        // Dimensões
        $grupo = "S1";

        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Projeto e Ações";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_projeto_acao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_projeto_acao"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_projeto_acao"] = $vetQualificadores;
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Empresas Executoras";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetQualificadores['tab_d'] = "plu_usuario";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "id_usuario";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "nome_completo";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_nan_empresa"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_empresa_executora"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Unidade Regional";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir . "sca_organizacao_secao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_unidade"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_unidade_regional"] = $vetQualificadores;




        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Agentes de Orientação Empresarial";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "plu_usuario";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "id_usuario";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "nome_completo";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_consultor"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_aoe"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Tutor/Gestor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "plu_usuario";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "id_usuario";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "nome_completo";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_nan_tutor"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_tutor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Porte/Faixa de Faturamento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "gec_organizacao_porte";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_porte"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_porte"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Status do Atendimento";
        $vetQualificadores['tip'] = "descDominio";
        $vetQualificadores['vet'] = "vetNanGrupo";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_nan_grupo_atendimento";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "status_1";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_grupo_atendimento"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_status"] = $vetQualificadores;



        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade do Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "" . db_pir_siac . "cidade";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "codcid";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "desccid";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.logradouro_codcid_e"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro do Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "" . db_pir_siac . "bairro";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "codbairro";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descbairro";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.logradouro_codbairro_e"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_bairro"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Setor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "gec_entidade_setor";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_setor"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_setor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Atividade Econômica";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "cnae";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "subclasse";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_cnae_principal"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_cnae"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Instrumentos";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_atendimento_instrumento";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_instrumento"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_instrumento"] = $vetQualificadores;
        //
        // Pegar pergunta e respostas
        //
		$pesq = "select    ";
        $pesq .= " grc_fp.*,  ";
        $pesq .= " grc_fpr.idt as grc_fpr_idt,  ";
        $pesq .= " grc_fpr.descricao as grc_fpr_descricao  ";
        $pesq .= " from  grc_formulario_pergunta grc_fp ";
        $pesq .= " inner join  grc_formulario_resposta grc_fpr on grc_fpr.idt_pergunta = grc_fp.idt ";
        $pesq .= " where grc_fp.sigla_dimensao = 'GE'  ";
        $pesq .= " order by grc_fpr.codigo";
        $rsp = execsql($pesq);

        ForEach ($rsp->data as $rowp) {
            $grc_fpr_idt = $rowp['grc_fpr_idt'];
            $grc_fpr_descricao = $rowp['grc_fpr_descricao'];
        }


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Perspectiva Empresarial";
        $vetQualificadores['tip'] = "descDominio";
        //$vetQualificadores['vet'] = "vetPerguntas";
        $vetQualificadores['esp'] = "PE";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_formulario_resposta";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "grc_avr.idt_resposta"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_perspectiva_empresarial"] = $vetQualificadores;
    }


///////////////////// presencial
    if ($menu == 'grc_presencial_analitico') {
        $vetTablas = Array();
        $vetTablas['PG']['tipodefull'] = "Analitico";
        $vetTablas['PG']['titulo'] = "Dimensões";
        $vetTablas['PG']['colgrupo'] = 2;



        $vetTablas['GR']['S1'] = "Pessoa Física";
        $vetTablas['GR']['S2'] = "Pessoa Jurídica";
        $vetTablas['GR']['TP'] = "Atendimento - Balcão";
        $vetTablas['GR']['EV'] = "Evento";

        $vetTablas['EV']['TabelaPrinc'] = "grc_evento";
        $vetTablas['EV']['AliasPric'] = "grc_av";
        $vetTablas['EV']['Entidade'] = "Evento";
        $vetTablas['EV']['Entidade_p'] = "Eventos";


        $vetTablas['TP']['TabelaPrinc'] = "grc_atendimento";
        $vetTablas['TP']['AliasPric'] = "grc_atd";
        $vetTablas['TP']['Entidade'] = "Atendimento";
        $vetTablas['TP']['Entidade_p'] = "Atendimentos";

        $vetTablas['S1']['TabelaSecun1'] = "grc_atendimento_pessoa";
        $vetTablas['S1']['AliasSecun1'] = "grc_atdp";
        $vetTablas['S1']['Entidades1'] = "Atendimento Pessoa";
        $vetTablas['S1']['Entidades1_p'] = "Atendimentos pessoa";

        $vetTablas['S2']['TabelaSecun2'] = "grc_atendimento_organizacao";
        $vetTablas['S2']['AliasSecun2'] = "grc_atdo";
        $vetTablas['S2']['Entidades2'] = "Atendimento Organizacao";
        $vetTablas['S2']['Entidades2_p'] = "Atendimentos Organizacao";
        //
        // Colunas do Atendimento
        //
        $grupo = "TP";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Protocolo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_protocolo"] = $vetQualificadores;

        $vetQualificadores['dsc'] = "Cliente - PF";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pf_nome"] = $vetQualificadores;

        $vetQualificadores['dsc'] = "Representante";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_representante"] = $vetQualificadores;
		
		$vetQualificadores['dsc'] = "Cliente - PJ";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_razao_social"] = $vetQualificadores;

        /*
          $vetQualificadores = Array();
          $vetQualificadores['dsc'] = "Empresa Executora";
          $vetQualificadores['tip'] = "";
          $vetQualificadores['tam'] = 200;
          $vetTablas['CTP'][$grupo]["at_empresa_executora"] = $vetQualificadores;


          $vetQualificadores = Array();
          $vetQualificadores['dsc'] = "Tutor/Gestor";
          $vetQualificadores['tip'] = "";
          $vetQualificadores['tam'] = 200;
          $vetTablas['CTP'][$grupo]["at_tutor"] = $vetQualificadores;

          $vetQualificadores = Array();
          $vetQualificadores['dsc'] = "Agente";
          $vetQualificadores['tip'] = "";
          $vetQualificadores['tam'] = 200;
          $vetTablas['CTP'][$grupo]["at_agente"] = $vetQualificadores;
         */
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Unidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_nome_unidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ponto Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_ponto_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_projeto"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ação";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["at_acao"] = $vetQualificadores;
        /*
          $vetQualificadores = Array();
          $vetQualificadores['dsc'] = "Ciclo";
          $vetQualificadores['tip'] = "";
          $vetQualificadores['tam'] = 100;
          $vetTablas['CTP'][$grupo]["at_ciclo"] = $vetQualificadores;
         */

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Consultor/Atendente";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["plu_usuc_nome_completo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Usuário Registrador";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["plu_usud_nome_completo"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Instrumento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_instrumento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data do Atendimento";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_data"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Hora Inicial";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_hora_inicio_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Hora Final";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_hora_termino_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Duração";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_horas_atendimento"] = $vetQualificadores;
/*
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Prazo Validação";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_prazo_validacao"] = $vetQualificadores;
*/
        /*
          $vetQualificadores = Array();
          $vetQualificadores['dsc'] = "Motivo desistência";
          $vetQualificadores['tip'] = "";
          $vetQualificadores['tam'] = 200;
          $vetTablas['CTP'][$grupo]["at_motivo_desistencia"] = $vetQualificadores;
         */

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data Registro";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_data_registro"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Situação";
        $vetQualificadores['tip'] = "descDominio";
        $vetQualificadores['vet'] = "vetNanGrupo";

        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["at_situacao"] = $vetQualificadores;




        $grupo = "EV";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Código do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_ev_codigo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Descrição do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_ev_descricao"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Status do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_evs_descricao"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_proj_descricao"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Gestor do Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_proj_gestor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Fase do Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_projs_fase"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ação do Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_proja_descricao"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Unidade/Escritório Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["sca_eve_u_unidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ponto Atendimento Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["sca_eve_pa_ponto_atendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Produto do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_prod_descricao"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Responsável pelo Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["plu_usuge_gestor_evento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Local do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["sala"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data Inicio";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_ev_dt_previsao_inicial"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Horário";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_ev_hora_inicio"] = $vetQualificadores;



        // Participantes

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Inscrição Ativa?";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_evp_ativo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Situação do Contrato ";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["grc_evp_contrato"] = $vetQualificadores;



        // Pessoa
        $grupo = "S1";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CPF";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cpf"] = $vetQualificadores;
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cliente - PF";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pf_nome"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Sexo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_sexo"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Nascimento";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_data_nascimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CEP";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cep"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Logradouro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pf_logradouro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Número";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_numero"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Complemento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_complemento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_bairro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Estado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_estado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "País";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_pais"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Residencial";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_residencial"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Celular";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_celular"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Recado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_telefone_recado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Email";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_email"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Escolaridade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_escolaridade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Potencial<br />Personagem";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_potencial_personagem"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Necessidades<br />Especiais";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pf_necessidade_especial"] = $vetQualificadores;

        // Empreendimento 
        $grupo = "S2";
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CNPJ";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cnpj"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Razão Social";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_razao_social"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Nome Fantasia";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_nome_fantasia"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Tipo<br />Empreendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_tipo_empreendimento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Porte/Faixa Faturamento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_porte_faixa"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Setor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_setor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Data<br />Abertura";
        $vetQualificadores['tip'] = "data";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_data_abertura"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Pessoas<br />Ocupadas";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_pessoas_ocupadas"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Optante<br />Simples";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_optante_simples"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cargo<br />Representante";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cargo_representante"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Atividade<br />Econômica";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_atividade_economica"] = $vetQualificadores;




        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "CEP";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cep"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Logradouro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_logradouro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Número";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_numero"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Complemento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_complemento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_bairro"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Estado";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_estado"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "País";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_pais"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Principal";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_telefone_principal"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Telefone<br />Secundário";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetTablas['CTP'][$grupo]["pj_telefone_secundario"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Email";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_email"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Site URL";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 200;
        $vetTablas['CTP'][$grupo]["pj_site_url"] = $vetQualificadores;
    }

/////////////////////////////// presencial
    if ($menu == 'grc_presencial_sintetico') {
        $vetTablas = Array();
        //
        $vetTablas['PG']['tipodefull'] = "Sintetico";
        $vetTablas['PG']['titulo'] = "Relatórios";
        $vetTablas['PG']['colgrupo'] = 4;
        //
        $vetTablas['GR']['S1'] = "";
        // Dimensões
        $grupo = "S1";
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Projetos";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_projeto_acao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_projeto"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_projeto"] = $vetQualificadores;
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ações do Projeto";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_projeto_acao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_projeto_acao"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_projeto_acao"] = $vetQualificadores;
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Unidade Regional";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir . "sca_organizacao_secao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_unidade"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_unidade_regional"] = $vetQualificadores;
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Consultor/Atendente";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "plu_usuario";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "id_usuario";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "nome_completo";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_consultor"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_aoe"] = $vetQualificadores;
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Porte/Faixa de Faturamento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "gec_organizacao_porte";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";      // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_porte"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_porte"] = $vetQualificadores;
        //
        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Cidade do Atendimentoo";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "" . db_pir_siac . "cidade";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "codcid";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "desccid";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.logradouro_codcid_e"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_cidade"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Bairro do Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "" . db_pir_siac . "bairro";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "codbairro";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descbairro";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.logradouro_codbairro_e"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_bairro"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Setor";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "gec_entidade_setor";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_setor"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_setor"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Atividade Econômica";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir_gec . "cnae";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "subclasse";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "ao.idt_cnae_principal"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_cnae"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Instrumentos";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_atendimento_instrumento";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_instrumento"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_instrumento"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Responsável do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "plu_usuario";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "id_usuario";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "nome_completo";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "grc_ev.idt_gestor_evento"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_gestor_evento"] = $vetQualificadores;

        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Produto do Evento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = "grc_produto";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "grc_ev.idt_produto"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_produto"] = $vetQualificadores;


        $vetQualificadores = Array();
        $vetQualificadores['dsc'] = "Ponto de Atendimento";
        $vetQualificadores['tip'] = "";
        $vetQualificadores['tam'] = 100;
        $vetQualificadores['tab_d'] = db_pir . "sca_organizacao_secao";     // Tabela da dimensão
        $vetQualificadores['tab_did'] = "idt";          // idt ligação com principal     
        $vetQualificadores['tab_dcp'] = "descricao";   // nome da dimensão
        $vetQualificadores['tab_pid'] = "idt_ponto_atendimento"; // liga com tabela principal
        $vetTablas['CTP'][$grupo]["grc_ponto_atendimento"] = $vetQualificadores;
    }




    return $vetTablas;
}

/**
 * Troca o codigo do siacweb nos bancos
 * @access public
 * @param string $antigo <p>
 * Codigo antigo do siacweb
 * </p>
 * @param string $novo <p>
 * Codigo novo do siacweb
 * </p>
 * @param string $tipoparceiro <p>
 * Tipo do cadastro Pessoa Fisica ou Juridica
 * </p>
 * */
function updateCodSiacweb($antigo, $novo, $tipoparceiro) {
    $sql = '';
    $sql .= ' select codparceiro';
    $sql .= ' from ' . db_pir_siac . 'parceiro';
    $sql .= ' where codparceiro = ' . null($novo);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        //SIAC
        $sql = 'update ' . db_pir_siac . 'parceiro set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
        execsql($sql, false);

        $sql = 'update ' . db_pir_siac . 'comunicacao set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
        execsql($sql, false);

        $sql = 'update ' . db_pir_siac . 'endereco set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
        execsql($sql, false);

        $sql = 'update ' . db_pir_siac . 'ativeconpj set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
        execsql($sql, false);

        if ($tipoparceiro == 'F') {
            $sql = 'update ' . db_pir_siac . 'pessoaf set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
            execsql($sql, false);

            $sql = '';
            $sql .= ' select codcontatopj';
            $sql .= ' from ' . db_pir_siac . 'contato';
            $sql .= ' where codcontatopf = ' . null($antigo);
            $rsDel = execsql($sql, false);

            $vetDel = Array();
            foreach ($rsDel->data as $rowDel) {
                $vetDel[$rowDel['codcontatopj']] = $rowDel['codcontatopj'];
            }

            if (count($vetDel) > 0) {
                $sql = 'delete from ' . db_pir_siac . 'contato';
                $sql .= ' where codcontatopf = ' . null($novo);
                $sql .= ' and codcontatopj in (' . implode(', ', $vetDel) . ')';
                execsql($sql, false);
            }

            $sql = 'update ' . db_pir_siac . 'contato set codcontatopf = ' . null($novo) . ' where codcontatopf = ' . null($antigo);
            execsql($sql, false);

            $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente set codcliente = ' . null($novo) . ' where codcliente = ' . null($antigo);
            execsql($sql, false);

            $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores set codcliente = ' . null($novo) . ' where codcliente = ' . null($antigo);
            execsql($sql, false);
        } else {
            $sql = 'update ' . db_pir_siac . 'pessoaj set codparceiro = ' . null($novo) . ' where codparceiro = ' . null($antigo);
            execsql($sql, false);

            $sql = '';
            $sql .= ' select codcontatopf';
            $sql .= ' from ' . db_pir_siac . 'contato';
            $sql .= ' where codcontatopj = ' . null($antigo);
            $rsDel = execsql($sql, false);

            $vetDel = Array();
            foreach ($rsDel->data as $rowDel) {
                $vetDel[$rowDel['codcontatopf']] = $rowDel['codcontatopf'];
            }

            if (count($vetDel) > 0) {
                $sql = 'delete from ' . db_pir_siac . 'contato';
                $sql .= ' where codcontatopj = ' . null($novo);
                $sql .= ' and codcontatopf in (' . implode(', ', $vetDel) . ')';
                execsql($sql, false);
            }

            $sql = 'update ' . db_pir_siac . 'contato set codcontatopj = ' . null($novo) . ' where codcontatopj = ' . null($antigo);
            execsql($sql, false);

            $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente set codempreedimento = ' . null($novo) . ' where codempreedimento = ' . null($antigo);
            execsql($sql, false);

            $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores set codempreedimento = ' . null($novo) . ' where codempreedimento = ' . null($antigo);
            execsql($sql, false);
        }
    } else {
        $erro = 'Não pode trocar o código do SiacWeb de ' . $antigo . ' para ' . $novo . ', pois tem os dois códigos no CACHE!';

        $inf_extra = Array(
            'antigo' => $antigo,
            'novo' => $novo,
        );

        erro_try($erro, 'updateCodSiacweb', $inf_extra);
    }

    //GEC
    $sql = 'update ' . db_pir_gec . 'gec_entidade set codigo_siacweb = ' . null($novo) . ' where codigo_siacweb = ' . aspa($antigo);
    execsql($sql, false);

    //GRC
    if ($tipoparceiro == 'F') {
        $sql = 'update ' . db_pir_grc . 'grc_atendimento_pessoa set codigo_siacweb = ' . null($novo) . ' where codigo_siacweb = ' . aspa($antigo);
        execsql($sql, false);

        $sql = 'update ' . db_pir_grc . 'grc_entidade_pessoa set codigo_siacweb = ' . null($novo) . ' where codigo_siacweb = ' . aspa($antigo);
        execsql($sql, false);
    } else {
        $sql = 'update ' . db_pir_grc . 'grc_atendimento_organizacao set codigo_siacweb_e = ' . null($novo) . ' where codigo_siacweb_e = ' . aspa($antigo);
        execsql($sql, false);

        $sql = 'update ' . db_pir_grc . 'grc_entidade_organizacao set codigo_siacweb_e = ' . null($novo) . ' where codigo_siacweb_e = ' . aspa($antigo);
        execsql($sql, false);
    }

    grava_log_sis('updateCodSiacweb', 'R', $tipoparceiro, 'de ' . $antigo . ' para ' . $novo, 'Troca do código do SiacWeb');
}

function ftr_grc_evento($row) {
    global $barra_exc_ap;

    if ($row['temporario'] == 'S') {
        $barra_exc_ap = true;
    } else {
        if ($row['grc_pr_tipo_ordem'] == 'SG' && $row['sgtec_modelo'] == 'E') {
            switch ($row['idt_evento_situacao']) {
                case 1: //EM CONSTRUÇÃO
                case 5: //DEVOLVIDO
                //case 24: //EM COTAÇÃO
                    if ($_SESSION[CS]['g_id_usuario'] == $row['idt_gestor_evento']) {
                        $barra_exc_ap = true;
                    } else {
                        $barra_exc_ap = false;
                    }
                    break;

                default:
                    $barra_exc_ap = false;
                    break;
            }
        } else {
            switch ($row['idt_evento_situacao']) {
                case 1: //EM CONSTRUÇÃO
                case 5: //DEVOLVIDO
                case 6: //EM TRAMITAÇÃO
                case 14: //AGENDADO
                case 16: //EM EXECUÇÃO
                case 19: //PENDENTE
                case 22: //CANCELADO APÓS APROVAÇÃO COM ERRO
                    if ($_SESSION[CS]['g_id_usuario'] == $row['idt_gestor_evento']) {
                        $barra_exc_ap = true;
                    } else {
                        $barra_exc_ap = false;
                    }
                    break;

                default:
                    $barra_exc_ap = false;
                    break;
            }
        }
    }
}

function ftr_grc_evento_anexo($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['so_consulta'] == 'S') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
    }
}

function ftr_gec_contratar_credenciado_distrato_anexos($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['so_consulta'] == 'S') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
    }
}

function ftr_gec_contratar_credenciado_aditivo_anexos($row) {
    global $barra_alt_ap_row, $barra_con_ap_row, $barra_exc_ap_row;

    if ($row['so_consulta'] == 'S') {
        $barra_alt_ap_row = false;
        $barra_exc_ap_row = false;
    }
}

function grc_nan_ordem_pagamento_at_per($row, $session_cod) {
    $title = 'Desvincular Atendimento';
    $mensagem = trata_aspa('Deseja desvincular a visita "' . $row['protocolo'] . '" da da Ordem de Pagamento?');

    $html = '';
    $html .= "<a href='#' onclick='return grc_nan_ordem_pagamento_at_per(\"{$row['idt']}\", \"{$row['idt_nan_ordem_pagamento']}\", \"{$mensagem}\", \"{$session_cod}\")'  title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/bt_menos.png' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

function func_gec_area_conhecimento(&$row) {
    global $trHtml;

    $row['descricao'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $row['nivel'] - 1) . $row['descricao'];

    if ($row['nivel'] == 1) {
        $display_none = 'N1 ';
    } else {
        $display_none = 'N' . $row['nivel'] . ' display_none ';
    }

    $data = '';
    $data .= ' data-nivel="' . $row['nivel'] . '"';
    $data .= ' data-aberto="N"';

    $vetCod = explode('.', $row['codigo']);

    foreach ($vetCod as $idx => $cod) {
        $idx++;
        $data .= ' data-cod' . $idx . '="' . $cod . '"';
    }

    $trHtml = str_replace("class='", $data . " class='{$display_none}", $trHtml);
}

/**
 * Utilizado para alterar o html da TD grc_ersit_descricao no listar_conf/grc_nan_ordem_pagamento.php
 * @access public
 * */
function ftd_grc_nan_ordem_pagamento($valor, $row, $campo) {
    global $vetAFProcessoSit, $vetAFProcessoFI, $vetNanOrdemPagSituacao;

    $html = '';

    switch ($campo) {
        case 'situacao':
            if ($row['situacao'] == 'AP') {
                if ($row['situacao_reg'] == '') {
                    $html .= 'O credenciado não consultou este processo';
                } else {
                    $html .= $vetAFProcessoSit[$row['situacao_reg']];
                }

                if ($row['situacao_reg'] == 'FI') {
                    $html .= '<br />' . $vetAFProcessoFI[$row['gfi_situacao']];
                }
            } else {
                $html .= $vetNanOrdemPagSituacao[$row['situacao']];
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

//
// NAN 2a Visita
//
function DevolutivaPDF($idt_avaliacao) {
    //
    // Gera Devolutiva em PDF
    //
	$row = Array();
    $ret = BuscarDados2Visita($idt_avaliacao, $row, $veterro);
    if ($ret == 0) {
        return 0;
    }
    //
    // Dados da 2 Visita
    //
	foreach ($rs->data as $row) {
        $numero_visita = $row['numero_visita'];
        $data_devolutiva_pdf = $row['data_devolutiva_pdf'];
        $arquivo_devolutiva_pdf = $row['arquivo_devolutiva_pdf'];
        $data_plano_facil_pdf = $row['data_plano_facil_pdf'];
        $arquivo_plano_facil_pdf = $row['arquivo_plano_facil_pdf'];
        $data_protocolo_pdf = $row['data_protocolo_pdf'];
        $arquivo_protocolo_pdf = $row['arquivo_protocolo_pdf '];
        //
        $data_inicio_segunda_visita = $row['data_inicio_segunda_visita'];
        $idt_responsavel_iniciar = $row['idt_responsavel_iniciar'];
        //
        $idt_responsavel = $row['idt_responsavel'];
        $data_responsavel = $row['data_responsavel'];
    }
}

function PlanoFacilPDF($idt_avaliacao) {
    //
    // Gera Plano Fácil em PDF
    //
	$row = Array();
    $ret = BuscarDados2Visita($idt_avaliacao, $row, $veterro);
    if ($ret == 0) {
        return 0;
    }
    //
    // Dados da 2 Visita
    //
	foreach ($rs->data as $row) {
        $numero_visita = $row['numero_visita'];
        $data_devolutiva_pdf = $row['data_devolutiva_pdf'];
        $arquivo_devolutiva_pdf = $row['arquivo_devolutiva_pdf'];
        $data_plano_facil_pdf = $row['data_plano_facil_pdf'];
        $arquivo_plano_facil_pdf = $row['arquivo_plano_facil_pdf'];
        $data_protocolo_pdf = $row['data_protocolo_pdf'];
        $arquivo_protocolo_pdf = $row['arquivo_protocolo_pdf '];
        //
        $data_inicio_segunda_visita = $row['data_inicio_segunda_visita'];
        $idt_responsavel_iniciar = $row['idt_responsavel_iniciar'];
        //
        $idt_responsavel = $row['idt_responsavel'];
        $data_responsavel = $row['data_responsavel'];
    }

    return 1;
}

function Protocolo2VisitaPDF($idt_avaliacao, &$veterro) {
    //
    // Protocolo da 2 Visita
    //
	$row = Array();
    $ret = BuscarDados2Visita($idt_avaliacao, $row, $veterro);
    if ($ret == 0) {
        return 0;
    }
    //
    // Dados da 2 Visita
    //
	foreach ($rs->data as $row) {
        $numero_visita = $row['numero_visita'];
        $data_devolutiva_pdf = $row['data_devolutiva_pdf'];
        $arquivo_devolutiva_pdf = $row['arquivo_devolutiva_pdf'];
        $data_plano_facil_pdf = $row['data_plano_facil_pdf'];
        $arquivo_plano_facil_pdf = $row['arquivo_plano_facil_pdf'];
        $data_protocolo_pdf = $row['data_protocolo_pdf'];
        $arquivo_protocolo_pdf = $row['arquivo_protocolo_pdf '];
        //
        $data_inicio_segunda_visita = $row['data_inicio_segunda_visita'];
        $idt_responsavel_iniciar = $row['idt_responsavel_iniciar'];
        //
        $idt_responsavel = $row['idt_responsavel'];
        $data_responsavel = $row['data_responsavel'];
    }

    return 1;
}

//
// Buscar dados da 2 visita
//
function BuscarDados2Visita($idt_avaliacao, &$row, &$veterro) {
    $sql = "select  ";
    $sql .= "   grc_av.*  ";
    $sql .= " from grc_avaliacao_visita grc_av ";
    $sql .= " where grc_av.idt_avaliacao   =   " . null($idt_avaliacao);
    $sql .= " and   numero_visita = 1 ";
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        //
        // Se existe registro de avaliação criar
        //
		$sql = "select  ";
        $sql .= "   grc_a.idt  ";
        $sql .= " from grc_avaliacao grc_a ";
        $sql .= " where grc_a.idt     =   " . null($idt_avaliacao);
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            // Tem erro
            $veterro[] = "Atendimento sem avaliação idt = {$idt_avaliacao} ";
            return 0;
        } else {
            $numero_visita = 1;
            $datadia = trata_data(date('d/m/Y H:i:s'));
            $idt_responsavel = $_SESSION[CS]['g_id_usuario'];
            $data_responsavel = $datadia;

            $sql_i = ' insert into grc_avaliacao_visita ';
            $sql_i .= ' (  ';
            $sql_i .= " idt_avaliacao, ";
            $sql_i .= " numero_visita, ";
            $sql_i .= " idt_responsavel, ";
            $sql_i .= " data_responsavel ";
            $sql_i .= '  ) values ( ';
            $sql_i .= " $idt_avaliacao, ";
            $sql_i .= " $numero_visita, ";
            $sql_i .= " $idt_responsavel, ";
            $sql_i .= " $data_responsavel ";
            $sql_i .= ') ';
            execsql($sql_i, false);
            // Buscar Novamente
            $sql = "select  ";
            $sql .= "   grc_av.*  ";
            $sql .= " from grc_avaliacao_visita grc_av ";
            $sql .= " where grc_av.idt_avaliacao   =   " . null($idt_avaliacao);
            $sql .= " and   numero_visita = 1 ";
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                // Tem erro
                $veterro[] = "Avaliação Visita Nã gerado idt = {$idt_avaliacao} ";
                return 0;
            }
        }
    }
    //
    // Dados da 2 Visita
    //
	foreach ($rs->data as $row) {
        $numero_visita = $row['numero_visita'];
        $data_devolutiva_pdf = $row['data_devolutiva_pdf'];
        $arquivo_devolutiva_pdf = $row['arquivo_devolutiva_pdf'];
        $data_plano_facil_pdf = $row['data_plano_facil_pdf'];
        $arquivo_plano_facil_pdf = $row['arquivo_plano_facil_pdf'];
        $data_protocolo_pdf = $row['data_protocolo_pdf'];
        $arquivo_protocolo_pdf = $row['arquivo_protocolo_pdf '];
        //
        $data_inicio_segunda_visita = $row['data_inicio_segunda_visita'];
        $idt_responsavel_iniciar = $row['idt_responsavel_iniciar'];
        //
        $idt_responsavel = $row['idt_responsavel'];
        $data_responsavel = $row['data_responsavel'];
    }
    return 1;
}

function IniciarSegundaVisita($idt_avaliacao, &$veterro) {
    $kokw = 1;

    // Gerar Atendimento com dados iniciais
    $ret = Gerar2VisitaCRM($idt_avaliacao, $veterro);

    if ($ret == 1) {
        // Gerar Protocolo em PDF
        $ret = Protocolo2VisitaPDF($idt_avaliacao, $row, $veterro);
        if ($ret == 1) {

            $kokw = 1;
        } else {

            $kokw = 0;
        }
    } else {

        $kokw = 0;
    }
    if ($kokw == 0) {
        //$veRetorno['erro']    = "Não pode ser Gerada a 2a Visita";
        //$veRetorno['veterro'] = $veterro;
        //p($veterro);
    }


    return $kokw;
}

function Gerar2VisitaCRM($idt_avaliacao, &$veterro) {
    //
    //  Gerar Atendimento com dados iniciais
    //
	$sql = "select  ";
    $sql .= "   grc_at.*,  ";
    $sql .= "   grc_nan_ga.num_visita_atu as grc_nan_ga_num_visita_atu   ";
    $sql .= " from  grc_avaliacao grc_a ";
    $sql .= " inner join grc_atendimento           grc_at     on grc_at.idt     = grc_a.idt_atendimento   ";
    $sql .= " inner join grc_nan_grupo_atendimento grc_nan_ga on grc_nan_ga.idt = grc_at.idt_grupo_atendimento   ";
    $sql .= " where grc_a.idt              =   " . null($idt_avaliacao);
    $sql .= "   and grc_at.nan_num_visita  =  1 ";
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Tem erro
        $veterro[] = "Nâo encontrado o atendimento da VIsita 1 idt_avaliacao=($idt_avaliacao) para geração da Visita 2";
        return 0;
    } else {
        foreach ($rs->data as $row) {
            $protocolo_1Visita = $row['protocolo'];
            $grc_nan_ga_num_visita_atu = $row['grc_nan_ga_num_visita_atu'];
            if ($grc_nan_ga_num_visita_atu > 1) {
                // Já tem a Visita 2 Gerada
                $veterro[] = "A Visita 2 para esse Atendimento já foi Gerada.";
                return 0;
            } else {
                beginTransaction();
                set_time_limit(30);
                $ret = Gerar2Visita($row, $veterro);
                if ($ret == 1) {
                    commit();
                } else {
                    rollBack();
                }
            }
        }
    }
}

function EditaCampoSql($tipo, $valorcampo) {

    if ($tipo == 'string') {
        $valorcampoeditado = aspa($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'texto') {
        $valorcampoeditado = aspa($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'inteiro') {
        $valorcampoeditado = null($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'data') {
        $valorcampoeditado = aspa($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'datahora') {
        $valorcampoeditado = aspa($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'decimal') {
        $valorcampoeditado = null($valorcampo);
        return($valorcampoeditado);
    }
    if ($tipo == 'decimal') {
        $valorcampoeditado = null($valorcampo);
        return($valorcampoeditado);
    }
}

function Gerar2Visita($row, &$veterro) {
    $idt_atendimento_1 = $row['idt'];


    //////////////// VERIFICA SE ESTA NA PRIMEIRA VISITA E PODE GERAR A SEGUNDA 
    $idt_grupo_atendimento = $row['idt_grupo_atendimento'];

    $sqlt = "select  ";
    $sqlt .= "   grc_nan_ga.*  ";
    $sqlt .= " from  grc_nan_grupo_atendimento grc_nan_ga ";
    $sqlt .= " where grc_nan_ga.idt              =   " . null($idt_grupo_atendimento);
    $rst = execsql($sqlt);
    if ($rst->rows == 0) {
        $veterro[] = "Grupo com idt = {$idt_grupo_atendimento} Não encontrado";
        return 0;
    }
    foreach ($rst->data as $rowt) {
        // Tem que estar na Visita 1 e status APROVADO.
        $num_visita_atu = $rowt['num_visita_atu'];
        if ($num_visita_atu != 1) {
            $veterro[] = "Segunda Visita Não pode ser Gerada. Visita atual {$num_visita_atu}";
            return 0;
        }
        $status_1 = $rowt['status_1'];
        if ($status_1 != 'AP') {
            $veterro[] = "Segunda Visita só pode ser Gerada se o status da primeira for aprovada. Status atual {$status_1}";
            return 0;
        }
    }
    ////////////////////////////////////
    //
    // Protocolo da 2 Visita
    //
	$vetEstrutura = Array();
    $banco = "db_pir_grc";
    $tabela = "grc_atendimento";

    MontaSql($banco, $tabela, $vetEstrutura);
    //
    $CamposTabela = $vetEstrutura['doc'][$banco][$tabela]['cpo'];
    $tam = count($CamposTabela);
    foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
        $tipo = $vetPropriedades['tipo'];
        $valorcampo = $row[$nomecampo];
        $valorcampoeditado = EditaCampoSql($tipo, $valorcampo);
        $$nomecampo = $valorcampoeditado;
    }

    $idt_atendimento_agenda_2 = '';
    CopiarAtendimentoAgenda($row, $idt_atendimento_agenda_2, $veterro);

    if ($idt_atendimento_agenda_2 == '') {
        return 0;
    }

    $tabela = 'grc_atendimento';
    $Campo = 'protocolo';
    $tam = 10;
    $codigow = numerador_arquivo($tabela, $Campo . 'NAN', $tam);
    $protocolo = 'NAN' . $codigow;
    $protocolo = aspa($protocolo);
    //	
    $idt_instrumento = 2;
    $nan_num_visita = 2;
    $idt_atendimento_agenda = $idt_atendimento_agenda_2;
    //	
    $data_atendimento_relogio = aspa('N');
    $data_atendimento_aberta = aspa('S');
    $hora_inicio_atendimento = aspa('');
    $hora_termino_atendimento = aspa('');
    $data = aspa('');
    $situacao = aspa('Esperando Atendimento');
    $idt_cliente = 'NULL';
    $idt_pessoa = 'NULL';
    $demanda = aspa('');

    $rm_codcfo = 'NULL';
    $idt_nan_ordem_pagamento = 'NULL';
    $nan_ap_sit_pf = 'NULL';
    $nan_ap_dt_pf = 'NULL';
    $nan_ap_sit_pj = 'NULL';
    $nan_ap_dt_pj = 'NULL';
    $nan_ap_sit_at = 'NULL';
    $nan_ap_dt_at = 'NULL';
    $nan_idt_motivo_desistencia = 'NULL';
    $nan_motivo_desistencia = 'NULL';
    $nan_prazo_validacao = 'NULL';

    $sql = '';
    $sql .= ' select et.idt_usuario as idt_nan_tutor';
    $sql .= ' from grc_nan_estrutura e';
    $sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
    $sql .= ' where e.idt_usuario = ' . null($idt_consultor);
    $sql .= ' and e.idt_acao = ' . null($idt_projeto_acao);
    $sql .= ' and e.idt_nan_tipo = 6';
    $sql .= " and e.ativo = 'S'";
    $rst = execsql($sql);

    if ($rst->rows == 1) {
        $idt_nan_tutor = null($rst->data[0][0]);
    }

    if ($idt_consultor_prox_atend == '') {
        $idt_consultor_prox_atend = $idt_consultor;
    } else {
        $idt_consultor = $idt_consultor_prox_atend;
    }

    $idt_digitador = $idt_consultor;

    //
    // Grava registro
    //
	$sql_i = "";
    $sql_i .= "insert into " . db_pir_grc . "grc_atendimento";
    $sql_i .= " ( ";
    $sql_i .= " idt_consultor,  ";
    $sql_i .= " idt_digitador,  ";
    $sql_i .= " idt_consultor_prox_atend, ";
    $sql_i .= " idt_unidade,  ";
    $sql_i .= " idt_ponto_atendimento,  ";
    $sql_i .= " assunto,  ";
    $sql_i .= " idt_atendimento_agenda,  ";
    $sql_i .= " data_inicio_atendimento,  ";
    $sql_i .= " data_termino_atendimento,  ";
    $sql_i .= " horas_atendimento,  ";
    $sql_i .= " protocolo,  ";
    $sql_i .= " idt_projeto,  ";
    $sql_i .= " idt_cliente,  ";
    $sql_i .= " idt_pessoa,  ";
    $sql_i .= " cpf,  ";
    $sql_i .= " cnpj,  ";
    $sql_i .= " idt_projeto_acao,  ";
    $sql_i .= " nome_pessoa,  ";
    $sql_i .= " nome_empresa,  ";
    $sql_i .= " primeiro,  ";
    $sql_i .= " data_atendimento_relogio,  ";
    $sql_i .= " data_atendimento_aberta,  ";
    $sql_i .= " hora_inicio_atendimento,  ";
    $sql_i .= " hora_termino_atendimento,  ";
    $sql_i .= " data,  ";
    $sql_i .= " idt_instrumento,  ";
    $sql_i .= " situacao,  ";
    $sql_i .= " pessoa_cep,  ";
    $sql_i .= " pessoa_rua,  ";
    $sql_i .= " pessoa_numero,  ";
    $sql_i .= " pessoa_complemento,  ";
    $sql_i .= " pessoa_bairro,  ";
    $sql_i .= " pessoa_cidade,  ";
    $sql_i .= " pessoa_pais,  ";
    $sql_i .= " idt_pessoa_pais,  ";
    $sql_i .= " idt_pessoa_estado,  ";
    $sql_i .= " pessoa_estado,  ";
    $sql_i .= " idt_pessoa_cidade,  ";
    $sql_i .= " organizacao_cep,  ";
    $sql_i .= " organizacao_rua,  ";
    $sql_i .= " organizacao_numero,  ";
    $sql_i .= " organizacao_complemento,  ";
    $sql_i .= " organizacao_bairro,  ";
    $sql_i .= " organizacao_cidade,  ";
    $sql_i .= " organizacao_pais,  ";
    $sql_i .= " idt_organizacao_pais,  ";
    $sql_i .= " idt_organizacao_estado,  ";
    $sql_i .= " organizacao_estado,  ";
    $sql_i .= " idt_organizacao_cidade,  ";
    $sql_i .= " pessoa_data_nascimento,  ";
    $sql_i .= " pessoa_sexo,  ";
    $sql_i .= " pessoa_telefone_residencial,  ";
    $sql_i .= " pessoa_telefone_celular,  ";
    $sql_i .= " pessoa_telefone_recado,  ";
    $sql_i .= " pessoa_email,  ";
    $sql_i .= " idt_escolaridade,  ";
    $sql_i .= " receber_informacoes,  ";
    $sql_i .= " potencial_personagem,  ";
    $sql_i .= " pessoa_representante,  ";
    $sql_i .= " interesse_tema,  ";
    $sql_i .= " interesse_produto,  ";
    $sql_i .= " idt_tipo_empreendimento,  ";
    $sql_i .= " organizacao_data_abertura,  ";
    $sql_i .= " organizacao_pessoas_ocupadas,  ";
    $sql_i .= " organizacao_nome_fantasia,  ";
    $sql_i .= " organizacao_telefone_comercial,  ";
    $sql_i .= " organizacao_email_comercial,  ";
    $sql_i .= " organizacao_site_url,  ";
    $sql_i .= " idt_atividade_economica,  ";
    $sql_i .= " idt_setor,  ";
    $sql_i .= " organizacao_dap,  ";
    $sql_i .= " organizacao_rmp,  ";
    $sql_i .= " organizacao_nirf,  ";
    $sql_i .= " tamanho_propriedade,  ";
    $sql_i .= " idt_porte,  ";
    $sql_i .= " faturamento,  ";
    $sql_i .= " optante_simples,  ";
    $sql_i .= " idt_segmentacao,  ";
    $sql_i .= " idt_subsegmentacao,  ";
    $sql_i .= " idt_programa_fidelidade,  ";
    $sql_i .= " senha_totem,  ";
    $sql_i .= " senha_ordem,  ";
    $sql_i .= " gestor_sge,  ";
    $sql_i .= " fase_acao_projeto,  ";
    $sql_i .= " diagnostico,  ";
    $sql_i .= " devolutiva,  ";
    $sql_i .= " idt_competencia,  ";
    $sql_i .= " idt_tema_tratado,  ";
    $sql_i .= " idt_subtema_tratado,  ";
    $sql_i .= " idt_tema_interesse,  ";
    $sql_i .= " idt_subtema_interesse,  ";
    $sql_i .= " idt_tema_produto_interesse,  ";
    $sql_i .= " idt_produto_interesse,  ";
    $sql_i .= " idt_canal,  ";
    $sql_i .= " idt_categoria,  ";
    $sql_i .= " mome_realizacao,  ";
    $sql_i .= " inicio_realizacao,  ";
    $sql_i .= " termino_realizacao,  ";
    $sql_i .= " numero_pessoas_informadas,  ";
    $sql_i .= " idt_tipo_realizacao,  ";
    $sql_i .= " demanda,  ";
    $sql_i .= " idt_evento,  ";
    $sql_i .= " evento_origem,  ";
    $sql_i .= " canal_registro,  ";
    $sql_i .= " rm_codcfo,  ";
    $sql_i .= " idt_grupo_atendimento,  ";
    $sql_i .= " nan_num_visita,  ";
    $sql_i .= " idt_nan_tutor,  ";
    $sql_i .= " idt_nan_empresa,  ";
    $sql_i .= " idt_nan_ordem_pagamento,  ";
    $sql_i .= " nan_ap_sit_pf,  ";
    $sql_i .= " nan_ap_dt_pf,  ";
    $sql_i .= " nan_ap_sit_pj,  ";
    $sql_i .= " nan_ap_dt_pj,  ";
    $sql_i .= " nan_ap_sit_at,  ";
    $sql_i .= " nan_ap_dt_at,  ";
    $sql_i .= " nan_idt_motivo_desistencia,  ";
    $sql_i .= " nan_motivo_desistencia,  ";
    $sql_i .= " nan_prazo_validacao ";
    $sql_i .= " ) ";
    $sql_i .= " value ";
    $sql_i .= " ( ";
    $sql_i .= " $idt_consultor,  ";
    $sql_i .= " $idt_digitador,  ";
    $sql_i .= " $idt_consultor_prox_atend, ";
    $sql_i .= " $idt_unidade,  ";
    $sql_i .= " $idt_ponto_atendimento,  ";
    $sql_i .= " $assunto,  ";
    $sql_i .= " $idt_atendimento_agenda,  ";
    $sql_i .= " $data_inicio_atendimento,  ";
    $sql_i .= " $data_termino_atendimento,  ";
    $sql_i .= " $horas_atendimento,  ";
    $sql_i .= " $protocolo,  ";
    $sql_i .= " $idt_projeto,  ";
    $sql_i .= " $idt_cliente,  ";
    $sql_i .= " $idt_pessoa,  ";
    $sql_i .= " $cpf,  ";
    $sql_i .= " $cnpj,  ";
    $sql_i .= " $idt_projeto_acao,  ";
    $sql_i .= " $nome_pessoa,  ";
    $sql_i .= " $nome_empresa,  ";
    $sql_i .= " $primeiro,  ";
    $sql_i .= " $data_atendimento_relogio,  ";
    $sql_i .= " $data_atendimento_aberta,  ";
    $sql_i .= " $hora_inicio_atendimento,  ";
    $sql_i .= " $hora_termino_atendimento,  ";
    $sql_i .= " $data,  ";
    $sql_i .= " $idt_instrumento,  ";
    $sql_i .= " $situacao,  ";
    $sql_i .= " $pessoa_cep,  ";
    $sql_i .= " $pessoa_rua,  ";
    $sql_i .= " $pessoa_numero,  ";
    $sql_i .= " $pessoa_complemento,  ";
    $sql_i .= " $pessoa_bairro,  ";
    $sql_i .= " $pessoa_cidade,  ";
    $sql_i .= " $pessoa_pais,  ";
    $sql_i .= " $idt_pessoa_pais,  ";
    $sql_i .= " $idt_pessoa_estado,  ";
    $sql_i .= " $pessoa_estado,  ";
    $sql_i .= " $idt_pessoa_cidade,  ";
    $sql_i .= " $organizacao_cep,  ";
    $sql_i .= " $organizacao_rua,  ";
    $sql_i .= " $organizacao_numero,  ";
    $sql_i .= " $organizacao_complemento,  ";
    $sql_i .= " $organizacao_bairro,  ";
    $sql_i .= " $organizacao_cidade,  ";
    $sql_i .= " $organizacao_pais,  ";
    $sql_i .= " $idt_organizacao_pais,  ";
    $sql_i .= " $idt_organizacao_estado,  ";
    $sql_i .= " $organizacao_estado,  ";
    $sql_i .= " $idt_organizacao_cidade,  ";
    $sql_i .= " $pessoa_data_nascimento,  ";
    $sql_i .= " $pessoa_sexo,  ";
    $sql_i .= " $pessoa_telefone_residencial,  ";
    $sql_i .= " $pessoa_telefone_celular,  ";
    $sql_i .= " $pessoa_telefone_recado,  ";
    $sql_i .= " $pessoa_email,  ";
    $sql_i .= " $idt_escolaridade,  ";
    $sql_i .= " $receber_informacoes,  ";
    $sql_i .= " $potencial_personagem,  ";
    $sql_i .= " $pessoa_representante,  ";
    $sql_i .= " $interesse_tema,  ";
    $sql_i .= " $interesse_produto,  ";
    $sql_i .= " $idt_tipo_empreendimento,  ";
    $sql_i .= " $organizacao_data_abertura,  ";
    $sql_i .= " $organizacao_pessoas_ocupadas,  ";
    $sql_i .= " $organizacao_nome_fantasia,  ";
    $sql_i .= " $organizacao_telefone_comercial,  ";
    $sql_i .= " $organizacao_email_comercial,  ";
    $sql_i .= " $organizacao_site_url,  ";
    $sql_i .= " $idt_atividade_economica,  ";
    $sql_i .= " $idt_setor,  ";
    $sql_i .= " $organizacao_dap,  ";
    $sql_i .= " $organizacao_rmp,  ";
    $sql_i .= " $organizacao_nirf,  ";
    $sql_i .= " $tamanho_propriedade,  ";
    $sql_i .= " $idt_porte,  ";
    $sql_i .= " $faturamento,  ";
    $sql_i .= " $optante_simples,  ";
    $sql_i .= " $idt_segmentacao,  ";
    $sql_i .= " $idt_subsegmentacao,  ";
    $sql_i .= " $idt_programa_fidelidade,  ";
    $sql_i .= " $senha_totem,  ";
    $sql_i .= " $senha_ordem,  ";
    $sql_i .= " $gestor_sge,  ";
    $sql_i .= " $fase_acao_projeto,  ";
    $sql_i .= " $diagnostico,  ";
    $sql_i .= " $devolutiva,  ";
    $sql_i .= " $idt_competencia,  ";
    $sql_i .= " $idt_tema_tratado,  ";
    $sql_i .= " $idt_subtema_tratado,  ";
    $sql_i .= " $idt_tema_interesse,  ";
    $sql_i .= " $idt_subtema_interesse,  ";
    $sql_i .= " $idt_tema_produto_interesse,  ";
    $sql_i .= " $idt_produto_interesse,  ";
    $sql_i .= " $idt_canal,  ";
    $sql_i .= " $idt_categoria,  ";
    $sql_i .= " $mome_realizacao,  ";
    $sql_i .= " $inicio_realizacao,  ";
    $sql_i .= " $termino_realizacao,  ";
    $sql_i .= " $numero_pessoas_informadas,  ";
    $sql_i .= " $idt_tipo_realizacao,  ";
    $sql_i .= " $demanda,  ";
    $sql_i .= " $idt_evento,  ";
    $sql_i .= " $evento_origem,  ";
    $sql_i .= " $canal_registro,  ";
    $sql_i .= " $rm_codcfo,  ";
    $sql_i .= " $idt_grupo_atendimento,  ";
    $sql_i .= " $nan_num_visita,  ";
    $sql_i .= " $idt_nan_tutor,  ";
    $sql_i .= " $idt_nan_empresa,  ";
    $sql_i .= " $idt_nan_ordem_pagamento,  ";
    $sql_i .= " $nan_ap_sit_pf,  ";
    $sql_i .= " $nan_ap_dt_pf,  ";
    $sql_i .= " $nan_ap_sit_pj,  ";
    $sql_i .= " $nan_ap_dt_pj,  ";
    $sql_i .= " $nan_ap_sit_at,  ";
    $sql_i .= " $nan_ap_dt_at,  ";
    $sql_i .= " $nan_idt_motivo_desistencia,  ";
    $sql_i .= " $nan_motivo_desistencia,  ";
    $sql_i .= " $nan_prazo_validacao ";
    $sql_i .= " ) ";
    $result = execsql($sql_i);
    $idt_atendimento_2 = lastInsertId();

    $sql_i = 'insert into grc_atendimento_tema (idt_atendimento, idt_tema, idt_sub_tema, nome_tema, nome_sub_tema, tipo_tratamento)';
    $sql_i .= ' select ' . $idt_atendimento_2 . ' as idt_atendimento, idt_tema, idt_sub_tema, nome_tema, nome_sub_tema, tipo_tratamento';
    $sql_i .= ' from grc_atendimento_tema';
    $sql_i .= ' where idt_atendimento = ' . null($idt_atendimento_1);
    $sql_i .= " and tipo_tratamento = 'T' ";
    execsql($sql_i);

    //
    // Copiar Organizacao e Pessoa
    //
	$kokw = 1;
    $ret = CopiarOrganizacao($row, $idt_atendimento_2, $veterro);
    if ($ret == 1) {
        $ret = CopiarPessoa($row, $idt_atendimento_2, $veterro);
        if ($ret == 0) {
            $kokw = 0;
        } else {

            $ret = GerarPlanoFacil($row, $idt_atendimento_2);
            if ($ret == 0) {
                $kokw = 0;
            } else {
                $ret = AtualizarGrupoAtendimento($row, $idt_atendimento_2, $veterro);
                if ($ret == 0) {
                    $kokw = 0;
                }
            }
        }
    } else {
        $kokw = 0;
    }
    return $kokw;
}

function CopiarAtendimentoAgenda($row, &$idt_atendimento_agenda_2, &$veterro) {
    $idt_atendimento_agenda_1 = $row['idt_atendimento_agenda'];
    $sql = "select  ";
    $sql .= "   *  ";
    $sql .= " from  grc_atendimento_agenda ";
    $sql .= " where idt =  " . null($idt_atendimento_agenda_1);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $veterro[] = "Não encontrada a Agenda do Atendimento com idt = {$idt_atendimento_agenda_1}";
        return 0;
    } else {
        foreach ($rs->data as $row) {
            $banco = "db_pir_grc";
            $tabela = "grc_atendimento_agenda";
            MontaSql($banco, $tabela, $vetEstrutura);

            $CamposTabela = $vetEstrutura['doc'][$banco][$tabela]['cpo'];
            $tam = count($CamposTabela);
            foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
                $tipo = $vetPropriedades['tipo'];
                $valorcampo = $row[$nomecampo];
                $valorcampoeditado = EditaCampoSql($tipo, $valorcampo);
                $$nomecampo = $valorcampoeditado;
            }

            $idt_instrumento = 2;

            $sql_i = "";
            $sql_i .= "insert into " . db_pir_grc . "grc_atendimento_agenda ";
            $sql_i .= " ( ";
            $sql_i .= " idt_consultor, ";
            $sql_i .= " idt_cliente, ";
            $sql_i .= " idt_especialidade, ";
            $sql_i .= " data, ";
            $sql_i .= " hora, ";
            $sql_i .= " origem, ";
            $sql_i .= " detalhe, ";
            $sql_i .= " situacao, ";
            $sql_i .= " data_confirmacao, ";
            $sql_i .= " hora_confirmacao, ";
            $sql_i .= " telefone, ";
            $sql_i .= " hora_chegada, ";
            $sql_i .= " hora_atendimento, ";
            $sql_i .= " idt_ponto_atendimento, ";
            $sql_i .= " dia_semana, ";
            $sql_i .= " hora_liberacao, ";
            $sql_i .= " celular, ";
            $sql_i .= " observacao_chegada, ";
            $sql_i .= " observacao_atendimento, ";
            $sql_i .= " cliente_texto, ";
            $sql_i .= " mensagem, ";
            $sql_i .= " hora_marcada_extra, ";
            $sql_i .= " tipo_pessoa, ";
            $sql_i .= " data_hora_marcacao, ";
            $sql_i .= " fila, ";
            $sql_i .= " protocolo, ";
            $sql_i .= " email, ";
            $sql_i .= " cpf, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " nome_empresa, ";
            $sql_i .= " assunto, ";
            $sql_i .= " hora_final_atendimento, ";
            $sql_i .= " idt_atendimento_gera_agenda, ";
            $sql_i .= " senha_totem, ";
            $sql_i .= " senha_ordem, ";
            $sql_i .= " idt_instrumento, ";
            $sql_i .= " idt_empreendimento ";
            $sql_i .= " ) ";
            $sql_i .= " value ";
            $sql_i .= " ( ";
            $sql_i .= " $idt_consultor, ";
            $sql_i .= " $idt_cliente, ";
            $sql_i .= " $idt_especialidade, ";
            $sql_i .= " $data, ";
            $sql_i .= " $hora, ";
            $sql_i .= " $origem, ";
            $sql_i .= " $detalhe, ";
            $sql_i .= " $situacao, ";
            $sql_i .= " $data_confirmacao, ";
            $sql_i .= " $hora_confirmacao, ";
            $sql_i .= " $telefone, ";
            $sql_i .= " $hora_chegada, ";
            $sql_i .= " $hora_atendimento, ";
            $sql_i .= " $idt_ponto_atendimento, ";
            $sql_i .= " $dia_semana, ";
            $sql_i .= " $hora_liberacao, ";
            $sql_i .= " $celular, ";
            $sql_i .= " $observacao_chegada, ";
            $sql_i .= " $observacao_atendimento, ";
            $sql_i .= " $cliente_texto, ";
            $sql_i .= " $mensagem, ";
            $sql_i .= " $hora_marcada_extra, ";
            $sql_i .= " $tipo_pessoa, ";
            $sql_i .= " $data_hora_marcacao, ";
            $sql_i .= " $fila, ";
            $sql_i .= " $protocolo, ";
            $sql_i .= " $email, ";
            $sql_i .= " $cpf, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $nome_empresa, ";
            $sql_i .= " $assunto, ";
            $sql_i .= " $hora_final_atendimento, ";
            $sql_i .= " $idt_atendimento_gera_agenda, ";
            $sql_i .= " $senha_totem, ";
            $sql_i .= " $senha_ordem, ";
            $sql_i .= " $idt_instrumento, ";
            $sql_i .= " $idt_empreendimento ";
            $sql_i .= " ) ";
            $result = execsql($sql_i);
            $idt_atendimento_agenda_2 = lastInsertId();
            return 1;
        }
    }
    return 0;
}

function CopiarOrganizacao($row, $idt_atendimento_2, &$veterro) {
    $idt_atendimento_1 = $row['idt'];
    $sql = "select  ";
    $sql .= "   grc_ao.*  ";
    $sql .= " from  grc_atendimento_organizacao grc_ao  ";
    $sql .= " where grc_ao.idt_atendimento =  " . null($idt_atendimento_1);
    $sql .= "   and grc_ao.representa      =  " . aspa('S');
    $sql .= "   and grc_ao.desvincular     =  " . aspa('N');
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $veterro[] = "Não encontrada Organização para o Atendimento com idt = {$idt_atendimento_1}, representa = S e desvincular= N";
        return 0;
    } else {
        if ($rs->rows != 1) {
            $veterro[] = "Encontrada Mais de uma Organização para o Atendimento com idt = {$idt_atendimento_1}, representa = S e desvincular= N";
            return 0;
        }
        foreach ($rs->data as $row) {
            $banco = "db_pir_grc";
            $tabela = "grc_atendimento_organizacao";
            MontaSql($banco, $tabela, $vetEstrutura);
            //
            $CamposTabela = $vetEstrutura['doc'][$banco][$tabela]['cpo'];
            $tam = count($CamposTabela);
            foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
                $tipo = $vetPropriedades['tipo'];
                $valorcampo = $row[$nomecampo];
                $valorcampoeditado = EditaCampoSql($tipo, $valorcampo);
                $$nomecampo = $valorcampoeditado;
            }

            if ($siacweb_situacao_e == '' || $siacweb_situacao_e == 'NULL') {
                $siacweb_situacao_e = 1;
            }

            $idt_atendimento = $idt_atendimento_2;
            // Include: db_pir_grc_grc_atendimento_organizacao_insert.php 
            // Banco  : db_pir_grc 
            // Tabela : grc_atendimento_organizacao 
            // Código para Insert em PHP 
            $sql_i = "";
            $sql_i .= "insert into " . db_pir_grc . "grc_atendimento_organizacao ";
            $sql_i .= " ( ";
            $sql_i .= " idt_atendimento,  ";
            $sql_i .= " cnpj,  ";
            $sql_i .= " razao_social,  ";
            $sql_i .= " nome_fantasia,  ";
            $sql_i .= " logradouro_cep_e,  ";
            $sql_i .= " logradouro_endereco_e,  ";
            $sql_i .= " logradouro_numero_e,  ";
            $sql_i .= " logradouro_complemento_e,  ";
            $sql_i .= " logradouro_referencia_e,  ";
            $sql_i .= " logradouro_codbairro_e,  ";
            $sql_i .= " logradouro_bairro_e,  ";
            $sql_i .= " logradouro_codcid_e,  ";
            $sql_i .= " logradouro_cidade_e,  ";
            $sql_i .= " logradouro_codest_e,  ";
            $sql_i .= " logradouro_estado_e,  ";
            $sql_i .= " logradouro_codpais_e,  ";
            $sql_i .= " logradouro_pais_e,  ";
            $sql_i .= " idt_pais_e,  ";
            $sql_i .= " idt_estado_e,  ";
            $sql_i .= " idt_cidade_e,  ";
            $sql_i .= " telefone_comercial_e,  ";
            $sql_i .= " telefone_celular_e,  ";
            $sql_i .= " email_e,  ";
            $sql_i .= " sms_e,  ";
            $sql_i .= " receber_informacao_e,  ";
            $sql_i .= " codigo_siacweb_e,  ";
            $sql_i .= " idt_organizacao,  ";
            $sql_i .= " site_url,  ";
            $sql_i .= " idt_porte,  ";
            $sql_i .= " idt_tipo_empreendimento,  ";
            $sql_i .= " data_abertura,  ";
            $sql_i .= " pessoas_ocupadas,  ";
            $sql_i .= " idt_setor,  ";
            $sql_i .= " idt_cnae_principal,  ";
            $sql_i .= " simples_nacional,  ";
            $sql_i .= " tamanho_propriedade,  ";
            $sql_i .= " dap,  ";
            $sql_i .= " nirf,  ";
            $sql_i .= " rmp,  ";
            $sql_i .= " ie_prod_rural,  ";
            $sql_i .= " sicab_codigo,  ";
            $sql_i .= " sicab_dt_validade,  ";
            $sql_i .= " data_fim_atividade,  ";
            $sql_i .= " siacweb_situacao_e,  ";
            $sql_i .= " pa_senha_e, ";
            $sql_i .= " pa_idfacebook_e, ";
            $sql_i .= " representa,  ";
            $sql_i .= " desvincular,  ";
            $sql_i .= " codigo_prod_rural,  ";
            $sql_i .= " novo_registro,  ";
            $sql_i .= " modificado,  ";
            $sql_i .= " funil_cliente_nota_avaliacao, ";
            $sql_i .= " funil_idt_cliente_classificacao, ";
            $sql_i .= " funil_cliente_data_avaliacao, ";
            $sql_i .= " funil_cliente_obs_avaliacao, ";
            $sql_i .= " representa_codcargcli ";
            $sql_i .= " ) ";
            $sql_i .= " value ";
            $sql_i .= " ( ";
            $sql_i .= " $idt_atendimento,  ";
            $sql_i .= " $cnpj,  ";
            $sql_i .= " $razao_social,  ";
            $sql_i .= " $nome_fantasia,  ";
            $sql_i .= " $logradouro_cep_e,  ";
            $sql_i .= " $logradouro_endereco_e,  ";
            $sql_i .= " $logradouro_numero_e,  ";
            $sql_i .= " $logradouro_complemento_e,  ";
            $sql_i .= " $logradouro_referencia_e,  ";
            $sql_i .= " $logradouro_codbairro_e,  ";
            $sql_i .= " $logradouro_bairro_e,  ";
            $sql_i .= " $logradouro_codcid_e,  ";
            $sql_i .= " $logradouro_cidade_e,  ";
            $sql_i .= " $logradouro_codest_e,  ";
            $sql_i .= " $logradouro_estado_e,  ";
            $sql_i .= " $logradouro_codpais_e,  ";
            $sql_i .= " $logradouro_pais_e,  ";
            $sql_i .= " $idt_pais_e,  ";
            $sql_i .= " $idt_estado_e,  ";
            $sql_i .= " $idt_cidade_e,  ";
            $sql_i .= " $telefone_comercial_e,  ";
            $sql_i .= " $telefone_celular_e,  ";
            $sql_i .= " $email_e,  ";
            $sql_i .= " $sms_e,  ";
            $sql_i .= " $receber_informacao_e,  ";
            $sql_i .= " $codigo_siacweb_e,  ";
            $sql_i .= " $idt_organizacao,  ";
            $sql_i .= " $site_url,  ";
            $sql_i .= " $idt_porte,  ";
            $sql_i .= " $idt_tipo_empreendimento,  ";
            $sql_i .= " $data_abertura,  ";
            $sql_i .= " $pessoas_ocupadas,  ";
            $sql_i .= " $idt_setor,  ";
            $sql_i .= " $idt_cnae_principal,  ";
            $sql_i .= " $simples_nacional,  ";
            $sql_i .= " $tamanho_propriedade,  ";
            $sql_i .= " $dap,  ";
            $sql_i .= " $nirf,  ";
            $sql_i .= " $rmp,  ";
            $sql_i .= " $ie_prod_rural,  ";
            $sql_i .= " $sicab_codigo,  ";
            $sql_i .= " $sicab_dt_validade,  ";
            $sql_i .= " $data_fim_atividade,  ";
            $sql_i .= " $siacweb_situacao_e,  ";
            $sql_i .= " $pa_senha_e, ";
            $sql_i .= " $pa_idfacebook_e, ";
            $sql_i .= " $representa,  ";
            $sql_i .= " $desvincular,  ";
            $sql_i .= " $codigo_prod_rural,  ";
            $sql_i .= " $novo_registro,  ";
            $sql_i .= " $modificado,  ";
            $sql_i .= " $funil_cliente_nota_avaliacao, ";
            $sql_i .= " $funil_idt_cliente_classificacao, ";
            $sql_i .= " $funil_cliente_data_avaliacao, ";
            $sql_i .= " $funil_cliente_obs_avaliacao, ";
            $sql_i .= " $representa_codcargcli ";
            $sql_i .= " ) ";
            $result = execsql($sql_i);
            $idt_atendimento_organizacao_2 = lastInsertId();

            $sql_i = 'insert into grc_atendimento_organizacao_cnae (idt_atendimento_organizacao, cnae, principal)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt_atendimento_organizacao, cnae, principal';
            $sql_i .= ' from grc_atendimento_organizacao_cnae';
            $sql_i .= ' where idt_atendimento_organizacao = ' . null($row['idt']);
            execsql($sql_i);

            $sql_i = 'insert into grc_atendimento_organizacao_tipo_informacao (idt, idt_tipo_informacao_e)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt, idt_tipo_informacao_e';
            $sql_i .= ' from grc_atendimento_organizacao_tipo_informacao';
            $sql_i .= ' where idt = ' . null($row['idt']);
            execsql($sql_i);
            return 1;
        }
    }
    return 0;
}

function CopiarPessoa($row, $idt_atendimento_2, &$veterro) {
    $idt_atendimento_1 = $row['idt'];
    $sql = "select  ";
    $sql .= "   grc_ap.*  ";
    $sql .= " from  grc_atendimento_pessoa grc_ap  ";
    $sql .= " where grc_ap.idt_atendimento =  " . null($idt_atendimento_1);
    $sql .= "   and grc_ap.tipo_relacao    =  " . aspa('L');
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Tem erro
        $veterro[] = "Não encontrada pessoa para o Atendimento com idt = {$idt_atendimento_1}, tipo_relacao = L";
        return 0;
    } else {
        if ($rs->rows != 1) {
            $veterro[] = "Encontrada mais de uma pessoa para o Atendimento com idt = {$idt_atendimento_1}, tipo_relacao = L";
            return 0;
        }
        foreach ($rs->data as $row) {
            $banco = "db_pir_grc";
            $tabela = "grc_atendimento_pessoa";
            MontaSql($banco, $tabela, $vetEstrutura);
            //
            $CamposTabela = $vetEstrutura['doc'][$banco][$tabela]['cpo'];
            $tam = count($CamposTabela);
            foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
                $tipo = $vetPropriedades['tipo'];
                $valorcampo = $row[$nomecampo];
                $valorcampoeditado = EditaCampoSql($tipo, $valorcampo);
                $$nomecampo = $valorcampoeditado;
            }

            if ($siacweb_situacao == '' || $siacweb_situacao == 'NULL') {
                $siacweb_situacao = 1;
            }

            $idt_atendimento = $idt_atendimento_2;
            // Include: db_pir_grc_grc_atendimento_pessoa_insert.php 
            // Banco  : db_pir_grc 
            // Tabela : grc_atendimento_pessoa 
            // Código para Insert em PHP 
            $sql_i = "";
            $sql_i .= "insert into " . db_pir_grc . "grc_atendimento_pessoa ";
            $sql_i .= " ( ";
            $sql_i .= " idt_atendimento,  ";
            $sql_i .= " cpf,  ";
            $sql_i .= " nome,  ";
            $sql_i .= " nome_mae,  ";
            $sql_i .= " idt_ativeconpf, ";
            $sql_i .= " siacweb_situacao, ";
            $sql_i .= " pa_senha, ";
            $sql_i .= " pa_idfacebook, ";
            $sql_i .= " logradouro_cep,  ";
            $sql_i .= " logradouro_endereco,  ";
            $sql_i .= " logradouro_numero,  ";
            $sql_i .= " logradouro_complemento,  ";
            $sql_i .= " logradouro_referencia,  ";
            $sql_i .= " logradouro_codbairro,  ";
            $sql_i .= " logradouro_bairro,  ";
            $sql_i .= " logradouro_codcid,  ";
            $sql_i .= " logradouro_cidade,  ";
            $sql_i .= " logradouro_codest,  ";
            $sql_i .= " logradouro_estado,  ";
            $sql_i .= " logradouro_codpais,  ";
            $sql_i .= " logradouro_pais,  ";
            $sql_i .= " idt_pais,  ";
            $sql_i .= " idt_estado,  ";
            $sql_i .= " idt_cidade,  ";
            $sql_i .= " telefone_residencial,  ";
            $sql_i .= " telefone_celular,  ";
            $sql_i .= " email,  ";
            $sql_i .= " sms,  ";
            $sql_i .= " nome_tratamento,  ";
            $sql_i .= " idt_escolaridade,  ";
            $sql_i .= " idt_sexo,  ";
            $sql_i .= " data_nascimento,  ";
            $sql_i .= " receber_informacao,  ";
            $sql_i .= " tipo_relacao,  ";
            $sql_i .= " nome_pai,  ";
            $sql_i .= " necessidade_especial,  ";
            $sql_i .= " idt_profissao,  ";
            $sql_i .= " idt_estado_civil,  ";
            $sql_i .= " idt_cor_pele,  ";
            $sql_i .= " idt_religiao,  ";
            $sql_i .= " idt_destreza,  ";
            $sql_i .= " potencial_personagem,  ";
            $sql_i .= " representa_empresa,  ";
            $sql_i .= " codigo_siacweb,  ";
            $sql_i .= " siacweb_codparticipantecosultoria,  ";
            $sql_i .= " idt_segmentacao,  ";
            $sql_i .= " idt_subsegmentacao,  ";
            $sql_i .= " idt_programa_fidelidade,  ";
            $sql_i .= " telefone_recado,  ";
            $sql_i .= " idt_pessoa,  ";
            $sql_i .= " evento_cortesia,  ";
            $sql_i .= " evento_alt_siacweb,  ";
            $sql_i .= " evento_inscrito,  ";
            $sql_i .= " evento_exc_siacweb,  ";
            $sql_i .= " evento_concluio,  ";
            $sql_i .= " falta_sincronizar_siacweb ";
            $sql_i .= " ) ";
            $sql_i .= " value ";
            $sql_i .= " ( ";
            $sql_i .= " $idt_atendimento,  ";
            $sql_i .= " $cpf,  ";
            $sql_i .= " $nome,  ";
            $sql_i .= " $nome_mae,  ";
            $sql_i .= " $idt_ativeconpf, ";
            $sql_i .= " $siacweb_situacao, ";
            $sql_i .= " $pa_senha, ";
            $sql_i .= " $pa_idfacebook, ";
            $sql_i .= " $logradouro_cep,  ";
            $sql_i .= " $logradouro_endereco,  ";
            $sql_i .= " $logradouro_numero,  ";
            $sql_i .= " $logradouro_complemento,  ";
            $sql_i .= " $logradouro_referencia,  ";
            $sql_i .= " $logradouro_codbairro,  ";
            $sql_i .= " $logradouro_bairro,  ";
            $sql_i .= " $logradouro_codcid,  ";
            $sql_i .= " $logradouro_cidade,  ";
            $sql_i .= " $logradouro_codest,  ";
            $sql_i .= " $logradouro_estado,  ";
            $sql_i .= " $logradouro_codpais,  ";
            $sql_i .= " $logradouro_pais,  ";
            $sql_i .= " $idt_pais,  ";
            $sql_i .= " $idt_estado,  ";
            $sql_i .= " $idt_cidade,  ";
            $sql_i .= " $telefone_residencial,  ";
            $sql_i .= " $telefone_celular,  ";
            $sql_i .= " $email,  ";
            $sql_i .= " $sms,  ";
            $sql_i .= " $nome_tratamento,  ";
            $sql_i .= " $idt_escolaridade,  ";
            $sql_i .= " $idt_sexo,  ";
            $sql_i .= " $data_nascimento,  ";
            $sql_i .= " $receber_informacao,  ";
            $sql_i .= " $tipo_relacao,  ";
            $sql_i .= " $nome_pai,  ";
            $sql_i .= " $necessidade_especial,  ";
            $sql_i .= " $idt_profissao,  ";
            $sql_i .= " $idt_estado_civil,  ";
            $sql_i .= " $idt_cor_pele,  ";
            $sql_i .= " $idt_religiao,  ";
            $sql_i .= " $idt_destreza,  ";
            $sql_i .= " $potencial_personagem,  ";
            $sql_i .= " $representa_empresa,  ";
            $sql_i .= " $codigo_siacweb,  ";
            $sql_i .= " $siacweb_codparticipantecosultoria,  ";
            $sql_i .= " $idt_segmentacao,  ";
            $sql_i .= " $idt_subsegmentacao,  ";
            $sql_i .= " $idt_programa_fidelidade,  ";
            $sql_i .= " $telefone_recado,  ";
            $sql_i .= " $idt_pessoa,  ";
            $sql_i .= " $evento_cortesia,  ";
            $sql_i .= " $evento_alt_siacweb,  ";
            $sql_i .= " $evento_inscrito,  ";
            $sql_i .= " $evento_exc_siacweb,  ";
            $sql_i .= " $evento_concluio,  ";
            $sql_i .= " $falta_sincronizar_siacweb ";
            $sql_i .= " ) ";
            $result = execsql($sql_i);
            $idt_atendimento_organizacao_2 = lastInsertId();

            $sql_i = 'insert into grc_atendimento_pessoa_produto_interesse (idt_atendimento_pessoa, idt_produto, observacao, data_registro, idt_responsavel)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt_atendimento_pessoa, idt_produto, observacao, data_registro, idt_responsavel';
            $sql_i .= ' from grc_atendimento_pessoa_produto_interesse';
            $sql_i .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
            execsql($sql_i);

            $sql_i = 'insert into grc_atendimento_pessoa_tema_interesse (idt_atendimento_pessoa, idt_tema, idt_subtema, observacao, idt_responsavel, data_registro)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt_atendimento_pessoa, idt_tema, idt_subtema, observacao, idt_responsavel, data_registro';
            $sql_i .= ' from grc_atendimento_pessoa_tema_interesse';
            $sql_i .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
            execsql($sql_i);

            $sql_i = 'insert into grc_atendimento_pessoa_tipo_deficiencia (idt, idt_tipo_deficiencia)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt, idt_tipo_deficiencia';
            $sql_i .= ' from grc_atendimento_pessoa_tipo_deficiencia';
            $sql_i .= ' where idt = ' . null($row['idt']);
            execsql($sql_i);

            $sql_i = 'insert into grc_atendimento_pessoa_tipo_informacao (idt, idt_tipo_informacao)';
            $sql_i .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt, idt_tipo_informacao';
            $sql_i .= ' from grc_atendimento_pessoa_tipo_informacao';
            $sql_i .= ' where idt = ' . null($row['idt']);
            execsql($sql_i);

            $arqCopia = Array();

            $sql = '';
            $sql .= ' select ' . $idt_atendimento_organizacao_2 . ' as idt_atendimento_pessoa, idt_responsavel, data_registro, titulo, arquivo';
            $sql .= ' from grc_atendimento_pessoa_arquivo_interesse';
            $sql .= ' where idt_atendimento_pessoa = ' . null($row['idt']);
            $rs = execsql($sql);

            ForEach ($rs->data as $row2) {
                $vetPrefixoArq = explode('_', $row2['arquivo']);
                $PrefixoArq = '';
                $PrefixoArq .= $vetPrefixoArq[0] . '_';
                $PrefixoArq .= $vetPrefixoArq[1] . '_';
                $PrefixoArq .= $vetPrefixoArq[2] . '_';
                $arq_novo = GerarStr() . '_arquivo_' . substr(time(), -3) . '_' . substr($row2['arquivo'], strlen($PrefixoArq));

                $arqCopia[] = Array(
                    'de' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_atendimento_pessoa_arquivo_interesse/' . $row2['arquivo']),
                    'para' => str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/obj_file/grc_atendimento_pessoa_arquivo_interesse/' . $arq_novo),
                );

                $idt_atendimento_pessoa = null($row2['idt_atendimento_pessoa']);
                $idt_responsavel = null($row2['idt_responsavel']);
                $data_registro = aspa($row2['data_registro']);
                $titulo = aspa($row2['titulo']);
                $arquivo = aspa($arq_novo);

                $sql_i = ' insert into grc_atendimento_pessoa_arquivo_interesse ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_atendimento_pessoa, ";
                $sql_i .= " idt_responsavel, ";
                $sql_i .= " data_registro, ";
                $sql_i .= " titulo, ";
                $sql_i .= " arquivo ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_atendimento_pessoa, ";
                $sql_i .= " $idt_responsavel, ";
                $sql_i .= " $data_registro, ";
                $sql_i .= " $titulo, ";
                $sql_i .= " $arquivo ";
                $sql_i .= ') ';
                execsql($sql_i);
            }

            if (is_array($arqCopia)) {
                foreach ($arqCopia as $arq) {
                    if (is_file($arq['de'])) {
                        copy($arq['de'], $arq['para']);
                    }
                }
            }

            return 1;
        }
    }
    return 0;
}

function AtualizarGrupoAtendimento($row, $idt_atendimento_2, &$veterro) {
    $kokw = 1;
    $idt_grupo_atendimento = $row['idt_grupo_atendimento'];
    $sql = "select  ";
    $sql .= "   grc_nan_ga.*  ";
    $sql .= " from  grc_nan_grupo_atendimento grc_nan_ga ";
    $sql .= " where grc_nan_ga.idt              =   " . null($idt_grupo_atendimento);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $veterro[] = "Não encontrado o Grupo de Atendimento com idt = {$idt_nan_grupo_atendimento}";
        return 0;
    }
    foreach ($rs->data as $row) {
        $num_visita_atu = $row['num_visita_atu'];
        if ($row['num_visita_atu'] != 1) {
            $veterro[] = "Número atual da Visita tem que ser 1 esta com {$num_visita_atu}";
            return 0;
        } else {
            //
            // Inicializar Grupo para 2a Visita
            //
			$datadia = trata_data(date('d/m/Y H:i:s'));
            $dt_registro_2 = aspa($datadia);
            $idt_pessoa_2 = $row['idt_pessoa_1'];
            $status_2 = aspa("CD");
            //
            $sql = 'update grc_nan_grupo_atendimento ';
            $sql .= " set num_visita_atu = 2, ";
            $sql .= " idt_pessoa_2   = {$idt_pessoa_2}, ";
            $sql .= " dt_registro_2  = {$dt_registro_2}, ";
            $sql .= " status_2       = {$status_2} ";

            $sql .= ' where idt          = ' . null($idt_grupo_atendimento);
            execsql($sql);
        }
    }

    return $kokw;
}

function MontaSql($banco, $tabela, &$vetEstrutura) {
    $vetEstrutura = Array();
    if ($_SESSION[CS]['g_estrutura_tabela'][$banco][$tabela] != '') {
        $vetEstrutura = $_SESSION[CS]['g_estrutura_tabela'][$banco][$tabela];
        return 2;
    }



    $sql = "select  ";
    $sql .= "   *  ";
    $sql .= "     ";
    if ($banco == '') {
        $sql .= " from  {$tabela} ";
    } else {
        $sql .= " from  {$banco}.{$tabela} ";
    }
    $sql .= " where 2 = 1  ";
    $rs = execsql($sql);
    //p($rs);
    $vetNoneCampo = Array();
    $vetNoneCampo = $rs->info['name'];
    //p($vetNoneCampo);
    $vetTipoCampo = Array();
    $vetTipoCampo = $rs->info['type'];
    // p($vetTipoCampo);
    $vetDadoCampo = Array();
    $vetDadoCampo = $rs->data;
    $vetTipoCampot = AjustaTipo($vetNoneCampo, $vetTipoCampo);

    $vetEstrutura['Banco'] = $banco;
    $vetEstrutura['Tabela'] = $tabela;
    $vetEstrutura['CampoNome'] = $vetNoneCampo;
    $vetEstrutura['CampoTipo'] = $vetTipoCampot;
    MontaDocumentacaoCampo($vetEstrutura);
    MontaEstruturaSQL($vetEstrutura);
    $_SESSION[CS]['g_estrutura_tabela'][$banco][$tabela] = $vetEstrutura;
    return 1;

    // p($vetDadoCampo);
}

function AjustaTipo($vetNoneCampo, $vetTipoCampo) {
    global $tipodb;




    $vetTipoBancoDados = Array();
    foreach ($vetNoneCampo as $numeroordem => $nomecampo) {
        $tipodado = $vetTipoCampo[$nomecampo];
        // aqui converter de acordo com o tipo do banco
        $tipobanco = $tipodb;
        $vetTipoBancoDados[$tipodb][$nomecampo] = $tipodadoGSD;
        $tipodadoGSD = AjustaTipoBanco($tipobanco, $tipodado);
        $vetTipoBancoDados['GSD'][$nomecampo] = $tipodadoGSD;
    }
    return $vetTipoBancoDados;
}

function AjustaTipoBanco($tipobanco, $tipodado) {
    $TabelaTioDadosDB = Array();
    $TabelaTioDadosDB['mysql']['date'] = 'data';
    $TabelaTioDadosDB['mysql']['datetime'] = 'datahora';
    $TabelaTioDadosDB['mysql']['string'] = 'string';
    $TabelaTioDadosDB['mysql']['var_string'] = 'string';
    $TabelaTioDadosDB['mysql']['blob'] = 'texto';

    $TabelaTioDadosDB['mysql']['long'] = 'inteiro';
    $TabelaTioDadosDB['mysql']['decimal'] = 'decimal';
    $TabelaTioDadosDB['mysql']['newdecimal'] = 'decimal';




    $TipoGSD = $TabelaTioDadosDB[$tipobanco][$tipodado];
    return $TipoGSD;
}

function MontaDocumentacaoCampo(&$vetEstrutura) {
    $vetTabelaDoc = Array();
    $banco = $vetEstrutura['Banco'];
    $tabela = $vetEstrutura['Tabela'];
    $vetTabelaDoc[$banco]['bco']['dsc'] = 'Descrição do Banco';

    $vetTabelaDoc[$banco][$tabela]['tba']['dsc'] = 'Descrição da Tabela';

    $vetNoneCampo = $vetEstrutura['CampoNome'];
    $vetTipoCampot = $vetEstrutura['CampoTipo'];

    foreach ($vetNoneCampo as $numeroordem => $nomecampo) {
        $vetTabelaDoc[$banco][$tabela]['cpo'][$nomecampo]['tipo'] = $vetTipoCampot['GSD'][$nomecampo];
    }


    $vetEstrutura['doc'] = $vetTabelaDoc;
    return 1;
}

function MontaEstruturaSQL(&$vetEstrutura) {

    $vetTabelaSQL = Array();
    $vetTabelaDoc = $vetEstrutura['doc'];
    $banco = $vetEstrutura['Banco'];
    $tabela = $vetEstrutura['Tabela'];
    $CamposTabela = $vetTabelaDoc[$banco][$tabela]['cpo'];
    $tam = count($CamposTabela);
    // SQL --> Insert
    $vetsql = Array();
    $vetsql[] = '#?php ';
    $vetsql[] = 'insert into ' . $banco . $tabela . '    ';
    $vetsql[] = '(  ';
    $ultimo = 0;
    $virgula = ", ";
    foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
        $tipo = $vetPropriedades['tipo'];
        $ultimo = $ultimo + 1;
        if ($ultimo == $tam) {
            $virgula = "";
        }
        $vetsql[] = '  ' . $nomecampo . $virgula . '   ';
    }
    $vetsql[] = '   )  ';
    $vetsql[] = '  value   ';
    $vetsql[] = '   (   ';
    $ultimo = 0;
    $virgula = ", ";
    foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
        $tipo = $vetPropriedades['tipo'];
        $ultimo = $ultimo + 1;
        if ($ultimo == $tam) {
            $virgula = "";
        }
        $vetsql[] = '  $' . $nomecampo . $virgula . '   ';
    }
    $vetsql[] = '   )   ';
    $vetTabelaSQL['SQL']['insert'] = $vetsql;
    // PHP --> Insert
    $vetsql = Array();
    $vetsql[] = "// Include: {$banco}_{$tabela}_insert.php ";
    $vetsql[] = "// Banco  : {$banco} ";
    $vetsql[] = "// Tabela : {$tabela} ";
    $vetsql[] = "// Código para Insert em PHP ";
    $vetsql[] = '  $sql_i   = ""; ';
    $vetsql[] = '  $sql_i  .= "insert into ' . $banco . '.' . $tabela . ' ";    ';
    $vetsql[] = '  $sql_i  .= " ( ";  ';
    $ultimo = 0;
    $virgula = ", ";
    foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
        $tipo = $vetPropriedades['tipo'];
        $ultimo = $ultimo + 1;
        if ($ultimo == $tam) {
            $virgula = "";
        }
        $vetsql[] = '  $sql_i  .= " ' . $nomecampo . $virgula . ' ";  ';
    }
    $vetsql[] = '  $sql_i  .= " ) ";  ';
    $vetsql[] = '  $sql_i  .= " value ";  ';
    $vetsql[] = '  $sql_i  .= " ( ";  ';
    $ultimo = 0;
    $virgula = ", ";
    foreach ($CamposTabela as $nomecampo => $vetPropriedades) {
        $tipo = $vetPropriedades['tipo'];
        $ultimo = $ultimo + 1;
        if ($ultimo == $tam) {
            $virgula = "";
        }
        $vetsql[] = '  $sql_i  .= " $' . $nomecampo . $virgula . ' ";  ';
    }
    $vetsql[] = '  $sql_i  .= " ) ";  ';

    $vetsql[] = '  $result = execsql($sql_i);  ';


    $vetTabelaSQL['PHP']['insert'] = $vetsql;
    $vetEstrutura['sql'] = $vetTabelaSQL;
}

function AtualizarPathPDF($idt_avaliacao, $arquivo, $tipo, &$veterro) {
    $kokw = 1;
    $sql = "select  ";
    $sql .= "   grc_at.idt_grupo_atendimento as grc_at_idt_grupo_atendimento   ";
    $sql .= " from  grc_avaliacao grc_a ";
    $sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
    $sql .= " where grc_a.idt  =  " . null($idt_avaliacao);
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        $veterro[] = "Não encontrado o Grupo de Atendimento com idt avaliação = {$idt_avaliacao}";
        return 0;
    }
    foreach ($rs->data as $row) {
        $idt_grupo_atendimento = $row['grc_at_idt_grupo_atendimento'];
        $arquivo = aspa($arquivo);
        if ($tipo == 'DE') { // Devolutiva
            $sql = 'update grc_nan_grupo_atendimento ';
            $sql .= " set pdf_devolutiva = {$arquivo} ";
            $sql .= ' where idt      = ' . null($idt_grupo_atendimento);
            execsql($sql);
        }
        if ($tipo == 'PF') { // Plano Facil
            $sql = 'update grc_nan_grupo_atendimento ';
            $sql .= " set pdf_plano_facil = {$arquivo} ";
            $sql .= ' where idt       = ' . null($idt_grupo_atendimento);
            execsql($sql);
        }
        if ($tipo == 'PR') { // Protocolo
            $sql = 'update grc_nan_grupo_atendimento ';
            $sql .= " set pdf_protocolo   = {$arquivo} ";
            $sql .= ' where idt       = ' . null($idt_grupo_atendimento);
            execsql($sql);
        }
    }

    return $kokw;
}

function GerarPlanoFacil($row, $idt_atendimento_2) {
    $kokw = 1;
    $idt_atendimento_1 = $row['idt'];
    //
    // Gravar grc_plano_facil
    //
    $datadia = (date('d/m/Y H:i:s'));
    $idt_responsavel = $_SESSION[CS]['g_id_usuario'];
    $data_responsavel = aspa(trata_data($datadia));
    $tabela = 'grc_plano_facil';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'PF' . $codigow;
    $protocolo = aspa($codigo);
    $sql_i = "";
    $sql_i .= "insert into " . db_pir_grc . "grc_plano_facil ";
    $sql_i .= " ( ";
    $sql_i .= " idt_atendimento,  ";
    $sql_i .= " protocolo,  ";
    $sql_i .= " idt_responsavel,  ";
    $sql_i .= " data_responsavel ";
    $sql_i .= " ) ";
    $sql_i .= " value ";
    $sql_i .= " ( ";
    $sql_i .= " $idt_atendimento_2,  ";
    $sql_i .= " $protocolo,  ";
    $sql_i .= " $idt_responsavel,  ";
    $sql_i .= " $data_responsavel ";
    $sql_i .= " ) ";
    $result = execsql($sql_i);
    $idt_plano_facil = lastInsertId();
    //
    $sql = "select  ";
    $sql .= " distinct  grc_fa.idt        as grc_fa_idt  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
    $sql .= " inner join grc_avaliacao_devolutiva_ferramenta grc_adf on grc_adf.idt_avaliacao_devolutiva = grc_ad.idt ";
    $sql .= " inner join grc_formulario_ferramenta_gestao    grc_ffg on grc_ffg.idt                      = grc_adf.idt_ferramenta ";
    $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_ffg.idt_area ";
    $sql .= " where grc_a.idt_atendimento = " . null($idt_atendimento_1);
    $sql .= " order by grc_adf.ordem ";
    $rs = execsql($sql);

    $vetArea = Array();

    foreach ($rs->data as $row) {
        $grc_fa_idt = $row['grc_fa_idt'];
        $grc_ffg_descricao = $row['grc_ffg_descricao'];
        $sql_i = "";
        $sql_i .= "insert into " . db_pir_grc . "grc_plano_facil_area ";
        $sql_i .= " ( ";
        $sql_i .= " idt_plano_facil,  ";
        $sql_i .= " idt_area  ";
        $sql_i .= " ) ";
        $sql_i .= " value ";
        $sql_i .= " ( ";
        $sql_i .= " $idt_plano_facil,  ";
        $sql_i .= " $grc_fa_idt  ";
        $sql_i .= " ) ";
        $result = execsql($sql_i);
        $idt_plano_facil_area = lastInsertId();
        $vetArea[$grc_fa_idt] = $idt_plano_facil_area;
    }

    //grc_plano_facil_ferramenta
    $sql = "select  ";
    $sql .= " grc_fa.idt as grc_fa_idt, grc_adf.idt_ferramenta  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
    $sql .= " inner join grc_avaliacao_devolutiva_ferramenta grc_adf on grc_adf.idt_avaliacao_devolutiva = grc_ad.idt ";
    $sql .= " inner join grc_formulario_ferramenta_gestao    grc_ffg on grc_ffg.idt                      = grc_adf.idt_ferramenta ";
    $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_ffg.idt_area ";
    $sql .= " where grc_a.idt_atendimento = " . null($idt_atendimento_1);
    $sql .= " order by grc_adf.ordem ";
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $sql_i = "";
        $sql_i .= "insert into " . db_pir_grc . "grc_plano_facil_ferramenta ";
        $sql_i .= " ( ";
        $sql_i .= " idt_plano_facil_area,  ";
        $sql_i .= " idt_ferramenta  ";
        $sql_i .= " ) ";
        $sql_i .= " value ";
        $sql_i .= " ( ";
        $sql_i .= null($vetArea[$row['grc_fa_idt']]) . ',';
        $sql_i .= null($row['idt_ferramenta']);
        $sql_i .= " ) ";
        execsql($sql_i);
    }

    // Cresce

    $sql = "select  ";
    $sql .= " grc_fa.idt          as grc_fa_idt,  ";
    $sql .= " grc_fa.descricao    as grc_fa_descricao,  ";
    $sql .= " grc_adra.percentual as grc_adra_percentual  ";
    $sql .= " from grc_avaliacao grc_a ";
    $sql .= " inner join grc_avaliacao_devolutiva                grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
    $sql .= " inner join grc_avaliacao_devolutiva_resultado_area grc_adra on grc_adra.idt_avaliacao_devolutiva = grc_ad.idt ";
    $sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt   = grc_adra.idt_area ";
    $sql .= " where grc_a.idt_atendimento = " . null($idt_atendimento_1);
    $sql .= " order by grc_fa.codigo ";
    $rs = execsql($sql);
    foreach ($rs->data as $row) {
        $idt_area = $row['grc_fa_idt'];
        $percentual = $row['grc_adra_percentual'];
        $sql_i = "";
        $sql_i .= "insert into " . db_pir_grc . "grc_plano_facil_cresce ";
        $sql_i .= " ( ";
        $sql_i .= " idt_plano_facil,  ";
        $sql_i .= " idt_area,  ";
        $sql_i .= " percentual  ";
        $sql_i .= " ) ";
        $sql_i .= " value ";
        $sql_i .= " ( ";
        $sql_i .= " $idt_plano_facil,  ";
        $sql_i .= " $idt_area,  ";
        $sql_i .= " $percentual  ";
        $sql_i .= " ) ";
        $result = execsql($sql_i);
        $idt_plano_facil_cresce = lastInsertId();
    }



    return $kokw;
}

/**
 * Verifica se tem as informações a avaliação informada, se não tiver pega do atendimento
 * @access public
 * @param idt $idt_avaliacao <p>
 * IDT da Avaliação
 * </p>
 * @param string $empresa_nan <p>
 * Empresa NAN
 * </p>
 * @param string $aoe_nan <p>
 * AOE NAN
 * </p>
 * @param string $empresa_atendida <p>
 * Empresa do Atendimento NAN
 * </p>
 * @param string $pessoa_atendida <p>
 * Pessoa do Atendimento NAN
 * </p>
 * */
function verificaInfAvaliacaoNAN($idt_avaliacao, &$empresa_nan, &$aoe_nan, &$empresa_atendida, &$pessoa_atendida) {
    $sql = '';
    $sql .= ' select emp_nan.nome_completo as empresa_nan_nome, aoe_nan.nome_completo as aoe_nan_nome,';
    $sql .= ' emp_ate.razao_social as empresa_atendida_nome, pes_ate.nome as pessoa_atendida_nome';
    $sql .= ' from grc_avaliacao grc_a';
    $sql .= ' inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento';
    $sql .= ' left outer join plu_usuario emp_nan on emp_nan.id_usuario = grc_at.idt_nan_empresa';
    $sql .= ' left outer join plu_usuario aoe_nan on aoe_nan.id_usuario = grc_at.idt_consultor';
    $sql .= " left outer join grc_atendimento_organizacao emp_ate on emp_ate.idt_atendimento = grc_at.idt and emp_ate.representa = 'S' and emp_ate.desvincular = 'N'";
    $sql .= " left outer join grc_atendimento_pessoa pes_ate on pes_ate.idt_atendimento = grc_at.idt and pes_ate.tipo_relacao = 'L'";
    $sql .= ' where grc_a.idt = ' . null($idt_avaliacao);
    $rs = execsql($sql);
    $row = $rs->data[0];

    if ($empresa_nan == '') {
        $empresa_nan = $row['empresa_nan_nome'];
    }

    if ($aoe_nan == '') {
        $aoe_nan = $row['aoe_nan_nome'];
    }

    if ($empresa_atendida == '') {
        $empresa_atendida = $row['empresa_atendida_nome'];
    }

    if ($pessoa_atendida == '') {
        $pessoa_atendida = $row['pessoa_atendida_nome'];
    }
}

function grc_entidade_ajuste_updateCodSiacweb($antigo, $novo) {
    //Cache
    $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente set codempreedimento = ' . null($novo) . ' where codempreedimento = ' . null($antigo);
    execsql($sql, false);

    $sql = 'update ' . db_pir_siac . 'historicorealizacoescliente_anosanteriores set codempreedimento = ' . null($novo) . ' where codempreedimento = ' . null($antigo);
    execsql($sql, false);

    //GEC
    $sql = 'update ' . db_pir_gec . 'gec_entidade set codigo_siacweb = ' . null($novo) . ' where codigo_siacweb = ' . aspa($antigo);
    execsql($sql, false);

    //GRC
    $sql = 'update ' . db_pir_grc . 'grc_atendimento_organizacao set codigo_siacweb_e = ' . null($novo) . ' where codigo_siacweb_e = ' . aspa($antigo);
    execsql($sql, false);

    $sql = 'update ' . db_pir_grc . 'grc_entidade_organizacao set codigo_siacweb_e = ' . null($novo) . ' where codigo_siacweb_e = ' . aspa($antigo);
    execsql($sql, false);

    //Cache
    $sql = 'delete from ' . db_pir_siac . 'comunicacao where codparceiro = ' . null($antigo);
    execsql($sql, false);

    $sql = 'delete from ' . db_pir_siac . 'endereco where codparceiro = ' . null($antigo);
    execsql($sql, false);

    $sql = 'delete from ' . db_pir_siac . 'ativeconpj where codparceiro = ' . null($antigo);
    execsql($sql, false);

    $sql = 'delete from ' . db_pir_siac . 'contato where codcontatopj = ' . null($antigo);
    execsql($sql, false);

    $sql = 'delete from ' . db_pir_siac . 'pessoaj where codparceiro = ' . null($antigo);
    execsql($sql, false);

    $sql = 'delete from ' . db_pir_siac . 'parceiro where codparceiro = ' . null($antigo);
    execsql($sql, false);

    grava_log_sis('grc_entidade_ajuste', 'R', $tipoparceiro, 'de ' . $antigo . ' para ' . $novo, 'Troca do código do SiacWeb', '', array(), false);
}

function remover_acento($string) {
    $string = preg_replace("/[ÁÀÂÃÄáàâãä]/", "a", $string);
    $string = preg_replace("/[ÉÈÊéèê]/", "e", $string);
    $string = preg_replace("/[ÍÌíì]/", "i", $string);
    $string = preg_replace("/[ÓÒÔÕÖóòôõö]/", "o", $string);
    $string = preg_replace("/[ÚÙÜúùü]/", "u", $string);
    $string = preg_replace("/Çç/", "c", $string);
    $string = mb_strtolower($string);
    return $string;
}

/**
 * Deside para quem vai mandar a aprovação inicial do evento
 * @access public
 * @return idt_evento_situacao
 * @param int $idt_instrumento <p>
 * IDT do Atendimento Insrtrumento
 * </p>
 * @param int $idt_programa <p>
 * IDT do Programa Credenciado (GEC)
 * </p>
 * @param string $dt_ini_evento <p>
 * Data de Inicio do Evento
 * </p>
 * @param int $idt_gestor_projeto <p>
 * IDT do Usuario do Gestor do Projeto
 * </p>
 * @param int $idt_responsavel <p>
 * IDT do Usuario do Cadastrante
 * </p>
 * @param int $idt_unidade <p>
 * IDT da Unidade
 * </p>
 * @param int $idt_ponto_atendimento <p>
 * IDT do PA
 * </p>
 * @param string $classificacao_unidade <p>
 * Classificação da Unidade
 * </p>
 * @param decimal $previsao_despesa <p>
 * Valor da Previsão de Despesa
 * </p>
 * @param dbx $rs_pendencia <p>
 * Devolve os usuarios que vão receber a pendencia do evento
 * </p>
 * @param boolean $temCG <p>
 * Tem pelo menos um usuario Coordenador / Gerente neste Evento?
 * </p>
 * @param boolean $temDI <p>
 * Tem pelo menos um usuario Diretor neste Evento?
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function decideAprovadorInicialEvento($idt_instrumento, $idt_programa, $dt_ini_evento, $idt_gestor_projeto, $idt_responsavel, $idt_unidade, $idt_ponto_atendimento, $classificacao_unidade, $previsao_despesa, &$rs_pendencia, &$temCG, &$temDI, $trata_erro = true) {
    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_gestor_projeto);
    $rsGP = execsql($sql, $trata_erro);

    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_responsavel);
    $rsCA = execsql($sql, $trata_erro);

    $idtSecaoPA = $idt_ponto_atendimento;
    $idtSecaoUN = $idt_unidade;

    //Diretoria
    $vetCod = explode('.', $classificacao_unidade);
    $vetCod[1] = '00';

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
    $rs = execsql($sql, $trata_erro);
    $idtSecaoDI = $rs->data[0][0];

    //Coordenador / Gerente
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
    $sql .= " where f.tipo_alcada_evento = 'CG'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $sql .= ' and ea.vl_alcada >= ' . null($previsao_despesa);
    $rsCG = execsql($sql, $trata_erro);

    if ($rsCG->rows == 0) {
        $sql = '';
        $sql .= ' select max(ea.vl_alcada) as max';
        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= " where f.tipo_alcada_evento = 'CG'";
        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
        $sql .= " and p.ativo = 'S'";
        $rsCG = execsql($sql, $trata_erro);
        $max = $rsCG->data[0][0];

        if ($max === '' || is_null($max)) {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, null as vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $rsCG = execsql($sql, $trata_erro);
        } else {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $sql .= ' and ea.vl_alcada = ' . null($max);
            $rsCG = execsql($sql, $trata_erro);
        }
    }

    $temCG = $rsCG->rows > 0;

    $vetCG = Array();
    foreach ($rsCG->data as $row) {
        $vetCG[$row['id_usuario']] = $row['id_usuario'];
    }

    //Diretor
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= " where f.tipo_alcada_evento = 'DI'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $rsDI = execsql($sql, $trata_erro);

    $temDI = $rsDI->rows > 0;

    $vetDI = Array();
    foreach ($rsDI->data as $row) {
        $vetDI[$row['id_usuario']] = $row['id_usuario'];
    }

    //É Diretor?
    if (in_array($idt_responsavel, $vetDI)) {
        $rs_pendencia = $rsCA;
        return 14; //AGENDADO
    }

    //É Coordenador / Gerente?
    if (in_array($idt_responsavel, $vetCG)) {
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_prazo_insumo ea';
        $sql .= ' where ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= ' and ea.idt_programa = ' . null($idt_programa);
        $rsEA = execsql($sql);
        $rowEA = $rsEA->data[0];

        $prazo = 0;
        $vl_alcada = 0;

        if ($rowEA['prazo_insumo'] != '') {
            if ($rowEA['prazo_insumo'] > $prazo) {
                $prazo = $rowEA['prazo_insumo'];
            }
        }

        if ($rowEA['prazo_credenciado'] != '') {
            if ($rowEA['prazo_credenciado'] > $prazo) {
                $prazo = $rowEA['prazo_credenciado'];
            }
        }

        $limite = date('d/m/Y', strtotime('-' . $prazo . ' days', strtotime($dt_ini_evento)));
        $diff = diffDate(date("d/m/Y"), $limite);

        if ($diff > 0) {
            $sql = '';
            $sql .= ' select ea.vl_alcada';
            $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = op.cod_usuario';
            $sql .= ' where ea.idt_instrumento = ' . null($idt_instrumento);
            $sql .= ' and u.id_usuario = ' . null($idt_responsavel);
            $rsEA = execsql($sql);
            $vl_alcada = $rsEA->data[0][0];

            if ($vl_alcada == '') {
                $vl_alcada = 0;
            }
        }

        if ($previsao_despesa > $vl_alcada) {
            $rs_pendencia = $rsDI;
            return 7; //Aguardando a aprovação do Diretor
        } else {
            $rs_pendencia = $rsCA;
            return 14; //AGENDADO
        }
    }

    //É Gestor do Projeto?
    if ($idt_gestor_projeto == $idt_responsavel) {
        $rs_pendencia = $rsCG;
        return 3; //Aguardando aprovação do Coordenador/Gerente
    }

    $rs_pendencia = $rsGP;
    return 2; //Aguardando aprovação do Gestor do Projeto
}

/**
 * Deside para quem vai mandar a aprovação inicial do evento
 * @access public
 * @return idt_evento_situacao
 * @param int $idt_instrumento <p>
 * IDT do Atendimento Insrtrumento
 * </p>
 * @param int $idt_gestor_projeto <p>
 * IDT do Usuario do Gestor do Projeto
 * </p>
 * @param int $idt_responsavel <p>
 * IDT do Usuario do Cadastrante
 * </p>
 * @param int $idt_unidade <p>
 * IDT da Unidade
 * </p>
 * @param int $idt_ponto_atendimento <p>
 * IDT do PA
 * </p>
 * @param string $classificacao_unidade <p>
 * Classificação da Unidade
 * </p>
 * @param decimal $previsao_despesa <p>
 * Valor da Previsão de Despesa
 * </p>
 * @param dbx $rs_pendencia <p>
 * Devolve os usuarios que vão receber a pendencia do evento
 * </p>
 * @param boolean $temCG <p>
 * Tem pelo menos um usuario Coordenador / Gerente neste Evento?
 * </p>
 * @param boolean $temDI <p>
 * Tem pelo menos um usuario Diretor neste Evento?
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function decideAprovadorInicialEventoPublicacao($idt_instrumento, $idt_gestor_projeto, $idt_responsavel, $idt_unidade, $idt_ponto_atendimento, $classificacao_unidade, $previsao_despesa, &$rs_pendencia, &$temCG, &$temDI, $trata_erro = true) {
    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_gestor_projeto);
    $rsGP = execsql($sql, $trata_erro);

    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_responsavel);
    $rsCA = execsql($sql, $trata_erro);

    $idtSecaoPA = $idt_ponto_atendimento;
    $idtSecaoUN = $idt_unidade;

    //Diretoria
    $vetCod = explode('.', $classificacao_unidade);
    $vetCod[1] = '00';

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
    $rs = execsql($sql, $trata_erro);
    $idtSecaoDI = $rs->data[0][0];

    //Coordenador / Gerente
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
    $sql .= " where f.tipo_alcada_evento = 'CG'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $sql .= ' and ea.vl_alcada >= ' . null($previsao_despesa);
    $rsCG = execsql($sql, $trata_erro);

    if ($rsCG->rows == 0) {
        $sql = '';
        $sql .= ' select max(ea.vl_alcada) as max';
        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= " where f.tipo_alcada_evento = 'CG'";
        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
        $sql .= " and p.ativo = 'S'";
        $rsCG = execsql($sql, $trata_erro);
        $max = $rsCG->data[0][0];

        if ($max === '' || is_null($max)) {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, null as vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $rsCG = execsql($sql, $trata_erro);
        } else {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $sql .= ' and ea.vl_alcada = ' . null($max);
            $rsCG = execsql($sql, $trata_erro);
        }
    }

    $temCG = $rsCG->rows > 0;

    $vetCG = Array();
    foreach ($rsCG->data as $row) {
        $vetCG[$row['id_usuario']] = $row['id_usuario'];
    }

    //Diretor
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= " where f.tipo_alcada_evento = 'DI'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $rsDI = execsql($sql, $trata_erro);

    $temDI = $rsDI->rows > 0;

    $vetDI = Array();
    foreach ($rsDI->data as $row) {
        $vetDI[$row['id_usuario']] = $row['id_usuario'];
    }

    //É Diretor?
    if (in_array($idt_responsavel, $vetDI)) {
        $rs_pendencia = $rsCA;
        return 'AP';
    }

    //É Coordenador / Gerente?
    if (in_array($idt_responsavel, $vetCG)) {
        $sql = '';
        $sql .= ' select ea.vl_alcada';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = op.cod_usuario';
        $sql .= ' where ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= ' and u.id_usuario = ' . null($idt_responsavel);
        $rsEA = execsql($sql);
        $vl_alcada = $rsEA->data[0][0];

        if ($vl_alcada == '') {
            $vl_alcada = 0;
        }

        if ($previsao_despesa > $vl_alcada) {
            $rs_pendencia = $rsDI;
            return 'DI';
        } else {
            $rs_pendencia = $rsCA;
            return 'AP';
        }
    }

    //É Gestor do Projeto?
    if ($idt_gestor_projeto == $idt_responsavel) {
        $rs_pendencia = $rsCG;
        return 'CG';
    }

    $rs_pendencia = $rsGP;
    return 'GP';
}

function RegistrarLogAgendamento($vetPar) {
    $tipov = $vetPar['tipo'];
    $idt_atendimento_agendav = $vetPar['idt_atendimento_agenda'];
    $textov = $vetPar['texto'];
    $sql = "select  ";
    $sql .= " grc_aa.*  ";
    $sql .= " from " . db_pir_grc . "grc_atendimento_agenda grc_aa ";
    $sql .= " where idt = {$idt_atendimento_agendav} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $dataw = date('d/m/Y H:i:s');
        $data_log = trata_data($dataw);
        $idt_responsavel = null($_SESSION[CS]['g_id_usuario']);
        $idt_atendimento_agenda = null($idt_atendimento_agendav);
        $dataregistro = aspa($data_log);

        $tipo = aspa($tipov);
        $texto = aspa($textov);
        //
        $observacao = aspa($row['observacao_desmarcacao']);
        $protocolo = aspa($row['protocolo']);
        $neutro = $vetPar['neutro'];
        if ($neutro == "") {
            $neutro = "N";
        }
        $neutro = aspa($neutro);
        $situacao = aspa($row['situacao']);
        $idt_tipo_deficiencia = null($row['idt_tipo_deficiencia']);
        $idt_especialidade = null($row['idt_especialidade']);
        $necessidade_especial = aspa($row['necessidade_especial']);
        $detalhe = aspa($row['detalhe']);
        $idt_cliente = null($row['idt_cliente']);
        $idt_consultor = null($row['idt_consultor']);
        $cpf = aspa($row['cpf']);
        $cliente_texto = aspa($row['cliente_texto']);
        $cnpj = aspa($row['cnpj']);
        $nome_empresa = aspa($row['nome_empresa']);
        $telefone = aspa($row['telefone']);
        $celular = aspa($row['celular']);
        $email = aspa($row['email']);
        $assunto = aspa($row['assunto']);
        $observacao_desmarcacao = aspa($row['observacao_desmarcacao']);

        $semmarcacao = aspa($row['semmarcacao']);
        $marcador = aspa($row['marcador']);
        $idt_marcador = null($row['idt_marcador']);
        $data_hora_marcacao_inicial = aspa($row['data_hora_marcacao_inicial']);
        //
        $sql_i = "";
        $sql_i .= "insert into " . db_pir_grc . "grc_atendimento_agenda_log ";
        $sql_i .= " ( ";
        $sql_i .= " idt_responsavel,  ";
        $sql_i .= " idt_atendimento_agenda,  ";
        $sql_i .= " dataregistro,  ";
        $sql_i .= " tipo,  ";
        $sql_i .= " texto,  ";
        $sql_i .= " protocolo,  ";
        $sql_i .= " situacao,  ";
        $sql_i .= " idt_tipo_deficiencia,  ";
        $sql_i .= " necessidade_especial,  ";
        $sql_i .= " detalhe,  ";
        $sql_i .= " idt_cliente,  ";
        $sql_i .= " cpf,  ";
        $sql_i .= " cliente_texto,  ";
        $sql_i .= " neutro,  ";
        $sql_i .= " cnpj,  ";
        $sql_i .= " nome_empresa,  ";
        $sql_i .= " telefone,  ";
        $sql_i .= " celular,  ";
        $sql_i .= " email,  ";
        $sql_i .= " assunto,  ";
        $sql_i .= " semmarcacao,  ";
        $sql_i .= " observacao_desmarcacao,  ";
        $sql_i .= " marcador,  ";
        $sql_i .= " idt_marcador,  ";
        $sql_i .= " idt_especialidade,  ";
        $sql_i .= " idt_consultor,  ";
        $sql_i .= " observacao,  ";

        $sql_i .= " data_hora_marcacao_inicial  ";
        $sql_i .= " ) ";
        $sql_i .= " value ";
        $sql_i .= " ( ";
        $sql_i .= " $idt_responsavel,  ";
        $sql_i .= " $idt_atendimento_agenda,  ";
        $sql_i .= " $dataregistro,  ";
        $sql_i .= " $tipo,  ";
        $sql_i .= " $texto,  ";
        $sql_i .= " $protocolo,  ";
        $sql_i .= " $situacao,  ";
        $sql_i .= " $idt_tipo_deficiencia,  ";
        $sql_i .= " $necessidade_especial,  ";
        $sql_i .= " $detalhe,  ";
        $sql_i .= " $idt_cliente,  ";
        $sql_i .= " $cpf,  ";
        $sql_i .= " $cliente_texto,  ";
        $sql_i .= " $neutro,  ";
        $sql_i .= " $cnpj,  ";
        $sql_i .= " $nome_empresa,  ";
        $sql_i .= " $telefone,  ";
        $sql_i .= " $celular,  ";
        $sql_i .= " $email,  ";
        $sql_i .= " $assunto,  ";
        $sql_i .= " $semmarcacao,  ";
        $sql_i .= " $observacao_desmarcacao,  ";
        $sql_i .= " $marcador,  ";
        $sql_i .= " $idt_marcador,  ";
        $sql_i .= " $idt_especialidade,  ";
        $sql_i .= " $idt_consultor,  ";
        $sql_i .= " $observacao,  ";
        $sql_i .= " $data_hora_marcacao_inicial  ";
        $sql_i .= " ) ";
        $result = execsql($sql_i);
        $idt_atendimento_agenda_log = lastInsertId();
    }
}

/**
 * Cria a estrutura do evento composto
 * @access public
 * @param int $idt_evento_pai <p>
 * IDT do Evento Pai
 * </p>
 * @param boolean $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function EventoCompostoCria($idt_evento_pai, $trata_erro) {
    $sql = 'update grc_evento set ';
    $sql .= ' idt_instrumento_org  = idt_instrumento';
    $sql .= ' where idt = ' . null($idt_evento_pai);
    execsql($sql, $trata_erro);


    $sql = "update grc_evento set idt_instrumento = 52, composto = 'S' where idt = " . null($idt_evento_pai);
    execsql($sql, $trata_erro);

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from grc_evento';
    $sql .= ' where idt = ' . null($idt_evento_pai);
    $rs = execsql($sql, $trata_erro);
    $rowPai = $rs->data[0];

    $sql = '';
    $sql .= ' select p.idt, p.idt_foco_tematico, p.titulo_comercial, p.descricao, p.frequencia_siac, p.idt_instrumento, p.idt_programa, gec_prog.tipo_ordem';
    $sql .= ' from grc_produto_produto pp';
    $sql .= " inner join grc_produto p on p.idt = pp.idt_produto_associado ";
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = p.idt_programa';
    $sql .= ' where pp.idt_produto = ' . null($rowPai['idt_produto']);
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        if ($row['idt_instrumento'] == 39) {
            $row['idt_instrumento'] = 2;
        }

        $idt_evento = GravarEvento($row['idt_instrumento']);

        if ($row['titulo_comercial'] == '' || $row['tipo_ordem'] == 'SG') {
            $descricao = $row['descricao'];
        } else {
            $descricao = $row['titulo_comercial'];
        }

        $sql = 'update grc_evento set ';
        $sql .= ' idt_evento_pai  = ' . null($idt_evento_pai) . ',';
        $sql .= ' idt_produto  = ' . null($row['idt']) . ',';
        $sql .= ' idt_foco_tematico  = ' . null($row['idt_foco_tematico']) . ',';
        $sql .= ' descricao  = ' . aspa($descricao) . ',  ';
        $sql .= ' frequencia_min  = ' . null($row['frequencia_siac']) . ',  ';
        $sql .= " temporario  = 'N',";
        $sql .= ' idt_programa  = ' . null($row['idt_programa']);
        $sql .= ' where idt = ' . null($idt_evento);
        execsql($sql, $trata_erro);
    }

    EventoCompostoSincroniza($idt_evento_pai, $trata_erro);
}

/**
 * Sincroniza a estrutura do evento composto
 * @access public
 * @param int $idt_evento_pai <p>
 * IDT do Evento Pai
 * </p>
 * @param boolean $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function EventoCompostoSincroniza($idt_evento_pai, $trata_erro) {
    $sql = '';
    $sql .= ' select idt_evento_pai, composto';
    $sql .= ' from grc_evento';
    $sql .= ' where idt = ' . null($idt_evento_pai);
    $rsa = execsql($sql, $trata_erro);
    $rowa = $rsa->data[0];

    $ok = false;

    if ($rowa['idt_evento_pai'] == '' && $rowa['composto'] == 'S') {
        $ok = true;
    }

    if ($rowa['idt_evento_pai'] != '') {
        $idt_evento_pai = $rowa['idt_evento_pai'];
        $ok = true;
    }

    if ($ok) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento';
        $sql .= ' where idt_evento_pai = ' . null($idt_evento_pai);
        $rs = execsql($sql, $trata_erro);

        $idtFilho = Array();
        $idtFilho[] = 0;

        foreach ($rs->data as $row) {
            $idtFilho[] = $row['idt'];
            ajustaTotaisEvento($row['idt'], $trata_erro);
            SincronizaHoraMesEventoComposto($row['idt'], $trata_erro);
        }

        $idtFilho = implode(', ', $idtFilho);

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($idt_evento_pai);
        $rs = execsql($sql, $trata_erro);
        $rowPai = $rs->data[0];

        //Filho igual ao Pai
        $sql = 'update grc_evento set ';
        $sql .= ' idt_evento_situacao  = ' . null($rowPai['idt_evento_situacao']) . ',';
        $sql .= ' idt_evento_situacao_ant  = ' . null($rowPai['idt_evento_situacao_ant']) . ',';
        $sql .= ' envio_opcao  = ' . aspa($rowPai['envio_opcao']) . ',';
        $sql .= ' envio_num_rastreio  = ' . aspa($rowPai['envio_num_rastreio']) . ',';
        $sql .= ' envio_resp_retirada  = ' . aspa($rowPai['envio_resp_retirada']) . ',';
        $sql .= ' envio_obs  = ' . aspa($rowPai['envio_obs']) . ',';
        $sql .= ' envio_sts_entrega  = ' . aspa($rowPai['envio_sts_entrega']) . ',';
        $sql .= ' motivo_cancelamento  = ' . aspa($rowPai['motivo_cancelamento']) . ',';
        $sql .= ' parecer_cancelamento  = ' . aspa($rowPai['parecer_cancelamento']) . ',';
        $sql .= ' idt_evento_situacao_can  = ' . null($rowPai['idt_evento_situacao_can']) . ',';
        $sql .= ' idt_evento_motivo_cancelamento  = ' . null($rowPai['idt_evento_motivo_cancelamento']) . ',';
        $sql .= ' dt_inicio_aprovacao  = ' . aspa($rowPai['dt_inicio_aprovacao']) . ',';
        $sql .= ' sincroniza_loja  = ' . aspa($rowPai['sincroniza_loja']) . ',';
        $sql .= ' idt_ponto_atendimento  = ' . null($rowPai['idt_ponto_atendimento']) . ',';
        $sql .= ' idt_gestor_projeto  = ' . null($rowPai['idt_gestor_projeto']) . ',  ';
        $sql .= ' idt_projeto  = ' . null($rowPai['idt_projeto']) . ',';
        $sql .= ' idt_acao  = ' . null($rowPai['idt_acao']) . ',';
        $sql .= ' ano_competencia  = ' . aspa($rowPai['ano_competencia']) . ',  ';
        $sql .= ' gestor_sge  = ' . aspa($rowPai['gestor_sge']) . ',';
        $sql .= ' fase_acao_projeto  = ' . aspa($rowPai['fase_acao_projeto']) . ',';
        $sql .= ' orc_previsto  = ' . null($rowPai['orc_previsto']) . ',';
        $sql .= ' orc_realizado  = ' . null($rowPai['orc_realizado']) . ',';
        $sql .= ' orc_percentual  = ' . null($rowPai['orc_percentual']) . ',';
        $sql .= ' orc_saldo  = ' . null($rowPai['orc_saldo']) . ',';
        $sql .= ' idt_unidade  = ' . null($rowPai['idt_unidade']) . ',';
        $sql .= ' idt_ponto_atendimento_tela  = ' . null($rowPai['idt_ponto_atendimento_tela']) . ',';
        $sql .= ' idt_gestor_evento  = ' . null($rowPai['idt_gestor_evento']) . ',';
        $sql .= ' idt_publico_alvo  = ' . null($rowPai['idt_publico_alvo']) . ',';
        $sql .= ' maturidade  = ' . aspa($rowPai['maturidade']) . ',  ';

        //$sql .= ' observacao  = '.aspa($rowPai['observacao']).',';
        //$sql .= ' total_receita  = '.null($rowPai['total_receita']).',';
        //$sql .= ' total_despesa  = '.null($rowPai['total_despesa']).',';
        //$sql .= ' participante_minimo  = '.null($rowPai['participante_minimo']).',';
        //$sql .= ' participante_maximo  = '.null($rowPai['participante_maximo']).',';
        //$sql .= ' quantidade_participante  = '.null($rowPai['quantidade_participante']).',';
        //$sql .= ' qtd_vagas_adicional  = '.null($rowPai['qtd_vagas_adicional']).',';
        //$sql .= ' frequencia_min  = '.null($rowPai['frequencia_min']).',  ';
        //$sql .= ' valor_inscricao  = '.null($rowPai['valor_inscricao']).',';
        //$sql .= ' qtd_minima_pagantes  = '.null($rowPai['qtd_minima_pagantes']).',';

        $sql .= ' cred_necessita_credenciado  = ' . aspa($rowPai['cred_necessita_credenciado']) . ',';
        $sql .= ' cred_rodizio_auto  = ' . aspa($rowPai['cred_rodizio_auto']) . ',';
        $sql .= ' cred_credenciado_sgc  = ' . aspa($rowPai['cred_credenciado_sgc']) . ',';
        $sql .= ' cred_escolhido_cnpj_cpf  = ' . aspa($rowPai['cred_escolhido_cnpj_cpf']) . ',';
        $sql .= ' cred_escolhido_nome  = ' . aspa($rowPai['cred_escolhido_nome']) . ',';
        $sql .= ' cred_escolhido_telefone  = ' . aspa($rowPai['cred_escolhido_telefone']) . ',';
        $sql .= ' cred_escolhido_email  = ' . aspa($rowPai['cred_escolhido_email']) . ',';
        $sql .= ' cred_escolhido_justificativa  = ' . aspa($rowPai['cred_escolhido_justificativa']) . ',';
        $sql .= ' cred_contratacao_cont  = ' . aspa($rowPai['cred_contratacao_cont']) . ',';
        $sql .= ' cred_idt_evento  = ' . aspa($rowPai['cred_idt_evento']) . ',';
        $sql .= ' cred_cod_evento  = ' . aspa($rowPai['cred_cod_evento']) . ',';
        $sql .= ' cred_contratacao_cont_obs  = ' . aspa($rowPai['cred_contratacao_cont_obs']) . ',';

        $sql .= ' evento_aberto  = ' . aspa($rowPai['evento_aberto']) . ',';
        $sql .= ' gratuito  = ' . aspa($rowPai['gratuito']) . ',';
        $sql .= ' publica_internet  = ' . aspa($rowPai['publica_internet']) . ',';
        $sql .= ' publique_imediatamente  = ' . aspa($rowPai['publique_imediatamente']) . ',';
        $sql .= ' obrigar_pesq_certificado  = ' . aspa($rowPai['obrigar_pesq_certificado']) . ',';
        $sql .= ' comercializar  = ' . aspa($rowPai['comercializar']);
        $sql .= ' where idt_evento_pai = ' . null($idt_evento_pai);
        execsql($sql, $trata_erro);

        //Pai com dados dos filhos
        $rowFilho = Array();

        $sql = '';
        $sql .= ' select min(ea.data_inicial) as dt_ini, max(ea.data_final) as dt_fim, min(ea.hora_inicial) as hr_ini, max(ea.hora_final) as hr_fim,';
        $sql .= ' sum(ea.carga_horaria) as carga_horaria, sum(ea.valor_hora * ea.carga_horaria) as custo, count(distinct ea.data_inicial) as qtd_dias_reservados';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento in (' . $idtFilho . ')';
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rs = execsql($sql, $trata_erro);
        $row = $rs->data[0];

        $rowFilho['dt_previsao_inicial'] = $row['dt_ini'];
        $rowFilho['dt_previsao_fim'] = $row['dt_fim'];
        $rowFilho['hora_inicio'] = $row['hr_ini'];
        $rowFilho['hora_fim'] = $row['hr_fim'];
        $rowFilho['tot_hora_consultoria'] = $row['carga_horaria'];
        $rowFilho['custo_tot_consultoria'] = $row['custo'];
        $rowFilho['qtd_dias_reservados'] = $row['qtd_dias_reservados'];

        $sql = '';
        $sql .= ' select sum(carga_horaria_total) as tot';
        $sql .= ' from grc_evento';
        $sql .= ' where idt_evento_pai = ' . null($idt_evento_pai);
        $rsa = execsql($sql, $trata_erro);
        $rowFilho['carga_horaria_total'] = $rsa->data[0][0];

        $sql = '';
        $sql .= ' select ea.idt_cidade, ea.idt_local';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento in (' . $idtFilho . ')';
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' order by ea.dt_ini limit 1';
        $rs = execsql($sql, $trata_erro);
        $row = $rs->data[0];

        $rowFilho['idt_cidade'] = $row['idt_cidade'];
        $rowFilho['idt_local'] = $row['idt_local'];

        $sql = 'update grc_evento set ';
        $sql .= ' dt_previsao_inicial  = ' . aspa($rowFilho['dt_previsao_inicial']) . ',';
        $sql .= ' dt_previsao_fim  = ' . aspa($rowFilho['dt_previsao_fim']) . ',';
        $sql .= ' hora_inicio  = ' . aspa($rowFilho['hora_inicio']) . ',';
        $sql .= ' hora_fim  = ' . aspa($rowFilho['hora_fim']) . ',';
        $sql .= ' carga_horaria_total  = ' . null($rowFilho['carga_horaria_total']) . ',';
        $sql .= ' tot_hora_consultoria  = ' . null($rowFilho['tot_hora_consultoria']) . ',';
        $sql .= ' custo_tot_consultoria  = ' . null($rowFilho['custo_tot_consultoria']) . ',';
        $sql .= ' qtd_dias_reservados  = ' . null($rowFilho['qtd_dias_reservados']) . ',';
        $sql .= ' idt_cidade = ' . null($rowFilho['idt_cidade']) . ',';
        $sql .= ' idt_local = ' . null($rowFilho['idt_local']);
        $sql .= ' where idt = ' . null($idt_evento_pai);
        execsql($sql, $trata_erro);
    }
}

/**
 * Deleta a estrutura do evento composto
 * @access public
 * @param int $idt_evento_pai <p>
 * IDT do Evento Pai
 * </p>
 * @param boolean $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function EventoCompostoDeleta($idt_evento_pai, $trata_erro) {
    $sql = 'update grc_evento set ';
    $sql .= " composto = 'N',";
    $sql .= ' idt_instrumento  = idt_instrumento_org';
    $sql .= ' where idt = ' . null($idt_evento_pai);
    execsql($sql, $trata_erro);

    $sql = 'select idt from grc_evento';
    $sql .= ' where idt_evento_pai = ' . null($idt_evento_pai);
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        ExcluiEventoAcao($row['idt'], $trata_erro);
    }
}

/**
 * Checa se o evento tem o registro de cred_necessita_credenciado criado
 * @access public
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * */
function checa_cred_necessita_credenciado($idt_evento) {
    $idtFilho = Array();
    $idtFilho[] = $idt_evento;

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento';
    $sql .= ' where idt_evento_pai = ' . null($idt_evento);
    $rs = execsql($sql);


    foreach ($rs->data as $row) {
        $idtFilho[] = $row['idt'];
    }

    $idtFilho = implode(', ', $idtFilho);

    $sql = '';
    $sql .= ' select idt, cred_necessita_credenciado, idt_produto, idt_instrumento, tipo_sincroniza_siacweb';
    $sql .= ' from grc_evento';
    $sql .= ' where idt in (' . $idtFilho . ')';
    $rse = execsql($sql);

    foreach ($rse->data as $rowe) {
        if ($rowe['cred_necessita_credenciado'] == 'S') {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_insumo';
            $sql .= ' where idt_evento = ' . null($rowe['idt']);
            $sql .= ' and idt_profissional is not null';
            $rst = execsql($sql);

            if ($rst->rows == 0) {
                $valor_hora = 0;

                $sql = "select grc_pi.*, pr.idt_profissional from grc_produto_insumo grc_pi ";
                $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = grc_pi.idt_insumo ";
                $sql .= ' inner join grc_produto_profissional pr on pr.idt = grc_pi.idt_produto_profissional';
                $sql .= " where grc_pi.idt_produto  = " . null($rowe['idt_produto']);
                $sql .= " and grc_pp.sinal = " . aspa('S'); // despesa
                $sql .= " and grc_pi.ativo = " . aspa('S'); // ativo
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    SincronizaProfissionalEvento($rowe['idt']);

                    $sql = '';
                    $sql .= ' select sum(custo_unitario_real) as tot';
                    $sql .= ' from grc_evento_insumo';
                    $sql .= ' where idt_evento = ' . null($rowe['idt']);
                    $sql .= " and codigo = '70001'";
                    $rsa = execsql($sql);
                    $valor_hora += $rsa->data[0][0];
                } else {
                    ForEach ($rs->data as $row) {
                        $idt_insumo = null($row['idt_insumo']);
                        $idt_area_suporte = null($row['idt_area_suporte']);
                        $idt_profissional = null($row['idt_profissional']);
                        $codigo = aspa($row['codigo']);
                        $descricao = aspa($row['descricao']);
                        $ativo = aspa($row['ativo']);
                        $detalhe = aspa($row['detalhe']);
                        $quantidade = null($row['quantidade']);
                        $qtd_automatico = aspa('S');
                        $custo_unitario_real = null($row['custo_unitario_real']);
                        $idt_insumo_unidade = null($row['idt_insumo_unidade']);
                        $por_participante = aspa($row['por_participante']);
                        $custo_total = null($row['custo_total']);
                        $ctotal_minimo = null($row['ctotal_minimo']);
                        $ctotal_maximo = null($row['ctotal_maximo']);
                        $rtotal_minimo = null($row['rtotal_minimo']);
                        $rtotal_maximo = null($row['rtotal_maximo']);
                        $receita_total = null($row['receita_total']);

                        if ($row['codigo'] == '70001') {
                            $valor_hora += $row['custo_unitario_real'];

                            if ($rowe['tipo_sincroniza_siacweb'] == 'VF' && ($rowe['idt_instrumento'] == 46 || $rowe['idt_instrumento'] == 47)) {
                                $qtd_automatico = aspa('N');
                                $quantidade = 1;
                            }
                        }

                        $sql_i = " insert into grc_evento_insumo ";
                        $sql_i .= " (  ";
                        $sql_i .= " qtd_automatico, ";
                        $sql_i .= " idt_evento, ";
                        $sql_i .= " idt_area_suporte, ";
                        $sql_i .= " idt_profissional, ";
                        $sql_i .= " idt_insumo, ";
                        $sql_i .= " codigo, ";
                        $sql_i .= " descricao, ";
                        $sql_i .= " detalhe, ";
                        $sql_i .= " ativo, ";
                        $sql_i .= " quantidade, ";
                        $sql_i .= " quantidade_evento, ";
                        $sql_i .= " custo_unitario_real, ";
                        $sql_i .= " idt_insumo_unidade, ";
                        $sql_i .= " por_participante ";
                        $sql_i .= "  ) values ( ";
                        $sql_i .= " $qtd_automatico, ";
                        $sql_i .= null($rowe['idt']) . ", ";
                        $sql_i .= " $idt_area_suporte, ";
                        $sql_i .= " $idt_profissional, ";
                        $sql_i .= " $idt_insumo, ";
                        $sql_i .= " $codigo, ";
                        $sql_i .= " $descricao, ";
                        $sql_i .= " $detalhe, ";
                        $sql_i .= " $ativo, ";
                        $sql_i .= " $quantidade, ";
                        $sql_i .= " $quantidade, ";
                        $sql_i .= " $custo_unitario_real, ";
                        $sql_i .= " $idt_insumo_unidade, ";
                        $sql_i .= " $por_participante ";
                        $sql_i .= ") ";
                        execsql($sql_i);
                    }
                }

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' valor_hora = ' . null($valor_hora);
                $sql_a .= ' where idt = ' . null($rowe['idt']);
                execsql($sql_a);
            }
        } else {
            $sql_d = 'delete  from grc_evento_insumo ';
            $sql_d .= "  where idt_evento = " . null($rowe['idt']);
            $sql_d .= "    and idt_profissional is not null";
            execsql($sql_d);
        }
    }
}

/**
 * Validações dos dados do Voucher da Política de Desconto
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento_publicacao_voucher <p>
 * IDT do Voucher da Política de Desconto
 * </p>
 * @param int $idt_evento_publicacao <p>
 * IDT da Política de Desconto
 * </p>
 * @param array $vetExtra [opcional] <p>
 * Array com Dados Extras
 * </p>
 * */
function validaVoucherEvento($idt_evento_publicacao_voucher, $idt_evento_publicacao, $vetExtra = Array()) {
    global $vetTipoVoucherCodIDT;

    $vetErroMsg = Array();

    //Verifica se o evento tem vagas disponiveis
    $sql = '';
    $sql .= ' select (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join grc_evento_publicacao p on p.idt_evento = e.idt';
    $sql .= " where p.idt = " . null($idt_evento_publicacao);
    $rs = execsql($sql, false);
    $qtd_disponivel = $rs->data[0][0];

    $sql = "select sum(v.quantidade) as quantidade";
    $sql .= " from grc_evento_publicacao_voucher v";
    $sql .= ' where v.idt_evento_publicacao = ' . null($idt_evento_publicacao);

    if ($idt_evento_publicacao_voucher >= 0) {
        $sql .= " and v.idt <> " . null($idt_evento_publicacao_voucher);
    }

    $rs = execsql($sql, false);
    $quantidade = $rs->data[0][0];

    if ($quantidade == '') {
        $quantidade = 0;
    }

    if ($vetExtra['quantidade'] != '') {
        $quantidade += $vetExtra['quantidade'];
    }

    if ($quantidade > $qtd_disponivel) {
        $msg = "A quantidade total voucheres da Política de Desconto não pode ser maior que a quantidade de vagas disponíveis!\n";
        $msg .= "Quantidade total voucheres da Política de Desconto: " . $quantidade . "\n";
        $msg .= "Quantidade de vagas disponíveis: " . $qtd_disponivel . "\n";
        $vetErroMsg[] = $msg;
    }

    //Tem que ter o a pessoa fisica no tipo B
    $sql = "select vr.numero";
    $sql .= " from grc_evento_publicacao_voucher_registro vr ";
    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
    $sql .= ' where v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
    $sql .= ' and vr.cpf is null';
    $sql .= " and vr.idt_evento_publicacao = " . null($idt_evento_publicacao);

    if ($idt_evento_publicacao_voucher >= 0) {
        $sql .= " and vr.idt_evento_publicacao_voucher = " . null($idt_evento_publicacao_voucher);
    }

    $sql .= " order by vr.numero";
    $rs = execsql($sql, false);

    if ($rs->rows > 0) {
        $vetErroMsg[] = "Os voucher a baixo estão faltando informar a Pessoa Fisica.";

        $vetTmp = Array();

        foreach ($rs->data as $row) {
            $vetTmp[] = $row['numero'];
        }

        $vetErroMsg[] = implode(', ', $vetTmp);
        $vetErroMsg[] = '';
    }

    return $vetErroMsg;
}

/**
 * Faz a transferencia da Quantidade de Cupons para o Evento e vice-versa<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento_publicacao_cupom <p>
 * IDT do grc_evento_publicacao_cupom
 * </p>
 * @param boolena $cred <p>
 * Se $cred = TRUE a quantidade informada no evento e removida do Cupom<br />
 * Se $cred = FALSE a quantidade informada no evento e devolvida ao Cupom<br />
 * </p>
 * */
function operacaoEventoCupom($idt_evento_publicacao_cupom, $cred) {
    $vetErroMsg = Array();

    $sql = '';
    $sql .= ' select p.idt, p.idt_evento_cupom, p.qtd_resevada as p_qtd_resevada, e.qtd_disponivel as e_qtd_disponivel';
    $sql .= ' from grc_evento_publicacao_cupom p';
    $sql .= ' inner join grc_evento_cupom e on e.idt = p.idt_evento_cupom';
    $sql .= ' where p.idt = ' . null($idt_evento_publicacao_cupom);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        $row = $rs->data[0];

        if ($cred) {
            if ($row['e_qtd_disponivel'] < $row['p_qtd_resevada']) {
                $vetErroMsg[] = 'O Cupom selecioando não tem a Qtd. de Cupons! Qtd. Disponível do Cupom: ' . $row['e_qtd_disponivel'];
            } else {
                $sql = 'update grc_evento_cupom set';
                $sql .= ' qtd_disponivel = qtd_disponivel - ' . null($row['p_qtd_resevada']) . ',';
                $sql .= ' qtd_resevada = qtd_resevada + ' . null($row['p_qtd_resevada']);
                $sql .= ' where idt = ' . null($row['idt_evento_cupom']);
                execsql($sql);
            }
        } else {
            $sql = 'update grc_evento_cupom set';
            $sql .= ' qtd_disponivel = qtd_disponivel + ' . null($row['p_qtd_resevada']) . ',';
            $sql .= ' qtd_resevada = qtd_resevada - ' . null($row['p_qtd_resevada']);
            $sql .= ' where idt = ' . null($row['idt_evento_cupom']);
            execsql($sql);
        }
    }

    $sql = 'update grc_evento_publicacao_cupom set';
    $sql .= ' qtd_disponivel = qtd_resevada - qtd_utilizada';
    $sql .= ' where idt = ' . null($idt_evento_publicacao_cupom);
    execsql($sql);

    return $vetErroMsg;
}

/**
 * Faz o bloqueio das vagas do Combo e vice-versa<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento_combo <p>
 * IDT do Associação de um Evento a um Combo (grc_evento_combo)
 * </p>
 * @param boolena $cred <p>
 * Se $cred = TRUE a quantidade informada no combo e bloqueada no Evento<br />
 * Se $cred = FALSE a quantidade informada no combo e desbloqueada no Evento<br />
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function operacaoEventoComboVaga($idt_evento_combo, $cred, $trata_erro = true) {
    $vetErroMsg = Array();

    $sql = '';
    $sql .= ' select p.idt_evento, p.qtd_vaga,';
    $sql .= ' (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
    $sql .= ' from grc_evento_combo p';
    $sql .= ' inner join grc_evento e on e.idt = p.idt_evento';
    $sql .= ' where p.idt = ' . null($idt_evento_combo);
    $rs = execsql($sql, $trata_erro);

    if ($rs->rows > 0) {
        $row = $rs->data[0];

        if ($cred) {
            if ($row['qtd_disponivel'] < $row['qtd_vaga']) {
                $vetErroMsg[] = 'O Evento selecioando não tem a Qtd. Disponível! Qtd. Disponível no Evento: ' . $row['qtd_disponivel'];
            } else {
                $sql = 'update grc_evento set';
                $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + ' . null($row['qtd_vaga']);
                $sql .= ' where idt = ' . null($row['idt_evento']);
                execsql($sql, $trata_erro);
            }
        } else {
            $sql = 'update grc_evento set';
            $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - ' . null($row['qtd_vaga']);
            $sql .= ' where idt = ' . null($row['idt_evento']);
            execsql($sql, $trata_erro);
        }
    }

    return $vetErroMsg;
}

/**
 * Faz o bloqueio das vagas do Voucher e vice-versa<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento_publicacao_voucher <p>
 * IDT do Voucher do Evento (grc_evento_publicacao_voucher)
 * </p>
 * @param boolena $cred <p>
 * Se $cred = TRUE a quantidade informada no combo e bloqueada no Evento<br />
 * Se $cred = FALSE a quantidade informada no combo e desbloqueada no Evento<br />
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function operacaoVoucherVaga($idt_evento_publicacao_voucher, $cred, $trata_erro = true) {
    $vetErroMsg = Array();

    $sql = '';
    $sql .= ' select p.idt_evento, v.quantidade as qtd_vaga,';
    $sql .= ' (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
    $sql .= ' from grc_evento_publicacao_voucher v';
    $sql .= ' inner join grc_evento_publicacao p on p.idt = v.idt_evento_publicacao';
    $sql .= ' inner join grc_evento e on e.idt = p.idt_evento';
    $sql .= ' where v.idt = ' . null($idt_evento_publicacao_voucher);
    $rs = execsql($sql, $trata_erro);

    if ($rs->rows > 0) {
        $row = $rs->data[0];

        if ($cred) {
            if ($row['qtd_disponivel'] < $row['qtd_vaga']) {
                $vetErroMsg[] = 'O Evento não tem a Qtd. Disponível! Qtd. Disponível no Evento: ' . $row['qtd_disponivel'];
            } else {
                $sql = 'update grc_evento set';
                $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + ' . null($row['qtd_vaga']);
                $sql .= ' where idt = ' . null($row['idt_evento']);
                execsql($sql, $trata_erro);
            }
        } else {
            $sql = 'update grc_evento set';
            $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - ' . null($row['qtd_vaga']);
            $sql .= ' where idt = ' . null($row['idt_evento']);
            execsql($sql, $trata_erro);
        }
    }

    return $vetErroMsg;
}

/**
 * Valida se pode usar o Voucher informado
 * @access public
 * @return string com o erro
 * @param string $voucher_numero <p>
 * Número do Voucher
 * </p>
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param int $idt_atendimento <p>
 * IDT do Atendimento (Matricula)
 * </p>
 * @param boolena $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function acaoChecaVoucher($voucher_numero, $idt_evento, $idt_atendimento, $trata_erro) {
    $erro = '';

    $sql = '';
    $sql .= ' select ep.idt_evento, vr.idt_matricula_utilizado, vr.idt_matricula_gerado, vr.ativo, vr.data_validade';
    $sql .= ' from grc_evento_publicacao_voucher_registro vr';
    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
    $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
    $sql .= ' where vr.numero = ' . aspa($voucher_numero);
    $sql .= " and ep.situacao = 'AP'";
    $rs = execsql($sql, $trata_erro);

    if ($rs->rows == 0) {
        $erro = 'O Número do Voucher informado não foi localizado no sistema!';
    } else {
        $row = $rs->data[0];

        if ($erro == '' && $row['idt_evento'] != $idt_evento && substr($voucher_numero, 0, 3) != 'VER') {
            $erro = 'O Número do Voucher informado não pertence a este evento!';
        }

        if ($erro == '' && $row['idt_matricula_utilizado'] != '' && $row['idt_matricula_utilizado'] != $idt_atendimento) {
            $erro = 'O Número do Voucher informado já foi utilizado!';
        }

        $diff = diffDate(getdata(false, true), trata_data($row['data_validade']));

        if ($erro == '' && ($row['ativo'] == 'N' || $diff < 0)) {
            $erro = 'O Número do Voucher informado não esta mais válido!';
        }

        if (substr($voucher_numero, 0, 3) == 'VEO' && $row['idt_matricula_gerado'] == $idt_atendimento) {
            $erro = 'O Número do Voucher informado não pode ser usando no mesmo inscrição que foi gerado!';
        }

        if ($erro == '' && substr($voucher_numero, 0, 3) == 'VER') {
            if ($erro == '') {
                $sql = '';
                $sql .= ' select dt_utilizacao';
                $sql .= ' from grc_evento_publicacao_voucher_registro';
                $sql .= ' where numero = ' . aspa(str_replace('R', 'O', $voucher_numero));
                $rs = execsql($sql, $trata_erro);

                if ($rs->data[0][0] == '') {
                    $erro = 'O Voucher do Indicado ainda não foi utilizado!';
                }

                if ($erro == '' && $row['idt_evento'] == $idt_evento) {
                    $erro = 'O Número do Voucher informado não pode ser usando no mesmo evento que foi gerado!';
                }
            }
        }
    }

    return $erro;
}

/**
 * Ajusta o Cupom e Voucher no cancelamento da matricula
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return string com o erro
 * @param string $voucher_numero <p>
 * Número do Voucher
 * </p>
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param int $idt_atendimento <p>
 * IDT do Atendimento (Matricula)
 * </p>
 * @param boolena $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function ajustaCupomVoucherCancelamentoMatricula($idt_evento, $idt_atendimento, $trata_erro) {
    global $vetTipoVoucherCodIDT;

    $vetErroFinal = Array();

    //Libera o Voucher gerado e não utilizado
    $sql = 'update grc_evento_publicacao_voucher_registro vr';
    $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
    $sql .= " set vr.ativo = 'N'";
    $sql .= ' where vr.idt_matricula_gerado = ' . null($idt_atendimento);
    $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
    $qtd = execsql($sql, $trata_erro);

    $sql = 'update grc_evento set';
    $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - ' . $qtd;
    $sql .= ' where idt = ' . null($idt_evento);
    execsql($sql, $trata_erro);

    //Voucher utilizado A
    $sql = 'update grc_evento_publicacao_voucher_registro vr';
    $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
    $sql .= ' set vr.cpf = null, vr.nome_pessoa = null, vr.idt_matricula_utilizado = null, vr.dt_utilizacao = null';
    $sql .= ' where vr.idt_matricula_utilizado = ' . null($idt_atendimento);
    $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
    $qtd = execsql($sql, $trata_erro);

    $sql = "update grc_evento set qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + " . $qtd;
    $sql .= " where idt = " . null($idt_evento);
    execsql($sql, $trata_erro);

    //Voucher utilizado B
    $sql = 'update grc_evento_publicacao_voucher_registro vr';
    $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
    $sql .= ' set vr.idt_matricula_utilizado = null, vr.dt_utilizacao = null';
    $sql .= ' where vr.idt_matricula_utilizado = ' . null($idt_atendimento);
    $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
    $qtd = execsql($sql, $trata_erro);

    $sql = "update grc_evento set qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + " . $qtd;
    $sql .= " where idt = " . null($idt_evento);
    execsql($sql, $trata_erro);

    //Voucher utilizado E Indicado
    $sql = 'update grc_evento_publicacao_voucher_registro vr';
    $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
    $sql .= ' set vr.cpf = null, vr.nome_pessoa = null, vr.idt_matricula_utilizado = null, vr.dt_utilizacao = null';
    $sql .= ' where vr.idt_matricula_utilizado = ' . null($idt_atendimento);
    $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['E']);
    $sql .= " and substring(vr.numero, 1, 3) = 'VEO'";
    $qtd = execsql($sql, $trata_erro);

    $sql = "update grc_evento set qtd_vagas_extra = qtd_vagas_extra - " . $qtd;
    $sql .= " where idt = " . null($idt_evento);
    execsql($sql, $trata_erro);

    //Voucher utilizado E Indicador
    $sql = 'update grc_evento_publicacao_voucher_registro vr';
    $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
    $sql .= ' set vr.cpf = null, vr.nome_pessoa = null, vr.idt_matricula_utilizado = null, vr.dt_utilizacao = null';
    $sql .= ' where vr.idt_matricula_utilizado = ' . null($idt_atendimento);
    $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['E']);
    $sql .= " and substring(vr.numero, 1, 3) = 'VER'";
    execsql($sql, $trata_erro);

    //Libera o Cupom de Desconto utilizado no pagamento
    $sql = '';
    $sql .= ' select idt_evento_publicacao_cupom';
    $sql .= ' from grc_evento_participante';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        //Desbloquea o cupom utilizado
        $vetErro = operacaoMatriculaCupom($row['idt_evento_publicacao_cupom'], FALSE, $trata_erro);

        if (count($vetErro) > 0) {
            $vetErroFinal[] = implode('<br />', $vetErro);
        }
    }

    return implode('<br />', $vetErroFinal);
}

/**
 * Faz o controle do saldo da utilização do Cupom na Matricula<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento_publicacao_cupom <p>
 * IDT do grc_evento_publicacao_cupom
 * </p>
 * @param boolena $cred <p>
 * Se $cred = TRUE um contador e removida do Cupom<br />
 * Se $cred = FALSE um contador e devolvida ao Cupom<br />
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function operacaoMatriculaCupom($idt_evento_publicacao_cupom, $cred, $trata_erro = true) {
    $vetErroMsg = Array();

    if ($idt_evento_publicacao_cupom != '') {
        $sql = '';
        $sql .= ' select idt_evento_cupom';
        $sql .= ' from grc_evento_publicacao_cupom';
        $sql .= ' where idt = ' . null($idt_evento_publicacao_cupom);
        $rs = execsql($sql, $trata_erro);
        $rowEPC = $rs->data[0];

        if ($cred) {
            $sql = "update grc_evento_publicacao_cupom set qtd_disponivel = qtd_disponivel - 1, qtd_utilizada = qtd_utilizada + 1";
            $sql .= " where idt = " . null($idt_evento_publicacao_cupom);
            execsql($sql, $trata_erro);

            $sql = "update grc_evento_cupom set qtd_utilizada = qtd_utilizada + 1";
            $sql .= " where idt = " . null($rowEPC['idt_evento_cupom']);
            execsql($sql, $trata_erro);

            $sql = '';
            $sql .= ' select qtd_disponivel';
            $sql .= ' from grc_evento_publicacao_cupom';
            $sql .= ' where idt = ' . null($idt_evento_publicacao_cupom);
            $rs = execsql($sql, $trata_erro);

            if ($rs->data[0][0] < 0) {
                $vetErroMsg[] = 'O Cupom não tem mais quantidade disponível para utilização!';
            }
        } else {
            $sql = "update grc_evento_publicacao_cupom set qtd_disponivel = qtd_disponivel + 1, qtd_utilizada = qtd_utilizada - 1";
            $sql .= " where idt = " . null($idt_evento_publicacao_cupom);
            execsql($sql, $trata_erro);

            $sql = "update grc_evento_cupom set qtd_utilizada = qtd_utilizada - 1";
            $sql .= " where idt = " . null($rowEPC['idt_evento_cupom']);
            execsql($sql, $trata_erro);
        }
    }

    return $vetErroMsg;
}

/**
 * Faz o controle para usar maior desconto na Matricula<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @param int $idt_atendimento <p>
 * IDT do grc_atendimento
 * </p>
 * @param float $valor_inscricao <p>
 * Valor total da Inscrição
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function operacaoEventoPagamentoDesconto($idt_atendimento, $valor_inscricao, $trata_erro = true) {
    if ($valor_inscricao == '') {
        $valor_inscricao = 0;
    }

    $sql = '';
    $sql .= ' select max(percentual) as tot';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_desconto';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $percentual = $rs->data[0][0];

    if ($percentual == '') {
        $sql = 'delete from ' . db_pir_grc . 'grc_evento_participante_pagamento';
        $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
        $sql .= ' and idt_evento_natureza_pagamento = 9';
        execsql($sql, $trata_erro);
    } else {
        $valor_pagamento = $valor_inscricao * $percentual / 100;

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_pagamento';
        $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
        $sql .= ' and idt_evento_natureza_pagamento = 9';
        $rs = execsql($sql, $trata_erro);

        if ($rs->rows == 0) {
            $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante_pagamento (';
            $sql .= ' idt_atendimento, idt_evento_situacao_pagamento, idt_evento_natureza_pagamento, operacao, so_consulta, data_pagamento, valor_pagamento';
            $sql .= ') values (';
            $sql .= null($idt_atendimento) . ", 5, 9, 'C', 'S', now(), " . null($valor_pagamento);
            $sql .= ')';
            execsql($sql, $trata_erro);
        } else {
            $sql = 'update ' . db_pir_grc . 'grc_evento_participante_pagamento set';
            $sql .= ' valor_pagamento = ' . null($valor_pagamento);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, $trata_erro);
        }
    }
}

/**
 * Cadastra o registro de Desconto na Matricula<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @param int $idt_atendimento <p>
 * IDT do grc_atendimento
 * </p>
 * @param string $codigo <p>
 * Código do Desconto
 * </p>
 * @param string $descricao <p>
 * Descrição do Desconto
 * </p>
 * @param float $percentual <p>
 * Percentual do Desconto
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function cadastraMatriculaDesconto($idt_atendimento, $codigo, $descricao, $percentual, $trata_erro = true) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_desconto';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' and codigo = ' . aspa($codigo);
    $rs = execsql($sql, $trata_erro);

    if ($rs->rows == 0) {
        $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante_desconto (';
        $sql .= ' idt_atendimento, codigo, descricao, percentual';
        $sql .= ') values (';
        $sql .= null($idt_atendimento) . ', ' . aspa($codigo) . ', ' . aspa($descricao) . ', ' . null($percentual);
        $sql .= ')';
        execsql($sql, $trata_erro);
    } else {
        $sql = 'update ' . db_pir_grc . 'grc_evento_participante_desconto set';
        $sql .= ' percentual = ' . null($percentual);
        $sql .= ' where idt = ' . null($rs->data[0][0]);
        execsql($sql, $trata_erro);
    }
}

/**
 * Gera os registros por Local/Sala do Mapa de Assento da Política de Desconto
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return tipo
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param string $assento_marcado <p>
 * Se o valor do assento_marcado for igual a S gera os registros, qualquer outro valor deleta os registros que tiver.
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function geraMapaAssento($idt_evento, $assento_marcado, $trata_erro = true) {
    $vetIdtOK = Array();
    $vetIdtOK[] = 0;

    if ($assento_marcado == 'S') {
        $sql = '';
        $sql .= ' select idt_local as idt_local_pa';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($idt_evento);
        $sql .= ' and idt_local is not null';
        $sql .= ' union ';
        $sql .= ' select distinct idt_local as idt_local_pa';
        $sql .= ' from grc_evento_agenda';
        $sql .= ' where idt_evento = ' . null($idt_evento);
        $sql .= ' and idt_local is not null';
        $rs = execsql($sql, $trata_erro);

        foreach ($rs->data as $row) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_mapa';
            $sql .= ' where idt_evento = ' . null($idt_evento);
            $sql .= ' and idt_local_pa = ' . null($row['idt_local_pa']);
            $rst = execsql($sql);

            if ($rst->rows == 0) {
                $sql = 'insert into grc_evento_mapa (idt_evento, idt_local_pa) values (';
                $sql .= null($idt_evento) . ', ' . null($row['idt_local_pa']) . ')';
                execsql($sql, $trata_erro);
                $vetIdtOK[] = lastInsertId();
            } else {
                $vetIdtOK[] = $rst->data[0][0];
            }
        }
    }

    $sql = 'delete from grc_evento_mapa';
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= ' and idt not in (' . implode(', ', $vetIdtOK) . ')';
    execsql($sql, $trata_erro);
}

/**
 * Gera os registros por Instrumento de Evento Combo
 * @access public
 * @return tipo
 * @param int $idt_evento <p>
 * IDT do Evento do Instrumento Combo
 * </p>
 * */
function geraEventoComboInstrumento($idt_evento) {
    $sql = '';
    $sql .= ' select e.idt_instrumento, eg.matricula_obr';
    $sql .= ' from grc_evento_combo eg';
    $sql .= ' inner join grc_evento e on e.idt = eg.idt_evento';
    $sql .= ' where eg.idt_evento_origem = ' . null($idt_evento);
    $rs = execsql($sql);

    $vetDados = Array();
    $vetIdtOK = Array();
    $vetIdtOK[] = 0;

    foreach ($rs->data as $row) {
        $vetIdtOK[$row['idt_instrumento']] = $row['idt_instrumento'];
        $vetDados[$row['idt_instrumento']]['qtd_max'] ++;

        if ($row['matricula_obr'] == 'S') {
            $vetDados[$row['idt_instrumento']]['qtd_min'] ++;
        }
    }

    foreach ($vetDados as $idt_instrumento => $row) {
        if ($row['qtd_max'] == '') {
            $row['qtd_max'] = 0;
        }

        if ($row['qtd_min'] == '') {
            $row['qtd_min'] = 0;
        }

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento_combo_instrumento';
        $sql .= ' where idt_evento = ' . null($idt_evento);
        $sql .= ' and idt_instrumento = ' . null($idt_instrumento);
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            if ($row['qtd_min'] === $row['qtd_max']) {
                $sql = 'insert into grc_evento_combo_instrumento (idt_evento, idt_instrumento, qtd_min, qtd_max, qtd_atual) values (';
                $sql .= null($idt_evento) . ', ' . null($idt_instrumento) . ', ' . null($row['qtd_min']) . ', ' . null($row['qtd_max']) . ', ' . null($row['qtd_max']) . ')';
                execsql($sql);
            } else {
                $sql = 'insert into grc_evento_combo_instrumento (idt_evento, idt_instrumento, qtd_min, qtd_max) values (';
                $sql .= null($idt_evento) . ', ' . null($idt_instrumento) . ', ' . null($row['qtd_min']) . ', ' . null($row['qtd_max']) . ')';
                execsql($sql);
            }
        } else {
            $sql = 'update grc_evento_combo_instrumento set';

            if ($row['qtd_min'] === $row['qtd_max']) {
                $sql .= ' qtd_atual = ' . null($row['qtd_max']) . ',';
            }

            $sql .= ' qtd_min = ' . null($row['qtd_min']) . ',';
            $sql .= ' qtd_max = ' . null($row['qtd_max']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql);
        }
    }

    $sql = 'delete from grc_evento_combo_instrumento';
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= ' and idt_instrumento not in (' . implode(', ', $vetIdtOK) . ')';
    execsql($sql);

    //Resumo Unidade
    $vetIdtOK = Array();
    $vetIdtOK[] = 0;

    $sql = '';
    $sql .= ' select e.idt_unidade, count(eg.idt) as qtd_evento';
    $sql .= ' from grc_evento_combo eg';
    $sql .= ' inner join grc_evento e on e.idt = eg.idt_evento';
    $sql .= ' where eg.idt_evento_origem = ' . null($idt_evento);
    $sql .= ' group by e.idt_unidade';
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $vetIdtOK[$row['idt_unidade']] = $row['idt_unidade'];

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento_combo_unidade';
        $sql .= ' where idt_evento = ' . null($idt_evento);
        $sql .= ' and idt_unidade = ' . null($row['idt_unidade']);
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $sql = 'insert into grc_evento_combo_unidade (idt_evento, idt_unidade, qtd_evento) values (';
            $sql .= null($idt_evento) . ', ' . null($row['idt_unidade']) . ', ' . null($row['qtd_evento']) . ')';
            execsql($sql);
        } else {
            $sql = 'update grc_evento_combo_unidade set';
            $sql .= ' qtd_evento = ' . null($row['qtd_evento']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql);
        }
    }

    $sql = 'delete from grc_evento_combo_unidade';
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= ' and idt_unidade not in (' . implode(', ', $vetIdtOK) . ')';
    execsql($sql);
}

function ftr_grc_evento_combo($rs) {
    global $idt_responsavel_unidade_lotacao;

    foreach ($rs->data as $idx => $row) {
        if ($row['idt_unidade'] == $idt_responsavel_unidade_lotacao) {
            $rs->data[$idx]['linha_cor'] = 'fe0000';
        }
    }

    return $rs;
}

/**
 * Utilizado para alterar o html da TD ftd_grc_evento_combo no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_combo($valor, &$row, $Campo) {
    global $vetSimNao;

    $html = '';

    switch ($Campo) {
        case 'assento_marcado':
            $html = $vetSimNao[$valor];

            if ($html == '') {
                $html = $vetSimNao['N'];
            }
            break;

        default :
            $html = $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD grc_evento_combo_instrumento no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_combo_instrumento($valor, &$row, $Campo) {
    global $acao, $acao_alt_con;

    $html = '';

    switch ($Campo) {
        case 'qtd_atual':
            if ($acao == 'con' || $acao_alt_con == 'S') {
                $html = $row['qtd_atual'];
            } else {
                $html = '<input value="' . $row['qtd_atual'] . '" data-min="' . $row['qtd_min'] . '" data-max="' . $row['qtd_max'] . '" name="dados[' . $row['idt'] . '][qtd_atual]" type="text" class="Texto qtd_atual" maxlength="5" size="5" onblur="enumero(this)" >';
            }
            break;

        default :
            $html = $valor;
            break;
    }

    return $html;
}

/**
 * Utilizado para alterar o html da TD grc_evento_combo_instrumento no cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_publicar_evento($valor, &$row, $Campo) {
    global $vetEventoPubilcarRegistro;

    $html = '';

    switch ($Campo) {
        case 'situacao':
            $tmp = $vetEventoPubilcarRegistro;
            unset($tmp['AA']);
            unset($tmp['CA']);

            $html = criar_combo_vet($tmp, 'epe_situacao[' . $row['idt_evento'] . ']', $valor, ' ', '', '', true);

            break;

        default :
            $html = $valor;
            break;
    }

    return $html;
}

function fbp_grc_evento_participante($row, $session_cod) {
    $title = 'Inscrever no Combo';

    $par = '';
    $par .= '&menu=grc_evento_participante';
    $par .= '&session_cod=' . $_GET['session_cod'];
    $par .= '&idCad=' . $row['idt'];
    $par .= '&id=0';
    $par .= '&cas=' . $_GET['cas'];
    $par .= '&idt_instrumento=' . $row['idt_instrumento'];
    $par .= '&gratuito=N';

    $url = 'conteudo_cadastro.php?acao=inc&prefixo=cadastro' . $par;

    $html = '';
    $html .= "<a href='{$url}' target='_self' title='{$title}' alt='{$title}' class='Titulo'>";
    $html .= "<img src='imagens/bt_marcado.png' width='16' title='{$title}' alt='{$title}' border='0'>";
    $html .= "</a>";

    return $html;
}

/**
 * Ajusta Público Alvo da Política de Desconto com base nos dados do Evento
 * @access public
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param boolean $usaTransaction [opcional] <p>
 * Usa transação do banco
 * </p>
 * */
function geraPublicoAlvoPoliticaDesconto($idt_evento, $usaTransaction = true) {
    //Atualiza a Publico Alvo
    if ($usaTransaction) {
        beginTransaction();
    }

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_publicacao';
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= " and situacao = 'CD'";
    $sql .= " and ativo = 'S'";
    $rsEP = execsql($sql);

    $sql = '';
    $sql .= ' select idt_publico_alvo_outro as idt_publico_alvo';
    $sql .= ' from grc_evento_publico_alvo';
    $sql .= ' where idt = ' . null($idt_evento);
    $sql .= " and ativo = 'S'";
    $rs = execsql($sql);

    foreach ($rsEP->data as $rowEP) {
        $vetIdtOK = Array();
        $vetIdtOK[] = 0;

        foreach ($rs->data as $row) {
            $vetIdtOK[$row['idt_publico_alvo']] = $row['idt_publico_alvo'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_publicacao_publico_alvo';
            $sql .= ' where idt = ' . null($rowEP['idt']);
            $sql .= ' and idt_publico_alvo = ' . null($row['idt_publico_alvo']);
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $sql = 'insert into grc_evento_publicacao_publico_alvo (idt, idt_publico_alvo) values (';
                $sql .= null($rowEP['idt']) . ', ' . null($row['idt_publico_alvo']) . ')';
                execsql($sql);
            }
        }

        $sql = 'delete from grc_evento_publicacao_publico_alvo';
        $sql .= ' where idt = ' . null($rowEP['idt']);
        $sql .= ' and idt_publico_alvo not in (' . implode(', ', $vetIdtOK) . ')';
        execsql($sql);
    }

    if ($usaTransaction) {
        commit();
    }
}

/**
 * validações da Política de Desconto para poder salvar o registro
 * @access public
 * @return Array Vetor com os erros
 * @param array $vetDados <p>
 * Vetor com as informações
 * </p>
 * */
function validaPoliticaDesconto($vetDados) {
    $vetErroMsg = validaVoucherEvento(-1, $vetDados['idt']);

    $sql = '';
    $sql .= ' select sum(quantidade_inscrito) as qtd';
    $sql .= ' from grc_evento_publicacao_canal';
    $sql .= ' where idt_evento_publicacao = ' . null($vetDados['idt']);
    $rs = execsql($sql, false);

    if ($rs->data[0][0] > $vetDados['quantidade_participante']) {
        $vetErroMsg[] = 'A quantidade de incrições no Canal não pode ser maior que a Qtde. Participantes do Evento (QTD: ' . $vetDados['quantidade_participante'] . ')!';
    }

    //Valida os Tipos de Voucher 
    if ($vetDados['gerador_voucher'] == 'S') {
        $vetTemVoucher = Array();

        $sql = '';
        $sql .= ' select t.codigo';
        $sql .= ' from grc_evento_publicacao_voucher v';
        $sql .= ' inner join grc_evento_tipo_voucher t on t.idt = v.idt_tipo_voucher';
        $sql .= ' where v.idt_evento_publicacao = ' . null($vetDados['idt']);
        $rs = execsql($sql, false);

        foreach ($rs->data as $row) {
            $vetTemVoucher[$row['codigo']] ++;
        }

        if ($vetTemVoucher['E'] > 0) {
            unset($vetTemVoucher['E']);

            if ($vetDados['cupon_desconto'] == 'S') {
                $vetErroMsg[] = 'O Voucher E não pode ser usado com Cupom de Desconto!';
            }
        }

        //Valida Data Validade Voucher 
        $vetErro = Array();
        $data_publicacao_de = substr($vetDados['data_publicacao_de'], 0, 10);
        $data_hora_fim_inscricao_ec = substr($vetDados['data_hora_fim_inscricao_ec'], 0, 10);

        if ($data_publicacao_de != '' && $data_hora_fim_inscricao_ec != '') {
            $sql = '';
            $sql .= ' select idt, descricao, data_validade';
            $sql .= ' from grc_evento_publicacao_voucher';
            $sql .= ' where idt_evento_publicacao = ' . null($vetDados['idt']);
            $sql .= ' and data_validade is not null';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $data_validade = trata_data($row['data_validade']);

                if (diffDate($data_validade, $data_publicacao_de) > 0 || diffDate($data_validade, $data_hora_fim_inscricao_ec) < 0) {
                    $vetErro[$row['idt']] = '"' . $row['descricao'] . '"';
                }
            }

            if (count($vetErro) > 0) {
                $vetErroMsg[] = 'Favor informar uma Data Validade Voucher válida, para os Voucher ' . implode(', ', $vetErro) . '!';
            }
        }
    }

    return $vetErroMsg;
}

/**
 * Validações da Matricula na Consultoria de Longa Duração
 * @access public
 * @return Array Vetor com os erros
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param string cred_necessita_credenciado <p>
 * O Evento Necessita Credenciado(s)?
 * </p>
 * @param array $vetExtra [opcional] <p>
 * Array com Dados Extras
 * </p>
 * */
function validaMatEventoCLD($idt_evento, $cred_necessita_credenciado, $vetExtra = Array()) {
    global $vetConf;

    $sql = "select gec_prog.tipo_ordem, grc_e.tipo_sincroniza_siacweb";
    $sql .= ' from grc_evento grc_e';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_e.idt_programa';
    $sql .= " where grc_e.idt = " . null($idt_evento);
    $rs = execsql($sql, false);
    $rowe = $rs->data[0];

    $vetErroMsg = Array();

    //Tem que ter o tema e subtema das atividades
    if (count($vetErroMsg) == 0 && count($vetExtra) == 0 && $rowe['tipo_sincroniza_siacweb'] == 'P') {
        $sql = '';
        $sql .= " select a.protocolo, p.nome, substring(ea.atividade, 1, 60) as txt";
        $sql .= ' from grc_evento_atividade ea';
        $sql .= " left outer join grc_atendimento a on a.idt = ea.idt_atendimento";
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
        $sql .= " left outer join grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' and (ea.idt_tema is null or ea.idt_subtema is null)';
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $vetErroMsg[] = "As atividades a baixo estão faltando informar o Tema ou Subtema.\n";

            foreach ($rs->data as $row) {
                $vetErroMsg[] = $row['protocolo'] . ' - ' . $row['nome'] . ': ' . trata_data($row['txt']);
            }
        }
    }

    //A atividade não pode mudar o mês
    if (count($vetErroMsg) == 0) {
        if (count($vetExtra) == 0) {
            $sql = '';
            $sql .= " select a.protocolo, p.nome, ea.atividade, count(distinct concat(year(ea.data_inicial), month(ea.data_inicial))) as tot";
            $sql .= ' from grc_evento_agenda ea';
            $sql .= " left outer join grc_atendimento a on a.idt = ea.idt_atendimento";
            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= " left outer join grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = ea.idt_atendimento";
            $sql .= ' where ea.idt_evento = ' . null($idt_evento);
            $sql .= whereEventoParticipante();
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $sql .= ' group by a.protocolo, p.nome, ea.atividade';
            $sql .= ' having tot > 1';
            $sql .= ' order by a.protocolo, p.nome, ea.atividade';
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $vetErroMsg[] = "As atividades a baixo estão com datas em mais de um mês o que não é permitido.\n";

                foreach ($rs->data as $row) {
                    $vetErroMsg[] = $row['protocolo'] . ' - ' . $row['nome'] . ': ' . $row['atividade'];
                }
            }
        } else {
            $sql = '';
            $sql .= " select month(ea.data_inicial) as mes, year(ea.data_inicial) as ano";
            $sql .= ' from grc_evento_agenda ea';
            $sql .= ' where ea.idt_evento = ' . null($idt_evento);
            $sql .= ' and ea.idt_evento_atividade = ' . null($vetExtra['idt_evento_atividade']);
            $sql .= ' and ea.idt <> ' . null($vetExtra['idt']);
            $rs = execsql($sql);

            $vetMesAno = Array();

            foreach ($rs->data as $row) {
                $vetMesAno[(int) $row['mes']][(int) $row['ano']] ++;
            }

            $vetData = DatetoArray($vetExtra['dt_ini']);
            $vetMesAno[(int) $vetData['mes']][(int) $vetData['ano']] ++;

            if ($vetExtra['dt_ini'] != $vetExtra['dt_fim']) {
                $vetData = DatetoArray($vetExtra['dt_fim']);
                $vetMesAno[(int) $vetData['mes']][(int) $vetData['ano']] ++;
            }

            if (count($vetMesAno) > 1) {
                $vetErroMsg[] = "A atividade esta com datas em mais de um mês o que não é permitido.";
            }
        }
    }

    //Não pode ter mais de uma atividade com data inicio igual
    if (count($vetErroMsg) == 0) {
        if (count($vetExtra) == 0) {
            $sql = '';
            $sql .= " select protocolo, nome, ini, count(atividade) as tot";
            $sql .= ' from (';
            $sql .= " select a.protocolo, p.nome, ea.atividade, min(ea.dt_ini) as ini";
            $sql .= ' from grc_evento_agenda ea';
            $sql .= " left outer join grc_atendimento a on a.idt = ea.idt_atendimento";
            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= " left outer join grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = ea.idt_atendimento";
            $sql .= ' where ea.idt_evento = ' . null($idt_evento);
            $sql .= whereEventoParticipante();
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $sql .= ' group by a.protocolo, p.nome, ea.atividade';
            $sql .= ' ) x';
            $sql .= ' group by protocolo, nome, ini';
            $sql .= ' having tot > 1';
            $sql .= ' order by protocolo, nome, ini';
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $vetErroMsg[] = "As atividades a baixo estão com a mesma data de inicio o que não é permitido.\n";

                foreach ($rs->data as $row) {
                    $vetErroMsg[] = $row['protocolo'] . ' - ' . $row['nome'] . ': ' . trata_data($row['ini']);
                }
            }
        } else {
            $ini = $vetExtra['dt_ini'] . ' ' . $vetExtra['hora_inicial'];

            $sql = '';
            $sql .= " select ea.atividade, min(ea.dt_ini) as ini";
            $sql .= ' from grc_evento_agenda ea';
            $sql .= ' where ea.idt_atendimento = ' . null($vetExtra['idt_atendimento']);
            $sql .= ' and ea.idt <> ' . null($vetExtra['idt']);
            $sql .= ' group by ea.atividade';
            $rs = execsql($sql);

            $vetDT = Array();

            foreach ($rs->data as $row) {
                $vetDT[$row['ini']] = trata_data($row['ini']);
            }

            if (in_array($ini, $vetDT)) {
                $vetErroMsg[] = "A atividade esta com a mesma data de inicio o que não é permitido.\n";
            }
        }
    }

    //A quantidade de horas mensais que um credenciado pode executar é de XXX horas
    if (count($vetErroMsg) == 0 && $rowe['tipo_ordem'] != 'SG' && $cred_necessita_credenciado != 'N') {
        $sql = '';
        $sql .= ' select month(ea.data_inicial) as mes, year(ea.data_inicial) as ano, sum(ea.carga_horaria) as tot';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";

        if (count($vetExtra) > 0) {
            $sql .= ' and ea.idt <> ' . null($vetExtra['idt']);
        }

        $sql .= ' group by month(ea.data_inicial), year(ea.data_inicial)';
        $rs = execsql($sql);

        $vetMesAno = Array();
        $vetErro = Array();

        foreach ($rs->data as $row) {
            $vetMesAno[(int) $row['ano']][(int) $row['mes']] += $row['tot'];
        }

        if (count($vetExtra['vetMesAno']) > 0) {
            foreach ($vetExtra['vetMesAno'] as $ano => $vetMes) {
                foreach ($vetMes as $mes => $tot) {
                    $vetMesAno[(int) $ano][(int) $mes] += $tot;
                }
            }
        }

        foreach ($vetMesAno as $ano => $vetMes) {
            foreach ($vetMes as $mes => $tot) {
                if ($tot > $vetConf['evento_cons_hora_mes']) {
                    $vetErro[] = $mes . '/' . $ano;
                }
            }
        }

        if (count($vetErro) > 0) {
            sort($vetErro);
            $vetErroMsg[] = "As atividades ultrapassaram o limite de " . $vetConf['evento_cons_hora_mes'] . " horas mensais nos meses de\n" . implode(', ', $vetErro);
        }
    }

    return $vetErroMsg;
}

/**
 * Inclui ou alterar o registro da tabela informada
 * @access public
 * @return int IDT do Registro
 * @param string $tabela <p>
 * Nome da Tabela
 * </p>
 * @param string $pk <p>
 * PK
 * </p>
 * @param string $where <p>
 * Where do SQL para verificação se o registro já existe.
 * </p>
 * @param array $row <p>
 * Array com os dados do registro
 * </p>
 * @param array $vetCampoExtra <p>
 * Array com os dados extras do registro
 * </p>
 * @param array $vetCampoRemoveUpdate <p>
 * Array com os campos que vão atualizados no update
 * </p>
 * @param string $whereUpdate <p>
 * Where do Update. Se FALSE não faz update
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function MatriculaEventoCompostoSincronizaAcao($tabela, $pk, $where, $row, $vetCampoExtra, $vetCampoRemoveUpdate, $whereUpdate = '', $trata_erro = true) {
    set_time_limit(60);

    $vetCampo = Array();
    $vetCampoTmp = Array();

    foreach ($row as $key => $value) {
        if (!is_array($value)) {
            $vetCampoTmp[$key] = aspa($value);
        }
    }

    $tabela = db_pir_grc . $tabela;

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . $tabela;
    $sql .= ' where 1 = 0';
    $rst = execsql($sql, $trata_erro);

    foreach ($rst->info['name'] as $campo) {
        if (key_exists($campo, $vetCampoTmp)) {
            $vetCampo[$campo] = $vetCampoTmp[$campo];
        }
    }

    foreach ($vetCampoExtra as $key => $value) {
        $vetCampo[$key] = aspa($value);
    }

    if ($where === false) {
        $idt = '';
    } else {
        $sql = '';
        $sql .= ' select ' . $pk;
        $sql .= ' from ' . $tabela;
        $sql .= ' where ' . $where;
        $sql .= ' order by ' . $pk;
        $rs = execsql($sql, $trata_erro);
        $idt = $rs->data[0][$pk];
    }

    if ($idt == '') {
        $sql = 'insert into ' . $tabela . ' (' . implode(', ', array_keys($vetCampo)) . ') values (' . implode(', ', $vetCampo) . ')';
        execsql($sql, $trata_erro);
        $idt = lastInsertId();
    } else if ($whereUpdate !== false) {
        $tmp = Array();
        foreach ($vetCampo as $key => $value) {
            if (!in_array($key, $vetCampoRemoveUpdate)) {
                $tmp[] = $key . ' = ' . $value;
            }
        }

        $sql = 'update ' . $tabela . ' set ' . implode(', ', $tmp) . ' where ' . $pk . ' = ' . null($idt) . $whereUpdate;
        execsql($sql, $trata_erro);
    }

    return $idt;
}

/**
 * Faz o sincronismo da matricula do evento Pai com os filhos (Evento Composto)
 * @access public
 * @return string Mensagem de Erro
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param int $idt_atendimento [opcional] <p>
 * IDT do Atendimento (Matricula)
 * </p>
 * @param boolean $usaTransaction [opcional] <p>
 * Usa transação do banco
 * </p>
 * */
function MatriculaEventoCompostoSincroniza($idt_evento, $idt_atendimento = '', $usaTransaction = true) {
    global $debug;

    $trata_erro = false;

    try {
        if ($usaTransaction) {
            beginTransaction();
        }

        $sql = '';
        $sql .= ' select idt_instrumento';
        $sql .= ' from ' . db_pir_grc . 'grc_evento';
        $sql .= ' where idt = ' . null($idt_evento);
        $rs = execsql($sql, $trata_erro);
        $rowMatPai = $rs->data[0];

        if ($rowMatPai['idt_instrumento'] == 54) {
            $sql = '';
            $sql .= ' select idt_evento as idt, matricula_obr';
            $sql .= ' from ' . db_pir_grc . 'grc_evento_combo';
            $sql .= ' where idt_evento_origem = ' . null($idt_evento);
        } else {
            $sql = '';
            $sql .= " select idt, 'N' as matricula_obr";
            $sql .= ' from ' . db_pir_grc . 'grc_evento';
            $sql .= ' where idt_evento_pai = ' . null($idt_evento);
        }

        $rsEF = execsql($sql, $trata_erro);

        if ($rsEF->rows > 0) {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
            $sql .= ' where a.idt_evento = ' . null($idt_evento);

            if ($idt_atendimento != '') {
                $sql .= ' and a.idt = ' . null($idt_atendimento);
            }

            $rsMP = execsqlNomeCol($sql, $trata_erro);

            foreach ($rsMP->data as $rowMP) {
                $vetIdtFilho = Array();

                foreach ($rsEF->data as $rowEF) {
                    $sql = '';
                    $sql .= ' select a.idt';
                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
                    $sql .= ' where a.idt_evento = ' . null($rowEF['idt']);
                    $sql .= ' and a.idt_atendimento_pai = ' . null($rowMP['idt']);
                    $rs = execsql($sql, $trata_erro);
                    $idtFilho = $rs->data[0][0];

                    if ($idtFilho == '') {
                        //Cadastrar Matricula no Evento Filho
                        $idtFilho = MatriculaEventoCompostoCria($rowEF['matricula_obr'], $rowEF['idt'], $rowMP['idt'], $trata_erro);
                    }

                    $vetIdtFilho[$idtFilho] = $idtFilho;
                }

                if (count($vetIdtFilho) > 0) {
                    $idtFilho = implode(', ', $vetIdtFilho);

                    //grc_atendimento
                    $vetCampo = Array();
                    $vetCampoRemove = Array(
                        'idt', 'codrealizacao', 'idt_atendimento_agenda', 'idt_cliente', 'idt_pessoa', 'idt_instrumento',
                        'senha_totem', 'senha_ordem', 'idt_evento', 'idt_atendimento_pai', 'siacweb_codcosultoria'
                    );

                    foreach ($rsMP->info['name'] as $campo) {
                        if (!in_array($campo, $vetCampoRemove)) {
                            $vetCampo[$campo] = $rowMP[$campo];
                        }
                    }

                    $tmp = Array();
                    foreach ($vetCampo as $key => $value) {
                        $tmp[] = $key . ' = ' . aspa($value);
                    }

                    $sql = 'update ' . db_pir_grc . 'grc_atendimento set ' . implode(', ', $tmp) . ' where idt in (' . $idtFilho . ')';
                    execsql($sql, $trata_erro);

                    //Pessoa
                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
                    $sql .= ' where idt_atendimento = ' . null($rowMP['idt']);
                    $rsOrg = execsqlNomeCol($sql, $trata_erro);

                    $vetCampoRemove = Array(
                        'idt', 'idt_atendimento', 'evento_cortesia', 'evento_inscrito', 'evento_exc_siacweb', 'evento_concluio', 'siacweb_codcosultoria', 'siacweb_codparticipantecosultoria'
                    );

                    foreach ($vetIdtFilho as $idt_at) {
                        $vetNotDel = Array();
                        $vetNotDel[0] = 0;

                        foreach ($rsOrg->data as $rowOrg) {
                            //grc_atendimento_pessoa
                            $dados = Array();

                            foreach ($rsOrg->info['name'] as $campo) {
                                if (!in_array($campo, $vetCampoRemove)) {
                                    $dados[$campo] = $rowOrg[$campo];
                                }
                            }

                            $dados['idt_atendimento'] = $idt_at;

                            $vetCampoRemoveUpdate = Array('idt_atendimento');

                            $where = '';
                            $where .= ' idt_atendimento = ' . null($idt_at);
                            $where .= ' and cpf = ' . aspa($rowOrg['cpf']);

                            $whereUpdate = '';
                            $vetCampoExtra = Array();

                            $idt_pes = MatriculaEventoCompostoSincronizaAcao('grc_atendimento_pessoa', 'idt', $where, $dados, $vetCampoExtra, $vetCampoRemoveUpdate, $whereUpdate, $trata_erro);

                            $vetNotDel[$idt_pes] = $idt_pes;

                            //grc_atendimento_pessoa_tipo_deficiencia
                            $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_deficiencia where idt = ' . null($idt_pes);
                            execsql($sql, $trata_erro);

                            $sql = 'insert ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_deficiencia (idt, idt_tipo_deficiencia)';
                            $sql .= " select {$idt_pes} as idt, idt_tipo_deficiencia";
                            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_deficiencia';
                            $sql .= ' where idt = ' . null($rowOrg['idt']);
                            execsql($sql, $trata_erro);

                            //grc_atendimento_pessoa_tipo_informacao
                            $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_informacao where idt = ' . null($idt_pes);
                            execsql($sql, $trata_erro);

                            $sql = 'insert grc_atendimento_pessoa_tipo_informacao (idt, idt_tipo_informacao)';
                            $sql .= " select {$idt_pes} as idt, idt_tipo_informacao";
                            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa_tipo_informacao';
                            $sql .= ' where idt = ' . null($rowOrg['idt']);
                            execsql($sql, $trata_erro);
                        }

                        $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_pessoa where idt_atendimento = ' . null($idt_at);
                        $sql .= ' and idt not in (' . implode(', ', $vetNotDel) . ')';
                        execsql($sql, $trata_erro);
                    }

                    //Organização
                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao';
                    $sql .= ' where idt_atendimento = ' . null($rowMP['idt']);
                    $rsOrg = execsqlNomeCol($sql, $trata_erro);

                    $vetCampoRemove = Array(
                        'idt', 'idt_atendimento'
                    );

                    foreach ($vetIdtFilho as $idt_at) {
                        $vetNotDel = Array();
                        $vetNotDel[0] = 0;

                        foreach ($rsOrg->data as $rowOrg) {
                            //grc_atendimento_organizacao
                            $dados = Array();

                            foreach ($rsOrg->info['name'] as $campo) {
                                if (!in_array($campo, $vetCampoRemove)) {
                                    $dados[$campo] = $rowOrg[$campo];
                                }
                            }

                            $dados['idt_atendimento'] = $idt_at;

                            $vetCampoRemoveUpdate = Array('idt_atendimento');

                            $where = '';
                            $where .= ' idt_atendimento = ' . null($idt_at);
                            $where .= ' and cnpj = ' . aspa($rowOrg['cnpj']);

                            $whereUpdate = '';
                            $vetCampoExtra = Array();

                            $idt_pes = MatriculaEventoCompostoSincronizaAcao('grc_atendimento_organizacao', 'idt', $where, $dados, $vetCampoExtra, $vetCampoRemoveUpdate, $whereUpdate, $trata_erro);

                            $vetNotDel[$idt_pes] = $idt_pes;

                            //grc_atendimento_organizacao_cnae
                            $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao_cnae where idt_atendimento_organizacao = ' . null($idt_pes);
                            execsql($sql, $trata_erro);

                            $sql = 'insert ' . db_pir_grc . 'grc_atendimento_organizacao_cnae (idt_atendimento_organizacao, cnae, principal)';
                            $sql .= " select {$idt_pes} as idt_atendimento_organizacao, cnae, principal";
                            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao_cnae';
                            $sql .= ' where idt_atendimento_organizacao = ' . null($rowOrg['idt']);
                            execsql($sql, $trata_erro);

                            //grc_atendimento_organizacao_tipo_informacao
                            $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao where idt = ' . null($idt_pes);
                            execsql($sql, $trata_erro);

                            $sql = 'insert ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao (idt, idt_tipo_informacao_e)';
                            $sql .= " select {$idt_pes} as idt, idt_tipo_informacao_e";
                            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao_tipo_informacao';
                            $sql .= ' where idt = ' . null($rowOrg['idt']);
                            execsql($sql, $trata_erro);
                        }

                        $sql = 'delete from ' . db_pir_grc . 'grc_atendimento_organizacao where idt_atendimento = ' . null($idt_at);
                        $sql .= ' and idt not in (' . implode(', ', $vetNotDel) . ')';
                        execsql($sql, $trata_erro);
                    }

                    //grc_evento_participante
                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante';
                    $sql .= ' where idt_atendimento = ' . null($rowMP['idt']);
                    $rsOrg = execsqlNomeCol($sql, $trata_erro);

                    $vetCampoRemove = Array(
                        'idt', 'idt_atendimento', 'ativo', 'vl_tot_pagamento'
                    );

                    foreach ($vetIdtFilho as $idt_at) {
                        foreach ($rsOrg->data as $rowOrg) {
                            //grc_evento_participante
                            $dados = Array();

                            foreach ($rsOrg->info['name'] as $campo) {
                                if (!in_array($campo, $vetCampoRemove)) {
                                    $dados[$campo] = $rowOrg[$campo];
                                }
                            }

                            $dados['idt_atendimento'] = $idt_at;

                            $vetCampoRemoveUpdate = Array('idt_atendimento');

                            $where = '';
                            $where .= ' idt_atendimento = ' . null($idt_at);

                            $whereUpdate = '';
                            $vetCampoExtra = Array();

                            MatriculaEventoCompostoSincronizaAcao('grc_evento_participante', 'idt', $where, $dados, $vetCampoExtra, $vetCampoRemoveUpdate, $whereUpdate, $trata_erro);
                        }
                    }
                }

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_participante';
                $sql .= ' where idt_atendimento = ' . null($rowMP['idt']);
                $rs = execsql($sql, $trata_erro);

                if ($rs->rows == 0) {
                    $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante (idt_atendimento) VALUES (' . null($rowMP['idt']) . ')';
                    execsql($sql, $trata_erro);
                }

                MatriculaEventoCompostoPag($rowMP['idt'], $trata_erro);
            }

            if ($rowMatPai['idt_instrumento'] != 54) {
                foreach ($rsEF->data as $rowEF) {
                    ajustaTotaisEvento($rowEF['idt'], $trata_erro);
                }
            }
        }

        if ($usaTransaction) {
            commit();
        }

        return '';
    } catch (Exception $e) {
        if ($usaTransaction) {
            rollBack();
        }

        if ($debug) {
            p($e);
        }

        return grava_erro_log('MatriculaEventoCompostoSincroniza', $e);
    }
}

/**
 * Cria a matricula do evento filho com base do evento pai (Evento Composto)
 * @access public
 * @return string IDT do Atendimento da matricula
 * @param string $matricula_obr <p>
 * Matricula Obrigatoria
 * </p>
 * @param int $idt_evento_filho <p>
 * IDT do Evento Filho
 * </p>
 * @param int $idt_atendimento_pai <p>
 * IDT do Atendimento (Matricula)
 * </p>
 * @param boolean $trata_erro <p>
 * Trata o erro do SQL.
 * </p>
 * */
function MatriculaEventoCompostoCria($matricula_obr, $idt_evento_filho, $idt_atendimento_pai, $trata_erro) {
    $sql = '';
    $sql .= ' select idt, idt_instrumento';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= ' where idt = ' . null($idt_evento_filho);
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];

    $sql = '';
    $sql .= ' select a.protocolo, p.cpf';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
    $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
    $sql .= ' where p.idt_atendimento = ' . null($idt_atendimento_pai);
    $sql .= " and p.tipo_relacao = 'L'";
    $rs = execsql($sql, $trata_erro);
    $rowp = $rs->data[0];

    $variavel = Array();
    $variavel['erro'] = "";
    $variavel['cpf'] = $rowp['cpf'];
    $variavel['idt_instrumento'] = $row['idt_instrumento'];
    $variavel['idt_pf'] = 0;
    $variavel['idt_evento'] = $row['idt'];
    $variavel['evento_origem'] = 'PIR';
    $variavel['bancoTransaction'] = 'N';
    $variavel['valida_vaga'] = 'N';

    define('CodigoMatriculaPaiEventoComposto', $rowp['protocolo']);
    define('idtAtendimentoPaiEventoComposto', $idt_atendimento_pai);

    BuscaCPF(0, $variavel);

    $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante (idt_atendimento, ativo) VALUES (' . null($variavel['idt_atendimento']) . ', ' . aspa($matricula_obr) . ')';
    execsql($sql, $trata_erro);

    return $variavel['idt_atendimento'];
}

/**
 * ajusta os valores replicados das tabela de Agenda e Insumo
 * @access public
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function ajustaTotaisEvento($idt_evento, $trata_erro = true) {
    $sql = '';
    $sql .= ' select e.idt_instrumento, e.composto, e.idt_evento_pai, p.tipo_calculo';
    $sql .= ' from grc_evento e';
    $sql .= ' left outer join grc_produto p on p.idt = e.idt_produto';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rsa = execsql($sql, $trata_erro);
    $rowe = $rsa->data[0];

    if ($rowe['idt_instrumento'] == 41 || $rowe['idt_instrumento'] == 45) {
        //Não tem agenda com isso não atualiza
    } else {
        $sql = '';
        $sql .= ' select min(ea.data_inicial) as dt_ini, max(ea.data_final) as dt_fim, min(ea.hora_inicial) as hr_ini, max(ea.hora_final) as hr_fim,';
        $sql .= ' sum(ea.carga_horaria) as carga_horaria, sum(ea.valor_hora * ea.carga_horaria) as custo, count(distinct ea.data_inicial) as qtd_dias_reservados';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rsa = execsql($sql, $trata_erro);
        $row_sum = $rsa->data[0];

        $sql = '';
        $sql .= ' select ei.custo_total';
        $sql .= ' from grc_evento_insumo ei';
        $sql .= ' where ei.idt_evento = ' . null($idt_evento);
        $sql .= " and ei.codigo = '71001'";
        $rsa = execsql($sql, $trata_erro);

        if ($rsa->rows > 0) {
            $row_sum['custo'] = $rsa->data[0][0];
        }

        $sql = '';
        $sql .= ' select ea.idt_cidade, ea.idt_local, c.desccid as cidade, l.descricao as local';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " inner join " . db_pir_siac . "cidade c on c.codcid = ea.idt_cidade";
        $sql .= " inner join grc_evento_local_pa l on l.idt = ea.idt_local";
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' order by ea.dt_ini limit 1';
        $rsa = execsql($sql, $trata_erro);
        $rowa = $rsa->data[0];

        if ($rowe['composto'] == 'S') {
            $sql = '';
            $sql .= ' select sum(carga_horaria_total) as tot';
            $sql .= ' from grc_evento';
            $sql .= ' where idt_evento_pai = ' . null($idt_evento);
            $rsa = execsql($sql, $trata_erro);
            $carga_horaria_total = $rsa->data[0][0];
        } else if ($rowe['idt_evento_pai'] != '' && $rowe['tipo_calculo'] != '') {
            $carga_horaria_total = false;
        } else {
            $carga_horaria_total = $row_sum['carga_horaria'];
        }

        $sql = '';
        $sql .= ' update grc_evento set';

        if ($rowe['idt_instrumento'] != 2) {
            $sql .= ' idt_cidade = ' . null($rowa['idt_cidade']) . ',';
            $sql .= ' idt_local = ' . null($rowa['idt_local']) . ',';
        }

        $sql .= ' dt_previsao_inicial = ' . aspa($row_sum['dt_ini']) . ',';
        $sql .= ' dt_previsao_fim = ' . aspa($row_sum['dt_fim']) . ',';
        $sql .= ' hora_inicio = ' . aspa($row_sum['hr_ini']) . ',';
        $sql .= ' hora_fim = ' . aspa($row_sum['hr_fim']) . ',';

        if ($carga_horaria_total !== false) {
            $sql .= ' carga_horaria_total = ' . null($carga_horaria_total) . ',';
        }

        $sql .= ' tot_hora_consultoria = ' . null($row_sum['carga_horaria']) . ',';
        $sql .= ' custo_tot_consultoria = ' . null($row_sum['custo']);
        $sql .= ' where idt = ' . null($idt_evento);
        execsql($sql, $trata_erro);
    }
}

/**
 * Calcula o valor do pagamento da matriculas no evento composto
 * @access public
 * @param int $idt_atendimento_pai <p>
 * IDT da Matricula
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function MatriculaEventoCompostoPag($idt_atendimento_pai, $trata_erro = true) {
    $sql = '';
    $sql .= ' select a.idt_evento, a.idt_instrumento';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
    $sql .= ' where a.idt = ' . null($idt_atendimento_pai);
    $rs = execsql($sql, $trata_erro);
    $rowMatPai = $rs->data[0];

    if ($rowMatPai['idt_instrumento'] == 54) {
        $sql = '';
        $sql .= ' select ep.idt, p.evento_cortesia, ep.ativo, ec.vl_matricula as valor_inscricao';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_combo ec on ec.idt_evento = a.idt_evento and ec.idt_evento_origem = ' . null($rowMatPai['idt_evento']);
        $sql .= ' left outer join ' . db_pir_grc . 'grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
        $sql .= ' where a.idt_atendimento_pai = ' . null($idt_atendimento_pai);
    } else {
        $sql = '';
        $sql .= ' select ep.idt, p.evento_cortesia, ep.ativo, e.valor_inscricao';
        $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento e on e.idt = a.idt_evento';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
        $sql .= ' where a.idt_atendimento_pai = ' . null($idt_atendimento_pai);
    }

    $rs = execsql($sql, $trata_erro);

    $vl = 0;

    foreach ($rs->data as $row) {
        if ($row['ativo'] == 'S' && $row['evento_cortesia'] == 'N') {
            $vl += $row['valor_inscricao'];
        }
    }

    $sql = 'update ' . db_pir_grc . 'grc_evento_participante set vl_tot_pagamento = ' . null($vl);
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento_pai);
    execsql($sql, $trata_erro);

    return $vl;
}

/**
 * Sincroniza a previsão por Mês com os valores das agendas das matriculas<br />
 * ATENÇÃO!!! Colocar a chamada desta função dentro de uma transação de banco (beginTransaction / commit)
 * @access public
 * @return tipo
 * @param int $idt_evento <p>
 * IDT do Evento
 * </p>
 * @param boolena $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function SincronizaHoraMesEventoComposto($idt_evento, $trata_erro = true) {
    $sql = '';
    $sql .= ' select inc_cliente_prev';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= ' where idt = ' . null($idt_evento);
    $rs = execsql($sql, $trata_erro);

    if ($rs->data[0][0] == 'S') {
        $sql = ' update ' . db_pir_grc . 'grc_evento_agenda_prev set ';
        $sql .= ' qtd = 0';
        $sql .= ' where idt_evento = ' . null($idt_evento);
        execsql($sql, $trata_erro);

        $sql = '';
        $sql .= " select date_format(ea.data_inicial, '%m/%Y') as mesano, sum(ea.carga_horaria) as qtd";
        $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ea';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= " group by date_format(ea.data_inicial, '%m/%Y')";
        $rs = execsql($sql, $trata_erro);

        foreach ($rs->data as $row) {
            $sql = ' update ' . db_pir_grc . 'grc_evento_agenda_prev set ';
            $sql .= ' qtd = ' . null($row['qtd']);
            $sql .= ' where idt_evento = ' . null($idt_evento);
            $sql .= ' and data = ' . aspa(trata_data('01/' . $row['mesano']));
            execsql($sql, $trata_erro);
        }
    }
}

/**
 * Cria o registro do Evento com base nos Atendimento Evento
 * @access public
 * @return int IDT do Evento criado
 * @param int $idt_atendimento_evento <p>
 * IDT do Atendimento Evento
 * </p>
 * */
function cria_atendimento_evento($idt_atendimento_evento) {
    global $vetConf;

    $sql = '';
    $sql .= ' select codigo';
    $sql .= ' from grc_evento';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        msg_erro('O Evento vinculado a este Atendimento já foi criado com o Código ' . $rs->data[0][0] . '! Com isso não podemos criar outro evento. Favor verificar se o evento esta de acordo com o Atendimento.');
    }

    $sql = '';
    $sql .= ' select idt_instrumento';
    $sql .= ' from grc_atendimento_evento';
    $sql .= ' where idt = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $idt_instrumento = $rs->data[0][0];

    $idt_evento = GravarEvento($idt_instrumento);

    $sql = 'update grc_atendimento_evento set idt_evento = ' . null($idt_evento);
    $sql .= ' where idt = ' . null($idt_atendimento_evento);
    execsql($sql);

    $sql = 'update grc_evento set idt_atendimento_evento = ' . null($idt_atendimento_evento);
    $sql .= ' where idt = ' . null($idt_evento);
    execsql($sql);

    $sql = '';
    $sql .= ' select ae.idt_atendimento, ae.idt_produto, ae.resumo_pag, ae.resumo_tot, ae.entrega_prazo_max, ae.contrapartida_sgtec, ae.idt_midia, e.data_criacao';
    $sql .= ' from grc_atendimento_evento ae';
    $sql .= ' inner join grc_evento e on e.idt = ae.idt_evento';
    $sql .= ' where ae.idt = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $rowDados = $rs->data[0];

    $vet = Array(
        'idt_projeto' => '',
        'idt_acao' => '',
        'idt_produto' => '',
        'idt_gestor_evento' => '',
        'objetivo' => '',
        'resultado_esperado' => '',
        'gestor_sge' => '',
        'fase_acao_projeto' => '',
        'idt_gestor_projeto' => '',
        'idt_unidade' => '',
        'idt_ponto_atendimento' => '',
        'idt_ponto_atendimento_tela' => '',
        'ano_competencia' => '',
        'qtd_previsto' => '',
        'qtd_realizado' => '',
        'qtd_percentual' => '',
        'qtd_saldo' => '',
        'orc_previsto' => '',
        'orc_realizado' => '',
        'orc_percentual' => '',
        'orc_saldo' => '',
        'entrega_prazo_max' => '',
        'vl_determinado' => '',
        'idt_foco_tematico' => '',
        'maturidade' => '',
        'descricao' => '',
        'idt_publico_alvo' => '',
        'idt_programa' => '',
        'cep' => '',
        'idt_cidade' => '',
        'valor_hora' => '',
        'custo_tot_consultoria' => $rowDados['resumo_tot'],
        'quantidade_participante' => '1',
        'cred_necessita_credenciado' => 'S',
        'cred_rodizio_auto' => 'S',
        'cred_credenciado_sgc' => 'N',
        'cred_contratacao_cont' => 'N',
        'temporario' => 'N',
        'idt_evento_situacao_ant' => 1,
        'contrapartida_sgtec' => $rowDados['contrapartida_sgtec'],
    );

    //insumo
    $sql = "select grc_pi.*, pr.idt_profissional from grc_produto_insumo grc_pi ";
    $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = grc_pi.idt_insumo ";
    $sql .= ' left outer join grc_produto_profissional pr on pr.idt = grc_pi.idt_produto_profissional';
    $sql .= " where grc_pi.idt_produto  = " . null($rowDados['idt_produto']);
    $sql .= " and grc_pp.sinal = " . aspa('S'); // despesa
    $sql .= " and grc_pi.ativo = " . aspa('S'); // ativo
    $rs = execsql($sql);

    $valor_hora = 0;

    ForEach ($rs->data as $row) {
        $idt_insumo = null($row['idt_insumo']);
        $idt_area_suporte = null($row['idt_area_suporte']);
        $idt_profissional = null($row['idt_profissional']);
        $codigo = aspa($row['codigo']);
        $descricao = aspa($row['descricao']);
        $ativo = aspa($row['ativo']);
        $detalhe = aspa($row['detalhe']);
        $quantidade = null($row['quantidade']);
        $qtd_automatico = aspa('S');
        $custo_unitario_real = null($row['custo_unitario_real']);
        $idt_insumo_unidade = null($row['idt_insumo_unidade']);
        $por_participante = aspa($row['por_participante']);
        $custo_total = null($row['custo_total']);
        $ctotal_minimo = null($row['ctotal_minimo']);
        $ctotal_maximo = null($row['ctotal_maximo']);
        $rtotal_minimo = null($row['rtotal_minimo']);
        $rtotal_maximo = null($row['rtotal_maximo']);
        $receita_total = null($row['receita_total']);

        if ($row['codigo'] == '70001') {
            $valor_hora += $row['custo_unitario_real'];
        }

        if ($row['codigo'] == '70004') {
            $qtd_automatico = aspa('N');
        }

        $sql_i = " insert into grc_evento_insumo ";
        $sql_i .= " (  ";
        $sql_i .= " qtd_automatico, ";
        $sql_i .= " idt_evento, ";
        $sql_i .= " idt_area_suporte, ";
        $sql_i .= " idt_profissional, ";
        $sql_i .= " idt_insumo, ";
        $sql_i .= " codigo, ";
        $sql_i .= " descricao, ";
        $sql_i .= " detalhe, ";
        $sql_i .= " ativo, ";
        $sql_i .= " quantidade, ";
        $sql_i .= " quantidade_evento, ";
        $sql_i .= " custo_unitario_real, ";
        $sql_i .= " idt_insumo_unidade, ";
        $sql_i .= " por_participante ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $qtd_automatico, ";
        $sql_i .= " $idt_evento, ";
        $sql_i .= " $idt_area_suporte, ";
        $sql_i .= " $idt_profissional, ";
        $sql_i .= " $idt_insumo, ";
        $sql_i .= " $codigo, ";
        $sql_i .= " $descricao, ";
        $sql_i .= " $detalhe, ";
        $sql_i .= " $ativo, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $custo_unitario_real, ";
        $sql_i .= " $idt_insumo_unidade, ";
        $sql_i .= " $por_participante ";
        $sql_i .= ") ";
        execsql($sql_i);
    }

    $vet['valor_hora'] = $valor_hora;

    $sql = '';
    $sql .= ' select idt_projeto, idt_acao, idt_produto, idt_gestor_evento, objetivo, resultado_esperado, gestor_sge, fase_acao_projeto,';
    $sql .= ' idt_gestor_projeto, idt_unidade, idt_ponto_atendimento, idt_ponto_atendimento_tela, ano_competencia, qtd_previsto, qtd_realizado,';
    $sql .= ' qtd_percentual, qtd_saldo, orc_previsto, orc_realizado, orc_percentual, orc_saldo, entrega_prazo_max, vl_determinado';
    $sql .= ' from grc_atendimento_evento';
    $sql .= ' where idt = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    foreach ($rs->info['name'] as $campo) {
        $vet[$campo] = $row[$campo];
    }

    $sql = '';
    $sql .= ' select p.idt_foco_tematico, m.descricao as maturidade, p.descricao, p.idt_publico_alvo, p.idt_programa';
    $sql .= ' from grc_produto p';
    $sql .= ' left outer join grc_produto_maturidade m on m.idt = p.idt_produto_maturidade';
    $sql .= ' where p.idt = ' . null($rowDados['idt_produto']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    foreach ($rs->info['name'] as $campo) {
        $vet[$campo] = $row[$campo];
    }

    $sql = '';
    $sql .= ' select logradouro_cep_e as cep';
    $sql .= ' from grc_atendimento_organizacao o';
    $sql .= ' where idt_atendimento = ' . null($rowDados['idt_atendimento']);
    $sql .= " and representa = 'S'";
    $sql .= " and desvincular = 'N'";
    $rs = execsql($sql);
    $row = $rs->data[0];

    foreach ($rs->info['name'] as $campo) {
        $vet[$campo] = $row[$campo];
    }

    $cep = $row['cep'];
    $cep = str_replace('.', '', $cep);
    $cep = str_replace('-', '', $cep);

    $sql = '';
    $sql .= ' select codcid as idt_cidade';
    $sql .= ' from ' . db_pir_gec . 'base_cep';
    $sql .= ' where cep = ' . aspa($cep);
    $sql .= ' and cep_situacao = 1';
    $rs = execsql($sql);
    $row = $rs->data[0];

    foreach ($rs->info['name'] as $campo) {
        $vet[$campo] = $row[$campo];
    }

    $vetSQL = Array();

    foreach ($vet as $key => $value) {
        $vetSQL[] = $key . ' = ' . aspa($value);
    }

    $sql = 'update grc_evento set ';
    $sql .= implode(', ', $vetSQL);
    $sql .= ' where idt = ' . null($idt_evento);
    execsql($sql);

    SincronizaProfissionalEvento($idt_evento);

    $sql = 'update grc_evento_insumo set custo_unitario_real = ' . null($rowDados['resumo_tot']);
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= " and codigo = '71001'";
    execsql($sql);

    //Matricula
    $sql = '';
    $sql .= ' select cpf';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($rowDados['idt_atendimento']);
    $sql .= " and tipo_relacao = 'L'";
    $rs = execsql($sql);
    $cpf = $rs->data[0][0];

    $parCPF = Array();
    $parCPF['erro'] = "";
    $parCPF['cpf'] = $cpf;
    $parCPF['idt_instrumento'] = $idt_instrumento;
    $parCPF['idt_pf'] = 0;
    $parCPF['idt_evento'] = $idt_evento;
    $parCPF['bancoTransaction'] = 'N';
    $parCPF['evento_origem'] = 'PIR';

    BuscaCPF(0, $parCPF);

    $sql = 'insert into grc_evento_participante (idt_atendimento, vl_tot_pagamento, idt_midia, contrato) VALUES (';
    $sql .= null($parCPF['idt_atendimento']) . ', ' . null($rowDados['resumo_pag']) . ', ' . null($rowDados['idt_midia']) . ", 'R')";
    execsql($sql);

    $sql = '';
    $sql .= ' select cnpj, dap, nirf, rmp, ie_prod_rural, sicab_codigo, idt_tipo_empreendimento, representa_codcargcli';
    $sql .= ' from grc_atendimento_organizacao o';
    $sql .= ' where idt_atendimento = ' . null($rowDados['idt_atendimento']);
    $sql .= " and representa = 'S'";
    $sql .= " and desvincular = 'N'";
    $rs = execsql($sql);
    $row = $rs->data[0];

    $parCNPJ = Array();
    $parCNPJ['erro'] = "";

    if (validaCNPJ($row['cnpj'])) {
        $parCNPJ['cnpj'] = FormataCNPJ($row['cnpj']);
    } else {
        $parCNPJ['cnpj'] = '';
    }

    $variavel['idt_tipo_empreendimento'] = $row['idt_tipo_empreendimento'];
    $parCNPJ['dap'] = $row['dap'];
    $parCNPJ['nirf'] = $row['nirf'];
    $parCNPJ['rmp'] = $row['rmp'];
    $parCNPJ['ie_prod_rural'] = $row['ie_prod_rural'];
    $parCNPJ['sicab_codigo'] = $row['sicab_codigo'];
    $parCNPJ['bancoTransaction'] = 'N';

    BuscaCNPJ($parCPF['idt_atendimento'], $parCNPJ);

    $sql = "update grc_atendimento_organizacao set";
    $sql .= " novo_registro = 'N',";
    $sql .= " representa = 'S',";
    $sql .= " modificado = 'S',";
    $sql .= " representa_codcargcli = " . null($row['representa_codcargcli']);
    $sql .= " where idt = " . null($parCNPJ['idt_atendimento_organizacao']);
    execsql($sql);

    $sql = "update grc_atendimento_pessoa set representa_empresa = 'S'";
    $sql .= " where idt = " . null($parCPF['idt_atendimento_pessoa']);
    execsql($sql);

    $idt_atendimento = $parCPF['idt_atendimento'];

    //Entregas
    $sql = '';
    $sql .= ' select idt, codigo, descricao, detalhe, percentual, ordem';
    $sql .= ' from grc_atendimento_evento_entrega';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $sql = '';
        $sql .= ' insert into grc_evento_entrega (idt_evento, idt_atendimento, codigo, descricao, detalhe, percentual, ordem) values (';
        $sql .= null($idt_evento) . ', ' . null($idt_atendimento) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
        $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
        execsql($sql);
        $idt_evento_entrega = lastInsertId();

        $sql = '';
        $sql .= ' insert into grc_evento_entrega_documento (idt_evento_entrega, idt_documento, codigo)';
        $sql .= ' select ' . $idt_evento_entrega . ' as idt_evento_entrega, idt_documento, codigo';
        $sql .= ' from grc_atendimento_evento_entrega_documento';
        $sql .= ' where idt_atendimento_evento_entrega = ' . null($row['idt']);
        execsql($sql);
    }

    //Dimensionamento
    $sql = '';
    $sql .= ' insert into grc_evento_dimensionamento (idt_evento, idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, qtd, vl_total)';
    $sql .= ' select ' . $idt_evento . ' as idt_evento, ' . $idt_atendimento . ' as idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, qtd, vl_total';
    $sql .= ' from grc_atendimento_evento_dimensionamento';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    execsql($sql);

    //Pagamentos
    $sql = '';
    $sql .= ' insert into grc_evento_participante_pagamento (idt_atendimento, idt_evento_situacao_pagamento, data_vencimento, data_pagamento, valor_pagamento, idt_evento_natureza_pagamento, idt_evento_cartao_bandeira, idt_evento_forma_parcelamento, codigo_nsu, idt_evento_estabelecimento, idt_evento_participante_contrato, estornado, estornar_rm, origem_reg, lojasiac_id, rm_idmov, ch_numero, ch_banco, ch_agencia, ch_cc, emitente_nome, emitente_tel, usa_parceiro, par_cnpj, par_razao_social, par_nome_fantasia, par_cep, par_rua, par_numero, par_bairro, par_cidade, par_estado)';
    $sql .= ' select ' . $idt_atendimento . ' as idt_atendimento, idt_evento_situacao_pagamento, data_vencimento, data_pagamento, valor_pagamento, idt_evento_natureza_pagamento, idt_evento_cartao_bandeira, idt_evento_forma_parcelamento, codigo_nsu, idt_evento_estabelecimento, idt_evento_participante_contrato, estornado, estornar_rm, origem_reg, lojasiac_id, rm_idmov, ch_numero, ch_banco, ch_agencia, ch_cc, emitente_nome, emitente_tel, usa_parceiro, par_cnpj, par_razao_social, par_nome_fantasia, par_cep, par_rua, par_numero, par_bairro, par_cidade, par_estado';
    $sql .= ' from grc_atendimento_evento_pagamento';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    execsql($sql);

    //Conta Devolução
    $sql = '';
    $sql .= ' insert into grc_evento_participante_contadevolucao (idt_atendimento, codigo, descricao, inc_pag_rm, banco_numero, banco_nome, agencia_numero, agencia_digito, cc_numero, cc_digito, cpfcnpj, razao_social, vl_pago, vl_devolucao, rm_codcfo, rm_idpgto)';
    $sql .= ' select ' . $idt_atendimento . ' as idt_atendimento, codigo, descricao, inc_pag_rm, banco_numero, banco_nome, agencia_numero, agencia_digito, cc_numero, cc_digito, cpfcnpj, razao_social, vl_pago, vl_devolucao, rm_codcfo, rm_idpgto';
    $sql .= ' from grc_atendimento_evento_contadevolucao';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    execsql($sql);

    $sql = '';
    $sql .= ' select count(x.idt_atendimento) as qtd, avg(x.pag) as media';
    $sql .= ' from (';
    $sql .= ' select a.idt as idt_atendimento, sum(p.valor_pagamento) as pag';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante_pagamento p on p.idt_atendimento = a.idt';
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' where a.idt_evento = ' . null($idt_evento);
    $sql .= " and (p.estornado is null or p.estornado <> 'S')";
    $sql .= whereEventoParticipante();
    $sql .= ' group by a.idt';
    $sql .= ' ) x';
    $rs = execsql($sql);
    $rowu = $rs->data[0];

    $tot = $rowu['qtd'] * $rowu['media'];

    $sql = 'update grc_evento set valor_inscricao = ' . null($rowu['media']);
    $sql .= ', quantidade_participante = ' . null($rowu['qtd']);
    $sql .= ', previsao_receita = ' . null($tot);
    $sql .= " where idt = " . null($idt_evento);
    execsql($sql);

    $sql = 'update grc_evento_insumo set';
    $sql .= ' quantidade = 1, ';
    $sql .= ' quantidade_evento = ' . null($rowu['qtd']) . ', ';
    $sql .= ' custo_unitario_real = ' . null($rowu['media']) . ', ';
    $sql .= ' rtotal_minimo = ' . null($tot) . ', ';
    $sql .= ' rtotal_maximo = ' . null($tot) . ', ';
    $sql .= ' receita_total = ' . null($tot);
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= " and codigo = 'evento_insc'";
    execsql($sql);

    CalcularInsumoEvento($idt_evento);

    return $idt_evento;
}

function sincronizaAgendaEventoSG($idt_gec_contratacao_credenciado_ordem, $idt_evento) {
    $sql = '';
    $sql .= ' select e.sgtec_modelo, p.tipo_ordem';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join ' . db_pir_gec . 'gec_programa p on p.idt = e.idt_programa';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rst = execsql($sql);
    $rowe = $rst->data[0];

    if ($rowe['tipo_ordem'] == 'SG' && $rowe['sgtec_modelo'] == 'E') {
        //Entregas
        $sql = '';
        $sql .= ' select ea.idt, ea.idt_atendimento, ea.codigo, ea.descricao, ea.detalhe, ea.percentual, ea.ordem';
        $sql .= ' from grc_evento_entrega ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        $rs = execsql($sql);

        $vetNaoDeleta = Array();
        $vetNaoDeleta[] = 0;

        foreach ($rs->data as $row) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
            $sql .= ' and idt_atendimento = ' . null($row['idt_atendimento']);
            $sql .= ' and codigo = ' . aspa($row['codigo']);
            $rst = execsql($sql);

            if ($rst->rows == 0) {
                $sql = '';
                $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega (idt_gec_contratacao_credenciado_ordem, idt_atendimento, codigo, descricao, detalhe, percentual, ordem) values (';
                $sql .= null($idt_gec_contratacao_credenciado_ordem) . ', ' . null($row['idt_atendimento']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
                $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
                execsql($sql);
                $idt_gec_contratacao_credenciado_ordem_entrega = lastInsertId();

                $sql = '';
                $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega_documento (idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo)';
                $sql .= ' select ' . $idt_gec_contratacao_credenciado_ordem_entrega . ' as idt_gec_contratacao_credenciado_ordem_entrega, idt_documento, codigo';
                $sql .= ' from grc_evento_entrega_documento';
                $sql .= ' where idt_evento_entrega = ' . null($row['idt']);
                execsql($sql);

                $vetNaoDeleta[] = $idt_gec_contratacao_credenciado_ordem_entrega;
            } else {
                $vetNaoDeleta[] = $rst->data[0][0];
            }
        }

        $sql = '';
        $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
        $sql .= ' and idt not in (' . implode(', ', $vetNaoDeleta) . ')';
        execsql($sql);
    } else {
        $sql = '';
        $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
        execsql($sql);

        $sql = '';
        $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
        execsql($sql);

        $sql = '';
        $sql .= ' select idt_produto_tipo';
        $sql .= ' from grc_produto';
        $sql .= ' where idt = ' . null($idt_produto);
        $rstt = execsql($sql);

        switch ($rstt->data[0][0]) {
            case 1: //Instrutoria
                $tipo = 'I';
                break;

            case 2: //Consultoria
                $tipo = 'C';
                break;

            default: //Consultoria/Instrutoria
                $tipo = 'I';
                break;
        }

        $sql = '';
        $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda (idt_gec_contratacao_credenciado_ordem, tipo, dt_ini, dt_fim, tot_hora, obs)';
        $sql .= " select {$idt_gec_contratacao_credenciado_ordem} as idt_gec_contratacao_credenciado_ordem, '{$tipo}' as tipo, ea.dt_ini, ea.dt_fim, ea.carga_horaria as tot_hora, ea.observacao as obs";
        $sql .= ' from grc_evento_agenda ea';
        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
        $sql .= ' where ea.idt_evento = ' . null($idt_evento);
        $sql .= whereEventoParticipante();
        execsql($sql);

        $sql = '';
        $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
        $sql .= " and tipo = 'C'";
        $rsa = execsql($sql);
        $rowa = $rsa->data[0];

        $sql = '';
        $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
        $sql .= ' agenda_consultoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
        $sql .= ' agenda_consultoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
        $sql .= ' agenda_consultoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
        $sql .= ' agenda_consultoria_tot_hora = ' . null($rowa['tot_hora']);
        $sql .= ' where idt = ' . null($idt_gec_contratacao_credenciado_ordem);
        execsql($sql);

        $sql = '';
        $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($idt_gec_contratacao_credenciado_ordem);
        $sql .= " and tipo = 'I'";
        $rsa = execsql($sql);
        $rowa = $rsa->data[0];

        $sql = '';
        $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
        $sql .= ' agenda_instrutoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
        $sql .= ' agenda_instrutoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
        $sql .= ' agenda_instrutoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
        $sql .= ' agenda_instrutoria_tot_hora = ' . null($rowa['tot_hora']);
        $sql .= ' where idt = ' . null($idt_gec_contratacao_credenciado_ordem);
        execsql($sql);
    }
}

function grc_evento_participante_msgParametros($txt, $protocolo, $rowe) {
    $txt = str_replace('#protocolo#', $protocolo, $txt);
    $txt = str_replace('#data#', date('d/m/Y H:i:s'), $txt);

    $sql = '';
    $sql .= ' select nome_completo';
    $sql .= ' from plu_usuario';
    $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
    $rs = execsql($sql);
    $txt = str_replace('#solicitante#', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select nome_completo';
    $sql .= ' from plu_usuario';
    $sql .= ' where id_usuario = ' . null($rowe['idt_gestor_evento']);
    $rs = execsql($sql);
    $txt = str_replace('#evento_responsavel#', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
    $rs = execsql($sql);
    $txt = str_replace('#ponto_atendimento#', $rs->data[0][0], $txt);

    $txt = str_replace('#codigo#', $rowe['codigo'], $txt);

    $sql = '';
    $sql .= ' select desccid';
    $sql .= ' from ' . db_pir_siac . 'cidade';
    $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
    $rs = execsql($sql);
    $txt = str_replace('#cidade#', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from grc_evento_local_pa';
    $sql .= ' where idt = ' . null($rowe['idt_local']);
    $rs = execsql($sql);
    $txt = str_replace('#local#', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from grc_evento_situacao';
    $sql .= ' where idt = ' . null($_POST['situacao']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from grc_evento_situacao';
        $sql .= ' where idt = ' . null($rowe['idt_evento_situacao']);
        $rs = execsql($sql);
    }

    $txt = str_replace('#situacao#', $rs->data[0][0], $txt);

    $txt = str_replace('#instrumento#', $rowe['instrumento'], $txt);
    $txt = str_replace('#descricao#', $rowe['descricao'], $txt);
    $txt = str_replace('#dt_previsao_inicial#', trata_data($rowe['dt_previsao_inicial']), $txt);
    $txt = str_replace('#dt_previsao_fim#', trata_data($rowe['dt_previsao_fim']), $txt);
    $txt = str_replace('#hora_inicio#', $rowe['hora_inicio'], $txt);
    $txt = str_replace('#hora_fim#', $rowe['hora_fim'], $txt);
    $txt = str_replace('#observacao#', $rowe['observacao'], $txt);
    $txt = str_replace('#previsao_receita#', format_decimal($rowe['previsao_receita']), $txt);
    $txt = str_replace('#previsao_despesa#', format_decimal($rowe['previsao_despesa']), $txt);

    $txt = str_replace('#nome_pessoa#', $rowe['nome_pessoa'], $txt);
    $txt = str_replace('#numero_voucher#', $rowe['numero_voucher'], $txt);
    $txt = str_replace('#validade_voucher#', trata_data($rowe['validade_voucher']), $txt);
    $txt = str_replace('#desconto_voucher#', format_decimal($rowe['desconto_voucher']), $txt);

    return $txt;
}

function grc_evento_dep_msgParametros($txt, $protocolo, $rowe) {
    $txt = str_replace('#protocolo', $protocolo, $txt);
    $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

    $sql = '';
    $sql .= ' select nome_completo';
    $sql .= ' from plu_usuario';
    $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
    $rs = execsql($sql);
    $txt = str_replace('#solicitante', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select nome_completo';
    $sql .= ' from plu_usuario';
    $sql .= ' where id_usuario = ' . null($rowe['idt_gestor_evento']);
    $rs = execsql($sql);
    $txt = str_replace('#evento_responsavel', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
    $rs = execsql($sql);
    $txt = str_replace('#ponto_atendimento', $rs->data[0][0], $txt);

    $txt = str_replace('#codigo', $rowe['codigo'], $txt);

    $sql = '';
    $sql .= ' select desccid';
    $sql .= ' from ' . db_pir_siac . 'cidade';
    $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
    $rs = execsql($sql);
    $txt = str_replace('#cidade', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from grc_evento_local_pa';
    $sql .= ' where idt = ' . null($rowe['idt_local']);
    $rs = execsql($sql);
    $txt = str_replace('#local', $rs->data[0][0], $txt);

    $sql = '';
    $sql .= ' select descricao';
    $sql .= ' from grc_evento_situacao';
    $sql .= ' where idt = ' . null($_POST['situacao']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from grc_evento_situacao';
        $sql .= ' where idt = ' . null($rowe['idt_evento_situacao']);
        $rs = execsql($sql);
    }

    $txt = str_replace('#situacao', $rs->data[0][0], $txt);

    $txt = str_replace('#instrumento', $rowe['instrumento'], $txt);
    $txt = str_replace('#descricao', $rowe['descricao'], $txt);
    $txt = str_replace('#dt_previsao_inicial', trata_data($rowe['dt_previsao_inicial']), $txt);
    $txt = str_replace('#dt_previsao_fim', trata_data($rowe['dt_previsao_fim']), $txt);
    $txt = str_replace('#hora_inicio', $rowe['hora_inicio'], $txt);
    $txt = str_replace('#hora_fim', $rowe['hora_fim'], $txt);
    $txt = str_replace('#observacao', $rowe['observacao'], $txt);
    $txt = str_replace('#previsao_receita', format_decimal($rowe['previsao_receita']), $txt);
    $txt = str_replace('#previsao_despesa', format_decimal($rowe['previsao_despesa']), $txt);

    return $txt;
}

function grc_evento_dep_situacao_6($idt_evento, $rowe) {
    $sql = '';
    $sql .= ' select ei.idt, ord.codigo';
    $sql .= ' from grc_evento_insumo ei';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ei.idt_ordem_contratacao = ord.idt';
    $sql .= ' where ei.idt_evento = ' . null($idt_evento);
    $sql .= " and (ei.codigo = '70001' or ei.codigo = '71001')";
    $sql .= ' and ei.cod_ordem_contratacao is null';
    $sql .= " and ord.ativo = 'S'";
    $rsx = execsql($sql);

    ForEach ($rsx->data as $rowx) {
        $codigo = $rowx['codigo'];

        if ($codigo == '') {
            $codigo = 'BA' . date('mY') . geraAutoNum(db_pir_gec, 'gec_contratacao_credenciado_ordem_codigo_BA' . date('mY'), 4);
        }

        $sql_a = ' update grc_evento_insumo set ';
        $sql_a .= ' cod_ordem_contratacao = ' . aspa($codigo);
        $sql_a .= ' where idt = ' . null($rowx['idt']);
        execsql($sql_a);
    }

    $situacao = decideAprovadorInicialEvento($rowe['idt_instrumento'], $rowe['idt_programa'], $rowe['dt_previsao_inicial'], $rowe['idt_gestor_projeto'], $rowe['idt_responsavel'], $rowe['idt_unidade'], $rowe['idt_ponto_atendimento'], $rowe['classificacao_unidade'], $rowe['previsao_despesa'], $rs_pendencia, $temCG, $temDI);

    $sql_a = ' update grc_atendimento_pendencia set ';
    $sql_a .= " idt_evento_situacao_para = " . null($situacao) . ",";
    $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
    $sql_a .= " dt_update = now(),";
    $sql_a .= " ativo  =  'N'";
    $sql_a .= ' where idt_evento  = ' . null($idt_evento);
    $sql_a .= " and ativo  =  'S'";
    $sql_a .= " and tipo   =  'Evento'";
    execsql($sql_a);

    $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
    execsql($sql_a);

    $sql_a = ' update grc_evento set ';
    $sql_a .= ' idt_evento_situacao  = ' . null($situacao);
    $sql_a .= ' where idt  = ' . null($idt_evento);
    $result = execsql($sql_a);

    $data_solucaow = date('d/m/Y');
    $assuntow = $rowe['descricao'];
    $observacaow = '[' . $rowe['instrumento'] . '] ' . $rowe['descricao'];

    foreach ($rs_pendencia->data as $row) {
        PendenciaAprovacao($idt_evento, $situacao, $rowe['idt_ponto_atendimento'], $row['id_usuario'], $data_solucaow, $assuntow, $observacaow, $rowe['codigo']);
    }

    $protocolo = date('dmYHis');

    $vetGRC_parametros = GRC_parametros();
    $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_03'], $protocolo, $rowe);
    $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_04'], $protocolo, $rowe);

    foreach ($rs_pendencia->data as $row) {
        $txt = $mensagem;
        $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

        enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
    }

    $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_13'], $protocolo, $rowe);
    $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_14'], $protocolo, $rowe);

    $sql = '';
    $sql .= ' select email, nome_completo';
    $sql .= ' from plu_usuario';
    $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $txt = $mensagem;
        $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

        enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
    }

    return $situacao;
}

function grc_evento_dep_situacao_24($idt_evento, $rowe) {
    if ($rowe['tipo_ordem'] == 'SG') {
        if ($rowe['sgtec_modelo'] == 'H') {
            $sql = '';
            $sql .= ' select gec_ol.idt_gec_contratacao_credenciado_ordem';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem gec_ord';
            $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ol on gec_ord.idt = gec_ol.idt_gec_contratacao_credenciado_ordem";
            $sql .= ' where gec_ord.idt_evento = ' . null($idt_evento);
            $sql .= " and gec_ol.ativo = 'S'";
            $sql .= " and gec_ord.ativo = 'S'";
            $rsi = execsql($sql);

            if ($rsi->rows > 0) {
                $rowi = $rsi->data[0];
                sincronizaAgendaEventoSG($rowi['idt_gec_contratacao_credenciado_ordem'], $idt_evento);
            }

            atualizaPagEventoSG($idt_evento);
        } else {
            $automatico = true;
            $usa_rodizio = true;
            $variavel = array();
            $ret = GEC_contratacao_credenciado_ordem($idt_evento, $variavel, $automatico, $usa_rodizio, false);

            if ($variavel['erro'] != '') {
                rollBack();

                foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
                    $chave_origem = 'GC' . $ordem_codigo;
                    $mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
                    $vetIdMov = Array();

                    $sql = '';
                    $sql .= ' select rm.rm_idmov';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
                    $sql .= ' where o.codigo = ' . aspa($ordem_codigo);
                    $sql .= ' and rm.rm_idmov is not null';
                    $rstt = execsql($sql);

                    foreach ($rstt->data as $rowtt) {
                        $vetIdMov[] = $rowtt['rm_idmov'];
                    }

                    CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
                }

                $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
                erro_try($variavel['erro'], 'evento_ordem_sg');
                msg_erro($variavel['erro']);
            }
        }

        $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
        execsql($sql_a);

        $sql_a = ' update grc_evento set ';
        $sql_a .= ' idt_evento_situacao  =  24';
        $sql_a .= ' where idt  = ' . null($idt_evento);
        $result = execsql($sql_a);
    }
}

/**
 * Utilizado para alterar o html da TD grc_evento_agenda no cadastro_conf/grc_evento_atividade_valida.php
 * @access public
 * */
function ftd_alt_atividade($valor, &$row, $Campo) {
    global $vetSimNao, $acao;

    $html = '';

    switch ($Campo) {
        case 'data_inicial_real':
            if ($row['data_inicial_real'] == '') {
                $row['data_inicial_real'] = $row['data_inicial'];
            }

            if ($acao == 'con') {
                $html = trata_data($row['data_inicial_real']);
            } else {
                $html = '<input value="' . trata_data($row['data_inicial_real']) . '" name="dados[' . $row['idt'] . '][data_inicial_real]" type="text" class="Texto DT Obr" maxlength="10" size="10" onkeyup="return Formata_Data(this,event)" onblur="return checkdate(this)">';
            }
            break;

        case 'hora_inicial_real':
            if ($row['hora_inicial_real'] == '') {
                $row['hora_inicial_real'] = $row['hora_inicial'];
            }

            if ($acao == 'con') {
                $html = $row['hora_inicial_real'];
            } else {
                $html = '<input value="' . $row['hora_inicial_real'] . '" name="dados[' . $row['idt'] . '][hora_inicial_real]" type="text" class="Texto HI Obr" onkeyup="return Formata_Hora(this,event)" onblur="return Valida_Hora(this)" maxlength="5" size="5">';
            }
            break;

        case 'hora_final_real':
            if ($row['hora_final_real'] == '') {
                $row['hora_final_real'] = $row['hora_final'];
            }

            if ($acao == 'con') {
                $html = $row['hora_final_real'];
            } else {
                $html = '<input value="' . $row['hora_final_real'] . '" name="dados[' . $row['idt'] . '][hora_final_real]" type="text" class="Texto HF Obr" onkeyup="return Formata_Hora(this,event)" onblur="return Valida_Hora(this)" maxlength="5" size="5">';
            }
            break;

        case 'obs_real':
            if ($acao == 'con') {
                $html = $valor;
            } else {
                $html = '<input value="' . $valor . '" name="dados[' . $row['idt'] . '][obs_real]" type="text" class="Texto" maxlength="255" size="60">';
            }
            break;

        case 'carga_horaria_real':
            $dt_ini = $row['data_inicial_real'] . ' ' . $row['hora_inicial_real'];
            $dt_fim = $row['data_inicial_real'] . ' ' . $row['hora_final_real'];
            $html = format_decimal(diffDate($dt_ini, $dt_fim, 'H'));
            break;
    }

    return $html;
}

/**
 * Galeria do Produto
 * Utilizado para alterar o html do cadastro_conf/grc_produto.php
 * @access public
 * */
function ftd_grc_produto_galeria($valor, $row, $campo) {
    global $dir_file;

    $html = '';

    switch ($campo) {
        case 'conteudo':
            if ($row['link'] != '') {
                $html .= "<a href='http://" . $row['link'] . "' target='_blank' class='FileLink'>http://" . $row['link'] . "</a>";
                $html .= "<br />";
            }

            if ($row['arquivo'] != '') {
                $path = $dir_file . '/grc_produto_galeria/';

                $vetImagemProdPrefixo = explode('_', $row['arquivo']);
                $ImagemProdPrefixo = '';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                $html .= ArquivoLink($path, $row['arquivo'], $ImagemProdPrefixo, '', '', true);
                $html .= "<br />";
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Galeria do Evento
 * Utilizado para alterar o html do cadastro_conf/grc_evento.php
 * @access public
 * */
function ftd_grc_evento_galeria($valor, $row, $campo) {
    global $dir_file;

    $html = '';

    switch ($campo) {
        case 'conteudo':
            if ($row['link'] != '') {
                $html .= "<a href='http://" . $row['link'] . "' target='_blank' class='FileLink'>http://" . $row['link'] . "</a>";
                $html .= "<br />";
            }

            if ($row['arquivo'] != '') {
                $path = $dir_file . '/grc_evento_galeria/';

                $vetImagemProdPrefixo = explode('_', $row['arquivo']);
                $ImagemProdPrefixo = '';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';

                $html .= ArquivoLink($path, $row['arquivo'], $ImagemProdPrefixo, '', '', true);
                $html .= "<br />";
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Envia o e-Mail para o Credenciado / Gestor do Evento com a Lista de Preseça
 * @access public
 * @return array Com as mensagem de erros
 * @param array $vetDados <p>
 * Vetor com as informações para a geração / envio da Lista de Presença<br />
 * Informações do vetor:<br />
 * <b>id</b>: IDT do Evento<br />
 * <b>linha_vazia</b>: Colocar linhas em branco até o limite de vagas? | S: Sim ou N: Não<br />
 * <b>concluio</b>: Concluinte? | Vazio: Todos, S: Sim ou N: Não<br />
 * <b>contrato</b>: Situações do Contrato. | R: Rascunho, A: Em Assinatura, C: Concluido, G: Gratuito, S: SiacWeb ou IC: Inscrição Cancelada
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function enviaEmailEventoAcompanharLista($vetDados, $trata_erro = true) {
    $vetErro = Array();

    $vetGRC_parametros = GRC_parametros();
    $assunto = $vetGRC_parametros['grc_evento_acompanhar_lista_01'];
    $mensagem = $vetGRC_parametros['grc_evento_acompanhar_lista_02'];

    $sql = '';
    $sql .= ' select e.codigo, e.descricao, ug.email, ug.nome_completo, urc.email as urc_email, urc.nome_completo as urc_nome_completo';
    $sql .= ' from grc_evento e';
    $sql .= ' left outer join plu_usuario ug on ug.id_usuario = e.idt_gestor_evento';
    $sql .= ' left outer join plu_usuario urc on urc.id_usuario = e.idt_responsavel_consultor';
    $sql .= ' where e.idt = ' . null($vetDados['id']);
    $rs = execsql($sql, $trata_erro);
    $rowe = $rs->data[0];

    $assunto = str_replace('#codigo_evento#', $rowe['codigo'], $assunto);
    $assunto = str_replace('#descricao_evento#', $rowe['descricao'], $assunto);

    $mensagem = str_replace('#codigo_evento#', $rowe['codigo'], $mensagem);
    $mensagem = str_replace('#descricao_evento#', $rowe['descricao'], $mensagem);

    $vetEnviar = Array();
    $vetEnviar[$rowe['email']] = $rowe['nome_completo'];
    $vetEnviar[$rowe['urc_email']] = $rowe['urc_nome_completo'];

    //fornecedores contratados e/ou convidados
    $sql = '';
    $sql .= " select distinct gec_o.descricao as organizacao, usu_o.email as organizacao_email, gec_c.descricao as pessoa, usu_c.email as pessoa_email";
    $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_lst";
    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem gec_ord on gec_lst.idt_gec_contratacao_credenciado_ordem = gec_ord.idt";
    $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_lst.idt_organizacao = gec_o.idt";
    $sql .= " left outer join " . db_pir_gec . "plu_usuario usu_o on gec_o.codigo = usu_o.login";
    $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_c on gec_lst.idt_primeiro = gec_c.idt";
    $sql .= " left outer join " . db_pir_gec . "plu_usuario usu_c on gec_c.codigo = usu_c.login";
    $sql .= ' where gec_ord.idt_evento = ' . null($vetDados['id']);
    $sql .= " and gec_ord.ativo = 'S'";
    $sql .= " and gec_lst.ativo = 'S'";
    $rs = execsql($sql, $trata_erro);

    foreach ($rs->data as $row) {
        if ($row['organizacao_email'] != '') {
            $vetEnviar[$row['organizacao_email']] = $row['organizacao'];
        } else {
            $vetEnviar[$row['pessoa_email']] = $row['pessoa'];
        }
    }

    $pathPDF = sys_get_temp_dir() . DIRECTORY_SEPARATOR;
    $arqPDF = 'lista_presenca_' . $rowe['codigo'] . '.pdf';

    $vetArquivos[] = Array(
        'dirorigem' => $pathPDF,
        'arquivo' => $arqPDF,
    );

    $requestORG = $_REQUEST;
    $_REQUEST = $vetDados;

    $_REQUEST['prefixo'] = 'cadastro';
    $_REQUEST['menu'] = 'grc_evento_acompanhar_lista';
    $_REQUEST['titulo_rel'] = 'Lista de Presença';
    $_REQUEST['print_tela'] = 'S';

    salvaPDF($pathPDF . $arqPDF);
    $_REQUEST = $requestORG;

    foreach ($vetEnviar as $email => $nome) {
        if ($email != '') {
            if ($nome == '') {
                $nome = $email;
            }

            $vetRegProtocolo = Array(
                'origem' => 'grc_evento_acompanhar_lista_0102',
            );
            $vetErro[] = enviarEmail(db_pir_pfo, $assunto, $mensagem, $email, $nome, true, $vetRegProtocolo, '', '', $trata_erro, $vetArquivos);
        }
    }

    fclose($pathPDF . $arqPDF);
}

/**
 * Função auxilixar para a função cria_rascunho_produto
 * @access public
 * @return array
 * @param string $tabela_pai <p>
 * Nome da tabela pai
 * </p>
 * @param string $campo_pai <p>
 * Campo que faz a ligação com a tabela pai
 * </p>
 * @param boolean $tem_idt_produto <p>
 * Tem o campo idt_produto
 * </p>
 * */
function vetCopia($tabela_pai, $campo_pai, $tem_idt_produto) {
    $vet = Array();

    $vet['tabela_pai'] = $tabela_pai;
    $vet['campo_pai'] = $campo_pai;
    $vet['tem_idt_produto'] = $tem_idt_produto;

    return $vet;
}

//Vetor da ordem de copia da Produto
$vetCopiaProduto = Array();
$vetCopiaProduto['grc_produto'] = vetCopia('grc_produto', 'idt', false);
$vetCopiaProduto['grc_produto_insumo'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_realizador'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_conteudo_programatico'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_produto'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_profissional'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_arquivo_associado'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_area_conhecimento'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_entrega'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_entrega_documento'] = vetCopia('grc_produto_entrega', 'idt_produto_entrega', false);
$vetCopiaProduto['grc_produto_unidade_regional'] = vetCopia('grc_produto', 'idt_produto', false);
$vetCopiaProduto['grc_produto_versao'] = vetCopia('grc_produto', 'idt_produto', false);

/**
 * Cria o registro rascunho da endidade
 * @access public
 * @return int|string Retorna o IDT do registro de rascunho criado ou uma mensagem de erro
 * @param int $idt_produto <p>
 * IDT da Produto
 * </p>
 * */
function copiar_produto($idt_produto) {
    global $vetCopiaProduto;

    $vetIDT = Array();
    $vetIDT['grc_produto'][$idt_produto] = '';

    foreach ($vetCopiaProduto as $tabela => $coluna) {
        $lst = array_keys($vetIDT[$coluna['tabela_pai']]);

        if (is_array($lst)) {

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . $tabela;
            $sql .= ' where ' . $coluna['campo_pai'] . ' in (' . implode(', ', $lst) . ')';

            if ($coluna['tem_idt_produto']) {
                $sql .= ' and idt_produto = ' . null($idt_produto);
            }

            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $campos = $rs->info['name'];
                $campos = array_flip($campos);
                unset($campos['idt']);
                $campos = array_flip($campos);

                foreach ($rs->data as $row) {
                    $vetVL = Array();

                    foreach ($campos as $col) {
                        $vetVL[$col] = aspa($row[$col]);
                    }

                    switch ($tabela) {
                        case 'grc_produto':
                            $sqlt = "select grc_p.copia from grc_produto grc_p ";
                            $sqlt .= " where grc_p.codigo = " . $vetVL['codigo'];
                            $sqlt .= " order by copia desc limit 1";
                            $rst = execsql($sqlt);

                            $vetVL['copia'] = $rst->data[0][0] + 1;
                            $vetVL['idt_produto_situacao'] = 4;

                            break;

                        case 'grc_produto_entrega':

                            $tabela_c = 'grc_produto_entrega';
                            $Campo_c = 'codigo';
                            $tam_c = 11;
                            $codigow = numerador_arquivo($tabela_c, $Campo_c, $tam_c);
                            $codigo_c = 'TA' . $codigow;
                            $vetVL['codigo'] = aspa($codigo_c);

                            break;
                    }

                    if (array_key_exists($coluna['campo_pai'], $vetVL)) {
                        $vetVL[$coluna['campo_pai']] = aspa($vetIDT[$coluna['tabela_pai']][$row[$coluna['campo_pai']]]);
                    }

                    if ($coluna['tem_idt_produto']) {
                        $vetVL['idt_produto'] = aspa($vetIDT['grc_produto'][$row['idt_produto']]);
                    }

                    $sql = 'insert into ' . $tabela . ' (' . implode(', ', $campos) . ') values (' . implode(', ', $vetVL) . ')';
                    execsql($sql);
                    $vetIDT[$tabela][$row['idt']] = lastInsertId();
                }
            }
        }
    }

    $idt_produto_novo = $vetIDT['grc_produto'][$idt_produto];

    return $idt_produto_novo;
}

function GravaComunicacao(&$vetParametros) {
    DadosEstacao($vetParametros);
    //
    DadosUsuario($vetParametros);

    $tabela = 'grc_comunicacao';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'CC' . $codigow;
    $descricao = aspa($vetParametros['descricao']);
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $protocolo = aspa($codigo);


    $emitente_nome = $vetParametros['emitente_nome'];
    $emitente_email = $vetParametros['emitente_email'];
    $emitente_login = $vetParametros['emitente_login'];
    $emitente_sms = $vetParametros['emitente_sms'];

    $login_e = aspa($emitente_login);
    $nome_e = aspa($emitente_nome);
    $email_e = aspa($emitente_email);
    $sms_e = aspa($emitente_sms);
    $sms_enum = str_replace('(', '', $sms_e);
    $sms_enum = str_replace(')', '', $sms_enum);
    $sms_enum = str_replace('.', '', $sms_enum);
    $sms_enum = str_replace('-', '', $sms_enum);
    $sms_enum = str_replace(' ', '', $sms_enum);
    $sms_enum = null($sms_enum);



    $datahora = aspa(($datadia));
    $ip = aspa($_SERVER['REMOTE_ADDR']);
    $macroprocesso = 'null';
    $anonimo_nome = 'null';
    $anomimo_email = 'null';


    $navegador = aspa($vetParametros['navegador']);
    $tipo_dispositivo = aspa($vetParametros['mobile']);
    $modelo = aspa($vetParametros['modelo']);


    $tipo_informacao = aspa('NA');
    $tipo_solicitacao = aspa($vetParametros['tipo_solicitacao']);


    $latitude = $_SESSION[CS]['latitude'];
    $longitude = $_SESSION[CS]['longitude'];
    if ($latitude == "") {
        $latitude = 0;
    }
    if ($longitude == "") {
        $longitude = 0;
    }
    if ($latitude == 0 and $longitude == 0) {
        $lalo = "Coordnada geográficas Não identificada";
    }


    $status = aspa('A');
    $titulo = aspa($vetParametros['titulo_trans']);
    $descricao = aspa($vetParametros['descricao_trans']);
    $cpf = $vetParametros['cpf'];
    $emailT = $vetParametros['email'];
    $telefone = $vetParametros['telefone'];

    $quando = $vetParametros['quando'];
    $prazo = $vetParametros['prazo'];
    $data_enviar = $vetParametros['data_enviar'];

    $complemento = "";

    /*
      $nome_completo = $_SESSION[CS]['g_nome_completo'];
      $complemento .= "NOME: {$nome_completo}<br />";
      $complemento .= "CPF: {$cpf} TELEFONE: {$telefone} EMAIL: {$emailT}";


      $gec_en_credenciado_nan = $vetParametros['credenciado_nan'];

      if ($gec_en_credenciado_nan == 'S') {
      $tutor = $vetParametros['tutor'];
      $empresa_executora = $vetParametros['empresa_executora'];
      $ponto_atendimento = $vetParametros['ponto_atendimento'];
      $contrato = $vetParametros['contrato'];
      $complemento .= "<br /><br />";
      $complemento .= "-> AGENTE DE ORIENTAÇÃO EMPRESARIAL - AOE<br /><br />";
      $complemento .= "EMPRESA EXEECUTORA: {$empresa_executora}<br />";
      $complemento .= "TUTOR: {$tutor}<br />";
      $complemento .= "PONTO ATENDIMENTO: {$ponto_atendimento}<br />";
      $complemento .= "CONTRATO: {$contrato}<br />";
      }


      $matricula = $vetParametros['matricula'];
      if ($matricula != '') {
      $secao = $vetParametros['secao'];
      $cargo = $vetParametros['cargo'];
      $complemento .= "<br /><br />";
      $complemento .= "-> COLABORADOR DO SEBRAE<br /><br />";
      $complemento .= "SEÇÃO: {$secao}<br />";
      $complemento .= "CARGO: {$cargo}<br />";
      $complemento .= "MATRÍCULA: {$matricula}<br />";
      }
     */
    $complemento = aspa($complemento);

    $idt_externo = null($vetParametros['idt_externo']);
    $processo = aspa($vetParametros['processo']);
    $protocolo_agenda = aspa($vetParametros['protocolo_agenda']);



    $cliente_nomew = $vetParametros['destinatario_nome'];
    $cliente_emailw = $vetParametros['destinatario_email'];
    $cliente_smsw = $vetParametros['destinatario_sms'];
    /*
      if ($idt_externo > 0) {
      // buscar nome e email do cliente destino
      $sql = " select cliente_texto, email ";
      $sql .= " from grc_atendimento_agenda ";
      $sql .= ' where  idt = ' . null($idt_externo);
      $rs = execsql($sql);
      if ($rs->rows != 1) {
      // erro;
      } else {
      ForEach ($rs->data as $row) {
      $cliente_nomew = $row['cliente_texto'];
      $cliente_emailw = $row['email'];
      }
      }
      }
     */
    $cliente_nome = aspa($cliente_nomew);
    $cliente_email = aspa($cliente_emailw);
    $cliente_sms = aspa($cliente_smsw);
    $cliente_sms_num = str_replace('(', '', $cliente_smsw);
    $cliente_sms_num = str_replace(')', '', $cliente_sms_num);
    $cliente_sms_num = str_replace('.', '', $cliente_sms_num);
    $cliente_sms_num = str_replace('-', '', $cliente_sms_num);
    $cliente_sms_num = str_replace(' ', '', $cliente_sms_num);
    $cliente_sms_num = null($cliente_sms_num);
    //
    $quando = aspa($vetParametros['quando']);
    $prazo = null($vetParametros['prazo']);
    $data_enviar = aspa(trata_data($vetParametros['data_enviar']));
    $pendente_envio = aspa('S');


    $sql = '';
    $sql .= ' select grc_c.* ';
    $sql .= ' from grc_comunicacao grc_c ';
    $sql .= ' where protocolo_agenda = ' . $protocolo_agenda;
    $sql .= '   and processo  = ' . $processo;
    $sql .= '   order by quantidade_envio ';
    $rst = execsql($sql);
    if ($rst->rows > 0) {
        // pega o último
        foreach ($rst->data as $rowt) {
            $idt_comunicacao = $rowt['idt'];
            $quantidade_envio = $rowt['quantidade_envio'];
            // aqui tem que ser amalisado...
            // pode não fazer nada ou ter que desavisar....algo...
            // entendendo que esta reenviando
        }
        $quantidade_envio = $quantidade_envio + 1;
    } else {
        $quantidade_envio = 1;
        $primeiro = 0;
    }
    //
    $sql_i = ' insert into grc_comunicacao ';
    $sql_i .= ' (  ';
    $sql_i .= " protocolo, ";
    $sql_i .= " protocolo_agenda, ";
    $sql_i .= " login, ";
    $sql_i .= " nome, ";
    $sql_i .= " email, ";
    $sql_i .= " sms_e, ";
    $sql_i .= " sms_enum, ";

    $sql_i .= " datahora, ";
    $sql_i .= " ip, ";
    $sql_i .= " latitude, ";
    $sql_i .= " longitude, ";
    $sql_i .= " macroprocesso, ";
    $sql_i .= " anonimo_nome, ";
    $sql_i .= " anomimo_email, ";
    $sql_i .= " navegador, ";
    $sql_i .= " tipo_dispositivo, ";
    $sql_i .= " modelo, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo_solicitacao, ";
    //
    $sql_i .= " idt_externo, ";
    $sql_i .= " processo, ";
    $sql_i .= " cliente_nome, ";
    $sql_i .= " cliente_email, ";
    $sql_i .= " sms, ";
    $sql_i .= " sms_t, ";
    //
    $sql_i .= " quando, ";
    $sql_i .= " prazo, ";
    $sql_i .= " data_enviar, ";
    $sql_i .= " pendente_envio, ";
    //
    $sql_i .= " titulo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " complemento, ";
    $sql_i .= " quantidade_envio ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $protocolo, ";
    $sql_i .= " $protocolo_agenda, ";
    $sql_i .= " $login_e, ";
    $sql_i .= " $nome_e, ";
    $sql_i .= " $email_e, ";
    $sql_i .= " $sms_e, ";
    $sql_i .= " $sms_enum, ";
    $sql_i .= " $datahora, ";
    $sql_i .= " $ip, ";
    $sql_i .= " $latitude, ";
    $sql_i .= " $longitude, ";
    $sql_i .= " $macroprocesso, ";
    $sql_i .= " $anonimo_nome, ";
    $sql_i .= " $anomimo_email, ";
    $sql_i .= " $navegador, ";
    $sql_i .= " $tipo_dispositivo, ";
    $sql_i .= " $modelo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $tipo_solicitacao, ";
    $sql_i .= " $idt_externo, ";
    $sql_i .= " $processo, ";
    $sql_i .= " $cliente_nome, ";
    $sql_i .= " $cliente_email, ";
    $sql_i .= " $cliente_sms_num, ";
    $sql_i .= " $cliente_sms, ";
    $sql_i .= " $quando, ";
    $sql_i .= " $prazo, ";
    $sql_i .= " $data_enviar, ";
    $sql_i .= " $pendente_envio, ";
    $sql_i .= " $titulo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $complemento, ";
    $sql_i .= " $quantidade_envio ";

    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_comunicacao = lastInsertId();
    //
    // Aberto o protocolo para registrar Chamado
    // Gerar Dados capturados da CS

    return $idt_comunicacao;
}

function GravaComunicacaoInteracao(&$vetParametros) {
    DadosEstacao($vetParametros);
    //
    DadosUsuario($vetParametros);

    $tabela = 'plu_cominicacao_interacao';
    $Campo = 'protocolo';
    $tam = 7;
    $codigow = numerador_arquivo($tabela, $Campo, $tam);
    $codigo = 'CCI' . $codigow;
    $descricao = aspa($vetParametros['descricao']);
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $protocolo = aspa($codigo);
    $login = aspa($_SESSION[CS]['g_login']);
    $nome = aspa($_SESSION[CS]['g_nome_completo']);
    $email = aspa($_SESSION[CS]['g_email']);
    $datahora = aspa(($datadia));
    $ip = aspa($_SERVER['REMOTE_ADDR']);
    $macroprocesso = 'null';
    $anonimo_nome = 'null';
    $anomimo_email = 'null';
    $titulo = aspa($vetParametros['titulo']);

    $navegador = aspa($vetParametros['navegador']);
    $tipo_dispositivo = aspa($vetParametros['mobile']);
    $modelo = aspa($vetParametros['modelo']);
    $status = aspa('A');
    $tipo_informacao = aspa('NA');
    $tipo_solicitacao = aspa('NA');
    if ($vetParametros['tipo_solicitacao'] == "") {
        $tipo_solicitacao = aspa('NA');
    } else {
        $tipo_solicitacao = aspa($vetParametros['tipo_solicitacao']);
    }
    $latitude = $_SESSION[CS]['latitude'];
    $longitude = $_SESSION[CS]['longitude'];
    if ($latitude == "") {
        $latitude = 0;
    }
    if ($longitude == "") {
        $longitude = 0;
    }
    if ($latitude == 0 and $longitude == 0) {
        $lalo = "Coordnada geográficas Não identificada";
    }

    $descricao = aspa($vetParametros['descricao']);
    $cpf = $vetParametros['cpf'];
    $emailT = $vetParametros['email'];
    $telefone = $vetParametros['telefone'];

    $complemento = "";
    $nome_completo = $_SESSION[CS]['g_nome_completo'];
    $complemento .= "NOME: {$nome_completo}<br />";
    $complemento .= "CPF: {$cpf} TELEFONE: {$telefone} EMAIL: {$emailT}";

    // Credenciado nan AOE

    $gec_en_credenciado_nan = $vetParametros['credenciado_nan'];

    if ($gec_en_credenciado_nan == 'S') {


        $tutor = $vetParametros['tutor'];
        $empresa_executora = $vetParametros['empresa_executora'];
        $ponto_atendimento = $vetParametros['ponto_atendimento'];
        $contrato = $vetParametros['contrato'];





        $complemento .= "<br /><br />";
        $complemento .= "-> AGENTE DE ORIENTAÇÃO EMPRESARIAL - AOE<br /><br />";
        $complemento .= "EMPRESA EXEECUTORA: {$empresa_executora}<br />";
        $complemento .= "TUTOR: {$tutor}<br />";
        $complemento .= "PONTO ATENDIMENTO: {$ponto_atendimento}<br />";
        $complemento .= "CONTRATO: {$contrato}<br />";
    }


    $matricula = $vetParametros['matricula'];
    if ($matricula != '') {
        $secao = $vetParametros['secao'];
        $cargo = $vetParametros['cargo'];
        $complemento .= "<br /><br />";
        $complemento .= "-> COLABORADOR DO SEBRAE<br /><br />";
        $complemento .= "SEÇÃO: {$secao}<br />";
        $complemento .= "CARGO: {$cargo}<br />";
        $complemento .= "MATRÍCULA: {$matricula}<br />";
    }
    $complemento = aspa($complemento);
    $idt_comunicacao = $vetParametros['idt_comunicacao'];
    $sql_i = ' insert into grc_comunicacao_interacao ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_comunicacao, ";
    $sql_i .= " protocolo, ";
    $sql_i .= " login, ";
    $sql_i .= " nome, ";
    $sql_i .= " email, ";
    $sql_i .= " datahora, ";
    $sql_i .= " ip, ";
    $sql_i .= " latitude, ";
    $sql_i .= " longitude, ";
    $sql_i .= " macroprocesso, ";
    $sql_i .= " anonimo_nome, ";
    $sql_i .= " anomimo_email, ";
    $sql_i .= " navegador, ";
    $sql_i .= " tipo_dispositivo, ";
    $sql_i .= " modelo, ";
    $sql_i .= " status, ";
    $sql_i .= " tipo_solicitacao, ";
    //
    $sql_i .= " titulo, ";
    $sql_i .= " descricao, ";
    $sql_i .= " complemento ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_comunicacao, ";
    $sql_i .= " $protocolo, ";
    $sql_i .= " $login, ";
    $sql_i .= " $nome, ";
    $sql_i .= " $email, ";
    $sql_i .= " $datahora, ";
    $sql_i .= " $ip, ";
    $sql_i .= " $latitude, ";
    $sql_i .= " $longitude, ";
    $sql_i .= " $macroprocesso, ";
    $sql_i .= " $anonimo_nome, ";
    $sql_i .= " $anomimo_email, ";
    $sql_i .= " $navegador, ";
    $sql_i .= " $tipo_dispositivo, ";
    $sql_i .= " $modelo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $tipo_solicitacao, ";

    $sql_i .= " $titulo, ";
    $sql_i .= " $descricao, ";
    $sql_i .= " $complemento ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    $idt_comunicacao_interacao = lastInsertId();
    //
    // Aberto o protocolo para registrar Chamado
    // Gerar Dados capturados da CS
    return $idt_comunicacao_interacao;
}

function SincronizaComunicacao(&$vetParametros) {
    global $vetConf;



    $vetTipoSolicitacaoHD = Array();
    //$vetTipoSolicitacaoHD['PS'] = 'Problema no Sistema';
    //$vetTipoSolicitacaoHD['RE'] = 'Dúvida do Sistema';

    $vetTipoSolicitacaoHD['CA'] = 'Confirmação de Agendamento';
    $vetTipoSolicitacaoHD['IN'] = 'Informação';
    $vetTipoSolicitacaoHD['SE'] = 'Solicitação de Esclarecimentos';



    $idt_comunicacao = $vetParametros['idt_comunicacao'];
    $sql = "select  ";
    $sql .= " grc_c.*  ";
    $sql .= " from grc_comunicacao grc_c ";
    $sql .= " where grc_c.idt = {$idt_comunicacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    $cliente_nome = "";
    $cliente_email = "";
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $descricao = $row['descricao'];
        $complemento = $row['complemento'];
        $datahora = $row['datahora'];
        $titulo = $row['titulo'];
        $login = $row['login'];
        $nome = $row['nome'];
        $email = $row['email'];
        $cliente_nome = $row['cliente_nome'];
        $cliente_email = $row['cliente_email'];
        $ip = $row['ip'];
        $navegador = $row['navegador'];
        $tipo_dispositivo = $row['tipo_dispositivo'];
        $modelo = $row['modelo'];
        $descricao_tipo = $vetTipoSolicitacaoHD[$row['tipo_solicitacao']];
    }
    //
    // Arquivos anexos
    //
	$sql = "select  ";
    $sql .= " grc_ca.*  ";
    $sql .= " from grc_comunicacao_anexo grc_ca";
    $sql .= " where grc_ca.idt_comunicacao = {$idt_comunicacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    $vetArquivos = Array();
    ForEach ($rs->data as $row) {
        $arquivo = $row['arquivo'];
        $descricao = $row['descricao'];
        $observacao = $row['observacao'];
        $dirorigem = 'obj_file/grc_comunicacao_anexo/';
        $vetA = Array();
        $vetA['dirorigem'] = $dirorigem;
        $vetA['arquivo'] = $arquivo;
        $vetA['descricao'] = $descricao;
        $vetA['observacao'] = $observacao;
        $vetArquivos[] = $vetA;
    }
    //p($vetArquivos);
    //
    // Enviar email para helpdesk Sebrae
    // guybete

    $loginad = "Não";
    if ($_SESSION[CS]['g_ldap'] == "S") {
        $loginad = "Sim";
    }
    $perfillogado = "";
    $sql = "select * from plu_perfil where id_perfil = " . null($_SESSION[CS]['g_id_perfil']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $perfillogado = "ERRO. PERFIL NÃO PODE SER ENCONTRADO";
    } else {
        $row = $rs->data[0];
        $perfillogado = $row['nm_perfil'];
    }
    $vetSistemas = Array();
    $perfillogado = "";
    $sql = "select * from " . db_pir . "plu_usuario ";
    $sql .= " where login = " . aspa($login);
    $rs = execsql($sql);
    $erropir = "";
    if ($rs->rows == 0) {
        $erropir = "ERRO. SEM LOGIN NO PIR";
    } else {
        $row = $rs->data[0];
        $pir_id_usuario = $row['id_usuario'];
    }


    if ($descricao_tipo == '') {
        $assuntow = '[' . $protocolo . '] - ' . $descricao_tipo . ' - ' . $titulo;
    } else {
        $assuntow = '[' . $protocolo . '] - ' . $titulo;
    }
    $datahoraw = trata_data($datahora);
    $mensagemw = 'CRM|Sebrae - Comunicação com o Cliente - Protocolo: ' . $protocolo . '<br />';

    // $mensagemw .= 'Protocolo: '.$protocolo.'<br />';
    // $mensagemw .= 'Tipo de Solicitação: '.$descricao_tipo.'<br />';
    // $mensagemw .= 'Data: '.$datahoraw.'<br />';
    // $mensagemw .= 'Login: '.$login.'<br />';
    // $mensagemw .= 'Perfil do Usuário: '.$perfillogado.'<br />';

    /*
      $mensagemw .= 'Login no AD?: '.$loginad.'<br />';
      $mensagemw .= 'Sistemas e Ambientes de Acesso:<br />';
      ForEach ($vetSistemas as $codsist => $VetAtributos) {
      $NomeSistema = $VetAtributos['nome'];
      $Ambiente = $VetAtributos['ambiente'];
      $mensagemw .= "{$NomeSistema} - {$Ambiente}<br />";
      }
      $mensagemw .= 'Usuario: '.$nome.'<br />';
      $mensagemw .= 'IP Usuario: '.$ip.'<br />';
      $mensagemw .= 'Navegador: '.$navegador.'<br />';
      $mensagemw .= 'Tipo do Dispositivo: '.$tipo_dispositivo.'<br />';
      $mensagemw .= 'Modelo: '.$modelo.'<br />';
      // $mensagemw .= 'Descrição: <pre>'.$descricao.'</pre><br /><br />';
      $mensagemw .= 'Descrição: '.$descricao.'<br /><br />';
     */
    //
    $mensagemw .= 'Informações para o Cliente: <br />' . $descricao . '<br /><br />';
    //
    // p($vetConf);
    //
	$enviou_email = 0;
    $vetParametros = Array();
    //
    $banco_grava = db_pir_grc;
    $assunto = $assuntow;
    $mensagem = $mensagemw;
    //$para_email      = $vetConf['email_logerro'];

    $para_email = $vetConf['comunicacao_solicitacao'];

//		$cliente_nome  = "";
//	$cliente_email = "";



    $para_email = $cliente_email;



    $para_nome = "";
    $usa_protocolo = false;

    $vetRegProtocolo = Array();
    $de_email = $email;
    $de_nome = $nome;
    $trata_erro = true;
    $enviou_email = enviarEmailComunicacao($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo, $vetRegProtocolo, $de_email, $de_nome, $trata_erro, $vetArquivos, $vetParametros);
    //
    // Update da data de envio
    //
	// Data_envio_email_helpdesk
    //
	if ($enviou_email == 1) {
        $mandou_email_comunicacao = "Email Gerado com Sucesso ...";
    } else {
        $mandou_email_comunicacao = "Email Não Pode ser Gerado ...";
    }

    $msg_erro = $vetParametros['msg_erro'];
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $sql = 'update grc_comunicacao set ';
    $sql .= ' msg_erro  = ' . aspa($msg_erro) . ", ";
    $sql .= ' status    = ' . aspa('R') . ", ";
    $sql .= ' mandou_email_comunicacao     = ' . aspa($mandou_email_comunicacao) . ", ";
    $sql .= ' data_envio_email_comunicacao = ' . aspa($datadia);
    $sql .= ' where idt                 = ' . null($idt_comunicacao);
    execsql($sql);

    //
}

function SincronizaComInteracaoSebrae(&$vetParametros) {
    global $vetConf;

    $vetTipoSolicitacaoHD = Array();
    $vetTipoSolicitacaoHD['PS'] = 'Problema no Sistema';
    $vetTipoSolicitacaoHD['RE'] = 'Dúvida do Sistema';


    $idt_comunicacao_interacao = $vetParametros['idt_comunicacao_interacao'];
    $sql = "select  ";
    $sql .= " grc_ci.*  ";
    $sql .= " from grc_comunicacao_interacao grc_ci ";
    $sql .= " where grc_ci.idt = {$idt_comunicacao_interacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    ForEach ($rs->data as $row) {
        $protocolo = $row['protocolo'];
        $descricao = $row['descricao'];
        $complemento = $row['complemento'];
        $datahora = $row['datahora'];
        $titulo = $row['titulo'];
        $login = $row['login'];
        $nome = $row['nome'];
        $ip = $row['ip'];
        $navegador = $row['navegador'];
        $tipo_dispositivo = $row['tipo_dispositivo'];
        $modelo = $row['modelo'];
        $descricao_tipo = $vetTipoSolicitacaoHD[$row['tipo_solicitacao']];
    }
    //
    // Arquivos anexos
    //
	$sql = "select  ";
    $sql .= " grc_cia.*  ";
    $sql .= " from grc_comunicacao_interacao_anexo grc_cia ";
    $sql .= " where grc_cia.idt_comunicacao_interacao = {$idt_comunicacao_interacao} ";
    $rs = execsql($sql);
    $wcodigo = '';
    $vetArquivos = Array();
    ForEach ($rs->data as $row) {
        $arquivo = $row['arquivo'];
        $descricao = $row['descricao'];
        $observacao = $row['observacao'];
        $dirorigem = 'obj_file/grc_comunicacao_interacao_anexo/';
        $vetA = Array();
        $vetA['dirorigem'] = $dirorigem;
        $vetA['arquivo'] = $arquivo;
        $vetA['descricao'] = $descricao;
        $vetA['observacao'] = $observacao;
        $vetArquivos[] = $vetA;
    }
    //p($vetArquivos);
    //
    // Enviar email para helpdesk Sebrae
    // guybete

    $loginad = "Não";
    if ($_SESSION[CS]['g_ldap'] == "S") {
        $loginad = "Sim";
    }
    $perfillogado = "";
    $sql = "select * from plu_perfil where id_perfil = " . null($_SESSION[CS]['g_id_perfil']);
    $rs = execsql($sql);

    if ($rs->rows == 0) {
        $perfillogado = "ERRO. PERFIL NÃO PODE SER ENCONTRADO";
    } else {
        $row = $rs->data[0];
        $perfillogado = $row['nm_perfil'];
    }
    $vetSistemas = Array();
    $perfillogado = "";
    $sql = "select * from " . db_pir . "plu_usuario ";
    $sql .= " where login = " . aspa($login);
    $rs = execsql($sql);
    $erropir = "";
    if ($rs->rows == 0) {
        $erropir = "ERRO. SEM LOGIN NO PIR";
    } else {
        $row = $rs->data[0];
        $pir_id_usuario = $row['id_usuario'];
    }



    $assuntow = $protocolo . ' - ' . $descricao_tipo . ' - ' . $titulo;
    $datahoraw = trata_data($datahora);
    $mensagemw = 'INTERAÇÃO DA COMUNICAÇÃO<br />';
    $mensagemw .= 'Protocolo: ' . $protocolo . '<br />';
    $mensagemw .= 'Tipo de Solicitação: ' . $descricao_tipo . '<br />';
    $mensagemw .= 'Data: ' . $datahoraw . '<br />';
    $mensagemw .= 'Login: ' . $login . '<br />';
    $mensagemw .= 'Perfil do Usuário: ' . $perfillogado . '<br />';
    $mensagemw .= 'Login no AD?: ' . $loginad . '<br />';
    $mensagemw .= 'Sistemas e Ambientes de Acesso:<br />';
    ForEach ($vetSistemas as $codsist => $VetAtributos) {
        $NomeSistema = $VetAtributos['nome'];
        $Ambiente = $VetAtributos['ambiente'];
        $mensagemw .= "{$NomeSistema} - {$Ambiente}<br />";
    }
    $mensagemw .= 'Usuario: ' . $nome . '<br />';
    $mensagemw .= 'IP Usuario: ' . $ip . '<br />';
    $mensagemw .= 'Navegador: ' . $navegador . '<br />';
    $mensagemw .= 'Tipo do Dispositivo: ' . $tipo_dispositivo . '<br />';
    $mensagemw .= 'Modelo: ' . $modelo . '<br />';
    // $mensagemw .= 'Descrição: <pre>'.$descricao.'</pre><br /><br />';
    $mensagemw .= 'Descrição: ' . $descricao . '<br /><br />';
    //
    $mensagemw .= 'Informações do Usuário: <br />' . $descricao . '<br /><br />';
    //
    // p($vetConf);
    //
	$enviou_email = 0;
    $vetParametros = Array();
    //
    $banco_grava = db_pir_grc;
    $assunto = $assuntow;
    $mensagem = $mensagemw;
    //$para_email      = $vetConf['email_logerro'];

    $para_email = $vetConf['helpdesk_solicitacao'];


    $para_nome = "";
    $usa_protocolo = false;
    $vetRegProtocolo = Array();
    $de_email = '';
    $de_nome = '';
    $trata_erro = true;
    $enviou_email = enviarEmailComunicacao($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo, $vetRegProtocolo, $de_email, $de_nome, $trata_erro, $vetArquivos, $vetParametros);
    //
    // Update da data de envio
    //
	// Data_envio_email_comunicacao
    //
	if ($enviou_email == 1) {
        $mandou_email_comunicacao = "Email Gerado com Sucesso ...";
    } else {
        $mandou_email_comunicacao = "Email Não Pode ser Gerado ...";
    }

    $msg_erro = $vetParametros['msg_erro'];
    $datadia = trata_data(date('d/m/Y H:i:s'));
    $sql = 'update grc_comunicacao set ';
    $sql .= ' status    = ' . aspa('R') . ", ";
    $sql .= ' msg_erro = ' . aspa($msg_erro) . ", ";
    $sql .= ' mandou_email_comunicacao     = ' . aspa($mandou_email_comunicacao) . ", ";
    $sql .= ' data_envio_email_comunicacao = ' . aspa($datadia);
    $sql .= ' where idt                    = ' . null($idt_comunicacao);
    execsql($sql);
    //
}

function enviarEmailComunicacao($banco_grava, $assunto, $mensagem, $para_email, $para_nome, $usa_protocolo = false, &$vetRegProtocolo = Array(), $de_email = '', $de_nome = '', $trata_erro = true, $vetArquivos = Array(), &$vetParametros = Array()) {
    $sql = 'select * from ' . $banco_grava . 'plu_config';
    $rs = execsql($sql, $trata_erro);

    $vetConf = Array();

    ForEach ($rs->data as $row) {
        $vetConf[$row['variavel']] = trim($row['valor'] . ($row['extra'] == '' ? '' : ' ' . $row['extra']));
    }

    $vetPadrao = Array();
    $de_email = "";
    if ($de_email == '') {
        $de_replay = $vetConf['comunicacao_email_site'];
        $de_email = $vetConf['comunicacao_email_envio'];
        $de_nome = $vetConf['comunicacao_email_nome'];

        if ($de_email == '') {
            $de_email = $de_replay;
        }
    } else {
        $de_replay = $de_email;
    }

    if ($usa_protocolo) {
        if ($vetRegProtocolo['protocolo'] == '') {
            $protocolo = date('dmYHis');
            $mensagem .= '<br/><br/>Protocolo de controle: ' . $protocolo;
        } else {
            $protocolo = $vetRegProtocolo['protocolo'];
        }

        $vetPadrao = Array(
            'protocolo' => $protocolo,
            'data_registro' => getdata(true, false, true),
            'email_origem' => $de_email,
            'nome_origem' => $de_nome,
            'email_destino' => $para_email,
            'nome_destino' => $para_nome,
            'msg_principal' => $mensagem,
            'confirmacao' => 'N',
            'enviado' => 'N',
        );





        if (is_array($vetRegProtocolo)) {
            foreach ($vetRegProtocolo as $key => $value) {
                $vetPadrao[$key] = $value;
            }
        }

        $sql_campo = Array();
        $sql_valor = Array();

        foreach ($vetPadrao as $key => $value) {
            $sql_campo[$key] = $key;
            $sql_valor[$key] = aspa($value);
        }

        if (count($sql_campo) > 0) {
            $sql = 'insert into ' . $banco_grava . 'plu_email_log (' . implode(', ', $sql_campo) . ') values (' . implode(', ', $sql_valor) . ')';
            execsql($sql, $trata_erro);
            $vetPadrao['idt'] = lastInsertId();
        }
    }

    require_once(lib_phpmailer . 'PHPMailerAutoload.php');

    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    $mail->SetLanguage('br', lib_phpmailer);

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    /*
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->Host = "smtp.live.com";
      $mail->SMTPAuth= true;
      $mail->Port = 587;
      $mail->Username= $account;
      $mail->Password= $password;
      $mail->SMTPSecure = 'tls';
      $mail->From = $from;
      $mail->FromName= $from_name;
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $msg;
      $mail->addAddress($to);
     */

    $mail->IsSMTP();
    $mail->Host = $vetConf['comunicacao_host_smtp'];
    $mail->Port = $vetConf['comunicacao_port_smtp'];
    $mail->Username = $vetConf['comunicacao_login_smtp'];
    $mail->Password = $vetConf['comunicacao_senha_smtp'];
    $mail->SMTPAuth = !($vetConf['comunicacao_login_smtp'] == '' && $vetConf['comunicacao_senha_smtp'] == '');
    $mail->SMTPSecure = $vetConf['comunicacao_smtp_secure'];








    $mail->setFrom($de_email, $de_nome);
    $mail->AddReplyTo($de_replay, $de_nome);




    $mail->Subject = $assunto;
    $mail->msgHTML($mensagem);

    $vetTmp = explode(';', $para_email);

    foreach ($vetTmp as $value) {
        $mail->addAddress($value, $para_nome);
    }

    if (count($vetArquivos) > 0) {
        // Anexar arquivos ao email
        ForEach ($vetArquivos as $indice => $VetArq) {
            $dirorigem = $VetArq['dirorigem'];
            $arquivo = $VetArq['arquivo'];

            // anexar ao email
            $pathfile = $dirorigem . $arquivo;
            $mail->AddAttachment($pathfile);
        }
    }
    $vetParametros['msg_erro'] = "";
    $vetParametros['erro'] = 0;
    if ($mail->send()) {
        if ($usa_protocolo) {
            $vetPadrao['enviado'] = 'S';

            $sql = 'update ' . $banco_grava . 'plu_email_log set enviado  = ' . aspa($vetPadrao['enviado']);
            $sql .= ' where idt = ' . null($vetPadrao['idt']);
            execsql($sql, $trata_erro);
        }
        $vetParametros['erro'] = 1;
        $return = true;
    } else {
        $return = $mail->ErrorInfo;
        $vetPadrao['msg_erro'] = $return;
        $vetParametros['msg_erro'] = $return;
        //p($vetParametros);
        //exit();
        if ($usa_protocolo) {
            $sql = 'update ' . $banco_grava . 'plu_email_log set msg_erro  = ' . aspa($vetPadrao['msg_erro']);
            $sql .= ' where idt = ' . null($vetPadrao['idt']);
            execsql($sql, $trata_erro);
        }
    }

    /*
      p($vetConf);
      p($mail);
      exit();

     */



    $vetRegProtocolo = $vetPadrao;
    return $return;
}

function GerarPendenciaDistancia($idt_atendimento) {
    // 
    // Buscar Atendimento 
    // 
    $kokw = 0;
    $sql = "select  ";
    $sql .= " grc_a.*  ";
    $sql .= " from grc_atendimento grc_a ";
    $sql .= " where grc_a.idt = {$idt_atendimento} ";
    $rs = execsql($sql);
    if ($rs->rows == 1) {
        ForEach ($rs->data as $row) {
            $protocolo = $row['protocolo'];
            $idt_servico = $row['idt_servico'];
            $diagnostico = $row['diagnostico'];
            $devolutiva = $row['devolutiva'];
            $recomendacao = $row['recomendacao'];
            $solucao_sebrae = $row['solucao_sebrae'];
        }
    } else {
        // Erro grava - não encontrato o atendimento
        $kokw = 0;
        return $kokw;
    }
    if ($idt_servico > 0 and $diagnostico != '' and $devolutiva != '' and $recomendacao != '' and $solucao_sebrae != '') {

        //if ($idt_servico > 0 ) {
        //
        // Tem serviço então, pode gerar devolutiva para aprovação
        //
		// Gerar pendência de aprovação
        //
		$idt_gestor = "";
        $sql = "select  ";
        $sql .= " grc_aeg.*  ";
        $sql .= " from grc_atendimento_especialidade_gestor grc_aeg ";
        $sql .= " where grc_aeg.idt_especialidade = {$idt_servico} ";
        $rs = execsql($sql);
        if ($rs->rows >= 1) {
            ForEach ($rs->data as $row) {
                $idt_gestor = $row['idt_gestor'];

                $idt_atendimentow = $idt_atendimento;
                $idt_gestor_localw = $_SESSION[CS]['g_id_usuario'];
                $idt_responsavel_solucaow = $idt_gestor;
                $assuntow = "Aprovação da Devolutiva ";
                $observacaow = "Aprovação da Devolutiva ";
                $datadia = date('d/m/Y H:i:s');
                $data_solucaow = $datadia;
                GerarPendenciaDevolutiva($idt_atendimentow, $protocolo, $assuntow, $data_solucaow, $observacaow, $idt_gestor_localw, $idt_responsavel_solucaow);
            }
        } else {
            // Não tem quem aprove
            $kokw = 2;
            return $kokw;
        }
        $kokw = 1;
        return $kokw;
    } else {
        $kokw = 3;
        return $kokw;
    }
}

function GerarPendenciaDevolutiva($idt_atendimentow, $protocolow, $assuntow, $data_solucaow, $observacaow, $idt_gestor_localw, $idt_responsavel_solucaow) {
    $kokw = 0;
    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
    $datadia = date('d/m/Y H:i:s');
    $data = aspa(trata_data($datadia));
    $idt_atendimento = $idt_atendimentow;
    $data_solucao = aspa(trata_data($data_solucaow));
    $protocolo = aspa($protocolow);
    $observacao = aspa($observacaow);
    $assunto = aspa($assuntow);
    $idt_gestor_local = null($idt_gestor_localw);
    $idt_responsavel_solucao = null($idt_responsavel_solucaow);

    $tipo = aspa('Atendimento Distância');
    $status = aspa('Para Aprovação');
    //
    $sql_i = ' insert into grc_atendimento_pendencia ';
    $sql_i .= ' (  ';
    $sql_i .= " idt_atendimento, ";
    $sql_i .= " idt_usuario, ";
    $sql_i .= " idt_gestor_local, ";
    $sql_i .= " idt_responsavel_solucao, ";
    $sql_i .= " protocolo, ";
    $sql_i .= " data, ";
    $sql_i .= " data_solucao, ";
    $sql_i .= " tipo, ";
    $sql_i .= " status, ";
    $sql_i .= " assunto, ";
    $sql_i .= " observacao ";
    $sql_i .= '  ) values ( ';
    $sql_i .= " $idt_atendimento, ";
    $sql_i .= " $idt_usuario, ";
    $sql_i .= " $idt_gestor_local, ";
    $sql_i .= " $idt_responsavel_solucao, ";
    $sql_i .= " $protocolo, ";
    $sql_i .= " $data, ";
    $sql_i .= " $data_solucao, ";
    $sql_i .= " $tipo, ";
    $sql_i .= " $status, ";
    $sql_i .= " $assunto, ";
    $sql_i .= " $observacao ";
    $sql_i .= ') ';
    $result = execsql($sql_i);
    //$idt_atendimento = lastInsertId();
    $kokw = 1;
    return $kokw;
}

// $vetParametros['idt_sca_oc']
function DadosSCA(&$vetParametros) {
    $tipo = $vetParametros['tipo'];
    if ($tipo == 'UR' and $vetParametros['idt_sca_oc'] == "") {   // descobrir idt da UR
        $idt_ponto_atendimento = $vetParametros['idt_ponto_atendimento'];
        $TabelaPrinc = db_pir . "sca_organizacao_secao";
        $AliasPric = "sca_oc";
        $campos = "{$AliasPric}.idt as idt_ponto_atendimento, sca_ocUR.idt as idt_unidade_regional   ";
        $sql = "select  ";
        $sql .= " $campos  ";
        $sql .= " from {$TabelaPrinc}  {$AliasPric}";
        $sql .= " inner join {$TabelaPrinc}  sca_ocUR on substring(sca_ocUR.classificacao,1,5) = substring(sca_oc.classificacao,1,5)";
        $idt_sca_oc = $vetParametros['idt_sca_oc'];
        $strWhere = " {$AliasPric}.idt = " . null($idt_ponto_atendimento);
        $strWhere .= " and sca_ocUR.tipo_estrutura = " . aspa('UR');
        $korderbyw = "";

        if ($strWhere != "") {
            $sql .= " where (";
            $sql .= $strWhere;
            $sql .= " )";
        }
        if ($korderbyw != "") {
            $sql .= " order by ";
            $sql .= $korderbyw;
        }
        $rs = execsql($sql);
        if ($rs->rows == 0) {
            // Nada foi selecionado
            $vetParametros['erro'] = "Erro Registro de Agendamento Não Encontrado";
            return 0;
        } else {


            ForEach ($rs->data as $row) {
                $idt_unidade_regional = $row['idt_unidade_regional'];
                $vetParametros['idt_sca_oc'] = $idt_unidade_regional;
            }
        }
    }
    // Acessar Dados no SCA
    //p($vetParametros);
    $TabelaPrinc = db_pir . "sca_organizacao_secao";
    $AliasPric = "sca_oc";
    $campos = "{$AliasPric}.*, ";
    $campos .= "sca_oc.descricao as ponto_atendimento,  ";
    $campos .= "sca_oc.logradouro as logradouro,  ";
    $campos .= "sca_oc.logradouro_numero as numero,  ";
    $campos .= "sca_oc.logradouro_complemento as complemento,  ";
    $campos .= "sca_oc.cep as cep,  ";
    $campos .= "sca_oc.telefone   as telefone,  ";
    $campos .= "sca_oc.horario_funcionamento as horario_funcionamento,  ";
    $campos .= "sca_oc.imagem as imagem,  ";
    $campos .= "sca_oc.logradouro_codbairro as logradouro_codbairro,  ";
    $campos .= "sca_oc.logradouro_codcid as logradouro_codcid,  ";
    $campos .= "sca_oc.logradouro_codest as logradouro_codest,  ";
    $campos .= "sca_oc.logradouro_codpais as logradouro_codpais  ";
    //$campos .= "pu.nome_completo as consultor,  ";
    //$campos .= "gae.descricao as servico  ";
    $sql = "select  ";
    $sql .= " $campos  ";
    $sql .= " from {$TabelaPrinc}  {$AliasPric}";
    $idt_sca_oc = $vetParametros['idt_sca_oc'];
    $strWhere = " {$AliasPric}.idt = " . null($idt_sca_oc);
    $korderbyw = "";

    if ($strWhere != "") {
        $sql .= " where (";
        $sql .= $strWhere;
        $sql .= " )";
    }
    if ($korderbyw != "") {
        $sql .= " order by ";
        $sql .= $korderbyw;
    }
    $rs = execsql($sql);
    if ($rs->rows == 0) {
        // Nada foi selecionado
        $vetParametros['erro'] = "Erro Registro de Agendamento Não Encontrado";
        return 0;
    } else {
        ForEach ($rs->data as $row) {
            $ponto_atendimento = $row['ponto_atendimento'];
            $logradouro = $row['logradouro'];
            $numero = $row['numero'];
            $complemento = $row['complemento'];
            $cep = $row['cep'];
            $telefone = $row['telefone'];
            $horario_funcionamento = $row['horario_funcionamento'];
            $imagem = $row['imagem'];
            $logradouro_codbairro = $row['logradouro_codbairro'];
            $logradouro_codcid = $row['logradouro_codcid'];
            $logradouro_codest = $row['logradouro_codest'];
            $logradouro_codpais = $row['logradouro_codpais'];
        }
    }
    $endereco = "";
    $sqlp = '';
    $sqlp .= " select distinct codpais as cod, pais_nome";
    $sqlp .= ' from ' . db_pir_gec . 'base_cep';
    $sqlp .= ' where codpais = ' . null($logradouro_codpais);
    $rsp = execsql($sqlp);
    ForEach ($rsp->data as $rowp) {
        $pais_nome = $rowp['pais_nome'];
    }
    $sqlp = '';
    $sqlp .= " select distinct codest as cod, uf_nome";
    $sqlp .= ' from ' . db_pir_gec . 'base_cep';
    $sqlp .= ' where codest = ' . null($logradouro_codest);
    $rsp = execsql($sqlp);
    ForEach ($rsp->data as $rowp) {
        $uf_nome = $rowp['uf_nome'];
    }
    $sqlp = '';
    $sqlp .= " select distinct codcid as cod, cidade";
    $sqlp .= ' from ' . db_pir_gec . 'base_cep';
    $sqlp .= ' where codcid = ' . null($logradouro_codcid);
    $rsp = execsql($sqlp);
    ForEach ($rsp->data as $rowp) {
        $cidade = $rowp['cidade'];
    }

    $sqlp = '';
    $sqlp .= " select distinct codbairro as cod, bairro";
    $sqlp .= ' from ' . db_pir_gec . 'base_cep';
    $sqlp .= ' where codbairro = ' . null($logradouro_codbairro);
    $rsp = execsql($sqlp);
    ForEach ($rsp->data as $rowp) {
        $bairro = $rowp['bairro'];
    }

    $vetParametros['pais_nome'] = $pais_nome;
    $vetParametros['uf_nome'] = $uf_nome;
    $vetParametros['cidade'] = $cidade;
    $vetParametros['bairro'] = $bairro;
    $vetParametros['logradouro'] = $bairro;
    $vetParametros['numero'] = $numero;
    $vetParametros['complemento'] = $complemento;
    $vetParametros['cep'] = $bairro;
    $vetParametros['telefone'] = $telefone;
    $vetParametros['horario_funcionamento'] = $horario_funcionamento;
    $vetParametros['imagem'] = $imagem;
    //

    if ($numero == "" and $complemento == "") {
        $endereco .= "$logradouro, CEP: $cep ";
    }
    if ($numero != "" and $complemento == "") {
        $endereco .= "$logradouro, $numero, CEP: $cep ";
    }
    if ($numero == "" and $complemento != "") {
        $endereco .= "$logradouro, $complemento, CEP: $cep ";
    }
    if ($numero != "" and $complemento != "") {
        $endereco .= "$logradouro, $numero, $complemento, CEP: $cep ";
    }
    $endereco .= "<br />$bairro, $cidade, $uf_nome, $pais_nome  ";
    $vetParametros['endereco_sca'] = $endereco;
    $vetParametros['descricao'] = $ponto_atendimento;
    if ($vetParametros['tipo'] == 'UR') {
        $vetParametros['endereco_ur'] = $endereco;
        $vetParametros['descricao_ur'] = $ponto_atendimento;
    }
    if ($vetParametros['tipo'] == 'PA') {
        $vetParametros['endereco_pa'] = $endereco;
        $vetParametros['descricao_pa'] = $ponto_atendimento;
    }
    return 1;
}

/**
 * Faz a verificação dos Registro de Devolução de Pagamento em função dos pagamentos informados
 * @access public
 * @param int $idt_atendimento <p>
 * IDT do Atendimento (Matricula)
 * </p>
 * @param string $reg_origem <p>
 * Origem do registro de Devolução
 * </p>
 * @param int $idt_ligacao [opcional]<p>
 * IDT da Ligação do o Registro de Origem
 * </p>
 * */
function atualizaRegDevolucaoSG($idt_atendimento, $reg_origem, $idt_ligacao = '') {
    $vetIdtOK = Array();
    $vetIdtOK[] = 0;

    $sql = '';
    $sql .= ' select ao.cnpj as mat_cnpj, ao.razao_social as mat_razao_social, pp.par_cnpj, pp.par_razao_social,';
    $sql .= ' sum(pp.valor_pagamento) as vl_pago, sum(distinct ep.vl_tot_pagamento_real) as vl_pago_real';
    $sql .= ' from grc_evento_participante_pagamento pp';
    $sql .= ' inner join grc_atendimento_organizacao ao on ao.idt_atendimento = pp.idt_atendimento';
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = pp.idt_atendimento';
    $sql .= ' where pp.idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and pp.estornado <> 'S'";
    $sql .= " and pp.operacao <> 'D'";
    $sql .= ' and pp.idt_aditivo_participante is null';
    $sql .= " and ao.representa = 'S'";
    $sql .= " and ao.desvincular = 'N'";
    $sql .= ' group by ao.cnpj, ao.razao_social, pp.par_cnpj, pp.par_razao_social';
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $sqlCampo = '';
        $sqlvalor = '';
        $sqlUpdate = '';

        if ($row['par_cnpj'] == '') {
            $codigo = $row['mat_cnpj'];
            $descricao = $row['mat_razao_social'];
            $inc_pag_rm = 'S';
        } else {
            $codigo = $row['par_cnpj'];
            $descricao = $row['par_razao_social'];
            $inc_pag_rm = 'N';
        }

        if ($reg_origem == 'DI' && $row['vl_pago_real'] != '') {
            $vl_pago = $row['vl_pago_real'];
        } else {
            $vl_pago = $row['vl_pago'];
        }

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento_participante_contadevolucao';
        $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
        $sql .= ' and codigo = ' . aspa($codigo);
        $sql .= ' and reg_origem = ' . aspa($reg_origem);

        if ($reg_origem == 'DI') {
            $sql .= ' and idt_contratar_credenciado_distrato = ' . null($idt_ligacao);

            $vl_ja_devolvido = $row['vl_pago'] - $vl_pago;

            //Insert
            $sqlCampo = ', idt_contratar_credenciado_distrato, vl_pago_compra, vl_ja_devolvido, vl_devolucao';
            $sqlvalor = ', ' . null($idt_ligacao) . ', ' . null($row['vl_pago']) . ', ' . null($vl_ja_devolvido) . ', ' . null($vl_pago);

            //Update
            $sqlUpdate .= ', vl_pago_compra = ' . null($row['vl_pago']);
            $sqlUpdate .= ', vl_ja_devolvido = ' . null($vl_ja_devolvido);
            $sqlUpdate .= ', vl_devolucao = ' . null($vl_pago);
        }

        $rst = execsql($sql);

        if ($rst->rows == 0) {
            $sql = 'insert into grc_evento_participante_contadevolucao (idt_atendimento, codigo, descricao, inc_pag_rm, vl_pago, reg_origem' . $sqlCampo . ') values (';
            $sql .= null($idt_atendimento) . ', ' . aspa($codigo) . ', ' . aspa($descricao) . ', ' . aspa($inc_pag_rm) . ', ' . null($vl_pago) . ', ' . aspa($reg_origem) . $sqlvalor . ')';
            execsql($sql);
            $idtReg = lastInsertId();
        } else {
            $sql = 'update grc_evento_participante_contadevolucao set descricao = ' . aspa($descricao);
            $sql .= ', inc_pag_rm = ' . aspa($inc_pag_rm);
            $sql .= ', vl_pago = ' . null($vl_pago);
            $sql .= $sqlUpdate;
            $sql .= ' where idt = ' . null($rst->data[0][0]);
            execsql($sql);
            $idtReg = $rst->data[0][0];
        }

        $vetIdtOK[] = $idtReg;

        if ($reg_origem != 'MA') {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_evento_participante_contadevolucao';
            $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
            $sql .= ' and codigo = ' . aspa($codigo);
            $sql .= " and reg_origem = 'MA'";
            $rst = execsql($sql);
            $rowt = $rst->data[0];

            $sql = 'update grc_evento_participante_contadevolucao set banco_numero = ' . aspa($rowt['banco_numero']);
            $sql .= ', banco_nome = ' . aspa($rowt['banco_nome']);
            $sql .= ', agencia_numero = ' . aspa($rowt['agencia_numero']);
            $sql .= ', agencia_digito = ' . aspa($rowt['agencia_digito']);
            $sql .= ', cc_numero = ' . aspa($rowt['cc_numero']);
            $sql .= ', cc_digito = ' . aspa($rowt['cc_digito']);
            $sql .= ', cpfcnpj = ' . aspa($rowt['cpfcnpj']);
            $sql .= ', razao_social = ' . aspa($rowt['razao_social']);
            $sql .= ', rm_codcfo = ' . aspa($rowt['rm_codcfo']);
            $sql .= ', rm_idpgto = ' . null($rowt['rm_idpgto']);
            $sql .= ' where idt = ' . null($idtReg);
            execsql($sql);
        }
    }

    $sql = 'delete from grc_evento_participante_contadevolucao';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' and idt not in (' . implode(', ', $vetIdtOK) . ')';
    $sql .= ' and reg_origem = ' . aspa($reg_origem);
    execsql($sql);
}

/**
 * Faz o calculo do RESUMO FINANCEIRO do Atendimento no Evento
 * @access public
 * @return array Valores calculados
 * @param int $idt_atendimento_evento <p>
 * IDT do Atendimento Evento
 * </p>
 * @param string $tab_log <p>
 * Nome da tabela que esta alterando
 * </p>
 * */
function calculaValorAtendEvento($idt_atendimento_evento, $tab_log) {
    global $vetLogDetalheExtra;

    $vet = Array();

    //resumo_tot
    $sql = '';
    $sql .= ' select sum(vl_unitario * qtd) as resumo_tot';
    $sql .= ' from grc_atendimento_evento_dimensionamento';
    $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $vet['resumo_tot'] = $rs->data[0][0];

    if ($vet['resumo_tot'] == '') {
        $vet['resumo_tot'] = 0;
    }

    //resumo_pag
    $sql = '';
    $sql .= ' select ae.contrapartida_sgtec';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_evento ae';
    $sql .= ' where ae.idt = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $contrapartida_sgtec = $rs->data[0][0];

    if ($contrapartida_sgtec == '') {
        $sql = '';
        $sql .= ' select sum(valor_pagamento) as resumo_pag';
        $sql .= ' from grc_atendimento_evento_pagamento';
        $sql .= ' where idt_atendimento_evento = ' . null($idt_atendimento_evento);
        $rs = execsql($sql);
        $vet['resumo_pag'] = $rs->data[0][0];

        if ($vet['resumo_pag'] == '') {
            $vet['resumo_pag'] = 0;
        }
    } else {
        $vet['resumo_pag'] = round($vet['resumo_tot'] * $contrapartida_sgtec / 100, 2);
    }

    //resumo_sub
    $vet['resumo_sub'] = $vet['resumo_tot'] - $vet['resumo_pag'];

    $sql = '';
    $sql .= ' select resumo_tot, resumo_sub, resumo_pag';
    $sql .= ' from grc_atendimento_evento';
    $sql .= ' where idt = ' . null($idt_atendimento_evento);
    $rs = execsql($sql);
    $rowDados = $rs->data[0];

    $sql = 'update grc_atendimento_evento set';
    $sql .= ' resumo_tot = ' . null($vet['resumo_tot']) . ', ';
    $sql .= ' resumo_sub = ' . null($vet['resumo_sub']) . ', ';
    $sql .= ' resumo_pag = ' . null($vet['resumo_pag']);
    $sql .= ' where idt = ' . null($idt_atendimento_evento);
    $totUPD = execsql($sql);

    $vet = array_map('format_decimal', $vet);

    if ($totUPD > 0) {
        $vetLogDetalheExtra[$tab_log]['resumo_tot']['campo_desc'] = 'Total (Resumo Finaceiro)';
        $vetLogDetalheExtra[$tab_log]['resumo_tot']['desc_ant'] = format_decimal($rowDados['resumo_tot']);
        $vetLogDetalheExtra[$tab_log]['resumo_tot']['desc_atu'] = $vet['resumo_tot'];

        $vetLogDetalheExtra[$tab_log]['resumo_sub']['campo_desc'] = 'Subsidio (Resumo Finaceiro)';
        $vetLogDetalheExtra[$tab_log]['resumo_sub']['desc_ant'] = format_decimal($rowDados['resumo_sub']);
        $vetLogDetalheExtra[$tab_log]['resumo_sub']['desc_atu'] = $vet['resumo_sub'];

        $vetLogDetalheExtra[$tab_log]['resumo_pag']['campo_desc'] = 'Valor a Pagar (Resumo Finaceiro)';
        $vetLogDetalheExtra[$tab_log]['resumo_pag']['desc_ant'] = format_decimal($rowDados['resumo_pag']);
        $vetLogDetalheExtra[$tab_log]['resumo_pag']['desc_atu'] = $vet['resumo_pag'];
    }

    return $vet;
}

//Utilizado no Atidamento e Distrato
function ftd_gec_contratacao_credenciado_ordem_entrega($valor, $row, $campo) {
    global $vetAFProcessoSit, $vetAFProcessoFI, $telaAditivo;

    $html = '';

    //alterar no DEP gec_contratar_credenciado_distrato no termo liquidado
    //alterar no cadastro_conf gec_contratar_credenciado_distrato no termo liquidado
    //if ($row['liquidado'] == 'S') {

    if ($telaAditivo) {
        if ($row['situacao_reg'] == '' || $row['situacao_reg'] == 'RN' || $row['situacao_reg'] == 'EA') {
            $regConsulta = false;
        } else {
            $regConsulta = true;
        }
    } else {
        if (($row['situacao_reg'] == 'FI' && $row['gfi_situacao'] == 'CB') || $row['situacao_reg'] == 'AP') {
            $regConsulta = true;
        } else {
            $regConsulta = false;
        }
    }

    switch ($campo) {
        case 'situacao_reg':
            if ($row['situacao_reg'] == '') {
                $html .= 'O credenciado não consultou este processo';
            } else {
                $html .= $vetAFProcessoSit[$row['situacao_reg']];

                if ($row['situacao_reg'] == 'FI') {
                    $html .= '<br />' . $vetAFProcessoFI[$row['gfi_situacao']];
                }
            }
            break;

        case 'entrega_realizada': //Distrato
            if ($regConsulta) {
                $html .= 'Sim';
            } else {
                $html .= 'Não';
            }
            break;
            
        case 'vl_executado': //Distrato
            if ($regConsulta) {
                $html .= 'Pagamento Aprovado';
                //$html .= 'Pagamento Liquidado';
            } else {
                $html .= '<input type = "hidden" value = "' . $row['codigo'] . '" name = "distrato_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][codigo]" />';
                $html .= 'R$: <input data-valor = "' . $row['vl_entrega_real'] . '" data-valant = "' . $row['vl_executado'] . '" value = "' . format_decimal($row['vl_executado']) . '" name = "distrato_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][vl_executado]" type = "text" class = "Texto vl_executado Obr" maxlength = "12" size = "12" />';
                $html .= '<br />';
                $html .= '%: <input data-valor = "' . $row['vl_entrega_real'] . '" data-valant = "' . $row['perc_executado'] . '" value = "' . format_decimal($row['perc_executado'], 8) . '" name = "distrato_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][perc_executado]" type = "text" class = "Texto perc_executado Obr" maxlength = "12" size = "12" />';
            }
            break;

        case 'mesano': //Aditivo
            if ($row['mesano_sem_atidivo'] != '') {
                $valor = $row['mesano_sem_atidivo'];
            }

            $html .= $valor;
            break;

        case 'vl_entrega_real': //Aditivo
            if ($row['vl_entrega_real_sem_atidivo'] != '') {
                $valor = $row['vl_entrega_real_sem_atidivo'];
            }

            $html .= format_decimal($valor);
            break;

        case 'valor': //Aditivo
            if ($regConsulta) {
                $html .= 'Pagamento Aprovado';
                //$html .= 'Pagamento Liquidado';
            } else {
                $html .= '<input type = "hidden" value = "' . $row['codigo'] . '" name = "aditivo_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][codigo]" />';
                $html .= '<input data-valor = "' . $row['vl_entrega_real'] . '" data-valant = "' . $row['valor'] . '" value = "' . format_decimal($row['valor']) . '" name = "aditivo_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][valor]" type = "text" class = "Texto entrega_valor" maxlength = "12" size = "12" />';
            }
            break;

        case 'data': //Aditivo
            if ($regConsulta) {
                $html .= 'Pagamento Aprovado';
                //$html .= 'Pagamento Liquidado';
            } else {
                //ultimo dia
                $vetMesAno = explode('/', $row['mesano']);
                $dia = cal_days_in_month(CAL_GREGORIAN, $vetMesAno[0], $vetMesAno[1]);
                $datasaida = $dia . '/' . $row['mesano'];

                $html .= '<input data-valor = "' . $datasaida . '" value = "' . trata_data($row['data']) . '" name = "aditivo_entrega[' . $row['idt_gec_contratacao_credenciado_ordem_entrega'] . '][data]" type = "text" class = "Texto entrega_data" size="10" maxlength="10" onkeyup="return Formata_Data(this,event)" />';
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_item($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
        case 'arquivo_ass':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_item/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_distrato_pdf($valor, $row, $campo) {
    global $vetSistemaUtiliza, $rowDados;

    $html = '';

    switch ($campo) {
        case 'empreendimento':
            if ($row['origem'] == 'PST') {
                $html .= $rowDados['pst_nome'] . '<br />' . $rowDados['pst_cnpj'];
            } else {
                $html .= $valor;
            }
            break;

        case 'arq_distrato':
            $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_distrato_pdf/';

            $url = ArquivoLink($path, $row[$campo], '', false, '', true);
            $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
            $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

            $html .= $url;
            break;

        case 'arq_distrato_ass':
            $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_distrato_pdf/';

            $url = ArquivoLink($path, $row[$campo], '', false, '', true);
            $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
            $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

            $html .= $url;

            if ($rowDados['situacao'] == 'AP') {
                if ($html != '') {
                    $html .= '<br />';
                }

                $name = 'arq_distrato_ass[' . $row['idt'] . ']';

                $html .= '<input name="' . $name . '" class="Texto fileAss" type="file">';
                $html .= '<script type="text/javascript">';
                $html .= "objFile[objFile.length] = '{$name}';";
                $html .= 'objFileMime[objFileMime.length] = vetMime.todos;';
                $html .= "objFileNome[objFileNome.length] = 'Distrato Assinado para o protocolo: {$row['protocolo']}';";
                $html .= '</script>';
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_anexo($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_anexo/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_distrato_anexos($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_distrato_anexos/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_distrato_parecer_anexos($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_distrato_parecer_anexos/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_aditivo_pdf($valor, $row, $campo) {
    global $vetSistemaUtiliza, $rowDados;

    $html = '';

    switch ($campo) {
        case 'empreendimento':
            if ($row['origem'] == 'PST') {
                $html .= $rowDados['pst_nome'] . '<br />' . $rowDados['pst_cnpj'];
            } else {
                $html .= $valor;
            }
            break;

        case 'arq_aditivo':
            $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_aditivo_pdf/';

            $url = ArquivoLink($path, $row[$campo], '', false, '', true);
            $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
            $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

            $html .= $url;
            break;

        case 'arq_aditivo_ass':
            $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_aditivo_pdf/';

            $url = ArquivoLink($path, $row[$campo], '', false, '', true);
            $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
            $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

            $html .= $url;

            if ($rowDados['situacao'] == 'AP') {
                if ($html != '') {
                    $html .= '<br />';
                }

                $name = 'arq_aditivo_ass[' . $row['idt'] . ']';

                $html .= '<input name="' . $name . '" class="Texto fileAss" type="file">';
                $html .= '<script type="text/javascript">';
                $html .= "objFile[objFile.length] = '{$name}';";
                $html .= 'objFileMime[objFileMime.length] = vetMime.todos;';
                $html .= "objFileNome[objFileNome.length] = 'Aditamento Assinado para o protocolo: {$row['protocolo']}';";
                $html .= '</script>';
            }
            break;

        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_aditivo_anexos($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_aditivo_anexos/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

function fnc_gec_contratar_credenciado_aditivo_parecer_anexos($valor, $row, $campo) {
    global $vetSistemaUtiliza;

    $html = '';

    switch ($campo) {
        case 'arquivo':
            if ($row[$campo] != '') {
                $path = $vetSistemaUtiliza['GEC']['path_file'] . '/gec_contratar_credenciado_aditivo_parecer_anexos/';

                $vetImagemProdPrefixo = explode('_', $row[$campo]);
                $ImagemProdPrefixo = '';

                if (is_numeric($vetImagemProdPrefixo[0]) && $vetImagemProdPrefixo[1] == $campo && is_numeric($vetImagemProdPrefixo[2])) {
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[0] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[1] . '_';
                    $ImagemProdPrefixo .= $vetImagemProdPrefixo[2] . '_';
                }

                $url = ArquivoLink($path, $row[$campo], $ImagemProdPrefixo, '', '', true);
                $url = str_replace($vetSistemaUtiliza['GEC']['path'] . 'admin/', $vetSistemaUtiliza['GEC']['url'], $url);
                $url = str_replace('localhost', $_SERVER['HTTP_HOST'], $url);

                $html .= $url;
            } else if ($row['cod_registro_ged'] != '') {
                $url = gedURLConsulta(gedCodDocDocumentacaoEntidade, $row['cod_registro_ged']);
                $html .= '<a href = "' . $url . '" target = "_blank">Link GED</a>';
            }
            break;


        default:
            $html .= $valor;
            break;
    }

    return $html;
}

/**
 * Decide para quem vai mandar a aprovação inicial do Distrato / Aditamento
 * @access public
 * @return situacao
 * @param int $idt_instrumento <p>
 * IDT do Atendimento Insrtrumento
 * </p>
 * @param int $idt_gestor_projeto <p>
 * IDT do Usuario do Gestor do Projeto
 * </p>
 * @param int $idt_responsavel <p>
 * IDT do Usuario do Cadastrante
 * </p>
 * @param int $idt_unidade <p>
 * IDT da Unidade
 * </p>
 * @param int $idt_ponto_atendimento <p>
 * IDT do PA
 * </p>
 * @param string $classificacao_unidade <p>
 * Classificação da Unidade
 * </p>
 * @param decimal $previsao_despesa <p>
 * Valor da Previsão de Despesa
 * </p>
 * @param dbx $rs_pendencia <p>
 * Devolve os usuarios que vão receber a pendencia do evento
 * </p>
 * @param boolean $temCG <p>
 * Tem pelo menos um usuario Coordenador / Gerente neste Evento?
 * </p>
 * @param boolean $temDI <p>
 * Tem pelo menos um usuario Diretor neste Evento?
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function decideAprovadorInicialDistratoAditivo($idt_instrumento, $idt_gestor_projeto, $idt_responsavel, $idt_unidade, $idt_ponto_atendimento, $classificacao_unidade, $previsao_despesa, &$rs_pendencia, &$temCG, &$temDI, $trata_erro = true) {
    $idt_gestor_projeto = IdUsuarioPIR($idt_gestor_projeto, db_pir_grc, db_pir_gec);

    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_gec . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_gestor_projeto);
    $rsGP = execsql($sql, $trata_erro);

    $sql = '';
    $sql .= ' select u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir_gec . 'plu_usuario u';
    $sql .= ' where u.id_usuario = ' . aspa($idt_responsavel);
    $rsCA = execsql($sql, $trata_erro);

    $idtSecaoPA = $idt_ponto_atendimento;
    $idtSecaoUN = $idt_unidade;

    //Diretoria
    $vetCod = explode('.', $classificacao_unidade);
    $vetCod[1] = '00';

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
    $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
    $rs = execsql($sql, $trata_erro);
    $idtSecaoDI = $rs->data[0][0];

    //Coordenador / Gerente
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
    $sql .= " where f.tipo_alcada_evento = 'CG'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $sql .= ' and ea.vl_alcada >= ' . null($previsao_despesa);
    $rsCG = execsql($sql, $trata_erro);

    if ($rsCG->rows == 0) {
        $sql = '';
        $sql .= ' select max(ea.vl_alcada) as max';
        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
        $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = p.cod_usuario';
        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= " where f.tipo_alcada_evento = 'CG'";
        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
        $sql .= " and p.ativo = 'S'";
        $rsCG = execsql($sql, $trata_erro);
        $max = $rsCG->data[0][0];

        if ($max === '' || is_null($max)) {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, null as vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $rsCG = execsql($sql, $trata_erro);
        } else {
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($idt_instrumento);
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $sql .= ' and ea.vl_alcada = ' . null($max);
            $rsCG = execsql($sql, $trata_erro);
        }
    }

    $temCG = $rsCG->rows > 0;

    $vetCG = Array();
    foreach ($rsCG->data as $row) {
        $vetCG[$row['id_usuario']] = $row['id_usuario'];
    }

    //Diretor
    $sql = '';
    $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
    $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = p.cod_usuario';
    $sql .= " where f.tipo_alcada_evento = 'DI'";
    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
    $sql .= " and p.ativo = 'S'";
    $rsDI = execsql($sql, $trata_erro);

    $temDI = $rsDI->rows > 0;

    $vetDI = Array();
    foreach ($rsDI->data as $row) {
        $vetDI[$row['id_usuario']] = $row['id_usuario'];
    }

    //É Diretor?
    if (in_array($idt_responsavel, $vetDI)) {
        $rs_pendencia = $rsCA;
        return 'AP';
    }

    //É Coordenador / Gerente?
    if (in_array($idt_responsavel, $vetCG)) {
        $sql = '';
        $sql .= ' select ea.vl_alcada';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
        $sql .= ' inner join ' . db_pir_gec . 'plu_usuario u on u.login = op.cod_usuario';
        $sql .= ' where ea.idt_instrumento = ' . null($idt_instrumento);
        $sql .= ' and u.id_usuario = ' . null($idt_responsavel);
        $rsEA = execsql($sql);
        $vl_alcada = $rsEA->data[0][0];

        if ($vl_alcada == '') {
            $vl_alcada = 0;
        }

        if ($previsao_despesa > $vl_alcada) {
            $rs_pendencia = $rsDI;
            return 'DI';
        } else {
            $rs_pendencia = $rsCA;
            return 'AP';
        }
    }

    //É Gestor do Projeto?
    if ($idt_gestor_projeto == $idt_responsavel) {
        $rs_pendencia = $rsCG;
        return 'CG';
    }

    $rs_pendencia = $rsGP;
    return 'GP';
}

/**
 * Cria o registro do Evento Retificadora do Distrato
 * @access public
 * @return int IDT do Evento criado
 * @param int $idt_ordem <p>
 * IDT da Ordem de Contratação
 * </p>
 * @param int $idt_distrato <p>
 * IDT do Distrato
 * </p>
 * @param int $idt_evento_distrato <p>
 * IDT do Evento do Distrato
 * </p>
 * @param int $valor_distrato <p>
 * Valor do Distrato
 * </p>
 * */
function cria_evento_retificadora($idt_ordem, $idt_distrato, $idt_evento_distrato, $valor_distrato) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= ' where idt_contratar_credenciado_distrato = ' . null($idt_distrato);
    $rs = execsql($sql);

    if ($rs->rows > 0) {
        return $rs->data[0][0];
    }

    $id_usuario_grc = $_SESSION[CS]['g_id_usuario'];

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_grc . 'grc_evento';
    $sql .= ' where idt = ' . null($idt_evento_distrato);
    $rs = execsql($sql);
    $rowe = $rs->data[0];

    $idt_evento = GravarEvento($rowe['idt_instrumento'], $id_usuario_grc);

    $dt_previsao_inicial = date('d/m/Y');

    $sql = '';
    $sql .= ' select valor';
    $sql .= ' from ' . db_pir_grc . 'plu_config';
    $sql .= " where variavel = 'evento_sg_qtd_inicio'";
    $rs = execsql($sql);
    $evento_sg_qtd_inicio = $rs->data[0][0];

    if (is_numeric($evento_sg_qtd_inicio)) {
        $dt_previsao_inicial = Calendario::Intervalo_Util($dt_previsao_inicial, $evento_sg_qtd_inicio);
    }

    $dt_previsao_fim = $dt_previsao_inicial;

    if ($rowe['entrega_prazo_max'] != '') {
        $dt_previsao_fim = Calendario::Intervalo_Util($dt_previsao_fim, $rowe['entrega_prazo_max']);
    }

    $dt_previsao_inicial = trata_data($dt_previsao_inicial);
    $dt_previsao_fim = trata_data($dt_previsao_fim);

    $vet = Array(
        'idt_contratar_credenciado_distrato' => $idt_distrato,
        'idt_projeto' => $rowe['idt_projeto'],
        'idt_acao' => $rowe['idt_acao'],
        'idt_produto' => $rowe['idt_produto'],
        'idt_gestor_evento' => $rowe['idt_gestor_evento'],
        'objetivo' => $rowe['objetivo'],
        'resultado_esperado' => $rowe['resultado_esperado'],
        'gestor_sge' => '',
        'fase_acao_projeto' => '',
        'idt_gestor_projeto' => '',
        'idt_unidade' => $rowe['idt_unidade'],
        'idt_ponto_atendimento' => $rowe['idt_ponto_atendimento'],
        'idt_ponto_atendimento_tela' => $rowe['idt_ponto_atendimento_tela'],
        'ano_competencia' => date('Y'),
        'qtd_previsto' => '',
        'qtd_realizado' => '',
        'qtd_percentual' => '',
        'qtd_saldo' => '',
        'orc_previsto' => '',
        'orc_realizado' => '',
        'orc_percentual' => '',
        'orc_saldo' => '',
        'entrega_prazo_max' => $rowe['entrega_prazo_max'],
        'vl_determinado' => 'N',
        'idt_foco_tematico' => $rowe['idt_foco_tematico'],
        'maturidade' => $rowe['maturidade'],
        'descricao' => $rowe['descricao'],
        'idt_publico_alvo' => $rowe['idt_publico_alvo'],
        'idt_programa' => $rowe['idt_programa'],
        'cep' => $rowe['cep'],
        'idt_cidade' => $rowe['idt_cidade'],
        'dt_previsao_inicial' => $dt_previsao_inicial,
        'dt_previsao_fim' => $dt_previsao_fim,
        'custo_tot_consultoria' => $valor_distrato,
        'quantidade_participante' => $rowe['quantidade_participante'],
        'cred_necessita_credenciado' => 'S',
        'cred_rodizio_auto' => 'S',
        'cred_credenciado_sgc' => 'N',
        'cred_contratacao_cont' => 'N',
        'temporario' => 'N',
        'idt_evento_situacao_ant' => 1,
        'contrapartida_sgtec' => '',
    );

    $postORG = $_POST;

    try {
        $_POST['idt_instrumento'] = $rowe['idt_instrumento'];
        $_POST['idt_evento'] = $idt_evento;
        $_POST['idt_acao'] = $rowe['idt_acao'];
        $_POST['ano_competencia'] = $rowe['ano_competencia'];
        $_POST['participacao_sebrae'] = $rowe['participacao_sebrae'];

        PreparaAcaoEvento($vet);
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }

    $_POST = $postORG;

    $vet['contrapartida_sgtec'] = desformat_decimal($vet['contrapartida_sgtec']);
    $vet['qtd_previsto'] = desformat_decimal($vet['qtd_previsto']);
    $vet['qtd_realizado'] = desformat_decimal($vet['qtd_realizado']);
    $vet['qtd_percentual'] = desformat_decimal($vet['qtd_percentual']);
    $vet['qtd_saldo'] = desformat_decimal($vet['qtd_saldo']);
    $vet['orc_previsto'] = desformat_decimal($vet['orc_previsto']);
    $vet['orc_realizado'] = desformat_decimal($vet['orc_realizado']);
    $vet['orc_percentual'] = desformat_decimal($vet['orc_percentual']);
    $vet['orc_saldo'] = desformat_decimal($vet['orc_saldo']);

    $sql = "select grc_ps.descricao as etapa ";
    $sql .= " from " . db_pir_grc . "grc_projeto as pr ";
    $sql .= " left join " . db_pir_grc . "grc_projeto_situacao grc_ps on grc_ps.idt = pr.idt_projeto_situacao ";
    $sql .= ' where pr.idt = ' . null($rowe['idt_projeto']);
    $rs = execsql($sql);
    $vet['fase_acao_projeto'] = $rs->data[0][0];

    //insumo
    $sql = '';
    $sql .= ' insert into ' . db_pir_grc . 'grc_evento_insumo (';
    $sql .= " idt_evento, qtd_automatico, idt_area_suporte, idt_profissional, idt_insumo, codigo, descricao, detalhe,";
    $sql .= " ativo, quantidade, quantidade_evento, custo_unitario_real, idt_insumo_unidade, por_participante)";
    $sql .= " select {$idt_evento} as idt_evento, qtd_automatico, idt_area_suporte, idt_profissional, idt_insumo, codigo, descricao, detalhe,";
    $sql .= " ativo, quantidade, quantidade_evento, custo_unitario_real, idt_insumo_unidade, por_participante ";
    $sql .= ' from ' . db_pir_grc . 'grc_evento_insumo';
    $sql .= ' where idt_evento = ' . null($idt_evento_distrato);
    $sql .= " and codigo <> 'evento_insc'";
    execsql($sql);

    $vetSQL = Array();

    foreach ($vet as $key => $value) {
        $vetSQL[] = $key . ' = ' . aspa($value);
    }

    $sql = 'update ' . db_pir_grc . 'grc_evento set ';
    $sql .= implode(', ', $vetSQL);
    $sql .= ' where idt = ' . null($idt_evento);
    execsql($sql);

    SincronizaProfissionalEvento($idt_evento);

    $sql = 'update ' . db_pir_grc . 'grc_evento_insumo set custo_unitario_real = ' . null($valor_distrato);
    $sql .= ', custo_total = ' . null($valor_distrato);
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= " and codigo = '71001'";
    execsql($sql);

    $_SESSION[CS]['g_idt_unidade_regional'] = $vet['idt_ponto_atendimento'];
    $_SESSION[CS]['g_idt_projeto'] = $vet['idt_projeto'];
    $_SESSION[CS]['g_idt_acao'] = $vet['idt_acao'];
    $_SESSION[CS]['g_projeto_gestor'] = $vet['gestor_sge'];
    $_SESSION[CS]['g_projeto_etapa'] = $vet['fase_acao_projeto'];
    carregaCompetencia();

    //Matricula
    $sql = '';
    $sql .= ' select p.cpf, ep.idt_midia, p.idt_atendimento, ';
    $sql .= ' o.cnpj, o.dap, o.nirf, o.rmp, o.ie_prod_rural, o.idt_tipo_empreendimento, o.representa_codcargcli';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa p';
    $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento a on a.idt = p.idt_atendimento';
    $sql .= " left outer join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento";
    $sql .= " left outer join " . db_pir_grc . "grc_atendimento_organizacao o on o.idt_atendimento = p.idt_atendimento and o.representa = 'S' and o.desvincular = 'N'";
    $sql .= ' where a.idt_evento = ' . null($idt_evento_distrato);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $rs = execsql($sql);

    $cotacao = $valor_distrato / $rs->rows;

    foreach ($rs->data as $rowp) {
        $parCPF = Array();
        $parCPF['erro'] = "";
        $parCPF['cpf'] = $rowp['cpf'];
        $parCPF['idt_instrumento'] = $rowe['idt_instrumento'];
        $parCPF['idt_pf'] = 0;
        $parCPF['idt_evento'] = $idt_evento;
        $parCPF['bancoTransaction'] = 'N';
        $parCPF['evento_origem'] = 'PIR';
        $parCPF['id_usuario'] = $id_usuario_grc;

        BuscaCPF(0, $parCPF);

        $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante (idt_atendimento, vl_tot_pagamento, idt_midia, contrato) VALUES (';
        $sql .= null($parCPF['idt_atendimento']) . ', null, ' . null($rowp['idt_midia']) . ", 'R')";
        execsql($sql);

        $parCNPJ = Array();
        $parCNPJ['erro'] = "";

        if (validaCNPJ($rowp['cnpj'])) {
            $parCNPJ['cnpj'] = FormataCNPJ($rowp['cnpj']);
        } else {
            $parCNPJ['cnpj'] = '';
        }

        $variavel['idt_tipo_empreendimento'] = $rowp['idt_tipo_empreendimento'];
        $parCNPJ['dap'] = $rowp['dap'];
        $parCNPJ['nirf'] = $rowp['nirf'];
        $parCNPJ['rmp'] = $rowp['rmp'];
        $parCNPJ['ie_prod_rural'] = $rowp['ie_prod_rural'];
        $parCNPJ['bancoTransaction'] = 'N';

        BuscaCNPJ($parCPF['idt_atendimento'], $parCNPJ);

        $sql = "update " . db_pir_grc . "grc_atendimento_organizacao set";
        $sql .= " novo_registro = 'N',";
        $sql .= " representa = 'S',";
        $sql .= " modificado = 'S',";
        $sql .= " representa_codcargcli = " . null($rowp['representa_codcargcli']);
        $sql .= " where idt = " . null($parCNPJ['idt_atendimento_organizacao']);
        execsql($sql);

        $sql = "update " . db_pir_grc . "grc_atendimento_pessoa set representa_empresa = 'S'";
        $sql .= " where idt = " . null($parCPF['idt_atendimento_pessoa']);
        execsql($sql);

        $idt_atendimento = $parCPF['idt_atendimento'];

        //Entregas
        $sql = '';
        $sql .= ' select oe.idt, oe.codigo, oe.descricao, oe.detalhe, oe.ordem, oe.vl_entrega_real - de.vl_executado as vl';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega oe';
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega de on de.idt_gec_contratacao_credenciado_ordem_entrega = oe.idt';
        $sql .= ' where oe.idt_gec_contratacao_credenciado_ordem = ' . null($idt_ordem);
        $sql .= ' and oe.idt_atendimento = ' . null($rowp['idt_atendimento']);
        $sql .= ' and de.idt_distrato = ' . null($idt_distrato);
        $sql .= ' and de.perc_executado < 100';
        $rs = execsql($sql);

        foreach ($rs->data as $row) {
            $percentual = $row['vl'] * 100 / $cotacao;

            $sql = '';
            $sql .= ' insert into ' . db_pir_grc . 'grc_evento_entrega (idt_evento, idt_atendimento, codigo, descricao, detalhe, percentual, valor, ordem) values (';
            $sql .= null($idt_evento) . ', ' . null($idt_atendimento) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
            $sql .= null($percentual) . ', ' . null($row['vl']) . ', ' . aspa($row['ordem']) . ')';
            execsql($sql);
            $idt_evento_entrega = lastInsertId();

            $sql = '';
            $sql .= ' insert into ' . db_pir_grc . 'grc_evento_entrega_documento (idt_evento_entrega, idt_documento, codigo)';
            $sql .= ' select ' . $idt_evento_entrega . ' as idt_evento_entrega, idt_documento, codigo';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega_documento';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem_entrega = ' . null($row['idt']);
            execsql($sql);
        }

        //Dimensionamento
        $sql = '';
        $sql .= ' insert into ' . db_pir_grc . 'grc_evento_dimensionamento (idt_evento, idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, qtd, vl_total)';
        $sql .= ' select ' . $idt_evento . ' as idt_evento, ' . $idt_atendimento . ' as idt_atendimento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario, qtd, vl_total';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_dimensionamento';
        $sql .= ' where idt_evento = ' . null($idt_evento_distrato);
        $sql .= ' and idt_atendimento = ' . null($rowp['idt_atendimento']);
        execsql($sql);
    }

    $sql = '';
    $sql .= ' select count(x.idt_atendimento) as qtd, avg(x.pag) as media';
    $sql .= ' from (';
    $sql .= ' select a.idt as idt_atendimento, sum(p.valor_pagamento) as pag';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante_pagamento p on p.idt_atendimento = a.idt';
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' where a.idt_evento = ' . null($idt_evento);
    $sql .= " and (p.estornado is null or p.estornado <> 'S')";
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= ' group by a.idt';
    $sql .= ' ) x';
    $rs = execsql($sql);
    $rowu = $rs->data[0];

    $tot = $rowu['qtd'] * $rowu['media'];

    $sql = 'update ' . db_pir_grc . 'grc_evento set valor_inscricao = ' . null($rowu['media']);
    $sql .= ', quantidade_participante = ' . null($rowu['qtd']);
    $sql .= ', previsao_receita = ' . null($tot);
    $sql .= " where idt = " . null($idt_evento);
    execsql($sql);

    $sql = 'update ' . db_pir_grc . 'grc_evento_insumo set';
    $sql .= ' quantidade = 1, ';
    $sql .= ' quantidade_evento = ' . null($rowu['qtd']) . ', ';
    $sql .= ' custo_unitario_real = ' . null($rowu['media']) . ', ';
    $sql .= ' rtotal_minimo = ' . null($tot) . ', ';
    $sql .= ' rtotal_maximo = ' . null($tot) . ', ';
    $sql .= ' receita_total = ' . null($tot);
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= " and codigo = 'evento_insc'";
    execsql($sql);

    CalcularInsumoEvento($idt_evento);

    return $idt_evento;
}

/**
 * Calcula o valor da Devolução do Cliente no Distrato
 * @access public
 * @return tipo
 * @param int $idt_distrato <p>
 * IDT do Distrato
 * </p>
 * @param int $valor_total <p>
 * Valor Total (R$) (realizado + a pagar):
 * </p>
 * @param boolean $trata_erro [opcional] <p>
 * Trata o erro do SQL.
 * </p>
 * */
function calculaValorDistratoDevolucao($idt_distrato, $valor_total, $trata_erro = true) {
    /*
     * O valor devolvido vai ser sempre 100% pago que esta sendo calculado na função atualizaRegDevolucaoSG
    $sql = '';
    $sql .= ' select ord.idt_evento';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato ccd';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' where ccd.idt = ' . null($idt_distrato);
    $rs = execsqlNomeCol($sql, $trata_erro);
    $rowDados = $rs->data[0];

    $sql = '';
    $sql .= ' select count(ea.idt) as qtd';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento ea';
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = ea.idt';
    $sql .= ' where ea.idt_evento = ' . null($rowDados['idt_evento']);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $rs = execsql($sql, $trata_erro);
    $quantidade_participante = $rs->data[0][0];

    if ($quantidade_participante == '') {
        $quantidade_participante = 0;
    }

    if ($quantidade_participante == 0) {
        $cotacao = 0;
    } else {
        $cotacao = $valor_total / $quantidade_participante;
    }

    $sql = '';
    $sql .= ' select ep.idt_atendimento, ep.idt as idt_ep, e.contrapartida_sgtec, ifnull(ep.vl_tot_pagamento_real, ep.vl_tot_pagamento) as pag_prev';
    $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' inner join ' . db_pir_grc . 'grc_evento e on e.idt = a.idt_evento';
    $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $rs_ep = execsql($sql, $trata_erro);

    foreach ($rs_ep->data as $row_ep) {
        if ($row_ep['contrapartida_sgtec'] == '') {
            $pag_real = $cotacao;
        } else {
            $pag_real = round($cotacao * $row_ep['contrapartida_sgtec'] / 100, 2);
        }

        $vl_tot_devolucao = $row_ep['pag_prev'] - $pag_real;

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_contadevolucao';
        $sql .= ' where idt_atendimento = ' . null($row_ep['idt_atendimento']);
        $sql .= " and reg_origem = 'DI'";
        $rsd = execsql($sql, $trata_erro);

        foreach ($rsd->data as $rowd) {
            $per_devolucao = $rowd['vl_pago'] * 100 / $row_ep['pag_prev'];
            $vl_devolucao = $vl_tot_devolucao * $per_devolucao / 100;

            $sql = 'update ' . db_pir_grc . 'grc_evento_participante_contadevolucao set vl_devolucao = ' . null($vl_devolucao);
            $sql .= ' where idt = ' . null($rowd['idt']);
            execsql($sql, $trata_erro);
        }
    }
     * 
     */
}

/**
 * Gera condições para o where da tabela grc_atendimento_pendencia
 * @access public
 * @return string
 * */
function whereAtendimentoPendencia() {
    $sql = '';

    $sql .= ' and (dt_limite_trans is null or dt_limite_trans >= ' . aspa(trata_data(getdata(false, true))) . ')';

    return $sql;
}
