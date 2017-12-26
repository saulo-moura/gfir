<style type="text/css">

    div#conteudo {
        padding:0px;
        margin:0px;
        margin-top:5px;
        margin-left:10px;
        width:100%;
    }

    div#conteudo img {
        text-align:center;

    }
    div#alterasenha {
        width:98%;
        height:60px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: #F2F2F2;
        padding-bottom:7px;
        margin-top:3px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: normal;
        color: #900000;


    }

    div#altera_senha  {
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size   : 13px;
        font-style  : normal;
        font-weight : normal;
        font-weight : bold;
        color       : #C40000;

        color       : #A2A2A2;
        stext-align  : center;

        margin-left:0px;
        margin-top :1px;
        background-color:#FFFFFF;

        sborder-top:6px solid #808080;
        sborder-right:6px solid #C0C0C0;
        sborder-bottom:6px solid #808080;
        sborder-left:6px solid #C0C0C0;

        padding:0px;
        width:99%;
        sheight:450px;

        height:370px;

        zz-index: 20000;
    }

    div#home_altera_senha_titulo  {
        width:100%;
        background-color:#FFFFFF;
        sborder-bottom:1px solid black;
        padding-top:5px;
        padding-bottom:5px;
    }

    div#home_altera_senha_titulo span {
        padding-left :3px;
        padding-right:3px;
    }

    div#home_altera_senha_erro {
        width:98%;
        height:60px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: red;
        padding-bottom:7px;
        margin-top:3px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: normal;
        color: #FFFFFF;
    }
    div#home_altera_senha_sucesso {
        width:98%;
        height:60px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: blue;
        padding-bottom:7px;
        margin-top:3px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: normal;
        color: #FFFFFF;
    }

    div#senha_padrao {
        width:98%;
        height:90px;
        text-align:center;
        border-top: 1px solid #DADADA;
        border-bottom: 1px solid #DADADA;
        background-color: #FF0000;
        padding-bottom:7px;
        margin-top:3px;
        font-family : Calibri, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: bold;
        color: #FFFFFF;


    }



</style>



<?php
$nome = $_SESSION[CS]['g_nome_completo'];
$email = $_SESSION[CS]['g_email'];
$telefone = '';
if ($veiosite != 'SP') {
    $_SESSION[CS]['alterar_senha'] = 'S';
} else {
    $_SESSION[CS]['alterar_senha'] = 'N';
}
$erro = '5';

