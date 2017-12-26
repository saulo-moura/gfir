<?php
require_once 'configuracao.php';

$conSIAC = conSIAC();

ini_set('memory_limit', '-1');
set_time_limit(0);

$sql = '';
$sql .= ' select a.idt as idt_atendimento, a.siacweb_codcosultoria as codconsultoria';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
$sql .= ' where a.siacweb_codcosultoria is not null';
$sql .= ' and p.siacweb_codparticipantecosultoria is null';
$sql .= ' group by a.idt, a.siacweb_codcosultoria';
$rs = execsqlNomeCol($sql);

foreach ($rs->data as $row) {
    beginTransaction();
    beginTransaction($conSIAC);

    //Participantes
    $sql = '';
    $sql .= ' select p.idt as idt_atendimento_pessoa, p.codigo_siacweb as codpessoaf,';
    $sql .= ' o.codigo_siacweb_e as codpessoaj, p.cpf, o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.cnpj, p.nome, o.razao_social,';
    $sql .= ' o.idt as idt_atendimento_organizacao';
    $sql .= ' from grc_atendimento_pessoa p';
    $sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = p.idt_atendimento';
    $sql .= ' where p.idt_atendimento = '.null($row['idt_atendimento']);
    $sql .= ' and p.siacweb_codparticipantecosultoria is null';
    $rs_p = execsqlNomeCol($sql);

    foreach ($rs_p->data as $row_p) {
        $regOK = true;

        $duplicadoF = '';
        $codparceiro = codParceiroSiacWeb($row_p['codpessoaf'], 'F', $duplicadoF, $row_p['cpf']);

        if ($row_p['codpessoaf'] != $codparceiro && $codparceiro != '') {
            updateCodSiacweb($row_p['codpessoaf'], $codparceiro, 'F');
            $row_p['codpessoaf'] = $codparceiro;
        }

        $duplicadoJ = '';
        $codparceiro = codParceiroSiacWeb($row_p['codpessoaj'], 'J', $duplicadoJ, $row_p['cnpj'], $row_p['nirf'], $row_p['dap'], $row_p['rmp'], $row_p['ie_prod_rural']);

        if ($row_p['codpessoaj'] != $codparceiro && $codparceiro != '') {
            updateCodSiacweb($row_p['codpessoaj'], $codparceiro, 'J');
            $row_p['codpessoaj'] = $codparceiro;
        }

        if ($duplicadoF == '' && $duplicadoJ == '') {
            if (substr($row_p['codpessoaf'], 0, 2) == '99') {
                $parametro = Array(
                    'en_Cpf' => preg_replace('/[^0-9]/i', '', $row_p['cpf']),
                );

                $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosPessoaFisica', $parametro, 'Table', true);
                $rowResult = $SebareResult->data[0];

                if ($rowResult['codparceiro'] != '') {
                    updateCodSiacweb($row_p['codpessoaf'], $rowResult['codparceiro'], 'F');

                    $row_p['codpessoaf'] = $rowResult['codparceiro'];
                }
            }

            if ($row_p['codpessoaf'] == '' || substr($row_p['codpessoaf'], 0, 2) == '99') {
                $regOK = false;
            }

            if (substr($row_p['codpessoaj'], 0, 2) == '99') {
                $parametro = Array(
                    'en_CgcCpf' => preg_replace('/[^0-9]/i', '', $row_p['cnpj']),
                    'en_Email' => '',
                    'en_CPR' => '',
                );

                $SebareResult = $SebraeSIACcad->executa('Util_Rec_DadosEmpreendimento', $parametro, 'Table', true);
                $rowResult = $SebareResult->data[0];

                if ($rowResult['codparceiro'] != '') {
                    updateCodSiacweb($row_p['codpessoaj'], $rowResult['codparceiro'], 'J');

                    $row_p['codpessoaj'] = $rowResult['codparceiro'];
                }
            }

            if ($row_p['idt_atendimento_organizacao'] != '' && ($row_p['codpessoaj'] == '' || substr($row_p['codpessoaj'], 0, 2) == '99')) {
                $regOK = false;
            }

            if ($regOK) {
                $vetBindParam = Array();
                $vetBindParam['CodConsultoria'] = vetBindParam($row['codconsultoria'], PDO::PARAM_INT);
                $vetBindParam['CodPessoaF'] = vetBindParam($row_p['codpessoaf'], PDO::PARAM_INT);
                $vetBindParam['CodPessoaJ'] = vetBindParam($row_p['codpessoaj'], PDO::PARAM_INT);

                $sql = 'ConsInserirConsultoriaParticipantes';

                execsql($sql, true, $conSIAC, $vetBindParam);
                $row_p['siacweb_codparticipantecosultoria'] = lastInsertId('CONS_CONSULTORIAPARTICIPANTE', $conSIAC);

                $sql = "update grc_atendimento_pessoa set evento_inscrito = 'S', siacweb_codparticipantecosultoria = ".null($row_p['siacweb_codparticipantecosultoria']);
                $sql .= ' where idt = '.null($row_p['idt_atendimento_pessoa']);
                execsql($sql);

                $sql = "update grc_evento set qtd_matriculado_siacweb = qtd_matriculado_siacweb + 1, qtd_vagas_resevado = qtd_vagas_resevado - 1";
                $sql .= " where idt = ".null($row_siac['idt_evento']);
                execsql($sql);
            }
        }
    }

    commit();
    commit($conSIAC);
}

echo 'FIM...';
