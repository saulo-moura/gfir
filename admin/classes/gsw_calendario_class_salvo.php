<?php
// <INICIO DO ARQUIVO>                                           //
//////////////////////////////////////////////////               //
//  GSW - V.1.0 - Julho 2016                                     //
//  Classe de Métodos - CALENDARIO                               //
//  Classe deve ser Instanciada apenas uma vez para o Sistema    //
////////////////////////////////////////////////////
// <INICIO CLASSE TGSW - Trata Calendario>

Require_Once('classes/gsw_html_class.php');
	

class TGSW_CALENDARIO
{
	private $modelo           = ""; 
	private $flagDono         = false;
    private $corMarcaDiaAtual = "";
	private $donoCalendario   = "";
	private $agenda_data       = "";
	private $width            = ""; 
	private $padding          = ""; 
	private $paddingLeft      = ""; 
	private $filtro           = false;
	private $vetCalendario    = Array();
    // 	
    public function __construct($vetCalendario)
    {
	    $this->vetCalendario  =  $vetCalendario;
		$this->modelo  = $vetCalendario['modelo'];
				
		if ($vetCalendario['flagDono']!='S')
		{
		    $this->flagDono = false;
		}
		else
		{
		    $this->flagDono = true;
		}
		if ($vetCalendario['filtro']!='S')
		{
		    $this->filtro = false;
		}
		else
		{
		    $this->filtro = true;
		}
		
		
		
		if ($vetCalendario['donoCalendario']=='')
		{
		    $this->donoCalendario = "Geral";
		}
		else
		{
		    $this->donoCalendario = $vetCalendario['donoCalendario'];
		}
		
		
		
		
		if ($vetCalendario['width']=='')
		{
		    $this->width = "width:100%;";
		}
		else
		{
		    $par           = $vetCalendario['width'];
		    $this->width   = "width:{$par};";
		}
		
		if ($vetCalendario['padding']=='')
		{
		    $this->padding      = "padding:0;";
		}
		else
		{
		    $par                = $vetCalendario['padding'];
		    $this->padding      = "padding:{$par};";
		}
		
		
		
		if ($vetCalendario['paddingLeft']=='')
		{
		    $this->paddingLeft = "padding-left:0;";
		}
		else
		{
		    $par                = $vetCalendario['paddingLeft'];
		    $this->paddingLeft  = "padding-left:{$par};";
		}
		
		if ($vetCalendario['linha']=='')
		{
		    $this->linha = 1;
		}
		else
		{
		    $this->linha        = $vetCalendario['linha'];
		}
		if ($vetCalendario['coluna']=='')
		{
		    $this->coluna = 1;
		}
		else
		{
		    $this->coluna       = $vetCalendario['coluna'];
		}
		if ($vetCalendario['corMarcaDiaAtual']=='')
		{
		    $this->corMarcaDiaAtual = "#247057";
		}
		else
		{
		    $this->corMarcaDiaAtual       = $vetCalendario['corMarcaDiaAtual'];
		}
		if ($vetCalendario['agenda_data']=='')
		{
		    $this->agenda_data = Date('d/m/Y');
		}
		else
		{
		    $this->agenda_data = $vetCalendario['agenda_data'];
		}
		
    }
    public function __destruct()
    {
		
    }
	public function SetCalendario($vetCalendario)
    {
		return 1;
	}
	public function MostraCalendario($vetHtml)
    {
		global $vetConf;
	
	    $flagDono       = $this->flagDono;
		$donoCalendario = $this->donoCalendario; 
		
		$linha          = $this->linha;
		$coluna         = $this->coluna;
		
	    $width          = $this->width; 
		$padding        = $this->padding; 
		$paddingLeft    = $this->paddingLeft; 
		
		$filtro         = $this->filtro; 
		
		//$corMarcaDiaAtual = "#247057";
		$corMarcaDiaAtual = $this->corMarcaDiaAtual;
		
		$cordestaque =  "#F1F1F1";
		
		
	    $html  = "";
		//
		$html .= "<div id='dialog-processando' class='col-lg-2' style=''></div>";
		
		
		$html .= "<div id='calendario_geral' class='col-lg-1' style='background: #F1F1F1; xheight:80em'>";
        //
		$html .= "<div class='col-lg-4' style='{$width} {$padding} float:left; background: #F1F1F1; xborder-right:1px solid #C0C0C0; '>";
		
		$html .= "<div id='calendario_destaque' style='background: #F1F1F1; '></div>";
		
		if ($flagDono==true)
		{   // Cabeçalho com o Dono
            $html .= "<h4>Nutricionista: {$donoCalendario} </h4>";
		}
		
		
		$html .= "<div id='calendario' style=''></div>";
		
		
		
		
		$html .= "<div id='calendario_instrucao' style='xpadding-left:1em; xborder:1px solid red; '>";
		$html .= "<div style='width:70%; xborder:1px solid blue; margin-left:3.5em;'>";
		
		$imagem1='imagens/icone_agendamento/incluir_cliente_ativado.png';
		$imagem2='imagens/icone_agendamento/pesquisar_cadastro_ativado.png';
		$imagem3='imagens/icone_agendamento/informar_ausencia_ativado.png';
		$imagem4='imagens/icone_agendamento/remover_cliente_ativado.png';
		$imagem5='imagens/icone_agendamento/historico_cliente_ativado.png';
		$imagem6='imagens/icone_agendamento/visualizar_agendamento_ativado.png';
		$imagem7='imagens/icone_agendamento/excluir_cliente_ativado.png';
		
		
		$html .= "<ul style='list-style-type:none;   '>";
		
		$html .= "<li style='line-height:3.0em;'>";
		$html .= "Legenda:";
		$html .= "</li>";
		
		
		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem1}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Incluir Cliente";
		$html .= "</li>";
		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem2}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Visualizar Cadastro";
		$html .= "</li>";
		
		/*
		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem3}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Informar Ausência";
		$html .= "</li>";
        */ 
		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem4}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Remover Cliente";
		$html .= "</li>";

		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem5}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Histórico de Agendamento";
		$html .= "</li>";

		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem6}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Visualizar Agendamento";
		$html .= "</li>";

		$html .= "<li style='line-height:0.5em;'>";
		$html .= "<img width='16' height='16' src='{$imagem7}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "Excluir Cliente";
		$html .= "</li>";


		$html .= "</ul>";
		$html .= "</div>";
		$html .= "</div>";
		
		$imagem8='imagens/minhaagenda.png';
		/*
		$html .= "<div id='minha_agenda' style=' padding-top:1em; xborder:1px solid red; text-align:center; '>";
		$html .= "<img width='64' height='64' src='{$imagem8}' style='padding-top:0.5em; padding-right:0.5em;' />";
		$html .= "<br/>";
		$html .= "Minha Agenda";
		
		$html .= "</div>";
		*/
		
		
		$html .= "</div>";
		
		
		
		
	    $html .= "<div id='filtro' class='col-lg-3' style=''>";
		
	    //
		$GSWHTML    = new TGSW_HTML($vetHtml);
		ForEach ($vetHtml as $idx => $vetPar) {
 		    if ($vetPar['tipo']=="Texto")
			{
				$html_c                     = $GSWHTML->Texto($vetPar);
				$html .= $html_c; 
			}
			if ($vetPar['tipo']=="SelecaoTabela")
			{
				$html_c                     = $GSWHTML->SelecaoTabela($vetPar);
				$html .= $html_c; 
			}
			if ($vetPar['tipo']=="BotaoSelecao")
			{
				$html_c                     = $GSWHTML->BotaoSelecao($vetPar);
				$html .= $html_c; 
			}
	    
		
		}
		// aqui ajustar depois
		$html .= "<div style='background:#F1F1F!; color:#2F66B8; fontize:14px; text-align:center;'>"; 
		$html .= "Por favor, selecione as Opções desejadas e, <b>para visualizar</b>, clicar em '<b>PESQUISAR</b>'"; 
		$html .= "</div>"; 
		
		$GSWHTML = null;	
		
		$html .= "</div>";
		
		
		$html .= "<div id='horario_geral' class='col-lg-6' style='float:left; width:68%; border:1px solid #FFFFFF; xborder-top:1px solid #FFFFFF; xborder-right:1px solid #FFFFFF; '>";
		
		$html .= "<div id='horario_cab'></div>";
        $html .= "<div id='horario'></div>";
		
		$html .= "</div>";

		
		$html .= "</div>";
		
		if ($vetConf['refresh_agenda'] == '') { 
        $vetConf['refresh_agenda'] = 30; 
        } 
		
        $refresh_agendat = $vetConf['refresh_agenda'] * 1000; 

		$agenda_data = $_SESSION[CS]['agenda_data'];
		
		// Carregar Datas da agenda
		
		$vetorDatasSituacao = $this->MontaVetorSistuacaoDatas($agenda_data);
		
		$html .= "<script type='text/javascript'>";
		// Carregar Datas da agenda
	
		//$vetorDatasSituacao = $this->MontaVetorSistuacaoDatas($agenda_data);
        $html .= " var vetorDatas = new Array(); ";
		$html .= " var vetorSituacao = new Array(); ";
		$html .= " var indice = 0; ";

		foreach ($vetorDatasSituacao as $data => $situacao) {
		    $html .= " indice = indice + 1; ";
			$html .= " vetorDatas[indice]    = '{$data}'; ";
			$html .= " vetorSituacao[indice] = '{$situacao}'; ";
		}
		
		$html .= " var RefreshTime = '{$refresh_agendat}'; "; 
		$html .= " var desativarefresh = 1; ";	
 
		$html .= " var turnot = 'S'; ";
		$html .= " var opcaop = 'GE'; ";
		
		$html .= " var data_atual = ''; ";
		
		$html .= ' Dia_Atual = new Array("Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");';
		$html .= ' Mes_Atual = new Array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");';
		
		// nesse vetor será cadastrado calendário de feriados
        $html .= "   disabled_dates = ['07/09/2016','22/03/2016'];  ";
		
		$html .= "    $(document).ready(function () { ";
