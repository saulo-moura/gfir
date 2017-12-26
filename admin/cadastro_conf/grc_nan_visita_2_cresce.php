<style type="text/css">
    #cresce_desc table {
        color: black;
    }

    #cresce_desc td {
        padding: 2px 5px;
        font-weight: bold;
    }

    #cresce_desc td.num {
        text-align: right;
        font-weight: normal;
        background: #f6f6f6;
    }

    #cresce_desc table table {
        width: auto;
    }

    #cresce_desc table table tr:first-child td {
        border-bottom: 1px solid black;
    }
</style>
<?php
$sql = '';
$sql .= ' select eo.codigo';
$sql .= ' from grc_atendimento a';
$sql .= ' inner join grc_nan_grupo_atendimento ga on ga.idt = a.idt_grupo_atendimento';
$sql .= " inner join " . db_pir_gec . "gec_entidade eo on eo.idt = ga.idt_organizacao";
$sql .= ' where a.idt = ' . null($_GET['idt_atendimento']);
$rs = execsql($sql);
$organizacao_codigo = $rs->data[0][0];

$sql = '';
$sql .= ' select av.idt';
$sql .= ' from grc_nan_grupo_atendimento g';
$sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
$sql .= " inner join grc_atendimento a on a.idt_grupo_atendimento = g.idt ";
$sql .= " inner join grc_avaliacao av on av.idt_atendimento = a.idt ";
$sql .= ' where g.nan_ciclo < 2';
$sql .= ' and e.codigo = ' . aspa($organizacao_codigo);
$sql .= " and g.status_2 = 'AP'";
$sql .= ' and a.nan_num_visita = 1';
$sql .= ' order by g.idt desc, av.idt desc limit 1';
$rs = execsql($sql);
$idt_avaliacao = $rs->data[0][0];

$sql = "select grc_fa.codigo, grc_adra.percentual";
$sql .= " from grc_avaliacao grc_a ";
$sql .= " inner join grc_avaliacao_devolutiva            grc_ad  on grc_ad.idt_avaliacao             = grc_a.idt ";
$sql .= " inner join grc_avaliacao_devolutiva_resultado_area grc_adra on grc_adra.idt_avaliacao_devolutiva = grc_ad.idt ";
$sql .= " inner join grc_formulario_area                 grc_fa  on grc_fa.idt                       = grc_adra.idt_area ";
$sql .= " where grc_a.idt = " . null($idt_avaliacao);
$rsPFC = execsql($sql);

$vetCicloAnt = Array();

foreach ($rsPFC->data as $rowPFC) {
    $vetCicloAnt[$rowPFC['codigo']] = $rowPFC['percentual'];
}

$sql = '';
$sql .= ' select fa.codigo, fa.descricao as area, pfc.percentual';
$sql .= ' from grc_plano_facil_cresce pfc';
$sql .= ' inner join grc_formulario_area fa on fa.idt = pfc.idt_area';
$sql .= ' where pfc.idt_plano_facil = ' . null(idtPF);
$sql .= ' order by fa.codigo';
$rsPFC = execsql($sql);

echo '<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">';
echo '<tr>';
echo '<td>Ciclo Atual</td>';
echo '<td>Ciclo Anterior</td>';
echo '</tr>';
echo '<tr>';

//Ciclo Atual
echo '<td>';

echo '<table cellspacing="4" cellpadding="0" border="0">';
echo '<tr>';
echo '<td>CRITÉRIO</td>';
echo '<td>% OBTIDA</td>';
echo '</tr>';

foreach ($rsPFC->data as $rowPFC) {
    echo '<tr>';
    echo '<td>' . $rowPFC['area'] . '</td>';
    echo '<td class="num">' . format_decimal($rowPFC['percentual']) . '</td>';
    echo '</tr>';
}

echo '</table>';

echo '</td>';

//Ciclo Anterior
echo '<td>';

echo '<table cellspacing="4" cellpadding="0" border="0">';
echo '<tr>';
echo '<td>CRITÉRIO</td>';
echo '<td>% OBTIDA</td>';
echo '</tr>';

foreach ($rsPFC->data as $rowPFC) {
    echo '<tr>';
    echo '<td>' . $rowPFC['area'] . '</td>';
    echo '<td class="num">' . format_decimal($vetCicloAnt[$rowPFC['codigo']]) . '</td>';
    echo '</tr>';
}

echo '</table>';

echo '</td>';

echo '</tr>';
echo '</table>';
