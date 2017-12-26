<?php
define('conteudo_abrir_sistema', 'S');

Require_Once('configuracao.php');

if ($_REQUEST['menu'] == '')
    $menu = 'vazio';
else
    $menu = $_REQUEST['menu'];

if ($_REQUEST['prefixo'] == '')
    $prefixo = 'inc';
else
    $prefixo = $_REQUEST['prefixo'];

$acao = mb_strtolower($_REQUEST['acao']);
$_SESSION[CS]['g_nom_tela'] = $vetMenu[$menu];
$cont_arq = '_abrir_sistema';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
        <script type="text/javascript">
            var returnVal = '';
            postMessageAcao = true;

            $(document).ready(function () {
                MenuPodeUsar = true;
                ativaObj();

                if ($.isFunction(self.onLoadPag)) {
                    onLoadPag();
                }

                if (prefixo == 'janela_sistema') {
                    var left = 0;
                    var top = 0;
                    var height = screen.availHeight - 80;
                    var width = screen.availWidth - 30;
                    var link = menu + '.php';

                    link_p = window.open(link, "Matriz", "left=" + left + ",top=" + top + ",width=" + width + ",height=" + height + ",resizable=yes,menubar=no,scrollbars=yes,toolbar=no");
                    link_p.focus();

                    parent.window.history.go(-1);
                }
            });

            // Create IE + others compatible event handler
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

            // Listen to message from child window
            eventer(messageEvent, function (e) {
                var height = parseInt(e.data) + 12;
                $('#abrir_sistema').height(height);
                
                parent.postMessage($('#geral_cadastro').outerHeight(true), postMessageUrl);
            }, false);
        </script>
    </head>
    <body>
        <div id="geral_cadastro" class="showPopWin_width">
            <div id="dtBanco" style="display: none;"><?php echo date("d/n/Y") ?></div>
            <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
            <div id="conteudo_cadastro">
                <?php
                if ($prefixo != 'janela_sistema') {
                    if ($_SESSION[CS]['g_id_usuario'] == '') {
                        $msg = 'timeout do sistema';
                        $tipo = 'timeout';
                        $inf_extra = Array(
                        );
                        erro_try($msg, $tipo, $inf_extra);

                        echo "<div align='center' class='Msg'>Favor entrar no sistema outra vez!</div>";
                    } else {
                        if ($prefixo == 'listar' || $prefixo == 'listar_rel' || $prefixo == 'listar_cmb' || $prefixo == 'listar_cmbmulti')
                            $Require_Once = "listar.php";
                        else if ($prefixo == 'cadastro')
                            $Require_Once = "cadastro.php";
                        else if ($prefixo == 'relatorio')
                            $Require_Once = "relatorio/$menu.php";
                        else
                            $Require_Once = "$prefixo$menu.php";

                        if ($vetFuncaoSistema[$menu] != '') {
                            $Require_Once = "abrir_sistema_chama.php";
                        }

                        if (file_exists($Require_Once)) {
                            bt_volta_painel('top');

                            if ($_SESSION[CS]['painel_passo'][$menu] != '') {
                                if ($_GET['origem_tela'] == 'menu') {
                                    unset($_SESSION[CS]['painel_passo'][$menu]);
                                } else {
                                    $codigo_painel_passo = 'S';
                                    require_once $_SESSION[CS]['painel_passo'][$menu];
                                }
                            }

                            Require_Once($Require_Once);

                            bt_volta_painel('rod');
                        } else {
                            echo "<script type='text/javascript'>self.location = 'index.php';</script>";
                            exit();
                        }
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
