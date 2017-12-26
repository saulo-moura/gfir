<?php
require_once 'configuracao.php';

function consultorIndicado($idt_entidade, $rowPSTEnd, $rowe) {
    $retorno = Array();

    if ($idt_entidade == '') {
        $retorno['cpf'] = preg_replace('/[^0-9]/i', '', $rowe['cpf_pessoa']);
        $retorno['nome'] = $rowe['nome_pessoa'];
        $retorno['cep'] = preg_replace('/[^0-9]/i', '', $rowPSTEnd['cep']);
        $retorno['logradouro'] = $rowPSTEnd['logradouro'];
        $retorno['numero'] = $rowPSTEnd['logradouro_numero'];
        $retorno['idescolaridade'] = '';
        $retorno['formacao'] = 'Consultor';
        $retorno['sexo'] = '1'; //Masculino
        $retorno['idpais'] = $rowPSTEnd['idpais'];
        $retorno['idestado'] = $rowPSTEnd['idestado'];
        $retorno['estado'] = $rowPSTEnd['logradouro_estado'];
        $retorno['idcidade'] = $rowPSTEnd['idcidade'];
        $retorno['idbairro'] = $rowPSTEnd['idbairro'];

        $idt_endereco = $rowPSTEnd['idt_endereco'];
    } else {
        $sql = '';
        $sql .= ' select e.idt as idt_entidade, e.codigo as cpf, e.descricao as nome, s.codigo as cod_sexo, gf.codigo as idescolaridade';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_pessoa p on p.idt_entidade = e.idt';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_grau_formacao gf on gf.idt = p.idt_escolaridade';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_sexo s on s.idt = p.idt_sexo';
        $sql .= ' where e.idt = ' . null($idt_entidade);
        $rs = execsql($sql, false);

        if ($rs->rows == 1) {
            $row = $rs->data[0];

            $sql = '';
            $sql .= ' select end.idt as idt_endereco, end.cep, end.logradouro, end.logradouro_numero as numero, end.logradouro_estado as estado,';
            $sql .= ' end.logradouro_codpais as idpais, end.logradouro_codest as idestado, end.logradouro_codcid as idcidade, end.logradouro_codbairro as idbairro';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade_endereco end ';
            $sql .= ' where end.idt_entidade = ' . null($row['idt_entidade']);
            $sqlEnd = $sql;

            $sql .= ' and end.idt_entidade_endereco_tipo = 6';
            $rsEnd = execsql($sql, false);

            if ($rsEnd->rows == 0) {
                $rsEnd = execsql($sqlEnd, false);
            }

            $rowEnd = $rsEnd->data[0];

            $retorno['cpf'] = preg_replace('/[^0-9]/i', '', $row['cpf']);
            $retorno['nome'] = $row['nome'];
            $retorno['cep'] = preg_replace('/[^0-9]/i', '', $rowEnd['cep']);
            $retorno['logradouro'] = $rowEnd['logradouro'];
            $retorno['numero'] = $rowEnd['numero'];
            $retorno['idescolaridade'] = $row['idescolaridade'];
            $retorno['formacao'] = 'Consultor';

            if ($row['cod_sexo'] == 2) {
                //Feminino
                $retorno['sexo'] = 0;
            } else {
                //Masculino
                $retorno['sexo'] = 1;
            }

            $retorno['idpais'] = $rowEnd['idpais'];
            $retorno['idestado'] = $rowEnd['idestado'];
            $retorno['estado'] = $rowEnd['estado'];
            $retorno['idcidade'] = $rowEnd['idcidade'];
            $retorno['idbairro'] = $rowEnd['idbairro'];

            $idt_endereco = $rowEnd['idt_endereco'];
        }
    }

    $sql = '';
    $sql .= ' select email_1, email_2';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao';
    $sql .= ' where idt_endereco = ' . null($idt_endereco);
    $rsc = execsql($sql, false);

    foreach ($rsc->data as $rowc) {
        if ($rowc['email_1'] != '') {
            $retorno['email'] = $rowc['email_1'];
            break;
        }

        if ($rowc['email_2'] != '') {
            $retorno['email'] = $rowc['email_2'];
            break;
        }
    }

    if ($retorno['email'] == '') {
        $retorno['email'] = 'edital.ict@ba.sebrae.com.br';
    }

    //Escolaridade  do Consultor não informado
    if ($retorno['idescolaridade'] == '') {
        $retorno['idescolaridade'] = 2; //ENSINO SUPERIOR COMPLETO
    }

    return $retorno;
}

set_time_limit(0);
$vetErro = Array();
$vetDados = Array();
$qtdErro = 0;