//      $html .= "        var data_atual = new Date(datew, 'dd.mm.yyyy'); ";
//		$html .= "        var intervalo  = window.setInterval(RefreshTime, RefreshAgenda); ";

		
		
		
		$html .= "        $('#calendario').datepicker({  ";
		$html .= "            numberOfMonths: [{$linha}, {$coluna}], ";
		$html .= "            currentText: 'Ir para o dia de Hoje', ";
		$html .= "            showButtonPanel: true, ";
		
		
		$data_iw = $_SESSION[CS]['agenda_data_i'];
		$data_fw = $_SESSION[CS]['agenda_data_f'];
		
		// marretagem
//		$data_iw = "05/05/2017";
//		$data_fw = "12/05/2017";
		
		
		
		$vet     = explode('/',$data_iw);
		$dia     = $vet[0];
		$mes     = $vet[1]-1;
		$ano     = $vet[2];
	    // minDate: new Date(2007, 1 - 1, 1)
		// maxDate: new Date(2007, 1 - 1, 1)
		$html .= "            minDate: new Date({$ano},{$mes},{$dia}), ";
		$vet     = explode('/',$data_fw);
		$dia     = $vet[0];
		$mes     = $vet[1]-1;
		$ano     = $vet[2];
		$html .= "            maxDate: new Date({$ano},{$mes},{$dia}), ";
		
		$html .= "            hideIfNoPrevNext: true, ";
		
		//
		$html .= "            changeMonth: true, ";
		$html .= "            changeYear: true, ";
		
		$html .= "            onSelect: function (dateText) { ";
		$html .= "                agenda_carrega(dateText); ";
		$html .= "            }, ";
		
		$html .= "            onChangeMonthYear: function (year, month, inst) { ";
		//$html .= "                $('#calendario').datepicker('refresh'); ";
	//	$html .= "                alert(' year = '+year+' month = '+month); ";
		//$html .= " dataw = '{$agenda_data}'; ";
		$html .= "var mes = month; ";
		$html .= "if (mes<10)";
    	$html .= "{";
	    $html .= "    mes = '0'+mes;";
	    $html .= "}";
        //
		$html .= "var data_i = '{$data_iw}';";
		$html .= "var data_f = '{$data_fw}';";
        //		
		$data_iy = trata_data($_SESSION[CS]['agenda_data_i']);
		$data_fy = trata_data($_SESSION[CS]['agenda_data_f']);
	    $html .= "var data_iy = '{$data_iy}';";
		$html .= "var data_fy = '{$data_fy}';";
        //
		$html .= " dataw = '01'+'/'+mes+'/'+year; ";
		$html .= " $('#calendario').datepicker('setDate', dataw); ";
		
		$html .= " agenda_carrega(dataw); ";
	
		// $html .= "        var intervalo  = window.setInterval(RefreshAgenda, RefreshTime ); ";

		//$html .= "        location.reload(); ";
		
		$html .= "            }, ";
		
