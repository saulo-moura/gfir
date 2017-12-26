<?php

//
// Rorina para Geração de Dados Estatísticos e Metas
//
function GerarDadosEstatisticos(&$vet) {
    $ano_base = 2017;

    $vet['erro'] = '';

    // Utilizar as siglas
    $vetInstrumentos = Array();
    $vetInstrumentos[8] = 'IN';   // Informação N
    $vetInstrumentos[13] = 'IT';   // Orientação Técnica B

    $vetInstrumentos[2] = 'CO';   // Consultoria (Balcão e outras) F
    $vetInstrumentos[50] = 'CO';   // Consultoria Técnica - "Consultoria Presencial" F;

    $vetInstrumentos[40] = 'CS';   // Curso  F
    $vetInstrumentos[41] = 'FE';   // Feira F

    $vetInstrumentos[42] = 'FP';  // FAMPE N

    $vetInstrumentos[45] = 'MC';   // Missão e Caravana F

    $vetInstrumentos[46] = 'OF';  // Oficinas F

    $vetInstrumentos[47] = 'PA';   // Palestra B
    $vetInstrumentos[48] = 'RO';   // Rodadas F
    $vetInstrumentos[49] = 'SM';   // Seminários F
    //beginTransaction();
    set_time_limit(0);
    $data_base = $vet['data_base'];
    $data_base = trata_data('31/12/' . $ano_base);

    $sql = ' truncate table ';
    $sql .= ' grc_historico_meta ';
    execsql($sql);

    for ($op = 0; $op < 3; $op++) {
        $condicao = "";

        switch ($op) {
            case 0:
                // para Atendimentos de Balcao
                $condicao .= " year(grc_a.data) = {$ano_base} and (grc_a.situacao = 'Finalizado' or grc_a.situacao = 'Finalizado em Alteração') and grc_a.idt_evento is null and grc_a.idt_grupo_atendimento is null ";
                $condicao .= " and grc_ap.tipo_relacao='L' ";
                break;

            case 1:
                // Para Atendimentos do NAN
                $condicao .= " year(grc_a.data) = {$ano_base} and ( (grc_a.nan_num_visita = 1 and grc_ga.status_1 = 'AP') or (grc_a.nan_num_visita = 2 and grc_ga.status_2 = 'AP')    )  and grc_a.idt_grupo_atendimento is not null ";
                $condicao .= " and grc_ap.tipo_relacao='L' ";
                break;

            case 2:
                // Para Atendimentos de Eventos
                $condicao .= " year(grc_a.data) = {$ano_base}  and grc_a.idt_evento is not null and grc_a.idt_grupo_atendimento is null ";
                $condicao .= " and grc_ep.contrato in ('S','G','C')";
                $condicao .= " and grc_ev.idt_evento_situacao in (19,20) "; // // Pendente e Consolidado				
                // $condicao    .= " and grc_ap.evento_concluio = 'S' "; // Consolidado
                break;
        }

        $sql = "select ";
        $sql .= "  grc_a.idt as idt_atendimento, grc_a.protocolo, grc_a.idt_evento, grc_a.data,  grc_a.horas_atendimento, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento, grc_ap.cpf , grc_ao.cnpj, ";
        $sql .= "  grc_ap.idt_segmentacao, grc_ga.status_1, grc_ga.status_2, ";
        $sql .= "  grc_ap.nome , grc_ao.razao_social , grc_ao.idt_porte, grc_ao.idt_tipo_empreendimento, ";
        $sql .= "  grc_ao.dap , grc_ao.nirf , grc_ao.rmp, grc_ao.ie_prod_rural, grc_ao.codigo_prod_rural, ";

        $sql .= "  gec_op.descricao as porte , gec_te.descricao as tipo_empreendimento, ";
        $sql .= "  grc_in.descricao as instrumento ,  ";

        $sql .= "  sac_ur.descricao as desc_unidade_regional ,sac_ur.sigla as unidade_regional , sac_or.descricao as ponto_atendimento, ";


        $sql .= "  grc_ap.evento_concluio as evento_concluido  , grc_ep.contrato as evento_contrato , grc_ev.descricao as evento, ";
        $sql .= "  grc_ev.dt_previsao_fim, grc_ev.dt_previsao_inicial, ";

        $sql .= "  grc_in.codigo as sigla_instrumento, ";
        $sql .= "  grc_ev.carga_horaria_total as horas_evento, grc_ev.idt_foco_tematico ";
        $sql .= " from grc_atendimento grc_a ";
        $sql .= " inner join grc_atendimento_pessoa       grc_ap on grc_ap.idt_atendimento  =  grc_a.idt";

        $sql .= " left  join grc_atendimento_organizacao  grc_ao on grc_ao.idt_atendimento  =  grc_a.idt";
        $sql .= "                                    and  grc_ao.representa                 =  'S'";
        //$sql .= " left  join grc_competencia         grc_c  on grc_c.idt                    =  grc_a.idt_competencia";
        $sql .= " left  join grc_nan_grupo_atendimento grc_ga on grc_ga.idt                 =  grc_a.idt_grupo_atendimento";


        $sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento       =  grc_a.idt";
        $sql .= " left  join grc_evento              grc_ev on grc_ev.idt                   =  grc_a.idt_evento";
        $sql .= " left  join " . db_pir_gec . "gec_organizacao_porte   gec_op on gec_op.idt     =  grc_ao.idt_porte";
        $sql .= " left  join " . db_pir_gec . "gec_entidade_tipo_emp   gec_te on gec_te.idt     =  grc_ao.idt_tipo_empreendimento";
        $sql .= " left  join grc_atendimento_instrumento       grc_in on grc_in.idt         =  grc_a.idt_instrumento";
        $sql .= " left  join " . db_pir . "sca_organizacao_secao   sac_or on sac_or.idt         =  grc_a.idt_ponto_atendimento";

        $sql .= " left  join " . db_pir . "sca_organizacao_secao   sac_ur on sac_ur.classificacao =  concat(substring(sac_or.classificacao,1,5), '.00.000')";

        //
        $sql .= "  where $condicao ";
        $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

        ForEach ($rsl->data as $rowl) {
            $idt_atendimento = null($rowl['idt_atendimento']);
            $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);

            $desc_unidade_regional = aspa($rowl['desc_unidade_regional']);

            if ($rowl['unidade_regional'] == "") {
                $unidade_regional = aspa($rowl['$desc_unidade_regional']);
            } else {
                $unidade_regional = aspa($rowl['unidade_regional']);
            }
            $pa = aspa($rowl['ponto_atendimento']);


            $idt_instrumento = null($rowl['idt_instrumento']);

            $sigla_instrumento = $rowl['sigla_instrumento'];

            $idt_evento = null($rowl['idt_evento']);
            $idt_segmentacao = null($rowl['idt_segmentacao']);
            $idt_foco_tematico = null($rowl['idt_foco_tematico']);
            $data_atendimento = aspa($rowl['data']);
            $horas_atendimento = null($rowl['horas_atendimento']);
            $horas_evento = null($rowl['horas_evento']);
            $cpf = aspa($rowl['cpf']);
            $cnpj = aspa($rowl['cnpj']);

            $dap = $rowl['dap'];
            $nirf = $rowl['nirf'];
            $rmp = $rowl['rmp'];
            $ie_prod_rural = $rowl['ie_prod_rural'];
            $codigo_prod_rural = $rowl['codigo_prod_rural'];

            $status_1 = aspa($rowl['status_1']);
            $status_2 = aspa($rowl['status_2']);

            if ($idt_evento > 0) {
                $origem = aspa('Evento');
            } else {
                $origem = aspa('Balcão');
            }

            $data_basew = aspa($data_base);
            $idt_porte = null($rowl['idt_porte']);

            $idt_tipo_empreendimento = null($rowl['idt_tipo_empreendimento']);

            $razao_social = aspa($rowl['razao_social']);
            $nome = aspa($rowl['nome']);
            $porte = aspa($rowl['porte']);
            $tipo_empreendimento = aspa($rowl['tipo_empreendimento']);
            $instrumento = aspa($rowl['instrumento']);

            $ponto_atendimento = aspa($rowl['ponto_atendimento']);

            if ($rowl['evento_concluido'] != "S") {
                $rowl['evento_concluido'] = "N";
            }

            $evento_concluido = aspa($rowl['evento_concluido']);

            $evento_concluidot = $rowl['evento_concluido'];

            $evento_contrato = aspa($rowl['evento_contrato']);

            $evento = aspa($rowl['evento']);
            $protocolo = aspa($rowl['protocolo']);
            $dt_previsao_inicial = aspa($rowl['dt_previsao_inicial']);
            $dt_previsao_fim = aspa($rowl['dt_previsao_fim']);

            // Classificação
            // Inovação
            $inovacao = aspa("N");
            $inovacaot = "N";
            if ($rowl['idt_evento'] == '') {
                $sql = "select ";
                $sql .= "  grc_at.idt ";
                $sql .= " from grc_atendimento_tema grc_at ";
                // $sql .= " inner join grc_tema_subtema  grc_ts on grc_ts.idt  = grc_at.idt_tema ";
                $sql .= "  where grc_at.idt_atendimento = {$idt_atendimento} ";
                $sql .= "    and grc_at.idt_tema = 80 ";    // inovacao
                $rsx = execsql($sql);
                if ($rsx->rows > 0) {   // Trata de Inovação
                    $inovacao = aspa("S");
                    $inovacaot = "S";
                }
            } else {
                if ($idt_foco_tematico == 3) {
                    $inovacao = aspa("S");
                    $inovacaot = "S";
                }
            }
            // Empresa
            $tipo_pessoaw = "";
            $naturezaw = "";
            if ($rowl['cnpj'] != '') {  // Atendimento a Empresa com CNPJ ou Produtor Rural
                $naturezaw = "AC"; // A CLASSIFICAR
                $tipo_pessoaw = "J";

                if ($rowl['idt_tipo_empreendimento'] > 0) {
                    $naturezaw = "NP"; // NÃO SE APLICA

                    if ($rowl['idt_tipo_empreendimento'] == 4) { // Empresa com CNPJ - 99
                        $naturezaw = "EM";
                    }

                    if ($rowl['idt_tipo_empreendimento'] == 7) { // Produtor Rural - 12
                        $naturezaw = "PR";

                        // Mover o dap... para cnpj
                        //
			// a ordem é para pegar dos mais fracos para o mais forte
                        $cnpj = aspa('PR_CNPJ_' . $rowl['cnpj']);
                        if ($rowl['codigo_prod_rural'] != "") {
                            $cnpj = aspa('PR_CPR_' . $rowl['codigo_prod_rural']);
                        }
                        if ($rowl['codigo_prod_rural'] != "") {
                            $cnpj = aspa('PR_IEPR_' . $rowl['ie_prod_rural']);
                        }
                        if ($rowl['rmp'] != "") {
                            $cnpj = aspa('PR_RMP_' . $rowl['rmp']);
                        }
                        if ($rowl['dap'] != "") {
                            $cnpj = aspa('PR_DAP_' . $rowl['dap']);
                        }
                        if ($rowl['nirf'] != "") {
                            $cnpj = aspa('PR_NIRF_' . $rowl['nirf']);
                        }
                    }
                    if ($rowl['idt_tipo_empreendimento'] == 3) { // Cooperativa - 5
                        $naturezaw = "CO";
                    }
                } else {
                    
                }
            } else {  // Atendimento a CPF
                $tipo_pessoaw = "F";
                $naturezaw = "PF";
            }
            $natureza = aspa($naturezaw);
            $tipo_pessoa = aspa($tipo_pessoaw);

            // pORTE DA EMPRESA
            $porte_metaw = "NA";
            if ($rowl['idt_porte'] == 5) { // MEI
                $porte_metaw = "MEI";
            }
            if ($rowl['idt_porte'] == 3) { // MICROEMPRESA
                $porte_metaw = "ME";
            }
            if ($rowl['idt_porte'] == 1) { // EMPRESA DE PEQUENO PORTE
                $porte_metaw = "EPP";
            }

            //
            $segmentacaow = "AC"; // A classificar

            if ($rowl['idt_segmentacao'] != "") {
                if ($idt_segmentacao == 3) { // Potencial Empreendedor
                    $segmentacaow = "PEE";
                } else {
                    $segmentacaow = "PE"; // Potencial empresário
                }
            } else {
                
            }

            if ($tipo_pessoaw == "F") {
                $porte_metaw = $segmentacaow;
            }
            $porte_meta = aspa($porte_metaw);

            $segmentacao = aspa($segmentacaow);
            // Classificar instrumentos
            // Intensidade - Nula, Baixa e Alta
            // Nula  = Não conta                  - Informação
            // Baixa = Conta apenas uma vez 	  - Palestras e Orientações Técnicas	
            // Alta  = Conta todas as vezes 	  - Demais.
            // cLASSIFICAR
            $instrumento_siglaw = "AC"; // a classificar
            //
		    if ($idt_instrumento > 0) {
                $sigla_instrumento = substr($sigla_instrumento, 0, 2);
                if ($sigla_instrumento == '') {
                    $instrumento_siglaw = "ER"; // erro
                } else {
                    $instrumento_siglaw = $sigla_instrumento;
                }
            }
            if ($instrumento_siglaw == 'CT') { // Consultoria Tecnológica
                $instrumento_siglaw = 'CO'; // considerar como CO
            }

            //
            $instrumento_sigla = aspa($instrumento_siglaw);

            // Intensidade
            $instrumento_intensidadew = "AL"; // ALTA

            if ($idt_instrumento == 8) { // Informação
                $instrumento_intensidadew = "NU"; // NULA
            } else {
                if (($idt_instrumento == 13) or ( $idt_instrumento == 47)) {  // Orientação Técnica e Palestra
                    $instrumento_intensidadew = "BX"; // BAIXA
                } else {
                    if (($idt_instrumento == 2) or ( $idt_instrumento == 50)  // CONSULTORIA (BALCÃO) E CONSULTORIA TECNICA
                            or ( $idt_instrumento == 40) or ( $idt_instrumento == 48)  // Curso E Rodadas
                            or ( $idt_instrumento == 41) or ( $idt_instrumento == 45)  // Feira E Missão e Caravana
                            or ( $idt_instrumento == 46) or ( $idt_instrumento == 49)  // Oficina e Seminário
                    ) {
                        $instrumento_intensidadew = "AL"; // ALTA
                    } else {
                        $instrumento_intensidadew = "NU"; // NULA
                    }
                }
            }

            //
            $instrumento_intensidade = aspa($instrumento_intensidadew);
            //
            // $unidade_regional = aspa("");
            // $pa               = aspa("");

            $sql_i = ' insert into grc_historico_meta ';
            $sql_i .= ' (  ';
            $sql_i .= " data_base, ";
            $sql_i .= " idt_atendimento, ";
            $sql_i .= " idt_evento, ";
            $sql_i .= " idt_foco_tematico, ";
            $sql_i .= " idt_segmentacao, ";
            $sql_i .= " data_atendimento, ";
            $sql_i .= " horas_atendimento, ";
            $sql_i .= " horas_evento, ";
            $sql_i .= " idt_ponto_atendimento, ";
            $sql_i .= " unidade_regional, ";
            $sql_i .= " pa, ";
            $sql_i .= " idt_instrumento, ";
            $sql_i .= " cpf, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " status_1, ";
            $sql_i .= " status_2, ";
            $sql_i .= " idt_porte, ";
            $sql_i .= " idt_tipo_empreendimento, ";
            $sql_i .= " razao_social, ";
            $sql_i .= " nome, ";
            $sql_i .= " porte, ";
            $sql_i .= " tipo_empreendimento, ";
            $sql_i .= " instrumento, ";
            $sql_i .= " ponto_atendimento, ";
            $sql_i .= " evento_concluido, ";
            $sql_i .= " evento_contrato, ";
            $sql_i .= " evento, ";
            $sql_i .= " protocolo, ";
            $sql_i .= " inovacao, ";
            $sql_i .= " tipo_pessoa, ";
            $sql_i .= " natureza, ";
            $sql_i .= " porte_meta, ";
            $sql_i .= " segmentacao, ";
            $sql_i .= " instrumento_sigla, ";
            $sql_i .= " instrumento_intensidade, ";
            $sql_i .= " dt_previsao_fim, ";
            $sql_i .= " dt_previsao_inicial, ";
            $sql_i .= " origem ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $data_basew, ";
            $sql_i .= " $idt_atendimento, ";
            $sql_i .= " $idt_evento, ";
            $sql_i .= " $idt_foco_tematico, ";
            $sql_i .= " $idt_segmentacao, ";
            $sql_i .= " $data_atendimento, ";
            $sql_i .= " $horas_atendimento, ";
            $sql_i .= " $horas_evento, ";
            $sql_i .= " $idt_ponto_atendimento, ";
            $sql_i .= " $unidade_regional, ";
            $sql_i .= " $pa, ";
            $sql_i .= " $idt_instrumento, ";
            $sql_i .= " $cpf, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $status_1, ";
            $sql_i .= " $status_2, ";
            $sql_i .= " $idt_porte, ";
            $sql_i .= " $idt_tipo_empreendimento, ";
            $sql_i .= " $razao_social, ";
            $sql_i .= " $nome, ";
            $sql_i .= " $porte, ";
            $sql_i .= " $tipo_empreendimento, ";
            $sql_i .= " $instrumento, ";
            $sql_i .= " $ponto_atendimento, ";
            $sql_i .= " $evento_concluido, ";
            $sql_i .= " $evento_contrato, ";
            $sql_i .= " $evento, ";
            $sql_i .= " $protocolo, ";
            $sql_i .= " $inovacao, ";
            $sql_i .= " $tipo_pessoa, ";
            $sql_i .= " $natureza, ";
            $sql_i .= " $porte_meta, ";
            $sql_i .= " $segmentacao, ";
            $sql_i .= " $instrumento_sigla, ";
            $sql_i .= " $instrumento_intensidade, ";
            $sql_i .= " $dt_previsao_fim, ";
            $sql_i .= " $dt_previsao_inicial, ";
            $sql_i .= " $origem ";
            $sql_i .= ') ';
            execsql($sql_i);
        }
    }

    $sql = "select ";
    $sql .= " idt, idt_evento, cpf, cnpj, evento_concluido, tipo_pessoa, natureza, porte_meta, segmentacao, instrumento_sigla, instrumento_intensidade, inovacao ";
    $sql .= ' from grc_historico_meta ';
    $sql .= ' where tipo_pessoa = ' . aspa('J'); // Meta é para Pessoa Jurídica
    $sql .= ' order by data_atendimento ';
    $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

    $vetCNPJ = Array();
    ForEach ($rsl->data as $rowl) {
        $idt_historico_meta = $rowl['idt'];
        $idt_evento = $rowl['idt_evento'];
        $cpf = $rowl['cpf'];
        $cnpj = $rowl['cnpj'];
        $evento_concluido = $rowl['evento_concluido'];
        $tipo_pessoa = $rowl['tipo_pessoa'];
        $natureza = $rowl['natureza'];
        $porte_meta = $rowl['porte_meta'];
        $segmentacao = $rowl['segmentacao'];
        $instrumento_sigla = $rowl['instrumento_sigla'];
        $instrumento_intensidade = $rowl['instrumento_intensidade'];
        $inovacao = $rowl['inovacao'];

        // Critérios para Meta 1
        $meta1 = "N";
        // Enquadramento da Empresa
        $vetReprovado = Array();
        if ($natureza == "EM") {
            if ($porte_meta == 'MEI' or $porte_meta == 'ME' or $porte_meta == 'EPP') {
                $meta1 = "S";
            } else {
                $vetReprovado[] = "[EM001] Meta 1 - Porte da Empresa - com CNPJ: {$porte_meta}";
            }
        } else {
            if ($natureza == "PR") {
                if ($porte_meta == 'ME' or $porte_meta == 'EPP') {
                    $meta1 = "S";
                } else {
                    $vetReprovado[] = "[EM002] Meta 1 - Porte da Empresa - Produtor Rural: {$porte_meta}";
                }
            } else {
                if ($natureza == "CO") {
                    if ($porte_meta == 'ME' or $porte_meta == 'EPP') {
                        $meta1 = "S";
                    } else {
                        $vetReprovado[] = "[EM003] Meta 1 - Porte da Empresa - Cooperativa: {$porte_meta}";
                    }
                } else {
                    $meta1 = "N";
                    $vetReprovado[] = "[EM004] Meta 1 - Natureza diferente de 'EM', 'PR' e 'CO' ";
                }
            }
        }
        //
        // Enquadramento do Atendimento
        //
		
		if ($meta1 == "S") {
            if ($instrumento_sigla == 'CO' or
                    $instrumento_sigla == 'CS' or
                    $instrumento_sigla == 'PA' or
                    $instrumento_sigla == 'IT' or
                    $instrumento_sigla == 'RO' or
                    $instrumento_sigla == 'MC' or
                    $instrumento_sigla == 'FE' or
                    $instrumento_sigla == 'SM' or
                    $instrumento_sigla == 'OF'
            ) {
                
            } else {
                $meta1 = "N";
                $vetReprovado[] = "[AT001] Meta 1 - Atendimento com Instrumento diferente de 'CO', 'CS', 'PA', 'IT', 'RO', 'MC', 'FE', 'SM'  e 'OF' ";
            }
        }

        if ($idt_evento > 0 and $meta1 == "S") { // Para Evento verificar se concluido
            if ($evento_concluido == 'S') {
                
            } else {
                $meta1 = "N";
                $vetReprovado[] = "[AT002] Meta 1 - Atendimento Matrícula sem Conclusão na Consolidação ";
            }
        }

        //  Fim do enquadramento na meta 1
        // Enquadramento na meta 2
        $meta2 = "N";
        if ($meta1 == "S") { // Tem que estar na Meta 1
            // Pequenos Negocios com foco em Inovação
            if ($inovacao == 'S') {
                $meta2 = "S";
            } else {
                $vetReprovado[] = "[AT003] Meta 2 - Atendimento Não é de Inovação ";
            }
        }
        // Enquadramento na meta 3
        $meta3 = "N";
        if ($meta1 == "S") { // Tem que estar na Meta 1
            // Pequenos Negocios com foco em Inovação
            if ($porte_meta == 'MEI') {
                $meta3 = "S";
            } else {
                $vetReprovado[] = "[AT004] Meta 3 - Atendimento Não é MEI ";
            }
        }
        // Enquadramento na meta 4
        $meta4 = "N";
        if ($meta1 == "S") { // Tem que estar na Meta 1
            // Pequenos Negocios com foco em Inovação
            if ($porte_meta == 'ME') {
                $meta4 = "S";
            } else {
                $vetReprovado[] = "[AT004] Meta 4 - Atendimento Não é ME - Microempresa ";
            }
        }
        // Enquadramento na meta 5
        $meta5 = "N";
        if ($meta1 == "S") { // Tem que estar na Meta 1
            // Pequenos Negocios com foco em Inovação
            if ($porte_meta == 'EPP') {
                $meta5 = "S";
            } else {
                $vetReprovado[] = "[AT005] Meta 5 - Atendimento Não é EPP ";
            }
        }

        //
        $ordem_cnpj = 0;
        //if ($meta1=='S')
        //{		
        //if ($tipo_pessoa == 'F') {
        //    $vetCNPJ[$cpf]  = $vetCNPJ[$cpf] + 1;
        //} else {
        $vetCNPJ[$cnpj] = $vetCNPJ[$cnpj] + 1;
        //}
        $ordem_cnpj = $vetCNPJ[$cnpj];
        //}			
        //  Considerar a intensidade
        //
        $req_intensidade = 'N';

        if ($instrumento_intensidade == 'BX' or $instrumento_intensidade == 'AL') {
            $vetCNPJINT[$cnpj][$instrumento_intensidade] = $vetCNPJINT[$cnpj][$instrumento_intensidade] + 1;
        }

        if ($vetCNPJINT[$cnpj]['AL'] > 1) {   // Serve
            if ($vetCNPJSRV[$cnpj] != 'S') {

                $vetCNPJSRV[$cnpj] = 'S';
                $req_intensidade = 'S';
            }
        }
        if ($vetCNPJINT[$cnpj]['AL'] == 1 and $vetCNPJINT[$cnpj]['BX'] > 0) {   // Serve
            if ($vetCNPJSRV[$cnpj] != 'S') {

                $vetCNPJSRV[$cnpj] = 'S';
                $req_intensidade = 'S';
            }
        }

        // Enquadramento na meta 7
        $meta7 = "N";
        if ($meta1 == "S") { // Tem que estar na Meta 1
            // Pequenos Negocios com foco em Inovação
            if ($req_intensidade == 'S') {
                $meta7 = "S";
            } else {
                $vetReprovado[] = "[AT006] Meta 7 - Não atende a condição de 2 fortes ou um fraco e um forte ";
            }
        }

        $req_intensidade = aspa($req_intensidade);


        //
        //  Fim do enquadramento nas metas 
        //
		$reprovadow = "";
        $separador = "";
        ForEach ($vetReprovado as $indice => $mensagem) {
            $reprovadow .= $separador . $mensagem;
            $separador = "#";
        }
        $reprovado = aspa($reprovadow);




        $sql_a = " update grc_historico_meta set ";
        $sql_a .= " meta1           = " . aspa($meta1) . ",   ";
        $sql_a .= " meta2           = " . aspa($meta2) . ",   ";
        $sql_a .= " meta3           = " . aspa($meta3) . ",   ";
        $sql_a .= " meta4           = " . aspa($meta4) . ",   ";
        $sql_a .= " meta5           = " . aspa($meta5) . ",   ";
        $sql_a .= " meta7           = " . aspa($meta7) . ",   ";
        $sql_a .= " req_intensidade = " . $req_intensidade . ",   ";
        $sql_a .= " ordem_cnpj      = " . null($ordem_cnpj) . ",   ";
        $sql_a .= " reprovadom1     = " . $reprovado . "   ";
        $sql_a .= " where idt       = " . null($idt_historico_meta);
        execsql($sql_a);
        // 
    }

    //
    // Geração dos Cubos 
    //
	GerarCubos();
    //commit(); 
    set_time_limit(30);
}

