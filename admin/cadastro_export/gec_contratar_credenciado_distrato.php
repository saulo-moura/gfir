<?php
$vetParametroDesc = Array(
    '#numero_evento#' => 'Nº DO EVENTO',
    '#numero_distrato#' => 'Nº DISTRATO',
    '#cliente_razaosocial#' => 'NOME DA EMPRESA BENEFICIADA',
    '#cliente_endereco#' => 'ENDEREÇO DA EMPRESA',
    '#cliente_cnpj#' => 'CNPJ',
    '#cliente_repesentante#' => 'Nome Cliente',
    '#cliente_repesentante_rg#' => 'RG',
    '#cliente_repesentante_orgao_expedidor#' => 'ORGÃO EXPEDIDOR',
    '#cliente_repesentante_cpf#' => 'CPF',
    '#pst_razaosocial#' => 'PST',
    '#pst_endereço#' => 'Endereço',
    '#pst_cnpj#' => 'CNPJ 2',
    '#pst_repesentante#' => 'Pessoa física que fez a contratação',
    '#pst_repesentante_rg#' => 'RG',
    '#pst_repesentante_cpf#' => 'CPF',
    '#codigo_contratacao#' => 'Código de contratação',
    '#data_assinatura_contrato#' => 'Data de Assinatura do Contrato',
    '#periodo_execucao#' => 'Período de execução',
    '#valor_devolucao_servico#' => 'Valor referente devolução do serviço não realizado',
    '#valor_devolucao_servico_extenso#' => 'Escrever o valor por extenso',
    '#valor_devolvido#' => 'Valor Devolvido',
    '#valor_devolvido_extenso#' => 'Valor Devolvido por extenso',
    '#motivo#' => 'Motivo',
    '#cidade#' => 'Cidade',
    '#dia#' => 'Dia',
    '#mes#' => 'Mês',
    '#ano#' => 'Ano',
);

$vetParametro = array_map(create_function('', ''), $vetParametroDesc);

$sql = '';
$sql .= ' select e.codigo as numero_evento, ccd.numero as numero_distrato, cc.idt_organizacao,';
$sql .= ' gec_o.descricao as pst_razaosocial, gec_o.codigo as pst_cnpj, ccd.idt_contratar_credenciado,';
$sql .= ' ord.codigo as codigo_contratacao, ord.dt_contratacao_ini, ord.dt_contratacao_fim,';
$sql .= ' cid.desccid as sebrae_cidade, est.abrevest as sebrae_estado, ccd.observacao';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato ccd';
$sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
$sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
$sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_o.idt = cc.idt_organizacao";
$sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
$sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
$sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = u.logradouro_codest';
$sql .= ' where ccd.idt = ' . null($_POST['id']);
$rs = execsqlNomeCol($sql);
$rowDados = $rs->data[0];

$vetParametro['#numero_evento#'] = $rowDados['numero_evento'];
$vetParametro['#numero_distrato#'] = $rowDados['numero_distrato'];
$vetParametro['#pst_razaosocial#'] = $rowDados['pst_razaosocial'];
$vetParametro['#pst_cnpj#'] = $rowDados['pst_cnpj'];
$vetParametro['#codigo_contratacao#'] = $rowDados['codigo_contratacao'];
$vetParametro['#periodo_execucao#'] = trata_data($rowDados['dt_contratacao_ini']) . ' a ' . trata_data($rowDados['dt_contratacao_fim']);
$vetParametro['#motivo#'] = $rowDados['observacao'];
$vetParametro['#cidade#'] = $rowDados['sebrae_cidade'] . ' / ' . $rowDados['sebrae_estado'];

//PST - Endereço
$sql = '';
$sql .= ' select ee.*';
$sql .= ' from ' . db_pir_gec . 'gec_entidade_endereco ee';
$sql .= ' left outer join ' . db_pir_gec . 'gec_endereco_tipo et on et.idt = ee.idt_entidade_endereco_tipo';
$sql .= ' where ee.idt_entidade = ' . null($rowDados['idt_organizacao']);
$sql .= " and et.ordem_contratacao = 'S'";
$rs = execsql($sql);
$row = $rs->data[0];

$tmp = Array();
$tmp[] = $row['logradouro'] . ' ' . $row['logradouro_numero'];
$tmp[] = $row['logradouro_complemento'];
$tmp[] = $row['logradouro_bairro'];
$tmp[] = $row['logradouro_municipio'];
$tmp[] = $row['cep'];

$vetParametro['#pst_endereço#'] = implode(', ', $tmp);

