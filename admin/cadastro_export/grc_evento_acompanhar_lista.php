<?php
$idxRow = 1;
$diaLinha = 5;

if (!function_exists('ftd_idx')) {

    function ftd_idx($valor, $row, $campo) {
        global $idxRow;

        if ($row['contrato'] != 'IC') {
            return $idxRow++;
        }
    }

    function ftd_contrato($valor, $row, $campo, $idxLinha, $qtdLinha) {
        global $vetEventoContrato, $diaLinha;

        $html = '';

        switch ($campo) {
            case 'contrato':
                $html .= $vetEventoContrato[$valor];

                if ($row['contrato'] == 'IC') {
                    if ($row['motivo_cancelamento'] != '') {
                        $html .= '<br>' . $row['motivo_cancelamento'];
                    }

                    if ($row['justificativa_cancelamento'] != '') {
                        $html .= '<br>' . $row['justificativa_cancelamento'];
                    }
                }
                break;

            case 'nome':
                if ($_REQUEST['titulo_rel'] == 'LPB') {
                    $html .= '<br /><br /><hr>';
                } else {
                    $html .= '<b>' . $valor . '</b>';

                    if ($row['contrato'] == 'IC') {
                        $html .= '<br />[Cancelado]';
                    }
                }
                break;

            case 'assinatura':
                $dia = $idxLinha * $diaLinha;

                $html .= '<table><tr>';

                for ($index = 0; $index < $qtdLinha; $index++) {
                    $dia++;
                    $html .= '<td><br /><hr>' . $dia . 'º dia</td>';
                }

                $html .= '</tr></table>';

                break;

            default:
                if ($_REQUEST['titulo_rel'] == 'LPB') {
                    $html .= '<br /><br /><hr>';
                } else {
                    $html .= $valor;
                }
                break;
        }

        return $html;
    }

    function ListarRegistros($sql, $vetCampo, $titulo, $qtd_linha_vazia = 0, $uppertxtcab = true) {
        global $vetLinha;

        $rs = execsqlNomeCol($sql);

        foreach ($vetLinha as $idxLinha => $qtdLinha) {
            if ($idxLinha > 0) {
                echo '<div style="page-break-after: always;"></div>';
            }

            if ($titulo != '') {
                echo '<div class="tit">' . $titulo . '</div>';
            }

            echo '<table class="tabela">';
            echo '<thead>';
            echo '<tr class="gridTOP">';

            ForEach ($vetCampo as $Campo => $Valor) {
                echo '<td class="cT">';

                if ($uppertxtcab) {
                    echo mb_strtoupper($Valor['nome'], "ISO-8859-1");
                } else {
                    echo $Valor['nome'];
                }

                echo '</td>';
            }

            echo '</tr>';
            echo '</thead>';

            foreach ($rs->data as $i => $row) {
                echo '<tr class="gridTR">';

                ForEach ($vetCampo as $strCampo => $Valor) {
                    echo '<td class="cD ' . $strCampo . '">';

                    $tipo = explode(", ", $Valor['tipo']);
                    $strCampo = explode(", ", $strCampo);

                    $vlTD = '';
                    ForEach ($strCampo as $idx => $Campo) {
                        if (count($strCampo) > 1 && $idx > 0) {
                            $vlTD .= ' ';
                        }

                        switch ($tipo[$idx]) {
                            case 'descDominio':
                                if (count($strCampo) == 1) {
                                    if ($Valor['vetDominio'][$row[$Campo]] == '')
                                        $vlTD .= $row[$Campo];
                                    else
                                        $vlTD .= $Valor['vetDominio'][$row[$Campo]];
                                } else {
                                    if ($Valor['vetDominio'][$idx][$row[$Campo]] == '')
                                        $vlTD .= $row[$Campo];
                                    else
                                        $vlTD .= $Valor['vetDominio'][$idx][$row[$Campo]];
                                }
                                break;

                            case 'data':
                                $vlTD .= trata_data($row[$Campo]);
                                break;

                            case 'decimal':
                                $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                                break;

                            case 'inteiro':
                                $vlTD .= format_decimal($row[$Campo], 0);
                                break;

                            case 'arquivo':
                                $vlTD .= '';
                                $path = $dir_file . '/' . $Valor['tabela'] . '/';
                                $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', false, true);

                                break;

                            case 'arquivo_link':
                                $vlTD .= '';
                                $path = $dir_file . '/' . $Valor['tabela'] . '/';

                                $vlTD .= ArquivoLink($path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', '', '', true);
                                break;

                            case 'link':
                                $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                                $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>" . $row[$Campo] . "</a>";
                                $stx .= "</span>";
                                $vlTD .= $stx;
                                break;


                            case 'func_trata_dado':
                                $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo, $idxLinha, $qtdLinha);
                                break;

                            default:
                                $vlTD .= $row[$Campo];
                                break;
                        }
                    }

                    echo $vlTD . '</td>';
                }

                echo '</tr>';
            }

            $row = array();

            for ($index = 0; $index < $qtd_linha_vazia; $index++) {
                echo '<tr class="gridTR vazioTR">';

                ForEach ($vetCampo as $strCampo => $Valor) {
                    echo '<td class="cD ' . $strCampo . '">';

                    $tipo = explode(", ", $Valor['tipo']);
                    $strCampo = explode(", ", $strCampo);

                    $vlTD = '';
                    ForEach ($strCampo as $idx => $Campo) {
                        if (count($strCampo) > 1 && $idx > 0) {
                            $vlTD .= ' ';
                        }

                        switch ($tipo[$idx]) {
                            case 'descDominio':
                                if (count($strCampo) == 1) {
                                    if ($Valor['vetDominio'][$row[$Campo]] == '')
                                        $vlTD .= $row[$Campo];
                                    else
                                        $vlTD .= $Valor['vetDominio'][$row[$Campo]];
                                } else {
                                    if ($Valor['vetDominio'][$idx][$row[$Campo]] == '')
                                        $vlTD .= $row[$Campo];
                                    else
                                        $vlTD .= $Valor['vetDominio'][$idx][$row[$Campo]];
                                }
                                break;

                            case 'data':
                                $vlTD .= trata_data($row[$Campo]);
                                break;

                            case 'decimal':
                                $vlTD .= format_decimal($row[$Campo], $Valor['ndecimal']);
                                break;

                            case 'inteiro':
                                $vlTD .= format_decimal($row[$Campo], 0);
                                break;

                            case 'arquivo':
                                $vlTD .= '';
                                $path = $dir_file . '/' . $Valor['tabela'] . '/';
                                $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', false, true);

                                break;

                            case 'arquivo_link':
                                $vlTD .= '';
                                $path = $dir_file . '/' . $Valor['tabela'] . '/';

                                $vlTD .= ArquivoLink($path, $row[$Campo], $row[$idCampo] . '_' . $Campo . '_', '', '', true);
                                break;

                            case 'link':
                                $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                                $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>" . $row[$Campo] . "</a>";
                                $stx .= "</span>";
                                $vlTD .= $stx;
                                break;


                            case 'func_trata_dado':
                                $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo, $idxLinha, $qtdLinha);
                                break;

                            default:
                                $vlTD .= $row[$Campo];
                                break;
                        }
                    }

                    echo $vlTD . '</td>';
                }

                echo '</tr>';
            }

            echo '</table>';
        }

        unset($sql);
        unset($rs);
        unset($row);
        unset($vetCampo);
        unset($titulo);
    }

}