function GerarCubos() {
    $ano_base = 2017;

    // Cubo Geral
    $cubo_nome = path_fisico . "obj_file/cubo/crm_cubo_geral.cub";
    $fp = fopen($cubo_nome, 'w');
    $rowSGE = Array(
        'Tipo Pessoa',
        'Porte',
        'Instrumento',
        'Intensidade',
        'Natureza',
        'Concluinte',
        'CNPJ Único',
        'UR',
        'PA',
    );
    $rowSGE = array_map('utf8_encode', $rowSGE);
    fputcsv($fp, $rowSGE, ';');
    $sql = "select ";
    $sql .= " tipo_pessoa, porte_meta, instrumento_sigla, instrumento_intensidade, natureza, evento_concluido, ordem_cnpj, unidade_regional, pa  ";
    $sql .= ' from grc_historico_meta ';
    $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
    foreach ($rsl->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        $rowSGE = array_map('utf8_encode', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }
    fclose($fp);

    // Meta 1
    $cubo_nome = path_fisico . "obj_file/cubo/crm_cubo_meta1.cub";
    $fp = fopen($cubo_nome, 'w');
    $rowSGE = Array(
        'cnpj',
        'Porte',
        'Natureza'
    );
    $rowSGE = array_map('utf8_encode', $rowSGE);
    fputcsv($fp, $rowSGE, ';');
    $sql = "select ";
    $sql .= " cnpj, porte_meta, natureza  ";
    $sql .= ' from grc_historico_meta ';
    $sql .= " where meta1 = 'S' and ordem_cnpj = 1 ";
    $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
    foreach ($rsl->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        $rowSGE = array_map('utf8_encode', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }
    fclose($fp);

    // Cubo de Fidelização
    // Meta 7
    $cubo_nome = path_fisico . "obj_file/cubo/crm_cubo_meta7.cub";
    $fp = fopen($cubo_nome, 'w');
    $rowSGE = Array(
        'cnpj',
        'Porte',
        'Natureza'
    );
    $rowSGE = array_map('utf8_encode', $rowSGE);
    fputcsv($fp, $rowSGE, ';');
    $sql = "select ";
    $sql .= " cnpj, porte_meta, natureza  ";
    $sql .= ' from grc_historico_meta ';
    $sql .= " where meta7 ='S' and req_intensidade = 'S'  ";
    $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
    foreach ($rsl->data as $rowSGE) {
        $rowSGE = array_map('conHTML10', $rowSGE);
        $rowSGE = array_map('utf8_encode', $rowSGE);
        fputcsv($fp, $rowSGE, ';');
    }
    fclose($fp);
}

function GerarDW(&$vet) {
    $ano_base = 2017;

    $vet['erro'] = '';

    // Utilizar as siglas
    $vetInstrumentos = Array();
    $vetInstrumentos[8] = 'IN';   // Informação N
    $vetInstrumentos[13] = 'IT';  // Orientação Técnica B
    $vetInstrumentos[2] = 'CO';   // Consultoria (Balcão e outras) F
    $vetInstrumentos[50] = 'CO';  // Consultoria Técnica - "Consultoria Presencial" F;
    $vetInstrumentos[40] = 'CS';  // Curso  F
    $vetInstrumentos[41] = 'FE';  // Feira F
    $vetInstrumentos[42] = 'FP';  // FAMPE N
    $vetInstrumentos[45] = 'MC';  // Missão e Caravana F
    $vetInstrumentos[46] = 'OF';  // Oficinas F
    $vetInstrumentos[47] = 'PA';  // Palestra B
    $vetInstrumentos[48] = 'RO';  // Rodadas F
    $vetInstrumentos[49] = 'SM';  // Seminários F
    //beginTransaction();
    set_time_limit(0);
    $data_base = $vet['data_base'];
    $data_base = trata_data('31/12/' . $ano_base);

    $tabela_ref = " grc_dw_{$ano_base}_indicadores_qualidade ";

    $sql = ' truncate table ';
    $sql .= " {$tabela_ref} ";
    execsql($sql);

    $tabela_ref_iq = " grc_dw_{$ano_base}_iq ";
    $sql = ' truncate table ';
    $sql .= " {$tabela_ref_iq} ";
    execsql($sql);

    $tabela_ref_mc = "grc_dw_{$ano_base}_matriz_campos";
    $sql = ' truncate table ';
    $sql .= " {$tabela_ref_mc} ";
    execsql($sql);

    $tabela_ref_mc = "grc_dw_{$ano_base}_matriz_campos_iq_3";
    $sql = ' truncate table ';
    $sql .= " {$tabela_ref_mc} ";
    execsql($sql);

    //for ($op = 0; $op < 3; $op++) {
    for ($op = 0; $op < 1; $op++) {
        $condicao = "";

        switch ($op) {
            case 0:
                // para Atendimentos de Balcao
                $condicao .= " year(grc_a.data) = {$ano_base} and (grc_a.situacao = 'Finalizado' or grc_a.situacao = 'Finalizado em Alteração') and grc_a.idt_evento is null and grc_a.idt_grupo_atendimento is null ";
                $condicao .= " and grc_ap.tipo_relacao='L' ";
                break;

            case 1:
                // Para Atendimentos do NAN
                $condicao .= " year(grc_a.data) = {$ano_base} and ( (grc_a.nan_num_visita = 1 and grc_ga.status_1 = 'AP') or (grc_a.nan_num_visita = 2 and grc_ga.status_2 = 'AP')    )  and grc_a.idt_grupo_atendimento is not null ";
                $condicao .= " and grc_ap.tipo_relacao='L' ";
                break;

            case 2:
                // Para Atendimentos de Eventos
                $condicao .= " year(grc_a.data) = {$ano_base}  and grc_a.idt_evento is not null and grc_a.idt_grupo_atendimento is null ";
                $condicao .= " and grc_ep.contrato in ('S','G','C')";
                $condicao .= " and grc_ev.idt_evento_situacao in (19,20) "; // // Pendente e Consolidado				
                // $condicao    .= " and grc_ap.evento_concluio = 'S' "; // Consolidado
                break;
        }

        $sql = "select ";
        $sql .= "  grc_a.idt as idt_atendimento";
        $sql .= " from grc_atendimento grc_a ";
        $sql .= " inner join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt";
        $sql .= " left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt and  grc_ao.representa =  'S'";
        // $sql .= " left  join grc_competencia         grc_c  on grc_c.idt                    =  grc_a.idt_competencia";
        $sql .= " left  join grc_nan_grupo_atendimento grc_ga on grc_ga.idt = grc_a.idt_grupo_atendimento";
        $sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento = grc_a.idt";
        $sql .= " left  join grc_evento grc_ev on grc_ev.idt = grc_a.idt_evento";

        // Condições 
        $sql .= "  where $condicao ";
        $sql .= " and grc_ao.cnpj IS NOT NULL ";
        $sql .= " and grc_ao.idt_tipo_empreendimento <> 7 ";

        $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);

        $vetPA = Array();
        $vetURPA = Array();

        ForEach ($rsl->data as $rowTMP) {
            $sql = "select ";
            $sql .= "  grc_a.idt as idt_atendimento, grc_a.idt_consultor, plu_usu.nome_completo as nome_consultor, grc_a.protocolo, grc_a.idt_evento, ";
            $sql .= "  grc_a.data, grc_a.idt_ponto_atendimento, grc_a.idt_instrumento, grc_ap.cpf , grc_ao.cnpj, ";
            $sql .= "  grc_a.data_atendimento_aberta, grc_a.horas_atendimento, grc_a.demanda, grc_ap.idt_segmentacao, ";
            $sql .= "  grc_a.hora_inicio_atendimento, grc_a.hora_termino_atendimento, ";
            $sql .= "  grc_ga.status_1, grc_ga.status_2, grc_ap.nome , grc_ao.razao_social , grc_ao.idt_porte, ";
            $sql .= "  grc_ao.idt_tipo_empreendimento, grc_ao.dap , grc_ao.nirf , grc_ao.rmp, grc_ao.ie_prod_rural, ";
            $sql .= "  grc_ao.codigo_prod_rural, gec_op.descricao as porte, gec_op.descricao_rf as descricao_rf, gec_te.descricao as tipo_empreendimento, ";
            $sql .= "  grc_in.descricao as instrumento, sac_ur.descricao as desc_unidade_regional ,sac_ur.sigla as unidade_regional, ";
            $sql .= "  sac_or.descricao as ponto_atendimento, grc_a.data_inicio_atendimento as data_inicio_atendimento,  ";
            $sql .= "  grc_ap.telefone_residencial as telefone_residencial, grc_ap.telefone_celular as telefone_celular, ";
            $sql .= "  grc_ap.telefone_recado as telefone_recado, grc_ap.idt_escolaridade as idt_escolaridade, ";
            $sql .= "  grc_ap.potencial_personagem as potencial_personagem, grc_ap.necessidade_especial as necessidade_especial, ";
            $sql .= "  grc_ao.idt as idt_atendimento_organizacao, grc_ao.telefone_comercial_e as telefone_comercial_e, ";
            $sql .= "  grc_ao.telefone_celular_e as telefone_celular_e, grc_ao.simples_nacional as simples_nacional, ";
            $sql .= "  grc_ap.data_nascimento as data_nascimento, grc_ap.email as email, grc_ap.logradouro_cep as logradouro_cep, ";
            $sql .= "  grc_ap.logradouro_endereco as logradouro_endereco, grc_ap.logradouro_numero as logradouro_numero, ";
            $sql .= "  grc_ap.logradouro_complemento as logradouro_complemento, grc_ap.logradouro_bairro as logradouro_bairro, ";
            $sql .= "  grc_ap.logradouro_cidade as logradouro_cidade, grc_ap.logradouro_estado as logradouro_estado, ";
            $sql .= "  grc_ap.logradouro_pais as logradouro_pais, ";
            $sql .= "  grc_ao.email_e as email_e, grc_ao.logradouro_cep_e as logradouro_cep_e, grc_ao.logradouro_endereco_e as logradouro_endereco_e, ";
            $sql .= "  grc_ao.logradouro_numero_e as logradouro_numero_e, grc_ao.logradouro_complemento_e as logradouro_complemento_e, ";
            $sql .= "  grc_ao.logradouro_bairro_e as logradouro_bairro_e, grc_ao.logradouro_cidade_e as logradouro_cidade_e, ";
            $sql .= "  grc_ao.logradouro_estado_e as logradouro_estado_e, grc_ao.logradouro_pais_e as logradouro_pais_e, ";
            $sql .= "  grc_ao.idt_cnae_principal as idt_cnae_principal, grc_ao.data_abertura as data_abertura, ";
            $sql .= "  grc_ap.evento_concluio as evento_concluido, grc_ep.contrato as evento_contrato, grc_ev.descricao as evento, ";
            $sql .= "  grc_ev.dt_previsao_fim, grc_ev.dt_previsao_inicial, grc_in.codigo as sigla_instrumento, ";
            $sql .= "  cnae.subclasse as cnae_subclasse, cnae.descricao as cnae_descricao,";
            $sql .= "  grc_ev.carga_horaria_total as horas_evento, grc_ev.idt_foco_tematico ";
            $sql .= " from grc_atendimento grc_a ";
            $sql .= " inner join grc_atendimento_pessoa grc_ap on grc_ap.idt_atendimento = grc_a.idt";
            $sql .= " left  join grc_atendimento_organizacao grc_ao on grc_ao.idt_atendimento = grc_a.idt and  grc_ao.representa =  'S'";
            // $sql .= " left  join grc_competencia         grc_c  on grc_c.idt                    =  grc_a.idt_competencia";
            $sql .= " left  join grc_nan_grupo_atendimento grc_ga on grc_ga.idt = grc_a.idt_grupo_atendimento";
            $sql .= " left  join grc_evento_participante grc_ep on grc_ep.idt_atendimento = grc_a.idt";
            $sql .= " left  join grc_evento grc_ev on grc_ev.idt = grc_a.idt_evento";
            $sql .= " left  join " . db_pir_gec . "gec_organizacao_porte gec_op on gec_op.idt =  grc_ao.idt_porte";
            $sql .= " left  join " . db_pir_gec . "gec_entidade_tipo_emp gec_te on gec_te.idt =  grc_ao.idt_tipo_empreendimento";
            $sql .= " left  join grc_atendimento_instrumento grc_in on grc_in.idt =  grc_a.idt_instrumento";
            $sql .= " left  join " . db_pir . "sca_organizacao_secao sac_or on sac_or.idt = grc_a.idt_ponto_atendimento";
            $sql .= " left  join " . db_pir . "sca_organizacao_secao sac_ur on sac_ur.classificacao = concat(substring(sac_or.classificacao,1,5), '.00.000')";
            $sql .= " left  join plu_usuario plu_usu on plu_usu.id_usuario = grc_a.idt_consultor";
            $sql .= " left  join " . db_pir_gec . "cnae on cnae.subclasse = grc_ao.idt_cnae_principal";
            $sql .= "  where grc_a.idt = " . null($rowTMP['idt_atendimento']);
            $rsTMP = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
            $rowl = $rsTMP->data[0];

            $idt_atendimento = null($rowl['idt_atendimento']);
            $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
            $idt_consultor = null($rowl['idt_consultor']);
            $idt_atendimento_organizacao = $rowl['idt_atendimento_organizacao'];
            $nome_consultor = aspa($rowl['nome_consultor']);

            $desc_unidade_regional = aspa($rowl['desc_unidade_regional']);

            if ($rowl['unidade_regional'] == "") {
                $unidade_regional = aspa($rowl['$desc_unidade_regional']);
            } else {
                $unidade_regional = aspa($rowl['unidade_regional']);
            }
            $pa = aspa($rowl['ponto_atendimento']);

            $vetPA[$idt_ponto_atendimento] = $rowl['ponto_atendimento'];
            $vetURPA[$idt_ponto_atendimento] = $rowl['desc_unidade_regional'];

            $idt_instrumento = null($rowl['idt_instrumento']);
            $sigla_instrumento = $rowl['sigla_instrumento'];
            $idt_evento = null($rowl['idt_evento']);
            $idt_segmentacao = null($rowl['idt_segmentacao']);
            $idt_foco_tematico = null($rowl['idt_foco_tematico']);
            $data_atendimento = aspa($rowl['data']);
            $horas_atendimento = null($rowl['horas_atendimento']);
            $demanda = aspa($rowl['demanda']);
            $demanda_md5 = aspa(md5($rowl['demanda']));
            $horas_evento = null($rowl['horas_evento']);
            $cpf = aspa($rowl['cpf']);
            $cnpj = aspa($rowl['cnpj']);
            $dap = $rowl['dap'];
            $nirf = $rowl['nirf'];
            $rmp = $rowl['rmp'];
            $ie_prod_rural = $rowl['ie_prod_rural'];
            $codigo_prod_rural = $rowl['codigo_prod_rural'];
            $status_1 = aspa($rowl['status_1']);
            $status_2 = aspa($rowl['status_2']);

            if ($idt_evento > 0) {
                $origem = aspa('Evento');
            } else {
                $origem = aspa('Balcão');
            }

            $data_basew = aspa($data_base);
            $idt_porte = null($rowl['idt_porte']);
            $idt_tipo_empreendimento = null($rowl['idt_tipo_empreendimento']);
            $razao_social = aspa($rowl['razao_social']);
            $nome = aspa($rowl['nome']);
            $porte = aspa($rowl['porte']);
            $descricao_rf = aspa($rowl['descricao_rf']);
            $tipo_empreendimento = aspa($rowl['tipo_empreendimento']);
            $instrumento = aspa($rowl['instrumento']);
            $ponto_atendimento = aspa($rowl['ponto_atendimento']);

            if ($rowl['evento_concluido'] != "S") {
                $rowl['evento_concluido'] = "N";
            }

            $evento_concluido = aspa($rowl['evento_concluido']);
            $evento_concluidot = $rowl['evento_concluido'];
            $evento_contrato = aspa($rowl['evento_contrato']);
            $evento = aspa($rowl['evento']);
            $protocolo = aspa($rowl['protocolo']);
            $dt_previsao_inicial = aspa($rowl['dt_previsao_inicial']);
            $dt_previsao_fim = aspa($rowl['dt_previsao_fim']);

            // Classificação
            // Inovação
            $inovacao = aspa("N");
            $inovacaot = "N";

            // Empresa
            $tipo_pessoaw = "";
            $naturezaw = "";
            if ($rowl['cnpj'] != '') {  // Atendimento a Empresa com CNPJ ou Produtor Rural
                $naturezaw = "AC"; // A CLASSIFICAR
                $tipo_pessoaw = "J";

                if ($rowl['idt_tipo_empreendimento'] > 0) {
                    $naturezaw = "NP"; // NÃO SE APLICA

                    if ($rowl['idt_tipo_empreendimento'] == 4) { // Empresa com CNPJ - 99
                        $naturezaw = "EM";
                    }

                    if ($rowl['idt_tipo_empreendimento'] == 7) { // Produtor Rural - 12
                        $naturezaw = "PR";

                        // Mover o dap... para cnpj
                        //
			// a ordem é para pegar dos mais fracos para o mais forte
                        $cnpj = aspa('PR_CNPJ_' . $rowl['cnpj']);
                        if ($rowl['codigo_prod_rural'] != "") {
                            $cnpj = aspa('PR_CPR_' . $rowl['codigo_prod_rural']);
                        }
                        if ($rowl['codigo_prod_rural'] != "") {
                            $cnpj = aspa('PR_IEPR_' . $rowl['ie_prod_rural']);
                        }
                        if ($rowl['rmp'] != "") {
                            $cnpj = aspa('PR_RMP_' . $rowl['rmp']);
                        }
                        if ($rowl['dap'] != "") {
                            $cnpj = aspa('PR_DAP_' . $rowl['dap']);
                        }
                        if ($rowl['nirf'] != "") {
                            $cnpj = aspa('PR_NIRF_' . $rowl['nirf']);
                        }
                    }
                    if ($rowl['idt_tipo_empreendimento'] == 3) { // Cooperativa - 5
                        $naturezaw = "CO";
                    }
                } else {
                    
                }
            } else {  // Atendimento a CPF
                $tipo_pessoaw = "F";
                $naturezaw = "PF";
            }

            $natureza = aspa($naturezaw);
            $tipo_pessoa = aspa($tipo_pessoaw);

            // PORTE DA EMPRESA
            $porte_metaw = "NA";
            if ($rowl['idt_porte'] == 5) { // MEI
                $porte_metaw = "MEI";
            }
            if ($rowl['idt_porte'] == 3) { // MICROEMPRESA
                $porte_metaw = "ME";
            }
            if ($rowl['idt_porte'] == 1) { // EMPRESA DE PEQUENO PORTE
                $porte_metaw = "EPP";
            }

            //
            $segmentacaow = "AC"; // A classificar

            if ($rowl['idt_segmentacao'] != "") {
                if ($idt_segmentacao == 3) { // Potencial Empreendedor
                    $segmentacaow = "PEE";
                } else {
                    $segmentacaow = "PE"; // Potencial empresário
                }
            } else {
                
            }

            if ($tipo_pessoaw == "F") {
                $porte_metaw = $segmentacaow;
            }

            $porte_meta = aspa($porte_metaw);
            $segmentacao = aspa($segmentacaow);
            // Classificar instrumentos
            // Intensidade - Nula, Baixa e Alta
            // Nula  = Não conta                  - Informação
            // Baixa = Conta apenas uma vez 	  - Palestras e Orientações Técnicas	
            // Alta  = Conta todas as vezes 	  - Demais.
            // cLASSIFICAR
            $instrumento_siglaw = "AC"; // a classificar
            //
            
	    if ($idt_instrumento > 0) {
                $sigla_instrumento = substr($sigla_instrumento, 0, 2);
                if ($sigla_instrumento == '') {
                    $instrumento_siglaw = "ER"; // erro
                } else {
                    $instrumento_siglaw = $sigla_instrumento;
                }
            }

            if ($instrumento_siglaw == 'CT') { // Consultoria Tecnológica
                $instrumento_siglaw = 'CO'; // considerar como CO
            }

            // Sigla
            $instrumento_sigla = aspa($instrumento_siglaw);

            // Intensidade
            $instrumento_intensidadew = "AL"; // ALTA

            if ($idt_instrumento == 8) { // Informação
                $instrumento_intensidadew = "NU"; // NULA
            } else {
                if (($idt_instrumento == 13) or ( $idt_instrumento == 47)) {  // Orientação Técnica e Palestra
                    $instrumento_intensidadew = "BX"; // BAIXA
                } else {
                    if (($idt_instrumento == 2) or ( $idt_instrumento == 50)  // CONSULTORIA (BALCÃO) E CONSULTORIA TECNICA
                            or ( $idt_instrumento == 40) or ( $idt_instrumento == 48)  // Curso E Rodadas
                            or ( $idt_instrumento == 41) or ( $idt_instrumento == 45)  // Feira E Missão e Caravana
                            or ( $idt_instrumento == 46) or ( $idt_instrumento == 49)  // Oficina e Seminário
                    ) {
                        $instrumento_intensidadew = "AL"; // ALTA
                    } else {
                        $instrumento_intensidadew = "NU"; // NULA
                    }
                }
            }

            // Intensidade
            $instrumento_intensidade = aspa($instrumento_intensidadew);
            //
            // $unidade_regional = aspa("");
            // $pa               = aspa("");
            // 
            // Gerar Indicadores Referentes a um único Atendimento
            //
            // Indicador 1
            // PF

            $logradouro_complemento = aspa($rowl['logradouro_complemento']);
            $telefone_residencial = aspa($rowl['telefone_residencial']);
            $telefone_celular = aspa($rowl['telefone_celular']);
            $telefone_recado = aspa($rowl['telefone_recado']);
            $idt_escolaridade = null($rowl['idt_escolaridade']);
            $potencial_personagem = aspa($rowl['potencial_personagem']);
            $necessidade_especial = aspa($rowl['necessidade_especial']);

            // PJ
            $simples_nacional = aspa($rowl['simples_nacional']);
            //
            $logradouro_complemento_e = aspa($rowl['logradouro_complemento_e']);
            //
            $telefone_comercial_e = aspa($rowl['telefone_comercial_e']);
            $telefone_celular_e = aspa($rowl['telefone_celular_e']);
            //
            $atividade_economica_secundaria = TrataAtvEconSec($idt_atendimento_organizacao);
            $atividade_economica_secundaria = aspa($atividade_economica_secundaria);

            //$vetC        = $rowl;
            //$indicador_1 = CalculaINDQUA1($vetC);
            //
            $vetC = Array();
            $vetC = $rowl;

            $indicadorpf = 0;
            $indicadorpj = 0;
            $indicador_1 = CalculaINDQUA1($vetC, $indicadorpf, $indicadorpj);

            // Indicador 2	
            $indicador_2 = CalculaINDQUA2($vetC);
            $vetRF = $vetC['RF'];

            // Tratar para gravação dados da receita federal
            $cnpj_crm = aspa($vetRF['cnpj_receita']);
            $cnpj_rf = aspa($vetRF['cnpj_RF']);
            $razao_social_crm = aspa($vetRF['razao_social_crm']);
            $razao_social_rf = aspa($vetRF['razao_social_RF']);
            $porte_crm = aspa($vetRF['descricao_porte']);
            $porte_rf = aspa($vetRF['porte_RF']);
            $data_abertura_crm = aspa($vetRF['data_abertura_t']);
            $data_abertura_rf = aspa($vetRF['data_abertura_RF']);
            $cnae_crm = aspa($vetRF['subclasse_t']);
            $cnae_rf = aspa($vetRF['cnae_atividade_principal_RF']);
            $amostra_2 = aspa($vetRF['amostra_2']);

            //
            // Indicador 3
            //
            // PF
            $data_nascimento = aspa($rowl['data_nascimento']);
            $logradouro_cep = aspa($rowl['logradouro_cep']);
            $logradouro_endereco = aspa($rowl['logradouro_endereco']);
            $logradouro_numero = aspa($rowl['logradouro_numero']);
            $logradouro_bairro = aspa($rowl['logradouro_bairro']);
            $logradouro_cidade = aspa($rowl['logradouro_cidade']);
            $logradouro_estado = aspa($rowl['logradouro_estado']);
            $logradouro_pais = aspa($rowl['logradouro_pais']);
            $email = aspa($rowl['email']);

            // PJ
            $data_abertura = aspa($rowl['data_abertura']);
            $email_e = aspa($rowl['email_e']);
            $logradouro_cep_e = aspa($rowl['logradouro_cep_e']);
            $logradouro_endereco_e = aspa($rowl['logradouro_endereco_e']);
            $logradouro_numero_e = aspa($rowl['logradouro_numero_e']);
            $logradouro_bairro_e = aspa($rowl['logradouro_bairro_e']);
            $logradouro_cidade_e = aspa($rowl['logradouro_cidade_e']);
            $logradouro_estado_e = aspa($rowl['logradouro_estado_e']);
            $logradouro_pais_e = aspa($rowl['logradouro_pais_e']);

            // Indicador 5
            $data_inf_atendimento = $rowl['data'];
            $data_inicio_atendimento = $rowl['data_inicio_atendimento'];
            $data_atendimento_aberto = $rowl['data_atendimento_aberto'];
            $horas_atendimento = $rowl['horas_atendimento'];
            $criterio1 = "TR";
            if (data_atendimento_aberto == "S") { // Se S foi aberto
                $criterio1 = "NTR";
            }

            $data_inf_atendimento = aspa($rowl['data']);
            $data_inicio_atendimento = aspa($rowl['data_inicio_atendimento']);
            $data_atendimento_aberta = aspa($rowl['data_atendimento_aberta']);
            $horas_atendimento = aspa($rowl['horas_atendimento']);
            $criterio1 = aspa($criterio1);
            $hora_inicio_atendimento = aspa($rowl['hora_inicio_atendimento']);
            $hora_termino_atendimento = aspa($rowl['hora_termino_atendimento']);

            //
            $sql_i = " insert into {$tabela_ref} ";
            $sql_i .= ' (  ';
            $sql_i .= " data_base, ";
            $sql_i .= " idt_atendimento, ";
            $sql_i .= " idt_consultor, ";
            $sql_i .= " nome_consultor, ";
            $sql_i .= " idt_evento, ";
            $sql_i .= " idt_foco_tematico, ";
            $sql_i .= " idt_segmentacao, ";
            $sql_i .= " data_atendimento, ";
            $sql_i .= " demanda, ";
            $sql_i .= " demanda_md5, ";
            $sql_i .= " horas_evento, ";
            $sql_i .= " idt_ponto_atendimento, ";
            $sql_i .= " unidade_regional, ";
            $sql_i .= " pa, ";
            $sql_i .= " idt_instrumento, ";
            $sql_i .= " cpf, ";
            $sql_i .= " cnpj, ";
            $sql_i .= " status_1, ";
            $sql_i .= " status_2, ";
            $sql_i .= " idt_porte, ";
            $sql_i .= " idt_tipo_empreendimento, ";
            $sql_i .= " razao_social, ";
            $sql_i .= " nome, ";
            $sql_i .= " porte, ";
            $sql_i .= " tipo_empreendimento, ";
            $sql_i .= " instrumento, ";
            $sql_i .= " ponto_atendimento, ";
            $sql_i .= " evento_concluido, ";
            $sql_i .= " evento_contrato, ";
            $sql_i .= " evento, ";
            $sql_i .= " protocolo, ";
            $sql_i .= " inovacao, ";
            $sql_i .= " tipo_pessoa, ";
            $sql_i .= " natureza, ";
            $sql_i .= " porte_meta, ";
            $sql_i .= " segmentacao, ";
            $sql_i .= " instrumento_sigla, ";
            $sql_i .= " instrumento_intensidade, ";
            $sql_i .= " dt_previsao_fim, ";
            $sql_i .= " dt_previsao_inicial, ";
            $sql_i .= " hora_inicio_atendimento, ";
            $sql_i .= " hora_termino_atendimento, ";

            // PF
            $sql_i .= " logradouro_complemento, ";
            $sql_i .= " telefone_residencial, ";
            $sql_i .= " telefone_celular, ";
            $sql_i .= " telefone_recado, ";
            $sql_i .= " idt_escolaridade, ";
            $sql_i .= " potencial_personagem, ";
            $sql_i .= " necessidade_especial, ";
            $sql_i .= " indicadorpf, ";

            // PJ
            $sql_i .= " simples_nacional, ";
            $sql_i .= " logradouro_complemento_e, ";
            $sql_i .= " telefone_comercial_e, ";
            $sql_i .= " telefone_celular_e, ";
            $sql_i .= " atividade_economica_secundaria, ";
            $sql_i .= " indicadorpj, ";

            // Datas
            $sql_i .= " data_inf_atendimento, ";
            $sql_i .= " data_inicio_atendimento, ";
            $sql_i .= " data_atendimento_aberta, ";
            $sql_i .= " horas_atendimento, ";
            $sql_i .= " criterio1, ";

            // Endereços - indicador 3
            // PF
            $sql_i .= " email, ";
            $sql_i .= " data_nascimento, ";
            $sql_i .= " logradouro_cep, ";
            $sql_i .= " logradouro_endereco, ";
            $sql_i .= " logradouro_numero, ";
            $sql_i .= " logradouro_bairro, ";
            $sql_i .= " logradouro_cidade, ";
            $sql_i .= " logradouro_estado, ";
            $sql_i .= " logradouro_pais, ";

            // PJ
            $sql_i .= " email_e, ";
            $sql_i .= " data_abertura, ";
            $sql_i .= " logradouro_cep_e, ";
            $sql_i .= " logradouro_endereco_e, ";
            $sql_i .= " logradouro_numero_e, ";
            $sql_i .= " logradouro_bairro_e, ";
            $sql_i .= " logradouro_cidade_e, ";
            $sql_i .= " logradouro_estado_e, ";
            $sql_i .= " logradouro_pais_e, ";

            $sql_i .= " indicador_1, ";
            $sql_i .= " indicador_2, ";

            // Dados comparação receita federal
            $sql_i .= " cnpj_crm, ";
            $sql_i .= " cnpj_rf, ";
            $sql_i .= " razao_social_crm, ";
            $sql_i .= " razao_social_rf, ";
            $sql_i .= " porte_crm, ";
            $sql_i .= " porte_rf, ";
            $sql_i .= " descricao_rf, ";
            $sql_i .= " data_abertura_crm, ";
            $sql_i .= " data_abertura_rf, ";
            $sql_i .= " cnae_crm, ";
            $sql_i .= " cnae_rf, ";
            $sql_i .= " amostra_2, ";
            $sql_i .= " origem ";
            $sql_i .= "  ) values ( ";
            $sql_i .= " $data_basew, ";
            $sql_i .= " $idt_atendimento, ";
            $sql_i .= " $idt_consultor, ";
            $sql_i .= " $nome_consultor, ";
            $sql_i .= " $idt_evento, ";
            $sql_i .= " $idt_foco_tematico, ";
            $sql_i .= " $idt_segmentacao, ";
            $sql_i .= " $data_atendimento, ";
            $sql_i .= " $demanda, ";
            $sql_i .= " $demanda_md5, ";
            $sql_i .= " $horas_evento, ";
            $sql_i .= " $idt_ponto_atendimento, ";
            $sql_i .= " $unidade_regional, ";
            $sql_i .= " $pa, ";
            $sql_i .= " $idt_instrumento, ";
            $sql_i .= " $cpf, ";
            $sql_i .= " $cnpj, ";
            $sql_i .= " $status_1, ";
            $sql_i .= " $status_2, ";
            $sql_i .= " $idt_porte, ";
            $sql_i .= " $idt_tipo_empreendimento, ";
            $sql_i .= " $razao_social, ";
            $sql_i .= " $nome, ";
            $sql_i .= " $porte, ";
            $sql_i .= " $tipo_empreendimento, ";
            $sql_i .= " $instrumento, ";
            $sql_i .= " $ponto_atendimento, ";
            $sql_i .= " $evento_concluido, ";
            $sql_i .= " $evento_contrato, ";
            $sql_i .= " $evento, ";
            $sql_i .= " $protocolo, ";
            $sql_i .= " $inovacao, ";
            $sql_i .= " $tipo_pessoa, ";
            $sql_i .= " $natureza, ";
            $sql_i .= " $porte_meta, ";
            $sql_i .= " $segmentacao, ";
            $sql_i .= " $instrumento_sigla, ";
            $sql_i .= " $instrumento_intensidade, ";
            $sql_i .= " $dt_previsao_fim, ";
            $sql_i .= " $dt_previsao_inicial, ";
            $sql_i .= " $hora_inicio_atendimento, ";
            $sql_i .= " $hora_termino_atendimento, ";

            // PF
            $sql_i .= " $logradouro_complemento, ";
            $sql_i .= " $telefone_residencial, ";
            $sql_i .= " $telefone_celular, ";
            $sql_i .= " $telefone_recado, ";
            $sql_i .= " $idt_escolaridade, ";
            $sql_i .= " $potencial_personagem, ";
            $sql_i .= " $necessidade_especial, ";
            $sql_i .= " $indicadorpf, ";

            // PJ
            $sql_i .= " $simples_nacional, ";
            $sql_i .= " $logradouro_complemento_e, ";
            $sql_i .= " $telefone_comercial_e, ";
            $sql_i .= " $telefone_celular_e, ";
            $sql_i .= " $atividade_economica_secundaria, ";
            $sql_i .= " $indicadorpj, ";

            // Datas
            $sql_i .= " $data_inf_atendimento, ";
            $sql_i .= " $data_inicio_atendimento, ";
            $sql_i .= " $data_atendimento_aberta, ";
            $sql_i .= " $horas_atendimento, ";
            $sql_i .= " $criterio1, ";

            // Endereços - indicador 3
            // PF
            $sql_i .= " $email, ";
            $sql_i .= " $data_nascimento, ";
            $sql_i .= " $logradouro_cep, ";
            $sql_i .= " $logradouro_endereco, ";
            $sql_i .= " $logradouro_numero, ";
            $sql_i .= " $logradouro_bairro, ";
            $sql_i .= " $logradouro_cidade, ";
            $sql_i .= " $logradouro_estado, ";
            $sql_i .= " $logradouro_pais, ";

            // PJ
            $sql_i .= " $email_e, ";
            $sql_i .= " $data_abertura, ";
            $sql_i .= " $logradouro_cep_e, ";
            $sql_i .= " $logradouro_endereco_e, ";
            $sql_i .= " $logradouro_numero_e, ";
            $sql_i .= " $logradouro_bairro_e, ";
            $sql_i .= " $logradouro_cidade_e, ";
            $sql_i .= " $logradouro_estado_e, ";
            $sql_i .= " $logradouro_pais_e, ";
            //			
            $sql_i .= " $indicador_1, ";
            $sql_i .= " $indicador_2, ";

            // Dados comparação receita federal
            $sql_i .= " $cnpj_crm, ";
            $sql_i .= " $cnpj_rf, ";
            $sql_i .= " $razao_social_crm, ";
            $sql_i .= " $razao_social_rf, ";
            $sql_i .= " $porte_crm, ";
            $sql_i .= " $porte_rf, ";
            $sql_i .= " $descricao_rf, ";
            $sql_i .= " $data_abertura_crm, ";
            $sql_i .= " $data_abertura_rf, ";
            $sql_i .= " $cnae_crm, ";
            $sql_i .= " $cnae_rf, ";
            $sql_i .= " $amostra_2, ";
            $sql_i .= " $origem ";
            $sql_i .= ') ';
            execsql($sql_i);
        }
    }

    foreach ($vetPA as $idt_pa => $nome_pa) {
        $nome_ur = $vetURPA[$idt_pa];
        $idt_ponto_atendimento = $idt_pa;
        $unidade_regional = aspa($nome_ur);
        $ponto_atendimento = aspa($nome_pa);

        $sql_i = " insert into {$tabela_ref_iq} ";
        $sql_i .= ' (  ';
        $sql_i .= " idt_ponto_atendimento, ";
        $sql_i .= " unidade_regional, ";
        $sql_i .= " ponto_atendimento ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_ponto_atendimento, ";
        $sql_i .= " $unidade_regional, ";
        $sql_i .= " $ponto_atendimento ";
        $sql_i .= ') ';
        execsql($sql_i);
    }

    // ações sobre o DW
    GravaBaseIndicador3();
    GravaBaseIndicador5();

    //
    // Geração dos Cubos 
    //
    //GerarCubos();
    //commit(); 
    set_time_limit(30);
}

function GravaBaseIndicador3() {
    //
    // Gravar dados
    //
    // PF

    $ano_base = 2017;

    $vetLimite = Array();

    $vetLimite['pf']["endereco_pf"] = 5;
    $vetLimite['pf']["data_nascimento"] = 100;
    $vetLimite['pf']["telefone_residencial"] = 5;
    $vetLimite['pf']["telefone_celular"] = 5;
    $vetLimite['pf']["telefone_recado"] = 5;
    $vetLimite['pf']["email"] = 2;

    // PJ
    $vetLimite['pj']["endereco_pj"] = 5;
    $vetLimite['pj']["data_abertura"] = 100;
    $vetLimite['pj']["telefone_comercial_e"] = 5;
    $vetLimite['pj']["telefone_celular_e"] = 5;
    $vetLimite['pj']["email_e"] = 2;

    // $vetLimite -> esta em definição de vetores genérico // deu problema não esta no genérico conteudo...
    foreach ($vetLimite['pf'] as $cpo_ref => $limite) {
        if ($cpo_ref != "endereco_pf") {
            GravaMatrizCampos('pf', $cpo_ref, $limite);
        }
    }

    foreach ($vetLimite['pj'] as $cpo_ref => $limite) {
        if ($cpo_ref != "endereco_pj") {
            GravaMatrizCampos('pj', $cpo_ref, $limite);
        }
    }

    /*
      // Telefone Residencial
      $cpo_ref = "data_nascimento";
      $limite  = $vetLimite[$cpo_ref];
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "telefone_residencial";
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "telefone_celular";
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "telefone_recado";
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "email";
      GravaMatrizCampos($cpo_ref,$limite);
      //
      $cpo_ref = "data_abertura";
      GravaMatrizCampos($cpo_ref,$limite);

      $cpo_ref = "telefone_comercial_e";
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "telefone_celular_e";
      GravaMatrizCampos($cpo_ref,$limite);
      $cpo_ref = "email_e";
      GravaMatrizCampos($cpo_ref,$limite);
     */

    // Enderco PF
    $grupo = "";
    $grupo .= " logradouro_cep, ";
    $grupo .= " logradouro_endereco, ";
    $grupo .= " logradouro_numero, ";
    $grupo .= " logradouro_complemento, ";
    $grupo .= " logradouro_bairro, ";
    $grupo .= " logradouro_cidade, ";
    $grupo .= " logradouro_estado, ";
    $grupo .= " logradouro_pais   ";

    $sql = "Select  ";
    $sql .= " idt_ponto_atendimento, {$grupo}, count(distinct cpf)  as qtd ";
    $sql .= " from    grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $sql .= ' where coalesce(logradouro_cep, logradouro_endereco, logradouro_numero, logradouro_complemento, logradouro_bairro, logradouro_cidade, logradouro_estado, logradouro_pais) is not null';
    $sql .= " group by idt_ponto_atendimento, {$grupo} ";
    $sql .= " having qtd > {$limite}";
    $rsl = execsql($sql);
    $tabela_ref = "grc_dw_{$ano_base}_matriz_campos";

    $cpo_ref = "endereco_pf";
    $limite = $vetLimite['pf'][$cpo_ref];

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
        $logradouro_cep = $rowl['logradouro_cep'];
        $logradouro_endereco = $rowl['logradouro_endereco'];
        $logradouro_numero = $rowl['logradouro_numero'];
        $logradouro_complemento = $rowl['logradouro_complemento'];
        $logradouro_bairro = $rowl['logradouro_bairro'];
        $logradouro_cidade = $rowl['logradouro_cidade'];
        $logradouro_estado = $rowl['logradouro_estado'];
        $logradouro_pais = $rowl['logradouro_pais'];
        $end = $logradouro_cep . " - " . $logradouro_endereco . ', ' . $logradouro_numero . ', ' . $logradouro_complemento . ', ';
        $end .= $logradouro_bairro . " - " . $logradouro_cidade . ', ' . $logradouro_estado . ', ' . $logradouro_pais;
        $valor = aspa($end);
        $quantidade = $rowl['qtd'];
        $campo = aspa($cpo_ref);
        $inconsistente = "N";

        if ($quantidade > $limite) {
            $inconsistente = "S";
        }
        $inconsistente = aspa($inconsistente);

        $sql_i = " insert into {$tabela_ref} ";
        $sql_i .= ' (  ';
        $sql_i .= " idt_ponto_atendimento, ";
        $sql_i .= " campo, ";
        $sql_i .= " valor, ";
        $sql_i .= " quantidade, ";
        $sql_i .= " inconsistente ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_ponto_atendimento, ";
        $sql_i .= " $campo, ";
        $sql_i .= " $valor, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $inconsistente ";
        $sql_i .= ') ';
        execsql($sql_i);
        $idt_dw_matriz_campos = lastInsertId();

        $sql_iq = '';
        $sql_iq .= " where idt_ponto_atendimento = $idt_ponto_atendimento";

        if ($logradouro_cep == '') {
            $sql_iq .= " and logradouro_cep is null";
        } else {
            $sql_iq .= " and logradouro_cep = " . aspa($logradouro_cep);
        }

        if ($logradouro_endereco == '') {
            $sql_iq .= " and logradouro_endereco is null";
        } else {
            $sql_iq .= " and logradouro_endereco = " . aspa($logradouro_endereco);
        }

        if ($logradouro_numero == '') {
            $sql_iq .= " and logradouro_numero is null";
        } else {
            $sql_iq .= " and logradouro_numero = " . aspa($logradouro_numero);
        }

        if ($logradouro_complemento == '') {
            $sql_iq .= " and logradouro_complemento is null";
        } else {
            $sql_iq .= " and logradouro_complemento = " . aspa($logradouro_complemento);
        }

        if ($logradouro_bairro == '') {
            $sql_iq .= " and logradouro_bairro is null";
        } else {
            $sql_iq .= " and logradouro_bairro = " . aspa($logradouro_bairro);
        }

        if ($logradouro_cidade == '') {
            $sql_iq .= " and logradouro_cidade is null";
        } else {
            $sql_iq .= " and logradouro_cidade = " . aspa($logradouro_cidade);
        }

        if ($logradouro_estado == '') {
            $sql_iq .= " and logradouro_estado is null";
        } else {
            $sql_iq .= " and logradouro_estado = " . aspa($logradouro_estado);
        }

        if ($logradouro_pais == '') {
            $sql_iq .= " and logradouro_pais is null";
        } else {
            $sql_iq .= " and logradouro_pais = " . aspa($logradouro_pais);
        }

        $sql = "insert into grc_dw_{$ano_base}_matriz_campos_iq_3 (idt_dw_matriz_campos, idt_dw_indicadores_qualidade)";
        $sql .= ' select ' . $idt_dw_matriz_campos . ' as idt_dw_matriz_campos, idt as idt_dw_indicadores_qualidade';
        $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade";
        $sql .= $sql_iq;
        execsql($sql);

        // Update na detalhada
        if ($inconsistente == "'S'") {
            $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_3_inconsistente = {$inconsistente}";
            $sql .= $sql_iq;
            execsql($sql);
        }
    }

    // Enderco PJ
    $grupo = "";
    $grupo .= " logradouro_cep_e, ";
    $grupo .= " logradouro_endereco_e, ";
    $grupo .= " logradouro_numero_e, ";
    $grupo .= " logradouro_complemento_e, ";
    $grupo .= " logradouro_bairro_e, ";
    $grupo .= " logradouro_cidade_e, ";
    $grupo .= " logradouro_estado_e, ";
    $grupo .= " logradouro_pais_e   ";

    $sql = "Select  ";
    $sql .= " idt_ponto_atendimento, {$grupo}, count(distinct cnpj)  as qtd ";
    $sql .= " from    grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $sql .= ' where cnpj is not null';
    $sql .= ' and coalesce(logradouro_cep_e, logradouro_endereco_e, logradouro_numero_e, logradouro_complemento_e, logradouro_bairro_e, logradouro_cidade_e, logradouro_estado_e, logradouro_pais_e) is not null';
    $sql .= " group by idt_ponto_atendimento, {$grupo} ";
    $sql .= " having qtd > {$limite}";
    $rsl = execsql($sql);
    $tabela_ref = "grc_dw_{$ano_base}_matriz_campos";

    $cpo_ref = "endereco_pj";
    $limite = $vetLimite['pj'][$cpo_ref];

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
        $logradouro_cep = $rowl['logradouro_cep_e'];
        $logradouro_endereco = $rowl['logradouro_endereco_e'];
        $logradouro_numero = $rowl['logradouro_numero_e'];
        $logradouro_complemento = $rowl['logradouro_complemento_e'];
        $logradouro_bairro = $rowl['logradouro_bairro_e'];
        $logradouro_cidade = $rowl['logradouro_cidade_e'];
        $logradouro_estado = $rowl['logradouro_estado_e'];
        $logradouro_pais = $rowl['logradouro_pais_e'];
        $end = $logradouro_cep . " - " . $logradouro_endereco . ', ' . $logradouro_numero . ', ' . $logradouro_complemento . ', ';
        $end .= $logradouro_bairro . " - " . $logradouro_cidade . ', ' . $logradouro_estado . ', ' . $logradouro_pais;
        $valor = aspa($end);
        $quantidade = $rowl['qtd'];
        $campo = aspa($cpo_ref);
        $inconsistente = "N";
        if ($quantidade > $limite) {
            $inconsistente = "S";
        }
        $inconsistente = aspa($inconsistente);

        $sql_i = " insert into {$tabela_ref} ";
        $sql_i .= ' (  ';
        $sql_i .= " idt_ponto_atendimento, ";
        $sql_i .= " campo, ";
        $sql_i .= " valor, ";
        $sql_i .= " quantidade, ";
        $sql_i .= " inconsistente ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_ponto_atendimento, ";
        $sql_i .= " $campo, ";
        $sql_i .= " $valor, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $inconsistente ";
        $sql_i .= ') ';
        execsql($sql_i);
        $idt_dw_matriz_campos = lastInsertId();

        $sql_iq = '';
        $sql_iq .= " where idt_ponto_atendimento = {$idt_ponto_atendimento}";

        if ($logradouro_cep == '') {
            $sql_iq .= " and logradouro_cep_e is null";
        } else {
            $sql_iq .= " and logradouro_cep_e = " . aspa($logradouro_cep);
        }

        if ($logradouro_endereco == '') {
            $sql_iq .= " and logradouro_endereco_e is null";
        } else {
            $sql_iq .= " and logradouro_endereco_e = " . aspa($logradouro_endereco);
        }

        if ($logradouro_numero == '') {
            $sql_iq .= " and logradouro_numero_e is null";
        } else {
            $sql_iq .= " and logradouro_numero_e = " . aspa($logradouro_numero);
        }

        if ($logradouro_complemento == '') {
            $sql_iq .= " and logradouro_complemento_e is null";
        } else {
            $sql_iq .= " and logradouro_complemento_e = " . aspa($logradouro_complemento);
        }

        if ($logradouro_bairro == '') {
            $sql_iq .= " and logradouro_bairro_e is null";
        } else {
            $sql_iq .= " and logradouro_bairro_e = " . aspa($logradouro_bairro);
        }

        if ($logradouro_cidade == '') {
            $sql_iq .= " and logradouro_cidade_e is null";
        } else {
            $sql_iq .= " and logradouro_cidade_e = " . aspa($logradouro_cidade);
        }

        if ($logradouro_estado == '') {
            $sql_iq .= " and logradouro_estado_e is null";
        } else {
            $sql_iq .= " and logradouro_estado_e = " . aspa($logradouro_estado);
        }

        if ($logradouro_pais == '') {
            $sql_iq .= " and logradouro_pais_e is null";
        } else {
            $sql_iq .= " and logradouro_pais_e = " . aspa($logradouro_pais);
        }

        $sql = "insert into grc_dw_{$ano_base}_matriz_campos_iq_3 (idt_dw_matriz_campos, idt_dw_indicadores_qualidade)";
        $sql .= ' select ' . $idt_dw_matriz_campos . ' as idt_dw_matriz_campos, idt as idt_dw_indicadores_qualidade';
        $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade";
        $sql .= $sql_iq;
        execsql($sql);

        // Update na detalhada
        if ($inconsistente == "'S'") {
            $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_3_inconsistente = {$inconsistente}";
            $sql .= $sql_iq;
            execsql($sql);
        }
    }

    /*
      // Telefone Residencial
      $sql  = "Select  ";
      $sql .= " idt_ponto_atendimento, telefone_residencial, count(idt_ponto_atendimento)  as qtd ";
      $sql .= " from    grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
      $sql .= " group by idt_ponto_atendimento, telefone_residencial ";
      $sql .= " order by idt_ponto_atendimento, qtd ";
      $tabela_ref = "grc_dw_{$ano_base}_matriz_campos";
      ForEach ($rsl->data as $rowl) {
      $idt_ponto_atendimento     = $rowl['idt_ponto_atendimento'];
      $valor                     = aspa($rowl['telefone_residencial']);
      $qtd                       = $rowl['qtd'];
      $campo                     = aspa("telefone_residencial");
      $sql_i = " insert into {$tabela_ref} ";
      $sql_i .= ' (  ';
      $sql_i .= " campo, ";
      $sql_i .= " valor, ";
      $sql_i .= " quantidade ";
      $sql_i .= "  ) values ( ";
      $sql_i .= " $campo, ";
      $sql_i .= " $valor, ";
      $sql_i .= " $quantidade ";
      $sql_i .= ') ';
      execsql($sql_i);
      }
     */
}

