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

switch ($menu) {
    case 'plu_funcao':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:
                $sql = 'update plu_direito_funcao set descricao = null';
                $sql .= ' where id_funcao = ' . null($vlID);
                $sql .= ' and id_direito = ' . null($rowt['id_direito']);
                execsql($sql);

                $sql = '';
                $sql .= ' select d.id_direito';
                $sql .= ' from plu_direito d';
                $sql .= " where d.desc_funcao = 'S'";
                $rst = execsql($sql);

                foreach ($rst->data as $rowt) {
                    $sql = 'update plu_direito_funcao set descricao = ' . aspa($_POST['desc_funcao_' . $rowt['id_direito']]);
                    $sql .= ' where id_funcao = ' . null($vlID);
                    $sql .= ' and id_direito = ' . null($rowt['id_direito']);
                    execsql($sql);
                }

                break;
        }
        break;

    case 'plu_perfil':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:
                $sql = 'delete from plu_direito_perfil where id_perfil = ' . $vlID;
                $result = execsql($sql);

                ForEach (explode(',', $_POST['id_difu']) as $chave) {
                    if ($chave != '') {
                        $sql = 'insert into plu_direito_perfil (
            						id_perfil,
            						id_difu
            				    ) values (
            						' . $vlID . ',
            						' . $chave . '
            				    )';
                        $result = execsql($sql);
                    }
                }

                carregaSession();
                break;
        }
        break;

    case 'plu_site_perfil':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:



                $sql = 'delete from plu_site_direito_perfil where id_perfil = ' . $vlID;
                $result = execsql($sql);

                ForEach (explode(',', $_POST['id_difu']) as $chave) {
                    if ($chave != '') {
                        $sql = 'insert into plu_site_direito_perfil (
            						id_perfil,
            						id_difu
            				    ) values (
            						' . $vlID . ',
            						' . $chave . '
            				    )';
                        $result = execsql($sql);
                    }
                }
                break;
        }
        break;

    case 'plu_senha':
        $_SESSION[CS]['g_senha_antiga'] = md5($_POST['senha']);
        WSsincronizarSenha($_POST['login'], md5($_POST['senha']));
        echo "<script type='text/javascript'>alert('Senha alterada com sucesso!');</script>";
        break;

    case 'plu_email_adm':
        Require_Once('PHPMailer/class.phpmailer.php');
        Require_Once('PHPMailer/class.smtp.php');

        $mail = new PHPMailer();
        $mail->SetLanguage('br', 'PHPMailer/');

        $mail->IsSMTP();
        $mail->Host = $vetConf['host_smtp'];
        $mail->Port = $vetConf['port_smtp'];
        $mail->Username = $vetConf['login_smtp'];
        $mail->Password = $vetConf['senha_smtp'];
        $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
        $mail->SMTPSecure = $vetConf['smtp_secure'];

        $mail->From = $_POST['email'];
        $mail->FromName = $_SESSION[CS]['g_nome_completo'];
        $mail->Subject = "[$sigla_site] " . $_POST['assunto'];
        $mail->Body = $_POST['mensagem'];
        $mail->AltBody = $_POST['mensagem'];
        $mail->IsHTML(true);

        $mail->AddAddress($vetConf['email_site'], $nome_site);

        $mail->Send();
        break;

    case 'plu_usuario':
        if ($_POST['btnAcao'] == $bt_salvar_lbl) {
// modificar nos outros sistemas  
//ajustar_login($vlID);
//
            // Mandar e-mail
//
            Require_Once('PHPMailer/class.phpmailer.php');
            Require_Once('PHPMailer/class.smtp.php');

            $mail = new PHPMailer();
            $mail->SetLanguage('br', 'PHPMailer/');

            $mail->IsSMTP();
            $mail->Host = $vetConf['host_smtp'];
            $mail->Port = $vetConf['port_smtp'];
            $mail->Username = $vetConf['login_smtp'];
            $mail->Password = $vetConf['senha_smtp'];
            $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
            $mail->SMTPSecure = $vetConf['smtp_secure'];

            $destino_email = $_POST['email'];
            $destino_nome = $_POST['nome_completo'];

            $mail->From = $vetConf['email_envio'];
            $mail->FromName = $nome_site;

            $mail->AddReplyTo($vetConf['email_site'], $nome_site);

            $assunto = 'Login e Senha para acesso ao sistema';

            $mensagem = 'Caro ' . $destino_nome . ',' . '<br /><br />';
            $mensagem .= 'Cadastramos no GEC seus dados para acesso conforme segue:' . '<br /><br />';

            $Vetlogin = Array();
            $Vetlogin = explode('@', $_POST['login']);
            $login = $Vetlogin[0];
            $mensagem .= '<b>';
            $mensagem .= 'Login        : ' . $login . '' . '<br />';
            $mensagem .= 'Senha Inicial: ' . $vetConf['senha_padrao'] . '' . '<br /><br />';
            $mensagem .= '</b>';

            $mensagem .= 'Por segurança, no seu primeiro acesso <b>altere imediatamente a senha INICIAL</b>.' . '<br /><br />';

            $mensagem .= 'Atenciosamente,' . '<br />';
            $mensagem .= 'Setor de Controle de Credenciamentos' . '<br /><br />';


            $mail->Subject = "[$sigla_site] " . $assunto;
            $mail->Body = $mensagem;
            $mail->AltBody = $mensagem;
            $mail->IsHTML(true);

            $mail->AddAddress($destino_email, $destino_nome);

            $mail->Send();

            try {
                if ($mail->Send()) {
                    $kokw = 1;
//   echo "<script type='text/javascript'>alert('Enviado com sucesso!');</script>";
                } else {
                    $kokw = 0;
                    echo "<script type='text/javascript'>alert('Erro na transmissão do e_mail de Login.\\nTente outra vez!\\n\\n" . trata_aspa($mail->ErrorInfo) . "');</script>";
                }
            } catch (PDOException $e) {
                
            }
        }

        carregaSession();
        break;

    case 'grc_usuario':
        carregaSession();
        break;

    case 'grc_competencia':
        carregaSession();
        break;

    case 'grc_atendimento_pa_pessoa':
    case 'grc_atendimento_pa_pessoa_par':
        carregaSession();
        if ($menu == 'grc_atendimento_pa_pessoa') {
            if ($acao == 'inc' or $acao == 'alt') {
                CalculaMediaAtendimento($vlID);
            }
        }
        break;

    case 'cbo_importacao':
        if ($acao == 'inc' or $acao == 'alt') {
            $idt_importacao = $vlID;
            $executa = $_POST['executa'];
            $sql_a = ' update cbo_importacao set ';
            $sql_a .= ' executa   = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($vlID);
            $result = execsql($sql_a);
            if ($executa == 'E') {
//    $kokw = ExcluiImportacao_CBO($idt_lote);
            }
            if ($executa == 'S') {
                $kokw = ExecutaImportacao_CBO($idt_importacao);
            } else {
                
            }
        }
        break;

    case 'cnae_importacao':
        if ($acao == 'inc' or $acao == 'alt') {
            $idt_importacao = $vlID;
            $executa = $_POST['executa'];
            $sql_a = ' update cnae_importacao set ';
            $sql_a .= ' executa   = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($vlID);
            $result = execsql($sql_a);
            if ($executa == 'E') {
//    $kokw = ExcluiImportacao_CBO($idt_lote);
            }
            if ($executa == 'S') {
                $kokw = ExecutaImportacao_CNAE($idt_importacao);
            } else {
                
            }
        }
        break;

    case 'gec_entidade_cnae':
        if ($acao == 'inc' or $acao == 'alt') {
            $gec_entidade_cnae = $vlID;
            $idt_entidade = $_POST['idt_entidade'];
            $principal = $_POST['principal'];
            if ($principal == 'S') {
                $sql_a = ' update gec_entidade_cnae set ';
                $sql_a .= ' principal  = ' . aspa('N') . '  ';
                $sql_a .= ' where idt_entidade      = ' . null($idt_entidade);
                $sql_a .= '   and idt <> ' . null($gec_entidade_cnae);
                $result = execsql($sql_a);
            }
        }
        break;

    case 'gec_organizacao_natureza_juridica_importacao':
        if ($acao == 'inc' or $acao == 'alt') {
            $idt_importacao = $vlID;
            $executa = $_POST['executa'];
            $sql_a = ' update gec_organizacao_natureza_juridica_importacao set ';
            $sql_a .= ' executa   = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($vlID);
            $result = execsql($sql_a);
            if ($executa == 'E') {
//    $kokw = ExcluiImportacao_CBO($idt_lote);
            }
            if ($executa == 'S') {
                $kokw = ExecutaImportacao_NaturezaJuridica($idt_importacao);
            } else {
                
            }
        }
        break;

    case 'plu_painel_grupo':
        switch ($_POST['btnAcao']) {
            case $bt_alterar_lbl:
                $ordena = false;
                $vetCampoAlt = Array('mostra_item', 'texto_altura', 'img_altura', 'img_largura', 'img_margem_dir', 'img_margem_esq', 'espaco_linha');

                foreach ($vetCampoAlt as $campo) {
                    if ($row_painel_ant[$campo] != $_POST[$campo]) {
                        $ordena = true;
                    }
                }

                if ($row_painel_ant['layout_grid'] != $_POST['layout_grid'] && $_POST['layout_grid'] == 'S') {
                    $ordena = true;
                }

                if ($ordena) {
                    $cont_largura = $_POST['img_largura'] + $_POST['img_margem_dir'] + $_POST['img_margem_esq'];
                    $cont_altura = 0;

                    if ($_POST['mostra_item'] == 'IT' || $_POST['mostra_item'] == 'SI') {
                        $cont_altura += $_POST['img_altura'];
                    }

                    if ($_POST['mostra_item'] == 'IT' || $_POST['mostra_item'] == 'ST') {
                        $cont_altura += $_POST['espaco_linha'];
                    }

                    if ($_POST['layout_grid'] == 'S') {
                        $cont_altura += $_POST['texto_altura'];
                    }

                    $limite_largura = floor(870 / $cont_largura) * $cont_largura;
                    $pos_top = 0;
                    $pos_left = 0;

                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from plu_painel_funcao';
                    $sql .= ' where idt_painel_grupo = ' . null($vlID);
                    $sql .= ' order by pos_top, pos_left';
                    $rs = execsql($sql);

                    foreach ($rs->data as $row) {
                        $sql = 'update plu_painel_funcao set pos_top=' . null($pos_top) . ', pos_left=' . null($pos_left);
                        $sql .= ' where idt = ' . null($row['idt']);
                        execsql($sql);

                        $pos_left += $cont_largura;

                        if ($pos_left >= $limite_largura) {
                            $pos_top += $cont_altura;
                            $pos_left = 0;
                        }
                    }
                }
                break;
        }
        break;

    case 'gec_entidade':

        if ($idt_etapa_candidato > 0) {
            $sql_a = ' update gec_edital_processo_etapa_candidato set ';
            $sql_a .= ' idt_entidade   = ' . null($vlID);
            $sql_a .= ' where idt = ' . null($idt_etapa_candidato);
            $result = execsql($sql_a);
        }
        break;



    case 'grc_produto_receita':
    case 'grc_produto_insumo':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_insumo']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_insumo';
                $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
                $sql .= ' and idt_insumo = ' . null($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $participante_minimo = Troca($_POST['participante_minimo'], '', 0);
                    $participante_maximo = Troca($_POST['participante_maximo'], '', 0);
                    $por_participante = Troca($dados['por_participante'], '', 'N');

                    if ($por_participante == "N") {
                        $participante_minimo = 1;
                        $participante_maximo = 1;
                    }

                    $custo_unitario_real = Troca(desformat_decimal($dados['custo_unitario_real']), '', 0);
                    $quantidade = 0;

                    $custo_total = 0;
                    $receita_total = 0;

                    $ctotal_minimo = 0;
                    $ctotal_maximo = 0;

                    $rtotal_minimo = 0;
                    $rtotal_maximo = 0;

                    if ($participante_minimo == 0) {
                        $participante_minimo = 1;
                    }
                    if ($participante_maximo == 0) {
                        $participante_maximo = 1;
                    }

                    if ($_POST['veio'] == 'R') {
                        $receita_total = $quantidade * $custo_unitario_real;
                        $rtotal_minimo = $participante_minimo * $receita_total;
                        $rtotal_maximo = $participante_maximo * $receita_total;
                    } else {
                        $custo_total = $quantidade * $custo_unitario_real;
                        $ctotal_minimo = $participante_minimo * $custo_total;
                        $ctotal_maximo = $participante_maximo * $custo_total;
                    }

                    $sql = 'insert into grc_produto_insumo (idt_produto, idt_insumo, detalhe, ativo,';
                    $sql .= ' custo_unitario_real, idt_insumo_unidade, por_participante, quantidade,';
                    $sql .= ' custo_total, ctotal_minimo, ctotal_maximo, rtotal_minimo, rtotal_maximo, receita_total,';
                    $sql .= ' idt_area_suporte';
                    $sql .= ') values (';
                    $sql .= null($_POST['idt_produto']) . ', ' . null($dados['idt']) . ', ' . aspa($dados['detalhe']) . ', ' . aspa($dados['ativo']) . ', ';
                    $sql .= null($custo_unitario_real) . ', ' . null($dados['idt_insumo_unidade']) . ', ' . aspa($dados['por_participante']) . ', ' . null($quantidade) . ', ';
                    $sql .= null($custo_total) . ', ' . null($ctotal_minimo) . ', ' . null($ctotal_maximo) . ', ' . null($rtotal_minimo) . ', ' . null($rtotal_maximo) . ', ' . null($receita_total) . ', ';
                    $sql .= null($dados['idt_area_suporte']) . ')';
                    execsql($sql);
                }
            }
        }

        if ($acao != 'con') {
            $idt_produto = $_POST['idt_produto'];
            CalcularInsumoProduto($idt_produto);
        }
        break;

    case 'grc_evento_publicar':
        if ($_POST['id'] == 0) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sel_trab'];

            if ($_POST['despublicar'] == 'S') {
                foreach ($vetSel as $idx => $dados) {
                    $sql = "update grc_evento set publica_internet = 'N'";
                    $sql .= ' where idt = ' . null($dados['idt']);
                    execsql($sql, false);

                    grava_log_sis('grc_evento', 'R', $dados['idt'], 'Despublicação do Evento');
                }
            } else {
                $vetUnidade = Array();
                $vetUnidadeNome = Array();

                foreach ($vetSel as $idx => $dados) {
                    $vetUnidade[$dados['idt_unidade']][] = $dados;
                    $vetUnidadeNome[$dados['idt_unidade']] = $dados['unidade'];
                }

                if (count($vetUnidade) > 0) {
                    $codigo = geraAutoNum(db_pir_grc, 'grc_evento_publicar', 10);
                    $dt_registro = trata_data(date('d/m/Y H:i:s'), true);

                    foreach ($vetUnidade as $idt_unidade => $vetEvento) {
                        $vetIdtEvento = Array();
                        $vetLogDetalheTmp = Array();

                        $vetLogDetalheTmp['codigo'] = Array(
                            'campo_desc' => 'Código',
                            'vl_atu' => '',
                            'desc_atu' => $codigo,
                        );

                        $vetLogDetalheTmp['idt_unidade'] = Array(
                            'campo_desc' => 'Unidade/Escritório',
                            'vl_atu' => $idt_unidade,
                            'desc_atu' => $vetUnidadeNome[$idt_unidade],
                        );

                        $vetLogDetalheTmp['dt_registro'] = Array(
                            'campo_desc' => 'Data do Registro',
                            'vl_atu' => '',
                            'desc_atu' => trata_data($dt_registro),
                        );

                        $vetLogDetalheTmp['situacao'] = Array(
                            'campo_desc' => 'Situação',
                            'vl_atu' => 'AA',
                            'desc_atu' => $vetEventoPubilcar['AA'],
                        );

                        $vetLogDetalheTmp['idt_responsalvel'] = Array(
                            'campo_desc' => 'Responsável',
                            'vl_atu' => $_SESSION[CS]['g_id_usuario'],
                            'desc_atu' => $_SESSION[CS]['g_nome_completo'],
                        );

                        $vetLogDetalheTmp['data_publicacao_de'] = Array(
                            'campo_desc' => 'Publicar De',
                            'vl_atu' => '',
                            'desc_atu' => $_POST['data_publicacao_de'],
                        );

                        $vetLogDetalheTmp['data_publicacao_ate'] = Array(
                            'campo_desc' => 'Publicar  Até',
                            'vl_atu' => '',
                            'desc_atu' => $_POST['data_publicacao_ate'],
                        );

                        $vetLogDetalheTmp['data_hora_fim_inscricao_ec'] = Array(
                            'campo_desc' => 'Data Fim inscrição loja Virtual',
                            'vl_atu' => '',
                            'desc_atu' => $_POST['data_hora_fim_inscricao_ec'],
                        );

                        $sql = 'insert into grc_evento_publicar (codigo, idt_unidade, dt_registro, idt_responsalvel,';
                        $sql .= ' data_publicacao_de, data_publicacao_ate, data_hora_fim_inscricao_ec) values (';
                        $sql .= aspa($codigo) . ', ' . null($idt_unidade) . ', ' . aspa($dt_registro) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ';
                        $sql .= aspa(trata_data($_POST['data_publicacao_de'])) . ', ' . aspa(trata_data($_POST['data_publicacao_ate'])) . ', ' . aspa(trata_data($_POST['data_hora_fim_inscricao_ec'])) . ')';
                        execsql($sql);
                        echo "'" . $sql . "'<br />";
                        $idt_evento_publicar = lastInsertId();

                        foreach ($vetEvento as $row) {
                            $vetIdtEvento[] = $row['idt'];

                            $vetLogDetalheTmp['idt_evento_' . $row['idt']] = Array(
                                'campo_desc' => 'Evento: [' . $row['codigo'] . '] ' . $row['descricao'],
                                'vl_atu' => 'AA',
                                'desc_atu' => $vetEventoPubilcarRegistro['AA'],
                            );

                            $sql = 'insert into grc_evento_publicar_evento (idt_evento_publicar, idt_evento) values (';
                            $sql .= null($idt_evento_publicar) . ', ' . null($row['idt']) . ')';
                            execsql($sql);
                        }

                        $des_registro = $codigo . ', ' . $vetUnidadeNome[$idt_unidade];
                        grava_log_sis_banco(db_pir_grc, 'grc_evento_publicar', 'I', $idt_evento_publicar, $des_registro, '', '', $vetLogDetalheTmp, false);

                        //Abre Pendencia para o CG do Evento
                        $vetIdtEvento[] = 0;

                        $sql = '';
                        $sql .= " select e.idt_instrumento, e.idt_unidade, e.idt_ponto_atendimento, s.classificacao";
                        $sql .= ' from grc_evento e';
                        $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = e.idt_unidade';
                        $sql .= ' where e.idt in (' . implode(', ', $vetIdtEvento) . ')';
                        $rs = execsql($sql);

                        $vetPEN = Array();

                        foreach ($rs->data as $row) {
                            $vetCG = CoordenadorGerenteDiretorEvento('CG', $row['idt_instrumento'], $row['idt_unidade'], $row['idt_ponto_atendimento'], $row['classificacao'], 0);
                            $vetPEN = array_merge($vetPEN, $vetCG);
                        }

                        $vetPEN = array_unique($vetPEN);

                        $vetDados = Array(
                            'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                            'protocolo' => $codigo,
                            'tipo' => 'Publicação de Eventos',
                            'status' => 'Aprovação',
                            'observacao' => 'Para eventos da unidade ' . $vetUnidadeNome[$idt_unidade],
                            'idt_responsavel_unidade_lotacao' => $idt_unidade,
                            'idt_evento_publicar' => $idt_evento_publicar,
                            'situacao_de' => 'AA',
                        );

                        foreach ($vetPEN as $idt_usuario_solucao) {
                            gravaPendenciaGRC($idt_usuario_solucao, $vetDados);
                        }
                    }
                }
            }

            $_SESSION[CS]['objListarCmbMulti'][$_GET['session_cod']]['sel_trab'] = Array();
        } else {
            //Fecha a Pendencia em Aberto
            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " situacao_para = " . aspa($_POST['situacao']) . ",";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_publicar  = ' . null($vlID);
            $sql_a .= " and ativo = 'S'";
            $sql_a .= " and tipo = 'Publicação de Eventos'";
            execsql($sql_a);

            if ($_POST['situacao'] == 'FR') {
                //Abre pendencia de Aviso de Reprovado

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where idt = ' . null($_POST['idt_unidade']);
                $rs = execsql($sql);

                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['codigo'],
                    'tipo' => 'Publicação de Eventos',
                    'status' => 'Finalizado com Reprovação',
                    'observacao' => 'Para eventos da unidade ' . $rs->data[0][0],
                    'idt_responsavel_unidade_lotacao' => $_POST['idt_unidade'],
                    'idt_evento_publicar' => $vlID,
                    'situacao_de' => $_POST['situacao'],
                );

                gravaPendenciaGRC($_POST['idt_responsalvel'], $vetDados);
            }
        }
        break;

    case 'gec_contratar_credenciado_distrato':
        $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade, prd.codigo as codigo_produto";
        $sql .= ' from ' . db_pir_grc . 'grc_evento grc_e';
        $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
        $sql .= ' left outer join ' . db_pir_grc . 'grc_produto prd on prd.idt = grc_e.idt_produto';
        $sql .= " where grc_e.idt  = " . null($rowDados['idt_evento']);
        $rs = execsql($sql);
        $rowe = $rs->data[0];

        $msgParametros = function ($txt, $protocolo, $rowe) {
            $txt = str_replace('#protocolo', $protocolo, $txt);
            $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

            $sql = '';
            $sql .= ' select nome_completo';
            $sql .= ' from ' . db_pir_grc . 'plu_usuario';
            $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
            $rs = execsql($sql);
            $txt = str_replace('#solicitante', $rs->data[0][0], $txt);

            $sql = '';
            $sql .= ' select nome_completo';
            $sql .= ' from ' . db_pir_grc . 'plu_usuario';
            $sql .= ' where id_usuario = ' . null($rowe['idt_gestor_evento']);
            $rs = execsql($sql);
            $txt = str_replace('#evento_responsavel', $rs->data[0][0], $txt);

            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
            $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
            $rs = execsql($sql);
            $txt = str_replace('#ponto_atendimento', $rs->data[0][0], $txt);

            $txt = str_replace('#codigo', $rowe['codigo'], $txt);

            $sql = '';
            $sql .= ' select desccid';
            $sql .= ' from ' . db_pir_siac . 'cidade';
            $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
            $rs = execsql($sql);
            $txt = str_replace('#cidade', $rs->data[0][0], $txt);

            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from ' . db_pir_grc . 'grc_evento_local_pa';
            $sql .= ' where idt = ' . null($rowe['idt_local']);
            $rs = execsql($sql);
            $txt = str_replace('#local', $rs->data[0][0], $txt);

            $sql = '';
            $sql .= ' select descricao';
            $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
            $sql .= ' where idt = ' . null($_POST['situacao']);
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
                $sql .= ' where idt = ' . null($rowe['idt_evento_situacao']);
                $rs = execsql($sql);
            }

            $txt = str_replace('#situacao', $rs->data[0][0], $txt);

            $txt = str_replace('#instrumento', $rowe['instrumento'], $txt);
            $txt = str_replace('#descricao', $rowe['descricao'], $txt);
            $txt = str_replace('#dt_previsao_inicial', trata_data($rowe['dt_previsao_inicial']), $txt);
            $txt = str_replace('#dt_previsao_fim', trata_data($rowe['dt_previsao_fim']), $txt);
            $txt = str_replace('#hora_inicio', $rowe['hora_inicio'], $txt);
            $txt = str_replace('#hora_fim', $rowe['hora_fim'], $txt);
            $txt = str_replace('#observacao', $rowe['observacao'], $txt);
            $txt = str_replace('#previsao_receita', format_decimal($rowe['previsao_receita']), $txt);
            $txt = str_replace('#previsao_despesa', format_decimal($rowe['previsao_despesa']), $txt);

            return $txt;
        };

        $vetGEC_parametros = Array();

        $sql = '';
        $sql .= ' select *';
        $sql .= ' from ' . db_pir_gec . 'gec_parametros';
        $sql .= " where codigo in ('distrato_ap_01', 'distrato_ap_02', 'distrato_ap_03', 'distrato_ap_04', 'distrato_ap_05', 'distrato_ap_06', 'distrato_ap_07', 'distrato_ap_08')";
        $rs = execsql($sql);

        ForEach ($rs->data as $row) {
            $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
            $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");

            $vetGEC_parametros[$codigo] = $detalhe;
        }

        if ($_POST['btnAcao'] != 'Excluir') {
            calculaValorDistratoDevolucao($vlID, desformat_decimal($_POST['valor_total']));

            if (is_array($_POST['distrato_entrega'])) {
                $vetRegistro = Array();

                foreach ($_POST['distrato_entrega'] as $idt => $row) {
                    $vetRegistro[] = $idt;

                    if ($row['vl_executado'] == '') {
                        $row['vl_executado'] = 0;
                    }

                    if ($row['perc_executado'] == '') {
                        $row['perc_executado'] = 0;
                    }

                    $sql = '';
                    $sql .= ' select vl_executado, perc_executado';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega';
                    $sql .= ' where idt_distrato = ' . null($vlID);
                    $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($idt);
                    $rs = execsql($sql);
                    $rowAnt = $rs->data[0];

                    if ($rs->rows == 0) {
                        $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega (';
                        $sql .= ' idt_distrato, idt_gec_contratacao_credenciado_ordem_entrega, vl_executado, perc_executado';
                        $sql .= ') values (';
                        $sql .= null($vlID) . ', ' . null($idt) . ', ' . null(desformat_decimal($row['vl_executado'])) . ', ' . null(desformat_decimal($row['perc_executado']));
                        $sql .= ')';
                        execsql($sql);
                    } else {
                        $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega set';
                        $sql .= ' vl_executado = ' . null(desformat_decimal($row['vl_executado'])) . ', ';
                        $sql .= ' perc_executado = ' . null(desformat_decimal($row['perc_executado']));
                        $sql .= ' where idt_distrato = ' . null($vlID);
                        $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($idt);
                        execsql($sql);
                    }

                    $campoLog = 'entrega_' . $row['codigo'];
                    $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['campo_desc'] = 'Entrega ' . $row['codigo'];
                    $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['desc_ant'] = format_decimal($rowAnt['vl_executado']);
                    $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['desc_atu'] = format_decimal($row['vl_executado']);
                    $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['vl_ant'] = format_decimal($rowAnt['perc_executado'], 8);
                    $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['vl_atu'] = format_decimal($row['perc_executado'], 8);
                }

                if (count($vetRegistro) > 0) {
                    $sql = '';
                    $sql .= ' select ccde.idt_gec_contratacao_credenciado_ordem_entrega, ccde.vl_executado, ccde.perc_executado, orde.codigo';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega ccde';
                    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_entrega orde on orde.idt = ccde.idt_gec_contratacao_credenciado_ordem_entrega";
                    $sql .= ' where ccde.idt_distrato = ' . null($vlID);
                    $sql .= ' and ccde.idt_gec_contratacao_credenciado_ordem_entrega not in (' . implode(', ', $vetRegistro) . ')';
                    $rs = execsql($sql);

                    foreach ($rs->data as $rowAnt) {
                        $sql = 'delete from ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega';
                        $sql .= ' where idt_distrato = ' . null($vlID);
                        $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($rowAnt['idt_gec_contratacao_credenciado_ordem_entrega']);
                        execsql($sql);

                        $campoLog = 'entrega_' . $rowAnt['codigo'];
                        $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['campo_desc'] = 'Entrega ' . $rowAnt['codigo'];
                        $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['desc_ant'] = format_decimal($rowAnt['vl_executado']);
                        $vetLogDetalheExtra['gec_contratar_credenciado_distrato'][$campoLog]['vl_ant'] = format_decimal($rowAnt['perc_executado'], 8);
                    }
                }
            }
        }

        if ($_POST['bt_salva'] == '') {
            $sql_a = ' update ' . db_pir_gec . 'gec_contratar_credenciado_distrato_anexos set ';
            $sql_a .= " so_consulta = 'S'";
            $sql_a .= ' where idt_distrato  = ' . null($vlID);
            execsql($sql_a);

            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " situacao_para = " . aspa($_POST['situacao']) . ",";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_contratar_credenciado_distrato  = ' . null($vlID);
            $sql_a .= " and ativo = 'S'";
            $sql_a .= " and tipo = 'Aprovação do Distrato'";
            execsql($sql_a);

            //Devolvido para Ajuste
            if ($distrato_situacao == 'DE') {
                if ($rowDados['reg_origem'] == 'PFO') {
                    $sql = '';
                    $sql .= ' select nome_completo, login, email';
                    $sql .= ' from plu_usuario';
                    $sql .= ' where id_usuario = ' . null($rowDados['idt_responsavel']);
                    $rs = execsql($sql);
                    $rowUP = $rs->data[0];

                    $protocolo = date('dmYHis');

                    $assunto = $msgParametros($vetGEC_parametros['distrato_ap_03'], $protocolo, $rowe);
                    $mensagem = $msgParametros($vetGEC_parametros['distrato_ap_04'], $protocolo, $rowe);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'distrato_ap_0304',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                } else {
                    $vetDados = Array(
                        'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                        'protocolo' => $_POST['numero'],
                        'status' => 'Devolvido para Ajuste',
                        'tipo' => 'Aprovação do Distrato',
                        'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                        'idt_evento' => $rowDados['idt_evento'],
                        'idt_contratar_credenciado_distrato' => $vlID,
                        'situacao_de' => $distrato_situacao,
                    );

                    gravaPendenciaGRC($rowDados['idt_responsavel'], $vetDados);
                }
            }

            //Aguardando aprovação do Responsavel do Evento
            if ($distrato_situacao == 'RE') {
                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Distrato',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_distrato' => $vlID,
                    'situacao_de' => $distrato_situacao,
                );

                gravaPendenciaGRC($rowDados['idt_gestor_evento'], $vetDados);
            }

            //Aguardando aprovação do Gestor do Projeto
            if ($distrato_situacao == 'GP') {
                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Distrato',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_distrato' => $vlID,
                    'situacao_de' => $distrato_situacao,
                );

                gravaPendenciaGRC($rowDados['idt_gestor_projeto'], $vetDados);
            }

            //Aguardando aprovação do Coordenador/Gerente
            //Aguardando a aprovação do Diretor
            if ($distrato_situacao == 'CG' || $distrato_situacao == 'DI') {
                $idt_usuario_solucao = CoordenadorGerenteDiretorEvento($distrato_situacao, $rowDados['idt_instrumento'], $rowDados['idt_unidade'], $rowDados['idt_ponto_atendimento'], $rowDados['classificacao'], $rowDados['vl_cotacao'], true, db_pir_grc);

                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Distrato',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_distrato' => $vlID,
                    'situacao_de' => $distrato_situacao,
                );

                gravaPendenciaGRC($idt_usuario_solucao, $vetDados);
            }

            //Aprovação
            if ($distrato_situacao == 'AP') {
                set_time_limit(0);

                //Gera o PDF do Distrato
                $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, $pathObjFile . '/gec_contratar_credenciado_distrato_pdf/');

                if (!file_exists($pathPDF)) {
                    mkdir($pathPDF);
                }

                //Cliente
                $sql = '';
                $sql .= ' select a.idt';
                $sql .= " from " . db_pir_grc . "grc_atendimento a";
                $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = a.idt";
                $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $sql .= ' union all';
                $sql .= " select 'pst' as idt";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $contrato_pdf = $vlID . '.' . $row['idt'] . '_arq_distrato_' . $microtime . '_distrato.pdf';

                    $_POST['id'] = $vlID;
                    $_POST['idt_atendimento'] = $row['idt'];
                    salvaPDF($pathPDF . $contrato_pdf);

                    if (!file_exists($pathPDF . $contrato_pdf)) {
                        erro_try('Distrato em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                        echo '<script type="text/javascript">';
                        echo 'alert("Distrato em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                        echo 'self.location = "' . $pagina . '?' . $_SERVER['QUERY_STRING'] . '";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_distrato_pdf (idt_distrato, idt_atendimento, arq_distrato) values (';
                    $sql .= null($vlID) . ', ' . null($row['idt']) . ', ' . aspa($contrato_pdf) . ')';
                    execsql($sql);
                }

                //Ajusta informações do RM
                $vetErro = Array();

                try {
                    $SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');
                    $SoapSebraeRM_PR = new SoapSebraeRMGeral('wsProcess', true);

                    $sql = '';
                    $sql .= ' select orde.mesano, sum(ccde.vl_executado) as vl_distrato';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega orde';
                    $sql .= ' inner join ' . db_pir_gec . 'gec_contratar_credenciado_distrato_entrega ccde on ccde.idt_gec_contratacao_credenciado_ordem_entrega = orde.idt';
                    $sql .= ' where ccde.idt_distrato = ' . null($vlID);
                    $sql .= ' group by orde.mesano';
                    $rs = execsql($sql);

                    $vetVlDistrato = Array();

                    foreach ($rs->data as $row) {
                        $vetVlDistrato[$row['mesano']] = $row['vl_distrato'];
                    }

                    $sql = '';
                    $sql .= ' select rm.*';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                    $sql .= ' left outer join ' . db_pir_pfo . 'pfo_af_processo afp on afp.idmov = rm.rm_idmov';
                    $sql .= ' where rm.idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                    $sql .= " and rm.rm_cancelado = 'N'";
                    $sql .= " and (afp.situacao_reg is null or not ((afp.situacao_reg = 'FI' && afp.gfi_situacao = 'CB') || afp.situacao_reg = 'AP'))"; //liquidado
                    $rs = execsql($sql, false);

                    foreach ($rs->data as $row) {
                        $valor_real = $vetVlDistrato[$row['mesano_real']];

                        if ($row['valor_real_sem_atidivo'] == '') {
                            $sqlUP = ' valor_real_sem_atidivo = ' . $row['valor_real'] . ',';
                        } else {
                            $sqlUP = '';
                        }

                        $sql = 'update ' . db_pir_gec . ' gec_contratacao_credenciado_ordem_rm set';
                        $sql .= $sqlUP;
                        $sql .= ' valor_real = ' . $valor_real;
                        $sql .= ' where idt = ' . null($row['idt']);
                        execsql($sql);

                        if ($valor_real == 0) {
                            //Cancela o RM
                            if ($row['rm_idmov'] == '') {
                                $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                                $sql .= ' where idt = ' . null($row['idt']);
                                execsql($sql, false);
                            } else {
                                $funcao = 'ReadRecordAuth';

                                $parametro = Array(
                                    'DataServerName' => 'MovMovimentoTBCData',
                                    'PrimaryKey' => '1;' . $row['rm_idmov'],
                                    'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                );

                                $Z = Array('TMOV');

                                $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
                                $rowRM = $rsRM['TMOV']->data[0];

                                if ($rowRM['status'] != 'C') {
                                    $xml = '';
                                    $xml .= '<MovCancelMovProcParams>';
                                    $xml .= '<MovimentosACancelar>';
                                    $xml .= '<MovimentosCancelar>';
                                    $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                                    $xml .= '<CodColigada>1</CodColigada>';
                                    $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                                    $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                                    $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                                    $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                                    $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                                    $xml .= '<MotivoCancelamento>Distrato da Ordem de Contratação</MotivoCancelamento>';
                                    $xml .= '</MovimentosCancelar>';
                                    $xml .= '</MovimentosACancelar>';
                                    $xml .= '</MovCancelMovProcParams>';

                                    $metodo = 'ExecuteWithParams';

                                    $parametro = Array(
                                        'ProcessServerName' => 'MovCancelMovProc',
                                        'strXmlParams' => $xml,
                                    );

                                    $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                                    if ($retorno == '1') {
                                        $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                                        $sql .= ' where idt = ' . null($row['idt']);
                                        execsql($sql, false);
                                    } else {
                                        $erro = 'RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                                        $inf_extra = Array(
                                            'RM Erro' => $retorno,
                                            'parametro' => $parametro,
                                            'row' => $row,
                                        );

                                        $vetErro[] = $erro;

                                        erro_try($erro, 'aprovacao_distrato', $inf_extra);
                                    }
                                } else {
                                    $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                                    $sql .= ' where idt = ' . null($row['idt']);
                                    execsql($sql, false);
                                }
                            }
                        } else {
                            //Atualiza o RM
                            if ($row['rm_idmov'] != '') {
                                $funcao = 'ReadRecordAuth';

                                $parametro = Array(
                                    'DataServerName' => 'MovMovimentoTBCData',
                                    'PrimaryKey' => '1;' . $row['rm_idmov'],
                                    'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                );

                                $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                                try {
                                    $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
                                } catch (Exception $e) {
                                    $rsRM = $e->getMessage();
                                }

                                if (is_array($rsRM)) {
                                    $valor = str_replace(".", ",", $valor_real);

                                    $registro = Array();

                                    $registro['TMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'NSEQITMMOV' => '1',
                                        'NSEQITMMOV1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'PRECOUNITARIO' => $valor,
                                        'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOVRATCCU'] = Array(
				                        'CODCOLIGADA' => '1',
                                        'NSEQITMMOV' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'VALOR' => $valor,
                                        'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                                    );

                                    $parametro = Array(
                                        'DataServerName' => 'MovMovimentoTBCData',
                                        'Contexto' => 'codcoligada=1',
                                    );

                                    $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                                    $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                    if (substr($retorno, 0, 2) != '1;') {
                                        $retorno_org = $retorno;
                                        $i = strpos($retorno, '=======================================');
                                        if ($i !== FALSE) {
                                            $retorno = substr($retorno, 0, $i);
                                        }

                                        $erro = 'ERRO DO RM: ' . $retorno;

                                        $inf_extra = Array(
                                            'RM Erro' => $retorno_org,
                                            'Z' => $Z,
                                            'parametro' => $parametro,
                                            'registro' => $registro,
                                        );

                                        $vetErro[] = $erro;

                                        erro_try($erro, 'aprovacao_distrato', $inf_extra);
                                    }
                                } else {
                                    $erro = 'ERRO DO RM: ' . $rsRM;

                                    $inf_extra = Array(
                                        'funcao' => $funcao,
                                        'Z' => $Z,
                                        'parametro' => $parametro,
                                    );

                                    $vetErro[] = $erro;

                                    erro_try($erro, 'aprovacao_distrato', $inf_extra);
                                }
                            }
                        }
                    }

                    if (count($vetErro) > 0) {
                        $erroFinal = 'Erro na Aprovação do Distrato.<br />' . implode('<br />', $vetErro);

                        $sql = '';
                        $sql .= ' select idt, rm_idmov, valor_real_sem_atidivo';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                        $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                        $sql .= ' and valor_real_sem_atidivo is not null';
                        $rs = execsql($sql);

                        ForEach ($rs->data as $row) {
                            $valor_real = $row['valor_real_sem_atidivo'];

                            $funcao = 'ReadRecordAuth';

                            $parametro = Array(
                                'DataServerName' => 'MovMovimentoTBCData',
                                'PrimaryKey' => '1;' . $row['rm_idmov'],
                                'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                            );

                            $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                            try {
                                $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
                            } catch (Exception $e) {
                                $rsRM = $e->getMessage();
                            }

                            if (is_array($rsRM)) {
                                $valor = str_replace(".", ",", $valor_real);

                                $registro = Array();

                                $registro['TMOV'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'CODCOLIGADA1' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                                );

                                $registro['TITMMOV'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'CODCOLIGADA1' => '1',
                                    'NSEQITMMOV' => '1',
                                    'NSEQITMMOV1' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'PRECOUNITARIO' => $valor,
                                    'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                                );

                                $registro['TITMMOVRATCCU'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'NSEQITMMOV' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'VALOR' => $valor,
                                    'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                                );

                                $parametro = Array(
                                    'DataServerName' => 'MovMovimentoTBCData',
                                    'Contexto' => 'codcoligada=1',
                                );

                                $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                                $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                if (substr($retorno, 0, 2) != '1;') {
                                    $retorno_org = $retorno;
                                    $i = strpos($retorno, '=======================================');
                                    if ($i !== FALSE) {
                                        $retorno = substr($retorno, 0, $i);
                                    }

                                    $erro = 'ERRO DO RM: ' . $retorno;

                                    $inf_extra = Array(
                                        'RM Erro' => $retorno_org,
                                        'Z' => $Z,
                                        'parametro' => $parametro,
                                        'registro' => $registro,
                                    );

                                    erro_try($erro, 'aprovacao_distrato_erro', $inf_extra);
                                }
                            } else {
                                $erro = 'ERRO DO RM: ' . $rsRM;

                                $inf_extra = Array(
                                    'funcao' => $funcao,
                                    'Z' => $Z,
                                    'parametro' => $parametro,
                                );

                                erro_try($erro, 'aprovacao_distrato_erro', $inf_extra);
                            }
                        }

                        rollBack();
                        msg_erro($erroFinal);
                    }

                    //Gera devolução do cliente
                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from ' . db_pir_grc . 'grc_evento_participante_contadevolucao';
                    $sql .= ' where idt_contratar_credenciado_distrato = ' . null($vlID);
                    $sql .= ' and vl_devolucao > 0';
                    $rsd = execsql($sql, false);

                    foreach ($rsd->data as $rowd) {
                        //Tem codigo rm_codcfo
                        if ($rowd['rm_codcfo'] == '') {
                            if (substr($rowd['codigo'], 0, 2) == 'PR') {
                                $sql = '';
                                $sql .= ' select cpf';
                                $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
                                $sql .= ' where idt_atendimento = ' . null($rowd['idt_atendimento']);
                                $sql .= " and tipo_relacao = 'L'";
                                $rs = execsql($sql, false);
                                $cgccfo = FormataCPF14($rs->data[0][0]);
                            } else if (strlen($rowd['codigo']) > 14) {
                                $cgccfo = FormataCNPJ($rowd['codigo']);
                            } else {
                                $cgccfo = FormataCPF14($rowd['codigo']);
                            }

                            $parametro = Array(
                                'DataServerName' => 'FinCFODataBR',
                                'Filtro' => "codcoligada=1 and cgccfo = '" . $cgccfo . "'",
                                'Contexto' => 'codcoligada=1',
                            );
                            $rsRM = $SoapSebraeRM_DS->executa('ReadViewAuth', Array('FCFO'), $parametro, true);

                            $rowd['rm_codcfo'] = $rsRM['FCFO']->data[0]['codcfo'];

                            if ($rowd['rm_codcfo'] == '') {
                                if (strlen($rowd['codigo']) > 14 || substr($rowd['codigo'], 0, 2) == 'PR') {
                                    $pessoafisoujur = 'J';

                                    $sql = '';
                                    $sql .= ' select nome_fantasia as nomefantasia, razao_social as nome, logradouro_cep_e as cep, logradouro_endereco_e as rua, logradouro_numero_e as numero,';
                                    $sql .= ' logradouro_bairro_e as bairro, logradouro_cidade_e as cidade, logradouro_estado_e as codetd, email_e as email, logradouro_complemento_e as complemento,';
                                    $sql .= ' coalesce(telefone_comercial_e, telefone_celular_e) as telefone';
                                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_organizacao';
                                    $sql .= ' where idt_atendimento = ' . null($rowd['idt_atendimento']);
                                    $sql .= ' and cnpj = ' . aspa($rowd['codigo']);
                                } else {
                                    $pessoafisoujur = 'F';

                                    $sql = '';
                                    $sql .= ' select nome as nomefantasia, nome as nome, logradouro_cep as cep, logradouro_endereco as rua, logradouro_numero as numero,';
                                    $sql .= ' logradouro_bairro as bairro, logradouro_cidade as cidade, logradouro_estado as codetd, email as email, logradouro_complemento as complemento,';
                                    $sql .= ' coalesce(telefone_celular, telefone_residencial, telefone_recado) as telefone';
                                    $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa';
                                    $sql .= ' where idt_atendimento = ' . null($rowd['idt_atendimento']);
                                    $sql .= ' and cpf = ' . aspa($rowd['codigo']);
                                }

                                $rs = execsql($sql, false);
                                $rowDadosPess = $rs->data[0];

                                $cep = preg_replace('/[^0-9]/i', '', $rowDadosPess['cep']);

                                $sql = '';
                                $sql .= ' select codigo ';
                                $sql .= ' from ' . db_pir_gec . 'base_municipio';
                                $sql .= ' where nome = ' . aspa($rowDadosPess['cidade']);
                                $rst = execsql($sql, false);
                                $codmunicipio = $rst->data[0][0];

                                $registro = Array(
                                    'CODCOLIGADA' => 1,
                                    'CODCOLTCF' => 1,
                                    'CODCFO' => -1,
                                    'NOMEFANTASIA' => $rowDadosPess['nomefantasia'],
                                    'NOME' => $rowDadosPess['nome'],
                                    'CGCCFO' => $cgccfo,
                                    'ATIVO' => 1,
                                    'PAGREC' => 1,
                                    'PESSOAFISOUJUR' => $pessoafisoujur,
                                    'RUA' => $rowDadosPess['rua'],
                                    'NUMERO' => $rowDadosPess['numero'],
                                    'BAIRRO' => $rowDadosPess['bairro'],
                                    'CODMUNICIPIO' => $codmunicipio,
                                    'CIDADE' => $rowDadosPess['cidade'],
                                    'CODETD' => $rowDadosPess['codetd'],
                                    'CEP' => $cep,
                                    'EMAIL' => $rowDadosPess['email'],
                                    'CODTCF' => '028',
                                    'COMPLEMENTO' => substr($rowDadosPess['complemento'], 0, 60),
                                    'TELEFONE' => $rowDadosPess['telefone'],
                                );

                                $parametro = Array(
                                    'DataServerName' => 'FinCFODataBR',
                                    'Contexto' => 'codcoligada=1',
                                );

                                $Z = 'FCFO';
                                $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                if (substr($retorno, 0, 2) == '1;') {
                                    $rowd['rm_codcfo'] = substr($retorno, 2);
                                } else {
                                    $retorno_org = $retorno;
                                    $i = strpos($retorno, '=======================================');
                                    if ($i !== FALSE) {
                                        $retorno = substr($retorno, 0, $i);
                                    }

                                    $erro = 'ERRO DO RM: ' . $retorno;

                                    throw new Exception($erro);
                                }
                            }

                            $sql = 'update ' . db_pir_grc . 'grc_evento_participante_contadevolucao set rm_codcfo = ' . aspa($rowd['rm_codcfo']);
                            $sql .= ' where idt = ' . null($rowd['idt']);
                            execsql($sql, false);
                        }

                        //Tem a conta no RM 
                        if ($rowd['rm_idpgto'] == '') {
                            $rowd['rm_idpgto'] = 0;

                            if ($rowd['banco_numero'] == 1) {
                                $formapagamento = 'T';
                            } else {
                                $formapagamento = 'D';
                            }

                            $registro = Array(
                                'CODCOLIGADA' => 1,
                                'CODCOLCFO' => 1,
                                'CODCFO' => $rowd['rm_codcfo'],
                                'IDPGTO' => $rowd['rm_idpgto'],
                                'DESCRICAO' => 'Conta para Devolução do PIR.CRM',
                                'FORMAPAGAMENTO' => $formapagamento,
                                'NUMEROBANCO' => $rowd['banco_numero'],
                                'CODIGOAGENCIA' => $rowd['agencia_numero'],
                                'DIGITOAGENCIA' => $rowd['agencia_digito'],
                                'CONTACORRENTE' => $rowd['cc_numero'],
                                'DIGITOCONTA' => $rowd['cc_digito'],
                                'TIPOCONTA' => '1',
                                'TIPODOC' => 'C',
                                'FAVORECIDO' => $rowd['razao_social'],
                                'CGCFAVORECIDO' => $rowd['cpfcnpj'],
                            );

                            $parametro = Array(
                                'DataServerName' => 'FinDadosPgtoDataBR',
                                'Contexto' => 'codcoligada=1',
                            );

                            $Z = 'FDadosPgto';
                            $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                            $len = strlen('1;1;' . $rowd['rm_codcfo'] . ';');

                            if (substr($retorno, 0, $len) == '1;1;' . $rowd['rm_codcfo'] . ';') {
                                $idpgto = substr($retorno, $len);

                                $sql = 'update ' . db_pir_grc . 'grc_evento_participante_contadevolucao set rm_idpgto = ' . null($idpgto);
                                $sql .= ' where idt = ' . null($rowd['idt']);
                                execsql($sql, false);
                            } else {
                                $retorno_org = $retorno;
                                $i = strpos($retorno, '=======================================');
                                if ($i !== FALSE) {
                                    $retorno = substr($retorno, 0, $i);
                                }

                                throw new Exception($retorno);
                            }
                        }

                        $sql = 'insert into ' . db_pir_grc . 'grc_evento_participante_pagamento (';
                        $sql .= ' idt_atendimento, idt_evento_situacao_pagamento, operacao, data_pagamento, valor_pagamento';
                        $sql .= ') values (';
                        $sql .= null($rowd['idt_atendimento']) . ", 7, 'D', now(), " . null($rowd['vl_devolucao']);
                        $sql .= ')';
                        execsql($sql, false);
                        $idt_evento_participante_pagamento = lastInsertId();

                        $sql = 'update ' . db_pir_grc . 'grc_evento_participante_contadevolucao set idt_evento_participante_pagamento = ' . null($idt_evento_participante_pagamento);
                        $sql .= ' where idt = ' . null($rowd['idt']);
                        execsql($sql, false);

                        $sql = 'insert into ' . db_pir_grc . 'grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_participante_pagamento, tipo) values (';
                        $sql .= null($rowd['idt_atendimento']) . ', ' . null($rowDados['idt_evento']) . ', ' . null($idt_evento_participante_pagamento) . ", 'RM_INC_PAG')";
                        execsql($sql, false);
                    }
                } catch (PDOException $e) {
                    $msg = grava_erro_log($tipodb, $e, $sql);

                    echo "<div align='center' class='Msg'>" . $msg . "\n";
                    echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';

                    if ($debug) {
                        p($e);
                    }

                    onLoadPag();

                    FimTela();
                    exit();
                } catch (SoapFault $e) {
                    $msg = grava_erro_log('soap', $e, $sql);

                    echo "<div align='center' class='Msg'>" . $msg . "\n";
                    echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';

                    if ($debug) {
                        p($e);
                    }

                    onLoadPag();

                    FimTela();
                    exit();
                } catch (Exception $e) {
                    $msg = grava_erro_log('php', $e, '');

                    echo "<div align='center' class='Msg'>" . $msg . "\n";
                    echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';

                    if ($debug) {
                        p($e);
                    }

                    onLoadPag();

                    FimTela();
                    exit();
                }

                //Cria o evento retificadora
                if ($rowDados['retificadora'] == 'S') {
                    cria_evento_retificadora($rowDados['idt_gec_contratacao_credenciado_ordem'], $vlID, $rowDados['idt_evento'], $rowDados['valor_distrato']);
                }

                commit();
                beginTransaction();

                $ssaMostrarErro = 'N';
                $ssaIdtEvento = $rowDados['idt_evento'];

                $rowDadosDEP = $rowDados;
                require_once 'sincroniza_siac_acao.php';
                $rowDados = $rowDadosDEP;

                set_time_limit(0);

                //Envia email
                $vetEnviar = Array();

                //responsável pelo evento, aprovador
                $sql = '';
                $sql .= ' select distinct u.email, u.nome_completo';
                $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
                $sql .= ' inner join (';
                $sql .= ' select idt_autorizador';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_autorizador';
                $sql .= ' where idt_ponto_atendimento = ' . null($rowDados['idt_unidade']);

                if ($rowDados['idt_gestor_projeto'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_gestor_projeto'] . ' as idt_autorizador';
                }

                if ($rowDados['idt_gestor_evento'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_gestor_evento'] . ' as idt_autorizador';
                }

                if ($rowDados['idt_responsavel_evento'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_responsavel_evento'] . ' as idt_autorizador';
                }

                $sql .= ' ) as ea on ea.idt_autorizador = u.id_usuario';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome_completo'];
                }

                //fornecedores contratados e/ou convidados
                if ($rowDados['pst_email'] != '') {
                    $vetEnviar[$rowDados['pst_email']] = $rowDados['pst_nome'];
                }

                //clientes vinculados
                $sql = '';
                $sql .= ' select distinct p.nome, p.email';
                $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa p';
                $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento a on a.idt = p.idt_atendimento';
                $sql .= " left outer join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento";
                $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome'];
                }

                if (count($vetEnviar) > 0) {
                    foreach ($vetEnviar as $email => $nome) {
                        if ($email != '') {
                            if ($nome == '') {
                                $nome = $email;
                            }

                            $protocolo = date('dmYHis');

                            $assunto = $msgParametros($vetGEC_parametros['distrato_ap_01'], $protocolo, $rowe);
                            $mensagem = $msgParametros($vetGEC_parametros['distrato_ap_02'], $protocolo, $rowe);

                            $mensagem = str_replace('#responsavel', $nome, $mensagem);

                            $vetRegProtocolo = Array(
                                'protocolo' => $protocolo,
                                'origem' => 'distrato_ap_0102',
                            );

                            enviarEmail(db_pir_pfo, $assunto, $mensagem, $email, $nome, true, $vetRegProtocolo);
                        }
                    }
                }

                //Envia Aviso de Assinatura do Distrato
                $protocolo = date('dmYHis');

                $assunto = $msgParametros($vetGEC_parametros['distrato_ap_05'], $protocolo, $rowe);
                $mensagem = $msgParametros($vetGEC_parametros['distrato_ap_06'], $protocolo, $rowe);

                $mensagem = str_replace('#responsavel', $rowDados['pst_nome'], $mensagem);

                if ($rowDados['pst_email'] != '') {
                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'distrato_ap_0506',
                    );
                    enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowDados['pst_email'], $rowDados['pst_nome'], true, $vetRegProtocolo);
                }

                criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowDados['pst_login']);
            }
        }

        if (count($vetDel) > 0) {
            commit();
            beginTransaction();

            foreach ($vetDel as $arq) {
                if (is_file($arq)) {
                    unlink($arq);
                }
            }
        }

        if ($emailUploadPST && $rowDados['idt_gestor_evento'] != '') {
            //Envia email
            $vetEnviar = Array();

            $sql = '';
            $sql .= ' select u.email, u.nome_completo';
            $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
            $sql .= ' where u.id_usuario = ' . null($rowDados['idt_gestor_evento']);
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                $vetEnviar[$row['email']] = $row['nome_completo'];
            }

            if (count($vetEnviar) > 0) {
                foreach ($vetEnviar as $email => $nome) {
                    if ($email != '') {
                        if ($nome == '') {
                            $nome = $email;
                        }

                        $protocolo = date('dmYHis');

                        $assunto = $msgParametros($vetGEC_parametros['distrato_ap_07'], $protocolo, $rowe);
                        $mensagem = $msgParametros($vetGEC_parametros['distrato_ap_08'], $protocolo, $rowe);

                        $mensagem = str_replace('#responsavel', $nome, $mensagem);

                        $vetRegProtocolo = Array(
                            'protocolo' => $protocolo,
                            'origem' => 'distrato_ap_0708',
                        );

                        enviarEmail(db_pir_pfo, $assunto, $mensagem, $email, $nome, true, $vetRegProtocolo);
                    }
                }
            }
        }
        break;

    case 'gec_contratar_credenciado_aditivo':
        if ($_POST['btnAcao'] != 'Excluir') {
            if (is_array($_POST['aditivo_entrega'])) {
                $vetRegistro = Array();

                foreach ($_POST['aditivo_entrega'] as $idt => $row) {
                    $vetRegistro[] = $idt;

                    $sql = '';
                    $sql .= ' select valor, data';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega';
                    $sql .= ' where idt_aditivo = ' . null($vlID);
                    $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($idt);
                    $rs = execsql($sql);
                    $rowAnt = $rs->data[0];

                    if ($rs->rows == 0) {
                        $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega (';
                        $sql .= ' idt_aditivo, idt_gec_contratacao_credenciado_ordem_entrega, valor, data';
                        $sql .= ') values (';
                        $sql .= null($vlID) . ', ' . null($idt) . ', ' . null(desformat_decimal($row['valor'])) . ', ' . aspa(trata_data($row['data']));
                        $sql .= ')';
                        execsql($sql);
                    } else {
                        $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega set';
                        $sql .= ' valor = ' . null(desformat_decimal($row['valor'])) . ', ';
                        $sql .= ' data = ' . aspa(trata_data($row['data']));
                        $sql .= ' where idt_aditivo = ' . null($vlID);
                        $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($idt);
                        execsql($sql);
                    }

                    $campoLog = 'entrega_' . $row['codigo'];
                    $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['campo_desc'] = 'Entrega ' . $row['codigo'];
                    $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['desc_ant'] = format_decimal($rowAnt['valor']);
                    $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['desc_atu'] = $row['valor'];
                    $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['vl_ant'] = trata_data($rowAnt['data']);
                    $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['vl_atu'] = $row['data'];
                }

                if (count($vetRegistro) > 0) {
                    $sql = '';
                    $sql .= ' select ccde.idt_gec_contratacao_credenciado_ordem_entrega, ccde.valor, ccde.data, orde.codigo';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega ccde';
                    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_entrega orde on orde.idt = ccde.idt_gec_contratacao_credenciado_ordem_entrega";
                    $sql .= ' where ccde.idt_aditivo = ' . null($vlID);
                    $sql .= ' and ccde.idt_gec_contratacao_credenciado_ordem_entrega not in (' . implode(', ', $vetRegistro) . ')';
                    $rs = execsql($sql);

                    foreach ($rs->data as $rowAnt) {
                        $sql = 'delete from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega';
                        $sql .= ' where idt_aditivo = ' . null($vlID);
                        $sql .= ' and idt_gec_contratacao_credenciado_ordem_entrega = ' . null($rowAnt['idt_gec_contratacao_credenciado_ordem_entrega']);
                        execsql($sql);

                        $campoLog = 'entrega_' . $rowAnt['codigo'];
                        $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['campo_desc'] = 'Entrega ' . $rowAnt['codigo'];
                        $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['desc_ant'] = format_decimal($rowAnt['valor']);
                        $vetLogDetalheExtra['gec_contratar_credenciado_aditivo'][$campoLog]['vl_ant'] = trata_data($rowAnt['data']);
                    }
                }
            }
        }

        if ($_POST['bt_salva'] == '') {
            $sql_a = ' update ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_anexos set ';
            $sql_a .= " so_consulta = 'S'";
            $sql_a .= ' where idt_aditivo  = ' . null($vlID);
            execsql($sql_a);

            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " situacao_para = " . aspa($_POST['situacao']) . ",";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_contratar_credenciado_aditivo  = ' . null($vlID);
            $sql_a .= " and ativo = 'S'";
            $sql_a .= " and tipo = 'Aprovação do Aditamento'";
            execsql($sql_a);

            $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade, prd.codigo as codigo_produto";
            $sql .= ' from ' . db_pir_grc . 'grc_evento grc_e';
            $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
            $sql .= ' left outer join ' . db_pir_grc . 'grc_produto prd on prd.idt = grc_e.idt_produto';
            $sql .= " where grc_e.idt  = " . null($rowDados['idt_evento']);
            $rs = execsql($sql);
            $rowe = $rs->data[0];

            $msgParametros = function ($txt, $protocolo, $rowe) {
                $txt = str_replace('#protocolo', $protocolo, $txt);
                $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

                $sql = '';
                $sql .= ' select nome_completo';
                $sql .= ' from ' . db_pir_grc . 'plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);
                $txt = str_replace('#solicitante', $rs->data[0][0], $txt);

                $sql = '';
                $sql .= ' select nome_completo';
                $sql .= ' from ' . db_pir_grc . 'plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_gestor_evento']);
                $rs = execsql($sql);
                $txt = str_replace('#evento_responsavel', $rs->data[0][0], $txt);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
                $rs = execsql($sql);
                $txt = str_replace('#ponto_atendimento', $rs->data[0][0], $txt);

                $txt = str_replace('#codigo', $rowe['codigo'], $txt);

                $sql = '';
                $sql .= ' select desccid';
                $sql .= ' from ' . db_pir_siac . 'cidade';
                $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
                $rs = execsql($sql);
                $txt = str_replace('#cidade', $rs->data[0][0], $txt);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_local_pa';
                $sql .= ' where idt = ' . null($rowe['idt_local']);
                $rs = execsql($sql);
                $txt = str_replace('#local', $rs->data[0][0], $txt);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
                $sql .= ' where idt = ' . null($_POST['situacao']);
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    $sql = '';
                    $sql .= ' select descricao';
                    $sql .= ' from ' . db_pir_grc . 'grc_evento_situacao';
                    $sql .= ' where idt = ' . null($rowe['idt_evento_situacao']);
                    $rs = execsql($sql);
                }

                $txt = str_replace('#situacao', $rs->data[0][0], $txt);

                $txt = str_replace('#instrumento', $rowe['instrumento'], $txt);
                $txt = str_replace('#descricao', $rowe['descricao'], $txt);
                $txt = str_replace('#dt_previsao_inicial', trata_data($rowe['dt_previsao_inicial']), $txt);
                $txt = str_replace('#dt_previsao_fim', trata_data($rowe['dt_previsao_fim']), $txt);
                $txt = str_replace('#hora_inicio', $rowe['hora_inicio'], $txt);
                $txt = str_replace('#hora_fim', $rowe['hora_fim'], $txt);
                $txt = str_replace('#observacao', $rowe['observacao'], $txt);
                $txt = str_replace('#previsao_receita', format_decimal($rowe['previsao_receita']), $txt);
                $txt = str_replace('#previsao_despesa', format_decimal($rowe['previsao_despesa']), $txt);

                return $txt;
            };

            $vetGEC_parametros = Array();

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_gec . 'gec_parametros';
            $sql .= " where codigo in ('aditivo_ap_01', 'aditivo_ap_02', 'aditivo_ap_03', 'aditivo_ap_04', 'aditivo_ap_05', 'aditivo_ap_06')";
            $rs = execsql($sql);

            ForEach ($rs->data as $row) {
                $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
                $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");

                $vetGEC_parametros[$codigo] = $detalhe;
            }

            //Devolvido para Ajuste
            if ($aditivo_situacao == 'DE') {
                if ($rowDados['reg_origem'] == 'PFO') {
                    $sql = '';
                    $sql .= ' select nome_completo, login, email';
                    $sql .= ' from plu_usuario';
                    $sql .= ' where id_usuario = ' . null($rowDados['idt_responsavel']);
                    $rs = execsql($sql);
                    $rowUP = $rs->data[0];

                    $protocolo = date('dmYHis');

                    $assunto = $msgParametros($vetGEC_parametros['aditivo_ap_03'], $protocolo, $rowe);
                    $mensagem = $msgParametros($vetGEC_parametros['aditivo_ap_04'], $protocolo, $rowe);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'aditivo_ap_0304',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                } else {
                    $vetDados = Array(
                        'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                        'protocolo' => $_POST['numero'],
                        'status' => 'Devolvido para Ajuste',
                        'tipo' => 'Aprovação do Aditamento',
                        'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                        'idt_evento' => $rowDados['idt_evento'],
                        'idt_contratar_credenciado_aditivo' => $vlID,
                        'situacao_de' => $aditivo_situacao,
                    );

                    gravaPendenciaGRC($rowDados['idt_responsavel'], $vetDados);
                }
            }

            //Aguardando aprovação do Responsavel do Evento
            if ($aditivo_situacao == 'RE') {
                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Aditamento',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_aditivo' => $vlID,
                    'situacao_de' => $aditivo_situacao,
                );

                gravaPendenciaGRC($rowDados['idt_gestor_evento'], $vetDados);
            }

            //Aguardando aprovação do Gestor do Projeto
            if ($aditivo_situacao == 'GP') {
                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Aditamento',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_aditivo' => $vlID,
                    'situacao_de' => $aditivo_situacao,
                );

                gravaPendenciaGRC($rowDados['idt_gestor_projeto'], $vetDados);
            }

            //Aguardando aprovação do Coordenador/Gerente
            //Aguardando a aprovação do Diretor
            if ($aditivo_situacao == 'CG' || $aditivo_situacao == 'DI') {
                $idt_usuario_solucao = CoordenadorGerenteDiretorEvento($aditivo_situacao, $rowDados['idt_instrumento'], $rowDados['idt_unidade'], $rowDados['idt_ponto_atendimento'], $rowDados['classificacao'], $rowDados['vl_cotacao'], true, db_pir_grc);

                $vetDados = Array(
                    'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                    'protocolo' => $_POST['numero'],
                    'status' => 'Para Aprovação',
                    'tipo' => 'Aprovação do Aditamento',
                    'observacao' => 'Evento: ' . $rowDados['evento_codigo'],
                    'idt_evento' => $rowDados['idt_evento'],
                    'idt_contratar_credenciado_aditivo' => $vlID,
                    'situacao_de' => $aditivo_situacao,
                );

                gravaPendenciaGRC($idt_usuario_solucao, $vetDados);
            }

            //Aprovação
            if ($aditivo_situacao == 'AP') {
                set_time_limit(0);

                //Gera o PDF do Aditamento
                $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, $pathObjFile . '/gec_contratar_credenciado_aditivo_pdf/');

                if (!file_exists($pathPDF)) {
                    mkdir($pathPDF);
                }

                //Cliente
                $sql = '';
                $sql .= ' select a.idt';
                $sql .= " from " . db_pir_grc . "grc_atendimento a";
                $sql .= " inner join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = a.idt";
                $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $sql .= ' union all';
                $sql .= " select 'pst' as idt";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $contrato_pdf = $vlID . '.' . $row['idt'] . '_arq_aditivo_' . $microtime . '_aditivo.pdf';

                    $_POST['id'] = $vlID;
                    $_POST['idt_atendimento'] = $row['idt'];
                    salvaPDF($pathPDF . $contrato_pdf);

                    if (!file_exists($pathPDF . $contrato_pdf)) {
                        erro_try('Aditamento em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                        echo '<script type="text/javascript">';
                        echo 'alert("Aditamento em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                        echo 'self.location = "' . $pagina . '?' . $_SERVER['QUERY_STRING'] . '";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $sql = 'insert into ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_pdf (idt_aditivo, idt_atendimento, arq_aditivo) values (';
                    $sql .= null($vlID) . ', ' . null($row['idt']) . ', ' . aspa($contrato_pdf) . ')';
                    execsql($sql);
                }

                //Sincroniza o Evento no SiacWeb
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_sincroniza_siac';
                $sql .= ' where idt_evento = ' . null($rowDados['idt_evento']);
                $sql .= " and tipo = 'EV'";
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo, representa) values (';
                    $sql .= null($rowDados['idt_evento']) . ", 'EV', 'N')";
                    execsql($sql);
                } else {
                    $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null, representa = 'N'";
                    $sql .= ' where idt = ' . null($rst->data[0][0]);
                    execsql($sql);
                }

                //Sincroniza Pagamento RM
                $sql = '';
                $sql .= ' select pp.idt, pp.idt_atendimento';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_participante ap';
                $sql .= ' inner join grc_evento_participante_pagamento pp on pp.idt_aditivo_participante = ap.idt';
                $sql .= ' where ap.idt_aditivo = ' . null($vlID);
                $sql .= " and pp.estornado <> 'S' ";
                $sql .= " and pp.operacao = 'C'";
                $rs = execsql($sql);

                ForEach ($rs->data as $row) {
                    $sql = 'insert into ' . db_pir_grc . 'grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_participante_pagamento, tipo) values (';
                    $sql .= null($row['idt_atendimento']) . ', ' . null($rowDados['idt_evento']) . ', ' . null($row['idt']) . ", 'RM_INC_PAG')";
                    execsql($sql);
                }

                //Atualiza as Entregas da ordem para os valores do Aditivo
                $sql = '';
                $sql .= ' select o.idt, a.valor as vl_aditivo, a.data as dt_aditivo, o.mesano, o.vl_entrega_real, o.mesano_sem_atidivo, o.vl_entrega_real_sem_atidivo';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado_aditivo_entrega a';
                $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega o on o.idt = a.idt_gec_contratacao_credenciado_ordem_entrega';
                $sql .= ' where a.idt_aditivo = ' . null($vlID);
                $rs = execsql($sql);

                ForEach ($rs->data as $row) {
                    $valor_real = 0;
                    $sqlUP = '';

                    if ($row['mesano_sem_atidivo'] == '') {
                        $valor_real += $row['vl_entrega_real'];
                        $sqlUP .= ' mesano_sem_atidivo = ' . aspa($row['mesano']) . ',';
                        $sqlUP .= ' vl_entrega_real_sem_atidivo = ' . $row['vl_entrega_real'] . ',';
                    } else {
                        $valor_real += $row['vl_entrega_real_sem_atidivo'];
                    }

                    if ($row['vl_aditivo'] != '') {
                        $valor_real += $row['vl_aditivo'];
                    }

                    if ($row['dt_aditivo'] != '') {
                        $vetDT = DatetoArray(trata_data($row['dt_aditivo']));
                        $sqlUP .= ' mesano = ' . aspa($vetDT['mes'] . '/' . $vetDT['ano']) . ',';
                    }

                    $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega set';
                    $sql .= $sqlUP;
                    $sql .= ' vl_entrega_real = ' . $valor_real;
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql);
                }

                $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm set';
                $sql .= " aditivo = 'N'";
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                $sql .= " and rm_cancelado = 'N'";
                $sql .= " and so_prev = 'N'";
                $sql .= " and distrato = 'N'";
                execsql($sql);

                $sql = '';
                $sql .= ' select mesano, sum(vl_entrega_prev) as valor_prev, sum(vl_entrega_real) as valor_real';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_entrega';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                $sql .= ' group by mesano';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    if ($row['valor_prev'] == '') {
                        $row['valor_prev'] = 0;
                    }

                    if ($row['valor_real'] == '') {
                        $row['valor_real'] = 0;
                    }

                    $mesano = $row['mesano'];
                    $mesano_real = $row['mesano'];

                    //ultimo dia
                    $vetMesAno = explode('/', $mesano);
                    $dia = cal_days_in_month(CAL_GREGORIAN, $vetMesAno[0], $vetMesAno[1]);

                    $datasaida = $dia . '/' . $mesano;

                    $sql = '';
                    $sql .= ' select idt, rm_idmov';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                    $sql .= ' and mesano_real = ' . aspa($mesano_real);
                    $sql .= " and rm_cancelado = 'N'";
                    $sql .= " and so_prev = 'N'";
                    $rst = execsql($sql);
                    $rowt = $rst->data[0];

                    if ($rst->rows == 0) {
                        $sql = 'insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm (idt_gec_contratacao_credenciado_ordem, mesano, mesano_real, datasaida,';
                        $sql .= ' valor_prev, valor_real, aditivo) values (';
                        $sql .= null($rowDados['idt_gec_contratacao_credenciado_ordem']) . ', ' . aspa($mesano) . ', ' . aspa($mesano_real) . ', ' . aspa(trata_data($datasaida)) . ', ';
                        $sql .= null($row['valor_prev']) . ', ' . null($row['valor_real']) . ", 'S')";
                        execsql($sql);
                    } else if ($rowt['rm_idmov'] == '') {
                        $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm set';
                        $sql .= " aditivo = 'S',";
                        $sql .= " datasaida_sem_atidivo = datasaida,";
                        $sql .= " valor_real_sem_atidivo = valor_real,";
                        $sql .= ' mesano = ' . aspa($mesano) . ', ';
                        $sql .= ' datasaida = ' . aspa(trata_data($datasaida)) . ', ';
                        $sql .= ' valor_prev = ' . null($row['valor_prev']) . ', ';
                        $sql .= ' valor_real = ' . null($row['valor_real']);
                        $sql .= ' where idt = ' . null($rowt['idt']);
                        execsql($sql);
                    }
                }

                //Sincroniza a alteração da ordem com o RM
                $SoapSebraeRM_DS = new SoapSebraeRMGeral('wsDataServer');
                $SoapSebraeRM_PR = new SoapSebraeRMGeral('wsProcess', true);
                $vetErro = Array();

                $sql = '';
                $sql .= ' select idt, rm_idmov, aditivo';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                $sql .= " and rm_cancelado = 'N'";
                $sql .= " and so_prev = 'N'";
                $sql .= " and distrato = 'N'";
                $sql .= ' order by datasaida';
                $rs = execsqlNomeCol($sql);

                foreach ($rs->data as $row) {
                    try {
                        $funcao = '';
                        $Z = '';
                        $parametro = '';

                        if ($row['aditivo'] == 'S') {
                            $vetErroRM = rmConsolidacaoPrevista($rowDados['idt_gec_contratacao_credenciado_ordem'], 'valor_real', false, true, false, $row['idt']);

                            if (count($vetErroRM) == 0) {
                                $vetErroRM = rmConsolidacaoRealizado($rowDados['idt_gec_contratacao_credenciado_ordem'], false, $row['idt']);
                            }

                            if (count($vetErroRM) > 0) {
                                throw new Exception(implode('<br />', $vetErroRM));
                            }
                        } else {
                            //Atualiza o RM
                            if ($row['rm_idmov'] != '') {
                                $funcao = 'ReadRecordAuth';

                                $parametro = Array(
                                    'DataServerName' => 'MovMovimentoTBCData',
                                    'PrimaryKey' => '1;' . $row['rm_idmov'],
                                    'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                );

                                $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                                $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);

                                $valor = $valor = str_replace(".", ",", '0.01');

                                $registro = Array();

                                $registro['TMOV'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'CODCOLIGADA1' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                                );

                                $registro['TITMMOV'] = Array(
                                    'CODCOLIGADA' => '1',
                                    'CODCOLIGADA1' => '1',
                                    'NSEQITMMOV' => '1',
                                    'NSEQITMMOV1' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'PRECOUNITARIO' => $valor,
                                    'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                                );

                                $registro['TITMMOVRATCCU'] = Array(
									'CODCOLIGADA' => '1',
                                    'NSEQITMMOV' => '1',
                                    'IDMOV' => $row['rm_idmov'],
                                    'VALOR' => $valor,
                                    'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                                );

                                $parametro = Array(
                                    'DataServerName' => 'MovMovimentoTBCData',
                                    'Contexto' => 'codcoligada=1',
                                );

                                $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                                $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                if (substr($retorno, 0, 2) != '1;') {
                                    $retorno_org = $retorno;
                                    $i = strpos($retorno, '=======================================');
                                    if ($i !== FALSE) {
                                        $retorno = substr($retorno, 0, $i);
                                    }

                                    $erro = 'ERRO DO RM: ' . $retorno;

                                    $inf_extra = Array(
                                        'RM Erro' => $retorno_org,
                                        'Z' => $Z,
                                        'parametro' => $parametro,
                                        'registro' => $registro,
                                        'row' => $row,
                                    );

                                    $vetErro[] = $erro;

                                    erro_try($erro, 'aprovacao_aditivo', $inf_extra);
                                }
                            }
                        }
                    } catch (Exception $e) {
                        $erro = 'ERRO DO RM: ' . $e->getMessage();

                        $inf_extra = Array(
                            'funcao' => $funcao,
                            'Z' => $Z,
                            'parametro' => $parametro,
                            'row' => $row,
                        );

                        $vetErro[] = $erro;

                        erro_try($erro, 'aprovacao_aditivo', $inf_extra);
                    }
                }

                if (count($vetErro) > 0) {
                    $erroFinal = 'Erro na Aprovação do Aditamento.<br />' . implode('<br />', $vetErro);

                    $sql = '';
                    $sql .= ' select *';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                    $sql .= " and rm_cancelado = 'N'";
                    $sql .= " and so_prev = 'N'";
                    $sql .= " and distrato = 'N'";
                    $sql .= ' order by datasaida';
                    $rs = execsqlNomeCol($sql);

                    ForEach ($rs->data as $row) {
                        try {
                            $funcao = '';
                            $Z = '';
                            $parametro = '';

                            if ($row['aditivo'] == 'S') {
                                $valor_real = $row['valor_real_sem_atidivo'];
                                $datasaida = $row['datasaida_sem_atidivo'];

                                if ($valor_real == '') {
                                    //Cancela o RM
                                    if ($row['rm_idmov'] != '') {
                                        $funcao = 'ReadRecordAuth';

                                        $parametro = Array(
                                            'DataServerName' => 'MovMovimentoTBCData',
                                            'PrimaryKey' => '1;' . $row['rm_idmov'],
                                            'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                        );

                                        $Z = Array('TMOV');

                                        $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);
                                        $rowRM = $rsRM['TMOV']->data[0];

                                        if ($rowRM['status'] != 'C') {
                                            $xml = '';
                                            $xml .= '<MovCancelMovProcParams>';
                                            $xml .= '<MovimentosACancelar>';
                                            $xml .= '<MovimentosCancelar>';
                                            $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                                            $xml .= '<CodColigada>1</CodColigada>';
                                            $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                                            $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                                            $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                                            $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                                            $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                                            $xml .= '<MotivoCancelamento>Erro na Aprovação do Aditamento</MotivoCancelamento>';
                                            $xml .= '</MovimentosCancelar>';
                                            $xml .= '</MovimentosACancelar>';
                                            $xml .= '</MovCancelMovProcParams>';

                                            $metodo = 'ExecuteWithParams';

                                            $parametro = Array(
                                                'ProcessServerName' => 'MovCancelMovProc',
                                                'strXmlParams' => $xml,
                                            );

                                            $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                                            if ($retorno != '1') {
                                                $erro = 'RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                                                $inf_extra = Array(
                                                    'RM Erro' => $retorno,
                                                    'parametro' => $parametro,
                                                    'row' => $row,
                                                );

                                                erro_try($erro, 'aprovacao_aditivo_erro', $inf_extra);
                                            }
                                        }
                                    }
                                } else {
                                    $funcao = 'ReadRecordAuth';

                                    $parametro = Array(
                                        'DataServerName' => 'MovMovimentoTBCData',
                                        'PrimaryKey' => '1;' . $row['rm_idmov'],
                                        'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                    );

                                    $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                                    $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);

                                    $valor = str_replace(".", ",", $valor_real);

                                    $registro = Array();

                                    $registro['TMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'DATASAIDA' => $datasaida,
                                        'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'NSEQITMMOV' => '1',
                                        'NSEQITMMOV1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'PRECOUNITARIO' => $valor,
                                        'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOVRATCCU'] = Array(
				                        'CODCOLIGADA' => '1',
                                        'NSEQITMMOV' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'VALOR' => $valor,
                                        'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                                    );

                                    $parametro = Array(
                                        'DataServerName' => 'MovMovimentoTBCData',
                                        'Contexto' => 'codcoligada=1',
                                    );

                                    $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                                    $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                    if (substr($retorno, 0, 2) != '1;') {
                                        $retorno_org = $retorno;
                                        $i = strpos($retorno, '=======================================');
                                        if ($i !== FALSE) {
                                            $retorno = substr($retorno, 0, $i);
                                        }

                                        $erro = 'ERRO DO RM: ' . $retorno;

                                        $inf_extra = Array(
                                            'RM Erro' => $retorno_org,
                                            'Z' => $Z,
                                            'parametro' => $parametro,
                                            'registro' => $registro,
                                        );

                                        erro_try($erro, 'aprovacao_aditivo_erro', $inf_extra);
                                    }
                                }
                            } else {
                                //Atualiza o RM
                                if ($row['rm_idmov'] != '') {
                                    $valor_real = $row['valor_real'];

                                    $funcao = 'ReadRecordAuth';

                                    $parametro = Array(
                                        'DataServerName' => 'MovMovimentoTBCData',
                                        'PrimaryKey' => '1;' . $row['rm_idmov'],
                                        'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                                    );

                                    $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                                    $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);

                                    $valor = str_replace(".", ",", $valor_real);

                                    $registro = Array();

                                    $registro['TMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOV'] = Array(
                                        'CODCOLIGADA' => '1',
                                        'CODCOLIGADA1' => '1',
                                        'NSEQITMMOV' => '1',
                                        'NSEQITMMOV1' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'PRECOUNITARIO' => $valor,
                                        'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                                    );

                                    $registro['TITMMOVRATCCU'] = Array(
				                        'CODCOLIGADA' => '1',
                                        'NSEQITMMOV' => '1',
                                        'IDMOV' => $row['rm_idmov'],
                                        'VALOR' => $valor,
                                        'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                                    );

                                    $parametro = Array(
                                        'DataServerName' => 'MovMovimentoTBCData',
                                        'Contexto' => 'codcoligada=1',
                                    );

                                    $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                                    $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                                    if (substr($retorno, 0, 2) != '1;') {
                                        $retorno_org = $retorno;
                                        $i = strpos($retorno, '=======================================');
                                        if ($i !== FALSE) {
                                            $retorno = substr($retorno, 0, $i);
                                        }

                                        $erro = 'ERRO DO RM: ' . $retorno;

                                        $inf_extra = Array(
                                            'RM Erro' => $retorno_org,
                                            'Z' => $Z,
                                            'parametro' => $parametro,
                                            'registro' => $registro,
                                            'row' => $row,
                                        );

                                        $vetErro[] = $erro;

                                        erro_try($erro, 'aprovacao_aditivo_erro', $inf_extra);
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            $erro = 'ERRO DO RM: ' . $e->getMessage();

                            $inf_extra = Array(
                                'funcao' => $funcao,
                                'Z' => $Z,
                                'parametro' => $parametro,
                                'row' => $row,
                            );

                            erro_try($erro, 'aprovacao_aditivo_erro', $inf_extra);
                        }
                    }

                    rollBack();
                    msg_erro($erroFinal);
                }

                //Cancelar no RM
                $sql = '';
                $sql .= ' select idt, rm_idmov, valor_real';
                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowDados['idt_gec_contratacao_credenciado_ordem']);
                $sql .= " and rm_cancelado = 'N'";
                $sql .= " and so_prev = 'N'";
                $sql .= " and aditivo = 'N'";
                $sql .= " and distrato = 'N'";
                $sql .= ' order by datasaida';
                $rs = execsqlNomeCol($sql);

                foreach ($rs->data as $row) {
                    if ($row['rm_idmov'] == '') {
                        $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                        $sql .= ' where idt = ' . null($row['idt']);
                        execsql($sql, false);
                    } else {
                        $funcao = 'ReadRecordAuth';

                        $parametro = Array(
                            'DataServerName' => 'MovMovimentoTBCData',
                            'PrimaryKey' => '1;' . $row['rm_idmov'],
                            'Contexto' => 'codcoligada=1;idmov=' . $row['rm_idmov'],
                        );

                        $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');

                        $rsRM = $SoapSebraeRM_DS->executa($funcao, $Z, $parametro, true);

                        //Atualiza o RM
                        $valor_real = $row['valor_real'];

                        $valor = str_replace(".", ",", $valor_real);

                        $registro = Array();

                        $registro['TMOV'] = Array(
                            'CODCOLIGADA' => '1',
                            'CODCOLIGADA1' => '1',
                            'IDMOV' => $row['rm_idmov'],
                            'IDMOVHST' => $rsRM['TMOV']->data[0]['idmovhst'],
                        );

                        $registro['TITMMOV'] = Array(
                            'CODCOLIGADA' => '1',
                            'CODCOLIGADA1' => '1',
                            'NSEQITMMOV' => '1',
                            'NSEQITMMOV1' => '1',
                            'IDMOV' => $row['rm_idmov'],
                            'PRECOUNITARIO' => $valor,
                            'IDMOVHST' => $rsRM['TITMMOV']->data[0]['idmovhst'],
                        );

                        $registro['TITMMOVRATCCU'] = Array(
                            'CODCOLIGADA' => '1',
                            'NSEQITMMOV' => '1',
                            'IDMOV' => $row['rm_idmov'],
                            'VALOR' => $valor,
                            'IDMOVRATCCU' => $rsRM['TITMMOVRATCCU']->data[0]['idmovratccu'],
                        );

                        $parametro = Array(
                            'DataServerName' => 'MovMovimentoTBCData',
                            'Contexto' => 'codcoligada=1',
                        );

                        $Z = Array('TMOV', 'TITMMOV', 'TITMMOVRATCCU');
                        $retorno = $SoapSebraeRM_DS->save($Z, $registro, $parametro, true);

                        if (substr($retorno, 0, 2) != '1;') {
                            $retorno_org = $retorno;
                            $i = strpos($retorno, '=======================================');
                            if ($i !== FALSE) {
                                $retorno = substr($retorno, 0, $i);
                            }

                            $erro = 'ERRO DO RM: ' . $retorno;

                            $inf_extra = Array(
                                'RM Erro' => $retorno_org,
                                'Z' => $Z,
                                'parametro' => $parametro,
                                'registro' => $registro,
                                'row' => $row,
                            );

                            $vetErro[] = $erro;

                            erro_try($erro, 'aprovacao_aditivo_erro', $inf_extra);
                        }

                        //Cancelar
                        $rowRM = $rsRM['TMOV']->data[0];

                        if ($rowRM['status'] != 'C') {
                            $xml = '';
                            $xml .= '<MovCancelMovProcParams>';
                            $xml .= '<MovimentosACancelar>';
                            $xml .= '<MovimentosCancelar>';
                            $xml .= '<ApagarMovRelac>false</ApagarMovRelac>';
                            $xml .= '<CodColigada>1</CodColigada>';
                            $xml .= '<CodSistemaLogado>T</CodSistemaLogado>';
                            $xml .= '<CodUsuarioLogado>' . SoapSebraeRMusuario . '</CodUsuarioLogado>';
                            $xml .= '<DataCancelamento>' . date('Y-m-d') . '</DataCancelamento>';
                            $xml .= '<IdExercicioFiscal>5</IdExercicioFiscal>';
                            $xml .= '<IdMov>' . $row['rm_idmov'] . '</IdMov>';
                            $xml .= '<MotivoCancelamento>Foi aditado para outra data de entrega</MotivoCancelamento>';
                            $xml .= '</MovimentosCancelar>';
                            $xml .= '</MovimentosACancelar>';
                            $xml .= '</MovCancelMovProcParams>';

                            $metodo = 'ExecuteWithParams';

                            $parametro = Array(
                                'ProcessServerName' => 'MovCancelMovProc',
                                'strXmlParams' => $xml,
                            );

                            $retorno = $SoapSebraeRM_PR->processo($metodo, $parametro, true);

                            if ($retorno == '1') {
                                $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                                $sql .= ' where idt = ' . null($row['idt']);
                                execsql($sql, false);
                            } else {
                                $erro = 'RM: [' . $metodo . '] ' . $retorno . ' para o IDMOV: ' . $row['rm_idmov'];

                                $inf_extra = Array(
                                    'RM Erro' => $retorno,
                                    'parametro' => $parametro,
                                    'row' => $row,
                                );

                                $vetErro[] = $erro;

                                erro_try($erro, 'aprovacao_aditivo', $inf_extra);
                            }
                        } else {
                            $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem_rm set rm_cancelado = 'S'";
                            $sql .= ' where idt = ' . null($row['idt']);
                            execsql($sql, false);
                        }
                    }
                }

                commit();
                beginTransaction();

                $ssaMostrarErro = 'N';
                $ssaIdtEvento = $rowDados['idt_evento'];

                $rowDadosDEP = $rowDados;
                require_once 'sincroniza_siac_acao.php';
                $rowDados = $rowDadosDEP;

                set_time_limit(0);

                //Envia email
                $vetEnviar = Array();

                //responsável pelo evento, aprovador
                $sql = '';
                $sql .= ' select distinct u.email, u.nome_completo';
                $sql .= ' from ' . db_pir_grc . 'plu_usuario u';
                $sql .= ' inner join (';
                $sql .= ' select idt_autorizador';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_autorizador';
                $sql .= ' where idt_ponto_atendimento = ' . null($rowDados['idt_unidade']);

                if ($rowDados['idt_gestor_projeto'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_gestor_projeto'] . ' as idt_autorizador';
                }

                if ($rowDados['idt_gestor_evento'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_gestor_evento'] . ' as idt_autorizador';
                }

                if ($rowDados['idt_responsavel_evento'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowDados['idt_responsavel_evento'] . ' as idt_autorizador';
                }

                $sql .= ' ) as ea on ea.idt_autorizador = u.id_usuario';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome_completo'];
                }

                //clientes vinculados
                $sql = '';
                $sql .= ' select distinct p.nome, p.email';
                $sql .= ' from ' . db_pir_grc . 'grc_atendimento_pessoa p';
                $sql .= ' inner join ' . db_pir_grc . 'grc_atendimento a on a.idt = p.idt_atendimento';
                $sql .= " left outer join " . db_pir_grc . "grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento";
                $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
                $sql .= " and (ep.contrato is null or ep.contrato <> 'IC')";
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome'];
                }

                if (count($vetEnviar) > 0) {
                    foreach ($vetEnviar as $email => $nome) {
                        if ($email != '') {
                            if ($nome == '') {
                                $nome = $email;
                            }

                            $protocolo = date('dmYHis');

                            $assunto = $msgParametros($vetGEC_parametros['aditivo_ap_01'], $protocolo, $rowe);
                            $mensagem = $msgParametros($vetGEC_parametros['aditivo_ap_02'], $protocolo, $rowe);

                            $mensagem = str_replace('#responsavel', $nome, $mensagem);

                            $vetRegProtocolo = Array(
                                'protocolo' => $protocolo,
                                'origem' => 'aditivo_ap_0102',
                            );

                            enviarEmail(db_pir_pfo, $assunto, $mensagem, $email, $nome, true, $vetRegProtocolo);
                        }
                    }
                }

                //Envia Aviso de Assinatura do Aditamento
                $protocolo = date('dmYHis');

                $sql = "select valor from " . db_pir_gec . "plu_config where variavel = 'link_aceite_pfo'";
                $rsGEC = execsql($sql);

                $link_assinar_aditivo = $rsGEC->data[0][0];
                $link_assinar_aditivo = str_replace('localhost', $_SERVER['HTTP_HOST'], $link_assinar_aditivo);
                $link_assinar_aditivo .= '/link_assinar_aditivo.php?chave=' . md5($vlID);

                $assunto = $msgParametros($vetGEC_parametros['aditivo_ap_05'], $protocolo, $rowe);
                $mensagem = $msgParametros($vetGEC_parametros['aditivo_ap_06'], $protocolo, $rowe);

                $mensagem = str_replace('#responsavel', $rowDados['pst_nome'], $mensagem);
                $mensagem = str_replace('#link_assinar_aditivo', $link_assinar_aditivo, $mensagem);

                if ($rowDados['pst_email'] != '') {
                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'aditivo_ap_0506',
                    );
                    enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowDados['pst_email'], $rowDados['pst_nome'], true, $vetRegProtocolo);
                }

                criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowDados['pst_login']);
            }
        }
        break;

    case 'grc_evento_combo_cad':
        $sql_a = ' update grc_evento set ';
        $sql_a .= ' temporario = ' . aspa('N');
        $sql_a .= ' where idt = ' . null($vlID);
        execsql($sql_a);

        if (is_array($_POST['dados'])) {
            foreach ($_POST['dados'] as $idt => $row) {
                $sql = '';
                $sql .= ' select eg.idt, eg.qtd_atual, i.descricao as instrumento';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_combo_instrumento eg';
                $sql .= ' inner join grc_atendimento_instrumento i on i.idt = eg.idt_instrumento';
                $sql .= ' where eg.idt = ' . null($idt);
                $rs = execsql($sql);
                $rowAnt = $rs->data[0];

                $sql = 'update ' . db_pir_grc . 'grc_evento_combo_instrumento set';
                $sql .= ' qtd_atual = ' . null($row['qtd_atual']);
                $sql .= ' where idt = ' . null($idt);
                execsql($sql);

                $campoLog = 'qtd_atual_' . $rowAnt['idt'];
                $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = '[' . $rowAnt['instrumento'] . '] Qtde. Mínima na Inscrição)';
                $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $rowAnt['qtd_atual'];
                $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $row['qtd_atual'];
            }
        }

        //Envia para Aprovação
        if ($_POST['situacao'] == 'EnviarAprovarEventoCombo') {
            //Fecha a Pendencia em Aberto
            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_evento_situacao_para = 6,";
            $sql_a .= " situacao_para = 'GE',";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_combo_origem  = ' . null($vlID);
            $sql_a .= " and ativo  =  'S'";
            $sql_a .= " and tipo   =  'Evento Combo'";
            execsql($sql_a);

            //Atualiza a Situação
            $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
            execsql($sql_a);

            $sql_a = 'update grc_evento set idt_evento_situacao = 6 where idt = ' . null($vlID);
            execsql($sql_a);

            $campoLog = 'idt_evento_situacao';
            $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = 'Situação';
            $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_ant'] = $_POST['idt_evento_situacao'];
            $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetEventoSituacao[$_POST['idt_evento_situacao']];
            $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_atu'] = 6;
            $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $vetEventoSituacao[6];

            //Cria as Pendencia para Aprovação
            $sql = '';
            $sql .= " select e.codigo, e.descricao";
            $sql .= ' from grc_evento e';
            $sql .= ' where e.idt = ' . null($vlID);
            $rs = execsql($sql);
            $rowDadosEvento = $rs->data[0];

            $sql = '';
            $sql .= " select e.idt_instrumento, e.idt_unidade, e.idt_ponto_atendimento, s.classificacao";
            $sql .= ' from grc_evento_combo eg';
            $sql .= ' inner join grc_evento e on e.idt = eg.idt_evento';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = e.idt_unidade';
            $sql .= ' where eg.idt_evento_origem = ' . null($vlID);
            $rs = execsql($sql);

            $vetPEN = Array();

            foreach ($rs->data as $row) {
                $vetCG = CoordenadorGerenteDiretorEvento('CG', $row['idt_instrumento'], $row['idt_unidade'], $row['idt_ponto_atendimento'], $row['classificacao'], 0);
                $vetPEN = array_merge($vetPEN, $vetCG);
            }

            $vetPEN = array_unique($vetPEN);

            $vetDados = Array(
                'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                'protocolo' => $rowDadosEvento['codigo'],
                'tipo' => 'Evento Combo',
                'status' => 'Aprovação',
                'observacao' => $rowDadosEvento['descricao'],
                'idt_evento' => $vlID,
                'idt_evento_combo_origem' => $vlID,
                'idt_evento_situacao_de' => 6,
                'situacao_de' => 'GE',
            );

            foreach ($vetPEN as $idt_usuario_solucao) {
                $sql = '';
                $sql .= ' select und.idt';
                $sql .= ' from plu_usuario u';
                $sql .= ' left outer join ' . db_pir . 'sca_organizacao_secao s on s.idt = u.idt_unidade_lotacao';
                $sql .= " left outer join " . db_pir . "sca_organizacao_secao und on und.classificacao = concat(substring(s.classificacao, 1, 5), '.00.000')";
                $sql .= ' where u.id_usuario = ' . null($idt_usuario_solucao);
                $rs = execsql($sql);

                $vetDados['idt_responsavel_unidade_lotacao'] = $rs->data[0][0];

                gravaPendenciaGRC($idt_usuario_solucao, $vetDados);
            }

            $sql_a = "update grc_evento_combo set situacao = 'GE' where idt_evento_origem = " . null($vlID);
            execsql($sql_a);

            $sql_a = "update grc_evento_combo_unidade";
            $sql_a .= " set situacao = null,";
            $sql_a .= " idt_usuario_aprovacao = null,";
            $sql_a .= " dt_aprovacao = null";
            $sql_a .= " where idt_evento = " . null($vlID);
            execsql($sql_a);
        }

        // 5 - DEVOLVIDO
        if ($_POST['situacao'] == 5) {
            //Fecha a Pendencia em Aberto
            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_evento_situacao_para = 5,";
            $sql_a .= " situacao_para = 'RP',";
            $sql_a .= " solucao = " . aspa($_POST['parecer']) . ",";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_combo_origem  = ' . null($vlID);
            $sql_a .= " and idt_responsavel_unidade_lotacao = " . null($idt_responsavel_unidade_lotacao);
            $sql_a .= " and ativo  =  'S'";
            $sql_a .= " and tipo   =  'Evento Combo'";
            execsql($sql_a);

            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_evento_situacao_para = 5,";
            $sql_a .= " situacao_para = 'CD',";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_combo_origem  = ' . null($vlID);
            $sql_a .= " and ativo  =  'S'";
            $sql_a .= " and tipo   =  'Evento Combo'";
            execsql($sql_a);

            //Atualiza a Situação
            $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
            execsql($sql_a);

            $sql_a = 'update grc_evento set idt_evento_situacao = 5 where idt = ' . null($vlID);
            execsql($sql_a);

            $campoLog = 'idt_evento_situacao';
            $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = 'Situação';
            $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_ant'] = $_POST['idt_evento_situacao'];
            $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetEventoSituacao[$_POST['idt_evento_situacao']];
            $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_atu'] = 5;
            $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $vetEventoSituacao[5];

            //Cria as Pendencia da Devolução
            $vetDados = Array(
                'idt_usuario' => $_SESSION[CS]['g_id_usuario'],
                'protocolo' => $codigo_evento,
                'tipo' => 'Evento Combo',
                'status' => 'Reprovado',
                'observacao' => '[' . $codigo_evento . '] ' . $_POST['descricao'],
                'idt_evento' => $vlID,
                'idt_evento_combo_origem' => $vlID,
                'idt_evento_situacao_de' => 5,
                'situacao_de' => 'RP',
            );

            gravaPendenciaGRC($idt_responsavel, $vetDados);

            $sql_a = "update grc_evento_combo ec";
            $sql_a .= " inner join grc_evento e on e.idt = ec.idt_evento";
            $sql_a .= " set ec.situacao = 'RP'";
            $sql_a .= " where ec.idt_evento_origem = " . null($vlID);
            $sql_a .= " and e.idt_unidade = " . null($idt_responsavel_unidade_lotacao);
            execsql($sql_a);

            $sql_a = "update grc_evento_combo ec";
            $sql_a .= " inner join grc_evento e on e.idt = ec.idt_evento";
            $sql_a .= " set ec.situacao = 'CD'";
            $sql_a .= " where ec.idt_evento_origem = " . null($vlID);
            $sql_a .= " and e.idt_unidade <> " . null($idt_responsavel_unidade_lotacao);
            $sql_a .= " and ec.situacao <> 'AP'";
            execsql($sql_a);

            $sql_a = "update grc_evento_combo_unidade";
            $sql_a .= " set situacao = 'RP',";
            $sql_a .= " idt_usuario_aprovacao = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_aprovacao = now()";
            $sql_a .= " where idt_evento = " . null($vlID);
            $sql_a .= " and idt_unidade = " . null($idt_responsavel_unidade_lotacao);
            execsql($sql_a);
        }

        //Gestor Aprovar Evento Combo
        if ($_POST['situacao'] == 'GestorAprovarEventoCombo') {
            //Fecha a Pendencia em Aberto
            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= " idt_evento_situacao_para = 15,";
            $sql_a .= " situacao_para = 'AP',";
            $sql_a .= " solucao = " . aspa($_POST['parecer']) . ",";
            $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_update = now(),";
            $sql_a .= " ativo  =  'N'";
            $sql_a .= ' where idt_evento_combo_origem  = ' . null($vlID);
            $sql_a .= ' and idt_responsavel_unidade_lotacao  = ' . null($idt_responsavel_unidade_lotacao);
            $sql_a .= " and ativo  =  'S'";
            $sql_a .= " and tipo   =  'Evento Combo'";
            execsql($sql_a);

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_pendencia';
            $sql .= ' where idt_evento_combo_origem  = ' . null($vlID);
            $sql .= " and ativo = 'S'";
            $sql .= " and tipo = 'Evento Combo'";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                //Atualiza a Situação
                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao = 15 where idt = ' . null($vlID);
                execsql($sql_a);

                $campoLog = 'idt_evento_situacao';
                $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = 'Situação';
                $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_ant'] = $_POST['idt_evento_situacao'];
                $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetEventoSituacao[$_POST['idt_evento_situacao']];
                $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_atu'] = 15;
                $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $vetEventoSituacao[15];
            }

            $sql_a = "update grc_evento_combo ec";
            $sql_a .= " inner join grc_evento e on e.idt = ec.idt_evento";
            $sql_a .= " set ec.situacao = 'AP'";
            $sql_a .= " where ec.idt_evento_origem = " . null($vlID);
            $sql_a .= " and e.idt_unidade = " . null($idt_responsavel_unidade_lotacao);
            execsql($sql_a);

            $sql_a = "update grc_evento_combo_unidade";
            $sql_a .= " set situacao = 'AP',";
            $sql_a .= " idt_usuario_aprovacao = " . null($_SESSION[CS]['g_id_usuario']) . ",";
            $sql_a .= " dt_aprovacao = now()";
            $sql_a .= " where idt_evento = " . null($vlID);
            $sql_a .= " and idt_unidade = " . null($idt_responsavel_unidade_lotacao);
            execsql($sql_a);
        }
        break;

    case 'grc_evento':
        $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade, prd.codigo as codigo_produto";
        $sql .= ' from grc_evento grc_e';
        $sql .= ' inner join grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
        $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
        $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
        $sql .= ' left outer join grc_produto prd on prd.idt = grc_e.idt_produto';
        $sql .= " where grc_e.idt  = " . null($vlID);
        $sql_evento = $sql;

        if ($_POST['idt_pfo_af_processo'] == '') {
            EventoCompostoSincroniza($vlID, true);

            $rs = execsql($sql_evento);
            $rowe = $rs->data[0];

            $idt_produto = $_POST['idt_produto'];
            $texto = $_POST['vinculo_texto'];
            $idt_evento = $vlID;

            $sql_a = ' update grc_evento set ';
            $sql_a .= ' temporario = ' . aspa('N');
            $sql_a .= ' where idt = ' . null($vlID);
            $result = execsql($sql_a);

            checa_cred_necessita_credenciado($idt_evento);
            CalcularInsumoEvento($idt_evento);

            //Eventos SebraeTec não tem Política de Desconto
            if ($rowe['tipo_ordem'] == 'SG') {
                $sql = '';
                $sql .= ' delete from grc_evento_publicacao';
                $sql .= ' where idt_evento = ' . null($idt_evento);
                execsql($sql);
            }

            if ($rowe['composto'] != 'S') {
                if ($rowe['tipo_ordem'] == 'SG' && $rowe['sgtec_modelo'] == 'E') {
                    $sql = '';
                    $sql .= ' select ei.custo_total';
                    $sql .= ' from grc_evento_insumo ei';
                    $sql .= ' where ei.idt_evento = ' . null($idt_evento);
                    $sql .= " and ei.codigo = '71001'";
                    $rsa = execsql($sql);

                    $sql = '';
                    $sql .= ' update grc_evento set';
                    $sql .= ' custo_tot_consultoria = ' . null($rsa->data[0][0]);
                    $sql .= ' where idt = ' . null($idt_evento);
                    execsql($sql);
                } else {
                    ajustaTotaisEvento($idt_evento);
                }
            }

            $rs = execsql($sql_evento);
            $rowe = $rs->data[0];

            //Atualiza a previsão de horas no mes
            if (is_array($_POST['inc_cliente_mes']) && $_POST['inc_cliente_prev'] == 'N') {
                $sql = '';
                $sql .= ' select idt, descricao, qtd';
                $sql .= ' from grc_evento_agenda_prev';
                $sql .= ' where idt_evento = ' . null($vlID);
                $rs = execsql($sql);

                $vetMesPrev = Array();

                foreach ($rs->data as $row) {
                    $vetMesPrev[$row['idt']] = Array(
                        'desc' => $row['descricao'],
                        'vl' => format_decimal($row['qtd']),
                    );
                }

                foreach ($_POST['inc_cliente_mes'] as $key => $value) {
                    $campoLog = 'inc_cliente_mes_' . $key;

                    $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = 'Previsão de horas no mês ' . $vetMesPrev[$key]['desc'];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetMesPrev[$key]['vl'];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $value;

                    $sql_a = ' update grc_evento_agenda_prev set ';
                    $sql_a .= ' qtd = ' . null(desformat_decimal($value));
                    $sql_a .= ' where idt = ' . null($key);
                    execsql($sql_a);
                }
            }

            //Atualiza o Público Alvo do Evento
            if ($_POST['situacao'] != 'alt_programa' && $_POST['situacao'] != 'reload_tela') {
                $sql = '';
                $sql .= ' select df.idt_publico_alvo_outro, d.descricao, df.ativo';
                $sql .= ' from grc_publico_alvo d';
                $sql .= ' inner join grc_evento_publico_alvo df on d.idt = df.idt_publico_alvo_outro';
                $sql .= ' where df.idt = ' . null($vlID);
                $sql .= ' order by d.codigo';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $campoLog = 'pa' . $row['idt_publico_alvo_outro'];
                    $vl = $_POST['pa'][$row['idt_publico_alvo_outro']];

                    if ($vl == '') {
                        $vl = 'N';
                    }

                    $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = '[Público Alvo] ' . $row['descricao'];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_ant'] = $row['ativo'];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetSimNao[$row['ativo']];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_atu'] = $vl;
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $vetSimNao[$vl];

                    $sql_a = ' update grc_evento_publico_alvo set ';
                    $sql_a .= ' ativo = ' . aspa($vl);
                    $sql_a .= ' where idt = ' . null($vlID);
                    $sql_a .= ' and idt_publico_alvo_outro = ' . null($row['idt_publico_alvo_outro']);
                    execsql($sql_a);
                }

                geraPublicoAlvoPoliticaDesconto($vlID, false);
            }

            //EM TRAMITAÇÃO
            if ($_POST['situacao'] == 6) {
                $sql_a = 'update grc_evento set idt_evento_situacao_antes_aprovacao = idt_evento_situacao where idt = ' . null($idt_evento);
                execsql($sql_a);

                if ($rowe['tipo_ordem'] == 'SG' && $rowe['sgtec_modelo'] == 'E' && $rowe['vl_determinado'] == 'S') {
                    //Cria a Ordem de Contratação
                    $automatico = true;
                    $usa_rodizio = true;
                    $variavel = array();
                    $ret = GEC_contratacao_credenciado_ordem($idt_evento, $variavel, $automatico, $usa_rodizio, false);

                    if ($variavel['erro'] == '') {
                        commit();
                        beginTransaction();

                        $_POST['situacao'] = grc_evento_dep_situacao_6($idt_evento, $rowe);
                    } else {
                        rollBack();

                        foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
                            $chave_origem = 'GC' . $ordem_codigo;
                            $mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
                            $vetIdMov = Array();

                            $sql = '';
                            $sql .= ' select rm.rm_idmov';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                            $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
                            $sql .= ' where o.codigo = ' . aspa($ordem_codigo);
                            $sql .= ' and rm.rm_idmov is not null';
                            $rstt = execsql($sql);

                            foreach ($rstt->data as $rowtt) {
                                $vetIdMov[] = $rowtt['rm_idmov'];
                            }

                            CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
                        }

                        $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
                        erro_try($variavel['erro'], 'evento_ordem_sg');
                        msg_erro($variavel['erro']);
                    }
                } else {
                    $_POST['situacao'] = grc_evento_dep_situacao_6($vlID, $rowe);
                }

                if ($_POST['situacao'] != 14) {
                    $_POST['situacao'] = 6;
                }
            }

            //Aguardando aprovação do Coordenador/Gerente
            if ($_POST['situacao'] == 3) {
                $idtSecaoPA = $rowe['idt_ponto_atendimento'];
                $idtSecaoUN = $rowe['idt_unidade'];

                //Diretoria
                $vetCod = explode('.', $rowe['classificacao_unidade']);
                $vetCod[1] = '00';

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
                $rs = execsql($sql);
                $idtSecaoDI = $rs->data[0][0];

                //Coordenador / Gerente
                $sql = '';
                $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
                $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($rowe['idt_instrumento']);
                $sql .= " where f.tipo_alcada_evento = 'CG'";
                $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                $sql .= " and p.ativo = 'S'";
                $sql .= ' and ea.vl_alcada >= ' . null($rowe['previsao_despesa']);
                $rsCG = execsql($sql);

                if ($rsCG->rows == 0) {
                    $sql = '';
                    $sql .= ' select max(ea.vl_alcada) as max';
                    $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                    $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                    $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                    $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($rowe['idt_instrumento']);
                    $sql .= " where f.tipo_alcada_evento = 'CG'";
                    $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                    $sql .= " and p.ativo = 'S'";
                    $rsCG = execsql($sql);
                    $max = $rsCG->data[0][0];

                    if ($max === '' || is_null($max)) {
                        $sql = '';
                        $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, null as vl_alcada';
                        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                        $sql .= " where f.tipo_alcada_evento = 'CG'";
                        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                        $sql .= " and p.ativo = 'S'";
                        $rsCG = execsql($sql);
                    } else {
                        $sql = '';
                        $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo, ea.vl_alcada';
                        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                        $sql .= ' inner join ' . db_pir_grc . 'grc_evento_alcada ea on ea.idt_sca_organizacao_funcao = p.idt_funcao and ea.idt_instrumento = ' . null($rowe['idt_instrumento']);
                        $sql .= " where f.tipo_alcada_evento = 'CG'";
                        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                        $sql .= " and p.ativo = 'S'";
                        $sql .= ' and ea.vl_alcada = ' . null($max);
                        $rsCG = execsql($sql);
                    }
                }

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_evento  = ' . null($idt_evento);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Evento'";
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' idt_evento_situacao  = ' . null($_POST['situacao']);
                $sql_a .= ' where idt  = ' . null($idt_evento);
                $result = execsql($sql_a);

                $data_solucaow = date('d/m/Y');
                $assuntow = $rowe['descricao'];
                $observacaow = '[' . $rowe['instrumento'] . '] ' . $rowe['descricao'];

                foreach ($rsCG->data as $row) {
                    PendenciaAprovacao($idt_evento, $_POST['situacao'], $rowe['idt_ponto_atendimento'], $row['id_usuario'], $data_solucaow, $assuntow, $observacaow, $rowe['codigo']);
                }

                $protocolo = date('dmYHis');

                $vetGRC_parametros = GRC_parametros();
                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_03'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_04'], $protocolo, $rowe);

                foreach ($rsCG->data as $row) {
                    $txt = $mensagem;
                    $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                    enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
                }

                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_13'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_14'], $protocolo, $rowe);

                $sql = '';
                $sql .= ' select email, nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $txt = $mensagem;
                    $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                    enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
                }
            }

            //Aguardando a aprovação do Diretor
            if ($_POST['situacao'] == 7) {
                $idtSecaoPA = $rowe['idt_ponto_atendimento'];
                $idtSecaoUN = $rowe['idt_unidade'];

                //Diretoria
                $vetCod = explode('.', $rowe['classificacao_unidade']);
                $vetCod[1] = '00';

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
                $rs = execsql($sql);
                $idtSecaoDI = $rs->data[0][0];

                //Diretor
                $sql = '';
                $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
                $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                $sql .= " where f.tipo_alcada_evento = 'DI'";
                $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                $sql .= " and p.ativo = 'S'";
                $rsDI = execsql($sql);

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_evento  = ' . null($idt_evento);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Evento'";
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' idt_evento_situacao  = ' . null($_POST['situacao']);
                $sql_a .= ' where idt  = ' . null($idt_evento);
                $result = execsql($sql_a);

                $data_solucaow = date('d/m/Y');
                $assuntow = $rowe['descricao'];
                $observacaow = '[' . $rowe['instrumento'] . '] ' . $rowe['descricao'];

                foreach ($rsDI->data as $row) {
                    PendenciaAprovacao($idt_evento, $_POST['situacao'], $rowe['idt_ponto_atendimento'], $row['id_usuario'], $data_solucaow, $assuntow, $observacaow, $rowe['codigo']);
                }

                $protocolo = date('dmYHis');

                $vetGRC_parametros = GRC_parametros();
                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_03'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_04'], $protocolo, $rowe);

                foreach ($rsDI->data as $row) {
                    $txt = $mensagem;
                    $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                    enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
                }

                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_13'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_14'], $protocolo, $rowe);

                $sql = '';
                $sql .= ' select email, nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $txt = $mensagem;
                    $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                    enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
                }
            }

            //CancelarDespacho
            if ($_POST['situacao'] == 1) {
                $sql = '';
                $sql .= ' select data';
                $sql .= ' from grc_atendimento_pendencia';
                $sql .= ' where idt_evento = ' . null($idt_evento);
                $sql .= ' and idt_usuario = ' . null($_SESSION[CS]['g_id_usuario']);
                $sql .= " and ativo = 'S'";
                $sql .= " and tipo = 'Evento'";
                $rs = execsql($sql);
                $dtPenAberta = $rs->data[0][0];

                $sql = '';
                $sql .= ' select data, idt_usuario, idt_evento_situacao_de';
                $sql .= ' from grc_atendimento_pendencia';
                $sql .= ' where idt_evento = ' . null($idt_evento);
                $sql .= ' and data >= ' . aspa($dt_inicio_aprovacao);
                $sql .= ' and data < ' . aspa($dtPenAberta);
                $sql .= " and ativo = 'N'";
                $sql .= " and tipo = 'Evento'";
                $sql .= ' order by data desc';
                $rs = execsql($sql);
                $rowPen = $rs->data[0];
                $tmp = $rowPen['idt_evento_situacao_de'];

                if ($tmp == '') {
                    $sql = '';
                    $sql .= ' select idt_evento_situacao_antes_aprovacao';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt  = ' . null($idt_evento);
                    $rs = execsql($sql);
                    $tmp = $rs->data[0][0];
                }

                if ($tmp != '') {
                    $_POST['situacao'] = $tmp;
                }

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_evento  = ' . null($idt_evento);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Evento'";
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' idt_evento_situacao  =  ' . null($_POST['situacao']);
                $sql_a .= ' where idt  = ' . null($idt_evento);
                $result = execsql($sql_a);

                if ($rowPen['idt_usuario'] != '') {
                    $sql_a = ' update grc_atendimento_pendencia set ';
                    $sql_a .= " ativo  =  'S'";
                    $sql_a .= ' where idt_evento = ' . null($idt_evento);
                    $sql_a .= ' and data = ' . aspa($rowPen['data']);
                    $sql_a .= ' and idt_usuario = ' . null($rowPen['idt_usuario']);
                    $sql_a .= ' and idt_evento_situacao_de = ' . null($rowPen['idt_evento_situacao_de']);
                    $sql_a .= " and ativo  =  'N'";
                    $sql_a .= " and tipo   =  'Evento'";
                    execsql($sql_a);
                }

                $_POST['situacao'] = 1;
            }

            //CANCELADO
            if ($_POST['situacao'] == 4) {
                SolicitarCancelarEvento($vlID);

                if ($rowe['tipo_ordem'] == 'SG' && $rowe['sgtec_modelo'] == 'E') {
                    //sincroniza Evento
                    $sql = "delete from grc_sincroniza_siac";
                    $sql .= ' where idt_evento = ' . null($vlID);
                    execsql($sql);

                    $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo) values (';
                    $sql .= null($vlID) . ", 'EV_EXC')";
                    execsql($sql);

                    $ssaIdtEvento = $vlID;
                    require_once 'sincroniza_siac_acao.php';
                }
            }

            //AGENDADO
            if ($_POST['situacao'] == 14) {
                $enviaEmailOrdemContratacaoAssinatura = '';
                $vet = Array();
                $vet['idt_instrumento'] = $_POST['idt_instrumento'];
                $vet['idt_evento'] = $vlID;
                AprovarEvento($vet);

                //Aprova a Politica de Desconto
                $sql = "update grc_evento_publicacao set situacao = 'AP'";
                $sql .= " where idt_evento = " . null($vlID);
                $sql .= " and ativo = 'S'";
                $sql .= " and situacao = 'CD'";
                execsql($sql);

                if ($rowe['tipo_ordem'] == 'SG') {
                    $cancelaRM = false;
                    $erro = '';

                    $sql = 'update grc_evento set qtd_minima_pagantes = quantidade_participante';
                    $sql .= " where idt = " . null($vlID);
                    execsql($sql);

                    if ($rowe['sgtec_modelo'] == 'H' || $rowe['vl_determinado'] == 'N') {
                        $sql = '';
                        $sql .= ' select gec_ord.idt_gec_contratacao_status, gec_ord.rm_consolidado, gec_ol.idt_organizacao, gec_ol.idt_gec_contratacao_credenciado_ordem';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem gec_ord';
                        $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_ol on gec_ord.idt = gec_ol.idt_gec_contratacao_credenciado_ordem";
                        $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_ol.idt_organizacao = gec_o.idt";
                        $sql .= ' where gec_ord.idt_evento = ' . null($vlID);
                        $sql .= " and gec_ord.ativo = 'S'";
                        $sql .= " and gec_ol.ativo = 'S'";
                        $rsi = execsql($sql);
                        $rowi = $rsi->data[0];

                        if ($rsi->rows == 0) {
                            $erro = 'Não tem o registro do indicado na ordem de contratação (Credenciado)!';
                        } else if ($rsi->rows > 1) {
                            $vet['erro'] = rawurlencode('O evento tem mais de uma ordem ativa! Só pode ter uma.');
                        } else if ($rowi['idt_gec_contratacao_status'] != 9) {
                            $erro = 'A ordem de contratação (Credenciado) não foi concluida!';
                        } else if ($rowi['idt_organizacao'] == '') {
                            $erro = 'Tem que informar a Organização do Indicado na ordem de contratação (Credenciado)!';
                        } else if ($rowi['rm_consolidado'] == 'R') {
                            $erro = 'Não pode fazer a consolidação do realizado, pois já foi feita! (1)';
                        } else {
                            $sql = '';
                            $sql .= ' select rm_idmov';
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                            $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                            $sql .= ' and rm_idmov is not null';
                            $sql .= " and rm_cancelado = 'N'";
                            $rs = execsql($sql);

                            if ($rs->rows > 0) {
                                $erro = 'Não tem informação para fazer a consolidação do realizado! (1)';
                            } else {
                                sincronizaAgendaEventoSG($rowi['idt_gec_contratacao_credenciado_ordem'], $vlID);

                                if ($rowe['nao_sincroniza_rm'] == 'N') {
                                    if ($rowi['rm_consolidado'] == 'N') {
                                        $cancelaRM = true;
                                        $vetErro = rmConsolidacaoPrevista($rowi['idt_gec_contratacao_credenciado_ordem'], 'valor_real');
                                    } else {
                                        $vetErro = Array();
                                    }

                                    if (count($vetErro) > 0) {
                                        $erro = implode('<br />', $vetErro);
                                    } else {
                                        $vetErro = rmConsolidacaoRealizado($rowi['idt_gec_contratacao_credenciado_ordem']);

                                        if (count($vetErro) > 0) {
                                            $erro = implode('<br />', $vetErro);
                                        } else {
                                            $sql = '';
                                            $sql .= ' select gec_ol.idt';
                                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista gec_ol';
                                            $sql .= ' where gec_ol.idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                                            $sql .= " and gec_ol.ativo = 'S'";
                                            $rs = execsql($sql);

                                            geraContratoOrdemContratacao($rs->data[0][0]);

                                            if ($rowe['sgtec_modelo'] == 'E') {
                                                //AGUARDANDO ASSINATURA
                                                $sql = 'update ' . db_pir_grc . 'grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                                                execsql($sql);

                                                $sql = 'update ' . db_pir_grc . 'grc_evento set idt_evento_situacao = 9';
                                                $sql .= ' where idt = ' . null($vlID);
                                                execsql($sql);

                                                $enviaEmailOrdemContratacaoAssinatura = $rs->data[0][0];
                                            }
                                        }
                                    }
                                } else {
                                    $sql = "update " . db_pir_gec . "gec_contratacao_credenciado_ordem set rm_consolidado = 'R'";
                                    $sql .= ' where idt = ' . null($rowi['idt_gec_contratacao_credenciado_ordem']);
                                    execsql($sql);

                                    $sql = '';
                                    $sql .= ' insert into ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_agenda (idt_gec_contratacao_credenciado_ordem, idt_evento, tipo, dt_ini, dt_fim, tot_hora, obs)';
                                    $sql .= " select {$rowi['idt_gec_contratacao_credenciado_ordem']} as idt_gec_contratacao_credenciado_ordem, ea.idt_evento, '{$tipo}' as tipo, ea.dt_ini, ea.dt_fim, ea.carga_horaria as tot_hora, ea.observacao as obs";
                                    $sql .= ' from grc_evento_agenda ea';
                                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                                    $sql .= ' where ea.idt_evento = ' . $vlID;
                                    $sql .= whereEventoParticipante();
                                    $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                                    execsql($sql);

                                    geraContratoOrdemContratacao($rs->data[0][0]);

                                    if ($rowe['sgtec_modelo'] == 'E') {
                                        //AGUARDANDO ASSINATURA
                                        $sql = 'update ' . db_pir_grc . 'grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                                        execsql($sql);

                                        $sql = 'update ' . db_pir_grc . 'grc_evento set idt_evento_situacao = 9';
                                        $sql .= ' where idt = ' . null($vlID);
                                        execsql($sql);

                                        $enviaEmailOrdemContratacaoAssinatura = $rs->data[0][0];
                                    }
                                }
                            }
                        }
                    } else {
                        $sql = '';
                        $sql .= ' select idt, codigo, automatico, usa_rodizio, idt_gec_contratacao_status';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
                        $sql .= ' where idt_evento = ' . null($vlID);
                        $sql .= " and gec_ord.ativo = 'S'";
                        $rsi = execsql($sql);

                        if ($rsi->rows == 0) {
                            $erro = 'Não tem o registro da ordem de contratação (Credenciado)!';
                        } else if ($rsi->rows > 1) {
                            $erro = 'O evento tem mais de uma ordem ativa! Só pode ter uma.';
                        } else {
                            $rowi = $rsi->data[0];

                            if ($rowi['automatico'] == 'S' && $rowi['usa_rodizio'] == 'S') {
                                $vetRodizio = geraRodizioOrdemContratacao($rowi['idt']);

                                //Grava o Rodizio
                                $idt_ordem_contratacao_lista = gravaRodizioOrdemContratacao($vetRodizio, $rowi['codigo'], $rowi['idt']);

                                if ($idt_ordem_contratacao_lista == 0) {
                                    $erro = 'Erro na gravação do rodizio!';
                                }

                                if ($vetRodizio['tem_habilitado'] == 'S') {
                                    $sql = "select * from " . db_pir_gec . "plu_config where ordem = '04'";
                                    $rsGEC = execsql($sql);

                                    $vetConfGEC = Array();

                                    ForEach ($rsGEC->data as $rowGEC) {
                                        $vetConfGEC[$rowGEC['variavel']] = trim($rowGEC['valor'] . ($rowGEC['extra'] == '' ? '' : ' ' . $rowGEC['extra']));
                                    }

                                    $hora = ' ' . (date('H') - date('I')) . ':' . date('i');

                                    $dt_aviso_ini = getdata(false, true);
                                    $dt_aviso_fim = Calendario::Intervalo_Util($dt_aviso_ini, $vetConfGEC['grc_rodizio_dia_cotacao']);

                                    $dt_contratacao_ini = $rowe['dt_previsao_inicial'];
                                    $dt_contratacao_fim = $rowe['dt_previsao_fim'];

                                    $dt_aviso_ini = trata_data($dt_aviso_ini . $hora);
                                    $dt_aviso_fim = trata_data($dt_aviso_fim . $hora);
                                    $dt_contratacao_ini = trata_data($dt_contratacao_ini);
                                    $dt_contratacao_fim = trata_data($dt_contratacao_fim);

                                    $sql = ' update grc_evento set ';
                                    $sql .= ' idt_evento_situacao  = 24';
                                    $sql .= ' where idt  = ' . null($vlID);
                                    execsql($sql);

                                    $sql = '';
                                    $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                                    $sql .= ' dt_contratacao_ini = ' . aspa($dt_contratacao_ini) . ',';
                                    $sql .= ' dt_contratacao_fim = ' . aspa($dt_contratacao_fim) . ',';
                                    $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                                    $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim);
                                    $sql .= ' where idt = ' . null($rowi['idt']);
                                    execsql($sql);

                                    $sql = '';
                                    $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_lista set';
                                    $sql .= ' envia_aviso = 1,';
                                    $sql .= ' dt_ini_aviso_1 = ' . aspa($dt_aviso_ini) . ',';
                                    $sql .= ' dt_fim_aviso_1 = ' . aspa($dt_aviso_fim) . ',';
                                    $sql .= ' data_inicio_cotacao = ' . aspa($dt_aviso_ini) . ',';
                                    $sql .= ' data_final_cotacao = ' . aspa($dt_aviso_fim) . ',';
                                    $sql .= ' dt_utl_aviso = ' . aspa($dt_aviso_ini);
                                    $sql .= ' where idt = ' . null($idt_ordem_contratacao_lista);
                                    execsql($sql);

                                    //Envia Aviso
                                    $erroEOC = '';
                                    $erroEOC = enviaEmailOrdemContratacao($idt_ordem_contratacao_lista);

                                    if ($erroEOC != '') {
                                        $erro = $erroEOC;
                                    }
                                }
                            }
                        }
                    }

                    if ($erro != '') {
                        rollBack();

                        if ($cancelaRM) {
                            $sql = '';
                            $sql .= " select ord.idt, ord.codigo";
                            $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem ord';
                            $sql .= ' where ord.idt_evento = ' . null($vlID);
                            $sql .= " and ord.ativo = 'S'";
                            $rs = execsql($sql);
                            $rowo = $rs->data[0];

                            //Verifica lixo no RM
                            if ($rowo['codigo'] != '') {
                                $chave_origem = 'GC' . $rowo['codigo'];
                                $mensagemRM = 'Erro na Aprovação do Evento';
                                $vetIdMov = Array();

                                CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);

                                $sql = '';
                                $sql .= ' delete from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                                $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowo['idt']);
                                execsql($sql);

                                $sql = '';
                                $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem set';
                                $sql .= " rm_consolidado = 'N'";
                                $sql .= ' where idt = ' . null($rowo['idt']);
                                execsql($sql);
                            }
                        }

                        $erro = 'Erro na geração da Ordem de Contratação.<br />' . $erro;
                        erro_try($erro, 'evento_aprovacao');
                        msg_erro($erro);
                    }

                    //sincronização com o RM
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_atendimento';
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $rsa = execsql($sql);

                    foreach ($rsa->data as $rowa) {
                        sincronizaAtendimentoGEC($rowa['idt']);

                        if ($rowe['nao_sincroniza_rm'] == 'N') {
                            $sql = '';
                            $sql .= ' select idt';
                            $sql .= ' from grc_sincroniza_siac';
                            $sql .= ' where idt_atendimento = ' . null($rowa['idt']);
                            $sql .= " and tipo = 'RM_INC'";
                            $rst = execsql($sql);

                            if ($rst->rows == 0) {
                                $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, tipo) values (';
                                $sql .= null($rowa['idt']) . ', ' . null($vlID) . ", 'RM_INC')";
                                execsql($sql);
                            } else {
                                $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                                $sql .= ' where idt = ' . null($rst->data[0][0]);
                                execsql($sql);
                            }
                        }
                    }
                } else {
                    $gera_ordem = false;
                    $automatico = false;
                    $usa_rodizio = true;

                    if ($_POST['cred_necessita_credenciado'] == 'S' && $_POST['cred_rodizio_auto'] == 'S') {
                        $gera_ordem = true;
                        $automatico = true;
                    }

                    if ($_POST['cred_necessita_credenciado'] == 'S' && $_POST['cred_rodizio_auto'] == 'N' && $_POST['cred_credenciado_sgc'] == 'S') {
                        $gera_ordem = true;
                        $automatico = false;
                    }

                    //Não fazer rodizio em Produção
                    //if (debug !== true) {
                    $usa_rodizio = false;
                    //}

                    if ($gera_ordem) {
                        $variavel = array();
                        $ret = GEC_contratacao_credenciado_ordem($vlID, $variavel, $automatico, $usa_rodizio, false);

                        if ($variavel['erro'] != '') {
                            rollBack();

                            foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
                                $chave_origem = 'GC' . $ordem_codigo;
                                $mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
                                $vetIdMov = Array();

                                $sql = '';
                                $sql .= ' select rm.rm_idmov';
                                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                                $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
                                $sql .= ' where o.codigo = ' . aspa($ordem_codigo);
                                $sql .= ' and rm.rm_idmov is not null';
                                $rstt = execsql($sql);

                                foreach ($rstt->data as $rowtt) {
                                    $vetIdMov[] = $rowtt['rm_idmov'];
                                }

                                CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
                            }

                            $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
                            erro_try($variavel['erro'], 'evento_ordem_gc');
                            msg_erro($variavel['erro']);
                        }
                    }
                }

                $vetEV = Array();

                if ($rowe['composto'] == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt_evento_pai = ' . null($vlID);
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $vetEV[] = $rowt['idt'];
                    }
                } else {
                    $vetEV[] = $vlID;
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                    $sql .= " and tipo = 'EV'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo, representa) values (';
                        $sql .= null($idt_evento_tmp) . ", 'EV', 'N')";
                        execsql($sql);
                    } else {
                        $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null, representa = 'N'";
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }
                }

                $ssaIdtEvento = implode(', ', $vetEV);
                require_once 'sincroniza_siac_acao.php';

                commit();
                beginTransaction();

                if ($enviaEmailOrdemContratacaoAssinatura != '') {
                    enviaEmailOrdemContratacaoAssinatura($enviaEmailOrdemContratacaoAssinatura);
                }

                $vetGRC_parametros = GRC_parametros();
                $assunto = $vetGRC_parametros['grc_atendimento_pendencia_07'];
                $mensagem = $vetGRC_parametros['grc_atendimento_pendencia_08'];

                $protocolo = date('dmYHis');

                $mensagem = str_replace('#protocolo', $protocolo, $mensagem);
                $mensagem = str_replace('#data', date('d/m/Y H:i:s'), $mensagem);

                $sql = '';
                $sql .= ' select nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);
                $mensagem = str_replace('#solicitante', $rs->data[0][0], $mensagem);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where idt = ' . null($rowe['idt_ponto_atendimento']);
                $rs = execsql($sql);
                $mensagem = str_replace('#ponto_atendimento', $rs->data[0][0], $mensagem);

                $mensagem = str_replace('#codigo', $rowe['codigo'], $mensagem);

                $sql = '';
                $sql .= ' select desccid';
                $sql .= ' from ' . db_pir_siac . 'cidade';
                $sql .= ' where codcid = ' . null($rowe['idt_cidade']);
                $rs = execsql($sql);
                $mensagem = str_replace('#cidade', $rs->data[0][0], $mensagem);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from grc_evento_local_pa';
                $sql .= ' where idt = ' . null($rowe['idt_local']);
                $rs = execsql($sql);
                $mensagem = str_replace('#local', $rs->data[0][0], $mensagem);

                $mensagem = str_replace('#descricao', $rowe['descricao'], $mensagem);
                $mensagem = str_replace('#dt_previsao_inicial', trata_data($rowe['dt_previsao_inicial']), $mensagem);
                $mensagem = str_replace('#dt_previsao_fim', trata_data($rowe['dt_previsao_fim']), $mensagem);
                $mensagem = str_replace('#hora_inicio', $rowe['hora_inicio'], $mensagem);
                $mensagem = str_replace('#hora_fim', $rowe['hora_fim'], $mensagem);
                $mensagem = str_replace('#observacao', $rowe['observacao'], $mensagem);

                $sql = '';
                $sql .= ' select email, nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);
                $row = $rs->data[0];

                enviarEmail(db_pir_grc, $assunto, $mensagem, $row['email'], $row['nome_completo']);
            }

            // 5 - DEVOLVIDO
            // 8 - Devolver para Cotacao Finalizada
            if ($_POST['situacao'] == 5 || $_POST['situacao'] == 8) {
                $vet = Array();
                $vet['idt_instrumento'] = $_POST['idt_instrumento'];
                $vet['idt_evento'] = $vlID;
                SolicitarAjustesEvento($vet);

                $vetGRC_parametros = GRC_parametros();
                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_05'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_06'], $protocolo, $rowe);

                $sql = '';
                $sql .= ' select email, nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $txt = $mensagem;
                $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
            }

            //CANCELADO depois do agendamento
            if ($_POST['situacao'] == 21 || $_POST['situacao'] == 22) {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_evento_situacao_para = " . null($_POST['situacao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_evento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Evento'";
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= " ativo = 'N', ";
                $sql_a .= ' idt_evento_situacao  = 22';
                $sql_a .= ' where idt  = ' . null($vlID);
                execsql($sql_a);

                commit();

                //sincroniza Evento
                $vetEV = Array();

                if ($rowe['composto'] == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt_evento_pai = ' . null($vlID);
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $vetEV[] = $rowt['idt'];
                    }
                } else {
                    $vetEV[] = $vlID;
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    $sql = "delete from grc_sincroniza_siac";
                    $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                    execsql($sql);

                    $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo) values (';
                    $sql .= null($idt_evento_tmp) . ", 'EV_EXC')";
                    execsql($sql);
                }

                $ssaIdtEvento = implode(', ', $vetEV);
                require_once 'sincroniza_siac_acao.php';

                beginTransaction();

                SolicitarCancelarEvento($vlID);

                commit();
                beginTransaction();

                $protocolo = date('dmYHis');

                $vetGRC_parametros = GRC_parametros();
                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_11'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_12'], $protocolo, $rowe);

                $vetEnviar = Array();

                //responsável pelo evento, aprovador
                $sql = '';
                $sql .= ' select distinct u.email, u.nome_completo';
                $sql .= ' from plu_usuario u';
                $sql .= ' inner join (';
                $sql .= ' select idt_autorizador';
                $sql .= ' from grc_evento_autorizador';
                $sql .= ' where idt_ponto_atendimento = ' . null($rowe['idt_unidade']);

                if ($rowe['idt_gestor_projeto'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowe['idt_gestor_projeto'] . ' as idt_autorizador';
                }

                if ($rowe['idt_gestor_evento'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowe['idt_gestor_evento'] . ' as idt_autorizador';
                }

                if ($rowe['idt_responsavel'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowe['idt_responsavel'] . ' as idt_autorizador';
                }

                $sql .= ' ) as ea on ea.idt_autorizador = u.id_usuario';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome_completo'];
                }

                //unidades de suporte
                if ($vetConf['email_canc_evento_suporte'] != '') {
                    $vetEnviar[$vetConf['email_canc_evento_suporte']] = $vetConf['email_canc_evento_suporte'];
                }

                //financeiro
                if ($vetConf['email_canc_evento_financeiro'] != '') {
                    $vetEnviar[$vetConf['email_canc_evento_financeiro']] = $vetConf['email_canc_evento_financeiro'];
                }

                //fornecedores contratados e/ou convidados
                $sql = '';
                $sql .= " select distinct gec_o.descricao as organizacao, usu_o.email as organizacao_email";
                $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista gec_lst";
                $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem gec_ord on gec_lst.idt_gec_contratacao_credenciado_ordem = gec_ord.idt";
                $sql .= " left outer join " . db_pir_gec . "gec_entidade gec_o on gec_lst.idt_organizacao = gec_o.idt";
                $sql .= " left outer join " . db_pir_gec . "plu_usuario usu_o on gec_o.codigo = usu_o.login";
                $sql .= ' where gec_ord.idt_evento = ' . null($vlID);
                $sql .= " and gec_ord.ativo = 'S'";
                $sql .= " and gec_lst.ativo = 'S'";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['organizacao_email']] = $row['organizacao'];
                }

                //clientes vinculados
                $sql = '';
                $sql .= ' select distinct p.nome, p.email';
                $sql .= ' from grc_atendimento_pessoa p';
                $sql .= ' inner join grc_atendimento a on a.idt = p.idt_atendimento';
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = p.idt_atendimento";
                $sql .= ' where a.idt_evento = ' . null($vlID);
                $sql .= whereEventoParticipante();
                $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $vetEnviar[$row['email']] = $row['nome'];
                }

                foreach ($vetEnviar as $email => $nome) {
                    if ($email != '') {
                        if ($nome == '') {
                            $nome = $email;
                        }

                        $txt = $mensagem;
                        $txt = str_replace('#responsavel', $nome, $txt);

                        enviarEmail(db_pir_grc, $assunto, $txt, $email, $nome);
                    }
                }
            }

            //CONSOLIDADO
            if ($_POST['idt_evento_situacao'] == 19 || $_POST['situacao'] == 20) {
                $sql = '';
                $sql .= " select ap.idt, ap.idt_atendimento, ap.evento_concluio, ap.cpf, ap.nome";
                $sql .= " from grc_atendimento a";
                $sql .= " left outer join grc_atendimento_pessoa ap on ap.idt_atendimento = a.idt ";
                $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
                $sql .= ' where a.idt_evento = ' . null($vlID);
                $sql .= " and ep.contrato in ('C', 'S', 'G')";
                $sql .= " and ep.ativo = 'S'";
                $rst = execsql($sql);

                foreach ($rst->data as $rowt) {
                    $campoLog = 'evento_concluio_' . $rowt['idt'];

                    if ($_POST[$campoLog] == '') {
                        $_POST[$campoLog] = 'N';
                    }

                    $vetLogDetalheExtra['grc_evento'][$campoLog]['campo_desc'] = 'Concluio o evento ' . $rowt['cpf'] . ' ' . $rowt['nome'] . ' [' . $rowt['idt'] . ']';
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_ant'] = $rowt['evento_concluio'];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_ant'] = $vetSimNao[$rowt['evento_concluio']];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['vl_atu'] = $_POST[$campoLog];
                    $vetLogDetalheExtra['grc_evento'][$campoLog]['desc_atu'] = $vetSimNao[$_POST[$campoLog]];

                    $sql_a = ' update grc_atendimento_pessoa set ';
                    $sql_a .= ' evento_concluio = ' . aspa($_POST[$campoLog]);
                    $sql_a .= ' where idt = ' . null($rowt['idt']);
                    execsql($sql_a);
                }
            }

            //CONSOLIDADO
            if ($_POST['situacao'] == 20) {
                if ($rowe['seg_real_ini'] == '') {
                    $seg_real_ini = ':10';
                } else {
                    $seg_real_ini = $rowe['seg_real_ini'];
                }

                if ($rowe['muda_dt_hist'] == 'S') {
                    $siacweb_hist_hora_ini = substr($rowe['dt_real_ini'], 0, 16) . $seg_real_ini;
                    $siacweb_hist_hora_fim = $rowe['dt_real_fim'];
                } else {
                    $siacweb_hist_hora_ini = $rowe['dt_previsao_inicial'] . ' ' . $rowe['hora_inicio'] . $seg_real_ini;
                    $siacweb_hist_hora_fim = $rowe['dt_previsao_fim'] . ' ' . $rowe['hora_fim'];
                }

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' dt_consolidado = now(), ';
                $sql_a .= ' siacweb_hist_hora_ini  =  ' . aspa($siacweb_hist_hora_ini) . ', ';
                $sql_a .= ' siacweb_hist_hora_fim  =  ' . aspa($siacweb_hist_hora_fim) . ', ';
                $sql_a .= ' seg_real_ini  =  ' . aspa($seg_real_ini);
                $sql_a .= ' where idt  = ' . null($vlID);
                execsql($sql_a);

                commit();
                beginTransaction();

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= " sincroniza_loja = 'N',";
                $sql_a .= ' idt_evento_situacao  =  ' . null($_POST['situacao']);
                $sql_a .= ' where idt  = ' . null($vlID);
                execsql($sql_a);

                //sincroniza Evento (Legado)
                if ($rowe['tipo_sincroniza_siacweb'] != 'P' && $rowe['idt_instrumento'] == 2) {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $sql .= " and tipo = 'EV'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_evento, idt_responsavel, tipo) values (';
                        $sql .= null($vlID) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ", 'EV')";
                        execsql($sql);
                    } else {
                        $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                        $sql .= ', idt_responsavel = ' . null($_SESSION[CS]['g_id_usuario']);
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }
                }

                $vetEV = Array();

                if ($rowe['composto'] == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt_evento_pai = ' . null($vlID);
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $vetEV[] = $rowt['idt'];
                    }
                } else {
                    $vetEV[] = $vlID;
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                    $sql .= " and tipo = 'EV_CON'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_evento, idt_responsavel, tipo) values (';
                        $sql .= null($idt_evento_tmp) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ", 'EV_CON')";
                        execsql($sql);
                    } else {
                        $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                        $sql .= ', idt_responsavel = ' . null($_SESSION[CS]['g_id_usuario']);
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }
                }

                $ssaIdtEvento = implode(', ', $vetEV);
                require_once 'sincroniza_siac_acao.php';
            }

            //DESCONSOLIDADO (Voltar para PENDENTE)
            if ($_POST['situacao'] == 19) {
                //sincroniza Evento
                $vetEV = Array();

                if ($rowe['composto'] == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento';
                    $sql .= ' where idt_evento_pai = ' . null($vlID);
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $vetEV[] = $rowt['idt'];
                    }
                } else {
                    $vetEV[] = $vlID;
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    $sql = "delete from grc_sincroniza_siac where idt_evento = " . null($idt_evento_tmp);
                    $sql .= " and tipo = 'EV_CON'";
                    execsql($sql);

                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                    $sql .= " and tipo = 'EV_DESCON'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo) values (';
                        $sql .= null($idt_evento_tmp) . ", 'EV_DESCON')";
                        execsql($sql);
                    } else {
                        $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }
                }

                $ssaIdtEvento = implode(', ', $vetEV);
                require_once 'sincroniza_siac_acao.php';

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($vlID);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' idt_evento_situacao  = ' . null($_POST['situacao']);
                $sql_a .= ' where idt  = ' . null($vlID);
                execsql($sql_a);
            }

            //APROVAÇÃO DE CANCELAMENTO
            if ($_POST['situacao'] == 23) {
                $vet = Array();
                $vet['idt_instrumento'] = $_POST['idt_instrumento'];
                $vet['idt_evento'] = $vlID;
                SolicitarCancelamentoEvento($vet);

                $protocolo = date('dmYHis');

                $vetGRC_parametros = GRC_parametros();
                $assunto = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_09'], $protocolo, $rowe);
                $mensagem = grc_evento_dep_msgParametros($vetGRC_parametros['grc_atendimento_pendencia_10'], $protocolo, $rowe);

                $sql = '';
                $sql .= ' select distinct u.email, u.nome_completo';
                $sql .= ' from plu_usuario u';
                $sql .= ' inner join (';
                $sql .= ' select idt_autorizador';
                $sql .= ' from grc_evento_autorizador';
                $sql .= ' where idt_ponto_atendimento = ' . null($rowe['idt_unidade']);

                if ($rowe['idt_gestor_projeto'] != '') {
                    $sql .= ' union all';
                    $sql .= ' select ' . $rowe['idt_gestor_projeto'] . ' as idt_autorizador';
                }

                $sql .= ' ) as ea on ea.idt_autorizador = u.id_usuario';
                $sql .= ' where ea.idt_autorizador <> ' . null($rowe['idt_gestor_evento']);
                $sql .= ' and ea.idt_autorizador <> ' . null($rowe['idt_responsavel']);
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $txt = $mensagem;
                    $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                    enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
                }
            }

            //Devolver Cancelamento Evento
            if ($_POST['situacao'] == 'DevolverCancelamentoEvento') {
                $sql_a = 'select idt_evento_situacao_can from grc_evento where idt = ' . null($vlID);
                $rstt = execsql($sql_a);
                $idt_evento_situacao_can = $rstt->data[0][0];

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_evento_situacao_para = " . null($idt_evento_situacao_can) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_evento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Evento'";
                execsql($sql_a);

                $sql_a = 'update grc_evento set idt_evento_situacao = ' . null($idt_evento_situacao_can) . ', idt_evento_situacao_can = null where idt = ' . null($vlID);
                execsql($sql_a);
            }

            //Pré-Aprovação / Enviar para Cotação
            if ($_POST['situacao'] == 24) {
                grc_evento_dep_situacao_24($vlID, $rowe);
            }

            if ($_POST['situacao'] == 'CanPreAprovarEvento') {
                $sql_a = 'select idt_evento_situacao_ant from grc_evento where idt = ' . null($vlID);
                $rstt = execsql($sql_a);
                $tmp = $rstt->data[0][0];

                $sql_a = 'update grc_evento set idt_evento_situacao_ant = idt_evento_situacao where idt = ' . null($idt_evento);
                execsql($sql_a);

                $sql_a = ' update grc_evento set ';
                $sql_a .= ' idt_evento_situacao  =  ' . null($tmp);
                $sql_a .= ' where idt  = ' . null($idt_evento);
                $result = execsql($sql_a);
            }

            //Credenciado
            if ($_POST['situacao'] == 'Credenciado') {
                if ($rowe['tipo_ordem'] == 'SG') {
                    $gera_ordem = false;
                    $automatico = false;
                    $usa_rodizio = true;

                    if ($_POST['cred_necessita_credenciado'] == 'S' && $_POST['cred_rodizio_auto'] == 'S') {
                        $gera_ordem = true;
                        $automatico = true;
                    }

                    if ($_POST['cred_necessita_credenciado'] == 'S' && $_POST['cred_rodizio_auto'] == 'N' && $_POST['cred_credenciado_sgc'] == 'S') {
                        $gera_ordem = true;
                        $automatico = false;
                    }

                    if ($rowe['sgtec_modelo'] != 'E') {
                        $usa_rodizio = false;
                    }

                    if ($gera_ordem) {
                        $variavel = array();
                        $ret = GEC_contratacao_credenciado_ordem($vlID, $variavel, $automatico, $usa_rodizio, false);

                        if ($variavel['erro'] == '') {
                            echo '<script type="text/javascript">';
                            echo "var url = 'conteudo.php?prefixo=listar&menu=gec_contratacao_credenciado_ordem&origem_tela=menu&class=0&idt_evento={$vlID}';";
                            echo "OpenWin(url, 'AbrirOrdem{$vlID}', screen.width, screen.height, 0, 0);";
                            echo '</script>';
                        } else {
                            rollBack();

                            foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
                                $chave_origem = 'GC' . $ordem_codigo;
                                $mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
                                $vetIdMov = Array();

                                $sql = '';
                                $sql .= ' select rm.rm_idmov';
                                $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                                $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
                                $sql .= ' where o.codigo = ' . aspa($ordem_codigo);
                                $sql .= ' and rm.rm_idmov is not null';
                                $rstt = execsql($sql);

                                foreach ($rstt->data as $rowtt) {
                                    $vetIdMov[] = $rowtt['rm_idmov'];
                                }

                                CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
                            }

                            $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
                            erro_try($variavel['erro'], 'evento_ordem_sg');
                            msg_erro($variavel['erro']);
                        }
                    }
                }
            }

            //Alterar a Qtde. Participantes
            if ($_POST['situacao'] == 'alt_evento') {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_sincroniza_siac';
                $sql .= ' where idt_evento = ' . null($vlID);
                $sql .= " and tipo = 'EV'";
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_sincroniza_siac (idt_evento, tipo, representa) values (';
                    $sql .= null($vlID) . ", 'EV', 'N')";
                    execsql($sql);
                } else {
                    $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null, representa = 'N'";
                    $sql .= ' where idt = ' . null($rst->data[0][0]);
                    execsql($sql);
                }

                $ssaIdtEvento = $vlID;
                require_once 'sincroniza_siac_acao.php';
            }

            if ($_POST['situacao'] == 'alt_programa' || $_POST['situacao'] == 'reload_tela') {
                if ($rowe['tipo_ordem'] == 'SG') {
                    atualizaPagEventoSG($vlID);
                }

                $botao_acao = '<script type="text/javascript">self.location = "conteudo.php?' . $_SERVER['QUERY_STRING'] . '";</script>';
            }

            EventoCompostoSincroniza($vlID, true);
        } else {
            $rs = execsql($sql);
            $rowe = $rs->data[0];

            if (is_array($_POST['pfo_situacao'])) {
                foreach ($_POST['pfo_situacao'] as $idt => $dados) {
                    if ($dados['vl'] == '') {
                        $dados['vl'] = 'PE';
                    }

                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo_item set';
                    $sql .= ' situacao = ' . aspa($dados['vl']) . ',';
                    $sql .= ' obs_validacao = ' . aspa($dados['obs']) . ',';
                    $sql .= ' idt_validador = ' . null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_pfo)) . ',';
                    $sql .= ' dt_validacao = now()';
                    $sql .= ' where idt = ' . null($idt);
                    execsql($sql);
                }
            }

            $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
            $sql .= ' obs_validacao = ' . aspa($_POST['pfo_obs_validacao']);
            $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
            execsql($sql);

            if ($_POST['situacao'] != 'pfoSalvar') {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_pfo_af_processo  = ' . null($_POST['idt_pfo_af_processo']);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Pagamento a Credenciado'";
                execsql($sql_a);
            }

            $vetPOF_parametros = Array();

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_pfo . 'pfo_parametros pfo_pa';
            $sql .= " where codigo in ('pfo_af_processo_cred_03', 'pfo_af_processo_cred_04', 'pfo_af_processo_cred_05', 'pfo_af_processo_cred_06', 'pfo_af_processo_01', 'pfo_af_processo_02')";
            $rs = execsql($sql);

            ForEach ($rs->data as $row) {
                $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
                $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");
                $vetPOF_parametros[$codigo] = $detalhe;
            }

            $sql = '';
            $sql .= ' select login, email, nome_completo';
            $sql .= ' from ' . db_pir_pfo . 'plu_usuario';
            $sql .= ' where id_usuario = ' . null($_POST['pfo_idt_usuario']);
            $rs = execsql($sql);
            $rowUP = $rs->data[0];

            switch ($_POST['situacao']) {
                case 'pfoDevolver':
                case 'pfoDevolverDOC':
                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'RN'";
                    $sql .= ", status_liberacao = 'N'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    //fazer sincronia do siacweb para desconsolidação das atividades deste pagamento
                    if ($_POST['situacao'] == 'pfoDevolverDOC') {
                        $vetEV = Array();

                        if ($rowe['composto'] == 'S') {
                            $sql = '';
                            $sql .= ' select idt';
                            $sql .= ' from grc_evento';
                            $sql .= ' where idt_evento_pai = ' . null($vlID);
                            $sql .= ' and idt_instrumento = 2';
                            $sql .= " and tipo_sincroniza_siacweb = 'P'";
                            $rst = execsql($sql);

                            foreach ($rst->data as $rowt) {
                                $vetEV[] = $rowt['idt'];
                            }
                        } else {
                            if ($rowe['idt_instrumento'] == 2 && $rowe['tipo_sincroniza_siacweb'] == 'P') {
                                $vetEV[] = $vlID;
                            }
                        }

                        $dt_ini = '01/' . $_POST['pfo_mesano'];

                        $vetDT = DatetoArray($dt_ini);

                        $t = mktime(0, 0, 0, $vetDT['mes'], 1, $vetDT['ano']);
                        $dt_fim = Date('d/m/Y', strtotime('+1 month', $t));

                        foreach ($vetEV as $idt_evento_tmp) {
                            $sql = '';
                            $sql .= ' select ea.idt, ea.idt_atendimento';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento_atividade ea';
                            $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ea.idt_atendimento";
                            $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                            $sql .= ' where a.idt_evento = ' . null($idt_evento_tmp);
                            $sql .= whereEventoParticipante();
                            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                            $sql .= " and ea.consolidado_cred = 'S'";
                            $sql .= ' and ea.idt in (';
                            $sql .= ' select ag.idt_evento_atividade';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ag';
                            $sql .= ' where ag.data_inicial >= ' . aspa(trata_data($dt_ini));
                            $sql .= ' and ag.data_inicial < ' . aspa(trata_data($dt_fim));
                            $sql .= ' )';
                            $rs = execsql($sql);

                            foreach ($rs->data as $row) {
                                $sql = '';
                                $sql .= ' delete from grc_sincroniza_siac';
                                $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                                $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                                $sql .= " and tipo = 'EV_CON_AT'";
                                execsql($sql);

                                $sql = '';
                                $sql .= ' select idt';
                                $sql .= ' from grc_sincroniza_siac';
                                $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                                $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                                $sql .= " and tipo = 'EV_AT_EXC'";
                                $rst = execsql($sql);

                                if ($rst->rows == 0) {
                                    $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_atividade, tipo) values (';
                                    $sql .= null($row['idt_atendimento']) . ', ' . null($idt_evento_tmp) . ', ' . null($row['idt']) . ", 'EV_AT_EXC')";
                                    execsql($sql);
                                } else {
                                    $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                                    $sql .= ' where idt = ' . null($rst->data[0][0]);
                                    execsql($sql);
                                }
                            }
                        }

                        if (count($vetEV) > 0) {
                            $ssaIdtEvento = implode(', ', $vetEV);
                            require_once 'sincroniza_siac_acao.php';
                        }
                    }

                    $protocolo = date('dmYHis');

                    $assunto = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_03'], $protocolo, $rowe);
                    $mensagem = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_04'], $protocolo, $rowe);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'pfo_af_processo_cred_0304',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                    break;

                case 'pfoAprovarEA':
                    $sql = '';
                    $sql .= ' select afp.nf_idmov, afp.valida_nf_sem_doc';
                    $sql .= ' from ' . db_pir_pfo . 'pfo_af_processo afp';
                    $sql .= ' where afp.idt = ' . null($_POST['idt_pfo_af_processo']);
                    $rsPFO = execsql($sql);
                    $rowPFO = $rsPFO->data[0];

                    $diretoGFI = false;

                    if ($rowPFO['valida_nf_sem_doc'] == 'S' && $rowPFO['nf_idmov'] != '') {
                        $diretoGFI = true;
                    }

                    if ($diretoGFI) {
                        $sql = "update " . db_pir_pfo . "pfo_af_processo set situacao_reg = 'FI', gfi_situacao = 'CF', liberado_validacao = 'S' where idt = " . null($_POST['idt_pfo_af_processo']);
                        execsql($sql);
                    } else {
                        $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                        $sql .= " situacao_reg = 'GE'";
                        $sql .= ", status_liberacao = 'N'";
                        $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                        execsql($sql);
                    }

                    //fazer sincronia do siacweb para consolidação das atividades deste pagamento
                    $vetEV = Array();

                    if ($rowe['composto'] == 'S') {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_evento';
                        $sql .= ' where idt_evento_pai = ' . null($vlID);
                        $sql .= ' and idt_instrumento = 2';
                        $sql .= " and tipo_sincroniza_siacweb = 'P'";
                        $rst = execsql($sql);

                        foreach ($rst->data as $rowt) {
                            $vetEV[] = $rowt['idt'];
                        }
                    } else {
                        if ($rowe['idt_instrumento'] == 2 && $rowe['tipo_sincroniza_siacweb'] == 'P') {
                            $vetEV[] = $vlID;
                        }
                    }

                    $dt_ini = '01/' . $_POST['pfo_mesano'];

                    $vetDT = DatetoArray($dt_ini);

                    $t = mktime(0, 0, 0, $vetDT['mes'], 1, $vetDT['ano']);
                    $dt_fim = Date('d/m/Y', strtotime('+1 month', $t));

                    $hoje = date('d/m/Y');

                    foreach ($vetEV as $idt_evento_tmp) {
                        if ($rowe['tipo_ordem'] == 'SG' && $rowe['sgtec_modelo'] == 'E') {
                            $sql = '';
                            $sql .= ' select ea.idt';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento_atividade ea';
                            $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ea.idt_atendimento";
                            $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                            $sql .= ' where a.idt_evento = ' . null($idt_evento_tmp);
                            $sql .= whereEventoParticipante();
                            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                            $sql .= ' and ea.idt in (';
                            $sql .= ' select ag.idt_evento_atividade';
                            $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ag';
                            $sql .= ' where ag.data_inicial >= ' . aspa(trata_data($dt_ini));
                            $sql .= ' and ag.data_inicial < ' . aspa(trata_data($dt_fim));
                            $sql .= ' )';
                            $rs = execsql($sql);

                            foreach ($rs->data as $row) {
                                $sql = '';
                                $sql .= ' update grc_evento_agenda set';
                                $sql .= ' data_inicial_real = data_inicial, ';
                                $sql .= ' hora_inicial_real = hora_inicial, ';
                                $sql .= ' dt_ini_real = dt_ini, ';
                                $sql .= ' data_final_real = data_final, ';
                                $sql .= ' hora_final_real = hora_final, ';
                                $sql .= ' dt_fim_real = dt_fim, ';
                                $sql .= ' carga_horaria_real = carga_horaria';
                                $sql .= ' where idt_evento_atividade = ' . null($row['idt']);
                                execsql($sql);

                                $sql = '';
                                $sql .= ' update grc_evento_agenda set';
                                $sql .= ' data_final_real = ' . aspa(trata_data($hoje)) . ', ';
                                $sql .= " dt_fim_real = concat(" . aspa(trata_data($hoje)) . ", ' ', hora_final_real)";
                                $sql .= ' where idt_evento_atividade = ' . null($row['idt']);
                                $sql .= ' and data_final_real > ' . aspa(trata_data($hoje));
                                execsql($sql);

                                $sql = '';
                                $sql .= ' update grc_evento_atividade set';
                                $sql .= " consolidado_cred = 'S' ";
                                $sql .= ' where idt = ' . null($row['idt']);
                                execsql($sql);
                            }
                        }

                        $sql = '';
                        $sql .= ' select ea.idt, ea.idt_atendimento';
                        $sql .= ' from ' . db_pir_grc . 'grc_evento_atividade ea';
                        $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ea.idt_atendimento";
                        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                        $sql .= ' where a.idt_evento = ' . null($idt_evento_tmp);
                        $sql .= whereEventoParticipante();
                        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                        $sql .= " and ea.consolidado_cred = 'S'";
                        $sql .= ' and ea.idt in (';
                        $sql .= ' select ag.idt_evento_atividade';
                        $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ag';
                        $sql .= ' where ag.data_inicial >= ' . aspa(trata_data($dt_ini));
                        $sql .= ' and ag.data_inicial < ' . aspa(trata_data($dt_fim));
                        $sql .= ' )';
                        $rs = execsql($sql);

                        foreach ($rs->data as $row) {
                            $sql = '';
                            $sql .= ' delete from grc_sincroniza_siac';
                            $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                            $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                            $sql .= " and tipo = 'EV_AT_EXC'";
                            execsql($sql);

                            $sql = '';
                            $sql .= ' select idt';
                            $sql .= ' from grc_sincroniza_siac';
                            $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                            $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                            $sql .= " and tipo = 'EV_CON_AT'";
                            $rst = execsql($sql);

                            if ($rst->rows == 0) {
                                $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_atividade, tipo) values (';
                                $sql .= null($row['idt_atendimento']) . ', ' . null($idt_evento_tmp) . ', ' . null($row['idt']) . ", 'EV_CON_AT')";
                                execsql($sql);
                            } else {
                                $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                                $sql .= ' where idt = ' . null($rst->data[0][0]);
                                execsql($sql);
                            }
                        }
                    }

                    if (count($vetEV) > 0) {
                        $ssaIdtEvento = implode(', ', $vetEV);
                        require_once 'sincroniza_siac_acao.php';
                    }

                    if (!$diretoGFI) {
                        //Pendencia Gestor da Unidade
                        $idtSecaoPA = $rowe['idt_ponto_atendimento'];
                        $idtSecaoUN = $rowe['idt_unidade'];

                        //Diretoria
                        $vetCod = explode('.', $rowe['classificacao_unidade']);
                        $vetCod[1] = '00';

                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                        $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
                        $rs = execsql($sql);
                        $idtSecaoDI = $rs->data[0][0];

                        //Coordenador / Gerente
                        $sql = '';
                        $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
                        $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                        $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                        $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                        $sql .= " where f.tipo_alcada_evento = 'CG'";
                        $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                        $sql .= " and p.ativo = 'S'";
                        $rsCG = execsql($sql);

                        $idt_pfo_af_processo = null($_POST['idt_pfo_af_processo']);
                        $idt_usuario = $_SESSION[CS]['g_id_usuario'];
                        $data = aspa(trata_data(date('d/m/Y H:i:s')));
                        $data_solucao = aspa(trata_data(date('d/m/Y')));
                        $assunto = aspa($rowe['descricao']);
                        $observacao = aspa('[' . $rowe['instrumento'] . '] ' . $rowe['descricao']);
                        $protocolo = aspa($rowe['codigo']);
                        $status = aspa('Aprovação da Prestação de Contas');
                        $tipo = aspa('Pagamento a Credenciado');
                        $recorrencia = aspa('1');
                        $idt_ponto_atendimento = null($rowe['idt_ponto_atendimento']);
                        $idt_evento = null($rowe['idt']);

                        foreach ($rsCG->data as $row) {
                            $idt_gestor_evento = null($row['id_usuario']);

                            $sql_i = ' insert into grc_atendimento_pendencia ';
                            $sql_i .= ' (  ';
                            $sql_i .= " idt_pfo_af_processo, ";
                            $sql_i .= " protocolo, ";
                            $sql_i .= " idt_ponto_atendimento, ";
                            $sql_i .= " idt_gestor_local, ";
                            $sql_i .= " recorrencia, ";
                            $sql_i .= " idt_responsavel_solucao, ";
                            $sql_i .= " status, ";
                            $sql_i .= " tipo, ";
                            $sql_i .= " idt_evento, ";
                            $sql_i .= " idt_usuario, ";
                            $sql_i .= " data, ";
                            $sql_i .= " data_solucao, ";
                            $sql_i .= " assunto, ";
                            $sql_i .= " observacao ";
                            $sql_i .= '  ) values ( ';
                            $sql_i .= " $idt_pfo_af_processo, ";
                            $sql_i .= " $protocolo, ";
                            $sql_i .= " $idt_ponto_atendimento, ";
                            $sql_i .= " $idt_gestor_evento, ";
                            $sql_i .= " $recorrencia, ";
                            $sql_i .= " $idt_gestor_evento, ";
                            $sql_i .= " $status, ";
                            $sql_i .= " $tipo, ";
                            $sql_i .= " $idt_evento, ";
                            $sql_i .= " $idt_usuario, ";
                            $sql_i .= " $data, ";
                            $sql_i .= " $data_solucao, ";
                            $sql_i .= " $assunto, ";
                            $sql_i .= " $observacao ";
                            $sql_i .= ') ';
                            execsql($sql_i);
                        }
                    }

                    //Gera PDF
                    $sql = '';
                    $sql .= ' select idt, codigo';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem';
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $rsi = execsql($sql);
                    $rowi = $rsi->data[0];
                    $codigo_os = $rowi['codigo'];

                    $sql = '';
                    $sql .= ' select sum(valor_real) as tot';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt']);
                    $sql .= " and rm_cancelado = 'N'";
                    $rsi = execsql($sql);
                    $vl_os = $rsi->data[0][0];

                    $dt_aprovacao = getdata(true, true, true);

                    $md5 = '';
                    $md5 .= $_SERVER['REMOTE_ADDR'];
                    $md5 .= $_SESSION[CS]['g_login'];
                    $md5 .= $rowe['codigo'];
                    $md5 .= $rowe['codigo_produto'];
                    $md5 .= $rowe['previsao_despesa'];
                    $md5 .= $rowe['previsao_receita'];
                    $md5 .= $codigo_os;
                    $md5 .= $vl_os;
                    $md5 .= $dt_aprovacao;
                    $md5 = md5($md5);

                    $contrato_pdf_old = '';
                    $contrato_pdf = 'declaracao_' . $md5 . '.pdf';

                    $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_declaracao/');

                    if (!file_exists($pathPDF)) {
                        mkdir($pathPDF);
                    }

                    $pathPDFAnexo = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_anexo/');

                    if (!file_exists($pathPDFAnexo)) {
                        mkdir($pathPDFAnexo);
                    }

                    $sql = 'update grc_evento_declaracao set';
                    $sql .= ' idt_usuario_cancelamento = ' . null($_SESSION[CS]['g_id_usuario']) . ',';
                    $sql .= ' dt_cancelamento = ' . aspa(trata_data($dt_aprovacao, true)) . ',';
                    $sql .= " ativo = 'N'";
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $sql .= ' and idt_pfo_af_processo = ' . null($_POST['idt_pfo_af_processo']);
                    $sql .= " and ativo = 'S'";
                    $sql .= " and tipo = 'RE'";
                    execsql($sql);

                    $sql = 'insert into grc_evento_declaracao (idt_evento, idt_pfo_af_processo, ativo, arquivo, md5, tipo,';
                    $sql .= ' ip, login_aprovacao, codigo_evento, codigo_produto,';
                    $sql .= ' vl_despesa, vl_receita, codigo_os, vl_os,';
                    $sql .= ' dt_aprovacao, idt_usuario_aprovacao) values (';
                    $sql .= null($vlID) . ', ' . null($_POST['idt_pfo_af_processo']) . ", 'S', " . aspa($contrato_pdf) . ', ' . aspa($md5) . ", 'RE',";
                    $sql .= aspa($_SERVER['REMOTE_ADDR']) . ', ' . aspa($_SESSION[CS]['g_login']) . ', ' . aspa($rowe['codigo']) . ', ' . aspa($rowe['codigo_produto']) . ', ';
                    $sql .= null($rowe['previsao_despesa']) . ', ' . null($rowe['previsao_receita']) . ', ' . aspa($codigo_os) . ', ' . null($vl_os) . ', ';
                    $sql .= aspa(trata_data($dt_aprovacao, true)) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ')';
                    execsql($sql);
                    $idt_evento_declaracao = lastInsertId();

                    $vetParametro = Array(
                        'idt_evento_declaracao' => $idt_evento_declaracao,
                    );

                    salvaPDF($pathPDF . $contrato_pdf, $vetParametro);

                    if (!file_exists($pathPDF . $contrato_pdf)) {
                        erro_try('A Declaração em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                        echo '<script type="text/javascript">';
                        echo 'alert("A Declaração em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                        echo 'self.location = "conteudo.php";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $anexoDesc = 'DECLARAÇÃO DE CONCLUSÃO DOS SERVIÇOS';

                    if ($_POST['pfo_mesano'] != 'total') {
                        $anexoDesc .= ' (' . $_POST['pfo_mesano'] . ')';
                    }

                    $sql = '';
                    $sql .= ' select idt, arquivo';
                    $sql .= ' from grc_evento_anexo';
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $sql .= ' and descricao = ' . aspa($anexoDesc);
                    $sql .= " and observacao = 'GERADO NA ETAPA DE APROVAÇÃO DO RESPONSÁVEL PELO EVENTO'";
                    $sql .= " and so_consulta = 'S'";
                    $rsi = execsql($sql);

                    if ($rsi->rows == 0) {
                        $sql = 'insert into grc_evento_anexo (idt_evento, descricao, idt_responsavel, data_responsavel, arquivo, so_consulta, observacao) values (';
                        $sql .= null($vlID) . ', ' . aspa($anexoDesc) . ', ' . aspa($_SESSION[CS]['g_id_usuario']) . ', ' . aspa(trata_data($dt_aprovacao, true)) . ', ';
                        $sql .= aspa($contrato_pdf) . ", 'S', 'GERADO NA ETAPA DE APROVAÇÃO DO RESPONSÁVEL PELO EVENTO')";
                        execsql($sql);
                    } else {
                        $rowi = $rsi->data[0];
                        $contrato_pdf_old = $rowi['arquivo'];

                        $sql = 'update grc_evento_anexo set';
                        $sql .= ' idt_responsavel = ' . null($_SESSION[CS]['g_id_usuario']) . ',';
                        $sql .= ' data_responsavel = ' . aspa(trata_data($dt_aprovacao, true)) . ',';
                        $sql .= ' arquivo = ' . aspa($contrato_pdf);
                        $sql .= ' where idt = ' . null($rowi['idt']);
                        execsql($sql);
                    }

                    //Copia Arquivo grc_evento_anexo
                    if (is_file($pathPDFAnexo . $contrato_pdf_old)) {
                        unlink($pathPDFAnexo . $contrato_pdf_old);
                    }

                    if (is_file($pathPDF . $contrato_pdf)) {
                        copy($pathPDF . $contrato_pdf, $pathPDFAnexo . $contrato_pdf);
                    }
                    break;

                case 'pfoDevolverEA':
                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'PG'";
                    $sql .= ", status_liberacao = 'N'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    //fazer sincronia do siacweb para desconsolidação das atividades deste pagamento
                    $vetEV = Array();

                    if ($rowe['composto'] == 'S') {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_evento';
                        $sql .= ' where idt_evento_pai = ' . null($vlID);
                        $sql .= ' and idt_instrumento = 2';
                        $sql .= " and tipo_sincroniza_siacweb = 'P'";
                        $rst = execsql($sql);

                        foreach ($rst->data as $rowt) {
                            $vetEV[] = $rowt['idt'];
                        }
                    } else {
                        if ($rowe['idt_instrumento'] == 2 && $rowe['tipo_sincroniza_siacweb'] == 'P') {
                            $vetEV[] = $vlID;
                        }
                    }

                    $dt_ini = '01/' . $_POST['pfo_mesano'];

                    $vetDT = DatetoArray($dt_ini);

                    $t = mktime(0, 0, 0, $vetDT['mes'], 1, $vetDT['ano']);
                    $dt_fim = Date('d/m/Y', strtotime('+1 month', $t));

                    foreach ($vetEV as $idt_evento_tmp) {
                        $sql = '';
                        $sql .= ' select ea.idt, ea.idt_atendimento';
                        $sql .= ' from ' . db_pir_grc . 'grc_evento_atividade ea';
                        $sql .= " inner join " . db_pir_grc . "grc_atendimento a on a.idt = ea.idt_atendimento";
                        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento';
                        $sql .= ' where a.idt_evento = ' . null($idt_evento_tmp);
                        $sql .= whereEventoParticipante();
                        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
                        $sql .= " and ea.consolidado_cred = 'S'";
                        $sql .= ' and ea.idt in (';
                        $sql .= ' select ag.idt_evento_atividade';
                        $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda ag';
                        $sql .= ' where ag.data_inicial >= ' . aspa(trata_data($dt_ini));
                        $sql .= ' and ag.data_inicial < ' . aspa(trata_data($dt_fim));
                        $sql .= ' )';
                        $rs = execsql($sql);

                        foreach ($rs->data as $row) {
                            $sql = '';
                            $sql .= ' delete from grc_sincroniza_siac';
                            $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                            $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                            $sql .= " and tipo = 'EV_CON_AT'";
                            execsql($sql);

                            $sql = '';
                            $sql .= ' select idt';
                            $sql .= ' from grc_sincroniza_siac';
                            $sql .= ' where idt_evento = ' . null($idt_evento_tmp);
                            $sql .= ' and idt_evento_atividade = ' . null($row['idt']);
                            $sql .= " and tipo = 'EV_AT_EXC'";
                            $rst = execsql($sql);

                            if ($rst->rows == 0) {
                                $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_atividade, tipo) values (';
                                $sql .= null($row['idt_atendimento']) . ', ' . null($idt_evento_tmp) . ', ' . null($row['idt']) . ", 'EV_AT_EXC')";
                                execsql($sql);
                            } else {
                                $sql = "update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null";
                                $sql .= ' where idt = ' . null($rst->data[0][0]);
                                execsql($sql);
                            }
                        }
                    }

                    if (count($vetEV) > 0) {
                        $ssaIdtEvento = implode(', ', $vetEV);
                        require_once 'sincroniza_siac_acao.php';
                    }

                    $idt_pfo_af_processo = null($_POST['idt_pfo_af_processo']);
                    $idt_usuario = $_SESSION[CS]['g_id_usuario'];
                    $data = aspa(trata_data(date('d/m/Y H:i:s')));
                    $data_solucao = aspa(trata_data(date('d/m/Y')));
                    $assunto = aspa($rowe['descricao']);
                    $observacao = aspa('[' . $rowe['instrumento'] . '] ' . $rowe['descricao']);
                    $protocolo = aspa($rowe['codigo']);
                    $status = aspa('Reprovação da Prestação de Contas');
                    $tipo = aspa('Pagamento a Credenciado');
                    $recorrencia = aspa('1');
                    $idt_ponto_atendimento = null($rowe['idt_ponto_atendimento']);
                    $idt_evento = null($rowe['idt']);
                    $idt_gestor_evento = null($_POST['idt_gestor_evento']);

                    $sql_i = ' insert into grc_atendimento_pendencia ';
                    $sql_i .= ' (  ';
                    $sql_i .= " idt_pfo_af_processo, ";
                    $sql_i .= " protocolo, ";
                    $sql_i .= " idt_ponto_atendimento, ";
                    $sql_i .= " idt_gestor_local, ";
                    $sql_i .= " recorrencia, ";
                    $sql_i .= " idt_responsavel_solucao, ";
                    $sql_i .= " status, ";
                    $sql_i .= " tipo, ";
                    $sql_i .= " idt_evento, ";
                    $sql_i .= " idt_usuario, ";
                    $sql_i .= " data, ";
                    $sql_i .= " data_solucao, ";
                    $sql_i .= " assunto, ";
                    $sql_i .= " observacao ";
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $idt_pfo_af_processo, ";
                    $sql_i .= " $protocolo, ";
                    $sql_i .= " $idt_ponto_atendimento, ";
                    $sql_i .= " $idt_gestor_evento, ";
                    $sql_i .= " $recorrencia, ";
                    $sql_i .= " $idt_gestor_evento, ";
                    $sql_i .= " $status, ";
                    $sql_i .= " $tipo, ";
                    $sql_i .= " $idt_evento, ";
                    $sql_i .= " $idt_usuario, ";
                    $sql_i .= " $data, ";
                    $sql_i .= " $data_solucao, ";
                    $sql_i .= " $assunto, ";
                    $sql_i .= " $observacao ";
                    $sql_i .= ') ';
                    execsql($sql_i);
                    break;

                case 'pfoAprovarGE':
                    //Gera PDF
                    $sql = '';
                    $sql .= ' select o.idt, o.codigo';
                    $sql .= ' from ' . db_pir_pfo . 'pfo_af_processo afp';
                    $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = afp.idt_gec_contratacao_credenciado_ordem';
                    $sql .= ' where afp.idt = ' . null($_POST['idt_pfo_af_processo']);
                    $rsi = execsql($sql);
                    $rowi = $rsi->data[0];
                    $codigo_os = $rowi['codigo'];

                    $sql = '';
                    $sql .= ' select sum(valor_real) as tot';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm';
                    $sql .= ' where idt_gec_contratacao_credenciado_ordem = ' . null($rowi['idt']);
                    $sql .= " and rm_cancelado = 'N'";
                    $rsi = execsql($sql);
                    $vl_os = $rsi->data[0][0];

                    $dt_aprovacao = getdata(true, true, true);

                    $md5 = '';
                    $md5 .= $_SERVER['REMOTE_ADDR'];
                    $md5 .= $_SESSION[CS]['g_login'];
                    $md5 .= $rowe['codigo'];
                    $md5 .= $rowe['codigo_produto'];
                    $md5 .= $rowe['previsao_despesa'];
                    $md5 .= $rowe['previsao_receita'];
                    $md5 .= $codigo_os;
                    $md5 .= $vl_os;
                    $md5 .= $dt_aprovacao;
                    $md5 = md5($md5);

                    $contrato_pdf_old = '';
                    $contrato_pdf = 'declaracao_' . $md5 . '.pdf';

                    $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_declaracao/');

                    if (!file_exists($pathPDF)) {
                        mkdir($pathPDF);
                    }

                    $pathPDFAnexo = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_anexo/');

                    if (!file_exists($pathPDFAnexo)) {
                        mkdir($pathPDFAnexo);
                    }

                    $sql = 'update grc_evento_declaracao set';
                    $sql .= ' idt_usuario_cancelamento = ' . null($_SESSION[CS]['g_id_usuario']) . ',';
                    $sql .= ' dt_cancelamento = ' . aspa(trata_data($dt_aprovacao, true)) . ',';
                    $sql .= " ativo = 'N'";
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $sql .= ' and idt_pfo_af_processo = ' . null($_POST['idt_pfo_af_processo']);
                    $sql .= " and ativo = 'S'";
                    $sql .= " and tipo = 'GE'";
                    execsql($sql);

                    $sql = 'insert into grc_evento_declaracao (idt_evento, idt_pfo_af_processo, ativo, arquivo, md5, tipo,';
                    $sql .= ' ip, login_aprovacao, codigo_evento, codigo_produto,';
                    $sql .= ' vl_despesa, vl_receita, codigo_os, vl_os,';
                    $sql .= ' dt_aprovacao, idt_usuario_aprovacao) values (';
                    $sql .= null($vlID) . ', ' . null($_POST['idt_pfo_af_processo']) . ", 'S', " . aspa($contrato_pdf) . ', ' . aspa($md5) . ", 'GE',";
                    $sql .= aspa($_SERVER['REMOTE_ADDR']) . ', ' . aspa($_SESSION[CS]['g_login']) . ', ' . aspa($rowe['codigo']) . ', ' . aspa($rowe['codigo_produto']) . ', ';
                    $sql .= null($rowe['previsao_despesa']) . ', ' . null($rowe['previsao_receita']) . ', ' . aspa($codigo_os) . ', ' . null($vl_os) . ', ';
                    $sql .= aspa(trata_data($dt_aprovacao, true)) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ')';
                    execsql($sql);
                    $idt_evento_declaracao = lastInsertId();

                    $vetParametro = Array(
                        'idt_evento_declaracao' => $idt_evento_declaracao,
                    );

                    salvaPDF($pathPDF . $contrato_pdf, $vetParametro);

                    if (!file_exists($pathPDF . $contrato_pdf)) {
                        erro_try('A Declaração em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                        echo '<script type="text/javascript">';
                        echo 'alert("A Declaração em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                        echo 'self.location = "conteudo.php";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $anexoDesc = 'DECLARAÇÃO DE CONCLUSÃO DOS SERVIÇOS';

                    if ($_POST['pfo_mesano'] != 'total') {
                        $anexoDesc .= ' (' . $_POST['pfo_mesano'] . ')';
                    }

                    $sql = '';
                    $sql .= ' select idt, arquivo';
                    $sql .= ' from grc_evento_anexo';
                    $sql .= ' where idt_evento = ' . null($vlID);
                    $sql .= ' and descricao = ' . aspa($anexoDesc);
                    $sql .= " and observacao = 'GERADO NA ETAPA DE APROVAÇÃO DO GERENTE'";
                    $sql .= " and so_consulta = 'S'";
                    $rsi = execsql($sql);

                    if ($rsi->rows == 0) {
                        $sql = 'insert into grc_evento_anexo (idt_evento, descricao, idt_responsavel, data_responsavel, arquivo, so_consulta, observacao) values (';
                        $sql .= null($vlID) . ', ' . aspa($anexoDesc) . ', ' . aspa($_SESSION[CS]['g_id_usuario']) . ', ' . aspa(trata_data($dt_aprovacao, true)) . ', ';
                        $sql .= aspa($contrato_pdf) . ", 'S', 'GERADO NA ETAPA DE APROVAÇÃO DO GERENTE')";
                        execsql($sql);
                    } else {
                        $rowi = $rsi->data[0];
                        $contrato_pdf_old = $rowi['arquivo'];

                        $sql = 'update grc_evento_anexo set';
                        $sql .= ' idt_responsavel = ' . null($_SESSION[CS]['g_id_usuario']) . ',';
                        $sql .= ' data_responsavel = ' . aspa(trata_data($dt_aprovacao, true)) . ',';
                        $sql .= ' arquivo = ' . aspa($contrato_pdf);
                        $sql .= ' where idt = ' . null($rowi['idt']);
                        execsql($sql);
                    }

                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'NF'";
                    $sql .= ", status_liberacao = 'S'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    $protocolo = date('dmYHis');

                    $assunto = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_05'], $protocolo, $rowe);
                    $mensagem = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_06'], $protocolo, $rowe);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'pfo_af_processo_cred_0506',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }

                    //Copia Arquivo grc_evento_anexo
                    if (is_file($pathPDFAnexo . $contrato_pdf_old)) {
                        unlink($pathPDFAnexo . $contrato_pdf_old);
                    }

                    if (is_file($pathPDF . $contrato_pdf)) {
                        copy($pathPDF . $contrato_pdf, $pathPDFAnexo . $contrato_pdf);
                    }

                    commit();
                    beginTransaction();
                    break;

                case 'pfoDevolverNF':
                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'NF'";
                    $sql .= ", status_liberacao = 'S'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    $protocolo = date('dmYHis');

                    $assunto = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_05'], $protocolo, $rowe);
                    $mensagem = grc_evento_dep_msgParametros($vetPOF_parametros['pfo_af_processo_cred_06'], $protocolo, $rowe);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'pfo_af_processo_cred_0506',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                    break;

                case 'pfoAprovarFIN':
                    $sql = "update " . db_pir_pfo . "pfo_af_processo set situacao_reg = 'FI', gfi_situacao = 'CF', liberado_validacao = 'S' where idt = " . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    //Email de aviso para o usuaruio sebrae
                    $sql = '';
                    $sql .= ' select nome_completo, email';
                    $sql .= ' from ' . db_pir_pfo . 'plu_usuario';
                    $sql .= " where aviso_validacao_rm = 'S'";
                    $sql .= " and ativo = 'S'";
                    $rs = execsql($sql);

                    foreach ($rs->data as $row) {
                        $assunto = $vetPOF_parametros['pfo_af_processo_01'];
                        $mensagem = $vetPOF_parametros['pfo_af_processo_02'];

                        $protocolo = date('dmYHis');

                        $mensagem = str_replace('#protocolo', $protocolo, $mensagem);
                        $mensagem = str_replace('#data', date('d/m/Y H:i:s'), $mensagem);
                        $mensagem = str_replace('#num_movimento', $_POST['protocolo'], $mensagem);
                        $mensagem = str_replace('#cnpjcpf', $_POST['cnpjcpf'], $mensagem);

                        $vetRegProtocolo = Array(
                            'protocolo' => $protocolo,
                            'origem' => 'pfo_af_processo_0102',
                        );
                        enviarEmail(db_pir_pfo, $assunto, $mensagem, $row['email'], $row['nome_completo'], true, $vetRegProtocolo);
                    }
                    break;
            }
        }
        break;

    case 'grc_evento_combo':
        //Bloquea a Qtd. Vagas no Evento
        $vetErro = operacaoEventoComboVaga($vlID, TRUE);

        if (count($vetErro) > 0) {
            $erro = implode('<br />', $vetErro);
            msg_erro($erro);
        }

        geraEventoComboInstrumento($_POST['idt_evento_origem']);

        $sql = '';
        $sql .= ' select sum(eg.vl_evento) as combo_vl_tot_evento, sum(eg.vl_matricula) as combo_vl_tot_matricula, min(e.dt_previsao_inicial) as combo_dt_min_ini';
        $sql .= ' from grc_evento_combo eg';
        $sql .= ' inner join grc_evento e on e.idt = eg.idt_evento';
        $sql .= ' where eg.idt_evento_origem = ' . null($_POST['idt_evento_origem']);
        $rs = execsql($sql);
        $row = $rs->data[0];

        if ($row['combo_vl_tot_evento'] == 0) {
            $combo_percentual_desc = 0;
        } else {
            $combo_percentual_desc = 100 - ($row['combo_vl_tot_matricula'] * 100 / $row['combo_vl_tot_evento']);
        }

        $vet = Array();
        $vet['combo_vl_tot_evento'] = rawurlencode(format_decimal($row['combo_vl_tot_evento']));
        $vet['combo_vl_tot_matricula'] = rawurlencode(format_decimal($row['combo_vl_tot_matricula']));
        $vet['combo_percentual_desc'] = rawurlencode(format_decimal($combo_percentual_desc));
        $vet['combo_dt_min_ini'] = rawurlencode(trata_data($row['combo_dt_min_ini']));
        $returnVal = json_encode($vet);
        ?>
        <script type="text/javascript">
            returnVal = <?php echo $returnVal; ?>;
        </script>
        <?php
        break;

    case 'grc_evento_nf':
        if (is_array($_POST['gec_autorizar_nf_sem_doc'])) {
            $sql = '';
            $sql .= ' update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
            $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
            $sql .= " set rm.autorizar_nf_sem_doc = 'N'";
            $sql .= ' where o.idt_evento = ' . null($vlID);
            $sql .= " and o.ativo = 'S'";
            $sql .= " and rm.rm_cancelado = 'N'";
            execsql($sql);

            foreach ($_POST['gec_autorizar_nf_sem_doc'] as $idt => $vl) {
                if ($vl == '') {
                    $vl = 'N';
                }

                $sql = 'update ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm set';
                $sql .= ' autorizar_nf_sem_doc = ' . aspa($vl);
                $sql .= ' where idt = ' . null($idt);
                execsql($sql);
            }
        }
        break;

    case 'grc_evento_publicacao':
        $sql_a = ' update grc_evento_publicacao set ';
        $sql_a .= ' temporario = ' . aspa('N');
        $sql_a .= ' where idt = ' . null($vlID);
        execsql($sql_a);

        if ($_POST['gerador_voucher'] == 'N') {
            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_evento_publicacao_voucher';
            $sql .= ' where idt_evento_publicacao = ' . null($vlID);
            $sql .= ' and idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['B']);
            $rs = execsql($sql);

            foreach ($rs->data as $row) {
                //Desbloquea a Qtd. Vagas no Evento
                $vetErro = operacaoVoucherVaga($row['idt'], FALSE);

                if (count($vetErro) > 0) {
                    $erro = implode('<br />', $vetErro);
                    msg_erro($erro);
                }
            }

            $sql = 'delete from grc_evento_publicacao_voucher where idt_evento_publicacao = ' . null($vlID);
            execsql($sql);
        }

        $sql = '';
        $sql .= ' select e.idt, e.codigo, e.descricao, e.idt_instrumento, e.previsao_despesa, e.idt_ponto_atendimento, e.idt_unidade, e.idt_gestor_projeto, i.descricao as instrumento';
        $sql .= ' from grc_evento e';
        $sql .= ' inner join grc_atendimento_instrumento i on i.idt = e.idt_instrumento';
        $sql .= ' where e.idt = ' . null($_GET['idt0']);
        $rs = execsqlNomeCol($sql);
        $rowe = $rs->data[0];

        $sql_a = ' update grc_atendimento_pendencia set ';
        $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
        $sql_a .= " dt_update = now(),";
        $sql_a .= " ativo  =  'N'";
        $sql_a .= ' where idt_evento_publicacao  = ' . null($vlID);
        $sql_a .= " and ativo  =  'S'";
        $sql_a .= " and tipo   =  'Política de Desconto do Evento'";
        execsql($sql_a);

        //Aguardando aprovação do Gestor do Projeto
        if ($_POST['situacao'] == 'GP') {
            $data_solucaow = date('d/m/Y');
            $assuntow = $rowe['descricao'];
            $observacaow = '[' . $rowe['instrumento'] . '] ' . $rowe['descricao'];

            PendenciaEventoPublicacao($vlID, $rowe['idt'], $rowe['idt_ponto_atendimento'], $rowe['idt_gestor_projeto'], $data_solucaow, $assuntow, $observacaow, $rowe['codigo']);
        }

        //Aguardando aprovação do Coordenador/Gerente
        //Aguardando a aprovação do Diretor
        if ($_POST['situacao'] == 'CG' || $_POST['situacao'] == 'DI') {
            $sql = "select s.classificacao";
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao s';
            $sql .= " where s.idt  = " . null($rowe['idt_unidade']);
            $rs = execsql($sql);
            $classificacao_unidade = $rs->data[0][0];

            $vetPEN = CoordenadorGerenteDiretorEvento($_POST['situacao'], $rowe['idt_instrumento'], $rowe['idt_unidade'], $rowe['idt_ponto_atendimento'], $classificacao_unidade, $rowe['previsao_despesa']);

            $data_solucaow = date('d/m/Y');
            $assuntow = $rowe['descricao'];
            $observacaow = '[' . $rowe['instrumento'] . '] ' . $rowe['descricao'];

            foreach ($vetPEN as $id_usuario) {
                PendenciaEventoPublicacao($vlID, $rowe['idt'], $rowe['idt_ponto_atendimento'], $id_usuario, $data_solucaow, $assuntow, $observacaow, $rowe['codigo']);
            }
        }

        //Cancela
        if ($_POST['situacao'] == 'CA') {
            $sql = "update grc_evento_publicacao set ativo = 'N'";
            $sql .= ' where idt = ' . null($vlID);
            execsql($sql);
            break;
        }

        //Aprovado
        if ($_POST['situacao'] == 'AP') {
            $sql = "update grc_evento_publicacao set ativo = 'N'";
            $sql .= ' where idt <> ' . null($vlID);
            $sql .= ' and idt_evento = ' . null($rowe['idt']);
            execsql($sql);
        }
    //break;

    case 'grc_evento_publicacao_cupom':
        //Credita a Qtd. de Cupons do Cupom no Evento
        if ($vetID['grc_evento_publicacao_cupom'] != '') {
            $vetErro = operacaoEventoCupom($vetID['grc_evento_publicacao_cupom'], TRUE);

            if (count($vetErro) > 0) {
                $erro = implode('<br />', $vetErro);
                msg_erro($erro);
            }
        }
        break;

    case 'grc_evento_mapa':
        if ($_POST['btnAcao'] != $bt_excluir_lbl) {
            if ($rowDadosAnt['idt_local_pa_mapa'] != $_POST['idt_local_pa_mapa']) {
                //Apaga o Mapa antigo
                if ($rowDadosAnt['assento_mapa'] != '') {
                    $pathPARA = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_mapa/');

                    if (is_file($pathPARA . $rowDadosAnt['assento_mapa'])) {
                        unlink($pathPARA . $rowDadosAnt['assento_mapa']);
                    }

                    $sql = 'update grc_evento_mapa set assento_mapa = null where idt = ' . null($vlID);
                    execsql($sql);
                }

                $sql = '';
                $sql .= ' select idt, mapa_assento';
                $sql .= ' from grc_evento_mapa_assento';
                $sql .= ' where idt_evento_mapa  = ' . null($vlID);
                $sql .= ' and mapa_assento is not null';
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $pathPARA = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_mapa_assento/');

                    foreach ($rs->data as $row) {
                        if (is_file($pathPARA . $row['mapa_assento'])) {
                            unlink($pathPARA . $row['mapa_assento']);
                        }
                    }
                }

                $sql = 'delete from grc_evento_mapa_assento where idt_evento_mapa = ' . null($vlID);
                execsql($sql);

                //Cadastra o novo Mapa
                $sql = 'insert into grc_evento_mapa_assento (';
                $sql .= ' idt_evento_mapa, codigo, descricao, ativo, detalhe, linha, coluna, coordenada, idt_tipo_assento, mapa_assento';
                $sql .= ')';
                $sql .= ' select ' . $vlID . ' as idt_evento_mapa, codigo, descricao, ativo, detalhe, linha, coluna, coordenada, idt_tipo_assento, mapa_assento';
                $sql .= ' from grc_evento_local_pa_mapa_assento';
                $sql .= ' where idt_local_pa_mapa = ' . null($_POST['idt_local_pa_mapa']);
                execsql($sql);

                if ($_POST['assento_mapa'] != '') {
                    $pathDE = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_local_pa_mapa/');
                    $pathPARA = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_mapa/');

                    if (!file_exists($pathPARA)) {
                        mkdir($pathPARA);
                    }

                    $nomearq = explode('_', $_POST['assento_mapa']);
                    array_shift($nomearq);
                    array_shift($nomearq);
                    array_shift($nomearq);
                    array_shift($nomearq);
                    $nomearq = implode('_', $nomearq);
                    $nomearq = mb_strtolower($vlID . '_assento_mapa_' . $microtime . '_' . troca_caracter($nomearq));

                    $sql_a = 'update grc_evento_mapa set assento_mapa  = ' . aspa($nomearq);
                    $sql_a .= ' where idt  = ' . null($vlID);
                    execsql($sql_a);

                    $vetLogDetalhe['assento_mapa']['desc_atu'] = $nomearq;

                    $pathDE .= $_POST['assento_mapa'];
                    $pathPARA .= $nomearq;

                    if (is_file($pathDE)) {
                        copy($pathDE, $pathPARA);
                    }
                }

                $sql = '';
                $sql .= ' select idt, mapa_assento';
                $sql .= ' from grc_evento_mapa_assento';
                $sql .= ' where idt_evento_mapa  = ' . null($vlID);
                $sql .= ' and mapa_assento is not null';
                $rs = execsql($sql);

                if ($rs->rows > 0) {
                    $pathDE = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_local_pa_mapa_assento/');
                    $pathPARA = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_mapa_assento/');

                    if (!file_exists($pathPARA)) {
                        mkdir($pathPARA);
                    }

                    foreach ($rs->data as $row) {
                        $nomearq = explode('_', $row['mapa_assento']);
                        array_shift($nomearq);
                        array_shift($nomearq);
                        array_shift($nomearq);
                        array_shift($nomearq);
                        $nomearq = implode('_', $nomearq);
                        $nomearq = mb_strtolower($row['idt'] . '_mapa_assento_' . $microtime . '_' . troca_caracter($nomearq));

                        $sql = 'update grc_evento_mapa_assento set mapa_assento  = ' . aspa($nomearq);
                        $sql .= ' where idt  = ' . null($row['idt']);
                        execsql($sql);

                        if (is_file($pathDE . $row['mapa_assento'])) {
                            copy($pathDE . $row['mapa_assento'], $pathPARA . $nomearq);
                        }
                    }
                }
            }

            if ($_POST['bt_continua'] == 'S') {
                $vetPar = $_GET;
                $vetPar['prefixo'] = 'cadastro';
                $vetPar['id'] = $vlID;
                $vetPar['acao'] = 'alt';

                $par = http_build_query($vetPar);

                $href = "conteudo{$cont_arq}.php?" . $par;
                $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
            }
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
                    $codigo = 'grc_evento_publicacao_voucher_registro_numero_' . $tipo_voucher;

                    for ($index = 0; $index < $_POST['quantidade']; $index++) {
                        $numero = $tipo_voucher . AutoNum($codigo, 12);

                        $sql = 'insert into grc_evento_publicacao_voucher_registro (idt_evento_publicacao, idt_evento_publicacao_voucher, numero, data_validade) values (';
                        $sql .= null($_POST['idt_evento_publicacao']) . ', ' . null($vlID) . ', ' . aspa($numero) . ', ' . aspa(trata_data($_POST['data_validade'])) . ')';
                        execsql($sql);
                    }

                    //Bloquea a Qtd. Vagas no Evento
                    $vetErro = operacaoVoucherVaga($vlID, TRUE);

                    if (count($vetErro) > 0) {
                        $erro = implode('<br />', $vetErro);
                        msg_erro($erro);
                    }

                    $_POST['btnAcao'] = 'Continua';
                }
                break;

            case $bt_alterar_lbl:
                $sql = 'update grc_evento_publicacao_voucher_registro set data_validade = ' . aspa(trata_data($_POST['data_validade']));
                $sql .= ' where idt_evento_publicacao_voucher = ' . null($vlID);
                execsql($sql);
                break;
        }
        break;

    case 'grc_evento_publicacao_voucher_registro':
        $sql = 'update grc_evento_publicacao_voucher set quantidade = (';
        $sql .= ' select count(idt) as tot';
        $sql .= ' from grc_evento_publicacao_voucher_registro';
        $sql .= ' where idt_evento_publicacao_voucher = ' . null($_POST['idt_evento_publicacao_voucher']);
        $sql .= " and ativo = 'S'";
        $sql .= ')';
        $sql .= ' where idt = ' . null($_POST['idt_evento_publicacao_voucher']);
        execsql($sql);

        //Bloquea a Qtd. Vagas no Evento
        $vetErro = operacaoVoucherVaga($_POST['idt_evento_publicacao_voucher'], TRUE);

        if (count($vetErro) > 0) {
            $erro = implode('<br />', $vetErro);
            msg_erro($erro);
        }
        break;

    case 'grc_evento_produto':

        if ($acao == 'inc' or $acao == 'alt') {
//
            $idt_evento = $_POST[idt_evento];
            $sql_a = " update grc_evento set ";
            $sql_a .= " provisorio = 'N' ";
            $sql_a .= " where idt  = " . null($idt_evento);
            $result = execsql($sql_a);
// copiar via ajax
            if ($idt_produto > 0) {
                $idt_produto = $_POST[idt_produto];
//$texto = "Vinculado pela simplificação de associação de Produto a Evento";
//CopiarEventoProduto($idt_evento, $idt_produto, $texto);
            }
        }
        break;








    case 'grc_evento_insumo':

        if ($acao != 'con') {
            $idt_evento = $_POST['idt_evento'];
            CalcularInsumoEvento($idt_evento);
        }
        break;




    case 'grc_evento_nada':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                /*           case $bt_alterar_lbl:
                  //                $sql = 'delete from plu_direito_perfil where id_perfil = '.$vlID;
                  //                $result = execsql($sql);

                  ForEach (explode(',', $_POST['id_difu']) as $chave) {
                  if ($chave != '') {
                  $sql = 'insert into plu_direito_perfil (
                  id_perfil,
                  id_difu
                  ) values (
                  '.$vlID.',
                  '.$chave.'
                  )';
                  $result = execsql($sql);
                  }
                  }
                  break;
                 */
                GRC_CopiaProduto($idt_produto, $idt_produto_programar);
                echo "<script type='text/javascript'>alert('Entrei na funçao\nTente outra vez!');</script>";
        }
        break;






    case 'plu_converte_texto':
        if ($acao == 'alt') {
            $idt_importacao = $vlID;
            $tipo = $_POST['tipo'];
            $sql_a = ' update plu_converte_texto set ';
            $sql_a .= ' tipo  = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($vlID);
            $result = execsql($sql_a);
            if ($tipo == 'M') {
                $kokw = ExecutaImportacao_Municipio($idt_importacao);
            }
            if ($tipo == 'R') {
                $kokw = ExecutaImportacao_Regional($idt_importacao);
            }
            if ($tipo == 'P') {
                $kokw = ExecutaImportacao_Produto($idt_importacao);
            }
            if ($tipo == 'S') {
                $kokw = ExecutaImportacao_Produto_siac($idt_importacao);
            }
            if ($tipo == 'I') {
                $kokw = ExecutaImportacao_Produto_siac_insumo($idt_importacao);
            }
// Projetos e ações
            if ($tipo == 'PR') {
                $kokw = ExecutaImportacao_Projeto($idt_importacao);
            }
            if ($tipo == 'PA') {
                $kokw = ExecutaImportacao_Projeto_acao($idt_importacao);
            }
            if ($tipo == 'PE') {
                $kokw = ExecutaImportacao_Projeto_etapa($idt_importacao);
            }
            if ($tipo == 'PF') {
                $kokw = ExecutaImportacao_Projeto_acao_metrica_fisica_ano($idt_importacao);
            }
            if ($tipo == 'PO') {
//  $kokw = ExecutaImportacao_Projeto_acao_metrica_orcamento_ano($idt_importacao);
            }


            if ($tipo == 'SI') {
//  para compatibilizar as tabelas siacweb com sge
                ExecutaAjuste_projetos_SiacWeb($idt_importacao);
            }
        }
        break;
    case 'grc_formulario':
        $idt_dimensao = $_POST['idt_dimensao'];
        $sql = '';
        $sql .= ' select grc_fdr.* ';
        $sql .= ' from grc_formulario_dimensao_resposta grc_fdr ';
        $sql .= " where grc_fdr.idt = {$idt_dimensao}";
        $rst = execsql($sql);
        $agregador = '';
        foreach ($rst->data as $rowt) {
            $agregador = $rowt['agregador'];
        }
        if ($agregador == 'S') {
            $idt_formulario_agregador = $vlID;
            AgregarFormularios($idt_formulario_agregador);
        }
        break;
    case 'grc_formulario_secao':
        if ($acao != 'exc') {
            checa_ponto_formulario($vlID, 'idt_formulario', 'grc_formulario_secao', 'grc_formulario', $acao);
            if ($acao != 'con') {
                $idt_formulario_secao = $vlID;
                $idt_area = $_POST['idt_formulario_area'];
                $sql = '';
                $sql .= ' select grc_fa.* ';
                $sql .= ' from grc_formulario_area grc_fa ';
                $sql .= " where grc_fa.idt = {$idt_area}";
                $rst = execsql($sql);

                foreach ($rst->data as $rowt) {
                    $descricao = aspa($rowt['descricao']);
                    $sql = 'update grc_formulario_secao set descricao = ' . $descricao;
                    $sql .= ' where idt = ' . null($idt_formulario_secao);
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_formulario_pergunta':
        if ($acao != 'exc') {
            checa_ponto_formulario($vlID, 'idt_secao', 'grc_formulario_pergunta', 'grc_formulario_secao', $acao);
        }
        break;

    case 'grc_formulario_resposta':
        if ($acao != 'exc') {
            checa_ponto_formulario($vlID, 'idt_pergunta', 'grc_formulario_resposta', 'grc_formulario_pergunta', $acao);
        }
        break;

    case 'grc_avaliacao':
    case 'grc_avaliacao_resposta':
        $idt_avaliacao = $vlID;

        $sql = '';
        $sql .= ' select av.idt_formulario, a.idt_grupo_atendimento, a.nan_ap_sit_at';
        $sql .= ' from grc_avaliacao av';
        $sql .= ' left outer join grc_atendimento a on a.idt = av.idt_atendimento';
        $sql .= ' where av.idt = ' . null($vlID);
        $rs = execsql($sql);
        $idt_formulario = $rs->data[0]['idt_formulario'];
        $idt_grupo_atendimento = $rs->data[0]['idt_grupo_atendimento'];
        $nan_ap_sit_at = $rs->data[0]['nan_ap_sit_at'];

        $sql = '';
        $sql .= ' select p.idt_secao, r.idt_pergunta, r.idt as idt_resposta, r.qtd_pontos , s.evidencia';
        $sql .= ' from grc_formulario_secao s';
        $sql .= ' inner join grc_formulario_pergunta p on p.idt_secao = s.idt';
        $sql .= ' inner join grc_formulario_resposta r on r.idt_pergunta = p.idt';
        $sql .= ' where s.idt_formulario = ' . null($idt_formulario);
        $rs = execsql($sql);

        $vetDados = Array();
        $vetDadosS = Array();
        $vetDadosSE = Array();


        foreach ($rs->data as $row) {
            $vetDados[$row['idt_pergunta']][$row['idt_resposta']] = Array(
                'idt_secao' => $row['idt_secao'],
                'qtd_pontos' => $row['qtd_pontos'],
            );

            $vetDadosS[$row['idt_pergunta']] = $row['idt_secao'];
            $vetDadosSE[$row['idt_secao']] = $row['evidencia'];
        }

        //p($_POST);

        foreach ($vetDados as $idt_pergunta => $vetP) {
            $idt_resposta = $_POST['p' . $idt_pergunta];
            //$idt_secao  = $vetP[$idt_resposta]['idt_secao'];
            $idt_secao = $vetDadosS[$idt_pergunta];


            $evidencia = $vetDadosSE[$row['idt_secao']];

            if ($evidencia == 'S') {
                $evidencia_txt = aspa($_POST['evidencia' . $idt_secao]);

                $sqlt = ' select grc_se.idt';
                $sqlt .= ' from grc_avaliacao_secao grc_se';
                $sqlt .= ' where ';
                $sqlt .= ' grc_se.idt_avaliacao   = ' . null($idt_avaliacao);
                $sqlt .= '   and grc_se.idt_formulario  = ' . null($idt_formulario);
                $sqlt .= '   and grc_se.idt_secao = ' . null($idt_secao);
                $rst = execsql($sqlt);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_avaliacao_secao (idt_avaliacao, idt_formulario, idt_secao, evidencia) values (';
                    $sql .= null($idt_avaliacao) . ', ' . null($idt_formulario) . ', ' . null($idt_secao) . ', ' . $evidencia_txt . ')';
                    execsql($sql);
                } else {
                    foreach ($rst->data as $rowt) {
                        $idt_avaliacao_secao = $rowt['idt'];
                    }

                    $sql_a = ' update grc_avaliacao_secao set ';
                    $sql_a .= " evidencia  = {$evidencia_txt} " . " ";
                    $sql_a .= ' where idt  = ' . null($idt_avaliacao_secao) . '  ';
                    $result = execsql($sql_a);
                }
            }

            $qtd_pontos = $vetP[$idt_resposta]['qtd_pontos'];
            $resposta_txt = $_POST['txt' . $idt_resposta];

            $sqlt = ' select grc_ar.idt';
            $sqlt .= ' from grc_avaliacao_resposta grc_ar';
            $sqlt .= ' where ';
            $sqlt .= '   grc_ar.idt_avaliacao      = ' . null($vlID);
            $sqlt .= '   and grc_ar.idt_secao      = ' . null($idt_secao);
            $sqlt .= '   and grc_ar.idt_pergunta   = ' . null($idt_pergunta);
            $rst = execsql($sqlt);
            if ($rst->rows == 0) {
                //if ($idt_resposta != '') {
                $sql = 'insert into grc_avaliacao_resposta (idt_avaliacao, idt_formulario, idt_secao, idt_pergunta, idt_resposta, qtd_pontos, resposta_txt) values (';
                $sql .= null($vlID) . ', ' . null($idt_formulario) . ', ' . null($idt_secao) . ', ' . null($idt_pergunta) . ', ' . null($idt_resposta) . ', ';
                $sql .= null($qtd_pontos) . ', ' . aspa($resposta_txt) . ')';
                execsql($sql);
                //}
            } else {
                foreach ($rst->data as $rowt) {
                    $idt_avaliacao_resposta = $rowt['idt'];
                }

                $idt_resposta = null($idt_resposta);
                $resposta_txt = aspa($resposta_txt);
                $qtd_pontos = null(qtd_pontos);
                $sql_a = ' update grc_avaliacao_resposta set ';
                $sql_a .= " idt_resposta       = {$idt_resposta} " . ", ";
                $sql_a .= " qtd_pontos         = {$qtd_pontos} " . ", ";
                $sql_a .= " resposta_txt       = {$resposta_txt} " . "  ";
                $sql_a .= ' where idt  = ' . null($idt_avaliacao_resposta) . '  ';
                $result = execsql($sql_a);

                //p($sql_a);
            }
        }

        $sql = 'update grc_avaliacao set data_resposta = ' . aspa(getdata(true, false, true)) . ' where idt = ' . null($vlID);
        execsql($sql);
        VerificaAvaliacaoRespostas($vlID);

        if ($_POST['nan'] == 'S') {
            $sql = '';
            $sql .= ' select status_1';
            $sql .= ' from grc_nan_grupo_atendimento';
            $sql .= ' where idt = ' . null($idt_grupo_atendimento);
            $rstt = execsql($sql);
            $status_1_ant = $rstt->data[0][0];

            if ($_POST['situacao'] == 'Volta') {
                if ($status_1_ant == 'AT' || $status_1_ant == 'CD' || $status_1_ant == 'DI' || $status_1_ant == 'DE') {
                    if ($nan_ap_sit_at == 'S') {
                        $tmp = 'DE';
                    } else {
                        $tmp = 'CD';
                    }

                    $sql = "update grc_nan_grupo_atendimento set status_1 = " . aspa($tmp);
                    $sql .= ' where idt = ' . null($idt_grupo_atendimento);
                    execsql($sql);
                }

                $_GET['tipo'] = 'ConfirmaReabrirAvaliacao';
                $_POST['idt_avaliacao'] = $vlID;
                require_once 'ajax2.php';
            } else {
                if ($status_1_ant == 'AT' || $status_1_ant == 'CD' || $status_1_ant == 'DI' || $status_1_ant == 'DE') {
                    $sql = "update grc_nan_grupo_atendimento set status_1 = 'AT'";
                    $sql .= ' where idt = ' . null($idt_grupo_atendimento);
                    execsql($sql);
                }

                $_GET['tipo'] = 'ConfirmaFechamentoAvaliacao';
                $_POST['idt_avaliacao'] = $vlID;
                require_once 'ajax2.php';

                ob_start();
                $_GET['idt_avaliacao'] = $vlID;
                require_once 'cadastro_conf/grc_nan_devolutiva_rel_inc.php';
                ob_end_clean();
            }
        }
        break;




    case 'grc_produto_desenvolver':
    case 'grc_produto':
        $sql = "update grc_produto set temporario='N' where idt = " . null($vlID);
        execsql($sql);

        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:
                $idt_produto = $vlID;

                if ($_POST['necessita_credenciado'] == 'S') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_produto_profissional';
                    $sql .= ' where idt_produto = ' . null($vlID);
                    $rs = execsql($sql);

                    if ($rs->rows == 0) {
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from ' . db_pir_gec . 'gec_profissional';
                        $sql .= " where codigo = '00'";
                        $rs = execsql($sql);
                        $idt_profissional = $rs->data[0][0];

                        $sql = 'insert into grc_produto_profissional (idt_produto, idt_profissional, observacao) values (';
                        $sql .= null($idt_produto) . ', ' . null($idt_profissional) . ", 'Registro Automático')";
                        execsql($sql);
                    }
                }

                $sql = '';
                $sql .= ' select idt, idt_profissional';
                $sql .= ' from grc_produto_profissional';
                $sql .= ' where idt_produto = ' . null($idt_produto);
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $idt_produto_profissional = $row['idt'];
                    $idt_profissional = $row['idt_profissional'];

                    SincronizaProfissional($idt_produto_profissional, $idt_produto, $idt_profissional);
                }

                CalcularInsumoProduto($idt_produto);
                break;
        }
        break;

    case 'grc_atendimento_agenda_excluir':
    case 'grc_atendimento_agenda_desmarcacao':
    case 'grc_atendimento_agenda_marcacao':
    case 'grc_atendimento_agenda':

//p($_POST);
//echo "$acao <br/>";

        /*
          if ($acao == 'inc' or $acao == 'alt') {
          $servicos          = str_replace(Char(13),'<br>',$_POST['servicos']);
          $servicos          = str_replace(Char(13),'<br />',$servicos);
          $_POST['servicos'] = $servicos;
          }
         */
        if ($acao == 'inc') {
            $sql = 'update grc_atendimento_agenda set situacao = ' . aspa('Agendado') . ' where idt = ' . null($vlID);
            execsql($sql);
        }

        if ($acao == 'alt') {
            $idt_atendimento_agenda = $vlID;
            $idt_cliente = $_POST['idt_cliente'];
            $idt_ponto_atendimento = $_POST['idt_ponto_atendimento'];
            $situacao = $_POST['situacao'];
            $cliente_texto = $_POST['cliente_texto'];

            $idt_especialidade = $_POST['idt_especialidade'];
            $telefone = $_POST['telefone'];
            $celular = $_POST['celular'];

            $cpf = $_POST['cpf'];
            $cnpj = $_POST['cnpj'];
            $nome_empresa = $_POST['nome_empresa'];




            //p($_POST);

            $sql = '';
            $sql .= ' select gec_ser.tipo_atendimento, gec_ser.descricao ';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento_especialidade gec_ser where gec_ser.idt = ' . null($_POST['idt_especialidade']);
            $rs_a1 = execsql($sql);

            $tipo_atendimento = '';
            $servico = "";
            ForEach ($rs_a1->data as $row) {
                $tipo_atendimento = $row['tipo_atendimento'];
                $servico = $row['descricao'];
            }
            // echo " tipo atendimento = {$tipo_atendimento} "; 			
            // die();
            // echo "não sei o que aconteceu $acao --- $cliente_texto --- $situacao <br />";
            //
            if ($cliente_texto == '' and $idt_cliente != 0) {
                $sql = '';
                $sql .= ' select ge.descricao';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade as ge where ge.idt = ' . null($idt_cliente);
                $rs_a1 = execsql($sql);

                $descricao = '';
                ForEach ($rs_a1->data as $row) {
                    $descricao = $row['descricao'];
                    $sql = "update grc_atendimento_agenda ";
                    $sql .= " set ";
                    $sql .= " cliente_texto = " . aspa($descricao);
                    $sql .= " where idt = " . null($vlID);
                    execsql($sql);
                }
            }
            echo "<script>";
            echo " retorno_close_w=1; ";
            echo "</script>";

            // Marcação 
            if (($idt_cliente != 0 or $cliente_texto != "") and $situacao == 'Agendado') {
                //echo "marcar correto $acao --- $cliente_texto --- $situacao <br />";

                $dataw = date('d/m/Y H:i:s');
                $data_marcacao = trata_data($dataw);
                // guy pode ser mais de um horário a depender do serviço
                // Montar funcao para - receber dados(servico, idt_agenda --> vetor com idt para bloqueio)
                // essa rotina calcula quntos horários consecutivos devem ser reservados para atender ao serviço solicitado
                // notar que tem que alterar o bloqueio e desbloqueio do grupo...
                // no bloqueio fazer a rotina de colocar em cinza
                // criar vetor com idts para registro aqui....
                //
                // inverso para desbloqueio
                // aqui grava vários registros de marcação
                //				
// protocolo já foi dado na inicialização do agendamento				
                /*
                  $protocolo = "";
                  $tabela = 'grc_atendimento_agenda';
                  $Campo = 'protocolo';
                  $tam = 7;
                  $codigow = numerador_arquivo($tabela, $Campo, $tam);
                  $codigo = 'MC' . $codigow;
                  $protocolo = $codigo;
                 */


                $sql = "update grc_atendimento_agenda ";
                $sql .= " set ";
                $sql .= " idt_atendimento_agenda = " . null($idt_atendimento_agenda) . ", ";
                $sql .= " situacao      = " . aspa('Marcado') . ", ";
                $sql .= " semmarcacao   = " . aspa('N') . ", ";
                // $sql .= " protocolo           = " . aspa($protocolo) . ", ";
                $sql .= " data_hora_marcacao = " . aspa($data_marcacao) . " ";
                $sql .= " where idt = " . null($vlID);
                execsql($sql);

                // se tem filhos marcar


                $sql = "update grc_atendimento_agenda ";
                $sql .= " set ";
                $sql .= " idt_cliente        = " . null($idt_cliente) . ", ";
                $sql .= " idt_especialidade  = " . null($idt_especialidade) . ", ";
                $sql .= " cliente_texto      = " . aspa($cliente_texto) . ", ";
                $sql .= " telefone           = " . aspa($telefone) . ", ";
                $sql .= " celular            = " . aspa($celular) . ", ";
                $sql .= " cpf                = " . aspa($cpf) . ", ";
                $sql .= " cnpj               = " . aspa($cnpj) . ", ";
                $sql .= " nome_empresa       = " . aspa($nome_empresa) . ", ";
                $sql .= " situacao           = " . aspa('Marcado') . ", ";
                $sql .= " semmarcacao        = " . aspa('N') . ", ";
                // $sql .= " protocolo        = " . aspa($protocolo) . ", ";
                $sql .= " data_hora_marcacao = " . aspa($data_marcacao) . " ";
                $sql .= " where idt_atendimento_agenda = " . null($vlID);
                execsql($sql);




                //p($sql);
                //die();
                //
				// Registrar marcação se veio do atendimento
                if ($veio_at == "AT") {

                    $cpl = "Agendamento - Marcação ";
                    $idt_atendimento_agenda = $vlID;
                    $idt_atendimento = $idt_atendimento;
                    $descricao = "";
                    $cpl = "";
                    //$descricao    .= $cpl.$_POST['protocolo']." - ".$cliente_texto;
                    $data_m = $_POST['data'];
                    $hora_m = $_POST['hora'];

                    $descricao .= "Data: {$data_m} {$hora_m} Serviço: {$servico} ";
                    $vetRetorno = Array();
                    $vetRetorno['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                    $vetRetorno['idt_pendencia'] = $idt_pendencia;
                    $vetRetorno['idt_acao'] = 5;

                    $vetRetorno['descricao'] = $descricao;
                    $vetRetorno['veio'] = "AGENDAMARCACAO";
                    $vetRetorno['complemento_acao'] = "Marcação - " . $_POST['protocolo'];
                    AtendimentoResumo($idt_atendimento, $vetRetorno);
                }




                // registrar o log dos horários complementares
                $sql_fi = '';
                $sql_fi .= ' select grc_aa.idt ';
                $sql_fi .= " from grc_atendimento_agenda as grc_aa  ";
                $sql_fi .= " where grc_aa.idt_atendimento_agenda = " . null($vlID);
                $sql_fi .= "   order by hora ";
                $rs_fi = execsql($sql_fi);
                if ($rs_fi->rows > 1) {   // Registrar Pai e filhos
                    ForEach ($rs_fi->data as $row_fi) {
                        $idt_atendimento_agenda_filho = $row_fi['idt'];
                        $vetPar = Array();
                        $vetPar['tipo'] = 'MARCADO COM ADICIONAIS';
                        $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda_filho;
                        RegistrarLogAgendamento($vetPar);
                    }
                } else {
                    $idt_atendimento_agenda = $vlID;
                    $vetPar = Array();
                    $vetPar['tipo'] = 'MARCADO';
                    $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                    RegistrarLogAgendamento($vetPar);
                }


                // Pegar as opções do cliente agendado
				
				$envia_sms   = 'N';
				$envia_email = 'S';
				$codigo      = $_POST['cpf'];
				$vetRetorno=Array();
				$ret = OpcaoCanalContato($codigo,$vetRetorno);
				if  ($ret==0)
				{
				     // Cliente não fez Opções receber informacao = não
					 $envia_sms   = 'N';
					 $envia_email = 'N';
				}
				else
				{
				      $vetCanalAgenda = $vetRetorno['vetCanalAgenda'];
					  foreach ($vetCanalAgenda as $tipo => $opcao) {
					        if ($tipo == 'SMS')
							{
							    $envia_sms   = $opcao;
							}
							if ($tipo == 'EMAIL')
							{
							    $envia_email = $opcao;
							}							
					  }
				}



                $codigo = '02.01';
                if ($tipo_atendimento == 'D') {
                    $codigo = '80.01'; // processo email para distância
                }


                $idt_atendimento_agenda = $vlID;
                $vetParametros = Array();
                $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
                $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
                $vetParametros['tipo'] = "PA"; // processo Email/SMS


                $vetParametros['tipo'] = "PA";
                $vetParametros['idt_sca_oc'] = $idt_ponto_atendimento;
                $vetParametros['idt_ponto_atendimento'] = $idt_ponto_atendimento;

                
				if  ($envia_email=='S') // Essa é a Opção do cliente
				{
					$kokw = AgendamentoPrepararEmail($vetParametros);
					if ($kokw == 0) {
						//echo "---> Erro = ".$vetParametros['erro'];
						//p($vetParametros);
						//die();
					}
				}




                $envia_sms_confirmacao = $_SESSION[CS]['ParametrosGeraisAgenda']['envia_sms_confirmacao'];
                if ($envia_sms_confirmacao == 'S'or $envia_sms=='S') // prevalece a do cliente
				{
                    // Manda SMS de Confirmação
                    $codigo = '90.01';
                    if ($tipo_atendimento == 'D') {
                        $codigo = '90.01'; // processo email para distância
                    }
                    $idt_atendimento_agenda = $vlID;
                    $vetParametros = Array();
                    $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
                    $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
                    $vetParametros['tipo'] = "PA"; // processo Email/SMS
                    $vetParametros['tipo'] = "PA";
                    $vetParametros['idt_sca_oc'] = $idt_ponto_atendimento;
                    $vetParametros['idt_ponto_atendimento'] = $idt_ponto_atendimento;
                    $kokw = AgendamentoPrepararEmail($vetParametros);
                    if ($kokw == 0) {
                        //echo "---> Erro = ".$vetParametros['erro'];
                        //p($vetParametros);
                        //die();
                    }
                }
            }
            //////////////////// chamar comprovante

            if ($_POST['acao_imprime_comprovante'] == 'S') {
                $titulo = "Comprovante de Agendamento";
                $parww = '&idt_atendimento_agenda=' . $vlID . '&deondeveio=Distancia&titulo_rel=' . $titulo;
                $href = 'conteudo_print.php?prefixo=relatorio&menu=grc_imprime_comprovante_agendamento' . $parww;

                $botao_acao = '<script type="text/javascript">';
                $botao_acao .= 'self.location = "' . $href . '"';
                $botao_acao .= '</script>';
            }

            // Desmarcação
            if (($menu == 'grc_atendimento_agenda_desmarcacao' or $menu == 'grc_atendimento_agenda_excluir') and $situacao == 'Marcado') {

                //echo " excluir 0 <br />";

                $idt_atendimento_agenda = $vlID;


                if ($veio_at == "AT") {
                    //$marcacaow = MontaMarcacao($idt_atendimento_agenda);
                    //$vetRetorno['marcacao']  = $marcacaow;
                    $vetRetorno = Array();
                    $cpl = "";
                    if ($menu == 'grc_atendimento_agenda_desmarcacao') {
                        $vetRetorno['veio'] = "AGENDADESMARCACAO";
                        $vetRetorno['idt_acao'] = 6;
                        $cpl = "Agendamento";
                        $vetRetorno['complemento_acao'] = "Desmarcação - " . $_POST['protocolo'];
                    } else {
                        $vetRetorno['veio'] = "AGENDAEXCLUSAO";
                        $vetRetorno['idt_acao'] = 7;
                        $cpl = "Agendamento";
                        $vetRetorno['complemento_acao'] = "Esclusão - " . $_POST['protocolo'];
                    }

                    $idt_atendimento = $idt_atendimento;
                    $descricao = "";
                    $cpl = "";
                    //$descricao      .= $cpl.$_POST['protocolo']." - ".$_POST['cliente_texto'];
                    $data_m = $_POST['data'];
                    $hora_m = $_POST['hora'];
                    $descricao .= "Data: {$data_m} {$hora_m} Serviço: {$servico} ";

                    $vetRetorno['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                    $vetRetorno['idt_pendencia'] = $idt_pendencia;

                    $vetRetorno['descricao'] = $descricao;




                    AtendimentoResumo($idt_atendimento, $vetRetorno);
                }





                /*
                  $vetPar = Array();
                  if ($menu == 'grc_atendimento_agenda_desmarcacao') {
                  $vetPar['tipo'] = 'DESMARCADO';
                  } else {
                  $vetPar['tipo'] = 'EXCLUIDO';
                  //	echo " excluir 1 <br />";
                  }

                  //$vetPar['tipo'] = 'DESMARCADO';
                  $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                  RegistrarLogAgendamento($vetPar);
                 */
                ///////////////////////////////////
// registrar o log dos horários complementares
                $sql_fi = '';
                $sql_fi .= ' select grc_aa.idt ';
                $sql_fi .= " from grc_atendimento_agenda as grc_aa  ";
                $sql_fi .= " where grc_aa.idt_atendimento_agenda = " . null($vlID);
                $sql_fi .= "   order by hora ";
                $rs_fi = execsql($sql_fi);
                if ($rs_fi->rows > 1) {   // Registrar Pai e filhos
                    ForEach ($rs_fi->data as $row_fi) {
                        $idt_atendimento_agenda_filho = $row_fi['idt'];
                        $vetPar = Array();
                        if ($menu == 'grc_atendimento_agenda_desmarcacao') {
                            $vetPar['tipo'] = 'DESMARCADO COM ADICIONAIS ';
                        } else {
                            $vetPar['tipo'] = 'EXCLUIDO COM ADICIONAIS';
                            //	echo " excluir 1 <br />";
                        }
                        $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda_filho;
                        RegistrarLogAgendamento($vetPar);
                    }
                } else {
                    $vetPar = Array();
                    if ($menu == 'grc_atendimento_agenda_desmarcacao') {
                        $vetPar['tipo'] = 'DESMARCADO';
                    } else {
                        $vetPar['tipo'] = 'EXCLUIDO';
                        //	echo " excluir 1 <br />";
                    }
                    $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                    RegistrarLogAgendamento($vetPar);
                }

                ///////////////////////////////////
                // enviar email e sms 
                $idt_atendimento_agenda = $vlID;
                if ($menu == 'grc_atendimento_agenda_desmarcacao') {
                    $codigo = '02.50'; // CANCELAMENTO DE AGENDAMENTO pelo cliente
                    $vetParametros = Array();
                    $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
                    $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
                    $kokw = AgendamentoPrepararEmail($vetParametros);
                    if ($kokw == 0) {
                        //echo "---> Erro = ".$vetParametros['erro'];
                    }
                } else {
                    //echo " excluir email <br />";
                    $codigo = '02.51'; // CANCELAMENTO DE AGENDAMENTO pelo Sebrae - indevido
                    $vetParametros = Array();
                    $vetParametros['idt_atendimento_agenda'] = $idt_atendimento_agenda; // idt da agenda
                    $vetParametros['processo_emailsms'] = $codigo; // processo Email/SMS
                    $kokw = AgendamentoPrepararEmail($vetParametros);
                    if ($kokw == 0) {
                        //echo "---> Erro = ".$vetParametros['erro'];
                    }
                }
                //
                // deletar necessidades especiais associadas
                //
				//echo " efetivar0 <br />";
                $sql = ' delete from ';
                $sql .= ' grc_atendimento_agenda_tipo_deficiencia ';
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                // 
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
                $sql .= " where idt = " . null($vlID);
                execsql($sql);
                //echo " excluir terminar <br />";
                // se tem filhos desmarcar
                // 
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
                $sql .= " where idt_atendimento_agenda = " . null($vlID);
                execsql($sql);
            }
        }
//		die();

        break;




    case 'grc_atendimento_agenda_ausencia':


        if ($acao == 'alt') {
            $idt_atendimento_agenda = $vlID;
            $idt_cliente = $_POST['idt_cliente'];
            $situacao = $_POST['situacao'];
            $cliente_texto = $_POST['cliente_texto'];
            //
            //  Ausência
            if ($situacao == 'Marcado') {

                //
                $idt_atendimento_agenda = $vlID;
                $vetPar = Array();
                $vetPar['tipo'] = 'AUSENCIA';
                $vetPar['idt_atendimento_agenda'] = $idt_atendimento_agenda;
                RegistrarLogAgendamento($vetPar);

                $data = date('Y-m-d');
                $data .= ' ' . (date('H') - date('I')) . ':' . date('i');
                $data .= ':' . date('s');
                $datahoraausencia = $data;

                $sql = "update grc_atendimento_agenda ";
                $sql .= " set ";
                $sql .= " semmarcacao                = " . aspa('N') . ", ";
                $sql .= " data_hora_ausencia = " . aspa($datahoraausencia) . " ";


                //$sql .= " idt_especialidade  = ".'null'.", ";
                //$sql .= " idt_cliente        = ".'null'.", ";
                //$sql .= " cpf                = ".aspa('').", ";
                //$sql .= " cnpj               = ".aspa('').", ";
                //$sql .= " nome_empresa       = ".aspa('').", ";
                //$sql .= " telefone           = ".aspa('').", ";
                //$sql .= " celular            = ".aspa('').", ";
                //$sql .= " email              = ".aspa('').", ";
                //$sql .= " protocolo          = ".aspa('').", ";
                //$sql .= " assunto            = ".aspa('').", ";
                //$sql .= " necessidade_especial = ".aspa('N').", ";
                //$sql .= " data_hora_marcacao = ".aspa('').", ";
                //$sql .= " observacao_desmarcacao     = ".aspa('').", ";
                //$sql .= " semmarcacao                = ".aspa('N').", ";
                //$sql .= " marcador                   = ".aspa('').", ";
                //$sql .= " idt_marcador               = ".'null'.", ";
                //$sql .= " data_hora_marcacao_inicial = ".aspa('')." ";
                $sql .= " where idt = " . null($vlID);
                execsql($sql);
            }
        }

        break;













    case 'grc_atendimento_gera_agenda':

        if ($acao == 'inc' or $acao == 'alt') {
            $idt_atendimento_gera_agenda = $vlID;
            $executa = $_POST['executa'];
            $sql_a = ' update grc_atendimento_gera_agenda set ';
            $sql_a .= " executa_ag  = " . aspa($executa) . ',  ';
            $sql_a .= ' executa     = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($idt_atendimento_gera_agenda);
            $result = execsql($sql_a);
//
            if ($executa == 'Gera') {
                //  $vetret = array();
                //	$ret = CarregarAgendaExistente($idt_atendimento_gera_agenda, $vetret);
                //	p($vetret);
                //	exit();
                //	if ($ret==0)
                //	{
                $vetret = array();
                $ret = geracao_agenda_sebrae($idt_atendimento_gera_agenda, $vetret);
                if ($ret == 0 or $ret == 2) {
                    $erw = "Erro Geração da Agenda " . $ret;
                    echo "<script>";
                    echo " alert({$erw}); ";
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo " MostraResultado({$idt_atendimento_gera_agenda}); ";
                    echo "</script>";
                }
                //exit();
                //	}
                //  else
                //	{
                //	}
            }

            if ($executa == 'Exclui') {
                $vetret = array();
                $ret = exclusao_agenda($idt_atendimento_gera_agenda, $vetret);

                if ($ret == 0 or $ret == 2) {
                    $erw = "Erro Exclusão da Agenda " . $ret;
                    echo "<script>";
                    echo " alert({$erw}); ";
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo " MostraResultado({$idt_atendimento_gera_agenda}); ";
                    echo "</script>";
                }
            }

            if ($executa == 'Cancela') {
                $vetret = array();
                $ret = cancela_agenda($idt_atendimento_gera_agenda, $vetret);

                if ($ret == 0 or $ret == 2) {
                    $erw = "Erro Cancelamento da Agenda " . $ret;
                    echo "<script>";
                    echo " alert({$erw}); ";
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo " MostraResultado({$idt_atendimento_gera_agenda}); ";
                    echo "</script>";
                }
            }

            if ($executa == 'Bloqueia') {
                $vetret = array();
                $ret = bloqueio_agenda($idt_atendimento_gera_agenda, $vetret);

                if ($ret == 0 or $ret == 2) {
                    $erw = "Erro Bloqueio da Agenda " . $ret;
                    echo "<script>";
                    echo " alert({$erw}); ";
                    echo "</script>";
                } else {
                    echo "<script>";
                    //echo " alert('Será?????'+'{$idt_atendimento_gera_agenda}'); ";
                    echo " MostraResultado({$idt_atendimento_gera_agenda}); ";
                    echo "</script>";
                }
            }

            if ($executa == 'Agenda') {
                $vetret = array();
                $ret = VoltaAgenda($idt_atendimento_gera_agenda, $vetret);

                if ($ret == 0 or $ret == 2) {

                    $erw = "Erro Voltando a Agendamento " . $ret;
                    echo "<script>";
                    echo " alert({$erw}); ";
                    echo "</script>";
                } else {
                    echo "<script>";
                    //echo " alert('Será?????'); ";
                    echo " MostraResultado({$idt_atendimento_gera_agenda}); ";
                    echo "</script>";
                }
            }
            echo "<script>";
            echo " history.back(); ";
            echo "</script>";

            //die();
        }
        break;


    case 'grc_atendimento_gera_painel':

        if ($acao == 'inc' or $acao == 'alt') {
            $idt_atendimento_gera_painel = $vlID;
            $executa = $_POST['executa'];
            $sql_a = ' update grc_atendimento_gera_painel set ';
            $sql_a .= ' executa     = ' . aspa('') . '  ';
            $sql_a .= ' where idt = ' . null($idt_atendimento_gera_painel);
            $result = execsql($sql_a);

            if ($executa == 'Gera') {
                $vetret = array();
                $ret = geracao_painel($idt_atendimento_gera_painel, $vetret);

                if ($ret == 0 or $ret == 2) {
                    echo "Erro Geração do Painel " . $ret;
                }
            }

            if ($executa == 'Exclui') {
                $vetret = array();
                $ret = exclusao_painel($idt_atendimento_gera_painel, $vetret);

                if ($ret == 0 or $ret == 2) {
                    echo "Erro Exclusão do Painel " . $ret;
                }
            }
        }
        break;

    case 'grc_produto_area_conhecimento':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_area']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_area_conhecimento';
                $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
                $sql .= ' and idt_area = ' . null($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_produto_area_conhecimento (idt_produto, idt_area, detalhe) values (';
                    $sql .= null($_POST['idt_produto']) . ', ' . null($dados['idt']) . ', ' . aspa($_POST['detalhe']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_produto_unidade_regional':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_unidade_regional']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_unidade_regional';
                $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
                $sql .= ' and idt_unidade_regional = ' . null($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_produto_unidade_regional (idt_produto, idt_unidade_regional, detalhe) values (';
                    $sql .= null($_POST['idt_produto']) . ', ' . null($dados['idt']) . ', ' . aspa($_POST['detalhe']) . ')';
                    execsql($sql);
                }
            }
        }
        break;


    case 'grc_atendimento_usuario_disponibilidade':

        if ($acao == 'inc' or $acao == 'alt') {
            $idt_atendimento_usuario_disponibilidade = $vlID;
            $diasemana = $_POST['dia'];

            $numdiasemana = '';

            if ($diasemana == 'Dom') {
                $numdiasemana = '1';
            }
            if ($diasemana == 'Seg') {
                $numdiasemana = '2';
            }
            if ($diasemana == 'Ter') {
                $numdiasemana = '3';
            }
            if ($diasemana == 'Qua') {
                $numdiasemana = '4';
            }
            if ($diasemana == 'Qui') {
                $numdiasemana = '5';
            }
            if ($diasemana == 'Sex') {
                $numdiasemana = '6';
            }
            if ($diasemana == 'Sab') {
                $numdiasemana = '7';
            }

            $sql_a = ' update grc_atendimento_usuario_disponibilidade set ';
            $sql_a .= ' num_dia     = ' . aspa($numdiasemana);
            $sql_a .= ' where idt = ' . null($idt_atendimento_usuario_disponibilidade);
            $result = execsql($sql_a);
        }
        break;


    case 'grc_atendimento_avulso':

        if ($acao == 'inc') {

            $idt_atendimento_avulso = $vlID;

            $sql1 = 'select ';
            $sql1 .= '  grc_av.*   ';
            $sql1 .= '  from grc_atendimento_avulso grc_av ';
            $sql1 .= '  where grc_av.idt = ' . null($idt_atendimento_avulso);

            $rs_a1 = execsql($sql1);

            if ($rs_a1->rows == 0) {
                
            } else {
                ForEach ($rs_a1->data as $row) {

                    $vetw = explode(' ', $row['data_atendimento']);
                    $data_inicial = $vetw[0];
                    $hora_inicial = $vetw[1];

                    $data_inicial_aux = substr($data_inicial, 8, 2) . '/' . substr($data_inicial, 5, 2) . '/' . substr($data_inicial, 0, 4);
                    $dia_semana = GRC_DiaSemana($data_inicial_aux, 'resumo1');   // formato dd/mm/aaaa

                    $mensagem = $row['mensagem'];
                    $telefone = $row['telefone'];
                    $celular = $row['celular'];
                    $idt_ponto_atendimento = $row['idt_ponto_atendimento'];
                    $assunto = $row['assunto'];
                    $protocolo = $row['protocolo'];
                    $email = $row['email'];
                    $cpf = $row['cpf'];
                    $cnpj = $row['cnpj'];
                    $nome_empresa = $row['nome_empresa'];
                    $nome = $row['nome'];

// grava registro na agenda

                    $idt_consultor_agenda = 0;
                    $idt_cliente_agenda = 0;
                    $idt_especialidade_agenda = 0;
                    $data_agenda = aspa($data_inicial);
                    $hora_agenda = aspa($hora_inicial);
                    $origem_agenda = aspa('Hora Extra');
                    $detalhe_agenda = aspa($assunto);
                    $situacao_agenda = aspa('Agendado');
                    $data_confirmacao_agenda = aspa($data_inicial);
                    $hora_confirmacao_agenda = aspa($hora_inicial);
                    $telefone_agenda = aspa($telefone);
                    $hora_chegada_agenda = aspa($hora_inicial);
                    $hora_atendimento_agenda = aspa($hora_inicial);
                    $idt_ponto_atendimento_agenda = null($idt_ponto_atendimento);
                    $dia_semana_agenda = aspa($dia_semana);
                    $hora_liberacao_agenda = aspa('');
                    $celular_agenda = aspa($celular);
                    $observacao_chegada_agenda = aspa('');
                    $observacao_atendimento_agenda = aspa('');
                    $cliente_texto_agenda = aspa($nome);
                    $tipo_pessoa_agenda = aspa('S');
                    $protocolo_agenda = aspa($protocolo);
                    $email_agenda = aspa($email);
                    $cpf_agenda = aspa($cpf);
                    $cnpj_agenda = aspa($cnpj);
                    $nome_empresa_agenda = aspa($nome_empresa);

                    $sql_i = ' insert into grc_atendimento_agenda ';
                    $sql_i .= ' (  ';
                    $sql_i .= ' idt_consultor, ';
                    $sql_i .= ' idt_cliente, ';
                    $sql_i .= ' idt_especialidade, ';
                    $sql_i .= ' data, ';
                    $sql_i .= ' hora, ';
                    $sql_i .= ' origem, ';
                    $sql_i .= ' detalhe, ';
                    $sql_i .= ' situacao, ';
                    $sql_i .= ' data_confirmacao, ';
                    $sql_i .= ' hora_confirmacao, ';
                    $sql_i .= ' telefone, ';
                    $sql_i .= ' hora_chegada, ';
                    $sql_i .= ' hora_atendimento, ';
                    $sql_i .= ' idt_ponto_atendimento, ';
                    $sql_i .= ' dia_semana, ';
                    $sql_i .= ' hora_liberacao, ';
                    $sql_i .= ' celular, ';
                    $sql_i .= ' observacao_chegada, ';
                    $sql_i .= ' observacao_atendimento, ';
                    $sql_i .= ' cliente_texto, ';
                    $sql_i .= ' tipo_pessoa, ';
                    $sql_i .= ' protocolo, ';
                    $sql_i .= ' email, ';
                    $sql_i .= ' cpf, ';
                    $sql_i .= ' cnpj, ';
                    $sql_i .= ' nome_empresa ';
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $idt_consultor_agenda, ";
                    $sql_i .= " $idt_cliente_agenda, ";
                    $sql_i .= " $idt_especialidade_agenda, ";
                    $sql_i .= " $data_agenda, ";
                    $sql_i .= " $hora_agenda, ";
                    $sql_i .= " $origem_agenda, ";
                    $sql_i .= " $detalhe_agenda, ";
                    $sql_i .= " $situacao_agenda, ";
                    $sql_i .= " $data_confirmacao_agenda, ";
                    $sql_i .= " $hora_confirmacao_agenda, ";
                    $sql_i .= " $telefone_agenda, ";
                    $sql_i .= " $hora_chegada_agenda, ";
                    $sql_i .= " $hora_atendimento_agenda, ";
                    $sql_i .= " $idt_ponto_atendimento_agenda, ";
                    $sql_i .= " $dia_semana_agenda, ";
                    $sql_i .= " $hora_liberacao_agenda, ";
                    $sql_i .= " $celular_agenda, ";
                    $sql_i .= " $observacao_chegada_agenda, ";
                    $sql_i .= " $observacao_atendimento_agenda, ";
                    $sql_i .= " $cliente_texto_agenda, ";
                    $sql_i .= " $tipo_pessoa_agenda, ";
                    $sql_i .= " $protocolo_agenda, ";
                    $sql_i .= " $email_agenda, ";
                    $sql_i .= " $cpf_agenda, ";
                    $sql_i .= " $cnpj_agenda, ";
                    $sql_i .= " $nome_empresa_agenda ";
                    $sql_i .= ') ';
                    $result = execsql($sql_i);

                    $idt_atendimento_agenda = lastInsertId();
                    $idt_atendimento_box = 'null';
                    $idt_atendimento_painel = idtAtendimentoPainel();
                    $status_painel_agenda = aspa('44');

// grava registro no painel

                    $sql_i = ' insert into grc_atendimento_agenda_painel ';
                    $sql_i .= ' (  ';
                    $sql_i .= ' idt_consultor, ';
                    $sql_i .= ' idt_cliente, ';
                    $sql_i .= ' idt_especialidade, ';
                    $sql_i .= ' idt_atendimento_agenda, ';
                    $sql_i .= ' idt_atendimento_box, ';
                    $sql_i .= ' idt_atendimento_painel, ';
                    $sql_i .= ' data, ';
                    $sql_i .= ' hora, ';
                    $sql_i .= ' origem, ';
                    $sql_i .= ' detalhe, ';
                    $sql_i .= ' situacao, ';
                    $sql_i .= ' data_confirmacao, ';
                    $sql_i .= ' hora_confirmacao, ';
                    $sql_i .= ' telefone, ';
                    $sql_i .= ' hora_chegada, ';
                    $sql_i .= ' hora_atendimento, ';
                    $sql_i .= ' idt_ponto_atendimento, ';
                    $sql_i .= ' dia_semana, ';
                    $sql_i .= ' hora_liberacao, ';
                    $sql_i .= ' celular, ';
                    $sql_i .= ' observacao_chegada, ';
                    $sql_i .= ' observacao_atendimento, ';
                    $sql_i .= ' cliente_texto, ';
                    $sql_i .= ' status_painel, ';
                    $sql_i .= ' protocolo  ';
                    $sql_i .= '  ) values ( ';
                    $sql_i .= " $idt_consultor_agenda, ";
                    $sql_i .= " $idt_cliente_agenda, ";
                    $sql_i .= " $idt_especialidade_agenda, ";
                    $sql_i .= " $idt_atendimento_agenda, ";
                    $sql_i .= " $idt_atendimento_box, ";
                    $sql_i .= " $idt_atendimento_painel, ";
                    $sql_i .= " $data_agenda, ";
                    $sql_i .= " $hora_agenda, ";
                    $sql_i .= " $origem_agenda, ";
                    $sql_i .= " $detalhe_agenda, ";
                    $sql_i .= " $situacao_agenda, ";
                    $sql_i .= " $data_confirmacao_agenda, ";
                    $sql_i .= " $hora_confirmacao_agenda, ";
                    $sql_i .= " $telefone_agenda, ";
                    $sql_i .= " $hora_chegada_agenda, ";
                    $sql_i .= " $hora_atendimento_agenda, ";
                    $sql_i .= " $idt_ponto_atendimento_agenda, ";
                    $sql_i .= " $dia_semana_agenda, ";
                    $sql_i .= " $hora_liberacao_agenda, ";
                    $sql_i .= " $celular_agenda, ";
                    $sql_i .= " $observacao_chegada_agenda, ";
                    $sql_i .= " $observacao_atendimento_agenda, ";
                    $sql_i .= " $cliente_texto_agenda, ";
                    $sql_i .= " $status_painel_agenda, ";
                    $sql_i .= " $protocolo_agenda ";
                    $sql_i .= ') ';
                    $result = execsql($sql_i);
                }
            }
        }

        break;

// SIAC - WEB Tom   - Ajustes do idt para o SIAC

    case 'siac_aplicacao':




// Atividade Economica de Cliente


        $sql1 = 'select ';
        $sql1 .= '  par.idt, par.CodParceiro ';
        $sql1 .= '  from db_pir_siac.parceiro par ';
        $sql1 .= '  where CodParceiro > 26100000 and CodParceiro < 26109000';
        $rs_a1 = execsql($sql1);
        ForEach ($rs_a1->data as $row) {
            $idt = $row['idt'];
            $codigo = $row['CodParceiro'];

            $sql_a = ' update  db_pir_siac.ativeconpj set ';
            $sql_a .= ' idt_parceiro      = ' . null($idt);
            $sql_a .= ' where CodParceiro  = ' . null($codigo);
            $result = execsql($sql_a);
        }

        /*
          //    Pessoa Juridica
          $sql1 = 'select ';
          $sql1 .= '  par.idt, par.CodParceiro ';
          $sql1 .= '  from db_pir_siac.parceiro par ';
          $rs_a1 = execsql($sql1);

          ForEach ($rs_a1->data as $row)
          {
          $idt      = $row['idt'];
          $codigo   = $row['CodParceiro'];

          $sql_a = ' update  db_pir_siac.pessoaj set ';
          $sql_a .= ' idt_parceiro      = '.null($idt);
          $sql_a .= ' where CodParceiro = '.null($codigo);
          $result = execsql($sql_a);
          }
          // Pessoa Física
          $sql1 = 'select ';
          $sql1 .= '  par.idt, par.CodParceiro ';
          $sql1 .= '  from db_pir_siac.parceiro par ';
          $rs_a1 = execsql($sql1);

          ForEach ($rs_a1->data as $row)
          {
          $idt      = $row['idt'];
          $codigo   = $row['CodParceiro'];

          $sql_a = ' update  db_pir_siac.pessoaf set ';
          $sql_a .= ' idt_parceiro      = '.null($idt);
          $sql_a .= ' where CodParceiro = '.null($codigo);
          $result = execsql($sql_a);
          }
          // Endereco
          $sql1 = 'select ';
          $sql1 .= '  par.idt, par.CodParceiro ';
          $sql1 .= '  from db_pir_siac.parceiro par ';
          $rs_a1 = execsql($sql1);

          ForEach ($rs_a1->data as $row)
          {
          $idt      = $row['idt'];
          $codigo   = $row['CodParceiro'];

          $sql_a = ' update  db_pir_siac.endereco set ';
          $sql_a .= ' idt_parceiro      = '.null($idt);
          $sql_a .= ' where CodParceiro = '.null($codigo);
          $result = execsql($sql_a);
          }
         */
        break;

    case 'grc_atendimento_pessoa':
        /*
          $idt_atendimento = $_POST['idt_atendimento'];
          $idt_pessoa = $_POST['idt_pessoa'];
          $tipo_relacao = $_POST['tipo_relacao'];
          if ($tipo_relacao == 'L') {
          $sql_a = ' update  grc_atendimento set ';
          $sql_a .= ' idt_pessoa  = '.null($idt_pessoa);
          $sql_a .= ' where idt = '.null($idt_atendimento);
          $result = execsql($sql_a);
          }
         * 
         */
        break;

    case 'grc_atendimento_cadastro':
    case 'grc_nan_visita_1_cadastro':
    case 'grc_nan_visita_2_cadastro':
        if ($_POST['representa_empresa'] == 'N') {
            $sql = "update grc_atendimento_organizacao set representa = 'N' where idt = " . null($vetID['grc_atendimento_organizacao']);
            execsql($sql);
        }

        $sql = "delete from grc_sincroniza_siac where idt_atendimento = " . null($vetID['grc_atendimento']);
        $sql .= " and tipo = 'E'";
        execsql($sql);

        sincronizaAtendimentoGEC($vetID['grc_atendimento']);

        if (nan == 'S') {
            $sql = '';
            $sql .= ' select idt_grupo_atendimento, nan_num_visita';
            $sql .= ' from grc_atendimento';
            $sql .= ' where idt = ' . null($vetID['grc_atendimento']);
            $rst = execsql($sql);
            $rowt = $rst->data[0];

            $sql = '';
            $sql .= ' select status_' . $rowt['nan_num_visita'] . ' as status';
            $sql .= ' from grc_nan_grupo_atendimento';
            $sql .= ' where idt = ' . null($rowt['idt_grupo_atendimento']);
            $rst = execsql($sql);
            $status_ant = $rst->data[0][0];

            $sql = '';
            $sql .= ' select cpf';
            $sql .= ' from grc_atendimento_pessoa';
            $sql .= ' where idt_atendimento = ' . null($vetID['grc_atendimento']);
            $sql .= " and tipo_relacao = 'L'";
            $rst = execsql($sql);

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from ' . db_pir_gec . 'gec_entidade';
            $sql .= ' where codigo = ' . aspa($rst->data[0][0]);
            $sql .= " and reg_situacao = 'A'";
            $rst = execsql($sql);

            $idt_pessoa = $rst->data[0][0];

            if ($rowt['nan_num_visita'] == 1) {
                $sql = '';
                $sql .= ' select cnpj';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt_atendimento = ' . null($vetID['grc_atendimento']);
                $sql .= " and representa = 'S'";
                $sql .= " and desvincular = 'N'";
                $rst = execsql($sql);
                $cnpj = $rst->data[0][0];

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir_gec . 'gec_entidade';
                $sql .= ' where codigo = ' . aspa($cnpj);
                $sql .= " and reg_situacao = 'A'";
                $rst = execsql($sql);
                $idt_organizacao = $rst->data[0][0];

                $sql = '';
                $sql .= ' select distinct year(g.dt_registro_2) as reg';
                $sql .= ' from grc_nan_grupo_atendimento g';
                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade e on e.idt = g.idt_organizacao';
                $sql .= ' where year(g.dt_registro_2) < ' . date('Y');
                $sql .= ' and e.codigo = ' . aspa($cnpj);
                $sql .= " and g.status_2 = 'AP'";
                $rst = execsql($sql);
                $nan_ciclo = $rst->rows + 1;

                $sql_up = ' idt_organizacao = ' . null($idt_organizacao) . ', nan_ciclo = ' . null($nan_ciclo) . ', ';
                $status_nan = 'DI';
            } else {
                $sql_up = '';
                $status_nan = 'AT';
            }

            $sql = "update grc_nan_grupo_atendimento set ";
            $sql .= $sql_up;

            if ($status_ant == 'AT' || $status_ant == 'CD' || $status_ant == 'DI' || $status_ant == 'DE') {
                $sql .= "status_" . $rowt['nan_num_visita'] . " = " . aspa($status_nan) . ', ';
            }

            $sql .= ' idt_pessoa_' . $rowt['nan_num_visita'] . ' = ' . null($idt_pessoa) . ' where idt = ' . null($rowt['idt_grupo_atendimento']);
            execsql($sql);
        }
        break;

    case 'grc_atendimento_organizacao':
        switch ($_POST['btnAcao']) {
            case $bt_alterar_lbl:
                if ($_POST['novo_registro'] == 'S') {
                    $sql = "update grc_atendimento_organizacao set representa = 'N' where idt_atendimento = " . null($_POST['idt_atendimento']);
                    execsql($sql);

                    $sql = "update grc_atendimento_organizacao set representa = 'S', novo_registro = 'N' where idt = " . null($vlID);
                    execsql($sql);
                }
                break;
        }

        $sql = "update grc_atendimento_organizacao set modificado = 'S' where idt = " . null($vlID);
        execsql($sql);

        $sql = 'delete from grc_atendimento_organizacao_cnae';
        $sql .= ' where idt_atendimento_organizacao = ' . null($vlID);
        $sql .= ' and cnae = ' . aspa($_POST['idt_cnae_principal']);
        execsql($sql);

        /*
          $idt_atendimento = $_POST['idt_atendimento'];
          $idt_organizacao = $_POST['idt_organizacao'];
          $sql_a = ' update  grc_atendimento set ';
          $sql_a .= ' idt_cliente = '.null($idt_organizacao);
          $sql_a .= ' where idt   = '.null($idt_atendimento);
          $result = execsql($sql_a);
         * 
         */
        break;

    case 'grc_evento_participante':
    case 'grc_evento_participante_filaespera':
        $sincroniza_siac_acao = false;

        if ($_POST['contrato'] != 'FE') {
            $sql = "update grc_evento_participante set fe_situacao = 'MA'";
            $sql .= ' where idt_atendimento = ' . null($vlID);
            $sql .= " and fe_situacao = 'AM'";
            $qtdAlt = execsql($sql);

            if ($qtdAlt > 0) {
                $sql = 'insert into grc_evento_participante_fe_log (idt_evento, idt_atendimento, usuario_nome, usuario_login, situacao) values (';
                $sql .= null($_POST['idt_evento']) . ', ' . null($vlID) . ', ' . aspa($_SESSION[CS]['g_nome_completo']) . ', ' . aspa($_SESSION[CS]['g_login']) . ", 'MA')";
                execsql($sql);
            }
        }

        if ($_POST['representa_empresa'] == 'N') {
            $sql = 'delete from grc_atendimento_organizacao where idt_atendimento = ' . null($vlID);
            execsql($sql);

            $sql = 'delete from grc_atendimento_pessoa where idt_atendimento = ' . null($vlID);
            $sql .= " and tipo_relacao = 'P'";
            execsql($sql);
        } else {
            $sql = "update grc_atendimento_organizacao set representa = 'S', novo_registro = 'N' where idt_atendimento = " . null($vlID);
            execsql($sql);

            $sql = 'delete from grc_atendimento_organizacao_cnae';
            $sql .= ' where idt_atendimento_organizacao in (';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_organizacao';
            $sql .= ' where idt_atendimento = ' . null($vlID);
            $sql .= ' )';
            $sql .= ' and cnae = ' . aspa($_POST['idt_cnae_principal']);
            execsql($sql);
        }

        $erro = MatriculaEventoCompostoSincroniza($_POST['idt_evento'], $vlID, false);

        if ($erro != '') {
            $erro = 'Erro na sincronia das matriculas no Evento Composto.<br />' . $erro;
            msg_erro($erro);
        }

        if ($_GET['veio'] == 'SG') {
            atualizaPagEventoSG($_POST['idt_evento']);
        }

        $sql = '';
        $sql .= ' select nao_sincroniza_rm, idt_instrumento, composto, dt_previsao_inicial, entrega_prazo_max';
        $sql .= ' from grc_evento';
        $sql .= ' where idt = ' . null($_POST['idt_evento']);
        $rs = execsql($sql);
        $rowe = $rs->data[0];

        $sincroniza_siac_acao_pess = true;

        $ssaIdtEventoComposto = Array();
        $ssaIdtAtendimentoComposto = Array();

        $ssaIdtEventoComposto[$_POST['idt_evento']] = $_POST['idt_evento'];
        $ssaIdtAtendimentoComposto[$vlID] = $vlID;

        if ($_GET['veio'] == 'SG' && $_POST['contrato'] == 'R' && $rowe['dt_previsao_inicial'] != '') {
            $sql = '';
            $sql .= " select a.idt";
            $sql .= " from grc_atendimento a";
            $sql .= " inner join grc_evento_participante ep on ep.idt_atendimento = a.idt ";
            $sql .= ' where a.idt_evento = ' . null($_POST['idt_evento']);
            $sql .= " and ep.contrato not in ('R', 'IC', 'FE')";
            $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
            $rs = execsql($sql);

            if ($rs->rows == 0) {
                $sql = 'update grc_evento set ';
                $sql .= ' dt_previsao_inicial = null, ';
                $sql .= ' dt_previsao_fim = null';
                $sql .= ' where idt = ' . null($_POST['idt_evento']);
                execsql($sql);
            }
        }

        $enviarEmail = false;

        switch ($_POST['bt_acao_insc']) {
            case 'print_rascunho':
                $sincroniza_siac_acao_pess = false;

                $botao_acao = '';
                $botao_acao .= '<script type="text/javascript">';
                $botao_acao .= 'listar_rel_pdf_url("' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '", "R");';
                $botao_acao .= 'setTimeout(\'self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '"\', 100);';
                $botao_acao .= '</script>';
                break;

            case 'print_contrato':
                $sincroniza_siac_acao_pess = false;

                //Calcula data do evento SGTEC
                if ($_GET['veio'] == 'SG' && $rowe['dt_previsao_inicial'] == '') {
                    $dt_previsao_inicial = getdata(false, true);

                    if (is_numeric($vetConf['evento_sg_qtd_inicio'])) {
                        $dt_previsao_inicial = Calendario::Intervalo_Util($dt_previsao_inicial, $vetConf['evento_sg_qtd_inicio']);
                    }

                    $sql = '';
                    $sql .= " select ord_lste.data_conclusao_servico_cotacao";
                    $sql .= " from " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista_endidade ord_lste";
                    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem_lista ord_lst on ord_lst.idt = ord_lste.idt_gec_contratacao_credenciado_ordem_lista";
                    $sql .= " inner join " . db_pir_gec . "gec_contratacao_credenciado_ordem ord on ord.idt = ord_lst.idt_gec_contratacao_credenciado_ordem";
                    $sql .= " where ord_lst.ativo = 'S'";
                    $sql .= " and ord.ativo = 'S'";
                    $sql .= " and ord_lst.idt_organizacao = ord_lste.idt_organizacao ";
                    $sql .= ' and ord.idt_evento = ' . null($_POST['idt_evento']);
                    $rs = execsql($sql);
                    $dt_previsao_fim = $rs->data[0][0];

                    if ($dt_previsao_fim == '') {
                        $dt_previsao_fim = $dt_previsao_inicial;

                        if ($rowe['entrega_prazo_max'] != '') {
                            $dt_previsao_fim = Calendario::Intervalo_Corrido($dt_previsao_fim, $rowe['entrega_prazo_max']);
                        }
                    } else {
                        $dt_previsao_fim = trata_data($dt_previsao_fim);
                    }

                    $sql = 'update grc_evento set ';
                    $sql .= ' dt_previsao_inicial = ' . aspa(trata_data($dt_previsao_inicial)) . ', ';
                    $sql .= ' dt_previsao_fim = ' . aspa(trata_data($dt_previsao_fim));
                    $sql .= ' where idt = ' . null($_POST['idt_evento']);
                    execsql($sql);
                }

                $botao_acao = '';
                $botao_acao .= '<script type="text/javascript">';
                $botao_acao .= 'listar_rel_pdf_url("' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '", "C");';
                $botao_acao .= 'setTimeout(\'self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '"\', 100);';
                $botao_acao .= '</script>';
                break;

            case 'voltar_rascunho':
                $sincroniza_siac_acao_pess = false;

                $botao_acao = '';
                $botao_acao .= '<script type="text/javascript">';
                $botao_acao .= 'self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '";';
                $botao_acao .= '</script>';
                break;

            case 'gerar_contrato':
                $_GET['id'] = $vetID['grc_atendimento_pessoa'];

                $contrato_pdf = 'contrato_' . $vlID . '_' . GerarStr(20) . '.pdf';
                $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_participante_contrato/');

                if (!file_exists($pathPDF)) {
                    mkdir($pathPDF);
                }

                $contrato_txt = salvaPDF($pathPDF . $contrato_pdf);
                $contrato_txt = base64_encode(serialize(print_r($contrato_txt, true)));

                if (!file_exists($pathPDF . $contrato_pdf)) {
                    erro_try('Contrato em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                    echo '<script type="text/javascript">';
                    echo 'alert("Contrato em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                    echo 'self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '";';
                    echo '</script>';
                    onLoadPag();
                    exit();
                }

                $sql = 'insert into grc_evento_participante_contrato (idt_atendimento, idt_usuario_cont, contrato_txt, contrato_pdf) values (';
                $sql .= null($vlID) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ' . aspa($contrato_txt) . ', ' . aspa($contrato_pdf) . ')';
                execsql($sql);
                $idt_contrato = lastInsertId();

                if ($_FILES['contrato_ass_pdf']['name'] != '') {
                    $Erro = ErroArq('contrato_ass_pdf');
                    if ($Erro != "OK") {
                        erro_try('Erro no Contrato Assinado: ' . $Erro);

                        echo '<script type="text/javascript">';
                        echo 'alert("Erro no Contrato Assinado: ' . $Erro . '");';
                        echo 'self.location = "' . $_SESSION[CS]['grc_evento_participante_volta_cad'] . '";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $path = dirname($_SERVER['SCRIPT_FILENAME']);
                    if ($path == '')
                        msg_erro('Não foi possível obter o path real do sistema!');

                    $path .= DIRECTORY_SEPARATOR . $dir_file;
                    if (!file_exists($path))
                        mkdir($path);

                    $path .= DIRECTORY_SEPARATOR . 'grc_evento_participante_contrato';
                    if (!file_exists($path)) {
                        mkdir($path);
                    }

                    $path .= DIRECTORY_SEPARATOR;

                    $path = str_replace('/', DIRECTORY_SEPARATOR, $path);

                    set_time_limit(600);

                    $nomearq = mb_strtolower($idt_contrato . '_' . 'contrato_ass_pdf' . '_' . $microtime . '_' . troca_caracter($_FILES['contrato_ass_pdf']['name']));
                    move_uploaded_file($_FILES['contrato_ass_pdf']['tmp_name'], $path . $nomearq);

                    $sql = "update grc_evento_participante_contrato set contrato_ass_pdf = " . aspa($nomearq);
                    $sql .= " where idt = " . null($idt_contrato);
                    execsql($sql);
                }

                $sql = "update grc_evento_participante_pagamento set idt_evento_participante_contrato = " . null($idt_contrato);
                $sql .= ', idt_evento_situacao_pagamento = 5';
                $sql .= " where idt_atendimento = " . null($vlID);
                $sql .= " and estornado = 'N'";
                $sql .= " and operacao = 'C'";
                $sql .= ' and idt_aditivo_participante is null';
                execsql($sql);

                $enviarEmail = true;

                if ($_GET['veio'] != 'SG') {
                    $vetEV = Array();

                    if ($rowe['composto'] == 'S' || $rowe['idt_instrumento'] == 54) {
                        $sql = '';
                        $sql .= ' select a.idt, a.idt_evento';
                        $sql .= ' from grc_atendimento a';
                        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                        $sql .= ' where a.idt_atendimento_pai = ' . null($vlID);
                        $sql .= " and ep.ativo = 'S'";
                        $rst = execsql($sql);

                        foreach ($rst->data as $rowt) {
                            $vetEV[] = $rowt['idt'];

                            $ssaIdtEventoComposto[$rowt['idt_evento']] = $rowt['idt_evento'];
                            $ssaIdtAtendimentoComposto[$rowt['idt']] = $rowt['idt'];
                        }
                    } else {
                        $vetEV[] = $vlID;
                    }

                    foreach ($vetEV as $idt_evento_tmp) {
                        $sql = "delete from grc_sincroniza_siac where idt_atendimento = " . null($idt_evento_tmp);
                        $sql .= " and tipo = 'E'";
                        execsql($sql);

                        sincronizaAtendimentoGEC($idt_evento_tmp);
                    }

                    if ($rowe['nao_sincroniza_rm'] == 'N') {
                        //sincronização com o RM
                        $sql = '';
                        $sql .= ' select idt';
                        $sql .= ' from grc_sincroniza_siac';
                        $sql .= ' where idt_atendimento = ' . null($vlID);
                        $sql .= " and tipo = 'RM_INC'";
                        $rst = execsql($sql);

                        if ($rst->rows == 0) {
                            $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, tipo) values (';
                            $sql .= null($vlID) . ', ' . null($_POST['idt_evento']) . ", 'RM_INC')";
                            execsql($sql);
                        } else {
                            $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                            $sql .= ' where idt = ' . null($rst->data[0][0]);
                            execsql($sql);
                        }
                    }

                    $sincroniza_siac_acao = true;
                }
                break;

            case 'cancelar_contrato':
                $sql = '';
                $sql .= ' select *';
                $sql .= ' from grc_evento_participante_pagamento';
                $sql .= " where idt_atendimento = " . null($vlID);
                $sql .= " and estornado = 'N'";
                $sql .= " and operacao = 'C'";
                $sql .= ' and idt_aditivo_participante is null';
                $sql .= " and lojasiac_id is null";
                $rst = execsqlNomeCol($sql);

                foreach ($rst->data as $rowt) {
                    $rowt['idt_evento_situacao_pagamento'] = 1;
                    $rowt['estornado'] = 'T';

                    unset($rowt['idt']);
                    unset($rowt['idt_evento_participante_contrato']);

                    $rowt = array_map('aspa', $rowt);

                    $sql = 'insert into grc_evento_participante_pagamento (' . implode(', ', array_keys($rowt)) . ') values (' . implode(', ', $rowt) . ')';
                    execsql($sql);
                }

                $sql = "update grc_evento_participante_pagamento set estornado = 'S'";
                $sql .= " where idt_atendimento = " . null($vlID);
                $sql .= " and estornado = 'N'";
                $sql .= " and operacao = 'C'";
                $sql .= ' and idt_aditivo_participante is null';
                $sql .= " and lojasiac_id is null";
                execsql($sql);

                $sql = "update grc_evento_participante_pagamento set estornado = 'N'";
                $sql .= " where idt_atendimento = " . null($vlID);
                $sql .= " and estornado = 'T'";
                execsql($sql);

                $sql = "update grc_evento_participante_contrato set dt_cancelamento = now(), idt_usuario_canc = " . null($_SESSION[CS]['g_id_usuario']);
                $sql .= " where idt_atendimento = " . null($vlID);
                $sql .= " and dt_cancelamento is null";
                execsql($sql);

                $vetEV = Array();

                if ($rowe['composto'] == 'S' || $rowe['idt_instrumento'] == 54) {
                    $sql = '';
                    $sql .= ' select a.idt, a.idt_evento';
                    $sql .= ' from grc_atendimento a';
                    $sql .= ' left outer join grc_evento e on e.idt = a.idt_evento';
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                    $sql .= ' where a.idt_atendimento_pai = ' . null($vlID);
                    $sql .= " and ep.ativo = 'S'";
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $vetEV[] = Array(
                            'at' => $rowt['idt'],
                            'ev' => $rowt['idt_evento'],
                        );

                        $ssaIdtEventoComposto[$rowt['idt_evento']] = $rowt['idt_evento'];
                        $ssaIdtAtendimentoComposto[$rowt['idt']] = $rowt['idt'];
                    }
                } else {
                    $vetEV[] = Array(
                        'at' => $vlID,
                        'ev' => $_POST['idt_evento'],
                    );
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    //Exclui a inscrição no SiacWeb
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_atendimento = ' . null($idt_evento_tmp['at']);
                    $sql .= " and tipo = 'EP_EXC'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, tipo) values (';
                        $sql .= null($idt_evento_tmp['at']) . ', ' . null($idt_evento_tmp['ev']) . ", 'EP_EXC')";
                        execsql($sql);
                    } else {
                        $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        execsql($sql);
                    }
                }

                $sincroniza_siac_acao = true;
                break;

            case 'inscricao_cancelada':
                $erro = ajustaCupomVoucherCancelamentoMatricula($idt_evento, $vlID, true);

                if ($erro != '') {
                    msg_erro($erro);
                }

                $sincroniza_siac_acao_pess = false;

                if ($rowe['idt_instrumento'] == 54) {
                    $sql = '';
                    $sql .= ' select a.idt, a.idt_evento, ec.idt as idt_evento_combo';
                    $sql .= ' from grc_atendimento a';
                    $sql .= ' inner join grc_evento_combo ec on ec.idt_evento = a.idt_evento and ec.idt_evento_origem = ' . null($_POST['idt_evento']);
                    $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                    $sql .= ' where a.idt_atendimento_pai = ' . null($vlID);
                    $sql .= " and ep.ativo = 'S'";
                    $rst = execsql($sql);

                    foreach ($rst->data as $rowt) {
                        $sql = "update grc_evento_combo set qtd_utilizada = qtd_utilizada - 1, qtd_vaga = qtd_vaga + 1";
                        $sql .= " where idt = " . null($rowt['idt_evento_combo']);
                        execsql($sql);

                        $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - 1, qtd_vagas_bloqueadas = qtd_vagas_bloqueadas + 1";
                        $sql .= " where idt = " . null($rowt['idt_evento']);
                        execsql($sql);


                        $vetEV[] = Array(
                            'at' => $rowt['idt'],
                            'ev' => $rowt['idt_evento'],
                        );

                        $ssaIdtEventoComposto[$rowt['idt_evento']] = $rowt['idt_evento'];
                        $ssaIdtAtendimentoComposto[$rowt['idt']] = $rowt['idt'];
                    }
                } else {
                    $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - 1";
                    $sql .= " where idt = " . null($_POST['idt_evento']);
                    execsql($sql);

                    if ($rowe['composto'] == 'S') {
                        $sql = '';
                        $sql .= ' select a.idt, a.idt_evento';
                        $sql .= ' from grc_atendimento a';
                        $sql .= ' left outer join grc_evento e on e.idt = a.idt_evento';
                        $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                        $sql .= ' where a.idt_atendimento_pai = ' . null($vlID);
                        $sql .= " and ep.ativo = 'S'";
                        $rst = execsql($sql);

                        foreach ($rst->data as $rowt) {
                            $vetEV[] = Array(
                                'at' => $rowt['idt'],
                                'ev' => $rowt['idt_evento'],
                            );

                            $ssaIdtEventoComposto[$rowt['idt_evento']] = $rowt['idt_evento'];
                            $ssaIdtAtendimentoComposto[$rowt['idt']] = $rowt['idt'];
                        }
                    } else {
                        $vetEV[] = Array(
                            'at' => $vlID,
                            'ev' => $_POST['idt_evento'],
                        );
                    }
                }

                foreach ($vetEV as $idt_evento_tmp) {
                    //Exclui a inscrição no SiacWeb
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_sincroniza_siac';
                    $sql .= ' where idt_atendimento = ' . null($idt_evento_tmp['at']);
                    $sql .= " and tipo = 'EP_EXC'";
                    $rst = execsql($sql);

                    if ($rst->rows == 0) {
                        $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, tipo) values (';
                        $sql .= null($idt_evento_tmp['at']) . ', ' . null($idt_evento_tmp['ev']) . ", 'EP_EXC')";
                        execsql($sql);
                    } else {
                        $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                        $sql .= ' where idt = ' . null($rst->data[0][0]);
                        $sql .= ' and erro is not null';
                        execsql($sql);
                    }
                }

                $sincroniza_siac_acao = true;
                break;

            case 'inscricao_excluir':
                if (filadeespera != 'S') {
                    $sql = "update grc_evento set qtd_vagas_resevado = qtd_vagas_resevado - 1";
                    $sql .= " where idt = " . null($_POST['idt_evento']);
                    execsql($sql);
                }
                break;
        }

        if (filadeespera == 'S') {
            $sincroniza_siac_acao_pess = false;
        }

        if ($_POST['volta_cad'] != 'S' && $sincroniza_siac_acao_pess) {
            $vetEV = Array();

            if ($rowe['composto'] == 'S' || $rowe['idt_instrumento'] == 54) {
                $sql = '';
                $sql .= ' select a.idt, a.idt_evento, p.idt as idt_atendimento_pessoa';
                $sql .= ' from grc_atendimento a';
                $sql .= " left outer join grc_atendimento_pessoa p on p.idt_atendimento = a.idt ";
                $sql .= ' left outer join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                $sql .= ' where a.idt_atendimento_pai = ' . null($vlID);
                $sql .= " and ep.ativo = 'S'";
                $rst = execsql($sql);

                foreach ($rst->data as $rowt) {
                    $vetEV[] = Array(
                        'at' => $rowt['idt'],
                        'ev' => $rowt['idt_evento'],
                        'atp' => $rowt['idt_atendimento_pessoa'],
                    );
                }
            } else {
                $vetEV[] = Array(
                    'at' => $vlID,
                    'ev' => $_POST['idt_evento'],
                    'atp' => $vetID['grc_atendimento_pessoa'],
                );
            }

            foreach ($vetEV as $idt_evento_tmp) {
                $sql = '';
                $sql .= ' select e.gratuito';
                $sql .= ' from grc_evento e';
                $sql .= ' where e.idt = ' . null($idt_evento_tmp['ev']);
                $rs = execsql($sql);
                $gratuito = $rs->data[0]['gratuito'];

                $sql = '';
                $sql .= ' select evento_alt_siacweb';
                $sql .= ' from grc_atendimento_pessoa';
                $sql .= " where idt = " . null($idt_evento_tmp['atp']);
                $rs = execsql($sql);

                if ($rs->data[0][0] == 'S' || $gratuito == 'S') {
                    $sincroniza_siac_acao = true;
                    sincronizaAtendimentoGEC($idt_evento_tmp['at'], $idt_evento_tmp['atp']);

                    $sql = "update grc_atendimento_pessoa set evento_alt_siacweb = 'N'";
                    $sql .= " where idt = " . null($idt_evento_tmp['atp']);
                    execsql($sql);

                    $ssaIdtEventoComposto[$idt_evento_tmp['ev']] = $idt_evento_tmp['ev'];
                    $ssaIdtAtendimentoComposto[$idt_evento_tmp['at']] = $idt_evento_tmp['at'];
                }
            }
        }

        if ($_POST['bt_acao_insc'] != 'inscricao_cancelada') {
            $idt_entidade_pj = idtEntidadeGEC('O', $_POST['cnpj'], $_POST['nirf'], $_POST['dap'], $_POST['rmp'], $_POST['ie_prod_rural'], $_POST['sicab_codigo']);

            //Atualiza a pessoa juridica no voucher A da matricula
            $sql = 'update grc_evento_publicacao_voucher_registro vr';
            $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
            $sql .= ' set vr.idt_entidade_pj = ' . null($idt_entidade_pj);
            $sql .= ' where vr.idt_matricula_gerado = ' . null($vlID);
            $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
            execsql($sql);

            //Atualiza a pessoa fisica no voucher A da matricula
            $sql = 'update grc_evento_publicacao_voucher_registro vr';
            $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
            $sql .= ' set vr.cpf = ' . aspa($_POST['cpf']) . ',';
            $sql .= ' vr.nome_pessoa = ' . aspa($_POST['nome']);
            $sql .= ' where vr.idt_matricula_utilizado = ' . null($vlID);
            $sql .= ' and v.idt_tipo_voucher = ' . null($vetTipoVoucherCodIDT['A']);
            execsql($sql);

            //Atualiza a pessoa fisica e juridica do voucher E utilizado na matricula
            $sql = 'update grc_evento_publicacao_voucher_registro vr';
            $sql .= ' set vr.cpf = ' . aspa($_POST['cpf']) . ',';
            $sql .= ' vr.nome_pessoa = ' . aspa($_POST['nome']) . ',';
            $sql .= ' vr.dt_utilizacao = now(),';
            $sql .= ' vr.idt_matricula_utilizado = ' . null($vlID);
            $sql .= ' where vr.numero = ' . aspa($_POST['usado_numero_voucher_e']);
            execsql($sql);
        }

        if ($sincroniza_siac_acao) {
            $ssaIdtEvento = implode(', ', $ssaIdtEventoComposto);
            $ssaIdtAtendimento = implode(', ', $ssaIdtAtendimentoComposto);
            require_once 'sincroniza_siac_acao.php';
        }

        if ($enviarEmail && $_POST['email_indicado'] != '') {
            $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade, prd.codigo as codigo_produto";
            $sql .= ' from grc_evento grc_e';
            $sql .= ' inner join grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
            $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
            $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
            $sql .= ' left outer join grc_produto prd on prd.idt = grc_e.idt_produto';
            $sql .= " where grc_e.idt  = " . null($_POST['idt_evento']);
            $rs = execsqlNomeCol($sql);
            $rowEV = $rs->data[0];

            $sql = '';
            $sql .= ' select vr.numero as numero_voucher, vr.data_validade as validade_voucher, v.perc_desconto as desconto_voucher';
            $sql .= ' from grc_evento_publicacao_voucher_registro vr';
            $sql .= ' inner join grc_evento_publicacao_voucher v on v.idt = vr.idt_evento_publicacao_voucher';
            $sql .= ' where vr.idt = ' . null($_POST['idt_voucher_e_indicado']);
            $rs = execsqlNomeCol($sql);
            $rowEV = array_merge($rowEV, $rs->data[0]);

            $sql = '';
            $sql .= ' select protocolo';
            $sql .= ' from grc_atendimento';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsql($sql);
            $protocolo = $rs->data[0][0] . '_VOUCHER_E';

            $rowEV['nome_pessoa'] = $_POST['nome'];

            $vetGRC_parametros = GRC_parametros();
            $assunto = grc_evento_participante_msgParametros($vetGRC_parametros['voucher_e_email_01'], $protocolo, $rowEV);
            $mensagem = grc_evento_participante_msgParametros($vetGRC_parametros['voucher_e_email_02'], $protocolo, $rowEV);

            $vetRegProtocolo = Array(
                'protocolo' => $protocolo,
                'origem' => 'voucher_e_email_0102',
            );
            $respEmail = enviarEmail(db_pir_grc, $assunto, $mensagem, $_POST['email_indicado'], $_POST['email_indicado'], true, $vetRegProtocolo);
        }
        break;

    case 'grc_evento_participante_pessoa_p':
        /* Evento Composto não tem outros participantes
          $erro = MatriculaEventoCompostoSincroniza($idt_evento, $idt_atendimento, false);

          if ($erro != '') {
          $erro = 'Erro na sincronia das matriculas no Evento Composto.<br />'.$erro;
          msg_erro($erro);
          }
         * 
         */

        $sql = '';
        $sql .= ' select e.gratuito';
        $sql .= ' from grc_evento e';
        $sql .= ' where e.idt = ' . null($idt_evento);
        $rs = execsql($sql);
        $gratuito = $rs->data[0]['gratuito'];

        $sql = '';
        $sql .= ' select evento_alt_siacweb';
        $sql .= ' from grc_atendimento_pessoa';
        $sql .= " where idt = " . null($vetID['grc_atendimento_pessoa']);
        $rs = execsql($sql);

        if ($rs->data[0][0] == 'S' || $gratuito == 'S') {
            sincronizaAtendimentoGEC($idt_atendimento, $vetID['grc_atendimento_pessoa']);

            $sql = "update grc_atendimento_pessoa set evento_alt_siacweb = 'N'";
            $sql .= " where idt = " . null($vetID['grc_atendimento_pessoa']);
            execsql($sql);

            $ssaIdtEvento = $idt_evento;
            $ssaIdtAtendimento = $idt_atendimento;
            require_once 'sincroniza_siac_acao.php';
        }
        break;

    case 'grc_evento_participante_pagamento':
        if ($_GET['veio'] == 'SG') {
            $sql = '';
            $sql .= ' select a.idt_evento, e.nao_sincroniza_rm, e.sgtec_modelo, e.vl_determinado';
            $sql .= ' from grc_atendimento a';
            $sql .= ' inner join grc_evento e on e.idt = a.idt_evento';
            $sql .= ' where a.idt = ' . null($_POST['idt_atendimento']);
            $rs = execsql($sql);
            $idt_evento = $rs->data[0]['idt_evento'];
            $nao_sincroniza_rm = $rs->data[0]['nao_sincroniza_rm'];
            $sgtec_modelo = $rs->data[0]['sgtec_modelo'];
            $vl_determinado = $rs->data[0]['vl_determinado'];

            atualizaPagEventoSG($idt_evento);

            if ($sgtec_modelo == 'E' && $vl_determinado == 'S') {
                atualizaRegDevolucaoSG($_POST['idt_atendimento'], 'MA');
            }

            $sql = '';
            $sql .= ' select count(x.idt_atendimento) as qtd, avg(x.pag) as media';
            $sql .= ' from (';
            $sql .= ' select a.idt as idt_atendimento, sum(p.valor_pagamento) as pag';
            $sql .= ' from ' . db_pir_grc . 'grc_atendimento a';
            $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante_pagamento p on p.idt_atendimento = a.idt';
            $sql .= ' left outer join ' . db_pir_grc . 'grc_evento_participante ep on ep.idt_atendimento = a.idt';
            $sql .= ' where a.idt_evento = ' . null($idt_evento);
            $sql .= ' and p.idt_aditivo_participante is null';
            $sql .= " and (p.estornado is null or p.estornado <> 'S')";
            $sql .= " and (p.operacao is null or p.operacao = 'C')";
            $sql .= whereEventoParticipante();
            $sql .= ' group by a.idt';
            $sql .= ' ) x';
            $rs = execsql($sql);
            $rowu = $rs->data[0];

            $tot = $rowu['qtd'] * $rowu['media'];

            $sql = 'update grc_evento set valor_inscricao = ' . null($rowu['media']);
            $sql .= ', quantidade_participante = ' . null($rowu['qtd']);
            $sql .= ', previsao_receita = ' . null($tot);
            $sql .= " where idt = " . null($idt_evento);
            execsql($sql);

            $sql = 'update grc_evento_insumo set';
            $sql .= ' quantidade = 1, ';
            $sql .= ' quantidade_evento = ' . null($rowu['qtd']) . ', ';
            $sql .= ' custo_unitario_real = ' . null($rowu['media']) . ', ';
            $sql .= ' rtotal_minimo = ' . null($tot) . ', ';
            $sql .= ' rtotal_maximo = ' . null($tot) . ', ';
            $sql .= ' receita_total = ' . null($tot);
            $sql .= ' where idt_evento = ' . null($idt_evento);
            $sql .= " and codigo = 'evento_insc'";
            execsql($sql);

            if ($idt_evento_situacao != 24 && $idt_evento_situacao >= 14 && $nao_sincroniza_rm == 'N' && $_POST['btnAcao'] != $bt_excluir_lbl) {
                //sincronização com o RM
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_sincroniza_siac';
                $sql .= ' where idt_evento_participante_pagamento = ' . null($vlID);
                $sql .= " and tipo = 'RM_INC_PAG'";
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_sincroniza_siac (idt_atendimento, idt_evento, idt_evento_participante_pagamento, tipo) values (';
                    $sql .= null($_POST['idt_atendimento']) . ', ' . null($idt_evento) . ', ' . null($vlID) . ", 'RM_INC_PAG')";
                    execsql($sql);
                } else {
                    $sql = 'update grc_sincroniza_siac set dt_registro = now(), dt_sincroniza = null, erro = null';
                    $sql .= ' where idt = ' . null($rst->data[0][0]);
                    execsql($sql);
                }

                $ssaIdtEvento = $idt_evento;
                $ssaIdtAtendimento = $_POST['idt_atendimento'];
                $ssaIdtPagamento = $vlID;
                require_once 'sincroniza_siac_acao.php';
            }
        }
        break;

    case 'grc_atendimento':
    case 'grc_atendimento_monitor':
    case 'monitor_atendimento':
        switch ($_POST['situacao']) {
            case 'Esperando Atendimento':
                $botao_acao = str_replace('&aba=1', '&aba=2', $botao_acao);
                break;

            case 'Finalizado':
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Atendimento Webservice'";
                execsql($sql_a);

                if ($_GET['pesquisa'] == 'S') {
                    $botao_acao = '';
                } else {
                    $botao_acao = '<script type="text/javascript">self.location = "' . $_SESSION[CS]['grc_atendimento_' . $_GET['session_volta']] . '";</script>';
                }

                $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = " . null($vlID);
                execsql($sql);

                // GUY acrescentado para gerar pendência
                if ($instrumento == 2) {
                    if ($origem == "D") {
                        $sql_a = ' update grc_atendimento_pendencia set ';
                        $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                        $sql_a .= " dt_update = now(),";
                        $sql_a .= " ativo  =  'N'";
                        $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                        $sql_a .= " and ativo  =  'S'";
                        $sql_a .= " and tipo   =  'Atendimento Distância'";
                        execsql($sql_a);

                        $ret = GerarPendenciaDistancia($vlID);
                        if ($ret != 1) {
                            echo "  ret == $ret <br />";
                        }
                    }
                }

                $sql = "select  ";
                $sql .= " grc_a.idt_atendimento_agenda, grc_a.origem";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
                $sql_a = ' update grc_atendimento_agenda set ';
                $sql_a .= " situacao          = 'Atendido'";
                $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
                execsql($sql_a);

                $sql = "delete from grc_sincroniza_siac where idt_atendimento = " . null($vetID['grc_atendimento']);
                execsql($sql);

                sincronizaAtendimentoGEC($vetID['grc_atendimento']);
                sincronizaSIAChist($vetID['grc_atendimento']);
                break;

            case 'Cancelado':
                if ($_GET['pesquisa'] == 'S') {
                    $botao_acao = '';
                } else {
                    $botao_acao = '<script type="text/javascript">self.location = "' . $_SESSION[CS]['grc_atendimento_' . $_GET['session_volta']] . '";</script>';
                }

                $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = " . null($vlID);
                execsql($sql);

                $sql = "select  ";
                $sql .= " grc_a.idt_atendimento_agenda  ";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $wcodigo = '';
                ForEach ($rs->data as $row) {
                    $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
                    $sql_a = ' update grc_atendimento_agenda set ';
                    $sql_a .= " situacao          = 'Cancelado'";
                    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
                    execsql($sql_a);
                }
                break;
        }
        break;

    case 'grc_nan_visita_1':
    case 'grc_nan_visita_2':
        if ($menu == 'grc_nan_visita_2') {
            $num_visita = 2;
            $aba = 1;

            //Plano Facíl
            foreach ($rsPFA->data as $rowPFA) {
                $sql = 'update grc_plano_facil_area set decido_planejo = ' . aspa($_POST['decido_planejo_' . $rowPFA['idt']]);
                $sql .= ' where idt = ' . null($rowPFA['idt']);
                execsql($sql);
            }

            $sql = 'update grc_plano_facil set banco_ideia = ' . aspa($_POST['banco_ideia']) . ', quemquandoprocurar = ' . aspa($_POST['quemquandoprocurar']);
            $sql .= ' where idt = ' . null($rowPF['idt']);
            execsql($sql);
        } else {
            $num_visita = 1;
            $aba = 3;
        }

        $status_nan = '';

        switch ($_POST['situacao']) {
            case 'Enviar para Validação':
                $status_nan = 'EV';

                if ($_GET['pesquisa'][0] == 'S') {
                    $botao_acao = '';
                } else if ($_SESSION[CS][$menu . '_' . $_GET['session_volta']] == '') {
                    $botao_acao = '<script type="text/javascript">self.location = "index.php";</script>';
                } else {
                    $botao_acao = '<script type="text/javascript">self.location = "' . $_SESSION[CS][$menu . '_' . $_GET['session_volta']] . '";</script>';
                }

                $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = " . null($vlID);
                execsql($sql);

                $sql = "select  ";
                $sql .= " grc_a.idt_atendimento_agenda  ";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $wcodigo = '';
                ForEach ($rs->data as $row) {
                    $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
                    $sql_a = ' update grc_atendimento_agenda set ';
                    $sql_a .= " situacao          = 'Atendido'";
                    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
                    execsql($sql_a);
                }

                $sql = "delete from grc_sincroniza_siac where idt_atendimento = " . null($vetID['grc_atendimento']);
                execsql($sql);

                sincronizaAtendimentoGEC($vetID['grc_atendimento']);

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'NAN - Visita {$num_visita}'";
                execsql($sql_a);

                //Pendencia
                $sql = '';
                $sql .= ' select nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($_POST['idt_consultor']);
                $rst = execsql($sql);
                $txt = '[' . $rst->data[0][0] . '] ';

                $sql = '';
                $sql .= ' select razao_social';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt = ' . null($_POST['idt_cliente']);
                $rst = execsql($sql);
                $txt .= $rst->data[0][0];

                $idt_atendimento = null($vetID['grc_atendimento']);
                $idt_usuario = null($_SESSION[CS]['g_id_usuario']);
                $data = aspa(trata_data(date('d/m/Y H:i:s')));
                $data_solucao = aspa(trata_data(date('d/m/Y')));
                $assunto = aspa($txt);
                $observacao = aspa($txt);
                $protocolo = aspa($_POST['protocolo']);
                $status = aspa('Aprovação');
                $tipo = aspa('NAN - Visita ' . $num_visita);
                $recorrencia = aspa('1');
                $idt_gestor_evento = null($_POST['idt_nan_tutor']);
                $idt_ponto_atendimento = null($_POST['idt_ponto_atendimento']);

                $sql_i = ' insert into grc_atendimento_pendencia ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_atendimento, ";
                $sql_i .= " protocolo, ";
                $sql_i .= " idt_ponto_atendimento, ";
                $sql_i .= " idt_gestor_local, ";
                $sql_i .= " recorrencia, ";
                $sql_i .= " idt_responsavel_solucao, ";
                $sql_i .= " status, ";
                $sql_i .= " tipo, ";
                $sql_i .= " idt_usuario, ";
                $sql_i .= " data, ";
                $sql_i .= " data_solucao, ";
                $sql_i .= " assunto, ";
                $sql_i .= " observacao ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_atendimento, ";
                $sql_i .= " $protocolo, ";
                $sql_i .= " $idt_ponto_atendimento, ";
                $sql_i .= " $idt_gestor_evento, ";
                $sql_i .= " $recorrencia, ";
                $sql_i .= " $idt_gestor_evento, ";
                $sql_i .= " $status, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $idt_usuario, ";
                $sql_i .= " $data, ";
                $sql_i .= " $data_solucao, ";
                $sql_i .= " $assunto, ";
                $sql_i .= " $observacao ";
                $sql_i .= ') ';
                execsql($sql_i);
                copiaAtendimentoPendenciaTransResp(lastInsertId());
                break;

            case 'Cancelado':
                $status_nan = 'CA';

                if ($_GET['pesquisa'][0] == 'S') {
                    $botao_acao = '';
                } else {
                    $botao_acao = '<script type="text/javascript">self.location = "' . $_SESSION[CS][$menu . '_' . $_GET['session_volta']] . '";</script>';
                }

                $sql = "update grc_atendimento set data_atendimento_relogio = 'N' where idt = " . null($vlID);
                execsql($sql);

                $sql = "select  ";
                $sql .= " grc_a.idt_atendimento_agenda  ";
                $sql .= " from grc_atendimento grc_a ";
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $wcodigo = '';
                ForEach ($rs->data as $row) {
                    $idt_atendimento_agenda = $row['idt_atendimento_agenda'];
                    $sql_a = ' update grc_atendimento_agenda set ';
                    $sql_a .= " situacao          = 'Cancelado'";
                    $sql_a .= ' where idt  = ' . null($idt_atendimento_agenda);
                    execsql($sql_a);
                }

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'NAN - Visita {$num_visita}'";
                execsql($sql_a);
                break;

            case 'Finalizado em Alteração':
                if ($aba == 1) {
                    $sql = '';
                    $sql .= ' select a.nan_ap_sit_at';
                    $sql .= ' from grc_atendimento a';
                    $sql .= ' where a.idt = ' . null($vetID['grc_atendimento']);
                    $rs = execsql($sql);

                    if ($rs->data[0][0] == 'S') {
                        $status_nan = 'DE';
                    } else {
                        $status_nan = 'CD';
                    }
                } else {
                    $status_nan = 'DI';
                }

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_avaliacao';
                $sql .= ' where idt_atendimento = ' . null($vlID);
                $rstt = execsql($sql);

                $_GET['tipo'] = 'ConfirmaReabrirAvaliacao';
                $_POST['idt_avaliacao'] = $rstt->data[0][0];
                require_once 'ajax2.php';

                $href = "conteudo{$cont_arq}.php?prefixo=inc&menu={$menu}&session_volta=" . $_GET['session_volta'] . "&idt_atendimento_agenda=" . $_GET['idt_atendimento_agenda'] . "&idt_atendimento=" . $_GET['idt_atendimento'] . "&id=" . $_GET['idt_atendimento_agenda'] . "&pesquisa=" . $_GET['pesquisa'] . "&aba={$aba}";
                $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
                break;
        }

        if ($status_nan != '') {
            $sql = '';
            $sql .= ' select idt_grupo_atendimento';
            $sql .= ' from grc_atendimento';
            $sql .= ' where idt = ' . null($vetID['grc_atendimento']);
            $rst = execsql($sql);
            $rowt = $rst->data[0];

            $sql = 'update grc_nan_grupo_atendimento set status_' . $num_visita . ' = ' . aspa($status_nan);
            $sql .= ' where idt = ' . null($rowt['idt_grupo_atendimento']);
            execsql($sql);
        }
        break;

    case 'grc_nan_visita_1_ap':
    case 'grc_nan_visita_2_ap':
        if ($menu == 'grc_nan_visita_2_ap') {
            $num_visita = 2;
        } else {
            $num_visita = 1;
        }

        $sql = '';
        $sql .= ' select idt_grupo_atendimento';
        $sql .= ' from grc_atendimento';
        $sql .= ' where idt = ' . null($vlID);
        $rst = execsql($sql);
        $rowt = $rst->data[0];

        $status_nan = '';

        switch ($_POST['situacao']) {
            case 'Validar Visita':
                $status_nan = 'AP';
                sincronizaSIAChist($vlID);

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " solucao = " . aspa($_POST['solucao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'NAN - Visita {$num_visita}'";
                execsql($sql_a);
                break;

            case 'Devolver para Ajustes':
                $status_nan = 'DE';

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " solucao = " . aspa($_POST['solucao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_atendimento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'NAN - Visita {$num_visita}'";
                execsql($sql_a);

                //Pendencia
                $sql = '';
                $sql .= ' select razao_social';
                $sql .= ' from grc_atendimento_organizacao';
                $sql .= ' where idt = ' . null($_POST['idt_cliente']);
                $rst = execsql($sql);
                $txt = $rst->data[0][0];

                $idt_atendimento = null($vlID);
                $idt_usuario = null($_SESSION[CS]['g_id_usuario']);
                $data = aspa(trata_data(date('d/m/Y H:i:s')));
                $data_solucao = aspa(trata_data(date('d/m/Y')));
                $assunto = aspa($txt);
                $observacao = aspa($_POST['solucao']);
                $protocolo = aspa($_POST['protocolo']);
                $status = aspa('Devolver para Ajustes');
                $tipo = aspa('NAN - Visita ' . $num_visita);
                $recorrencia = aspa('1');
                $idt_gestor_evento = null($_POST['idt_consultor']);
                $idt_ponto_atendimento = null($_POST['idt_ponto_atendimento']);

                $sql_i = ' insert into grc_atendimento_pendencia ';
                $sql_i .= ' (  ';
                $sql_i .= " idt_atendimento, ";
                $sql_i .= " protocolo, ";
                $sql_i .= " idt_ponto_atendimento, ";
                $sql_i .= " idt_gestor_local, ";
                $sql_i .= " recorrencia, ";
                $sql_i .= " idt_responsavel_solucao, ";
                $sql_i .= " status, ";
                $sql_i .= " tipo, ";
                $sql_i .= " idt_usuario, ";
                $sql_i .= " data, ";
                $sql_i .= " data_solucao, ";
                $sql_i .= " assunto, ";
                $sql_i .= " observacao ";
                $sql_i .= '  ) values ( ';
                $sql_i .= " $idt_atendimento, ";
                $sql_i .= " $protocolo, ";
                $sql_i .= " $idt_ponto_atendimento, ";
                $sql_i .= " $idt_gestor_evento, ";
                $sql_i .= " $recorrencia, ";
                $sql_i .= " $idt_gestor_evento, ";
                $sql_i .= " $status, ";
                $sql_i .= " $tipo, ";
                $sql_i .= " $idt_usuario, ";
                $sql_i .= " $data, ";
                $sql_i .= " $data_solucao, ";
                $sql_i .= " $assunto, ";
                $sql_i .= " $observacao ";
                $sql_i .= ') ';
                execsql($sql_i);
                copiaAtendimentoPendenciaTransResp(lastInsertId());
                break;
        }

        if ($status_nan != '') {
            $sql = 'update grc_nan_grupo_atendimento set status_' . $num_visita . ' = ' . aspa($status_nan);
            $sql .= ' where idt = ' . null($rowt['idt_grupo_atendimento']);
            execsql($sql);
        }
        break;

    case 'grc_atendimento_organizacao_cnae':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['cnae']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_organizacao_cnae';
                $sql .= ' where idt_atendimento_organizacao = ' . null($_POST['idt_atendimento_organizacao']);
                $sql .= ' and cnae = ' . aspa($dados['subclasse']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_organizacao_cnae (idt_atendimento_organizacao, cnae) values (';
                    $sql .= null($_POST['idt_atendimento_organizacao']) . ', ' . aspa($dados['subclasse']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_pessoa_produto_interesse':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_pessoa_produto_interesse';
                $sql .= ' where idt_atendimento_pessoa = ' . null($_POST['idt_atendimento_pessoa']);
                $sql .= ' and idt_produto = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_pessoa_produto_interesse (idt_atendimento_pessoa, idt_produto, ';
                    $sql .= 'observacao, data_registro, idt_responsavel) values (';
                    $sql .= null($_POST['idt_atendimento_pessoa']) . ', ' . aspa($dados['idt']) . ', ' . aspa($_POST['observacao']) . ', ';
                    $sql .= aspa(trata_data($_POST['data_registro'])) . ', ' . aspa($_POST['idt_responsavel']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_tema_tratado':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_sub_tema']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_tema';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= ' and idt_sub_tema = ' . aspa($dados['idt']);
                $sql .= ' and tipo_tratamento = ' . aspa($_POST['tipo_tratamento']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_tema (idt_atendimento, idt_tema, idt_sub_tema, tipo_tratamento) values (';
                    $sql .= null($_POST['idt_atendimento']) . ', ' . null($dados['idt_tema']) . ', ' . null($dados['idt']) . ', ' . aspa($_POST['tipo_tratamento']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_tema':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_tema']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_tema';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= ' and idt_tema = ' . aspa($dados['idt']);
                $sql .= ' and tipo_tratamento = ' . aspa($_POST['tipo_tratamento']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_tema (idt_atendimento, idt_tema, tipo_tratamento) values (';
                    $sql .= null($_POST['idt_atendimento']) . ', ' . null($dados['idt']) . ', ' . aspa($_POST['tipo_tratamento']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_produto':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto']]['sel_final'];

            foreach ($vetSel as $idx => $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_produto';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= ' and idt_produto = ' . null($dados['idt']);
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    $sql = 'insert into grc_atendimento_produto (idt_atendimento, idt_produto) values (';
                    $sql .= null($_POST['idt_atendimento']) . ', ' . null($dados['idt']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_pendencia':
    case 'grc_atendimento_pendencia_m':
        if ($_POST['temporario'] == 'S' && $acao != 'inc') {
            $sql_a = ' update grc_atendimento_pendencia set ';
            $sql_a .= ' temporario = ' . aspa('N') . ',  ';
            $sql_a .= ' idt_pendencia_raiz = ' . null($vlID) . '  ';
            $sql_a .= ' where idt = ' . null($vlID);
            execsql($sql_a);

            $idt_atendimento = $_POST['idt_atendimento'];
            GeraComplementoPendencia($vlID, $idt_atendimento);
            copiaAtendimentoPendenciaTransResp($vlID);

            if ($_POST['enviar_email'] == 'S') {
                $vetGRC_parametros = GRC_parametros();
                $assunto = $vetGRC_parametros['grc_atendimento_pendencia_01'];
                $mensagem = $vetGRC_parametros['grc_atendimento_pendencia_02'];

                $protocolo = date('dmYHis');

                $assunto = str_replace('#pendencia_protocolo', $_POST['protocolo'], $assunto);
                $assunto = str_replace('#assunto', $_POST['assunto'], $assunto);

                $mensagem = str_replace('#protocolo', $protocolo, $mensagem);
                $mensagem = str_replace('#data', date('d/m/Y H:i:s'), $mensagem);

                $sql = '';
                $sql .= ' select nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($_POST['idt_usuario']);
                $rs = execsql($sql);
                $mensagem = str_replace('#consultor', $rs->data[0][0], $mensagem);

                $sql = '';
                $sql .= ' select descricao';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where idt = ' . null($_POST['idt_ponto_atendimento']);
                $rs = execsql($sql);
                $mensagem = str_replace('#ponto_atendimento', $rs->data[0][0], $mensagem);

                $mensagem = str_replace('#pendencia_protocolo', $_POST['protocolo'], $mensagem);
                $mensagem = str_replace('#cliente', $_POST['nome_cliente'], $mensagem);
                $mensagem = str_replace('#empreendimento', $_POST['nome_empreendimento'], $mensagem);
                $mensagem = str_replace('#assunto', $_POST['assunto'], $mensagem);
                $mensagem = str_replace('#detalhamento', $_POST['observacao'], $mensagem);
                $mensagem = str_replace('#reg_data', $_POST['data'], $mensagem);
                $mensagem = str_replace('#dasolucao_data', $_POST['data_solucao'], $mensagem);

                $sql = '';
                $sql .= ' select email, nome_completo';
                $sql .= ' from plu_usuario';
                $sql .= ' where id_usuario = ' . null($_POST['idt_gestor_local']);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $txt = $mensagem;
                $txt = str_replace('#responsavel', $row['nome_completo'], $txt);

                enviarEmail(db_pir_grc, $assunto, $txt, $row['email'], $row['nome_completo']);
            }
        } else {
            $sql = '';
            $sql .= ' select idt_atendimento_pendencia_trans';
            $sql .= ' from grc_atendimento_pendencia';
            $sql .= ' where idt = ' . null($vlID);
            $rs = execsql($sql);
            $idt_atendimento_pendencia_trans = $rs->data[0][0];

            if ($idt_atendimento_pendencia_trans == '') {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= ' ativo = ' . aspa($_POST['ativo']);
                $sql_a .= ' where idt_atendimento_pendencia_trans = ' . null($vlID);
                execsql($sql_a);
            } else {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= ' ativo = ' . aspa($_POST['ativo']);
                $sql_a .= ' where idt = ' . null($idt_atendimento_pendencia_trans);
                $sql_a .= ' or idt_atendimento_pendencia_trans = ' . null($idt_atendimento_pendencia_trans);
                execsql($sql_a);
            }
        }

        //p($_POST);
        //echo " acao = $acao tipo = $tipo ";
        if ($acao == 'inc') {
            //die();
        }

        if ($acao == 'alt') {

            if ($menu == 'grc_atendimento_pendencia') {
                $idt_pendencia = $vlID;
                $idt_atendimento = $_POST['idt_atendimento'];
                $descricao = "";
                //$descricao .= $_POST['protocolo'] . " - " . $_POST['assunto'];
                $descricao .= $_POST['assunto'];
                $vetRetorno = Array();
                $vetRetorno['complemento_acao'] = "Protocolo: {$_POST['protocolo']}";
                $vetRetorno['idt_pendencia'] = $idt_pendencia;
                $vetRetorno['idt_acao'] = 4;
                $vetRetorno['descricao'] = $descricao;
                // Gera no Resumo a Pendência		
                AtendimentoResumo($idt_atendimento, $vetRetorno);
            }
            //p($_POST);
            //die();

            $opcao_tramitacao = $_POST['opcao_tramitacao'];

            if ($opcao_tramitacao == 'E' && $_POST['idt_status_tramitacao'] == '') {
                $_POST['idt_status_tramitacao'] = 2;
            }
            $idt_status_tramitacao = $_POST['idt_status_tramitacao'];
            //	$status=" i = {$idt_status_tramitacao} o = {$opcao_tramitacao}";
            //	echo $status;

            $status = "";
            if ($idt_status_tramitacao == 1) {
                $status = "ABERTO";
            }

            if ($idt_status_tramitacao == 2) {
                $status = "ENCAMINHADA";
            }

            if ($idt_status_tramitacao == 3) {
                $status = "FINALIZADA - ATENDIDA";
            }

            if ($idt_status_tramitacao == 4) {
                $status = "FINALIZADA - CANCELADA";
            }
            if ($status != "") {

                $sql = '';
                $sql .= ' select idt_pendencia_raiz ';
                $sql .= ' from grc_atendimento_pendencia';
                $sql .= ' where idt = ' . null($vlID);
                $rs = execsql($sql);
                $rowtw = $rs->data[0];
                $idt_pendencia_raiz = $rowtw['idt_pendencia_raiz'];

                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= ' status = ' . aspa($status);
                $sql_a .= ' where idt = ' . null($idt_pendencia_raiz);
                execsql($sql_a);
                //p($sql_a);
                //p($_POST);
                //die();
            }


            // Gera para destinatários da pendência
            if ($idt_status_tramitacao > 1) {
                $idt_pendencia = $_POST['idt_pendencia'];
                $observacao = $_POST['observacao'];
                $opcao_tramitacao = $_POST['opcao_tramitacao'];
                $idt_status_tramitacao = $_POST['idt_status_tramitacao'];
                $vetRetorno = Array();
                $vetRetorno['acao'] = $acao;
                $vetRetorno['idt_pendencia'] = $vlID;
                $vetRetorno['observacao'] = $observacao;
                $vetRetorno['opcao_tramitacao'] = $opcao_tramitacao;
                $vetRetorno['idt_status_tramitacao'] = $idt_status_tramitacao;
                // Gera para destinatários da pendência
                $ret = PendenciaRedeGerarFilhos($vetRetorno);
                //die();
            }
        }
        break;

    case 'grc_atendimento_pendencia_destinatario':
        //	
        $idt_pendencia = $_POST['idt_pendencia'];
        $idt_destinatario = $_POST['idt_destinatario'];
        $observacao = $_POST['observacao'];
        $sql = '';
        $sql .= ' select idt_unidade_lotacao, idt_unidade_regional ';
        $sql .= ' from plu_usuario ';
        $sql .= ' where id_usuario = ' . null($idt_destinatario);
        $rst = execsql($sql);
        ForEach ($rst->data as $row) {
            $idt_unidade_lotacao = $row['idt_unidade_lotacao'];
            $idt_unidade_regional = $row['idt_unidade_regional'];
            $sql_a = ' update grc_atendimento_pendencia_destinatario set ';
            $sql_a .= " idt_unidade = " . null($idt_unidade_lotacao) . ", ";
            $sql_a .= " idt_ponto_atendimento = " . null($idt_unidade_regional) . " ";
            $sql_a .= ' where idt  = ' . null($vlID);
            execsql($sql_a);
        }
        //
        break;

    case 'grc_evento_tema':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_sub_tema']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_tema';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= ' and idt_sub_tema = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_evento_tema (idt_evento, idt_tema, idt_sub_tema) values (';
                    $sql .= null($_POST['idt_evento']) . ', ' . null($dados['idt_tema']) . ', ' . null($dados['idt']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_evento_cnae':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['cnae']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_cnae';
                $sql .= ' where idt_evento = ' . null($_POST['idt_evento']);
                $sql .= ' and cnae = ' . aspa($dados['subclasse']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_evento_cnae (idt_evento, cnae) values (';
                    $sql .= null($_POST['idt_evento']) . ', ' . aspa($dados['subclasse']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_evento_agenda':
    case 'grc_evento_agenda_mat':
        if ($_POST['id'] == 0) {
            $vetTmp = Array();

            $vet = DatetoArray($_POST['dt_ini']);
            $intIni = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

            $vet = DatetoArray($_POST['dt_fim']);
            $intFim = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

            $nextDia = 86400; //Qtd de segundos em 24h

            for ($i = $intIni; $i <= $intFim; $i = $i + $nextDia) {
                $dia = date('d/m/Y', $i);
                $dt_ini = $dia . ' ' . $_POST['hora_inicial'];
                $dt_fim = $dia . ' ' . $_POST['hora_final'];
                $tot_hora = diffDate($dt_ini, $dt_fim, 'H');

                $vetReturn = validaDispLocalEvento($vlID, 0, $_POST['idt_local'], $dt_ini, $dt_fim);

                if (count($vetReturn) == 0) {
                    $alocacao_disponivel = 'S';
                    $alocacao_msg = '';
                } else {
                    $alocacao_disponivel = 'N';
                    $alocacao_msg = implode('<br />', $vetReturn);
                }

                $sql = '';
                $sql .= ' insert into grc_evento_agenda (idt_evento, data_inicial, hora_inicial, dt_ini,';
                $sql .= ' data_final, hora_final, dt_fim, carga_horaria, idt_local, idt_cidade, observacao,';
                $sql .= ' atividade, valor_hora, idt_tema, idt_subtema, competencia,';
                $sql .= ' alocacao_disponivel, alocacao_msg, idt_atendimento, idt_evento_atividade';
                $sql .= ' ) values (';
                $sql .= null($_POST['idt_evento']) . ', ' . aspa(trata_data($dia)) . ', ' . aspa($_POST['hora_inicial']) . ', ' . aspa(trata_data($dt_ini, true)) . ', ';
                $sql .= aspa(trata_data($dia)) . ', ' . aspa($_POST['hora_final']) . ', ' . aspa(trata_data($dt_fim, true)) . ', ' . null($tot_hora) . ', ';
                $sql .= null($_POST['idt_local']) . ', ' . null($_POST['idt_cidade']) . ', ' . aspa($_POST['observacao']) . ', ';
                $sql .= aspa($_POST['atividade']) . ', ' . null(desformat_decimal($_POST['valor_hora'])) . ', ' . null($_POST['idt_tema']) . ', ' . null($_POST['idt_subtema']) . ', ' . aspa(trata_data($dia)) . ', ';
                $sql .= aspa($alocacao_disponivel) . ', ' . aspa($alocacao_msg) . ', ' . null($_POST['idt_atendimento']) . ', ' . null($_POST['idt_evento_atividade']) . ')';
                execsql($sql);
            }
        }

        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
            case $bt_alterar_lbl:
                if ($_POST['idt_evento_atividade'] != '') {
                    $sql = '';
                    $sql .= ' update grc_evento_agenda set atividade = ' . aspa($_POST['atividade']);
                    $sql .= ' , idt_tema = ' . null($_POST['idt_tema']);
                    $sql .= ' , idt_subtema = ' . null($_POST['idt_subtema']);
                    $sql .= ' where idt_evento_atividade = ' . null($_POST['idt_evento_atividade']);
                    execsql($sql);
                }
                break;

            case $bt_excluir_lbl:
                if ($_POST['idt_evento_atividade'] != '') {
                    $sql = '';
                    $sql .= ' select idt';
                    $sql .= ' from grc_evento_agenda';
                    $sql .= ' where idt_evento_atividade = ' . null($_POST['idt_evento_atividade']);
                    $rsDel = execsql($sql);

                    if ($rsDel->rows == 0) {
                        $sql = 'delete from grc_evento_atividade';
                        $sql .= ' where idt = ' . null($_POST['idt_evento_atividade']);
                        execsql($sql);
                    }
                }
                break;
        }

        if ($_GET['veio'] == 'SG') {
            atualizaPagEventoSG($_POST['idt_evento']);
        }

        $sql = '';
        $sql .= ' select min(ea.data_inicial) as dt_ini, max(ea.data_final) as dt_fim, min(ea.hora_inicial) as hr_ini, max(ea.hora_final) as hr_fim,';
        $sql .= ' sum(ea.carga_horaria) as carga_horaria, sum(ea.valor_hora * ea.carga_horaria) as custo, count(distinct ea.data_inicial) as qtd_dias_reservados';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($_POST['idt_evento']);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rsa = execsql($sql);
        $row_sum = $rsa->data[0];

        $sql = '';
        $sql .= ' select ei.custo_total';
        $sql .= ' from grc_evento_insumo ei';
        $sql .= ' where ei.idt_evento = ' . null($_POST['idt_evento']);
        $sql .= " and ei.codigo = '71001'";
        $rsa = execsql($sql);

        if ($rsa->rows > 0) {
            $row_sum['custo'] = $rsa->data[0][0];
        }

        $dt_ini = $row_sum['dt_ini'];
        $dt_fim = $row_sum['dt_fim'];
        $hr_ini = $row_sum['hr_ini'];
        $hr_fim = $row_sum['hr_fim'];

        $sql = '';
        $sql .= ' select ea.idt_cidade, ea.idt_local, c.desccid as cidade, l.descricao as local,';
        $sql .= ' l.cep, l.logradouro, l.logradouro_numero, l.logradouro_complemento,';
        $sql .= ' end_b.descbairro as logradouro_bairro, end_c.desccid as logradouro_municipio, end_e.abrevest as logradouro_estado, end_p.descpais as logradouro_pais';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " inner join " . db_pir_siac . "cidade c on c.codcid = ea.idt_cidade";
        $sql .= " inner join grc_evento_local_pa l on l.idt = ea.idt_local";
        $sql .= ' left outer join ' . db_pir_siac . 'bairro end_b on end_b.codbairro = l.logradouro_codbairro';
        $sql .= ' left outer join ' . db_pir_siac . 'cidade end_c on end_c.codcid = l.logradouro_codcid';
        $sql .= ' left outer join ' . db_pir_siac . 'estado end_e on end_e.codest = l.logradouro_codest';
        $sql .= ' left outer join ' . db_pir_siac . 'pais end_p on end_p.codpais = l.logradouro_codpais';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= ' where ea.idt_evento = ' . null($_POST['idt_evento']);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $sql .= ' order by ea.dt_ini limit 1';
        $rsa = execsql($sql);
        $rowa = $rsa->data[0];

        $sql = '';
        $sql .= ' select e.idt_instrumento, e.composto, e.idt_evento_pai, p.tipo_calculo, e.assento_marcado';
        $sql .= ' from grc_evento e';
        $sql .= ' inner join grc_produto p on p.idt = e.idt_produto';
        $sql .= ' where e.idt = ' . null($_POST['idt_evento']);
        $rsa = execsql($sql);
        $rowe = $rsa->data[0];

        if ($rowe['assento_marcado'] == 'S') {
            geraMapaAssento($_POST['idt_evento'], $rowe['assento_marcado']);
        }

        if ($rowe['composto'] == 'S') {
            $sql = '';
            $sql .= ' select sum(carga_horaria_total) as tot';
            $sql .= ' from grc_evento';
            $sql .= ' where idt_evento_pai = ' . null($_POST['idt_evento']);
            $rsa = execsql($sql);
            $carga_horaria_total = $rsa->data[0][0];
        } else if ($rowe['idt_evento_pai'] != '' && $rowe['tipo_calculo'] != '') {
            $carga_horaria_total = false;
        } else {
            $carga_horaria_total = $row_sum['carga_horaria'];
        }

        $sql = '';
        $sql .= ' update grc_evento set';

        if ($rowe['idt_instrumento'] != 2) {
            $sql .= ' idt_cidade = ' . null($rowa['idt_cidade']) . ',';
            $sql .= ' idt_local = ' . null($rowa['idt_local']) . ',';
            $sql .= ' cep = ' . aspa($rowa['cep']) . ',';
            $sql .= ' logradouro = ' . aspa($rowa['logradouro']) . ',';
            $sql .= ' logradouro_numero = ' . aspa($rowa['logradouro_numero']) . ',';
            $sql .= ' logradouro_complemento = ' . aspa($rowa['logradouro_complemento']) . ',';
            $sql .= ' logradouro_bairro = ' . aspa($rowa['logradouro_bairro']) . ',';
            $sql .= ' logradouro_municipio = ' . aspa($rowa['logradouro_municipio']) . ',';
            $sql .= ' logradouro_estado = ' . aspa($rowa['logradouro_estado']) . ',';
            $sql .= ' logradouro_pais = ' . aspa($rowa['logradouro_pais']) . ',';
        }

        $sql .= ' dt_previsao_inicial = ' . aspa($dt_ini) . ',';
        $sql .= ' dt_previsao_fim = ' . aspa($dt_fim) . ',';
        $sql .= ' hora_inicio = ' . aspa($hr_ini) . ',';
        $sql .= ' hora_fim = ' . aspa($hr_fim) . ',';

        if ($carga_horaria_total !== false) {
            $sql .= ' carga_horaria_total = ' . null($carga_horaria_total) . ',';
        }

        $sql .= ' tot_hora_consultoria = ' . null($row_sum['carga_horaria']) . ',';
        $sql .= ' custo_tot_consultoria = ' . null($row_sum['custo']);
        $sql .= ' where idt = ' . null($_POST['idt_evento']);
        execsql($sql);

        $vet = Array();
        $vet['dt_ini'] = rawurlencode(trata_data($dt_ini));
        $vet['dt_fim'] = rawurlencode(trata_data($dt_fim));
        $vet['hr_ini'] = rawurlencode($hr_ini);
        $vet['hr_fim'] = rawurlencode($hr_fim);
        $vet['idt_cidade'] = rawurlencode($rowa['idt_cidade']);
        $vet['idt_cidade_tf'] = rawurlencode($rowa['cidade']);
        $vet['idt_local'] = rawurlencode($rowa['idt_local']);
        $vet['idt_local_tf'] = rawurlencode($rowa['local']);

        $vet['cep'] = rawurlencode($rowa['cep']);
        $vet['logradouro'] = rawurlencode($rowa['logradouro']);
        $vet['logradouro_numero'] = rawurlencode($rowa['logradouro_numero']);
        $vet['logradouro_complemento'] = rawurlencode($rowa['logradouro_complemento']);
        $vet['logradouro_bairro'] = rawurlencode($rowa['logradouro_bairro']);
        $vet['logradouro_municipio'] = rawurlencode($rowa['logradouro_municipio']);
        $vet['logradouro_estado'] = rawurlencode($rowa['logradouro_estado']);
        $vet['logradouro_pais'] = rawurlencode($rowa['logradouro_pais']);

        $vet['tot_hora_consultoria'] = rawurlencode(format_decimal($row_sum['carga_horaria']));
        $vet['custo_tot_consultoria'] = rawurlencode(format_decimal($row_sum['custo']));
        $vet['qtd_dias_reservados'] = rawurlencode($row_sum['qtd_dias_reservados']);

        $sql = '';
        $sql .= ' select count(ea.idt) as tot';
        $sql .= ' from grc_evento_agenda ea';
        $sql .= " left outer join grc_evento_participante ep on ep.idt_atendimento = ea.idt_atendimento";
        $sql .= " where ea.alocacao_disponivel = 'N'";
        $sql .= ' and ea.idt_evento = ' . null($_POST['idt_evento']);
        $sql .= whereEventoParticipante();
        $sql .= " and (ep.ativo is null or ep.ativo = 'S')";
        $rst = execsql($sql);
        $vet['grc_evento_agenda_erro'] = rawurlencode($rst->data[0][0]);

        $returnVal = json_encode($vet);

        CalcularInsumoEvento($_POST['idt_evento']);

        if ($rowe['idt_evento_pai'] != '') {
            SincronizaHoraMesEventoComposto($_POST['idt_evento']);
            EventoCompostoSincroniza($rowe['idt_evento_pai'], true);
        }
        ?>
        <script type="text/javascript">
            returnVal = <?php echo $returnVal; ?>;
        </script>
        <?php
        break;

    case 'grc_evento_local_pa':
        if ($_GET['showPopWin'] == 'S') {
            ?>
            <script type="text/javascript">
                returnVal = '<?php echo $vlID; ?>';
            </script>
            <?php
        }
        break;

    case 'grc_evento_local_pa_mapa_assento':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                $sql = '';
                $sql .= ' select codigo';
                $sql .= ' from grc_evento_local_pa_mapa_assento';
                $sql .= ' where idt_local_pa_mapa = ' . null($_POST['idt_local_pa_mapa']);
                $rs = execsql($sql);

                $vetCod = Array();

                foreach ($rs->data as $row) {
                    $vetCod[$row['codigo']] = $row['codigo'];
                }

                for ($lin = 1; $lin <= $_POST['linha']; $lin++) {
                    for ($col = 1; $col <= $_POST['coluna']; $col++) {
                        $codigo = getLetterFromNumber($lin) . $col;

                        if (!in_array($codigo, $vetCod)) {
                            $sql = 'insert into grc_evento_local_pa_mapa_assento (idt_local_pa_mapa, codigo, descricao, linha, coluna, idt_tipo_assento) values (';
                            $sql .= null($_POST['idt_local_pa_mapa']) . ', ' . aspa($codigo) . ', ' . aspa($codigo) . ', ' . null($lin) . ', ';
                            $sql .= null($col) . ', ' . null($_POST['idt_tipo_assento']) . ')';
                            execsql($sql);
                        }
                    }
                }
                break;
        }
        break;

    case 'grc_evento_mapa_assento':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                $sql = '';
                $sql .= ' select codigo';
                $sql .= ' from grc_evento_mapa_assento';
                $sql .= ' where idt_evento_mapa = ' . null($_POST['idt_evento_mapa']);
                $rs = execsql($sql);

                $vetCod = Array();

                foreach ($rs->data as $row) {
                    $vetCod[$row['codigo']] = $row['codigo'];
                }

                for ($lin = 1; $lin <= $_POST['linha']; $lin++) {
                    for ($col = 1; $col <= $_POST['coluna']; $col++) {
                        $codigo = getLetterFromNumber($lin) . $col;

                        if (!in_array($codigo, $vetCod)) {
                            $sql = 'insert into grc_evento_mapa_assento (idt_evento_mapa, codigo, descricao, linha, coluna, idt_tipo_assento) values (';
                            $sql .= null($_POST['idt_evento_mapa']) . ', ' . aspa($codigo) . ', ' . aspa($codigo) . ', ' . null($lin) . ', ';
                            $sql .= null($col) . ', ' . null($_POST['idt_tipo_assento']) . ')';
                            execsql($sql);
                        }
                    }
                }
                break;
        }
        break;

    case 'grc_evento_local_pa_agenda':
        if ($_POST['idorg'] == -1) {
            $vetTmp = Array();

            $vet = DatetoArray($_POST['dt_ini']);
            $intIni = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

            $vet = DatetoArray($_POST['dt_fim']);
            $intFim = mktime($vet['hora'], $vet['min'], $vet['seg'], $vet['mes'], $vet['dia'], $vet['ano']);

            $nextDia = 86400; //Qtd de segundos em 24h

            for ($i = $intIni; $i <= $intFim; $i = $i + $nextDia) {
                $dia = date('d/m/Y', $i);
                $dt_ini = $dia . ' ' . $_POST['hora_inicial'];
                $dt_fim = $dia . ' ' . $_POST['hora_final'];

                $vetReturn = validaDispLocalEvento(0, $vlID, $_POST['idt_local_pa'], $dt_ini, $dt_fim);

                if (count($vetReturn) == 0) {
                    $alocacao_disponivel = 'S';
                    $alocacao_msg = '';
                } else {
                    $alocacao_disponivel = 'N';
                    $alocacao_msg = implode('<br />', $vetReturn);
                }

                $sql = '';
                $sql .= ' insert into grc_evento_local_pa_agenda (idt_local_pa, data_inicial, hora_inicial, dt_ini,';
                $sql .= ' data_final, hora_final, dt_fim, status, detalhe, alocacao_disponivel, alocacao_msg) values (';
                $sql .= null($_POST['idt_local_pa']) . ', ' . aspa(trata_data($dia)) . ', ' . aspa($_POST['hora_inicial']) . ', ' . aspa(trata_data($dt_ini, true)) . ', ';
                $sql .= aspa(trata_data($dia)) . ', ' . aspa($_POST['hora_final']) . ', ' . aspa(trata_data($dt_fim, true)) . ', ';
                $sql .= aspa($_POST['status']) . ', ' . aspa($_POST['detalhe']) . ', ';
                $sql .= aspa($alocacao_disponivel) . ', ' . aspa($alocacao_msg) . ')';
                execsql($sql);
            }
        }
        break;

    case 'grc_produto_profissional':
        $idt_produto = $_POST['idt_produto'];

        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                $idt_produto_profissional = $vlID;
                $idt_profissional = $_POST['idt_profissional'];

                SincronizaProfissional($idt_produto_profissional, $idt_produto, $idt_profissional);
                break;
        }
        CalcularInsumoProduto($idt_produto);
//exit();
        break;

    case 'grc_entidade_organizacao':
        switch ($_POST['btnAcao']) {
            case $bt_alterar_lbl:
                if ($_POST['novo_registro'] == 'S') {
                    $sql = "update grc_entidade_organizacao set novo_registro = 'N' where idt = " . null($vlID);
                    execsql($sql);
                }
                break;
        }

        $sql = 'delete from grc_entidade_organizacao_cnae';
        $sql .= ' where idt_entidade_organizacao = ' . null($vlID);
        $sql .= ' and cnae = ' . aspa($_POST['idt_cnae_principal']);
        execsql($sql);

        $sql = '';
        $sql .= ' select idt_representa';
        $sql .= ' from grc_entidade_organizacao';
        $sql .= ' where idt = ' . null($vlID);
        $rs = execsql($sql);
        $idt_representa = $rs->data[0][0];

        if ($idt_representa != '') {
            $codigo_siacweb = sincronizaSIACcad($idt_representa, 0, 'S');

            $sql = 'update grc_atendimento_pessoa ';
            $sql .= " set codigo_siacweb = " . aspa($codigo_siacweb);
            $sql .= ' where idt = ' . null($idt_representa);
            execsql($sql);
        }

        sincronizaEntidadeOrganizacaoGEC($vlID);
        break;

    case 'grc_entidade_organizacao_cnae':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['cnae']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_entidade_organizacao_cnae';
                $sql .= ' where idt_entidade_organizacao = ' . null($_POST['idt_entidade_organizacao']);
                $sql .= ' and cnae = ' . aspa($dados['subclasse']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_entidade_organizacao_cnae (idt_entidade_organizacao, cnae) values (';
                    $sql .= null($_POST['idt_entidade_organizacao']) . ', ' . aspa($dados['subclasse']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_entidade_pessoa':
        sincronizaEntidadePessoaGEC($vlID);
        break;

    case 'grc_entidade_pessoa_produto_interesse':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_entidade_pessoa_produto_interesse';
                $sql .= ' where idt_entidade_pessoa = ' . null($_POST['idt_entidade_pessoa']);
                $sql .= ' and idt_produto = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_entidade_pessoa_produto_interesse (idt_entidade_pessoa, idt_produto, ';
                    $sql .= 'observacao, data_registro, idt_responsavel) values (';
                    $sql .= null($_POST['idt_entidade_pessoa']) . ', ' . aspa($dados['idt']) . ', ' . aspa($_POST['observacao']) . ', ';
                    $sql .= aspa(trata_data($_POST['data_registro'])) . ', ' . aspa($_POST['idt_responsavel']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'plu_parametros_lista':
        $tabela = $_POST['codigo'];
        $objEstrutura = new PIR_entidades($tabela, 'A');

//$vetEstrutura_FD = $objEstrutura -> estrutura_cd('FD');
//exit();
        break;

    case 'grc_nan_gestao_contrato':

        $sql = '';
        $sql .= ' select valor_visita1, valor_visita2';
        $sql .= ' from grc_nan_parametros_projetos';
//$sql .= ' where idt = '.null($vlID);
        $sql .= ' where idt = 1 ';
        $rs = execsql($sql);
        $valor_visita1 = $rs->data[0][0];
        $valor_visita2 = $rs->data[0][1];
        $nan_meta_atendimentos_v1 = $_POST['nan_meta_atendimentos_v1'];
        $nan_meta_atendimentos_aditivo_v1 = $_POST['nan_meta_atendimentos_aditivo_v1'];

        $nan_meta_atendimentos_v2 = $_POST['nan_meta_atendimentos_v2'];
        $nan_meta_atendimentos_aditivo_v2 = $_POST['nan_meta_atendimentos_aditivo_v2'];

        if ($nan_meta_atendimentos_v1 == '') {
            $nan_meta_atendimentos_v1 = 0;
        }
        if ($nan_meta_atendimentos_aditivo_v1 == '') {
            $$nan_meta_atendimentos_aditivo_v1 = 0;
        }
        if ($nan_meta_atendimentos_v2 == '') {
            $nan_meta_atendimentos_v2 = 0;
        }
        if ($nan_meta_atendimentos_aditivo_v2 == '') {
            $$nan_meta_atendimentos_aditivo_v2 = 0;
        }

        $valor_v1 = ($nan_meta_atendimentos_v1 + $nan_meta_atendimentos_aditivo_v1) * $valor_visita1;
        $valor_v2 = ($nan_meta_atendimentos_v2 + $nan_meta_atendimentos_aditivo_v2) * $valor_visita2;

        $meta_at = ($nan_meta_atendimentos_v1 + $nan_meta_atendimentos_v2);
        $meta_ad = ($nan_meta_atendimentos_aditivo_v1 + $nan_meta_atendimentos_aditivo_v2);

        $valor_contrato = $valor_v1 + $valor_v2;
        $sql = 'update ' . db_pir_gec . 'gec_contratar_credenciado ';
        $sql .= " set valor_contrato = " . null($valor_contrato) . ", ";
        $sql .= "  nan_meta_atendimentos = " . null($meta_at) . ", ";
        $sql .= "  nan_meta_atendimentos_aditivo = " . null($meta_ad) . " ";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);

        break;

    case 'grc_nan_ordem_pagamento':
        $acao_nan = $_POST['acao_nan'];

        $sql = 'update grc_nan_ordem_pagamento ';
        $sql .= " set acao_nan = null";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);

        if ($_POST['idt_pfo_af_processo'] == '') {
            // agregar visitas
            if ($acao_nan == 'AG') {
                $sql = '';
                $sql .= ' select gec_cc.nan_idt_unidade_regional, pu_usu.id_usuario ';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado gec_cc ';
                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao ';
                $sql .= ' inner join plu_usuario pu_usu on pu_usu.login = gec_e.codigo ';
                $sql .= ' where gec_cc.idt = ' . null($_POST['idt_contrato']);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $data_inicio = $_POST['data_inicio'];
                $data_fim = $_POST['data_fim'];

                $data_me = trata_data($data_inicio);
                $data_ma = trata_data($data_fim);

                $sql = '';
                $sql .= ' select grc_a.idt as grc_a_idt, grc_nga.idt_organizacao ';
                $sql .= ' from grc_atendimento grc_a ';
                $sql .= ' inner join grc_nan_grupo_atendimento grc_nga on grc_nga.idt = grc_a.idt_grupo_atendimento ';
                $sql .= ' where grc_a.idt_nan_empresa = ' . null($row['id_usuario']);
                $sql .= ' and grc_a.idt_unidade = ' . null($row['nan_idt_unidade_regional']);
                $sql .= ' and (';
                $sql .= '    grc_a.nan_num_visita = 1 and grc_nga.status_1 = ' . aspa('AP');
                $sql .= ' or grc_a.nan_num_visita = 2 and grc_nga.status_2 = ' . aspa('AP');
                $sql .= ' )';
                $sql .= ' and grc_a.idt_nan_ordem_pagamento is null ';
                $sql .= ' and grc_a.idt_grupo_atendimento is not null ';
                $sql .= ' and grc_a.data >= ' . aspa($data_me) . ' and grc_a.data <= ' . aspa($data_ma);
                $sql .= ' and grc_a.idt_nan_tutor in (';
                $sql .= ' select tu.idt_usuario';
                $sql .= ' from grc_nan_estrutura gl';
                $sql .= ' inner join grc_nan_estrutura tu on tu.idt_tutor = gl.idt';
                $sql .= ' where gl.idt_usuario = ' . null($_POST['idt_cadastrante']);
                $sql .= ' and gl.idt_ponto_atendimento = ' . null($row['nan_idt_unidade_regional']);
                $sql .= ' and gl.idt_nan_tipo = 3';
                $sql .= ' )';
                $rs = execsql($sql);

                ForEach ($rs->data as $row) {
                    $idt_atendimento = $row['grc_a_idt'];
                    $sql = 'update grc_atendimento ';
                    $sql .= " set idt_nan_ordem_pagamento = " . null($vlID) . " ";
                    $sql .= ' where idt = ' . null($idt_atendimento);
                    execsql($sql);
                }
            }

            // desagregar visitas
            if ($acao_nan == 'DE' || $acao_nan == 'EX') {
                $data_inicio = $_POST['data_inicio'];
                $data_fim = $_POST['data_fim'];
                $sql = 'update grc_atendimento ';
                $sql .= " set idt_nan_ordem_pagamento = null ";
                $sql .= ' where idt_nan_ordem_pagamento = ' . null($vlID);
                execsql($sql);

                if ($acao_nan == 'EX') {
                    $sql = 'delete from grc_atendimento_pendencia';
                    $sql .= ' where idt_nan_ordem_pagamento = ' . null($vlID);
                    execsql($sql);

                    $sql = 'delete from grc_nan_ordem_pagamento';
                    $sql .= ' where idt = ' . null($vlID);
                    execsql($sql);
                }
            }

            if ($acao_nan == 'AG' || $acao_nan == 'DE') {
                // calcular valores da Ordem
                $vetResultado = Array();
                NAN_CalcularOP($vlID, $vetResultado);

                $vetPar = $_GET;
                $vetPar['prefixo'] = 'cadastro';
                $vetPar['id'] = $vlID;
                $vetPar['acao'] = 'alt';

                $par = http_build_query($vetPar);

                $href = "conteudo{$cont_arq}.php?" . $par;
                $botao_acao = '<script type="text/javascript">self.location = "' . $href . '";</script>';
            }

            //Fecha pendencia
            if ($_GET['idt_pendencia'] != '') {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_nan_ordem_pagamento  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'NAN - Ordem de Pagamento'";
                execsql($sql_a);

                unset($_GET['idt_pendencia']);
            }

            //Aprovação ou Devolução da Pendencia
            if ($acao_nan == 'AP' || $acao_nan == 'DV') {
                $sql = '';
                $sql .= ' select gec_cc.codigo, gec_e.descricao';
                $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado gec_cc ';
                $sql .= ' inner join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao ';
                $sql .= ' where gec_cc.idt = ' . null($_POST['idt_contrato']);
                $rs = execsql($sql);
                $row = $rs->data[0];

                $assunto = aspa('[' . $row['codigo'] . '] ' . $row['descricao']);
                $observacao = $assunto;
                $data = aspa(trata_data(date('d/m/Y H:i:s')));
                $data_solucao = aspa(trata_data(date('d/m/Y')));

                if ($acao_nan == 'AP') {
                    $idt_usuario = $_SESSION[CS]['g_id_usuario'];

                    do {
                        $sql = '';
                        $sql .= ' select ifnull(pai.idt_usuario, ne.idt_usuario) as idt_usuario, ifnull(pai.idt_nan_tipo, ne.idt_nan_tipo) as idt_nan_tipo';
                        $sql .= ' from grc_nan_estrutura ne';
                        $sql .= ' inner join grc_nan_estrutura_tipo net on net.idt = ne.idt_nan_tipo';
                        $sql .= ' left outer join grc_nan_estrutura pai on pai.idt = ne.idt_tutor';
                        $sql .= ' where ne.idt_usuario = ' . null($idt_usuario);
                        $sql .= ' and (ne.idt_ponto_atendimento = 6 or ne.idt_ponto_atendimento = ' . null($nan_idt_unidade_regional_orcada) . ')';
                        $sql .= ' order by net.ordem limit 1';
                        $rs = execsql($sql);
                        $row = $rs->data[0];

                        $idt_usuario = $row['idt_usuario'];

                        $sql = '';
                        $sql .= ' select aprova_ordem';
                        $sql .= ' from grc_nan_estrutura_tipo';
                        $sql .= ' where idt = ' . null($row['idt_nan_tipo']);
                        $rsx = execsql($sql);
                    } while ($rsx->data[0][0] != 'S');

                    $status = 'Solicitação de Aprovação';
                    $idt_usuario = $row['idt_usuario'];
                    $situacao = 'V' . $row['idt_nan_tipo'];
                    $solucao = 'null';
                } else {
                    $status = 'Devolver para Ajustes';
                    $idt_usuario = $_POST['idt_cadastrante'];
                    $situacao = 'GE';
                    $solucao = aspa($_POST['solucao_pendencia']);
                }

                $sql_i = ' insert into grc_atendimento_pendencia (';
                $sql_i .= ' idt_nan_ordem_pagamento, protocolo, idt_gestor_local, idt_responsavel_solucao,';
                $sql_i .= ' status, tipo, idt_usuario, data, data_solucao, assunto, observacao, solucao';
                $sql_i .= ' ) values ( ';
                $sql_i .= null($vlID) . ', ' . aspa($_POST['protocolo']) . ', ' . null($idt_usuario) . ', ' . null($idt_usuario) . ', ';
                $sql_i .= aspa($status) . ", 'NAN - Ordem de Pagamento', " . null($_POST['idt_cadastrante']) . ', ';
                $sql_i .= "{$data}, {$data_solucao}, {$assunto}, {$observacao}, {$solucao}";
                $sql_i .= ' )';
                execsql($sql_i);
                copiaAtendimentoPendenciaTransResp(lastInsertId());

                $sql = 'update grc_nan_ordem_pagamento set situacao = ' . aspa($situacao);
                $sql .= ' where idt = ' . null($vlID);
                execsql($sql);
            }

            //Sincronia RM
            if ($acao_nan == 'RM') {
                //Gera PDF
                $contrato_pdf = mb_strtolower('lista_faturamento_' . $_POST['protocolo'] . '.pdf');
                $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_nan_ordem_pagamento/');

                if (!file_exists($pathPDF)) {
                    mkdir($pathPDF);
                }

                $_REQUEST['titulo_rel'] = $bt_exportar_tit;
                salvaPDF($pathPDF . $contrato_pdf);

                if (!file_exists($pathPDF . $contrato_pdf)) {
                    erro_try('A Lista do Faturamento em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                    echo "<div align='center' class='Msg'>A Lista do Faturamento em PDF não localizado em " . $pathPDF . $contrato_pdf . "\n";
                    echo '<br><br><input type="button" name="btnAcao" class="Botao" value=" Voltar " onClick="history.go(-1)"></div>';
                    onLoadPag();
                    exit();
                }

                $sql = 'update grc_nan_ordem_pagamento set pdf_aprova_ordem = ' . aspa($contrato_pdf);
                $sql .= ' where idt = ' . null($vlID);
                execsql($sql);

                $vetErro = rmGeraOrdemPagamentoNAN($vlID);

                if (count($vetErro) > 0) {
                    $erro = 'Erro na geração da Ordem de Pagamento do NAN no RM.<br />';
                    $erro .= implode('<br />', $vetErro);
                    msg_erro($erro);
                }

                $sql = "update grc_nan_ordem_pagamento set situacao = 'AP',";
                $sql .= ' data_aprova_ordem = now(), idt_aprova_ordem = ' . null($_SESSION[CS]['g_id_usuario']);
                $sql .= ' where idt = ' . null($vlID);
                execsql($sql);

                commit();
                beginTransaction();

                try {

                    //Enviar email para a empresa NAN
                    function msgParametros($txt) {
                        global $protocolo, $row;

                        $txt = str_replace('#protocolo', $protocolo, $txt);
                        $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

                        $txt = str_replace('#ordem_pagamento', $_POST['protocolo'], $txt);
                        $txt = str_replace('#contrato', $row['cod_contrato'], $txt);

                        $txt = str_replace('#inicio_data', $_POST['data_inicio'], $txt);
                        $txt = str_replace('#fim_data', $_POST['data_fim'], $txt);
                        $txt = str_replace('#observacao', $_POST['objeto'], $txt);
                        $txt = str_replace('#qtd_total_visitas', $_POST['qtd_total_visitas'], $txt);
                        $txt = str_replace('#qtd_visitas1', $_POST['qtd_visitas1'], $txt);
                        $txt = str_replace('#qtd_visitas2', $_POST['qtd_visitas2'], $txt);
                        $txt = str_replace('#valor_total', $_POST['valor_total'], $txt);

                        return $txt;
                    }

                    $sql = '';
                    $sql .= ' select gec_cc.codigo as cod_contrato, u.email, u.nome_completo';
                    $sql .= ' from ' . db_pir_gec . 'gec_contratar_credenciado gec_cc';
                    $sql .= ' inner join ' . db_pir_gec . 'gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao';
                    $sql .= ' inner join plu_usuario u on u.login = gec_e.codigo';
                    $sql .= ' where gec_cc.idt = ' . null($_POST['idt_contrato']);
                    $rs = execsql($sql);
                    $row = $rs->data[0];

                    $protocolo = date('dmYHis');

                    $vetGRC_parametros = GRC_parametros();
                    $assunto = msgParametros($vetGRC_parametros['grc_nan_ordem_pagamento_01']);
                    $mensagem = msgParametros($vetGRC_parametros['grc_nan_ordem_pagamento_02']);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'grc_nan_ordem_pagamento_0102',
                    );
                    enviarEmail(db_pir_grc, $assunto, $mensagem, $row['email'], $row['nome_completo'], true, $vetRegProtocolo);
                } catch (Exception $e) {
                    grava_erro_log('php', $e, '');
                    echo "<script type='text/javascript'>alert('Integração com o RM realizado com sucesso, mas não foi possivel enviar o email para o credenciado!');</script>";
                }
            }
        } else {
            $sql = '';
            $sql .= ' select e.*, gec_cc.codigo as gec_cc_codigo, gec_e.descricao as gec_e_executora, sca_nan.descricao as sca_nan_ur';
            $sql .= ' from grc_nan_ordem_pagamento e';
            $sql .= " inner join " . db_pir_gec . "gec_contratar_credenciado gec_cc on gec_cc.idt = e.idt_contrato";
            $sql .= " inner join " . db_pir_gec . "gec_entidade gec_e on gec_e.idt = gec_cc.idt_organizacao";
            $sql .= " inner join " . db_pir . "sca_organizacao_secao sca_nan on sca_nan.idt = gec_cc.nan_idt_unidade_regional";
            $sql .= ' where e.idt = ' . null($vlID);
            $rse = execsql($sql);
            $rowe = $rse->data[0];

            function msgParametrosOrdemPagamentoNAN($txt) {
                global $protocolo, $rowe;

                $txt = str_replace('#protocolo', $protocolo, $txt);
                $txt = str_replace('#data', date('d/m/Y H:i:s'), $txt);

                $txt = str_replace('#codigo', $rowe['protocolo'], $txt);
                $txt = str_replace('#cod_contrato', $rowe['gec_cc_codigo'], $txt);
                $txt = str_replace('#empresa_contrato', $rowe['gec_e_executora'], $txt);
                $txt = str_replace('#unid_regional', $rowe['sca_nan_ur'], $txt);

                return $txt;
            }

            if (is_array($_POST['pfo_situacao'])) {
                foreach ($_POST['pfo_situacao'] as $idt => $dados) {
                    if ($dados['vl'] == '') {
                        $dados['vl'] = 'PE';
                    }

                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo_item set';
                    $sql .= ' situacao = ' . aspa($dados['vl']) . ',';
                    $sql .= ' obs_validacao = ' . aspa($dados['obs']) . ',';
                    $sql .= ' idt_validador = ' . null(IdUsuarioPIR($_SESSION[CS]['g_id_usuario'], db_pir_grc, db_pir_pfo)) . ',';
                    $sql .= ' dt_validacao = now()';
                    $sql .= ' where idt = ' . null($idt);
                    execsql($sql);
                }
            }

            $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
            $sql .= ' obs_validacao = ' . aspa($_POST['pfo_obs_validacao']);
            $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
            execsql($sql);

            if ($_POST['acao_nan'] != 'pfoSalvar') {
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_pfo_af_processo  = ' . null($_POST['idt_pfo_af_processo']);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Pagamento a Credenciado'";
                execsql($sql_a);
            }

            $vetPOF_parametros = Array();

            $sql = '';
            $sql .= ' select *';
            $sql .= ' from ' . db_pir_pfo . 'pfo_parametros pfo_pa';
            $sql .= " where codigo in ('pfo_af_processo_cred_nan_03', 'pfo_af_processo_cred_nan_04', 'pfo_af_processo_cred_nan_05', 'pfo_af_processo_cred_nan_06', 'pfo_af_processo_01', 'pfo_af_processo_02')";
            $rs = execsql($sql);

            ForEach ($rs->data as $row) {
                $codigo = html_entity_decode($row['codigo'], ENT_QUOTES, "ISO-8859-1");
                $detalhe = html_entity_decode($row['detalhe'], ENT_QUOTES, "ISO-8859-1");
                $vetPOF_parametros[$codigo] = $detalhe;
            }

            $sql = '';
            $sql .= ' select login, email, nome_completo';
            $sql .= ' from ' . db_pir_pfo . 'plu_usuario';
            $sql .= ' where id_usuario = ' . null($_POST['pfo_idt_usuario']);
            $rs = execsql($sql);
            $rowUP = $rs->data[0];

            switch ($_POST['acao_nan']) {
                case 'pfoDevolver':
                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'RN'";
                    $sql .= ", status_liberacao = 'N'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    $protocolo = date('dmYHis');

                    $assunto = msgParametrosOrdemPagamentoNAN($vetPOF_parametros['pfo_af_processo_cred_nan_03']);
                    $mensagem = msgParametrosOrdemPagamentoNAN($vetPOF_parametros['pfo_af_processo_cred_nan_04']);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'pfo_af_processo_cred_nan_0304',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                    break;

                case 'pfoAprovar':
                    $sql = 'update ' . db_pir_pfo . 'pfo_af_processo set';
                    $sql .= " situacao_reg = 'NF'";
                    $sql .= ", status_liberacao = 'S'";
                    $sql .= ' where idt = ' . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    $protocolo = date('dmYHis');

                    $assunto = msgParametrosOrdemPagamentoNAN($vetPOF_parametros['pfo_af_processo_cred_nan_05']);
                    $mensagem = msgParametrosOrdemPagamentoNAN($vetPOF_parametros['pfo_af_processo_cred_nan_06']);

                    $mensagem = str_replace('#responsavel', $rowUP['nome_completo'], $mensagem);

                    $vetRegProtocolo = Array(
                        'protocolo' => $protocolo,
                        'origem' => 'pfo_af_processo_cred_nan_0506',
                    );
                    $respEmail = enviarEmail(db_pir_pfo, $assunto, $mensagem, $rowUP['email'], $rowUP['nome_completo'], true, $vetRegProtocolo);

                    if ($respEmail !== true) {
                        msg_erro("Erro na transmissão do email. Tente outra vez!<br /><br />" . $respEmail);
                    }

                    $respAviso = criarPFOAviso($assunto, $mensagem, $_SESSION[CS]['g_login'], $rowUP['login']);

                    if ($respAviso !== true) {
                        msg_erro("Erro na transmissão. Tente outra vez! " . $respAviso);
                    }
                    break;

                case 'pfoAprovarFIN':
                    $sql = "update " . db_pir_pfo . "pfo_af_processo set situacao_reg = 'FI', gfi_situacao = 'CF', liberado_validacao = 'S' where idt = " . null($_POST['idt_pfo_af_processo']);
                    execsql($sql);

                    //Email de aviso para o usuaruio sebrae
                    $sql = '';
                    $sql .= ' select nome_completo, email';
                    $sql .= ' from ' . db_pir_pfo . 'plu_usuario';
                    $sql .= " where aviso_validacao_rm = 'S'";
                    $sql .= " and ativo = 'S'";
                    $rs = execsql($sql);

                    foreach ($rs->data as $row) {
                        $assunto = $vetPOF_parametros['pfo_af_processo_01'];
                        $mensagem = $vetPOF_parametros['pfo_af_processo_02'];

                        $protocolo = date('dmYHis');

                        $mensagem = str_replace('#protocolo', $protocolo, $mensagem);
                        $mensagem = str_replace('#data', date('d/m/Y H:i:s'), $mensagem);
                        $mensagem = str_replace('#num_movimento', $_POST['protocolo'], $mensagem);
                        $mensagem = str_replace('#cnpjcpf', $_POST['cnpjcpf'], $mensagem);

                        $vetRegProtocolo = Array(
                            'protocolo' => $protocolo,
                            'origem' => 'pfo_af_processo_0102',
                        );
                        enviarEmail(db_pir_pfo, $assunto, $mensagem, $row['email'], $row['nome_completo'], true, $vetRegProtocolo);
                    }
                    break;
            }
        }
        break;

    case 'grc_avaliacao_devolutiva_produto':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto']]['sel_final'];

            foreach ($vetSel as $idx => $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_avaliacao_devolutiva_produto';
                $sql .= ' where idt_avaliacao_devolutiva = ' . null($_POST['idt_avaliacao_devolutiva']);
                $sql .= ' and idt_produto = ' . null($dados['idt']);
                $rs = execsql($sql);

                if ($rs->rows == 0) {
                    $sql = 'insert into grc_avaliacao_devolutiva_produto (idt_avaliacao_devolutiva, idt_produto, status) values (';
                    $sql .= null($_POST['idt_avaliacao_devolutiva']) . ', ' . null($dados['idt']) . ", 'MA')";
                    execsql($sql);
                } else {
                    $sql = 'update grc_avaliacao_devolutiva_produto set ';
                    $sql .= " status = 'MA',";
                    $sql .= " ativo = 'S'";
                    $sql .= ' where idt = ' . null($rs->data[0][0]);
                    execsql($sql);
                }
            }
        }
        break;

    case 'plu_helpdesk':
        $sql = 'update plu_helpdesk set ';
        $sql .= " flag_logico = 'A' ";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);
        //
        $vetParametros['idt_helpdesk'] = $vlID;
        SincronizaDeskSebrae($vetParametros);

        if ($acao == 'alt' or $acao == 'ins') {
            if ($vetParametros['erro'] == 1) {
                echo "<script>";
                echo ' var msg = "Sua solicitação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";';
                echo " alert(msg); ";
                echo "</script>";
            } else {
                $msg_erro = $vetParametros['msg_erro'];
                echo "<script>";
                //echo " var msg = '".''."\n"."O EMAIL DE REGISTRO NÃO PODE SER ENVIADO"."\n"."Mas, sua solicitação foi cadastrada com sucesso!"."\n"." Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.';";
                echo ' var msg = "O EMAIL DE REGISTRO NÃO PODE SER ENVIADO. Sua solicitação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";';
                echo " alert(msg); ";
                echo "</script>";
            }
        }
        break;

    case 'plu_helpdesk_interacao':
        $sql = 'update plu_helpdesk_interacao set ';
        $sql .= " flag_logico = 'A' ";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);
        //
        $vetParametros['idt_helpdesk_interacao'] = $vlID;
        SincronizaDeskInteracaoSebrae($vetParametros);

        if ($acao == 'alt' or $acao == 'ins') {
            if ($vetParametros['erro'] == 1) {
                echo "<script>";
                echo ' var msg = "Sua interação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";';
                echo " alert(msg); ";
                echo "</script>";
            } else {
                $msg_erro = $vetParametros['msg_erro'];
                echo "<script>";
                //echo " var msg = '".''."\n"."O EMAIL DE REGISTRO NÃO PODE SER ENVIADO"."\n"."Mas, sua solicitação foi cadastrada com sucesso!"."\n"." Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.';";
                echo ' var msg = "O EMAIL DA INTERAÇÃO NÃO PODE SER ENVIADO. Sua solicitação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";';
                echo " alert(msg); ";
                echo "</script>";
            }
        }


        break;

    case 'grc_politica_vendas':
        $vetWizard = Array(
            'wizardEvento' => 'P',
            'wizardMatricula' => 'M',
        );

        foreach ($vetWizard as $postWizard => $tipoWizard) {
            $sql = 'delete from grc_politica_vendas_condicao';
            $sql .= ' where idt_politica_vendas = ' . null($vlID);
            $sql .= ' and tipo = ' . aspa($tipoWizard);
            execsql($sql);

            if (is_array($_POST[$postWizard])) {
                unset($_POST[$postWizard][0]);

                $ordem = 0;

                foreach ($_POST[$postWizard] as $row) {
                    if ($row['campo'] != '') {
                        $ordem++;

                        $sql = '';
                        $sql .= 'insert into grc_politica_vendas_condicao (';
                        $sql .= ' idt_politica_vendas, codigo, ordem, parentese_ant,';
                        $sql .= ' parentese_dep, condicao, valor, operador, tipo';
                        $sql .= ') values (';
                        $sql .= null($vlID) . ', ' . aspa($row['campo']) . ', ' . aspa($ordem) . ', ' . aspa($row['parentese_ant']) . ', ';
                        $sql .= aspa($row['parentese_dep']) . ', ' . aspa($row['operador']) . ', ' . aspa($row['valor']) . ', ' . aspa($row['expressao']) . ', ' . aspa($tipoWizard);
                        $sql .= ')';
                        execsql($sql);
                    }
                }
            }
        }
        break;

    case 'grc_entidade_ajuste':
        $sql = '';
        $sql .= ' select coalesce(dap, nirf, rmp, ie_prod_rural) as vl, verificado';
        $sql .= ' from grc_entidade_ajuste';
        $sql .= ' where idt = ' . null($_GET['id']);
        $rs = execsql($sql);

        $sql = 'update grc_entidade_ajuste set';
        $sql .= ' verificado = ' . aspa($_POST['verificado']);
        $sql .= ' where coalesce(dap, nirf, rmp, ie_prod_rural) = ' . aspa($rs->data[0][0]);
        execsql($sql);
        break;

    case 'grc_entidade_ajuste_cad':
        $sql = '';
        $sql .= ' select e.descricao, o.dap, o.nirf, o.rmp, o.ie_prod_rural';
        $sql .= ' from ' . db_pir_gec . 'gec_entidade e';
        $sql .= ' inner join ' . db_pir_gec . 'gec_entidade_organizacao o on o.idt_entidade = e.idt';
        $sql .= ' where e.idt = ' . null($_POST['id']);
        $rs = execsql($sql);
        $rowAnt = $rs->data[0];

        $sql = 'update ' . db_pir_gec . 'gec_entidade set';
        $sql .= ' descricao = ' . aspa($_POST['descricao']);
        $sql .= ' where idt = ' . null($_POST['id']);
        execsql($sql);

        $sql = 'update ' . db_pir_gec . 'gec_entidade_organizacao set';
        $sql .= ' dap = ' . aspa($_POST['dap']) . ',';
        $sql .= ' nirf = ' . aspa($_POST['nirf']) . ',';
        $sql .= ' rmp = ' . aspa($_POST['rmp']) . ',';
        $sql .= ' ie_prod_rural = ' . aspa($_POST['ie_prod_rural']);
        $sql .= ' where idt_entidade = ' . null($_POST['id']);
        execsql($sql);

        $sql = 'update grc_entidade_ajuste set';
        $sql .= ' descricao = ' . aspa($_POST['descricao']) . ',';
        $sql .= ' dap = ' . aspa($_POST['dap']) . ',';
        $sql .= ' nirf = ' . aspa($_POST['nirf']) . ',';
        $sql .= ' rmp = ' . aspa($_POST['rmp']) . ',';
        $sql .= ' ie_prod_rural = ' . aspa($_POST['ie_prod_rural']);
        $sql .= ' where idt_entidade = ' . null($_POST['id']);
        execsql($sql);

        $vetLogDetalhe = Array();
        $vetLogDetalhe['descricao']['campo_desc'] = 'Razão Social';
        $vetLogDetalhe['descricao']['desc_ant'] = $rowAnt['descricao'];
        $vetLogDetalhe['descricao']['desc_atu'] = $_POST['descricao'];

        $vetLogDetalhe['dap']['campo_desc'] = 'DAP';
        $vetLogDetalhe['dap']['desc_ant'] = $rowAnt['dap'];
        $vetLogDetalhe['dap']['desc_atu'] = $_POST['dap'];

        $vetLogDetalhe['nirf']['campo_desc'] = 'NIRF';
        $vetLogDetalhe['nirf']['desc_ant'] = $rowAnt['nirf'];
        $vetLogDetalhe['nirf']['desc_atu'] = $_POST['nirf'];

        $vetLogDetalhe['rmp']['campo_desc'] = 'Registro Ministério da Pesca';
        $vetLogDetalhe['rmp']['desc_ant'] = $rowAnt['rmp'];
        $vetLogDetalhe['rmp']['desc_atu'] = $_POST['rmp'];

        $vetLogDetalhe['ie_prod_rural']['campo_desc'] = 'IE';
        $vetLogDetalhe['ie_prod_rural']['desc_ant'] = $rowAnt['ie_prod_rural'];
        $vetLogDetalhe['ie_prod_rural']['desc_atu'] = $_POST['ie_prod_rural'];

        grava_log_sis('grc_entidade_ajuste', 'A', $_POST['id'], $_POST['descricao'], 'Ajuste do Produtor Rural', '', $vetLogDetalhe, true);
        break;

    case 'grc_nan_estrutura':
        if ($_POST['idt_tutor'] != $_POST['idt_tutor_old']) {
            $sql = '';
            $sql .= ' select et.idt_usuario as idt_nan_tutor, idt_acao';
            $sql .= ' from grc_nan_estrutura et';
            $sql .= ' where et.idt = ' . null($_POST['idt_tutor']);
            $rs = execsql($sql);
            $rowTutorNovo = $rs->data[0];

            $sql = '';
            $sql .= ' select et.idt_usuario as idt_nan_tutor, idt_acao';
            $sql .= ' from grc_nan_estrutura et';
            $sql .= ' where et.idt = ' . null($_POST['idt_tutor_old']);
            $rs = execsql($sql);
            $rowTutorOld = $rs->data[0];

            if ($rowTutorNovo['idt_acao'] == $rowTutorOld['idt_acao']) {
                $sql = '';
                $sql .= ' select a.idt';
                $sql .= ' from grc_atendimento a';
                $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
                $sql .= ' where a.idt_nan_tutor = ' . null($rowTutorOld['idt_nan_tutor']);
                $sql .= ' and a.idt_projeto_acao = ' . null($rowTutorOld['idt_acao']);
                $sql .= ' and a.idt_consultor = ' . null($_POST['idt_usuario']);
                $sql .= ' and (';
                $sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
                $sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
                $sql .= ' )';
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $sql = 'update grc_atendimento set idt_nan_tutor = ' . null($rowTutorNovo['idt_nan_tutor']);
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql);

                    $sql = 'update grc_atendimento_pendencia set idt_gestor_local = ' . null($rowTutorNovo['idt_nan_tutor']);
                    $sql .= ', idt_responsavel_solucao = ' . null($rowTutorNovo['idt_nan_tutor']);
                    $sql .= ' where idt_atendimento = ' . null($row['idt']);
                    $sql .= " and ativo = 'S'";
                    $sql .= " and status = 'Aprovação'";
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_nan_troca_tutor':
        $sql = '';
        $sql .= ' select et.idt_usuario as idt_nan_tutor, et.idt_acao, u.nome_completo';
        $sql .= ' from grc_nan_estrutura et';
        $sql .= " inner join plu_usuario u on u.id_usuario = et.idt_usuario ";
        $sql .= ' where et.idt = ' . null($_POST['idt_tutor_old']);
        $rs = execsql($sql);
        $rowTutorOld = $rs->data[0];

        if (is_array($_POST['idt_tutor'])) {
            foreach ($_POST['idt_tutor'] as $idt => $idt_tutor) {
                if ($idt_tutor != '') {
                    $sql = '';
                    $sql .= ' select idt_usuario';
                    $sql .= ' from grc_nan_estrutura';
                    $sql .= ' where idt = ' . null($idt);
                    $rs = execsql($sql);
                    $idt_consultor = $rs->data[0][0];

                    $sql = '';
                    $sql .= ' select et.idt_usuario as idt_nan_tutor, u.nome_completo';
                    $sql .= ' from grc_nan_estrutura et';
                    $sql .= " inner join plu_usuario u on u.id_usuario = et.idt_usuario ";
                    $sql .= ' where et.idt = ' . null($idt_tutor);
                    $rs = execsql($sql);

                    if ($rs->rows > 0) {
                        $rowTutorNovo = $rs->data[0];

                        $sql = 'update grc_nan_estrutura set idt_tutor = ' . null($idt_tutor);
                        $sql .= ' where idt = ' . null($idt);
                        execsql($sql);

                        $sql = '';
                        $sql .= ' select a.idt';
                        $sql .= ' from grc_atendimento a';
                        $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
                        $sql .= ' where a.idt_nan_tutor = ' . null($rowTutorOld['idt_nan_tutor']);
                        $sql .= ' and a.idt_projeto_acao = ' . null($rowTutorOld['idt_acao']);
                        $sql .= ' and a.idt_consultor = ' . null($idt_consultor);
                        $sql .= ' and (';
                        $sql .= "    (a.nan_num_visita = 1 and g.status_1 <> 'AP')";
                        $sql .= " or (a.nan_num_visita = 2 and g.status_2 <> 'AP')";
                        $sql .= ' )';
                        $rs = execsql($sql);

                        foreach ($rs->data as $row) {
                            $sql = 'update grc_atendimento set idt_nan_tutor = ' . null($rowTutorNovo['idt_nan_tutor']);
                            $sql .= ' where idt = ' . null($row['idt']);
                            execsql($sql);

                            $sql = 'update grc_atendimento_pendencia set idt_gestor_local = ' . null($rowTutorNovo['idt_nan_tutor']);
                            $sql .= ', idt_responsavel_solucao = ' . null($rowTutorNovo['idt_nan_tutor']);
                            $sql .= ' where idt_atendimento = ' . null($row['idt']);
                            $sql .= " and ativo = 'S'";
                            $sql .= " and status = 'Aprovação'";
                            execsql($sql);
                        }

                        $vetLogDetalhe = Array();
                        $vetLogDetalhe['idt_tutor']['campo_desc'] = 'Tutor';
                        $vetLogDetalhe['idt_tutor']['vl_ant'] = $rowTutorOld['idt_nan_tutor'];
                        $vetLogDetalhe['idt_tutor']['desc_ant'] = $rowTutorOld['nome_completo'];
                        $vetLogDetalhe['idt_tutor']['vl_atu'] = $rowTutorNovo['idt_nan_tutor'];
                        $vetLogDetalhe['idt_tutor']['desc_atu'] = $rowTutorNovo['nome_completo'];

                        grava_log_sis('grc_nan_estrutura', 'A', $idt, '', 'Troca de Tutor', '', $vetLogDetalhe, true);
                    }
                }
            }
        }
        break;

    case 'grc_nan_transferir_atendimento':
        if (is_array($_POST['idt_consultor'])) {
            $sql = '';
            $sql .= ' select nome_completo';
            $sql .= ' from plu_usuario';
            $sql .= ' where id_usuario = ' . null($_POST['idt_aoe']);
            $rs = execsql($sql);
            $desc_ant = $rs->data[0][0];

            foreach ($_POST['idt_consultor'] as $idt => $idt_consultor) {
                if ($idt_consultor != '') {
                    $sql = '';
                    $sql .= ' select et.idt_usuario as idt_nan_tutor, u.nome_completo';
                    $sql .= ' from grc_nan_estrutura e';
                    $sql .= ' inner join grc_nan_estrutura et on et.idt = e.idt_tutor';
                    $sql .= " inner join plu_usuario u on u.id_usuario = et.idt_usuario ";
                    $sql .= ' where e.idt_usuario = ' . null($idt_consultor);
                    $sql .= ' and e.idt_acao = ' . null($_POST['idt_acao']);
                    $sql .= ' and e.idt_nan_tipo = 6';
                    $sql .= " and e.ativo = 'S'";
                    $rst = execsql($sql);
                    $rowTutorNovo = $rst->data[0];

                    $sql = '';
                    $sql .= ' select a.idt_consultor, a.protocolo, a.idt_nan_tutor, u.nome_completo,';
                    $sql .= ' a.nan_num_visita, g.status_1, g.status_2, a.idt_consultor_prox_atend';
                    $sql .= ' from grc_atendimento a';
                    $sql .= ' inner join grc_nan_grupo_atendimento g on g.idt = a.idt_grupo_atendimento';
                    $sql .= " left outer join plu_usuario u on u.id_usuario = a.idt_nan_tutor ";
                    $sql .= ' where a.idt = ' . null($idt);
                    $rst = execsql($sql);
                    $rowTutorOld = $rst->data[0];

                    $sql = '';
                    $sql .= ' select nome_completo';
                    $sql .= ' from plu_usuario';
                    $sql .= ' where id_usuario = ' . null($idt_consultor);
                    $rs = execsql($sql);
                    $desc_atu = $rs->data[0][0];

                    $vetLogDetalhe = Array();

                    $sql = 'update grc_atendimento set idt_consultor_prox_atend = ' . null($idt_consultor);

                    if ($rowTutorOld['status_' . $rowTutorOld['nan_num_visita']] != 'AP') {
                        $sql .= ', idt_consultor = ' . null($idt_consultor);
                        $sql .= ', idt_nan_tutor = ' . null($rowTutorNovo['idt_nan_tutor']);

                        $vetLogDetalhe['idt_consultor']['campo_desc'] = 'Consultor/Atendente';
                        $vetLogDetalhe['idt_consultor']['vl_ant'] = $_POST['idt_aoe'];
                        $vetLogDetalhe['idt_consultor']['desc_ant'] = $desc_ant;
                        $vetLogDetalhe['idt_consultor']['vl_atu'] = $idt_consultor;
                        $vetLogDetalhe['idt_consultor']['desc_atu'] = $desc_atu;

                        $vetLogDetalhe['idt_tutor']['campo_desc'] = 'Tutor';
                        $vetLogDetalhe['idt_tutor']['vl_ant'] = $rowTutorOld['idt_nan_tutor'];
                        $vetLogDetalhe['idt_tutor']['desc_ant'] = $rowTutorOld['nome_completo'];
                        $vetLogDetalhe['idt_tutor']['vl_atu'] = $rowTutorNovo['idt_nan_tutor'];
                        $vetLogDetalhe['idt_tutor']['desc_atu'] = $rowTutorNovo['nome_completo'];
                    } else {
                        $sqlx = '';
                        $sqlx .= ' select nome_completo';
                        $sqlx .= ' from plu_usuario';
                        $sqlx .= ' where id_usuario = ' . null($rowTutorOld['idt_consultor_prox_atend']);
                        $rsx = execsql($sqlx);

                        $vetLogDetalhe['idt_consultor_prox_atend']['campo_desc'] = 'Consultor/Atendente da próxima visita';
                        $vetLogDetalhe['idt_consultor_prox_atend']['vl_ant'] = $rowTutorOld['idt_consultor_prox_atend'];
                        $vetLogDetalhe['idt_consultor_prox_atend']['desc_ant'] = $rsx->data[0][0];
                        $vetLogDetalhe['idt_consultor_prox_atend']['vl_atu'] = $idt_consultor;
                        $vetLogDetalhe['idt_consultor_prox_atend']['desc_atu'] = $desc_atu;
                    }

                    $sql .= ' where idt = ' . null($idt);
                    execsql($sql);

                    $sql = 'update grc_atendimento_pendencia set idt_gestor_local = ' . null($idt_consultor);
                    $sql .= ', idt_responsavel_solucao = ' . null($idt_consultor);
                    $sql .= ' where idt_atendimento = ' . null($idt);
                    $sql .= ' and idt_responsavel_solucao = ' . null($rowTutorOld['idt_consultor']);
                    $sql .= " and ativo = 'S'";
                    execsql($sql);


                    grava_log_sis('grc_nan_transferir_atendimento', 'A', $idt, $rowTutorOld['protocolo'], 'Transferir Atendimento (NAN)', '', $vetLogDetalhe, true);
                }
            }
        }
        break;

    case 'grc_produto_produto':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto_associado']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_produto';
                $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
                $sql .= ' and idt_produto_associado = ' . null($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_produto_produto (idt_produto, idt_produto_associado, tipo_relacao, obrigatorio, ativo, detalhe) values (';
                    $sql .= null($_POST['idt_produto']) . ', ' . null($dados['idt']) . ', ' . aspa($_POST['tipo_relacao']) . ', ' . aspa($_POST['obrigatorio']) . ', ' . aspa($_POST['ativo']) . ', ' . aspa($_POST['detalhe']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_produto_dimensionamento':
        if ($_POST['id'] == 0) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_insumo_dimensionamento']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_produto_dimensionamento';
                $sql .= ' where idt_produto = ' . null($_POST['idt_produto']);
                $sql .= ' and idt_insumo_dimensionamento = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_produto_dimensionamento (idt_produto, idt_insumo_dimensionamento, codigo, descricao,';
                    $sql .= ' detalhe, idt_insumo_unidade, vl_unitario) values (';
                    $sql .= null($_POST['idt_produto']) . ', ' . aspa($dados['idt']) . ', ' . aspa($dados['codigo']) . ', ' . aspa($dados['descricao']) . ', ';
                    $sql .= aspa($dados['detalhe']) . ', ' . null($dados['idt_insumo_unidade']) . ', ' . null(desformat_decimal($dados['vl_unitario'])) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_evento_dimensionamento':
        if ($_POST['id'] == 0) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_insumo_dimensionamento']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_evento_dimensionamento';
                $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
                $sql .= ' and idt_insumo_dimensionamento = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_evento_dimensionamento (idt_atendimento_evento, idt_insumo_dimensionamento, codigo, descricao,';
                    $sql .= ' detalhe, idt_insumo_unidade, vl_unitario) values (';
                    $sql .= null($_POST['idt_atendimento_evento']) . ', ' . aspa($dados['idt']) . ', ' . aspa($dados['codigo']) . ', ' . aspa($dados['descricao']) . ', ';
                    $sql .= aspa($dados['detalhe']) . ', ' . null($dados['idt_insumo_unidade']) . ', ' . null(desformat_decimal($dados['vl_unitario'])) . ')';
                    execsql($sql);
                }
            }
        }

        $vet = calculaValorAtendEvento($_POST['idt_atendimento_evento'], 'grc_atendimento_evento_dimensionamento');
        $vet = array_map('rawurlencode', $vet);
        ?>
        <script type="text/javascript">
            returnVal = <?php echo json_encode($vet); ?>;
        </script>
        <?php
        break;

    case 'grc_atendimento_evento_pagamento':
        //Conta de Devolução
        $vetIdtOK = Array();
        $vetIdtOK[] = 0;

        $sql = '';
        $sql .= ' select ao.cnpj as mat_cnpj, ao.razao_social as mat_razao_social, pp.par_cnpj, pp.par_razao_social,';
        $sql .= ' sum(pp.valor_pagamento) as vl_pago';
        $sql .= ' from grc_atendimento_evento_pagamento pp';
        $sql .= ' inner join grc_atendimento_evento ae on ae.idt = pp.idt_atendimento_evento';
        $sql .= ' inner join grc_atendimento_organizacao ao on ao.idt_atendimento = ae.idt_atendimento';
        $sql .= ' where pp.idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
        $sql .= " and pp.estornado <> 'S'";
        $sql .= " and ao.representa = 'S'";
        $sql .= " and ao.desvincular = 'N'";
        $sql .= ' group by ao.cnpj, ao.razao_social, pp.par_cnpj, pp.par_razao_social';
        $rs = execsql($sql);

        foreach ($rs->data as $row) {
            if ($row['par_cnpj'] == '') {
                $codigo = $row['mat_cnpj'];
                $descricao = $row['mat_razao_social'];
                $inc_pag_rm = 'S';
            } else {
                $codigo = $row['par_cnpj'];
                $descricao = $row['par_razao_social'];
                $inc_pag_rm = 'N';
            }

            $vl_pago = $row['vl_pago'];

            $sql = '';
            $sql .= ' select idt';
            $sql .= ' from grc_atendimento_evento_contadevolucao';
            $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
            $sql .= ' and codigo = ' . aspa($codigo);
            $rst = execsql($sql);

            if ($rst->rows == 0) {
                $sql = 'insert into grc_atendimento_evento_contadevolucao (idt_atendimento_evento, codigo, descricao, inc_pag_rm, vl_pago) values (';
                $sql .= null($_POST['idt_atendimento_evento']) . ', ' . aspa($codigo) . ', ' . aspa($descricao) . ', ' . aspa($inc_pag_rm) . ', ' . null($vl_pago) . ')';
                execsql($sql);
                $vetIdtOK[] = lastInsertId();
            } else {
                $sql = 'update grc_atendimento_evento_contadevolucao set descricao = ' . aspa($descricao);
                $sql .= ' , inc_pag_rm = ' . aspa($inc_pag_rm);
                $sql .= ' , vl_pago = ' . null($vl_pago);
                $sql .= ' where idt = ' . null($rst->data[0][0]);
                execsql($sql);
                $vetIdtOK[] = $rst->data[0][0];
            }
        }

        $sql = 'delete from grc_atendimento_evento_contadevolucao';
        $sql .= ' where idt_atendimento_evento = ' . null($_POST['idt_atendimento_evento']);
        $sql .= ' and idt not in (' . implode(', ', $vetIdtOK) . ')';
        execsql($sql);

        $vet = calculaValorAtendEvento($_POST['idt_atendimento_evento'], 'grc_atendimento_evento_pagamento');
        $vet = array_map('rawurlencode', $vet);
        ?>
        <script type="text/javascript">
            returnVal = <?php echo json_encode($vet); ?>;
        </script>
        <?php
        break;

    case 'grc_evento_dimensionamento':
        if ($_POST['id'] == 0) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_insumo_dimensionamento']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_evento_dimensionamento';
                $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
                $sql .= ' and idt_insumo_dimensionamento = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_evento_dimensionamento (idt_evento, idt_insumo_dimensionamento, codigo, descricao,';
                    $sql .= ' detalhe, idt_insumo_unidade, vl_unitario, idt_atendimento) values (';
                    $sql .= null($_POST['idt_evento']) . ', ' . aspa($dados['idt']) . ', ' . aspa($dados['codigo']) . ', ' . aspa($dados['descricao']) . ', ';
                    $sql .= aspa($dados['detalhe']) . ', ' . null($dados['idt_insumo_unidade']) . ', ' . null(desformat_decimal($dados['vl_unitario'])) . ', ';
                    $sql .= null($_POST['idt_atendimento']) . ')';
                    execsql($sql);
                }
            }
        }

        atualizaPagEventoSG($_POST['idt_evento']);

        $sql = '';
        $sql .= ' select vl_tot_pagamento';
        $sql .= ' from grc_evento_participante';
        $sql .= ' where idt_atendimento = ' . null($_POST['idt_atendimento']);
        $rs = execsql($sql);
        ?>
        <script type="text/javascript">
            returnVal = '<?php echo format_decimal($rs->data[0][0]);
        ?>';
        </script>
        <?php
        break;

    case 'grc_atendimento_evento':
        switch ($_POST['bt_acao_cadastro']) {
            case 'muda_acao':
                calculaValorAtendEvento($_POST['id'], 'grc_atendimento_evento');
                $botao_acao = '<script type="text/javascript">self.location = "conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'] . '";</script>';
                break;

            case 'bt_backoffice':
                cria_atendimento_evento($_POST['id']);
                break;

            case 'bt_backoffice_cotacao':
                commit();
                beginTransaction();

                $idt_evento = cria_atendimento_evento($_POST['id']);

                $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade";
                $sql .= ' from grc_evento grc_e';
                $sql .= ' inner join grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
                $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
                $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
                $sql .= " where grc_e.idt  = " . null($idt_evento);
                $rs = execsql($sql);
                $rowe = $rs->data[0];

                grc_evento_dep_situacao_24($idt_evento, $rowe);
                break;

            case 'bt_aprovacao':
                commit();
                beginTransaction();

                $idt_evento = cria_atendimento_evento($_POST['id']);

                $botao_acao = '';
                $botao_acao .= '<script type="text/javascript">';
                $botao_acao .= 'listar_rel_pdf_url("' . 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'] . '", "C");';
                $botao_acao .= 'setTimeout(\'self.location = "' . 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'] . '"\', 100);';
                $botao_acao .= '</script>';
                break;

            case 'bt_concluir':
                //Faz o contrato da matricula
                $sql = '';
                $sql .= ' select ep.idt, ep.idt_atendimento, p.idt as idt_atendimento_pessoa';
                $sql .= ' from grc_atendimento a';
                $sql .= ' inner join grc_evento_participante ep on ep.idt_atendimento = a.idt';
                $sql .= ' inner join grc_atendimento_pessoa p on p.idt_atendimento = a.idt';
                $sql .= ' where a.idt_evento = ' . null($rowDados['idt_evento']);
                $rs = execsql($sql);

                foreach ($rs->data as $row) {
                    $sql = "update grc_evento_participante set contrato = 'C'";
                    $sql .= ' where idt = ' . null($row['idt']);
                    execsql($sql);

                    $contrato_pdf = 'contrato_' . $row['idt_atendimento'] . '_' . GerarStr(20) . '.pdf';
                    $pathPDF = str_replace('/', DIRECTORY_SEPARATOR, path_fisico . '/' . $dir_file . '/grc_evento_participante_contrato/');

                    if (!file_exists($pathPDF)) {
                        mkdir($pathPDF);
                    }

                    $contrato_txt = salvaPDF($pathPDF . $contrato_pdf);
                    $contrato_txt = base64_encode(serialize(print_r($contrato_txt, true)));

                    if (!file_exists($pathPDF . $contrato_pdf)) {
                        erro_try('Contrato em PDF não localizado em ' . $pathPDF . $contrato_pdf);

                        echo '<script type="text/javascript">';
                        echo 'alert("Contrato em PDF não localizado em ' . $pathPDF . $contrato_pdf . '");';
                        echo 'self.location = "' . 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'] . '";';
                        echo '</script>';
                        onLoadPag();
                        exit();
                    }

                    $sql = 'insert into grc_evento_participante_contrato (idt_atendimento, idt_usuario_cont, contrato_txt, contrato_pdf) values (';
                    $sql .= null($row['idt_atendimento']) . ', ' . null($_SESSION[CS]['g_id_usuario']) . ', ' . aspa($contrato_txt) . ', ' . aspa($contrato_pdf) . ')';
                    execsql($sql);
                    $idt_contrato = lastInsertId();

                    if ($_FILES['contrato_ass_pdf']['name'] != '') {
                        $Erro = ErroArq('contrato_ass_pdf');
                        if ($Erro != "OK") {
                            erro_try('Erro no Contrato Assinado: ' . $Erro);

                            echo '<script type="text/javascript">';
                            echo 'alert("Erro no Contrato Assinado: ' . $Erro . '");';
                            echo 'self.location = "' . 'conteudo_cadastro.php?' . $_SERVER['QUERY_STRING'] . '";';
                            echo '</script>';
                            onLoadPag();
                            exit();
                        }

                        $path = dirname($_SERVER['SCRIPT_FILENAME']);
                        if ($path == '')
                            msg_erro('Não foi possível obter o path real do sistema!');

                        $path .= DIRECTORY_SEPARATOR . $dir_file;
                        if (!file_exists($path))
                            mkdir($path);

                        $path .= DIRECTORY_SEPARATOR . 'grc_evento_participante_contrato';
                        if (!file_exists($path)) {
                            mkdir($path);
                        }

                        $path .= DIRECTORY_SEPARATOR;

                        set_time_limit(600);

                        $nomearq = mb_strtolower($idt_contrato . '_' . 'contrato_ass_pdf' . '_' . $microtime . '_' . troca_caracter($_FILES['contrato_ass_pdf']['name']));
                        move_uploaded_file($_FILES['contrato_ass_pdf']['tmp_name'], $path . $nomearq);

                        $sql = "update grc_evento_participante_contrato set contrato_ass_pdf = " . aspa($nomearq);
                        $sql .= " where idt = " . null($idt_contrato);
                        execsql($sql);
                    }

                    $sql = "update grc_evento_participante_pagamento set idt_evento_participante_contrato = " . null($idt_contrato);
                    $sql .= ', idt_evento_situacao_pagamento = 5';
                    $sql .= " where idt_atendimento = " . null($row['idt_atendimento']);
                    $sql .= " and estornado = 'N'";
                    $sql .= " and operacao = 'C'";
                    $sql .= ' and idt_aditivo_participante is null';
                    execsql($sql);
                }

                //Cria a Ordem de Contratação
                $automatico = true;
                $usa_rodizio = true;
                $variavel = array();
                $ret = GEC_contratacao_credenciado_ordem($rowDados['idt_evento'], $variavel, $automatico, $usa_rodizio, false);

                if ($variavel['erro'] == '') {
                    commit();
                    beginTransaction();

                    $sql = "select grc_e.*, i.descricao as instrumento, pd.tipo_ordem, s.classificacao as classificacao_unidade";
                    $sql .= ' from grc_evento grc_e';
                    $sql .= ' inner join grc_atendimento_instrumento i on i.idt = grc_e.idt_instrumento';
                    $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = grc_e.idt_unidade';
                    $sql .= ' left outer join ' . db_pir_gec . 'gec_programa pd on pd.idt = grc_e.idt_programa';
                    $sql .= " where grc_e.idt  = " . null($rowDados['idt_evento']);
                    $rs = execsql($sql);
                    $rowe = $rs->data[0];

                    grc_evento_dep_situacao_6($rowDados['idt_evento'], $rowe);
                } else {
                    rollBack();

                    foreach ($variavel['ordem_codigo'] as $ordem_codigo) {
                        $chave_origem = 'GC' . $ordem_codigo;
                        $mensagemRM = 'Empenho não encontrado na Ordem de Contratação no sistema GEC';
                        $vetIdMov = Array();

                        $sql = '';
                        $sql .= ' select rm.rm_idmov';
                        $sql .= ' from ' . db_pir_gec . 'gec_contratacao_credenciado_ordem_rm rm';
                        $sql .= ' inner join ' . db_pir_gec . 'gec_contratacao_credenciado_ordem o on o.idt = rm.idt_gec_contratacao_credenciado_ordem';
                        $sql .= ' where o.codigo = ' . aspa($ordem_codigo);
                        $sql .= ' and rm.rm_idmov is not null';
                        $rstt = execsql($sql);

                        foreach ($rstt->data as $rowtt) {
                            $vetIdMov[] = $rowtt['rm_idmov'];
                        }

                        CancelaMovRM($chave_origem, $vetIdMov, $mensagemRM);
                    }

                    $variavel['erro'] = 'Erro na geração da Ordem de Contratação.<br />' . $variavel['erro'];
                    erro_try($variavel['erro'], 'evento_ordem_at');
                    msg_erro($variavel['erro']);
                }
                break;
        }
        break;

    case 'grc_evento_atividade_valida':
        if (is_array($_POST['dados'])) {
            foreach ($_POST['dados'] as $idt => $row) {
                $dia = $row['data_inicial_real'];
                $dt_ini = $dia . ' ' . $row['hora_inicial_real'];
                $dt_fim = $dia . ' ' . $row['hora_final_real'];
                $row['carga_horaria_real'] = diffDate($dt_ini, $dt_fim, 'H');

                $sql = '';
                $sql .= ' select idt, data_inicial_real, hora_inicial_real, hora_final_real, carga_horaria_real, obs_real';
                $sql .= ' from ' . db_pir_grc . 'grc_evento_agenda';
                $sql .= ' where idt = ' . null($idt);
                $rs = execsql($sql);
                $rowAnt = $rs->data[0];

                $sql = 'update ' . db_pir_grc . 'grc_evento_agenda set';
                $sql .= ' data_inicial_real = ' . aspa(trata_data($dia)) . ', ';
                $sql .= ' hora_inicial_real = ' . aspa($row['hora_inicial_real']) . ', ';
                $sql .= ' dt_ini_real = ' . aspa(trata_data($dt_ini)) . ', ';
                $sql .= ' data_final_real = ' . aspa(trata_data($dia)) . ', ';
                $sql .= ' hora_final_real = ' . aspa($row['hora_final_real']) . ', ';
                $sql .= ' dt_fim_real = ' . aspa(trata_data($dt_fim)) . ', ';
                $sql .= ' carga_horaria_real = ' . null($row['carga_horaria_real']) . ', ';
                $sql .= ' obs_real = ' . aspa($row['obs_real']);
                $sql .= ' where idt = ' . null($idt);
                execsql($sql);

                $vetLogDetalhe = Array();
                $vetLogDetalhe['data_inicial_real']['campo_desc'] = 'Data da Realização';
                $vetLogDetalhe['data_inicial_real']['desc_ant'] = $rowAnt['data_inicial_real'];
                $vetLogDetalhe['data_inicial_real']['desc_atu'] = $row['data_inicial_real'];

                $vetLogDetalhe['hora_inicial_real']['campo_desc'] = 'Hora Inicio da Realização';
                $vetLogDetalhe['hora_inicial_real']['desc_ant'] = $rowAnt['hora_inicial_real'];
                $vetLogDetalhe['hora_inicial_real']['desc_atu'] = $row['hora_inicial_real'];

                $vetLogDetalhe['hora_final_real']['campo_desc'] = 'Hora Final da Realização';
                $vetLogDetalhe['hora_final_real']['desc_ant'] = $rowAnt['hora_final_real'];
                $vetLogDetalhe['hora_final_real']['desc_atu'] = $row['hora_final_real'];

                $vetLogDetalhe['carga_horaria_real']['campo_desc'] = 'Carga Horária da Realização';
                $vetLogDetalhe['carga_horaria_real']['desc_ant'] = $rowAnt['carga_horaria_real'];
                $vetLogDetalhe['carga_horaria_real']['desc_atu'] = $row['carga_horaria_real'];

                $vetLogDetalhe['obs_real']['campo_desc'] = 'Comentário da Realização';
                $vetLogDetalhe['obs_real']['desc_ant'] = $rowAnt['obs_real'];
                $vetLogDetalhe['obs_real']['desc_atu'] = $row['obs_real'];

                grava_log_sis('grc_evento_agenda', 'A', $idt, $_POST['protocolo'], '', '', $vetLogDetalhe, true);
            }
        }
        break;

    case 'grc_transferencia_responsabilidade':
        switch ($_POST['btnAcao']) {
            case $bt_salvar_lbl:
            case 'Continua':
                if (is_array($_POST['chk_banco'])) {
                    foreach ($_POST['chk_banco'] as $idt_atendimento_pendencia => $ativo) {
                        $sql = 'insert into grc_transferencia_responsabilidade_reg (idt_transferencia_responsabilidade, idt_atendimento_pendencia, ativo) values (';
                        $sql .= null($vlID) . ', ' . null($idt_atendimento_pendencia) . ', ' . aspa($ativo) . ')';
                        execsql($sql);
                    }
                }

                $sql = '';
                $sql .= ' select s.idt, s.classificacao';
                $sql .= ' from plu_usuario u';
                $sql .= ' inner join ' . db_pir . 'sca_organizacao_secao s on s.idt = u.idt_unidade_lotacao';
                $sql .= ' where u.id_usuario = ' . null($_POST['idt_colaborador_destino']);
                $rs = execsql($sql);
                $rowc = $rs->data[0];

                $idtSecaoPA = $rowc['idt'];
                $vetCod = explode('.', $rowc['classificacao']);

                //Unidade
                $vetCod[2] = '00';

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
                $rs = execsql($sql);
                $idtSecaoUN = $rs->data[0][0];

                //Diretoria
                $vetCod[1] = '00';

                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from ' . db_pir . 'sca_organizacao_secao';
                $sql .= ' where classificacao = ' . aspa(implode('.', $vetCod));
                $rs = execsql($sql);
                $idtSecaoDI = $rs->data[0][0];

                //Coordenador / Gerente
                $sql = '';
                $sql .= ' select distinct u.id_usuario, u.email, u.nome_completo';
                $sql .= ' from ' . db_pir . 'sca_organizacao_pessoa p';
                $sql .= ' inner join ' . db_pir . 'sca_organizacao_funcao f on f.idt = p.idt_funcao';
                $sql .= ' inner join ' . db_pir_grc . 'plu_usuario u on u.login = p.cod_usuario';
                $sql .= " where f.tipo_alcada_evento = 'CG'";
                $sql .= ' and p.idt_secao in (' . null($idtSecaoPA) . ', ' . null($idtSecaoUN) . ', ' . null($idtSecaoDI) . ')';
                $sql .= " and p.ativo = 'S'";
                $rsCG = execsql($sql);

                //Pendencia para Gerente / Coordenador
                $assunto = aspa($_POST['descricao']);
                $observacao = $assunto;
                $data = aspa(trata_data(date('d/m/Y H:i:s')));
                $data_solucao = aspa(trata_data(date('d/m/Y')));
                $status = 'Solicitação de Aprovação';
                $solucao = 'null';

                foreach ($rsCG->data as $row) {
                    $sql_i = ' insert into grc_atendimento_pendencia (';
                    $sql_i .= ' idt_transferencia_responsabilidade, protocolo, idt_gestor_local, idt_responsavel_solucao,';
                    $sql_i .= ' status, tipo, idt_usuario, data, data_solucao, assunto, observacao, solucao';
                    $sql_i .= ' ) values ( ';
                    $sql_i .= null($vlID) . ', ' . aspa($vlID) . ', ' . null($row['id_usuario']) . ', ' . null($row['id_usuario']) . ', ';
                    $sql_i .= aspa($status) . ", 'Transferência de Responsabilidades', " . null($_SESSION[CS]['g_id_usuario']) . ', ';
                    $sql_i .= "{$data}, {$data_solucao}, {$assunto}, {$observacao}, {$solucao}";
                    $sql_i .= ' )';
                    execsql($sql_i);
                    copiaAtendimentoPendenciaTransResp(lastInsertId());
                }
                break;

            case $bt_alterar_lbl:
                $sql_a = ' update grc_atendimento_pendencia set ';
                $sql_a .= " solucao = " . aspa($_POST['justificativa_reprovacao']) . ",";
                $sql_a .= " idt_usuario_update = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                $sql_a .= " dt_update = now(),";
                $sql_a .= " ativo  =  'N'";
                $sql_a .= ' where idt_transferencia_responsabilidade  = ' . null($vlID);
                $sql_a .= " and ativo  =  'S'";
                $sql_a .= " and tipo   =  'Transferência de Responsabilidades'";
                execsql($sql_a);

                if ($situacao_ant == 'GC' || $situacao_ant == 'CG') {
                    $sql_a = ' update grc_transferencia_responsabilidade set ';
                    $sql_a .= " usuario_etapa_" . mb_strtolower($situacao_ant) . " = " . null($_SESSION[CS]['g_id_usuario']) . ",";
                    $sql_a .= " dt_etapa_" . mb_strtolower($situacao_ant) . " = now()";
                    $sql_a .= ' where idt = ' . null($vlID);
                    execsql($sql_a);
                }

                switch ($_POST['situacao']) {
                    case 'RE':
                        $vetGRC_parametros = GRC_parametros();
                        $assunto = $vetGRC_parametros['grc_transferencia_responsabilidade_01'];
                        $mensagem = $vetGRC_parametros['grc_transferencia_responsabilidade_02'];

                        $assunto = str_replace('#protocolo#', $vlID, $assunto);

                        $mensagem = str_replace('#protocolo#', $vlID, $mensagem);
                        $mensagem = str_replace('#descricao#', $_POST['descricao'], $mensagem);

                        $sql = '';
                        $sql .= ' select nome_completo';
                        $sql .= ' from plu_usuario';
                        $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_origem']);
                        $rs = execsql($sql);
                        $mensagem = str_replace('#colaborador_origem#', $rs->data[0][0], $mensagem);

                        $mensagem = str_replace('#dt_validade#', $_POST['dt_validade'], $mensagem);
                        $mensagem = str_replace('#justificativa#', $_POST['justificativa'], $mensagem);
                        $mensagem = str_replace('#justificativa_reprovacao#', $_POST['justificativa_reprovacao'], $mensagem);

                        $sql = '';
                        $sql .= ' select email, nome_completo';
                        $sql .= ' from plu_usuario';
                        $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_destino']);
                        $rs = execsql($sql);
                        $row = $rs->data[0];

                        $mensagem = str_replace('#colaborador_destino#', $row['nome_completo'], $mensagem);
                        $mensagem = str_replace('#responsavel#', $row['nome_completo'], $mensagem);

                        $vetRegProtocolo = Array(
                            'origem' => 'grc_transferencia_responsabilidade_0102',
                        );
                        enviarEmail(db_pir_grc, $assunto, $mensagem, $row['email'], $row['nome_completo'], true, $vetRegProtocolo);
                        break;

                    case 'CG':
                        $sql = '';
                        $sql .= ' select u.id_usuario, u.email, u.nome_completo';
                        $sql .= ' from plu_usuario u';
                        $sql .= ' inner join plu_perfil p on p.id_perfil = u.id_perfil';
                        $sql .= " where p.trans_resp_aprova_cgp = 'S'";
                        $sql .= " and u.ativo = 'S'";
                        $rsCG = execsql($sql);

                        //Pendencia para Gerente / Coordenador
                        $assunto = aspa($_POST['descricao']);
                        $observacao = $assunto;
                        $data = aspa(trata_data(date('d/m/Y H:i:s')));
                        $data_solucao = aspa(trata_data(date('d/m/Y')));
                        $status = 'Solicitação de Aprovação';
                        $solucao = 'null';

                        foreach ($rsCG->data as $row) {
                            $sql_i = ' insert into grc_atendimento_pendencia (';
                            $sql_i .= ' idt_transferencia_responsabilidade, protocolo, idt_gestor_local, idt_responsavel_solucao,';
                            $sql_i .= ' status, tipo, idt_usuario, data, data_solucao, assunto, observacao, solucao';
                            $sql_i .= ' ) values ( ';
                            $sql_i .= null($vlID) . ', ' . aspa($vlID) . ', ' . null($row['id_usuario']) . ', ' . null($row['id_usuario']) . ', ';
                            $sql_i .= aspa($status) . ", 'Transferência de Responsabilidades', " . null($_SESSION[CS]['g_id_usuario']) . ', ';
                            $sql_i .= "{$data}, {$data_solucao}, {$assunto}, {$observacao}, {$solucao}";
                            $sql_i .= ' )';
                            execsql($sql_i);
                            copiaAtendimentoPendenciaTransResp(lastInsertId());
                        }
                        break;

                    case 'AP':
                        //Copia Pendencia
                        $vetTipo = Array();

                        if ($_POST['chk_evento'] == 'S') {
                            $vetTipo[] = aspa($vetTipoPenTransResp['evento']);
                        }

                        if ($_POST['chk_pag_cred'] == 'S') {
                            $vetTipo[] = aspa($vetTipoPenTransResp['pag_cred']);
                        }

                        if ($_POST['chk_atend'] == 'S') {
                            $vetTipo[] = aspa($vetTipoPenTransResp['atend']);
                        }

                        $sql = '';
                        $sql .= ' select pe.*, r.idt_transferencia_responsabilidade';
                        $sql .= ' from grc_atendimento_pendencia pe';
                        $sql .= " left outer join grc_transferencia_responsabilidade_reg r on r.idt_atendimento_pendencia = pe.idt and r.idt_transferencia_responsabilidade = " . null($vlID);
                        $sql .= ' where pe.idt_responsavel_solucao = ' . null($_POST['idt_colaborador_origem']);
                        $sql .= " and pe.ativo = 'S'";
                        $sql .= " and (r.ativo = 'S' or r.ativo is null)";

                        if (count($vetTipo) == 0) {
                            $sql .= " and 1 = 0";
                        } else {
                            $sql .= ' and pe.tipo in (' . implode(', ', $vetTipo) . ')';
                        }

                        $rsp = execsqlNomeCol($sql);

                        foreach ($rsp->data as $rowp) {
                            $rowp['idt_gestor_local'] = $_POST['idt_colaborador_destino'];
                            $rowp['idt_responsavel_solucao'] = $_POST['idt_colaborador_destino'];
                            $rowp['idt_atendimento_pendencia_trans'] = $rowp['idt'];
                            $rowp['idt_transferencia_responsabilidade'] = $rowp['idt_transferencia_responsabilidade'];
                            $rowp['dt_limite_trans'] = trata_data($_POST['dt_validade']);

                            unset($rowp['idt']);

                            $rowp = array_map('aspa', $rowp);

                            $sql = 'insert into grc_atendimento_pendencia (' . implode(', ', array_keys($rowp)) . ') values (' . implode(', ', $rowp) . ')';
                            execsql($sql);
                        }

                        $vetGRC_parametros = GRC_parametros();
                        $assunto = $vetGRC_parametros['grc_transferencia_responsabilidade_03'];
                        $mensagem = $vetGRC_parametros['grc_transferencia_responsabilidade_04'];

                        $assunto = str_replace('#protocolo#', $vlID, $assunto);

                        $mensagem = str_replace('#protocolo#', $vlID, $mensagem);
                        $mensagem = str_replace('#descricao#', $_POST['descricao'], $mensagem);

                        $sql = '';
                        $sql .= ' select nome_completo';
                        $sql .= ' from plu_usuario';
                        $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_origem']);
                        $rs = execsql($sql);
                        $mensagem = str_replace('#colaborador_origem#', $rs->data[0][0], $mensagem);

                        $mensagem = str_replace('#dt_validade#', $_POST['dt_validade'], $mensagem);
                        $mensagem = str_replace('#justificativa#', $_POST['justificativa'], $mensagem);
                        $mensagem = str_replace('#justificativa_reprovacao#', $_POST['justificativa_reprovacao'], $mensagem);

                        $sql = '';
                        $sql .= ' select email, nome_completo';
                        $sql .= ' from plu_usuario';
                        $sql .= ' where id_usuario = ' . null($_POST['idt_colaborador_destino']);
                        $rs = execsql($sql);
                        $row = $rs->data[0];

                        $mensagem = str_replace('#colaborador_destino#', $row['nome_completo'], $mensagem);
                        $mensagem = str_replace('#responsavel#', $row['nome_completo'], $mensagem);

                        $vetRegProtocolo = Array(
                            'origem' => 'grc_transferencia_responsabilidade_0304',
                        );
                        enviarEmail(db_pir_grc, $assunto, $mensagem, $row['email'], $row['nome_completo'], true, $vetRegProtocolo);
                        break;
                }
                break;

            case $bt_excluir_lbl:
                break;
        }
        break;

    case 'grc_agenda_parametro_suspensao':
        $geral = $_POST['geral'];
        $excluir = $_POST['excluir'];
        $nacional = $_POST['nacional'];
        $sql_a = ' update grc_agenda_parametro_suspensao set ';
        $sql_a .= ' geral   = ' . aspa('') . ',  ';
        $sql_a .= ' excluir = ' . aspa('') . ',  ';
        $sql_a .= ' nacional= ' . aspa('') . '  ';
        $sql_a .= ' where idt = ' . null($vlID);
        $result = execsql($sql_a);
        $data = $_POST['data'];
        $observacao = $_POST['observacao'];
        $idt_grc_agenda_parametro_suspensao = $vlID;



        if ($geral == 'S' and ( $acao == 'alt')) {
            GerarTodosPAALT($idt_grc_agenda_parametro_suspensao, $data, $observacao);
        }

        if ($geral == 'S' and ( $acao == 'inc')) {
            GerarTodosPA($idt_grc_agenda_parametro_suspensao, $data, $observacao);
        }

        //if ($excluir == 'S' and $geral == 'S' and $acao=='exc') {
        if ($geral == 'S' and $acao == 'exc') {
            //echo " to indo <br>";
            ExcluirTodosPA($idt_grc_agenda_parametro_suspensao, $data, $observacao);
            //exit();
        }
        if ($nacional == 'S' and $acao == 'alt') {
            $sql = 'select ';
            $sql .= '   idt, descricao  ';
            $sql .= ' from ' . db_pir . 'sca_organizacao_secao sac_os ';
            $sql .= " where posto_atendimento = 'UR' or posto_atendimento = 'S' ";
            $sql .= ' order by classificacao ';
            $rst = execsql($sql);
            if ($rst->rows > 0) {
                foreach ($rst->data as $row) {
                    $idt_ponto_atendimento = $row['idt'];
                    //
                    // Inserir datas feriados nacionais e sábados e domingos
                    //
					InserirSuspanesaoNacionais($idt_ponto_atendimento);
                }
            }
        }
        break;

    case 'grc_atendimento_especialidade_produto':
        if ($_POST['idorg'] == -1) {
            $vetSel = $_SESSION[CS]['objListarCmbMulti'][$_POST['idt_produto']]['sel_final'];

            foreach ($vetSel as $dados) {
                $sql = '';
                $sql .= ' select idt';
                $sql .= ' from grc_atendimento_especialidade_produto';
                $sql .= ' where idt_atendimento_especialidade = ' . null($_POST['idt_atendimento_especialidade']);
                $sql .= ' and idt_produto = ' . aspa($dados['idt']);
                $rst = execsql($sql);

                if ($rst->rows == 0) {
                    $sql = 'insert into grc_atendimento_especialidade_produto (idt_atendimento_especialidade, idt_produto, ';
                    $sql .= 'observacao, data_registro, idt_responsavel) values (';
                    $sql .= null($_POST['idt_atendimento_especialidade']) . ', ' . aspa($dados['idt']) . ', ' . aspa($_POST['observacao']) . ', ';
                    $sql .= aspa(trata_data($_POST['data_registro'])) . ', ' . aspa($_POST['idt_responsavel']) . ')';
                    execsql($sql);
                }
            }
        }
        break;

    case 'grc_atendimento_especialidade':
        $opcoes_escolher = $_POST['opcoes_escolher'];
        $opcoes_escolher = str_replace('[', '', $opcoes_escolher);
        $opcoes_escolher = str_replace(']', '', $opcoes_escolher);
        $vet = explode(';', $opcoes_escolher);
        $idt_especialidade = $vlID;
        if ($acao == "inc" or $acao == "alt" or $acao == "exc") {
            //
            // Excluir e gravar novos
            //
			$sql_d = 'delete from grc_atendimento_especialidade_duracao ';
            $sql_d .= ' where idt_especialidade = ' . null($vlID);

            $result = execsql($sql_d);
        }


        if ($acao == "inc" or $acao == "alt") {
            ForEach ($vet as $Indice => $Duracao) {
                // 
                $sql_i = " insert into grc_atendimento_especialidade_duracao ";
                $sql_i .= " (  ";
                $sql_i .= " idt_especialidade, ";
                $sql_i .= " duracao ";
                $sql_i .= "  ) values ( ";
                $sql_i .= " $idt_especialidade, ";
                $sql_i .= " $Duracao ";
                $sql_i .= ") ";
                $result = execsql($sql_i);
            }
        }
        break;

    case 'grc_atendimento_pa_pessoa_servico':
        //p($_POST);
        //exit();

        $vet = Array();

        $id_pa_pessoa = $_POST['idt_pa_pessoa'];
        // exit();
        $menorvalor = CalculaMediaAtendimento($id_pa_pessoa);
        $vet['duracao'] = $menorvalor;

        $returnVal = json_encode($vet);
        ?>
        <script type="text/javascript">
            returnVal = <?php echo $returnVal; ?>;
        </script>
        <?php
        break;




    case 'grc_comunicacao':
        $sql = 'update grc_comunicacao set ';
        $sql .= " flag_logico = 'A' ";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);
        //

        if ($SMS == 0) {
            $vetParametros['idt_comunicacao'] = $vlID;
            SincronizaComunicacao($vetParametros);

            if ($acao == 'alt' or $acao == 'ins') {
                if ($vetParametros['erro'] == 1) {
                    echo "<script>";
                    echo ' var msg = "Sua comunicação foi enviada com sucesso! Por gentileza, aguardar retorno do Cliente.";';
                    echo " alert(msg); ";
                    echo "</script>";
                } else {
                    $msg_erro = $vetParametros['msg_erro'];
                    echo "<script>";
                    //echo " var msg = '".''."\n"."O EMAIL DE REGISTRO NÃO PODE SER ENVIADO"."\n"."Mas, sua solicitação foi cadastrada com sucesso!"."\n"." Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.';";
                    echo ' var msg = "O EMAIL DE REGISTRO NÃO PODE SER ENVIADO. Sua comunicação foi cadastrada com sucesso! Por gentileza, aguardar retorno da equipe de suporte técnico para dar continuidade a este atendimento.";';
                    echo " alert(msg); ";
                    echo "</script>";
                }
            }
        } else {
            echo "<script>";
            echo ' var msg = "Seu SMS foi enviado com sucesso";';
            echo " alert(msg); ";
            echo "</script>";
        }
        break;

    case 'plu_helpdesk_interacao':
        $sql = 'update plu_helpdesk_interacao set ';
        $sql .= " flag_logico = 'A' ";
        $sql .= ' where idt = ' . null($vlID);
        execsql($sql);
        //
        $vetParametros['idt_helpdesk_interacao'] = $vlID;
        SincronizaDeskInteracaoSebrae($vetParametros);
        break;

    case 'grc_agenda_parametro':
        $geral = $_POST['geral'];
        // 01
        $envia_sms_confirmacao = $_POST['envia_sms_confirmacao'];
        $prazo_sms_confirmacao = $_POST['prazo_sms_confirmacao'];
        $texto_sms_confirmacao = $_POST['texto_sms_confirmacao'];
        $ativo = $envia_sms_confirmacao;
        $descricao = $texto_sms_confirmacao;
        $prazo = $prazo_sms_confirmacao;
        $sql = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
        $sql .= " where grc_ps.idt = {$prazo} ";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $prazo = trim($row['codigo']);
        }

        $quando = "D";
        if ($prazo == 0) {
            $quando = "E";
        }
        $sql_a = ' update grc_agenda_emailsms_processo set ';
        $sql_a .= ' ativo        = ' . aspa($ativo) . ',  ';
        $sql_a .= ' prazo        = ' . null($prazo) . ',  ';
        $sql_a .= ' quando       = ' . aspa($quando) . '  ';
        $sql_a .= ' where codigo = ' . aspa('90.01');
        $result = execsql($sql_a);
        if ($descricao != "") {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' descricao    = ' . aspa($descricao) . '  ';
            $sql_a .= ' where codigo = ' . aspa('90.01');
            $result = execsql($sql_a);
        }

        // 02
        $envia_sms_cancelamento = $_POST['envia_sms_cancelamento'];
        $prazo_sms_cancelamento = $_POST['prazo_sms_cancelamento'];
        $texto_sms_cancelamento = $_POST['texto_sms_cancelamento'];

        $ativo = $envia_sms_cancelamento;
        $descricao = $texto_sms_cancelamento;
        $prazo = $prazo_sms_cancelamento;
        $sql = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
        $sql .= " where grc_ps.idt = {$prazo} ";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $prazo = trim($row['codigo']);
        }
        $quando = "D";
        if ($prazo == 0) {
            $quando = "E";
        }
        $sql_a = ' update grc_agenda_emailsms_processo set ';
        $sql_a .= ' ativo        = ' . aspa($ativo) . ',  ';
        $sql_a .= ' prazo        = ' . null($prazo) . ',  ';
        $sql_a .= ' quando       = ' . aspa($quando) . '  ';
        $sql_a .= ' where codigo = ' . aspa('90.02');
        $result = execsql($sql_a);
        if ($descricao != "") {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' descricao    = ' . aspa($descricao) . '  ';
            $sql_a .= ' where codigo = ' . aspa('90.02');
            $result = execsql($sql_a);
        }

        // 03
        $envia_sms_vespera = $_POST['envia_sms_vespera'];
        $prazo_sms_vespera = $_POST['prazo_sms_vespera'];
        $texto_sms_vespera = $_POST['texto_sms_vespera'];

        $ativo = $envia_sms_vespera;
        $descricao = $texto_sms_vespera;
        $prazo = $prazo_sms_vespera;
        $sql = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
        $sql .= " where grc_ps.idt = {$prazo} ";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $prazo = trim($row['codigo']);
        }
        $quando = "A";
        if ($prazo == 0) {
            $quando = "E";
        }
        $sql_a = ' update grc_agenda_emailsms_processo set ';
        $sql_a .= ' ativo        = ' . aspa($ativo) . ',  ';
        $sql_a .= ' prazo        = ' . null($prazo) . ',  ';
        $sql_a .= ' quando       = ' . aspa($quando) . '  ';
        $sql_a .= ' where codigo = ' . aspa('90.03');
        $result = execsql($sql_a);
        if ($descricao != "") {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' descricao    = ' . aspa($descricao) . '  ';
            $sql_a .= ' where codigo = ' . aspa('90.03');
            $result = execsql($sql_a);
        }






        // 04
        $envia_sms_agradecimento = $_POST['envia_sms_agradecimento'];
        $prazo_sms_agradecimento = $_POST['prazo_sms_agradecimento'];
        $texto_sms_agradecimento = $_POST['texto_sms_agradecimento'];
        $ativo = $envia_sms_agradecimento;
        $descricao = $texto_sms_agradecimento;
        $prazo = $prazo_sms_agradecimento;
        $quando = "D";

        $sql = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
        $sql .= " where grc_ps.idt = {$prazo} ";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $prazo = trim($row['codigo']);
        }



        if ($prazo == 0) {
            $quando = "E";
        }
        $sql_a = ' update grc_agenda_emailsms_processo set ';
        $sql_a .= ' ativo        = ' . aspa($ativo) . ',  ';
        $sql_a .= ' prazo        = ' . null($prazo) . ',  ';
        $sql_a .= ' quando       = ' . aspa($quando) . '  ';
        $sql_a .= ' where codigo = ' . aspa('90.04');
        $result = execsql($sql_a);
        if ($descricao != "") {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' descricao    = ' . aspa($descricao) . '  ';
            $sql_a .= ' where codigo = ' . aspa('90.04');
            $result = execsql($sql_a);
        }




        // 05
        $envia_sms_cancelamento_sebrae = $_POST['envia_sms_cancelamento_sebrae'];
        $prazo_sms_cancelamento_sebrae = $_POST['prazo_sms_cancelamento_sebrae'];
        $texto_sms_cancelamento_sebrae = $_POST['texto_sms_cancelamento_sebrae'];

        $ativo = $envia_sms_cancelamento_sebrae;
        $descricao = $texto_sms_cancelamento_sebrae;
        $prazo = $prazo_sms_cancelamento_sebrae;
        $sql = "select idt, codigo, descricao from grc_prazo_sms grc_ps ";
        $sql .= " where grc_ps.idt = {$prazo} ";
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $prazo = trim($row['codigo']);
        }
        $quando = "D";
        if ($prazo == 0) {
            $quando = "E";
        }
        $sql_a = ' update grc_agenda_emailsms_processo set ';
        $sql_a .= ' ativo        = ' . aspa($ativo) . ',  ';
        $sql_a .= ' prazo        = ' . null($prazo) . ',  ';
        $sql_a .= ' quando       = ' . aspa($quando) . '  ';
        $sql_a .= ' where codigo = ' . aspa('90.05');
        $result = execsql($sql_a);
        if ($descricao != "") {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' descricao    = ' . aspa($descricao) . '  ';
            $sql_a .= ' where codigo = ' . aspa('90.05');
            $result = execsql($sql_a);
        }
        // Carregar Parametros em memória
        CarregaParametrosGeraisAgendamento();

        //
//grc_parametros_agendamento
        break;
    case 'grc_agenda_emailsms':
        $padrao = $_POST['padrao'];
        //p($_POST);
        //exit();
        if ($padrao == 'S') {
            $sql_a = ' update grc_agenda_emailsms set ';
            $sql_a .= ' padrao = ' . aspa('N') . '  ';
            $sql_a .= ' where idt <> ' . null($vlID);
            $result = execsql($sql_a);
        }
        break;
}