switch ($_POST['btnAcao']) {
    case 'Confirmar':
        $sql = "select * from {$pre_table}usuario where login = ".aspa($_SESSION[CS]['g_login'])." and senha = ".aspa(md5($_POST['senha_atual']));
        $result = execsql($sql);
        $row = $result->data[0];
        $idt_usuario = $row['id_usuario'];
        if ($result->rows == 0) {
            echo "<script type='text/javascript'>alert('Usuário e/ou senha inválidos.\\n\\nTente de novo.');</script>";
        } else if ($row['ativo'] == 'N') {
            echo "<script type='text/javascript'>alert('Usuário não esta ativo!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
//        } else if ($row['ativo_pir'] == 'N') {
  //          echo "<script type='text/javascript'>alert('Usuário não esta ativo no sistema PIR!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
        } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
            echo "<script type='text/javascript'>alert('O seu acesso expirou em ".trata_data($row['dt_validade'])."!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
        } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '') {
            echo "<script type='text/javascript'>alert('O seu acesso só vai esta liberado em ".trata_data($row['dt_validade_inicio'])."!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
        } else {
            if ($_POST['senha_nova'] != $_POST['senha_nova_repete']) {
                echo "<script type='text/javascript'>alert('Senha Nova difere da digitada em Senha Nova repetida. ');</script>";
            } else {
                $email_adm = $vetConf['email_site'];
                $nome_adm = 'Administrador do Site';
                $msg = "Sr(a) ".$_POST['nome']."<br>";
                $msg .= "E-Mail: ".$_POST['email']."<br>";
                $msg .= "Estamos comunicando que a sua solicitação de modificação da senha no site <b>sebrae.GRC</b> foi aceita.<br>";
                $msg .= "Aguarde Confirmação e qualquer irregularidade favor utilizar o 'Fale Conosco' para informar a ocorrência.<br>";
                $msg .= "<br>";
                $msg .= "Atenciosamente,<br>";
                $msg .= "Administrador do Site <b>sebrae.GRC</b>.";
                Require_Once('admin/PHPMailer/class.phpmailer.php');
                Require_Once('admin/PHPMailer/class.smtp.php');
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = $vetConf['host_smtp'];
                $mail->Port = $vetConf['port_smtp'];
                $mail->Username = $vetConf['login_smtp'];
                $mail->Password = $vetConf['senha_smtp'];
                $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
                $mail->SMTPSecure = $vetConf['smtp_secure'];
                $mail->From = $vetConf['email_envio'];
                $mail->FromName = $nome_adm;

                $mail->AddReplyTo($email_adm, $nome_adm);

                $mail->Subject = "[$sigla_site] Comunicação de Alteração de Senha";
                $mail->Body = $msg;
                $mail->AltBody = $msg;
                $mail->IsHTML(true);
                //$_POST['email']='lupe@sknet.com.br';
                $mail->AddAddress($_POST['email'], $_POST['nome']);
                try {
                    if ($mail->Send()) {
                        //      echo "<script type='text/javascript'>alert('Enviado com sucesso!');</script>";
                        $erro = '0';
                    } else {
                        $erro = '1';
                        echo "<script type='text/javascript'>alert('Erro na transmissão.\\nTente outra vez!\\n\\n".trata_aspa($mail->ErrorInfo)."');</script>";
                    }
                } catch (Exception $e) {
                    echo 'O Sistema encontrou problemas para enviar seu e-mail. ', $e->getMessage(), "\n";
                }
                if ($erro == '0') {  // comunicação de tentativa de modificação enviada
                    // modificar
                    $senha_novaw = aspa(md5($_POST['senha_nova']));
                    $_SESSION[CS]['g_senha_antiga'] = $row['senha_nova'];
                    $sql_a = ' update usuario set ';
                    $sql_a .= ' senha  = '.$senha_novaw;
                    $sql_a .= ' where id_usuario = '.null($idt_usuario);
                    $result = execsql($sql_a);
                    //
                    $sql = "select * from {$pre_table}usuario where login = ".aspa($_SESSION[CS]['g_login'])." and senha = ".aspa(md5($_POST['senha_nova']));
                    $result = execsql($sql);
                    $row = $result->data[0];
                    //
                    if ($result->rows == 0) {
                        echo "<script type='text/javascript'>alert('Usuário e/ou senha inválidos.\\n\\nSua solicitação de modificar a senha não obteve sucesso.\\n\\nTente de novo.');</script>";
                    } else {
                        $email_adm = $vetConf['email_site'];
                        $nome_adm = 'Administrador do Site';
                        $msg = "Sr(a) ".$_POST['nome']."<br>";
                        $msg .= "E-Mail: ".$_POST['email']."<br>";
                        $msg .= "Estamos comunicando que a sua <b>SENHA</b> no site <b>sebrae.GRC</b> foi MODIFICADA COM SUCESSO....<br>";
                        $msg .= "Qualquer irregularidade favor utilizar o 'Fale Conosco' para informar a ocorrência.<br>";
                        $msg .= "<br>";
                        $msg .= "Atenciosamente,<br>";
                        $msg .= "Administrador do Site <b>sebrae.GRC</b>.";
                        Require_Once('admin/PHPMailer/class.phpmailer.php');
                        Require_Once('admin/PHPMailer/class.smtp.php');
                        $mail = new PHPMailer();
                        $mail->IsSMTP();
                        $mail->Host = $vetConf['host_smtp'];
                        $mail->Port = $vetConf['port_smtp'];
                        $mail->Username = $vetConf['login_smtp'];
                        $mail->Password = $vetConf['senha_smtp'];
                        $mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
                        $mail->SMTPSecure = $vetConf['smtp_secure'];
                        $mail->From = $vetConf['email_envio'];
                        $mail->FromName = $nome_adm;

                        $mail->AddReplyTo($email_adm, $nome_adm);
                        $mail->Subject = "[$sigla_site] Comunicação de Alteração de Senha";
                        $mail->Body = $msg;
                        $mail->AltBody = $msg;
                        $mail->IsHTML(true);
                        // $_POST['email']='luizrehmpereira@gmail.com';
                        $mail->AddAddress($_POST['email'], $_POST['nome']);
                        try {
                            if ($mail->Send()) {
                                //      echo "<script type='text/javascript'>alert('Enviado com sucesso!');</script>";
                                $erro = '0';
                            } else {
                                $erro = '1';
                                echo "<script type='text/javascript'>alert('Erro na transmissão.\\nTente outra vez!\\n\\n".trata_aspa($mail->ErrorInfo)."');</script>";
                            }
                        } catch (Exception $e) {
                            echo 'O Sistema encontrou problemas para enviar seu e-mail. ', $e->getMessage(), "\n";
                        }
                    }  //
                }  //
            } //
        } //
        //exit();
        break;
}


