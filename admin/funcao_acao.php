<?php



function SomarData($data, $dias, $meses, $ano) {
    /* www.brunogross.com */
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
    return $newData;
}

function DifData_dia($data1, $data2) {
//defino data 1
    $vet = Array();
    $vet = explode("/", $data1);
    $ano1 = $vet[2];
    $mes1 = $vet[1];
    $dia1 = $vet[0];

//defino data 2
    $vet = Array();
    $vet = explode("/", $data2);
    $ano2 = $vet[2];
    $mes2 = $vet[1];
    $dia2 = $vet[0];

//calculo timestam das duas datas
    $timestamp1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
    $timestamp2 = mktime(4, 12, 0, $mes2, $dia2, $ano2);

//diminuo a uma data a outra
    $segundos_diferenca = $timestamp1 - $timestamp2;
//echo $segundos_diferenca;
//converto segundos em dias
    $dias_diferenca = $segundos_diferenca / (60 * 60 * 24);

//obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
    $dias_diferenca = abs($dias_diferenca);

//tiro os decimais aos dias de diferenca
    $dias_diferenca = floor($dias_diferenca);

    return $dias_diferenca;
}



function DifData_dia_fechado($data1,$data2)
{
    if ($data1=='')
    {
        return 0;
    }
    if ($data2=='')
    {
        return 0;
    }

//defino data 1
$vet=Array();
$vet = explode("/", $data1);
$ano1 = $vet[2];
$mes1 = $vet[1];
$dia1 = $vet[0];

//defino data 2
$vet=Array();
$vet = explode("/", $data2);
$ano2 = $vet[2];
$mes2 = $vet[1];
$dia2 = $vet[0];

//calculo timestam das duas datas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
//$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2);

//diminuo a uma data a outra
$segundos_diferenca = $timestamp1 - $timestamp2;
//echo $segundos_diferenca;

//converto segundos em dias
$dias_diferencaw = $segundos_diferenca / (60 * 60 * 24);

//obtenho o valor absoluto dos dias (tiro o possível sinal negativo)
//$dias_diferenca = abs($dias_diferenca);


//tiro os decimais aos dias de diferenca
//$dias_diferenca = (int) floor($dias_diferencaw);

$dias_diferenca = (int) floor($dias_diferencaw);

//if ($dias_diferenca!=$dias_diferencaw)
//{
    $dias_diferenca = $dias_diferenca + 1;
//}
return $dias_diferenca;
}
//
//  Data de Inicio  = $data_inicio
//  Número de Dias úteis = $ndu
//  [saida] como parâmetro Número de dias corridos = &$ndc
//  [saida] como parâmetro  Data Final = $dic
function CalculaDiasCorridos($data_inicio,$ndu,&$ndc,&$dic)
{
    $kokw=1;
    $data_inicial         = $data_inicio;

    $numero_dias_uteis    = $ndu;
    $numero_dias_corridos = 0;

    $data         = $data_inicial;
    $meses        = 0;
    $ano          = 0;
    $qtd_feriados = 0;
    $qtd_uteis    = 0;
    $intervalo    = $numero_dias_uteis + 800;
    
	//if ($_SESSION[CS]['g_vet_feriado_obra_par']=="")
	//{
	   $codtab = ""; 
	   CarregarFeriadoPAR($codtab);
	//}
    $vet_feriado  = $_SESSION[CS]['g_vet_feriado_obra_par'];

   // p($vet_feriado);




    if ($data_inicio=="22/06/2013")
    {
        //echo ' $ndu  '.$ndu."<br />";
    }

    //echo ' $intervalo  '.$intervalo."<br />";

    for ($c = 0; $c < $intervalo; $c++) {
         
         //$data = SomarData($data, 1, 0, 0);
        // echo ' $data  '.$data;
         if ($vet_feriado[$data]!='')
         {
          //   echo ' $data  f '.$data."<br />";
             $qtd_feriados = $qtd_feriados + 1;
         }
         else
         {
           //  echo ' $data  u '.$data."<br />";
             $qtd_uteis = $qtd_uteis + 1 ;
         }
		 
		 if ($numero_dias_uteis==$qtd_uteis)
         {
             $numero_dias_corridos = $qtd_uteis + $qtd_feriados;
             break;
         }
         $data = SomarData($data, 1, 0, 0);
    }
    $ndc = $numero_dias_corridos-1;
    $dic = SomarData($data_inicial, $ndc, 0, 0);

    // echo ' ndc '.$ndc.' inicial '.$data_inicial. ' final '.$dic.'<br />';

    return $kokw;
}

