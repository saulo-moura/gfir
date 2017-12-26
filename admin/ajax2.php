<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);
Require_Once('configuracao.php');

switch ($_GET['tipo']) {
    case 'erro_log':
        $sql = 'select objeto from plu_erro_log where idt = ' . null($_GET['idt']);
        $rs = execsql($sql);
        echo p(unserialize(base64_decode($rs->data[0][0])));
        break;
    /*
      case 'obra':
      $idt_obra                   = $_POST['idt_obra'];
      $nm_obra                    = $_POST['nm_obra'];
      $_SESSION[CS]['g_idt_obra'] = $idt_obra;
      $_SESSION[CS]['g_nm_obra']  = $nm_obra;
      break;

     */

    case 'obra':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $_SESSION[CS]['g_idt_obra'] = $idt_obra;
        $_SESSION[CS]['g_nm_obra'] = $nm_obra;

        $_SESSION[CS]['g_pri_vez_log'] = 0;

        $_SESSION[CS]['g_strMenuJS'] = '';




        $sql = "select 	      ";
        $sql .= "     em.*       ";
        $sql .= " from empreendimento em ";
        $sql .= " where idt = " . $_SESSION[CS]['g_idt_obra'];
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $path = $dir_file . '/empreendimento/';
            $_SESSION[CS]['g_path_logo_obra'] = $path;
            $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
            $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
            $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
            $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];
            $vetper = Array();

            $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];
            $_SESSION[CS]['g_ativo'] = $row['ativo'];



            //$vetper[]=' guy 1';
            $_SESSION[CS]['g_periodo_obra'] = '';
            // $vetper = calculaperiodoobra($row,1);
            $_SESSION[CS]['g_periodo_obra'] = $vetper;
            // $vetper = calculaperiodoobra($row,2);
            $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

            //     menu_obra($_SESSION[CS]['g_idt_obra']);
            $_SESSION[CS]['g_pri_vez_log'] = 0;
        }

        // {
        //     $_SESSION[CS]['g_idt_obra'] = '';
        // }

        break;





    case 'alterar_senha':
    case 'login':
        $msg = '';

        unset($_SESSION[CS]);
        $_SESSION[CS]['ajax_alt'] = 0;

        $_POST['login'] = rawurldecode($_POST['login']);
        $_POST['senha'] = rawurldecode($_POST['senha']);

        if ($_POST['login'] == '' || $_POST['senha'] == '') {
            $msg = "[03] Usuário e/ou senha inválidos.<br><br>Tente de novo.";
        } else {
            $senha = true;

            $sql = "select ldap from plu_usuario where login = " . aspa($_POST['login']);
            $result = execsql($sql);

            if ($result->data[0][0] == 'S') {
                if ($_GET['tipo'] == 'alterar_senha') {
                    $msg = "Usuário esta usando a senha do AD, com isso não pode usar o 'Quero alterar minha senha'!";
                } else {
                    $num_erro = error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

                    $cnx = ldap_connect(ldap_host, 389);

                    if ($cnx == false) {
                        $msg = "Não foi possível fazer a conexão com o servidor AD!<br><br>Tente de novo.";
                    } else {
                        set_time_limit(600);

                        ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);

                        if (ldap_bind($cnx, utf8_encode($_POST['login'] . ldap_usuario_dominio), utf8_encode($_POST['senha'])) == false) {
                            $number_error = '';
                            ldap_get_option($cnx, LDAP_OPT_ERROR_NUMBER, $number_error);

                            $extended_error = '';
                            ldap_get_option($cnx, LDAP_OPT_ERROR_STRING, $extended_error);

                            erro_try("[$number_error] $extended_error", 'ldap', 'Login: ' . $_POST['login'] . ldap_usuario_dominio);

                            if ($number_error == 49 && !empty($extended_error)) {
                                $errno = explode(',', $extended_error);
                                $errno = $errno[2];
                                $errno = explode(' ', $errno);
                                $errno = $errno[2];

                                if ($vetErroLDAP[$errno] != '') {
                                    $extended_error = $vetErroLDAP[$errno];
                                }
                            }

                            $msg = "Erro na consulta ao AD!<br>[$number_error] $extended_error";
                        }

                        ldap_close($cnx);
                        $senha = false;
                    }

                    error_reporting($num_erro);
                }
            }

            if ($msg == '') {
                $sql = "select * from plu_usuario where login = " . aspa($_POST['login']);

                if ($senha) {
                    $sql .= " and senha = " . aspa(md5($_POST['senha']));
                }

                $result = execsql($sql);
                $row = $result->data[0];

                if ($result->rows == 0) {
                    $msg = "[02] Usuário e/ou senha inválidos.<br><br>Tente de novo.";
                } else if ($row['ativo'] == 'N' && $pdca != 'S') {
                    $msg = "Usuário não esta ativo!<br>Para maiores informações<br>procurar o Administrador do sistema.";
//                } else if ($row['ativo_pir'] == 'N' && $pdca != 'S') {
                    //                  $msg = "Usuário não esta ativo no sistema PIR!<br>Para maiores informações<br>procurar o Administrador do sistema.";
//                } else if ($row['gerenciador'] == 'N' && $pdca != 'S') {
//                    $msg = "Usuário não tem permissão de acessar esta área!<br>Para maiores informações<br>procurar o Administrador do sistema.";
                } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '' && $pdca != 'S') {
                    $msg = "O seu acesso expirou em " . trata_data($row['dt_validade']) . "!<br>Para maiores informações<br>procurar o Administrador do sistema.";
                } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '' && $pdca != 'S') {
                    $msg = "O seu acesso só vai esta liberado em " . trata_data($row['dt_validade_inicio']) . "!<br>Para maiores informações<br>procurar o Administrador do sistema.";
                } else {
                    $_SESSION[CS]['g_s_slv'] = $_POST['senha'];
                    carregaSession($row['id_usuario']);

                    $_SESSION[CS]['aviso_tovivo'] = $vetConf['to_vivo'];

                    $tabela = "plu_usuario";
                    $id_lo = $_SESSION[CS]['g_id_usuario'];
                    $desc_log = "Efetuado Login para " . $_SESSION[CS]['g_login'] . ' de ' . $_SESSION[CS]['g_nome_completo'];
                    $nom_tabela = "Login GC GRC";
                    grava_log_sis($tabela, 'L', $id_lo, $desc_log, $nom_tabela);
                    $_SESSION[CS]['g_deu_login'] = "S";

                    $_SESSION[CS]['alterar_senha'] = 'N';
                    if ($_GET['tipo'] == 'alterar_senha') {
                        // entrar para alterar a senha
                        $_SESSION[CS]['alterar_senha'] = 'S';
                    }

                    if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao'])) {
                        $_SESSION[CS]['alterar_senha'] = 'S';
                    }

                    if ($pdca != 'S') {
						//agora vai ser via agendamento
                        //verifica_job();
                    }
                }
            }
        }

        if ($pdca == 'S') {
            return $msg;
        } else {
            if ($msg != '') {
                echo rawurlencode($msg);
            }
        }
        break;
    case 'escolha_obra':
        $ajax_alt = $_POST['ajax_altw'];
        if ($ajax_alt == 1) {
            //$_SESSION[CS]['g_pri_vez_log'] = 0;
            $_SESSION[CS]['ajax_alt'] = 1;
        } else {
            $_SESSION[CS]['g_pri_vez_log'] = 1;
            $_SESSION[CS]['ajax_alt'] = 0;
        }
        $_SESSION[CS]['g_strMenuJS'] = '';
        $_SESSION[CS]['g_idt_obra'] = '';
        $_SESSION[CS]['g_nm_obra'] = '';

        break;

    case 'envia_email_st_ocorrencia':
        $idt = $_POST['idtw'];
        // acessar registro da ocorrência e enviar e-mail para responsável na obra
        $sql = 'select ';
        $sql .= '  stoc.*, ';
        $sql .= '  usu.nome_completo as usu_nome, ';
        $sql .= '  usu.email         as usu_email ';
        $sql .= '  from st_ocorrencias stoc ';
        $sql .= '  inner join plu_usuario usu on usu.id_usuario = stoc.idt_usuario ';
        $sql .= 'where ';
        $sql .= '   stoc.idt = ' . null($idt);
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $idt_empreendimento = $row['idt_empreendimento'];
            $usu_email_eng = $row['usu_email'];
            $nome_eng = $row['usu_nome'];
            $protocolo = $row['protocolo'];
            $data = trata_data($row['data']);
            $resumo = $row['resumo'];
            $descricao = $row['descricao'];
            //
            $sqlr = 'select ';
            $sqlr .= '  strs.*, ';
            $sqlr .= '  usu.nome_completo as nome, ';
            $sqlr .= '  usu.email         as usu_email ';
            $sqlr .= '  from st_responsavel_seguranca strs ';
            $sqlr .= '  inner join plu_usuario usu on usu.id_usuario = strs.idt_usuario ';
            $sqlr .= 'where ';
            $sqlr .= '       strs.idt_empreendimento = ' . null($idt_empreendimento);
            $sqlr .= '   and strs.responsavel        = ' . aspa('S');
            $rsr = execsql($sqlr);
            ForEach ($rsr->data as $rowr) {
                $emailr = $rowr['email'];
                $nomer = $rowr['nome'];

                $usu_email = $rowr['usu_email'];
                $usu_nome = $rowr['usu_nome'];
                // agora envia e-mail
                $msg = "QSMA - COMUNICAÇÃO DE OCORRÊNCIA" . "<br>";
                $msg .= "<br>";
                $msg .= "Protocolo: " . $protocolo . "<br>";
                $msg .= "Data/Hora: " . $data . "<br>";
                $msg .= "Resumo: " . $resumo . "<br>";
                if ($descricao != '') {
                    $msg .= "Descrição: " . $descricao . "<br>";
                }
                $msg .= "<br><br>";
                $msg .= "Atenciosamente,<br>";
                $msg .= $nome_eng . "<br>";
                $msg .= "Engenheiro de Segurança oas empreendimentos<br>";

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

                $mail->From = $usu_email_eng;
                $mail->FromName = $nome_eng;

                $mail->Subject = "[$sigla_site] QSMA - COMUNICAÇÃO DE OCORRÊNCIA " . " Protocolo: " . $protocolo;
                $mail->Body = $msg;
                $mail->AltBody = $msg;
                $mail->IsHTML(true);

                if ($emailr == '') {
                    $mail->AddAddress($emailr, $usu_nome);
                } else {
                    $mail->AddAddress($usu_email, $usu_nome);
                }

                try {

                    if ($mail->Send()) {
                        echo "E-mail Enviado com sucesso!";
                        $erro = '0';
                    } else {
                        $erro = '1';
                        echo "Erro na transmissão.\\nTente outra vez!\\n\\n" . trata_aspa($mail->ErrorInfo);
                    }
                } catch (Exception $e) {
                    echo 'O Sistema encontrou problemas para enviar seu e-mail. ' . $e->getMessage();
                }
            }
        }
        break;

    case 'excluir_fluxo_financeiro':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];
        /*
          $tranca        = '';
          $data_controle = '';

          if ($_SESSION[CS]['g_acao_tranca']=='S')
          {
          $tranca          = $_SESSION[CS]['g_acao_tranca'];
          $data_controle   = $_SESSION[CS]['g_data_tranca'];
          $acao='con';
          echo "<div style='font-size:18px; text-align:center; height:80px; background:#FFFF00; color:#000000; border:1px solid #900000;' >";
          echo " Não é permitida essa Ação.<br />";
          echo " Modificações só podiam ser efetuadas até {$data_controle}.<br />";
          echo " Para modificar consulte o Usuário Master do Sistema.<br />";
          echo "</div>";


          }
          else
         */


        //////////////////////////////////////////
        $executa = 'S';

        $tranca = '';
        $data_controle = '';
        $vet_assina = Array();
        $vet_assina = $_SESSION[CS]['g_assina_tranca'];
        $vet_assina_atual = Array();
        $vet_assina_atual = $_SESSION[CS]['g_assina_atual'];

        $tranca = $_SESSION[CS]['g_tranca'];
        $razao_tranca = $_SESSION[CS]['g_razao_tranca'];
        $assina_tranca = $_SESSION[CS]['g_assina_tranca_ass'];
        $permissao = $_SESSION[CS]['g_assina_permissao'];


        if ($vet_assina[0] != '') {
            echo "<div style='font-size:12px;  padding-left:10px; padding-top:10px; text-align:left; height:60px; background:#F4F4F4; color:#000000; border-bottom:1px solid #900000;' >";
            $ass = "<span style='color:#900000'> Registro da última assinatura:</span> ";
            $ass .= " Assinado por {$vet_assina[0]} em {$vet_assina[1]} ";
            if ($vet_assina[2] != '') {
                $ass .= " e por {$vet_assina[2]} em {$vet_assina[3]} ";
            }
            echo $ass . "<br /><br />";

            if ($vet_assina_atual[0] != '') {
                if ($vet_assina_atual[4] == 'S') {
                    $ass = "<span style='font-size:14px; color:#000080' font-weight: bold;> Registro da Reabertura da assinatura desse Fluxo:</span><br /> ";
                    $ass .= " Assinado para reabertura por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                } else {
                    $ass = "<span style='color:#900000'> Registro da assinatura desse Fluxo:</span> ";
                    $ass .= " Assinado por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                }
                if ($vet_assina_atual[2] != '') {
                    $ass .= " e por {$vet_assina_atual[2]} em {$vet_assina_atual[3]} ";
                }
                echo $ass . "<br />";
            } else {
                $ass = "<span style='color:#900000'> Sem Registro de assinatura para esse Fluxo.</span> ";
                echo $ass . "<br />";
            }
            echo "</div>";
        } else {
            
        }

        if ($_SESSION[CS]['g_acao_tranca'] == 'S') {
            $tranca = $_SESSION[CS]['g_acao_tranca'];
            $data_controle = $_SESSION[CS]['g_data_tranca'];

            $acao = 'con';
            echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
            echo " Permitido apenas Consultar.<br />";
            echo " Modificações só podiam ser efetuadas até {$data_controle}.<br /><br />";
            echo " <span style='color:#600000'>Para modificar consulte o Usuário Master do Sistema. </span>";
            echo '<a onclick="showPopWin(' . "'" . "conteudo_popup.php?menu=email_adm&prefixo=cadastro', 'Comunicação com o Administrador do Sistema', 704, 351)" . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Comunicação com o Administrador do Sistema" title="Comunicação com o Administrador do Sistema" src="imagens/email.gif" > Envie email pelo Fale Conosco.</a>';
            echo "</div>";
            $executa = 'N';
        } else {
            // se esta assinado permitir desassinar....
            if ($assina_tranca == "S") {
                $data_controle = $_SESSION[CS]['g_data_tranca'];
                if ($vet_assina_atual[4] == 'S') {
                    echo "<div style='font-size:18px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#000080; color:#FFFFFF; border-bottom:1px solid #900000;' >";
                    echo " Fluxo esta Reaberto para Modificações por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    echo "</div>";
                } else {
                    $acao = 'con';
                    $executa = 'N';
                    echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
                    echo " Permitido apenas Consultar. Fluxo já esta Assinado por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    if ($permissao == 'S') {
                        echo " <span style='color:#600000'> </span>";
                        $idt_obra = $_SESSION[CS]['g_idt_obra'];
                        $idt_usuario = $_SESSION[CS]['g_id_usuario'];
                        $idt_controle_assinatura = $_SESSION[CS]['idt_controle_assinatura'];
                        $chama = "return des_assina_tela({$idt_obra},{$idt_usuario}, 'fluxo_financeiro',{$idt_controle_assinatura});";
                        echo '<a onclick="' . $chama . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Clique aqui para Autenticar Informação Site" title="Clique aqui para Autenticar Informação Site" src="imagens/cadeado.gif" style="float:left; padding:0px;"> Assine Solicitação para liberar Modificações no Fluxo.</a>';
                    }
                    echo "</div>";
                }
            }
        }






        if ($executa == 'S') {
            if (tem_direito('fluxo_financeiro', "'EXC'")) {
                beginTransaction();
                set_time_limit(190);
                $sql = 'select ';
                $sql .= '  ff.idt ';
                $sql .= ' from fluxo_financeiro ff ';
                $sql .= ' where ';
                $sql .= '      ff.idt_empreendimento = ' . null($idt_obra);
                $sql .= ' and  ff.idt_periodo_h      = ' . null($idt_periodo);
                $rs = execsql($sql);
                if ($rs->rows != 0) {
                    ForEach ($rs->data as $row) {
                        $idt = $row['idt'];
                        $sql_e = ' delete from fluxo_financeiro ';
                        $sql_e .= ' where idt = ' . null($idt);
                        $result = execsql($sql_e);
                    }
                }
                // desativar o controle para não aparecer no site
                $sql_a = ' update fluxo_financeiro_controle set ';
                $sql_a .= ' publica  = ' . aspa('N') . '  ';
                $sql_a .= ' where  idt_empreendimento = ' . null($idt_obra);
                $sql_a .= ' and    idt_periodo_h      = ' . null($idt_periodo);
                $result = execsql($sql_a);
                commit();
                set_time_limit(30);
            }
        }
        break;

    case 'gerar_fluxo_financeiro':
        $idt_obra = $_POST['idt_obra'];
        $nm_obra = $_POST['nm_obra'];
        $idt_periodo = $_POST['idt_periodo'];
        $nm_periodo = $_POST['nm_periodo'];

        /*
          $tranca        = '';
          $data_controle = '';

          if ($_SESSION[CS]['g_acao_tranca']=='S')
          {



          $tranca          = $_SESSION[CS]['g_acao_tranca'];
          $data_controle   = $_SESSION[CS]['g_data_tranca'];
          $acao='con';
          echo "<div style='font-size:18px; text-align:center; height:80px; background:#FFFF00; color:#000000; border:1px solid #900000;' >";
          echo " Não é permitida essa Ação.<br />";
          echo " Modificações só podiam ser efetuadas até {$data_controle}.<br />";
          echo " Para modificar consulte o Usuário Master do Sistema.<br />";
          echo "</div>";




          }
         */

        //////////////////////////////////////////
        $executa = 'S';

        $tranca = '';
        $data_controle = '';
        $vet_assina = Array();
        $vet_assina = $_SESSION[CS]['g_assina_tranca'];
        $vet_assina_atual = Array();
        $vet_assina_atual = $_SESSION[CS]['g_assina_atual'];

        $tranca = $_SESSION[CS]['g_tranca'];
        $razao_tranca = $_SESSION[CS]['g_razao_tranca'];
        $assina_tranca = $_SESSION[CS]['g_assina_tranca_ass'];
        $permissao = $_SESSION[CS]['g_assina_permissao'];


        if ($vet_assina[0] != '') {
            echo "<div style='font-size:12px;  padding-left:10px; padding-top:10px; text-align:left; height:60px; background:#F4F4F4; color:#000000; border-bottom:1px solid #900000;' >";
            $ass = "<span style='color:#900000'> Registro da última assinatura:</span> ";
            $ass .= " Assinado por {$vet_assina[0]} em {$vet_assina[1]} ";
            if ($vet_assina[2] != '') {
                $ass .= " e por {$vet_assina[2]} em {$vet_assina[3]} ";
            }
            echo $ass . "<br /><br />";

            if ($vet_assina_atual[0] != '') {
                if ($vet_assina_atual[4] == 'S') {
                    $ass = "<span style='font-size:14px; color:#000080' font-weight: bold;> Registro da Reabertura da assinatura desse Fluxo:</span><br /> ";
                    $ass .= " Assinado para reabertura por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                } else {
                    $ass = "<span style='color:#900000'> Registro da assinatura desse Fluxo:</span> ";
                    $ass .= " Assinado por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                }
                if ($vet_assina_atual[2] != '') {
                    $ass .= " e por {$vet_assina_atual[2]} em {$vet_assina_atual[3]} ";
                }
                echo $ass . "<br />";
            } else {
                $ass = "<span style='color:#900000'> Sem Registro de assinatura para esse Fluxo.</span> ";
                echo $ass . "<br />";
            }
            echo "</div>";
        } else {
            
        }

        if ($_SESSION[CS]['g_acao_tranca'] == 'S') {
            $tranca = $_SESSION[CS]['g_acao_tranca'];
            $data_controle = $_SESSION[CS]['g_data_tranca'];

            $acao = 'con';
            echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
            echo " Permitido apenas Consultar.<br />";
            echo " Modificações só podiam ser efetuadas até {$data_controle}.<br /><br />";
            echo " <span style='color:#600000'>Para modificar consulte o Usuário Master do Sistema. </span>";
            echo '<a onclick="showPopWin(' . "'" . "conteudo_popup.php?menu=email_adm&prefixo=cadastro', 'Comunicação com o Administrador do Sistema', 704, 351)" . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Comunicação com o Administrador do Sistema" title="Comunicação com o Administrador do Sistema" src="imagens/email.gif" > Envie email pelo Fale Conosco.</a>';
            echo "</div>";
            $executa = 'N';
        } else {
            // se esta assinado permitir desassinar....
            if ($assina_tranca == "S") {
                $data_controle = $_SESSION[CS]['g_data_tranca'];
                if ($vet_assina_atual[4] == 'S') {
                    echo "<div style='font-size:18px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#000080; color:#FFFFFF; border-bottom:1px solid #900000;' >";
                    echo " Fluxo esta Reaberto para Modificações por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    echo "</div>";
                } else {
                    $acao = 'con';
                    $executa = 'N';
                    echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
                    echo " Permitido apenas Consultar. Fluxo já esta Assinado por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    if ($permissao == 'S') {
                        echo " <span style='color:#600000'> </span>";
                        $idt_obra = $_SESSION[CS]['g_idt_obra'];
                        $idt_usuario = $_SESSION[CS]['g_id_usuario'];
                        $idt_controle_assinatura = $_SESSION[CS]['idt_controle_assinatura'];
                        $chama = "return des_assina_tela({$idt_obra},{$idt_usuario}, 'fluxo_financeiro',{$idt_controle_assinatura});";
                        echo '<a onclick="' . $chama . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Clique aqui para Autenticar Informação Site" title="Clique aqui para Autenticar Informação Site" src="imagens/cadeado.gif" style="float:left; padding:0px;"> Assine Solicitação para liberar Modificações no Fluxo.</a>';
                    }
                    echo "</div>";
                }
            }
        }






        if ($executa == 'S') {
            if (tem_direito('fluxo_financeiro', "'INC'")) {
                $sql = 'select ';
                $sql .= '  ff.idt ';
                $sql .= 'from fluxo_financeiro ff ';
                $sql .= 'where ';
                $sql .= '      ff.idt_empreendimento = ' . null($idt_obra);
                $sql .= ' and  ff.idt_periodo_h      = ' . null($idt_periodo);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_fluxo_financeiro(null($idt_obra), null($idt_periodo));
                }
            }
        }
        break;
    case 'des_assinatura':
        $idt_obra = $_POST['idt_obra'];
        $idt_usuario = $_POST['idt_usuario'];
        $chave = $_POST['chave'];
        $idt_controle_assinatura = $_POST['idt_controle_assinatura'];
        $vet_ocorr = Array();
        $ret = des_assina_tela($idt_obra, $idt_usuario, $chave, $idt_controle_assinatura, $vet_ocorr);
        if ($ret == 0) {
            $erro = $vet_ocorr['erro'];
            echo $erro;
        } else {
            // desassinou....
        }
        break;

    case 'monta_financiamento':
        $idt_obra = $_POST['idt0w'];
        $nm_obra = $_POST['nm_idt0w'];
        $idt_empreendimento_financiamento = $_POST['idt1w'];
        if (tem_direito('empreendimento_financiamento', "'INC'")) {
            monta_financiamento(null($idt_obra), null($idt_empreendimento_financiamento));
        }


        break;

    case 'monta_fluxo_financeiro':
        $idt_obra = $_POST['idt0w'];
        $nm_obra = $_POST['nm_idt0w'];
        $idt_periodo_h = $_POST['idt1w'];
        $nm_periodo = $_POST['nm_idt1w'];
        //////////////////////////////////////////
        $executa = 'S';

        $tranca = '';
        $data_controle = '';
        $vet_assina = Array();
        $vet_assina = $_SESSION[CS]['g_assina_tranca'];
        $vet_assina_atual = Array();
        $vet_assina_atual = $_SESSION[CS]['g_assina_atual'];

        $tranca = $_SESSION[CS]['g_tranca'];
        $razao_tranca = $_SESSION[CS]['g_razao_tranca'];
        $assina_tranca = $_SESSION[CS]['g_assina_tranca_ass'];
        $permissao = $_SESSION[CS]['g_assina_permissao'];


        if ($vet_assina[0] != '') {
            echo "<div style='font-size:12px;  padding-left:10px; padding-top:10px; text-align:left; height:60px; background:#F4F4F4; color:#000000; border-bottom:1px solid #900000;' >";
            $ass = "<span style='color:#900000'> Registro da última assinatura:</span> ";
            $ass .= " Assinado por {$vet_assina[0]} em {$vet_assina[1]} ";
            if ($vet_assina[2] != '') {
                $ass .= " e por {$vet_assina[2]} em {$vet_assina[3]} ";
            }
            echo $ass . "<br /><br />";

            if ($vet_assina_atual[0] != '') {
                if ($vet_assina_atual[4] == 'S') {
                    $ass = "<span style='font-size:14px; color:#000080' font-weight: bold;> Registro da Reabertura da assinatura desse Fluxo:</span><br /> ";
                    $ass .= " Assinado para reabertura por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                } else {
                    $ass = "<span style='color:#900000'> Registro da assinatura desse Fluxo:</span> ";
                    $ass .= " Assinado por {$vet_assina_atual[0]} em {$vet_assina_atual[1]} ";
                }
                if ($vet_assina_atual[2] != '') {
                    $ass .= " e por {$vet_assina_atual[2]} em {$vet_assina_atual[3]} ";
                }
                echo $ass . "<br />";
            } else {
                $ass = "<span style='color:#900000'> Sem Registro de assinatura para esse Fluxo.</span> ";
                echo $ass . "<br />";
            }
            echo "</div>";
        } else {
            
        }

        if ($_SESSION[CS]['g_acao_tranca'] == 'S') {
            $tranca = $_SESSION[CS]['g_acao_tranca'];
            $data_controle = $_SESSION[CS]['g_data_tranca'];

            $acao = 'con';
            echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
            echo " Permitido apenas Consultar.<br />";
            echo " Modificações só podiam ser efetuadas até {$data_controle}.<br /><br />";
            echo " <span style='color:#600000'>Para modificar consulte o Usuário Master do Sistema. </span>";
            echo '<a onclick="showPopWin(' . "'" . "conteudo_popup.php?menu=email_adm&prefixo=cadastro', 'Comunicação com o Administrador do Sistema', 704, 351)" . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Comunicação com o Administrador do Sistema" title="Comunicação com o Administrador do Sistema" src="imagens/email.gif" > Envie email pelo Fale Conosco.</a>';
            echo "</div>";
            $executa = 'N';
        } else {
            // se esta assinado permitir desassinar....
            if ($assina_tranca == "S") {
                $data_controle = $_SESSION[CS]['g_data_tranca'];
                if ($vet_assina_atual[4] == 'S') {
                    echo "<div style='font-size:18px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#000080; color:#FFFFFF; border-bottom:1px solid #900000;' >";
                    echo " Fluxo esta Reaberto para Modificações por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    echo "</div>";
                } else {
                    $acao = 'con';
                    $executa = 'N';
                    echo "<div style='font-size:14px; padding-left:10px; padding-top:10px; text-align:left; height:70px; background:#EBEBEB; color:#000000; border-bottom:1px solid #900000;' >";
                    echo " Permitido apenas Consultar. Fluxo já esta Assinado por {$vet_assina[0]} em {$vet_assina[1]}.<br />";
                    echo " Modificações só podem ser efetuadas até {$data_controle}.<br /><br />";
                    if ($permissao == 'S') {
                        echo " <span style='color:#600000'> </span>";
                        $idt_obra = $_SESSION[CS]['g_idt_obra'];
                        $idt_usuario = $_SESSION[CS]['g_id_usuario'];
                        $idt_controle_assinatura = $_SESSION[CS]['idt_controle_assinatura'];
                        $chama = "return des_assina_tela({$idt_obra},{$idt_usuario}, 'fluxo_financeiro',{$idt_controle_assinatura});";
                        echo '<a onclick="' . $chama . '"' . ' href="#" style="text-decoration:none; "><img width="14" height="14" border="0" alt="Clique aqui para Autenticar Informação Site" title="Clique aqui para Autenticar Informação Site" src="imagens/cadeado.gif" style="float:left; padding:0px;"> Assine Solicitação para liberar Modificações no Fluxo.</a>';
                    }
                    echo "</div>";
                }
            }
        }






        if ($executa == 'S') {


            if (tem_direito('fluxo_financeiro', "'INC'")) {
                monta_fluxo_financeiro(null($idt_obra), null($idt_periodo_h));
            }
        }

        break;




    case 'qu_indice_obra_pqo':
        $idt_obra = $_POST['idt_obra'];
        $idt_revisao = $_POST['idt_revisao'];
        if (tem_direito('qu_indice_obra_pqo', "'INC'")) {
            $sql = 'select ';
            $sql .= '  iopqo.idt ';
            $sql .= 'from qu_indice_obra_pqo iopqo ';
            $sql .= 'where ';
            $sql .= '      iopqo.idt_empreendimento = ' . null($idt_obra);
            $sql .= ' and  iopqo.idt_versao         = ' . null($idt_revisao);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                copia_indice_obra($idt_obra, $idt_revisao);
            }
        }

        break;
    case 'qu_indice_obra_versao_pqo':
        $idt_obra = $_POST['idt_obra'];
        $idt_revisao = $_POST['idt_revisao'];
        if (tem_direito('qu_indice_obra_pqo', "'INC'")) {
            $sql = 'select ';
            $sql .= '  iopqo.idt ';
            $sql .= 'from qu_indice_obra_pqo iopqo ';
            $sql .= 'where ';
            $sql .= '      iopqo.idt_empreendimento = ' . null($idt_obra);
            $sql .= ' and  iopqo.idt_versao         = ' . null($idt_revisao);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                copia_indice_obra_versao($idt_obra, $idt_revisao);
            }
        }

        break;

    case 'qu_indice_obra_itens':
        $idt_obra = $_POST['idt_obra'];
        $idt_revisao = $_POST['idt_revisao'];
        $idt_item = $_POST['idt_item'];
        if (tem_direito('qu_indice_obra_pqo', "'INC'")) {
            $chama_modulo = '';
            $sql = 'select ';
            $sql .= '  iopqo.idt, cod_funcao ';
            $sql .= ' from qu_indice_obra_pqo iopqo ';
            $sql .= ' left join  qu_modulos as qumo on qumo.idt = iopqo.idt_modulo';
            $sql .= ' left join  funcao     as func on func.id_funcao = qumo.idt_funcao';
            $sql .= ' where ';
            $sql .= '      iopqo.idt = ' . null($idt_item);
            $rs = execsql($sql);
            if ($rs->rows == 0) {
                // copia_indice_obra(null($idt_obra) , null($idt_revisao) );
            } else {
                // acessar tipo
                ForEach ($rs->data as $row) {
                    $idt = $row['idt'];
                    $idt_modulo = $row['idt_modulo'];
                    $chama_modulo = $row['cod_funcao'];
                }
            }
            if ($chama_modulo == 'qu_indicadores_obra_pqo') {
                $sql = 'select ';
                $sql .= '  indoqo.idt ';
                $sql .= 'from qu_indicadores_obra_pqo indoqo ';
                $sql .= 'where ';
                $sql .= '      indoqo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_indicadores_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }
            if ($chama_modulo == 'qu_procedimentos_gestao_obra_pg') {
                $sql = 'select ';
                $sql .= '  pgo.idt ';
                $sql .= 'from qu_procedimentos_gestao_obra_pg pgo ';
                $sql .= 'where ';
                $sql .= '      pgo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_procedimentos_gestao_obra_pg($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_procedimentos_operacionais_obra_po') {
                $sql = 'select ';
                $sql .= '  poo.idt ';
                $sql .= 'from qu_procedimentos_operacionais_obra_po poo ';
                $sql .= 'where ';
                $sql .= '      poo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_procedimentos_operacionais_obra_po($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_dispositivos_medicao_obra') {
                $sql = 'select ';
                $sql .= '  dmo.idt ';
                $sql .= 'from qu_dispositivos_medicao_obra dmo ';
                $sql .= 'where ';
                $sql .= '      dmo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_dispositivos_medicao_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_relacao_servicos_obra') {
                $sql = 'select ';
                $sql .= '  rso.idt ';
                $sql .= 'from qu_relacao_servicos_obra rso ';
                $sql .= 'where ';
                $sql .= '      rso.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_relacao_servicos_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_processos_criticos_obra') {
                $sql = 'select ';
                $sql .= '  pco.idt ';
                $sql .= 'from qu_processos_criticos_obra pco ';
                $sql .= 'where ';
                $sql .= '      pco.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_processos_criticos_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_relacao_materiais_obra') {
                $sql = 'select ';
                $sql .= '  rmo.idt ';
                $sql .= 'from qu_relacao_materiais_obra rmo ';
                $sql .= 'where ';
                $sql .= '      rmo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_relacao_materiais_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }

            if ($chama_modulo == 'qu_maquinas_obra') {
                $sql = 'select ';
                $sql .= '  mo.idt ';
                $sql .= 'from qu_maquinas_obra mo ';
                $sql .= 'where ';
                $sql .= '      mo.idt_revisao_pqo   = ' . null($idt_item);
                $rs = execsql($sql);
                if ($rs->rows == 0) {
                    copia_maquinas_obra($idt_obra, $idt_revisao, $idt_item);
                }
            }


            echo $chama_modulo;
        }



        break;


    case 'excluir_versao_pqo':

        $idt_obra = $_POST['idt_obra'];
        $idt_revisao = $_POST['idt_revisao'];
        if (tem_direito('qu_indice_obra_pqo', "'EXC'")) {
            excluir_versao_pqo($idt_obra, $idt_revisao);
        }
        break;

    case 'montar_versao_pqo':

        $idt_obra = $_POST['idt_obra'];
        $idt_revisao = $_POST['idt_revisao'];
        if (tem_direito('qu_indice_obra_pqo', "'INC'")) {
            montar_versao_pqo($idt_obra, $idt_revisao);
        }
        break;

    case 'formatar_avaliacao':
        $idt_periodo = $_POST['idt_periodo'];
        if (tem_direito('periodo', "'INC'")) {
            formatar_avaliacao($idt_periodo);
        }
        break;

    case 'registra_avaliacao':
        $str_idtc = $_POST['str_idtcw'];
        $str_nota = $_POST['str_notaw'];
        $ca_idtw = $_POST['ca_idtw'];
        $nota_finalw = $_POST['nota_finalw'];

        //   p($ca_idtw);
        //   p($nota_finalw);
        //   p($str_idtc);
        //   p($str_nota);

        $kokw = registra_avaliacao($str_idtc, $str_nota, $ca_idtw, $nota_finalw);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ATUALIZAR AVALIAÇÃO...TENTE NOVAMENTE.';
        }
        break;



    case 'situacao_avaliacao':
        $nota_geralw = $_POST['nota_finalw'];
        $ca_idtw = $_POST['ca_idtw'];
        $vet_peso_img = Array();
        $vet_peso_des = Array();
        $sqll = 'select ';
        $sqll .= '  foat.descricao     as foat_descricao, ';
        $sqll .= '  foat.imagem        as foat_imagem,   ';
        $sqll .= '  foat.peso          as foat_peso   ';
        $sqll .= '  from fornecedor_avaliacao foat ';
        $sqll .= '  order by peso desc ';
        $rsl = execsql($sqll);
        $path = 'admin/obj_file/fornecedor_avaliacao/';

        ForEach ($rsl->data as $rowl) {
            $foat_imagem = $rowl['foat_imagem'];
            $foat_descricao = $rowl['foat_descricao'];
            $classe = 'legenda_cab_td';
            $classer = 'legenda_cab_td';
            $vet_peso_img[$rowl['foat_peso']] = $rowl['foat_imagem'];
            $vet_peso_des[$rowl['foat_peso']] = $rowl['foat_descricao'];
        }

        $foa_imagemw = '';
        $foa_descricaow = '';
        $t_img_p = "img_p_{$ca_idtw}";

        ForEach ($vet_peso_img as $peso => $Imagem) {
            if ($peso <= $nota_geralw) {
                $foa_imagemw = $Imagem;
                $foa_descricaow = $vet_peso_des[$peso];
                break;
            }
        }
        echo '   <a>';
        $js = " id = '{$t_img_p}' ";
        // ImagemProd(21 , 21, $path, $foa_imagemw, '', False, $foa_descricaow, $js);
        $t_sit_p = "sit_{$ca_idtw}";
        $t_site = "<input type='text' id='{$t_sit_p}' name='{$t_sit_p}' size='20' readonly='true' value='{$foa_descricaow}'  style='font-size:14px; color:#004080; border:0; background:#C0C0C0;'  />";
        echo '&nbsp;&nbsp;' . $t_site;
        echo '   </a> ';
        break;



    case 'registra_parecer_avaliacao':
        $parecer = utf8_decode($_POST['parecerw']);
        $ca_idt = $_POST['ca_idtw'];
        $kokw = registra_parecer_avaliacao($ca_idt, $parecer);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ATUALIZAR PARECER...TENTE NOVAMENTE.';
        }
        break;

    case 'registra_parecer_contrato':
        $parecer = utf8_decode($_POST['parecerw']);
        $idt_contrato = $_POST['idt_contratow'];
        $kokw = registra_parecer_contrato($idt_contrato, $parecer);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ATUALIZAR PARECER...TENTE NOVAMENTE.';
        }
        break;

    case 'registra_observacao_avaliacao':
        $observacao = utf8_decode($_POST['observacaow']);
        $idt_epa = $_POST['idt_epaw'];
        $kokw = registra_observacao_avaliacao($idt_epa, $observacao);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ATUALIZAR OBSERVAÇÃO...TENTE NOVAMENTE.';
        }
        break;



    case 'registra_parecer_fornecedor':
        $parecer = utf8_decode($_POST['parecerw']);
        $idt_fornecedor = $_POST['idt_fornecedorw'];
        $kokw = registra_parecer_fornecedor($idt_fornecedor, $parecer);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ATUALIZAR O PARECER DO FORNECEDOR...POR FAVOR, TENTE NOVAMENTE.';
        }
        break;

    case 'excluir_pg_marcados':
        $strvet = $_POST['strvetw'];
        $kokw = excluir_pg_marcados($strvet);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU EXCLUIR PG MARCADOS. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;

    case 'excluir_po_marcados':
        $strvet = $_POST['strvetw'];
        $kokw = excluir_po_marcados($strvet);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU EXCLUIR PO MARCADOS. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;
    case 'sincroniza_empresa_fornecedor':
        $kokw = sincroniza_empresa_fornecedor();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR EMPRESAS. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;

    case 'sincroniza_site_direito':
        $kokw = sincroniza_site_direito();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR COM ASSINATURAS. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;
    case 'anexar_servico_obra':
        $strvet = $_POST['strvetw'];
        $idt_obra = $_SESSION[CS]['g_idt_obra'];
        $kokw = anexar_servico_obra($idt_obra, $strvet);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ANEXAR SERVIÇOS Á OBRA. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;


    case 'sincroniza_cadastro_produto':
        $kokw = Gerar_html_produto_geral();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;


    case 'Sincroniza_html_empreendimentos_Geral':
        $kokw = Gera_html_empreendimentos_Geral();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;


    case 'sca_organizacao_cargo_processo':
        $idt_cargo = $_POST['idt_cargow'];

        $sqlp = '';
        $sqlp .= ' select ';
        $sqlp .= ' scaocp.idt, scaocp.* ,';
        $sqlp .= '  scae.classificacao as scae_classificacao, ';
        $sqlp .= '  scae.descricao as scae_descricao, ';
        $sqlp .= '  scae.sistema_executa as scae_sistema_executa, ';
        $sqlp .= '  scae.transacao as scae_transacao, ';
        $sqlp .= '  scate.descricao as scate_descricao ';
        $sqlp .= ' from sca_organizacao_cargo_processo scaocp ';
        $sqlp .= ' left join sca_estrutura scae on substring(scae.classificacao,1,8) = scaocp.classificacao ';
        $sqlp .= ' left join sca_tipo_estrutura scate on scate.idt = scae.idt_sca_tipo_estrutura ';
        $sqlp .= ' where scaocp.idt_cargo = ' . null($idt_cargo);
        $sqlp .= ' order by scae.classificacao';
        $rsp = execsql($sqlp);
        echo "<table class='Geral' width='100%' border='0' cellspacing='0' cellpadding='0' vspace='0' hspace='0'> ";
        ForEach ($rsp->data as $rowp) {
            echo "<tr class='linha_cab_tabela' style='border:0;'>  ";
            echo "<td class='linha_tabela' style='sborder:0; background:{$bgcolor}; color:{$color};'  >" . "&nbsp;</td>";
            echo "<td class='linha_tabela' style='text-align:left; sborder:0; background:{$bgcolor}; color:{$color};'  >" . $rowp['processo'] . "</td>";
            echo "<td class='linha_tabela' style='text-align:left; sborder:0; background:{$bgcolor}; color:{$color};'  >" . $rowp['scae_sistema_executa'] . "</td>";
            echo "<td class='linha_tabela' style='width:30px; text-align:left; sborder:0; background:{$bgcolor}; color:{$color};'  >&nbsp;&nbsp;" . $rowp['scae_transacao'] . "</td>";
            // echo "<td class='linha_tabela' style='text-align:left; sborder:0; background:{$bgcolor}; color:{$color};'  >".$rowp['scate_descricao']."</td>";
            echo "</tr>";
        }
        echo "</table> ";

        break;




    case 'Sincronizar_com_pco':
        $kokw = Sincronizar_pco_oas_pco();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR PCO. POR FAVOR, TENTE NOVAMENTE.';
        }
        $kokw = Sincronizar_pco_oas_sep();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR SEP. POR FAVOR, TENTE NOVAMENTE.';
        }
        $kokw = Sincronizar_pco_oas_spd();
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR SPD. POR FAVOR, TENTE NOVAMENTE.';
        }
        break;

    case 'Sincronizar_usuarios_oas_pco':
        $idt_usuariow = 0;
        $kokw = Sincronizar_usuarios_oas_pco($idt_usuariow);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU SINCRONIZAR USUÁRIOS COM SISTEMAS DA SOLUÇÃO. POR FAVOR, TENTE NOVAMENTE.';
        }



        break;


    case 'AutorizarTodosUsuarios':
        $idt_empreendimento = $_POST['idt_empreendimentow'];
        $kokw = AutorizarTodosUsuarios($idt_empreendimento);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU AUTORIZAR TODOS OS USUÁRIOS, TENTE NOVAMENTE.';
        }



        break;


    case 'GerarMatrizPerfil':
        $idt_organizacao = $_POST['idt_organizacao'];
        $kokw = GerarMatrizPerfil($idt_organizacao);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU Gerar a Matriz de Perfil, TENTE NOVAMENTE.';
        }
        break;



    case 'GerarProcessos':
        $idt_organizacao = $_POST['idt_organizacao'];
        $kokw = GerarProcessos($idt_organizacao);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU Gerar a Processos, TENTE NOVAMENTE.';
        }
        break;


    case 'ModificaProgramaObjeto':
        $idt_funcao = $_POST['idt_funcao'];
        $kokw = ModificaProgramaObjeto($idt_funcao);
        if ($kokw != 1) {
            echo 'NÃO CONSEGUIU ASSOCIAR OBJETOS. TENTE NOVAMENTE.';
        }
        break;

    case 'ModificaCargoPerfil':
        $idt_perfil = $_POST['idt_perfil'];
        $_SESSION[CS]['g_idt_perfil'] = $idt_perfil;
        // $kokw = ModificaCargoPerfil($idt_perfil);
        // if ($kokw!=1)
        //{
        //    echo 'NÃO CONSEGUIU ASSOCIAR PERFIL. TENTE NOVAMENTE.';
        //}
        break;



    case 'consiste':
        $codigo = $_POST['codigo'];
        $sql = "select 	      ";
        $sql .= "     gec_en.idt, gec_en.descricao   ";
        $sql .= " from gec_entidade gec_en ";
        $sql .= " where codigo = " . aspa($codigo);
        $rs = execsql($sql);
        $gec_en_idt = 0;
        ForEach ($rs->data as $row) {
            $gec_en_idt = $row['idt'];
            $gec_en_descricao = $row['descricao'];
        }
        if ($gec_en_idt > 0) {
            echo " $codigo já esta cadastrado para {$gec_en_descricao} ";
        }
        break;



    case 'EditalProcessoEtapa':
        $idt_etapa = $_POST['idt_etapa'];
        $_SESSION[CS]['g_idt_etapa'] = $idt_etapa;
        break;

    case 'EditalProcessoEtapaLimpa':
        $_SESSION[CS]['g_idt_etapa'] = "";
        $_SESSION[CS][$idt_etapa]['g_Aceite_Termo'] = 'N';
        break;

    case 'AceitedoTermo':
        $idt_etapa = $_POST['idt_etapa'];
        $_SESSION[CS][$idt_etapa]['g_Aceite_Termo'] = 'S';
        break;

    case 'AceitedoTermoLimpa':
        $idt_etapa = $_POST['idt_etapa'];
        $_SESSION[CS][$idt_etapa]['g_Aceite_Termo'] = 'N';
        break;
    case 'IdentificaCandidato':
        $identificacao = $_POST['identificacao'];
        $nome_candidato = utf8_decode($_POST['nome']);
        $email_candidato = $_POST['email'];
        $opc = $_POST['opc'];

        $jacadastrado = 'N';
        $sql = "select * from plu_usuario where login = " . aspa($identificacao);
        $result = execsql($sql);
        $row = $result->data[0];
        if ($result->rows == 0) {
            $msg = "Candidato Não cadastrado.";
            $jacadastrado = 'N';
        } else if ($row['ativo'] == 'N') {
            $msg = "Usuário não esta ativo!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
        } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
            $msg = "O seu acesso expirou em " . trata_data($row['dt_validade']) . "!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
        } else {
            $_SESSION[CS]['g_ca_id_usuario'] = $row['id_usuario'];
            $_SESSION[CS]['g_ca_login'] = $row['login'];
            $_SESSION[CS]['g_ca_nome_completo'] = $row['nome_completo'];
            $_SESSION[CS]['g_ca_email'] = $row['email'];
            $jacadastrado = 'S';
            $nome_candidato = $_SESSION[CS]['g_ca_nome_completo'];
            $email_candidato = $_SESSION[CS]['g_ca_email'];
        }
        $identificacao_j = str_replace('.', '', $identificacao);
        $identificacao_j = str_replace('/', '', $identificacao_j);
        $identificacao_j = str_replace('-', '', $identificacao_j);
        $tam = strlen($identificacao_j);
        $cnpjcpf = "";
        if ($tam < 12) { // CPF
            $cnpjcpf = "CPF";
        } else { // CNPJ
            $cnpjcpf = "CNPJ";
        }


        $_SESSION[CS]['g_identificacao'] = $identificacao;
        $_SESSION[CS]['g_cnpjcpf'] = $cnpjcpf;

        $_SESSION[CS]['g_nome_candidato'] = $nome_candidato;
        $_SESSION[CS]['g_email_candidato'] = $email_candidato;
        echo $_SESSION[CS]['g_identificacao'] . "###" . $_SESSION[CS]['g_cnpjcpf'] . "###" . $_SESSION[CS]['g_nome_candidato'] . "###" . $_SESSION[CS]['g_email_candidato'] . "###" . $jacadastrado . "###";
        break;

    case 'IdentificaCandidatoLimpa':
        $identificacao = $_POST['identificacao'];
        $nome_candidato = utf8_decode($_POST['nome']);
        $email_candidato = $_POST['email'];
        $opc = $_POST['opc'];


        $identificacao = "";
        $nome_candidato = "";
        $email_candidato = "";

        $jacadastrado = 'N';
        $_SESSION[CS]['g_ca_id_usuario'] = 0;
        $_SESSION[CS]['g_ca_login'] = "";
        $_SESSION[CS]['g_ca_nome_completo'] = "";
        $_SESSION[CS]['g_ca_email'] = "";
        $nome_candidato = $_SESSION[CS]['g_ca_nome_completo'];
        $email_candidato = $_SESSION[CS]['g_ca_email'];
        $cnpjcpf = "AMBOS";
        $_SESSION[CS]['g_identificacao'] = $identificacao;
        $_SESSION[CS]['g_cnpjcpf'] = $cnpjcpf;
        $_SESSION[CS]['g_nome_candidato'] = $nome_candidato;
        $_SESSION[CS]['g_email_candidato'] = $email_candidato;


        // OUTRAS VARIÁVEIS DOS PASSOS SEGUINTES
        $_SESSION[CS]['g_telefone_candidato'] = "";
        $_SESSION[CS]['g_senha_candidato'] = "";
        $_SESSION[CS]['g_senha_c_candidato'] = "";

        $_SESSION[CS]['g_idt_etapa'] = "";
        $_SESSION[CS][$idt_etapa]['g_Aceite_Termo'] = 'N';


        echo $_SESSION[CS]['g_identificacao'] . "###" . $_SESSION[CS]['g_cnpjcpf'] . "###" . $_SESSION[CS]['g_nome_candidato'] . "###" . $_SESSION[CS]['g_email_candidato'] . "###" . $jacadastrado . "###";
        break;

    case 'AutenticacaoCandidato':
        $identificacao = $_POST['identificacao'];
        $nome_candidato = utf8_decode($_POST['nome']);
        $email_candidato = $_POST['email'];
        $opc = $_POST['opc'];

        $telefone_candidato = $_POST['telefone'];
        $senha_candidato = $_POST['senha'];
        $senha_c_candidato = $_POST['senha_c'];

        //
        $jacadastrado = 'N';
        $sql = "select * from plu_usuario where login = " . aspa($identificacao);
        $result = execsql($sql);
        $row = $result->data[0];
