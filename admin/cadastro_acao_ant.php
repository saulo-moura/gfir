<?php
/*
  switch ($_POST['btnAcao']) {
  case $bt_salvar_lbl:
  case 'Continua':
  break;

  case $bt_alterar_lbl:
  break;

  case $bt_excluir_lbl:
  break;
  }
 */
//echo "  $menu <br />";
//p($_POST);

switch ($menu) {
    case 'plu_senha':
        if ($_SESSION[CS]['g_senha_antiga'] != md5($_POST['atual'])) {
            echo "
                <script type='text/javascript'>
                    alert('A senha atual esta errada!');
                    self.location = 'conteudo" . $cont_arq . ".php?prefixo=cadastro&menu=plu_senha';
                </script>
            ";
            exit();
        } elseif ($_POST['senha'] != $_POST['confirmacao']) {
            echo "
                <script type='text/javascript'>
                    alert('A senha nova esta diferente da confirmação!');
                    self.location = 'conteudo" . $cont_arq . ".php?prefixo=cadastro&menu=plu_senha';
                </script>
            ";
            exit();
        }
        break;

    case 'plu_funcao':
        $_POST['des_prefixo'] = $_POST['prefixo_menu'] . $_POST['parametros'];
        break;

    case 'plu_painel_grupo':
        switch ($_POST['btnAcao']) {
            case $bt_alterar_lbl:
                $sql = '';
                $sql .= ' select *';
                $sql .= ' from plu_painel_grupo';
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $row_painel_ant = $rs->data[0];
                break;
        }
        break;


    case 'grc_produto_desenvolver':
    case 'grc_produto':
        if ($_POST['tipo_calculo'] == 'P') {
            $_POST['carga_horaria_fim'] = $_POST['carga_horaria_ini'];
            $_POST['carga_horaria_2_fim'] = $_POST['carga_horaria_2_ini'];
        }

        if ($acao == 'exc') {
            $idt_produto = $vlID;
            ExcluiProduto($idt_produto);
        }
        break;

    case 'grc_evento_acesso':
        $_POST['descricao_md5'] = md5($_POST['descricao']);
        break;

    case 'grc_evento_participante_motivo_ic':
        $_POST['descricao_md5'] = md5($_POST['descricao']);
        break;

    case 'grc_evento_produto':
        if ($acao == 'exc') {
            $sql = '';
            $sql .= ' select idt_produto';
            $sql .= ' from grc_evento_produto ';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsql($sql);


            ForEach ($rs->data as $row) {
                $idt_produto = $row['idt_produto'];
            }
            $sql_d = 'delete from grc_evento_produto ';
            $sql_d .= ' where idt = ' . null($vlID);
            $result = execsql($sql_d);

            ExcluiProduto($idt_produto);
        }
        break;

    case 'grc_evento_publicar':
        $_POST['situacao'] = 'FI';
        $_POST['idt_usuario_aprovacao'] = $_SESSION[CS]['g_id_usuario'];
        $_POST['dt_aprovacao'] = getdata(true, true, true);

        if (is_array($_POST['epe_situacao'])) {
            foreach ($_POST['epe_situacao'] as $idt => $situacao) {
                if ($situacao == 'RE') {
                    $_POST['situacao'] = 'FR';
                }

                $sql = 'update ' . db_pir_grc . 'grc_evento_publicar_evento set';
                $sql .= ' situacao = ' . aspa($situacao);
                $sql .= ' where idt_evento = ' . null($idt);
                $sql .= ' and idt_evento_publicar = ' . null($vlID);
                execsql($sql);

                $sql = '';
                $sql .= ' select codigo, descricao';
                $sql .= ' from grc_evento';
                $sql .= ' where idt = ' . null($idt);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $campoLog = 'idt_evento_' . $idt;
                $vetLogDetalheExtra['grc_evento_publicar'][$campoLog]['campo_desc'] = 'Evento: [' . $row['codigo'] . '] ' . $row['descricao'];
                $vetLogDetalheExtra['grc_evento_publicar'][$campoLog]['desc_ant'] = $vetEventoPubilcarRegistro['AA'];
                $vetLogDetalheExtra['grc_evento_publicar'][$campoLog]['vl_ant'] = 'AA';
                $vetLogDetalheExtra['grc_evento_publicar'][$campoLog]['desc_atu'] = $vetEventoPubilcarRegistro[$situacao];
                $vetLogDetalheExtra['grc_evento_publicar'][$campoLog]['vl_atu'] = $situacao;
            }
        }
        break;

    case 'grc_evento_combo_cad':
        if ($_POST['btnAcao'] == $bt_excluir_lbl) {
            ExcluiEventoAcao($vlID);
        }
        if ($_POST['situacao'] == 6) {
            $_POST['dt_inicio_aprovacao'] = getdata(false, true);
        }

        if ($_POST['idt_evento_situacao'] == 1 || $_POST['idt_evento_situacao'] == 5) {
            $sql = '';
            $sql .= ' select sum(vl_evento) as combo_vl_tot_evento, sum(vl_matricula) as combo_vl_tot_matricula';
            $sql .= ' from grc_evento_combo';
            $sql .= ' where idt_evento_origem = ' . null($vlID);
            $rs = execsql($sql);
            $row = $rs->data[0];

            if ($row['combo_vl_tot_evento'] == 0) {
                $combo_percentual_desc = 0;
            } else {
                $combo_percentual_desc = 100 - ($row['combo_vl_tot_matricula'] * 100 / $row['combo_vl_tot_evento']);
            }

            $_POST['combo_vl_tot_evento'] = format_decimal($row['combo_vl_tot_evento']);
            $_POST['combo_vl_tot_matricula'] = format_decimal($row['combo_vl_tot_matricula']);
            $_POST['combo_percentual_desc'] = format_decimal($combo_percentual_desc);
        }
        break;

    case 'gec_contratar_credenciado_distrato':
        $distrato_situacao = $_POST['situacao'];
        $vetDel = Array();
        $emailUploadPST = false;

        if ($_POST['situacao_ant'] != $distrato_situacao) {
            $_POST['idt_usuario_situacao'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_situacao'] = getdata(true, true, true);
        }

        if ($_POST['bt_salva'] == '') {
            //Assinatura
            if ($distrato_situacao == 'AS') {
                if (is_array($_FILES['arq_distrato_ass'])) {
                    $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, $pathObjFile . '/gec_contratar_credenciado_distrato_pdf/');

                    if (!file_exists($pathPDF)) {
                        mkdir($pathPDF);
                    }

                    foreach ($_FILES['arq_distrato_ass']['name'] as $idx => $file_name) {
                        if ($file_name != '') {
                            if ($_SESSION[CS]['g_abrir_sistema_origem'] == 'PFO') {
                                $emailUploadPST = true;
                            }

                            $sql = '';
                            $sql .= ' select arq_distrato_ass';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf';
                            $sql .= ' where idt = ' . null($idx);
                            $rs = execsql($sql);
                            $nomearq = $rs->data[0][0];

                            if ($nomearq != '') {
                                $vetDel[] = $pathPDF . $nomearq;
                            }

                            switch ($_FILES['arq_distrato_ass']['error'][$idx]) {
                                case UPLOAD_ERR_OK:
                                    $Erro = "OK";
                                    break;

                                case UPLOAD_ERR_INI_SIZE:
                                    $Erro = "O arquivo ultrapassou o limite de tamanho de (Ini) " . ini_get('upload_max_filesize') . ".";
                                    break;

                                case UPLOAD_ERR_FORM_SIZE:
                                    $Erro = "O arquivo ultrapassou o limite de tamanho de (post) " . $_POST['MAX_FILE_SIZE'] . " bytes.";
                                    break;

                                case UPLOAD_ERR_PARTIAL:
                                    $Erro = "O upload do arquivo foi feito parcialmente.";
                                    break;

                                case UPLOAD_ERR_NO_FILE:
                                    $Erro = "Não foi feito o upload do arquivo.";
                                    break;
                            }

                            if ($Erro != "OK") {
                                erro_try('Distrato Assinado erro: ' . $Erro);

                                echo '<script type="text/javascript">';
                                echo 'alert("Distrato Assinado erro: ' . $Erro . '");';
                                echo 'self.location = "' . $pagina . '?' . $_SERVER['QUERY_STRING'] . '";';
                                echo '</script>';
                                onLoadPag();
                                exit();
                            }

                            $nomearq = mb_strtolower($idx . '_arq_distrato_ass_' . $microtime . '_' . troca_caracter($file_name));
                            move_uploaded_file($_FILES['arq_distrato_ass']['tmp_name'][$idx], $pathPDF . $nomearq);

                            $sql = "update " . db_pir_gec . "gec_contratar_credenciado_distrato_pdf set arq_distrato_ass = " . aspa($nomearq);
                            $sql .= ', data_upload = now(), idt_usuario_upload = ' . null($_SESSION[CS]['g_id_usuario_sistema']['GEC']);
                            $sql .= " where idt = " . null($idx);
                            execsql($sql);
                        }
                    }
                }

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf';
                $sql .= ' where idt_distrato = ' . null($vlID);
                $sql .= ' and arq_distrato_ass is null';
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $_POST['situacao'] = 'AP';
                }
            }
        }
        break;

    case 'gec_contratar_credenciado_aditivo':
        $aditivo_situacao = $_POST['situacao'];
        $vetDel = Array();

        if ($_POST['situacao_ant'] != $aditivo_situacao) {
            $_POST['idt_usuario_situacao'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_situacao'] = getdata(true, true, true);
        }

        if ($_POST['bt_salva'] == '') {
            //Assinatura
            if ($aditivo_situacao == 'AS') {
                if (is_array($_FILES['arq_aditivo_ass'])) {
                    $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, $pathObjFile . '/gec_contratar_credenciado_aditivo_pdf/');

                    if (!file_exists($pathPDF)) {
                        mkdir($pathPDF);
                    }

                    foreach ($_FILES['arq_aditivo_ass']['name'] as $idx => $file_name) {
                        if ($file_name != '') {
                            $sql = '';
                            $sql .= ' select arq_aditivo_ass';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_pdf';
                            $sql .= ' where idt = ' . null($idx);
                            $rs = execsql($sql);
                            $nomearq = $rs->data[0][0];

                            if ($nomearq != '') {
                                $vetDel[] = $pathPDF . $nomearq;
                            }

                            switch ($_FILES['arq_aditivo_ass']['error'][$idx]) {
                                case UPLOAD_ERR_OK:
                                    $Erro = "OK";
                                    break;

                                case UPLOAD_ERR_INI_SIZE:
                                    $Erro = "O arquivo ultrapassou o limite de tamanho de (Ini) " . ini_get('upload_max_filesize') . ".";
                                    break;

                                case UPLOAD_ERR_FORM_SIZE:
                                    $Erro = "O arquivo ultrapassou o limite de tamanho de (post) " . $_POST['MAX_FILE_SIZE'] . " bytes.";
                                    break;

                                case UPLOAD_ERR_PARTIAL:
                                    $Erro = "O upload do arquivo foi feito parcialmente.";
                                    break;

                                case UPLOAD_ERR_NO_FILE:
                                    $Erro = "Não foi feito o upload do arquivo.";
                                    break;
                            }

                            if ($Erro != "OK") {
                                erro_try('Aditamento Assinado erro: ' . $Erro);

                                echo '<script type="text/javascript">';
                                echo 'alert("Aditamento Assinado erro: ' . $Erro . '");';
                                echo 'self.location = "' . $pagina . '?' . $_SERVER['QUERY_STRING'] . '";';
                                echo '</script>';
                                onLoadPag();
                                exit();
                            }

                            $nomearq = mb_strtolower($idx . '_arq_aditivo_ass_' . $microtime . '_' . troca_caracter($file_name));
                            move_uploaded_file($_FILES['arq_aditivo_ass']['tmp_name'][$idx], $pathPDF . $nomearq);

                            $sql = "update " . db_pir_gec . "gec_contratar_credenciado_aditivo_pdf set arq_aditivo_ass = " . aspa($nomearq);
                            $sql .= ', data_upload = now(), idt_usuario_upload = ' . null($_SESSION[CS]['g_id_usuario_sistema']['GEC']);
                            $sql .= " where idt = " . null($idx);
                            execsql($sql);
                        }
                    }
                }

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_pdf';
                $sql .= ' where idt_aditivo = ' . null($vlID);
                $sql .= ' and arq_aditivo_ass is null';
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $_POST['situacao'] = 'AP';
                }
            }
        }
        break;

    case 'grc_evento':
        if ($acao == 'inc') {
            $_POST['copia'] = 0;
            //
            $tabela = 'grc_evento';
            $Campo = 'codigo';
            $tam = 7;
            $codigow = numerador_arquivo($tabela, $Campo, $tam);
            $codigo = 'EV' . $codigow;
            $_POST['codigo'] = $codigo;

            $_POST['idt_evento_situacao'] = 1;
        }

        $_POST['idt_ponto_atendimento'] = $_POST['idt_ponto_atendimento_tela'];
        $_POST['descricao'] = str_replace("'", '', $_POST['descricao']);

        if ($_POST['situacao'] == 6 || $_POST['situacao'] == 'EnviarAprovarEventoCombo') {
            $_POST['dt_inicio_aprovacao'] = getdata(true, true);

            if ($_POST['publique_imediatamente'] == 'S') {
                $_POST['publica_internet'] = 'S';
        }
        }

        if ($_POST['idt_ponto_atendimento'] == '') {
            $_POST['idt_ponto_atendimento'] = $_POST['idt_unidade'];
        }

        if ($_POST['valor_inscricao'] == '') {
            $_POST['valor_inscricao'] = 0;
        }

        if ($_POST['qtd_vagas_adicional'] == '') {
            $_POST['qtd_vagas_adicional'] = 0;
        }

        if ($_POST['cred_necessita_credenciado'] == '') {
            $_POST['cred_necessita_credenciado'] = 'N';
        }

        if ($_POST['cred_rodizio_auto'] == '') {
            $_POST['cred_rodizio_auto'] = $_POST['cred_necessita_credenciado'];
        }

        if ($_POST['cred_credenciado_sgc'] == '') {
            $_POST['cred_credenciado_sgc'] = 'N';
        }

        if ($_POST['cred_contratacao_cont'] == '') {
            $_POST['cred_contratacao_cont'] = 'N';
        }

        if ($_POST['nao_sincroniza_rm'] == '') {
            $_POST['nao_sincroniza_rm'] = 'N';
        }

        if ($_POST['sincroniza_loja'] == '') {
            $_POST['sincroniza_loja'] = 'S';
        }

        $sql = '';
        $sql .= ' select tipo_calculo';
        $sql .= ' from grc_produto';
        $sql .= ' where idt = ' . null($_POST['idt_produto']);
        $rs = execsql($sql);

        if ($rs->data[0][0] == 'P') {
            $_POST['carga_horaria_total'] = $_POST['carga_horaria_total_ini'] * ($_POST['quantidade_participante'] + $_POST['qtd_vagas_adicional']);
        }

        $sql = '';
        $sql .= ' select tipo_ordem';
        $sql .= ' from ' . db_pir_gec . 'gec_programa';
        $sql .= ' where idt = ' . null($_POST['idt_programa']);
        $rs = execsql($sql);

        if ($rs->data[0][0] == 'SG') {
            $_POST['cred_necessita_credenciado'] = 'S';
            $_POST['cred_rodizio_auto'] = 'N';
            $_POST['cred_credenciado_sgc'] = 'S';
            $_POST['cred_contratacao_cont'] = 'N';
        }

        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from grc_evento_acesso';
        $sql .= ' where descricao_md5 = ' . aspa($_POST['evento_acesso_descricao_md5']);
        $rs = execsql($sql);
        $_POST['evento_acesso_descricao'] = $rs->data[0][0];

        if ($_POST['situacao'] == 'reload_tela') {
            $sql = '';
            $sql .= ' select conteudo_programatico, descricao_comercial';
            $sql .= ' from grc_evento';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsql($sql);
            $_POST['conteudo_programatico'] = $rs->data[0]['conteudo_programatico'];
            $_POST['descricao_comercial'] = $rs->data[0]['descricao_comercial'];
        }
        break;

    case 'grc_evento_combo':
        if ($_POST['qtd_utilizada'] == '') {
            $_POST['qtd_utilizada'] = 0;
        }

        $sql = '';
        $sql .= ' select valor_inscricao';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($_POST['idt_evento']);
        $rs = execsql($sql);
        $_POST['vl_evento'] = $rs->data[0][0];

        if ($_POST['vl_evento'] == '') {
            $_POST['vl_evento'] = 0;
        }

        $_POST['vl_matricula'] = format_decimal($_POST['vl_evento'] - ($_POST['vl_evento'] * desformat_decimal($_POST['perc_desconto']) / 100));
        $_POST['vl_evento'] = format_decimal($_POST['vl_evento']);

        //Desbloquea a Qtd. Vagas no Evento
        $vetErro = operacaoEventoComboVaga($vlID, FALSE);

        if (count($vetErro) > 0) {
            $erro = implode('<br />', $vetErro);
            msg_erro($erro);
        }
        break;

    case 'grc_evento_participante_contadevolucao':
    case 'grc_atendimento_evento_contadevolucao':
        if ($_POST['conta'] == -1) {
            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from grc_evento_banco';
            $sql .= ' where codigo = ' . aspa($_POST['banco_numero']);
            $rs = execsql($sql);
            $_POST['banco_nome'] = $rs->data[0][0];
        } else {
            $vetConta = $_SESSION[CS]['tmp']['contadevolucao'][$_GET['session_cod']];
            $rowConta = $vetConta[$_POST['conta']];

            $_POST['banco_numero'] = $rowConta['banco_numero'];
            $_POST['banco_nome'] = $rowConta['banco_nome'];
            $_POST['agencia_numero'] = $rowConta['agencia_numero'];
            $_POST['agencia_digito'] = $rowConta['agencia_digito'];
            $_POST['cc_numero'] = $rowConta['cc_numero'];
            $_POST['cc_digito'] = $rowConta['cc_digito'];
            $_POST['cpfcnpj'] = $rowConta['cpfcnpj'];
            $_POST['razao_social'] = $rowConta['razao_social'];
            $_POST['rm_codcfo'] = $rowConta['rm_codcfo'];
            $_POST['rm_idpgto'] = $rowConta['rm_idpgto'];
        }
        break;

    case 'grc_atendimento_agenda':
        /*
          if ($acao == 'inc') {

          $tabela = 'grc_atendimento_agenda';
          $Campo  = 'protocolo';
          $tam = 7;
          $codigow = numerador_arquivo($tabela, $Campo, $tam);
          $codigo  = 'MA'.$codigow;
          $_POST['protocolo']=$codigo;

          }
         */
        if ($acao == 'inc' or $acao == 'alt') {
            /*
              $servicos          = str_replace('<br>',Char(13),$_POST['servicos']);
              $servicos          = str_replace('<br />',Char(13),$servicos);
              $_POST['servicos'] = $servicos;
             */
            $data = $_POST['data'];
            $dia_semana = GRC_DiaSemana($data, 'resumo1');
            $_POST['dia_semana'] = $dia_semana;
        }
        break;


    case 'grc_atendimento_usuario_disponibilidade':
        if ($acao == 'inc') {
            $dia = $_POST['dia'];
            $hora_inicial = $_POST['hora_inicial'];
            $idt_usuario = $_POST['idt_usuario'];
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_usuario_disponibilidade ';
            $sql .= ' where dia = ' . aspa($dia);
            $sql .= '   and hora_inicial = ' . aspa($hora_inicial);
            $sql .= '   and idt_usuario = ' . null($idt_usuario);
            $rs = execsql($sql);
            if ($rs->rows != 0) {
                echo
                " <script type='text/javascript'>
                  alert('Registro já existe. Verifique!');
                  self.location = 'conteudo.php?prefixo=listar&menu=grc_atendimento_usuario_disponibilidade&cod_volta=tabela_apoio_atendimento&painel_btvoltar_rod=N&pri=S&id=0';
                  </script> ";
                exit();
            }
        }

        if ($acao == 'inc' or $acao == 'alt') {

            $idt = $vlID;
            $idt_usuario = $_POST['idt_usuario'];
            $dia = $_POST['dia'];
            $hora_inicial = $_POST['hora_inicial'];
            $hora_final = $_POST['hora_final'];

            $sql_aa = 'select * from grc_atendimento_usuario_disponibilidade ';
            $sql_aa .= ' where  idt_usuario   = ' . null($idt_usuario);
            $sql_aa .= '   and  dia           = ' . aspa($dia);
            $sql_aa .= '   and  ((hora_inicial < ' . aspa($hora_inicial);
            $sql_aa .= '   and  hora_final    > ' . aspa($hora_inicial);

            $sql_aa .= ')   or  (hora_inicial < ' . aspa($hora_final);
            $sql_aa .= '   and  hora_final    > ' . aspa($hora_final);
            $sql_aa .= '))';

            if ($acao == 'alt') {
                $sql_aa .= ' and  idt <> ' . null($idt);
            }
            $sql_aa .= ' order by hora_inicial ';

            $result = execsql($sql_aa);

            if ($result->rows != 0) {
                echo
                " <script type='text/javascript'>
                  alert('Horário coincidente com existente!');
                  self.location = 'conteudo.php?sqlOrderby_upcad=&vlPesquisaPadrao=&prefixo=listar&menu=grc_atendimento_usuario_disponibilidade&cod_volta=tabela_apoio_atendimento&painel_btvoltar_rod=N&pri=S0';
                  </script> ";
                exit();
            }
        }

