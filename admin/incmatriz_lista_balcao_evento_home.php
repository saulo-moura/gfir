<style type="text/css">
  #01 {
    width:100%;
	display:block;
	background:#FF0000;
	color:#FFFFFF;
	
  }
  #01_01 {
      }
  .G {
    
  }
  .A {
    width:24.3%;
	display:block;
	background:transparent;
	color:#FFFFFF;
	xheight:10em;
	height:220px;
    xborder:1px solid#FF0000;
	//margin:5px;
    float:left;
	margin:0.1em;
	xborder-radius: 1em;
  }
  #01_01 {
    background:#0000FF;
  }
  #01_02 {
    background:#FF0000; 
  }
  #01_03 {
    background:#00FF00; 
  }
  #01_04 {
    background:#C0C0C0; 
  }
  #02_01 {
    background:#0000FF; 
  }
  #02_02 {
    background:#FF0000; 
  }
  #02_03 {
    background:#00FF00; 
  }
  #02_04 {
    background:#C0C0C0; 
  }
  
div#corpo_painel {
        background:#2F2FFF;
        color:#FFFFFF;
        xfont-size:20px;
        width:100%;
		height:660px;
        background: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
        background: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
        xborder: 1px solid thick #c00000;
        xborder-radius: 1em;
        xborder:1px solid  #0000A0;
    }  
</style>
<?php






// seção 1
echo "<div id='corpo_painel' class='P' style='' >";


// seção 1
echo "<div id='01'    class='G' style='' >";
echo "<div id='01_01' class='A' style='' >";
echo "</div>";
echo "<div id='01_02'  class='A' style='' >";
echo "</div>";
echo "<div id='01_03' class='A' style='' >";
echo "</div>";
echo "<div id='01_04' class='A' style='' >";
echo "</div>";
echo "</div>";




// seção 2
echo "<div id='02'    class='G' style='' >";
echo "<div id='02_01' class='A' style='' >";
echo "</div>";
echo "<div id='02_02' class='A' style='' >";
echo "</div>";
echo "<div id='02_03' class='A' style='' >";
echo "</div>";
echo "<div id='02_04' class='A' style='' >";
echo "</div>";
echo "</div>";



// seção 3
echo "<div id='03'    class='G' style='' >";

echo "<div id='03_01' class='A' style='' >";

echo "</div>";
echo "<div id='03_02' class='A' style='' >";

echo "</div>";
echo "<div id='03_03' class='A' style='' >";

echo "</div>";
echo "<div id='03_04' class='A' style='' >";

echo "</div>";



echo "</div>";

echo "</div>";


//p($vetAtendimentosG);


$legenda_x1     = "'Meta','Realizado', 'A Realizar'";
$qtd_previsto   = $vetMetasValorAnual['GE'];
$qtd_realizado  = $vetAtendimentosG['bruto_total'];
$qtd_projetado  = $qtd_previsto-$qtd_realizado;

$qtd_previsto_perc    = 100.00;
$qtd_realizado_perc   = format_decimal(($qtd_realizado/$qtd_previsto)*100,2);
$qtd_realizado_perc   = desformat_decimal($qtd_realizado_perc);


$titulo1         = '<span style="">Total de Atendimentos</span><br />';

$titulo1        .= '<span style="color:#FF0000;">Realizado: '.$qtd_realizado_perc.' %</span>';
// Qtd
$qtd_previsto_perc    = $qtd_previsto;
$qtd_realizado_perc   = $qtd_realizado;

$qtd_projetado_perc   = $qtd_previsto_perc-$qtd_realizado_perc;

$valores_g1p  = $qtd_previsto_perc;
$valores_g1r  = $qtd_realizado_perc;
$valores_g1ar = $qtd_projetado_perc;

$valores_g1li = "$qtd_previsto_perc, $qtd_realizado_perc, $qtd_projetado_perc ";



// Constituição Jurídica

$titulo2        = 'Constituição Jurídica';
$legenda_x2     = "";
$valores_g2     = "";

$virgula        = '';

/*
$vetPorte = $vetAtendimentosG['CS'];
ForEach ($vetPorte as $constituicao => $quantidade) {

	$qtd_realizado_perc   = format_decimal(($quantidade/$qtd_realizado)*100,2);
	$qtd_realizado_perc   = desformat_decimal($qtd_realizado_perc);


	$valores_g2  .= $virgula."{"."name: '".$constituicao." ".$qtd_realizado_perc." %', y:".$quantidade."}";
	$leg          = $constituicao;
	$legenda_x2  .= " {$virgula} '{$leg}' ";  
	$virgula      = ', ';
}
*/





ForEach ($vetNaturezaPainel as $natureza => $VetAtr) {
    $quantidade = $VetAtr['qtd'];
	$qtd_realizado_perc   = format_decimal(($quantidade/$qtd_realizado)*100,2);
	$qtd_realizado_perc   = desformat_decimal($qtd_realizado_perc);
	$valores_g2  .= $virgula."{"."name: '".$natureza." ".$qtd_realizado_perc." %', y:".$quantidade."}";
	$leg          = $constituicao;
	$legenda_x2  .= " {$virgula} '{$leg}' ";  
	$virgula      = ', ';
}