//        if ($result->rows == 0) {
        $msg = "Candidato Não cadastrado.";
        $jacadastrado = 'N';
        if ($senha_candidato == $senha_c_candidato) { // insert em usuario
            $nome_completo = $nome_candidato;
            $login = $identificacao;
            $senha_candidatow = md5($senha_candidato);
            $senha = $senha_candidatow;
            $ativo = 'S';
            $id_perfil = 1;
            $idt_natureza = 2;
            $email = $email_candidato;
            $gestor_login = 'N';
            $gerenciador = 'N';
            $situacao_login = '00';

            if ($result->rows == 0) {
                $sql_i = ' insert into plu_usuario ';
                $sql_i .= ' (nome_completo, login, senha, ativo, id_perfil,idt_natureza,email, situacao_login, telefone) values ( ';
                $sql_i .= aspa($nome_completo) . ' , ';
                $sql_i .= aspa($login) . ' , ';
                $sql_i .= aspa($senha) . ' , ';
                $sql_i .= aspa($ativo) . ' , ';
                $sql_i .= null($id_perfil) . ' , ';
                $sql_i .= null($idt_natureza) . ' , ';
                $sql_i .= aspa($email) . ' , ';
                $sql_i .= aspa($situacao_login) . ',  ';
                $sql_i .= aspa($telefone_candidato) . '  ';
                $sql_i .= ') ';
                $result = execsql($sql_i);


                $numero_edital = '111';
                $numero_processo = '777';
                $resumo = '555';
                $data = Date('d/m/Y');

                $msg = "SEBRAE-BA :: COMUNICAÇÃO DE ACEITE" . "<br>";
                $msg .= "<br>";
                $msg .= "Edital  : " . $numero_edital . "<br>";
                $msg .= "Processo: " . $numero_processo . "<br>";
                $msg .= "Data/Hora: " . $data . "<br>";
                $msg .= "Resumo: " . $resumo . "<br>";
                $msg .= "<br><br>";
                $msg .= "Atenciosamente,<br>";
                $msg .= "SEBRAE - CREDENCIAMENTO" . "<br>";


                $vetEmail = Array();
                //
                $vetEmail['origem_nome'] = 'Luiz Pereira';
                $vetEmail['origem_email'] = 'luizrehmpereira@gmail.com';
                $vetEmail['destino_nome'] = $nome_candidato;
                $vetEmail['destino_email'] = $email_candidato;
                $vetEmail['destino_mensagem'] = $msg;

                //email_aceite($vetEmail);
                //exit();
            } else {
                $idt_usuario = $row['id_usuario'];
                $sql_a = ' update plu_usuario set ';
                $sql_a .= ' nome_completo  = ' . aspa($nome_completo) . ',  ';
                $sql_a .= ' telefone       = ' . aspa($telefone_candidato) . ',  ';
                $sql_a .= ' email           = ' . aspa($email) . ',  ';
                $sql_a .= ' senha          = ' . aspa($senha) . '  ';

                $sql_a .= ' where  id_usuario = ' . null($idt_usuario);
                $result = execsql($sql_a);
            }
        }
        // }
        //   $sql = "select * from plu_usuario where login = ".aspa($identificacao);
        $result = execsql($sql);
        $row = $result->data[0];
        if ($result->rows == 0) {
            $msg = "Candidato Não cadastrado.";
            $jacadastrado = 'N';
        } else if ($row['ativo'] == 'N') {
            $msg = "Usuário não esta ativo!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
//        } else if ($row['ativo_pir'] == 'N') {
            //          $msg = "Usuário não esta ativo no sistema PIR!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
        } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
            $msg = "O seu acesso expirou em " . trata_data($row['dt_validade']) . "!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
        } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '') {
            $msg = "O seu acesso só vai esta liberado em " . trata_data($row['dt_validade_inicio']) . "!<br>Para maiores informações<br>procurar o Administrador do sistema.";
            $jacadastrado = 'N';
        } else {
            $_SESSION[CS]['g_ca_id_usuario'] = $row['id_usuario'];
            $_SESSION[CS]['g_ca_login'] = $row['login'];
            $_SESSION[CS]['g_ca_nome_completo'] = $row['nome_completo'];
            $_SESSION[CS]['g_ca_email'] = $row['email'];

            $_SESSION[CS]['g_ca_telefone'] = $row['telefone'];
            $jacadastrado = 'S';
            $nome_candidato = $_SESSION[CS]['g_ca_nome_completo'];
            $email_candidato = $_SESSION[CS]['g_ca_email'];
            $telefone_candidato = $_SESSION[CS]['g_ca_telefone'];
        }
