<style>
</style>
<?php
$quantidadet = 0;
$titulo      = $caption_dimensaow."<br />Quantidade de Atendimentos";
$legenda_x   = "";
$valores_g1  = "";
$virgula     = '';
$totalgeral  = 0;


foreach ($vetDimensao as $dimensao => $Vetores)
{
    $dimensaow     = str_replace("'","",$dimensao);
    $legenda_x    .= " {$virgula} '{$dimensaow}' "; 
	
	$vetQtd        = $Vetores['qtd'];
	$vetPer        = $Vetores['per'];
	$totaldimensao = 0;
	foreach ($vetQtd as $mes => $Qtd)
	{
       $totaldimensao = $totaldimensao + $Qtd; 
	}
	
	$totalgeral   = $totalgeral+$totaldimensao;
	
    $valores_g1  .= $virgula.$totaldimensao;
	$virgula      = ', ';
	$quantidadet  = $quantidadet+1;
}
$titulo2     = $caption_dimensaow."<br />% de Atendimentos";
$valores_g2  = "";
$virgula     = '';
if ($totalgeral==0)
{
    $totalgeral=1;
}
foreach ($vetDimensao as $dimensao => $Vetores)
{
	$vetQtd = $Vetores['qtd'];
	$vetPer = $Vetores['per'];
	$totaldimensao = 0;
	foreach ($vetQtd as $mes => $Qtd)
	{
       $totaldimensao = $totaldimensao + $Qtd; 
	}
	$perc         = ($totaldimensao/$totalgeral)*100;
	$percw        = desformat_decimal(format_decimal($perc,2));
    $valores_g2  .= $virgula.$percw;
	$virgula      = ', ';
}
echo  "<div id='graficos' style='width:100%; margin-top:10px; background:#2C3E50; color:#FFFFFF; font-size:18px; font-weight: bold; text-align:center; '>GRÁFICOS</div>";

$fatoraltura = 40;
$fatoraltura = 50;

if ($quantidadet>=15)
{
    $altura = $quantidadet * 50;
	echo  "<div id='container_grafico1' style='width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696;'></div>";
	echo  "<div id='container_grafico2' style='width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696; border-bottom:3px solid #2A5696;'></div>";
}
else
{
    $altura = $quantidadet * $fatoraltura + 100;
	echo  "<div id='container_grafico1' style='width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696;'></div>";
	echo  "<div id='container_grafico2' style='width:100%; height:{$altura}px; margin-top:10px; border-top:3px solid #2A5696; border-bottom:3px solid #2A5696;'></div>";
}
?>

<script type="text/javascript">
var chart;
$(document).ready(function() {
        chart = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico1',
            type: 'bar'
        },
        title: {
            text: '<?php echo $titulo ?>'
        },
        // subtitle: {
        //     text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
        // },
        xAxis: {
			categories: [<?php echo $legenda_x ?>],
			
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
			//max: 100,
			gridLineWidth: 1,
			//reversed: true,
            title: {
                text: '(em Quantidade de Atendimentos)',
				
                align: 'high'
            },
            labels: {
			    enabled: true,
				                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' '
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
            name: '<?php echo $titulo ?>',
			data: [<?php echo $valores_g1 ?>],
			color: 'rgba(0, 0, 255, 1)'
        }]
    });
	/////////////////// grafico 2
	 chart = new Highcharts.Chart({
        chart: {
		    renderTo: 'container_grafico2',
            type: 'bar'
        },
        title: {
            text: '<?php echo $titulo2 ?>'
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
                text: '(em % de Atendimentos)',
                align: 'high'
            },
            labels: {
			    enabled: true,
				reversed: true,
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' '
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
            name: '<?php echo $titulo2 ?>',
            //data: [10, 31, 63, 20, 2, 78 , 89],
			data: [<?php echo $valores_g2 ?>],
			color: 'rgba(255, 0, 0, 1)'
        }]
    });
	// fim do grafico 2
});
</script>
