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
        width:130px;
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
    td.botao_concluir_atendimento_desc {
        background:#C0C0C0;
    }
    .barra_final {
        text-align:center;
    }

    .sem_width {
        width: auto;
    }
</style>
<?php
echo " <div class='barra_final' >";

$id_usuarioSTR = $_SESSION[CS]['g_id_usuario'];
$id_usuarioSTR = (string) $id_usuarioSTR;

if ($origem_evento_tela == 'grc_evento_publicar_acao') {
    echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else
if ($idt_evento_pai != '') {
    if ($acao == 'alt' && ($idt_evento_situacao == 1 || $idt_evento_situacao == 5)) {
        echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";
    }

    echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
    echo " <div style='margin:8px; '>Voltar</div>";
    echo " </div>";
} else
if ($idt_pfo_af_processo == '') {
    if ($idt_instrumento == 2) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento_agenda';
        $sql .= ' where idt_evento = ' . null($idt_evento);
        $sql .= ' and idt_atendimento is null';
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            echo " <div class='botao_ag_bl sem_width' id='ExcluirAgendaErrada' onclick='return ExcluirAgendaErrada();' >";
            echo " <div style='margin:8px; '>Excluir o Cronograma / Atividades sem Cliente</div>";
            echo " </div>";
        }
    }

    if ($so_inscricao === true) {
        echo " <div class='botao_ag_bl' onclick='return SalvarConsolidacao();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if ($origem_evento_tela == 'combo') {
        if ($acao == 'exc') {
            if ($grc_evento_temporario == 'S') {
                echo " <div class='botao_ag_bl' onclick='return VoltarEvento(true);' >";
                echo " <div style='margin:8px; '>Excluir Evento</div>";
                echo " </div>";
            } else {
                switch ($idt_evento_situacao) {
                    case 1:
                    case 5:
                        if ($id_usuarioSTR == $idt_responsavel) {
                            echo " <div class='botao_ag_bl' onclick='return ExcluirEvento();' >";
                            echo " <div style='margin:8px; '>Excluir Evento</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Excluir este evento, pois não tem permissão!');
                        }
                        break;

                    case 4:
                    case 21:
                        alert('Evento já Cancelado!');
                        break;

                    default:
                        alert('Não pode Cancelar este evento!');
                        break;
                }
            }
        } else
        if (($acao == 'inc' || $acao == 'alt') && $acao_alt_con == 'N') {
            echo " <div class='botao_ag_b2' onclick='return EnviarAprovarEventoCombo();' >";
            echo " <div style='margin:8px; '>Enviar para Aprovação</div>";
            echo " </div>";

            echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
            echo " <div style='margin:8px; '>Salvar</div>";
            echo " </div>";

            if ($grc_evento_temporario == 'S') {
                echo " <div class='botao_ag_bl' onclick='return VoltarEvento(true);' >";
                echo " <div style='margin:8px; '>Excluir Evento</div>";
                echo " </div>";
            }
        } else {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pendencia';
            $sql .= ' where idt = ' . null($_GET['idt_pendencia']);
            $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
            $sql .= " and ativo = 'S'";
            $sql .= " and tipo = 'Evento Combo'";
            $sql .= whereAtendimentoPendencia();
            $rs = execsql($sql);
            $responsavel_solucao = $rs->rows > 0;

            if ($idt_evento_situacao == 6) {
                if ($responsavel_solucao) {
                    echo " <div class='botao_ag_b2 sem_width' onclick='return AprovarEvento(\"GestorAprovarEventoCombo\");' >";
                    echo " <div style='margin:8px;'>Aprovar o Evento</div>";
                    echo " </div>";

                    echo " <div class='botao_ag_b2' onclick='return DevolverEvento(true);' >";
                    echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
                    echo " </div>";
                }
            }
        }

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if ($origem_evento_tela == 'compra') {
        if ($acao == 'alt') {
            echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
            echo " <div style='margin:8px; '>Salvar</div>";
            echo " </div>";
        }

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if ($origem_evento_tela == 'grc_evento_nf') {
        if ($acao == 'alt') {
            echo " <div class='botao_ag_bl' onclick='return SalvarConsolidacao();' >";
            echo " <div style='margin:8px; '>Salvar</div>";
            echo " </div>";
        }

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if ($origem_evento_tela == 'grc_evento_acompanhar') {
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if ($acao == 'con') {
        if ($prefixo_volta == 'listar_cmb') {
            echo " <div class='botao_ag_bl' onclick='parent.hidePopWin(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else {
            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        }
    } else
    if ($acao == 'exc') {
        if ($grc_evento_temporario == 'S') {
            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(true);' >";
            echo " <div style='margin:8px; '>Excluir Evento</div>";
            echo " </div>";
        } else {
            if ($veio == 'SG' && $sgtec_modelo == 'E') {
                switch ($idt_evento_situacao) {
                    case 1: //EM CONSTRUÇÃO
                    case 5: //DEVOLVIDO
                    //case 24: //EM COTAÇÃO
                        if ($id_usuarioSTR == $idt_gestor_evento) {
                            echo " <div class='botao_ag_bl' onclick='return CancelarEventoAprovado(true);' >";
                            echo " <div style='margin:8px; '>Cancelar Evento</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Cancelar este evento, pois não tem permissão!');
                        }
                        break;

                    case 22: //CANCELADO APÓS APROVAÇÃO COM ERRO
                        if ($id_usuarioSTR == $idt_gestor_evento) {
                            echo " <div class='botao_ag_bl sem_width' onclick='return CancelarEventoAprovado22();' >";
                            echo " <div style='margin:8px; '>Tentar cancelar o evento outra vez</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Cancelar este evento, pois não tem permissão!');
                        }
                        break;

                    case 4: //CANCELADO DURANTE APROVAÇÃO
                    case 21: //CANCELADO APÓS APROVAÇÃO
                        alert('Evento já Cancelado!');
                        break;

                    default:
                        alert('Não pode Cancelar este evento!');
                        break;
                }
            } else {
                switch ($idt_evento_situacao) {
                    case 1: //EM CONSTRUÇÃO
                    case 5: //DEVOLVIDO
                    case 6: //EM TRAMITAÇÃO
                        if ($id_usuarioSTR == $idt_gestor_evento) {
                            echo " <div class='botao_ag_bl' onclick='return CancelarEvento_alt();' >";
                            echo " <div style='margin:8px; '>Cancelar Evento</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Cancelar este evento, pois não tem permissão!');
                        }
                        break;

                    case 14: //AGENDADO
                    case 16: //EM EXECUÇÃO
                    case 19: //PENDENTE
                        if ($id_usuarioSTR == $idt_gestor_evento) {
                            echo " <div class='botao_ag_bl sem_width' onclick='return SoCancelarEventoAprovado();' >";
                            echo " <div style='margin:8px; '>Solicitar Cancelamento</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Cancelar este evento, pois não tem permissão!');
                        }
                        break;

                    case 22: //CANCELADO APÓS APROVAÇÃO COM ERRO
                        if ($id_usuarioSTR == $idt_gestor_evento) {
                            echo " <div class='botao_ag_bl sem_width' onclick='return CancelarEventoAprovado22();' >";
                            echo " <div style='margin:8px; '>Tentar cancelar o evento outra vez</div>";
                            echo " </div>";
                        } else {
                            alert('Não pode Cancelar este evento, pois não tem permissão!');
                        }
                        break;

                    case 4: //CANCELADO DURANTE APROVAÇÃO
                    case 21: //CANCELADO APÓS APROVAÇÃO
                        alert('Evento já Cancelado!');
                        break;

                    default:
                        alert('Não pode Cancelar este evento!');
                        break;
                }
            }
        }

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else
    if (($acao == 'inc' || $acao == 'alt') && $acao_alt_con == 'N') {
        if ($veio == 'SG') {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
            $sql .= ' where idt_evento = ' . null($idt_evento);
            $sql .= " and ativo = 'S'";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                if ($sgtec_modelo == 'H') {
                    echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return Credenciado();' >";
                    echo " <div style='margin:8px; '>Criar Ordem de Contratação</div>";
                    echo " </div>";
                }
            } else {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            if ($vl_determinado == 'S' && $sgtec_modelo == 'E') {
                echo " <div class='botao_ag_b2' onclick='return EnviarAprovarEvento({$idt_evento});' >";
                echo " <div style='margin:8px; '>Enviar para Aprovação</div>";
                echo " </div>";
            } else
            if ($sgtec_modelo == 'H') {
                echo " <div class='botao_ag_b2' onclick='return PreAprovarEvento({$idt_evento}, \"PRÉ-APROVAÇÃO do\");' >";
                echo " <div style='margin:8px; '>Pré-Aprovar o Evento</div>";
                echo " </div>";
            } else {
                echo " <div class='botao_ag_b2' onclick='return PreAprovarEvento({$idt_evento}, \"ENVIAR PARA COTAÇÃO o\");' >";
                echo " <div style='margin:8px; '>Enviar para Cotação</div>";
                echo " </div>";
            }
        } else {
            echo " <div class='botao_ag_b2' onclick='return EnviarAprovarEvento({$idt_evento});' >";
            echo " <div style='margin:8px; '>Enviar para Aprovação</div>";
            echo " </div>";
        }

        echo " <div class='botao_ag_bl' onclick='return SalvarEvento();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        if ($grc_evento_temporario == 'S') {
            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(true);' >";
            echo " <div style='margin:8px; '>Excluir Evento</div>";
            echo " </div>";
        }

        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";
    } else {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_pendencia';
        $sql .= ' where idt = ' . null($_GET['idt_pendencia']);
        $sql .= ' and idt_responsavel_solucao = ' . null($_SESSION[CS]['g_id_usuario']);
        $sql .= " and ativo = 'S'";
        $sql .= " and tipo = 'Evento'";
        $sql .= whereAtendimentoPendencia();
        $rs = execsql($sql);
        $responsavel_solucao = $rs->rows > 0;

        if ($idt_evento_situacao == 2 || $idt_evento_situacao == 3 || $idt_evento_situacao == 6 || $idt_evento_situacao == 7) {
            if ($responsavel_solucao) {
                switch ($idt_evento_situacao) {
                    case 2:
                        $lbl_funcao = 'Validar e Encaminhar para Coordenador/Gerente';
                        $idt_evento_situacao_novo = 3;
                        break;

                    case 3:
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

                        $limite = date('d/m/Y', strtotime('-' . $prazo . ' days', strtotime($dt_previsao_inicial)));
                        $diff = diffDate(date("d/m/Y"), $limite);

                        if ($diff > 0) {
                            $sql = '';
                            $sql .= ' select ea.vl_alcada';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento_alcada ea';
                            $sql .= ' inner join ' . db_pir . 'sca_organizacao_pessoa op on op.idt_funcao = ea.idt_sca_organizacao_funcao';
                            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = op.cod_usuario';
                            $sql .= ' where ea.idt_instrumento = ' . null($idt_instrumento);
                            $sql .= ' and u.id_usuario = ' . null($id_usuarioSTR);
                            $rsEA = execsql($sql);
                            $vl_alcada = $rsEA->data[0][0];

                            if ($vl_alcada == '') {
                                $vl_alcada = 0;
                            }
                        }

                        if ($previsao_despesa > $vl_alcada) {
                            $lbl_funcao = 'Validar e Encaminhar para Diretor';
                            $idt_evento_situacao_novo = 7;
                        } else {
                            $lbl_funcao = 'Aprovar o Evento';
                            $idt_evento_situacao_novo = 14;
                        }
                        break;

                    default:
                        $lbl_funcao = 'Aprovar o Evento';
                        $idt_evento_situacao_novo = 14;
                        break;
                }

                echo " <div class='botao_ag_b2 sem_width' onclick='return AprovarEvento({$idt_evento_situacao_novo});' >";
                echo " <div style='margin:8px;'>" . $lbl_funcao . "</div>";
                echo " </div>";

                if (!($veio == 'SG' && $sgtec_modelo == 'E')) {
                    echo " <div class='botao_ag_b2' onclick='return DevolverEvento(false);' >";
                    echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
                    echo " </div>";
                } else
                if ($vl_determinado == 'N') {
                    echo " <div class='botao_ag_b2 sem_width' onclick='return DevolverCotacaoFinalizada();' >";
                    echo " <div style='margin:8px; '>Devolver para o Responsável pelo Evento</div>";
                    echo " </div>";
                }

                if ($veio == 'SG' && $sgtec_modelo == 'E') {
                    echo " <div class='botao_ag_bl' onclick='return CancelarEventoAprovado(false);' >";
                    echo " <div style='margin:8px; '>Cancelar Evento</div>";
                    echo " </div>";
                } else {
                    echo " <div class='botao_ag_bl' onclick='return CancelarEvento_alt();' >";
                    echo " <div style='margin:8px; '>Cancelar Evento</div>";
                    echo " </div>";
                }

                echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
                echo " <div style='margin:8px; '>Voltar</div>";
                echo " </div>";
            } else {
                if ($veio == 'SG') {
                    echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                    echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                    echo " </div>";
                }

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_pendencia';
                $sql .= ' where idt_evento = ' . null($idt_evento);
                $sql .= ' and idt_usuario = ' . null($_SESSION[CS]['g_id_usuario']);
                $sql .= " and ativo = 'S'";
                $sql .= " and tipo = 'Evento'";
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    if ($veio == 'SG' && $sgtec_modelo == 'E' && $vl_determinado == 'N') {
                        echo " <div class='botao_ag_b2 sem_width' onclick='return DevolverCotacaoFinalizada();' >";
                        echo " <div style='margin:8px; '>Cancelar Despacho</div>";
                        echo " </div>";
                    } else {
                    echo " <div class='botao_ag_bl' onclick='return CancelarDespacho();' >";
                    echo " <div style='margin:8px; '>Cancelar Despacho</div>";
                    echo " </div>";
                }
                }

                echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
                echo " <div style='margin:8px; '>Voltar</div>";
                echo " </div>";
            }
        } else
        if ($idt_evento_situacao == 14 || $idt_evento_situacao == 16) {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            if ($composto != 'S') {
                if (($adm_evento_qtd == 90 || $id_usuarioSTR === $idt_gestor_evento) || ($adm_evento_qtd == 90 && $idt_instrumento != 52)) {
                    echo " <div class='botao_ag_bl' onclick='return AlterarEvento();' >";
                    echo " <div style='margin:8px; '>Salvar</div>";
                    echo " </div>";
                }
            }

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else
        if ($idt_evento_situacao == 19) {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            $coloca_salvar = true;

            if ($adm_evento_qtd == 90 && $idt_instrumento != 52) {
                $coloca_salvar = false;
                echo " <div class='botao_ag_bl' onclick='return AlterarEvento();' >";
                echo " <div style='margin:8px; '>Salvar</div>";
                echo " </div>";
            }

            if ($coloca_salvar) {
                echo " <div class='botao_ag_bl' onclick='return SalvarConsolidacao();' >";
                echo " <div style='margin:8px; '>Salvar</div>";
                echo " </div>";
            }

            if (!acesso($menu, "'extra1'", false)) {
                echo " <div class='botao_ag_bl' onclick='return ConsolidarEvento();' >";
                echo " <div style='margin:8px; '>Consolidar</div>";
                echo " </div>";
            }

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else
        if ($idt_evento_situacao == 20) {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

			echo " <div class='botao_ag_bl' onclick='return DesconsolidarEvento();' >";
			echo " <div style='margin:8px; '>Desconsolidar</div>";
			echo " </div>";

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else
        if ($idt_evento_situacao == 23) {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            if ($responsavel_solucao) {
                echo " <div class='botao_ag_b2' onclick='return CancelarEventoAprovado(false);' >";
                echo " <div style='margin:8px; '>Aprovar Cancelamento</div>";
                echo " </div>";

                echo " <div class='botao_ag_b2' onclick='return DevolverCancelamentoEvento();' >";
                echo " <div style='margin:8px; '>Devolver Cancelamento</div>";
                echo " </div>";
            } else {
                /*
                  if ($id_usuarioSTR == $idt_gestor_evento) {
                  echo " <div class='botao_ag_bl' onclick='return CancelarDespacho();' >";
                  echo " <div style='margin:8px; '>Cancelar Despacho</div>";
                  echo " </div>";
                  }
                 * 
                 */
            }

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else
        if (($idt_evento_situacao == 24 && $sgtec_modelo == 'H') || $idt_evento_situacao == 8) {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            if ($sgtec_modelo == 'H') {
                echo " <div class='botao_ag_b2' onclick='return CanPreAprovarEvento({$idt_evento});' >";
                echo " <div style='margin:8px; '>Cancelar a Pré-Aprovação</div>";
                echo " </div>";
            }

            echo " <div class='botao_ag_b2' onclick='return EnviarAprovarEvento({$idt_evento});' >";
            echo " <div style='margin:8px; '>Enviar para Aprovação</div>";
            echo " </div>";

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        } else {
            if ($veio == 'SG') {
                echo " <div id='btCredenciado' class='botao_ag_b2' onclick='return AbrirOrdem();' >";
                echo " <div style='margin:8px; '>Ordem de Contratação</div>";
                echo " </div>";
            }

            echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
            echo " <div style='margin:8px; '>Voltar</div>";
            echo " </div>";
        }
    }
} else {
    $vetTmp = DatetoArray(trata_data($rowPFO['data_registro']));

    if ($vetTmp['ano'] < date('Y')) {
        $pfoAprovarEAmsg = 'S';
    } else {
        $pfoAprovarEAmsg = 'N';
    }

    if ($rowPFO['situacao_reg'] == 'ED') {
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";

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
    } else
    if ($rowPFO['situacao_reg'] == 'GE') {
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl' onclick='return pfoSalvar();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolverEA();'>";
        echo " <div style='margin:8px; '>Reprovar Prestação de Contas</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAprovarGE();'>";
        echo " <div style='margin:8px; '>Aprovar Prestação de Contas</div>";
        echo " </div>";
    } else
    if ($rowPFO['situacao_reg'] == 'PG') {
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl' onclick='return pfoSalvar();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolver();'>";
        echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAprovarEA();'>";
        echo " <div style='margin:8px; '>Aprovar Prestação de Contas</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAvaliar();'>";
        echo " <div style='margin:8px; '>Avaliar Credenciado</div>";
        echo " </div>";
    } else {
        echo " <div class='botao_ag_bl' onclick='return VoltarEvento(false);'>";
        echo " <div style='margin:8px; '>Voltar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl' onclick='return pfoSalvar();' >";
        echo " <div style='margin:8px; '>Salvar</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoDevolver();'>";
        echo " <div style='margin:8px; '>Devolver para Ajustes</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAprovarEA();'>";
        echo " <div style='margin:8px; '>Aprovar Prestação de Contas</div>";
        echo " </div>";

        echo " <div class='botao_ag_bl sem_width' onclick='return pfoAvaliar();'>";
        echo " <div style='margin:8px; '>Avaliar Credenciado</div>";
        echo " </div>";
    }
}

echo " </div>";
?>
<script type="text/javascript">
    $(document).ready(function () {
        onSubmitCancelado = function () {
            valida_cust = '';
            onSubmitMsgTxt = '';
            situacao_submit = '';
        };
    });

    function pfoSalvar() {
        onSubmitMsgTxt = '';
        valida_cust = 'N';
        situacao_submit = 'pfoSalvar';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolver() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem documentação pendente!');
            return false;
        }

        var okOBS = '';

        $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox:not(:checked)').each(function () {
            var txt = $(this).parent().find('input.pfoObs');

            if (txt.val() == '' && okOBS == '') {
                okOBS = txt;
            }
        });

        if (okOBS !== '') {
            alert('Favor informar a observação desta pendência!');
            okOBS.focus();
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes?';
        valida_cust = 'N';
        situacao_submit = 'pfoDevolver';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolverEA() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem documentação pendente!');
            return false;
        }

        var okOBS = '';

        $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox:not(:checked)').each(function () {
            var txt = $(this).parent().find('input.pfoObs');

            if (txt.val() == '' && okOBS == '') {
                okOBS = txt;
            }
        });

        if (okOBS !== '') {
            alert('Favor informar a observação desta pendência!');
            okOBS.focus();
            return false;
        }

        if ($('#arq_ordem_servico').length > 0) {
            if ($('#arq_ordem_servico').val() == '' && '<?php echo $arq_ordem_servico; ?>' == '') {
                alert('Favor selecionar o arquivo da Ordem de Serviço (OS) assinada!');
                $('#arq_ordem_servico').focus();
                return false;
            }
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Reprovar Prestação de Contas?';
        valida_cust = 'N';
        situacao_submit = 'pfoDevolverEA';
        $(':submit:first').click();

        return true;
    }

    function pfoAprovarEA() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked').length;

        if (tot != marcado) {
            alert('Não pode aprovar, pois tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = '';
        onSubmitMsgTxt += 'Prezado <?php echo $_SESSION[CS]['g_nome_completo']; ?>, confirma a conclusão da prestação do serviço pela empresa credenciada ';
        onSubmitMsgTxt += '<?php echo $rowPFO['nomefantasia']; ?>, conforme evidenciado neste processo de pagamento?';

        if ('<?php echo $pfoAprovarEAmsg; ?>' == 'S') {
            onSubmitMsgTxt += '\n\nPor se tratar de contratação com agenda e/ou atividades relativa(s) a exercício(s) anterior(es), não haverá contabilização da meta física associada a esta realização. Somente será tramitado o processo de pagamento. Confirma?';
        }

        valida_cust = 'N';
        situacao_submit = 'pfoAprovarEA';
        $(':submit:first').click();

        return true;
    }

    function pfoAprovarGE() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked').length;

        if (tot != marcado) {
            alert('Não pode aprovar, pois tem documentação pendente!');
            return false;
        }

        if ($('#arq_ordem_servico').length > 0) {
            if ($('#arq_ordem_servico').val() == '' && '<?php echo $arq_ordem_servico; ?>' == '') {
                alert('Favor selecionar o arquivo da Ordem de Serviço (OS) assinada!');
                $('#arq_ordem_servico').focus();
                return false;
            }
        }

        onSubmitMsgTxt = 'Confirma a conclusão da prestação do serviço do credenciado e autorize a emissão na NF?\n\nTambém vai ser gerado a declaração de conclusão dos serviçoes e anexado ao evento!';
        valida_cust = 'N';
        situacao_submit = 'pfoAprovarGE';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolverDOC() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox[data-tipo_documento!="NF"]').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked[data-tipo_documento!="NF"]').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem documentação pendente!');
            return false;
        }

        var okOBS = '';

        $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox[data-tipo_documento!="NF"]:not(:checked)').each(function () {
            var txt = $(this).parent().find('input.pfoObs');

            if (txt.val() == '' && okOBS == '') {
                okOBS = txt;
            }
        });

        if (okOBS !== '') {
            alert('Favor informar a observação desta pendência!');
            okOBS.focus();
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes (Documentação)?';
        valida_cust = 'N';
        situacao_submit = 'pfoDevolverDOC';
        $(':submit:first').click();

        return true;
    }

    function pfoDevolverNF() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox[data-tipo_documento="NF"]').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked[data-tipo_documento="NF"]').length;

        if (tot == marcado) {
            alert('Não pode devolver, pois não tem Nota Fiscal pendente!');
            return false;
        }

        var okOBS = '';

        $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox[data-tipo_documento="NF"]:not(:checked)').each(function () {
            var txt = $(this).parent().find('input.pfoObs');

            if (txt.val() == '' && okOBS == '') {
                okOBS = txt;
            }
        });

        if (okOBS !== '') {
            alert('Favor informar a observação desta pendência!');
            okOBS.focus();
            return false;
        }

        onSubmitMsgTxt = 'Confirma a solicitação para Devolver para Ajustes (Nota Fiscal)?';
        valida_cust = 'N';
        situacao_submit = 'pfoDevolverNF';
        $(':submit:first').click();

        return true;
    }

    function pfoAprovarFIN() {
        var tot = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checkbox').length;
        var marcado = $('.pfo_af_processo_item_frm td[data-campo=situacao] > :checked').length;

        if (tot != marcado) {
            alert('Não pode mandar para o financeiro, pois tem documentação pendente!');
            return false;
        }

        onSubmitMsgTxt = 'Confirma o envio para o financeiro?';
        valida_cust = 'N';
        situacao_submit = 'pfoAprovarFIN';
        $(':submit:first').click();

        return true;
    }

    function pfoAvaliar() {
        var idt_pfo_af_processo = '<?php echo $idt_pfo_af_processo; ?>';
        var url = 'conteudo_exportar.php?prefixo=cadastro&menu=grc_avaliacao_resposta&origem_tela=menu&idt_pfo_af_processo=' + idt_pfo_af_processo;
        OpenWin(url, 'pfoAvaliar' + idt_pfo_af_processo, screen.width, screen.height, 0, 0);
    }

    function AbrirOrdem() {
        var url = 'conteudo.php?prefixo=listar&menu=gec_contratacao_credenciado_ordem&origem_tela=menu&class=0&idt_evento=' + idt_evento;
        OpenWin(url, 'AbrirOrdem' + idt_evento, screen.width, screen.height, 0, 0);
    }

    function Credenciado() {
        if ($('#idt_unidade').val() == '') {
            alert('Favor informar a Unidade/Escritório!');
            $('#idt_unidade').focus();
            return false;
        }

        if ($('#idt_gestor_evento').val() == '') {
            alert('Favor informar o Responsável pelo Evento!');
            $('#idt_gestor_evento').focus();
            return false;
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                idt_programa: $('#idt_programa').val(),
                situacao: 'Credenciado'
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#dialog-processando').remove();
                    onSubmitMsgTxt = 'Confirma a solicitação da criação da ordem?';
                    situacao_submit = 'Credenciado';
                    $(':submit:first').click();
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

    function CanPreAprovarEvento(idt_evento) {
        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                idt_unidade: $('#idt_unidade').val(),
                idt_gestor_evento: $('#idt_gestor_evento').val(),
                idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                idt_responsavel: '<?php echo $idt_responsavel; ?>',
                idt_instrumento: '<?php echo $idt_instrumento; ?>',
                idt_programa: $('#idt_programa').val(),
                situacao: 'CanPreAprovarEvento'
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#dialog-processando').remove();
                    valida_cust = 'N';
                    onSubmitMsgTxt = 'Confirma o cancelamento da PRÉ-APROVAÇÃO do evento?';
                    situacao_submit = 'CanPreAprovarEvento';
                    $(':submit:first').click();
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

    function PreAprovarEvento(idt_evento, txt) {
        if ($('#idt_unidade').val() == '') {
            alert('Favor informar a Unidade/Escritório!');
            $('#idt_unidade').focus();
            return false;
        }

        if ($('#idt_gestor_evento').val() == '') {
            alert('Favor informar o Responsável pelo Evento!');
            $('#idt_gestor_evento').focus();
            return false;
        }

        if ('<?php echo $vetConf['evento_sem_metrica_sge'] ?>' == 'Não') {
            var qtd_previsto = str2float($('#qtd_previsto').val());

            if (isNaN(qtd_previsto)) {
                qtd_previsto = 0;
            }

            if (qtd_previsto == 0) {
                alert('A Ação do Projeto não tem Métrica Previsão no SGE!\n\nCom isso não pode continuar com esta solicitação!');
                return false;
            }
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                idt_unidade: $('#idt_unidade').val(),
                idt_gestor_evento: $('#idt_gestor_evento').val(),
                idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                idt_responsavel: '<?php echo $idt_responsavel; ?>',
                idt_instrumento: '<?php echo $idt_instrumento; ?>',
                idt_programa: $('#idt_programa').val(),
                idt_ponto_atendimento_tela: $('#idt_ponto_atendimento_tela').val(),
                previsao_despesa: $('#previsao_despesa').val(),
                dt_previsao_inicial: $('#dt_previsao_inicial').val(),
                situacao: 24
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#dialog-processando').remove();
                    onSubmitMsgTxt = 'Confirma a ' + txt + ' evento?';
                    situacao_submit = '24';
                    $(':submit:first').click();
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

    function EnviarAprovarEvento(idt_evento) {
        if ($('#idt_unidade').val() == '') {
            alert('Favor informar a Unidade/Escritório!');
            $('#idt_unidade').focus();
            return false;
        }

        if ($('#idt_gestor_evento').val() == '') {
            alert('Favor informar o Responsável pelo Evento!');
            $('#idt_gestor_evento').focus();
            return false;
        }

        if ('<?php echo $vetConf['evento_sem_metrica_sge'] ?>' == 'Não') {
            var qtd_previsto = str2float($('#qtd_previsto').val());

            if (isNaN(qtd_previsto)) {
                qtd_previsto = 0;
            }

            if (qtd_previsto == 0) {
                alert('A Ação do Projeto não tem Métrica Previsão no SGE!\n\nCom isso não pode continuar com esta solicitação!');
                return false;
            }
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                idt_unidade: $('#idt_unidade').val(),
                idt_gestor_evento: $('#idt_gestor_evento').val(),
                idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                idt_responsavel: '<?php echo $idt_responsavel; ?>',
                idt_instrumento: '<?php echo $idt_instrumento; ?>',
                idt_programa: $('#idt_programa').val(),
                idt_ponto_atendimento_tela: $('#idt_ponto_atendimento_tela').val(),
                previsao_despesa: $('#previsao_despesa').val(),
                dt_previsao_inicial: $('#dt_previsao_inicial').val(),
                situacao: 6
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#dialog-processando').remove();
                    onSubmitMsgTxt = url_decode(response.msg);
                    situacao_submit = '6';
                    $(':submit:first').click();
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

    function EnviarAprovarEventoCombo()
    {
        situacao_submit = 'EnviarAprovarEventoCombo';
        $(':submit:first').click();
    }

    function SalvarEvento()
    {
        situacao_submit = '';
        $(':submit:first').click();
    }

    function SalvarConsolidacao() {
        valida_cust = 'N';
        situacao_submit = '';
        $(':submit:first').click();
    }

    function AlterarEvento() {
        if ($('#qtd_vagas_adicional').val() == '' && $("#qtd_vagas_adicional").prop("disabled") == false) {
            alert('Favor informar a Qtde. adicional de Participantes!');
            $('#qtd_vagas_adicional').focus();
            return false;
        }

        if ($('#quantidade_participante').val() == '' && $("#quantidade_participante").prop("disabled") == false) {
            alert('Favor informar a Qtde. Participantes!');
            $('#quantidade_participante').focus();
            return false;
        }

        processando();

        var sincroniza = '';

        if ($("#quantidade_participante").prop("disabled") == false) {
            sincroniza = 'alt_evento';
        }

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: ajax_sistema + '?tipo=alt_qtd_vagas_adicional',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                qtd_vagas_adicional: $('#qtd_vagas_adicional').val(),
                quantidade_participante: $('#quantidade_participante').val()
            },
            success: function (response) {
                if (response.erro == '') {
                    valida_cust = 'N';
                    situacao_submit = sincroniza;
                    $(':submit:first').click();
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

    function CancelarEvento_alt() {
        valida_cust = 'N';
        situacao_submit = '4';
        $(':submit:first').click();
    }

    function ExcluirEvento()
    {
        valida_cust = 'N';
        $(':submit:first').click();
    }

    function CancelarDespacho()
    {
        valida_cust = 'N';
        situacao_submit = '1';
        $(':submit:first').click();
    }

    function DevolverCancelamentoEvento() {
        if ($('#parecer_cancelamento').val() == '') {
            alert('Favor informar o Parecer do Cancelamento!');
            $('#parecer_cancelamento').focus();
            return false;
        }

        valida_cust = 'N';
        situacao_submit = 'DevolverCancelamentoEvento';
        $(':submit:first').click();
    }

    function CancelarEventoAprovado(valida_campo) {
        if (veio == 'SG' && sgtec_modelo == 'E' && valida_campo === true) {
            if ($('#idt_evento_motivo_cancelamento').val() == '') {
                alert('Favor informar o Motivo da Rescisão!');
                $('#idt_evento_motivo_cancelamento').focus();
                return false;
            }

            if ($('#motivo_cancelamento').val() == '') {
                alert('Favor informar o Motivo do Cancelamento!');
                $('#motivo_cancelamento').focus();
                return false;
            }

            if ($('#idt_unidade').val() == '') {
                alert('Favor informar a Unidade/Escritório!');
                $('#idt_unidade').focus();
                return false;
            }

            if ($('#idt_gestor_evento').val() == '') {
                alert('Favor informar o Responsável pelo Evento!');
                $('#idt_gestor_evento').focus();
                return false;
            }
        }

        valida_cust = 'N';
        situacao_submit = '21';
        onSubmitMsgTxt = '';
        onSubmitMsgTxt += 'Atenção: O cancelamento deste evento poderá causar impactos para\n';
        onSubmitMsgTxt += 'as unidades de suporte, fornecedores e, principalmente, para o cliente.\n';
        onSubmitMsgTxt += '\n';
        onSubmitMsgTxt += 'Esta ação não poderá ser desfeita!\n';
        onSubmitMsgTxt += '\n';
        onSubmitMsgTxt += 'Deseja continuar?';
        $(':submit:first').click();
    }

    function CancelarEventoAprovado22() {
        valida_cust = 'N';
        situacao_submit = '21';
        $(':submit:first').click();
    }

    function SoCancelarEventoAprovado() {
        if ($('#idt_evento_motivo_cancelamento').val() == '') {
            alert('Favor informar o Motivo da Rescisão!');
            $('#idt_evento_motivo_cancelamento').focus();
            return false;
        }

        if ($('#motivo_cancelamento').val() == '') {
            alert('Favor informar o Motivo do Cancelamento!');
            $('#motivo_cancelamento').focus();
            return false;
        }

        if ($('#idt_unidade').val() == '') {
            alert('Favor informar a Unidade/Escritório!');
            $('#idt_unidade').focus();
            return false;
        }

        if ($('#idt_gestor_evento').val() == '') {
            alert('Favor informar o Responsável pelo Evento!');
            $('#idt_gestor_evento').focus();
            return false;
        }

        processando();

        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'ajax_atendimento.php' + '?tipo=SituacaoEvento',
            data: {
                cas: conteudo_abrir_sistema,
                idt_evento: idt_evento,
                idt_unidade: $('#idt_unidade').val(),
                idt_gestor_evento: $('#idt_gestor_evento').val(),
                idt_gestor_projeto: $('#idt_gestor_projeto').val(),
                idt_responsavel: '<?php echo $idt_responsavel; ?>',
                idt_instrumento: '<?php echo $idt_instrumento; ?>',
                idt_programa: $('#idt_programa').val(),
                situacao: 23
            },
            success: function (response) {
                if (response.erro == '') {
                    $('#dialog-processando').remove();
                    valida_cust = 'N';
                    situacao_submit = '23';
                    $(':submit:first').click();
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

    function VoltarEvento(chama_ajax) {
        if (chama_ajax) {
            if (confirm('Deseja EXCLUIR este registro de rascunho?')) {
                processando();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'ajax_atendimento.php' + '?tipo=ExcluiEventoTemporario',
                    data: {
                        cas: conteudo_abrir_sistema,
                        idt_evento: idt_evento

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

    function AprovarEvento(idt_evento_situacao_novo) {
        valida_cust = 'N';

        if (idt_evento_situacao_novo == 14) {
            onSubmitMsgTxt = 'Confirma a APROVAÇÃO FINAL deste evento?';
        } else {
            onSubmitMsgTxt = 'Confirma a APROVAÇÃO desta etapa do evento?';
        }

        situacao_submit = idt_evento_situacao_novo;
        $(':submit:first').click();
    }

    function DevolverEvento(valida_campo)
    {
        if (valida_campo) {
            if ($('#parecer').val() == '') {
                alert('Favor informar o Parecer!');
                $('#parecer').focus();
                return false;
            }
        }

        valida_cust = 'N';
        situacao_submit = '5';
        $(':submit:first').click();
    }

    function DevolverCotacaoFinalizada() {
        valida_cust = 'N';
        situacao_submit = '8';
        $(':submit:first').click();
    }

    function ConsolidarEvento() {
        if ('<?php echo $idt_instrumento; ?>' == '2') {
            if ($('#resultados_obtidos').val() == '') {
                alert('Favor informar o Resultados Obtidos!');
                $('#resultados_obtidos').focus();
                return false;
            }
        }

        var ok = true;

        processando();

        $.ajax({
            type: 'POST',
            url: ajax_sistema + '?tipo=ConsolidarEventoValida',
            data: {
                cas: conteudo_abrir_sistema,
                idt_instrumento: '<?php echo $idt_instrumento; ?>',
                idt: idt_evento
            },
            success: function (response) {
                if (response != '') {
                    ok = false;
                    $('#dialog-processando').remove();
                    alert(url_decode(response));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#dialog-processando').remove();
                alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
            },
            async: false
        });

        $('#dialog-processando').remove();

        if (ok) {
            if ('<?php echo $siac_at_erro_con; ?>' == 'S') {
                onSubmitMsgTxt = 'Por se tratar de realização com agenda e/ou atividades relativa(s) a exercício(s) anterior(es), não serão contabilizadas a meta física. Confirma?';
            } else {
                onSubmitMsgTxt = '';
            }

            valida_cust = 'N';
            situacao_submit = '20';
            $(':submit:first').click();
        }
    }

    function DesconsolidarEvento() {
        valida_cust = 'N';
        situacao_submit = '19';
        $(':submit:first').click();
    }

    function ExcluirAgendaErrada() {
        if (confirm('Deseja EXCLUIR o Cronograma / Atividades sem Cliente?')) {
            processando();

            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: ajax_sistema + '?tipo=ExcluirAgendaErradaEvento',
                data: {
                    cas: conteudo_abrir_sistema,
                    idt_evento: idt_evento
                },
                success: function (response) {
                    btFechaCTC($('#grc_evento_agenda').data('session_cod'));

                    if (response.erro == '') {
                        $('#ExcluirAgendaErrada').remove();
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

    }
</script>