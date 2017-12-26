<?php
require_once 'configuracao.php';

$sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade, prd.codigo as codigo_produto";
$sql .= ' from grc_evento grc_e';
$sql .= ' inner join grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
$sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
$sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
$sql .= ' left outer join grc_produto prd on prd.idt = grc_e.idt_produto';
$sql .= " where grc_e.idt_evento_situacao = 14";
$sql .= ' and grc_e.codigo_siacweb is null';
$sql .= ' and grc_e.idt_instrumento not in (2, 45)';
$rs = execsql($sql);

foreach ($rs->data as $rowe) {
    beginTransaction();

    //AGENDADO
    if ($rowe['tipo_ordem'] == 'SG') {
        $erro = '';

        $sql = 'update grc_evento set qtd_minima_pagantes = quantidade_participante';
        $sql .= " where idt = " . null($rowe['idt']);
        execsql($sql);

        $sql = '';
        $sql .= ' select gec_ord.idt_gec_contratacao_status, gec_ord.rm_consolidado, gec_ol.idt_organizacao, gec_ol.idt_gec_contratacao_credenciado_ordem';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem gec_ord';
        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ol on gec_ord.idt = gec_ol.idt_gec_contratacao_credenciado_ordem";
        $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_ol.idt_organizacao = gec_o.idt";
        $sql .= ' where gec_ord.idt_evento = ' . null($rowe['idt']);
        $sql .= " and gec_ol.ativo = 'S'";
        $rsi = execsql($sql);
        $rowi = $rsi->data[0];

        if ($rsi->rows == 0) {
            $erro = 'Não tem o registro do indicado na ordem de contratação (Credenciado)!';
        } else if ($rowi['idt_gec_contratacao_status'] != 9) {
            $erro = 'A ordem de contratação (Credenciado) não foi concluida!';
        } else if ($rowi['idt_organizacao'] == '') {
            $erro = 'Tem que informar a Organização do Indicado na ordem de contratação (Credenciado)!';
        } else {
            $sql = '';
            $sql .= ' select rm_idmov';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
            $sql .= ' and rm_idmov is not null';
            $rs = execsql($sql);

            if ($rs->rows > 0) {
                $erro = 'Não tem informação para fazer a consolidação do realizado!';
            } else {
                $sql = '';
                $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);

                $sql = '';
                $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);

                $sql = '';
                $sql .= ' select idt_produto_tipo';
                $sql .= ' from grc_produto';
                $sql .= ' where idt = ' . null($rowe['idt_produto']);
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
                $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda (idt_gec_contratacao_credenciado_ordem, idt_evento, tipo, dt_ini, dt_fim, tot_hora, obs)';
                $sql .= " select {$rowi['idt_gec_contratacao_credenciado_ordem']} as idt_gec_contratacao_credenciado_ordem, ea.idt_evento, '{$tipo}' as tipo, ea.dt_ini, ea.dt_fim, ea.carga_horaria as tot_hora, ea.observacao as obs";
                $sql .= ' from grc_evento_agenda ea';
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                $sql .= ' where ea.idt_evento = ' . $rowe['idt'];
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                execsql($sql);

                $sql = '';
                $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                $sql .= " and tipo = 'C'";
                $rsa = execsql($sql);
                $rowa = $rsa->data[0];

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                $sql .= ' agenda_consultoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
                $sql .= ' agenda_consultoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
                $sql .= ' agenda_consultoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
                $sql .= ' agenda_consultoria_tot_hora = ' . null($rowa['tot_hora']);
                $sql .= ' where idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);

                $sql = '';
                $sql .= ' select min(dt_ini) as dt_ini, max(dt_fim) as dt_fim, sum(tot_hora) as tot_hora, avg(tot_hora) as carga_horaria';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                $sql .= " and tipo = 'I'";
                $rsa = execsql($sql);
                $rowa = $rsa->data[0];

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                $sql .= ' agenda_instrutoria_dt_ini = ' . aspa($rowa['dt_ini']) . ',';
                $sql .= ' agenda_instrutoria_dt_fim = ' . aspa($rowa['dt_fim']) . ',';
                $sql .= ' agenda_instrutoria_carga_horaria = ' . null($rowa['carga_horaria']) . ',';
                $sql .= ' agenda_instrutoria_tot_hora = ' . null($rowa['tot_hora']);
                $sql .= ' where idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);

                if ($rowe['nao_sincroniza_rm'] == 'N') {
                    if ($rowi['rm_consolidado'] == 'N') {
                        $vetErro = rmConsolidacaoPrevista($rowi['idt_gec_contratacao_credenciado_ordem'], 'valor_real');
                    } else {
                        $vetErro = Array();
                    }

                    if (count($vetErro) > 0) {
                        $erro = implode('<br />', $vetErro);
                    } else {
                        $vetErro = rmConsolidacaoRealizado($rowi['idt_gec_contratacao_credenciado_ordem']);

                        if (count($vetErro) > 0) {
                            $erro = implode('<br />', $vetErro);
                        } else {
                            $sql = '';
                            $sql .= ' select gec_ol.idt';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista gec_ol';
                            $sql .= ' where gec_ol.idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                            $sql .= " and gec_ol.ativo = 'S'";
                            $rs = execsql($sql);

                            geraContratoOrdemContratacao($rs->data[0][0]);
                        }
                    }
                } else {
                    $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem set rm_consolidado = 'R'";
                    $sql .= ' where idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                    execsql($sql);

                    $sql = '';
                    $sql .= ' select gec_ol.idt';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista gec_ol';
                    $sql .= ' where gec_ol.idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                    $sql .= " and gec_ol.ativo = 'S'";
                    $rs = execsql($sql);

                    geraContratoOrdemContratacao($rs->data[0][0]);
                }
            }
        }

        if ($erro != '') {
            rollBack();

            $sql = '';
            $sql .= " select ord.idt, ord.codigo";
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord';
            $sql .= ' where ord.idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
            $rs = execsql($sql);
            $rowo = $rs->data[0];

            //Verifica lixo no RM
            if ($rowo['codigo'] != '') {
                $chave_origem = 'GC' . $rowo['codigo'];
                $mensagemRM = 'Erro na Aprovação do Evento';
                $vetIdMov = Array();

                CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);

                $sql = '';
                $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);

                $sql = '';
                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                $sql .= " rm_consolidado = 'N'";
                $sql .= ' where idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                execsql($sql);
            }

            $erro = 'Erro na geração da Ordem de Contratação.<br />' . $erro;
            erro_try($erro, 'evento_aprovacao');
            msg_erro($erro);
        }

        //sincronização com o RM
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento';
        $sql .= ' where idt_evento = ' . null($rowe['idt']);
        $rsa = execsql($sql);

        foreach ($rsa->data as $rowa) {
            sincronizaAtendimentoGEC($rowa['idt']);

            if ($rowe['nao_sincroniza_rm'] == 'N') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_sincroniza_siac';
                $sql .= ' where idt_atendimento = ' . null($rowa['idt']);
                $sql .= " and tipo = 'RM_INC'";
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, tipo) values (';
                    $sql .= null($rowa['idt']) . ', ' . null($rowe['idt']) . ", 'RM_INC')";
                    execsql($sql);
                } else {
                    $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                    $sql .= ' where idt = ' . null($rst->data[0][0]);
                    execsql($sql);
                }
            }
        }
    } else {
        $gera_ordem = false;
        $automatico = false;
        $usa_rodizio = true;

        if ($rowe['cred_necessita_credenciado'] == 'S' && $rowe['cred_rodizio_auto'] == 'S') {
            $gera_ordem = true;
            $automatico = true;
        }

        if ($rowe['cred_necessita_credenciado'] == 'S' && $rowe['cred_rodizio_auto'] == 'N' && $rowe['cred_credenciado_sgc'] == 'S') {
            $gera_ordem = true;
            $automatico = false;
        }

        //Não fazer rodizio em Produção
        //if (debug !== true) {
        $usa_rodizio = false;
        //}

        if ($gera_ordem) {
            $variavel = array();
            $ret = GEC_contratacao_credenciado_ordem($rowe['idt'], $variavel, $automatico, $usa_rodizio, false);

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
                msg_erro($variavel['erro']);
            }
        }
    }

    $vetEV = Array();

    if ($rowe['composto'] == 'S') {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_evento';
        $sql .= ' where idt_evento_pai = ' . null($rowe['idt']);
        $rst = execsql($sql);

        foreach ($rst->data as $rowt) {
            $vetEV[] = $rowt['idt'];
        }
    } else {
        $vetEV[] = $rowe['idt'];
    }

    foreach ($vetEV as $idt_evento_tmp) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_sincroniza_siac';
        $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
        $sql .= " and tipo = 'EV'";
        $rst = execsql($sql);

        if ($rst->rows == 0) {
            $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo, representa) values (';
            $sql .= null($idt_evento_tmp) . ", 'EV', 'N')";
            execsql($sql);
        } else {
            $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null, representa = 'N'";
            $sql .= ' where idt = ' . null($rst->data[0][0]);
            execsql($sql);
        }
    }
    
    commit();
}

echo 'FIM...';
