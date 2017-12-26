<?php
$tabela = 'usuario';
$id = 'id_usuario';
$acao = 'alt';
$botao_volta = "self.location = 'conteudo.php'";
$botao_acao = "<script>self.location = 'conteudo.php';</script>";

$_GET['id'] = $_SESSION[CS]['g_id_usuario'];

if ($_GET['id'] == '') {
    echo '
        <script>
            alert("Favor utilizar o Sistema de Login!!!");
            top.location = "index.php";
        </script>
    ';
    exit();
}

$vetCampo['nome_completo'] = objTextoFixo('nome_completo', 'Nome Completo', 50, True);
$vetCampo['login'] = objTextoFixo('login', 'Login', 30, True);
$vetCampo['atual'] = objSenha('atual', 'Senha Atutal', True, 50, '', '', false);
$vetCampo['senha'] = objSenha('senha', 'Senha Nova', True, 50);
$vetCampo['confirmacao'] = objSenha('confirmacao', 'Confirmação da Senha', True, 50, '', '', false);

$vetFrm = Array();
$vetFrm[] = Frame('', Array(
    Array($vetCampo['nome_completo']),
    Array($vetCampo['login']),
    Array($vetCampo['atual']),
    Array($vetCampo['senha']),
    Array($vetCampo['confirmacao']),
));
$vetCad[] = $vetFrm;
?>