//		onChangeMonthYear  

//Type: Function( Integer year, Integer month, Object inst )
		
		
		$html .= "        beforeShowDay:function(datew){ ";
//$html .= "   console.log(date.toString()); ";
//console.log(d);
//$html .= "        alert(' data pas = '+datew); ";


//$html .= "        var formattedDate = $.fn.datepicker.DPGlobal.formatDate(date, 'dd.mm.yyyy', 'pl'); ";
$html .= "        var formattedDate = new Date(datew, 'dd.mm.yyyy'); ";



	$html .= "  dia = datew.getDate(); ";
	$html .= "	mes = datew.getMonth()+1; ";
	$html .= "  ano = datew.getFullYear(); ";
    $html .= "if (dia<10)";
	$html .= "{";
	$html .= "    dia = '0'+dia;";
	$html .= "}";
	$html .= "if (mes<10)";
	$html .= "{";
	$html .= "    mes = '0'+mes;";
	$html .= "}";

	$html .= " dta = dia+'/'+mes+'/'+ano; ";
	
    


//$html .= "        alert(' data pas bbbb = '+dta+' ---- '+formattedDate+'======'+datew); ";
$html .= "        if ($.inArray(dta.toString(), disabled_dates) != -1){ ";
//$html .= "        return {  ";
//$html .= "                  enabled : false  ";
//$html .= "               };  ";

$html .= "       return [0,'feriado','feriado....']; ";



$html .= "        }  ";

$html .= "        var indice = $.inArray(dta.toString(), vetorDatas); ";
//$html .= "        if ($.inArray(dta.toString(), vetorDatas) != -1){ ";
//$html .= "        var dtateste = dta.toString(); ";
//$html .= "        alert(' data pas bbbb = '+dtateste+' Indice ' +indice) ; ";


