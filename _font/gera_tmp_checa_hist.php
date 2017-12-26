<?php
require_once '../configuracao.php';

$conSIAC = conSIAC();

ini_set('memory_limit', '-1');
set_time_limit(0);

$sql = 'truncate table tmp_checa_hist';
execsql($sql);

/*
$sql = '';
$sql .= " select p.idt as idt_atendimento_pessoa, a.idt_evento, e.idt_instrumento, e.codigo_siacweb, p.cpf, concat(e.dt_previsao_inicial, ' ', e.hora_inicio) as hora_inicio, p.evento_concluio,";
$sql .= " concat('[', e.codigo, '] ', e.descricao) as nomerealizacao, inst.descricao_siacweb as instrumento,";
$sql .= ' o.razao_social as descricao, o.cnpj, o.codigo_siacweb_e, o.dap, o.nirf, o.rmp, o.ie_prod_rural, const.codigo as codconst, fat.codigo as faturam, p.nome';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
$sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
$sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
$sql .= ' inner join grc_atendimento_instrumento inst on inst.idt = e.idt_instrumento';
$sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt ';
$sql .= ' left outer join '.db_pir_gec.'gec_entidade_tipo_emp const on const.idt = o.idt_tipo_empreendimento';
$sql .= ' left outer join '.db_pir_gec.'gec_organizacao_porte fat on fat.idt = o.idt_porte';
$sql .= ' where e.idt_evento_situacao = 20';
$sql .= " and ep.contrato in ('C', 'S', 'G')";
$sql .= ' and e.idt_instrumento <> 2';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select m.codevento';
    $sql .= ' from participante m with(nolock)';
    $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = m.codpessoapf';
    $sql .= ' where m.codevento = '.aspa($row['codigo_siacweb']);
    $sql .= ' and p.cgccpf = '.null(preg_replace('/[^0-9]/i', '', $row['cpf']));
    $rss = execsqlNomeCol($sql, true, $conSIAC);

    if ($rss->rows > 0) {
        $matricula_siacweb = 'S';
    } else {
        $matricula_siacweb = 'N';
    }

    $sql = '';
    $sql .= ' select h.codrealizacao, j.nomerazaosocial as descricao, j.cgccpf as codigo, dj.coddap as dap, dj.nirf, dj.codpescador as rmp, dj.inscest as ie_prod_rural,';
    $sql .= ' h.faturam as hist_faturam, h.codconst as hist_codconst, dj.faturam as siacweb_faturam, dj.codconst as siacweb_codconst, h.codempreedimento,';
    $sql .= ' p.cgccpf, p.nomerazaosocial as pessoa';
    $sql .= ' from historicorealizacoescliente h with(nolock)';
    $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = h.codcliente';
    $sql .= ' left outer join parceiro j with(nolock) on j.codparceiro = h.CodEmpreedimento';
    $sql .= ' left outer join pessoaj dj with(nolock) on dj.codparceiro = h.CodEmpreedimento';
    $sql .= ' where h.codsebrae = 26';
    $sql .= ' and p.cgccpf = '.null(preg_replace('/[^0-9]/i', '', $row['cpf']));
    //$sql .= ' and h.datahorainiciorealizacao = '.aspa($row['hora_inicio']);
    $sql .= ' and h.nomerealizacao = '.aspa($row['nomerealizacao']);
    $sql .= ' and h.instrumento = '.aspa($row['instrumento']);
    $sql .= ' and h.codrealizacao = '.aspa($row['codigo_siacweb']);
    $sql .= " and h.abordagem = 'G'";
    $sql .= " and h.tiporealizacao = 'INS'";
    $rss = execsqlNomeCol($sql, true, $conSIAC);
    $rows = $rss->data[0];

    $sql = 'insert into tmp_checa_hist (idt_atendimento_pessoa, idt_evento, idt_instrumento, evento_siacweb, cpf,';
    $sql .= ' hora_inicio, concluio, descricao, cnpj, codigo, dap,';
    $sql .= ' nirf, rmp, ie_prod_rural, faturam, codconst,';
    $sql .= ' codrealizacao, hist_descricao, hist_cnpj, hist_codigo, hist_dap,';
    $sql .= ' hist_nirf, hist_rmp, hist_ie_prod_rural, hist_faturam, hist_codconst,';
    $sql .= ' siacweb_faturam, siacweb_codconst, pessoa, hist_cpf, hist_pessoa,';
    $sql .= ' matricula_siacweb, nomerealizacao, instrumento) values (';
    $sql .= null($row['idt_atendimento_pessoa']).', '.null($row['idt_evento']).', '.null($row['idt_instrumento']).', '.null($row['codigo_siacweb']).', '.aspa($row['cpf']).', ';
    $sql .= aspa($row['hora_inicio']).', '.aspa($row['evento_concluio']).', '.aspa($row['descricao']).', '.aspa($row['cnpj']).', '.aspa($row['codigo_siacweb_e']).', '.aspa($row['dap']).', ';
    $sql .= aspa($row['nirf']).', '.aspa($row['rmp']).', '.aspa($row['ie_prod_rural']).', '.aspa($row['faturam']).', '.aspa($row['codconst']).', ';
    $sql .= aspa($rows['codrealizacao']).', '.aspa($rows['descricao']).', '.aspa(FormataCNPJ($rows['codigo'])).', '.aspa($rows['codempreedimento']).', '.aspa($rows['dap']).', ';
    $sql .= aspa(FormataNirf($rows['nirf'])).', '.aspa($rows['rmp']).', '.aspa(FormataCNPJ($rows['ie_prod_rural'])).', '.aspa($rows['hist_faturam']).', '.aspa($rows['hist_codconst']).', ';
    $sql .= aspa($rows['siacweb_faturam']).', '.aspa($rows['siacweb_codconst']).', '.aspa($row['nome']).', '.aspa(FormataCPF12($rows['cgccpf'])).', '.aspa($rows['pessoa']).', ';
    $sql .= aspa($matricula_siacweb).', '.aspa($row['nomerealizacao']).', '.aspa($row['instrumento']).')';
    execsql($sql);
}
*/