$titulo3        = 'Instrumentos';
$legenda_x3     = "";
$valores_g3     = "";

$virgula        = '';


$vetInstrumentosLeg = Array();
$vetInstrumentosLeg[8]  = 'IN';   // Informação N
$vetInstrumentosLeg[13] = 'IT';   // Orientação Técnica B

$vetInstrumentosLeg[2]  = 'CO';   // Consultoria (Balcão e outras) F
$vetInstrumentosLeg[50] = 'CT';   // Consultoria Técnica - "Consultoria Presencial" F;

$vetInstrumentosLeg[40] = 'CS';   // Curso  F
$vetInstrumentosLeg[41] = 'FE';   // Feira F

$vetInstrumentosLeg[42] = 'FP';  // FAMPE N

$vetInstrumentosLeg[45] = 'MC';   // Missão e Caravana F

$vetInstrumentosLeg[46] = 'OF';  // Oficinas F

$vetInstrumentosLeg[47] = 'PA';   // Palestra B
$vetInstrumentosLeg[48] = 'RO';   // Rodadas F
$vetInstrumentosLeg[49] = 'SM';   // Seminários F
    


$vetInstrumentos = $vetAtendimentosG['instrumento'];
ForEach ($vetInstrumentos as $instrumento => $quantidade) {
	$qtd_realizado_perc   = format_decimal(($quantidade/$qtd_realizado)*100,2);
	$qtd_realizado_perc   = desformat_decimal($qtd_realizado_perc);
	//$valores_g3  .= $virgula."{"."name: '".$porte." ".$qtd_realizado_perc." %', y:".$quantidade."}";
	if ($quantidade=='')
	{
	    $quantidade='null';
	}
	$valores_g3  .= $virgula.$quantidade;
	
	$leg          = $vetInstrumentosLeg[$instrumento];
	if ($leg=='')
	{
	    $leg='AC';
	}
	
	$legenda_x3  .= " {$virgula} '{$leg}' ";  
	$virgula      = ', ';
}




// publico alvo

$titulo4        = 'Público Alvo';
$legenda_x4     = "";
$valores_g4     = "";

$virgula        = '';

$vetPorte = $vetAtendimentosG['PS'];
ForEach ($vetPorte as $porte => $quantidade) {
	$qtd_realizado_perc   = format_decimal(($quantidade/$qtd_realizado)*100,2);
	$qtd_realizado_perc   = desformat_decimal($qtd_realizado_perc);
	$valores_g4  .= $virgula."{"."name: '".$porte." ".$qtd_realizado_perc." %', y:".$quantidade."}";
	$leg          = $vetLeg[$porte];
	$leg          = $porte;
	$legenda_x4  .= " {$virgula} '{$leg}' ";  
	$virgula      = ', ';
}




?>

<script type="text/javascript" >


