<?php
//ajustar codrealizacao

require_once '../configuracao.php';

$conSIAC = conSIAC();

ini_set('memory_limit', '-1');
set_time_limit(0);

$sql = '';
$sql .= " select a.idt, a.idt_instrumento, ap.cpf, a.data, a.hora_inicio_atendimento, i.descricao_siacweb as instrumento,";
$sql .= " a.idt_grupo_atendimento, 'P' as origem, a.codrealizacao";
$sql .= ' from grc_atendimento a';
$sql .= " inner join grc_atendimento_pessoa ap on ap.idt_atendimento = a.idt and ap.tipo_relacao = 'L'";
$sql .= " inner join grc_sincroniza_siac s on s.idt_atendimento = a.idt";
$sql .= " inner join grc_atendimento_instrumento i on i.idt = a.idt_instrumento";

$sql .= " INNER JOIN grc_atendimento_organizacao o ON o.idt_atendimento = a.idt AND o.representa = 'S' AND o.desvincular = 'N'";

$sql .= " where s.tipo = 'H'";
//$sql .= ' and a.idt_grupo_atendimento is not null';
//$sql .= ' and s.erro is null';
//$sql .= ' and s.dt_sincroniza is not null';
$sql .= ' and a.codrealizacao is not null';
//$sql .= ' and a.hist_codigo is not null';
//$sql .= ' and a.idt = 323271';

$sql .= ' AND YEAR (a. DATA) = 2016';
$sql .= ' and a.hist_codconst is null';

$rs = execsql($sql);
//p($rs);
//exit();

foreach ($rs->data as $row) {
    if ($row['idt_grupo_atendimento'] != '') {
        //Atendimento NAN
        $nomerealizacao = "'Atendimento', 'Atendimento Negócio a Negócio'";

        switch ($row['idt_instrumento']) {
            case 13: //Orientação Técnica Presencial
				$tiporealizacao = "'NAN', 'ATN'";
                break;

            case 2: //Consultoria Presencial
				$tiporealizacao = "'NAN', 'CON'";
                break;

            default:
				$tiporealizacao = "'NAN', 'ATN'";
                break;
        }
    } else if ($row['origem'] == 'D') {
        //Atendimento a Distância
        $nomerealizacao = "'Atendimento a Distância'";
        $tiporealizacao = "'ATN'";
    } else {
        //Atendimento de Balcão
        $nomerealizacao = "'Atendimento'";
        $tiporealizacao = "'ATN'";
    }

    $sql = '';
    $sql .= ' select h.codrealizacao, j.nomerazaosocial as descricao, j.cgccpf as codigo, dj.coddap as dap, dj.nirf, dj.codpescador as rmp, dj.inscest as ie_prod_rural,';
	$sql .= ' h.faturam as hist_faturam, h.codconst as hist_codconst, dj.faturam as siacweb_faturam, dj.codconst as siacweb_codconst';
    $sql .= ' from historicorealizacoescliente h with(nolock)';
    $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = h.codcliente';
    $sql .= ' left outer join parceiro j with(nolock) on j.codparceiro = h.CodEmpreedimento';
    $sql .= ' left outer join pessoaj dj with(nolock) on dj.codparceiro = h.CodEmpreedimento';
    $sql .= ' where p.cgccpf = '.null(preg_replace('/[^0-9]/i', '', $row['cpf']));
    $sql .= ' and h.codsebrae = 26';
    $sql .= ' and h.datahorainiciorealizacao = '.aspa($row['data'].' '.$row['hora_inicio_atendimento']);
    $sql .= " and h.codrealizacao = ".aspa($row['codrealizacao']);
    /*
	$sql .= " and h.abordagem = 'I'";
    $sql .= " and h.nomerealizacao in ({$nomerealizacao})";
    $sql .= " and h.tiporealizacao in ({$tiporealizacao})";
    $sql .= " and h.instrumento = ".aspa($row['instrumento']);
	*/
    $rss = execsql($sql, true, $conSIAC);
    $rows = $rss->data[0];
//echo "'".$sql."'<br />";
//p($rows);

    $sql = 'update grc_atendimento set ';
    //$sql .= ' codrealizacao = '.null($rows['codrealizacao']).',';
    $sql .= ' hist_faturam = '.null($rows['hist_faturam']).',';
    $sql .= ' hist_codconst = '.null($rows['hist_codconst']).',';
    $sql .= ' siacweb_faturam = '.null($rows['siacweb_faturam']).',';
    $sql .= ' siacweb_codconst = '.null($rows['siacweb_codconst']).',';
    $sql .= ' hist_descricao = '.aspa($rows['descricao']).',';
    $sql .= ' hist_codigo = '.aspa(FormataCNPJ($rows['codigo'])).',';
    $sql .= ' hist_dap = '.aspa($rows['dap']).',';
    $sql .= ' hist_nirf = '.aspa(FormataNirf($rows['nirf'])).',';
    $sql .= ' hist_rmp = '.aspa($rows['rmp']).',';
    $sql .= ' hist_ie_prod_rural = '.aspa($rows['ie_prod_rural']);
    $sql .= ' where idt = '.null($row['idt']);
//echo "'".$sql."'<br />";
    execsql($sql, false);
}

echo 'FIM...';
