<?php
require_once '../configuracao.php';
ini_set('memory_limit', '2048M');
set_time_limit(0);

rever logica
pois so pode alterar a agenda e atividade

beginTransaction();

$sql = "update grc_evento set tipo_sincroniza_siacweb = 'LHN' where idt_instrumento = 2";
execsql($sql);

//Duplica Agenda
$sql = '';
$sql .= ' select distinct ea.idt_evento';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_evento_agenda ea on ea.idt_evento = e.idt';
$sql .= ' where e.idt_instrumento = 2';
$sql .= ' and ea.idt_atendimento is null';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select a.idt as idt_atendimento';
    $sql .= ' from grc_evento e';
    $sql .= ' inner join grc_atendimento a on a.idt_evento = e.idt';
    $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
    $sql .= ' where e.idt = '.null($row['idt_evento']);
    $sql .= " and ep.contrato <> 'IC'";
    $rsp = execsql($sql);

    if ($rs->rows > 0) {
        foreach ($rsp->data as $rowp) {
            $sql = 'insert into grc_evento_agenda (idt_evento, idt_atendimento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, idt_evento_atividade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg, data_inicial_real, hora_inicial_real, dt_ini_real, data_final_real, hora_final_real, dt_fim_real, obs_real, carga_horaria_real)';
            $sql .= ' select idt_evento, '.$rowp['idt_atendimento'].' as idt_atendimento, tipo_agenda, codigo, nome_agenda, ativo, observacao, data_inicial, hora_inicial, dt_ini, data_final, hora_final, dt_fim, dia_extenso, dia_abreviado, carga_horaria, quantidade_horas_mes, idt_local, idt_cidade, idt_evento_atividade, atividade, valor_hora, idt_tema, idt_subtema, competencia, alocacao_disponivel, alocacao_msg, data_inicial_real, hora_inicial_real, dt_ini_real, data_final_real, hora_final_real, dt_fim_real, obs_real, carga_horaria_real';
            $sql .= ' from grc_evento_agenda';
            $sql .= ' where idt_evento = '.null($row['idt_evento']);
            $sql .= ' and idt_atendimento is null';
            execsql($sql);
        }

        $sql = 'delete from grc_evento_agenda';
        $sql .= ' where idt_evento = '.null($row['idt_evento']);
        $sql .= ' and idt_atendimento is null';
        execsql($sql);
    }
    
    $sql = "update grc_evento set tipo_sincroniza_siacweb = 'LHR'";
    $sql .= ' where idt = '.null($row['idt_evento']);
    execsql($sql);
}

$sql = "update grc_evento set tipo_sincroniza_siacweb_old = tipo_sincroniza_siacweb where idt_instrumento = 2";
execsql($sql);

$sql = "update grc_evento set tipo_sincroniza_siacweb = 'P' where idt_instrumento = 2 and idt_evento_situacao in (1, 5)";
execsql($sql);

//Cria a Atividade
$sql = '';
$sql .= ' select ea.idt, ea.idt_evento, ea.idt_atendimento, ea.atividade';
$sql .= ' from grc_evento e';
$sql .= ' inner join grc_evento_agenda ea on ea.idt_evento = e.idt';
$sql .= ' where e.idt_instrumento = 2';
$sql .= ' and ea.idt_evento_atividade is null';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select idt';
    $sql .= ' from grc_evento_atividade';
    $sql .= ' where cod_atividade = '.aspa(md5($row['atividade']));
    $sql .= ' and idt_evento = '.null($row['idt_evento']);
    $sql .= ' and idt_atendimento = '.null($row['idt_atendimento']);
    $rs_ea = execsql($sql);
    $idt_evento_atividade = $rs_ea->data[0][0];

    if ($idt_evento_atividade == '') {
        $sql = '';
        $sql .= ' insert into grc_evento_atividade (idt_evento, idt_atendimento, cod_atividade, atividade, consolidado_cred) values (';
        $sql .= null($row['idt_evento']).', '.null($row['idt_atendimento']).', '.aspa(md5($row['atividade'])).', '.aspa($row['atividade']).", 'S')";
        execsql($sql);
        $idt_evento_atividade = lastInsertId();
    }

    $sql = '';
    $sql .= ' update grc_evento_agenda set';
    $sql .= ' idt_evento_atividade = '.null($idt_evento_atividade).', ';
    $sql .= ' data_inicial_real = data_inicial, ';
    $sql .= ' hora_inicial_real = hora_inicial, ';
    $sql .= ' dt_ini_real = dt_ini, ';
    $sql .= ' data_final_real = data_final, ';
    $sql .= ' hora_final_real = hora_final, ';
    $sql .= ' dt_fim_real = dt_fim, ';
    $sql .= ' carga_horaria_real = carga_horaria';
    $sql .= ' where idt = '.null($row['idt']);
    execsql($sql);
}

//Ajusta registro de sincronização
$sql = '';
$sql .= ' delete from grc_sincroniza_siac';
$sql .= ' where idt_evento in (';
$sql .= ' select idt';
$sql .= ' from grc_evento e';
$sql .= ' where idt_instrumento = 2';
$sql .= ' )';
$sql .= " and tipo in ('EP', 'EP_EXC')";
execsql($sql);

commit();

echo 'FIM...';