$(document).ready(function() {

    // Inicio Grafico 1
    chart1 = new Highcharts.Chart({
        chart: {
		    renderTo: '01_01',
            type: 'column'
			
			
        },
        title: {
		    xmargin:		    50,
            text: '<?php echo $titulo1; ?>',
			style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
			}
        },
        xAxis: {
			categories: [<?php echo $legenda_x1; ?>],
			
            title: {
                text: null
            }
        },
        yAxis: {
		    
            min: 0,
			//max: 100,
			gridLineWidth: 0,
			//reversed: true,
            title: {
                text: null,
				
                align: 'high'
            },
            labels: {
			    enabled: false,
                overflow: 'justify'
            }
        },
        
		tooltip: {
		    enabled: false,
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do Total<br/>'
		  //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}%</b> of total<br/>'
		    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false
					// format: '{point.y:.1f}%'
				    
					// format: '{point.y}%'
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
		
		
		
		
		series: [{
            name: 'Quantidade Atendimentos',
            colorByPoint: true,
            data: [
			{
                name: 'Prevista',
				//format: '{point.y}%',
				y: <?php echo $valores_g1p; ?>,
				color: 'rgba(0, 0, 255, 1)',
                drilldown: null,
				
				
				dataLabels: {  
					enabled: true, 
					// rotation: -90, 
					//rotation: +90, 
					color: '#000000', 
					align: 'center', 
					format: '{point.y} ppppp%',  
					//y: 1,  
					//x: 5, 
					style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				} 
				
				
				
            }, {
                name: 'Realizado',
                y: <?php echo $valores_g1r; ?>,
				color: 'rgba(255,0, 0, , 1)',
                drilldown: null,
				
				
				dataLabels: {  
					enabled: true, 
					color: '#000000', 
					align: 'center', 
					format: '{point.y} ppppp%',  
					style: { 
						fontSize: '12px' 
						// fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				}				
				
				
				
				
				
				
            }, {
                name: 'A Realizar',
                y: <?php echo $valores_g1ar; ?>,
				color: 'rgba(192,192, 192, 1)',
                drilldown: null,
				
				dataLabels: {  
					enabled: true, 
					color: '#000000', 
					align: 'center', 
					format: '{point.y} ppppp%',  
					style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				}				
								
				
				
				
            }
			
			]
			
        },
		
		
		
		{
            type: 'spline',
            name: 'Medidor',
			data: [<?php echo $valores_g1li; ?>],
            marker: {
                lineWidth: 1,
                //lineColor: Highcharts.getOptions().colors[3],
				color: '#FF0000',
				lineColor: '#FF0000'
                //fillColor: 'white'
            }
		}
		]
    });
  

// Grafico 2 = publico alvo
    
	
	
    chart2 = new Highcharts.Chart({
        chart: {
		    renderTo: '01_02',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
			
			
        },
        title: {
		    margin:		    10,
            text: '<?php echo $titulo2; ?>',
			style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
			}
        },
       
        
		tooltip: {
		    enabled: true,
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do Total<br/>'
		  //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}%</b> of total<br/>'
		    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
		legend: {
		    enabled: true
            
        },
        plotOptions: {
			
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
				 slicedOffset: 10,
				 
                dataLabels: {
                    enabled: true,
					useHTML: true,
					distance: 0,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					//format: '{y}',
					color:'#000000',
					x: 0,
                    y: 0,
                    style: {
						fontSize: '9px' 
                       // color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
					
                }
            }		
        },
        credits: {
            enabled: false
        },
		series: [{
            type: 'pie',
            name: 'Constituição Jurídica',
			colorByPoint: true,
            
            data: [<?php echo $valores_g2; ?>]
			/*
			dataLabels: {  
					enabled: true, 
					color: '#000000', 
					align: 'center', 
					format: '{point.y} ',  
					style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				}				
			*/	
        }
		]
    });
	
	
	// Grafico 3
    // Instrumentos
    //

    chart3 = new Highcharts.Chart({
        chart: {
		    renderTo: '01_03',
            type: 'column'
			
			
        },
        title: {
		    xmargin:		    50,
            text: '<?php echo $titulo3; ?>',
			style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
			}
        },
        xAxis: {
			categories: [<?php echo $legenda_x3; ?>],
			
			labels: {
			   // rotation: -90
				
                //overflow: 'justify'
				
            },
            title: {
                text: null
            }
			
        },
        yAxis: {
		    
            min: 0,
			//max: 100,
			gridLineWidth: 0,
			//reversed: true,
            title: {
                text: null,
				
                align: 'high'
            },
            labels: {
			    enabled: false,
				
                overflow: 'justify'
				
            }
        },
        
		tooltip: {
		    enabled: false,
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do Total<br/>'
		  //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}%</b> of total<br/>'
		    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false
					// format: '{point.y:.1f}%'
				    
					// format: '{point.y}%'
                }
            }
        },
        legend: {
		    enabled: false,
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
			rotation: -90,
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
		
		series: [{
            type: 'column',
            name: 'Instrumento',
			colorByPoint: true,
            
            data: [<?php echo $valores_g3; ?>],
			
			dataLabels: {  
					enabled: true, 
					color: '#000000', 
					align: 'center', 
					rotation: -90, 
					y: -10,
					//format: '{point.y} ',  
					style: { 
						fontSize: '10px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				}				
				
        }
		]
		
		
		
    });
  
// Grafico 2 = publico alvo
    
	
	
    chart2 = new Highcharts.Chart({
        chart: {
		    renderTo: '01_04',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
			
			
        },
        title: {
		    margin:		    10,
            text: '<?php echo $titulo4; ?>',
			style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
			}
        },
       
        
		tooltip: {
		    enabled: true,
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
          //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> do Total<br/>'
		  //  pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}%</b> of total<br/>'
		    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
        },
		legend: {
		    enabled: true
            
        },
        plotOptions: {
			
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
				 slicedOffset: 10,
				 
                dataLabels: {
                    enabled: true,
					useHTML: true,
					distance: 0,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
					//format: '{y}',
					color:'#000000',
					x: 0,
                    y: 0,
                    style: {
						fontSize: '9px' 
                       // color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
					
                }
            }		
        },
        credits: {
            enabled: false
        },
		series: [{
            type: 'pie',
            name: 'Público Alvo',
			colorByPoint: true,
            
            data: [<?php echo $valores_g4; ?>]
			/*
			dataLabels: {  
					enabled: true, 
					color: '#000000', 
					align: 'center', 
					format: '{point.y} ',  
					style: { 
						fontSize: '12px' 
						//fontWeight: 'bold' 
						//fontFamily: 'Verdana, sans-serif' 
					} 
				}				
			*/	
        }
		]
    });
	
	
	
    // fim grafico



});

</script>


