<style>
</style>
<?php
    
    Require_Once('configuracao.php');
    //
    Require_Once('classes/gsw_email_class.php');
	
	
	//
    set_time_limit(0);
    $vetEmail=Array();
	
	echo "AGENDAMENTO - GERADO EMAILS E SMS<BR />";
	echo "GERADO EMAILS<BR /><BR />";
	//
	// Pesquisar Agenda
	//
	// Tratar datas futuras
	$datadiaBA = trata_data(date('d/m/Y'));
	//
	// Determinar maior data e menor data
	//
	$vetProcessoPrazo=Array();
	$vetProcessoQuando=Array();
	$sql  = 'select ';
	$sql .= '   grc_aesp.* ';
	$sql .= ' from grc_agenda_emailsms_processo grc_aesp ';
	//$sql .= ' inner join grc_agenda_emailsms grc_aes on grc_aes.idt_processo = grc_aesp.idt ';
	$sql .= " where grc_aesp.aplicacao = ".aspa('Agenda');
	$sql .= "   and grc_aesp.ativo     = ".aspa('S');
	$rst   = execsql($sql);
	$menordias=0;
	$maiordias=0;
	if ($rst->rows > 0) {
		foreach ($rst->data as $rowt) {
		    $codigo    = $rowt['codigo'];
		    $descricao = $rowt['descricao'];
			$detalhe   = $rowt['detalhe'];
			$quando    = $rowt['quando'];
			$prazo     = $rowt['prazo'];
			$vetProcessoPrazo[$codigo]=$prazo;
			$vetProcessoQuando[$codigo]=$quando;
			/*
			if ($quando=='A')
			{  // Antes da data do agendamento
			   if ($prazo > $menordias)
			   {
			       $menordias=$prazo;
			   }
			}
			if ($quando=='D')
			{  // Depois da data do agendamento
			   if ($prazo > $maiordias)
			   {
			       $maiordias=$prazo;
			   }
			}
			if ($quando=='E')
			{  // imediato na execução
			
			}
			*/
		}	
	}
	
	//
	// Atuar no universo das Agendas Marcadas e Futuras
    //
	
	$vetProcessosAgendaMarcada=Array();
	$vetProcessosAgendaMarcada['02.02']="Enviar Email Solicitando Confirmação";
	$vetProcessosAgendaMarcada['90.03']="Enviar SMS na Véspera";
	//
	$sql_aa  = ' select grc_aa.* from grc_atendimento_agenda grc_aa ';
    $sql_aa .= ' where  grc_aa.data  > '.aspa($datadiaBA);
	$sql_aa .= '   and  situacao     = '.aspa('Marcado');
    $result = execsql($sql_aa);
    if ($result->rows == 0) {
        
    } else {
			ForEach ($result->data as $row) {
				$idt_atendimento_agenda = $row['idt'];
				$idt_consultor          = $row['idt_consultor'];
				foreach ($vetProcessosAgendaMarcada as $codigo => $descricao)
				{
					$vetParametros=Array();
					$vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
					$vetParametros['processo_emailsms']      = $codigo; // processo Email/SMS
					$kokw = AgendamentoPrepararEmail($vetParametros);
					if ($kokw==0)
					{
						//echo "---> Erro = ".$vetParametros['erro'];
					}	
				}
			}
    }
	//
	$datadiaCP = trata_data(date('d/m/Y H:i:s'));
    //	
	$sql  = 'select ';
	$sql .= '   grc_c.* ';
	$sql .= ' from grc_comunicacao grc_c ';
	$sql .= " where grc_c.pendente_envio = ".aspa('S');
	$rst   = execsql($sql);
	$qtd_total = 0; 
	$qtd_email = 0; 
	$qtd_sms   = 0; 
	if ($rst->rows > 0)
	{
		foreach ($rst->data as $rowt)
		{
		    $idt_comunicacao  = $rowt['idt'];
			$tipo_solicitacao = $rowt['tipo_solicitacao'];
			$data_enviar      = $rowt['data_enviar']; 
			if ($data_enviar>$datadiaCP)
			{   // ainda não é para enviar
			    continue;
			}
			// enviar EMAIL e/ou SMS
			$enviou_ok        = 0;
			$observacao_envio = "";
			if ($tipo_solicitacao=='EM')
			{
				$enviou_ok=AgendamentoEnviarEmail($idt_comunicacao,$vetParametros);
				if ($enviou_ok==1)
				{
					$observacao_envio .= "Enviado EMAIL<br />";
					$qtd_email = $qtd_email + 1;
				}
				else
				{
					$observacao_envio .= "Não Enviado EMAIL<br />";
				}
			}
			if ($tipo_solicitacao=='SM')
			{
				$enviou_ok=AgendamentoEnviarSMS($idt_comunicacao,$vetParametros);
				if ($enviou_ok==1)
				{
					$observacao_envio .= "Enviado SMS<br />";
					$qtd_sms = $qtd_sms + 1;
				}
				else
				{
					$observacao_envio .= "Não Enviado SMS<br />";
				}
			}
            if ($tipo_solicitacao=='ES')
			{
			    $observacao_envio .= "Enviado SMS<br />";
				$enviou_ok=AgendamentoEnviarEmail($idt_comunicacao,$vetParametros);
				if ($enviou_ok==1)
				{
				    $qtd_email = $qtd_email + 1;
				    $enviou_ok=AgendamentoEnviarSMS($idt_comunicacao,$vetParametros);
					if ($enviou_ok==1)
				    {
					    $observacao_envio .= "Enviado SMS<br />";
						$qtd_sms = $qtd_sms + 1;
					}
					else
					{
					    $observacao_envio .= "Não Enviado SMS<br />";
					}
				}	
				else
				{
				    $observacao_envio .= "Não Enviado EMAIL<br />";
					$observacao_envio .= "Não Enviado SMS<br />";
				}
			}			
            if ($enviou_ok == 1)
			{
                $qtd_total = $qtd_total + 1;
				$datadia = trata_data(date('d/m/Y H:i:s'));
				$sql = 'update grc_comunicacao set ';
				$sql .= ' observacao_envio  = ' . aspa($observacao_envio) . ", ";
				$sql .= ' pendente_envio    = ' . aspa('E') . ", ";
				$sql .= ' data_envio        = ' . aspa($datadia);
				$sql .= ' where idt         = ' . null($idt_comunicacao);
				execsql($sql);
			}
		}			
    }
	echo "TOTAL DE EMAILs {$qtd_email} <BR /><BR />";
	echo "TOTAL DE SMSs {$qtd_sms} <BR /><BR />";
	echo "TOTAL GERAL     {$qtd_total} <BR /><BR />";
	echo "FIM DA GERAÇÃO DE EMAILS - SMS <BR /><BR />";
    //
    set_time_limit(30);
	echo "FIM DA GERAÇAO PARA AGENDAMENTO DE EMAILS E SMS";
?>