$sql = '';
$sql .= ' select e.codigo, e.descricao, e.idt_produto, s.descricao as unidade, e.quantidade_participante, e.frequencia_min,';
$sql .= ' e.cep, e.logradouro, e.logradouro_numero, e.logradouro_complemento, e.logradouro_bairro, e.logradouro_municipio, e.logradouro_estado, e.logradouro_pais';
$sql .= ' from ' . db_pir_grc . 'grc_evento e';
$sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao s on s.idt = e.idt_unidade';
$sql .= ' where e.idt = ' . null($_REQUEST['id']);
$rs = execsqlNomeCol($sql);
$rowDados = $rs->data[0];

$sql = '';
$sql .= ' select ac.descricao';
$sql .= ' from grc_produto_area_conhecimento pac';
$sql .= ' inner join ' . db_pir_gec . 'gec_area_conhecimento ac on ac.idt = pac.idt_area';
$sql .= ' where pac.idt_produto = ' . null($rowDados['idt_produto']);
$sql .= " and pac.ativo = 'S'";
$sql .= ' order by ac.descricao';
$rs = execsqlNomeCol($sql);

$vetTmp = Array();

foreach ($rs->data as $row) {
    $vetTmp[] = $row['descricao'];
}

$area_produto = implode(', ', $vetTmp);

