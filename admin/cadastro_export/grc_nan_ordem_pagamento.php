<?php

function ListarRegistros($sql, $vetCampo, $titulo, $uppertxtcab = true) {
    $rs = execsqlNomeCol($sql);

    if ($titulo != '') {
        echo '<div class="tit">'.$titulo.'</div>';
    }

    echo '<table class="tabela">';
    echo '<tr class="gridTOP">';

    ForEach ($vetCampo as $Campo => $Valor) {
        echo '<td class="cT">';

        if ($uppertxtcab) {
            echo mb_strtoupper($Valor['nome']);
        } else {
            echo $Valor['nome'];
        }

        echo '</td>';
    }

    echo '</tr>';

    foreach ($rs->data as $i => $row) {
        echo '<tr class="gridTR">';

        ForEach ($vetCampo as $strCampo => $Valor) {
            $tipo = explode(", ", $Valor['tipo']);
            $strCampo = explode(", ", $strCampo);

            echo '<td class="cD">';

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
                        $path = $dir_file.'/'.$Valor['tabela'].'/';
                        $vlTD .= ImagemProdListarConf($Valor['vetDominio'], $path, $row[$Campo], $row[$idCampo].'_'.$Campo.'_', false, true);

                        break;

                    case 'arquivo_link':
                        $vlTD .= '';
                        $path = $dir_file.'/'.$Valor['tabela'].'/';

                        $vlTD .= ArquivoLink($path, $row[$Campo], $row[$idCampo].'_'.$Campo.'_', '', '', true);
                        break;

                    case 'link':
                        $stx = "<span style='color:#0080C0; text-decoration:none;'>";
                        $stx .= "<a href='$row[$Campo]' target='_blank' style='font-size:13px; font-weight: bold; cursor:pointer; color:#0080C0; text-decoration:none;'>".$row[$Campo]."</a>";
                        $stx .= "</span>";
                        $vlTD .= $stx;
                        break;


                    case 'func_trata_dado':
                        $vlTD .= $Valor['vetDominio']($row[$Campo], $row, $Campo);
                        break;

                    default:
                        $vlTD .= $row[$Campo];
                        break;
                }
            }

            echo $vlTD.'</td>';
        }

        echo '</tr>';
    }

    echo '</table>';

    unset($sql);
    unset($rs);
    unset($row);
    unset($vetCampo);
    unset($titulo);
}

$sql = '';
$sql .= ' select op.*, gec_cc.descricao as gec_cc_descricao, gec_cc.codigo as gec_cc_codigo, gec_e.codigo as gec_e_cnpj, gec_e.descricao as gec_e_executora,';
$sql .= '  sca_nan.descricao as sca_nan_ur,u.nome_completo';
$sql .= ' from '.db_pir_grc.'grc_nan_ordem_pagamento op';
$sql .= " inner join ".db_pir_grc."plu_usuario u on u.id_usuario = op.idt_cadastrante";
$sql .= " inner join ".db_pir_gec."gec_contratar_credenciado gec_cc on gec_cc.idt = op.idt_contrato";
$sql .= " inner join ".db_pir_gec."gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
$sql .= " inner join ".db_pir."sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";
$sql .= ' where op.idt = '.null($_GET['id']);
$rs = execsqlNomeCol($sql);

