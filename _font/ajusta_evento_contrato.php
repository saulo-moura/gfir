<?php
require_once 'configuracao.php';

//ini_set('memory_limit', '-1');
set_time_limit(0);

define('_MPDF_PATH', lib_mpdf);
include(lib_mpdf.'mpdf.php');

$pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico.'/'.$dir_file.'/grc_evento_participante_contrato/');

if (!file_exists($pathPDF)) {
    mkdir($pathPDF);
}

$ME = 5;
$MD = 5;
$MS = 27;
$MB = 7;
$MHEADER = 3;
$MFOOTER = 5;

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
    '#representante_telefone#' => 'Telefone Principal ou Celular Principal -Pessoa Jurídica da Oportunidade',
    '#representante_cpf#' => 'CPF-Pessoa Física da Oportunidade',
    '#empresa_nome#' => 'Pessoa Jurídica - Oportunidade',
    '#empresa_cidade#' => 'Cidade-Pessoa Jurídica da Oportunidade',
    '#empresa_estado#' => 'Estado-Pessoa Jurídica da Oportunidade',
    '#empresa_bairro#' => 'Bairro-Pessoa Jurídica da Oportunidade',
    '#empresa_cep#' => 'CEP -Pessoa Jurídica da Oportunidade',
    '#empresa_telefone#' => 'Telefone Principal ou Celular Principal -Pessoa Jurídica da Oportunidade',
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

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = 'evento_modelo_contrato_cab'";
$rs = execsql($sql);
$headerPadrao = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = 'evento_modelo_contrato_rod'";
$rs = execsql($sql);
$footerPadrao = $rs->data[0][0];

$sql = '';
$sql .= ' select detalhe';
$sql .= ' from grc_parametros';
$sql .= " where codigo = 'evento_modelo_contrato_cont'";
$rs = execsql($sql);
$htmlPDFPadrao = $rs->data[0][0];

$sql = '';
$sql .= ' select c.idt, c.idt_atendimento, a.idt_evento, c.contrato_pdf, c.contrato_txt, c.dt_contrato';
$sql .= ' from grc_evento_participante_contrato c';
$sql .= ' inner join grc_atendimento a on a.idt = c.idt_atendimento';

$sql .= " where c.problema = 'S'";
/*
$sql .= ' inner join (';
$sql .= ' select contrato_pdf';
$sql .= ' from grc_evento_participante_contrato';
$sql .= ' group by contrato_pdf';
$sql .= ' having count(idt) > 1';
$sql .= ' ) x on x.contrato_pdf = c.contrato_pdf';
*/
//echo $sql; exit();
$rsd = execsql($sql);