function GravaBaseIndicador5() {
    $ano_base = 2017;

    //horas_atendimento
    $grupo = "";
    $grupo .= " data_atendimento_aberta, ";
    $grupo .= " horas_atendimento ";

    $sql = "Select  ";
    $sql .= " idt_ponto_atendimento, {$grupo}, count(distinct idt_atendimento) as qtd ";
    $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $sql .= " where data_atendimento_aberta = 'S'";
    $sql .= " group by idt_ponto_atendimento, {$grupo} ";
    $sql .= " having qtd > 21";
    $rsl = execsql($sql);

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
        $data_atendimento_aberta = $rowl['data_atendimento_aberta'];
        $horas_atendimento = $rowl['horas_atendimento'];
        $quantidade = $rowl['qtd'];

        $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_5_hora = 'S'";
        $sql .= " where idt_ponto_atendimento = {$idt_ponto_atendimento}";

        if ($data_atendimento_aberta == '') {
            $sql .= " and data_atendimento_aberta is null";
        } else {
            $sql .= " and data_atendimento_aberta = " . aspa($data_atendimento_aberta);
        }

        if ($horas_atendimento == '') {
            $sql .= " and horas_atendimento is null";
        } else {
            $sql .= " and horas_atendimento = " . null($horas_atendimento);
        }

        execsql($sql);
    }

    //demanda
    $grupo = "";
    $grupo .= " data_atendimento_aberta, ";
    $grupo .= " demanda_md5 ";

    $sql = "Select  ";
    $sql .= " idt_ponto_atendimento, {$grupo}, count(distinct idt_atendimento) as qtd ";
    $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $sql .= " where data_atendimento_aberta = 'S'";
    $sql .= " group by idt_ponto_atendimento, {$grupo} ";
    $sql .= " having qtd >= 2";
    $rsl = execsql($sql);

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
        $data_atendimento_aberta = $rowl['data_atendimento_aberta'];
        $demanda = $rowl['demanda_md5'];
        $quantidade = $rowl['qtd'];

        $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_5_demanda = 'S'";
        $sql .= " where idt_ponto_atendimento = {$idt_ponto_atendimento}";

        if ($data_atendimento_aberta == '') {
            $sql .= " and data_atendimento_aberta is null";
        } else {
            $sql .= " and data_atendimento_aberta = " . aspa($data_atendimento_aberta);
        }

        if ($demanda == '') {
            $sql .= " and demanda_md5 is null";
        } else {
            $sql .= " and demanda_md5 = " . aspa($demanda);
        }

        execsql($sql);
    }

    $sql = "Select distinct ";
    $sql .= " idt_ponto_atendimento ";
    $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $rsl = execsql($sql);

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);

        $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_5_inconsistente = 'S'";
        $sql .= " where idt_ponto_atendimento = {$idt_ponto_atendimento}";
        $sql .= " and data_atendimento_aberta = 'S'";
        $sql .= " and indicador_5_hora = 'S'";
        $sql .= " and indicador_5_demanda = 'S'";
        execsql($sql);
    }
}