try {
    $SoapSebraeRM_CS = new SoapSebraeRMGeral('wsConsultaSQL');
    $sebraeuf = 'BA';

    $sql = '';
    $sql .= ' select e.codigo, o.idt_evento, l.idt_organizacao, l.idt_primeiro as idt_pessoa, e.sgtec_modelo, coalesce(le.data_cotacao, l.dt_resposta) as dataenvio,';
    $sql .= ' i.custo_total_real as vl_cotacao, e.ws_sg_idprestadora, le.cpf_pessoa, le.nome_pessoa,';

    //Evento
    $sql .= ' ao.idt_atendimento, e.descricao as nomeprojeto, prd.descricao as demanda, rd.cpf as cpfresponsaveldemanda, e.data_criacao as datacadastro,';
    $sql .= ' e.dt_consolidado as datamudsituacao, e.dt_previsao_inicial as datainicio, e.dt_previsao_fim as datafim, e.custo_tot_consultoria as valortotal,';
    $sql .= ' rd.nome_completo as usumsg_nome, rd.cpf as usumsg_cpf, rd.email as usumsg_email, pra.codigo_sge as codigo_acao_sge,';
    $sql .= ' coalesce(ep.vl_tot_pagamento_real, ep.vl_tot_pagamento) as valorarrecadado, e.idt_produto, e.contrapartida_sgtec,';
    $sql .= ' sg_tp.codigo as idproduto, sg_mo.codigo as idmodalidade, sg_na.codigo as natureza,';

    //Matricula - Empresa
    $sql .= ' ao.cnpj as cl_cnpj, ao.razao_social as cl_razaosocial, ao.nome_fantasia as cl_nomefantasia, ao.email_e as cl_email, ao.logradouro_cep_e as cl_cep,';
    $sql .= ' ao.logradouro_codpais_e as cl_idpais, ao.logradouro_codest_e as cl_idestado, ao.logradouro_codcid_e as cl_idcidade, ao.logradouro_codbairro_e as cl_idbairro,';
    $sql .= ' ao.logradouro_endereco_e as cl_logradouro, ao.logradouro_numero_e as cl_numero, ao.logradouro_complemento_e as cl_complemento,';
    $sql .= ' ao.idt_tipo_empreendimento as cl_produtorrural, s.id_ws_sgtec_nacional as idsetoreconomico, op.codigo as cl_codfaturamento,';
    $sql .= ' ao.idt_cnae_principal as cl_cnae, ao.dap as cl_dap, ao.nirf as cl_nirf, ao.rmp as cl_rmp, ao.ie_prod_rural as cl_ie_prod_rural,';

    //Matricula - Pessoa Fisica
    $sql .= ' ap.idt as idt_atendimento_pessoa, ap.cpf as cl_cpf, ap.nome as cl_contato';

    $sql .= ' from grc_evento e';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt_evento = e.idt';
    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_insumo i on i.idt_gec_contratacao_credenciado_ordem = o.idt and i.codigo = '71001'";
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista l on l.idt_gec_contratacao_credenciado_ordem = o.idt';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista_endidade le on le.idt_gec_contratacao_credenciado_ordem_lista = l.idt and l.idt_organizacao = le.idt_organizacao';
    $sql .= ' left outer join grc_produto prd on prd.idt = e.idt_produto';
    $sql .= ' left outer join plu_usuario rd on rd.id_usuario = e.idt_gestor_evento';
    $sql .= ' left outer join grc_projeto_acao pra on pra.idt = e.idt_acao';
    $sql .= ' left outer join grc_atendimento a on a.idt_evento = e.idt';
    $sql .= ' left outer join grc_atendimento_organizacao ao on ao.idt_atendimento = a.idt';
    $sql .= ' left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = a.idt';
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_setor s on s.idt = ao.idt_setor';
    $sql .= ' left outer join ' . db_pir_gec . 'gec_organizacao_porte op on op.idt = ao.idt_porte';
    $sql .= ' left outer join grc_sgtec_tipo_servico sg_tp on sg_tp.idt = prd.idt_sgtec_tipo_servico';
    $sql .= ' left outer join grc_sgtec_modalidade sg_mo on sg_mo.idt = sg_tp.idt_modalidade';
    $sql .= ' left outer join grc_sgtec_natureza sg_na on sg_na.idt = sg_tp.idt_natureza';
    $sql .= ' where e.idt_evento_situacao = 20';
    $sql .= ' and e.idt_programa = 4';
    $sql .= " and l.ativo = 'S'";
    $sql .= ' and e.ws_sg_erro is null';
    $sql .= ' and ap.ws_sg_erro is null';
    $sql .= ' and ap.ws_sg_iddemanda is null';
    $sql .= " and (ep.contrato is null or ep.contrato in ('C', 'S', 'G'))";
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $sql .= " and o.ativo = 'S'";
    $rse = execsqlNomeCol($sql, false);
} catch (PDOException $e) {
    $qtdErro++;
    $vetErro[] = grava_erro_log('sincroniza_ws_sg', $e, $sql);
} catch (Exception $e) {
    $qtdErro++;
    $vetErro[] = grava_erro_log('sincroniza_ws_sg', $e, '');
}