if ($rs->rows == 1) {
    $row = $rs->data[0];
    unset($rs);
    ?>
    <style type="text/css">
        table.tabela {
            width: 100%;
            border: none;
            border-spacing: 0px;
        }

        table.tabela tr td {
            font-size: 11px;
            padding: 10px;
        }

        div.tit {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            color: white;
            background-color: #2f66b8;
        }

        table.tabela tr td.cT {
            font-weight: bold;
            width: 180px;
            background-color: #ecf0f1;
        }

        table.tabela tr.gridTR td {
            border-bottom: 1px solid #ecf0f1;
        }

        table.tabela tr.gridTOP td.cT,
        table.tabela tr.gridTR td.cT {
            width: auto;
        }

        table.tabela tr.gridTOP td,
        table.tabela tr.gridTR td {
            font-size: 10px;
        }
    </style>
    <div class="tit">IDENTIFICAÇÃO</div>
    <table class="tabela">
        <tr>
            <td class="cT">Protocolo:</td><td class="cD"><?php echo $row['protocolo']; ?></td>
        </tr>
        <tr>
            <td class="cT">Unidade Regional (UR):</td><td class="cD"><?php echo $row['sca_nan_ur']; ?></td>
        </tr>
        <tr>
            <td class="cT">Empresa:</td><td class="cD"><?php echo $row['gec_e_cnpj'].' - '.$row['gec_e_executora']; ?></td>
        </tr>
        <tr>
            <td class="cT">Contrato:</td><td class="cD"><?php echo $row['gec_cc_codigo'].' - '.$row['gec_cc_descricao']; ?></td>
        </tr>
        <tr>
            <td class="cT">Periodo:</td><td class="cD"><?php echo trata_data($row['data_inicio']).' até '.trata_data($row['data_fim']); ?></td>
        </tr>
        <tr>
            <td class="cT">Observação:</td><td class="cD"><?php echo conHTML($row['objeto']); ?></td>
        </tr>
    </table>
    <div class="tit">QUANTITATIVOS E VALORES</div>
    <table class="tabela">
        <tr>
            <td class="cT">Quantidade Primeira Visita:</td><td class="cD"><?php echo $row['qtd_visitas1']; ?></td>
            <td class="cT">Quantidade Segunda Visita:</td><td class="cD"><?php echo $row['qtd_visitas2']; ?></td>
        </tr>
        <tr>
            <td class="cT">Quantidade Total Visitas:</td><td class="cD"><?php echo $row['qtd_total_visitas']; ?></td>
            <td class="cT">Valor Total (R$):</td><td class="cD"><?php echo format_decimal($row['valor_total']); ?></td>
        </tr>
        <tr>
            <td class="cT">Responsavel:</td><td class="cD"><?php echo $row['nome_completo']; ?></td>
            <td class="cT">Data de Criação:</td><td class="cD"><?php echo trata_data($row['data_cadastrante']); ?></td>
        </tr>
    </table>
    <?php
    $titulo = 'ATENDIMENTOS - VISITAS';

    $vetCampoLC = Array();
    $vetCampoLC['data'] = CriaVetTabela('Data do Atendimento', 'data');
    $vetCampoLC['agente'] = CriaVetTabela('AOE');
    $vetCampoLC['tutor'] = CriaVetTabela('Tutor');
    $vetCampoLC['representante_cliente'] = CriaVetTabela('Representante / Cliente');
    $vetCampoLC['horas_atendimento'] = CriaVetTabela('Qtd. Horas do Atendimento');
    $vetCampoLC['protocolo'] = CriaVetTabela('Protocolo');

    $sql = '';
    $sql .= ' select grc_a.idt, grc_a.data, grc_a.horas_atendimento, grc_a.protocolo,';
    $sql .= ' concat_ws("<br >", grc_ap.nome, gec_ec.descricao) as representante_cliente, ';
    $sql .= ' plu_usut.nome_completo as tutor, ';
    $sql .= ' plu_usuc.nome_completo as agente ';
    $sql .= ' from grc_atendimento grc_a ';
    $sql .= ' inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_a.idt_grupo_atendimento ';
    $sql .= ' left join '.db_pir_gec.'gec_entidade gec_ec on gec_ec.idt = grc_nga.idt_organizacao ';
    $sql .= " left join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt and grc_ap.tipo_relacao = 'L'";
    $sql .= ' left join plu_usuario plu_usut on plu_usut.id_usuario = grc_a.idt_nan_tutor ';
    $sql .= ' left join plu_usuario plu_usuc on plu_usuc.id_usuario = grc_a.idt_consultor ';
    $sql .= ' where grc_a.idt_nan_ordem_pagamento = '.null($_GET['id']);
    $sql .= ' order by grc_a.data, plu_usuc.nome_completo';

    ListarRegistros($sql, $vetCampoLC, $titulo);
}

unset($row);
unset($vetCampoLC);
unset($titulo);
unset($sql);
