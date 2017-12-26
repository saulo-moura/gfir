<style>
div#painel_cont {
    xborder: 1px solid;
    margin-left: 30px;
}

div#painel_cont > div.cell > span > div {
    xpadding-top:15px;
}

div#painel_cab {
    border: 1px solid;
    background:#0000ff;
    xmargin-left: 30px;
    color:#FFFFFF;
    text-align:center;
}
div#painel_rod {
    border: 1px solid;
    xmargin-left: 38px;
    background:#0000ff;
    color:#FFFFFF;
    text-align:center;
}



div.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;
}

.bt_volta_painel {
    Xborder: 1px solid;
    xmargin-left: 38px;
    background:#ECF0F1;
    color:#000000;
    text-align:left;

}


Input.Botao {

    border: 1px solid transparent;
    padding-left:10px;
    background:#C4C9CD;
    color:#FFFFFF;


}

</style>

<?php
$_SESSION[CS]['grc_atendimento_avulso'] = $_SERVER['REQUEST_URI'];

$veio_atendimento=1;
$codigo_painel = 'grc_presencial_site';
require_once 'painel.php';
?>
<script>
function InitHighChart(container,titulo,subtitulo,tipografico,dimensao)
{
	$("#"+container).html("Aguarde, Carregando Gráfico...");
	
	var legendasim = 'false';
	if (tipografico=='pie')
	{
        legendasim = 'true';
    }
	var options = {
		chart: {
			renderTo: container,
			type: tipografico
			
		},
		credits: {
			enabled: false
		},
		title: {
			text: titulo+' - '+subtitulo,
			x: +5,
			style: {
                fontWeight: 'normal',
                fontSize: '12'
            }
		},
        subtitle: {
            text: null,
            x: -20
        },
		xAxis: {
			categories: [{}]
		},
		yAxis: {
                title: {
                    text: null
                }
            },
		legend: {
            enabled: legendasim
        },
        plotOptions: {
            column: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }

                }
            },

            pie: {
                allowPointSelect: true,
                slicedOffset: 10,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    crop:false,
                    overflow:"none",
                    //overflow:"justify",
                    connectorPadding: 0,
                    connectorWidth: 0,
                    distance: 5,
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        //color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        //color:  'black',
                        fontWeight: 'normal',
                        fontSize: '10'
                    },
                    formatter: function() {
                        if (tipografico=='pie')
                        {
                          var nome_serie = this.point.series.name;
                          var nome_ponto = this.point.name;
                          //var s = nome_ponto+' '+this.point.percentage+'%';
                          var s = this.point.percentage+'%';
                          return s;
                        }
                        else
                        {

                        }
                    }

                },
            }
        },
		tooltip: {
            formatter: function() {
                if (tipografico!='pie')
                {
                    var s = '<b>'+ this.x +'</b>';
                    $.each(this.points, function(i, point) {
                        s += '<br/>'+point.series.name+': '+point.y;
                    });
                }
                else
                {
                    var s = '';
                    s = '<br/>'+point.series.name+': '+point.percentage;
                    //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'

                }
                //var s = ' ttttttttttttt '+s;
                return s;
            },
            shared: true
        },
		//series: [{},{}]
		series: [{}]
	};

	$.ajax({
		url: "ajax_atendimento.php?tipo=GraficoPainelBordo&dim="+dimensao+"&opcao=P",
		data: 'show=Vetquantidade',
		type:'post',
		dataType: "json",
		success: function(data){
			options.xAxis.categories = data.Vetcategorias;
			options.series[0].name = dimensao;
			options.series[0].data = data.Vetquantidade;
			//options.series[1].name = 'Click';
			//options.series[1].data = data.clicks;
			var chart = new Highcharts.Chart(options);
                        TelaHeight();
		}
	});
}
function RefreshPainelBordo(opcao)
{
    var str = '';
    $.post('ajax_atendimento.php?tipo=RefreshPainelBordo', {
        async : false,
		opcao : opcao
    }
    , function (str) {
        if (str == '')
        {
           alert('Erro de refresh no Painel de Bordo');
        }
        else
        {
           var id='PainelBordo';
           objx = document.getElementById(id);
           if (objx != null) {
               objx.innerHTML=str;
               grafico1();
               grafico2();
               grafico3();
               TelaHeight();
           }
        }
    });
    return false;
}


function EscolhaPainel(opc)
{
    alert(' opcao '+opc);
    return false;
}

</script>
<script type="text/javascript">
  function grafico1()
  {
     var titulo    = "Atendimentos - Total";
     var subtitulo = "Últimos 4 dias";
     var container = "container1";
     var tipografico = 'column';
     var dimensao    = 'data';
     InitHighChart(container,titulo,subtitulo,tipografico,dimensao);
  }
  function grafico2()
  {
     var titulo    = "Atendimentos - Porte";
     var subtitulo = "Últimos 4 dias";
     var container = "container2";
     var tipografico = 'pie';
     var dimensao    = 'porte';
     InitHighChart(container,titulo,subtitulo,tipografico,dimensao);
  }
  function grafico3()
  {
     var titulo    = "Atendimentos - PJ e PF";
     var subtitulo = "Últimos 4 dias";
     var container = "container3";
     var tipografico = 'pie';
     var dimensao    = 'PJPF';
     InitHighChart(container,titulo,subtitulo,tipografico,dimensao);
  }
</script>