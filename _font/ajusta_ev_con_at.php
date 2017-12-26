<?php
require_once '../configuracao.php';

ini_set('memory_limit', '-1');
set_time_limit(0);

beginTransaction();

$sql = '';
$sql .= ' select afp.idt_evento, ord_rm.mesano';
$sql .= ' from '.db_pir_pfo.'pfo_af_processo afp';
$sql .= ' inner join grc_evento e on e.idt = afp.idt_evento';
$sql .= ' inner join '.db_pir_gec."gec_contratacao_credenciado_ordem_rm ord_rm on ord_rm.rm_idmov = afp.idmov";
$sql .= ' where e.idt_instrumento = 2';
$sql .= " and e.tipo_sincroniza_siacweb = 'P'";
$sql .= " and afp.situacao_reg in ('NF', 'FI', 'ED', 'AP')";
$sql .= " and (afp.autorizar_nf_sem_doc = 'N' or afp.valida_nf_sem_doc = 'S')";
$rsAFP = execsqlNomeCol($sql);

foreach ($rsAFP->data as $rowAFP) {
    $dt_ini = '01/'.$rowAFP['mesano'];

    $vetDT = DatetoArray($dt_ini);

    $t = mktime(0, 0, 0, $vetDT['mes'], 1, $vetDT['ano']);
    $dt_fim = Date('d/m/Y', strtotime('+1 month', $t));

    $sql = '';
    $sql .= ' select ea.idt, ea.idt_atendimento';
    $sql .= ' from '.db_pir_grc.'grc_evento_atividade ea';
    $sql .= " inner join ".db_pir_grc."grc_atendimento a on a.idt = ea.idt_atendimento";
    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
    $sql .= ' where a.idt_evento = '.null($rowAFP['idt_evento']);
    $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
    $sql .= ' and ea.idt in (';
    $sql .= ' select ag.idt_evento_atividade';
    $sql .= ' from '.db_pir_grc.'grc_evento_agenda ag';
    $sql .= ' where ag.data_inicial >= '.aspa(trata_data($dt_ini));
    $sql .= ' and ag.data_inicial < '.aspa(trata_data($dt_fim));
    $sql .= ' )';
    $rs = execsql($sql);

    foreach ($rs->data as $row) {
        $sql = '';
        $sql .= ' select idt';
        $sql .= ' from grc_sincroniza_siac';
        $sql .= ' where idt_evento = '.null($rowAFP['idt_evento']);
        $sql .= ' and idt_evento_atividade = '.null($row['idt']);
        $sql .= " and tipo = 'EV_CON_AT'";
        $rst = execsql($sql);

        if ($rst->rows == 0) {
			$sql = "update grc_evento_atividade set consolidado_cred = 'S'";
			$sql .= ' where idt = '.null($row['idt']);
			execsql($sql);

			$sql = '';
			$sql .= ' update grc_evento_agenda set';
			$sql .= ' data_inicial_real = data_inicial, ';
			$sql .= ' hora_inicial_real = hora_inicial, ';
			$sql .= ' dt_ini_real = dt_ini, ';
			$sql .= ' data_final_real = data_final, ';
			$sql .= ' hora_final_real = hora_final, ';
			$sql .= ' dt_fim_real = dt_fim, ';
			$sql .= ' carga_horaria_real = carga_horaria';
			$sql .= ' where idt_atendimento = '.null($row['idt_atendimento']);
			$sql .= ' and data_inicial_real is null';
			execsql($sql);

            $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_atividade, tipo, refeito) values (';
            $sql .= null($row['idt_atendimento']).', '.null($rowAFP['idt_evento']).', '.null($row['idt']).", 'EV_CON_AT', 'A')";
            execsql($sql);
        }
    }
}

commit();

echo 'FIM...';