$sql = "select count(grc_at.idt) as tot";
$sql .= " from grc_atendimento grc_at  ";
$sql .= " left  join grc_evento_participante grc_evpa on grc_evpa.idt_atendimento = grc_at.idt ";
$sql .= " where grc_at.idt_evento = " . null($_REQUEST['id']);
$sql .= whereEventoParticipante('grc_evpa');
$rs = execsql($sql);
$tot_inscrito = $rs->data[0][0];

if ($_REQUEST['titulo_rel'] == 'LPB') {
    $qtd_linha_vazia = $rowDados['quantidade_participante'];
} else {
    if ($_REQUEST['linha_vazia'] == 'S') {
        $qtd_linha_vazia = $rowDados['quantidade_participante'] - $tot_inscrito;
    } else {
        $qtd_linha_vazia = 0;
    }
}

$sql = '';
$sql .= " select ord_lste.nome_pessoa, pf.descricao";
$sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem ord";
$sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista ord_lst on ord_lst.idt_gec_contratacao_credenciado_ordem = ord.idt";
$sql .= " left outer join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ord_lste on ord_lste.idt_gec_contratacao_credenciado_ordem_lista = ord_lst.idt and ord_lste.idt_organizacao = ord_lst.idt_organizacao";
$sql .= " left outer join " . db_pir_gec . "gec_entidade pf on pf.idt = ord_lst.idt_primeiro";
$sql .= ' where ord.idt_evento = ' . null($_REQUEST['id']);
$sql .= " and ord.ativo = 'S'";
$sql .= " and ord_lst.ativo = 'S'";
$rs = execsqlNomeCol($sql);

$vetTmp = Array();

foreach ($rs->data as $row) {
    if ($row['descricao'] == '') {
        $vetTmp[] = $row['nome_pessoa'];
    } else {
        $vetTmp[] = $row['descricao'];
    }
}

$instrutor = implode(', ', $vetTmp);

$sql = '';
$sql .= ' select count(distinct ea.data_inicial) as qtd, min(ea.dt_ini) as ini, max(ea.dt_fim) as fim';
$sql .= ' from grc_evento_agenda ea';
$sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
$sql .= ' where ea.idt_evento = ' . null($_REQUEST['id']);
$sql .= whereEventoParticipante();
$rs = execsqlNomeCol($sql);
$row_agenda = $rs->data[0];

$vetLinha = Array();

