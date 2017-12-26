<?php
Require_Once('configuracao.php');

$str = base64_decode($_POST['dados']);
$str = substr($str, 10, strlen($str) - 20);
$str = base64_decode($str);
$dados = unserialize($str);

$_POST['login'] = $dados['login'];
$_POST['senha'] = $dados['senha'];

$pdca = 'S';
$_GET['tipo'] = 'login';

$msg = Require_Once('ajax2.php');

if ($msg != '') {
    echo '<script type="text/javascript">alert("'.$msg.'".replace(/<br>/gi, "\n"));</script>';
}

echo '<script type="text/javascript">self.location = "conteudo.php";</script>';