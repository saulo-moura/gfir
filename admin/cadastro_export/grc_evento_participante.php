<?php
$idt_evento = $_GET['idCad'];

$sql = '';
$sql .= ' select idt_atendimento';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt = ' . null($_GET['id']);
$rs = execsql($sql);
$idt_atendimento = $rs->data[0][0];

if ($_GET['veio'] == 'SG') {
    $vetParametroDesc = Array(
        '#numero_evento#' => 'Nº DO EVENTO',
        '#cnpj_equivalente#' => 'CNPJ ou equivalente',
        '#razao_social#' => 'Razão Social',
        '#nome_fantasia#' => 'Nome Fantasia',
        '#telefone#' => 'Telefone',
        '#celular#' => 'Celular',
        '#nome_responsavel#' => 'Nome do Responsável',
        '#cpf#' => 'CPF',
        '#email#' => 'E-mail',
        '#endereco#' => 'Endereço',
        '#complemento#' => 'Complemento',
        '#bairro#' => 'Bairro',
        '#cidade#' => 'Cidade',
        '#cep#' => 'Cep',
        '#produto#' => 'Produto',
        '#data_prevista_inicio#' => 'Data Prevista de Início',
        '#data_prevista_termino#' => 'Data Prevista de Término',
        '#tipo_servico#' => 'Tipo de Serviço',
        '#necessidade_cliente#' => 'Necessidade do Cliente',
        '#resultados_esperados#' => 'Resultados Esperados',
        '#entregas#' => 'Entregas',
        '#valor_servico#' => 'Valor Serviço:',
        '#pagante#' => 'Lista de Pagentes',
        '#cidade_assinatura#' => 'Cidade Assinatura',
        '#data_assinatura#' => 'Data Assinatura',
        '#mes_assinatura#' => 'Mes Assinatura',
        '#ano_assinatura#' => 'Ano Assinatura',
        '#diretor_superintendente#' => 'Diretor Superintendente',
        '#diretor_atendimento#' => 'Diretor de Atendimento',
        '#url_sebrae#' => 'URL do sistema GRC',
    );

    $vetParametro = array_map(create_function('', ''), $vetParametroDesc);

    //Dados do Evento
    $sql = '';
    $sql .= ' select e.codigo, e.descricao, e.dt_previsao_inicial, e.dt_previsao_fim, i.descricao as instrumento, e.objetivo, e.resultado_esperado, cid.desccid as sebrae_cidade';
    $sql .= ' from ' . db_pir_grc . 'grc_evento e';
    $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
    $sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#numero_evento#'] = $row['codigo'];
    $vetParametro['#produto#'] = $row['descricao'];
    $vetParametro['#data_prevista_inicio#'] = trata_data($row['dt_previsao_inicial']);
    $vetParametro['#data_prevista_termino#'] = trata_data($row['dt_previsao_fim']);
    $vetParametro['#tipo_servico#'] = $row['instrumento'];
    $vetParametro['#necessidade_cliente#'] = $row['objetivo'];
    $vetParametro['#resultados_esperados#'] = $row['resultado_esperado'];
    $vetParametro['#cidade_assinatura#'] = $row['sebrae_cidade'];

    //Dados da Pessoa Representante (LIDER)
    $sql = '';
    $sql .= ' select nome, cpf';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= " where tipo_relacao = 'L'";
    $sql .= ' and idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#nome_responsavel#'] = $row['nome'];
    $vetParametro['#cpf#'] = $row['cpf'];

    //Dados da Empreendimento
    $sql = '';
    $sql .= ' select nome_fantasia, razao_social, logradouro_cidade_e, logradouro_bairro_e, logradouro_complemento_e,';
    $sql .= ' logradouro_cep_e, telefone_comercial_e as telefone, telefone_celular_e as celular, cnpj,';
    $sql .= ' email_e, logradouro_endereco_e, logradouro_numero_e';
    $sql .= ' from grc_atendimento_organizacao o';
    $sql .= " where representa = 'S'";
    $sql .= " and desvincular = 'N'";
    $sql .= ' and idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#cnpj_equivalente#'] = $row['cnpj'];
    $vetParametro['#razao_social#'] = $row['razao_social'];
    $vetParametro['#nome_fantasia#'] = $row['nome_fantasia'];
    $vetParametro['#telefone#'] = $row['telefone'];
    $vetParametro['#celular#'] = $row['celular'];
    $vetParametro['#email#'] = $row['email_e'];
    $vetParametro['#endereco#'] = $row['logradouro_endereco_e'] . ' ' . $row['logradouro_numero_e'];
    $vetParametro['#complemento#'] = $row['logradouro_complemento_e'];
    $vetParametro['#bairro#'] = $row['logradouro_bairro_e'];
    $vetParametro['#cidade#'] = $row['logradouro_cidade_e'];
    $vetParametro['#cep#'] = $row['logradouro_cep_e'];

    //Pagamento
    $sql = '';
    $sql .= ' select sum(p.valor_pagamento) as pag';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_pagamento p';
    $sql .= ' where p.idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' and p.idt_aditivo_participante is null';
    $sql .= " and (p.estornado is null or p.estornado <> 'S')";
    $sql .= " and (p.operacao is null or p.operacao = 'C')";
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];

    $vetParametro['#valor_servico#'] = format_decimal($row['pag']);

    $sql = '';
    $sql .= ' select p.par_razao_social, sum(p.valor_pagamento) as pag';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_pagamento p';
    $sql .= ' where p.idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and (p.estornado is null or p.estornado <> 'S')";
    $sql .= " and (p.operacao is null or p.operacao = 'C')";
    $sql .= ' group by p.par_razao_social';
    $sql .= ' order by p.par_razao_social';
    $rs = execsql($sql, $trata_erro);

    $pagante = Array();

    foreach ($rs->data as $row) {
        $razao_social = $row['par_razao_social'];

        if ($razao_social == '') {
            $razao_social = $vetParametro['#razao_social#'];
        }

        $pagante[] = 'A ' . $razao_social . ' a importância de R$ ' . format_decimal($row['pag']);
    }

    if (count($pagante) == 0) {
        $vetParametro['#pagante#'] = '';
    } else {
        $vetParametro['#pagante#'] = implode(';<br />', $pagante) . '.';
    }

    //Contrato
    $sql = '';
    $sql .= ' select dt_contrato';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_contrato p';
    $sql .= ' where p.idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and p.dt_cancelamento is null";
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];
    $dt = trata_data($row['dt_contrato']);

    if ($dt == '') {
        $dt = Date('d/m/Y');
    }

    $dt = DatetoArray($dt);

    $vetMes = Array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
    );

    $vetParametro['#data_assinatura#'] = $dt['dia'];
    $vetParametro['#mes_assinatura#'] = $vetMes[$dt['mes']];
    $vetParametro['#ano_assinatura#'] = $dt['ano'];


    //Parametros
    $sql = "select * from " . db_pir_grc . "plu_config";
    $sql .= " where variavel in ('grc_evento_participante_superintendente', 'grc_evento_participante_atendimento')";
    $rs = execsql($sql);

    $vetPar = Array();

    ForEach ($rs->data as $row) {
        $vetPar[$row['variavel']] = trim($row['valor'] . ($row['extra'] == '' ? '' : ' ' . $row['extra']));
    }

    $vetParametro['#diretor_superintendente#'] = $vetPar['grc_evento_participante_superintendente'];
    $vetParametro['#diretor_atendimento#'] = $vetPar['grc_evento_participante_atendimento'];

    //Entregas
    $entregas = '';
    $entregas .= '<table class="bordasimples">';
    $entregas .= '<tr style="background:#4f81bd; color: white; font-weight: bold; text-align: center;">';
    $entregas .= '<td>ENTREGAS</td>';
    $entregas .= '<td>DOCUMENTOS(S) - EVIDÊNCIAS</td>';
    $entregas .= '<td>PERCENTUAL</td>';
    $entregas .= '</tr>';

    $sql = '';
    $sql .= ' select ee.descricao, ee.percentual,';
    $sql .= " group_concat(distinct concat_ws(' ', eed.codigo, d.descricao) order by eed.codigo, d.descricao separator '<br />') as evidencia";
    $sql .= ' from ' . db_pir_grc . 'grc_evento_entrega ee';
    $sql .= " left outer join " . db_pir_grc . "grc_evento_entrega_documento eed on eed.idt_evento_entrega = ee.idt";
    $sql .= " left outer join " . db_pir_gec . "gec_documento d on d.idt = eed.idt_documento";
    $sql .= ' where ee.idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' group by ee.descricao, ee.percentual';
    $sql .= ' order by ee.ordem';
    $rs = execsql($sql);

    ForEach ($rs->data as $row) {
        $entregas .= '<tr>';
        $entregas .= '<td>' . $row['descricao'] . '</td>';
        $entregas .= '<td>' . $row['evidencia'] . '</td>';
        $entregas .= '<td>' . format_decimal($row['percentual']) . '%</td>';
        $entregas .= '</tr>';
    }

    $entregas .= '</table>';

    $vetParametro['#entregas#'] = $entregas;

    //Dados da Devolução
    $entregas = '';
    $devolucao .= '<table class="bordasimples">';
    $devolucao .= '<tr style="background:#4f81bd; color: white; font-weight: bold; text-align: center;">';
    $devolucao .= '<td>FAVORECIDO</td>';
    $devolucao .= '<td>BANCO</td>';
    $devolucao .= '<td>AGÊNCIA</td>';
    $devolucao .= '<td>CONTA CORRENTE</td>';
    $devolucao .= '</tr>';

    $sql = '';
    $sql .= " select cd.*, concat_ws('-', cd.agencia_numero, cd.agencia_digito) as agencia, concat_ws('-', cd.cc_numero, cd.cc_digito) as cc,";
    $sql .= " concat_ws(' - ', cd.cpfcnpj, cd.razao_social) as favorecido";
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_contadevolucao cd';
    $sql .= ' where cd.idt_atendimento = ' . null($idt_atendimento);
    $sql .= " and cd.reg_origem = 'MA'";
    $sql .= ' order by cd.cpfcnpj, cd.razao_social';
    $rs = execsql($sql);

    ForEach ($rs->data as $row) {
        $devolucao .= '<tr>';
        $devolucao .= '<td>' . $row['favorecido'] . '</td>';
        $devolucao .= '<td>' . $row['banco_nome'] . '</td>';
        $devolucao .= '<td>' . $row['agencia'] . '</td>';
        $devolucao .= '<td>' . $row['cc'] . '</td>';
        $devolucao .= '</tr>';
    }

    $devolucao .= '</table>';

    $vetParametro['#devolucao#'] = $devolucao;

    $vetParametro['#url_sebrae#'] = 'http://127.0.0.1/';

    //Gerando PDF
    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_sg_cab'";
    $rs = execsql($sql);
    $header = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_sg_rod'";
    $rs = execsql($sql);
    $footer = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_sg_cont'";
    $rs = execsql($sql);
    $htmlPDF = $rs->data[0][0];
} else {
    $vetParametroDesc = Array(
        '#sebrae_nome#' => 'Nome do SEBRAE/UF da Oportunidade',
        '#sebrae_cidade#' => 'Cidade-SEBRAE/UF da Oportunidade',
        '#sebrae_estado#' => 'Estado-SEBRAE/UF da Oportunidad',
        '#sebrae_bairro#' => 'Bairro-SEBRAE/UF da Oportunidade',
        '#sebrae_cnpj#' => 'CNPJ-SEBRAE/UF da Oportunidade',
        '#sebrae_ie#' => 'I.E-SEBRAE/UF da Oportunidade',
        '#evento_nome#' => 'Nome da Turma por Produto de Interesse da Oportunidade',
        '#evento_min_pag#' => 'Número Mínimo de Participantes do Produto por Produto de Interesse da Oportunidade',
        '#evento_vagas#' => 'Total de Inscrição por Produto de Interesse da Oportunidade',
        '#evento_freq#' => 'Frequência mínima do Produto de Interesse da Oportunidade',
        '#representante_nome#' => 'Pessoa Física-Oportunidade',
        '#representante_cidade#' => 'Cidade-Pessoa Física da Oportunidade',
        '#representante_estado#' => 'Estado-Pessoa Física da Oportunidade',
        '#representante_bairro#' => 'Bairro-Pessoa Física da Oportunidade',
        '#representante_cep#' => 'CEP -Pessoa Jurídica da Oportunidade',
        '#representante_telefone#' => 'Telefone Comercial ou Celular Principal -Pessoa Jurídica da Oportunidade',
        '#representante_cpf#' => 'CPF-Pessoa Física da Oportunidade',
        '#empresa_nome#' => 'Pessoa Jurídica - Oportunidade',
        '#empresa_cidade#' => 'Cidade-Pessoa Jurídica da Oportunidade',
        '#empresa_estado#' => 'Estado-Pessoa Jurídica da Oportunidade',
        '#empresa_bairro#' => 'Bairro-Pessoa Jurídica da Oportunidade',
        '#empresa_cep#' => 'CEP -Pessoa Jurídica da Oportunidade',
        '#empresa_telefone#' => 'Telefone Comercial ou Celular Principal -Pessoa Jurídica da Oportunidade',
        '#empresa_cnpj#' => 'CNPJ--Pessoa Jurídica da Oportunidade',
        '#agenda_data#' => 'Data da Realização da Turma por Produto de Interesse da Oportunidade',
        '#agenda_local#' => 'Local de Realização da Turma por Produto de Interesse da Oportunidade',
        '#pagamento_tot#' => 'Valor total da Oportunidade',
        '#pagamento_desc#' => 'descrição em reais do Valor total da Oportunidade',
        '#pagamento_forma#' => 'Forma de Pagamento da Condição de Pagamento da Oportunidade',
        '#pagamento_porc#' => 'Porcentagem Pagamento da Condição de Pagamento da Oportunidade',
        '#pagamento_valor#' => 'Valor de Pagamento da Condição de Pagamento da Oportunidade',
        '#insc_nome#' => 'Nome completo dos Inscritos por Produto de Interesse da Oportunidade',
        '#dt_atual#' => 'Data Atual',
        '#n+dt_atual#' => 'Data Atual + 360 dias',
        '#hoje#' => 'Preencher com data, mês e ano da data corrente',
    );

    $vetParametro = array_map(create_function('', ''), $vetParametroDesc);

    //Dados do Evento
    $sql = '';
    $sql .= ' select u.descricao as sebrae_nome, cid.desccid as sebrae_cidade, est.descest as sebrae_estado, bai.descbairro as sebrae_bairro,';
    $sql .= " u.cnpj as sebrae_cnpj, null as sebrae_ie, concat_ws(' - ', e.codigo, e.descricao) as evento_nome, e.qtd_minima_pagantes as evento_min_pag,";
    $sql .= ' e.quantidade_participante as evento_vagas, e.frequencia_min as evento_freq';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
    $sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
    $sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = u.logradouro_codest';
    $sql .= ' left outer join ' . db_pir_siac . 'bairro bai on bai.codbairro = u.logradouro_codbairro';
    $sql .= ' where e.idt = ' . null($idt_evento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#sebrae_nome#'] = $row['sebrae_nome'];
    $vetParametro['#sebrae_cidade#'] = $row['sebrae_cidade'];
    $vetParametro['#sebrae_estado#'] = $row['sebrae_estado'];
    $vetParametro['#sebrae_bairro#'] = $row['sebrae_bairro'];
    $vetParametro['#sebrae_cnpj#'] = $row['sebrae_cnpj'];
    $vetParametro['#sebrae_ie#'] = $row['sebrae_ie'];

    $vetParametro['#evento_nome#'] = $row['evento_nome'];
    $vetParametro['#evento_min_pag#'] = $row['evento_min_pag'];
    $vetParametro['#evento_vagas#'] = $row['evento_vagas'];
    $vetParametro['#evento_freq#'] = $row['evento_freq'];

    //Dados da Pessoa Representante (LIDER)
    $sql = '';
    $sql .= ' select nome as representante_nome, logradouro_cidade as representante_cidade, logradouro_estado as representante_estado, logradouro_bairro as representante_bairro,';
    $sql .= ' logradouro_cep as representante_cep, coalesce(telefone_celular, telefone_recado, telefone_residencial) as representante_telefone, cpf as representante_cpf,';
    $sql .= ' representa_empresa';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= " where tipo_relacao = 'L'";
    $sql .= ' and idt_atendimento = ' . null($idt_atendimento);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#representante_nome#'] = $row['representante_nome'];
    $vetParametro['#representante_cidade#'] = $row['representante_cidade'];
    $vetParametro['#representante_estado#'] = $row['representante_estado'];
    $vetParametro['#representante_bairro#'] = $row['representante_bairro'];
    $vetParametro['#representante_cep#'] = $row['representante_cep'];
    $vetParametro['#representante_telefone#'] = $row['representante_telefone'];
    $vetParametro['#representante_cpf#'] = $row['representante_cpf'];

    //Dados da Empreendimento
    $tem_empresa = false;

    if ($row['representa_empresa'] == 'S') {
        $sql = '';
        $sql .= ' select razao_social as empresa_nome, logradouro_cidade_e as empresa_cidade, logradouro_estado_e as empresa_estado, logradouro_bairro_e as empresa_bairro,';
        $sql .= ' logradouro_cep_e as empresa_cep, coalesce(telefone_comercial_e, telefone_celular_e) as empresa_telefone, cnpj as empresa_cnpj';
        $sql .= ' from grc_atendimento_organizacao o';
        $sql .= " where representa = 'S'";
        $sql .= " and desvincular = 'N'";
        $sql .= ' and idt_atendimento = ' . null($idt_atendimento);
        $rs = execsql($sql);

        if ($rs->rows > 0) {
            $tem_empresa = true;
            $row = $rs->data[0];

            $vetParametro['#empresa_nome#'] = $row['empresa_nome'];
            $vetParametro['#empresa_cidade#'] = $row['empresa_cidade'];
            $vetParametro['#empresa_estado#'] = $row['empresa_estado'];
            $vetParametro['#empresa_bairro#'] = $row['empresa_bairro'];
            $vetParametro['#empresa_cep#'] = $row['empresa_cep'];
            $vetParametro['#empresa_telefone#'] = $row['empresa_telefone'];
            $vetParametro['#empresa_cnpj#'] = $row['empresa_cnpj'];
        }
    }

    if (!$tem_empresa) {
        $vetParametro['#empresa_nome#'] = $vetParametro['#representante_nome#'];
        $vetParametro['#empresa_cidade#'] = $vetParametro['#representante_cidade#'];
        $vetParametro['#empresa_estado#'] = $vetParametro['#representante_estado#'];
        $vetParametro['#empresa_bairro#'] = $vetParametro['#representante_bairro#'];
        $vetParametro['#empresa_cep#'] = $vetParametro['#representante_cep#'];
        $vetParametro['#empresa_telefone#'] = $vetParametro['#representante_telefone#'];
        $vetParametro['#empresa_cnpj#'] = $vetParametro['#representante_cpf#'];
    }

    //Dados da Agenda
    $sql = '';
    $sql .= ' select ea.data_inicial, c.desccid as cidade, l.descricao as local';
    $sql .= ' from grc_evento_agenda ea';
    $sql .= " inner join " . db_pir_siac . "cidade c on c.codcid = ea.idt_cidade";
    $sql .= " inner join grc_evento_local_pa l on l.idt = ea.idt_local";
    $sql .= ' where idt_evento = ' . null($idt_evento);
    $sql .= ' order by ea.dt_ini, ea.dt_fim';
    $rs = execsql($sql);

    $vetAgenda_data = Array();
    $vetAgenda_local = Array();

    foreach ($rs->data as $row) {
        $data = trata_data($row['data_inicial']);
        $local = $row['local'] . ' - ' . $row['cidade'];

        $vetAgenda_data[$data] = $data;
        $vetAgenda_local[$local] = $local;
    }

    $vetParametro['#agenda_data#'] = implode('<br />', $vetAgenda_data);
    $vetParametro['#agenda_local#'] = implode('<br />', $vetAgenda_local);

    //Dados do Pagamento
    $sql = '';
    $sql .= " select pp.valor_pagamento, np.descricao as forma, fp.codigo as parcela";
    $sql .= " from grc_evento_participante_pagamento pp";
    $sql .= ' left outer join grc_evento_natureza_pagamento np on np.idt = pp.idt_evento_natureza_pagamento';
    $sql .= ' left outer join grc_evento_forma_parcelamento fp on fp.idt = pp.idt_evento_forma_parcelamento';
    $sql .= ' where pp.idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' and pp.idt_aditivo_participante is null';
    $sql .= " and pp.estornado <> 'S'";
    $sql .= " and pp.operacao = 'C'";
    $sql .= ' order by pp.data_pagamento';
    $rs = execsql($sql);
    $row = $rs->data[0];

    $tot = 0;

    foreach ($rs->data as $row) {
        $tot += $row['valor_pagamento'];
    }

    $vetPagamento_forma = Array();
    $vetPagamento_porc = Array();
    $vetPagamento_valor = Array();

    foreach ($rs->data as $row) {
        $forma = $row['forma'] . ' - ' . $row['parcela'];
        $porc = $row['valor_pagamento'] * 100 / $tot;

        $vetPagamento_forma[] = $forma;
        $vetPagamento_porc[] = format_decimal($porc);
        $vetPagamento_valor[] = format_decimal($row['valor_pagamento']);
    }

    $tot = format_decimal($tot);
    $vetParametro['#pagamento_tot#'] = $tot;
    $vetParametro['#pagamento_desc#'] = clsTexto::valorPorExtenso($tot);
    $vetParametro['#pagamento_forma#'] = implode('<br />', $vetPagamento_forma);
    $vetParametro['#pagamento_porc#'] = implode('<br />', $vetPagamento_porc);
    $vetParametro['#pagamento_valor#'] = implode('<br />', $vetPagamento_valor);

    //Inscritos
    $sql = '';
    $sql .= ' select nome';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= ' where idt_atendimento = ' . null($idt_atendimento);
    $sql .= ' order by nome';
    $rs = execsql($sql);

    $vetInsc_nome = Array();

    foreach ($rs->data as $row) {
        $vetInsc_nome[] = $row['nome'];
    }

    $vetParametro['#insc_nome#'] = implode('<br />', $vetInsc_nome);

    $vetParametro['#dt_atual#'] = Date('d/m/Y');
    $vetParametro['#n+dt_atual#'] = Date('d/m/Y', strtotime('+360 day'));
    $vetParametro['#hoje#'] = Date('d/m/Y');

    //Gerando PDF
    $mpdf->SetColumns(2, 'justify');

    if ($_GET['titulo_rel'] == 'R') {
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->SetWatermarkText('RASCUNHO DO CONTRATO', 0.1);
    }

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_cab'";
    $rs = execsql($sql);
    $header = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_rod'";
    $rs = execsql($sql);
    $footer = $rs->data[0][0];

    $sql = '';
    $sql .= ' select detalhe';
    $sql .= ' from grc_parametros';
    $sql .= " where codigo = 'evento_modelo_contrato_cont'";
    $rs = execsql($sql);
    $htmlPDF = $rs->data[0][0];

    /* Armenge para a falta da IE */
    if ($vetParametro['#sebrae_ie#'] == '') {
        $htmlPDF = str_replace(', Inscrição Estadual nº #sebrae_ie#', '', $htmlPDF);
    }
}

foreach ($vetParametro as $key => $value) {
    $header = str_replace($key, $value, $header);
    $footer = str_replace($key, $value, $footer);
    $htmlPDF = str_replace($key, $value, $htmlPDF);
}

$header = utf8_encode($header);
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($header, 'E');

$footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footer, 'E');

$return = $vetParametro;
echo $htmlPDF;
