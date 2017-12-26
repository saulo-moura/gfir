<?php
Require_Once('../configuracao.php');

switch ($_GET['tipo']) {
    case 'erro_log':
        $sql = 'select objeto, vget, vpost, vserver, vsession, vfiles, inf_extra from plu_erro_log where idt = '.null($_GET['idt']);
        $rs = execsql($sql);
        $row = $rs->data[0];

        echo 'Erro:<br />';
        echo p(unserialize(base64_decode($row['objeto'])));
        echo 'Informações Extras:<br />';
        echo p(unserialize(base64_decode($row['inf_extra'])));
        echo 'GET:<br />';
        echo p(unserialize(base64_decode($row['vget'])));
        echo 'POST:<br />';
        echo p(unserialize(base64_decode($row['vpost'])));
        echo 'SERVER:<br />';
        echo p(unserialize(base64_decode($row['vserver'])));
        echo 'FILES:<br />';
        echo p(unserialize(base64_decode($row['vfiles'])));
        echo 'SESSION:<br />';
        echo p(unserialize(base64_decode($row['vsession'])));
        break;


    case 'obra':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $_SESSION[CS]['g_idt_obra'] = $idt_obra;
        $_SESSION[CS]['g_nm_obra'] = $nm_obra;

        $sql = "select em.idt, em.imagem  from empreendimento em  ";
        $sql .= " where idt = ".null($idt_obra);
        $result = execsql($sql);
        $row = $result->data[0];
        $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];






        break;


    case 'alterar_senha':
    case 'login':

        $msg = '';
        unset($_SESSION[CS]);

        // $_POST['login']=$_GET['login'];
        // $_POST['senha']=$_GET['senha'];

        $_POST['login'] = rawurldecode($_POST['login']);
        $_POST['senha'] = rawurldecode($_POST['senha']);

        if ($_POST['login'] != '' && $_POST['senha'] != '') {
            // if (substr(mb_strtolower(trim($_POST['login'])), -23, 23) != '@oasempreendimentos.com')
            //     $_POST['login'] .= '@oasempreendimentos.com';

            $sql = "select * from plu_usuario where login = ".aspa($_POST['login'])." and senha = ".aspa(md5($_POST['senha']));
            $result = execsql($sql);
            $row = $result->data[0];

            // echo' 1111111111111111';
            if ($result->rows == 0) {
                $msg = "Usuário e/ou senha inválidos.<br><br>Tente de novo.";
            } else if ($row['ativo'] == 'N') {
                $msg = "Usuário não esta ativo!<br>Para maiores informações<br>procurar o Administrador do sistema.";
//            } else if ($row['ativo_pir'] == 'N') {
  //              $msg = "Usuário não esta ativo no sistema PIR!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
                $msg = "O seu acesso expirou em ".trata_data($row['dt_validade'])."!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '') {
                $msg = "O seu acesso só vai esta liberado em ".trata_data($row['dt_validade_inicio'])."!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            } else {
                $_SESSION[CS]['g_s_slv'] = $_POST['senha'];
                carregaSession($row['id_usuario']);

                $tabela = "plu_usuario";
                $id_lo = $_SESSION[CS]['g_id_usuario'];
                $desc_log = "Efetuado Login para ".$_SESSION[CS]['g_login'].' de '.$_SESSION[CS]['g_nome_completo'];
                $nom_tabela = "Login Site sebrae.GRC";
                grava_log_sis($tabela, 'L', $id_lo, $desc_log, $nom_tabela);
            }

            if ($msg != '') {
                echo ($msg);
                //  echo rawurlencode($msg);
            }


            $_SESSION[CS]['alterar_senha'] = 'N';
            if ($_GET['tipo'] == 'alterar_senha') {

                // entrar para alterar a senha
                $_SESSION[CS]['alterar_senha'] = 'S';
            }
        } else {
            //  echo rawurlencode(' sem inf ');
        }
        //  echo (' fim...... ');
        //   exit();
        //p($_SESSION[CS]);

        break;



    case 'gerar_demonstrativo':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('demonstrativo', "'INC'")) {
            $sql = 'select ';
            $sql .= '  de.*, ';
            $sql .= '  pc.tipo_conta as pc_tipo_conta,  ';
            $sql .= '  pc.descricao  as pc_descricao  ';
            $sql .= 'from demonstrativo de ';
            $sql .= 'inner join periodo peri on peri.idt  = de.idt_periodo ';
            $sql .= 'inner join plano_contas pc on pc.idt = de.idt_conta ';
            $sql .= 'where ';
            $sql .= '      de.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  de.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                copia_plano_contas(null($idt_obra), null($idt_periodo));
            }
        }

        break;

    case 'excluir_demonstrativo':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('demonstrativo', "'EXC'")) {
            $sql = 'select ';
            $sql .= '  de.* ';
            $sql .= 'from demonstrativo de ';
            $sql .= 'where ';
            $sql .= '      de.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  de.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows != 0) {
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $sql_e = ' delete from demonstrativo ';
                    $sql_e .= ' where idt = '.null($idt);
                    $result = execsql($sql_e);
                }
            }
        }

        break;

    case 'gerar_imobilizado':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('imobilizado', "'INC'")) {
            $sql = 'select ';
            $sql .= '  ai.* ';
            $sql .= 'from administrativo_item ai ';
            $sql .= 'where ';
            $sql .= '      ai.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  ai.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                copia_imobilizado(null($idt_obra), null($idt_periodo));
            }
        }
        break;
    case 'excluir_imobilizado':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('demonstrativo', "'INC'")) {
            $sql = 'select ';
            $sql .= '  ai.* ';
            $sql .= 'from administrativo_item ai ';
            $sql .= 'where ';
            $sql .= '      ai.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  ai.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows != 0) {
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $sql_e = ' delete from administrativo_item ';
                    $sql_e .= ' where idt = '.null($idt);
                    $result = execsql($sql_e);
                }
            }
        }

        break;

    case 'gerar_rotatividade':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('rotatividade', "'INC'")) {
            $sql = 'select ';
            $sql .= '  ro.* ';
            $sql .= 'from rotatividade ro ';
            $sql .= 'where ';
            $sql .= '      ro.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  ro.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                copia_rotatividade(null($idt_obra), null($idt_periodo));
            }
        }
        break;
    case 'excluir_rotatividade':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('demonstrativo', "'INC'")) {
            $sql = 'select ';
            $sql .= '  ro.* ';
            $sql .= 'from rotatividade ro ';
            $sql .= 'where ';
            $sql .= '      ro.idt_empreendimento = '.null($idt_obra);
            $sql .= ' and  ro.idt_periodo = '.null($idt_periodo);
            $rs = execsql($sql);
            if ($rs->rows != 0) {
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $sql_e = ' delete from rotatividade ';
                    $sql_e .= ' where idt = '.null($idt);
                    $result = execsql($sql_e);
                }
            }
        }

        break;

    case 'exportar_torre':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('empreendimento_parametros', "'INC'")) {
            exportar_torre(null($idt_obra));
        }
        break;
    case 'importar_torre':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('empreendimento_parametros', "'INC'")) {
            importar_torre(null($idt_obra));
        }
        break;

    case 'pert':
        $valorw = $_POST['valorw'];
        $prev_gw = $_POST['prev_gw'];
        $idt_gw = $_POST['idt_gw'];

        $idt_servico_obra_mes = $idt_gw;
        $flag_valor = $prev_gw;
        $valor = $valorw;
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);

        if ($valor != '') {
            $sql_a = ' update servico_obra_mes_valor set ';
            $sql_a .= ' valor = '.$valor.'  ';
            $sql_a .= ' where idt_servico_obra_mes = '.null($idt_gw);
            $sql_a .= '   and flag_valor           = '.aspa($flag_valor);
            $result = execsql($sql_a);
        }

        // CALCULAR VALOR DA LINHA, SERVIÇO E MES...
        $servico = '';
        $anomes = '';
        $valor_linha = 0;
        $ret = calcula_valor_linha_gantt(null($idt_gw), $flag_valor, $servico, $anomes, $valor_linha);
        $valor_linhaw = format_decimal($valor_linha);
        // $sd  = "Serviço     : {$servico}      <br>";
        // $sd .= "Mês-Ano     : {$anomes}       <br>";
        // $sd .= "Valor linha : {$valor_linhaw} <br>";
        $sd = "{$servico}      <br>";
        $sd .= "{$anomes}       <br>";
        $sd .= "{$valor_linhaw} <br>";

        echo $sd;

        //echo $sql_a;
        break;

    case 'pert_mostra':
        $valorw = $_POST['valorw'];
        $prev_gw = $_POST['prev_gw'];
        $idt_gw = $_POST['idt_gw'];
        $idt_servico_obra_mes = $idt_gw;
        $flag_valor = $prev_gw;
        $valor = $valorw;
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        /*
          if ($valor!='')
          {
          $sql_a = ' update servico_obra_mes_valor set ';
          $sql_a .= ' valor = '.$valor.'  ';
          $sql_a .= ' where idt_servico_obra_mes = '.null($idt_gw);
          $sql_a .= '   and flag_valor           = '.aspa($flag_valor);
          $result = execsql($sql_a);
          }
         */
        // CALCULAR VALOR DA LINHA, SERVIÇO E MES...
        $servico = '';
        $anomes = '';
        $valor_linha = 0;
        $ret = calcula_valor_linha_gantt(null($idt_gw), $flag_valor, $servico, $anomes, $valor_linha);
        $valor_linhaw = format_decimal($valor_linha);
        $sd = "Serviço     : {$servico}      <br>";
        $sd .= "Mês-Ano     : {$anomes}       <br>";
        $sd .= "Valor linha : {$valor_linhaw} <br>";
        echo $sd;
        //echo $sql_a;
        break;


    case 'calcular_gantt':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        //p(' vvvvv '.$idt_obra);
        if (tem_direito('servico_obra', "'INC'")) {
            copia_servico_obra(null($idt_obra));
            $vet = carregar_vetor_cronograma(null($idt_obra), 'G');
            //   $vethtml  = carregar_vetor_cronograma_html($_SESSION[CS]['g_idt_obra'],$vet,'S');
            //
          //  echo 'Término NORMAL dos Cálculos do Gráfico de Gantt';
        } else {
            //  echo 'Término ANORMAL dos Cálculos do Gráfico de Gantt';
        }
        break;

    case 'exportar_obra_residuo_quantidade':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        //    if (tem_direito('ma_obra_residuo_quantidade', "'INC'"))
        //    {
        exportar_obra_residuo_quantidade(null($idt_obra));
        //    }
        break;
    case 'importar_obra_residuo_quantidade':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        if (tem_direito('ma_obra_residuo_quantidade', "'INC'")) {
            importar_obra_residuo_quantidade(null($idt_obra));
        }
        break;



    case 'copiar_efetivo_atual':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        $dt_destino = $_POST['dt_destino'];
        if (tem_direito('pessoal_efetivo', "'INC'")) {
            copiar_efetivo_atual(null($idt_obra), $dt_destino);
        }
        break;
    case 'excluir_efetivo_atual':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        $dt_destino = $_POST['dt_destino'];
        if (tem_direito('pessoal_efetivo', "'INC'")) {
            excluir_efetivo_atual(null($idt_obra), $dt_destino);
        }
        break;


    case 'help_campo':
        $tabelaw = utf8_decode($_POST['tabelaw']);
        $campow  = utf8_decode($_POST['campow']);
        $descricaow = utf8_decode($_POST['descricaow']);
        if (tem_direito('plu_usuario', "'INC'")) {
            $resumow = '';
            $textow = '';
            help_campo($tabelaw, $campow, $resumow, $textow, $descricaow);
            echo $resumow.'######'.$textow.'######'.$descricaow.'######';
        }
		
        break;



    case 'upload_gsd':
        $idt_catw = $_POST['idt_catw'];
        $arq_catw = $_POST['arq_catw'];
        $tabelaw = $_POST['tabelaw'];
        $campow = $_POST['campow'];
        if (tem_direito('st_acidente', "'INC'")) {
            $ret = upload_gsd($tabelaw, $arq_catw, $idt_catw, $campow);
            echo $ret;
            // if ($ret==0)
            // {
            //     echo 'Erro de Upload ';
            // }
        }
        break;

    case 'inclui_acidente':
        $idt_catw = $_POST['idt_catw'];
        $arq_catw = $_POST['arq_catw'];
        $acaow = $_POST['acaow'];
        $idt_empreendimentow = $_POST['idt_empreendimentow'];


        $vet_erro = Array();
        if (tem_direito('st_acidente', "'INC'")) {
            $ret = inclui_acidente($idt_empreendimentow, $idt_catw, $arq_catw, $acaow, $vet_erro);
            if ($ret == 0) {
                //  $vet_erro['erro']='Erro de Upload';
                //  $vet_erro['acidente']=$vet_acidente;
                echo $vet_erro['erro'];
            }
        }
        break;

    case 'altera_acidente':
        $idt_catw = $_POST['idt_catw'];
        $arq_catw = $_POST['arq_catw'];
        $acaow = $_POST['acaow'];
        $idt_empreendimentow = $_POST['idt_empreendimentow'];
        $vet_erro = Array();
        if (tem_direito('st_acidente', "'ALT'")) {
            $ret = inclui_acidente($idt_empreendimentow, $idt_catw, $arq_catw, $acaow, $vet_erro);
            if ($ret == 0) {
                //  $vet_erro['erro']='Erro de Upload';
                //  $vet_erro['acidente']=$vet_acidente;
                echo $vet_erro['erro'];
            }
        }
        break;

    case 'copiar_indices':
        $idt_periodo_a_copiar = $_POST['idt_periodo_a_copiar'];
        $nm_periodo_a_copiar = $_POST['nm_periodo_a_copiar'];
        if (tem_direito('indices', "'INC'")) {
            copiar_indices(null($idt_periodo_a_copiar), $nm_periodo_a_copiar);
        }
        break;
    case 'copiar_indices_anteriores':
        $idt_periodo_a_copiar = $_POST['idt_periodo_a_copiar'];
        $nm_periodo_a_copiar = $_POST['nm_periodo_a_copiar'];
        if (tem_direito('indices', "'INC'")) {
            tabela_indice_anteriores(null($idt_periodo_a_copiar), $nm_periodo_a_copiar);
        }
        break;


    case 'buscar_comentario_gantt':
        $idt_obra = $_POST['idt_obra'];
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];
        //  echo ' ajax ';
        // if (tem_direito('servico_obra_mes_resumo', "'INC'"))
        // {
        $idt_somr = '';
        $observacao = '';
        //  echo ' entrar ';
        $kokw = buscar_comentario_gantt(null($idt_obra), $mes, $ano, $idt_somr, $observacao);
        if ($kokw == 1) {

            $ret = $idt_somr.'###'.$observacao;
            echo $ret;
        }
        // }
        break;

    case 'atualizar_comentario_gantt':
        $idt_registro = $_POST['idt_registro'];
        $observacao = utf8_decode($_POST['observacao']);
        // if (tem_direito('servico_obra_mes_resumo', "'INC'"))
        // {
        //echo ' entrar ';
        $kokw = atualiza_comentario_gantt($idt_registro, $observacao);
        if ($kokw == 1) {
            //  $ret=$idt_somr.'###'.$observacao;
            //  echo $ret;
        }
        // }
        break;


    case 'copia_assina_controle_menu':
        $idt0 = $_POST['idt0w'];
        $nm_idt0 = $_POST['nm_idt0w'];
        $idt1 = $_POST['idt1w'];
        $nm_idt1 = $_POST['nm_idt1w'];
        //   if (tem_direito('copia_assina_controle_menu', "'INC'"))
        //   {
        copia_assina_controle_menu(null($idt0), null($idt1));
        //   }


        break;

    case 'esqueci_senha':
        $msg = '';

        $sql = "select id_usuario, nome_completo, email, ativo, dt_validade, dt_validade_inicio, ldap from plu_usuario where login = ".aspa($_POST['login']);
        $result = execsql($sql);
        $row = $result->data[0];

        if ($result->rows == 0) {
            $msg = "Usuário não esta registrado no sistema!";
        } else if ($row['ldap'] == 'S') {
            $msg = "Usuário esta usando a senha do AD, com isso não pode usar o 'Esqueci minha senha'!";
        } else if ($row['ativo'] == 'N') {
            $msg = "Usuário não esta ativo!";
//        } else if ($row['ativo_pir'] == 'N') {
  //          $msg = "Usuário não esta ativo no sistema PIR!";
        } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
            $msg = "O acesso expirou em ".trata_data($row['dt_validade'])."!";
        } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '') {
            $msg = "O seu acesso só vai esta liberado em ".trata_data($row['dt_validade_inicio'])."!";
        } else if ($row['email'] == '') {
            $msg = "Este usuário não tem email cadastrado! Por isso não podemos enviar uma nova senha.\\n\\nFavor entrar em contado com o administrador do sistema";
        } else {
            $cod = md5($row['id_usuario']);
            $cod = base64_encode(GerarStr().$cod.GerarStr());

            $Body = '';
            $Body .= 'Prezado '.$row['nome_completo'].',<br /><br />';
            $Body .= 'Conforme solicitado, segue o link para receber uma nova senha de acesso ao sistema.<br /><br />';
            $Body .= '<a href="'.url.'esqueci_senha.php?cod='.$cod.'" target="_blank">Trocar a Senha</a>';

            $assunto = "[{$sigla_site}] Confirmação para a troca da senha";

            Require_Once('PHPMailer/class.phpmailer.php');
            Require_Once('PHPMailer/class.smtp.php');

            $mail = new PHPMailer();

            $mail->IsSMTP();
            $mail->Host = $vetConf['host_smtp'];
            $mail->Port = $vetConf['port_smtp'];
            $mail->Username = $vetConf['login_smtp'];
            $mail->Password = $vetConf['senha_smtp'];
            $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
            $mail->SMTPSecure = $vetConf['smtp_secure'];

            $mail->From = $vetConf['email_envio'];
            $mail->FromName = $nome_site;

            $mail->AddReplyTo($vetConf['email_site'], $nome_site);

            $mail->Subject = $assunto;
            $mail->Body = $Body;
            $mail->AltBody = $Body;

            $mail->IsHTML(true);

            $mail->AddAddress($row['email'], $row['nome_completo']);

            try {
                if ($mail->Send()) {
                    $msg = "A confirmação para troca da senha foi enviada para o email: ".mb_strtoupper(trunca_email($row['email']));
                } else {
                    $msg = "Erro na transmissão.\\nTente outra vez!\\n\\n".trata_aspa($mail->ErrorInfo);
                }
            } catch (Exception $e) {
                $msg = 'O Sistema encontrou problemas para enviar seu e-mail. '.$e->getMessage();
            }
        }

        echo rawurlencode($msg);
        break;
}