if ($_REQUEST['titulo_rel'] == 'RB') {
    $vetLinha[] = '';
} else {
    $qtdDias = $row_agenda['qtd'];
    $qtdDias = 13;

    $ult = $qtdDias % $diaLinha;
    $qtd = ($qtdDias - $ult) / $diaLinha;

    for ($index = 0; $index < $qtd; $index++) {
        $vetLinha[] = $diaLinha;
    }

    if ($ult > 0) {
        $vetLinha[] = $ult;
    }
}
?>
<style type="text/css">
    div.tit {
        text-align: center;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
        color: white;
        background-color: #2f66b8;
    }

    .bold {
        font-weight: bold;
    }

    table.tabela {
        width: 100%;
        border: none;
        border-spacing: 0px;
    }

    table.tabela tr td {
        font-size: 11px;
        padding: 0px 10px;
    }

    table.tabela tr td.cT {
        font-weight: bold;
        color: #4367a3;
        background-color: #aebddc;
    }

    table.tabela tr.gridTR > td {
        border-bottom: 1px solid #aebddc;
    }

    table.tabela tr.gridTOP > td.cT,
    table.tabela tr.gridTR > td.cT {
        width: auto;
    }

    table.tabela tr.gridTOP > td,
    table.tabela tr.gridTR > td {
        font-size: 10px;
    }

    table.tabela tr.vazioTR td {
        height: 40px;
    }

    table.tab_tit {
        width: 100%;
        border: none;
        border-spacing: 0px;
    }

    table.tab_tit tr td {
        font-size: 11px;
        padding: 5px 10px;
    }

    table.box {
        width: auto;
        border: none;
        border-spacing: 0px;
    }

    table.box tr td {
        padding: 5px;
        border: 1px solid #405e90;
    }

    .tdFecha {
        border-top: 1px solid #cbc9d6;
        border-bottom: 1px solid #cbc9d6;
    }

    td.idx {
        width: 20px;
    }

    td.assinatura {
        padding: 0px;
        width: 60%;
    }

    td.assinatura table {
        width: 100%;
        border: none;
        border-spacing: 0px;
    }

    td.assinatura table tr td {
        font-size: 10px;
        padding: 5px 10px;
        border: none;
    }

    hr {
        border: none;
        height: 1px;
        background-color: black;
    }
</style>
<?php
$header = '';
$header .= '<img src="imagens/evento_lista_presenca_topo.jpg"/>';
$header .= '</div>';
$header .= '<table class="tab_tit">';
$header .= '<tr>';
$header .= '<td colspan="3">Evento</td>';
$header .= '<td rowspan="6">';
$header .= '<table class="box"><tr><td>';
$header .= 'Início do Evento:<br />';
$header .= '<span class="bold">' . trata_data($row_agenda['ini']) . '</span><br />';
$header .= '<br />';
$header .= 'Fim do Evento:<br />';
$header .= '<span class="bold">' . trata_data($row_agenda['fim']) . '</span><br />';
$header .= '</td></tr></table>';
$header .= '</td>';
$header .= '<td rowspan="4" width="400">';
$header .= 'O participante deverá ter ' . $rowDados['frequencia_min'] . '% de frequência para receber o certificado.<br />';
$header .= 'Favor conferir seu nome, pois os certificados serão impressos conforme a lista de presença.';
$header .= '</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td class="bold" colspan="3">' . $rowDados['codigo'] . ' - ' . $rowDados['descricao'] . '</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td>Área do produto</td>';
$header .= '<td>Regional</td>';
$header .= '<td>Instrutor(a)</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td class="bold">' . $area_produto . '</td>';
$header .= '<td class="bold">' . $rowDados['unidade'] . '</td>';
$header .= '<td class="bold">' . $instrutor . '</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td colspan="3">Local do Evento</td>';
$header .= '<td rowspan="2" style="text-align: right">';
$header .= '<table class="box"><tr><td>';
$header .= 'Total de inscritos: ' . format_decimal($tot_inscrito, 0);
$header .= '</td></tr></table>';
$header .= '</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td class="bold" colspan="3">';
$header .= $rowDados['logradouro'] . ', ' . $rowDados['logradouro_numero'] . ', ' . $rowDados['logradouro_complemento'] . ', ';
$header .= $rowDados['cep'] . ', ' . $rowDados['logradouro_bairro'] . ', ' . $rowDados['logradouro_municipio'] . ', ' . $rowDados['logradouro_estado'];
$header .= '</td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td colspan="5"></td>';
$header .= '</tr>';
$header .= '<tr>';
$header .= '<td class="tdFecha" colspan="5"></td>';
$header .= '</tr>';
$header .= '</table>';