function CalculaDiasCorridosPratras($data_inicio,$ndu,&$ndc,&$dic)
{
    $kokw=1;
    $data_inicial         = $data_inicio;

    $numero_dias_uteis    = $ndu;
    $numero_dias_corridos = 0;

    $data         = $data_inicial;
    $meses        = 0;
    $ano          = 0;
    $qtd_feriados = 0;
    $qtd_uteis    = 0;
    $intervalo    = $numero_dias_uteis + 400;

    //CarregarFeriadoPAR($codtab);
    $vet_feriado  = $_SESSION[CS]['g_vet_feriado_obra_par'];

//    p($vet_feriado);

    for ($c = 0; $c < $intervalo; $c++) {

         if ($numero_dias_uteis==$qtd_uteis)
         {
             $numero_dias_corridos = $qtd_uteis + $qtd_feriados;
             break;
         }

         $data = SomarData($data, -1, 0, 0);


         if ($vet_feriado[$data]!='')
         {
             $qtd_feriados = $qtd_feriados + 1;
         }
         else
         {
             $qtd_uteis = $qtd_uteis + 1 ;
         }
    }


    $ndc = $numero_dias_corridos*(-1);
    $dic = SomarData($data_inicial, $ndc, 0, 0);

    // echo ' ndc '.$ndc.' inicial '.$data_inicial. ' final '.$dic.'<br />';

    return $kokw;
}


function EncontrarPrimeiroUtil($datan)
{
    $qtd_feriados = 0;
    $intervalo    = 100;
    //CarregarFeriadoPAR($codtab);
    $vet_feriado  = $_SESSION[CS]['g_vet_feriado_obra_par'];
    $data = $datan;
    for ($c = 0; $c < $intervalo; $c++) {
         if ($vet_feriado[$data]!='')
         {
             $qtd_feriados   = $qtd_feriados + 1;
             $dataw = SomarData($data, 1, 0, 0);
             $data  = $dataw;
         }
         else
         {
             break;
         }
    }
    return $qtd_feriados;
}
//
//  Data de Inicio  = $data_inicio
//  Data de Termino = $data_fim
//  [saida] como parâmetro Número de dias corridos = $xnumero_dias_corridos
//  [saida] no return Numero de Dias úteis = $numero_dias_uteis
function CalculaDiasUteis($data_inicio, $data_fim, &$xnumero_dias_corridos)
{
    $kokw=1;
    $data_inicial = $data_inicio;
    $data_final   = $data_fim;
    //
    $numero_dias_uteis     = 0;
    $xnumero_dias_corridos = 0;

    $numero_dias_corridosw = DifData_dia_fechado($data_fim, $data_inicio);

    $xnumero_dias_corridos = $numero_dias_corridosw;



    $data         = $data_inicial;
    $meses        = 0;
    $ano          = 0;
    $qtd_feriados = 0;
    $qtd_uteis    = 0;


    $intervalo    = $xnumero_dias_corridos + 400;

 //   $codtab = "";
  //  CarregarFeriadoPAR($codtab);
    $vet_feriado  = $_SESSION[CS]['g_vet_feriado_obra_par'];
   // echo " tabela feriados $data_inicio $data_fim <br /> ";
   // p($vet_feriado);

    if ($data_inicio=="02/05/2014")
    {
        //echo ' $ndu  '.$xnumero_dias_corridos."<br />";
    }

    $totaldias=0;
    for ($c = 0; $c < $intervalo; $c++) {
         // echo ' $data  '.$data;
         if ($vet_feriado[$data]!='')
         {
          //   echo ' $data  f '.$data."<br />";
             $qtd_feriados = $qtd_feriados + 1;
             $totaldias    = $totaldias + 1;
         }
         else
         {
           //  echo ' $data  u '.$data."<br />";
             $qtd_uteis = $qtd_uteis + 1 ;
             $totaldias    = $totaldias + 1;
         }
         $data = SomarData($data, 1, 0, 0);
         if ($totaldias>$xnumero_dias_corridos)
         {
             $numero_dias_uteis = $qtd_uteis;
             break;
         }

    }
    //p($vet_feriado);

    if ($data_inicio=="02/05/2014")
    {
        //echo ' $ndu 2222 '.$xnumero_dias_corridos."<br />";
    }


    return $numero_dias_uteis;
}
function CarregarFeriadoPAR($par)
{
   $kokw=0;
   
   $par = "SSA-01";
   $_SESSION[CS]['g_vet_feriado_obra_par']=Array();
   $vet_feriado=Array();
   
/*
   // carregar vetor com feriados para a obra - módulo
   $sql = 'select ';
   $sql .= '  dcp.data as dcp_data,  ';
   $sql .= '  tdcp.codigo as tdcp_codigo  ';
   $sql .= '  from calendario_padrao cp ';
   $sql .= '  inner join datas_calendario_padrao dcp on dcp.idt_calendario = cp.idt';
   $sql .= '  inner join tipo_datas_calendario_padrao tdcp on tdcp.idt = dcp.idt_tipo_datas_calendario_padrao';
   //$sql .= '  where cp.idt_empreendimento_modulo = '.null($idt_empreendimento_modulo);
   $sql .= '  where cp.codigo = '.aspa($par);
   $sql .= '    and tdcp.nao_trabalha   = '.aspa('S');
   $sql .= '  order by data ';
   $rs = execsql($sql);
   if ($rs->rows == 0) {
   }
   else
   {
      $vet_feriado=Array();
      ForEach ($rs->data as $row) {
         $dcp_data               = trata_data($row['dcp_data']);
         $vet_feriado[$dcp_data] = $dcp_data;
      }
      $kokw=1;
      $_SESSION[CS]['g_vet_feriado_obra_par']=$vet_feriado;
   }
*/
   //
  $difanos = 2;
  $anocw   = "2016";
  $sabado  ="N";
  $domingo ="N";
  for ($c = 0; $c < $difanos; $c++) {

	$feriados_ano = Array();
	$vet = Feriados($anocw, $sabado, $domingo, $feriados_ano);

	ForEach ($feriados_ano as $anovw => $meses) {
		$anow = $anovw;
		ForEach ($meses as $mes => $dias) {
			$mesw = $mes;
			ForEach ($dias as $dia => $tpdias) {
			    if ($tpdias['tpdi']=='F')
				{
					$dataw = $dia.'/'.$mesw.'/'.$anow;
					$vet_feriado[$dataw]=$dataw;
				}
			}
		}
	}
	
	$anocw = $anocw + 1;
  } 
  
 // p($vet_feriado);
/*   
   $vet_feriado['02/11/2016']='02/11/2016';
   $vet_feriado['05/11/2016']='05/11/2016';
   $vet_feriado['06/11/2016']='06/11/2016';
   $vet_feriado['15/11/2016']='15/11/2016';
   //
*/   
   $_SESSION[CS]['g_vet_feriado_obra_par']=$vet_feriado;

   return $kokw;
}

