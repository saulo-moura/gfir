<?php
$vetParametroDesc = Array(
    '#nome_gerente#' => 'Nome do Aprovador',
    '#matricula#' => 'Nº da Matrícula do Aprovador',
    '#cargo#' => 'Cargo do Aprovador>',
    '#codigo_evento#' => 'Nº Evento',
    '#codigo_os#' => 'Nº da O.S. no GEC',
    '#cidade#' => 'Cidade',
    '#estado#' => 'Estado',
    '#dt_aprovacao#' => 'Data da Aprovação',
    '#md5#' => 'Código de Autenticidade (MD5)',
);

$vetParametroHtml = array_map(create_function('', ''), $vetParametroDesc);

$sql = '';
$sql .= ' select u.nome_completo as nome_gerente, u.matricula_intranet as matricula, c.descricao as cargo, d.tipo,';
$sql .= ' d.codigo_evento, d.codigo_os, cid.desccid as cidade, est.abrevest as estado, d.dt_aprovacao, d.md5';
$sql .= ' from grc_evento_declaracao d';
$sql .= ' inner join plu_usuario u on u.id_usuario = d.idt_usuario_aprovacao';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_cargo c on c.idt = u.idt_cargo';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao s on s.idt = u.idt_unidade_lotacao';
$sql .= ' left outer join ' . db_pir_siac . 'cidade cid on cid.codcid = s.logradouro_codcid';
$sql .= ' left outer join ' . db_pir_siac . 'estado est on est.codest = s.logradouro_codest';
$sql .= ' where d.idt = ' . null($vetParametro['idt_evento_declaracao']);
$rs = execsqlNomeCol($sql);
$row = $rs->data[0];

$modelo = 'evento_declaracao_modelo_' . mb_strtolower($row['tipo']);

$vetParametroHtml['#nome_gerente#'] = $row['nome_gerente'];
$vetParametroHtml['#matricula#'] = $row['matricula'];
$vetParametroHtml['#cargo#'] = $row['cargo'];
$vetParametroHtml['#codigo_evento#'] = $row['codigo_evento'];
$vetParametroHtml['#codigo_os#'] = $row['codigo_os'];
$vetParametroHtml['#cidade#'] = $row['cidade'];
$vetParametroHtml['#estado#'] = $row['estado'];
$vetParametroHtml['#dt_aprovacao#'] = trata_data($row['dt_aprovacao'], true);
$vetParametroHtml['#md5#'] = $row['md5'];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = '{$modelo}_cab'";
$rs = execsql($sql);
$header = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = '{$modelo}_rod'";
$rs = execsql($sql);
$footer = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = '{$modelo}_cont'";
$rs = execsql($sql);
$htmlPDF = $rs->data[0][0];

foreach ($vetParametroHtml as $key => $value) {
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

echo $htmlPDF;