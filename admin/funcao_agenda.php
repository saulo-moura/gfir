<?php

function MinhaAgendaDia($data) {
    $html = "";



    $vetorDatas = Array();
    $TabelaPrinc = "grc_atendimento_agenda";
    $AliasPric = "grc_aa";
    $Entidade = "Agenda";
    $Entidade_p = "Agendas";

    $idt_unidade_regional = $_SESSION[CS]['agenda_idt_unidade_regional'];
    $idt_ponto_atendimento = $_SESSION[CS]['agenda_idt_ponto_atendimento'];
    $idt_consultor = $_SESSION[CS]['agenda_idt_consultor'];
    $idt_servico = $_SESSION[CS]['agenda_idt_servico'];

    if ($idt_ponto_atendimento == "") {
        $html .= "<div class='sem_agenda'>";
        $html .= "FAVOR SELECIONAR UM PONTO DE ATENDIMENTO PARA MOSTRAR A AGENDA!";
        $html .= "</div>";
    } else {

        $sql = "select ";
        //$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";
        $sql .= "   {$AliasPric}.*,  ";
        $sql .= "   ga.situacao as ga_situacao,  ";
        $sql .= "   ge.descricao as ge_descricao,  ";
        $sql .= "   pu.nome_completo as pu_nome_completo,  ";
        //$sql  .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
        $sql .= "   sos.descricao as sos_descricao,  ";
        $sql .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";
        $sql .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
        $sql .= "   sos.descricao as sos_descricao,  ";
        $sql .= "  gae.descricao as especialidade , ";
        $sql .= "  sos.descricao as ponto_atendimento , ";

        //$sql  .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";
        $sql .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";
        $sql .= " from {$TabelaPrinc} as {$AliasPric} ";
        $sql .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
        $sql .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
        if ($idt_servico != "") {
            $sql .= " left  join grc_atendimento_agenda_servico as grc_aas on grc_aas.idt = {$AliasPric}.idt ";
        }
        $sql .= " left  join " . db_pir_gec . "gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
        $sql .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
        $sql .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
        $sql .= " left join " . db_pir . "sca_organizacao_secao as sos on sos.idt = {$AliasPric}.idt_ponto_atendimento ";
        $dt_iniw = trata_data($data);
        $dt_fimw = trata_data($data);
        $sql .= ' where ';
        $sql .= " grc_aa.data >= " . aspa($dt_iniw) . " and grc_aa.data <=  " . aspa($dt_fimw) . " ";
        $sql .= " and grc_aa.origem = 'Hora Marcada' ";

        if ($idt_unidade_regional != "" and $idt_ponto_atendimento == "") {
            // Fazer where
            $sqlUR = "select classificacao   ";
            $sqlUR .= " from " . db_pir . "sca_organizacao_secao as sos";
            $sqlUR .= ' where ';
            $sqlUR .= ' sos.idt = ' . null($idt_unidade_regional);
            $rsUR = execsql($sqlUR);
            if ($rsUR->rows <= 0) {
                // erro, reportar
            } else {
                foreach ($rsUR->data as $rowUR) {
                    $classificacao_unidade = substr($rowUR['classificacao'], 0, 5) . "%";
                    $sql .= " and sos.classificacao like " . aspa($classificacao_unidade) . " and sos.posto_atendimento = 'S' ";
                }
            }
        } else {
            if ($idt_ponto_atendimento != "") {
                $sql .= " and grc_aa.idt_ponto_atendimento = " . null($idt_ponto_atendimento);
            }
        }


        if ($idt_consultor != "") {
            $sql .= " and grc_aa.idt_consultor = " . null($idt_consultor);
        }
        if ($idt_servico != "") {
            $sql .= " and grc_aas.idt_servico = " . null($idt_servico);
        }

        $sql_preso  = $sql;
		$sql_preso .= " and ({$AliasPric}.semmarcacao = 'S') ";
        $sql_preso .= " order by {$AliasPric}.data, {$AliasPric}.hora, sos.descricao   ";
        $rs_preso = execsql($sql_preso); 
		//
		// Desativar presos com muito tempo de parado
		//
		foreach ($rs_preso->data as $row_preso) {
			$semmarcacao = $row_preso['semmarcacao'];
			if ($semmarcacao == 'S') {
				// Esta livre mas, nesse momento preso para Marcar por outro atendente
				$tempopreso   = VerificaTempoPresoAgenda($row_preso);
			}	
		}	
		// separar ate aqui. 
	    $sql .= " order by {$AliasPric}.data, {$AliasPric}.hora, sos.descricao   ";
        $rs = execsql($sql);
        if ($rs->rows <= 0) {
            $html .= "<div class='sem_agenda'>";
            $html .= "SEM AGENDA PARA ESSE DIA";
            $html .= "</div>";
        } else {

            $vetTipoAgenda = Array();
            $vetTipoAgenda['Agendado'] = 'AGENDADO';
            $vetTipoAgenda['Marcado'] = 'MARCADO';
            $vetTipoAgenda['Cancelado'] = 'CANCELADO';




            $html .= "<table class='tabela' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'>";
            $html .= "<tr class='cab' >";

            $html .= "<td class='cab'>";
            $html .= "HORA";
            $html .= "</td>";

            $idt_ponto_atendimentoP = $idt_ponto_atendimento;
            if ($idt_ponto_atendimentoP == "") {
                $html .= "<td class='cab'>";
                $html .= "PONTO<br /> ATENDIMENTO";
                $html .= "</td>";
            }
            //$html .= "<td class='cab'>"; 
            //$html .= "STATUS"; 
            //$html .= "</td>"; 

            $html .= "<td class='cab'>";
            $html .= "CLIENTE";
            $html .= "</td>";
            $html .= "<td class='cab'>";
            $html .= "TELEFONE";
            $html .= "</td>";

            $html .= "<td class='cab' style='border-right:1px solid #c0c0c0;'>";
            $html .= "SERVIÇO";
            $html .= "</td>";


            $html .= "<td colspan='7' class='cab_exe' style='text-align:center;'>";
            $html .= "AÇÕES";
            $html .= "</td>";
/*
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
            $html .= "<td class='cab_exe' style=''>";
            $html .= "";
            $html .= "</td>";
*/

            $html .= "</tr>";

            $horati1 = "07:00";
            $horatf1 = "12:00";
            $horati2 = "12:01";
            $horatf2 = "18:00";
            $horati3 = "18:01";
            $horatf3 = "24:00";
            $horati4 = "00:01";
            $horatf4 = "06:59";

            $vetStatusAgendaR = Array();
            $vetStatusAgendaR['AGENDADO'] = 'LIVRE';
            $vetStatusAgendaR['Agendado'] = 'LIVRE';

            $vetStatusAgendaR['Bloqueado'] = 'BLOQUEADO';
            $vetStatusAgendaR['BLOQUEADO'] = 'BLOQUEADO';

            $vetStatusAgendaR['MARCADO'] = 'MARCADO';
            $vetStatusAgendaR['Marcado'] = 'MARCADO';

            $vetStatusAgendaR['CANCELADO'] = 'CANCELADO';
            $vetStatusAgendaR['Cancelado'] = 'CANCELADO';

            //
            $vetStatusAgendaR['PRESENTE'] = 'PRESENTE';
            $vetStatusAgendaR['AUSENTE'] = 'AUSENTE';
            $vetStatusAgendaR['EM ATENDIMENTO'] = 'EM ATENDIMENTO';
            $vetStatusAgendaR['FINALIZADO'] = 'FINALIZADO';
            $vetStatusAgendaR['DESISTENTE'] = 'DESISTENTE';
            //
			/*
            $vetStatusAgenda = Array();
            $vetStatusAgenda['AGENDADO'] = '#0000FF';
            $vetStatusAgenda['MARCADO'] = '#0000FF';

            $vetStatusAgenda['BLOQUEADO'] = '#FF0000';
            $vetStatusAgenda['LIVRE'] = '#00FF66';

            $vetStatusAgenda['CANCELADO'] = '#000000';
            //
            $vetStatusAgenda['PRESENTE'] = '#FFFFFF';
            $vetStatusAgenda['AUSENTE'] = '#FFFFFF';
            $vetStatusAgenda['EM ATENDIMENTO'] = '#FFFFFF';
            $vetStatusAgenda['FINALIZADO'] = '#FFFFFF';
            $vetStatusAgenda['DESISTENTE'] = '#FFFFFF';
		*/
		
		
		$vetStatusAgenda = Array();
          //  $vetStatusAgenda['AGENDADO'] = '#0000FF';
        //    $vetStatusAgenda['MARCADO'] = '#0000FF';
		    $vetStatusAgenda['AGENDADO'] = '#2F65BB';
            $vetStatusAgenda['MARCADO']  = '#2F65BB';

            $vetStatusAgenda['BLOQUEADO'] = '#FF0000';
            $vetStatusAgenda['LIVRE'] = '#00FF66';
			
			
            //$vetStatusAgenda['LIVRE'] = '#00FF66';
			$vetStatusAgenda['LIVRE'] = '#339F48';

            $vetStatusAgenda['CANCELADO'] = '#000000';
            //
            $vetStatusAgenda['PRESENTE'] = '#FFFFFF';
            $vetStatusAgenda['AUSENTE'] = '#FFFFFF';
            $vetStatusAgenda['EM ATENDIMENTO'] = '#FFFFFF';
            $vetStatusAgenda['FINALIZADO'] = '#FFFFFF';
            $vetStatusAgenda['DESISTENTE'] = '#FFFFFF';
		
		
		
		
		
		
		
		
            $linha = -1;
            foreach ($rs->data as $row) {
                $idt_atendimento_agenda = $row['idt'];
                $hora        = $row['hora'];
                $situacao    = $row['situacao'];
                $semmarcacao = $row['semmarcacao'];
				$data_hora_marcacao_inicial = $row['data_hora_marcacao_inicial'];
                $idt_atendimento_agenda_filho = $row['idt_atendimento_agenda'];

                $marcador = $row['marcador'];

                $data_hora_ausencia = $row['data_hora_ausencia'];

                // $situacaow = $vetTipoAgenda[$situacao];
                $situacaow = $vetStatusAgendaR[$situacao];
                if ($situacaow == "") {
                    $situacaow = $situacao;
                }
                //$situacaow=$situacao;
                $classstatus = $situacaow;

                //$idt_atendimento_agenda = $row['idt'];
                $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
                if ($idt_ponto_atendimento > 0) {
                    
                } else {
                    $idt_ponto_atendimento = "";
                }
                $especialidade_ponto = $row['especialidade_ponto'];
                $especialidade = $row['especialidade'];
                $ponto_atendimento = $row['ponto_atendimento'];
                $cliente = $row['ge_descricao'];
				if ($cliente=="")
				{
				    $cliente = $row['cliente_texto'];
				}	
                $telefone_celular = $row['telefone_celular'];

                $servicos = $row['servicos'];
				
                



                $class = ' GE ';
                if ($hora >= $horati1 and $hora <= $horatf1) {
                    $class .= ' T1 ';
                } else {
                    if ($hora >= $horati2 and $hora <= $horatf2) {
                        $class .= ' T2 ';
                    } else {
                        if ($hora >= $horati3 and $hora <= $horatf3) {
                            $class .= ' T3 ';
                        } else {
                            if ($hora >= $horati4 and $hora <= $horatf4) {
                                $class .= ' T4 ';
                            } else {
                                $class .= ' ';
                            }
                        }
                    }
                }
                $linha = $linha + 1;
                $bgz = '#F8F8F8';
                if ($linha % 2 == 0) {
                    $bgz = '#FFFFFF';
                }
                $esconder = "";
                if ($idt_atendimento_agenda_filho > 0) {
                    $esconder = " display:table-row; ";
                }
                $html .= "<tr class=' linhas {$class} {$classstatus} ' style='background:{$bgz}; {$esconder}' >";
                //$situacaowU = $vetStatusAgendaR[$situacaow];
                $corstatus  = $vetStatusAgenda[$classstatus];
                $emmarcacao = "";
                if ($semmarcacao == 'S') {
                    // Esta livre mas, nesse momento preso para Marcar por outro atendente
					//$tempopreso   = VerificaTempoPresoAgenda($row);
					$tempopreso   = 0; // funcionalidade ficou para antes de tudo
					if ($tempopreso==0)
					{
						$corstatus    = "#C0C0C0";
						if ($situacao == 'Marcado') {
							$emmarcacao = "\n" . "Em Desmarcação pelo Consultor/Atendente {$marcador}";
						} else {
							$emmarcacao = "\n" . "Em Marcação pelo Consultor/Atendente {$marcador}";
						}
					}	
                }
                $b_imagem1 = "N";
                $b_imagem2 = "N";
                $b_imagem3 = "N";
                $b_imagem4 = "N";
                $b_imagem5 = "N";
                $b_imagem6 = "N";
                $b_imagem7 = "N";
                if ($classstatus == "LIVRE") {
                    $b_imagem1 = "S";
                    $b_imagem2 = "S";
                    $b_imagem3 = "N";
                    $b_imagem4 = "N";
                    $b_imagem5 = "N";
                    $b_imagem6 = "N";
                    $b_imagem7 = "N";
                }
                if ($classstatus == "MARCADO") {
                    $b_imagem1 = "N";
                    $b_imagem2 = "S";
                    $b_imagem3 = "S";
                    $b_imagem4 = "S";
                    $b_imagem5 = "S";
                    $b_imagem6 = "S";
                    $b_imagem7 = "S";
                }
                if ($classstatus == "BLOQUEADO") {
                    $b_imagem1 = "N";
                    $b_imagem2 = "N";
                    $b_imagem3 = "N";
                    $b_imagem4 = "N";
                    $b_imagem5 = "N";
                    $b_imagem6 = "N";
                    $b_imagem7 = "N";
                }
                if ($classstatus == "CANCELADO") {
                    $b_imagem1 = "N";
                    $b_imagem2 = "N";
                    $b_imagem3 = "N";
                    $b_imagem4 = "N";
                    $b_imagem5 = "N";
                    $b_imagem6 = "N";
                    $b_imagem7 = "N";
                }
                $imagemfilho = "";
                if ($idt_atendimento_agenda_filho > 0 and $idt_atendimento_agenda_filho != $idt_atendimento_agenda ) {
                    $b_imagem1 = "N";
                    $b_imagem2 = "N";
                    $b_imagem3 = "N";
                    $b_imagem4 = "N";
                    $b_imagem5 = "N";
                    $b_imagem6 = "N";
                    $b_imagem7 = "N";
                    //$corstatus = "#00AA00FF";
				    $corstatus = "#FFC6C6";
                    $imagemfilho = "<img width='12' height='12' src='imagens/cadeado.png' title='Filho'/>";
                }
                if ($idt_atendimento_agenda_filho > 0 and $idt_atendimento_agenda_filho == $idt_atendimento_agenda) {
                    //$imagemfilho = "<img width='12' height='12' src='imagens/marcacao.png' title='Marcação'/>";
                }
                $html .= "<td class='hora' title='{$classstatus}{$emmarcacao}' style='background:{$corstatus}; font-size: 14px; '>";
                $html .= " {$imagemfilho} {$hora} ";
                $html .= "</td>";


                if ($idt_ponto_atendimentoP == "") {
                    $html .= "<td class='ponto_atendimento'  >";
                    $html .= "{$ponto_atendimento}";
                    $html .= "</td>";
                }

                //	$html .= "<td class='situacao'>"; 
                //	$html .= "{$classstatus}"; 
                //	$html .= "</td>"; 

                $backcli = " ";
                if ($data_hora_ausencia != "") {
                    $backcli = " background:#FFCCE6; ";
                }
                $html .= "<td class='cliente' style='{$backcli}' >";
                $html .= "{$cliente}";
                $html .= "</td>";

                $html .= "<td class='cliente'>";
                $html .= "{$telefone_celular}";
                $html .= "</td>";


                $html .= "<td class='especialidade'>";
                if ($classstatus == "MARCADO") {
                    $html .= "<span style='color:#0000FF;'>{$especialidade}</span>";
                } else {
					// tratar quando tem mais de 3 linhas
					$hint     = ""; 
					$servicos = MontaServicoAgenda($servicos,$idt_atendimento_agenda,$hint); 
                    $html .= "<span title='{$hint}' >{$servicos}</span>";
                }
                $html .= "</td>";


                // Ativas
                /*
                  $imagem1='imagens/agenda_img1a.png';
                  $imagem2='imagens/agenda_img2a.png';
                  $imagem3='imagens/agenda_img3a.png';
                  $imagem4='imagens/agenda_img4a.png';
                  $imagem5='imagens/agenda_img5a.png';
                  $imagem6='imagens/agenda_img6a.png';
                  $imagem7='imagens/agenda_img7a.png';
                 */
                $imagem1 = 'imagens/icone_agendamento/incluir_cliente_ativado.png';
                $imagem2 = 'imagens/icone_agendamento/pesquisar_cadastro_ativado.png';
                $imagem3 = 'imagens/icone_agendamento/informar_ausencia_ativado.png';
                $imagem4 = 'imagens/icone_agendamento/remover_cliente_ativado.png';
                $imagem5 = 'imagens/icone_agendamento/historico_cliente_ativado.png';
                $imagem6 = 'imagens/icone_agendamento/visualizar_agendamento_ativado.png';
                $imagem7 = 'imagens/icone_agendamento/excluir_cliente_ativado.png';






                // Inativas
                /*
                  $imagem1i='imagens/agenda_img1.png';
                  $imagem2i='imagens/agenda_img2.png';
                  $imagem3i='imagens/agenda_img3.png';
                  $imagem4i='imagens/agenda_img4.png';
                  $imagem5i='imagens/agenda_img5.png';
                  $imagem6i='imagens/agenda_img6.png';
                  $imagem7i='imagens/agenda_img7.png';
                 */
                $imagem1i = 'imagens/icone_agendamento/incluir_cliente_desativado.png';
                $imagem2i = 'imagens/icone_agendamento/pesquisar_cadastro_desativado.png';
                $imagem3i = 'imagens/icone_agendamento/informar_ausencia_desativado.png';
                $imagem4i = 'imagens/icone_agendamento/remover_cliente_desativado.png';
                $imagem5i = 'imagens/icone_agendamento/historico_cliente_desativado.png';
                $imagem6i = 'imagens/icone_agendamento/visualizar_agendamento_desativado.png';
                $imagem7i = 'imagens/icone_agendamento/excluir_cliente_desativado.png';




                $hint = "Incluir Cliente";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao1($idt_atendimento_agenda,$idt_ponto_atendimento);'  ";

                if ($b_imagem1 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem1 = $imagem1i;
                }
                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem1}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";


                $hint = "Visualizar Cadastro";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao2($idt_atendimento_agenda,$idt_ponto_atendimento);' ";

                if ($b_imagem2 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem2 = $imagem2i;
                }


                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem2}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";

                $hint = "Informar Ausência";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao3($idt_atendimento_agenda,$idt_ponto_atendimento);' ";

                if ($b_imagem3 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem3 = $imagem3i;
                }

                //$html .= "<td class='imagens_exe'>"; 
                //$html .= "<img width='12' height='12' src='{$imagem3}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                //$html .= "</td>"; 

                $hint = "Remover Cliente";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao4($idt_atendimento_agenda,$idt_ponto_atendimento);' ";
                if ($b_imagem4 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem4 = $imagem4i;
                }

                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem4}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";

                $hint = "Histórico de Agendamento";
                $fun = " onclick='return ChamaFuncao5($idt_atendimento_agenda,$idt_ponto_atendimento);' ";

                if ($b_imagem5 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem5 = $imagem5i;
                }

                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem5}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";

                $hint = "Visualizar Agendamento";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao6($idt_atendimento_agenda,$idt_ponto_atendimento);' ";

                if ($b_imagem6 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem6 = $imagem6i;
                }


                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem6}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";

                $hint = "Excluir Cliente";
                $cur = "cursor:pointer; ";
                $fun = " onclick='return ChamaFuncao7($idt_atendimento_agenda,$idt_ponto_atendimento);' ";

                if ($b_imagem7 == "N") {
                    $hint = "";
                    $cur = "";
                    $fun = "' ";
                    $imagem7 = $imagem7i;
                }

                $html .= "<td class='imagens_exe'>";
                $html .= "<img width='12' height='12' src='{$imagem7}' title='{$hint}' {$fun} style='{$cur} padding-right:0.1em;' />";
                $html .= "</td>";


                $html .= "</tr>";
            }
            $html .= "</table>";
        }
    }

    return $html;
}