//        $tam=strlen($identificacao);
//        $cnpjcpf         = "";


        $identificacao_j = str_replace('.', '', $identificacao);
        $identificacao_j = str_replace('/', '', $identificacao_j);
        $identificacao_j = str_replace('-', '', $identificacao_j);
        $tam = strlen($identificacao_j);
        $cnpjcpf = "";
        if ($tam < 12) { // CPF
            $cnpjcpf = "CPF";
        } else { // CNPJ
            $cnpjcpf = "CNPJ";
        }


        if ($tam < 12) { // CPF
            $cnpjcpf = "CPF";
        } else { // CNPJ
            $cnpjcpf = "CNPJ";
        }

        $telefone_candidato = $_POST['telefone'];
        $senha_candidato = $_POST['senha'];
        $senha_c_candidato = $_POST['senha_c'];

        $_SESSION[CS]['g_identificacao'] = $identificacao;
        $_SESSION[CS]['g_cnpjcpf'] = $cnpjcpf;
        $_SESSION[CS]['g_nome_candidato'] = $nome_candidato;
        $_SESSION[CS]['g_email_candidato'] = $email_candidato;

        $_SESSION[CS]['g_telefone_candidato'] = $telefone_candidato;
        $_SESSION[CS]['g_senha_candidato'] = $senha_candidato;
        $_SESSION[CS]['g_senha_c_candidato'] = $senha_c_candidato;

        $parametro = $_SESSION[CS]['g_identificacao'] . "###" . $_SESSION[CS]['g_cnpjcpf'] . "###" . $_SESSION[CS]['g_nome_candidato'] . "###" . $_SESSION[CS]['g_email_candidato'] . "###" . $jacadastrado . "###";
        $parametro .= $_SESSION[CS]['g_telefone_candidato'] . "###";
        echo $_SESSION[CS]['g_identificacao'] . "###" . $_SESSION[CS]['g_cnpjcpf'] . "###" . $_SESSION[CS]['g_nome_candidato'] . "###" . $_SESSION[CS]['g_email_candidato'] . "###" . $jacadastrado . "###";
        break;

    case 'FimProcesso':
        $identificacao = "";
        $nome_candidato = "";
        $email_candidato = "";

        $jacadastrado = 'N';
        $_SESSION[CS]['g_ca_id_usuario'] = 0;
        $_SESSION[CS]['g_ca_login'] = "";
        $_SESSION[CS]['g_ca_nome_completo'] = "";
        $_SESSION[CS]['g_ca_email'] = "";
        $nome_candidato = $_SESSION[CS]['g_ca_nome_completo'];
        $email_candidato = $_SESSION[CS]['g_ca_email'];
        $cnpjcpf = "AMBOS";
        $_SESSION[CS]['g_identificacao'] = $identificacao;
        $_SESSION[CS]['g_cnpjcpf'] = $cnpjcpf;
        $_SESSION[CS]['g_nome_candidato'] = $nome_candidato;
        $_SESSION[CS]['g_email_candidato'] = $email_candidato;
        // OUTRAS VARIÁVEIS DOS PASSOS SEGUINTES
        $_SESSION[CS]['g_telefone_candidato'] = "";
        $_SESSION[CS]['g_senha_candidato'] = "";
        $_SESSION[CS]['g_senha_c_candidato'] = "";

        $_SESSION[CS]['g_idt_etapa'] = "";
        $_SESSION[CS][$idt_etapa]['g_Aceite_Termo'] = 'N';

        break;



    case 'Sincronizar_Area_sgc':

        SincronizaAreasConhecimento();
        break;
    case 'Sincronizar_Metodologia_sgc':
        SincronizaMetodologia();
        break;



    case 'AtivaSituacaoProduto':
        $idt_produto = $_POST['idt_produto'];
        $idt_situacao = $_POST['idt_situacao'];

        // echo " $idt_produto == $idt_situacao ";

        AtivaSituacaoProduto($idt_produto, $idt_situacao);
        break;


    case 'AtivaSituacaoEvento':
        $idt_evento = $_POST['idt_evento'];
        $idt_situacao = $_POST['idt_situacao'];
        AtivaSituacaoEvento($idt_evento, $idt_situacao);
        break;

    case 'AtivaCopiaProduto':
        $idt_produto = $_POST['idt_produto'];
        $idt_produto_novo = 0;
        AtivaCopiaProduto($idt_produto, 0, $idt_produto_novo);
        break;

    case 'buscar_insumo':
        $idt_insumo = $_POST['idt_insumo'];
        $row = Array();
        $row = DadoInsumo($idt_insumo);
        $codigo = $row['codigo'];
        $descricao = $row['descricao'];
        $ativo = $row['ativo'];
        $detalhe = $row['detalhe'];
        $classificacao = $row['classificacao'];
        $idt_insumo_elemento_custo = $row['idt_insumo_elemento_custo'];
        $idt_insumo_unidade = $row['idt_insumo_unidade'];
        $custo_unitario_real = $row['custo_unitario_real'];
        $por_participante = $row['por_participante'];
        $nivel = $row['nivel'];
        $str = "";
        $str .= "$codigo###";
        $str .= "$descricao###";
        $str .= "$ativo###";
        $str .= "$detalhe###";
        $str .= "$classificacao###";
        $str .= "$idt_insumo_elemento_custo###";
        $str .= "$idt_insumo_unidade###";
        $str .= "$custo_unitario_real###";
        $str .= "$por_participante###";
        $str .= "$nivel###";

        echo $str;

        break;



    case 'PegaAutora':
        $vet = Array(
            'erro' => '',
            'proprio' => '',
        );

        try {
            $sql = "select grc_pa.proprio from grc_produto_abrangencia grc_pa ";
            $sql .= " where grc_pa.idt = " . null($_POST['idt_produto_abrangencia']);
            $rs = execsql($sql, false);
            $vet['proprio'] = rawurlencode($rs->data[0][0]);
        } catch (PDOException $e) {
            $msg = grava_erro_log($tipodb, $e, $sql);
            $vet['erro'] = rawurlencode($msg);
        } catch (Exception $e) {
            $msg = grava_erro_log('php', $e, '');
            $vet['erro'] = rawurlencode($msg);
        }

        echo json_encode($vet);
        break;

    case 'esqueci_senha':
        $msg = '';

        $sql = "select id_usuario, nome_completo, email, ativo, dt_validade from plu_usuario where login = " . aspa($_POST['login']);
        $result = execsql($sql);
        $row = $result->data[0];

        if ($result->rows == 0) {
            $msg = "Usuário não esta registrado no sistema!";
        } else if ($row['ativo'] == 'N') {
            $msg = "Usuário não esta ativo!";
        } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
            $msg = "O acesso expirou em " . trata_data($row['dt_validade']) . "!";
        } else if ($row['email'] == '') {
            $msg = "Este usuário não tem email cadastrado! Por isso não podemos enviar uma nova senha.\\n\\nFavor entrar em contado com o administrador do sistema";
        } else {
            $cod = md5($row['id_usuario']);
            $cod = base64_encode(GerarStr() . $cod . GerarStr());

            $Body = '';
            $Body .= 'Prezado ' . $row['nome_completo'] . ',<br /><br />';
            $Body .= 'Conforme solicitado, segue o link para receber uma nova senha de acesso ao sistema.<br /><br />';
            $Body .= '<a href="' . url . 'esqueci_senha.php?cod=' . $cod . '" target="_blank">Trocar a Senha</a>';

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
                    $msg = "A confirmação para troca da senha foi enviada para o email: " . mb_strtoupper(trunca_email($row['email']));
                } else {
                    $msg = "Erro na transmissão.\\nTente outra vez!\\n\\n" . trata_aspa($mail->ErrorInfo);
                }
            } catch (Exception $e) {
                $msg = 'O Sistema encontrou problemas para enviar seu e-mail. ' . $e->getMessage();
            }
        }

        echo rawurlencode($msg);
        break;

    case 'ConfirmaFechamentoAvaliacao':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        $idt_situacao = 4;
        //ApurarResultado($idt_avaliacao);
        TrocaAvaliacaoSituacao($idt_avaliacao, $idt_situacao);
        break;

    case 'ConfirmaReabrirAvaliacao':
        $idt_avaliacao = $_POST['idt_avaliacao'];
        $idt_situacao = 3;
        TrocaAvaliacaoSituacao($idt_avaliacao, $idt_situacao);
        break;
}
