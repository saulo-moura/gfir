<?php
die('travado...');

require_once '../configuracao.php';
require_once '../admin/funcao_atendimento.php';

ini_set('memory_limit', '2048M');

$sql = '';
$sql .= ' select distinct ev.*, pen.dt_update as dt_aprovado, ord.idt as idt_ordem, ord.codigo as codigo_ordem, pd.tipo_ordem, pen.idt_usuario_update';
$sql .= ' from db_pir_grc.grc_evento ev';
$sql .= ' left outer join db_pir_gec.gec_contratacao_credenciado_ordem ord on ord.idt_evento = ev.idt';
$sql .= ' left outer join db_pir_grc.grc_atendimento_pendencia pen on pen.idt_evento = ev.idt and pen.idt_evento_situacao_para = 14';
$sql .= ' left outer join '.db_pir_gec.'gec_programa pd on pd.idt = ev.idt_programa';
$sql .= " where (pen.dt_update is null or pen.dt_update >= '2016-04-02')";
$sql .= ' and ev.idt_evento_situacao in (14, 16)';
$sql .= ' and ord.idt is null';
$sql .= ' and (';
$sql .= "   (ev.cred_necessita_credenciado = 'S' and ev.cred_rodizio_auto = 'S')";
$sql .= '   or (';
$sql .= "     ev.cred_necessita_credenciado = 'S' and ev.cred_rodizio_auto = 'N'";
$sql .= "     and ev.cred_credenciado_sgc = 'S'";
$sql .= '   )';
$sql .= ' )';
$sql .= ' order by pen.dt_update';
$rs = execsql($sql);

foreach ($rs->data as $row) {
    $_SESSION[CS]['g_id_usuario'] = $row['idt_usuario_update'];

    echo $row['codigo'].': ';

    if ($row['tipo_ordem'] != 'SG') {
        $gera_ordem = false;
        $automatico = false;
        $usa_rodizio = true;

        if ($row['cred_necessita_credenciado'] == 'S' && $row['cred_rodizio_auto'] == 'S') {
            $gera_ordem = true;
            $automatico = true;
        }

        if ($row['cred_necessita_credenciado'] == 'S' && $row['cred_rodizio_auto'] == 'N' && $row['cred_credenciado_sgc'] == 'S') {
            $gera_ordem = true;
            $automatico = false;
        }

        //Não fazer rodizio em Produção
        //if (debug !== true) {
        $usa_rodizio = false;
        //}

        if ($gera_ordem) {
            beginTransaction();

            $variavel = array();
            echo 'gera ordem...<br>';
            $ret = GEC_contratacao_credenciado_ordem($row['idt'], $variavel, $automatico, $usa_rodizio, false);

            if ($variavel['erro'] == '') {
                commit();
            } else {
                rollBack();
                $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />'.$variavel['erro'];
                echo $variavel['erro'].'<br>';
            }
        }
    }

    echo '<br>';
}

echo 'FIM...';