function GravaMatrizCampos($tipo_cadastro, $cpo_ref, $limite) {
    $ano_base = 2017;

    if ($tipo_cadastro == 'pf') {
        $campo_cad = 'cpf';
    } else {
        $campo_cad = 'cnpj';
    }

    $sql = "Select  ";
    $sql .= " idt_ponto_atendimento, {$cpo_ref}, count(distinct {$campo_cad}) as qtd ";
    $sql .= " from    grc_dw_{$ano_base}_indicadores_qualidade grc_dwiq ";
    $sql .= " where {$cpo_ref} is not null";
    $sql .= " group by idt_ponto_atendimento, {$cpo_ref} ";
    $sql .= " having qtd > {$limite}";
    $rsl = execsql($sql);

    $tabela_ref = "grc_dw_{$ano_base}_matriz_campos";
    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = null($rowl['idt_ponto_atendimento']);
        $valor = aspa($rowl[$cpo_ref]);
        $quantidade = null($rowl['qtd']);
        $campo = aspa($cpo_ref);
        $inconsistente = "N";

        if ($quantidade > $limite) {
            $inconsistente = "S";
        }
        $inconsistente = aspa($inconsistente);
        $sql_i = " insert into {$tabela_ref} ";
        $sql_i .= ' (  ';
        $sql_i .= " idt_ponto_atendimento, ";
        $sql_i .= " campo, ";
        $sql_i .= " valor, ";
        $sql_i .= " quantidade, ";
        $sql_i .= " inconsistente ";
        $sql_i .= "  ) values ( ";
        $sql_i .= " $idt_ponto_atendimento, ";
        $sql_i .= " $campo, ";
        $sql_i .= " $valor, ";
        $sql_i .= " $quantidade, ";
        $sql_i .= " $inconsistente ";
        $sql_i .= ') ';
        execsql($sql_i);
        $idt_dw_matriz_campos = lastInsertId();

        $sql_iq = '';
        $sql_iq .= " where idt_ponto_atendimento = {$idt_ponto_atendimento}";

        if ($rowl[$cpo_ref] == '') {
            $sql_iq .= " and {$cpo_ref} is null";
        } else {
            $sql_iq .= " and {$cpo_ref} = {$valor}";
        }

        $sql = "insert into grc_dw_{$ano_base}_matriz_campos_iq_3 (idt_dw_matriz_campos, idt_dw_indicadores_qualidade)";
        $sql .= ' select ' . $idt_dw_matriz_campos . ' as idt_dw_matriz_campos, idt as idt_dw_indicadores_qualidade';
        $sql .= " from grc_dw_{$ano_base}_indicadores_qualidade";
        $sql .= $sql_iq;
        execsql($sql);

        // Update na detalhada
        if ($inconsistente == "'S'") {
            $sql = "update grc_dw_{$ano_base}_indicadores_qualidade set indicador_3_inconsistente = {$inconsistente}";
            $sql .= $sql_iq;
            execsql($sql);
        }
    }
}