function Feriados($ano, $sabado, $domingo, &$feriados_ano) {
    $dia   = 86400;

    $datas = array();
    $datas['pascoa'] = easter_date($ano);
    $datas['sexta_santa']   = $datas['pascoa'] - (2 * $dia);
    $datas['carnaval']      = $datas['pascoa'] - (47 * $dia);
    $datas['corpus_cristi'] = $datas['pascoa'] + (60 * $dia);

    /*
      $feriados = array (
      '01/01',
      '02/02', // Navegantes
      date('d/m',$datas['carnaval']),
      date('d/m',$datas['sexta_santa']),
      date('d/m',$datas['pascoa']),
      '21/04',
      '01/05',
      date('d/m',$datas['corpus_cristi']),
      '20/09', // Revolução Farroupilha \m/
      '12/10',
      '02/11',
      '15/11',
      '25/12',
      );
     */
    $tpoas = 'Dia não Trabalhado';
    $feriados_dia = Array();
    $feriados_mes = Array();
    $feriados_dia = Array();
    $feriados_dia[desc] = 'Confraternização Universal';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes['01']['01'] = $feriados_dia;
    //
    $feriados_dia = Array();
    $feriados_dia[desc] = 'Navegantes';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes['02']['02'] = $feriados_dia;



    $feriados_dia = Array();
    $dd = date('d', $datas['carnaval']);
    $mm = date('m', $datas['carnaval']);
    $feriados_dia[desc] = 'Carnaval';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = date('d', $datas['sexta_santa']);
    $mm = date('m', $datas['sexta_santa']);
    $feriados_dia[desc] = 'Sexta Feira da Paixão';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = date('d', $datas['pascoa']);
    $mm = date('m', $datas['pascoa']);
    $feriados_dia[desc] = 'Pascoa';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = '19';
    $mm = '03';
    $feriados_dia[desc] = 'Dia da Construção';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpdi] = 'F';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = '21';
    $mm = '04';
    $feriados_dia[desc] = 'Tiradentes';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;


    $feriados_dia = Array();
    $dd = '01';
    $mm = '05';
    $feriados_dia[desc] = 'Dia do Trabalhador';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = date('d', $datas['corpus_cristi']);
    $mm = date('m', $datas['corpus_cristi']);
    $feriados_dia[desc] = 'Corpus Cristi';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;


    $feriados_dia = Array();
    $dd = '24';
    $mm = '06';
    $feriados_dia[desc] = 'São João';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;






    $feriados_dia = Array();
    $dd = '12';
    $mm = '10';
    $feriados_dia[desc] = 'Dia das Crianças';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = '02';
    $mm = '11';
    $feriados_dia[desc] = 'Finados';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = '15';
    $mm = '11';
    $feriados_dia[desc] = 'Proclamação da República';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $feriados_dia = Array();
    $dd = '25';
    $mm = '12';
    $feriados_dia[desc] = 'Natal';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