//PST - Representante
$sql = '';
$sql .= ' select e.codigo, e.descricao';
$sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = ee.idt_entidade_relacionada';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
$sql .= ' where ee.idt_entidade = ' . null($rowDados['idt_organizacao']);
$sql .= " and er.codigo = '00'";
$rs = execsql($sql);
$row = $rs->data[0];

$vetParametro['#pst_repesentante#'] = $row['descricao'];
$vetParametro['#pst_repesentante_cpf#'] = $row['codigo'];
$vetParametro['#pst_repesentante_rg#'] = 'NÃO TEM NO CRM';

if ($_POST['idt_atendimento'] != 'pst') {
    //Cliente
    $sql = '';
    $sql .= ' select razao_social, logradouro_cidade_e, logradouro_bairro_e, logradouro_complemento_e,';
    $sql .= ' logradouro_cep_e, cnpj, logradouro_endereco_e, logradouro_numero_e';
    $sql .= ' from grc_atendimento_organizacao o';
    $sql .= " where representa = 'S'";
    $sql .= " and desvincular = 'N'";
    $sql .= ' and idt_atendimento = ' . null($_POST['idt_atendimento']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#cliente_razaosocial#'] = $row['razao_social'];
    $vetParametro['#cliente_cnpj#'] = $row['cnpj'];

    $tmp = Array();
    $tmp[] = $row['logradouro_endereco_e'] . ' ' . $row['logradouro_numero_e'];
    $tmp[] = $row['logradouro_complemento_e'];
    $tmp[] = $row['logradouro_bairro_e'];
    $tmp[] = $row['logradouro_cidade_e'];
    $tmp[] = $row['logradouro_cep_e'];

    $vetParametro['#cliente_endereco#'] = implode(', ', $tmp);

    //Dados da Pessoa Representante (LIDER)
    $sql = '';
    $sql .= ' select nome, cpf';
    $sql .= ' from grc_atendimento_pessoa';
    $sql .= " where tipo_relacao = 'L'";
    $sql .= ' and idt_atendimento = ' . null($_POST['idt_atendimento']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#cliente_repesentante#'] = $row['nome'];
    $vetParametro['#cliente_repesentante_cpf#'] = $row['cpf'];
    $vetParametro['#cliente_repesentante_rg#'] = 'NÃO TEM NO CRM';
    $vetParametro['#cliente_repesentante_orgao_expedidor#'] = 'NÃO TEM NO CRM';
}

$sql = '';
$sql .= ' select min(dt_upload) as dt';
$sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_item';
$sql .= ' where idt_contratar_credenciado = ' . null($rowDados['idt_contratar_credenciado']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetParametro['#data_assinatura_contrato#'] = trata_data($row['dt'], false, true);

$sql = '';
$sql .= " select sum(cd.vl_pago) as tot_pago, sum(cd.vl_devolucao) as tot_devolucao";
$sql .= ' from grc_evento_participante_contadevolucao cd';
$sql .= " where cd.reg_origem = 'DI'";

if ($_POST['idt_atendimento'] != 'pst') {
    $sql .= ' and cd.idt_atendimento = ' . null($_POST['idt_atendimento']);
}

$rs = execsql($sql);
$row = $rs->data[0];

$tot = format_decimal($row['tot_devolucao']);
$vetParametro['#valor_devolucao_servico#'] = $tot;
$vetParametro['#valor_devolucao_servico_extenso#'] = clsTexto::valorPorExtenso($tot);

$tot = format_decimal($row['tot_pago'] - $row['tot_devolucao']);
$vetParametro['#valor_devolvido#'] = $tot;
$vetParametro['#valor_devolvido_extenso#'] = clsTexto::valorPorExtenso($tot);

$dt = DatetoArray(Date('d/m/Y'));

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

$vetParametro['#dia#'] = $dt['dia'];
$vetParametro['#mes#'] = $vetMes[$dt['mes']];
$vetParametro['#ano#'] = $dt['ano'];

if ($_POST['idt_atendimento'] == 'pst') {
    $modeloPDF = 'distrato_modelo_pst';
} else {
    $modeloPDF = 'distrato_modelo_cliente';
}

//Gerando PDF
$sql = '';
$sql .= ' select detalhe';
$sql .= ' from ' . db_pir_gec . 'gec_parametros';
$sql .= " where codigo = '{$modeloPDF}_cab'";
$rs = execsql($sql);
$header = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from ' . db_pir_gec . 'gec_parametros';
$sql .= " where codigo = '{$modeloPDF}_rod'";
$rs = execsql($sql);
$footer = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from ' . db_pir_gec . 'gec_parametros';
$sql .= " where codigo = '{$modeloPDF}_cont'";
$rs = execsql($sql);
$htmlPDF = $rs->data[0][0];

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
