<?php
Require_Once('configuracao.php');

if (PHP_SAPI == 'cli') {
    $t = mb_strtolower($argv[1] . '/sebrae_grc/admin/funcao_' . $plu_sigla_interna . '.php');
    if (file_exists($t)) {
        Require_Once($t);
    }

    $t = mb_strtolower($argv[1] . '/sebrae_grc/admin/funcao_ger.php');
    if (file_exists($t)) {
        Require_Once($t);
    }
}

$grava_log = false;

//Envia email para o responsável pelo evento, gestor do projeto e gerente adjunto informando o atraso da PST em fazer o upload do distrato assinado
try {
    $msgParametros = function ($txt, $protocolo, $rowe) {
        $txt = str_replace('#protocolo', $protocolo, $txt);
        $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

        $sql = '';
        $sql .= ' select nome_completo';
        $sql .= ' from ' . db_pir_grc . 'plu_usuario';
        $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
        $rs = execsql($sql, false);
        $txt = str_replace('#solicitante', $rs->data[0][0], $txt);

        $sql = '';
        $sql .= ' select nome_completo';
        $sql .= ' from ' . db_pir_grc . 'plu_usuario';
        $sql .= ' where id_usuario = ' . null($rowe['idt_gestor_evento']);
        $rs = execsql($sql, false);
        $txt = str_replace('#evento_responsavel', $rs->data[0][0], $txt);

        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
        $rs = execsql($sql, false);
        $txt = str_replace('#ponto_atendimento', $rs->data[0][0], $txt);

        $txt = str_replace('#codigo', $rowe['codigo'], $txt);

        $sql = '';
        $sql .= ' select desccid';
        $sql .= ' from ' . db_pir_siac . 'cidade';
        $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
        $rs = execsql($sql, false);
        $txt = str_replace('#cidade', $rs->data[0][0], $txt);

        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_local_pa';
        $sql .= ' where idt = ' . null($rowe['idt_local']);
        $rs = execsql($sql, false);
        $txt = str_replace('#local', $rs->data[0][0], $txt);

        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
        $sql .= ' where idt = ' . null($_POST['situacao']);
        $rs = execsql($sql, false);

        if ($rs->rows == 0) {
            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
            $sql .= ' where idt = ' . null($rowe['idt_evento_situacao']);
            $rs = execsql($sql, false);
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
    };

    $vetGEC_parametros = Array();

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from ' . db_pir_gec . 'gec_parametros';
    $sql .= " where codigo in ('distrato_ap_09', 'distrato_ap_10')";
    $rs = execsql($sql);

    ForEach ($rs->data as $row) {
        $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
        $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");

        $vetGEC_parametros[$codigo] = $detalhe;
    }

    if ($vetConf['distrato_dias_sem_assinar_pst'] == '') {
        $limite = date('d/m/Y H:i:s');
    } else {
        $limite = date('d/m/Y H:i:s', strtotime('-' . $vetConf['distrato_dias_sem_assinar_pst'] . ' days'));
    }

    $sql = '';
    $sql .= ' select ccdp.idt, e.idt_instrumento, e.idt_unidade, e.idt_ponto_atendimento, s.classificacao, i.custo_total_real as vl_cotacao,';
    $sql .= ' ugp.email as ugp_email, ugp.nome_completo as ugp_nome, uge.email as uge_email, uge.nome_completo as uge_nome,';
    $sql .= ' e.idt_responsavel, e.idt_gestor_evento, e.idt_ponto_atendimento, e.codigo, e.idt_cidade, e.idt_local, e.idt_evento_situacao, i.descricao as instrumento,';
    $sql .= ' e.descricao, e.dt_previsao_inicial, e.dt_previsao_fim, e.hora_inicio, e.hora_fim, e.observacao, e.previsao_receita, e.previsao_despesa';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf ccdp';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_distrato ccd on ccd.idt = ccdp.idt_distrato';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo i on i.idt_gec_contratacao_credenciado_ordem = ord.idt and i.codigo = '71001'";
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
    $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao s on s.idt = e.idt_unidade';
    $sql .= ' left outer join ' . db_pir_grc . 'plu_usuario ugp on ugp.id_usuario = e.idt_gestor_projeto';
    $sql .= ' left outer join ' . db_pir_grc . 'plu_usuario uge on uge.id_usuario = e.idt_gestor_evento';
    $sql .= ' where ccdp.idt_atendimento is null';
    $sql .= ' and ccdp.arq_distrato_ass is null';
    $sql .= ' and ccdp.dt_atualizacao_registro <= ' . aspa(trata_data($limite));
    $rs = execsqlNomeCol($sql, false);

    foreach ($rs->data as $row) {
        $vetEnviar = Array();
        $vetEnviar[$row['ugp_email']] = $row['ugp_nome'];
        $vetEnviar[$row['uge_email']] = $row['uge_nome'];

        $vetUsuarioCG = CoordenadorGerenteDiretorEvento('CG', $row['idt_instrumento'], $row['idt_unidade'], $row['idt_ponto_atendimento'], $row['classificacao'], $row['vl_cotacao'], false, db_pir_grc);

        if (is_array($vetUsuarioCG)) {
            $sql = '';
            $sql .= ' select distinct u.email, u.nome_completo';
            $sql .= ' from ' . db_pir_grc . 'plu_usuario u ';
            $sql .= ' where id_usuario in (' . implode(', ', $vetUsuarioCG) . ')';
            $rsTmp = execsql($sql, false);

            foreach ($rsTmp->data as $rowTmp) {
                $vetEnviar[$rowTmp['email']] = $rowTmp['nome_completo'];
            }
        }

        foreach ($vetEnviar as $email => $nome) {
            if ($email != '') {
                if ($nome == '') {
                    $nome = $email;
                }

                $protocolo = date('dmYHis');

                $assunto = $msgParametros($vetGEC_parametros['distrato_ap_09'], $protocolo, $row);
                $mensagem = $msgParametros($vetGEC_parametros['distrato_ap_10'], $protocolo, $row);

                $mensagem = str_replace('#responsavel', $nome, $mensagem);

                $vetRegProtocolo = Array(
                    'protocolo' => $protocolo,
                    'origem' => 'distrato_ap_0910',
                );

                $return = enviarEmail(db_pir_pfo, $assunto, $mensagem, $email, $nome, true, $vetRegProtocolo);

                if ($return === true) {
                    $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf set dt_atualizacao_registro = now()';
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = '[Erro no envio do aviso da falta de upload do Distrato pela PST] ';
                    $erro .= $return;
                    erro_try($erro, 'executa_job', $vetRegProtocolo);
                }
            }
        }
    }

    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    grava_erro_log('executa_job', $e, '');
}

Require_Once('executa_job_rm.php');
Require_Once('executa_job_siacweb.php');

//grc_tema_subtema
try {
    $conSIAC = conSIAC();

    beginTransaction();

    $sql = "update grc_tema_subtema set ativo = 'N'";
    execsql($sql, false);

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from AREATEMATICA';
    $rsSIAC = execsql($sql, false, $conSIAC);

    ForEach ($rsSIAC->data as $row) {
        if ($row['temaprincipal'] == 1) {
            $nivel = 0;
            $codigo = substr($row['codareatematica'], 0, 2);
        } else {
            $nivel = 1;
            $codigo = substr($row['codareatematica'], 0, 2) . '.' . substr($row['codareatematica'], 2, 2);
        }

        if ($row['status'] == 1) {
            $ativo = 'S';
        } else {
            $ativo = 'N';
        }

        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_tema_subtema';
        $sql .= ' where rowguid = ' . aspa($row['rowguid']);
        $rs = execsql($sql, false);

        if ($rs->rows == 0) {
            $sql = 'insert into grc_tema_subtema (codigo, nivel, descricao, ativo, detalhe, palavras_chaves, rowguid) values (';
            $sql .= aspa($codigo) . ', ' . null($nivel) . ', ' . aspa($row['descareatematica']) . ', ' . aspa($ativo) . ', ' . aspa($row['conceito']) . ', ';
            $sql .= aspa($row['palavraschave']) . ', ' . aspa($row['rowguid']) . ')';
            execsql($sql, false);
        } else {
            $sql = 'update grc_tema_subtema set';
            $sql .= ' codigo = ' . aspa($codigo) . ',';
            $sql .= ' nivel = ' . aspa($nivel) . ',';
            $sql .= ' descricao = ' . aspa($row['descareatematica']) . ',';
            $sql .= ' ativo = ' . aspa($ativo) . ',';
            $sql .= ' detalhe = ' . aspa($row['conceito']) . ',';
            $sql .= ' palavras_chaves = ' . aspa($row['palavraschave']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, false);
        }
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//grc_foco_tematico
try {
    $conSIAC = conSIAC();

    beginTransaction();

    $sql = "update grc_foco_tematico set ativo = 'N'";
    execsql($sql, false);

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from FocoTematicoProdutoPortfolio';
    $rsSIAC = execsql($sql, false, $conSIAC);

    ForEach ($rsSIAC->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_foco_tematico';
        $sql .= ' where codigo = ' . aspa($row['codfocotematico']);
        $rs = execsql($sql, false);

        if ($rs->rows == 0) {
            $sql = 'insert into grc_foco_tematico (codigo, descricao, ativo, detalhe) values (';
            $sql .= aspa($row['codfocotematico']) . ', ' . aspa($row['nomefocotematico']) . ', ' . aspa($row['situacao']) . ', ' . aspa($row['descfocotematico']) . ')';
            execsql($sql, false);
        } else {
            $sql = 'update grc_foco_tematico set';
            $sql .= ' codigo = ' . aspa($row['codfocotematico']) . ',';
            $sql .= ' descricao = ' . aspa($row['nomefocotematico']) . ',';
            $sql .= ' ativo = ' . aspa($row['situacao']) . ',';
            $sql .= ' detalhe = ' . aspa($row['descfocotematico']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, false);
        }
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//grc_atendimento_instrumento
try {
    $conSIAC = conSIAC();

    beginTransaction();

    $sql = "update grc_atendimento_instrumento set ativo = 'N'";
    execsql($sql, false);

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from CategoriaAtendimento';
    $rsSIAC = execsql($sql, false, $conSIAC);

    ForEach ($rsSIAC->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_atendimento_instrumento';
        $sql .= ' where codigo_siacweb = ' . aspa($row['codcategoria']);
        $rs = execsql($sql, false);

        $codigo = $row['tipo'] . '.' . $row['codcategoria'];

        if ($rs->rows == 0) {
            $sql = 'insert into grc_atendimento_instrumento (codigo, codigo_siacweb, descricao, descricao_siacweb, ativo) values (';
            $sql .= aspa($codigo) . ', ' . aspa($row['codcategoria']) . ', ' . aspa($row['desccategoria']) . ', ' . aspa($row['desccategoria']) . ', ' . aspa($row['ativo']) . ')';
            execsql($sql, false);
        } else {
            $sql = 'update grc_atendimento_instrumento set';
            $sql .= ' codigo = ' . aspa($codigo) . ',';
            $sql .= ' descricao_siacweb = ' . aspa($row['desccategoria']) . ',';
            $sql .= ' ativo = ' . aspa($row['ativo']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, false);
        }
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//Verifica se pode mudar a competência do sistema
try {
    $sql = '';
    $sql .= ' select *';
    $sql .= ' from grc_competencia';
    $sql .= " where fechado = 'N'";
    $sql .= ' order by data_inicial limit 1';
    $rs = execsql($sql, false);

    if ($rs->rows > 0) {
        $row = $rs->data[0];

        $diff = diffDate(trata_data($row['data_final']), getdata(false, true), 'S');

        if ($diff >= 0) {
            beginTransaction();

            $sql = "update grc_competencia set fechado = 'S' where idt = " . null($row['idt']);
            execsql($sql, false);

            $ano = (int) $row['ano'];
            $mes = (int) $row['mes'] + 1;

            if ($mes == 13) {
                $mes = 1;
                $ano++;
            }

            if ($mes < 10) {
                $mes = '0' . $mes;
            }

            $fechado = 'N';

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_competencia';
            $sql .= ' where mes = ' . aspa($mes);
            $sql .= ' and ano = ' . aspa($ano);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $data_inicial = trata_data(date('d/m/Y', strtotime('+1 month', strtotime($row['data_inicial']))));
                $data_final = trata_data(date('d/m/Y', strtotime('+1 month', strtotime($row['data_final']))));
                $texto = $vetMes[$mes] . '/' . $ano;

                $sql = 'insert into grc_competencia (data_inicial, data_final, fechado, ano, mes, texto) values (';
                $sql .= aspa($data_inicial) . ', ' . aspa($data_final) . ', ' . aspa($fechado) . ', ' . aspa($ano) . ', ' . aspa($mes) . ', ' . aspa($texto);
                $sql .= ')';
                execsql($sql, false);
            }

            $mes = (int) $mes;
            $mes++;

            if ($mes == 13) {
                $mes = 1;
                $ano++;
            }

            if ($mes < 10) {
                $mes = '0' . $mes;
            }

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_competencia';
            $sql .= ' where mes = ' . aspa($mes);
            $sql .= ' and ano = ' . aspa($ano);
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $data_inicial = trata_data(date('d/m/Y', strtotime('+2 month', strtotime($row['data_inicial']))));
                $data_final = trata_data(date('d/m/Y', strtotime('+2 month', strtotime($row['data_final']))));
                $texto = $vetMes[$mes] . '/' . $ano;

                $sql = 'insert into grc_competencia (data_inicial, data_final, fechado, ano, mes, texto) values (';
                $sql .= aspa($data_inicial) . ', ' . aspa($data_final) . ', ' . aspa($fechado) . ', ' . aspa($ano) . ', ' . aspa($mes) . ', ' . aspa($texto);
                $sql .= ')';
                execsql($sql, false);
            }

            commit();

            carregaSession();
        }
    }

    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//gec_entidade_setor
try {
    $conSIAC = conSIAC();

    beginTransaction();

    $sql = "update " . db_pir_gec . "gec_entidade_setor set ativo = 'N'";
    execsql($sql, false);

    $sql = '';
    $sql .= ' select *';
    $sql .= ' from setor';
    $rsSIAC = execsql($sql, false, $conSIAC);

    ForEach ($rsSIAC->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade_setor';
        $sql .= ' where codigo = ' . aspa($row['codsetor']);
        $rs = execsql($sql, false);

        if ($rs->rows == 0) {
            $sql = 'insert into ' . db_pir_gec . 'gec_entidade_setor (codigo, descricao, ativo) values (';
            $sql .= aspa($row['codsetor']) . ', ' . aspa($row['descsetor']) . ', ' . aspa($row['situacao']) . ')';
            execsql($sql, false);
        } else {
            $sql = 'update ' . db_pir_gec . 'gec_entidade_setor set';
            $sql .= ' descricao = ' . aspa($row['descsetor']) . ',';
            $sql .= ' ativo = ' . aspa($row['situacao']);
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, false);
        }
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//cnae no GEC
try {
    $conSIAC = conSIAC();

    beginTransaction();

    $vetSetor = Array();

    $sql = '';
    $sql .= ' select idt, codigo';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_setor';
    $rs = execsql($sql, false);

    foreach ($rs->data as $row) {
        $vetSetor[$row['codigo']] = $row['idt'];
    }

    $sql = "update " . db_pir_gec . "cnae set existe_siacweb = 'N'";
    execsql($sql, false);

    $sql = '';
    $sql .= ' select codclass, codativecon, descativecon, descabrevativ, codsetor, null as codcnaefiscal';
    $sql .= ' from ativeconomica';
    $sql .= ' union all';
    $sql .= ' select a.codclass, a.codativecon, null as descativecon, cf.desccnaefiscal as descabrevativ, a.codsetor, cf.codcnaefiscal';
    $sql .= ' from ativeconomica a';
    $sql .= ' inner join cnaefiscal cf on cf.codativecon = a.codativecon';
    $sql .= ' order by codativecon, codcnaefiscal';
    $rsSIAC = execsql($sql, false, $conSIAC);

    ForEach ($rsSIAC->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from ' . db_pir_gec . 'cnae';
        $sql .= ' where codclass_siacweb = ' . null($row['codclass']);
        $sql .= ' and codativecon_siacweb = ' . aspa($row['codativecon']);

        if ($row['codcnaefiscal'] == '') {
            $sql .= ' and codcnaefiscal_siacweb is null';
        } else {
            $sql .= ' and codcnaefiscal_siacweb = ' . aspa($row['codcnaefiscal']);
        }

        $rs = execsql($sql, false);

        if ($rs->rows == 0) {
            $divisao = substr($row['codativecon'], 0, 2);
            $grupo = substr($row['codativecon'], 0, 3);

            if (strlen($grupo) != 3) {
                $grupo = '';
            }

            if ($grupo != '') {
                $grupo = substr($grupo, 0, 2) . '.' . substr($grupo, 2, 1);
            }

            $classe = $row['codativecon'];

            if (strlen($classe) != 5) {
                $classe = '';
            }

            if ($classe != '') {
                $classe = substr($classe, 0, 2) . '.' . substr($classe, 2, 2) . '-' . substr($classe, 4, 1);
            }

            $subclasse = $row['codcnaefiscal'];

            if ($subclasse != '') {
                $subclasse = substr($row['codativecon'], 0, 4) . '-' . substr($row['codativecon'], 4, 1) . '/' . $subclasse;
            }

            $codigo = '#' . $divisao;

            if ($grupo != '') {
                $codigo .= '#' . $grupo;
            }

            if ($classe != '') {
                $codigo .= '#' . $classe;
            }

            if ($subclasse != '') {
                $codigo .= '#' . $subclasse;
            }

            $sql = 'insert into ' . db_pir_gec . 'cnae (codigo, descricao, detalhe, divisao, grupo, classe, ';
            $sql .= 'subclasse, codclass_siacweb, codativecon_siacweb, codcnaefiscal_siacweb, codsetor_siacweb, idt_entidade_setor, existe_siacweb) values (';
            $sql .= aspa($codigo) . ', ' . aspa($row['descabrevativ']) . ', ' . aspa($row['descativecon']) . ', ' . aspa($divisao) . ', ' . aspa($grupo) . ', ' . aspa($classe) . ', ';
            $sql .= aspa($subclasse) . ', ' . null($row['codclass']) . ', ' . aspa($row['codativecon']) . ', ' . aspa($row['codcnaefiscal']) . ', ' . null($row['codsetor']) . ', ' . null($vetSetor[$row['codsetor']]) . ", 'S')";
            execsql($sql, false);
        } else {
            $sql = 'update ' . db_pir_gec . 'cnae set';
            $sql .= ' descricao = ' . aspa($row['descabrevativ']) . ',';
            $sql .= ' detalhe = ' . aspa($row['descativecon']) . ',';
            $sql .= ' codsetor_siacweb = ' . null($row['codsetor']) . ',';
            $sql .= ' idt_entidade_setor = ' . null($vetSetor[$row['codsetor']]) . ',';
            $sql .= " existe_siacweb = 'S'";
            $sql .= ' where idt = ' . null($rs->data[0][0]);
            execsql($sql, false);
        }
    }

    commit();
    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//Verifica se pode mudar a situação do Evento
try {
    beginTransaction();

    mudaSituacaoEvento(false, 'Execução do JOB');

    commit();

    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

//Envia o email da Lista de Presença dos eventos
try {
    if ($vetConf['evento_lista_presenca_dias_email'] == '') {
        $limite = date('d/m/Y');
    } else {
        $limite = date('d/m/Y', strtotime('+' . $vetConf['evento_lista_presenca_dias_email'] . ' days'));
    }

    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento';
    $sql .= ' where dt_previsao_inicial <= ' . aspa(trata_data($limite));
    $sql .= " and email_enviado_lista_presenca = 'N'";
    $sql .= " and idt_evento_situacao in (14, 15, 16, 19, 20)";
    $sql .= " and idt_instrumento not in (52, 54)";
    $rs = execsql($sql, false);

    foreach ($rs->data as $row) {
        $vetDados = Array(
            'id' => $row['idt'],
            'linha_vazia' => 'S',
            'concluio' => '',
            'contrato' => Array(
                'R' => 'R',
                'A' => 'A',
                'C' => 'C',
                'G' => 'G',
                'S' => 'S',
                'IC' => 'IC',
            ),
        );

        $vetErroMsg = enviaEmailEventoAcompanharLista($vetDados, false);

        if (count($vetErroMsg) == 0) {
            $sql = "update grc_evento set email_enviado_lista_presenca = 'S'";
            $sql .= ' where idt = ' . null($row['idt']);
            execsql($sql, false);
        } else {
            $erro = '[Erro no envio da Lista de Presença] ';
            $erro .= implode(", ", $vetErroMsg);
            erro_try($erro, 'executa_job', $vetDados);
        }
    }

    $grava_log = true;
} catch (Exception $e) {
    if ($fim != 'N') {
        p($e);
        exit();
    }

    rollBack();
    grava_erro_log('executa_job', $e, '');
}

Require_Once('executa_job_sge.php');

if ($grava_log) {
    grava_log_sis('executa_job', 'R', '', '', 'Controle de Execução do JOB');
}

if ($fim != 'N') {
    echo 'FIM...';
}