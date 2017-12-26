<style>
</style>

<?php

function AchaTurno($hora) {
    $vet = explode(":", $hora);
    $hora = $vet[0];
    if ($hora >= 07 and $hora <= 12) {
        $turno = 'Manhã';
    }
    if ($hora > 12 and $hora <= 19) {
        $turno = 'Tarde';
    }
    if (($hora > 19 and $hora <= 23) or ( $hora >= 00 and $hora < 07)) {
        $turno = 'Noite';
    }
    return $turno;
}

//
// Eventos
//
$sql = '';
$sql .= ' select grc_e.*, grc_ft.descricao as grc_ft_descricao, c.desccid as cidade';
$sql .= ' from grc_evento grc_e ';
$sql .= ' inner join grc_foco_tematico grc_ft on grc_ft.idt = grc_e.idt_foco_tematico  ';
$sql .= ' left outer join '.db_pir_siac.'cidade c on c.codcid = grc_e.idt_cidade';
$sql .= ' where grc_e.ativo = '.aspa('S');
$sql .= ' and grc_e.idt_evento_situacao = 14 ';   // agendado;
$sql .= ' and grc_e.idt_ponto_atendimento = '.null($rowGA['idt_ponto_atendimento']);
$sql .= ' order by grc_e.dt_previsao_inicial ';
$rs = execsql($sql);

$background = '#FF8000;';
$color = '#004080;';
$width = '100%';
$width = $width.'%';
$height = '25px';
$height = $height.'px';

echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";
echo "<tr>";
$stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:12pt; color:$color; background:$background;";
echo "<tr>";
echo "<td  style='{$stylo}' >";
echo 'Tema';
echo "</td>";
echo "<td  style='{$stylo} width:300px;' >";
echo 'Cuso/Oficina';
echo "</td>";
echo "<td  style='{$stylo}' >";
echo 'Carga Horária';
echo "</td>";

echo "<td  style='{$stylo}' >";
echo 'Início';
echo "</td>";
echo "<td  style='{$stylo}' >";
echo 'Fim';
echo "</td>";
echo "<td  style='{$stylo}' >";
echo 'Turno';
echo "</td>";
echo "<td  style='{$stylo}' >";
echo 'Local';
echo "</td>";
echo "</tr>";

$temEvento = false;

foreach ($rs->data as $row) {
    $codigo = $row['codigo'];
    $descricao = $row['descricao'];
    $detalhe = $row['detalhe'];
    $dt_previsao_inicio = trata_data($row['dt_previsao_inicial']);
    $dt_previsao_fim = trata_data($row['dt_previsao_fim']);
    $carga_horaria = format_decimal($row['carga_horaria_total']);
    $hora_inicio = $row['hora_inicio'];
    $hora_fim = $row['hora_fim'];

    $idt_foco_tematico = $row['idt_foco_tematico'];
    $idt_produto = $row['idt_produto'];
    $idt_foco_tematicoP = $kvetProdutoFocoP[$idt_produto];
    if ($idt_foco_tematicoP != $idt_foco_tematico) {   // tem que ser mesmo foco temático
        continue;
    }

    $grc_ft_descricao = $row['grc_ft_descricao'];

    $inicio = $dt_previsao_inicio;
    $fim = $dt_previsao_fim;

    $turno = AchaTurno($hora_inicio);
    $local = $row['cidade'];

    $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
    echo "<tr>";
    echo "<td  style='{$stylo}' >";
    echo $grc_ft_descricao;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $descricao;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $carga_horaria;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $inicio;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $fim;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $turno;
    echo "</td>";
    echo "<td  style='{$stylo}' >";
    echo $local;
    echo "</td>";
    echo "</tr>";

    $temEvento = true;
}

if (!$temEvento) {
    $stylo = "font-family : Calibri, Arial, Helvetica, sans-serif; text-align:center; font-size:11pt;";
    echo "<tr>";
    echo "<td colspan='7' style='{$stylo}' >";
    echo 'Não existem eventos agendados.';
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
