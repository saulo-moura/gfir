<?php
$conSIAC = conSIAC();

$codsebrae = 26;
$qtdErro = 0;
$vetErro = Array();

if ($ssaMostrarErro == '') {
    $ssaMostrarErro = 'S';
}

$usaTransaction = true;
$ativoTransaction = false;
$ativoTransactionSIAC = false;
$wherePersonalizado = '';

if ($ssaIdtEvento == '') {
    $wherePersonalizado .= ' and (s.idt_evento is null or (s.idt_evento is not null and s.dt_registro <= ' . aspa(trata_data(date('d/m/Y H:i:s', strtotime('-30 minutes')), true)) . '))';
} else {
    $usaTransaction = false;
    $wherePersonalizado .= ' and s.idt_evento in (' . $ssaIdtEvento . ')';
}

if ($ssaIdtAtendimento != '') {
    $usaTransaction = false;
    $wherePersonalizado .= ' and s.idt_atendimento in (' . $ssaIdtAtendimento . ')';
}

if ($ssaIdtPagamento != '') {
    $usaTransaction = false;
    $wherePersonalizado .= ' and s.idt_evento_participante_pagamento = ' . null($ssaIdtPagamento);
}

if ($ssaIdtEntidade != '') {
    $usaTransaction = false;
    $wherePersonalizado .= ' and s.idt_entidade = ' . null($ssaIdtEntidade);
    $wherePersonalizado .= " and tipo = 'E'";
}

try {
    $SebraeSIACevt = new SebraeSIAC('SiacWEB_EventosWS', 'even');
    $SebraeSIAChist = new SebraeSIAC('SiacWEB_HistoricoWS', 'his');
    $SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');
    $SoapSebraeRM_CS = new SoapSebraeRMGeral('wsConsultaSQL');
    $SoapSebraeRM_PR = new SoapSebraeRMGeral('wsProcess', true);

    $whereEventoInstrumento = ' and e.idt_instrumento in (40, 47, 46, 49, 50)';

    $vetTipoInformacao = Array();

    $sql = '';
    $sql .= ' select idt, codigo';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_tipo_informacao';
    $rs = execsql($sql, false);

    foreach ($rs->data as $row) {
        $vetTipoInformacao[$row['idt']] = $row['codigo'];
    }

    $vetPorteLimite = Array();

    $sql = '';
    $sql .= ' select codporte, numminfunc as min, nummaxfunc as max';
    $sql .= ' from ' . db_pir_siac . 'porte';
    $sql .= ' where codporte = 99';
    $rs = execsql($sql, false);

    foreach ($rs->data as $row) {
        $vetPorteLimite[$row['codporte']] = $row;
    }

    $sql = '';
    $sql .= ' select s.idt, s.idt_atendimento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= " where s.tipo = 'H'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacH = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.dt_previsao_inicial is not null';
    $sql .= ' and e.dt_previsao_fim is not null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_EXC = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento, u.codparceiro_siacweb as codresponsavel';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= ' left outer join plu_usuario u on u.id_usuario = s.idt_responsavel';
    $sql .= " where s.tipo = 'EV_CON'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_CON = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV_DESCON'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_DESCON = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EP'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEP = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EP_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $whereEventoInstrumento;
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEP_EXC = execsql($sql, false);

    //Consultoria de Longa Duração

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= ' and e.dt_previsao_inicial is not null';
    $sql .= ' and e.dt_previsao_fim is not null';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento, s.idt_atendimento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EP'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= ' and e.idt_evento_situacao in (14, 16, 19, 20)';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEP_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento, s.idt_atendimento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EP_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEP_EXC_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento, s.idt_evento_atividade, p.siacweb_codcosultoria as codconsultoria, p.idt as idt_atendimento_pessoa, s.idt_atendimento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = s.idt_atendimento';
    $sql .= " where s.tipo = 'EV_CON_AT'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_CON_AT_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento_atividade, p.siacweb_codcosultoria as codconsultoria, p.idt as idt_atendimento_pessoa, s.idt_atendimento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = s.idt_atendimento';
    $sql .= " where s.tipo = 'EV_AT_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_AT_EXC_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento, u.codparceiro_siacweb as codresponsavel';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= ' left outer join plu_usuario u on u.id_usuario = s.idt_responsavel';
    $sql .= " where s.tipo = 'EV_CON'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_CON_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV_DESCON'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_DESCON_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'EV_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento = 2';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacEV_EXC_CLD = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt_entidade, e.codigo_siacweb, group_concat(s.idt) as idts,';
    $sql .= ' group_concat(s.idt_atendimento_pessoa) as idt_atendimento_pessoa_lst, group_concat(s.idt_atendimento) as idt_atendimento_lst';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = s.idt_entidade';
    $sql .= " where s.tipo = 'E'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= $wherePersonalizado;
    $sql .= ' group by s.idt_entidade, e.codigo_siacweb';
    $sql .= ' order by s.tipo_entidade, s.idt';
    $rs_siac = execsql($sql, false);
} catch (SoapFault $e) {
    $qtdErro++;
    $vetErro[] = grava_erro_log('sincroniza_siac', $e, '');
} catch (Exception $e) {
    $qtdErro++;
    $vetErro[] = grava_erro_log('sincroniza_siac', $e, $sql);
}

