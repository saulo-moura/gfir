<style type="text/css">
    div.novo {
        padding-top: 10px;
        margin-left: 632px;
        font-size: 12px;
        line-height: 20px;
        width: 148px;
        height: 61px;
    }

    div.Login {
        padding-left : 564px;
        padding-top  : 98px;
    }

    div.Senha {
        padding-left : 564px;
        padding-top  : 47px;
        margin-bottom: 15px;
    }

    div#login_dados{
        text-align: left;
        background: url(imagens/fundo_login.jpg) no-repeat;
        font-family: Arial,Helvetica,sans-serif;
        font-size: 11px;
        height: 408px;
    }

    div.Login input, div.Senha input {
        width: 284px;
        border: 0px solid white;
        height: 23px;
        background-color: white;
    }

    div#botoes {
        margin-left: 564px;
    }

    div#botoes a{
        color: #7b7b7b;
        text-decoration: none;
    }

    .BtSenha {
        cursor: pointer;
        margin-left : 58px;
        margin-top : 6px;

        border: none;
        height: auto;
        width: auto;
    }

    .ie .BtSenha {
        margin-top : 8px;
    }

    .BtEsqueci {
        cursor: pointer;
        margin-left : 0px;
        margin-top : 500px;
    }

    .ie .BtEsqueci {
        margin-top : 18px;
    }

    .BtEnter {
        cursor: pointer;
        margin-left: 632px;
        margin-top: 30px;
        width: 148px;
        height: 61px;
    }

    .ie .BtEnter {
        margin-top : 16px;
    }

    div.Site_inscricao {
        width: 98%;
        border: 0px solid white;
        height: 400px;
        background-color: transparent;
        border:1px solid red;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('div.Login input:first').focus();
    });
</script>
<center>
    <div id="login_dados">
        <div class="novo">
	    <!--
            <a href='conteudo_iniciar_inscricao.php' target='_blank' >
                <img title="Possibilita a solicitação de Login (Usuário e Senha) para ter acesso ao Portal" id="login_b_novo" src="imagens/novo.png" border="0"/>
            </a>
            -->
        </div>
        <div class="Login">
            <input class="Texto" type="text" value="" name="login" >
        </div>
        <div class="Senha">
            <input class="Texto" type="password" value="" name="senha" >
        </div>
        <div id="botoes">
            <a class="BtEsqueci" id="login_b_esqueci_senha">Esqueci minha senha</a>
            <a class="BtSenha" id="login_b_alterar_senha">Quero alterar minha senha</a>
        </div>
        <img alt="" class="BtEnter" id="login_b_entrar" src="imagens/enter.png" border="0"/>
    </div>
</center>
