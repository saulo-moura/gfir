<?php
$sql = '';
$sql .= ' select p.idt_atendimento, a.idt_evento';
$sql .= ' from grc_atendimento_pessoa p';
$sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
$sql .= ' where p.idt = ' . null($_GET['id']);
$rs = execsql($sql);
$idt_atendimento = $rs->data[0]['idt_atendimento'];
$idt_evento = $rs->data[0]['idt_evento'];

$vetParametro = array_map(create_function('', ''), $vetParametroEventoCertificado);

//Dados do Evento
$sql = '';
$sql .= ' select u.descricao as sebrae_nome, cid.desccid as sebrae_cidade, est.descest as sebrae_estado, bai.descbairro as sebrae_bairro,';
$sql .= " u.cnpj as sebrae_cnpj, concat_ws(' - ', e.codigo, e.descricao) as evento_nome, e.qtd_minima_pagantes as evento_min_pag,";
$sql .= ' e.quantidade_participante as evento_vagas, e.frequencia_min as evento_freq,';
$sql .= ' e.html_corpo, e.html_header, e.html_footer, e.mpdf_me, e.mpdf_md, e.mpdf_ms, e.mpdf_mb, e.mpdf_mh, e.mpdf_mf, e.mpdf_papel_orientacao';
$sql .= ' from grc_evento e';
$sql .= ' inner join ' . db_pir . 'sca_organizacao_secao u on u.idt = e.idt_unidade';
$sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = u.logradouro_codcid';
$sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = u.logradouro_codest';
$sql .= ' left outer join ' . db_pir_siac . 'bairro bai on bai.codbairro = u.logradouro_codbairro';
$sql .= ' where e.idt = ' . null($idt_evento);
$rs = execsql($sql);
$rowE = $rs->data[0];

$vetParametro['#sebrae_nome#'] = $rowE['sebrae_nome'];
$vetParametro['#sebrae_cidade#'] = $rowE['sebrae_cidade'];
$vetParametro['#sebrae_estado#'] = $rowE['sebrae_estado'];
$vetParametro['#sebrae_bairro#'] = $rowE['sebrae_bairro'];
$vetParametro['#sebrae_cnpj#'] = $rowE['sebrae_cnpj'];
$vetParametro['#sebrae_ie#'] = $rowE['sebrae_ie'];

$vetParametro['#evento_nome#'] = $rowE['evento_nome'];
$vetParametro['#evento_min_pag#'] = $rowE['evento_min_pag'];
$vetParametro['#evento_vagas#'] = $rowE['evento_vagas'];
$vetParametro['#evento_freq#'] = $rowE['evento_freq'];

//Dados da Pessoa Representante (LIDER)
$sql = '';
$sql .= ' select nome as representante_nome, logradouro_cidade as representante_cidade, logradouro_estado as representante_estado, logradouro_bairro as representante_bairro,';
$sql .= ' logradouro_cep as representante_cep, coalesce(telefone_celular, telefone_recado, telefone_residencial) as representante_telefone, cpf as representante_cpf';
$sql .= ' from grc_atendimento_pessoa';
$sql .= ' where idt = ' . null($_GET['id']);
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
$sql = '';
$sql .= ' select razao_social as empresa_nome, logradouro_cidade_e as empresa_cidade, logradouro_estado_e as empresa_estado, logradouro_bairro_e as empresa_bairro,';
$sql .= ' logradouro_cep_e as empresa_cep, coalesce(telefone_comercial_e, telefone_celular_e) as empresa_telefone, cnpj as empresa_cnpj';
$sql .= ' from grc_atendimento_organizacao o';
$sql .= " where representa = 'S'";
$sql .= " and desvincular = 'N'";
$sql .= ' and idt_atendimento = ' . null($idt_atendimento);
$rs = execsql($sql);

if ($rs->rows > 0) {
    $row = $rs->data[0];

    $vetParametro['#empresa_nome#'] = $row['empresa_nome'];
    $vetParametro['#empresa_cidade#'] = $row['empresa_cidade'];
    $vetParametro['#empresa_estado#'] = $row['empresa_estado'];
    $vetParametro['#empresa_bairro#'] = $row['empresa_bairro'];
    $vetParametro['#empresa_cep#'] = $row['empresa_cep'];
    $vetParametro['#empresa_telefone#'] = $row['empresa_telefone'];
    $vetParametro['#empresa_cnpj#'] = $row['empresa_cnpj'];
} else {
    $vetParametro['#empresa_nome#'] = $vetParametro['#representante_nome#'];
    $vetParametro['#empresa_cidade#'] = $vetParametro['#representante_cidade#'];
    $vetParametro['#empresa_estado#'] = $vetParametro['#representante_estado#'];
    $vetParametro['#empresa_bairro#'] = $vetParametro['#representante_bairro#'];
    $vetParametro['#empresa_cep#'] = $vetParametro['#representante_cep#'];
    $vetParametro['#empresa_telefone#'] = $vetParametro['#representante_telefone#'];
    $vetParametro['#empresa_cnpj#'] = $vetParametro['#representante_cpf#'];
}

//Gerando PDF
if ($rowE['mpdf_papel_orientacao'] == 'L') {
    $papel = 'A4-L';
} else {
    $papel = 'A4';
}

$mpdf = new mPDF('win-1252', $papel, '10', '', $rowE['mpdf_me'], $rowE['mpdf_md'], $rowE['mpdf_ms'], $rowE['mpdf_mb'], $rowE['mpdf_mh'], $rowE['mpdf_mf'], $rowE['mpdf_papel_orientacao']);

$header = $rowE['html_header'];
$footer = $rowE['html_footer'];
$htmlPDF = $rowE['html_corpo'];

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
