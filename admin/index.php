<?php
Require_Once('configuracao.php');

if ($debug)
{
    Require_Once('conteudo.php');
}
else
{
     Require_Once('conteudo.php');
    

    /*
    echo '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>'.$nome_site.'</title>
        <link rel="shortcut icon" href="imagens/favicon.ico" />
        <script language="JavaScript" src="js/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script language="JavaScript" src="js/funcao.js" type="text/javascript"></script>
        <script type="text/javascript">
        function muda_frame(on) {
            if (on)
                $("#frameset").attr("rows", "0,*");
            else
                $("#frameset").attr("rows", "*,0");
        }
        </script>
        </head>
        <frameset id="frameset" rows="*,0" frameborder="no" border="0" framespacing="0" onunload=\'OpenWin("logout.php", "logout", 100, 100, -200, -200)\'>
            <frame src="carregando.php" noresize="noresize" scrolling="no">
            <frame name="conteudo" src="conteudo.php" noresize="noresize" scrolling="yes">
        </frameset>
        <noframes>
            <body>Favor atualizar o navegador para uma versão mais nova!</body>
        </noframes>
        </html>
    ';
    */
}


?>