if ($qtdErro == 0) {
foreach ($rs_siac->data as $row_siac) {
    try {
        set_time_limit(300);
        $duplicado = '';

        $sql = '';
        $sql .= ' select e.tipo_entidade, e.codigo, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_organizacao o on o.idt_entidade = e.idt';
        $sql .= ' where e.idt = ' . null($row_siac['idt_entidade']);
        $rs = execsql($sql, false);
        $row_ent = $rs->data[0];

        if ($rs->rows > 0) {
            if ($row_ent['tipo_entidade'] == 'P') {
                $tipoparceiro = 'F';
            } else {
                $tipoparceiro = 'J';
            }

            $codparceiro = codParceiroSiacWeb($tipoparceiro, $duplicado, $row_ent['codigo'], $row_ent['nirf'], $row_ent['dap'], $row_ent['rmp'], $row_ent['ie_prod_rural'], $row_ent['sicab_codigo']);

            if ($codparceiro == '' && substr($row_siac['codigo_siacweb'], 0, 2) != '99') {
                $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
            }

            if ($row_siac['codigo_siacweb'] != $codparceiro && $codparceiro != '') {
                if ($usaTransaction) {
                    beginTransaction();
                    $ativoTransaction = true;
                }

                updateCodSiacweb($row_siac['codigo_siacweb'], $codparceiro, $tipoparceiro);
                $row_siac['codigo_siacweb'] = $codparceiro;

                if ($usaTransaction) {
                    commit();
                    $ativoTransaction = false;
                }
            }
        }

        if ($duplicado != '') {
            $qtdErro++;
            $erro = "Registro duplicado no SiacWeb!" . $duplicado;

            $vetErro[] = $erro;
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idts'] . ')', 'sincroniza_siac_duplicado', $row_siac);

            $sql = 'update grc_sincroniza_siac set';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= ' erro = ' . aspa($erro);
            $sql .= ' where idt in (' . $row_siac['idts'] . ')';
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' select e.reg_situacao, e.tipo_entidade, e.codigo, e.descricao, e.resumo, t.codigo as codconst, e.siacweb_situacao';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_tipo_emp t on t.idt = e.idt_entidade_tipo_emp';
            $sql_ent = $sql;

            $sql .= ' where e.idt = ' . null($row_siac['idt_entidade']);
            $rs = execsql($sql, false);

            if ($rs->data[0]['reg_situacao'] != 'A') {
                $row_siac['idt_entidade'] = idtEntidadeGEC($row_ent['tipo_entidade'], $row_ent['codigo'], $row_ent['nirf'], $row_ent['dap'], $row_ent['rmp'], $row_ent['ie_prod_rural'], $row_ent['sicab_codigo']);

                $sql = $sql_ent;
                $sql .= ' where e.idt = ' . null($row_siac['idt_entidade']);
                $rs = execsql($sql, false);
            }

            if ($rs->rows == 0) {
                $qtdErro++;
                $erro = "Código SIAC \"" . $row_siac['codigo_siacweb'] . "\" não localizado no tabela de parceiro no sistema PIR!";

                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idts'] . ')', 'sincroniza_siac', $row_siac);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= ' erro = ' . aspa($erro);
                $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                execsql($sql, false);
            } else {
                $vetErroCons = Array();
                $row = $rs->data[0];

                if ($row['siacweb_situacao'] === '') {
                    $row['siacweb_situacao'] = 1;
                }

                $sql = '';
                $sql .= ' select o.*';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade_endereco o';
                $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                $sql .= " and o.idt_entidade_endereco_tipo = 8";
                $rs = execsql($sql, false);
                $rowe = $rs->data[0];

                $sql = '';
                $sql .= ' select o.*';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao o';
                $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                $sql .= " and o.origem = 'ATENDIMENTO PRINCIPAL'";
                $rs = execsql($sql, false);
                $rowc1 = $rs->data[0];

                $sql = '';
                $sql .= ' select o.*';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao o';
                $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                $sql .= " and o.origem = 'ATENDIMENTO RECADO'";
                $rs = execsql($sql, false);
                $rowc2 = $rs->data[0];

                //beginTransaction($conSIAC);
                //$ativoTransactionSIAC = true;

                if ($row['tipo_entidade'] == 'O') {
                    $tipoparceiro = 'J';
                } else {
                    $tipoparceiro = 'F';
                }

                if (substr($row['codigo'], 0, 2) == 'PR') {
                    $cgccpf = '';
                } else {
                    $cgccpf = preg_replace('/[^0-9]/i', '', $row['codigo']);
                }

                if ($row['tipo_entidade'] == 'P') {
                    $sql = '';
                    $sql .= ' select o.data_nascimento, f.codigo as codgrauescol, s.codigo as cod_sexo, ae.codigo as codatividadepf';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_pessoa o';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_grau_formacao f on f.idt = o.idt_escolaridade';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_sexo s on s.idt = o.idt_sexo';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_ativeconpf ae on ae.idt = o.idt_ativeconpf';
                    $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                    $rsp = execsql($sql, false);
                    $rowp = $rsp->data[0];

                    if ($rowp['codatividadepf'] == '') {
                        $rowp['codatividadepf'] = 1000;
                    }

                    if ($rowp['cod_sexo'] == 2) {
                        $sexo = 0;
                    } else {
                        $sexo = 1;
                    }

                    $receberrmail = 'N';
                    $recebermala = 'N';
                    $recebersms = 'N';
                    $recebertelefone = 'N';

                    $sql = '';
                    $sql .= ' select idt_tipo_informacao';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
                    $sql .= ' where idt = ' . null($row_siac['idt_entidade']);
                    $rs_ti = execsql($sql, false);

                    foreach ($rs_ti->data as $row_ti) {
                        switch ($row_ti['idt_tipo_informacao']) {
                            case 1:
                                if ($rowc1['telefone_1'] == '') {
                                    $sql = '';
                                    $sql .= ' delete from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
                                    $sql .= ' where idt = ' . null($row_siac['idt_entidade']);
                                    $sql .= ' and idt_tipo_informacao = ' . null($row_ti['idt_tipo_informacao']);
                                    execsql($sql, false);
                                } else {
                                    $recebertelefone = 'S';
                                }
                                break;

                            case 2:
                                $recebermala = 'S';
                                break;

                            case 3:
                                $receberrmail = 'S';
                                break;

                            case 4:
                                $recebersms = 'S';
                                break;
                        }
                    }

                    $vetPar = array(
                        'CodParceiro' => $row_siac['codigo_siacweb'],
                        'CgcCpf' => $cgccpf,
                        'Senha' => 'senhapadrao',
                        'NomeCompleto' => $row['descricao'],
                        'NomeAbrevFantasia' => $row['resumo'],
                        'CodGrauEscol' => $rowp['codgrauescol'],
                        'DataNasc' => $rowp['data_nascimento'],
                        'Sexo' => $sexo,
                        'DescEndereco' => $rowe['logradouro'],
                        'Cep' => preg_replace('/[^0-9]/i', '', $rowe['logradouro_cep']),
                        'CodPais' => $rowe['logradouro_codpais'],
                        'CodEst' => $rowe['logradouro_codest'],
                        'CodCid' => $rowe['logradouro_codcid'],
                        'CodBairro' => $rowe['logradouro_codbairro'],
                        'Complemento' => $rowe['logradouro_numero'] . ' / ' . $rowe['logradouro_complemento'],
                        'EndInternacional' => '',
                        'Email' => $rowc1['email_1'],
                        'TelResidencial' => preg_replace('/[^0-9]/i', '', $rowc1['telefone_1']),
                        'TelComercial' => preg_replace('/[^0-9]/i', '', $rowc2['telefone_1']),
                        'TelCelular' => preg_replace('/[^0-9]/i', '', $rowc1['telefone_2']),
                        'CodClassificacao' => 1,
                        'CodAtividadePF' => $rowp['codatividadepf'],
                        'Situacao' => $row['siacweb_situacao'],
                        'ReceberEmail' => $receberrmail,
                        'ReceberMala' => $recebermala,
                        'ReceberSMS' => $recebersms,
                        'ReceberTelefone' => $recebertelefone,
                        'CpfResponsavel' => '',
                    );

                    foreach ($vetPar as $key => $value) {
                        switch ($key) {
                            case 'DataNasc':
                                $value = trata_data($value, false, true);

                                $vetDT = DatetoArray($value);

                                if (diffDate($value, Date('d/m/Y')) < 0 || $vetDT['ano'] > Date('Y')) {
                                    $vetErroCons[] = "A Data de Nascimento não pode ser maior que hoje!";
                                }

                                $value = str_replace('/', '', $value);

                                if ($value == '') {
                                    $value = ' ';
                                }
                                break;

                            case 'CodGrauEscol':
                            case 'CodPais':
                            case 'CodEst':
                            case 'CodCid':
                            case 'CodBairro':
                                if ($value == '') {
                                    $value = '0';
                                }
                                break;

                            case 'Sexo':
                                break;

                            default:
                                if ($value == '') {
                                    $value = ' ';
                                }
                                break;
                        }

                        //$vetPar[$key] = str_replace('|', '/', $value);
                        $vetPar[$key] = $value;
                    }

                    if (substr($vetPar['CodParceiro'], 0, 2) == '99') {
                        $vetTmp = $vetPar;

                        unset($vetTmp['CodParceiro']);

                        $parametro = $vetTmp;

                        $metodo = 'Trans_Ins_CadastroPF';
                    } else {
                        $vetTmp = $vetPar;

                        unset($vetTmp['Senha']);

                        $parametro = $vetTmp;

                        $metodo = 'Trans_Alt_CadastroPF';
                    }
                } else {
                    $sql = '';
                    $sql .= ' select e.idt_ult_representante_emp, e.representa_codcargcli';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
                    $sql .= ' where idt = ' . null($row_siac['idt_entidade']);
                    $rs = execsql($sql, false);
                    $rowp = $rs->data[0];
                    $idt_ult_representante_emp = $rowp['idt_ult_representante_emp'];
                    $cargo = $rowp['representa_codcargcli'];

                    $sql = '';
                    $sql .= ' select codigo';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade';
                    $sql .= ' where idt = ' . null($idt_ult_representante_emp);
                    $rs = execsql($sql, false);
                    $cpf = preg_replace('/[^0-9]/i', '', $rs->data[0][0]);

                    if ($row_siac['idt_atendimento_lst'] != '') {
                        if ($cpf == '') {
                            $sql = '';
                            $sql .= ' select cpf';
                            $sql .= ' from grc_atendimento_pessoa';
                            $sql .= ' where idt_atendimento in (' . $row_siac['idt_atendimento_lst'] . ')';
                            $sql .= " and tipo_relacao = 'L'";
                            $sql .= ' and cpf is not null';
                            $sql .= ' order by idt desc';
                            $rs = execsql($sql, false);
                            $cpf = preg_replace('/[^0-9]/i', '', $rs->data[0][0]);
                        }

                        if ($cargo == '') {
                            $sql = '';
                            $sql .= ' select representa_codcargcli';
                            $sql .= ' from grc_atendimento_organizacao';
                            $sql .= ' where idt_atendimento in (' . $row_siac['idt_atendimento_lst'] . ')';
                            $sql .= " and representa = 'S'";
                            $sql .= " and desvincular = 'N'";
                            $sql .= ' and representa_codcargcli is not null';
                            $sql .= ' order by idt desc';
                            $rs = execsql($sql, false);
                            $cargo = $rs->data[0][0];
                        }
                    }

                    $sql = '';
                    $sql .= ' select o.*, p.codigo as faturam';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_organizacao o';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_organizacao_porte p on p.idt = o.idt_porte';
                    $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                    $rsp = execsql($sql, false);
                    $rowp = $rsp->data[0];

                    $sql = '';
                    $sql .= ' select o.*, c.codsetor_siacweb as codsetor';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_cnae o';
                    $sql .= ' left outer join ' . db_pir_gec . 'cnae c on c.subclasse = o.cnae';
                    $sql .= ' where o.idt_entidade = ' . null($row_siac['idt_entidade']);
                    $sql .= " and o.principal = 'S'";
                    $rst = execsql($sql, false);
                    $rowt = $rst->data[0];
                    $codigoativeconomica = '01' . preg_replace('/[^0-9]/i', '', $rowt['cnae']);

                    if ($rowp['simples_nacional'] == 'S') {
                        $optantesimplesnacional = 0;
                    } else {
                        $optantesimplesnacional = 1;
                    }

                    if (is_array($vetPorteLimite[$rowp['faturam']])) {
                        $altReg = false;
                        $limite = $vetPorteLimite[$rowp['faturam']];

                        if ($rowp['qt_funcionarios'] < $limite['min']) {
                            $altReg = true;
                            $rowp['qt_funcionarios'] = $limite['min'];
                        }

                        if ($rowp['qt_funcionarios'] > $limite['max']) {
                            $altReg = true;
                            $rowp['qt_funcionarios'] = $limite['max'];
                        }

                        if ($altReg) {
                            $sql = '';
                            $sql .= ' update ' . db_pir_gec . 'gec_entidade_organizacao set';
                            $sql .= ' qt_funcionarios = ' . null($rowp['qt_funcionarios']);
                            $sql .= ' where idt = ' . null($rowp['idt']);
                            execsql($sql, false);
                        }
                    }

                    $vetPar = array(
                        'CodParceiroPJ' => $row_siac['codigo_siacweb'],
                        'CPF' => $cpf,
                        'Cargo' => $cargo,
                        'CgcCpf' => $cgccpf,
                        'NomeRazaoSocial' => $row['descricao'],
                        'NomeAbrevFantasia' => $row['resumo'],
                        'CodigoAtivEconomica' => $codigoativeconomica,
                        'NumFunc' => $rowp['qt_funcionarios'],
                        'CodSetor' => $rowt['codsetor'],
                        'Faturam' => $rowp['faturam'],
                        'DatAbert' => $rowp['data_inicio_atividade'],
                        'DatFech' => $rowp['data_fim_atividade'],
                        'CodConst' => $row['codconst'],
                        'DescEndereco' => $rowe['logradouro'],
                        'Cep' => preg_replace('/[^0-9]/i', '', $rowe['logradouro_cep']),
                        'TelefoneComercial' => preg_replace('/[^0-9]/i', '', $rowc1['telefone_1']),
                        'TelefoneCelular' => preg_replace('/[^0-9]/i', '', $rowc1['telefone_2']),
                        'CodPais' => $rowe['logradouro_codpais'],
                        'CodEst' => $rowe['logradouro_codest'],
                        'CodCid' => $rowe['logradouro_codcid'],
                        'CodBairro' => $rowe['logradouro_codbairro'],
                        'Complemento' => $rowe['logradouro_numero'] . ' / ' . $rowe['logradouro_complemento'],
                        'EndInternacional' => '',
                        'CodProdutorRural' => $rowp['ie_prod_rural'],
                        'CodDap' => $rowp['dap'],
                        'CodPescador' => $rowp['rmp'],
                        'Situacao' => $row['siacweb_situacao'],
                        'Email' => $rowc1['email_1'],
                        'Nirf' => preg_replace('/[^0-9]/i', '', $rowp['nirf']),
                        'OptanteSimplesNacional' => $optantesimplesnacional,
                        'CpfResponsavel' => '',
                        'CodSICAB' => preg_replace('/\./i', '', $rowp['sicab_codigo']),
                        'DataValidade' => $rowp['sicab_dt_validade'],
                    );

                    if ($vetPar['CgcCpf'] != '' || $vetPar['CodDap'] != '' || $vetPar['CodPescador'] != '' || $vetPar['Nirf'] != '') {
                        $vetPar['CodProdutorRural'] = '';
                    }

                    foreach ($vetPar as $key => $value) {
                        switch ($key) {
                            case 'DatAbert':
                                $value = trata_data($value, false, true);

                                $vetDT = DatetoArray($value);

                                if (diffDate($value, Date('d/m/Y')) < 0 || $vetDT['ano'] > Date('Y')) {
                                    $vetErroCons[] = "A Data Abertura não pode ser maior que hoje!";
                                }

                                $value = str_replace('/', '', $value);
                                $value = substr($value, 2);

                                if ($value == '') {
                                    $value = ' ';
                                }
                                break;

                            case 'DatFech':
                            case 'DataValidade':
                                $value = trata_data($value, false, true);
                                $value = str_replace('/', '', $value);
                                $value = substr($value, 2);

                                if ($value == '') {
                                    $value = ' ';
                                }
                                break;

                            case 'Cargo':
                            case 'CodPais':
                            case 'CodEst':
                            case 'CodCid':
                            case 'CodBairro':
                            case 'CodSetor':
                                if ($value == '') {
                                    $value = '0';
                                }
                                break;

                            case 'Nirf':
                                $value = preg_replace('/[^0-9]/i', '', $value);

                                if ($value == '') {
                                    $value = '0';
                                } else {
                                    $value = ZeroEsq($value, 8);
                                }
                                break;

                            default:
                                if ($value === '') {
                                    $value = ' ';
                                }
                                break;
                        }

                        //$vetPar[$key] = str_replace('|', '/', $value);
                        $vetPar[$key] = $value;
                    }

                    if (substr($vetPar['CodParceiroPJ'], 0, 2) == '99') {
                        $vetTmp = $vetPar;

                        unset($vetTmp['CodParceiroPJ']);

                        $parametro = $vetTmp;

                        $metodo = 'Trans_Ins_CadastroPJ';
                    } else {
                        $vetTmp = $vetPar;

                        unset($vetTmp['CodigoAtivEconomica']);

                        $parametro = $vetTmp;

                        $metodo = 'Trans_Alt_CadastroPJ';
                    }
                }

                if (!is_numeric($vetPar['Cep']) || count($vetErroCons) > 0) {

                    if (!is_numeric($vetPar['Cep'])) {
                        if ($row['tipo_entidade'] == 'P') {
                            $vetErroCons[] = "O cadastro da Pessoa Fisíca esta incompleto!";
                        } else {
                            $vetErroCons[] = "O cadastro da Pessoa Jurídica esta incompleto!";
                        }
                    }

                    $qtdErro++;
                    $erro = implode(', ', $vetErroCons);

                    $vetErro[] = $erro;

                    $inf_extra = Array(
                        'row_siac' => $row_siac,
                        'metodo' => $metodo,
                        'parametro' => $parametro,
                    );
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idts'] . ')', 'sincroniza_siac', $inf_extra);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= ' erro = ' . aspa($erro);
                    $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                    execsql($sql, false);
                } else {
                    if (substr($row_siac['codigo_siacweb'], 0, 2) != '99') {
                        foreach ($vetTipoInformacao as $codformacontato) {
                            $sql = 'GER_ExcluirFormaPF';

                            $vetBindParam = Array();
                            $vetBindParam['CodParceiro'] = vetBindParam($row_siac['codigo_siacweb']);
                            $vetBindParam['CodFormaContato'] = vetBindParam($codformacontato);
                            execsql($sql, false, $conSIAC, $vetBindParam);
                        }
                    }

                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                    $SebareResult = $SebraeSIACcad->executa($metodo, $parametro, 'Table', true, array('Table1'));
                    $rowResult = $SebareResult->data[0];

                    if ($metodo == 'Trans_Ins_CadastroPF') {
                        if ($rowResult['error'] == 7) {
                            $parametro = Array(
                                'en_Cpf' => $cgccpf,
                            );

                            $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                            $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                            $rowResult = $SebareResult->data[0];

                            if ($rowResult['codparceiro'] != '') {
                                $vetPar['CodParceiro'] = $rowResult['codparceiro'];

                                foreach ($vetTipoInformacao as $codformacontato) {
                                    $sql = 'GER_ExcluirFormaPF';

                                    $vetBindParam = Array();
                                    $vetBindParam['CodParceiro'] = vetBindParam($vetPar['CodParceiro']);
                                    $vetBindParam['CodFormaContato'] = vetBindParam($codformacontato);
                                    execsql($sql, false, $conSIAC, $vetBindParam);
                                }

                                $vetTmp = $vetPar;

                                unset($vetTmp['Senha']);

                                $parametro = $vetTmp;

                                $metodo = 'Trans_Alt_CadastroPF';
                                $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                                $SebareResult = $SebraeSIACcad->executa($metodo, $parametro, 'Table', true, array('Table1'));
                                $rowResult = $SebareResult->data[0];
                            }
                        }
                    }

                    if ($metodo == 'Trans_Ins_CadastroPJ') {
                        if ($rowResult['error'] == 86) {
                            $parametro = Array(
                                'en_CgcCpf' => $cgccpf,
                                'en_Email' => '',
                                'en_CPR' => '',
                            );

                            $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                            $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                            $rowResult = $SebareResult->data[0];

                            if ($rowResult['codparceiro'] != '') {
                                $vetPar['CodParceiroPJ'] = $rowResult['codparceiro'];

                                foreach ($vetTipoInformacao as $codformacontato) {
                                    $sql = 'GER_ExcluirFormaPF';

                                    $vetBindParam = Array();
                                    $vetBindParam['CodParceiro'] = vetBindParam($vetPar['CodParceiroPJ']);
                                    $vetBindParam['CodFormaContato'] = vetBindParam($codformacontato);
                                    execsql($sql, false, $conSIAC, $vetBindParam);
                                }

                                $vetTmp = $vetPar;

                                $parametro = $vetTmp;

                                $metodo = 'Trans_Alt_CadastroPJ';
                                $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                                $SebareResult = $SebraeSIACcad->executa($metodo, $parametro, 'Table', true, array('Table1'));
                                $rowResult = $SebareResult->data[0];
                            }
                        }
                    }

                    if ($usaTransaction) {
                        beginTransaction();
                        $ativoTransaction = true;
                    }

                    set_time_limit(300);

                    if ($rowResult['error'] === '0' && $rowResult['description'] == '') {
                        $erroUpdate = false;

                        if (substr($row_siac['codigo_siacweb'], 0, 2) == '99') {
                            if (!is_numeric($rowResult['codigo'])) {
                                $erroUpdate = true;
                                $qtdErro++;
                                $erro = 'Não tem codigo siacweb: [' . $rowResult['error'] . '] ' . $rowResult['description'] . ' - ' . $rowResult['codigo'];
                                $vetErro[] = $erro;
                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idts'] . ')', 'sincroniza_siac', $parametro);

                                $sql = 'update grc_sincroniza_siac set';
                                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                $sql .= " erro = " . aspa($erro);
                                $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                                execsql($sql, false);
                                continue;
                            }
                        }

                        if ($row_siac['codigo_siacweb'] != $rowResult['codigo']) {
                            if ($row['tipo_entidade'] == 'O') {
                                $tipoparceiro = 'J';
                            } else {
                                $tipoparceiro = 'F';
                            }

                            updateCodSiacweb($row_siac['codigo_siacweb'], $rowResult['codigo'], $tipoparceiro);
                            $row_siac['codigo_siacweb'] = $rowResult['codigo'];
                        }

                        if (substr($row_siac['codigo_siacweb'], 0, 2) != '99') {
                            foreach ($vetTipoInformacao as $codformacontato) {
                                $sql = 'GER_ExcluirFormaPF';

                                $vetBindParam = Array();
                                $vetBindParam['CodParceiro'] = vetBindParam($row_siac['codigo_siacweb']);
                                $vetBindParam['CodFormaContato'] = vetBindParam($codformacontato);
                                execsql($sql, false, $conSIAC, $vetBindParam);
                            }

                            $sql = '';
                            $sql .= ' select idt_tipo_informacao';
                            $sql .= ' from ' . db_pir_gec . 'gec_entidade_x_tipo_informacao';
                            $sql .= ' where idt = ' . null($row_siac['idt_entidade']);
                            $rs_ti = execsql($sql, false);

                            foreach ($rs_ti->data as $row_ti) {
                                $sql = 'GER_CadFormaPF';

                                $vetBindParam = Array();
                                $vetBindParam['CodParceiro'] = vetBindParam($row_siac['codigo_siacweb']);
                                $vetBindParam['CodFormaContato'] = vetBindParam($vetTipoInformacao[$row_ti['idt_tipo_informacao']]);
                                execsql($sql, false, $conSIAC, $vetBindParam);
                            }

                            //Contato Principal para PJ
                            if ($row['tipo_entidade'] == 'O') {
                                $duplicadoF = '';
                                $codparceiro = codParceiroSiacWeb('F', $duplicadoF, $cpf);

                                if ($codparceiro != '') {
                                    $vetContato = Array();

                                    $sql = 'RecContatoPessoaJuridica';

                                    $vetBindParam = Array();
                                    $vetBindParam['CodParceiro'] = vetBindParam($row_siac['codigo_siacweb']);
                                    $rsc = execsql($sql, false, $conSIAC, $vetBindParam);

                                    foreach ($rsc->data as $rowc) {
                                        $vetContato[$rowc['codparceiro']] = Array(
                                            'CodContatoPF' => $rowc['codparceiro'],
                                            'CodCargCli' => $rowc['codcargcli'],
                                            'IndPrincipal' => 0,
                                        );

                                        $sql = 'ExcluirContatoEmpreendimento';

                                        $vetBindParam = Array();
                                        $vetBindParam['CodContatoPJ'] = vetBindParam($row_siac['codigo_siacweb']);
                                        $vetBindParam['CodContatoPF'] = vetBindParam($rowc['codparceiro']);
                                        execsql($sql, false, $conSIAC, $vetBindParam);
                                    }

                                    $vetContato[$codparceiro] = Array(
                                        'CodContatoPF' => $codparceiro,
                                        'CodCargCli' => $cargo,
                                        'IndPrincipal' => 1,
                                    );

                                    foreach ($vetContato as $rowc) {
                                        $sql = '_BA_InserirContato';

                                        $vetBindParam = Array();
                                        $vetBindParam['CodContatoPJ'] = vetBindParam($row_siac['codigo_siacweb']);
                                        $vetBindParam['CodContatoPF'] = vetBindParam($rowc['CodContatoPF']);
                                        $vetBindParam['CodCargCli'] = vetBindParam($rowc['CodCargCli']);
                                        $vetBindParam['IndPrincipal'] = vetBindParam($rowc['IndPrincipal']);
                                        execsql($sql, false, $conSIAC, $vetBindParam);
                                    }
                                }
                            }
                        }

                        //commit($conSIAC);
                        //$ativoTransactionSIAC = false;

                        if (!$erroUpdate) {
                            if ($row_siac['idt_atendimento_pessoa_lst'] != '') {
                                $sql = "update grc_atendimento_pessoa set falta_sincronizar_siacweb = 'N'";
                                $sql .= ' where idt in (' . $row_siac['idt_atendimento_pessoa_lst'] . ')';
                                execsql($sql, false);
                            }

                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                            $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                            execsql($sql, false);
                        }
                    } else {
                        $qtdErro++;
                        $erro = $metodo . ': [' . $rowResult['error'] . '] ' . $rowResult['description'];

                        if ($metodo == 'Trans_Ins_CadastroPJ') {
                            if ($rowResult['error'] == 7) {
                                $erro = 'Empreendimento não integrado, pois deu erro na integração da Pessoa!';
                            }
                        }

                        $vetErro[] = $erro;

                        $inf_extra = Array(
                            'metodo' => $metodo,
                            'parametro' => $parametro,
                            'xml' => $SebraeSIACcad->xml(),
                        );
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idts'] . ')', 'sincroniza_siac', $inf_extra);

                        if (is_numeric($rowResult['error'])) {
                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                            $sql .= ' erro = ' . aspa($erro);
                            $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                            execsql($sql, false);
                        } else {
                            $sql = 'update grc_sincroniza_siac set';
                            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                            $sql .= ' erro = ' . aspa($erro);
                            $sql .= ' where idt in (' . $row_siac['idts'] . ')';
                            execsql($sql, false);
                        }

                        if ($ativoTransactionSIAC) {
                            //rollBack($conSIAC);
                            $ativoTransactionSIAC = false;
                        }
                    }

                    if ($usaTransaction) {
                        commit();
                        $ativoTransaction = false;
                    }
                }
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacH->data as $row_siac) {
    try {
        set_time_limit(300);

        $sql = '';
        $sql .= ' select distinct tipo_entidade';
        $sql .= ' from grc_sincroniza_siac';
        $sql .= ' where idt_atendimento = ' . null($row_siac['idt_atendimento']);
        $sql .= " and tipo = 'E'";
        $sql .= ' and erro is not null';
        $sql .= ' order by tipo_entidade';
        $rs = execsql($sql, false);

        if ($rs->rows != 0) {
            $qtdErro++;
            $erro = '';
            $erro .= 'Atendimento não integrado, pois deu erro nas integrações: ';

            $tmp = Array();
            foreach ($rs->data as $row) {
                if ($row['tipo_entidade'] == 'F') {
                    $tmp[] = 'Pessoa';
                } else {
                    $tmp[] = 'Empreendimento';
                }
            }

            $erro .= implode(', ', $tmp) . '!';

            $vetErro[] = $erro;
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' select a.*, cl.codigo_siacweb as codcliente, cl.cpf, pt.unidoperacional_siacweb, tr.codigo as subtema_tratato,';
            $sql .= ' o.codigo_siacweb_e as codempreendimento, o.cnpj, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo, o.idt as idt_atendimento_organizacao';
            $sql .= ' from grc_atendimento a';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao pt on pt.idt = a.idt_ponto_atendimento';
            $sql .= " inner join grc_atendimento_pessoa cl on cl.idt_atendimento = a.idt and cl.tipo_relacao = 'L'";
            $sql .= " left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt and o.representa = 'S' and o.desvincular = 'N'";
            $sql .= ' left outer join grc_tema_subtema tr on tr.idt = a.idt_subtema_tratado';
            $sql .= ' where a.idt = ' . null($row_siac['idt_atendimento']);
            $rs_a = execsql($sql, false);

            if ($rs_a->rows == 0) {
                $qtdErro++;
                $erro = 'Atendimento não localizado no GRC!';

                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            } else {
                $row_a = $rs_a->data[0];

                $duplicadoF = '';
                $codparceiro = codParceiroSiacWeb('F', $duplicadoF, $row_a['cpf']);

                if ($codparceiro == '' && substr($row_a['codcliente'], 0, 2) != '99') {
                    $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                }

                if ($row_a['codcliente'] != $codparceiro && $codparceiro != '') {
                    if ($usaTransaction) {
                        beginTransaction();
                        $ativoTransaction = true;
                    }

                    updateCodSiacweb($row_a['codcliente'], $codparceiro, 'F');
                    $row_a['codcliente'] = $codparceiro;

                    if ($usaTransaction) {
                        commit();
                        $ativoTransaction = false;
                    }
                }

                $duplicadoJ = '';
                $codparceiro = codParceiroSiacWeb('J', $duplicadoJ, $row_a['cnpj'], $row_a['nirf'], $row_a['dap'], $row_a['rmp'], $row_a['ie_prod_rural'], $row_a['sicab_codigo']);

                if ($codparceiro == '' && $row_a['idt_atendimento_organizacao'] != '' && substr($row_a['codempreendimento'], 0, 2) != '99') {
                    $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                }

                if ($row_a['codempreendimento'] != $codparceiro && $codparceiro != '') {
                    if ($usaTransaction) {
                        beginTransaction();
                        $ativoTransaction = true;
                    }

                    updateCodSiacweb($row_a['codempreendimento'], $codparceiro, 'J');
                    $row_a['codempreendimento'] = $codparceiro;

                    if ($usaTransaction) {
                        commit();
                        $ativoTransaction = false;
                    }
                }

                if ($duplicadoF != '') {
                    $qtdErro++;
                    $erro = "Registro duplicado no SiacWeb!" . $duplicadoF;

                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac_duplicado', $row_siac);

                    $sql = 'update grc_sincroniza_siac set';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= ' erro = ' . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                } else if ($duplicadoJ != '') {
                    $qtdErro++;
                    $erro = "Registro duplicado no SiacWeb!" . $duplicadoJ;

                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac_duplicado', $row_siac);

                    $sql = 'update grc_sincroniza_siac set';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= ' erro = ' . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                } else if (substr($row_a['codcliente'], 0, 2) == '99' || substr($row_a['codempreendimento'], 0, 2) == '99') {
                    $qtdErro++;
                    $erro = '';
                    $erro .= 'Atendimento não integrado, pois deu erro nas integrações: ';

                    $tmp = Array();

                    if (substr($row_a['codcliente'], 0, 2) == '99') {
                        $tmp[] = 'Pessoa';
                    }

                    if (substr($row_a['codempreendimento'], 0, 2) == '99') {
                        $tmp[] = 'Empreendimento';
                    }

                    $erro .= implode(', ', $tmp) . '!';

                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                } else {
                    $row = sincronizaSIAChist($row_a['idt'], false, false);

                    if ($row === false) {
                        $qtdErro++;
                        $erro = 'Atendimento não localizado no SIAC!';

                        $vetErro[] = $erro;
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);
                    } else {
                        if (strlen($row['mescompetencia']) == 1) {
                            $row['mescompetencia'] = '0' . $row['mescompetencia'];
                        }

                        beginTransaction($conSIAC);
                        $ativoTransactionSIAC = true;

                        if ($row_a['codrealizacao'] == '') {
                            //Novo Atendimento

                            $sql = 'ATEND_InserirAtendimentoIntegrado';

                            $vetBindParam = Array();
                            $vetBindParam['DataHoraAtendimento'] = vetBindParam($row['datahorainiciorealizacao']);
                            $vetBindParam['HoraFinal'] = vetBindParam($row['datahorafimrealizacao']);
                            $vetBindParam['CodPessoa'] = vetBindParam($row_a['codcliente'], PDO::PARAM_INT);
                            $vetBindParam['CodEmpreendimento'] = vetBindParam($row_a['codempreendimento'], PDO::PARAM_INT);
                            $vetBindParam['CodMeioAtendimento'] = vetBindParam(1, PDO::PARAM_INT);
                            $vetBindParam['DescComentario'] = vetBindParam($row['descrealizacao']);
                            $vetBindParam['UsuarioResponsavel'] = vetBindParam($row['codresponsavel'], PDO::PARAM_INT);
                            $vetBindParam['CodSol'] = vetBindParam($row['codprojeto']);
                            $vetBindParam['CodObj'] = vetBindParam($row['codacao'], PDO::PARAM_INT);
                            $vetBindParam['CodUnidOp'] = vetBindParam($row_a['unidoperacional_siacweb'], PDO::PARAM_INT);
                            $vetBindParam['CodMomentoVida'] = vetBindParam(0, PDO::PARAM_INT);
                            $vetBindParam['AtendManutencao'] = vetBindParam(0, PDO::PARAM_INT);

                            $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                            $rowAtendInt = $SebareResult->data[0];

                            if ($rowAtendInt['erro'] == 0) {
                                $codtema = 0;

                                switch ($row_a['idt_instrumento']) {
                                    case 2: //Consultoria Presencial
                                        if ($row_a['subtema_tratato'] != '') {
                                            $codtema = preg_replace('/[^0-9]/i', '', $row_a['subtema_tratato']);

                                            /*
                                              $sql = 'ATEND_InserirAtendimentoIntegradoTema';

                                              $vetBindParam = Array();
                                              $vetBindParam['CodAtendIntegrado'] = vetBindParam($rowAtendInt['codatendintegrado'], PDO::PARAM_INT);
                                              $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);
                                              $vetBindParam['StatusBIA'] = vetBindParam(' ', PDO::PARAM_STR);
                                              $vetBindParam['CodAplicacao'] = vetBindParam($row['codaplicacao'], PDO::PARAM_INT);
                                              $vetBindParam['AnoCompetencia'] = vetBindParam($row['anocompetencia'], PDO::PARAM_INT);
                                              $vetBindParam['TipoRealizacao'] = vetBindParam($row['tiporealizacao'], PDO::PARAM_STR);

                                              $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                             * 
                                             */
                                        }
                                        break;

                                    default:
                                        $sql = '';
                                        $sql .= ' select t.codigo';
                                        $sql .= ' from grc_atendimento_tema at';
                                        $sql .= ' inner join grc_tema_subtema t on t.idt = at.idt_sub_tema';
                                        $sql .= ' where at.idt_atendimento = ' . null($row_siac['idt_atendimento']);
                                        $sql .= " and at.tipo_tratamento = 'T'";
                                        $rs_tema = execsql($sql, false);

                                        if ($rs_tema->rows > 0) {
                                            $codtema = preg_replace('/[^0-9]/i', '', $rs_tema->data[0][0]);

                                            foreach ($rs_tema->data as $row_tema) {
                                                if ($row_tema['codigo'] == '22.04') { //Inovação
                                                    $codtema = preg_replace('/[^0-9]/i', '', $row_tema['codigo']);
                                                }
                                            }
                                        }

                                        /*
                                          foreach ($rs_tema->data as $row_tema) {
                                          $codtema = preg_replace('/[^0-9]/i', '', $row_tema['codigo']);

                                          $sql = 'ATEND_InserirAtendimentoIntegradoTema';

                                          $vetBindParam = Array();
                                          $vetBindParam['CodAtendIntegrado'] = vetBindParam($rowAtendInt['codatendintegrado'], PDO::PARAM_INT);
                                          $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);
                                          $vetBindParam['StatusBIA'] = vetBindParam(' ', PDO::PARAM_STR);
                                          $vetBindParam['CodAplicacao'] = vetBindParam($row['codaplicacao'], PDO::PARAM_INT);
                                          $vetBindParam['AnoCompetencia'] = vetBindParam($row['anocompetencia'], PDO::PARAM_INT);
                                          $vetBindParam['TipoRealizacao'] = vetBindParam($row['tiporealizacao'], PDO::PARAM_STR);

                                          $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                          }
                                         * 
                                         */
                                        break;
                                }

                                $sql = '';
                                $sql .= ' select codigo_siacweb, cpf';
                                $sql .= ' from grc_atendimento_pessoa';
                                $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                                $rs_pess = execsql($sql, false);

                                $duplicado = '';

                                foreach ($rs_pess->data as $row_pess) {
                                    if ($duplicado == '') {
                                        if ($usaTransaction) {
                                            beginTransaction();
                                            $ativoTransaction = true;
                                        }

                                        $codparceiro = codParceiroSiacWeb('F', $duplicado, $row_pess['cpf']);

                                        if ($codparceiro == '' && substr($row_pess['codigo_siacweb'], 0, 2) != '99') {
                                            $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                                        }

                                        if ($row_pess['codigo_siacweb'] != $codparceiro && $codparceiro != '') {
                                            updateCodSiacweb($row_pess['codigo_siacweb'], $codparceiro, 'F');
                                            $row_pess['codigo_siacweb'] = $codparceiro;
                                        }

                                        if ($usaTransaction) {
                                            commit();
                                            $ativoTransaction = false;
                                        }

                                        $sql = 'ATEND_InserirAtendimentoIntegradoPessoasAtendidas';

                                        $vetBindParam = Array();
                                        $vetBindParam['CodAtendIntegrado'] = vetBindParam($rowAtendInt['codatendintegrado']);
                                        $vetBindParam['CodPessoaAtendida'] = vetBindParam($row_pess['codigo_siacweb']);

                                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                    }
                                }

                                if ($duplicado != '') {
                                    if ($ativoTransactionSIAC) {
                                        rollBack($conSIAC);
                                        $ativoTransactionSIAC = false;
                                    }

                                    $qtdErro++;
                                    $erro = "Registro duplicado no SiacWeb!" . $duplicado;

                                    $vetErro[] = $erro;
                                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac_duplicado', $row_siac);

                                    $sql = 'update grc_sincroniza_siac set';
                                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                    $sql .= ' erro = ' . aspa($erro);
                                    $sql .= ' where idt = ' . null($row_siac['idt']);
                                    execsql($sql, false);
                                } else {
                                        $vetPar = array(
                                            'CodCliente' => $row_a['codcliente'],
                                            'CodEmpreendimento' => $row_a['codempreendimento'],
                                            'DataHoraInicioRealizacao' => $row['datahorainiciorealizacao'],
                                            'DataHoraFimRealizacao' => $row['datahorafimrealizacao'],
                                            'NomeRealizacao' => $row['nomerealizacao'],
                                            'CodRealizacao' => $rowAtendInt['codatendintegrado'],
                                            'CodRealizacaoComp' => $row['codrealizacaocomp'],
                                            'TipoRealizacao' => 'IUF',
                                            'Instrumento' => $row['instrumento'],
                                            'Abordagem' => $row['abordagem'],
                                            'DescRealizacao' => '',
                                            'CodProjeto' => $row['codprojeto'],
                                            'CodAcao' => $row['codacao'],
                                            'MesAnoCompetencia' => $row['mescompetencia'] . $row['anocompetencia'],
                                            'CargaHoraria' => $row['cargahoraria'],
                                            'CodSebrae' => $codsebrae,
                                            'Tema' => $codtema,
                                            'CodSistemaOrigem' => 0,
                                            'CpfResponsavel' => '37218628800',
                                        );

                                        foreach ($vetPar as $key => $value) {
                                            switch ($key) {
                                                case 'CodEmpreendimento':
                                                    if ($value == '') {
                                                        $value = '0';
                                                    }
                                                    break;
                                            }

                                            $vetPar[$key] = $value;
                                        }

                                        $metodo = 'Trans_Ins_HistoricoRealizacaoCliente';
                                        $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                                    $rowHist = $SebareResult->data[0];

                                    if (array_key_exists('erro', $rowHist)) {
                                        $rowHist = Array(
                                            'coderro' => $rowHist['erro'],
                                            'mensagem' => $rowHist['msgerro'],
                                        );
                                    }

                                    if ($rowHist['coderro'] == '0') {
                                        commit($conSIAC);
                                        $ativoTransactionSIAC = false;

                                        $sql = 'update grc_atendimento set codrealizacao = ' . null($rowAtendInt['codatendintegrado']);
                                        $sql .= ' where idt = ' . null($row_a['idt']);
                                        execsql($sql, false);

                                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                                        $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                                        execsql($sql, false);
                                    } else {
                                        if ($ativoTransactionSIAC) {
                                            rollBack($conSIAC);
                                            $ativoTransactionSIAC = false;
                                        }

                                        $qtdErro++;
                                        $erro = $sql . ': [' . $rowHist['coderro'] . '] ' . $rowHist['mensagem'];

                                            $inf_extra = Array(
                                                'metodo' => $metodo,
                                                'parametro' => $vetPar,
                                                'row_siac' => $row_siac,
                                            );

                                        $vetErro[] = $erro;
                                            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                                        $sql = 'update grc_sincroniza_siac set';

                                        if ($rowHist['coderro'] != '19') {
                                            $sql .= ' dt_sincroniza = now(),';
                                        }

                                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                        $sql .= " erro = " . aspa($erro);
                                        $sql .= ' where idt = ' . null($row_siac['idt']);
                                        execsql($sql, false);
                                    }
                                }
                            } else {
                                if ($ativoTransactionSIAC) {
                                    rollBack($conSIAC);
                                    $ativoTransactionSIAC = false;
                                }

                                $qtdErro++;
                                $erro = $sql . ': [' . $rowAtendInt['erro'] . '] ' . $rowAtendInt['msgerro'];

                                $vetErro[] = $erro;
                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetBindParam);

                                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                $sql .= " erro = " . aspa($erro);
                                $sql .= ' where idt = ' . null($row_siac['idt']);
                                execsql($sql, false);
                            }
                        } else {
                            //Alterar Atendimento

                            $sql = 'ATEND_AtualizarAtendimentoIntegrado';

                            $vetBindParam = Array();
                            $vetBindParam['usuariologin'] = vetBindParam('GRC.SEBRAEBA');
                            $vetBindParam['CodMeioAtendimento'] = vetBindParam(1, PDO::PARAM_INT);
                            $vetBindParam['DescComentario'] = vetBindParam($row['descrealizacao']);
                            $vetBindParam['CodSol'] = vetBindParam($row['codprojeto']);
                            $vetBindParam['CodObj'] = vetBindParam($row['codacao'], PDO::PARAM_INT);
                            $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                            $vetBindParam['CodMomentoVida'] = vetBindParam(0, PDO::PARAM_INT);
                            $vetBindParam['CodUnidOp'] = vetBindParam($row_a['unidoperacional_siacweb'], PDO::PARAM_INT);
                            $vetBindParam['DataHoraInicial'] = vetBindParam($row['datahorainiciorealizacao']);
                            $vetBindParam['HoraFinal'] = vetBindParam($row['datahorafimrealizacao']);
                            $vetBindParam['UsuarioResponsavel'] = vetBindParam($row['codresponsavel'], PDO::PARAM_INT);

                            $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                            $rowAtuAtendInt = $SebareResult->data[0];

                            if ($rowAtuAtendInt['erro'] == 0) {
                                $codtema = 0;

                                /*
                                  $sql = 'ATEND_ExcluirTemas';

                                  $vetBindParam = Array();
                                  $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                  $vetBindParam['tipoRealizacao'] = vetBindParam($row['tiporealizacao'], PDO::PARAM_STR);

                                  $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                 * 
                                 */

                                switch ($row_a['idt_instrumento']) {
                                    case 2: //Consultoria Presencial
                                        if ($row_a['subtema_tratato'] != '') {
                                            $codtema = preg_replace('/[^0-9]/i', '', $row_a['subtema_tratato']);

                                            /*
                                              $sql = 'ATEND_InserirAtendimentoIntegradoTema';

                                              $vetBindParam = Array();
                                              $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                              $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);
                                              $vetBindParam['StatusBIA'] = vetBindParam(' ', PDO::PARAM_STR);
                                              $vetBindParam['CodAplicacao'] = vetBindParam($row['codaplicacao'], PDO::PARAM_INT);
                                              $vetBindParam['AnoCompetencia'] = vetBindParam($row['anocompetencia'], PDO::PARAM_INT);
                                              $vetBindParam['TipoRealizacao'] = vetBindParam($row['tiporealizacao'], PDO::PARAM_STR);

                                              $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                             * 
                                             */
                                        }
                                        break;

                                    default:
                                        $sql = '';
                                        $sql .= ' select t.codigo';
                                        $sql .= ' from grc_atendimento_tema at';
                                        $sql .= ' inner join grc_tema_subtema t on t.idt = at.idt_sub_tema';
                                        $sql .= ' where at.idt_atendimento = ' . null($row_siac['idt_atendimento']);
                                        $sql .= " and at.tipo_tratamento = 'T'";
                                        $rs_tema = execsql($sql, false);


                                        if ($rs_tema->rows > 0) {
                                            $codtema = preg_replace('/[^0-9]/i', '', $rs_tema->data[0][0]);

                                            foreach ($rs_tema->data as $row_tema) {
                                                if ($row_tema['codigo'] == '22.04') { //Inovação
                                                    $codtema = preg_replace('/[^0-9]/i', '', $row_tema['codigo']);
                                                }
                                            }
                                        }

                                        /*
                                          foreach ($rs_tema->data as $row_tema) {
                                          $codtema = preg_replace('/[^0-9]/i', '', $row_tema['codigo']);

                                          $sql = 'ATEND_InserirAtendimentoIntegradoTema';

                                          $vetBindParam = Array();
                                          $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                          $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);
                                          $vetBindParam['StatusBIA'] = vetBindParam(' ', PDO::PARAM_STR);
                                          $vetBindParam['CodAplicacao'] = vetBindParam($row['codaplicacao'], PDO::PARAM_INT);
                                          $vetBindParam['AnoCompetencia'] = vetBindParam($row['anocompetencia'], PDO::PARAM_INT);
                                          $vetBindParam['TipoRealizacao'] = vetBindParam($row['tiporealizacao'], PDO::PARAM_STR);

                                          $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                          }
                                         * 
                                         */
                                        break;
                                }

                                $sql = 'ATEND_ExcluirAtendimentoIntegradoPessoasAtendidas';

                                $vetBindParam = Array();
                                $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                $vetBindParam['CodPessoaAtendida'] = vetBindParam('0');

                                $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);

                                $sql = '';
                                $sql .= ' select codigo_siacweb, cpf';
                                $sql .= ' from grc_atendimento_pessoa';
                                $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
                                $rs_pess = execsql($sql, false);

                                $duplicado = '';

                                foreach ($rs_pess->data as $row_pess) {
                                    if ($duplicado == '') {
                                        if ($usaTransaction) {
                                            beginTransaction();
                                            $ativoTransaction = true;
                                        }

                                        $duplicado = '';
                                        $codparceiro = codParceiroSiacWeb('F', $duplicado, $row_pess['cpf']);

                                        if ($codparceiro == '' && substr($row_pess['codigo_siacweb'], 0, 2) != '99') {
                                            $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                                        }

                                        if ($row_pess['codigo_siacweb'] != $codparceiro && $codparceiro != '') {
                                            updateCodSiacweb($row_pess['codigo_siacweb'], $codparceiro, 'F');
                                            $row_pess['codigo_siacweb'] = $codparceiro;
                                        }
                                        if ($usaTransaction) {
                                            commit();
                                            $ativoTransaction = false;
                                        }

                                        $sql = 'ATEND_InserirAtendimentoIntegradoPessoasAtendidas';

                                        $vetBindParam = Array();
                                        $vetBindParam['CodAtendIntegrado'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                        $vetBindParam['CodPessoaAtendida'] = vetBindParam($row_pess['codigo_siacweb']);

                                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                    }
                                }

                                if ($duplicado != '') {
                                    if ($ativoTransactionSIAC) {
                                        rollBack($conSIAC);
                                        $ativoTransactionSIAC = false;
                                    }

                                    $qtdErro++;
                                    $erro = "Registro duplicado no SiacWeb!" . $duplicado;

                                    $vetErro[] = $erro;
                                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                                    $sql = 'update grc_sincroniza_siac set';
                                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                    $sql .= ' erro = ' . aspa($erro);
                                    $sql .= ' where idt = ' . null($row_siac['idt']);
                                    execsql($sql, false);
                                } else {
                                    $sql = 'HIST_ExcluirHistoricoClienteWS';

                                    $vetBindParam = Array();
                                    $vetBindParam['CodCliente'] = vetBindParam($row_a['codcliente'], PDO::PARAM_INT);
                                    $vetBindParam['CodEmpreendimento'] = vetBindParam(0, PDO::PARAM_INT);
                                    $vetBindParam['CodRealizacao'] = vetBindParam($row_a['codrealizacao'], PDO::PARAM_INT);
                                    $vetBindParam['CodRealizacaoComp'] = vetBindParam($row['codrealizacaocomp'], PDO::PARAM_INT);
                                    $vetBindParam['TipoRealizacao'] = vetBindParam('IUF'); //$row['tiporealizacao']
                                    $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);

                                    $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                                    $rowHist = $SebareResult->data[0];

                                    if (array_key_exists('erro', $rowHist)) {
                                        $rowHist = Array(
                                            'coderro' => $rowHist['erro'],
                                            'mensagem' => $rowHist['msgerro'],
                                        );
                                    }

                                    if ($rowHist['coderro'] == '0' || $rowHist['coderro'] == '21') {
                                            $vetPar = array(
                                                'CodCliente' => $row_a['codcliente'],
                                                'CodEmpreendimento' => $row_a['codempreendimento'],
                                                'DataHoraInicioRealizacao' => $row['datahorainiciorealizacao'],
                                                'DataHoraFimRealizacao' => $row['datahorafimrealizacao'],
                                                'NomeRealizacao' => $row['nomerealizacao'],
                                                'CodRealizacao' => $row_a['codrealizacao'],
                                                'CodRealizacaoComp' => $row['codrealizacaocomp'],
                                                'TipoRealizacao' => 'IUF',
                                                'Instrumento' => $row['instrumento'],
                                                'Abordagem' => $row['abordagem'],
                                                'DescRealizacao' => '',
                                                'CodProjeto' => $row['codprojeto'],
                                                'CodAcao' => $row['codacao'],
                                                'MesAnoCompetencia' => $row['mescompetencia'] . $row['anocompetencia'],
                                                'CargaHoraria' => $row['cargahoraria'],
                                                'CodSebrae' => $codsebrae,
                                                'Tema' => $codtema,
                                                'CodSistemaOrigem' => 0,
                                                'CpfResponsavel' => '37218628800',
                                            );

                                            foreach ($vetPar as $key => $value) {
                                                switch ($key) {
                                                    case 'CodEmpreendimento':
                                                        if ($value == '') {
                                                            $value = '0';
                                                        }
                                                        break;
                                                }

                                                $vetPar[$key] = $value;
                                            }

                                            $metodo = 'Trans_Ins_HistoricoRealizacaoCliente';
                                            $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                                        $rowHist = $SebareResult->data[0];

                                        if (array_key_exists('erro', $rowHist)) {
                                            $rowHist = Array(
                                                'coderro' => $rowHist['erro'],
                                                'mensagem' => $rowHist['msgerro'],
                                            );
                                        }

                                        if ($rowHist['coderro'] == '0') {
                                            commit($conSIAC);
                                            $ativoTransactionSIAC = false;

                                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                                            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                                            execsql($sql, false);
                                        } else {
                                            if ($ativoTransactionSIAC) {
                                                rollBack($conSIAC);
                                                $ativoTransactionSIAC = false;
                                            }

                                            $qtdErro++;
                                                $erro = $metodo . ': [' . $rowHist['coderro'] . '] ' . $rowHist['mensagem'];

                                                $inf_extra = Array(
                                                    'metodo' => $metodo,
                                                    'parametro' => $vetPar,
                                                    'row_siac' => $row_siac,
                                                );

                                            $vetErro[] = $erro;
                                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                                            $sql = 'update grc_sincroniza_siac set';

                                            if ($rowHist['coderro'] != '19') {
                                                $sql .= ' dt_sincroniza = now(),';
                                            }

                                            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                            $sql .= " erro = " . aspa($erro);
                                            $sql .= ' where idt = ' . null($row_siac['idt']);
                                            execsql($sql, false);
                                        }
                                    } else {
                                        if ($ativoTransactionSIAC) {
                                            rollBack($conSIAC);
                                            $ativoTransactionSIAC = false;
                                        }

                                        $qtdErro++;
                                        $erro = $sql . ': [' . $rowHist['coderro'] . '] ' . $rowHist['mensagem'];

                                        $vetErro[] = $erro;
                                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetBindParam);

                                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                        $sql .= " erro = " . aspa($erro);
                                        $sql .= ' where idt = ' . null($row_siac['idt']);
                                        execsql($sql, false);
                                    }
                                }
                            } else {
                                if ($ativoTransactionSIAC) {
                                    rollBack($conSIAC);
                                    $ativoTransactionSIAC = false;
                                }

                                $qtdErro++;
                                $erro = $sql . ': [' . $rowAtuAtendInt['erro'] . '] ' . $rowAtuAtendInt['msgerro'];

                                $vetErro[] = $erro;
                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetBindParam);

                                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                $sql .= " erro = " . aspa($erro);
                                $sql .= ' where idt = ' . null($row_siac['idt']);
                                execsql($sql, false);
                            }
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV->data as $row_siac) {
    try {
        set_time_limit(300);

        $sql = '';
        $sql .= ' select gec_prog.tipo_ordem, e.sgtec_modelo, e.idt_evento_situacao';
        $sql .= ' from grc_evento e';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
        $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
        $rs = execsql($sql, false);
        $row_e = $rs->data[0];

        $roda = true;

        if ($row_e['tipo_ordem'] == 'SG' && $row_e['sgtec_modelo'] == 'E') {
            $roda = false;

            if ($row_e['idt_evento_situacao'] == 14 || $row_e['idt_evento_situacao'] == 16 || $row_e['idt_evento_situacao'] == 19 || $row_e['idt_evento_situacao'] == 20) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
                $sql .= ' where idt_evento = ' . null($row_siac['idt_evento']);
                $sql .= ' and idt_gec_contratacao_status <> 9';
                $sql .= " and ativo = 'S'";
                $rs = execsql($sql, false);

                if ($rs->rows == 0) {
                    criaAgendaEntregaSGLocal();
                    $roda = true;
                }
            }
        }

        if ($roda) {
            $sql = '';
            $sql .= ' select esc.unidoperacional_siacweb as codescritorio, area.codarea_siacweb as area_codigo, e.area_codigo_siacweb as evento_codarea, i.codigo_familia_siac as codfamiliaproduto,';
            $sql .= ' p.codigo_siac as codproduto, i.codigo_tipoevento_siac as tipoevento, e.descricao as tituloevento, e.carga_horaria_total as cargahoraria,';
            $sql .= ' e.frequencia_min as frequenciamin, e.quantidade_participante as maxparticipante, e.valor_inscricao as valorinscricao, e.qtd_dias_reservados as qtddiareserva,';
            $sql .= ' e.qtd_minima_pagantes as minpagante, ac.codigo_proj as codprojeto, ac.codigo_siacweb as codacao, e.publica_internet as publicarportal,';
            $sql .= ' e.dt_previsao_inicial as periodoinicial, e.dt_previsao_fim as periodofinal, e.hora_inicio as horarioinicial, e.hora_fim as horariofinal,';
            $sql .= " l.descricao as desclocalevento, l.logradouro as descendereco, concat_ws(' / ', l.logradouro_numero, l.logradouro_complemento) as local_complemento,";
            $sql .= ' l.logradouro_codbairro as local_codbairro, l.logradouro_codcid as local_codcid, l.logradouro_codest as local_codest, l.logradouro_codpais as local_codpais,';
            $sql .= ' l.cep as local_cep, l.proprio as local_interno, l.codigo_siacweb as local_siacweb, e.local_codigo_siacweb as evento_codlocalevento,';
            $sql .= ' e.codigo_siacweb as codigo_evento_siacweb, e.codigo as evento_codigo, e.idt_local, e.idt_ponto_atendimento_tela';
            $sql .= ' from grc_evento e';
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
            $sql .= ' inner join grc_evento_local_pa l on l.idt = e.idt_local';
            $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
            $sql .= ' inner join grc_projeto_acao ac on ac.idt = e.idt_acao';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao esc on e.idt_unidade = esc.idt';
            $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao area on e.idt_ponto_atendimento_tela = area.idt';
            $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
            $rs_e = execsql($sql, false);
            $row_e = $rs_e->data[0];

            if ($row_e['valorinscricao'] == '') {
                $row_e['valorinscricao'] = 0;
            }

            if ($rs_e->rows == 0) {
                $qtdErro++;
                $erro = 'Evento não localizado no GRC!';

                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            } else if ($row_e['codproduto'] == '') {
                $qtdErro++;
                $erro = 'O Código SIACWEB não esta informado no produto relacionado ao Evento!';

                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            } else {
                if ($row_e['idt_ponto_atendimento_tela'] == '') {
                    $codarea = 2625;
                } else {
                    $codarea = $row_e['area_codigo'];

                    if ($codarea == '') {
                        $evento_codarea = $row_e['evento_codarea'];

                        if ($evento_codarea == '') {
                            $vetPar = array(
                                'CodSebrae' => $codsebrae,
                                'CodEscritorio' => $row_e['codescritorio'],
                            );

                            $metodo = 'Util_Rec_AreaPorEscritorio';
                            $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);

                            if ($SebareResult->rows == 0) {
                                $qtdErro++;
                                $erro = 'Evento não tem Área cadastrada para o Escritório!';

                                $vetErro[] = $erro;
                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetPar);

                                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                $sql .= " erro = " . aspa($erro);
                                $sql .= ' where idt = ' . null($row_siac['idt']);
                                execsql($sql, false);
                                continue;
                            } else {
                                $rowResult = $SebareResult->data[0];

                                if ($rowResult['erro'] == '') {
                                    $evento_codarea = $rowResult['codarea'];
                                } else {
                                    $qtdErro++;
                                    $erro = $metodo . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                                    $vetErro[] = $erro;
                                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetPar);

                                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                    $sql .= " erro = " . aspa($erro);
                                    $sql .= ' where idt = ' . null($row_siac['idt']);
                                    execsql($sql, false);
                                    continue;
                                }
                            }
                        }

                        $codarea = $evento_codarea;
                    }
                }

                $vetPar = array(
                    'CodSebrae' => $codsebrae,
                    'DescLocalEvento' => substr($row_e['desclocalevento'], 0, 60),
                    'DescEndereco' => substr($row_e['descendereco'], 0, 60),
                    'Complemento' => substr($row_e['local_complemento'], 0, 30),
                    'CodBairro' => $row_e['local_codbairro'],
                    'CodCid' => $row_e['local_codcid'],
                    'CodEstado' => $row_e['local_codest'],
                    'CodPais' => $row_e['local_codpais'],
                    'CEP' => preg_replace('/[^0-9]/i', '', $row_e['local_cep']),
                    'Ativo' => 'S',
                );

                //if ($row_e['local_interno'] == 'S') {
                //$local = $row_e['local_siacweb'];
                //} else {
                $local = $row_e['evento_codlocalevento'];
                $vetPar['DescLocalEvento'] = substr($row_e['evento_codigo'] . '# ' . $vetPar['DescLocalEvento'], 0, 60);
                //}

                if ($local == '') {
                    $metodo = 'Trans_Ins_LocalEvento';
                    $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
                    $rowResult = $SebareResult->data[0];

                    if ($rowResult['codlocalevento'] == '') {
                        $qtdErro++;
                        $erro = $metodo . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                        $vetErro[] = $erro;
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetPar);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);
                        continue;
                    } else {
                        $local = $rowResult['codlocalevento'];

                        /*
                          if ($row_e['local_interno'] == 'S') {
                          $sql = 'update grc_evento_local_pa set codigo_siacweb = '.null($local);
                          $sql .= ' where idt = '.null($row_e['idt_local']);
                          execsql($sql, false);
                          }
                         */
                    }
                }

                /*
                  $vetPar = array(
                  'CodSebrae' => $codsebrae,
                  'CodEscritorio' => $row_e['codescritorio'],
                  'CodArea' => $codarea,
                  );

                  $metodo = 'Trans_Ins_AreaPorEscritorio';
                  $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
                  $rowResult = $SebareResult->data[0];

                  if ($rowResult['erro'] !== 0) {
                  $qtdErro++;
                  $erro = $metodo.': ['.$rowResult['erro'].'] '.$rowResult['descricao'];

                  $vetErro[] = $erro;
                  $idt_erro_log = erro_try($erro.' ('.$row_siac['idt'].')', 'sincroniza_siac', $vetPar);

                  $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                  $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                  $sql .= " erro = ".aspa($erro);
                  $sql .= ' where idt = '.null($row_siac['idt']);
                  execsql($sql, false);
                  continue;
                  }
                 * 
                 */

                $sql = 'update grc_evento set';
                $sql .= ' area_codigo_siacweb = ' . null($codarea);
                $sql .= ', local_codigo_siacweb = ' . null($local);
                $sql .= ' where idt = ' . null($row_siac['idt_evento']);
                execsql($sql, false);

                $codrealizacao = $row_e['codigo_evento_siacweb'];

                $vetPar = array(
                    'CodSebrae' => $codsebrae,
                    'CodRealizacao' => $codrealizacao,
                    'CodEscritorio' => $row_e['codescritorio'],
                    'CodArea' => $codarea,
                    'CodFamiliaProduto' => $row_e['codfamiliaproduto'],
                    'CodProduto' => $row_e['codproduto'],
                    'TipoEvento' => $row_e['tipoevento'],
                    'TituloEvento' => str_replace("'", '', $row_e['tituloevento']),
                    'CargaHoraria' => $row_e['cargahoraria'],
                    'FrequenciaMin' => $row_e['frequenciamin'],
                    'MaxParticipante' => $row_e['maxparticipante'],
                    'ValorInscricao' => $row_e['valorinscricao'],
                    'QtdDiaReserva' => $row_e['qtddiareserva'],
                    'MinPagante' => $row_e['minpagante'],
                    'CodProjeto' => $row_e['codprojeto'],
                    'CodAcao' => $row_e['codacao'],
                    'PublicarPortal' => $row_e['publicarportal'],
                    'PeriodoInicial' => trata_data($row_e['periodoinicial']),
                    'PeriodoFinal' => trata_data($row_e['periodofinal']),
                    'HorarioInicial' => $row_e['horarioinicial'],
                    'HorarioFinal' => $row_e['horariofinal'],
                    'Local' => $local,
                    'Concluido' => 'N',
                );

                if ($codrealizacao == '') {
                    $metodo = 'Trans_Ins_Evento';
                    unset($vetPar['CodRealizacao']);
                } else {
                    $metodo = 'Trans_Alt_Evento';

                    $sql = '';
                    $sql .= " select count(pr.codpessoapf) as tot";
                    $sql .= ' from participante pr with(nolock)';
                    $sql .= ' where pr.codevento = ' . null($codrealizacao);
                    $rsSIAC = execsql($sql, false, $conSIAC);
                    $qtdSiac = $rsSIAC->data[0][0];

                    if ($qtdSiac > $row_e['maxparticipante']) {
                        $vetPar['MaxParticipante'] = $qtdSiac;
                    }
                }

                $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
                $rowResult = $SebareResult->data[0];

                if ($rowResult['coderro'] == '0') {
                    if ($codrealizacao == '') {
                        $codrealizacao = $rowResult['codrealizacao'];
                    }

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                } else {
                    $qtdErro++;
                    $erro = $metodo . ': [' . $rowResult['coderro'] . '] ' . $rowResult['mensagem'];

                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetPar);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                    continue;
                }

                $sql = 'update grc_evento set codigo_siacweb = ' . null($codrealizacao);
                $sql .= ' where idt = ' . null($row_siac['idt_evento']);
                execsql($sql, false);

                if (!$usaTransaction) {
                    commit();
                    $ativoTransaction = false;
                    beginTransaction();
                    $ativoTransaction = true;
                }
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_CON->data as $row_siac) {
    try {
        set_time_limit(300);

        $vetErroCons = Array();

        $codresponsavel = $row_siac['codresponsavel'];

        if ($codresponsavel == '') {
            $codresponsavel = 99;
        }

        $sql = '';
        $sql .= ' select codigo_siacweb, dt_previsao_fim as datahorafimrealizacao';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($row_siac['idt_evento']);
        $rst = execsql($sql, false);

        $codrealizacao = $rst->data[0]['codigo_siacweb'];

        if ($codrealizacao == '') {
            $erro = 'Evento não sincronizado!';

            $sql = 'update grc_sincroniza_siac set';
            $sql .= ' idt_erro_log = null,';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= " select dbo.FN_RetornarMesAnoCompetencia('" . $rst->data[0]['datahorafimrealizacao'] . "', GETDATE()) as dt";
            $rstt = execsql($sql, false, $conSIAC);

            $mesanocompetencia = $rstt->data[0][0];

            $mesanocompetencia_ws = DatetoArray(trata_data($mesanocompetencia));
            $mesanocompetencia_ws = $mesanocompetencia_ws['mes'] . $mesanocompetencia_ws['ano'];

            //Consolida Pessoa
            $sql = '';
            $sql .= ' select p.codigo_siacweb as codcliente, p.cpf, p.nome, p.idt_atendimento, p.idt as idt_atendimento_pessoa,';
            $sql .= ' o.codigo_siacweb_e as codempreendimento, p.evento_concluio as concluido, o.idt as idt_atendimento_organizacao,';
            $sql .= " e.siacweb_hist_hora_ini as datahorainiciorealizacao,";
            $sql .= " e.siacweb_hist_hora_fim as datahorafimrealizacao,";
            $sql .= " concat('[', e.codigo, '] ', e.descricao) as nomerealizacao, inst.descricao_siacweb as instrumento, e.idt_instrumento,";
            $sql .= ' proj.codigo_sge as codprojeto, siac_acao.codacao_seq as codacao, e.carga_horaria_total as cargahoraria,';
            $sql .= ' o.cnpj, o.razao_social, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo, e.data_criacao as dtinscricaoinicio';
            $sql .= ' from grc_sincroniza_siac s';
            $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
            $sql .= ' inner join grc_atendimento a on a.idt_evento = s.idt_evento';
            $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join grc_atendimento_instrumento inst on inst.idt = e.idt_instrumento';
            $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt';
            $sql .= ' left outer join grc_projeto proj on proj.idt = e.idt_projeto';
            $sql .= ' left outer join grc_projeto_acao proja on proja.idt = e.idt_acao';
            $sql .= ' left outer join ' . db_pir_siac . 'tbpaiacao siac_acao on siac_acao.codacao = proja.codigo_sge';
            $sql .= ' where s.idt = ' . null($row_siac['idt']);
            $sql .= " and ep.contrato in ('C', 'S', 'G')";
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $rs = execsql($sql, false);

            beginTransaction($conSIAC);
            $ativoTransactionSIAC = true;

            $idx = 0;
            $gravaData = false;
            $vetHistErro = Array();

            foreach ($rs->data as $row) {
                $regOK = true;

                if ($regOK) {
                    $duplicado = '';
                    $codparceiro = codParceiroSiacWeb('F', $duplicado, $row['cpf']);

                    if ($codparceiro == '' && substr($row['codcliente'], 0, 2) != '99') {
                        $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                    }

                    if ($row['codcliente'] != $codparceiro && $codparceiro != '') {
                        if ($usaTransaction) {
                            beginTransaction();
                            $ativoTransaction = true;
                        }

                        updateCodSiacweb($row['codcliente'], $codparceiro, 'F');
                        $row['codcliente'] = $codparceiro;

                        if ($usaTransaction) {
                            commit();
                            $ativoTransaction = false;
                        }
                    }

                    if ($duplicado != '') {
                        $vetErroCons[] = "Registro duplicado no SiacWeb!" . $duplicado;
                        $regOK = false;
                    }
                }

                if ($regOK && $row['idt_atendimento_organizacao'] != '') {
                    $duplicado = '';
                    $codparceiro = codParceiroSiacWeb('J', $duplicado, $row['cnpj'], $row['nirf'], $row['dap'], $row['rmp'], $row['ie_prod_rural'], $row['sicab_codigo']);

                    if ($codparceiro == '' && substr($row['codempreendimento'], 0, 2) != '99') {
                        $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                    }

                    if ($row['codempreendimento'] != $codparceiro && $codparceiro != '') {
                        if ($usaTransaction) {
                            beginTransaction();
                            $ativoTransaction = true;
                        }

                        updateCodSiacweb($row['codempreendimento'], $codparceiro, 'J');
                        $row['codempreendimento'] = $codparceiro;

                        if ($usaTransaction) {
                            commit();
                            $ativoTransaction = false;
                        }
                    }

                    if ($duplicado != '') {
                        $vetErroCons[] = "Registro duplicado no SiacWeb!" . $duplicado;
                        $regOK = false;
                    }
                }

                if ($regOK) {
                    if (substr($row['codcliente'], 0, 2) == '99') {
                        $parametro = Array(
                            'en_Cpf' => preg_replace('/[^0-9]/i', '', $row['cpf']),
                        );

                        $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                        $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                        $rowResult = $SebareResult->data[0];

                        if ($rowResult['codparceiro'] != '') {
                            updateCodSiacweb($row['codcliente'], $rowResult['codparceiro'], 'F');

                            $row['codcliente'] = $rowResult['codparceiro'];
                        }
                    }

                    if ($row['codcliente'] == '' || substr($row['codcliente'], 0, 2) == '99') {
                        $vetErroCons[] = 'O registro da pessoa ' . $row['cpf'] . ' ' . $row['nome'] . ' (IDT: ' . $row['idt_atendimento_pessoa'] . ') não foi sincronizado!';
                        $regOK = false;
                    }

                    if (substr($row['codempreendimento'], 0, 2) == '99') {
                        $parametro = Array(
                            'en_CgcCpf' => preg_replace('/[^0-9]/i', '', $row['cnpj']),
                            'en_Email' => '',
                            'en_CPR' => '',
                        );

                        $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                        $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                        $rowResult = $SebareResult->data[0];

                        if ($rowResult['codparceiro'] != '') {
                            updateCodSiacweb($row['codempreendimento'], $rowResult['codparceiro'], 'J');

                            $row['codempreendimento'] = $rowResult['codparceiro'];
                        }
                    }

                    if ($row['idt_atendimento_organizacao'] != '' && ($row['codempreendimento'] == '' || substr($row['codempreendimento'], 0, 2) == '99')) {
                        $vetErroCons[] = 'O registro do empreendimento ' . $row['cnpj'] . ' ' . $row['razao_social'] . ' (IDT: ' . $row['idt_atendimento_organizacao'] . ') não foi sincronizado!';
                        $regOK = false;
                    }
                }

                if ($regOK) {
                    if ($row['concluido'] == 'S') {
                        $idx++;
                        $codrealizacaocomp = $idx;

                        $abordagem = 'G';

                            $vetPar = array(
                                'CodCliente' => $row['codcliente'],
                                'CodEmpreendimento' => $row['codempreendimento'],
                                'DataHoraInicioRealizacao' => $row['datahorainiciorealizacao'],
                                'DataHoraFimRealizacao' => $row['datahorafimrealizacao'],
                                'NomeRealizacao' => $row['nomerealizacao'],
                                'CodRealizacao' => $codrealizacao,
                                'CodRealizacaoComp' => $codrealizacaocomp,
                                'TipoRealizacao' => 'IUF',
                                'Instrumento' => $row['instrumento'],
                                'Abordagem' => $abordagem,
                                'DescRealizacao' => '',
                                'CodProjeto' => $row['codprojeto'],
                                'CodAcao' => $row['codacao'],
                                'MesAnoCompetencia' => $mesanocompetencia_ws,
                                'CargaHoraria' => $row['cargahoraria'],
                                'CodSebrae' => $codsebrae,
                                'Tema' => 0,
                                'CodSistemaOrigem' => 0,
                                'CpfResponsavel' => '37218628800',
                            );

                            foreach ($vetPar as $key => $value) {
                                switch ($key) {
                                    case 'CodEmpreendimento':
                                        if ($value == '') {
                                            $value = '0';
                                        }
                                        break;
                                }

                                $vetPar[$key] = $value;
                            }

                            $metodo = 'Trans_Ins_HistoricoRealizacaoCliente';
                            $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                        $rowResult = $SebareResult->data[0];

                        if (array_key_exists('erro', $rowResult)) {
                            $rowResult = Array(
                                'coderro' => $rowResult['erro'],
                                'mensagem' => $rowResult['msgerro'],
                            );
                        }

                        //Erro na consolidação com empresa
                        if ($rowResult['coderro'] == '22' || $rowResult['coderro'] == '23' || $rowResult['coderro'] == '37') {
                            $vetHistErro[] = Array(
                                'idt' => $row['idt_atendimento_pessoa'],
                                'coderro' => $rowResult['coderro'],
                                'mensagem' => $rowResult['mensagem'],
                            );

                                $vetPar['CodEmpreendimento'] = 0;

                                $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                            $rowResult = $SebareResult->data[0];

                            if (array_key_exists('erro', $rowResult)) {
                                $rowResult = Array(
                                    'coderro' => $rowResult['erro'],
                                    'mensagem' => $rowResult['msgerro'],
                                );
                            }
                        }

                        //Historico já cadastrado
                        if ($rowResult['coderro'] == '11' || $rowResult['coderro'] == '26') {
                            $sql = '';
                            $sql .= ' select h.codsebrae';
                            $sql .= ' from historicorealizacoescliente h with(nolock)';
                            $sql .= ' where h.codcliente = ' . null($row['codcliente']);
                            $sql .= ' and h.codsebrae = ' . null($codsebrae);
                            $sql .= ' and h.datahorainiciorealizacao = ' . aspa($row['datahorainiciorealizacao']);
                            $sql .= " and h.abordagem = '{$abordagem}'";
                            $sql .= " and h.nomerealizacao = " . aspa($row['nomerealizacao']);
                            $sql .= " and h.tiporealizacao = 'IUF'"; //INS
                            $sql .= " and h.instrumento = " . aspa($row['instrumento']);
                            $sql .= " and h.codrealizacao = " . null($codrealizacao);
                            $rss = execsql($sql, false, $conSIAC);

                            if ($rss->rows == 1) {
                                $rowResult = Array(
                                    'coderro' => '0',
                                    'mensagem' => '',
                                );
                            } else {
                                $vetHistErro[] = Array(
                                    'idt' => $row['idt_atendimento_pessoa'],
                                    'coderro' => $rowResult['coderro'],
                                    'mensagem' => $rowResult['mensagem'],
                                );

                                $rowResult = Array(
                                    'coderro' => '0',
                                    'mensagem' => '',
                                );
                            }
                        }
                    } else {
                        $rowResult = Array(
                            'coderro' => '0',
                            'mensagem' => '',
                        );
                    }

                    if ($rowResult['coderro'] == '0') {
                        if ($row['concluido'] == 'S') {
                            $percfreq = 100;
                            $indaprovacao = 2;
                        } else {
                            $percfreq = 1;
                            $indaprovacao = 1;
                        }

                        $sql = 'trnConsolidarParticipante';

                        $vetBindParam = Array();
                        $vetBindParam['Codevento'] = vetBindParam($codrealizacao, PDO::PARAM_INT);
                        $vetBindParam['CodParceiro'] = vetBindParam($row['codcliente'], PDO::PARAM_INT);
                        $vetBindParam['PercFreq'] = vetBindParam($percfreq, PDO::PARAM_INT);
                        $vetBindParam['DataDesist'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['IndAprovacao'] = vetBindParam($indaprovacao, PDO::PARAM_INT);
                        $vetBindParam['IndRecCertificado'] = vetBindParam(0, PDO::PARAM_INT);

                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                        $rowResult = $SebareResult->data[0];

                        if ($rowResult['error'] != '0') {
                            $vetErroCons[] = $sql . ': [' . $rowResult['error'] . '] ' . $rowResult['description'];
                            $vetErroCons[] = $vetBindParam;
                        }
                    } else {
                        if ($rowResult['coderro'] == '26') {
                            $gravaData = true;
                            $vetErroCons[] = 'O cliente ' . $row['nome'] . ' (' . $row['cpf'] . ') já possui histórico de realização registrado para esta mesma data e horário. Não é possível Consolidar este evento. Cancele a inscrição deste cliente para prosseguir.';
                        } else {
                                $vetErroCons[] = $metodo . ': [' . $rowResult['coderro'] . '] ' . $rowResult['mensagem'];
                        }

                            $inf_extra = Array(
                                'metodo' => $metodo,
                                'parametro' => $vetPar,
                                'row_siac' => $row_siac,
                            );

                            $vetErroCons[] = $inf_extra;
                    }
                }
            }

            //Consolida Evento
            if (count($vetErroCons) == 0) {
                $sql = 'trnConsolidarEvento';

                $vetBindParam = Array();
                $vetBindParam['codevento'] = vetBindParam($codrealizacao, PDO::PARAM_INT);

                if ($codresponsavel == 99) {
                    $vetBindParam['codUsuarioLogado'] = vetBindParam(null, PDO::PARAM_NULL);
                } else {
                    $vetBindParam['codUsuarioLogado'] = vetBindParam($codresponsavel, PDO::PARAM_INT);
                }

                $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                $rowResult = $SebareResult->data[0];

                if ($rowResult['error'] != '0') {
                    $vetErroCons[] = $sql . ': [' . $rowResult['error'] . '] ' . $rowResult['description'];
                    $vetErroCons[] = $vetBindParam;
                }

                if (count($vetErroCons) == 0) {
                    $sql = 'update grc_evento set mesanocompetencia = ' . aspa($mesanocompetencia);
                    $sql .= ' where idt = ' . null($row_siac['idt_evento']);
                    execsql($sql, false);

                    foreach ($vetHistErro as $rowHist) {
                        $sql = 'update grc_atendimento_pessoa set';
                        $sql .= ' siacweb_hist_erro_cod = ' . null($rowHist['coderro']) . ', ';
                        $sql .= ' siacweb_hist_erro_msg = ' . aspa($rowHist['mensagem']);
                        $sql .= ' where idt = ' . null($rowHist['idt_atendimento_pessoa']);
                        execsql($sql, false);
                    }

                    commit($conSIAC);
                    $ativoTransactionSIAC = false;

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                } else {
                    if ($ativoTransactionSIAC) {
                        rollBack($conSIAC);
                        $ativoTransactionSIAC = false;
                    }

                    $qtdErro += count($vetErroCons);
                    $erro = 'Erros na consolidação das inscrições do evento utilizando o webservice!';

                    $vetErro = array_merge($vetErro, $vetErroCons);
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

                    $sql = 'update grc_sincroniza_siac set';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                }
            } else {
                if ($ativoTransactionSIAC) {
                    rollBack($conSIAC);
                    $ativoTransactionSIAC = false;
                }

                $qtdErro += count($vetErroCons);
                $erro = 'Erros na consolidação das inscrições do evento!';

                $vetErro = array_merge($vetErro, $vetErroCons);
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

                $sql = 'update grc_sincroniza_siac set ';

                if ($gravaData) {
                    $sql .= ' dt_sincroniza = now(),';
                }

                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_DESCON->data as $row_siac) {
    try {
        set_time_limit(300);

        $sql = '';
        $sql .= ' select codigo_siacweb';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($row_siac['idt_evento']);
        $rst = execsql($sql, false);

        $codevento = $rst->data[0][0];

        if ($codevento == '') {
            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        } else {
            $vetPar = array(
                'CodRealizacao' => $codevento,
            );

            $metodo = 'Trans_Alt_ReabrirEvento';

            $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
            $rowResult = $SebareResult->data[0];

            if ($rowResult['erro'] == '0') {
                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                execsql($sql, false);
            } else {
                $qtdErro++;
                $erro = $metodo . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetPar);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_EXC->data as $row_siac) {
    try {
        set_time_limit(300);

        $vetErroCons = Array();
        $motivoRM = 'Evento cancelado no CRM';

        //Concela no RM os Dados do Pagamento
        $sql = '';
        $sql .= ' select p.idt, p.rm_idmov';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
        $sql .= ' where a.idt_evento = ' . null($row_siac['idt_evento']);
        $sql .= " and (p.estornado <> 'S' or p.estornar_rm = 'S')";
        $sql .= ' and p.rm_idmov is not null';
        $rsRM_PAG = execsql($sql, false);

        foreach ($rsRM_PAG->data as $row) {
            $funcao = 'ReadRecordAuth';

            $parametro = Array(
                'DataServerName' => 'MovMovimentoTBCData',
                'PrimaryKey' => '1;' . $row['rm_idmov'],
                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
            );

            $Z = Array('TMOV');

            $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
            $rowRM = $rsRM['TMOV']->data[0];

            if ($rowRM['status'] != 'C') {
                $xml = '';
                $xml .= '<MovCancelMovProcParams>';
                $xml .= '<MovimentosACancelar>';
                $xml .= '<MovimentosCancelar>';
                $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                $xml .= '<CodColigada>1</CodColigada>';
                $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                $xml .= '<MotivoCancelamento>' . $motivoRM . '</MotivoCancelamento>';
                $xml .= '</MovimentosCancelar>';
                $xml .= '</MovimentosACancelar>';
                $xml .= '</MovCancelMovProcParams>';

                $metodo = 'ExecuteWithParams';

                $parametro = Array(
                    'ProcessServerName' => 'MovCancelMovProc',
                    'strXmlParams' => $xml,
                );

                $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                if ($retorno == '1') {
                    $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'ERRO DO RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $parametro;
                }
            } else {
                $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                $sql .= ' where idt = ' . null($row['idt']);
                execsql($sql, false);
            }
        }

        //Cancela no RM as Ordem de Contratação
        $sql = '';
        $sql .= ' select rm.idt_gec_contratacao_credenciado_ordem, rm.mesano, rm.rm_idmov, rm.idt';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = rm.idt_gec_contratacao_credenciado_ordem';
        $sql .= ' where ord.idt_evento = ' . null($row_siac['idt_evento']);
        $sql .= " and ord.ativo = 'S'";
        $sql .= ' and rm.rm_idmov is not null';
        $sql .= " and rm.rm_cancelado = 'N'";
        $rsRM_PAG = execsql($sql, false);

        foreach ($rsRM_PAG->data as $row) {
            $funcao = 'ReadRecordAuth';

            $parametro = Array(
                'DataServerName' => 'MovMovimentoTBCData',
                'PrimaryKey' => '1;' . $row['rm_idmov'],
                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
            );

            $Z = Array('TMOV');

            $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
            $rowRM = $rsRM['TMOV']->data[0];

            if ($rowRM['status'] != 'C') {
                $xml = '';
                $xml .= '<MovCancelMovProcParams>';
                $xml .= '<MovimentosACancelar>';
                $xml .= '<MovimentosCancelar>';
                $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                $xml .= '<CodColigada>1</CodColigada>';
                $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                $xml .= '<MotivoCancelamento>' . $motivoRM . '</MotivoCancelamento>';
                $xml .= '</MovimentosCancelar>';
                $xml .= '</MovimentosACancelar>';
                $xml .= '</MovCancelMovProcParams>';

                $metodo = 'ExecuteWithParams';

                $parametro = Array(
                    'ProcessServerName' => 'MovCancelMovProc',
                    'strXmlParams' => $xml,
                );

                $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                if ($retorno == '1') {
                    $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'ERRO DO RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $parametro;
                }
            } else {
                $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                $sql .= ' where idt = ' . null($row['idt']);
                execsql($sql, false);
            }
        }

        if (count($vetErroCons) > 0) {
            $qtdErro += count($vetErroCons);
            $erro = 'Erros no cancelamento do evento!';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' select codigo_siacweb';
            $sql .= ' from grc_evento';
            $sql .= ' where idt = ' . null($row_siac['idt_evento']);
            $rst = execsql($sql, false);

            $codrealizacao = $rst->data[0][0];

            if ($codrealizacao == '') {
                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                execsql($sql, false);
            } else {
                //beginTransaction($conSIAC);
                //$ativoTransactionSIAC = true;

                $sql = 'trnExcluirParticipanteEventoWS';

                $vetBindParam = Array();
                $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                $vetBindParam['CodCliente'] = vetBindParam(0, PDO::PARAM_INT);
                $vetBindParam['CodEmpreendimento'] = vetBindParam(0, PDO::PARAM_INT);
                $vetBindParam['CodRealizacao'] = vetBindParam($codrealizacao, PDO::PARAM_INT);

                $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                $rowResult = $SebareResult->data[0];

                if ($rowResult['erro'] == '0') {
                    $sql = 'trnExcluirEvento';

                    $vetBindParam = Array();
                    $vetBindParam['CodEvento'] = vetBindParam($codrealizacao, PDO::PARAM_INT);

                    set_time_limit(300);
                    $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                    $rowResult = $SebareResult->data[0];

                    if ($rowResult['error'] == '0') {
                        //commit($conSIAC);
                        //$ativoTransactionSIAC = false;

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                        $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                        execsql($sql, false);
                    } else {
                        if ($ativoTransactionSIAC) {
                            //rollBack($conSIAC);
                            $ativoTransactionSIAC = false;
                        }

                        $qtdErro++;
                        $erro = $sql . ': [' . $rowResult['error'] . '] ' . $rowResult['description'];

                        $vetErro[] = $erro;
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetBindParam);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);
                    }
                } else if ($rowResult['erro'] == '2') {
                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                } else {
                    if ($ativoTransactionSIAC) {
                        //rollBack($conSIAC);
                        $ativoTransactionSIAC = false;
                    }

                    $qtdErro++;
                    $erro = $sql . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetBindParam);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                }
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEP->data as $row_siac) {
    try {
        set_time_limit(300);

        $sql = '';
        $sql .= ' select e.codigo_siacweb as codrealizacao, p.codigo_siacweb as codcliente, o.idt as idt_atendimento_organizacao,';
        $sql .= ' o.codigo_siacweb_e as codempreendimento, e.data_criacao as dtinscricaoinicio, o.cnpj, p.codigo as cpf,';
        $sql .= ' o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo,';
        $sql .= ' s.idt_atendimento_pessoa, s.idt_evento, e.quantidade_participante, e.qtd_vagas_adicional';
        $sql .= ' from grc_sincroniza_siac s';
        $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade p on p.idt = s.idt_entidade';
        $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = s.idt_atendimento';
        $sql .= ' where s.idt = ' . null($row_siac['idt']);
        $rs = execsql($sql, false);

        if ($usaTransaction) {
            beginTransaction();
            $ativoTransaction = true;
        }

        $naoFazNada = true;

        $vetErroCons = Array();

        foreach ($rs->data as $row) {
            $regOK = true;

            if ($regOK) {
                $duplicado = '';
                $codparceiro = codParceiroSiacWeb('F', $duplicado, $row['cpf']);

                if ($codparceiro == '' && substr($row['codcliente'], 0, 2) != '99') {
                    $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                }

                if ($row['codcliente'] != $codparceiro && $codparceiro != '') {
                    updateCodSiacweb($row['codcliente'], $codparceiro, 'F');
                    $row['codcliente'] = $codparceiro;
                }

                if ($duplicado != '') {
                    $vetErroCons[] = "Registro duplicado no SiacWeb!" . $duplicado;
                    $regOK = false;
                }
            }

            if ($regOK && $row['idt_atendimento_organizacao'] != '') {
                $duplicado = '';
                $codparceiro = codParceiroSiacWeb('J', $duplicado, $row['cnpj'], $row['nirf'], $row['dap'], $row['rmp'], $row['ie_prod_rural'], $row['sicab_codigo']);

                if ($codparceiro == '' && substr($row['codempreendimento'], 0, 2) != '99') {
                    $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                }

                if ($row['codempreendimento'] != $codparceiro && $codparceiro != '') {
                    updateCodSiacweb($row['codempreendimento'], $codparceiro, 'J');
                    $row['codempreendimento'] = $codparceiro;
                }

                if ($duplicado != '') {
                    $vetErroCons[] = "Registro duplicado no SiacWeb!" . $duplicado;
                    $regOK = false;
                }
            }

            if ($regOK) {
                if (substr($row['codcliente'], 0, 2) == '99') {
                    $parametro = Array(
                        'en_Cpf' => preg_replace('/[^0-9]/i', '', $row['cpf']),
                    );

                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                    $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                    $rowResult = $SebareResult->data[0];

                    if ($rowResult['codparceiro'] != '') {
                        updateCodSiacweb($row['codcliente'], $rowResult['codparceiro'], 'F');

                        $row['codcliente'] = $rowResult['codparceiro'];
                    }
                }

                if ($row['codcliente'] == '' || substr($row['codcliente'], 0, 2) == '99') {
                    $regOK = false;
                }

                if (substr($row['codempreendimento'], 0, 2) == '99') {
                    $parametro = Array(
                        'en_CgcCpf' => preg_replace('/[^0-9]/i', '', $row['cnpj']),
                        'en_Email' => '',
                        'en_CPR' => '',
                    );

                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                    $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                    $rowResult = $SebareResult->data[0];

                    if ($rowResult['codparceiro'] != '') {
                        updateCodSiacweb($row['codempreendimento'], $rowResult['codparceiro'], 'J');

                        $row['codempreendimento'] = $rowResult['codparceiro'];
                    }
                }

                if ($row['idt_atendimento_organizacao'] != '' && ($row['codempreendimento'] == '' || substr($row['codempreendimento'], 0, 2) == '99')) {
                    $regOK = false;
                }
            }

            if ($row['codrealizacao'] != '' && $regOK) {
                $naoFazNada = false;

                $vetPar = array(
                    'CodSebrae' => $codsebrae,
                    'CodCliente' => $row['codcliente'],
                    'CodEmpreendimento' => 0,
                    'CodRealizacao' => $row['codrealizacao'],
                    'DtInscricaoInicio' => trata_data($row['dtinscricaoinicio'], false, true),
                    'DtInscricaoFim' => date('d/m/Y', strtotime('+1 days')),
                    'Concluido' => '',
                );

                $metodo = 'Util_Rec_ParticipanteEvento';

                $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true, array('Table'));
                $rowResult = $SebareResult->data[0];

                if ($rowResult['erro'] == '') {
                    if ($rowResult['codcliente'] != '' && $rowResult['codempreendimento'] != $row['codempreendimento']) {
                        beginTransaction($conSIAC);
                        $ativoTransactionSIAC = true;

                        $sql = 'trnExcluirParticipanteEventoWS';

                        $vetBindParam = Array();
                        $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                        $vetBindParam['CodCliente'] = vetBindParam($row['codcliente'], PDO::PARAM_INT);
                        $vetBindParam['CodEmpreendimento'] = vetBindParam($rowResult['codempreendimento'], PDO::PARAM_INT);
                        $vetBindParam['CodRealizacao'] = vetBindParam($row['codrealizacao'], PDO::PARAM_INT);

                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                        $rowResultExc = $SebareResult->data[0];

                        if ($rowResultExc['erro'] == '0') {
                            commit($conSIAC);
                            $ativoTransactionSIAC = false;

                            $rowResult['codcliente'] = '';

                            $sql = "update grc_evento set qtd_matriculado_siacweb = qtd_matriculado_siacweb - 1, qtd_vagas_resevado = qtd_vagas_resevado + 1";
                            $sql .= " where idt = " . null($row['idt_evento']);
                            execsql($sql, false);

                            $sql = "update grc_atendimento_pessoa set evento_inscrito = 'N'";
                            $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                            execsql($sql, false);
                        } else {
                            if ($ativoTransactionSIAC) {
                                rollBack($conSIAC);
                                $ativoTransactionSIAC = false;
                            }

                            $erro = $sql . ': [' . $rowResultExc['erro'] . '] ' . $rowResultExc['descricao'];

                            $vetErroCons[] = $erro;
                            $vetErroCons[] = $vetBindParam;
                        }
                    }

                    if ($rowResult['codcliente'] == '') {
                        //verifica se tem que alterar a quantidade
                        if ($row['qtd_vagas_adicional'] > 0) {
                            $sql = '';
                            $sql .= " select count(pr.codpessoapf) as tot";
                            $sql .= ' from participante pr with(nolock)';
                            $sql .= ' where pr.codevento = ' . null($row['codrealizacao']);
                            $rsSIAC = execsql($sql, false, $conSIAC);
                            $qtdSiac = $rsSIAC->data[0][0];

                            if ($qtdSiac < $row['quantidade_participante'] + $row['qtd_vagas_adicional']) {
                                if ($qtdSiac < $row['quantidade_participante']) {
                                    $qtdSiac = $row['quantidade_participante'];
                                } else {
                                    $qtdSiac++;
                                }

                                $sql = '';
                                $sql .= ' select esc.unidoperacional_siacweb as codescritorio, area.codarea_siacweb as area_codigo, e.area_codigo_siacweb as evento_codarea, i.codigo_familia_siac as codfamiliaproduto,';
                                $sql .= ' p.codigo_siac as codproduto, i.codigo_tipoevento_siac as tipoevento, e.descricao as tituloevento, e.carga_horaria_total as cargahoraria,';
                                $sql .= ' e.frequencia_min as frequenciamin, e.quantidade_participante as maxparticipante, e.valor_inscricao as valorinscricao, e.qtd_dias_reservados as qtddiareserva,';
                                $sql .= ' e.qtd_minima_pagantes as minpagante, ac.codigo_proj as codprojeto, ac.codigo_siacweb as codacao, e.publica_internet as publicarportal,';
                                $sql .= ' e.dt_previsao_inicial as periodoinicial, e.dt_previsao_fim as periodofinal, e.hora_inicio as horarioinicial, e.hora_fim as horariofinal,';
                                $sql .= " l.descricao as desclocalevento, l.logradouro as descendereco, concat_ws(' / ', l.logradouro_numero, l.logradouro_complemento) as local_complemento,";
                                $sql .= ' l.logradouro_codbairro as local_codbairro, l.logradouro_codcid as local_codcid, l.logradouro_codest as local_codest, l.logradouro_codpais as local_codpais,';
                                $sql .= ' l.cep as local_cep, l.proprio as local_interno, l.codigo_siacweb as local_siacweb, e.local_codigo_siacweb as evento_codlocalevento,';
                                $sql .= ' e.codigo_siacweb as codigo_evento_siacweb, e.codigo as evento_codigo, e.idt_local, e.idt_ponto_atendimento_tela';
                                $sql .= ' from grc_evento e';
                                $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
                                $sql .= ' inner join grc_evento_local_pa l on l.idt = e.idt_local';
                                $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
                                $sql .= ' inner join grc_projeto_acao ac on ac.idt = e.idt_acao';
                                $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao esc on e.idt_unidade = esc.idt';
                                $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao area on e.idt_ponto_atendimento_tela = area.idt';
                                $sql .= ' where e.idt = ' . null($row['idt_evento']);
                                $rs_e = execsql($sql, false);
                                $row_e = $rs_e->data[0];

                                if ($row_e['valorinscricao'] == '') {
                                    $row_e['valorinscricao'] = 0;
                                }

                                $vetPar = array(
                                    'CodSebrae' => $codsebrae,
                                    'CodRealizacao' => $row['codrealizacao'],
                                    'CodEscritorio' => $row_e['codescritorio'],
                                    'CodArea' => $row_e['evento_codarea'],
                                    'CodFamiliaProduto' => $row_e['codfamiliaproduto'],
                                    'CodProduto' => $row_e['codproduto'],
                                    'TipoEvento' => $row_e['tipoevento'],
                                    'TituloEvento' => str_replace("'", '', $row_e['tituloevento']),
                                    'CargaHoraria' => $row_e['cargahoraria'],
                                    'FrequenciaMin' => $row_e['frequenciamin'],
                                    'MaxParticipante' => $qtdSiac,
                                    'ValorInscricao' => $row_e['valorinscricao'],
                                    'QtdDiaReserva' => $row_e['qtddiareserva'],
                                    'MinPagante' => $row_e['minpagante'],
                                    'CodProjeto' => $row_e['codprojeto'],
                                    'CodAcao' => $row_e['codacao'],
                                    'PublicarPortal' => $row_e['publicarportal'],
                                    'PeriodoInicial' => trata_data($row_e['periodoinicial']),
                                    'PeriodoFinal' => trata_data($row_e['periodofinal']),
                                    'HorarioInicial' => $row_e['horarioinicial'],
                                    'HorarioFinal' => $row_e['horariofinal'],
                                    'Local' => $row_e['evento_codlocalevento'],
                                    'Concluido' => 'N',
                                );

                                $metodo = 'Trans_Alt_Evento';

                                $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
                                $rowResult = $SebareResult->data[0];

                                if ($rowResult['coderro'] != '0') {
                                    $erro = $metodo . ': [' . $rowResult['coderro'] . '] ' . $rowResult['mensagem'];

                                    $vetErroCons[] = $erro;
                                    $vetErroCons[] = $vetPar;
                                }
                            }
                        }

                        if ($row['codempreendimento'] == '') {
                            $row['codempreendimento'] = 0;
                        }

                        beginTransaction($conSIAC);
                        $ativoTransactionSIAC = true;

                        $sql = 'trnIncluirParticipanteEventoWS';

                        $vetBindParam = Array();
                        $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                        $vetBindParam['CodCliente'] = vetBindParam($row['codcliente'], PDO::PARAM_INT);
                        $vetBindParam['CodEmpreendimento'] = vetBindParam($row['codempreendimento'], PDO::PARAM_INT);
                        $vetBindParam['CodRealizacao'] = vetBindParam($row['codrealizacao'], PDO::PARAM_INT);
                        $vetBindParam['Concluido'] = vetBindParam('N', PDO::PARAM_STR);

                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                        $rowResult = $SebareResult->data[0];

                        if ($rowResult['erro'] == '0') {
                            commit($conSIAC);
                            $ativoTransactionSIAC = false;

                            $sql = "update grc_evento set qtd_matriculado_siacweb = qtd_matriculado_siacweb + 1, qtd_vagas_resevado = qtd_vagas_resevado - 1";
                            $sql .= " where idt = " . null($row['idt_evento']);
                            execsql($sql, false);

                            $sql = "update grc_atendimento_pessoa set evento_inscrito = 'S'";
                            $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                            execsql($sql, false);
                        } else {
                            if ($ativoTransactionSIAC) {
                                rollBack($conSIAC);
                                $ativoTransactionSIAC = false;
                            }

                            $erro = $sql . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                            $vetErroCons[] = $erro;
                            $vetErroCons[] = $vetBindParam;
                        }
                    }
                } else {
                    $erro = $metodo . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $vetPar;
                }
            }
        }

        if (count($vetErroCons) > 0) {
            if ($usaTransaction && $ativoTransaction) {
                rollBack();
                $ativoTransaction = false;
            }

            $qtdErro += count($vetErroCons);
            $erro = 'Erros na sincronização das inscrições no evento (Inclusão)!';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            if ($usaTransaction) {
                commit();
                $ativoTransaction = false;
            }

            if (!$naoFazNada) {
                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                execsql($sql, false);
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEP_EXC->data as $row_siac) {
    try {
        set_time_limit(300);

        $sql = '';
        $sql .= ' select e.codigo_siacweb as codrealizacao, p.codigo_siacweb as codcliente,';
        $sql .= ' e.data_criacao as dtinscricaoinicio, e.quantidade_participante, e.qtd_vagas_adicional, ';
        $sql .= ' p.cpf, p.idt as idt_atendimento_pessoa, s.idt_evento';
        $sql .= ' from grc_sincroniza_siac s';
        $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
        $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = s.idt_atendimento';
        $sql .= ' where s.idt = ' . null($row_siac['idt']);
        $rs = execsql($sql, false);

        if ($usaTransaction) {
            beginTransaction();
            $ativoTransaction = true;
        }

        $vetErroCons = Array();

        foreach ($rs->data as $row) {
            $regOK = true;

            if ($regOK) {
                $duplicado = '';
                $codparceiro = codParceiroSiacWeb('F', $duplicado, $row['cpf']);

                if ($codparceiro == '' && substr($row['codcliente'], 0, 2) != '99') {
                    $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                }

                if ($row['codcliente'] != $codparceiro && $codparceiro != '') {
                    updateCodSiacweb($row['codcliente'], $codparceiro, 'F');
                    $row['codcliente'] = $codparceiro;
                }

                if ($duplicado != '') {
                    $vetErroCons[] = "Registro duplicado no SiacWeb!" . $duplicado;
                    $regOK = false;
                }
            }

            if ($regOK) {
                if (substr($row['codcliente'], 0, 2) == '99') {
                    $parametro = Array(
                        'en_Cpf' => preg_replace('/[^0-9]/i', '', $row['cpf']),
                    );

                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                    $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                    $rowResult = $SebareResult->data[0];

                    if ($rowResult['codparceiro'] != '') {
                        updateCodSiacweb($row['codcliente'], $rowResult['codparceiro'], 'F');

                        $row['codcliente'] = $rowResult['codparceiro'];
                    }
                }

                if ($row['codcliente'] == '' || substr($row['codcliente'], 0, 2) == '99') {
                    $regOK = false;
                }
            }

            if ($row['codrealizacao'] != '' && $regOK) {
                $vetPar = array(
                    'CodSebrae' => $codsebrae,
                    'CodCliente' => $row['codcliente'],
                    'CodEmpreendimento' => 0,
                    'CodRealizacao' => $row['codrealizacao'],
                    'DtInscricaoInicio' => trata_data($row['dtinscricaoinicio'], false, true),
                    'DtInscricaoFim' => date('d/m/Y', strtotime('+1 days')),
                    'Concluido' => '',
                );

                $metodo = 'Util_Rec_ParticipanteEvento';

                $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true, array('Table'));
                $rowResult = $SebareResult->data[0];

                if ($rowResult['erro'] == '') {
                    if ($rowResult['codcliente'] != '') {
                        if ($rowResult['codempreendimento'] == '') {
                            $rowResult['codempreendimento'] = 0;
                        }

                        beginTransaction($conSIAC);
                        $ativoTransactionSIAC = true;

                        $sql = 'trnExcluirParticipanteEventoWS';

                        $vetBindParam = Array();
                        $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                        $vetBindParam['CodCliente'] = vetBindParam($row['codcliente'], PDO::PARAM_INT);
                        $vetBindParam['CodEmpreendimento'] = vetBindParam($rowResult['codempreendimento'], PDO::PARAM_INT);
                        $vetBindParam['CodRealizacao'] = vetBindParam($row['codrealizacao'], PDO::PARAM_INT);

                        $SebareResult = execsql($sql, false, $conSIAC, $vetBindParam);
                        $rowResultExc = $SebareResult->data[0];

                        if ($rowResultExc['erro'] == '0') {
                            commit($conSIAC);
                            $ativoTransactionSIAC = false;

                            $sql = "update grc_evento set qtd_matriculado_siacweb = qtd_matriculado_siacweb - 1, qtd_vagas_resevado = qtd_vagas_resevado + 1";
                            $sql .= " where idt = " . null($row['idt_evento']);
                            execsql($sql, false);

                            $sql = "update grc_atendimento_pessoa set evento_inscrito = 'N'";
                            $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                            execsql($sql, false);

                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                            execsql($sql, false);

                            //verifica se tem que alterar a quantidade
                            if ($row['qtd_vagas_adicional'] > 0) {
                                $sql = '';
                                $sql .= " select count(pr.codpessoapf) as tot";
                                $sql .= ' from participante pr with(nolock)';
                                $sql .= ' where pr.codevento = ' . null($row['codrealizacao']);
                                $rsSIAC = execsql($sql, false, $conSIAC);
                                $qtdSiac = $rsSIAC->data[0][0];

                                if ($qtdSiac > $row['quantidade_participante']) {
                                    $sql = '';
                                    $sql .= ' select esc.unidoperacional_siacweb as codescritorio, area.codarea_siacweb as area_codigo, e.area_codigo_siacweb as evento_codarea, i.codigo_familia_siac as codfamiliaproduto,';
                                    $sql .= ' p.codigo_siac as codproduto, i.codigo_tipoevento_siac as tipoevento, e.descricao as tituloevento, e.carga_horaria_total as cargahoraria,';
                                    $sql .= ' e.frequencia_min as frequenciamin, e.quantidade_participante as maxparticipante, e.valor_inscricao as valorinscricao, e.qtd_dias_reservados as qtddiareserva,';
                                    $sql .= ' e.qtd_minima_pagantes as minpagante, ac.codigo_proj as codprojeto, ac.codigo_siacweb as codacao, e.publica_internet as publicarportal,';
                                    $sql .= ' e.dt_previsao_inicial as periodoinicial, e.dt_previsao_fim as periodofinal, e.hora_inicio as horarioinicial, e.hora_fim as horariofinal,';
                                    $sql .= " l.descricao as desclocalevento, l.logradouro as descendereco, concat_ws(' / ', l.logradouro_numero, l.logradouro_complemento) as local_complemento,";
                                    $sql .= ' l.logradouro_codbairro as local_codbairro, l.logradouro_codcid as local_codcid, l.logradouro_codest as local_codest, l.logradouro_codpais as local_codpais,';
                                    $sql .= ' l.cep as local_cep, l.proprio as local_interno, l.codigo_siacweb as local_siacweb, e.local_codigo_siacweb as evento_codlocalevento,';
                                    $sql .= ' e.codigo_siacweb as codigo_evento_siacweb, e.codigo as evento_codigo, e.idt_local, e.idt_ponto_atendimento_tela';
                                    $sql .= ' from grc_evento e';
                                    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
                                    $sql .= ' inner join grc_evento_local_pa l on l.idt = e.idt_local';
                                    $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
                                    $sql .= ' inner join grc_projeto_acao ac on ac.idt = e.idt_acao';
                                    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao esc on e.idt_unidade = esc.idt';
                                    $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao area on e.idt_ponto_atendimento_tela = area.idt';
                                    $sql .= ' where e.idt = ' . null($row['idt_evento']);
                                    $rs_e = execsql($sql, false);
                                    $row_e = $rs_e->data[0];

                                    if ($row_e['valorinscricao'] == '') {
                                        $row_e['valorinscricao'] = 0;
                                    }

                                    $vetPar = array(
                                        'CodSebrae' => $codsebrae,
                                        'CodRealizacao' => $row['codrealizacao'],
                                        'CodEscritorio' => $row_e['codescritorio'],
                                        'CodArea' => $row_e['evento_codarea'],
                                        'CodFamiliaProduto' => $row_e['codfamiliaproduto'],
                                        'CodProduto' => $row_e['codproduto'],
                                        'TipoEvento' => $row_e['tipoevento'],
                                        'TituloEvento' => str_replace("'", '', $row_e['tituloevento']),
                                        'CargaHoraria' => $row_e['cargahoraria'],
                                        'FrequenciaMin' => $row_e['frequenciamin'],
                                        'MaxParticipante' => $qtdSiac,
                                        'ValorInscricao' => $row_e['valorinscricao'],
                                        'QtdDiaReserva' => $row_e['qtddiareserva'],
                                        'MinPagante' => $row_e['minpagante'],
                                        'CodProjeto' => $row_e['codprojeto'],
                                        'CodAcao' => $row_e['codacao'],
                                        'PublicarPortal' => $row_e['publicarportal'],
                                        'PeriodoInicial' => trata_data($row_e['periodoinicial']),
                                        'PeriodoFinal' => trata_data($row_e['periodofinal']),
                                        'HorarioInicial' => $row_e['horarioinicial'],
                                        'HorarioFinal' => $row_e['horariofinal'],
                                        'Local' => $row_e['evento_codlocalevento'],
                                        'Concluido' => 'N',
                                    );

                                    $metodo = 'Trans_Alt_Evento';

                                    $SebareResult = $SebraeSIACevt->executa($metodo, $vetPar, 'Table1', true);
                                    $rowResult = $SebareResult->data[0];

                                    if ($rowResult['coderro'] != '0') {
                                        $erro = $metodo . ': [' . $rowResult['coderro'] . '] ' . $rowResult['mensagem'];

                                        $vetErroCons[] = $erro;
                                        $vetErroCons[] = $vetPar;
                                    }
                                }
                            }
                        } else {
                            if ($ativoTransactionSIAC) {
                                rollBack($conSIAC);
                                $ativoTransactionSIAC = false;
                            }

                            $erro = $sql . ': [' . $rowResultExc['erro'] . '] ' . $rowResultExc['descricao'];

                            $vetErroCons[] = $erro;
                            $vetErroCons[] = $vetBindParam;
                        }
                    }
                } else {
                    $erro = $metodo . ': [' . $rowResult['erro'] . '] ' . $rowResult['descricao'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $vetPar;
                }
            }
        }

        if (count($vetErroCons) > 0) {
            if ($usaTransaction && $ativoTransaction) {
                rollBack();
                $ativoTransaction = false;
            }

            $qtdErro += count($vetErroCons);
            $erro = 'Erros na sincronização das inscrições no evento! (Exclusão)';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            if ($usaTransaction) {
                commit();
                $ativoTransaction = false;
            }

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_CLD->data as $row_siac) {
    try {
        criaCLD($row_siac);
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEP_CLD->data as $row_siac) {
    try {
        criaCLD($row_siac);
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEP_EXC_CLD->data as $row_siac) {
    try {
        set_time_limit(300);

        $vetErroCons = Array();
        $motivoRM = 'Evento cancelado no CRM';

        //Concela no RM os Dados do Pagamento
        $sql = '';
        $sql .= ' select p.idt, p.rm_idmov';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
        $sql .= ' where a.idt_evento = ' . null($row_siac['idt_evento']);
        $sql .= ' and a.idt = ' . null($row_siac['idt_atendimento']);
        $sql .= " and (p.estornado <> 'S' or p.estornar_rm = 'S')";
        $sql .= ' and p.rm_idmov is not null';
        $rsRM_PAG = execsql($sql, false);

        foreach ($rsRM_PAG->data as $row) {
            $funcao = 'ReadRecordAuth';

            $parametro = Array(
                'DataServerName' => 'MovMovimentoTBCData',
                'PrimaryKey' => '1;' . $row['rm_idmov'],
                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
            );

            $Z = Array('TMOV');

            $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
            $rowRM = $rsRM['TMOV']->data[0];

            if ($rowRM['status'] != 'C') {
                $xml = '';
                $xml .= '<MovCancelMovProcParams>';
                $xml .= '<MovimentosACancelar>';
                $xml .= '<MovimentosCancelar>';
                $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                $xml .= '<CodColigada>1</CodColigada>';
                $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                $xml .= '<MotivoCancelamento>' . $motivoRM . '</MotivoCancelamento>';
                $xml .= '</MovimentosCancelar>';
                $xml .= '</MovimentosACancelar>';
                $xml .= '</MovCancelMovProcParams>';

                $metodo = 'ExecuteWithParams';

                $parametro = Array(
                    'ProcessServerName' => 'MovCancelMovProc',
                    'strXmlParams' => $xml,
                );

                $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                if ($retorno == '1') {
                    $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $parametro;
                }
            } else {
                $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                $sql .= ' where idt = ' . null($row['idt']);
                execsql($sql, false);
            }
        }

        if (count($vetErroCons) > 0) {
            $qtdErro += count($vetErroCons);
            $erro = 'Erros no cancelamento da inscrição do evento!';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' select p.siacweb_codcosultoria as codconsultoria, u.codparceiro_siacweb as codresponsavel,';
            $sql .= ' e.motivo_cancelamento as obscancelamento, m.codigo as codmotivorecisao';
            $sql .= ' from grc_evento e';
            $sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
            $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_gestor_evento';
            $sql .= ' left outer join grc_evento_motivo_cancelamento m on m.idt = e.idt_evento_motivo_cancelamento';
            $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
            $sql .= ' and a.idt = ' . null($row_siac['idt_atendimento']);
            $rs = execsql($sql, false);

            beginTransaction($conSIAC);
            $ativoTransactionSIAC = true;

            foreach ($rs->data as $row) {
                if ($row['codconsultoria'] != '') {
                    if ($row['codmotivorecisao'] == '') {
                        $row['codmotivorecisao'] = 3;
                    }

                    $sql = '';
                    $sql .= ' sp_executesql';
                    $sql .= " N'";
                    $sql .= ' update cons_consultoria set Situacao = @Situacao, CodResponsavel = @CodResponsavel,';
                    $sql .= ' DtCancelamento = @DtCancelamento, ObsCancelamento = @ObsCancelamento, CodMotivoRecisao = @CodMotivoRecisao';
                    $sql .= ' where CodConsultoria = @CodConsultoria';
                    $sql .= ' and CodSebrae = @CodSebrae';
                    $sql .= " ',";
                    $sql .= " N'";
                    $sql .= ' @CodConsultoria int, @CodSebrae int, @Situacao varchar(11), @CodResponsavel int, @DtCancelamento datetime,';
                    $sql .= ' @ObsCancelamento varchar(100), @CodMotivoRecisao int';
                    $sql .= " '";
                    $sql .= ', ' . null($row['codconsultoria']);
                    $sql .= ', ' . null($codsebrae);
                    $sql .= ", 'Cancelada'";
                    $sql .= ', ' . null($row['codresponsavel']);
                    $sql .= ', ' . aspa(trata_data(getdata(true, true, true), true));
                    $sql .= ', ' . aspa($row['obscancelamento']);
                    $sql .= ', ' . null($row['codmotivorecisao']);
                    execsql($sql, false, $conSIAC, true);
                }
            }

            commit($conSIAC);
            $ativoTransactionSIAC = false;

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_CON_AT_CLD->data as $row_siac) {
    try {
        $sql = '';
        $sql .= ' select ea.idt, ea.atividade, ea.siacweb_codatividade, ts.codigo as codtema,';
        $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.dt_ini) as dt_ini, max(ag.dt_fim) as dt_fim,';
        $sql .= ' sum(ag.carga_horaria_real) as carga_horaria_real, min(ag.dt_ini_real) as dt_ini_real, max(ag.dt_fim_real) as dt_fim_real,';
        $sql .= ' avg(ag.valor_hora) as valor_hora, max(ag.competencia) as competencia,';
        $sql .= " group_concat(ag.obs_real separator ' |@^@| ') as desccomentario";
        $sql .= ' from grc_evento_atividade ea';
        $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
        $sql .= ' left outer join grc_tema_subtema ts on ts.idt = ea.idt_subtema';
        $sql .= ' where ea.idt = ' . null($row_siac['idt_evento_atividade']);
        $sql .= ' and ea.siacweb_codatividade is not null';
        $sql .= " and ea.consolidado_cred = 'S'";
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' group by ea.idt, ea.atividade, ea.siacweb_codatividade, ts.codigo';
        $rs_ea = execsql($sql, false);

        if ($rs_ea->rows == 0) {
            $qtdErro++;
            $erro = 'Atividade do Evento não localizado no GRC!';

            $vetErro[] = $erro;
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $vetAtOK = Array();

                beginTransaction($conSIAC);
                $ativoTransactionSIAC = true;

                foreach ($rs_ea->data as $row_ea) {
                    $codtema = preg_replace('/[^0-9]/i', '', $row_ea['codtema']);
                    $desccomentario = str_replace(' |@^@| ', ' ' . chr(13), $row_ea['desccomentario']);

                    $vetBindParam = Array();
                    $vetBindParam['CodAtividade'] = vetBindParam($row_ea['siacweb_codatividade'], PDO::PARAM_INT);
                    $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                    $vetBindParam['CargaHoraria'] = vetBindParam($row_ea['carga_horaria'], PDO::PARAM_INT);
                    $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                    $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                    $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                    $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                    $vetBindParam['DtInicioReal'] = vetBindParam($row_ea['dt_ini_real'], PDO::PARAM_STR);
                    $vetBindParam['DtFimReal'] = vetBindParam($row_ea['dt_fim_real'], PDO::PARAM_STR);
                    $vetBindParam['CargaHorariaReal'] = vetBindParam($row_ea['carga_horaria_real'], PDO::PARAM_INT);
                    $vetBindParam['DescComentario'] = vetBindParam($desccomentario, PDO::PARAM_STR);
                    $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                    $vetBindParam['CodConsultoria'] = vetBindParam($row_siac['codconsultoria'], PDO::PARAM_INT);
                    $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                    $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                    $sql = 'ConsAtualizaAtividadeConsultoria';

                    execsql($sql, false, $conSIAC, $vetBindParam);

                    $vetAtOK[] = $row_ea['idt'];
                        }

                    commit($conSIAC);
                    $ativoTransactionSIAC = false;

                    if (count($vetAtOK) > 0) {
                        $sql = "update grc_evento_atividade set consolidado_siacweb = 'S'";
                        $sql .= ' where idt in (' . implode(', ', $vetAtOK) . ')';
                        execsql($sql, false);
                    }

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                    }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_AT_EXC_CLD->data as $row_siac) {
    try {
        $sql = '';
        $sql .= ' select ea.idt, ea.atividade, ea.siacweb_codatividade, ea.consolidado_siacweb, ts.codigo as codtema,';
        $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.dt_ini) as dt_ini, max(ag.dt_fim) as dt_fim,';
        $sql .= ' avg(ag.valor_hora) as valor_hora, max(ag.competencia) as competencia';
        $sql .= ' from grc_evento_atividade ea';
        $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
        $sql .= ' left outer join grc_tema_subtema ts on ts.idt = ea.idt_subtema';
        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
        $sql .= ' where ea.idt = ' . null($row_siac['idt_evento_atividade']);
        $sql .= ' and ea.siacweb_codatividade is not null';
        $sql .= " and ea.consolidado_cred = 'S'";
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' group by ea.idt, ea.atividade, ea.siacweb_codatividade, ea.consolidado_siacweb, ts.codigo';
        $rs_ea = execsql($sql, false);

        if ($rs_ea->rows == 0) {
            $qtdErro++;
            $erro = 'Atividade do Evento não localizado no GRC!';

            $vetErro[] = $erro;
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $row_siac);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $vetAtOK = Array();

                beginTransaction($conSIAC);
                $ativoTransactionSIAC = true;

                foreach ($rs_ea->data as $row_ea) {
                    if ($row_ea['consolidado_siacweb'] == 'S') {
                        $codtema = preg_replace('/[^0-9]/i', '', $row_ea['codtema']);

                        $vetBindParam = Array();
                        $vetBindParam['CodAtividade'] = vetBindParam($row_ea['siacweb_codatividade'], PDO::PARAM_INT);
                        $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                        $vetBindParam['CargaHoraria'] = vetBindParam($row_ea['carga_horaria'], PDO::PARAM_INT);
                        $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                        $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                        $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                        $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                        $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['CargaHorariaReal'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                        $vetBindParam['CodConsultoria'] = vetBindParam($row_siac['codconsultoria'], PDO::PARAM_INT);
                        $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                        $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                        $sql = 'ConsAtualizaAtividadeConsultoria';

                        execsql($sql, false, $conSIAC, $vetBindParam);

                        $vetAtOK[] = $row_ea['idt'];
                            }
                            }

                    commit($conSIAC);
                    $ativoTransactionSIAC = false;

                    if (count($vetAtOK) > 0) {
                        $sql = "update grc_evento_atividade set consolidado_siacweb = 'N'";
                        $sql .= ' where idt in (' . implode(', ', $vetAtOK) . ')';
                        execsql($sql, false);
                    }

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                    }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_CON_CLD->data as $row_siac) {
    try {
        set_time_limit(300);

        $regOK = true;
        $vetAtOK = Array();
        $vetErroCons = Array();
        $vetHistErro = Array();

        $sql = '';
        $sql .= ' select a.idt as idt_atendimento, p.siacweb_codcosultoria as codconsultoria, u.codparceiro_siacweb as codresponsavel,';
        $sql .= ' e.resultados_obtidos, e.tipo_sincroniza_siacweb, e.idt_produto, e.codigo, e.nao_sincroniza_rm, e.cred_necessita_credenciado,';
            $sql .= ' p.idt as idt_atendimento_pessoa, e.dt_previsao_inicial as datahorainiciorealizacao, e.dt_previsao_fim as datahorafimrealizacao';
        $sql .= ' from grc_evento e';
        $sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
        $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
        $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
        $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_gestor_evento';
        $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
        $sql .= " and ep.contrato in ('C', 'S', 'G')";
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rs_e = execsql($sql, false);

        beginTransaction($conSIAC);
        $ativoTransactionSIAC = true;

        foreach ($rs_e->data as $row_e) {
                $carga_horaria_tot = 0;
                $carga_horaria_real_tot = 0;

            if ($row_e['resultados_obtidos'] == '') {
                $row_e['resultados_obtidos'] = 'Resultados Obtidos não informado (legado)';
            }

            if ($row_e['tipo_sincroniza_siacweb'] != 'P' || $row_e['nao_sincroniza_rm'] == 'S' || ($row_e['tipo_sincroniza_siacweb'] == 'P' && $row_e['cred_necessita_credenciado'] == 'N')) {
                $sql = '';
                $sql .= ' update grc_evento_agenda set';
                $sql .= ' data_inicial_real = data_inicial, ';
                $sql .= ' hora_inicial_real = hora_inicial, ';
                $sql .= ' dt_ini_real = dt_ini, ';
                $sql .= ' data_final_real = data_final, ';
                $sql .= ' hora_final_real = hora_final, ';
                $sql .= ' dt_fim_real = dt_fim, ';
                $sql .= ' carga_horaria_real = carga_horaria';
                $sql .= ' where idt_atendimento = ' . null($row_e['idt_atendimento']);
                execsql($sql, false);

                $sql = '';
                $sql .= ' select ft.codigo';
                $sql .= ' from grc_produto p';
                $sql .= ' inner join grc_foco_tematico ft on ft.idt = p.idt_foco_tematico';
                $sql .= ' where p.idt = ' . null($row_e['idt_produto']);
                $rsf = execsql($sql, false);
                $cod_foco_tematico = $rsf->data[0][0];

                $sql = '';
                    $sql .= ' select min(dt_ini_real) as datahorainiciorealizacao, max(dt_fim_real) as datahorafimrealizacao';
                    $sql .= ' from grc_evento_agenda';
                    $sql .= ' where idt_atendimento = ' . null($row_e['idt_atendimento']);
                    $rs_ea = execsql($sql, false);
                    $row_dtEvento = $rs_ea->data[0];

                    $sql = '';
                $sql .= ' select ea.idt, ea.atividade, ea.siacweb_codatividade, ts.codigo as codtema,';
                $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.dt_ini) as dt_ini, max(ag.dt_fim) as dt_fim,';
                $sql .= ' sum(ag.carga_horaria_real) as carga_horaria_real, min(ag.dt_ini_real) as dt_ini_real, max(ag.dt_fim_real) as dt_fim_real,';
                $sql .= ' avg(ag.valor_hora) as valor_hora, max(ag.competencia) as competencia';
                $sql .= ' from grc_evento_atividade ea';
                $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
                $sql .= ' left outer join grc_tema_subtema ts on ts.idt = ea.idt_subtema';
                $sql .= ' where ea.idt_atendimento = ' . null($row_e['idt_atendimento']);
                $sql .= ' and ea.siacweb_codatividade is not null';
                //$sql .= " and ea.consolidado_cred = 'S'";
                $sql .= ' group by ea.idt, ea.atividade, ea.siacweb_codatividade';
                $rs_ea = execsql($sql, false);

                $sql = '';
                $sql .= ' select p.codigo_siacweb as codcliente, p.cpf, p.nome, p.idt as idt_atendimento_pessoa,';
                $sql .= ' o.codigo_siacweb_e as codempreendimento, o.idt as idt_atendimento_organizacao,';
                $sql .= " e.descricao as nomerealizacao, inst.descricao_siacweb as instrumento,";
                $sql .= ' proj.codigo_sge as codprojeto, siac_acao.codacao_seq as codacao,';
                $sql .= ' o.cnpj, o.razao_social, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo,';
                $sql .= ' u.codparceiro_siacweb as codresponsavel, rc.codparceiro_siacweb as rc_codresponsavel';
                $sql .= ' from grc_atendimento a';
                $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
                $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
                $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
                $sql .= ' inner join grc_atendimento_instrumento inst on inst.idt = e.idt_instrumento';
                $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_gestor_evento';
                $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt';
                $sql .= ' left outer join grc_projeto proj on proj.idt = e.idt_projeto';
                $sql .= ' left outer join grc_projeto_acao proja on proja.idt = e.idt_acao';
                $sql .= ' left outer join ' . db_pir_siac . 'tbpaiacao siac_acao on siac_acao.codacao = proja.codigo_sge';
                $sql .= ' left outer join plu_usuario rc on rc.id_usuario = e.idt_responsavel_consultor';
                $sql .= ' where p.idt = ' . null($row_e['idt_atendimento_pessoa']);
                $sql .= " and ep.contrato in ('C', 'S', 'G')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs_mat = execsql($sql, false);

                foreach ($rs_mat->data as $idx_p => $row_p) {
                    if ($regOK) {
                        $duplicado = '';
                        $codparceiro = codParceiroSiacWeb('F', $duplicado, $row_p['cpf']);

                        if ($codparceiro == '' && substr($row_p['codcliente'], 0, 2) != '99') {
                            $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                        }

                        if ($row_p['codcliente'] != $codparceiro && $codparceiro != '') {
                            if ($usaTransaction) {
                                beginTransaction();
                                $ativoTransaction = true;
                            }

                            updateCodSiacweb($row_p['codcliente'], $codparceiro, 'F');
                            $row_p['codcliente'] = $codparceiro;

                            if ($usaTransaction) {
                                commit();
                                $ativoTransaction = false;
                            }
                        }

                        if ($duplicado != '') {
                            $erro = "Registro duplicado no SiacWeb!" . $duplicado;
                            $vetErroCons[] = $erro;
                            $regOK = false;
                        }
                    }

                    if ($regOK && $row_p['idt_atendimento_organizacao'] != '') {
                        $duplicado = '';
                        $codparceiro = codParceiroSiacWeb('J', $duplicado, $row_p['cnpj'], $row_p['nirf'], $row_p['dap'], $row_p['rmp'], $row_p['ie_prod_rural'], $row_p['sicab_codigo']);

                        if ($codparceiro == '' && substr($row_p['codempreendimento'], 0, 2) != '99') {
                            $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                        }

                        if ($row_p['codempreendimento'] != $codparceiro && $codparceiro != '') {
                            if ($usaTransaction) {
                                beginTransaction();
                                $ativoTransaction = true;
                            }

                            updateCodSiacweb($row_p['codempreendimento'], $codparceiro, 'J');
                            $row_p['codempreendimento'] = $codparceiro;

                            if ($usaTransaction) {
                                commit();
                                $ativoTransaction = false;
                            }
                        }

                        if ($duplicado != '') {
                            $erro = "Registro duplicado no SiacWeb!" . $duplicado;
                            $vetErroCons[] = $erro;
                            $regOK = false;
                        }
                    }

                    if ($regOK) {
                        if (substr($row_p['codcliente'], 0, 2) == '99') {
                            $parametro = Array(
                                'en_Cpf' => preg_replace('/[^0-9]/i', '', $row_p['cpf']),
                            );

                            $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                            $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                            $rowResult = $SebareResult->data[0];

                            if ($rowResult['codparceiro'] != '') {
                                updateCodSiacweb($row_p['codcliente'], $rowResult['codparceiro'], 'F');

                                $row_p['codcliente'] = $rowResult['codparceiro'];
                            }
                        }

                        if ($row_p['codcliente'] == '' || substr($row_p['codcliente'], 0, 2) == '99') {
                            $erro = 'O registro da pessoa ' . $row_p['cpf'] . ' ' . $row_p['nome'] . ' (IDT: ' . $row_p['idt_atendimento_pessoa'] . ') não foi sincronizado!';
                            $vetErroCons[] = $erro;
                            $regOK = false;
                        }

                        if (substr($row_p['codempreendimento'], 0, 2) == '99') {
                            $parametro = Array(
                                'en_CgcCpf' => preg_replace('/[^0-9]/i', '', $row_p['cnpj']),
                                'en_Email' => '',
                                'en_CPR' => '',
                            );

                            $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                            $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                            $rowResult = $SebareResult->data[0];

                            if ($rowResult['codparceiro'] != '') {
                                updateCodSiacweb($row_p['codempreendimento'], $rowResult['codparceiro'], 'J');

                                $row_p['codempreendimento'] = $rowResult['codparceiro'];
                            }
                        }

                        if ($row_p['idt_atendimento_organizacao'] != '' && ($row_p['codempreendimento'] == '' || substr($row_p['codempreendimento'], 0, 2) == '99')) {
                            $erro = 'O registro do empreendimento ' . $row_p['cnpj'] . ' ' . $row_p['razao_social'] . ' (IDT: ' . $row_p['idt_atendimento_organizacao'] . ') não foi sincronizado!';
                            $vetErroCons[] = $erro;
                            $regOK = false;
                        }
                    }

                    $rs_mat->data[$idx_p] = $row_p;
                }

                if ($regOK) {
                    foreach ($rs_ea->data as $idx => $row_ea) {
                        $idx++;

                        if ($row_e['nao_sincroniza_rm'] == 'S' || ($row_e['tipo_sincroniza_siacweb'] == 'P' && $row_e['cred_necessita_credenciado'] == 'N')) {
                            $seg = '00';
                            $codtema = preg_replace('/[^0-9]/i', '', $row_ea['codtema']);
                            $carga_horaria = $row_ea['carga_horaria'];
                            $carga_horaria_real = $row_ea['carga_horaria_real'];
                        } else {
                            if ($idx < 10) {
                                $seg = '0' . $idx;
                            } else {
                                $seg = $idx;
                            }

                            $codtema = $vetFocoTematicoTema[$cod_foco_tematico];

                            if ($row_e['tipo_sincroniza_siacweb'] == 'LHR') {
                                $carga_horaria = $row_ea['carga_horaria'] / $rs_e->rows;
                                $carga_horaria_real = $row_ea['carga_horaria_real'] / $rs_e->rows;
                            } else {
                                $carga_horaria = $row_ea['carga_horaria'];
                                $carga_horaria_real = $row_ea['carga_horaria_real'];
                            }
                        }

                            $carga_horaria_tot += $carga_horaria;
                            $carga_horaria_real_tot += $carga_horaria_real;

                        $vetBindParam = Array();
                        $vetBindParam['CodAtividade'] = vetBindParam($row_ea['siacweb_codatividade'], PDO::PARAM_INT);
                        $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                        $vetBindParam['CargaHoraria'] = vetBindParam($carga_horaria, PDO::PARAM_INT);
                        $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                        $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                        $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                        $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                        $vetBindParam['DtInicioReal'] = vetBindParam($row_ea['dt_ini_real'], PDO::PARAM_STR);
                        $vetBindParam['DtFimReal'] = vetBindParam($row_ea['dt_fim_real'], PDO::PARAM_STR);
                        $vetBindParam['CargaHorariaReal'] = vetBindParam($carga_horaria_real, PDO::PARAM_INT);
                        $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                        $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                        $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                        $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                        $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                        $sql = 'ConsAtualizaAtividadeConsultoria';

                        execsql($sql, false, $conSIAC, $vetBindParam);

                        $vetAtOK[] = $row_ea['idt'];
                        }
                    }
                }

                if ($regOK) {
                    $sql = 'ConsAtualizarConsultoriaConsolidacao';

                    $vetBindParam = Array();
                    $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                    $vetBindParam['Situacao'] = vetBindParam('Consolidada');
                    $vetBindParam['CodResponsavel'] = vetBindParam($row_e['codresponsavel'], PDO::PARAM_INT);
                    $vetBindParam['CodTema'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['CodAreaTematica'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['DescTema'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['ResultadosObtidos'] = vetBindParam($row_e['resultados_obtidos']);
                    $vetBindParam['DtInicioReal'] = vetBindParam($row_dtEvento['datahorainiciorealizacao'], PDO::PARAM_STR);
                    $vetBindParam['DtFimReal'] = vetBindParam($row_dtEvento['datahorafimrealizacao'], PDO::PARAM_STR);

                    execsql($sql, false, $conSIAC, $vetBindParam);

                    if ($row_e['tipo_sincroniza_siacweb'] != 'P' || $row_e['nao_sincroniza_rm'] == 'S' || ($row_e['tipo_sincroniza_siacweb'] == 'P' && $row_e['cred_necessita_credenciado'] == 'N')) {
                        $sql = '';
                        $sql .= " select dbo.FN_RetornarMesAnoCompetencia('" . $row_e['datahorafimrealizacao'] . "', GETDATE()) as dt";
                        $rstt = execsql($sql, false, $conSIAC);

                        $mesanocompetencia = $rstt->data[0][0];

                        $mesanocompetencia_ws = DatetoArray(trata_data($mesanocompetencia));
                        $mesanocompetencia_ws = $mesanocompetencia_ws['mes'] . $mesanocompetencia_ws['ano'];

                        foreach ($rs_mat->data as $row_p) {
                            $descrealizacao = '';
                            $descrealizacao .= 'Consultoria: ' . $row_e['codigo'] . ' - ' . $row_p['nomerealizacao'];

                            if ($row_p['rc_codresponsavel'] == '') {
                                $codresponsavel = $row_p['codresponsavel'];
                            } else {
                                $codresponsavel = $row_p['rc_codresponsavel'];
                            }

                            $DataHoraInicioRealizacao = substr($row_dtEvento['datahorainiciorealizacao'], 0, 17) . $seg;
                            $DataHoraFimRealizacao = substr($row_dtEvento['datahorafimrealizacao'], 0, 17) . $seg;

                            $vetPar = array(
                                'CodCliente' => $row_p['codcliente'],
                                'CodEmpreendimento' => $row_p['codempreendimento'],
                                'DataHoraInicioRealizacao' => $DataHoraInicioRealizacao,
                                'DataHoraFimRealizacao' => $DataHoraFimRealizacao,
                                'NomeRealizacao' => 'CONSULTORIA INDIVIDUAL',
                                'CodRealizacao' => $row_e['codconsultoria'],
                                'CodRealizacaoComp' => 0,
                                'TipoRealizacao' => 'IUF',
                                'Instrumento' => $row_p['instrumento'],
                                'Abordagem' => 'I',
                                'DescRealizacao' => $descrealizacao,
                                'CodProjeto' => $row_p['codprojeto'],
                                'CodAcao' => $row_p['codacao'],
                                'MesAnoCompetencia' => $mesanocompetencia_ws,
                                'CargaHoraria' => $carga_horaria_real_tot,
                                'CodSebrae' => $codsebrae,
                                'Tema' => 0,
                                'CodSistemaOrigem' => 0,
                                'CpfResponsavel' => '37218628800',
                            );

                            foreach ($vetPar as $key => $value) {
                                switch ($key) {
                                    case 'CodEmpreendimento':
                                        if ($value == '') {
                                            $value = '0';
                                        }
                                        break;
                                }

                                $vetPar[$key] = $value;
                            }

                            $metodo = 'Trans_Ins_HistoricoRealizacaoCliente';
                            $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                            $rowResult = $SebareResult->data[0];

                            if (array_key_exists('erro', $rowResult)) {
                                $rowResult = Array(
                                    'coderro' => $rowResult['erro'],
                                    'mensagem' => $rowResult['msgerro'],
                                );
                            }

                            //Erro na consolidação com empresa
                            if ($rowResult['coderro'] == '22' || $rowResult['coderro'] == '23' || $rowResult['coderro'] == '37') {
                                $vetHistErro[] = Array(
                                    'idt' => $row_p['idt_atendimento_pessoa'],
                                    'coderro' => $rowResult['coderro'],
                                    'mensagem' => $rowResult['mensagem'],
                                );

                                $vetPar['CodEmpreendimento'] = 0;

                                $SebareResult = $SebraeSIAChist->executa($metodo, $vetPar, 'Table1', true);
                                $rowResult = $SebareResult->data[0];

                                if (array_key_exists('erro', $rowResult)) {
                                    $rowResult = Array(
                                        'coderro' => $rowResult['erro'],
                                        'mensagem' => $rowResult['msgerro'],
                                    );
                                }
                            }

                            //Historico já cadastrado
                            if ($rowResult['coderro'] == '11' || $rowResult['coderro'] == '26') {
                                $sql = '';
                                $sql .= ' select h.codsebrae';
                                $sql .= ' from historicorealizacoescliente h with(nolock)';
                                $sql .= ' where h.codcliente = ' . null($row_p['codcliente']);
                                $sql .= ' and h.codsebrae = ' . null($codsebrae);
                                $sql .= ' and h.datahorainiciorealizacao = ' . aspa($DataHoraInicioRealizacao);
                                $sql .= " and h.nomerealizacao = 'CONSULTORIA INDIVIDUAL'";
                                $sql .= " and h.abordagem = 'I'";
                                $sql .= " and h.tiporealizacao = 'IUF'"; //CON
                                $sql .= " and h.instrumento = " . aspa($row_p['instrumento']);
                                $sql .= " and h.codrealizacao = " . null($row_e['codconsultoria']);
                                $sql .= " and h.codrealizacaocomp = 0";
                                $rss = execsql($sql, false, $conSIAC);

                                if ($rss->rows == 1) {
                                    $rowResult = Array(
                                        'coderro' => '0',
                                        'mensagem' => '',
                                    );
                                } else {
                                    $vetHistErro[] = Array(
                                        'idt' => $row['idt_atendimento_pessoa'],
                                        'coderro' => $rowResult['coderro'],
                                        'mensagem' => $rowResult['mensagem'],
                                    );

                                    $rowResult = Array(
                                        'coderro' => '0',
                                        'mensagem' => '',
                                    );
                                }
                            }

                            if ($rowResult['coderro'] != '0') {
                                if ($rowResult['coderro'] == '26') {
                                    $vetErroCons[] = 'O cliente ' . $row_p['nome'] . ' (' . $row_p['cpf'] . ') já possui histórico de realização registrado para esta mesma data e horário. Não é possível Consolidar este atividade.';
                                } else {
                                    $vetErroCons[] = $metodo . ': [' . $rowResult['coderro'] . '] ' . $rowResult['mensagem'];
                                }

                                $inf_extra = Array(
                                    'metodo' => $metodo,
                                    'parametro' => $vetPar,
                                    'row_siac' => $row_siac,
                                );

                                $vetErroCons[] = $inf_extra;
                            }
                        }
                    }
                }
            }

        if (count($vetErroCons) == 0) {
            commit($conSIAC);
            $ativoTransactionSIAC = false;

            if (count($vetAtOK) > 0) {
                $sql = "update grc_evento_atividade set consolidado_siacweb = 'S'";
                $sql .= ' where idt in (' . implode(', ', $vetAtOK) . ')';
                execsql($sql, false);
            }

            foreach ($vetHistErro as $rowHist) {
                $sql = 'update grc_atendimento_pessoa set';
                $sql .= ' siacweb_hist_erro_cod = ' . null($rowHist['coderro']) . ', ';
                $sql .= ' siacweb_hist_erro_msg = ' . aspa($rowHist['mensagem']);
                $sql .= ' where idt = ' . null($rowHist['idt_atendimento_pessoa']);
                execsql($sql, false);
            }

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        } else {
            if ($ativoTransactionSIAC) {
                rollBack($conSIAC);
                $ativoTransactionSIAC = false;
            }

            $qtdErro += count($vetErroCons);
            $erro = 'Erros na consolidação do evento!';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_DESCON_CLD->data as $row_siac) {
    try {
        
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacEV_EXC_CLD->data as $row_siac) {
    try {
        set_time_limit(300);

        $vetErroCons = Array();
        $motivoRM = 'Evento cancelado no CRM';

        //Concela no RM os Dados do Pagamento
        $sql = '';
        $sql .= ' select p.idt, p.rm_idmov';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
        $sql .= ' where a.idt_evento = ' . null($row_siac['idt_evento']);
        $sql .= " and (p.estornado <> 'S' or p.estornar_rm = 'S')";
        $sql .= ' and p.rm_idmov is not null';
        $rsRM_PAG = execsql($sql, false);

        foreach ($rsRM_PAG->data as $row) {
            $funcao = 'ReadRecordAuth';

            $parametro = Array(
                'DataServerName' => 'MovMovimentoTBCData',
                'PrimaryKey' => '1;' . $row['rm_idmov'],
                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
            );

            $Z = Array('TMOV');

            $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
            $rowRM = $rsRM['TMOV']->data[0];

            if ($rowRM['status'] != 'C') {
                $xml = '';
                $xml .= '<MovCancelMovProcParams>';
                $xml .= '<MovimentosACancelar>';
                $xml .= '<MovimentosCancelar>';
                $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                $xml .= '<CodColigada>1</CodColigada>';
                $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                $xml .= '<MotivoCancelamento>' . $motivoRM . '</MotivoCancelamento>';
                $xml .= '</MovimentosCancelar>';
                $xml .= '</MovimentosACancelar>';
                $xml .= '</MovCancelMovProcParams>';

                $metodo = 'ExecuteWithParams';

                $parametro = Array(
                    'ProcessServerName' => 'MovCancelMovProc',
                    'strXmlParams' => $xml,
                );

                $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                if ($retorno == '1') {
                    $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'ERRO DO RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $parametro;
                }
            } else {
                $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                $sql .= ' where idt = ' . null($row['idt']);
                execsql($sql, false);
            }
        }

        //Cancela no RM as Ordem de Contratação
        $sql = '';
        $sql .= ' select rm.idt_gec_contratacao_credenciado_ordem, rm.mesano, rm.rm_idmov, rm.idt';
        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
        $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = rm.idt_gec_contratacao_credenciado_ordem';
        $sql .= ' where ord.idt_evento = ' . null($row_siac['idt_evento']);
        $sql .= " and ord.ativo = 'S'";
        $sql .= ' and rm.rm_idmov is not null';
        $sql .= " and rm.rm_cancelado = 'N'";
        $rsRM_PAG = execsql($sql, false);

        foreach ($rsRM_PAG->data as $row) {
            $funcao = 'ReadRecordAuth';

            $parametro = Array(
                'DataServerName' => 'MovMovimentoTBCData',
                'PrimaryKey' => '1;' . $row['rm_idmov'],
                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
            );

            $Z = Array('TMOV');

            $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
            $rowRM = $rsRM['TMOV']->data[0];

            if ($rowRM['status'] != 'C') {
                $xml = '';
                $xml .= '<MovCancelMovProcParams>';
                $xml .= '<MovimentosACancelar>';
                $xml .= '<MovimentosCancelar>';
                $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                $xml .= '<CodColigada>1</CodColigada>';
                $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                $xml .= '<MotivoCancelamento>' . $motivoRM . '</MotivoCancelamento>';
                $xml .= '</MovimentosCancelar>';
                $xml .= '</MovimentosACancelar>';
                $xml .= '</MovCancelMovProcParams>';

                $metodo = 'ExecuteWithParams';

                $parametro = Array(
                    'ProcessServerName' => 'MovCancelMovProc',
                    'strXmlParams' => $xml,
                );

                $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                if ($retorno == '1') {
                    $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);
                } else {
                    $erro = 'ERRO DO RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                    $vetErroCons[] = $erro;
                    $vetErroCons[] = $parametro;
                }
            } else {
                $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                $sql .= ' where idt = ' . null($row['idt']);
                execsql($sql, false);
            }
        }

        if (count($vetErroCons) > 0) {
            $qtdErro += count($vetErroCons);
            $erro = 'Erros no cancelamento do evento!';

            $vetErro = array_merge($vetErro, $vetErroCons);
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        } else {
            $sql = '';
            $sql .= ' select p.siacweb_codcosultoria as codconsultoria, u.codparceiro_siacweb as codresponsavel,';
            $sql .= ' e.motivo_cancelamento as obscancelamento, m.codigo as codmotivorecisao';
            $sql .= ' from grc_evento e';
            $sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
            $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_gestor_evento';
            $sql .= ' left outer join grc_evento_motivo_cancelamento m on m.idt = e.idt_evento_motivo_cancelamento';
            $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
            $sql .= " and ep.contrato in ('C', 'S', 'G')";
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $rs = execsql($sql, false);

            beginTransaction($conSIAC);
            $ativoTransactionSIAC = true;

            foreach ($rs->data as $row) {
                if ($row['codconsultoria'] != '') {
                    if ($row['codmotivorecisao'] == '') {
                        $row['codmotivorecisao'] = 3;
                    }

                    $sql = '';
                    $sql .= ' sp_executesql';
                    $sql .= " N'";
                    $sql .= ' update cons_consultoria set Situacao = @Situacao, CodResponsavel = @CodResponsavel,';
                    $sql .= ' DtCancelamento = @DtCancelamento, ObsCancelamento = @ObsCancelamento, CodMotivoRecisao = @CodMotivoRecisao';
                    $sql .= ' where CodConsultoria = @CodConsultoria';
                    $sql .= ' and CodSebrae = @CodSebrae';
                    $sql .= " ',";
                    $sql .= " N'";
                    $sql .= ' @CodConsultoria int, @CodSebrae int, @Situacao varchar(11), @CodResponsavel int, @DtCancelamento datetime,';
                    $sql .= ' @ObsCancelamento varchar(100), @CodMotivoRecisao int';
                    $sql .= " '";
                    $sql .= ', ' . null($row['codconsultoria']);
                    $sql .= ', ' . null($codsebrae);
                    $sql .= ", 'Cancelada'";
                    $sql .= ', ' . null($row['codresponsavel']);
                    $sql .= ', ' . aspa(trata_data(getdata(true, true, true), true));
                    $sql .= ', ' . aspa($row['obscancelamento']);
                    $sql .= ', ' . null($row['codmotivorecisao']);
                    execsql($sql, false, $conSIAC, true);
                }
            }

            commit($conSIAC);
            $ativoTransactionSIAC = false;

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

//Sincronização RM

try {
    $vetInstrumentoPrd = Array();

    $sql = '';
    $sql .= ' select classificacao, idprd';
    $sql .= ' from grc_insumo';
    $sql .= " where classificacao in ('04.08.0001', '04.08.0002', '04.08.0003', '04.08.0004', '04.08.0005')";
    $rs = execsql($sql, false);

    foreach ($rs->data as $row) {
        switch ($row['classificacao']) {
            case '04.08.0001':
                //04.08.0001 Cursos = Curso, Oficina
                $vetInstrumentoPrd[40]['T'] = $row['idprd'];
                $vetInstrumentoPrd[46]['T'] = $row['idprd'];

                $vetInstrumentoPrd[52]['T'] = $row['idprd'];
                $vetInstrumentoPrd[54]['T'] = $row['idprd'];
                break;

            case '04.08.0002':
                //04.08.0002 Feiras = Feira, Missão, Caravana
                $vetInstrumentoPrd[41]['T'] = $row['idprd'];
                $vetInstrumentoPrd[45]['T'] = $row['idprd'];
                break;

            case '04.08.0003':
                //04.08.0003 Consultoria não financeira = Consultoria
                $vetInstrumentoPrd[2]['T'] = $row['idprd'];
                $vetInstrumentoPrd[50]['T'] = $row['idprd'];
                break;

            case '04.08.0004':
                //04.08.0004 Consultoria Financeira = Consultoria
                $vetInstrumentoPrd[2]['F'] = $row['idprd'];
                $vetInstrumentoPrd[50]['F'] = $row['idprd'];
                break;

            case '04.08.0005':
                //04.08.0005 Palestras = Palestra, Seminário
                $vetInstrumentoPrd[47]['T'] = $row['idprd'];
                $vetInstrumentoPrd[49]['T'] = $row['idprd'];
                break;
        }
    }

    $parametro = Array(
        'codSentenca' => 'ws_pir_meiopagto',
        'codColigada' => '1',
        'codAplicacao' => 'T',
    );
    $rsRM = $SoapSebraeRM_CS->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);

    $vetTaxa = Array();
    foreach ($rsRM['Resultado']->data as $row) {
        $vetTaxa[$row['idformapagto']] = Array(
            'taxaasministracao' => str_replace(".", ",", $row['taxaasministracao']),
            'taxaadmparcela' => str_replace(".", ",", $row['taxaadmparcela']),
        );
    }

    $sql = '';
    $sql .= ' select s.idt, s.idt_evento_participante_pagamento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= " where s.tipo = 'RM_EXC'";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento in (40, 47, 46, 49, 50, 2, 52, 54)';
    //$sql .= ' and e.codigo_siacweb is not null';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacRM_EXC = execsql($sql, false);

    $sql = '';
    $sql .= ' select s.idt, s.idt_atendimento, s.idt_evento, e.codigo, e.descricao, e.dt_previsao_inicial, e.dt_previsao_fim,';
    $sql .= ' pa.codigo_sge as codigo_acao_sge, pt.classificacao, pt.rm_coddepartamento, pt.rm_codfilial, e.idt_instrumento, e.idt_produto,';
    $sql .= ' s.idt_evento_participante_pagamento';
    $sql .= ' from grc_sincroniza_siac s';
    $sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
    $sql .= ' inner join grc_projeto_acao pa on pa.idt = e.idt_acao';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao pt on pt.idt = e.idt_ponto_atendimento';
    $sql .= " where (s.tipo = 'RM_INC' or s.tipo = 'RM_INC_PAG')";
    $sql .= ' and s.dt_sincroniza is null';
    $sql .= ' and e.idt_instrumento in (40, 47, 46, 49, 50, 2, 52, 54)';
    $sql .= ' and e.dt_previsao_inicial is not null';
    $sql .= ' and e.dt_previsao_fim is not null';
    //$sql .= ' and e.codigo_siacweb is not null';
    $sql .= $wherePersonalizado;
    $sql .= ' order by s.idt';
    $rs_siacRM_INC = execsql($sql, false);
} catch (Exception $e) {
    $qtdErro++;
    $vetErro[] = grava_erro_log('sincroniza_ws_sg', $e, $sql);
}

foreach ($rs_siacRM_INC->data as $row_siac) {
    try {
        set_time_limit(300);

        $rm_coddepartamento = $row_siac['rm_coddepartamento'];

        if ($rm_coddepartamento == '') {
            $classificacao = substr($row_siac['classificacao'], 0, 5) . '.00.000';

            $sql = '';
            $sql .= ' select rm_coddepartamento';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa($classificacao);
            $rsCD = execsql($sql, false);
            $rm_coddepartamento = $rsCD->data[0][0];
        }

        $rm_codfilial = $row_siac['rm_codfilial'];

        if ($rm_codfilial == '') {
            $classificacao = substr($row_siac['classificacao'], 0, 5) . '.00.000';

            $sql = '';
            $sql .= ' select rm_codfilial';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where classificacao = ' . aspa($classificacao);
            $rsCD = execsql($sql, false);
            $rm_codfilial = $rsCD->data[0][0];
        }

        //Dados do Pagamento
        $sql = '';
        $sql .= ' select p.*, fp.rm_codcpg, np.descricao as descformapagto , np.rm_idformapagto, np.codigo as tipo_pag, est.codigo as sbaestab,';
        $sql .= ' fp.numero_de_parcelas, cd.rm_codcfo, cd.rm_idpgto, cd.codigo as cnpj_devolucao, cd.inc_pag_rm';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= ' left outer join grc_evento_forma_parcelamento fp on fp.idt = p.idt_evento_forma_parcelamento';
        $sql .= ' left outer join grc_evento_natureza_pagamento np on np.idt = p.idt_evento_natureza_pagamento';
        $sql .= ' left outer join grc_evento_estabelecimento est on est.idt = p.idt_evento_estabelecimento';
        $sql .= ' left outer join grc_evento_participante_contadevolucao cd on cd.idt_evento_participante_pagamento = p.idt';
        $sql .= ' where p.idt_atendimento = ' . null($row_siac['idt_atendimento']);
        $sql .= " and p.estornado <> 'S'";
        $sql .= ' and p.rm_idmov is null';
        $sql .= " and (np.desconto is null or np.desconto = 'N')";

        if ($row_siac['idt_evento_participante_pagamento'] == '') {
            $sql .= ' and p.idt_aditivo_participante is null';
        } else {
            $sql .= ' and p.idt = ' . null($row_siac['idt_evento_participante_pagamento']);
        }

        $rsRM_PAG = execsql($sql, false);

        if ($rsRM_PAG->rows == 0) {
            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        } else {
            //Pessoa
            $sql = '';
            $sql .= ' select p.idt as idt_atendimento_pessoa, p.cpf, o.idt as idt_atendimento_organizacao, o.cnpj, a.protocolo';
            $sql .= ' from grc_atendimento a';
            $sql .= " inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt and tipo_relacao = 'L'";
            $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt';
            $sql .= ' where a.idt = ' . null($row_siac['idt_atendimento']);
            $rs = execsql($sql, false);
            $row = $rs->data[0];
            $chaveorigem = 'CRM-' . $row['protocolo'];

            if ($row['cnpj'] == '' || substr($row['cnpj'], 0, 2) == 'PR') {
                $cgccfo = FormataCPF14($row['cpf']);
            } else {
                $cgccfo = $row['cnpj'];
            }

            $parametro = Array(
                'DataServerName' => 'FinCFODataBR',
                'Filtro' => "codcoligada=1 and cgccfo = '{$cgccfo}'",
                'Contexto' => 'codcoligada=1',
            );
            $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

            if ($rsRM['FCFO']->rows == 0) {
                if ($row['cnpj'] == '' || substr($row['cnpj'], 0, 2) == 'PR') {
                    $pessoafisoujur = 'F';

                    $sql = '';
                    $sql .= ' select nome as nomefantasia, nome as nome, logradouro_cep as cep, logradouro_endereco as rua, logradouro_numero as numero,';
                    $sql .= ' logradouro_bairro as bairro, logradouro_cidade as cidade, logradouro_estado as codetd, email as email, logradouro_complemento as complemento,';
                    $sql .= ' coalesce(telefone_celular, telefone_residencial, telefone_recado) as telefone';
                    $sql .= ' from grc_atendimento_pessoa';
                    $sql .= ' where idt = ' . null($row['idt_atendimento_pessoa']);
                } else {
                    $pessoafisoujur = 'J';

                    $sql = '';
                    $sql .= ' select nome_fantasia as nomefantasia, razao_social as nome, logradouro_cep_e as cep, logradouro_endereco_e as rua, logradouro_numero_e as numero,';
                    $sql .= ' logradouro_bairro_e as bairro, logradouro_cidade_e as cidade, logradouro_estado_e as codetd, email_e as email, logradouro_complemento_e as complemento,';
                    $sql .= ' coalesce(telefone_comercial_e, telefone_celular_e) as telefone';
                    $sql .= ' from grc_atendimento_organizacao';
                    $sql .= ' where idt = ' . null($row['idt_atendimento_organizacao']);
                }

                $rs = execsql($sql, false);
                $rowDados = $rs->data[0];

                $cep = preg_replace('/[^0-9]/i', '', $rowDados['cep']);

                $sql = '';
                $sql .= ' select codigo ';
                $sql .= ' from ' . db_pir_gec . 'base_municipio';
                $sql .= ' where nome = ' . aspa($rowDados['cidade']);
                $rst = execsql($sql, false);
                $codmunicipio = $rst->data[0][0];

                $pagrec = 1;

                $registro = Array(
                    'CODCOLIGADA' => 1,
                    'CODCOLTCF' => 1,
                    'CODCFO' => -1,
                    'NOMEFANTASIA' => substr($rowDados['nomefantasia'], 0, 100),
                    'NOME' => substr($rowDados['nome'], 0, 100),
                    'CGCCFO' => $cgccfo,
                    'ATIVO' => 1,
                    'PAGREC' => $pagrec,
                    'PESSOAFISOUJUR' => $pessoafisoujur,
                    'RUA' => substr($rowDados['rua'], 0, 100),
                    'NUMERO' => $rowDados['numero'],
                    'BAIRRO' => $rowDados['bairro'],
                    'CODMUNICIPIO' => $codmunicipio,
                    'CIDADE' => $rowDados['cidade'],
                    'CODETD' => $rowDados['codetd'],
                    'CEP' => $cep,
                    'EMAIL' => $rowDados['email'],
                    'CODTCF' => '028',
                    'COMPLEMENTO' => substr($rowDados['complemento'], 0, 60),
                    'TELEFONE' => $rowDados['telefone'],
                );

                $parametro = Array(
                    'DataServerName' => 'FinCFODataBR',
                    'Contexto' => 'codcoligada=1',
                );

                $Z = 'FCFO';
                $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                if (substr($retorno, 0, 2) == '1;') {
                    $codcfo = substr($retorno, 2);
                } else {
                    $qtdErro++;

                    $retorno_org = $retorno;
                    $i = strpos($retorno, '=======================================');
                    if ($i !== FALSE) {
                        $retorno = substr($retorno, 0, $i);
                    }

                    $erro = 'ERRO DO RM: ' . $retorno;

                    $inf_extra = Array(
                        'mensagem' => $retorno_org,
                        'Z' => $Z,
                        'parametro' => $parametro,
                        'registro' => $registro,
                    );
                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                    continue;
                }
            } else {
                $codcfo = $rsRM['FCFO']->data[0]['codcfo'];
                $pagrec = $rsRM['FCFO']->data[0]['pagrec'];
                $ativo = $rsRM['FCFO']->data[0]['ativo'];
                $codtcf = $rsRM['FCFO']->data[0]['codtcf'];

                if ($pagrec == 2 || ativo != 1 || $codtcf == '') {
                    if ($pagrec == 2) {
                        $pagrec = 3;
                    }

                    if ($codtcf == '') {
                        $codtcf = '028';
                    }

                    $registro = Array(
                        'CODCOLIGADA' => 1,
                        'CODCOLTCF' => 1,
                        'CODCFO' => $codcfo,
                        'CODTCF' => $codtcf,
                        'ATIVO' => 1,
                        'PAGREC' => $pagrec,
                    );

                    $parametro = Array(
                        'DataServerName' => 'FinCFODataBR',
                        'Contexto' => 'codcoligada=1',
                    );

                    $Z = 'FCFO';
                    $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                    if (substr($retorno, 0, 2) == '1;') {
                        $codcfo = substr($retorno, 2);
                    } else {
                        $qtdErro++;

                        $retorno_org = $retorno;
                        $i = strpos($retorno, '=======================================');
                        if ($i !== FALSE) {
                            $retorno = substr($retorno, 0, $i);
                        }

                        $erro = 'ERRO DO RM: ' . $retorno;

                        $inf_extra = Array(
                            'mensagem' => $retorno_org,
                            'Z' => $Z,
                            'parametro' => $parametro,
                            'registro' => $registro,
                        );
                        $vetErro[] = $erro;
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);
                        continue;
                    }
                }
            }

            $sql = 'update grc_atendimento set rm_codcfo = ' . aspa($codcfo);
            $sql .= ' where idt = ' . null($row_siac['idt_atendimento']);
            execsql($sql, false);

            if ($codcfo != '') {
                $parametro = Array(
                    'codSentenca' => 'WS_PRI_SGEvRM',
                    'codColigada' => '1',
                    'codAplicacao' => 'T',
                    'parameters' => 'GUIDACAOSGE=' . $row_siac['codigo_acao_sge'],
                );
                $rsRM = $SoapSebraeRM_CS->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);
                $rowRM = $rsRM['Resultado']->data[0];

                $codccusto = $rowRM['projeto_acao_unidade_rm'];
                $nome = $rowRM['nome_unidade_sge'];

                $sql = '';
                $sql .= ' select pac.idt';
                $sql .= ' from grc_produto_area_conhecimento pac';
                $sql .= ' inner join ' . db_pir_gec . 'gec_area_conhecimento ac on ac.idt = pac.idt_area';
                $sql .= ' where pac.idt_produto = ' . null($row_siac['idt_produto']);
                $sql .= " and ac.codigo like '03%'";
                $rs = execsql($sql, false);

                if ($rs->rows > 0) {
                    $idprd = $vetInstrumentoPrd[$row_siac['idt_instrumento']]['F'];
                }

                if ($idprd == '') {
                    $idprd = $vetInstrumentoPrd[$row_siac['idt_instrumento']]['T'];
                }

                //Pagamento
                foreach ($rsRM_PAG->data as $row) {
                    $codcfoRM = $codcfo;

                    if ($row['usa_parceiro'] == 'S') {
                        $codcfoRM = consultaCODCFORM($row);
                    }

                    if ($codcfoRM != '') {
                        $temErro = false;

                        $idmov = -1;

                        /*
                         * "Data de contabilização da venda. Último dia útil do mês da venda. Se a data de fim do evento for menor do que esta data, considerar a data de fim do evento."

                          $vetDataPag = DatetoArray(trata_data($row['data_pagamento']));

                          $datasaida = ultimoDiaUtil($vetDataPag['mes'], $vetDataPag['ano']);

                          $diff = diffDate($datasaida, trata_data($row_siac['dt_previsao_fim']));

                          if ($diff < 0) {
                          $datasaida = $row_siac['dt_previsao_fim'];
                          }
                         * 
                         */

                        $dataemissao = $row['data_pagamento'];
                        $datasaida = date('Y-m-d');
                        $datamovimento = $row['data_pagamento'];
                        $datavencimento = $row['data_vencimento'];

                        $vetData = DatetoArray(trata_data($dataemissao));
                        $dtAnoMes = $vetData['ano'] . $vetData['mes'];

                        if ($dtAnoMes < date('Ym')) {
                            $dataemissao = $datasaida;
                        }

                        $valor = str_replace(".", ",", $row['valor_pagamento']);

                        if ($row['operacao'] == 'D') {
                            $codcfoRM = $row['rm_codcfo'];
                            $hist = '[' . $row_siac['codigo'] . '] ' . $row_siac['descricao'] . ' (Devolução)' . "\r\n";
                            $hist .= 'Dado Bancário Nº' . $row['rm_idpgto'];

                            $sql = '';
                            $sql .= ' select rm_idmov';
                            $sql .= ' from grc_evento_participante_pagamento';
                            $sql .= ' where idt_atendimento = ' . null($row_siac['idt_atendimento']);
                            $sql .= " and estornado <> 'S'";
                            $sql .= " and operacao = 'C'";
                            $sql .= ' and idt_aditivo_participante is null';
                            $sql .= ' and rm_idmov is not null';

                            if ($row['inc_pag_rm'] == 'S') {
                                $sql .= ' and par_cnpj is null';
                            } else {
                                $sql .= ' and par_cnpj = ' . aspa($row['cnpj_devolucao']);
                            }

                            $rst = execsql($sql, false);
                            $numeromov = $rst->data[0][0];

                            $parametro = Array(
                                'DataServerName' => 'FinCFODataBR',
                                'Filtro' => "codcoligada=1 and CODCFO = {$codcfoRM}",
                                'Contexto' => 'codcoligada=1',
                            );
                            $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);
                            $pagrec = $rsRM['FCFO']->data[0]['pagrec'];

                            if ($pagrec == 1) {
                                $pagrec = 3;

                                $registro = Array(
                                    'CODCOLIGADA' => 1,
                                    'CODCOLTCF' => 1,
                                    'CODCFO' => $codcfoRM,
                                    'PAGREC' => $pagrec,
                                );

                                $parametro = Array(
                                    'DataServerName' => 'FinCFODataBR',
                                    'Contexto' => 'codcoligada=1',
                                );

                                $Z = 'FCFO';
                                $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);
                            }

                            $registro = Array();

                            $registro['TMOV'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                                'CODFILIAL' => 1,
                                'CODLOC' => '01',
                                'CODCFO' => $codcfoRM,
                                'NUMEROMOV' => $numeromov,
                                'SERIE' => 'DRP',
                                'CODTMV' => '2.2.18',
                                'TIPO' => 'S',
                                'STATUS' => 'F',
                                'DATAEMISSAO' => $dataemissao,
                                'DATASAIDA' => $datasaida,
                                'CODCPG' => 27,
                                'IDMOVLCTFLUXUS' => -1,
                                'CODVEN1' => 9997,
                                'CODCOLCFO' => 1,
                                'IDMOVCFO' => -1,
                                'HISTORICOCURTO' => $hist,
                                'CHAVEORIGEM' => $chaveorigem,
                                'CAMPOLIVRE3' => $row_siac['codigo'],
                                'CODCOLIGADA1' => 1,
                                'IDMOVHST' => -1,
                                'CODTB1FLX' => '01.02.0015',
                            );

                            $registro['TITMMOV'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                                'NSEQITMMOV' => 1,
                                'CODFILIAL' => 1,
                                'NUMEROSEQUENCIAL' => 1,
                                'IDPRD' => 610,
                                'CODTBORCAMENTO' => '001',
                                'CODCOLTBORCAMENTO' => 1,
                                'QUANTIDADE' => 1,
                                'PRECOUNITARIO' => $valor,
                                'CODDEPARTAMENTO' => $rm_coddepartamento,
                                'CHAVEORIGEM' => $chaveorigem,
                                'HISTORICOCURTO' => $hist,
                                'IDMOVHST' => -1,
                                'NSEQITMMOV1' => 1,
                            );

                            $registro['TITMMOVRATCCU'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                                'NSEQITMMOV' => 1,
                                'CODCCUSTO' => $codccusto,
                                'VALOR' => $valor,
                                'HISTORICOCURTO' => $hist,
                                'IDMOVRATCCU' => -1,
                            );

                            $registro['TMOVCOMPL'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                            );

                            $registro['TITMMOVCOMPL'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                                'NSEQITMMOV' => 1,
                            );

                            $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU', 'TMOVCOMPL', 'TITMMOVCOMPL');
                        } else {
                            switch ($row['tipo_pag']) {
                                case 'CD': //Cartão de Débito
                                    $datavencimento = trata_data(date('d/m/Y', strtotime('+1 days', strtotime($row['data_pagamento']))));
                                    break;

                                case 'CCA': //Cartão de Crédito A Vista
                                    $datavencimento = trata_data(dt_vencimento_prox($row['data_pagamento'], 1));
                                    break;
                            }

                            $diff = diffDate(trata_data($dataemissao), trata_data($datavencimento));

                            if ($diff < 0) {
                                $datavencimento = $dataemissao;
                            }

                            if ($row['rm_idformapagto'] == 1 || $row['rm_idformapagto'] == 2 || $row['rm_idformapagto'] == 7) {
                                $row['codigo_nsu'] = 0;
                            }

                            $registro = Array();

                            $registro['TMOV'] = Array(
                                'IDMOV' => $idmov,
                                'NUMEROMOV' => -1,
                                'CODTB1FLX' => '01.02.0003',
                                'SERIE' => 'RVM',
                                'CODCOLIGADA' => 1,
                                'CODFILIAL' => $rm_codfilial,
                                'CODCOLCFO' => 1,
                                'SEGUNDONUMERO' => $row['codigo_nsu'],
                                'CODCFO' => $codcfoRM,
                                'CODTMV' => '2.1.06',
                                'CAMPOLIVRE3' => $row_siac['codigo'],
                                'DATAEMISSAO' => $dataemissao,
                                'DATASAIDA' => $datasaida,
                                'DATAMOVIMENTO' => $datamovimento,
                                'CODVEN1' => 9997,
                                'CODLOC' => '01',
                                'CODMOEVALORLIQUIDO' => 'R$',
                                'CODCXA' => '004',
                                'CODCOLCXA' => 1,
                                'INTEGRAAPLICACAO' => 'T',
                                'TIPO' => 'A',
                                'STATUS' => 'A',
                                //'CODCPG' => $row['rm_codcpg'],
                                'DATAEXTRA1' => $row_siac['dt_previsao_inicial'],
                                'DATAEXTRA2' => $row_siac['dt_previsao_fim'],
                                'HISTORICOCURTO' => '[' . $row_siac['codigo'] . '] ' . $row_siac['descricao'],
                                'IDMOVHST' => -1,
                            );

                            $registro['TITMMOVRATCCU'] = Array(
                                'IDMOVRATCCU' => -1,
                                'IDMOV' => $idmov,
                                'CODCOLIGADA' => 1,
                                'NSEQITMMOV' => 1,
                                'CODCCUSTO' => $codccusto,
                                'NOME' => $nome,
                                'VALOR' => $valor,
                                'HISTORICO' => '[' . $row_siac['codigo'] . '] ' . $row_siac['descricao'],
                                'PERCENTUAL' => 100,
                            );

                            $registro['TITMMOV'] = Array(
                                'IDMOV' => $idmov,
                                'CODCOLIGADA' => 1,
                                'NSEQITMMOV' => 1,
                                'QUANTIDADE' => 1,
                                'PRECOUNITARIO' => $valor,
                                'CODFILIAL' => $rm_codfilial,
                                'IDPRD' => $idprd,
                                'CODDEPARTAMENTO' => $rm_coddepartamento,
                                'CODTB2FAT' => '05.002',
                                'CODTBORCAMENTO' => '001',
                                'CODCOLTBORCAMENTO' => 1,
                                'HISTORICOCURTO' => '[' . $row_siac['codigo'] . '] ' . $row_siac['descricao'],
                                'IDMOVHST' => -1,
                            );

                            if ($row['tipo_pag'] == 'CCP') {
                                $vlParcela = floor($row['valor_pagamento'] / $row['numero_de_parcelas'] * 100) / 100;
                                $vlParcelaPri = $row['valor_pagamento'] - ($vlParcela * $row['numero_de_parcelas']) + $vlParcela;

                                $vlParcela = str_replace(".", ",", $vlParcela);
                                $vlParcelaPri = str_replace(".", ",", $vlParcelaPri);

                                for ($parcela = 1; $parcela <= $row['numero_de_parcelas']; $parcela++) {
                                    if ($parcela == 1) {
                                        $valor = $vlParcelaPri;
                                        $taxaadm = $vetTaxa[$row['rm_idformapagto']]['taxaasministracao'];
                                    } else {
                                        $valor = $vlParcela;
                                        $taxaadm = $vetTaxa[$row['rm_idformapagto']]['taxaadmparcela'];
                                    }

                                    $datavencimento = trata_data(dt_vencimento_prox($row['data_pagamento'], $parcela));

                                    $diff = diffDate(trata_data($dataemissao), trata_data($datavencimento));

                                    if ($diff < 0) {
                                        $datavencimento = $dataemissao;
                                    }

                                    $registro['TMOVPAGTO'][] = Array(
                                        'CODCOLIGADA' => '1',
                                        'IDSEQPAGTO' => -1,
                                        'IDMOV' => $idmov,
                                        'CODCOLCFODEFAULT' => 1,
                                        'CODCXA' => '004',
                                        'CODCOLCXA' => 1,
                                        'IDFORMAPAGTO' => $row['rm_idformapagto'],
                                        'CHEQUE' => $row['ch_numero'],
                                        'CC' => $row['ch_cc'],
                                        'AGENCIA' => $row['ch_agencia'],
                                        'BANCO' => $row['ch_banco'],
                                        'NOMEEMITENTE' => $row['emitente_nome'],
                                        'TELEMITENTE' => $row['emitente_tel'],
                                        'DATAVENCIMENTO' => $datavencimento,
                                        'VALOR' => $valor,
                                        'DEBITOCREDITO' => 'C',
                                        'IDSEQPAGTO1' => -1,
                                        'DESCFORMAPAGTO' => $row['descformapagto'],
                                        'TAXAADM' => $taxaadm,
                                    );
                                }
                            } else {
                                $registro['TMOVPAGTO'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'IDSEQPAGTO' => -1,
                                    'IDMOV' => $idmov,
                                    'CODCOLCFODEFAULT' => 1,
                                    'CODCXA' => '004',
                                    'CODCOLCXA' => 1,
                                    'IDFORMAPAGTO' => $row['rm_idformapagto'],
                                    'CHEQUE' => $row['ch_numero'],
                                    'CC' => $row['ch_cc'],
                                    'AGENCIA' => $row['ch_agencia'],
                                    'BANCO' => $row['ch_banco'],
                                    'NOMEEMITENTE' => $row['emitente_nome'],
                                    'TELEMITENTE' => $row['emitente_tel'],
                                    'DATAVENCIMENTO' => $datavencimento,
                                    'VALOR' => $valor,
                                    'DEBITOCREDITO' => 'C',
                                    'IDSEQPAGTO1' => -1,
                                    'DESCFORMAPAGTO' => $row['descformapagto'],
                                    'TAXAADM' => $vetTaxa[$row['rm_idformapagto']]['taxaasministracao'],
                                );
                            }

                            $registro['TMOVCOMPL'] = Array(
                                'CODCOLIGADA' => 1,
                                'IDMOV' => $idmov,
                                'SBAESTAB' => $row['sbaestab'],
                                'CHAVEORIGEM' => $chaveorigem,
                            );

                            $Z = Array('TMOV', 'TITMMOVRATCCU', 'TITMMOV', 'TMOVPAGTO', 'TMOVCOMPL');
                        }

                        $parametro = Array(
                            'DataServerName' => 'MovMovimentoTBCData',
                            'Contexto' => 'codcoligada=1',
                        );

                        $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                        if (substr($retorno, 0, 2) == '1;') {
                            $rm_idmov = substr($retorno, 2);

                            $sql = 'update grc_evento_participante_pagamento set rm_idmov = ' . null($rm_idmov);
                            $sql .= ' where idt = ' . null($row['idt']);
                            execsql($sql, false);

                            if ($row['operacao'] == 'D') {
                                $funcao = 'ReadViewAuth';

                                $parametro = Array(
                                    'DataServerName' => 'FinLanDataBR',
                                    'Filtro' => 'idmov=' . $rm_idmov,
                                    'Contexto' => 'codcoligada=1;',
                                );

                                $Z = Array('FLAN');

                                $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
                                $rowFLAN = $rsRM['FLAN']->data[0];

                                $parametro = Array(
                                    'DataServerName' => 'FinLanDataBR',
                                    'Contexto' => 'codcoligada=' . $rowFLAN['codcoligada'],
                                );

                                $registro = Array();

                                $registro['FLAN'] = Array(
                                    'IDLAN' => $rowFLAN['idlan'],
                                    'CODCOLIGADA' => $rowFLAN['codcoligada'],
                                    'CODFILIAL' => $rowFLAN['codfilial'],
                                    'IDPGTO' => $row['rm_idpgto'],
                                );

                                $Z = Array('FLAN');

                                $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                if (substr($retorno, 0, 2) != '1;') {
                                    $temErro = true;

                                    $qtdErro++;

                                    $retorno_org = $retorno;
                                    $i = strpos($retorno, '=======================================');
                                    if ($i !== FALSE) {
                                        $retorno = substr($retorno, 0, $i);
                                    }

                                    $erro = 'ERRO DO RM: ' . $retorno;

                                    $inf_extra = Array(
                                        'mensagem' => $retorno_org,
                                        'Z' => $Z,
                                        'parametro' => $parametro,
                                        'registro' => $registro,
                                    );
                                    $vetErro[] = $erro;
                                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                    $sql .= " erro = " . aspa($erro);
                                    $sql .= ' where idt = ' . null($row_siac['idt']);
                                    execsql($sql, false);
                                }
                            }

                            if (!$usaTransaction) {
                                commit();
                                $ativoTransaction = false;
                                beginTransaction();
                                $ativoTransaction = true;
                            }
                        } else {
                            $temErro = true;

                            $qtdErro++;

                            $retorno_org = $retorno;
                            $i = strpos($retorno, '=======================================');
                            if ($i !== FALSE) {
                                $retorno = substr($retorno, 0, $i);
                            }

                            $erro = 'ERRO DO RM: ' . $retorno;

                            $inf_extra = Array(
                                'mensagem' => $retorno_org,
                                'Z' => $Z,
                                'parametro' => $parametro,
                                'registro' => $registro,
                            );
                            $vetErro[] = $erro;
                            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                            $sql .= " erro = " . aspa($erro);
                            $sql .= ' where idt = ' . null($row_siac['idt']);
                            execsql($sql, false);
                        }

                        if (!$temErro) {
                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                            execsql($sql, false);
                        }
                    }
                }
            }
        }

        //Verifica lixo no RM
        $sql = '';
        $sql .= ' select p.rm_idmov, a.protocolo';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= " inner join grc_atendimento a on a.idt = p.idt_atendimento";
        $sql .= ' where p.idt_atendimento = ' . null($row_siac['idt_atendimento']);
        $sql .= ' and p.rm_idmov is not null';
        $rsRM_PAG = execsql($sql, false);

        $vetCanRM = Array();

        foreach ($rsRM_PAG->data as $row) {
            $vetCanRM['CRM-' . $row['protocolo']][] = $row['rm_idmov'];
        }

        $mensagemRM = 'Pagamento para evento não encontrado no CRM';

        foreach ($vetCanRM as $chave_origem => $vetIdMov) {
            CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
        }
    } catch (Exception $e) {
        funcCatch();
    }
}

foreach ($rs_siacRM_EXC->data as $row_siac) {
    try {
        //Dados do Pagamento
        $sql = '';
        $sql .= ' select p.idt, p.rm_idmov, p.idt_evento_natureza_pagamento, pc.dt_cancelamento, u.nome_completo';
        $sql .= ' from grc_evento_participante_pagamento p';
        $sql .= ' left outer join grc_evento_participante_contrato pc on pc.idt = p.idt_evento_participante_contrato';
        $sql .= ' left outer join plu_usuario u on u.id_usuario = pc.idt_usuario_canc';
        $sql .= ' where p.idt = ' . null($row_siac['idt_evento_participante_pagamento']);
        $sql .= " and p.estornar_rm = 'S'";
        $sql .= ' and p.rm_idmov is not null';
        $rsRM_PAG = execsql($sql, false);

        if ($rsRM_PAG->rows == 0) {
            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
            $sql .= ' where idt in (' . $row_siac['idt'] . ')';
            execsql($sql, false);
        } else {
            foreach ($rsRM_PAG->data as $row) {
                $cancelado = false;
                $funcao = 'ReadRecordAuth';

                $parametro = Array(
                    'DataServerName' => 'MovMovimentoTBCData',
                    'PrimaryKey' => '1;' . $row['rm_idmov'],
                    'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                );

                $Z = Array('TMOV');

                $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);

                if (is_array($rsRM)) {
                    $rowRM = $rsRM['TMOV']->data[0];

                    if ($rowRM['status'] == 'C') {
                        $cancelado = true;
                    } else if ($rowRM['avisopermissao'] != '') {
                        $qtdErro++;
                        $erro = 'ERRO DO RM: Processo bloquedo "' . $rowRM['avisopermissao'] . '" para o IDMOV: ' . $row['rm_idmov'];

                        $inf_extra = Array(
                            'funcao' => $funcao,
                            'parametro' => $parametro,
                        );
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);

                        $erro .= '<br /><br />Favor entrar em contato com o contas a receber!';
                        $vetErro[] = $erro;
                        continue;
                    }
                } else {
                    $qtdErro++;
                    $erro = 'ERRO DO RM: [' . $funcao . '] ' . $rsRM . ' para o IDMOV: ' . $row['rm_idmov'];

                    $inf_extra = Array(
                        'funcao' => $funcao,
                        'parametro' => $parametro,
                    );
                    $vetErro[] = $erro;
                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                    $sql .= " erro = " . aspa($erro);
                    $sql .= ' where idt = ' . null($row_siac['idt']);
                    execsql($sql, false);
                    continue;
                }

                if ($cancelado) {
                    $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql, false);

                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                    $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                    execsql($sql, false);
                } else {
                    //Cheque
                    if ($row['idt_evento_natureza_pagamento'] == 8) {
                        $vetDadosCH = Array();

                        $funcao = 'RealizarConsultaSQLAuth';

                        $parametro = Array(
                            'codSentenca' => 'ws_movidcheque',
                            'codColigada' => '1',
                            'codAplicacao' => 'T',
                            'parameters' => 'idmov=' . $row['rm_idmov'],
                        );
                        $rsRM = $SoapSebraeRM_CS->executa($funcao, Array('Resultado'), $parametro, true);

                        if (is_array($rsRM)) {
                            foreach ($rsRM['Resultado']->data as $rowRM) {
                                if ($rowRM['statuslan'] != 0) {
                                    $qtdErro++;
                                    $erro = 'ERRO DO RM: Processo bloquedo "O lançamento já foi baixado no financeiro" para o IDMOV: ' . $row['rm_idmov'];

                                    $inf_extra = Array(
                                        'funcao' => $funcao,
                                        'parametro' => $parametro,
                                    );
                                    $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                                    $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                    $sql .= " erro = " . aspa($erro);
                                    $sql .= ' where idt = ' . null($row_siac['idt']);
                                    execsql($sql, false);

                                    $erro .= '<br /><br />Favor entrar em contato com o contas a receber!';
                                    $vetErro[] = $erro;
                                    continue;
                                }

                                $vetDadosCH[] = Array(
                                    'idlan' => $rowRM['idlan'],
                                    'idxcx' => $rowRM['idxcx'],
                                    'idbaixa' => $rowRM['idbaixa'],
                                );
                            }
                        } else {
                            $qtdErro++;
                            $erro = 'ERRO DO RM: [' . $funcao . '] ' . $rsRM . ' para o IDMOV: ' . $row['rm_idmov'];

                            $inf_extra = Array(
                                'funcao' => $funcao,
                                'parametro' => $parametro,
                            );
                            $vetErro[] = $erro;
                            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                            $sql .= " erro = " . aspa($erro);
                            $sql .= ' where idt = ' . null($row_siac['idt']);
                            execsql($sql, false);
                            continue;
                        }

                        if (count($vetDadosCH) > 0) {
                            $xml = '';
                            $xml .= '<FinLanCancelamentoChequeParamsProc>';
                            $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                            $xml .= '<Historico/>';
                            $xml .= '<ItensCancelamento>';

                            foreach ($vetDadosCH as $rowCH) {
                                $xml .= '<ItemCancelamentoChequeResult>';
                                $xml .= '<InternalId/>';
                                $xml .= '<CodColXcx>1</CodColXcx>';
                                $xml .= '<CodColigada>1</CodColigada>';
                                $xml .= '<IDLAN>' . $rowCH['idlan'] . '</IDLAN>';
                                $xml .= '<IDXCX>' . $rowCH['idxcx'] . '</IDXCX>';
                                $xml .= '<IDBAIXA>' . $rowCH['idbaixa'] . '</IDBAIXA>';
                                $xml .= '</ItemCancelamentoChequeResult>';
                            }

                            $xml .= '</ItensCancelamento>';
                            $xml .= '<Usuario>' . SoapSebraeRMusuario . '</Usuario>';
                            $xml .= '</FinLanCancelamentoChequeParamsProc>';

                            $metodo = 'ExecuteWithParams';
                            $funcao = 'FinLanCancelamentoChequeData';

                            $parametro = Array(
                                'ProcessServerName' => $funcao,
                                'strXmlParams' => $xml,
                            );

                            $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                            if ($retorno != '1') {
                                $qtdErro++;
                                $erro = 'ERRO DO RM: [' . $funcao . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                                $inf_extra = Array(
                                    'metodo' => $metodo,
                                    'funcao' => $funcao,
                                    'parametro' => $parametro,
                                );
                                $vetErro[] = $erro;
                                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                                $sql .= " erro = " . aspa($erro);
                                $sql .= ' where idt = ' . null($row_siac['idt']);
                                execsql($sql, false);
                                continue;
                            }
                        }
                    }

                    //Cancela no RM
                    if ($row['nome_completo'] == '') {
                        $motivo = 'Cancelado por ' . $_SESSION[CS]['g_nome_completo'] . ' em ' . getdata(true, true, true);
                    } else {
                        $motivo = 'Cancelado por ' . $row['nome_completo'] . ' em ' . trata_data($row['dt_cancelamento']);
                    }

                    $xml = '';
                    $xml .= '<MovCancelMovProcParams>';
                    $xml .= '<MovimentosACancelar>';
                    $xml .= '<MovimentosCancelar>';
                    $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                    $xml .= '<CodColigada>1</CodColigada>';
                    $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                    $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                    $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                    $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                    $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                    $xml .= '<MotivoCancelamento>' . $motivo . '</MotivoCancelamento>';
                    $xml .= '</MovimentosCancelar>';
                    $xml .= '</MovimentosACancelar>';
                    $xml .= '</MovCancelMovProcParams>';

                    $metodo = 'ExecuteWithParams';
                    $funcao = 'MovCancelMovProc';

                    $parametro = Array(
                        'ProcessServerName' => $funcao,
                        'strXmlParams' => $xml,
                    );

                    $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                    if ($retorno == '1') {
                        $sql = "update grc_evento_participante_pagamento set estornar_rm = 'E'";
                        $sql .= ' where idt = ' . null($row['idt']);
                        execsql($sql, false);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                        $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                        execsql($sql, false);
                    } else {
                        $qtdErro++;
                        $erro = 'ERRO DO RM: [' . $funcao . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                        $inf_extra = Array(
                            'metodo' => $metodo,
                            'funcao' => $funcao,
                            'parametro' => $parametro,
                        );
                        $vetErro[] = $erro;
                        $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                        $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                        $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                        $sql .= " erro = " . aspa($erro);
                        $sql .= ' where idt = ' . null($row_siac['idt']);
                        execsql($sql, false);
                        continue;
                    }
                }
            }
        }
    } catch (Exception $e) {
        funcCatch();
    }
}
}

if ($usaTransaction) {
    if ($qtdErro == 0) {
        echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. EXECUTADA COM SUCESSO!';
    } else {
        echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. OCORREU ' . $qtdErro . ' ERROS NA ROTINA.CONSULTAR LOG DE ERROS!';
    }
} else {
    if ($qtdErro != 0 && $ssaMostrarErro == 'S') {
        echo "<div align='' class='Msg'>Data do Erro: " . getdata(true, true, true) . "<br><br>Erro na Sincronização com SiacWEB e RM.<br /><br />\n";

        $idx = 0;
        foreach ($vetErro as $value) {
            if (!is_array($value)) {
                $idx++;
                echo $idx . ' - ' . $value . '<br />';
            }
        }

        echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';
        onLoadPag();
        FimTela();
        die();
    }
}

function consultaCODCFORM($row) {
    global $SoapSebraeRM_DS, $qtdErro, $vetErro, $row_siac;

    $codcfo = '';
    $cgccfo = $row['par_cnpj'];

    $parametro = Array(
        'DataServerName' => 'FinCFODataBR',
        'Filtro' => "codcoligada=1 and cgccfo = '{$cgccfo}'",
        'Contexto' => 'codcoligada=1',
    );
    $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

    if ($rsRM['FCFO']->rows == 0) {
        $sql = '';
        $sql .= ' select codigo ';
        $sql .= ' from ' . db_pir_gec . 'base_municipio';
        $sql .= ' where nome = ' . aspa($row['par_cidade']);
        $rst = execsql($sql, false);
        $codmunicipio = $rst->data[0][0];

        $registro = Array(
            'CODCOLIGADA' => 1,
            'CODCOLTCF' => 1,
            'CODCFO' => -1,
            'NOMEFANTASIA' => substr($row['par_nome_fantasia'], 0, 100),
            'NOME' => substr($row['par_razao_social'], 0, 100),
            'CGCCFO' => $cgccfo,
            'ATIVO' => 1,
            'PAGREC' => 1,
            'PESSOAFISOUJUR' => 'J',
            'RUA' => substr($row['par_rua'], 0, 100),
            'NUMERO' => $row['par_numero'],
            'BAIRRO' => $row['par_bairro'],
            'CODMUNICIPIO' => $codmunicipio,
            'CIDADE' => $row['par_cidade'],
            'CODETD' => $row['par_estado'],
            'CEP' => preg_replace('/[^0-9]/i', '', $row['par_cep']),
            'CODTCF' => '028',
        );

        $parametro = Array(
            'DataServerName' => 'FinCFODataBR',
            'Contexto' => 'codcoligada=1',
        );

        $Z = 'FCFO';
        $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

        if (substr($retorno, 0, 2) == '1;') {
            $codcfo = substr($retorno, 2);
        } else {
            $qtdErro++;

            $retorno_org = $retorno;
            $i = strpos($retorno, '=======================================');
            if ($i !== FALSE) {
                $retorno = substr($retorno, 0, $i);
            }

            $erro = 'ERRO DO RM: ' . $retorno;

            $inf_extra = Array(
                'mensagem' => $retorno_org,
                'Z' => $Z,
                'parametro' => $parametro,
                'registro' => $registro,
            );
            $vetErro[] = $erro;
            $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

            $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
            $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
            $sql .= " erro = " . aspa($erro);
            $sql .= ' where idt = ' . null($row_siac['idt']);
            execsql($sql, false);
        }
    } else {
        $codcfo = $rsRM['FCFO']->data[0]['codcfo'];
        $pagrec = $rsRM['FCFO']->data[0]['pagrec'];
        $ativo = $rsRM['FCFO']->data[0]['ativo'];
        $codtcf = $rsRM['FCFO']->data[0]['codtcf'];

        if ($pagrec == 2 || ativo != 1 || $codtcf == '') {
            if ($pagrec == 2) {
                $pagrec = 3;
            }

            if ($codtcf == '') {
                $codtcf = '028';
            }

            $registro = Array(
                'CODCOLIGADA' => 1,
                'CODCOLTCF' => 1,
                'CODCFO' => $codcfo,
                'CODTCF' => $codtcf,
                'ATIVO' => 1,
                'PAGREC' => $pagrec,
            );

            $parametro = Array(
                'DataServerName' => 'FinCFODataBR',
                'Contexto' => 'codcoligada=1',
            );

            $Z = 'FCFO';
            $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

            if (substr($retorno, 0, 2) == '1;') {
                $codcfo = substr($retorno, 2);
            } else {
                $qtdErro++;

                $retorno_org = $retorno;
                $i = strpos($retorno, '=======================================');
                if ($i !== FALSE) {
                    $retorno = substr($retorno, 0, $i);
                }

                $erro = 'ERRO DO RM: ' . $retorno;

                $inf_extra = Array(
                    'mensagem' => $retorno_org,
                    'Z' => $Z,
                    'parametro' => $parametro,
                    'registro' => $registro,
                );
                $vetErro[] = $erro;
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $inf_extra);

                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            }
        }
    }

    return $codcfo;
}

function criaAgendaEntregaSGLocal() {
    global $row_siac, $usaTransaction, $ativoTransaction;

    if ($usaTransaction) {
        beginTransaction();
        $ativoTransaction = true;
    }

    criaAgendaEntregaSG($row_siac['idt_evento'], $row_siac['idt_atendimento']);

    if ($usaTransaction) {
        commit();
        $ativoTransaction = false;
    }
}

function dt_vencimento_prox($data, $parcela) {
    $vetDT = DatetoArray(trata_data($data));

    $dia = $vetDT['dia'];
    $mes = $vetDT['mes'];
    $ano = $vetDT['ano'];

    $mes = $mes + $parcela;

    if ($mes > 12) {
        $mes = $mes - 12;
        $ano++;
    }

    if (!checkdate($mes, $dia, $ano)) {
        $dia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
    }

    return date("d/m/Y", mktime(0, 0, 0, $mes, $dia, $ano));
}

function criaCLD($row_siac) {
    global $conSIAC, $codsebrae, $usaTransaction, $qtdErro, $vetFocoTematicoTema, $ativoTransaction, $ativoTransactionSIAC;

    set_time_limit(300);

    $sql = '';
    $sql .= ' select gec_prog.tipo_ordem, e.sgtec_modelo, e.idt_evento_situacao';
    $sql .= ' from grc_evento e';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa gec_prog on gec_prog.idt = e.idt_programa';
    $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);
    $rs = execsql($sql, false);
    $row_e = $rs->data[0];

    $roda = true;

    if ($row_e['tipo_ordem'] == 'SG' && $row_e['sgtec_modelo'] == 'E') {
        $roda = false;

        if ($row_e['idt_evento_situacao'] == 14 || $row_e['idt_evento_situacao'] == 16 || $row_e['idt_evento_situacao'] == 19 || $row_e['idt_evento_situacao'] == 20) {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
            $sql .= ' where idt_evento = ' . null($row_siac['idt_evento']);
            $sql .= ' and idt_gec_contratacao_status <> 9';
            $sql .= " and ativo = 'S'";
            $rs = execsql($sql, false);

            if ($rs->rows == 0) {
                $roda = true;
                criaAgendaEntregaSGLocal();

                $sql = '';
                $sql .= " select min(str_to_date(concat('01/', mesano),'%d/%m/%Y')) as dt_ini, max(str_to_date(concat('01/', mesano),'%d/%m/%Y')) as dt_fim";
                $sql .= ' from grc_evento_entrega';
                $sql .= ' where idt_evento = ' . null($row_siac['idt_evento']);
                $rs = execsql($sql, false);
                $row = $rs->data[0];

                $dt_previsao_inicial = $row['dt_ini'];

                //ultimo dia
                $mesano = trata_data($row['dt_fim']);
                $vetMesAno = explode('/', $mesano);
                $dia = cal_days_in_month(CAL_GREGORIAN, $vetMesAno[1], $vetMesAno[2]);

                $dt_previsao_fim = trata_data($dia . '/' . $vetMesAno[1] . '/' . $vetMesAno[2]);
            }
        }
    }

    if ($roda) {
        $sql = '';
        $sql .= ' select e.descricao as nomeconsultoria, e.codigo, e.objetivo as objetivoconsultoria, e.resultado_esperado as resultadosesperados,';
        $sql .= ' e.dt_previsao_inicial as dtinicio, e.dt_previsao_fim as dtfim, e.hora_inicio as hrinicio, e.hora_fim as hrfim,';
        $sql .= ' ac.codigo_proj as codprojeto, ac.codigo_siacweb as codacao, p.codigo_siac as codprodutoportfolio,';
        $sql .= ' unid.unidoperacional_siacweb as codunidop, area.codarea_siacweb as codarea, e.idt_cidade as codcid,';
        $sql .= ' u.codparceiro_siacweb as codresponsavel, pe.siacweb_codcosultoria as codconsultoria, pe.idt as idt_atendimento_pessoa,';
        $sql .= ' u.cpf as cpf_codresponsavel, rc.cpf as cpf_rc_codresponsavel, u.login as login_codresponsavel, rc.login as login_rc_codresponsavel,';
        $sql .= ' u.id_usuario as idt_codresponsavel, rc.id_usuario as idt_rc_codresponsavel,';
        $sql .= ' rc.codparceiro_siacweb as rc_codresponsavel, a.idt as idt_atendimento, a.protocolo, e.tipo_sincroniza_siacweb, e.idt_produto';
        $sql .= ' from grc_evento e';
        $sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
        $sql .= ' inner join grc_atendimento_pessoa pe on pe.idt_atendimento = a.idt';
        $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
        $sql .= ' inner join grc_projeto_acao ac on ac.idt = e.idt_acao';
        $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
        $sql .= ' inner join plu_usuario u on u.id_usuario = e.idt_gestor_evento';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao unid on e.idt_unidade = unid.idt';
        $sql .= ' left outer join plu_usuario rc on rc.id_usuario = e.idt_responsavel_consultor';
        $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao area on e.idt_ponto_atendimento_tela = area.idt';
        $sql .= ' where e.idt = ' . null($row_siac['idt_evento']);

        if ($row_siac['idt_atendimento'] != '') {
            $sql .= ' and a.idt = ' . null($row_siac['idt_atendimento']);
        }

        $sql .= " and ep.contrato in ('C', 'S', 'G')";
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rs_e = execsql($sql, false);

        if ($rs_e->rows == 0) {
            /*
              $qtdErro++;
              $erro = 'Evento não localizado no GRC!';

              $vetErro[] = $erro;
              $idt_erro_log = erro_try($erro.' ('.$row_siac['idt'].')', 'sincroniza_siac', $row_siac);

              $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(),';
              $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
              $sql .= " erro = ".aspa($erro);
              $sql .= ' where idt = '.null($row_siac['idt']);
              execsql($sql, false);
             */
        } else {
            if ($usaTransaction) {
                beginTransaction();
                $ativoTransaction = true;
            }

            beginTransaction($conSIAC);
            $ativoTransactionSIAC = true;

            $vetErroCons = Array();

            foreach ($rs_e->data as $row_e) {
                $sql = '';
                $sql .= " select codconsultoria";
                $sql .= ' from cons_consultoria with(nolock)';
                $sql .= ' where codconsultoria = ' . null($row_e['codconsultoria']);
                $rsSIAC = execsql($sql, false, $conSIAC);

                if ($rsSIAC->rows == 0) {
                    $row_e['codconsultoria'] = '';
                }

                $situacao = 'Aberta';

                if ($row_e['codresponsavel'] == '' && $row_e['cpf_codresponsavel'] != '') {
                    $sql = '';
                    $sql .= ' select codparceiro';
                    $sql .= ' from ' . db_pir_siac . 'parceiro';
                    $sql .= ' where cgccpf = ' . null(preg_replace('/[^0-9]/i', '', $row_e['cpf_codresponsavel']));
                    $rs = execsql($sql, false);

                    if ($rs->data[0][0] == '') {
                        migraParceiroSiacWeb('cpfcnpj', preg_replace('/[^0-9]/i', '', $row_e['cpf_codresponsavel']), true, true);
                        $rs = execsql($sql, false);
                    }

                    if ($rs->data[0][0] != '') {
                        $row_e['codresponsavel'] = $rs->data[0][0];

                        $sql = 'update plu_usuario set codparceiro_siacweb = ' . null($row_e['codresponsavel']);
                        $sql .= ' where id_usuario = ' . null($row_e['idt_codresponsavel']);
                        execsql($sql, false);
                    }
                }

                if ($row_e['rc_codresponsavel'] == '' && $row_e['cpf_rc_codresponsavel'] != '') {
                    $sql = '';
                    $sql .= ' select codparceiro';
                    $sql .= ' from ' . db_pir_siac . 'parceiro';
                    $sql .= ' where cgccpf = ' . null(preg_replace('/[^0-9]/i', '', $row_e['cpf_rc_codresponsavel']));
                    $rs = execsql($sql, false);

                    if ($rs->data[0][0] == '') {
                        migraParceiroSiacWeb('cpfcnpj', preg_replace('/[^0-9]/i', '', $row_e['cpf_rc_codresponsavel']), true, true);
                        $rs = execsql($sql, false);
                    }

                    if ($rs->data[0][0] != '') {
                        $row_e['rc_codresponsavel'] = $rs->data[0][0];

                        $sql = 'update plu_usuario set codparceiro_siacweb = ' . null($row_e['rc_codresponsavel']);
                        $sql .= ' where id_usuario = ' . null($row_e['idt_rc_codresponsavel']);
                        execsql($sql, false);
                    }
                }

                if ($row_e['rc_codresponsavel'] == '') {
                    $row_e['rc_codresponsavel'] = $row_e['codresponsavel'];
                }

                if ($row_e['rc_codresponsavel'] == '') {
                    $vetTmp = Array();
                    $vetTmp[$row_e['login_codresponsavel']] = $row_e['login_codresponsavel'];
                    $vetTmp[$row_e['login_rc_codresponsavel']] = $row_e['login_rc_codresponsavel'];

                    $vetErroCons[] = 'Favor informar o CPF dos usuários dos login ' . implode(', ', $vetTmp) . ' para poder o Código do Parceiro destes usuárois do Siacweb!';
                } else {
                    if ($row_e['codunidop'] == '') {
                        $row_e['codunidop'] = 0;
                    }

                    if ($row_e['codarea'] == '') {
                        $row_e['codarea'] = 0;
                    }

                    if ($row_e['tipo_ordem'] == 'SG' && $row_e['sgtec_modelo'] == 'E') {
                        $row_e['dtinicio'] = $dt_previsao_inicial;
                        $row_e['dtfim'] = $dt_previsao_fim;
                    }

                    $vetBindParam = Array();
                    $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                    $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                    $vetBindParam['NomeConsultoria'] = vetBindParam($row_e['codigo'] . ' - ' . $row_e['nomeconsultoria'], PDO::PARAM_STR);
                    $vetBindParam['DtInicioPrevisto'] = vetBindParam($row_e['dtinicio'] . ' ' . $row_e['hrinicio'], PDO::PARAM_STR);
                    $vetBindParam['ObjetivoConsultoria'] = vetBindParam($row_e['objetivoconsultoria'], PDO::PARAM_STR);
                    $vetBindParam['ResultadosEsperados'] = vetBindParam($row_e['resultadosesperados'], PDO::PARAM_STR);
                    $vetBindParam['CodProjeto'] = vetBindParam($row_e['codprojeto'], PDO::PARAM_STR);
                    $vetBindParam['CodAcao'] = vetBindParam($row_e['codacao'], PDO::PARAM_INT);
                    $vetBindParam['CodProdutoPortfolio'] = vetBindParam($row_e['codprodutoportfolio'], PDO::PARAM_INT);
                    $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['CodUnidOp'] = vetBindParam($row_e['codunidop'], PDO::PARAM_INT);
                    $vetBindParam['CodArea'] = vetBindParam($row_e['codarea'], PDO::PARAM_INT);
                    $vetBindParam['ResultadosObtidos'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['CodCid'] = vetBindParam($row_e['codcid'], PDO::PARAM_INT);
                    $vetBindParam['Situacao'] = vetBindParam($situacao, PDO::PARAM_STR);
                    $vetBindParam['CodTipoConsultoria'] = vetBindParam(2, PDO::PARAM_INT);
                    $vetBindParam['CodResponsavel'] = vetBindParam($row_e['codresponsavel'], PDO::PARAM_INT);
                    $vetBindParam['CodTema'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['CodAreaTematica'] = vetBindParam(null, PDO::PARAM_NULL);
                    $vetBindParam['DescTema'] = vetBindParam(null, PDO::PARAM_NULL);

                    if ($row_e['codconsultoria'] == '') {
                        $sql = 'ConsInserirConsultoria';

                        unset($vetBindParam['CodConsultoria']);

                        execsql($sql, false, $conSIAC, $vetBindParam);
                        $row_e['codconsultoria'] = lastInsertId('CONS_CONSULTORIA', $conSIAC);

                        $sql = 'update grc_atendimento_pessoa set siacweb_codcosultoria = ' . null($row_e['codconsultoria']);
                        $sql .= ' where idt = ' . null($row_e['idt_atendimento_pessoa']);
                        execsql($sql, false);

                        $sql = 'ConsInserirConsultoriaTecnico';

                        $vetBindParam = Array();
                        $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                        $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                        $vetBindParam['VlrHora'] = vetBindParam(0, PDO::PARAM_INT);
                        $vetBindParam['CodClasse'] = vetBindParam(5, PDO::PARAM_INT);

                        execsql($sql, false, $conSIAC, $vetBindParam);
                    } else {
                        $sql = 'ConsAtualizarConsultoria';

                        execsql($sql, false, $conSIAC, $vetBindParam);

                        $sql = '';
                        $sql .= ' sp_executesql';
                        $sql .= " N'";
                        $sql .= ' update cons_consultoria set DtCancelamento = null, ObsCancelamento = null, CodMotivoRecisao = null';
                        $sql .= ' where CodConsultoria = @CodConsultoria';
                        $sql .= ' and CodSebrae = @CodSebrae';
                        $sql .= " ',";
                        $sql .= " N'";
                        $sql .= ' @CodConsultoria int, @CodSebrae int';
                        $sql .= " '";
                        $sql .= ', ' . null($row_e['codconsultoria']);
                        $sql .= ', ' . null($codsebrae);
                        execsql($sql, false, $conSIAC, true);
                    }

                    //Consultor/Responsável
                    $sql = '';
                    $sql .= ' sp_executesql';
                    $sql .= " N'";
                    $sql .= ' delete from cons_consultoriaresponsavel';
                    $sql .= ' where CodConsultoria = @CodConsultoria';
                    $sql .= ' and CodSebrae = @CodSebrae';
                    $sql .= " ',";
                    $sql .= " N'";
                    $sql .= ' @CodConsultoria int, @CodSebrae int';
                    $sql .= " '";
                    $sql .= ', ' . null($row_e['codconsultoria']);
                    $sql .= ', ' . null($codsebrae);
                    execsql($sql, false, $conSIAC, true);

                    $vetBindParam = Array();
                    $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                    $vetBindParam['CodResponsavel'] = vetBindParam($row_e['rc_codresponsavel'], PDO::PARAM_INT);

                    $sql = 'ConsInserirConsultoriaResponsavel';

                    execsql($sql, false, $conSIAC, $vetBindParam);

                    //Cadastra Atividade
                    $vetCodAtividadeOK = Array();
                    $vetCodAtividadeOK[0] = 0;

                    if ($row_e['tipo_sincroniza_siacweb'] != 'P') {
                        $sql = '';
                        $sql .= ' select ft.codigo';
                        $sql .= ' from grc_produto p';
                        $sql .= ' inner join grc_foco_tematico ft on ft.idt = p.idt_foco_tematico';
                        $sql .= ' where p.idt = ' . null($row_e['idt_produto']);
                        $rsf = execsql($sql, false);
                        $cod_foco_tematico = $rsf->data[0][0];

                        $sql = '';
                        $sql .= ' select ea.idt, ea.atividade, ea.siacweb_codatividade,';
                        $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.dt_ini) as dt_ini, max(ag.dt_fim) as dt_fim,';
                        $sql .= ' avg(ag.valor_hora) as valor_hora, max(ag.competencia) as competencia';
                        $sql .= ' from grc_evento_atividade ea';
                        $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
                        $sql .= ' where ea.idt_atendimento = ' . null($row_e['idt_atendimento']);
                        $sql .= ' group by ea.idt, ea.atividade, ea.siacweb_codatividade';
                        $rs_ea = execsql($sql, false);

                        foreach ($rs_ea->data as $row_ea) {
                            $codtema = $vetFocoTematicoTema[$cod_foco_tematico];

                            if ($row_e['tipo_sincroniza_siacweb'] == 'LHR') {
                                $carga_horaria = $row_ea['carga_horaria'] / $rs_e->rows;
                            } else {
                                $carga_horaria = $row_ea['carga_horaria'];
                            }

                            if ($row_ea['siacweb_codatividade'] == '') {
                                $vetBindParam = Array();
                                $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                                $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                                $vetBindParam['CargaHoraria'] = vetBindParam($carga_horaria, PDO::PARAM_INT);
                                $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                                $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                                $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                                $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                                $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['CargaHorariaReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                                $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                                $sql = 'ConsInserirAtividadeConsultoria';

                                execsql($sql, false, $conSIAC, $vetBindParam);
                                $row_ea['siacweb_codatividade'] = lastInsertId('CONS_ATIVIDADE', $conSIAC);

                                $sql = "update grc_evento_atividade set siacweb_codatividade = " . null($row_ea['siacweb_codatividade']);
                                $sql .= ' where idt = ' . null($row_ea['idt']);
                                execsql($sql, false);
                            } else {
                                $vetBindParam = Array();
                                $vetBindParam['CodAtividade'] = vetBindParam($row_ea['siacweb_codatividade'], PDO::PARAM_INT);
                                $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                                $vetBindParam['CargaHoraria'] = vetBindParam($carga_horaria, PDO::PARAM_INT);
                                $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                                $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                                $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                                $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                                $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['CargaHorariaReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                                $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                                $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                                $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                                $sql = 'ConsAtualizaAtividadeConsultoria';

                                execsql($sql, false, $conSIAC, $vetBindParam);
                            }

                            $vetCodAtividadeOK[$row_ea['siacweb_codatividade']] = $row_ea['siacweb_codatividade'];
                        }
                    } else {
                        $sql = '';
                        $sql .= ' select ea.idt, ea.atividade, ea.siacweb_codatividade, ts.codigo as codtema,';
                        $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.dt_ini) as dt_ini, max(ag.dt_fim) as dt_fim,';
                        $sql .= ' avg(ag.valor_hora) as valor_hora, max(ag.competencia) as competencia';
                        $sql .= ' from grc_evento_atividade ea';
                        $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
                        $sql .= ' left outer join grc_tema_subtema ts on ts.idt = ea.idt_subtema';
                        $sql .= ' where ea.idt_atendimento = ' . null($row_e['idt_atendimento']);
                        $sql .= ' group by ea.idt, ea.atividade, ea.siacweb_codatividade, ts.codigo';
                        $rs_ea = execsql($sql, false);

                        foreach ($rs_ea->data as $row_ea) {
                            $codtema = preg_replace('/[^0-9]/i', '', $row_ea['codtema']);

                            if ($row_ea['siacweb_codatividade'] == '') {
                                $vetBindParam = Array();
                                $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                                $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                                $vetBindParam['CargaHoraria'] = vetBindParam($row_ea['carga_horaria'], PDO::PARAM_INT);
                                $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                                $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                                $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                                $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                                $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['CargaHorariaReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                                $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                                $sql = 'ConsInserirAtividadeConsultoria';

                                execsql($sql, false, $conSIAC, $vetBindParam);
                                $row_ea['siacweb_codatividade'] = lastInsertId('CONS_ATIVIDADE', $conSIAC);

                                $sql = "update grc_evento_atividade set siacweb_codatividade = " . null($row_ea['siacweb_codatividade']);
                                $sql .= ' where idt = ' . null($row_ea['idt']);
                                execsql($sql, false);
                            } else {
                                $vetBindParam = Array();
                                $vetBindParam['CodAtividade'] = vetBindParam($row_ea['siacweb_codatividade'], PDO::PARAM_INT);
                                $vetBindParam['DescAtividade'] = vetBindParam($row_ea['atividade'], PDO::PARAM_STR);
                                $vetBindParam['CargaHoraria'] = vetBindParam($row_ea['carga_horaria'], PDO::PARAM_INT);
                                $vetBindParam['DtInicio'] = vetBindParam($row_ea['dt_ini'], PDO::PARAM_STR);
                                $vetBindParam['DtFim'] = vetBindParam($row_ea['dt_fim'], PDO::PARAM_STR);
                                $vetBindParam['CodTecnico'] = vetBindParam(26405, PDO::PARAM_INT);
                                $vetBindParam['VlrHora'] = vetBindParam($row_ea['valor_hora'], PDO::PARAM_INT);
                                $vetBindParam['DtInicioReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DtFimReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['CargaHorariaReal'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['DescComentario'] = vetBindParam(null, PDO::PARAM_NULL);
                                $vetBindParam['MesAnoCompetencia'] = vetBindParam($row_ea['competencia'], PDO::PARAM_STR);
                                $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                                $vetBindParam['CodSebrae'] = vetBindParam($codsebrae, PDO::PARAM_INT);
                                $vetBindParam['CodTema'] = vetBindParam($codtema, PDO::PARAM_INT);

                                $sql = 'ConsAtualizaAtividadeConsultoria';

                                execsql($sql, false, $conSIAC, $vetBindParam);
                            }

                            $vetCodAtividadeOK[$row_ea['siacweb_codatividade']] = $row_ea['siacweb_codatividade'];
                        }
                    }

                    //Exclui as atividades que não tem mais no sistema
                    $sql = '';
                    $sql .= ' delete from cons_atividade';
                    $sql .= ' where CodConsultoria = ' . null($row_e['codconsultoria']);
                    $sql .= ' and CodSebrae = ' . null($codsebrae);
                    $sql .= ' and CodAtividade not in (' . implode(', ', $vetCodAtividadeOK) . ')';
                    execsql($sql, false, $conSIAC);

                    //Participantes
                    $sql = '';
                    $sql .= ' select p.idt as idt_atendimento_pessoa, p.siacweb_codparticipantecosultoria, p.codigo_siacweb as codpessoaf,';
                    $sql .= ' o.codigo_siacweb_e as codpessoaj, p.cpf, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo, o.cnpj, p.nome, o.razao_social,';
                    $sql .= ' o.idt as idt_atendimento_organizacao';
                    $sql .= ' from grc_atendimento_pessoa p';
                    $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = p.idt_atendimento';
                    $sql .= ' where p.idt = ' . null($row_e['idt_atendimento_pessoa']);
                    $rs_p = execsql($sql, false);

                    if ($rs_p->rows == 0) {
                        $vetErroCons[] = 'Matricula ' . $row_e['protocolo'] . ' do Evento não localizado no GRC!';
                    } else {
                        foreach ($rs_p->data as $row_p) {
                            $regOK = true;

                            $duplicadoF = '';
                            $codparceiro = codParceiroSiacWeb('F', $duplicadoF, $row_p['cpf']);

                            if ($codparceiro == '' && substr($row_p['codpessoaf'], 0, 2) != '99') {
                                $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                            }

                            if ($row_p['codpessoaf'] != $codparceiro && $codparceiro != '') {
                                updateCodSiacweb($row_p['codpessoaf'], $codparceiro, 'F');
                                $row_p['codpessoaf'] = $codparceiro;
                            }

                            $duplicadoJ = '';
                            $codparceiro = codParceiroSiacWeb('J', $duplicadoJ, $row_p['cnpj'], $row_p['nirf'], $row_p['dap'], $row_p['rmp'], $row_p['ie_prod_rural'], $row_p['sicab_codigo']);

                            if ($codparceiro == '' && $row_p['idt_atendimento_organizacao'] != '' && substr($row_p['codpessoaj'], 0, 2) != '99') {
                                $codparceiro = '99' . geraAutoNum(db_pir_grc, 'codparceiro_99', 12);
                            }

                            if ($row_p['codpessoaj'] != $codparceiro && $codparceiro != '') {
                                updateCodSiacweb($row_p['codpessoaj'], $codparceiro, 'J');
                                $row_p['codpessoaj'] = $codparceiro;
                            }

                            if ($duplicadoF != '') {
                                $vetErroCons[] = 'Matricula ' . $row_e['protocolo'] . ' com registro duplicado no SiacWeb!' . $duplicadoF;
                            } else if ($duplicadoJ != '') {
                                $vetErroCons[] = 'Matricula ' . $row_e['protocolo'] . ' com registro duplicado no SiacWeb!' . $duplicadoJ;
                            } else {
                                if (substr($row_p['codpessoaf'], 0, 2) == '99') {
                                    $parametro = Array(
                                        'en_Cpf' => preg_replace('/[^0-9]/i', '', $row_p['cpf']),
                                    );

                                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                                    $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                                    $rowResult = $SebareResult->data[0];

                                    if ($rowResult['codparceiro'] != '') {
                                        updateCodSiacweb($row_p['codpessoaf'], $rowResult['codparceiro'], 'F');

                                        $row_p['codpessoaf'] = $rowResult['codparceiro'];
                                    }
                                }

                                if ($row_p['codpessoaf'] == '' || substr($row_p['codpessoaf'], 0, 2) == '99') {
                                    $vetErroCons[] = 'O registro da pessoa ' . $row_p['cpf'] . ' ' . $row_p['nome'] . ' (IDT: ' . $row_p['idt_atendimento_pessoa'] . ') não foi sincronizado!';
                                    $regOK = false;
                                }

                                if (substr($row_p['codpessoaj'], 0, 2) == '99') {
                                    $parametro = Array(
                                        'en_CgcCpf' => preg_replace('/[^0-9]/i', '', $row_p['cnpj']),
                                        'en_Email' => '',
                                        'en_CPR' => '',
                                    );

                                    $SebraeSIACcad = new SebraeSIAC('SiacWEB_CadastroAtenderWS', 'tns');
                                    $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                                    $rowResult = $SebareResult->data[0];

                                    if ($rowResult['codparceiro'] != '') {
                                        updateCodSiacweb($row_p['codpessoaj'], $rowResult['codparceiro'], 'J');

                                        $row_p['codpessoaj'] = $rowResult['codparceiro'];
                                    }
                                }

                                if ($row_p['idt_atendimento_organizacao'] != '' && ($row_p['codpessoaj'] == '' || substr($row_p['codpessoaj'], 0, 2) == '99')) {
                                    $vetErroCons[] = 'O registro do empreendimento ' . $row_p['cnpj'] . ' ' . $row_p['razao_social'] . ' (IDT: ' . $row_p['idt_atendimento_organizacao'] . ') não foi sincronizado!';
                                    $regOK = false;
                                }

                                if ($regOK) {
                                    if ($row_p['siacweb_codparticipantecosultoria'] == '') {
                                        $vetBindParam = Array();
                                        $vetBindParam['CodConsultoria'] = vetBindParam($row_e['codconsultoria'], PDO::PARAM_INT);
                                        $vetBindParam['CodPessoaF'] = vetBindParam($row_p['codpessoaf'], PDO::PARAM_INT);
                                        $vetBindParam['CodPessoaJ'] = vetBindParam($row_p['codpessoaj'], PDO::PARAM_INT);

                                        $sql = 'ConsInserirConsultoriaParticipantes';

                                        execsql($sql, false, $conSIAC, $vetBindParam);
                                        $row_p['siacweb_codparticipantecosultoria'] = lastInsertId('CONS_CONSULTORIAPARTICIPANTE', $conSIAC);

                                        $sql = "update grc_atendimento_pessoa set evento_inscrito = 'S', siacweb_codparticipantecosultoria = " . null($row_p['siacweb_codparticipantecosultoria']);
                                        $sql .= ' where idt = ' . null($row_p['idt_atendimento_pessoa']);
                                        execsql($sql, false);

                                        $sql = "update grc_evento set qtd_matriculado_siacweb = qtd_matriculado_siacweb + 1, qtd_vagas_resevado = qtd_vagas_resevado - 1";
                                        $sql .= " where idt = " . null($row_siac['idt_evento']);
                                        execsql($sql, false);
                                    } else {
                                        $sql = '';
                                        $sql .= ' sp_executesql';
                                        $sql .= " N'";
                                        $sql .= ' update CONS_CONSULTORIAPARTICIPANTE set';
                                        $sql .= ' CodConsultoria = @CodConsultoria,';
                                        $sql .= ' CodPessoaF = @CodPessoaF,';
                                        $sql .= ' CodPessoaJ = @CodPessoaJ';
                                        $sql .= ' where CodParticipanteCosultoria = @CodParticipanteCosultoria';
                                        $sql .= ' and CodSebrae = @CodSebrae';
                                        $sql .= " ',";
                                        $sql .= " N'";
                                        $sql .= ' @CodConsultoria int, @CodParticipanteCosultoria int, @CodSebrae int, @CodPessoaF int, @CodPessoaJ int';
                                        $sql .= " '";
                                        $sql .= ', ' . null($row_e['codconsultoria']);
                                        $sql .= ', ' . null($row_p['siacweb_codparticipantecosultoria']);
                                        $sql .= ', ' . null($codsebrae);
                                        $sql .= ', ' . null($row_p['codpessoaf']);
                                        $sql .= ', ' . null($row_p['codpessoaj']);
                                        execsql($sql, false, $conSIAC, true);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (count($vetErroCons) == 0) {
                $sql = 'update grc_sincroniza_siac set dt_sincroniza = now(), erro = null, idt_erro_log = null';
                $sql .= ' where idt in (' . $row_siac['idt'] . ')';
                execsql($sql, false);

                if ($usaTransaction) {
                    commit();
                    $ativoTransaction = false;
                }

                commit($conSIAC);
                $ativoTransactionSIAC = false;
            } else {
                if ($usaTransaction && $ativoTransaction) {
                    rollBack();
                    $ativoTransaction = false;
                }

                if ($ativoTransactionSIAC) {
                    rollBack($conSIAC);
                    $ativoTransactionSIAC = false;
                }

                $qtdErro += count($vetErroCons);
                $erro = 'Erros na inclução do evento no SiacWeb!';

                $vetErro = array_merge($vetErro, $vetErroCons);
                $idt_erro_log = erro_try($erro . ' (' . $row_siac['idt'] . ')', 'sincroniza_siac', $vetErroCons);

                $sql = 'update grc_sincroniza_siac set';
                $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
                $sql .= " erro = " . aspa($erro);
                $sql .= ' where idt = ' . null($row_siac['idt']);
                execsql($sql, false);
            }
        }
    }
}

function funcCatch() {
    global $qtdErro, $row_siac, $sql, $vetErro, $e, $conSIAC, $ativoTransaction, $ativoTransactionSIAC;

    if ($ativoTransaction) {
        rollBack();
        $ativoTransaction = false;
    }

    if ($ativoTransactionSIAC) {
        rollBack($conSIAC);
        $ativoTransactionSIAC = false;
    }

    $qtdErro++;

    $inf_extra = Array(
        'row_siac' => $row_siac,
        'sql' => $sql,
    );

    $erro = grava_erro_log('sincroniza_siac', $e, $sql, '', $inf_extra, $idt_erro_log);
    $vetErro[] = $erro;

    if ($row_siac['idts'] == '') {
        $idt = $row_siac['idt'];
    } else {
        $idt = $row_siac['idts'];
    }

    $sql = 'update grc_sincroniza_siac set';
    $sql .= ' idt_erro_log = ' . null($idt_erro_log) . ',';
    $sql .= " erro = " . aspa($erro);
    $sql .= ' where idt in (' . $idt . ')';
    execsql($sql, false);
}
