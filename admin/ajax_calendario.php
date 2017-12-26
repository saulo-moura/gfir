<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

Require_Once('configuracao.php');

if ($_SESSION[CS]['g_id_usuario'] == '') {
    //die('O acesso ao sistema expirou! Favor entrar no sistema outra vez.');
}

if (file_exists('funcao_agenda.php')) {
    Require_Once('funcao_agenda.php');
}

switch ($_GET['tipo'])
{


	case 'agenda_carrega':
		$vet = Array(
			'erro' => '',
			'html_cab' => 'html_cab',
			'html' => 'html',
			'destaque' => 'destaque',
		);

		$data = $_POST['data'];
		
		if ($data=='')
		{
		
		    if ($_SESSION[CS]['agenda_data']!="")
			{
			    $data=$_SESSION[CS]['agenda_data'];	
			}
			else
			{
		       $data=Date('d/m/Y');	
			}
		}
		
		
		$_SESSION[CS]['agenda_data']=$data;
		$vetMes = Array(
        '01' => 'Janeiro',
        '02' => 'Fevereiro',
        '03' => 'Março',
        '04' => 'Abril',
        '05' => 'Maio',
        '06' => 'Junho',
        '07' => 'Julho',
        '08' => 'Agosto',
        '09' => 'Setembro',
        '10' => 'Outubro',
        '11' => 'Novembro',
        '12' => 'Dezembro'
        );
		$vetDia = Array(
        0 => 'Domingo',
        1 => 'Segunda Feira',
        2 => 'Terça Feira',
		3 => 'Quarta Feira',
		4 => 'Quinta Feira',
		5 => 'Sexta Feira',
		6 => 'Sábado'
        );
		
		
		$vetw  = explode('/',$data);
		
		
		
		$dia   = $vetw[0];
		$mes   = $vetw[1];
		$ano   = $vetw[2];
		//
		if ($mes<10)
		{
		    //$mes='0'.$mes;
		}
		if ($dia<10)
		{
		    //$dia='0'.$dia;
		}
		//
		$datanova=$ano.'-'.$mes.'-'.$dia;
		
		//$datanova=$dia.'/'.$mes.'/'.$ano;
		
		$dianumw = date("w", strtotime(date($datanova))); 
		
		
		
		
		$mesw  = $vetMes[$mes];
		
		
		$diaw  = $vetDia[$dianumw];
		$texto_destaque  = "";
	
		$texto_destaque .= "<div style='  border-radius: 0.5em 0.5em 0em 0em; margin:0; padding:0; font-weight: bold; font-size:1.5em; color:#FFFFFF; text-align:center; display:block; background:#2F65BB;' >";
		$texto_destaque .= "{$diaw}";
		$texto_destaque .= "</div>"; 
		
		$texto_destaque .= "<div style='margin:0; padding:0.0em;   font-weight: bold; font-size:1.5em; color:#000000; text-align:center; display:block; ' >";
		$texto_destaque .= "{$ano}";
		$texto_destaque .= "</div>";
		
		$texto_destaque .= "<div style='margin:0; padding:0; font-weight: bold; font-size:3.5em; color:#000000; text-align:center; display:block; ' >";
		$texto_destaque .= "{$dia}";
		$texto_destaque .= "</div>";
		
		$texto_destaque .= "<div style='margin:0; padding:0; font-weight: bold; font-size:1.5em; color:#000000; text-align:center; display:block; ' >";
		$texto_destaque .= "{$mesw}";
		$texto_destaque .= "</div>";
		
		
		
		// Cabeçalho
		
		$texto_cab   = "";
		
		$bgb         = "#DBDBDB;";
		$borg        = "#FFFFFF;";
		$texto_cab  .= "<div style='float:left; width:100%; xborder-top:1px solid #FFFFFF;'>";
		
		$hint        = "Lista Agenda com Todos os Horários disponíveis. "; 
		$turnos5w    = "Todos";
		$onclick     = " onclick='return Turno(".'"'."GE".'"'.");' ";
		$texto_cab  .= "<div id='id_GE' title='{$hint}'  class='opcao'  {$onclick} style='float:left; width:6em;  cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$turnos5w}";
		$texto_cab  .= "</div>";
		
		$hint        = "Lista Agendamento Horário de 07:00 até 12:00. "; 
	    $turnos1w    = "Manhã";
		$onclick     = " onclick='return Turno(".'"'."T1".'"'.");' ";
		$texto_cab  .= "<div id='id_T1' title='{$hint}' class='opcao' {$onclick} style='float:left; width:6em; cursor:pointer;  border-radius: 0.5em; margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$turnos1w}";
		$texto_cab  .= "</div>"; 
		
		$hint        = "Lista Agendamento Horário de 12:01 até 18:00. "; 
		$turnos2w    = "Tarde";
		$onclick     = " onclick='return Turno(".'"'."T2".'"'.");' ";
		$texto_cab  .= "<div id='id_T2'  title='{$hint}' class='opcao' {$onclick} style='float:left; width:6em; cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$turnos2w}";
		$texto_cab  .= "</div>";
		
		$hint        = "Lista Agendamento Horário de 18:01 até 00:00. "; 
		$turnos3w    = "Noite";
		$onclick     = " onclick='return Turno(".'"'."T3".'"'.");' ";
		$texto_cab  .= "<div id='id_T3'  title='{$hint}'  class='opcao' {$onclick} style='float:left; width:6em;  cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$turnos3w}";
		$texto_cab  .= "</div>";

		$hint        = "Lista Agendamento Horário de 00:01 até 06:59. "; 
		$turnos4w    = "Madrugada";
		$onclick     = " onclick='return Turno(".'"'."T4".'"'.");' ";
		$texto_cab  .= "<div id='id_T4'  title='{$hint}'  class='opcao'  {$onclick} style='float:left; width:6em; cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$turnos4w}";
		$texto_cab  .= "</div>";
		
		//$texto_cab  .= "</div>";
		
		
		
		//$texto_cab  .= "<div style='float:left; width:100%; margin-top:0.15em;'>";
		/*
		$statusw    = "";
		$onclick     = " onclick='return Status(".'"'."GE".'"'.");' ";
		
		$onclick     = " onclick='return Status(".'"'."GE".'"'.");' ";
		$texto_cab  .= "<div id='id_TODOSSTATUS'  class='status'  {$onclick} style='float:left; width:7em;  xcursor:pointer; xborder-radius: 0.5em;  margin:0; margin-right:0.3em; font-weight: bold; font-size:0.6em; color:#000000; text-align:center; display:block; background:{$bgb}' >";
		$texto_cab  .= "{$statusw}";
		$texto_cab  .= "</div>";
		*/
		
		
		$texto_cab  .= "<div id='id_SEPARA'  title=''  class='xstatus'  style='float:left; width:2em;   xborder-radius: 0.5em;  margin:0; margin-left:0.3em; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#0000FF; text-align:center; display:block; xbackground:{$bgb} xborder:1px solid {$borg};' >";
		$texto_cab  .= "||";
		$texto_cab  .= "</div>";

		
		$hint        = "Lista Agendamentos com Horários Disponíveis para Marcação "; 
		$statusw     = "Livres";
		$onclick     = " onclick='return Status(".'"'."LIVRE".'"'.");' ";
		$texto_cab  .= "<div id='id_LIVRE'  title='{$hint}'  class='status'  {$onclick} style='float:left; width:6em;  cursor:pointer; border-radius: 0.5em;  margin:0; margin-left:0.3em; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$statusw}";
		$texto_cab  .= "</div>";

		$hint        = "Lista Agendamentos com Horários Marcados para Atendimento "; 
		$statusw     = "Marcados";
		$onclick     = " onclick='return Status(".'"'."MARCADO".'"'.");' ";
		$texto_cab  .= "<div id='id_AGENDADO'  title='{$hint}'  class='status'  {$onclick} style='float:left; width:6em;  cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$statusw}";
		$texto_cab  .= "</div>";

		$hint        = "Lista Agendamentos com Horários Bloqueados para Atendimento "; 
		$statusw     = "Bloqueados";
		$onclick     = " onclick='return Status(".'"'."BLOQUEADO".'"'.");' ";
		$texto_cab  .= "<div id='id_BLOQUEADO'  title='{$hint}'  class='status'  {$onclick} style='float:left; width:6em;  cursor:pointer; border-radius: 0.5em;  margin:0; margin-right:0.3em; xfont-weight: bold; font-size:0.6em; color:#666666; text-align:center; display:block; background:{$bgb} border:1px solid {$borg};' >";
		$texto_cab  .= "{$statusw}";
		$texto_cab  .= "</div>";
		
		
		$texto_cab  .= "</div>";
		
		
		/*
		$turnosatual = "Manhã";
		$texto_cab  .= "<div id='turnoatual' style='float:left; width:15em; margin:0; padding:0.3em; font-weight: bold; font-size:0.5em; color:#000000; text-align:center; display:block; background:#D1D1D1;' >";
		$texto_cab  .= "{$turnosatual}";
		$texto_cab  .= "</div>";
		*/
		//
		$vet['html_cab']    = rawurlencode($texto_cab);
		//$vet['html_cab']  = 'Data: '.$data;
		$html = MinhaAgendaDia($data);
        $vet['html']        = rawurlencode($html);
		$vet['destaque']    = rawurlencode($texto_destaque);
		echo json_encode($vet);
	break;

    
}