function MontaVetorSistuacaoDatas($data_base) {
    $vetStatusAgendaR = Array();
    $vetStatusAgendaR['AGENDADO'] = 'LIVRE';
    $vetStatusAgendaR['Agendado'] = 'LIVRE';

    $vetStatusAgendaR['Bloqueado'] = 'BLOQUEADO';
    $vetStatusAgendaR['BLOQUEADO'] = 'BLOQUEADO';

    $vetStatusAgendaR['MARCADO'] = 'MARCADO';
    $vetStatusAgendaR['Marcado'] = 'MARCADO';

    $vetStatusAgendaR['CANCELADO'] = 'CANCELADO';
    $vetStatusAgendaR['Cancelado'] = 'CANCELADO';

    //
    $vetStatusAgendaR['PRESENTE'] = 'PRESENTE';
    $vetStatusAgendaR['AUSENTE'] = 'AUSENTE';
    $vetStatusAgendaR['EM ATENDIMENTO'] = 'EM ATENDIMENTO';
    $vetStatusAgendaR['FINALIZADO'] = 'FINALIZADO';
    $vetStatusAgendaR['DESISTENTE'] = 'DESISTENTE';
    //
    $vetStatusAgenda = Array();
    $vetStatusAgenda['AGENDADO'] = '#0000FF';
    $vetStatusAgenda['MARCADO'] = '#0000FF';

    $vetStatusAgenda['BLOQUEADO'] = '#FF0000';
    $vetStatusAgenda['LIVRE'] = '#00FF00';

    $vetStatusAgenda['CANCELADO'] = '#000000';
    //
    $vetStatusAgenda['PRESENTE'] = '#FFFFFF';
    $vetStatusAgenda['AUSENTE'] = '#FFFFFF';
    $vetStatusAgenda['EM ATENDIMENTO'] = '#FFFFFF';
    $vetStatusAgenda['FINALIZADO'] = '#FFFFFF';
    $vetStatusAgenda['DESISTENTE'] = '#FFFFFF';





    $vetorDatas = Array();
    $TabelaPrinc = "grc_atendimento_agenda";
    $AliasPric = "grc_aa";
    $Entidade = "Agenda";
    $Entidade_p = "Agendas";
    $vet = explode('/', $data_base);
    $data_i = '01/' . $vet[1] . '/' . $vet[2];

    $ultimo = cal_days_in_month(CAL_GREGORIAN, $vet[1], $vet[2]); // número de dias do mes
    //$ultimo           = '31';
    $data_f = $ultimo . '/' . $vet[1] . '/' . $vet[2];


    // filtros
    $idt_unidade_regional = $_SESSION[CS]['agenda_idt_unidade_regional'];
    $idt_ponto_atendimento = $_SESSION[CS]['agenda_idt_ponto_atendimento'];
    $idt_consultor = $_SESSION[CS]['agenda_idt_consultor'];
    $idt_servico = $_SESSION[CS]['agenda_idt_servico'];
    //echo " -------------- idt_unidade_regional  ---- $idt_ponto_atendimento ";
    //die();


    $sql = "select ";
    $sql .= "   {$AliasPric}.data, {$AliasPric}.hora, {$AliasPric}.situacao, {$AliasPric}.semmarcacao, {$AliasPric}.marcador, ";
    //$sql  .= "   {$AliasPric}.*, gae.descricao as gae_descricao,  ";
    $sql .= "   gae.descricao as gae_descricao,  ";
    $sql .= "   ga.situacao as ga_situacao,  ";
    $sql .= "   ge.descricao as ge_descricao,  ";
    $sql .= "   pu.nome_completo as pu_nome_completo,  ";
    $sql .= "   substring(gae.descricao,1,25) as gae_descricao,  ";
    $sql .= "   sos.descricao as sos_descricao,  ";
    $sql .= "  concat_ws('<br />', grc_aa.telefone, grc_aa.celular ) as telefone_celular,  ";
    $sql .= "  concat_ws('<br />', concat_ws('','-',grc_aa.cliente_texto) , concat_ws('','-',substring(pu.nome_completo,1,25)) ) as pu_cliente_consultor,  ";
    $sql .= "   sos.descricao as sos_descricao,  ";
    $sql .= "  gae.descricao as especialidade , ";
    $sql .= "  sos.descricao as ponto_atendimento , ";
    $sql .= "  sos.classificacao as ponto_atendimento_classificacao , ";

    $sql .= "  concat_ws('<br />', gae.descricao, sos.descricao) as especialidade_ponto,  ";
    $sql .= "  concat_ws('<br />', grc_aa.nome_empresa, grc_aa.cnpj) as empresacnpj  ";
    $sql .= " from {$TabelaPrinc} as {$AliasPric} ";
    $sql .= " left  join grc_atendimento as ga on ga.idt_atendimento_agenda = {$AliasPric}.idt ";
    $sql .= " left  join grc_atendimento_especialidade as gae on gae.idt = {$AliasPric}.idt_especialidade ";
    $sql .= " left  join " . db_pir_gec . "gec_entidade as ge on ge.idt = {$AliasPric}.idt_cliente ";
    $sql .= " left  join plu_usuario as pu on pu.id_usuario = {$AliasPric}.idt_consultor ";
//	$sql  .= " left  join grc_atendimento_agenda_painel as pn on pn.idt_atendimento_agenda = {$AliasPric}.idt ";
    $sql .= " left  join " . db_pir . "sca_organizacao_secao as sos on sos.idt = {$AliasPric}.idt_ponto_atendimento ";

    if ($idt_servico != "") {
        $sql .= " left  join grc_atendimento_agenda_servico as grc_aas on grc_aas.idt = {$AliasPric}.idt ";
    }

    $dt_iniw = trata_data($data_i);
    $dt_fimw = trata_data($data_f);

    $sql .= ' where ';
    $sql .= " grc_aa.origem = 'Hora Marcada' ";

    $sql .= " and grc_aa.data >= " . aspa($dt_iniw) . " and grc_aa.data <=  " . aspa($dt_fimw) . " ";


    if ($idt_unidade_regional != "" and $idt_ponto_atendimento == "") {
        // Fazer where
        $sqlUR = "select classeificacao   ";
        $sqlUR .= " from " . db_pir . "sca_organizacao_secao as sos";
        $sqlUR .= ' where ';
        $sqlUR .= ' sos.idt = ' . null($idt_unidade_regional);
        $rsUR = execsql($sqlUR);
        if ($rsUR->rows <= 0) {
            // erro, reportar
        } else {
            foreach ($rsUR->data as $rowUR) {
                $classificacao_unidade = substr($rowUR['classificacao'], 0, 5) . "%";
                $sql .= " and sos.classificacao like " . aspa($classificacao_unidade) . " and sos.posto_atendimento = 'S' ";
            }
        }
    } else {
        if ($idt_ponto_atendimento != "") {
            $sql .= " and grc_aa.idt_ponto_atendimento = " . null($idt_ponto_atendimento);
        }
    }
    if ($idt_consultor != "") {
        $sql .= " and grc_aa.idt_consultor = " . null($idt_consultor);
    }
    if ($idt_servico != "") {
        $sql .= " and grc_aas.idt_servico = " . null($idt_servico);
    }
    // $sql .= " order by {$AliasPric}.data, {$AliasPric}.hora, sos.descricao   ";


    $vetorDatasSituacao = Array();
    $rs = execsqlNomeCol($sql);
    if ($rs->rows <= 0) {
        
    } else {
        foreach ($rs->data as $row) {
            $data = trata_data($row['data']);
            $hora = $row['hora'];
            $situacao = $row['situacao'];
            $semmarcacao = $row['semmarcacao'];
            $marcador = $row['marcador'];

            // data,hora,situacao,semmarcacao,marcador



            $situacaow = $vetStatusAgendaR[$situacao];
            if ($situacaow == "") {
                $situacaow = $situacao;
            }
            if ($situacaow == 'LIVRE') {
                $vetorDatasSituacao[$data] = "L"; // indicar que esta sem  agendamento
            } else {
                if ($vetorDatasSituacao[$data] != "L") {
                    $vetorDatasSituacao[$data] = "S";
                }
            }
        }
    }

    return $vetorDatasSituacao;
}

