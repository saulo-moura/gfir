<?php
Require_Once('configuracao.php');

p($_SESSION[CS]);

//echo ' nnnnnnnnnnnnnnn '.$nome_site;
switch ($_GET['tipo']) {
    case 'erro_log':
        $sql = 'select objeto from plu_erro_log where idt = '.null($_GET['idt']);
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




        $sql = "select 	      ";
        $sql .= "     em.*       ";
        $sql .= " from empreendimento em ";
        $sql .= " where idt = ".$_SESSION[CS]['g_idt_obra'];
        $rs = execsql($sql);
        ForEach ($rs->data as $row) {
            $path = $dir_file.'/empreendimento/';
            $_SESSION[CS]['g_path_logo_obra'] = $path;
            $_SESSION[CS]['g_imagem_logo_obra'] = $row['imagem'];
            $_SESSION[CS]['g_nm_obra'] = $row['descricao'];
            $_SESSION[CS]['g_obra_orc_real'] = $row['orcamento_real'];
            $_SESSION[CS]['g_obra_orc_incc'] = $row['orcamento_incc'];

            $_SESSION[CS]['g_indicador_fluxo_financeiro'] = $row['indicador_fluxo_financeiro'];

            $_SESSION[CS]['g_ativo'] = $row['ativo'];


            $vetper = Array();
            //$vetper[]=' guy 1';
            $_SESSION[CS]['g_periodo_obra'] = '';
            $vetper = calculaperiodoobra($row, 1);
            $_SESSION[CS]['g_periodo_obra'] = $vetper;
            $vetper = calculaperiodoobra($row, 2);
            $_SESSION[CS]['g_periodo_obra_fl'] = $vetper;

            //  menu_obra($_SESSION[CS]['g_idt_obra']);
        }
        break;



    case 'login':
        $msg = '';

        unset($_SESSION[CS]);

        if ($_POST['login'] != '' && $_POST['senha'] != '') {
            //   if (substr(mb_strtolower(trim($_POST['login'])), -23, 23) != '@oasempreendimentos.com')
            //       $_POST['login'] .= '@oasempreendimentos.com';

            $sql = "select * from {$pre_table}plu_usuario where login = ".aspa($_POST['login'])." and senha = ".aspa(md5($_POST['senha']));
            $result = execsql($sql);
            $row = $result->data[0];

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
                $nom_tabela = "Login Site sebrae.GC";
                grava_log_sis($tabela, 'L', $id_lo, $desc_log, $nom_tabela);
            }

            if ($msg != '') {
                echo rawurlencode($msg);
            }
        }
        break;
}
?>