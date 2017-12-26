<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

Require_Once('configuracao.php');
Require_Once('funcao_agenda.php');

switch ($_GET['tipo']) {
    case 'grava_grc_politica_vendas_condicao_evento':
        $erro = Array();
        $vet = Array(
            'erro' => '',
        );

        try {
            $row = array();
            parse_str($_POST['form'], $row);
            $row = array_map_recursive('utf8_decode', $row);
            $_POST = array_map_recursive('trim', $row);

            $vetWizard = Array(
                'wizardEvento' => 'P',
            );

            beginTransaction();

            foreach ($vetWizard as $postWizard => $tipoWizard) {
                $sql = 'delete from grc_politica_vendas_condicao';
                $sql .= ' where idt_politica_vendas = ' . null($_POST['id']);
                $sql .= ' and tipo = ' . aspa($tipoWizard);
                execsql($sql);

                if (is_array($_POST[$postWizard])) {
                    unset($_POST[$postWizard][0]);

                    $ordem = 0;

                    foreach ($_POST[$postWizard] as $row) {
                        if ($row['campo'] != '') {
                            $ordem++;

                            $sql = '';
                            $sql .= 'insert into grc_politica_vendas_condicao (';
                            $sql .= ' idt_politica_vendas, codigo, ordem, parentese_ant,';
                            $sql .= ' parentese_dep, condicao, valor, operador, tipo';
                            $sql .= ') values (';
                            $sql .= null($_POST['id']) . ', ' . aspa($row['campo']) . ', ' . aspa($ordem) . ', ' . aspa($row['parentese_ant']) . ', ';
                            $sql .= aspa($row['parentese_dep']) . ', ' . aspa($row['operador']) . ', ' . aspa($row['valor']) . ', ' . aspa($row['expressao']) . ', ' . aspa($tipoWizard);
                            $sql .= ')';
                            execsql($sql);
                        }
                    }
                }
            }

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'checa_formulario':
        $sql = '';
        $sql .= ' select s.idt_formulario';
        $sql .= ' from grc_formulario_secao s';
        $sql .= ' left outer join grc_formulario_pergunta p on s.idt = p.idt_secao';
        $sql .= ' left outer join grc_formulario_resposta r on p.idt = r.idt_pergunta';
        $sql .= ' where s.idt_formulario = ' . null($_POST['idt_formulario']);
        $sql .= ' and (';
        $sql .= " s.valido = 'N'";
        $sql .= " or p.valido = 'N'";
        $sql .= " or r.valido = 'N'";
        $sql .= ' )';
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            echo 'N';
        } else {
            echo 'S';
        }
        break;

    case 'conWSProdutoSIAC':
        $vet = Array(
            'erro' => '',
            'situacao_siac' => 'N',
            'descricao_siac' => '',
            'codigo_classificacao_siac' => '',
            'idt_instrumento' => '',
            'idt_instrumento_siac' => '',
            'idt_foco_tematico_siac' => '',
            'idt_autor_siac' => '',
            'idt_responsavel_siac' => '',
            'minimo_pagantes_siac' => '',
            'maximo_participantes_siac' => '',
            'frequencia_siac' => '',
            'qtdias_reservados_siac' => '',
            'idt_produto_tipo' => '',
        );

        try {
            $conSIAC = conSIAC();

            $sql = '';
            $sql .= ' select p.CodProdutoEstruturado as codigo_classificacao_siac, p.NomeProduto as descricao_siac, p.CodFocoTematico as codfocotematico,';
            $sql .= ' p.CodAutorProduto as idt_autor_siac, p.CodSEBRAEResp as idt_responsavel_siac, c.Qtdminpagantes as minimo_pagantes_siac,';
            $sql .= ' c.Qtdinscmaxprev as maximo_participantes_siac, c.Percfreqmin as frequencia_siac, c.Qtdlimdiareserv as qtdias_reservados_siac,';
            $sql .= ' p.CodFamiliaProduto as idt_instrumento_siac, p.Situacao as situacao_siac';
            $sql .= ' from ProdutoPortfolio p';
            $sql .= ' left outer join ProdutoPortfolioEDUComplemento c on c.CodProdutoPortfolio = p.CodProdutoPortfolio and c.CodSebrae = dbo.FN_RetornarCodSebrae()';
            $sql .= ' where p.CodProdutoPortfolio = ' . null($_POST['cod']);
            $rs = execsql($sql, false, $conSIAC);

            if ($rs->rows == 0) {
                $vet['erro'] = rawurlencode('Código do SIAC não localizado!');
            } else {
                $row = $rs->data[0];

                $vet['descricao_siac'] = rawurlencode($row['descricao_siac']);
                $vet['codigo_classificacao_siac'] = rawurlencode($row['codigo_classificacao_siac']);
                $vet['idt_instrumento_siac'] = rawurlencode($row['idt_instrumento_siac']);

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_foco_tematico';
                $sql .= ' where codigo = ' . aspa($row['codfocotematico']);
                $rs = execsql($sql, false);
                $vet['idt_foco_tematico_siac'] = rawurlencode($rs->data[0][0]);

                $vet['idt_autor_siac'] = rawurlencode($row['idt_autor_siac']);
                $vet['idt_responsavel_siac'] = rawurlencode($row['idt_responsavel_siac']);
                $vet['minimo_pagantes_siac'] = rawurlencode($row['minimo_pagantes_siac']);
                $vet['maximo_participantes_siac'] = rawurlencode($row['maximo_participantes_siac']);
                $vet['frequencia_siac'] = rawurlencode($row['frequencia_siac']);
                $vet['qtdias_reservados_siac'] = rawurlencode($row['qtdias_reservados_siac']);

                if ($row['situacao_siac'] == '') {
                    $vet['situacao_siac'] = rawurlencode('N');
                } else {
                    $vet['situacao_siac'] = rawurlencode($row['situacao_siac']);
                }

                $sql = '';
                $sql .= ' select idt, idt_produto_tipo';
                $sql .= ' from grc_atendimento_instrumento';
                $sql .= ' where codigo_familia_siac = ' . null($row['idt_instrumento_siac']);
                $rs = execsql($sql, false);
                $vet['idt_instrumento'] = rawurlencode($rs->data[0]['idt']);
                $vet['idt_produto_tipo'] = rawurlencode($rs->data[0]['idt_produto_tipo']);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'incgrc_atendimento_agenda':
        $menu = $_REQUEST['menu'];
        require_once 'listar.php';
        break;

    case 'projeto_dados':
        $vet = Array(
            'erro' => '',
            'gestor' => '',
            'etapa' => '',
                //'idt_gestor_projeto' => '',
        );

        try {
            $sql = "select ";
            $sql .= "   pr.*, grc_ps.descricao as etapa ";
            $sql .= " from grc_projeto as pr ";
            $sql .= " left join grc_projeto_situacao grc_ps on grc_ps.idt = pr.idt_projeto_situacao ";
            $sql .= ' where pr.idt = ' . null($_POST['idt_projeto']);
            $rs = execsql($sql, false);

            $row = $rs->data[0];

            $vet['gestor'] = rawurlencode($row['gestor']);
            $vet['etapa'] = rawurlencode($row['etapa']);
//$vet['idt_gestor_projeto'] = rawurlencode($row['idt_responsavel']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'cnae_setor':
        $vet = Array(
            'erro' => '',
            'idt' => '',
            'txt' => '',
        );

        try {
            $sql = '';
            $sql .= ' select es.idt, es.descricao';
            $sql .= ' from ' . db_pir_gec . 'cnae c';
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_setor es on es.codigo = c.codsetor_siacweb';
            $sql .= ' where c.codclass_siacweb = 1';
            $sql .= ' and c.subclasse = ' . aspa($_POST['idt_cnae_principal']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['idt'] = rawurlencode($row['idt']);
            $vet['txt'] = rawurlencode($row['descricao']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'cpf_codparceiro_siacweb':
        $sql = '';
        $sql .= ' select codparceiro';
        $sql .= ' from ' . db_pir_siac . 'parceiro';
        $sql .= ' where cgccpf = ' . null(preg_replace('/[^0-9]/i', '', $_POST['cpf']));
        $rs = execsql($sql);

        if ($rs->data[0][0] == '') {
            beginTransaction();
            migraParceiroSiacWeb('cpfcnpj', preg_replace('/[^0-9]/i', '', $_POST['cpf']), true, true);
            commit();
            $rs = execsql($sql);
        }

        if ($rs->data[0][0] == '') {
            echo 'Parceiro não encontrado no SiacWeb!';
        } else {
            echo $rs->data[0][0];
        }
        break;

    case 'sincroniza_siac':
        require_once 'sincroniza_siac_acao.php';
        break;

    case 'competencia_dados':
        $vet = Array(
            'erro' => '',
            'idt' => '',
            'texto' => '',
        );

        try {
            $vet['idt'] = idtCompetencia($_POST['data']);

            $sql = '';
            $sql .= ' select texto';
            $sql .= ' from grc_competencia';
            $sql .= ' where idt = ' . null($vet['idt']);
            $rs = execsql($sql, false);
            $vet['texto'] = rawurlencode($rs->data[0][0]);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'pa_unidade':
        $sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
        $sql .= " where posto_atendimento = 'S'";
        $sql .= ' and SUBSTRING(classificacao, 1, 5) = (';
        $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql .= ' where idt = ' . null($_GET['val']);
        $sql .= ' )';
        $sql .= ' and idt <> ' . null($_GET['val']);
        $sql .= ' order by classificacao ';
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $linhafixa = '';
        } else {
            $linhafixa = ' ';
        }

        echo option_rs_json($rs, $_GET['val'], $linhafixa, 'NÃO SE APLICA');
        break;

    case 'area_tematica':
        $sql = '';
        $sql .= ' select idt, descricao';
        $sql .= ' from ' . db_pir_gec . 'gec_area_conhecimento ';
        $sql .= " where idt_programa = 4 ";
        $sql .= " and idt_area  = " . null($_GET['val']);
        $sql .= " and idt_subarea IS NOT NULL";
        $sql .= ' order by descricao';
        $rs = execsql($sql);

        if ($rs->rows == 0) {
            $linhafixa = '';
        } else {
            $linhafixa = '-- Todos --';
        }

        echo option_rs_json($rs, $_GET['val'], $linhafixa, 'NÃO SE APLICA');
        break;

    case 'pa_cidade':
        $sql = '';
        $sql .= " select case proprio when 'S' then 'Interno' else 'Externo' end as grupo,";
        $sql .= ' idt,descricao';
        $sql .= ' from grc_evento_local_pa';
        $sql .= " where logradouro_codcid = " . null($_GET['val']);
        $sql .= ' order by grupo desc, descricao';
        echo grupo_option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'pa_local_mapa':
        $sql = '';
        $sql .= ' select idt, descricao';
        $sql .= ' from grc_evento_local_pa_mapa';
        $sql .= ' where idt_local_pa = ' . null($_GET['val']);
        $sql .= ' order by descricao';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'pa_consultor':
        $sql = "select distinct plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
        $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";

        if ($_GET['val'] > 0) {
            $sql .= " where grc_pap.idt_ponto_atendimento = " . null($_GET['val']);
        }

        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'pesquisa_consultor_agenda':

        $sql = "select plu_usu.id_usuario,plu_usu.id_usuario, plu_usu.nome_completo from plu_usuario plu_usu";
        $sql .= " inner join grc_atendimento_pa_pessoa grc_app on grc_app.idt_usuario = plu_usu.id_usuario ";
        $sql .= " inner join " . db_pir . "sca_organizacao_secao as sos on sos.idt = grc_app.idt_ponto_atendimento ";
        if ($_GET['val'] > 0) {
            $sql .= " where sos.idt = " . null($_GET['val']);
            $sql .= "   and grc_app.duracao is not null ";
        }

        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], '');
        break;
		
		

    case 'usuario_pa':
        $sql = '';
        $sql .= ' select distinct id_usuario, nome_completo';
        $sql .= ' from plu_usuario';
        $sql .= " where ativo = 'S'";

        if (($_GET['val'] != "" && $_GET['val'] != "0" && $_GET['val'] != "-1") || $_GET['todos'] == 'n') {
            $sql .= ' and idt_unidade_lotacao in (';
            $sql .= " select idt from " . db_pir . "sca_organizacao_secao ";
            $sql .= ' where SUBSTRING(classificacao, 1, 5) = (';
            $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where idt = ' . null($_GET['val']);
            $sql .= ' )';
            $sql .= ' )';
        } else {
            $sql .= ' and idt_unidade_lotacao is not null';
        }

        $sql .= ' order by nome_completo';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'executa_job_rm':
        require_once 'executa_job_rm.php';

        if ($qtdErro == 0) {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. EXECUTADA COM SUCESSO!';
        } else {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. OCORREU ' . $qtdErro . ' ERROS NA ROTINA. CONSULTAR LOG DE ERROS!';
        }
        break;

    case 'executa_job_sge':
        require_once 'executa_job_sge.php';

        if ($qtdErro == 0) {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. EXECUTADA COM SUCESSO!';
        } else {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. OCORREU ' . $qtdErro . ' ERROS NA ROTINA. CONSULTAR LOG DE ERROS!';
        }
        break;

    case 'executa_job_siacweb':
        require_once 'executa_job_siacweb.php';

        if ($qtdErro == 0) {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. EXECUTADA COM SUCESSO!';
        } else {
            echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. OCORREU ' . $qtdErro . ' ERROS NA ROTINA. CONSULTAR LOG DE ERROS!';
        }
        break;

    case 'consulta_desconto_pagamento':
        $erro = '';
        $vet = Array(
            'erro' => '',
            'idt_desconto' => '',
        );

        try {
            beginTransaction();

            if ($_POST['codigo_cupom'] == '') {
                $sql = '';
                $sql .= ' select idt, idt_evento_publicacao_cupom';
                $sql .= ' from grc_evento_participante';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $rs = execsql($sql, false);
                $rowEP = $rs->data[0];

                $sql = 'update grc_evento_participante set';
                $sql .= ' codigo_cupom = null, ';
                $sql .= ' idt_evento_publicacao_cupom = null';
                $sql .= ' where idt = ' . null($rowEP['idt']);
                execsql($sql, false);

                $sql = 'delete from grc_evento_participante_desconto';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= " and codigo = 'cupom'";
                execsql($sql, false);

                //Desbloquea o cupom utilizado
                $vetErro = operacaoMatriculaCupom($rowEP['idt_evento_publicacao_cupom'], FALSE, false);

                if (count($vetErro) > 0) {
                    $erro = implode('<br />', $vetErro);
                }
            } else {
                $sql = '';
                $sql .= ' select epc.idt, ec.ativo, ec.data_validade, ec.perc_desconto';
                $sql .= ' from grc_evento_publicacao_cupom epc';
                $sql .= ' inner join grc_evento_cupom ec on ec.idt = epc.idt_evento_cupom';
                $sql .= ' where epc.idt_evento_publicacao = ' . null($_POST['idt_evento_publicacao']);
                $sql .= ' and ec.palavra_chave = ' . aspa($_POST['codigo_cupom']);
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    $erro = 'O Cupom ' . $_POST['codigo_cupom'] . ' está inválido!';
                } else {
                    $row = $rs->data[0];

                    if ($erro == '' && $row['ativo'] == 'N') {
                        $erro = 'O Cupom ' . $_POST['codigo_cupom'] . ' não está ativo!';
                    }

                    if ($erro == '') {
                        if (diffDate(trata_data($row['data_validade']), getdata(false, true)) > 0) {
                            $erro = 'O Cupom ' . $_POST['codigo_cupom'] . ' está expirado (Validade: ' . trata_data($row['data_validade']) . ')!';
                        }
                    }

                    if ($erro == '') {
                        $sql = '';
                        $sql .= ' select idt, idt_evento_publicacao_cupom';
                        $sql .= ' from grc_evento_participante';
                        $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                        $rs = execsql($sql, false);
                        $rowEP = $rs->data[0];

                        if ($row['idt'] != $rowEP['idt_evento_publicacao_cupom']) {
                            if ($rs->rows == 0) {
                                $sql = 'insert into grc_evento_participante (idt_atendimento, codigo_cupom, idt_evento_publicacao_cupom) values (';
                                $sql .= null($_POST['idt_atendimento']) . ', ' . aspa($_POST['codigo_cupom']) . ', ' . null($row['idt']) . ')';
                                execsql($sql, false);
                                $idt_evento_participante = lastInsertId();
                            } else {
                                $idt_evento_participante = $rowEP['idt'];

                                $sql = 'update grc_evento_participante set';
                                $sql .= ' codigo_cupom = ' . aspa($_POST['codigo_cupom']) . ', ';
                                $sql .= ' idt_evento_publicacao_cupom = ' . null($row['idt']);
                                $sql .= ' where idt = ' . null($idt_evento_participante);
                                execsql($sql, false);
                            }

                            //Desbloquea o cupom utilizado
                            $vetErro = operacaoMatriculaCupom($rowEP['idt_evento_publicacao_cupom'], FALSE, false);

                            if (count($vetErro) > 0) {
                                $erro = implode('<br />', $vetErro);
                            }

                            if ($erro == '') {
                                //Bloquea o cupom utilizado
                                $vetErro = operacaoMatriculaCupom($row['idt'], TRUE, false);

                                if (count($vetErro) > 0) {
                                    $erro = implode('<br />', $vetErro);
                                }
                            }

                            if ($erro == '') {
                                cadastraMatriculaDesconto($_POST['idt_atendimento'], 'cupom', 'Cupom de Desconto', $row['perc_desconto'], false);

                                $vet['idt_desconto'] = $row['idt'];
                            }
                        }
                    }
                }
            }

            operacaoEventoPagamentoDesconto($_POST['idt_atendimento'], $_POST['vl_evento'], false);

            if ($erro == '') {
                commit();
            } else {
                rollBack();
                $vet['erro'] = rawurlencode($erro);
            }
        } catch (PDOException $e) {
            rollBack();

            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();

            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_insumo_insc':
        $vet = Array(
            'erro' => '',
        );

        try {
            $gratuito = $_POST['gratuito'];

            if ($gratuito != 'S') {
                $gratuito = 'N';
            }

            $quantidade = desformat_decimal($_POST['quantidade']);
            if ($quantidade == '') {
                $quantidade = 0;
            }

            $custo_unitario_real = desformat_decimal($_POST['custo_unitario_real']);
            if ($custo_unitario_real == '') {
                $custo_unitario_real = 0;
            }

            if ($gratuito == 'S') {
                $custo_unitario_real = 0;
            }

            $tot = $quantidade * $custo_unitario_real;

            $sql = 'update grc_evento_insumo set';
            $sql .= ' quantidade = 1, ';
            $sql .= ' quantidade_evento = ' . null($quantidade) . ', ';
            $sql .= ' custo_unitario_real = ' . null($custo_unitario_real) . ', ';
            $sql .= ' rtotal_minimo = ' . null($tot) . ', ';
            $sql .= ' rtotal_maximo = ' . null($tot) . ', ';
            $sql .= ' receita_total = ' . null($tot);
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= " and codigo = 'evento_insc'";
            execsql($sql, false);

            $sql = '';
            $sql .= ' select p.tipo_calculo, p.carga_horaria_ini, p.carga_horaria_2_ini';
            $sql .= ' from grc_evento e';
            $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
            $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
            $rsa = execsql($sql, false);
            $rowp = $rsa->data[0];

            $sql = 'update grc_evento set';
            $sql .= ' gratuito = ' . aspa($gratuito) . ', ';
            $sql .= ' quantidade_participante = ' . null($quantidade) . ', ';

            if ($rowp['tipo_calculo'] == 'P') {
                $tot_ini = 0;

                if ($rowp['carga_horaria_ini'] != '') {
                    $tot_ini += $rowp['carga_horaria_ini'];
                }

                if ($rowp['carga_horaria_2_ini'] != '') {
                    $tot_ini += $rowp['carga_horaria_2_ini'];
                }

                $sql .= ' carga_horaria_total = ' . null($tot_ini * $quantidade) . ',';
            }

            $sql .= ' valor_inscricao = ' . null($custo_unitario_real);
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            execsql($sql, false);

            CalcularInsumoEvento($_POST['idt_evento']);

            EventoCompostoSincroniza($_POST['idt_evento'], false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_inc_cliente_prev':
        $vet = Array(
            'erro' => '',
            'dados' => Array(),
        );

        try {
            beginTransaction();
            SincronizaHoraMesEventoComposto($_POST['idt_evento'], false);
            commit();

            $sql = '';
            $sql .= ' select idt, qtd';
            $sql .= ' from grc_evento_agenda_prev';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= ' order by data';
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                $vet['dados'][$row['idt']] = format_decimal($row['qtd']);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_atualizaPrevisaoReceita':
        $vet = Array(
            'erro' => '',
            'valor' => '',
        );

        try {
            $sql = '';
            $sql .= ' select sum(ei.receita_total) as tot';
            $sql .= ' from grc_evento_insumo ei';
            $sql .= " inner join grc_insumo grc_pp on grc_pp.idt = ei.idt_insumo ";
            $sql .= ' where ei.idt_evento = ' . null($_POST['idt_evento']);
            $sql .= " and grc_pp.sinal = 'N'"; // receita
            $sql .= ' group by ei.idt_evento';
            $rs = execsql($sql, false);
            $vet['valor'] = format_decimal($rs->data[0][0]);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_dados':
        $vet = Array(
            'erro' => '',
            'valor_inscricao' => '',
            'quantidade_participante' => '',
            'idt_cidade' => '',
            'idt_cidade_tf' => '',
            'idt_local' => '',
            'idt_local_tf' => '',
            'carga_horaria_total' => '',
            'dt_previsao_inicial' => '',
            'dt_previsao_fim' => '',
            'hora_inicio' => '',
            'hora_fim' => '',
        );

        try {
            $sql = '';
            $sql .= ' select e.*, c.desccid as cidade, l.descricao as local';
            $sql .= ' from grc_evento e';
            $sql .= " left outer join " . db_pir_siac . "cidade c on c.codcid = e.idt_cidade";
            $sql .= " left outer join grc_evento_local_pa l on l.idt = e.idt_local";
            $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['valor_inscricao'] = format_decimal($row['valor_inscricao']);
            $vet['quantidade_participante'] = $row['quantidade_participante'];
            $vet['idt_cidade'] = $row['idt_cidade'];
            $vet['idt_cidade_tf'] = $row['idt_cidade_tf'];
            $vet['idt_local'] = $row['idt_local'];
            $vet['idt_local_tf'] = $row['idt_local_tf'];
            $vet['carga_horaria_total'] = format_decimal($row['carga_horaria_total']);
            $vet['dt_previsao_inicial'] = trata_data($row['dt_previsao_inicial']);
            $vet['dt_previsao_fim'] = trata_data($row['dt_previsao_fim']);
            $vet['hora_inicio'] = $row['hora_inicio'];
            $vet['hora_fim'] = $row['hora_fim'];
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = $msg;
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = $msg;
        }

        $vet = array_map('rawurlencode', $vet);
        echo json_encode($vet);
        break;

    case 'grc_evento_valida_programacao':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select distinct data ';
            $sql .= ' from grc_evento_programacao';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= ' and not data between ' . aspa(trata_data($_POST['ini'])) . ' and ' . aspa(trata_data($_POST['fim'])) . '';
            $sql .= ' order by data';
            $rs = execsql($sql, false);

            $erro = Array();

            foreach ($rs->data as $row) {
                $erro[] = trata_data($row['data']);
            }

            if (count($erro) > 0) {
                $vet['erro'] = rawurlencode(implode(', ', $erro));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_acompanhar_lista_email':
        $erro = Array();
        $vet = Array(
            'erro' => '',
        );

        try {
            $row = array();
            parse_str($_POST['form'], $row);
            array_walk_recursive($row, 'utf8_decode');
            array_walk_recursive($row, 'trim');

            $vetErroMsg = enviaEmailEventoAcompanharLista($row, false);

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_sincroniza_loja':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = 'update grc_evento set';
            $sql .= ' sincroniza_loja = ' . aspa($_POST['valor']);
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_nao_sincroniza_rm':
        try {
            $sql = 'update grc_evento set';
            $sql .= ' nao_sincroniza_rm = ' . aspa($_POST['valor']);
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            execsql($sql, false);
        } catch (PDOException $e) {
            grava_erro_log($tipodb, $e, $sql);
        } catch (Exception $e) {
            grava_erro_log('php', $e, '');
        }
        break;

    case 'evento_certificado_modelo':
        $vet = Array(
            'erro' => '',
            'html_corpo' => '',
            'html_header' => '',
            'html_footer' => '',
            'mpdf_me' => '',
            'mpdf_md' => '',
            'mpdf_ms' => '',
            'mpdf_mb' => '',
            'mpdf_mh' => '',
            'mpdf_mf' => '',
            'mpdf_papel_orientacao' => '',
            'mpdf_papel_orientacao_tf' => '',
        );

        try {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_evento_certificado_modelo';
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['html_corpo'] = rawurlencode($row['html_corpo']);
            $vet['html_header'] = rawurlencode($row['html_header']);
            $vet['html_footer'] = rawurlencode($row['html_footer']);
            $vet['mpdf_me'] = rawurlencode($row['mpdf_me']);
            $vet['mpdf_md'] = rawurlencode($row['mpdf_md']);
            $vet['mpdf_ms'] = rawurlencode($row['mpdf_ms']);
            $vet['mpdf_mb'] = rawurlencode($row['mpdf_mb']);
            $vet['mpdf_mh'] = rawurlencode($row['mpdf_mh']);
            $vet['mpdf_mf'] = rawurlencode($row['mpdf_mf']);
            $vet['mpdf_papel_orientacao'] = rawurlencode($row['mpdf_papel_orientacao']);
            $vet['mpdf_papel_orientacao_tf'] = rawurlencode($vetPapelOrientacao[$row['mpdf_papel_orientacao']]);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'evento_resp_pesq_certificado':
        $vet = Array(
            'erro' => '',
        );

        try {
            if (!is_array($_POST['idt'])) {
                $_POST['idt'] = Array($_POST['idt']);
            }

            $sql = '';
            $sql .= " select ap.idt, a.idt_evento, ap.evento_resp_pesq_certificado, ap.cpf, ap.nome";
            $sql .= " from grc_atendimento a";
            $sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = a.idt ";
            $sql .= ' where ap.idt in (' . implode(', ', $_POST['idt']) . ')';
            $rst = execsql($sql, false);

            if ($_POST['val'] == '') {
                $_POST['val'] = 'N';
            }

            beginTransaction();

            $vetLogDetalheTmp = Array();

            foreach ($rst->data as $rowt) {
                $sql_a = ' update grc_atendimento_pessoa set ';
                $sql_a .= ' evento_resp_pesq_certificado = ' . aspa($_POST['val']);
                $sql_a .= ' where idt = ' . null($rowt['idt']);
                execsql($sql_a, false);

                $campoLog = 'evento_resp_pesq_certificado_' . $rowt['idt'];

                $vetLogDetalheTmp[$campoLog]['campo_desc'] = 'Pesquisa Respondida ' . $rowt['cpf'] . ' ' . $rowt['nome'] . ' [' . $rowt['idt'] . ']';
                $vetLogDetalheTmp[$campoLog]['vl_ant'] = $rowt['evento_resp_pesq_certificado'];
                $vetLogDetalheTmp[$campoLog]['desc_ant'] = $vetSimNao[$rowt['evento_resp_pesq_certificado']];
                $vetLogDetalheTmp[$campoLog]['vl_atu'] = $_POST['val'];
                $vetLogDetalheTmp[$campoLog]['desc_atu'] = $vetSimNao[$_POST['val']];
            }

            $des_registro = 'Alteração na Pesquisa Respondida?';
            grava_log_sis_banco(db_pir_grc, 'grc_evento', 'A', $rowt['idt_evento'], $des_registro, '', '', $vetLogDetalheTmp, false);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_vl_metro':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vl_metro = desformat_decimal($_POST['vl_metro']);

            $sql = 'update grc_evento_stand set';
            $sql .= ' vl_stand = area * ' . null($vl_metro);
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            execsql($sql, false);

            $sql = 'update grc_evento set';
            $sql .= ' vl_metro = ' . null($vl_metro);
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            execsql($sql, false);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_valida_stand':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select distinct c.descricao ';
            $sql .= ' from grc_evento_stand et';
            $sql .= ' inner join ' . db_pir_gec . 'cnae c on c.subclasse = et.cnae';
            $sql .= ' where et.idt_evento = ' . null($_POST['idt_evento']);
            $sql .= " and et.cnae not in (";
            $sql .= ' select cnae';
            $sql .= ' from grc_evento_cnae';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= ' )';
            $sql .= ' order by c.descricao';
            $rs = execsql($sql, false);

            $erro = Array();

            foreach ($rs->data as $row) {
                $erro[] = $row['descricao'];
            }

            if (count($erro) > 0) {
                $vet['erro'] = rawurlencode(implode(', ', $erro));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'produto_dados':
        $vet = Array(
            'erro' => '',
            'idt_secao_responsavel' => '',
        );

        try {
            $sql = "select ";
            $sql .= "   idt_secao_responsavel ";
            $sql .= " from grc_produto ";
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);

            $row = $rs->data[0];

            $vet['idt_secao_responsavel'] = rawurlencode($row['idt_secao_responsavel']);

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_produto_insumo_copia':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_produto_insumo';
            $sql .= ' where idt_produto = ' . null($_POST['idt_produto_org']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                beginTransaction();

                $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'];

                foreach ($vetSel as $idx => $dados) {
                    foreach ($rs->data as $row) {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_produto_insumo';
                        $sql .= ' where idt_produto = ' . null($dados['idt']);
                        $sql .= ' and idt_insumo = ' . null($row['idt_insumo']);
                        $rst = execsql($sql, false);

                        if ($rst->rows == 0) {
                            $sql = 'insert into grc_produto_insumo (idt_produto, idt_insumo, codigo, descricao, ativo, detalhe, quantidade,';
                            $sql .= ' custo_unitario_real, idt_insumo_unidade, por_participante, custo_total, ctotal_minimo, ctotal_maximo,';
                            $sql .= ' rtotal_minimo, rtotal_maximo, receita_total) values (';
                            $sql .= null($dados['idt']) . ', ' . null($row['idt_insumo']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['ativo']) . ', ';
                            $sql .= aspa($row['detalhe']) . ', ' . null($row['quantidade']) . ', ' . null($row['custo_unitario_real']) . ', ' . null($row['idt_insumo_unidade']) . ', ' . aspa($row['por_participante']) . ', ';
                            $sql .= null($row['custo_total']) . ', ' . null($row['ctotal_minimo']) . ', ' . null($row['ctotal_maximo']) . ', ' . null($row['rtotal_minimo']) . ', ' . null($row['rtotal_maximo']) . ', ';
                            $sql .= null($row['receita_total']) . ')';
                            execsql($sql, false);
                        }
                    }

                    CalcularInsumoProduto($dados['idt']);
                }

                commit();

                $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = Array();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_local_pa_mapa_btAlterarBloco':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            if ($_POST['ab_fim'] == '') {
                $_POST['ab_fim'] = $_POST['ab_ini'];
            }

            $_POST['ab_ini'] = mb_strtoupper($_POST['ab_ini']);
            $_POST['ab_fim'] = mb_strtoupper($_POST['ab_fim']);

            $vetIni = separaPadraoExcelColuna($_POST['ab_ini']);
            $vetFim = separaPadraoExcelColuna($_POST['ab_fim']);

            if ($vetFim['linha'] != '') {
                $alphabet = mkRange('A', $vetFim['linha']);

                $vetIni['linha'] = array_search($vetIni['linha'], $alphabet);
                $vetFim['linha'] = array_search($vetFim['linha'], $alphabet);
            }

            $sqlPadrao = 'update grc_evento_local_pa_mapa_assento set';

            if ($_POST['ab_idt_tipo_assento'] != '') {
                $sqlPadrao .= ' idt_tipo_assento = ' . null($_POST['ab_idt_tipo_assento']) . ',';
            }

            if ($_POST['ab_ativo'] != '') {
                $sqlPadrao .= ' ativo = ' . aspa($_POST['ab_ativo']) . ',';
            }

            $sqlPadrao .= ' codigo = codigo';
            $sqlPadrao .= ' where idt_local_pa_mapa = ' . null($_POST['idt']);

            switch ($_POST['padraoJS']) {
                case 'SC':
                    for ($index = $vetIni['coluna']; $index <= $vetFim['coluna']; $index++) {
                        $sql = $sqlPadrao;
                        $sql .= ' and coluna = ' . null($index);
                        execsql($sql, false);
                    }
                    break;

                case 'SL':
                    for ($index = $vetIni['linha']; $index <= $vetFim['linha']; $index++) {
                        $sql = $sqlPadrao;
                        $sql .= ' and linha = ' . null($index);
                        execsql($sql, false);
                    }
                    break;

                case 'LC':
                    $colIni = $vetIni['coluna'];

                    for ($lin = $vetIni['linha']; $lin <= $vetFim['linha']; $lin++) {
                        for ($col = $colIni; $col <= $vetFim['coluna']; $col++) {
                            $sql = $sqlPadrao;
                            $sql .= ' and coluna = ' . null($col);
                            $sql .= ' and linha = ' . null($lin);
                            execsql($sql, false);
                        }

                        $colIni = 1;
                    }
                    break;
            }

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_local_pa_mapa_assento_tabela':
        $ajax = 'S';
        $_GET['id'] = $_POST['id'];
        $acao = $_POST['acao'];
        require 'cadastro_conf/grc_evento_local_pa_mapa_assento_tabela.php';
        break;

    case 'grc_evento_mapa_assento_tabela':
        $ajax = 'S';
        $_GET['id'] = $_POST['id'];
        $acao = $_POST['acao'];
        require 'cadastro_conf/grc_evento_mapa_assento_tabela.php';
        break;

    case 'grc_evento_publicar_fechar_pen':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " situacao_para = " . aspa($_POST['situacao']) . ",";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_publicar  = ' . null($_POST['idt']);
            $sql_a .= " and ativo = 'S'";
            $sql_a .= " and tipo = 'Publicação de Eventos'";
            execsql($sql_a, false);

            if ($_POST['situacao'] == 'CA') {
                $sql = '';
                $sql .= ' select ep.*, und.descricao as unidade, plu_u.nome_completo as aprovador';
                $sql .= ' from grc_evento_publicar ep';
                $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao und on und.idt = ep.idt_unidade';
                $sql .= ' left outer join plu_usuario plu_u on plu_u.id_usuario = ep.idt_usuario_aprovacao';
                $sql .= ' where ep.idt  = ' . null($_POST['idt']);
                $rs = execsql($sql, false);
                $rowAnt = $rs->data[0];

                $sql = 'update ' . db_pir_grc . 'grc_evento_publicar set';
                $sql .= " idt_usuario_aprovacao = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql .= " dt_aprovacao = now(),";
                $sql .= ' situacao = ' . aspa($_POST['situacao']);
                $sql .= ' where idt  = ' . null($_POST['idt']);
                execsql($sql, false);

                $sql = 'update ' . db_pir_grc . 'grc_evento_publicar_evento set';
                $sql .= ' situacao = ' . aspa($_POST['situacao']);
                $sql .= ' where idt_evento_publicar  = ' . null($_POST['idt']);
                execsql($sql, false);

                //Grava Log
                $vetLogDetalheTmp = Array();

                $campoLog = 'situacao';
                $vetLogDetalheTmp[$campoLog]['campo_desc'] = 'Situacao';
                $vetLogDetalheTmp[$campoLog]['desc_ant'] = $vetEventoPubilcarRegistro[$rowAnt['situacao']];
                $vetLogDetalheTmp[$campoLog]['vl_ant'] = $rowAnt['situacao'];
                $vetLogDetalheTmp[$campoLog]['desc_atu'] = $vetEventoPubilcarRegistro[$_POST['situacao']];
                $vetLogDetalheTmp[$campoLog]['vl_atu'] = $_POST['situacao'];

                $campoLog = 'idt_usuario_aprovacao';
                $vetLogDetalheTmp[$campoLog]['campo_desc'] = 'Responsável pela Aprovação';
                $vetLogDetalheTmp[$campoLog]['desc_ant'] = $rowAnt['aprovador'];
                $vetLogDetalheTmp[$campoLog]['vl_ant'] = $rowAnt['idt_usuario_aprovacao'];
                $vetLogDetalheTmp[$campoLog]['desc_atu'] = $_SESSION[CS]['g_nome_completo'];
                $vetLogDetalheTmp[$campoLog]['vl_atu'] = $_SESSION[CS]['g_id_usuario'];

                $campoLog = 'dt_aprovacao';
                $vetLogDetalheTmp[$campoLog]['campo_desc'] = 'Situacao';
                $vetLogDetalheTmp[$campoLog]['desc_ant'] = trata_data($rowAnt['dt_aprovacao'], true);
                $vetLogDetalheTmp[$campoLog]['desc_atu'] = getdata(true, true, true);

                $des_registro = $rowAnt['codigo'] . ', ' . $rowAnt['unidade'];
                grava_log_sis_banco(db_pir_grc, 'grc_evento_publicar', 'A', $_POST['idt'], $des_registro, '', '', $vetLogDetalheTmp, false);
            }

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_despublicacao_acao':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'];

            foreach ($vetSel as $idx => $dados) {
                $sql = "update grc_evento set publica_internet = 'N'";
                $sql .= ' where idt = ' . null($dados['idt']);
                execsql($sql, false);

                grava_log_sis('grc_evento', 'R', $dados['idt'], 'Despublicação do Evento');
            }

            commit();

            $_SESSION[CS]['objListarCmbMulti'][$_POST['session_cod']]['sel_trab'] = Array();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'cmb_idt_programa_grc':
        $sql = "select idt, descricao from grc_programa ";

        if (!($_POST['idt_programa'] == '' && $_POST['idt_programa_grc'] == '')) {
            $sql .= ' where idt in (';
            $sql .= ' select idt_grc_programa';
            $sql .= ' from ' . db_pir_gec . 'gec_programa_grc_programa';
            $sql .= ' where idt = ' . null($_POST['idt_programa']);
            $sql .= ' )';
        }

        $sql .= " order by codigo";

        echo rawurlencode(option_rs(execsql($sql), '', ' '));
        break;

    case 'cmb_idt_programa':
        $sql = "select idt, descricao from " . db_pir_gec . "gec_programa ";
        $sql .= " where ativo = 'S'";

        if (!($_POST['idt_programa'] == '' && $_POST['idt_programa_grc'] == '')) {
            $sql .= ' and idt in (';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_programa_grc_programa';
            $sql .= ' where idt_grc_programa = ' . null($_POST['idt_programa_grc']);
            $sql .= ' )';
        }

        $sql .= " order by codigo";

        echo rawurlencode(option_rs(execsql($sql), '', ' '));
        break;

    case 'grc_evento_participante_fecha_ant':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select contrato, idt_midia';
            $sql .= ' from grc_evento_participante';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt']);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $del = true;
            } else {
                $row = $rs->data[0];

                if ($row['idt_midia'] == '' && $row['contrato'] == 'FE') {
                    $del = true;
                } else {
                    $del = false;
                }
            }

            if ($del) {
                $vetDel = Array();

                $sql = '';
                $sql .= ' select idt, idt_evento';
                $sql .= ' from grc_atendimento';
                $sql .= ' where idt_atendimento_pai = ' . null($_POST['idt']);
                $rs = execsql($sql, false);

                foreach ($rs->data as $row) {
                    $vetDel[] = Array(
                        'idt_evento' => $row['idt_evento'],
                        'idt_atendimento' => $row['idt'],
                    );
                }

                $vetDel[] = Array(
                    'idt_evento' => $_POST['idt_evento'],
                    'idt_atendimento' => $_POST['idt'],
                );

                beginTransaction();

                foreach ($vetDel as $row) {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_atendimento_pessoa';
                    $sql .= ' where idt_atendimento = ' . null($row['idt_atendimento']);
                    $rstt = execsql($sql, false);

                    if ($_POST['filadeespera'] != 'S') {
                    $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - " . $rstt->rows;
                    $sql .= " where idt = " . null($row['idt_evento']);
                    execsql($sql, false);
                    }

                    ajustaCupomVoucherCancelamentoMatricula($row['idt_evento'], $row['idt_atendimento'], false);

                    $sql = 'delete from grc_evento_participante_pagamento where idt_atendimento = ' . null($row['idt_atendimento']);
                    execsql($sql, false);

                    $sql = 'delete from grc_evento_participante where idt_atendimento = ' . null($row['idt_atendimento']);
                    execsql($sql, false);

                    $sql = 'delete from grc_atendimento_organizacao where idt_atendimento = ' . null($row['idt_atendimento']);
                    execsql($sql, false);

                    $sql = 'delete from grc_atendimento_pessoa where idt_atendimento = ' . null($row['idt_atendimento']);
                    execsql($sql, false);

                    $sql = "delete from grc_atendimento where idt = " . null($row['idt_atendimento']);
                    execsql($sql, false);
                }

                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_sincroniza_ws_sg_btReprocessar':
        $vet = Array(
            'erro' => '',
            'alt_evento' => '',
            'alt_pessoa' => '',
        );
		
        try {
            beginTransaction();

            $sql = "update grc_evento set ws_sg_erro = null, ws_sg_idt_erro_log = null";
            $sql .= ' where ws_sg_idt_erro_log is not null';

            if ($_POST['idt'] != '') {
                $sql .= " and idt in (" . $_POST['idt'] . ")";
            }

            $vet['alt_evento'] = execsql($sql, false);

            $sql = "update grc_atendimento_pessoa set ws_sg_erro = null, ws_sg_idt_erro_log = null";
            $sql .= ' where ws_sg_idt_erro_log is not null';

            if ($_POST['idt_atendimento_pessoa'] != '') {
                $sql .= " and idt in (" . $_POST['idt_atendimento_pessoa'] . ")";
            }

            $vet['alt_pessoa'] = execsql($sql, false);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'consultaCnpjRM':
        $vet = Array(
            'erro' => '',
            'cadastrado' => 'N',
            'par_razao_social' => '',
            'par_nome_fantasia' => '',
            'par_cep' => '',
            'par_rua' => '',
            'par_numero' => '',
            'par_bairro' => '',
            'par_cidade' => '',
            'par_estado' => '',
        );

        try {
            $SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');

            $parametro = Array(
                'DataServerName' => 'FinCFODataBR',
                'Filtro' => "codcoligada=1 and cgccfo = '" . $_POST['par_cnpj'] . "'",
                'Contexto' => 'codcoligada=1',
            );
            $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

            if ($rsRM['FCFO']->rows == 1) {
                $rowRM = $rsRM['FCFO']->data[0];

                $vet['cadastrado'] = 'S';
                $vet['par_razao_social'] = $rowRM['nome'];
                $vet['par_nome_fantasia'] = $rowRM['nomefantasia'];
                $vet['par_cep'] = $rowRM['cep'];
                $vet['par_rua'] = $rowRM['rua'];
                $vet['par_numero'] = $rowRM['numero'];
                $vet['par_bairro'] = $rowRM['bairro'];
                $vet['par_cidade'] = $rowRM['cidade'];
                $vet['par_estado'] = $rowRM['codetd'];
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = $msg;
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = $msg;
        }

        $vet = array_map('rawurlencode', $vet);
        echo json_encode($vet);
        break;

    case 'grc_evento_valida_geral':
        $vet = Array(
            'erro' => '',
            'msg' => '',
        );

        try {
            $msg = '';

            $sql = "select gec_prog.tipo_ordem, grc_e.idt_instrumento, grc_e.idt_evento_pai, grc_e.composto";
            $sql .= ' from grc_evento grc_e';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_e.idt_programa';
            $sql .= " where grc_e.idt = " . null($_POST['idt_evento']);
            $rs = execsql($sql, false);
            $rowe = $rs->data[0];

            if ($rowe['tipo_ordem'] != 'SG') {
                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_produto';
                $sql .= ' where idt = ' . null($_POST['idt_produto']);
                $rs = execsql($sql, false);
                $rowp = $rs->data[0];

                if ($rowp['generico'] == 'N') {
                    $minPart = Troca($rowp['participante_minimo'], '', 0);
                    $maxPart = Troca($rowp['participante_maximo'], '', 0);

                    if ($_POST['quantidade_participante'] < $minPart || $_POST['quantidade_participante'] > $maxPart) {
                        $msg .= "A quantidade de participantes prevista para o evento é diferente da definida para o Produto escolhido.\n";
                    }
                }

                if ($rowp['tipo_calculo'] != 'P' && $rowe['composto'] != 'S') {
                    $tot_ini = 0;

                    if ($rowp['carga_horaria_ini'] != '') {
                        $tot_ini += $rowp['carga_horaria_ini'];
                    }

                    if ($rowp['carga_horaria_2_ini'] != '') {
                        $tot_ini += $rowp['carga_horaria_2_ini'];
                    }

                    $tot_fim = 0;

                    if ($rowp['carga_horaria_fim'] != '') {
                        $tot_fim += $rowp['carga_horaria_fim'];
                    }

                    if ($rowp['carga_horaria_2_fim'] != '') {
                        $tot_fim += $rowp['carga_horaria_2_fim'];
                    }

                    $msgCH = '';

                    if ($tot_ini == $tot_fim) {
                        if ($_POST['carga_horaria_total'] != $tot_ini) {
                            $msgCH = "A Carga Horária tem que ser " . format_decimal($tot_ini) . "!";
                        }
                    } else {
                        if ($_POST['carga_horaria_total'] < $tot_ini || $_POST['carga_horaria_total'] > $tot_fim) {
                            $msgCH = "A Carga Horária tem que estar dentro da faixa de " . format_decimal($tot_ini) . " a " . format_decimal($tot_fim) . "!";
                        }
                    }

                    if ($rowp['forcar_carga_horarria'] == 'S') {
                        $vet['erro'] = rawurlencode($msgCH);
                    } else {
                        $msg .= $msgCH . "\n";
                    }
                }
            }

            //Consulrora de Longa Duração
            if ($rowe['idt_instrumento'] == 2 && $vet['erro'] == '') {
                $vetErroMsg = validaMatEventoCLD($_POST['idt_evento'], $_POST['cred_necessita_credenciado']);

                if (count($vetErroMsg) > 0) {
                    $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
                }
            }

            if ($vet['erro'] == '') {
                $vetErroMsg = Array();

                //Valida Mapa Assento
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_mapa';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= ' and idt_local_pa_mapa is null';
                $rs = execsql($sql, false);

                if ($rs->rows > 0) {
                    $vetErroMsg[] = 'Favor informar todos os Mapas dos locais do evento!';
                }

                if (count($vetErroMsg) > 0) {
                    $erro = implode("\n", $vetErroMsg);
                    $vet['erro'] = rawurlencode($erro);
                }
            }

            if ($vet['erro'] == '') {
                $vetErroMsg = Array();

                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_evento_publicacao';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= " and situacao = 'CD'";
                $sql .= " and ativo = 'S'";
                $rsEP = execsql($sql, false);

                if ($rsEP->rows > 0) {
                    $rowEP = $rsEP->data[0];

                    /*
                      $hoje = date("d/m/Y");
                      $data_publicacao_de = trata_data($rowEP['data_publicacao_de'], false, true);
                      $data_publicacao_ate = trata_data($rowEP['data_publicacao_ate'], false, true);
                      $data_hora_fim_inscricao_ec = trata_data($rowEP['data_hora_fim_inscricao_ec'], false, true);

                      if (diffDate($data_publicacao_de, $hoje) > 0) {
                      $vetErroMsg[] = 'A data Publicar De tem que ser maior ou igual a Hoje (' . $hoje . ')!';
                      }

                      if (diffDate($data_publicacao_ate, $_POST['dt_previsao_inicial']) < 0) {
                      $vetErroMsg[] = 'A data Publicar Até tem que ser menor ou igual a Início do Evento (' . $_POST['dt_previsao_inicial'] . ')!';
                      }

                      if (diffDate($data_publicacao_de, $data_publicacao_ate) < 0) {
                      $vetErroMsg[] = 'A Data Publicar Até não pode ser menor que a Data Publicar De!';
                      }

                      if (diffDate($data_hora_fim_inscricao_ec, $data_publicacao_de) > 0) {
                      $vetErroMsg[] = 'A Data Fim inscrição loja Virtual tem que ser maior ou igual a Publicar De (' . $data_publicacao_de . ')!';
                      }

                      if (diffDate($data_hora_fim_inscricao_ec, $data_publicacao_ate) < 0) {
                      $vetErroMsg[] = 'A Data Fim inscrição loja Virtual tem que ser menor ou igual a Publicar Até (' . $data_publicacao_ate . ')!';
                      }

                      if ($rowEP['restrito'] == 'S') {
                      $sql = '';
                      $sql .= ' select idt';
                      $sql .= ' from grc_evento_publicacao_publico_alvo';
                      $sql .= ' where idt = ' . null($rowEP['ift']);
                      $sql .= " and ativo = 'S'";
                      $rs = execsql($sql, false);

                      if ($rs->rows == 0) {
                      $vetErroMsg[] = 'Favor informar o Público Alvo da Política de Desconto!';
                      }
                      }
                     * 
                     */

                    if (count($vetErroMsg) == 0) {
                        $vetDados = Array(
                            'quantidade_participante' => $_POST['quantidade_participante'],
                            'data_publicacao_de' => $data_publicacao_de,
                            'data_hora_fim_inscricao_ec' => $data_hora_fim_inscricao_ec,
                            'cupon_desconto' => $rowEP['cupon_desconto'],
                            'gerador_voucher' => $rowEP['gerador_voucher'],
                            'idt' => $rowEP['idt'],
                        );

                        $vetErroMsg = validaPoliticaDesconto($vetDados);
                    }

                    if (count($vetErroMsg) > 0) {
                        $erro = "Problemas na Política de Desconto:\n" . implode("\n", $vetErroMsg);
                        $vet['erro'] = rawurlencode($erro);
                    }
                }
            }

            if ($msg != '') {
                if ($_POST['situacao_submit'] == 14) {
                    $msg .= "\nDeseja realmente aprovar esta solicitação?";
                } else {
                    $msg .= "\nDeseja realmente concluir esta solicitação?";
                }

                $vet['msg'] = rawurlencode($msg);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_valida_legado':
        $vet = Array(
            'erro' => '',
        );

        try {
            if ($vet['erro'] == '') {
                $sql = '';
                $sql .= ' select a.idt';
                $sql .= ' from grc_atendimento a';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt";
                $sql .= ' where a.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    $vet['erro'] = rawurlencode("Não pode continuar, pois o evento não tem Participante informado!");
                }
            }

            if ($vet['erro'] == '') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_agenda';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= ' and idt_atendimento is null';
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $vet['erro'] = rawurlencode("Não pode continuar, pois o evento tem Cronograma / Atividades sem Cliente\n\nSe desejar pode Excluir estes registros!");
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_valida_consolidacao':
        $vet = Array(
            'erro' => '',
        );

        try {
            /*
              if ($vet['erro'] == '') {
              $sql = '';
              $sql .= ' select a.idt';
              $sql .= ' from grc_atendimento a';
              $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt";
              $sql .= ' where a.idt_evento = '.null($_POST['idt_evento']);
              $sql .= whereEventoParticipante();
              $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
              $rs = execsql($sql);

              if ($rs->rows == 0) {
              $vet['erro'] = rawurlencode("Não pode continuar, pois o evento não tem Participante informado!");
              }
              }
             * 
             */
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_valida_composto':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            //Valida Evento
            $sql = '';
            $sql .= ' select idt_instrumento';
            $sql .= ' from grc_evento';
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);
            $rowMatPai = $rs->data[0];

            if ($rowMatPai['idt_instrumento'] == 54) {
                $sql = '';
                $sql .= ' select e.*, gec_prog.tipo_ordem';
                $sql .= ' from grc_evento e';
                $sql .= ' inner join grc_evento_combo ec on ec.idt_evento = e.idt';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
                $sql .= ' where ec.idt_evento_origem = ' . null($_POST['idt_evento']);
                $sql .= ' order by e.codigo';
            } else {
                $sql = '';
                $sql .= ' select e.*, gec_prog.tipo_ordem';
                $sql .= ' from grc_evento e';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
                $sql .= ' where e.idt_evento_pai = ' . null($_POST['idt_evento']);
                $sql .= ' order by e.codigo';
            }

            $rsEV = execsql($sql, false);

            foreach ($rsEV->data as $rowEV) {
                $ok = true;
                $vetErroMsgLocal = Array();

                if ($rowEV['dt_previsao_inicial'] != '' && substr($rowEV['dt_previsao_inicial'], 0, 4) != $rowEV['ano_competencia']) {
                    $ok = false;
                }

                if ($rowEV['muda_dt_hist'] == 'S') {
                    if (diffDate(trata_data($rowEV['dt_real_ini']), trata_data($rowEV['dt_real_fim'])) < 0) {
                        $ok = false;
                    }
                }

                if ($rowEV['tipo_ordem'] != 'SG') {
                    if ($rowEV['quantidade_participante'] == '' || $rowEV['qtd_minima_pagantes'] == '') {
                        $ok = false;
                    }

                    if ($rowEV['quantidade_participante'] != '' && $rowEV['qtd_minima_pagantes'] != '') {
                        if ($rowEV['qtd_minima_pagantes'] > $rowEV['quantidade_participante']) {
                            $ok = false;
                        }
                    }

                    if ($rowEV['gratuito'] == 'N') {
                        if ($rowEV['valor_inscricao'] <= 0 || $rowEV['valor_inscricao'] == '') {
                            $ok = false;
                        }
                    }
                }

                if ($rowEV['tipo_ordem'] != 'SG') {
                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from grc_produto';
                    $sql .= ' where idt = ' . null($rowEV['idt_produto']);
                    $rs = execsql($sql, false);
                    $rowp = $rs->data[0];

                    if ($rowp['forcar_carga_horarria'] == 'S' || $rowp['forcar_carga_horarria'] == '') {
                        $tot_ini = 0;

                        if ($rowp['carga_horaria_ini'] != '') {
                            $tot_ini += $rowp['carga_horaria_ini'];
                        }

                        if ($rowp['carga_horaria_2_ini'] != '') {
                            $tot_ini += $rowp['carga_horaria_2_ini'];
                        }

                        $tot_fim = 0;

                        if ($rowp['carga_horaria_fim'] != '') {
                            $tot_fim += $rowp['carga_horaria_fim'];
                        }

                        if ($rowp['carga_horaria_2_fim'] != '') {
                            $tot_fim += $rowp['carga_horaria_2_fim'];
                        }

                        if ($rowp['tipo_calculo'] != 'P') {
                            if ($tot_ini == $tot_fim) {
                                if ($rowEV['carga_horaria_total'] != $tot_ini) {
                                    $ok = false;
                                    $vetErroMsgLocal[] = 'Carga Horária não informada ou não esta no intervalo especificado!';
                                }
                            } else {
                                if ($rowEV['carga_horaria_total'] < $tot_ini || $rowEV['carga_horaria_total'] > $tot_fim) {
                                    $ok = false;
                                    $vetErroMsgLocal[] = 'Carga Horária não informada ou não esta no intervalo especificado!';
                                }
                            }
                        } else if ($rowp['tipo_calculo'] == 'P') {
                            if ($rowEV['carga_horaria_total'] == '' || $rowEV['carga_horaria_total'] <= 0) {
                                $ok = false;
                                $vetErroMsgLocal[] = 'Carga Horária não informada ou não esta no intervalo especificado!';
                            }
                        }
                    }
                }

                //Consulrora de Longa Duração
                if ($rowEV['idt_instrumento'] == 2) {
                    $vetTmp = validaMatEventoCLD($rowEV['idt'], $rowEV['cred_necessita_credenciado']);
                    $vetErroMsgLocal = array_merge($vetErroMsgLocal, $vetTmp);

                    if (count($vetErroMsgLocal) > 0) {
                        $ok = false;
                    }
                }

                if (!$ok) {
                    $vetErroMsg[] = $rowEV['codigo'] . ' ' . $rowEV['descricao'];
                    $vetErroMsg = array_merge($vetErroMsg, $vetErroMsgLocal);
                }
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode("Verificar os Eventos Associados:\n\n" . implode("\n", $vetErroMsg));
            } else {
                //Valida Matriculas
                $sql = '';
                $sql .= ' select a.idt, a.protocolo, p.nome';
                $sql .= ' from grc_atendimento a';
                $sql .= " left outer join grc_atendimento_pessoa p on p.tipo_relacao = 'L' and p.idt_atendimento = a.idt";
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt";
                $sql .= ' where a.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rsEV = execsql($sql, false);

                foreach ($rsEV->data as $rowEV) {
                    $ok = true;

                    //Pagamento
                    $vl_apagar = MatriculaEventoCompostoPag($rowEV['idt'], false);

                    $sql = '';
                    $sql .= ' select sum(valor_pagamento) as tot';
                    $sql .= ' from grc_evento_participante_pagamento';
                    $sql .= ' where idt_atendimento = ' . null($rowEV['idt']);
                    $sql .= " and estornado <> 'S'";
                    $sql .= " and operacao = 'C'";
                    $sql .= ' and idt_aditivo_participante is null';
                    $rs = execsql($sql, false);
                    $vl_pago = $rs->data[0][0];

                    if ($vl_pago == '') {
                        $vl_pago = 0;
                    }

                    if ($vl_apagar != $vl_pago) {
                        $ok = false;
                    }

                    //Valida Carga Horaria do Evento
                    $sql = '';
                    $sql .= ' select p.carga_horaria_ini, p.carga_horaria_2_ini, p.carga_horaria_fim, p.carga_horaria_2_fim, e.descricao, e.codigo,';
                    $sql .= ' (select sum(ea.carga_horaria) as tot from grc_evento_agenda ea where ea.idt_atendimento = a.idt) as carga_horaria_total';
                    $sql .= ' from grc_atendimento a';
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                    $sql .= ' left outer join grc_evento e on e.idt = a.idt_evento';
                    $sql .= ' left outer join grc_produto p on p.idt = e.idt_produto';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
                    $sql .= ' where a.idt_atendimento_pai = ' . null($rowEV['idt']);
                    $sql .= whereEventoParticipante();
                    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                    $sql .= " and gec_prog.tipo_ordem <> 'SG'";
                    $sql .= " and p.forcar_carga_horarria = 'S'";
                    $sql .= " and p.tipo_calculo = 'P'";
                    $sql .= ' order by e.codigo';
                    $rsEVfilho = execsql($sql, false);

                    foreach ($rsEVfilho->data as $rowEVfilho) {
                        $vetErroMsgLocal = Array();

                        $tot_ini = 0;

                        if ($rowEVfilho['carga_horaria_ini'] != '') {
                            $tot_ini += $rowEVfilho['carga_horaria_ini'];
                        }

                        if ($rowEVfilho['carga_horaria_2_ini'] != '') {
                            $tot_ini += $rowEVfilho['carga_horaria_2_ini'];
                        }

                        $tot_fim = 0;

                        if ($rowEVfilho['carga_horaria_fim'] != '') {
                            $tot_fim += $rowEVfilho['carga_horaria_fim'];
                        }

                        if ($rowEVfilho['carga_horaria_2_fim'] != '') {
                            $tot_fim += $rowEVfilho['carga_horaria_2_fim'];
                        }

                        if ($tot_ini == $tot_fim) {
                            if ($rowEVfilho['carga_horaria_total'] != $tot_ini) {
                                $ok = false;
                                $vetErroMsgLocal[] = "A Carga Horária tem que ser " . format_decimal($tot_ini) . " para o [" . $rowEVfilho['codigo'] . "] " . $rowEVfilho['descricao'] . "!";
                            }
                        } else {
                            if ($rowEVfilho['carga_horaria_total'] < $tot_ini || $rowEVfilho['carga_horaria_total'] > $tot_fim) {
                                $ok = false;
                                $vetErroMsgLocal[] = "A Carga Horária tem que estar dentro da faixa de " . format_decimal($tot_ini) . " a " . format_decimal($tot_fim) . " para o [" . $rowEVfilho['codigo'] . "] " . $rowEVfilho['descricao'] . "!";
                            }
                        }
                    }

                    if (!$ok) {
                        $vetErroMsg[] = $rowEV['protocolo'] . ' ' . $rowEV['nome'];
                        $vetErroMsg = array_merge($vetErroMsg, $vetErroMsgLocal);
                    }
                }

                if (count($vetErroMsg) > 0) {
                    $vet['erro'] = rawurlencode("Verificar as Inscrições e Encerramento:\n\n" . implode("\n", $vetErroMsg));
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_agenda_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetMesAno = Array();

            $vetDT = DatetoArray($_POST['data_inicial'] . ' ' . $_POST['hora_inicial']);
            $intIni = mktime($vetDT['hora'], $vetDT['min'], $vetDT['seg'], $vetDT['mes'], $vetDT['dia'], $vetDT['ano']);

            $vetDT = DatetoArray($_POST['data_final'] . ' ' . $_POST['hora_final']);
            $intFim = mktime($vetDT['hora'], $vetDT['min'], $vetDT['seg'], $vetDT['mes'], $vetDT['dia'], $vetDT['ano']);

            $nextDia = 86400; //Qtd de segundos em 24h

            for ($i = $intIni; $i <= $intFim; $i = $i + $nextDia) {
                $dia = date('d/m/Y', $i);
                $mes = date('m', $i);
                $ano = date('Y', $i);
                $dt_ini = $dia . ' ' . $_POST['hora_inicial'];
                $dt_fim = $dia . ' ' . $_POST['hora_final'];
                $tot_hora = diffDate($dt_ini, $dt_fim, 'H');

                $vetMesAno[(int) $ano][(int) $mes] += $tot_hora;
            }

            $vetExtra = Array(
                'idt' => $_POST['idt'],
                'idt_atendimento' => $_POST['idt_atendimento'],
                'idt_evento_atividade' => $_POST['idt_evento_atividade'],
                'dt_ini' => $_POST['data_inicial'],
                'dt_fim' => $_POST['data_final'],
                'hora_inicial' => $_POST['hora_inicial'],
                'vetMesAno' => $vetMesAno,
            );

            $vetErroMsg = validaMatEventoCLD($_POST['idt_evento'], $_POST['cred_necessita_credenciado'], $vetExtra);

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_unidade_cidade':
        $vet = Array(
            'erro' => '',
            'cod' => '',
            'desc' => '',
        );

        try {
            $sql = '';
            $sql .= ' select logradouro_codcid';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where idt = ' . null($_POST['idt_unidade']);
            $rs = execsql($sql, false);
            $codcid_unidade = $rs->data[0][0];

            $sql = '';
            $sql .= ' select logradouro_codcid';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where idt = ' . null($_POST['idt_ponto_atendimento_tela']);
            $rs = execsql($sql, false);
            $codcid_pa = $rs->data[0][0];

            if ($codcid_pa == '') {
                $vet['cod'] = rawurlencode($codcid_unidade);
            } else {
                $vet['cod'] = rawurlencode($codcid_pa);
            }

            if ($vet['cod'] != '') {
                $sql = '';
                $sql .= ' select desccid';
                $sql .= ' from ' . db_pir_siac . 'cidade';
                $sql .= ' where codcid = ' . null($vet['cod']);
                $rs = execsql($sql, false);
                $vet['desc'] = rawurlencode($rs->data[0][0]);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_combo_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            if ($_POST['idt'] == 0) {
                $sql = '';
                $sql .= ' select (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
                $sql .= ' from grc_evento e';
                $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
                $rs = execsql($sql, false);

                if ($rs->rows > 0) {
                    $row = $rs->data[0];

                    if ($row['qtd_disponivel'] < $_POST['qtd_vaga']) {
                        $vet['erro'] = rawurlencode('O Evento selecioando não tem a Qtd. Disponível! Qtd. Disponível no Evento: ' . $row['qtd_disponivel']);
                    }
                }
            } else {
                //Desbloquea a Qtd. Vagas no Evento
                $vetErro = operacaoEventoComboVaga($_POST['idt'], FALSE, false);

                if (count($vetErro) > 0) {
                    $vet['erro'] = rawurlencode(implode('<br />', $vetErro));
                } else {
                    $sql = 'update grc_evento_combo set';
                    $sql .= ' idt_evento = ' . null($_POST['idt_evento']) . ',';
                    $sql .= ' qtd_vaga = ' . null($_POST['qtd_vaga']);
                    $sql .= ' where idt = ' . null($_POST['idt']);
                    execsql($sql, false);

                    //Bloquea a Qtd. Vagas no Evento
                    $vetErro = operacaoEventoComboVaga($_POST['idt'], TRUE, false);

                    if (count($vetErro) > 0) {
                        $vet['erro'] = rawurlencode(implode('<br />', $vetErro));
                    }
                }
            }

            rollBack();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_combo_dados':
        $vet = Array(
            'erro' => '',
            'vl_evento' => '',
            'qtd_disponivel' => '',
        );

        try {
            $sql = '';
            $sql .= ' select valor_inscricao,';
            $sql .= ' (quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra) - (qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas) as qtd_disponivel';
            $sql .= ' from grc_evento';
            $sql .= ' where idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);

            $row = $rs->data[0];
            $vl_evento = $row['valor_inscricao'];

            if ($vl_evento == '') {
                $vl_evento = 0;
            }

            $vl_evento = format_decimal($vl_evento);

            $vet['vl_evento'] = rawurlencode($vl_evento);
            $vet['qtd_disponivel'] = rawurlencode($row['qtd_disponivel']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_combo_tipo':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $sql = 'update grc_evento_combo set';
            $sql .= " matricula_obr = 'S'";
            $sql .= ' where idt_evento_origem = ' . null($_POST['idt']);
            execsql($sql, false);

            $sql = 'update grc_evento_combo_instrumento set';
            $sql .= ' qtd_min = qtd_max,';
            $sql .= ' qtd_atual = qtd_max';
            $sql .= ' where idt_evento = ' . null($_POST['idt']);
            execsql($sql, false);

            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = validaPoliticaDesconto($_POST);

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_voucher_ant':
        $vet = Array(
            'erro' => '',
            'qtd' => 0,
        );

        try {
            //Tem que ter o a pessoa fisica no tipo B
            $sql = "select vr.numero";
            $sql .= " from grc_evento_publicacao_voucher_registro vr ";
            $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
            $sql .= ' where v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
            $sql .= ' and vr.cpf is null';
            $sql .= " and vr.idt_evento_publicacao = " . null($_POST['idt']);
            $sql .= " order by vr.numero";
            $rs = execsql($sql, false);
            $vet['qtd'] = $rs->rows;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_voucher_del':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            //Desbloquea a Qtd. Vagas no Evento
            $vetErro = operacaoVoucherVaga($_POST['idt'], FALSE, false);

            if (count($vetErro) > 0) {
                rollBack();

                $vet['erro'] = rawurlencode(implode('<br />', $vetErro));
            } else {
                $sql = "delete from grc_evento_publicacao_voucher";
                $sql .= ' where idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
                $sql .= " and idt = " . null($_POST['idt']);
                execsql($sql, false);

                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_voucher_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = validaVoucherEvento($_POST['idt'], $_POST['idt_evento_publicacao'], $_POST);

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_cupom_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            //Verifica se tem a Qtd. de Cupons disponível do Cupom
            $sql = '';
            $sql .= ' select qtd_disponivel';
            $sql .= ' from grc_evento_cupom';
            $sql .= ' where idt = ' . null($_POST['idt_evento_cupom']);
            $rs = execsql($sql, false);
            $qtd = $rs->data[0][0];

            if ($qtd < $_POST['qtd_resevada']) {
                $vetErroMsg[] = 'O Cupom selecioando não tem a Qtd. de Cupons! Qtd. Disponível do Cupom: ' . $qtd;
            }

            $sql = '';
            $sql .= ' select (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
            $sql .= ' from grc_evento e';
            $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $row = $rs->data[0];

                if ($row['qtd_disponivel'] < $_POST['qtd_resevada']) {
                    $vetErroMsg[] = 'O Evento não tem a Qtd. Disponível! Qtd. Disponível no Evento: ' . $row['qtd_disponivel'];
                }
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'GerarVoucher':
        $vet = Array(
            'erro' => '',
            'idt_voucher_numero' => '',
            'voucher_numero' => '',
            'voucher_numero_indicador' => '',
            'idt_voucher_numero_indicador' => '',
            'altera_numero' => 'S',
        );

        try {
            $erroTransaction = true;
            $campoEP = '';
            $acaoGerarVoucher = true;
            beginTransaction();

            $sql = '';
            $sql .= ' select idt_evento';
            $sql .= ' from grc_evento_publicacao';
            $sql .= ' where idt = ' . null($_POST['idt_evento_publicacao']);
            $rs = execsql($sql, false);
            $idt_evento = $rs->data[0][0];

            $sql = '';
            $sql .= ' select codigo';
            $sql .= ' from grc_evento_tipo_voucher';
            $sql .= ' where idt = ' . null($_POST['idt_tipo_voucher']);
            $rs = execsql($sql, false);
            $tipo_voucher = 'V' . $rs->data[0][0];

            if ($tipo_voucher == 'VA' || $tipo_voucher == 'VE') {
                $campoEP = 'gerar_voucher_' . mb_strtolower($rs->data[0][0]);

                if ($campoEP != '') {
                    $sql = '';
                    $sql .= ' select idt, ' . $campoEP . ' as gera';
                    $sql .= ' from grc_evento_participante';
                    $sql .= ' where idt_atendimento = ' . null($_POST['idt_matricula_gerado']);
                    $rs = execsql($sql, false);
                    $row = $rs->data[0];

                    if ($row['gera'] == $_POST['gera']) {
                        $acaoGerarVoucher = false;
                        $vet['altera_numero'] = 'N';
                    } else {
                        if ($rs->rows == 0) {
                            $sql = 'insert into grc_evento_participante (idt_atendimento, ' . $campoEP . ') VALUES (' . null($_POST['idt_matricula_gerado']) . ', ' . aspa($_POST['gera']) . ')';
                            execsql($sql, false);
                            $idt_evento_participante = lastInsertId();
                        } else {
                            $idt_evento_participante = $row['idt'];

                            $sql = 'update grc_evento_participante set';
                            $sql .= ' ' . $campoEP . ' = ' . aspa($_POST['gera']);
                            $sql .= ' where idt = ' . null($idt_evento_participante);
                            execsql($sql, false);
                        }
                    }
                }
            }

            if ($acaoGerarVoucher) {
                $sql = '';
                $sql .= ' select data_validade, qtd_prazo, qtd_prazo_indicador';
                $sql .= ' from grc_evento_publicacao_voucher';
                $sql .= ' where idt = ' . null($_POST['idt_evento_publicacao_voucher']);
                $rs = execsql($sql, false);
                $row = $rs->data[0];

                if ($row['qtd_prazo'] == '') {
                    $data_validade = $row['data_validade'];
                } else {
                    $data_validade = trata_data(Calendario::Intervalo_Util(getdata(false, true), $row['qtd_prazo']));
                }

                switch ($tipo_voucher) {
                    case 'VA':
                        if ($_POST['gera'] == 'S') {
                            $codigo = 'grc_evento_publicacao_voucher_registro_numero_' . $tipo_voucher;
                            $numero = $tipo_voucher . AutoNum($codigo, 12);

                            $sql = 'insert into grc_evento_publicacao_voucher_registro (idt_evento_publicacao, idt_evento_publicacao_voucher, numero, data_validade, idt_matricula_gerado) values (';
                            $sql .= null($_POST['idt_evento_publicacao']) . ', ' . null($_POST['idt_evento_publicacao_voucher']) . ', ' . aspa($numero) . ', ' . aspa($data_validade) . ', ' . null($_POST['idt_matricula_gerado']) . ')';
                            execsql($sql, false);
                            $idt_voucher_numero = lastInsertId();

                            $sql = '';
                            $sql .= ' select quantidade';
                            $sql .= ' from grc_evento_publicacao_voucher';
                            $sql .= ' where idt = ' . null($_POST['idt_evento_publicacao_voucher']);
                            $rs = execsql($sql, false);
                            $qtd_vaga = $rs->data[0][0];

                            $sql = '';
                            $sql .= ' select count(idt) as tot';
                            $sql .= ' from grc_evento_publicacao_voucher_registro';
                            $sql .= ' where idt_evento_publicacao_voucher = ' . null($_POST['idt_evento_publicacao_voucher']);
                            $sql .= " and ativo = 'S'";
                            $rs = execsql($sql, false);
                            $qtd_utilizada = $rs->data[0][0];

                            if ($qtd_utilizada > $qtd_vaga) {
                                $vet['erro'] = rawurlencode('Não tem mais voucher disponível!');
                            } else {
                                $sql = 'update grc_evento set';
                                $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + 1';
                                $sql .= ' where idt = ' . null($idt_evento);
                                execsql($sql, false);

                                $sql = '';
                                $sql .= ' select (e.quantidade_participante + e.qtd_vagas_adicional + e.qtd_vagas_extra) - (e.qtd_matriculado_siacweb + e.qtd_vagas_resevado + e.qtd_vagas_bloqueadas) as qtd_disponivel';
                                $sql .= ' from grc_evento e';
                                $sql .= ' where e.idt = ' . null($idt_evento);
                                $rs = execsql($sql, false);
                                $row = $rs->data[0];

                                if ($row['qtd_disponivel'] < 0) {
                                    $vet['erro'] = rawurlencode('O Evento não tem a Qtd. Disponível! Qtd. Disponível no Evento: ' . $row['qtd_disponivel']);
                                } else {
                                    $vet['voucher_numero'] = $numero;
                                    $vet['idt_voucher_numero'] = $idt_voucher_numero;
                                    $erroTransaction = false;
                                }
                            }
                        } else {
                            $sql = 'delete from grc_evento_publicacao_voucher_registro';
                            $sql .= ' where idt_evento_publicacao_voucher = ' . null($_POST['idt_evento_publicacao_voucher']);
                            $sql .= ' and idt_matricula_gerado = ' . null($_POST['idt_matricula_gerado']);
                            $qtd = execsql($sql, false);

                            $sql = 'update grc_evento set';
                            $sql .= ' qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - ' . $qtd;
                            $sql .= ' where idt = ' . null($idt_evento);
                            execsql($sql, false);

                            $erroTransaction = false;
                        }
                        break;

                    case 'VE':
                        if ($_POST['gera'] == 'S') {
                            //Indicado
                            $codigo = 'grc_evento_publicacao_voucher_registro_numero_' . $tipo_voucher;
                            $cod = AutoNum($codigo, 12);

                            $numero = $tipo_voucher . 'O' . $cod;

                            $sql = 'insert into grc_evento_publicacao_voucher_registro (idt_evento_publicacao, idt_evento_publicacao_voucher, numero, data_validade, idt_matricula_gerado) values (';
                            $sql .= null($_POST['idt_evento_publicacao']) . ', ' . null($_POST['idt_evento_publicacao_voucher']) . ', ' . aspa($numero) . ', ' . aspa($data_validade) . ', ' . null($_POST['idt_matricula_gerado']) . ')';
                            execsql($sql, false);
                            $idt_voucher_numero = lastInsertId();

                            $vet['voucher_numero'] = $numero;
                            $vet['idt_voucher_numero'] = $idt_voucher_numero;

                            //Indicador
                            $numero = $tipo_voucher . 'R' . $cod;

                            $data_validade = trata_data(Calendario::Intervalo_Util(getdata(false, true), $row['qtd_prazo_indicador']));

                            $sql = 'insert into grc_evento_publicacao_voucher_registro (idt_evento_publicacao, idt_evento_publicacao_voucher, numero, data_validade, idt_matricula_gerado) values (';
                            $sql .= null($_POST['idt_evento_publicacao']) . ', ' . null($_POST['idt_evento_publicacao_voucher']) . ', ' . aspa($numero) . ', ' . aspa($data_validade) . ', ' . null($_POST['idt_matricula_gerado']) . ')';
                            execsql($sql, false);
                            $idt_voucher_numero_indicador = lastInsertId();

                            $vet['voucher_numero_indicador'] = $numero;
                            $vet['idt_voucher_numero_indicador'] = $idt_voucher_numero_indicador;

                            //Grava no Banco
                            $sql = 'update grc_evento_participante set';
                            $sql .= ' idt_voucher_e_indicado = ' . null($idt_voucher_numero) . ',';
                            $sql .= ' idt_voucher_e_indicador = ' . null($idt_voucher_numero_indicador);
                            $sql .= ' where idt = ' . null($idt_evento_participante);
                            execsql($sql, false);

                            $erroTransaction = false;
                        } else {
                            //Grava no Banco
                            $sql = 'update grc_evento_participante set';
                            $sql .= ' idt_voucher_e_indicado = null,';
                            $sql .= ' idt_voucher_e_indicador = null';
                            $sql .= ' where idt = ' . null($idt_evento_participante);
                            execsql($sql, false);

                            $sql = 'delete from grc_evento_publicacao_voucher_registro';
                            $sql .= ' where idt_evento_publicacao_voucher = ' . null($_POST['idt_evento_publicacao_voucher']);
                            $sql .= ' and idt_matricula_gerado = ' . null($_POST['idt_matricula_gerado']);
                            $qtd = execsql($sql, false);

                            $erroTransaction = false;
                        }
                        break;

                    default:
                        $vet['erro'] = rawurlencode('Falta implementar o ajax GerarVoucher para o tipo ' . $tipo_voucher . '!');
                        break;
                }
            }

            if ($erroTransaction) {
                rollBack();
            } else {
                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ChecaVoucher':
        $vet = Array(
            'erro' => '',
            'voucher_numero' => '',
        );

        try {
            beginTransaction();

            if ($_POST['voucher_numero'] != '') {
                $erro = acaoChecaVoucher($_POST['voucher_numero'], $_POST['idt_evento'], $_POST['idt_matricula_utilizado'], false);
            }

            if ($erro == '') {
                if ($_POST['voucher_numero'] == '' || substr($_POST['voucher_numero'], 0, 3) == 'VER') {
                    $sql = '';
                    $sql .= ' select idt, usado_numero_voucher_e';
                    $sql .= ' from grc_evento_participante';
                    $sql .= ' where idt_atendimento = ' . null($_POST['idt_matricula_utilizado']);
                    $rsEP = execsql($sql, false);
                    $rowEP = $rsEP->data[0];

                    $sql = 'update grc_evento_publicacao_voucher_registro vr';
                    $sql .= ' set vr.dt_utilizacao = null,';
                    $sql .= ' vr.idt_matricula_utilizado = null';
                    $sql .= ' where vr.numero = ' . aspa($rowEP['usado_numero_voucher_e']);
                    execsql($sql, false);

                    $sql = 'update grc_evento_publicacao_voucher_registro vr';
                    $sql .= ' set vr.dt_utilizacao = now(),';
                    $sql .= ' vr.idt_matricula_utilizado = ' . null($_POST['idt_matricula_utilizado']);
                    $sql .= ' where vr.numero = ' . aspa($_POST['voucher_numero']);
                    execsql($sql, false);

                    if ($rsEP->rows == 0) {
                        $sql = 'insert into grc_evento_participante (idt_atendimento, usado_numero_voucher_e) values (';
                        $sql .= null($_POST['idt_matricula_utilizado']) . ', ' . aspa($_POST['voucher_numero']) . ')';
                        execsql($sql, false);
                    } else {
                        $sql = 'update grc_evento_participante set';
                        $sql .= ' usado_numero_voucher_e = ' . aspa($_POST['voucher_numero']);
                        $sql .= ' where idt = ' . null($rowEP['idt']);
                        execsql($sql, false);
                    }

                    $sql = '';
                    $sql .= ' select v.perc_desconto_indicador';
                    $sql .= ' from grc_evento_publicacao_voucher_registro vr';
                    $sql .= " inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher";
                    $sql .= " inner join grc_evento_publicacao ep on ep.idt = vr.idt_evento_publicacao";
                    $sql .= ' where vr.numero = ' . aspa($_POST['voucher_numero']);
                    $sql .= " and ep.situacao = 'AP'";
                    $rs = execsql($sql, false);

                    if ($rs->rows == 0) {
                        $sql = 'delete from grc_evento_participante_desconto';
                        $sql .= ' where idt_atendimento = ' . null($_POST['idt_matricula_utilizado']);
                        $sql .= " and codigo = 'voucher_e_indicador'";
                        execsql($sql, false);
                    } else {
                        cadastraMatriculaDesconto($_POST['idt_matricula_utilizado'], 'voucher_e_indicador', 'Desconto pela Indicação do Amigo', $rs->data[0][0], false);
                    }

                    operacaoEventoPagamentoDesconto($_POST['idt_matricula_utilizado'], $_POST['vl_evento'], false);
                }

                commit();
            } else {
                rollBack();

                $sql = '';
                $sql .= ' select usado_numero_voucher_e';
                $sql .= ' from grc_evento_participante';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_matricula_utilizado']);
                $rsEP = execsql($sql, false);
                $vet['voucher_numero'] = rawurlencode($rsEP->data[0][0]);

                $vet['erro'] = rawurlencode($erro);
            }
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'GerarDescontoPorte':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();

            $sql = '';
            $sql .= ' select epp.percentual_desconto';
            $sql .= " from grc_evento_publicacao ep";
            $sql .= " inner join grc_evento_publicacao_porte epp on epp.idt_evento_publicacao = ep.idt";
            $sql .= ' where ep.idt = ' . null($_POST['idt_evento_publicacao']);
            $sql .= ' and epp.idt_porte = ' . null($_POST['idt_porte']);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $sql = 'delete from grc_evento_participante_desconto';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= " and codigo = 'porte'";
                execsql($sql, false);
            } else {
                cadastraMatriculaDesconto($_POST['idt_atendimento'], 'porte', 'Desconto por Porte', $rs->data[0][0], false);
            }

            operacaoEventoPagamentoDesconto($_POST['idt_atendimento'], $_POST['vl_evento'], false);

            commit();
        } catch (PDOException $e) {
            rollBack();

            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();

            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'marcaAssento':
        $vet = Array(
            'erro' => '',
            'marcado' => '',
            'html' => '',
        );

        try {
            beginTransaction();

            $erro = '';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pessoa';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_matricula_utilizado']);
            $rs = execsql($sql, false);
            $qtd_pessoa = $rs->rows;

            $sql = '';
            $sql .= ' select idt, ativo, idt_matricula_utilizado';
            $sql .= ' from grc_evento_mapa_assento';
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            if ($row['ativo'] == 'N') {
                $erro = 'Este lugar não está disponível';
            } else {
                if ($row['idt_matricula_utilizado'] == '') {
                    $vet['marcado'] = 'S';

                    $sql = 'update grc_evento_mapa_assento set';
                    $sql .= ' idt_matricula_utilizado = ' . null($_POST['idt_matricula_utilizado']);
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else if ($row['idt_matricula_utilizado'] == $_POST['idt_matricula_utilizado']) {
                    $vet['marcado'] = 'N';

                    $sql = 'update grc_evento_mapa_assento set';
                    $sql .= ' idt_matricula_utilizado = null';
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'Este lugar não está disponível';
                }
            }

            if ($erro == '') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_mapa_assento';
                $sql .= ' where idt_matricula_utilizado = ' . null($_POST['idt_matricula_utilizado']);
                $rs = execsql($sql, false);
                $qtd_marcado = $rs->rows;

                if ($qtd_marcado > $qtd_pessoa) {
                    $erro = 'Já estão selecionados os ' . $qtd_pessoa . ' lugares para está matricula!';
                }
            }

            if ($erro == '') {
                commit();
            } else {
                rollBack();

                $vet['erro'] = rawurlencode($erro);

                $ajax = 'S';
                $idt_evento = $_POST['idt_evento'];
                $_GET['id'] = $_POST['idt_matricula_utilizado'];
                $vet['html'] = require('cadastro_conf/grc_evento_participante_assento.php');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'BuscaCPF_Nome':
        $vet = Array(
            'erro' => '',
            'nome_pessoa' => '',
        );

        try {
            $cpfcnpj_w = FormataCPF12($_POST['cpf']);

            $vetEntidade = Array();
            BuscaDadosEntidadePIR($cpfcnpj_w, 'P', $vetEntidade);
            BuscaDadosEntidadeSIACBA($cpfcnpj_w, 'F', $vetEntidade);
            BuscaDadosEntidadeMEI($cpfcnpj_w, 'F', $vetEntidade);

            $nome_pessoa = '';

            if ($nome_pessoa == '') {
                $vetpir = $vetEntidade['PIR']['P'];

                if ($vetpir['existe_entidade'] == 'S') {
                    $nome_pessoa = $vetpir['nome'];
                }
            }

            if ($nome_pessoa == '') {
                $vetpir = $vetEntidade['SIACBA']['F'];

                if ($vetpir['existe_entidade'] == 'S') {
                    $nome_pessoa = $vetpir['nomerazaosocial'];
                }
            }

            if ($nome_pessoa == '') {
                $vetpir = $vetEntidade['MEI']['F'];

                if ($vetpir['existe_entidade'] == 'S') {
                    $nome_pessoa = $vetpir['nome'];
                }
            }

            $vet['nome_pessoa'] = rawurlencode($nome_pessoa);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'geraMapaAssento':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();
            geraMapaAssento($_POST['idt'], $_POST['assento_marcado'], false);
            commit();
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'sincronizaRM':
        $vet = Array(
            'erro' => '',
        );

        try {
            set_time_limit(60);

            $SoapSebraeRM_CS = new SoapSebraeRMGeral('wsConsultaSQL');

            $parametro = Array(
                'codSentenca' => 'ws_pir_movimnf',
                'codColigada' => '1',
                'codAplicacao' => 'T',
                'parameters' => 'idmov=' . null($_POST['idmov']),
            );
            $rsRM = $SoapSebraeRM_CS->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);

            if (is_array($rsRM)) {
                $rowRM = $rsRM['Resultado']->data[0];

                $numero_mov = aspa($rowRM['numeromov']);

                $vetTmp = explode('T', $rowRM['datasaida']);
                $data_autorizacao = aspa($vetTmp[0]);

                $idmov = null($rowRM['idmov']);
                $cod_tmov = aspa($rowRM['codtmv']);
                $valor_total = null($rowRM['valorbruto']);

                $sql_i = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                $sql_i .= " ativo = 'S',";
                $sql_i .= " nf_cnpjcpf = " . aspa($rowRM['cgccfo']) . ", ";
                $sql_i .= " nf_protocolo = $numero_mov, ";
                $sql_i .= " nf_data_registro = $data_autorizacao, ";
                $sql_i .= " nf_codtmv = $cod_tmov, ";
                $sql_i .= " nf_valorbruto = $valor_total, ";
                $sql_i .= " nf_idmov = $idmov ";
                $sql_i .= " where idmov = " . null($_POST['idmov']);
                execsql($sql_i, false);
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_pessoa_tema_interesse_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pessoa_tema_interesse';
            $sql .= ' where idt <> ' . null($_POST['idt']);
            $sql .= ' and idt_atendimento_pessoa = ' . null($_POST['idt_atendimento_pessoa']);
            $sql .= ' and idt_tema = ' . null($_POST['idt_tema']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vet['erro'] = rawurlencode('Tema já cadastrado!');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'evento_natureza_forma_parcelamento':
        $sql = "select idt, valor_ini, codigo from grc_evento_forma_parcelamento ";
        $sql .= ' where idt_natureza = ' . null($_GET['val']);
        $sql .= " and ativo = 'S'";
        $sql .= " order by numero_de_parcelas";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ', '', Array('valor_ini'));
        break;

    case 'grc_evento_participante_valida_geral':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select a.idt_evento, a.idt_instrumento, e.idt_evento_situacao, e.nao_sincroniza_rm, e.sgtec_modelo, e.vl_determinado, e.idt_produto,';
            $sql .= ' e.combo_qtd_evento_insc, ep.contrato';
            $sql .= ' from grc_atendimento a';
            $sql .= ' inner join grc_evento e on a.idt_evento = e.idt';
            $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
            $sql .= ' where a.idt = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $rowDados = $rs->data[0];

            if ($_POST['composto'] == 'S') {
                MatriculaEventoCompostoPag($_POST['id'], false);
            }

            //Verifica as informações do Evento Composto
            if ($vet['erro'] == '' && $rowDados['idt_instrumento'] == 54) {
                $vetErroMsgLocal = Array();

                //Quantidade matriculada e por Instrumento
                $sql = '';
                $sql .= ' select a.idt_instrumento';
                $sql .= ' from grc_atendimento a';
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                $sql .= ' where a.idt_atendimento_pai = ' . null($_POST['id']);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rsEVfilho = execsql($sql, false);

                $qtdTotal = 0;
                $vetQtdIns = Array();

                foreach ($rsEVfilho->data as $rowEVfilho) {
                    $qtdTotal++;
                    $vetQtdIns[$rowEVfilho['idt_instrumento']] ++;
                }

                if ($qtdTotal != $rowDados['combo_qtd_evento_insc']) {
                    $vetErroMsgLocal[] = "Tem que ter " . $rowDados['combo_qtd_evento_insc'] . " eventos selecionados!";
                } else {
                    $sql = '';
                    $sql .= ' select eci.idt_instrumento, i.descricao, eci.qtd_atual';
                    $sql .= ' from grc_evento_combo_instrumento eci';
                    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = eci.idt_instrumento';
                    $sql .= ' where eci.idt_evento = ' . null($rowDados['idt_evento']);
                    $sql .= ' and eci.qtd_atual > 0';
                    $rs = execsql($sql, false);

                    foreach ($rs->data as $row) {
                        $qtd = $vetQtdIns[$row['idt_instrumento']];

                        if ($qtd == '') {
                            $qtd = 0;
                        }

                        if ($qtd < $row['qtd_atual']) {
                            $vetErroMsgLocal[] = "O instrumento " . $row['descricao'] . " tem que ter no mínimo de " . $row['qtd_atual'] . " evento selecionado!";
                        }
                    }
                }

                if (count($vetErroMsgLocal) > 0) {
                    $vet['erro'] = rawurlencode(implode("\n", $vetErroMsgLocal));
                }
            }

            //Valida Carga Horaria do Evento
            if ($vet['erro'] == '') {
                $sql = '';
                $sql .= ' select p.carga_horaria_ini, p.carga_horaria_2_ini, p.carga_horaria_fim, p.carga_horaria_2_fim, e.descricao, e.codigo,';
                $sql .= ' (select sum(ea.carga_horaria) as tot from grc_evento_agenda ea where ea.idt_atendimento = a.idt) as carga_horaria_total';
                $sql .= ' from grc_atendimento a';
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                $sql .= ' left outer join grc_evento e on e.idt = a.idt_evento';
                $sql .= ' left outer join grc_produto p on p.idt = e.idt_produto';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';

                if ($_POST['composto'] == 'S') {
                    $sql .= ' where a.idt_atendimento_pai = ' . null($_POST['id']);
                } else {
                    $sql .= ' where a.idt = ' . null($_POST['id']);
                }

                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $sql .= " and gec_prog.tipo_ordem <> 'SG'";
                $sql .= " and p.forcar_carga_horarria = 'S'";
                $sql .= " and p.tipo_calculo = 'P'";
                $sql .= ' order by e.codigo';
                $rsEVfilho = execsql($sql, false);

                foreach ($rsEVfilho->data as $rowEVfilho) {
                    $vetErroMsgLocal = Array();

                    $tot_ini = 0;

                    if ($rowEVfilho['carga_horaria_ini'] != '') {
                        $tot_ini += $rowEVfilho['carga_horaria_ini'];
                    }

                    if ($rowEVfilho['carga_horaria_2_ini'] != '') {
                        $tot_ini += $rowEVfilho['carga_horaria_2_ini'];
                    }

                    $tot_fim = 0;

                    if ($rowEVfilho['carga_horaria_fim'] != '') {
                        $tot_fim += $rowEVfilho['carga_horaria_fim'];
                    }

                    if ($rowEVfilho['carga_horaria_2_fim'] != '') {
                        $tot_fim += $rowEVfilho['carga_horaria_2_fim'];
                    }

                    if ($tot_ini == $tot_fim) {
                        if ($rowEVfilho['carga_horaria_total'] != $tot_ini) {
                            $ok = false;
                            if ($_POST['composto'] == 'S') {
                                $vetErroMsgLocal[] = "A Carga Horária tem que ser " . format_decimal($tot_ini) . " para o [" . $rowEVfilho['codigo'] . "] " . $rowEVfilho['descricao'] . "!";
                            } else {
                                $vetErroMsgLocal[] = "A Carga Horária tem que ser " . format_decimal($tot_ini) . "!";
                            }
                        }
                    } else {
                        if ($rowEVfilho['carga_horaria_total'] < $tot_ini || $rowEVfilho['carga_horaria_total'] > $tot_fim) {
                            $ok = false;
                            if ($_POST['composto'] == 'S') {
                                $vetErroMsgLocal[] = "A Carga Horária tem que estar dentro da faixa de " . format_decimal($tot_ini) . " a " . format_decimal($tot_fim) . " para o [" . $rowEVfilho['codigo'] . "] " . $rowEVfilho['descricao'] . "!";
                            } else {
                                $vetErroMsgLocal[] = "A Carga Horária tem que estar dentro da faixa de " . format_decimal($tot_ini) . " a " . format_decimal($tot_fim) . "!";
                            }
                        }
                    }
                }

                if (!$ok) {
                    $vet['erro'] = rawurlencode(implode("\n", $vetErroMsgLocal));
                }
            }

            //Valida Valor do Pagamento
            if ($vet['erro'] == '' && $rowDados['contrato'] != 'FE') {
                $validaPAG = true;

                if ($_POST['veio'] == 'SG') {
                    atualizaPagEventoSG($rowDados['idt_evento'], false);
                }

                $sql = '';
                $sql .= ' select sum(valor_pagamento) as tot';
                $sql .= ' from grc_evento_participante_pagamento';
                $sql .= ' where idt_atendimento = ' . null($_POST['id']);
                $sql .= " and estornado <> 'S'";
                $sql .= " and operacao = 'C'";
                $sql .= ' and idt_aditivo_participante is null';
                $rs = execsql($sql, false);
                $vl_pago = $rs->data[0][0];

                if ($vl_pago == '') {
                    $vl_pago = 0;
                }

                if ($_POST['veio'] == 'SG') {
                    $sql = '';
                    $sql .= ' select vl_tot_pagamento';
                    $sql .= ' from grc_evento_participante';
                    $sql .= ' where idt_atendimento = ' . null($_POST['id']);
                    $rs = execsql($sql, false);
                    $vl_evento = $rs->data[0][0];

                    if ($vl_evento == '') {
                        $vl_evento = 0;
                    }

                    $tot = 1;

                    if ($rowDados['sgtec_modelo'] == 'E' && $rowDados['vl_determinado'] == 'S') {
                        if ($rowDados['nao_sincroniza_rm'] == 'S') {
                            $validaPAG = false;
                        }
                    } else {
                        if ($rowDados['idt_evento_situacao'] < 8 || $rowDados['nao_sincroniza_rm'] == 'S') {
                            $validaPAG = false;
                        }
                    }
                } else {
                    $vl_evento = desformat_decimal($_POST['valor_inscricao']);

                    if ($_POST['composto'] == 'S') {
                        $tot++;
                    } else {
                        $sql = '';
                        $sql .= ' select count(idt) as tot';
                        $sql .= ' from grc_atendimento_pessoa';
                        $sql .= ' where idt_atendimento = ' . null($_POST['id']);
                        $sql .= ' and idt <> ' . null($_POST['idt_lider']);
                        $sql .= " and ifnull(evento_cortesia, 'N') <> 'S'";
                        $rs = execsql($sql, false);
                        $tot = $rs->data[0][0];

                        if ($_POST['evento_cortesia'] == 'N') {
                            $tot++;
                        }
                    }
                }

                $vl_apagar = $vl_evento * $tot;

                if ($vl_apagar != $vl_pago && $validaPAG) {
                    $vet['erro'] = rawurlencode('O valor total de pagamento (R$ ' . format_decimal($vl_pago) . ') esta diferente do total da inscrição (R$ ' . format_decimal($vl_apagar) . ')!');
                }
            }

            //Tem que ter pagamento
            if ($vet['erro'] == '' && $_POST['veio'] == 'SG' && $rowDados['sgtec_modelo'] == 'E' && $rowDados['vl_determinado'] == 'S') {
                $sql = '';
                $sql .= ' select sum(ea.vl_total) as tot';
                $sql .= ' from grc_evento_dimensionamento ea';
                $sql .= ' where ea.idt_atendimento = ' . null($_POST['id']);
                $rs = execsql($sql, false);

                if ($rs->data[0][0] <= 0) {
                    $vet['erro'] = rawurlencode('O valor do Dimensionamento da Demanda não pode ser zero!');
                } else {
                    $sql = '';
                    $sql .= ' select vl_teto';
                    $sql .= ' from grc_produto';
                    $sql .= ' where idt = ' . null($rowDados['idt_produto']);
                    $rsp = execsql($sql, false);
                    $rowp = $rsp->data[0];

                    if ($rowp['vl_teto'] == '') {
                        $rowp['vl_teto'] = 0;
                    }

                    if ($rs->data[0][0] > $rowp['vl_teto']) {
                        $vet['erro'] = rawurlencode('O valor do Dimensionamento da Demanda não pode ser maior que o Valor Teto da Solução!');
                    }
                }
            }

            //Valida as Entregas
            if ($vet['erro'] == '' && $_POST['veio'] == 'SG' && $rowDados['sgtec_modelo'] == 'E') {
                $sql = '';
                $sql .= ' select sum(ea.percentual) as tot';
                $sql .= ' from grc_evento_entrega ea';
                $sql .= ' where ea.idt_atendimento = ' . null($_POST['id']);
                $rs = execsql($sql, false);

                if ($rs->data[0][0] != 100) {
                    $vet['erro'] = rawurlencode('O Percentual da distribuição das Entregas não é 100%!');
                }
            }

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_participante_pagamento';
            $sql .= ' where idt_atendimento = ' . null($_POST['id']);
            $sql .= " and estornado <> 'S'";
            $sql .= " and operacao = 'C'";
            $sql .= ' and idt_aditivo_participante is null';
            $rs = execsql($sql, false);

            if ($rs->rows > 0 && $_POST['veio'] == 'SG' && $rowDados['sgtec_modelo'] == 'E' && $rowDados['vl_determinado'] == 'S') {
                //Valida o Dimensionamento da Demanda
                if ($vet['erro'] == '') {
                    $sql = '';
                    $sql .= ' select ea.idt';
                    $sql .= ' from grc_evento_dimensionamento ea';
                    $sql .= ' where ea.idt_atendimento = ' . null($_POST['id']);
                    $rs = execsql($sql, false);

                    if ($rs->rows == 0) {
                        $vet['erro'] = rawurlencode('Favor informar o Dimensionamento da Demanda!');
                    }
                }

                //Verifica se informou as contas de devolução
                if ($vet['erro'] == '') {
                    if ($_POST['evento_contrato'] == 'A') {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_evento_participante_contadevolucao';
                        $sql .= ' where idt_atendimento = ' . null($_POST['id']);
                        $sql .= ' and cpfcnpj is null';
                        $sql .= " and reg_origem = 'MA'";
                        $rs = execsql($sql, false);

                        if ($rs->rows > 0) {
                            $vet['erro'] = rawurlencode('Favor informar a conta dos registros de Dados da Devolução!');
                        }
                    }
                }
            }

            //Valida se a qtd de pessoa é a mesma de assentos marcados
            if ($vet['erro'] == '') {
                if ($_POST['assento_marcado'] == 'S' && $_POST['situacao_contrato'] == 'R') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_atendimento_pessoa';
                    $sql .= ' where idt_atendimento = ' . null($_POST['id']);
                    $rs = execsql($sql, false);
                    $qtd_pessoa = $rs->rows;

                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento_mapa_assento';
                    $sql .= ' where idt_matricula_utilizado = ' . null($_POST['id']);
                    $rs = execsql($sql, false);
                    $qtd_marcado = $rs->rows;

                    if ($qtd_marcado != $qtd_pessoa) {
                        $vet['erro'] = rawurlencode("Favor selecionados " . $qtd_pessoa . " lugares para os pessoas desta matricula!\n\nQuantidade selecionada: " . $qtd_marcado);
                    }
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'conParticipanteEventoSiacWeb':
        $qtd_incluido = 0;
        $msg = conParticipanteEventoSiacWeb($_POST['idt'], $qtd_incluido);
        echo rawurlencode($msg);
        break;

    case 'ConsolidarEventoValida':
        $continua = true;

        $sql = '';
        $sql .= ' select tipo_sincroniza_siacweb, nao_sincroniza_rm, cred_necessita_credenciado';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($_POST['idt']);
        $rs = execsql($sql);
        $rowe = $rs->data[0];

        $sql = '';
        $sql .= ' select ep.idt';
        $sql .= ' from grc_evento_participante ep';
        $sql .= ' inner join grc_atendimento a on a.idt = ep.idt_atendimento';
        $sql .= ' where a.idt_evento = ' . null($_POST['idt']);
        $sql .= " and (ep.contrato is null or ep.contrato in ('R', 'A'))";
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $continua = false;
            echo rawurlencode("Ainda existem clientes com inscrições em Rascunho, Em Assinatura ou Aguardando Matrícula.\nÉ necessário remover os clientes nesta situação ou confirmar suas inscrições");
        }

        if ($continua) {
            $sql = '';
            $sql .= ' select a.idt';
            $sql .= ' from grc_atendimento a';
            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt";
            $sql .= ' where a.idt_evento = ' . null($_POST['idt']);
            $sql .= whereEventoParticipante();
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $continua = false;
                echo rawurlencode('Não pode continuar, pois o evento não tem Participante informado!');
            }
        }

        if ($continua && $_POST['idt_instrumento'] == 2 && $rowe['tipo_sincroniza_siacweb'] == 'P') {
            if ($rowe['cred_necessita_credenciado'] == 'N' || $rowe['nao_sincroniza_rm'] == 'S') {
                $campo_consolidado = 'consolidado_cred';
                $msg_consolidado = 'Ainda existem atividades que não tiveram a prestação de contas aprovada!';
            } else {
                $campo_consolidado = 'consolidado_siacweb';
                $msg_consolidado = 'Ainda existem atividades que não tiveram a prestação de contas aprovada no SiacWEB!';
            }

            $sql = '';
            $sql .= ' select ea.idt';
            $sql .= ' from grc_evento_atividade ea';
            $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
            $sql .= ' where ea.idt_evento = ' . null($_POST['idt']);
            $sql .= whereEventoParticipante();
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $sql .= " and ea.{$campo_consolidado} = 'N'";
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $continua = false;
                echo rawurlencode($msg_consolidado);
            } else {
                $sql = '';
                $sql .= ' select max(ea.dt_fim) as fim';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ea';
                $sql .= " left outer join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                $sql .= ' where ea.idt_evento = ' . null($_POST['idt']);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs = execsql($sql);
                $fim_ativ = trata_data($rs->data[0][0]);
                $hoje = getdata(true, true);

                if (diffDate($hoje, $fim_ativ) > 0) {
                    $continua = false;
                    echo rawurlencode('Não pode consolidar este evento, pois tem atividades que estão sendo executadas!');
                }
            }
        }

        if ($continua) {
            $qtd_incluido = 0;
            $msg = conParticipanteEventoSiacWeb($_POST['idt'], $qtd_incluido);

            if ($msg == '') {
                if ($qtd_incluido > 0) {
                    $continua = false;
                    echo rawurlencode('Tem novas inscrições feitas pelo SIACWEB. Favor revisar o campo de CONCLUINTE!');
                }
            } else {
                $continua = false;
                echo rawurlencode($msg);
            }
        }
        break;

    case 'grc_evento_cred_cod_evento':
        $vet = Array(
            'idt' => '',
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento';
            $sql .= ' where idt <> ' . null($_POST['idt_evento']);
            $sql .= ' and codigo = ' . aspa($_POST['cred_cod_evento']);
            $rs = execsql($sql, false);
            $vet['idt'] = $rs->data[0][0];
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'html_resumo_evento_receita_despesa':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $vet['html'] = rawurlencode(html_resumo_evento_receita_despesa($_POST['idt_evento']));
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_insumo_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select codigo';
            $sql .= ' from grc_evento_insumo';
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $codigo = $rs->data[0][0];

            switch ($codigo) {
                case '70002':
                case '70003':
                    $sql = '';
                    $sql .= ' select count(distinct ea.data_inicial) as dias';
                    $sql .= ' from grc_evento_agenda ea';
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                    $sql .= ' where ea.idt_evento = ' . null($_POST['idt_evento']);
                    $sql .= whereEventoParticipante();
                    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                    $rs = execsql($sql, false);
                    $dias = $rs->data[0][0];

                    if ($dias == '') {
                        $dias = 0;
                    }

                    if (desformat_decimal($_POST['quantidade']) > $dias) {
                        $sql = '';
                        $sql .= ' select p.tipo_calculo';
                        $sql .= ' from grc_evento e';
                        $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
                        $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
                        $rsa = execsql($sql, false);

                        if ($rsa->data[0][0] != 'P') {
                            $vet['erro'] = rawurlencode('A Quantidade não pode ser maior que ' . $dias . '!');
                        }
                    }
                    break;
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_entidade_pessoa_tema_interesse_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_entidade_pessoa_tema_interesse';
            $sql .= ' where idt <> ' . null($_POST['idt']);
            $sql .= ' and idt_entidade_pessoa = ' . null($_POST['idt_entidade_pessoa']);
            $sql .= ' and idt_tema = ' . null($_POST['idt_tema']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vet['erro'] = rawurlencode('Tema já cadastrado!');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'TipoProgramaGECProdutos':
        $vet = Array(
            'erro' => '',
            'tipo_atu' => '',
            'tipo_ant' => '',
            'prod_composto_atu' => 'N',
            'prod_composto_ant' => 'N',
        );

        try {
            $sql = '';
            $sql .= ' select gec_prog.tipo_ordem, grc_p.idt_produto_especie';
            $sql .= ' from grc_produto grc_p';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_p.idt_programa';
            $sql .= ' where grc_p.idt = ' . null($_POST['idt_produto_atu']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];
            $vet['tipo_atu'] = $row['tipo_ordem'];

            if ($row['idt_produto_especie'] == 3) {
                $vet['prod_composto_atu'] = 'S';
            }

            $sql = '';
            $sql .= ' select gec_prog.tipo_ordem, grc_p.idt_produto_especie';
            $sql .= ' from grc_produto grc_p';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_p.idt_programa';
            $sql .= ' where grc_p.idt = ' . null($_POST['idt_produto_ant']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];
            $vet['tipo_ant'] = $row['tipo_ordem'];

            if ($row['idt_produto_especie'] == 3) {
                $vet['prod_composto_ant'] = 'S';
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'alt_qtd_vagas_adicional':
        $vet = Array(
            'erro' => '',
        );

        try {
            if ($_POST['qtd_vagas_adicional'] == '') {
                $qtd = $_POST['quantidade_participante'];
            } else {
                $qtd = $_POST['quantidade_participante'] + $_POST['qtd_vagas_adicional'];
            }

            $sql = '';
            $sql .= ' select qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas - qtd_vagas_extra as tot';
            $sql .= ' from grc_evento';
            $sql .= " where idt = " . null($_POST['idt_evento']);
            $rsVaga = execsql($sql, false);
            $rowVaga = $rsVaga->data[0];

            if ($rowVaga['tot'] > $qtd) {
                if ($_POST['qtd_vagas_adicional'] == '') {
                    $vet['erro'] = rawurlencode('A Qtde. Participantes não pode ser menor que ' . $rowVaga['tot'] . '!');
                } else {
                    $atual = $rowVaga['tot'] - $_POST['quantidade_participante'];
                    $vet['erro'] = rawurlencode('A Qtde. adicional de Participantes não pode ser menor que ' . $atual . ', pois já tem ' . $rowVaga['tot'] . ' inscrições!');
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_habilitado_fe':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();
            beginTransaction();

            if (is_array($_POST['idts'])) {
                //Valida se tem Vagas disponivel
                $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + " . count($_POST['idts']);
                $sql .= " where idt = " . null($_POST['idt_evento']);
                execsql($sql, false);

                $sql = '';
                $sql .= ' select quantidade_participante + qtd_vagas_adicional as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                $sql .= ' from grc_evento';
                $sql .= " where idt = " . null($_POST['idt_evento']);
                $rsVaga = execsql($sql, false);
                $rowVaga = $rsVaga->data[0];

                if ($rowVaga['tot'] > $rowVaga['qtd']) {
                    $vetErroMsg[] = 'Não tem mais vaga disponível no Evento, para está quantidade de registros selecionados!';
                } else {
                    $fe_dt_validade = trata_data(date('d/m/Y H:i:s', strtotime('+' . $vetConf['evento_fe_prazo_habilitado'] . ' hours')), true);

                    $sql = 'update grc_evento_participante ep';
                    $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = ep.idt_atendimento';
                    $sql .= " set ep.fe_situacao = 'AM',";
                    $sql .= ' ep.contrato = null,';
                    $sql .= ' ep.fe_dt_validade = ' . aspa($fe_dt_validade);
                    $sql .= ' where p.idt in (' . implode(', ', $_POST['idts']) . ')';
                    execsql($sql, false);

                    $sql = 'insert into grc_evento_participante_fe_log (idt_evento, idt_atendimento, usuario_nome, usuario_login, situacao, dt_validade)';
                    $sql .= " select distinct " . $_POST['idt_evento'] . " as idt_evento, idt_atendimento,";
                    $sql .= "'" . $_SESSION[CS]['g_nome_completo'] . "' as usuario_nome, '" . $_SESSION[CS]['g_login'] . "' as usuario_login,";
                    $sql .= "'AM' as situacao, '" . $fe_dt_validade . "' as dt_validade";
                    $sql .= ' from grc_atendimento_pessoa';
                    $sql .= ' where idt in (' . implode(', ', $_POST['idts']) . ')';
                    execsql($sql, false);
                }
            }

            if (count($vetErroMsg) == 0) {
                commit();
            } else {
                rollBack();
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_publicacao_exc_temp':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql_a = 'delete from grc_evento_publicacao';
            $sql_a .= ' where idt = ' . null($_POST['idt']);
            $sql_a .= " and temporario = 'S'";
            execsql($sql_a);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'calculaValorDistratoDevolucao':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();
            calculaValorDistratoDevolucao($_POST['idt_distrato'], $_POST['valor_total'], false);
            commit();
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'gec_contratar_credenciado_distrato_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            //Verifica se informou as contas de devolução
            if ($vet['erro'] == '') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_participante_contadevolucao';
                $sql .= ' where idt_contratar_credenciado_distrato = ' . null($_POST['id']);
                $sql .= ' and cpfcnpj is null';
                $rs = execsql($sql, false);

                if ($rs->rows > 0) {
                    $vet['erro'] = rawurlencode('Favor informar a conta dos registros do Resumo do Distrato com o Cliente!');
                }
            }
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'calculaValorAditivoParticipante':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();
            calculaValorAditivoParticipante($_POST['idt_aditivo'], desformat_decimal($_POST['valor_aditivo']), false);
            commit();
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'gec_contratar_credenciado_aditivo_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();
            $msg = gec_contratar_credenciado_aditivo_dep($_POST['idt_aditivo']);
            commit();

            $vet['erro'] = rawurlencode($msg);
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'gec_contratar_credenciado_aditivo_participante_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            beginTransaction();
            $msg = gec_contratar_credenciado_aditivo_dep($_POST['idt_aditivo'], $_POST['idt_aditivo_participante']);
            commit();

            $vet['erro'] = rawurlencode($msg);
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_contratar_credenciado_modelo':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_item (idt_contratar_credenciado, ordem, descricao, detalhe, html_header, html_footer, inc_salvar_pdf, upload_ass)';
            $sql .= ' select ' . $_POST['idt_contratar_credenciado'] . ' as idt_contratar_credenciado, ordem, descricao, detalhe, html_header, html_footer, inc_salvar_pdf, upload_ass';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_modelo_item';
            $sql .= ' where idt_contratar_modelo = ' . null($_POST['idt_contratar_modelo']);
            execsql($sql, false);
        } catch (Exception $e) {
            $vet['erro'] = rawurlencode($e->getMessage());
        }

        echo json_encode($vet);
        break;

    case 'nan_pa_consultor':
        $sql = '';
        $sql .= ' select distinct u.id_usuario, u.nome_completo';
        $sql .= ' from grc_nan_estrutura e';
        $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
        $sql .= ' where e.idt_ponto_atendimento = ' . null($_GET['val']);
        $sql .= ' order by u.nome_completo';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_pf_pj_rep':
        $sql = '';
        $sql .= " select ef.idt, ef.codigo, ef.descricao, group_concat(distinct er.descricao separator ', ') as tipo";
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade ef on ef.idt = ee.idt_entidade_relacionada';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
        $sql .= ' where ee.idt_entidade = ' . null($_GET['val']);
        $sql .= " and ee.ativo = 'S'";
        $sql .= ' and ee.idt_entidade_relacao = 8';
        $sql .= " and ef.tipo_entidade = 'P'";
        $sql .= " and ef.reg_situacao = 'A'";
        $sql .= " and ef.ativo = 'S'";
        $sql .= " and (";

        //Credenciado
        $sql .= ' (';
        $sql .= " ef.credenciado_nan = 'S'";
        $sql .= " and ef.credenciado = 'S'";
        $sql .= " and ef.nan_ano = " . aspa(nan_ano);
        $sql .= ' )';

        //Não Credenciado
        $sql .= " or ef.credenciado = 'N'";

        $sql .= " )";

        $sql .= ' group by ef.idt, ef.codigo, ef.descricao';
        $sql .= ' order by ef.descricao';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_pf_pj_usuario':
        $sql = '';
        $sql .= " select uf.id_usuario, ef.codigo, ef.descricao, group_concat(distinct er.descricao separator ', ') as tipo";
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade ef on ef.idt = ee.idt_entidade_relacionada';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
        $sql .= ' inner join plu_usuario uf on uf.login = ef.codigo';
        $sql .= ' where ee.idt_entidade = ' . null($_GET['val']);
        $sql .= " and ee.ativo = 'S'";
        $sql .= ' and ee.idt_entidade_relacao = 8';
        $sql .= " and ef.tipo_entidade = 'P'";
        $sql .= " and ef.reg_situacao = 'A'";
        $sql .= " and ef.ativo = 'S'";
        $sql .= " and ef.credenciado_nan = 'S'";
        $sql .= " and ef.credenciado = 'S'";
        $sql .= " and ef.nan_ano = " . aspa(nan_ano);
        $sql .= ' group by uf.id_usuario, ef.codigo, ef.descricao';
        $sql .= ' order by ef.descricao';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'grc_nan_estrutura_fecha':
        $vet = Array(
            'tot' => -1,
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_nan_estrutura';
            $sql .= ' where idt_contrato = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $vet['tot'] = $rs->rows;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_nan_estrutura_arvore_fecha':
        $vet = Array(
            'tot' => -1,
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_nan_estrutura';
            $sql .= ' where idt_acao = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $vet['tot'] = $rs->rows;
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_nan_estrutura_contrato':
        $vet = Array(
            'idt_ponto_atendimento' => '',
            'idt_empresa_executora' => '',
            'idt_ponto_atendimento_desc' => '',
            'idt_empresa_executora_desc' => '',
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select cc.idt_organizacao, e.codigo, e.descricao, cc.nan_idt_unidade_regional, pa.descricao as pa_desc';
            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado cc';
            $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao pa on pa.idt = cc.nan_idt_unidade_regional';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade e on e.idt = cc.idt_organizacao';
            $sql .= ' where cc.idt = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['idt_ponto_atendimento'] = rawurlencode($row['nan_idt_unidade_regional']);
            $vet['idt_ponto_atendimento_desc'] = rawurlencode($row['pa_desc']);
            $vet['idt_empresa_executora'] = rawurlencode($row['idt_organizacao']);
            $vet['idt_empresa_executora_desc'] = rawurlencode($row['codigo'] . ' - ' . $row['descricao']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nan_acao_pa':
        $sql = "select ";
        $sql .= " grc_pa.idt, grc_p.descricao, grc_pa.descricao ";
        $sql .= " from grc_projeto_acao grc_pa ";
        $sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto';
        $sql .= " where nan_idt_unidade_regional =  " . null($_GET['val']);
        $sql .= " and grc_pa.nan =  " . aspa('S');
        $sql .= " order by grc_p.descricao, grc_pa.descricao";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_tutor_acao':
        $sql = "select grc_ne.idt,  ";
        $sql .= " plu_usu.nome_completo as plu_usu_nome_completo  ";
        $sql .= " from grc_nan_estrutura grc_ne ";
        $sql .= " inner join grc_nan_estrutura_tipo grc_net on grc_net.idt  = grc_ne.idt_nan_tipo ";
        $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
        $sql .= " where grc_ne.idt_acao = " . null($_GET['val']);
        $sql .= " and   grc_net.codigo = " . aspa('05');
        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_tipo_tutor':
        switch ($_GET['val']) {
            case 9:
                $idt_nan_tipo = 8;
                break;

            case 2:
                $idt_nan_tipo = 9;
                break;

            case 4:
                $idt_nan_tipo = 2;
                break;

            default:
                $idt_nan_tipo = 0;
                break;
        }

        $sql = "select grc_ne.idt, plu_usu.nome_completo";
        $sql .= " from grc_nan_estrutura grc_ne ";
        $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = grc_ne.idt_usuario";
        $sql .= " where grc_ne.idt_nan_tipo = " . null($idt_nan_tipo);
        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_tipo_tutor_pa':
        switch ($_GET['val']) {
            case 10:
                $idt_nan_tipo = 4;
                break;

            case 3:
                $idt_nan_tipo = 10;
                break;

            case 5:
                $idt_nan_tipo = 3;
                break;

            default:
                $idt_nan_tipo = 0;
                break;
        }

        $sql = "select grc_ne.idt, plu_usu.nome_completo as plu_usu_nome_completo  ";
        $sql .= " from grc_nan_estrutura grc_ne ";
        $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario      = grc_ne.idt_usuario ";
        $sql .= " where grc_ne.idt_nan_tipo = " . null($idt_nan_tipo);

        if ($_GET['val'] != 10) {
            $sql .= " and grc_ne.idt_ponto_atendimento = " . null($_GET['idt_pa']);
        }

        $sql .= " order by plu_usu.nome_completo";
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_registro_pa':
        $sql = '';
        $sql .= ' select distinct u.id_usuario, u.nome_completo';
        $sql .= ' from grc_nan_estrutura e';
        $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
        $sql .= ' where e.idt_nan_tipo = ' . null($_GET['nan_tipo']);

        if ($_GET['val'] != "" && $_GET['val'] != "0" && $_GET['val'] != "-1") {
            $sql .= ' and e.idt_ponto_atendimento = ' . null($_GET['val']);
        }

        $sql .= ' order by u.nome_completo';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'nan_registro_tutor':
        $sql = '';
        $sql .= ' select distinct u.id_usuario, u.nome_completo';
        $sql .= ' from grc_nan_estrutura e';
        $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_usuario';
        $sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
        $sql .= ' where e.idt_nan_tipo = ' . null($_GET['nan_tipo']);
        $sql .= ' and et.idt_usuario = ' . null($_GET['val']);
        $sql .= ' order by u.nome_completo';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'LatitudeLongitude':
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $_SESSION[CS]['latitude'] = $latitude;
        $_SESSION[CS]['longitude'] = $longitude;
        break;

    case 'dados_contrato':
        $vet = Array(
            'erro' => '',
            'cnpj' => '',
            'empresa' => '',
            'unidade' => '',
        );

        try {
            $sql = '';
            $sql .= ' select gec_e.codigo as gec_e_cnpj, gec_e.descricao as gec_e_executora, sca_nan.descricao as sca_nan_ur';
            $sql .= ' from ' . db_pir_gec . "gec_contratar_credenciado gec_cc";
            $sql .= " inner join " . db_pir_gec . "gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
            $sql .= " inner join " . db_pir . "sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";
            $sql .= ' where gec_cc.idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];

            $vet['cnpj'] = rawurlencode($row['gec_e_cnpj']);
            $vet['empresa'] = rawurlencode($row['gec_e_executora']);
            $vet['unidade'] = rawurlencode($row['sca_nan_ur']);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;



    case 'AC_SERV':
        $to_vivo = $_POST['to_vivo'];
        $vetRetorno = Array(
            'perdeu_session' => '',
            'registrar' => '',
            'mensagem' => '',
        );
        $msg = "";
        $id_session = session_id();
        if ($_SESSION[CS]['g_id_usuario'] != "" and $id_session != "") {

            $_SESSION[CS]['g_msg_id_usuario'] = '';
            if ($_SESSION[CS]['g_msg_id_usuario'] != "") {
                $vetRetorno['mensagem'] = $_SESSION[CS]['g_msg_id_usuario'];
            }

            try {
                // grava log

                $tabela = "plu_usuario";
                $id_lo = $_SESSION[CS]['g_id_usuario'];
                $desc_log = "ATIVO - " . $_SESSION[CS]['g_login'] . ' >>> ' . $_SESSION[CS]['g_nome_completo'];
                // $desc_log   .= "<br />".$id_session;
                // $desc_log   .= "<br />".CS;
                $nom_tabela = "SESSION GC GRC";
                grava_log_sis($tabela, 'V', $id_lo, $desc_log, $nom_tabela);
            } catch (PDOException $e) {
                $msg = grava_erro_log($tipodb, $e, $sql);
                $vetRetorno['registrar'] = rawurlencode($msg);
            } catch (Exception $e) {
                $msg = grava_erro_log('php', $e, '');
                $vetRetorno['registrar'] = rawurlencode($msg);
            }
        } else {
            $msg = 'Anônimo';
            $vetRetorno['perdeu_session'] = rawurlencode($msg);
        }
        echo json_encode($vetRetorno);
        break;
    //
    // NAN 2 VISITA
    //
		/*
      case 'DevolutivaPDF':
      $idt_avaliacao = $_POST['idt_avaliacao'];
      $vetRetorno = Array(
      'erro' => '',
      );
      DevolutivaPDF($idt_avaliacao);
      echo json_encode($vetRetorno);
      break;
     */

    case 'DevolutivaPDF':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        //p($_POST);
        //echo $idt_avaliacao;
        $vetRetorno = Array(
            'erro' => '',
        );
        $include = 'pdf_devolutiva.php';
        if (file_exists($include)) {
            Require_Once($include);
        }
        echo json_encode($vetRetorno);
        break;

    case 'PlanoFacilPDF':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        //p($_POST);
        //echo $idt_avaliacao;
        $vetRetorno = Array(
            'erro' => '',
        );
        $include = 'pdf_plano_facil.php';
        if (file_exists($include)) {
            Require_Once($include);
        }
        echo json_encode($vetRetorno);
        break;


    case 'ProtocoloPDF':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        //p($_POST);
        //echo $idt_avaliacao;
        $vetRetorno = Array(
            'erro' => '',
        );
        $include = 'pdf_protocolo2visita.php';
        if (file_exists($include)) {
            Require_Once($include);
        }
        echo json_encode($vetRetorno);
        break;


    case 'PlanoFacilRegerarPDF':
        $idt_avaliacao = $_POST['idt_avaliacao'];

        $sql = "select ";
        $sql .= "   grc_at.idt_grupo_atendimento, grc_nga.pdf_devolutiva, grc_nga.pdf_plano_facil, grc_nga.pdf_protocolo";
        $sql .= " from  grc_avaliacao grc_a ";
        $sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
        $sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
        $sql .= " where grc_a.idt  =  " . null($idt_avaliacao);
        $rsGA = execsql($sql);
        $rowGA = $rsGA->data[0];

        $exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
        $exportPath .= DIRECTORY_SEPARATOR . $dir_file;
        $exportPath .= DIRECTORY_SEPARATOR . 'grc_nan_grupo_atendimento';
        $exportPath .= DIRECTORY_SEPARATOR;
        $exportPath = str_replace('\\', '/', $exportPath);

        if ($rowGA['pdf_devolutiva'] != '') {
            $arq = $exportPath . $rowGA['pdf_devolutiva'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        if ($rowGA['pdf_plano_facil'] != '') {
            $arq = $exportPath . $rowGA['pdf_plano_facil'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        if ($rowGA['pdf_protocolo'] != '') {
            $arq = $exportPath . $rowGA['pdf_protocolo'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        $sql = 'update grc_nan_grupo_atendimento SET pdf_devolutiva=NULL, pdf_plano_facil=NULL, pdf_protocolo=NULL WHERE idt = ' . null($rowGA['idt_grupo_atendimento']);
        execsql($sql);
        break;

    case 'InicializaSegundaVisita':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        $vetRetorno = Array(
            'erro' => ''
        );

        $vetErroMsg = Array();
        IniciarSegundaVisita($idt_avaliacao, $vetErroMsg);

        $sql = "select ";
        $sql .= "   grc_at.idt_grupo_atendimento, grc_nga.pdf_devolutiva, grc_nga.pdf_plano_facil, grc_nga.pdf_protocolo";
        $sql .= " from  grc_avaliacao grc_a ";
        $sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
        $sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
        $sql .= " where grc_a.idt  =  " . null($idt_avaliacao);
        $rsGA = execsql($sql);
        $rowGA = $rsGA->data[0];

        $exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
        $exportPath .= DIRECTORY_SEPARATOR . $dir_file;
        $exportPath .= DIRECTORY_SEPARATOR . 'grc_nan_grupo_atendimento';
        $exportPath .= DIRECTORY_SEPARATOR;
        $exportPath = str_replace('\\', '/', $exportPath);

        if ($rowGA['pdf_devolutiva'] != '') {
            $arq = $exportPath . $rowGA['pdf_devolutiva'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        if ($rowGA['pdf_plano_facil'] != '') {
            $arq = $exportPath . $rowGA['pdf_plano_facil'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        if ($rowGA['pdf_protocolo'] != '') {
            $arq = $exportPath . $rowGA['pdf_protocolo'];
            if (file_exists($arq)) {
                unlink($arq);
            }
        }

        $sql = 'update grc_nan_grupo_atendimento SET pdf_devolutiva=NULL, pdf_plano_facil=NULL, pdf_protocolo=NULL WHERE idt = ' . null($rowGA['idt_grupo_atendimento']);
        execsql($sql);

        define('_MPDF_PATH', lib_mpdf);
        include(lib_mpdf . 'mpdf.php');

        if ($vetRetorno['erro'] != '') {
            $vetErroMsg[] = $vetRetorno['erro'];
        }

        Require_Once('pdf_devolutiva.php');

        if ($vetRetorno['erro'] != '') {
            $vetErroMsg[] = $vetRetorno['erro'];
        }

        Require_Once('pdf_plano_facil.php');

        if ($vetRetorno['erro'] != '') {
            $vetErroMsg[] = $vetRetorno['erro'];
        }

        Require_Once('pdf_protocolo2visita.php');

        if ($vetRetorno['erro'] != '') {
            $vetErroMsg[] = $vetRetorno['erro'];
        }

        if (count($vetErroMsg) > 0) {
            $vetRetorno['erro'] = implode("\n", $vetErroMsg);
        }

        $vetRetorno['erro'] = rawurlencode($vetRetorno['erro']);

        echo json_encode($vetRetorno);
        break;

    case 'limpaArqDevolutiva':
        $exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
        $exportPath .= DIRECTORY_SEPARATOR . $dir_file;
        $exportPath .= DIRECTORY_SEPARATOR . 'grc_nan_grupo_atendimento';
        $exportPath .= DIRECTORY_SEPARATOR;
        $exportPath .= $_POST['id'];
        $exportPath = str_replace('\\', '/', $exportPath);

        $arq = $exportPath . '_grafico1.png';
        if (file_exists($arq)) {
            unlink($arq);
        }

        $arq = $exportPath . '_grafico2.png';
        if (file_exists($arq)) {
            unlink($arq);
        }
        break;

    case 'limpaArqDevolutivac':
        $exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
        $exportPath .= DIRECTORY_SEPARATOR . $dir_file;
        $exportPath .= DIRECTORY_SEPARATOR . 'grc_nan_grupo_atendimento';
        $exportPath .= DIRECTORY_SEPARATOR;
        $exportPath .= $_POST['id'];
        $exportPath = str_replace('\\', '/', $exportPath);

        $arq = $exportPath . '_grafico1c.png';
        if (file_exists($arq)) {
            unlink($arq);
        }

        $arq = $exportPath . '_grafico2c.png';
        if (file_exists($arq)) {
            unlink($arq);
        }
        break;

    case 'SincronizaProfissional':
        beginTransaction();

        $sql = 'update grc_produto set insumo_horas_comp = ' . aspa($_POST['valor']);
        $sql .= ' where idt = ' . null($_POST['idt']);
        execsql($sql, false);

        grava_log_sis('grc_produto', 'R', $_POST['idt'], 'Produto possui Horas Complementares: ' . $vetSimNao[$_POST['valor']]);

        $sql = '';
        $sql .= ' select idt, idt_profissional';
        $sql .= ' from grc_produto_profissional';
        $sql .= ' where idt_produto = ' . null($_POST['idt']);
        $rs = execsql($sql, false);

        foreach ($rs->data as $row) {
            SincronizaProfissional($row['idt'], $_POST['idt'], $row['idt_profissional']);
        }

        CalcularInsumoProduto($_POST['idt']);

        commit();
        break;

    case 'grc_entidade_ajuste_cad_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select ' . $_POST['campo'] . ' as vl';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_organizacao o';
            $sql .= ' where idt_entidade = ' . null($_POST['idt_entidade']);
            $rs = execsql($sql, false);

            if ($rs->data[0][0] != $_POST['valor']) {
                $sql = '';
                $sql .= ' select e.idt, e.descricao';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade_organizacao o';
                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = o.idt_entidade';
                $sql .= " where e.idt_entidade_tipo_emp = 7";
                $sql .= " and e.reg_situacao = 'A'";
                $sql .= ' and e.idt <> ' . null($_POST['idt_entidade']);
                $sql .= ' and ' . $_POST['campo'] . ' = ' . aspa($_POST['valor']);
                $rs = execsql($sql, false);

                if ($rs->rows > 0) {
                    $vetDesc = Array(
                        'dap' => 'DAP',
                        'nirf' => 'NIRF',
                        'rmp' => 'Registro Ministério da Pesca',
                        'ie_prod_rural' => 'IE',
                    );

                    $msg = 'O ' . $vetDesc[$_POST['campo']] . ' informado esta sendo utilizado nos seguintes registros:';
                    $msg .= "\n";

                    foreach ($rs->data as $row) {
                        $msg .= "\n";
                        $msg .= $row['descricao'] . ' (' . $row['idt'] . ')';
                    }

                    $vet['erro'] = rawurlencode($msg);
                }
            }
        } catch (Exception $e) {
            $vet['erro'] = rawurlencode('O Sistema encontrou problemas: ' . $e->getMessage());
        }

        echo json_encode($vet);
        break;

    case 'grc_entidade_ajuste_acao':
        $vet = Array(
            'erro' => '',
        );

        try {
            $conSIAC = conSIAC();

            //Unico
            $vetCampo = Array('dap', 'nirf', 'rmp', 'ie_prod_rural');

            foreach ($vetCampo as $campo) {
                set_time_limit(0);

                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_entidade_ajuste';
                $sql .= ' where ' . $campo . ' in (';
                $sql .= ' select ' . $campo . '';
                $sql .= ' from grc_entidade_ajuste';
                $sql .= ' where ' . $campo . ' is not null';
                $sql .= ' group by ' . $campo . '';
                $sql .= ' having count(idt) > 1';
                $sql .= ' )';
                $rs = execsql($sql, false);

                $vetDados = Array();

                foreach ($rs->data as $row) {
                    $vetDados[$row[$campo]]['row'][] = $row;
                    $vetDados[$row[$campo]]['codparceiro_siac'][$row['codparceiro_siac']] = $row;
                }

                foreach ($vetDados as $vetRow) {
                    set_time_limit(0);

                    beginTransaction();

                    $vetSiac = $vetRow['codparceiro_siac'];
                    $vetEX = Array();
                    $vetEXtodos = Array();
                    $idt_entidade_maior = 0;
                    $idt_entidade_a = 0;

                    if (count($vetSiac) == 1) {
                        $executa = true;
                        $siac = array_shift($vetSiac);

                        foreach ($vetRow['row'] as $row) {
                            if (remover_acento($row['descricao']) != remover_acento($siac['descricao'])) {
                                $executa = false;
                            }
                        }

                        if ($executa) {
                            foreach ($vetRow['row'] as $row) {
                                if ($row['idt_entidade'] > $idt_entidade_maior) {
                                    $idt_entidade_maior = $row['idt_entidade'];
                                }

                                $vetEXtodos[$row['idt_entidade']] = $row['idt_entidade'];

                                if ($row['codparceiro_gec'] == $siac['codparceiro_siac']) {
                                    if ($row['idt_entidade'] > $idt_entidade_a) {
                                        $idt_entidade_a = $row['idt_entidade'];
                                    } else {
                                        $vetEX[$row['idt_entidade']] = $row['idt_entidade'];
                                    }
                                } else {
                                    $vetEX[$row['idt_entidade']] = $row['idt_entidade'];
                                    grc_entidade_ajuste_updateCodSiacweb($row['codparceiro_gec'], $siac['codparceiro_siac']);
                                }
                            }

                            if (count($vetEX) == 0) {
                                $vetEX = $vetEXtodos;
                                $idt_entidade_a = $idt_entidade_maior;
                                unset($vetEX[$idt_entidade_maior]);
                            } else if (count($vetRow['row']) == count($vetEX) || $idt_entidade_a == 0) {
                                $idt_entidade_a = $idt_entidade_maior;
                                unset($vetEX[$idt_entidade_maior]);
                            }

                            foreach ($vetEX as $idt_entidade) {
                                $sql = '';
                                $sql .= ' select idt_atendimento, count(distinct idt_entidade) as tot';
                                $sql .= ' from ' . db_pir_grc . 'grc_sincroniza_siac';
                                $sql .= ' where idt_evento is not null';
                                $sql .= " and tipo = 'E'";
                                $sql .= " and tipo_entidade = 'J'";
                                $sql .= ' and (idt_entidade = ' . null($idt_entidade_a) . ' or idt_entidade = ' . null($idt_entidade) . ')';
                                $sql .= ' group by idt_atendimento';
                                $sql .= ' having tot > 1';
                                $rs = execsql($sql, false);

                                if ($rs->rows > 0) {
                                    foreach ($rs->data as $row) {
                                        $sql = '';
                                        $sql .= ' delete from ' . db_pir_grc . 'grc_sincroniza_siac';
                                        $sql .= ' where idt_evento is not null';
                                        $sql .= " and tipo = 'E'";
                                        $sql .= " and tipo_entidade = 'J'";
                                        $sql .= ' and (idt_entidade = ' . null($idt_entidade_a) . ' or idt_entidade = ' . null($idt_entidade) . ')';
                                        $sql .= " and representa = 'N'";
                                        $sql .= ' and idt_atendimento = ' . null($row['idt_atendimento']);
                                        $rs = execsql($sql, false);
                                    }
                                }

                                $sql = "update " . db_pir_gec . "gec_entidade set codigo_siacweb = null, reg_situacao = 'EE' where idt = " . null($idt_entidade);
                                execsql($sql, false);

                                $sql = "update " . db_pir_grc . "grc_sincroniza_siac set idt_entidade = " . null($idt_entidade_a) . " where idt_entidade = " . null($idt_entidade);
                                execsql($sql, false);
                            }
                        }
                    }

                    if (count($vetSiac) == 0) {
                        $executa = true;
                        $descricao = '';
                        $codparceiro_siac = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);

                        foreach ($vetRow['row'] as $row) {
                            if ($descricao == '') {
                                $descricao = $row['descricao'];
                            } else if (remover_acento($row['descricao']) != remover_acento($descricao)) {
                                $executa = false;
                            }
                        }

                        if ($executa) {
                            foreach ($vetRow['row'] as $row) {
                                if ($row['idt_entidade'] > $idt_entidade_maior) {
                                    $idt_entidade_maior = $row['idt_entidade'];
                                }

                                $vetEX[$row['idt_entidade']] = $row['idt_entidade'];
                                grc_entidade_ajuste_updateCodSiacweb($row['codparceiro_gec'], $codparceiro_siac);
                            }

                            unset($vetEX[$idt_entidade_maior]);

                            foreach ($vetEX as $idt_entidade) {
                                $sql = "update " . db_pir_gec . "gec_entidade set codigo_siacweb = null, reg_situacao = 'EE' where idt = " . null($idt_entidade);
                                execsql($sql, false);

                                $sql = "update " . db_pir_grc . "grc_sincroniza_siac set idt_entidade = " . null($idt_entidade_maior) . " where idt_entidade = " . null($idt_entidade);
                                execsql($sql, false);
                            }
                        }
                    }

                    commit();
                }
            }

            //Verifica SiacWeb
            set_time_limit(0);
            execsql('truncate table grc_entidade_ajuste');

            $sql = '';
            $sql .= ' select e.idt, e.codigo, e.codigo_siacweb as codparceiro, e.descricao, o.dap, o.nirf, o.rmp, o.ie_prod_rural';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_organizacao o';
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = o.idt_entidade';
            $sql .= " where e.idt_entidade_tipo_emp = 7";
            $sql .= " and e.reg_situacao = 'A'";
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                set_time_limit(0);

                if (substr($row['codigo'], 0, 2) == 'PR') {
                    $row['codigo'] = '';
                }

                $sql = '';
                $sql .= ' select p.nomerazaosocial as descricao, j.coddap as dap, j.nirf, j.codpescador as rmp, j.inscest as ie_prod_rural,';
                $sql .= ' p.codparceiro, p.cgccpf as codigo';
                $sql .= ' from pessoaj j with(nolock)';
                $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = j.codparceiro';
                $sql .= ' where ';

                $vetSQL = Array();

                if ($row['ie_prod_rural'] != '') {
                    $vetSQL[] = 'j.inscest = ' . aspa($row['ie_prod_rural']);
                }

                if ($row['dap'] != '') {
                    $vetSQL[] = 'j.coddap = ' . aspa($row['dap']);
                }

                if ($row['rmp'] != '') {
                    $vetSQL[] = 'j.codpescador = ' . aspa($row['rmp']);
                }

                if ($row['nirf'] != '') {
                    $vetSQL[] = 'j.nirf = ' . null(preg_replace('/[^0-9]/i', '', $row['nirf']));
                }

                if (count($vetSQL) == 0) {
                    $sql .= ' 1 = 0 ';
                } else {
                    $sql .= implode(' or ', $vetSQL);
                }

                $rsSiac = execsql($sql, true, $conSIAC);

                if ($rsSiac->rows == 0) {
                    $sql = 'insert into grc_entidade_ajuste (codigo, descricao, dap, nirf, rmp, ie_prod_rural, idt_entidade, codparceiro_gec, msg_2) values (';
                    $sql .= aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['dap']) . ', ' . aspa($row['nirf']) . ', ' . aspa($row['rmp']) . ', ' . aspa($row['ie_prod_rural']) . ', ';
                    $sql .= aspa($row['idt']) . ', ' . aspa($row['codparceiro']) . ", 'Não tem no SiacWeb')";
                    execsql($sql, false);
                } else {
                    foreach ($rsSiac->data as $rowSiac) {
                        if (remover_acento($row['descricao']) == remover_acento($rowSiac['descricao'])) {
                            $erro_descricao = 'N';
                        } else {
                            $erro_descricao = 'S';
                        }

                        if (mb_strtolower($row['codparceiro']) == mb_strtolower($rowSiac['codparceiro'])) {
                            $erro_codparceiro = 'N';
                        } else {
                            $erro_codparceiro = 'S';
                        }

                        $sql = 'insert into grc_entidade_ajuste (descricao, dap, nirf, rmp, ie_prod_rural, descricao_siac, dap_siac, nirf_siac, rmp_siac, ie_prod_rural_siac,';
                        $sql .= ' idt_entidade, codparceiro_gec, codparceiro_siac, erro_descricao, erro_codparceiro, msg_2,';
                        $sql .= ' codigo, codigo_siac) values (';
                        $sql .= aspa($row['descricao']) . ', ' . aspa($row['dap']) . ', ' . aspa($row['nirf']) . ', ' . aspa($row['rmp']) . ', ' . aspa($row['ie_prod_rural']) . ', ';
                        $sql .= aspa($rowSiac['descricao']) . ', ' . aspa($rowSiac['dap']) . ', ' . aspa($rowSiac['nirf']) . ', ' . aspa($rowSiac['rmp']) . ', ' . aspa($rowSiac['ie_prod_rural']) . ', ';
                        $sql .= aspa($row['idt']) . ', ' . aspa($row['codparceiro']) . ', ' . aspa($rowSiac['codparceiro']) . ', ' . aspa($erro_descricao) . ', ' . aspa($erro_codparceiro) . ', null,';
                        $sql .= aspa($row['codigo']) . ', ' . aspa($rowSiac['codigo']) . ')';
                        execsql($sql, false);
                    }
                }
            }
        } catch (Exception $e) {
            $msg = grava_erro_log('grc_entidade_ajuste_acao', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_produto_dep_composto':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            $sql = '';
            $sql .= ' select tipo_ordem';
            $sql .= ' from ' . db_pir_gec . 'gec_programa';
            $sql .= ' where idt = ' . null($_POST['idt_programa']);
            $rs = execsql($sql, false);
            $tipo_ordem = $rs->data[0][0];

            $sql = "select grc_pp.idt";
            $sql .= " from grc_produto_produto grc_atdp  ";
            $sql .= " inner join grc_produto grc_pp on grc_pp.idt = grc_atdp.idt_produto_associado ";
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = grc_pp.idt_programa';
            $sql .= ' where grc_atdp.idt_produto = ' . null($_POST['idt']);
            $sql .= ' and gec_prog.tipo_ordem <> ' . aspa($tipo_ordem);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vetErroMsg[] = "O Programa Credenciado do Produto Composto é diferente de alguns PRODUTOS ASSOCIADOS selecioandos!";
            }

            $sql = "select grc_pp.idt";
            $sql .= " from grc_produto_produto grc_atdp  ";
            $sql .= " inner join grc_produto grc_pp on grc_pp.idt = grc_atdp.idt_produto_associado ";
            $sql .= ' where grc_atdp.idt_produto = ' . null($_POST['idt']);
            $sql .= ' and grc_pp.idt_programa_grc <> ' . null($_POST['idt_programa_grc']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vetErroMsg[] = "O Programa do Produto Composto é diferente de alguns PRODUTOS ASSOCIADOS selecioandos!";
            }

            $idt_instrumento = '0';

            if ($_POST['pc_consultoria'] == 'S') {
                $idt_instrumento .= ',39';
            }

            if ($_POST['pc_curso'] == 'S') {
                $idt_instrumento .= ',40';
            }

            if ($_POST['pc_oficina'] == 'S') {
                $idt_instrumento .= ',46';
            }

            if ($_POST['pc_palestra'] == 'S') {
                $idt_instrumento .= ',47';
            }

            if ($_POST['pc_seminario'] == 'S') {
                $idt_instrumento .= ',49';
            }

            $sql = "select grc_pp.idt";
            $sql .= " from grc_produto_produto grc_atdp  ";
            $sql .= " inner join grc_produto grc_pp on grc_pp.idt = grc_atdp.idt_produto_associado ";
            $sql .= ' where grc_atdp.idt_produto = ' . null($_POST['idt']);
            $sql .= ' and grc_pp.idt_instrumento not in (' . $idt_instrumento . ')';
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vetErroMsg[] = "Tem alguns PRODUTOS ASSOCIADOS selecioandos com instrumento que não foi selecioando!";
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_produto_dep_sg':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            $sql = '';
            $sql .= ' select sum(percentual) as tot';
            $sql .= ' from grc_produto_entrega';
            $sql .= ' where idt_produto = ' . null($_POST['idt']);
            $rs = execsql($sql, false);

            if ($rs->data[0][0] != 100) {
                $vetErroMsg[] = "O Percentual da distribuição das Entregas não é 100%!";
            }

            if ($_POST['vl_determinado'] == 'S') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_dimensionamento';
                $sql .= ' where idt_produto = ' . null($_POST['idt']);
                $sql .= ' limit 1';
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    $vetErroMsg[] = "Favor informar o Dimensionamento do Produto!";
                }
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_evento_dep':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            //grc_atendimento_evento_entrega
            $sql = '';
            $sql .= ' select ep.idt_entidade';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_produto ep';
            $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
            $sql .= " and ep.repasse = 'S'";
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $vetErroMsg[] = "O Produto não tem Profissionais informado!";
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_atendimento_evento_dep_ap':
        $vet = Array(
            'erro' => '',
        );

        try {
            $vetErroMsg = Array();

            //grc_atendimento_evento_entrega
            $sql = '';
            $sql .= ' select sum(percentual) as tot';
            $sql .= ' from grc_atendimento_evento_entrega';
            $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt']);
            $rs = execsql($sql, false);

            if ($rs->data[0][0] != 100) {
                $vetErroMsg[] = "O Percentual da distribuição das Entregas não é 100%!";
            }

            //grc_atendimento_evento_dimensionamento
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_evento_dimensionamento';
            $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt']);
            $sql .= ' limit 1';
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $vetErroMsg[] = "Favor informar o Dimensionamento da Demanda!";
            }

            //grc_atendimento_evento_pagamento
            $sql = '';
            $sql .= ' select sum(valor_pagamento) as tot';
            $sql .= ' from grc_atendimento_evento_pagamento';
            $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt']);
            $sql .= " and estornado <> 'S'";
            $rs = execsql($sql, false);
            $vl_pago = $rs->data[0][0];

            if ($vl_pago == '') {
                $vl_pago = 0;
            }

            $sql = '';
            $sql .= ' select resumo_pag, resumo_tot';
            $sql .= ' from grc_atendimento_evento';
            $sql .= ' where idt = ' . null($_POST['idt']);
            $rs = execsql($sql, false);
            $vl_apagar = $rs->data[0]['resumo_pag'];
            $resumo_tot = $rs->data[0]['resumo_tot'];

            if ($resumo_tot == '') {
                $resumo_tot = 0;
            }

            if ($resumo_tot == 0) {
                $vetErroMsg[] = 'Favor informar os valores do Dimensionamento da Demanda!';
            } else {
                $sql = '';
                $sql .= ' select p.vl_teto';
                $sql .= ' from grc_atendimento_evento ae';
                $sql .= ' inner join grc_produto p on p.idt = ae.idt_produto';
                $sql .= ' where ae.idt = ' . null($_POST['idt']);
                $rs = execsql($sql);
                $vl_teto = $rs->data[0][0];

                if ($vl_teto == '') {
                    $vl_teto = 0;
                }

                if ($resumo_tot > $vl_teto) {
                    $vetErroMsg[] = 'O Total do evento não pode ser maior que o Valor Teto da Solução!';
                } else {
                    if ($vl_apagar == '') {
                        $vl_apagar = 0;
                    }

                    if ($vl_apagar != $vl_pago) {
                        $vetErroMsg[] = 'O valor total de pagamento (R$ ' . format_decimal($vl_pago) . ') esta diferente do Valor a Pagar no Resumo Finaceiro (R$ ' . format_decimal($vl_apagar) . ')!';
                    }
                }
            }

            //Verifica se informou as contas de devolução
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_evento_contadevolucao';
            $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt']);
            $sql .= ' and cpfcnpj is null';
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vetErroMsg[] = 'Favor informar a conta dos registros de Dados da Devolução!';
            }

            if (count($vetErroMsg) > 0) {
                $vet['erro'] = rawurlencode(implode("\n", $vetErroMsg));
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_evento_participante_valida_sg':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select sum(ea.vl_total) as tot';
            $sql .= ' from grc_evento_dimensionamento ea';
            $sql .= ' where ea.idt_atendimento = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql, false);
            $tot = $rs->data[0][0];

            if ($tot <= 0) {
                $vet['erro'] = rawurlencode('O valor do Dimensionamento da Demanda não pode ser zero!');
            } else {
                $sql = '';
                $sql .= ' select vl_teto';
                $sql .= ' from grc_produto';
                $sql .= ' where idt = ' . null($_POST['idt_produto']);
                $rs = execsql($sql, false);
                $rowp = $rs->data[0];

                if ($rowp['vl_teto'] == '') {
                    $rowp['vl_teto'] = 0;
                }

                if ($tot > $rowp['vl_teto']) {
                    $vet['erro'] = rawurlencode('O valor do Dimensionamento da Demanda não pode ser maior que o Valor Teto da Solução!');
                }
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_nan_troca_tutor_listagem':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"><b>AOE</b></td>';
            $html .= '<td class="Titulo"><b>Novo Tutor</b></td>';
            $html .= '</tr>';

            $sql = '';
            $sql .= ' select ne.idt, ne.idt_acao, plu_usu.nome_completo as aoe';
            $sql .= ' from grc_nan_estrutura ne';
            $sql .= " left outer join plu_usuario plu_usu on plu_usu.id_usuario = ne.idt_usuario";
            $sql .= ' where ne.idt_nan_tipo = 6';
            $sql .= ' and ne.idt_tutor = ' . null($_POST['idt_tutor']);
            $sql .= ' order by plu_usu.nome_completo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $sql = "select ne.idt, plu_usu.nome_completo";
                $sql .= " from grc_nan_estrutura ne ";
                $sql .= " inner join plu_usuario plu_usu on plu_usu.id_usuario = ne.idt_usuario ";
                $sql .= ' where ne.idt_nan_tipo = 5';
                $sql .= ' and ne.idt_acao = ' . null($row['idt_acao']);
                $sql .= ' and ne.idt <> ' . null($_POST['idt_tutor']);
                $sql .= " order by plu_usu.nome_completo";
                $cmb = criar_combo_rs(execsql($sql), 'idt_tutor[' . $row['idt'] . ']', '', ' ', '', '', '', true);

                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro">' . $row['aoe'] . '</td>';
                $html .= '<td class="Registro">' . $cmb . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_nan_troca_aoe_listagem':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $sql = "select u_aoe.id_usuario, u_aoe.login, u_aoe.nome_completo";
            $sql .= " from grc_nan_estrutura ne ";
            $sql .= " inner join plu_usuario u_aoe on u_aoe.id_usuario = ne.idt_usuario";
            $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e_emp on e_emp.idt = ne.idt_empresa_executora';
            $sql .= " inner join plu_usuario u_emp on u_emp.login = e_emp.codigo";
            $sql .= ' where ne.idt_nan_tipo = 6';
            $sql .= ' and u_emp.id_usuario = ' . null($_POST['idt_nan_empresa']);
            $sql .= ' and ne.idt_acao = ' . null($_POST['idt_acao']);
            $sql .= ' and ne.idt_usuario <> ' . null($_POST['idt_aoe']);
            $sql .= " order by u_aoe.nome_completo";
            $rs_cmb = execsql($sql);

            $cmb = criar_combo_rs($rs_cmb, 'idt_consultor_padrao', '', ' ', '', '', '', true);

            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"><b>Protocolo NAN</b></td>';
            $html .= '<td class="Titulo"><b>Nº da Visita</b></td>';
            $html .= '<td class="Titulo"><b>Situação</b></td>';
            $html .= '<td class="Titulo"><b>Empreendimento / CNPJ</b></td>';
            $html .= '<td class="Titulo"><b>Novo Agente</b><br>' . $cmb . '</td>';
            $html .= '</tr>';

            $sql = '';
            $sql .= ' select a.idt, a.protocolo, a.nan_num_visita, g.status_1, g.status_2, v1.protocolo as protocolo_v1,';
            $sql .= " concat_ws('<br />', ao.razao_social, ao.cnpj) as empreendimento";
            $sql .= ' from grc_atendimento a';
            $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
            $sql .= ' inner join plu_usuario u on u.id_usuario = a.idt_consultor';
            $sql .= " left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = a.idt and ao.representa = 'S' and ao.desvincular = 'N'";
            $sql .= ' left outer join grc_atendimento v1 on v1.idt_grupo_atendimento = a.idt_grupo_atendimento and v1.nan_num_visita = 1';
            $sql .= ' where a.idt_nan_empresa = ' . null($_POST['idt_nan_empresa']);
            $sql .= ' and a.idt_consultor_prox_atend = ' . null($_POST['idt_aoe']);
            $sql .= ' and a.idt_projeto_acao = ' . null($_POST['idt_acao']);
            $sql .= ' and (';
            $sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
            $sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
            $sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
            $sql .= ' )';
            $sql .= ' order by a.protocolo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $cmb = criar_combo_rs($rs_cmb, 'idt_consultor[' . $row['idt'] . ']', '', ' ', '', '', '', true);

                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro">' . $row['protocolo'] . '</td>';
                $html .= '<td class="Registro">';

                $html .= $row['nan_num_visita'];

                if ($row['nan_num_visita'] == 2) {
                    $html .= '<br />Protocolo V1<br />' . $row['protocolo_v1'];
                }

                $html .= '</td>';
                $html .= '<td class="Registro">' . $vetNanGrupo[$row['status_' . $row['nan_num_visita']]] . '</td>';
                $html .= '<td class="Registro">' . $row['empreendimento'] . '</td>';
                $html .= '<td class="Registro">' . $cmb . '</td>';
                $html .= '</tr>';
            }

            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo" colspan="5"><b>Total de Registros: ' . $rs->rows . '</b></td>';
            $html .= '</tr>';

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'nan_at_pf_pj':
        $sql = '';
        $sql .= ' select u.id_usuario, u.login, u.nome_completo';
        $sql .= ' from grc_atendimento a';
        $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
        $sql .= ' inner join plu_usuario u on u.id_usuario = a.idt_consultor';
        $sql .= ' where a.idt_nan_empresa = ' . null($_POST['idt_nan_empresa']);
        $sql .= ' and a.idt_projeto_acao = ' . null($_POST['idt_acao']);
        $sql .= ' and (';
        $sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
        $sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
        $sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
        $sql .= ' )';
        $sql .= ' group by u.id_usuario, u.login, u.nome_completo';
        $sql .= ' order by u.nome_completo';
        echo rawurlencode(option_rs(execsql($sql), '', ' '));
        break;

    case 'wizard_campo':
        echo rawurlencode(option_rs($vetRsWizardCampo[$_POST['wizard_tabela']], '', ' ', 'Não existe informação no sistema', Array('tipo')));
        break;

    case 'cmb_peca_gestor':
        $sql = "select idt,  descricao from grc_agenda_emailsms ";
        $sql .= " where origem = 'P'";
        $sql .= "   and proprietario = 'GESTOR'";
        $sql .= "   and idt_responsavel = " . null($_SESSION[CS]['g_id_usuario']);
        $sql .= " order by codigo";
        echo rawurlencode(option_rs(execsql($sql), '', ' '));
        break;

    case 'grc_nan_troca_aoe_acao':
        $sql = '';
        $sql .= ' select grc_pa.idt, grc_p.descricao, grc_pa.descricao';
        $sql .= ' from grc_atendimento a';
        $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
        $sql .= " inner join grc_projeto_acao grc_pa on grc_pa.idt = a.idt_projeto_acao";
        $sql .= ' inner join grc_projeto grc_p on grc_p.idt = grc_pa.idt_projeto';
        $sql .= ' where a.idt_nan_empresa = ' . null($_GET['val']);
        $sql .= ' and (';
        $sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
        $sql .= " or (a.nan_num_visita = 1 and g.status_1 = 'AP' and g.num_visita_atu = 1)";
        $sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
        $sql .= ' )';
        $sql .= ' group by grc_pa.idt, grc_p.descricao, grc_pa.descricao';
        $sql .= ' order by grc_p.descricao, grc_pa.descricao';
        echo option_rs_json(execsql($sql), $_GET['val'], ' ');
        break;

    case 'grc_atendimento_evento_produto':
        $vet = Array(
            'erro' => '',
            'idt_instrumento' => '',
            'vl_determinado' => '',
            'vl_determinado_txt' => '',
            'vl_teto' => '',
        );

        try {
            beginTransaction();

            $sql = '';
            $sql .= ' select idt_instrumento, vl_determinado, entrega_prazo_max, vl_teto';
            $sql .= ' from grc_produto';
            $sql .= ' where idt = ' . null($_POST['idt_produto']);
            $rs = execsql($sql, false);
            $vet['idt_instrumento'] = $rs->data[0]['idt_instrumento'];
            $vl_determinado = $rs->data[0]['vl_determinado'];
            $vet['vl_determinado'] = $vl_determinado;
            $vet['vl_determinado_txt'] = $vetSimNao[$vl_determinado];
            $vet['entrega_prazo_max'] = $rs->data[0]['entrega_prazo_max'];
            $vet['vl_teto'] = format_decimal($rs->data[0]['vl_teto']);

            if ($vet['idt_instrumento'] == 39) {
                $vet['idt_instrumento'] = 2;
            }

            $sql = 'delete from grc_atendimento_evento_entrega where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
            execsql($sql, false);

            $sql = 'delete from grc_atendimento_evento_dimensionamento where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
            execsql($sql, false);

            $sql = 'delete from grc_atendimento_evento_contadevolucao where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
            execsql($sql, false);

            $sql = 'delete from grc_atendimento_evento_pagamento where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
            execsql($sql, false);

            //Entregas
            $sql = '';
            $sql .= ' select idt, codigo, descricao, detalhe, percentual, ordem';
            $sql .= ' from grc_produto_entrega';
            $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $sql = '';
                $sql .= ' insert into grc_atendimento_evento_entrega (idt_atendimento_evento, codigo, descricao, detalhe, percentual, ordem) values (';
                $sql .= null($_POST['idt_atendimento_evento']) . ', ' . aspa($row['codigo']) . ', ' . aspa($row['descricao']) . ', ' . aspa($row['detalhe']) . ', ';
                $sql .= aspa($row['percentual']) . ', ' . aspa($row['ordem']) . ')';
                execsql($sql, false);
                $idt_atendimento_evento_entrega = lastInsertId();

                $sql = '';
                $sql .= ' insert into grc_atendimento_evento_entrega_documento (idt_atendimento_evento_entrega, idt_documento, codigo)';
                $sql .= ' select ' . $idt_atendimento_evento_entrega . ' as idt_atendimento_evento_entrega, idt_documento, codigo';
                $sql .= ' from grc_produto_entrega_documento';
                $sql .= ' where idt_produto_entrega = ' . null($row['idt']);
                execsql($sql, false);
            }

            //Dimensionamento
            $sql = '';
            $sql .= ' insert into grc_atendimento_evento_dimensionamento (idt_atendimento_evento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario)';
            $sql .= ' select ' . $_POST['idt_atendimento_evento'] . ' as idt_atendimento_evento, idt_insumo_dimensionamento, codigo, descricao, detalhe, idt_insumo_unidade, vl_unitario';
            $sql .= ' from grc_produto_dimensionamento';
            $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
            execsql($sql, false);

            $sql = '';
            $sql .= ' select ea.resumo_tot, ea.resumo_sub, ea.resumo_pag, ea.entrega_prazo_max, ea.vl_determinado, ea.idt_produto, grc_p.descricao as idt_produto_vl';
            $sql .= ' from grc_atendimento_evento ea';
            $sql .= ' left outer join grc_produto grc_p on grc_p.idt = ea.idt_produto';
            $sql .= ' where ea.idt = ' . null($_POST['idt_atendimento_evento']);
            $rs = execsql($sql, false);
            $rowDados = $rs->data[0];

            $sql = 'update grc_atendimento_evento set';
            $sql .= ' idt_produto = ' . null($_POST['idt_produto']) . ',';
            $sql .= ' idt_instrumento = ' . null($vet['idt_instrumento']) . ',';
            $sql .= ' entrega_prazo_max = ' . null($vet['entrega_prazo_max']) . ',';
            $sql .= ' vl_determinado = ' . aspa($vl_determinado) . ',';
            $sql .= ' resumo_tot = 0,';
            $sql .= ' resumo_sub = 0,';
            $sql .= ' resumo_pag = 0';
            $sql .= ' where idt = ' . null($_POST['idt_atendimento_evento']);
            execsql($sql, false);

            //Grava Log
            $vetLogDetalhe = Array();

            $vetLogDetalhe['idt_produto']['campo_desc'] = 'Produto';
            $vetLogDetalhe['idt_produto']['vl_ant'] = $rowDados['idt_produto_vl'];
            $vetLogDetalhe['idt_produto']['desc_ant'] = $rowDados['idt_produto'];

            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from grc_produto';
            $sql .= ' where idt = ' . null($_POST['idt_produto']);
            $rs = execsql($sql, false);
            $vetLogDetalhe['idt_produto']['vl_atu'] = $rs->data[0][0];

            $vetLogDetalhe['idt_produto']['desc_atu'] = $_POST['idt_produto'];

            $vetLogDetalhe['entrega_prazo_max']['campo_desc'] = 'Prazo Máximo para execução do Serviço (dias)';
            $vetLogDetalhe['entrega_prazo_max']['desc_ant'] = $rowDados['entrega_prazo_max'];
            $vetLogDetalhe['entrega_prazo_max']['desc_atu'] = $vet['entrega_prazo_max'];

            $vetLogDetalhe['vl_determinado']['campo_desc'] = 'Valor Determinado';
            $vetLogDetalhe['vl_determinado']['desc_ant'] = $vetSimNao[$rowDados['vl_determinado']];
            $vetLogDetalhe['vl_determinado']['desc_atu'] = $vetSimNao[$vl_determinado];
            $vetLogDetalhe['vl_determinado']['vl_ant'] = $rowDados['vl_determinado'];
            $vetLogDetalhe['vl_determinado']['vl_atu'] = $vl_determinado;

            $vetLogDetalhe['resumo_tot']['campo_desc'] = 'Total (Resumo Finaceiro)';
            $vetLogDetalhe['resumo_tot']['desc_ant'] = format_decimal($rowDados['resumo_tot']);
            $vetLogDetalhe['resumo_tot']['desc_atu'] = 0;

            $vetLogDetalhe['resumo_sub']['campo_desc'] = 'Subsidio (Resumo Finaceiro)';
            $vetLogDetalhe['resumo_sub']['desc_ant'] = format_decimal($rowDados['resumo_sub']);
            $vetLogDetalhe['resumo_sub']['desc_atu'] = 0;

            $vetLogDetalhe['resumo_pag']['campo_desc'] = 'Valor a Pagar (Resumo Finaceiro)';
            $vetLogDetalhe['resumo_pag']['desc_ant'] = format_decimal($rowDados['resumo_pag']);
            $vetLogDetalhe['resumo_pag']['desc_atu'] = 0;

            grava_log_sis('grc_atendimento_evento', 'A', $_POST['idt_atendimento_evento'], 'Aletração do Produto', 'Contratação SEBRAETEC', '', $vetLogDetalhe, true);

            commit();
        } catch (PDOException $e) {
            rollBack();
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = $msg;
        } catch (Exception $e) {
            rollBack();
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = $msg;
        }

        $vet = array_map('rawurlencode', $vet);
        echo json_encode($vet);
        break;

    case 'CopiarAgendaEvento':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_agenda';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vet['erro'] = rawurlencode('Já tem registro de Cronograma / Atividades informada, com isso não pode fazer a copia!');
            } else {
                beginTransaction();

                $sql = 'insert into grc_evento_agenda (idt_atendimento, idt_evento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg)';
                $sql .= ' select ' . $_POST['idt_atendimento'] . ' as idt_atendimento, idt_evento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg';
                $sql .= ' from grc_evento_agenda';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);

                if ($_POST['idt_copia'] == 'evento') {
                    $sql .= ' and idt_atendimento is null';
                } else {
                    $sql .= ' and idt_atendimento = ' . null($_POST['idt_copia']);
                }

                execsql($sql, false);

                //Cria a Atividade
                $sql = '';
                $sql .= ' select idt, idt_evento, idt_atendimento, atividade, idt_tema, idt_subtema';
                $sql .= ' from grc_evento_agenda';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $rs = execsql($sql, false);

                foreach ($rs->data as $row) {
                    $sql = '';
                    $sql .= ' select idt, idt_tema, idt_subtema';
                    $sql .= ' from grc_evento_atividade';
                    $sql .= ' where cod_atividade = ' . aspa(md5($row['atividade']));
                    $sql .= ' and idt_evento = ' . null($row['idt_evento']);
                    $sql .= ' and idt_atendimento = ' . null($row['idt_atendimento']);
                    $rs_ea = execsql($sql, false);
                    $idt_evento_atividade = $rs_ea->data[0]['idt'];
                    $idt_tema = $rs_ea->data[0]['idt_tema'];
                    $idt_subtema = $rs_ea->data[0]['idt_subtema'];

                    if ($idt_evento_atividade == '') {
                        $sql = '';
                        $sql .= ' insert into grc_evento_atividade (idt_evento, idt_atendimento, cod_atividade, atividade, idt_tema, idt_subtema) values (';
                        $sql .= null($row['idt_evento']) . ', ' . null($row['idt_atendimento']) . ', ' . aspa(md5($row['atividade'])) . ', ' . aspa($row['atividade']) . ', ';
                        $sql .= null($row['idt_tema']) . ', ' . null($row['idt_subtema']) . ')';
                        execsql($sql, false);
                        $idt_evento_atividade = lastInsertId();
                    } else {
                        if ($idt_tema == '' && $row['idt_tema'] != '') {
                            $sql = '';
                            $sql .= ' update grc_evento_atividade set';
                            $sql .= ' idt_tema = ' . null($row['idt_tema']);
                            $sql .= ' where idt = ' . null($idt_evento_atividade);
                            execsql($sql, false);
                        }

                        if ($idt_subtema == '' && $row['idt_subtema'] != '') {
                            $sql = '';
                            $sql .= ' update grc_evento_atividade set';
                            $sql .= ' idt_subtema = ' . null($row['idt_subtema']);
                            $sql .= ' where idt = ' . null($idt_evento_atividade);
                            execsql($sql, false);
                        }
                    }

                    $sql = '';
                    $sql .= ' update grc_evento_agenda set';
                    $sql .= ' idt_evento_atividade = ' . null($idt_evento_atividade);
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                }

                //Ajusta Evento
                $sql = '';
                $sql .= ' select e.composto, e.idt_evento_pai, p.tipo_calculo';
                $sql .= ' from grc_evento e';
                $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
                $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
                $rsa = execsql($sql, false);
                $rowe = $rsa->data[0][0];

                $sql = '';
                $sql .= ' select min(ea.data_inicial) as dt_ini, max(ea.data_final) as dt_fim, min(ea.hora_inicial) as hr_ini, max(ea.hora_final) as hr_fim,';
                $sql .= ' sum(ea.carga_horaria) as carga_horaria, sum(ea.valor_hora * ea.carga_horaria) as custo, count(distinct ea.data_inicial) as qtd_dias_reservados';
                $sql .= ' from grc_evento_agenda ea';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                $sql .= ' where ea.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rsa = execsql($sql, false);
                $row_sum = $rsa->data[0];

                $sql = '';
                $sql .= ' select ei.custo_total';
                $sql .= ' from grc_evento_insumo ei';
                $sql .= ' where ei.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= " and ei.codigo = '71001'";
                $rsa = execsql($sql, false);

                if ($rsa->rows > 0) {
                    $row_sum['custo'] = $rsa->data[0][0];
                }

                if ($rowe['composto'] == 'S') {
                    $sql = '';
                    $sql .= ' select sum(carga_horaria_total) as tot';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt_evento_pai = ' . null($_POST['idt_evento']);
                    $rsa = execsql($sql, false);
                    $carga_horaria_total = $rsa->data[0][0];
                } else if ($rowe['idt_evento_pai'] != '' && $rowe['tipo_calculo'] != '') {
                    $carga_horaria_total = false;
                } else {
                    $carga_horaria_total = $row_sum['carga_horaria'];
                }

                $sql = '';
                $sql .= ' update grc_evento set';
                $sql .= ' dt_previsao_inicial = ' . aspa($row_sum['dt_ini']) . ',';
                $sql .= ' dt_previsao_fim = ' . aspa($row_sum['dt_fim']) . ',';
                $sql .= ' hora_inicio = ' . aspa($row_sum['hr_ini']) . ',';
                $sql .= ' hora_fim = ' . aspa($row_sum['hr_fim']) . ',';

                if ($carga_horaria_total !== false) {
                    $sql .= ' carga_horaria_total = ' . null($carga_horaria_total) . ',';
                }

                $sql .= ' tot_hora_consultoria = ' . null($row_sum['carga_horaria']) . ',';
                $sql .= ' custo_tot_consultoria = ' . null($row_sum['custo']);
                $sql .= ' where idt = ' . null($_POST['idt_evento']);
                execsql($sql, false);

                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'ExcluirAgendaErradaEvento':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_agenda';
            $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
            $sql .= ' and idt_atendimento is not null';
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $vet['erro'] = rawurlencode('Não pode Excluir o Cronograma / Atividades sem Cliente, pois não tem nenhum cliente com a agenda informada!');
            } else {
                beginTransaction();

                $sql = 'delete from grc_evento_agenda';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= ' and idt_atendimento is null';
                execsql($sql, false);

                //Ajusta Evento
                $sql = '';
                $sql .= ' select min(ea.data_inicial) as dt_ini, max(ea.data_final) as dt_fim, min(ea.hora_inicial) as hr_ini, max(ea.hora_final) as hr_fim,';
                $sql .= ' sum(ea.carga_horaria) as carga_horaria, sum(ea.valor_hora * ea.carga_horaria) as custo, count(distinct ea.data_inicial) as qtd_dias_reservados';
                $sql .= ' from grc_evento_agenda ea';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
                $sql .= ' where ea.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rsa = execsql($sql, false);
                $row_sum = $rsa->data[0];

                $sql = '';
                $sql .= ' select ei.custo_total';
                $sql .= ' from grc_evento_insumo ei';
                $sql .= ' where ei.idt_evento = ' . null($_POST['idt_evento']);
                $sql .= " and ei.codigo = '71001'";
                $rsa = execsql($sql, false);

                if ($rsa->rows > 0) {
                    $row_sum['custo'] = $rsa->data[0][0];
                }

                $sql = '';
                $sql .= ' update grc_evento set';
                $sql .= ' dt_previsao_inicial = ' . aspa($row_sum['dt_ini']) . ',';
                $sql .= ' dt_previsao_fim = ' . aspa($row_sum['dt_fim']) . ',';
                $sql .= ' hora_inicio = ' . aspa($row_sum['hr_ini']) . ',';
                $sql .= ' hora_fim = ' . aspa($row_sum['hr_fim']) . ',';
                $sql .= ' carga_horaria_total = ' . null($row_sum['carga_horaria']) . ',';
                $sql .= ' tot_hora_consultoria = ' . null($row_sum['carga_horaria']) . ',';
                $sql .= ' custo_tot_consultoria = ' . null($row_sum['custo']);
                $sql .= ' where idt = ' . null($_POST['idt_evento']);
                execsql($sql, false);

                grava_log_sis('grc_evento', 'R', $_POST['idt_evento'], 'Excluir o Cronograma / Atividades sem Cliente');

                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'MatriculaEventoCompostoPag':
        $vet = Array(
            'erro' => '',
            'valor' => '',
            'ativo_banco' => '',
        );

        try {
            $erro = Array();

            beginTransaction();

            $sql = '';
            $sql .= ' select a.idt_evento, a.idt_instrumento';
            $sql .= ' from grc_atendimento a';
            $sql .= ' where a.idt = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql, false);
            $rowMatPai = $rs->data[0];

            $sql = '';
            $sql .= ' select a.idt_evento, ep.ativo, gec_prog.tipo_ordem, e.codigo, e.descricao';
            $sql .= ' from grc_atendimento a';
            $sql .= ' left outer join grc_evento e on a.idt_evento = e.idt';
            $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
            $sql .= ' where a.idt = ' . null($_POST['idt_atendimento_filho']);
            $rs = execsql($sql, false);
            $rowMatAnt = $rs->data[0];

            $vet['ativo_banco'] = $rowMatAnt['ativo'];

            switch ($_POST['valor']) {
                case 'S':
                    $evento_cortesia = 'N';
                    $ativo = 'S';
                    break;

                case 'C':
                    $evento_cortesia = 'S';
                    $ativo = 'S';
                    break;

                default:
                    $evento_cortesia = 'N';
                    $ativo = 'N';
                    break;
            }

            $sql = "update grc_atendimento_pessoa set evento_cortesia = " . aspa($evento_cortesia) . " where idt_atendimento = " . null($_POST['idt_atendimento_filho']);
            execsql($sql, false);

            $sql = "update grc_evento_participante set ativo = " . aspa($ativo) . " where idt_atendimento = " . null($_POST['idt_atendimento_filho']);
            execsql($sql, false);

            if ($rowMatAnt['ativo'] != $ativo) {
                if ($rowMatPai['idt_instrumento'] == 54) {
                    $sql = '';
                    $sql .= ' select idt, qtd_vaga';
                    $sql .= ' from grc_evento_combo';
                    $sql .= " where idt_evento_origem = " . null($rowMatPai['idt_evento']);
                    $sql .= " and idt_evento = " . null($rowMatAnt['idt_evento']);
                    $rs = execsql($sql, false);
                    $rowEC = $rs->data[0];

                    if ($ativo == 'S') {
                        if ($rowEC['qtd_vaga'] <= 0) {
                            rollBack();
                            beginTransaction();
                            $erro[] = 'O evento ' . $rowMatAnt['codigo'] . ' - ' . $rowMatAnt['descricao'] . ' não tem mais vaga disponível!';
                        } else {
                            $sql = "update grc_evento_combo set qtd_utilizada = qtd_utilizada + 1, qtd_vaga = qtd_vaga - 1";
                            $sql .= " where idt = " . null($rowEC['idt']);
                            execsql($sql, false);

                            $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + 1, qtd_vagas_bloqueadas = qtd_vagas_bloqueadas - 1";
                            $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                            execsql($sql, false);

                            $sql = '';
                            $sql .= ' select quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                            $sql .= ' from grc_evento';
                            $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                            $rsVaga = execsql($sql, false);
                            $rowVaga = $rsVaga->data[0];

                            if ($rowVaga['tot'] > $rowVaga['qtd']) {
                                rollBack();
                                beginTransaction();
                                $erro[] = 'O evento ' . $rowMatAnt['codigo'] . ' - ' . $rowMatAnt['descricao'] . ' não tem mais vaga disponível!';
                            }
                        }
                    } else {
                        $sql = "update grc_evento_combo set qtd_utilizada = qtd_utilizada - 1, qtd_vaga = qtd_vaga + 1";
                        $sql .= " where idt = " . null($rowEC['idt']);
                        execsql($sql, false);

                        $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - 1, qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + 1";
                        $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                        execsql($sql, false);
                    }
                } else {
                    if ($ativo == 'S') {
                        $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado + 1";
                        $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                        execsql($sql, false);

                        if ($rowMatAnt['tipo_ordem'] != 'SG') {
                            $sql = '';
                            $sql .= ' select quantidade_participante + qtd_vagas_adicional + qtd_vagas_extra as qtd, qtd_matriculado_siacweb + qtd_vagas_resevado + qtd_vagas_bloqueadas as tot';
                            $sql .= ' from grc_evento';
                            $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                            $rsVaga = execsql($sql, false);
                            $rowVaga = $rsVaga->data[0];

                            if ($rowVaga['tot'] > $rowVaga['qtd']) {
                                rollBack();
                                beginTransaction();
                                $erro[] = 'O evento ' . $rowMatAnt['codigo'] . ' - ' . $rowMatAnt['descricao'] . ' não tem mais vaga disponível!';
                            }
                        }
                    } else {
                        $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - 1";
                        $sql .= " where idt = " . null($rowMatAnt['idt_evento']);
                        execsql($sql, false);
                    }
                }
            }

            $vet['valor'] = format_decimal(MatriculaEventoCompostoPag($_POST['idt_atendimento'], false));

            if (count($erro) > 0) {
                rollBack();
                $vet['erro'] = rawurlencode(implode('\n', $erro));
            } else {
                commit();
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'MatriculaEventoCompostoValida':
        $vet = Array(
            'erro' => '',
        );

        try {
            MatriculaEventoCompostoPag($_POST['idt_atendimento'], false);

            $sql = '';
            $sql .= ' select vl_tot_pagamento';
            $sql .= ' from grc_evento_participante';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql, false);
            $vl_tot_pagamento = $rs->data[0][0];

            $sql = '';
            $sql .= ' select sum(valor_pagamento) as tot';
            $sql .= ' from grc_evento_participante_pagamento';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $sql .= " and estornado <> 'S'";
            $sql .= " and operacao = 'C'";
            $sql .= ' and idt_aditivo_participante is null';
            $rs = execsql($sql, false);
            $tot = $rs->data[0][0];

            if ($tot != $vl_tot_pagamento) {
                $vet['erro'] = rawurlencode('Está faltando informar valores no Resumo do Pagamento!');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'MatriculaEventoValidaExcluir':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_participante_pagamento';
            $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
            $sql .= ' and rm_idmov is not null';
            $sql .= " and estornar_rm <> 'E'";
            $sql .= ' and idt_aditivo_participante is null';
            $rs = execsql($sql, false);

            if ($rs->rows > 0) {
                $vet['erro'] = rawurlencode('A matricula ainda tem registro de Resumo do Pagamento integrado com o RM! Favor excluir antes estes registros.');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'email_padrao':
        $vet = Array(
            'erro' => '',
        );

        $idt_email_padrao = $_POST['idt_email_padrao'];
//					$idt_email_padrao = 4;
        try {
            $sql = '';
            $sql .= ' select * ';
            $sql .= ' from grc_agenda_emailsms';
            $sql .= ' where idt = ' . null($idt_email_padrao);
            $rs = execsql($sql);
            ForEach ($rs->data as $row) {
                $titulo = $row['descricao'];
                $msg_email = $row['detalhe'];
            }

            $vet['titulo'] = rawurlencode($titulo);
            $vet['msg_email'] = rawurlencode($msg_email);
            //	p($rs);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }
//p($vet);
        echo json_encode($vet);
        break;




    case 'data_aleatoria':
        $vet = Array(
            'erro' => '',
        );
        $vet['data_aleatoria'] = $_POST['str_data_aleatoria'];
        $vet['dt_ini'] = $_POST['dt_ini'];
        $vet['dt_fim'] = $_POST['dt_fim'];
        $ret = VerificaDataAleatoria($vet);
        //p($vet);
        //exit();
		echo json_encode($vet);
        break;



    case 'FiltroAgenda':
        $vet = Array(
            'erro' => '',
        );
        $vet['idt_unidade_regional_I'] = $_POST['idt_unidade_regional_I'];
        $vet['idt_ponto_atendimento_I'] = $_POST['idt_ponto_atendimento_I'];
        $vet['idt_consultor_I'] = $_POST['idt_consultor_I'];
        $vet['idt_servico_I'] = $_POST['idt_servico_I'];
        $ret = FiltroAgenda($vet);
        //p($vet);

        echo json_encode($vet);

        break;
    case 'grc_transferencia_responsabilidade_listagem':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"><input id="chkTodos" value="S" class="" type="checkbox"></td>';
            $html .= '<td class="Titulo"><b>Tipo</b></td>';
            $html .= '<td class="Titulo"><b>Status</b></td>';
            $html .= '<td class="Titulo"><b>Protocolo</b></td>';
            $html .= '<td class="Titulo"><b>Data de Abertura</b></td>';
            $html .= '<td class="Titulo"><b>Consultor / Atendente</b></td>';
            $html .= '<td class="Titulo"><b>Assunto</b></td>';
            $html .= '</tr>';

            $vetTipo = Array();

            if ($_POST['chk_evento'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['evento']);
            }

            if ($_POST['chk_pag_cred'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['pag_cred']);
            }

            if ($_POST['chk_atend'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['atend']);
            }

            $sql = '';
            $sql .= ' select pe.*, u.nome_completo';
            $sql .= ' from grc_atendimento_pendencia pe';
            $sql .= ' left outer join plu_usuario u on u.id_usuario = pe.idt_usuario';
            $sql .= ' where pe.idt_responsavel_solucao = ' . null($_POST['idt_colaborador_origem']);
            $sql .= " and pe.ativo = 'S'";

            if (count($vetTipo) == 0) {
                $sql .= " and 1 = 0";
            } else {
                $sql .= ' and pe.tipo in (' . implode(', ', $vetTipo) . ')';
            }

            $sql .= ' order by pe.tipo, pe.status, pe.protocolo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro">';
                $html .= '<input data-id="chk_tela_' . $row['idt'] . '" type="checkbox">';
                $html .= '<input id="chk_tela_' . $row['idt'] . '" name="chk_banco[' . $row['idt'] . ']" value="N" type="hidden">';
                $html .= '</td>';
                $html .= '<td class="Registro">' . $row['tipo'] . '</td>';
                $html .= '<td class="Registro">' . $row['status'] . '</td>';
                $html .= '<td class="Registro">' . $row['protocolo'] . '</td>';
                $html .= '<td class="Registro">' . trata_data($row['data']) . '</td>';
                $html .= '<td class="Registro">' . $row['nome_completo'] . '</td>';
                $html .= '<td class="Registro">' . $row['assunto'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo" colspan="7"><b>Total de Registros: ' . $rs->rows . '</b></td>';
            $html .= '</tr>';

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_transferencia_responsabilidade_banco':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"></td>';
            $html .= '<td class="Titulo"><b>Tipo</b></td>';
            $html .= '<td class="Titulo"><b>Status</b></td>';
            $html .= '<td class="Titulo"><b>Protocolo</b></td>';
            $html .= '<td class="Titulo"><b>Data de Abertura</b></td>';
            $html .= '<td class="Titulo"><b>Consultor / Atendente</b></td>';
            $html .= '<td class="Titulo"><b>Assunto</b></td>';
            $html .= '</tr>';

            $sql = '';
            $sql .= ' select pe.*, u.nome_completo, r.ativo as ativo_reg';
            $sql .= ' from grc_atendimento_pendencia pe';
            $sql .= ' inner join grc_transferencia_responsabilidade_reg r on r.idt_atendimento_pendencia = pe.idt';
            $sql .= ' left outer join plu_usuario u on u.id_usuario = pe.idt_usuario';
            $sql .= ' where r.idt_transferencia_responsabilidade = ' . null($_POST['id']);
            $sql .= ' order by pe.tipo, pe.status, pe.protocolo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                if ($row['ativo_reg'] == 'S') {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }

                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro"><input type="checkbox" ' . $checked . '></td>';
                $html .= '<td class="Registro">' . $row['tipo'] . '</td>';
                $html .= '<td class="Registro">' . $row['status'] . '</td>';
                $html .= '<td class="Registro">' . $row['protocolo'] . '</td>';
                $html .= '<td class="Registro">' . trata_data($row['data']) . '</td>';
                $html .= '<td class="Registro">' . $row['nome_completo'] . '</td>';
                $html .= '<td class="Registro">' . $row['assunto'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo" colspan="7"><b>Total de Registros: ' . $rs->rows . '</b></td>';
            $html .= '</tr>';

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_transferencia_responsabilidade_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select s.idt, s.classificacao';
            $sql .= ' from plu_usuario u';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = u.idt_unidade_lotacao';
            $sql .= ' where u.id_usuario = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $rowc = $rs->data[0];

            $idtSecaoPA = $rowc['idt'];
            $vetCod = explode('.', $rowc['classificacao']);

            //Unidade
            $vetCod[2] = '00';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
            $rs = execsql($sql, false);
            $idtSecaoUN = $rs->data[0][0];

            //Diretoria
            $vetCod[1] = '00';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
            $rs = execsql($sql, false);
            $idtSecaoDI = $rs->data[0][0];

            //Coordenador / Gerente
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $rsCG = execsql($sql, false);

            if ($rsCG->rows == 0) {
                $vet['erro'] = rawurlencode('Não tem o aprovador com o perfil Coordenador / Gerente!');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_transferencia_responsabilidade_listagem':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"><input id="chkTodos" value="S" class="" type="checkbox"></td>';
            $html .= '<td class="Titulo"><b>Tipo</b></td>';
            $html .= '<td class="Titulo"><b>Status</b></td>';
            $html .= '<td class="Titulo"><b>Protocolo</b></td>';
            $html .= '<td class="Titulo"><b>Data de Abertura</b></td>';
            $html .= '<td class="Titulo"><b>Consultor / Atendente</b></td>';
            $html .= '<td class="Titulo"><b>Assunto</b></td>';
            $html .= '</tr>';

            $vetTipo = Array();

            if ($_POST['chk_evento'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['evento']);
            }

            if ($_POST['chk_pag_cred'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['pag_cred']);
            }

            if ($_POST['chk_atend'] == 'S') {
                $vetTipo[] = aspa($vetTipoPenTransResp['atend']);
            }

            $sql = '';
            $sql .= ' select pe.*, u.nome_completo';
            $sql .= ' from grc_atendimento_pendencia pe';
            $sql .= ' left outer join plu_usuario u on u.id_usuario = pe.idt_usuario';
            $sql .= ' where pe.idt_responsavel_solucao = ' . null($_POST['idt_colaborador_origem']);
            $sql .= " and pe.ativo = 'S'";

            if (count($vetTipo) == 0) {
                $sql .= " and 1 = 0";
            } else {
                $sql .= ' and pe.tipo in (' . implode(', ', $vetTipo) . ')';
            }

            $sql .= ' order by pe.tipo, pe.status, pe.protocolo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro">';
                $html .= '<input data-id="chk_tela_' . $row['idt'] . '" type="checkbox">';
                $html .= '<input id="chk_tela_' . $row['idt'] . '" name="chk_banco[' . $row['idt'] . ']" value="N" type="hidden">';
                $html .= '</td>';
                $html .= '<td class="Registro">' . $row['tipo'] . '</td>';
                $html .= '<td class="Registro">' . $row['status'] . '</td>';
                $html .= '<td class="Registro">' . $row['protocolo'] . '</td>';
                $html .= '<td class="Registro">' . trata_data($row['data']) . '</td>';
                $html .= '<td class="Registro">' . $row['nome_completo'] . '</td>';
                $html .= '<td class="Registro">' . $row['assunto'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo" colspan="7"><b>Total de Registros: ' . $rs->rows . '</b></td>';
            $html .= '</tr>';

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_transferencia_responsabilidade_banco':
        $vet = Array(
            'erro' => '',
            'html' => '',
        );

        try {
            $html = '';
            $html .= '<br />';
            $html .= '<table class="Generica" width="100%" vspace="0" cellspacing="0" cellpadding="0" border="0" hspace="0">';
            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo"></td>';
            $html .= '<td class="Titulo"><b>Tipo</b></td>';
            $html .= '<td class="Titulo"><b>Status</b></td>';
            $html .= '<td class="Titulo"><b>Protocolo</b></td>';
            $html .= '<td class="Titulo"><b>Data de Abertura</b></td>';
            $html .= '<td class="Titulo"><b>Consultor / Atendente</b></td>';
            $html .= '<td class="Titulo"><b>Assunto</b></td>';
            $html .= '</tr>';

            $sql = '';
            $sql .= ' select pe.*, u.nome_completo, r.ativo as ativo_reg';
            $sql .= ' from grc_atendimento_pendencia pe';
            $sql .= ' inner join grc_transferencia_responsabilidade_reg r on r.idt_atendimento_pendencia = pe.idt';
            $sql .= ' left outer join plu_usuario u on u.id_usuario = pe.idt_usuario';
            $sql .= ' where r.idt_transferencia_responsabilidade = ' . null($_POST['id']);
            $sql .= ' order by pe.tipo, pe.status, pe.protocolo';
            $rs = execsql($sql, false);

            foreach ($rs->data as $row) {
                if ($row['ativo_reg'] == 'S') {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }

                $html .= '<tr class="Registro">';
                $html .= '<td class="Registro"><input type="checkbox" ' . $checked . '></td>';
                $html .= '<td class="Registro">' . $row['tipo'] . '</td>';
                $html .= '<td class="Registro">' . $row['status'] . '</td>';
                $html .= '<td class="Registro">' . $row['protocolo'] . '</td>';
                $html .= '<td class="Registro">' . trata_data($row['data']) . '</td>';
                $html .= '<td class="Registro">' . $row['nome_completo'] . '</td>';
                $html .= '<td class="Registro">' . $row['assunto'] . '</td>';
                $html .= '</tr>';
            }

            $html .= '<tr class="Generica">';
            $html .= '<td class="Titulo" colspan="7"><b>Total de Registros: ' . $rs->rows . '</b></td>';
            $html .= '</tr>';

            $html .= '</table>';

            $vet['html'] = rawurlencode($html);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'grc_transferencia_responsabilidade_valida':
        $vet = Array(
            'erro' => '',
        );

        try {
            $sql = '';
            $sql .= ' select s.idt, s.classificacao';
            $sql .= ' from plu_usuario u';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = u.idt_unidade_lotacao';
            $sql .= ' where u.id_usuario = ' . null($_POST['id']);
            $rs = execsql($sql, false);
            $rowc = $rs->data[0];

            $idtSecaoPA = $rowc['idt'];
            $vetCod = explode('.', $rowc['classificacao']);

            //Unidade
            $vetCod[2] = '00';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
            $rs = execsql($sql, false);
            $idtSecaoUN = $rs->data[0][0];

            //Diretoria
            $vetCod[1] = '00';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
            $rs = execsql($sql, false);
            $idtSecaoDI = $rs->data[0][0];

            //Coordenador / Gerente
            $sql = '';
            $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
            $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
            $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
            $sql .= " where f.tipo_alcada_evento = 'CG'";
            $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
            $sql .= " and p.ativo = 'S'";
            $rsCG = execsql($sql, false);

            if ($rsCG->rows == 0) {
                $vet['erro'] = rawurlencode('Não tem o aprovador com o perfil Coordenador / Gerente!');
            }
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'CarregarAgendaExistente':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_gera_agenda = $_POST['idt_atendimento_gera_agenda'];
        $vet['idt_atendimento_gera_agenda'] = $_POST['idt_atendimento_gera_agenda'];
        $vet['dt_inicial'] = $_POST['dt_inicial'];
        $vet['dt_final'] = $_POST['dt_final'];

        $vet['idt_consultor'] = $_POST['idt_consultor'];
        $vet['idt_ponto_atendimento'] = $_POST['idt_ponto_atendimento'];
        $vet['hora_inicio'] = $_POST['hora_inicio'];
        $vet['hora_fim'] = $_POST['hora_fim'];
        $vet['hora_intervalo_inicio'] = $_POST['hora_intervalo_inicio'];
        $vet['hora_intervalo_fim'] = $_POST['hora_intervalo_fim'];
        $vet['idt_servico'] = $_POST['idt_servico'];
        $vet['data_aleatoria'] = $_POST['str_data_aleatoria'];
        $vet['observacao'] = $_POST['observacao'];
        $vet['existeagenda'] = 'N';
        $vet['memoria'] = 'S';
        $ret = CarregarAgendaExistente($idt_atendimento_gera_agenda, $vet);
        $vetAgenda = $vet['agenda'];

        $_SESSION[CS]['CarregarAgendaExistente'] = $vetAgenda;

        // retorno para javascript
        echo json_encode($vet);

        break;

    case 'CarregarAgendaExistente_dep':
        $vet = Array(
            'erro' => '',
        );
        $idt_atendimento_gera_agenda = $_POST['idt_atendimento_gera_agenda'];
        $vet['memoria'] = 'N';
        $ret = CarregarAgendaExistente($idt_atendimento_gera_agenda, $vet);
        $vetAgenda = $vet['agenda'];

        $_SESSION[CS]['CarregarAgendaExistente'] = $vetAgenda;

        // retorno para javascript
        echo json_encode($vet);

        break;

    case 'EscolherCampo':
        $idt_politica_parametro_tabelas = $_POST['opcao'];
        $sqlt = " select grc_ppc.* ";
        $sqlt .= " from " . db_pir_grc . "grc_politica_parametro_campos grc_ppc ";
        $sqlt .= " where idt_politica_parametro_tabelas = " . null($idt_politica_parametro_tabelas);
        $sqlt .= "   and ativo = " . aspa('S');
        $sqlt .= " order by codigo ";
        $rst = execsql($sqlt);

        echo "<table border='1' cellspacing='0' cellpadding='1' width='100%' style='width:100%; ' >";

        if ($rst->rows == 0) {
            
        } else {
            if ($idt_politica_parametro_tabelas == 1) {
                $tabela_escolhida = 'EVENTO';
            }
            if ($idt_politica_parametro_tabelas == 2) {
                $tabela_escolhida = 'PRODUTOS';
            }
            if ($idt_politica_parametro_tabelas == 3) {
                $tabela_escolhida = 'CLIENTES';
            }
            echo "<tr>";
            echo "<td colspan='2' style='font-size:14px; background:#C0C0C0; color:#FFFFFF; text-align:left; font-weight: normal;  ' >";
            echo "ESCOLHA O CAMPO PARA A TABELA " . $tabela_escolhida;
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td style='font-size:12px; background:#F1F1F1; color:#000000; text-align:center; font-weight: normal;  ' >";
            echo "CÓDIGO";
            echo "</td>";
            echo "<td style='font-size:12px; background:#C0C0C0; color:#000000; text-align:center; font-weight: normal;  ' >";
            echo "DESCRIÇÃO";
            echo "</td>";
            echo "</tr>";
            $hint = 'Clique para Selecionar o Campo';
            foreach ($rst->data as $rowt) {
                $idt = $rowt['idt'];
                $codigo = $rowt['codigo'];
                $descricao = $rowt['descricao'];
                echo "<tr>";
                $onclick = " onclick='return EscolheCampo($idt);' ";
                echo "<td title='{$hint}' id='codigo_{$idt}' {$onclick} class='escolha_tabela' style='font-size:18px; background:#FFFFFF; color:#000000; text-align:left; font-weight: normal;  ' >";
                echo $codigo;
                echo "</td>";
                echo "<td style='font-size:18px; background:#FFFFFF; color:#000000; text-align:left; font-weight: normal;  ' >";
                echo $descricao;
                echo "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
        break;






    case 'FunilMetasMobilizadoras':
        $vet = Array(
            'erro' => '',
        );
        
        $ret =  FunilExecutaJOB();

        //$ret = FunilAtualizaMeta();
		
        if ($ret == 0) {
            $vet['erro'] = rawurlencode("Existem problemas na execução desse JOB. Favor verificar.");
        }

        // retorno para javascript
        echo json_encode($vet);
        break;
		
		
    case 'BuscaAcompanhaClassificaxxxx';
	    $vet = Array(
            'erro' => '',
			'html' => '',
        );
		$html_acom  = "";
		$html_acom .= "<table>";
        $protocolo  = $_POST['protocolo'];
		$ano_base    = $_POST['anobase'];
		$html_acom .= "<tr>";
		$html_acom .= "<td>";
		$html_acom .= "Protocolo: $protocolo";
		$html_acom .= "</td>";
		$html_acom .= "</tr>";
		$html_acom .= "<tr>";
		$html_acom .= "<td>";
		$texto   = "";
		
	
		$caminho = "obj_file/funil/job_funil_ControleRelatorio_{$ano_base}.log";
		$fp      = fopen($caminho, "r"); 
		$texto = fread($fp, filesize ($caminho));
		fclose($fp);

		$texto = str_replace(chr(13),'<br />',$texto);
        //$vet = explode("=",$texto);
	    //$DataUltimaAtualizacao = $vet[1];
	    //$html .=  "Atualizado: {$DataUltimaAtualizacao}<br />";
	    $html_acom .= $texto;
	    $html_acom .= "</td>";
		$html_acom .= "</tr>";
        //if ($ret == 0) {
          //  $vet['erro'] = rawurlencode("Existem para Acompanhar execução de Job.");
        //}
        $html_acom .= "</table>";
		$vet['html'] = rawurlencode($html_acom);
        // retorno para javascript
        echo json_encode($vet);
	    break; 

    case 'FunilClassificaCliente':
        $vet = Array(
            'erro' => '',
        );
        
        $vetParametro = Array();
        $ret = FunilClassificaCliente($vetParametro);
        if ($ret == 0) {
            $vet['erro'] = rawurlencode("Existem problemas na execução desse JOB de Classificação do Cliente. Favor verificar.");
        }
        
        // retorno para javascript
        echo json_encode($vet);
        break;

    case 'GravaResumoAtendimento':
        $vet = Array(
            'erro' => '',
        );

        $veio = $_POST['veio'];
        $idt_acao = $_POST['idt_acao'];
        $idt_pendencia = $_POST['idt_pendencia'];
        $idt_atendimento = $_POST['idt_atendimento'];
        //
        $protocolo        = $_POST['protocolo'];
        $assunto          = utf8_decode($_POST['assunto']);
        $link_util        = $_POST['link_util'];
		$complemento_acao = utf8_decode($_POST['titulo']);


        $descricao = "";
        $descricao .= $assunto;
        $vetRetorno = Array();
        $vetRetorno['veio'] = $veio;
        $vetRetorno['idt_acao'] = $idt_acao;
		$vetRetorno['complemento_acao'] = $complemento_acao;
        $vetRetorno['idt_pendencia'] = $idt_pendencia;
        $vetRetorno['idt_atendimento'] = $idt_atendimento;
        $vetRetorno['descricao'] = $descricao;
        $vetRetorno['link_util'] = $link_util;
        // Gera no Resumo a Pendência		
        $ret = AtendimentoResumo($idt_atendimento, $vetRetorno);
        
        if ($ret == 0) {
            $vet['erro'] = rawurlencode("Existem problemas na Geração do Resumo do Atendimento. Favor verificar.");
        }
        
        // retorno para javascript
        echo json_encode($vet);
        break;
}