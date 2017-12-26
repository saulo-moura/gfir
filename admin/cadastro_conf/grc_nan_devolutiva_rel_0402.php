<style>
</style>

<?php
$idt_avaliacao = $_GET['idt_avaliacao'];
$vetAreas = Array();
$vetAreasIDT = Array();
$vetAreasV = Array();
$sql = '';
$sql .= ' select grc_fa.*';
$sql .= ' from grc_formulario_area grc_fa ';
$sql .= ' where grupo = '.aspa('NAN');
$sql .= ' order by grc_fa.codigo ';

$rs = execsql($sql);
$legenda_x = '';
$virgula = '';
foreach ($rs->data as $row) {
    $codigo = $row['codigo'];
    if ($codigo == '00') {
        continue;
    }
    $descricao = ucfirst(mb_strtolower($row['descricao']));
    $vetAreas[$codigo] = $descricao;
    $vetAreasIDT[$codigo] = $row['idt'];
    $legenda_x .= " {$virgula} '{$descricao}' ";
    $virgula = ',';
    $vetAreasV[$codigo] = 10;
}
if ($idt_avaliacao == "") {
    $idt_avaliacao = 0;
}
$vetAvaliacao = Array();
ApuracaoDiagnostico($idt_avaliacao, $vetAvaliacao);

$vetAvaliacaoA = $vetAvaliacao['A'];
$vetAvaliacaoL = $vetAvaliacao['L'];
$vetAvaliacaoQ = $vetAvaliacao['Q'];

$vetAvaliacaoRank = $vetAvaliacao['Rank'];
$vetAvaliacaoRankCla = $vetAvaliacao['RankCla'];
$vetAvaliacaoRankClaIE = $vetAvaliacao['RankClaIE'];
$vetAvaliacaoRankClaIQ = $vetAvaliacao['RankClaIQ'];
$vetAvaliacaoRankClaIA = $vetAvaliacao['RankClaIA'];



$quantidade_total = $vetAvaliacaoQ['99'];
$vetAreaPerc1 = Array();
$vetGRC_Avaliacao_DRA = Array();
$valores_g1 = "";
$virgula = "";

ForEach ($vetAvaliacaoQ as $area => $quantidade) {
    if ($area != '99') {
        $quantidade_total_area = $vetAvaliacaoQ[$area];
        $quantidade_s = 0;
        $vetAvaliacaoAA = $vetAvaliacaoA[$area];
        ForEach ($vetAvaliacaoAA as $pergunta => $resposta) {
            $quantidade_s = $quantidade_s + $resposta;
        }
        //$perc = ($quantidade_s/$quantidade_total)*100;

        $perc = ($quantidade_s - $quantidade_total_area) * ( 100 / ( (3 * $quantidade_total_area) - $quantidade_total_area ) );
        $vetGRC_Avaliacao_DRA[$vetAreasIDT[$area]] = $perc;

        $perc = (100 - $perc);
        $vetAreaPerc1[$area] = $perc;
        $val = format_decimal($perc);
        $val = str_replace(' ', '', $val);
        $val = str_replace('.', '', $val);
        $val = str_replace(',', '.', $val);
        $valores_g1 .= $virgula.$val;
        $virgula = ",";
    }
}

$vetAvaliacaoA = $vetAvaliacao['AAr'];
$vetAvaliacaoL = $vetAvaliacao['LAr'];
$vetAvaliacaoQ = $vetAvaliacao['QAr'];

$vetAreaPerc2 = Array();
$valores_g2 = "";
$virgula = "";
ForEach ($vetAvaliacaoQ as $area => $quantidade) {
    if ($area != '99') {
        $quantidade_total_area = $vetAvaliacaoQ[$area];
        $quantidade_s = 0;
        $vetAvaliacaoAA = $vetAvaliacaoA[$area];
        ForEach ($vetAvaliacaoAA as $pergunta => $resposta) {
            $quantidade_s = $quantidade_s + $resposta;
        }
        //$perc = ($quantidade_s/$quantidade_total)*100;

        $perc = ($quantidade_s - $quantidade_total_area) * ( 100 / ( (4 * $quantidade_total_area) - $quantidade_total_area ) );

        $perc = (100 - $perc);
        $vetAreaPerc2[$area] = $perc;
        $val = format_decimal($perc);
        $val = str_replace(' ', '', $val);
        $val = str_replace('.', '', $val);
        $val = str_replace(',', '.', $val);
        $valores_g2 .= $virgula.$val;
        $virgula = ",";
    }
}

/*
  p($vetAvaliacaoA); // da área
  p($vetAvaliacao['AQe']); // do quesito
  p($vetAvaliacaoRankCla);
  p($vetAvaliacaoRankClaIE); // base
 */


//
$background = '#FFFFFF;';
$color = '#000000;';
$width = '100%';
$width = $width.'%';
$height = '25px';
$height = $height.'px';
echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";

$stylo = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:12pt; color:$color; background:$background;";
echo "<tr>";
echo "<td  style='{$stylo} width:50%;' >";
echo "<div id='container_grafico1'></div>";

echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
echo "<tr>";
echo "<td  style='text-align:left;'>";
echo "Pouco a Melhorar";
echo "</td>";
echo "<td  style='text-align:right;'>";
echo "Muito a Melhorar";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</td>";

echo "<td  style='{$stylo} width:50%;' >";
echo "<div id='container_grafico2'></div>";

echo "<table border='0' cellspacing='0' cellpadding='0' width='100%'>";
echo "<tr>";
echo "<td  style='text-align:left;'>";
echo "Baixa";
echo "</td>";
echo "<td  style='text-align:right;'>";
echo "Alta";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "</td>";

echo "</tr>";
echo "</table>";

$exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
$exportPath .= DIRECTORY_SEPARATOR.$dir_file;
$exportPath .= DIRECTORY_SEPARATOR.'grc_nan_grupo_atendimento';
$exportPath .= DIRECTORY_SEPARATOR;
$exportPath .= $idt_avaliacao;
$exportPath = str_replace('\\', '/', $exportPath);

$sql = "select grc_nga.pdf_devolutiva, grc_nga.num_visita_atu, grc_at.idt_ponto_atendimento";
$sql .= " from  grc_avaliacao grc_a ";
$sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
$sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
$sql .= " where grc_a.idt  =  ".null($idt_avaliacao);
$rsGA = execsql($sql);
$rowGA = $rsGA->data[0];

if ($rowGA['pdf_devolutiva'] == '' || $rowGA['num_visita_atu'] == 1) {
    $geraImagem = 'S';
} else {
    $geraImagem = 'N';
}
?>
<script>
    var chart;
    var arqGraficoGerado = false;
    var geraImagem = '<?php echo $geraImagem; ?>';

    $(document).ready(function () {
        if (geraImagem == 'S') {
            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=limpaArqDevolutiva',
                data: {
                    id: '<?php echo $idt_avaliacao; ?>'
                },
                success: function (response) {
                    if (response != '') {
                        alert(response);
                    }
                },
                async: false
            });
        }

        chart1 = new Highcharts.Chart({
            chart: {
                animation: false,
                renderTo: 'container_grafico1',
                type: 'bar'


            },
            title: {
                text: 'Potencial de Melhoria'
            },
            // subtitle: {
            //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
            // },
            xAxis: {
                //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],

                categories: [<?php echo $legenda_x ?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                max: 100,
                gridLineWidth: 1,
                //reversed: true,


                title: {
                    text: '(em %)',
                    align: 'high'
                },
                labels: {
                    enabled: true,
                    overflow: 'justify'
                }

            },
            tooltip: {
                valueSuffix: ' %'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false,
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            /*
             series: [{
             name: 'Year 1800',
             data: [107, 31, 635, 203, 2]
             }, {
             name: 'Year 1900',
             data: [133, 156, 947, 408, 6]
             }, {
             name: 'Year 2012',
             data: [1052, 954, 4250, 740, 38]
             }]
             */

            series: [{
                    name: 'Potencial de Melhoria',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g1 ?>],
                    color: 'rgba(0, 0, 255, 1)'
                }]




        });
        /////////////////// grafico 2

        chart2 = new Highcharts.Chart({
            chart: {
                animation: false,
                renderTo: 'container_grafico2',
                type: 'bar'


            },
            title: {
                text: 'Insatisfação em relação ao Tema'
            },
            // subtitle: {
            //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
            // },
            xAxis: {
                //categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],

                categories: [<?php echo $legenda_x ?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                max: 100,
                gridLineWidth: 1,
                title: {
                    text: '(em %)',
                    align: 'high'
                },
                labels: {
                    enabled: true,
                    reversed: true,
                    overflow: 'justify'
                }

            },
            tooltip: {
                valueSuffix: ' %'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                reversed: true,
                enabled: false,
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            /*
             series: [{
             name: 'Year 1800',
             data: [107, 31, 635, 203, 2]
             }, {
             name: 'Year 1900',
             data: [133, 156, 947, 408, 6]
             }, {
             name: 'Year 2012',
             data: [1052, 954, 4250, 740, 38]
             }]
             */

            series: [{
                    name: 'Potencial de Melhoria',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g2 ?>],
                    color: 'rgba(255, 0, 0, 1)'
                }]




        }, function () {
            if (geraImagem == 'S') {
                setTimeout(function () {
                    var filename1 = '<?php echo $exportPath.'_grafico1.png'; ?>';
                    var filename2 = '<?php echo $exportPath.'_grafico2.png'; ?>';

                    var svg = chart1.container.innerHTML;
                    svg = base64_encode(svg);
                    exportChart('image/png', filename1, '', svg);

                    svg = chart2.container.innerHTML;
                    svg = base64_encode(svg);
                    exportChart('image/png', filename2, '', svg);

                    arqGraficoGerado = true;
                }, 1000);
            }
        });
        // fim do grafico 2
    });
</script>