function TiraAcento($string) {

    $string_n = "";

    // $string = 'ÁÍÓÚÉÄÏÖÜËÀÌÒÙÈÃÕÂÎÔÛÊáíóúéäïöüëàìòùèãõâîôûêÇç';
    //
   //$string_n = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $string ) );

    if ($string_n == '') {
        //  $string_n=$string; 
    }
    //

    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    // $string = preg_replace("/ /", "_", $string);
    return $string;

    //return $string_n;
}

function TrataAtvEconSec($idt_atendimento_organizacao) {
    $preenchida = "N";

    $TabelaPrinc = "grc_atendimento_organizacao_cnae";
    $AliasPric = "grc_aoc";

    $sql = "select {$AliasPric}.idt , cnae.subclasse ";
    $sql .= " from {$TabelaPrinc} {$AliasPric}  ";
    $sql .= " left outer join " . db_pir_gec . "cnae on  cnae.subclasse = {$AliasPric}.cnae";
    $sql .= " where {$AliasPric}" . '.idt_atendimento_organizacao = ' . null($idt_atendimento_organizacao);
    $sql .= " and principal = 'N'";
    $rsl = execsql($sql);
    if ($rsl > 0) {
        $preenchida = "S";
    }
    return $preenchida;
}

function GeraDWIQ() {
    $ano_base = '2017';

    $indicador_1 = 0;
    $indicador_2 = 0;
    $indicador_3 = 0;
    $indicador_4 = 0;
    $indicador_5 = 0;

    set_time_limit(0);
    $tabela_ref = " grc_dw_{$ano_base}_indicadores_qualidade ";
    $tabela_ref_iq = " grc_dw_{$ano_base}_iq ";

    // Indicador 1
    $sql = "select ";
    $sql .= " idt, idt_ponto_atendimento, indicador_1, indicador_2, indicador_3_inconsistente, indicador_5_inconsistente, amostra_2";
    $sql .= " from {$tabela_ref} ";
    $rsl = execsql($sql, true, null, array(), PDO::FETCH_ASSOC);
    //
    $vetPAIQ1T = Array();
    $vetPAIQ1Q = Array();
    $vetPAIQ2T = Array();
    $vetPAIQ2Q = Array();
    $vetPAIQ3T = Array();
    $vetPAIQ3Q = Array();
    $vetPAIQ5T = Array();
    $vetPAIQ5Q = Array();

    ForEach ($rsl->data as $rowl) {
        $idt_ponto_atendimento = $rowl['idt_ponto_atendimento'];
        $indicador_1 = $rowl['indicador_1'];
        $indicador_2 = $rowl['indicador_2'];
        $amostra_2 = $rowl['amostra_2'];
        $indicador_3_inconsistente = $rowl['indicador_3_inconsistente'];
        $indicador_5_inconsistente = $rowl['indicador_5_inconsistente'];

        $vetPAIQ1T[$idt_ponto_atendimento] = $vetPAIQ1T[$idt_ponto_atendimento] + $indicador_1;
        $vetPAIQ1Q[$idt_ponto_atendimento] = $vetPAIQ1Q[$idt_ponto_atendimento] + 1;

        if ($amostra_2 != 'S') {
            $vetPAIQ2T[$idt_ponto_atendimento] = $vetPAIQ2T[$idt_ponto_atendimento] + $indicador_2;
            $vetPAIQ2Q[$idt_ponto_atendimento] = $vetPAIQ2Q[$idt_ponto_atendimento] + 1;
        }

        $vetPAIQ3T[$idt_ponto_atendimento] = $vetPAIQ3T[$idt_ponto_atendimento] + 1;

        if ($indicador_3_inconsistente == 'N') {
            $vetPAIQ3Q[$idt_ponto_atendimento] = $vetPAIQ3Q[$idt_ponto_atendimento] + 1;
        }

        $vetPAIQ5T[$idt_ponto_atendimento] = $vetPAIQ5T[$idt_ponto_atendimento] + 1;

        if ($indicador_5_inconsistente == 'N') {
            $vetPAIQ5Q[$idt_ponto_atendimento] = $vetPAIQ5Q[$idt_ponto_atendimento] + 1;
        }
    }
    $quantidade_total = 0;
    $quantidade_total2 = 0;

    foreach ($vetPAIQ1T as $idt_pa => $total) {
        $quantidade = $vetPAIQ1Q[$idt_pa];
        $quantidade_total = $quantidade_total + $quantidade;

        $indicador_1 = 0;
        if ($quantidade > 0) {
            $indicador_1 = $total / $quantidade;
        }
        /*
          $quantidade2       = $vetPAIQ2Q[$idt_pa];
          $quantidade_total2 = $quantidade_total2 + $quantidade2;

          $indicador_2     = 0;
          if ($quantidade2 > 0) {
          $indicador_2 = $total / $quantidade2;
          }

         */

        $sql_a = " update {$tabela_ref_iq} set ";
        $sql_a .= " quantidade_atendimentos     = " . $quantidade . ",   ";
        $sql_a .= " indicador_1     = " . $indicador_1 . "   ";
        $sql_a .= " where idt_Ponto_atendimento       = " . null($idt_pa);
        execsql($sql_a);
    }

    $quantidade_total = 0;
    foreach ($vetPAIQ2T as $idt_pa => $total) {
        $quantidade = $vetPAIQ2Q[$idt_pa];
        $quantidade_total = $quantidade_total + $quantidade;

        $indicador_2 = 0;
        if ($quantidade > 0) {
            $indicador_2 = $total / $quantidade;
        }

        $sql_a = " update {$tabela_ref_iq} set ";
        $sql_a .= " quantidade_atendimentos     = " . $quantidade . ",   ";
        $sql_a .= " indicador_2     = " . $indicador_2 . "   ";
        $sql_a .= " where idt_ponto_atendimento       = " . null($idt_pa);
        execsql($sql_a);
    }

    $quantidade_total = 0;
    foreach ($vetPAIQ3T as $idt_pa => $total) {
        $quantidade = Troca($vetPAIQ3Q[$idt_pa], '', 0);
        $quantidade_total = $quantidade_total + $quantidade;

        $indicador_3 = 0;
        if ($quantidade > 0) {
            $$indicador_3 = $quantidade * 100 / $total;
        }

        $sql_a = " update {$tabela_ref_iq} set ";
        //$sql_a .= " quantidade_atendimentos     = ".$quantidade.",   ";
        $sql_a .= " indicador_3     = " . $$indicador_3 . "   ";
        $sql_a .= " where idt_ponto_atendimento       = " . null($idt_pa);
        execsql($sql_a);
    }

    $quantidade_total = 0;
    foreach ($vetPAIQ5T as $idt_pa => $total) {
        $quantidade = Troca($vetPAIQ5Q[$idt_pa], '', 0);
        $quantidade_total = $quantidade_total + $quantidade;

        $indicador_5 = 0;
        if ($quantidade > 0) {
            $indicador_5 = $quantidade * 100 / $total;
        }

        $sql_a = " update {$tabela_ref_iq} set ";
        //$sql_a .= " quantidade_atendimentos     = ".$quantidade.",   ";
        $sql_a .= " indicador_5     = " . $indicador_5 . "   ";
        $sql_a .= " where idt_ponto_atendimento       = " . null($idt_pa);
        execsql($sql_a);
    }

    //
    // Geral
    //
	//$indicador_g = ($indicador_1 + $indicador_2 + $indicador_3 + $indicador_4 + $indicador_5) / 5;
    $indicador_4 = 0;
    $indicador_g = ($indicador_1 + $indicador_2 + $indicador_3 + $indicador_4 + $indicador_5) / 4;

    $sql_a = " update {$tabela_ref_iq} set ";
    $sql_a .= " quantidade_atendimentos     = " . ($quantidade_total) . ",   ";
    $sql_a .= " indicador_g     = " . ($indicador_g) . "    ";
    $sql_a .= " where idt_ponto_atendimento       = " . null($idt_pa);
    execsql($sql_a);

    set_time_limit(30);
}