/*
    $feriados_dia = Array();
    $dd = '12';
    $mm = '12';
    $feriados_dia[desc] = 'Nossa Senhora Aparecida';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;
*/

    $feriados_dia = Array();
    $dd = '31';
    $mm = '12';
    $feriados_dia[desc] = 'Reveillon';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;


    $feriados_dia = Array();
    $dd = '07';
    $mm = '09';
    $feriados_dia[desc] = 'Independência do Brasil';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;


    // dependem da região criar condicionalidade a região.....
/*
    $feriados_dia = Array();
    $dd = '02';
    $mm = '07';
    $feriados_dia[desc] = 'Independência da Bahia';
    $feriados_dia[tpfe] = 'Regional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'RE';
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;
*/
    $feriados_dia = Array();
    $dd = '08';
    $mm = '12';
    $feriados_dia[desc] = 'Nossa Senhora Conceição';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;


    /*

    $ddca          = date('d', $datas['carnaval']);
    $mmca          = date('m', $datas['carnaval']);
    $datascarnaval = $ddca.'/'.$mmca.'/'.$ano;

    $data  = $datascarnaval;  // +1 quarta
    $dias  = 1;
    $meses = 0;
    $anosw = 0;
    $data  = SomarData($data, $dias, $meses, $anosw);
    $feriados_dia = Array();
    $dd = substr($data,0,2);
    $mm = substr($data,3,2);

    $feriados_dia[desc] = 'Carnaval';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $data  = $datascarnaval;  // +1 quarta
    $dias  = -1;
    $meses = 0;
    $anosw = 0;
    $data  = SomarData($data, $dias, $meses, $anosw);
    $feriados_dia = Array();
    $dd = substr($data,0,2);
    $mm = substr($data,3,2);

    $feriados_dia[desc] = 'Carnaval';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $data  = $datascarnaval;  // +1 quarta
    $dias  = -2;
    $meses = 0;
    $anosw = 0;
    $data  = SomarData($data, $dias, $meses, $anosw);
    $feriados_dia = Array();
    $dd = substr($data,0,2);
    $mm = substr($data,3,2);

    $feriados_dia[desc] = 'Carnaval';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

    $data  = $datascarnaval;  // +1 quarta
    $dias  = -3;
    $meses = 0;
    $anosw = 0;
    $data  = SomarData($data, $dias, $meses, $anosw);
    $feriados_dia = Array();
    $dd = substr($data,0,2);
    $mm = substr($data,3,2);

    $feriados_dia[desc] = 'Carnaval';
    $feriados_dia[tpfe] = 'Nacional';
    $feriados_dia[tpfe] = $tpoas;
    $feriados_dia[tpdi] = 'F';
    $feriados_mes[$mm][$dd] = $feriados_dia;

 //   $data  = $datas['carnaval'];  // -4 sexta
 //   $data  = $datas['carnaval'];  // -1 quinta

    */



    /*
    $feriados_dia_pessoas = Array();
    $feriados_dia_pessoas[] = 'Guy Pai';
    $feriados_dia_pessoas[] = 'Seu Luiz';
    $feriados_dia = Array();
    $dd = '25';
    $mm = '08';
    $feriados_dia[desc] = 'Util';
    $feriados_dia[tpfe] = '';
    $feriados_dia[tpdi] = 'N';
    $feriados_dia[aniv] = $feriados_dia_pessoas;
    $feriados_mes[$mm][$dd] = $feriados_dia;
    */

    // sabado e domingos

    $datainiano = '01/01/'.$ano.' 15:00:00';
    $datafimano = '31/12/'.$ano.' 15:00:00';
    $datainianott = dataToTimestamp($datainiano);
    $datafimanott = dataToTimestamp($datafimano);
    //aqui eu pego varias datas entre um intervalo, e preciso tratar para não pegar os  sabados domingos e feriados, isto eu não estou conseguindo fazer quem puder ajudar por favor responda, obrigado, lembrando que esta data não é mktime creio que devo transformala em mktime para que ela sempre pegue os dias corretos do mes, também não estou conseguindo fazer isso.
    $datas = array();
    $i = 0;
    for ($datatt = $datainianott; $datatt <= $datafimanott; $datatt = $datatt + $dia) {
        $datadt = TimestampToData($datatt);
        //$datatt = dataToTimestamp($datadt.' 00:00:00');
        //$datatt = dataToTimestamp($datadt);

        $datas[$i] = $datadt;

        $an = substr($datadt, 6, 4);
        $me = substr($datadt, 3, 2);
        $di = substr($datadt, 0, 2);
        // 0 é domingo e 6 é sábado.
        $dia_semana = date("w", mktime(0, 0, 0, $me, $di, $an));
        if ($an=='2011')
        {
          // echo ' Data '.$datadt."<br/>";
        }
        /*
        if ($an=='2011' and $me=='10' and $di=='16')
        {
            // echo ' assim esta certo '.$dia_semana;
            // echo "<script>";
            // echo " alert(' assim esta certo {$dia_semana} ');";
            // echo "</script>";
            // exit();
        }
        */

        // $tpdias['flgs'];

        if ($dia_semana == 0) {

            if ($domingo!="S")
            {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                $feriados_dia['desc'] = 'Domingo';
                $feriados_dia['tpfe'] = 'Descanso';
                $feriados_dia['tpfe'] = $tpoas;
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'F';
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
            }
            else
            {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                $feriados_dia['desc'] = 'Domingo';
                $feriados_dia['tpfe'] = 'Descanso';
                $feriados_dia['tpfe'] = $tpoas;
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'U';
                $feriados_dia['flgs'] = 'N';
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
            }
        }
        if ($dia_semana == 1) {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_dia['desc'] = 'Segunda';
                    $feriados_dia['tpfe'] = '';
                    $feriados_dia['tpfe'] = $tpoas;
                    $feriados_dia['tpdi'] = 'U';
                    $feriados_dia['flgs'] = 'N';
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
        }
        if ($dia_semana == 2) {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_dia['desc'] = 'Terça';
                    $feriados_dia['tpfe'] = '';
                    $feriados_dia['tpfe'] = $tpoas;
                    $feriados_dia['tpdi'] = 'U';
                    $feriados_dia['flgs'] = 'N';
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
        }
        if ($dia_semana == 3) {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_dia['desc'] = 'Quarta';
                    $feriados_dia['tpfe'] = '';
                    $feriados_dia['tpfe'] = $tpoas;
                    $feriados_dia['tpdi'] = 'U';
                    $feriados_dia['flgs'] = 'N';
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
        }
        if ($dia_semana == 4) {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_dia['desc'] = 'Quinta';
                    $feriados_dia['tpfe'] = '';
                    $feriados_dia['tpfe'] = $tpoas;
                    $feriados_dia['tpdi'] = 'U';
                    $feriados_dia['flgs'] = 'N';
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
        }
        if ($dia_semana == 5) {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_dia['desc'] = 'Sexta';
                    $feriados_dia['tpfe'] = '';
                    $feriados_dia['tpfe'] = $tpoas;
                    $feriados_dia['tpdi'] = 'U';
                    $feriados_dia['flgs'] = 'N';
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
        }



        if ($dia_semana == 6) {
            if ($sabado!="S")
            {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                $feriados_dia['desc'] = 'Sábado';
                $feriados_dia['tpfe'] = 'Descanso';
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'F';
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
            }
            else
            {
                $feriados_dia = Array();
                $dd = $di;
                $mm = $me;
                $feriados_dia['desc'] = 'Sábado';
                $feriados_dia['tpfe'] = 'Descanso';
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'DSR';
                $feriados_dia['tpdi'] = 'U';
                $feriados_dia['flgs'] = 'N';
                if ($feriados_mes[$mm][$dd]=='')
                {
                    $feriados_mes[$mm][$dd] = $feriados_dia;
                }
            }
        }
        $i++;
        if ($i > 370) {
            break;
        }
    }
    $feriados_ano[$ano] = $feriados_mes;
    return $feriados;
}
function dataToTimestamp($DataTime) {
    $ano = substr($DataTime, 6, 4);
    $mes = substr($DataTime, 3, 2);
    $dia = substr($DataTime, 0, 2);
    $hh = substr($DataTime, 11, 2);
    $mm = substr($DataTime, 14, 2);
    $ss = substr($DataTime, 17, 2);
    $Timestamp = mktime($hh, $mm, $ss, $mes, $dia, $ano);
    return $Timestamp;
}

function TimestampToData($Timestamp) {
    $data_hora_nova = date("d/m/Y H:i:s", $Timestamp);
    return $data_hora_nova;
}

