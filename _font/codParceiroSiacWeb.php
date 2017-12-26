<?php
ini_set('memory_limit', '1024M');

require_once '../configuracao.php';

$sql = '';
$sql .= ' select e.codigo_siacweb as codrealizacao, p.codigo_siacweb as codcliente, o.idt as idt_atendimento_organizacao,';
$sql .= ' o.codigo_siacweb_e as codempreendimento, e.data_criacao as dtinscricaoinicio, o.cnpj, p.codigo as cpf,';
$sql .= ' o.nirf, o.dap, o.rmp, o.ie_prod_rural, o.sicab_codigo,';
$sql .= ' s.idt_atendimento_pessoa, s.idt_evento, e.quantidade_participante, e.qtd_vagas_adicional';
$sql .= ' from grc_sincroniza_siac s';
$sql .= ' inner join grc_evento e on e.idt = s.idt_evento';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade p on p.idt = s.idt_entidade';
$sql .= ' left outer join grc_atendimento_organizacao o on o.idt_atendimento = s.idt_atendimento';
$sql .= ' where s.idt = 2657072';
$rs = execsql($sql);

foreach ($rs->data as $row) {
	p($row);
	$duplicado = '';
	$codparceiro = XcodParceiroSiacWeb('J', $duplicado, $row['cnpj'], $row['nirf'], $row['dap'], $row['rmp'], $row['ie_prod_rural'], $row['sicab_codigo']);
	var_dump($codparceiro);
	var_dump($duplicado);
}

function XcodParceiroSiacWeb($tipo_parceiro, &$duplicado, $cpfcnpj, $nirf = '', $dap = '', $rmp = '', $ie = '', $sicab_codigo = '') {
    $conSIAC = conSIAC();
    $codparceiro = '';
    $vetDuplicado = Array();
    $duplicado = '';

    if (!validaCPFCNPJ($cpfcnpj)) {
        $cpfcnpj = '';
    }

    $cpfcnpj = preg_replace('/[^0-9]/i', '', $cpfcnpj);
    $nirf = preg_replace('/[^0-9]/i', '', $nirf);

    if ($cpfcnpj != '') {
        $sql = '';
        $sql .= ' select codparceiro';
        $sql .= ' from parceiro (nolock)';
        $sql .= ' where cgccpf = ' . null($cpfcnpj);
        $sql .= ' and tipoparceiro = ' . aspa($tipo_parceiro);
        $sql .= ' order by situacao desc';
        $rs = execsql($sql, true, $conSIAC);
        $codparceiro = $rs->data[0][0];

        if ($rs->rows > 1) {
            foreach ($rs->data as $row) {
                $vetDuplicado[$row['codparceiro']] = $row['codparceiro'];
            }
        }
    }

    if ($tipo_parceiro == 'J' && $codparceiro == '') {
        $vetDados = Array();

        if ($dap != '') {
            $vetDados['coddap'] = $dap;
        }

        if ($rmp != '') {
            $vetDados['codpescador'] = $rmp;
        }

        if ($nirf != '') {
            $vetDados['nirf'] = $nirf;
        }

        if ($ie != '') {
            $vetDados['CodProdutorRural'] = $ie;
        }

        if ($sicab_codigo != '') {
            $vetDados['codsicab'] = preg_replace('/\./i', '', $sicab_codigo);
        }

        $codparceiro = XcodParceiroSiacWebPJ($vetDados, $vetDuplicado, $conSIAC);
    }

    if (count($vetDuplicado) > 0) {
        $duplicado = ' codParceiro: ' . implode(', ', $vetDuplicado);

        $des_registro = 'Regsitro duplicados no SiacWeb!';

        if ($cpfcnpj != '') {
            $des_registro .= ' CPF/CNPJ: ' . $cpfcnpj;
        }

        if ($dap != '') {
            $des_registro .= ' DAP: ' . $dap;
        }

        if ($rmp != '') {
            $des_registro .= ' RMP: ' . $rmp;
        }

        if ($nirf != '') {
            $des_registro .= ' NIRF: ' . $nirf;
        }

        if ($ie != '') {
            $des_registro .= ' IE: ' . $ie;
        }

        if ($sicab_codigo != '') {
            $des_registro .= ' SICAB: ' . $sicab_codigo;
        }

        $des_registro .= $duplicado;

        grava_log_sis('codParceiroSiacWeb', 'R', '', $des_registro, 'Pesquisa do Parceito no SiacWeb');
    }

    return $codparceiro;
}

function XcodParceiroSiacWebPJ($vetDados, &$vetDuplicado, $conSIAC) {
	p($vetDados);

    if (count($vetDados) == 0) {
        return '';
    }

    $codparceiro = '';

    $sql = '';
    $sql .= ' select codparceiro';
    $sql .= ' from pessoaj (nolock)';
    $sql .= ' where 1 = 1';

    foreach ($vetDados as $campo => $valor) {
        if ($codparceiro == '') {
            $vetDuplicado = Array();

            $sql_where = ' and ' . $campo . ' = ' . aspa($valor);
            $rs = execsql($sql . $sql_where, true, $conSIAC);
			p($sql . $sql_where);
			p($rs);

            if ($rs->rows == 1) {
                $codparceiro = $rs->data[0][0];
            } else if ($rs->rows > 1) {
                $sql .= $sql_where;

                if ($rs->rows > 1) {
                    foreach ($rs->data as $row) {
                        $vetDuplicado[$row['codparceiro']] = $row['codparceiro'];
                    }
                }
            }
        }
    }

    if ($codparceiro == '') {
        array_shift($vetDados);
        return XcodParceiroSiacWebPJ($vetDados, $vetDuplicado, $conSIAC);
    } else {
        return $codparceiro;
    }
}