//      self.location = 'conteudo.php?prefixo=listar&menu=grc_atendimento_usuario_disponibilidade&cod_volta=tabela_apoio_atendimento&painel_btvoltar_rod=N&pri=S&id=0';


        break;


    case 'grc_atendimento_pa_pessoa':
    case 'grc_atendimento_pa_pessoa_par':
        if ($acao == 'inc' or $acao == 'alt') {
            $idt = $vlID;
            $idt_ponto_atendimento = $_POST['idt_ponto_atendimento'];
            $letra_painel = $_POST['letra_painel'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pa_pessoa ';
            $sql .= ' where idt_ponto_atendimento = ' . null($idt_ponto_atendimento);
            $sql .= '   and letra_painel          = ' . aspa($letra_painel);

            if ($acao == 'alt') {
                $sql .= ' and  idt <> ' . null($idt);
            }

            $rs = execsql($sql);
            if ($rs->rows != 0) {
                /* // Neutralizado ate aq utilização do painel aí então revizar essa necessidade
                  echo
                  " <script type='text/javascript'>
                  alert('Letra Painel já Utilizada. Verifique!');
                  self.location = 'conteudo.php?sqlOrderby_upcad=&vlPesquisaPadrao=&prefixo=listar&menu=grc_atendimento_pa_pessoa&cod_volta=tabela_apoio_atendimento&painel_btvoltar_rod=N&pri=S0';
                  </script> ";
                  exit();
                 */
            }
        }

    case 'grc_atendimento_cadastro':
    case 'grc_nan_visita_1_cadastro':
    case 'grc_nan_visita_2_cadastro':
        if ($_POST['representa_empresa'] == 'N') {
            $_POST['cnpj'] = time();
            $_POST['razao_social'] = time();
        }
        break;

    case 'grc_atendimento_organizacao':
    case 'grc_entidade_organizacao':
        if ($_POST['idt_tipo_empreendimento'] == 7 && $_POST['codigo_prod_rural'] == '') {
            $_POST['codigo_prod_rural'] = 'PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc);
        }

        if ($_POST['cnpj'] == '') {
            $_POST['cnpj'] = $_POST['codigo_prod_rural'];
        }
        break;

    case 'grc_evento_participante':
    case 'grc_evento_participante_filaespera':
        if ($_POST['idt_tipo_empreendimento'] == 7 && $_POST['codigo_prod_rural'] == '') {
            $_POST['codigo_prod_rural'] = 'PRGRC' . AutoNum('grc_atendimento_organizacao_cnpj_PR', 10, false, false, db_pir_grc);
        }

        if ($_POST['cnpj'] == '') {
            $_POST['cnpj'] = $_POST['codigo_prod_rural'];
        }

        if ($_POST['cnpj'] == '') {
            $_POST['cnpj'] = '00.000.000/0000-00';
        }

        if ($_POST['razao_social'] == '') {
            $_POST['razao_social'] = 'Novo Empreendimento';
        }

        if ($_POST['novo_registro'] == '') {
            $_POST['novo_registro'] = 'N';
        }

        $sql = '';
        $sql .= ' select descricao';
        $sql .= ' from grc_evento_participante_motivo_ic';
        $sql .= ' where descricao_md5 = ' . aspa($_POST['motivo_cancelamento_md5']);
        $rs = execsql($sql);
        $_POST['motivo_cancelamento'] = $rs->data[0][0];

        switch ($_POST['btnAcao']) {
            case $bt_excluir_lbl:
                $sql = 'delete from grc_evento_participante_pagamento where idt_atendimento = ' . null($vlID);
                execsql($sql);

                $sql = 'delete from grc_atendimento_pessoa where idt_atendimento = ' . null($vlID);
                execsql($sql);
                break;
        }
        break;

    case 'grc_evento_participante_pagamento':
    case 'gec_contratar_credenciado_aditivo_participante_pagamento':
        switch ($_POST['btnAcao']) {
            case $bt_excluir_lbl:
                $sql = "update grc_evento_participante_pagamento set estornado = 'S', estornar_rm = 'S'";
                $sql .= ' where idt = ' . null($vlID);
                execsql($sql);

                $sql = '';
                $sql .= ' select p.idt, p.rm_idmov, p.idt_atendimento, a.idt_evento';
                $sql .= ' from grc_evento_participante_pagamento p';
                $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
                $sql .= ' where p.idt = ' . null($vlID);
                $rs = execsql($sql);
                $row = $rs->data[0];

                //sincronização com o RM
                if ($row['rm_idmov'] != '') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_evento_participante_pagamento = ' . null($row['idt']);
                    $sql .= " and tipo = 'RM_EXC'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_participante_pagamento, tipo) values (';
                        $sql .= null($row['idt_atendimento']) . ', ' . null($row['idt_evento']) . ', ' . null($row['idt']) . ", 'RM_EXC')";
                        execsql($sql);
                    } else {
                        $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }

                    $ssaIdtEvento = $row['idt_evento'];
                    $ssaIdtAtendimento = $row['idt_atendimento'];
                    $ssaIdtPagamento = $row['idt'];
                    require_once 'sincroniza_siac_acao.php';
                }
                break;
        }
        break;

    case 'grc_evento_agenda_mat':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:
                if ($_POST['idt_evento_atividade'] == '') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento_atividade';
                    $sql .= ' where cod_atividade = ' . aspa(md5($_POST['atividade']));
                    $sql .= ' and idt_evento = ' . null($_POST['idt_evento']);
                    $sql .= ' and idt_atendimento = ' . null($_POST['idt_atendimento']);
                    $rs_ea = execsql($sql);
                    $_POST['idt_evento_atividade'] = $rs_ea->data[0][0];
                }

                if ($_POST['idt_evento_atividade'] == '') {
                    $sql = '';
                    $sql .= ' insert into grc_evento_atividade (idt_evento, idt_atendimento, cod_atividade, atividade, idt_tema, idt_subtema) values (';
                    $sql .= null($_POST['idt_evento']) . ', ' . null($_POST['idt_atendimento']) . ', ' . aspa(md5($_POST['atividade'])) . ', ' . aspa($_POST['atividade']) . ', ';
                    $sql .= null($_POST['idt_tema']) . ', ' . null($_POST['idt_subtema']) . ')';
                    execsql($sql);
                    $_POST['idt_evento_atividade'] = lastInsertId();
                } else if ($_POST['id'] == 0) {
                    $sql = '';
                    $sql .= ' select atividade, idt_tema, idt_subtema';
                    $sql .= ' from grc_evento_atividade';
                    $sql .= ' where idt = ' . null($_POST['idt_evento_atividade']);
                    $rs = execsql($sql);
                    $row = $rs->data[0];

                    $_POST['atividade'] = $row['atividade'];
                    $_POST['idt_tema'] = $row['idt_tema'];
                    $_POST['idt_subtema'] = $row['idt_subtema'];
                } else {
                    $sql = '';
                    $sql .= ' update grc_evento_atividade set atividade = ' . aspa($_POST['atividade']);
                    $sql .= ', cod_atividade = ' . aspa(md5($_POST['atividade']));
                    $sql .= ', idt_tema = ' . null($_POST['idt_tema']);
                    $sql .= ', idt_subtema = ' . null($_POST['idt_subtema']);
                    $sql .= ' where idt = ' . null($_POST['idt_evento_atividade']);
                    execsql($sql);
                }
                break;

            case $bt_excluir_lbl:
                break;
        }

    case 'grc_evento_agenda':
        $_POST['dt_ini'] = $_POST['data_inicial'] . ' ' . $_POST['hora_inicial'];
        $_POST['dt_fim'] = $_POST['data_final'] . ' ' . $_POST['hora_final'];
        $_POST['carga_horaria'] = format_decimal(diffDate($_POST['dt_ini'], $_POST['dt_fim'], 'H'));
        $_POST['competencia'] = $_POST['data_inicial'];

        if ($_POST['idorg'] !== -1) {
            $vetReturn = validaDispLocalEvento($vlID, 0, $_POST['idt_local'], $_POST['dt_ini'], $_POST['dt_fim']);

            if (count($vetReturn) == 0) {
                $_POST['alocacao_disponivel'] = 'S';
                $_POST['alocacao_msg'] = '';
            } else {
                $_POST['alocacao_disponivel'] = 'N';
                $_POST['alocacao_msg'] = implode('<br />', $vetReturn);
            }
        }
        break;

    case 'grc_evento_local_pa_agenda':
        $_POST['dt_ini'] = $_POST['data_inicial'] . ' ' . $_POST['hora_inicial'];
        $_POST['dt_fim'] = $_POST['data_final'] . ' ' . $_POST['hora_final'];

        if ($_POST['idorg'] !== -1) {
            $vetReturn = validaDispLocalEvento(0, $vlID, $_POST['idt_local_pa'], $_POST['dt_ini'], $_POST['dt_fim']);

            if (count($vetReturn) == 0) {
                $_POST['alocacao_disponivel'] = 'S';
                $_POST['alocacao_msg'] = '';
            } else {
                $_POST['alocacao_disponivel'] = 'N';
                $_POST['alocacao_msg'] = implode('<br />', $vetReturn);
            }
        }
        break;

    case 'grc_produto_profissional':
        switch ($_POST['btnAcao']) {
            case $bt_excluir_lbl:
                $sql = 'delete from grc_produto_insumo where idt_produto_profissional = ' . null($vlID);
                execsql($sql);
                break;
        }
        break;

    case 'grc_atendimento_pendencia':
    case 'grc_atendimento_pendencia_m':
        if ($_POST['idt_responsavel_solucao'] == '') {
            $_POST['idt_responsavel_solucao'] = $_POST['idt_gestor_local'];
        }
        break;

    case 'grc_formulario_secao':
        if ($acao == 'exc') {
            checa_ponto_formularioEXC($vlID, 'idt_formulario', 'grc_formulario_secao', 'grc_formulario', $acao);
        }
        break;

    case 'grc_formulario_pergunta':
        if ($acao == 'exc') {
            checa_ponto_formularioEXC($vlID, 'idt_formulario', 'grc_formulario_secao', 'grc_formulario', $acao);
        }
        break;

    case 'grc_formulario_resposta':
        if ($acao == 'exc') {
            checa_ponto_formularioEXC($vlID, 'idt_formulario', 'grc_formulario_secao', 'grc_formulario', $acao);
        }
        break;

    case 'grc_nan_gestao_contrato':
        $vetData = explode('/', $_POST['nan_data_contrato']);
        $_POST['nan_contrato_dia'] = $vetData[0];
        $_POST['nan_contrato_mes'] = $vetData[1];
        $_POST['nan_contrato_ano'] = $vetData[2];
        break;

    case 'grc_nan_ordem_pagamento':
        if ($acao == 'exc') {
            $vetMesclarCadastro['grc_nan_ordem_pagamento']['tabela'] = '';
        }
        break;

    case 'grc_atendimento_pendencia_troca':
        $_POST['idt_gestor_local'] = $_POST['idt_responsavel_solucao'];
        break;

    case 'grc_transferencia_responsabilidade':
        if ($_POST['chk_evento'] == '') {
            $_POST['chk_evento'] = 'N';
        }

        if ($_POST['chk_pag_cred'] == '') {
            $_POST['chk_pag_cred'] = 'N';
        }

        if ($_POST['chk_atend'] == '') {
            $_POST['chk_atend'] = 'N';
        }

        $sql = '';
        $sql .= ' select r.situacao';
        $sql .= ' from grc_transferencia_responsabilidade r';
        $sql .= ' where r.idt = ' . null($vlID);
        $rs = execsql($sql);
        $situacao_ant = $rs->data[0][0];

        if ($_POST['situacao'] == 'AP' && $situacao_ant == 'GC') {
            $sql = '';
            $sql .= ' select idt_cargo';
            $sql .= ' from plu_usuario';
            $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_origem']);
            $rs = execsql($sql);
            $idt_cargoOrg = $rs->data[0][0];

            $sql = '';
            $sql .= ' select idt_cargo';
            $sql .= ' from plu_usuario';
            $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_destino']);
            $rs = execsql($sql);
            $idt_cargoDes = $rs->data[0][0];

            if ($idt_cargoOrg != $idt_cargoDes) {
                $_POST['situacao'] = 'CG';
            }
        }
        break;

    case 'grc_evento_publicacao':
        if ($_POST['situacao_ant'] != $_POST['situacao']) {
            $_POST['idt_usuario_situacao'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_situacao'] = getdata(true, true, true);
        }

        if ($_POST['situacao_ant'] == 'Despublicar') {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_evento_publicacao';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsqlNomeCol($sql);
            $row = $rs->data[0];

            $_POST['tipo_acao'] = 'D';

            $row['tipo_acao'] = 'D';

            $_POST['idt_responsavel'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_responsavel'] = getdata(true, true, true);

            $row['idt_responsavel'] = $_POST['idt_responsavel'];
            $row['data_responsavel'] = trata_data($_POST['data_responsavel']);

            $row['idt_usuario_situacao'] = $_POST['idt_usuario_situacao'];
            $row['data_situacao'] = trata_data($_POST['data_situacao']);

            unset($row['idt']);

            $row = array_map('aspa', $row);

            $sql = 'insert into ' . db_pir_grc . 'grc_evento_publicacao (' . implode(', ', array_keys($row)) . ') values (' . implode(', ', $row) . ')';
            execsql($sql);
            $vlID = lastInsertId();
            $_POST['id'] = $vlID;
            $_GET['id'] = $vlID;
            $vetID['grc_evento_publicacao'] = $vlID;
        }
        break;

    case 'grc_evento_publicacao_mapa':
        $sql = '';
        $sql .= ' select idt_local_pa_mapa';
        $sql .= ' from grc_evento_publicacao_mapa';
        $sql .= ' where idt = ' . null($vlID);
        $rs = execsql($sql);
        $rowDadosAnt = $rs->data[0];

        if ($rowDadosAnt['idt_local_pa_mapa'] == '') {
            $sql = '';
            $sql .= ' select descricao, detalhe, assento_mapa';
            $sql .= ' from grc_evento_local_pa_mapa';
            $sql .= ' where idt = ' . null($_POST['idt_local_pa_mapa']);
            $rs = execsql($sql);
            $row = $rs->data[0];
            
            $_POST['descricao'] = $row['descricao'];
            $_POST['detalhe'] = $row['detalhe'];
            $_POST['assento_mapa'] = $row['assento_mapa'];
        }
        break;
	
	case 'grc_atendimento_gera_agenda_errado':

    case 'grc_atendimento_gera_agenda_errado':

        p($_POST);
        //echo " $acao = $vlID ";

        if ($acao == 'inc' or $acao == 'alt') {
            $idt_atendimento_gera_agenda = $vlID;
            $executa = $_POST['executa'];
            //
            $vetret = array();
            $vetret['memoria'] = 'S';
            $vetret['idt_consultor'] = $_POST['idt_consultor'];
            $vetret['idt_ponto_atendimento'] = $_POST['idt_ponto_atendimento'];
            $vetret['hora_inicio'] = $_POST['hora_inicio'];
            $vetret['hora_intervalo_inicio'] = $_POST['hora_intervalo_inicio'];
            $vetret['hora_intervalo_fim'] = $_POST['hora_intervalo_fim'];
            $vetret['hora_fim'] = $_POST['hora_fim'];
            $vetret['dt_inicial'] = $_POST['dt_inicial'];
            $vetret['dt_final'] = $_POST['dt_final'];
            $vetret['data_aleatoria'] = $_POST['data_aleatoria'];
            $vetret['idt_servico'] = $_POST['idt_servico'];
            $vetret['observacao'] = $_POST['observacao'];

            if ($executa == 'Gera') {

                //		echo " idt_atendimento_gera_agenda = $idt_atendimento_gera_agenda ";


                $ret = CarregarAgendaExistente($idt_atendimento_gera_agenda, $vetret);

                echo " retorno = $ret ";



                if ($ret == 0) {
                    // nada encontrado
                } else {

                    // Perguntar algo
                    echo '
                <script type="text/javascript">
                    //alert("Apresentar a Questão e perguntar!");
					
					var r = confirm("Para o Periodo informado Existem Registros na sua Agenda."+"\n"+"Deseja Continuar essa Operação?!");
					if (r == false) {
						// Parar a OPERAção - Desistir e voltar a tela sem fazer nada.
						location.reload();
					} else {
					    // Agora perguntar se deseja apagar ou não
						var r = confirm("Deseja Apagar os Existentes e criar NOVOS com a parametrização informada agora?."+"\n"+"Atenção!\nSe confirmar os Existentes e DISPONIVEL serão apagados. Confirma?");
						if (r == true) {
							// apagar os existentes
						} else {
							// Prosseguir como é Hoje
						}
					}
					
                    
                </script>
				';
                    p($vetret);
                    exit();
                }
            }
        }
        break;

    case 'grc_evento_publicacao':
        if ($_POST['situacao_ant'] != $_POST['situacao']) {
            $_POST['idt_usuario_situacao'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_situacao'] = getdata(true, true, true);
        }

        if ($_POST['situacao_ant'] == 'Despublicar') {
            $sql = '';
            $sql .= ' select *';
            $sql .= ' from grc_evento_publicacao';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsqlNomeCol($sql);
            $row = $rs->data[0];

            $_POST['tipo_acao'] = 'D';

            $row['tipo_acao'] = 'D';

            $_POST['idt_responsavel'] = $_SESSION[CS]['g_id_usuario'];
            $_POST['data_responsavel'] = getdata(true, true, true);

            $row['idt_responsavel'] = $_POST['idt_responsavel'];
            $row['data_responsavel'] = trata_data($_POST['data_responsavel']);

            $row['idt_usuario_situacao'] = $_POST['idt_usuario_situacao'];
            $row['data_situacao'] = trata_data($_POST['data_situacao']);

            unset($row['idt']);

            $row = array_map('aspa', $row);

            $sql = 'insert into ' . db_pir_grc . 'grc_evento_publicacao (' . implode(', ', array_keys($row)) . ') values (' . implode(', ', $row) . ')';
            execsql($sql);
            $vlID = lastInsertId();
            $_POST['id'] = $vlID;
            $_GET['id'] = $vlID;
            $vetID['grc_evento_publicacao'] = $vlID;
        }
    //break;

    case 'grc_evento_publicacao_cupom':
        //Libera a Qtd. de Cupons do Cupom Anterior
        if ($vetID['grc_evento_publicacao_cupom'] != '') {
            $vetErro = operacaoEventoCupom($vetID['grc_evento_publicacao_cupom'], FALSE);

            if (count($vetErro) > 0) {
                $erro = implode('<br />', $vetErro);
                msg_erro($erro);
            }
        }

        if ($_POST['qtd_disponivel'] == '') {
            $_POST['qtd_disponivel'] = 0;
        }

        if ($_POST['qtd_utilizada'] == '') {
            $_POST['qtd_utilizada'] = 0;
        }
        break;

    case 'grc_evento_publicacao_voucher':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                $sql = '';
                $sql .= ' select codigo';
                $sql .= ' from grc_evento_tipo_voucher';
                $sql .= ' where idt = ' . null($_POST['idt_tipo_voucher']);
                $rs = execsql($sql);
                $tipo_voucher = 'V' . $rs->data[0][0];

                if ($tipo_voucher == 'VB') {
                    //Desbloquea a Qtd. Vagas no Evento
                    $vetErro = operacaoVoucherVaga($vlID, FALSE);

                    if (count($vetErro) > 0) {
                        $erro = implode('<br />', $vetErro);
                        msg_erro($erro);
                    }
                }
                break;
        }
        break;

    case 'grc_evento_publicacao_voucher_registro':
        //Desbloquea a Qtd. Vagas no Evento
        $vetErro = operacaoVoucherVaga($_POST['idt_evento_publicacao_voucher'], FALSE);

        if (count($vetErro) > 0) {
            $erro = implode('<br />', $vetErro);
            msg_erro($erro);
        }
        break;

    case 'grc_evento_mapa':
        $sql = '';
        $sql .= ' select *';
        $sql .= ' from grc_evento_mapa';
        $sql .= ' where idt = ' . null($vlID);
        $rs = execsql($sql);
        $rowDadosAnt = $rs->data[0];

        if ($rowDadosAnt['idt_local_pa_mapa'] != $_POST['idt_local_pa_mapa']) {
            $sql = '';
            $sql .= ' select descricao, detalhe, assento_mapa';
            $sql .= ' from grc_evento_local_pa_mapa';
            $sql .= ' where idt = ' . null($_POST['idt_local_pa_mapa']);
            $rs = execsql($sql);
            $row = $rs->data[0];

            $_POST['descricao'] = $row['descricao'];
            $_POST['detalhe'] = $row['detalhe'];
            $_POST['assento_mapa'] = $row['assento_mapa'];
        }
        break;

    case 'grc_evento_cupom':
        if ($_POST['qtd_resevada'] == '') {
            $_POST['qtd_resevada'] = 0;
        }

        if ($_POST['qtd_utilizada'] == '') {
            $_POST['qtd_utilizada'] = 0;
        }
        break;
		
	case 'grc_atendimento_especialidade':
        $data_despublicar = trata_data($_POST['data_despublicar']);
        $hora_despublicar = $_POST['hora_despublicar'];
		$despublica = $_POST['despublica'];
		$msg   = "";
		if ($despublica=='S')
		{
		    
			$sql = '';
			$sql .= ' select distinct grc_aa.idt_consultor, plu_usu.nome_completo  ';
			$sql .= ' from grc_atendimento_agenda grc_aa ';
			$sql .= ' inner join plu_usuario plu_usu on plu_usu.id_usuario =  grc_aa.idt_consultor';
			$sql .= ' where ';
			$sql .= '   ( grc_aa.data = ' . aspa($data_despublicar) . ' and grc_aa.hora >  ' . aspa($hora_despublicar) . ' )';
			$sql .= '   or ( grc_aa.data > ' . aspa($data_despublicar) . ' )';
			$rs = execsql($sql);
			//p($sql);
			if ($rs->rows>0)
			{ // Tem Agenda e não pode ter - mensagem
			    $consultores="<table>";
		        ForEach ($rs->data as $row) {
				    $idt_consultor = $row['idt_consultor'];
					$nome_completo = $row['nome_completo'];
					$consultores.="<tr>";
					$consultores.="<td>";
					$consultores.=$nome_completo;
					$consultores.="</td>";
					$consultores.="</tr>";
				}
				$consultores.="</table>";
              $msg  .=    "  Data da Despublicação ".$_POST['data_despublicar']." Hora: ".$_POST['hora_despublicar']; 
			  $msg  .= "<br /><br />"."  Existem Agendas com Datas Posteriores a da Despublicação para os Consultores: ";
			  $msg  .= "<br /><br />".$consultores;
			  
			  $vetMsg=Array();
			  $vetMsg['titulo'] = "Despublicação de Serviço";
			  $vetMsg['msg']    = $msg;
			  msg_CriticaConsiste($vetMsg);
			}
        }
		break;
		
		case 'grc_atendimento_gera_agenda':
			$executa      = ($_POST['executa']);
			$idt_servico  = ($_POST['idt_servico']);
			$dt_inicial   = trata_data($_POST['dt_inicial']);
			$dt_final     = trata_data($_POST['dt_final']);
			$hora_inicio  = ($_POST['hora_inicio']);
			$hora_fim     = ($_POST['hora_fim']);
			$msg          = "";
			
			if ($executa=="Gera")
			{
			    $vet = explode(',',$idt_servico);
	            $msg .= "<br />Solicitação não esta em conformidade com Serviços - Despublicação"; 
				$temerro = 0;
				ForEach ($vet as $idx => $Valor) {
				   $idt_servico = str_replace('S','',$Valor);
				   if ($idt_servico>0)
				   {
						$sql  = '';
						$sql .= ' select grc_ae.despublica, grc_ae.data_despublicar, grc_ae.hora_despublicar, grc_ae.descricao  ';
						$sql .= ' from grc_atendimento_especialidade grc_ae ';
						$sql .= ' where ';
						$sql .= '   grc_ae.idt = ' . null($idt_servico) ;
						$rs = execsql($sql);
						

						if ($rs->rows>0)
						{   // Serviço Encontrado
						
							ForEach ($rs->data as $row) {
							    $descricao        = $row['descricao'];
								$despublica       = $row['despublica'];
								$data_despublicar = ($row['data_despublicar']);
								$hora_despublicar = $row['hora_despublicar'];
								if ($despublica=='S')
								{
								    
							        if ($dt_final<$data_despublicar)
									{
                                        // Esta ok
									}
									else
									{
										if ($dt_final=$data_despublicar and $hora_fim < $hora_despublicar)
										{
											// Esta ok
										}
										else
										{  // Erro
										   $msg .= "<br /><br />Solicitada Agenda no intervalo de {$_POST['dt_inicial']} {$_POST['hora_inicio']} até {$_POST['dt_final']} {$_POST['hora_fim']} ";
										   $dtd = trata_data($row['data_despublicar']);
										   $msg .= "<br /><br />Serviço: {$descricao} com Data para Despublicação em {$dtd} {$row['horadespublicar']}";
										   $temerro = 1;
                                        } 
									}
								
								
								}
								
								
								
								
							}
						}
	                }					
			    }
			}	
			
			if ($temerro==1)
			{
				$vetMsg=Array();
				$vetMsg['titulo'] = "Gerar Agenda - Serviços com Despublicação ";
				$vetMsg['msg']    = $msg;
				msg_CriticaConsiste($vetMsg);

			
			}

        break;
		
		
		
}