function FiltroAgenda(&$vet) {
    $vet['erro'] = "";
    $veio = $vet['veio'];
    $idt_unidade_regional_I = $vet['idt_unidade_regional_I'];
    $idt_ponto_atendimento_I = $vet['idt_ponto_atendimento_I'];
    $idt_consultor_I = $vet['idt_consultor_I'];
    $idt_servico_I = $vet['idt_servico_I'];
    $vet['idt_ponto_atendimento_DC'] = "";
    $vet['idt_consultor_DC'] = "";
    $vet['idt_servico_DC'] = "";
    if ($idt_unidade_regional_I != "") {
        $sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
        $sql .= ' where SUBSTRING(classificacao, 1, 5) = ('; //and
        $sql .= ' select SUBSTRING(classificacao, 1, 5) as cod';
        $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
        $sql .= ' where idt = ' . null($vet['idt_unidade_regional_I']);
        $sql .= ' )';
        $sql .= ' and idt <> ' . null($vet['idt_unidade_regional_I']);
        $sql .= ' order by classificacao ';
        $vet['idt_ponto_atendimento_DC'] = rawurlencode(option_rs(execsql($sql), $idt_ponto_atendimento_I, ' '));
    } else {
        $sql = "select idt,  descricao from " . db_pir . "sca_organizacao_secao ";
        $sql .= " where (posto_atendimento = 'UR' or posto_atendimento = 'S')";
        $sql .= ' order by classificacao ';
        $vet['idt_ponto_atendimento_DC'] = rawurlencode(option_rs(execsql($sql), $idt_ponto_atendimento_I, ' '));
    }

    if ($idt_ponto_atendimento_I != "") {
        $sql = '';
        $sql .= "select plu_usu.id_usuario, plu_usu.nome_completo, sca_o.descricao from plu_usuario plu_usu";
        $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt_usuario = plu_usu.id_usuario ";
        $sql .= " inner join " . db_pir . "sca_organizacao_secao sca_o on sca_o.idt = grc_pap.idt_ponto_atendimento ";
        $sql .= " where grc_pap.idt_ponto_atendimento = " . null($idt_ponto_atendimento_I);
        if ($veio == 3) { // Veio de Criar Agenda
            //$sql .= " and id_usuario = ".null($idt_atendente);
            //$sql .= " and grc_pap.idt_ponto_atendimento = ".null($idt_pa);
        }
   	    $rs = execsql($sql);
		if ($rs->rows > 0)
		{
			
			$liga = "";
			$compl = "";
			foreach ($rs->data as $row) {
				$idt_consultor = $row['id_usuario'];
				$data=trata_data($_SESSION[CS]['agenda_data']);
				//p($data);
				$temagenda = VerificaConsultorData($idt_consultor,$idt_ponto_atendimento_I,$data);
				if ($temagenda==1)
				{
				    $compl .= $liga." plu_usu.id_usuario = ".null($idt_consultor);
					$liga = " or ";
				}
			}
			if ($liga == " or ")
			{
				$sql .= " and ( ".$compl;
				$sql .= " ) ";
			}
			else
			{
				$sql .= " and ( 2 = 1 ";
				$sql .= " ) ";
			
			}
		}
	    $sql .= " order by plu_usu.nome_completo, sca_o.descricao";
		//
		

        $vet['idt_consultor_DC'] = rawurlencode(option_rs(execsql($sql), $idt_consultor_I, ' '));
    }

    if ($idt_consultor_I != "") {
        $sql = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
        $sql .= " from grc_atendimento_pa_pessoa_servico grc_paps ";
        $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt = grc_paps.idt_pa_pessoa ";
        $sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_paps.idt_servico ";
        $sql .= " where grc_pap.idt_usuario = " . null($idt_consultor_I);
        if ($idt_ponto_atendimento_I != "") {
            $sql .= " and grc_pap.idt_ponto_atendimento = " . null($idt_ponto_atendimento_I);
        }
        $sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";
        $vet['idt_servico_DC'] = rawurlencode(option_rs(execsql($sql), $idt_servico_I, ' '));
    }
    if ($idt_ponto_atendimento_I != "") {
        $sql = "select grc_ae.idt, grc_ae.tipo_atendimento, grc_ae.descricao ";
        $sql .= " from grc_atendimento_pa_pessoa_servico grc_paps ";
        $sql .= " inner join grc_atendimento_pa_pessoa grc_pap on grc_pap.idt = grc_paps.idt_pa_pessoa ";
        $sql .= " inner join grc_atendimento_especialidade grc_ae on grc_ae.idt = grc_paps.idt_servico ";
        $sql .= " where grc_pap.idt_ponto_atendimento = " . null($idt_ponto_atendimento_I);
        //
        if ($idt_consultor_I != "") {
            $sql .= " and grc_pap.idt_usuario = " . null($idt_consultor_I);
        }
        //
        $sql .= " order by grc_ae.tipo_atendimento, grc_ae.codigo";
        $vet['idt_servico_DC'] = rawurlencode(option_rs(execsql($sql), $idt_servico_I, ' '));
    }
}