if ($erro != '0') {
    $varCampos = array("frm",
        "nome", "Nome",
        "email", "e-Mail",
        "senha_atual", "Senha Atual",
        "senha_nova", "Senha Nova",
        "senha_nova_repete", "Senha Nova repetida",
    );
    camposObrigatorios($varCampos);
    onLoadPag("senha_atual");
}


$btretorna = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_duvida();'  />";
echo '<div id="barra"><div id="tela"><div class="tit_home">';
echo 'Alterar Senha ';
echo '&nbsp;&nbsp;</div></div></div>';

//echo $vetConf[$menu];
if ($erro != '0') {
    echo "<div id='alterasenha' >";
    echo '<a>Essa Função possibilita a alteração da sua senha no site <b>sebrae.GRC</b>.<br>Por segurança, informe novamente a sua senha atual, digite a senha desejada e redigite a senha desejada.<br> Lembre que o Site é sensivel a letras maiúsculas/minusculas. </a>';
    echo "</div>";
}
if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao'])) {
    echo "<div id='senha_padrao' >";
    echo '<a>ATENÇÃO...<br><br>Sua senha é a Padrão do site <b>sebrae.GRC</b>.<br><br> Altere imediatamente a sua senha.<br></a>';
    echo "</div>";
}



echo "<div id='altera_senha'>";

echo "   <div id='altera_senha_titulo'>";
//echo " <span> ";
//if ($erro=='5')
//{
//    echo "   Nessa função você pode enviar <b>e-mail</b> para Falar com a <b>oas empreendimentos</b>.<br>Preencha os campos solicitados abaixo e aguarde resposta de nossos técnicos que será enviada para o <b>seu e-mail</b>.";
//}

if ($erro == '1') {
    echo "<div id='home_altera_senha_erro'>";
    echo "ATENÇÃO...<br> Senha Não pode ser Modificada...<br>Tente novamente e se persistir o problema, utilize o <b>Fale Conosco</b> para comunicar a ocorrência.";
    echo "</div>";
} else {
    if ($erro == '0') {
        echo "<div id='home_altera_senha_sucesso'>";
        echo "ATENÇÃO...<br> Senha Modificada com sucesso...";
        echo "</div>";
        $_SESSION[CS]['alterar_senha'] = 'N';

//        onLoadPag();
//        FimTela();
//        Exit();
    }
}

//echo " </span> ";

echo "   </div>";



echo "<form name='frm' action='conteudo.php? ".substr(getParametro(), 1)."' method='post' onSubmit='return frmFcn()'>";


echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";

//echo "<fieldset>";

