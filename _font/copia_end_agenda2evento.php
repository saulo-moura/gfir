<?php
require_once '../configuracao.php';
ini_set('memory_limit', '2048M');
set_time_limit(0);

beginTransaction();

$sql = '';
$sql .= ' select e.idt';
$sql .= ' from grc_evento e';
$sql .= ' where e.idt_instrumento <> 2';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select l.cep, l.logradouro, l.logradouro_numero, l.logradouro_complemento,';
    $sql .= ' end_b.descbairro as logradouro_bairro, end_c.desccid as logradouro_municipio, end_e.abrevest as logradouro_estado, end_p.descpais as logradouro_pais';
    $sql .= ' from grc_evento_agenda ea';
    $sql .= " inner join grc_evento_local_pa l on l.idt = ea.idt_local";
    $sql .= ' left outer join ' . db_pir_siac . 'bairro end_b on end_b.codbairro = l.logradouro_codbairro';
    $sql .= ' left outer join ' . db_pir_siac . 'cidade end_c on end_c.codcid = l.logradouro_codcid';
    $sql .= ' left outer join ' . db_pir_siac . 'estado end_e on end_e.codest = l.logradouro_codest';
    $sql .= ' left outer join ' . db_pir_siac . 'pais end_p on end_p.codpais = l.logradouro_codpais';
    $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
    $sql .= ' where ea.idt_evento = ' . null($row['idt']);
    $sql .= whereEventoParticipante();
    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
    $sql .= ' order by ea.dt_ini limit 1';
    $rsa = execsql($sql);
    $rowa = $rsa->data[0];

    $sql = '';
    $sql .= ' update grc_evento set';
    $sql .= ' cep = ' . aspa($rowa['cep']) . ',';
    $sql .= ' logradouro = ' . aspa($rowa['logradouro']) . ',';
    $sql .= ' logradouro_numero = ' . aspa($rowa['logradouro_numero']) . ',';
    $sql .= ' logradouro_complemento = ' . aspa($rowa['logradouro_complemento']) . ',';
    $sql .= ' logradouro_bairro = ' . aspa($rowa['logradouro_bairro']) . ',';
    $sql .= ' logradouro_municipio = ' . aspa($rowa['logradouro_municipio']) . ',';
    $sql .= ' logradouro_estado = ' . aspa($rowa['logradouro_estado']) . ',';
    $sql .= ' logradouro_pais = ' . aspa($rowa['logradouro_pais']);
    $sql .= ' where idt = ' . null($row['idt']);
    execsql($sql);
}

commit();

echo 'FIM...';