if ($qtdErro == 0) {
    foreach ($rse->data as $rowe) {
        try {
            set_time_limit(0);
            $continua = true;

            if ($rowe['cl_email'] == '') {
                $rowe['cl_email'] = 'edital.ict@ba.sebrae.com.br';
            }

            if ($rowe['idsetoreconomico'] == '') {
				$sql = '';
				$sql .= ' select es.id_ws_sgtec_nacional';
				$sql .= ' from ' . db_pir_gec . 'cnae c';
				$sql .= ' inner join ' . db_pir_gec . 'gec_entidade_setor es on es.codigo = c.codsetor_siacweb';
				$sql .= ' where c.codclass_siacweb = 1';
				$sql .= ' and c.subclasse = ' . aspa($rowe['idt_cnae_principal']);
				$rs = execsql($sql, false);
				$rowe['idsetoreconomico'] = $rs->data[0][0];
			}

            if ($rowe['idt_atendimento_pessoa'] == '') {
                $continua = false;
                $qtdErro++;
                $erro = 'As informações da Demanda não foi localizado para o evento ' . $rowe['codigo'] . '!';

                $vetErro[] = $erro;
                $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $rowe);

                $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                $sql .= ' ws_sg_erro = ' . aspa($erro);
                $sql .= ' where idt = ' . null($rowe['idt_evento']);
                execsql($sql, false);
            }

            if ($continua) {
                $iddemanda = '';
                $idprestadora = $rowe['ws_sg_idprestadora'];

                if ($idprestadora == '') {
                    $idprestadora = $vetDados[$rowe['idt_evento']]['idprestadora'];
                }

                //Prestadora
                $sql = '';
                $sql .= ' select e.idt as idt_entidade, e.codigo as cnpj, e.descricao as razaosocial, e.resumo as nomefantasia, o.simples_nacional as optantesimples,';
                $sql .= ' s.id_ws_sgtec_nacional as idsetoreconomico';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao o on o.idt_entidade = e.idt';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_entidade_setor s on s.idt = o.idt_entidade_setor';
                $sql .= ' where e.idt = ' . null($rowe['idt_organizacao']);
                $rs = execsqlNomeCol($sql, false);

                if ($rs->rows == 1) {
                    $rowPST = $rs->data[0];

                    $sql = '';
                    $sql .= ' select end.idt as idt_endereco, end.cep, end.logradouro, end.logradouro_numero, end.logradouro_bairro, end.logradouro_municipio, end.logradouro_estado,';
                    $sql .= ' end.logradouro_codpais as idpais, end.logradouro_codest as idestado, end.logradouro_codcid as idcidade, end.logradouro_codbairro as idbairro';
                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_endereco end ';
                    $sql .= ' where end.idt_entidade = ' . null($rowPST['idt_entidade']);
                    $sqlEnd = $sql;

                    $sql .= ' and end.idt_entidade_endereco_tipo = 6';
                    $rsEnd = execsql($sql, false);

                    if ($rsEnd->rows == 0) {
                        $rsEnd = execsql($sqlEnd, false);
                    }

                    $rowPSTEnd = $rsEnd->data[0];

                    if ($rowPSTEnd['cep'] == '') {
                        $idprestadora = 'erro';

                        $qtdErro++;
                        $erro = 'O endereço Principal da PST da Ordem de Contração não foi localizado no cadastro (CNPJ: ' . $rowPST['cnpj'] . ')!';

                        $vetErro[] = $erro;
                        $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $rowe);

                        $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                        $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                        $sql .= ' ws_sg_erro = ' . aspa($erro);
                        $sql .= ' where idt = ' . null($rowe['idt_evento']);
                        execsql($sql, false);
                    } else {
                        $cnpjprestadora = preg_replace('/[^0-9]/i', '', $rowPST['cnpj']);

                        if ($idprestadora == '') {
                            $funcao = 'ConsultaPrestadoras';
                            $parametro = Array(
                                'CNPJ' => $cnpjprestadora,
                            );

                            $SebraeTEC = new SoapSebraeTEC();
                            $rsTEC = $SebraeTEC->executa($funcao, Array('ZPRESTADORASGCTEC'), $parametro, true);

                            if (is_string($rsTEC)) {
                                $qtdErro++;
                                $erro = 'ERRO DO WS: [' . $funcao . '] ' . utf8_decode($rsTEC);

                                $inf_extra = Array(
                                    'funcao' => $funcao,
                                    'parametro' => $parametro,
                                    'xml' => $SebraeTEC->xml(),
                                );

                                $vetErro[] = $erro;
                                $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $inf_extra);

                                $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                                $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                                $sql .= ' ws_sg_erro = ' . aspa($erro);
                                $sql .= ' where idt = ' . null($rowe['idt_evento']);
                                execsql($sql, false);
                            } else {
                                $continua = true;

                                $idprestadora = $rsTEC['ZPRESTADORASGCTEC']->data[0]['idprestadora'];

                                if ($rowPST['optantesimples'] == 'S') {
                                    $optantesimples = 'true';
                                } else {
                                    $optantesimples = 'false';
                                }

                                $sql = '';
                                $sql .= ' select email_1, email_2';
                                $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao';
                                $sql .= ' where idt_endereco = ' . null($rowPSTEnd['idt_endereco']);
                                $rsc = execsql($sql, false);

                                $email = '';

                                foreach ($rsc->data as $rowc) {
                                    if ($rowc['email_1'] != '') {
                                        $email = $rowc['email_1'];
                                        break;
                                    }

                                    if ($rowc['email_2'] != '') {
                                        $email = $rowc['email_2'];
                                        break;
                                    }
                                }

                                if ($email == '') {
                                    $email = 'edital.ict@ba.sebrae.com.br';
                                }

                                $sql = '';
                                $sql .= ' select e.descricao as nome, end.idt as idt_endereco';
                                $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
                                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = ee.idt_entidade_relacionada';
                                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_endereco end on end.idt_entidade = e.idt';
                                $sql .= ' where ee.idt_entidade = ' . null($rowPST['idt_entidade']);
                                $sql .= ' and ee.idt_entidade_relacao = 11';
                                $sqlc = $sql;

                                $sql .= ' and end.idt_entidade_endereco_tipo = 6';
                                $rsc = execsql($sql, false);

                                if ($rsc->rows == 0) {
                                    $rsc = execsql($sqlc, false);
                                }

                                if ($rsc->rows == 0) {
                                    $continua = false;

                                    $qtdErro++;
                                    $erro = 'O Endereço Principal do Contato Principal da PST não foi localizado (CNPJ: ' . $rowPST['cnpj'] . ')!';

                                    $vetErro[] = $erro;
                                    $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $inf_extra);

                                    $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                                    $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                                    $sql .= ' ws_sg_erro = ' . aspa($erro);
                                    $sql .= ' where idt = ' . null($rowe['idt_evento']);
                                    execsql($sql, false);
                                } else {
                                    $rowc = $rsc->data[0];

                                    $nome_contato = $rowc['nome'];

                                    $sql = '';
                                    $sql .= ' select email_1, email_2';
                                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_comunicacao';
                                    $sql .= ' where idt_endereco = ' . null($rowc['idt_endereco']);
                                    $rsc = execsql($sql, false);

                                    $email_contato = '';

                                    foreach ($rsc->data as $rowc) {
                                        if ($rowc['email_1'] != '') {
                                            $email_contato = $rowc['email_1'];
                                            break;
                                        }

                                        if ($rowc['email_2'] != '') {
                                            $email_contato = $rowc['email_2'];
                                            break;
                                        }
                                    }

                                    if ($email_contato == '') {
                                        $email_contato = 'edital.ict@ba.sebrae.com.br';
                                    }

                                    $sql = '';
                                    $sql .= ' select cnae';
                                    $sql .= ' from ' . db_pir_gec . 'gec_entidade_cnae';
                                    $sql .= ' where idt_entidade = ' . null($rowPST['idt_entidade']);
                                    $sql .= ' order by principal desc';
                                    $rsc = execsql($sql, false);

                                    $cnae = '';

                                    foreach ($rsc->data as $rowc) {
                                        if ($rowc['cnae'] != '') {
                                            $cnae = $rowc['cnae'];
                                            break;
                                        }
                                    }

									if ($rowPST['idsetoreconomico'] == '') {
										$sql = '';
										$sql .= ' select es.id_ws_sgtec_nacional';
										$sql .= ' from ' . db_pir_gec . 'cnae c';
										$sql .= ' inner join ' . db_pir_gec . 'gec_entidade_setor es on es.codigo = c.codsetor_siacweb';
										$sql .= ' where c.codclass_siacweb = 1';
										$sql .= ' and c.subclasse = ' . aspa($cnae);
										$rs = execsql($sql, false);
										$rowPST['idsetoreconomico'] = $rs->data[0][0];
									}

                                    $registro = Array();

                                    $registro['ZPRESTADORASGCTEC'] = Array(
                                        'SEBRAEUF' => $sebraeuf,
                                        'RAZAOSOCIAL' => $rowPST['razaosocial'],
                                        'CNPJ' => $cnpjprestadora,
                                        'NOMEFANTASIA' => $rowPST['nomefantasia'],
                                        'OPTANTESIMPLES' => $optantesimples,
                                        'OBJETOSOCIAL' => 'Consultoria',
                                        'EMAIL' => $email,
                                        'CEP' => preg_replace('/[^0-9]/i', '', $rowPSTEnd['cep']),
                                        'LOGRADOURO' => $rowPSTEnd['logradouro'],
                                        'NUMERO' => $rowPSTEnd['logradouro_numero'],
                                        'BAIRRO' => $rowPSTEnd['logradouro_bairro'],
                                        'CIDADE' => $rowPSTEnd['logradouro_municipio'],
                                        'ESTADO' => $rowPSTEnd['logradouro_estado'],
                                        'NAOPARTICIARNOVASDEMANDAS' => 'false',
                                        'ZPRESTADORACONTATOSGCTEC' => Array(
                                            'NOME' => $nome_contato,
                                            'EMAIL' => $email_contato,
                                        ),
                                        'ZPRESTADORASETORECONOMICOSGCTEC' => Array(
                                            'IDSETORECONOMICO' => $rowPST['idsetoreconomico'],
                                        ),
                                        'ZPRESTADORACNAESGCTEC' => Array(
                                            'CNAE' => $cnae,
                                        ),
                                        'ZPRESTADORAAREAATUACAOSGCTEC' => Array(
                                            'AREAATUACAO' => $sebraeuf,
                                        ),
                                        'ZPRESTADORARELATOEDITALSGCTEC' => Array(
                                            'SITUACAO' => 'Ativo',
                                        ),
                                    );

                                    if (is_numeric($idprestadora)) {
                                        $funcao = 'AlteraPrestadora';
                                        $Z = Array('ZPRESTADORASGCTEC');

                                        unset($registro['ZPRESTADORASGCTEC']['ZPRESTADORARELATOEDITALSGCTEC']);

                                        $SebraeTEC = new SoapSebraeTEC();
                                        $idprestadora = $SebraeTEC->save($funcao, $Z, $registro, true);
                                    } else {
                                        $funcao = 'IncluiPrestadora';
                                        $Z = Array('ZPRESTADORASGCTEC');

                                        $SebraeTEC = new SoapSebraeTEC();
                                        $idprestadora = $SebraeTEC->save($funcao, $Z, $registro, true);
                                    }
                                }

                                if ($continua) {
                                    if (is_numeric($idprestadora)) {
                                        $vetDados[$rowe['idt_evento']]['idprestadora'] = $idprestadora;

                                        $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                                        $sql .= ' ws_sg_idprestadora = ' . null($idprestadora) . ',';
                                        $sql .= ' ws_sg_idt_erro_log = null,';
                                        $sql .= ' ws_sg_erro = null';
                                        $sql .= ' where idt = ' . null($rowe['idt_evento']);
                                        execsql($sql, false);

                                        $inf_extra = Array(
                                            'rowe' => $rowe,
                                            'funcao' => $funcao,
                                            'registro' => $registro,
                                            'xml' => $SebraeTEC->xml(),
                                        );

                                        grava_log_sis('grc_evento', 'R', $rowe['idt_evento'], '[' . $rowe['codigo'] . '] Prestadora: ' . $idprestadora, 'WS Sebraetec Nacional', $inf_extra);
                                    } else {
                                        $qtdErro++;
                                        $erro = 'ERRO DO WS: [' . $funcao . '] ' . $idprestadora;

                                        $inf_extra = Array(
                                            'rowe' => $rowe,
                                            'funcao' => $funcao,
                                            'registro' => $registro,
                                            'xml' => $SebraeTEC->xml(),
                                        );

                                        $vetErro[] = $erro;
                                        $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $inf_extra);

                                        $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                                        $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                                        $sql .= ' ws_sg_erro = ' . aspa($erro);
                                        $sql .= ' where idt = ' . null($rowe['idt_evento']);
                                        execsql($sql, false);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $idprestadora = 'erro';

                    $qtdErro++;
                    $erro = 'O PST da Ordem de Contração não localizado para o evento ' . $rowe['codigo'] . '!';

                    $vetErro[] = $erro;
                    $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ')', 'sincroniza_ws_sg', $rowe);

                    $sql = 'update grc_evento set ws_sg_dt_cadastro = now(),';
                    $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                    $sql .= ' ws_sg_erro = ' . aspa($erro);
                    $sql .= ' where idt = ' . null($rowe['idt_evento']);
                    execsql($sql, false);
                }

                //Demanda
                if (is_numeric($idprestadora)) {
                    $vetErroDemanda = Array();

                    $rowCI = consultorIndicado($rowe['idt_pessoa'], $rowPSTEnd, $rowe);

                    //Consultor não informado
                    if ($rowCI['cpf'] == '') {
                        $vetErroDemanda[] = 'O Consultor da Ordem de Contração não foi localizado no cadastro!';
                    }

                    if ($rowCI['cep'] == '' || $rowCI['idpais'] == '' || $rowCI['idestado'] == '' || $rowCI['idcidade'] == '' || $rowCI['idbairro'] == '') {
                        $vetErroDemanda[] = 'O endereço Principal do Consultor da Ordem de Contração não foi localizado no cadastro ou está incompleto (CPF: ' . FormataCPF12($rowCI['cpf']) . ')!';
                    }

                    $vl_cotacao = $vetDados[$rowe['idt_evento']]['vl_cotacao'];

                    if ($vl_cotacao == '') {
                        $sql = '';
                        $sql .= ' select count(ea.idt) as qtd';
                        $sql .= ' from ' . db_pir_grc . 'grc_atendimento ea';
                        $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = ea.idt';
                        $sql .= ' where ea.idt_evento = ' . null($rowe['idt_evento']);
            $sql .= whereEventoParticipante();
                        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                        $rs = execsql($sql, false);
                        $quantidade_participante = $rs->data[0][0];

                        if ($quantidade_participante == '') {
                            $vl_cotacao = $rowe['vl_cotacao'];
                        } {
                            $vl_cotacao = $rowe['vl_cotacao'] / $quantidade_participante;
                        }

                        $vetDados[$rowe['idt_evento']]['vl_cotacao'] = $vl_cotacao;
                    }

                    if ($rowe['valorarrecadado'] == '') {
                        $sql = '';
                        $sql .= ' select sum(p.valor_pagamento) as valortotal';
                        $sql .= ' from grc_evento_participante_pagamento p';
                        $sql .= ' where p.idt_atendimento = ' . null($rowe['idt_atendimento']);
                        $sql .= " and (p.estornado <> 'S' or p.estornar_rm = 'S')";
                        $sql .= " and p.operacao = 'C'";
                        $rst = execsql($sql, false);
                        $rowe['valorarrecadado'] = $rst->data[0][0];

                        if ($rowe['valorarrecadado'] == '') {
                            $rowe['valorarrecadado'] = 0;
                        }
                    }

                    $parametro = Array(
                        'codSentenca' => 'WS_PRI_SGEvRM',
                        'codColigada' => '1',
                        'codAplicacao' => 'T',
                        'parameters' => 'GUIDACAOSGE=' . $rowe['codigo_acao_sge'],
                    );
                    $rsRM = $SoapSebraeRM_CS->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);
                    $rowRM = $rsRM['Resultado']->data[0];

                    $parametro = Array(
                        'codSentenca' => 'ws_pir_projeto',
                        'codColigada' => '1',
                        'codAplicacao' => 'T',
                        'parameters' => 'CODCCUSTO=' . $rowRM['projeto_acao_unidade_rm'],
                    );
                    $rsRM = $SoapSebraeRM_CS->executa('RealizarConsultaSQLAuth', Array('Resultado'), $parametro, true);
                    $rowRM = $rsRM['Resultado']->data[0];

                    $vetTmp = explode('.', $rowRM['codccusto1']);

                    $idprojetoorcamentario = $vetTmp[0];
                    $idacao = $vetTmp[1];

                    if ($idprojetoorcamentario == '') {
						$idprojetoorcamentario = '01433';
                        //$vetErroDemanda[] = 'O RM não retornou o IDPROJETOORCAMENTARIO do Projeto Ação do Evento!';
                    }

                    if ($idacao == '') {
						$idacao = '000010';
                        //$vetErroDemanda[] = 'O RM não retornou o IDACAO do Projeto Ação do Evento!';
                    }

                    $rowe['cpfresponsaveldemanda'] = preg_replace('/[^0-9]/i', '', $rowe['cpfresponsaveldemanda']);
                    $rowe['cl_cnpj'] = preg_replace('/[^0-9]/i', '', $rowe['cl_cnpj']);
                    $rowe['cl_cep'] = preg_replace('/[^0-9]/i', '', $rowe['cl_cep']);
                    $rowe['cl_cpf'] = preg_replace('/[^0-9]/i', '', $rowe['cl_cpf']);
                    $rowe['cl_cep'] = preg_replace('/[^0-9]/i', '', $rowe['cl_cep']);
                    $rowe['usumsg_cpf'] = preg_replace('/[^0-9]/i', '', $rowe['usumsg_cpf']);

                    if ($rowe['cl_produtorrural'] == 7) {
                        $rowe['cl_produtorrural'] = 'true';
                        $rowe['cl_cnpj'] = '';
                        $identificacaoempresa = $rowe['cl_dap'];

                        if ($identificacaoempresa == '') {
                            $identificacaoempresa = $rowe['cl_nirf'];
                        }

                        if ($identificacaoempresa == '') {
                            $identificacaoempresa = $rowe['cl_rmp'];
                        }

                        if ($identificacaoempresa == '') {
                            $identificacaoempresa = $rowe['cl_ie_prod_rural'];
                        }

                        $codprodutorrural = $identificacaoempresa;
                    } else {
                        $rowe['cl_produtorrural'] = 'false';
                        $identificacaoempresa = $rowe['cl_cnpj'];
                        $codprodutorrural = '';
                    }

                    $sql = '';
                    $sql .= ' select ac.ws_sg_idarea, ac.ws_sg_idsubarea';
                    $sql .= ' from ' . db_pir_gec . 'gec_area_conhecimento ac';
                    $sql .= ' inner join (';
                    $sql .= ' select substring(acp.codigo, 1, 6) as codigo, acp.idt_programa';
                    $sql .= ' from grc_produto_area_conhecimento pac';
                    $sql .= ' inner join ' . db_pir_gec . 'gec_area_conhecimento acp on acp.idt = pac.idt_area';
                    $sql .= ' where pac.idt_produto = ' . null($rowe['idt_produto']);
                    $sql .= ' ) as acn2 on acn2.codigo = ac.codigo and acn2.idt_programa = ac.idt_programa';
                    $sql .= ' where ac.ws_sg_idsubarea is not null';
                    $rst = execsql($sql, false);
                    $rowt = $rst->data[0];

                    $idarea = $rowt['ws_sg_idarea'];
                    $idsubarea = $rowt['ws_sg_idsubarea'];

                    if ($idarea == '') {
                        $vetErroDemanda[] = 'A Área de Conhecimento associado ao Produto não tem a informação da IDAREA do SebraeTec Nacional!';
                    }

                    if ($idsubarea == '') {
                        $vetErroDemanda[] = 'A Área de Conhecimento associado ao Produto não tem a informação da IDSUBAREA do SebraeTec Nacional!';
                    }

                    $ZPLANOTRABALHOCONSULTORSGCTEC = Array();
                    $ZPLANOTRABALHOCRONOGRAMASGCTEC = Array();

                    $sql = '';
                    $sql .= ' select ea.cod_atividade, max(ag.atividade) as atividade, max(ag.codigo) as codigo, avg(ag.valor_hora) as valor_hora,';
                    $sql .= ' sum(ag.carga_horaria) as carga_horaria, min(ag.data_inicial) as data_inicial, max(ag.data_final) as data_final';
                    $sql .= ' from grc_evento_atividade ea';
                    $sql .= ' inner join grc_evento_agenda ag on ag.idt_evento_atividade = ea.idt';
                    $sql .= ' where ea.idt_atendimento = ' . null($rowe['idt_atendimento']);
                    $sql .= ' group by ea.cod_atividade';
                    $sql .= ' order by data_inicial, data_final';
                    $rst = execsql($sql, false);

                    foreach ($rst->data as $rowt) {
                        if ($rowt['codigo'] == '') {
                            $rowt['codigo'] = substr($rowt['atividade'], 0, 150);
                        }

                        $ZPLANOTRABALHOCONSULTORSGCTEC[] = Array(
                            'CPFCONSULTOR' => $rowCI['cpf'],
                            'CNPJPRESTADORA' => $cnpjprestadora,
                            'VALORHORA' => $rowt['valor_hora'],
                            'RESPONSAVEL' => 'false',
                            'HORASEXECUTADAS' => (int) $rowt['carga_horaria'],
                        );

                        $ZPLANOTRABALHOCRONOGRAMASGCTEC[] = Array(
                            'CPFCONSULTOR' => $rowCI['cpf'],
                            'CNPJPRESTADORA' => $cnpjprestadora,
                            'ATIVIDADE' => $rowt['atividade'],
                            'DATAINICIO' => $rowt['data_inicial'],
                            'DATAFINAL' => $rowt['data_final'],
                            'SITUACAO' => 1,
                            'HORASEXECUTADAS' => (int) $rowt['carga_horaria'],
                            'ATIVIDADECRITICA' => 'false',
                            'NOMEATIVIDADE' => $rowt['codigo'],
                            'ATIVIDADECONCLUIDA' => 'true',
                        );
                    }

                    $sql = '';
                    $sql .= ' select max(f.numero_de_parcelas) as numparcelas, min(p.data_pagamento) as dataprimeiropagamento, sum(p.valor_pagamento) as valortotal,';
                    $sql .= " group_concat(distinct n.descricao order by n.descricao separator ';') as formadepagamento";
                    $sql .= ' from grc_evento_participante_pagamento p';
                    $sql .= ' left outer join grc_evento_forma_parcelamento f on f.idt = p.idt_evento_forma_parcelamento';
                    $sql .= ' left outer join grc_evento_natureza_pagamento n on n.idt = p.idt_evento_natureza_pagamento';
                    $sql .= ' where p.idt_atendimento = ' . null($rowe['idt_atendimento']);
                    $sql .= " and (p.estornado <> 'S' or p.estornar_rm = 'S')";
                    $sql .= " and p.operacao = 'C'";
                    $rst = execsql($sql, false);
                    $row_pag = $rst->data[0];

                    if ($rowe['contrapartida_sgtec'] == '') {
                        $valorcontrapartidasebraeuf = $vl_cotacao - $row_pag['valortotal'];
                    } else {
                        $valorcontrapartidasebraeuf = 0;
                    }

                    $percentualcontrapartida = $row_pag['valortotal'] / $vl_cotacao * 100;
                    $percentualcontrapartidacliente = 100 - $percentualcontrapartida;

                    $sql = '';
                    $sql .= ' select min(data_inicial) as dataprimeiropagamento';
                    $sql .= ' from grc_evento_agenda';
                    $sql .= ' where idt_atendimento = ' . null($rowe['idt_atendimento']);
                    $rst = execsql($sql, false);
                    $rowt = $rst->data[0];

                    $dataprimeiropagamento = trata_data(Calendario::Intervalo_Util(trata_data($rowt['dataprimeiropagamento']), 15));

                    $sql = '';
                    $sql .= ' select count(idt) as numparcelas';
                    $sql .= ' from grc_evento_atividade';
                    $sql .= ' where idt_atendimento = ' . null($rowe['idt_atendimento']);
                    $rst = execsql($sql, false);
                    $rowt = $rst->data[0];

                    $numparcelas = $rowt['numparcelas'];

                    $registro = Array();

                    $registro['ZPROJETOSGCTEC'] = Array(
                        'NOMEPROJETO' => $rowe['nomeprojeto'],
                        'DEMANDA' => $rowe['demanda'],
                        'CPFRESPONSAVELDEMANDA' => $rowe['cpfresponsaveldemanda'],
                        'SITUACAO' => 6,
                        'DATACADASTRO' => $rowe['datacadastro'],
                        'DATAMUDSITUACAO' => $rowe['datamudsituacao'],
                        'DATAINICIO' => $rowe['datainicio'],
                        'DATAFIM' => $rowe['datafim'],
                        'VALORTOTAL' => $rowe['valortotal'],
                        'ZUSUARIOADMSGCTEC' => Array(
                            'NOME' => $rowe['usumsg_nome'],
                            'CPF' => $rowe['usumsg_cpf'],
                            'EMAIL' => $rowe['usumsg_email'],
                            'UF' => $sebraeuf,
                        ),
                        'ZPROJETOSETORECONOMICOSGCTEC' => Array(
                            'IDSETORECONOMICO' => $rowe['idsetoreconomico'],
                        ),
                        'ZPROJETODADOSORCAMENTARIOSGCTEC' => Array(
                            'IDPROJETOORCAMENTARIO' => $idprojetoorcamentario,
                            'IDACAO' => $idacao,
                        ),
                        'ZPROJETOCARACTERISTICASGCTEC' => Array(
                            'IDMODALIDADE' => $rowe['idmodalidade'],
                            'IDPRODUTO' => $rowe['idproduto'],
                            'IDAREA' => $idarea,
                        ),
                        'ZPROJETOCARACTERISTICASUBAREASGCTEC' => Array(
                            'IDSUBAREA' => $idsubarea,
                            'NATUREZA' => $rowe['natureza'],
                        ),
                        'ZPROJETOPRESTADORASGCTEC' => Array(
                            'CNPJPRESTADORA' => $cnpjprestadora,
                            'SITUACAO' => 6,
                            'DATAENVIO' => $rowe['dataenvio'],
                        ),
                        'ZPROJETOEMPRESASGCTEC' => Array(
                            'IDENTIFICACAOEMPRESA' => $identificacaoempresa,
                            'VALORARRECADADO' => $rowe['valorarrecadado'],
                            'PODEEXCLUIR' => 'false',
                            'PARTICIPOUDEMANDA' => 'false',
                        ),
                        'ZEMPRESASGCTEC' => Array(
                            'RAZAOSOCIAL' => $rowe['cl_razaosocial'],
                            'CNPJ' => $rowe['cl_cnpj'],
                            'NOMEFANTASIA' => $rowe['cl_nomefantasia'],
                            'EMAIL' => $rowe['cl_email'],
                            'CEP' => $rowe['cl_cep'],
                            'IDPAIS' => $rowe['cl_idpais'],
                            'IDESTADO' => $rowe['cl_idestado'],
                            'IDCIDADE' => $rowe['cl_idcidade'],
                            'IDBAIRRO' => $rowe['cl_idbairro'],
                            'LOGRADOURO' => $rowe['cl_logradouro'],
                            'NUMERO' => $rowe['cl_numero'],
                            'COMPLEMENTO' => $rowe['cl_complemento'],
                            'CONTATO' => $rowe['cl_contato'],
                            'CPF' => $rowe['cl_cpf'],
                            'PRODUTORRURAL' => $rowe['cl_produtorrural'],
                            'CODPRODUTORRURAL' => $codprodutorrural,
                            'DAP' => $rowe['cl_dap'],
                            'CODPESCADOR' => $rowe['cl_rmp'],
                            'NIRF' => $rowe['cl_nirf'],
                            'CODFATURAMENTO' => $rowe['cl_codfaturamento'],
                            'CNAE' => $rowe['cl_cnae'],
                        ),
                        'ZCONSULTORSGCTEC' => Array(
                            'CPF' => $rowCI['cpf'],
                            'NOME' => $rowCI['nome'],
                            'EMAIL' => $rowCI['email'],
                            'CEP' => $rowCI['cep'],
                            'IDPAIS' => $rowCI['idpais'],
                            'IDESTADO' => $rowCI['idestado'],
                            'ESTADO' => $rowCI['estado'],
                            'IDCIDADE' => $rowCI['idcidade'],
                            'IDBAIRRO' => $rowCI['idbairro'],
                            'LOGRADOURO' => $rowCI['logradouro'],
                            'NUMERO' => $rowCI['numero'],
                            'SEXO' => $rowCI['sexo'],
                            'IDESCOLARIDADE' => $rowCI['idescolaridade'],
                            'FORMACAO' => $rowCI['formacao'],
                        ),
                        'ZPLANOTRABALHOCONSULTORSGCTEC' => $ZPLANOTRABALHOCONSULTORSGCTEC,
                        'ZPLANOTRABALHOCRONOGRAMASGCTEC' => $ZPLANOTRABALHOCRONOGRAMASGCTEC,
                        'ZPLANOTRABALHOFINANCEIROAPAGARSGCTEC' => Array(
                            'CNPJPRESTADORA' => $cnpjprestadora,
                            'IDENTIFICACAOEMPRESA' => $identificacaoempresa,
                            'PERCENTUALCONTRAPARTIDA' => $percentualcontrapartida,
                            'NUMPARCELAS' => $row_pag['numparcelas'],
                            'DATAPRIMEIROPAGAMENTO' => $row_pag['dataprimeiropagamento'],
                            'FORMADEPAGAMENTO' => $row_pag['formadepagamento'],
                            'VALORTOTAL' => $row_pag['valortotal'],
                            'VALORCONTRAPARTIDASEBRAEUF' => $valorcontrapartidasebraeuf,
                            'VALORTOTALDESPESAS' => $vl_cotacao,
                            'PERCENTUALCONTRAPARTIDACLIENTE' => $percentualcontrapartidacliente,
                            'PERCENTUALCONTRAPARTIDANA' => $percentualcontrapartida,
                        ),
                        'ZPLANOTRABALHOFINANCEIROARECEBERSGCTEC' => Array(
                            'CNPJPRESTADORA' => $cnpjprestadora,
                            'PERCENTUALSINAL' => '0',
                            'DATAPRIMEIROPAGAMENTO' => $dataprimeiropagamento,
                            'NUMPARCELAS' => $numparcelas,
                            'VALORTOTAL' => $vl_cotacao,
                            'DATARESTANTEPAGAMENTO' => $dataprimeiropagamento,
                            'VALORSINAL' => '0',
                        ),
                    );

                    if (count($vetErroDemanda) == 0) {
                        $funcao = 'IncluiDemanda';
                        $Z = Array('ZPROJETOSGCTEC');

                        $SebraeTEC = new SoapSebraeTEC();
                        $iddemanda = $SebraeTEC->save($funcao, $Z, $registro, true);

                        if (!is_numeric($iddemanda)) {
                            $qtdErro++;
                            $erro = 'ERRO DO WS: [' . $funcao . '] ' . $iddemanda;

                            $inf_extra = Array(
                                'rowe' => $rowe,
                                'funcao' => $funcao,
                                'registro' => $registro,
                                'xml' => $SebraeTEC->xml(),
                            );

                            $vetErro[] = $erro;
                            $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ' - ' . $rowe['idt_atendimento_pessoa'] . ')', 'sincroniza_ws_sg', $inf_extra);

                            $sql = 'update grc_atendimento_pessoa set ws_sg_dt_cadastro = now(),';
                            $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                            $sql .= ' ws_sg_erro = ' . aspa($erro);
                            $sql .= ' where idt = ' . null($rowe['idt_atendimento_pessoa']);
                            execsql($sql, false);
                        }
                    } else {
                        $qtdErro++;
                        $erro = implode(nl(), $vetErroDemanda);

                        $inf_extra = Array(
                            'rowe' => $rowe,
                            'registro' => $registro,
                        );

                        $vetErro[] = $erro;
                        $ws_sg_idt_erro_log = erro_try($erro . ' (' . $rowe['idt_evento'] . ' - ' . $rowe['idt_atendimento_pessoa'] . ')', 'sincroniza_ws_sg', $inf_extra);

                        $sql = 'update grc_atendimento_pessoa set ws_sg_dt_cadastro = now(),';
                        $sql .= ' ws_sg_idt_erro_log = ' . null($ws_sg_idt_erro_log) . ',';
                        $sql .= ' ws_sg_erro = ' . aspa($erro);
                        $sql .= ' where idt = ' . null($rowe['idt_atendimento_pessoa']);
                        execsql($sql, false);
                    }
                }

                if (is_numeric($iddemanda)) {
                    $sql = 'update grc_atendimento_pessoa set ws_sg_dt_cadastro = now(),';
                    $sql .= ' ws_sg_iddemanda = ' . null($iddemanda) . ',';
                    $sql .= ' ws_sg_idt_erro_log = null,';
                    $sql .= ' ws_sg_erro = null';
                    $sql .= ' where idt = ' . null($rowe['idt_atendimento_pessoa']);
                    execsql($sql, false);

                    $inf_extra = Array(
                        'rowe' => $rowe,
                        'funcao' => $funcao,
                        'registro' => $registro,
                        'xml' => $SebraeTEC->xml(),
                    );

                    grava_log_sis('grc_atendimento_pessoa', 'R', $rowe['idt_atendimento_pessoa'], '[' . $rowe['codigo'] . '] Demanda: ' . $iddemanda, 'WS Sebraetec Nacional', $inf_extra);
                }
            }
        } catch (PDOException $e) {
            $qtdErro++;

            $inf_extra = Array(
                'rowe' => $rowe,
                'sql' => $sql,
            );

            $vetErro[] = grava_erro_log('sincroniza_ws_sg', $e, $inf_extra);
        } catch (Exception $e) {
            $qtdErro++;
            $vetErro[] = grava_erro_log('sincroniza_ws_sg', $e, $rowe);
        }
    }
}

if ($qtdErro == 0) {
    echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. EXECUTADA COM SUCESSO!';
} else {
    echo 'FIM DA EXECUÇÃO DA ROTINA DE SINCONIZAÇÃO. OCORREU ' . $qtdErro . ' ERROS NA ROTINA.CONSULTAR LOG DE ERROS!';
}