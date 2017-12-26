<?php
Require_Once('configuracao.php');

$cod = base64_decode($_GET['cod']);
$cod = substr($cod, 10, strlen($cod) - 20);

$msg = '';

$sql = "select id_usuario, login, nome_completo, email from plu_usuario where md5(id_usuario) = ".aspa($cod);
$result = execsql($sql);
$row = $result->data[0];

if ($result->rows == 0) {
    $msg = "Usuário não esta registrado no sistema!";
} else if ($row['email'] == '') {
    $msg = "Este usuário não tem email cadastrado! Por isso não podemos enviar uma nova senha.\\n\\nFavor entrar em contado com o administrador do sistema";
} else {
    $senha = GerarStr(5);

    WSsincronizarSenha($row['login'], md5($senha));

    $Body = '';
    $Body .= 'Prezado '.$row['nome_completo'].',<br /><br />';
    $Body .= 'Conforme solicitado, segue a nova senha de acesso ao sistema.<br /><br />';
    $Body .= 'A senha é <b>'.$senha.'</b>';

    $assunto = "[{$sigla_site}] Nova senha do sistema";

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
            $msg = "A nova senha foi enviada para o email: ".mb_strtoupper(trunca_email($row['email']));
        } else {
            $msg = "Erro na transmissão.\\nTente outra vez!\\n\\n".trata_aspa($mail->ErrorInfo);
        }
    } catch (Exception $e) {
        $msg = 'O Sistema encontrou problemas para enviar seu e-mail. '.$e->getMessage();
    }
}

echo "<script type='text/javascript'>alert('{$msg}');</script>";
echo "<script type='text/javascript'>top.location = '../index.php';</script>";