if ($erro != '0') {



    echo "<tr class='table_contato_linha'> ";


    echo "<tr class='table_contato_linha'> ";
    $nomelabelw = "<label for='nome' >Seu Nome<span>*</span>:&nbsp;</label>";
    echo "   <td class='table_contato_celula_label'>{$nomelabelw}</td> ";
    $nomew = "<input disabled='disabled' style='background:#EFEFEF' class='Texto' type='text' name='nome' value='{$nome}' size='45' maxlength='80'><br>";
    echo "   <td class='table_contato_celula_value'>{$nomew}</td> ";
    echo "</tr>";

    echo "<tr class='table_contato_linha'> ";
    $emaillabelw = "<label for='email' >Seu e-mail<span>*</span>:&nbsp;</label>";
    echo "   <td class='table_contato_celula_label'>{$emaillabelw}</td> ";
    $emailw = "<input disabled='disabled' style='background:#EFEFEF' class='Texto' type='text' name='email' value='{$email}' size='45' maxlength='80' onblur='Valida_Email(email)'><br>";
    echo "   <td class='table_contato_celula_value'>{$emailw}</td> ";
    echo "</tr>";

    echo "<tr class='table_contato_linha'> ";
    $senha_atualw = "<label for='senha_atual' >Senha Atual<span>*</span>:&nbsp;</label>";
    echo "   <td class='table_contato_celula_label'>{$senha_atualw}</td> ";
    $senha_atualw = "<input class='Texto' type='password' name='senha_atual' value='{$senha_atual}' maxlength='45' size='45' onblur='return true;' onkeyup='return true;' )'><br>";
    echo "   <td class='table_contato_celula_value'>{$senha_atualw}</td> ";
    echo "</tr>";

    echo "<tr class='table_contato_linha'> ";
    $senha_novaw = "<label for='senha_atual' >Senha Nova<span>*</span>:&nbsp;</label>";
    echo "   <td class='table_contato_celula_label'>{$senha_novaw}</td> ";
    $senha_novaw = "<input class='Texto' type='password' name='senha_nova' value='{$senha_nova}' maxlength='45' size='45' onblur='return true;' onkeyup='return true;' )'><br>";
    echo "   <td class='table_contato_celula_value'>{$senha_novaw}</td> ";
    echo "</tr>";

    echo "<tr class='table_contato_linha'> ";
    $senha_nova_repetew = "<label for='senha_atual' >Senha Nova repetida<span>*</span>:&nbsp;</label>";
    echo "   <td class='table_contato_celula_label'>{$senha_nova_repetew}</td> ";
    $senha_nova_repetew = "<input class='Texto' type='password' name='senha_nova_repete' value='{$senha_nova_repete}' maxlength='45' size='45' onblur='return true;' onkeyup='return true;' )'><br>";
    echo "   <td class='table_contato_celula_value'>{$senha_nova_repetew}</td> ";
    echo "</tr>";

    echo "</table >";

    echo "<table class='table_contato' width='100%' border='0' cellspacing='4' cellpadding='4' vspace='0' hspace='0'> ";


    $btconfirma = "<input type='submit' name='btnAcao' value='Confirmar' onClick='valida = ".'"'."S".'"'."' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'/>";
//$btdesiste  = "<input type='button' value='Desistir' name='btdesiste' id='btdesiste' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='desiste_altera_faleconosco();'  />";
    $btretorna = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='sai_altera_senha();'  />";


// $menu = 'homeobra';
// $Require_Once = "$prefixo$menu.php";

    echo "<tr class='table_contato_linha'> ";
    $msgrodapeobrigatoriow = '( * ) campo obrigatório';
    echo "   <td class='table_contato_celula_msgrodape' >{$msgrodapeobrigatoriow}</td> ";
    echo "</tr>";

    echo "<tr class='table_contato_linha'> ";
    echo "   <td class='table_contato_celula_btconfirmar' >{$btconfirma}{$btdesiste}{$btretorna}</td> ";
//echo "   <td class='table_contato_celula_btdesistir'>{$btdesiste}</td> ";
    echo "</tr>";
} else {
    $btretorna = "<input type='button' value='Retornar' name='btretornar' id='btretornar' style='width:150px; height:25px; margin-left:10px; cursor: pointer;'  onclick='sai_altera_senha();'  />";

    echo "<tr class='table_contato_linha'> ";
    echo "   <td class='table_contato_celula_btconfirmar' >{$btretorna}</td> ";
//echo "   <td class='table_contato_celula_btdesistir'>{$btdesiste}</td> ";
    echo "</tr>";
}
echo "</table >";

//echo "</fieldset>";


echo "</form>";

echo "</div>";
?>

