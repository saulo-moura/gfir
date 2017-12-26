<?php
Require_Once('configuracao.php');

$de_replay = $vetConf['email_site'];
$de_email = $vetConf['email_envio'];
$de_nome = $vetConf['email_nome'];

if ($de_email == '') {
	$de_email = $de_replay;
}

require_once(lib_phpmailer . 'PHPMailerAutoload.php');

//Create a new PHPMailer instance
$mail = new PHPMailer;

$mail->SetLanguage('br', lib_phpmailer);

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';

$mail->IsSMTP();
$mail->Host = $vetConf['host_smtp'];
$mail->Port = $vetConf['port_smtp'];
$mail->Username = $vetConf['login_smtp'];
$mail->Password = $vetConf['senha_smtp'];
$mail->SMTPAuth = !($vetConf['login_smtp'] == '' && $vetConf['senha_smtp'] == '');
$mail->SMTPSecure = $vetConf['smtp_secure'];
$mail->setFrom($de_email, $de_nome);
$mail->AddReplyTo($de_replay, $de_nome);

$mail->Subject = 'Teste e-mail - '.date('Ymd').'_'.(date('H') - date('I')).date('i').date('s');
$mail->msgHTML('Sebrae  '.date('Ymd').'_'.(date('H') - date('I')).date('i').date('s'));

$mail->AddAddress('esmeraldosousa@gmail.com');
$mail->AddAddress('emanuel.santos@ba.sebrae.com.br');
$mail->AddAddress('diego.queiroz@ba.sebrae.com.br');

var_dump($mail->Send());
p($mail);
