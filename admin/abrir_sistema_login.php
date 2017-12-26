<?php
define('conteudo_abrir_sistema', 'S');

Require_Once('configuracao.php');

$str = base64_decode($_POST['dados']);
$str = substr($str, 10, strlen($str) - 20);
$str = base64_decode($str);
$dados = unserialize($str);

if ($dados['login'] == '') {
    $_SESSION[CS]['g_id_usuario'] = 'x';
}

$msg = '';

if ($_SESSION[CS]['g_login'] != $dados['login']) {
    $_POST['login'] = $dados['login'];
    $_POST['senha'] = $dados['senha'];

    $pdca = 'S';
    $_GET['tipo'] = 'login';

    $msg = Require_Once('ajax2.php');
}

if ($msg != '') {
    echo '<script type="text/javascript">alert("'.$msg.'".replace(/<br>/gi, "\n"));</script>';
} else {
    $post_url = parse_url($_SERVER['HTTP_REFERER']);
    $str = $post_url['path'];
    $str = str_replace('admin/conteudo_abrir_sistema.php', '', $str);
    $str = str_replace('conteudo.php', '', $str);
    $str = mb_strtolower('http://'.$post_url['host'].($post_url['port'] == '' ? '' : ':'.$post_url['port'])).$str;
    
    $_SESSION[CS]['g_abrir_sistema'] = $dados['externo'];
    $_SESSION[CS]['g_abrir_sistema_origem'] = $dados['origem'];
    $_SESSION[CS]['g_abrir_sistema_url'] = $str;
    $_SESSION[CS]['g_popup'] = 'S';

    $_GET = $dados['get'];

    echo "<script type='text/javascript'>self.location = 'conteudo_abrir_sistema.php?prefixo={$dados['prefixo']}&menu={$dados['menu']}".getParametro('prefixo,menu', false)."';</script>";
}