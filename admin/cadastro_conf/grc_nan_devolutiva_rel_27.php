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
$sql .= ' where grupo = ' . aspa('NAN');
$sql .= ' order by grc_fa.codigo ';
$rs = execsql($sql);
$legenda_x = '';
$virgula = '';
$vetorAreasGrafico = Array();
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
    $vetorAreasGrafico[$area] = $descricao;
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
$valores_g1a = "";
$virgula = "";
$vetorAreasGrafico = Array();

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
        $valores_g1 .= $virgula . $val;
        $virgula = ",";
    }
}

// para ano anterior
$vetResultadoArea = Array();
$vetResultadoAreaNum = Array();
$vetResultadoAreaInv = Array();
$vetResultadoAreaNumInv = Array();

$ret = CiclosAtualAnteriorNAN($idt_avaliacao, $vetResultadoArea, $vetResultadoAreaInv, $vetResultadoAreaNum);

$vetorParaGrafico = Array();
ForEach ($vetorAreasGrafico as $area => $descricao) {
    $vetorParaGrafico[1][$area] = 0;
    $vetorParaGrafico[2][$area] = 0;
}
$ciclo = 2;
$vetCicloAtual = $vetResultadoAreaInv[$ciclo];
ForEach ($vetCicloAtual as $area => $valor) {
    $vetorAreasGrafico[$area] = $area;
}
$ciclo = 1;
$vetCicloAtual = $vetResultadoAreaInv[$ciclo];
ForEach ($vetCicloAtual as $area => $valor) {
    $vetorParaGrafico[$ciclo][$area] = $valor;
}
$ciclo = 2;
$vetCicloAtual = $vetResultadoAreaInv[$ciclo];
ForEach ($vetCicloAtual as $area => $valor) {
    $vetorParaGrafico[$ciclo][$area] = $valor;
}

// carrega valores do anterior para gráfico
$valores_g1a = "";
$virgula = "";
$ciclo = 1;
$vetCicloAtual = $vetResultadoAreaInv[$ciclo];
ForEach ($vetCicloAtual as $area => $valor) {
    $val = format_decimal($valor);
    $val = str_replace(' ', '', $val);
    $val = str_replace('.', '', $val);
    $val = str_replace(',', '.', $val);
    $valores_g1a .= $virgula . $val;
    $virgula = ",";
}

////////////////////// DO SETOR ANO ANTERIOR
// para ano anterior
/*
  $vetResultadoArea       = Array();
  $vetResultadoAreaNum    = Array();
  $vetResultadoAreaInv    = Array();
  $vetResultadoAreaNumInv = Array();
  function CiclosAtualAnteriorSetorNAN($idt_avaliacao,&$vetCliente) {
  $ret = CiclosAtualAnteriorSetorNAN($idt_avaliacao,$vetResultadoArea,$vetResultadoAreaInv,$vetResultadoAreaNum);
 */
//$vetCliente=Array();
//$ret = CiclosAtualAnteriorSetorNAN($idt_avaliacao,$vetCliente);
//p($vetCliente);
//
// Carrega valores do anterior para gráfico
//
$vetResultadoArea = Array();
$vetResultadoAreaInv = Array();
$vetCliente = Array();
$ret = CiclosAtualAnteriorSetorNAN($idt_avaliacao, $vetResultadoArea, $vetResultadoAreaInv, $vetCliente);

$descricao_setor = $vetCliente['descricao_setor'];
//p($vetCliente);
//
$valores_g1as = "";
$virgula = "";
$ciclo = 1;
$vetCicloAnteriorSetor = $vetResultadoAreaInv;
ForEach ($vetCicloAnteriorSetor as $area => $valor) {
    $val = format_decimal($valor);
    $val = str_replace(' ', '', $val);
    $val = str_replace('.', '', $val);
    $val = str_replace(',', '.', $val);
    $valores_g1as .= $virgula . $val;
    $virgula = ",";
}


//
$background = '#FFFFFF;';
$color = '#000000;';
$width = '100%';
$width = $width . '%';
$height = '25px';
$height = $height . 'px';
echo "<table border='1' cellspacing='0' cellpadding='0' width='100%' style='' >";

$stylo = "padding:5px; font-family : Calibri, Arial, Helvetica, sans-serif; text-align:left; font-size:12pt; color:$color; background:$background;";
echo "<tr>";
echo "<td  style='{$stylo} width:50%;' >";
echo "<div id='container_graficoc1'></div>";

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
echo "<div id='container_graficoc2'></div>";




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