$sql = '';
$sql .= " select p.idt as idt_atendimento_pessoa, a.idt_evento, e.idt_instrumento, p.siacweb_codcosultoria as codigo_siacweb, p.cpf, ea.siacweb_codatividade, p.evento_concluio,";
$sql .= ' o.razao_social as descricao, o.cnpj, o.codigo_siacweb_e, o.dap, o.nirf, o.rmp, o.ie_prod_rural, const.codigo as codconst, fat.codigo as faturam, p.nome';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
$sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
$sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
$sql .= ' inner join grc_evento_atividade ea on ea.idt_atendimento = a.idt';
$sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = a.idt ';
$sql .= ' left outer join '.db_pir_gec.'gec_entidade_tipo_emp const on const.idt = o.idt_tipo_empreendimento';
$sql .= ' left outer join '.db_pir_gec.'gec_organizacao_porte fat on fat.idt = o.idt_porte';
$sql .= ' where e.idt_evento_situacao = 20';
$sql .= " and ep.contrato in ('C', 'S', 'G')";
$sql .= ' and e.idt_instrumento = 2';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select h.codrealizacao, j.nomerazaosocial as descricao, j.cgccpf as codigo, dj.coddap as dap, dj.nirf, dj.codpescador as rmp, dj.inscest as ie_prod_rural,';
    $sql .= ' h.faturam as hist_faturam, h.codconst as hist_codconst, dj.faturam as siacweb_faturam, dj.codconst as siacweb_codconst, h.codempreedimento,';
    $sql .= ' p.cgccpf, p.nomerazaosocial as pessoa';
    $sql .= ' from historicorealizacoescliente h with(nolock)';
    $sql .= ' inner join parceiro p with(nolock) on p.codparceiro = h.codcliente';
    $sql .= ' left outer join parceiro j with(nolock) on j.codparceiro = h.CodEmpreedimento';
    $sql .= ' left outer join pessoaj dj with(nolock) on dj.codparceiro = h.CodEmpreedimento';
    $sql .= ' where h.codsebrae = 26';
    //$sql .= ' and p.cgccpf = '.null(preg_replace('/[^0-9]/i', '', $row['cpf']));
    $sql .= ' and h.codrealizacao = '.aspa($row['siacweb_codatividade']);
    $sql .= ' and h.codrealizacaocomp = '.aspa($row['codigo_siacweb']);
    $sql .= " and h.abordagem = 'I'";
    $sql .= " and h.tiporealizacao = 'CON'";
    $rss = execsqlNomeCol($sql, true, $conSIAC);
    $rows = $rss->data[0];

    $sql = 'insert into tmp_checa_hist (idt_atendimento_pessoa, idt_evento, idt_instrumento, evento_siacweb, cpf,';
    $sql .= ' hora_inicio, concluio, descricao, cnpj, codigo, dap,';
    $sql .= ' nirf, rmp, ie_prod_rural, faturam, codconst,';
    $sql .= ' codrealizacao, hist_descricao, hist_cnpj, hist_codigo, hist_dap,';
    $sql .= ' hist_nirf, hist_rmp, hist_ie_prod_rural, hist_faturam, hist_codconst,';
    $sql .= ' siacweb_faturam, siacweb_codconst, evento_ativ, pessoa, hist_cpf, hist_pessoa) values (';
    $sql .= null($row['idt_atendimento_pessoa']).', '.null($row['idt_evento']).', '.null($row['idt_instrumento']).', '.null($row['codigo_siacweb']).', '.aspa($row['cpf']).', ';
    $sql .= aspa($row['hora_inicio']).', '.aspa($row['evento_concluio']).', '.aspa($row['descricao']).', '.aspa($row['cnpj']).', '.aspa($row['codigo_siacweb_e']).', '.aspa($row['dap']).', ';
    $sql .= aspa($row['nirf']).', '.aspa($row['rmp']).', '.aspa($row['ie_prod_rural']).', '.aspa($row['faturam']).', '.aspa($row['codconst']).', ';
    $sql .= aspa($rows['codrealizacao']).', '.aspa($rows['descricao']).', '.aspa(FormataCNPJ($rows['codigo'])).', '.aspa($rows['codempreedimento']).', '.aspa($rows['dap']).', ';
    $sql .= aspa(FormataNirf($rows['nirf'])).', '.aspa($rows['rmp']).', '.aspa(FormataCNPJ($rows['ie_prod_rural'])).', '.aspa($rows['hist_faturam']).', '.aspa($rows['hist_codconst']).', ';
    $sql .= aspa($rows['siacweb_faturam']).', '.aspa($rows['siacweb_codconst']).', '.null($row['siacweb_codatividade']).', '.aspa($row['nome']).', '.aspa(FormataCPF12($rows['cgccpf'])).', '.aspa($rows['pessoa']).')';
    execsql($sql);
}

echo 'FIM...';