function VerificaTempoPresoAgenda($row)
{
	$kokw        = 0;
	return  $kokw;
	// Para Agenda que esta presa verificar se libera ou não
	$datadia     = trata_data(date('d/m/Y H:i:s'));
	$idt_atendimento_agenda       = $row['idt'];
	$hora                         = $row['hora'];
	$situacao                     = $row['situacao'];
	$semmarcacao                  = $row['semmarcacao'];
	$data_hora_marcacao_inicial   = $row['data_hora_marcacao_inicial'];
	//$idt_atendimento_agenda_filho = $row['idt_atendimento_agenda'];
	$marcador                     = $row['marcador'];
	$data_hora_ausencia           = $row['data_hora_ausencia'];
	$idt_ponto_atendimento        = $row['idt_ponto_atendimento'];
	$especialidade_ponto          = $row['especialidade_ponto'];
	$especialidade                = $row['especialidade'];
	$ponto_atendimento            = $row['ponto_atendimento'];
	$cliente                      = $row['ge_descricao'];
	//
	$idt_cliente                  = $row['idt_cliente'];
	$cliente_texto                = $row['cliente_texto'];
	//
	$idt_atendimento_agenda_filho = $row['idt_atendimento_agenda']; 
	if ($cliente=="")
	{
		$cliente = $row['cliente_texto'];
	}	
	$telefone_celular             = $row['telefone_celular'];
	$servicos                     = $row['servicos'];
	// Diferença para ver o numero de minutos
	$data1     = $data_hora_marcacao_inicial;
	$data2     = $datadia;
	$nHoras    = 0;
	$nMinutos  = 0;
	$nTMinutos = 0;
	$ret = DifHorasMin($data1, $data2, $nHoras, $nMinutos, $nTMinutos);
	$difminutos = $nMinutos;
	$ParametroPresoAgenda=$_SESSION[CS]['ParametroPresoAgenda'];
	if ($ParametroPresoAgenda=="")
	{
	   $ParametroPresoAgenda=60;
	}
	if ($ParametroPresoAgenda<30)
	{   // o Parâmetro não pode ser menor que 30 minutos
	    $ParametroPresoAgenda=30;
	}
	if ($difminutos>$ParametroPresoAgenda)
	{
	    //
	    // Tem que liberar 
	    // 
		$libera=1;
	    if ($cliente_texto!="")
		{
		    // tem cliente marcado
		}
		else
		{
		    // Não tem cliente marcado
		}
		// teste se é filho (Horários desdobrados)
		//if (($idt_atendimento_agenda_filho>0) and ($idt_atendimento_agenda_filho<>$idt_atendimento_agenda) )
		if ( ($idt_atendimento_agenda_filho!='') and ($idt_atendimento_agenda_filho<>$idt_atendimento_agenda) )
		{
            // É filho e só deve liberar em conjunto		
			// Verifica o pai
			$sql  = "select  ";
			$sql .= " grc_aa.semmarcacao  ";
			$sql .= " from grc_atendimento_agenda grc_aa ";
			$sql .= ' where idt = ' . null($idt_atendimento_agenda_filho);
			$rs   = execsql($sql);
			if ($rs->rows > 0) {
				ForEach ($rs->data as $rowt) {
					$semmarcacao = $rowt['semmarcacao'];
				}	
				if ($semmarcacao!="S")
				{   
					// esta livre - LIBERA
					$libera=1;
				}	
				else
				{
				    // esta preso - Não Libera
					$libera=0;  
				}
			}    
			else
			{
				// erro não encontrou o pai... - não libera;
				$libera=0;
			}
		}
		else
		{   // É Isolado ou pai - Não libera
		    $libera=1;
			$idt_atendimento_agenda_filho=$idt_atendimento_agenda;
		}
		
		$temclienteassociado="";
		if ( ($idt_cliente == '' and $cliente_texto =="") )
		{
            // Não tem marcado
			$temclienteassociado="N";
		}
		if ( ($idt_cliente > 0 or $cliente_texto !="") )
		{
            // Ta com cliente
			$temclienteassociado="S";
		}
		if ($situacao == 'Marcado')
		{
		    //
			$temclienteassociado="S";
		}
		if ($libera==1)
		{
		    if ($temclienteassociado=="S")
		    {
		        // tem cliente marcado
				$vetPar = Array();
                $vetPar['tipo'] = 'AJUSTADO CINZA  - COM CLIENTE';
                $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                RegistrarLogAgendamento($vetPar);

				
				$sql = "update grc_atendimento_agenda ";
				$sql .= " set ";
				$sql .= " semmarcacao                = " . aspa('N') . " ";
				$sql .= " where idt = " . null($idt_atendimento_agenda);
				execsql($sql);
				// se tem filhos desmarcar
				$sql = "update grc_atendimento_agenda ";
				$sql .= " set ";
				$sql .= " semmarcacao                = " . aspa('N') . " ";
				$sql .= " where idt_atendimento_agenda = " . null($idt_atendimento_agenda);
				execsql($sql);
				$kokw=1;
		    }
			else
			{
			
			    $vetPar = Array();
                $vetPar['tipo'] = 'AJUSTADO CINZA - SEM CLIENTE';
                $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                RegistrarLogAgendamento($vetPar);

				$sql = "update grc_atendimento_agenda ";
				$sql .= " set ";
				$sql .= " situacao           = " . aspa('Agendado') . ", ";
				$sql .= " idt_atendimento_agenda = " . 'null' . ", ";
				$sql .= " idt_especialidade  = " . 'null' . ", ";
				$sql .= " idt_cliente        = " . 'null' . ", ";
				$sql .= " cliente_texto      = " . aspa('') . ", ";
				$sql .= " cpf                = " . aspa('') . ", ";
				$sql .= " cnpj               = " . aspa('') . ", ";
				$sql .= " nome_empresa       = " . aspa('') . ", ";
				$sql .= " telefone           = " . aspa('') . ", ";
				$sql .= " celular            = " . aspa('') . ", ";
				$sql .= " email              = " . aspa('') . ", ";
				$sql .= " protocolo          = " . aspa('') . ", ";
				$sql .= " assunto            = " . aspa('') . ", ";
				$sql .= " necessidade_especial = " . aspa('N') . ", ";
				$sql .= " data_hora_marcacao = " . aspa('') . ", ";
				$sql .= " observacao_desmarcacao     = " . aspa('') . ", ";
				$sql .= " semmarcacao                = " . aspa('N') . ", ";
				$sql .= " marcador                   = " . aspa('') . ", ";
				$sql .= " idt_marcador               = " . 'null' . ", ";
				$sql .= " data_hora_ausencia = " . aspa('') . ", ";
				$sql .= " observacao_desmarcacao = " . aspa('') . ", ";
				$sql .= " data_hora_marcacao_inicial = " . aspa('') . " ";
				$sql .= " where idt = " . null($idt_atendimento_agenda);
				execsql($sql);
				// se tem filhos desmarcar
				$sql = "update grc_atendimento_agenda ";
				$sql .= " set ";
				$sql .= " situacao           = " . aspa('Agendado') . ", ";
				$sql .= " idt_especialidade  = " . 'null' . ", ";
				$sql .= " idt_atendimento_agenda = " . 'null' . ", ";
				$sql .= " idt_cliente        = " . 'null' . ", ";
				$sql .= " cliente_texto      = " . aspa('') . ", ";
				$sql .= " cpf                = " . aspa('') . ", ";
				$sql .= " cnpj               = " . aspa('') . ", ";
				$sql .= " nome_empresa       = " . aspa('') . ", ";
				$sql .= " telefone           = " . aspa('') . ", ";
				$sql .= " celular            = " . aspa('') . ", ";
				$sql .= " email              = " . aspa('') . ", ";
				$sql .= " protocolo          = " . aspa('') . ", ";
				$sql .= " assunto            = " . aspa('') . ", ";
				$sql .= " necessidade_especial = " . aspa('N') . ", ";
				$sql .= " data_hora_marcacao = " . aspa('') . ", ";
				$sql .= " observacao_desmarcacao     = " . aspa('') . ", ";
				$sql .= " semmarcacao                = " . aspa('N') . ", ";
				$sql .= " marcador                   = " . aspa('') . ", ";
				$sql .= " idt_marcador               = " . 'null' . ", ";
				$sql .= " data_hora_ausencia = " . aspa('') . ", ";
				$sql .= " observacao_desmarcacao = " . aspa('') . ", ";
				$sql .= " data_hora_marcacao_inicial = " . aspa('') . " ";
				$sql .= " where idt_atendimento_agenda = " . null($idt_atendimento_agenda);
				execsql($sql);
				$kokw=1;
			}
		}
	} 
   return $kokw;  
}