echo "</tr>";
echo "</table>";


$exportPath = dirname($_SERVER['SCRIPT_FILENAME']);
$exportPath .= DIRECTORY_SEPARATOR . $dir_file;
$exportPath .= DIRECTORY_SEPARATOR . 'grc_nan_grupo_atendimento';
$exportPath .= DIRECTORY_SEPARATOR;
$exportPath .= $idt_avaliacao;
$exportPath = str_replace('\\', '/', $exportPath);

/*
  $sql = "select grc_nga.pdf_devolutiva, grc_nga.num_visita_atu, grc_at.idt_ponto_atendimento";
  $sql .= " from  grc_avaliacao grc_a ";
  $sql .= " inner join grc_atendimento grc_at on grc_at.idt = grc_a.idt_atendimento ";
  $sql .= " inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_at.idt_grupo_atendimento ";
  $sql .= " where grc_a.idt  =  " . null($idt_avaliacao);
  $rsGA = execsql($sql);
  $rowGA = $rsGA->data[0];

  if ($rowGA['pdf_devolutiva'] == '' || $rowGA['num_visita_atu'] == 1) {
  $geraImagem = 'S';
  } else {
  $geraImagem = 'N';
  }
 * 
 */

?>
<script>
    var chart;
    arqGraficoGerado27 = false;
    //var geraImagem = '<?php echo $geraImagem; ?>';
    var descricao_setor = '<?php echo $descricao_setor; ?>';


    $(document).ready(function () {
        if (geraImagem == 'S') {
            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=limpaArqDevolutivac',
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

        chart1c = new Highcharts.Chart({
            chart: {
                animation: false,
                renderTo: 'container_graficoc1',
                type: 'bar'


            },
            title: {
                text: 'Potencial de Melhoria'
            },
            subtitle: {
                text: 'COMPARANDO SUA EMPRESA HOJE X SUA EMPRESA NO PASSADO'
            },
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
                enabled: true,
                // layout: 'vertical',
                layout: 'bottom',
                //  align: 'right',
                //  verticalAlign: 'top',
                //  x: 40,
                // y: 80,
                //  floating: true,
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
                    name: 'Potencial de Melhoria - Ano Anterior',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g1a ?>],
                    color: 'rgba(192, 192, 192 , 1)'
                },

                {
                    name: 'Potencial de Melhoria - Ano Atual',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g1 ?>],
                    color: 'rgba(0, 0, 255 , 1)'
                }


            ]




        });
        /////////////////// grafico 2

        chart2c = new Highcharts.Chart({
            chart: {
                animation: false,
                renderTo: 'container_graficoc2',
                type: 'bar'


            },
            title: {
                text: 'SETOR: ' + descricao_setor + ''
            },
            subtitle: {
                text: 'COMPARANDO SUA EMPRESA HOJE X OUTRAS EMPRESAS EM SEU SETOR'
            },
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
                // reversed: true,
                enabled: true,
                layout: 'bottom',
                //align: 'right',
                //verticalAlign: 'top',
                //x: -40,
                //y: 80,
                //floating: true,
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
                    name: 'Potencial de Melhoria - Média do Setor ',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g1as ?>],
                    color: 'rgba(192, 192, 192 , 1)'
                },

                {
                    name: 'Potencial de Melhoria - Sua Empresa',
                    //data: [10, 31, 63, 20, 2, 78 , 89],
                    data: [<?php echo $valores_g1 ?>],
                    color: 'rgba(0, 0, 255 , 1)'
                }


            ]




        }, function () {
            if (geraImagem == 'S') {
                setTimeout(function () {
                    var filename1 = '<?php echo $exportPath . '_graficoc1.png'; ?>';
                    var filename2 = '<?php echo $exportPath . '_graficoc2.png'; ?>';

                    var svg = chart1c.container.innerHTML;
                    svg = base64_encode(svg);
                    exportChart('image/png', filename1, '', svg);

                    svg = chart2c.container.innerHTML;
                    svg = base64_encode(svg);
                    exportChart('image/png', filename2, '', svg);

                    arqGraficoGerado27 = true;
                }, 1000);
            }
        });
        // fim do grafico 2
    });
</script>