$footer = '';
$footer .= '<div style="text-align: right; font-size: 11px;">';
$footer .= 'Página {PAGENO} / {nbpg}';
$footer .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$footer .= 'Emissão da Lista: ' . date('d/m/Y') . ' ' . (date('H') - date('I')) . ':' . date('i');
$footer .= '</div>';

$ME = 5;
$MD = 5;
$MS = 93;
$MB = 10;
$MHEADER = 3;
$MFOOTER = 5;

$mpdf = new mPDF('win-1252', 'A4-L', '10', '', $ME, $MD, $MS, $MB, $MHEADER, $MFOOTER, 'L');

$header = utf8_encode($header);
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($header, 'E');

$footer = utf8_encode($footer);
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footer, 'E');

$titulo = '';
$vetCampoLC = Array();

if ($_REQUEST['titulo_rel'] == 'RB') {
    $vetCampoLC['idx'] = CriaVetTabela('', 'func_trata_dado', ftd_idx);
    $vetCampoLC['nome'] = CriaVetTabela('Nome', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['cpf'] = CriaVetTabela('CPF', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['cnpj'] = CriaVetTabela('CNPJ', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['contrato'] = CriaVetTabela('Contrato', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['evento_concluio'] = CriaVetTabela('Concluinte', 'descDominio', $vetSimNao);
} else {
    $vetCampoLC['nome'] = CriaVetTabela('Nome', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['cpf'] = CriaVetTabela('CPF', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['cnpj'] = CriaVetTabela('CNPJ', 'func_trata_dado', ftd_contrato);
    $vetCampoLC['assinatura'] = CriaVetTabela('Assinaturas Diárias', 'func_trata_dado', ftd_contrato);
}

$sql = "select ";
$sql .= "       grc_atpe.nome, grc_atpe.cpf,";
$sql .= "       grc_ator.cnpj,";
$sql .= "       grc_evpa.contrato,";
$sql .= "       grc_evpa.motivo_cancelamento,";
$sql .= "       grc_evpa.justificativa_cancelamento,";
$sql .= "       grc_atpe.evento_concluio";
$sql .= " from grc_atendimento grc_at  ";
$sql .= " left  join grc_atendimento_pessoa            grc_atpe on grc_atpe.idt_atendimento = grc_at.idt ";
$sql .= " left  join grc_atendimento_organizacao       grc_ator on grc_ator.idt_atendimento = grc_at.idt ";
$sql .= " left  join grc_evento_participante           grc_evpa on grc_evpa.idt_atendimento = grc_at.idt ";
$sql .= " where grc_at.idt_evento = " . null($_REQUEST['id']);
$sql .= " and (grc_evpa.ativo is null or grc_evpa.ativo = 'S')";

if ($_REQUEST['titulo_rel'] == 'LPB') {
    $sql .= ' and 1 = 0';
} else {
    if (is_array($_REQUEST['contrato'])) {
        $sql .= " and grc_evpa.contrato in (" . implode(', ', array_map('aspa', $_REQUEST['contrato'])) . ')';
    } else {
        $sql .= ' and 1 = 0';
    }

    switch ($_REQUEST['concluio']) {
        case 'S':
            $sql .= " and grc_atpe.evento_concluio = 'S'";
            break;

        case 'N':
            $sql .= " and (grc_atpe.evento_concluio is null or grc_atpe.evento_concluio = 'N')";
            break;
    }
}

$sql .= " order by grc_atpe.nome";

ListarRegistros($sql, $vetCampoLC, $titulo, $qtd_linha_vazia);
