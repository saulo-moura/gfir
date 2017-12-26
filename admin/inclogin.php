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
        padding-left : 678px;
        padding-top  : 98px;
    }

    div.Senha {
        padding-left : 678px;
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
        width: 280px;
        border: 0px solid white;
        height: 23px;
        background-color: white;
        outline: none;
    }

    div#botoes {
        margin-left: 684px;
    }

    div#botoes a{
        color: white;
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
        margin-left: 752px;
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

    @media (max-width: 999px) {
        div#login_dados{
            text-align: left;
            background: url(imagens/fundo_login_p.jpg) no-repeat top right;
            font-family: Arial,Helvetica,sans-serif;
            font-size: 11px;
            height: 408px;
            width: 340px;
        }

        div.novo {
            display: none;
        }

        div.Login {
            padding-left: 20px;
            padding-top: 92px;
        }

        div.Senha {
            margin-bottom: 15px;
            padding-left: 20px;
            padding-top: 48px;
        }

        div#botoes {
            margin-left: 20px;
        }

        .BtEnter {
            cursor: pointer;
            height: 61px;
            margin-left: 90px;
            margin-top: 30px;
            width: 148px;
        }
		
		.BtSenha {
			margin-left : 40px;
		}
}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('div.Login input:first').focus();

        $('#login_b_entrar').click(function () {
            var login = $('#login_dados [name="login"]');
            var senha = $('#login_dados [name="senha"]');

            if (login.val() == '') {
                alert('Favor informar o Usuário!');
                login.focus();
                return false;
            }

            if (senha.val() == '') {
                alert('Favor informar a Senha!');
                senha.focus();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: 'ajax2.php?tipo=login',
                data: {
                    login: url_encode(login.val()),
                    senha: url_encode(senha.val())
                },
                beforeSend: function () {
                    processando();
                },
                complete: function () {
                    $("#dialog-processando").remove();
                },
                success: function (response) {
                    $('#login_dados input').val('');

                    if (response == '') {
                        self.location = 'conteudo.php';
                    } else {
                        $("#dialog-processando").remove();
                        alert(url_decode(response).replace(/<br>/gi, "\n"));
                        login.focus();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();
                    alert('Houve um problema na hora de fazer a verificação do usuário!\nFavor tentar outra vez.');
                },
                async: false
            });
        });

        $('#login_dados input').keyup(function (event) {
            if (event.keyCode == 13) {
                $('#login_b_entrar').click();
            }
        });


        $('#login_b_alterar_senha').click(function () {
            var login = $('#login_dados [name="login"]');
            var senha = $('#login_dados [name="senha"]');

            if (login.val() == '') {
                alert('Favor informar o Usuário!');
                login.focus();
                return false;
            }

            if (senha.val() == '') {
                alert('Favor informar a Senha!');
                senha.focus();
                return false;
            }

            $.post('ajax2.php?tipo=alterar_senha', {
                login: url_encode(login.val()),
                senha: url_encode(senha.val())
            }, function (str) {
                if (str == '') {
                    $('#login_dados input').val('');
                    self.location = 'conteudo.php';
                } else {
                    $('#login_dados input').val('');
                    alert(url_decode(str).replace(/<br>/gi, "\n"));
                    self.location = 'conteudo.php';

                }
            });
        });

        $('#login_b_esqueci_senha').click(function () {
            var login = $('#login_dados [name="login"]');

            if (login.val() == '') {
                alert('Favor informar o Usuário!');
                login.focus();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: 'ajax.php?tipo=esqueci_senha',
                data: {
                    login: login.val()
                },
                beforeSend: function () {
                    processando();
                },
                complete: function () {
                    $("#dialog-processando").remove();
                },
                success: function (str) {
                    $("#dialog-processando").remove();

                    if (str != '') {
                        alert(url_decode(str));
                    }

                    $('#login_dados input').val('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#dialog-processando").remove();

                    alert('Erro no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        });
    });
</script>
<center>
    <div id="login_dados">
        <div class="novo">
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