$html .= "        if (indice != -1){ ";
$html .= "            var situacao = vetorSituacao[indice]; ";
$html .= "            if (situacao == 'L') ";
$html .= "            { ";
$html .= "                     return [1,'disponivel','Disponibilidade para Agendamento...']; ";
$html .= "            } ";
$html .= "            else ";
$html .= "            { ";
$html .= "                return [1,'naodisponivel','Todos os Horárioa Não Disponíveis para Agendamento...']; ";
$html .= "            } ";
$html .= "        }  ";
$html .= "        else ";
$html .= "        { ";
$html .= "           return [0,'naodisponivelsem','Não Disponibilidade para Agendamento...']; ";
$html .= "        } ";



$html .= "            if(datew.toString().indexOf('Sun ')!=-1){ ";
$html .= "                     return [1,'feriado','Feriado...']; ";
$html .= "                }else if(datew.toString().indexOf('Sat ')!=-1){ ";
$html .= "                    return [1,'feriado','Feriado...']; ";
$html .= "                } ";
$html .= "                else { ";
$html .= "                    return [1]; ";
$html .= "                } ";

$html .= "            } ";

		
		
		
		$html .= "        }); ";
		$html .= "        $.datepicker._gotoToday = function (id) { ";
		$html .= "            $(id).datepicker('setDate', new Date()); ";
		$html .= "            agenda_carrega($(id).datepicker('getDate').toLocaleDateString()); ";
		$html .= "        }; ";

/*
$html .= " $('#calendario').datepicker({ ";
$html .= "        beforeShowDay:function(date){ ";
//$html .= "  //  console.log(date.toString()); ";

            
$html .= "            if(date.toString().indexOf('Sun ')!=-1){ ";
$html .= "                     return [1,'vermelho']; ";
$html .= "                }else if(date.toString().indexOf('Sat ')!=-1){ ";
$html .= "                    return [1,'azul']; ";
$html .= "                } ";
$html .= "                else { ";
$html .= "                    return [1]; ";
$html .= "                } ";

$html .= "            } ";



$html .= "    })	";	
*/	
/*
		$html .= " data = new Date(); ";
	    $html .= " dia = data.getDate();";
		$html .= " mes = data.getMonth();";
		$html .= " ano = data.getFullYear();";
		$html .= " if (mes<10) { ";
		$html .= "     mes = '0'+mes; ";
		$html .= " } ";
*/		
		
//		$html .= " dataw = dia+'/'+mes+'/'+ano; ";
		
		
		//$html .= " dataw = ''; ";
		
		
		$html .= " dataw = '{$agenda_data}'; ";
		$html .= " $('#calendario').datepicker('setDate', dataw); ";
		
		$html .= " agenda_carrega(dataw); ";
	