function CalculaINDQUA1($vetC, &$indicadorPF, &$indicadorPJ) {
    $ano_base = 2017;

    $indicadorPF = 0;
    $indicadorPJ = 0;

    $rowl = $vetC;
    //$idt_atendimento=$rowl['idt_atendimento'];
    $idt_atendimento_organizacao = $rowl['idt_atendimento_organizacao'];
    // PF - 5 20%
    // Complemento de Endereço, Três Campos de Contato, Escolaridade, Potencial
    // Personagem e Portador de Necessidades Especiais?

    $peso = 20;
    $logradouro_complemento = $rowl['logradouro_complemento'];
    $telefone_residencial = $rowl['telefone_residencial'];
    $telefone_celular = $rowl['telefone_celular'];
    $telefone_recado = $rowl['telefone_recado'];
    $idt_escolaridade = $rowl['idt_escolaridade'];
    $potencial_personagem = $rowl['potencial_personagem'];
    $necessidade_especial = $rowl['necessidade_especial'];
    $email = $rowl['email'];

    if ($logradouro_complemento != "") {
        $indicadorPF = $indicadorPF + $peso;
    }

    // Contato
    if ($telefone_residencial != "") {
        $indicadorPF = $indicadorPF + $peso;
    }
    if ($telefone_celular != "") {
        $indicadorPF = $indicadorPF + $peso;
    }
    if ($telefone_recado != "") {
        $indicadorPF = $indicadorPF + $peso;
    }
    if ($email != "") {
        $indicadorPF = $indicadorPF + $peso;
    }

//    if ($telefone_residencial != "" or $telefone_celular != "" or $telefone_recado != "") {
//        $indicadorPF = $indicadorPF + $peso;
//    }

    if ($idt_escolaridade > 0) {
        $indicadorPF = $indicadorPF + $peso;
    }

//    if ($potencial_personagem != "") {
//        $indicadorPF = $indicadorPF + $peso;
//    }
//    if ($necessidade_especial != "") {
//        $indicadorPF = $indicadorPF + $peso;
//    }

    if ($rowl['cnpj'] != '') {
        // PJ - 4 25%
        // Optante do Simples Nacional?, Atividade Econômica Secundária, Complemento de
        // Endereço, Três Campos de Contato.

        $peso = 20;
        $simples_nacional = $rowl['simples_nacional'];
        $logradouro_complemento_e = $rowl['logradouro_complemento_e'];
        $telefone_comercial_e = $rowl['telefone_comercial_e'];
        $telefone_celular_e = $rowl['telefone_celular_e'];
        $email_e = $rowl['email_e'];

        $atividade_economica_secundaria = TrataAtvEconSec($idt_atendimento_organizacao);

        if ($simples_nacional != '') {
            $indicadorPJ = $indicadorPJ + $peso;
        }
        if ($logradouro_complemento_e != '') {
            $indicadorPJ = $indicadorPJ + $peso;
        }

        // Contato
        if ($telefone_comercial_e != '') {
            $indicadorPJ = $indicadorPJ + $peso;
        }
        if ($telefone_celular_e != '') {
            $indicadorPJ = $indicadorPJ + $peso;
        }
        if ($email_e != '') {
            $indicadorPJ = $indicadorPJ + $peso;
        }

        if ($atividade_economica_secundaria != 'N') {
            $indicadorPJ = $indicadorPJ + $peso;
        }

        $indicadorPJ = $indicadorPJ - 20;
        $indicadorPF = $indicadorPF - 20;

        $indicador1 = ($indicadorPF + $indicadorPJ) / 2;
    } else {
        $indicador1 = ($indicadorPF - 20);
    }

    return $indicador1;
}

