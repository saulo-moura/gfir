<?php
if ($_POST['idt_atendimento'] == 'pst') {
    $modeloPDF = 'aditivo_modelo_pst';

    $vetParametroDesc = Array(
        '#numero_evento#' => 'Nº DO EVENTO',
        '#codigo_contratacao#' => 'Código de contratação',
        '#numero_aditivo#' => 'Nº ADITAMENTO',
        '#data_final_contrato#' => 'Data Final do Contrato',
        '#data_final_aditivo#' => 'Data Final do Contrato Aditado',
        '#pst_razaosocial#' => 'PST',
        '#pst_endereco#' => 'Endereço',
        '#pst_cnpj#' => 'CNPJ',
        '#pst_repesentante#' => 'Pessoa física que fez a contratação',
        '#pst_repesentante_rg#' => 'RG',
        '#pst_repesentante_cpf#' => 'CPF',
        '#data_gerado_contrato#' => 'Data da Geração do Contrato',
        '#data_upload_contrato#' => 'Data do Upload do Contrato',
        '#responsavel_evento#' => 'Responsável pelo Evento',
        '#tab_entrega#' => 'TABELA DE ENTREGA',
        '#cidade#' => 'Cidade',
        '#dia#' => 'Dia',
        '#mes#' => 'Mês',
        '#ano#' => 'Ano',
    );
    
    $vetParametro = array_map(create_function('', ''), $vetParametroDesc);

    $sql = '';
    $sql .= ' select e.codigo as numero_evento, ccd.numero as numero_aditivo, cc.idt_organizacao, cc.idt_gec_contratacao_credenciado_ordem, cc.idt_organizacao,';
    $sql .= ' gec_o.descricao as pst_razaosocial, gec_o.codigo as pst_cnpj, ccd.idt_contratar_credenciado, ord_lste.data_conclusao_servico_cotacao as data_final_contrato,';
    $sql .= ' ord.codigo as codigo_contratacao, cid.desccid as sebrae_cidade, est.abrevest as sebrae_estado, ug.nome_completo as responsavel_evento';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo ccd';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista ord_lst on ord_lst.idt_gec_contratacao_credenciado_ordem = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista_endidade ord_lste on ord_lste.idt_gec_contratacao_credenciado_ordem_lista = ord_lst.idt';
    $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_o.idt = cc.idt_organizacao";
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
    $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
    $sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
    $sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = u.logradouro_codest';
    $sql .= ' left outer join ' . db_pir_grc . 'plu_usuario ug on ug.id_usuario = e.idt_gestor_evento';
    $sql .= ' where ccd.idt = ' . null($_POST['id']);
    $sql .= " and ord_lst.idt_organizacao = ord_lste.idt_organizacao ";
    $rs = execsqlNomeCol($sql);
    $rowDados = $rs->data[0];

    $vetParametro['#numero_evento#'] = $rowDados['numero_evento'];
    $vetParametro['#numero_aditivo#'] = $rowDados['numero_aditivo'];
    $vetParametro['#data_final_contrato#'] = trata_data($rowDados['data_final_contrato']);
    $vetParametro['#pst_razaosocial#'] = $rowDados['pst_razaosocial'];
    $vetParametro['#pst_cnpj#'] = $rowDados['pst_cnpj'];
    $vetParametro['#codigo_contratacao#'] = $rowDados['codigo_contratacao'];
    $vetParametro['#responsavel_evento#'] = $rowDados['responsavel_evento'];
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

    $vetParametro['#pst_endereco#'] = implode(', ', $tmp);

    //PST - Representante
    $sql = '';
    $sql .= ' select e.codigo, e.descricao';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = ee.idt_entidade_relacionada';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
    $sql .= ' where ee.idt_entidade = ' . null($rowDados['idt_organizacao']);
    $sql .= " and er.codigo = '00'";
    $sql .= " and e.tipo_entidade = 'P'";
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#pst_repesentante#'] = $row['descricao'];
    $vetParametro['#pst_repesentante_cpf#'] = $row['codigo'];
    $vetParametro['#pst_repesentante_rg#'] = 'NÃO TEM NO CRM';

    $sql = '';
    $sql .= ' select min(dt_registro) as dt_registro,  min(dt_upload) as dt_upload';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_item';
    $sql .= ' where idt_contratar_credenciado = ' . null($rowDados['idt_contratar_credenciado']);
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#data_gerado_contrato#'] = trata_data($row['dt_registro'], false, true);
    $vetParametro['#data_upload_contrato#'] = trata_data($row['dt_upload'], false, true);
} else {
    $modeloPDF = 'aditivo_modelo_cliente';

    $vetParametroDesc = Array(
        '#numero_evento#' => 'Nº DO EVENTO',
        '#numero_aditivo#' => 'Nº ADITAMENTO',
        '#data_final_contrato#' => 'Data Final do Contrato',
        '#data_final_aditivo#' => 'Data Final do Contrato Aditado',
        '#pst_razaosocial#' => 'PST',
        '#pst_endereco#' => 'Endereço',
        '#pst_cnpj#' => 'CNPJ 2',
        '#pst_repesentante#' => 'Pessoa física que fez a contratação',
        '#pst_repesentante_rg#' => 'RG',
        '#pst_repesentante_cpf#' => 'CPF',
        '#cliente_razaosocial#' => 'NOME DA EMPRESA BENEFICIADA',
        '#cliente_endereco#' => 'ENDEREÇO DA EMPRESA',
        '#cliente_cnpj#' => 'CNPJ',
        '#cliente_repesentante#' => 'Nome Cliente',
        '#cliente_repesentante_rg#' => 'RG',
        '#cliente_repesentante_orgao_expedidor#' => 'ORGÃO EXPEDIDOR',
        '#cliente_repesentante_cpf#' => 'CPF',
        '#cliente_data_assinado#' => 'DATA DE ASSINATURA DO CONTRATO',
        '#responsavel_evento#' => 'Responsável pelo Evento',
        '#tab_entrega#' => 'TABELA DE ENTREGA',
        '#cidade#' => 'Cidade',
        '#dia#' => 'Dia',
        '#mes#' => 'Mês',
        '#ano#' => 'Ano',
    );

    $vetParametro = array_map(create_function('', ''), $vetParametroDesc);

    $sql = '';
    $sql .= ' select e.codigo as numero_evento, ccd.numero as numero_aditivo, cc.idt_gec_contratacao_credenciado_ordem, ug.nome_completo as responsavel_evento,';
    $sql .= ' gec_o.descricao as pst_razaosocial, gec_o.codigo as pst_cnpj, ord_lste.data_conclusao_servico_cotacao as data_final_contrato,';
    $sql .= ' ccd.idt_contratar_credenciado, ord.dt_contratacao_ini, ord.dt_contratacao_fim, cc.idt_organizacao,';
    $sql .= ' cid.desccid as sebrae_cidade, est.abrevest as sebrae_estado';
    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo ccd';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado cc on cc.idt = ccd.idt_contratar_credenciado';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord on ord.idt = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista ord_lst on ord_lst.idt_gec_contratacao_credenciado_ordem = cc.idt_gec_contratacao_credenciado_ordem';
    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista_endidade ord_lste on ord_lste.idt_gec_contratacao_credenciado_ordem_lista = ord_lst.idt';
    $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_o.idt = cc.idt_organizacao";
    $sql .= ' left outer join ' . db_pir_grc . 'grc_evento e on e.idt = ord.idt_evento';
    $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
    $sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
    $sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = u.logradouro_codest';
    $sql .= ' left outer join ' . db_pir_grc . 'plu_usuario ug on ug.id_usuario = e.idt_gestor_evento';
    $sql .= ' where ccd.idt = ' . null($_POST['id']);
    $sql .= " and ord_lst.idt_organizacao = ord_lste.idt_organizacao ";
    $rs = execsqlNomeCol($sql);
    $rowDados = $rs->data[0];

    $vetParametro['#numero_evento#'] = $rowDados['numero_evento'];
    $vetParametro['#numero_aditivo#'] = $rowDados['numero_aditivo'];
    $vetParametro['#data_final_contrato#'] = trata_data($rowDados['data_final_contrato']);
    $vetParametro['#pst_razaosocial#'] = $rowDados['pst_razaosocial'];
    $vetParametro['#pst_cnpj#'] = $rowDados['pst_cnpj'];
    $vetParametro['#responsavel_evento#'] = $rowDados['responsavel_evento'];
    $vetParametro['#cidade#'] = $rowDados['sebrae_cidade'] . ' / ' . $rowDados['sebrae_estado'];

    //Contrato
    $sql = '';
    $sql .= ' select dt_contrato';
    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_contrato p';
    $sql .= ' where p.idt_atendimento = ' . null($_POST['idt_atendimento']);
    $sql .= " and p.dt_cancelamento is null";
    $rs = execsql($sql, $trata_erro);
    $row = $rs->data[0];
    $vetParametro['#cliente_data_assinado#'] = trata_data($row['dt_contrato'], false, true);

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

    $vetParametro['#pst_endereco#'] = implode(', ', $tmp);

    //PST - Representante
    $sql = '';
    $sql .= ' select e.codigo, e.descricao';
    $sql .= ' from ' . db_pir_gec . 'gec_entidade_entidade ee';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = ee.idt_entidade_relacionada';
    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_relacao er on er.idt = ee.idt_entidade_relacao';
    $sql .= ' where ee.idt_entidade = ' . null($rowDados['idt_organizacao']);
    $sql .= " and er.codigo = '00'";
    $sql .= " and e.tipo_entidade = 'P'";
    $rs = execsql($sql);
    $row = $rs->data[0];

    $vetParametro['#pst_repesentante#'] = $row['descricao'];
    $vetParametro['#pst_repesentante_cpf#'] = $row['codigo'];
    $vetParametro['#pst_repesentante_rg#'] = 'NÃO TEM NO CRM';

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

//Entregas
$entregas = '';
$entregas .= '<table>';
$entregas .= '<tr style="background:#4f81bd; font-weight: bold; text-align: center;">';

if ($_POST['idt_atendimento'] == 'pst') {
    $entregas .= '<td style="color: white;">CLIENTE</td>';
}

$entregas .= '<td style="color: white;">CÓDIGO</td>';
$entregas .= '<td style="color: white;">ATIVIDADE</td>';
$entregas .= '<td style="color: white;">MÊS/ANO</td>';
$entregas .= '<td style="color: white;">PERCENTUAL</td>';
$entregas .= '<td style="color: white;">VL. COTAÇÃO</td>';
$entregas .= '<td style="color: white;">FINANCEIRO</td>';
$entregas .= '<td style="color: white;">VL. ADITADO</td>';
$entregas .= '<td style="color: white;">PRAZO ADITADO</td>';
$entregas .= '</tr>';

$sql = "select orde.*,";
$sql .= " concat_ws('<br />', grc_atpe.cpf, grc_atpe.nome) as pessoa,";
$sql .= ' afp.situacao_reg, afp.gfi_situacao, afp.liquidado, ccae.valor, ccae.data,';
$sql .= ' orde.idt as idt_gec_contratacao_credenciado_ordem_entrega';
$sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_entrega orde";
$sql .= " left outer join " . db_pir_grc . "grc_atendimento_pessoa grc_atpe on grc_atpe.tipo_relacao = 'L' and grc_atpe.idt_atendimento = orde.idt_atendimento";
$sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm rm on";
$sql .= " rm.idt_gec_contratacao_credenciado_ordem = orde.idt_gec_contratacao_credenciado_ordem";
$sql .= " and rm.rm_cancelado = 'N'";
$sql .= " and rm.mesano = orde.mesano";
$sql .= " left outer join " . db_pir_pfo . "pfo_af_processo afp on afp.idmov = rm.rm_idmov";
$sql .= " left outer join " . db_pir_gec . "gec_contratar_credenciado_aditivo_entrega ccae on";
$sql .= " ccae.idt_gec_contratacao_credenciado_ordem_entrega = orde.idt";
$sql .= " and ccae.idt_aditivo = " . null($_POST['id']);
$sql .= ' where orde.idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);

if ($_POST['idt_atendimento'] == 'pst') {
    $sql .= " order by grc_atpe.nome, orde.ordem";
} else {
    $sql .= ' and orde.idt_atendimento = ' . null($_POST['idt_atendimento']);
    $sql .= " order by orde.ordem";
}

$rs = execsql($sql);

ForEach ($rs->data as $row) {
    $entregas .= '<tr>';

    if ($_POST['idt_atendimento'] == 'pst') {
        $entregas .= '<td>' . $row['pessoa'] . '</td>';
    }

    $entregas .= '<td>' . $row['codigo'] . '</td>';
    $entregas .= '<td>' . $row['descricao'] . '</td>';
    $entregas .= '<td>' . $row['mesano'] . '</td>';
    $entregas .= '<td>' . format_decimal($row['percentual']) . '</td>';
    $entregas .= '<td>' . format_decimal($row['vl_entrega_real']) . '</td>';
    $entregas .= '<td>';

    if ($row['situacao_reg'] == '') {
        $entregas .= 'O credenciado não consultou este processo';
    } else {
        $entregas .= $vetAFProcessoSit[$row['situacao_reg']];

        if ($row['situacao_reg'] == 'FI') {
            $entregas .= '<br />' . $vetAFProcessoFI[$row['gfi_situacao']];
        }
    }

    $entregas .= '</td>';
    $entregas .= '<td>' . format_decimal($row['valor']) . '</td>';
    $entregas .= '<td>' . trata_data($row['data']) . '</td>';
    $entregas .= '</tr>';
}

$entregas .= '</table>';

$vetParametro['#tab_entrega#'] = $entregas;

$sql = '';
$sql .= ' select max(data) as data_final_aditivo';
$sql .= ' from '.db_pir_gec.'gec_contratar_credenciado_aditivo_entrega';
$sql .= ' where idt_aditivo = '. null($_POST['id']);
$rs = execsql($sql);
$row = $rs->data[0];

$vetParametro['#data_final_aditivo#'] = trata_data($row['data_final_aditivo']);

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
