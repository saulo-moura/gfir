<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
if ($_REQUEST['cas'] == '') {
    $_REQUEST['cas'] = 'conteudo_abrir_sistema';
}
define('conteudo_abrir_sistema', $_REQUEST['cas']);

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
$cont_arq = '_listarcmb';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php Require_Once('head.php'); ?>
        <script type="text/javascript">
            var returnVal = '';

            $(document).ready(function () {
                MenuPodeUsar = true;
                ativaObj();

                if ($.isFunction(self.onLoadPag)) {
                    onLoadPag();
                }

                new ResizeSensor($('#conteudo_cadastro'), function () {
                    aviso_frm_tam();
                });
                
                aviso_frm_tam();
            });

            function aviso_frm_tam() {
                var data = '{"iframe_name":"<?php echo $_GET['iframe_name']; ?>", "height":"' + $('#geral_cadastro').height() + '"}';
                parent.postMessage(data, postMessageUrl);

            }
        </script>
        <script language="JavaScript" src="js/ResizeSensor.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="geral_cadastro" class="showPopWin_width">
            <div id="dtBanco" style="display: none;"><?php echo date("d/n/Y") ?></div>
            <input type="hidden" id="dtBancoObj" value="<?php echo date("d/m/Y"); ?>" />
            <div id="conteudo_cadastro">
                <?php
                Require_Once('cadastro.php');
                ?>
            </div>
        </div>
    </body>
</html>
