<?php
acesso($menu, '', true, false);

$url = str_replace('localhost', $_SERVER['HTTP_HOST'], $vetFuncaoSistema[$menu]);
$url .= '/abrir_sistema_login.php';

$dados = Array(
    'login' => $_SESSION[CS]['g_login'],
    'senha' => $_SESSION[CS]['g_s_slv'],
    'prefixo' => $prefixo,
    'menu' => $menu,
    'externo' => 'E',
    'origem' => $plu_sigla_interna,
    'get' => $_GET,
);

$dados = serialize($dados);
$dados = base64_encode($dados);
$dados = base64_encode(GerarStr().$dados.GerarStr());
?>
<style type="text/css">
    span#carregando {
        display: block;
        position: relative;
        padding: 20px;
        padding-left: 273px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        if ($.isFunction(self.TelaHeight)) {
            TelaHeight();
        }

        frm.submit();
    });

    function tira_aviso() {
        $('#carregando').hide();
    }

    // Create IE + others compatible event handler
    var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
    var eventer = window[eventMethod];
    var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";

    // Listen to message from child window
    eventer(messageEvent, function (e) {
        var height = parseInt(e.data) + 12;
        $('#abrir_sistema').height(height);
        TelaHeight();
    }, false);
</script>
<span id="carregando"><img src="imagens/ajax-loader.gif" />Aguarde, processando...</span>
<iframe src="" id="abrir_sistema" name="abrir_sistema" width="100%" height="100%" scrolling="auto" frameborder="0" onload="tira_aviso()"></iframe>
<form method="post" action="<?php echo $url; ?>" target="abrir_sistema" name="frm" id="frm">
    <input type="hidden" name="dados" value="<?php echo $dados; ?>">
</form>