function DifHorasMin($data1,$data2, &$nHoras, &$nMinutos, &$nTMinutos)
{
	$kokw=0;
	//$data1 = '2006-07-22 12:27:00';
	//$data2 = '2006-07-30 18:00:00';
	$unix_data1 = strtotime($data1);
	$unix_data2 = strtotime($data2);
	$nHoras   = ($unix_data2 - $unix_data1) / 3600;
	$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
	//
	$nTMinutos= ($nHoras*60)+$nMinutos; 
	//printf('%02d:%02d', $nHoras, $nMinutos);
	$kokw=1;
    return $kokw;
}

function MontaServicoAgenda($servicos,$idt_agenda,&$hint)
{
    $servicosw=$servicos;
	$hint     ="";
	$vet = explode('<br />',$servicos);
	//p($vet);
	$qtd = count($vet);
	$qtdmostrar=3;
	
	if ($qtd>$qtdmostrar)
	{
	    $hint     = str_replace('<br />',chr(13),$servicos);
	    $contador  = 0;
		$onclick = " onclick='return MostraServicos($idt_agenda);'" ;
		$servicosw = "<div $onclick id='ser_{$idt_agenda}' style='cursor:pointer; width:100%; display:block;'>";
		foreach ($vet as $ordem => $servico) {
		  $contador  = $contador + 1;
		  if ($contador<$qtdmostrar)
	      {	
		     $servicosw .= $servico."<br />";
		  }
		  else
		  {
			  if ($contador==$qtdmostrar)
			  {	
			      $temmais="<span style='color:#0000FF;'><img width='16' height='16' src='imagens/agenda_servico.jpg' title=''/></span>"; 
				  
                  $servicosw .= "<div style='float:left; text-align:center; width:80%;'>";
				  $servicosw .= "<span style=''>{$servico}</span><br />";
				  $servicosw .= "</div>";
				  
				  $servicosw .= "<div style='float:left;  text-align:right; width:10%; margin-right:10px;'>";
				  $servicosw .= "<span style=''>{$temmais}</span><br />";
				  $servicosw .= "</div>";
				  
				  $servicosw .= "</div>";
				  $servicosw .= "<div id='ser_oc{$idt_agenda}' style='display:none; width:100%; '>";
				  
			  }
			  else
			  {  // esconde
				  if ($contador==$qtd)
				  {
					 $servicosw .= $servico."</div>";
				  }
                  else
                  {
                     $servicosw .= $servico."<br />";

                  }
			  }
		  }
 	
		}
    }     

    return $servicosw;
}


