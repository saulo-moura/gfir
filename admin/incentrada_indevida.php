<?php
Require_Once('configuracao.php');
unset($_SESSION[CS]);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $nome_site ?></title>
        <script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
        <style type="text/css">

            div#conteudo {
                width:1000px;
            }
            div#agradecimento {
                padding:0px;
                margin:0px;
                margin-left:60px;
                width:1000px;
                height:350px;
                sborder:1px solid red;
                margin-top:40px;
                background: url(imagens/home_obra_indevido.jpg) center top no-repeat #FFFFFF;

            }

            div#agradecimento_texto {
                padding:0px;
                margin:0px;
                margin-left:60px;
                width:1000px;
                height:30px;
                font-family : Calibri, Arial, Helvetica, sans-serif;
                font-size   : 18px;
                font-style  : normal;
                font-weight : bold;
                color       : #C40000;

                color       : #A2A2A2;


                sborder:1px solid red;
                text-align:center;
                background: #FFFFFF;
                padding-top:10px;
            }

            div#agradecimento_texto a {
                text-decoration:none;

            }

        </style>
        <script type="text/javascript">
            $(document).ready(function () {
                if ($.isFunction(top.muda_frame)) {
                    top.muda_frame(true);
                }
                top.close();
            });
        </script>
    </head>
    <body id="body">
        <div id='agradecimento'>
        </div>
        <div id='agradecimento_texto'>
            Para acesso ao Gerenciador de Conteúdo favor entrar no Site <br/>e informar o Usuário e a Senha de acesso.<br/>Obrigado.  <br /><br />
            <a href="../"  title="Clique aqui para Retornar ao Site" >Clique aqui para ENTRAR ao Site</a>
        </div>
    </body>
</html>

