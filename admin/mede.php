<?php
$nome_site = "PA";
$externo   = "S";

$_GET['cpf']              = "061846425-53";
$_GET['cnpj']             = "04.848.154/0001-99";
$_GET['codigo_formulario']= "650";
$_GET['data_avaliacao']   = "09/04/2017";
$_GET['titulo_avaliacao'] = "Avaliação inicial de Luiz pereira";


/*
$titulo_avaliacao         = $_GET['titulo_avaliacao'];
$data_avaliacao           = $_GET['data_avaliacao'];
$protocolo                = $_GET['protocolo'];
$cpf                      = $_GET['cpf'];
$idt_avaliacao            = $_GET['idt_avaliacao'];
$cnpj                     = $_GET['cnpj'];
$idt_organizacao_avaliado = $_GET['idt_organizacao_avaliado'];
$observacao               = $_GET['observacao'];
$codigo_formulario        = $_GET['codigo_formulario'];
$idt_formulario           = $_GET['idt_formulario'];
$usuario_responsavel      = $_GET['usuario_responsavel'];
*/
$debug=false;
if ($debug)
{
    Require_Once('conteudo_pa_mede.php');
}
else
{
    Require_Once('conteudo_pa_mede.php');
/*
    $nome_site = "PA";
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
        <frameset id="frameset" rows="50%" frameborder="no" border="0" framespacing="0" onunload=\'OpenWin("../../admin/logout.php", "logout", 100, 100, -200, -200)\'>
            <frame name="conteudo" src="../../admin/conteudo_pa_mede.php" noresize="noresize" scrolling="yes">
        </frameset>
        <noframes>
            <body>Navegador não compatível com a utilização de Frames!</body>
        </noframes>
        </html>
    ';
*/	
	
}


?>
