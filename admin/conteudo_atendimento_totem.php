<?php
Require_Once('configuracao.php');

//$_SESSION[CS]['sem_menu']='S';
if ($_REQUEST['menu'] == '')
    $menu = 'vazio';
else
    $menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];


if ($_REQUEST['titulo_rel'] == '')
    $nome_titulo = '';
else
    $nome_titulo = $_REQUEST['titulo_rel'];

if ($_REQUEST['origem'] == '')
    $origem = '';
else
    $origem = $_REQUEST['origem'];
$nome_cabecalho = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $nome_titulo.' - '.$nome_site ?></title>
        <style type="text/css" media="all">
            Table.sMenu_print {
                font-family: Arial, Helvetica, sans-serif;
                font-style: normal;
                font-weight: bold;
                color: Black;
                word-spacing: 0px;
                width: 100%;
                border: 1px solid Black;
                display: inline;
            }
            Table.Menu_print_e {
                background:#FFFFFF;
                width: 100%;

            }
            div#barra_topo_m {
                background:#004080;
                width: 100%;
                height:30px;
                display:block;
                margin-bottom:4px;
                color:#FFFFFF;
                font-family: Calibri, Arial, Helvetica, sans-serif;
                font-size: 12px;
                font-style: normal;
                font-weight: bold;
            }
            div#retornar {
                float:left;
                padding-left:5px;
                padding-top:2px;
                height:30px;
            }
            div#retornar a {
                font-family: Calibri, Arial, Helvetica, sans-serif;
                font-size: 14px;
                font-style: normal;
                font-weight: bold;
                color:#FFFFFF;
                text-decoration:none;
            }

            div#usuario_m {
                float:left;
                padding-left:30px;
                padding-top:5px;
            }
            div#resto_m {
                float:right;
                padding-right:30px;
                padding-top:5px;
            }
            div#titulo_modulo_X {
                background:#2F2FFF;
                color:#FFFFFF;
                font-size:30px;
                width:100%;
                background: -moz-linear-gradient(top, #2F2FFF 0%, #6FB7FF 50%, #DFDFFF 100%); /* FF3.6+ */
                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff0000), color-stop(35%,#6FB7FF), color-stop(100%,#DFDFFF)); /* Chrome,Safari4+ */
                background: -webkit-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Chrome10+,Safari5.1+ */
                background: -o-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* Opera 11.10+ */
                background: -ms-linear-gradient(top, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* IE10+ */
                background: linear-gradient(to bottom, #2F2FFF 0%,#6FB7FF 50%,#DFDFFF 100%); /* W3C */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2F2FFF', endColorstr='#6FB7FF',GradientType=0 ); /* IE6-9 */
                border: 1px solid thick #c00000;
                border-radius: 1em;
                border:1px solid  #0000A0;
            }

            div#titulo_modulo {
                background:#8080FF;
                color:#FFFFFF;
                font-size:30px;
                width:100%;
                border:1px solid  #0000A0;
            }
            div#ele_topo {
                float:left;
                xpadding-left:10px;
                xpadding-right:10px;
                padding:5px;
                border-right:1px solid #FFFFFF;
                font-size:14px;
                height:30px;
            }
            div#div_topo {
                padding:0px;
                margin:0px;
                width: 100%;
            }
            .ctopo {
                width: 100%;
                background: #FFFFFF;
                text-align: center;
                padding: 0px;
                padding-top: 8px;
                height: 24px;
            }
            .ctopo a {
                color: #d2d2d2;
                margin: 0px 5px;
                font-size:12px;
            }
            .ctopo a.intranet {
                color: white;
                font-weight: bold;
            }
            div#hora_m {
                color:#000000;
            }


            div#Meio {
                width:100%;
            }


        </style>
        <?php
        Require_Once('head.php');
//echo "<script>var reduz_cron='N';</script>";

        if ($_GET['cod'] != '') {
            //
            // Entrou pelo totem - fazer login especial

            if ($_SESSION[CS]['g_login'] != $_GET['cod']) {
                $_GET['tipo'] = "login";
                $_POST['login'] = $_GET['cod'];
                $_POST['senha'] = "1";

                Require_Once('ajax2.php');
            }

            //p($_SESSION);
        }

        if ($_SESSION[CS]['g_id_usuario'] == '') {
            echo 'Entrada indevida... ';
            echo ' <script type="text/javascript" language="JavaScript1.2">';
            echo "    self.location = 'incentrada_indevida.php';";
            echo ' </script> ';
            exit();
        }
        echo '</head>';
        echo '<body style="background:#FFFFFF; ">';


//p($_REQUEST);

        echo '<div class="Meio" id="Meio">';
            
        if ($_SESSION[CS]['g_idt_unidade_regional'] == '') {
            alert('Usuário não tem Ponto de Atendimento informado! Favor informar para continuar com a operação.');
        } else {
            $idt_atendimento_painel = $_GET['idt_atendimento_painel'];
            $idt_atendimento_painel = idtAtendimentoPainel();
            $_SESSION[CS]['g_ordem_painel'] = 0;
            $_SESSION[CS]['g_ordem_msg_painel'] = 0;


            //p($_SESSION[CS]);
			//die();

            $prefixo = "inc";
            $menu = "atendimento_totem";
            $Require_Once = "$prefixo$menu.php";

            //echo " esse ta ".$Require_Once;
            //exit();


            if (file_exists($Require_Once)) {
                //echo " chamando ta ".$Require_Once;
                Require_Once($Require_Once);
            } else {
                exit();
            }
        }
        
        echo '</div>';
        echo '</body>';
        echo '</html>';