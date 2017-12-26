<?php
require_once '../configuracao.php';

//ini_set('memory_limit', '-1');
set_time_limit(0);

$sql = '';
$sql .= ' select a.idt, a.protocolo, a.idt_nan_tutor, a.idt_projeto_acao, a.idt_consultor, u.nome_completo';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
$sql .= " inner join plu_usuario u on u.id_usuario = a.idt_consultor ";
$sql .= ' where (';
$sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
$sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
$sql .= ' )';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    $sql = '';
    $sql .= ' select et.idt_usuario as idt_nan_tutor, u.nome_completo';
    $sql .= ' from grc_nan_estrutura e';
    $sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
    $sql .= " inner join plu_usuario u on u.id_usuario = et.idt_usuario ";
    $sql .= ' where e.idt_usuario = '.null($row['idt_consultor']);
    $sql .= ' and e.idt_acao = '.null($row['idt_projeto_acao']);
    $sql .= ' and e.idt_nan_tipo = 6';
    $sql .= " and e.ativo = 'S'";
    $rst = execsqlNomeCol($sql);
    $rowt = $rst->data[0];

    if ($rowt['idt_nan_tutor'] != $row['idt_nan_tutor'] && $rst->rows == 1) {
        beginTransaction();
        
        $sql = 'update grc_atendimento set idt_nan_tutor = '.null($rowt['idt_nan_tutor']);
        $sql .= ' where idt = '.null($row['idt']);
        execsql($sql);

        $sql = 'update grc_atendimento_pendencia set idt_gestor_local = '.null($rowt['idt_nan_tutor']);
        $sql .= ', idt_responsavel_solucao = '.null($rowt['idt_nan_tutor']);
        $sql .= ' where idt_atendimento = '.null($row['idt']);
        $sql .= " and ativo = 'S'";
        execsql($sql);

        $vetLogDetalhe = Array();
        $vetLogDetalhe['idt_nan_tutor']['campo_desc'] = 'Tutor';
        $vetLogDetalhe['idt_nan_tutor']['vl_ant'] = $row['idt_nan_tutor'];
        $vetLogDetalhe['idt_nan_tutor']['desc_ant'] = $row['nome_completo'];
        $vetLogDetalhe['idt_nan_tutor']['vl_atu'] = $rowt['idt_nan_tutor'];
        $vetLogDetalhe['idt_nan_tutor']['desc_atu'] = $rowt['nome_completo'];

        grava_log_sis('grc_atendimento', 'A', $row['idt'], $row['protocolo'], 'Troca de Tutor (Ajuste)', '', $vetLogDetalhe, true);
        
        commit();
    }
}

echo 'FIM...';
