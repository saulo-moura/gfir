<?php
if ($_POST['login'] != '' && $_POST['senha'] != '') {
//    if (substr(mb_strtolower(trim($_POST['login'])), -23, 23) != '@oasempreendimentos.com')
//        $_POST['login'] .= '@oasempreendimentos.com';

    $sql = "select * from {$pre_table}usuario where login = ".aspa($_POST['login'])." and senha = ".aspa(md5($_POST['senha']));
    $result = execsql($sql);
    $row = $result->data[0];

    if ($result->rows == 0) {
        echo "<script type='text/javascript'>alert('Usuário e/ou senha inválidos.\\n\\nTente de novo.');</script>";
    } else if ($row['ativo'] == 'N') {
        echo "<script type='text/javascript'>alert('Usuário não esta ativo!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
//    } else if ($row['ativo_pir'] == 'N') {
  //      echo "<script type='text/javascript'>alert('Usuário não esta ativo no sistema PIR!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
    } else if (trata_data(getdata(false, true)) > $row['dt_validade'] && $row['dt_validade'] != '') {
        echo "<script type='text/javascript'>alert('O seu acesso expirou em ".trata_data($row['dt_validade'])."!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
    } else if (trata_data(getdata(false, true)) < $row['dt_validade_inicio'] && $row['dt_validade_inicio'] != '') {
        echo "<script type='text/javascript'>alert('O seu acesso só vai esta liberado em ".trata_data($row['dt_validade_inicio'])."!\\nPara maiores informações\\nprocurar o Administrador do sistema.');</script>";
    } else {
        $_SESSION[CS]['alt_status_produto'] = $row['alt_status_produto'];
        $_SESSION[CS]['g_id_usuario'] = $row['id_usuario'];
        $_SESSION[CS]['g_login'] = $row['login'];
                $_SESSION[CS]['g_s_slv'] = $_POST['senha'];
        $_SESSION[CS]['g_nome_completo'] = $row['nome_completo'];
        $_SESSION[CS]['g_email'] = $row['email'];
        $_SESSION[CS]['g_senha_antiga'] = $row['senha'];
        $_SESSION[CS]['g_id_perfil'] = $row['id_perfil'];
        $_SESSION[CS]['g_id_site_perfil'] = $row['id_site_perfil'];
        $_SESSION[CS]['g_idt_pessoa'] = $row['idt_pessoa'];
                $_SESSION[CS]['g_mostra_menu'] = $row['mostra_menu'];

        $par = '';
        if ($_SESSION[CS]['g_senha_antiga'] == md5($vetConf['senha_padrao'])) {
            $par = 'prefixo=cadastro&menu=senha';
            echo "<script type='text/javascript'>alert('Sr(a) ".$row['nome_completo'].",\\n\\nVocê esta utilizando a senha padrão do sistema.\\nFavor alterar a senha por uma questão de segurança.');</script>";
        } elseif ($_POST['tipo'] == 'S') {
            $par = 'prefixo=cadastro&menu=senha';
        }

        echo "<script type='text/javascript'>$target_js.location = 'conteudo.php?".$par."';</script>";
        exit();
    }
}

unset($_SESSION[CS]);

$varCampos = array("frm",
    "login", "Usuário",
    "senha", "Senha"
);


camposObrigatorios($varCampos, False);
?>
<script type="text/javascript" >
    valida = 'S';

    function loga(t) {
        if (frmFcn()) {
            document.frm.tipo.value = t;
            document.frm.submit();
        }
    }

    function Enter(teclapres) {
        if (teclapres.keyCode == 13)
            if (frmFcn())
                document.frm.submit();
    }
</script>


<form id="frm" name="frm" target="_self" action="conteudo.php?<?php echo substr(getParametro('login,senha'), 1) ?>" method="post" onSubmit="return frmFcn()">
    <input type="hidden" name="tipo">
    <div class="Login">
        Usuário:
        <input class="Texto" type="text" value="" name="login" onkeyup='Enter(event)'>
    </div>
    <div class="Senha">
        Senha:
        <input class="Texto" type="password" value="" name="senha" onkeyup='Enter(event)'>
    </div>
    <img alt="" class="BtSenha" onclick="loga('S');" src="imagens/trans.gif" border="0">
    <img alt="" class="BtEnter" onclick="loga('N');" src="imagens/trans.gif" border="0">
</form>
<?php
onLoadPag("login");
?>