function CalculaINDQUA2(&$vetC) {
    $ano_base = 2017;

    $indicador2 = 0;
    $rowl = $vetC;
    $peso = 25;
    $indicador2 = 0;
    $vetRF = Array();

    // Nossa base
    $cnpj = $rowl['cnpj'];
    $idt_porte = $rowl['idt_porte'];
    $razao_social = $rowl['razao_social'];
    $data_abertura = $rowl['data_abertura'];
    $idt_cnae_principal = $rowl['idt_cnae_principal'];
    $descricao_rf = $rowl['descricao_rf'];

    // Vetor Receita Federal
    $vetRF['cnpj'] = $cnpj;
    $vetRF['idt_porte'] = $idt_porte;
    $vetRF['razao_social'] = $razao_social;
    $vetRF['data_abertura'] = $data_abertura;
    $vetRF['idt_cnae_principal'] = $idt_cnae_principal;

//    $sql = '';
//    $sql .= ' select idt, descricao, desc_vl_cmb';
//    $sql .= ' from ' . db_pir_gec . 'gec_organizacao_porte';
//    //$sql .= " where codigo in ('2', '3', '99')";
//    $sql .= " where idt = " . null($idt_porte);
//    $rsl = execsql($sql);
//    ForEach ($rsl->data as $row) {
//        // Pegar campo novo.
//
//        $descricao_porte = $row['descricao'];
//        $desc_vl_cmb = $row['desc_vl_cmb'];
//    }

    $descricao_porte = $descricao_rf;
    $vetRF['descricao_porte'] = $descricao_rf;
//    $vetRF['desc_vl_cmb'] = $desc_vl_cmb;


    $descricao_cnae = $rowl['cnae_descricao'];
    $subclasse = $rowl['cnae_subclasse'];

    $vetRF['descricao_cnae'] = $descricao_cnae;
    $vetRF['subclasse'] = $subclasse;
    $subclasse_t = $subclasse;
    $vetRF['subclasse_t'] = $subclasse_t;

    $data_abertura = str_replace('-', '', $data_abertura);
    $vetRF['data_abertura_t'] = $data_abertura;

    $cnpj_receita = $cnpj;

    $vetRF['cnpj_receita'] = $cnpj_receita;
    $vetRF['amostra_2'] = 'N';

    $sql = '';
    //$sql .= ' select b,d,e,ar,x,ao '; AJUSTAR
    $sql .= ' select cnpj, razao_social as razao_social, porte_CSE_27mar2015_descr as porte_rf, cnae_subclasse as cnae_atividade_principal_rf, data_de_abertura as data_abertura_rf ';
    $sql .= ' from ' . db_pir . 'bc_rf_2015'; //bc_rf_2015
    $sql .= " where cnpj = " . aspa($cnpj_receita);
    $rsl = execsql($sql);

    if ($rsl->rows > 0) {
        $rz = "NA";

        ForEach ($rsl->data as $row) {
            $cnpj_rf = $row['cnpj'];
            $razao_social_rf = $row['razao_social'];
            $porte_rf = $row['porte_rf'];
            $cnae_atividade_principal_rf = $row['cnae_atividade_principal_rf'];
            $data_abertura_rf = $row['data_abertura_rf'];

            //$razao_social_rft            = str_replace('LTDA','',$razao_social_rf);
            $razao_social_rft = $razao_social_rf;

            // Trta o indicador 2
            $indicador2 = $indicador2 + $peso; // CNPJ existe

            $razao_socialw = str_replace(' - ', ' ', $razao_social);
            $razao_socialw = mb_strtoupper($razao_socialw);
            $rz = TiraAcento($razao_socialw);

//          $rz           = mb_strtoupper($razao_socialw);
//            if ($rz == $razao_social_rf) {  // razão social
//                $indicador2 = $indicador2 + $peso;
//            }

            if ($data_abertura == $data_abertura_rf) { // Data abertura
                $indicador2 = $indicador2 + $peso;
            }
            if ($descricao_porte == $porte_rf) { // porte empresa
                $indicador2 = $indicador2 + $peso;
            }
            if ($subclasse_t == $cnae_atividade_principal_rf) { // porte empresa
                $indicador2 = $indicador2 + $peso;
            }
        }
        $vetRF['razao_social_crm'] = $rz;
        $vetRF['cnpj_RF'] = $cnpj_rf;
        $vetRF['razao_social_RF'] = $razao_social_rf;
        $vetRF['razao_social_RFT'] = $razao_social_rft;
        $vetRF['porte_RF'] = $porte_rf;
        $vetRF['cnae_atividade_principal_RF'] = $cnae_atividade_principal_rf;
        $vetRF['data_abertura_RF'] = $data_abertura_rf;
    } else {

        $data = trata_data('31/12/' . ($ano_base - 1));
        if ($data_abertura > $data) {
            $vetRF['amostra_2'] = 'S';
        }
    }

    $vetC['RF'] = $vetRF;

    return $indicador2;
}