//        $html .= "        var data_atual = new Date(datew, 'dd.mm.yyyy'); ";
		$html .= "        var intervalo  = window.setInterval(RefreshAgenda, RefreshTime ); ";

	
	
		$html .= "    }); ";
		
		
		
		$html .= "function agenda_carrega(dateText) { ";
		// $html .= " alert('to ferrado 1'); ";
        $html .= "$.ajax({ ";
        $html .= "    dataType: 'json', ";
        $html .= "    type: 'POST', ";
        $html .= "    url: 'ajax_calendario.php?tipo=agenda_carrega', ";
        $html .= "    data: { ";
        $html .= "        data: dateText ";
        $html .= "    }, ";
        $html .= "    beforeSend: function () { ";
        $html .= "        processando(); ";
        $html .= "    }, ";
        $html .= "    complete: function () { ";
        $html .= "        $('#dialog-processando').remove(); ";
        $html .= "    }, ";
        $html .= "    success: function (response) { ";
        $html .= "        if (response.erro == '') { ";
		$html .= "              data_atual = dateText; ";
		//$html .= "		    alert('fui e voltei'+response.html); "; 
		// $html .= "		    $('#horario').append(response.html); ";
		//$html .= "		    $('#horario_cab').text(url_decode(response.html_cab)); ";
		$html .= "		    document.getElementById('horario_cab').innerHTML = url_decode(response.html_cab); ";
		
		
		//$html .= "		    $('#horario').text(url_decode(response.html)); ";
		//$html .= "		    document.getElementById('horario').innerHTML = response.html; ";
		
		//$html .= "		    $('#calendario_destaque').text((response.destaque)); ";
		$html .= "		    document.getElementById('horario').innerHTML = url_decode(response.html); ";
		
		$html .= "		    document.getElementById('calendario_destaque').innerHTML = url_decode(response.destaque); ";
		
		$html .= " if (turnot=='S') ";
		$html .= " { ";
		$html .= "          Turno(opcaop); ";
		$html .= " } ";
		$html .= " else ";
		$html .= " { ";
		$html .= "          Status(opcaop); ";
		$html .= " } ";
        //$html .= " alert (' -- '+turnot+' -- '+opcaop); ";
        $html .= "		    TelaHeight(); ";
		$html .= "		    TelaHeightAgenda(); ";

        $html .= "        } else { ";
        $html .= "            $('#dialog-processando').remove(); ";
        $html .= "            alert(url_decode(response.erro)); ";
        $html .= "        } ";
        $html .= "    }, ";
        $html .= "    error: function (jqXHR, textStatus, errorThrown) { ";
        $html .= "        $('#dialog-processando').remove(); ";
        $html .= "        alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown); ";
        $html .= "    }, ";
        $html .= "    async: false ";
        $html .= "}); ";
		
		$html .= "} ";
		
		
		$html .= " function Turno(opcao) { ";
		
		$html .= " turnot = 'S'; ";
		$html .= " opcaop = opcao; ";

		
    	$html .= " var classw='.linhas'; ";
        $html .= " $(classw).each(function() { ";
		$html .= " $(this).hide(); ";
        $html .= " }); ";
		$html .= "  classw='.'+opcao; ";
        $html .= " $(classw).each(function() { ";
		$html .= " 	$(this).show(); ";
        $html .= " }); ";
		
		$html .= "  classw='.status'; ";
		$html .= " $(classw).each(function() { ";
		$html .= " 	$(this).css('color', '#666666'); ";
        $html .= " }); ";
		
		$html .= "  classw='.opcao'; ";
		$html .= " $(classw).each(function() { ";
		$html .= " 	$(this).css('color', '#666666'); ";
        $html .= " }); ";
		
		$html .= "  var id = '#id_'+opcao; ";
		$html .= " 	$(id).css('color', '#FFFFFF'); ";
		
		
		$html .= "} ";
		
		$html .= " function Status(opcao) { ";
		
        $html .= " turnot  = 'N'; ";
		$html .= " opcaop = opcao; ";
		
		
    	$html .= " var classw='.linhas'; ";
        $html .= " $(classw).each(function() { ";
		$html .= " $(this).hide(); ";
        $html .= " }); ";
		
		$html .= "  classw='.'+opcao; ";
        $html .= " $(classw).each(function() { ";
		$html .= " 	$(this).show(); ";
        $html .= " }); ";
		
		$html .= "  classw='.opcao'; ";
		$html .= " $(classw).each(function() { ";
		$html .= " 	$(this).css('color', '#666666'); ";
        $html .= " }); ";
		
		
		$html .= "  classw='.status'; ";
		$html .= " $(classw).each(function() { ";
		$html .= " 	$(this).css('color', '#666666'); ";
        $html .= " }); ";
		
		$html .= "  var id = '#id_'+opcao; ";
		$html .= " 	$(id).css('color', '#FFFFFF'); ";
		
		
		$html .= "} ";
		
    $html .= "function TelaHeightAgenda() { ";
	$html .= " return true; ";
	$html .= " var tam_filtro        = $('#filtro').height(); ";
	// $html .= " var tam_horario_cab   = $('#horario_cab').height(); ";
	$html .= " var tam_horario_geral = $('#horario_geral').height(); ";
	
	$html .= " var tam_lado_2 = tam_filtro+tam_horario_geral; ";
	
	$html .= " var tam_calendario_destaque = $('#calendario_destaque').height(); ";
	$html .= " var tam_calendario          = $('#calendario').height(); ";
	
    $html .= " var tam_lado_1 = tam_calendario_destaque+tam_calendario; ";
	
	$html .= " var tam_tela = tam_lado_2; ";
	$html .= " if  (tam_lado_1>tam_lado_2) ";
	$html .= " { ";
	$html .= "     tam_tela=tam_lado_1; ";
	$html .= "     $('#horario_geral').height(tam_lado_1); ";
	$html .= " } ";
	
	$html .= " $('#calendario_geral').height(tam_tela); ";
	
	$html .= " alert(' tam_lado_1 '+tam_lado_1+' tam_lado_2 '+tam_lado_2+' tam_tela '+tam_tela); ";
	
	
	$html .= "} ";
	/*
    if ($('div#div_geral').length > 0) {
        $('div#conteudo' + popup).height('');

        var menos = 0;

        if ($('div#div_topo').css('display') != 'none') {
            menos += $('div#div_topo').height();
        }

        menos += $('div#div_rodape').height();

        if ($('div#div_geral').height() < $(window).height() - menos) {
            var height = $(window).height() - $('div#div_geral').height();
            height += $('div#conteudo' + popup).height();
            height -= menos;
            $('div#conteudo' + popup).height(height);
        }
    }

    if ($.isFunction(self.ajusta_altura_PopWin)) {
        ajusta_altura_PopWin('');
    }

    if (postMessageAcao) {
        parent.postMessage($('#geral_cadastro').outerHeight(true), postMessageUrl);
    }
}
	*/	
		$html .= "</script>";
		

	// Funções da Agenda	
	$html .= "<script>";
	$html .= " function ChamaFuncao1(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	//$html .= " alert(' funcao 1 marcação - grc_atendimento_agenda '+idt_atendimento_agenda+' PA '+idt_ponto_atendimento); ";
	//
	//  $html .= "return 1;";
	//
    $html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
	
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_marcacao'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 950; ";
	
	
    $html .= " var titulo = ".'"'."<div style='xwidth:700px; display:block; text-align:center; '>Marcar Atendimento</div>".'";';
	
	
	//$html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_marcacao'; ";
	
   // $html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	//$html .= " alert('loucura '); ";
	
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	
	//$html .= " alert('loucura 1 '); ";
	    
	$html .= "   DistanciaMarcacao = window.open(href,'DistanciaMarcacao','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";
	
	
	
	// new_window.onBeforeUnload = function(){ my code}
	// $html .= " alert('loucura 2 '); ";
    // $html .= "   DistanciaMarcacao.onBeforeUnload = function(){ RetornarClose(); }; ";
	
	
	
	
	$html .= " return 1;";
    $html .= " } ";	
	$html .= " function close_ChamaFuncao1(returnVal) { ";
	$html .= " } ";
	//
    $html .= " function ChamaFuncao2(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	//$html .= " alert(' funcao 2  - cadastro'); ";
	
	
	
	
	
	$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia&acaoc=con'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_marcacao'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='xwidth:700px; display:block; text-align:center; '>Marcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var DistanciaMarcacaoc = window.open(href,'DistanciaMarcacaoc','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";
	$html .= " return 1;";
	
	
	
	$html .= " } ";
	
	
	$html .= " function ChamaFuncao3(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	$html .= " alert(' funcao 3 - informar ausência'); ";
	
	$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_ausencia'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='width:100%; display:block; text-align:center; font-size:10em; '>Informar Ausência</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var DistanciaMarcacaod = window.open(href,'DistanciaMarcacaod','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";

	
	
	
	
	$html .= " return 1;";
  
	
	
	
	$html .= " } ";
	$html .= " function ChamaFuncao4(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	//$html .= " alert(' funcao 4 desmarcação - grc_atendimento_agenda '+idt_atendimento_agenda); ";
	//
	//  $html .= "return 1;";
	//
    $html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_desmarcacao'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='width:100%; display:block; text-align:center; font-size:10em; '>Desmarcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var DistanciaMarcacaoe = window.open(href,'DistanciaMarcacaoe','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";

	
	
	
	
	$html .= " return 1;";
  
	$html .= " } ";
	$html .= " function ChamaFuncao5(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { "; // histórico do Agendamento
	// $html .= " alert(' funcao 5'); ";
	$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
    $html .= " var href    ='conteudo_historico_agendamento.php?prefixo=inc&menu=historico_agendamento'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='width:100%; display:block; text-align:center; font-size:10em; '>Desmarcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var HistoricoAgendamento = window.open(href,'HistoricoAgendamento','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";

	
	
	
	
	$html .= " } ";
	$html .= " function ChamaFuncao6(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	
	//$html .= " alert(' funcao 6'); ";
	
	
		
	
	$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_visualizar'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='width:100%; display:block; text-align:center; font-size:10em; '>Desmarcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var  VisualizarMarcacao = window.open(href,'VisualizarMarcacao','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";



$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia&acaoc=con'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_marcacao'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='xwidth:700px; display:block; text-align:center; '>Marcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var DistanciaMarcacaof = window.open(href,'DistanciaMarcacaof','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";
	$html .= " return 1;";
	
	
	
	
	
	$html .= " } ";
	$html .= " function ChamaFuncao7(idt_atendimento_agenda,idt_ponto_atendimento) ";
	$html .= " { ";
	//$html .= " alert(' funcao 7'); ";
	
	
	
	$html .= " var parww='&idt_atendimento_agenda='+idt_atendimento_agenda+'&idt_ponto_atendimento='+idt_ponto_atendimento+'&deondeveio=Distancia'; ";
    $html .= " var href    ='conteudo_cadastro_agenda.php?prefixo=cadastro&menu=grc_atendimento_agenda_excluir'+parww; ";
	
    $html .= " var  height = $(window).height(); ";
    $html .= " var  width  = $(window).width(); ";
	
	$html .= " var  height = 600; ";
    $html .= " var  width  = 900; ";
	
	
    $html .= " var titulo = ".'"'."<div style='width:100%; display:block; text-align:center; font-size:10em; '>Desmarcar Atendimento</div>".'";';
	
	
    //$html .= " showPopWin(href, titulo , width, height, close_ChamaFuncao1);";
	
	$html .= "   var  left   = 0; ";
	$html .= "   var  top    = 0; ";
	$html .= "   var  height = $(window).height(); ";
	$html .= "   var  width  = $(window).width();  ";
	$html .= "   var ExcluirMarcacao = window.open(href,'ExcluirMarcacao','left='+left+',top='+top+',width='+width+',height='+height+',resizable=yes,menubar=no,scrollbars=yes,toolbar=no'); ";

	$html .= " } ";	
	$html .= " function RefreshAgenda() ";
	$html .= " { ";
	$html .= "     if (desativarefresh == 1) ";	
	$html .= "     { ";
    $html .= "        agenda_carrega(data_atual); ";	
	$html .= "     } ";	
	$html .= " } ";	
    $html .= "</script>"; 
	
		
		
		
		
		
		
        return $html;
    }
	
	
	private function MontaVetorSistuacaoDatas($data_base)
    {
		$vetStatusAgendaR=Array();
		$vetStatusAgendaR['AGENDADO']      = 'LIVRE';
		$vetStatusAgendaR['Agendado']      = 'LIVRE';
		
		$vetStatusAgendaR['Bloqueado']     = 'BLOQUEADO';
		$vetStatusAgendaR['BLOQUEADO']     = 'BLOQUEADO';
		
		$vetStatusAgendaR['MARCADO']       = 'MARCADO';
		$vetStatusAgendaR['Marcado']       = 'MARCADO';
		
		$vetStatusAgendaR['CANCELADO']     = 'CANCELADO';
		$vetStatusAgendaR['Cancelado']     = 'CANCELADO';
		
		//
		$vetStatusAgendaR['PRESENTE']      = 'PRESENTE';
		$vetStatusAgendaR['AUSENTE']       = 'AUSENTE';
		$vetStatusAgendaR['EM ATENDIMENTO']= 'EM ATENDIMENTO';
		$vetStatusAgendaR['FINALIZADO']    = 'FINALIZADO';
		$vetStatusAgendaR['DESISTENTE']    = 'DESISTENTE';
		//
		$vetStatusAgenda=Array();
		$vetStatusAgenda['AGENDADO']      = '#0000FF';
		$vetStatusAgenda['MARCADO']       = '#0000FF';
		
		$vetStatusAgenda['BLOQUEADO']     = '#FF0000';
		$vetStatusAgenda['LIVRE']         = '#00FF00';
		
		$vetStatusAgenda['CANCELADO']     = '#000000';
		//
		$vetStatusAgenda['PRESENTE']      = '#FFFFFF';
		$vetStatusAgenda['AUSENTE']       = '#FFFFFF';
		$vetStatusAgenda['EM ATENDIMENTO']= '#FFFFFF';
		$vetStatusAgenda['FINALIZADO']    = '#FFFFFF';
		$vetStatusAgenda['DESISTENTE']    = '#FFFFFF';





    $vetorDatas       = Array();
	$TabelaPrinc      = "grc_atendimento_agenda";
	$AliasPric        = "grc_aa";
	$Entidade         = "Agenda";
	$Entidade_p       = "Agendas";
	
	$data_hoje        = Date('d/m/Y');
	$data_hoje_banco  = Date('Y-m-d');
	$hora_hoje_banco  = Date('H:i'); 
	$data_i           = $data_hoje;           
	
	
	//$vet              = explode('/',$data_base);
	$delayinicialw = '-15 day';
	$data_hojew        = Date('d/m/Y', strtotime($delayinicialw)); 
	$vet              = explode('/',$data_hojew);
	$delayinicial = '+60 day';
	$data_i           = '01/'.$vet[1].'/'.$vet[2];           
	$datamaior        = Date('d/m/Y', strtotime($delayinicial)); 
	$vet              = explode('/',$datamaior);
	
	$ultimo           = cal_days_in_month(CAL_GREGORIAN, $vet[1], $vet[2]); // número de dias do mes
	$data_f           = $ultimo.'/'.$vet[1].'/'.$vet[2];           
	
	echo "<div style='border-bottom:2px solid #FFFFFF; font-size=10px; color:#0000FF; padding-left:20px; display:block; text-align:center;'>";
	echo "Período de $data_i até $data_f";
	echo "</div>";
	//$vet              = explode('/',$data_i);
	//$data_i           = '01/'.$vet[1].'/'.$vet[2];           
	//echo "ppppppppppppppppppp ".$data_i;
	//$data_i           = '01'.'/'.'01'.'/'.'2016';           
	//$data_f           = '01'.'/'.'03'.'/'.'2017';           
	
	// filtros
	$idt_unidade_regional  = $_SESSION[CS]['agenda_idt_unidade_regional'];
	$idt_ponto_atendimento = $_SESSION[CS]['agenda_idt_ponto_atendimento'];
	$idt_consultor         = $_SESSION[CS]['agenda_idt_consultor'];
	$idt_servico           = $_SESSION[CS]['agenda_idt_servico'];
	$_SESSION[CS]['agenda_data_i'] = $data_i;
	$_SESSION[CS]['agenda_data_f'] = $data_f;
	
//echo $_SESSION[CS]['agenda_data_i']."......... <br />";
//echo $_SESSION[CS]['agenda_data_f']."......... <br />";
	
    $sql   = "select ";
	$sql  .= "   {$AliasPric}.data, {$AliasPric}.hora, {$AliasPric}.situacao, {$AliasPric}.semmarcacao, {$AliasPric}.marcador, ";
	//$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";
	$sql  .= "   gae.descricao as gae_descricao,  ";
	$sql  .= "   ga.situacao as ga_situacao,  ";
	$sql  .= "   ge.descricao as ge_descricao,  ";
	$sql  .= "   pu.nome_completo as pu_nome_completo,  ";
	$sql  .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
	$sql  .= "   sos.descricao as sos_descricao,  ";
	$sql  .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";
	$sql  .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
	$sql  .= "   sos.descricao as sos_descricao,  ";
	$sql  .= "  gae.descricao as especialidade , ";
	$sql  .= "  sos.descricao as ponto_atendimento , ";
	
	$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";
	$sql  .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";
	$sql  .= " from {$TabelaPrinc} as {$AliasPric} ";
	$sql  .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
	$sql  .= " left  join ".db_pir_gec."gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
	$sql  .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
	//     $sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
	$sql  .= " left join ".db_pir."sca_organizacao_secao as sos on sos.idt = {$AliasPric}.idt_ponto_atendimento ";
	if ($idt_servico!="")
	{
	    $sql  .= " left  join grc_atendimento_agenda_servico as grc_aas on grc_aas.idt = {$AliasPric}.idt ";
		
	}
	$dt_iniw   = trata_data($data_i);
	$dt_fimw   = trata_data($data_f);
	$sql .= ' where ';
	$sql .= " grc_aa.origem = 'Hora Marcada' ";
	$sql .= " and grc_aa.data >= ".aspa($dt_iniw)." and grc_aa.data <=  ".aspa($dt_fimw)." " ;
	
	if ($idt_unidade_regional!="" and $idt_ponto_atendimento=="")
	{
        // Fazer where
        $sqlUR  = "select classificacao   ";
		$sqlUR .= " from ".db_pir."sca_organizacao_secao as sos";
        $sqlUR .= ' where ';
		$sqlUR .= ' sos.idt = '.null($idt_unidade_regional);
	    $rsUR   = execsql($sqlUR);
		if ($rsUR->rows <= 0 )
		{
		    // erro, reportar
		}
		else
		{
			foreach ($rsUR->data as $rowUR)
			{
				$classificacao_unidade = substr( $rowUR['classificacao'],0,5) . "%";
				$sql .= " and sos.classificacao like ".aspa($classificacao_unidade)." and sos.posto_atendimento = 'S' " ;
			}	
        }
	}
	else
	{
		if ($idt_ponto_atendimento!="")
		{
		   $sql .= " and grc_aa.idt_ponto_atendimento = ".null($idt_ponto_atendimento);
		}
	}
	if ($idt_consultor!="")
	{
	   $sql .= " and grc_aa.idt_consultor = ".null($idt_consultor);
	}
	if ($idt_servico!="")
	{
	    $sql .= " and grc_aas.idt_servico = ".null($idt_servico);
	}
	
	
	// $sql .= " order by {$AliasPric}.data, {$AliasPric}.hora, sos.descricao   ";
	$vetorDatasSituacao=Array();
	$rs   = execsqlNomeCol($sql);
	if ($rs->rows <= 0 )
	{
	}
	else
	{
		foreach ($rs->data as $row)
		{
		    $data        = trata_data($row['data']);
			
			$data_banco  = $row['data'];
			$hora        = $row['hora'];
			$situacao    = $row['situacao'];
			$semmarcacao = $row['semmarcacao'];
			$marcador    = $row['marcador'];
			
			// data,hora,situacao,semmarcacao,marcador 
			$situacaow   = $vetStatusAgendaR[$situacao];
            if ($situacaow=="")
			{
                $situacaow=$situacao;
			}
			if ($situacaow=='LIVRE')
			{
			    // só será livre se maior que hoje
				
				if ($data_banco >= $data_hoje_banco)
				{
				    if ($data_banco == $data_hoje_banco)
				    {
						if ($hora > $hora_hoje_banco)
						{
							$vetorDatasSituacao[$data]="L"; // indicar que tem agendamento
						}
						else
						{
							$vetorDatasSituacao[$data]="S";
							// tirar
					    //	$vetorDatasSituacao[$data]="L"; // indicar que tem agendamento
						}
					}	
					else
					{
						$vetorDatasSituacao[$data]="L"; // indicar que tem agendamento
					
					}
				}
				else
				{
				    $vetorDatasSituacao[$data]="S";
					// tirar
					//$vetorDatasSituacao[$data]="L"; // indicar que tem agendamento
				}
			}	
			else
			{
			    if ($vetorDatasSituacao[$data]!="L")
				{
				    $vetorDatasSituacao[$data]="S";
				}
			}
        }	
    }

    return $vetorDatasSituacao;
    }
	
	
}
////////////////////////////////////////////////////
// <FIM DO ARQUIVO>                               //
////////////////////////////////////////////////////
?>