foreach ($rsd->data as $rowd) {
    if (file_exists($pathPDF.$rowd['contrato_pdf'])) {
        unlink($pathPDF.$rowd['contrato_pdf']);
    }

    $header = $headerPadrao;
    $footer = $footerPadrao;
    $htmlPDF = $htmlPDFPadrao;
    $vetParametro = array_map(create_function('', ''), $vetParametroDesc);

    //Dados do Evento
    $sql = '';
    $sql .= ' select u.descricao as sebrae_nome, cid.desccid as sebrae_cidade, est.descest as sebrae_estado, bai.descbairro as sebrae_bairro,';
    $sql .= " u.cnpj as sebrae_cnpj, null as sebrae_ie, concat_ws(' - ', e.codigo, e.descricao) as evento_nome, e.qtd_minima_pagantes as evento_min_pag,";
    $sql .= ' e.quantidade_participante as evento_vagas, e.frequencia_min as evento_freq';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join '.db_pir.'sca_organizacao_secao u on u.idt = e.idt_unidade';
    $sql .= ' left outer join '.db_pir_siac.'cidade cid on cid.codcid = u.logradouro_codcid';
    $sql .= ' left outer join '.db_pir_siac.'estado est on est.codest = u.logradouro_codest';
    $sql .= ' left outer join '.db_pir_siac.'bairro bai on bai.codbairro = u.logradouro_codbairro';
    $sql .= ' where e.idt = '.null($rowd['idt_evento']);
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
    $sql .= ' and idt_atendimento = '.null($rowd['idt_atendimento']);
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
        $sql .= ' and idt_atendimento = '.null($rowd['idt_atendimento']);
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
    $sql .= " inner join ".db_pir_siac."cidade c on c.codcid = ea.idt_cidade";
    $sql .= " inner join grc_evento_local_pa l on l.idt = ea.idt_local";
    $sql .= ' where idt_evento = '.null($rowd['idt_evento']);
    $sql .= ' order by ea.dt_ini, ea.dt_fim';
    $rs = execsql($sql);

    $vetAgenda_data = Array();
    $vetAgenda_local = Array();

    foreach ($rs->data as $row) {
        $data = trata_data($row['data_inicial']);
        $local = $row['local'].' - '.$row['cidade'];

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
    $sql .= ' where pp.idt_atendimento = '.null($rowd['idt_atendimento']);
    $sql .= " and pp.estornado <> 'S'";
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
        $forma = $row['forma'].' - '.$row['parcela'];
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
    $sql .= ' where idt_atendimento = '.null($rowd['idt_atendimento']);
    $sql .= ' order by nome';
    $rs = execsql($sql);

    $vetInsc_nome = Array();

    foreach ($rs->data as $row) {
        $vetInsc_nome[] = $row['nome'];
    }

    $vetParametro['#insc_nome#'] = implode('<br />', $vetInsc_nome);

    $vet = DatetoArray(trata_data($rowd['dt_contrato'], true));
    $intDT = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);
    
    $vetParametro['#dt_atual#'] = trata_data($rowd['dt_contrato']);
    $vetParametro['#n+dt_atual#'] = Date('d/m/Y', strtotime('+360 day', $intDT));
    $vetParametro['#hoje#'] = trata_data($rowd['dt_contrato']);

    /* Armenge para a falta da IE */
    if ($vetParametro['#sebrae_ie#'] == '') {
        $htmlPDF = str_replace(', Inscrição Estadual nº #sebrae_ie#', '', $htmlPDF);
    }

    foreach ($vetParametro as $key => $value) {
        $header = str_replace($key, $value, $header);
        $footer = str_replace($key, $value, $footer);
        $htmlPDF = str_replace($key, $value, $htmlPDF);
    }
	
	unset($vetParametro);

	$mpdf = new mPDF('win-1252', 'A4', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'P');
	$mpdf->SetColumns(2, 'justify');

    $header = utf8_encode($header);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLHeader($header, 'E');

    $footer = utf8_encode($footer);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->SetHTMLFooter($footer, 'E');

    $contrato_pdf = 'contrato_'.$rowd['idt_atendimento'].'_'.GerarStr(20).'.pdf';

    $html = '';
    $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    $html .= '<html xmlns="http://www.w3.org/1999/xhtml">';
    $html .= '<head>';
    $html .= '<meta http-equiv="Content-Type" content="text/html; charset=win-1252" />';
    $html .= '</head>';
    $html .= '<body>';
    $html .= $htmlPDF;
    $html .= '</body>';
    $html .= '</html>';

    $html = preg_replace("|<script\b[^>]*>(.*?)</script>|s", "", $html);
    $html = str_replace('  ', ' ', $html);
    $html = str_replace("\n", '', $html);
    $html = str_replace(chr(10), '', $html);
    $html = str_replace(chr(13), '', $html);
    $html = str_replace("&nbsp;", '', $html);
    $html = utf8_encode($html);

    $mpdf->WriteHTML($html);
    $mpdf->Output($pathPDF.$contrato_pdf, 'F');

    $sql = "update grc_evento_participante_contrato set problema = 'O', contrato_pdf = ".aspa($contrato_pdf);
    $sql .= ' where idt = '.null($rowd['idt']);
    execsql($sql);
}

echo 'FIM...';